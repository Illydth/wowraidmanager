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

if (empty($phprlang) || !is_array($phprlang))
	$phprlang = array();
	
$phprlang = array_merge($phprlang, array(

// announcements
'announcements_header' =>  'Annunci',
'announcements_new_header' =>  'Crea un nuovo Annuncio',
'announcements_message_text' =>  'Testo',
'announcements_title_text' =>  'Titolo',

// Calendar
'invites' =>  'Inviti',
'start' =>  'Inizio',
'key' =>  'Key:<br>White Border = Not Signed Up<br>Green Border = Signed Up & Drafted<br>Blue Border = Signed Up, Not Drafted (queued)<br>Red Border = Signup Cancelled<br><span class="priorDay">TEXT</span> dates are in the past.<br><span class="currentDay">TEXT</span> date is today.<br><span class="postDay">TEXT</span> dates are in the future.', //New
'calendar_month_select_header' =>  'Seleziona mese ed anno da visualizzare',

// DKP View
'eqdkp_system_link' =>  'Link al sistema DKP',

// guilds
'guilds_header' =>  'Lista delle Gilde',
'guilds_new_header' =>  'Nuova Gilda',
'guilds_master' =>  'GuildMaster',
'guilds_name' =>  'Nome della Gilda',
'guilds_tag'	=> 'Abbreviazione della Gilda',						
'guilds_description' =>  'Guild Description',
'guilds_server' =>  'Guild Server',
'guilds_faction' =>  'Guild Faction',
'guilds_armory_code' =>  'Armory Code for Guild',
'raid_force_header' =>  'Raid Force Listing', //New
'raid_force_select_text' =>  'Select Raid Force: ', //New
'raid_force_name_box_text' =>  'Raid Force Name', //New
'raid_force_guild_options_text' =>  'Guild', //New
'raid_force_new_header' =>  'New Raid Force Link', //New
'raid_force_name_missing' =>  'Raid Force Name must not be blank or NULL.', //New
'raid_force_duplicate' =>  'Duplicate Raid Force Name/Guild Record.', //New
'raid_force_guild_id_missing' =>  'Guild ID must not be blank or NULL', //New
'armory_lang_US' =>  'US : http://us.battle.net/wow/ : English', //New
'armory_lang_EU' =>  'EU : http://eu.battle.net/wow/ : English', //New
'armory_lang_DE' =>  'DE : http://eu.battle.net/wow/ : German', //New
'armory_lang_ES' =>  'ES : http://eu.battle.net/wow/ : Spanish', //New
'armory_lang_FR' =>  'FR : http://eu.battle.net/wow/ : French', //New
'armory_lang_KR' =>  'KR : http://kr.battle.net/wow/ : Korean', //New
'armory_lang_TW' =>  'TW : http://tw.battle.net/wow/ : Taiwainese', //New
'armory_lang_none' =>  'No Armory or Not Applicable', //New

// locations
'locations_header' =>  'Istanze configurate',
'locations_max_lvl' =>  'Livello massimo',
'locations_min_lvl' =>  'Livello minimo',
'locations_limits_header' =>  'Limiti',
'locations_long' =>  'Nome esteso',
'locations_new' =>  'Configura una nuova Istanza',
'locations_raid_max' =>  'Numero massimo di PG',
'locations_short' =>  'Nome abbreviato',
'lock_template' =>  'Profilo Istanza non modificabile?',
'locations_ro_text' =>  'Read Only: Populated With WoW Official Name for Instance',
'locations_expansion_text' =>  'Expansion',
'locations_events_text' =>  'Event Name',

// lua_output
'rim_download' =>  'Scarica RIM (Raid Information Manager)',
'phprv_download' =>  'Scarica phpRaidViewer',
'lua_header' =>  'Codice LUA/Macro',
'sort_name' =>  'Name',
'sort_date' =>  'Date',
'output_rim' =>  'RIM (Raid Invite Manager)',
'output_phprv' =>  'PHP Raid Viewer',
'sort_signups_text' =>  'Sort Signups By:',
'sort_queue_text' =>  'Sort Queue By:',
'output_format_text' =>  'Output Format:',
'options_header' =>  'Options',
'lua_output_header' =>  'Beginning LUA Output',
'lua_show_all_raids' =>  'Output all Open Raids',
'lua_failed_to_write' =>  'LUA file could not be created due to failure to write.</b><br/>' .
									'Please set logging level to display warnings (E_WARNING or better) ' .
									'to see the issue.<br>' .
									'Use this for copy+paste:<br>',
'lua_rim_write_success' =>  '<b>LUA file created.</b><br>' . 
									'Download <a href="cache/raid_lua/phpRaid_Data.lua">phpRaid_Data.lua</a> and save 
									it to [wow-dir]\interface\addons\RIM\<br>' .
									'or use this for copy+paste:<br>',
'lua_prv_write_success' =>  '<b>LUA file created.</b><br>' . 
									'Download <a href="cache/raid_lua/phpRaid_Data.lua">phpRaid_Data.lua</a> and save 
									it to [wow-dir]\interface\addons\phpraidviewer\<br>' .
									'or use this for copy+paste:<br>',
'lua_drafted' =>  'Drafted Users', //New
'lua_queued' =>  'Queued Users', //New
'lua_macro_header' =>  'Macro output listing...', //New
'lua_macro_footer' =>  '<br>Macro output listing complete.<br>Copy and paste the above to a macro and run in-game.', //New

// permissions
'permissions_add' =>  'Aggiungi al Profilo Utente',
'permissions_announcements' =>  'Annunci',
'permissions_configuration' =>  'Configurazione',
'permissions_details_users_header' =>  'Permessi dettagliati',
'permissions_edit_header' =>  'Modifica Profilo Utente',
'permissions_description' =>  'Descrizione',
'permissions_details_header' =>  'Dettaglio dei Permessi',
'permissions_guilds' =>  'Gilde',
'permissions_header' =>  'Profili Utente',
'permissions_locations' =>  'Istanze',
'permissions_logs' =>  'Log',
'permissions_name' =>  'Nome',
'permissions_permissions' =>  'Profili Utente',
'permissions_profile' =>  'Personaggi',
'permissions_raids' =>  'Raid',
'permissions_new' =>  'Crea un nuovo Profilo Utente',
'permissions_users' =>  'Utenti',
'permissions_users_header' =>  'Utenti che utilizzano questo Profilo',

// profile
'profile_arcane' =>  'Resistenza Arcane',
'profile_class' =>  'Classe',
'profile_create_header' =>  'Non è possibile definire nuovi Personaggi',
'profile_create_msg' =>  'Non è possibile definire Personaggi fino a quando non viene inserita almeno una Gilda',
'profile_fire' =>  'Resistenza Fire',
'profile_frost' =>  'Resistenza Frost',
'profile_gender' =>  'Genere',
'profile_guild' =>  'Gilda',
'profile_role' =>  'Ruolo',
'profile_header' =>  'Personaggi',
'profile_level' =>  'Livello',
'profile_name' =>  'Nome',
'profile_nature' =>  'Resistenza Nature',
'profile_raid' =>  'Iscrizioni',
'profile_race' =>  'Razza',
'profile_shadow' =>  'Resistenza Shadow',
'iLvL' =>  "iLvL (Equipped, Best)", //New
'health' =>  "Health", //New
'mana' =>  "Mana", //New

// raids
'raids_date' =>  'Data',
'raids_description' =>  'Descrizione',
'raids_dungeon' =>  'Istanza',
'raids_freeze' =>  'Anticipo chiusura delle iscrizioni (in ore)',
'raids_invite' =>  'Ora di invito',
'raids_limits' =>  'Limiti del Raid',
'raids_location' =>  'Istanze preconfigurate',
'raids_max' =>  'Numero massimo di PG',
'raids_max_lvl' =>  'Livello massimo',
'raids_min_lvl' =>  'Livello minimo',
'raids_old' =>  'Raid passati',
'raids_new' =>  'Raid in programma',
'raids_new_header' =>  'Nuovo Raid',
'raids_edit_header' =>  'Edit Raid', //new
'raids_start' =>  'Ora di inizio',
'raids_eventtype_text' =>  'Tipo di evento',
'raids_mark_selected_raids_to_old' =>  "all mark raids are closed and over",

// event type
'event_type_raid' =>  'Raid (10/25 persone)',
'event_type_dungeon' =>  'Dungeon (5 persone)',
'event_type_pvp' =>  'Evento PvP',
'event_type_meeting' =>  'Incontro (online/offline)',
'event_type_other' =>  'Altro',

// expansions
'exp_generic_wow' =>  'Generic World of Warcraft',
'exp_burning_crusade' =>  'The Burning Crusade',
'exp_wrath_lich_king' =>  'Wrath of the Lich King',
'exp_cataclysm' =>  'Cataclysm',

// roster
'roster_header' =>  'Roster di Gilda',

// registration
'register_complete_header' =>  'Registrazione effettuata con successo',
'register_complete_msg' =>  'Ora sei un Utente registrato. Potrebbe esser necessario attendere l\'abilitazione definitiva da parte di un Amministratore prima di poter utilizzare tutte le funzioni di WowRaidManager.',
'register_confirm' =>  'Le password non corrispondono.',
'register_confirm_text' =>  'Inserisci nuovamente la password',
'register_email_header' =>  'Registrazione a',
'register_email_empty' =>  'E\' necessario inserire un indirizzo e-mail',
'register_email_exists' =>  'L\'indirizzo e-mail specificato è già in uso',
'register_email_greeting' =>  'Benvenuto',
'register_email_subject' =>  'E-mail di conferma della registrazione. Non necessita di risposta.',
'register_email_text' =>  'Indirizzo e-mail',
'register_error' =>  'Errore in fase di registrazione',
'register_header' =>  'Registrazione Utente',
'register_pass_empty' =>  'E\' necessario inserire una password',
'register_password_text' =>  'Password',
'register_user_empty' =>  'E\' necessario inserire uno username',
'register_user_exists' =>  'Lo username specificato è già in uso',
'register_username_text' =>  'Username',

// users
'users_assign' =>  'Assegna',
'users_char_header' =>  'Personaggi degli Utenti',
'users_header' =>  'Utenti',

// view
'view_approved' =>  'Iscrizioni confermate',
'view_cancel_header' =>  'Iscrizioni annullate',
'view_character' =>  'Personaggio',
'view_comments' =>  'Commenti',
'view_create' =>  'Definisci un Personaggio da iscrivere',
'view_date' =>  'Data',
'view_description_header' =>  'Descrizione del Raid',
'view_frozen' =>  'Le iscrizioni per questo Raid sono chiuse',
'view_information_header' =>  'Informazioni',
'view_invite' =>  'Ora di invito',
'view_location' =>  'Istanza',
'view_login' =>  'Accedi a WowRaidManager con i tuoi username e password per poterti iscrivere',
'view_new' =>  'Iscriviti a questo Raid',
'view_max' =>  'Numero massimo di PG',
'view_max_lvl' =>  'Livello massimo',
'view_min_lvl' =>  'Livello minimo',
'view_missing_signups_link_text' =>  'Visualizza gli Utenti che NON risultano iscritti a questo Raid',
'view_officer' =>  'Inserito da',
'view_ok' =>  'Iscrizioni aperte',
'view_queue' =>  'Tipo di iscrizione',
'view_queue_header' =>  'Iscrizioni in coda',
'view_queued' =>  'Iscrizioni in coda',
'view_raid_cancel_text' =>  'Iscrizioni annullate',
'view_signed' =>  'Già iscritto',
'view_signup' =>  'Stato delle iscrizioni',
'view_signup_queue' =>  'In coda (disponibile per il Raid)',
'view_signup_cancel' =>  'Annullata (non disponibile per il Raid)',
'view_signup_draft' =>  'Confermata (nella formazione del Raid)',
'view_start' =>  'Ora di inizio',
'view_statistics_header' =>  'Statistiche',
'view_teams_link_text' =>  'Crea ed assegna i Team per questo Raid',
'view_total' =>  'Iscrizioni totali',
'view_username' =>  'Utente',
'view_missing_signups_return_to_view' =>  'Back to Raid View', //New

// main page
'main_previous_raids' =>  'Eventi passati',
'main_upcoming_raids' =>  'Eventi in programma',
'signup' =>  'Iscriviti',
'rss_feed_text' =>  'Feed RSS delle iscrizioni ai Raid',
'guild_time_string' =>  'Orario di gilda',
'menu_header_text' =>  'Menù di WRM',

// teams
'team_new_header' =>  'Crea un nuovo Team',
'team_add_header' =>  'Aggiungi membri al Team',
'team_remove_header' =>  'Rimuovi membri dal Team',
'teams_raid_view_text' =>  'Torna alla visualizzazione del Raid',
'team_cur_teams_header' =>  'Team creati',
'team_page_header' =>  'Team',

// Boss Kill Tracking
'boss_kill_type_dungeon' =>  'Dungeon (5/10 Man)',
'boss_kill_type_25_man' =>  '25 Man Raid',
'boss_kill_type_10_man' =>  '10 Man Raid',
'boss_kill_type_40_man' =>  '40 Man Raid',
'bosskill_header' =>  'Track Named (Boss) Accomplishments',

//Raids Archive
'raidsarchive_header' =>  'Raids Archive',

));  ?>