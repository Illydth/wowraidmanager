<?php
/***************************************************************************
 *                             lang_pages.php
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
$phprlang['announcements_header'] = 'Annunci';
$phprlang['announcements_new_header'] = 'Crea un nuovo Annuncio';
$phprlang['announcements_message_text'] = 'Testo';
$phprlang['announcements_title_text'] = 'Titolo';

// Calendar
$phprlang['invites'] = 'Inviti';
$phprlang['start'] = 'Inizio';
$phprlang['key'] = 'Key:<br>White Border = Not Signed Up<br>Green Border = Signed Up & Drafted<br>Blue Border = Signed Up, Not Drafted (queued)<br>Red Border = Signup Cancelled<br><span class="priorDay">TEXT</span> dates are in the past.<br><span class="currentDay">TEXT</span> date is today.<br><span class="postDay">TEXT</span> dates are in the future.'; //New
$phprlang['calendar_month_select_header'] = 'Seleziona mese ed anno da visualizzare';

// DKP View
$phprlang['eqdkp_system_link'] = 'Link al sistema DKP';

// guilds
$phprlang['guilds_header'] = 'Lista delle Gilde';
$phprlang['guilds_new_header'] = 'Nuova Gilda';
$phprlang['guilds_master'] = 'GuildMaster';
$phprlang['guilds_name'] = 'Nome della Gilda';
$phprlang['guilds_tag']	= 'Abbreviazione della Gilda';						
$phprlang['guilds_description'] = 'Guild Description';
$phprlang['guilds_server'] = 'Guild Server';
$phprlang['guilds_faction'] = 'Guild Faction';
$phprlang['guilds_armory_code'] = 'Armory Code for Guild';
$phprlang['armory_lang_US'] = 'US : http://us.battle.net/wow/ : English'; //New
$phprlang['armory_lang_EU'] = 'EU : http://eu.battle.net/wow/ : English'; //New
$phprlang['armory_lang_DE'] = 'DE : http://eu.battle.net/wow/ : German'; //New
$phprlang['armory_lang_ES'] = 'ES : http://eu.battle.net/wow/ : Spanish'; //New
$phprlang['armory_lang_FR'] = 'FR : http://eu.battle.net/wow/ : French'; //New
$phprlang['armory_lang_KR'] = 'KR : http://kr.battle.net/wow/ : Korean'; //New
$phprlang['armory_lang_TW'] = 'TW : http://tw.battle.net/wow/ : Taiwainese'; //New
$phprlang['armory_lang_none'] = 'No Armory or Not Applicable'; //New

// locations
$phprlang['locations_header'] = 'Istanze configurate';
$phprlang['locations_max_lvl'] = 'Livello massimo';
$phprlang['locations_min_lvl'] = 'Livello minimo';
$phprlang['locations_limits_header'] = 'Limiti';
$phprlang['locations_long'] = 'Nome esteso';
$phprlang['locations_new'] = 'Configura una nuova Istanza';
$phprlang['locations_raid_max'] = 'Numero massimo di PG';
$phprlang['locations_short'] = 'Nome abbreviato';
$phprlang['lock_template'] = 'Profilo Istanza non modificabile?';
$phprlang['locations_ro_text'] = 'Read Only: Populated With WoW Official Name for Instance';
$phprlang['locations_expansion_text'] = 'Expansion';
$phprlang['locations_events_text'] = 'Event Name';

// lua_output
$phprlang['rim_download'] = 'Scarica RIM (Raid Information Manager)';
$phprlang['phprv_download'] = 'Scarica phpRaidViewer';
$phprlang['lua_header'] = 'Codice LUA/Macro';
$phprlang['sort_name'] = 'Name';
$phprlang['sort_date'] = 'Date';
$phprlang['output_rim'] = 'RIM (Raid Invite Manager)';
$phprlang['output_phprv'] = 'PHP Raid Viewer';
$phprlang['sort_signups_text'] = 'Sort Signups By:';
$phprlang['sort_queue_text'] = 'Sort Queue By:';
$phprlang['output_format_text'] = 'Output Format:';
$phprlang['options_header'] = 'Options';
$phprlang['lua_output_header'] = 'Beginning LUA Output';
$phprlang['lua_show_all_raids'] = 'Output all Open Raids';
$phprlang['lua_failed_to_write'] = 'LUA file could not be created due to failure to write.</b><br/>' .
									'Please set logging level to display warnings (E_WARNING or better) ' .
									'to see the issue.<br>' .
									'Use this for copy+paste:<br>';
$phprlang['lua_rim_write_success'] = '<b>LUA file created.</b><br>' . 
									'Download <a href="cache/raid_lua/phpRaid_Data.lua">phpRaid_Data.lua</a> and save 
									it to [wow-dir]\interface\addons\RIM\<br>' .
									'or use this for copy+paste:<br>';
$phprlang['lua_prv_write_success'] = '<b>LUA file created.</b><br>' . 
									'Download <a href="cache/raid_lua/phpRaid_Data.lua">phpRaid_Data.lua</a> and save 
									it to [wow-dir]\interface\addons\phpraidviewer\<br>' .
									'or use this for copy+paste:<br>';

// permissions
$phprlang['permissions_add'] = 'Aggiungi al Profilo Utente';
$phprlang['permissions_announcements'] = 'Annunci';
$phprlang['permissions_configuration'] = 'Configurazione';
$phprlang['permissions_details_users_header'] = 'Permessi dettagliati';
$phprlang['permissions_edit_header'] = 'Modifica Profilo Utente';
$phprlang['permissions_description'] = 'Descrizione';
$phprlang['permissions_details_header'] = 'Dettaglio dei Permessi';
$phprlang['permissions_guilds'] = 'Gilde';
$phprlang['permissions_header'] = 'Profili Utente';
$phprlang['permissions_locations'] = 'Istanze';
$phprlang['permissions_logs'] = 'Log';
$phprlang['permissions_name'] = 'Nome';
$phprlang['permissions_permissions'] = 'Profili Utente';
$phprlang['permissions_profile'] = 'Personaggi';
$phprlang['permissions_raids'] = 'Raid';
$phprlang['permissions_new'] = 'Crea un nuovo Profilo Utente';
$phprlang['permissions_users'] = 'Utenti';
$phprlang['permissions_users_header'] = 'Utenti che utilizzano questo Profilo';
$phprlang['profile_header_text'] = "my Profile";
$phprlang['profile_number_character'] = "Number of my Character";
$phprlang['profile_number_signups_all'] = "Number of all my signups";
$phprlang['profile_number_signups_draft'] = "Number of my signups in confirmation list";
$phprlang['profile_number_signups_queue'] = "Number of my signups in queue list";
$phprlang['profile_number_signups_chancel'] = "Number of my checkouts (chancel)";

// profile
$phprlang['profile_class'] = 'Classe';
$phprlang['profile_create_header'] = 'Non è possibile definire nuovi Personaggi';
$phprlang['profile_create_msg'] = 'Non è possibile definire Personaggi fino a quando non viene inserita almeno una Gilda';
$phprlang['profile_gender'] = 'Genere';
$phprlang['profile_guild'] = 'Gilda';
$phprlang['profile_role'] = 'Ruolo';
$phprlang['profile_header'] = 'Personaggi';
$phprlang['profile_level'] = 'Livello';
$phprlang['profile_name'] = 'Nome';
$phprlang['profile_raid'] = 'Iscrizioni';
$phprlang['profile_race'] = 'Razza';

// raids
$phprlang['raids_date'] = 'Data';
$phprlang['raids_description'] = 'Descrizione';
$phprlang['raids_dungeon'] = 'Istanza';
$phprlang['raids_freeze'] = 'Anticipo chiusura delle iscrizioni (in ore)';
$phprlang['raids_invite'] = 'Ora di invito';
$phprlang['raids_limits'] = 'Limiti del Raid';
$phprlang['raids_location'] = 'Istanze preconfigurate';
$phprlang['raids_max'] = 'Numero massimo di PG';
$phprlang['raids_max_lvl'] = 'Livello massimo';
$phprlang['raids_min_lvl'] = 'Livello minimo';
$phprlang['raids_old'] = 'Raid passati';
$phprlang['raids_new'] = 'Raid in programma';
$phprlang['raids_new_header'] = 'Nuovo Raid';
$phprlang['raids_edit_header'] = 'Edit Raid'; //new
$phprlang['raids_start'] = 'Ora di inizio';
$phprlang['raids_eventtype_text'] = 'Tipo di evento';
$phprlang['raids_mark_selected_raids_to_old'] = "all mark raids are closed and over";

// event type
$phprlang['event_type_raid'] = 'Raid (10/25 persone)';
$phprlang['event_type_dungeon'] = 'Dungeon (5 persone)';
$phprlang['event_type_pvp'] = 'Evento PvP';
$phprlang['event_type_meeting'] = 'Incontro (online/offline)';
$phprlang['event_type_other'] = 'Altro';

// roster
$phprlang['roster_header'] = 'Roster di Gilda';

// registration
$phprlang['register_complete_header'] = 'Registrazione effettuata con successo';
$phprlang['register_complete_msg'] = 'Ora sei un Utente registrato. Potrebbe esser necessario attendere l\'abilitazione definitiva da parte di un Amministratore prima di poter utilizzare tutte le funzioni di WowRaidManager.';
$phprlang['register_confirm'] = 'Le password non corrispondono.';
$phprlang['register_confirm_text'] = 'Inserisci nuovamente la password';
$phprlang['register_email_header'] = 'Registrazione a';
$phprlang['register_email_empty'] = 'E\' necessario inserire un indirizzo e-mail';
$phprlang['register_email_exists'] = 'L\'indirizzo e-mail specificato è già in uso';
$phprlang['register_email_greeting'] = 'Benvenuto';
$phprlang['register_email_subject'] = 'E-mail di conferma della registrazione. Non necessita di risposta.';
$phprlang['register_email_text'] = 'Indirizzo e-mail';
$phprlang['register_error'] = 'Errore in fase di registrazione';
$phprlang['register_header'] = 'Registrazione Utente';
$phprlang['register_pass_empty'] = 'E\' necessario inserire una password';
$phprlang['register_password_text'] = 'Password';
$phprlang['register_user_empty'] = 'E\' necessario inserire uno username';
$phprlang['register_user_exists'] = 'Lo username specificato è già in uso';
$phprlang['register_username_text'] = 'Username';

// users
$phprlang['users_assign'] = 'Assegna';
$phprlang['users_char_header'] = 'Personaggi degli Utenti';
$phprlang['users_header'] = 'Utenti';

// view
$phprlang['view_approved'] = 'Iscrizioni confermate';
$phprlang['view_cancel_header'] = 'Iscrizioni annullate';
$phprlang['view_character'] = 'Personaggio';
$phprlang['view_comments'] = 'Commenti';
$phprlang['view_create'] = 'Definisci un Personaggio da iscrivere';
$phprlang['view_date'] = 'Data';
$phprlang['view_description_header'] = 'Descrizione del Raid';
$phprlang['view_frozen'] = 'Le iscrizioni per questo Raid sono chiuse';
$phprlang['view_information_header'] = 'Informazioni';
$phprlang['view_invite'] = 'Ora di invito';
$phprlang['view_location'] = 'Istanza';
$phprlang['view_login'] = 'Accedi a WowRaidManager con i tuoi username e password per poterti iscrivere';
$phprlang['view_new'] = 'Iscriviti a questo Raid';
$phprlang['view_max'] = 'Numero massimo di PG';
$phprlang['view_max_lvl'] = 'Livello massimo';
$phprlang['view_min_lvl'] = 'Livello minimo';
$phprlang['view_missing_signups_link_text'] = 'Visualizza gli Utenti che NON risultano iscritti a questo Raid';
$phprlang['view_officer'] = 'Inserito da';
$phprlang['view_ok'] = 'Iscrizioni aperte';
$phprlang['view_queue'] = 'Tipo di iscrizione';
$phprlang['view_queue_header'] = 'Iscrizioni in coda';
$phprlang['view_queued'] = 'Iscrizioni in coda';
$phprlang['view_raid_cancel_text'] = 'Iscrizioni annullate';
$phprlang['view_signed'] = 'Già iscritto';
$phprlang['view_signup'] = 'Stato delle iscrizioni';
$phprlang['view_signup_queue'] = 'In coda (disponibile per il Raid)';
$phprlang['view_signup_cancel'] = 'Annullata (non disponibile per il Raid)';
$phprlang['view_signup_draft'] = 'Confermata (nella formazione del Raid)';
$phprlang['view_start'] = 'Ora di inizio';
$phprlang['view_statistics_header'] = 'Statistiche';
$phprlang['view_teams_link_text'] = 'Crea ed assegna i Team per questo Raid';
$phprlang['view_total'] = 'Iscrizioni totali';
$phprlang['view_username'] = 'Utente';
$phprlang['view_missing_signups_return_to_view']= 'Back to Raid View'; //New

// main page
$phprlang['main_previous_raids'] = 'Eventi passati';
$phprlang['main_upcoming_raids'] = 'Eventi in programma';
$phprlang['signup'] = 'Iscriviti';
$phprlang['rss_feed_text'] = 'Feed RSS delle iscrizioni ai Raid';
$phprlang['guild_time_string'] = 'Orario di gilda';
$phprlang['menu_header_text'] = 'Menù di WRM';

// teams
$phprlang['team_new_header'] = 'Crea un nuovo Team';
$phprlang['team_add_header'] = 'Aggiungi membri al Team';
$phprlang['team_remove_header'] = 'Rimuovi membri dal Team';
$phprlang['teams_raid_view_text'] = 'Torna alla visualizzazione del Raid';
$phprlang['team_cur_teams_header'] = 'Team creati';
$phprlang['team_page_header'] = 'Team';

// Boss Kill Tracking
$phprlang['boss_kill_type_dungeon'] = 'Dungeon (5/10 Man)';
$phprlang['boss_kill_type_25_man'] = '25 Man Raid';
$phprlang['boss_kill_type_10_man'] = '10 Man Raid';
$phprlang['boss_kill_type_40_man'] = '40 Man Raid';
$phprlang['bosskill_header'] = 'Track Named (Boss) Accomplishments';

//Raids Archive
$phprlang['raidsarchive_header'] = 'Raids Archive';

//Menubar 
$phprlang['user_menu_header'] = 'User Menu';
$phprlang['main_menu_header'] = 'Main Menu';

//Signup Page
$phprlang['signup_edit_header'] = "Edit your Signup Settings";
$phprlang['signup_character_spec'] = "Character Spec";

?>