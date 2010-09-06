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
		
$pageURL = 'admin_permissions.php?mode=view&amp;';
/**************************************************************
 * End Record Output Setup for Data Table
 **************************************************************/

if(isset($_GET['perm_id']))
	$perm_id = scrub_input($_GET['perm_id']);
else
	$perm_id = '';

if($_GET['mode'] == 'view') 
{
	$perm = array();
	
	// get permission sets
	$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "permissions";
	$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	
	while($data = $db_raid->sql_fetchrow($result, true)) {
		$edit = '<a href="admin_permissions.php?mode=edit&amp;perm_id='.$data['permission_id'].'"><img src="../templates/' . $phpraid_config['template'] . 
					'/images/icons/icon_edit.gif" border="0" onMouseover="ddrivetip(\'' . $phprlang['edit'] . '\');" onMouseout="hideddrivetip();" alt="edit icon"></a>';
				
		$delete = '<a href="admin_permissions.php?mode=delete&amp;perm_id='.$data['permission_id'].'"><img src="../templates/' . 
					$phpraid_config['template'] . '/images/icons/icon_delete.gif" border="0" onMouseover="ddrivetip(\'' . $phprlang['delete'] . '\');" 
					onMouseout="hideddrivetip();" alt="delete icon"></a>';

		// deny deletion/editing of super account
		if($data['permission_id'] == 1) {
			$admin = '';
		} else {
			$admin = $edit . $delete;
		}
		
		if($data['announcements'] == 1)
			$announcements = '<img src="../templates/' . $phpraid_config['template'] . '/images/icons/check_mark.gif" border="0" 
							height="14" width="14" onMouseover="ddrivetip(\'' . $phprlang['has_permission'] . '\');" onMouseout="hideddrivetip();" alt="check mark">';
		else
			$announcements = '';
			
		if($data['configuration'] == 1)
			$phpraid_configuration = '<img src="../templates/' . $phpraid_config['template'] . '/images/icons/check_mark.gif" border="0" 
							height="14" width="14" onMouseover="ddrivetip(\'' . $phprlang['has_permission'] . '\');" onMouseout="hideddrivetip();" alt="check mark">';
		else
			$phpraid_configuration = '';
			
		if($data['guilds'] == 1)
			$guilds = '<img src="../templates/' . $phpraid_config['template'] . '/images/icons/check_mark.gif" border="0" 
							height="14" width="14" onMouseover="ddrivetip(\'' . $phprlang['has_permission'] . '\');" onMouseout="hideddrivetip();" alt="check mark">';
		else
			$guilds = '';
			
		if($data['locations'] == 1)
			$locations = '<img src="../templates/' . $phpraid_config['template'] . '/images/icons/check_mark.gif" border="0" 
							height="14" width="14" onMouseover="ddrivetip(\'' . $phprlang['has_permission'] . '\');" onMouseout="hideddrivetip();" alt="check mark">';
		else
			$locations = '';
			
		if($data['profile'] == 1)
			$profile = '<img src="../templates/' . $phpraid_config['template'] . '/images/icons/check_mark.gif" border="0" 
							height="14" width="14" onMouseover="ddrivetip(\'' . $phprlang['has_permission'] . '\');" onMouseout="hideddrivetip();" alt="check mark">';
		else
			$profile = '';
			
		if($data['raids'] == 1)
			$raids = '<img src="../templates/' . $phpraid_config['template'] . '/images/icons/check_mark.gif" border="0" 
							height="14" width="14" onMouseover="ddrivetip(\'' . $phprlang['has_permission'] . '\');"  onMouseout="hideddrivetip();" alt="check mark">';
		else
			$raids = '';
			
		array_push($perm, 
			array('ID'=>$data['permission_id'],
				  'Name'=>$data['name'],
				  'Description'=>$data['description'],
				  'An'=>$announcements,
				  'Co'=>$phpraid_configuration,
				  'Gu'=>$guilds,
				  'Lo'=>$locations,
				  'Pr'=>$profile,
				  'Ra'=>$raids,
				  'Buttons'=>$admin
			)
		);
	}
	
	/**************************************************************
	 * Code to setup for a Dynamic Table Create: permissions1 View.
	 **************************************************************/
	$viewName = 'permissions1';
		
	//Setup Columns
	$perm_headers = array();
	$perm_record_count_array = array();
	$perm_headers = getVisibleColumns($viewName);
	
	//Get Record Counts
	$perm_record_count_array = getRecordCounts($perm, $perm_headers, $startRecord);
		
	//Get the Jump Menu and pass it down
	$permJumpMenu = getPageNavigation($perm, $startRecord, $pageURL, $sortField, $sortDesc);
			
	//Setup Default Data Sort from Headers Table
	if (!$initSort)
		foreach ($perm_headers as $column_rec)
			if ($column_rec['default_sort'])
				$sortField = $column_rec['column_name'];

	//Setup Data
	$perm = paginateSortAndFormat($perm, $sortField, $sortDesc, $startRecord, $viewName);
	
	/****************************************************************
	 * Data Assign for Template.
	 ****************************************************************/
	$wrmadminsmarty->assign('perm_data', $perm); 
	$wrmadminsmarty->assign('perm_jump_menu', $permJumpMenu);
	$wrmadminsmarty->assign('column_name', $perm_headers);
	$wrmadminsmarty->assign('perm_record_counts', $perm_record_count_array);
	$wrmadminsmarty->assign('header_data',
		array(
			'template_name'=>$phpraid_config['template'],
			'permissions_header' => $phprlang['permissions_header'],
			'sort_url_base' => $pageURL,
			'sort_descending' => $sortDesc,
			'sort_text' => $phprlang['sort_text'],
		)
	);
} 
elseif(isset($_POST['submit']) && ($_GET['mode'] == 'edit' || $_GET['mode'] == 'new')) 
{
	// grab values
	$name = scrub_input($_POST['name']);
	$description = scrub_input($_POST['description']);
	$announcements = scrub_input($_POST['announcements']);
	$phpraid_configuration = scrub_input($_POST['configuration']);
	$guilds = scrub_input($_POST['guilds']);
	$locations = scrub_input($_POST['locations']);
	$profile = scrub_input($_POST['profile']);
	$raids = scrub_input($_POST['raids']);

	// error checking
	if($name == '' || $description == '') 
	{
		$errorDie = 0;
		$errorSpace = 1;
		
		$errorTitle = $phprlang['form_error'];
		$errorMsg = '<ul>';
			
		if($name == '')
			$errorMsg .= '<li>' . $phprlang['permissions_form_name'] . '</li>';
		
		if($description == '')
			$errorMsg .= '<li>' . $phprlang['permissions_form_description'] . '</li>';
				
		$errorMsg .= '</ul>';
	} 
	else 
	{
		if($_GET['mode'] == 'new') 
		{
			// new submission
			$sql = sprintf("INSERT INTO " . $phpraid_config['db_prefix'] . "permissions (`name`,`description`,`announcements`,`configuration`,`guilds`,`locations`,
				`profile`,`raids`) VALUES(%s,%s,%s,%s,%s,%s,%s,%s)",quote_smart($name),quote_smart($description),quote_smart($announcements),
				quote_smart($phpraid_configuration),quote_smart($guilds),quote_smart($locations),
				quote_smart($profile),quote_smart($raids));
				
			$db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
			
			log_create('permission',mysql_insert_id(),$name);
			
			header("Location: admin_permissions.php?mode=view");
		} 
		elseif($_GET['mode'] == 'edit') 
		{
			// it's an edit, update entry
			$sql = sprintf("UPDATE " . $phpraid_config['db_prefix'] . "permissions SET name=%s, description=%s, announcements=%s, configuration=%s, 
				guilds=%s,	locations=%s, profile=%s, raids=%s WHERE permission_id=%s",	quote_smart($name),quote_smart($description),
				quote_smart($announcements),quote_smart($phpraid_configuration),quote_smart($guilds),quote_smart($locations),
				quote_smart($profile),quote_smart($raids),quote_smart($perm_id));
				
			$db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
			
			header("Location: admin_permissions.php?mode=view");
		}
	}
}
elseif($_GET['mode'] == 'delete') 
{
	$perm_id = scrub_input($_GET['perm_id']);
	
	if($_SESSION['priv_configuration'] == 1) 
	{
		if(!isset($_POST['submit'])) 
		{			
			$form_action = 'admin_permissions.php?mode=delete&amp;perm_id=' . $perm_id;
			$confirm_button = '<input type="submit" value="'.$phprlang['confirm_deletion'].'" name="submit" class="post">';
			
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
			require_once('./includes/admin_page_header.php');
			$wrmadminsmarty->display('../delete.html');
			require_once('./includes/admin_page_footer.php');
			
			exit;
		} 
		else 
		{
			delete_permissions($perm_id);
			
			header("Location: admin_permissions.php?mode=view");
		}
	} 
	else 
	{
		if($_SESSION['priv_configuration'] == 1)
			header("Location: auth_permissions.php?mode=view");
		else
			header("Location: index.php");
	}
}
// new/edit details
if($_GET['mode'] != 'delete') 
{
	if($_GET['mode'] == 'edit') 
	{
		// grab from DB
		$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "permissions WHERE permission_id=%s",quote_smart($perm_id));
		$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
		$data = $db_raid->sql_fetchrow($result, true);
		
		$announcements = '<select name="announcements" class="post">';
		if($data['announcements'] == 1) {
			$announcements .= '<option value="1" SELECTED>' . $phprlang['yes'] . '</option>';
			$announcements .= '<option value="0">' . $phprlang['no'] . '</option>';
		} else {
			$announcements .= '<option value="1">' . $phprlang['yes'] . '</option>';
			$announcements .= '<option value="0" SELECTED>' . $phprlang['no'] . '</option>';
		}
		$announcements .= '</select>';
		
		$phpraid_configuration = '<select name="configuration" class="post">';
		if($data['configuration'] == 1) {
			$phpraid_configuration .= '<option value="1" SELECTED>' . $phprlang['yes'] . '</option>';
			$phpraid_configuration .= '<option value="0">' . $phprlang['no'] . '</option>';
		} else {
			$phpraid_configuration .= '<option value="1">' . $phprlang['yes'] . '</option>';
			$phpraid_configuration .= '<option value="0" SELECTED>' . $phprlang['no'] . '</option>';
		}
		$phpraid_configuration .= '</select>';
		
		$guilds = '<select name="guilds" class="post">';
		if($data['guilds'] == 1) {
			$guilds .= '<option value="1" SELECTED>' . $phprlang['yes'] . '</option>';
			$guilds .= '<option value="0">' . $phprlang['no'] . '</option>';
		} else {
			$guilds .= '<option value="1">' . $phprlang['yes'] . '</option>';
			$guilds .= '<option value="0" SELECTED>' . $phprlang['no'] . '</option>';
		}
		$guilds .= '</select>';
		
		$locations = '<select name="locations" class="post">';
		if($data['locations'] == 1) {
			$locations .= '<option value="1" SELECTED>' . $phprlang['yes'] . '</option>';
			$locations .= '<option value="0">' . $phprlang['no'] . '</option>';
		} else {
			$locations .= '<option value="1">' . $phprlang['yes'] . '</option>';
			$locations .= '<option value="0" SELECTED>' . $phprlang['no'] . '</option>';
		}
		$locations .= '</select>';
		
		$profile = '<select name="profile" class="post">';
		if($data['profile'] == 1) {
			$profile .= '<option value="1" SELECTED>' . $phprlang['yes'] . '</option>';
			$profile .= '<option value="0">' . $phprlang['no'] . '</option>';
		} else {
			$profile .= '<option value="1">' . $phprlang['yes'] . '</option>';
			$profile .= '<option value="0" SELECTED>' . $phprlang['no'] . '</option>';
		}
		$profile .= '</select>';
		
		$raids = '<select name="raids" class="post">';
		if($data['raids'] == 1) {
			$raids .= '<option value="1" SELECTED>' . $phprlang['yes'] . '</option>';
			$raids .= '<option value="0">' . $phprlang['no'] . '</option>';
		} else {
			$raids .= '<option value="1">' . $phprlang['yes'] . '</option>';
			$raids .= '<option value="0" SELECTED>' . $phprlang['no'] . '</option>';
		}
		$raids .= '</select>';
		
		$name = '<input type="text" name="name" class="post" value="' . $data['name'] . '">';
		$description = '<input type="text" name="description" class="post" value="' . $data['description'] . '"style="width:300px">';
		
		$form_action = "admin_permissions.php?mode=edit&amp;perm_id=$perm_id";
		
		$wrmadminsmarty->assign('header_text',$phprlang['permissions_edit_header']);
	} else {
		$announcements = '<select name="announcements" class="post">
						<option value="1" SELECTED>' . $phprlang['yes'] . '</option>
						<option value="0">' . $phprlang['no'] . '</option>
		 				</select>';
		
		$phpraid_configuration = '<select name="configuration" class="post">
						<option value="1" SELECTED>' . $phprlang['yes'] . '</option>
						<option value="0">' . $phprlang['no'] . '</option>
						</select>';
		
		$guilds = '<select name="guilds" class="post">
				<option value="1" SELECTED>' . $phprlang['yes'] . '</option>
				<option value="0">' . $phprlang['no'] . '</option>
				</select>';
		
		$locations = '<select name="locations" class="post">
				<option value="1" SELECTED>' . $phprlang['yes'] . '</option>
				<option value="0">' . $phprlang['no'] . '</option>
				</select>';
				
		$profile = '<select name="profile" class="post">
				<option value="1" SELECTED>' . $phprlang['yes'] . '</option>
				<option value="0">' . $phprlang['no'] . '</option>
				</select>';
				
		$raids = '<select name="raids" class="post">
				<option value="1" SELECTED>' . $phprlang['yes'] . '</option>
				<option value="0">' . $phprlang['no'] . '</option>
				</select>';	
				
		$name = '<input type="text" name="name" class="post">';
		$description = '<input type="text" name="description" class="post" style="width:300px">';
		
		$form_action = "admin_permissions.php?mode=new&amp;perm_id=$perm_id";
		
		$wrmadminsmarty->assign('header_text',$phprlang['permissions_new']);
	}
	
	$wrmadminsmarty->assign('perms_new',
		array(
			'announcements'=>$announcements,
			'configuration'=>$phpraid_configuration,
			'guilds'=>$guilds,
			'locations'=>$locations,
			'profile'=>$profile,
			'raids'=>$raids,
			'name'=>$name,
			'description'=>$description,
			'announcements_text'=>$phprlang['permissions_announcements'],
			'configuration_text'=>$phprlang['permissions_configuration'],
			'guilds_text'=>$phprlang['permissions_guilds'],
			'locations_text'=>$phprlang['permissions_locations'],
			'profile_text'=>$phprlang['permissions_profile'],
			'raids_text'=>$phprlang['permissions_raids'],
			'name_text'=>$phprlang['permissions_name'],
			'description_text'=>$phprlang['permissions_description'],
			'form_action'=>$form_action
		)
	);
	$wrmadminsmarty->assign('buttons','<input type="submit" value="'.$phprlang['submit'].'" name="submit" class="mainoption"> <input type="reset" value="'.$phprlang['reset'].'" name="reset" class="liteoption">');
}

//
// Start output of the page.
//
require_once('./includes/admin_page_header.php');
$wrmadminsmarty->display('admin_permissions.html');
require_once('./includes/admin_page_footer.php');

?>