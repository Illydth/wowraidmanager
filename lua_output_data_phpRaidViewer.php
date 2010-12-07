<?php
/***************************************************************************
 *                            lua_output_data.php
 *                            -------------------
 *   begin                : Saturday, Jan 16, 2005
 *   copyright            : (C) 2007-2010 Douglas Wagner
 *   email                : douglasw@wagnerweb.org
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
function GetClassIdByClassName($class)
{
	global $phprlang, $db_raid, $phpraid_config, $wrm_global_classes;
	
	foreach ($wrm_global_classes as $global_class)
	{
		if ($class == $global_class['class_id'])
		{
			return $global_class['class_index'];
		}				
	}
}

function GetClassNameByClassId($id)
{
	global $phprlang, $db_raid, $phpraid_config, $wrm_global_classes;
	
	if ($id == 0)
		return "queue";
	if ($id == 10)
		return "skip";

	foreach ($wrm_global_classes as $global_class)
	{
		if ($id == $global_class['class_index'])
		{
			$class = $global_class['lang_index'] . "s";
			return $class;
		}				
	}
}

function output_macro_drafted($raid_id)
{
	global $db_raid, $text, $phpraid_config;
	
	$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "signups WHERE raid_id=%s AND queue='0' AND cancel='0'",quote_smart($raid_id));
	$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	while($data = $db_raid->sql_fetchrow($result, true))
	{
		$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "chars WHERE char_id=%s",quote_smart($data['char_id']));
		$result2 = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
		$data2 = $db_raid->sql_fetchrow($result2, true);
		$data2['name'] = ucfirst(strtolower_wrap($data2['name'], "UTF-8"));
		$drafted_text .= "/i {$data2['name']}\n";
	}
	
	return $drafted_text;
}

function output_macro_queued($raid_id)
{
	global $db_raid, $text, $phpraid_config;
	
	$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "signups WHERE raid_id=%s AND queue='1' AND cancel='0'",quote_smart($raid_id));
	$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	while($data = $db_raid->sql_fetchrow($result, true))
	{
		$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "chars WHERE char_id='" . $data['char_id'] . "'";
		$result2 = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
		$data2 = $db_raid->sql_fetchrow($result2, true);
		$data2['name'] = ucfirst(strtolower_wrap($data2['name'], "UTF-8"));
		$queued_text .= "/i {$data2['name']}\n";
	}
	
	return $queued_text;
}


//Modified by Flintman of Hellscream
function output_lua_rim()
{
	global $db_raid, $text, $phpraid_config, $wrm_global_classes, $raid_sql_where;
	$raid_id=scrub_input($_GET['raid_id']);
	$raid_lua_info = array();
	$raid_count=0;
	
	/************************
	 * Get/Set Various non-database bits of Information for Output.
	 ************************/
	// Set Version of LUA, this can now be Reved since RIM and PHP Raid Viewer are being separated.
	$lua_version = "31";
	//Obtain Current Date/Time Stamp.  This is the GM Date/Time stamp.  Nothing fancy has to be done
	//  to this because it's being used as only a sequential numeric stamp, not an actual date.
	$file_date_stamp=gmdate("YmdHis");
	// Obtain the total raid count for the raid_count output.
	$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "raids WHERE ".$raid_sql_where." ORDER BY invite_time ASC";
	$raids_result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	$total_raid_num = $db_raid->sql_numrows($raids_result);
	// Get the total number of classes, this is max class_index from the classes table.
	//  This will come in handy later when we're creating the LUA output.
	$sql = "SELECT max(class_index) as max_class_index " .
			"FROM ".$phpraid_config['db_prefix']."classes";
	$max_class_query = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	$max_class_records = $db_raid->sql_fetchrow($max_class_query, true);
	$max_class_index = $max_class_records['max_class_index'];

	/******************************	
	 * Start the LUA Text Output
	 ******************************/
	$lua_output  = "phpRaid_Data = {\n";  //Output
	$lua_output .= "\t[\"lua_version\"] = \"{$lua_version}\",\n";  //Output
	$lua_output .= "\t[\"file_stamp\"] = \"{$file_date_stamp}\",\n";  //Output
	$lua_output .= "\t[\"raid_count\"] = \"".$total_raid_num."\",\n";  //Output
	
	/**********
	 * Start Processing Raids.  If the Raid ID is not passed, get all the raids and into format.
	 * If the raid ID is passed in, get only the information for that raid.
	 **********/
	if (!isset($raid_id)||!is_numeric($raid_id))
	{
		/* Get Guild/Server/Raid Force */
		// Select Distinct guild_server from wrm_guilds
		$sql = "SELECT DISTINCT guild_server as guild_server " .
				"FROM ".$phpraid_config['db_prefix']."guilds";
		$guild_server_result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
		while($guild_server_data = $db_raid->sql_fetchrow($guild_server_result, true))
		{
			$server = $guild_server_data['guild_server'];
			$lua_output .= "\t[\"". $server . "\"] = {\n";  //Output
			
			// Get the Raid Forces associated with that server. 
			// Raids with RF Name of None are not processed...they have no server and thus RIM has no use for them.
			$sql = "SELECT DISTINCT b.raid_force_name as raid_force_name " . 
					"FROM ".$phpraid_config['db_prefix']."guilds a, ".$phpraid_config['db_prefix']."raid_force b " .
					"WHERE a.guild_id = b.guild_id " .
					"AND a.guild_server = '" . $server . "' " .
					"ORDER BY b.raid_force_name";
			$rf_list_query = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
			while($rf_list_records = $db_raid->sql_fetchrow($rf_list_query, true))
			{
				$lua_output .= "\t\t[\"". $rf_list_records['raid_force_name'] . "\"] = {\n";  //Output
				$lua_output .= "\t\t\t[\"raids\"] = {\n";  //Output
				
				// Get Raids for Each Raid Force and Process Them.
				$count = 0;
				$sql = "SELECT * FROM ".$phpraid_config['db_prefix']."raids 
						WHERE raid_force_name = '" . $rf_list_records['raid_force_name'] . "' 
						AND " . $raid_sql_where . " ORDER BY invite_time ASC"; // raid_sql_where from lua_output.php
				$raids_list_query = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
				while($raid_data = $db_raid->sql_fetchrow($raids_list_query, true))
				{
					$location_data=addslashes($raid_data['location']);
					$description_data=linebreak_to_bslash_n(addslashes($raid_data['description']));
					$lua_output .= "\t\t\t\t[{$count}] = {\n";
					$lua_output .= "\t\t\t\t\t[\"location\"] = \"$location_data\",\n";
					$lua_output .= "\t\t\t\t\t[\"date\"] = \"" . new_date($phpraid_config['date_format'],$raid_data['invite_time'],$phpraid_config['timezone'] + $phpraid_config['dst']) . "\",\n";
					$lua_output .= "\t\t\t\t\t[\"invite_time\"] = \"" . new_date("Hi",$raid_data['invite_time'],$phpraid_config['timezone'] + $phpraid_config['dst']) . "\",\n";
					$lua_output .= "\t\t\t\t\t[\"start_time\"] = \"" . new_date("Hi",$raid_data['start_time'],$phpraid_config['timezone'] + $phpraid_config['dst']) . "\",\n";
					$lua_output .= "\t\t\t\t\t[\"event_type\"] = \"" . $raid_data['event_type'] . "\",\n";
					$lua_output .= "\t\t\t\t\t[\"description\"] = \"$description_data\",\n";
								
					// sql string for signups
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

					// get data signed up
					$order_by = '';
					$signups = array();
					if ($phpraid_config['lua_output_sort_signups'] == 1)
						$order_by = 'ORDER BY '.$phpraid_config['db_prefix'].'chars.name ASC';
					elseif ($phpraid_config['lua_output_sort_signups'] == 2)
						$order_by = 'ORDER BY '.$phpraid_config['db_prefix'].'signups.timestamp ASC';
					$sql1 = $sql."0 ".$order_by.";";
					$signup_result = $db_raid->sql_query($sql1) or print_error($sql1, $db_raid->sql_error(), 1);
					while($signup = $db_raid->sql_fetchrow($signup_result, true))
					{
						$sql2 = "SELECT team_name " .
								"FROM ".$phpraid_config['db_prefix']."teams " .
								"WHERE raid_id=".$raid_data['raid_id']." and char_id=".$signup['ID'];
						$team_result = $db_raid->sql_query($sql2) or print_error($sql2, $db_raid->sql_error(), 1);
						$team = $db_raid->sql_fetchrow($team_result, true);
			
						// Determine access_type for each character for each raid.
						$profile_id = $signup['profile_id'];
						$raid_officer = $raid_data['officer'];
							
						$sql3 = "SELECT profile_id " .
								"FROM ".$phpraid_config['db_prefix']."profile " .
								"WHERE username='".$raid_officer."'";
						$officer_profile = $db_raid->sql_query($sql3) or print_error($sql3, $db_raid->sql_error(), 1);
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
							'name'		 => ucfirst(strtolower_wrap($signup['name'], "UTF-8")),
							'level'		 => $signup['lvl'],
							'race'		 => $signup['race'],
							'class'		 => $signup['class'],
							'team_name'  => $team['team_name'],
							'access_type'=> $access_type,
							'comment'	 => linebreak_to_bslash_n(addslashes($signup['comment'])),
							'timestamp'	 => new_date($phpraid_config['date_format'],$signup['timestamp'],$phpraid_config['timezone'] + $phpraid_config['dst']) . ' - ' . new_date($phpraid_config['time_format'],$signup['timestamp'],$phpraid_config['timezone'] + $phpraid_config['dst']),
						));
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
					$signup_result = $db_raid->sql_query($sql1) or print_error($sql1, $db_raid->sql_error(), 1);
					while($signup = $db_raid->sql_fetchrow($signup_result, true))
					{
						$sql2 = "SELECT team_name " .
								"FROM ".$phpraid_config['db_prefix']."teams " .
								"WHERE raid_id=".$raid_data['raid_id']." and char_id=".$signup['ID'];
						$team_result = $db_raid->sql_query($sql2) or print_error($sql2, $db_raid->sql_error(), 1);
						$team = $db_raid->sql_fetchrow($team_result, true);
			
						// Determine access_type for each character for each raid.
						$profile_id = $signup['profile_id'];
						$raid_officer = $raid_data['officer'];
						
						$sql3 = "SELECT profile_id " .
								"FROM ".$phpraid_config['db_prefix']."profile " .
								"WHERE username='".$raid_officer."'";
						$officer_profile = $db_raid->sql_query($sql3) or print_error($sql3, $db_raid->sql_error(), 1);
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
							'name'		 => ucfirst(strtolower_wrap($signup['name'], "UTF-8")),
							'level'		 => $signup['lvl'],
							'race'		 => $signup['race'],
							'class'		 => $signup['class'],
							'access_type'=> $access_type,
							'team_name'  => $team['team_name'],
							'comment'	 => linebreak_to_bslash_n(addslashes($signup['comment'])),
							'timestamp'	 => new_date($phpraid_config['date_format'],$signup['timestamp'],$phpraid_config['timezone'] + $phpraid_config['dst']) . ' - ' . new_date($phpraid_config['time_format'],$signup['timestamp'],$phpraid_config['timezone'] + $phpraid_config['dst']),
						));
					}
								
					// begin - add data to lua output
					for($i=0; $i<=$max_class_index; $i++)
					{
						$class = GetClassNameByClassId($i);
						if ($class != "skip")
							$lua_signups[$i] = "\t\t\t\t\t[\"".$class."\"] = {\n";
					}
					// init counter vars
					$cnt[0] = 0;
					foreach ($wrm_global_classes as $global_class)
						$cnt[$global_class['class_index']] = 0;
					
					foreach($queue as $char)
					{
						$lua_signups[0] .= "\t\t\t\t\t\t[{$cnt[0]}] = {\n";
						$lua_signups[0] .= "\t\t\t\t\t\t\t[\"name\"] = \"{$char['name']}\",\n";
						$lua_signups[0] .= "\t\t\t\t\t\t\t[\"level\"] = \"{$char['level']}\",\n";
						$lua_signups[0] .= "\t\t\t\t\t\t\t[\"class\"] = \"".$char['class']."\",\n";
						$lua_signups[0] .= "\t\t\t\t\t\t\t[\"race\"] = \"{$char['race']}\",\n";
						$lua_signups[0] .= "\t\t\t\t\t\t\t[\"team_name\"] = \"{$char['team_name']}\",\n";
						$lua_signups[0] .= "\t\t\t\t\t\t\t[\"access_type\"] = \"{$char['access_type']}\",\n";
						$lua_signups[0] .= "\t\t\t\t\t\t\t[\"comment\"] = \"{$char['comment']}\",\n";
						$lua_signups[0] .= "\t\t\t\t\t\t\t[\"timestamp\"] = \"{$char['timestamp']}\",\n";
						$lua_signups[0] .= "\t\t\t\t\t\t},\n";
						$cnt[0]++;
					}
					
					foreach($signups as $char)
					{
						$class_id = GetClassIdByClassName($char['class']);
						$lua_signups[$class_id] .= "\t\t\t\t\t\t[{$cnt[$class_id]}] = {\n";
						$lua_signups[$class_id] .= "\t\t\t\t\t\t\t[\"name\"] = \"{$char['name']}\",\n";
						$lua_signups[$class_id] .= "\t\t\t\t\t\t\t[\"level\"] = \"{$char['level']}\",\n";
						$lua_signups[$class_id] .= "\t\t\t\t\t\t\t[\"class\"] = \"".$char['class']."\",\n";
						$lua_signups[$class_id] .= "\t\t\t\t\t\t\t[\"race\"] = \"{$char['race']}\",\n";
						$lua_signups[$class_id] .= "\t\t\t\t\t\t\t[\"team_name\"] = \"{$char['team_name']}\",\n";
						$lua_signups[$class_id] .= "\t\t\t\t\t\t\t[\"access_type\"] = \"{$char['access_type']}\",\n";
						$lua_signups[$class_id] .= "\t\t\t\t\t\t\t[\"comment\"] = \"{$char['comment']}\",\n";
						$lua_signups[$class_id] .= "\t\t\t\t\t\t\t[\"timestamp\"] = \"{$char['timestamp']}\",\n";
						$lua_signups[$class_id] .= "\t\t\t\t\t\t},\n";
						$cnt[$class_id]++;
					}
					
					// add class counts
					$lua_output .= "\t\t\t\t\t[\"queue_count\"] = \"".$cnt[0]."\",\n";
					foreach ($wrm_global_classes as $global_class)
						$lua_output .= "\t\t\t\t\t[\"".$global_class['lang_index']."s_count\"] = \"".$cnt[$global_class['class_index']]."\",\n";
					
					for($i=0; $i<=$max_class_index; $i++)
						if ($i != 10) // Class ID Number 10 does not exist at this point.
							$lua_output .= $lua_signups[$i] . "\t\t\t\t\t},\n";
					$lua_output .= "\t\t\t\t},\n"; // Output - Close [X] Raid Loop.
					
					$count++;
				}
				$lua_output .= "\t\t\t},\n"; // Output - Close Raids Loop
			}
			$lua_output .= "\t\t},\n"; // Output - Close Raid Force Loop
		}
	}
	else // raid_id is set
	{
		// Get Raids for Raid ID and Process It.
		$sql = "SELECT * FROM ".$phpraid_config['db_prefix']."raids 
				WHERE " . $raid_sql_where; // raid_sql_where from lua_output.php
		$raids_list_query = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
		$raid_data = $db_raid->sql_fetchrow($raids_list_query, true);
		
		// Take the Raid ID and get the Raid Force
		$sql = "SELECT * FROM ".$phpraid_config['db_prefix']."raid_force
				WHERE raid_force_name = '" . $raid_data['raid_force_name'] . "'";
		$raid_force_name_query = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
		$raid_force_name_data = $db_raid->sql_fetchrow($raid_force_name_query, true);
	
		// Take Raid Force Information and get Server.
		$sql = "SELECT * FROM ".$phpraid_config['db_prefix']."guilds
				WHERE guild_id = '" . $raid_force_name_data['guild_id'] . "'";
		$guild_id_query = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
		$guild_id_data = $db_raid->sql_fetchrow($guild_id_query, true);
		
		$lua_output .= "\t[\"". $guild_id_data['guild_server'] . "\"] = {\n";  //Output
		$lua_output .= "\t\t[\"". $raid_force_name_data['raid_force_name'] . "\"] = {\n";  //Output
		$lua_output .= "\t\t\t[\"raids\"] = {\n";  //Output
		$lua_output .= "\t\t\t\t[0] = {\n"; //Output
	
		// Ouptut Raid Data
		$location_data=addslashes($raid_data['location']);
		$description_data=linebreak_to_bslash_n(addslashes($raid_data['description']));
		$lua_output .= "\t\t\t\t\t[\"location\"] = \"$location_data\",\n";
		$lua_output .= "\t\t\t\t\t[\"date\"] = \"" . new_date($phpraid_config['date_format'],$raid_data['invite_time'],$phpraid_config['timezone'] + $phpraid_config['dst']) . "\",\n";
		$lua_output .= "\t\t\t\t\t[\"invite_time\"] = \"" . new_date("Hi",$raid_data['invite_time'],$phpraid_config['timezone'] + $phpraid_config['dst']) . "\",\n";
		$lua_output .= "\t\t\t\t\t[\"start_time\"] = \"" . new_date("Hi",$raid_data['start_time'],$phpraid_config['timezone'] + $phpraid_config['dst']) . "\",\n";
		$lua_output .= "\t\t\t\t\t[\"event_type\"] = \"" . $raid_data['event_type'] . "\",\n";
		$lua_output .= "\t\t\t\t\t[\"description\"] = \"$description_data\",\n";
					
		// sql string for signups
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
	
		// get data signed up
		$order_by = '';
		$signups = array();
		if ($phpraid_config['lua_output_sort_signups'] == 1)
			$order_by = 'ORDER BY '.$phpraid_config['db_prefix'].'chars.name ASC';
		elseif ($phpraid_config['lua_output_sort_signups'] == 2)
			$order_by = 'ORDER BY '.$phpraid_config['db_prefix'].'signups.timestamp ASC';
		$sql1 = $sql."0 ".$order_by.";";
		$signup_result = $db_raid->sql_query($sql1) or print_error($sql1, $db_raid->sql_error(), 1);
		while($signup = $db_raid->sql_fetchrow($signup_result, true))
		{
			$sql2 = "SELECT team_name " .
					"FROM ".$phpraid_config['db_prefix']."teams " .
					"WHERE raid_id=".$raid_data['raid_id']." and char_id=".$signup['ID'];
			$team_result = $db_raid->sql_query($sql2) or print_error($sql2, $db_raid->sql_error(), 1);
			$team = $db_raid->sql_fetchrow($team_result, true);
	
			// Determine access_type for each character for each raid.
			$profile_id = $signup['profile_id'];
			$raid_officer = $raid_data['officer'];
				
			$sql3 = "SELECT profile_id " .
					"FROM ".$phpraid_config['db_prefix']."profile " .
					"WHERE username='".$raid_officer."'";
			$officer_profile = $db_raid->sql_query($sql3) or print_error($sql3, $db_raid->sql_error(), 1);
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
				'name'		 => ucfirst(strtolower_wrap($signup['name'], "UTF-8")),
				'level'		 => $signup['lvl'],
				'race'		 => $signup['race'],
				'class'		 => $signup['class'],
				'team_name'  => $team['team_name'],
				'access_type'=> $access_type,
				'comment'	 => linebreak_to_bslash_n(addslashes($signup['comment'])),
				'timestamp'	 => new_date($phpraid_config['date_format'],$signup['timestamp'],$phpraid_config['timezone'] + $phpraid_config['dst']) . ' - ' . new_date($phpraid_config['time_format'],$signup['timestamp'],$phpraid_config['timezone'] + $phpraid_config['dst']),
			));
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
		$signup_result = $db_raid->sql_query($sql1) or print_error($sql1, $db_raid->sql_error(), 1);
		while($signup = $db_raid->sql_fetchrow($signup_result, true))
		{
			$sql2 = "SELECT team_name " .
					"FROM ".$phpraid_config['db_prefix']."teams " .
					"WHERE raid_id=".$raid_data['raid_id']." and char_id=".$signup['ID'];
			$team_result = $db_raid->sql_query($sql2) or print_error($sql2, $db_raid->sql_error(), 1);
			$team = $db_raid->sql_fetchrow($team_result, true);
	
			// Determine access_type for each character for each raid.
			$profile_id = $signup['profile_id'];
			$raid_officer = $raid_data['officer'];
			
			$sql3 = "SELECT profile_id " .
					"FROM ".$phpraid_config['db_prefix']."profile " .
					"WHERE username='".$raid_officer."'";
			$officer_profile = $db_raid->sql_query($sql3) or print_error($sql3, $db_raid->sql_error(), 1);
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
				'name'		 => ucfirst(strtolower_wrap($signup['name'], "UTF-8")),
				'level'		 => $signup['lvl'],
				'race'		 => $signup['race'],
				'class'		 => $signup['class'],
				'access_type'=> $access_type,
				'team_name'  => $team['team_name'],
				'comment'	 => linebreak_to_bslash_n(addslashes($signup['comment'])),
				'timestamp'	 => new_date($phpraid_config['date_format'],$signup['timestamp'],$phpraid_config['timezone'] + $phpraid_config['dst']) . ' - ' . new_date($phpraid_config['time_format'],$signup['timestamp'],$phpraid_config['timezone'] + $phpraid_config['dst']),
			));
		}
					
		// begin - add data to lua output
		for($i=0; $i<=$max_class_index; $i++)
		{
			$class = GetClassNameByClassId($i);
			if ($class != "skip")
				$lua_signups[$i] = "\t\t\t\t\t[\"".$class."\"] = {\n";
		}
		// init counter vars
		$cnt[0] = 0;
		foreach ($wrm_global_classes as $global_class)
			$cnt[$global_class['class_index']] = 0;
		
		foreach($queue as $char)
		{
			$lua_signups[0] .= "\t\t\t\t\t\t[{$cnt[0]}] = {\n";
			$lua_signups[0] .= "\t\t\t\t\t\t\t[\"name\"] = \"{$char['name']}\",\n";
			$lua_signups[0] .= "\t\t\t\t\t\t\t[\"level\"] = \"{$char['level']}\",\n";
			$lua_signups[0] .= "\t\t\t\t\t\t\t[\"class\"] = \"".$char['class']."\",\n";
			$lua_signups[0] .= "\t\t\t\t\t\t\t[\"race\"] = \"{$char['race']}\",\n";
			$lua_signups[0] .= "\t\t\t\t\t\t\t[\"team_name\"] = \"{$char['team_name']}\",\n";
			$lua_signups[0] .= "\t\t\t\t\t\t\t[\"access_type\"] = \"{$char['access_type']}\",\n";
			$lua_signups[0] .= "\t\t\t\t\t\t\t[\"comment\"] = \"{$char['comment']}\",\n";
			$lua_signups[0] .= "\t\t\t\t\t\t\t[\"timestamp\"] = \"{$char['timestamp']}\",\n";
			$lua_signups[0] .= "\t\t\t\t\t\t},\n";
			$cnt[0]++;
		}
		
		foreach($signups as $char)
		{
			$class_id = GetClassIdByClassName($char['class']);
			$lua_signups[$class_id] .= "\t\t\t\t\t\t[{$cnt[$class_id]}] = {\n";
			$lua_signups[$class_id] .= "\t\t\t\t\t\t\t[\"name\"] = \"{$char['name']}\",\n";
			$lua_signups[$class_id] .= "\t\t\t\t\t\t\t[\"level\"] = \"{$char['level']}\",\n";
			$lua_signups[$class_id] .= "\t\t\t\t\t\t\t[\"class\"] = \"".$char['class']."\",\n";
			$lua_signups[$class_id] .= "\t\t\t\t\t\t\t[\"race\"] = \"{$char['race']}\",\n";
			$lua_signups[$class_id] .= "\t\t\t\t\t\t\t[\"team_name\"] = \"{$char['team_name']}\",\n";
			$lua_signups[$class_id] .= "\t\t\t\t\t\t\t[\"access_type\"] = \"{$char['access_type']}\",\n";
			$lua_signups[$class_id] .= "\t\t\t\t\t\t\t[\"comment\"] = \"{$char['comment']}\",\n";
			$lua_signups[$class_id] .= "\t\t\t\t\t\t\t[\"timestamp\"] = \"{$char['timestamp']}\",\n";
			$lua_signups[$class_id] .= "\t\t\t\t\t\t},\n";
			$cnt[$class_id]++;
		}
		
		// add class counts
		$lua_output .= "\t\t\t\t\t[\"queue_count\"] = \"".$cnt[0]."\",\n";
		foreach ($wrm_global_classes as $global_class)
			$lua_output .= "\t\t\t\t\t[\"".$global_class['lang_index']."s_count\"] = \"".$cnt[$global_class['class_index']]."\",\n";
		
		for($i=0; $i<=$max_class_index; $i++)
			if ($i != 10) // Class ID Number 10 does not exist at this point.
				$lua_output .= $lua_signups[$i] . "\t\t\t\t\t},\n";
		
		$lua_output .= "\t\t\t\t},\n"; // Output - Close [X] Raid Loop.
		$lua_output .= "\t\t\t},\n"; // Output - Close Raids Loop
		$lua_output .= "\t\t},\n"; // Output - Close Raid Force Loop
	}	
	$lua_output .= "\t}\n}"; // Output - Closes the Server Loop and then the phpRaid_Data Loop.
	// end - add data to lua output		
	
	return ($lua_output);
}

function output_lua_prv()
{
	global $db_raid, $text, $phpraid_config, $wrm_global_classes;
	$format=$phpraid_config['lua_output_format'];
	$raid_id=scrub_input($_GET['raid_id']);
	
	$lua_version = "250";
	
	// Get the total number of classes, this is max class_index from the classes table.
	//  This will come in handy later when we're creating the LUA output.
	$sql = "SELECT max(class_index) as max_class_index " .
			"FROM ".$phpraid_config['db_prefix']."classes";
	$max_class_query = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	$max_class_records = $db_raid->sql_fetchrow($max_class_query, true);
	$max_class_index = $max_class_records['max_class_index'];
	
	
	$text .= "<b>Beginning LUA output</b><br>";
	
	// open/create file
	$file = fopen('cache/raid_lua/phpRaid_Data.lua','w');
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
	$raids_result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	
	// base output
	$lua_output  = "phpRaid_Data = {\n";
	$lua_output .= "\t[\"lua_version\"] = \"{$lua_version}\",\n";

	// Pulls roles from WRM
	$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "roles";
	$role_result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);

	while($role_data = $db_raid->sql_fetchrow($role_result, true))
		{
		  	$lua_output .= "\t[\"".$role_data['role_id']."\"] = \"{$role_data['role_name']}\",\n";
		}
	$lua_output .= "\t[\"role_count\"] = \"".$db_raid->sql_numrows($role_data)."\",\n";
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
		
			$sql = "SELECT ".$phpraid_config['db_prefix']."signups.comments AS comment,
						   ".$phpraid_config['db_prefix']."signups.selected_spec AS selected_spec,
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
		// get data signed up
		$order_by = '';
		$signups = array();
		if ($phpraid_config['lua_output_sort_signups'] == 1)
			$order_by = 'ORDER BY '.$phpraid_config['db_prefix'].'chars.name ASC';
		elseif ($phpraid_config['lua_output_sort_signups'] == 2)
			$order_by = 'ORDER BY '.$phpraid_config['db_prefix'].'signups.timestamp ASC';
		$sql1 = $sql."0 ".$order_by.";";
		$signup_result = $db_raid->sql_query($sql1) or print_error($sql1, $db_raid->sql_error(), 1);
		while($signup = $db_raid->sql_fetchrow($signup_result, true))
		{
			//Gets Role id
			$search = array("(", ")");
			$replace   = array("", "");
			$role_name = strstr($signup['selected_spec'], '(');
			$role_name = str_replace($search, $replace, $role_name);
			$sql4 = "SELECT * FROM " . $phpraid_config['db_prefix'] . "roles WHERE role_name='".$role_name."'";
			$role_result = $db_raid->sql_query($sql4) or print_error($sql4, mysql_error(), 1);
			$role_info = $db_raid->sql_fetchrow($role_result, true);
			$role_id = $role_info['role_id'][strlen($role_info['role_id'])-1];
			
			array_push($signups, array(
					'name'		=> ucfirst(strtolower_wrap($signup['name'], "UTF-8")),
					'level'		=> $signup['lvl'],
					'race'		=> $signup['race'],
					'class'		=> $signup['class'],
					'comment'	=> strip_linebreaks(addslashes($signup['comment'])),
         				'role'		=> $role_id,
					'timestamp'	=> new_date($phpraid_config['date_format'],$signup['timestamp'],$phpraid_config['timezone'] + $phpraid_config['dst']) . ' - ' . new_date($phpraid_config['time_format'],$signup['timestamp'],$phpraid_config['timezone'] + $phpraid_config['dst']),
				));
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
		$signup_result = $db_raid->sql_query($sql1) or print_error($sql1, $db_raid->sql_error(), 1);
		while($signup = $db_raid->sql_fetchrow($signup_result, true))
		{
			array_push($queue, array(
					'name'		=> ucfirst(strtolower_wrap($signup['name'], "UTF-8")),
					'level'		=> $signup['lvl'],
					'race'		=> $signup['race'],
					'class'		=> $signup['class'],
					'comment'	=> strip_linebreaks(addslashes($signup['comment'])),
					'role'		=> $role_id,
					'timestamp'	=> new_date($phpraid_config['date_format'],$signup['timestamp'],$phpraid_config['timezone'] + $phpraid_config['dst']) . ' - ' . new_date($phpraid_config['time_format'],$signup['timestamp'],$phpraid_config['timezone'] + $phpraid_config['dst']),
				));					
		}
					
		// begin - add data to lua output
		for($i=0; $i<=$max_class_index; $i++)
		{
			$class = GetClassNameByClassId($i);
			if ($class != "skip")
				$lua_signups[$i] = "\t\t\t[\"".$class."\"] = {\n";
		}
		// init counter vars
		$cnt[0] = 0;
		foreach ($wrm_global_classes as $global_class)
			$cnt[$global_class['class_index']] = 0;
		
		foreach($queue as $char)
		{
			$lua_signups[0] .= "\t\t\t\t[{$cnt[0]}] = {\n";
			$lua_signups[0] .= "\t\t\t\t\t[\"name\"] = \"{$char['name']}\",\n";
			$lua_signups[0] .= "\t\t\t\t\t[\"level\"] = \"{$char['level']}\",\n";
			$lua_signups[0] .= "\t\t\t\t\t[\"class\"] = \"".$char['class']."\",\n";
			$lua_signups[0] .= "\t\t\t\t\t[\"race\"] = \"{$char['race']}\",\n";
			$lua_signups[0] .= "\t\t\t\t\t[\"comment\"] = \"{$char['comment']}\",\n";
			$lua_signups[0] .= "\t\t\t\t\t[\"timestamp\"] = \"{$char['timestamp']}\",\n";
			$lua_signups[0] .= "\t\t\t\t\t[\"role_id\"] = \"{$char['role']}\",\n";
			$lua_signups[0] .= "\t\t\t\t},\n";
			$cnt[0]++;
		}
		
		foreach($signups as $char)
		{
			$class_id = GetClassIdByClassName($char['class']);
			$lua_signups[$class_id] .= "\t\t\t\t[{$cnt[$class_id]}] = {\n";
			$lua_signups[$class_id] .= "\t\t\t\t\t[\"name\"] = \"{$char['name']}\",\n";
			$lua_signups[$class_id] .= "\t\t\t\t\t[\"level\"] = \"{$char['level']}\",\n";
			$lua_signups[$class_id] .= "\t\t\t\t\t[\"class\"] = \"".$char['class']."\",\n";
			$lua_signups[$class_id] .= "\t\t\t\t\t[\"race\"] = \"{$char['race']}\",\n";
			$lua_signups[$class_id] .= "\t\t\t\t\t[\"comment\"] = \"{$char['comment']}\",\n";
			$lua_signups[$class_id] .= "\t\t\t\t\t[\"timestamp\"] = \"{$char['timestamp']}\",\n";
			$lua_signups[$class_id] .= "\t\t\t\t\t[\"role_id\"] = \"{$char['role']}\",\n";
			$lua_signups[$class_id] .= "\t\t\t\t},\n";
			$cnt[$class_id]++;
		}
		
		// add class counts
		$lua_output .= "\t\t\t[\"queue_count\"] = \"".$cnt[0]."\",\n";
		foreach ($wrm_global_classes as $global_class)
			$lua_output .= "\t\t\t[\"".$global_class['lang_index']."s_count\"] = \"".$cnt[$global_class['class_index']]."\",\n";
		
		for($i=0; $i<=$max_class_index; $i++)
			if ($i != 10) // Class ID Number 10 does not exist at this point.
				$lua_output .= $lua_signups[$i] . "\t\t\t},\n";
		$lua_output .= "\t\t},\n";
		
		$count++;
	}
	$lua_output .= "\t}\n}";
	// end - add data to lua output
	
	return ($lua_output);
}

?>
