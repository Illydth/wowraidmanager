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
	$max = $count['dr'] + $count['hu'] + $count['ma'] + $count['pa'] + $count['pr'] + $count['ro'] + $count ['sh'] + $count['wk'] + $count['wa'];
	
	//Queued Additional
	$max2 = $count2['dr'] + $count2['hu'] + $count2['ma'] + $count2['pa'] + $count2['pr'] + $count2['ro'] + $count2['sh'] + $count2['wk'] + $count2['wa'];

	if($max == "")
	{
		$max = "0";
	}		
	
	if($max2 == "")
	{
		$max2 = "";
	}
	else
	{
		$max2 = " (+$max2)";
	}

	$logged_in=scrub_input($_SESSION['session_logged_in']);
	$priv_profile=scrub_input($_SESSION['priv_profile']);
	$profile_id=scrub_input($_SESSION['profile_id']);

	// check if signed up
	// precendence -> cancelled signup, signed up, raid frozen, open for signup
	if($logged_in == 1 && $priv_profile == 1) {
		if(is_char_cancel($profile_id, $raids['raid_id']))
			$info = '<img src="templates/' . $phpraid_config['template'] . '/images/icons/cancel.gif" border="0" height="14" width="14" onMouseover="ddrivetip(\'' . $phprlang['cancel_msg'] . '\')"; onMouseout="hideddrivetip()">';
		else if(is_char_signed($profile_id, $raids['raid_id']))
			$info = '<img src="templates/' . $phpraid_config['template'] . '/images/icons/check_mark.gif" border="0" height="14" width="14" onMouseover="ddrivetip(\'' . $phprlang['signed_up'] . '\')"; onMouseout="hideddrivetip()">';
		else if(check_frozen($raids['raid_id']) && $phpraid_config['disable_freeze'] == 0)
			$info = '<img src="templates/' . $phpraid_config['template'] . '/images/icons/frozen.gif" border="0" height="14" width="14" onMouseover="ddrivetip(\'' . $phprlang['frozen_msg'] . '\')"; onMouseout="hideddrivetip()">';
		else
			$info = '<a href="view.php?mode=view&raid_id=' . $raids['raid_id'] . '#signup">'. $phprlang['signup'] .'</a>';
		//	$info = '<a href="view.php?mode=view&raid_id=' . $raids['raid_id'] . '#signup"><img src="templates/' . $phpraid_config['template'] . '/images/icons/signup.gif" border="0" height="14" width="14" onMouseover="ddrivetip(\'' . $phprlang['not_signed_up'] . '\')"; onMouseout="hideddrivetip()"></a>';
	}
	
	$location = '<a href="view.php?mode=view&raid_id=' . $raids['raid_id'] . '">' . $raids['location'] . '</a>';
	
	//Code Specific to Nalumis	
	//$minustkmel = 0;
	//$tank = get_coloredcount($count['tank'], $count2['tank'], $raids['tank_lmt'], 0, $count['tkmel'] + $count2['tkmel'], 0, 0, 0, $minustkmel);
	//$heal = get_coloredcount($count['heal'], $count2['heal'], $raids['heal_lmt'], 0, 0, 0, 0, 0, $minustkmel);
	//$merk_minustkmel = $minustkmel;
	//$melee = get_coloredcount($count['melee'], $count2['melee'], $raids['melee_lmt'], 2, $count['tkmel'] + $count2['tkmel'] - $minustkmel, $count['melee'] + $count['ranged'], $count2['melee'] + $count2['ranged'], $raids['melee_lmt'] + $raids['ranged_lmt'], $minustkmel);
	//$minustkmel = $merk_minustkmel;
	//$ranged = get_coloredcount($count['ranged'], $count2['ranged'], $raids['ranged_lmt'], 2, $count['tkmel'] + $count2['tkmel'] - $minustkmel, $count['melee'] + $count['ranged'], $count2['melee'] + $count2['ranged'], $raids['melee_lmt'] + $raids['ranged_lmt'], $minustkmel);
	//$tkmel = get_coloredcount($count['tkmel'], $count2['tkmel'], $raids['tkmel_lmt'], 1, 0, 0, 0, 0, $minustkmel);
	
	if($phpraid_config['class_as_min'])
	{
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
				'id'=>$raids['raid_id'],
				'Info'=>$info,
				'Date'=>$date,
				'Location'=>UBB2($location),
				'Invite Time'=>$invite,
				'Start Time'=>$start,
				'Officer'=>$raids['officer'],
				'dr'=>$dr_text,
				'hu'=>$hu_text,
				'ma'=>$ma_text,
				'pa'=>$pa_text,
				'pr'=>$pr_text,
				'ro'=>$ro_text,
				'sh'=>$sh_text,
				'wk'=>$wk_text,
				'wa'=>$wa_text,
				'role1'=>$role1_text,
				'role2'=>$role2_text,
				'role3'=>$role3_text,
				'role4'=>$role4_text,
				'role5'=>$role5_text,
				'role6'=>$role6_text,
				//'Tank'=>$tank,'Heal'=>$heal,'Melee'=>$melee,'Ranged'=>$ranged,'TkMel'=>$tkmel,
				'max'=>$max . '/' . $raids['max'] . '' . $max2,
				'info'=>$info,
				'raid'=>$raids['raid_id']
			)
		);
	} else {
		array_push($previous,
			array(
				'id'=>$raids['raid_id'],
				'Info'=>$info,
				'Date'=>$date,
				'Location'=>UBB2($raids['location']),
				'Invite Time'=>$invite,
				'Start Time'=>$start,
				'Officer'=>$raids['officer'],
				'dr'=>$count['dr'] . '/' . $raids['dr_lmt'],
				'hu'=>$count['hu'] . '/' . $raids['hu_lmt'],
				'ma'=>$count['ma'] . '/' . $raids['ma_lmt'],
				'pa'=>$count['pa'] . '/' . $raids['pa_lmt'],
				'pr'=>$count['pr'] . '/' . $raids['pr_lmt'],
				'ro'=>$count['ro'] . '/' . $raids['ro_lmt'],
				'sh'=>$count['sh'] . '/' . $raids['sh_lmt'],
				'wk'=>$count['wk'] . '/' . $raids['wk_lmt'],
				'wa'=>$count['wa'] . '/' . $raids['wa_lmt'],
				'role1'=>$count['role1'] . '/' . $raids['role1_lmt'],
				'role2'=>$count['role2'] . '/' . $raids['role2_lmt'],
				'role3'=>$count['role3'] . '/' . $raids['role3_lmt'],
				'role4'=>$count['role4'] . '/' . $raids['role4_lmt'],
				'role5'=>$count['role5'] . '/' . $raids['role5_lmt'],
				'role6'=>$count['role6'] . '/' . $raids['role6_lmt'],
				//'Tank'=>$tank,'Heal'=>$heal,'Melee'=>$melee,'Ranged'=>$ranged,'TkMel'=>$tkmel,
				'max'=>$max . '/' . $raids['max'] . '' . $max2,
				'info'=>$info,
				'raid'=>$raids['raid_id']
			)
		);
	}
}
// setup formatting for report class (THANKS to www.thecalico.com)
// generic settings
setup_output();

$report->showRecordCount(true);
$report->allowPaging(true, $_SERVER['PHP_SELF'] . '?mode=view&Base=');
$report->setListRange($_GET['Base'], 25);
$report->allowLink(ALLOW_HOVER_INDEX,'',array());

//Default sorting
$sort=scrub_input($_GET['Sort']);
$sort_desc=scrub_input($_GET['SortDescending']);
if(!$sort)
{
	$report->allowSort(true, 'Date', 'ASC', 'index.php');
}
else
{
	$report->allowSort(true, $sort, $sort_desc, 'index.php');
}

// and now to format each column output
// the report class makes it very easy to use icons (or whatever) instead of just text
$report->addOutputColumn('info','','','left');
if($phpraid_config['show_id'] == 1)
	$report->addOutputColumn('id',$phprlang['id'],'','center');
$report->addOutputColumn('Date',$phprlang['date'],'wrmdate','center');
$report->addOutputColumn('Location',$phprlang['location'],'','center');
$report->addOutputColumn('Invite Time',$phprlang['invite_time'],'wrmtime','center');
$report->addOutputColumn('Start Time',$phprlang['start_time'],'wrmtime','center');
$report->addOutputColumn('Officer',$phprlang['officer'],'','center');
$report->addOutputColumn('dr', '<img src="templates/' . $phpraid_config['template'] . '/images/classes/druid_icon.gif" border="0" height="18" width="18" onMouseover="ddrivetip(\'' . $phprlang['sort_text'] . $phprlang['druid'] . '\')"; onMouseout="hideddrivetip()">', '', 'center');
$report->addOutputColumn('hu', '<img src="templates/' . $phpraid_config['template'] . '/images/classes/hunter_icon.gif" border="0" height="18" width="18" onMouseover="ddrivetip(\'' . $phprlang['sort_text'] . $phprlang['hunter'] . '\')"; onMouseout="hideddrivetip()">', '', 'center');
$report->addOutputColumn('ma', '<img src="templates/' . $phpraid_config['template'] . '/images/classes/mage_icon.gif" border="0" height="18" width="18" onMouseover="ddrivetip(\'' . $phprlang['sort_text'] . $phprlang['mage'] . '\')"; onMouseout="hideddrivetip()">', '', 'center');
$report->addOutputColumn('pa', '<img src="templates/' . $phpraid_config['template'] . '/images/classes/paladin_icon.gif" border="0" height="18" width="18" onMouseover="ddrivetip(\'' . $phprlang['sort_text'] . $phprlang['paladin'] . '\')"; onMouseout="hideddrivetip()">', '', 'center');
$report->addOutputColumn('pr', '<img src="templates/' . $phpraid_config['template'] . '/images/classes/priest_icon.gif" border="0" height="18" width="18" onMouseover="ddrivetip(\'' . $phprlang['sort_text'] . $phprlang['priest'] . '\')"; onMouseout="hideddrivetip()">', '', 'center');
$report->addOutputColumn('ro', '<img src="templates/' . $phpraid_config['template'] . '/images/classes/rogue_icon.gif" border="0" height="18" width="18" onMouseover="ddrivetip(\'' . $phprlang['sort_text'] . $phprlang['rogue'] . '\')"; onMouseout="hideddrivetip()">', '', 'center');
$report->addOutputColumn('sh', '<img src="templates/' . $phpraid_config['template'] . '/images/classes/shaman_icon.gif" border="0" height="18" width="18" onMouseover="ddrivetip(\'' . $phprlang['sort_text'] . $phprlang['shaman'] . '\')"; onMouseout="hideddrivetip()">', '', 'center');
$report->addOutputColumn('wk', '<img src="templates/' . $phpraid_config['template'] . '/images/classes/warlock_icon.gif" border="0" height="18" width="18" onMouseover="ddrivetip(\'' . $phprlang['sort_text'] . $phprlang['warlock'] . '\')"; onMouseout="hideddrivetip()">', '', 'center');
$report->addOutputColumn('wa', '<img src="templates/' . $phpraid_config['template'] . '/images/classes/warrior_icon.gif" border="0" height="18" width="18" onMouseover="ddrivetip(\'' . $phprlang['sort_text'] . $phprlang['warrior'] . '\')"; onMouseout="hideddrivetip()">', '', 'center');
//$report->addOutputColumn('Tank',$phprlang['role_tanks'],'','center');
//$report->addOutputColumn('Tank','<img src="templates/' . $phpraid_config['template'] . '/images/classes/warrior_icon.gif" border="0" height="18" width="18" onMouseover="ddrivetip(\'' . $phprlang['sort_text'] . $phprlang['role_tanks'] . '\')"; onMouseout="hideddrivetip()">','','center');
//$report->addOutputColumn('Heal','<img src="templates/' . $phpraid_config['template'] . '/images/classes/priest_icon.gif" border="0" height="18" width="18" onMouseover="ddrivetip(\'' . $phprlang['sort_text'] . $phprlang['role_heals'] . '\')"; onMouseout="hideddrivetip()">','','center');
//$report->addOutputColumn('Melee','<img src="templates/' . $phpraid_config['template'] . '/images/classes/rogue_icon.gif" border="0" height="18" width="18" onMouseover="ddrivetip(\'' . $phprlang['sort_text'] . $phprlang['role_melees'] . '\')"; onMouseout="hideddrivetip()">','','center');
//$report->addOutputColumn('Ranged','<img src="templates/' . $phpraid_config['template'] . '/images/classes/mage_icon.gif" border="0" height="18" width="18" onMouseover="ddrivetip(\'' . $phprlang['sort_text'] . $phprlang['role_ranges'] . '\')"; onMouseout="hideddrivetip()">','','center');
//$report->addOutputColumn('TkMel','<img src="templates/' . $phpraid_config['template'] . '/images/classes/druid_icon.gif" border="0" height="18" width="18" onMouseover="ddrivetip(\'' . $phprlang['sort_text'] . $phprlang['role_tankmelees'] . '\')"; onMouseout="hideddrivetip()">','','center');
if ($phpraid_config['role1_name'] != '')
	$report->addOutputColumn('role1',$phpraid_config['role1_name'],'','center');
if ($phpraid_config['role2_name'] != '')
	$report->addOutputColumn('role2',$phpraid_config['role2_name'],'','center');
if ($phpraid_config['role3_name'] != '')
	$report->addOutputColumn('role3',$phpraid_config['role3_name'],'','center');
if ($phpraid_config['role4_name'] != '')
	$report->addOutputColumn('role4',$phpraid_config['role4_name'],'','center');
if ($phpraid_config['role5_name'] != '')
	$report->addOutputColumn('role5',$phpraid_config['role5_name'],'','center');
if ($phpraid_config['role6_name'] != '')
	$report->addOutputColumn('role6',$phpraid_config['role6_name'],'','center');
$report->addOutputColumn('max',$phprlang['totals'],'','center');

// and finally, put the data into the variables to be read
$current = $report->getListFromArray($current);
$previous = $report->getListFromArray($previous);

//
// Start output of page
//
require_once('includes/page_header.php');

$page->set_file(array(
	'body_file' => $phpraid_config['template'] . '/main_page.htm')
);

$page->set_var(
	array(
		'new_raids'=>$current,
		'old_raids'=>$previous,
		'upcoming_raids'=>$phprlang['main_upcoming_raids'],
		'previous_raids'=>$phprlang['main_previous_raids'],
		)
);

// now for announcements
// get announcements
$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "announcements";
$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
if($db_raid->sql_numrows($result) > 0)
{
	$page->set_file('announceFile',$phpraid_config['template'] . '/announcements_msg.htm');
	$page->set_block('announceFile','announcement_row','ARow');
	
	/* fetch rows in reverse order */
	$i = $db_raid->sql_numrows($result) - 1;
	while($i >= 0) 
	{
		$db_raid->sql_rowseek($i, $result);
		$data = $db_raid->sql_fetchrow($result, true);
		$time = new_date($phpraid_config['time_format'], $data['timestamp'],$phpraid_config['timezone'] + $phpraid_config['dst']);
		$date = new_date($phpraid_config['date_format'], $data['timestamp'],$phpraid_config['timezone'] + $phpraid_config['dst']);
		
		$page->set_var(
			array(
				'announcement_header'=>$phprlang['announcements_header'],
				'announcement_author'=>$data['posted_by'],
				'announcement_date'=>$date,
				'announcement_time'=>$time,
				'announcement_msg'=>$data['message'],
				'announcement_title'=>$data['title'],
			)
		);
		
		$page->parse('ARow','announcement_row',true);
		
		$i--;
	}
	$page->parse('body','announceFile',true);
}
$page->parse('body','body_file',true);

$page->p('body');

require_once('includes/page_footer.php');
?>