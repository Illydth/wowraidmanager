<?php
/***************************************************************************
 *                             announcements.php
 *                            -------------------
 *   begin                : Saturday, Jan 16, 2005
 *   copyright            : (C) 2007-2008 Douglas Wagner
 *   email                : douglasw@wagnerweb.org
 *
 *   $Id: announcements.php,v 2.00 2007/11/18 13:08:36 psotfx Exp $
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

// commons
define("IN_PHPRAID", true);
require_once('./common.php');

// page authentication
define("PAGE_LVL","announcements");
require_once("includes/authentication.php");

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
	
$pageURL = 'announcements.php?mode=view&';
$announcement_header = $phprlang['announcements_header'];

/**************************************************************
 * End Record Output Setup for Data Table
 **************************************************************/

if($_GET['mode'] == 'view')
{
	$announcements = array();
	$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "announcements";
	$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	while($data = $db_raid->sql_fetchrow($result, true))
	{
		$id = $data['announcements_id'];
		$title = $data['title'];
		$message = $data['message'];
		
		if(strlen_wrap($title, "UTF-8") > 30)
			$title = substr_wrap($title, 0, 30, "UTF-8") . '...';

		if(strlen_wrap($message, "UTF-8") > 30)
			$message = substr_wrap($message, 0, 30, "UTF-8") . '...';

		$posted_by = $data['posted_by'];
		$date = new_date('Y/m/d H:i:s',$data['timestamp'],$phpraid_config['timezone'] + $phpraid_config['dst']);
		$time = new_date('Y/m/d H:i:s',$data['timestamp'],$phpraid_config['timezone'] + $phpraid_config['dst']);

		$edit = '<a href="announcements.php?mode=edit&amp;id='.$id.'"><img src="templates/' . $phpraid_config['template'] .
				'/images/icons/icon_edit.gif" border="0" onMouseover="ddrivetip(\'' . $phprlang['edit'] . '\');" onMouseout="hideddrivetip();" alt="edit icon"></a> ';

		// Removed "Title" from being passed, no need for it.
		$delete = '<a href="announcements.php?mode=delete&amp;id='.$id.'"><img src="templates/' .
					$phpraid_config['template'] . '/images/icons/icon_delete.gif" border="0" onMouseover="ddrivetip(\'' . $phprlang['delete'] . '\');"
					onMouseout="hideddrivetip();" alt="delete icon"></a>';

		array_push($announcements,
			array(
				'ID'=>$id,
				'Title'=>$title,
				'Message'=>$message,
				'Posted By'=>$posted_by,
				'Create Date'=>$date,
				'Create Time'=>$time,
				'Buttons'=>$edit . $delete,
			)
		);
	}

	/**************************************************************
	 * Code to setup for a Dynamic Table Create: raids1 View.
	 **************************************************************/
	$viewName = 'announcements1';
	
	//Setup Columns
	$raid_headers = array();
	$record_count_array = array();
	$raid_headers = getVisibleColumns($viewName);

	//Get Record Counts
	$curr_record_count_array = getRecordCounts($announcements, $raid_headers, $startRecord);
	
	//Get the Jump Menu and pass it down
	$currJumpMenu = getPageNavigation($announcements, $startRecord, $pageURL, $sortField, $sortDesc);
			
	//Setup Default Data Sort from Headers Table
	if (!$initSort)
		foreach ($raid_headers as $column_rec)
			if ($column_rec['default_sort'])
				$sortField = $column_rec['column_name'];

	//Setup Data
	$announcements = paginateSortAndFormat($announcements, $sortField, $sortDesc, $startRecord, $viewName);

	/****************************************************************
	 * Data Assign for Template.
	 ****************************************************************/
	$wrmsmarty->assign('announcement_data', $announcements);
	$wrmsmarty->assign('announcement_header', $announcement_header); 
	$wrmsmarty->assign('current_jump_menu', $currJumpMenu);
	$wrmsmarty->assign('column_name', $raid_headers);
	$wrmsmarty->assign('curr_record_counts', $curr_record_count_array);
	$wrmsmarty->assign('display_data_table', TRUE);
	$wrmsmarty->assign('header_data',
		array(
			'template_name'=>$phpraid_config['template'],
			'sort_url_base' => $pageURL,
			'sort_descending' => $sortDesc,
			'sort_text' => $phprlang['sort_text'],
		)
	);
	
}
elseif($_GET['mode'] == 'delete')
{
	$id = scrub_input($_GET['id'], false);
	if($_SESSION['priv_announcements'] == 1) 
	{
		if(!isset($_POST['submit'])) 
		{
			$form_action = 'announcements.php?mode=delete&amp;id=' . $id;
			$confirm_button = '<input type="submit" value="'. $phprlang['confirm'] .'" name="submit" class="post">';
	
			$wrmsmarty->assign('page',
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
			require_once('includes/page_header.php');
			$wrmsmarty->display('delete.html');
			require_once('includes/page_footer.php');
		} else {
			log_delete('announcement',$delete_name);
	
			$sql = sprintf("DELETE FROM " . $phpraid_config['db_prefix'] . "announcements WHERE announcements_id=%s", quote_smart($id));
			$db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	
			header("Location: announcements.php?mode=view");
		}
	} else {
		if($_SESSION['priv_announcements'] == 1)
			header("Location: announcements.php?mode=view");
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
	$title = scrub_input($_POST['title'], true);
	$message = scrub_input($_POST['message'], true);
	$timestamp = time();
	$posted_by = $_SESSION['username'];
	if($_GET['mode'] == 'new')
	{
		$sql = sprintf("INSERT INTO " . $phpraid_config['db_prefix'] . "announcements (`title`,`message`,`timestamp`,`posted_by`)
		VALUES (%s,%s,%s,%s)", quote_smart($title),quote_smart($message),quote_smart($timestamp),quote_smart($posted_by));
	
		$db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);

		log_create('announcement',mysql_insert_id(),$title);
	}
	elseif($_GET['mode'] == 'edit')
	{
		$id = scrub_input($_GET['id']);
		$sql = sprintf("UPDATE " . $phpraid_config['db_prefix'] . "announcements SET title=%s,message=%s WHERE announcements_id=%s",quote_smart($title),quote_smart($message),quote_smart($id));
		$db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	}
	header("Location: announcements.php?mode=view");
}
	
// and the form
if($_GET['mode'] != 'delete')
{
	if($_GET['mode'] == 'edit')
	{
		$wrmsmarty->assign('display_data_table', FALSE);
		// grab from DB
		$id = scrub_input($_GET['id']);
	
		$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "announcements WHERE announcements_id=%s",quote_smart($id));
		$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
		$data = $db_raid->sql_fetchrow($result, true);
	
		$form_action = 'announcements.php?mode=edit&amp;id=' . $id;
		$title_data = $data['title'];
		$message_data = $data['message'];
		$button_01 = $phprlang['update'];
	}
	else
	{
		$form_action = 'announcements.php?mode=new';
		$title_data = "";
		$message_data = "";
		$button_01 = $phprlang['submit'];
	}
	
	// set variables
	$wrmsmarty->assign('announcement_header', $announcement_header); 
	$wrmsmarty->assign('new_announcement',
		array(
			'form_action'=>$form_action,
			'title_data'=>$title_data,
			'title_text'=>$phprlang['announcements_title_text'],
			'message_text'=>$phprlang['announcements_message_text'],
			'header'=>$phprlang['announcements_new_header'],
			'message_data'=>$message_data,
			'button_01'=> $button_01,
			'button_reset'=> $phprlang['reset'],
		)
	);

	//
	// Start output of page
	//
	require_once('includes/page_header.php');
	$wrmsmarty->display('announcements.html');
	require_once('includes/page_footer.php');
}

?>