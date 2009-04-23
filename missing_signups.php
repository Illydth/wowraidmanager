<?php
/***************************************************************************
 *                            missing_signups.php
 *                            -------------------
 *   begin                : Monday, Jul 28, 2008
 *   copyright            : (C) 2007-2008 Douglas Wagner
 *   email                : douglasw@wagnerweb.org
 *
 *   $Id: missing_signups.php,v 1.0 2008/07/28 16:03:22 psotfx Exp $
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

isset($_GET['raid_id']) ? $raid_id = scrub_input($_GET['raid_id']) : $raid_id = '';

if($raid_id == '')
	log_hack();

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
		
$pageURL = 'missing_signups.php?raid_id=' . $raid_id;
/**************************************************************
 * End Record Output Setup for Data Table
 **************************************************************/
	
// Set the Guild Server for the Page.
//$server = $phpraid_config['guild_server'];

$users = array();
//$signed_profile_id_arr = array();
//$profile_list_arr = array();
//$not_in_signed_arr = array();

// Get a list of all Profiles that are NOT currently signed up for this raid. 
// Update: We can't use "NOT IN" because MySQL 4.0 doesn't support it (MUTTER).  We've got to do it
//   with left joins.  Solution found on net.
//$sql = sprintf("SELECT profile_id, username, last_login_time FROM " . $phpraid_config['db_prefix'] . "profile " .
//		"WHERE profile_id NOT IN " .
//		    "(SELECT profile_id FROM " . $phpraid_config['db_prefix'] . "signups " .
//		     "WHERE raid_id = %s)", quote_smart($raid_id));

$sql = sprintf("SELECT a.profile_id, a.username, a.last_login_time " .
				"FROM " . $phpraid_config['db_prefix'] . "profile AS a " . 
				"LEFT JOIN " . $phpraid_config['db_prefix'] . "signups ON a.profile_id = " . $phpraid_config['db_prefix'] . "signups.profile_id " .
				    "AND " . $phpraid_config['db_prefix'] . "signups.raid_id = %s " .
				"WHERE " . $phpraid_config['db_prefix'] . "signups.profile_id IS NULL", quote_smart($raid_id));

$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);

while($data = $db_raid->sql_fetchrow($result, true))
{
	$usersname = '<!-- ' . strtolower($data['username']) . ' --><a href="users.php?mode=details&amp;user_id='.$data['profile_id'].'">'.$data['username'].'</a>';

	$date = !($data['last_login_time'])?'':new_date('Y/m/d H:i:s',$data['last_login_time'],$phpraid_config['timezone'] + $phpraid_config['dst']);
	$time = !($data['last_login_time'])?'':new_date('Y/m/d H:i:s',$data['last_login_time'],$phpraid_config['timezone'] + $phpraid_config['dst']);
	
	array_push($users, 
		array(
			'ID'=>$data['profile_id'],
			'Username'=>$usersname,
			'Last Login Date'=>$date,
			'Last Login Time'=>$time,
			));
}

/**************************************************************
 * Code to setup for a Dynamic Table Create: roster1 View.
 **************************************************************/
$viewName = 'users1';
	
//Setup Columns
$missing_headers = array();
$missing_record_count_array = array();
$missing_headers = getVisibleColumns($viewName);

//Get Record Counts
$missing_record_count_array = getRecordCounts($users, $raid_headers, $startRecord);
	
//Get the Jump Menu and pass it down
$missingJumpMenu = getPageNavigation($users, $startRecord, $pageURL, $sortField, $sortDesc);
			
//Setup Default Data Sort from Headers Table
if (!$initSort)
	foreach ($missing_headers as $column_rec)
		if ($column_rec['default_sort'])
			$sortField = $column_rec['column_name'];

//Setup Data
$users = paginateSortAndFormat($users, $sortField, $sortDesc, $startRecord, $viewName);

/****************************************************************
 * Data Assign for Template.
 ****************************************************************/
$wrmsmarty->assign('users_data', $users); 
$wrmsmarty->assign('users_jump_menu', $missingJumpMenu);
$wrmsmarty->assign('column_name', $missing_headers);
$wrmsmarty->assign('users_record_counts', $missing_record_count_array);
$wrmsmarty->assign('header_data',
	array(
		'template_name'=>$phpraid_config['template'],
		'users_header'=>$phprlang['users_header'],
		'sort_url_base' => $pageURL,
		'sort_descending' => $sortDesc,
		'sort_text' => $phprlang['sort_text'],
	)
);

//
// Start output of page
//
require_once('includes/page_header.php');
$wrmsmarty->display('users.html');
require_once('includes/page_footer.php');
?>