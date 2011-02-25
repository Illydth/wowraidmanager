<?php
/***************************************************************************
*                           functions_auth.php
*                           ---------------------
*   begin                : Monday, May 26, 2006
*   copyright            : (C) 2007-2008 Douglas Wagner
*   email                : douglasw@wagnerweb.org
*
*   $Id: functions_auth.php,v 2.00 2008/03/03 14:22:10 psotfx Exp $
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
// Gets the current Page URL to determine cookie path.
function curPageURL() {
 $pageURL = 'http';
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 return $pageURL;
}

// Creates the cookie storage path.
function getCookiePath()
{
	$URL_Array = array();
	$URL_Array = parse_url(curPageURL());
	$cookie_path = $URL_Array['path'];

	$pos = strrpos($cookie_path, "/");
	if ($pos === false) 
	{ 
	    // can't find a proper URL, return "/" as the cookie position.
	    $cookie_path = "/";
	}
	else
	  $cookie_path = substr($cookie_path, 0, $pos) . "/";

	return $cookie_path;
}

// clears session variables just in case
function clear_session()
{
	unset($_SESSION['username']);
	unset($_SESSION['session_logged_in']);
	unset($_SESSION['profile_id']);
	clear_session_permissions();
}

// clears only session variables from permissions
function clear_session_permissions()
{
	global $db_raid, $phpraid_config;

	$sql_priv = sprintf("SELECT * ".
						"	FROM " . $phpraid_config['db_prefix'] . "permission_value");
	$result_priv = $db_raid->sql_query($sql_priv) or print_error($sql_priv, $db_raid->sql_error(),1);
	while ($data_priv = $db_raid->sql_fetchrow($result_priv, true))
	{
		unset($_SESSION['priv_'.$data_priv['permission_value_name']]);
	}
}

//fill with default value 0
function set_session_permissions_default()
{
	global $db_raid, $phpraid_config;

	$sql_priv = sprintf("SELECT * ".
						"	FROM " . $phpraid_config['db_prefix'] . "permission_value");
	$result_priv = $db_raid->sql_query($sql_priv) or print_error($sql_priv, $db_raid->sql_error(),1);
	while ($data_priv = $db_raid->sql_fetchrow($result_priv, true))
	{
		$_SESSION['priv_'.$data_priv['permission_value_name']] = 0;
	}	
}

// gets and sets user permissions
function get_permissions($profile_id) 
{
	global $db_raid, $phpraid_config;

	//clear first
	clear_session_permissions();
	
	set_session_permissions_default();
	
	$permission_type_id = get_permission_id($profile_id);
	
	// check all permissions
	// read what permission the profile has and 
	// return the correct permission name (permission_value_name) 
	// from table permission_value
	$sql = sprintf("SELECT a.permission_value_id, b.permission_value_name".
					" FROM "  . $phpraid_config['db_prefix'] . "acl_permission a, " .
					"		". $phpraid_config['db_prefix'] . "permission_value b ".
					" WHERE a.permission_value_id = b.permission_value_id ".
					" AND permission_type_id = %s", quote_smart($permission_type_id));
	$result_priv = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(),1);
	while ($data_priv = $db_raid->sql_fetchrow($result_priv, true))
	{
		$_SESSION['priv_'.$data_priv['permission_value_name']] = 1;
	}
}

function check_permission($perm_type, $profile_id) {
	global $db_raid, $phpraid_config;
	
	$sql = sprintf("SELECT ".$phpraid_config['db_prefix']."permissions.raids AS perm_val
		FROM ".$phpraid_config['db_prefix']."permissions
		LEFT JOIN ".$phpraid_config['db_prefix']."profile ON
			".$phpraid_config['db_prefix']."profile.priv = ".$phpraid_config['db_prefix']."permission_type.permission_type_id
		WHERE ".$phpraid_config['db_prefix']."profile.profile_id = %s", quote_smart($profile_id));

	$perm_data = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	$permission_val = $db_raid->sql_fetchrow($perm_data, true);
	
	if ($permission_val['perm_val'] == "1")
		return TRUE;
	else
		return FALSE;
}

function delete_permissions($perm_id) {
	global $db_raid, $phpraid_config;
	
	$id = scrub_input($perm_id);
	
	$sql = sprintf("DELETE FROM " . $phpraid_config['db_prefix'] . "permissions WHERE permission_id=%s", quote_smart($id));
	$db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	
	$sql = sprintf("UPDATE " . $phpraid_config['db_prefix'] . "profile ".
					" SET priv=%s WHERE priv=%s",quote_smart($phpraid_config['default_group']), quote_smart($id));
	$db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
}

// not used
function remove_user() {
	global $db_raid, $phpraid_config;

	$user_id = scrub_input($_GET['user_id']);
	$perm_id = scrub_input($_GET['perm_id']);
	
	$sql = sprintf("UPDATE " . $phpraid_config['db_prefix'] . "profile SET priv='0' WHERE profile_id=%s", quote_smart($user_id));
	$db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	header("Location: permissions.php?mode=details&perm_id=". $perm_id);
}

/**
 * group permission
 * get are all classes that could be found (in (cms) bridge)
 * 
 * @return array
 */
function get_group_array()
{
	global $db_raid, $table_prefix, $db_raid;
	global $db_allgroups_id, $db_allgroups_name, $db_table_allgroups ;

	$group = array();
	
	$sql =  sprintf("SELECT " . $db_allgroups_id . " , ". $db_allgroups_name .
			" FROM " . $table_prefix . $db_table_allgroups .
			" ORDER BY ". $db_allgroups_id);
	
	$result_group = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	while ($data_wrm = $db_raid->sql_fetchrow($result_group,true))
	{
		$group[$data_wrm[$db_allgroups_id]] = $data_wrm[$db_allgroups_name];
	}

	return $group;
}

/**
 * change bridge groups
 */
function change_bridge_groups($bridge_selected_group_id, $bridge_selected_alt_group_id)
{
	global $db_raid, $phpraid_config;
	
	//base group
	$sql =	sprintf(
					"UPDATE `".$phpraid_config['db_prefix']."config` " .
					" SET `config_value` = %s" .
					" WHERE `".$phpraid_config['db_prefix']."config`.`config_name` = %s ;", 
					quote_smart($bridge_selected_group_id),
					quote_smart($phpraid_config['auth_type'].'_auth_user_class')
			);
	$db_raid->sql_query($sql) or print_error($sql,$db_raid->sql_error(),1);

	//alt group
	$sql =	sprintf(
					"UPDATE `".$phpraid_config['db_prefix']."config` " .
					" SET `config_value` = %s" .
					" WHERE `".$phpraid_config['db_prefix']."config`.`config_name`= %s ;", 
					quote_smart($bridge_selected_alt_group_id),
					quote_smart($phpraid_config['auth_type'].'_alt_auth_user_class')
			);
	$db_raid->sql_query($sql) or print_error($sql,$db_raid->sql_error(),1);

}

// Illydth:
// This is done oddly.  The intent is to wrap the wrm_login() function with an "if this doesn't exist,
//   define this function" check.  This allows users to write their own "login" function within the bridge auth
//   files to replace this login function for custom logins to custom CMS/BB systems.  HOWEVER, according
//   to the PHP forums, the "if exists" check may not work properly on some variants of PHP due to the
//   PHP Parser scrubbing the page first to check for function definitions THEN parsing the script...the
//   "IF" check doesn't stop the definition.  Thus what we've done is defined a function that will 
//   dynamically define the WRM_LOGIN() function at runtime.  We've added the if check to the common.php
//   area where we setup the login code.
function DEFINE_wrm_login()
{
	/**
	 * WRM Login
	 * @return Integer; 
	 * 1 = ok
	 * 0,-1 = fail
	 **/	
	function wrm_login()
	{
		global $db_user_id, $db_group_id, $db_add_group_ids, $db_user_name, $db_user_email, $db_user_password, $db_table_user_name; 
		global $db_table_group_name, $auth_user_class, $auth_alt_user_class, $table_prefix;
		global $db_raid, $phpraid_config;
		global $Bridge2ColumGroup;
	
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
			$username = strtolower_wrap(scrub_input($_COOKIE['username']), "UTF-8");
			$password = $_COOKIE['password'];
			$profile_id = $_COOKIE['profile_id'];
			$wrmpass = '';
		} 
		else 
		{
			wrm_logout();
			return -1;
		}
		/*
		if ( validate_Bridge_User($profile_id, $password, $pwdencrypt) == false)
		{
			wrm_logout();
			return -1;
		}
		*/
	
		// If auth type is iUMS, check that the user is in the database, otherwise fail authorization.
		//  iUMS Users must be registered with WRM before using the software.  External Auth does not have
		//  to pass this requirement.
		if ($phpraid_config['auth_type']=='iums')
		{
			$sql = sprintf(	"SELECT ". $db_user_id . "," . $db_user_name . "," . $db_user_email . "," . $db_user_password.
						" FROM " . $table_prefix . $db_table_user_name . 
						" WHERE ". $db_user_name . " = %s", quote_smart($username));
			$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
			if ($db_raid->sql_numrows($result) > 0 )
			{
				$data = $db_raid->sql_fetchrow($result, true);
				$profile_id = $data[$db_user_id];
	
				
				if( ($profile_id == $data[$db_user_id]) && ($cmspass = password_check($password, $data[$db_user_id], $pwdencrypt)) )
					$user_auth = TRUE;
				else
					$user_auth = FALSE;
			}
			else
			{
				wrm_logout();
				return -1;
			}
		}
		else // We are using an external Auth System...non iUMS.  Validate the user within the auth database.
		{
			$sql = sprintf( "SELECT ".$db_user_id.",". $db_user_name .",".$db_user_email.",".$db_user_password.
							" FROM " . $table_prefix . $db_table_user_name.
							" WHERE ".$db_user_name." = %s", quote_smart($username));
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
		}		
	
		//database
		//$sql = sprintf(	"SELECT ". $db_user_id . "," . $db_user_name . "," . $db_user_email . "," . $db_user_password.
		//				" FROM " . $table_prefix . $db_table_user_name . 
		//				" WHERE ". $db_user_id . " = %s", quote_smart($profile_id)
		//		);
				
		//$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
		//$data = $db_raid->sql_fetchrow($result, true);
		
		// Authorize User, now check if User_Auth = TRUE.
		//if( ($profile_id == $data[$db_user_id]) && ($cmspass = password_check($password, $data[$db_user_id], $pwdencrypt)) ) 
		if ($user_auth == TRUE)
		{
			/**
			 * user with access to admin area
			 * ignore base and alt base group Settings
			 * 
			 */
/*			$sql = sprintf(	"SELECT  configuration" .
							" FROM    `" . $phpraid_config['db_prefix'] . "permissions`" .
							"	inner JOIN `" . $phpraid_config['db_prefix'] . "profile`" .
							"		ON `" . $phpraid_config['db_prefix'] . "permissions`.`permission_id` = `" . $phpraid_config['db_prefix'] . "profile`.`priv`" .
							" where `" . $phpraid_config['db_prefix'] . "profile`.`profile_id` = %s", quote_smart($data[$db_user_id]));
			$result_permissions = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
			$data_permissions = $db_raid->sql_fetchrow($result_permissions, true);
			$_SESSION['priv_configuration']*/
			// The user has a matching username and proper password in the BRIDGE database.
			// We need to validate the users group.  If it does not contain the user group that has been set as
			//	authorized to use WRM, we need to fail the login with a proper message.
			if ((($auth_user_class != "") and ($auth_user_class != $default_bridge_value)) and ($_SESSION['priv_configuration'] != 1))
			//if ((($auth_user_class != "") and ($auth_user_class != $default_bridge_value)) and ($data_permissions["configuration"] != 1))
			
			{
				$FoundUserInGroup = FALSE;
				
				/*e107, smf*/
				// This is all of the "odd" group checking systems, each system has it's own method and it's
				//  not as simple as "select a field from a table".  Each one of the auth systems in this
				//  section have their own code for finding group membership.
				if ($Bridge2ColumGroup == TRUE)
				{
					if ($db_add_group_ids != "")
						$sql = sprintf( "SELECT  " .$db_group_id . "," . $db_add_group_ids . 
										" FROM "  . $table_prefix . $db_table_group_name . 
										" WHERE " . $db_user_id . " = %s", quote_smart($data[$db_user_id])
								);
					else
						$sql = sprintf( "SELECT  " .$db_group_id .  
										" FROM "  . $table_prefix . $db_table_group_name . 
										" WHERE " . $db_user_id . " = %s", quote_smart($data[$db_user_id])
								);
					
					$resultgroup = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
					$datagroup = $db_raid->sql_fetchrow($resultgroup, true);
	
					if ($db_add_group_ids != "")
						$user_class = $datagroup[$db_group_id] . "," . $datagroup[$db_add_group_ids];
					else
						$user_class = $datagroup[$db_group_id];
					
					// Group Access Check for Auth where Groups are stored in a list in a single field.
					$pos = strpos($user_class, $auth_user_class);
					$pos2 = strpos($user_class, $auth_alt_user_class);
					if ($pos === false && $auth_user_class != 0)
					{
						if ($pos2 === false)
							$FoundUserInGroup = FALSE;
						else
							$FoundUserInGroup = TRUE;
					}
					else
						$FoundUserInGroup = TRUE;
				}
				/* phpbb,...*/
				else
				{
					$sql = sprintf( "SELECT " . $db_group_id . 
									" FROM "  . $table_prefix . $db_table_group_name . 
									" WHERE " . $db_user_id . " = %s", quote_smart($data[$db_user_id])
							);
					$resultgroup = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
					while($datagroup = $db_raid->sql_fetchrow($resultgroup, true))
					{
						if( ($datagroup[$db_group_id] == $auth_user_class) or 
							($datagroup[$db_group_id] == $auth_alt_user_class)
						  )
						{	
							$FoundUserInGroup = TRUE;
						}
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
			if ($phpraid_config['auth_type'] != 'iums')
			{
				// User is all logged in and setup, the session is initialized properly.  Now we need to create the users
				//    profile in the WRM database if it does not already exist.
				$sql = sprintf(	"SELECT * " .
								"	FROM " . $phpraid_config['db_prefix'] . "profile" .
								"	WHERE profile_id = %s",	quote_smart($_SESSION['profile_id'])
						);
				$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
				
				if ($profdata = $db_raid->sql_fetchrow($result))
					wrm_profile_update($_SESSION['profile_id'],$wrmpass,$data[$db_user_email]);
				else
					wrm_profile_add($data[$db_user_id],$data[$db_user_email],$wrmpass,$data[$db_user_name]);
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
			unset($username);
			unset($password);
			unset($cmspass);
			unset($wrmpass);
	
			return 1;
		}
		
		return 0;
		
	}// end wrm_login()
}

/*
 * validat WRM User
 * @return Integer;
 */
function validate_Bridge_User($profile_id, $password, $pwdencrypt)
{
	global $db_raid, $phpraid_config;
	global $db_user_id, $table_prefix, $db_table_user_name, $db_user_id;

	$sql = sprintf(	"SELECT ". $db_user_id .
					" FROM " . $table_prefix . $db_table_user_name . 
					" WHERE ". $db_user_id . " = %s", quote_smart($profile_id)
		);
			
	$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	if(password_check($password, $data[$db_user_id], $pwdencrypt) ) 
	{
		return true;
	}
	
	//fail, error
	return false;
}
/**************************************************************
 * set user profile variables in SESSION
 **************************************************************/
function set_WRM_SESSION($profile_id, $session_logged_in_status, $profile_username, $SESSION_initiated = FALSE)
{
	$_SESSION['initiated'] = $SESSION_initiated;
	$_SESSION['username'] = strtolower_wrap($profile_username, "UTF-8");
	$_SESSION['session_logged_in'] = $session_logged_in_status;
	$_SESSION['profile_id'] = $profile_id;
}

/**************************************************************
 * add new Profile to WRM
 **************************************************************/
function wrm_profile_add($profile_id, $email, $wrmpass, $username)
{
	global $db_raid, $phpraid_config;
	
	// get default group 
	if($phpraid_config['default_group'] != '' || $phpraid_config['default_group'] != 0)
		$user_priv = $phpraid_config['default_group'];
	else
		$user_priv = '2';
	
	if ($profile_id != "")
	{
		$sql = sprintf(	" INSERT INTO " . $phpraid_config['db_prefix'] . "profile ".
						"	(`profile_id`,`email`,`password`,`priv`,`username`,`last_login_time`)".
						"	VALUES (%s, %s, %s, %s, %s, %s)",
					quote_smart($profile_id), quote_smart($email), quote_smart($wrmpass),
					quote_smart($user_priv), quote_smart($username), quote_smart(time())
				);
	}
	else
	{
		//iUMS
		$sql = sprintf(	" INSERT INTO " . $phpraid_config['db_prefix'] . "profile ".
						"	(`email`,`password`,`priv`,`username`,`last_login_time` )".
						"	VALUES ( %s, %s, %s, %s, %s)",
					quote_smart($email), quote_smart($wrmpass),
					quote_smart($user_priv), quote_smart($username), quote_smart(time())
				);		
	}
	//echo $sql;
	$db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);

	return 1;
}

/**************************************************************
 * WRM Profile update last_login_time
 **************************************************************/
function wrm_profile_update($profile_id, $wrmpass, $email)
{
	global $db_raid, $phpraid_config;

	if ($wrmpass != '')
	{
		$sql = sprintf("UPDATE " . $phpraid_config['db_prefix'] . "profile 
						SET email = %s, password = %s, last_login_time = %s WHERE profile_id = %s",
						quote_smart($email),quote_smart($wrmpass),quote_smart(time()),
						quote_smart($profile_id)
						);
	}
	else
	{
		$sql = sprintf("UPDATE " . $phpraid_config['db_prefix'] . "profile 
						SET email = %s, last_login_time = %s WHERE profile_id = %s",
						quote_smart($email),quote_smart(time()),
						quote_smart($profile_id)
						);
	}
	$db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	
	return 1;
}

/**************************************************************
 * WRM Logout
 **************************************************************/
function wrm_logout()
{
	// unset the session and remove all cookies
	clear_session();
	setcookie('username', '', time() - 2629743);
	setcookie('profile_id', '', time() - 2629743);
	setcookie('password', '', time() - 2629743);
}

?>
