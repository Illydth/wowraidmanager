<?php
/***************************************************************************                          
 *                         signup_flow.php
 *                        -------------------
 *   begin                : Jan 22, 2011
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

 /**************************************************************************
  * The following are the list of all valid buttons available for each stage
  * the below flow is documented in User_Signup_Flow.txt in the docs directory.
  *
  * You can change the flow within user signups any way you like by making buttons
  * available to the users at various times.
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

function initializeButtons($signup_signup_id, $signup_raid_id)
{
	global $phprlang, $phpraid_config;
	
	$buttons = array();
		
	#Edit Comments
	$buttons['Comments'] = '<a href="raid_signup.php?mode=edit&signup_id='.$signup_signup_id.'">
			<img src="templates/'.$phpraid_config['template'].'/images/icons/icon_edit.gif" border="0"
		onMouseover="ddrivetip(\''.$phprlang['edit'].'\');" onMouseout="hideddrivetip();" alt="edit icon"></a>';

	#Delete (Remove Signup Completely)
	$buttons['Delete'] = '<a href="raid_signup.php?mode=delete&signup_id='.$signup_signup_id.'&raid_id=' . $signup_raid_id .'">
		<img src="templates/' . $phpraid_config['template'] . '/images/icons/icon_delete.gif" border="0"
		onMouseover="ddrivetip(\''.$phprlang['signup_delete'].'\');" onMouseout="hideddrivetip();" alt="delete icon"></a>';

	#Promote from Queue to Drafted.
	$buttons['Draft'] = '<a href="raid_signup.php?mode=draft&signup_id='.$signup_signup_id.'&raid_id=' . $signup_raid_id .'">
		<img src="templates/' . $phpraid_config['template'] . '/images/icons/icon_promote.gif" border="0"
		onMouseover="ddrivetip(\''.$phprlang['out_queue'].'\');" onMouseout="hideddrivetip();" alt="promote icon"></a>';

	#Demote from Drafted to Queue.
	$buttons['Queue'] = '<a href="raid_signup.php?mode=queue&signup_id='.$signup_signup_id.'&raid_id=' . $signup_raid_id .'">
		<img src="templates/' . $phpraid_config['template'] . '/images/icons/icon_demote.gif" border="0"
		onMouseover="ddrivetip(\''.$phprlang['in_queue'].'\');" onMouseout="hideddrivetip();" alt="demote icon"></a>';

	#Move to Cancelled Area
	$buttons['Cancel'] = '<a href="raid_signup.php?mode=cancel&signup_id='.$signup_signup_id.'&raid_id=' . $signup_raid_id .'">
		<img src="templates/' . $phpraid_config['template'] . '/images/icons/icon_cancel.gif" border="0"
		onMouseover="ddrivetip(\''.$phprlang['cancel'].'\');" onMouseout="hideddrivetip();" alt="cancel icon"></a>';
	
	return $buttons;
}

function get_SignUp_Buttons($profile_id, $priv_raids, $signup_profile_id, $signup_signup_id, $signup_raid_id, $signup_signupstatus)
{
	global $db_raid, $phpraid_config;
	$action_button = "";
	
	//Set Button Array to Determine which buttons are set.
	$array_button = array();
	$array_button = initializeButtons($signup_signup_id, $signup_raid_id);
	
	$permission_type_id = get_permission_id($_SESSION['profile_id']);
	
	$sql = sprintf(	"SELECT * FROM " . $phpraid_config['db_prefix'] . "acl_raid_permission".
					" WHERE `" . $phpraid_config['db_prefix'] . "acl_raid_permission`.`permission_type_id` = %s;",
					quote_smart($permission_type_id)
			);
	$result_group = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	while ($data_wrm = $db_raid->sql_fetchrow($result_group,true))
	{
		if ($signup_signupstatus == "00")
		{	
			if ( ($profile_id == $signup_profile_id) or ($priv_raids == 1))	
			{
				if($data_wrm['raid_permission_type_id'] == '9')
					$action_button .= $array_button['Queue'];
		
				if($data_wrm['raid_permission_type_id'] == '10')
					$action_button .= $array_button['Comments'];
		
				if($data_wrm['raid_permission_type_id'] == '11')
					$action_button .= $array_button['Cancel'];
		
				if($data_wrm['raid_permission_type_id'] == '12')
					$action_button .= $array_button['Delete'];				
			}	

		}
		elseif ($signup_signupstatus == "01")
		{
			if ( ($profile_id == $signup_profile_id) or ($priv_raids == 1))	
			{			
				if($data_wrm['raid_permission_type_id'] == '1')
					$action_button .= $array_button['Draft'];
		
				if($data_wrm['raid_permission_type_id'] == '2')
					$action_button .= $array_button['Comments'];
		
				if($data_wrm['raid_permission_type_id'] == '3')
					$action_button .= $array_button['Cancel'];
		
				if($data_wrm['raid_permission_type_id'] == '4')
					$action_button .= $array_button['Delete'];
			}
		}
		elseif ($signup_signupstatus == "10")
		{	
			if ( ($profile_id == $signup_profile_id) or ($priv_raids == 1))	
			{					
				if($data_wrm['raid_permission_type_id'] == '5')
					$action_button .= $array_button['Queue'];
	
				if($data_wrm['raid_permission_type_id'] == '6')
					$action_button .= $array_button['Comments'];
		
				if($data_wrm['raid_permission_type_id'] == '7')
					$action_button .= $array_button['Draft'];
		
				if($data_wrm['raid_permission_type_id'] == '8')
					$action_button .= $array_button['Delete'];
			}
		}
	}

	return $action_button;
}

?>