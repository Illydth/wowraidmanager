<?php
/***************************************************************************
 *                             install_smf.php
 *                            -------------------
 *   begin                : June 15, 2008
 *	 Dev                  : Carsten Hölbing
 *	 email                : hoelbin@gmx.de
 *
 *   copyright            : (C) 2007-2008 Douglas Wagner
 *   email                : douglasw0@yahoo.com
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
  *   this functions below have a specific use as laid out:
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

require_once ('../includes/functions_pwdhash.php');

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
	$smf_config_name = 'Settings.php';
	$pwd_hasher = new PasswordHash(8, FALSE);
		
	require_once('../config.php');

	$step5_substep = $_POST['substep'];

	if ($step5_substep == "")
	{
		$content  = '<br>';
		$content .=  $localstr['step5smfsub1desc'].'.<br>';
		$content .=  $localstr['step5sub1follval'].'.<br>';
		$content .= '<br>------------------------------------------------------------------<br><br>';
		$content .= '<br><br>';
		$content .= '<form action="install.php?s=5&lang='.$lang.'" method="POST">';
		$content .= '<input type="hidden" name="auth_type" value="' . $auth_type . '" class="post">';
		$content .= '<input type="hidden" name="substep" value="2" class="post">';
		$content .= $localstr['step5smfsub1inputdir'].'.<br><br>';
		$content .= '<input type="text" name="smf_base_path" size="20" class="post" value="../smf/"><br><br>';
		$content .= '<br><br><br>';
		$content .= '<br>------------------------------------------------------------------<br>';	
		$content .= $localstr['hittingsubmit'].'.<br><br>';
		$content .= '<input type="submit" value="'.$localstr['bd_submit'].'" name="submit" class="post"></form>';

	}
	else if ($step5_substep == 2)
	{
		$smf_base_path = $_POST['smf_base_path'];
			
			// check for valid entry of previous form
		if(!is_file($smf_base_path.$smf_config_name))
		{
			echo '<font color=red>'.$localstr['step5sub2failfindfile'].' ("'.$smf_root_path.$smf_config_name.'").<br>';
			echo $localstr['step5sub2checkdir'].'<br>';
			echo $localstr['pressbrowserpack'].'</font>';
			exit;
		}
		
		require($smf_base_path.$smf_config_name);
		
		$smf_prefix = $db_prefix;
		
		//check if db available
		$linkDB = mysql_connect($db_server,$db_user,$db_passwd);
		if (!$linkDB) {
			echo '<font color=red>'.$localstr['step5esmffailconesmf'].'<br>';
			echo $localstr['problem']. mysql_error().'<br>';
			echo $localstr['pressbrowserpack'].'</font>';
			exit;
		}
		mysql_select_db($db_name);
		
		// all users -> select boxes.
		$smfusernametable = '<select name="smf_useradmin_name" class="post">';

		$sql = "SELECT member_name, email_address FROM " . $smf_prefix . "members ORDER BY member_name";
		
		$result = mysql_query($sql) or die($localstr['step5smfsub3errorretusername'] . mysql_error());
		if (mysql_num_rows($result) > 0) {
			while ($data = mysql_fetch_assoc($result)) {
				$smfusernametable .= '<option value="' . $data['member_name']. '">' .$data['member_name']. ': '.$data['email_address'] . '</option>';
//				$smf_useradmin_name = $data['member_name'];
//				$smf_useradmin_email = $data['email_address'];
			}
		}
		$smfusernametable .= '</select>';
		
		mysql_close($linkDB);
		
		$content  = '<br>';
		$content .= '<form action="install.php?s=5&lang='.$lang.'" method="POST">';
		$content .= '<input type="hidden" name="auth_type" value="' . $auth_type . '" class="post">';
		$content .= '<input type="hidden" name="substep" value="3" class="post">';
		$content .= '<input type="hidden" name="smf_base_path" value="'.$smf_base_path.'" class="post">';
//		$content .= '<input type="hidden" name="smf_useradmin_name" value="'.$smf_useradmin_name.'" class="post">';
//		$content .= '<input type="hidden" name="smf_useradmin_email" value="'.$smf_useradmin_email.'" class="post">';
		$content .= $localstr['step5smfsub2readconffile'].': <font color=green>'.$localstr['step5done'].'</font><br>';
		$content .= '<br>------------------------------------------------------------------<br><br>';
		$content .= '<br><br>';	
		$content .= $localstr['step5sub2usernamefullperm'].'!<br><br>';		
		$content .= $smfusernametable. '<br><br>';
		$content .= $localstr['txtpassword'].':';
		$content .= '<input type="text" name="smf_useradmin_password" size="20" class="post" value=""><br><br>';
		$content .= '<br><br><br>';
		$content .= '<br>------------------------------------------------------------------<br>';	
		$content .= $localstr['hittingsubmit'].'.<br><br>';
		$content .= '<input type="submit" value="'.$localstr['bd_submit'].'" name="submit" class="post"></form>';

	}
	else if ($step5_substep == 3){
	
		$smf_base_path = $_POST['smf_base_path'];
		$smf_useradmin_name = $_POST['smf_useradmin_name'];
		$smf_useradmin_password = $pwd_hasher->HashPassword($_POST['smf_useradmin_password']);

		require($smf_base_path.$smf_config_name);
		
		$smf_prefix = $db_prefix;
		
		//check if db available
		$linkDB = mysql_connect($db_server,$db_user,$db_passwd);
		if (!$linkDB) {
			echo '<font color=red>'.$localstr['step5smffailconsmf'].'<br>';
			echo $localstr['problem']. mysql_error().'<br>';
			echo $localstr['pressbrowserpack'].'</font>';
			exit;
		}
		mysql_select_db($db_name);
		
		// Setup the smf_auth_user_class and smf_alt_auth_userclass select boxes.
		$userclasses = '<select name="smf_auth_user_class" class="post">';
		$userclasses .= '<option value="0">'.$localstr['step5sub3norest'].'</option>';
		$altuserclass = '<select name="smf_alt_auth_user_class" class="post">';
		$altuserclass .= '<option value="0">'.$localstr['step5sub3noaddus'].'</option>';
		
		// Get Userclasses from smf database.
		$sql = "SELECT id_group, group_name FROM " . $smf_prefix . "membergroups ORDER BY id_group";
		$result = mysql_query($sql) or die($localstr['step5smfsub3errorretuserclass'].':' . mysql_error());
		if (mysql_num_rows($result) > 0) {
			while ($data = mysql_fetch_assoc($result)) {
				$userclasses .= '<option value="' . $data['id_group']. '">' . htmlentities($data['group_name']) . '</option>';
				$altuserclass .= '<option value="' . $data['id_group']. '">' . htmlentities($data['group_name']) . '</option>';
			}
		}
		$userclasses .= '</select>';
		$altuserclass .= '</select>';
		
		$sql = sprintf("SELECT member_name, email_address, id_member FROM ".$smf_prefix."members WHERE member_name  = %s", quote_smart($smf_useradmin_name));
		//echo ':datenbank:'.$mySQLdefaultdb.'::<br>::'.$sql;
		$result = mysql_query($sql) or die($localstr['step5smfsub3errorretusername'].': <br>' .$sql. '<br>'. mysql_error());
		
		$data = mysql_fetch_assoc($result);
		$smf_useradmin_email = $data['email_address'];
		$smf_useradmin_id = $data['id_member'];
		
		mysql_close($linkDB);
		
		if ($phpraid_config['db_name'] != $db_name)
		{
			$smf_prefix = $db_name.'.'. $smf_prefix;
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
		$sql = sprintf("SELECT username FROM " . $phpraid_config['db_prefix']. "profile WHERE username = %s", quote_smart($smf_useradmin_name));
		
		$result = mysql_query($sql) or die("Error verifying " . mysql_error());
		//$sqlresultdata = mysql_fetch_assoc($result);
		
		if((mysql_num_rows($result) == 0))
		{
			$sql = sprintf("INSERT INTO " . $phpraid_config['db_prefix'] . "profile (`profile_id`,`username`,`email`,`password`,`priv`) " .
							"VALUES(%s,%s,%s,%s,'1')", quote_smart($smf_useradmin_id), quote_smart($smf_useradmin_name), 
							quote_smart($smf_useradmin_email), quote_smart($smf_useradmin_password));
			$result = mysql_query($sql) or die("Error inserting " . mysql_error());
		}
		else
		{
			$sql = sprintf("UPDATE " . $phpraid_config['db_prefix'] . "profile SET priv='1' WHERE username=%s", quote_smart($smf_useradmin_name));
			mysql_query($sql)or die("Error updating " . mysql_error());
		}
	
		mysql_close($linkWRM);
		

		$content  = '<form action="install.php?s=5&lang='.$lang.'" method="POST">';
		$content .= '<input type="hidden" name="auth_type" value="' . $auth_type . '" class="post">';
		$content .= '<input type="hidden" name="substep" value="done" class="post">';
		$content .= '<br>';
		$content .= $localstr['step5selctusername'].' ('.$smf_useradmin_name.'): <font color=green>'.$localstr['step5done'].'</font><br>';
		$content .= '<br>------------------------------------------------------------------<br><br>';
		$content .= $localstr['step5sub3group01'].'.<br>';
		$content .= $localstr['step5sub3group02'].'.<br>';
		$content .= $localstr['step5sub3group03'].'.<br><br>';
		$content .= $userclasses . '<br><br>';
		$content .= $localstr['step5sub3altgroup01'].'.<br>';
		$content .= $localstr['step5sub3altgroup02'].'.<br><br>';
		$content .= $altuserclass . '<br><br>';
		$content .= '<br>------------------------------------------------------------------<br><br>';	
		$content .= '<input type="hidden" name="smf_prefix" value="'. $smf_prefix .'" class="post">';
		$content .= '<input type="hidden" name="smf_base_path" value="'. $smf_base_path .'" class="post">';

		$content .= $localstr['hittingsubmit'].'<br><br>';
		$content .= '<input type="submit" value="'.$localstr['bd_submit'].'" name="submit" class="post"></form>';

	}
	else if ($step5_substep == "done"){
		$smf_base_path = $_POST['smf_base_path'];
		$smf_prefix = $_POST['smf_prefix'];
	
		$smf_auth_user_class = $_POST['smf_auth_user_class'];
		$smf_alt_auth_user_class = $_POST['smf_alt_auth_user_class'];
	
		// insert the super group or update if it exists already
		$linkWRM = mysql_connect($phpraid_config['db_host'],$phpraid_config['db_user'],$phpraid_config['db_pass']);
		mysql_select_db($phpraid_config['db_name']);
	
		$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "config WHERE config_name='smf_base_path'";
		$result = mysql_query($sql) or die("BOO2: ". mysql_error());
		
	
		if(mysql_num_rows($result) > 0)
		{
			// update
			$sql = sprintf("UPDATE " . $phpraid_config['db_prefix'] . "config SET config_value=%s WHERE config_name='smf_base_path'", quote_smart($smf_base_path));
			mysql_query($sql) or die("Error updateing smf_base_path in config table. " . mysql_error());
			
			$sql = sprintf("UPDATE " . $phpraid_config['db_prefix'] . "config SET config_value=%s WHERE config_name='smf_table_prefix'", quote_smart($smf_prefix));
			mysql_query($sql) or die("Error updateing smf_prefix in config table. " . mysql_error());
			
			$sql = "UPDATE " . $phpraid_config['db_prefix'] . "config SET config_value='smf2' WHERE config_name='auth_type'";
			mysql_query($sql) or die("Error updateing auth_type in config table. " . mysql_error());
			
			$sql = sprintf("UPDATE " . $phpraid_config['db_prefix'] . "config SET config_value=%s WHERE config_name='smf_auth_user_class'", quote_smart($smf_auth_user_class));
			mysql_query($sql) or die("Error updateing smf_auth_user_class in config table. " . mysql_error());
			
			$sql = sprintf("UPDATE " . $phpraid_config['db_prefix'] . "config SET config_value=%s WHERE config_name='smf_alt_auth_user_class'", quote_smart($smf_alt_auth_user_class));
			mysql_query($sql) or die("Error updateing smf_alt_auth_user_class in config table. " . mysql_error());			
		}
		else
		{
			// install
			$sql = "INSERT INTO " . $phpraid_config['db_prefix'] . "config VALUES('auth_type','smf2')";
			mysql_query($sql);
			$sql = sprintf("INSERT INTO " . $phpraid_config['db_prefix'] . "config VALUES('smf_base_path',%s)", quote_smart($smf_base_path));
			mysql_query($sql) or die("BOO5");
			$sql = sprintf("INSERT INTO " . $phpraid_config['db_prefix'] . "config VALUES('smf_table_prefix',%s)", quote_smart($smf_prefix));
			mysql_query($sql) or die("Error inserting smf_table_prefix in config table. " . mysql_error());
			// Insert the smf_auth_user_class
			$sql = sprintf("INSERT INTO " . $phpraid_config['db_prefix'] . "config VALUES('smf_auth_user_class', %s)", quote_smart($smf_auth_user_class));
			mysql_query($sql) or die("Error inserting smf_auth_user_class in config table. " . mysql_error());		
			// Insert the smf_auth_user_class
			$sql = sprintf("INSERT INTO " . $phpraid_config['db_prefix'] . "config VALUES('smf_alt_auth_user_class', %s)", quote_smart($smf_alt_auth_user_class));
			mysql_query($sql) or die("Error inserting smf_alt_auth_user_class in config table. " . mysql_error());
		}
	
		mysql_close($linkWRM);
		$content  = '<br>';

		$content .= '<br>------------------------------------------------------------------<br><br>';	
		$content .= '<form action="install.php?s=done&lang='.$lang.'" method="POST">';
		$content .= '<input type="hidden" name="auth_type" value="' . $auth_type . '" class="post">';
		$content .= '<input type="hidden" name="substep" value="done" class="post">';

		$content .= $localstr['step5smfdesc'] .' '. $localstr['txtconfig'];
		$content .= ': <font color=green>'.$localstr['step5done'].'</font><br><br>';
		$content .= '<input type="submit" value="'.$localstr['bd_submit'].'" name="submit" class="post"></form>';

	}
	step($localstr['menustep5confauth'].' ('.$localstr['step5smfdesc'].')','lime','lime','lime','lime','red','white',$content);

	return 1;
}


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