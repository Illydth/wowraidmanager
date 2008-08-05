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

// data output headers (Reports.php)
$phprlang['add_team']='Check to Add To Team';
$phprlang['add_team_dropdown_text']='Select Team to Add Members To';
$phprlang['team_global']='Mark Group Available to All Raids';
$phprlang['sort_desc']='Click here to sort (in descending order) by ';
$phprlang['sort_asc']='Click here to sort (in ascending order) by '; 
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

// roles
$phprlang['role'] = 'Role';
$phprlang['role_none'] = '-';
$phprlang['role_tank'] = 'Tank';
$phprlang['role_heal'] = 'Healer';
$phprlang['role_melee'] = 'Melee';
$phprlang['role_ranged'] = 'Ranged';
$phprlang['role_tankmelee'] = 'Tank or Melee';

$phprlang['role_tanks'] = 'Tanks';
$phprlang['role_heals'] = 'Healers';
$phprlang['role_melees'] = 'Melee';
$phprlang['role_ranges'] = 'Ranged';
$phprlang['role_tankmelees'] = 'Tanks/Melee';

$phprlang['max_tanks'] = 'Max Tanks';
$phprlang['max_heals'] = 'Max Healers';
$phprlang['max_melees'] = 'Max Melee';
$phprlang['max_ranged'] = 'Max Ranged';
$phprlang['max_tkmels'] = 'Max Tank/Melee';

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
$phprlang['permissions_form_description'] = 'You must input a description';
$phprlang['permissions_form_name'] = 'You must input a name';
$phprlang['profile_error_arcane'] = 'Arcane must be numeric';
$phprlang['profile_error_class'] = 'You must selet a class';
$phprlang['profile_error_dupe'] = 'A character with that name already exists';
$phprlang['profile_error_fire'] = 'Fire must be numeric';
$phprlang['profile_error_frost'] = 'Frost must be numeric';
$phprlang['profile_error_guild'] = 'You must select a guild';
$phprlang['profile_error_level'] = 'Level must be numeric from 1-70';
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
$phprlang['disable_header'] = 'Site under maintenance';
$phprlang['disable_message'] = 'phpRaid is currently undergoing maintenance. Please try again later.';
$phprlang['login_title'] = 'Login failed';
$phprlang['login_msg'] = 'You have specified an invalid username or password. Please try again.';
$phprlang['userclass_msg'] = 'Your e107 user is not authorized to use phpRaid, please contact the system administrator.';
$phprlang['priv_title'] = 'Insufficient priveleges';
$phprlang['priv_msg'] = 'You have insufficient priveleges to view this page. If you believe this is an error, please contact the site administrator';
$phprlang['remember'] = 'Remember me on this computer';
$phprlang['welcome'] = 'Welcome ';

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
							
// links
$phprlang['announcements_link'] = '&raquo; Announcements';
$phprlang['configuration_link'] = '&raquo; Configuration';
$phprlang['guilds_link'] = '&raquo; Guilds';
$phprlang['home_link'] = '&raquo; Main Page';
$phprlang['calendar_link'] = '&raquo; Calendar View';
$phprlang['locations_link'] = '&raquo; Locations';
$phprlang['logs_link'] = '&raquo; Logs';
$phprlang['permissions_link'] = '&raquo; Permissions';
$phprlang['profile_link'] = '&raquo; Profile';
$phprlang['raids_link'] = '&raquo; Raids';
$phprlang['register_link'] = '&raquo; Register';
$phprlang['roster_link'] = '&raquo; Roster';
$phprlang['users_link'] = '&raquo; Users';
$phprlang['lua_output_link'] = '&raquo; Lua output raids';
$phprlang['index_link'] = '&raquo; Home';
$phprlang['dkp_link'] = '&raquo; DKP';

// sorting information
$phprlang['sort_text'] = 'Click here to sort by ';

// tooltips
$phprlang['add'] = 'Add';
$phprlang['announcements'] = 'Announcements';
$phprlang['arcane'] = 'Arcane';
$phprlang['calendar'] = 'Calendar';
$phprlang['cancel'] = 'Cancel signup';
$phprlang['cancel_msg'] = 'You have cancelled your signup for this raid';
$phprlang['comments'] = 'Comments';
$phprlang['configuration'] = 'Configuration';
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