<?php
/***************************************************************************
                                admin_index.php
 *                            -------------------
 *   begin                : Monday, May 11, 2009
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

/*************************************************
 * Access Authorization Section
 *************************************************/
// page authentication
define("PAGE_LVL","configuration");
require_once("../includes/authentication.php");	

/* 
 * Data for Index Page
 */
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
	
$pageURL = 'admin_rolecfg.php?mode=view&';
/**************************************************************
 * End Record Output Setup for Data Table
 **************************************************************/
if($_GET['mode'] != 'remove') 
{
	//Process current Roles into Data Table.
	$roles = array();

	$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "roles";
	$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);

	while($global_role = $db_raid->sql_fetchrow($result, true))
	{
		$imgDelete = '<img src="../templates/'.$phpraid_config['template'].'/images/icons/icon_delete.gif" border="0" alt="delete" />';
		$urlDelete = 'admin_rolecfg.php?mode=remove&amp;roleid='.$global_role['role_id'];
		$delete = cssToolTip($imgDelete, $phprlang['delete'], 'smallIconText', $urlDelete);
		$imgEdit = '<img src="../templates/'.$phpraid_config['template'].'/images/icons/icon_edit.gif" border="0" alt="edit" />';
		$urlEdit= 'admin_rolecfg.php?mode=edit&amp;roleid='.$global_role['role_id'];
		$edit = cssToolTip($imgEdit, $phprlang['edit'], 'smallIconText', $urlEdit);
		array_push($roles,
			array(
				'ID' => $global_role['role_id'],
				'Role Name' => $global_role['role_name'],
				'Config Text' => $global_role['lang_index'],
				'Image' => $global_role['image'],
				'Buttons'=>$edit . $delete//'<a href="admin_rolecfg.php?mode=remove&amp;roleid='.$global_role['role_id'].'"><img src="../templates/' . $phpraid_config['template'] . '/images/icons/icon_delete.gif" border="0" onMouseover="ddrivetip(\''. $phprlang['delete'] .'\');" onMouseout="hideddrivetip();" alt="delete icon"></a>
					//<a href="admin_rolecfg.php?mode=edit&amp;roleid='.$global_role['role_id'].'"><img src="../templates/' . $phpraid_config['template'] . '/images/icons/icon_edit.gif" border="0" onMouseover="ddrivetip(\'' . $phprlang['edit'] .'\');" onMouseout="hideddrivetip();" alt="edit icon"></a>'				
				
			)
		);
	}

	/**************************************************************
	 * Code to setup for a Dynamic Table Create: guild1 View.
	 **************************************************************/
	$viewName = 'role1';
	
	//Setup Columns
	$role_headers = array();
	$record_count_array = array();
	$role_headers = getVisibleColumns($viewName);

	//Get Record Counts
	$role_record_count_array = getRecordCounts($roles, $role_headers, $startRecord);
	
	//Get the Jump Menu and pass it down
	$roleJumpMenu = getPageNavigation($roles, $startRecord, $pageURL, $sortField, $sortDesc);
			
	//Setup Default Data Sort from Headers Table
	if (!$initSort)
		foreach ($role_headers as $column_rec)
			if ($column_rec['default_sort'])
				$sortField = $column_rec['column_name'];

	//Setup Data
	$roles = paginateSortAndFormat($roles, $sortField, $sortDesc, $startRecord, $viewName);

	/****************************************************************
	 * Data Assign for Template.
	 ****************************************************************/
	$wrmadminsmarty->assign('role_data', $roles); 
	$wrmadminsmarty->assign('role_jump_menu', $roleJumpMenu);
	$wrmadminsmarty->assign('role_column_name', $role_headers);
	$wrmadminsmarty->assign('role_record_counts', $role_record_count_array);
	$wrmadminsmarty->assign('header_data',
		array(
			'template_name'=>$phpraid_config['template'],
			'role_header' => $phprlang['configuration_role_header'],
			'sort_url_base' => $pageURL,
			'sort_descending' => $sortDesc,
			'sort_text' => $phprlang['sort_text'],
		)
	);
	
} elseif($_GET['mode'] == 'remove') {
	$roleid = scrub_input($_GET['roleid']);

	if(!isset($_POST['submit']))
	{
		$form_action = "admin_rolecfg.php?mode=remove&amp;roleid=$roleid";
		$confirm_button = '<input name="submit" type="submit" id="submit" value="'.$phprlang['confirm_deletion'].'" class="mainoption">';

		$wrmadminsmarty->assign('page',
			array(
				'form_action'=>$form_action,
				'confirm_button'=>$confirm_button,
				'delete_header'=>$phprlang['confirm_deletion'],
				'delete_msg'=>$phprlang['delete_msg'],
				)
			);
		//
		// Start output of delete page.
		//
		require_once('./includes/admin_page_header.php');
		$wrmadminsmarty->display('../delete.html');
		require_once('./includes/admin_page_footer.php');
		
		exit;
	}
	else
	{
		log_delete('character',$n);

		$sql = sprintf("DELETE FROM " . $phpraid_config['db_prefix'] . "roles WHERE role_id=%s",quote_smart($roleid));
		$db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);

		header("Location: admin_rolecfg.php?mode=view");
	}
} 

if(($_GET['mode'] == 'new' || $_GET['mode'] == 'edit')) {
	if($_GET['mode'] == 'new') {
		// check for errors
		$new_role_id = scrub_input($_POST['role_id']);
		$role_name = scrub_input($_POST['role_name']);
		$role_config_text = scrub_input($_POST['role_config']);
		$role_image = scrub_input($_POST['role_image']);
	} else {
		// edit, grab from database
		$role_id = scrub_input($_GET['roleid']);

		$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "roles WHERE role_id=%s",quote_smart($role_id));
		$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
		$data = $db_raid->sql_fetchrow($result, true);
		
		$new_role_id = $data['role_id'];
		$role_name = $data['role_name'];
		$role_config_text = $data['lang_index'];
		$role_image = $data['role_image'];
	}

	if(isset($_POST['submit'])) {
		$new_role_id = scrub_input($_POST['role_id']);
		$role_name = scrub_input($_POST['role_name']);
		$role_config_text = scrub_input($_POST['role_config']);
		$role_image = scrub_input($_POST['role_image']);
		
		// ERROR CHECKING
		// Setup Error Vars
		$errorDie = 0;
		$errorMsg = '<ul>';
		$errorTitle = $phprlang['form_error'];
		
		// Verify Role not Already in Database
		if ($_GET['mode'] == 'new' || $role_id != $new_role_id)
		{
			$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "roles WHERE role_id=%s",quote_smart($new_role_id));
			$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
			if($numrows = $db_raid->sql_numrows($result)>0)
				$errorMsg .= '<li>'.$phprlang['role_error_exists'].'</li>';
		}
		if($new_role_id == '')
			$errorMsg .= '<li>'.$phprlang['role_error_role_id_blank'].'</li>';
		if($role_name == '')
			$errorMsg .= '<li>'.$phprlang['role_error_role_name_blank'].'</li>';
		if($role_config_text == '')
			$errorMsg .= '<li>'.$phprlang['role_error_role_config_blank'].'</li>';
			
		$errorMsg .= '</ul>';

		if($errorMsg != '<ul></ul>')
		{
			$errorDie = 1;
		}
		else
		{
			// all is good add to database
			if($_GET['mode'] == 'new') {
				$sql = sprintf("INSERT INTO " . $phpraid_config['db_prefix'] . 
				"roles (`role_id`,`role_name`,`lang_index`,`image`)
				VALUES(%s,%s,%s,%s)",quote_smart($new_role_id),quote_smart($role_name),
				quote_smart($role_config_text),quote_smart($role_image));
				
				$db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);

				log_create('role',mysql_insert_id(),$name);
			} elseif($_GET['mode'] == 'edit') {
				//echo "Orig Role ID: " . $role_id;
				//echo "<br>New Role ID: " . $new_role_id;
				$sql = sprintf("UPDATE " . $phpraid_config['db_prefix'] . "roles 
				SET role_id=%s,role_name=%s,lang_index=%s,image=%s WHERE role_id=%s",
				quote_smart($new_role_id),quote_smart($role_name),
				quote_smart($role_config_text), quote_smart($role_image),
				quote_smart($role_id));
	
				//echo "<br>SQL: " . $sql;
				
				$db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
			}
			header("Location: admin_rolecfg.php?mode=view");
		}
	}
}

// Display the Add New / Edit Form.
$role_id_box = '<input type="text" name="role_id" class="post" value="' . $role_id . '" style="width:100px">';
$role_name_box = '<input type="text" name="role_name" class="post" value="' . $role_name . '" style="width:100px">';
$role_config_box = '<input type="text" name="role_config" class="post" value="' . $role_config_text . '" style="width:200px">';
$role_image_box = '<input type="text" name="role_image" class="post" value="' . $role_image . '" style="width:400px">';

if($_GET['mode'] == 'view' || $_GET['mode'] == 'new')
	$form_action = 'admin_rolecfg.php?mode=new';
else
	$form_action = 'admin_rolecfg.php?mode=edit&amp;roleid='.$role_id;

if($_GET['mode'] == 'view' || $_GET['mode'] == 'new') {
	$buttons = '<input type="submit" name="submit" value="'.$phprlang['addrole'].'" class="mainoption"> <input type="reset" name="Reset" value="'.$phprlang['reset'].'" class="liteoption">';
} else {
	$buttons = '<input type="submit" name="submit" value="'.$phprlang['updaterole'].'" class="mainoption"> <input type="reset" name="Reset" value="'.$phprlang['reset'].'" class="liteoption">';
}

if($_GET['mode'] == 'view' || $_GET['mode'] == 'new')
	$role_new_edit_header = $phprlang['configuration_role_new_header'];
else 
	$role_new_edit_header = $phprlang['configuration_role_edit_header'];

$wrmadminsmarty->assign('role_new',
	array(
		'roleID_text' => $phprlang['role_id'],
		'roleName_text' => $phprlang['role_name'],
		'roleConfig_text' => $phprlang['role_config'],
		'roleImage_text' => $phprlang['role_image'],
		'role_id' => $role_id_box,
		'role_name' => $role_name_box,
		'role_config' => $role_config_box,
		'role_image' => $role_image_box,
		'role_new_edit_header'=>$role_new_edit_header,
		'form_action' => $form_action,
		'buttons' => $buttons,
	)
);

//
// Start output of the page.
//
require_once('./includes/admin_page_header.php');
$wrmadminsmarty->display('admin_role_config.html');
require_once('./includes/admin_page_footer.php');

?>
