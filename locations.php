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

$page_filename = "locations.php";
$pageURL = $page_filename.'?mode=view&';

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

// show the form
if($_GET['mode'] == 'view')
{
	$loc = array();
	$loc_loop_num = 0;
	$sql = "SELECT * ".
			" FROM " . $phpraid_config['db_prefix'] . "locations".
			" WHERE `gamepack_id` = ".$phpraid_config['gamepack_id'].";";
	$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	while($data = $db_raid->sql_fetchrow($result, true))
	{
		//$edit = '<a href="'.$page_url.'?mode=update&amp;id='.$data['location_id'].'"><img src="templates/' . $phpraid_config['template'] .
				//'/images/icons/icon_edit.gif" border="0" onMouseover="ddrivetip(\'' . $phprlang['edit'] . '\');" onMouseout="hideddrivetip();" alt="edit icon"></a>';
		$url = $page_url.'?mode=update&amp;id='.$data['location_id'];
		$img = '<img src="templates/'.$phpraid_config['template'].'/images/icons/icon_edit.gif" border="0" alt="edit icon" />';
		$edit = cssToolTip($img, $phprlang['edit'], 'smallIconText', $url);

		//$delete = '<a href="'.$page_url.'?mode=delete&amp;n='.$data['name'].'&amp;id='.$data['location_id'].'"><img src="templates/' .
					//$phpraid_config['template'] . '/images/icons/icon_delete.gif" border="0" onMouseover="ddrivetip(\'' . $phprlang['delete'] . '\');" onMouseout="hideddrivetip();" alt="delete icon"></a>';
		$url = $page_url.'?mode=delete&amp;n='.$data['name'].'&amp;id='.$data['location_id'];
		$img = '<img src="templates/'.$phpraid_config['template'].'/images/icons/icon_delete.gif" border="0" alt="edit icon" />';
		$edit = cssToolTip($img, $phprlang['delete'], 'smallIconText', $url);

		$sql = sprintf("SELECT event_type_lang_id ".
						" FROM " . $phpraid_config['db_prefix'] . "event_type ".
						" WHERE event_type_id = %s",
						quote_smart($data['event_type'])
				);
		$result2 = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
		$event_type_data = $db_raid->sql_fetchrow($result2, true);
		$event_type_id = $event_type_data['event_type'];
		$event_type_text = $phprlang[$event_type_data['event_type_lang_id']];
		
		// Now that we have the location data, we need to retrieve limit data based upon location ID.
		// Get Class Limits
		$loc_class_array = array();
		$sql = sprintf("SELECT * ".
						" FROM " . $phpraid_config['db_prefix'] . "loc_class_lmt ".
						" WHERE location_id = %s", 
						quote_smart($data['location_id'])
				);
		$result_loc_class = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
		while($loc_class_data = $db_raid->sql_fetchrow($result_loc_class, true))
		{
			$loc_class_array[$loc_class_data['class_id']] = $loc_class_data['lmt'];
		}
		// Get Role Limits
		$loc_role_array = array();
		$sql = sprintf("SELECT * ".
						" FROM " . $phpraid_config['db_prefix'] . "loc_role_lmt ".
						" WHERE location_id = %s", 
						quote_smart($data['location_id'])
				);
		$result_loc_role = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
		while($loc_role_data = $db_raid->sql_fetchrow($result_loc_role, true))
		{
			$sql2 = sprintf("SELECT role_name ".
							" FROM " . $phpraid_config['db_prefix'] . "roles ".
							" WHERE role_id = %s", 
							quote_smart($loc_role_data['role_id'])
					);
			$result_role_name = $db_raid->sql_query($sql2) or print_error($sql2, $db_raid->sql_error(), 1);
			$role_name = $db_raid->sql_fetchrow($result_role_name, true);
			
			$loc_role_array[$role_name['role_name']] = $loc_role_data['lmt'];
		}
	
		array_push($loc,
			array(
				'ID'=>$data['location_id'],
				'Name'=>$data['name'],
				'Force Name'=>$data['raid_force_name'],
				'Event Type'=>$event_type_text,
				'Dungeon'=>$data['location'],
				'Min Level'=>$data['min_lvl'],
				'Max Level'=>$data['max_lvl'],
				'Raid Max'=>$data['max'],
				'Locked'=>$data['locked'],
				'Buttons'=>$edit . $delete,
			)
		);
		foreach ($loc_class_array as $left => $right)
		{
			$loc[$loc_loop_num][$left]= $right;
		}
		foreach ($loc_role_array as $left => $right)
		{
			$loc[$loc_loop_num][$left]= $right;
		}
		$loc_loop_num++;
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
			
	//Setup Default Data Sort from Headers Table
	if (!$initSort)
		foreach ($loc_headers as $column_rec)
			if ($column_rec['default_sort'])
				$sortField = $column_rec['column_name'];

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
			'gamepack_name' => $phpraid_config['gamepack_name'],				
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
	$location_shortname =scrub_input($_POST['name']);
	$loc = scrub_input($_GET['location']);
	$eventtype = scrub_input($_GET['event_type']);
	$event_id = scrub_input($_GET['event']);
	$location_min_lvl = scrub_input($_POST['location_min_lvl']);
	$location_max_lvl = scrub_input($_POST['location_max_lvl']);
	$raid_force_name = scrub_input($_POST['raid_force_name']);
	
	// Handle Classes
	foreach ($wrm_global_classes as $global_class)
	{
		$classtrans = str_replace(" ", "_", $global_class['class_id']);
		$class[$global_class['class_id']] = scrub_input($_POST[$classtrans]);
	}
	
	// Handle Roles
	foreach ($wrm_global_roles as $global_role)	
	{
		$role[$global_role['role_id']] = scrub_input($_POST[$global_role['role_id']]);
		if ($role[$global_role['role_id']] == '')
			$role[$global_role['role_id']] == '0'; 
	}
 
 	if(isset($_POST['lock_template']))
 		$locked = 1;
 	else
 		$locked = 0;
 	
	$number_max_chars = scrub_input($_POST['number_max_chars']);

	if($_GET['mode'] == 'new')
	{
		$sql = sprintf(	"INSERT INTO " . $phpraid_config['db_prefix'] . "locations".
						" (`location`,`min_lvl`,`max_lvl`,`name`,`max`,`locked`,`event_type`,`event_id`,`raid_force_name`)".
						" VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s)",
		quote_smart($loc),quote_smart($location_min_lvl),quote_smart($location_max_lvl),quote_smart($location_shortname),
		quote_smart($number_max_chars),quote_smart($locked),quote_smart($eventtype),quote_smart($event_id),quote_smart($raid_force_name));
		
		$db_raid->sql_query($sql) or print_error($sql,$db_raid->sql_error(),1);

		// Get the Location ID of what was Just Entered to Apply to the Lookup Tables
		$sql = "SELECT location_id ".
				" FROM " . $phpraid_config['db_prefix'] . "locations ".
				" ORDER BY location_id ".
				" DESC LIMIT 1";
		$loc_id_result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
		$loc_id = $db_raid->sql_fetchrow($loc_id_result, true);
		
		// Insert Class Data to loc_class_lmt
		foreach ($wrm_global_classes as $global_class)
		{
			$sql = sprintf("INSERT INTO " . $phpraid_config['db_prefix'] . "loc_class_lmt (`location_id`, `class_id`, `lmt`)
			VALUES (%s,%s,%s)",quote_smart($loc_id['location_id']), quote_smart($global_class['class_id']), quote_smart($class[$global_class['class_id']]));
			
			$db_raid->sql_query($sql) or print_error($sql,$db_raid->sql_error(),1);
		}
		
		// Insert Role Data to loc_role_lmt
		foreach ($wrm_global_roles as $global_role)	
		{
			if ($global_role['role_name'] != '')
			{
				$sql = sprintf("INSERT INTO " . $phpraid_config['db_prefix'] . "loc_role_lmt (`location_id`, `role_id`, `lmt`)
								VALUES (%s,%s,%s)",quote_smart($loc_id['location_id']), quote_smart($global_role['role_id']), 
								quote_smart($role[$global_role['role_id']]));
			
				$db_raid->sql_query($sql) or print_error($sql,$db_raid->sql_error(),1);
			}	
		}
		
		log_create('location',mysql_insert_id(),$location_shortname);
	}
	elseif($_GET['mode'] == 'edit');
	{
		if(isset($_GET['id']))
			$id = scrub_input($_GET['id']);
		else
			$id = '';

		$sql = sprintf(	"UPDATE " . $phpraid_config['db_prefix'] . "locations ".
						"	SET name=%s,max=%s, min_lvl=%s,max_lvl=%s,location=%s,".
						"	locked=%s,event_type=%s,event_id=%s,raid_force_name=%s ".
						"	WHERE location_id=%s",
		quote_smart($location_shortname),quote_smart($number_max_chars),quote_smart($location_min_lvl),quote_smart($location_max_lvl),
		quote_smart($loc),quote_smart($locked),quote_smart($eventtype),quote_smart($event_id),
		quote_smart($raid_force_name),quote_smart($id));

		$db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);

		// Insert Class Data to loc_class_lmt
		foreach ($wrm_global_classes as $global_class)
		{
			$sql = sprintf("UPDATE " . $phpraid_config['db_prefix'] . "loc_class_lmt SET lmt=%s WHERE location_id=%s AND class_id=%s",
			quote_smart($class[$global_class['class_id']]), quote_smart($id), quote_smart($global_class['class_id']));
			
			$db_raid->sql_query($sql) or print_error($sql,$db_raid->sql_error(),1);
		}
		
		// Insert Role Data to loc_role_lmt
		foreach ($wrm_global_roles as $global_role)	
		{
			$sql = sprintf("UPDATE " . $phpraid_config['db_prefix'] . "loc_role_lmt SET lmt=%s WHERE location_id=%s AND role_id=%s",
			quote_smart($role[$global_role['role_id']]), quote_smart($id), quote_smart($global_role['role_id']));
			
			$db_raid->sql_query($sql) or print_error($sql,$db_raid->sql_error(),1);	
		}
	}

	header("Location: ".$pageURL);
}
elseif($_GET['mode'] == 'delete')
{
	$id = scrub_input($_GET['id']);
	$n = scrub_input($_GET['n']);

	if($_SESSION['priv_locations'] == 1) {
		if(!isset($_POST['submit'])) {
			$form_action = $page_url.'?mode=delete&amp;n='.$n.'&amp;id=' . $id;
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
			$db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
			$sql = sprintf("DELETE FROM " . $phpraid_config['db_prefix'] . "loc_class_lmt WHERE location_id=%s",quote_smart($id));
			$db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
			$sql = sprintf("DELETE FROM " . $phpraid_config['db_prefix'] . "loc_role_lmt WHERE location_id=%s",quote_smart($id));
			$db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
			
			header("Location: " . $pageURL);
		}
	} else {
		if($_SESSION['priv_locations'] == 1)
			header("Location: " . $pageURL);
		else
			header("Location: index.php");
	}
}

if($_GET['mode'] != 'delete')
{
	if (isset($_GET['id'])) // Update
	{
		$id = scrub_input($_GET['id']);
		
		$sql = sprintf("SELECT event_id, event_type ".
						" FROM " . $phpraid_config['db_prefix'] . "locations ".
						" WHERE location_id = %s",
						quote_smart($id)
				);
		$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
		$data = $db_raid->sql_fetchrow($result, true);

		isset($_GET['event_type']) ? $event_type_id = scrub_input($_GET['event_type']) : $event_type_id = $data['event_type'];
		isset($_GET['event']) ? $event_id = scrub_input($_GET['event']) : $event_id = $data['event_id'];		
		
		$sql = sprintf("SELECT exp_id ".
						" FROM " . $phpraid_config['db_prefix'] . "events ".
						" WHERE event_id = %s", 
						quote_smart($data['event_id'])
				);
		$result2 = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
		$event_data = $db_raid->sql_fetchrow($result2, true);		
		
		isset($_GET['exp_id']) ? $expansion_id = scrub_input($_GET['exp_id']) : $expansion_id = $event_data['exp_id'];		
	}
	else // Insert
	{
		// Get Default Values for Expansion
		$sql = "SELECT exp_id ".
				" FROM " . $phpraid_config['db_prefix'] . "expansion ".
				" WHERE def = 1";
		$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
		$data = $db_raid->sql_fetchrow($result, true);
		isset($_GET['exp_id']) ? $expansion_id = scrub_input($_GET['exp_id']) : $expansion_id = $data['exp_id'];
		// Get Default Values for Event Type
		$sql = "SELECT event_type_id ".
				" FROM " . $phpraid_config['db_prefix'] . "event_type ".
				" WHERE def = 1";
		$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
		$data = $db_raid->sql_fetchrow($result, true);
		isset($_GET['event_type']) ? $event_type_id = scrub_input($_GET['event_type']) : $event_type_id = $data['event_type_id'];
		// Get Default Values for Event
		$event_id = $_GET['event'];		
	}
	
	$array_event_type = array();
	$array_expansion = array();
	$array_raid_force = array();
	
	if($_GET['mode'] == 'view')
	{

		// setup new form information
		// Setup Event Type Select Box.
		$sql = "SELECT * ".
				" FROM " . $phpraid_config['db_prefix'] . "event_type".
				" WHERE `gamepack_id` = ".$phpraid_config['gamepack_id'].";";
		$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
		while($data = $db_raid->sql_fetchrow($result, true))
		{	
			$array_event_type[$page_url.'?mode=view&amp;event_type='.$data['event_type_id']] = $phprlang[$data['event_type_lang_id']];
			// Event Type for WoW Calendar
			if  ( ($event_type_id != '' && $data['event_type_id'] == $event_type_id) or
				  ($event_type_id == '' && $data['event_type_id'] == 1)
				)
				$selected_event_type = $page_url.'?mode=view&amp;event_type='.$data['event_type_id'];
		}
		// End Event Type Setup

		// Setup Expansion Select Box.
		$sql = "SELECT * ".
				" FROM " . $phpraid_config['db_prefix'] . "expansion".
				" WHERE `gamepack_id` = ".$phpraid_config['gamepack_id'].";";
		$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
		while($data = $db_raid->sql_fetchrow($result, true))
		{
			$tmp_link = $page_url.'?mode=view&amp;exp_id='.$data['exp_id'].'&amp;event_type='.$event_type_id;
			$array_expansion[$tmp_link] = $phprlang[$data['exp_lang_id']];

			if (!isset($_GET['exp_id']) and ($data['exp_id'] == $phpraid_config['wrm_expansion']))
			{
				$selected_expansion = $tmp_link;
			}
			elseif($_GET['exp_id'] == $data['exp_id'])
			{
				$selected_expansion = $tmp_link;
			}
		}
		// End Expansion Setup

		// Setup Events Select Box.
		if ($event_type_id != '' && $expansion_id != '')
		{
			$events = '<select name="event" id="event" class="post" onChange="MM_jumpMenu(\'self\',this,0)">
						<option value="'.$page_url.'?mode=view"></option>';
			
			if ($event_type_id == 1 || $event_type_id == 2) // If Dungeons or Raids pull exp_id = 0 also.
				$sql = sprintf("SELECT * ".
								"FROM " . $phpraid_config['db_prefix'] . "events ".
								" WHERE (exp_id = %s OR exp_id = 0) ".
								" AND event_type_id = %s ORDER BY zone_desc", 
								quote_smart($expansion_id), quote_smart($event_type_id)
						);
			elseif ($event_type_id == 3 || $event_type_id == 4) // If Meeting Type, Pull Major Cities
				$sql = sprintf("SELECT * ".
								" FROM " . $phpraid_config['db_prefix'] . "events ".
								" WHERE event_type_id = %s ORDER BY zone_desc", 
								quote_smart($event_type_id)
						);
			elseif ($event_type_id == 5) // Other Type, Pull Everything
				$sql = sprintf("SELECT * ".
								" FROM " . $phpraid_config['db_prefix'] . "events ".
								" WHERE (exp_id = %s OR exp_id = 0) ORDER BY zone_desc", 
								quote_smart($expansion_id)
						);	
			else // By default pull Raids and Dungeons
				$sql = sprintf("SELECT * ". 
								" FROM " . $phpraid_config['db_prefix'] . "events ".
								" WHERE (exp_id = %s OR exp_id = 0) ".
								" AND event_type_id = %s ORDER BY zone_desc", 
								quote_smart($expansion_id), quote_smart($event_type_id)
						);
			
			$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
			while($data = $db_raid->sql_fetchrow($result, true))
			{		
				// Event Type for WoW Calendar
				if ($event_id != '' && $data['event_id'] == $event_id)
					$events .= '<option value="'.$page_url.'?mode=view&amp;exp_id='.$expansion_id.'&amp;event_type='.$event_type_id.'&amp;event='.$data['event_id'].'" selected>' . $data['zone_desc'] . '</option>';
				else
					$events .= '<option value="'.$page_url.'?mode=view&amp;exp_id='.$expansion_id.'&amp;event_type='.$event_type_id.'&amp;event='.$data['event_id'].'">' . $data['zone_desc'] . '</option>';
			}
			$events .= '</select>';		
			// End Event Type Setup
		}
		else
		{
			$events = '<select name="events" DISABLED><option></option></select>';
		}
		
		// This code sets up the selection box for raid force from the raid_force table.
		$array_raid_force[$phprlang['none']] = $phprlang['all'];

		$sql = "SELECT DISTINCT raid_force_name ".
				" FROM " . $phpraid_config['db_prefix'] . "raid_force".
				" WHERE `gamepack_id` = ".$phpraid_config['gamepack_id'].";";
		$raid_force_result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
		while($raid_force_data = $db_raid->sql_fetchrow($raid_force_result, true))
		{
			$array_raid_force[$raid_force_data['raid_force_name']] = $raid_force_data['raid_force_name'];
			if ($raid_force_name == $raid_force_data['raid_force_name'])
				$selected_raid_force = $raid_force_data['raid_force_name'];
		}

		$location_shortname = '';
		$location_min_lvl = '1';
		
		//set dafault location_max_lvl
		if (isset($_GET['exp_id']))
		{
			$expansion_nr = $_GET['exp_id'];
		}
		else
		{
			$sql_expansion_nr = sprintf("SELECT * ".
										"	FROM " . $phpraid_config['db_prefix'] . "config ".
										"	WHERE config_name = %s;",
										quote_smart('wrm_expansion')
					);
			$result_expansion_nr = $db_raid->sql_query($sql_expansion_nr) or print_error($sql_expansion_nr, $db_raid->sql_error(), 1);
			$data_expansion_nr = $db_raid->sql_fetchrow($result_expansion_nr, true);
			$expansion_nr = $data_expansion_nr['config_value'];
		}
		
		$sql_max_lvl = sprintf(	"SELECT max_lvl ".
								"	FROM " . $phpraid_config['db_prefix'] . "expansion ".
								"	WHERE exp_id = %s".
								" AND `gamepack_id` = ".$phpraid_config['gamepack_id'].";",
								quote_smart($expansion_nr));
		$result_max_lvl = $db_raid->sql_query($sql_max_lvl) or print_error($sql_max_lvl, $db_raid->sql_error(), 1);
		$data_max_lvl = $db_raid->sql_fetchrow($result_max_lvl, true);
				
		$location_max_lvl = $data_max_lvl['max_lvl'];

		// Setup the Class Text Fields
		foreach ($wrm_global_classes as $global_class)
			$class[$global_class['class_id']]='<input name="'.$global_class['class_id'].'" type="text" class="post" style="width:20px" maxlength="2">';
		
		// Setup the Role Text Fields
		foreach ($wrm_global_roles as $global_role)	
		{
			if ($global_role['role_name'] != '')	
				$role[$global_role['role_id']]='<input name="'.$global_role['role_id'].'" type="text" class="post" style="width:20px" maxlength="2">';
			else			
				$role[$global_role['role_id']]='<input name="'.$global_role['role_id'].'" type="hidden" class="post" style="width:20px" maxlength="2">';
		}
		
		$chbox_locked_loc_value = '1';
		$chbox_locked_loc_status = "";
			
		if ($event_id != '')
		{
			$sql = sprintf("SELECT * ".
							" FROM " . $phpraid_config['db_prefix'] . "events ".
							" WHERE event_id = %s".
							" AND `gamepack_id` = ".$phpraid_config['gamepack_id'].";",
							quote_smart($event_id) );
			$result2 = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
			$event_data = $db_raid->sql_fetchrow($result2, true);
			$event_max = $event_data['max'];
			$zone_desc = $event_data['zone_desc'];
			$number_max_chars = $event_data['max'];
			$location_wow_name = $event_data['wow_name'];
			$icon = "gamepack/" . $phpraid_config['gamepack_name'] . "/" . $event_data['icon_path'];
			$form_action = $page_URL.'?mode=new&amp;event_type='.$event_type_id.'&amp;event='.$event_id.'&amp;location='.$zone_desc;
		}
		else
		{
			$number_max_chars = '';
			$location_wow_name = "";
			$icon = "";
			$form_action = $pageURL;
		}
			
		$buttons_01 = $phprlang['submit']; 
	}
	elseif($_GET['mode'] == 'update')
	{
		// it's an edit... joy

		// Get Limit Information for Class
		$loc_class_array = array();
		$sql = sprintf("SELECT * ".
						" FROM " . $phpraid_config['db_prefix'] . "loc_class_lmt ".
						" WHERE location_id = %s", 
						quote_smart($data['location_id']));
		$result_loc_class = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
		while($loc_class_data = $db_raid->sql_fetchrow($result_loc_class, true))
		{
			$loc_class_array[$loc_class_data['class_id']] = $loc_class_data['lmt'];
		}
		
		// Get Limit Information for Role
		$loc_role_array = array();
		$sql = sprintf("SELECT * ".
						" FROM " . $phpraid_config['db_prefix'] . "loc_role_lmt ".
						" WHERE location_id = %s", 
						quote_smart($data['location_id'])
				);
		$result_loc_role = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
		while($loc_role_data = $db_raid->sql_fetchrow($result_loc_role, true))
		{
			$sql2 = sprintf("SELECT role_name ".
							" FROM " . $phpraid_config['db_prefix'] . "roles ".
							" WHERE role_id = %s", 
							quote_smart($loc_role_data['role_id'])
					);
			$result_role_name = $db_raid->sql_query($sql2) or print_error($sql2, $db_raid->sql_error(), 1);
			$role_name = $db_raid->sql_fetchrow($result_role_name, true);
			
			$loc_role_array[$role_name['role_name']] = $loc_role_data['lmt'];
		}
						
		// Setup Event Type Select Box.
		$sql = "SELECT * ".
				" FROM " . $phpraid_config['db_prefix'] . "event_type";
		$result2 = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
		while($event_type_data = $db_raid->sql_fetchrow($result2, true))
		{
			$array_event_type[$page_URL."?mode=update&amp;id='.$id.'&amp;event_type='".$event_type_data['event_type_id']."'"] = $phprlang[$event_type_data['event_type_lang_id']];
			
			// Event Type for WoW Calendar
			if ($event_type_data['event_type_id'] == $event_type_id)
				$selected_event_type = $event_type_data['event_type_id'];
		}
		// End Event Type Setup
		
		// Setup Expansion Select Box.
		$sql = sprintf("SELECT exp_id ".
				" FROM " . $phpraid_config['db_prefix'] . "events ".
				" WHERE event_id = %s", quote_smart($event_id)
				);
		$result2 = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
		$event_data = $db_raid->sql_fetchrow($result2, true);

		$array_expansion[""] = "";
		$sql = "SELECT * ".
				" FROM " . $phpraid_config['db_prefix'] . "expansion";
		$result2 = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
		while($expansion_data = $db_raid->sql_fetchrow($result2, true))
		{		
			$array_expansion[$page_URL.'?mode=update&amp;id='.$id.'&amp;exp_id='.$expansion_data['exp_id'].'&amp;event_type='.$event_type_id] = $phprlang[$expansion_data['exp_lang_id']];		
			
			// Event Type for WoW Calendar
			if ($expansion_data['exp_id'] == $expansion_id)
				$selected_expansion = $page_URL.'?mode=update&amp;id='.$id.'&amp;exp_id='.$expansion_data['exp_id'].'&amp;event_type='.$event_type_id;
		}
		// End Expansion Setup

		// Setup Events Select Box.
		$events = '<select name="event" id="event" class="post" onChange="MM_jumpMenu(\'self\',this,0)">
					<option value="'.$page_url.'?mode=update&amp;id=' . $id . '"></option>';

		if ($event_type_id == 1 || $event_type_id == 2) // If Dungeons or Raids pull exp_id = 0 also.
			$sql = sprintf("SELECT * ".
					" FROM " . $phpraid_config['db_prefix'] . "events ".
					" WHERE (exp_id = %s OR exp_id = 0) ".
					" AND event_type_id = %s ORDER BY zone_desc", 
					quote_smart($expansion_id), quote_smart($event_type_id));
		elseif ($event_type_id == 3 || $event_type_id == 4) // If Meeting Type, Pull Major Cities
			$sql = sprintf("SELECT * ".
					" FROM " . $phpraid_config['db_prefix'] . "events ".
					" WHERE event_type_id = %s ".
					" ORDER BY zone_desc", 
					quote_smart($event_type_id));
		elseif ($event_type_id == 5) // Other Type, Pull Everything
			$sql = sprintf("SELECT * ".
					" FROM " . $phpraid_config['db_prefix'] . "events ".
					" WHERE (exp_id = %s OR exp_id = 0) ".
					" ORDER BY zone_desc", 
					quote_smart($expansion_id));	
		else // By default pull Raids and Dungeons
			$sql = sprintf("SELECT * ".
					" FROM " . $phpraid_config['db_prefix'] . "events ".
					" WHERE (exp_id = %s OR exp_id = 0) ".
					" AND event_type_id = %s ORDER BY zone_desc", 
					quote_smart($expansion_id), quote_smart($event_type_id));
			
		$result2 = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
		while($event_data = $db_raid->sql_fetchrow($result2, true))
		{		
			// Event Type for WoW Calendar
			if ($event_data['event_id'] == $event_id)
				$events .= '<option value='.$page_URL.'"?mode=update&amp;id='.$id.'&amp;exp_id='.$expansion_id.'&amp;event_type='.$event_type_id.'&amp;event='.$event_data['event_id'].'" selected>' . $event_data['zone_desc'] . '</option>';
			else
				$events .= '<option value='.$page_URL.'"??mode=update&amp;id='.$id.'&amp;exp_id='.$expansion_id.'&amp;event_type='.$event_type_id.'&amp;event='.$event_data['event_id'].'">' . $event_data['zone_desc'] . '</option>';
		}
		$events .= '</select>';		
		// End Event Setup
		
		// This code sets up the selection box for raid force from the raid_force table.
		
		$array_raid_force[$phprlang['all']] = $phprlang['all'];
		$selected_raid_force = $phprlang['all'];

		$sql = "SELECT DISTINCT raid_force_name ".
				" FROM " . $phpraid_config['db_prefix'] . "raid_force";
		$raid_force_result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
		while($raid_force_data = $db_raid->sql_fetchrow($raid_force_result, true))
		{	
			$array_raid_force[$raid_force_data['raid_force_name']] = $raid_force_data['raid_force_name'];
			if ($data['raid_force_name'] == $raid_force_data['raid_force_name'])
				$selected_raid_force = $raid_force_data['raid_force_name'];
				
//			$raid_force_box .= "<option ";
//			if ($data['raid_force_id'] == $raid_force_data['raid_force_id'])
//				$raid_force_box .= "SELECTED ";
//			$raid_force_box .= "value=\"" . $raid_force_data['raid_force_id'] . "\">" . $raid_force_data['raid_force_name'] ."</option>";	
		}
		
		$location_shortname =  $data['name'];
		$location_min_lvl = $data['min_lvl'];
		$location_max_lvl =  $data['max_lvl'];

		// Setup the Class Text Fields
		foreach ($wrm_global_classes as $global_class)
			$class[$global_class['class_id']]='<input name="'.$global_class['class_id'].'" type="text" value="' . $loc_class_array[$global_class['class_id']] . '"  class="post" style="width:20px" maxlength="2">';

		// Setup the Role Text Fields
		foreach ($wrm_global_roles as $global_role)	
			if ($global_role['role_name'] != '')
				$role[$global_role['role_id']]='<input name="'.$global_role['role_id'].'" type="text" value="' . $loc_role_array[$global_role['role_name']] . '"  class="post" style="width:20px" maxlength="2">';	

		if($data['locked'] == '0')
		{
			$chbox_locked_loc_value = $data['locked'];
			$chbox_locked_loc_status = "";
		}
		else
		{
			$chbox_locked_loc_value = $data['locked'];
			$chbox_locked_loc_status = "checked";
		}
		$number_max_chars = $data['max'];
		$sql = sprintf("SELECT * ".
						" FROM " . $phpraid_config['db_prefix'] . "events ".
						" WHERE event_id = %s", 
						quote_smart($event_id)
				);
		$result2 = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
		$event_data = $db_raid->sql_fetchrow($result2, true);
		$zone_desc = $event_data['zone_desc'];

		$location_wow_name = $event_data['wow_name'];
		if ($event_data['icon_path']!='')
			$icon = "gamepack/" . $phpraid_config['gamepack_name'] . "/" . $event_data['icon_path'];
		else
			$icon = '';
		$form_action = $page_URL.'?mode=edit&amp;id='.$id.'&amp;event_type='.$event_type_id.'&amp;event='.$event_id.'&amp;location='.$zone_desc;
		
		$buttons_01 = $phprlang['update']; 
	}

	// Select Roles to Assign to Location
	$wrmsmarty->assign('locations_new',
		array(
			'form_action'=>$form_action,
			'icon'=>$icon,
			'event'=>$events,
			'eventtype_text'=>$phprlang['raids_eventtype_text'],
			'expansion_text'=>$phprlang['locations_expansion_text'],
			'event_text'=>$phprlang['locations_events_text'],
			'location_shortname'=>$location_shortname,
			'location_wow_name'=>$location_wow_name,
			'location_read_only_text'=>$phprlang['locations_ro_text'],
			'location_min_lvl'=>$location_min_lvl,
			'location_max_lvl'=>$location_max_lvl,
			'number_max_chars'=>$number_max_chars,
			'chbox_locked_loc_status'=>$chbox_locked_loc_status,
			'chbox_locked_loc_value' =>$chbox_locked_loc_value,
			'button_01' => $buttons_01,
			'button_reset' => $phprlang['reset'],
			'locked_text'=>$phprlang['lock_template'],
			'newlocation_header'=>$phprlang['locations_new'],
			'shortname_text'=>$phprlang['locations_short'],
			'location_text'=>$phprlang['locations_long'],
			'minlvl_text'=>$phprlang['locations_min_lvl'],
			'maxlvl_text'=>$phprlang['locations_max_lvl'],
			'maxattendees_text'=>$phprlang['locations_raid_max'],
			'limits_header'=>$phprlang['locations_limits_header'],
			'raid_force'=>$raid_force_box,
			'raid_force_text'=>$phprlang['raid_force_name'],
			'array_event_type' => $array_event_type,
			'selected_event_type' => $selected_event_type,
			'array_expansion' => $array_expansion,
			'selected_expansion' => $selected_expansion,
			'array_raid_force' => $array_raid_force,
			'selected_raid_force' => $selected_raid_force,
		
		)
	);
	// Assign Class Info to Class For Location
	$class_array = array();
	foreach ($wrm_global_classes as $global_class)
	{
		array_push($class_array,
			array(
				'class'=>$class[$global_class['class_id']],
				'lang_id'=>$phprlang[$global_class['lang_index']],
			)
		);
	}
	$wrmsmarty->assign('class_data', $class_array);
	
	// Assign Role Info to Role For Location
	$role_array = array();
	foreach ($wrm_global_roles as $global_role)	
	{
		array_push($role_array,
			array(
				'role'=>$role[$global_role['role_id']],
				'lang_id'=>$global_role['role_name'],
			)
		);
	}
	$wrmsmarty->assign('role_data', $role_array);	
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