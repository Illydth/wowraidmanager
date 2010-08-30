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
$phprlang['configuration_version_current'] = 'Du har nyaste versionen av WoW Raid Manager';
$phprlang['configuration_version_info_header'] = 'Versions Information';
$phprlang['configuration_version_outdated_header'] = 'WoW Raid Manager uppdatering tillgänglig!';
$phprlang['configuration_version_outdated_message'] = 'Din version av WoW Raid Manager är gammal. Du rekommenderas starkt att uppdatera.<br>
													   Den senaste versionen är %s och du använder för närvarande version %s.<br>
													   För att ladda ner, besök <a href="http://www.wowraidmanager.net">WoW Raid Manager</a>.';

// Text on the "General Config" Page
$phprlang['configuration_addon'] = 'Addon URL';
$phprlang['configuration_admin_email'] = 'Admin e-post';
$phprlang['configuration_debug'] = 'Debug mode';
$phprlang['configuration_disable'] = 'Avaktivera WoW Raid Manager';
$phprlang['configuration_email_header'] = 'E-post konfiguration';
$phprlang['configuration_email_sig'] = 'E-post signatur';
$phprlang['configuration_enable_five_man'] = 'Aktivera grupper<br><a href="../docs/enable_groups.htm" target="_blank">hjälp?</a>';
$phprlang['configuration_language'] = 'Språk';
$phprlang['configuration_logo'] = 'Sökväg till logo bild';
$phprlang['configuration_records_per_page'] = 'Records Per Data Table Page';
$phprlang['configuration_register_text'] = 'Registrerings URL';
$phprlang['configuration_rss_header'] = 'RSS Configuration';
$phprlang['configuration_rss_site'] = 'RSS: URL tilll WoW Raid Manager Installationen (Inget avslutande /)';
$phprlang['configuration_rss_export'] = 'RSS: sida att exportera RSS feed till';
$phprlang['configuration_rss_feed_amt'] = 'RSS: Antal raids som visas i feeden';
$phprlang['configuration_show_addon'] = 'Visa addon länk';
$phprlang['configuration_sitelink'] = '"Hem" länken pekar till';
$phprlang['configuration_template'] = 'Mall';
$phprlang['general_configuration_header'] = 'General Settings';
$phprlang['configuration_site_name'] = 'Site Name';
$phprlang['configuration_site_server'] = 'Site Server Name';
$phprlang['configuration_site_description'] = 'Site Description';
$phprlang['configuration_persistent_db'] = 'Create Persistant Database Connection?';

// Text on the "Time Config" Page
$phprlang['configuration_ampm'] = 'Planera raids i 12h/24h format';
$phprlang['configuration_date'] = 'Datum format<br><a href="http://www.php.net/date/" target="_blank">hjälp?</a>';
$phprlang['configuration_dst_text'] = 'Ändra för Sommar/Vinter tid?';
$phprlang['configuration_time'] = 'Tids format<br><a href="http://www.php.net/date/" target="_blank">hjälp?</a>';
$phprlang['configuration_timezone_text'] = 'Tidszone';
$phprlang['time_header'] = 'Time Configuration';

// Text on the "Role Configuration" Page.
$phprlang['configuration_role_header'] = 'Roll Konfigurering';
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
$phprlang['configuration_external_links_header'] = 'Integrera med externa system';
$phprlang['configuration_eqdkp_integration_text'] = 'Integrera med EqDKP<br><a href="../docs/eqdkp_link.htm" target="_blank">hjälp?</a>';
$phprlang['configuration_eqdkp_link'] = 'URL till er EqDKP installation (Inget avslutande /)';
$phprlang['configuration_roster_text'] = 'Integrera med WoW Roster';
$phprlang['configuration_armory_enable'] = 'Aktivera Armory uppslagning';
$phprlang['configuration_armory_cache_database'] = 'Database Table';
$phprlang['configuration_armory_cache_files'] = 'Files on Disk';
$phprlang['configuration_armory_cache_none'] = 'Do not Cache Armory Data';
$phprlang['configuration_armory_link_text'] = 'Korrekt Armory länk för Server';
$phprlang['configuration_armory_language_text'] = 'Språk kod för Armoryt';
$phprlang['configuration_extsys_bridge_config_header'] = 'Bridge Config';
$phprlang['configuration_extsys_norest'] = 'Inga Restriktioner';
$phprlang['configuration_extsys_noaddus'] = 'Inga Ytterliggare AnvÃ€ndargrupper';
$phprlang['configuration_extsys_group01'] = 'VÃ€lj grund gruppen/klassen som har tillgÃ¥ng attnyttja WRM';
$phprlang['configuration_extsys_group02'] = 'Alla anvÃ€ndare utan denna grupp kommer inte atttillÃ¥tas logga in';
$phprlang['configuration_extsys_group03'] = 'VÃ€nligen vÃ¶lj "Inga Restriktioner" hÃ€r om du vill att alla anvÃ€ndare oavsett grupp/klass skall kunna logga in och nyttja WRM';
$phprlang['configuration_extsys_alt_group01'] = 'VÃ€lj en alternativ grupp/klass som kan nyttja WRM';
$phprlang['configuration_extsys_alt_group02'] = 'Alla anvÃ€ndare i denna grupp kommer att tillÃ¥tas att logga in, oavsett om de Ã€r i ovanstÃ¥ende grupp/klass eller inte';
$phprlang['configuration_extsys_group_text'] = 'Base User group';
$phprlang['configuration_extsys_alt_group_text'] = 'Additional user group';

// Text on the "User Settings" Page.
$phprlang['configuration_multiple'] = 'Tillåt multipla bokningar från samma användare';
$phprlang['configuration_anonymous'] = 'Tillåt anonym insyn';
$phprlang['configuration_resop'] = 'Gör resistance valfritt';

// Text on the "Signup Rights" Page.
$phprlang['configuration_cancel'] = 'Avbryt';
$phprlang['configuration_cancel_def'] = 'Avbryt = Placera en användare bland avbokade';
$phprlang['configuration_cancelled'] = 'Avbokad status';
$phprlang['configuration_comments'] = 'Kommentarer';
$phprlang['configuration_comments_def'] = 'Kommentarer = Tillåt användare att editera sina kommentarer';
$phprlang['configuration_delete'] = 'Radera';
$phprlang['configuration_delete_def'] = 'Radera = Ta bort användares bokning helt';
$phprlang['configuration_draft_def'] = 'Uppflyttningt = Placera användaren i Raidet';
$phprlang['configuration_draft'] = 'Uppflyttning';
$phprlang['configuration_drafted'] = 'Uppflyttad (I Raidet)';
$phprlang['configuration_on_queue'] = 'I kö';
$phprlang['configuration_queue'] = 'Köa';
$phprlang['configuration_queue_def'] = 'Köa = Placera en användare i bokningskön';
$phprlang['configuration_signup_rights_header'] = 'Bokningsrättigheter';
$phprlang['configuraiton_admin'] = 'Administratör';
$phprlang['configuration_raidlead'] = 'Raid Ledare';

// Text on the "Raid Settings" Page.
$phprlang['configuration_raid_settings_header'] = 'Raid Inställningar';
$phprlang['configuration_raid_view_type_text'] = 'Select Raid View Type';
$phprlang['configuration_raid_view_type_class'] = 'Display Raid View By Class';
$phprlang['configuration_raid_view_type_role'] = 'Display Raid View By Role';
$phprlang['configuration_role_limit_text'] = 'Tvinga Roll begränsningar för Raids';
$phprlang['configuration_class_limit_text'] = 'Tvinga Klass begränsningar för Raids';
$phprlang['configuration_class_as_min'] = 'Använd Klass begränsningar som minimum';
$phprlang['configuration_freeze'] = 'Avaktivera frys kontroll';


$phprlang['configuration_description'] = 'Beskrivning';
$phprlang['configuration_default'] = 'Standard Grupp';
$phprlang['configuration_faction'] = 'Faktion';
$phprlang['configuration_guild_header'] = 'Guild Konfiguration';
$phprlang['configuration_guild_name'] = 'Namn';
$phprlang['configuration_id'] = 'Visa ID i tabeller';
$phprlang['configuration_server'] = 'Server';
$phprlang['configuration_site_header'] = 'Site Konfiguration';
$phprlang['configuration_user'] = 'Användare';
$phprlang['configuration_user_rights_header'] = 'Användar Rättigheter';

// multiple use
$phprlang['configuration_autoqueue'] = 'Förbjud bokning till uppflyttad status';
