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

if (empty($phprlang) || !is_array($phprlang))
	$phprlang = array();
	
$phprlang = array_merge($phprlang, array(

// Menu Headers
'admin_menu_header' =>  'Admin Menu',
'gen_conf_menu_header' =>  'General Config',
'user_mgt_menu_header' =>  'User Management',
'table_conf_menu_header' =>  'Table Config',
'logs_menu_header' =>  'Logs',

// Admin Main Menu Links
'admin_site_link' =>  '&raquo; Exit Admin',
'admin_main_link' =>  '&raquo; Main',
'admin_logs_link' =>  '&raquo; Logs',
'admin_rolecfg_link' =>  '&raquo; Role Configuration',
'admin_datatablecfg_link' =>  '&raquo; Manage Data Tables',
'admin_permissions' =>  '&raquo; WRM Permission Groups',
'admin_signup_rights' =>  '&raquo; Signup Activities',
'admin_raid_signupgroups' =>  '&raquo; Raid Permission Groups',
'admin_user_settings' =>  '&raquo; User Settings',
'admin_user_management' =>  '&raquo; User Administration',
'admin_general_config' =>  '&raquo; WRM Config',
'admin_general_rss_cfg' =>  '&raquo; RSS Configuration',
'admin_general_email_cfg' =>  '&raquo; E-mail Configuration',
'admin_time_config' =>  '&raquo; Time Settings',
'admin_raid_settings' =>  '&raquo; Raid Settings',
'admin_external_config' =>  '&raquo; External Systems',
'admin_game_settings' =>  '&raquo; Game Settings',
'admin_roletalent_config' =>  '&raquo; Link Class/Role/Talent',
'admin_style_conf' =>  '&raquo; Template Config',
'admin_menubar_mgt_link' =>  '&raquo; Menu Bar Settings',
'admin_general_lua_output_cfg' =>  '&raquo; LUA Output Settings',

// Link from Main Site to Admin
'admin_section_link' =>  'Admin Section',

// Text on the Main Index Page
'admin_index_header' =>  'WRM Administrative Section',
'admin_statistics_header' =>  'Statistics',
'wrm_statistics_header' =>  'WRM Statistics:',
'database_statistics_header' =>  'Database Statistics:',
'admin_version_stat_text' =>  'WRM Version:',
'statistic' =>  'Statistic',
'value' =>  'Value',
'db_name_text' =>  'Database Name:',
'db_host_text' =>  'Database HostName:',
'db_user_text' =>  'Database Username:',
'db_prefix_text' =>  'Database Table Prefix:',
'db_size_text' =>  'Database Size (WRM Tables Only):',
'php_version_text' =>  'PHP Version:',
'mysql_version_text' =>  'MySQL Version:',
'user_count_text' =>  'Number of Users:',
'wrm_db_ver_text' =>  'WRM Database Version:',
'recent_logins_header' =>  'Recent Logins:',
'recent_logins_explanation' =>  'These are the users who have used the WRM software within the last 5 minutes.',
'inactive_logins_header' =>  'Inactive Logins:',
'inactive_login_explanation' =>  'These are the last 10 most recent users to fall into the "inactive" 
											category.<br>To see the full list of inactive users please see the 
											"User Administration" link in the Admin Section.',
'logins_username_header' =>  'Username',
'logins_email_header' =>  'EMail',
'logins_priv_header' =>  'Privledge Group',
'logins_time_header' =>  'Last Login',
'kib' =>   'KiB',
'raid_stats_header' =>  'Raid Statistics:',
'raid_stats_explanation' =>  'Percentages are calculated as the total number of signed up users for the period<br>
										(Queued + Drafted, NOT Cancelled) devided by total maximum raid attendees
										for the period.',
'raid_active_count_header' =>  'Active Raids:',
'raid_total_count_header' =>  'Total Raids:',
'raid_week_percent_header' =>  'This Week\'s Attendance Percentage:',
'raid_30d_percent_header' =>  'Attendence Last 30 Days:',
'raid_3m_percent_header' =>  'Attendence Last 3 Months:',
'raid_6m_percent_header' =>  'Attendence Last 6 Months:',
'raid_1y_percent_header' =>  'Attendence Last 1 Year:',
'raid_life_percent_header' =>  'Lifetime Attendence Percentage:',
'logs_header' =>  'Recent Hack Logs:',
'logs_explanation' =>  'The 10 most recent "Hacking Attempts" identified by the system.',
'ip_header' =>  'IP Address',
'message_header' =>  'Message',
'timestamp_header' =>  'Date/Time',
'delete_board_cache_text' =>  'Delete cache files for the WRM Application.',
'delete_armory_cache_text' =>  'Delete WOW Armory Cache Information',
'delete_armory_log_text' =>  'Delete the WoW Armory Output Logs',
'delete_template_cache_text' =>  'Delete the WRM Application Template Cache Files.',
'actions_header' =>  'Board Cache/Log Actions:',
'actions_explanation' =>  'The buttons below purge the various cache and log files associated with WRM.',
'configuration_version_current' =>  'You are running the latest version of WRM',
'configuration_version_info_header' =>  'Version Information',
'configuration_version_outdated_header' =>  'WoW Raid Manager update available!',
'configuration_version_outdated_message' =>  'Your version of WoW Raid Manager is out of date. Updating is strongly recommended.<br>
													   The latest version is %s and you are running version %s.<br>
													   To download, visit the <a href="http://www.wowraidmanager.net">WoW Raid Manager for BC download</a> section.',

// Text on the "General Config" Page
'configuration_debug' =>  'Debug mode',
'configuration_disable' =>  'Disable WRM',
'configuration_enable_five_man' =>  'Enable groups<br><a href="../docs/enable_groups.htm" target="_blank">help?</a>',
'configuration_language' =>  'Language',
'configuration_records_per_page' =>  'Records Per Data Table Page',
'configuration_persistent_db' =>  'Create Persistant Database Connection?',
'general_configuration_header' =>  'General Settings',
'configuration_old_raids_index' =>  'Number of Old Raids to Show on the Index Page',
'auto_mark_raids_old' =>  'Auto Mark Raids Old (Hours)',

'general_side_cfg_header' =>  'Side Config',
'configuration_site_name' =>  'Site Name',
'configuration_site_server' =>  'Site Server Name',
'configuration_site_description' =>  'Site Description',

'configuration_admin_email' =>  'Admin e-mail',
'configuration_email_header' =>  'E-mail configuration',
'configuration_email_sig' =>  'E-mail signature',

'configuration_rss_header' =>  'RSS Configuration',
'configuration_rss_site' =>  'RSS: URL to WRM Installation (No Trailing /)',
'configuration_rss_export' =>  'RSS: Site to export RSS feed to',
'configuration_rss_feed_amt' =>  'RSS: Number of Raids to Show in Feed',


// Text on the "Style Config" Page
'style_menu_header' =>  'Style Config',
'configuration_template_cfg_header' =>  'Template Config',
'configuration_template_width_text' =>  "Template Width",
'configuration_width_normal' =>  "normal",
'configuration_width_expanded' =>  "expanded",
'configuration_logo' =>  'Path to header image',
'configuration_sitelink' =>  '"Home" Link Points To',
'configuration_template' =>  'Template',
'configuration_addon' =>  'Addon URL',
'configuration_show_addon' =>  'Show addon link',
'configuration_register_text' =>  'Registration URL',

// Text on the "Time Config" Page
'configuration_ampm' =>  'Schedule Raids in 12h/24h format',
'configuration_date' =>  'Date format<br><a href="http://www.php.net/date/" target="_blank">help?</a>',
'configuration_dst_text' =>  'Daylight saving time?',
'configuration_time' =>  'Time format<br><a href="http://www.php.net/date/" target="_blank">help?</a>',
'configuration_timezone_text' =>  'Timezone',
'time_header' =>  'Time Configuration',

// Text on the "Game Settings" Page.
'configuration_game_header' =>  'Game Settings',
'configuration_game_select_addon' =>  'select Addon',

// Text on the "Role Configuration" Page.
'configuration_role_header' =>  'Role Configuration',
'addrole' =>  'Add Role',
'updaterole' =>  'Update Role',
'configuration_role_new_header' =>  'Add a New Role',
'configuration_role_edit_header' =>  'Modify an Existing Role',
'role_error_exists' =>  'Role ID Already Exists, Chose Another.',
'role_error_role_name_blank' =>  'Role Name Cannot Be a Blank or Null Value.',
'role_error_role_config_blank' =>  'Role Config Text Cannot Be a Blank or Null Value.',
'role_error_role_id_blank' =>  'Role ID Cannot Be a Blank or Null Value.',

// Text on the "Link Class/Role/Talent" Page.
'configuration_roletalent_header' =>  'Class/Role/Talent Links',
'configuration_roletalent_new_header' =>  'Add New Class/Role/Talent Link',
'configuration_roletalent_edit_header' =>  'Edit Class/Role/Talent Link',
'roletalent_duplicate_error' =>  'Duplicate Class/Role/Talent Link',
'roletalent_classid_blank_error' =>  'The Class ID Cannot be a Blank or Null Value.',
'roletalent_talenttree_blank_error' =>  'The Talent Tree Name Cannot be a Blank or Null Value',
'roletalent_displaytext_blank_error' =>  'The Display Text Value Cannot be Blank or Null.',
'roletalent_roleid_blank_error' =>  'The Role Name Cannot be a Blank or Null Value',

// Text on the "Data Table Config" Page.
'configuration_datatable_header' =>  'Modify Data Table Information',
'configuration_datatable_view_select_text' =>  'Select the View to Modify: ',
'configuration_datatable_edit_header' =>  'Change View Properties',
'configuration_datatable_column_name' =>  'Column Name',
'configuration_datatable_visible' =>  'Visible',
'configuration_datatable_position' =>  'Column Position',
'configuration_datatable_image_url' =>  'Image URL',
'configuration_datatable_default_sort' =>  'Sort on This Column', 

// Text on the "User Administration" Page.
'configuration_users_modperm_header' =>  'Change Selected User(s) Permission Group',
'configuration_users_modperm_desc' =>  'To change the permission group for a user, do the
												following: <br><ol><li>Select the checkboxes in the
												table above next to the users whose permission group
												you want to change.</li><li>Select the permission group
												to change to from the dropdown box below</li><li>Click
												the Submit button below.</li></ol><br>The permission
												group for each user should update in the user list
												table above to the selected permission group.',
'configuration_permission_cannot_modify' =>  'You have attempted to remove the "Admin" privledge group
														from all of your users, this would leave you without an 
														ability to administrate your system and is not allowed.<br><br>
														Please add a user to the "Admin" Privledge group before
														atempting to remove users from it.  There must be at least
														one "Admin" privledged user.',

// Text on the "External Systems" Page.
'configuration_armory_cache' =>  'Cache Armory Data To',
'configuration_external_links_header' =>  'Integration with External Systems',
'configuration_eqdkp_integration_text' =>  'Integrate with EqDKP<br><a href="../docs/eqdkp_link.htm" target="_blank">help?</a>',
'configuration_eqdkp_link' =>  'URL to Base of EqDKP Installation (No Trailing /)',
'configuration_roster_text' =>  'Integrate with WoW Roster',
'configuration_armory_enable' =>  'Enable Armory Lookups',
'configuration_armory_cache_database' =>  'Database Table',
'configuration_armory_cache_files' =>  'Files on Disk',
'configuration_armory_cache_none' =>  'Do not Cache Armory Data',
'configuration_armory_link_text' =>  'Correct Armory Link for Server',
'configuration_armory_language_text' =>  'Language Code for Armory',
'configuration_extsys_bridge_config_header' =>  'Bridge Config',
'configuration_extsys_norest' =>  'No Restrictions',
'configuration_extsys_noaddus' =>  'No Additional UserGroup',
'configuration_extsys_group01' =>  'Select the base user group that has access to use WRM',
'configuration_extsys_group02' =>  'Any user without this group set will not be allowed to log in',
'configuration_extsys_group03' =>  'Please select "No Restrictions" here if you want all users regardless of group to be able to login to WRM',
'configuration_extsys_alt_group01' =>  'Select an Additional user group/class that can access WRM',
'configuration_extsys_alt_group02' =>  'Any user tagged with this group will be allowed to log in regardless of whether they are in the above user group or not',
'configuration_extsys_group_text' =>  'Base User group',
'configuration_extsys_alt_group_text' =>  'Additional user group',
'configuration_armory_cache_timeout' =>  'Armory Cache Lifetime (In Hours)',
'configuration_armory_cache_timeout_sup' =>  'After the Cache Lifetime expires, WRM will go back to the Armory to re-pull data.  The shorter the cache<br>' . 
													' the "fresher" the data WRM will have in it\'s popup, but the slower WRM will run due to pulling data from<br>' . 
													' the armory URL more often.  The longer the cache value, the less "fresh" Armory data but the faster<br>' . 
													' WRM will run.',

// Text on the "User Settings" Page.
'configuration_multiple' =>  'Allow multiple signups',
'configuration_anonymous' =>  'Allow anonymous viewing',
'configuration_resop' =>  'Make resistance optional',

// Text on the "Signup Rights" Page.
'configuration_raid_signupgroups_header' =>  'Raid Permission Groups',
'configuration_cancel' =>  'Cancel',
'configuration_cancel_def' =>  'Cancel = Place User Into Cancelled Area',
'configuration_cancelled' =>  'Cancelled Status',
'configuration_comments' =>  'Comments',
'configuration_comments_def' =>  'Comments = Allow User to Edit Their Comments',
'configuration_delete' =>  'Delete',
'configuration_delete_def' =>  'Delete = Remove User Signup Completely',
'configuration_draft_def' =>  'Draft = Place User into Attending Raid Area',
'configuration_draft' =>  'Draft',
'configuration_drafted' =>  'Drafted (In Raid)',
'configuration_on_queue' =>  'On Queue',
'configuration_queue' =>  'Queue',
'configuration_queue_def' =>  'Queue = Place User In Queued Area',
'configuration_signup_rights_header' =>  'Signup Rights',
'configuraiton_admin' =>  'Administrator',
'configuration_raidlead' =>  'Raid Leader',

// Text on the "Raid Settings" Page.
'configuration_raid_settings_header' =>  'Raid Settings',//
'configuration_raid_view_type_text' =>  'Select Raid View Type',//
'configuration_raid_view_type_class' =>  'Display Raid View By Class',//
'configuration_raid_view_type_role' =>  'Display Raid View By Role',//
'configuration_role_limit_text' =>  'Enforce Role Limits for Raid',//
'configuration_class_limit_text' =>  'Enforce Class Limits for Raid',//
'configuration_class_as_min' =>  'Use Class Limits as Minimums',//
'configuration_freeze' =>  'Disable freeze checking',//
'configuration_recurrance_enabled_text' =>  'Enable Recurring Raids System',
'configuration_freeze_status_draft' =>  'Stop changes to Drafted Raiders During Freeze',
'configuration_freeze_status_queue' =>  'Stop changes to Queued Raiders During Freeze',
'configuration_freeze_status_cancel' =>  'Stop changes to Cancelled Raiders During Freeze',
'configuration_description' =>  'Description',
'configuration_default' =>  'Default Group',
'configuration_faction' =>  'Faction',
'configuration_guild_header' =>  'Guild Configuration',
'configuration_guild_name' =>  'Name',
'configuration_id' =>  'Show id in tables',
'configuration_server' =>  'Server',
'configuration_site_header' =>  'Site Configuration',
'configuration_user' =>  'User',
'configuration_user_rights_header' =>  'User Rights',

// multiple use
'configuration_autoqueue' =>  'Disallow Signup to Drafted Status',

));

?>