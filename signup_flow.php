<?php
/***************************************************************************
 *                             signup_flow.php
 *                            -------------------
 *   begin                : Tuesday, June 26, 2007
 *   copyright            : (C) 2007 Douglas Wagner
 *   email                : douglasw0@yahoo.com
 *
 *   $Id: mysql.php,v 1.16 2002/03/19 01:07:36 psotfx Exp $
 *
 ***************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/
 
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
  * 	Demote - Take user from Drafted Area and Demote to Queue
  * 	Promote - Take user from Queue to Drafted Area or Take user from Cancelled
  * 		and move to Queued
  * 	Comments - Edit User Comments
  * 	Cancel - Move user to Cancelled Area
  * 	Delete - Delete User from Signups
  * 
  * To add buttons set the button type to true (see initializeButtons below) in the appropriate
  * permissions area and that permission group will see that button.
  * 
  * For instance, if you want an admin to be able to demote Drafted Players to the Queue you will
  * modify the signedUpFlow function, under the admin permission group and add $buttons['Demote']=TRUE;
  * 
  * See the documentation in docs for more info. 
  *****************************************************************************/
function initializeButtons()
{
	$buttons['Demote'] = FALSE;
	$buttons['Promote'] = FALSE;
	$buttons['Comments'] = FALSE;
	$buttons['Cancel'] = FALSE;
	$buttons['Delete'] = FALSE;	

	return $buttons;
}

function signedUpFlow($user_perm_group, $phpraid_config, $data, $raid_id, $phprlang, $sort_mode, $sort_descending, $signups)
{
	
		//Set Button Array to Determine which buttons are set.
		$buttons=initializeButtons();
		
		//Signed Up Buttons	
		if($user_perm_group['admin'])
		{
			//Allow Demote to Queue
			$buttons['Demote'] = TRUE;
			//Allow Edit Comments
			$buttons['Comments'] = TRUE;
		}
		
		if($user_perm_group['RL'])
		{
			//Allow Demote to Queue
			$buttons['Demote'] = TRUE;
			//Allow Edit Comments
			$buttons['Comments'] = TRUE;
		}
		
		//Demote User to Queue if Put On Queue is checked as an option. - For yourself only.
		if($phpraid_config['putonqueue'] == 1)
		{
			if ($_SESSION['profile_id'] == $data['profile_id'])
			{
				//Allow user to Demote Him/Herself to Queue.
				$buttons['Demote'] = TRUE;
			}
		}
		// Users should only have options to work on themselves, they should not be able to modify other users.				
		if($_SESSION['profile_id'] == $data['profile_id']) {
			// Edit your Comment - Users who have been drafted cannot edit their comments.
			$buttons['Comments'] = TRUE;
			
			// allow users to cancel - Admins and RLs cannot cancel drafted players, only demote.
			$buttons['Cancel'] = TRUE;
		}

		//Create Buttons
		if ($buttons['Demote']) {
			#Demote from Drafted to Queue.
			$actions .= '<a href="view.php?mode=queue&raid_id=' . $raid_id . '&char_id=' . $data['char_id'] . '&Sort=' . $sort_mode . '&SortDescending=' . $sort_descending . '">
				<img src="templates/' . $phpraid_config['template'] . '/images/icons/icon_demote.gif" border="0" 
				onMouseover="ddrivetip(\''.$phprlang['in_queue'].'\')"; onMouseout="hideddrivetip()"></a>';			
		}
		if ($buttons['Comments']) {
			#Edit Comments
			$actions .= '<a href="view.php?mode=edit_comment&raid_id='.$raid_id.'&signup_id='.$signups['signup_id'].'">
				<img src="templates/'.$phpraid_config['template'].'/images/icons/icon_edit.gif" border="0" 
				onMouseover="ddrivetip(\''.$phprlang['edit_comment'].'\')"; onMouseout="hideddrivetip()">';			
		}
		if ($buttons['Cancel']) {
			#Move to Cancelled Area
			$actions .= '<a href="view.php?mode=cancel&profile_id='.$data['profile_id'].'&raid_id=' . $raid_id . '&char_id='.$data['char_id'].'">
				<img src="templates/' . $phpraid_config['template'] . '/images/icons/icon_cancel.gif" border="0" 
				onMouseover="ddrivetip(\''.$phprlang['cancel'].'\')"; onMouseout="hideddrivetip()"></a>';			
		}
		if ($buttons['Delete']) {
			#Delete (Remove Signup Completely)
			$actions .= '<a href="view.php?mode=delete&profile_id='.$data['profile_id'].'&raid_id=' . $raid_id . '&char_id='.$data['char_id'].'">
				<img src="templates/' . $phpraid_config['template'] . '/images/icons/icon_delete.gif" border="0" 
				onMouseover="ddrivetip(\''.$phprlang['signup_delete'].'\')"; onMouseout="hideddrivetip()"></a>';			
		}

		return $actions;
}

function queuedFlow($user_perm_group, $phpraid_config, $data, $raid_id, $phprlang, $sort_mode, $sort_descending, $signups)
{

		//Set Button Array to Determine which buttons are set.
		$buttons=initializeButtons();
		
		//Signed Up Buttons	
		if($user_perm_group['admin'])
		{
			//Allow Demote to Queue
			$buttons['Promote'] = TRUE;
			//Allow Edit Comments
			$buttons['Comments'] = TRUE;
		}
		
		if($user_perm_group['RL'])
		{
			//Allow Demote to Queue
			$buttons['Promote'] = TRUE;
			//Allow Edit Comments
			$buttons['Comments'] = TRUE;
		}
		
		// Users should only have options to work on themselves, they should not be able to modify other users.
		if($_SESSION['profile_id'] == $data['profile_id']) {
			// Edit your Comment
			$buttons['Comments'] = TRUE;
			// Allow Delete
			$buttons['Delete'] = TRUE;
		}

		//Create Buttons
		if ($buttons['Promote']) {
			#Promote from Queue to Drafted.
			$actions .= '<a href="view.php?mode=queue&raid_id=' . $raid_id . '&char_id=' . $data['char_id'] . '&Sort=' . $sort_mode . '&SortDescending=' . $sort_descending . '">
				<img src="templates/' . $phpraid_config['template'] . '/images/icons/icon_promote.gif" border="0" 
				onMouseover="ddrivetip(\''.$phprlang['out_queue'].'\')"; onMouseout="hideddrivetip()"></a>';		
		}
		if ($buttons['Comments']) {
			#Edit Comments
			$actions .= '<a href="view.php?mode=edit_comment&raid_id='.$raid_id.'&signup_id='.$signups['signup_id'].'">
				<img src="templates/'.$phpraid_config['template'].'/images/icons/icon_edit.gif" border="0" 
				onMouseover="ddrivetip(\''.$phprlang['edit_comment'].'\')"; onMouseout="hideddrivetip()">';			
		}
		if ($buttons['Cancel']) {
			#Move to Cancelled Area
			$actions .= '<a href="view.php?mode=cancel&profile_id='.$data['profile_id'].'&raid_id=' . $raid_id . '&char_id='.$data['char_id'].'">
				<img src="templates/' . $phpraid_config['template'] . '/images/icons/icon_cancel.gif" border="0" 
				onMouseover="ddrivetip(\''.$phprlang['cancel'].'\')"; onMouseout="hideddrivetip()"></a>';			
		}
		if ($buttons['Delete']) {
			#Delete (Remove Signup Completely)
			$actions .= '<a href="view.php?mode=delete&profile_id='.$data['profile_id'].'&raid_id=' . $raid_id . '&char_id='.$data['char_id'].'">
				<img src="templates/' . $phpraid_config['template'] . '/images/icons/icon_delete.gif" border="0" 
				onMouseover="ddrivetip(\''.$phprlang['signup_delete'].'\')"; onMouseout="hideddrivetip()"></a>';			
		}
		
	return $actions;
}

function canceledFlow($user_perm_group, $phpraid_config, $data, $raid_id, $phprlang, $sort_mode, $sort_descending, $signups)
{
		//Set Button Array to Determine which buttons are set.
		$buttons=initializeButtons();
		
		//Signed Up Buttons	
		if($user_perm_group['admin'])
		{
			//Allow Demote to Queue
			$buttons['Comments'] = TRUE;
			//Allow Edit Comments
			$buttons['Delete'] = TRUE;
		}
		
		if($user_perm_group['RL'])
		{
			//Allow Demote to Queue
			$buttons['Comments'] = TRUE;
			//Allow Edit Comments
			$buttons['Delete'] = TRUE;
		}
		
		// Users should only have options to work on themselves, they should not be able to modify other users.				
		if($_SESSION['profile_id'] == $data['profile_id']) {
			// Edit your Comment
			$buttons['Promote'] = TRUE;
			// Allow Delete
			$buttons['Comments'] = TRUE;
		}

		//Create Buttons
		if ($buttons['Demote']) {
			#Demote from Drafted to Queue.
			$actions .= '<a href="view.php?mode=queue&raid_id=' . $raid_id . '&char_id=' . $data['char_id'] . '&Sort=' . $sort_mode . '&SortDescending=' . $sort_descending . '">
				<img src="templates/' . $phpraid_config['template'] . '/images/icons/icon_demote.gif" border="0" 
				onMouseover="ddrivetip(\''.$phprlang['in_queue'].'\')"; onMouseout="hideddrivetip()"></a>';			
		}
		if ($buttons['Promote']) {
			#Demote from Drafted to Queue.
			$actions .= '<a href="view.php?mode=queue&raid_id=' . $raid_id . '&char_id=' . $data['char_id'] . '&Sort=' . $sort_mode . '&SortDescending=' . $sort_descending . '">
				<img src="templates/' . $phpraid_config['template'] . '/images/icons/icon_promote.gif" border="0" 
				onMouseover="ddrivetip(\''.$phprlang['out_queue'].'\')"; onMouseout="hideddrivetip()"></a>';
		}
		if ($buttons['Comments']) {
			#Edit Comments
			$actions .= '<a href="view.php?mode=edit_comment&raid_id='.$raid_id.'&signup_id='.$signups['signup_id'].'">
				<img src="templates/'.$phpraid_config['template'].'/images/icons/icon_edit.gif" border="0" 
				onMouseover="ddrivetip(\''.$phprlang['edit_comment'].'\')"; onMouseout="hideddrivetip()">';			
		}
		if ($buttons['Delete']) {
			#Delete (Remove Signup Completely)
			$actions .= '<a href="view.php?mode=delete&raid_id=' . $raid_id . '&char_id='.$data['char_id'].'">
				<img src="templates/' . $phpraid_config['template'] . '/images/icons/icon_delete.gif" border="0" 
				onMouseover="ddrivetip(\''.$phprlang['signup_delete'].'\')"; onMouseout="hideddrivetip()"></a>';			
		}
		
		return $actions;
}
?>