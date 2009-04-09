<?php
/***************************************************************************
 *                               raids.php
 *                            ---------------
 *   begin                : Saturday, Jan 16, 2005
 *   copyright            : (C) 2007 - 2008 Douglas Wagner
 *   email                : douglasw@wagnerweb.org
 *
 *   $Id: raids.php,v 2.00 2008/03/10 13:26:43 psotfx Exp $
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
if ($phpraid_config['enable_five_man'])
{
	define("PAGE_LVL","profile");
}
else
{
	define("PAGE_LVL","raids");
}
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
	
$pageURL = 'raids.php?mode=view&';
/**************************************************************
 * End Record Output Setup for Data Table
 **************************************************************/
		
$priv_raids = scrub_input($_SESSION['priv_raids']);
$username = scrub_input($_SESSION['username']);

if($_GET['mode'] == 'view')
{
	// two arrays to pass to our report class, current and previous raids
	$current = array();
	$previous = array();
	$count = array();
	$count2 = array();
	$raid_loop_cur = 0;
	$raid_loop_prev = 0;
	
	$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "raids";
	$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);

	// Get information for current raids
	// And push into current array so that we can output it with our report class
	if (!$db_raid->sql_numrows($result) || $db_raid->sql_numrows($result) < 1)
		$new_raid_link = '<a href="raids.php?mode=new"><img src="templates/' . $phpraid_config['template'] . '/images/icons/icon_new_raid.gif" border="0"  onMouseover="ddrivetip(\''.$phprlang['raids_new_header'].'\');" onMouseout="hideddrivetip();" alt="new raid icon"></a>';		

	while($data = $db_raid->sql_fetchrow($result, true)) {
		if ($priv_raids or $username == $data['officer'])
		{
			$edit = '<a href="raids.php?mode=edit&amp;id='.$data['raid_id'].'"><img src="templates/' . $phpraid_config['template'] .
					'/images/icons/icon_edit.gif" border="0" onMouseover="ddrivetip(\''.$phprlang['edit'].'\');" onMouseout="hideddrivetip();" alt="edit icon"></a>';

			$delete = '<a href="raids.php?mode=delete&amp;n='.$data['location'].'&amp;id='.$data['raid_id'].'"><img src="templates/' .
						$phpraid_config['template'] . '/images/icons/icon_delete.gif" border="0" onMouseover="ddrivetip(\''.$phprlang['delete'].'\');"
						onMouseout="hideddrivetip();" alt="delete icon"></a><a href="lua_output.php?raid_id=' . $data['raid_id'] . '">

						<img src="templates/' . $phpraid_config['template'] . '/images/icons/icon_minipost.gif" border="0"
						onMouseover="ddrivetip(\''.$phprlang['lua'].'\');" onMouseout="hideddrivetip();" alt="minipost icon"></a>

						<a href="raids.php?mode=mark&amp;id='.$data['raid_id'].'"><img src="templates/' . $phpraid_config['template'] .
						'/images/icons/icon_latest_reply.gif" border="0" onMouseover="ddrivetip(\''.$phprlang['mark'].'\');"
						onMouseout="hideddrivetip();" alt="latest reply icon"></a>';

			$old_delete = '<a href="raids.php?mode=delete&amp;id='.$data['raid_id'].'"><img src="templates/' . $phpraid_config['template'] . '/images/icons/icon_delete.gif" border="0" onMouseover="ddrivetip(\''.$phprlang['delete'].'\');" onMouseout="hideddrivetip();" alt="delete icon"></a>';

			$mark_new = '<a href="raids.php?mode=mark&amp;id='.$data['raid_id'].'"><img src="templates/' . $phpraid_config['template'] . '/images/icons/icon_latest_reply.gif" border="0" onMouseover="ddrivetip(\''.$phprlang['new'].'\');" onMouseout="hideddrivetip();" alt="latest reply icon"></a>';
		}

		// Create the "new raid" button.
		$new_raid_link = '<a href="raids.php?mode=new"><img src="templates/' . $phpraid_config['template'] . '/images/icons/icon_new_raid.gif" border="0"  onMouseover="ddrivetip(\''.$phprlang['raids_new_header'].'\');" onMouseout="hideddrivetip();" alt="new raid icon"></a>';

		// Initialize Count Array and Totals.
		foreach ($wrm_global_classes as $global_class)
		{
			$count[$global_class['class_id']]='0';
			$count2[$global_class['class_id']]='0';
		}		
		foreach ($wrm_global_roles as $global_role)
		{	
			$count[$global_role['role_id']]='0';
			$count2[$global_role['role_id']]='0';
		}
		$total = 0;
		$total2 = 0;

		$desc = scrub_input($data['description']);
		$desc = str_replace("'", "\'", $desc);
		$ddrivetiptxt = "'<span class=tooltip_title>" . $phprlang['description'] ."</span><br>" . DEUBB2($desc) . "'";
		$location = '<a href="view.php?mode=view&amp;raid_id='.$data['raid_id'].'" onMouseover="ddrivetip('.$ddrivetiptxt.');" onMouseout="hideddrivetip();">'.$data['location'].'</a>';

		// convert unix timestamp to something readable
		$start = new_date('Y/m/d H:i:s',$data['start_time'],$phpraid_config['timezone'] + $phpraid_config['dst']);
		$invite = new_date('Y/m/d H:i:s',$data['invite_time'],$phpraid_config['timezone'] + $phpraid_config['dst']);
		$date = $start;
		
		//Get Raid Total Counts
		$count = get_char_count($data['raid_id'], $type='');
		$count2 = get_char_count($data['raid_id'], $type='queue');		
		foreach ($count as $class_count)
			$total += $class_count;
		foreach ($count2 as $class_queue_count)
			$total2 += $class_queue_count;
			
		// Now that we have the raid data, we need to retrieve limit data based upon Raid ID.
		// Get Class Limits and set Colored Counts
		$raid_class_array = array();
		$class_color_count = array();
		$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "raid_class_lmt WHERE raid_id = %s", quote_smart($data['raid_id']));
		$result_raid_class = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
		while($raid_class_data = $db_raid->sql_fetchrow($result_raid_class, true))
		{
			$raid_class_array[$raid_class_data['class_id']] = $raid_class_data['lmt'];
			if($phpraid_config['class_as_min'])
				$class_color_count[$raid_class_data['class_id']] = get_coloredcount($raid_class_data['class_id'], $count[$raid_class_data['class_id']], $raid_class_array[$raid_class_data['class_id']], $count2[$raid_class_data['class_id']], true);
			else
				$class_color_count[$raid_class_data['class_id']] = get_coloredcount($raid_class_data['class_id'], $count[$raid_class_data['class_id']], $raid_class_array[$raid_class_data['class_id']], $count2[$raid_class_data['class_id']]);
		}
		// Get Role Limits and set Colored Counts
		$raid_role_array = array();
		$role_color_count = array();
		$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "raid_role_lmt WHERE raid_id = %s", quote_smart($data['raid_id']));
		$result_raid_role = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
		while($raid_role_data = $db_raid->sql_fetchrow($result_raid_role, true))
		{
			$sql2 = sprintf("SELECT role_name FROM " . $phpraid_config['db_prefix'] . "roles WHERE role_id = %s", quote_smart($raid_role_data['role_id']));
			$result_role_name = $db_raid->sql_query($sql2) or print_error($sql2, mysql_error(), 1);
			$role_name = $db_raid->sql_fetchrow($result_role_name, true);
			
			$raid_role_array[$role_name['role_name']] = $raid_role_data['lmt'];
			$role_color_count[$role_name['role_name']] = get_coloredcount($role_name['role_name'], $count[$raid_role_data['role_id']], $raid_role_array[$role_name['role_name']], $count2[$raid_role_data['role_id']]);
		}
					
		// current raids
		if($data['old'] == 0) {
			array_push($current,
				array(
					'ID'=>$data['raid_id'],
					'Date'=>$date,
					'Dungeon'=>$location,
					'Invite Time'=>$invite,
					'Start Time'=>$start,
					'Creator'=>$data['officer'],
					'Totals'=>$total.'/'.$data['max']  . '(+' . $total2. ')',
					'Buttons'=>$edit . $delete,
				)
			);
			foreach ($class_color_count as $left => $right)
				$current[$raid_loop_cur][$left]= $right;
			foreach ($role_color_count as $left => $right)
				$current[$raid_loop_cur][$left]= $right;
			$raid_loop_cur++;
		}
		else
		{
			array_push($previous,
				array(
					'ID'=>$data['raid_id'],
					'Date'=>$date,
					'Dungeon'=>UBB2($location),
					'Invite Time'=>$invite,
					'Start Time'=>$start,
					'Creator'=>$data['officer'],
					'Totals'=>$total.'/'.$data['max']  . '(+' . $total2. ')',
					'Buttons'=> $mark_new . $old_delete
				)
			);	
			foreach ($class_color_count as $left => $right)
				$previous[$raid_loop_prev][$left]= $right;
			foreach ($role_color_count as $left => $right)
				$previous[$raid_loop_prev][$left]= $right;
			$raid_loop_prev++;
		}
		$edit = "";
		$delete= "";
		$old_delete="";
		$mark_new="";
	}

	/**************************************************************
	 * Code to setup for a Dynamic Table Create: raids1 View.
	 **************************************************************/
	$viewName = 'raids1';
	
	//Setup Columns
	$raid_headers = array();
	$record_count_array = array();
	$raid_headers = getVisibleColumns($viewName);

	//Get Record Counts
	$curr_record_count_array = getRecordCounts($current, $raid_headers, $startRecord);
	$prev_record_count_array = getRecordCounts($previous, $raid_headers, $startRecord);
	
	//Get the Jump Menu and pass it down
	$currJumpMenu = getPageNavigation($current, $startRecord, $pageURL, $sortField, $sortDesc);
	$prevJumpMenu = getPageNavigation($previous, $startRecord, $pageURL, $sortField, $sortDesc);

	//Setup Data
	$current = paginateSortAndFormat($current, $sortField, $sortDesc, $startRecord, $viewName);
	$previous = paginateSortAndFormat($previous, $sortField, $sortDesc, $startRecord, $viewName);

	/****************************************************************
	 * Data Assign for Template.
	 ****************************************************************/
	$wrmsmarty->assign('new_data', $current); 
	$wrmsmarty->assign('old_data', $previous);
	$wrmsmarty->assign('current_jump_menu', $currJumpMenu);
	$wrmsmarty->assign('previous_jump_menu', $prevJumpMenu);
	$wrmsmarty->assign('column_name', $raid_headers);
	$wrmsmarty->assign('curr_record_counts', $curr_record_count_array);
	$wrmsmarty->assign('prev_record_counts', $prev_record_count_array);
	$wrmsmarty->assign('header_data',
		array(
			'template_name'=>$phpraid_config['template'],
			'new_raid_link' => $new_raid_link,
			'old_raids_header' => $phprlang['raids_old'],
			'new_raids_header' => $phprlang['raids_new'],
			'sort_url_base' => $pageURL,
			'sort_descending' => $sortDesc,
			'sort_text' => $phprlang['sort_text'],
		)
	);
	
	//
	// Start output of delete page.
	//
	require_once('includes/page_header.php');
	$wrmsmarty->display('raids.html');
	require_once('includes/page_footer.php');
}
elseif($_GET['mode'] == 'new' || $_GET['mode'] == 'edit')
{
	// error checking, goes before the output so we can show the error at the top and allow them to fix the errors without pressing back
	if(isset($_POST['submit']))
	{
		$location = scrub_input($_POST['location']);
		$date = str_replace(" ", "", scrub_input($_POST['date']));
		$tag = scrub_input($_POST['tag']);
		if ($tag == '')
			$tag = "1";
		$event_id = scrub_input($_POST['event_id']);
		if ($event_id == '')
			$event_id = "0";
		$description = scrub_input($_POST['description']);
		$max = scrub_input($_POST['max']);
		$min_lvl = scrub_input($_POST['min_lvl']);
		$max_lvl = scrub_input($_POST['max_lvl']);

		// Handle Classes
		$bad_class_limit = FALSE;
		foreach ($wrm_global_classes as $global_class)
		{
			$classtrans = str_replace(" ", "_", $global_class['class_id']);
			if ($_POST[$classtrans]!='' && is_numeric($_POST[$classtrans]))
				$class[$global_class['class_id']] = scrub_input($_POST[$classtrans]);
			else
				$bad_class_limit = TRUE;
		}
		
		// Handle Roles
		$bad_role_limit = FALSE;
		foreach ($wrm_global_roles as $global_role)	
		{
			$role[$global_role['role_id']] = scrub_input($_POST[$global_role['role_id']]);
			if ($role[$global_role['role_id']] == '')
				$role[$global_role['role_id']] == '0'; 

			if($global_role['role_name'] != '')
				if (!is_numeric($role[$global_role['role_id']]))
					$bad_role_limit = TRUE;	
		}
		
		// Verify Data to ensure Correctness, set error if not.
		if($location == "" || $date == "" || $max == "" || $min_lvl == "" || $max_lvl == "" ||
		   !is_numeric($max) || !is_numeric($min_lvl) || !is_numeric($max_lvl) || $bad_class_limit ||
		   $bad_role_limit)
		{
			$errorTitle = $phprlang['form_error'];
			$errorSpace = 1;
			$errorMsg = '<ul>';
			if($location == "")
				$errorMsg .= '<li>' . $phprlang['raid_error_location'] . '</li>';

			if($date == "")
				$errorMsg .= '<li>' . $phprlang['raid_error_date'] . '</li>';

			if($max == "" || $min_lvl == "" || $max_lvl == "" ||
			!is_numeric($max) || !is_numeric($min_lvl) || !is_numeric($max_lvl) || $bad_class_limit ||
			$bad_role_limit)
				$errorMsg .= '<li>' . $phprlang['raid_error_limits'] . '</li>';
		}
		if($description == "")				
		{									
        	$description="-";			
        	$_POST['description']="-";	
		}

	}

	//Normal fetch location
	if(isset($_GET['id']))
	{
		$location = scrub_input($_GET['id']);
		//if ($priv_raids == 1)
		//{
			$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "locations WHERE location_id=%s", quote_smart($location));
			$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
			$data = $db_raid->sql_fetchrow($result, true);
		//}
		//else
		//{
		//	$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "locations WHERE location_id=%s and locked='0'", quote_smart($location));
		//	$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
		//	$data = $db_raid->sql_fetchrow($result, true);
		//}

		$tag = $data['event_type'];
		$event_id = $data['event_id'];
		$max = $data['max'];

		// Now that we have the location data, we need to retrieve limit data based upon location ID.
		// Get Class Limits
		//$raid_class_array = array();
		$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "loc_class_lmt WHERE location_id = %s", quote_smart($location));
		$result_loc_class = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
		while($loc_class_data = $db_raid->sql_fetchrow($result_loc_class, true))
		{
			$class[$loc_class_data['class_id']] = $loc_class_data['lmt'];
		}
		// Get Role Limits
		//$raid_role_array = array();
		$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "loc_role_lmt WHERE location_id = %s", quote_smart($location));
		$result_loc_role = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
		while($loc_role_data = $db_raid->sql_fetchrow($result_loc_role, true))
		{
			$sql2 = sprintf("SELECT role_name FROM " . $phpraid_config['db_prefix'] . "roles WHERE role_id = %s", quote_smart($loc_role_data['role_id']));
			$result_role_name = $db_raid->sql_query($sql2) or print_error($sql2, mysql_error(), 1);
			$role_name = $db_raid->sql_fetchrow($result_role_name, true);
			
			$role[$role_name['role_name']] = $loc_role_data['lmt'];
		}
		$min_lvl_value = $data['min_lvl'];
		$max_lvl_value = $data['max_lvl'];
		$location_value = $data['location'];
	}

	if(!isset($_POST['submit']) || isset($errorTitle))
	{
		// setup the form action first
		if(isset($_GET['mode']) && $_GET['mode'] == 'new')
		{
			$form_action = 'raids.php?mode=new';
		}
		elseif(isset($_GET['mode']) && $_GET['mode'] == 'edit')
		{
			$id = scrub_input($_GET['id']);
			$form_action = 'raids.php?mode=edit&amp;id='. $id;
		}

 		// and if it's an edit, grab straight from the raids database instead
		if($_GET['mode'] == 'edit')
		{
			// if so, grab values from database
			if(isset($_GET['location']))
			{
				echo "<BR>Gets to New/Edit -> Not Submit -> Edit -> Location";
			//	$location = scrub_input($_GET['location']);
			//	if ($priv_raids == 1)
			//	{
			//		$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "locations WHERE name=%s", quote_smart($location));
			//		$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
			//		$data = $db_raid->sql_fetchrow($result, true);
			//	}
			//	else
			//	{
			//		$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "locations WHERE name=%s and locked='0'", quote_smart($location));
			//		$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
			//		$data = $db_raid->sql_fetchrow($result, true);
			//	}

			//	$tag = $data['event_type'];
			//	$event_id = $data['event_id'];
	        //  $max = $data['max'];

	            // Now that we have the location data, we need to retrieve limit data based upon location ID.
				// Get Class Limits
			//	$loc_class_array = array();
			//	$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "loc_class_lmt WHERE location_id = %s", quote_smart($location));
			//	$result_loc_class = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
			//	while($loc_class_data = $db_raid->sql_fetchrow($result_loc_class, true))
			//	{
			//		$loc_class_array[$loc_class_data['class_id']] = $loc_class_data['lmt'];
			//	}
				// Get Role Limits
			//	$loc_role_array = array();
			//	$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "loc_role_lmt WHERE location_id = %s", quote_smart($location));
			//	$result_loc_role = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
			//	while($loc_role_data = $db_raid->sql_fetchrow($result_loc_role, true))
			//	{
			//		$sql2 = sprintf("SELECT role_name FROM " . $phpraid_config['db_prefix'] . "roles WHERE role_id = %s", quote_smart($loc_role_data['role_id']));
			//		$result_role_name = $db_raid->sql_query($sql2) or print_error($sql2, mysql_error(), 1);
			//		$role_name = $db_raid->sql_fetchrow($result_role_name, true);
			//		
			//		$loc_role_array[$role_name['role_name']] = $loc_role_data['lmt'];
			//	}
	            //$dk = $data['dk'];
			    //$dr = $data['dr'];
			    //$hu = $data['hu'];
			    //$ma = $data['ma'];
			    //$pa = $data['pa'];
			    //$pr = $data['pr'];
			    //$ro = $data['ro'];
			    //$sh = $data['sh'];
			    //$wk = $data['wk'];
			    //$wa = $data['wa'];
				//$role1 = $data['role1'];
				//$role2 = $data['role2'];
				//$role3 = $data['role3'];
				//$role4 = $data['role4'];
				//$role5 = $data['role5'];
				//$role6 = $data['role6'];
	        //	$min_lvl_value = $data['min_lvl'];
	        //	$max_lvl_value = $data['max_lvl'];
	        //	$location_value = UBB2($data['location']);
	
			//	$id = scrub_input($_GET['id']);
			//	$sql2 = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "raids WHERE raid_id=%s", quote_smart($id));
			//	$result2 = $db_raid->sql_query($sql2) or print_error($sql2, mysql_error(), 1);
			//	$data2 = $db_raid->sql_fetchrow($result2, true);
	            
			//	$date_value = new_date("m/d/Y",$data2['start_time'],$phpraid_config['timezone'] + $phpraid_config['dst']);
			//	if ($phpraid_config['ampm'] == '12')
			//		$i_time_hour_value = new_date("h",$data2['invite_time'],$phpraid_config['timezone'] + $phpraid_config['dst']);
			//	else
			//		$i_time_hour_value = new_date("H",$data2['invite_time'],$phpraid_config['timezone'] + $phpraid_config['dst']);	            	
			//	$i_time_minute_value = new_date("i",$data2['invite_time'],$phpraid_config['timezone'] + $phpraid_config['dst']);
			//	$i_time_ampm_value = new_date("a",$data2['invite_time'],$phpraid_config['timezone'] + $phpraid_config['dst']);
			//	if ($phpraid_config['ampm'] == '12')
			//		$s_time_hour_value = new_date("h",$data2['start_time'],$phpraid_config['timezone'] + $phpraid_config['dst']);
			//	else
			//		$s_time_hour_value = new_date("H",$data2['start_time'],$phpraid_config['timezone'] + $phpraid_config['dst']);
			//	$s_time_minute_value = new_date("i",$data2['start_time'],$phpraid_config['timezone'] + $phpraid_config['dst']);
			//	$s_time_ampm_value = new_date("a",$data2['start_time'],$phpraid_config['timezone'] + $phpraid_config['dst']);
			//	$freeze_value = $data2['freeze'];
			//	$description_value = UBB2($data2['description']);
			}
			else // Edit, Location Not set.
			{
	         	$id = scrub_input($_GET['id']);
	            $sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "raids WHERE raid_id=%s", quote_smart($id));
	            $result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
	            $data = $db_raid->sql_fetchrow($result, true);
	            
	            $tag = $data['event_type'];
	            $event_id = $data['event_id'];
	            $max = $data['max'];

	            // Now that we have the raid data, we need to retrieve limit data based upon Raid ID.
				// Get Class Limits and set Colored Counts
				//$raid_class_array = array();
				$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "raid_class_lmt WHERE raid_id = %s", quote_smart($data['raid_id']));
				$result_raid_class = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
				while($raid_class_data = $db_raid->sql_fetchrow($result_raid_class, true))
				{
					$class[$raid_class_data['class_id']] = $raid_class_data['lmt'];
				}
				// Get Role Limits and set Colored Counts
				//$raid_role_array = array();
				$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "raid_role_lmt WHERE raid_id = %s", quote_smart($data['raid_id']));
				$result_raid_role = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
				while($raid_role_data = $db_raid->sql_fetchrow($result_raid_role, true))
				{
					$sql2 = sprintf("SELECT role_name FROM " . $phpraid_config['db_prefix'] . "roles WHERE role_id = %s", quote_smart($raid_role_data['role_id']));
					$result_role_name = $db_raid->sql_query($sql2) or print_error($sql2, mysql_error(), 1);
					$role_name = $db_raid->sql_fetchrow($result_role_name, true);
					
					$role[$role_name['role_name']] = $raid_role_data['lmt'];
				}	            
	            $min_lvl_value = $data['min_lvl'];
	            $max_lvl_value = $data['max_lvl'];
	            $location_value = UBB2($data['location']);
	            $date_value = new_date("m/d/Y",$data['start_time'],$phpraid_config['timezone'] + $phpraid_config['dst']);
				if ($phpraid_config['ampm'] == '12')
	            	$i_time_hour_value = new_date("h",$data['invite_time'],$phpraid_config['timezone'] + $phpraid_config['dst']);
	            else
	            	$i_time_hour_value = new_date("H",$data['invite_time'],$phpraid_config['timezone'] + $phpraid_config['dst']);	            	
	            $i_time_minute_value = new_date("i",$data['invite_time'],$phpraid_config['timezone'] + $phpraid_config['dst']);
	            $i_time_ampm_value = new_date("a",$data['invite_time'],$phpraid_config['timezone'] + $phpraid_config['dst']);
				if ($phpraid_config['ampm'] == '12')
	            	$s_time_hour_value = new_date("h",$data['start_time'],$phpraid_config['timezone'] + $phpraid_config['dst']);
	            else
	            	$s_time_hour_value = new_date("H",$data['start_time'],$phpraid_config['timezone'] + $phpraid_config['dst']);
	            $s_time_minute_value = new_date("i",$data['start_time'],$phpraid_config['timezone'] + $phpraid_config['dst']);
	            $s_time_ampm_value = new_date("a",$data['start_time'],$phpraid_config['timezone'] + $phpraid_config['dst']);
	            $freeze_value = $data['freeze'];
	            $description_value = UBB2($data['description']);
			}
      	}
		elseif(isset($_POST['submit']))
		{
			//or it could be they screwed up the form, let's put those values back in because we're nice like that
			$tag = scrub_input($_POST['tag']);
			$event_id = scrub_input($_POST['event_id']);
			$max = scrub_input($_POST['max']);

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
			$min_lvl_value = scrub_input($_POST['min_lvl']);
			$max_lvl_value = scrub_input($_POST['max_lvl']);
			$location_value = scrub_input($_POST['location']);
			$date_value = scrub_input($_POST['date']);
			$i_time_hour_value = scrub_input($_POST['i_time_hour']);
			$i_time_minute_value = scrub_input($_POST['i_time_minute']);
			$i_time_ampm_value = scrub_input($_POST['i_time_ampm']);
			$s_time_hour_value = scrub_input($_POST['s_time_hour']);
			$s_time_minute_value = scrub_input($_POST['s_time_minute']);
			$s_time_ampm_value = scrub_input($_POST['s_time_ampm']);
			$freeze_value = scrub_input($_POST['freeze']);
			$description_value = scrub_input($_POST['description']);
		}

		// now for the actual form elements
		if(isset($date_value))
			$date = '<input type="text" name="date" size="20" class="post" READONLY value="' . $date_value . '"><a href="javascript:showCal(\'Calendar1\')"><span class="gen"> [+]</span></a>';
		else
			$date = '<input type="text" name="date" size="20" class="post" READONLY><a href="javascript:showCal(\'Calendar1\')"><span class="gen"> [+]</span></a>';

		// invite time
		$i_time_hour = '<select name="i_time_hour" class="post">';
		for($i = 1; $i <= $phpraid_config['ampm']; $i++)
		{
			if($i < 10)
				$i_string = '0' . $i;
			else
				$i_string = $i;

			if(isset($i_time_hour_value) && $i_string == $i_time_hour_value)
				$i_time_hour .= '<option value="' . $i_string . '" selected>' . $i_string . '</option>';
			else
				$i_time_hour .= '<option value="' . $i_string . '">' . $i_string . '</option>';
		}
		$i_time_hour .= '</select>';

		//~@@Change: Douglas Wagner - 6/23/2007
		// This code reduces the selections in the "minute" selection boxes.  We want a 15 minute granularity, not a 1 minute granularity.
		$i_time_minute = '<select name="i_time_minute" class="post">';
		for($i = 0; $i < 60; $i++)
		{
			$ifloor=$i/15;					//Added
			if(($ifloor) == floor($ifloor)) //Added
			{								//Added
				if($i < 10)
					$i_string = '0' . $i;
				else
					$i_string = $i;

				if(isset($i_time_minute_value) && $i_string == $i_time_minute_value)
					$i_time_minute .= '<option value="' . $i_string . '" selected>' . $i_string . '</option>';
				else
					$i_time_minute .= '<option value="' . $i_string . '">' . $i_string . '</option>';
			} 								//Added
		}
		$i_time_minute .= '</select>';

		if ($phpraid_config['ampm'] == '12')
		{
			$i_time_ampm = '<select name="i_time_ampm" class="post">';
			if(isset($i_time_ampm_value) && $i_time_ampm_value == 'am')
			{
				$i_time_ampm .= '<option value="am" selected>am</option><option value="pm">pm</option>';
			}
			elseif(isset($i_time_ampm_value) && $i_time_ampm_value == 'pm')
			{
				$i_time_ampm .= '<option value="am">am</option><option value="pm" selected>pm</option>';
			}
			else
			{
				$i_time_ampm .= '<option value="am">am</option><option value="pm" selected>pm</option>';
			}
			$i_time_ampm .= '</select>';
			// end of invite time
		}
		
		// start time
		$s_time_hour = '<select name="s_time_hour" class="post">';
		for($i = 1; $i <= $phpraid_config['ampm']; $i++)
		{
			if($i < 10)
				$s_string = '0' . $i;
			else
				$s_string = $i;

			if(isset($s_time_hour_value) && $s_string == $s_time_hour_value)
				$s_time_hour .= '<option value="' . $s_string . '" selected>' . $s_string . '</option>';
			else
				$s_time_hour .= '<option value="' . $s_string . '">' . $s_string . '</option>';
		}
		$s_time_hour .= '</select>';

		//~@@Change: Douglas Wagner - 6/23/2007
		// This code reduces the selections in the "minute" selection boxes.  We want a 15 minute granularity, not a 1 minute granularity.
		$s_time_minute = '<select name="s_time_minute" class="post">';
		for($i = 0; $i < 60; $i++)
		{
			$ifloor=$i/15;					//Added
			if(($ifloor) == floor($ifloor)) //Added
			{								//Added
				if($i < 10)
					$s_string = '0' . $i;
				else
					$s_string = $i;

				if(isset($s_time_minute_value) && $s_string == $s_time_minute_value)
					$s_time_minute .= '<option value="' . $s_string . '" selected>' . $s_string . '</option>';
				else
					$s_time_minute .= '<option value="' . $s_string . '">' . $s_string . '</option>';
			} 								//Added
		}
		$s_time_minute .= '</select>';

		if ($phpraid_config['ampm'] == '12')
		{
			$s_time_ampm = '<select name="s_time_ampm" class="post">';
			if(isset($s_time_ampm_value) && $s_time_ampm_value == 'am')
			{
				$s_time_ampm .= '<option value="am" selected>am</option><option value="pm">pm</option>';
			}
			elseif(isset($s_time_ampm_value) && $s_time_ampm_value == 'pm')
			{
				$s_time_ampm .= '<option value="am">am</option><option value="pm" selected>pm</option>';
			}
			else
			{
				$s_time_ampm .= '<option value="am">am</option><option value="pm" selected>pm</option>';
			}
			$s_time_ampm .= '</select>';
			// end of start time
		}
		
		// freeze
		$freeze = '<select name="freeze" class="post">';
		for($i = 0; $i <= 24; $i++)
		{
			if(isset($freeze_value) && $i == $freeze_value)
				$freeze .= '<option value="' . $i . '" selected>' . $i . '</option>';
			else
				$freeze .= '<option value="' . $i . '">' . $i . '</option>';
		}
		$freeze .= '</select>';
		
		// Event Type for WoW Calendar
		$eventtype = '<select name="tag" class="post">';
		$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "event_type";
		$result2 = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
		while($event_type_data = $db_raid->sql_fetchrow($result2, true))
		{		
			// Event Type for WoW Calendar
			if (isset($tag) && $event_type_data['event_type_id'] == $tag)
				$eventtype .= '<option value="'.$event_type_data['event_type_id'].'" selected>' . $phprlang[$event_type_data['event_type_lang_id']] . '</option>';
			elseif (!isset($tag) && $event_type_data['event_type_id'] == 1)
				$eventtype .= '<option value="'.$event_type_data['event_type_id'].'" selected>' . $phprlang[$event_type_data['event_type_lang_id']] . '</option>';
			else
				$eventtype .= '<option value="'.$event_type_data['event_type_id'].'">' . $phprlang[$event_type_data['event_type_lang_id']] . '</option>';
		}
		$eventtype .= '</select>';		
		// End Event Type Setup		
		
		$event_id_info = '<input type="hidden" name="event_id" class="post" value="' . $event_id . '">';

		// location
		if(isset($location_value))
			$location = '<input type="text" name="location" class="post" value="' . $location_value . '">';
		else
			$location = '<input type="text" name="location" class="post">';

		// Determine values for Location Dropdown.
		if (isset($_GET['location'])) {
		   $raid_location = scrub_input($_GET['location']);
		} else {
		   $raid_location = '';
		}
		if (isset($_GET['mode'])) {
		   $raid_mode = scrub_input($_GET['mode']);
		} else {
		   $raid_mode = '';
		}
		//if (isset($_GET['id'])) {
		//   $raid_id = scrub_input($_GET['id']);
		//} else {
		//   $raid_id = '';
		//}
			
		// setup vars for raid templates
		$raid_name = '<select name="name" id="name" class="post" onChange="MM_jumpMenu(\'parent\',this,0)">
					<option value=""></option>';

		if ($priv_raids == 1)
		{
			$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "locations ORDER BY name";
			$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
		}
		else
		{
			$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "locations WHERE locked='0' ORDER BY name";
			$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
		}
		while($data = $db_raid->sql_fetchrow($result, true))
		{
			if($raid_location == $data['name'])
			{
			   if($raid_mode == 'edit')
				  $raid_name .= '<option value="raids.php?mode=edit&id=' . $data['location_id'] . '&location=' . $data['name'] .'" selected>' . $data['name'] . '</option>';
			   else
				  $raid_name .= '<option value="raids.php?mode=new&id=' . $data['location_id']  . '&location=' . $data['name'] .'" selected>' . $data['name'] . '</option>';
			}
			else
			{
			   if($raid_mode == 'edit')
				  $raid_name .= '<option value="raids.php?mode=edit&id=' . $data['location_id'] . '&location=' . $data['name'] .'">' . $data['name'] . '</option>';
			   else
				  $raid_name .= '<option value="raids.php?mode=new&id=' . $data['location_id'] . '&location=' . $data['name'] .'">' . $data['name'] . '</option>';
			}
		 }
		 $raid_name .= '</select>';

		// description
		if(isset($description_value))
			$description = '<textarea name="description" cols="50" rows="10" wrap="PHYSICAL" class="post" id="message" style="width:300;height:150">' . $description_value . '</textarea>';
		else
			$description = '<textarea name="description" cols="50" rows="10" wrap="PHYSICAL" class="post" id="message" style="width:300;height:150"></textarea>';

		// limits
		$raid_class_array = array();
		$raid_role_array = array();
		if($_GET['mode'] == 'edit' || isset($_GET['id']))
		{
			$maximum = '<input name="max" type="text" class="post" style="width:20px" value="' . $max . '" maxlength="2">';
			$minimum_level = '<input name="min_lvl" type="text" class="post" style="width:20px" value="' . $min_lvl_value . '" maxlength="2">';
			$maximum_level =  '<input name="max_lvl" type="text" class="post" style="width:20px" value="' . $max_lvl_value . '" maxlength="2">';
			
			// Handle Classes
			foreach ($wrm_global_classes as $global_class)
				$raid_class_array[$global_class['class_id']] = '<input name="'.$global_class['class_id'].'" type="text" class="post" style="width:20px" value="' . $class[$global_class['class_id']] . '" maxlength="2">';
			
			// Handle Roles
			foreach ($wrm_global_roles as $global_role)	
			{
				if ($global_role['role_name'] != '')
					$raid_role_array[$global_role['role_id']] = '<input name="'.$global_role['role_id'].'" type="text" class="post" style="width:20px" value="' . $role[$global_role['role_name']] . '" maxlength="2">';
				else
					$raid_role_array[$global_role['role_id']] = '';	
			}					
		} else {
			$maximum = '<input name="max" type="text" class="post" style="width:20px" maxlength="2">';
			$minimum_level = '<input name="min_lvl" type="text" class="post" style="width:20px" maxlength="2">';
			$maximum_level =  '<input name="max_lvl" type="text" class="post" style="width:20px" maxlength="2">';

			// Handle Classes
			foreach ($wrm_global_classes as $global_class)
				$raid_class_array[$global_class['class_id']] = '<input name="'.$global_class['class_id'].'" type="text" class="post" style="width:20px" maxlength="2">';
			
			// Handle Roles
			foreach ($wrm_global_roles as $global_role)	
			{
				if ($global_role['role_name'] != '')
					$raid_role_array[$global_role['role_id']] = '<input name="'.$global_role['role_id'].'" type="text" class="post" style="width:20px" maxlength="2">';
				else
					$raid_role_array[$global_role['role_id']] = '';	
			}			
		}
		$buttons = '<input type="submit" name="submit" value="'.$phprlang['submit'].'" class="mainoption"> <input type="reset" name="reset" value="'.$phprlang['reset'].'" class="liteoption">';			
		
		/****************************************************************
		 * Data Assign for Template.
		 ****************************************************************/		
		$wrmsmarty->assign('page',
			array(
				'buttons'=>$buttons,
				'form_action'=>$form_action,
				'raid_name'=>$raid_name,
				'date'=>$date,
				'i_time_hour'=>$i_time_hour,
				'i_time_minute'=>$i_time_minute,
				'i_time_ampm'=>$i_time_ampm,
				's_time_hour'=>$s_time_hour,
				's_time_minute'=>$s_time_minute,
				's_time_ampm'=>$s_time_ampm,
				'freeze'=>$freeze,
				'event_type'=>$eventtype,
				'event_id_info'=>$event_id_info,
				'location'=>$location,
				'description'=>$description,
				'maximum'=>$maximum,
				'minimum_level'=>$minimum_level,
				'maximum_level'=>$maximum_level,
				'dungeon_text'=>$phprlang['raids_dungeon'],
				'date_text'=>$phprlang['raids_date'],
				'raids_new'=>$phprlang['raids_new_header'],
				'invite_text'=>$phprlang['raids_invite'],
				'start_text'=>$phprlang['raids_start'],
				'freeze_text'=>$phprlang['raids_freeze'],
				'eventtype_text'=>$phprlang['raids_eventtype_text'],
				'location_text'=>$phprlang['raids_location'],
				'description_text'=>$phprlang['raids_description'],
				'limits_text'=>$phprlang['raids_limits'],
				'max_text'=>$phprlang['raids_max'],
				'minlvl_text'=>$phprlang['raids_min_lvl'],
				'maxlvl_text'=>$phprlang['raids_max_lvl'],
			)
		);
		
		// Handle Classes
		$class_array = array();
		foreach ($wrm_global_classes as $global_class)
		{				
			array_push($class_array,
				array(
					'lmt'=>$raid_class_array[$global_class['class_id']],
					'lang_id'=>$phprlang[$global_class['lang_index']],
				)
			);
		}
		$wrmsmarty->assign('class_limits', $class_array);
				
		// Handle Roles
		$role_array = array();
		foreach ($wrm_global_roles as $global_role)	
		{
			array_push($role_array,
				array(
					'lmt'=>$raid_role_array[$global_role['role_id']],
					'lang_id'=>$global_role['role_name'],
				)
			);
		}			
		$wrmsmarty->assign('role_limits', $role_array);	
		
		//
		// Start output of New Raid Or Edit Raid Page
		//
		require_once('includes/page_header.php');
		$wrmsmarty->display('raids_new.html');
		require_once('includes/page_footer.php');		
	}
	else
	{
		// holy crap, time to put it into the database
		// variables first
		$max = scrub_input($_POST['max']);

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

		$min_lvl = scrub_input($_POST['min_lvl']);
		$max_lvl = scrub_input($_POST['max_lvl']);

		$location = scrub_input(DEUBB($_POST['location']));

		$date = scrub_input($_POST['date']);
		$i_time_hour_value = scrub_input($_POST['i_time_hour']);
		$i_time_minute_value = scrub_input($_POST['i_time_minute']);
		$i_time_ampm_value = scrub_input($_POST['i_time_ampm']);
		$s_time_hour_value = scrub_input($_POST['s_time_hour']);
		$s_time_minute_value = scrub_input($_POST['s_time_minute']);
		$s_time_ampm_value = scrub_input($_POST['s_time_ampm']);
		$freeze = scrub_input($_POST['freeze']);
		$tag = scrub_input($_POST['tag']);
		$event_id = scrub_input($_POST['event_id']);
		$description = scrub_input(DEUBB($_POST['description']));
		if(isset($_GET['id']))
			$id = scrub_input($_GET['id']);
		else
			$id = '';

		// setup the date, probably the only tricky tricky part :D
		$month = substr($date,0,2);
		$day = substr($date,3,2);
		$year = substr($date,6,4);

		if($i_time_ampm_value == 'pm' && $i_time_hour_value < 12)
			$i_time_hour_value += 12;

		if($s_time_ampm_value == 'pm' && $s_time_hour_value < 12)
			$s_time_hour_value += 12;

		$invite_time = new_mktime($i_time_hour_value,$i_time_minute_value,0,$month,$day,$year,$phpraid_config['timezone'] + $phpraid_config['dst']);
		$start_time = new_mktime($s_time_hour_value,$s_time_minute_value,0,$month,$day,$year,$phpraid_config['timezone'] + $phpraid_config['dst']);

		if($_GET['mode'] == 'new')
		{
			$sql = sprintf("INSERT INTO " . $phpraid_config['db_prefix'] . "raids (`description`,`freeze`,`invite_time`,
					`location`,`officer`,`old`,`start_time`,
					`min_lvl`,`max_lvl`,`max`,`event_type`,`event_id`)	VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)",
					quote_smart($description),quote_smart($freeze),quote_smart($invite_time),quote_smart($location),
					quote_smart($username),quote_smart('0'),quote_smart($start_time),
					quote_smart($min_lvl),quote_smart($max_lvl),quote_smart($max),quote_smart($tag),quote_smart($event_id));

			$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);

			// Get the Location ID of what was Just Entered to Apply to the Lookup Tables
			$sql = "SELECT raid_id FROM " . $phpraid_config['db_prefix'] . "raids ORDER BY raid_id DESC LIMIT 1";
			$raid_id_result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
			$raid_id = $db_raid->sql_fetchrow($raid_id_result, true);
			
			// Insert Class Data to loc_class_lmt
			foreach ($wrm_global_classes as $global_class)
			{
				$sql = sprintf("INSERT INTO " . $phpraid_config['db_prefix'] . "raid_class_lmt (`raid_id`, `class_id`, `lmt`)
				VALUES (%s,%s,%s)",quote_smart($raid_id['raid_id']), quote_smart($global_class['class_id']), quote_smart($class[$global_class['class_id']]));
				
				$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
			}
			
			// Insert Role Data to loc_role_lmt
			foreach ($wrm_global_roles as $global_role)	
			{
				$sql = sprintf("INSERT INTO " . $phpraid_config['db_prefix'] . "raid_role_lmt (`raid_id`, `role_id`, `lmt`)
				VALUES (%s,%s,%s)",quote_smart($raid_id['raid_id']), quote_smart($global_role['role_id']), quote_smart($role[$global_role['role_id']]));
				
				$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);	
			}
			
			log_create('raid',mysql_insert_id(),$location);
		}
		else
		{
			$sql = sprintf("UPDATE " . $phpraid_config['db_prefix'] . "raids SET location=%s,description=%s,invite_time=%s,start_time=%s,
					freeze=%s,max=%s,event_type=%s,event_id=%s,old='0',min_lvl=%s,max_lvl=%s WHERE raid_id=%s",
					quote_smart($location),quote_smart($description),quote_smart($invite_time),quote_smart($start_time), quote_smart($freeze),
					quote_smart($max),quote_smart($tag),quote_smart($event_id),quote_smart($min_lvl),quote_smart($max_lvl),quote_smart($id));

			$db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);

			// Insert Class Data to loc_class_lmt
			foreach ($wrm_global_classes as $global_class)
			{
				$sql = sprintf("UPDATE " . $phpraid_config['db_prefix'] . "raid_class_lmt SET lmt=%s WHERE raid_id=%s AND class_id=%s",
				quote_smart($class[$global_class['class_id']]), quote_smart($id), quote_smart($global_class['class_id']));
				
				$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
			}
			
			// Insert Role Data to loc_role_lmt
			foreach ($wrm_global_roles as $global_role)	
			{
				$sql = sprintf("UPDATE " . $phpraid_config['db_prefix'] . "raid_role_lmt SET lmt=%s WHERE raid_id=%s AND role_id=%s",
				quote_smart($role[$global_role['role_id']]), quote_smart($id), quote_smart($global_role['role_id']));
				
				$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);	
			}		
		}
		header("Location: raids.php?mode=view");
	}
}
elseif($_GET['mode'] == 'delete')
{
	$id = scrub_input($_GET['id']);
	$n = scrub_input($_GET['n']);

	if(!isset($_POST['submit']))
	{
		$form_action = "raids.php?mode=delete&amp;n=$n&amp;id=$id";
		$confirm_button = '<input name="submit" type="submit" id="submit" value="'.$phprlang['confirm_deletion'].'" class="mainoption">';

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
	}
	else
	{
		log_delete('raid',$n);

		$sql = sprintf("DELETE FROM " . $phpraid_config['db_prefix'] . "raids WHERE raid_id=%s", quote_smart($id));
		$db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);

		$sql = sprintf("DELETE FROM " . $phpraid_config['db_prefix'] . "signups WHERE raid_id=%s", quote_smart($id));
		$db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);

		$sql = sprintf("DELETE FROM " . $phpraid_config['db_prefix'] . "raid_class_lmt WHERE raid_id=%s",quote_smart($id));
		$db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);

		$sql = sprintf("DELETE FROM " . $phpraid_config['db_prefix'] . "raid_role_lmt WHERE raid_id=%s",quote_smart($id));
		$db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
		
		header("Location: raids.php?mode=view");
	}
}
elseif($_GET['mode'] == 'mark')
{
	$raid_id = scrub_input($_GET['id']);

	$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "raids WHERE raid_id=%s", quote_smart($raid_id));
	$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
	$data = $db_raid->sql_fetchrow($result, true);
	
	if($data['old'] == 1)
	{
		$sql = sprintf("UPDATE " . $phpraid_config['db_prefix'] . "raids SET old='0' WHERE raid_id=%s", quote_smart($raid_id));
		$db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
	}
	else
	{
		$sql = sprintf("UPDATE " . $phpraid_config['db_prefix'] . "raids SET old='1' WHERE raid_id=%s", quote_smart($raid_id));
		$db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
	}

	header("Location: raids.php?mode=view");
}

?>