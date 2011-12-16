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
'announcements_header' =>  'Meddelanden',
'announcements_new_header' =>  'Skapa nytt Meddelande',
'announcements_message_text' =>  'Meddelande',
'announcements_title_text' =>  'Titel',

// Calendar
'invites' =>  'Inbjudan',
'start' =>  'Start',
'key' =>  'Nyckel:<br>Vit kant = Ej uppskriven<br>Grön kant = Uppskriven med status Uttagen<br>Blå kant = Uppskriven med status Tillgänglig<br>Röd kant = Uppskriven med status Ej tillgänglig<br><span class="priorDay">TEXT</span> datum har passerat.<br><span class="currentDay">TEXT</span> dagens datum.<br><span class="postDay">TEXT</span> framtida datum.', //New
'calendar_month_select_header' =>  'Välj månad och år att visa',

// DKP View
'eqdkp_system_link' =>  'Direkt länk till anslutet DKP System:',

// guilds
'guilds_header' =>  'Guild Listning',
'guilds_new_header' =>  'Nytt Guild',
'guilds_master' =>  'Guildmaster',
'guilds_name' =>  'Komplett Guild namn',
'guilds_tag'	=> 'Guild märke',						
'guilds_description' =>  'Guild Beskrivning',
'guilds_server' =>  'Guild Server',
'guilds_faction' =>  'Guild Faktion',
'guilds_armory_code' =>  'Armory kod för Guild',
'raid_force_header' =>  'Raidgrupp listning', //New
'raid_force_select_text' =>  'Välj Raidgrupp: ', //New
'raid_force_name_box_text' =>  'Raidgruppnamn', //New
'raid_force_guild_options_text' =>  'Guild', //New
'raid_force_new_header' =>  'Ny Raidgrupp länk', //New
'raid_force_name_missing' =>  'Raidgruppnamn kan ej vara tom eller ett nollvärde.', //New
'raid_force_duplicate' =>  'Raidgrupp eller Guild existerar', //New
'raid_force_guild_id_missing' =>  'Guild ID kan ej vara tom eller ett nollvärde.', //New
'armory_lang_US' =>  'US : http://us.battle.net/wow/ : English', //New
'armory_lang_EU' =>  'EU : http://eu.battle.net/wow/ : English', //New
'armory_lang_DE' =>  'DE : http://eu.battle.net/wow/ : German', //New
'armory_lang_ES' =>  'ES : http://eu.battle.net/wow/ : Spanish', //New
'armory_lang_FR' =>  'FR : http://eu.battle.net/wow/ : French', //New
'armory_lang_KR' =>  'KR : http://kr.battle.net/wow/ : Korean', //New
'armory_lang_TW' =>  'TW : http://tw.battle.net/wow/ : Taiwainese', //New
'armory_lang_none' =>  'Inget Armory eller ej applicerbart', //New

// locations
'locations_header' =>  'Sparade Instanser',
'locations_max_lvl' =>  'Högsta Level',
'locations_min_lvl' =>  'Lägsta Level',
'locations_limits_header' =>  'Raid begränsningar',
'locations_long' =>  'Raid Instans',
'locations_new' =>  'Skapa ny instans',
'locations_raid_max' =>  'Raid Max',
'locations_short' =>  'Förkortning',
'lock_template' =>  'Låst raid mall?',
'locations_ro_text' =>  'Skrivskyddad: Fylls i med officiellt namn från WoW.',
'locations_expansion_text' =>  'Expansion',
'locations_events_text' =>  'Event Namn',

// lua_output
'rim_download' =>  'Ladda ner RIM (Raid Information Manager)',
'phprv_download' =>  'Ladda ner phpRaidViewer',
'lua_header' =>  'LUA/Macro utskrift',
'sort_name' =>  'Namn',
'sort_date' =>  'Datum',
'output_rim' =>  'RIM (Raid Invite Manager)',
'output_phprv' =>  'PHP Raid Viewer',
'sort_signups_text' =>  'Sortera Uppskrivningar efter:',
'sort_queue_text' =>  'Sortera tillgängliga efter:',
'output_format_text' =>  'Output Format:',
'options_header' =>  'Inställningar',
'lua_output_header' =>  'Påbörjar LUA Utdata',
'lua_show_all_raids' =>  'Utdata alla Aktiva Raider',
'lua_failed_to_write' =>  'LUA filen kunde inte skapas på grund av skrivfel.</b><br/>' .
									'Vänligen sätt sätt loggnings nivån till att visa varningar (E_WARNING eller bättre) ' .
									'för att se felet.<br>' .
									'Använd detta för copy+paste:<br>',
'lua_rim_write_success' =>  '<b>LUA filen skapades.</b><br>' . 
									'Ladda ned <a href="cache/raid_lua/phpRaid_Data.lua">phpRaid_Data.lua</a> och spara 
									den till [wow-dir]\interface\addons\RIM\<br>' .
									'eller använd nedan för copy+paste:<br>',
'lua_prv_write_success' =>  '<b>LUA filen skapades.</b><br>' . 
									'Ladda ned <a href="cache/raid_lua/phpRaid_Data.lua">phpRaid_Data.lua</a> och spara
									den till [wow-dir]\interface\addons\phpraidviewer\<br>' .
									'eller använd nedan för copy+paste:<br>',
'lua_drafted' =>  'Uttagna Användare', //New
'lua_queued' =>  'Tillgängliga Användare', //New
'lua_macro_header' =>  'Macro utsignalslistan...', //New
'lua_macro_footer' =>  '<br>Macro utsignalslistan färdig.<br>Kopiera och klista in ovan i ett macro och kör i spelet.', //New

// permissions
'permissions_add' =>  'Lägg till i set',
'permissions_announcements' =>  'Nyheter',
'permissions_configuration' =>  'Konfiguration',
'permissions_details_users_header' =>  'Detaljerade Rättigheter',
'permissions_edit_header' =>  'Editera set',
'permissions_description' =>  'Beskrivning',
'permissions_details_header' =>  'Rättighetsdetaljer',
'permissions_guilds' =>  'Guilder',
'permissions_header' =>  'Rättighets Sets',
'permissions_locations' =>  'Instanser',
'permissions_logs' =>  'Loggar',
'permissions_name' =>  'Namn',
'permissions_permissions' =>  'Rättigheter',
'permissions_profile' =>  'Profil',
'permissions_raids' =>  'Raider',
'permissions_new' =>  'Skapa nytt set',
'permissions_users' =>  'Användare',
'permissions_users_header' =>  'Användare i setet',

// profile
'profile_arcane' =>  'Arcane Resistance',
'profile_class' =>  'Klass',
'profile_create_header' =>  'Karaktärsskapande inte tillgängligt',
'profile_create_msg' =>  'Tills dess en administratör skapar ett guild, kommer inte karaktärsskapande vara tillgängligt',
'profile_fire' =>  'Fire Resistance',
'profile_frost' =>  'Frost Resistance',
'profile_gender' =>  'Kön',
'profile_guild' =>  'Guild tillhörighet',
'profile_role' =>  'Roll',
'profile_header' =>  'Karaktärer',
'profile_level' =>  'Level',
'profile_name' =>  'Namn',
'profile_nature' =>  'Nature Resistance',
'profile_raid' =>  'Raid Deltagande',
'profile_race' =>  'Ras',
'profile_shadow' =>  'Shadow Resistance',
'iLvL' =>  "iLvL (Utrustad, Bästa)", //New
'health' =>  "Hälsa", //New
'mana' =>  "Mana", //New

// raids
'raids_date' =>  'Datum',
'raids_description' =>  'Beskrivning',
'raids_dungeon' =>  'Instans',
'raids_freeze' =>  'Frys begränsning (i timmar)',
'raids_invite' =>  'Inbjudningstid',
'raids_limits' =>  'Raid begränsning',
'raids_location' =>  'Sparad Instans',
'raids_max' =>  'Raid maximum',
'raids_max_lvl' =>  'Högsta level',
'raids_min_lvl' =>  'Lägsta level',
'raids_old' =>  'Gamla Raids',
'raids_new' =>  'Kommande Raids',
'raids_new_header' =>  'Skapa Ny Raid',
'raids_edit_header' =>  'Redigera Raid', //new
'raids_start' =>  'Starttid',
'raids_eventtype_text' =>  'Raid Typ',
'raids_mark_selected_raids_to_old' =>  "Sätt alla markerade raider som stängda och över",

// event type
'event_type_raid' =>  'Raid (10/25 man)',
'event_type_dungeon' =>  'Dungeon (5 man Instans)',
'event_type_pvp' =>  'PvP Event',
'event_type_meeting' =>  'Möte (online/offline)',
'event_type_other' =>  'Annat',

// expansions
'exp_generic_wow' =>  'Generic World of Warcraft',
'exp_burning_crusade' =>  'The Burning Crusade',
'exp_wrath_lich_king' =>  'Wrath of the Lich King',
'exp_cataclysm' =>  'Cataclysm',

// roster
'roster_header' =>  'Guild Roster',

// registration
'register_complete_header' =>  'Registreringen lyckades',
'register_complete_msg' =>  'Du är nu registrerad för användning av WRM. På vissa websidor kan du nu skapa din profil och användare, på andra måste du vänta tills en administratör godkänt din registrering innan du kan göra det.',
'register_confirm' =>  'Dina lösenord matchar inte.',
'register_confirm_text' =>  'Fyll i lösenord igen',
'register_email_header' =>  'Registrering hos',
'register_email_empty' =>  'Du måste fylla i en e-post adress',
'register_email_exists' =>  'Den E-post adressen nyttjas redan',
'register_email_greeting' =>  'Välkommen',
'register_email_subject' =>  'Detta e-post är till för att bekräfta din registrering. Svara inte, då ingen kommer att mottaga ditt svar.',
'register_email_text' =>  'E-post adress',
'register_error' =>  'Registrerings error',
'register_header' =>  'Användar Registrering',
'register_pass_empty' =>  'Du måste fylla i ett lösenord',
'register_password_text' =>  'Lösenord',
'register_user_empty' =>  'Du måste fylla i ett användarnamn',
'register_user_exists' =>  'Det användarnamnet är redan upptaget',
'register_username_text' =>  'Användarnamn',

// users
'users_assign' =>  'Tilldela',
'users_char_header' =>  'Användarkaraktärer',
'users_header' =>  'Användare',

// view
'view_approved' =>  'Uttagna spelare',
'view_cancel_header' =>  'Ej tillgängliga spelare',
'view_character' =>  'Karaktär',
'view_comments' =>  'Kommentar',
'view_create' =>  'Skapa en karaktär för att skriva upp dig',
'view_date' =>  'Datum',
'view_description_header' =>  'Raid beskrivning',
'view_frozen' =>  'Uppskrivningar har frusits',
'view_information_header' =>  'Information',
'view_invite' =>  'Inbjudningstid',
'view_location' =>  'Instans',
'view_login' =>  'Logga in för att skriva upp dig',
'view_new' =>  'Skriv upp dig till raiden',
'view_max' =>  'Raid max',
'view_max_lvl' =>  'Högsta level',
'view_min_lvl' =>  'Lägsta level',
'view_missing_signups_link_text' =>  'Visa Profiler som INTE har skrivit upp sig för denna raid.',
'view_officer' =>  'Skapare',
'view_ok' =>  'Öppet för Uppskrivning',
'view_queue' =>  'Hur vill du skriva upp dig??',
'view_queue_header' =>  'Tillgängliga spelare',
'view_queued' =>  'Tillgängliga spelare',
'view_raid_cancel_text' =>  'Ej tilgängliga registeringar',
'view_signed' =>  'Redan uppskriven',
'view_signup' =>  'Uppskrivnings Information',
'view_signup_queue' =>  'Skriv upp dig som Tillgänglig',
'view_signup_cancel' =>  'Skriv upp dig som Ej Tillgänglig',
'view_signup_draft' =>  'Skriv upp dig som Uttagen',
'view_start' =>  'Starttid',
'view_statistics_header' =>  'Statistik',
'view_teams_link_text' =>  'Skapa och tilldela ett lag för denna raid',
'view_total' =>  'Totala Uppskrivningar',
'view_username' =>  'Användarnamn',
'view_missing_signups_return_to_view' =>  'Tillbaka till Raid-Vy', //New

// main page
'main_previous_raids' =>  'Gamla Raids',
'main_upcoming_raids' =>  'Kommande Raids',
'signup' =>  'Skriv upp dig',
'rss_feed_text' =>  'Raid Feed',
'guild_time_string' =>  'Guild tid',
'menu_header_text' =>  'WRM Meny',

// teams
'team_new_header' =>  'Skapa nytt lag',
'team_add_header' =>  'Lägg till medlemmar i laget',
'team_remove_header' =>  'Ta bort medlemmar från laget',
'teams_raid_view_text' =>  'Återgå till Raid sidan',
'team_cur_teams_header' =>  'Skapade Lag',
'team_page_header' =>  'Lag',

// Boss Kill Tracking
'boss_kill_type_dungeon' =>  'Dungeon (5/10 Man)',
'boss_kill_type_25_man' =>  '25 Man Raid',
'boss_kill_type_10_man' =>  '10 Man Raid',
'boss_kill_type_40_man' =>  '40 Man Raid',
'bosskill_header' =>  'Spåra Namngivna (Boss) Prestationer',

//Raids Archive
'raidsarchive_header' =>  'Raid Arkiv',

));  ?>