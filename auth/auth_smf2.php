<?php
/***************************************************************************
 *                             auth_smf.php
 *                            -------------------
 *   begin                : June 18, 2008
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

function phpraid_login() {
	global $groups, $db_raid, $phpraid_config;

	# Try to use stronger but system-specific hashes, with a possible fallback to
	# the weaker portable hashes.
	$pwd_hasher = new PasswordHash(8, FALSE);
	
	if(isset($_POST['username'])) 	{
		$username = scrub_input(strtolower($_POST['username']));
		//pwd hash
		$password = $pwd_hasher->HashPassword($_POST['password']);
		
	} elseif(isset($_COOKIE['username']) && isset($_COOKIE['password'])) {
		$username = scrub_input(strtolower($_COOKIE['username']));
		$password = scrub_input($_COOKIE['password']);
	} else {
		phpraid_logout();
	}

	// Set smf Configuration Options
	$smf_table_prefix = $phpraid_config['smf_table_prefix'];
	$smf_auth_user_class = $phpraid_config['smf_auth_user_class'];
	$smf_alt_auth_user_class = $phpraid_config['smf_alt_auth_user_class'];

	
	// Get the user_loginname and password and the various user classes that the user belongs to.
	$sql = "SELECT id_member, member_name, email_address, id_group FROM " . $smf_table_prefix . "members WHERE member_name = '".$username."'";
	$result = $db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	
	$sql = "SELECT username, password FROM " . $phpraid_config['db_prefix'] . "profile WHERE username='".$username."'";
	$result2 = $db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	if ($data2 = $db_raid->sql_fetchrow($result2))
			{
				$wrmuserpassword = $data2['password'];
			}
	
	while($data = $db_raid->sql_fetchrow($result, true)) {
		//echo "<br>Processing: " . $data['member_name'] . " : " . $data['passwd'].'<br>pwd:'.$password;
		if($username == strtolower($data['member_name']) && $pwd_hasher->CheckPassword($password, $wrmuserpassword)==0) {
			// The user has a matching username and proper password in the smf database.
			// We need to validate the users class.  If it does not contain the user class that has been set as
			//	authorized to use smf, we need to fail the login with a proper message.
			$user_class = $data['id_group'];
			$pos = strpos($user_class, $smf_auth_user_class);
			$pos2 = strpos($user_class, $smf_alt_auth_user_class);
			if ($pos === false && $smf_auth_user_class != 0)
			{
				if ($pos2 === false)
				{
					phpraid_logout();
					return -1;
				}
			}

			// User is properly logged in and is allowed to use WRM, go ahead and process his login.
			$autologin=scrub_input($_POST['autologin']);
			if(isset($autologin)) {
				// they want automatic logins so set the cookie
				// set to expire in one month
				setcookie('username', $data['member_name'], time() + 2629743);
				setcookie('password', $wrmuserpassword, time() + 2629743);
			}

			// set user profile variables
			$_SESSION['username'] = strtolower($data['member_name']);
			$_SESSION['session_logged_in'] = 1;
			$_SESSION['profile_id'] = $data['id_member'];
			$_SESSION['email'] = $data['email_address'];
			$user_password = $wrmuserpassword;
			if($phpraid_config['default_group'] != 'nil')
				$user_priv = $phpraid_config['default_group'];
			else
				$user_priv = '0';

			// User is all logged in and setup, the session is initialized properly.  Now we need to create the users
			//    profile in the WRM database if it does not already exist.
			$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "profile WHERE profile_id=%s", quote_smart($_SESSION['profile_id']));
			$result = $db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
			if ($data = $db_raid->sql_fetchrow($result))
			{ //We found the profile in the database, update.
				$sql = sprintf("UPDATE " . $phpraid_config['db_prefix'] . "profile SET email=%s,password=%s,last_login_time=%s WHERE profile_id=%s",quote_smart($_SESSION['email']),quote_smart($user_password),quote_smart(time()),quote_smart($_SESSION['profile_id']));
				$db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
			}
			else
			{ //Profile not found in the database or DB Error, insert.
				$sql = sprintf("INSERT INTO " . $phpraid_config['db_prefix'] . "profile VALUES (%s, %s, %s, %s, %s, %s)", quote_smart($_SESSION['profile_id']), quote_smart($_SESSION['email']), quote_smart($user_password), quote_smart($user_priv), quote_smart($_SESSION['username']),quote_smart(time()));
				$db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
			}

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
$_SESSION['name'] = "WRM";

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