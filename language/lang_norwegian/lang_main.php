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

// data output headers (Reports.php)
$phprlang['add_team']='Kryss av for å legge til Lag';
$phprlang['add_team_dropdown_text']='Velg Lag til å legge medlemmer til';
$phprlang['team_global']='Marker gruppe tilgjengelig for alle raid';
$phprlang['male'] = 'Mann';
$phprlang['female'] = 'Dame';
$phprlang['class'] = 'Class';
$phprlang['date'] = 'Dato';
$phprlang['description'] = 'Beskrivelse';
$phprlang['email'] = 'E-post';
$phprlang['guild'] = 'Guild';
$phprlang['guild_name'] = 'Guild Navn';
$phprlang['guild_master'] = 'Guildmaster';
$phprlang['guild_tag'] = 'Guild merke';
$phprlang['id'] = 'ID';
$phprlang['invite_time'] = 'Invite Tid';
$phprlang['level'] = 'Level';
$phprlang['location'] = 'Dungeon';
$phprlang['max_lvl'] = 'Maks Lvl';
$phprlang['max_raiders'] = 'Raid Maks';
$phprlang['locked_header'] = 'Låst?';
$phprlang['message'] = 'Melding';
$phprlang['min_lvl'] = 'Minimum Lvl';
$phprlang['name'] = 'Navn';
$phprlang['officer'] = 'Laget av';
$phprlang['no_data'] = 'Tom';
$phprlang['posted_by'] = 'Informert av';
$phprlang['race'] = 'Rase';
$phprlang['start_time'] = 'Start Tid';
$phprlang['team_name'] = 'Lag Navn';
$phprlang['time'] = 'Tid';
$phprlang['title'] = 'Tittel';
$phprlang['totals'] = 'Totalt';
$phprlang['username'] = 'Brukernavn';
$phprlang['records'] = 'Liste';
$phprlang['to'] = 'til';
$phprlang['of'] = 'av';
$phprlang['total'] = 'total';
$phprlang['section'] = 'Avsnitt';
$phprlang['prev'] = 'Forrige';
$phprlang['next'] = 'Neste';
$phprlang['earned'] = 'Tjent';
$phprlang['spent'] = 'Brukt';
$phprlang['adjustment'] = 'Justering';
$phprlang['dkp'] = 'DKP';

// roles
$phprlang['role'] = 'Rolle';
$phprlang['role_none'] = '-';
$phprlang['role_tank'] = 'Tank';
$phprlang['role_heal'] = 'Healer';
$phprlang['role_melee'] = 'Melee';
$phprlang['role_ranged'] = 'Ranged';
$phprlang['role_tankmelee'] = 'Tank eller Melee';

$phprlang['role_tanks'] = 'Tanks';
$phprlang['role_heals'] = 'Healers';
$phprlang['role_melees'] = 'Melee';
$phprlang['role_ranges'] = 'Ranged';
$phprlang['role_tankmelees'] = 'Tanks/Melee';

$phprlang['max_tanks'] = 'Maks Tanks';
$phprlang['max_heals'] = 'Maks Healers';
$phprlang['max_melees'] = 'Maks Melee';
$phprlang['max_ranged'] = 'Maks Ranged';
$phprlang['max_tkmels'] = 'Maks Tank/Melee';

// errors
$phprlang['connect_socked_error'] = 'Kunne ikke koble til socket med feilmelding %s';
$phprlang['invalid_group_title'] = 'Gruppen eksisterer';
$phprlang['invalid_group_message'] = 'Gruppen er allerede en del av dette settet. Trykk BACK for å prøve igjen.';
$phprlang['invalid_option_title'] = 'Feil input';
$phprlang['invalid_option_msg'] = 'Du har prøvd å vise denne siden på feil måte.';
$phprlang['no_user_msg'] = 'Denne brukeren finnes ikke.';
$phprlang['no_user_title'] = 'Bruker finnes ikke';
$phprlang['print_error_critical'] = 'en seriøs feil!';
$phprlang['print_error_details'] = 'Detaljer';
$phprlang['print_error_minor'] = 'en mindre feil!';
$phprlang['print_error_msg_begin'] = 'Beklager, WRM har funnet ';
$phprlang['print_error_msg_end'] = 'Hvis dette fortsetter, ta kontakt med en admin!';
$phprlang['print_error_page'] = 'Side';
$phprlang['print_error_query'] = 'Spørring';
$phprlang['print_error_title'] = 'Uh oh! Noe feil skjedde';
$phprlang['socket_functions_disabled'] = 'Kunne ikke koble til server.';

// forms
$phprlang['asc'] = 'stigende';
$phprlang['auth_phpbb_no_groups'] = 'Ingen grupper tilgjengelige';
$phprlang['desc'] = 'synkende';
$phprlang['form_error'] = 'Feil i formen';
$phprlang['form_select'] = 'Velg en';
$phprlang['no'] = 'Nei';
$phprlang['none'] = 'Ingen';
$phprlang['guild_name_missing'] = 'Fullt guild navn mangler.';
$phprlang['guild_tag_missing'] = 'Guild taggen mangler.';
$phprlang['permissions_form_description'] = 'Du må legge til en beskrivelse';
$phprlang['permissions_form_name'] = 'Du må legge til et navn';
$phprlang['profile_error_arcane'] = 'Arcane må være et tall';
$phprlang['profile_error_class'] = 'Du må velge en class';
$phprlang['profile_error_dupe'] = 'Dette navnet er allerede tatt';
$phprlang['profile_error_fire'] = 'Fire må være et tall';
$phprlang['profile_error_frost'] = 'Frost må være et tall';
$phprlang['profile_error_guild'] = 'Du må velge et guild';
$phprlang['profile_error_level'] = 'Level må være et tall mellom 1-70';
$phprlang['profile_error_name'] = 'Du må velge et navn';
$phprlang['profile_error_nature'] = 'Nature må være et tall';
$phprlang['profile_error_race'] = 'Du må velge en rase';
$phprlang['profile_error_role'] = 'Du må velge en rolle';
$phprlang['profile_error_shadow'] = 'Shadow må være et tall';
$phprlang['raid_error_date'] = 'Du må sette en skikkelig dato';
$phprlang['raid_error_description'] = 'Du må ha en beskrivelse';
$phprlang['raid_error_limits'] = 'Alle limits må være tall og fyllt ut';
$phprlang['raid_error_location'] = 'Du må ha et raid sted';
$phprlang['view_error_signed_up'] = 'Du har allerede siget opp med den characteren.';
$phprlang['view_error_role_undef'] = 'Sørg for at characteren har en definert rolle i  <a href="profile.php?mode=view">Profilen</a>.';
$phprlang['yes'] = 'Ja';

// Buttons
$phprlang['submit'] = 'Send';
$phprlang['reset'] = 'Reset';
$phprlang['confirm'] = 'Bekreft';
$phprlang['update'] = 'Oppdater';
$phprlang['confirm_deletion'] = 'Bekreft sletting';
$phprlang['filter'] = 'Filtrer';
$phprlang['addchar'] = 'Legg til Character';
$phprlang['updatechar'] = 'Oppdater Character';
$phprlang['login'] = 'Logg Inn';
$phprlang['logout'] = 'Logg Ut';
$phprlang['signup'] = 'Påmelding';


// generic information
$phprlang['delete_msg'] = 'NOTIS: Sletting er permanent. <br>Klikk under for å slette.';
$phprlang['maintenance_header'] = 'Site under vedlikehold';
$phprlang['maintenance_message'] = 'Vedlikehold pågår. Prøv igjen senere.';
$phprlang['disabled_header'] = 'Site deaktivert notis!';
$phprlang['disabled_message'] = 'Denne siden er deaktivert, og kan ikke brukes akuratt nå!<br>Gå til <u>Konfigurasjon</u> for å <u>aktivere WRM</u>';
$phprlang['userclass_msg'] = 'Din bruker er ikke autorisert til å bruke WRM, kontakt en admin.';
$phprlang['priv_title'] = 'Ikke nok tilgang';
$phprlang['priv_msg'] = 'Du har ikke tilgang til å vise denne siden. Hvis du mener dette er feil, ta kontakt med en admin.';
$phprlang['remember'] = 'Husk meg';
$phprlang['welcome'] = 'Velkommen ';

// Login Information
$phprlang['login_fail_title'] = 'Login feilet';
$phprlang['login_msg'] = 'Feil brukernavn og/eller passord, prøv igjen.';

// Days of the Week
$phprlang['sunday'] = 'Søndag';
$phprlang['monday'] = 'Mandag';
$phprlang['tuesday'] = 'Tirsdag';
$phprlang['wednesday'] = 'Onsdag';
$phprlang['thursday'] = 'Torsdag';
$phprlang['friday'] = 'Fredag';
$phprlang['saturday'] = 'Lørdag';
$phprlang['2ltrsunday'] = 'Sø';
$phprlang['2ltrmonday'] = 'Ma';
$phprlang['2ltrtuesday'] = 'Ti';
$phprlang['2ltrwednesday'] = 'On';
$phprlang['2ltrthursday'] = 'To';
$phprlang['2ltrfriday'] = 'Fr';
$phprlang['2ltrsaturday'] = 'Lø';						

// Months
$phprlang['month1'] = 'Januar';
$phprlang['month2'] = 'Februar';
$phprlang['month3'] = 'Mars';
$phprlang['month4'] = 'April';
$phprlang['month5'] = 'Mai';
$phprlang['month6'] = 'Juni';
$phprlang['month7'] = 'Juli';
$phprlang['month8'] = 'August';
$phprlang['month9'] = 'September';
$phprlang['month10'] = 'Oktober';
$phprlang['month11'] = 'November';
$phprlang['month12'] = 'Desember';
							
// links
$phprlang['announcements_link'] = '&raquo; Nyheter';
$phprlang['configuration_link'] = '&raquo; Konfigurer';
$phprlang['guilds_link'] = '&raquo; Guilder';
$phprlang['home_link'] = '&raquo; Hovedside';
$phprlang['calendar_link'] = '&raquo; Kalender';
$phprlang['locations_link'] = '&raquo; Steder';
$phprlang['logs_link'] = '&raquo; Logger';
$phprlang['permissions_link'] = '&raquo; Tilganger';
$phprlang['profile_link'] = '&raquo; Profiler';
$phprlang['raids_link'] = '&raquo; Raid';
$phprlang['register_link'] = '&raquo; Registrer';
$phprlang['roster_link'] = '&raquo; Roster';
$phprlang['users_link'] = '&raquo; Brukere';
$phprlang['lua_output_link'] = '&raquo; Lua utmating raid';
$phprlang['index_link'] = '&raquo; Hjem';
$phprlang['dkp_link'] = '&raquo; DKP';

// sorting information
$phprlang['sort_text'] = 'Trykk her for å sortere etter ';
$phprlang['sort_desc']='Klikk her for å sortere (synkende) av ';
$phprlang['sort_asc']='Klikk her for å sortere (stigende) av '; 

// tooltips
$phprlang['add'] = 'Legg til';
$phprlang['announcements'] = 'Nyheter';
$phprlang['arcane'] = 'Arcane';
$phprlang['calendar'] = 'Kalender';
$phprlang['cancel'] = 'Kanseller påmelding';
$phprlang['cancel_msg'] = 'Du har kansellert påmeldingen til dette raidet';
$phprlang['comments'] = 'Kommentarer';
$phprlang['configuration'] = 'Konfigurer';
$phprlang['delete'] = 'Slett';
$phprlang['description'] = 'Beskrivelse';
$phprlang['druid_icon'] = 'Klikk for å se druider';
$phprlang['edit'] = 'Endre';
$phprlang['edit_comment'] = 'Endre kommentar';
$phprlang['fire'] = 'Fire';
$phprlang['frost'] = 'Frost';
$phprlang['frozen_msg'] = 'Raidet er låst. Ikke mulig å melde seg på lenger.';
$phprlang['group_name'] = 'Gruppe Navn';
$phprlang['group_description'] = 'Gruppe Beskrivelse';
$phprlang['guilds'] = 'Guilds';
$phprlang['has_permission'] = 'Har Tilgang';
$phprlang['hunter_icon'] = 'Trykk for å se hunters';
$phprlang['in_queue'] = 'Sett bruker i kø';
$phprlang['last_login_date'] = 'Siste innloggingsdato';
$phprlang['last_login_time'] = 'Siste innloggingstid';
$phprlang['locations'] = 'Steder';
$phprlang['logs'] = 'Logger';
$phprlang['lua'] = 'LUA og macro utmating';
$phprlang['mage_icon'] = 'Trykk for å se mager';
$phprlang['mark'] = 'Marker raid som gammelt';
$phprlang['nature'] = 'Nature';
$phprlang['new'] = 'Marker raid som nytt';
$phprlang['not_signed_up'] = 'Trykk her for å signe opp til raid';
$phprlang['out_queue'] = 'Sett bruker som p�meldt';
$phprlang['paladin_icon'] = 'Trykk for å se  paladiner';
$phprlang['permissions'] = 'Tilganger';
$phprlang['priest_icon'] = 'Trykk for å se priests';
$phprlang['priv'] = 'Tilganger';
$phprlang['profile'] = 'Profil';
$phprlang['raids'] = 'Raids';
$phprlang['remove_group'] = 'Fjern gruppe fra sett';
$phprlang['remove_user'] = 'Fjern bruker fra sett';
$phprlang['rogue_icon'] = 'Trykk for å se roguer';
$phprlang['shadow'] = 'Shadow';
$phprlang['shaman_icon'] = 'Trykk for å se shamaner';
$phprlang['signed_up'] = 'Du er p�meldt dette raidet';
$phprlang['signup_add'] = 'Legg bruker til påmeldt';
$phprlang['signup_delete'] = 'Fjern bruker fra påmelding (permanent)';
$phprlang['users'] = 'Brukere';
$phprlang['warlock_icon'] = 'Trykk for å se warlocker';
$phprlang['warrior_icon'] = 'Trykk for å se warriorer';

?>