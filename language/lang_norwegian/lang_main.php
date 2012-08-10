<?php
/***************************************************************************
 *                           lang_main.php (English)
 *                            -------------------
 *   begin                : Saturday, Jan 16, 2005
 *   copyright            : (C) 2007-2008 Douglas Wagner
 *   email                : douglasw@wagnerweb.org
 *
 *   $Id: lang_main.php,v 2.00 2008/03/07 13:46:51 psotfx Exp $
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
global $phprlang;

// logging language file
require_once('lang_log.php');

// page specific language file
require_once('lang_pages.php');

// world of warcraft language file
require_once('lang_wow.php');

// admin section language file
require_once('lang_admin.php');

if (empty($phprlang) || !is_array($phprlang))
	$phprlang = array();
	
$phprlang = array_merge($phprlang, array(

// data output headers (Reports.php)
'add_team' => 'Kryss av for å legge til Lag',
'add_team_dropdown_text' => 'Velg Lag til å legge medlemmer til',
'team_global' => 'Marker gruppe tilgjengelig for alle raid',
'male' =>  'Mann',
'female' =>  'Dame',
'class' =>  'Class',
'date' =>  'Dato',
'description' =>  'Beskrivelse',
'email' =>  'E-post',
'guild' =>  'Guild',
'guild_name' =>  'Guild Navn',
'guild_master' =>  'Guildmaster',
'guild_tag' =>  'Guild merke',
'guild_description' =>  'Guild Description',
'guild_server' =>  'Guild Server',
'guild_faction' =>  'Guild Faction',
'guild_armory_link' =>  'Armory Link',
'guild_armory_code' =>  'Armory Code',
'guild_id' =>  'Guild ID',
'raid_force_id' =>  'Raid Force ID',
'raid_force_name' =>  'Raid Force',
'id' =>  'ID',
'invite_time' =>  'Invite Tid',
'level' =>  'Level',
'location' =>  'Dungeon',
'max_lvl' =>  'Maks Lvl',
'max_raiders' =>  'Raid Maks',
'locked_header' =>  'Låst?',
'message' =>  'Melding',
'min_lvl' =>  'Minimum Lvl',
'name' =>  'Navn',
'officer' =>  'Laget av',
'no_data' =>  'Tom',
'posted_by' =>  'Informert av',
'race' =>  'Rase',
'start_time' =>  'Start Tid',
'team_name' =>  'Lag Navn',
'time' =>  'Tid',
'title' =>  'Tittel',
'totals' =>  'Totalt',
'username' =>  'Brukernavn',
'records' =>  'Liste',
'to' =>  'til',
'of' =>  'av',
'total' =>  'total',
'section' =>  'Avsnitt',
'prev' =>  'Forrige',
'next' =>  'Neste',
'earned' =>  'Tjent',
'spent' =>  'Brukt',
'adjustment' =>  'Justering',
'dkp' =>  'DKP',
'buttons' =>  'Buttons',
'add_to_team' =>  'Add To Team',
'create_date' =>  'Create Date',
'create_time' =>  'Create Time',
'pri_spec' =>  'Pri Talent',
'sec_spec' =>  'Sec Talent',
'signup_spec' =>  'Draft As',
'talent_tree' =>  'Talent Tree',
'display_text' =>  'Display Text',
'perm_mod' =>  'Update Permissions',
'all' =>  'All',

// Recurrance Text Items
'recur_header' =>  'Raid Recurrance Settings',
'raids_recur' =>  'Recurring Raids',
'daily' =>  'Daily (Every Day At This Time)',
'weekly' =>  'Weekly (On This Day of the Week)',
'monthly' =>  'Monthly (On This Day of the Month)',
'recurrance' =>  'Recurring Raid?<br><a href="../docs/recurring_raids.html" target="_blank">help?</a>',
'recur_interval' =>  'Recurrance Interval',
'recur_length' =>  'Number of Intervals to Show',

// Scheduler Texts
'scheduler_error_header' =>  'Scheduler Error',
'scheduler_unknown' =>  'The scheduler threw an Unknown error, please post the error message to WRM support.',
'scheduler_error_no_raid_found' =>  'No raid found when attempting to select the current recurring raid from the raids table.
												Recurring Raid was likely deleted, please reload the page.',
'scheduler_error_schedule_raid' =>  'Error Scheduling New Raids from Recurring Raids.',
'scheduler_error_sql_error' =>  'Generic SQL Error Occured, See Above Printed Information.',
'scheduler_error_update_recurring' =>  'Failed to Update Timestamp on Recurring Raid.',
'scheduler_error_class_limits_missing' =>  'Class Limits could not be retrieved for Recurring Raid.  
													Delete Recurring Raid and Try again.',
'scheduler_error_role_limits_missing' =>  'Role Limits could not be retrieved for Recurring Raid.  
													Delete Recurring Raid and Try again.',

// roles
'role_none' =>  '-',
'role' =>  'Role', //New

// errors
'connect_socked_error' =>  'Kunne ikke koble til socket med feilmelding %s',
'invalid_group_title' =>  'Gruppen eksisterer',
'invalid_group_message' =>  'Gruppen er allerede en del av dette settet. Trykk BACK for å prøve igjen.',
'invalid_option_title' =>  'Feil input',
'invalid_option_msg' =>  'Du har prøvd å vise denne siden på feil måte.',
'no_user_msg' =>  'Denne brukeren finnes ikke.',
'no_user_title' =>  'Bruker finnes ikke',
'print_error_critical' =>  'en seriøs feil!',
'print_error_details' =>  'Detaljer',
'print_error_minor' =>  'en mindre feil!',
'print_error_msg_begin' =>  'Beklager, WRM har funnet ',
'print_error_msg_end' =>  'Hvis dette fortsetter, ta kontakt med en admin!',
'print_error_page' =>  'Side',
'print_error_query' =>  'Spørring',
'print_error_title' =>  'Uh oh! Noe feil skjedde',
'socket_functions_disabled' =>  'Kunne ikke koble til server.',

// forms
'asc' =>  'stigende',
'auth_phpbb_no_groups' =>  'Ingen grupper tilgjengelige',
'desc' =>  'synkende',
'form_error' =>  'Feil i formen',
'form_select' =>  'Velg en',
'no' =>  'Nei',
'none' =>  'Ingen',
'guild_name_missing' =>  'Fullt guild navn mangler.',
'guild_tag_missing' =>  'Guild taggen mangler.',
'permissions_form_description' =>  'Du må legge til en beskrivelse',
'permissions_form_name' =>  'Du må legge til et navn',
'profile_error_arcane' =>  'Arcane må være et tall',
'profile_error_class' =>  'Du må velge en class',
'profile_error_dupe' =>  'Dette navnet er allerede tatt',
'profile_error_fire' =>  'Fire må være et tall',
'profile_error_frost' =>  'Frost må være et tall',
'profile_error_guild' =>  'Du må velge et guild',
'profile_error_level' =>  'Level må være et tall mellom 1-80',
'profile_error_name' =>  'Du må velge et navn',
'profile_error_nature' =>  'Nature må være et tall',
'profile_error_race' =>  'Du må velge en rase',
'profile_error_role' =>  'Du må velge en rolle',
'profile_error_shadow' =>  'Shadow må være et tall',
'raid_error_date' =>  'Du må sette en skikkelig dato',
'raid_error_description' =>  'Du må ha en beskrivelse',
'raid_error_limits' =>  'Alle limits må være tall og fyllt ut',
'raid_error_location' =>  'Du må ha et raid sted',
'view_error_signed_up' =>  'Du har allerede siget opp med den characteren.',
'view_error_role_undef' =>  'Sørg for at characteren har en definert rolle i  <a href="profile.php?mode=view">Profilen</a>.',
'yes' =>  'Ja',
'teams_error_no_team' =>  'No team is selected to add users to.',

// Buttons
'submit' =>  'Send',
'reset' =>  'Reset',
'confirm' =>  'Bekreft',
'update' =>  'Oppdater',
'confirm_deletion' =>  'Bekreft sletting',
'filter' =>  'Filtrer',
'addchar' =>  'Legg til Character',
'updatechar' =>  'Oppdater Character',
'login' =>  'Logg Inn',
'logout' =>  'Logg Ut',
'signup' =>  'Påmelding',
'apply' =>  'Apply Options',

// generic information
'delete_msg' =>  'NOTIS: Sletting er permanent. <br>Klikk under for å slette.',
'maintenance_header' =>  'Site under vedlikehold',
'maintenance_message' =>  'Vedlikehold pågår. Prøv igjen senere.',
'disabled_header' =>  'Site deaktivert notis!',
'disabled_message' =>  'Denne siden er deaktivert, og kan ikke brukes akuratt nå!<br>Gå til <u>Konfigurasjon</u> for å <u>aktivere WRM</u>',
'userclass_msg' =>  'Din bruker er ikke autorisert til å bruke WRM, kontakt en admin.',
'priv_title' =>  'Ikke nok tilgang',
'priv_msg' =>  'Du har ikke tilgang til å vise denne siden. Hvis du mener dette er feil, ta kontakt med en admin.',
'remember' =>  'Husk meg',
'welcome' =>  'Velkommen ',

// Login Information
'login_fail_title' =>  'Login feilet',
'login_msg' =>  'Feil brukernavn og/eller passord, prøv igjen.',

// Days of the Week
'sunday' =>  'Søndag',
'monday' =>  'Mandag',
'tuesday' =>  'Tirsdag',
'wednesday' =>  'Onsdag',
'thursday' =>  'Torsdag',
'friday' =>  'Fredag',
'saturday' =>  'Lørdag',
'2ltrsunday' =>  'Sø',
'2ltrmonday' =>  'Ma',
'2ltrtuesday' =>  'Ti',
'2ltrwednesday' =>  'On',
'2ltrthursday' =>  'To',
'2ltrfriday' =>  'Fr',
'2ltrsaturday' =>  'Lø',						

// Months
'month' =>  'Month',
'year' =>  'Year',
'month1' =>  'Januar',
'month2' =>  'Februar',
'month3' =>  'Mars',
'month4' =>  'April',
'month5' =>  'Mai',
'month6' =>  'Juni',
'month7' =>  'Juli',
'month8' =>  'August',
'month9' =>  'September',
'month10' =>  'Oktober',
'month11' =>  'November',
'month12' =>  'Desember',
							
// links
'announcements_link' =>  '&raquo; Nyheter',
'configuration_link' =>  '&raquo; Konfigurer',
'guilds_link' =>  '&raquo; Guilder',
'home_link' =>  '&raquo; Hovedside',
'calendar_link' =>  '&raquo; Kalender',
'locations_link' =>  '&raquo; Steder',
'permissions_link' =>  '&raquo; Tilganger',
'profile_link' =>  '&raquo; Profiler',
'raids_link' =>  '&raquo; Raid',
'register_link' =>  '&raquo; Registrer',
'roster_link' =>  '&raquo; Roster',
'users_link' =>  '&raquo; Brukere',
'lua_output_link' =>  '&raquo; Lua utmating raid',
'index_link' =>  '&raquo; Hjem',
'dkp_link' =>  '&raquo; DKP',
'bosstrack_link' =>  '&raquo; Boss Kill Tracking',
'raidsarchive_link' =>  '&raquo; Raids Archive',

// sorting information
'sort_text' =>  'Trykk her for å sortere etter ',
'sort_desc' => 'Klikk her for å sortere (synkende) av ',
'sort_asc' => 'Klikk her for å sortere (stigende) av ', 

// tooltips
'add' =>  'Legg til',
'announcements' =>  'Nyheter',
'calendar' =>  'Kalender',
'cancel' =>  'Kanseller påmelding',
'cancel_msg' =>  'Du har kansellert påmeldingen til dette raidet',
'comments' =>  'Kommentarer',
'configuration' =>  'Konfigurer',
'delete' =>  'Slett',
'description' =>  'Beskrivelse',
'edit' =>  'Endre',
'edit_comment' =>  'Endre kommentar',
'frozen_msg' =>  'Raidet er låst. Ikke mulig å melde seg på lenger.',
'group_name' =>  'Gruppe Navn',
'group_description' =>  'Gruppe Beskrivelse',
'guilds' =>  'Guilds',
'has_permission' =>  'Har Tilgang',
'in_queue' =>  'Sett bruker i kø',
'last_login_date' =>  'Siste innloggingsdato',
'last_login_time' =>  'Siste innloggingstid',
'locations' =>  'Steder',
'logs' =>  'Logger',
'lua' =>  'LUA og macro utmating',
'mark' =>  'Marker raid som gammelt',
'new' =>  'Marker raid som nytt',
'not_signed_up' =>  'Trykk her for å signe opp til raid',
'out_queue' =>  'Sett bruker som p�meldt',
'permissions' =>  'Tilganger',
'priv' =>  'Tilganger',
'profile' =>  'Profil',
'raids' =>  'Raids',
'remove_group' =>  'Fjern gruppe fra sett',
'remove_user' =>  'Fjern bruker fra sett',
'signed_up' =>  'Du er p�meldt dette raidet',
'signup_add' =>  'Legg bruker til påmeldt',
'signup_delete' =>  'Fjern bruker fra påmelding (permanent)',
'users' =>  'Brukere',

));  
?>