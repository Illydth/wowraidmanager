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
	unset($_SESSION['priv_permissions']);
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
	$data_priv['permissions'] ? $_SESSION['priv_permissions'] = 1 : $_SESSION['priv_permissions'] = 0;
}

function delete_permissions() {
	global $db_raid, $phpraid_config;
	
	$id = scrub_input($_GET['perm_id']);
	
	$sql = sprintf("DELETE FROM " . $phpraid_config['db_prefix'] . "permissions WHERE permission_id=%s", quote_smart($id));
	$db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
	
	$sql = sprintf("UPDATE " . $phpraid_config['db_prefix'] . "profile SET priv='0' WHERE priv=%s", quote_smart($id));
	$db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
}

function permissions($report) {
	global $db_raid, $page, $phprlang, $phpraid_config;
	
	if(!isset($_POST['submit'])) {
		$users = array();
		$permission_id = scrub_input($_GET['perm_id']);

		// display users for phpraid authentication and this permission set
		$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "profile WHERE priv=%s", quote_smart($permission_id));
		$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
		
		while($data = $db_raid->sql_fetchrow($result, true)) {	
			// set delete permissions 
			if($_SESSION['priv_permissions'] == 1) {
				if($permission_id == 1 && $data['profile_id'] == 1) {
					$delete = '';
				} else {
					$delete = '<a href="permissions.php?mode=remove_user&perm_id=' . $permission_id . '&amp;user_id='.$data['profile_id'].'">
								<img src="templates/' . $phpraid_config['template'] . '/images/icons/icon_delete.gif" border="0" 
								onMouseover="ddrivetip(\''.$phprlang['remove_user'].'\');" onMouseout="hideddrivetip();" alt="delete icon"></a>';
				}
			} else {
				$delete = '';
			}
			
			$data['username'] = ucwords(strtolower($data['username']));
			
			array_push($users,
				array(
					'id'=>$data['profile_id'],
					'username'=>$data['username'],
					'email'=>$data['email'],
					'admin'=>$delete
				)
			);
		}
		
		// setup report (users)
		setup_output();
		
		$report->showRecordCount(true);
		$report->allowPaging(true, $_SERVER['PHP_SELF'] . '?mode=details&amp;perm_id='.$permission_id.'&Base=');
		$report->setListRange($_GET['Base'], 25);
		$report->allowLink(ALLOW_HOVER_INDEX,'',array());	
		
		//Default sorting
		if(!$_GET['Sort'])
		{
			$report->allowSort(true, 'username', 'ASC', 'permissions.php?mode=details&amp;perm_id=' . $permission_id);
		}
		else
		{
			$report->allowSort(true, $_GET['Sort'], $_GET['SortDescending'], 'permissions.php?mode=details&amp;perm_id=' . $permission_id);
		}
		
		if($phpraid_config['show_id'] == 1)
			$report->addOutputColumn('id',$phprlang['id'],'','center');
		$report->addOutputColumn('username',$phprlang['username'],'','left');
		$report->addOutputColumn('email',$phprlang['email'],'','left');
		$report->addOutputColumn('admin','','','right');
		$users = $report->getListFromArray($users);
		
		$page->set_file('details',$phpraid_config['template'] . '/permissions_details.htm');
		$page->set_var(
			array(
				'users_header'=>$phprlang['permissions_users_header'],
				'users'=>$users,
			)
		);
		
		$page->parse('output','details',true);
			
		// show add information
		$page->set_file('add',$phpraid_config['template'] . '/permissions_add.htm');
		
		$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "profile WHERE priv='0'";
		$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
		
		$users = array();
		
		while($data = $db_raid->sql_fetchrow($result, true)) {
			$actions = '<input type="checkbox" name="addtolist' . $data['profile_id'] . '" value="' . $data['profile_id'] . '">';
			array_push($users, array('id'=>$data['profile_id'],'username'=>ucwords(strtolower($data['username'])), 'email'=>$data['email'], 'actions'=>$actions));
		}
				
		$add_body = '<form action="permissions.php?mode=details&amp;perm_id=' . $permission_id . '" method="POST">';
		
		// setup report (users)
		$report->clearOutputColumns();
		//Default sorting
		if(!$_GET['Sort'])
		{
			$report->allowSort(true, 'username', 'ASC', 'permissions.php?mode=details&amp;perm_id=' . $permission_id);
		}
		else
		{
			$report->allowSort(true, $_GET['Sort'], $_GET['SortDescending'], 'permissions.php?mode=details&amp;perm_id=' . $permission_id);
		}
		setup_output();
		
		$report->showRecordCount(true);
		$report->allowPaging(true, $_SERVER['PHP_SELF'] . '?mode=details&amp;perm_id=' . $permission_id . '&Base=');
		$report->setListRange($_GET['Base'], 25);
		$report->allowLink(ALLOW_HOVER_INDEX,'',array());
		
		if($phpraid_config['show_id'] == 1)
			$report->addOutputColumn('id',$phprlang['id'],'','center');
		$report->addOutputColumn('username',$phprlang['username'],'','left');
		$report->addOutputColumn('email',$phprlang['email'],'','left');
		$report->addOutputColumn('actions','','','right',__NOLINK__);
		$add_body .= $report->getListFromArray($users);
		
		$buttons = '<input type="submit" value="'.$phprlang['submit'].'" name="submit" class="mainoption"> 
					<input type="reset" value="'.$phprlang['reset'].'" name="reset" class="liteoption"></form>';
		
		$page->set_var(
			array(
				'add_header'=>$phprlang['permissions_add'],
				'add_body'=>$add_body,
				'buttons'=>$buttons,
			)
		);
			
		$page->parse('output','add',true);
	} else {
		$priv_id = scrub_input($_GET['perm_id']);
		foreach($_POST as $key=>$value) {
			if($key != 'submit') {
					$sql = sprintf("UPDATE " . $phpraid_config['db_prefix'] . "profile SET priv=%s WHERE profile_id=%s", quote_smart($priv_id), quote_smart($value));
					$db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
			}
		}
		header("Location: permissions.php?mode=details&perm_id=". $priv_id);
	}
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