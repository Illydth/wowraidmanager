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
$phprlang['admin_permissions'] = '&raquo; WRM Permission Groups';
$phprlang['admin_signup_rights'] = '&raquo; Signup Activities';
$phprlang['admin_raid_signupgroups'] = '&raquo; Raid Permission Groups';
$phprlang['admin_user_settings'] = '&raquo; User Settings';
$phprlang['admin_user_management'] = '&raquo; User Administration';
$phprlang['admin_general_config'] = '&raquo; General Config';
$phprlang['admin_time_config'] = '&raquo; Time Settings';
$phprlang['admin_raid_settings'] = '&raquo; Raid Settings';
$phprlang['admin_external_config'] = '&raquo; External Systems';
$phprlang['admin_roletalent_config'] = '&raquo; Link Class/Role/Talent';

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
$phprlang['configuration_version_current'] = '您現在使用的是最新版的WRM';
$phprlang['configuration_version_info_header'] = '版本資訊';
$phprlang['configuration_version_outdated_header'] = '有新版的WRM可以更新!';
$phprlang['configuration_version_outdated_message'] = '您的WRM已經是舊版的了. 強烈建議您立即更新.<br>
													   最新的版本號是 %s 您目前的版本是 %s.<br>
													   請到後面的鏈結下載 <a href="http://www.wowraidmanager.net">WoW Raid Manager for BC</a>.';

// Text on the "General Config" Page
$phprlang['configuration_addon'] = '插件鏈結位址';
$phprlang['configuration_admin_email'] = '管理者信箱';
$phprlang['configuration_debug'] = '除蟲模式';
$phprlang['configuration_disable'] = '關閉活動報名系統';
$phprlang['configuration_email_header'] = '信箱設定';
$phprlang['configuration_email_sig'] = '信箱簽名檔';
$phprlang['configuration_enable_five_man'] = '允許五人隊伍<br><a href="../docs/enable_groups.htm" target="_blank">help?</a>';
$phprlang['configuration_language'] = '語言';
$phprlang['configuration_logo'] = 'Logo鏈結位址';
$phprlang['configuration_records_per_page'] = 'Records Per Data Table Page';
$phprlang['configuration_register_text'] = '登寄網址';
$phprlang['configuration_rss_header'] = 'RSS Configuration';
$phprlang['configuration_rss_site'] = 'RSS:WRM安裝網址 (網址尾端不得輸入 /)';
$phprlang['configuration_rss_export'] = 'RSS:輸出RSS資料至網站';
$phprlang['configuration_rss_feed_amt'] = 'RSS:於RSS資料顯示之團隊數量';
$phprlang['configuration_show_addon'] = '顯示插件連結';
$phprlang['configuration_sitelink'] = '"頁首" 連結';
$phprlang['configuration_template'] = '版面';
$phprlang['general_configuration_header'] = 'General Settings';
$phprlang['configuration_site_name'] = 'Site Name';
$phprlang['configuration_site_server'] = 'Site Server Name';
$phprlang['configuration_site_description'] = 'Site Description';
$phprlang['configuration_persistent_db'] = 'Create Persistant Database Connection?';

// Text on the "Time Config" Page
$phprlang['configuration_ampm'] = 'Schedule Raids in 12h/24h format';
$phprlang['configuration_date'] = '日期格式<br><a href="http://www.php.net/date/" target="_blank">幫助?</a>';
$phprlang['configuration_dst_text'] = '日光節約時間?';
$phprlang['configuration_time'] = '時間格式 <br><a href="http://www.php.net/date/" target="_blank">help?</a>';
$phprlang['configuration_timezone_text'] = '時區';
$phprlang['time_header'] = 'Time Configuration';

// Text on the "Role Configuration" Page.
$phprlang['configuration_role_header'] = '角色設定';
$phprlang['addrole'] = 'Add Role';
$phprlang['updaterole'] = 'Update Role';
$phprlang['configuration_role_new_header'] = 'Add a New Role';
$phprlang['configuration_role_edit_header']= 'Modify an Existing Role';
$phprlang['role_error_exists'] = 'Role ID Already Exists, Chose Another.';
$phprlang['role_error_role_name_blank'] = 'Role Name Cannot Be a Blank or Null Value.';
$phprlang['role_error_role_config_blank'] = 'Role Config Text Cannot Be a Blank or Null Value.';
$phprlang['role_error_role_id_blank'] = 'Role ID Cannot Be a Blank or Null Value.';

// Text on the "Link Class/Role/Talent" Page.
$phprlang['configuration_roletalent_header'] = 'Class/Role/Talent Links';
$phprlang['configuration_roletalent_new_header'] = 'Add New Class/Role/Talent Link';
$phprlang['configuration_roletalent_edit_header'] = 'Edit Class/Role/Talent Link';
$phprlang['roletalent_duplicate_error'] = 'Duplicate Class/Role/Talent Link';
$phprlang['roletalent_classid_blank_error'] = 'The Class ID Cannot be a Blank or Null Value.';
$phprlang['roletalent_talenttree_blank_error'] = 'The Talent Tree Name Cannot be a Blank or Null Value';
$phprlang['roletalent_displaytext_blank_error'] = 'The Display Text Value Cannot be Blank or Null.';
$phprlang['roletalent_roleid_blank_error'] = 'The Role Name Cannot be a Blank or Null Value';

// Text on the "Data Table Config" Page.
$phprlang['configuration_datatable_header'] = 'Modify Data Table Information';
$phprlang['configuration_datatable_view_select_text'] = 'Select the View to Modify: ';
$phprlang['configuration_datatable_edit_header'] = 'Change View Properties';
$phprlang['configuration_datatable_column_name'] = 'Column Name';
$phprlang['configuration_datatable_visible'] = 'Visible';
$phprlang['configuration_datatable_position'] = 'Column Position';
$phprlang['configuration_datatable_image_url'] = 'Image URL';
$phprlang['configuration_datatable_default_sort'] = 'Sort on This Column'; 

// Text on the "User Administration" Page.
$phpraid['configuration_users_modperm_header'] = 'Change Selected User(s) Permission Group';
$phpraid['configuration_users_modperm_desc'] = 'To change the permission group for a user, do the
												following: <br><ol><li>Select the checkboxes in the
												table above next to the users whose permission group
												you want to change.</li><li>Select the permission group
												to change to from the dropdown box below</li><li>Click
												the Submit button below.</li></ol><br>The permission
												group for each user should update in the user list
												table above to the selected permission group.';
$phprlang['configuration_permission_cannot_modify'] = 'You have attempted to remove the "Admin" privledge group
														from all of your users, this would leave you without an 
														ability to administrate your system and is not allowed.<br><br>
														Please add a user to the "Admin" Privledge group before
														atempting to remove users from it.  There must be at least
														one "Admin" privledged user.';

// Text on the "External Systems" Page.
$phprlang['configuration_armory_cache'] = 'Cache Armory Data To';
$phprlang['configuration_external_links_header'] = 'Integration with External Systems';
$phprlang['configuration_eqdkp_integration_text'] = 'Integrate with EqDKP<br><a href="../docs/eqdkp_link.htm" target="_blank">help?</a>';
$phprlang['configuration_eqdkp_link'] = 'URL to Base of EqDKP Installation (No Trailing /)';
$phprlang['configuration_roster_text'] = '與WoW Roster整合';
$phprlang['configuration_armory_enable'] = 'Enable Armory Lookups';
$phprlang['configuration_armory_cache_database'] = 'Database Table';
$phprlang['configuration_armory_cache_files'] = 'Files on Disk';
$phprlang['configuration_armory_cache_none'] = 'Do not Cache Armory Data';
$phprlang['configuration_armory_link_text'] = '正確伺服器ARMORY連結';
$phprlang['configuration_armory_language_text'] = 'Armory語言碼';
$phprlang['configuration_extsys_bridge_config_header'] = 'Bridge Config';
$phprlang['configuration_extsys_norest'] = 'No Restrictions';
$phprlang['configuration_extsys_noaddus'] = 'No Additional UserGroup';
$phprlang['configuration_extsys_group01'] = 'Select the base user group that has access to use WRM';
$phprlang['configuration_extsys_group02'] = 'Any user without this group set will not be allowed to log in';
$phprlang['configuration_extsys_group03'] = 'Please select "No Restrictions" here if you want all users regardless of group to be able to login to WRM';
$phprlang['configuration_extsys_alt_group01'] = 'Select an Additional user group/class that can access WRM';
$phprlang['configuration_extsys_alt_group02'] = 'Any user tagged with this group will be allowed to log in regardless of whether they are in the above user group or not';
$phprlang['configuration_extsys_group_text'] = 'Base User group';
$phprlang['configuration_extsys_alt_group_text'] = 'Additional user group';

// Text on the "User Settings" Page.
$phprlang['configuration_multiple'] = '允許多重報名';
$phprlang['configuration_anonymous'] = '允許遊客瀏覽';
$phprlang['configuration_resop'] = '使韌性成為非必須選項';

// Text on the "Signup Rights" Page.
$phprlang['configuration_raid_signupgroups_header'] = 'Raid Permission Groups';
$phprlang['configuration_cancel'] = '取消';
$phprlang['configuration_cancel_def'] = '取消 = 將使用者移動至取消區域';
$phprlang['configuration_cancelled'] = '取消狀態';
$phprlang['configuration_comments'] = '建議';
$phprlang['configuration_comments_def'] = '建議 = 允許使用者編輯建議';
$phprlang['configuration_delete'] = '刪除';
$phprlang['configuration_delete_def'] = '刪除 = 完全移除使用者登記';
$phprlang['configuration_draft_def'] = '參加 = 將使用者放置於參予團隊區';
$phprlang['configuration_draft'] = '參加';
$phprlang['configuration_drafted'] = '參加 (已列入團隊)';
$phprlang['configuration_on_queue'] = '後補中';
$phprlang['configuration_queue'] = '後補';
$phprlang['configuration_queue_def'] = '候補 = 將使用者放置於候補區';
$phprlang['configuration_signup_rights_header'] = '報名權限';
$phprlang['configuraiton_admin'] = '管理者';
$phprlang['configuration_raidlead'] = '團隊指揮';

// Text on the "Raid Settings" Page.
$phprlang['configuration_raid_settings_header'] = '團隊設定';
$phprlang['configuration_raid_view_type_text'] = 'Select Raid View Type';
$phprlang['configuration_raid_view_type_class'] = 'Display Raid View By Class';
$phprlang['configuration_raid_view_type_role'] = 'Display Raid View By Role';
$phprlang['configuration_role_limit_text'] = '強制團隊職責限制';
$phprlang['configuration_class_limit_text'] = '強制團隊職業數量限制';
$phprlang['configuration_class_as_min'] = '各職業限制最少數量';
$phprlang['configuration_freeze'] = '關閉報名至檢查時間';


$phprlang['configuration_description'] = '描述';
$phprlang['configuration_default'] = '預設群組';
$phprlang['configuration_faction'] = '陣營';
$phprlang['configuration_guild_header'] = '公會設定';
$phprlang['configuration_guild_name'] = '名稱';
$phprlang['configuration_id'] = '在列表中顯示ID';
$phprlang['configuration_server'] = '伺服器';
$phprlang['configuration_site_header'] = '網站設定';
$phprlang['configuration_user'] = '使用者';
$phprlang['configuration_user_rights_header'] = '使用者權限';

// multiple use
$phprlang['configuration_autoqueue'] = '報名時自動進入候補';
