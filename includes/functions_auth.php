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
	$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(),1);
	$data = $db_raid->sql_fetchrow($result, true);
	
	// check all permissions
	$sql_priv = "SELECT * FROM " . $phpraid_config['db_prefix'] . "permissions WHERE permission_id='{$data['priv']}'";
	$result_priv = $db_raid->sql_query($sql_priv) or print_error($sql_priv, mysql_error(),1);
			
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

	$perm_data = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
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
	$db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
	
	$sql = sprintf("UPDATE " . $phpraid_config['db_prefix'] . "profile SET priv='0' WHERE priv=%s", quote_smart($id));
	$db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
}

function remove_user() {
	global $db_raid, $phpraid_config;

	$user_id = scrub_input($_GET['user_id']);
	$perm_id = scrub_input($_GET['perm_id']);
	
	$sql = sprintf("UPDATE " . $phpraid_config['db_prefix'] . "profile SET priv='0' WHERE profile_id=%s", quote_smart($user_id));
	$sql = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
	header("Location: permissions.php?mode=details&perm_id=". $perm_id);
}

?>