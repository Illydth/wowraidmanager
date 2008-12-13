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
if(!isset($_GET['Sort']))
	$sortField="";
else
	$sortField = scrub_input($_GET['Sort']);
	
// Set Sort Descending Mark
if(!isset($_GET['SortDescending']) || !is_numeric($_GET['SortDescending']))
	$sortDesc = 1;
else
	$sortDesc = scrub_input($_GET['SortDescending']);
	
$pageURL = 'index.php?mode=view&';
/**************************************************************
 * End Record Output Setup for Data Table
 **************************************************************/

// arrays to old raid information
$current = array();
$previous = array();

$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "raids";
$raids_result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);

$count = array();

while($raids = $db_raid->sql_fetchrow($raids_result, true)) {
	$invite = new_date('Y/m/d H:i:s', $raids['invite_time'],$phpraid_config['timezone'] + $phpraid_config['dst']);
	$start = new_date('Y/m/d H:i:s', $raids['start_time'],$phpraid_config['timezone'] + $phpraid_config['dst']);
	$date = $start;
	
	$count = get_char_count($raids['raid_id'], $type='');
	$count2 = get_char_count($raids['raid_id'], $type='queue');

	//Drafted maximum
	$total = $count['dk'] + $count['dr'] + $count['hu'] + $count['ma'] + $count['pa'] + $count['pr'] + $count['ro'] + $count ['sh'] + $count['wk'] + $count['wa'];
	
	//Queued Additional
	$total2 = $count2['dk'] + $count2['dr'] + $count2['hu'] + $count2['ma'] + $count2['pa'] + $count2['pr'] + $count2['ro'] + $count2['sh'] + $count2['wk'] + $count2['wa'];

	if($total == "")
	{
		$total = "0";
	}		
	
	if($total2 == "")
	{
		$total2 = "";
	}
	else
	{
		$total2 = " (+$total2)";
	}

	$logged_in=scrub_input($_SESSION['session_logged_in']);
	$priv_profile=scrub_input($_SESSION['priv_profile']);
	$profile_id=scrub_input($_SESSION['profile_id']);

	// check if signed up
	// precendence -> cancelled signup, signed up, raid frozen, open for signup
	if($logged_in == 1 && $priv_profile == 1) {
		if(is_char_cancel($profile_id, $raids['raid_id']))
			$info = '<img src="templates/' . $phpraid_config['template'] . '/images/icons/cancel.gif" border="0" height="14" width="14" onMouseover="ddrivetip(\'' . $phprlang['cancel_msg'] . '\');" onMouseout="hideddrivetip();" alt="cancel icon">';
		else if(is_char_signed($profile_id, $raids['raid_id']))
			$info = '<img src="templates/' . $phpraid_config['template'] . '/images/icons/check_mark.gif" border="0" height="14" width="14" onMouseover="ddrivetip(\'' . $phprlang['signed_up'] . '\');" onMouseout="hideddrivetip();" alt="check mark">';
		else if(check_frozen($raids['raid_id']) && $phpraid_config['disable_freeze'] == 0)
			$info = '<img src="templates/' . $phpraid_config['template'] . '/images/icons/frozen.gif" border="0" height="14" width="14" onMouseover="ddrivetip(\'' . $phprlang['frozen_msg'] . '\');" onMouseout="hideddrivetip();" alt="frozen">';
		else
			$info = '<a href="view.php?mode=view&amp;raid_id=' . $raids['raid_id'] . '#signup">'. $phprlang['signup'] .'</a>';
		//	$info = '<a href="view.php?mode=view&amp;raid_id=' . $raids['raid_id'] . '#signup"><img src="templates/' . $phpraid_config['template'] . '/images/icons/signup.gif" border="0" height="14" width="14" onMouseover="ddrivetip(\'' . $phprlang['not_signed_up'] . '\')"; onMouseout="hideddrivetip()"></a>';
	}

	$desc = scrub_input($raids['description']);
	$ddrivetiptxt = "'<span class=tooltip_title>" . $phprlang['description'] ."</span><br>" . DEUBB2($desc) . "'";
	$location = '<a href="view.php?mode=view&amp;raid_id=' . $raids['raid_id'] . '" onMouseover="ddrivetip('.$ddrivetiptxt.');" onMouseout="hideddrivetip();">'.$raids['location'].'</a>';
	
	if($phpraid_config['class_as_min'])
	{
		$dk_text = get_coloredcount('death knight', $count['dk'], $raids['dk_lmt'], $count2['dk'], true);
		$dr_text = get_coloredcount('druid', $count['dr'], $raids['dr_lmt'], $count2['dr'], true);
		$hu_text = get_coloredcount('hunter', $count['hu'], $raids['hu_lmt'], $count2['hu'], true);
		$ma_text = get_coloredcount('mage', $count['ma'], $raids['ma_lmt'], $count2['ma'], true);
		$pa_text = get_coloredcount('paladin', $count['pa'], $raids['pa_lmt'], $count2['pa'], true);
		$pr_text = get_coloredcount('priest', $count['pr'], $raids['pr_lmt'], $count2['pr'], true);
		$ro_text = get_coloredcount('rogue', $count['ro'], $raids['ro_lmt'], $count2['ro'], true);
		$sh_text = get_coloredcount('shaman', $count['sh'], $raids['sh_lmt'], $count2['sh'], true);
		$wk_text = get_coloredcount('warlock', $count['wk'], $raids['wk_lmt'], $count2['wk'], true);
		$wa_text = get_coloredcount('warrior', $count['wa'], $raids['wa_lmt'], $count2['wa'], true);
		$role1_text = get_coloredcount('role1', $count['role1'], $raids['role1_lmt'], $count2['role1']);
		$role2_text = get_coloredcount('role2', $count['role2'], $raids['role2_lmt'], $count2['role2']);
		$role3_text = get_coloredcount('role3', $count['role3'], $raids['role3_lmt'], $count2['role3']);
		$role4_text = get_coloredcount('role4', $count['role4'], $raids['role4_lmt'], $count2['role4']);
		$role5_text = get_coloredcount('role5', $count['role5'], $raids['role5_lmt'], $count2['role5']);
		$role6_text = get_coloredcount('role6', $count['role6'], $raids['role6_lmt'], $count2['role6']);
	}
	else
	{
		$dk_text = get_coloredcount('death knight', $count['dk'], $raids['dk_lmt'], $count2['dk']);
		$dr_text = get_coloredcount('druid', $count['dr'], $raids['dr_lmt'], $count2['dr']);
		$hu_text = get_coloredcount('hunter', $count['hu'], $raids['hu_lmt'], $count2['hu']);
		$ma_text = get_coloredcount('mage', $count['ma'], $raids['ma_lmt'], $count2['ma']);
		$pa_text = get_coloredcount('paladin', $count['pa'], $raids['pa_lmt'], $count2['pa']);
		$pr_text = get_coloredcount('priest', $count['pr'], $raids['pr_lmt'], $count2['pr']);
		$ro_text = get_coloredcount('rogue', $count['ro'], $raids['ro_lmt'], $count2['ro']);
		$sh_text = get_coloredcount('shaman', $count['sh'], $raids['sh_lmt'], $count2['sh']);
		$wk_text = get_coloredcount('warlock', $count['wk'], $raids['wk_lmt'], $count2['wk']);
		$wa_text = get_coloredcount('warrior', $count['wa'], $raids['wa_lmt'], $count2['wa']);
		$role1_text = get_coloredcount('role1', $count['role1'], $raids['role1_lmt'], $count2['role1']);
		$role2_text = get_coloredcount('role2', $count['role2'], $raids['role2_lmt'], $count2['role2']);
		$role3_text = get_coloredcount('role3', $count['role3'], $raids['role3_lmt'], $count2['role3']);
		$role4_text = get_coloredcount('role4', $count['role4'], $raids['role4_lmt'], $count2['role4']);
		$role5_text = get_coloredcount('role5', $count['role5'], $raids['role5_lmt'], $count2['role5']);
		$role6_text = get_coloredcount('role6', $count['role6'], $raids['role6_lmt'], $count2['role6']);
	}
	
	// always show current raids
	if($raids['old'] == 0) {
		array_push($current,
			array(
				'ID'=>$raids['raid_id'],
				'Signup'=>$info,
				'Date'=>$date,
				//'Dungeon'=>UBB2($location),
				'Dungeon'=>$location,
				'Invite Time'=>$invite,
				'Start Time'=>$start,
				'Creator'=>$raids['officer'],
				'Death Knight'=>$dk_text,
				'Druid'=>$dr_text,
				'Hunter'=>$hu_text,
				'Mage'=>$ma_text,
				'Paladin'=>$pa_text,
				'Priest'=>$pr_text,
				'Rogue'=>$ro_text,
				'Shaman'=>$sh_text,
				'Warlock'=>$wk_text,
				'Warrior'=>$wa_text,
				$phpraid_config['role1_name']=>$role1_text,
				$phpraid_config['role2_name']=>$role2_text,
				$phpraid_config['role3_name']=>$role3_text,
				$phpraid_config['role4_name']=>$role4_text,
				$phpraid_config['role5_name']=>$role5_text,
				$phpraid_config['role6_name']=>$role6_text,
				'Totals'=>$total.'/'.$raids['max']  . '' . $total2,
			)
		);
	} else {
		array_push($previous,
			array(
				'ID'=>$raids['raid_id'],
				'Signup'=>$info,
				'Date'=>$date,
				'Dungeon'=>$raids['location'],
				'Invite Time'=>$invite,
				'Start Time'=>$start,
				'Creator'=>$raids['officer'],
				'Death Knight'=>$dk_text,
				'Druid'=>$dr_text,
				'Hunter'=>$hu_text,
				'Mage'=>$ma_text,
				'Paladin'=>$pa_text,
				'Priest'=>$pr_text,
				'Rogue'=>$ro_text,
				'Shaman'=>$sh_text,
				'Warlock'=>$wk_text,
				'Warrior'=>$wa_text,
				$phpraid_config['role1_name']=>$role1_text,
				$phpraid_config['role2_name']=>$role2_text,
				$phpraid_config['role3_name']=>$role3_text,
				$phpraid_config['role4_name']=>$role4_text,
				$phpraid_config['role5_name']=>$role5_text,
				$phpraid_config['role6_name']=>$role6_text,
				'Totals'=>$total.'/'.$raids['max']  . '' . $total2,
			)
		);
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
	$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
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