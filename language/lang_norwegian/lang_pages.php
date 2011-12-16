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

if (empty($phprlang) || !is_array($phprlang))
	$phprlang = array();
	
$phprlang = array_merge($phprlang, array(

// announcements
'announcements_header' =>  'Nyheter',
'announcements_new_header' =>  'Lag ny Nyhet',
'announcements_message_text' =>  'Melding',
'announcements_title_text' =>  'Tittel',

// Calendar
'invites' =>  'Inviterte',
'start' =>  'Start',
'key' =>  'Key:<br>White Border = Not Signed Up<br>Green Border = Signed Up & Drafted<br>Blue Border = Signed Up, Not Drafted (queued)<br>Red Border = Signup Cancelled<br><span class="priorDay">TEXT</span> dates are in the past.<br><span class="currentDay">TEXT</span> date is today.<br><span class="postDay">TEXT</span> dates are in the future.', //New
'calendar_month_select_header' =>  'Velg måned og år som skal vises',

// DKP View
'eqdkp_system_link' =>  'Direct link to Associated DKP System:',

// guilds
'guilds_header' =>  'Guild liste',
'guilds_new_header' =>  'New Guild',
'guilds_master' =>  'Guildmaster',
'guilds_name' =>  'Fullt guild navn',
'guilds_tag'	=> 'Guild tag',						
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
'locations_header' =>  'Lagret sted',
'locations_max_lvl' =>  'Maximum Level',
'locations_min_lvl' =>  'Minimum Level',
'locations_limits_header' =>  'Raid begrensninger',
'locations_long' =>  'Raid Hule',
'locations_new' =>  'Lag ett nytt sted',
'locations_raid_max' =>  'Raid Maks',
'locations_short' =>  'Identifiserer',
'lock_template' =>  'Lås Raid mal?',
'locations_ro_text' =>  'Read Only: Populated With WoW Official Name for Instance',
'locations_expansion_text' =>  'Expansion',
'locations_events_text' =>  'Event Name',

// lua_output
'rim_download' =>  'Last ned RIM (Raid Information Manager)',
'phprv_download' =>  'Last ned phpRaidViewer',
'lua_header' =>  'LUA/Macro utmating',
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
'permissions_add' =>  'Legg til nytt sett',
'permissions_announcements' =>  'Nyheter',
'permissions_configuration' =>  'Konfigurasjon',
'permissions_details_users_header' =>  'Detaljerte tilganger',
'permissions_edit_header' =>  'Endre sett',
'permissions_description' =>  'Beskrivelse',
'permissions_details_header' =>  'Tilgang detaljer',
'permissions_guilds' =>  'Guild',
'permissions_header' =>  'Tilgang Sett',
'permissions_locations' =>  'Steder',
'permissions_logs' =>  'Logger',
'permissions_name' =>  'Navn',
'permissions_permissions' =>  'Tilganger',
'permissions_profile' =>  'Profiler',
'permissions_raids' =>  'Raids',
'permissions_new' =>  'Lag et nytt set',
'permissions_users' =>  'Brukere',
'permissions_users_header' =>  'Brukere i sett',

// profile
'profile_arcane' =>  'Arcane Resistance',
'profile_class' =>  'Klasse',
'profile_create_header' =>  'Character oppretting utilgjengelig',
'profile_create_msg' =>  'Det må opprettes et guild først',
'profile_fire' =>  'Fire Resistance',
'profile_frost' =>  'Frost Resistance',
'profile_gender' =>  'Kjønn',
'profile_guild' =>  'Guild tilknytning',
'profile_role' =>  'Rolle',
'profile_header' =>  'Characters',
'profile_level' =>  'Level',
'profile_name' =>  'Navn',
'profile_nature' =>  'Nature Resistance',
'profile_raid' =>  'Raid Participation',
'profile_race' =>  'Rase',
'profile_shadow' =>  'Shadow Resistance',
'iLvL' =>  "iLvL (Equipped, Best)", //New
'health' =>  "Health", //New
'mana' =>  "Mana", //New

// raids
'raids_date' =>  'Dato',
'raids_description' =>  'Beskrivelse',
'raids_dungeon' =>  'Dungeon',
'raids_freeze' =>  'Låses om (i timer)',
'raids_invite' =>  'Inviter tid',
'raids_limits' =>  'Raid begrensning',
'raids_location' =>  'Lagret sted',
'raids_max' =>  'Raid maximum',
'raids_max_lvl' =>  'Maximum level',
'raids_min_lvl' =>  'Minimum level',
'raids_old' =>  'Tidligere begivenhet',
'raids_new' =>  'Kommende begivenhet',
'raids_new_header' =>  'Nytt Raid',
'raids_edit_header' =>  'Edit Raid', //new
'raids_start' =>  'Start tid',
'raids_eventtype_text' =>  'Event Type',
'raids_mark_selected_raids_to_old' =>  "all mark raids are closed and over",

// event type
'event_type_raid' =>  'Raid (10/25 man)',
'event_type_dungeon' =>  'Dungeon (5 man Instance)',
'event_type_pvp' =>  'PvP Event',
'event_type_meeting' =>  'Meeting (online/offline)',
'event_type_other' =>  'Other',

// expansions
'exp_generic_wow' =>  'Generic World of Warcraft',
'exp_burning_crusade' =>  'The Burning Crusade',
'exp_wrath_lich_king' =>  'Wrath of the Lich King',
'exp_cataclysm' =>  'Cataclysm',

// roster
'roster_header' =>  'Guild Roster',

// registration
'register_complete_header' =>  'Registrering suksess',
'register_complete_msg' =>  'Du er nå registrert for WRM bruk.  På noen servere kan du nå opprette bruker og characters, på andre må du vente til du får tilgang.',
'register_confirm' =>  'Passordene dine stemmer ikke.',
'register_confirm_text' =>  'Skriv passord en gang til',
'register_email_header' =>  'Registrering hos',
'register_email_empty' =>  'Du må skrive en e-post adresse',
'register_email_exists' =>  'E-mail adressen er allerede ibruk',
'register_email_greeting' =>  'Velkommen',
'register_email_subject' =>  'Denne mailen er for å bekrefte din registrering. Ikke reply.',
'register_email_text' =>  'E-post addresse',
'register_error' =>  'Registreringsfeil',
'register_header' =>  'Bruker Registrering',
'register_pass_empty' =>  'Du må skrive passord',
'register_password_text' =>  'Passord',
'register_user_empty' =>  'Du må skrive ett brukernavn',
'register_user_exists' =>  'Det brukernavnet er allerede tatt.',
'register_username_text' =>  'Brukernavn',

// users
'users_assign' =>  'Velg',
'users_char_header' =>  'Bruker characters',
'users_header' =>  'Brukere',

// view
'view_approved' =>  'Godkjennte medlemmer',
'view_cancel_header' =>  'Kannsellerte påmeldinger',
'view_character' =>  'Character',
'view_comments' =>  'Kommentar',
'view_create' =>  'Lag en character for å melde deg på.',
'view_date' =>  'Dato',
'view_description_header' =>  'Raid beskrivelse',
'view_frozen' =>  'Påmelding er låst',
'view_information_header' =>  'Informasjon',
'view_invite' =>  'Inviteringstid',
'view_location' =>  'Dungeon',
'view_login' =>  'Logg inn for å melde deg på',
'view_new' =>  'Påmelding til dette raidet',
'view_max' =>  'Raid maks',
'view_max_lvl' =>  'Maximum level',
'view_min_lvl' =>  'Minimum level',
'view_missing_signups_link_text' =>  'Se Profler som ikke har registrert seg til dette raidet.',
'view_officer' =>  'Laget av',
'view_ok' =>  'Åpen for påmelding',
'view_queue' =>  'Vil du melde deg på?',
'view_queue_header' =>  'Påmeldt i kø',
'view_queued' =>  'Kø medlemmer',
'view_raid_cancel_text' =>  'Kansellerte påmeldinger',
'view_signed' =>  'Allerede påmeldt',
'view_signup' =>  'Påmeldingsinformasjon',
'view_signup_queue' =>  'Meld på til kø',
'view_signup_cancel' =>  'Meld på til kansellert',
'view_signup_draft' =>  'Meld på til raid (utkast)',
'view_start' =>  'Start tid',
'view_statistics_header' =>  'Statestikk',
'view_teams_link_text' =>  'Lag og sett Lag for dette raidet',
'view_total' =>  'Total påmelding',
'view_username' =>  'Brukernavn',
'view_missing_signups_return_to_view' =>  'Back to Raid View', //New

// main page
'main_previous_raids' =>  'Tidligere begivenheter',
'main_upcoming_raids' =>  'Kommende begivenhet',
'signup' =>  'Meld på',
'rss_feed_text' =>  'Raid påmelding RSS Feed',
'guild_time_string' =>  'Guild Tid',
'menu_header_text' =>  'WRM Meny',

// teams
'team_new_header' =>  'Opprett nytt Lag',
'team_add_header' =>  'Legg til medlem til Lag',
'team_remove_header' =>  'Fjern Medlen fra Lag',
'teams_raid_view_text' =>  'Tilbake til raid',
'team_cur_teams_header' =>  'Opprettende Lag',
'team_page_header' =>  'Lag',

// Boss Kill Tracking
'boss_kill_type_dungeon' =>  'Dungeon (5/10 Man)',
'boss_kill_type_25_man' =>  '25 Man Raid',
'boss_kill_type_10_man' =>  '10 Man Raid',
'boss_kill_type_40_man' =>  '40 Man Raid',
'bosskill_header' =>  'Track Named (Boss) Accomplishments',

//Raids Archive
'raidsarchive_header' =>  'Raids Archive',

));  ?>