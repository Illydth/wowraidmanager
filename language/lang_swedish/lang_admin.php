<?php
/***************************************************************************
 *                           lang_admin.php (swedish)
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
'admin_menu_header' =>  'Admin Meny',
'gen_conf_menu_header' =>  'Generell Konfig',
'user_mgt_menu_header' =>  'Användarhantering',
'table_conf_menu_header' =>  'Tabell Konfig',
'logs_menu_header' =>  'Loggar',

// Admin Main Menu Links
'admin_site_link' =>  '&raquo; Stäng Admin',
'admin_main_link' =>  '&raquo; Hem',
'admin_logs_link' =>  '&raquo; Loggar',
'admin_rolecfg_link' =>  '&raquo; Roll Konfiguration',
'admin_datatablecfg_link' =>  '&raquo; Hantera Datatabeller',
'admin_permissions' =>  '&raquo; WRM Rättighetsgrupper',
'admin_signup_rights' =>  '&raquo; Registrerings Aktivitet',
'admin_raid_signupgroups' =>  '&raquo; Raid Rättighetsgrupper',
'admin_user_settings' =>  '&raquo; Användarinställningar',
'admin_user_management' =>  '&raquo; Användarhantering',
'admin_general_config' =>  '&raquo; Allmänna Inställningar',
'admin_general_rss_cfg' =>  '&raquo; RSS Konfiguration',
'admin_general_email_cfg' =>  '&raquo; E-post Konfiguration',
'admin_time_config' =>  '&raquo; Tidsinställningar',
'admin_raid_settings' =>  '&raquo; Raid Inställningar',
'admin_external_config' =>  '&raquo; Externa System',
'admin_game_settings' =>  '&raquo; Spel Inställningar',
'admin_roletalent_config' =>  '&raquo; Länk Klass/Roll/Talent',
'admin_style_conf' =>  '&raquo; Tema Inställningar',
'admin_menubar_mgt_link' =>  '&raquo; Meny Inställningar',
'admin_general_lua_output_cfg' =>  '&raquo; LUA Output Inställningar', //New

// Link from Main Site to Admin
'admin_section_link' =>  'Administration',

// Text on the Main Index Page
'admin_index_header' =>  'WRM Administrativa Sektionen',
'admin_statistics_header' =>  'Statistik',
'wrm_statistics_header' =>  'WRM Statistik:',
'database_statistics_header' =>  'Databas Statistik:',
'admin_version_stat_text' =>  'WRM Version:',
'statistic' =>  'Statistik',
'value' =>  'Värde',
'db_name_text' =>  'Databas Namn:',
'db_host_text' =>  'Databas Värdnamn:',
'db_user_text' =>  'Databas Användarnamn:',
'db_prefix_text' =>  'Databas Tabell Prefix:',
'db_size_text' =>  'Databas Storlek (Endast WRM Tabeller):',
'php_version_text' =>  'PHP Version:',
'mysql_version_text' =>  'MySQL Version:',
'user_count_text' =>  'Antal Användare:',
'wrm_db_ver_text' =>  'WRM Databas Version:',
'recent_logins_header' =>  'Senaste Logins:',
'recent_logins_explanation' =>  'Dessa är de användare som har använt WRM under de senaste 5 minuterna.',
'inactive_logins_header' =>  'Inaktiva Logins:',
'inactive_login_explanation' =>  'Dessa är de senaste 10 senaste användare som hamnat i kategorin "inaktiv".
                                                            <br> vill du se hela listan med inaktiva användare se "Användarhantering"-länken i Admin avsnitt.',

'logins_username_header' =>  'Användarnamn',
'logins_email_header' =>  'E-post',
'logins_priv_header' =>  'Rättighetsgrupp',
'logins_time_header' =>  'Senaste login',
'kib' =>   'KiB',
'raid_stats_header' =>  'Raid Statistik:',
'raid_stats_explanation' =>  'Procentsatserna beräknas som det totala antalet uppskrivna användare för perioden<br>
										(Tillgängliga + Uttagna, Ej "Ej tillgängliga") dividerat med den totala maximala raiddeltagare för perioden.',
'raid_active_count_header' =>  'Aktiva Raids:',
'raid_total_count_header' =>  'Totala Raids:',
'raid_week_percent_header' =>  'Denna veckas närvaro i %:',
'raid_30d_percent_header' =>  'Närvaro senaste 30 dagar:',
'raid_3m_percent_header' =>  'Närvaro senaste 3 Månader:',
'raid_6m_percent_header' =>  'Närvaro senaste 6 Månader:',
'raid_1y_percent_header' =>  'Närvaro senaste 1 år:',
'raid_life_percent_header' =>  'Livstids närvaro i %:',
'logs_header' =>  'Senaste Intrångsförsök logg:',
'logs_explanation' =>  'De 10 senaste försök som identifierats som "Intrångsförsök" identifierade av systemet.',
'ip_header' =>  'IP Adress',
'message_header' =>  'Meddelande',
'timestamp_header' =>  'Datum/Tid',
'delete_board_cache_text' =>  'Radera Cache filer för WRM.',
'delete_armory_cache_text' =>  'Radera WOW Armory Cache Information',
'delete_armory_log_text' =>  'Radera WoW Armory Output Loggar',
'delete_template_cache_text' =>  'Radera WRM Applikations Tema Cache Filer.',
'actions_header' =>  'WRM Cache/Logg Händelser:',
'actions_explanation' =>  'Nedan knappar raderar cache eller logg filer assosierade med WRM.',
'configuration_version_current' =>  'Du har senaste versionen av WoW Raid Manager',
'configuration_version_info_header' =>  'Versions Information',
'configuration_version_outdated_header' =>  'En ny WoW Raid Manager uppdatering finns tillgänglig!',
'configuration_version_outdated_message' =>  'Din version av WoW Raid Manager är gammal. Du rekommenderas starkt att uppdatera.<br>
													   Den senaste versionen är %s och du använder för närvarande version %s.<br>
													   För att ladda ner, besök <a href="http://www.wowraidmanager.net">WoW Raid Manager</a>.',

// Text on the "General Config" Page
'configuration_debug' =>  'Debug-läge',
'configuration_disable' =>  'Avaktivera WoW Raid Manager',
'configuration_enable_five_man' =>  'Aktivera 5-manna grupper<br><a href="../docs/enable_groups.htm" target="_blank">hjälp?</a>',
'configuration_language' =>  'Språk',
'configuration_records_per_page' =>  'Poster per Datatabell sida',
'configuration_persistent_db' =>  'Använd Ihållande databasanslutning (Persistent Database Connection?',
'general_configuration_header' =>  'Generella Inställningar',
'configuration_old_raids_index' =>  'Antal gamla raids att visa på startsidan',
'auto_mark_raids_old' =>  'Automatiskt markera gamla raider (Timmar)', //New

'general_side_cfg_header' =>  'Webbplatsinställningar',
'configuration_site_name' =>  'Webbplatsens Namn',
'configuration_site_server' =>  'Webbplatsens Servernamn',
'configuration_site_description' =>  'Webbplatsens Beskrivning',

'configuration_admin_email' =>  'Admin e-post',
'configuration_email_header' =>  'E-post konfiguration',
'configuration_email_sig' =>  'E-post signatur',

'configuration_rss_header' =>  'RSS Konfiguration',
'configuration_rss_site' =>  'RSS: URL tilll WoW Raid Manager Installationen (Inget avslutande /)',
'configuration_rss_export' =>  'RSS: sida att exportera RSS feed till',
'configuration_rss_feed_amt' =>  'RSS: Antal raids som visas i feeden',

// Text on the "Style Config" Page
'style_menu_header' =>  'Layout Inställningar',
'configuration_template_cfg_header' =>  'Tema Inställningar',
'configuration_template_width_text' =>  "Temats Bredd",
'configuration_width_normal' =>  "normal",
'configuration_width_expanded' =>  "expanderad",
'configuration_logo' =>  'Sökväg till logo bild',
'configuration_sitelink' =>  '"Hem" länken pekar till',
'configuration_template' =>  'Áktivt Tema',
'configuration_addon' =>  'Addon URL',
'configuration_show_addon' =>  'Visa addon länk',
'configuration_register_text' =>  'Registrations URL',
'current_template_header_text' => 'current template',
'current_template_name_text' => 'template name',
'current_template_created_by_text' => 'created by',
'current_template_version_nr_text' => 'version',
'current_template_info_text' => 'info',
'available_templates_text' => 'available templates',
'active' => 'active',
		
// Text on the "Gamepack Config" Page
'gamepack_menu_header' => 'Gamepack',
'admin_gamepack_config' =>  '&raquo; Config',
'current_gamepack_header_text' => 'current Gamepack',
'current_gamepack_name_text' => 'Name',
'current_gamepack_created_by_text' => 'created by',
'current_gamepack_version_nr_text' => 'version',
'current_gamepack_info_text' => 'info',
'available_gamepack_text' => 'available gamepack',
		
// Text on the "Time Config" Page
'configuration_ampm' =>  'Planera raids i 12h/24h format',
'configuration_date' =>  'Datumformat<br><a href="http://www.php.net/date/" target="_blank">hjälp?</a>',
'configuration_dst_text' =>  'Ändra för Sommar/Vinter tid?',
'configuration_time' =>  'Tidsformat<br><a href="http://www.php.net/date/" target="_blank">hjälp?</a>',
'configuration_timezone_text' =>  'Tidszon',
'time_header' =>  'Tidsinställningar',

// Text on the "Game Settings" Page.
'configuration_game_header' =>  'Spelkonfiguration',
'configuration_game_select_addon' =>  'Välj Addon',

// Text on the "Role Configuration" Page.
'configuration_role_header' =>  'Roll Konfigurering',
'addrole' =>  'Lägg till Roll',
'updaterole' =>  'Updatera Roll',
'configuration_role_new_header' =>  'Lägg till en ny Roll',
'configuration_role_edit_header' =>  'Redigera en existerande Roll',
'role_error_exists' =>  'Roll ID existerar, Välj en annan.',
'role_error_role_name_blank' =>  'Rollnamn måste anges och kan ej vara tomt eller ett nollvärde.',
'role_error_role_config_blank' =>  'Roll Konfig Text måste anges och kan ej vara tomt eller ett nollvärde.',
'role_error_role_id_blank' =>  'Roll ID måste anges och kan ej vara tomt eller ett nollvärde.',

// Text on the "Link Class/Role/Talent" Page.
'configuration_roletalent_header' =>  'Klass/Roll/Talangträds Länkar',
'configuration_roletalent_new_header' =>  'Lägg till ny Klass/Roll/Talangträds länk',
'configuration_roletalent_edit_header' =>  'Redigera Klass/Roll/Talangträds länk',
'roletalent_duplicate_error' =>  'Duplicera Klass/Roll/Talangträds länk',
'roletalent_classid_blank_error' =>  'Klass ID måste anges och kan ej vara tomt eller ett nollvärde.',
'roletalent_talenttree_blank_error' =>  'Talangträdets namn måste anges och kan ej vara tomt eller ett nollvärde.',
'roletalent_displaytext_blank_error' =>  'Visningstextens Värde måste anges och kan ej vara tomt eller ett nollvärde.',
'roletalent_roleid_blank_error' =>  'Rollnamnet måste anges och kan ej vara tomt eller ett nollvärde',

// Text on the "Data Table Config" Page.
'configuration_datatable_header' =>  'Redigera Datatabell Information',
'configuration_datatable_view_select_text' =>  'Välj vy för att redigera: ',
'configuration_datatable_edit_header' =>  'Ändra egenskaper',
'configuration_datatable_column_name' =>  'Kolumnamn',
'configuration_datatable_visible' =>  'Synlig',
'configuration_datatable_position' =>  'Kolumn possition',
'configuration_datatable_image_url' =>  'Bild URL',
'configuration_datatable_default_sort' =>  'Sortera efter denna kolumn', 

// Text on the "User Administration" Page.
'configuration_users_modperm_header' =>  'Ändra de markerade användares Rättighetsgrupp',
'configuration_users_modperm_desc' =>  'För att ändra rättighetsgruppen för en användare gör följande:
                                                                                                                <br><ol><li>Markera kryssrutan i ovan tabell för den
                                                                                                                användares rättighetsgrupp du vill ändra på.</li>
                                                                                                                <li>Markera den nya rättighetsgruppen att tilldela
                                                                                                                användaren med från listrutan nedan</li>
                                                                                                                <li>Klicka på knappen skicka nedan.</li></ol><br>
                                                                                                                Rättighetsgruppen skall nu vara uppdaterade i
                                                                                                                användarlistan ovan till den valda nya gruppen',
'configuration_permission_cannot_modify' =>  'Du har försökt att radera rättighetsgruppen Admin
														från alla dina användare, detta skulle betyda att du inte
                                                                                                                kan administrera eller redigera ditt WRM system vilket
                                                                                                                inte är tillåtet <br><br>
                                                                                                                Vänligen uppdatera en användare med Admin rättigheter
                                                                                                                innan du försöker att ta bort admins från gruppen.
                                                                                                                Det måste alltid existera minimum en Admin.',

// Text on the "External Systems" Page.
'configuration_armory_cache' =>  'Cacha Armory Data Till',
'configuration_external_links_header' =>  'Integrera med externa system',
'configuration_eqdkp_integration_text' =>  'Integrera med EqDKP<br><a href="../docs/eqdkp_link.htm" target="_blank">hjälp?</a>',
'configuration_eqdkp_link' =>  'URL till er EqDKP installation (Inget avslutande /)',
'configuration_roster_text' =>  'Integrera med WoW Roster',
'configuration_armory_enable' =>  'Aktivera Armory uppslagning',
'configuration_armory_cache_database' =>  'Databas Tabell',
'configuration_armory_cache_files' =>  'Filer på disk',
'configuration_armory_cache_none' =>  'Cacha inte Armory Data',
'configuration_armory_link_text' =>  'Korrekt Armory länk för er Server',
'configuration_armory_language_text' =>  'Språk kod för Armoryt',
'configuration_extsys_bridge_config_header' =>  'Bryggnings Inställningar',
'configuration_extsys_norest' =>  'Inga Restriktioner',
'configuration_extsys_noaddus' =>  'Inga Ytterliggare Användargrupper',
'configuration_extsys_group01' =>  'Välj grundgruppen eller klassen som har tillgång attnyttja WRM',
'configuration_extsys_group02' =>  'Alla användare utan denna grupp kommer inte att tillåtas att logga in',
'configuration_extsys_group03' =>  'Vänligen välj "Inga Restriktioner" här om du vill att alla användare oavsett grupp/klass skall kunna logga in och utnyttja WRM',
'configuration_extsys_alt_group01' =>  'Välj en alternativ grupp/klass som kan nyttja WRM',
'configuration_extsys_alt_group02' =>  'Alla användare i denna grupp kommer att tillåtas att logga in, oavsett om de Är i ovanstående grupp/klass eller inte',
'configuration_extsys_group_text' =>  'Grundanvändar grupp',
'configuration_extsys_alt_group_text' =>  'YUtterligare användargrupp',
'configuration_armory_cache_timeout' =>  'Armory Cache Livstid (I Timmar)', //New
'configuration_armory_cache_timeout_sup' =>  'Efter Cache Lifetime löper ut, kommer WRM gå tillbaka till Armory för att hämta ny data.<br>
                                                                                                        Ju kortare cachen är desto färskare data kommer WRM att ha i dess popup,
                                                                                                        men desto långsammare kommer WRM att köra på grund av
                                                                                                        att det drar data från Armoryts URL oftare.<br>
                                                                                                        Ju längre cachen värde, desto mindre färska uppgifter
                                                                                                        från Armory men desto snabbare kommer WRM att köras.<br>', //New
// Text on the "User Settings" Page.
'configuration_multiple' =>  'Tillåt multipla registreringar från samma användare',
'configuration_anonymous' =>  'Tillåt anonym insyn',
'configuration_resop' =>  'Gör resistance valfritt',

// Text on the "Signup Rights" Page.
'configuration_raid_signupgroups_header' =>  'Raid Rättighetsgrupper',
'configuration_cancel' =>  'Avbryt',
'configuration_cancel_def' =>  'Avbryt = Placera en användare som Ej Tillgänglig',
'configuration_cancelled' =>  'Som Ej Tillgänglig',
'configuration_comments' =>  'Kommentarer',
'configuration_comments_def' =>  'Kommentarer = Tillåt användare att editera sina kommentarer',
'configuration_delete' =>  'Radera',
'configuration_delete_def' =>  'Radera = Ta bort användarens registrering helt',
'configuration_draft_def' =>  'Uttagning = Placera användaren som uttagna',
'configuration_draft' =>  'Uttagning',
'configuration_drafted' =>  'Uttagen (I Raiden)',
'configuration_on_queue' =>  'Som Tillgänglig',
'configuration_queue' =>  'Köa',
'configuration_queue_def' =>  'Köa = Placera en användare som Tillgänglig',
'configuration_signup_rights_header' =>  'Registreringsrättigheter',
'configuraiton_admin' =>  'Administratör',
'configuration_raidlead' =>  'Raidledare',

// Text on the "Raid Settings" Page.
'configuration_raid_settings_header' =>  'Raid Inställningar',
'configuration_raid_view_type_text' =>  'Välj Raid visningstyp',
'configuration_raid_view_type_class' =>  'Visa Raids efter Klass',
'configuration_raid_view_type_role' =>  'Visa Raids efter Roll',
'configuration_role_limit_text' =>  'Tvinga Roll begränsningar för Raids',
'configuration_class_limit_text' =>  'Tvinga Klass begränsningar för Raids',
'configuration_class_as_min' =>  'Använd Klass begränsningar som minimum',
'configuration_freeze' =>  'Avaktivera frys kontroll',
'configuration_recurrance_enabled_text' =>  'Aktivera återkommande raider', //New
'configuration_freeze_status_draft' =>  'Stoppa ändringar på Uttagna Raiders efter frysning av raid',  //NEW
'configuration_freeze_status_queue' =>  'Stoppa ändringar på Tillgängliga Raiders efter frysning av raid',  //NEW
'configuration_freeze_status_cancel' =>  'Stoppa ändringar på Ej Tillgängliga Raiders efter frysning av raid',  //NEW
'configuration_description' =>  'Beskrivning',
'configuration_default' =>  'Standard Grupp',
'configuration_faction' =>  'Faktion',
'configuration_guild_header' =>  'Guild Konfiguration',
'configuration_guild_name' =>  'Namn',
'configuration_id' =>  'Visa ID i tabeller',
'configuration_server' =>  'Server',
'configuration_site_header' =>  'Webbplats Konfiguration',
'configuration_user' =>  'Användare',
'configuration_user_rights_header' =>  'Användarrättigheter',

// multiple use
'configuration_autoqueue' =>  'Förbjud uppskrivning som Uttagen',

));  ?>