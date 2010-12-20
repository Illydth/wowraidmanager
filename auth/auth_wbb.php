<?php
/***************************************************************************
 *                             auth_wbb.php
 *                            -------------------
 *   begin                : July 22, 2008
 *	 Dev                  : Carsten Hölbing
 *	 email                : hoelbin@gmx.de
 *
 *	 based on 			  : auth_e107.php @ Douglas Wagner
 *   copyright            : (C) 2007-2008 Douglas Wagner
 *   email                : douglasw0@yahoo.com
 *
 ***************************************************************************/

/***************************************************************************
*
*    WoW Raid Manager - Raid Management Software for World of Warcraft
*    Copyright (C) 2007-2008 Douglas Wagner
*
*    This program is free software: you can redistribute it and/or modify
*    it under the terms of the GNU General Public License as published by
*    the Free Software Foundation, either version 3 of the License, or
*    (at your option) any later version.
*
*    This program is distributed in the hope that it will be useful,
*    but WITHOUT ANY WARRANTY; without even the implied warranty of
*    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*    GNU General Public License for more details.
*
*    You should have received a copy of the GNU General Public License
*    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*
****************************************************************************/

/********************************************************************************
 * For WBB, to create a password we use sha1 several times over.  We need to get the value of a set of
 * WBB parameters and then mangle the password in the same way they do.
 * 
 * The Parameters are:
 * define('ENCRYPTION_ENABLE_SALTING', 1);
 * define('ENCRYPTION_ENCRYPT_BEFORE_SALTING', 1);
 * define('ENCRYPTION_METHOD', 'sha1');
 * define('ENCRYPTION_SALT_POSITION', 'before');
 * 
 * For "ENCRYPTION_SALT_POSITION = before", the final password algorithm is:
 * $salt = Salt Value From DB Table (random 40 character salt)
 * $oldpassword = Current Value of Password (or new password if changing the pwd).
 * $password = sha1($salt.sha1($salt.sha1($oldpassword)));
 * 
 * For "ENCRYPTION_SALT_POSITION = after", the final password algorithm is:
 * $salt = Salt Value From DB Table (random 40 character salt)
 * $oldpassword = Current Value of Password (or new password if changing the pwd).
 * $password = sha1($salt.sha1(sha1($oldpassword).$salt));
 * 
 * These values are stored in the WBB base directory in options.inc.php and this file should be
 * included before attempting to hash.  
 * 
 * Note too that the ENCRYPTION METHOD can be any of:
 * - sha1
 * - md5
 * - crc32
 * - crypt
 * 
 * Anyplace in the above formula where "sha1" appears will need to change based upon this value.
 * Finally, the "salt" for creating a new password is nothing more than a randomly generated 40
 * character value. (Numbers and Letters);
 * 
 ************************************************************************************/

if ( !defined('IN_PHPRAID'))
	print_error("Hacking Attempt", "Invalid access detected", 1);

if(isset($_GET['phpraid_dir']) || isset($_POST['phpraid_dir']))
	die("Hacking attempt detected!");

// THIS IS SAFE TO TURN ON.
$BridgeSupportPWDChange = FALSE;
$Bridge2ColumGroup = FALSE;

/*********************************************** 
 * Table and Column Names - change per CMS.
 ***********************************************/
// Column Name for the ID field for the User.
$db_user_id = "userID";
// Column Name for the ID field for the Group the User belongs to.
$db_group_id = "groupID";
// Column Name for the UserName field.
$db_user_name = "username";
// Column Name for the User's E-Mail Address
$db_user_email = "email";
// Column Name for the User's Password
$db_user_password = "password";
// Column Name for the User's Salt
$db_user_salt = "salt";

$db_table_user_name = "user";
$db_table_group_name = "user_to_groups";

if (isset($phpraid_config[$phpraid_config['auth_type'].'_db_name']))
	$table_prefix = $phpraid_config[$phpraid_config['auth_type'].'_db_name'] . ".". $phpraid_config[$phpraid_config['auth_type'].'_table_prefix'];
else
	$table_prefix = $phpraid_config[$phpraid_config['auth_type'].'_table_prefix'];

$auth_user_class = $phpraid_config[$phpraid_config['auth_type'].'_auth_user_class'];
$auth_alt_user_class = $phpraid_config[$phpraid_config['auth_type'].'_alt_auth_user_class'];

// Table Name were save all  Groups/Class Infos
$db_table_allgroups = "groups";
// Column Name for the ID field for the Group/Class.
$db_allgroups_id = "groupid";
// Column Name for the Groups/Class Name field.
$db_allgroups_name = "title";


function encrypt($value) {
	if (defined('ENCRYPTION_METHOD')) {
		switch (ENCRYPTION_METHOD) {
			case 'sha1': return sha1($value);
			case 'md5': return md5($value);
			case 'crc32': return crc32($value);
			case 'crypt': return crypt($value);
		}
	}
	return sha1($value);
}

function getSaltedHash($value, $salt) 
{
	if (!defined('ENCRYPTION_ENABLE_SALTING') || ENCRYPTION_ENABLE_SALTING) 
	{
		$hash = '';
		// salt
		if (!defined('ENCRYPTION_SALT_POSITION') || ENCRYPTION_SALT_POSITION == 'before') 
			$hash .= $salt;

		// value
		if (!defined('ENCRYPTION_ENCRYPT_BEFORE_SALTING') || ENCRYPTION_ENCRYPT_BEFORE_SALTING) 
			$hash .= encrypt($value);
		else
			$hash .= $value;

		// salt
		if (defined('ENCRYPTION_SALT_POSITION') && ENCRYPTION_SALT_POSITION == 'after')
			$hash .= $salt;

		return encrypt($hash);
	}
	else
		return encrypt($value);
}

function getDoubleSaltedHash($value, $salt) 
{
	return encrypt($salt . getSaltedHash($value, $salt));
}

//change password in WRM DB

// NOTE for WBB the password produced here should exactly match WBBs password schema.
function db_password_change($profile_id, $dbusernewpassword)
{
	global $db_user_id, $db_group_id, $db_user_name, $db_user_email, $db_user_password, $db_table_user_name; 
	global $db_table_group_name, $auth_user_class, $auth_alt_user_class, $table_prefix, $db_raid, $phpraid_config;
	global $db_user_salt;
	
	// WBB Specific Password Mangling - See Top of File for info on WBB Mangling.
	
	//Generate Salt
	for($i=0; $i < 40; $i++) 
	{
		//Generate a random character.  This must be within the following range:
		// * 48 - 57 - Number
		// * 65 - 90 - Capital Letter
		// * 97 - 122 - Lower Case letter
		$charnum = 0;
		while (($charnum > 57 and $charnum < 65)||($charnum > 90 and $charnum < 97))
			$charnum = rand(48,122);
				
		//chr(int $ascii) -> Return a specific character
		$salt .= chr($charnum); 
	}
	
	// Create the New Password
	$dbusernewpassword = getDoubleSaltedHash($dbusernewpassword, $salt);

	/*********************************************************************
	 * Do not modify anything below here.
	 *********************************************************************/
	//check: is profile_id in CMS DB
	$sql = sprintf(	"SELECT ".$db_user_id.
					" FROM " . $table_prefix . $db_table_user_name . 
					" WHERE ".$db_user_id." = %s", 
					quote_smart($profile_id)
			);
			
	$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	if ($db_raid->sql_numrows($result) != 1) {
		//user not found in WRM DB
		return 2;
	}

	// Profile ID Exists, Update CMS with new password.
	$sql = sprintf(	"UPDATE " . $table_prefix . $db_table_user_name . 
					" SET ".$db_user_password." = %s, ".$db_user_salt." = %s WHERE " . $db_user_id . " = %s", 
					quote_smart($dbusernewpassword), quote_smart($salt), quote_smart($profile_id)
			);

	if (($db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1)) == true)
	{
		//pwd change
		return 1;
	}
	else
	{
		//pwd NOT change
		return 0;
	} 
}

//compare password
//return value -> $db_pass (Password from CMS database) upon success, FALSE upon fail.
function password_check($oldpassword, $profile_id, $encryptflag)
{
	global $db_user_id, $db_group_id, $db_user_name, $db_user_email, $db_user_password, $db_table_user_name; 
	global $db_table_group_name, $auth_user_class, $auth_alt_user_class, $table_prefix, $db_raid, $phpraid_config;
	global $db_user_salt;

	$sql_passchk = sprintf("SELECT " . $db_user_password . 
							" FROM " . $table_prefix . $db_table_user_name . 
							" WHERE " . $db_user_id . " = %s", quote_smart($profile_id)
			);
	$result_passchk = $db_raid->sql_query($sql_passchk) or print_error($sql_passchk, $db_raid->sql_error(), 1);

	if ($db_raid->sql_numrows($result_passchk) != 1)
	{
		//user not found in CMS DB, Fail
		return 2;
	}

	$data_passchk = $db_raid->sql_fetchrow($result_passchk, true);
	$db_pass = $data_passchk[$db_user_password];

	if ($encryptflag)
	{ // Encrypted Password Sent in, Check directly against DB.
		if ($oldpassword == $db_pass)
			return $db_pass;
		else
			return FALSE;
	}
	else
	{ // Non-encrypted password sent in, encrypt and check against DB.
		//We have the password now, now for WBB Specific Password Mangling
		// See Top of File for Information.
		$sql_salt = sprintf("SELECT " . $db_user_salt . 
							" FROM " . $table_prefix . $db_table_user_name . 
							" WHERE " . $db_user_id . " = %s", quote_smart($profile_id)
				);
		$result_salt = $db_raid->sql_query($sql_salt) or print_error($sql_salt, $db_raid->sql_error(), 1);
	
		$data_salt = $db_raid->sql_fetchrow($result_salt, true);
		$salt = $data_salt[$db_user_salt];
	
		$dbusernewpassword = getDoubleSaltedHash($oldpassword, $salt);
	
		if ($dbusernewpassword == $db_pass)
			return $db_pass;
		else
			return FALSE;
	}
}

// Read In the Include File.
include('options.inc.php');

?>