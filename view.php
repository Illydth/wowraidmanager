<?php
/***************************************************************************
 *                                 view.php
 *                            -------------------
 *   begin                : Saturday, Jan 16, 2005
 *   copyright            : (C) 2007 - 2008 Douglas Wagner
 *   email                : douglasw@wagnerweb.org
 *
 *   $Id: view.php,v 2.00 2008/03/11 13:27:48 psotfx Exp $
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

// check for valid input of raid_id
if(!isset($_GET['raid_id']) || !is_numeric($_GET['raid_id']))
	log_hack();

// check for mode passing
isset($_GET['mode']) ? $mode = scrub_input($_GET['mode']) : $mode = '';

if($mode == '')
	log_hack();

// check for invalid raid passed
isset($_GET['raid_id']) ? $raid_id = scrub_input($_GET['raid_id']) : $raid_id = '';

if($raid_id == '' || !is_numeric($raid_id))
	log_hack();

$profile_id = scrub_input($_SESSION['profile_id']);

isset($_GET['Sort']) ? $sort_mode = scrub_input($_GET['Sort']) : $sort_mode = 'name';
isset($_GET['SortDescending']) ? $sort_descending = scrub_input($_GET['SortDescending']) : $sort_descending = 0;

// This require sets up the flow control surrounding queueing, cancelling and drafting of users.
require_once('./signup_flow.php');

// Determine Advanced Profile Permisions to this Raid - Note: "user" doesn't need to be checked, it's
//	 a default permission that will be checked within the signup flow.
$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "raids WHERE raid_id=%s", quote_smart($raid_id));
$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
$data = $db_raid->sql_fetchrow($result);

$priv_raids = scrub_input($_SESSION['priv_raids']);
$username = scrub_input($_SESSION['username']);

if ($priv_raids == 1)
	$user_perm_group['admin'] = 1;
elseif ($username == $data['officer'])
	$user_perm_group['RL'] = 1;
else
{
	$user_perm_group['admin'] = 0;
	$user_perm_group['RL'] = 0;
}

if($mode == 'view')
{
	$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "raids WHERE raid_id=%s", quote_smart($raid_id));
	$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
	$data = $db_raid->sql_fetchrow($result);

	$raid_location = UBB2($data['location']);
	$raid_officer = $data['officer'];
	$raid_date = new_date($phpraid_config['date_format'],$data['start_time'],$phpraid_config['timezone'] + $phpraid_config['dst']);
	$raid_invite_time = new_date($phpraid_config['time_format'],$data['invite_time'],$phpraid_config['timezone'] + $phpraid_config['dst']);
	$raid_start_time = new_date($phpraid_config['time_format'],$data['start_time'],$phpraid_config['timezone'] + $phpraid_config['dst']);
	$raid_max = $data['max'];
	$raid_min_lvl = $data['min_lvl'];
	$raid_max_lvl = $data['max_lvl'];

	$raid_description = scrub_input($data['description']);
	$raid_description = UBB($raid_description);

	// get signup information
	$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "signups WHERE raid_id=%s AND queue='0' AND cancel='0'", quote_smart($raid_id));
	$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
	$raid_count = $db_raid->sql_numrows($result);

	// get cancel information
	$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "signups WHERE raid_id=%s AND queue='0' AND cancel='1'", quote_smart($raid_id));
	$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
	$raid_cancel_count = $db_raid->sql_numrows($result);

	// get queue information
	$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "signups WHERE raid_id=%s AND queue='1'", quote_smart($raid_id));
	$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
	$raid_queue_count = $db_raid->sql_numrows($result);

	// get totals
	$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "signups WHERE raid_id=%s", quote_smart($raid_id));
	$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
	$raid_total = $db_raid->sql_numrows($result);

	// calculate percentages
	if($raid_total != 0)
	{
		$raid_count_percentage = substr(($raid_count / $raid_total) * 100,0,5);
		$raid_queue_count_percentage = substr(($raid_queue_count / $raid_total) * 100,0,5);
		$raid_cancel_count_percentage = substr(($raid_cancel_count / $raid_total) * 100,0,5);
	}
	else
	{
		$raid_count_percentage = 0;
		$raid_queue_count_percentage = 0;
		$raid_cancel_count_percentage = 0;
	}
	if($raid_max != 0)
		$raid_max_percentage = substr(($raid_total / $raid_max) * 100,0,5);
	else
		$raid_max_percentage = 0;

	$raid_open = $raid_max - $raid_total;

	// now, get the actual class information and put them into their arrays
	$druid = array();
	$hunter = array();
	$mage = array();
	$paladin = array();
	$priest = array();
	$rogue = array();
	$shaman = array();
	$warlock = array();
	$warrior = array();
	$raid_queue = array();
	$raid_cancel = array();

	$druid_count = 0;
	$hunter_count = 0;
	$mage_count = 0;
	$paladin_count = 0;
	$priest_count = 0;
	$rogue_count = 0;
	$shaman_count = 0;
	$warlock_count = 0;
	$warrior_count = 0;

	// parse the signup array and seperate to classes
	$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "signups WHERE raid_id=%s AND queue='0' AND cancel='0'", quote_smart($raid_id));
	$signups_result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
	while($signups = $db_raid->sql_fetchrow($signups_result))
	{
		$race = '';
		$name = '';
		$team_name = '';

		// okay, push the value into the array after we
		// get all the character information from the database
		$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "chars WHERE char_id=%s",quote_smart($signups['char_id']));
		$data_result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
		$data = $db_raid->sql_fetchrow($data_result);

		$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "teams WHERE char_id=%s and raid_id=%s",quote_smart($signups['char_id']),quote_smart($raid_id));
		$teams_result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
		$teamrow = $db_raid->sql_fetchrow($teams_result);

		if ($db_raid->sql_numrows($teams_result) > 0)
		{
			$team_name=$teamrow['team_name'];
		}

		// okay, push the value into the array after we
		// get all the character and team information from the database.
		//$sql = sprintf("SELECT " . $phpraid_config['db_prefix'] . "chars.*, " . $phpraid_config['db_prefix'] . "teams.team_name " .
		//				"LEFT JOIN " . $phpraid_config['db_prefix'] . "chars, " . $phpraid_config['db_prefix'] . "teams " .
		//				"WHERE " .$phpraid_config['db_prefix'] . "chars.char_id=%s " .
		//				"and " .$phpraid_config['db_prefix'] . "chars.char_id=" .$phpraid_config['db_prefix'] . "teams.char_id " .
		//				"and " .$phpraid_config['db_prefix'] . "teams.raid_id=%s",quote_smart($signups['char_id']),quote_smart($raid_id));
		//$data_result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
		//$data = $db_raid->sql_fetchrow($data_result);

		//$team_name=$data['team_name'];

		/**********************
		 * Buttons applicable to users who are Signed Up (drafted) for a raid.  Buttons for Queued and Cancelled
		 * Character signups are below.
		 *
		 * This goes to Flow control, see signup_flow.php.
		 *
		 * The function below controls the logic of what users, admins and raid leaders can do
		 * to a character that is signed up for a raid.  The default flow control for this
		 * application is documented in the docs directory under "User_Signup_Flow.txt", if
		 * you wish to change the Signup Flow, please read that document and modify what buttons
		 * are available to each class of user ($user_perm_group) by commenting and uncommenting
		 * the available buttons in signup_flow.php.
		 **********************/
		// allow queue swapping
		$actions = '';
		$actions = signedUpFlow($user_perm_group, $phpraid_config, $data, $raid_id, $phprlang, $sort_mode, $sort_descending, $signups);

		$date = new_date($phpraid_config['date_format'],$signups['timestamp'],$phpraid_config['timezone'] + $phpraid_config['dst']);
		$time = new_date($phpraid_config['time_format'],$signups['timestamp'],$phpraid_config['timezone'] + $phpraid_config['dst']);
		switch($data['race'])
		{
			case $phprlang['draenei']:
				if(strtolower($data['gender']) == strtolower($phprlang['male']))
					$race = '<img src="templates/' . $phpraid_config['template'] . '/images/faces/dr_male.gif" height="18" width="18" border="0" onMouseover="ddrivetip(\''.$phprlang['draenei'].'\')"; onMouseout="hideddrivetip()">';
				else
					$race = '<img src="templates/' . $phpraid_config['template'] . '/images/faces/dr_female.gif" height="18" width="18" border="0" onMouseover="ddrivetip(\''.$phprlang['draenei'].'\')"; onMouseout="hideddrivetip()">';
				break;
			case $phprlang['dwarf']:
				if(strtolower($data['gender']) == strtolower($phprlang['male']))
					$race = '<img src="templates/' . $phpraid_config['template'] . '/images/faces/dw_male.gif" height="18" width="18" border="0" onMouseover="ddrivetip(\''.$phprlang['dwarf'].'\')"; onMouseout="hideddrivetip()">';
				else
					$race = '<img src="templates/' . $phpraid_config['template'] . '/images/faces/dw_female.gif" height="18" width="18" border="0" onMouseover="ddrivetip(\''.$phprlang['dwarf'].'\')"; onMouseout="hideddrivetip()">';
				break;
			case $phprlang['gnome']:
				if(strtolower($data['gender']) == strtolower($phprlang['male']))
					$race = '<img src="templates/' . $phpraid_config['template'] . '/images/faces/gn_male.gif" height="18" width="18" border="0" onMouseover="ddrivetip(\''.$phprlang['gnome'].'\')"; onMouseout="hideddrivetip()">';
				else
					$race = '<img src="templates/' . $phpraid_config['template'] . '/images/faces/gn_female.gif" height="18" width="18" border="0" onMouseover="ddrivetip(\''.$phprlang['gnome'].'\')"; onMouseout="hideddrivetip()">';
				break;
			case $phprlang['human']:
				if(strtolower($data['gender']) == strtolower($phprlang['male']))
					$race = '<img src="templates/' . $phpraid_config['template'] . '/images/faces/hu_male.gif" height="18" width="18" border="0" onMouseover="ddrivetip(\''.$phprlang['human'].'\')"; onMouseout="hideddrivetip()">';
				else
					$race = '<img src="templates/' . $phpraid_config['template'] . '/images/faces/hu_female.gif" height="18" width="18" border="0" onMouseover="ddrivetip(\''.$phprlang['human'].'\')"; onMouseout="hideddrivetip()">';
				break;
			case $phprlang['night_elf']:
				if(strtolower($data['gender']) == strtolower($phprlang['male']))
					$race = '<img src="templates/' . $phpraid_config['template'] . '/images/faces/ne_male.gif" height="18" width="18" border="0" onMouseover="ddrivetip(\''.$phprlang['night_elf'].'\')"; onMouseout="hideddrivetip()">';
				else
					$race = '<img src="templates/' . $phpraid_config['template'] . '/images/faces/ne_female.gif" height="18" width="18" border="0" onMouseover="ddrivetip(\''.$phprlang['night_elf'].'\')"; onMouseout="hideddrivetip()">';
				break;
			case $phprlang['blood_elf']:
				if(strtolower($data['gender']) == strtolower($phprlang['male']))
					$race = '<img src="templates/' . $phpraid_config['template'] . '/images/faces/be_male.gif" height="18" width="18" border="0" onMouseover="ddrivetip(\''.$phprlang['blood_elf'].'\')"; onMouseout="hideddrivetip()">';
				else
					$race = '<img src="templates/' . $phpraid_config['template'] . '/images/faces/be_female.gif" height="18" width="18" border="0" onMouseover="ddrivetip(\''.$phprlang['blood_elf'].'\')"; onMouseout="hideddrivetip()">';
				break;
			case $phprlang['orc']:
				if(strtolower($data['gender']) == strtolower($phprlang['male']))
					$race = '<img src="templates/' . $phpraid_config['template'] . '/images/faces/or_male.gif" height="18" width="18" border="0" onMouseover="ddrivetip(\''.$phprlang['orc'].'\')"; onMouseout="hideddrivetip()">';
				else
					$race = '<img src="templates/' . $phpraid_config['template'] . '/images/faces/or_female.gif" height="18" width="18" border="0" onMouseover="ddrivetip(\''.$phprlang['orc'].'\')"; onMouseout="hideddrivetip()">';
				break;
			case $phprlang['tauren']:
				if(strtolower($data['gender']) == strtolower($phprlang['male']))
					$race = '<img src="templates/' . $phpraid_config['template'] . '/images/faces/ta_male.gif" height="18" width="18" border="0" onMouseover="ddrivetip(\''.$phprlang['tauren'].'\')"; onMouseout="hideddrivetip()">';
				else
					$race = '<img src="templates/' . $phpraid_config['template'] . '/images/faces/ta_female.gif" height="18" width="18" border="0" onMouseover="ddrivetip(\''.$phprlang['tauren'].'\')"; onMouseout="hideddrivetip()">';
				break;
			case $phprlang['troll']:
				if(strtolower($data['gender']) == strtolower($phprlang['male']))
					$race = '<img src="templates/' . $phpraid_config['template'] . '/images/faces/tr_male.gif" height="18" width="18" border="0" onMouseover="ddrivetip(\''.$phprlang['troll'].'\')"; onMouseout="hideddrivetip()">';
				else
					$race = '<img src="templates/' . $phpraid_config['template'] . '/images/faces/tr_female.gif" height="18" width="18" border="0" onMouseover="ddrivetip(\''.$phprlang['troll'].'\')"; onMouseout="hideddrivetip()">';
				break;
			case $phprlang['undead']:
				if(strtolower($data['gender']) == strtolower($phprlang['male']))
					$race = '<img src="templates/' . $phpraid_config['template'] . '/images/faces/un_male.gif" height="18" width="18" border="0" onMouseover="ddrivetip(\''.$phprlang['undead'].'\')"; onMouseout="hideddrivetip()">';
				else
					$race = '<img src="templates/' . $phpraid_config['template'] . '/images/faces/un_female.gif" height="18" width="18" border="0" onMouseover="ddrivetip(\''.$phprlang['undead'].'\')"; onMouseout="hideddrivetip()">';
				break;
			}

		$comments = DEUBB2(scrub_input($signups['comments']));

		if(strlen($signups['comments']) > 25)
			$comments = '<a href="#" onMouseover="ddrivetip(\'<span class=tooltip_title>'.$phprlang['comments'].'</span><br>'.$comments.'\',\'\',\'150\')" onMouseout="hideddrivetip()">' . substr($signups['comments'], 0, 22) . '...</a>';
		else
			$comments = UBB(scrub_input($signups['comments']));

		if(strlen($comments) == 0)
			$comments = 'None';

		$arcane = $data['arcane'];
		$fire = $data['fire'];
		$nature = $data['nature'];
		$frost = $data['frost'];
		$shadow = $data['shadow'];

		// now that we have the row, figure out what class and push into corresponding array
		switch($data['class'])
		{
			case $phprlang['druid']:
				$druid_count++;
				array_push($druid,
					array('id'=>$data['char_id'],'arcane'=>$arcane,'fire'=>$fire,'nature'=>$nature,'frost'=>$frost,'shadow'=>$shadow,
						  'race'=>$race,'name'=>$data['name'],'comments'=>$comments,'lvl'=>$data['lvl'],'actions'=>$actions,
						  'date'=>$date,'time'=>$time,'team_name'=>$team_name));
				break;
			case $phprlang['hunter']:
				$hunter_count++;
				array_push($hunter,
					array('id'=>$data['char_id'],'arcane'=>$arcane,'fire'=>$fire,'nature'=>$nature,'frost'=>$frost,'shadow'=>$shadow,
						  'race'=>$race,'name'=>$data['name'],'comments'=>$comments,'lvl'=>$data['lvl'],'actions'=>$actions,
						  'date'=>$date,'time'=>$time,'team_name'=>$team_name));
				break;
			case $phprlang['mage']:
				$mage_count++;
				array_push($mage,
					array('id'=>$data['char_id'],'arcane'=>$arcane,'fire'=>$fire,'nature'=>$nature,'frost'=>$frost,'shadow'=>$shadow,
						  'race'=>$race,'name'=>$data['name'],'comments'=>$comments,'lvl'=>$data['lvl'],'actions'=>$actions,
						  'date'=>$date,'time'=>$time,'team_name'=>$team_name));
				break;
			case $phprlang['paladin']:
				$paladin_count++;
				array_push($paladin,
					array('id'=>$data['char_id'],'arcane'=>$arcane,'fire'=>$fire,'nature'=>$nature,'frost'=>$frost,'shadow'=>$shadow,
						  'race'=>$race,'name'=>$data['name'],'comments'=>$comments,'lvl'=>$data['lvl'],'actions'=>$actions,
						  'date'=>$date,'time'=>$time,'team_name'=>$team_name));
				break;
			case $phprlang['priest']:
				$priest_count++;
				array_push($priest,
					array('id'=>$data['char_id'],'arcane'=>$arcane,'fire'=>$fire,'nature'=>$nature,'frost'=>$frost,'shadow'=>$shadow,
						  'race'=>$race,'name'=>$data['name'],'comments'=>$comments,'lvl'=>$data['lvl'],'actions'=>$actions,
						  'date'=>$date,'time'=>$time,'team_name'=>$team_name));
				break;
			case $phprlang['rogue']:
				$rogue_count++;
				array_push($rogue,
					array('id'=>$data['char_id'],'arcane'=>$arcane,'fire'=>$fire,'nature'=>$nature,'frost'=>$frost,'shadow'=>$shadow,
						  'race'=>$race,'name'=>$data['name'],'comments'=>$comments,'lvl'=>$data['lvl'],'actions'=>$actions,
						  'date'=>$date,'time'=>$time,'team_name'=>$team_name));
				break;
			case $phprlang['shaman']:
				$shaman_count++;
				array_push($shaman,
					array('id'=>$data['char_id'],'arcane'=>$arcane,'fire'=>$fire,'nature'=>$nature,'frost'=>$frost,'shadow'=>$shadow,
						  'race'=>$race,'name'=>$data['name'],'comments'=>$comments,'lvl'=>$data['lvl'],'actions'=>$actions,
						  'date'=>$date,'time'=>$time,'team_name'=>$team_name));
				break;
			case $phprlang['warlock']:
				$warlock_count++;
				array_push($warlock,
					array('id'=>$data['char_id'],'arcane'=>$arcane,'fire'=>$fire,'nature'=>$nature,'frost'=>$frost,'shadow'=>$shadow,
						  'race'=>$race,'name'=>$data['name'],'comments'=>$comments,'lvl'=>$data['lvl'],'actions'=>$actions,
						  'date'=>$date,'time'=>$time,'team_name'=>$team_name));
				break;
			case $phprlang['warrior']:
				$warrior_count++;
				array_push($warrior,
					array('id'=>$data['char_id'],'arcane'=>$arcane,'fire'=>$fire,'nature'=>$nature,'frost'=>$frost,'shadow'=>$shadow,
						  'race'=>$race,'name'=>$data['name'],'comments'=>$comments,'lvl'=>$data['lvl'],'actions'=>$actions,
						  'date'=>$date,'time'=>$time,'team_name'=>$team_name));
				break;
		}
	}

	// parse the queue array and seperate to classes
	$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "signups WHERE raid_id=%s AND queue='1' AND cancel='0'",quote_smart($raid_id));
	$signups_result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
	while($signups = $db_raid->sql_fetchrow($signups_result))
	{
		// okay, push the value into the array after we
		// get all the character information from the database
		$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "chars WHERE char_id=%s",quote_smart($signups['char_id']));
		$data_result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
		$data = $db_raid->sql_fetchrow($data_result);

		$comments = DEUBB2(scrub_input($signups['comments']));

		if(strlen($signups['comments']) > 25)
			$comments = '<a href="#" onMouseover="fixedtooltip(\'<span class=tooltip_title>'.$phprlang['comments'].'</span><br>'.$comments.'\',this,event,\'150\')" onMouseout="delayhidetip()">' . substr($signups['comments'], 0, 22) . '...</a>';
		else
			$comments = UBB(scrub_input($signups['comments']));

		if(strlen($comments) == 0)
			$comments = 'None';

		$name = $data['name'];

		$date = new_date($phpraid_config['date_format'],$signups['timestamp'],$phpraid_config['timezone'] + $phpraid_config['dst']);
		$time = new_date($phpraid_config['time_format'],$signups['timestamp'],$phpraid_config['timezone'] + $phpraid_config['dst']);

		switch($data['race'])
		{
			case $phprlang['draenei']:
				if(strtolower($data['gender']) == strtolower($phprlang['male']))
					$race = '<img src="templates/' . $phpraid_config['template'] . '/images/faces/dr_male.gif" height="18" width="18" border="0" onMouseover="ddrivetip(\''.$phprlang['draenei'].'\')"; onMouseout="hideddrivetip()">';
				else
					$race = '<img src="templates/' . $phpraid_config['template'] . '/images/faces/dr_female.gif" height="18" width="18" border="0" onMouseover="ddrivetip(\''.$phprlang['draenei'].'\')"; onMouseout="hideddrivetip()">';
				break;
			case $phprlang['dwarf']:
				if(strtolower($data['gender']) == strtolower($phprlang['male']))
					$race = '<img src="templates/' . $phpraid_config['template'] . '/images/faces/dw_male.gif" height="18" width="18" border="0" onMouseover="ddrivetip(\''.$phprlang['dwarf'].'\')"; onMouseout="hideddrivetip()">';
				else
					$race = '<img src="templates/' . $phpraid_config['template'] . '/images/faces/dw_female.gif" height="18" width="18" border="0" onMouseover="ddrivetip(\''.$phprlang['dwarf'].'\')"; onMouseout="hideddrivetip()">';
				break;
			case $phprlang['gnome']:
				if(strtolower($data['gender']) == strtolower($phprlang['male']))
					$race = '<img src="templates/' . $phpraid_config['template'] . '/images/faces/gn_male.gif" height="18" width="18" border="0" onMouseover="ddrivetip(\''.$phprlang['gnome'].'\')"; onMouseout="hideddrivetip()">';
				else
					$race = '<img src="templates/' . $phpraid_config['template'] . '/images/faces/gn_female.gif" height="18" width="18" border="0" onMouseover="ddrivetip(\''.$phprlang['gnome'].'\')"; onMouseout="hideddrivetip()">';
				break;
			case $phprlang['human']:
				if(strtolower($data['gender']) == strtolower($phprlang['male']))
					$race = '<img src="templates/' . $phpraid_config['template'] . '/images/faces/hu_male.gif" height="18" width="18" border="0" onMouseover="ddrivetip(\''.$phprlang['human'].'\')"; onMouseout="hideddrivetip()">';
				else
					$race = '<img src="templates/' . $phpraid_config['template'] . '/images/faces/hu_female.gif" height="18" width="18" border="0" onMouseover="ddrivetip(\''.$phprlang['human'].'\')"; onMouseout="hideddrivetip()">';
				break;
			case $phprlang['night_elf']:
				if(strtolower($data['gender']) == strtolower($phprlang['male']))
					$race = '<img src="templates/' . $phpraid_config['template'] . '/images/faces/ne_male.gif" height="18" width="18" border="0" onMouseover="ddrivetip(\''.$phprlang['night_elf'].'\')"; onMouseout="hideddrivetip()">';
				else
					$race = '<img src="templates/' . $phpraid_config['template'] . '/images/faces/ne_female.gif" height="18" width="18" border="0" onMouseover="ddrivetip(\''.$phprlang['night_elf'].'\')"; onMouseout="hideddrivetip()">';
				break;
			case $phprlang['blood_elf']:
				if(strtolower($data['gender']) == strtolower($phprlang['male']))
					$race = '<img src="templates/' . $phpraid_config['template'] . '/images/faces/be_male.gif" height="18" width="18" border="0" onMouseover="ddrivetip(\''.$phprlang['blood_elf'].'\')"; onMouseout="hideddrivetip()">';
				else
					$race = '<img src="templates/' . $phpraid_config['template'] . '/images/faces/be_female.gif" height="18" width="18" border="0" onMouseover="ddrivetip(\''.$phprlang['blood_elf'].'\')"; onMouseout="hideddrivetip()">';
				break;
			case $phprlang['orc']:
				if(strtolower($data['gender']) == strtolower($phprlang['male']))
					$race = '<img src="templates/' . $phpraid_config['template'] . '/images/faces/or_male.gif" height="18" width="18" border="0" onMouseover="ddrivetip(\''.$phprlang['orc'].'\')"; onMouseout="hideddrivetip()">';
				else
					$race = '<img src="templates/' . $phpraid_config['template'] . '/images/faces/or_female.gif" height="18" width="18" border="0" onMouseover="ddrivetip(\''.$phprlang['orc'].'\')"; onMouseout="hideddrivetip()">';
				break;
			case $phprlang['tauren']:
				if(strtolower($data['gender']) == strtolower($phprlang['male']))
					$race = '<img src="templates/' . $phpraid_config['template'] . '/images/faces/ta_male.gif" height="18" width="18" border="0" onMouseover="ddrivetip(\''.$phprlang['tauren'].'\')"; onMouseout="hideddrivetip()">';
				else
					$race = '<img src="templates/' . $phpraid_config['template'] . '/images/faces/ta_female.gif" height="18" width="18" border="0" onMouseover="ddrivetip(\''.$phprlang['tauren'].'\')"; onMouseout="hideddrivetip()">';
				break;
			case $phprlang['troll']:
				if(strtolower($data['gender']) == strtolower($phprlang['male']))
					$race = '<img src="templates/' . $phpraid_config['template'] . '/images/faces/tr_male.gif" height="18" width="18" border="0" onMouseover="ddrivetip(\''.$phprlang['troll'].'\')"; onMouseout="hideddrivetip()">';
				else
					$race = '<img src="templates/' . $phpraid_config['template'] . '/images/faces/tr_female.gif" height="18" width="18" border="0" onMouseover="ddrivetip(\''.$phprlang['troll'].'\')"; onMouseout="hideddrivetip()">';
				break;
			case $phprlang['undead']:
				if(strtolower($data['gender']) == strtolower($phprlang['male']))
					$race = '<img src="templates/' . $phpraid_config['template'] . '/images/faces/un_male.gif" height="18" width="18" border="0" onMouseover="ddrivetip(\''.$phprlang['undead'].'\')"; onMouseout="hideddrivetip()">';
				else
					$race = '<img src="templates/' . $phpraid_config['template'] . '/images/faces/un_female.gif" height="18" width="18" border="0" onMouseover="ddrivetip(\''.$phprlang['undead'].'\')"; onMouseout="hideddrivetip()">';
				break;
		}

		switch($data['class'])
		{
			case $phprlang['druid']:
				$class = ' <img src="templates/' . $phpraid_config['template'] . '/images/classes/druid_icon.gif" height="18" width="18" border="0" onMouseover="ddrivetip(\''.$phprlang['druid'].'\')"; onMouseout="hideddrivetip()">';
				break;
			case $phprlang['hunter']:
				$class = ' <img src="templates/' . $phpraid_config['template'] . '/images/classes/hunter_icon.gif" height="18" width="18" border="0" onMouseover="ddrivetip(\''.$phprlang['hunter'].'\')"; onMouseout="hideddrivetip()">';
				break;
			case $phprlang['mage']:
				$class = ' <img src="templates/' . $phpraid_config['template'] . '/images/classes/mage_icon.gif" height="18" width="18" border="0" onMouseover="ddrivetip(\''.$phprlang['mage'].'\')"; onMouseout="hideddrivetip()">';
				break;
			case $phprlang['paladin']:
				$class = ' <img src="templates/' . $phpraid_config['template'] . '/images/classes/paladin_icon.gif" height="18" width="18" border="0" onMouseover="ddrivetip(\''.$phprlang['paladin'].'\')"; onMouseout="hideddrivetip()">';
				break;
			case $phprlang['priest']:
				$class = ' <img src="templates/' . $phpraid_config['template'] . '/images/classes/priest_icon.gif" height="18" width="18" border="0" onMouseover="ddrivetip(\''.$phprlang['priest'].'\')"; onMouseout="hideddrivetip()">';
				break;
			case $phprlang['rogue']:
				$class = ' <img src="templates/' . $phpraid_config['template'] . '/images/classes/rogue_icon.gif" height="18" width="18" border="0" onMouseover="ddrivetip(\''.$phprlang['rogue'].'\')"; onMouseout="hideddrivetip()">';
				break;
			case $phprlang['shaman']:
				$class = ' <img src="templates/' . $phpraid_config['template'] . '/images/classes/shaman_icon.gif" height="18" width="18" border="0" onMouseover="ddrivetip(\''.$phprlang['shaman'].'\')"; onMouseout="hideddrivetip()">';
				break;
			case $phprlang['warlock']:
				$class = ' <img src="templates/' . $phpraid_config['template'] . '/images/classes/warlock_icon.gif" height="18" width="18" border="0" onMouseover="ddrivetip(\''.$phprlang['warlock'].'\')"; onMouseout="hideddrivetip()">';
				break;
			case $phprlang['warrior']:
				$class = ' <img src="templates/' . $phpraid_config['template'] . '/images/classes/warrior_icon.gif" height="18" width="18" border="0" onMouseover="ddrivetip(\''.$phprlang['warrior'].'\')"; onMouseout="hideddrivetip()">';
				break;
		}

		/**********************
		 * Buttons applicable to users who are Queued to be Drafted for a raid.  Buttons for Drafted Characters
		 * are set above and buttons for Cancelled Character signups are below.
		 *
		 * This goes to Flow control, see signup_flow.php.
		 *
		 * The function below controls the logic of what users, admins and raid leaders can do
		 * to a character that is queued to be drafted for a raid.  The default flow control for this
		 * application is documented in the docs directory under "User_Signup_Flow.txt", if
		 * you wish to change the Signup Flow, please read that document and modify what buttons
		 * are available to each class of user ($user_perm_group) by commenting and uncommenting
		 * the available buttons in signup_flow.php.
		 **********************/
		// allow queue swapping
		$actions = '';
		$actions=queuedFlow($user_perm_group, $phpraid_config, $data, $raid_id, $phprlang, $sort_mode, $sort_descending, $signups);
		array_push($raid_queue, array('id'=>$data['char_id'],'race'=>$race,'class'=>$class,'name'=>$name,'lvl'=>$data['lvl'],'actions'=>$actions,'date'=>$date,'time'=>$time,'comments'=>$comments));
	}

	// parse the cancel array and seperate to classes
	$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "signups WHERE raid_id=%s AND queue='0' AND cancel='1'",quote_smart($raid_id));
	$signups_result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
	while($signups = $db_raid->sql_fetchrow($signups_result))
	{
		// okay, push the value into the array after we
		// get all the character information from the database
		$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "chars WHERE char_id=%s",quote_smart($signups['char_id']));
		$data_result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
		$data = $db_raid->sql_fetchrow($data_result);

		$comments = DEUBB2(scrub_input($signups['comments']));

		if(strlen($signups['comments']) > 25)
			$comments = '<a href="#" onMouseover="ddrivetip(\'<span class=tooltip_title>'.$phprlang['comments'].'</span><br>'.$comments.'\',\'\',\'150\')" onMouseout="hideddrivetip()">' . substr($signups['comments'], 0, 22) . '...</a>';
		else
			$comments = UBB(scrub_input($signups['comments']));

		if(strlen($comments) == 0)
			$comments = 'None';

		$name = $data['name'];

		$date = new_date($phpraid_config['date_format'],$signups['timestamp'],$phpraid_config['timezone'] + $phpraid_config['dst']);
		$time = new_date($phpraid_config['time_format'],$signups['timestamp'],$phpraid_config['timezone'] + $phpraid_config['dst']);

		switch($data['race'])
		{
			case $phprlang['draenei']:
				if(strtolower($data['gender']) == strtolower($phprlang['male']))
					$race = '<img src="templates/' . $phpraid_config['template'] . '/images/faces/dr_male.gif" height="18" width="18" border="0" onMouseover="ddrivetip(\''.$phprlang['draenei'].'\')"; onMouseout="hideddrivetip()">';
				else
					$race = '<img src="templates/' . $phpraid_config['template'] . '/images/faces/dr_female.gif" height="18" width="18" border="0" onMouseover="ddrivetip(\''.$phprlang['draenei'].'\')"; onMouseout="hideddrivetip()">';
				break;
			case $phprlang['dwarf']:
				if(strtolower($data['gender']) == strtolower($phprlang['male']))
					$race = '<img src="templates/' . $phpraid_config['template'] . '/images/faces/dw_male.gif" height="18" width="18" border="0" onMouseover="ddrivetip(\''.$phprlang['dwarf'].'\')"; onMouseout="hideddrivetip()">';
				else
					$race = '<img src="templates/' . $phpraid_config['template'] . '/images/faces/dw_female.gif" height="18" width="18" border="0" onMouseover="ddrivetip(\''.$phprlang['dwarf'].'\')"; onMouseout="hideddrivetip()">';
				break;
			case $phprlang['gnome']:
				if(strtolower($data['gender']) == strtolower($phprlang['male']))
					$race = '<img src="templates/' . $phpraid_config['template'] . '/images/faces/gn_male.gif" height="18" width="18" border="0" onMouseover="ddrivetip(\''.$phprlang['gnome'].'\')"; onMouseout="hideddrivetip()">';
				else
					$race = '<img src="templates/' . $phpraid_config['template'] . '/images/faces/gn_female.gif" height="18" width="18" border="0" onMouseover="ddrivetip(\''.$phprlang['gnome'].'\')"; onMouseout="hideddrivetip()">';
				break;
			case $phprlang['human']:
				if(strtolower($data['gender']) == strtolower($phprlang['male']))
					$race = '<img src="templates/' . $phpraid_config['template'] . '/images/faces/hu_male.gif" height="18" width="18" border="0" onMouseover="ddrivetip(\''.$phprlang['human'].'\')"; onMouseout="hideddrivetip()">';
				else
					$race = '<img src="templates/' . $phpraid_config['template'] . '/images/faces/hu_female.gif" height="18" width="18" border="0" onMouseover="ddrivetip(\''.$phprlang['human'].'\')"; onMouseout="hideddrivetip()">';
				break;
			case $phprlang['night_elf']:
				if(strtolower($data['gender']) == strtolower($phprlang['male']))
					$race = '<img src="templates/' . $phpraid_config['template'] . '/images/faces/ne_male.gif" height="18" width="18" border="0" onMouseover="ddrivetip(\''.$phprlang['night_elf'].'\')"; onMouseout="hideddrivetip()">';
				else
					$race = '<img src="templates/' . $phpraid_config['template'] . '/images/faces/ne_female.gif" height="18" width="18" border="0" onMouseover="ddrivetip(\''.$phprlang['night_elf'].'\')"; onMouseout="hideddrivetip()">';
				break;
			case $phprlang['blood_elf']:
				if(strtolower($data['gender']) == strtolower($phprlang['male']))
					$race = '<img src="templates/' . $phpraid_config['template'] . '/images/faces/be_male.gif" height="18" width="18" border="0" onMouseover="ddrivetip(\''.$phprlang['blood_elf'].'\')"; onMouseout="hideddrivetip()">';
				else
					$race = '<img src="templates/' . $phpraid_config['template'] . '/images/faces/be_female.gif" height="18" width="18" border="0" onMouseover="ddrivetip(\''.$phprlang['blood_elf'].'\')"; onMouseout="hideddrivetip()">';
				break;
			case $phprlang['orc']:
				if(strtolower($data['gender']) == strtolower($phprlang['male']))
					$race = '<img src="templates/' . $phpraid_config['template'] . '/images/faces/or_male.gif" height="18" width="18" border="0" onMouseover="ddrivetip(\''.$phprlang['orc'].'\')"; onMouseout="hideddrivetip()">';
				else
					$race = '<img src="templates/' . $phpraid_config['template'] . '/images/faces/or_female.gif" height="18" width="18" border="0" onMouseover="ddrivetip(\''.$phprlang['orc'].'\')"; onMouseout="hideddrivetip()">';
				break;
			case $phprlang['tauren']:
				if(strtolower($data['gender']) == strtolower($phprlang['male']))
					$race = '<img src="templates/' . $phpraid_config['template'] . '/images/faces/ta_male.gif" height="18" width="18" border="0" onMouseover="ddrivetip(\''.$phprlang['tauren'].'\')"; onMouseout="hideddrivetip()">';
				else
					$race = '<img src="templates/' . $phpraid_config['template'] . '/images/faces/ta_female.gif" height="18" width="18" border="0" onMouseover="ddrivetip(\''.$phprlang['tauren'].'\')"; onMouseout="hideddrivetip()">';
				break;
			case $phprlang['troll']:
				if(strtolower($data['gender']) == strtolower($phprlang['male']))
					$race = '<img src="templates/' . $phpraid_config['template'] . '/images/faces/tr_male.gif" height="18" width="18" border="0" onMouseover="ddrivetip(\''.$phprlang['troll'].'\')"; onMouseout="hideddrivetip()">';
				else
					$race = '<img src="templates/' . $phpraid_config['template'] . '/images/faces/tr_female.gif" height="18" width="18" border="0" onMouseover="ddrivetip(\''.$phprlang['troll'].'\')"; onMouseout="hideddrivetip()">';
				break;
			case $phprlang['undead']:
				if(strtolower($data['gender']) == strtolower($phprlang['male']))
					$race = '<img src="templates/' . $phpraid_config['template'] . '/images/faces/un_male.gif" height="18" width="18" border="0" onMouseover="ddrivetip(\''.$phprlang['undead'].'\')"; onMouseout="hideddrivetip()">';
				else
					$race = '<img src="templates/' . $phpraid_config['template'] . '/images/faces/un_female.gif" height="18" width="18" border="0" onMouseover="ddrivetip(\''.$phprlang['undead'].'\')"; onMouseout="hideddrivetip()">';
				break;
		}

		switch($data['class'])
		{
			case $phprlang['druid']:
				$class = ' <img src="templates/' . $phpraid_config['template'] . '/images/classes/druid_icon.gif" height="18" width="18" border="0" onMouseover="ddrivetip(\''.$phprlang['druid'].'\')"; onMouseout="hideddrivetip()">';
				break;
			case $phprlang['hunter']:
				$class = ' <img src="templates/' . $phpraid_config['template'] . '/images/classes/hunter_icon.gif" height="18" width="18" border="0" onMouseover="ddrivetip(\''.$phprlang['hunter'].'\')"; onMouseout="hideddrivetip()">';
				break;
			case $phprlang['mage']:
				$class = ' <img src="templates/' . $phpraid_config['template'] . '/images/classes/mage_icon.gif" height="18" width="18" border="0" onMouseover="ddrivetip(\''.$phprlang['mage'].'\')"; onMouseout="hideddrivetip()">';
				break;
			case $phprlang['paladin']:
				$class = ' <img src="templates/' . $phpraid_config['template'] . '/images/classes/paladin_icon.gif" height="18" width="18" border="0" onMouseover="ddrivetip(\''.$phprlang['paladin'].'\')"; onMouseout="hideddrivetip()">';
				break;
			case $phprlang['priest']:
				$class = ' <img src="templates/' . $phpraid_config['template'] . '/images/classes/priest_icon.gif" height="18" width="18" border="0" onMouseover="ddrivetip(\''.$phprlang['priest'].'\')"; onMouseout="hideddrivetip()">';
				break;
			case $phprlang['rogue']:
				$class = ' <img src="templates/' . $phpraid_config['template'] . '/images/classes/rogue_icon.gif" height="18" width="18" border="0" onMouseover="ddrivetip(\''.$phprlang['rogue'].'\')"; onMouseout="hideddrivetip()">';
				break;
			case $phprlang['shaman']:
				$class = ' <img src="templates/' . $phpraid_config['template'] . '/images/classes/shaman_icon.gif" height="18" width="18" border="0" onMouseover="ddrivetip(\''.$phprlang['shaman'].'\')"; onMouseout="hideddrivetip()">';
				break;
			case $phprlang['warlock']:
				$class = ' <img src="templates/' . $phpraid_config['template'] . '/images/classes/warlock_icon.gif" height="18" width="18" border="0" onMouseover="ddrivetip(\''.$phprlang['warlock'].'\')"; onMouseout="hideddrivetip()">';
				break;
			case $phprlang['warrior']:
				$class = ' <img src="templates/' . $phpraid_config['template'] . '/images/classes/warrior_icon.gif" height="18" width="18" border="0" onMouseover="ddrivetip(\''.$phprlang['warlock'].'\')"; onMouseout="hideddrivetip()">';
				break;
		}

		/**********************
		 * Buttons applicable to users who have canceled their signup for the Raid.  Buttons for Drafted
		 * Characters and Queued Characters are above.
		 *
		 * This goes to Flow control, see signup_flow.php.
		 *
		 * The function below controls the logic of what users, admins and raid leaders can do
		 * to a character who has cancelled their signup from a raid.  The default flow control for this
		 * application is documented in the docs directory under "User_Signup_Flow.txt", if
		 * you wish to change the Signup Flow, please read that document and modify what buttons
		 * are available to each class of user ($user_perm_group) by commenting and uncommenting
		 * the available buttons in signup_flow.php.
		 **********************/
		// allow queue swapping
		$actions = '';
		$actions=canceledFlow($user_perm_group, $phpraid_config, $data, $raid_id, $phprlang, $sort_mode, $sort_descending, $signups);
		array_push($raid_cancel, array('id'=>$data['char_id'],'race'=>$race,'class'=>$class,'name'=>$name,'lvl'=>$data['lvl'],'actions'=>$actions,'date'=>$date,'time'=>$time,'comments'=>$comments));
	}

	// setup formatting for report class (THANKS to www.thecalico.com)
	// generic settings
	setup_output();

	$report->showRecordCount(false);
	$report->allowLink(ALLOW_HOVER_INDEX,'',array());

	//Default sorting
	if(!$_GET['Sort'])
	{
		$report->allowSort(true, 'name', 'ASC', 'view.php?mode=view&raid_id='.$raid_id);
	}
	else
	{
		$report->allowSort(true, $_GET['Sort'], $_GET['SortDescending'], 'view.php?mode=view&raid_id='.$raid_id);
	}

	if($phpraid_config['show_id'] == 1)
		$report->addOutputColumn('id',$phprlang['id'],'','center');
	$report->addOutputColumn('name',$phprlang['name'],'','left');
	$report->addOutputColumn('comments',$phprlang['comments'],'','left');
	$report->addOutputColumn('team_name',$phprlang['team_name'],'','left');
	$report->addOutputColumn('lvl',$phprlang['level'],'','center');
	$report->addOutputColumn('race',$phprlang['race'],'','center');
	$report->addOutputColumn('arcane','<img border="0" src="templates/' . $phpraid_config['template'] .
									  '/images/resistances/arcane_resistance.gif" onMouseover=
									  "ddrivetip(\''.$phprlang['arcane'].'\')"; onMouseout="hideddrivetip()"
									  height="16" width="16">','','center');
	$report->addOutputColumn('fire','<img border="0" src="templates/' . $phpraid_config['template'] .
									  '/images/resistances/fire_resistance.gif" onMouseover=
									  "ddrivetip(\''.$phprlang['fire'].'\')"; onMouseout="hideddrivetip()"
									  height="16" width="16">','','center');
	$report->addOutputColumn('nature','<img border="0" src="templates/' . $phpraid_config['template'] .
									  '/images/resistances/nature_resistance.gif" onMouseover=
									  "ddrivetip(\''.$phprlang['nature'].'\')"; onMouseout="hideddrivetip()"
									  height="16" width="16">','','center');
	$report->addOutputColumn('frost','<img border="0" src="templates/' . $phpraid_config['template'] .
									  '/images/resistances/frost_resistance.gif" onMouseover=
									  "ddrivetip(\''.$phprlang['frost'].'\')"; onMouseout="hideddrivetip()"
									  height="16" width="16">','','center');
	$report->addOutputColumn('shadow','<img border="0" src="templates/' . $phpraid_config['template'] .
									  '/images/resistances/shadow_resistance.gif" onMouseover=
									  "ddrivetip(\''.$phprlang['shadow'].'\')"; onMouseout="hideddrivetip()"
									  height="16" width="16">','','center');
	$report->addOutputColumn('date',$phprlang['date'],'','center');
	$report->addOutputColumn('time',$phprlang['time'],'','center');
	$report->addOutputColumn('actions','','','right');

	$druid = $report->getListFromArray($druid);
	$hunter = $report->getListFromArray($hunter);
	$mage = $report->getListFromArray($mage);
	$paladin = $report->getListFromArray($paladin);
	$priest = $report->getListFromArray($priest);
	$rogue = $report->getListFromArray($rogue);
	$shaman = $report->getListFromArray($shaman);
	$warlock = $report->getListFromArray($warlock);
	$warrior = $report->getListFromArray($warrior);

	$report->clearOutputColumns();
	// setup formatting for report class (THANKS to www.thecalico.com)
	// generic settings
	setup_output();

	$report->showRecordCount(true);
	$report->allowPaging(true, $_SERVER['PHP_SELF'] . '?raid_id='.$raid_id.'&mode=view&Base=');
	$report->setListRange($_GET['Base'], 25);
	$report->allowLink(ALLOW_HOVER_INDEX,'',array());

	//Default sorting
	if(!$_GET['Sort'])
	{
		$report->allowSort(true, 'name', 'ASC', 'view.php?mode=view&raid_id='.$raid_id);
	}
	else
	{
		$report->allowSort(true, $_GET['Sort'], $_GET['SortDescending'], 'view.php?mode=view&raid_id='.$raid_id);
	}

	if($phpraid_config['show_id'] == 1)
		$report->addOutputColumn('id',$phprlang['id'],'','center');
	$report->addOutputColumn('name',$phprlang['name'],'','left');
	$report->addOutputColumn('comments',$phprlang['comments'],'','left');
	$report->addOutputColumn('lvl',$phprlang['level'],'','center');
	$report->addOutputColumn('race',$phprlang['race'],'','center');
	$report->addOutputColumn('class',$phprlang['class'],'','center');
	$report->addOutputColumn('date',$phprlang['date'],'','center');
	$report->addOutputColumn('time',$phprlang['time'],'','center');
	$report->addOutputColumn('actions','','','right');
	$raid_queue = $report->getListFromArray($raid_queue);
	$raid_cancel = $report->getListFromArray($raid_cancel);

	// last but not least, tooltips for class breakdown
	$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "raids WHERE raid_id=%s",quote_smart($raid_id));
	$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
	$data = $db_raid->sql_fetchrow($result);

	$druid_count = $druid_count . ' of ' . $data['dr_lmt'];
	$hunter_count = $hunter_count . ' of ' . $data['hu_lmt'];
	$mage_count = $mage_count . ' of ' . $data['ma_lmt'];
	$paladin_count = $paladin_count . ' of ' . $data['pa_lmt'];
	$priest_count = $priest_count . ' of ' . $data['pr_lmt'];
	$rogue_count = $rogue_count . ' of ' . $data['ro_lmt'];
	$shaman_count = $shaman_count . ' of ' . $data['sh_lmt'];
	$warlock_count = $warlock_count . ' of ' . $data['wk_lmt'];
	$warrior_count = $warrior_count . ' of ' . $data['wa_lmt'];

	// check to see if they have permissions to signup
	$show_signup = 1;
	$raid_notice = "<a href=\"#signup\">" . $phprlang['view_ok'] . "</a>";

	// check if raid is frozen
	if($phpraid_config['disable_freeze'] == 0)
	{
		if(check_frozen($raid_id)) {
			$show_signup = 0;
			$raid_notice = $phprlang['view_frozen'];
		}
	}

	// check if already signed up
	if($phpraid_config['multiple_signups'] == 0)
	{
		$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "signups WHERE raid_id=%s AND profile_id=%s",quote_smart($raid_id),quote_smart($profile_id));
		$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
		if($db_raid->sql_numrows($result) > 0)
		{
			$show_signup = 0;
			$raid_notice = $phprlang['view_signed'];
		}
	}

	// check if they have chars and that they have at least one within the range limit
	$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "chars WHERE profile_id=%s
	AND lvl<=%s AND lvl>=%s",quote_smart($profile_id),quote_smart($raid_max_lvl),quote_smart($raid_min_lvl));
	$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
	$char_count = $db_raid->sql_numrows($result);

	if($char_count <= 0)
	{
		$show_signup = 0;
		$raid_notice = '<a href="profile.php?mode=view">' . $phprlang['view_create'] . '</a>';
	}

	if($_SESSION['priv_profile'] == 0)
	{
		$show_signup = 0;
		$raid_notice = $phprlang['view_login'];
	}

	// finally, icons
	$druid_icon = '<a href="#druids" onMouseover="ddrivetip(\''.$phprlang['druid_icon'].'\')"; onMouseout="hideddrivetip()"><img src="templates/'.$phpraid_config['template'].'/images/classes/druid_icon.gif" width="24" height="24" border="0"></a>';
	$hunter_icon = '<a href="#hunters" onMouseover="ddrivetip(\''.$phprlang['hunter_icon'].'\')"; onMouseout="hideddrivetip()"><img src="templates/'.$phpraid_config['template'].'/images/classes/hunter_icon.gif" width="24" height="24" border="0"></a>';
	$mage_icon = '<a href="#mages" onMouseover="ddrivetip(\''.$phprlang['mage_icon'].'\')"; onMouseout="hideddrivetip()"><img src="templates/'.$phpraid_config['template'].'/images/classes/mage_icon.gif" width="24" height="24" border="0"></a>';
	$paladin_icon = '<a href="#paladins" onMouseover="ddrivetip(\''.$phprlang['paladin_icon'].'\')"; onMouseout="hideddrivetip()"><img src="templates/'.$phpraid_config['template'].'/images/classes/paladin_icon.gif" width="24" height="24" border="0"></a>';
	$priest_icon = '<a href="#priests" onMouseover="ddrivetip(\''.$phprlang['priest_icon'].'\')"; onMouseout="hideddrivetip()"><img src="templates/'.$phpraid_config['template'].'/images/classes/priest_icon.gif" width="24" height="24" border="0"></a>';
	$rogue_icon = '<a href="#rogues" onMouseover="ddrivetip(\''.$phprlang['rogue_icon'].'\')"; onMouseout="hideddrivetip()"><img src="templates/'.$phpraid_config['template'].'/images/classes/rogue_icon.gif" width="24" height="24" border="0"></a>';
	$shaman_icon = '<a href="#shamans" onMouseover="ddrivetip(\''.$phprlang['shaman_icon'].'\')"; onMouseout="hideddrivetip()"><img src="templates/'.$phpraid_config['template'].'/images/classes/shaman_icon.gif" width="24" height="24" border="0"></a>';
	$warlock_icon = '<a href="#warlocks" onMouseover="ddrivetip(\''.$phprlang['warlock_icon'].'\')"; onMouseout="hideddrivetip()"><img src="templates/'.$phpraid_config['template'].'/images/classes/warlock_icon.gif" width="24" height="24" border="0"></a>';
	$warrior_icon = '<a href="#warriors" onMouseover="ddrivetip(\''.$phprlang['warrior_icon'].'\')"; onMouseout="hideddrivetip()"><img src="templates/'.$phpraid_config['template'].'/images/classes/warrior_icon.gif" width="24" height="24" border="0"></a>';

	// And now create the link to the team assignment/creation form but only if RL or RA.
	if ($user_perm_group['admin'] OR $user_perm_group['RL'])
		$team_link = '<a href="teams.php?mode=view&raid_id=' . $raid_id . '">' . $phprlang['view_teams_link_text'] . '</a>';
	else
		$team_link="";

	// output
	$page->set_file('output',$phpraid_config['template'] . '/view_raid.htm');
	$page->set_var(
		array(
			'team_link'=>$team_link,
			'raid_location'=>$raid_location,
			'raid_officer'=>$raid_officer,
			'raid_date'=>$raid_date,
			'raid_invite_time'=>$raid_invite_time,
			'raid_start_time'=>$raid_start_time,
			'druid_count'=>$druid_count,
			'hunter_count'=>$hunter_count,
			'mage_count'=>$mage_count,
			'priest_count'=>$priest_count,
			'paladin_count'=>$paladin_count,
			'rogue_count'=>$rogue_count,
			'shaman_count'=>$shaman_count,
			'warlock_count'=>$warlock_count,
			'warrior_count'=>$warrior_count,
			'raid_cancel'=>$raid_cancel,
			'raid_max'=>$raid_max,
			'raid_max_percentage'=>$raid_max_percentage,
			'raid_min_lvl'=>$raid_min_lvl,
			'raid_max_lvl'=>$raid_max_lvl,
			'raid_count'=>$raid_count,
			'raid_count_percentage'=>$raid_count_percentage,
			'raid_queue'=>$raid_queue,
			'raid_cancel_count'=>$raid_cancel_count,
			'raid_cancel_percentage'=>$raid_cancel_count_percentage,
			'raid_queue_count'=>$raid_queue_count,
			'raid_queue_count_percentage'=>$raid_queue_count_percentage,
			'raid_total'=>$raid_total,
			'raid_open'=>$raid_open,
			'druids'=>$druid,
			'hunters'=>$hunter,
			'mages'=>$mage,
			'priests'=>$priest,
			'paladins'=>$paladin,
			'rogues'=>$rogue,
			'shamans'=>$shaman,
			'warlocks'=>$warlock,
			'warriors'=>$warrior,
			'raid_notice'=>$raid_notice,
			'raid_description'=>$raid_description,
			'cancel_text'=>$phprlang['view_raid_cancel_text'],
			'raid_description_header'=>$phprlang['view_description_header'],
			'location_text'=>$phprlang['view_location'],
			'date_text'=>$phprlang['view_date'],
			'officer_text'=>$phprlang['view_officer'],
			'invite_text'=>$phprlang['view_invite'],
			'start_text'=>$phprlang['view_start'],
			'signup_text'=>$phprlang['view_signup'],
			'minlvl_text'=>$phprlang['view_min_lvl'],
			'maxlvl_text'=>$phprlang['view_max_lvl'],
			'maxattendees_text'=>$phprlang['view_max'],
			'approved_text'=>$phprlang['view_approved'],
			'queued_text'=>$phprlang['view_queued'],
			'raid_cancel_header'=>$phprlang['view_cancel_header'],
			'total_text'=>$phprlang['view_total'],
			'raid_queue_header'=>$phprlang['view_queue_header'],
			'information_header'=>$phprlang['view_information_header'],
			'statistics_header'=>$phprlang['view_statistics_header'],
			'druid_header'=>$phprlang['druid'],
			'hunter_header'=>$phprlang['hunter'],
			'mage_header'=>$phprlang['mage'],
			'priest_header'=>$phprlang['priest'],
			'paladin_header'=>$phprlang['paladin'],
			'rogue_header'=>$phprlang['rogue'],
			'shaman_header'=>$phprlang['shaman'],
			'warrior_header'=>$phprlang['warrior'],
			'warlock_header'=>$phprlang['warlock'],
			'druid_icon'=>$druid_icon,
			'hunter_icon'=>$hunter_icon,
			'mage_icon'=>$mage_icon,
			'paladin_icon'=>$paladin_icon,
			'priest_icon'=>$priest_icon,
			'rogue_icon'=>$rogue_icon,
			'shaman_icon'=>$shaman_icon,
			'warlock_icon'=>$warlock_icon,
			'warrior_icon'=>$warrior_icon
		)
	);

}
elseif($mode == 'signup')
{
	// they're wanting to signup
	if(!isset($_POST['submit']))
	{
		// they tried to view this page without using the form which is a nono
		header("Location: view.php?mode=view&raid_id=$raid_id");
	}
	else
	{
		// setup post vars
		$char_id = scrub_input($_POST['character']);

		// Did he/she/it cancel? or queued? or just normal signup...
		if($_POST['queue'] == "queue")
		{
			$queue = 1;
			$cancel = 0;
		}
		else
		{
			$cancel = 0;
			$queue = 0;
		}

		if($phpraid_config['auto_queue'] == '0')
		{
			// now check class limits
			// setup the count array
			$count = array('dr'=>'0','hu'=>'0','ma'=>'0','pa'=>'0','pr'=>'0','ro'=>'0','sh'=>'0','wk'=>'0','wa'=>'0');
			$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "signups WHERE raid_id=%s AND queue='0' AND cancel='0'",quote_smart($raid_id));
			$result_char = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
			while($char = $db_raid->sql_fetchrow($result_char))
			{
				$signup_char_id = scrub_input($char['char_id']);
				$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "chars WHERE char_id=%s", quote_smart($signup_char_id));
				$result_count = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
				$tmp = $db_raid->sql_fetchrow($result_count);

				switch($tmp['class'])
				{
					case $phprlang['druid']:
						$count['dr']++;
						break;
					case $phprlang['hunter']:
						$count['hu']++;
						break;
					case $phprlang['mage']:
						$count['ma']++;
						break;
					case $phprlang['paladin']:
						$count['pa']++;
						break;
					case $phprlang['priest']:
						$count['pr']++;
						break;
					case $phprlang['rogue']:
						$count['ro']++;
						break;
					case $phprlang['shaman']:
						$count['sh']++;
						break;
					case $phprlang['warlock']:
						$count['wk']++;
						break;
					case $phprlang['warrior']:
						$count['wa']++;
						break;
				}
			}
			$sql = sprintf("SELECT dr_lmt,hu_lmt,ma_lmt,pa_lmt,pr_lmt,ro_lmt,sh_lmt,wk_lmt,wa_lmt FROM " . $phpraid_config['db_prefix'] . "raids WHERE raid_id=%s", quote_smart($raid_id));
			$result_raid = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
			$total = $db_raid->sql_fetchrow($result_raid);

			$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "chars WHERE char_id=%s", quote_smart($char_id));
			$result_class = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
			$class = $db_raid->sql_fetchrow($result_class);

			$queue = scrub_input($_POST['queue']);
			switch($class['class'])
			{
				case $phprlang['druid']:
					if($queue == "cancel")
					{
						$queue = 0;
						$cancel = 1;
					}
					elseif($count['dr'] >= $total['dr_lmt'])
					{
						$queue = 1;
						$cancel = 0;
					}
					break;
				case $phprlang['hunter']:
					if($queue == "cancel")
					{
						$queue = 0;
						$cancel = 1;
					}
					elseif($count['hu'] >= $total['hu_lmt'])
					{
						$queue = 1;
						$cancel = 0;
					}
					break;
				case $phprlang['mage']:
					if($queue == "cancel")
					{
						$queue = 0;
						$cancel = 1;
					}
					elseif($count['ma'] >= $total['ma_lmt'])
					{
						$queue = 1;
						$cancel = 0;
					}
					break;
				case $phprlang['paladin']:
					if($queue == "cancel")
					{
						$queue = 0;
						$cancel = 1;
					}
					elseif($count['pa'] >= $total['pa_lmt'])
					{
						$queue = 1;
						$cancel = 0;
					}
					break;
				case $phprlang['priest']:
					if($queue == "cancel")
					{
						$queue = 0;
						$cancel = 1;
					}
					elseif($count['pr'] >= $total['pr_lmt'])
					{
						$queue = 1;
						$cancel = 0;
					}
					break;
				case $phprlang['rogue']:
					if($queue == "cancel")
					{
						$queue = 0;
						$cancel = 1;
					}
					elseif($count['ro'] >= $total['ro_lmt'])
					{
						$queue = 1;
						$cancel = 0;
					}
					break;
				case $phprlang['shaman']:
					if($queue == "cancel")
					{
						$queue = 0;
						$cancel = 1;
					}
					elseif($count['sh'] >= $total['sh_lmt'])
					{
						$queue = 1;
						$cancel = 0;
					}
					break;
				case $phprlang['warlock']:
					if($queue == "cancel")
					{
						$queue = 0;
						$cancel = 1;
					}
					elseif($count['wk'] >= $total['wk_lmt'])
					{
						$queue = 1;
						$cancel = 0;
					}
					break;
				case $phprlang['warrior']:
					if($queue == "cancel")
					{
						$queue = 0;
						$cancel = 1;
					}
					elseif($count['wa'] >= $total['wa_lmt'])
					{
						$queue = 1;
						$cancel = 0;
					}
					break;
			}
		}
		else
		{
			if($queue == "cancel")
			{
				$queue = 0;
				$cancel = 1;
			}
			else
			{
				$cancel = 0;
				$queue = 1;
			}
		}

		$comments = DEUBB(scrub_input($_POST['comments']));
		$timestamp = scrub_input($_POST['timestamp']);
		$profile_id = scrub_input($_SESSION['profile_id']);

		$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "signups WHERE raid_id=%s AND char_id=%s AND profile_id=%s", quote_smart($raid_id), quote_smart($char_id), quote_smart($profile_id));
		$result_signup = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
		if($db_raid->sql_numrows($result_signup) > 0) {
			$form_error = 1;
			$errorTitle = $phprlang['form_error'];
			$errorMsg = $phprlang['view_error_signed_up'];
			$errorDie = 1;
			$errorSpace = 1;
		}else{
			log_raid($char_id, $raid_id, 'signup');

			$sql = sprintf("INSERT INTO " . $phpraid_config['db_prefix'] . "signups
						(`char_id`,`profile_id`,`raid_id`,`comments`,`queue`,`timestamp`,`cancel`)
					VALUES
						(%s,%s,%s,%s,%s,%s,%s)", quote_smart($char_id), quote_smart($profile_id), quote_smart($raid_id),
						quote_smart($comments), quote_smart($queue), quote_smart($timestamp), quote_smart($cancel));
			$db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
			header("Location: view.php?mode=view&raid_id=$raid_id");
		}
	}
}
elseif($mode == 'delete')
{
	$char_id = scrub_input($_GET['char_id']);
	$raid_id = scrub_input($_GET['raid_id']);
	$profile_id = scrub_input($_GET['profile_id']);
	$S_profile_id = scrub_input($_SESSION['profile_id']);

	if($user_perm_group['admin'] == 1 or $user_perm_group['RL'] == 1 or $S_profile_id == $profile_id) {
		// they have permission to delete
		if(!isset($_POST['submit'])) {
			$form_action = 'view.php?mode=delete&profile_id=' . $profile_id . '&raid_id=' . $raid_id . '&char_id=' . $char_id;
			$confirm_button = '<input type="submit" value="Confirm" name="submit" class="post">';

			$page->set_file('output',$phpraid_config['template'] . '/delete.htm');

			$page->set_var(
				array(
					'form_action'=>$form_action,
					'confirm_button'=>$confirm_button,
					'delete_header'=>$phprlang['delete_header'],
					'delete_msg'=>$phprlang['delete_msg'],
				)
			);
			$page->parse('output','output');
		} else {
			$sql = sprintf("DELETE FROM " . $phpraid_config['db_prefix'] . "signups WHERE char_id=%s AND raid_id=%s", quote_smart($char_id), quote_smart($raid_id));
			$db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);

			log_raid($char_id, $raid_id, 'delete');

			header("Location: view.php?mode=view&raid_id=$raid_id");
		}
	} else {
		header("Location: index.php");
	}
}
elseif($mode == 'queue')
{
	// check for hack attempt
	if(!isset($_GET['char_id']) || !is_numeric($_GET['char_id']))
		log_hack();

	$char_id = scrub_input($_GET['char_id']);
	$raid_id = scrub_input($_GET['raid_id']);
	$S_profile_id = scrub_input($_SESSION['profile_id']);

	// Get Profile ID with Char ID to verify user.
	$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "signups WHERE raid_id=%s AND char_id=%s", quote_smart($raid_id), quote_smart($char_id));
	$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
	$data = $db_raid->sql_fetchrow($result);

	$profile_id = $data['profile_id'];

	$priv_raids = scrub_input($_SESSION['priv_raids']);

	// verify user is editing own data
	if($priv_raids != 1 && $user_perm_group['RL'] != 1 &&
		$S_profile_id != $profile_id)
		log_hack();

	$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "signups WHERE raid_id=%s AND char_id=%s", quote_smart($raid_id), quote_smart($char_id));
	$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
	$data = $db_raid->sql_fetchrow($result);

	//Check for a hacking attempt sending in a URL without clicking a button.
	$hackattempt=1;
	if(($user_perm_group['admin'] && $data['cancel'] && $phpraid_config['admin_cancel_queue']) ||
	($user_perm_group['admin'] && !$data['queue'] && !$data['cancel'] && $phpraid_config['admin_drafted_queue']))
		$hackattempt=0;

	if (($user_perm_group['RL'] && $data['cancel'] && $phpraid_config['rl_cancel_queue']) ||
	($user_perm_group['RL'] && !$data['queue'] && !$data['cancel'] && $phpraid_config['rl_drafted_queue']))
		$hackattempt=0;

	if (($data['cancel'] && $phpraid_config['user_cancel_queue']) ||
	(!$data['queue'] && !$data['cancel'] && $phpraid_config['user_drafted_queue']))
		$hackattempt=0;

	if($hackattempt)
		log_hack();
	else
	{
		$sql = sprintf("UPDATE " . $phpraid_config['db_prefix'] . "signups set queue='1',cancel='0' WHERE raid_id=%s AND char_id=%s", quote_smart($raid_id), quote_smart($char_id));
		$db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);

		log_raid($char_id, $raid_id, 'queue_in');
	}
	header("Location: view.php?mode=view&raid_id=$raid_id&Sort=$sort_mode&SortDescending=$sort_descending");
}
elseif($mode == 'draft')
{
	// check for hack attempt
	if(!isset($_GET['char_id']) || !is_numeric($_GET['char_id']))
		log_hack();

	$char_id = scrub_input($_GET['char_id']);
	$raid_id = scrub_input($_GET['raid_id']);
	$S_profile_id = scrub_input($_SESSION['profile_id']);

	// Get Profile ID with Char ID to verify user.
	$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "signups WHERE raid_id=%s AND char_id=%s", quote_smart($raid_id), quote_smart($char_id));
	$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
	$data = $db_raid->sql_fetchrow($result);

	// verify user is editing own data
	if($user_perm_group['admin'] != 1 && $user_perm_group['RL'] != 1 &&
		$S_profile_id != $data['profile_id'])
		log_hack();

	// now check class limits to prevent users cheating the cancel/queue signup
	// setup the count array
	$count = array('dr'=>'0','hu'=>'0','ma'=>'0','pa'=>'0','pr'=>'0','ro'=>'0','sh'=>'0','wk'=>'0','wa'=>'0');
	$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "signups WHERE raid_id=%s AND queue='0' AND cancel='0'",quote_smart($raid_id));
	$result_char = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
	while($char = $db_raid->sql_fetchrow($result_char))
	{
		$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "chars WHERE char_id=%s", quote_smart($char['char_id']));
		$result_count = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
		$tmp = $db_raid->sql_fetchrow($result_count);

		switch($tmp['class'])
		{
			case $phprlang['druid']:
				$count['dr']++;
				break;
			case $phprlang['hunter']:
				$count['hu']++;
				break;
			case $phprlang['mage']:
				$count['ma']++;
				break;
			case $phprlang['paladin']:
				$count['pa']++;
				break;
			case $phprlang['priest']:
				$count['pr']++;
				break;
			case $phprlang['rogue']:
				$count['ro']++;
				break;
			case $phprlang['shaman']:
				$count['sh']++;
				break;
			case $phprlang['warlock']:
				$count['wk']++;
				break;
			case $phprlang['warrior']:
				$count['wa']++;
				break;
		}
	}
	$sql = sprintf("SELECT dr_lmt,hu_lmt,ma_lmt,pa_lmt,pr_lmt,ro_lmt,sh_lmt,wk_lmt,wa_lmt FROM " . $phpraid_config['db_prefix'] . "raids WHERE raid_id=%s", quote_smart($raid_id));
	$result_raid = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
	$total = $db_raid->sql_fetchrow($result_raid);

	$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "chars WHERE char_id=%s", quote_smart($char_id));
	$result_class = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
	$class = $db_raid->sql_fetchrow($result_class);

	$queue=0;
	switch($class['class'])
	{
		case $phprlang['druid']:
			if($count['dr'] >= $total['dr_lmt'])
				$queue = 1;
			break;
		case $phprlang['hunter']:
			if($count['hu'] >= $total['hu_lmt'])
				$queue = 1;
			break;
		case $phprlang['mage']:
			if($count['ma'] >= $total['ma_lmt'])
				$queue = 1;
			break;
		case $phprlang['paladin']:
			if($count['pa'] >= $total['pa_lmt'])
				$queue = 1;
			break;
		case $phprlang['priest']:
			if($count['pr'] >= $total['pr_lmt'])
				$queue = 1;
			break;
		case $phprlang['rogue']:
			if($count['ro'] >= $total['ro_lmt'])
				$queue = 1;
			break;
		case $phprlang['shaman']:
			if($count['sh'] >= $total['sh_lmt'])
				$queue = 1;
			break;
		case $phprlang['warlock']:
			if($count['wk'] >= $total['wk_lmt'])
				$queue = 1;
			break;
		case $phprlang['warrior']:
			if($count['wa'] >= $total['wa_lmt'])
				$queue = 1;
			break;
	}

	$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "signups WHERE raid_id=%s AND char_id=%s", quote_smart($raid_id), quote_smart($char_id));
	$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
	$data = $db_raid->sql_fetchrow($result);

	//Debug Section
	//echo "<br>user_perm_group_admin: " . $user_perm_group['admin'];
	//echo "<br>user_perm_group_RL: " . $user_perm_group['RL'];
	//echo "<br>data_cancel: " . $data['cancel'];
	//echo "<br>data_queue: " . $data['queue'];
	//echo "<br>phpraid_config: admin_cancel_promote :" . $phpraid_config['admin_cancel_promote'];
	//echo "<br>phpraid_config: admin_queue_promote :" . $phpraid_config['admin_queue_promote'];
	//echo "<br>phpraid_config: rl_cancel_promote :" . $phpraid_config['rl_cancel_promote'];
	//echo "<br>phpraid_config: rl_queue_promote :" . $phpraid_config['rl_queue_promote'];
	//echo "<br>phpraid_config: user_cancel_promote :" . $phpraid_config['user_cancel_promote'];
	//echo "<br>phpraid_config: user_queue_promote :" . $phpraid_config['user_queue_promote'];

	//Check for a hacking attempt sending in a URL without clicking a button.
	$hackattempt=1;
	if(($user_perm_group['admin'] && $data['cancel'] && $phpraid_config['admin_cancel_promote']) ||
	($user_perm_group['admin'] && $data['queue'] && $phpraid_config['admin_queue_promote']))
		$hackattempt=0;

	if (($user_perm_group['RL'] && $data['cancel'] && $phpraid_config['rl_cancel_promote']) ||
	($user_perm_group['RL'] && $data['queue'] && $phpraid_config['rl_queue_promote']))
		$hackattempt=0;

	if (($data['cancel'] && $phpraid_config['user_cancel_promote']) ||
	($data['queue'] && $phpraid_config['user_queue_promote']))
		$hackattempt=0;

	if($hackattempt)
		log_hack();
	else
	{
		if ($queue)
		{
			// Too many of this type, set back to queue.
			$sql = sprintf("UPDATE " . $phpraid_config['db_prefix'] . "signups set queue='1',cancel='0' WHERE raid_id=%s AND char_id=%s", quote_smart($raid_id), quote_smart($char_id));
			$db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);

			log_raid($char_id, $raid_id, 'queue_in');
		}
		else
		{
			//Open spot in raid, draft them.
			$sql = sprintf("UPDATE " . $phpraid_config['db_prefix'] . "signups set queue='0',cancel='0' WHERE raid_id=%s AND char_id=%s", quote_smart($raid_id), quote_smart($char_id));
			$db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);

			log_raid($char_id, $raid_id, 'queue_out');
		}
	}
	header("Location: view.php?mode=view&raid_id=$raid_id&Sort=$sort_mode&SortDescending=$sort_descending");
}
elseif($mode == 'cancel')
{
	$S_profile_id = scrub_input($_SESSION['profile_id']);
	$profile_id = scrub_input($_GET['profile_id']);

	// check for hack attempt
	if(!isset($_GET['char_id']) || !is_numeric($_GET['char_id']))
		log_hack();

	if(!isset($_GET['profile_id']) || !is_numeric($_GET['profile_id']))
		log_hack();

	// verify user is editing own data
	if($priv_raids != 1 && $user_perm_group['RL'] != 1)
	{
		if($S_profile_id != $profile_id)
			log_hack();
	}

	$char_id = scrub_input($_GET['char_id']);
	$raid_id = scrub_input($_GET['raid_id']);

	$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "signups WHERE raid_id=%s AND char_id=%s", quote_smart($raid_id), quote_smart($char_id));
	$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
	$data = $db_raid->sql_fetchrow($result);
	if($S_profile_id == $data['profile_id'] || $priv_raids == 1) {
		if($data['cancel'] == 0) {
			$sql = sprintf("UPDATE " . $phpraid_config['db_prefix'] . "signups set cancel='1',queue='0' WHERE raid_id=%s AND char_id=%s", quote_smart($raid_id), quote_smart($char_id));
			$db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);

			// put in cancel
			log_raid($char_id, $raid_id, 'cancel_in');
		} else {
			$sql = sprintf("UPDATE " . $phpraid_config['db_prefix'] . "signups set cancel='0',queue='0' WHERE raid_id=%s AND char_id=%s", quote_smart($raid_id), quote_smart($char_id));
			$db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);

			// removed from cancel
			log_raid($char_id, $raid_id, 'cancel_out');
		}
	}
	header("Location: view.php?mode=view&raid_id=$raid_id");
}
else if($mode == 'edit_comment')
{
	$S_profile_id = scrub_input($_SESSION['profile_id']);

	// validate input
	isset($_GET['signup_id']) ? $signup_id = scrub_input($_GET['signup_id']) : $signup_id = '';

	if($signup_id == '')
		log_hack();

	$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "signups WHERE signup_id=%s", quote_smart($signup_id));
	$result = $db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$data = $db_raid->sql_fetchrow($result);

	// verify user
	if($S_profile_id != $data['profile_id'] AND
						$user_perm_group['admin'] == 0 AND
						$user_perm_group['RL'] == 0)
		log_hack();

	if(!isset($_POST['submit']))
	{
		$edit_comment = $data['comments'];
		$view_edit = '<form action="view.php?mode=edit_comment&raid_id='.$raid_id.'&signup_id='.$signup_id.'" method="POST">';
		$view_edit .= '<textarea name="comments" cols="30" rows="7" class="post">'.$edit_comment.'</textarea><br><br>';
		$view_edit .= '<input type="submit" name="submit" value="'.$phprlang['edit'].'" class="mainoption"> ';
		$view_edit .= '<input type="reset" name="reset" value="'.$phprlang['reset'].'" class="liteoption">';
		$view_edit .= '</form>';
	}
	else
	{
		$comments = DEUBB(scrub_input($_POST['comments']));

		$sql = sprintf("UPDATE " . $phpraid_config['db_prefix'] . "signups SET comments=%s WHERE signup_id=%s", quote_smart($comments), quote_smart($signup_id));
		$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);

		header("Location: view.php?mode=view&raid_id=$raid_id");
	}

	$page->set_file('view_output',$phpraid_config['template'].'/view_edit.htm');
	$page->set_var(
		array(
			'header'=>$phprlang['view_edit_header'],
			'view_edit'=>$view_edit
		)
	);
	$page->parse('output','view_output',true);
}
else
{
	$errorMsg = $phprlang['invalid_option_msg'];
	$errorTitle = $phprlang['invalid_option_title'];
	$errorDie = 1;
}

require_once('./includes/page_header.php');

$page->pparse('output','output');

$priv_profile = scrub_input($_SESSION['priv_profile']);

if($show_signup == 1 && $priv_profile == 1)
{
	$profile_id = scrub_input($_SESSION['profile_id']);

	// setup min/max levels
	$sql = sprintf("SELECT min_lvl,max_lvl FROM " . $phpraid_config['db_prefix'] . "raids WHERE raid_id=%s", quote_smart($raid_id));
	$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
	$limit = $db_raid->sql_fetchrow($result);

	$signup_action = 'view.php?mode=signup&raid_id=' . $raid_id;

	// set vars
	$username = scrub_input($_SESSION['username']);

	// get character list
	$character = '<select name="character" class="post">';
	$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "chars WHERE profile_id=%s", quote_smart($profile_id));
	$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
	while($data = $db_raid->sql_fetchrow($result))
	{
		$sql = sprintf("SELECT lvl FROM " . $phpraid_config['db_prefix'] . "chars WHERE char_id=%s", quote_smart($data['char_id']));
		$result_lvl = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
		$lvl = $db_raid->sql_fetchrow($result_lvl);

		if($lvl['lvl'] >= $limit['min_lvl'] && $lvl['lvl'] <= $limit['max_lvl'])
			$character .= '<option value="' . $data['char_id'] . '">' . $data['name'] . '</option>';
	}
	$character .= '</select>';

	if($phpraid_config['auto_queue'] == 1)
	{
		$queue = '
				<select name="queue">
				<option value="queue" selected>Signup as queued</option>
				<option value="cancel">Signup as cancelled</option>
				</select>
				';
	}
	else
	{
		$queue = '
				<select name="queue">
				<option value="signup" selected>Signup as available</option>
				<option value="queue">Signup as queued</option>
				<option value="cancel">Signup as cancelled</option>
				</select>
				';
	}

	$comments = '<textarea name="comments" cols="30" rows="7" class="post"></textarea>';
	$timestamp = time();

	$hidden_vars = '<input name="timestamp" type="hidden" value="' . $timestamp . '">';

	$page->set_file('signup_output',$phpraid_config['template'] . '/view_signup.htm');
	$page->set_var(
		array(
			'username'=>$username,
			'character'=>$character,
			'queue'=>$queue,
			'comments'=>$comments,
			'signup_action'=>$signup_action,
			'hidden_vars'=>$hidden_vars,
			'view_signup_header'=>$phprlang['view_new'],
			'username_text'=>$phprlang['view_username'],
			'character_text'=>$phprlang['view_character'],
			'queue_text'=>$phprlang['view_queue'],
			'comments_text'=>$phprlang['view_comments']
		)
	);
	$page->pparse('signup_output','signup_output');
}

require_once('./includes/page_footer.php');
?>