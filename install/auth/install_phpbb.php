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
Version 2.0 (Neme aka Carsten Hoelbing)
- bugfix
- multi. Lang
- ..

Version 1.1 (Neme aka Carsten Hoelbing)
- new funtion: import user
- insert substep (base on idea from e107(auth mod))
- bugfix

Version 1.0 (Neme aka Carsten Hoelbing)
- it is done and work :-)
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
  /*
  * New (Version 1.1)
  * function importUserfromDB($phpbb_root_path, $phpbb_prefix, $phpraid_config)
  *	- read user(user_id, username, email) from phpbb3 forum and write into WRM
  *****************************************************************************/

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
	$phpBB_config_name = 'config.php';
		
	require_once('../config.php');

	$step5_substep = $_POST['substep'];

	if ($step5_substep == "")
	{
		$content  = '<br>';
		$content .=  $localstr['step5phpBBsub1desc'].'.<br>';
		$content .=  $localstr['step5sub1follval'].'.<br>';
		$content .= '<br>------------------------------------------------------------------<br><br>';
		$content .= '<br><br>';
		$content .= '<form action="install.php?s=5&lang='.$lang.'" method="POST">';
		$content .= '<input type="hidden" name="auth_type" value="' . $auth_type . '" class="post">';
		$content .= '<input type="hidden" name="substep" value="2" class="post">';
		$content .= $localstr['step5phpBBsub1inputdir'].'.<br><br>';
		$content .= '<input type="text" name="phpbb_root_path" size="20" class="post" value="../phpBB/"><br><br>';
		$content .= '<br><br><br>';
		$content .= '<br>------------------------------------------------------------------<br>';	
		$content .= $localstr['hittingsubmit'].'.<br><br>';
		$content .= '<input type="submit" value="'.$localstr['bd_submit'].'" name="submit" class="post"></form>';

	}
	else if ($step5_substep == 2)
	{
		$phpbb_root_path = $_POST['phpbb_root_path'];
		$phpbbversioncheck = $_POST['phpbbversioncheck'];
			
			// check for valid entry of previous form
		if(!is_file($phpbb_root_path.$phpBB_config_name))
		{
			echo '<font color=red>'.$localstr['step5sub2failfindfile'].' ("'.$phpbb_root_path.$phpBB_config_name.'").<br>';
			echo $localstr['step5sub2checkdir'].'<br>';
			echo $localstr['pressbrowserpack'].'</font>';
			exit;
		}
		
		//check if phpbb == phpBB2
		if(is_file($phpbb_root_path.'extension.inc'))
		{
			$phpbbversioncheck = 2;
		}
		else {
			if(!is_file('../auth/auth_phpbb3.php'))
			{
				echo '<font color=red>'.$localstr['step5phpBBsub2failfindautfile'].'<br>';
				echo $localstr['step5phpBBsub2faildownautfile'].'</font>';
				die();
			}
			$phpbbversioncheck = 3;
		}
		
		require($phpbb_root_path.$phpBB_config_name);
		
		$phpbb_prefix=$table_prefix;
		
		//check if db available
		$linkDB = mysql_connect($dbhost,$dbuser,$dbpasswd);
		if (!$linkDB) {
			echo '<font color=red>'.$localstr['step5phpBBfailconphpBB'].'<br>';
			echo $localstr['problem']. mysql_error().'<br>';
			echo $localstr['pressbrowserpack'].'</font>';
			exit;
		}
		mysql_select_db($dbname);
		
		// all phpBB3 users -> select boxes.
		$phpBB3usernametable = '<select name="phpbb_useradmin_name" class="post">';
		
		//standart/default bots, in phpbb3, have not a email adress
		$sql = "SELECT username, user_email FROM " . $phpbb_prefix . "users WHERE user_email <> '' ORDER BY username";
		
		$result = mysql_query($sql) or die($localstr['step5phpBBsub3errorretusername'] . mysql_error());
		if (mysql_num_rows($result) > 0) {
			while ($data = mysql_fetch_assoc($result)) {
				$phpBB3usernametable .= '<option value="' . $data['username']. '">' .$data['username']. ': '.$data['user_email'] . '</option>';
//				$phpbb_useradmin_name = $data['username'];
//				$phpbb_useradmin_email = $data['user_email'];
			}
		}
		$phpBB3usernametable .= '</select>';
		
		mysql_close($linkDB);
		
		$content  = '<br>';
		$content .= '<form action="install.php?s=5&lang='.$lang.'" method="POST">';
		$content .= '<input type="hidden" name="auth_type" value="' . $auth_type . '" class="post">';
		$content .= '<input type="hidden" name="substep" value="3" class="post">';
		$content .= '<input type="hidden" name="phpbb_root_path" value="'.$phpbb_root_path.'" class="post">';
//		$content .= '<input type="hidden" name="phpbb_useradmin_name" value="'.$phpbb_useradmin_name.'" class="post">';
//		$content .= '<input type="hidden" name="phpbb_useradmin_email" value="'.$phpbb_useradmin_email.'" class="post">';
		$content .= '<input type="hidden" name="phpbbversioncheck" value="'.$phpbbversioncheck.'" class="post">';
		$content .= $localstr['step5phpBBsub2founddb'].' <font color=green></font> Version: phpBB'.$phpbbversioncheck.'<br>';
		$content .= $localstr['step5phpBBsub2readconffile'].': <font color=green>'.$localstr['step5done'].'</font><br>';
		$content .= '<br>------------------------------------------------------------------<br><br>';
		$content .= '<br><br>';	
		$content .= $localstr['step5sub2usernamefullperm'].'!<br><br>';	
		$content .= $phpBB3usernametable. '<br><br>';
		$content .= '<br><br><br>';
		$content .= '<br>------------------------------------------------------------------<br>';	
		$content .= $localstr['hittingsubmit'].'.<br><br>';
		$content .= '<input type="submit" value="'.$localstr['bd_submit'].'" name="submit" class="post"></form>';

	}
	else if ($step5_substep == 3){
	
		$phpbb_root_path = $_POST['phpbb_root_path'];
		$phpbb_useradmin_name = $_POST['phpbb_useradmin_name'];
		$phpbbversioncheck = $_POST['phpbbversioncheck'];

		//need user_email, user_id
		require($phpbb_root_path.$phpBB_config_name);
		
		$phpbb_prefix = $table_prefix;
		
		$linkDB = mysql_connect($dbhost,$dbuser,$dbpasswd);
		if (!$linkDB) {
			echo '<font color=red>'.$localstr['step5phpBBfailconphpBB'].'<br>';
			echo $localstr['problem']. mysql_error().'<br>';
			echo $localstr['pressbrowserpack'].'</font>';
			exit;
		}
		mysql_select_db($dbname);
		
			// Setup the phpBB_auth_user_class and phpBB_alt_auth_user_class select boxes.
		$userclasses = '<select name="phpBB_auth_user_class" class="post">';
		$userclasses .= '<option value="0">'.$localstr['step5sub3norest'].'</option>';
		$altuserclass = '<select name="phpBB_alt_auth_user_class" class="post">';
		$altuserclass .= '<option value="0">'.$localstr['step5sub3noaddus'].'</option>';
		
		// Get Usergroups from phpBB database.
		$sql = "SELECT group_id, group_name FROM " . $phpbb_prefix . "groups ORDER BY group_id";
		$result = mysql_query($sql) or die($localstr['step5phpBBsub3errorretusergroup'].':' . mysql_error());
		if (mysql_num_rows($result) > 0) {
			while ($data = mysql_fetch_assoc($result)) {
				$userclasses .= '<option value="' . $data['group_id']. '">' . htmlentities($data['group_name']) . '</option>';
				$altuserclass .= '<option value="' . $data['group_id']. '">' . htmlentities($data['group_name']) . '</option>';
			}
		}
		$userclasses .= '</select>';
		$altuserclass .= '</select>';
		
		$sql = sprintf("SELECT username, user_email, user_id FROM " . $phpbb_prefix . "users WHERE username = %s", quote_smart($phpbb_useradmin_name));
		$result = mysql_query($sql) or die($localstr['step5phpBBsub3errorretusername'].': <br>'. $sql. '<br>'. mysql_error());
		$data = mysql_fetch_assoc($result);
		$phpbb_useradmin_email = $data['user_email'];
		$phpbb_useradmin_id = $data['user_id'];
		
		mysql_close($linkDB);
		
		if ($phpraid_config['db_name'] != $dbname)
		{
			$phpbb_prefix = $dbname.'.'. $phpbb_prefix;
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
		$sql = sprintf("SELECT username FROM " . $phpraid_config['db_prefix']. "profile WHERE username = %s", quote_smart($phpbb_useradmin_name));
		
		$result = mysql_query($sql) or die("Error verifying " . mysql_error());
		//$sqlresultdata = mysql_fetch_assoc($result);
		
		if((mysql_num_rows($result) == 0))
		{
			$sql = sprintf("INSERT INTO " . $phpraid_config['db_prefix'] . "profile (`profile_id`, `username`, `email`, `priv`) " .
							"VALUES(%s,%s,%s,'1')", quote_smart($phpbb_useradmin_id), quote_smart($phpbb_useradmin_name), 
							quote_smart($phpbb_useradmin_email));
			$result = mysql_query($sql) or die("Error inserting " . mysql_error());
		}
		else
		{
			$sql = sprintf("UPDATE " . $phpraid_config['db_prefix'] . "profile SET priv='1' WHERE username=%s", quote_smart($phpbb_useradmin_name));
			mysql_query($sql)or die("Error updating " . mysql_error());
		}
	
		mysql_close($linkWRM);
		
		//NEW - Import all user from phpbb3
		$content  = '<form action="install.php?s=5&lang='.$lang.'" method="POST">';
		$content .= '<input type="hidden" name="auth_type" value="' . $auth_type . '" class="post">';
		if (phpbbversioncheck == 2){
			$content .= '<input type="hidden" name="substep" value="done" class="post">';
		}
		else{
			$content .= '<input type="hidden" name="substep" value="4" class="post">';
		}

		$content .= '<br>';
		$content .= $localstr['step5selctusername'].' ('.$phpbb_useradmin_name.'): <font color=green>'.$localstr['step5done'].'</font><br>';
		$content .= '<br>------------------------------------------------------------------<br><br>';
		$content .= $localstr['step5sub3group01'].'.<br>';
		$content .= $localstr['step5sub3group02'].'.<br>';
		$content .= $localstr['step5sub3group03'].'.<br><br>';
		$content .= $userclasses . '<br><br>';
		$content .= $localstr['step5sub3altgroup01'].'.<br>';
		$content .= $localstr['step5sub3altgroup02'].'.<br><br>';
		$content .= $altuserclass . '<br><br>';
		$content .= '<br>------------------------------------------------------------------<br>';	
		$content .= '<input type="hidden" name="phpbb_prefix" value="'. $phpbb_prefix .'" class="post">';
		$content .= '<input type="hidden" name="phpbb_root_path" value="'. $phpbb_root_path .'" class="post">';
		$content .= '<input type="hidden" name="phpbb_useradmin_name" value="'. $phpbb_useradmin_name .'" class="post">';
		$content .= '<input type="hidden" name="phpbbversioncheck" value="'.$phpbbversioncheck.'" class="post">';
		$content .= $localstr['hittingsubmit'].'<br><br>';
		$content .= '<input type="submit" value="'.$localstr['bd_submit'].'" name="submit" class="post"></form>';
	}
	
	else if ($step5_substep == 4){
		$phpbb_prefix = $_POST['phpbb_prefix'];
		$phpbb_root_path = $_POST['phpbb_root_path'];
		$phpbb_useradmin_name = $_POST['phpbb_useradmin_name'];
		$phpbbversioncheck = $_POST['phpbbversioncheck'];
		
		$phpBB_auth_user_class = $_POST['phpBB_auth_user_class'];
		$phpBB_alt_auth_user_class = $_POST['phpBB_alt_auth_user_class'];
		
		$content  = '<form action="install.php?s=5&lang='.$lang.'" method="POST"><br>';
		$content .= '<br>------------------------------------------------------------------<br><br>';
		$content .= '<br><br>';
		if ($phpbbversioncheck == 3){
			$content .= $localstr['step5phpBBsub4wantimport'].'? <br>';
			$content .= '<br>';
			$content .= '<input type="radio" name="importUser" value="Yes">Yes';
			$content .= '<input type="radio" name="importUser" value="No" checked>No<br><br>';
		}
		else {
			$content .= $localstr['step5phpBBsub4srynotsupport'].' <br><br>';
		}
		$content .= '<br><br>';
		$content .= '<br>------------------------------------------------------------------<br><br>';
		$content .= '<input type="hidden" name="auth_type" value="' . $auth_type . '" class="post">';
		$content .= '<input type="hidden" name="substep" value="done" class="post">';
		$content .= '<input type="hidden" name="phpbb_prefix" value="'. $phpbb_prefix .'" class="post">';
		$content .= '<input type="hidden" name="phpbb_root_path" value="'. $phpbb_root_path .'" class="post">';
		$content .= '<input type="hidden" name="phpbb_useradmin_name" value="'. $phpbb_useradmin_name .'" class="post">';
		$content .= '<input type="hidden" name="phpbbversioncheck" value="'.$phpbbversioncheck.'" class="post">';
		$content .= '<input type="hidden" name="phpBB_auth_user_class" value="'. $phpBB_auth_user_class .'" class="post">';
		$content .= '<input type="hidden" name="phpBB_alt_auth_user_class" value="'.$phpBB_alt_auth_user_class.'" class="post">';

		$content .= '<br><br>';
		$content .= '<input type="submit" value="'.$localstr['bd_submit'].'" name="submit" class="post"></form>';

	}
	else if ($step5_substep == "done"){
		$phpbb_prefix = $_POST['phpbb_prefix'];
		$phpbb_root_path = $_POST['phpbb_root_path'];
		$phpbb_useradmin_name = $_POST['phpbb_useradmin_name'];
		$phpbbversioncheck = $_POST['phpbbversioncheck'];
		$phpBB_auth_user_class = $_POST['phpBB_auth_user_class'];
		$phpBB_alt_auth_user_class = $_POST['phpBB_alt_auth_user_class'];
		
	
		// insert the super group or update if it exists already
		$linkWRM = mysql_connect($phpraid_config['db_host'],$phpraid_config['db_user'],$phpraid_config['db_pass']);
		mysql_select_db($phpraid_config['db_name']);
	
		$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "config WHERE config_name='phpbb_root_path'";
		$result = mysql_query($sql) or die("BOO2: ". mysql_error());
		
		$authstring = 'phpbb';
		if ($phpbbversioncheck == 3){
				$authstring = 'phpbb3';
		}
	
		if(mysql_num_rows($result) > 0)
		{
			// update
			$sql = sprintf("UPDATE " . $phpraid_config['db_prefix'] . "config SET config_value=%s WHERE config_name='phpbb_root_path'", quote_smart($phpbb_root_path));
			mysql_query($sql) or die("Error updateing phpbb_root_path in config table. " . mysql_error());
			
			$sql = sprintf("UPDATE " . $phpraid_config['db_prefix'] . "config SET config_value=%s WHERE config_name='phpbb_prefix'", quote_smart($phpbb_prefix));
			mysql_query($sql) or die("Error updateing phpbb_prefix in config table. " . mysql_error());
			$sql = sprintf("UPDATE " . $phpraid_config['db_prefix'] . "config SET config_value=%s WHERE config_name='auth_type'", quote_smart($authstring));
			mysql_query($sql) or die("Error updateing auth_type in config table. " . mysql_error());
			$sql = sprintf("UPDATE " . $phpraid_config['db_prefix'] . "config SET config_value=%s WHERE config_name='phpBB_auth_user_class'", quote_smart($phpBB_auth_user_class));
			mysql_query($sql) or die("Error updateing phpBB_auth_user_class in config table. " . mysql_error());
			$sql = sprintf("UPDATE " . $phpraid_config['db_prefix'] . "config SET config_value=%s WHERE config_name='phpBB_alt_auth_user_class'", quote_smart($phpBB_alt_auth_user_class));
			mysql_query($sql) or die("Error updateing phpBB_alt_auth_user_class in config table. " . mysql_error());
			
		}
		else
		{
			// install
			$sql = sprintf("INSERT INTO " . $phpraid_config['db_prefix'] . "config VALUES('auth_type',%s)", quote_smart($authstring));
			mysql_query($sql) or die("Error inserting auth_type in config table. " . mysql_error());
			
			$sql = sprintf("INSERT INTO " . $phpraid_config['db_prefix'] . "config VALUES('phpbb_root_path',%s)", quote_smart($phpbb_root_path));
			mysql_query($sql) or die("Error inserting phpbb_root_path in config table. " . mysql_error());
			
			$sql = sprintf("INSERT INTO " . $phpraid_config['db_prefix'] . "config VALUES('phpbb_prefix',%s)", quote_smart($phpbb_prefix));
			mysql_query($sql) or die("Error inserting phpbb_prefix in config table. " . mysql_error());
			
			// Insert the phpBB_auth_user_class
			$sql = sprintf("INSERT INTO " . $phpraid_config['db_prefix'] . "config VALUES('phpBB_auth_user_class', %s)", quote_smart($phpBB_auth_user_class));
			mysql_query($sql) or die("Error inserting phpBB_auth_user_class in config table. " . mysql_error());
		
			// Insert the phpBB_alt_auth_user_class
			$sql = sprintf("INSERT INTO " . $phpraid_config['db_prefix'] . "config VALUES('phpBB_alt_auth_user_class', %s)", quote_smart($phpBB_alt_auth_user_class));
			mysql_query($sql) or die("Error inserting phpBB_alt_auth_user_class in config table. " . mysql_error());
		}
	
		mysql_close($linkWRM);	
				
		$content  = '<br>';
		
		if (isset($_GET['importUser']) && $_POST['importUser'] == 'Yes')
		{
			importUserfromDB($phpbb_root_path, $phpbb_prefix, $phpraid_config, $phpbb_useradmin_name );
			$content .= $localstr['step5phpBBsub5import'].': <font color=green>'.$localstr['step5done'].'</font>.<br>';
		}
		else $content .= '<br>';
	
		$content .= '<br>------------------------------------------------------------------<br><br>';	
		$content .= '<form action="install.php?s=done&lang='.$lang.'" method="POST">';
		$content .= '<input type="hidden" name="auth_type" value="' . $auth_type . '" class="post">';
		$content .= '<input type="hidden" name="substep" value="done" class="post">';

		$content .= $localstr['step5phpBBdesc'] .' '. $localstr['txtconfig'];
		$content .= ': <font color=green>'.$localstr['step5done'].'</font><br><br>';
		$content .= '<input type="submit" value="'.$localstr['bd_submit'].'" name="submit" class="post"></form>';
	}
		
	step($localstr['menustep5confauth'].' ('.$localstr['step5phpBBdesc'].')','lime','lime','lime','lime','red','white',$content);

	return 1;
}

//read user(user_id, username, email) from phpbb3 forum and write in WRM
function importUserfromDB($phpbb_root_path, $phpbb_prefix, $phpraid_config,$adminusername)
{

	$defaultuserPriv = '0';
	
	//link to phpbb3
	require($phpbb_root_path.'config.php');
	$linkDB = mysql_connect($dbhost,$dbuser,$dbpasswd);
	if (!$linkDB) {die($localstr['step5phpBBfailconphpBB'] .' <br> ' . mysql_error());}
	mysql_select_db($dbname);

	//link to WRM
	require_once('../config.php');
	$linkWRM = mysql_connect($phpraid_config['db_host'],$phpraid_config['db_user'],$phpraid_config['db_pass']);
	if (!$linkWRM) {die($localstr['step5failconWRM'].'  <br> ' . mysql_error());}
	mysql_select_db($phpraid_config['db_name']);

	$sql = "SELECT user_id, user_email, username  FROM " . $phpbb_prefix . "users ORDER BY user_id";
	$result = mysql_query($sql) or die('unable read table users: <br>'.$sql .'<br>'.mysql_error());

	if (mysql_num_rows($result) == 0) {
		echo "Failed: no users in phpBB3 tables";
		exit;
	}
	
	for ($i = 0; $i < mysql_num_rows($result); $i++){
		$rows = mysql_fetch_array($result);
		if ($adminusername != $rows[2]){
			$profile_id = $rows[0];
			$email = $rows[1]; 
			$username = $rows[2];
			
			$sql = sprintf("INSERT INTO " . $phpraid_config['db_prefix'] . "profile (`profile_id`, `email`, `password`,`priv`,`username`) " .
				 			"VALUES(%s,%s,'',%s,%s)", quote_smart($profile_id), quote_smart($email), quote_smart($defaultuserPriv), quote_smart($username));
			mysql_query($sql) or die("Error @ User Import (phpBB3)" . mysql_error());
		}
			
	}
	
	mysql_close($linkDB);
	mysql_close($linkWRM);
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