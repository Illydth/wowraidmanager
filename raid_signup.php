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
$phprlang['signup_error_no_chars_for_raid'] = "You have no Characters for Signup this Raid";

// commons
define("IN_PHPRAID", true);	
require_once('./common.php');
require_once('./includes/functions_raids.php');

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
$returnURL = "raid_view.php?mode=view&signup_id=";
$file_URL_raidview_view = "raid_view.php?mode=view&raid_id=";

// This require sets up the flow control surrounding queueing, cancelling and drafting of users.
//require_once('includes/signup_flow.php');

$priv_raids = scrub_input($_SESSION['priv_raids']);
$profile_id = scrub_input($_SESSION['profile_id']);

$wrm_db_user_name = "username";
$wrm_table_prefix = $phpraid_config['db_prefix'];
$wrm_db_table_user_name = "profile";
$error_msg = "";
	
if ($mode == "signup")
{
	$raid_id =  scrub_input($_GET['raid_id']);
	$profile_id = scrub_input($_SESSION['profile_id']);
	
	$raid_info_array = get_array_allInfo_from_RaidID($raid_id);
	$array_character = get_array_userchars_from_RaidID($raid_id, $profile_id);
	
	$comments_changeable = true;//has_user_rights_change_comments("", $profile_id);
	$array_signup_rights_type = get_array_signup_type($signup_id,$profile_id+1);
	$selected_signup_status = "01";
	
	$signup_header = $phprlang['view_new'];
	$button_alt = $phprlang['signup'];

	if ($array_character == False)
		$error_msg = $phprlang['signup_error_no_chars_for_raid'];
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
	
	$signup_header = $phprlang['signup_edit_header'];
	$button_alt = $phprlang['submit'];

	//liste erstellen,
	$array_signup_rights_type = get_array_signup_type($signup_id, $profile_id);
	
	//show comments box , writeable=true, false=not	
	$comments_changeable = has_user_rights_change_comments($signup_id, $profile_id);
}	
elseif($mode == 'cancel')
{
/*	$S_profile_id = scrub_input($_SESSION['profile_id']);
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
*/
	$signup_id = scrub_input($_GET['signup_id']);
	
	set_signup_status_chancel($signup_id);
	//$raid_id = get_raidid_from_signup($signup_id);
	
	// put in cancel
	log_raid($char_id, $raid_id, 'cancel_in');
	$raid_id = scrub_input($_GET['raid_id']);
	header("Location: ".$file_URL_raidview_view.$raid_id);
}
elseif($mode == 'draft')
{
/*	$S_profile_id = scrub_input($_SESSION['profile_id']);
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
*/
	$signup_id = scrub_input($_GET['signup_id']);
	
	set_signup_status_drafted($signup_id);
	//$raid_id = get_raidid_from_signup($signup_id);
	$raid_id = scrub_input($_GET['raid_id']);
	
	header("Location: ".$file_URL_raidview_view.$raid_id);
}
elseif($mode == 'queue')
{
/*	$S_profile_id = scrub_input($_SESSION['profile_id']);
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
*/
	$signup_id = scrub_input($_GET['signup_id']);
	$raid_id = scrub_input($_GET['raid_id']);
	
	set_signup_status_queue($signup_id);
	//$raid_id = get_raidid_from_signup($signup_id);

	header("Location: ".$file_URL_raidview_view.$raid_id);
}
elseif($mode == 'delete')
{
//	$char_id = scrub_input($_GET['char_id']);
//	$profile_id = scrub_input($_GET['profile_id']);
//	$S_profile_id = scrub_input($_SESSION['profile_id']);
	
	$signup_id = scrub_input($_GET['signup_id']);
	$raid_id = scrub_input($_GET['raid_id']);	

	// they have permission to delete
	if(!isset($_POST['submit_del'])) 
	{
		$form_action = 'raid_signup.php?mode=delete&signup_id='.$signup_id.'&raid_id=' . $raid_id;
		$confirm_button = '<input type="submit" value="'.$phprlang['confirm'].'" name="submit_del" class="post">';

		$wrmsmarty->assign('page',
			array(
				'form_action'=>$form_action,
				'confirm_button'=>$confirm_button,
				'delete_header'=>$phprlang['confirm_deletion'],
				'delete_msg'=>$phprlang['delete_msg'],
			)
		);
		//
		// Start output of Delete Page
		//
		require_once('includes/page_header.php');
		$wrmsmarty->display('delete.html');
		require_once('includes/page_footer.php');
		exit;
	} 
	elseif (isset($_POST['submit_del']))
	{
		del_signup($signup_id);

		log_raid($char_id, $raid_id, 'delete');
		header("Location: ".$file_URL_raidview_view.$raid_id);
	}
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
		
		$selected_spec = get_array_spec_from_char($char_id);
		
		if ($signup_status_new == "00")
		{
			$cancel = $queue = "0";
		}
		elseif ($signup_status_new == "10")
		{
			$cancel = "1";
			$queue = "0";
		}
		else 
		{
			$cancel = "0";
			$queue = "1";
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

		header("Location: ./index.php");
	
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
			set_signup_status_drafted($signup_id);
		}
		if ($signup_status_new == "01")
		{
			set_signup_status_queue($signup_id);
		}
		// put in cancel
		if ($signup_status_new == "10")
		{
			set_signup_status_chancel($signup_id);
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
			
		header("Location: ".$file_URL_raidview_view.$raid_id);
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

		'raid_lvl_min_text' => $phprlang['min_lvl'],
		'raid_lvl_min_value' => $raid_info_array['min_lvl'],
		'raid_lvl_max_text' => $phprlang['max_lvl'],
		'raid_lvl_max_value' => $raid_info_array['max_lvl'],
		
		'signup_header' => $signup_header,

		'username_text' => $phprlang['view_username'],
		'username_value' => get_user_name($profile_id),
		'character_text' => $phprlang['view_character'],
		'character_value' => $raid_char_name,
		'array_character' => $array_character,
		'spec_text' => $phprlang['signup_character_spec'],
		'array_spec' => $array_spec,
		'selected_spec' => $selected_spec,
		'queue_text' => $phprlang['view_queue'] ,
		'array_signup_rights_type' => $array_signup_rights_type,
		'selected_signup_status' => $selected_signup_status,
		'comments_text' => $phprlang['view_comments'],
		'comments_value' => $raid_comments,
		'comments_changeable' => $comments_changeable,
	
		'error_msg' => $error_msg,

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

?>