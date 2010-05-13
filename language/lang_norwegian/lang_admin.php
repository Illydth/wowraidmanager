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
$phprlang['configuration_addon'] = 'Sito ufficiale di WowRaidManager';
$phprlang['configuration_admin_email'] = 'E-mail dell\'Amministratore';
$phprlang['configuration_debug'] = 'Modalità debug';
$phprlang['configuration_disable'] = 'Disabilita WowRaidManager';
$phprlang['configuration_email_header'] = 'Configurazione dell\'e-mail';
$phprlang['configuration_email_sig'] = 'Firma dell\'e-mail';
$phprlang['configuration_enable_five_man'] = 'Abilita i Gruppi<br><a href="../docs/enable_groups.htm" target="_blank">(Guida)</a>';
$phprlang['configuration_language'] = 'Lingua';
$phprlang['configuration_logo'] = 'Immagine di intestazione';
$phprlang['configuration_register_text'] = 'Indirizzo di registrazione';
$phprlang['configuration_show_addon'] = 'Visualizza link a WRM';
$phprlang['configuration_sitelink'] = 'Il link "Homepage" punta a';
$phprlang['configuration_template'] = 'Tema visuale';
$phprlang['general_configuration_header'] = 'General Settings';

// Text on the "Time Config" Page
$phprlang['configuration_ampm'] = 'Formato orario di creazione dei Raid';
$phprlang['configuration_date'] = 'Formato delle date<br><a href="http://www.php.net/date/" target="_blank">(Guida)</a>';
$phprlang['configuration_dst_text'] = 'Ora legale?';
$phprlang['configuration_time'] = 'Formato degli orari<br><a href="http://www.php.net/date/" target="_blank">(Guida)</a>';
$phprlang['configuration_timezone_text'] = 'Fuso orario';
$phprlang['time_header'] = 'Time Configuration';

$phprlang['configuraiton_admin'] = 'Amministratori';
$phprlang['configuration_anonymous'] = 'Consenti la visualizzazione agli Utenti non registrati';
$phprlang['configuration_armory_enable'] = 'Abilita l\'integrazione con l\'Armory';
$phprlang['configuration_armory_link_text'] = 'Indirizzo dell\'Armory';
$phprlang['configuration_armory_language_text'] = 'Codice linguaggio dell\'Armory';
$phprlang['configuration_autoqueue'] = 'Impedisci l\'inserimento diretto fra le iscrizioni confermate';
$phprlang['configuration_cancel'] = 'Annulla';
$phprlang['configuration_cancel_def'] = 'Annulla = Consenti l\'inserimento fra le iscrizioni annullate';
$phprlang['configuration_cancelled'] = 'Iscrizioni annullate';
$phprlang['configuration_comments'] = 'Commenti';
$phprlang['configuration_comments_def'] = 'Commenti = Consenti la modifica dei commenti';
$phprlang['configuration_description'] = 'Descrizione';
$phprlang['configuration_default'] = 'Profilo Utente predefinito';
$phprlang['configuration_delete'] = 'Elimina';
$phprlang['configuration_delete_def'] = 'Elimina = Consenti l\'eliminazione delle iscrizioni';
$phprlang['configuration_draft'] = 'Conferma';
$phprlang['configuration_draft_def'] = 'Conferma = Consenti l\'inserimento fra le iscrizioni confermate';
$phprlang['configuration_drafted'] = 'Iscrizioni confermate';
$phprlang['configuration_eqdkp_integration_text'] = 'Integra con EqDKP<br><a href="../docs/eqdkp_link.htm" target="_blank">(Guida)</a>';
$phprlang['configuration_eqdkp_link'] = 'Indirizzo base dell\'installazione di EqDKP (senza barra finale)';
$phprlang['configuration_external_links_header'] = 'Integrazione con sistemi esterni';
$phprlang['configuration_faction'] = 'Fazione';
$phprlang['configuration_freeze'] = 'Disabilita la chiusura delle iscrizioni';
$phprlang['configuration_guild_header'] = 'Configurazione della Gilda';
$phprlang['configuration_guild_name'] = 'Nome';
$phprlang['configuration_id'] = 'Visualizza l\'ID nelle tabelle';
$phprlang['configuration_multiple'] = 'Consenti iscrizioni multiple';
$phprlang['configuration_on_queue'] = 'Iscrizioni in coda';
$phprlang['configuration_queue'] = 'Accoda';
$phprlang['configuration_queue_def'] = 'Accoda = Consenti l\'inserimento fra le iscrizioni in coda';
$phprlang['configuration_raid_settings_header'] = 'Impostazioni inerenti i Raid';
$phprlang['configuration_raid_view_type_text'] = 'Visualizzazione Raid';
$phprlang['configuration_raid_view_type_class'] = 'Visualizzazione Raid per classe';
$phprlang['configuration_raid_view_type_role'] = 'Visualizzazione Raid per ruolo';
$phprlang['configuration_raidlead'] = 'Gestori Raid';
$phprlang['configuration_resop'] = 'Rendi opzionali i dati delle resistenze';
$phprlang['configuration_role_header'] = 'Configurazione dei ruoli';
$phprlang['configuration_role1_text'] = 'Ruolo #1';
$phprlang['configuration_role2_text'] = 'Ruolo #2';
$phprlang['configuration_role3_text'] = 'Ruolo #3';
$phprlang['configuration_role4_text'] = 'Ruolo #4';
$phprlang['configuration_role5_text'] = 'Ruolo #5';
$phprlang['configuration_role6_text'] = 'Ruolo #6';
$phprlang['configuration_role_limit_text'] = 'Imponi i limiti sui ruoli';
$phprlang['configuration_class_limit_text'] = 'Imponi i limiti sulle classi';
$phprlang['configuration_class_as_min'] = 'Considera i limiti sulle classi come limiti minimi';
$phprlang['configuration_roster_text'] = 'Integra con WoW Roster';
$phprlang['configuration_rss_site'] = 'RSS: indirizzo di installazione di WowRaidManager (senza barra finale)';
$phprlang['configuration_rss_export'] = 'RSS: indirizzo a cui esportare il feed RSS';
$phprlang['configuration_rss_feed_amt'] = 'RSS: numero di Raid da visualizzare';
$phprlang['configuration_server'] = 'Server';
$phprlang['configuration_signup_rights_header'] = 'Permessi di iscrizione';
$phprlang['configuration_site_header'] = 'Configurazione del sito';
$phprlang['configuration_user'] = 'Utenti';
$phprlang['configuration_user_rights_header'] = 'Permessi degli Utenti';
$phprlang['configuration_version_current'] = 'Si sta utilizzando l\'ultima versione di WowRaidManager';
$phprlang['configuration_version_info_header'] = 'Informazioni sulla versione di WRM';
$phprlang['configuration_version_outdated_header'] = 'E\' disponibile una nuova versione di WowRaidManager!';
$phprlang['configuration_version_outdated_message'] = 'La versione in uso di WowRaidManager non è l\'ultima disponibile: si consiglia vivamente di aggiornarla.<br>
													   L\'ultima versione è %s, mentre quella in uso è %s.<br>
													   Per scaricare l\'ultima versione, fare riferimento all\'area Download di <a href="http://www.wowraidmanager.net">WowRaidManager.net</a>.';
