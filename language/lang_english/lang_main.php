<?php
/***************************************************************************
 *                           lang_main.php (English)
 *                            -------------------
 *   begin                : Saturday, Jan 16, 2005
 *   copyright            : (C) 2007-2008 Douglas Wagner
 *   email                : douglasw@wagnerweb.org
 *
 *   $Id: lang_main.php,v 2.00 2008/03/07 13:46:51 psotfx Exp $
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
global $phprlang;

// logging language file
require_once('lang_log.php');

// page specific language file
require_once('lang_pages.php');

// admin section language file
require_once('lang_admin.php');

if (empty($phprlang) || !is_array($phprlang))
	$phprlang = array();
	
$phprlang = array_merge($phprlang, array(

// data output headers (Reports.php)
'add_team' 								=> 'Check to Add To Team',
'add_team_dropdown_text' 				=> 'Select Team to Add Members To',
'team_global' 							=> 'Mark Group Available to All Raids',
'male' 									=>  'Male',
'female' 								=>  'Female',
'class' 								=>  'Class',
'date' 									=>  'Date',
'description' 							=>  'Description',
'email' 								=>  'E-mail',
'guild' 								=>  'Guild',
'guild_name' 							=>  'Guild Name',
'guild_master' 							=>  'Guildmaster',
'guild_tag' =>  'Guild Tag',
'guild_description' =>  'Guild Description',
'guild_server' =>  'Guild Server',
'guild_faction' =>  'Guild Faction',
'guild_armory_link' =>  'Armory Link',
'guild_armory_code' =>  'Armory Code',
'guild_id' =>  'Guild ID',
'raid_force_id' =>  'Raid Force ID',
'raid_force_name' =>  'Raid Force',
'id' =>  'ID',
'invite_time' =>  'Invite Time',
'level' =>  'Level',
'location' =>  'Dungeon',
'max_lvl' =>  'Max Lvl',
'max_raiders' =>  'Raid Max',
'locked_header' =>  'Locked?',
'message' =>  'Message',
'min_lvl' =>  'Min Lvl',
'name' =>  'Name',
'officer' =>  'Creator',
'no_data' =>  'Empty',
'posted_by' =>  'Posted By',
'race' =>  'Race',
'start_time' =>  'Start Time',
'team_name' =>  'Team Name',
'time' =>  'Time',
'title' =>  'Title',
'totals' =>  'Totals',
'username' =>  'Username',
'records' =>  'Record(s)',
'to' =>  'to',
'of' =>  'of',
'total' =>  'total',
'section' =>  'Section',
'prev' =>  'Prev',
'next' =>  'Next',
'earned' =>  'Earned',
'spent' =>  'Spent',
'adjustment' =>  'Adjustment',
'dkp' =>  'DKP',
'buttons' =>  'Buttons',
'add_to_team' =>  'Add To Team',
'create_date' =>  'Create Date',
'create_time' =>  'Create Time',
'pri_spec' =>  'Pri Talent',
'sec_spec' =>  'Sec Talent',
'signup_spec' =>  'Draft As',
'role_id' =>  'Role ID',
'role_name' =>  'Role Name',
'role_config' =>  'Role Config Text',
'role_image' =>  'Role Image',
'talent_tree' =>  'Talent Tree',
'display_text' =>  'Display Text',
'perm_mod' =>  'Update Permissions',
'all' =>  'All',

// Reoccurance Text Items
'recur_header' =>  'Raid Recurrance Settings',
'raids_recur' =>  'Recurring Raids',
'daily' =>  'Daily (Every Day At This Time)',
'weekly' =>  'Weekly (On This Day of the Week)',
'monthly' =>  'Monthly (On This Day of the Month)',
'recurrance' =>  'Recurring Raid?<br><a href="docs/recurring_raids.html" target="_blank">help?</a>',
'recur_interval' =>  'Recurrance Interval',
'recur_length' =>  'Number of Intervals to Show',

// Scheduler Texts
'scheduler_error_header' =>  'Scheduler Error',
'scheduler_unknown' =>  'The scheduler threw an Unknown error, please post the error message to WRM support.',
'scheduler_error_no_raid_found' =>  'No raid found when attempting to select the current recurring raid from the raids table.
												Recurring Raid was likely deleted, please reload the page.',
'scheduler_error_schedule_raid' =>  'Error Scheduling New Raids from Recurring Raids.',
'scheduler_error_sql_error' =>  'Generic SQL Error Occured, See Above Printed Information.',
'scheduler_error_update_recurring' =>  'Failed to Update Timestamp on Recurring Raid.',
'scheduler_error_class_limits_missing' =>  'Class Limits could not be retrieved for Recurring Raid.  
													Delete Recurring Raid and Try again.',
'scheduler_error_role_limits_missing' =>  'Role Limits could not be retrieved for Recurring Raid.  
													Delete Recurring Raid and Try again.',

// roles
'role_none' =>  '-',
'role' =>  'Role',

// errors
'connect_socked_error' =>  'Failed to connect to socket with error %s',
'invalid_group_title' =>  'Group exists',
'invalid_group_message' =>  'The group selected is already part of this set. Press your browsers BACK button to try again.',
'invalid_option_title' =>  'Invalid input for page',
'invalid_option_msg' =>  'You have tried to access this page using invalid input.',
'no_user_msg' =>  'The user you are trying to view does not exist or has been deleted.',
'no_user_title' =>  'User does not exist',
'print_error_critical' =>  'a critical error!',
'print_error_details' =>  'Details',
'print_error_minor' =>  'a minor error!',
'print_error_msg_begin' =>  'Sorry, WRM has encountered ',
'print_error_msg_end' =>  'If this error persists, please make a post 
									with this message <br>on the <a href="http://www.wowraidmanager.net/">wowraidmanager.net Forums</a> and
									we will do our best to get it corrected. Thanks!',
'print_error_page' =>  'Page',
'print_error_query' =>  'Query',
'print_error_title' =>  'Uh oh! You hit a boo boo',
'socket_functions_disabled' =>  'Update checked failed to connect to server.',

// forms
'asc' =>  'ascending',
'auth_phpbb_no_groups' =>  'No groups available to add',
'desc' =>  'descending',
'form_error' =>  'Error with your form submission',
'form_select' =>  'Select One',
'no' =>  'No',
'none' =>  'None',
'guild_name_missing' =>  'The Full Guild Name is missing.',
'guild_tag_missing' =>  'The Guild Tag is missing.',
'permissions_form_description' =>  'You must input a description',
'permissions_form_name' =>  'You must input a name',
'profile_error_arcane' =>  'Arcane must be numeric',
'profile_error_class' =>  'You must selet a class',
'profile_error_dupe' =>  'A character with that name already exists',
'profile_error_fire' =>  'Fire must be numeric',
'profile_error_frost' =>  'Frost must be numeric',
'profile_error_guild' =>  'You must select a guild',
'profile_error_level' =>  'Level must be numeric from 1-80',
'profile_error_name' =>  'You must enter a name',
'profile_error_nature' =>  'Nature must be numeric',
'profile_error_race' =>  'You must select a race',
'profile_error_role' =>  'You must enter a role',
'profile_error_shadow' =>  'Shadow must be numeric',
'raid_error_date' =>  'You must input a proper date',
'raid_error_description' =>  'Description must be entered',
'raid_error_limits' =>  'All raid limits must be entered and numeric',
'raid_error_location' =>  'Input a raid location',
'view_error_signed_up' =>  'You have already signed up with this character',
'view_error_role_undef' =>  'Make sure that the Character in <a href="profile.php?mode=view">Profile</a> has a defined Role.',
'yes' =>  'Yes',
'teams_error_no_team' =>  'No team is selected to add users to.',

// Buttons
'submit' =>  'Submit',
'reset' =>  'Reset',
'confirm' =>  'Confirm',
'update' =>  'Update',
'confirm_deletion' =>  'Confirm Deletion',
'filter' =>  'Filter',
'addchar' =>  'Add Character',
'updatechar' =>  'Update Character',
'login' =>  'Log In',
'logout' =>  'Log Out',
'signup' =>  'Signup',
'apply' =>  'Apply Options',

// generic information
'delete_msg' =>  'NOTICE: Deletion is permanent and cannot be reversed. <br>Click the button below to continue.',
'maintenance_header' =>  'Site under maintenance',
'maintenance_message' =>  'WoW Raid Manager is currently undergoing maintenance. Please try again later.',
'disabled_header' =>  'Site Disabled Notice!',
'disabled_message' =>  'Please note, your site is disabled. Visitors can\'t use the system right now!<br>Go to <u>Configuration</u> and then uncheck <u>Disable WRM</u>',
'userclass_msg' =>  'Your user is not authorized to use WoW Raid Manager , please contact the system administrator.',
'priv_title' =>  'Insufficient priveleges',
'priv_msg' =>  'You have insufficient priveleges to view this page. If you believe this is an error, please contact the site administrator',
'remember' =>  'Remember me on this computer',
'welcome' =>  'Welcome ',

// Login Information
'login_fail_title' =>  'Login failed',
'login_fail' =>  'You have specified an invalid username or password. Please try again.',
'login_forgot_password' =>  'Forgot Your Password?',
'login_pwdreset_fail_title' =>  'Failed to Send/Reset Password',
'login_pwdreset_title' =>  'Reset Password',
'login_password_reset_msg' =>  'To Reset Your Password Please Enter the Following Information',
'login_username_email_incorrect' =>  'The Entered Username and/or Email Address is Incorrect.<br><br>Please Click the Back Button and Try Again.',
'login_password_sent' =>  'Your WRM password has been reset and the new password has been sent to:<br><br>',
'login_password_sent2' =>  '<br><br>Please check the E-Mail address listed above for a message from this system. ' .
									'If you do not see the message please check your spam folder and/or turn off ' .
									'your spam filter and use the "Forgot My Password" link again.',
'login_password_email_msg' =>  'THIS MESSAGE IS NOT SPAM!<br><br>Someone (hopefully you) has clicked the ' .
										'"Forgot My Password" link on a WRM installation and entered an account with ' .
										'your e-mail address.  Your WRM Password has been reset by the WRM system.  The ' .
										'new password is:<br><br>',
'login_password_email_msg2' =>  '<br><br>Please login to the WRM system using the above supplied password and click the ' .
										 '"Click to Change Password" link under the Log Out button to reset your password ' .
										 'to something more memorable.<br><br>If you were NOT the one to click this link please ' .
										 'contact your WRM administrator to inform them that the reset link is being abused.<br><br>' .
										 'You will still need to use the new password supplied above to access your WRM account.',
'login_password_email_sub' =>  'WRM Password Reset Notification',										 
'login_chpass_text' =>  'Change Password For User: ',
'login_chpwd' =>  'Click to Change Password',
'login_curr_password' =>  'Current Password',
'login_password_conf' =>  'Confirm Password',
'login_password_incorrect' =>  'Either the current password for the listed username is incorrect or the new password and ' .
										'confirm password do not match.<br><br>Please Click the Back Button and Try Again.',
'login_password_new' =>  'New Password',
'login_pwdreset_success' =>  'Your password HAS BEEN correctly reset.<br><br>You will need to use the new password the next time you login.',

// Days of the Week
'sunday' =>  'Sunday',
'monday' =>  'Monday',
'tuesday' =>  'Tuesday',
'wednesday' =>  'Wednesday',
'thursday' =>  'Thursday',
'friday' =>  'Friday',
'saturday' =>  'Saturday',
'2ltrsunday' =>  'Su',
'2ltrmonday' =>  'Mo',
'2ltrtuesday' =>  'Tu',
'2ltrwednesday' =>  'We',
'2ltrthursday' =>  'Th',
'2ltrfriday' =>  'Fr',
'2ltrsaturday' =>  'Sa',

// Months
'month' =>  'Month',
'year' =>  'Year',
'month1' =>  'January',
'month2' =>  'February',
'month3' =>  'March',
'month4' =>  'April',
'month5' =>  'May',
'month6' =>  'June',
'month7' =>  'July',
'month8' =>  'August',
'month9' =>  'September',
'month10' =>  'October',
'month11' =>  'November',
'month12' =>  'December',
							
// links
'announcements_link' =>  '&raquo; Announcements',
'configuration_link' =>  '&raquo; Configuration',
'guilds_link' =>  '&raquo; Guilds',
'home_link' =>  '&raquo; Main Page',
'calendar_link' =>  '&raquo; Calendar View',
'locations_link' =>  '&raquo; Locations',
'permissions_link' =>  '&raquo; Permissions',
'profile_link' =>  '&raquo; Profile',
'raids_link' =>  '&raquo; Raids',
'register_link' =>  '&raquo; Register',
'roster_link' =>  '&raquo; Roster',
'users_link' =>  '&raquo; Users',
'lua_output_link' =>  '&raquo; Lua Output Raids',
'index_link' =>  '&raquo; Home',
'dkp_link' =>  '&raquo; DKP',
'bosstrack_link' =>  '&raquo; Boss Kill Tracking',
'raidsarchive_link' =>  '&raquo; Raids Archive',

// sorting information
'sort_text' =>  'Click here to sort by ',
'sort_desc' => 'Click here to sort (in descending order) by ',
'sort_asc' => 'Click here to sort (in ascending order) by ', 

// tooltips
'add' =>  'Add',
'announcements' =>  'Announcements',
'calendar' =>  'Calendar',
'cancel' =>  'Cancel signup',
'cancel_msg' =>  'You have cancelled your signup for this raid',
'comments' =>  'Comments',
'configuration' =>  'Configuration',
'delete' =>  'Delete',
'description' =>  'Description',
'edit' =>  'Edit',
'edit_comment' =>  'Edit Comment',
'frozen_msg' =>  'This raid is frozen. Signups are disabled.',
'group_name' =>  'Group Name',
'group_description' =>  'Group Description',
'guilds' =>  'Guilds',
'has_permission' =>  'Has Permission',
'in_queue' =>  'Place user in queue',
'last_login_date' =>  'Last Login Date',
'last_login_time' =>  'Last Login Time',
'locations' =>  'Locations',
'logs' =>  'Logs',
'lua' =>  'LUA and macro output',
'mark' =>  'Mark raid as old',
'new' =>  'Mark raid as new',
'not_signed_up' =>  'Click here to signup for this raid',
'out_queue' =>  'Place user in signups',
'permissions' =>  'Permissions',
'priv' =>  'Privileges',
'profile' =>  'Profile',
'raids' =>  'Raids',
'remove_group' =>  'Remove group from set',
'remove_user' =>  'Remove user from set',
'signed_up' =>  'You are signed up for this raid',
'signup_add' =>  'Add user to signups',
'signup_delete' =>  'Remove user from signups (permanent)',
'users' =>  'Users',

));
?>