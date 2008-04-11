<?php

/***************************************************************************
 *                            install_phpraid.php
 *                            -------------------
 *   begin                : Tuesday, June 20, 2007
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

 /**************************************************************************
  *
  *   The functions in this file serve the installer to specifically configure
  * 	the phpraid system for phpraid's default authentication system.
  *
  *   Both functions below have a specific use as laid out:
  *
  *   step5 - This function retrieves any system specific information that
  * 		may be needed by the installer or system later in the process.
  * 		Things like getting the base directory for the master CMS system,
  * 		getting the default admin user, or setting the table prefix for
  * 		the CMS system would be examples of information obtained here.
  *
  *   done - This function completes processing for the installer.  Typically
  * 		this function takes the information provided in step5 above and
  * 		processes it in some way.  Generally this means storing the various
  * 		configuration options into the config table or other processing.
  * 		NOTE: It is VASTLY important to include a piece to set the default
  * 		authentication system in the config table.  Without doing this the
  * 		system will default to phpraid authentication and what you expect
  * 		to happen probably won't.  Make sure that you are updating/inserting
  * 		auth_type for the authentication type you selected in step 4.
  *
  *****************************************************************************/


function step5($auth_type)
{
	require_once('../config.php');

	echo "We are on Step 5.";
	// if profile information exists no need to recreate superuser or modify database
	$link = mysql_connect($phpraid_config['db_host'],$phpraid_config['db_user'],$phpraid_config['db_pass']);
	mysql_select_db($phpraid_config['db_name']);

	// force update of auth_type
	$sql = "UPDATE " . $phpraid_config['db_prefix'] . "config SET config_value='phpraid' WHERE config_name='auth_type'";
	mysql_query($sql);

	// set new permission type
	$sql = "UPDATE " . $phpraid_config['db_prefix'] . "profile SET priv='1' WHERE priv='superadmin'";
	mysql_query($sql);

	$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "profile";
	$result = mysql_query($sql) or die("boooooo");

	if(mysql_num_rows($result) > 0)
		$exit = 1;

	if($exit == 1)
	{
		mysql_close($link);
		$content = 'Setup is now complete. Be sure to remove the install/ directory and click <a href="../index.php">here</a> when you have done so.';

		step('Finished!','lime','lime','lime','lime','lime',$content);
		exit;
	}

	$content = 'You have selected phpRaid authentcation. All that is left is to enter your Super Administrator information by filling out the information below.<br><br>';
	$content .= '<form action="install.php?s=done" method="POST">';
	$content .= '<input type="hidden" name="auth_type" value="phpraid" class="post">';
	$content .= '<table width="100%" cellpadding="0" cellspacing="0" border="0">';
	$content .= '<tr><td width="25%"><div align="right" style="font-size:11px; color:white">Username:</td><td width="75%"><input type="text" name="username" class="post"></td></tr>';
	$content .= '<tr><td><div align="right" style="font-size:11px; color:white">Password:</td><td><input type="text" name="password" class="post"></td></tr>';
	$content .= '<tr><td><div align="right" style="font-size:11px; color:white">E-mail:</td><td><input type="text" name="email" class="post"></td></tr>';
	$content .= '</table>';
	$content .= '<br><br><div align="center"><strong>Please verify all information before hitting submit! Failure to do so could cause unforseen failure and support will not be given!</strong>';
	$content .= '<br><br><input type="submit" value="continue" class="mainoption">';

	step('Step 5: Finalize','lime','lime','lime','lime','red',$content);

	return 1;

}

function done($auth_type)
{
	require_once('../config.php');

	$email = $_POST['email'];
	$user = $_POST['username'];
	$pass = md5($_POST['password']);

	$link = mysql_connect($phpraid_config['db_host'],$phpraid_config['db_user'],$phpraid_config['db_pass']);
	mysql_select_db($phpraid_config['db_name']);
	mysql_query("INSERT INTO " . $phpraid_config['db_prefix'] . "profile VALUES('0','$email','$pass','1','$user')") or die(mysql_error());
	$sql = "INSERT INTO " . $phpraid_config['db_prefix'] . "config VALUES('auth_type','" . $auth_type . "')";
	mysql_query($sql) or die("Error inserting auth_type phpRaid in config table");
	mysql_close($link);

	$content = 'Setup is now complete. Be sure to remove the install/ directory and click <a href="../index.php">here</a> when you have done so.';
	step('Finished!','lime','lime','lime','lime','lime',$content);

	return 1;
}

?>