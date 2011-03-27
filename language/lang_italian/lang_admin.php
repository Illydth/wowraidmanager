<?php
/***************************************************************************
 *                           lang_admin.php (italian)
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
$phprlang['admin_general_rss_cfg'] = '&raquo; RSS Configuration';
$phprlang['admin_general_email_cfg'] = '&raquo; Configurazione dell\'e-mail';
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
$phprlang['delete_armory_cache_text'] = 'Delete WOW Armory Cache Information';
$phprlang['delete_armory_log_text'] = 'Delete the WoW Armory Output Logs';
$phprlang['delete_template_cache_text'] = 'Delete the WRM Application Template Cache Files.';
$phprlang['actions_header'] = 'Board Cache/Log Actions:';
$phprlang['actions_explanation'] = 'The buttons below purge the various cache and log files associated with WRM.';
$phprlang['configuration_version_current'] = 'Si sta utilizzando l\'ultima versione di WowRaidManager';
$phprlang['configuration_version_info_header'] = 'Informazioni sulla versione di WRM';
$phprlang['configuration_version_outdated_header'] = 'E\' disponibile una nuova versione di WowRaidManager!';
$phprlang['configuration_version_outdated_message'] = 'La versione in uso di WowRaidManager non è l\'ultima disponibile: si consiglia vivamente di aggiornarla.<br>
													   L\'ultima versione è %s, mentre quella in uso è %s.<br>
													   Per scaricare l\'ultima versione, fare riferimento all\'area Download di <a href="http://www.wowraidmanager.net">WowRaidManager.net</a>.';

// Text on the "General Config" Page
$phprlang['configuration_debug'] = 'Modalità debug';
$phprlang['configuration_disable'] = 'Disabilita WowRaidManager';
$phprlang['configuration_enable_five_man'] = 'Abilita i Gruppi<br><a href="../docs/enable_groups.htm" target="_blank">(Guida)</a>';
$phprlang['configuration_language'] = 'Lingua';
$phprlang['configuration_records_per_page'] = 'Records Per Data Table Page';
$phprlang['configuration_persistent_db'] = 'Create Persistant Database Connection?';
$phprlang['general_configuration_header'] = 'General Settings';
$phprlang['configuration_old_raids_index'] = 'Number of Old Raids to Show on the Index Page';
$phprlang['auto_mark_raids_old'] = 'Auto Mark Raids Old (Hours)'; //New

$phprlang['general_side_cfg_header'] = 'Side Config';
$phprlang['configuration_site_name'] = 'Site Name';
$phprlang['configuration_site_server'] = 'Site Server Name';
$phprlang['configuration_site_description'] = 'Site Description';

$phprlang['configuration_admin_email'] = 'E-mail dell\'Amministratore';
$phprlang['configuration_email_header'] = 'Configurazione dell\'e-mail';
$phprlang['configuration_email_sig'] = 'Firma dell\'e-mail';

$phprlang['configuration_rss_header'] = 'RSS Configuration';
$phprlang['configuration_rss_site'] = 'RSS: indirizzo di installazione di WowRaidManager (senza barra finale)';
$phprlang['configuration_rss_export'] = 'RSS: indirizzo a cui esportare il feed RSS';
$phprlang['configuration_rss_feed_amt'] = 'RSS: numero di Raid da visualizzare';

// Text on the "Style Config" Page
$phprlang['style_menu_header'] = 'Style Config';
$phprlang['configuration_template_cfg_header'] = 'Template Config';
$phprlang['configuration_template_width_text'] = "Template Width";
$phprlang['configuration_width_normal'] = "normal";
$phprlang['configuration_width_expanded'] = "expanded";
$phprlang['configuration_logo'] = 'Immagine di intestazione';
$phprlang['configuration_sitelink'] = 'Il link "Homepage" punta a';
$phprlang['configuration_template'] = 'Tema visuale';
$phprlang['configuration_addon'] = 'Sito ufficiale di WowRaidManager';
$phprlang['configuration_show_addon'] = 'Visualizza link a WRM';
$phprlang['configuration_register_text'] = 'Indirizzo di registrazione';

// Text on the "Time Config" Page
$phprlang['configuration_ampm'] = 'Formato orario di creazione dei Raid';
$phprlang['configuration_date'] = 'Formato delle date<br><a href="http://www.php.net/date/" target="_blank">(Guida)</a>';
$phprlang['configuration_dst_text'] = 'Ora legale?';
$phprlang['configuration_time'] = 'Formato degli orari<br><a href="http://www.php.net/date/" target="_blank">(Guida)</a>';
$phprlang['configuration_timezone_text'] = 'Fuso orario';
$phprlang['time_header'] = 'Time Configuration';

// Text on the "Game Settings" Page.
$phprlang['configuration_game_header'] = 'Game Settings';
$phprlang['configuration_game_select_addon'] = 'select Addon';

// Text on the "Role Configuration" Page.
$phprlang['configuration_role_header'] = 'Configurazione dei ruoli';
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
$phprlang['configuration_external_links_header'] = 'Integrazione con sistemi esterni';
$phprlang['configuration_eqdkp_integration_text'] = 'Integra con EqDKP<br><a href="../docs/eqdkp_link.htm" target="_blank">(Guida)</a>';
$phprlang['configuration_eqdkp_link'] = 'Indirizzo base dell\'installazione di EqDKP (senza barra finale)';
$phprlang['configuration_roster_text'] = 'Integra con WoW Roster';
$phprlang['configuration_armory_enable'] = 'Abilita l\'integrazione con l\'Armory';
$phprlang['configuration_armory_cache_database'] = 'Database Table';
$phprlang['configuration_armory_cache_files'] = 'Files on Disk';
$phprlang['configuration_armory_cache_none'] = 'Do not Cache Armory Data';
$phprlang['configuration_armory_link_text'] = 'Indirizzo dell\'Armory';
$phprlang['configuration_armory_language_text'] = 'Codice linguaggio dell\'Armory';
$phprlang['configuration_extsys_bridge_config_header'] = 'Bridge Config';
$phprlang['configuration_extsys_norest'] = 'Nessuna restrizione';
$phprlang['configuration_extsys_noaddus'] = 'Nessun altro gruppo';
$phprlang['configuration_extsys_group01'] = 'Seleziona il gruppo base di Utenti ai quali consentire l\'accesso a WRM';
$phprlang['configuration_extsys_group02'] = 'Gli Utenti al di fuori di questo gruppo non avranno accesso a WRM';
$phprlang['configuration_extsys_group03'] = 'Seleziona "Nessuna restrizione" per consentire l\'accesso a WRM a tutti gli Utenti indipendentemente dai gruppi di appartenenza';
$phprlang['configuration_extsys_alt_group01'] = 'Seleziona un ulteriore gruppo di Utenti ai quali consentire l\'accesso a WRM';
$phprlang['configuration_extsys_alt_group02'] = 'Agli Utenti appartenenti a questo gruppo sarà consentito l\'accesso a WRM indipendentemente dall\'appartenenza anche all\'altro gruppo specificato';
$phprlang['configuration_extsys_group_text'] = 'Base User group';
$phprlang['configuration_extsys_alt_group_text'] = 'Additional user group';
$phprlang['configuration_armory_cache_timeout'] = 'Armory Cache Lifetime (In Hours)'; //New
$phprlang['configuration_armory_cache_timeout_sup'] = 'After the Cache Lifetime expires, WRM will go back to the Armory to re-pull data.  The shorter the cache<br>' . 
													' the "fresher" the data WRM will have in it\'s popup, but the slower WRM will run due to pulling data from<br>' . 
													' the armory URL more often.  The longer the cache value, the less "fresh" Armory data but the faster<br>' . 
													' WRM will run.'; //New

// Text on the "User Settings" Page.
$phprlang['configuration_multiple'] = 'Consenti iscrizioni multiple';
$phprlang['configuration_anonymous'] = 'Consenti la visualizzazione agli Utenti non registrati';
$phprlang['configuration_resop'] = 'Rendi opzionali i dati delle resistenze';

// Text on the "Signup Rights" Page.
$phprlang['configuration_raid_signupgroups_header'] = 'Raid Permission Groups';
$phprlang['configuration_cancel'] = 'Annulla';
$phprlang['configuration_cancel_def'] = 'Annulla = Consenti l\'inserimento fra le iscrizioni annullate';
$phprlang['configuration_cancelled'] = 'Iscrizioni annullate';
$phprlang['configuration_comments'] = 'Commenti';
$phprlang['configuration_comments_def'] = 'Commenti = Consenti la modifica dei commenti';
$phprlang['configuration_delete'] = 'Elimina';
$phprlang['configuration_delete_def'] = 'Elimina = Consenti l\'eliminazione delle iscrizioni';
$phprlang['configuration_draft'] = 'Conferma';
$phprlang['configuration_draft_def'] = 'Conferma = Consenti l\'inserimento fra le iscrizioni confermate';
$phprlang['configuration_drafted'] = 'Iscrizioni confermate';
$phprlang['configuration_on_queue'] = 'Iscrizioni in coda';
$phprlang['configuration_queue'] = 'Accoda';
$phprlang['configuration_queue_def'] = 'Accoda = Consenti l\'inserimento fra le iscrizioni in coda';
$phprlang['configuration_signup_rights_header'] = 'Permessi di iscrizione';
$phprlang['configuraiton_admin'] = 'Amministratori';
$phprlang['configuration_raidlead'] = 'Gestori Raid';

// Text on the "Raid Settings" Page.
$phprlang['configuration_raid_settings_header'] = 'Impostazioni inerenti i Raid';
$phprlang['configuration_raid_view_type_text'] = 'Visualizzazione Raid';
$phprlang['configuration_raid_view_type_class'] = 'Visualizzazione Raid per classe';
$phprlang['configuration_raid_view_type_role'] = 'Visualizzazione Raid per ruolo';
$phprlang['configuration_role_limit_text'] = 'Imponi i limiti sui ruoli';
$phprlang['configuration_class_limit_text'] = 'Imponi i limiti sulle classi';
$phprlang['configuration_class_as_min'] = 'Considera i limiti sulle classi come limiti minimi';
$phprlang['configuration_freeze'] = 'Disabilita la chiusura delle iscrizioni';
$phprlang['configuration_recurrance_enabled_text'] = 'Enable Recurring Raids System'; //New
$phprlang['configuration_freeze_status_draft'] = 'Stop changes to Drafted Raiders During Freeze';  //NEW
$phprlang['configuration_freeze_status_queue'] = 'Stop changes to Queued Raiders During Freeze';  //NEW
$phprlang['configuration_freeze_status_cancel'] = 'Stop changes to Cancelled Raiders During Freeze';  //NEW
$phprlang['configuration_description'] = 'Descrizione';
$phprlang['configuration_default'] = 'Profilo Utente predefinito';
$phprlang['configuration_faction'] = 'Fazione';
$phprlang['configuration_guild_header'] = 'Configurazione della Gilda';
$phprlang['configuration_guild_name'] = 'Nome';
$phprlang['configuration_id'] = 'Visualizza l\'ID nelle tabelle';
$phprlang['configuration_server'] = 'Server';
$phprlang['configuration_site_header'] = 'Configurazione del sito';
$phprlang['configuration_user'] = 'Utenti';
$phprlang['configuration_user_rights_header'] = 'Permessi degli Utenti';

// multiple use
$phprlang['configuration_autoqueue'] = 'Impedisci l\'inserimento diretto fra le iscrizioni confermate';

?>