<?php
/***************************************************************************
 *                          lang_pages.php (German)
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
'announcements_header' =>  'Ankündigungen',
'announcements_new_header' =>  'Neue Ankündigung erstellen',
'announcements_message_text' =>  'Nachricht',
'announcements_title_text' =>  'Titel',

// Calendar
'invites' =>  'Einladungen',
'start' =>  'Start',
'key' =>  'Key:<br>White Border = Not Signed Up<br>Green Border = Signed Up & Drafted<br>Blue Border = Signed Up, Not Drafted (queued)<br>Red Border = Signup Cancelled<br><span class="priorDay">TEXT</span> dates are in the past.<br><span class="currentDay">TEXT</span> date is today.<br><span class="postDay">TEXT</span> dates are in the future.', //New
'calendar_month_select_header' =>  'Wähle das anzuzeigende Jahr und Monat',

// DKP
'eqdkp_system_link' =>  'Der Link zu unserem DKP - System:',

// guilds
'guilds_header' =>  'Gildenliste',
'guilds_new_header' =>  'Neue Gilde',
'guilds_master' =>  'Gildenmeister',
'guilds_name' =>  'Kompletter Gildenname',
'guilds_tag' =>  'Gildenkürzel',
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
'locations_header' =>  'Gespeicherte Instanzen',
'locations_max_lvl' =>  'Maximalstufe',
'locations_min_lvl' =>  'Minimalstufe',
'locations_limits_header' =>  'Raid-Begrenzungen',
'locations_long' =>  'Name der Instanz',
'locations_new' =>  'Neue Instanz erstellen',
'locations_raid_max' =>  'Maximale Teilnehmerzahl',
'locations_short' =>  'Instanzkürzel',
'lock_template' =>  'Gesperrte Raid-Vorlage?',
'locations_ro_text' =>  'Read Only: Populated With WoW Official Name for Instance',
'locations_expansion_text' =>  'Expansion',
'locations_events_text' =>  'Event Name',

// lua_output
'rim_download' =>  'RIM (Raid Information Manager) herunterladen',
'phprv_download' =>  'phpRaidViewer herunterladen',
'lua_header' =>  'LUA-/Makroausgabe',
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
'permissions_add' =>  'Benutzer zur Berechtigungsgruppe hinzufügen',
'permissions_announcements' =>  'Ankündigungen',
'permissions_configuration' =>  'Konfiguration',
'permissions_details_users_header' =>  'Detaillierte Benutzerrechte',
'permissions_edit_header' =>  'Gruppe bearbeiten',
'permissions_description' =>  'Beschreibung',
'permissions_details_header' =>  'Gruppendetails',
'permissions_guilds' =>  'Gilden',
'permissions_header' =>  'Benutzergruppen',
'permissions_locations' =>  'Instanzen',
'permissions_logs' =>  'Protokoll',
'permissions_name' =>  'Name',
'permissions_permissions' =>  'Berechtigungen',
'permissions_profile' =>  'Profil',
'permissions_raids' =>  'Raids',
'permissions_new' =>  'Neue Berechtigungsgruppe erstellen',
'permissions_users' =>  'Benutzer',
'permissions_users_header' =>  'Benutzer in dieser Berechtigungsgruppe',

// profile
'profile_arcane' =>  'Arkanwiderstand',
'profile_class' =>  'Klasse',
'profile_create_header' =>  'Charaktererstellung nicht verfügbar',
'profile_create_msg' =>  'Die Charaktererstellung bleibt gesperrt, bis ein Administrator eine Gilde erstellt hat.',
'profile_fire' =>  'Feuerwiderstand',
'profile_frost' =>  'Frostwiderstand',
'profile_gender' =>  'Geschlecht',
'profile_guild' =>  'Gildenzugehörigkeit',
'profile_role' =>  'Rolle',
'profile_header' =>  'Charaktere',
'profile_level' =>  'Stufe',
'profile_name' =>  'Name',
'profile_nature' =>  'Naturwiderstand',
'profile_raid' =>  'Raidteilnahme',
'profile_race' =>  'Rasse',
'profile_shadow' =>  'Schattenwiderstand',
'iLvL' =>  "iLvL (Equipped, Best)", //New
'health' =>  "Health", //New
'mana' =>  "Mana", //New

// raids
'raids_date' =>  'Datum',
'raids_description' =>  'Beschreibung',
'raids_dungeon' =>  'Instanz',
'raids_freeze' =>  'Anmeldeschluss (in Stunden)',
'raids_invite' =>  'Einladung',
'raids_limits' =>  'Raidbegrenzungen',
'raids_location' =>  'Gespeicherte Instanzen',
'raids_max' =>  'Maximale Teilnehmerzahl',
'raids_max_lvl' =>  'Maximalstufe',
'raids_min_lvl' =>  'Minimalstufe',
'raids_old' =>  'Beendete Raids',
'raids_new' =>  'Aktuelle Raids',
'raids_new_header' =>  'Neuer Raid',
'raids_edit_header' =>  'Edit Raid', //new
'raids_start' =>  'Startzeit',
'raids_eventtype_text' =>  'Eventart',
'raids_mark_selected_raids_to_old' =>  "alle markierten Raids sind vorbei und geschlossen",

// event type
'event_type_raid' =>  'Raid (10/25er)',
'event_type_dungeon' =>  'Dungeon (5er-Instanz)',
'event_type_pvp' =>  'PvP-Event',
'event_type_meeting' =>  'Treffen (online/offline)',
'event_type_other' =>  'Andere',

// expansions
'exp_generic_wow' =>  'Generic World of Warcraft',
'exp_burning_crusade' =>  'The Burning Crusade',
'exp_wrath_lich_king' =>  'Wrath of the Lich King',
'exp_cataclysm' =>  'Cataclysm',

// roster
'roster_header' =>  'Mitgliederliste',

// registration
'register_complete_header' =>  'Registrierung erfolgreich!',
'register_complete_msg' =>  'Du bist nun registriert. Klicke jetzt auf "Profil", um deine(n) Charakter(e) zu erstellen.',
'register_confirm' =>  'Die Passwörter stimmen nicht überein.',
'register_confirm_text' =>  'Passwort erneut eingeben',
'register_email_header' =>  'Deine Registrierung bei',
'register_email_empty' =>  'Du musst eine (gültige) E-Mail-Adresse eingeben',
'register_email_exists' =>  'Diese E-Mail-Adresse kannst du nicht benutzen',
'register_email_greeting' =>  'Willkommen',
'register_email_subject' =>  'Diese E-Mail dient nur als Registrierungsbestätigung. Bitte antworte nicht darauf.',
'register_email_text' =>  'E-Mail-Adresse',
'register_error' =>  'Fehler bei der Registrierung',
'register_header' =>  'Benutzer-Registrierung',
'register_pass_empty' =>  'Du musst ein Passwort eingeben',
'register_password_text' =>  'Passwort',
'register_user_empty' =>  'Du musst einen Benutzernamen eingeben',
'register_user_exists' =>  'Dieser Benutzername wird bereits verwendet',
'register_username_text' =>  'Benutzername',

// users
'users_assign' =>  'zuweisen',
'users_char_header' =>  'Benutzercharaktere',
'users_header' =>  'Benutzer',

// view
'view_approved' =>  'Bestätigte Mitglieder',
'view_cancel_header' =>  'Abgemeldete Benutzer',
'view_character' =>  'Charakter',
'view_comments' =>  'Kommentar',
'view_create' =>  'Charakter erstellen',
'view_date' =>  'Datum',
'view_description_header' =>  'Raid-Beschreibung',
'view_frozen' =>  'Anmeldungen sind eingefroren',
'view_information_header' =>  'Information',
'view_invite' =>  'Einladung',
'view_location' =>  'Instanz',
'view_login' =>  'Zum Anmelden bitte einloggen',
'view_new' =>  'Für diesen Raid anmelden',
'view_max' =>  'Maximale Teilnehmerzahl',
'view_max_lvl' =>  'Maximalstufe',
'view_min_lvl' =>  'Minimalstufe',
'view_missing_signups_link_text' =>  'Zeige Profile, die sich NICHT für diesen Raid angemeldet haben.',
'view_officer' =>  'Ersteller',
'view_ok' =>  'Offen für Anmeldungen',
'view_queue' =>  'Wie möchtest du dich anmelden?',
'view_queue_header' =>  'Warteliste',
'view_queued' =>  'Mitglieder auf der Warteliste',
'view_raid_cancel_text' =>  'Zurückgezogene Anmeldungen',
'view_signed' =>  'Bereits angemeldet',
'view_signup' =>  'Anmeldeinformation',
'view_signup_queue' =>  'In die Warteschlage anmelden',
'view_signup_cancel' =>  'Als nicht verfügbar anmelden',
'view_signup_draft' =>  'Für den Raid anmelden',
'view_start' =>  'Startzeit',
'view_statistics_header' =>  'Statistiken',
'view_teams_link_text' =>  'Teams für diesen Raid erzeugen und zuweisen',
'view_total' =>  'Anmeldungen insgesamt',
'view_username' =>  'Benutzername',
'view_missing_signups_return_to_view' =>  'Back to Raid View', //New

// main page
'main_previous_raids' =>  'Beendete Raids',
'main_upcoming_raids' =>  'Aktuelle Raids',
'signup' =>  'Anmelden',
'rss_feed_text' =>  'Raidanmeldungen RSS-Feed',
'guild_time_string' =>  'Datum und Uhrzeit',
'menu_header_text' =>  'WRM-Menü',

// teams
'team_new_header' =>  'Neues Team erzeugen',
'team_add_header' =>  'Mitglieder zu Team hinzufügen',
'team_remove_header' =>  'Mitglieder aus Team entfernen',
'teams_raid_view_text' =>  'Zurück zur Raidansicht',
'team_cur_teams_header' =>  'Erzeugte Teams',
'team_page_header' =>  'Teams',

// Boss Kill Tracking
'boss_kill_type_dungeon' =>  'Dungeon (5/10 Man)',
'boss_kill_type_25_man' =>  '25 Man Raid',
'boss_kill_type_10_man' =>  '10 Man Raid',
'boss_kill_type_40_man' =>  '40 Man Raid',
'bosskill_header' =>  'Track Named (Boss) Accomplishments',

//Raids Archive
'raidsarchive_header' =>  'Raids Archive',

));  ?>