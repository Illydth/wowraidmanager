<?php
/***************************************************************************
*                           functions_users.php
*                           ---------------------
*   begin                : Friday, May 26, 2006
*   copyright            : (C) 2007-2008 Douglas Wagner
*   email                : douglasw@wagnerweb.org
*
*   $Id: functions_users.php,v 2.00 2008/03/03 15:24:16 psotfx Exp $
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

function check_frozen($raid_id) {
	global $db_raid, $phpraid_config;
	
	$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "raids where raid_id='$raid_id'";
	$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
	$data = $db_raid->sql_fetchrow($result);
	
 	$raid_date_month = new_date("m",$data['start_time'],$phpraid_config['timezone'] + $phpraid_config['dst']);
	$raid_date_day = new_date("d",$data['start_time'],$phpraid_config['timezone'] + $phpraid_config['dst']);
	$raid_date_year = new_date("Y",$data['start_time'],$phpraid_config['timezone'] + $phpraid_config['dst']);
	$raid_time_hour = new_date("H",$data['invite_time'],$phpraid_config['timezone'] + $phpraid_config['dst']);
	$raid_time_minute = new_date("i",$data['invite_time'],$phpraid_config['timezone'] + $phpraid_config['dst']);
	$cur_date_month = new_date("m",time(),$phpraid_config['timezone'] + $phpraid_config['dst']);
	$cur_date_day = new_date("d",time(),$phpraid_config['timezone'] + $phpraid_config['dst']);
	$cur_date_year = new_date("Y",time(),$phpraid_config['timezone'] + $phpraid_config['dst']);
	$cur_time_hour = new_date("H",time(),$phpraid_config['timezone'] + $phpraid_config['dst']);
	$cur_time_minute = new_date("i",time(),$phpraid_config['timezone'] + $phpraid_config['dst']);
	$freeze = $data['freeze'];
	
	// check if raid is frozen
	if($phpraid_config['disable_freeze'] == 0)
	{
		$frozen = 0;
		
		if($raid_date_year < $cur_date_year)
		{
			$frozen = 1;
		}
		elseif($raid_date_year == $cur_date_year)
		{
			if($raid_date_month < $cur_date_month)
			{
				$frozen = 1;
			}
			elseif($raid_date_month == $cur_date_month)
			{
				if($raid_date_day < $cur_date_day)
				{
					$frozen = 1;
				}
				elseif($raid_date_day == $cur_date_day)
				{
					if($raid_time_hour < ($cur_time_hour + $freeze))
					{
						$frozen = 1;
					}
					elseif($raid_time_hour == ($cur_time_hour + $freeze))
					{
						if($raid_time_minute < $cur_time_minute)
							$frozen = 1;
					}
				}
			}
		}
	}
	
	return $frozen;
}

function get_char_count($id, $type) {
	global $db_raid, $phpraid_config, $phprlang;
	
	$count = array('dr'=>'0','hu'=>'0','ma'=>'0','pa'=>'0','pr'=>'0','ro'=>'0','sh'=>'0','wk'=>'0','wa'=>'0');
	
	if($type == "backup")
	{
		$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "signups WHERE raid_id='$id' AND queue='1' AND cancel='0'"; 
		$result_signups = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
	}
	else
	{
		$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "signups WHERE raid_id='$id' AND queue='0' AND cancel='0'"; 
		$result_signups = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
	}
	while($signups = $db_raid->sql_fetchrow($result_signups)) {
		$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "chars WHERE char_id='{$signups['char_id']}'";
		$result_char = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
		$char = $db_raid->sql_fetchrow($result_char);

		switch($char['class']) {
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
	
	return $count;
}

function get_priv_name($id)
{
	global $db_raid, $phpraid_config;
	
	$sql = "SELECT `name` FROM " . $phpraid_config['db_prefix'] . "permissions WHERE permission_id='$id'";
	$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
	$data = $db_raid->sql_fetchrow($result);
	
	return($data['name']);
}

function get_queued($raid_id) {
	global $db_raid, $phpraid_config;
	
	$queued = array();
	
	$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "queues";
	$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
	while($data = $db_raid->sql_fetchrow($result)) {
		if($raid_id == $data['raid_id']) {
			// match, push onto array
			array_push($queued, array('pos'=>$data['pos'],'char_id'=>$data['char_id']));
		}
	}
	
	// sort by position so we make sure to output them in order
	array_multisort($queued);
		
	return $queued;
}

function get_signups($raid_id) {
	global $db_raid, $phpraid_config;
	
	$signups = array();
	
	$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "signups";
	$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
	while($data = $db_raid->sql_fetchrow($result)) 	{
		if($raid_id == $data['raid_id']) {
			// match, push onto array
			array_push($signups, array('pos'=>$data['pos'],'char_id'=>$data['char_id']));
		}
	}
	
	// sort by position so we make sure to output them in order
	array_multisort($signups);
	
	return $signups;
}

function is_char_cancel($profile_id, $raid_id) {
	global $db_raid, $phpraid_config;
	
	$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "signups WHERE profile_id='$profile_id' AND raid_id='$raid_id' AND cancel='1'";
	$result = $db_raid->sql_query($sql);
	
	if($db_raid->sql_numrows($result) == 0)
		return 0;
	else
		return 1;
}

function is_char_signed($profile_id, $raid_id) {
	global $db_raid, $phpraid_config;
	
	$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "signups WHERE profile_id='$profile_id' AND raid_id='$raid_id'";
	$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
	if($db_raid->sql_numrows($result) > 0)
		return 1;
	else
		return 0;		
}

function isCharExist($charName) {
	global $db_raid, $phpraid_config;
	
	$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "chars WHERE name='".$charName."'";
	$result = $db_raid->sql_query($sql);
	return $db_raid->sql_numrows($result);
}