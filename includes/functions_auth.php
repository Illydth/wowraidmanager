<?php
/***************************************************************************
*                           functions_auth.php
*                           ---------------------
*   begin                : Monday, May 26, 2006
*   copyright            : (C) 2005 Kyle Spraggs
*   email                : spiffyjr@gmail.com
*
*   $Id: mysql.php,v 1.16 2002/03/19 01:07:36 psotfx Exp $
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
	
	$profile_id = $_SESSION['profile_id'];

	$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "profile WHERE profile_id='$profile_id'";
	$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(),1);
	$data = $db_raid->sql_fetchrow($result);
	
	// check all permissions
	$sql_priv = "SELECT * FROM " . $phpraid_config['db_prefix'] . "permissions WHERE permission_id='{$data['priv']}'";
	$result_priv = $db_raid->sql_query($sql_priv) or print_error($sql_priv, mysql_error(),1);
			
	$data_priv = $db_raid->sql_fetchrow($result_priv);
	
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
	
	$id = $_GET['id'];
	
	$sql = "DELETE FROM " . $phpraid_config['db_prefix'] . "permissions WHERE permission_id='$id'";
	$db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
	
	$sql = "UPDATE " . $phpraid_config['db_prefix'] . "profile SET priv='0' WHERE priv='$id'";
	$db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
}

function permissions($report) {
	global $db_raid, $page, $phprlang, $phpraid_config;
	
	if(!isset($_POST['submit'])) {
		$users = array();
		$id = $_GET['id'];
		
		// display users for phpraid authentication and this permission set
		$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "profile WHERE priv='$id'";
		$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
		
		while($data = $db_raid->sql_fetchrow($result)) {	
			// set delete permissions 
			if($_SESSION['priv_permissions'] == 1) {
				if($id == 1 && $data['profile_id'] == 1) {
					$delete = '';
				} else {
					$delete = '<a href="permissions.php?mode=remove_user&priv_id=' . $id . '&user_id='.$data['profile_id'].'">
								<img src="templates/' . $phpraid_config['template'] . '/images/icons/icon_delete.gif" border="0" 
								onMouseover="ddrivetip(\''.$phprlang['remove_user'].'\')"; onMouseout="hideddrivetip()"></a>';
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
		$report->allowPaging(true, $_SERVER['PHP_SELF'] . '?mode=details&id='.$_GET['id'].'&Base=');
		$report->setListRange($_GET['Base'], 25);
		$report->allowLink(ALLOW_HOVER_INDEX,'',array());	
		
		//Default sorting
		if(!$_GET['Sort'])
		{
			$report->allowSort(true, 'username', 'ASC', 'permissions.php?mode=details&id=' . $_GET['id']);
		}
		else
		{
			$report->allowSort(true, $_GET['Sort'], $_GET['SortDescending'], 'permissions.php?mode=details&id=' . $_GET['id']);
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
		
		while($data = $db_raid->sql_fetchrow($result)) {
			$actions = '<input type="checkbox" name="addtolist' . $data['profile_id'] . '" value="' . $data['profile_id'] . '">';
			array_push($users, array('id'=>$data['profile_id'],'username'=>ucwords(strtolower($data['username'])), 'email'=>$data['email'], 'actions'=>$actions));
		}
				
		$add_body = '<form action="permissions.php?mode=details&id=' . $id . '" method="POST">';
		
		// setup report (users)
		$report->clearOutputColumns();
		//Default sorting
		if(!$_GET['Sort'])
		{
			$report->allowSort(true, 'username', 'ASC', 'permissions.php?mode=details&id=' . $_GET['id']);
		}
		else
		{
			$report->allowSort(true, $_GET['Sort'], $_GET['SortDescending'], 'permissions.php?mode=details&id=' . $_GET['id']);
		}
		setup_output();
		
		$report->showRecordCount(true);
		$report->allowPaging(true, $_SERVER['PHP_SELF'] . '?mode=details&id=' . $id . '&Base=');
		$report->setListRange($_GET['Base'], 25);
		$report->allowLink(ALLOW_HOVER_INDEX,'',array());
		
		if($phpraid_config['show_id'] == 1)
			$report->addOutputColumn('id',$phprlang['id'],'','center');
		$report->addOutputColumn('username',$phprlang['username'],'','left');
		$report->addOutputColumn('email',$phprlang['email'],'','left');
		$report->addOutputColumn('actions','','','right',__NOLINK__);
		$add_body .= $report->getListFromArray($users);
		
		$buttons = '<input type="submit" value="Submit" name="submit" class="mainoption"> 
					<input type="reset" value="Reset" name="reset" class="liteoption"></form>';
		
		$page->set_var(
			array(
				'add_header'=>$phprlang['permissions_add'],
				'add_body'=>$add_body,
				'buttons'=>$buttons,
			)
		);
			
		$page->parse('output','add',true);
	} else {
		$priv_id = $_GET['id'];
		foreach($_POST as $key=>$value) {
			if($key != 'submit') {
					$sql = "UPDATE " . $phpraid_config['db_prefix'] . "profile SET priv='$priv_id' WHERE profile_id='$value'";
					$db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
			}
		}
		header("Location: permissions.php?mode=details&id=$priv_id");
	}
}

function remove_user() {
	global $db_raid, $phpraid_config;
	
	$user_id = $_GET['user_id'];
	$priv_id = $_GET['priv_id'];
	
	$sql = "UPDATE " . $phpraid_config['db_prefix'] . "profile SET priv='0' WHERE profile_id='$user_id'";
	$sql = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
	header("Location: permissions.php?mode=details&id=$priv_id");
}

?>