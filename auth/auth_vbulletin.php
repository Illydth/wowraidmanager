<?php
/***************************************************************************
*                            auth_vbulletin.php
*                           --------------------
*	date				: 2011-02-12 for WRM version 4.1.3
*	Dev					: Josh Waggoner
*	email				: waggz@bnwguild.com
*
*	NOTES: this auth file looks for the following values in your WRM config table:
*		vbulletin_auth_user_class	- A comma separated list of vbulletin groups 
*										allowed to use WRM		EXAMPLE: 1,2,3,4
*									**Both Primary and Additional groups are searched!
*		vbulletin_db_name			- The database name your vBulletin is held in,
*										if separate from WRM. Leave blank if using
*										same database
*		vbulletin_user_table		- The name of the table that holds your vBulletin
*										users. usually XXXusers, where XXX is your
*										vBulletin table prefix
*
***************************************************************************
*	 based on 			  : auth_phpbb3.php
*	 Dev                  : Carsten Hölbing
*	 email                : hoelbin@gmx.de
*
*	 based on 			  : auth_e107.php @ Douglas Wagner
*   copyright            : (C) 2007-2008 Douglas Wagner
*   email                : douglasw0@yahoo.com
*
***************************************************************************/

/***************************************************************************
*
*    WoW Raid Manager - Raid Management Software for World of Warcraft
*    Copyright (C) 2007-2008 Douglas Wagner
*
*    This program is free software: you can redistribute it and/or modify
*    it under the terms of the GNU General Public License as published by
*    the Free Software Foundation, either version 3 of the License, or
*    (at your option) any later version.
*
*    This program is distributed in the hope that it will be useful,
*    but WITHOUT ANY WARRANTY; without even the implied warranty of
*    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*    GNU General Public License for more details.
*
*    You should have received a copy of the GNU General Public License
*    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*
****************************************************************************/

if ( !defined('IN_PHPRAID'))
print_error("Hacking Attempt", "Invalid access detected", 1);

if(isset($_GET['phpraid_dir']) || isset($_POST['phpraid_dir']))
die("Hacking attempt detected!");

//This is NOT SAFE to turn on.
$BridgeSupportPWDChange = FALSE;
$Bridge2ColumGroup = TRUE;

/***********************************************
* Table and Column Names - change per CMS.
***********************************************/
require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');
$salt = COOKIE_SALT;
//the table name that holds the vbulletin users
$db_table_user_name = "`" . $phpraid_config[$phpraid_config['auth_type'].'_user_table'] . "`";
$db_table_group_name = $db_table_user_name;

//shouldn't need to change for normal installation
// Column Name for the ID field for the User.
$db_user_id = "userid";
// Column Name for the ID field for the Group the User belongs to.
$db_group_id = "usergroupid";
$db_add_group_ids = "membergroupids";
// Column Name for the UserName field.
$db_user_name = "username";
// Column Name for the User's E-Mail Address
$db_user_email = "email";
// Column Name for the User's Password
$db_user_password = "password";
$db_user_salt = "salt";


if (isset($phpraid_config[$phpraid_config['auth_type'].'_db_name'])) {
	if (!empty($phpraid_config[$phpraid_config['auth_type'].'_db_name'])) {
		$table_prefix = "`".$phpraid_config[$phpraid_config['auth_type'].'_db_name'] . "`.";
	}
}


$auth_user_class = explode (",", $phpraid_config[$phpraid_config['auth_type'].'_auth_user_class']);

// Table Name were save all  Groups/Class Infos
$db_table_allgroups = "groups";
// Column Name for the ID field for the Group/Class.
$db_allgroups_id = "group_id";
// Column Name for the Groups/Class Name field.
$db_allgroups_name = "group_name";

//change password in WRM DB
//Just return 0, not going to use this function (if it ever gets called)
function db_password_change($profile_id, $dbusernewpassword)
{
	//pwd NOT change
	return 0;
}

//compare password
//return value -> $db_pass (Password from CMS database) upon success, FALSE upon fail.
function password_check($oldpassword, $profile_id, $encryptflag)
{
	global $db_user_id, $db_group_id, $db_user_name, $db_user_email, $db_user_password, $db_table_user_name, $db_user_salt;
	global $db_table_group_name, $auth_user_class, $table_prefix, $db_raid, $phpraid_config;

	$sql_passchk = sprintf(	"SELECT `" . $db_user_password . "`, `" . $db_user_salt . "` FROM " . $table_prefix . $db_table_user_name .
	" WHERE `" . $db_user_id . "` = %s", quote_smart($profile_id));
	
	$result_passchk = $db_raid->sql_query($sql_passchk) or print_error($sql_passchk, $db_raid->sql_error(), 1);

	if ($db_raid->sql_numrows($result_passchk) != 1)
	{
		//user not found in CMS DB, Fail
		return 2;
	}

	$data_passchk = $db_raid->sql_fetchrow($result_passchk, true);
	$db_pass = $data_passchk[$db_user_password];
	
	if ($encryptflag) {
		
	}
	else {
		$oldpassword = md5(md5($oldpassword).$data_passchk[$db_user_salt]);
	}
	
	if ($oldpassword == $db_pass) {
		return $db_pass;
	}
	else {
		return FALSE;
	}
}

function wrm_login()
{
	global $db_user_id, $db_group_id, $db_add_group_ids, $db_user_name, $db_user_email, $db_user_password, $db_table_user_name;
	global $db_table_group_name, $auth_user_class, $table_prefix;
	global $db_raid, $phpraid_config;
	
	$password = "";
	$profile_id = "";
	
	//if you select "No Restrictions" or "No Additional UserGroup" (bridge permission group)
	$default_bridge_value = "-1";

	//first login
	if(isset($_POST['username']))
	{
		// User is logging in, set encryption flag to 0 to identify login with plain text password.
		$pwdencrypt = FALSE;
		$username = strtolower_wrap(scrub_input($_POST['username']), "UTF-8");
		$password = $_POST['password'];
		//$password = md5($_POST['password']);//
		$wrmpass = md5($_POST['password']);
	}// get infos from the COOKIE
	elseif(isset($_COOKIE['username']) && isset($_COOKIE['password']))
	{
		// User is not logging in but processing cookie, set encryption flag to 1 to identify login with encrypted password.
		$pwdencrypt = TRUE;
		$username = $_COOKIE['username'];
		$password = $_COOKIE['password'];
		$profile_id = $_COOKIE['profile_id'];
		$wrmpass = '';
	}
	else
	{
		wrm_logout();
		return -1;
	}

	$sql = sprintf( "SELECT `" . $db_user_id."`, `". $db_user_name . "`, `" . $db_user_email."`, `" . $db_user_password . "` FROM " . $table_prefix . $db_table_user_name . " WHERE `".$db_user_name."` = %s", quote_smart($username));
	$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	if ($db_raid->sql_numrows($result) > 0 )
	{
		$data = $db_raid->sql_fetchrow($result, true);
		$profile_id = $data[$db_user_id];
		if( ($username == strtolower_wrap($data[$db_user_name], "UTF-8")) &&
				($cmspass = password_check($password, $data[$db_user_id], $pwdencrypt)) )
		$user_auth = TRUE;
		else
		$user_auth = FALSE;
	}
	else
	{
		wrm_logout();
		return -1;
	}

	// Authorize User, now check if User_Auth = TRUE.
	if ($user_auth == TRUE)
	{
		$sql = sprintf(	"SELECT  configuration" .
		" FROM    `" . $phpraid_config['db_prefix'] . "permissions`" .
		"	inner JOIN `" . $phpraid_config['db_prefix'] . "profile`" .
		"		ON `" . $phpraid_config['db_prefix'] . "permissions`.`permission_id` = `" . $phpraid_config['db_prefix'] . "profile`.`priv`" .
		" where `" . $phpraid_config['db_prefix'] . "profile`.`profile_id` = %s", quote_smart($data[$db_user_id]));
		$result_permissions = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
		$data_permissions = $db_raid->sql_fetchrow($result_permissions, true);
		
		// The user has a matching username and proper password in the BRIDGE database.
		// We need to validate the users group.  If it does not contain the user group that has been set as
		//	authorized to use WRM, we need to fail the login with a proper message.
		if ((($auth_user_class != "") and ($auth_user_class != $default_bridge_value)) and ($data_permissions["configuration"] != 1))
		{
			$FoundUserInGroup = FALSE;

			if ($db_add_group_ids != "") {
				$sql = sprintf( "SELECT  " .$db_group_id . "," . $db_add_group_ids . " FROM "  . $table_prefix . $db_table_group_name . " WHERE " . $db_user_id . " = %s", quote_smart($data[$db_user_id]));
			}
			else {
				$sql = sprintf( "SELECT  " .$db_group_id . " FROM " . $table_prefix . $db_table_group_name . " WHERE " . $db_user_id . " = %s", quote_smart($data[$db_user_id]));
			}
			
			$resultgroup = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
			$datagroup = $db_raid->sql_fetchrow($resultgroup, true);
			
			if ($db_add_group_ids != "") {
				$user_class = $datagroup[$db_group_id] . "," . $datagroup[$db_add_group_ids];
			}
			else {
				$user_class = $datagroup[$db_group_id];
			}
			
			$user_class = explode(",", $user_class);
			

			// Group Access Check for Auth where Groups are stored in a list in a single field.
			foreach ($user_class as $group) {
				if (in_array($group, $auth_user_class)) {
					$FoundUserInGroup = TRUE;
					break;
				}
			}

			if ($FoundUserInGroup == FALSE)
			{
				wrm_logout();
				return -1;
			}
		}
		
		// User is properly logged in and is allowed to use WRM, go ahead and process his login.
		$autologin = scrub_input($_POST['autologin']);
		if(isset($autologin)) {
			// they want automatic logins so set the cookie
			// set to expire in one month
			setcookie('username', $data[$db_user_name], time() + 2629743);
			setcookie('profile_id', $data[$db_user_id], time() + 2629743);
			setcookie('password', $cmspass, time() + 2629743);
		}
		/**************************************************************
			* set user profile variables in SESSION
			**************************************************************/
		set_WRM_SESSION($data[$db_user_id], 1, $data[$db_user_name], TRUE);
		if ($auth_user_class != $default_bridge_value)
		{
			// User is all logged in and setup, the session is initialized properly.  Now we need to create the users
			//    profile in the WRM database if it does not already exist.
			$sql = sprintf("SELECT * " . "FROM " . $phpraid_config['db_prefix'] . "profile" . " WHERE profile_id = %s",	quote_smart($_SESSION['profile_id']));
			$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
			
			if ($profdata = $db_raid->sql_fetchrow($result)) {
				wrm_profile_update($_SESSION['profile_id'],$wrmpass,$data[$db_user_email]);
			}
			else {
				wrm_profile_add($data[$db_user_id],$data[$db_user_email],$wrmpass,$data[$db_user_name]);
			}
		}
		else
		{
			// ********************
			// * NOTE * IUMS Auth does not do profile checking like external bridges do.
			// ********************
			
			wrm_profile_update($_SESSION['profile_id'],"",$data[$db_user_email]);
		}
		
		get_permissions($profile_id);
		
		//security fix
		unset($password);
		unset($cmspass);
		unset($wrmpass);
		
		return 1;
	}
	
	return 0;
	
}// end wrm_login()

?>
