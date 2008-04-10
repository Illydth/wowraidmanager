<?php
/***************************************************************************
*                               lang_main.php
*								   ENGLISH
*                            -------------------
*   begin                : Saturday, Jan 16, 2005
*   copyright            : (C) 2005 Kyle Spraggs
*   email                : spiffyjr@gmail.com
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
global $phprlang;

// logging language file
require_once('lang_log.php');

// page specific language file
require_once('lang_pages.php');

// world of warcraft language file
require_once('lang_wow.php');

// data output headers
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
$phprlang['message'] = 'Message';
$phprlang['min_lvl'] = 'Min Lvl';
$phprlang['name'] = 'Name';
$phprlang['officer'] = 'Officer';
$phprlang['no_data'] = 'Empty';
$phprlang['posted_by'] = 'Posted By';
$phprlang['race'] = 'Race';
$phprlang['start_time'] = 'Start Time';
$phprlang['time'] = 'Time';
$phprlang['title'] = 'Title';
$phprlang['totals'] = 'Totals';
$phprlang['username'] = 'Username';

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
									with this message <br>on the <a href="http://www.spiffyjr.com/forums/">SpiffyJr.com Forums</a> and
									we will do our best to get it corrected. Thanks!';
$phprlang['print_error_page'] = 'Page';
$phprlang['print_error_query'] = 'Query';
$phprlang['print_error_title'] = 'Uh oh! You hit a boo boo';
$phprlang['socket_functions_disabled'] = 'Update checked failed to connect to server.';

// forms
$phprlang['asc'] = 'ascending';
$phprlang['auth_phpbb_no_groups'] = 'No groups available to add';
$phprlang['confirm_deletion'] = 'Confirm Deletion';
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
$phprlang['profile_error_shadow'] = 'Shadow must be numeric';
$phprlang['raid_error_date'] = 'You must input a proper date';
$phprlang['raid_error_description'] = 'Description must be entered';
$phprlang['raid_error_limits'] = 'All raid limits must be entered and numeric';
$phprlang['raid_error_location'] = 'Input a raid location';
$phprlang['reset'] = 'Reset';
$phprlang['view_error_signed_up'] = 'You have already signed up with this character';
$phprlang['yes'] = 'Yes';

// generic information
$phprlang['delete_header'] = 'Confirm Deletion';
$phprlang['delete_msg'] = 'NOTICE: Deletion is permanent and cannot be reversed. <br>Click the button below to continue.';
$phprlang['disable_header'] = 'Site under maintenance';
$phprlang['disable_message'] = 'phpRaid is currently undergoing maintenance. Please try again later.';
$phprlang['login_title'] = 'Login failed';
$phprlang['login_msg'] = 'You have specified an invalid username or password. Please try again.';
$phprlang['priv_title'] = 'Insufficient priveleges';
$phprlang['priv_msg'] = 'You have insufficient priveleges to view this page. If you believe this is an error, please contact the site administrator';
$phprlang['remember'] = 'Remember me on this computer';
$phprlang['welcome'] = 'Welcome ';
									
// links
$phprlang['announcements_link'] = '&raquo; Announcements';
$phprlang['configuration_link'] = '&raquo; Configuration';
$phprlang['guilds_link'] = '&raquo; Guilds';
$phprlang['home_link'] = '&raquo; Main Page';
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

// sorting information
$phprlang['sort_text'] = 'Click here to sort by ';

// tooltips
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