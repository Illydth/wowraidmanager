<?php
/***************************************************************************
 *                          lang_pages.php (English)
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
$phprlang['announcements_header'] = 'Nyheter';
$phprlang['announcements_new_header'] = 'Lag ny Nyhet';
$phprlang['announcements_message_text'] = 'Melding';
$phprlang['announcements_title_text'] = 'Tittel';

// Calendar
$phprlang['invites'] = 'Inviterte';
$phprlang['start'] = 'Start';
$phprlang['key'] = 'Key:<br>(<span class="draftedmark">*</span>) = Påmeldt & utkast<br>(<span class="qcanmark">#</span>) = Påmeldt, ikke i utkastet (kø eller kannselert)<br><span class="priorDay">TEXT</span> datoer er i fortid.<br><span class="currentDay">TEXT</span> dato er idag.<br><span class="postDay">TEXT</span> dato er i fremtiden.';
$phprlang['calendar_month_select_header'] = 'Velg måned og år som skal vises';

// DKP View
$phprlang['eqdkp_system_link'] = 'Direct link to Associated DKP System:';

// guilds
$phprlang['guilds_header'] = 'Guild liste';
$phprlang['guilds_new_header'] = 'New Guild';
$phprlang['guilds_master'] = 'Guildmaster';
$phprlang['guilds_name'] = 'Fullt guild navn';
$phprlang['guilds_tag']	= 'Guild tag';						
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
$phprlang['locations_header'] = 'Lagret sted';
$phprlang['locations_max_lvl'] = 'Maximum Level';
$phprlang['locations_min_lvl'] = 'Minimum Level';
$phprlang['locations_limits_header'] = 'Raid begrensninger';
$phprlang['locations_long'] = 'Raid Hule';
$phprlang['locations_new'] = 'Lag ett nytt sted';
$phprlang['locations_raid_max'] = 'Raid Maks';
$phprlang['locations_short'] = 'Identifiserer';
$phprlang['lock_template'] = 'Lås Raid mal?';
$phprlang['locations_ro_text'] = 'Read Only: Populated With WoW Official Name for Instance';
$phprlang['locations_expansion_text'] = 'Expansion';
$phprlang['locations_events_text'] = 'Event Name';

// lua_output
$phprlang['rim_download'] = 'Last ned RIM (Raid Information Manager)';
$phprlang['phprv_download'] = 'Last ned phpRaidViewer';
$phprlang['lua_header'] = 'LUA/Macro utmating';
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
$phprlang['permissions_add'] = 'Legg til nytt sett';
$phprlang['permissions_announcements'] = 'Nyheter';
$phprlang['permissions_configuration'] = 'Konfigurasjon';
$phprlang['permissions_details_users_header'] = 'Detaljerte tilganger';
$phprlang['permissions_edit_header'] = 'Endre sett';
$phprlang['permissions_description'] = 'Beskrivelse';
$phprlang['permissions_details_header'] = 'Tilgang detaljer';
$phprlang['permissions_guilds'] = 'Guild';
$phprlang['permissions_header'] = 'Tilgang Sett';
$phprlang['permissions_locations'] = 'Steder';
$phprlang['permissions_logs'] = 'Logger';
$phprlang['permissions_name'] = 'Navn';
$phprlang['permissions_permissions'] = 'Tilganger';
$phprlang['permissions_profile'] = 'Profiler';
$phprlang['permissions_raids'] = 'Raids';
$phprlang['permissions_new'] = 'Lag et nytt set';
$phprlang['permissions_users'] = 'Brukere';
$phprlang['permissions_users_header'] = 'Brukere i sett';

// profile
$phprlang['profile_arcane'] = 'Arcane Resistance';
$phprlang['profile_class'] = 'Klasse';
$phprlang['profile_create_header'] = 'Character oppretting utilgjengelig';
$phprlang['profile_create_msg'] = 'Det må opprettes et guild først';
$phprlang['profile_fire'] = 'Fire Resistance';
$phprlang['profile_frost'] = 'Frost Resistance';
$phprlang['profile_gender'] = 'Kjønn';
$phprlang['profile_guild'] = 'Guild tilknytning';
$phprlang['profile_role'] = 'Rolle';
$phprlang['profile_header'] = 'Characters';
$phprlang['profile_level'] = 'Level';
$phprlang['profile_name'] = 'Navn';
$phprlang['profile_nature'] = 'Nature Resistance';
$phprlang['profile_raid'] = 'Raid Participation';
$phprlang['profile_race'] = 'Rase';
$phprlang['profile_shadow'] = 'Shadow Resistance';

// raids
$phprlang['raids_date'] = 'Dato';
$phprlang['raids_description'] = 'Beskrivelse';
$phprlang['raids_dungeon'] = 'Dungeon';
$phprlang['raids_freeze'] = 'Låses om (i timer)';
$phprlang['raids_invite'] = 'Inviter tid';
$phprlang['raids_limits'] = 'Raid begrensning';
$phprlang['raids_location'] = 'Lagret sted';
$phprlang['raids_max'] = 'Raid maximum';
$phprlang['raids_max_lvl'] = 'Maximum level';
$phprlang['raids_min_lvl'] = 'Minimum level';
$phprlang['raids_old'] = 'Tidligere begivenhet';
$phprlang['raids_new'] = 'Kommende begivenhet';
$phprlang['raids_new_header'] = 'Nytt Raid';
$phprlang['raids_start'] = 'Start tid';
$phprlang['raids_eventtype_text'] = 'Event Type';
$phprlang['raids_mark_selected_raids_to_old'] = "mark selected raids to old";

// event type
$phprlang['event_type_raid'] = 'Raid (10/25 man)';
$phprlang['event_type_dungeon'] = 'Dungeon (5 man Instance)';
$phprlang['event_type_pvp'] = 'PvP Event';
$phprlang['event_type_meeting'] = 'Meeting (online/offline)';
$phprlang['event_type_other'] = 'Other';

// expansions
$phprlang['exp_generic_wow'] = 'Generic World of Warcraft';
$phprlang['exp_burning_crusade'] = 'The Burning Crusade';
$phprlang['exp_wrath_lich_king'] = 'Wrath of the Lich King';
$phprlang['exp_cataclysm'] = 'Cataclysm';

// roster
$phprlang['roster_header'] = 'Guild Roster';

// registration
$phprlang['register_complete_header'] = 'Registrering suksess';
$phprlang['register_complete_msg'] = 'Du er nå registrert for WRM bruk.  På noen servere kan du nå opprette bruker og characters, på andre må du vente til du får tilgang.';
$phprlang['register_confirm'] = 'Passordene dine stemmer ikke.';
$phprlang['register_confirm_text'] = 'Skriv passord en gang til';
$phprlang['register_email_header'] = 'Registrering hos';
$phprlang['register_email_empty'] = 'Du må skrive en e-post adresse';
$phprlang['register_email_exists'] = 'E-mail adressen er allerede ibruk';
$phprlang['register_email_greeting'] = 'Velkommen';
$phprlang['register_email_subject'] = 'Denne mailen er for å bekrefte din registrering. Ikke reply.';
$phprlang['register_email_text'] = 'E-post addresse';
$phprlang['register_error'] = 'Registreringsfeil';
$phprlang['register_header'] = 'Bruker Registrering';
$phprlang['register_pass_empty'] = 'Du må skrive passord';
$phprlang['register_password_text'] = 'Passord';
$phprlang['register_user_empty'] = 'Du må skrive ett brukernavn';
$phprlang['register_user_exists'] = 'Det brukernavnet er allerede tatt.';
$phprlang['register_username_text'] = 'Brukernavn';

// users
$phprlang['users_assign'] = 'Velg';
$phprlang['users_char_header'] = 'Bruker characters';
$phprlang['users_header'] = 'Brukere';

// view
$phprlang['view_approved'] = 'Godkjennte medlemmer';
$phprlang['view_cancel_header'] = 'Kannsellerte påmeldinger';
$phprlang['view_character'] = 'Character';
$phprlang['view_comments'] = 'Kommentar';
$phprlang['view_create'] = 'Lag en character for å melde deg på.';
$phprlang['view_date'] = 'Dato';
$phprlang['view_description_header'] = 'Raid beskrivelse';
$phprlang['view_frozen'] = 'Påmelding er låst';
$phprlang['view_information_header'] = 'Informasjon';
$phprlang['view_invite'] = 'Inviteringstid';
$phprlang['view_location'] = 'Dungeon';
$phprlang['view_login'] = 'Logg inn for å melde deg på';
$phprlang['view_new'] = 'Påmelding til dette raidet';
$phprlang['view_max'] = 'Raid maks';
$phprlang['view_max_lvl'] = 'Maximum level';
$phprlang['view_min_lvl'] = 'Minimum level';
$phprlang['view_missing_signups_link_text'] = 'Se Profler som ikke har registrert seg til dette raidet.';
$phprlang['view_officer'] = 'Laget av';
$phprlang['view_ok'] = 'Åpen for påmelding';
$phprlang['view_queue'] = 'Vil du melde deg på?';
$phprlang['view_queue_header'] = 'Påmeldt i kø';
$phprlang['view_queued'] = 'Kø medlemmer';
$phprlang['view_raid_cancel_text'] = 'Kansellerte påmeldinger';
$phprlang['view_signed'] = 'Allerede påmeldt';
$phprlang['view_signup'] = 'Påmeldingsinformasjon';
$phprlang['view_signup_queue'] = 'Meld på til kø';
$phprlang['view_signup_cancel'] = 'Meld på til kansellert';
$phprlang['view_signup_draft'] = 'Meld på til raid (utkast)';
$phprlang['view_start'] = 'Start tid';
$phprlang['view_statistics_header'] = 'Statestikk';
$phprlang['view_teams_link_text'] = 'Lag og sett Lag for dette raidet';
$phprlang['view_total'] = 'Total påmelding';
$phprlang['view_username'] = 'Brukernavn';
$phprlang['view_missing_signups_return_to_view']= 'Back to Raid View'; //New

// main page
$phprlang['main_previous_raids'] = 'Tidligere begivenheter';
$phprlang['main_upcoming_raids'] = 'Kommende begivenhet';
$phprlang['signup'] = 'Meld på';
$phprlang['rss_feed_text'] = 'Raid påmelding RSS Feed';
$phprlang['guild_time_string'] = 'Guild Tid';
$phprlang['menu_header_text'] = 'WRM Meny';

// teams
$phprlang['team_new_header'] = 'Opprett nytt Lag';
$phprlang['team_add_header'] = 'Legg til medlem til Lag';
$phprlang['team_remove_header'] = 'Fjern Medlen fra Lag';
$phprlang['teams_raid_view_text'] = 'Tilbake til raid';
$phprlang['team_cur_teams_header'] = 'Opprettende Lag';
$phprlang['team_page_header'] = 'Lag';

// Boss Kill Tracking
$phprlang['boss_kill_type_dungeon'] = 'Dungeon (5/10 Man)';
$phprlang['boss_kill_type_25_man'] = '25 Man Raid';
$phprlang['boss_kill_type_10_man'] = '10 Man Raid';
$phprlang['boss_kill_type_40_man'] = '40 Man Raid';
$phprlang['bosskill_header'] = 'Track Named (Boss) Accomplishments';

//Raids Archive
$phprlang['raidsarchive_header'] = 'Raids Archive';

?>