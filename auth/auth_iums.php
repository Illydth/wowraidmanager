<?php
/***************************************************************************
 *                             auth_phpraid.php
 *                            -------------------
 *   begin                : Monday, Jan 18, 2005
 *   copyright            : (C) 2007-2008 Douglas Wagner
 *   email                : douglasw@wagnerweb.org
 *
 *   $Id: auth_phpraid.php,v 2.00 2007/11/23 14:25:57 psotfx Exp $
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

$BridgeSupportPWDChange = TRUE;

//change password in WRM DB
function db_password_change($profile_id, $dbusernewpassword)
{
	global $db_raid, $phpraid_config;

	//convert pwd
	//$dbusernewpassword = $pwd_hasher->HashPassword(dbusernewpassword);
	$dbusernewpassword = md5($dbusernewpassword);


	//check: is profile_id in WRM DB
	$sql = sprintf("SELECT profile_id FROM " . $phpraid_config['db_prefix'] . "profile WHERE profile_id = %s", 
					quote_smart($profile_id)
			);
	$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(),1);
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
//return value -> $data['password'] (Password from CMS database) upon success, FALSE upon fail.
function password_check($oldpassword, $profile_id, $encryptflag)
{
	global $db_raid, $phpraid_config;
	$sql = sprintf("SELECT password FROM " . $phpraid_config['db_prefix'] . "profile WHERE profile_id = %s",
					quote_smart($profile_id)
			);
	$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
	$data = $db_raid->sql_fetchrow($result, true);
	
	if ($encryptflag)
	{ // Encrypted Password Sent In.
		if ($oldpassword == $data['password'])
			return $data['password'];
		else
			return FALSE;
	}
	else 
	{ // Plain text password sent in.
		if (md5($oldpassword) == $data['password'])
			return $data['password'];
		else
			return FALSE;
	}
}

function phpraid_login() {
	global $groups, $db_raid, $phpraid_config;
	$username = $password = "";

	$table_prefix = $phpraid_config['db_prefix'];

	//table and column name
	$db_user_id = "profile_id";
	$db_user_name = "username";
	$db_user_password = "password";
	$db_user_email = "email";
	$db_table_user_name = "profile";

	if(isset($_POST['username'])) 	{
		// User is logging in, set encryption flag to 0 to identify login with plain text password.
		$pwdencrypt = FALSE;
		$username = strtolower_wrap(scrub_input($_POST['username']), "UTF-8");
		$password = $_POST['password'];
	} elseif(isset($_COOKIE['username']) && isset($_COOKIE['password'])) {
		// User is not logging in but processing cooking, set encryption flag to 1 to identify login with encrypted password.
		$pwdencrypt = TRUE;
		$username = strtolower_wrap(scrub_input($_COOKIE['username']), "UTF-8");
		$password = $_COOKIE['password'];
	} else {
		phpraid_logout();
	}
	
	$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "profile";
	
	$sql = sprintf(	"SELECT ".$db_user_id." , ". $db_user_name ." , ". $db_user_email . " , " . $db_user_password .
					" FROM " . $table_prefix . $db_table_user_name. 
					" WHERE ".$db_user_name." = %s", quote_smart($username)
			);

	$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
	
	while($data = $db_raid->sql_fetchrow($result, true)) 
	{
		if( ($username == strtolower_wrap($data[$db_user_name], "UTF-8")) && ($cmspass = password_check($password, $data[$db_user_id], $pwdencrypt)) ) 
		{
			// User is properly logged in and is allowed to use WRM, go ahead and process his login.
			$autologin = scrub_input($_POST['autologin']);
			if(isset($autologin)) {
				// they want automatic logins so set the cookie
				// set to expire in one month
				setcookie('username', $data[$db_user_name], time() + 2629743);
				setcookie('password', $cmspass, time() + 2629743);
			}

			// set user profile variables
			$_SESSION['username'] = strtolower_wrap($data[$db_user_name], "UTF-8");
			$_SESSION['session_logged_in'] = 1;
			$_SESSION['profile_id'] = $data[$db_user_id];
			$_SESSION['email'] = $data[$db_user_email];

			// get user permissions
			get_permissions();

			// ********************
			// * NOTE * IUMS Auth does not do profile checking like external bridges do.
			// ********************

			/* if($phpraid_config['default_group'] != 'nil')
				$user_priv = $phpraid_config['default_group'];
			else
				$user_priv = '0'; */

			// User is all logged in and setup, the session is initialized properly.  Now we need to create the users
			//    profile in the WRM database if it does not already exist.
			/* $sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "profile WHERE profile_id = %s",
							quote_smart($_SESSION['profile_id'])
					);
			$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
			if ($data = $db_raid->sql_fetchrow($result))
			{*/
				//We found the profile in the database, update.
			/*	$sql = sprintf(	"UPDATE " . $phpraid_config['db_prefix'] . "profile ".
								" SET email = %s, password = %s, last_login_time = %s WHERE profile_id = %s",
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
			}*/

			$sql = sprintf("UPDATE " . $phpraid_config['db_prefix'] . "profile SET last_login_time=%s WHERE profile_id=%s",
							quote_smart(time()),quote_smart($_SESSION['profile_id']));
	
			$db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
			
			//security fix
			unset($username);
			unset($password);
			unset($cmspass);
			
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

// good ole authentication
$lifetime = get_cfg_var("session.gc_maxlifetime"); 
$temp = session_name("WRM-iums");
$temp = session_set_cookie_params($lifetime, getCookiePath());
session_start();
$_SESSION['name'] = "WRM-iums";

// set session defaults
if (!isset($_SESSION['initiated'])) 
{
	if(isset($_COOKIE['username']) && isset($_COOKIE['password']))
	{ 
		$testval = phpraid_login();
		if (!$testval)
		{
			phpraid_logout();
			session_regenerate_id();
			$_SESSION['initiated'] = true;
			$_SESSION['username'] = 'Anonymous';
			$_SESSION['session_logged_in'] = 0;
			$_SESSION['profile_id'] = -1;
		}
	}
	else 
	{
		session_regenerate_id();
		$_SESSION['initiated'] = true;
		$_SESSION['username'] = 'Anonymous';
		$_SESSION['session_logged_in'] = 0;
		$_SESSION['profile_id'] = -1;
	}
}
?>