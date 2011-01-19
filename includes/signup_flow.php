<?php
/***************************************************************************
 *                             signup_flow.php
 *                            -------------------
 *   begin                : Tuesday, June 26, 2007
 *   copyright            : (C) 2007-2008 Douglas Wagner
 *   email                : douglasw0@yahoo.com
 *
 *   $Id: mysql.php,v 2.00 2008/03/10 00:58:33 psotfx Exp $
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

 /**************************************************************************
  * The following are the list of all valid buttons available for each stage
  * the below flow is documented in User_Signup_Flow.txt in the docs directory.
  *
  * You can change the flow within user signups any way you like by making buttons
  * available to the users at various times.
  *
  * There are 3 types of "priviledges" users may have, buttons are addable for each
  * priviledge:
  *
  * Admin - They belong to a privlidge group wtih the "Raids" privlidge set.
  * 	admins can do anything to any raid.
  *
  * Raid Leader - The user's login profile matches that of the "officer" (owner) of the
  * 	raid.  The user created the raid and thus is considered the raid leader.   Raid
  * 	leaders have rights to do almost anything within the raid they own, but no other
  * 	raids.
  *
  * User - Raid Users, these signups do not own the raid and they do not belong to a group
  *		with the Raids bit set.  Users have limited rights to act upon their own signup
  *		but not upon any other signups.
  *
  * The following 3 functions control what buttons are available to each of the three
  * priviledges listed above: (one function for each state area: Drafted, Queued and Cancelled)
  *
  * signedUpFlow controls the buttons available to a user who is drafted.
  * queuedFlow controls the buttons available to a user who is queued.
  * canceledFlow controls the buttons available to a user who is in the Canceled status.
  *
  * Adding buttons to a priviledge in a function changes the flow of the signup application.
  *
  * Buttons Are:
  * 	Queue - Take user and place on Queued area
  * 	Draft - Take user from Queue or Cancelled to Drafted Area
  * 	Comments - Edit User Comments
  * 	Cancel - Move user to Cancelled Area
  * 	Delete - Delete User from Signups
  *
  * To add buttons set the button type to true (see initializeButtons below) in the appropriate
  * permissions area and that permission group will see that button.
  *
  * For instance, if you want an admin to be able to Queue Drafted Players to the Queued Area you will
  * modify the signedUpFlow function, under the admin permission group and add $buttons['Queue']=TRUE;
  *
  * See the documentation in docs for more info.
  *****************************************************************************/
function initializeButtons()
{
	$buttons = array();
	
	$buttons['Queue'] = FALSE;
	$buttons['Draft'] = FALSE;
	$buttons['Comments'] = FALSE;
	$buttons['Cancel'] = FALSE;
	$buttons['Delete'] = FALSE;

	return $buttons;
}

function initializeButtonsTRUE()
{
	$buttons = array();
	
	$buttons['Queue'] = TRUE;
	$buttons['Draft'] = TRUE;
	$buttons['Comments'] = TRUE;
	$buttons['Cancel'] = TRUE;
	$buttons['Delete'] = TRUE;

	return $buttons;
}
/**
 * 
 * @param $signup_group_id (1=user, 2=RL, 3=Admin)
 * @param $type
 */
function getarray_button($signup_status)
{
	global $db_raid, $phpraid_config;

	//Set Button Array to Determine which buttons are set.
	$array_button = initializeButtons();
	
	$permission_type_id = get_permission_id($_SESSION['profile_id']);
	
	$sql = sprintf(	"SELECT * FROM " . $phpraid_config['db_prefix'] . "acl_raid_permission".
					" WHERE `" . $phpraid_config['db_prefix'] . "acl_raid_permission`.`permission_type_id` = %s;",
					quote_smart($permission_type_id)
			);
	//echo $sql;
	$result_group = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	while ($data_wrm = $db_raid->sql_fetchrow($result_group,true))
	{
		if ($signup_status == "drafted")
		{			
			if($data_wrm['raid_permission_type_id'] == '9')
				$array_button['Queue'] = TRUE;
	
			if($data_wrm['raid_permission_type_id'] == '10')
				$array_button['Comments'] = TRUE;
	
			if($data_wrm['raid_permission_type_id'] == '11')
				$array_button['Cancel'] = TRUE;
	
			if($data_wrm['raid_permission_type_id'] == '12')
				$array_button['Delete'] = TRUE;
		}
		elseif ($signup_status == "queue")
		{
			if($data_wrm['raid_permission_type_id'] == '1')
				$array_button['Draft'] = TRUE;
	
			if($data_wrm['raid_permission_type_id'] == '2')
				$array_button['Comments'] = TRUE;
	
			if($data_wrm['raid_permission_type_id'] == '3')
				$array_button['Cancel'] = TRUE;
	
			if($data_wrm['raid_permission_type_id'] == '4')
				$array_button['Delete'] = TRUE;
		}
		elseif ($signup_status == "chancel")
		{			
			if($data_wrm['raid_permission_type_id'] == '5')
				$array_button['Queue'] = TRUE;

			if($data_wrm['raid_permission_type_id'] == '6')
				$array_button['Comments'] = TRUE;
	
			if($data_wrm['raid_permission_type_id'] == '7')
				$array_button['Draft'] = TRUE;
	
			if($data_wrm['raid_permission_type_id'] == '8')
				$array_button['Delete'] = TRUE;
		}
	}		
	//var_dump($array_button);
	return $array_button;
}

function signedUpFlow($user_perm_group, $phpraid_config, $data, $raid_id, $phprlang, $sort_mode, $sort_descending, $signups)
{
	global $db_raid, $phpraid_config, $phprlang;
	
	//Signed Up Buttons
	if (has_user_rights_raids(scrub_input($_SESSION['profile_id'])) == true)
	{
		$buttons = initializeButtonsTRUE();
	}
	else 
		$buttons = getarray_button("drafted");
	
	//Create Buttons
	if ($buttons['Queue']) {
		#Demote from Drafted to Queue.
		$actions .= '<a href="raid_signup.php?mode=queue&signup_id='.$signups['signup_id'].'&raid_id=' . $raid_id .'">
			<img src="templates/' . $phpraid_config['template'] . '/images/icons/icon_demote.gif" border="0"
			onMouseover="ddrivetip(\''.$phprlang['in_queue'].'\');" onMouseout="hideddrivetip();" alt="demote icon"></a>';
	}
	if ($buttons['Edit']) {
		#Edit Comments
		$actions .= '<a href="raid_signup.php?mode=edit&signup_id='.$signups['signup_id'].'">
			<img src="templates/'.$phpraid_config['template'].'/images/icons/icon_edit.gif" border="0"
			onMouseover="ddrivetip(\''.$phprlang['edit_comment'].'\');" onMouseout="hideddrivetip();" alt="edit icon">';
	}
	if ($buttons['Cancel']) {
		#Move to Cancelled Area
		$actions .= '<a href="raid_signup.php?mode=cancel&signup_id='.$signups['signup_id'].'&raid_id=' . $raid_id .'">
			<img src="templates/' . $phpraid_config['template'] . '/images/icons/icon_cancel.gif" border="0"
			onMouseover="ddrivetip(\''.$phprlang['cancel'].'\');" onMouseout="hideddrivetip();" alt="cancel icon"></a>';
	}
	if ($buttons['Delete']) {
		#Delete (Remove Signup Completely)
		$actions .= '<a href="raid_signup.php?mode=delete&signup_id='.$signups['signup_id'].'&raid_id=' . $raid_id .'">
			<img src="templates/' . $phpraid_config['template'] . '/images/icons/icon_delete.gif" border="0"
			onMouseover="ddrivetip(\''.$phprlang['signup_delete'].'\');" onMouseout="hideddrivetip();" alt="delete icon"></a>';
	}

	return $actions;
}

function queuedFlow($user_perm_group, $phpraid_config, $data, $raid_id, $phprlang, $sort_mode, $sort_descending, $signups)
{
	global $db_raid, $phpraid_config, $phprlang;
	
	//Signed Up Buttons
	if (has_user_rights_raids(scrub_input($_SESSION['profile_id'])) == true)
	{
		$buttons = initializeButtonsTRUE();
	}
	else 
		$buttons = getarray_button("queue");

	//Create Buttons
	if ($buttons['Draft']) {
		#Promote from Queue to Drafted.
		$actions .= '<a href="raid_signup.php?mode=draft&signup_id='.$signups['signup_id'].'&raid_id=' . $raid_id .'">
			<img src="templates/' . $phpraid_config['template'] . '/images/icons/icon_promote.gif" border="0"
			onMouseover="ddrivetip(\''.$phprlang['out_queue'].'\');" onMouseout="hideddrivetip();" alt="promote icon"></a>';
	}
	if ($buttons['Comments']) {
		#Edit Comments
//		$actions .= '<a href="raid_signup.php?mode=queue&amp;raid_id=' . $raid_id . '&amp;char_id=' . $data['char_id'] . '&Sort=' . $sort_mode . '&SortDescending=' . $sort_descending . '">
		$actions .= '<a href="raid_signup.php?mode=edit&signup_id='.$signups['signup_id'].'">
				<img src="templates/'.$phpraid_config['template'].'/images/icons/icon_edit.gif" border="0"
			onMouseover="ddrivetip(\''.$phprlang['edit_comment'].'\');" onMouseout="hideddrivetip();" alt="edit icon"></a>';
	}
	if ($buttons['Cancel']) {
		#Move to Cancelled Area
		$actions .= '<a href="raid_signup.php?mode=cancel&signup_id='.$signups['signup_id'].'&raid_id=' . $raid_id .'">
			<img src="templates/' . $phpraid_config['template'] . '/images/icons/icon_cancel.gif" border="0"
			onMouseover="ddrivetip(\''.$phprlang['cancel'].'\');" onMouseout="hideddrivetip();" alt="cancel icon"></a>';
	}
	if ($buttons['Delete']) {
		#Delete (Remove Signup Completely)
		$actions .= '<a href="raid_signup.php?mode=delete&signup_id='.$signups['signup_id'].'&raid_id=' . $raid_id .'">
			<img src="templates/' . $phpraid_config['template'] . '/images/icons/icon_delete.gif" border="0"
			onMouseover="ddrivetip(\''.$phprlang['signup_delete'].'\');" onMouseout="hideddrivetip();" alt="delete icon"></a>';
	}

	return $actions;
}

function canceledFlow($user_perm_group, $phpraid_config, $data, $raid_id, $phprlang, $sort_mode, $sort_descending, $signups)
{
	global $db_raid, $phpraid_config, $phprlang;
	
	//Signed Up Buttons
	if (has_user_rights_raids(scrub_input($_SESSION['profile_id'])) == true)
	{
		$buttons = initializeButtonsTRUE();
	}
	else 
		$buttons = getarray_button("chancel");
	
	//Create Buttons
	if ($buttons['Queue'])
	{
		#Promote from Cancelled to Queue.
		$actions .= '<a href="raid_signup.php?mode=queue&signup_id='.$signups['signup_id'].'&raid_id=' . $raid_id .'">'.
					'<img src="templates/' . $phpraid_config['template'] . '/images/icons/icon_promote.gif" border="0"'.
					'onMouseover="ddrivetip(\''.$phprlang['in_queue'].'\');" onMouseout="hideddrivetip();" alt="demote icon"></a>';
	}
	if ($buttons['Draft'])
	{
		#Promote from Cancelled to Drafted.
		$actions .= '<a href="raid_signup.php?mode=draft&signup_id='.$signups['signup_id'].'&raid_id=' . $raid_id .'">
			<img src="templates/' . $phpraid_config['template'] . '/images/icons/icon_promote.gif" border="0"
			onMouseover="ddrivetip(\''.$phprlang['out_queue'].'\');" onMouseout="hideddrivetip();" alt="promote icon"></a>';
	}
	if ($buttons['Comments'])
	{
		//Edit Comments
//		$actions .= '<a href="view.php?mode=edit_comment&amp;raid_id='.$raid_id.'&signup_id='.$signups['signup_id'].'">
		$actions .= '<a href="raid_signup.php?mode=edit&signup_id='.$signups['signup_id'].'">';
		$actions .= '<img src="templates/'.$phpraid_config['template'].'/images/icons/icon_edit.gif" border="0"
			onMouseover="ddrivetip(\''.$phprlang['edit_comment'].'\');" onMouseout="hideddrivetip();" alt="edit icon"></a>';
	}
	if ($buttons['Delete'])
	{
		#Delete (Remove Signup Completely)
//		$actions .= '<a href="view.php?mode=delete&profile_id='.$data['profile_id'].'&amp;raid_id=' . $raid_id . '&amp;char_id='.$data['char_id'].'">
		$actions .= '<a href="raid_signup.php?mode=delete&signup_id='.$signups['signup_id'].'&raid_id=' . $raid_id .'"">
		<img src="templates/' . $phpraid_config['template'] . '/images/icons/icon_delete.gif" border="0"
			onMouseover="ddrivetip(\''.$phprlang['signup_delete'].'\');" onMouseout="hideddrivetip();" alt="delete icon"></a>';
	}

	return $actions;
}

?>