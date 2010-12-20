<?php
/***************************************************************************
 *                             dkp_view.php
 *                            -------------------
 *   begin                : April 05, 2008
 *	 Dev                  : Carsten Hölbing
 *	 email                : hoelbin@gmx.de
 *
 ***************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
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
	
$pageURL = 'dkp_view.php?';
/**************************************************************
 * End Record Output Setup for Data Table
 **************************************************************/

global $db_dkp, $errorTitle, $errorMsg, $errorDie;

/*---------- (eqdkp) web link + text -------------------------*/

$eqdkp_text_link = $phprlang['eqdkp_system_link'] . '<a href="'.$phpraid_config['eqdkp_url'].'/listmembers.php?s="> >-LINK-< </a>';

/*------------------------------------*/

if ($phpraid_config['persistent_db'] == TRUE)
	$db_dkp = &new sql_db($phpraid_config['eqdkp_db_host'],$phpraid_config['eqdkp_db_user'],$phpraid_config['eqdkp_db_pass'],$phpraid_config['eqdkp_db_name'], TRUE, TRUE);
else
	$db_dkp = &new sql_db($phpraid_config['eqdkp_db_host'],$phpraid_config['eqdkp_db_user'],$phpraid_config['eqdkp_db_pass'],$phpraid_config['eqdkp_db_name'], TRUE, FALSE);

if(!$db_dkp->db_connect_id) 
{
	$txtproblem = "There appears to be a problem with the database server.<br>We should be back up shortly.";
	die('<div align="center">'.$txtproblem.'<strong></strong></div>');	
}

// view the character list
$sql = "SELECT * FROM " . $phpraid_config['eqdkp_db_prefix'] . "members, " . $phpraid_config['eqdkp_db_prefix'] . "classes WHERE " . $phpraid_config['eqdkp_db_prefix'] . "classes.class_id = " . $phpraid_config['eqdkp_db_prefix'] . "members.member_class_id";

$result = $db_dkp->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
$members = array();

		
// get all the chars and throw them in that nice array for 
// output by the report class
while($data = $db_dkp->sql_fetchrow($result)) {

	$tmp = (($data['member_earned'] - $data['member_spent']) + $data['member_adjustment']);
	if ($tmp == 0) $tmp = '0';

	$tmpclass = $phprlang[strtolower($data['class_name'])];
	if ($tmpclass == "") $tmpclass = $data['class_name'];
	
	//Calculate name link.
	$namelink = '<a href="'.$phpraid_config['eqdkp_url'].'/viewmember.php?s=&name='.$data['member_name'].'">'.$data['member_name'].'</a>';
	
	array_push($members,
		array(
			'ID'=>$data['member_id'],
			'Name'=>$namelink,
			'Earned'=>$data['member_earned'],
			'Spent'=>$data['member_spent'],
			'Adjustment'=>$data['member_adjustment'],
			'Class'=>$tmpclass,
			'DKP'=> $tmp
		)
	);
}

/**************************************************************
 * Code to setup for a Dynamic Table Create: raids1 View.
 **************************************************************/
$viewName = 'dkp1';
	
//Setup Columns
$members_headers = array();
$record_count_array = array();
$members_headers = getVisibleColumns($viewName);

//Get Record Counts
$members_record_count_array = getRecordCounts($members, $members_headers, $startRecord);
	
//Get the Jump Menu and pass it down
$membersJumpMenu = getPageNavigation($members, $startRecord, $pageURL, $sortField, $sortDesc);
			
//Setup Default Data Sort from Headers Table
if (!$initSort)
	foreach ($members_headers as $column_rec)
		if ($column_rec['default_sort'])
			$sortField = $column_rec['column_name'];

//Setup Data
$members = paginateSortAndFormat($members, $sortField, $sortDesc, $startRecord, $viewName);

/****************************************************************
 * Data Assign for Template.
 ****************************************************************/
$wrmsmarty->assign('members', $members); 
$wrmsmarty->assign('members_jump_menu', $membersJumpMenu);
$wrmsmarty->assign('column_name', $members_headers); // "column_name" needs to stay static
$wrmsmarty->assign('members_record_counts', $members_record_count_array);
// "header_data" below needs to stay static
$wrmsmarty->assign('header_data',
	array(
		'header' => $phprlang['dkp'],
		'dkp_link' => $eqdkp_text_link,
		'template_name'=>$phpraid_config['template'],
		'sort_url_base' => $pageURL,
		'sort_descending' => $sortDesc,
		'sort_text' => $phprlang['sort_text'],
	)
);

//
// Start output of page
//
require_once('includes/page_header.php');
$wrmsmarty->display('dkp_view.html');
require_once('includes/page_footer.php');

?>