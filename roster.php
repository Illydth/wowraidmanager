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

// for now, we'll let everyone view the character list
$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "chars";
$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
$chars = array();
		
// get all the chars and throw them in that nice array for 
// output by the report class
while($data = $db_raid->sql_fetchrow($result)) {
	array_push($chars,
		array(
			'id'=>$data['char_id'],
			'Name'=>$data['name'],
			'Guild'=>$data['guild'],
			'Level'=>$data['lvl'],
			'Race'=>$data['race'],
			'Class'=>$data['class'],
			'Arcane'=>$data['arcane'],
			'Fire'=>$data['fire'],
			'Frost'=>$data['frost'],
			'Nature'=>$data['nature'],
			'Shadow'=>$data['shadow']
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
	$report->allowSort(true, 'Name', 'ASC', 'roster.php');
}
else
{
	$report->allowSort(true, $_GET['Sort'], $_GET['SortDescending'], 'roster.php');
}

$report->showRecordCount(true);
if($phpraid_config['show_id'] == 1)
	$report->addOutputColumn('id',$phprlang['id'],'','center');
$report->addOutputColumn('Name',$phprlang['name'],'','center');
$report->addOutputColumn('Guild',$phprlang['guild'],'','center');
$report->addOutputColumn('Level',$phprlang['level'],'','center');
$report->addOutputColumn('Race',$phprlang['race'],'','center');
$report->addOutputColumn('Class',$phprlang['class'],'','center');
$report->addOutputColumn('Arcane','<img border="0" src="templates/' . $phpraid_config['template'] . '/images/resistances/arcane_resistance.gif" onMouseover="ddrivetip(\''.$phprlang['arcane'].'\')"; onMouseout="hideddrivetip()" height="16" width="16">','','center');
$report->addOutputColumn('Fire','<img border="0" src="templates/' . $phpraid_config['template'] . '/images/resistances/fire_resistance.gif" onMouseover="ddrivetip(\''.$phprlang['fire'].'\')"; onMouseout="hideddrivetip()" height="16" width="16">','','center');
$report->addOutputColumn('Nature','<img border="0" src="templates/' . $phpraid_config['template'] . '/images/resistances/nature_resistance.gif" onMouseover="ddrivetip(\''.$phprlang['nature'].'\')"; onMouseout="hideddrivetip()" height="16" width="16">','','center');
$report->addOutputColumn('Frost','<img border="0" src="templates/' . $phpraid_config['template'] . '/images/resistances/frost_resistance.gif" onMouseover="ddrivetip(\''.$phprlang['frost'].'\')"; onMouseout="hideddrivetip()" height="16" width="16">','','center');
$report->addOutputColumn('Shadow','<img border="0" src="templates/' . $phpraid_config['template'] . '/images/resistances/shadow_resistance.gif" onMouseover="ddrivetip(\''.$phprlang['shadow'].'\')"; onMouseout="hideddrivetip()" height="16" width="16">','','center');
$report->allowPaging(true, $_SERVER['PHP_SELF'] . '?Base=');
$report->setListRange($_GET['Base'], 25);
$body = $report->getListFromArray($chars);

//
// Start output of page
//
require_once('includes/page_header.php');
	
$page->set_file(array(
	'output' => $phpraid_config['template'] . '/roster.htm')
);

$page->set_var(
	array(
		'roster' => $body,
		'header' => $phprlang['roster_header']
	)
);

$page->pparse('output','output');

require_once('includes/page_footer.php');
?>