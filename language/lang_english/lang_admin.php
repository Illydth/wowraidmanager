<?php
/***************************************************************************
 *                           lang_admin.php (English)
 *                            -------------------
 *   begin                : Monday, May 11, 2009
 *   copyright            : (C) 2007-2009 Douglas Wagner
 *   email                : douglasw@wagnerweb.org
 *
 ***************************************************************************/

/***************************************************************************
*
*    WoW Raid Manager - Raid Management Software for World of Warcraft
*    Copyright (C) 2007-2009 Douglas Wagner
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

// Menu Headers
$phprlang['admin_menu_header'] = 'Admin Menu';
$phprlang['gen_conf_menu_header'] = 'General Config';
$phprlang['user_mgt_menu_header'] = 'User Management';
$phprlang['table_conf_menu_header'] = 'Table Config';
$phprlang['logs_menu_header'] = 'Logs';

// Admin Main Menu Links
$phprlang['admin_site_link'] = '&raquo; Exit Admin';
$phprlang['admin_main_link'] = '&raquo; Main';
$phprlang['admin_logs_link'] = '&raquo; Logs';
$phprlang['admin_rolecfg_link'] = '&raquo; Role Configuration';
$phprlang['admin_datatablecfg_link'] = '&raquo; Manage Data Tables';
$phprlang['admin_permissions'] = '&raquo; User Permissions';
$phprlang['admin_signup_rights'] = '&raquo; Signup Activities';
$phprlang['admin_user_settings'] = '&raquo; User Settings';
$phprlang['admin_user_management'] = '&raquo; User Administration';
$phprlang['admin_general_config'] = '&raquo; General Config';
$phprlang['admin_time_config'] = '&raquo; Time Settings';
$phprlang['admin_raid_settings'] = '&raquo; Raid Settings';
$phprlang['admin_external_config'] = '&raquo; External Systems';

// Link from Main Site to Admin
$phprlang['admin_section_link'] = 'Admin Section';

// Text on the Main Index Page
$phprlang['admin_index_header'] = 'WRM Administrative Section';
$phprlang['admin_statistics_header'] = 'Statistics';
$phprlang['wrm_statistics_header'] = 'WRM Statistics:';
$phprlang['database_statistics_header'] = 'Database Statistics:';
$phprlang['admin_version_stat_text'] = 'WRM Version:';
$phprlang['statistic'] = 'Statistic';
$phprlang['value'] = 'Value';
$phprlang['db_name_text'] = 'Database Name:';
$phprlang['db_host_text'] = 'Database HostName:';
$phprlang['db_user_text'] = 'Database Username:';
$phprlang['db_prefix_text'] = 'Database Table Prefix:';
$phprlang['db_size_text'] = 'Database Size (WRM Tables Only):';
$phprlang['php_version_text'] = 'PHP Version:';
$phprlang['mysql_version_text'] = 'MySQL Version:';
$phprlang['user_count_text'] = 'Number of Users:';
$phprlang['wrm_db_ver_text'] = 'WRM Database Version:';
$phprlang['recent_logins_header'] = 'Recent Logins:';
$phprlang['recent_logins_explanation'] = 'These are the users who have used the WRM software within the last 5 minutes.';
$phprlang['inactive_logins_header'] = 'Inactive Logins:';
$phprlang['inactive_login_explanation'] = 'These are the last 10 most recent users to fall into the "inactive" 
											category.<br>To see the full list of inactive users please see the 
											"User Administration" link in the Admin Section.';
$phprlang['logins_username_header'] = 'Username';
$phprlang['logins_email_header'] = 'EMail';
$phprlang['logins_priv_header'] = 'Privledge Group';
$phprlang['logins_time_header'] = 'Last Login';
$phprlang['kib'] =  'KiB';
$phprlang['raid_stats_header'] = 'Raid Statistics:';
$phprlang['raid_stats_explanation'] = 'Percentages are calculated as the total number of signed up users for the period<br>
										(Queued + Drafted, NOT Cancelled) devided by total maximum raid attendees
										for the period.';
$phprlang['raid_active_count_header'] = 'Active Raids:';
$phprlang['raid_total_count_header'] = 'Total Raids:';
$phprlang['raid_week_percent_header'] = 'This Week\'s Attendance Percentage:';
$phprlang['raid_30d_percent_header'] = 'Attendence Last 30 Days:';
$phprlang['raid_3m_percent_header'] = 'Attendence Last 3 Months:';
$phprlang['raid_6m_percent_header'] = 'Attendence Last 6 Months:';
$phprlang['raid_1y_percent_header'] = 'Attendence Last 1 Year:';
$phprlang['raid_life_percent_header'] = 'Lifetime Attendence Percentage:';
$phprlang['logs_header'] = 'Recent Hack Logs:';
$phprlang['logs_explanation'] = 'The 10 most recent "Hacking Attempts" identified by the system.';
$phprlang['ip_header'] = 'IP Address';
$phprlang['message_header'] = 'Message';
$phprlang['timestamp_header'] = 'Date/Time';
$phprlang['delete_board_cache_text'] = 'Delete cache files for the WRM Application.';
$phprlang['delete_armory_cache_text'] = 'Delete cache files for the WOW Armory';
$phprlang['delete_armory_log_text'] = 'Delete the WoW Armory Output Logs';
$phprlang['delete_template_cache_text'] = 'Delete the WRM Application Template Cache Files.';
$phprlang['actions_header'] = 'Board Cache/Log Actions:';
$phprlang['actions_explanation'] = 'The buttons below purge the various cache and log files associated with WRM.';

// Text on the "General Config" Page
$phprlang['configuration_addon'] = 'Addon URL';
$phprlang['configuration_admin_email'] = 'Admin e-mail';
$phprlang['configuration_debug'] = 'Debug mode';
$phprlang['configuration_disable'] = 'Disable phpRaid';
$phprlang['configuration_email_header'] = 'E-mail configuration';
$phprlang['configuration_email_sig'] = 'E-mail signature';
$phprlang['configuration_enable_five_man'] = 'Enable groups<br><a href="../docs/enable_groups.htm" target="_blank">help?</a>';
$phprlang['configuration_language'] = 'Language';
$phprlang['configuration_logo'] = 'Path to header image';
$phprlang['configuration_register_text'] = 'Registration URL';
$phprlang['configuration_rss_header'] = 'RSS Configuration';
$phprlang['configuration_show_addon'] = 'Show addon link';
$phprlang['configuration_sitelink'] = '"Home" Link Points To';
$phprlang['configuration_template'] = 'Template';
$phprlang['general_configuration_header'] = 'General Settings';

// Text on the "Time Config" Page
$phprlang['configuration_ampm'] = 'Schedule Raids in 12h/24h format';
$phprlang['configuration_date'] = 'Date format<br><a href="http://www.php.net/date/" target="_blank">help?</a>';
$phprlang['configuration_dst_text'] = 'Daylight saving time?';
$phprlang['configuration_time'] = 'Time format<br><a href="http://www.php.net/date/" target="_blank">help?</a>';
$phprlang['configuration_timezone_text'] = 'Timezone';
$phprlang['time_header'] = 'Time Configuration';

// Text on the "Role Configuration" Page.
$phprlang['addrole'] = 'Add Role';
$phprlang['updaterole'] = 'Update Role';
$phprlang['configuration_role_new_header'] = 'Add a New Role';
$phprlang['configuration_role_edit_header']= 'Modify an Existing Role';
$phprlang['role_error_exists'] = 'Role ID Already Exists, Chose Another.';
$phprlang['role_error_role_name_blank'] = 'Role Name Cannot Be a Blank or Null Value.';
$phprlang['role_error_role_config_blank'] = 'Role Config Text Cannot Be a Blank or Null Value.';
$phprlang['role_error_role_id_blank'] = 'Role ID Cannot Be a Blank or Null Value.';


$phprlang['configuraiton_admin'] = 'Administrator';
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
$phprlang['configuration_description'] = 'Description';
$phprlang['configuration_default'] = 'Default Group';
$phprlang['configuration_delete'] = 'Delete';
$phprlang['configuration_delete_def'] = 'Delete = Remove User Signup Completely';
$phprlang['configuration_draft_def'] = 'Draft = Place User into Attending Raid Area';
$phprlang['configuration_draft'] = 'Draft';
$phprlang['configuration_drafted'] = 'Drafted (In Raid)';
$phprlang['configuration_eqdkp_integration_text'] = 'Integrate with EqDKP<br><a href="docs/eqdkp_link.htm" target="_blank">help?</a>';
$phprlang['configuration_eqdkp_link'] = 'URL to Base of EqDKP Installation (No Trailing /)';
$phprlang['configuration_external_links_header'] = 'Integration with External Systems';
$phprlang['configuration_faction'] = 'Faction';
$phprlang['configuration_freeze'] = 'Disable freeze checking';
$phprlang['configuration_guild_header'] = 'Guild Configuration';
$phprlang['configuration_guild_name'] = 'Name';
$phprlang['configuration_id'] = 'Show id in tables';
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
$phprlang['configuration_role_header'] = 'Role Configuration';
$phprlang['configuration_role_limit_text'] = 'Enforce Role Limits for Raid';
$phprlang['configuration_class_limit_text'] = 'Enforce Class Limits for Raid';
$phprlang['configuration_class_as_min'] = 'Use Class Limits as Minimums';
$phprlang['configuration_roster_text'] = 'Integrate with WoW Roster';
$phprlang['configuration_rss_site'] = 'RSS: URL to phpRaid Installation (No Trailing /)';
$phprlang['configuration_rss_export'] = 'RSS: Site to export RSS feed to';
$phprlang['configuration_rss_feed_amt'] = 'RSS: Number of Raids to Show in Feed';
$phprlang['configuration_server'] = 'Server';
$phprlang['configuration_signup_rights_header'] = 'Signup Rights';
$phprlang['configuration_site_header'] = 'Site Configuration';
$phprlang['configuration_user'] = 'User';
$phprlang['configuration_user_rights_header'] = 'User Rights';
$phprlang['configuration_version_current'] = 'You are running the latest version of phpRaid';
$phprlang['configuration_version_info_header'] = 'Version Information';
$phprlang['configuration_version_outdated_header'] = 'WoW Raid Manager update available!';
$phprlang['configuration_version_outdated_message'] = 'Your version of WoW Raid Manager is out of date. Updating is strongly recommended.<br>
													   The latest version is %s and you are running version %s.<br>
													   To download, visit the <a href="http://www.wowraidmanager.net">WoW Raid Manager for BC download</a> section.';

