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
// announcements
$phprlang['announcements_header'] = 'Ankündigungen';
$phprlang['announcements_new_header'] = 'Neue Ankündigung erstellen';
$phprlang['announcements_message_text'] = 'Nachricht';
$phprlang['announcements_title_text'] = 'Titel';

// Calendar
$phprlang['invites'] = 'Einladungen';
$phprlang['start'] = 'Start';
$phprlang['key'] = 'Legende:<br>(<span class="draftedmark">*</span>) = Angemeldet & vorgesehen<br>(<span class="qcanmark">#</span>) = Angemeldet, nicht vorgesehen (Warteliste oder abgebrochen)<br><span class="priorDay">TEXT</span>: Datum liegt in der Vergangenheit.<br><span class="currentDay">TEXT</span>: Datum ist heute.<br><span class="postDay">TEXT</span>: Datum liegt in der Zukunft.';
$phprlang['calendar_month_select_header'] = 'Wähle das anzuzeigende Jahr und Monat';

// DKP
$phprlang['eqdkp_system_link'] = 'Der Link zu unserem DKP - System:';

// guilds
$phprlang['guilds_header'] = 'Gildenliste';
$phprlang['guilds_new_header'] = 'Neue Gilde';
$phprlang['guilds_master'] = 'Gildenmeister';
$phprlang['guilds_name'] = 'Kompletter Gildenname';
$phprlang['guilds_tag'] = 'Gildenkürzel';
$phprlang['guilds_description'] = 'Guild Description';
$phprlang['guilds_server'] = 'Guild Server';
$phprlang['guilds_faction'] = 'Guild Faction';
$phprlang['guilds_armory_code'] = 'Armory Code for Guild';

// locations
$phprlang['locations_header'] = 'Gespeicherte Instanzen';
$phprlang['locations_max_lvl'] = 'Maximalstufe';
$phprlang['locations_min_lvl'] = 'Minimalstufe';
$phprlang['locations_limits_header'] = 'Raid-Begrenzungen';
$phprlang['locations_long'] = 'Name der Instanz';
$phprlang['locations_new'] = 'Neue Instanz erstellen';
$phprlang['locations_raid_max'] = 'Maximale Teilnehmerzahl';
$phprlang['locations_short'] = 'Instanzkürzel';
$phprlang['lock_template'] = 'Gesperrte Raid-Vorlage?';
$phprlang['locations_ro_text'] = 'Read Only: Populated With WoW Official Name for Instance';
$phprlang['locations_expansion_text'] = 'Expansion';
$phprlang['locations_events_text'] = 'Event Name';

// lua_output
$phprlang['rim_download'] = 'RIM (Raid Information Manager) herunterladen';
$phprlang['phprv_download'] = 'phpRaidViewer herunterladen';
$phprlang['lua_header'] = 'LUA-/Makroausgabe';
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
$phprlang['permissions_add'] = 'Benutzer zur Berechtigungsgruppe hinzufügen';
$phprlang['permissions_announcements'] = 'Ankündigungen';
$phprlang['permissions_configuration'] = 'Konfiguration';
$phprlang['permissions_details_users_header'] = 'Detaillierte Benutzerrechte';
$phprlang['permissions_edit_header'] = 'Gruppe bearbeiten';
$phprlang['permissions_description'] = 'Beschreibung';
$phprlang['permissions_details_header'] = 'Gruppendetails';
$phprlang['permissions_guilds'] = 'Gilden';
$phprlang['permissions_header'] = 'Benutzergruppen';
$phprlang['permissions_locations'] = 'Instanzen';
$phprlang['permissions_logs'] = 'Protokoll';
$phprlang['permissions_name'] = 'Name';
$phprlang['permissions_permissions'] = 'Berechtigungen';
$phprlang['permissions_profile'] = 'Profil';
$phprlang['permissions_raids'] = 'Raids';
$phprlang['permissions_new'] = 'Neue Berechtigungsgruppe erstellen';
$phprlang['permissions_users'] = 'Benutzer';
$phprlang['permissions_users_header'] = 'Benutzer in dieser Berechtigungsgruppe';

// profile
$phprlang['profile_arcane'] = 'Arkanwiderstand';
$phprlang['profile_class'] = 'Klasse';
$phprlang['profile_create_header'] = 'Charaktererstellung nicht verfügbar';
$phprlang['profile_create_msg'] = 'Die Charaktererstellung bleibt gesperrt, bis ein Administrator eine Gilde erstellt hat.';
$phprlang['profile_fire'] = 'Feuerwiderstand';
$phprlang['profile_frost'] = 'Frostwiderstand';
$phprlang['profile_gender'] = 'Geschlecht';
$phprlang['profile_guild'] = 'Gildenzugehörigkeit';
$phprlang['profile_role'] = 'Rolle';
$phprlang['profile_header'] = 'Charaktere';
$phprlang['profile_level'] = 'Stufe';
$phprlang['profile_name'] = 'Name';
$phprlang['profile_nature'] = 'Naturwiderstand';
$phprlang['profile_raid'] = 'Raidteilnahme';
$phprlang['profile_race'] = 'Rasse';
$phprlang['profile_shadow'] = 'Schattenwiderstand';

// raids
$phprlang['raids_date'] = 'Datum';
$phprlang['raids_description'] = 'Beschreibung';
$phprlang['raids_dungeon'] = 'Instanz';
$phprlang['raids_freeze'] = 'Anmeldeschluss (in Stunden)';
$phprlang['raids_invite'] = 'Einladung';
$phprlang['raids_limits'] = 'Raidbegrenzungen';
$phprlang['raids_location'] = 'Gespeicherte Instanzen';
$phprlang['raids_max'] = 'Maximale Teilnehmerzahl';
$phprlang['raids_max_lvl'] = 'Maximalstufe';
$phprlang['raids_min_lvl'] = 'Minimalstufe';
$phprlang['raids_old'] = 'Beendete Raids';
$phprlang['raids_new'] = 'Aktuelle Raids';
$phprlang['raids_new_header'] = 'Neuer Raid';
$phprlang['raids_start'] = 'Startzeit';
$phprlang['raids_eventtype_text'] = 'Eventart';
$phprlang['raids_mark_selected_raids_to_old'] = "markiere ausgewählte raids als alt";

// event type
$phprlang['event_type_raid'] = 'Raid (10/25er)';
$phprlang['event_type_dungeon'] = 'Dungeon (5er-Instanz)';
$phprlang['event_type_pvp'] = 'PvP-Event';
$phprlang['event_type_meeting'] = 'Treffen (online/offline)';
$phprlang['event_type_other'] = 'Andere';

// expansions
$phprlang['exp_generic_wow'] = 'Generic World of Warcraft';
$phprlang['exp_burning_crusade'] = 'The Burning Crusade';
$phprlang['exp_wrath_lich_king'] = 'Wrath of the Lich King';
$phprlang['exp_cataclysm'] = 'Cataclysm';

// roster
$phprlang['roster_header'] = 'Mitgliederliste';

// registration
$phprlang['register_complete_header'] = 'Registrierung erfolgreich!';
$phprlang['register_complete_msg'] = 'Du bist nun registriert. Klicke jetzt auf "Profil", um deine(n) Charakter(e) zu erstellen.';
$phprlang['register_confirm'] = 'Die Passwörter stimmen nicht überein.';
$phprlang['register_confirm_text'] = 'Passwort erneut eingeben';
$phprlang['register_email_header'] = 'Deine Registrierung bei';
$phprlang['register_email_empty'] = 'Du musst eine (gültige) E-Mail-Adresse eingeben';
$phprlang['register_email_exists'] = 'Diese E-Mail-Adresse kannst du nicht benutzen';
$phprlang['register_email_greeting'] = 'Willkommen';
$phprlang['register_email_subject'] = 'Diese E-Mail dient nur als Registrierungsbestätigung. Bitte antworte nicht darauf.';
$phprlang['register_email_text'] = 'E-Mail-Adresse';
$phprlang['register_error'] = 'Fehler bei der Registrierung';
$phprlang['register_header'] = 'Benutzer-Registrierung';
$phprlang['register_pass_empty'] = 'Du musst ein Passwort eingeben';
$phprlang['register_password_text'] = 'Passwort';
$phprlang['register_user_empty'] = 'Du musst einen Benutzernamen eingeben';
$phprlang['register_user_exists'] = 'Dieser Benutzername wird bereits verwendet';
$phprlang['register_username_text'] = 'Benutzername';

// users
$phprlang['users_assign'] = 'zuweisen';
$phprlang['users_char_header'] = 'Benutzercharaktere';
$phprlang['users_header'] = 'Benutzer';

// view
$phprlang['view_approved'] = 'Bestätigte Mitglieder';
$phprlang['view_cancel_header'] = 'Abgemeldete Benutzer';
$phprlang['view_character'] = 'Charakter';
$phprlang['view_comments'] = 'Kommentar';
$phprlang['view_create'] = 'Charakter erstellen';
$phprlang['view_date'] = 'Datum';
$phprlang['view_description_header'] = 'Raid-Beschreibung';
$phprlang['view_frozen'] = 'Anmeldungen sind eingefroren';
$phprlang['view_information_header'] = 'Information';
$phprlang['view_invite'] = 'Einladung';
$phprlang['view_location'] = 'Instanz';
$phprlang['view_login'] = 'Zum Anmelden bitte einloggen';
$phprlang['view_new'] = 'Für diesen Raid anmelden';
$phprlang['view_max'] = 'Maximale Teilnehmerzahl';
$phprlang['view_max_lvl'] = 'Maximalstufe';
$phprlang['view_min_lvl'] = 'Minimalstufe';
$phprlang['view_missing_signups_link_text'] = 'Zeige Profile, die sich NICHT für diesen Raid angemeldet haben.';
$phprlang['view_officer'] = 'Ersteller';
$phprlang['view_ok'] = 'Offen für Anmeldungen';
$phprlang['view_queue'] = 'Wie möchtest du dich anmelden?';
$phprlang['view_queue_header'] = 'Warteliste';
$phprlang['view_queued'] = 'Mitglieder auf der Warteliste';
$phprlang['view_raid_cancel_text'] = 'Zurückgezogene Anmeldungen';
$phprlang['view_signed'] = 'Bereits angemeldet';
$phprlang['view_signup'] = 'Anmeldeinformation';
$phprlang['view_signup_queue'] = 'In die Warteschlage anmelden';
$phprlang['view_signup_cancel'] = 'Als nicht verfügbar anmelden';
$phprlang['view_signup_draft'] = 'Für den Raid anmelden';
$phprlang['view_start'] = 'Startzeit';
$phprlang['view_statistics_header'] = 'Statistiken';
$phprlang['view_teams_link_text'] = 'Teams für diesen Raid erzeugen und zuweisen';
$phprlang['view_total'] = 'Anmeldungen insgesamt';
$phprlang['view_username'] = 'Benutzername';
$phprlang['view_missing_signups_return_to_view']= 'Back to Raid View'; //New

// main page
$phprlang['main_previous_raids'] = 'Beendete Raids';
$phprlang['main_upcoming_raids'] = 'Aktuelle Raids';
$phprlang['signup'] = 'Anmelden';
$phprlang['rss_feed_text'] = 'Raidanmeldungen RSS-Feed';
$phprlang['guild_time_string'] = 'Datum und Uhrzeit';
$phprlang['menu_header_text'] = 'WRM-Menü';

// teams
$phprlang['team_new_header'] = 'Neues Team erzeugen';
$phprlang['team_add_header'] = 'Mitglieder zu Team hinzufügen';
$phprlang['team_remove_header'] = 'Mitglieder aus Team entfernen';
$phprlang['teams_raid_view_text'] = 'Zurück zur Raidansicht';
$phprlang['team_cur_teams_header'] = 'Erzeugte Teams';
$phprlang['team_page_header'] = 'Teams';

// Boss Kill Tracking
$phprlang['boss_kill_type_dungeon'] = 'Dungeon (5/10 Man)';
$phprlang['boss_kill_type_25_man'] = '25 Man Raid';
$phprlang['boss_kill_type_10_man'] = '10 Man Raid';
$phprlang['boss_kill_type_40_man'] = '40 Man Raid';
$phprlang['bosskill_header'] = 'Track Named (Boss) Accomplishments';

//Raids Archive
$phprlang['raidsarchive_header'] = 'Raids Archive';

?>