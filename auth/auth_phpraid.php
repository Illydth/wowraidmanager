<?php
/***************************************************************************
 *                             auth_phpraid.php
 *                            -------------------
 *   begin                : Monday, Jan 18, 2005
 *   copyright            : (C) 2005 Kyle Spraggs
 *   email                : spiffyjr@gmail.com
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
	
	$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "profile";
	$result = $db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	
	while($data = $db_raid->sql_fetchrow($result)) {
		if($username == strtolower($data['username']) && $password == $data['password']) {
			if(isset($_POST['autologin'])) {
				// they want automatic logins so set the cookie
				// set to expire in one month
				setcookie('username', $data['username'], time() + 2629743);
				setcookie('password', $data['password'], time() + 2629743);
			}
			
			// set user variables
			$_SESSION['username'] = $data['username'];
			$_SESSION['session_logged_in'] = 1;
			$_SESSION['profile_id'] = $data['profile_id'];
			$_SESSION['email'] = $data['email'];
				
			// get user permissions
			get_permissions();
				
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