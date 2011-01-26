<?php
/***************************************************************************
 *                           profile_raids.php
 *                        -------------------
 *   begin                : Jan 23, 2011
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
define("PAGE_LVL","profile");
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
	
$pageURL = "profile_raid.php";
$pageURL_edit = $pageURL. '?mode=edit&';
$pageURL_new = $pageURL. '?mode=new';
$pageURL_remove = $pageURL. '?mode=remove&';
$pageURL_view = $pageURL. '?mode=view&';

/**************************************************************
 * End Record Output Setup for Data Table
 **************************************************************/

if($_GET['mode'] == 'view') 
{
	// now that we have their profile_id, let's get a list of all their characters
	$profile_id = scrub_input($_SESSION['profile_id']);

// arrays to hold raid information
$current = array();
$previous = array();
$count = array();
$count2 = array();
$raid_loop_cur = 0;
$raid_loop_prev = 0;

//$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "raids WHERE recurrance = 0";

// Select all raids that are marked current and only the top X raids marked old and throw out any record
//  that has recurrance set to 1.
$sql = "(SELECT * from " . $phpraid_config['db_prefix'] . "raids " .
		"WHERE `old` = 0 " .
		"AND `recurrance` = 0) " .
		"UNION ALL " .
		"(SELECT * FROM " . $phpraid_config['db_prefix'] . "raids " . 
		"WHERE `recurrance` = 0 " .
		"AND `old` = 1 " .
		"ORDER BY `raid_id` DESC " .
		"LIMIT " . $phpraid_config['num_old_raids_index'] . ")";
$raids_result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);

while($raids = $db_raid->sql_fetchrow($raids_result, true))
{
	$invite = get_time_full($raids['invite_time']);
	$start = get_time_full($raids['start_time']);
	$date = $start;
	
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
	
	//Get Raid Total Counts
	$count = get_char_count($raids['raid_id'], $type='');
	$count2 = get_char_count($raids['raid_id'], $type='queue');		
	foreach ($wrm_global_classes as $global_class)
		$total += $count[$global_class['class_id']];
	foreach ($wrm_global_classes as $global_class)
		$total2 += $count2[$global_class['class_id']];
	
	$logged_in=scrub_input($_SESSION['session_logged_in']);
	$priv_profile=scrub_input($_SESSION['priv_profile']);
	$profile_id=scrub_input($_SESSION['profile_id']);

	// check if signed up
	// precendence -> cancelled signup, signed up, raid frozen, open for signup
	if($logged_in == 1 && $priv_profile == 1) 
	{
		if(is_char_cancel($profile_id, $raids['raid_id']))
			$info = '<img src="templates/' . $phpraid_config['template'] . '/images/icons/cancel.gif" border="0" height="14" width="14" onMouseover="ddrivetip(\'' . $phprlang['cancel_msg'] . '\');" onMouseout="hideddrivetip();" alt="cancel icon">';
		else if(is_char_signed($profile_id, $raids['raid_id']))
			$info = '<img src="templates/' . $phpraid_config['template'] . '/images/icons/check_mark.gif" border="0" height="14" width="14" onMouseover="ddrivetip(\'' . $phprlang['signed_up'] . '\');" onMouseout="hideddrivetip();" alt="check mark">';
		else if((check_frozen($raids['raid_id']) && $phpraid_config['disable_freeze'] == 0) or ($raids['old'] != 0))
			$info = '<img src="templates/' . $phpraid_config['template'] . '/images/icons/frozen.gif" border="0" height="14" width="14" onMouseover="ddrivetip(\'' . $phprlang['frozen_msg'] . '\');" onMouseout="hideddrivetip();" alt="frozen">';
		else
		{
			$info  = '<a href="raid_signup.php?mode=signup&amp;raid_id=' . $raids['raid_id'] . '">';
//			$info  = '<a href="view.php?mode=view&amp;raid_id=' . $raids['raid_id'] . '#signup">';
			$info .= '<img src="templates/' . $phpraid_config['template'] . '/images/icons/signup.gif" border="0" height="14" width="14" onMouseover="ddrivetip(\'' . $phprlang['not_signed_up'] . '\');" onMouseout="hideddrivetip();" alt="'.$phprlang['signup'].'">';
			//$info .=  $phprlang['signup'];
			$info .= '</a>';
		}
	}

	$desc = scrub_input($raids['description']);
	$ddrivetiptxt = "'<span class=tooltip_title>" . $phprlang['description'] ."</span><br>" . DEUBB2($desc) . "'";
	$location = '<a href="raid_view.php?mode=view&amp;raid_id=' . $raids['raid_id'] . '" onMouseover="ddrivetip('.$ddrivetiptxt.');" onMouseout="hideddrivetip();">'.$raids['location'].'</a>';
	
	// Now that we have the raid data, we need to retrieve limit data based upon Raid ID.
	// Get Class Limits and set Colored Counts
	$raid_class_array = array();
	$class_color_count = array();
	$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "raid_class_lmt WHERE raid_id = %s", quote_smart($raids['raid_id']));
	$result_raid_class = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
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
	$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "raid_role_lmt WHERE raid_id = %s", quote_smart($raids['raid_id']));
	$result_raid_role = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	while($raid_role_data = $db_raid->sql_fetchrow($result_raid_role, true))
	{
		$sql2 = sprintf("SELECT role_name FROM " . $phpraid_config['db_prefix'] . "roles WHERE role_id = %s", quote_smart($raid_role_data['role_id']));
		$result_role_name = $db_raid->sql_query($sql2) or print_error($sql2, $db_raid->sql_error(), 1);
		$role_name = $db_raid->sql_fetchrow($result_role_name, true);
		
		$raid_role_array[$role_name['role_name']] = $raid_role_data['lmt'];
		$role_color_count[$role_name['role_name']] = get_coloredcount($role_name['role_name'], $count[$raid_role_data['role_id']], $raid_role_array[$role_name['role_name']], $count2[$raid_role_data['role_id']]);
	}
	
	// Get Raid Force Name from Raid Force ID
	$sql = sprintf("SELECT raid_force_name FROM " . $phpraid_config['db_prefix'] . "raid_force WHERE raid_force_id = %s", quote_smart($raids['raid_force_id']));
	$result_raid_force_name = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	$raid_force_name_data = $db_raid->sql_fetchrow($result_raid_force_name, true);
	
	if ($raids['raid_force_id'] == 0)
		$force_name = $phprlang['none'];
	else
		$force_name = $raid_force_name_data['raid_force_name'];
	
	// always show current raids
	if($raids['old'] == 0) {
		array_push($current,
			array(
				'ID'=>$raids['raid_id'],
				'Signup'=>$info,
				'Force Name'=>$force_name,
				'Date'=>$date,
				'Dungeon'=>$location,
				'Invite Time'=>$invite,
				'Start Time'=>$start,
				'Creator'=>$raids['officer'],
				'Totals'=>$total.'/'.$raids['max']  . '(+' . $total2. ')',
			)
		);
		foreach ($class_color_count as $left => $right)
			$current[$raid_loop_cur][$left]= $right;
		foreach ($role_color_count as $left => $right)
			$current[$raid_loop_cur][$left]= $right;
		$raid_loop_cur++;		
	}
}

/**************************************************************
 * Code to setup for a Dynamic Table Create: raids1 View.
 **************************************************************/
$viewName = 'index1';

//Setup Columns
$raid_headers = array();
$record_count_array = array();
$raid_headers = getVisibleColumns($viewName);

//Get Record Counts
$curr_record_count_array = getRecordCounts($current, $raid_headers, $startRecord);


//Get the Jump Menu and pass it down
$currJumpMenu = getPageNavigation($current, $startRecord, $pageURL, $sortField, $sortDesc);

		
//Setup Default Data Sort from Headers Table
if (!$initSort)
	foreach ($raid_headers as $column_rec)
		if ($column_rec['default_sort'])
			$sortField = $column_rec['column_name'];

//Setup Data
$current = paginateSortAndFormat($current, $sortField, $sortDesc, $startRecord, $viewName);


/****************************************************************
 * Data Assign for Template.
 ****************************************************************/
$wrmsmarty->assign('new_data', $current); 
$wrmsmarty->assign('current_jump_menu', $currJumpMenu);
$wrmsmarty->assign('column_name', $raid_headers);
$wrmsmarty->assign('curr_record_counts', $curr_record_count_array);
$wrmsmarty->assign('header_data',
	array(
		'template_name'=>$phpraid_config['template'],
		'old_raids_header' => $phprlang['raids_old'],
		'new_raids_header' => $phprlang['raids_new'],
		'sort_url_base' => $pageURL,
		'sort_descending' => $sortDesc,
		'sort_text' => $phprlang['sort_text'],
	)
);
	
	// time to get a list of raids that they've signed up for
	$raid_list = array();
	$count = array();
	$count2 = array();
	$raid_loop_cur = 0;
	$raid_loop_prev = 0;
	
	$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "signups WHERE profile_id=%s", quote_smart($profile_id));
	$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	while($signups = $db_raid->sql_fetchrow($result, true))
	{
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
		
		$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "raids WHERE raid_id=%s", quote_smart($signups['raid_id']));
		$result_raid = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
		$data = $db_raid->sql_fetchrow($result_raid, true);
		
		//$desc = strip_tags($data['description']);
		//$desc = UBB($desc);
		$desc = scrub_input($data['description']);
		$ddrivetiptxt = "'<span class=tooltip_title>" . $phprlang['description'] ."</span><br>" . DEUBB2($desc) . "'";
		$location = '<a href="raid_view.php?mode=view&amp;raid_id='.$data['raid_id'].'"
					 onMouseover="ddrivetip('.$ddrivetiptxt.');" onMouseout="hideddrivetip();">'.$data['location'].'</a>';

		// convert unix timestamp to something readable
		$invite = get_time_full($data['invite_time']);
		$start = get_time_full($data['start_time']);
		$date = $start;

		//Get Raid Total Counts
		$count = get_char_count($data['raid_id'], $type='');
		$count2 = get_char_count($data['raid_id'], $type='queue');		

		foreach ($wrm_global_classes as $global_class)
			$total += $count[$global_class['class_id']];
		foreach ($wrm_global_classes as $global_class)
			$total2 += $count2[$global_class['class_id']];
			
		//foreach ($count as $class_count)
		//	$total += $class_count;
		//foreach ($count2 as $class_queue_count)
		//	$total2 += $class_queue_count;

		// Now that we have the raid data, we need to retrieve limit data based upon Raid ID.
		// Get Class Limits and set Colored Counts
		$raid_class_array = array();
		$class_color_count = array();
		$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "raid_class_lmt WHERE raid_id = %s", quote_smart($data['raid_id']));
		$result_raid_class = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
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
		$result_raid_role = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
		while($raid_role_data = $db_raid->sql_fetchrow($result_raid_role, true))
		{
			$sql2 = sprintf("SELECT role_name FROM " . $phpraid_config['db_prefix'] . "roles WHERE role_id = %s", quote_smart($raid_role_data['role_id']));
			$result_role_name = $db_raid->sql_query($sql2) or print_error($sql2, $db_raid->sql_error(), 1);
			$role_name = $db_raid->sql_fetchrow($result_role_name, true);
			
			$raid_role_array[$role_name['role_name']] = $raid_role_data['lmt'];
			$role_color_count[$role_name['role_name']] = get_coloredcount($role_name['role_name'], $count[$raid_role_data['role_id']], $raid_role_array[$role_name['role_name']], $count2[$raid_role_data['role_id']]);
		}
		
		// current raids
		if($data['old'] == 0) {
			array_push($raid_list,
				array(
					'ID'=>$data['raid_id'],
					'Date'=>$date,
					'Dungeon'=>$location,
					'Invite Time'=>$invite,
					'Start Time'=>$start,
					'Creator'=>$data['officer'],
					'Totals'=>$total.'/'.$data['max']  . '(+' . $total2. ')',
					'Buttons'=>''
				)
			);
			foreach ($class_color_count as $left => $right)
				$raid_list[$raid_loop_cur][$left]= $right;
			foreach ($role_color_count as $left => $right)
				$raid_list[$raid_loop_cur][$left]= $right;
			$raid_loop_cur++;
		}
	}

	/**************************************************************
	 * Code to setup for a Dynamic Table Create: guild1 View.
	 **************************************************************/
	$viewName = 'raids1';
	
	//Setup Columns
	$raid_headers = array();
	$record_count_array = array();
	$raid_headers = getVisibleColumns($viewName);
	
	//Get Record Counts
	$raid_record_count_array = getRecordCounts($raid_list, $char_headers, $startRecord);
	
	//Get the Jump Menu and pass it down
	$raidJumpMenu = getPageNavigation($raid_list, $startRecord, $pageURL, $sortField, $sortDesc);
			
	//Setup Default Data Sort from Headers Table
	if (!$initSort)
		foreach ($raid_headers as $column_rec)
			if ($column_rec['default_sort'])
				$sortField = $column_rec['column_name'];
	
	//Setup Data
	$raid_list = paginateSortAndFormat($raid_list, $sortField, $sortDesc, $startRecord, $viewName);

	$form_action = $pageURL_new;
	/****************************************************************
	 * Data Assign for Template.
	 ****************************************************************/
	$wrmsmarty->assign('raid_data', $raid_list); 
	$wrmsmarty->assign('raid_jump_menu', $raidJumpMenu);
	$wrmsmarty->assign('raid_column_name', $raid_headers);
	$wrmsmarty->assign('raid_record_counts', $raid_record_count_array);
	$wrmsmarty->assign('header_data',
		array(
			'form_action' => $form_action,
			'template_name'=>$phpraid_config['template'],
			'character_header' => $phprlang['profile_header'],
			'raid_header' => $phprlang['profile_raid'],
			'sort_url_base' => $pageURL,
			'sort_descending' => $sortDesc,
			'sort_text' => $phprlang['sort_text'],
			'button_addchar' => $phprlang['addchar'],
		)
	);

	require_once('includes/page_header.php');
	$wrmsmarty->display('profile_raid.html');
	require_once('includes/page_footer.php');
			
}

?>