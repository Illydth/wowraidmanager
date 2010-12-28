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
$phprlang['gen_conf_menu_header'] = 'Allgemeine Konf.';
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
$phprlang['admin_general_config'] = '&raquo; WRM Konfig.';
$phprlang['admin_general_rss_cfg'] = '&raquo; RSS Configuration';
$phprlang['admin_general_email_cfg'] = '&raquo; E-mail Configuration';
$phprlang['admin_time_config'] = '&raquo; Time Settings';
$phprlang['admin_raid_settings'] = '&raquo; Raid Settings';
$phprlang['admin_external_config'] = '&raquo; External Systems';
$phprlang['admin_game_settings'] = '&raquo; Game Settings';
$phprlang['admin_roletalent_config'] = '&raquo; Link Class/Role/Talent';
$phprlang['admin_style_conf'] = '&raquo; Template Config';
$phprlang['admin_menubar_mgt_link'] = '&raquo; Menu Bar Settings';
$phprlang['admin_general_lua_output_cfg'] = '&raquo; LUA Output Settings'; //New

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
$phprlang['db_name_text'] = 'Datenbank Name:';
$phprlang['db_host_text'] = 'Datenbank HostName:';
$phprlang['db_user_text'] = 'Datenbank Benutzername:';
$phprlang['db_prefix_text'] = 'Datenbank Table Prefix:';
$phprlang['db_size_text'] = 'Datenbank Grösse (Nur WRM Tabellen):';
$phprlang['php_version_text'] = 'PHP Version:';
$phprlang['mysql_version_text'] = 'MySQL Version:';
$phprlang['user_count_text'] = 'Anzahl der Benutzer:';
$phprlang['wrm_db_ver_text'] = 'WRM Datenbank Version:';
$phprlang['recent_logins_header'] = 'Recent Logins:';
$phprlang['recent_logins_explanation'] = 'These are the users who have used the WRM software within the last 5 minutes.';
$phprlang['inactive_logins_header'] = 'Inactive Logins:';
$phprlang['inactive_login_explanation'] = 'These are the last 10 most recent users to fall into the "inactive" 
											category.<br>To see the full list of inactive users please see the 
											"User Administration" link in the Admin Section.';
$phprlang['logins_username_header'] = 'Benutzername';
$phprlang['logins_email_header'] = 'E-Mail';
$phprlang['logins_priv_header'] = 'Privledge Group';
$phprlang['logins_time_header'] = 'Letzter Login';
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
$phprlang['configuration_version_current'] = 'Du benutzt die aktuellste Version von WoW Raid Manager';
$phprlang['configuration_version_info_header'] = 'Version Information';
$phprlang['configuration_version_outdated_header'] = 'Eine neuere Version von WoW Raid Manager ist verfügbar!';
$phprlang['configuration_version_outdated_message'] = 'Deine Version von WoW Raid Manager ist nicht aktuell. Ein Update wird empfohlen.<br>
													   Die aktuellste Version ist %s, und du benutzt Version %s.<br>
													   Zum Herunterladen besuche bitte den <a href="http://www.wowraidmanager.net/">offiziellen WRM - Downloadbereich</a>.';

// Text on the "General Config" Page
$phprlang['configuration_debug'] = 'Debugmodus';
$phprlang['configuration_disable'] = 'WRM deaktivieren';
$phprlang['configuration_enable_five_man'] = 'Gruppen aktivieren<br><a href="../docs/enable_groups.htm" target="_blank">Hilfe?</a>';
$phprlang['configuration_language'] = 'Sprache';
$phprlang['configuration_records_per_page'] = 'Records Per Data Table Page';
$phprlang['configuration_persistent_db'] = 'Create Persistant Database Connection?';
$phprlang['general_configuration_header'] = 'Allgemeine Einstellungen';
$phprlang['configuration_old_raids_index'] = 'Number of Old Raids to Show on the Index Page';

$phprlang['general_side_cfg_header'] = 'Side Config';
$phprlang['configuration_site_name'] = 'Seite Name';
$phprlang['configuration_site_server'] = 'Seite Server Name';
$phprlang['configuration_site_description'] = 'Seite Beschreibung';

$phprlang['configuration_admin_email'] = 'Administrator-E-Mail';
$phprlang['configuration_email_header'] = 'E-Mail-Konfiguration';
$phprlang['configuration_email_sig'] = 'E-Mail-Signatur';

$phprlang['configuration_rss_header'] = 'RSS Einstellungen';
$phprlang['configuration_rss_site'] = 'RSS: URL zur WRM-Installation (ohne abschließenden /)';
$phprlang['configuration_rss_export'] = 'RSS: Seite des RSS-Feeds';
$phprlang['configuration_rss_feed_amt'] = 'RSS: Anzahl der Raids, die im Feed angezeigt werden sollen';

// Text on the "Style Config" Page
$phprlang['style_menu_header'] = 'Style Config';
$phprlang['configuration_template_cfg_header'] = 'Template Config';
$phprlang['configuration_logo'] = 'Pfad zum Logo';
$phprlang['configuration_sitelink'] = 'Link zur "Gildenseite"';
$phprlang['configuration_template'] = 'Vorlage';
$phprlang['configuration_addon'] = 'Addon URL';
$phprlang['configuration_show_addon'] = 'Addon-Link zeigen';
$phprlang['configuration_register_text'] = 'Registrierungs-URL';


// Text on the "Time Config" Page
$phprlang['configuration_ampm'] = '24-Stunden-Format verwenden';
$phprlang['configuration_date'] = 'Datumsformat<br><a href="http://de.php.net/date/" target="_blank">Hilfe?</a>';
$phprlang['configuration_dst_text'] = 'Sommerzeit?';
$phprlang['configuration_time'] = 'Zeitformat<br><a href="http://www.php.net/date/" target="_blank">Hilfe?</a>';
$phprlang['configuration_timezone_text'] = 'Zeitzone';
$phprlang['time_header'] = 'Zeit/Datum Einstellungen';

// Text on the "Game Settings" Page.
$phprlang['configuration_game_header'] = 'Game Settings';
$phprlang['configuration_game_select_addon'] = 'select Addon';

// Text on the "Role Configuration" Page.
$phprlang['configuration_role_header'] = 'Konfiguration der Rollen';
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
$phprlang['configuration_external_links_header'] = 'Integration in externe Systeme';
$phprlang['configuration_eqdkp_integration_text'] = 'Integration in EqDKP<br><a href="../docs/eqdkp_link.htm" target="_blank">Hilfe?</a>';
$phprlang['configuration_eqdkp_link'] = 'URL zur Basis der EqDKP-Installation (ohne abschließenden /)';
$phprlang['configuration_roster_text'] = 'In WoW-Gildendatenbank integrieren';
$phprlang['configuration_armory_enable'] = 'Enable Armory Lookups';
$phprlang['configuration_armory_cache_database'] = 'Database Table';
$phprlang['configuration_armory_cache_files'] = 'Files on Disk';
$phprlang['configuration_armory_cache_none'] = 'Do not Cache Armory Data';
$phprlang['configuration_armory_link_text'] = 'Genauer Arsenal-Link für den Server';
$phprlang['configuration_armory_language_text'] = 'Sprach-Code für Arsenal';
$phprlang['configuration_extsys_bridge_config_header'] = 'Bridge Konfiguration';
$phprlang['configuration_extsys_norest'] = 'Keine Einschränkung';
$phprlang['configuration_extsys_noaddus'] = 'Keine zusätzlichen Benutzergruppe';
$phprlang['configuration_extsys_group01'] = 'Wähle die Basis Benutzergruppe aus, welche Zugang zur Nutzung von WRM hat';
$phprlang['configuration_extsys_group02'] = 'Benutzer die nicht in dieser Benutzergruppe sind, ist es auch nicht möglich, sich anzumelden';
$phprlang['configuration_extsys_group03'] = 'Wenn du willst, dass alle Benutzer unabhängig von der Benutzergruppe sich im WRM anmelden können, wähle "Keine Einschränkung" aus.';
$phprlang['configuration_extsys_alt_group01'] = 'Wähle eine alternative Benutzergruppe aus, welcher den Zugang zu WRM auch erlaubt ist';
$phprlang['configuration_extsys_alt_group02'] = 'mit dieser alternativen Gruppe ist es dem Benutzer auch möglich, sich unabhängig davon anzumelden, ob sie in der oben genannten Benutzergruppe sind oder nicht ';
$phprlang['configuration_extsys_group_text'] = 'Basis Benutzergruppe';
$phprlang['configuration_extsys_alt_group_text'] = 'alternative Benutzergruppe';

// Text on the "User Settings" Page.
$phprlang['configuration_multiple'] = 'Mehrfachanmeldungen erlauben';
$phprlang['configuration_anonymous'] = 'Anonymes Betrachten erlauben';
$phprlang['configuration_resop'] = 'Eingabe der Widerstände optional';

// Text on the "Signup Rights" Page.
$phprlang['configuration_raid_signupgroups_header'] = 'Raid Permission Groups';
$phprlang['configuration_cancel'] = 'Abbrechen';
$phprlang['configuration_cancel_def'] = 'Abbrechen = Benutzer in Bereich der abgebrochenen Anmeldungen platzieren';
$phprlang['configuration_cancelled'] = 'Abgebrochen';
$phprlang['configuration_comments'] = 'Kommentare';
$phprlang['configuration_comments_def'] = 'Kommentare = Benutzern erlauben, ihre Kommentare zu bearbeiten';
$phprlang['configuration_delete'] = 'Löschen';
$phprlang['configuration_delete_def'] = 'Löschen = Benutzer aus der Anmeldung komplett entfernen';
$phprlang['configuration_draft'] = 'Anmelden';
$phprlang['configuration_draft_def'] = 'Anmelden = Benutzer in den Bereich der Anmeldungen platzieren';
$phprlang['configuration_drafted'] = 'Bestätigt';
$phprlang['configuration_on_queue'] = 'in Warteschlange';
$phprlang['configuration_queue'] = 'Warteschlange';
$phprlang['configuration_queue_def'] = 'Warteschlange = Benutzer in Warteschlange platzieren';
$phprlang['configuration_signup_rights_header'] = 'Anmelderechte';
$phprlang['configuraiton_admin'] = 'Administrator';
$phprlang['configuration_raidlead'] = 'Raidleiter';

// Text on the "Raid Settings" Page.
$phprlang['configuration_raid_settings_header'] = 'Raideinstellungen';
$phprlang['configuration_raid_view_type_text'] = 'Wähle die Anzeigeart der Raids';
$phprlang['configuration_raid_view_type_class'] = 'Zeige Raids nach Klassen';
$phprlang['configuration_raid_view_type_role'] = 'Zeige Raids nach Rollen';
$phprlang['configuration_role_limit_text'] = 'Erzwinge Rollen-Limit für Raids';
$phprlang['configuration_class_limit_text'] = 'Erzwinge Klassen-Limit für Raids';
$phprlang['configuration_class_as_min'] = 'Benutze Klassen-Limit als Minimum';
$phprlang['configuration_freeze'] = 'Prüfung auf eingefrorene Raids ausschalten';


$phprlang['configuration_description'] = 'Beschreibung';
$phprlang['configuration_default'] = 'Standardgruppe';
$phprlang['configuration_faction'] = 'Fraktion';
$phprlang['configuration_guild_header'] = 'Gildenkonfiguration';
$phprlang['configuration_guild_name'] = 'Name';
$phprlang['configuration_id'] = 'IDs in den Tabellen anzeigen';
$phprlang['configuration_server'] = 'Server';
$phprlang['configuration_site_header'] = 'WRM-Konfiguration';
$phprlang['configuration_user'] = 'Benutzer';
$phprlang['configuration_user_rights_header'] = 'Benutzerrechte';

// multiple use
$phprlang['configuration_autoqueue'] = 'Anmeldungen nur in Warteschlange erlauben';

?>