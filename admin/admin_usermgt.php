<?php
/***************************************************************************
 *                             admin_usermgt.php
 *                            -------------------
 *   begin                : Thursday, May 14, 2009
 *   copyright            : (C) 2007-2009 Douglas Wagner
 *   email                : douglasw@wagnerweb.org
 *
 ***************************************************************************/

/***************************************************************************
*
*    WoW Raid Manager - Raid Management Software for World of Warcraft
*    Copyright (C) 2007-2009 Douglas Wagner
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
// commons
define("IN_PHPRAID", true);
require_once('./admin_common.php');

// page authentication
define("PAGE_LVL","configuration");
require_once("../includes/authentication.php");	

isset($_GET['mode']) ? $mode = scrub_input($_GET['mode']) : $mode = '';

if($mode == '')
	log_hack();

if($mode == 'view')
{
	/*************************************************************
	 * Setup Record Output Information for Data Table
	 *************************************************************/
	// Set StartRecord for Page
	if(!isset($_GET['Base']) || !is_numeric($_GET['Base']))
		$startRecord = 1;
	else
		$startRecord = scrub_input($_GET['Base']);
	
	// Set Sort Field for Page
	if(!isset($_GET['Sort'])||$_GET['Sort']=='')
	{
		$sortField="";
		$initSort=FALSE;
	}
	else
	{
		$sortField = scrub_input($_GET['Sort']);
		$initSort=TRUE;
	}
		
	// Set Sort Descending Mark
	if(!isset($_GET['SortDescending']) || !is_numeric($_GET['SortDescending']))
		$sortDesc = 0;
	else
		$sortDesc = scrub_input($_GET['SortDescending']);
		
	$pageURL = 'admin_usermgt.php?mode=view&';
	/**************************************************************
	 * End Record Output Setup for Data Table
	 **************************************************************/
	// Generate the Update Permissions form elements
	$form_action = "admin_usermgt.php?mode=mod_perms";
	$form_buttons = '<input type="submit" name="submit" value="'.$phprlang['submit'].'" class="mainoption"> <input type="reset" name="Reset" value="'.$phprlang['reset'].'" class="liteoption">';
	$priv_dropdown = '<select name="perm_id">';
	$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "permissions";
	$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);			
	while($perm_data = $db_raid->sql_fetchrow($result, true))
	{
		$priv_dropdown .= "<option value=\"" . $perm_data['permission_id'] . "\">" . $perm_data['name']."</option>";
	}
	$priv_dropdown .= '</select>';
		
	$users = array();

	// get a list of all users and assign permissions accordingly
	$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "profile";
	$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	
	while($data = $db_raid->sql_fetchrow($result, true))
	{
		$usersname = '<!-- ' . strtolower_wrap($data['username'], "UTF-8") . ' --><a href="admin_usermgt.php?mode=details&amp;user_id='.$data['profile_id'].'">'.$data['username'].'</a>';

		$priv = '<a href="admin_permissions.php?mode=view">'.get_priv_name($data['priv']).'</a>';

		$actions = '<a href="admin_usermgt.php?mode=remove_user&amp;n='.$data['username'].'&amp;user_id='.$data['profile_id'].'">
					<img src="../templates/' . $phpraid_config['template'] . '/images/icons/icon_delete.gif" border="0"
					onMouseover="ddrivetip(\''. $phprlang['delete'] .'\');" onMouseout="hideddrivetip();" alt="delete icon"></a>';
		
		$date = !($data['last_login_time'])?'':new_date('Y/m/d H:i:s',$data['last_login_time'],$phpraid_config['timezone'] + $phpraid_config['dst']);
		$time = !($data['last_login_time'])?'':new_date('Y/m/d H:i:s',$data['last_login_time'],$phpraid_config['timezone'] + $phpraid_config['dst']);
		
		$mod_perm='<input type="checkbox" name="modperm' . $data['profile_id'] . '" value="' . $data['profile_id'] . '">';		
		
		array_push($users, 
			array(
				'ID'=>$data['profile_id'],
				'Username'=>$usersname,
				'Privileges'=>$priv,
				'E-Mail'=>$data['email'],
				'Last Login Date'=>$date,
				'Last Login Time'=>$time,
				'Permission_Mod'=>$mod_perm,
				'Buttons'=>$actions
			)
		);
	}

	/**************************************************************
	 * Code to setup for a Dynamic Table Create: users1 View.
	 **************************************************************/
	$viewName = 'users1';
	
	//Setup Columns
	$users_headers = array();
	$record_count_array = array();
	$users_headers = getVisibleColumns($viewName);

	//Get Record Counts
	$users_record_count_array = getRecordCounts($users, $raid_headers, $startRecord);
	
	//Get the Jump Menu and pass it down
	$usersJumpMenu = getPageNavigation($users, $startRecord, $pageURL, $sortField, $sortDesc);

	//Setup Default Data Sort from Headers Table
	if (!$initSort)
		foreach ($users_headers as $column_rec)
			if ($column_rec['default_sort'])
				$sortField = $column_rec['column_name'];
	
	//Setup Data
	$users = paginateSortAndFormat($users, $sortField, $sortDesc, $startRecord, $viewName);

	/****************************************************************
	 * Data Assign for Template.
	 ****************************************************************/
	$wrmadminsmarty->assign('users_data', $users); 
	$wrmadminsmarty->assign('users_jump_menu', $usersJumpMenu);
	$wrmadminsmarty->assign('column_name', $users_headers);
	$wrmadminsmarty->assign('users_record_counts', $users_record_count_array);
	$wrmadminsmarty->assign('header_data',
		array(
			'template_name'=>$phpraid_config['template'],
			'users_header' => $phprlang['users_header'],
			'new_raids_header' => $phprlang['raids_new'],
			'sort_url_base' => $pageURL,
			'sort_descending' => $sortDesc,
			'sort_text' => $phprlang['sort_text'],
		)
	);
	
	$wrmadminsmarty->assign('perm_mod_data', 
		array(
			'form_action' => $form_action,
			'perm_mod_header' => $phpraid['configuration_users_modperm_header'],
			'priv_dropdown' => $priv_dropdown,
			'dropdown_desc' => $phpraid['configuration_users_modperm_desc'],
			'action_buttons' => $form_buttons,
		)
	);
	
}
else if($mode == 'details')
{
	// detailed information
	$chars = array();
	$user_id = scrub_input($_GET['user_id']);
	
	/*************************************************************
	 * Setup Record Output Information for Data Table
	 *************************************************************/
	// Set StartRecord for Page
	if(!isset($_GET['Base']) || !is_numeric($_GET['Base']))
		$startRecord = 1;
	else
		$startRecord = scrub_input($_GET['Base']);
	
	// Set Sort Field for Page
	if(!isset($_GET['Sort'])||$_GET['Sort']=='')
	{
		$sortField="";
		$initSort=FALSE;
	}
	else
	{
		$sortField = scrub_input($_GET['Sort']);
		$initSort=TRUE;
	}
		
	// Set Sort Descending Mark
	if(!isset($_GET['SortDescending']) || !is_numeric($_GET['SortDescending']))
		$sortDesc = 0;
	else
		$sortDesc = scrub_input($_GET['SortDescending']);
		
	$pageURL = 'admin_usermgt.php?mode=details&user_id='.$user_id.'&';
	/**************************************************************
	 * End Record Output Setup for Data Table
	 **************************************************************/
		
	// check valid input
	$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "profile WHERE profile_id=%s",quote_smart($user_id));
	$result = $db_raid->sql_query($sql) or print_error($sql,$db_raid->sql_error(),1);
	if($db_raid->sql_numrows($result) == 0)
	{
		// invalid user
		$errorMsg = $phprlang['no_user_msg'];
		$errorTitle = $phprlang['no_user_title'];
		$errorDie = 1;
	}

	$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "chars WHERE profile_id=%s",quote_smart($user_id));
	$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	
	while($data = $db_raid->sql_fetchrow($result, true))
	{
		array_push($chars,
			array(
				'ID'=>$data['char_id'],
				'Name'=>get_armorychar($data['name'], $data['guild']), // Buggy
				'Guild'=>$data['guild'],
				'Level'=>$data['lvl'],
				'Race'=>$data['race'],
				'Role'=>$data['role'],
				'Class'=>$data['class'],
				'Arcane'=>$data['arcane'],
				'Fire'=>$data['fire'],
				'Frost'=>$data['frost'],
				'Nature'=>$data['nature'],
				'Shadow'=>$data['shadow'],
				'Pri_Spec'=>$data['pri_spec'],
				'Sec_Spec'=>$data['sec_spec'],
				'Buttons'=>'<a href="users.php?mode=remove_char&amp;n='.$data['name'].'&amp;char_id='.$data['char_id'].'&amp;user_id='.$data['profile_id'].'"><img src="../templates/' . $phpraid_config['template'] . '/images/icons/icon_delete.gif" border="0" onMouseover="ddrivetip(\''. $phprlang['delete'] .'\');" onMouseout="hideddrivetip();" alt="delete icon"></a>')
			);
	}

	/**************************************************************
	 * Code to setup for a Dynamic Table Create: char1 View.
	 **************************************************************/
	$viewName = 'char1';
	
	//Setup Columns
	$char_headers = array();
	$record_count_array = array();
	$char_headers = getVisibleColumns($viewName);

	//Get Record Counts
	$char_record_count_array = getRecordCounts($chars, $char_headers, $startRecord);
	
	//Get the Jump Menu and pass it down
	$charJumpMenu = getPageNavigation($chars, $startRecord, $pageURL, $sortField, $sortDesc);

	//Setup Default Data Sort from Headers Table
	if (!$initSort)
		foreach ($char_headers as $column_rec)
			if ($column_rec['default_sort'])
				$sortField = $column_rec['column_name'];
	
	//Setup Data
	$chars = paginateSortAndFormat($chars, $sortField, $sortDesc, $startRecord, $viewName);

	/****************************************************************
	 * Data Assign for Template.
	 ****************************************************************/
	$wrmadminsmarty->assign('char_data', $chars); 
	$wrmadminsmarty->assign('char_jump_menu', $charJumpMenu);
	$wrmadminsmarty->assign('column_name', $char_headers);
	$wrmadminsmarty->assign('char_record_counts', $char_record_count_array);
	$wrmadminsmarty->assign('header_data',
		array(
			'template_name'=>$phpraid_config['template'],
			'char_header' => $phprlang['users_char_header'],
			'sort_url_base' => $pageURL,
			'sort_descending' => $sortDesc,
			'sort_text' => $phprlang['sort_text'],
		)
	);

	require_once('includes/admin_page_header.php');
	$wrmadminsmarty->display('admin_user_details.html');
	require_once('includes/admin_page_footer.php');
	exit;
}
else if($mode == 'remove_user')
{
	$user_id = scrub_input($_GET['user_id']);
	$delete_name = scrub_input($_GET['n']);

	if(!isset($_POST['submit'])) {
		$form_action = 'admin_usermgt.php?mode=remove_user&amp;user_id='.$user_id.'&amp;n='.$delete_name;
		$confirm_button = '<input type="submit" value="'.$phprlang['confirm'].'" name="submit" class="post">';

		$wrmadminsmarty->assign('page',
			array(
				'form_action'=>$form_action,
				'confirm_button'=>$confirm_button,
				'delete_header'=>$phprlang['confirm_deletion'],
				'delete_msg'=>$phprlang['delete_msg'],
			)
		);
		//
		// Start output of Delete Page
		//
		require_once('includes/admin_page_header.php');
		$wrmadminsmarty->display('../delete.html');
		require_once('includes/admin_page_footer.php');		
	} else {
		log_delete('user',$delete_name);

		$sql = sprintf("DELETE FROM " . $phpraid_config['db_prefix'] . "profile WHERE profile_id=%s", quote_smart($user_id));
		$db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);

		$sql = sprintf("DELETE FROM " . $phpraid_config['db_prefix'] . "chars WHERE profile_id=%s", quote_smart($user_id));
		$db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);

		$sql = sprintf("DELETE FROM " . $phpraid_config['db_prefix'] . "signups WHERE profile_id=%s", quote_smart($user_id));
		$db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);

		header("Location: admin_usermgt.php?mode=view");
	}
}
else if($mode == 'remove_char')
{
	$char_id = scrub_input($_GET['char_id']);
	$user_id = scrub_input($_GET['user_id']);
	$delete_name = scrub_input($_GET['n']);

	if(!isset($_POST['submit'])) {
		$form_action = 'admin_usermgt.php?mode=remove_char&amp;char_id='.$char_id.'&amp;user_id='.$user_id.'&amp;n='.$delete_name;
		$confirm_button = '<input type="submit" value="'.$phprlang['confirm'].'" name="submit" class="post">';

		$wrmadminsmarty->assign('page',
			array(
				'form_action'=>$form_action,
				'confirm_button'=>$confirm_button,
				'delete_header'=>$phprlang['confirm_deletion'],
				'delete_msg'=>$phprlang['delete_msg'],
			)
		);
		//
		// Start output of Delete Page
		//
		require_once('includes/admin_page_header.php');
		$wrmadminsmarty->display('../delete.html');
		require_once('includes/admin_page_footer.php');		
	} else {
		log_delete('character',$delete_name);

		$sql = sprintf("DELETE FROM " . $phpraid_config['db_prefix'] . "chars WHERE char_id=%s", quote_smart($char_id));
		$db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);

		$sql = sprintf("DELETE FROM " . $phpraid_config['db_prefix'] . "signups WHERE char_id=%s", quote_smart($char_id));
		$db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);

		header("Location: admin_usermgt.php?mode=details&user_id=$user_id");
	}
}
else if ($mode == 'mod_perms')
{
	$perm_id = scrub_input($_POST['perm_id']);
	$errorDie = 0;
	$admin_count = 0;
	
	if ($perm_id != '1')
	{
		//Now we need to protect users from themselves, we need to verify that we're not 
		//  unsetting the only WRM Superadmin in the system to an unprivlidged user thus
		//  locking out anyone from admining the system.

		//Start by pulling each users current Permission ID and verify whether or not we're
		//  moving from PermID:1 -> Another Perm ID.
		foreach($_POST as $key=>$value)
		{
			if(strpos($key, 'modperm')!==FALSE)
			{
				$sql = sprintf("SELECT priv FROM " . $phpraid_config['db_prefix'] . "profile
						WHERE profile_id = %s", quote_smart($value));
				$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
				$data = $db_raid->sql_fetchrow($result, true);
				if ($data['priv'] == '1')
					$admin_count++;
			}
		}
		// We now have the number of admins being changed out of Admin Status, now check
		//   total admins in the system.
		$sql = "SELECT priv FROM " . $phpraid_config['db_prefix'] . "profile WHERE priv = '1'";
		$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
		$numrows = $db_raid->sql_numrows($result);
		if($numrows<=$admin_count)
		{
			// They're being stupid and setting the last WRM Superadmin to another value, stop them.
			$errorMsg = $phprlang['configuration_permission_cannot_modify'];
			$errorTitle = $phprlang['form_error'];
			$errorDie = 1;
		}					
		else 
		{
			// The transaction is fine, process it.
			foreach($_POST as $key=>$value)
			{
				if(strpos($key, 'modperm')!==FALSE)
				{
					$cht_profile_id = $value;
					$sql = sprintf("UPDATE " . $phpraid_config['db_prefix'] . "profile
								SET priv=%s WHERE profile_id = %s", quote_smart($perm_id),quote_smart($cht_profile_id));
					$db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
					
					log_create('profile_update',mysql_insert_id(),$title);
				}
			}
			header("Location: admin_usermgt.php?mode=view");
		}	
	}
	else 
	{
		// We're updating TO WRM Superadmin, just process it.
		foreach($_POST as $key=>$value)
		{
			if(strpos($key, 'modperm')!==FALSE)
			{
				$cht_profile_id = $value;
				$sql = sprintf("UPDATE " . $phpraid_config['db_prefix'] . "profile
							SET priv=%s WHERE profile_id = %s", quote_smart($perm_id),quote_smart($cht_profile_id));
				$db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
				
				log_create('profile_update',mysql_insert_id(),$title);
			}
		}
		header("Location: admin_usermgt.php?mode=view");		
	}
}
else
{
	$errorMsg = $phprlang['invalid_option_msg'];
	$errorTitle = $phprlang['invalid_option_title'];
	$errorDie = 1;
}

require_once('includes/admin_page_header.php');
$wrmadminsmarty->display('admin_user_management.html');
require_once('includes/admin_page_footer.php');

?>
