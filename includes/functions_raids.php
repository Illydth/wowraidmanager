<?php
/***************************************************************************
*                           functions_raids.php
*                           ---------------------
*   begin                : Mon, Sep 20, 2010
*   copyright            : (C) 2007-2010 Carsten Hölbing
*   email                : carsten@hoelbing.net
*
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
/*
 * Raid: del
 */
function raid_del($id, $n)
{	
	global $phpraid_config, $db_raid;
	
	log_delete('raid',$n);

	$sql = sprintf(	"DELETE FROM " . $phpraid_config['db_prefix'] . "raids ".
					"	WHERE raid_id=%s", quote_smart($id));
	$db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);

	$sql = sprintf(	"DELETE FROM " . $phpraid_config['db_prefix'] . "signups".
					"	WHERE raid_id=%s", quote_smart($id));
	$db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);

	$sql = sprintf(	"DELETE FROM " . $phpraid_config['db_prefix'] . "raid_class_lmt ".
					"	WHERE raid_id=%s",quote_smart($id));
	$db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);

	$sql = sprintf(	"DELETE FROM " . $phpraid_config['db_prefix'] . "raid_role_lmt ".
					"	WHERE raid_id=%s",quote_smart($id));
	$db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
		
}

function raid_mark($raid_id)
{
	global $phpraid_config, $db_raid;
	
	$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "raids WHERE raid_id=%s", quote_smart($raid_id));
	$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	$data = $db_raid->sql_fetchrow($result, true);
	
	if($data['old'] == 1)
	{
		$sql = sprintf("UPDATE " . $phpraid_config['db_prefix'] . "raids SET old='0' WHERE raid_id=%s", quote_smart($raid_id));
		$db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	}
	else
	{
		$sql = sprintf("UPDATE " . $phpraid_config['db_prefix'] . "raids SET old='1' WHERE raid_id=%s", quote_smart($raid_id));
		$db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	}
}

/**
 * Get all Information about the selected Raid
 * @param numeric $raid_id
 * NOTE: move to includes/functions_raids.php
 */
function get_array_allInfo_from_RaidID($raid_id)
{
	global $db_raid, $phpraid_config;

	$raid_info_array = array();

	// Obtain data for the raid
	$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "raids WHERE raid_id=%s", quote_smart($raid_id));
	$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	$data = $db_raid->sql_fetchrow($result, true);

	$raid_info_array['date'] = new_date($phpraid_config['date_format'],$data['start_time'],$phpraid_config['timezone'] + $phpraid_config['dst']);
	$raid_info_array['invite_time'] = new_date($phpraid_config['time_format'],$data['invite_time'],$phpraid_config['timezone'] + $phpraid_config['dst']);
	$raid_info_array['start_time'] = new_date($phpraid_config['time_format'],$data['start_time'],$phpraid_config['timezone'] + $phpraid_config['dst']);

	$raid_info_array['location'] = UBB2($data['location']);
	$raid_info_array['description'] = $data['description'];
	
	$raid_info_array['max'] = $data['max'];
	$raid_info_array['min_lvl'] = $data['min_lvl'];
	$raid_info_array['max_lvl'] = $data['max_lvl'];

	$raid_info_array['officer'] = $data['officer'];	

	$raid_info_array['freeze'] = $data['freeze'];
	$raid_info_array['old'] = $data['old'];
	$raid_info_array['event_type'] = $data['event_type'];	
	$raid_info_array['event_id'] = $data['event_id'];
	$raid_info_array['raid_force_name'] = $data['raid_force_name'];
	$raid_info_array['recurrance'] = $data['recurrance'];
	$raid_info_array['rec_interval'] = $data['rec_interval'];
	$raid_info_array['num_recur'] = $data['num_recur'];	
	
	// get signup information
	$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "signups WHERE raid_id=%s AND queue='0' AND cancel='0'", quote_smart($raid_id));
	$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	$raid_info_array['count_signup_total'] = $db_raid->sql_numrows($result);
	
	// get cancel information
	$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "signups WHERE raid_id=%s AND queue='0' AND cancel='1'", quote_smart($raid_id));
	$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	$raid_info_array['count_chancel'] = $db_raid->sql_numrows($result);
	
	// get queue information
	$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "signups WHERE raid_id=%s AND queue='1'", quote_smart($raid_id));
	$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	$raid_info_array['queue_count'] = $db_raid->sql_numrows($result);

	// get totals
	$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "signups WHERE raid_id=%s", quote_smart($raid_id));
	$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	$raid_info_array['count_total'] = $db_raid->sql_numrows($result);
	
	return $raid_info_array;
}

/**
 * Gets possible chars by selected raid_id
 * NOTE: move to includes/functions_raids.php
 */
function get_array_userchars_from_RaidID($raid_id, $profile_id)
{
	global $db_raid, $phpraid_config; 
	$array_char_all = array();
	$array_char_ProfilID = array();
	
	$array_char_all =  get_array_allpossible_chars_from_RaidID($raid_id);

	for ($i=1; $i < count($array_char_all)+1;$i++ )
	{
		$sql = sprintf(	"SELECT `char_id`,`profile_id`,`name` ".
						" FROM `" . $phpraid_config['db_prefix'] . "chars`".
						" WHERE name = %s", quote_smart($array_char_all[$i])
				);

		$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
		$array_data = $db_raid->sql_fetchrow($result, true);
	
		if ($profile_id == $array_data['profile_id'])
			$array_char_ProfilID[$array_data['char_id']] = $array_data['name'];
		 
	}
	
	if (count($array_char_ProfilID) != 0)
		return $array_char_ProfilID;
	else 
		return false;
}

/**
 * return value
 * array (char_id, profil_id)
 * NOTE: move to includes/functions_raids.php
 */
function get_array_allpossible_chars_from_RaidID($raid_id)
{
	global $db_raid, $phpraid_config;	
	$chars = array();

	$sql = sprintf(	"SELECT * ".
					" FROM `" . $phpraid_config['db_prefix'] . "raids`".
					" WHERE raid_id = %s", quote_smart($raid_id)
			);
	$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);	
	$array_raid = $db_raid->sql_fetchrow($result, true);

	$sql = sprintf(	"SELECT * ".
					" FROM `" . $phpraid_config['db_prefix'] . "chars`");
	$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	while($array_char = $db_raid->sql_fetchrow($result, true))
	{
		$char_check_lvl = false;
		$char_check_resist = false;
		$char_check_class = false;
		$char_check_role = false;
				
		//check: level
		if ( ($array_raid['min_lvl'] <= $array_char['lvl']) and ($array_char['lvl'] <= $array_raid['max_lvl']))
			$char_check_lvl = true;
		
		//check: resist
		if ($phpraid_config['resop'] == "0")
		{
			//@ todo resist
			//not implement yet
			$char_check_resist = true;			
		}
		else 
		{
			$char_check_resist = true;	
		}
		

		//@ todo class
		//not implement yet
		//check: class
		$char_check_class = true;
		
		//@ todo role
		//not implement yet
		//check: role
		$char_check_role = true;

		
		if ( ($char_check_lvl == true) and 
			 ($char_check_resist == true) and
			 ($char_check_class == true) and
			 ($char_check_role == true)
			)
		{
			$chars[$array_char['char_id']] = $array_char['name'];
		}
	
	}		
	return ($chars);
}

function has_user_rights_change_comments($signup_id, $profile_id)
{
	// permission grp, dann schauen was diese grp kann
	global $db_raid, $phpraid_config;
	
	if ($signup_id != "")
	{
		$has_user_rights_change_comments = false;
		
		$permission_type_id = get_permission_id($profile_id);
	
		$sql = sprintf(	"SELECT `cancel`,`queue` ".
						" FROM `" . $phpraid_config['db_prefix'] . "signups`".
						" WHERE signup_id = %s", quote_smart($signup_id)
			);
		$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
		$data = $db_raid->sql_fetchrow($result, true);
		$status_cancel =  $data['cancel'];
		$status_queue =  $data['queue'];
		
		$sql = sprintf(	"SELECT `raid_permission_type_id` ".
						" FROM `" . $phpraid_config['db_prefix'] . "acl_raid_permission`".
						" WHERE permission_type_id = %s", quote_smart($permission_type_id)
				);
		$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
		while($data = $db_raid->sql_fetchrow($result, true))
		{
			//on_queue_comments = 2
			if (($data['raid_permission_type_id'] ==	"2")
				and ($status_cancel == "1") )
				$has_user_rights_change_comments = true;
				
			//cancelled_status_comments	
			if (($data['raid_permission_type_id'] ==	"7")
				and ($status_queue == "1") )
				$has_user_rights_change_comments = true;
			
			//drafted_comments
			if (($data['raid_permission_type_id'] ==	"10")
				and ($status_cancel == "0") and ($status_queue == "0") )
				$has_user_rights_change_comments = true;
		}
	}
	else 
	{
		$has_user_rights_change_comments = true;
	}
	
	return ($has_user_rights_change_comments);
}

function get_array_signup_type($signup_id, $profile_id)
{
	/*
	 * cancel='0',queue='0' => Signup Status: queue and Open spot in raid, draft them
	 * cancel='0',queue='1' => Signup Status: queue
	 * cancel='1',queue='0' => Signup Status: cancel
	 */
	
	global $db_raid, $phpraid_config,$phprlang;
	
	$signup_type = array();
	$permission_type_id = get_permission_id($profile_id);
	
	if ($signup_id != "")
	{
		$sql = sprintf(	"SELECT * ".
						" FROM `" . $phpraid_config['db_prefix'] . "signups`".
						" WHERE signup_id = %s", quote_smart($signup_id)
				);
		$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
		$data = $db_raid->sql_fetchrow($result, true);
		
		//cancel
		if ($data['cancel'] ==	"1")
			$status_cancel = 1;
		else 
			$status_cancel = 0;
			
		//queue
		if ($data['queue'] ==	"1")
			$status_queue = 1;
		else 
			$status_queue = 0;

	
		$sql = sprintf(	"SELECT `raid_permission_type_id` ".
						" FROM `" . $phpraid_config['db_prefix'] . "acl_raid_permission`".
						" WHERE permission_type_id = %s", quote_smart($permission_type_id)
				);
		$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
		while($data = $db_raid->sql_fetchrow($result, true))
		{
			
			//on_queue status
			if ( $status_queue == "1")
			{
				$signup_type['01'] = $phprlang['configuration_queue_def'];

				//on_queue_draft 1
				if ($data['raid_permission_type_id'] ==	"1")
					$signup_type['00'] = $phprlang['configuration_drafted'];
				//on_queue_cancel 3
				if ($data['raid_permission_type_id'] ==	"3")
					$signup_type['10'] = $phprlang['configuration_cancel_def'];
			}

			
			// cancelled status
			if ( $status_cancel == "1")
			{
				$signup_type['10'] = $phprlang['configuration_cancel_def'];
				
				// cancelled_status_queue 5
				if ( $data['raid_permission_type_id'] == "5")
					$signup_type['01'] = $phprlang['configuration_queue_def'];
				//cancelled_status_draft 6
				if ( $data['raid_permission_type_id'] == "6")
					$signup_type['00'] = $phprlang['configuration_drafted'];
			}
			
			// drafted status
			if ( $status_cancel == "0" and $status_queue == "0")
			{
				$signup_type['00'] = $phprlang['configuration_drafted'];
				
				// drafted_queue 9
				if ($data['raid_permission_type_id'] ==	"9")
					$signup_type['01'] = $phprlang['configuration_queue_def'];
				//drafted_cancel 11
				if ($data['raid_permission_type_id'] ==	"11")
					$signup_type['10'] = $phprlang['configuration_cancel_def'];
			}
		}	
	}
	else 
	{
		$signup_type['00'] = $phprlang['configuration_drafted'];
		$signup_type['01'] = $phprlang['configuration_queue_def'];
		$signup_type['10'] = $phprlang['configuration_cancel_def'];	
	}

	return ($signup_type);
}
/**
 * 
 * create a new Signup
 * @param unknown_type $char_id
 * @param unknown_type $profile_id
 * @param unknown_type $raid_id
 * @param unknown_type $comments
 * @param unknown_type $cancel
 * @param unknown_type $queue
 * @param unknown_type $selected_spec
 */
function create_new_signup($char_id,$profile_id,$raid_id,$comments,$cancel, $queue, $selected_spec)
{
	global $db_raid, $phpraid_config;

	$sql = sprintf(	"INSERT INTO " . $phpraid_config['db_prefix'] . "signups ".
					" (`char_id`,`profile_id`,`raid_id`,`comments`,`cancel`,`queue`,`timestamp`,`selected_spec`)".
					" VALUES(%s,%s,%s,%s,%s,%s,%s,%s)",
				quote_smart($char_id),quote_smart($profile_id),quote_smart($raid_id),
				quote_smart($comments),quote_smart($cancel),quote_smart($queue),
				quote_smart(time()),quote_smart($selected_spec)
			);

	$db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
}

function del_signup($signup_id)
{
	global $db_raid, $phpraid_config;
	
	$sql = sprintf(	"DELETE FROM " . $phpraid_config['db_prefix'] . "signups ".
					" WHERE `signup_id`=%s", 
					quote_smart($signup_id));
	echo $sql;
	$db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
}
/**
 * 
 * change signup status to chancel
 * @param integer $signup_id
 */
function set_signup_status_chancel($signup_id)
{
	global $db_raid, $phpraid_config;
	
	$sql = sprintf(	"UPDATE " . $phpraid_config['db_prefix'] . "signups ".
					" set cancel='1',queue='0',timestamp=%s ".
					" WHERE `signup_id`=%s", 
					quote_smart(time()), quote_smart($signup_id));
	$db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
}

/**
 * 
 * change signup status to queue
 * @param integer $signup_id
 */
function set_signup_status_queue($signup_id)
{
	global $db_raid, $phpraid_config;
	
	$sql = sprintf(	"UPDATE " . $phpraid_config['db_prefix'] . "signups ".
					" set cancel='0',queue='1',timestamp=%s ".
					" WHERE `signup_id`=%s", 
					quote_smart(time()), quote_smart($signup_id));
	$db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
}

/**
 * 
 * change signup status to drafted
 * @param integer $signup_id
 */
function set_signup_status_drafted($signup_id)
{
	global $db_raid, $phpraid_config;
	
	$sql = sprintf(	"UPDATE " . $phpraid_config['db_prefix'] . "signups ".
					" set cancel='0',queue='0',timestamp=%s ".
					" WHERE `signup_id`=%s", 
					quote_smart(time()), quote_smart($signup_id));
	$db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
}

function get_raidid_from_signup($signup_id)
{
	global $db_raid, $phpraid_config;

	$sql = sprintf(	"SELECT `priv` ".
					" FROM `" . $phpraid_config['db_prefix'] . "signup`".
					" WHERE profile_id = %s", quote_smart($profile_id)
			);
	$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	$data = $db_raid->sql_fetchrow($result, true);
	
	return ($data['raid_id']);			
}

?>