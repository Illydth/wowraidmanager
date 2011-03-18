<?php
/***************************************************************************
 *                                index.php
 *                            -------------------
 *   begin                : Saturday, Jan 16, 2005
 *   copyright            : (C) 2007-2008 Douglas Wagner
 *   email                : douglasw@wagnerweb.org
 *
 *   $Id: index.php,v 2.00 2008/03/04 17:15:50 psotfx Exp $
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

while($raids = $db_raid->sql_fetchrow($raids_result, true)) {

        // Auto Mark Raids as old if raid start time is X hours old or more. - Istari
        // This now uses $phpraid_config['auto_mark_raids_old'] setting. - Istari
        $raid_id = $raids['raid_id'];
        if ($raids['start_time'] < (mktime() - (3600*$phpraid_config['auto_mark_raids_old']))) {
                $sql = sprintf("UPDATE " . $phpraid_config['db_prefix'] . "raids SET old='1' WHERE raid_id=%s", quote_smart($raid_id));
                $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
        }
		
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
		if(is_char_cancel($profile_id, $raids['raid_id'])){
			//$info = '<img src="templates/' . $phpraid_config['template'] . '/images/icons/cancel.gif" border="0" height="14" width="14" onMouseover="ddrivetip(\'' . $phprlang['cancel_msg'] . '\');" onMouseout="hideddrivetip();" alt="cancel icon">';
			$info = '<img src="templates/' . $phpraid_config['template'] . '/images/icons/cancel.gif" border="0" height="14" width="14" alt="cancel icon" />';
			$msg = $phprlang['cancel_msg'];
			$url = 'view.php?mode=view&amp;raid_id='.$raids['raid_id'];
		}
		else if(is_char_signed($profile_id, $raids['raid_id'])){
			//$info = '<img src="templates/' . $phpraid_config['template'] . '/images/icons/check_mark.gif" border="0" height="14" width="14" onMouseover="ddrivetip(\'' . $phprlang['signed_up'] . '\');" onMouseout="hideddrivetip();" alt="check mark">';
			$info = '<img src="templates/' . $phpraid_config['template'] . '/images/icons/check_mark.gif" border="0" height="14" width="14" alt="check mark" />';
			$msg = $phprlang['signed_up'];
			$url = 'view.php?mode=view&amp;raid_id='.$raids['raid_id'];
		}
		else if((check_frozen($raids['raid_id']) && $phpraid_config['disable_freeze'] == 0) or ($raids['old'] != 0)) {
			//$info = '<img src="templates/' . $phpraid_config['template'] . '/images/icons/frozen.gif" border="0" height="14" width="14" onMouseover="ddrivetip(\'' . $phprlang['frozen_msg'] . '\');" onMouseout="hideddrivetip();" alt="frozen">';
			$info = '<img src="templates/' . $phpraid_config['template'] . '/images/icons/frozen.gif" border="0" height="14" width="14" alt="frozen" />';
			$msg = $phprlang['frozen_msg'];
			$url = 'view.php?mode=view&amp;raid_id='.$raids['raid_id'];
		}
		else
		{
			//$info  = '<a href="view.php?mode=view&amp;raid_id=' . $raids['raid_id'] . '#signup">';
			//$info .= '<img src="templates/' . $phpraid_config['template'] . '/images/icons/signup.gif" border="0" height="14" width="14" onMouseover="ddrivetip(\'' . $phprlang['not_signed_up'] . '\');" onMouseout="hideddrivetip();" alt="'.$phprlang['signup'].'">';
			$info = '<img src="templates/' . $phpraid_config['template'] . '/images/icons/signup.gif" border="0" height="14" width="14"  alt="'.$phprlang['signup'].'" />';
			$msg =  $phprlang['not_signed_up'];
			$url = 'view.php?mode=view&amp;raid_id='.$raids['raid_id'].'#signup';
			//$info .= '</a>';
		}
		//$img = '<img src="templates/'.$phpraid_config['template'].'/images/icons/icon_delete.gif" border="0" alt="delete icon" />';
		$info = cssToolTip($info, $msg, 'mediumIconText', $url);
	}

	//$desc = scrub_input($raids['description']);
	//$ddrivetiptxt = "'<span class=tooltip_title>" . $phprlang['description'] ."</span><br>" . DEUBB2($desc) . "'";
	//$location = '<a href="view.php?mode=view&amp;raid_id=' . $raids['raid_id'] . '" onMouseover="ddrivetip('.$ddrivetiptxt.');" onMouseout="hideddrivetip();">'.$raids['location'].'</a>';
	$url = 'view.php?mode=view&amp;raid_id=' . $raids['raid_id'];
	//$location=create_comment_popup($phprlang['description'], $raids['description'], $url, $raids['location']);
	$location=cssToolTip($raids['location'], $raids['description'], 'custom comment', $url, $phprlang['description']);
	
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
	} else {
		array_push($previous,
			array(
				'ID'=>$raids['raid_id'],
				'Signup'=>$info,
				'Force Name'=>$force_name,
				'Date'=>$date,
				'Dungeon'=>$raids['location'],
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
$viewName = 'index1';

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
		
//Setup Default Data Sort from Headers Table
if (!$initSort)
	foreach ($raid_headers as $column_rec)
		if ($column_rec['default_sort'])
			$sortField = $column_rec['column_name'];

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
		'old_raids_header' => $phprlang['raids_old'],
		'new_raids_header' => $phprlang['raids_new'],
		'sort_url_base' => $pageURL,
		'sort_descending' => $sortDesc,
		'sort_text' => $phprlang['sort_text'],
	)
);

// now for announcements
// get announcements
$announcements = array();
$announcement_header=$phprlang['announcements_header'];
$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "announcements";
$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
if($db_raid->sql_numrows($result) > 0)
{
	/* fetch rows in reverse order */
	$i = $db_raid->sql_numrows($result) - 1;
	while($i >= 0) 
	{
		$db_raid->sql_rowseek($i, $result);
		$data = $db_raid->sql_fetchrow($result, true);
		$time = new_date($phpraid_config['time_format'], $data['timestamp'],$phpraid_config['timezone'] + $phpraid_config['dst']);
		$date = new_date($phpraid_config['date_format'], $data['timestamp'],$phpraid_config['timezone'] + $phpraid_config['dst']);
	
		array_push($announcements,
			array(
				'announcement_author'=>$data['posted_by'],
				'announcement_date'=>$date,
				'announcement_time'=>$time,
				'announcement_msg'=>linebreak_to_br($data['message']),
				'announcement_title'=>$data['title'],
			)
		);
		
		$i--;
	}
	
	$wrmsmarty->assign('announcement_header', $announcement_header);	
	$wrmsmarty->assign('announcement_data', $announcements);	
}
//
// Start output of the page.
//
require_once('includes/page_header.php');
$wrmsmarty->display('main_page.html');
require_once('includes/page_footer.php');

?>