<?php
/***************************************************************************
 *                             install_joomla.php
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
/*
configuration.php
/ Database Settings /
class JConfig {
	...
	var $host = 'localhost'; // normally set to localhost
	var $user = '';         // MySQL username
	var $password = '';     // MySQL password
	var $db = '';           // MySQL database name ...." 
	var $dbprefix = 'jos_'; // MySQL table prefix
	..
}
---
example
$JOOMLACONFIG = new JConfig();
$JOOMLACONFIG->host;

-----------------------------
CREATE TABLE IF NOT EXISTS `jos_core_acl_aro_groups` (
  `id` int(11) NOT NULL auto_increment,
  `parent_id` int(11) NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `lft` int(11) NOT NULL default '0',
  `rgt` int(11) NOT NULL default '0',
  `value` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `jos_gacl_parent_id_aro_groups` (`parent_id`),
  KEY `jos_gacl_lft_rgt_aro_groups` (`lft`,`rgt`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=31 ;

CREATE TABLE IF NOT EXISTS `jos_users` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `username` varchar(150) NOT NULL default '',
  `email` varchar(100) NOT NULL default '',
  `password` varchar(100) NOT NULL default '',
  `usertype` varchar(25) NOT NULL default '',
  `block` tinyint(4) NOT NULL default '0',
  `sendEmail` tinyint(4) default '0',
  `gid` tinyint(3) unsigned NOT NULL default '1',
  `registerDate` datetime NOT NULL default '0000-00-00 00:00:00',
  `lastvisitDate` datetime NOT NULL default '0000-00-00 00:00:00',
  `activation` varchar(100) NOT NULL default '',
  `params` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `usertype` (`usertype`),
  KEY `idx_name` (`name`),
  KEY `gid_block` (`gid`,`block`),
  KEY `username` (`username`),
  KEY `email` (`email`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=63 ;

*/
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
	$joomla_config_name = 'configuration.php';
	$pwd_hasher = new PasswordHash(8, FALSE);
		
	require_once('../config.php');

	$step5_substep = $_POST['substep'];

	if ($step5_substep == "")
	{
		$content  = '<br>';
		$content .=  $localstr['step5joomlasub1desc'].'.<br>';
		$content .=  $localstr['step5sub1follval'].'.<br>';
		$content .= '<br>------------------------------------------------------------------<br><br>';
		$content .= '<br><br>';
		$content .= '<form action="install.php?s=5&lang='.$lang.'" method="POST">';
		$content .= '<input type="hidden" name="auth_type" value="' . $auth_type . '" class="post">';
		$content .= '<input type="hidden" name="substep" value="2" class="post">';
		$content .= $localstr['step5joomlasub1inputdir'].'.<br><br>';
		$content .= '<input type="text" name="joomla_base_path" size="20" class="post" value="../joomla/"><br><br>';
		$content .= '<br><br><br>';
		$content .= '<br>------------------------------------------------------------------<br>';	
		$content .= $localstr['hittingsubmit'].'.<br><br>';
		$content .= '<input type="submit" value="'.$localstr['bd_submit'].'" name="submit" class="post"></form>';

	}
	else if ($step5_substep == 2)
	{
		$joomla_base_path = $_POST['joomla_base_path'];
			
			// check for valid entry of previous form
		if(!is_file($joomla_base_path.$joomla_config_name))
		{
			echo '<font color=red>'.$localstr['step5sub2failfindfile'].' ("' . $joomla_base_path.$joomla_config_name.'").<br>';
			echo $localstr['step5sub2checkdir'].'<br>';
			echo $localstr['pressbrowserpack'].'</font>';
			exit;
		}
		
		require($joomla_base_path.$joomla_config_name);
		
		$JOOMLACONFIG = new JConfig();
		$joomla_prefix = $JOOMLACONFIG->dbprefix;
		
		//check if db available
		$linkDB = mysql_connect($JOOMLACONFIG->host,$JOOMLACONFIG->user,$JOOMLACONFIG->password);
		if (!$linkDB) {
			echo '<font color=red>'.$localstr['step5ejoomlafailconejoomla'].'<br>';
			echo $localstr['problem']. mysql_error().'<br>';
			echo $localstr['pressbrowserpack'].'</font>';
			exit;
		}
		mysql_select_db($JOOMLACONFIG->db);
		
		// all users -> select boxes.
		$joomlausernametable = '<select name="joomla_useradmin_name" class="post">';

		$sql = "SELECT username, email FROM " . $joomla_prefix . "users ORDER BY username";

		$result = mysql_query($sql) or die($localstr['step5joomlasub3errorretusername'] . mysql_error());
		if (mysql_num_rows($result) > 0) {
			while ($data = mysql_fetch_assoc($result)) {
				$joomlausernametable .= '<option value="' . $data['username']. '">' .$data['username']. ': '.$data['email'] . '</option>';
			}
		}
		$joomlausernametable .= '</select>';
		
		mysql_close($linkDB);
		
		$content  = '<br>';
		$content .= '<form action="install.php?s=5&lang='.$lang.'" method="POST">';
		$content .= '<input type="hidden" name="auth_type" value="' . $auth_type . '" class="post">';
		$content .= '<input type="hidden" name="substep" value="3" class="post">';
		$content .= '<input type="hidden" name="joomla_base_path" value="'.$joomla_base_path.'" class="post">';
		$content .= $localstr['step5joomlasub2readconffile'].': <font color=green>'.$localstr['step5done'].'</font><br>';
		$content .= '<br>------------------------------------------------------------------<br><br>';
		$content .= '<br><br>';	
		$content .= $localstr['step5sub2usernamefullperm'].'!<br><br>';		
		$content .= $joomlausernametable. '<br><br>';
		$content .= $localstr['txtpassword'].':';
		$content .= '<input type="text" name="joomla_useradmin_password" size="20" class="post" value=""><br><br>';
		$content .= '<br><br><br>';
		$content .= '<br>------------------------------------------------------------------<br>';	
		$content .= $localstr['hittingsubmit'].'.<br><br>';
		$content .= '<input type="submit" value="'.$localstr['bd_submit'].'" name="submit" class="post"></form>';
	}
	else if ($step5_substep == 3){

		$joomla_base_path = $_POST['joomla_base_path'];
		$joomla_useradmin_name = $_POST['joomla_useradmin_name'];
		$joomla_useradmin_password = $pwd_hasher->HashPassword($_POST['joomla_useradmin_password']);

		require($joomla_base_path.$joomla_config_name);
		
		$JOOMLACONFIG = new JConfig();
		$joomla_prefix = $JOOMLACONFIG->dbprefix;

		//check if db available
		$linkDB = mysql_connect($JOOMLACONFIG->host,$JOOMLACONFIG->user,$JOOMLACONFIG->password);
		if (!$linkDB) {
			echo '<font color=red>'.$localstr['step5joomlafailconjoomla'].'<br>';
			echo $localstr['problem']. mysql_error().'<br>';
			echo $localstr['pressbrowserpack'].'</font>';
			exit;
		}
		mysql_select_db($JOOMLACONFIG->db);
		
		// Setup the joomla_auth_user_class and joomla_alt_auth_userclass select boxes.
		$userclasses = '<select name="joomla_auth_user_class" class="post">';
		$userclasses .= '<option value="0">'.$localstr['step5sub3norest'].'</option>';
		$altuserclass = '<select name="joomla_alt_auth_user_class" class="post">';
		$altuserclass .= '<option value="0">'.$localstr['step5sub3noaddus'].'</option>';
		
		// Get Userclasses from joomla database.
		$sql = "SELECT id, name FROM " . $joomla_prefix . "core_acl_aro_groups ORDER BY id";
		$result = mysql_query($sql) or die($localstr['step5joomlasub3errorretuserclass'].':' . mysql_error());
		if (mysql_num_rows($result) > 0) {
			while ($data = mysql_fetch_assoc($result)) {
				$userclasses .= '<option value="' . $data['id']. '">' . htmlentities($data['name']) . '</option>';
				$altuserclass .= '<option value="' . $data['id']. '">' . htmlentities($data['name']) . '</option>';
			}
		}
		$userclasses .= '</select>';
		$altuserclass .= '</select>';
		
		$sql = printf("SELECT username, email, id FROM ".$joomla_prefix."users WHERE username  = %s", quote_smart($joomla_useradmin_name));
		//echo ':datenbank:'.$mySQLdefaultdb.'::<br>::'.$sql;
		$result = mysql_query($sql) or die($localstr['step5joomlasub3errorretusername'].': <br>' .$sql. '<br>'. mysql_error());
		
		$data = mysql_fetch_assoc($result);
		$joomla_useradmin_email = $data['email'];
		$joomla_useradmin_id = $data['id'];
		
		mysql_close($linkDB);
		
		if ($phpraid_config['db_name'] != $JOOMLACONFIG->db)
		{
			$joomla_prefix = $JOOMLACONFIG->db . '.' . $joomla_prefix;
		}

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
		$sql = printf("SELECT username FROM " . $phpraid_config['db_prefix']. "profile WHERE username = %s", quote_smart($joomla_useradmin_name));
		
		$result = mysql_query($sql) or die("Error verifying " . mysql_error());
		//$sqlresultdata = mysql_fetch_assoc($result);
		
		if((mysql_num_rows($result) == 0))
		{
			$sql = printf("INSERT INTO " . $phpraid_config['db_prefix'] . "profile (`profile_id`,`username`,`email`,`password`,`priv`)" . 
			       "VALUES(%s,%s,%s,%s,'1')", quote_smart($joomla_useradmin_id), quote_smart($joomla_useradmin_name), quote_smart($joomla_useradmin_email), 
					quote_smart($joomla_useradmin_password));
			$result = mysql_query($sql) or die("Error inserting " . mysql_error());
		}
		else
		{
			$sql = printf("UPDATE " . $phpraid_config['db_prefix'] . "profile SET priv='1' WHERE username=%s", quote_smart($joomla_useradmin_name));
			mysql_query($sql)or die("Error updating " . mysql_error());
		}
	
		mysql_close($linkWRM);
		

		$content  = '<form action="install.php?s=5&lang='.$lang.'" method="POST">';
		$content .= '<input type="hidden" name="auth_type" value="' . $auth_type . '" class="post">';
		$content .= '<input type="hidden" name="substep" value="done" class="post">';
		$content .= '<br>';
		$content .= $localstr['step5selctusername'].' ('.$joomla_useradmin_name.'): <font color=green>'.$localstr['step5done'].'</font><br>';
		$content .= '<br>------------------------------------------------------------------<br><br>';
		$content .= $localstr['step5sub3group01'].'.<br>';
		$content .= $localstr['step5sub3group02'].'.<br>';
		$content .= $localstr['step5sub3group03'].'.<br><br>';
		$content .= $userclasses . '<br><br>';
		$content .= $localstr['step5sub3altgroup01'].'.<br>';
		$content .= $localstr['step5sub3altgroup02'].'.<br><br>';
		$content .= $altuserclass . '<br><br>';
		$content .= '<br>------------------------------------------------------------------<br><br>';	
		$content .= '<input type="hidden" name="joomla_prefix" value="'. $joomla_prefix .'" class="post">';
		$content .= '<input type="hidden" name="joomla_base_path" value="'. $joomla_base_path .'" class="post">';

		$content .= $localstr['hittingsubmit'].'<br><br>';
		$content .= '<input type="submit" value="'.$localstr['bd_submit'].'" name="submit" class="post"></form>';
	}
	else if ($step5_substep == "done"){
	
		$joomla_base_path = $_POST['joomla_base_path'];
		$joomla_prefix = $_POST['joomla_prefix'];
	
		$joomla_auth_user_class = $_POST['joomla_auth_user_class'];
		$joomla_alt_auth_user_class = $_POST['joomla_alt_auth_user_class'];
	
		// insert the super group or update if it exists already
		$linkWRM = mysql_connect($phpraid_config['db_host'],$phpraid_config['db_user'],$phpraid_config['db_pass']);
		mysql_select_db($phpraid_config['db_name']);
	
		$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "config WHERE config_name='joomla_base_path'";
		$result = mysql_query($sql) or die("BOO2: ". mysql_error());
		
	
		if(mysql_num_rows($result) > 0)
		{
			// update
			$sql = pritnf("UPDATE " . $phpraid_config['db_prefix'] . "config SET config_value=%s WHERE config_name='joomla_base_path'", quote_smart($joomla_base_path));
			mysql_query($sql) or die("Error updateing joomla_base_path in config table. " . mysql_error());
			
			$sql = printf("UPDATE " . $phpraid_config['db_prefix'] . "config SET config_value=%s WHERE config_name='joomla_table_prefix'", quote_smart($joomla_prefix));
			mysql_query($sql) or die("Error updateing joomla_prefix in config table. " . mysql_error());
			
			$sql = "UPDATE " . $phpraid_config['db_prefix'] . "config SET config_value='joomla' WHERE config_name='auth_type'";
			mysql_query($sql) or die("Error updateing auth_type in config table. " . mysql_error());
			
			$sql = printf("UPDATE " . $phpraid_config['db_prefix'] . "config SET config_value=%s WHERE config_name='joomla_auth_user_class'", quote_smart($joomla_auth_user_class));
			mysql_query($sql) or die("Error updateing joomla_auth_user_class in config table. " . mysql_error());
			
			$sql = printf("UPDATE " . $phpraid_config['db_prefix'] . "config SET config_value=%s WHERE config_name='joomla_auth_alt_user_class'", quote_smart($joomla_auth_alt_user_class));
			mysql_query($sql) or die("Error updateing joomla_auth_alt_user_class in config table. " . mysql_error());
		}
		else
		{
			// install
			$sql = "INSERT INTO " . $phpraid_config['db_prefix'] . "config VALUES('auth_type','joomla')";
			mysql_query($sql);
			$sql = printf("INSERT INTO " . $phpraid_config['db_prefix'] . "config VALUES('joomla_base_path',%s)", quote_smart($joomla_base_path));
			mysql_query($sql) or die("BOO5");
			$sql = printf("INSERT INTO " . $phpraid_config['db_prefix'] . "config VALUES('joomla_table_prefix',%s)", quote_smart($joomla_prefix));
			mysql_query($sql) or die("Error inserting joomla_table_prefix in config table. " . mysql_error());
			// Insert the joomla_auth_user_class
			$sql = printf("INSERT INTO " . $phpraid_config['db_prefix'] . "config VALUES('joomla_auth_user_class', %s)", quote_smart($joomla_auth_user_class));
			mysql_query($sql) or die("Error inserting joomla_auth_user_class in config table. " . mysql_error());
		
			// Insert the joomla_auth_user_class
			$sql = printf("INSERT INTO " . $phpraid_config['db_prefix'] . "config VALUES('joomla_alt_auth_user_class', %s)", quote_smart($joomla_alt_auth_user_class));
			mysql_query($sql) or die("Error inserting joomla_auth_alt_user_class in config table. " . mysql_error());
		}
	
		mysql_close($linkWRM);
		$content  = '<br>';

		$content .= '<br>------------------------------------------------------------------<br><br>';	
		$content .= '<form action="install.php?s=done&lang='.$lang.'" method="POST">';
		$content .= '<input type="hidden" name="auth_type" value="' . $auth_type . '" class="post">';
		$content .= '<input type="hidden" name="substep" value="done" class="post">';

		$content .= $localstr['step5joomladesc'] .' '. $localstr['txtconfig'];
		$content .= ': <font color=green>'.$localstr['step5done'].'</font><br><br>';
		$content .= '<input type="submit" value="'.$localstr['bd_submit'].'" name="submit" class="post"></form>';

	}
	step($localstr['menustep5confauth'].' ('.$localstr['step5joomladesc'].')','lime','lime','lime','lime','red','white',$content);

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