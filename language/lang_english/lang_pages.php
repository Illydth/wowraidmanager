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
// announcements
$phprlang['announcements_header'] = 'Announcements';
$phprlang['announcements_new_header'] = 'Create New Announcement';
$phprlang['announcements_message_text'] = 'Message';
$phprlang['announcements_title_text'] = 'Title';

// Calendar
$phprlang['invites'] = 'Invites';
$phprlang['start'] = 'Start';
$phprlang['key'] = 'Key:<br>(<span class="draftedmark">*</span>) = Signed Up & Drafted<br>(<span class="qcanmark">#</span>) = Signed Up, Not Drafted (queued or cancelled)<br><span class="priorDay">TEXT</span> dates are in the past.<br><span class="currentDay">TEXT</span> date is today.<br><span class="postDay">TEXT</span> dates are in the future.';
$phprlang['calendar_month_select_header'] = 'Select Month and Year to View';

// configuration
$phprlang['configuration_addon'] = 'Addon URL';
$phprlang['configuraiton_admin'] = 'Administrator';
$phprlang['configuration_admin_email'] = 'Admin e-mail';
$phprlang['configuration_ampm'] = 'Schedule Raids in 12h/24h format';
$phprlang['configuration_anonymous'] = 'Allow anonymous viewing';
$phprlang['configuration_armory_enable'] = 'Enable Armory Lookups';
$phprlang['configuration_armory_link_text'] = 'Correct Armory Link for Server';
$phprlang['configuration_armory_language_text'] = 'Language Code for Armory';
$phprlang['configuration_autoqueue'] = 'Disallow Signup to Drafted Status';
$phprlang['configuration_cancel'] = 'Cancel';
$phprlang['configuration_cancel_def'] = 'Cancel = Place User Into Cancelled Area';
$phprlang['configuration_cancelled'] = 'Cancelled Status';
$phprlang['configuration_comments'] = 'Comments';
$phprlang['configuration_comments_def'] = 'Comments = Allow User to Edit Their Comments';
$phprlang['configuration_date'] = 'Date format<br><a href="http://www.php.net/date/" target="_blank">help?</a>';
$phprlang['configuration_description'] = 'Description';
$phprlang['configuration_debug'] = 'Debug mode';
$phprlang['configuration_default'] = 'Default Group';
$phprlang['configuration_delete'] = 'Delete';
$phprlang['configuration_delete_def'] = 'Delete = Remove User Signup Completely';
$phprlang['configuration_disable'] = 'Disable phpRaid';
$phprlang['configuration_draft_def'] = 'Draft = Place User into Attending Raid Area';
$phprlang['configuration_draft'] = 'Draft';
$phprlang['configuration_drafted'] = 'Drafted (In Raid)';
$phprlang['configuration_dst_text'] = 'Daylight saving time?';
$phprlang['configuration_email_header'] = 'E-mail configuration';
$phprlang['configuration_email_sig'] = 'E-mail signature';
$phprlang['configuration_enable_five_man'] = 'Enable groups<br><a href="docs/enable_groups.htm" target="_blank">help?</a>';
$phprlang['configuration_eqdkp_integration_text'] = 'Integrate with EqDKP<br><a href="docs/eqdkp_link.htm" target="_blank">help?</a>';
$phprlang['configuration_eqdkp_link'] = 'URL to Base of EqDKP Installation (No Trailing /)';
$phprlang['configuration_external_links_header'] = 'Integration with External Systems';
$phprlang['configuration_faction'] = 'Faction';
$phprlang['configuration_freeze'] = 'Disable freeze checking';
$phprlang['configuration_guild_header'] = 'Guild Configuration';
$phprlang['configuration_guild_name'] = 'Name';
$phprlang['configuration_id'] = 'Show id in tables';
$phprlang['configuration_language'] = 'Language';
$phprlang['configuration_logo'] = 'Path to header image';
$phprlang['configuration_multiple'] = 'Allow multiple signups';
$phprlang['configuration_on_queue'] = 'On Queue';
$phprlang['configuration_queue'] = 'Queue';
$phprlang['configuration_queue_def'] = 'Queue = Place User In Queued Area';
$phprlang['configuration_raid_settings_header'] = 'Raid Settings';
$phprlang['configuration_raid_view_type_text'] = 'Select Raid View Type';
$phprlang['configuration_raid_view_type_class'] = 'Display Raid View By Class';
$phprlang['configuration_raid_view_type_role'] = 'Display Raid View By Role';
$phprlang['configuration_raidlead'] = 'Raid Leader';
$phprlang['configuration_resop'] = 'Make resistance optional';
$phprlang['configuration_register_text'] = 'Registration URL';
$phprlang['configuration_role_header'] = 'Role Configuration';
$phprlang['configuration_role1_text'] = 'Class Role #1';
$phprlang['configuration_role2_text'] = 'Class Role #2';
$phprlang['configuration_role3_text'] = 'Class Role #3';
$phprlang['configuration_role4_text'] = 'Class Role #4';
$phprlang['configuration_role5_text'] = 'Class Role #5';
$phprlang['configuration_role6_text'] = 'Class Role #6';
$phprlang['configuration_role_limit_text'] = 'Enforce Role Limits for Raid';
$phprlang['configuration_class_limit_text'] = 'Enforce Class Limits for Raid';
$phprlang['configuration_class_as_min'] = 'Use Class Limits as Minimums';
$phprlang['configuration_roster_text'] = 'Integrate with WoW Roster';
$phprlang['configuration_rss_site'] = 'RSS: URL to phpRaid Installation (No Trailing /)';
$phprlang['configuration_rss_export'] = 'RSS: Site to export RSS feed to';
$phprlang['configuration_rss_feed_amt'] = 'RSS: Number of Raids to Show in Feed';
$phprlang['configuration_server'] = 'Server';
$phprlang['configuration_show_addon'] = 'Show addon link';
$phprlang['configuration_signup_rights_header'] = 'Signup Rights';
$phprlang['configuration_site_header'] = 'Site Configuration';
$phprlang['configuration_sitelink'] = '"Home" Link Points To';
$phprlang['configuration_template'] = 'Template';
$phprlang['configuration_time'] = 'Time format<br><a href="http://www.php.net/date/" target="_blank">help?</a>';
$phprlang['configuration_timezone_text'] = 'Timezone';
$phprlang['configuration_user'] = 'User';
$phprlang['configuration_user_rights_header'] = 'User Rights';
$phprlang['configuration_version_current'] = 'You are running the latest version of phpRaid';
$phprlang['configuration_version_info_header'] = 'Version Information';
$phprlang['configuration_version_outdated_header'] = 'WoW Raid Manager update available!';
$phprlang['configuration_version_outdated_message'] = 'Your version of WoW Raid Manager is out of date. Updating is strongly recommended.<br>
													   The latest version is %s and you are running version %s.<br>
													   To download, visit the <a href="http://www.wowraidmanager.net">WoW Raid Manager for BC download</a> section.';

// DKP View
$phprlang['eqdkp_system_link'] = 'Direct link to Associated DKP System:';

// guilds
$phprlang['guilds_header'] = 'Guild Listing';
$phprlang['guilds_new_header'] = 'New Guild';
$phprlang['guilds_master'] = 'Guildmaster';
$phprlang['guilds_name'] = 'Full guild name';
$phprlang['guilds_tag']	= 'Guild tag';						

// locations
$phprlang['locations_header'] = 'Saved Locations';
$phprlang['locations_max_lvl'] = 'Maximum Level';
$phprlang['locations_min_lvl'] = 'Minimum Level';
$phprlang['locations_limits_header'] = 'Raid limitations';
$phprlang['locations_long'] = 'Raid dungeon';
$phprlang['locations_new'] = 'Create a new location';
$phprlang['locations_raid_max'] = 'Raid Max';
$phprlang['locations_short'] = 'Identifier';
$phprlang['lock_template'] = 'Locked Raid Template?';
$phprlang['locations_ro_text'] = 'Read Only: Populated With WoW Official Name for Instance';
$phprlang['locations_expansion_text'] = 'Expansion';
$phprlang['locations_events_text'] = 'Event Name';

// lua_output
$phprlang['rim_download'] = 'Download RIM (Raid Information Manager)';
$phprlang['lua_download'] = 'Download phpRaidViewer';
$phprlang['lua_header'] = 'LUA/Macro Output';

// permissions
$phprlang['permissions_add'] = 'Add to set';
$phprlang['permissions_announcements'] = 'Announcements';
$phprlang['permissions_configuration'] = 'Configuration';
$phprlang['permissions_details_users_header'] = 'Detailed Permissions';
$phprlang['permissions_edit_header'] = 'Edit set';
$phprlang['permissions_description'] = 'Description';
$phprlang['permissions_details_header'] = 'Permission Details';
$phprlang['permissions_guilds'] = 'Guilds';
$phprlang['permissions_header'] = 'Permission Sets';
$phprlang['permissions_locations'] = 'Locations';
$phprlang['permissions_logs'] = 'Logs';
$phprlang['permissions_name'] = 'Name';
$phprlang['permissions_permissions'] = 'Permissions';
$phprlang['permissions_profile'] = 'Profile';
$phprlang['permissions_raids'] = 'Raids';
$phprlang['permissions_new'] = 'Create a new set';
$phprlang['permissions_users'] = 'Users';
$phprlang['permissions_users_header'] = 'Users in set';

// profile
$phprlang['profile_arcane'] = 'Arcane Resistance';
$phprlang['profile_class'] = 'Class';
$phprlang['profile_create_header'] = 'Character creation unavailable';
$phprlang['profile_create_msg'] = 'Until an admin creates a guild character creation will be unavailable';
$phprlang['profile_fire'] = 'Fire Resistance';
$phprlang['profile_frost'] = 'Frost Resistance';
$phprlang['profile_gender'] = 'Gender';
$phprlang['profile_guild'] = 'Guild affiliation';
$phprlang['profile_role'] = 'Role';
$phprlang['profile_header'] = 'Characters';
$phprlang['profile_level'] = 'Level';
$phprlang['profile_name'] = 'Name';
$phprlang['profile_nature'] = 'Nature Resistance';
$phprlang['profile_raid'] = 'Raid Participation';
$phprlang['profile_race'] = 'Race';
$phprlang['profile_shadow'] = 'Shadow Resistance';

// raids
$phprlang['raids_date'] = 'Date';
$phprlang['raids_description'] = 'Description';
$phprlang['raids_dungeon'] = 'Dungeon';
$phprlang['raids_freeze'] = 'Freeze limit (in hours)';
$phprlang['raids_invite'] = 'Invite time';
$phprlang['raids_limits'] = 'Raid limits';
$phprlang['raids_location'] = 'Stored location';
$phprlang['raids_max'] = 'Raid maximum';
$phprlang['raids_max_lvl'] = 'Maximum level';
$phprlang['raids_min_lvl'] = 'Minimum level';
$phprlang['raids_old'] = 'Previous events';
$phprlang['raids_new'] = 'Upcoming events';
$phprlang['raids_new_header'] = 'New Raid';
$phprlang['raids_start'] = 'Start time';
$phprlang['raids_eventtype_text'] = 'Event Type';

// event type
$phprlang['event_type_raid'] = 'Raid (10/25 man)';
$phprlang['event_type_dungeon'] = 'Dungeon (5 man Instance)';
$phprlang['event_type_pvp'] = 'PvP Event';
$phprlang['event_type_meeting'] = 'Meeting (online/offline)';
$phprlang['event_type_other'] = 'Other';

// expansions
$phprlang['exp_generic_wow'] = 'Generic World of Warcraft';
$phprlang['exp_burning_crusade'] = 'The Burning Crusade';
$phprlang['exp_wrath_lich_king'] = 'Wrath of the Lich King';

// roster
$phprlang['roster_header'] = 'Guild Roster';

// registration
$phprlang['register_complete_header'] = 'Registration success';
$phprlang['register_complete_msg'] = 'You are now registered for WRM Use.  On some sites you may now create your profile and characters, on others you will need to wait for permissions to be set by the system administrator.';
$phprlang['register_confirm'] = 'Your passwords do not match.';
$phprlang['register_confirm_text'] = 'Enter password again';
$phprlang['register_email_header'] = 'Registration at';
$phprlang['register_email_empty'] = 'You must enter an email address';
$phprlang['register_email_exists'] = 'That e-mail address is already in use';
$phprlang['register_email_greeting'] = 'Welcome';
$phprlang['register_email_subject'] = 'This email is to confirm your registration. Do not reply as no one will receive your response.';
$phprlang['register_email_text'] = 'E-mail address';
$phprlang['register_error'] = 'Registration error';
$phprlang['register_header'] = 'User Registration';
$phprlang['register_pass_empty'] = 'You must enter a password';
$phprlang['register_password_text'] = 'Password';
$phprlang['register_user_empty'] = 'You must enter a user name';
$phprlang['register_user_exists'] = 'That username is already in use';
$phprlang['register_username_text'] = 'Username';

// users
$phprlang['users_assign'] = 'Assign';
$phprlang['users_char_header'] = 'User characters';
$phprlang['users_header'] = 'Users';

// view
$phprlang['view_approved'] = 'Approved members';
$phprlang['view_cancel_header'] = 'Cancelled signups';
$phprlang['view_character'] = 'Character';
$phprlang['view_comments'] = 'Comments';
$phprlang['view_create'] = 'Create a character to signup';
$phprlang['view_date'] = 'Date';
$phprlang['view_description_header'] = 'Raid description';
$phprlang['view_frozen'] = 'Signups are frozen';
$phprlang['view_information_header'] = 'Information';
$phprlang['view_invite'] = 'Invite time';
$phprlang['view_location'] = 'Dungeon';
$phprlang['view_login'] = 'Log in to signup';
$phprlang['view_new'] = 'Signup for this raid';
$phprlang['view_max'] = 'Raid max';
$phprlang['view_max_lvl'] = 'Maximum level';
$phprlang['view_min_lvl'] = 'Minimum level';
$phprlang['view_missing_signups_link_text'] = 'View Profles who have NOT signed up for this raid.';
$phprlang['view_officer'] = 'Creator';
$phprlang['view_ok'] = 'Open for signups';
$phprlang['view_queue'] = 'How do you want to signup?';
$phprlang['view_queue_header'] = 'Queued signups';
$phprlang['view_queued'] = 'Queued members';
$phprlang['view_raid_cancel_text'] = 'Cancelled signups';
$phprlang['view_signed'] = 'Already signed up';
$phprlang['view_signup'] = 'Signup information';
$phprlang['view_signup_queue'] = 'Signup as Queued';
$phprlang['view_signup_cancel'] = 'Signup as Cancelled';
$phprlang['view_signup_draft'] = 'Signup as In Raid (Drafted)';
$phprlang['view_start'] = 'Start time';
$phprlang['view_statistics_header'] = 'Statistics';
$phprlang['view_teams_link_text'] = 'Create and Assign Teams for This Raid';
$phprlang['view_total'] = 'Total signups';
$phprlang['view_username'] = 'Username';

// main page
$phprlang['main_previous_raids'] = 'Previous events';
$phprlang['main_upcoming_raids'] = 'Upcoming events';
$phprlang['signup'] = 'Sign Up';
$phprlang['rss_feed_text'] = 'Raid Signups RSS Feed';
$phprlang['guild_time_string'] = 'Guild Time';
$phprlang['menu_header_text'] = 'WRM Menu';

// teams
$phprlang['team_new_header'] = 'Create New Team';
$phprlang['team_add_header'] = 'Add Members to Team';
$phprlang['team_remove_header'] = 'Remove Members from Team';
$phprlang['teams_raid_view_text'] = 'Return to Raid View';
$phprlang['team_cur_teams_header'] = 'Created Teams';
$phprlang['team_page_header'] = 'Teams';
?>