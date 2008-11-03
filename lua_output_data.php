<?php
/***************************************************************************
 *                            lua_output_data.php
 *                            -------------------
 *   begin                : Saturday, Jan 16, 2005
 *   copyright            : (C) 2007-2008 Douglas Wagner
 *   email                : douglasw@wagnerweb.org
 *
 *   $Id: lua_output_data.php,v 2.00 2008/03/08 13:51:56 psotfx Exp $
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
class Output_Data
{
	function GetOptions()
	{
		global $phpraid_config;
		
		//$phpraid_config['lua_output_sort_signups']
		//$phpraid_config['lua_output_sort_queue']
		//	1=name, 2=date, 3=class
		
		if (!array_key_exists('lua_output_sort_signups', $phpraid_config))
		{
			$phpraid_config['lua_output_sort_signups'] = 1;
		}
		if (!array_key_exists('lua_output_sort_queue', $phpraid_config))
		{
			$phpraid_config['lua_output_sort_queue'] = 2;
		}
		if (!array_key_exists('lua_output_format', $phpraid_config))
		{
			$phpraid_config['lua_output_format'] = 1;
		}
	}
	
	function ShowOptions()
	{
		global $db_raid, $text, $phpraid_config;

		$selected[1] = ($phpraid_config['lua_output_sort_signups'] == 1) ? 'SELECTED' : '';
		$selected[2] = ($phpraid_config['lua_output_sort_signups'] == 2) ? 'SELECTED' : '';
		$selected[3] = ($phpraid_config['lua_output_sort_queue'] == 1) ? 'SELECTED' : '';
		$selected[4] = ($phpraid_config['lua_output_sort_queue'] == 2) ? 'SELECTED' : '';
		$selected[5] = ($phpraid_config['lua_output_sort_queue'] == 3) ? 'SELECTED' : '';
		$selected[6] = ($phpraid_config['lua_output_format'] == 1) ? 'SELECTED' : '';
		$selected[7] = ($phpraid_config['lua_output_format'] == 2) ? 'SELECTED' : '';
		
		$raid_id = scrub_input($_GET['raid_id']);
		
		$text .= '<form method="post" action="lua_output.php?raid_id=' . $raid_id . '&amp;name=post">';
		$text .= '<table width="300" align="center">';
		$text .= '<tr><th colspan="2">Options</th></tr>';
		$text .= '<tr>';
		$text .= '<td>Sort signups by:</td>';
		$text .= '<td><select name="config[lua_output_sort_signups]" size=1>';
		$text .= '<option '.$selected[1].' value="1">Name</option>';
		$text .= '<option '.$selected[2].' value="2">Date</option>';
		$text .= '</select></td>';
		$text .= '</tr><tr>';
		$text .= '<td>Sort queue by:</td>';
		$text .= '<td><select name="config[lua_output_sort_queue]" size=1>';
		$text .= '<option '.$selected[3].' value="1">Name</option>';
		$text .= '<option '.$selected[4].' value="2">Date</option>';
		$text .= '<option '.$selected[5].' value="3">Class</option>';
		$text .= '</select></td>';
		$text .= '</tr><tr>';
		$text .= '<td>Output Format:</td>';
		$text .= '<td><select name="config[lua_output_format]" size=1>';
		$text .= '<option '.$selected[6].' value="1">RIM (Raid Invite Manager)</option>';
		$text .= '<option '.$selected[7].' value="2">PHP Raid Viewer</option>';
		$text .= '</select></td>';
		$text .= '<tr>';
		$text .= '<td align="left" colspan="2"><input type="submit" name="parse" value="Apply options" class="mainoption"></td>';
		$text .= '</tr>';
		$text .= '</table>';
		$text .= '</form>';
	}
	
	function UpdateOptions()
	{
		global $db_raid, $phpraid_config;
		
		$phpraid_config['lua_output_sort_signups'] = scrub_input($_POST['config']['lua_output_sort_signups']);
		$phpraid_config['lua_output_sort_queue'] = scrub_input($_POST['config']['lua_output_sort_queue']);
		$phpraid_config['lua_output_format'] = scrub_input($_POST['config']['lua_output_format']);
		
		//Enter the Signup Sorting order for LUA Output
		$sql = "SELECT config_name FROM `".$phpraid_config['db_prefix']."config` WHERE `config_name`= 'lua_output_sort_signups';";
		$result = $db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
		if ($db_raid->sql_numrows($result) != 0)
		{
			$sql = sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value`=%s WHERE `config_name`= 'lua_output_sort_signups';", quote_smart($phpraid_config['lua_output_sort_signups']));
		}
		else
		{
			$sql = sprintf("INSERT INTO `".$phpraid_config['db_prefix']."config` (`config_name`, `config_value`) VALUES('lua_output_sort_signups', %s);", quote_smart($phpraid_config['lua_output_sort_signups']));
		}
		$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
		
		//Enter the Queue Sorting Order for LUA Output
		$sql = "SELECT config_name FROM `".$phpraid_config['db_prefix']."config` WHERE `config_name`= 'lua_output_sort_queue';";
		$result = $db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
		if ($db_raid->sql_numrows($result) != 0)
		{
			$sql = sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value`=%s WHERE `config_name`= 'lua_output_sort_queue';", quote_smart($phpraid_config['lua_output_sort_queue']));
		}
		else
		{
			$sql = sprintf("INSERT INTO `".$phpraid_config['db_prefix']."config` (`config_name`, `config_value`) VALUES('lua_output_sort_queue', %s);", quote_smart($phpraid_config['lua_output_sort_queue']));
		}
		$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);

		//Enter the Output Format for LUA Output
		$sql = "SELECT config_name FROM `".$phpraid_config['db_prefix']."config` WHERE `config_name`= 'lua_output_format';";
		$result = $db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
		if ($db_raid->sql_numrows($result) != 0)
		{
			$sql = sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value`=%s WHERE `config_name`= 'lua_output_format';", quote_smart($phpraid_config['lua_output_format']));
		}
		else
		{
			$sql = sprintf("INSERT INTO `".$phpraid_config['db_prefix']."config` (`config_name`, `config_value`) VALUES('lua_output_format', %s);", quote_smart($phpraid_config['lua_output_format']));
		}
		$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	}
	
	function GetClassIdByClassName($class)
	{
		global $phprlang;
		
		switch(strtolower($class))
		{
			case strtolower($phprlang['druid']):
				return 1;
			case strtolower($phprlang['hunter']):
				return 2;
			case strtolower($phprlang['mage']):
				return 3;
			case strtolower($phprlang['paladin']):
				return 4;
			case strtolower($phprlang['priest']):
				return 5;
			case strtolower($phprlang['rogue']):
				return 6;
			case strtolower($phprlang['shaman']):
				return 7;
			case strtolower($phprlang['warlock']):
				return 8;
			case strtolower($phprlang['warrior']):
				return 9;
			case strtolower($phprlang['deathknight']);
				return 10;
		}
	}
	
	function GetClassNameByClassId($id)
	{
		global $phprlang;
		
		switch($id)
		{
			case 0:
				return 'queue';
			case 1:
				return 'druids';
			case 2:
				return 'hunters';
			case 3:
				return 'mages';
			case 4:
				return 'paladins';
			case 5:
				return 'priests';
			case 6:
				return 'rogues';
			case 7:
				return 'shaman';
			case 8:
				return 'warlocks';
			case 9:
				return 'warriors';
			case 10:
				return 'deathknights';
		}
	}
	
	function Output_Macro()
	{
		global $db_raid, $text, $phpraid_config;
		
		// macro output
		// non-queued first
		$text .= "<b>Macro output listing...</b>";
		$text .= '<table width="100%"><tr>';
		$text .= "<td>Non-queued users</td>";
		$text .= "<td>Queued users</td></tr>";
		$text .= '<tr><td width="50%"><textarea rows="10" cols="60" style="width: 100%">';
		
		$raid_id = scrub_input($_GET['raid_id']);
		
		$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "signups WHERE raid_id=%s AND queue='0' AND cancel='0'",quote_smart($raid_id));
		$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
		while($data = $db_raid->sql_fetchrow($result, true))
		{
			$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "chars WHERE char_id=%s",quote_smart($data['char_id']));
			$result2 = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
			$data2 = $db_raid->sql_fetchrow($result2, true);
			$data2['name'] = ucfirst(strtolower($data2['name']));
			$text .= "/i {$data2['name']}\n";
		}
		
		$text .= '</textarea></td>';
		$text .= '<td width="50%"><textarea rows="10" cols="60" style="width: 100%">';
		
		$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "signups WHERE raid_id=%s AND queue='1' AND cancel='0'",quote_smart($raid_id));
		$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
		while($data = $db_raid->sql_fetchrow($result, true))
		{
			$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "chars WHERE char_id='" . $data['char_id'] . "'";
			$result2 = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
			$data2 = $db_raid->sql_fetchrow($result2, true);
			$data2['name'] = ucfirst(strtolower($data2['name']));
			$text .= "/i {$data2['name']}\n";
		}
		$text .= '</textarea></td></tr></table>';
		$text .= "<b><br>Macro output listing complete.<br>";
		$text .= "Copy and paste the above to a macro and run in-game</b>";
	}
	
	function Output_Lua()
	{
		global $db_raid, $text, $phpraid_config;
		$format=$phpraid_config['lua_output_format'];
		$raid_id=scrub_input($_GET['raid_id']);
		
		$lua_version = "31";
		
		if ($format == "1")
		{
			//Obtain Current Date/Time Stamp.  This is the GM Date/Time stamp.  Nothing fancy has to be done
			//  to this because it's being used as only a sequential numeric stamp, not an actual date.
			$file_date_stamp=gmdate("YmdHis");
		}
		
		$text .= "<b>Beginning LUA output</b><br>";
		
		// open/create file
		$file = fopen('./raid_lua/phpRaid_Data.lua','w');
		if ($file == FALSE)
			$failed_to_open=TRUE;
		
		// sql query
		$sql_where = 'old=0';
		
		if (isset($raid_id) && is_numeric($raid_id))
		{
			$text .= "<a href=\"lua_output.php\">Output all open raids</a><br><br>";
			$sql_where = "raid_id=".quote_smart($raid_id);
		}
		$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "raids WHERE ".$sql_where." ORDER BY invite_time ASC";
		$raids_result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
		
		// base output
		$lua_output  = "phpRaid_Data = {\n";
		$lua_output .= "\t[\"lua_version\"] = \"{$lua_version}\",\n";
		if ($format == "1")
		{
			$lua_output .= "\t[\"file_stamp\"] = \"{$file_date_stamp}\",\n";
			$lua_output .= "\t[\"guild\"] = \"{$phpraid_config['guild_name']}\",\n";
			$lua_output .= "\t[\"server\"] = \"{$phpraid_config['guild_server']}\",\n";			
		}
		$lua_output .= "\t[\"raid_count\"] = \"".$db_raid->sql_numrows($raids_result)."\",\n";
		$lua_output .= "\t[\"raids\"] = {\n";
		
		// parse result
		$count = 0;
		while($raid_data = $db_raid->sql_fetchrow($raids_result, true))
		{
			$location_data=addslashes($raid_data['location']);
			$description_data=linebreak_to_bslash_n(addslashes($raid_data['description']));
			$lua_output .= "\t\t[{$count}] = {\n";
			$lua_output .= "\t\t\t[\"location\"] = \"$location_data\",\n";
			$lua_output .= "\t\t\t[\"date\"] = \"" . new_date($phpraid_config['date_format'],$raid_data['invite_time'],$phpraid_config['timezone'] + $phpraid_config['dst']) . "\",\n";
			$lua_output .= "\t\t\t[\"invite_time\"] = \"" . new_date("Hi",$raid_data['invite_time'],$phpraid_config['timezone'] + $phpraid_config['dst']) . "\",\n";
			$lua_output .= "\t\t\t[\"start_time\"] = \"" . new_date("Hi",$raid_data['start_time'],$phpraid_config['timezone'] + $phpraid_config['dst']) . "\",\n";
			if ($format == "1")
			{
				$lua_output .= "\t\t\t[\"event_type\"] = \"" . $raid_data['event_type'] . "\",\n";
				$lua_output .= "\t\t\t[\"description\"] = \"$description_data\",\n";
			}
						
			// sql string for signups
			if ($format == "1")
			{
				$sql = "SELECT ".$phpraid_config['db_prefix']."signups.comments AS comment,
							   ".$phpraid_config['db_prefix']."signups.timestamp AS timestamp,
							   ".$phpraid_config['db_prefix']."signups.profile_id AS profile_id,
							   ".$phpraid_config['db_prefix']."chars.char_id AS ID,
							   ".$phpraid_config['db_prefix']."chars.name AS name,
							   ".$phpraid_config['db_prefix']."chars.lvl AS lvl,
							   ".$phpraid_config['db_prefix']."chars.race AS race,
							   ".$phpraid_config['db_prefix']."chars.class AS class
						FROM ".$phpraid_config['db_prefix']."signups
						LEFT JOIN ".$phpraid_config['db_prefix']."chars ON
							".$phpraid_config['db_prefix']."chars.char_id = ".$phpraid_config['db_prefix']."signups.char_id
						WHERE ".$phpraid_config['db_prefix']."signups.raid_id = ".$raid_data['raid_id']."
							AND ".$phpraid_config['db_prefix']."signups.cancel = 0
							AND ".$phpraid_config['db_prefix']."signups.queue = ";
			}
			else
			{
				$sql = "SELECT ".$phpraid_config['db_prefix']."signups.comments AS comment,
							   ".$phpraid_config['db_prefix']."signups.timestamp AS timestamp,
							   ".$phpraid_config['db_prefix']."chars.name AS name,
							   ".$phpraid_config['db_prefix']."chars.lvl AS lvl,
							   ".$phpraid_config['db_prefix']."chars.race AS race,
							   ".$phpraid_config['db_prefix']."chars.class AS class
						FROM ".$phpraid_config['db_prefix']."signups
						LEFT JOIN ".$phpraid_config['db_prefix']."chars ON
							".$phpraid_config['db_prefix']."chars.char_id = ".$phpraid_config['db_prefix']."signups.char_id
						WHERE ".$phpraid_config['db_prefix']."signups.raid_id = ".$raid_data['raid_id']."
							AND ".$phpraid_config['db_prefix']."signups.cancel = 0
							AND ".$phpraid_config['db_prefix']."signups.queue = ";				
			}
			// get data signed up
			$order_by = '';
			$signups = array();
			if ($phpraid_config['lua_output_sort_signups'] == 1)
				$order_by = 'ORDER BY '.$phpraid_config['db_prefix'].'chars.name ASC';
			elseif ($phpraid_config['lua_output_sort_signups'] == 2)
				$order_by = 'ORDER BY '.$phpraid_config['db_prefix'].'signups.timestamp ASC';
			$sql1 = $sql."0 ".$order_by.";";
			$signup_result = $db_raid->sql_query($sql1) or print_error($sql1, mysql_error(), 1);
			while($signup = $db_raid->sql_fetchrow($signup_result, true))
			{
				if ($format=="1")
				{
					$sql2 = "SELECT team_name " .
							"FROM ".$phpraid_config['db_prefix']."teams " .
							"WHERE raid_id=".$raid_data['raid_id']." and char_id=".$signup['ID'];
					$team_result = $db_raid->sql_query($sql2) or print_error($sql2, mysql_error(), 1);
					$team = $db_raid->sql_fetchrow($team_result, true);

					// Determine access_type for each character for each raid.
					$profile_id = $signup['profile_id'];
					$raid_officer = $raid_data['officer'];
					
					$sql3 = "SELECT profile_id " .
							"FROM ".$phpraid_config['db_prefix']."profile " .
							"WHERE username='".$raid_officer."'";
					$officer_profile = $db_raid->sql_query($sql3) or print_error($sql3, mysql_error(), 1);
					$raid_officer_profile_id = $db_raid->sql_fetchrow($officer_profile, true);
					
					// Check for Admin Privs for Signup Profile
					$raids_perm = check_permission("raids", $profile_id);
					
					// Set Access Type Priv
					if ($raids_perm)
						$access_type = "Admin";
					elseif ($profile_id == $raid_officer_profile_id['profile_id'])
						$access_type = "Moderator";
					else
						$access_type = "User";
						
					array_push($signups, array(
						'name'		 => ucfirst(strtolower($signup['name'])),
						'level'		 => $signup['lvl'],
						'race'		 => $signup['race'],
						'class'		 => $signup['class'],
						'team_name'  => $team['team_name'],
						'access_type'=> $access_type,
						'comment'	 => linebreak_to_bslash_n(addslashes($signup['comment'])),
						'timestamp'	 => new_date($phpraid_config['date_format'],$signup['timestamp'],$phpraid_config['timezone'] + $phpraid_config['dst']) . ' - ' . new_date($phpraid_config['time_format'],$signup['timestamp'],$phpraid_config['timezone'] + $phpraid_config['dst']),
					));
				}
				else
				{				
					array_push($signups, array(
						'name'		=> ucfirst(strtolower($signup['name'])),
						'level'		=> $signup['lvl'],
						'race'		=> $signup['race'],
						'class'		=> $signup['class'],
						'comment'	=> strip_linebreaks(addslashes($signup['comment'])),
						'timestamp'	=> new_date($phpraid_config['date_format'],$signup['timestamp'],$phpraid_config['timezone'] + $phpraid_config['dst']) . ' - ' . new_date($phpraid_config['time_format'],$signup['timestamp'],$phpraid_config['timezone'] + $phpraid_config['dst']),
					));
				}
			}
			
			// get data queue
			$order_by = '';
			$queue = array();
			if ($phpraid_config['lua_output_sort_queue'] == 1)
				$order_by = 'ORDER BY '.$phpraid_config['db_prefix'].'chars.name ASC';
			elseif ($phpraid_config['lua_output_sort_queue'] == 2)
				$order_by = 'ORDER BY '.$phpraid_config['db_prefix'].'signups.timestamp ASC';
			elseif ($phpraid_config['lua_output_sort_queue'] == 3)
				$order_by = 'ORDER BY '.$phpraid_config['db_prefix'].'chars.class ASC';
			$sql1 = $sql."1 ".$order_by.";";
			$signup_result = $db_raid->sql_query($sql1) or print_error($sql1, mysql_error(), 1);
			while($signup = $db_raid->sql_fetchrow($signup_result, true))
			{
				if ($format=="1")
				{
					$sql2 = "SELECT team_name " .
							"FROM ".$phpraid_config['db_prefix']."teams " .
							"WHERE raid_id=".$raid_data['raid_id']." and char_id=".$signup['ID'];
					$team_result = $db_raid->sql_query($sql2) or print_error($sql2, mysql_error(), 1);
					$team = $db_raid->sql_fetchrow($team_result, true);

					// Determine access_type for each character for each raid.
					$profile_id = $signup['profile_id'];
					$raid_officer = $raid_data['officer'];
					
					$sql3 = "SELECT profile_id " .
							"FROM ".$phpraid_config['db_prefix']."profile " .
							"WHERE username='".$raid_officer."'";
					$officer_profile = $db_raid->sql_query($sql3) or print_error($sql3, mysql_error(), 1);
					$raid_officer_profile_id = $db_raid->sql_fetchrow($officer_profile, true);

					// Check for Admin Privs for Signup Profile
					$raids_perm = check_permission("raids", $profile_id);
					
					// Set Access Type Priv
					if ($raids_perm)
						$access_type = "Admin";
					elseif ($profile_id == $raid_officer_profile_id['profile_id'])
						$access_type = "Moderator";
					else
						$access_type = "User";
					
					array_push($queue, array(
						'name'		 => ucfirst(strtolower($signup['name'])),
						'level'		 => $signup['lvl'],
						'race'		 => $signup['race'],
						'class'		 => $signup['class'],
						'access_type'=> $access_type,
						'team_name'  => $team['team_name'],
						'comment'	 => linebreak_to_bslash_n(addslashes($signup['comment'])),
						'timestamp'	 => new_date($phpraid_config['date_format'],$signup['timestamp'],$phpraid_config['timezone'] + $phpraid_config['dst']) . ' - ' . new_date($phpraid_config['time_format'],$signup['timestamp'],$phpraid_config['timezone'] + $phpraid_config['dst']),
					));
				}
				else
				{
					array_push($queue, array(
						'name'		=> ucfirst(strtolower($signup['name'])),
						'level'		=> $signup['lvl'],
						'race'		=> $signup['race'],
						'class'		=> $signup['class'],
						'comment'	=> strip_linebreaks(addslashes($signup['comment'])),
						'timestamp'	=> new_date($phpraid_config['date_format'],$signup['timestamp'],$phpraid_config['timezone'] + $phpraid_config['dst']) . ' - ' . new_date($phpraid_config['time_format'],$signup['timestamp'],$phpraid_config['timezone'] + $phpraid_config['dst']),
					));					
				}
			}
			
			// begin - add data to lua output
			for($i=0; $i<11; $i++)
				$lua_signups[$i] = "\t\t\t[\"".$this->GetClassNameByClassId($i)."\"] = {\n";
				
			// init counter vars
			$cnt[0] = 0;
			$cnt[1] = 0;
			$cnt[2] = 0;
			$cnt[3] = 0;
			$cnt[4] = 0;
			$cnt[5] = 0;
			$cnt[6] = 0;
			$cnt[7] = 0;
			$cnt[8] = 0;
			$cnt[9] = 0;
			
			foreach($queue as $char)
			{
				$lua_signups[0] .= "\t\t\t\t[{$cnt[0]}] = {\n";
				$lua_signups[0] .= "\t\t\t\t\t[\"name\"] = \"{$char['name']}\",\n";
				$lua_signups[0] .= "\t\t\t\t\t[\"level\"] = \"{$char['level']}\",\n";
				$lua_signups[0] .= "\t\t\t\t\t[\"class\"] = \"".$char['class']."\",\n";
				$lua_signups[0] .= "\t\t\t\t\t[\"race\"] = \"{$char['race']}\",\n";
				if ($format == "1")
				{
					$lua_signups[0] .= "\t\t\t\t\t[\"team_name\"] = \"{$char['team_name']}\",\n";
					$lua_signups[0] .= "\t\t\t\t\t[\"access_type\"] = \"{$char['access_type']}\",\n";
				}
				$lua_signups[0] .= "\t\t\t\t\t[\"comment\"] = \"{$char['comment']}\",\n";
				$lua_signups[0] .= "\t\t\t\t\t[\"timestamp\"] = \"{$char['timestamp']}\",\n";
				$lua_signups[0] .= "\t\t\t\t},\n";
				$cnt[0]++;
			}
			
			foreach($signups as $char)
			{
				$class_id = $this->GetClassIdByClassName($char['class']);
				$lua_signups[$class_id] .= "\t\t\t\t[{$cnt[$class_id]}] = {\n";
				$lua_signups[$class_id] .= "\t\t\t\t\t[\"name\"] = \"{$char['name']}\",\n";
				$lua_signups[$class_id] .= "\t\t\t\t\t[\"level\"] = \"{$char['level']}\",\n";
				$lua_signups[$class_id] .= "\t\t\t\t\t[\"class\"] = \"".$char['class']."\",\n";
				$lua_signups[$class_id] .= "\t\t\t\t\t[\"race\"] = \"{$char['race']}\",\n";
				if ($format == "1")
				{
					$lua_signups[$class_id] .= "\t\t\t\t\t[\"team_name\"] = \"{$char['team_name']}\",\n";
					$lua_signups[$class_id] .= "\t\t\t\t\t[\"access_type\"] = \"{$char['access_type']}\",\n";
				}
				$lua_signups[$class_id] .= "\t\t\t\t\t[\"comment\"] = \"{$char['comment']}\",\n";
				$lua_signups[$class_id] .= "\t\t\t\t\t[\"timestamp\"] = \"{$char['timestamp']}\",\n";
				$lua_signups[$class_id] .= "\t\t\t\t},\n";
				$cnt[$class_id]++;
			}
			
			// add class counts
			$lua_output .= "\t\t\t[\"queue_count\"] = \"".$cnt[0]."\",\n";
			$lua_output .= "\t\t\t[\"druids_count\"] = \"".$cnt[1]."\",\n";
			$lua_output .= "\t\t\t[\"hunters_count\"] = \"".$cnt[2]."\",\n";
			$lua_output .= "\t\t\t[\"mages_count\"] = \"".$cnt[3]."\",\n";
			$lua_output .= "\t\t\t[\"paladins_count\"] = \"".$cnt[4]."\",\n";
			$lua_output .= "\t\t\t[\"priests_count\"] = \"".$cnt[5]."\",\n";
			$lua_output .= "\t\t\t[\"rogues_count\"] = \"".$cnt[6]."\",\n";
			$lua_output .= "\t\t\t[\"shaman_count\"] = \"".$cnt[7]."\",\n";
			$lua_output .= "\t\t\t[\"warlocks_count\"] = \"".$cnt[8]."\",\n";
			$lua_output .= "\t\t\t[\"warriors_count\"] = \"".$cnt[9]."\",\n";
			
			for($i=0; $i<11; $i++)
				$lua_output .= $lua_signups[$i] . "\t\t\t},\n";
			$lua_output .= "\t\t},\n";
			
			$count++;
		}
		$lua_output .= "\t}\n}";
		// end - add data to lua output
		
		// write to file
		$output = "\xEF\xBB\xBF" . $lua_output;
		//fwrite($file,utf8_encode($lua_output));
		fwrite($file, $output);
		
		// output to textarea
		if ( $failed_to_open == TRUE)
		{
			$text .= 'LUA file could not be created due to failure to write.</b></br>';
			$text .= 'Please set logging level to display warnings (E_WARNING or better)</br>';
			$text .= 'To see the issue.';
			$text .= '<br>';
			$text .= 'Use this for copy+paste:<br>';
			$text .= '<textarea rows="10" cols="60" style="width: 100%">';
			$text .= $lua_output;
			$text .= '</textarea><br><br><br>';
			//$output = str_replace("\n","<br>",$output);
			//echo '<br><br>' . $output;
		}
		else
		{
			$text .= '<b>LUA file created.</b><br>';
			$text .= 'Download <a href="./raid_lua/phpRaid_Data.lua">phpRaid_Data.lua</a> and save it to [wow-dir]\interface\addons\phpraidviewer\<br>';
			$text .= 'or use this for copy+paste:<br>';
			$text .= '<textarea rows="10" cols="60" style="width: 100%">';
			$text .= $lua_output;
			$text .= '</textarea><br><br><br>';
			//$output = str_replace("\n","<br>",$output);
			//echo '<br><br>' . $output;
		}
	}
}

global $text;
$text = '';

$Output_Data = new Output_Data;
if (array_key_exists('config', $_POST))
	$Output_Data->UpdateOptions();
$Output_Data->GetOptions();
$Output_Data->ShowOptions();
$Output_Data->Output_Lua();
$raid_id=scrub_input($_GET['raid_id']);
if (isset($raid_id) && is_numeric($raid_id))
	$Output_Data->Output_Macro();
?>