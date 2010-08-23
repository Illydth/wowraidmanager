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
	unset($_SESSION['priv_announcements']);
	unset($_SESSION['priv_configuration']);
	unset($_SESSION['priv_profile']);
	unset($_SESSION['priv_guilds']);
	unset($_SESSION['priv_locations']);
	unset($_SESSION['priv_raids']);
}
// gets and sets user permissions
function get_permissions() 
{
	global $db_raid, $phpraid_config;
	
	$profile_id = scrub_input($_SESSION['profile_id']);

	$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "profile WHERE profile_id=%s", quote_smart($profile_id));
	$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(),1);
	$data = $db_raid->sql_fetchrow($result, true);
	
	// check all permissions
	$sql_priv = "SELECT * FROM " . $phpraid_config['db_prefix'] . "permissions WHERE permission_id='{$data['priv']}'";
	$result_priv = $db_raid->sql_query($sql_priv) or print_error($sql_priv, $db_raid->sql_error(),1);
			
	$data_priv = $db_raid->sql_fetchrow($result_priv, true);
	
	$data_priv['announcements'] ? $_SESSION['priv_announcements'] = 1 : $_SESSION['priv_announcements'] = 0;	
	$data_priv['configuration'] ? $_SESSION['priv_configuration'] = 1 :	$_SESSION['priv_configuration'] = 0;
	$data_priv['profile'] ? $_SESSION['priv_profile'] = 1 : $_SESSION['priv_profile'] = 0;
	$data_priv['guilds'] ? $_SESSION['priv_guilds'] = 1 : $_SESSION['priv_guilds'] = 0;
	$data_priv['locations'] ? $_SESSION['priv_locations'] = 1 : $_SESSION['priv_locations'] = 0;
	$data_priv['raids'] ? $_SESSION['priv_raids'] = 1 : $_SESSION['priv_raids'] = 0;
}

function check_permission($perm_type, $profile_id) {
	global $db_raid, $phpraid_config;
	
	$sql = "SELECT ".$phpraid_config['db_prefix']."permissions." . $perm_type . " AS perm_val
		FROM ".$phpraid_config['db_prefix']."permissions
		LEFT JOIN ".$phpraid_config['db_prefix']."profile ON
			".$phpraid_config['db_prefix']."profile.priv = ".$phpraid_config['db_prefix']."permissions.permission_id
		WHERE ".$phpraid_config['db_prefix']."profile.profile_id = ".$profile_id;

	$perm_data = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	$permission_val = $db_raid->sql_fetchrow($perm_data, true);
	
	if ($permission_val['perm_val'] == "1")
		return TRUE;
	else
		return FALSE;
}

function delete_permissions() {
	global $db_raid, $phpraid_config;
	
	$id = scrub_input($_GET['perm_id']);
	
	$sql = sprintf("DELETE FROM " . $phpraid_config['db_prefix'] . "permissions WHERE permission_id=%s", quote_smart($id));
	$db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	
	$sql = sprintf("UPDATE " . $phpraid_config['db_prefix'] . "profile SET priv='0' WHERE priv=%s", quote_smart($id));
	$db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
}

function remove_user() {
	global $db_raid, $phpraid_config;

	$user_id = scrub_input($_GET['user_id']);
	$perm_id = scrub_input($_GET['perm_id']);
	
	$sql = sprintf("UPDATE " . $phpraid_config['db_prefix'] . "profile SET priv='0' WHERE profile_id=%s", quote_smart($user_id));
	$sql = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	header("Location: permissions.php?mode=details&perm_id=". $perm_id);
}

//group permission
//get are all classes that could be found (in (cms) bridge)
function get_group_array()
{
	global $db_raid, $table_prefix, $db_raid;

	global $db_group_id, $db_table_group_name, $db_allgroups_name, $db_table_allgroups ;

	$sql =  "SELECT " . $db_group_id . " , ". $db_allgroups_name .
			" FROM " . $table_prefix . $db_table_allgroups .
			" ORDER BY ". $db_group_id;

	$result_group = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	while ($data_wrm = $db_raid->sql_fetchrow($result_group,true))
	{
		array_push($group,
			array(
				'group_name'=>$data[$db_allgroups_name],
				'group_id'=>$data[$db_group_id]
			)
		);
	
	}
	return $group;
}

/**************************************************************
 * WRM Login
 **************************************************************/
function wrm_login()
{
	global $db_user_id, $db_group_id, $db_user_name, $db_user_email, $db_user_password, $db_table_user_name; 
	global $db_table_group_name, $auth_user_class, $auth_alt_user_class, $table_prefix, $db_raid, $phpraid_config;
	global $Bridge2ColumGroup;

	$username = $password = "";
	$username_id = "";
		
	//first login
	if(isset($_POST['username'])){
		// User is logging in, set encryption flag to 0 to identify login with plain text password.
		$pwdencrypt = FALSE;
		//$username = strtolower_wrap(scrub_input($_POST['username']), "UTF-8");
		$password = $_POST['password'];
		$wrmpass = md5($_POST['password']);
		//database
		$sql = sprintf(	"SELECT profile_id " .
						" FROM " . $table_prefix . "profile". 
						" WHERE username = %s", quote_smart($_POST['username'])
					);
		$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
		if ($db_raid->sql_numrows($result) > 0 )
		{
			$data = $db_raid->sql_fetchrow($result, true);
			$username_id = $data['profile_id'];
		}
		else
		{
			wrm_logout();
			return -1;
		}
		
	}// get infos from the COOKIE
	elseif(isset($_COOKIE['profile_id']) && isset($_COOKIE['password'])) {
		// User is not logging in but processing cooking, set encryption flag to 1 to identify login with encrypted password.
		$pwdencrypt = TRUE;
		//$username = strtolower_wrap(scrub_input($_COOKIE['username']), "UTF-8");
		$password = $_COOKIE['password'];
		$username_id = $_COOKIE['profile_id'];
		$wrmpass = '';
	} else {
		wrm_logout();
	}
	
	//database
	$sql = sprintf(	"SELECT ". $db_user_id . "," . $db_user_name . "," . $db_user_email . "," . $db_user_password.
					" FROM " . $table_prefix . $db_table_user_name . 
					" WHERE ". $db_user_id . " = %s", quote_smart($username_id)
			);
			
	$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	$data = $db_raid->sql_fetchrow($result, true);
	

	if( ($username_id == $data[$db_user_id]) && ($cmspass = password_check($password, $data[$db_user_id], $pwdencrypt)) ) 
	{
		// The user has a matching username and proper password in the BRIDGE database.
		// We need to validate the users group.  If it does not contain the user group that has been set as
		//	authorized to use WRM, we need to fail the login with a proper message.		
		if ($auth_user_class != "")
		{
			$FoundUserInGroup = FALSE;
	
			$sql = sprintf( "SELECT " . $db_group_id. "," .$db_add_group_ids ." FROM " . $table_prefix . $db_table_group_name. 
							" WHERE ".$db_user_id." = %s", quote_smart($data[$db_user_id])
					);
			$resultgroup = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
			$datagroup = $db_raid->sql_fetchrow($resultgroup, true);

			/*e107, smf*/
			if ($Bridge2ColumGroup == TRUE)
			{
				if (($datagroup[$db_group_id] == $auth_user_class) or 
					($datagroup[$db_group_id] == $auth_alt_user_class))
				{
					$FoundUserInGroup = TRUE;
				}
				
				if (($datagroup[$db_add_group_ids] == $auth_user_class) or 
					($datagroup[$db_add_group_ids] == $auth_alt_user_class))
				{
					$FoundUserInGroup = TRUE;
				}

			/* old
			$user_class = $datagroup[$db_group_id];
			$user_class = $datagroup[$db_group_id] . "," . $datagroup[$db_add_group_ids];
			
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
			*/
			}
			/* phpbb,...*/
			else
			{
				if( ($datagroup[$db_group_id] == $auth_user_class) or 
					($datagroup[$db_group_id] == $auth_alt_user_class)
				  )
				{	
					$FoundUserInGroup = TRUE;
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
		$_SESSION['username'] = strtolower_wrap($data[$db_user_name], "UTF-8");
		$_SESSION['session_logged_in'] = 1;
		$_SESSION['profile_id'] = $data[$db_user_id];
		$_SESSION['email'] = $data[$db_user_email];

		if ($auth_user_class != "")
		{
			 
			if($phpraid_config['default_group'] != 'nil')
				$user_priv = $phpraid_config['default_group'];
			else
				$user_priv = '0';

			// User is all logged in and setup, the session is initialized properly.  Now we need to create the users
			//    profile in the WRM database if it does not already exist.
			$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "profile WHERE profile_id = %s",
							quote_smart($_SESSION['profile_id'])
					);
			$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
			
			if ($data = $db_raid->sql_fetchrow($result))
			{
				wrm_profile_update_last_login_time($_SESSION['profile_id']);
			}
			else
			{
				wrm_profile_add($data[$db_user_id],$data[$db_user_email],$wrmpass,$user_priv,strtolower_wrap($_SESSION['username'], "UTF-8"));
			}
		}
		else
		{
			wrm_profile_update_last_login_time($_SESSION['profile_id']);
		}
		
		get_permissions();
		
		//security fix
		unset($username);
		unset($password);
		unset($cmspass);
		unset($wrmpass);

		return 1;
	}
	
	return 0;
	
}// end wrm_login()

/**************************************************************
 * add new Profile to WRM
 **************************************************************/
function wrm_profile_add($profile_id,$email,$wrmpass,$user_priv,$username)
{
	global $db_raid, $phpraid_config;
	
	$sql = sprintf("INSERT INTO " . $phpraid_config['db_prefix'] . "profile VALUES (%s, %s, %s, %s, %s, %s)",
				quote_smart($profile_id), quote_smart($email), quote_smart($wrmpass),
				quote_smart($user_priv), quote_smart($username), quote_smart(time())
			);
	$db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
}

/**************************************************************
 * WRM Profile update last_login_time
 **************************************************************/
function wrm_profile_update_last_login_time($profile_id)
{
	global $db_raid, $phpraid_config;

	$sql = sprintf(	"UPDATE " . $phpraid_config['db_prefix'] . 
					"profile SET last_login_time = %s WHERE profile_id = %s",
					quote_smart(time()),quote_smart($profile_id)
			);
	$db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
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
