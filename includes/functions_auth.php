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
	unset($_SESSION['priv_logs']);
	unset($_SESSION['priv_raids']);
	unset($_SESSION['priv_users']);
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
	$data_priv['logs'] ? $_SESSION['priv_logs'] = 1 : $_SESSION['priv_logs'] = 0;
	$data_priv['raids'] ? $_SESSION['priv_raids'] = 1 : $_SESSION['priv_raids'] = 0;
	$data_priv['users'] ? $_SESSION['priv_users'] = 1 : $_SESSION['priv_users'] = 0;
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

//function permissions() {
//	global $db_raid, $wrmsmarty, $phprlang, $phpraid_config;
//	
//	if(!isset($_POST['submit'])) {
//		$users = array();
//		$permission_id = scrub_input($_GET['perm_id']);
//	
//		/*************************************************************
//		 * Setup Record Output Information for Data Table
//		 *************************************************************/
//		// Set StartRecord for Page
//		if(!isset($_GET['Base']) || !is_numeric($_GET['Base']))
//			$startRecord = 1;
//		else
//			$startRecord = scrub_input($_GET['Base']);
//			
//		// Set Sort Field for Page
//		if(!isset($_GET['Sort']))
//			$sortField="";
//		else
//			$sortField = scrub_input($_GET['Sort']);
//				
//		// Set Sort Descending Mark
//		if(!isset($_GET['SortDescending']) || !is_numeric($_GET['SortDescending']))
//			$sortDesc = 1;
//		else
//			$sortDesc = scrub_input($_GET['SortDescending']);
//				
//		$pageURL = 'permissions.php?mode=details&amp;perm_id=' . $permission_id . '&';
//		/**************************************************************
//		 * End Record Output Setup for Data Table
//		 **************************************************************/
//
//		// display users for phpraid authentication and this permission set
//		$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "profile WHERE priv=%s", quote_smart($permission_id));
//		$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
//		
//		while($data = $db_raid->sql_fetchrow($result, true)) {	
//			// set delete permissions 
//			if($_SESSION['priv_permissions'] == 1) {
//				if($permission_id == 1 && $data['profile_id'] == 1) {
//					$delete = '';
//				} else {
//					$delete = '<a href="permissions.php?mode=remove_user&perm_id=' . $permission_id . '&amp;user_id='.$data['profile_id'].'">
//								<img src="templates/' . $phpraid_config['template'] . '/images/icons/icon_delete.gif" border="0" 
//								onMouseover="ddrivetip(\''.$phprlang['remove_user'].'\');" onMouseout="hideddrivetip();" alt="delete icon"></a>';
//				}
//			} else {
//				$delete = '';
//			}
//			
//			$data['username'] = ucwords(mb_strtolower($data['username'], "UTF-8"));
//			
//			array_push($users,
//				array(
//					'ID'=>$data['profile_id'],
//					'Username'=>$data['username'],
//					'E-Mail'=>$data['email'],
//					'Buttons'=>$delete
//				)
//			);
//		}
//		
//		/******************************************************************************
//		 * Code to setup for a Dynamic Table Create: permissions2 View. (User Details)
//		 ******************************************************************************/
//		$viewName = 'permissions2';
//			
//		//Setup Columns
//		$perm2_headers = array();
//		$record_count_array = array();
//		$perm2_headers = getVisibleColumns($viewName);
//		
//		//Get Record Counts
//		$perm2_record_count_array = getRecordCounts($users, $perm2_headers, $startRecord);
//			
//		//Get the Jump Menu and pass it down
//		$perm2JumpMenu = getPageNavigation($users, $startRecord, $pageURL, $sortField, $sortDesc);
//		
//		//Setup Data
//		$users = paginateSortAndFormat($users, $sortField, $sortDesc, $startRecord, $viewName);
//		
//		/****************************************************************
//		 * Data Assign for Template.
//		 ****************************************************************/
//		$wrmsmarty->assign('perm2_data', $users); 
//		$wrmsmarty->assign('perm2_jump_menu', $perm2JumpMenu);
//		$wrmsmarty->assign('column_name', $perm2_headers);
//		$wrmsmarty->assign('perm2_record_counts', $perm2_record_count_array);
//		$wrmsmarty->assign('header_data',
//			array(
//				'template_name'=>$phpraid_config['template'],
//				'users_header'=>$phprlang['permissions_users_header'],
//				'sort_url_base' => $pageURL,
//				'sort_descending' => $sortDesc,
//				'sort_text' => $phprlang['sort_text'],
//			)
//		);
//		
//		// *** ADD USERS TO SET START ***
//		$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "profile WHERE priv='0'";
//		$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
//		
//		$users = array();
//		
//		while($data = $db_raid->sql_fetchrow($result, true)) {
//			$actions = '<input type="checkbox" name="addtolist' . $data['profile_id'] . '" value="' . $data['profile_id'] . '">';
//			array_push($users, 
//				array(
//					'ID'=>$data['profile_id'],
//					'Username'=>ucwords(mb_strtolower($data['username'], "UTF-8")), 
//					'E-Mail'=>$data['email'], 
//					'Buttons'=>$actions
//					)
//			);
//		}
//						
//		$buttons = '<input type="submit" value="'.$phprlang['submit'].'" name="submit" class="mainoption"> 
//					<input type="reset" value="'.$phprlang['reset'].'" name="reset" class="liteoption"></form>';
//
//		/******************************************************************************
//		 * Code to setup for a Dynamic Table Create: permissions2 View. (User Details)
//		 ******************************************************************************/
//		$viewName = 'permissions2';
//			
//		//Setup Columns
//		$perm3_headers = array();
//		$perm3_record_count_array = array();
//		$perm3_headers = getVisibleColumns($viewName);
//		
//		//Get Record Counts
//		$perm3_record_count_array = getRecordCounts($users, $perm3_headers, $startRecord);
//			
//		//Get the Jump Menu and pass it down
//		$perm3JumpMenu = getPageNavigation($users, $startRecord, $pageURL, $sortField, $sortDesc);
//		
//		//Setup Data
//		$users = paginateSortAndFormat($users, $sortField, $sortDesc, $startRecord, $viewName);
//		
//		/****************************************************************
//		 * Data Assign for Template.
//		 ****************************************************************/
//		$wrmsmarty->assign('perm3_data', $users); 
//		$wrmsmarty->assign('perm3_jump_menu', $perm3JumpMenu);
//		$wrmsmarty->assign('column3_name', $perm3_headers);
//		$wrmsmarty->assign('perm3_record_counts', $perm3_record_count_array);
//		$wrmsmarty->assign('header3_data',
//			array(
//				'template_name'=>$phpraid_config['template'],
//				'add_header'=>$phprlang['permissions_add'],
//				'sort_url_base' => $pageURL,
//				'sort_descending' => $sortDesc,
//				'sort_text' => $phprlang['sort_text'],
//				'buttons'=>$buttons,
//				'permission_id'=>$permission_id,
//			)
//		);
//		
//		// page output
//		require_once('includes/page_header.php');
//		$wrmsmarty->display('permissions_details.html');
//		require_once('includes/page_footer.php');
//		exit;
//
//	} else {
//		$priv_id = scrub_input($_GET['perm_id']);
//		foreach($_POST as $key=>$value) {
//			if($key != 'submit') {
//					$sql = sprintf("UPDATE " . $phpraid_config['db_prefix'] . "profile SET priv=%s WHERE profile_id=%s", quote_smart($priv_id), quote_smart($value));
//					$db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
//			}
//		}
//		header("Location: permissions.php?mode=details&perm_id=". $priv_id);
//	}
//}

function remove_user() {
	global $db_raid, $phpraid_config;

	$user_id = scrub_input($_GET['user_id']);
	$perm_id = scrub_input($_GET['perm_id']);
	
	$sql = sprintf("UPDATE " . $phpraid_config['db_prefix'] . "profile SET priv='0' WHERE profile_id=%s", quote_smart($user_id));
	$sql = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
	header("Location: permissions.php?mode=details&perm_id=". $perm_id);
}

?>