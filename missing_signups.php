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
			'id'=>$data['profile_id'],
			'username'=>$usersname,
			'last_login_date'=>$date,
			'last_login_time'=>$time,
			));
}

// setup output
setup_output();
$report->showRecordCount(true);
$report->allowPaging(true, $_SERVER['PHP_SELF'] . '?raid_id='. $raid_id . '&Base=');
$report->setListRange($_GET['Base'], 25);
$report->allowLink(ALLOW_HOVER_INDEX,'',array());

//Default sorting
if(!$_GET['Sort'])
{
	$report->allowSort(true, 'id', '0', 'users.php?mode=view');
}
else
{
	$report->allowSort(true, $_GET['Sort'], $_GET['SortDescending'], 'users.php?mode=view');
}

if($phpraid_config['show_id'] == 1)
	$report->addOutputColumn('id',$phprlang['id'],'','center');
$report->addOutputColumn('username',$phprlang['username'],'','center');
$report->addOutputColumn('last_login_date',$phprlang['last_login_date'],'wrmdate','center');
$report->addOutputColumn('last_login_time',$phprlang['last_login_time'],'wrmtime','center');
$users = $report->getListFromArray($users);

$page->set_file('body_file',$phpraid_config['template'] . '/users.htm');

$page->set_var(
	array('users'=>$users,
		'header'=>$phprlang['users_header'])
);

$page->parse('output','body_file');

//
// Start output of page
//
require_once('includes/page_header.php');

$page->p('output');

require_once('includes/page_footer.php');
?>