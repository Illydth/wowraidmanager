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

global $db_dkp, $errorTitle, $errorMsg, $errorDie;

/*---------- (eqdkp) web link + text -------------------------*/

$eqdkp_text_link = $phprlang['eqdkp_system_link'] . '<a href="'.$phpraid_config['eqdkp_url'].'/listmembers.php?s="> >-LINK-< </a>';

/*------------------------------------*/

$db_dkp = &new sql_db($phpraid_config['eqdkp_db_host'],$phpraid_config['eqdkp_db_user'],$phpraid_config['eqdkp_db_pass'],$phpraid_config['eqdkp_db_name']);

if(!$db_dkp->db_connect_id) 
{
	$txtproblem = "There appears to be a problem with the database server.<br>We should be back up shortly.";
	die('<div align="center">'.$txtproblem.'<strong></strong></div>');	
}

// view the character list
$sql = "SELECT * FROM " . $phpraid_config['eqdkp_db_prefix'] . "members, " . $phpraid_config['eqdkp_db_prefix'] . "classes WHERE " . $phpraid_config['eqdkp_db_prefix'] . "classes.class_id = " . $phpraid_config['eqdkp_db_prefix'] . "members.member_class_id";

$result = $db_dkp->sql_query($sql) or print_error($sql, mysql_error(), 1);
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
			'id'=>$data['member_id'],
			'Name'=>$namelink,
			'Earned'=>$data['member_earned'],
			'Spent'=>$data['member_spent'],
			'Adjustment'=>$data['member_adjustment'],
			'Class'=>$tmpclass,
			'Dkp_Now'=> $tmp
		)
	);
}

// output the information
setup_output();

$report->showRecordCount(true);
$report->allowPaging(true, $_SERVER['PHP_SELF'] . '?mode=view&Base=');
$report->setListRange($_GET['Base'], 25);
$report->allowLink(ALLOW_HOVER_INDEX,'',array());

//Default sorting
if(!$_GET['Sort'])
{
	$report->allowSort(true, 'Name', 'ASC', 'dkp_view.php');
}
else
{
	$report->allowSort(true, $_GET['Sort'], $_GET['SortDescending'], 'dkp_view.php');
}

$report->showRecordCount(true);
if($phpraid_config['show_id'] == 1)
	$report->addOutputColumn('id',$phprlang['id'],'','center');
$report->addOutputColumn('Name',$phprlang['name'],'','center');
$report->addOutputColumn('Class',$phprlang['class'],'','center');
$report->addOutputColumn('Earned',$phprlang['earned'],'','center');
$report->addOutputColumn('Spent',$phprlang['spent'],'','center');
$report->addOutputColumn('Adjustment',$phprlang['adjustment'],'','center');
$report->addOutputColumn('Dkp_Now',$phprlang['dkp'],'','center');
$report->allowPaging(true, $_SERVER['PHP_SELF'] . '?Base=');
$report->setListRange($_GET['Base'], 25);
$body = $report->getListFromArray($members);

//
// Start output of page
//
require_once('includes/page_header.php');
	
$page->set_file(array(
	'output' => $phpraid_config['template'] . '/dkp_view.htm')
);

$page->set_var(
	array(
		'roster' => $body,
		'header' => $phprlang['dkp'],
		'dkp_link' => $eqdkp_text_link
	)
);

$page->pparse('output','output');

require_once('includes/page_footer.php');
?>