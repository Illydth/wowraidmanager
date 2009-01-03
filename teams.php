<?php
/***************************************************************************
 *                              teams.php
 *                            -------------------
 *   begin                : Monday, July 2, 2007
 *   copyright            : (C) 2007-2008 Douglas Wagner
 *   email                : douglasw@wagnerweb.org
 *
 *   $Id: teams.php,v 2.00 2008/03/08 15:36:47 psotfx Exp $
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
if ($phpraid_config['enable_five_man'])
{
	define("PAGE_LVL","profile");
}
else
{
	define("PAGE_LVL","raids");
}
require_once("includes/authentication.php");

// check for valid input of raid_id
if(!isset($_GET['raid_id']) || !is_numeric($_GET['raid_id']))
	log_hack();

// check for mode passing
isset($_GET['mode']) ? $mode = $_GET['mode'] : $mode = '';

if($mode == '')
	log_hack();

// check for invalid raid passed
isset($_GET['raid_id']) ? $raid_id = scrub_input($_GET['raid_id']) : $raid_id = '';

if($raid_id == '' || !is_numeric($raid_id))
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
if(!isset($_GET['Sort']))
	$sortField="";
else
	$sortField = scrub_input($_GET['Sort']);
	
// Set Sort Descending Mark
if(!isset($_GET['SortDescending']) || !is_numeric($_GET['SortDescending']))
	$sortDesc = 1;
else
	$sortDesc = scrub_input($_GET['SortDescending']);
	
$pageURL = 'teams.php?mode=view&raid_id='.$raid_id.'&';
/**************************************************************
 * End Record Output Setup for Data Table
 **************************************************************/

// Set the Guild Server for the Page.
$server = $phpraid_config['guild_server'];

//View Mode, display the page with Current Data.
if($mode == 'view')
{
	$current_teams = array();
	
	//**********************************************
	//Setup the "New Team" Form
	//**********************************************
	$wrmsmarty->assign('new_team_fields', 
		array(
			'team_new_header'=>$phprlang['team_new_header'],
			'raid_id'=>$raid_id,
			'global_raid_text'=>$phprlang['team_global'],
			'addbuttontext'=>$phprlang['add'],
			'resetbuttontext'=>$phprlang['reset']
		)
	); 

	$wrmsmarty->assign('curr_team_fields', 
		array(
			'raid_id'=>$raid_id,
			'delbuttontext'=>$phprlang['delete'],
			'resetbuttontext'=>$phprlang['reset'],
			'team_cur_teams_header'=>$phprlang['team_cur_teams_header']
		)
	);
	$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "teams WHERE (raid_id=%s and char_id='-1') or char_id='-2'",quote_smart($raid_id));
	$teams_result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
	while($team = $db_raid->sql_fetchrow($teams_result, true))
	{
		array_push($current_teams,
			array(
				'team_name'=>$team['team_name'],
				'char_id'=>$team['char_id'],
				'team_id'=>$team['team_id']
			)
		);
	}

	$wrmsmarty->assign('current_teams', $current_teams); 
	
	//********************************************
	//Setup the "Remove Users from Team" section.
	//********************************************
	$team_remove = array();

	// get everyone already on a team for this raid, print info from chars table, selection from teams table,
	//   join is on char_id.
	$sql = sprintf("select " . $phpraid_config['db_prefix'] . "chars.char_id, " .
					   $phpraid_config['db_prefix'] . "chars.name, " .
					   $phpraid_config['db_prefix'] . "chars.class, " .
					   $phpraid_config['db_prefix'] . "chars.guild, " .
					   $phpraid_config['db_prefix'] . "chars.lvl, " .
					   $phpraid_config['db_prefix'] . "teams.team_name " .
			"from " . $phpraid_config['db_prefix'] . "teams, " .
					  $phpraid_config['db_prefix'] . "chars " .
			"where " . $phpraid_config['db_prefix'] . "teams.char_id = " . $phpraid_config['db_prefix'] . "chars.char_id " .
			"and " . $phpraid_config['db_prefix'] . "teams.raid_id = %s", quote_smart($raid_id));
	$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
		
	while($team = $db_raid->sql_fetchrow($result, true))
	{
		// set delete permissions
		if($_SESSION['priv_raids'] == 1) {
			$delete = '<a href="teams.php?mode=remove&amp;raid_id=' . $raid_id . '&amp;char_id='.$team['char_id'].'">
						<img src="templates/' . $phpraid_config['template'] . '/images/icons/icon_delete.gif" border="0"
						onMouseover="ddrivetip(\''.$phprlang['remove_user'].'\');" onMouseout="hideddrivetip();" alt="delete icon"></a>';
		} else {
			$delete = '';
		}

		array_push($team_remove,
			array(
				'ID'=>$team['char_id'],
				'Name'=>get_armorychar($team['name'], $phpraid_config['armory_language'], $server),
				'Class'=>$team['class'],
				'Guild'=>$team['guild'],
				'Level'=>$team['lvl'],
				'Team Name'=>$team['team_name'],
				'Actions'=>$delete
			)
		);
	}
	
	/**************************************************************
	 * Code to setup for a Dynamic Table Create: team1 View.
	 **************************************************************/
	$viewName = 'team1';
	
	//Setup Columns
	$remove_headers = array();
	$record_count_array = array();
	$remove_headers = getVisibleColumns($viewName);

	//Get Record Counts
	$remove_record_count_array = getRecordCounts($team_remove, $remove_headers, $startRecord);
	
	//Get the Jump Menu and pass it down
	$removeJumpMenu = getPageNavigation($team_remove, $startRecord, $pageURL, $sortField, $sortDesc);

	//Setup Data
	$team_remove = paginateSortAndFormat($team_remove, $sortField, $sortDesc, $startRecord, $viewName);
	
	$wrmsmarty->assign('team_remove', $team_remove);
	$wrmsmarty->assign('remove_jump_menu', $removeJumpMenu);
	$wrmsmarty->assign('remove_column_names', $remove_headers);
	$wrmsmarty->assign('remove_record_counts', $remove_record_count_array);
	$wrmsmarty->assign('team_remove_header', $phprlang['team_remove_header']);
	$wrmsmarty->assign('remove_header_data',
		array(
			'template_name'=>$phpraid_config['template'],
			'sort_url_base' => $pageURL,
			'sort_descending' => $sortDesc,
			'sort_text' => $phprlang['sort_text'],
		)
	);
		
//******************************************
//Setup the "Add Users to Team" section.
//******************************************
//$team_add = 'Characters to Add go here.';
	$signups = array();
	$teamed_users = array();
	$unteamed_users = array();
	$team_add = array();
	$add_data = array();

	// Setup Add Teams Generic Data
	$wrmsmarty->assign('add_team_fields', 
		array(
			'team_add_header'=>$phprlang['team_add_header'],
			'raid_id'=>$raid_id,
			'dropdown_text'=>$phprlang['add_team_dropdown_text'],
			'submitbuttontext'=>$phprlang['submit'],
			'resetbuttontext'=>$phprlang['reset']
		)
	); 
	
	//************************************************
	//  So here we need to get everyone who is NOT already placed into a team.  This would be trivial with a
	//    subselect using a NOT IN and checking the char_id in signups vs the char_id in teams.  That said,
	//    mysql 4.0 DOES NOT support subselects...thus we have to do this the hard way around by getting
	//    the data from the first table, the second table, and then parsing that data into a third variable
	//    that contains the differences between the two. 
	//	     @@@-- We're doing this in other places with left joins - look to replace this.
	//*************************************************
	// get everyone signed up for this raid:
	$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "signups WHERE raid_id=%s and cancel='0' and queue='0'",quote_smart($raid_id));
	$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);

	$X=0;
	while($data = $db_raid->sql_fetchrow($result, true))
	{
		$signups[$X]['char_id'] = $data['char_id'];
		$X++;
	}
	$signups_num=$X;

	// get everyone already on a team for this raid
	$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "teams WHERE raid_id=%s",quote_smart($raid_id));
	$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);

	$X=0;
	while($data = $db_raid->sql_fetchrow($result, true))
	{
		$teamed_users[$X]['char_id']=$data['char_id'];
		$X++;
	}
	$teamed_users_num=$X;

	// now we need to compare the first array's data vs the second array and put info from array 1 into array
	//   3 if it's not in array 2...the trials of having to support old versions of MySQL.
	$Z=0;
	for($X=0; $X<$signups_num; $X++)
	{
		$found=FALSE;
		for($Y=0; $Y<$teamed_users_num; $Y++)
			if ($signups[$X]['char_id']==$teamed_users[$Y]['char_id'])
			{
				$found=TRUE;
				break;
			}
		if (!$found)
		{
			$unteamed_users[$Z]['char_id']=$signups[$X]['char_id'];
			$Z++;
		}
	}
	$unteamed_users_num=$Z;

	//At this point we have a list of char_id's that are not already assigned to a team.  Now we need to get
	//  the data from the characters table to display and load that into our form.
	for($X=0; $X<$unteamed_users_num;$X++)
	{
		$char_id = $unteamed_users[$X]['char_id'];

		// get character data from the characters table.
		$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "chars WHERE char_id=%s",quote_smart($char_id));
		$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
		$data = $db_raid->sql_fetchrow($result, true);

		$action='<input type="checkbox" name="addtolist' . $data['char_id'] . '" value="' . $data['char_id'] . '">';

		array_push($team_add,
			array(
				'ID'=>$data['char_id'],
				'Name'=>get_armorychar($data['name'], $phpraid_config['armory_language'], $server),
				'Class'=>$data['class'],
				'Guild'=>$data['guild'],
				'Level'=>$data['lvl'],
				'Team Name'=>'',
				'Add To Team'=>$action
			)
		);
	}

	/**************************************************************
	 * Code to setup for a Dynamic Table Create: team1 View.
	 **************************************************************/
	$viewName = 'team2';
	
	//Setup Columns
	$add_headers = array();
	$record_count_array = array();
	$add_headers = getVisibleColumns($viewName);

	//Get Record Counts
	$add_record_count_array = getRecordCounts($team_add, $add_headers, $startRecord);
	
	//Get the Jump Menu and pass it down
	$addJumpMenu = getPageNavigation($team_add, $startRecord, $pageURL, $sortField, $sortDesc);

	//Setup Data
	$team_add = paginateSortAndFormat($team_add, $sortField, $sortDesc, $startRecord, $viewName);
	
	$wrmsmarty->assign('team_add', $team_add);
	$wrmsmarty->assign('add_jump_menu', $addJumpMenu);
	$wrmsmarty->assign('add_column_names', $add_headers);
	$wrmsmarty->assign('add_record_counts', $add_record_count_array);
	$wrmsmarty->assign('add_header_data',
		array(
			'template_name'=>$phpraid_config['template'],
			'sort_url_base' => $pageURL,
			'sort_descending' => $sortDesc,
			'sort_text' => $phprlang['sort_text'],
		)
	);
	
	// get character data from the teams table.
	$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "teams WHERE (raid_id=%s and char_id='-1') or char_id='-2'",quote_smart($raid_id));
	$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
	while ($data = $db_raid->sql_fetchrow($result, true))
	{
		array_push($add_data,
			array(
				'team_id'=>$data['team_id'],
				'team_name'=>$data['team_name']
			)
		);
	}
	
	$wrmsmarty->assign('add_data', $add_data);
}
elseif($mode == 'new')
{
	isset($_POST['team_name']) ? $team_name = scrub_input($_POST['team_name']) : $team_name = '';
	isset($_POST['global']) ? $global = scrub_input($_POST['team_name']) : $global = '';

	if ($team_name != "")
	{
		if ($_POST['global'])
			$sql = sprintf("INSERT INTO " . $phpraid_config['db_prefix'] . "teams VALUES('0',%s,%s,'-2')",quote_smart($raid_id),quote_smart($team_name));
		else
			$sql = sprintf("INSERT INTO " . $phpraid_config['db_prefix'] . "teams VALUES('0',%s,%s,'-1')",quote_smart($raid_id),quote_smart($team_name));

		$db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);

		log_create('teams',mysql_insert_id(),$name);
	}
	header("Location: teams.php?mode=view&raid_id=$raid_id");
}
elseif($mode == 'remove')
{
	//We simply need to find the char ID/Raid ID combo in the teams table and delete the row.
	// check for invalid raid passed
	isset($_GET['char_id']) ? $char_id = sprintf($_GET['char_id']) : $char_id = '';

	if($char_id == '' || !is_numeric($char_id))
		log_hack();

	$sql = sprintf("DELETE FROM " . $phpraid_config['db_prefix'] . "teams WHERE raid_id=%s and char_id=%s", quote_smart($raid_id),quote_smart($char_id));
	$db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);

	header("Location: teams.php?mode=view&raid_id=$raid_id");
}
elseif($mode == 'add')
{
	//Obtain and Verify the Team_ID from the POST data.
	isset($_POST['team_drop_name']) ? $team_id = sprintf($_POST['team_drop_name']) : $team_id = '';

	if($team_id == '' || !is_numeric($team_id))
		log_hack();

	//get team_name from team_id: Only one team name can be passed at any given time, so only retrieve team once.
	$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "teams WHERE team_id=%s",quote_smart($team_id));
	$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
	$data = $db_raid->sql_fetchrow($result, true);
	$team_name = $data['team_name'];

	//For each char id on input, we need to add a record to the teams table noteing that that char is now on a team.
	foreach($_POST as $key=>$value)
	{
		if($key != 'submit' and $key != 'team_drop_name')
		{
			$char_id = $value;
			//insert character and raid to teams table.
			$sql = sprintf("INSERT INTO " . $phpraid_config['db_prefix'] . "teams (`team_id`,`raid_id`,`team_name`,`char_id`)
						VALUES ('0',%s,%s,%s)", quote_smart($raid_id),quote_smart($team_name),quote_smart($char_id));
			$db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);

			log_create('teams',mysql_insert_id(),$title);
		}
	}
	header("Location: teams.php?mode=view&raid_id=$raid_id");
}
elseif($mode == 'delteam')
{
	//For each team id on input, we need to delete a record from the teams table.
	foreach($_POST as $key=>$value)
	{
		if($key != 'submit')
		{
			$team_id = $value;

			//delete from teams table.
			$sql = sprintf("DELETE FROM " . $phpraid_config['db_prefix'] . "teams WHERE team_id=%s", quote_smart($team_id));
			$db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);

			log_delete('teams',$title);
		}
	}
	header("Location: teams.php?mode=view&raid_id=$raid_id");
}
else
{
	$errorMsg = $phprlang['invalid_option_msg'];
	$errorTitle = $phprlang['invalid_option_title'];
	$errorDie = 1;
}

//Create Link back to the Raid View page.
$raid_view_link = '<a href="view.php?mode=view&amp;raid_id=' . $raid_id . '">' . $phprlang['teams_raid_view_text'] . '</a>';

require_once('./includes/page_header.php');
$wrmsmarty->assign('header_data', 
	array(
		'team_page_header'=>$phprlang['team_page_header'],
		'raid_view_link'=>$raid_view_link
	)
);

$wrmsmarty->display('team_main.html');
require_once('./includes/page_footer.php');
?>
