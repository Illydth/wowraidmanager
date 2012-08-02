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
	
$pageURL = 'admin_roletalent.php?mode=view&';
/**************************************************************
 * End Record Output Setup for Data Table
 **************************************************************/
if($_GET['mode'] != 'remove') 
{
	//Pull the Class Role table and put it into a table format.
	$classrole = array();

	$sql = "SELECT a.class_id, a.subclass, a.lang_index, b.role_id, b.role_name
			FROM " . $phpraid_config['db_prefix'] . "class_role a, " . $phpraid_config['db_prefix'] . "roles b
			WHERE a.role_id = b.role_id
			ORDER BY a.class_id, a.subclass";
	$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);

	while($data = $db_raid->sql_fetchrow($result, true))
	{
		$imgDelete = '<img src="../templates/'.$phpraid_config['template'].'/images/icons/icon_delete.gif" border="0" alt="delete" />';
		$urlDelete = 'admin_roletalent.php?mode=remove&amp;class_id='.$data['class_id'].'&amp;talent_tree_name='.$data['subclass'];
		$delete = cssToolTip($imgDelete, $phprlang['delete'], 'smallIconText', $urlDelete);
		$imgEdit = '<img src="../templates/'.$phpraid_config['template'].'/images/icons/icon_edit.gif" border="0" alt="edit" />';
		$urlEdit= 'admin_roletalent.php?mode=edit&amp;class_id='.$data['class_id'].'&amp;talent_tree_name='.$data['subclass'];
		$edit = cssToolTip($imgEdit, $phprlang['edit'], 'smallIconText', $urlEdit);
		array_push($classrole,
			array(
				'Class' => $data['class_id'],
				'Talent Tree' => $data['subclass'],
				'Display Text' => $data['lang_index'],
				'Role Name' => $data['role_name'],
				'Buttons'=>$edit . $delete//'<a href="admin_roletalent.php?mode=remove&amp;class_id='.$data['class_id'].'&amp;talent_tree_name='.$data['subclass'].'"><img src="../templates/' . $phpraid_config['template'] . '/images/icons/icon_delete.gif" border="0" onMouseover="ddrivetip(\''. $phprlang['delete'] .'\');" onMouseout="hideddrivetip();" alt="delete icon"></a>
					 //<a href="admin_roletalent.php?mode=edit&amp;class_id='.$data['class_id'].'&amp;talent_tree_name='.$data['subclass'].'"><img src="../templates/' . $phpraid_config['template'] . '/images/icons/icon_edit.gif" border="0" onMouseover="ddrivetip(\'' . $phprlang['edit'] .'\');" onMouseout="hideddrivetip();" alt="edit icon"></a>'				
			)
		);
	}

	/**************************************************************
	 * Code to setup for a Dynamic Table Create: guild1 View.
	 **************************************************************/
	$viewName = 'classroletalent1';
	
	//Setup Columns
	$roletalent_headers = array();
	$record_count_array = array();
	$roletalent_headers = getVisibleColumns($viewName);

	//Get Record Counts
	$roletalent_record_count_array = getRecordCounts($classrole, $roletalent_headers, $startRecord);
	
	//Get the Jump Menu and pass it down
	$roletalentJumpMenu = getPageNavigation($classrole, $startRecord, $pageURL, $sortField, $sortDesc);
			
	//Setup Default Data Sort from Headers Table
	if (!$initSort)
		foreach ($roletalent_headers as $column_rec)
			if ($column_rec['default_sort'])
				$sortField = $column_rec['column_name'];

	//Setup Data
	$classrole = paginateSortAndFormat($classrole, $sortField, $sortDesc, $startRecord, $viewName);

	/****************************************************************
	 * Data Assign for Template.
	 ****************************************************************/
	$wrmadminsmarty->assign('roletalent_data', $classrole); 
	$wrmadminsmarty->assign('roletalent_jump_menu', $roletalentJumpMenu);
	$wrmadminsmarty->assign('roletalent_column_name', $roletalent_headers);
	$wrmadminsmarty->assign('roletalent_record_counts', $roletalent_record_count_array);
	$wrmadminsmarty->assign('header_data',
		array(
			'template_name'=>$phpraid_config['template'],
			'roletalent_header' => $phprlang['configuration_roletalent_header'],
			'sort_url_base' => $pageURL,
			'sort_descending' => $sortDesc,
			'sort_text' => $phprlang['sort_text'],
		)
	);	
} elseif($_GET['mode'] == 'remove') {
	$class_id = scrub_input($_GET['class_id']);
	$talent_tree_name = scrub_input($_GET['talent_tree_name']);
	
	if(!isset($_POST['submit']))
	{
		$form_action = "admin_roletalent.php?mode=remove&amp;class_id=".$class_id."&amp;talent_tree_name=".$talent_tree_name."";
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
		log_delete('class/role/talent link',$n);

		$sql = sprintf("DELETE FROM " . $phpraid_config['db_prefix'] . "class_role WHERE class_id=%s and subclass=%s",quote_smart($class_id), quote_smart($talent_tree_name));
		//echo "SQL: " . $sql;
		$db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);

		header("Location: admin_roletalent.php?mode=view");
	}
} 
if(($_GET['mode'] == 'new' || $_GET['mode'] == 'edit')) {
	if($_GET['mode'] == 'new') {
		// check for errors
		$new_class_id = scrub_input($_POST['class_id']);
		$new_talent_tree_name = scrub_input($_POST['talent_tree_name']);
		$display_text = scrub_input($_POST['display_text']);
		$role_id = scrub_input($_POST['role_id']);
	} else {
		// edit, grab from database
		$class_id = scrub_input($_GET['class_id']);
		$talent_tree_name = scrub_input($_GET['talent_tree_name']);
		
		$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "class_role WHERE class_id=%s AND subclass=%s",quote_smart($class_id), quote_smart($talent_tree_name));
		$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
		$data = $db_raid->sql_fetchrow($result, true);
	
		$display_text = $data['lang_index'];
		$role_id = $data['role_id'];
	}

	if(isset($_POST['submit'])) {
		$new_class_id = scrub_input($_POST['class_id']);
		$new_talent_tree_name = scrub_input($_POST['talent_tree_name']);
		$display_text = scrub_input($_POST['display_text']);
		$role_id = scrub_input($_POST['role_id']);
				
		// ERROR CHECKING
		// Setup Error Vars
		$errorDie = 0;
		$errorMsg = '<ul>';
		$errorTitle = $phprlang['form_error'];
		
		// Verify Role not Already in Database
		if ($_GET['mode'] == 'new')
		{
			$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "class_role WHERE class_id=%s AND subclass=%s",quote_smart($class_id), quote_smart($talent_tree_name));
			$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
			if($numrows = $db_raid->sql_numrows($result)>0)
				$errorMsg .= '<li>'.$phprlang['roletalent_duplicate_error'].'</li>';
		}
		if($new_class_id == '')
			$errorMsg .= '<li>'.$phprlang['roletalent_classid_blank_error'].'</li>';
		if($new_talent_tree_name == '')
			$errorMsg .= '<li>'.$phprlang['roletalent_talenttree_blank_error'].'</li>';
		if($display_text == '')
			$errorMsg .= '<li>'.$phprlang['roletalent_displaytext_blank_error'].'</li>';
		if($role_id == '')
			$errorMsg .= '<li>'.$phprlang['roletalent_roleid_blank_error'].'</li>';
			
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
				"class_role (`class_id`,`subclass`,`lang_index`,`role_id`)
				VALUES(%s,%s,%s,%s)",quote_smart($new_class_id),quote_smart($new_talent_tree_name),
				quote_smart($display_text),quote_smart($role_id));
				
				$db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);

				log_create('class/role/talent link',mysql_insert_id(),$name);
			} elseif($_GET['mode'] == 'edit') {
				$sql = sprintf("UPDATE " . $phpraid_config['db_prefix'] . "class_role 
				SET class_id=%s,subclass=%s,lang_index=%s,role_id=%s WHERE class_id=%s AND subclass=%s",
				quote_smart($new_class_id),quote_smart($new_talent_tree_name),
				quote_smart($display_text), quote_smart($role_id),
				quote_smart($class_id), quote_smart($talent_tree_name));
	
				$db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
			}
			header("Location: admin_roletalent.php?mode=view");
		}
	}
}

// Display the Add New / Edit Form.
// Fill in the Class Dropdown
$class_options = '<select name="class_id">';
$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "classes";
$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);			
while($class_data = $db_raid->sql_fetchrow($result, true))
{
	$class_options .= "<option ";
	if($class_id == $class_data['class_id'])
		$class_options .= "SELECTED ";
	$class_options .= "value=\"" . $class_data['class_id'] . "\">" . $phprlang[$class_data['lang_index']]."</option>";
}
$class_options .= '</select>';

// Fill in the Talent Tree box.
$talent_tree_box = '<input type="text" name="talent_tree_name" class="post" value="' . $talent_tree_name . '" style="width:100px">';

// Now for the Display Text box.
$display_text_box = '<input type="text" name="display_text" class="post" value="' . $display_text . '" style="width:100px">';

// Finally we need the role dropdown.
$role_options = '<select name="role_id">';
$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "roles";
$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);			
while($role_data = $db_raid->sql_fetchrow($result, true))
{
	$role_options .= "<option ";
	if($role_id == $role_data['role_id'])
		$role_options .= "SELECTED ";
	$role_options .= "value=\"" . $role_data['role_id'] . "\">" . $role_data['role_name'] ."</option>";
}
$role_options .= '</select>';

if($_GET['mode'] == 'view' || $_GET['mode'] == 'new')
	$form_action = 'admin_roletalent.php?mode=new';
else
	$form_action = 'admin_roletalent.php?mode=edit&amp;class_id='.$class_id.'&amp;talent_tree_name='.$talent_tree_name;

$buttons = '<input type="submit" name="submit" value="'.$phprlang['submit'].'" class="mainoption"> <input type="reset" name="Reset" value="'.$phprlang['reset'].'" class="liteoption">';

if($_GET['mode'] == 'view' || $_GET['mode'] == 'new')
	$roletalent_header = $phprlang['configuration_roletalent_new_header'];
else 
	$roletalent_header = $phprlang['configuration_roletalent_edit_header'];

$wrmadminsmarty->assign('roletalent_new',
	array(
		'class_text' => $phprlang['class'],
		'talent_tree_text' => $phprlang['talent_tree'],
		'role_name_text' => $phprlang['role_name'],
		'display_text_text' => $phprlang['display_text'],
		'class_box' => $class_options,
		'talent_tree_box' => $talent_tree_box,
		'display_text_box' => $display_text_box,
		'role_box' => $role_options,
		'roletalent_header'=>$roletalent_header,
		'form_action' => $form_action,
		'buttons' => $buttons,
	)
);

//
// Start output of the page.
//
require_once('./includes/admin_page_header.php');
$wrmadminsmarty->display('admin_role_talent_config.html');
require_once('./includes/admin_page_footer.php');

?>
