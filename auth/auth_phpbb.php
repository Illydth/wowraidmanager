<?php
/***************************************************************************
 *                                 auth_phpbb.php
 *                            -------------------
 *   begin                : Saturday, Jan 16, 2005
 *   copyright            : (C) 2007-2008 Douglas Wagner
 *   email                : douglasw@wagnerweb.org
 *
 *   $Id: auth_phpbb.php,v 2.00 2007/11/18 17:35:00 psotfx Exp $
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

// define our auth type
if( isset( $_GET["phpbb_root_path"] ) || isset( $_POST["phpbb_root_path"]) )
	log_hack();
		
// check profile
// Specific to phpBB authentication only. Checks to see if a profile exists
// for phpBB user and if not, creates one.
function check_profile($userdata)
{
	global $db_raid, $phpraid_config;
	
	$user_id = $userdata['user_id'];
	$email = $userdata['user_email'];
	
	$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "profile WHERE profile_id='$user_id'";
	$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
	
	//Update email incase it doesn't match phpBB
	if($userdata['user_email'] != $result['email'])
	{
		$sql = "UPDATE " . $phpraid_config['db_prefix'] . "profile SET email='$email' WHERE profile_id='$user_id'";
		$db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
	}
	
	// if nothing returns we need to create profile
	// otherwise they have a profile so let's set their ID
	// we'll just use the phpBB user id as the profile ID to simplify things
	if($db_raid->sql_numrows($result) == 0 && $userdata['username'] != 'Anonymous')
	{
		$user_id = $userdata['user_id'];
		$username = $userdata['username'];
		
		if($phpraid_config['default_group'] != 'nil')
			$default = $phpraid_config['default_group'];
		else
			$default = '0';
		
		// nothing returned, create profile
		$sql = "INSERT INTO " . $phpraid_config['db_prefix'] . "profile (`profile_id`,`email`,`password`,`priv`,`username`)
				VALUES ('$user_id','$email','','$default','$username')";
		$db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
	}
	
	return $userdata['user_id'];
}

// login function for phpBB
function phpraid_login()
{
	global $db, $user_ip;
	
	$username = isset($_POST['username']) ? phpbb_clean_username($_POST['username']) : '';
	$password = isset($_POST['password']) ? $_POST['password'] : '';
		$sql = "SELECT user_id, username, user_password, user_active, user_level
		FROM " . USERS_TABLE . "
		WHERE username = '" . str_replace("\\'", "''", $username) . "'";
		
	if ( !($result = $db->sql_query($sql)) )
		message_die(GENERAL_ERROR, 'Error in obtaining userdata', '', __LINE__, __FILE__, $sql);
		
	if( $row = $db->sql_fetchrow($result, true) )
	{
		if( md5($password) == $row['user_password'] && $row['user_active'] )
		{ 
			// success
			$autologin = ( isset($_POST['autologin']) ) ? TRUE : 0;
			$admin = (isset($_POST['admin'])) ? 1 : 0;
			$session_id = session_begin($row['user_id'], $user_ip, PAGE_INDEX, FALSE, $autologin, $admin);
			
			$sql = sprintf("UPDATE " . $phpraid_config['db_prefix'] . "profile SET last_login_time=%s WHERE profile_id=%s",
							quote_smart(time()),quote_smart($_SESSION['profile_id']));
			$db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
			
			return 1;
		}
		else
		{
			// login failure
			return 0;
		}
	}
}

// logout function for phpBB
function phpraid_logout()
{
	global $userdata;
	
	session_end($userdata['session_id'], $userdata['user_id']);
	clear_session();
}

// database connection
$phpbb_prefix = $phpraid_config['phpbb_prefix'];

global $user_group_table;
$user_group_table = $phpbb_prefix . "user_group";

// setup phpBB user integration
define('IN_PHPBB', true);

$phpbb_root_path = $phpraid_config['phpbb_root_path'];
		
// set this as the path to your phpBB installation
include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'common.'.$phpEx);
	
$userdata = session_pagestart($user_ip, PAGE_INDEX);
init_userprefs($userdata);

// set user variables
$_SESSION['username'] = $userdata['username'];
$_SESSION['session_logged_in'] = $userdata['session_logged_in'];

// check if they have a phpRaid profile yet
// if not, create one if so set profile_id to correct
$_SESSION['profile_id'] = check_profile($userdata);
?>