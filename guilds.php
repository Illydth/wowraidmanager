<?php
/***************************************************************************
 *                               guilds.php
 *                            -------------------
 *   begin                : Saturday, Jan 16, 2005
 *   copyright            : (C) 2007-2008 Douglas Wagner
 *   email                : douglasw@wagnerweb.org
 *
 *   $Id: guilds.php,v 2.00 2008/02/29 13:25:14 psotfx Exp $
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
define("PAGE_LVL","guilds");
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
if(!isset($_GET['Sort']))
	$sortField="";
else
	$sortField = scrub_input($_GET['Sort']);
	
// Set Sort Descending Mark
if(!isset($_GET['SortDescending']) || !is_numeric($_GET['SortDescending']))
	$sortDesc = 1;
else
	$sortDesc = scrub_input($_GET['SortDescending']);
	
$pageURL = 'guilds.php?mode=view&';
/**************************************************************
 * End Record Output Setup for Data Table
 **************************************************************/

// show the form
if($_GET['mode'] == 'view' || $_GET['mode'] == 'update') {
	$guild = array();
	
	$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "guilds";
	$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(),1);
	while($data = $db_raid->sql_fetchrow($result, true)) {
		

	$edit = '<a href="guilds.php?mode=update&amp;id='.$data['guild_id'].'"><img src="templates/' . $phpraid_config['template'] . 
			'/images/icons/icon_edit.gif" border="0" onMouseover="ddrivetip(\''.$phprlang['edit'].'\');" onMouseout="hideddrivetip();" alt="edit icon"></a>';
			
	$delete = '<a href="guilds.php?mode=delete&amp;n='.$data['guild_name'].'&amp;id='.$data['guild_id'].'"><img src="templates/' . 
				$phpraid_config['template'] . '/images/icons/icon_delete.gif" border="0" onMouseover="ddrivetip(\''.$phprlang['delete'].'\');" 
				onMouseout="hideddrivetip();" alt="delete icon"></a>';
		
		array_push($guild, 
			array(
				'ID'=>$data['guild_id'],
				'Guild Name'=>$data['guild_name'],
				'Guild Tag'=>$data['guild_tag'],
				'Guild Master'=>$data['guild_master'],
				'Actions'=>$edit . $delete,
				)
		);
	}
	
	/**************************************************************
	 * Code to setup for a Dynamic Table Create: guild1 View.
	 **************************************************************/
	$viewName = 'guild1';
	
	//Setup Columns
	$guild_headers = array();
	$record_count_array = array();
	$guild_headers = getVisibleColumns($viewName);

	//Get Record Counts
	$guild_record_count_array = getRecordCounts($guild, $guild_headers, $startRecord);
	
	//Get the Jump Menu and pass it down
	$guildJumpMenu = getPageNavigation($guild, $startRecord, $pageURL, $sortField, $sortDesc);

	//Setup Data
	$guild = paginateSortAndFormat($guild, $sortField, $sortDesc, $startRecord, $viewName);

	/****************************************************************
	 * Data Assign for Template.
	 ****************************************************************/
	$wrmsmarty->assign('guild_data', $guild); 
	$wrmsmarty->assign('guild_jump_menu', $guildJumpMenu);
	$wrmsmarty->assign('column_name', $guild_headers);
	$wrmsmarty->assign('guild_record_counts', $guild_record_count_array);
	$wrmsmarty->assign('header_data',
		array(
			'template_name'=>$phpraid_config['template'],
			'header' => $phprlang['guilds_header'],
			'sort_url_base' => $pageURL,
			'sort_descending' => $sortDesc,
			'sort_text' => $phprlang['sort_text'],
		)
	);
	
} elseif($_GET['mode'] == 'new' || $_GET['mode'] == 'edit') {
	// slashes
	$name = scrub_input($_POST['name'], false);
	$short = scrub_input($_POST['short'], false);
	$master = scrub_input($_POST['master'], false);
	
	// Added Verifications
	$errorSpace = 1;
	$errorTitle = $phprlang['form_error'];
	$errorMsg = '<ul>';
	if ($name == '')
		$errorMsg .= '<li>'.$phprlang['guild_name_missing'].'</li>';
	if ($short == '')
		$errorMsg .= '<li>'.$phprlang['guild_tag_missing'].'</li>';
	$errorDie = 0;
	$errorMsg .= '</ul>';

	if($errorMsg != '<ul></ul>')
		$errorDie = 1;
	else
	{
		if($_GET['mode'] == 'new') 	{
			$sql = sprintf("INSERT INTO " . $phpraid_config['db_prefix'] . "guilds (`guild_master`,`guild_name`,`guild_tag`) 
			VALUES (%s,%s,%s)",quote_smart($master),quote_smart($name),quote_smart($short));
			
			$db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
			
			log_create('guild',mysql_insert_id(),$name);
		} elseif($_GET['mode'] == 'edit') {
			$id = scrub_input($_GET['id'], false);
			
			$sql = sprintf("UPDATE " . $phpraid_config['db_prefix'] . "guilds SET guild_name=%s,guild_tag=%s,guild_master=%s WHERE guild_id=%s",quote_smart($name),quote_smart($short),quote_smart($master),quote_smart($id));
			$db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
		}		
	
		header("Location: guilds.php?mode=view");
	}

} elseif($_GET['mode'] == 'delete') {
	$id = scrub_input($_GET['id'], false);
	$n = scrub_input($_GET['n'], false);
	
	if($_SESSION['priv_guilds'] == 1) {
		if(!isset($_POST['submit'])) {			
			$form_action = 'guilds.php?mode=delete&amp;n='.$n.'&amp;id=' . $id;
			$confirm_button = '<input type="submit" value="'.$phprlang['confirm'].'" name="submit" class="post">';
			
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
			log_delete('guild',$n);
			
			$sql = sprintf("DELETE FROM " . $phpraid_config['db_prefix'] . "guilds WHERE guild_id=%s",quote_smart($id));
			$db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
			
			header("Location: guilds.php?mode=view");
		}
	} else {
		if($_SESSION['priv_guilds'] == 1)
			header("Location: guilds.php?mode=view");
		else
			header("Location: index.php");
	}
}

if($_GET['mode'] != 'delete') {
	if($_GET['mode'] == 'view') {
		// setup new form information
		$form_action = 'guilds.php?mode=new';
		$name = '<input name="name" type="text" id="name" class="post">';
		$short = '<input name="short" type="text" id="short" class="post">';
		$master = '<input name="master" type="text" id="master" class="post">';
		
		$buttons = '<input type="submit" value="'.$phprlang['submit'].'" name="submit" class="mainoption"> <input type="reset" value="'.$phprlang['reset'].'" name="reset" class="liteoption">';
	} elseif($_GET['mode'] == 'update') {
		$id = scrub_input($_GET['id'], false);
		
		$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "guilds WHERE guild_id=%s",quote_smart($id));
		$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
		$data = $db_raid->sql_fetchrow($result, true);
		
		// it's an edit... joy
		$form_action = "guilds.php?mode=edit&amp;id=$id";
		$name = '<input name="name" type="text" id="name" value="' . $data['guild_name'] . '" class="post">';
		$short = '<input name="short" type="text" id="short" value="' . $data['guild_tag'] . '" class="post">';
		$master = '<input name="master" type="text" id="master" value="' . $data['guild_master'] . '" class="post">';
		
		$buttons = '<input type="submit" value="'.$phprlang['update'].'" name="submit" class="mainoption"> <input type="reset" value="'.$phprlang['reset'].'" name="reset" class="liteoption">';			
	}
	
	$wrmsmarty->assign('guilds_new',
		array(
			'form_action'=>$form_action,
			'name'=>$name,
			'short'=>$short,
			'master'=>$master,
			'buttons'=>$buttons,
			'newguild_header'=>$phprlang['guilds_new_header'],
			'name_text'=>$phprlang['guilds_name'],
			'short_text'=>$phprlang['guilds_tag'],
			'master_text'=>$phprlang['guilds_master']
		)
	);
}

//
// Start output of page
//
if($_GET['mode'] != 'delete')
{
	require_once('includes/page_header.php');
	$wrmsmarty->display('guilds.html');
	require_once('includes/page_footer.php');
}
?>