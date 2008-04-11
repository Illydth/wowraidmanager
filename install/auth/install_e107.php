<?php

/***************************************************************************
 *                             install_e107.php
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

 /**************************************************************************
  *   Please see the bottom of the file for documentation on userclass and
  * alt user class restrictions in step 5.
  **************************************************************************/

function step5($auth_type) {

	require_once('../config.php');

	// Step 5 needs to be broken up into at least a couple steps.  First we need to get information
	//   about the e107 installation (the table prefix, etc.) before we can actually prompt for the
	//   phpraid information we really need.

	$step5_substep = $_POST['substep'];

	// The "if" block below allows us to add screens to the configuration of phpRaid.  In this case,
	//   I needed to get the information for the table prefixes so that I could build a dropdown
	//   of userclasses, however that requires 2 screens, since we don't want to modify install.php
	//   we have added a mechanism to add additional screens to phpRaid's setup.
	//
	// The important value here is the hidden box "substep" which contains value of the **next**
	//   step in the process.  If we wanted to add another screen (Step 5.3) in 5.2's content we'd
	//   add another hidden box called substep with the value 3 in it. Form action for all but the
	//   last step should be install.php?s=5 (i.e. we're recalling step 5 over and over and over
	//   again and letting the if inside step5 function handle which screen to print based upon
	//   the value of the "substep" box.)
	//
	// Note the first call to "step5" does not have a "substep" and thus the check for the first
	//   screen is always for a NULL value.

	if ($step5_substep == "")
	{
		//*****************************************************
		//						Step 5.1
		//*****************************************************
		$content = 'You have selected e107 authentication. In order to complete the installation please fill in the following values.<br><br>
							<br>';
		$content .= '<form action="install.php?s=5" method="POST">';
		$content .= '<input type="hidden" name="auth_type" value="' . $auth_type . '" class="post">';
		$content .= '<input type="hidden" name="substep" value="2" class="post">';
		$content .= 'Please input the path and filename to your e107_config.php file<br><br>';
		$content .= '<input type="text" name="e107_base_path" size="20" class="post" value="../../e107_config.php"><br><br>';
		$content .= 'Finally, input the prefix to your e107 tables<br><br>';
		$content .= '<input type="text" name="e107_table_prefix" size="20" class="post" value="e107_"><br><br>';
		$content .= 'Verify the above information before hitting submit!<br><br>';
		$content .= '<input type="submit" value="Submit" name="submit" class="post"></form>';
	}
	else //if ($step_substep == 2)
	{
		//******************************************************
		// 						Step 5.2
		//******************************************************
		// Now that we have the Table prefix, we can get the appropriate user groups out of the e107
		//   tables.
		$e107_table_prefix = $_POST['e107_table_prefix'];

		// Make connnection to e107 DB.
		$link = mysql_connect($phpraid_config['db_host'],$phpraid_config['db_user'],$phpraid_config['db_pass']);
		mysql_select_db($phpraid_config['db_name']);

		// Setup the e107_auth_user_class and alt_auth_userclass select boxes.
		$userclasses = '<select name="e107_auth_user_class" class="post">';
		$userclasses .= '<option value="0">No Restrictions</option>';
		$altuserclass = '<select name="alt_auth_user_class" class="post">';
		$altuserclass .= '<option value="0">No Additional Userclass</option>';

			// Get Userclasses from e107 database.
		$sql = "SELECT userclass_id, userclass_name FROM " . $e107_table_prefix . "userclass_classes ORDER BY userclass_id";
		$result = mysql_query($sql) or die("Error retrieving userclasses from e107: " . mysql_error());
		if (mysql_num_rows($result) > 0) {
			while ($data = mysql_fetch_assoc($result)) {
				$userclasses .= '<option value="' . $data['userclass_id']. '">' . $data['userclass_name'] . '</option>';
				$altuserclass .= '<option value="' . $data['userclass_id']. '">' . $data['userclass_name'] . '</option>';
			}
		}
		$userclasses .= '</select>';
		$altuserclass .= '</select>';

		mysql_close($link);

		$content = 'You have selected e107 authentication. In order to complete the installation please fill in the following values.<br><br>
							<br>';

		$content .= '<form action="install.php?s=done" method="POST">';
		$content .= '<input type="hidden" name="auth_type" value="' . $auth_type . '" class="post">';
		$content .= '<input type="hidden" name="e107_base_path" value="' . $_POST['e107_base_path'] . '" class="post">';
		$content .= '<input type="hidden" name="e107_table_prefix" value="' . $_POST['e107_table_prefix'] . '" class="post">';
		$content .= 'Fill in your e107 username. This username will be given full phpRaid permissions!<br	><br>';
		$content .= '<input type="text" name="username" size="20" class="post"><br><br>';
		$content .= 'For verification purposes, enter the e-mail address associated with above account.<br><br>';
		$content .= '<input type="text" name="email" size="20" class="post"><br><br>';
		$content .= 'Select the base user class that has access to use phpRaid.<br>Any user without this e107 class set will not be allowed to log in.<br>Please select "No Restrictios" here if you want all users regardless of class to be able to login to phpRaid.<br><br>';
		$content .= $userclasses . '<br><br>';
		$content .= 'Select an alternate user class that can access phpRaid.<br>Any user tagged with this class will be allowed to log in regardless of whether they are in the above user class or not.  See documentation in install_e107.php for more info.<br><br>';
		$content .= $altuserclass . '<br><br>';
		$content .= 'Verify the above information before hitting submit!<br><br>';
		$content .= '<input type="submit" value="Submit" name="submit" class="post"></form>';
	}

	step('Step 5: Finalize','lime','lime','lime','lime','red',$content);

	return 1;
}

function done($auth_type)
{
	require_once('../config.php');

	$email = $_POST['email'];
	$user = $_POST['username'];
	$pass = "junkpass";

	$link = mysql_connect($phpraid_config['db_host'],$phpraid_config['db_user'],$phpraid_config['db_pass']);
	mysql_select_db($phpraid_config['db_name']);

	// Insert a value for the Admin Profile.
	mysql_query("INSERT INTO " . $phpraid_config['db_prefix'] . "profile VALUES('0','$email','$pass','1','$user')") or die(mysql_error());

	// Insert the auth_type.
	$sql = "INSERT INTO " . $phpraid_config['db_prefix'] . "config VALUES('auth_type','e107')";
	mysql_query($sql) or die("Error inserting auth_type e107 in config table");

	// Insert the e107 table prefix
	$sql = "INSERT INTO " . $phpraid_config['db_prefix'] . "config VALUES('e107_table_prefix', '" . $_POST['e107_table_prefix'] . "')";
	mysql_query($sql) or die("Error inserting e107_table_prefix in config table");

	// Insert the e107_auth_user_class
	$sql = "INSERT INTO " . $phpraid_config['db_prefix'] . "config VALUES('e107_auth_user_class', '" . $_POST['e107_auth_user_class'] . "')";
	mysql_query($sql) or die("Error inserting e107_auth_user_class in config table");

	// Insert the e107_auth_user_class
	$sql = "INSERT INTO " . $phpraid_config['db_prefix'] . "config VALUES('alt_auth_user_class', '" . $_POST['alt_auth_user_class'] . "')";
	mysql_query($sql) or die("Error inserting alt_auth_user_class in config table");

	mysql_close($link);

	$content = 'Setup is now complete. Be sure to remove the install/ directory and click <a href="../index.php">here</a> when you have done so.';

	step('Finished!','lime','lime','lime','lime','lime',$content);

	return 1;
}

/***********************************************************************************************
 * 					UserClass and Alternate User Class Documentation
 *
 * 	In Step 5 of the installation you are able to select 2 values: One is described as
 * "the base user class that has access to use phpRaid" and the other is described as
 * "an alternate user class that can access phpRaid".  The combination of these two values
 * determines which e107 users are allowed to login to and create a profile within e107.
 *
 * The phpRaid e107 authentication system supports the concept of allowing only certain
 * board users to create a profile in, and thus use, phpRaid.  Take for example a gulid
 * that allows only it's full users to sign up for raids.  Initiates (guild applicants)
 * are not allowed to sign up for raids in this guild.  However, applicants still need to
 * have accounts on the main e107 CMS System to keep in touch with the guild members.  This
 * creates a bit of a situation: How do you allow only SOME of your e107 users to use
 * phpRaid while allowing others to do so?  You could simply restrict the link to the URL
 * to only those board users you want to see the raid system.  However this doesn't stop
 * users from "determining" the direct address for the raid system and going to it and
 * creating a profile (security by obscurity isn't really security).  It's also nice to allow
 * the entire guild to see what raids the guild is going on, even if they're not allowed to
 * sign up (gives a means of determining how active a guild is for an applicant).
 *
 * To allow this we have 2 user classes available:  The first is the base board userclass
 * that allows basic access.  If only your "full" guild members are allowed to use the
 * raid system, select the user class that corresponds to the definition of a "full" guild
 * member.  In my guild this equates to "TC General Member", all full guild members are a
 * member of this usergroup.  I would then select "TC General Member" from the dropdown
 * list under "base user class" in Step 5 of the install.  Selecting "No Restrictions" here
 * disables the check for userclass and allows anyone with an e107 account on your board to
 * create characters and sign up for raids in your system.
 *
 * NOTE: If "No Restrictions" is selected here, whatever you select below in the "alternate
 * user class" has no meaning and isn't used.
 *
 * The second dropdown allows you to add "additional" members that are allowed to access the
 * phpRaid system.  Again, for instance in my guild, we have a "partner" guild, some members
 * of which have raided with us enough that they have permission to sign up on our raids any
 * time they wish to.  However, these people are NOT full members of my guild and thus cannot
 * be given the "TC General Member" userclass (as this controls certain forum access as well
 * that we do not wish to give access to).  As a second example we have "initiate" members
 * who have come from other guilds that have raided with us extensively.  We allow these members
 * to continue raiding with us even though normal initiates are not allowd to sign up.
 *
 * For these conditions you are able to select a secondary userclass (alternate user class) that
 * can be given to any board member to allow them to use phpRaid.  Note again that it is completely
 * unnecessary to give a user BOTH the userclass corresponding to the base userclass AND the
 * userclass corresponding to the alternate userclass.  One OR the other are good enough to give
 * the member access to use phpRaid.  Selecting "No Additional Userclass" here disables this
 * functionality.
 *
 * If you find that the vast majority of your phpRaid users belong to the first userclass and you
 * have a few stragglers (or none) that belong to your second userclass, you have made the proper
 * selections.
 *
 * NOTE: The userclasses that you intend to have access to phpRaid need to be already created
 * in e107 prior to the installation of phpRaid.  This system will NOT create userclasses for you.
 *
 * Any questions can be directed to douglasw0@yahoo.com.
 ************************************************************************************************/
?>