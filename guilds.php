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
	
$pageURL = 'guilds.php?mode=view&';
/**************************************************************
 * End Record Output Setup for Data Table
 **************************************************************/

// show the form
if($_GET['mode'] == 'view' || $_GET['mode'] == 'update' || $_GET['mode'] == 'select' || $_GET['mode'] == 'force_edit') {
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
				'Name'=>$data['guild_name'],
				'Tag'=>$data['guild_tag'],
				'Guild Master'=>$data['guild_master'],
				'Description'=>$data['guild_description'],
				'Server'=>$data['guild_server'],
				'Faction'=>$data['guild_faction'],
				'Armory Link'=>$data['guild_armory_link'],
				'Armory Code'=>$data['guild_armory_code'],
				'Buttons'=>$edit . $delete,
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
			
	//Setup Default Data Sort from Headers Table
	if (!$initSort)
		foreach ($guild_headers as $column_rec)
			if ($column_rec['default_sort'])
				$sortField = $column_rec['column_name'];

	//Setup Data
	$guild = paginateSortAndFormat($guild, $sortField, $sortDesc, $startRecord, $viewName);

	/****************************************************************
	 * Data Assign for Template.
	 ****************************************************************/
	$wrmsmarty->assign('guild_data', $guild); 
	$wrmsmarty->assign('guild_jump_menu', $guildJumpMenu);
	$wrmsmarty->assign('guild_column_name', $guild_headers);
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
	
	/****************************************************************
	 * Raid Force Table Listing.
	 ****************************************************************/
	// Set View_Name if Passed
	if(isset($_GET['raid_force_drop_name']))
		$raid_force_name = scrub_input($_GET['raid_force_drop_name']);
	
	// Fill in the Class Dropdown
	$sql = "SELECT DISTINCT raid_force_name FROM " . $phpraid_config['db_prefix'] . "raid_force";
	$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);			
	while($raid_force_data = $db_raid->sql_fetchrow($result, true))
	{
		$force_name_url = urlencode($raid_force_data['raid_force_name']);
		$rf_options .= "<option ";
		if($raid_force_name == $raid_force_data['raid_force_name'])
			$rf_options .= "SELECTED ";
		$rf_options .= "value=\"guilds.php?mode=select&amp;raid_force_drop_name=" . $force_name_url . "\">" . $raid_force_data['raid_force_name'] ."</option>";
	}
	
	$rf_select = '<select name="raid_force_drop_name" onChange="MM_jumpMenu(\'parent\',this,0)" class="form" style="width:100px">';
	$rf_select .= '<option value="guilds.php?mode=view">'.$phprlang['form_select'].'</option>' . $rf_options . '</select>';
	
	$form_action = 'guilds.php?mode=select';
	
	$wrmsmarty->assign('rf_select_data', 
		array(
			'datatable_header' => $phprlang['raid_force_header'],
			'rf_select_text' => $phprlang['raid_force_select_text'],
			'rf_select' => $rf_select,
			'form_action' => $form_action,
		)
	); 	
} elseif($_GET['mode'] == 'new' || $_GET['mode'] == 'edit') {
	// slashes
	$name = scrub_input($_POST['name'], false);
	$short = scrub_input($_POST['short'], false);
	$master = scrub_input($_POST['master'], false);
	$description = scrub_input($_POST['description'], false);
	$server = scrub_input($_POST['server'], false);
	$faction = scrub_input($_POST['faction'], false);
	$code = scrub_input($_POST['code'], false);
	
	switch ($code)
	{
		case 'US':
			$link = 'http://www.wowarmory.com';
			break;
		case 'EU':
			$link = 'http://ew.wowarmory.com';
			break;
		case 'DE':
			$link = 'http://ew.wowarmory.com';
			break;
		case 'ES':
			$link = 'http://ew.wowarmory.com';
			break;
		case 'FR':
			$link = 'http://ew.wowarmory.com';
			break;
		case 'KR':
			$link = 'http://kr.wowarmory.com';
			break;
		case 'TW':
			$link = 'http://tw.wowarmory.com';
			break;
		default:
			$link = '';
			break;	
	}
	
	// Added Verifications
	$errorSpace = 1;
	$errorTitle = $phprlang['form_error'];
	$errorMsg = '<ul>';
	if ($name == '')
		$errorMsg .= '<li>'.$phprlang['guild_name_missing'].'</li>';
	if ($short == '')
		$errorMsg .= '<li>'.$phprlang['guild_tag_missing'].'</li>';
	if ($server == '')
		$errorMsg .= '<li>'.$phprlang['guild_server_missing'].'</li>';
	if ($faction == '')
		$errorMsg .= '<li>'.$phprlang['guild_faction_missing'].'</li>';
	$errorDie = 0;
	$errorMsg .= '</ul>';

	if($errorMsg != '<ul></ul>')
		$errorDie = 1;
	else
	{
		if($_GET['mode'] == 'new') 	{
			$sql = sprintf("INSERT INTO " . $phpraid_config['db_prefix'] . "guilds 
				(`guild_master`,`guild_name`,`guild_tag`,`guild_description`,`guild_server`,
				`guild_faction`,`guild_armory_link`,`guild_armory_code`) 
				VALUES (%s,%s,%s,%s,%s,%s,%s,%s)",quote_smart($master),quote_smart($name),
				quote_smart($short),quote_smart($description),quote_smart($server),
				quote_smart($faction),quote_smart($link),quote_smart($code));
			
			$db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
			
			log_create('guild',mysql_insert_id(),$name);
		} elseif($_GET['mode'] == 'edit') {
			$id = scrub_input($_GET['id'], false);
			
			$sql = sprintf("UPDATE " . $phpraid_config['db_prefix'] . "guilds 
				SET guild_name=%s,guild_tag=%s,guild_master=%s,guild_description=%s,
				guild_server=%s,guild_faction=%s,guild_armory_link=%s,guild_armory_code=%s 
				WHERE guild_id=%s",quote_smart($name),quote_smart($short),
				quote_smart($master),quote_smart($description),quote_smart($server),
				quote_smart($faction),quote_smart($link),quote_smart($code),
				quote_smart($id));
			$db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
		}		
	
		header("Location: guilds.php?mode=view");
	}
} elseif($_GET['mode'] == 'force_new' || $_GET['mode'] == 'force_edit_submit') {
	
	$raid_force_name = scrub_input($_POST['raid_force_name']);
	$guild_id = scrub_input($_POST['guild_id']);
	
	$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "raid_force WHERE raid_force_name = %s AND guild_id = %s", quote_smart($raid_force_name), quote_smart($guild_id));
	$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(),1);
	$numrows = $db_raid->sql_numrows($result);

	// Added Verifications
	$errorSpace = 1;
	$errorTitle = $phprlang['form_error'];
	$errorMsg = '<ul>';
	if ($raid_force_name == '')
		$errorMsg .= '<li>'.$phprlang['raid_force_name_missing'].'</li>';
	if ($_GET['mode'] == 'force_new' && $numrows >= 1)
		$errorMsg .= '<li>'.$phprlang['raid_force_duplicate'].'</li>';
	if ($guild_id == '')
		$errorMsg .= '<li>'.$phprlang['raid_force_guild_id_missing'].'</li>';
	$errorDie = 0;
	$errorMsg .= '</ul>';

	if($errorMsg != '<ul></ul>')
		$errorDie = 1;
	else
	{	
		if($_GET['mode'] == 'force_new') 	{
			$sql = sprintf("INSERT INTO " . $phpraid_config['db_prefix'] . "raid_force 
				(`raid_force_name`,`guild_id`) VALUES (%s,%s)",
				quote_smart($raid_force_name),quote_smart($guild_id));
			
			$db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
			
			log_create('raid_force',mysql_insert_id(),$name);
		} elseif($_GET['mode'] == 'force_edit_submit') {
			$rf_id = scrub_input($_GET['rf_id'], false);
			
			$sql = sprintf("UPDATE " . $phpraid_config['db_prefix'] . "raid_force 
				SET raid_force_name=%s,guild_id=%s WHERE raid_force_id = %s",
				quote_smart($raid_force_name),quote_smart($guild_id),
				quote_smart($rf_id));
			
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
			exit;		
		} else {
			log_delete('guild',$n);
			
			$sql = sprintf("DELETE FROM " . $phpraid_config['db_prefix'] . "guilds WHERE guild_id=%s",quote_smart($id));
			$db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
			
			// Deleting the guild, set all characters to a guild ID of "0" to denote they are not attached to a guild.
			$sql = sprintf("UPDATE " . $phpraid_config['db_prefix'] . "chars SET guild = '0' WHERE guild = %s",quote_smart($id));
			$db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
			
			header("Location: guilds.php?mode=view");
		}
	} else {
		if($_SESSION['priv_guilds'] == 1)
			header("Location: guilds.php?mode=view");
		else
			header("Location: index.php");
	}

} elseif($_GET['mode'] == 'force_delete') {
	$rf_id = scrub_input($_GET['rf_id'], false);
	
	if($_SESSION['priv_guilds'] == 1) {
		if(!isset($_POST['submit'])) {			
			$form_action = 'guilds.php?mode=force_delete&amp;rf_id=' . $rf_id;
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
			exit;		
		} else {
			log_delete('raid_force',$rf_id);
			
			$sql = sprintf("DELETE FROM " . $phpraid_config['db_prefix'] . "raid_force WHERE raid_force_id=%s",quote_smart($rf_id));
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

if($_GET['mode'] == 'select' || $_GET['mode'] == 'force_edit') {
	
	$raid_force = array();
	
	$raid_force_name = scrub_input($_GET['raid_force_drop_name']);
	$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "raid_force WHERE raid_force_name = %s", quote_smart($raid_force_name));
	$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(),1);
	while($data = $db_raid->sql_fetchrow($result, true)) 
	{	
		$edit = '<a href="guilds.php?mode=force_edit&amp;rf_id='.$data['raid_force_id'].'&amp;raid_force_drop_name='.$raid_force_name.'"><img src="templates/' . $phpraid_config['template'] . 
				'/images/icons/icon_edit.gif" border="0" onMouseover="ddrivetip(\''.$phprlang['edit'].'\');" onMouseout="hideddrivetip();" alt="edit icon"></a>';
				
		$delete = '<a href="guilds.php?mode=force_delete&amp;rf_id='.$data['raid_force_id'].'"><img src="templates/' . 
					$phpraid_config['template'] . '/images/icons/icon_delete.gif" border="0" onMouseover="ddrivetip(\''.$phprlang['delete'].'\');" 
					onMouseout="hideddrivetip();" alt="delete icon"></a>';
		
		// Get the Guild Name to Display instead of Just the ID
		$sql = sprintf("SELECT guild_name FROM " . $phpraid_config['db_prefix'] . "guilds WHERE guild_id=%s",quote_smart($data['guild_id']));
		$guild_result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
		$guild_data = $db_raid->sql_fetchrow($guild_result, true);
		$guild_name = $guild_data['guild_name'];
		
		array_push($raid_force, 
			array(
				'ID'=>$data['raid_force_id'],
				'Force Name'=>$data['raid_force_name'],
				'Guild ID'=>$data['guild_id'],
				'Guild Name'=>$guild_name,
				'Buttons'=>$edit . $delete,
			)
		);
		
	}

	/**************************************************************
	 * Code to setup for a Dynamic Table Create: raidforce1 View.
	 **************************************************************/
	$viewName = 'raidforce1';
	
	//Setup Columns
	$rf_headers = array();
	$rf_count_array = array();
	$rf_headers = getVisibleColumns($viewName);

	//Get Record Counts
	$rf_record_count_array = getRecordCounts($raid_force, $rf_headers, $startRecord);
	
	//Get the Jump Menu and pass it down
	$rfJumpMenu = getPageNavigation($raid_force, $startRecord, $pageURL, $sortField, $sortDesc);
			
	//Setup Default Data Sort from Headers Table
	if (!$initSort)
		foreach ($rf_headers as $column_rec)
			if ($column_rec['default_sort'])
				$sortField = $column_rec['column_name'];

	//Setup Data
	$raid_force = paginateSortAndFormat($raid_force, $sortField, $sortDesc, $startRecord, $viewName);

	/****************************************************************
	 * Data Assign for Template.
	 ****************************************************************/
	$wrmsmarty->assign('rf_data', $raid_force); 
	$wrmsmarty->assign('rf_jump_menu', $rfJumpMenu);
	$wrmsmarty->assign('rf_column_name', $rf_headers);
	$wrmsmarty->assign('rf_record_counts', $rf_record_count_array);
	$wrmsmarty->assign('rf_header_data',
		array(
			'template_name'=>$phpraid_config['template'],
			'header' => $phprlang['raid_force_header'],
			'sort_url_base' => $pageURL,
			'sort_descending' => $sortDesc,
			'sort_text' => $phprlang['sort_text'],
		)
	);	
}
if($_GET['mode'] != 'delete' && $_GET['mode'] != 'force_delete') {
	if($_GET['mode'] == 'view' || $_GET['mode'] == 'select') {
		// setup new form information
		$form_action = 'guilds.php?mode=new';
		$name = '<input name="name" type="text" id="name" class="post">';
		$short = '<input name="short" type="text" id="short" class="post">';
		$master = '<input name="master" type="text" id="master" class="post">';
		$description = '<input name="description" type="text" id="description" class="post">';
		$server = '<input name="server" type="text" id="server" class="post">';
		
		// Raid Force Boxes
		$force_form_action = "guilds.php?mode=force_new";
		$raid_force_name = '<input name="raid_force_name" type="text" id="raid_force_name" class="post">';

		$guild_options = '<select name="guild_id">';
		$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "guilds";
		$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);			
		while($guild_data = $db_raid->sql_fetchrow($result, true))
			$guild_options .= "<option value=\"" . $guild_data['guild_id'] . "\">" . $guild_data['guild_name']."</option>";
		$guild_options .= '</select>';
		
		// now the faction
		$faction = '<select name="faction" class="post">';
		$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "faction";
		$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);			
		while($faction_data = $db_raid->sql_fetchrow($result, true))
		{
			$faction .= "<option ";
			if($faction_data['faction_name'] == $phpraid_config['faction'])
				$faction .= "SELECTED ";
			$faction .= "value=\"" . $faction_data['faction_name'] . "\">" . $faction_data['faction_name'] ."</option>";
		}
		$faction .= '</select>';

		// Selection box for Armory Code.
		$armory_box = '<select name="code" class="post">';
		$armory_box .=   '<option value="US" selected>US : http://www.wowarmory.com : English</option>';
		$armory_box .=   '<option value="EU">EU : http://eu.wowarmory.com : English</option>';
		$armory_box .=   '<option value="DE">DE : http://eu.wowarmory.com : German</option>';
		$armory_box .=   '<option value="ES">ES : http://eu.wowarmory.com : Spanish</option>';
		$armory_box .=   '<option value="FR">FR : http://eu.wowarmory.com : French</option>';
		$armory_box .=   '<option value="KR">KR : http://kr.wowarmory.com : Korean</option>';
		$armory_box .=   '<option value="TW">TW : http://tw.wowarmory.com : Taiwainese</option>';
		$armory_box .=   '<option value="None">No Armory or Not Applicable</option>';
		$armory_box .= '</select>';
		
		$buttons = '<input type="submit" value="'.$phprlang['submit'].'" name="submit" class="mainoption"> <input type="reset" value="'.$phprlang['reset'].'" name="reset" class="liteoption">';
		$rf_buttons = '<input type="submit" value="'.$phprlang['submit'].'" name="submit" class="mainoption"> <input type="reset" value="'.$phprlang['reset'].'" name="reset" class="liteoption">';
	} elseif($_GET['mode'] == 'update' || $_GET['mode'] == 'force_edit') {
		$id = scrub_input($_GET['id'], false);
		$rf_id = scrub_input($_GET['rf_id'], false);
		
		$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "guilds WHERE guild_id=%s",quote_smart($id));
		$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
		$data = $db_raid->sql_fetchrow($result, true);
		
		// it's an edit... joy
		$form_action = "guilds.php?mode=edit&amp;id=$id";
		$name = '<input name="name" type="text" id="name" value="' . $data['guild_name'] . '" class="post">';
		$short = '<input name="short" type="text" id="short" value="' . $data['guild_tag'] . '" class="post">';
		$master = '<input name="master" type="text" id="master" value="' . $data['guild_master'] . '" class="post">';
		$description = '<input name="description" type="text" id="description" value="' . $data['guild_description'] . '" class="post">';
		$server = '<input name="server" type="text" id="server" value="' . $data['guild_server'] . '" class="post">';

		// Raid Force Boxes
		$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "raid_force WHERE raid_force_id=%s",quote_smart($rf_id));
		$rf_result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
		$rf_data = $db_raid->sql_fetchrow($rf_result, true);
		
		$force_form_action = "guilds.php?mode=force_edit_submit&amp;rf_id=".$rf_id;
		
		$raid_force_name = '<input name="raid_force_name" type="text" id="raid_force_name" class="post" value="'.$rf_data['raid_force_name'].'">';

		$guild_options = '<select name="guild_id">';
		$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "guilds";
		$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);			
		while($guild_data = $db_raid->sql_fetchrow($result, true))
		{
			$guild_options .= "<option ";
			if($rf_data['guild_id'] == $class_data['guild_id'])
				$guild_options .= "SELECTED ";
			$guild_options .= "value=\"" . $guild_data['guild_id'] . "\">" . $guild_data['guild_name']."</option>";
		}
		$guild_options .= '</select>';
		
		// now the faction
		$faction = '<select name="faction" class="post">';
		$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "faction";
		$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);			
		while($faction_data = $db_raid->sql_fetchrow($result, true))
		{
			$faction .= "<option ";
			if($faction_data['faction_name'] == $data['guild_faction'])
				$faction .= "SELECTED ";
			$faction .= "value=\"" . $faction_data['faction_name'] . "\">" . $faction_data['faction_name'] ."</option>";
		}
		$faction .= '</select>';
		
		// Selection box for Armory Code.
		$armory_box = '<select name="code" class="post">';
		if ($data['guild_armory_code'] == 'US')
			$armory_box .=   '<option value="US" selected>US : http://www.wowarmory.com : English</option>';
		else 
			$armory_box .=   '<option value="US">US : http://www.wowarmory.com : English</option>';
		if ($data['guild_armory_code'] == 'EU')
			$armory_box .=   '<option value="EU" selected>EU : http://eu.wowarmory.com : English</option>';
		else 
			$armory_box .=   '<option value="EU">EU : http://eu.wowarmory.com : English</option>';
		if ($data['guild_armory_code'] == 'DE')
			$armory_box .=   '<option value="DE" selected>DE : http://eu.wowarmory.com : German</option>';
		else 
			$armory_box .=   '<option value="DE">DE : http://eu.wowarmory.com : German</option>';
		if ($data['guild_armory_code'] == 'ES')
			$armory_box .=   '<option value="ES" selected>ES : http://eu.wowarmory.com : Spanish</option>';
		else 
			$armory_box .=   '<option value="ES">ES : http://eu.wowarmory.com : Spanish</option>';
		if ($data['guild_armory_code'] == 'FR')
			$armory_box .=   '<option value="FR" selected>FR : http://eu.wowarmory.com : French</option>';
		else 
			$armory_box .=   '<option value="FR">FR : http://eu.wowarmory.com : French</option>';
		if ($data['guild_armory_code'] == 'KR')
			$armory_box .=   '<option value="KR" selected>KR : http://kr.wowarmory.com : Korean</option>';
		else 
			$armory_box .=   '<option value="KR">KR : http://kr.wowarmory.com : Korean</option>';
		if ($data['guild_armory_code'] == 'TW')
			$armory_box .=   '<option value="TW" selected>TW : http://tw.wowarmory.com : Taiwainese</option>';
		else 
			$armory_box .=   '<option value="TW">TW : http://tw.wowarmory.com : Taiwainese</option>';
		if ($data['guild_armory_code'] == '')
			$armory_box .=   '<option value="None" selected>No Armory or Not Applicable</option>';
		else 
			$armory_box .=   '<option value="None">No Armory or Not Applicable</option>';
		$armory_box .= '</select>';
				
		$buttons = '<input type="submit" value="'.$phprlang['update'].'" name="submit" class="mainoption"> <input type="reset" value="'.$phprlang['reset'].'" name="reset" class="liteoption">';			
		$rf_buttons = '<input type="submit" value="'.$phprlang['update'].'" name="submit" class="mainoption"> <input type="reset" value="'.$phprlang['reset'].'" name="reset" class="liteoption">';
	}
	
	$wrmsmarty->assign('guilds_new',
		array(
			'form_action'=>$form_action,
			'name'=>$name,
			'short'=>$short,
			'master'=>$master,
			'description'=>$description,
			'server'=>$server,
			'faction'=>$faction,
			'code'=>$armory_box,
			'buttons'=>$buttons,
			'newguild_header'=>$phprlang['guilds_new_header'],
			'name_text'=>$phprlang['guilds_name'],
			'short_text'=>$phprlang['guilds_tag'],
			'master_text'=>$phprlang['guilds_master'],
			'description_text'=>$phprlang['guilds_description'],
			'server_text'=>$phprlang['guilds_server'],
			'faction_text'=>$phprlang['guilds_faction'],
			'code_text'=>$phprlang['guilds_armory_code'],
		)
	);
	
	$wrmsmarty->assign('force_new',
		array(
			'force_new_header'=>$phprlang['raid_force_new_header'],
			'force_form_action'=>$force_form_action,
			'raid_force_name_box'=>$raid_force_name,
			'guild_options_box'=>$guild_options,
			'raid_force_name_box_text'=>$phprlang['raid_force_name_box_text'],
			'guild_options_text'=>$phprlang['raid_force_guild_options_text'],
			'rf_buttons'=>$rf_buttons,
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