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

require_once("includes/functions_guilds.php");

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
	$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(),1);
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
	$array_raid_force = array();
	// Set View_Name if Passed
	if(isset($_GET['raid_force_drop_name']))
		$raid_force_name = scrub_input($_GET['raid_force_drop_name']);
	
	// Fill in the Class Dropdown
	
//	$rf_select = '<select name="raid_force_drop_name" onChange="MM_jumpMenu(\'parent\',this,0)" class="form" style="width:100px">';
//	$rf_select .= '<option value="guilds.php?mode=view">'.$phprlang['form_select'].'</option>' . $rf_options . '</select>';
		
		
	$sql = "SELECT DISTINCT raid_force_name FROM " . $phpraid_config['db_prefix'] . "raid_force";
	$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);			
	while($raid_force_data = $db_raid->sql_fetchrow($result, true))
	{
		$force_name_url = urlencode($raid_force_data['raid_force_name']);
		$array_raid_force["guilds.php?mode=select&amp;raid_force_drop_name=" . $force_name_url] = $raid_force_data['raid_force_name'];

//		$rf_options .= "<option ";
		
		if($raid_force_name == $raid_force_data['raid_force_name'])
			$selected_raid_force = $raid_force_data['raid_force_name'];
//			$rf_options .= "SELECTED ";
			
//		$rf_options .= "value=\"guilds.php?mode=select&amp;raid_force_drop_name=" . $force_name_url . "\">" . $raid_force_data['raid_force_name'] ."</option>";
	}
	$array_raid_force[$phprlang['form_select']] = $phprlang['form_select'];
	
	$form_action = 'guilds.php?mode=select';
	$rf_select_data ="";
	$wrmsmarty->assign('rf_select_data', 
		array(
			'datatable_header' => $phprlang['raid_force_header'],
			'rf_select_text' => $phprlang['raid_force_select_text'],
			'array_raid_force' => $array_raid_force,
			'selected_raid_force' => $selected_raid_force,
			//'rf_select' => $rf_select,
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
	$code = scrub_input($_POST['armory_code'], false);
	
	$link = get_armory_link_from_code($code);

	
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
		if($_GET['mode'] == 'new')
		{
			//create new guilde
			guild_add_new($master,$name,$short,$description,$server,$faction,$link,$code);
		} elseif($_GET['mode'] == 'edit') 
		{	
			//edit guilde
			$id = scrub_input($_GET['id'], false);
			guild_edit($name,$short,$master,$description,$server,$faction,$link,$code,$id);
		}		
	
		header("Location: guilds.php?mode=view");
	}
} elseif($_GET['mode'] == 'force_new' || $_GET['mode'] == 'force_edit_submit') {
	
	$raid_force_name = scrub_input($_POST['raid_force_name']);
	$guild_id = scrub_input($_POST['guild_id']);
	
	$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "raid_force WHERE raid_force_name = %s AND guild_id = %s", quote_smart($raid_force_name), quote_smart($guild_id));
	$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(),1);
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
			
			$db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
			
			log_create('raid_force',mysql_insert_id(),$name);
		} elseif($_GET['mode'] == 'force_edit_submit') {
			$rf_id = scrub_input($_GET['rf_id'], false);
			
			$sql = sprintf("UPDATE " . $phpraid_config['db_prefix'] . "raid_force 
				SET raid_force_name=%s,guild_id=%s WHERE raid_force_id = %s",
				quote_smart($raid_force_name),quote_smart($guild_id),
				quote_smart($rf_id));
			
			$db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
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
			guild_remove($n, $id);
			
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
			$db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
			
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
	$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(),1);
	while($data = $db_raid->sql_fetchrow($result, true)) 
	{	
		$edit = '<a href="guilds.php?mode=force_edit&amp;rf_id='.$data['raid_force_id'].'&amp;raid_force_drop_name='.$raid_force_name.'"><img src="templates/' . $phpraid_config['template'] . 
				'/images/icons/icon_edit.gif" border="0" onMouseover="ddrivetip(\''.$phprlang['edit'].'\');" onMouseout="hideddrivetip();" alt="edit icon"></a>';
				
		$delete = '<a href="guilds.php?mode=force_delete&amp;rf_id='.$data['raid_force_id'].'"><img src="templates/' . 
					$phpraid_config['template'] . '/images/icons/icon_delete.gif" border="0" onMouseover="ddrivetip(\''.$phprlang['delete'].'\');" 
					onMouseout="hideddrivetip();" alt="delete icon"></a>';
		
		// Get the Guild Name to Display instead of Just the ID
		$sql = sprintf("SELECT guild_name FROM " . $phpraid_config['db_prefix'] . "guilds WHERE guild_id=%s",quote_smart($data['guild_id']));
		$guild_result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
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

	// Selection box for Armory Code.
	$array_armory_code = get_armory_code_full();
	$array_faction = array();
	$array_guild = array();
	
	if($_GET['mode'] == 'view' || $_GET['mode'] == 'select') {
		
		// setup new form information
		$form_action = 'guilds.php?mode=new';
		$guild_name = "";
		$guild_tag = "";
		$guild_master = "";
		$guild_description = "";
		$guild_server = "";
			 
		// now the faction
		$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "faction";
		$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);			
		while($faction_data = $db_raid->sql_fetchrow($result, true))
		{
			$array_faction[$faction_data['faction_name']] = $faction_data['faction_name'];

			if($faction_data['faction_name'] == $phpraid_config['faction'])
			{
				$selected_faction = $faction_data['faction_name'];
			}			
		}
		
		$selected_armory_code = $data['guild_armory_code'];
		
		// Raid Force Boxes
		$force_form_action = "guilds.php?mode=force_new";
		$raid_force_name = "";

		$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "guilds";
		$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);			
		while($guild_data = $db_raid->sql_fetchrow($result, true))
		{
			$array_guild[$guild_data['guild_id']] = $guild_data['guild_name'];
		}
		
		$button_01 = $phprlang['submit'];
		
	} elseif($_GET['mode'] == 'update' || $_GET['mode'] == 'force_edit') {
		$id = scrub_input($_GET['id'], false);
		$rf_id = scrub_input($_GET['rf_id'], false);
		
		$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "guilds WHERE guild_id=%s",quote_smart($id));
		$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
		$data = $db_raid->sql_fetchrow($result, true);
		
		// it's an edit... joy
		$form_action = "guilds.php?mode=edit&amp;id=$id";
		$guild_name = $data['guild_name'];
		$guild_tag = $data['guild_tag'];
		$guild_master = $data['guild_master'];
		$guild_description = $data['guild_description'];
		$guild_server = $data['guild_server'];
		
		// now the faction
		$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "faction";
		$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);			
		while($faction_data = $db_raid->sql_fetchrow($result, true))
		{
			$array_faction[$faction_data['faction_name']] = $faction_data['faction_name'];

			if($faction_data['faction_name'] == $data['guild_faction'])
			{
				$selected_faction = $faction_data['faction_name'];
			}
		}

		$selected_armory_code = $data['guild_armory_code'];
		
		// Raid Force Boxes
		$force_form_action = "guilds.php?mode=force_edit_submit&amp;rf_id=".$rf_id;
		$raid_force_name = $rf_data['raid_force_name'];
		
		$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "raid_force WHERE raid_force_id=%s",quote_smart($rf_id));
		$rf_result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
		$rf_data = $db_raid->sql_fetchrow($rf_result, true);
		
		$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "guilds";
		$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);			
		while($guild_data = $db_raid->sql_fetchrow($result, true))
		{
			$array_guild[$guild_data['guild_id']] = $guild_data['guild_name'];
			
			if($rf_data['guild_id'] == $guild_data['guild_id'])
				$selected_guild = $guild_data['guild_id'];				
		}

		$button_01 = $phprlang['update'];
	}
	
	$wrmsmarty->assign('guilds_new',
		array(
			'form_action'=>$form_action,
			'guild_name'=>$guild_name,
			'guild_tag'=>$guild_tag,
			'guild_master'=>$guild_master,
			'guild_description'=>$guild_description,
			'guild_server'=>$guild_server,
			'array_faction' => $array_faction,
			'selected_faction' => $selected_faction,
			'newguild_header'=>$phprlang['guilds_new_header'],
			'name_text'=>$phprlang['guilds_name'],
			'short_text'=>$phprlang['guilds_tag'],
			'master_text'=>$phprlang['guilds_master'],
			'description_text'=>$phprlang['guilds_description'],
			'server_text'=>$phprlang['guilds_server'],
			'faction_text'=>$phprlang['guilds_faction'],
			'code_text'=>$phprlang['guilds_armory_code'],
			'selected_armory_code'=>$selected_armory_code,
			'array_armory_code'=>$array_armory_code,
			'button_submit' => $button_01,
			'button_reset' => $phprlang['reset']
		)
	);
	
	$wrmsmarty->assign('force_new',
		array(
			'force_new_header'=>$phprlang['raid_force_new_header'],
			'force_form_action'=>$force_form_action,
			'raid_force_name' =>$raid_force_name,
			'array_guild' => $array_guild,
			'selected_guild' => $selected_guild,
			'array_guild' => $array_guild,
			'selected_guild' => $selected_guild,
			'raid_force_name_box_text'=>$phprlang['raid_force_name_box_text'],
			'guild_options_text'=>$phprlang['raid_force_guild_options_text'],
			'button_submit' => $button_01,
			'button_reset' => $phprlang['reset']
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
