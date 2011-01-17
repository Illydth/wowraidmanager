<?php
/***************************************************************************
 *                               scheduler.php
 *                            -------------------
 *   begin                : Friday, Sep. 18, 2009
 *   copyright            : (C) 2007-2010 Douglas Wagner
 *   email                : douglasw@wagnerweb.org
 *
 *
 ***************************************************************************/
/***************************************************************************
*
*    WoW Raid Manager - Raid Management Software for World of Warcraft
*    Copyright (C) 2007-2010 Douglas Wagner
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
/** GENERIC Function Comment Block
 * Description of Function Goes here.
 *
 * @param type $variable Description
 * @param boolean $deleteRootToo Delete specified top-level directory as well
 * @return type $variable Description
 * @return array $table_headers The array of data including column name, visibility, and image URL
 * @access public|private
 * @access public
 */

/**
 * Executes "time" based code upon page reload.  Used to automatically perform
 * actions within WRM.
 *
 * @param none
 * @return INT - 0: Successful Execution  
 * @access public
 */
function scheduler() {
	global $phpraid_config;

	$error_array = array();
	
	$error_array = process_recurring_raids(); 
	$error_array = automatic_raid_mark_old();
	
	return $error_array;
}

/** 
 * Process Recurring Raids:  Process the recurring raids from the raids table to ensure 
 * enough raids are scheduled.
 *
 * @param None
 * @return Array - Error Code
 * @access private
 */
function process_recurring_raids()
{
	global $phpraid_config, $db_raid, $phprlang;
	
	$error_array = array();
	$raid_id_array = array();
	
	// Get "Current" Date/Time for all our Calculations.
	$currTimeStamp = time();
	
	// Obtain the List of "Recurring" raids from the raids table.
	$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "raids WHERE recurrance = 1";
	$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);	
	while($data = $db_raid->sql_fetchrow($result, true)) {
		// For each raid, determine the interval and calculate the raids that SHOULD be scheduled
		//   for this recurring raid already.
		$num_recur = $data['num_recur'];
		// Calculate Start Time and Invite Time without the Date portion:
		$start_time_hour = date('H',$data['start_time']);
		$start_time_minute = date('i',$data['start_time']);
		$start_time = $data['start_time'];
		$invite_time = $data['invite_time'];
		
		for ($x=0; $x < $num_recur; $x++)
		{
			if ($currTimeStamp > $start_time)
			{
				$raid_check_time = get_next_time_stamp($start_time, $data['rec_interval'], $x+1); 
				$new_invite_time = get_next_time_stamp($invite_time, $data['rec_interval'], $x+1);
			}
			else
			{	
				$raid_check_time = get_next_time_stamp($start_time, $data['rec_interval'], $x); 
				$new_invite_time = get_next_time_stamp($invite_time, $data['rec_interval'], $x);
			}
			// Verify if Start_Time raid has been scheduled
			$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "raids 
					WHERE recurrance = 0
					AND start_time = " . $raid_check_time . "
					AND location = '" . $data['location'] ."'";
			$check_result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);	
			if (!$db_raid->sql_numrows($check_result) || $db_raid->sql_numrows($check_result) < 1)
				$errcode = schedule_raid($new_invite_time, $raid_check_time, $data['raid_id']);
			
			switch ($errcode)
			{
				case -1: //Raid ID Returned No Records
					clean_scheduled_raids($raid_id_array);
					$error_array['errval'] = 1;
					$error_array['errorMsg'] = $phprlang['scheduler_error_no_raid_found'];
					$error_array['errorDie'] = 1;
					$error_array['errorTitle'] = $phprlang['scheduler_error_schedule_raid'];
					return $error_array;
				break;
				case -2: //SQL Error
					clean_scheduled_raids($raid_id_array);
					$error_array['errval'] = 1;
					$error_array['errorMsg'] = $phprlang['scheduler_error_sql_error'];
					$error_array['errorDie'] = 1;
					$error_array['errorTitle'] = $phprlang['scheduler_error_schedule_raid'];
					return $error_array;
				break;
				case -3: //Class Limits Returned No Records
					clean_scheduled_raids($raid_id_array);
					$error_array['errval'] = 1;
					$error_array['errorMsg'] = $phprlang['scheduler_error_class_limits_missing'];
					$error_array['errorDie'] = 1;
					$error_array['errorTitle'] = $phprlang['scheduler_error_schedule_raid'];
					return $error_array;
				break;
				case -4: //Role Limits Returned No Records
					clean_scheduled_raids($raid_id_array);
					$error_array['errval'] = 1;
					$error_array['errorMsg'] = $phprlang['scheduler_error_role_limits_missing'];
					$error_array['errorDie'] = 1;
					$error_array['errorTitle'] = $phprlang['scheduler_error_schedule_raid'];
					return $error_array;
				break;
				default:
					// This catches the 0 case, all is well, reset error data.
					$raid_id_array[$x] = $errcode; // Raid ID of Scheduled Raid.
					$error_array['errval'] = 0;
					$error_array['errorMsg'] = '';
					$error_array['errorDie'] = 0;
					$error_array['errorTitle'] = '';
				break;
			}
		}
		// If Current Time > Start Time, add 1 interval to the raid.
		if ($currTimeStamp > $start_time)
		{
			$new_start_time = get_next_time_stamp($start_time, $data['rec_interval'], 1);
			$new_invite_time = get_next_time_stamp($invite_time, $data['rec_interval'], 1);

			$sql = sprintf("UPDATE " . $phpraid_config['db_prefix'] . "raids
							SET start_time=%s, invite_time=%s WHERE raid_id = %s"
							,quote_smart($new_start_time), quote_smart($new_invite_time), quote_smart($data['raid_id']));
			
			if (!$db_raid->sql_query($sql))
			{
				print_error($sql,$db_raid->sql_error(),0);
				clean_scheduled_raids($raid_id_array);
				$error_array['errval'] = 1;
				$error_array['errorMsg'] = $phprlang['scheduler_error_update_recurring'];
				$error_array['errorDie'] = 1;
				$error_array['errorTitle'] = $phprlang['scheduler_error_schedule_raid'];
				return $error_array;
			} 			
		}
	}
	return $error_array;
}

/** 
 * Schedule Raid:  Schedule a Raid to the Raid Table from the recurring raid data.
 *
 * @param TIME - Invite Time - The new invite time of the raid to schedule.
 * @param TIME - Start Time - The new start time of the raid to schedule.
 * @param INT - Raid ID - The Raid ID of the raid data to retrieve and schedule.
 * @return INT - $raid_id_data['raid_id'] - The Raid ID of the Raid Just Scheduled or a negative
 * 					integer to denote a failure.
 * @access private
 */
function schedule_raid($invite_time, $start_time, $raid_id)
{
	global $phpraid_config, $db_raid, $wrm_global_roles, $wrm_global_classes;
	
	$class = array();
	$role = array();
	
	// Pull the current record from the DB based upon Raid ID
	$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "raids WHERE raid_id = ". $raid_id;
	if (!$result = $db_raid->sql_query($sql))
	{
		print_error($sql, $db_raid->sql_error(), 0);
		return -2; // SQL Error
	}	
	$data = $db_raid->sql_fetchrow($result, true);
	if (!$db_raid->sql_numrows($result) || $db_raid->sql_numrows($result) < 1)
		return -1; // Raid ID not Found.
			
	// Create Scheduled Record based upon Pulled Record
	$sql = sprintf("INSERT INTO " . $phpraid_config['db_prefix'] . "raids (`description`,`freeze`,`invite_time`,
	`location`,`officer`,`old`,`start_time`,`min_lvl`,`max_lvl`,`max`,`event_type`,
	`event_id`,`raid_force_name`,`recurrance`)	
	VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)",
	quote_smart($data['description']),quote_smart($data['freeze']),quote_smart($invite_time),quote_smart($data['location']),
	quote_smart($data['officer']),quote_smart('0'),quote_smart($start_time),quote_smart($data['min_lvl']),
	quote_smart($data['max_lvl']),quote_smart($data['max']),quote_smart($data['tag']),quote_smart($data['event_id']),
	quote_smart($data['raid_force_name']),'0');
	
	if(!$db_raid->sql_query($sql))
	{
		print_error($sql, $db_raid->sql_error(), 0);
		return -2; // SQL Error
	}	
	
	// Get the Location ID of what was Just Entered to Apply to the Lookup Tables
	$sql = "SELECT raid_id FROM " . $phpraid_config['db_prefix'] . "raids ORDER BY raid_id DESC LIMIT 1";
	if (!$raid_id_result = $db_raid->sql_query($sql))
	{
		print_error($sql, $db_raid->sql_error(), 0);
		return -2; // SQL Error
	}	
	$raid_id_data = $db_raid->sql_fetchrow($raid_id_result, true);
	
	// Insert Class Data to loc_class_lmt
	// Get Class Limit Data
	$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "raid_class_lmt WHERE raid_id = ". $raid_id;
	if (!$class_result = $db_raid->sql_query($sql))
	{
		print_error($sql, $db_raid->sql_error(), 0);
		return -2; // SQL Error
	}	
	if (!$db_raid->sql_numrows($class_result) || $db_raid->sql_numrows($class_result) < 1)
		return -3; // Raid ID not Found.
	while ($class_data = $db_raid->sql_fetchrow($class_result, true))
	{
		$sql = sprintf("INSERT INTO " . $phpraid_config['db_prefix'] . "raid_class_lmt (`raid_id`, `class_id`, `lmt`)
		VALUES (%s,%s,%s)",quote_smart($raid_id_data['raid_id']), quote_smart($class_data['class_id']), quote_smart($class_data['lmt']));
		
		if (!$db_raid->sql_query($sql))
		{
			print_error($sql,$db_raid->sql_error(),0);
			return -2; //SQL Error
		} 
	}
	
	// Insert Role Data to loc_role_lmt
	// Get Role Limit Data
	$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "raid_role_lmt WHERE raid_id = ". $raid_id;
	if (!$role_result = $db_raid->sql_query($sql))
	{
		print_error($sql, $db_raid->sql_error(), 0);
		return -2; // SQL Error
	}	
	if (!$db_raid->sql_numrows($role_result) || $db_raid->sql_numrows($role_result) < 1)
		return -4; // Raid ID not Found.
	while ($role_data = $db_raid->sql_fetchrow($role_result, true))
	{
		$sql = sprintf("INSERT INTO " . $phpraid_config['db_prefix'] . "raid_role_lmt (`raid_id`, `role_id`, `lmt`)
		VALUES (%s,%s,%s)",quote_smart($raid_id_data['raid_id']), quote_smart($role_data['role_id']), quote_smart($role_data['lmt']));
		
		if (!$db_raid->sql_query($sql))
		{
			print_error($sql,$db_raid->sql_error(),0);
			return -2; //SQL Error
		} 
	}
	
	log_create('raid',mysql_insert_id(),$data['location']);
	return $raid_id_data['raid_id'];
}

/** 
 * Clean Scheduled Raids:  Upon a scheduling failure, clean the already created raids from 
 * 		the raid table.  This is the 'rollback' function.
 *
 * @param Array - raid_id_array - An array of Raid ID's to back out.
 * @return None
 * @access private
 */
function clean_scheduled_raids($raid_id_array)
{
	foreach ($raid_id_array as $raid_id)
	{
		echo "<br>Cleaning Raid Data from Raid ID: " . $raid_id;
		// Raids Table
		$sql = sprintf("DELETE FROM " . $phpraid_config['db_prefix'] . "raids
						WHERE raid_id = " . $raid_id);
		$db_raid->sql_query($sql) or print_error($sql,$db_raid->sql_error(),1);
		
		$sql = sprintf("DELETE FROM " . $phpraid_config['db_prefix'] . "raid_role_lmt
						WHERE raid_id = " . $raid_id);
		$db_raid->sql_query($sql) or print_error($sql,$db_raid->sql_error(),1);
		
		$sql = sprintf("DELETE FROM " . $phpraid_config['db_prefix'] . "raid_class_lmt
						WHERE raid_id = " . $raid_id);
		$db_raid->sql_query($sql) or print_error($sql,$db_raid->sql_error(),1);
	}	
}

/** 
 * get_next_time_stamp:  Calculate the timestamp of the next raid to be scheduled. 
  *
 * @param TIME - time - The time to calculate from.
 * @param String - Interval - The Interval for scheduling (daily, weekly, monthly).
 * @param INT - Increment - The number of intervals forward to schedule.
 * @return TIME - new_time_stamp - The new time stamp calculated off what was passed in.
 * @access private
 */
function get_next_time_stamp($time, $interval, $increment)
{
	// If the current timestamp is greater than today's raid, add a day so 
	// that we keep $num_recur raids available.
	switch ($interval)
	{
		case 'daily':	
			// start_time = start_time + $increment Days	
			$new_time_stamp = strtotime("+".$increment." days", $time);
		break;
		case 'weekly':	
			// start_time = start_time + $increment Weeks	
			$new_time_stamp = strtotime("+".$increment." weeks", $time);
		break;
		case 'monthly':	
			// start_time = start_time + $increment Months	
			$new_time_stamp = strtotime("+".$increment." months", $time);
		break;
	}
	return $new_time_stamp;	
}

/** 
 * automatic_raid_mark_old(): Parse list of current raids in database and mark any 
 * 							of them that are past raid start by X amount of time as
 * 							old. 
 *
 * @return boolean $success
 * @access private
 */
function automatic_raid_mark_old()
{
	global $phpraid_config, $db_raid, $phprlang;
	
	return true;
	
	if (!$phpraid_config['auto_mark_raids_old'])
		return true;
	
	$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "raids WHERE recurrance = 0 and old = 0";
	$raids_result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	while($raid_details = $db_raid->sql_fetchrow($raids_result, true)) 
	{
		 if ($raid_details['start_time'] < (mktime() - (3600*($phpraid_config['auto_mark_raids_old_limit']))))
		 {
		 	//Update Raid to "old" status.
		 	$sql = sprintf("UPDATE ". $phpraid_config['db_prefix'] . "raids SET old='1' WHERE raid_id=%s", quote_smart($raid_details['raid_id']));
		 	$db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
		 }
	}
		
	return true;
}

?>