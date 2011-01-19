<?php
/***************************************************************************
 *                         raid_view.php
 *                        -------------------
 *   begin                : Jan 16, 2011
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
if (isset($_GET['raid_id']))
{
	$raid_id = scrub_input($_GET['raid_id']);
}
else 
{
	$raid_id = '';
//	log_hack();
}

//Page URL
$raid_view = 'raid_view.php';

$returnURL = "index.php";

$raid_info_array = get_array_allInfo_from_RaidID($raid_id);

$wrmsmarty->assign('raid_view',
	array(
		'form_action' => $form_action,
		'raid_description_header' => $phprlang['view_description_header'],
		'raid_description' => $raid_info_array['description'] ,
		'information_header' => $phprlang['view_information_header'],
		'statistics_header' => $phprlang['view_statistics_header']  ,
		'location_text' => $phprlang['view_location'] ,
		'raid_location' => $raid_info_array['location'] ,
		'officer_text' => $phprlang['view_officer'] , 
		'raid_officer' => $raid_info_array['officer'] ,
		'raid_force_text' => $phprlang['raid_force_name'] ,
		'raid_force' => $raid_info_array['raid_force_name'] ,
		'date_text' => $phprlang['view_date'] ,
		'raid_date' => $raid_info_array['date'] ,
		'invite_text' => $phprlang['view_invite'] ,
		'raid_invite_time' => $raid_info_array['invite_time'] ,
		'start_text' => $phprlang['view_start'] ,
		'raid_start_time' => $raid_info_array['start_time'] ,
		'signup_text' => $phprlang['view_signup'] ,
		'minlvl_text' => $phprlang['view_min_lvl'] ,
		'raid_min_lvl' => $raid_info_array['min_lvl'] ,
		'maxlvl_text' => $phprlang['view_max_lvl'] ,
		'raid_max_lvl' => $raid_info_array['max_lvl'] ,
		'maxattendees_text' => $phprlang['view_max'] ,
		'raid_max' => $raid_info_array['max'] ,
		'approved_text' => $phprlang['view_approved'] ,
		'raid_count_percentage' => $raid_count_percentage ,
		'queued_text' => $phprlang['view_queued'] ,
		'raid_queue_count' => $raid_info_array['queue_count'] ,
		'raid_queue_count_percentage' => ($raid_info_array['queue_count']/$raid_info_array['count_total'])*100 ,
		'cancel_text' => $phprlang['view_cancel_header'] ,
		'raid_cancel_count' => $raid_info_array['count_chancel'] ,
		'raid_cancel_percentage' => ($raid_info_array['count_chancel']/$raid_info_array['count_total'])*100 ,
		'total_text' => $phprlang['view_total'] ,
		'raid_total' => $raid_info_array['count_total'] , 

		
/*
		'signup_header' => $signup_header,

		'username_text' => $phprlang['view_username'],
		'username_value' => get_user_name($profile_id),
		'character_text' => $phprlang['view_character'],
	*/	
		'button_submit'=>$button_alt,
		'button_reset'=>$phprlang['reset']
	)
);


/*
              	{section name=class_data_sec loop=$class_count_icon}
                	<td width="11%" valign="top" class="row1"><div align="center">{$class_count_icon[class_data_sec].icon}<br>
          				{$class_count_icon[class_data_sec].count}</div></td>
          		{/section}


              	{section name=role_data_sec loop=$role_count_icon}
	                <td width="20%" valign="top" class="row1"><div align="center">{$role_count_icon[role_data_sec].text}<br>
						{$role_count_icon[role_data_sec].count}</div></td>
          		{/section}
 */         		

//
// Start output of page
//
require_once('includes/page_header.php');
$wrmsmarty->display('raid_view_class.html');
require_once('includes/page_footer.php');


/**
 * THIS IS A COPY from raid_signup.php
 * 
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
?>