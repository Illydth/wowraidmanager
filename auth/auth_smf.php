<?php
/***************************************************************************
 *                             auth_smf.php
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

if ( !defined('IN_PHPRAID'))
	print_error("Hacking Attempt", "Invalid access detected", 1);

if(isset($_GET['phpraid_dir']) || isset($_POST['phpraid_dir']))
	die("Hacking attempt detected!");

// THIS IS SAFE TO TURN ON.
$BridgeSupportPWDChange = FALSE;
$Bridge2ColumGroup = TRUE;

/*********************************************** 
 * Table and Column Names - change per CMS.
 ***********************************************/
// Column Name for the ID field for the User.
$db_user_id = "ID_MEMBER";
// Column Name for the ID field for the Group the User belongs to.
$db_group_id = "ID_GROUP";
// Column Name for Additional Groups User belongs to.
$db_add_group_ids = "additionalGroups";
// Column Name for the UserName field.
$db_user_name = "memberName";
// Column Name for the User's E-Mail Address
$db_user_email = "emailAddress";
// Column Name for the User's Password
$db_user_password = "passwd";

$db_table_user_name = "members";
$db_table_group_name = "members";

if (isset($phpraid_config[$phpraid_config['auth_type'].'_db_name']))
	$table_prefix = $phpraid_config[$phpraid_config['auth_type'].'_db_name'] . ".". $phpraid_config[$phpraid_config['auth_type'].'_table_prefix'];
else
	$table_prefix = $phpraid_config[$phpraid_config['auth_type'].'_table_prefix'];

$auth_user_class = $phpraid_config[$phpraid_config['auth_type'].'_auth_user_class'];
$auth_alt_user_class = $phpraid_config[$phpraid_config['auth_type'].'_alt_auth_user_class'];

// Table Name were save all  Groups/Class Infos
$db_table_allgroups = "membergroups";
// Column Name for the ID field for the Group/Class.
$db_allgroups_id = "ID_GROUP";
// Column Name for the Groups/Class Name field.
$db_allgroups_name = "groupName";

//change password in WRM DB

// NOTE for Joomla the password produced here should exactly match Joomla's password schema.
function db_password_change($profile_id, $dbusernewpassword)
{
	global $db_user_id, $db_group_id, $db_user_name, $db_user_email, $db_user_password, $db_table_user_name; 
	global $db_table_group_name, $auth_user_class, $auth_alt_user_class, $table_prefix, $db_raid, $phpraid_config;
	global $db_add_group_ids;
	
	// SMF Specific Password Mangling
	/* 
	 * For SMF, to create a password we use the sha1 hashing algorithm but we pre-pend the username
	 * onto the beginning of the password.  The final password looks like: 
	 * sha1(strtolower($user).$password); 
	 */
	
	// Get the username:
	$sql = sprintf(	"SELECT ".$db_user_name." FROM " . $table_prefix . $db_table_user_name . 
					" WHERE ".$db_user_id." = %s", 
					quote_smart($profile_id)
			);
			
	$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	if (mysql_num_rows($result) != 1) {
		//user not found in WRM DB
		return 2;
	}
	$data_username = $db_raid->sql_fetchrow($result, true);
	$username = $data_username[$db_user_name];

	//Create the password:	
	$dbusernewpassword = sha1(strtolower($username).$dbusernewpassword);

	/*********************************************************************
	 * Do not modify anything below here.
	 *********************************************************************/
	//check: is profile_id in CMS DB
	$sql = sprintf(	"SELECT ".$db_user_id." FROM " . $table_prefix . $db_table_user_name . 
					" WHERE ".$db_user_id." = %s", 
					quote_smart($profile_id)
			);
			
	$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	if (mysql_num_rows($result) != 1) {
		//user not found in WRM DB
		return 2;
	}

	// Profile ID Exists, Update CMS with new password.
	$sql = sprintf(	"UPDATE " . $table_prefix . $db_table_user_name . 
					" SET ".$db_user_password." = %s WHERE " . $db_user_id . " = %s", 
					quote_smart($dbusernewpassword), quote_smart($profile_id)
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
	global $pwd_hasher,	$db_add_group_ids;

	$sql_passchk = sprintf("SELECT " . $db_user_password . " FROM " . $table_prefix . $db_table_user_name . 
						" WHERE " . $db_user_id . " = %s", quote_smart($profile_id)
			);
	$result_passchk = $db_raid->sql_query($sql_passchk) or print_error($sql_passchk, $db_raid->sql_error(), 1);

	if (mysql_num_rows($result_passchk) != 1)
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
		//We have the password now, now for SMF Specific Password Mangling
		/* 
		 * For SMF, we need to obtain the username and use a sha1 hash with the username and the input password
		 * to check against what's in the DB.
		 */
		$sql_user = sprintf("SELECT " . $db_user_name . " FROM " . $table_prefix . $db_table_user_name . 
							" WHERE " . $db_user_id . " = %s", quote_smart($profile_id)
				);
		$result_user = $db_raid->sql_query($sql_user) or print_error($sql_user, $db_raid->sql_error(), 1);
	
		$data_username = $db_raid->sql_fetchrow($result_user, true);
		$username = $data_username[$db_user_name];
		
		$dbusernewpassword = sha1(strtolower($username).$oldpassword);
		
		if ($dbusernewpassword == $db_pass)
			return $db_pass;
		else
			return FALSE;
	}
}

?>
