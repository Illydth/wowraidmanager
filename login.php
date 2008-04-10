<?php
/***************************************************************************
 *                                login.php
 *                            -------------------
 *   begin                : Saturday, Jan 16, 2005
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
// commons
define("IN_PHPRAID", true);	
require_once('./common.php');

// page authentication
define("PAGE_LVL","anonymous");
require_once($phpraid_dir.'includes/authentication.php');

// is the user already logged in? if so, there's no need for them to login again
if($_SESSION['session_logged_in'] == 0) {
	if(isset($_POST['login'])) 	{
		$logged_in = phpraid_login();
			if($logged_in == 0)
		{
			$errorTitle = $phprlang['login_title'];
			$errorMsg = $phprlang['login_msg'];
			$errorDie = 1;
		} else { 
			header("Location: index.php");
		}
	}
} else {
	// user is already logged in
	// either they're trying to logout
	// or they shouldn't be accessing this page
	if(isset($_GET['logout'])) {
		// it would appear they're trying to logout
		phpraid_logout();
				
		header("Location: index.php");
	} else {
		// they did something wrong, let's just send them back to the mainpage
		header("Location: index.php");
	}
}

//
// Start output of page
//
require_once('includes/page_header.php');

require_once('includes/page_footer.php');
?>