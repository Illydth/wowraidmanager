<?php
/***************************************************************************
 *                          lang_pages.php (English)
 *                            -------------------
 *   begin                : Saturday, Jan 16, 2005
 *   copyright            : (C) 2007-2008 Douglas Wagner
 *   email                : douglasw@wagnerweb.org
 *
 *   $Id: lang_pages.php,v 2.00 2008/03/07 13:49:54 psotfx Exp $
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
if (empty($phprlang) || !is_array($phprlang))
	$phprlang = array();
	
$phprlang = array_merge($phprlang, array(

// announcements
'announcements_header' =>  'Announcements',
'announcements_new_header' =>  'Create New Announcement',
'announcements_message_text' =>  'Message',
'announcements_title_text' =>  'Title',

// Calendar
'invites' =>  'Invites',
'start' =>  'Start',
'key' =>  'Key:<br>White Border = Not Signed Up<br>Green Border = Signed Up & Drafted<br>Blue Border = Signed Up, Not Drafted (queued)<br>Red Border = Signup Cancelled<br><span class="priorDay">TEXT</span> dates are in the past.<br><span class="currentDay">TEXT</span> date is today.<br><span class="postDay">TEXT</span> dates are in the future.',
'calendar_month_select_header' =>  'Select Month and Year to View',

// DKP View
'eqdkp_system_link' =>  'Direct link to Associated DKP System:',

// guilds
'guilds_header' =>  'Guild Listing',
'guilds_new_header' =>  'New Guild',
'guilds_master' =>  'Guildmaster',
'guilds_name' =>  'Full guild name',
'guilds_tag'	=> 'Guild tag',
'guilds_description' =>  'Guild Description',
'guilds_server' =>  'Guild Server',
'guilds_faction' =>  'Guild Faction',
'guilds_armory_code' =>  'Armory Code for Guild',
'raid_force_header' =>  'Raid Force Listing',
'raid_force_select_text' =>  'Select Raid Force: ',
'raid_force_name_box_text' =>  'Raid Force Name',
'raid_force_guild_options_text' =>  'Guild',
'raid_force_new_header' =>  'New Raid Force Link',
'raid_force_name_missing' =>  'Raid Force Name must not be blank or NULL.',
'raid_force_duplicate' =>  'Duplicate Raid Force Name/Guild Record.',
'raid_force_guild_id_missing' =>  'Guild ID must not be blank or NULL',
'armory_lang_US' =>  'US : http://us.battle.net/wow/ : English',
'armory_lang_EU' =>  'EU : http://eu.battle.net/wow/ : English',
'armory_lang_DE' =>  'DE : http://eu.battle.net/wow/ : German',
'armory_lang_ES' =>  'ES : http://eu.battle.net/wow/ : Spanish',
'armory_lang_FR' =>  'FR : http://eu.battle.net/wow/ : French',
'armory_lang_KR' =>  'KR : http://kr.battle.net/wow/ : Korean',
'armory_lang_TW' =>  'TW : http://tw.battle.net/wow/ : Taiwainese',
'armory_lang_none' =>  'No Armory or Not Applicable',

// locations
'locations_header' =>  'Saved Locations',
'locations_max_lvl' =>  'Maximum Level',
'locations_min_lvl' =>  'Minimum Level',
'locations_limits_header' =>  'Raid limitations',
'locations_long' =>  'Raid dungeon',
'locations_new' =>  'Create a new location',
'locations_raid_max' =>  'Raid Max',
'locations_short' =>  'Identifier',
'lock_template' =>  'Locked Raid Template?',
'locations_ro_text' =>  'Read Only: Populated With WoW Official Name for Instance',
'locations_expansion_text' =>  'Expansion',
'locations_events_text' =>  'Event Name',

// lua_output
'rim_download' =>  'Download RIM (Raid Information Manager)',
'phprv_download' =>  'Download phpRaidViewer',
'lua_header' =>  'LUA/Macro Output',
'sort_name' =>  'Name',
'sort_date' =>  'Date',
'output_rim' =>  'RIM (Raid Invite Manager)',
'output_phprv' =>  'PHP Raid Viewer',
'sort_signups_text' =>  'Sort Signups By:',
'sort_queue_text' =>  'Sort Queue By:',
'output_format_text' =>  'Output Format:',
'options_header' =>  'Options',
'lua_output_header' =>  'Beginning LUA Output',
'lua_show_all_raids' =>  'Output all Open Raids',
'lua_failed_to_write' =>  'LUA file could not be created due to failure to write.</b><br/>' .
									'Please set logging level to display warnings (E_WARNING or better) ' .
									'to see the issue.<br>' .
									'Use this for copy+paste:<br>',
'lua_rim_write_success' =>  '<b>LUA file created.</b><br>' . 
									'Download <a href="cache/raid_lua/phpRaid_Data.lua">phpRaid_Data.lua</a> and save 
									it to [wow-dir]\interface\addons\RIM\<br>' .
									'or use this for copy+paste:<br>',
'lua_prv_write_success' =>  '<b>LUA file created.</b><br>' . 
									'Download <a href="cache/raid_lua/phpRaid_Data.lua">phpRaid_Data.lua</a> and save 
									it to [wow-dir]\interface\addons\phpraidviewer\<br>' .
									'or use this for copy+paste:<br>',
'lua_drafted' =>  'Drafted Users',
'lua_queued' =>  'Queued Users',
'lua_macro_header' =>  'Macro output listing...',
'lua_macro_footer' =>  '<br>Macro output listing complete.<br>Copy and paste the above to a macro and run in-game.',

// permissions
'permissions_add' =>  'Add to set',
'permissions_announcements' =>  'Announcements',
'permissions_configuration' =>  'Configuration',
'permissions_details_users_header' =>  'Detailed Permissions',
'permissions_edit_header' =>  'Edit set',
'permissions_description' =>  'Description',
'permissions_details_header' =>  'Permission Details',
'permissions_guilds' =>  'Guilds',
'permissions_header' =>  'Permission Sets',
'permissions_locations' =>  'Locations',
'permissions_logs' =>  'Logs',
'permissions_name' =>  'Name',
'permissions_permissions' =>  'Permissions',
'permissions_profile' =>  'Profile',
'permissions_raids' =>  'Raids',
'permissions_new' =>  'Create a new set',
'permissions_users' =>  'Users',
'permissions_users_header' =>  'Users in set',

// profile
'profile_arcane' =>  'Arcane Resistance',
'profile_class' =>  'Class',
'profile_create_header' =>  'Character creation unavailable',
'profile_create_msg' =>  'Until an admin creates a guild character creation will be unavailable',
'profile_fire' =>  'Fire Resistance',
'profile_frost' =>  'Frost Resistance',
'profile_gender' =>  'Gender',
'profile_guild' =>  'Guild affiliation',
'profile_role' =>  'Role',
'profile_header' =>  'Characters',
'profile_level' =>  'Level',
'profile_name' =>  'Name',
'profile_nature' =>  'Nature Resistance',
'profile_raid' =>  'Raid Participation',
'profile_race' =>  'Race',
'profile_shadow' =>  'Shadow Resistance',
'iLvL' =>  "iLvL (Equipped, Best)",
'health' =>  "Health",
'mana' =>  "Mana",

// raids
'raids_date' =>  'Date',
'raids_description' =>  'Description',
'raids_dungeon' =>  'Dungeon',
'raids_freeze' =>  'Freeze limit (in hours)',
'raids_invite' =>  'Invite time',
'raids_limits' =>  'Raid limits',
'raids_location' =>  'Stored location',
'raids_max' =>  'Raid maximum',
'raids_max_lvl' =>  'Maximum level',
'raids_min_lvl' =>  'Minimum level',
'raids_old' =>  'Previous events',
'raids_new' =>  'Upcoming events',
'raids_new_header' =>  'New Raid',
'raids_edit_header' =>  'Edit Raid',
'raids_start' =>  'Start time',
'raids_eventtype_text' =>  'Event Type',
'raids_mark_selected_raids_to_old' =>  "all mark raids are closed and over",

// event type
'event_type_raid' =>  'Raid (10/25 man)',
'event_type_dungeon' =>  'Dungeon (5 man Instance)',
'event_type_pvp' =>  'PvP Event',
'event_type_meeting' =>  'Meeting (online/offline)',
'event_type_other' =>  'Other',

// expansions
'exp_generic_wow' =>  'Generic World of Warcraft',
'exp_burning_crusade' =>  'The Burning Crusade',
'exp_wrath_lich_king' =>  'Wrath of the Lich King',
'exp_cataclysm' =>  'Cataclysm',

// roster
'roster_header' =>  'Guild Roster',

// registration
'register_complete_header' =>  'Registration success',
'register_complete_msg' =>  'You are now registered for WRM Use.  On some sites you may now create your profile and characters, on others you will need to wait for permissions to be set by the system administrator.',
'register_confirm' =>  'Your passwords do not match.',
'register_confirm_text' =>  'Enter password again',
'register_email_header' =>  'Registration at',
'register_email_empty' =>  'You must enter an email address',
'register_email_exists' =>  'That e-mail address is already in use',
'register_email_greeting' =>  'Welcome',
'register_email_subject' =>  'This email is to confirm your registration. Do not reply as no one will receive your response.',
'register_email_text' =>  'E-mail address',
'register_error' =>  'Registration error',
'register_header' =>  'User Registration',
'register_pass_empty' =>  'You must enter a password',
'register_password_text' =>  'Password',
'register_user_empty' =>  'You must enter a user name',
'register_user_exists' =>  'That username is already in use',
'register_username_text' =>  'Username',

// users
'users_assign' =>  'Assign',
'users_char_header' =>  'User characters',
'users_header' =>  'Users',

// view
'view_approved' =>  'Approved members',
'view_cancel_header' =>  'Cancelled signups',
'view_character' =>  'Character',
'view_comments' =>  'Comments',
'view_create' =>  'Create a character to signup',
'view_date' =>  'Date',
'view_description_header' =>  'Raid description',
'view_frozen' =>  'Signups are frozen',
'view_information_header' =>  'Information',
'view_invite' =>  'Invite time',
'view_location' =>  'Dungeon',
'view_login' =>  'Log in to signup',
'view_new' =>  'Signup for this raid',
'view_max' =>  'Raid max',
'view_max_lvl' =>  'Maximum level',
'view_min_lvl' =>  'Minimum level',
'view_missing_signups_link_text' =>  'View Profles who have NOT signed up for this raid.',
'view_officer' =>  'Creator',
'view_ok' =>  'Open for signups',
'view_queue' =>  'How do you want to signup?',
'view_queue_header' =>  'Queued signups',
'view_queued' =>  'Queued members',
'view_raid_cancel_text' =>  'Cancelled signups',
'view_signed' =>  'Already signed up',
'view_signup' =>  'Signup information',
'view_signup_queue' =>  'Signup as Queued',
'view_signup_cancel' =>  'Signup as Cancelled',
'view_signup_draft' =>  'Signup as In Raid (Drafted)',
'view_start' =>  'Start time',
'view_statistics_header' =>  'Statistics',
'view_teams_link_text' =>  'Create and Assign Teams for This Raid',
'view_total' =>  'Total signups',
'view_username' =>  'Username',
'view_missing_signups_return_to_view' =>  'Back to Raid View',

// main page
'main_previous_raids' =>  'Previous events',
'main_upcoming_raids' =>  'Upcoming events',
'signup' =>  'Sign Up',
'rss_feed_text' =>  'Raid Signups RSS Feed',
'guild_time_string' =>  'Guild Time',
'menu_header_text' =>  'WRM Menu',

// teams
'team_new_header' =>  'Create New Team',
'team_add_header' =>  'Add Members to Team',
'team_remove_header' =>  'Remove Members from Team',
'teams_raid_view_text' =>  'Return to Raid View',
'team_cur_teams_header' =>  'Created Teams',
'team_page_header' =>  'Teams',

// Boss Kill Tracking
'boss_kill_type_dungeon' =>  'Dungeon (5/10 Man)',
'boss_kill_type_25_man' =>  '25 Man Raid',
'boss_kill_type_10_man' =>  '10 Man Raid',
'boss_kill_type_40_man' =>  '40 Man Raid',
'bosskill_header' =>  'Track Named (Boss) Accomplishments',

//Raids Archive
'raidsarchive_header' =>  'Raids Archive',


));
?>