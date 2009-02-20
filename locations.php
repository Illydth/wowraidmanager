<?php
/***************************************************************************
 *                               locations.php
 *                            -------------------
 *   begin                : Saturday, Jan 16, 2005
 *   copyright            : (C) 2007-2008 Douglas Wagner
 *   email                : douglasw@wagnerweb.org
 *
 *   $Id: locations.php,v 2.0 2008/03/07 16:46:43 psotfx Exp $
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
define("PAGE_LVL","locations");
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
	
$pageURL = 'locations.php?mode=view&';
/**************************************************************
 * End Record Output Setup for Data Table
 **************************************************************/

// show the form
if($_GET['mode'] == 'view')
{
	$loc = array();

	$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "locations";
	$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
	while($data = $db_raid->sql_fetchrow($result, true))
	{
		$edit = '<a href="locations.php?mode=update&amp;id='.$data['location_id'].'"><img src="templates/' . $phpraid_config['template'] .
				'/images/icons/icon_edit.gif" border="0" onMouseover="ddrivetip(\'' . $phprlang['edit'] . '\');" onMouseout="hideddrivetip();" alt="edit icon"></a>';

		$delete = '<a href="locations.php?mode=delete&amp;n='.$data['name'].'&amp;id='.$data['location_id'].'"><img src="templates/' .
					$phpraid_config['template'] . '/images/icons/icon_delete.gif" border="0" onMouseover="ddrivetip(\'' . $phprlang['delete'] . '\');" onMouseout="hideddrivetip();" alt="delete icon"></a>';

		$sql = "SELECT event_type_lang_id FROM " . $phpraid_config['db_prefix'] . "event_type WHERE event_type_id =" . $data['event_type'];
		$result2 = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
		$event_type_data = $db_raid->sql_fetchrow($result2, true);
		$event_type_id = $event_type_data['event_type'];
		$event_type_text = $phprlang[$event_type_data['event_type_lang_id']];
		
		array_push($loc,
			array(
				'ID'=>$data['location_id'],
				'Name'=>$data['name'],
				'Event Type'=>$event_type_text,
				'Dungeon'=>$data['location'],
				'Min Level'=>$data['min_lvl'],
				'Max Level'=>$data['max_lvl'],
				'Raid Max'=>$data['max'],
				'Death Knight'=>$data['dk'],
				'Druid'=>$data['dr'],
				'Hunter'=>$data['hu'],
				'Mage'=>$data['ma'],
				'Paladin'=>$data['pa'],
				'Priest'=>$data['pr'],
				'Rogue'=>$data['ro'],
				'Shaman'=>$data['sh'],
				'Warlock'=>$data['wk'],
				'Warrior'=>$data['wa'],
				$phpraid_config['role1_name']=>$data['role1'],
				$phpraid_config['role2_name']=>$data['role2'],
				$phpraid_config['role3_name']=>$data['role3'],
				$phpraid_config['role4_name']=>$data['role4'],
				$phpraid_config['role5_name']=>$data['role5'],
				$phpraid_config['role6_name']=>$data['role6'],
				'Locked'=>$data['locked'],
				'Buttons'=>$edit . $delete,
			)
		);
	}

	/**************************************************************
	 * Code to setup for a Dynamic Table Create: guild1 View.
	 **************************************************************/
	$viewName = 'location1';
	
	//Setup Columns
	$loc_headers = array();
	$record_count_array = array();
	$loc_headers = getVisibleColumns($viewName);

	//Get Record Counts
	$loc_record_count_array = getRecordCounts($loc, $loc_headers, $startRecord);
	
	//Get the Jump Menu and pass it down
	$locJumpMenu = getPageNavigation($loc, $startRecord, $pageURL, $sortField, $sortDesc);

	//Setup Data
	$loc = paginateSortAndFormat($loc, $sortField, $sortDesc, $startRecord, $viewName);

	/****************************************************************
	 * Data Assign for Template.
	 ****************************************************************/
	$wrmsmarty->assign('loc_data', $loc); 
	$wrmsmarty->assign('loc_jump_menu', $locJumpMenu);
	$wrmsmarty->assign('column_name', $loc_headers);
	$wrmsmarty->assign('loc_record_counts', $loc_record_count_array);
	$wrmsmarty->assign('header_data',
		array(
			'template_name'=>$phpraid_config['template'],
			'header' => $phprlang['locations_header'],
			'sort_url_base' => $pageURL,
			'sort_descending' => $sortDesc,
			'sort_text' => $phprlang['sort_text'],
		)
	);
}
elseif($_GET['mode'] == 'new' || $_GET['mode'] == 'edit')
{
	// form submitted, check for errors
	// assume no errors
	$form_error = 0;

	// slashes
	$name =scrub_input($_POST['name']);
	$loc = scrub_input($_GET['location']);
	$eventtype = scrub_input($_GET['event_type']);
	$event_id = scrub_input($_GET['event']);
	$min_lvl = scrub_input($_POST['min_lvl']);
	$max_lvl = scrub_input($_POST['max_lvl']);
	$dk = scrub_input($_POST['dk']);
	$dr = scrub_input($_POST['dr']);
	$hu = scrub_input($_POST['hu']);
	$ma = scrub_input($_POST['ma']);
	$pa = scrub_input($_POST['pa']);
	$pr = scrub_input($_POST['pr']);
	$ro = scrub_input($_POST['ro']);
	$sh = scrub_input($_POST['sh']);
	$wk = scrub_input($_POST['wk']);
	$wa = scrub_input($_POST['wa']);
 	$role1 = scrub_input($_POST['role1']);
	if ($role1 == '')
		$role1 = '0';
	$role2 = scrub_input($_POST['role2']);
	if ($role2 == '')
		$role2 = '0';
	$role3 = scrub_input($_POST['role3']);
	if ($role3 == '')
		$role3 = '0';
	$role4 = scrub_input($_POST['role4']);
	if ($role4 == '')
		$role4 = '0';
	$role5 = scrub_input($_POST['role5']);
	if ($role5 == '')
		$role5 = '0';
	$role6 = scrub_input($_POST['role6']);
	if ($role6 == '')
		$role6 = '0';
 
 	if(isset($_POST['lock_template']))
 		$locked = 1;
 	else
 		$locked = 0;
	$max = scrub_input($_POST['max']);

	if($_GET['mode'] == 'new')
	{
		$sql = sprintf("INSERT INTO " . $phpraid_config['db_prefix'] . "locations (`location`,`min_lvl`,`max_lvl`,
		`name`,`dk`,`dr`,`hu`,`ma`,`pa`,`pr`,`ro`,`sh`,`wk`,`wa`,`role1`,`role2`,`role3`,`role4`,`role5`,`role6`,`max`,`locked`,`event_type`,`event_id`) VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)",
		quote_smart($loc),quote_smart($min_lvl),quote_smart($max_lvl),quote_smart($name),quote_smart($dk),quote_smart($dr),quote_smart($hu),
		quote_smart($ma),quote_smart($pa),quote_smart($pr),quote_smart($ro),quote_smart($sh),quote_smart($wk),quote_smart($wa),
		quote_smart($role1),quote_smart($role2),quote_smart($role3),quote_smart($role4),quote_smart($role5),quote_smart($role6),
		quote_smart($max),quote_smart($locked),quote_smart($eventtype),quote_smart($event_id));
		
		$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);

		log_create('location',mysql_insert_id(),$name);
	}
	elseif($_GET['mode'] == 'edit');
	{
		if(isset($_GET['id']))
			$id = scrub_input($_GET['id']);
		else
			$id = '';

		$sql = sprintf("UPDATE " . $phpraid_config['db_prefix'] . "locations SET name=%s,max=%s,dk=%s,dr=%s,hu=%s,ma=%s,pa=%s,pr=%s,ro=%s,sh=%s,wk=%s,
		wa=%s,role1=%s,role2=%s,role3=%s,role4=%s,role5=%s,role6=%s,min_lvl=%s,max_lvl=%s,location=%s,locked=%s,event_type=%s,event_id=%s WHERE location_id=%s",quote_smart($name),quote_smart($max),
		quote_smart($dk),quote_smart($dr),quote_smart($hu),quote_smart($ma),quote_smart($pa),quote_smart($pr),quote_smart($ro),quote_smart($sh),quote_smart($wk),quote_smart($wa),
		quote_smart($role1),quote_smart($role2),quote_smart($role3),quote_smart($role4),quote_smart($role5),quote_smart($role6),quote_smart($min_lvl),
		quote_smart($max_lvl),quote_smart($loc),quote_smart($locked),quote_smart($eventtype),quote_smart($event_id),quote_smart($id));

		$db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
	}

	header("Location: locations.php?mode=view");
}
elseif($_GET['mode'] == 'delete')
{
	$id = scrub_input($_GET['id']);
	$n = scrub_input($_GET['n']);

	if($_SESSION['priv_locations'] == 1) {
		if(!isset($_POST['submit'])) {
			$form_action = 'locations.php?mode=delete&amp;n='.$n.'&amp;id=' . $id;
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
			log_delete('location',$n);

			$sql = sprintf("DELETE FROM " . $phpraid_config['db_prefix'] . "locations WHERE location_id=%s",quote_smart($id));
			$db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);

			header("Location: locations.php?mode=view");
		}
	} else {
		if($_SESSION['priv_locations'] == 1)
			header("Location: locations.php?mode=view");
		else
			header("Location: index.php");
	}
}

if($_GET['mode'] != 'delete')
{
	if (isset($_GET['id'])) // Update
	{
		$id = scrub_input($_GET['id']);
		
		$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "locations WHERE location_id=%s",quote_smart($id));
		$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
		$data = $db_raid->sql_fetchrow($result, true);

		isset($_GET['event_type']) ? $event_type_id = scrub_input($_GET['event_type']) : $event_type_id = $data['event_type'];
		isset($_GET['event']) ? $event_id = scrub_input($_GET['event']) : $event_id = $data['event_id'];		
		
		$sql = "SELECT exp_id FROM " . $phpraid_config['db_prefix'] . "events WHERE event_id = " . $data['event_id'];
		$result2 = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
		$event_data = $db_raid->sql_fetchrow($result2, true);		
		
		isset($_GET['exp_id']) ? $expansion_id = scrub_input($_GET['exp_id']) : $expansion_id = $event_data['exp_id'];		
	}
	else // Insert
	{
		// Get Default Values for Expansion
		$sql = "SELECT exp_id FROM " . $phpraid_config['db_prefix'] . "expansion WHERE def = 1";
		$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
		$data = $db_raid->sql_fetchrow($result, true);
		isset($_GET['exp_id']) ? $expansion_id = scrub_input($_GET['exp_id']) : $expansion_id = $data['exp_id'];
		// Get Default Values for Event Type
		$sql = "SELECT event_type_id FROM " . $phpraid_config['db_prefix'] . "event_type WHERE def = 1";
		$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
		$data = $db_raid->sql_fetchrow($result, true);
		isset($_GET['event_type']) ? $event_type_id = scrub_input($_GET['event_type']) : $event_type_id = $data['event_type_id'];
		// Get Default Values for Event
		$event_id = $_GET['event'];		
	}
	
	if($_GET['mode'] == 'view')
	{
		// setup new form information
		// Setup Event Type Select Box.
		$eventtype = '<select name="event_type" id="event_type" class="post" onChange="MM_jumpMenu(\'parent\',this,0)">
					<option value=""></option>';

		$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "event_type";
		$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
		while($data = $db_raid->sql_fetchrow($result, true))
		{		
			// Event Type for WoW Calendar
			if ($event_type_id != '' && $data['event_type_id'] == $event_type_id)
				$eventtype .= '<option value="locations.php?mode=view&amp;event_type='.$data['event_type_id'].'" selected>' . $phprlang[$data['event_type_lang_id']] . '</option>';
			elseif ($event_type_id == '' && $data['event_type_id'] == 1)
				$eventtype .= '<option value="locations.php?mode=view&amp;event_type='.$data['event_type_id'].'" selected>' . $phprlang[$data['event_type_lang_id']] . '</option>';
			else
				$eventtype .= '<option value="locations.php?mode=view&amp;event_type='.$data['event_type_id'].'">' . $phprlang[$data['event_type_lang_id']] . '</option>';
		}
		$eventtype .= '</select>';		
		// End Event Type Setup

		// Setup Expansion Select Box.
		$expansion = '<select name="expansion" id="expansion" class="post" onChange="MM_jumpMenu(\'parent\',this,0)">
					<option value=""></option>';
		
		$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "expansion";
		$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
		while($data = $db_raid->sql_fetchrow($result, true))
		{		
			// Event Type for WoW Calendar
			if ($expansion_id != '' && $data['exp_id'] == $expansion_id)
				$expansion .= '<option value="locations.php?mode=view&amp;exp_id='.$data['exp_id'].'&amp;event_type='.$event_type_id.'" selected>' . $phprlang[$data['exp_lang_id']] . '</option>';
			elseif ($expansion_id == '' && $data['exp_id'] == $db_raid->sql_numrows($result))
				$expansion .= '<option value="locations.php?mode=view&amp;exp_id='.$data['exp_id'].'&amp;event_type='.$event_type_id.'" selected>' . $phprlang[$data['exp_lang_id']] . '</option>';
			else
				$expansion .= '<option value="locations.php?mode=view&amp;exp_id='.$data['exp_id'].'&amp;event_type='.$event_type_id.'">' . $phprlang[$data['exp_lang_id']] . '</option>';
		}
		$expansion .= '</select>';		
		// End Expansion Setup

		// Setup Events Select Box.
		if ($event_type_id != '' && $expansion_id != '')
		{
			$events = '<select name="event" id="event" class="post" onChange="MM_jumpMenu(\'parent\',this,0)">
						<option value=""></option>';
			
			if ($event_type_id == 1 || $event_type_id == 2) // If Dungeons or Raids pull exp_id = 0 also.
				$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "events WHERE (exp_id =" .$expansion_id . " OR exp_id = 0) AND event_type_id =" .$event_type_id. " ORDER BY zone_desc";
			elseif ($event_type_id == 3 || $event_type_id == 4) // If Meeting Type, Pull Major Cities
				$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "events WHERE event_type_id =" .$event_type_id. " ORDER BY zone_desc";
			elseif ($event_type_id == 5) // Other Type, Pull Everything
				$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "events WHERE (exp_id =" .$expansion_id . " OR exp_id = 0) ORDER BY zone_desc";	
			else // By default pull Raids and Dungeons
				$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "events WHERE (exp_id =" .$expansion_id . " OR exp_id = 0) AND event_type_id =" .$event_type_id. " ORDER BY zone_desc";
			
			$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
			while($data = $db_raid->sql_fetchrow($result, true))
			{		
				// Event Type for WoW Calendar
				if ($event_id != '' && $data['event_id'] == $event_id)
					$events .= '<option value="locations.php?mode=view&amp;exp_id='.$expansion_id.'&amp;event_type='.$event_type_id.'&amp;event='.$data['event_id'].'" selected>' . $data['zone_desc'] . '</option>';
				else
					$events .= '<option value="locations.php?mode=view&amp;exp_id='.$expansion_id.'&amp;event_type='.$event_type_id.'&amp;event='.$data['event_id'].'">' . $data['zone_desc'] . '</option>';
			}
			$events .= '</select>';		
			// End Event Type Setup
		}
		else
		{
			$events = '<select name="events" DISABLED><option></option></select>';
		}
		
		$name = '<input name="name" type="text" id="name" class="post">';
		$min_lvl = '<input name="min_lvl" type="text" class="post" style="width:20px" maxlength="2">';
		$max_lvl = '<input name="max_lvl" type="text" class="post" style="width:20px" maxlength="2">';
		$dk = '<input name="dk" type="text" class="post" style="width:20px" maxlength="2">';
		$dr = '<input name="dr" type="text" class="post" style="width:20px" maxlength="2">';
		$hu = '<input name="hu" type="text" class="post" style="width:20px" maxlength="2">';
		$ma = '<input name="ma" type="text" class="post" style="width:20px" maxlength="2">';
		$pa = '<input name="pa" type="text" class="post" style="width:20px" maxlength="2">';
		$pr = '<input name="pr" type="text" class="post" style="width:20px" maxlength="2">';
		$ro = '<input name="ro" type="text" class="post" style="width:20px" maxlength="2">';
		$sh = '<input name="sh" type="text" class="post" style="width:20px" maxlength="2">';
		$wk = '<input name="wk" type="text" class="post" style="width:20px" maxlength="2">';
		$wa = '<input name="wa" type="text" class="post" style="width:20px" maxlength="2">';
		if ($phpraid_config['role1_name'] != '')
			$role1 = '<input name="role1" type="text" class="post" style="width:20px" maxlength="2">';
		else
			$role1 = '<input name="role1" type="hidden" value="" class="post" style="width:20px" maxlength="2">';
		if ($phpraid_config['role2_name'] != '')
			$role2 = '<input name="role2" type="text" class="post" style="width:20px" maxlength="2">';
		else
			$role2 = '<input name="role2" type="hidden" value="" class="post" style="width:20px" maxlength="2">';
		if ($phpraid_config['role3_name'] != '')
			$role3 = '<input name="role3" type="text" class="post" style="width:20px" maxlength="2">';
		else
			$role3 = '<input name="role3" type="hidden" value="" class="post" style="width:20px" maxlength="2">';
		if ($phpraid_config['role4_name'] != '')
			$role4 = '<input name="role4" type="text" class="post" style="width:20px" maxlength="2">';
		else
			$role4 = '<input name="role4" type="hidden" value="" class="post" style="width:20px" maxlength="2">';
		if ($phpraid_config['role5_name'] != '')
			$role5 = '<input name="role5" type="text" class="post" style="width:20px" maxlength="2">';
		else
			$role5 = '<input name="role5" type="hidden" value="" class="post" style="width:20px" maxlength="2">';
		if ($phpraid_config['role6_name'] != '')
			$role6 = '<input name="role6" type="text" class="post" style="width:20px" maxlength="2">';
		else
			$role6 = '<input name="role6" type="hidden" value="" class="post" style="width:20px" maxlength="2">';
		$locked = '<input name="lock_template" type="checkbox" value="1" class="post">';
		
		if ($event_id != '')
		{
			$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "events WHERE event_id =" . $event_id;
			$result2 = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
			$event_data = $db_raid->sql_fetchrow($result2, true);
			$event_max = $event_data['max'];
			$wow_name = $event_data['wow_name'];
			$zone_desc = $event_data['zone_desc'];
			$max = '<input name="max" value="' .$event_max. '" type="text" class="post" style="width:20px" maxlength="2">';
			$location = '<input name="location" value="'.$wow_name.'" type="text" id="location" style="width:350px" class="post" DISABLED>';
			$icon = "templates/" . $phpraid_config['template'] . "/" . $event_data['icon_path'];
			$form_action = 'locations.php?mode=new&amp;event_type='.$event_type_id.'&amp;event='.$event_id.'&amp;location='.$zone_desc;
		}
		else
		{
			$max = '<input name="max" type="text" class="post" style="width:20px" maxlength="2">';
			$location = '<input name="location" valuetype="text" id="location" style="width:350px" class="post" DISABLED>';
			$icon = "";
			$form_action = 'locations.php?mode=view';
		}
			
		$buttons = '<input type="submit" value="'.$phprlang['submit'].'" name="submit" class="mainoption"> <input type="reset" value="'.$phprlang['reset'].'" name="reset" class="liteoption">';
	}
	elseif($_GET['mode'] == 'update')
	{
		// it's an edit... joy
		
		// Setup Event Type Select Box.
		$eventtype = '<select name="event_type" id="event_type" class="post" onChange="MM_jumpMenu(\'parent\',this,0)">
					<option value=""></option>';

		$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "event_type";
		$result2 = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
		while($event_type_data = $db_raid->sql_fetchrow($result2, true))
		{		
			// Event Type for WoW Calendar
			if ($event_type_data['event_type_id'] == $event_type_id)
				$eventtype .= '<option value="locations.php?mode=update&amp;id='.$id.'&amp;event_type='.$event_type_data['event_type_id'].'" selected>' . $phprlang[$event_type_data['event_type_lang_id']] . '</option>';
			else
				$eventtype .= '<option value="locations.php?mode=update&amp;id='.$id.'&amp;event_type='.$event_type_data['event_type_id'].'">' . $phprlang[$event_type_data['event_type_lang_id']] . '</option>';
		}
		$eventtype .= '</select>';		
		// End Event Type Setup
		
		// Setup Expansion Select Box.
		$sql = "SELECT exp_id FROM " . $phpraid_config['db_prefix'] . "events WHERE event_id = " . $event_id;
		$result2 = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
		$event_data = $db_raid->sql_fetchrow($result2, true);
		$expansion = '<select name="expansion" id="expansion" class="post" onChange="MM_jumpMenu(\'parent\',this,0)">
					<option value=""></option>';
		
		$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "expansion";
		$result2 = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
		while($expansion_data = $db_raid->sql_fetchrow($result2, true))
		{		
			// Event Type for WoW Calendar
			if ($expansion_data['exp_id'] == $expansion_id)
				$expansion .= '<option value="locations.php?mode=update&amp;id='.$id.'&amp;exp_id='.$expansion_data['exp_id'].'&amp;event_type='.$event_type_id.'" selected>' . $phprlang[$expansion_data['exp_lang_id']] . '</option>';
			else
				$expansion .= '<option value="locations.php?mode=update&amp;id='.$id.'&amp;exp_id='.$expansion_data['exp_id'].'&amp;event_type='.$event_type_id.'">' . $phprlang[$expansion_data['exp_lang_id']] . '</option>';
		}
		$expansion .= '</select>';		
		// End Expansion Setup

		// Setup Events Select Box.
		$events = '<select name="event" id="event" class="post" onChange="MM_jumpMenu(\'parent\',this,0)">
					<option value=""></option>';

		if ($event_type_id == 1 || $event_type_id == 2) // If Dungeons or Raids pull exp_id = 0 also.
			$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "events WHERE (exp_id =" .$expansion_id . " OR exp_id = 0) AND event_type_id =" .$event_type_id. " ORDER BY zone_desc";
		elseif ($event_type_id == 3 || $event_type_id == 4) // If Meeting Type, Pull Major Cities
			$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "events WHERE event_type_id =" .$event_type_id. " ORDER BY zone_desc";
		elseif ($event_type_id == 5) // Other Type, Pull Everything
			$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "events WHERE (exp_id =" .$expansion_id . " OR exp_id = 0) ORDER BY zone_desc";	
		else // By default pull Raids and Dungeons
			$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "events WHERE (exp_id =" .$expansion_id . " OR exp_id = 0) AND event_type_id =" .$event_type_id. " ORDER BY zone_desc";
			
		$result2 = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
		while($event_data = $db_raid->sql_fetchrow($result2, true))
		{		
			// Event Type for WoW Calendar
			if ($event_data['event_id'] == $event_id)
				$events .= '<option value="locations.php?mode=update&amp;id='.$id.'&amp;exp_id='.$expansion_id.'&amp;event_type='.$event_type_id.'&amp;event='.$event_data['event_id'].'" selected>' . $event_data['zone_desc'] . '</option>';
			else
				$events .= '<option value="locations.php?mode=update&amp;id='.$id.'&amp;exp_id='.$expansion_id.'&amp;event_type='.$event_type_id.'&amp;event='.$event_data['event_id'].'">' . $event_data['zone_desc'] . '</option>';
		}
		$events .= '</select>';		
		// End Event Setup
		
		$name = '<input name="name" type="text" id="name" value="' . $data['name'] . '" class="post">';
		$min_lvl = '<input name="min_lvl" type="text" value="' . $data['min_lvl'] . '"  class="post" style="width:20px" maxlength="2">';
		$max_lvl = '<input name="max_lvl" type="text" value="' . $data['max_lvl'] . '"  class="post" style="width:20px" maxlength="2">';
		$dk = '<input name="dk" type="text" value="' . $data['dk'] . '"  class="post" style="width:20px" maxlength="2">';
		$dr = '<input name="dr" type="text" value="' . $data['dr'] . '"  class="post" style="width:20px" maxlength="2">';
		$hu = '<input name="hu" type="text" value="' . $data['hu'] . '"  class="post" style="width:20px" maxlength="2">';
		$ma = '<input name="ma" type="text" value="' . $data['ma'] . '"  class="post" style="width:20px" maxlength="2">';
		$pa = '<input name="pa" type="text" value="' . $data['pa'] . '"  class="post" style="width:20px" maxlength="2">';
		$pr = '<input name="pr" type="text" value="' . $data['pr'] . '"  class="post" style="width:20px" maxlength="2">';
		$ro = '<input name="ro" type="text" value="' . $data['ro'] . '"  class="post" style="width:20px" maxlength="2">';
		$sh = '<input name="sh" type="text" value="' . $data['sh'] . '"  class="post" style="width:20px" maxlength="2">';
		$wk = '<input name="wk" type="text" value="' . $data['wk'] . '"  class="post" style="width:20px" maxlength="2">';
		$wa = '<input name="wa" type="text" value="' . $data['wa'] . '"  class="post" style="width:20px" maxlength="2">';
		if ($phpraid_config['role1_name'] != '')
			$role1 = '<input name="role1" type="text" value="' . $data['role1'] . '"  class="post" style="width:20px" maxlength="2">';
		else
			$role1 = '<input name="role1" type="hidden" value="" class="post" style="width:20px" maxlength="2">';
		if ($phpraid_config['role2_name'] != '')
			$role2 = '<input name="role2" type="text" value="' . $data['role2'] . '"  class="post" style="width:20px" maxlength="2">';
		else
			$role2 = '<input name="role2" type="hidden" value="" class="post" style="width:20px" maxlength="2">';
		if ($phpraid_config['role3_name'] != '')
			$role3 = '<input name="role3" type="text" value="' . $data['role3'] . '"  class="post" style="width:20px" maxlength="2">';
		else
			$role3 = '<input name="role3" type="hidden" value="" class="post" style="width:20px" maxlength="2">';
		if ($phpraid_config['role4_name'] != '')
			$role4 = '<input name="role4" type="text" value="' . $data['role4'] . '"  class="post" style="width:20px" maxlength="2">';
		else
			$role4 = '<input name="role4" type="hidden" value="" class="post" style="width:20px" maxlength="2">';
		if ($phpraid_config['role5_name'] != '')
			$role5 = '<input name="role5" type="text" value="' . $data['role5'] . '"  class="post" style="width:20px" maxlength="2">';
		else
			$role5 = '<input name="role5" type="hidden" value="" class="post" style="width:20px" maxlength="2">';
		if ($phpraid_config['role6_name'] != '')
			$role6 = '<input name="role6" type="text" value="' . $data['role6'] . '"  class="post" style="width:20px" maxlength="2">';
		else
			$role6 = '<input name="role6" type="hidden" value="" class="post" style="width:20px" maxlength="2">';
		if($data['locked'] == '0')
			$locked = '<input type="checkbox" name="lock_template" value="' . $data['locked'] . '"  class="post">';
		else
			$locked = '<input type="checkbox" name="lock_template" value="' . $data['locked'] . '"  class="post" checked>';
		$max = '<input name="max" type="text" value="' . $data['max'] . '"  class="post" style="width:20px" maxlength="2">';
		$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "events WHERE event_id =" . $event_id;
		$result2 = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
		$event_data = $db_raid->sql_fetchrow($result2, true);
		$event_max = $event_data['max'];
		$wow_name = $event_data['wow_name'];
		$zone_desc = $event_data['zone_desc'];
		$location = '<input name="location" value="'.$wow_name.'" type="text" id="location" style="width:350px" class="post" DISABLED>';
		$icon = "templates/" . $phpraid_config['template'] . "/" . $event_data['icon_path'];
		$form_action = 'locations.php?mode=edit&amp;id='.$id.'&amp;event_type='.$event_type_id.'&amp;event='.$event_id.'&amp;location='.$zone_desc;
		
		$buttons = '<input type="submit" value="'.$phprlang['update'].'" name="submit" class="mainoption"> <input type="reset" value="'.$phprlang['reset'].'" name="reset" class="liteoption">';
	}

	$wrmsmarty->assign('locations_new',
		array(
			'form_action'=>$form_action,
			'event_type'=>$eventtype,
			'expansion'=>$expansion,
			'icon'=>$icon,
			'event'=>$events,
			'eventtype_text'=>$phprlang['raids_eventtype_text'],
			'expansion_text'=>$phprlang['locations_expansion_text'],
			'event_text'=>$phprlang['locations_events_text'],
			'name'=>$name,
			'location'=>$location,
			'location_read_only_text'=>$phprlang['locations_ro_text'],
			'min_lvl'=>$min_lvl,
			'max_lvl'=>$max_lvl,
			'dk'=>$dk,
			'dr'=>$dr,
			'hu'=>$hu,
			'ma'=>$ma,
			'pa'=>$pa,
			'pr'=>$pr,
			'ro'=>$ro,
			'sh'=>$sh,
			'wk'=>$wk,
			'wa'=>$wa,
			'role1'=>$role1,
			'role2'=>$role2,
			'role3'=>$role3,
			'role4'=>$role4,
			'role5'=>$role5,
			'role6'=>$role6,
			'max'=>$max,
			'locked'=>$locked,
			'buttons'=>$buttons,
			'deathknight_name'=>$phprlang['deathknight'],
			'druid_name'=>$phprlang['druid'],
			'hunter_name'=>$phprlang['hunter'],
			'mage_name'=>$phprlang['mage'],
			'paladin_name'=>$phprlang['paladin'],
			'priest_name'=>$phprlang['priest'],
			'rogue_name'=>$phprlang['rogue'],
			'shaman_name'=>$phprlang['shaman'],
			'warlock_name'=>$phprlang['warlock'],
			'warrior_name'=>$phprlang['warrior'],
			'role1_name'=>$phpraid_config['role1_name'],
			'role2_name'=>$phpraid_config['role2_name'],
			'role3_name'=>$phpraid_config['role3_name'],
			'role4_name'=>$phpraid_config['role4_name'],
			'role5_name'=>$phpraid_config['role5_name'],
			'role6_name'=>$phpraid_config['role6_name'],
			'locked_text'=>$phprlang['lock_template'],
			'newlocation_header'=>$phprlang['locations_new'],
			'shortname_text'=>$phprlang['locations_short'],
			'location_text'=>$phprlang['locations_long'],
			'minlvl_text'=>$phprlang['locations_min_lvl'],
			'maxlvl_text'=>$phprlang['locations_max_lvl'],
			'maxattendees_text'=>$phprlang['locations_raid_max'],
			'limits_header'=>$phprlang['locations_limits_header'],
		)
	);
}

//
// Start output of page
//
if($_GET['mode'] != 'delete')
{
	require_once('includes/page_header.php');
	$wrmsmarty->display('locations.html');
	require_once('includes/page_footer.php');
}
?>