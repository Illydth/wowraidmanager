<?php

/***************************************************************************
 *                             install_phpbb.php
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

	$content = 'You have selected phpBB authentication. In order to complete the installation please fill in the following values.<br><br>
						<br>';

	$content .= '<form action="install.php?s=done" method="POST">';
	$content .= '<input type="hidden" name="auth_type" value="' . $auth_type . '" class="post">';
	$content .= 'Fill in your phpBB username. This username will be given full phpRaid permissions!<br><br>';
	$content .= '<input type="text" name="username" size="20" class="post"><br><br>';
	$content .= 'For verification purposes, enter the e-mail address associated with above account.<br><br>';
	$content .= '<input type="text" name="email" size="20" class="post"><br><br>';
	$content .= 'Input the relative path to your phpBB directory (including trailing slash!)<br><br>';
	$content .= '<input type="text" name="phpbb_root_path" size="20" class="post" value="../phpBB2/"><br><br>';
	$content .= 'Finally, input the prefix to your phpBB tables<br><br>';
	$content .= '<input type="text" name="phpbb_prefix" size="20" class="post" value="phpbb_"><br><br>';
	$content .= 'Verify the above information before hitting submit!<br><br>';
	$content .= '<input type="submit" value="Submit" name="submit" class="post"></form>';

	step('Step 5: Finalize','lime','lime','lime','lime','red',$content);

	return 1;
}

function done()
{
	$username = $_POST['username'];
	$phpbb_root_path = $_POST['phpbb_root_path'];
	$phpbb_prefix = $_POST['phpbb_prefix'];
	$email = $_POST['email'];

	// check for valid entry of previous form
	if(!is_file('../'.$phpbb_root_path.'config.php'))
	{
		echo '<font color=red>Failed to find phpBB config file.<br> Use your browsers BACK button and input proper data.</font>';
		exit;
	}

	require('../'.$phpbb_root_path.'config.php');

	// now that we have phpBB information connect to database and verify user
	$link = mysql_connect($dbhost,$dbuser,$dbpasswd);
	mysql_select_db($dbname);

	$sql = "SELECT * FROM " . $phpbb_prefix . "users WHERE username='$username' AND user_email='$email'";
	$result = mysql_query($sql) or die(mysql_error());

	if(mysql_num_rows($result) == 0)
	{
		// they did something wrong, let them know
		echo '<font color=red>Failed to find user in phpBB tables with username and email specified.<br>Use your browsers BACK button to input proper data.</font>';
		mysql_close($link);
		exit;
	}

	// CHECK, grab necessary values
	$data = mysql_fetch_array($result);

	$username = $data['username'];
	$email = $data['user_email'];
	$profile_id = $data['user_id'];
	$priv = 1;

	mysql_close($link);

	require_once('../config.php');

	// insert the super group or update if it exists already
	$link = mysql_connect($phpraid_config['db_host'],$phpraid_config['db_user'],$phpraid_config['db_pass']);
	mysql_select_db($phpraid_config['db_name']);

	// verified user, might as well throw him in profile now if they don't already exist
	$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "profile WHERE username='$username'";
	$result = mysql_query($sql) or die("Error verifying " . mysql_error());

	if(mysql_num_rows($result) == 0)
	{
		$sql = "INSERT INTO " . $phpraid_config['db_prefix'] . "profile (`profile_id`, `username`, `email`, `priv`) VALUES('$profile_id','$username','$email','1')";
		$result = mysql_query($sql) or die("Error inserting " . mysql_error());
	}
	else
	{
		$sql = "UPDATE " . $phpraid_config['db_prefix'] . "profile SET priv='1' WHERE username='$username'";
		mysql_query($sql);
	}

	$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "config WHERE config_name='phpbb_root_path'";
	$result = mysql_query($sql) or die("BOO2");

	if(mysql_num_rows($result) > 0)
	{
		// update
		$sql = "UPDATE " . $phpraid_config['db_prefix'] . "config SET config_value='$phpbb_root_path' WHERE config_name='phpbb_root_path'";
		mysql_query($sql) or die("BOO3");
		$sql = "UPDATE " . $phpraid_config['db_prefix'] . "config SET config_value='$phpbb_prefix' WHERE config_name='phpbb_prefix'";
		mysql_query($sql) or die("BOO4");
		$sql = "UPDATE " . $phpraid_config['db_prefix'] . "config SET config_value='phpbb' WHERE config_name='auth_type'";
		mysql_query($sql) or die("BOO4");
	}
	else
	{
		// install
		$sql = "INSERT INTO " . $phpraid_config['db_prefix'] . "config VALUES('auth_type','phpbb')";
		mysql_query($sql);
		$sql = "INSERT INTO " . $phpraid_config['db_prefix'] . "config VALUES('phpbb_root_path','$phpbb_root_path')";
		mysql_query($sql) or die("BOO5");
		$sql = "INSERT INTO " . $phpraid_config['db_prefix'] . "config VALUES('phpbb_prefix','$phpbb_prefix')";
		mysql_query($sql) or die("BOO6");
	}

	mysql_close($link);

	$content = 'Setup is now complete. Be sure to remove the install/ directory and click <a href="../index.php">here</a> when you have done so.';

	step('Finished!','lime','lime','lime','lime','lime',$content);

	return 1;

}


?>