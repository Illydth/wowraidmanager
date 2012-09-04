<?php
/***************************************************************************
 *                             raidsarchive.php
 *                            -------------------
 *	 Dev                  : Carsten Hölbing
 *	 email                : carsten@hoelbing.net
 *
 *   -- WoW Raid Manager --
 *   copyright            : (C) 2007-2009 Douglas Wagner
 *   email                : douglasw0@yahoo.com
 *   www				  : http://www.wowraidmanager.net
 *
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
if($phpraid_config['anon_view'] == 1)
	define("PAGE_LVL","anonymous");
else
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
	
$pageURL = 'index.php?mode=view&';
/**************************************************************
 * End Record Output Setup for Data Table
 **************************************************************/

// arrays to hold raid information
$current = array();
$previous = array();
$count = array();
$count2 = array();
$raid_loop_cur = 0;
$raid_loop_prev = 0;

$sql = "SELECT * ".
		" FROM " . $phpraid_config['db_prefix'] . "raids ".
		" WHERE old = 1 ".
		" AND `gamepack_id` = ".$phpraid_config['gamepack_id']." ".
		" ORDER BY start_time DESC";
$raids_result = $db_raid->sql_query($sql) or $no_old = TRUE;

while($raids = $db_raid->sql_fetchrow($raids_result, true)) {
	$invite = new_date('Y/m/d H:i:s', $raids['invite_time'],$phpraid_config['timezone'] + $phpraid_config['dst']);
	$start = new_date('Y/m/d H:i:s', $raids['start_time'],$phpraid_config['timezone'] + $phpraid_config['dst']);
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
	//	if(is_char_cancel($profile_id, $raids['raid_id']))
	//		$info = '<img src="templates/' . $phpraid_config['template'] . '/images/icons/cancel.gif" border="0" height="14" width="14" onMouseover="ddrivetip(\'' . $phprlang['cancel_msg'] . '\');" onMouseout="hideddrivetip();" alt="cancel icon">';
	//	else if(is_char_signed($profile_id, $raids['raid_id']))
	//		$info = '<img src="templates/' . $phpraid_config['template'] . '/images/icons/check_mark.gif" border="0" height="14" width="14" onMouseover="ddrivetip(\'' . $phprlang['signed_up'] . '\');" onMouseout="hideddrivetip();" alt="check mark">';
//		if(check_frozen($raids['raid_id']) && $phpraid_config['disable_freeze'] == 0)
//			$info = '<img src="templates/' . $phpraid_config['template'] . '/images/icons/frozen.gif" border="0" height="14" width="14" onMouseover="ddrivetip(\'' . $phprlang['frozen_msg'] . '\');" onMouseout="hideddrivetip();" alt="frozen">';
	//	else
	//		$info = '<a href="view.php?mode=view&amp;raid_id=' . $raids['raid_id'] . '#signup">'. $phprlang['signup'] .'</a>';
	}

//	$desc = scrub_input($raids['description']);
//	$ddrivetiptxt = "'<span class=tooltip_title>" . $phprlang['description'] ."</span><br>" . DEUBB2($desc) . "'";
	//$location = $raids['location'];

	$raid_date = new_date($phpraid_config['date_format'],$raids['start_time'],$phpraid_config['timezone'] + $phpraid_config['dst']);
	$raid_start_time = new_date($phpraid_config['time_format'],$raids['start_time'],$phpraid_config['timezone'] + $phpraid_config['dst']);
	$raid_invite_time = new_date($phpraid_config['time_format'],$raids['invite_time'],$phpraid_config['timezone'] + $phpraid_config['dst']);		
	
	//$desc = scrub_input($raids['description']);
	//$desc = str_replace("'", "\'", $desc);
	//$raid_txt_desc = "'<span class=tooltip_title>" . $phprlang['description'] ."</span><br>" . DEUBB2($desc);
	$raid_txt_info = "------------------";
	$raid_txt_info .= "<br>".$phprlang['location'].":".$raids['location'];
	$raid_txt_info .= "<br>".$phprlang['officer'].":".$raids['officer'];
	$raid_txt_info .= "<br>".$phprlang['date'].":".$raid_date;
	$raid_txt_info .= "<br>".$phprlang['start_time'].":".$raid_start_time;
	$raid_txt_info .= "<br>".$phprlang['invite_time'].":".$raid_invite_time;
	$raid_txt_info .= "<br>".$phprlang['totals'].": ".$total.'/'.$raids['max']  . ' (+' . $total2. ')';
	$popupdesc = $raids['description'].'<br>'. $raid_txt_info."'";
	//$location = '<a href="view.php?mode=view&amp;raid_id='.$raids['raid_id'].'" onMouseover="ddrivetip('.$ddrivetiptxt.');" onMouseout="hideddrivetip();">'.$raids['location'].'</a>';	
	$url = 'view.php?mode=view&amp;raid_id=' . $raids['raid_id'];
	//$location=create_comment_popup($phprlang['description'], $popupdesc, $url, $raids['location']);
	$location=cssToolTip($raids['location'], $popupdesc,'custom comment', $url, $phprlang['description']);

	// Now that we have the raid data, we need to retrieve limit data based upon Raid ID.
	// Get Class Limits and set Colored Counts
	$raid_class_array = array();
	$class_color_count = array();
	$sql = sprintf("SELECT * ".
					" FROM " . $phpraid_config['db_prefix'] . "raid_class_lmt ".
					" WHERE raid_id = %s", 
					quote_smart($raids['raid_id'])
			);
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
	$sql = sprintf("SELECT * ".
					" FROM " . $phpraid_config['db_prefix'] . "raid_role_lmt ".
					" WHERE raid_id = %s", quote_smart($raids['raid_id']));
	$result_raid_role = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	while($raid_role_data = $db_raid->sql_fetchrow($result_raid_role, true))
	{
		$sql2 = sprintf("SELECT role_name ".
						" FROM " . $phpraid_config['db_prefix'] . "roles ".
						" WHERE role_id = %s", 
						quote_smart($raid_role_data['role_id'])
				);
		$result_role_name = $db_raid->sql_query($sql2) or print_error($sql2, $db_raid->sql_error(), 1);
		$role_name = $db_raid->sql_fetchrow($result_role_name, true);
		
		$raid_role_array[$role_name['role_name']] = $raid_role_data['lmt'];
		$role_color_count[$role_name['role_name']] = get_coloredcount($role_name['role_name'], $count[$raid_role_data['role_id']], $raid_role_array[$role_name['role_name']], $count2[$raid_role_data['role_id']]);
	}
	
	if($raids['old'] == 1) {
		array_push($previous,
			array(
				'ID'=>$raids['raid_id'],
				//'Signup'=>$info,
				'Force Name'=>$raids['raid_force_name'],
				'Date'=>$date,
				'Dungeon'=>UBB2($location),
				//'Dungeon'=>$raids['location'],
				'Invite Time'=>$invite,
				'Start Time'=>$start,
				'Creator'=>$raids['officer'],
				'Totals'=>$total.'/'.$raids['max']  . '(+' . $total2. ')',
			)
		);
		foreach ($class_color_count as $left => $right)
			$previous[$raid_loop_prev][$left]= $right;
		foreach ($role_color_count as $left => $right)
			$previous[$raid_loop_prev][$left]= $right;
		$raid_loop_prev++;
	}
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
//	$curr_record_count_array = getRecordCounts($current, $raid_headers, $startRecord);
	$prev_record_count_array = getRecordCounts($previous, $raid_headers, $startRecord);
	
	//Get the Jump Menu and pass it down
//	$currJumpMenu = getPageNavigation($current, $startRecord, $pageURL, $sortField, $sortDesc);
	$prevJumpMenu = getPageNavigation($previous, $startRecord, $pageURL, $sortField, $sortDesc);
			
	//Setup Default Data Sort from Headers Table
	if (!$initSort)
		foreach ($raid_headers as $column_rec)
			if ($column_rec['default_sort'])
				$sortField = $column_rec['column_name'];
	
	//Setup Data
//	$current = paginateSortAndFormat($current, $sortField, $sortDesc, $startRecord, $viewName);
	$previous = paginateSortAndFormat($previous, $sortField, $sortDesc, $startRecord, $viewName);

	/****************************************************************
	 * Data Assign for Template.
	 ****************************************************************/
//	$wrmsmarty->assign('new_data', $current); 
	$wrmsmarty->assign('old_data', $previous);
//	$wrmsmarty->assign('current_jump_menu', $currJumpMenu);
	$wrmsmarty->assign('previous_jump_menu', $prevJumpMenu);
	$wrmsmarty->assign('column_name', $raid_headers);
//	$wrmsmarty->assign('curr_record_counts', $curr_record_count_array);
	$wrmsmarty->assign('prev_record_counts', $prev_record_count_array);
	$wrmsmarty->assign('header_data',
		array(
			'template_name'=>$phpraid_config['template'],
			'gamepack_name' => $phpraid_config['gamepack_name'],				
			'raidsarchive_header' => $phprlang['raidsarchive_header'],
			//'new_raids_header' => $phprlang['raids_new'],
			'sort_url_base' => $pageURL,
			'sort_descending' => $sortDesc,
			'sort_text' => $phprlang['sort_text'],
		)
	);
	
	//
	// Start output of the page.
	//
	require_once('includes/page_header.php');
	$wrmsmarty->display('raidsarchive.html');
	require_once('includes/page_footer.php');

?>