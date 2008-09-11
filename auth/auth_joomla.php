<?php
/***************************************************************************
 *                             auth_jommla.php
 *                            -------------------
 *   begin                : July 23, 2008
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

$BridgeSupportPWDChange = TRUE;

//change password in WRM DB
function db_password_change($profile_id, $dbusernewpassword)
{
	global $db_raid, $phpraid_config;

	//convert pwd
	$dbusernewpassword = $pwd_hasher->HashPassword(dbusernewpassword);
	//$dbusernewpassword = md5($dbusernewpassword);


	//check: is profile_id in WRM DB
	$sql = sprintf("SELECT profile_id FROM " . $phpraid_config['db_prefix'] . "profile WHERE profile_id = %s", 
					quote_smart($profile_id)
			);
	$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
	if (mysql_num_rows($result) != 1) {
		//user not found in WRM DB
		return 2;
	}

	$sql = sprintf("UPDATE " . $phpraid_config['db_prefix'] . "profile SET password = %s WHERE profile_id = %s", 
				quote_smart($dbusernewpassword), quote_smart($profile_id)
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
//return value -> 0 equal ;1 Not equal
function password_check($oldpassword, $profile_id)
{
	global $db_raid, $phpraid_config;
	$sql = sprintf("SELECT password FROM " . $phpraid_config['db_prefix'] . "profile WHERE profile_id = %s",
					quote_smart($profile_id)
			);
	$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
	$data = $db_raid->sql_fetchrow($result, true);

	if ( $pwd_hasher->HashPassword($oldpassword) == $data['password'])
	{
		return 0;
	}
	else
		return 1;
}

function phpraid_login() {
	global $groups, $db_raid, $phpraid_config;
	$wrmuserpassword = $username = $password = "";

	// Set joomla Configuration Options
	$table_prefix = $phpraid_config['joomla_table_prefix'];
	$auth_user_class = $phpraid_config['joomla_auth_user_class'];
	$auth_alt_user_class = $phpraid_config['joomla_auth_alt_user_class'];

	//table and column name
	$db_user_id = "id";
	$db_user_name = "username";
	//$db_user_password = "";
	$db_user_email = "email";
	$db_group_id = "gid";
	$db_table_user_name = "jos_users";


	# Try to use stronger but system-specific hashes, with a possible fallback to
	# the weaker portable hashes.
	$pwd_hasher = new PasswordHash(8, FALSE);

	if(isset($_POST['username'])){
		$username = scrub_input(strtolower($_POST['username']));
		//pwd hash
		$password = $pwd_hasher->HashPassword($_POST['password']);

	} elseif(isset($_COOKIE['username']) && isset($_COOKIE['password'])) {
		$username = scrub_input(strtolower($_COOKIE['username']));
		$password = scrub_input($_COOKIE['password']);
	} else {
		phpraid_logout();
	}

	//Joomla database
	$sql = sprintf(	"SELECT ".$db_user_id." , ". $db_user_name ." , ". $db_user_email . " , ".$db_group_id.
					" FROM " . $table_prefix . $db_table_user_name. 
					" WHERE ".$db_user_name." = %s", quote_smart($username)
			);

	$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);

	//WRM database
	$sql = sprintf("SELECT username, password FROM " . $phpraid_config['db_prefix'] . "profile WHERE username = %s",
					quote_smart($username)
			);
	$result2 = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
	if ($data2 = $db_raid->sql_fetchrow($result2))
	{
		$wrmuserpassword = $data2['password'];
	}

	while($data = $db_raid->sql_fetchrow($result, true)) {

		if( ($username == strtolower($data[$db_user_name])) && (($pwd_hasher->CheckPassword($password, $wrmuserpassword)==0) or ($data2['password'] == "" ) ) ) {

	//	if( ($username == strtolower($data[$db_user_name])) && (($password == $wrmuserpassword) or ($data2['password'] == "" ) ) ) {

			//first use: password insert in WRM DB
			if ($wrmuserpassword == ""){
				$wrmuserpassword = $password;
			}

			// We need to validate the users group.  If it does not contain the user group that has been set as
			//	authorized to use WRM, we need to fail the login with a proper message.		
			$user_class = $data[$db_group_id];
			$pos = strpos($user_class, $auth_user_class);
			$pos2 = strpos($user_class, $auth_alt_user_class);
			if ($pos === false && $smf_auth_user_class != 0)
			{
				if ($pos2 === false)
				{
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
				setcookie('password', $wrmuserpassword, time() + 2629743);
			}

			// set user profile variables
			$_SESSION['username'] = strtolower($data[$db_user_name]);
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
				$sql = sprintf("UPDATE " . $phpraid_config['db_prefix'] . "profile SET email = %s, password = %s, last_login_time = %s WHERE profile_id = %s",
							quote_smart($_SESSION['email']),quote_smart($wrmuserpassword),
							quote_smart(time()),quote_smart($_SESSION['profile_id'])
						);
				$db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
			}
			else
			{
				//Profile not found in the database or DB Error, insert.
				$sql = sprintf("INSERT INTO " . $phpraid_config['db_prefix'] . "profile VALUES (%s, %s, %s, %s, %s, %s)",
							quote_smart($_SESSION['profile_id']), quote_smart($_SESSION['email']), quote_smart($wrmuserpassword),
							quote_smart($user_priv), quote_smart(strtolower($_SESSION['username'])), quote_smart(time())
						);
				$db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
			}
			
			//security fix
			unset($username);
			unset($password);
			unset($wrmuserpassword);

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

require ("includes/functions_pwdhash.php");

// good ole authentication
session_start();
$_SESSION['name'] = "WRM-joomla";

// set session defaults
if (!isset($_SESSION['initiated'])) {
	if(isset($_COOKIE['username']) && isset($_COOKIE['password'])) {
		phpraid_login();
	} else {
		session_regenerate_id();
		$_SESSION['initiated'] = true;
		$_SESSION['username'] = 'Anonymous';
		$_SESSION['session_logged_in'] = 0;
		$_SESSION['profile_id'] = -1;
	}
}

?>