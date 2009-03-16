<?php
/***************************************************************************
 *                              roster.php
 *                            ---------------
 *   begin                : Thursday, May 25, 2006
 *   copyright            : (C) 2007 - 2008 Douglas Wagner
 *   email                : douglasw@wagnerweb.org
 *
 *   $Id: roster.php,v 2.00 2008/03/10 01:16:26 psotfx Exp $
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
define("PAGE_LVL","anonymous");
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
		
$pageURL = 'roster.php?';
/**************************************************************
 * End Record Output Setup for Data Table
 **************************************************************/

// Set the Guild Server for the Page.
$server = $phpraid_config['guild_server'];

// for now, we'll let everyone view the character list
$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "chars";
$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
$chars = array();
		
// get all the chars and throw them in that nice array for 
// output by the report class
while($data = $db_raid->sql_fetchrow($result, true)) {
	$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "profile WHERE profile_id=" . $data['profile_id'];
	$data_result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
	$data_profdetail = $db_raid->sql_fetchrow($data_result);
	
	if ($phpraid_config['enable_armory'])
		$charname = get_armorychar($data['name'], $phpraid_config['armory_language'], $server);
	else
		$charname = $data['name'];
		
	array_push($chars,
		array(
			'ID'=>$data['char_id'],
			'Name'=> $charname,
			'Guild'=>$data['guild'],
			'Level'=>$data['lvl'],
			'Race'=>$data['race'],
			'Class'=>$data['class'],
			'Role'=>$data['role'],
			'Arcane'=>$data['arcane'],
			'Fire'=>$data['fire'],
			'Frost'=>$data['frost'],
			'Nature'=>$data['nature'],
			'Shadow'=>$data['shadow'],
			'Profile'=>'<a href="users.php?mode=details&amp;user_id=' . $data['profile_id'] . '">' . $data_profdetail['username'] . '</a>'
		)
	);
}

/**************************************************************
 * Code to setup for a Dynamic Table Create: roster1 View.
 **************************************************************/
$viewName = 'roster1';
	
//Setup Columns
$roster_headers = array();
$record_count_array = array();
$roster_headers = getVisibleColumns($viewName);

//Get Record Counts
$roster_record_count_array = getRecordCounts($chars, $raid_headers, $startRecord);
	
//Get the Jump Menu and pass it down
$rosterJumpMenu = getPageNavigation($chars, $startRecord, $pageURL, $sortField, $sortDesc);

//Setup Data
$chars = paginateSortAndFormat($chars, $sortField, $sortDesc, $startRecord, $viewName);

/****************************************************************
 * Data Assign for Template.
 ****************************************************************/
$wrmsmarty->assign('roster_data', $chars); 
$wrmsmarty->assign('roster_jump_menu', $rosterJumpMenu);
$wrmsmarty->assign('column_name', $roster_headers);
$wrmsmarty->assign('roster_record_counts', $roster_record_count_array);
$wrmsmarty->assign('header_data',
	array(
		'template_name'=>$phpraid_config['template'],
		'roster_header' => $phprlang['roster_header'],
		'sort_url_base' => $pageURL,
		'sort_descending' => $sortDesc,
		'sort_text' => $phprlang['sort_text'],
	)
);

// output the information
//setup_output();

//$report->showRecordCount(true);
//$report->allowPaging(true, $_SERVER['PHP_SELF'] . '?mode=view&Base=');
//$report->setListRange($_GET['Base'], 25);
//$report->allowLink(ALLOW_HOVER_INDEX,'',array());

//Default sorting
//if(!$_GET['Sort'])
//{
//	$report->allowSort(true, 'Name', 'ASC', 'roster.php');
//}
//else
//{
//	$report->allowSort(true, $_GET['Sort'], $_GET['SortDescending'], 'roster.php');
//}

//$report->showRecordCount(true);
//if($phpraid_config['show_id'] == 1)
//	$report->addOutputColumn('id',$phprlang['id'],'','center');
//$report->addOutputColumn('Name',$phprlang['name'],'','center');
//$report->addOutputColumn('Guild',$phprlang['guild'],'','center');
//$report->addOutputColumn('Level',$phprlang['level'],'','center');
//$report->addOutputColumn('Race',$phprlang['race'],'','center');
//$report->addOutputColumn('Class',$phprlang['class'],'','center');
//$report->addOutputColumn('Role',$phprlang['role'],'','center');
//$report->addOutputColumn('Arcane','<img border="0" src="templates/' . $phpraid_config['template'] . '/images/resistances/arcane_resistance.gif" onMouseover="ddrivetip(\''.$phprlang['arcane'].'\');" onMouseout="hideddrivetip();" height="16" width="16" alt="arcane">','','center');
//$report->addOutputColumn('Fire','<img border="0" src="templates/' . $phpraid_config['template'] . '/images/resistances/fire_resistance.gif" onMouseover="ddrivetip(\''.$phprlang['fire'].'\');" onMouseout="hideddrivetip();" height="16" width="16" alt="fire">','','center');
//$report->addOutputColumn('Nature','<img border="0" src="templates/' . $phpraid_config['template'] . '/images/resistances/nature_resistance.gif" onMouseover="ddrivetip(\''.$phprlang['nature'].'\');" onMouseout="hideddrivetip();" height="16" width="16" alt="nature">','','center');
//$report->addOutputColumn('Frost','<img border="0" src="templates/' . $phpraid_config['template'] . '/images/resistances/frost_resistance.gif" onMouseover="ddrivetip(\''.$phprlang['frost'].'\');" onMouseout="hideddrivetip();" height="16" width="16" alt="frost">','','center');
//$report->addOutputColumn('Shadow','<img border="0" src="templates/' . $phpraid_config['template'] . '/images/resistances/shadow_resistance.gif" onMouseover="ddrivetip(\''.$phprlang['shadow'].'\');" onMouseout="hideddrivetip();" height="16" width="16" alt="shadow">','','center');
//if (scrub_input($_SESSION['priv_users']) == 1)
//	$report->addOutputColumn('Profile', $phprlang['profile'], '', 'center');
//$report->allowPaging(true, $_SERVER['PHP_SELF'] . '?Base=');
//$report->setListRange($_GET['Base'], 25);
//$body = $report->getListFromArray($chars);

//
// Start output of page
//
require_once('includes/page_header.php');
	
//$page->set_file(array(
//	'output' => $phpraid_config['template'] . '/roster.htm')
//);

//$page->set_var(
//	array(
//		'roster' => $body,
//		'header' => $phprlang['roster_header']
//	)
//);

//$page->pparse('output','output');
$wrmsmarty->display('roster.html');
require_once('includes/page_footer.php');
?>