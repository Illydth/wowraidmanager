<?php
/***************************************************************************
 *                             auth_e107.php
 *                            -------------------
 *   begin                : Tuesday, June 19, 2007
 *   copyright            : (C) 2007 Douglas Wagner
 *   email                : douglasw0@yahoo.com
 *
 *   $Id: mysql.php,v 1.16 2002/03/19 01:07:36 psotfx Exp $
 *
 ***************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/

function phpraid_login() {
	global $groups, $db_raid, $phpraid_config;

	if(isset($_POST['username'])) 	{
		$username = strtolower($_POST['username']);
		$password = md5($_POST['password']);
	} elseif(isset($_COOKIE['username']) && isset($_COOKIE['password'])) {
		$username = strtolower($_COOKIE['username']);
		$password = $_COOKIE['password'];
	} else {
		phpraid_logout();
	}

	// Set e107 Configuration Options
	$e107_table_prefix = $phpraid_config['e107_table_prefix'];
	$e107_auth_user_class = $phpraid_config['e107_auth_user_class'];
	$alt_auth_user_class = $phpraid_config['alt_auth_user_class'];
	
	// Get the user_loginname and password and the various user classes that the user belongs to.
	$sql = "SELECT user_id, user_loginname, user_password, user_email, user_class FROM " . $e107_table_prefix . "user";
	$result = $db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	
	while($data = $db_raid->sql_fetchrow($result)) {
		//echo "Processing: " . $data['username'] . " : " . $data['password'];
		if($username == strtolower($data['user_loginname']) && $password == $data['user_password']) {
			// The user has a matching username and proper password in the e107 database.
			// We need to validate the users class.  If it does not contain the user class that has been set as 
			//	authorized to use phpRaid, we need to fail the login with a proper message.
			$user_class = $data['user_class'];
			$pos = strpos($user_class, $e107_auth_user_class);
			$pos2 = strpos($user_class, $alt_auth_user_class); 
			if ($pos === false && $e107_auth_user_class != 0)
			{
				if ($pos2 === false)
				{
					phpraid_logout();
					return -1;			
				}
			}
	
			// User is properly logged in and is allowed to use phpRaid, go ahead and process his login.
			if(isset($_POST['autologin'])) {
				// they want automatic logins so set the cookie
				// set to expire in one month
				setcookie('username', $data['user_loginname'], time() + 2629743);
				setcookie('password', $data['user_password'], time() + 2629743);
			}
			
			// set user profile variables
			$_SESSION['username'] = strtolower($data['user_loginname']);
			$_SESSION['session_logged_in'] = 1;
			$_SESSION['profile_id'] = $data['user_id'];
			$_SESSION['email'] = $data['user_email'];
			$user_password = $data['user_password'];
			$user_priv = $phpraid_config['default_group'];
			
			// User is all logged in and setup, the session is initialized properly.  Now we need to create the users
			//    profile in the phpRaid database if it does not already exist.
			$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "profile";
			$result = $db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
			
			while($data = $db_raid->sql_fetchrow($result)) 
			{
				if($_SESSION['profile_id'] == $data['profile_id']) 
				{
					//Profile is already created, Update email incase it doesn't match e107. 
					if($_SESSION['email'] != $data['email'])
					{
						$sql = "UPDATE " . $phpraid_config['db_prefix'] . "profile SET email='" . $_SESSION['email'] . "', password='" . $user_password . "' WHERE profile_id=" . $_SESSION['profile_id'];
						$db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
					}
					return 1;
				}
			}

			// At this point, the user is a proper user but we could not find his profile in our raid database.  Time to create it.
			$sql = "INSERT INTO " . $phpraid_config['db_prefix'] . "profile " .
					"VALUES ('" . $_SESSION['profile_id'] . "', '" . $_SESSION['email'] . "', '" . $user_password . "', '". $user_priv . "', '" . $_SESSION['username'] . "')";
			$db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
				
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
session_start();
$_SESSION['name'] = "phpRaid";

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