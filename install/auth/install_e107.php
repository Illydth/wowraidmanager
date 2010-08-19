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
  * 	the WRM system for WRM's default authentication system.
  *
  *   Both functions below have a specific use as laid out:
  *
  *   ---step5----
  *   substep 0 - ..
  *		 - This function retrieves any system specific information that
  * 		may be needed by the installer or system later in the process.
  * 		Things like getting the base directory for the master CMS system,
  * 		getting the default admin user, or setting the table prefix for
  * 		the CMS system would be examples of information obtained here.
  *
  *   substep 'done'
  *		  - This function completes processing for the installer.  Typically
  * 		this function takes the information provided in step5 above and
  * 		processes it in some way.  Generally this means storing the various
  * 		configuration options into the config table or other processing.
  * 		NOTE: It is VASTLY important to include a piece to set the default
  * 		authentication system in the config table.  Without doing this the
  * 		system will default to WRM authentication and what you expect
  * 		to happen probably won't.  Make sure that you are updating/inserting
  * 		auth_type for the authentication type you selected in step 4.
  *
  *****************************************************************************/

 /**************************************************************************
  *   Please see the bottom of the file for documentation on userclass and
  * alt user class restrictions in step 5.
  **************************************************************************/

function step5($auth_type)
{
	//multilanguage stuff
	$lang = $_GET['lang'];
	
	if( !is_file('language/locale-'.$lang.'.php')) 
		{
			$lang ='english';//en == default language
		}
	require_once('./language/locale-'.$lang.'.php');

	global $localstr;
	$e107_config_name = 'e107_config.php';

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
		$content  = '<br>';
		$content .=  $localstr['step5e107sub1desc'].'.<br>';
		$content .=  $localstr['step5sub1follval'].'.<br>';
		$content .= '<br>------------------------------------------------------------------<br><br>';
		$content .= '<br><br>';
		$content .= '<form action="install.php?s=5&lang='.$lang.'" method="POST">';
		$content .= '<input type="hidden" name="auth_type" value="' . $auth_type . '" class="post">';
		$content .= '<input type="hidden" name="substep" value="2" class="post">';
		$content .= $localstr['step5e107sub1inputdir'].'.<br><br>';
		$content .= '<input type="text" name="e107_base_path" size="20" class="post" value="../../"><br><br>';
		$content .= '<br><br><br>';
		$content .= '<br>------------------------------------------------------------------<br>';	
		$content .= $localstr['hittingsubmit'].'.<br><br>';
		$content .= '<input type="submit" value="'.$localstr['bd_submit'].'" name="submit" class="post"></form>';

	}
	else if ($step5_substep == 2)
	{
		$e107_base_path = $_POST['e107_base_path'];
			
		// check for valid entry of previous form
		if(!is_file($e107_base_path . $e107_config_name))
		{
			echo '<font color=red>'.$localstr['step5sub2failfindfile'].' ("'.$e107_base_path.$e107_config_name.'").<br>';
			echo $localstr['step5sub2checkdir'].'<br>';
			echo $localstr['pressbrowserpack'].'</font>';
			exit;
		}
		
		require($e107_base_path.$e107_config_name);
		
		$e107_prefix = $mySQLprefix;
		
		//check if db available
		$linkDB = mysql_connect($mySQLserver,$mySQLuser,$mySQLpassword);
		if (!$linkDB) {
			echo '<font color=red>'.$localstr['step5e107failcone107'].'<br>';
			echo $localstr['problem']. mysql_error().'<br>';
			echo $localstr['pressbrowserpack'].'</font>';
			exit;
		}
		mysql_select_db($mySQLdefaultdb);
		
		// all users -> select boxes.
		$e107usernametable = '<select name="e107_useradmin_name" class="post">';

		$sql = "SELECT user_loginname, user_email FROM " . $e107_prefix . "user ORDER BY user_loginname";
		
		$result = mysql_query($sql) or die($localstr['step5e107sub3errorretusername'] . mysql_error());
		if (mysql_num_rows($result) > 0) {
			while ($data = mysql_fetch_assoc($result)) {
				$e107usernametable .= '<option value="' . $data['user_loginname']. '">' .$data['user_loginname']. ': '.$data['user_email'] . '</option>';
//				$e107_useradmin_name = $data['user_loginname'];
//				$e107_useradmin_email = $data['user_email'];
			}
		}
		$e107usernametable .= '</select>';
		
		mysql_close($linkDB);
		
		$content  = '<br>';
		$content .= '<form action="install.php?s=5&lang='.$lang.'" method="POST">';
		$content .= '<input type="hidden" name="auth_type" value="' . $auth_type . '" class="post">';
		$content .= '<input type="hidden" name="substep" value="3" class="post">';
		$content .= '<input type="hidden" name="e107_base_path" value="'.$e107_base_path.'" class="post">';
//		$content .= '<input type="hidden" name="e107_useradmin_name" value="'.$e107_useradmin_name.'" class="post">';
//		$content .= '<input type="hidden" name="e107_useradmin_email" value="'.$e107_useradmin_email.'" class="post">';
		$content .= $localstr['step5e107sub2readconffile'].': <font color=green>'.$localstr['step5done'].'</font><br>';
		$content .= '<br>------------------------------------------------------------------<br><br>';
		$content .= '<br><br>';	
		$content .= $localstr['step5sub2usernamefullperm'].'!<br><br>';		
		$content .= $e107usernametable. '<br><br>';
		$content .= $localstr['txtpassword'].':';
		$content .= '<input type="text" name="e107_useradmin_password" size="20" class="post" value=""><br><br>';
		$content .= '<br><br><br>';
		$content .= '<br>------------------------------------------------------------------<br>';	
		$content .= $localstr['hittingsubmit'].'.<br><br>';
		$content .= '<input type="submit" value="'.$localstr['bd_submit'].'" name="submit" class="post"></form>';

	}
	else if ($step5_substep == 3){
	
		$e107_base_path = $_POST['e107_base_path'];
		$e107_useradmin_name = $_POST['e107_useradmin_name'];
		$e107_useradmin_password = md5($_POST['e107_useradmin_password']);

		require($e107_base_path.$e107_config_name);
		
		$e107_prefix = $mySQLprefix;
		
		//check if db available
		$linkDB = mysql_connect($mySQLserver,$mySQLuser,$mySQLpassword);
		if (!$linkDB) {
			echo '<font color=red>'.$localstr['step5e107failcone107'].'<br>';
			echo $localstr['problem']. mysql_error().'<br>';
			echo $localstr['pressbrowserpack'].'</font>';
			exit;
		}
		mysql_select_db($mySQLdefaultdb);
		
		// Setup the e107_auth_user_class and alt_auth_userclass select boxes.
		$userclasses = '<select name="e107_auth_user_class" class="post">';
		$userclasses .= '<option value="0">'.$localstr['step5sub3norest'].'</option>';
		$altuserclass = '<select name="alt_auth_user_class" class="post">';
		$altuserclass .= '<option value="0">'.$localstr['step5sub3noaddus'].'</option>';
		
		// Get Userclasses from e107 database.
		$sql = "SELECT userclass_id, userclass_name FROM " . $e107_prefix . "userclass_classes ORDER BY userclass_id";
		$result = mysql_query($sql) or die($localstr['step5e107sub3errorretuserclass'].':' . mysql_error());
		if (mysql_num_rows($result) > 0) {
			while ($data = mysql_fetch_assoc($result)) {
				$userclasses .= '<option value="' . $data['userclass_id']. '">' . htmlentities($data['userclass_name']).'</option>';
				$altuserclass .= '<option value="' . $data['userclass_id']. '">' . htmlentities($data['userclass_name']) . '</option>';
			}
		}
		$userclasses .= '</select>';
		$altuserclass .= '</select>';
		
		$sql = sprintf("SELECT user_loginname, user_email, user_id FROM ".$e107_prefix."user WHERE user_loginname = %s", quote_smart($e107_useradmin_name));
		//echo ':datenbank:'.$mySQLdefaultdb.'::<br>::'.$sql;
		$result = mysql_query($sql) or die($localstr['step5e107sub3errorretusername'].': <br>' .$sql. '<br>'. mysql_error());
		
		$data = mysql_fetch_assoc($result);
		$e107_useradmin_email = $data['user_email'];
		$e107_useradmin_id = $data['user_id'];
		
		mysql_close($linkDB);
		
		if ($phpraid_config['db_name'] != $mySQLdefaultdb)
		{
			$e107_prefix = $mySQLdefaultdb.'.'. $e107_prefix;
		}

		global $phpraid_config;
		
		// insert the super group or update if it exists already
		$linkWRM = mysql_connect($phpraid_config['db_host'],$phpraid_config['db_user'],$phpraid_config['db_pass']);
		if (!$linkWRM) {
			echo '<font color=red>'.$localstr['step5failconWRM'].'<br>';
			echo $localstr['problem']. mysql_error().'<br>';
			echo $localstr['pressbrowserpack'].'</font>';
			exit;
		}
		mysql_select_db($phpraid_config['db_name']);

		// verified user, might as well throw him in profile now if they don't already exist
		$sql = sprintf("SELECT username FROM " . $phpraid_config['db_prefix']. "profile WHERE username = %s", quote_smart($e107_useradmin_name));
		
		$result = mysql_query($sql) or die("Error verifying " . mysql_error());
		//$sqlresultdata = mysql_fetch_assoc($result);
		
		if((mysql_num_rows($result) == 0))
		{
			$sql = "INSERT INTO " . $phpraid_config['db_prefix'] . "profile (`profile_id`,`username`,`email`,`password`,`priv`) ";
			$sql.= "VALUES('$e107_useradmin_id','$e107_useradmin_name','$e107_useradmin_email','$e107_useradmin_password','1')";
			$result = mysql_query($sql) or die("Error inserting " . mysql_error());
		}
		else
		{
			$sql = "UPDATE " . $phpraid_config['db_prefix'] . "profile SET priv='1' WHERE username='$e107_useradmin_name'";
			mysql_query($sql)or die("Error updating " . mysql_error());
		}
	
		mysql_close($linkWRM);
		

		$content  = '<form action="install.php?s=5&lang='.$lang.'" method="POST">';
		$content .= '<input type="hidden" name="auth_type" value="' . $auth_type . '" class="post">';
		$content .= '<input type="hidden" name="substep" value="done" class="post">';
		$content .= '<br>';
		$content .= $localstr['step5selctusername'].' ('.$e107_useradmin_name.'): <font color=green>'.$localstr['step5done'].'</font><br>';
		$content .= '<br>------------------------------------------------------------------<br><br>';
		$content .= $localstr['step5sub3group01'].'.<br>';
		$content .= $localstr['step5sub3group02'].'.<br>';
		$content .= $localstr['step5sub3group03'].'.<br><br>';
		$content .= $userclasses . '<br><br>';
		$content .= $localstr['step5sub3altgroup01'].'.<br>';
		$content .= $localstr['step5sub3altgroup02'].'.<br><br>';
		$content .= $altuserclass . '<br><br>';
		$content .= '<br>------------------------------------------------------------------<br><br>';	
		$content .= '<input type="hidden" name="e107_prefix" value="'. $e107_prefix .'" class="post">';
		$content .= '<input type="hidden" name="e107_base_path" value="'. $e107_base_path .'" class="post">';

		$content .= $localstr['hittingsubmit'].'<br><br>';
		$content .= '<input type="submit" value="'.$localstr['bd_submit'].'" name="submit" class="post"></form>';

	}
	else if ($step5_substep == "done"){
		$e107_base_path = $_POST['e107_base_path'];
		$e107_prefix = $_POST['e107_prefix'];
	
		$e107_auth_user_class = $_POST['e107_auth_user_class'];
		$alt_auth_user_class = $_POST['alt_auth_user_class'];
	
		// insert the super group or update if it exists already
		$linkWRM = mysql_connect($phpraid_config['db_host'],$phpraid_config['db_user'],$phpraid_config['db_pass']);
		mysql_select_db($phpraid_config['db_name']);
	
		$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "config WHERE config_name='e107_base_path'";
		$result = mysql_query($sql) or die("BOO2: ". mysql_error());
		
	
		if(mysql_num_rows($result) > 0)
		{
			// update
			$sql = sprintf("UPDATE " . $phpraid_config['db_prefix'] . "config SET config_value=%s WHERE config_name='e107_base_path'", quote_smart($e107_base_path));
			mysql_query($sql) or die("Error updateing e107_base_path in config table. " . mysql_error());
			$sql = sprintf("UPDATE " . $phpraid_config['db_prefix'] . "config SET config_value=%s WHERE config_name='e107_table_prefix'", quote_smart($e107_prefix));
			mysql_query($sql) or die("Error updateing e107_prefix in config table. " . mysql_error());
			$sql = "UPDATE " . $phpraid_config['db_prefix'] . "config SET config_value='e107' WHERE config_name='auth_type'";
			mysql_query($sql) or die("Error updateing auth_type in config table. " . mysql_error());
			$sql = sprintf("UPDATE " . $phpraid_config['db_prefix'] . "config SET config_value=%s WHERE config_name='e107_auth_user_class'", quote_smart($e107_auth_user_class));
			mysql_query($sql) or die("Error updateing e107_auth_user_class in config table. " . mysql_error());
			$sql = sprintf("UPDATE " . $phpraid_config['db_prefix'] . "config SET config_value=%s WHERE config_name='alt_auth_user_class'", quote_smart($alt_auth_user_class));
			mysql_query($sql) or die("Error updateing alt_auth_user_class in config table. " . mysql_error());			
		}
		else
		{
			// install
			$sql = "INSERT INTO " . $phpraid_config['db_prefix'] . "config VALUES('auth_type','e107')";
			mysql_query($sql);
			$sql = sprintf("INSERT INTO " . $phpraid_config['db_prefix'] . "config VALUES('e107_base_path',%s)", quote_smart($e107_base_path));
			mysql_query($sql) or die("Error inserting e107 Base Path in config table.");
			$sql = sprintf("INSERT INTO " . $phpraid_config['db_prefix'] . "config VALUES('e107_table_prefix',%s)", quote_smart($e107_prefix));
			mysql_query($sql) or die("Error inserting e107_table_prefix in config table. " . mysql_error());
			// Insert the e107_auth_user_class
			$sql = sprintf("INSERT INTO " . $phpraid_config['db_prefix'] . "config VALUES('e107_auth_user_class', %s)", quote_smart($e107_auth_user_class));
			mysql_query($sql) or die("Error inserting e107_auth_user_class in config table. " . mysql_error());
			// Insert the e107_auth_user_class
			$sql = sprintf("INSERT INTO " . $phpraid_config['db_prefix'] . "config VALUES('alt_auth_user_class', %s)", quote_smart($alt_auth_user_class));
			mysql_query($sql) or die("Error inserting alt_auth_user_class in config table. " . mysql_error());
		}
	
		mysql_close($linkWRM);
		$content  = '<br>';

		$content .= '<br>------------------------------------------------------------------<br><br>';	
		$content .= '<form action="install.php?s=done&lang='.$lang.'" method="POST">';
		$content .= '<input type="hidden" name="auth_type" value="' . $auth_type . '" class="post">';
		$content .= '<input type="hidden" name="substep" value="done" class="post">';

		$content .= $localstr['step5e107desc'] .' '. $localstr['txtconfig'];
		$content .= ': <font color=green>'.$localstr['step5done'].'</font><br><br>';
		$content .= '<input type="submit" value="'.$localstr['bd_submit'].'" name="submit" class="post"></form>';

	}
	step($localstr['menustep5confauth'].' ('.$localstr['step5e107desc'].')','lime','lime','lime','lime','red','white',$content);

	return 1;
}
dbname

/***********************************************************************************************
 * 					UserClass and Alternate User Class/Group Documentation
 *
 * 	In Step 5 of the installation you are able to select 2 values: One is described as
 * "the base user class/group that has access to use WRM" and the other is described as
 * "an alternate user class that can access WRM".  The combination of these two values
 * determines which e107 users are allowed to login to and create a profile within e107.
 *
 * The WRM e107 authentication system supports the concept of allowing only certain
 * board users to create a profile in, and thus use, WRM.  Take for example a gulid
 * that allows only it's full users to sign up for raids.  Initiates (guild applicants)
 * are not allowed to sign up for raids in this guild.  However, applicants still need to
 * have accounts on the main e107 CMS System to keep in touch with the guild members.  This
 * creates a bit of a situation: How do you allow only SOME of your e107 users to use
 * WRM while allowing others to do so?  You could simply restrict the link to the URL
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
 * WRM system.  Again, for instance in my guild, we have a "partner" guild, some members
 * of which have raided with us enough that they have permission to sign up on our raids any
 * time they wish to.  However, these people are NOT full members of my guild and thus cannot
 * be given the "TC General Member" userclass (as this controls certain forum access as well
 * that we do not wish to give access to).  As a second example we have "initiate" members
 * who have come from other guilds that have raided with us extensively.  We allow these members
 * to continue raiding with us even though normal initiates are not allowd to sign up.
 *
 * For these conditions you are able to select a secondary userclass (alternate user class) that
 * can be given to any board member to allow them to use WRM.  Note again that it is completely
 * unnecessary to give a user BOTH the userclass corresponding to the base userclass AND the
 * userclass corresponding to the alternate userclass.  One OR the other are good enough to give
 * the member access to use WRM.  Selecting "No Additional Userclass" here disables this
 * functionality.
 *
 * If you find that the vast majority of your WRM users belong to the first userclass and you
 * have a few stragglers (or none) that belong to your second userclass, you have made the proper
 * selections.
 *
 * NOTE: The userclasses that you intend to have access to WRM need to be already created
 * in e107 prior to the installation of WRM.  This system will NOT create userclasses for you.
 *
 * Any questions can be directed to douglasw0@yahoo.com.
 ************************************************************************************************/
?>