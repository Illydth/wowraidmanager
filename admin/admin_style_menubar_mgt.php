<?php
/***************************************************************************
 *                          admin_style_menubar_mgt.php
 *                        --------------------------------
 *   begin                : Dec 30, 2010
 *   Dev                  : Carsten Hölbing
 *   email                : carsten@hoelbing.net
 *
 *   -- WoW Raid Manager --
 *   copyright            : (C) 2007-2009 Douglas Wagner
 *   email                : douglasw0@yahoo.com
 *   www		  : http://www.wowraidmanager.net
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
$phprlang['admin_menubar_header'] = 'Configuration Menubar Entrys';
$phprlang['admin_edit_menubar_entry_header'] = 'Edit Menubar';
$phprlang['admin_new_menubar_entry_header'] = 'New Menubar Entry';
$phprlang['Lang_index'] = "lang_index";
$phprlang['link'] = "Link";


// Set Page Filename
$page_filename = "admin_style_menubar_mgt.php";
$pageURL = $page_filename .'?mode=view&';

// commons
define("IN_PHPRAID", true);	
require_once('./admin_common.php');

/*************************************************
 * Access Authorization Section
 *************************************************/
// page authentication
define("PAGE_LVL","configuration");
require_once("../includes/authentication.php");	

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


/**************************************************************
 * End Record Output Setup for Data Table
 **************************************************************/

if($_GET['mode'] == 'view')
{
	$admin_menubar = array();
	$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "menu_value";
	$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	while($data = $db_raid->sql_fetchrow($result, true))
	{
		$menu_value_id = $data['menu_value_id'];
		$lang_index = $data['lang_index'];
		$link = $data['link'];
		
		$edit = '<a href="'.$page_filename.'?mode=edit&amp;menu_value_id='.$menu_value_id.'"><img src="../templates/' . $phpraid_config['template'] .
				'/images/icons/icon_edit.gif" border="0" onMouseover="ddrivetip(\'' . $phprlang['edit'] . '\');" onMouseout="hideddrivetip();" alt="edit icon"></a> ';

		// Removed "Title" from being passed, no need for it.
/*		$delete = '<a href="'.$page_filename.'?mode=delete&amp;menu_value_id='.$menu_value_id.'"><img src="../templates/' .
					$phpraid_config['template'] . '/images/icons/icon_delete.gif" border="0" onMouseover="ddrivetip(\'' . $phprlang['delete'] . '\');"
					onMouseout="hideddrivetip();" alt="delete icon"></a>';
*/
		array_push($admin_menubar,
			array(
				'ID'=>$menu_value_id,
				'Lang_index'=>$phprlang[$lang_index],
				'Link'=>$link,
				'Button'=>$edit . $delete,
			)
		);
	}

	/**************************************************************
	 * Code to setup for a Dynamic Table Create: raids1 View.
	 **************************************************************/
	$viewName = 'admin_menubar1';

	$members_headers = array();
	$record_count_array = array();
	$members_headers = getVisibleColumns($viewName);
	
	//Get Record Counts
	$members_record_count_array = getRecordCounts($admin_menubar, $members_headers, $startRecord);
		
	//Get the Jump Menu and pass it down
	$membersJumpMenu = getPageNavigation($admin_menubar, $startRecord, $pageURL, $sortField, $sortDesc);
				
	//Setup Default Data Sort from Headers Table
	if (!$initSort)
		foreach ($members_headers as $column_rec)
			if ($column_rec['default_sort'])
				$sortField = $column_rec['column_name'];
	
	//Setup Data
	$admin_menubar = paginateSortAndFormat($admin_menubar, $sortField, $sortDesc, $startRecord, $viewName);
	
	/****************************************************************
	 * Data Assign for Template.
	 ****************************************************************/
	$wrmadminsmarty->assign('members', $admin_menubar); 
	$wrmadminsmarty->assign('members_jump_menu', $membersJumpMenu);
	$wrmadminsmarty->assign('column_name', $members_headers); // "column_name" needs to stay static
	$wrmadminsmarty->assign('members_record_counts', $members_record_count_array);
	// "header_data" below needs to stay static
	$wrmadminsmarty->assign('config_data',
		array(
			'template_name'=>$phpraid_config['template'],
			'sort_url_base' => $pageURL,
			'sort_descending' => $sortDesc,
			'sort_text' => $phprlang['sort_text'],
			'datatable_header' => $phprlang['admin_menubar_header'],	
		)
	);

	//
	// Start output of page
	//
	require_once('./includes/admin_page_header.php');
	$wrmadminsmarty->display('admin_style_menubar_mgt.html');
	require_once('./includes/admin_page_footer.php');
	
}

elseif($_GET['mode'] == 'delete')
{
	$menu_value_id = scrub_input($_GET['menu_value_id'], false);
	if($_SESSION['priv_configuration'] == 1) 
	{
		if(!isset($_POST['submit'])) 
		{
			$form_action = $page_filename.'?mode=delete&amp;menu_value_id=' . $menu_value_id;
			$confirm_button = '<input type="submit" value="'. $phprlang['delete'] .'" name="submit" class="post">';
	
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
			$wrmadminsmarty->display('delete.html');
			require_once('./includes/admin_page_footer.php');
		} else {
			log_delete('announcement',$delete_name);
	
			$sql = sprintf("DELETE FROM " . $phpraid_config['db_prefix'] . "menu_value WHERE menu_value_id=%s", quote_smart($menu_value_id));
			$db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	
			header("Location:" . $pageURL);
		}
	} else {
		if($_SESSION['priv_configuration'] == 1)
			header("Location:" . $pageURL);
		else
		{
			//@@ Pop up an error explaning the user doesn't have privlidges to do that.
			header("Location: index.php");
		}
	}
}

elseif(($_GET['mode'] == 'new' || $_GET['mode'] = 'edit') && isset($_POST['submit']))
{

	// just grab the values they posted
	$menu_value_id = scrub_input($_POST['menu_value_id']);
	$menu_type_id = scrub_input($_POST['menu_type_id']);
	$lang_index = scrub_input($_POST['lang_index']);
	$menu_value_title_alt = scrub_input($_POST['menu_value_title_alt']);
	$show_menu_value_title_alt = scrub_input($_POST['show_menu_value_title_alt']);
	$ordering = scrub_input($_POST['ordering']);
	$filename_without_ext = scrub_input($_POST['filename_without_ext']);
	$link = scrub_input($_POST['link']);
	$menu_image = scrub_input($_POST['menu_image']);
	$menu_image_show = scrub_input($_POST['menu_image_show']);
	$permission_value_id = scrub_input($_POST['permission_value_id']);
	$visible = scrub_input($_POST['visible']);

	if($_GET['mode'] == 'new')
	{
		$sql = sprintf("INSERT INTO `" . $phpraid_config['db_prefix'] . "menu_value` 
						( `menu_type_id`, `lang_index`, `menu_value_title_alt`,`show_menu_value_title_alt`, `ordering`,
						`filename_without_ext`, `link`, `menu_image`, `menu_image_show`, `permission_value_id`, `visible` )
						VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)", 
						quote_smart($menu_value_id),quote_smart($menu_type_id),quote_smart($lang_index),
						quote_smart($menu_value_title_alt), quote_smart($show_menu_value_title_alt), quote_smart($ordering), 
						quote_smart($filename_without_ext), quote_smart($link),	quote_smart($menu_image), 
						quote_smart($menu_image_show), quote_smart($permission_value_id), quote_smart($visible)
					);
	}
	elseif($_GET['mode'] == 'edit')
	{
		$sql =  sprintf("UPDATE `" . $phpraid_config['db_prefix'] . "menu_value`" . 
						" SET `menu_type_id` = %s, `lang_index` = %s, `menu_value_title_alt` = %s,".
						" `show_menu_value_title_alt`=%s, `ordering`=%s,".
						" `filename_without_ext`=%s, `link`=%s, `menu_image`=%s, ".
						" `menu_image_show`=%s, `permission_value_id`=%s, `visible`=%s ".
						"WHERE `" . $phpraid_config['db_prefix'] . "menu_value`.`menu_value_id` = %s; ",
						quote_smart($menu_type_id),quote_smart($lang_index), quote_smart($menu_value_title_alt), 
						quote_smart($show_menu_value_title_alt), quote_smart($ordering), 
						quote_smart($filename_without_ext), quote_smart($link),	quote_smart($menu_image), 
						quote_smart($menu_image_show), quote_smart($permission_value_id), quote_smart($visible),
						quote_smart($menu_value_id)
					);
	}
	
	//echo $sql."<br/>";
	
	$db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	
	header("Location: ".$pageURL);
}
	
// and the form
if(($_GET['mode'] != 'delete') and ($_GET['mode'] != 'view'))
{
	$array_visible = array();
	$array_visible['0'] = $phprlang['no'];
	$array_visible['1'] = $phprlang['yes'];
	
	$array_show_menu_value_title_alt = array();
	$array_show_menu_value_title_alt['0'] = $phprlang['no'];
	$array_show_menu_value_title_alt['1'] = $phprlang['yes'];
	
	$array_permission_value_id = array();
	$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "permission_value";

	$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	while($data = $db_raid->sql_fetchrow($result, true))
	{
		$array_permission_value_id[$data['permission_value_id']] = $phprlang[$data['lang_index']];
	}
	$array_permission_value_id['-1'] = "N/A";
	
	$array_menu_type_id = array();
	$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "menu_type";

	$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	while($data = $db_raid->sql_fetchrow($result, true))
	{
		if ($data['menu_type_title_alt'] == "")
			$array_menu_type_id[$data['menu_type_id']] = $phprlang[$data['lang_index']];
		else 
			$array_menu_type_id[$data['menu_type_id']] = $data['menu_type_title_alt'];
	}	
	
	if($_GET['mode'] == 'edit')
	{
		// grab from DB
		$menu_value_id = scrub_input($_GET['menu_value_id']);
	
		$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "menu_value WHERE menu_value_id=%s",quote_smart($menu_value_id));
		$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
		$data = $db_raid->sql_fetchrow($result, true);

		$form_action = $page_filename.'?mode=edit&amp;id=' . $id;
		$menu_value_id = $data['menu_value_id'];
		//$menu_type_id = $data['menu_type_id'];
		$selected_menu_type_id = $data['menu_type_id'];
		$lang_index = $data['lang_index'];
		$menu_value_title_alt = $data['menu_value_title_alt'];
		$selected_show_menu_value_title_alt = $data['show_menu_value_title_alt'];
		$ordering = $data['ordering'];
		$filename_without_ext = $data['filename_without_ext'];
		$link = $data['link'];
		$menu_image = $data['menu_image'];
		$menu_image_show = $data['menu_image_show'];
		$selected_visible = $data['visible'];
		
		if ($data['permission_value_id'] == NULL)
			$selected_permission_value_id = "-1";
		else 
			$selected_permission_value_id = $data['permission_value_id'];

		$button_01 = $phprlang['update'];

		$menubar_header = $phprlang['admin_edit_menubar_entry_header'];
	}
	elseif($_GET['mode'] == 'new')
	{
		//not implement yet
		
		$form_action = $page_filename.'?mode=new';
		$menu_value_id = "";
		//$menu_type_id = "";
		$selected_menu_type_id = "0";
		$lang_index = "";
		$menu_value_title_alt = "";
		$selected_show_menu_value_title_alt = 0;
		$ordering = "";
		$filename_without_ext = "";
		$link = "";
		$menu_image = "";
		$menu_image_show = "";
		$selected_visible = 1;
		$selected_permission_value_id = "-1";
		
		$button_01 = $phprlang['submit'];

		$menubar_header = $phprlang['admin_new_menubar_entry_header'];
	}

	// set variables

	$wrmadminsmarty->assign('config_data',
		array(
			'form_action'=>$form_action,
			'config_data_header' => $menubar_header,
			'menu_value_id' => $menu_value_id,
			'array_menu_type_id' => $array_menu_type_id,
			'selected_menu_type_id' => $selected_menu_type_id,
			'menu_type_id' => $menu_type_id,
			'lang_index' => $lang_index,
			'menu_value_title_alt' => $menu_value_title_alt,
			'selected_show_menu_value_title_alt' =>$selected_show_menu_value_title_alt,
			'array_show_menu_value_title_alt' => $array_show_menu_value_title_alt,
			'ordering' => $ordering,
			'filename_without_ext' => $filename_without_ext,
			'link' => $link,
			'menu_image' => $menu_image,
			'menu_image_show' => $menu_image_show,
			'array_visible' => $array_visible,
			'selected_visible' => $selected_visible,
			'array_permission_value_id' => $array_permission_value_id,
			'selected_permission_value_id' => $selected_permission_value_id,
			'button_01'=> $button_01,
			'button_reset'=> $phprlang['reset'],
		)
	);

	//
	// Start output of page
	//
	require_once('./includes/admin_page_header.php');
	$wrmadminsmarty->display('admin_style_menubar_mgt_edit.html');
	require_once('./includes/admin_page_footer.php');
}

?>
