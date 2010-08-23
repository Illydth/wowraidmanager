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

$table_prefix = $phpraid_config[$phpraid_config['auth_type'].'_table_prefix'];
//$table_prefix = $phpraid_config[$phpraid_config['auth_type'].'_db_name'] . ".". $phpraid_config[$phpraid_config['auth_type'].'_table_prefix'];

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
	$sql = sprintf(	"SELECT ".$db_user_id." FROM " . $table_prefix . $db_table_user_name . 
					" WHERE ".$db_user_id." = %s", 
					quote_smart($profile_id)
			);
			
	$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
	if (mysql_num_rows($result) != 1) {
		//user not found in WRM DB
		return 2;
	}

	// Profile ID Exists, Update CMS with new password.
	$sql = sprintf(	"UPDATE " . $table_prefix . $db_table_user_name . 
					" SET ".$db_user_password." = %s, ".$db_user_salt." = %s WHERE " . $db_user_id . " = %s", 
					quote_smart($dbusernewpassword), quote_smart($salt), quote_smart($profile_id)
			);

	if (($db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1)) == true)
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

	$sql_passchk = sprintf("SELECT " . $db_user_password . " FROM " . $table_prefix . $db_table_user_name . 
						" WHERE " . $db_user_id . " = %s", quote_smart($profile_id)
			);
	$result_passchk = $db_raid->sql_query($sql_passchk) or print_error($sql_passchk, mysql_error(), 1);

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
		//We have the password now, now for WBB Specific Password Mangling
		// See Top of File for Information.
		$sql_salt = sprintf("SELECT " . $db_user_salt . " FROM " . $table_prefix . $db_table_user_name . 
							" WHERE " . $db_user_id . " = %s", quote_smart($profile_id)
				);
		$result_salt = $db_raid->sql_query($sql_salt) or print_error($sql_salt, mysql_error(), 1);
	
		$data_salt = $db_raid->sql_fetchrow($result_salt, true);
		$salt = $data_salt[$db_user_salt];
	
		$dbusernewpassword = getDoubleSaltedHash($oldpassword, $salt);
	
		if ($dbusernewpassword == $db_pass)
			return $db_pass;
		else
			return FALSE;
	}
}

function phpraid_login() 
{
	global $db_user_id, $db_group_id, $db_user_name, $db_user_email, $db_user_password, $db_table_user_name; 
	global $db_table_group_name, $auth_user_class, $auth_alt_user_class, $table_prefix, $db_raid, $phpraid_config;

	$username = $password = "";

	if(isset($_POST['username'])){
		// User is logging in, set encryption flag to 0 to identify login with plain text password.
		$pwdencrypt = FALSE;
		$username = strtolower_wrap(scrub_input($_POST['username']), "UTF-8");
		$password = $_POST['password'];
		$wrmpass = md5($_POST['password']);
	} elseif(isset($_COOKIE['username']) && isset($_COOKIE['password'])) {
		// User is not logging in but processing cooking, set encryption flag to 1 to identify login with encrypted password.
		$pwdencrypt = TRUE;
		$username = strtolower_wrap(scrub_input($_COOKIE['username']), "UTF-8");
		$password = $_COOKIE['password'];
		$wrmpass = '';
	} else {
		phpraid_logout();
	}

	// from site/page/.. change pwd (testing)
	//if(isset($_POST['username2'])){
	//	$username = scrub_input(strtolower($_POST['username2']));
		//$password = $pwd_hasher->HashPassword($_POST['password2']);
	//	$password = md5($_POST['password2']);
	//}

	//database
	$sql = sprintf(	"SELECT ".$db_user_id.",". $db_user_name .",".$db_user_email.",".$db_user_password.
					" FROM " . $table_prefix . $db_table_user_name. 
					" WHERE ".$db_user_name." = %s", quote_smart($username)
			);

	$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);

	//WRM database
	//$sql = sprintf("SELECT username, password FROM " . $phpraid_config['db_prefix'] . "profile WHERE username = %s",
	//				quote_smart($username)
	//		);
	//$result2 = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
	//if ($data2 = $db_raid->sql_fetchrow($result2))
	//{
	//	$wrmuserpassword = $data2['password'];
	//}

	while($data = $db_raid->sql_fetchrow($result, true)) {
		//$testVal = password_check($password, $data[$db_user_id]);
		//echo "<br>Processing: " . $data[$db_user_name] . " : Password Check: " . $testVal;
		if( ($username == strtolower_wrap($data[$db_user_name], "UTF-8")) && ($cmspass = password_check($password, $data[$db_user_id], $pwdencrypt)) )
		{
			// The user has a matching username and proper password in the phpbb database.
			// We need to validate the users group.  If it does not contain the user group that has been set as
			//	authorized to use WRM, we need to fail the login with a proper message.
			
			if ($auth_user_class != 0)
			{
				$FoundUserInGroup = FALSE;

				$sql = sprintf( "SELECT " . $db_user_id. "," .$db_group_id ." FROM " . $table_prefix . $db_table_group_name. 
								" WHERE ".$db_user_id." = %s", quote_smart($data[$db_user_id])
						);
				$resultgroup = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
				while($datagroup = $db_raid->sql_fetchrow($resultgroup, true)) {
					if( ($datagroup[$db_group_id] == $auth_user_class) or ($datagroup[$db_group_id] == $auth_alt_user_class) )
					{	
						$FoundUserInGroup = TRUE;
					}
				}

				if ($FoundUserInGroup == FALSE){
					phpraid_logout();
					return -1;
				}
			}


			// User is properly logged in and is allowed to use WRM, go ahead and process his login.
			$autologin = scrub_input($_POST['autologin']);
			if(isset($autologin)) {
				// they want automatic logins so set the cookie
				// set to expire in one month
				setcookie('username', $data[$db_user_name], time() + 2629743);
				setcookie('profile_id', $data[$db_user_id], time() + 2629743);
				setcookie('password', $cmspass, time() + 2629743);
			}

			// set user profile variables
			$_SESSION['username'] = strtolower_wrap($data[$db_user_name], "UTF-8");
			$_SESSION['session_logged_in'] = 1;
			$_SESSION['profile_id'] = $data[$db_user_id];
			$_SESSION['email'] = $data[$db_user_email];

			if($phpraid_config['default_group'] != 'nil')
				$user_priv = $phpraid_config['default_group'];
			else
				$user_priv = '0';
				
			// User is all logged in and setup, the session is initialized properly.  Now we need to create the users
			//    profile in the WRM database if it does not already exist.
			$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "profile WHERE profile_id = %s",
							quote_smart($_SESSION['profile_id'])
					);
			$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
			
			if ($data = $db_raid->sql_fetchrow($result))
			{
				//We found the profile in the database, update.
				if ($wrmpass != '')
				{
					$sql = sprintf("UPDATE " . $phpraid_config['db_prefix'] . 
									"profile SET email = %s, password = %s, last_login_time = %s WHERE profile_id = %s",
									quote_smart($_SESSION['email']),quote_smart($wrmpass),
									quote_smart(time()),quote_smart($_SESSION['profile_id'])
							);
				}
				else
				{
					$sql = sprintf("UPDATE " . $phpraid_config['db_prefix'] . 
									"profile SET email = %s, last_login_time = %s WHERE profile_id = %s",
									quote_smart($_SESSION['email']),
									quote_smart(time()),quote_smart($_SESSION['profile_id'])
							);	
				}
				$db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
			}
			else
			{
				//Profile not found in the database or DB Error, insert.
				$sql = sprintf("INSERT INTO " . $phpraid_config['db_prefix'] . "profile VALUES (%s, %s, %s, %s, %s, %s)",
							quote_smart($_SESSION['profile_id']), quote_smart($_SESSION['email']), quote_smart($wrmuserpassword),
							quote_smart($user_priv), quote_smart(strtolower_wrap($_SESSION['username'], "UTF-8")), quote_smart(time())
						);
				$db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
			}
			
			get_permissions();
			
			//security fix
			unset($username);
			unset($password);
			unset($cmspass);
			unset($wrmpass);

			return 1;
		}
	}
	return 0;
}

function phpraid_logout()
{
	// unset the session and remove all cookies
	clear_session();
	setcookie('username', '', time() - 2629743);
	setcookie('password', '', time() - 2629743);
}

// Read In the Include File.
include('options.inc.php');

?>
