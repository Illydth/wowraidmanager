<?php
/***************************************************************************
 *                         raid_signup.php
 *                        -------------------
 *   begin                : Jan 09, 2011
 *	 Dev                  : Carsten Hölbing
 *	 email                : carsten@hoelbing.net
 *
 *   copyright            : (C) 2007-2011 Douglas Wagner
 *   email                : douglasw0@yahoo.com
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
$phprlang['signup_edit'] = "Edit your Signup Settings";
$phprlang['character_spec'] = "Character Spec";

// commons
define("IN_PHPRAID", true);	
require_once('./common.php');

// page authentication
if($phpraid_config['anon_view'] == 1)
	define("PAGE_LVL","anonymous");
else
	define("PAGE_LVL","profile");
	
require_once("includes/authentication.php");

// check for mode passing
if (isset($_GET['mode']))
{
	$mode = scrub_input($_GET['mode']);
}
else 
{
	$mode = '';
//	log_hack();
}

//Page URL
$pageURL = 'raid_signup.php';
$pageURL_edit = $pageURL.'?mode=edit&signup_id=';
$pageURL_signup = $pageURL.'?mode=signup&raid_id=';
$returnURL = "index.php";

// This require sets up the flow control surrounding queueing, cancelling and drafting of users.
//require_once('includes/signup_flow.php');

$priv_raids = scrub_input($_SESSION['priv_raids']);
$profile_id = scrub_input($_SESSION['profile_id']);

$wrm_db_user_name = "username";
$wrm_table_prefix = $phpraid_config['db_prefix'];
$wrm_db_table_user_name = "profile";

if ($mode == "signup")
{
	$raid_id =  scrub_input($_GET['raid_id']);
	$profile_id = scrub_input($_SESSION['profile_id']);
	
	$raid_info_array = get_array_allInfo_from_RaidID($raid_id);
	$array_character = get_array_userchars_from_RaidID($raid_id, $profile_id);
	
	$comments_changeable = true;//has_user_rights_change_comments("", $profile_id);
	$array_signup_rights_type = get_array_signup_type($signup_id, $profile_id);
	$selected_signup_status = "01";
	
	$signup_header = $phprlang['view_new'];
	$button_alt = $phprlang['signup'];

	$form_action = $pageURL_signup.$raid_id;
}

else if ($mode == "edit")
{
	$array_spec = array();
	
	$signup_id =  scrub_input($_GET['signup_id']);
	$profile_id = scrub_input($_SESSION['profile_id']);
		
	$sql = sprintf(	"SELECT * FROM " . $phpraid_config['db_prefix'] . "signups ".
					" WHERE signup_id=%s", quote_smart($signup_id));
	$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	$data_signups = $db_raid->sql_fetchrow($result, true);
	//echo $sql."<br>";
	$raid_char_id = $data_signups['char_id'];
	$raid_comments = $data_signups['comments'];

	$sql = sprintf(	"SELECT `pri_spec`,`sec_spec` ".
					" FROM `" . $phpraid_config['db_prefix'] . "chars`".
					" WHERE char_id = %s", quote_smart($raid_char_id)
			);
	$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	$array_data = $db_raid->sql_fetchrow($result, true);
	if ($array_data['pri_spec'] != "")
		$array_spec[$array_data['pri_spec']] = $array_data['pri_spec'];
	if ($array_data['sec_spec'] != "")
		$array_spec[$array_data['sec_spec']] = $array_data['sec_spec'];
	$selected_spec = $data_signups['selected_spec'];
	
	if ($data_signups['cancel'] == "0" and $data_signups['queue'] == "0")
		$selected_signup_status = "00";	
	if ($data_signups['cancel'] == "1" and $data_signups['queue'] == "0")
		$selected_signup_status = "10";
	if ($data_signups['cancel'] == "0" and $data_signups['queue'] == "1")
		$selected_signup_status = "01";
	$raid_char_name = get_char_name($raid_char_id);
	
	//check for hack
	//if ($data['profile_id'] != $profile_id)
	//	log_hack();
	
	$raid_info_array = get_array_allInfo_from_RaidID($data_signups['raid_id']);
	$array_character = get_array_userchars_from_RaidID($data_signups['raid_id'], $data_signups['profile_id']);
	
	$signup_header = $phprlang['signup_edit'];
	$button_alt = $phprlang['submit'];

	//liste erstellen,
	$array_signup_rights_type = get_array_signup_type($signup_id, $profile_id);
	
	//show comments box , writeable=true, false=not	
	$comments_changeable = has_user_rights_change_comments($signup_id, $profile_id);
}	

/**
 *  --- Submit ---
 */
if ((isset($_POST['submit'])) and ($mode == "edit" or $mode == "signup"))
{

	$signup_status_new = scrub_input($_POST['signup_status']);
	$profile_id = scrub_input($_SESSION['profile_id']);
	
	if ($mode == "signup")
	{
		$comments = escapePOPUP(scrub_input($_POST['comments']));
		$char_id = scrub_input($_POST['character']);
		$raid_id =  scrub_input($_GET['raid_id']);
		$signup_status = scrub_input($_POST['signup_status']);

		$selected_spec=get_array_spec_from_char($char_id);
		if ($selected_spec == "00")
		{
			$cancel = $queue = "0";
		}
		elseif ($selected_spec == "10")
		{
			$cancel = "1";
			$queue = "0";
		}
		else 
		{
			$cancel = "1";
			$queue = "0";
		}
		
		create_new_signup($char_id,$profile_id,$raid_id,$comments,$cancel,$queue, $selected_spec[0]);
		
		/*
		 *  Log Event
		 */
		/* Status (Table Column Name) from signup table
		 * cancel='0',queue='0' => Signup Status: queue and Open spot in raid, draft them
		 * cancel='0',queue='1' => Signup Status: queue
		 * cancel='1',queue='0' => Signup Status: cancel
		 */
		
		if (($signup_status_new == "00" or $signup_status_new == "1")) //status new
		{
	//		log_raid($char_id, $raid_id, 'queue_in');
		}
		if (($signup_status_new == "01")) //status new
		{
	//		log_raid($char_id, $raid_id, 'cancel_in');
		}

		header("Location: ".$returnURL);
	
	}		
	if ($mode == "edit")
	{
		$comments = escapePOPUP(scrub_input($_POST['comments']));
		$char_spec = scrub_input($_POST['char_spec']);
		
		$sql = sprintf("UPDATE " . $phpraid_config['db_prefix'] . "signups SET comments=%s, selected_spec=%s WHERE signup_id=%s", quote_smart($comments), quote_smart($char_spec), quote_smart($signup_id));
		$db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);

		
		//check for status is change "cancel" or "queue"
		//unlike this methode
		$signup_status_cancel = $data_signups['cancel'];
		$signup_status_queue = $data_signups['queue'];
		
		if ($signup_status_new == "00")
		{
			$sql = sprintf("UPDATE " . $phpraid_config['db_prefix'] . "signups set cancel='0',queue='0' WHERE signup_id=%s", quote_smart($signup_id));
			$db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
		}
		if ($signup_status_new == "01")
		{
				$sql = sprintf("UPDATE " . $phpraid_config['db_prefix'] . "signups set cancel='0',queue='1' WHERE signup_id=%s", quote_smart($signup_id));
				$db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
		}
		// put in cancel
		if ($signup_status_new == "10")
		{
			$sql = sprintf("UPDATE " . $phpraid_config['db_prefix'] . "signups set cancel='1',queue='0' WHERE signup_id=%s", quote_smart($signup_id));
			$db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
		}
		
		/*
		 *  Log Event
		 */
		/* Status (Table Column Name) from signup table
		 * cancel='0',queue='0' => Signup Status: queue and Open spot in raid, draft them
		 * cancel='0',queue='1' => Signup Status: queue
		 * cancel='1',queue='0' => Signup Status: cancel
		 */
		
		if ((($signup_status_queue == "0") and (( $signup_status_cancel == "1"))) // status old
			and ($signup_status_new == "00" or $signup_status_new == "10")) //status new
			{
				log_raid($char_id, $raid_id, 'cancel_out');
				log_raid($char_id, $raid_id, 'queue_in');
			}
			
		if ((($signup_status_queue == "1") and (( $signup_status_cancel == "0"))) // status old
			and ($signup_status_new == "01")) //status new
			{
				log_raid($char_id, $raid_id, 'cancel_in');
				log_raid($char_id, $raid_id, 'queue_out');
			}			
	
			
		if (($signup_status_queue == "0") and (( $signup_status_cancel == "0"))) // status old
			{
				if ($signup_status_new == "10")
				{
					log_raid($char_id, $raid_id, 'cancel_in');
					log_raid($char_id, $raid_id, 'queue_out');
				}
				if ($signup_status_new == "01")
				{
					log_raid($char_id, $raid_id, 'cancel_in');
					log_raid($char_id, $raid_id, 'queue_out');
				}
				//no event for 
				//signup status: raid list => to only in the queue
				//if ($signup_status_new == "10")
				//{
				//}
			}	
			
		header("Location: ".$returnURL);
	
	}
	

		
	$form_action = $pageURL_edit.$signup_id;
}
else 
{
	//log_hack();
}

$wrmsmarty->assign('raid_signup',
	array(
		'form_action' => $form_action,
		'mode' => $mode,
		'raid_description_header' => $phprlang['view_description_header'],
		'raid_description_value' => $raid_info_array['description'],
		'information_header' => $phprlang['view_information_header'],
		'location_text' => $phprlang['view_location'],
		'location_value' => $raid_info_array['location'],
		'date_text' => $phprlang['view_date'],
		'date_value' => $raid_info_array['date'],
		'invite_date_text' => $phprlang['view_invite'],
		'invite_date_value' => $raid_info_array['invite_time'],
		'start_date_text' => $phprlang['view_start'],
		'start_date_value' => $raid_info_array['start_time'],

		'max_member_text' => $phprlang['view_max'],
		'max_member_value' => $raid_info_array['max'],
		'queued_members_text' => $phprlang['view_queued'],
		'queued_members_value' => $raid_info_array['queue_count'],

		'signup_header' => $signup_header,

		'username_text' => $phprlang['view_username'],
		'username_value' => get_user_name($profile_id),
		'character_text' => $phprlang['view_character'],
		'character_value' => $raid_char_name,
		'array_character' => $array_character,
		'spec_text' => $phprlang['character_spec'],
		'array_spec' => $array_spec,
		'selected_spec' => $selected_spec,
		'queue_text' => $phprlang['view_queue'] ,
		'array_signup_rights_type' => $array_signup_rights_type,
		'selected_signup_status' => $selected_signup_status,
		'comments_text' => $phprlang['view_comments'],
		'comments_value' => $raid_comments,
		'comments_changeable' => $comments_changeable,

		'button_submit'=>$button_alt,
		'button_reset'=>$phprlang['reset']
	)
);

//
// Start output of page
//
require_once('includes/page_header.php');
$wrmsmarty->display('raid_signup.html');
require_once('includes/page_footer.php');

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

function get_array_spec_from_char($char_id)
{
	global $db_raid, $phpraid_config;	
	
	$sql = sprintf(	"SELECT `pri_spec`,`sec_spec` ".
					" FROM `" . $phpraid_config['db_prefix'] . "chars`".
					" WHERE char_id = %s", quote_smart($char_id)
			);
	$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);	
	$array_data = $db_raid->sql_fetchrow($result, true);

	return ( array($array_data['pri_spec'],$array_data['sec_spec']) );
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

/**
 * 
 * return, in which permission group the user (profile) are
 * @param integer $profile_id
 */
function get_permission_id($profile_id)
{
	global $db_raid, $phpraid_config;
	$sql = sprintf(	"SELECT `priv` ".
					" FROM `" . $phpraid_config['db_prefix'] . "profile`".
					" WHERE profile_id = %s", quote_smart($profile_id)
			);
	$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	$data = $db_raid->sql_fetchrow($result, true);
	
	return ($data['priv']);	
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

function create_new_signup($char_id,$profile_id,$raid_id,$comments,$cancel,$queue, $selected_spec)
{
	global $db_raid, $phpraid_config;

	$sql = sprintf("INSERT INTO " . $phpraid_config['db_prefix'] . "signups ".
				" (`char_id`,`profile_id`,`raid_id`,`comments`,`cancel`,`queue`,`timestamp`,`selected_spec`)".
				" VALUES(%s,%s,%s,%s,%s,%s,%s,%s)",
				quote_smart($char_id),quote_smart($profile_id),quote_smart($raid_id),
				quote_smart($comments),quote_smart($cancel),quote_smart($queue),
				quote_smart(time()),quote_smart($selected_spec)
			);
	$db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
}

?>