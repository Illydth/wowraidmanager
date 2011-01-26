<?php
/***************************************************************************
                          admin_permission.php
 *                        -------------------
 *   begin                : Jan 12, 2011
 *	 Dev                  : Carsten Hölbing
 *	 email                : carsten@hoelbing.net
 *
 *   copyright            : (C) 2007-2011 Douglas Wagner
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
$phprlang['configuration_permission_new'] = "create new Permission Set";


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
		
$pageURL = 'admin_permissions.php';
$pageURL_view = $pageURL.'?mode=view';
$pageURL_new = $pageURL.'?mode=new';
$pageURL_edit = $pageURL.'?mode=edit&amp;';
$pageURL_delete = $pageURL.'?mode=delete&amp;';
/**************************************************************
 * End Record Output Setup for Data Table
 **************************************************************/

if(isset($_GET['perm_id']))
	$permission_type_id = scrub_input($_GET['perm_id']);
else
	$permission_type_id = '';

if($_GET['mode'] == 'view') 
{
	$perm = array();
	$array_permissioninfo = array();
	
	// get all permission sets
	$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "permission_type";
	$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	
	
	while($data = $db_raid->sql_fetchrow($result, true)) 
	{

		
		$edit = '<a href= '.$pageURL_edit.'perm_id='.$data['permission_type_id'].'><img src="../templates/' . $phpraid_config['template'] . 
					'/images/icons/icon_edit.gif" border="0" onMouseover="ddrivetip(\'' . $phprlang['edit'] . '\');" onMouseout="hideddrivetip();" alt="'.$phprlang['edit'].'"></a>';
				
/*		$delete = '<a href='.$pageURL_delete.'"perm_id='.$data['permission_type_id'].'"><img src="../templates/' . 
					$phpraid_config['template'] . '/images/icons/icon_delete.gif" border="0" onMouseover="ddrivetip(\'' . $phprlang['delete'] . '\');" 
					onMouseout="hideddrivetip();" alt="delete icon"></a>';
*/
		//not work yet (wy?)
		$array_permissioninfo = get_array_allInfo_from_PermissionID($data['permission_type_id']);
		$ddrivetiptxt  = "'<span class=tooltip_title>" . $phprlang['name'] ."<br/>";		
		$ddrivetiptxt .= $array_permissioninfo['permissions_name']."<br/>";
		$ddrivetiptxt .= $array_permissioninfo['permissions_description']."<br/>";
		$ddrivetiptxt .= "</span>'";
		
		$name = '<a href="'.$pageURL_edit.'perm_id='.$data['permission_type_id'].'" onMouseover="ddrivetip('.$ddrivetiptxt.');" onMouseout="hideddrivetip();">'. $data['permission_type_name'].'</a>';

		// deny deletion/editing of super account
		if($data['permission_type_id'] == 1) {
			$admin = $edit;
		} else {
			$admin = $edit . $delete;
		}

		array_push($perm, 
			array(
					'ID' => $data['permission_type_id'],
				  	'Name' => $data['permission_type_name'], //$name
				  	'Description' => $data['permission_type_description'],
				  	'buttons' => $admin
			)
		);
	}
	
	/**************************************************************
	 * Code to setup for a Dynamic Table Create: permissions1 View.
	 **************************************************************/
	$viewName = 'admin_permissions1';
		
	//Setup Columns
	$perm_headers = array();
	$perm_record_count_array = array();
	$perm_headers = getVisibleColumns($viewName);
	
	//Get Record Counts
	$perm_record_count_array = getRecordCounts($perm, $perm_headers, $startRecord);
		
	//Get the Jump Menu and pass it down
	$permJumpMenu = getPageNavigation($perm, $startRecord, $pageURL_view, $sortField, $sortDesc);
			
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
			'sort_url_base' => $pageURL_view,
			'sort_descending' => $sortDesc,
			'sort_text' => $phprlang['sort_text'],
		)
	);
	$wrmadminsmarty->assign('buttons',
		array(
			'form_action'=> $pageURL_new,
			'button_new_perm'=> $phprlang['configuration_permission_new'],
		)
	);
	
	//
	// Start output of the page.
	//
	require_once('./includes/admin_page_header.php');
	$wrmadminsmarty->display('admin_permissions.html');
	require_once('./includes/admin_page_footer.php');
} 
elseif(isset($_POST['submit']) && ($_GET['mode'] == 'edit' || $_GET['mode'] == 'new')) 
{

	// grab values
	$name = scrub_input($_POST['permissions_name']);
	$description = scrub_input($_POST['permissions_description']);
	
	$announcements = scrub_input($_POST['announcements']);
	$phpraid_configuration = scrub_input($_POST['configuration']);
	$guilds = scrub_input($_POST['guilds']);
	$locations = scrub_input($_POST['locations']);
	$profile = scrub_input($_POST['profile']);
	$raids = scrub_input($_POST['raids']);

	$on_queue_draft_value = scrub_input($_POST['on_queue_draft']);
	$on_queue_comments_value = scrub_input($_POST['on_queue_comments']);
	$on_queue_cancel_value = scrub_input($_POST['on_queue_cancel']);
	$on_queue_delete_value = scrub_input($_POST['on_queue_delete']);
	$cancelled_status_queue_value = scrub_input($_POST['cancelled_status_queue']);;
	$cancelled_status_draft_value = scrub_input($_POST['cancelled_status_draft']);
	$cancelled_status_comments_value = scrub_input($_POST['cancelled_status_comments']);
	$cancelled_status_delete_value = scrub_input($_POST['cancelled_status_delete']);
	$drafted_queue_value = scrub_input($_POST['drafted_queue']);
	$drafted_comments_value = scrub_input($_POST['drafted_comments']);
	$drafted_cancel_value = scrub_input($_POST['drafted_cancel']);
	$drafted_delete_value = scrub_input($_POST['drafted_delete']);
			
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
			$sql = sprintf("INSERT INTO " . $phpraid_config['db_prefix'] . "permission_type ".
						" (`permission_type_name`,`permission_type_description`) VALUES(%s,%s)",
						quote_smart($name),quote_smart($description));
			$db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
			
			//get 
			$sql = sprintf(	"SELECT * ".
							" FROM " . $phpraid_config['db_prefix'] . "permission_type");
			$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
							
			$permission_type_id = $db_raid->sql_numrows($result);
							
			log_create('permission',mysql_insert_id(),$name);
			
			//header("Location: ".$pageURL_view);
		} 
		elseif($_GET['mode'] == 'edit') 
		{
			// it's an edit, update entry
			$sql = sprintf("UPDATE " . $phpraid_config['db_prefix'] . "permission_type".
						" SET permission_type_name=%s, permission_type_description=%s ".
						" WHERE permission_type_id=%s",	
						quote_smart($name), quote_smart($description), quote_smart(permission_type));
			$db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
		}

		if (($_GET['mode'] == 'new') or ($_GET['mode'] == 'edit'))
		{
		// config
			if ($announcements == "1")
					update_permission_config($permission_type_id, "1" );
			else 
					delete_permissions_config($permission_type_id, "1" );
			if ($configuration == "1")
					update_permission_config($permission_type_id, "2" );
			else 
					delete_permissions_config($permission_type_id, "2" );
			if ($guilds == "1")
					update_permission_config($permission_type_id, "3" );
			else 
					delete_permissions_config($permission_type_id, "3" );
			if ($locations == "1")
					update_permission_config($permission_type_id, "4" );
			else 
					delete_permissions_config($permission_type_id, "4" );
			if ($profile == "1")
					update_permission_config($permission_type_id, "5" );
			else 
					delete_permissions_config($permission_type_id, "5" );
			if ($raids == "1")
					update_permission_config($permission_type_id, "6" );
			else 
					delete_permissions_config($permission_type_id, "6" );

	
		// Raid
			if ($on_queue_draft_value=="1")
					update_permission_signup($permission_type_id, "1" );
			else 
					delete_permissions_signup($permission_type_id, "1" );
			if ($on_queue_comments_value=="1")
					update_permission_signup($permission_type_id, "2" );
			else 
					delete_permissions_signup($permission_type_id, "2" );
			if ($on_queue_cancel_value=="1")
					update_permission_signup($permission_type_id, "3" );
			else 
					delete_permissions_signup($permission_type_id, "3" );
			if ($on_queue_delete_value=="1")
					update_permission_signup($permission_type_id, "4" );
			else 
					delete_permissions_signup($permission_type_id, "4" );
			if ($cancelled_status_queue_value=="1")
					update_permission_signup($permission_type_id, "5" );
			else 
					delete_permissions_signup($permission_type_id, "5" );
			if ($cancelled_status_draft_value=="1")
					update_permission_signup($permission_type_id, "6" );
			else 
					delete_permissions_signup($permission_type_id, "6" );
			if ($cancelled_status_comments_value=="1")
					update_permission_signup($permission_type_id, "7" );
			else 
					delete_permissions_signup($permission_type_id, "7" );
			if ($cancelled_status_delete_value=="1")
					update_permission_signup($permission_type_id, "8" );
			else 
					delete_permissions_signup($permission_type_id, "8" );	
			if ($drafted_queue_value=="1")
					update_permission_signup($permission_type_id, "9" );
			else 
					delete_permissions_signup($permission_type_id, "9" );
			if ($drafted_comments_value=="1")
					update_permission_signup($permission_type_id, "10" );
			else 
					delete_permissions_signup($permission_type_id, "10" );
			if ($drafted_cancel_value=="1")
					update_permission_signup($permission_type_id, "11" );
			else 
					delete_permissions_signup($permission_type_id, "11" );
			if ($drafted_delete_value=="1")
					update_permission_signup($permission_type_id, "12" );
			else 
					delete_permissions_signup($permission_type_id, "12" );	
		
			header("Location: ".$pageURL_view);
		}
	}
}
elseif($_GET['mode'] == 'delete') 
{
	$permission_type_id = scrub_input($_GET['perm_id']);
	
	if($_SESSION['priv_configuration'] == 1) 
	{
		if(!isset($_POST['submit'])) 
		{			
			$form_action = 'admin_permissions.php?mode=delete&amp;perm_id=' . $permission_type_id;
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
			delete_permissions($permission_type_id);
			
			header("Location: ".$pageURL_view);
		}
	} 
	else 
	{
		if($_SESSION['priv_configuration'] == 1)
			header("Location: ".$pageURL_view);
		else
			header("Location: ../index.php");
	}
}

// new/edit details
if(($_GET['mode'] != 'delete') and ($_GET['mode'] != 'view')) 
{
	$array_permissioninfo = array();
	$array_yesno = array();
	$array_yesno['0'] = $phprlang['no'];
	$array_yesno['1'] = $phprlang['yes'];
	
	// deny editing (config areas) of super account 
	$array_yesno_config = array();
	if ($permission_type_id != 1)
	{	$array_yesno_config['0'] = $phprlang['no'];}
		
	$array_yesno_config['1'] = $phprlang['yes'];
		
	if($_GET['mode'] == 'edit') 
	{
		// grab from DB
		$array_permissioninfo = get_array_allInfo_from_PermissionID($permission_type_id);
		
		$permissions_name = $array_permissioninfo['permissions_name'];
		$permissions_description = $array_permissioninfo['permissions_description'];
				
		$announcements = $array_permissioninfo['announcements'];
		$guilds = $array_permissioninfo['guilds'];
		$locations = $array_permissioninfo['locations'];
		$profile = $array_permissioninfo['profile'];
		$raids = $array_permissioninfo['raids'];
		$configuration = $array_permissioninfo['configuration'];

		$on_queue_draft_value = $array_permissioninfo['on_queue_draft_value'];
		$on_queue_comments_value = $array_permissioninfo['on_queue_comments_value'];
		$on_queue_cancel_value = $array_permissioninfo['on_queue_cancel_value'];
		$on_queue_delete_value = $array_permissioninfo['on_queue_delete_value'];
		$cancelled_status_queue_value = $array_permissioninfo['cancelled_status_queue_value'];
		$cancelled_status_draft_value = $array_permissioninfo['cancelled_status_draft_value'];
		$cancelled_status_comments_value = $array_permissioninfo['cancelled_status_comments_value'];
		$cancelled_status_delete_value = $array_permissioninfo['cancelled_status_delete_value'];
		$drafted_queue_value = $array_permissioninfo['drafted_queue_value'];
		$drafted_comments_value = $array_permissioninfo['drafted_comments_value'];
		$drafted_cancel_value = $array_permissioninfo['drafted_cancel_value'];
		$drafted_delete_value = $array_permissioninfo['drafted_delete_value'];

		$wrmadminsmarty->assign('header_text',$phprlang['permissions_edit_header']);
		$button_01 = $phprlang['update'];
		$form_action = $pageURL_view;
	} 
	elseif($_GET['mode'] == 'new')  
	{
				
		$permissions_name = '';
		$permissions_description = '';

		$announcements = '0';
		$guilds = '0';
		$locations = '0';
		$profile = '0';
		$raids = '0';
		$configuration = '0';

		$on_queue_draft_value = "0";
		$on_queue_comments_value = "0";
		$on_queue_cancel_value = "0";
		$on_queue_delete_value = "0";
		$cancelled_status_queue_value = "0";
		$cancelled_status_draft_value = "0";
		$cancelled_status_comments_value = "0";
		$cancelled_status_delete_value = "0";
		$drafted_queue_value = "0";
		$drafted_comments_value = "0";
		$drafted_cancel_value = "0";
		$drafted_delete_value = "0";
		
		$wrmadminsmarty->assign('header_text',$phprlang['permissions_new']);
		$button_01 = $phprlang['submit'];
		
		$form_action = $pageURL_new;
	}
	
	$wrmadminsmarty->assign('perms_new',
		array(
			'form_action'=> $form_action,
		
			'permissions_name_text'=>$phprlang['permissions_name'],
			'permissions_name'=> $permissions_name,
			'permissions_description_text'=>$phprlang['permissions_description'],
			'permissions_description'=>$permissions_description,

			'announcements_text'=>$phprlang['permissions_announcements'],
			'announcements'=>$announcements,
			'guilds_text'=>$phprlang['permissions_guilds'],
			'guilds'=>$guilds,
			'locations_text'=>$phprlang['permissions_locations'],
			'locations'=>$locations,
			'profile_text'=>$phprlang['permissions_profile'],
			'profile'=>$profile,
			'raids_text'=>$phprlang['permissions_raids'],
			'raids'=>$raids,
			'configuration_text'=>$phprlang['permissions_configuration'],
			'configuration'=>$phpraid_configuration,
		
			'configuration_signup_rights_header'=>$phprlang['configuration_signup_rights_header'], 
			'array_yesno' => $array_yesno,
			'array_yesno_config' => $array_yesno_config,
			'configuration_queue_def' => $phprlang['configuration_queue_def'],
			'on_queue_draft_text'=>$phprlang['configuration_drafted'],
			'on_queue_draft' =>$on_queue_draft_value,
			'on_queue_comments_text'=>$phprlang['configuration_comments'],
			'on_queue_comments' => $on_queue_comments_value, 
			'on_queue_cancel_text'=>$phprlang['configuration_cancel'],
			'on_queue_cancel' =>$on_queue_cancel_value,
			'on_queue_delete_text'=>$phprlang['configuration_delete'],
			'on_queue_delete' =>$on_queue_delete_value,
			'configuration_cancel_def' => $phprlang['configuration_cancel_def'],		
			'cancelled_status_queue_text'=>$phprlang['configuration_queue'],
			'cancelled_status_queue' =>$cancelled_status_queue_value,
			'cancelled_status_draft_text'=>$phprlang['configuration_draft'],
			'cancelled_status_draft' =>$cancelled_status_draft_value,
			'cancelled_status_comments_text'=>$phprlang['configuration_comments'],
			'cancelled_status_comments' =>$cancelled_status_comments_value,
			'cancelled_status_delete_text'=>$phprlang['configuration_delete'],
			'cancelled_status_delete' =>$cancelled_status_delete_value,
			'configuration_draft_def' => $phprlang['configuration_draft_def'],
			'drafted_queue_text'=>$phprlang['configuration_queue'],
			'drafted_queue' =>$drafted_queue_value,
			'drafted_comments_text'=>$phprlang['configuration_comments'],
			'drafted_comments' =>$drafted_comments_value,
			'drafted_cancel_text'=>$phprlang['configuration_cancel'],
			'drafted_cancel' =>$drafted_cancel_value,
			'drafted_delete_text' =>$phprlang['configuration_delete'],
			'drafted_delete' =>$drafted_delete_value,
		
			'cancel_def' =>$phprlang['configuration_cancel_def'],
			'comments_def' =>$phprlang['configuration_comments_def'],
			'delete_def' =>$phprlang['configuration_delete_def'],
			'draft_def' =>$phprlang['configuration_draft_def'],
			'queue_def' =>$phprlang['configuration_queue_def'],
		)
	);
	$wrmadminsmarty->assign('buttons',
		array(
			'button_01'=> $button_01,
			'button_reset'=> $phprlang['reset'],
		)
	);
	
	//
	// Start output of the page.
	//
	require_once('./includes/admin_page_header.php');
	$wrmadminsmarty->display('admin_permissions_new.html');
	require_once('./includes/admin_page_footer.php');	
}


//update the selected permission_signup  set
function update_permission_signup($permission_type_id,$raid_permission_type_id )
{
	global $db_raid, $phpraid_config;
	
	$sql = sprintf(	"SELECT * ".
					" FROM " . $phpraid_config['db_prefix'] . "acl_raid_permission".
					" WHERE raid_permission_type_id=%s and permission_type_id=%s",
					quote_smart($raid_permission_type_id),quote_smart($permission_type_id));
					
	$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);

	if ($db_raid->sql_numrows($result) < 1)
	{
		$sql = sprintf("INSERT INTO " . $phpraid_config['db_prefix'] . "acl_raid_permission ".
						" (`raid_permission_type_id`,`permission_type_id`) VALUES(%s,%s)",
						quote_smart($raid_permission_type_id),quote_smart($permission_type_id));
		$db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);	
	} 
}

//delete the selected permission_signup  set
function delete_permissions_signup($permission_type_id, $raid_permission_type_id)
{
	global $db_raid, $phpraid_config;
	
	$sql = sprintf(	"SELECT * ".
					" FROM " . $phpraid_config['db_prefix'] . "acl_raid_permission".
					" WHERE raid_permission_type_id=%s and permission_type_id=%s",
					quote_smart($raid_permission_type_id),quote_smart($permission_type_id));
	$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
					
	if ($db_raid->sql_numrows($result) == 1)
	{
		$sql = sprintf(	"DELETE ".
						" FROM " . $phpraid_config['db_prefix'] . "acl_raid_permission".
						" WHERE raid_permission_type_id=%s and permission_type_id=%s",
						quote_smart($raid_permission_type_id),quote_smart($permission_type_id));
		$db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	}
	
}

//update the selected permission_conf  set
function update_permission_config($permission_type_id,$permission_value_id )
{
	global $db_raid, $phpraid_config;
	
	$sql = sprintf(	"SELECT * ".
					" FROM " . $phpraid_config['db_prefix'] . "acl_permission".
					" WHERE permission_value_id=%s and permission_type_id=%s",
					quote_smart($permission_value_id),quote_smart($permission_type_id));
					
	$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);

	if ($db_raid->sql_numrows($result) < 1)
	{
		$sql = sprintf("INSERT INTO " . $phpraid_config['db_prefix'] . "acl_permission ".
						" (`permission_value_id`,`permission_type_id`) VALUES(%s,%s)",
						quote_smart($permission_value_id),quote_smart($permission_type_id));
		$db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);	
	} 
}
//delete the selected permission_conf  set
function delete_permissions_config($permission_type_id, $permission_value_id)
{
	global $db_raid, $phpraid_config;
	
	$sql = sprintf(	"SELECT * ".
					" FROM " . $phpraid_config['db_prefix'] . "acl_permission".
					" WHERE permission_value_id=%s and permission_type_id=%s",
					quote_smart($permission_value_id),quote_smart($permission_type_id));
	$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
					
	if ($db_raid->sql_numrows($result) == 1)
	{
		$sql = sprintf(	"DELETE ".
						" FROM " . $phpraid_config['db_prefix'] . "acl_permission".
						" WHERE permission_value_id=%s and permission_type_id=%s",
						quote_smart($permission_value_id),quote_smart($permission_type_id));
		$db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	}
	
}

//read all information from the selected permission set
function get_array_allInfo_from_PermissionID($permission_type_id)
{
	global  $db_raid,$phpraid_config;
	$array_permissioninfo = array();
		
	$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "permission_type WHERE permission_type_id=%s",quote_smart($permission_type_id));
	$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	$data = $db_raid->sql_fetchrow($result, true);
	$array_permissioninfo['permissions_name'] = $data['permission_type_name'];
	$array_permissioninfo['permissions_description'] = $data['permission_type_description'];

	$array_permissioninfo['announcements'] = '0';
	$array_permissioninfo['guilds'] = '0';
	$array_permissioninfo['locations'] = '0';
	$array_permissioninfo['profile'] = '0';
	$array_permissioninfo['raids'] = '0';
	$array_permissioninfo['configuration'] = '0';

	$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "acl_permission WHERE permission_type_id=%s",quote_smart($permission_type_id));
	$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	while($data = $db_raid->sql_fetchrow($result, true)) 
	{
		if ($data['permission_value_id'] == "1") 
			$array_permissioninfo['announcements'] = '1';
			
		if ($data['permission_value_id'] == "2") 
			$array_permissioninfo['configuration'] = '1';

		if ($data['permission_value_id'] == "3") 
			$array_permissioninfo['guilds'] = '1';
			
		if ($data['permission_value_id'] == "4") 
			$array_permissioninfo['locations'] = '1';

		if ($data['permission_value_id'] == "5") 
			$array_permissioninfo['profile'] = '1';
			
		if ($data['permission_value_id'] == "6") 
			$array_permissioninfo['configuration'] = '1';
	}
	
	$array_permissioninfo['on_queue_draft_value'] = "0";
	$array_permissioninfo['on_queue_comments_value'] = "0";
	$array_permissioninfo['on_queue_cancel_value'] = "0";
	$array_permissioninfo['on_queue_delete_value'] = "0";
	$array_permissioninfo['cancelled_status_queue_value'] = "0";
	$array_permissioninfo['cancelled_status_draft_value'] = "0";
	$array_permissioninfo['cancelled_status_comments_value'] = "0";
	$array_permissioninfo['cancelled_status_delete_value'] = "0";
	$array_permissioninfo['drafted_queue_value'] = "0";
	$array_permissioninfo['drafted_comments_value'] = "0";
	$array_permissioninfo['drafted_cancel_value'] = "0";
	$array_permissioninfo['drafted_delete_value'] = "0";
			
	$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "acl_raid_permission WHERE permission_type_id=%s",quote_smart($permission_type_id));
	$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	while($data = $db_raid->sql_fetchrow($result, true)) 
	{

		if ($data['raid_permission_type_id'] == "1")
			$array_permissioninfo['on_queue_draft_value'] = "1";
							
		if ($data['raid_permission_type_id'] == "2")
			$array_permissioninfo['on_queue_comments_value'] = "1";
						
		if ($data['raid_permission_type_id'] == "3")
			$array_permissioninfo['on_queue_cancel_value'] = "1";
			
		if ($data['raid_permission_type_id'] == "4")
			$array_permissioninfo['on_queue_delete_value'] = "1";
			
		if ($data['raid_permission_type_id'] == "5")
			$array_permissioninfo['cancelled_status_queue_value'] = "1";
			
		if ($data['raid_permission_type_id'] == "6")
			$array_permissioninfo['cancelled_status_draft_value'] = "1";
							
		if ($data['raid_permission_type_id'] == "7")
			$array_permissioninfo['cancelled_status_comments_value'] = "1";
			
		if ($data['raid_permission_type_id'] == "8")
			$array_permissioninfo['cancelled_status_delete_value'] = "1";
			
		if ($data['raid_permission_type_id'] == "9")
			$array_permissioninfo['drafted_queue_value'] = "1";
			
		if ($data['raid_permission_type_id'] == "10")
			$array_permissioninfo['drafted_comments_value'] = "1";

		if ($data['raid_permission_type_id'] == "11")
			$array_permissioninfo['drafted_cancel_value'] = "1";
			
		if ($data['raid_permission_type_id'] == "12")
			$array_permissioninfo['drafted_delete_value'] = "1";	
	}

	return $array_permissioninfo;	
}

?>