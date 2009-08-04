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

// world of warcraft language file
require_once('lang_wow.php');

// admin section language file
require_once('lang_admin.php');

// data output headers (Reports.php)
$phprlang['add_team']='Check to Add To Team';
$phprlang['add_team_dropdown_text']='Select Team to Add Members To';
$phprlang['team_global']='Mark Group Available to All Raids';
$phprlang['male'] = 'Male';
$phprlang['female'] = 'Female';
$phprlang['class'] = 'Class';
$phprlang['date'] = 'Date';
$phprlang['description'] = 'Description';
$phprlang['email'] = 'E-mail';
$phprlang['guild'] = 'Guild';
$phprlang['guild_name'] = 'Guild Name';
$phprlang['guild_master'] = 'Guildmaster';
$phprlang['guild_tag'] = 'Guild Tag';
$phprlang['guild_description'] = 'Guild Description';
$phprlang['guild_server'] = 'Guild Server';
$phprlang['guild_faction'] = 'Guild Faction';
$phprlang['guild_armory_link'] = 'Armory Link';
$phprlang['guild_armory_code'] = 'Armory Code';
$phprlang['id'] = 'ID';
$phprlang['invite_time'] = 'Invite Time';
$phprlang['level'] = 'Level';
$phprlang['location'] = 'Dungeon';
$phprlang['max_lvl'] = 'Max Lvl';
$phprlang['max_raiders'] = 'Raid Max';
$phprlang['locked_header'] = 'Locked?';
$phprlang['message'] = 'Message';
$phprlang['min_lvl'] = 'Min Lvl';
$phprlang['name'] = 'Name';
$phprlang['officer'] = 'Creator';
$phprlang['no_data'] = 'Empty';
$phprlang['posted_by'] = 'Posted By';
$phprlang['race'] = 'Race';
$phprlang['start_time'] = 'Start Time';
$phprlang['team_name'] = 'Team Name';
$phprlang['time'] = 'Time';
$phprlang['title'] = 'Title';
$phprlang['totals'] = 'Totals';
$phprlang['username'] = 'Username';
$phprlang['records'] = 'Record(s)';
$phprlang['to'] = 'to';
$phprlang['of'] = 'of';
$phprlang['total'] = 'total';
$phprlang['section'] = 'Section';
$phprlang['prev'] = 'Prev';
$phprlang['next'] = 'Next';
$phprlang['earned'] = 'Earned';
$phprlang['spent'] = 'Spent';
$phprlang['adjustment'] = 'Adjustment';
$phprlang['dkp'] = 'DKP';
$phprlang['buttons'] = 'Buttons';
$phprlang['add_to_team'] = 'Add To Team';
$phprlang['create_date'] = 'Create Date';
$phprlang['create_time'] = 'Create Time';
$phprlang['pri_spec'] = 'Pri Talent';
$phprlang['sec_spec'] = 'Sec Talent';
$phprlang['signup_spec'] = 'Draft As';
$phprlang['role_id'] = 'Role ID';
$phprlang['role_name'] = 'Role Name';
$phprlang['role_config'] = 'Role Config Text';
$phprlang['role_image'] = 'Role Image';
$phprlang['talent_tree'] = 'Talent Tree';
$phprlang['display_text'] = 'Display Text';
$phprlang['perm_mod'] = 'Update Permissions';

// roles
$phprlang['role_none'] = '-';

// errors
$phprlang['connect_socked_error'] = 'Failed to connect to socket with error %s';
$phprlang['invalid_group_title'] = 'Group exists';
$phprlang['invalid_group_message'] = 'The group selected is already part of this set. Press your browsers BACK button to try again.';
$phprlang['invalid_option_title'] = 'Invalid input for page';
$phprlang['invalid_option_msg'] = 'You have tried to access this page using invalid input.';
$phprlang['no_user_msg'] = 'The user you are trying to view does not exist or has been deleted.';
$phprlang['no_user_title'] = 'User does not exist';
$phprlang['print_error_critical'] = 'a critical error!';
$phprlang['print_error_details'] = 'Details';
$phprlang['print_error_minor'] = 'a minor error!';
$phprlang['print_error_msg_begin'] = 'Sorry, phpRaid has encountered ';
$phprlang['print_error_msg_end'] = 'If this error persists, please make a post 
									with this message <br>on the <a href="http://www.wowraidmanager.net/">wowraidmanager.net Forums</a> and
									we will do our best to get it corrected. Thanks!';
$phprlang['print_error_page'] = 'Page';
$phprlang['print_error_query'] = 'Query';
$phprlang['print_error_title'] = 'Uh oh! You hit a boo boo';
$phprlang['socket_functions_disabled'] = 'Update checked failed to connect to server.';

// forms
$phprlang['asc'] = 'ascending';
$phprlang['auth_phpbb_no_groups'] = 'No groups available to add';
$phprlang['desc'] = 'descending';
$phprlang['form_error'] = 'Error with your form submission';
$phprlang['form_select'] = 'Select One';
$phprlang['no'] = 'No';
$phprlang['none'] = 'None';
$phprlang['guild_name_missing'] = 'The Full Guild Name is missing.';
$phprlang['guild_tag_missing'] = 'The Guild Tag is missing.';
$phprlang['permissions_form_description'] = 'You must input a description';
$phprlang['permissions_form_name'] = 'You must input a name';
$phprlang['profile_error_arcane'] = 'Arcane must be numeric';
$phprlang['profile_error_class'] = 'You must selet a class';
$phprlang['profile_error_dupe'] = 'A character with that name already exists';
$phprlang['profile_error_fire'] = 'Fire must be numeric';
$phprlang['profile_error_frost'] = 'Frost must be numeric';
$phprlang['profile_error_guild'] = 'You must select a guild';
$phprlang['profile_error_level'] = 'Level must be numeric from 1-80';
$phprlang['profile_error_name'] = 'You must enter a name';
$phprlang['profile_error_nature'] = 'Nature must be numeric';
$phprlang['profile_error_race'] = 'You must select a race';
$phprlang['profile_error_role'] = 'You must enter a role';
$phprlang['profile_error_shadow'] = 'Shadow must be numeric';
$phprlang['raid_error_date'] = 'You must input a proper date';
$phprlang['raid_error_description'] = 'Description must be entered';
$phprlang['raid_error_limits'] = 'All raid limits must be entered and numeric';
$phprlang['raid_error_location'] = 'Input a raid location';
$phprlang['view_error_signed_up'] = 'You have already signed up with this character';
$phprlang['view_error_role_undef'] = 'Make sure that the Character in <a href="profile.php?mode=view">Profile</a> has a defined Role.';
$phprlang['yes'] = 'Yes';
$phprlang['teams_error_no_team'] = 'No team is selected to add users to.';

// Buttons
$phprlang['submit'] = 'Submit';
$phprlang['reset'] = 'Reset';
$phprlang['confirm'] = 'Confirm';
$phprlang['update'] = 'Update';
$phprlang['confirm_deletion'] = 'Confirm Deletion';
$phprlang['filter'] = 'Filter';
$phprlang['addchar'] = 'Add Character';
$phprlang['updatechar'] = 'Update Character';
$phprlang['login'] = 'Log In';
$phprlang['logout'] = 'Log Out';
$phprlang['signup'] = 'Signup';


// generic information
$phprlang['delete_msg'] = 'NOTICE: Deletion is permanent and cannot be reversed. <br>Click the button below to continue.';
$phprlang['maintenance_header'] = 'Site under maintenance';
$phprlang['maintenance_message'] = 'WoW Raid Manager is currently undergoing maintenance. Please try again later.';
$phprlang['disabled_header'] = 'Site Disabled Notice!';
$phprlang['disabled_message'] = 'Please note, your site is disabled. Visitors can\'t use the system right now!<br>Go to <u>Configuration</u> and then uncheck <u>Disable phpRaid</u>';
$phprlang['userclass_msg'] = 'Your user is not authorized to use WoW Raid Manager , please contact the system administrator.';
$phprlang['priv_title'] = 'Insufficient priveleges';
$phprlang['priv_msg'] = 'You have insufficient priveleges to view this page. If you believe this is an error, please contact the site administrator';
$phprlang['remember'] = 'Remember me on this computer';
$phprlang['welcome'] = 'Welcome ';

// Login Information
$phprlang['login_fail_title'] = 'Login failed';
$phprlang['login_fail'] = 'You have specified an invalid username or password. Please try again.';
$phprlang['login_forgot_password'] = 'Forgot Your Password?';
$phprlang['login_pwdreset_fail_title'] = 'Failed to Send/Reset Password';
$phprlang['login_pwdreset_title'] = 'Reset Password';
$phprlang['login_password_reset_msg']= 'To Reset Your Password Please Enter the Following Information';
$phprlang['login_username_email_incorrect'] = 'The Entered Username and/or Email Address is Incorrect.<br><br>Please Click the Back Button and Try Again.';
$phprlang['login_password_sent'] = 'Your WRM password has been reset and the new password has been sent to:<br><br>';
$phprlang['login_password_sent2'] = '<br><br>Please check the E-Mail address listed above for a message from this system. ' .
									'If you do not see the message please check your spam folder and/or turn off ' .
									'your spam filter and use the "Forgot My Password" link again.';
$phprlang['login_password_email_msg'] = 'THIS MESSAGE IS NOT SPAM!<br><br>Someone (hopefully you) has clicked the ' .
										'"Forgot My Password" link on a WRM installation and entered an account with ' .
										'your e-mail address.  Your WRM Password has been reset by the WRM system.  The ' .
										'new password is:<br><br>';
$phprlang['login_password_email_msg2'] = '<br><br>Please login to the WRM system using the above supplied password and click the ' .
										 '"Click to Change Password" link under the Log Out button to reset your password ' .
										 'to something more memorable.<br><br>If you were NOT the one to click this link please ' .
										 'contact your WRM administrator to inform them that the reset link is being abused.<br><br>' .
										 'You will still need to use the new password supplied above to access your WRM account.';
$phprlang['login_password_email_sub'] = 'WRM Password Reset Notification'.										 
$phprlang['login_chpass_text'] = 'Change Password For User: ';
$phprlang['login_chpwd'] = 'Click to Change Password';
$phprlang['login_curr_password'] = 'Current Password';
$phprlang['login_password_conf'] = 'Confirm Password';
$phprlang['login_password_incorrect'] = 'Either the current password for the listed username is incorrect or the new password and ' .
										'confirm password do not match.<br><br>Please Click the Back Button and Try Again.';
$phprlang['login_password_new'] = 'New Password';
$phprlang['login_pwdreset_success'] = 'Your password HAS BEEN correctly reset.<br><br>You will need to use the new password the next time you login.';

// Days of the Week
$phprlang['sunday'] = 'Sunday';
$phprlang['monday'] = 'Monday';
$phprlang['tuesday'] = 'Tuesday';
$phprlang['wednesday'] = 'Wednesday';
$phprlang['thursday'] = 'Thursday';
$phprlang['friday'] = 'Friday';
$phprlang['saturday'] = 'Saturday';
$phprlang['2ltrsunday'] = 'Su';
$phprlang['2ltrmonday'] = 'Mo';
$phprlang['2ltrtuesday'] = 'Tu';
$phprlang['2ltrwednesday'] = 'We';
$phprlang['2ltrthursday'] = 'Th';
$phprlang['2ltrfriday'] = 'Fr';
$phprlang['2ltrsaturday'] = 'Sa';

// Months
$phprlang['month'] = 'Month';
$phprlang['year'] = 'Year';
$phprlang['month1'] = 'January';
$phprlang['month2'] = 'February';
$phprlang['month3'] = 'March';
$phprlang['month4'] = 'April';
$phprlang['month5'] = 'May';
$phprlang['month6'] = 'June';
$phprlang['month7'] = 'July';
$phprlang['month8'] = 'August';
$phprlang['month9'] = 'September';
$phprlang['month10'] = 'October';
$phprlang['month11'] = 'November';
$phprlang['month12'] = 'December';
							
// links
$phprlang['announcements_link'] = '&raquo; Announcements';
$phprlang['configuration_link'] = '&raquo; Configuration';
$phprlang['guilds_link'] = '&raquo; Guilds';
$phprlang['home_link'] = '&raquo; Main Page';
$phprlang['calendar_link'] = '&raquo; Calendar View';
$phprlang['locations_link'] = '&raquo; Locations';
$phprlang['permissions_link'] = '&raquo; Permissions';
$phprlang['profile_link'] = '&raquo; Profile';
$phprlang['raids_link'] = '&raquo; Raids';
$phprlang['register_link'] = '&raquo; Register';
$phprlang['roster_link'] = '&raquo; Roster';
$phprlang['users_link'] = '&raquo; Users';
$phprlang['lua_output_link'] = '&raquo; Lua Output Raids';
$phprlang['index_link'] = '&raquo; Home';
$phprlang['dkp_link'] = '&raquo; DKP';
$phprlang['bosstrack_link'] = '&raquo; Boss Kill Tracking';

// sorting information
$phprlang['sort_text'] = 'Click here to sort by ';
$phprlang['sort_desc']='Click here to sort (in descending order) by ';
$phprlang['sort_asc']='Click here to sort (in ascending order) by '; 

// tooltips
$phprlang['add'] = 'Add';
$phprlang['announcements'] = 'Announcements';
$phprlang['arcane'] = 'Arcane';
$phprlang['calendar'] = 'Calendar';
$phprlang['cancel'] = 'Cancel signup';
$phprlang['cancel_msg'] = 'You have cancelled your signup for this raid';
$phprlang['comments'] = 'Comments';
$phprlang['configuration'] = 'Configuration';
$phprlang['deathknight_icon'] = 'Click to see Death Knights';
$phprlang['delete'] = 'Delete';
$phprlang['description'] = 'Description';
$phprlang['druid_icon'] = 'Click to see druids';
$phprlang['edit'] = 'Edit';
$phprlang['edit_comment'] = 'Edit Comment';
$phprlang['fire'] = 'Fire';
$phprlang['frost'] = 'Frost';
$phprlang['frozen_msg'] = 'This raid is frozen. Signups are disabled.';
$phprlang['group_name'] = 'Group Name';
$phprlang['group_description'] = 'Group Description';
$phprlang['guilds'] = 'Guilds';
$phprlang['has_permission'] = 'Has Permission';
$phprlang['hunter_icon'] = 'Click to see hunters';
$phprlang['in_queue'] = 'Place user in queue';
$phprlang['last_login_date'] = 'Last Login Date';
$phprlang['last_login_time'] = 'Last Login Time';
$phprlang['locations'] = 'Locations';
$phprlang['logs'] = 'Logs';
$phprlang['lua'] = 'LUA and macro output';
$phprlang['mage_icon'] = 'Click to see mages';
$phprlang['mark'] = 'Mark raid as old';
$phprlang['nature'] = 'Nature';
$phprlang['new'] = 'Mark raid as new';
$phprlang['not_signed_up'] = 'Click here to signup for this raid';
$phprlang['out_queue'] = 'Place user in signups';
$phprlang['paladin_icon'] = 'Click to see paladins';
$phprlang['permissions'] = 'Permissions';
$phprlang['priest_icon'] = 'Click to see priests';
$phprlang['priv'] = 'Privileges';
$phprlang['profile'] = 'Profile';
$phprlang['raids'] = 'Raids';
$phprlang['remove_group'] = 'Remove group from set';
$phprlang['remove_user'] = 'Remove user from set';
$phprlang['rogue_icon'] = 'Click to see rogues';
$phprlang['shadow'] = 'Shadow';
$phprlang['shaman_icon'] = 'Click to see shamans';
$phprlang['signed_up'] = 'You are signed up for this raid';
$phprlang['signup_add'] = 'Add user to signups';
$phprlang['signup_delete'] = 'Remove user from signups (permanent)';
$phprlang['users'] = 'Users';
$phprlang['warlock_icon'] = 'Click to see warlocks';
$phprlang['warrior_icon'] = 'Click to see warriors';

?>