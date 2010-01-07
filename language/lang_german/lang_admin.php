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
$phprlang['configuration_admin_email'] = 'Administrator-E-Mail';
$phprlang['configuration_debug'] = 'Debugmodus';
$phprlang['configuration_disable'] = 'WRM deaktivieren';
$phprlang['configuration_email_header'] = 'E-Mail-Konfiguration';
$phprlang['configuration_email_sig'] = 'E-Mail-Signatur';
$phprlang['configuration_enable_five_man'] = 'Gruppen aktivieren<br><a href="../docs/enable_groups.htm" target="_blank">Hilfe?</a>';
$phprlang['configuration_language'] = 'Sprache';
$phprlang['configuration_logo'] = 'Pfad zum Logo';
$phprlang['configuration_register_text'] = 'Registrierungs-URL';
$phprlang['configuration_show_addon'] = 'Addon-Link zeigen';
$phprlang['configuration_sitelink'] = 'Link zur "Gildenseite"';
$phprlang['configuration_template'] = 'Vorlage';
$phprlang['general_configuration_header'] = 'General Settings';

// Text on the "Time Config" Page
$phprlang['configuration_ampm'] = '24-Stunden-Format verwenden';
$phprlang['configuration_date'] = 'Datumsformat<br><a href="http://de.php.net/date/" target="_blank">Hilfe?</a>';
$phprlang['configuration_dst_text'] = 'Sommerzeit?';
$phprlang['configuration_time'] = 'Zeitformat<br><a href="http://www.php.net/date/" target="_blank">Hilfe?</a>';
$phprlang['configuration_timezone_text'] = 'Zeitzone';
$phprlang['time_header'] = 'Time Configuration';


$phprlang['configuraiton_admin'] = 'Administrator';
$phprlang['configuration_anonymous'] = 'Anonymes Betrachten erlauben';
$phprlang['configuration_armory_enable'] = 'Arsenal-Hints aktivieren';
$phprlang['configuration_armory_link_text'] = 'Genauer Arsenal-Link für den Server';
$phprlang['configuration_armory_language_text'] = 'Sprach-Code für Arsenal';
$phprlang['configuration_autoqueue'] = 'Anmeldungen nur in Warteschlange erlauben';
$phprlang['configuration_cancel'] = 'Abbrechen';
$phprlang['configuration_cancel_def'] = 'Abbrechen = Benutzer in Bereich der abgebrochenen Anmeldungen platzieren';
$phprlang['configuration_cancelled'] = 'Abgebrochen';
$phprlang['configuration_comments'] = 'Kommentare';
$phprlang['configuration_comments_def'] = 'Kommentare = Benutzern erlauben, ihre Kommentare zu bearbeiten';
$phprlang['configuration_description'] = 'Beschreibung';
$phprlang['configuration_default'] = 'Standardgruppe';
$phprlang['configuration_delete'] = 'Löschen';
$phprlang['configuration_delete_def'] = 'Löschen = Benutzer aus der Anmeldung komplett entfernen';
$phprlang['configuration_draft'] = 'Anmelden';
$phprlang['configuration_draft_def'] = 'Anmelden = Benutzer in den Bereich der Anmeldungen platzieren';
$phprlang['configuration_drafted'] = 'Bestätigt';
$phprlang['configuration_eqdkp_integration_text'] = 'Integration in EqDKP<br><a href="../docs/eqdkp_link.htm" target="_blank">Hilfe?</a>';
$phprlang['configuration_eqdkp_link'] = 'URL zur Basis der EqDKP-Installation (ohne abschließenden /)';
$phprlang['configuration_external_links_header'] = 'Integration in externe Systeme';
$phprlang['configuration_faction'] = 'Fraktion';
$phprlang['configuration_freeze'] = 'Prüfung auf eingefrorene Raids ausschalten';
$phprlang['configuration_guild_header'] = 'Gildenkonfiguration';
$phprlang['configuration_guild_name'] = 'Name';
$phprlang['configuration_id'] = 'IDs in den Tabellen anzeigen';
$phprlang['configuration_multiple'] = 'Mehrfachanmeldungen erlauben';
$phprlang['configuration_on_queue'] = 'in Warteschlange';
$phprlang['configuration_queue'] = 'Warteschlange';
$phprlang['configuration_queue_def'] = 'Warteschlange = Benutzer in Warteschlange platzieren';
$phprlang['configuration_raid_settings_header'] = 'Raideinstellungen';
$phprlang['configuration_raid_view_type_text'] = 'Wähle die Anzeigeart der Raids';
$phprlang['configuration_raid_view_type_class'] = 'Zeige Raids nach Klassen';
$phprlang['configuration_raid_view_type_role'] = 'Zeige Raids nach Rollen';
$phprlang['configuration_raidlead'] = 'Raidleiter';
$phprlang['configuration_resop'] = 'Eingabe der Widerstände optional';
$phprlang['configuration_role_header'] = 'Konfiguration der Rollen';
$phprlang['configuration_role1_text'] = 'Rolle #1';
$phprlang['configuration_role2_text'] = 'Rolle #2';
$phprlang['configuration_role3_text'] = 'Rolle #3';
$phprlang['configuration_role4_text'] = 'Rolle #4';
$phprlang['configuration_role5_text'] = 'Rolle #5';
$phprlang['configuration_role6_text'] = 'Rolle #6';
$phprlang['configuration_role_limit_text'] = 'Erzwinge Rollen-Limit für Raids';
$phprlang['configuration_class_limit_text'] = 'Erzwinge Klassen-Limit für Raids';
$phprlang['configuration_class_as_min'] = 'Benutze Klassen-Limit als Minimum';
$phprlang['configuration_roster_text'] = 'In WoW-Gildendatenbank integrieren';
$phprlang['configuration_rss_site'] = 'RSS: URL zur WRM-Installation (ohne abschließenden /)';
$phprlang['configuration_rss_export'] = 'RSS: Seite des RSS-Feeds'; /* FIX */
$phprlang['configuration_rss_feed_amt'] = 'RSS: Anzahl der Raids, die im Feed angezeigt werden sollen';
$phprlang['configuration_server'] = 'Server';
$phprlang['configuration_signup_rights_header'] = 'Anmelderechte';
$phprlang['configuration_site_header'] = 'WRM-Konfiguration';
$phprlang['configuration_user'] = 'Benutzer';
$phprlang['configuration_user_rights_header'] = 'Benutzerrechte';
$phprlang['configuration_version_current'] = 'Du benutzt die aktuellste Version von WoW Raid Manager';
$phprlang['configuration_version_info_header'] = 'Version Information';
$phprlang['configuration_version_outdated_header'] = 'Eine neuere Version von WoW Raid Manager ist verfügbar!';
$phprlang['configuration_version_outdated_message'] = 'Deine Version von WoW Raid Manager ist nicht aktuell. Ein Update wird empfohlen.<br>
													   Die aktuellste Version ist %s, und du benutzt Version %s.<br>
													   Zum Herunterladen besuche bitte den <a href="http://www.wowraidmanager.net/">offiziellen WRM - Downloadbereich</a>.';

