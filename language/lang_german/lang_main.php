<?php
/***************************************************************************
 *                           lang_main.php (German)
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
$phprlang['add_team']='Zum Team hinzufügen';
$phprlang['add_team_dropdown_text']='Team, zu dem Mitglieder hinzugefügt werdensollen';
$phprlang['team_global']='Team für alle Raids verfügbar machen';
$phprlang['male'] = 'männlich';
$phprlang['female'] = 'weiblich';
$phprlang['class'] = 'Klasse';
$phprlang['date'] = 'Datum';
$phprlang['description'] = 'Beschreibung';
$phprlang['email'] = 'E-Mail';
$phprlang['guild'] = 'Gilde';
$phprlang['guild_name'] = 'Gildenname';
$phprlang['guild_master'] = 'Gildenmeister';
$phprlang['guild_tag'] = 'Gildenkürzel';
$phprlang['id'] = 'ID';
$phprlang['invite_time'] = 'Einladung';
$phprlang['level'] = 'Stufe';
$phprlang['location'] = 'Instanz';
$phprlang['max_lvl'] = 'Höchststufe';
$phprlang['max_raiders'] = 'Raidmaximum';
$phprlang['locked_header'] = 'Gesperrt?';
$phprlang['message'] = 'Nachricht';
$phprlang['min_lvl'] = 'Mindeststufe';
$phprlang['name'] = 'Name';
$phprlang['officer'] = 'Ersteller';
$phprlang['no_data'] = 'Leer';
$phprlang['posted_by'] = 'Geschrieben von';
$phprlang['race'] = 'Rasse';
$phprlang['start_time'] = 'Startzeit';
$phprlang['team_name'] = 'Team-Name';
$phprlang['time'] = 'Zeit';
$phprlang['title'] = 'Titel';
$phprlang['totals'] = 'Gesamt';
$phprlang['username'] = 'Benutzername';
$phprlang['records'] = 'Datensätze';
$phprlang['to'] = 'bis';
$phprlang['of'] = 'von';
$phprlang['total'] = 'insgesamt';
$phprlang['section'] = 'Abschnitt';
$phprlang['prev'] = 'Zurück';
$phprlang['next'] = 'Weiter';
$phprlang['earned'] = 'Erhalten';
$phprlang['spent'] = 'Ausgegeben';
$phprlang['adjustment'] = 'Anpassung';
$phprlang['dkp'] = 'DKP';

// roles
$phprlang['role'] = 'Rolle';
$phprlang['role_none'] = '-';
$phprlang['role_tank'] = 'Tank';
$phprlang['role_heal'] = 'Heiler';
$phprlang['role_melee'] = 'Nahkämpfer';
$phprlang['role_ranged'] = 'Fernkämpfer';
$phprlang['role_tankmelee'] = 'Tank oder Nahkämpfer';

$phprlang['role_tanks'] = 'Tanks';
$phprlang['role_heals'] = 'Heiler';
$phprlang['role_melees'] = 'Nahkämpfer';
$phprlang['role_ranges'] = 'Fernkämpfer';
$phprlang['role_tankmelees'] = 'Tanks/Nahkämpfer';

$phprlang['max_tanks'] = 'Erwünschte Tanks';
$phprlang['max_heals'] = 'Erwünschte Heiler';
$phprlang['max_melees'] = 'Erwünschte Nahkämpfer';
$phprlang['max_ranged'] = 'Erwünschte Fernkämpfer';
$phprlang['max_tkmels'] = 'Erwünschte Tanks oder Nahkämpfer';

// errors
$phprlang['connect_socked_error'] = 'Fehler beim Aufbau der Socket-Verbindung:  %s';
// unused: $phprlang['invalid_group_title'] = 'Group exists';
// unused: $phprlang['invalid_group_message'] = 'The group selected is already part of this set. Press your browsers BACK button to try again.';
$phprlang['invalid_option_title'] = 'Ungültigte Eingabe für die Seite';
$phprlang['invalid_option_msg'] = 'Du hast versucht, diese Seite mit ungültigenEingabe aufzurufen.';
$phprlang['no_user_msg'] = 'Der Benutzer, den du dir ansehen möchtest, existiert nicht oder wurde gelöscht.';
$phprlang['no_user_title'] = 'Benutzer existiert nicht';
$phprlang['print_error_critical'] = 'kritischen Fehler entdeckt!';
$phprlang['print_error_details'] = 'Details';
$phprlang['print_error_minor'] = 'kleinen Fehler entdeckt!';
$phprlang['print_error_msg_begin'] = 'Entschuldigung, phhRaid hat einen ';
$phprlang['print_error_msg_end'] = 'Wenn der Fehler weiter auftritt, erzeuge bitte ein Posting 
									mit dieser Nachricht <br>in den <a href="http://www.spiffyjr.com/forums/">SpiffyJr.com-Forums</a> und
									wir werden unser Bestes geben, um ihn zu beheben. Danke!';
$phprlang['print_error_page'] = 'Seite';
$phprlang['print_error_query'] = 'Anfrage';
$phprlang['print_error_title'] = 'Oh-oh! Da ist ein Fehler passiert';
$phprlang['socket_functions_disabled'] = 'Die Versionsprüfung konnte den Servernicht erreichen.';

// forms
$phprlang['asc'] = 'aufsteigender';
$phprlang['auth_phpbb_no_groups'] = 'Keine Gruppen zum Hinzufügen verfügbar';
$phprlang['desc'] = 'absteigender';
$phprlang['form_error'] = 'Fehler beim Abschicken des Formulars';
$phprlang['form_select'] = 'Bitte wählen';
$phprlang['no'] = 'Nein';
$phprlang['none'] = 'Keine';
$phprlang['permissions_form_description'] = 'Du musst eine Beschreibung eingeben';
$phprlang['permissions_form_name'] = 'Du musst einen Namen eingeben';
$phprlang['profile_error_arcane'] = 'Arkanwiderstand muss nummerisch sein';
$phprlang['profile_error_class'] = 'Du musst eine Klasse auswählen';
$phprlang['profile_error_dupe'] = 'Ein Character mit diesem Namen existiert bereits';
$phprlang['profile_error_fire'] = 'Feuerwiderstand muss nummerisch sein';
$phprlang['profile_error_frost'] = 'Frostwiderstand muss nummerisch sein';
$phprlang['profile_error_guild'] = 'Du musst eine Gilde auswählen';
$phprlang['profile_error_level'] = 'Stufe muss nummerisch und zwischen 1 und 70 sein';
$phprlang['profile_error_name'] = 'Du musst einen Namen eingeben';
$phprlang['profile_error_nature'] = 'Naturwiderstand muss nummerisch sein';
$phprlang['profile_error_race'] = 'Du musst eine Rasse auswählen';
$phprlang['profile_error_role'] = 'Du musst eine Rolle auswählen';
$phprlang['profile_error_shadow'] = 'Schattenwiderstand muss nummerisch sein';
$phprlang['raid_error_date'] = 'Du musst ein gültiges Datum eingeben';
$phprlang['raid_error_description'] = 'Du musst eine Beschreibung eingeben';
$phprlang['raid_error_limits'] = 'Alle Raid-Begrenzungen müssen eingegeben werden und nummerisch sein';
$phprlang['raid_error_location'] = 'Du musst eine Raidinstanz eingeben';
$phprlang['view_error_signed_up'] = 'Du hast dich bereits mit diesem Charakter angemeldet';
$phprlang['view_error_role_undef'] = 'Bitte weise deinem Charakter im <a href="profile.php?mode=view">Profil</a> erst eine Rolle zu';
$phprlang['yes'] = 'Ja';

// Buttons
$phprlang['submit'] = 'Übernehmen';
$phprlang['reset'] = 'Zurücksetzen';
$phprlang['confirm'] = 'Confirm';
$phprlang['update'] = 'Update';
$phprlang['confirm_deletion'] = 'Löschen bestätigen';
$phprlang['filter'] = 'Filter';
$phprlang['addchar'] = 'Add Character';
$phprlang['updatechar'] = 'Update Character';
$phprlang['login'] = 'Anmelden';
$phprlang['logout'] = 'Abmelden';
$phprlang['signup'] = 'Anmelden';

// generic information
$phprlang['delete_msg'] = 'ACHTUNG: Die Löschung ist permanent und kann nicht rückgängig gemacht werden. <br>Klicke auf die Schaltfläche unten, um fortzufahren.';
$phprlang['disable_header'] = 'Wartungsarbeiten';
$phprlang['disable_message'] = 'phpRaid wird gerade Wartungsarbeiten unterzogen. Bitte versuche es später noch einmal.';
$phprlang['login_title'] = 'Login fehlgeschlagen';
$phprlang['login_msg'] = 'Du hast einen ungültigen Benutzernamen oder ein falsches Passwort eingegeben. Bitte versuche es noch einmal.';
$phprlang['userclass_msg'] = 'Dein e107-Benutzer hat nicht die Berechtigung, phpRaid zu benutzen. Bitte benachrichtige den System-Administrator.';
$phprlang['priv_title'] = 'Ungenügende Rechte';
$phprlang['priv_msg'] = 'Du hast nicht die Berechtigung, diese Seite aufzurufen. Wenn du glaubst, dass es sich dabei um einen Fehler handelt, benachrichtige bitte den Administrator.';
$phprlang['remember'] = 'Mich bei jedem Besuch von diesem Computer automatisch anmelden';
$phprlang['welcome'] = 'Willkommen ';

// Days of the Week
$phprlang['sunday'] = 'Sonntag';
$phprlang['monday'] = 'Montag';
$phprlang['tuesday'] = 'Dienstag';
$phprlang['wednesday'] = 'Mittwoch';
$phprlang['thursday'] = 'Donnerstag';
$phprlang['friday'] = 'Freitag';
$phprlang['saturday'] = 'Samstag';
									
// links
$phprlang['announcements_link'] = '&raquo; Ankündigungen';
$phprlang['configuration_link'] = '&raquo; Konfiguration';
$phprlang['guilds_link'] = '&raquo; Gilden';
$phprlang['home_link'] = '&raquo; Übersicht';
$phprlang['calendar_link'] = '&raquo; Kalender';
$phprlang['locations_link'] = '&raquo; Instanzen';
$phprlang['logs_link'] = '&raquo; Protokoll';
$phprlang['permissions_link'] = '&raquo; Berechtigungen';
$phprlang['profile_link'] = '&raquo; Profil';
$phprlang['raids_link'] = '&raquo; Raids';
$phprlang['register_link'] = '&raquo; Registrieren';
$phprlang['roster_link'] = '&raquo; Mitgliederliste';
$phprlang['users_link'] = '&raquo; Benutzer';
$phprlang['lua_output_link'] = '&raquo; LUA-Raidausgabe';
$phprlang['index_link'] = '&raquo; Gildenseite';
$phprlang['dkp_link'] = '&raquo; DKP';

// sorting information
$phprlang['sort_text'] = 'Sortieren nach ';

// tooltips
$phprlang['add'] = 'Hinzufügen';
$phprlang['announcements'] = 'Ankündigungen';
$phprlang['arcane'] = 'Arkan';
$phprlang['calendar'] = 'Kalender';
$phprlang['cancel'] = 'Anmeldung abbrechen';
$phprlang['cancel_msg'] = 'Du hast deine Anmeldung für diesen Raid abgebrochen';
$phprlang['comments'] = 'Kommentare';
$phprlang['configuration'] = 'Konfiguration';
$phprlang['delete'] = 'Löschen';
$phprlang['description'] = 'Beschreibung';
$phprlang['druid_icon'] = 'Klick, um Druiden zu sehen';
$phprlang['edit'] = 'Bearbeiten';
$phprlang['edit_comment'] = 'Kommentar bearbeiten';
$phprlang['fire'] = 'Feuer';
$phprlang['frost'] = 'Frost';
$phprlang['frozen_msg'] = 'Dieser Raid wurde eingefroren. Anmeldungen sind deaktiviert.';
$phprlang['group_name'] = 'Gruppenname';
$phprlang['group_description'] = 'Gruppenbeschreibung';
$phprlang['guilds'] = 'Gilden';
$phprlang['has_permission'] = 'Hat Berechtigung';
$phprlang['hunter_icon'] = 'Klick, um Jäger zu sehen';
$phprlang['in_queue'] = 'Benutzer in die Warteschlange setzen';
$phprlang['last_login_date'] = 'Letzter Login';
$phprlang['last_login_time'] = 'Uhrzeit';
$phprlang['locations'] = 'Instanzen';
$phprlang['logs'] = 'Protokoll';
$phprlang['lua'] = 'LUA- und Makroausgabe';
$phprlang['mage_icon'] = 'Klick, um Magier zu sehen';
$phprlang['mark'] = 'Raid als veraltet markieren';
$phprlang['nature'] = 'Natur';
$phprlang['new'] = 'Raid als aktuell markieren';
$phprlang['not_signed_up'] = 'Klicke hier, um dich für den Raid anzumelden';
$phprlang['out_queue'] = 'Benutzer in die Anmeldeliste setzen';
$phprlang['paladin_icon'] = 'Klick, um Paladine zu sehen';
$phprlang['permissions'] = 'Berechtigungen';
$phprlang['priest_icon'] = 'Klick, um Priester zu sehen';
$phprlang['priv'] = 'Berechtigungsgruppe';
$phprlang['profile'] = 'Profil';
$phprlang['raids'] = 'Raids';
// unused: $phprlang['remove_group'] = 'Remove group from set';
$phprlang['remove_user'] = 'Benutzer aus Berechtigungsgruppe entfernen';
$phprlang['rogue_icon'] = 'Klick, um Schurken zu sehen';
$phprlang['shadow'] = 'Schatten';
$phprlang['shaman_icon'] = 'Klick, um Schamanen zu sehen';
$phprlang['signed_up'] = 'Du bist für diesen Raid angemeldet';
$phprlang['signup_add'] = 'Benutzer der Anmeldung hinzufügen';
$phprlang['signup_delete'] = 'Benutzer von der Anmeldung entfernen (permanent)';
$phprlang['users'] = 'Benutzer';
$phprlang['warlock_icon'] = 'Klick, um Hexenmeister zu sehen';
$phprlang['warrior_icon'] = 'Klick, um Krieger zu sehen';

?>