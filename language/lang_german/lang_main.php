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

// admin section language file
require_once('lang_admin.php');

if (empty($phprlang) || !is_array($phprlang))
	$phprlang = array();
	
$phprlang = array_merge($phprlang, array(


// data output headers (Reports.php)
'add_team' => 'Zum Team hinzufügen',
'add_team_dropdown_text' => 'Team, zu dem Mitglieder hinzugefügt werden sollen',
'team_global' => 'Team für alle Raids verfügbar machen',
'male' =>  'männlich',
'female' =>  'weiblich',
'class' =>  'Klasse',
'date' =>  'Datum',
'description' =>  'Beschreibung',
'email' =>  'E-Mail',
'guild' =>  'Gilde',
'guild_name' =>  'Gildenname',
'guild_master' =>  'Gildenmeister',
'guild_tag' =>  'Gildenkürzel',
'guild_description' =>  'Guild Description',
'guild_server' =>  'Guild Server',
'guild_faction' =>  'Guild Faction',
'guild_armory_link' =>  'Armory Link',
'guild_armory_code' =>  'Armory Code',
'guild_id' =>  'Guild ID',
'raid_force_id' =>  'Raid Force ID',
'raid_force_name' =>  'Raid Force',
'id' =>  'ID',
'invite_time' =>  'Einladung',
'level' =>  'Stufe',
'location' =>  'Instanz',
'max_lvl' =>  'Höchststufe',
'max_raiders' =>  'Raidmaximum',
'locked_header' =>  'Gesperrt?',
'message' =>  'Nachricht',
'min_lvl' =>  'Mindeststufe',
'name' =>  'Name',
'officer' =>  'Ersteller',
'no_data' =>  'Leer',
'posted_by' =>  'Geschrieben von',
'race' =>  'Rasse',
'start_time' =>  'Startzeit',
'team_name' =>  'Team-Name',
'time' =>  'Zeit',
'title' =>  'Titel',
'totals' =>  'Gesamt',
'username' =>  'Benutzername',
'records' =>  'Datensätze',
'to' =>  'bis',
'of' =>  'von',
'total' =>  'insgesamt',
'section' =>  'Abschnitt',
'prev' =>  'Zurück',
'next' =>  'Weiter',
'earned' =>  'Erhalten',
'spent' =>  'Ausgegeben',
'adjustment' =>  'Anpassung',
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

// Scheduler Texts
'scheduler_error_header' =>  'Scheduler Error',
'scheduler_unknown' =>  'The scheduler threw an Unknown error, please post the error message to WRM support.',

// roles
'role_none' =>  '-',
'role' =>  'Role', //New

// errors
'connect_socked_error' =>  'Fehler beim Aufbau der Socket-Verbindung:  %s',
// unused: 'invalid_group_title' =>  'Gruppe existiert',
// unused: 'invalid_group_message' =>  'Die ausgewählte Gruppe ist bereits ein Teil dieses Sets. Bitte benutze in deinem Browser die "Zurück"-Taste und versuche es erneut.',
'invalid_option_title' =>  'Ungültigte Eingabe für die Seite',
'invalid_option_msg' =>  'Du hast versucht, diese Seite mit ungültigen Eingaben aufzurufen.',
'no_user_msg' =>  'Der Benutzer, den du dir ansehen möchtest, existiert nicht oder wurde gelöscht.',
'no_user_title' =>  'Benutzer existiert nicht',
'print_error_critical' =>  'kritischen Fehler entdeckt!',
'print_error_details' =>  'Details',
'print_error_minor' =>  'kleinen Fehler entdeckt!',
'print_error_msg_begin' =>  'Entschuldigung, WRM hat einen ',
'print_error_msg_end' =>  'Wenn der Fehler weiter auftritt, erzeuge bitte ein Posting
									mit dieser Nachricht <br>in den <a href="http://www.wowraidmanager.net/">wowraidmanager.net-Forums</a> und
									wir werden unser Bestes geben, um ihn zu beheben. Danke!',
'print_error_page' =>  'Seite',
'print_error_query' =>  'Anfrage',
'print_error_title' =>  'Oh-oh! Da ist ein Fehler passiert',
'socket_functions_disabled' =>  'Die Versionsprüfung konnte den Server nicht erreichen.',

// forms
'asc' =>  'aufsteigender',
'auth_phpbb_no_groups' =>  'Keine Gruppen zum Hinzufügen verfügbar',
'desc' =>  'absteigender',
'form_error' =>  'Fehler beim Abschicken des Formulars',
'form_select' =>  'Bitte wählen',
'no' =>  'Nein',
'none' =>  'Keine',
'guild_name_missing' =>  'Der Gildenname fehlt.',
'guild_tag_missing' =>  'Das Gildenkürzel fehlt.',
'permissions_form_description' =>  'Du musst eine Beschreibung eingeben',
'permissions_form_name' =>  'Du musst einen Namen eingeben',
'profile_error_arcane' =>  'Arkanwiderstand muss nummerisch sein',
'profile_error_class' =>  'Du musst eine Klasse auswählen',
'profile_error_dupe' =>  'Ein Charakter mit diesem Namen existiert bereits',
'profile_error_fire' =>  'Feuerwiderstand muss nummerisch sein',
'profile_error_frost' =>  'Frostwiderstand muss nummerisch sein',
'profile_error_guild' =>  'Du musst eine Gilde auswählen',
'profile_error_level' =>  'Stufe muss nummerisch und zwischen 1 und 80 sein',
'profile_error_name' =>  'Du musst einen Namen eingeben',
'profile_error_nature' =>  'Naturwiderstand muss nummerisch sein',
'profile_error_race' =>  'Du musst eine Rasse auswählen',
'profile_error_role' =>  'Du musst eine Rolle auswählen',
'profile_error_shadow' =>  'Schattenwiderstand muss nummerisch sein',
'raid_error_date' =>  'Du musst ein gültiges Datum eingeben',
'raid_error_description' =>  'Du musst eine Beschreibung eingeben',
'raid_error_limits' =>  'Alle Raid-Begrenzungen müssen eingegeben werden und nummerisch sein',
'raid_error_location' =>  'Du musst eine Raidinstanz eingeben',
'view_error_signed_up' =>  'Du hast dich bereits mit diesem Charakter angemeldet',
'view_error_role_undef' =>  'Bitte weise deinem Charakter im <a href="profile.php?mode=view">Profil</a> erst eine Rolle zu',
'yes' =>  'Ja',
'teams_error_no_team' =>  'No team is selected to add users to.',

// Buttons
'submit' =>  'Übernehmen',
'reset' =>  'Zurücksetzen',
'confirm' =>  'Bestätigen',
'update' =>  'Aktualisieren',
'confirm_deletion' =>  'Löschen bestätigen',
'filter' =>  'Filter',
'addchar' =>  'Charakter hinzufügen',
'updatechar' =>  'Charakter aktualisieren',
'login' =>  'Anmelden',
'logout' =>  'Abmelden',
'signup' =>  'Anmelden',
'apply' =>  'Apply Options',

// generic information
'delete_msg' =>  'ACHTUNG: Die Löschung ist permanent und kann nicht rückgängig gemacht werden. <br>Klicke auf die Schaltfläche unten, um fortzufahren.',
'maintenance_header' =>  'Wartungsarbeiten',
'maintenance_message' =>  'WoW Raid Manager wird gerade Wartungsarbeiten unterzogen. Bitte versuche es später noch einmal.',
'disabled_header' =>  'Webseite deaktiviert!',
'disabled_message' =>  'Die Webseite ist deaktiviert. Besucher können das System im Moment nicht benutzen!<br>Gehe in die <u>Konfiguration</u> und entferne den Haken bei <u>WRM deaktivieren</u>',
'userclass_msg' =>  'Dein Benutzer hat nicht die Berechtigung, WoW Raid Manager zu benutzen. Bitte benachrichtige den System-Administrator.',
'priv_title' =>  'Ungenügende Rechte',
'priv_msg' =>  'Du hast nicht die Berechtigung, diese Seite aufzurufen. Wenn du glaubst, dass es sich dabei um einen Fehler handelt, benachrichtige bitte den Administrator.',
'remember' =>  'Mich bei jedem Besuch von diesem Computer automatisch anmelden',
'welcome' =>  'Willkommen ',

// Login Information
'login_fail_title' =>  'Anmeldung fehlgeschlagen',
'login_fail' =>  'Du hast einen ungültigen Benutzernamen oder ein falsches Passwort eingegeben. Bitte versuche es noch einmal.',
'login_forgot_password' =>  'Passwort vergessen?',
'login_pwdreset_fail_title' =>  'Das Passwort konnte nicht gesendet/zurückgesetzt werden',
'login_pwdreset_title' =>  'Passwort zurücksetzen',
'login_password_reset_msg' =>  'Um dein Passwort zurückzusetzen, gib die folgenden Informationen ein',
'login_username_email_incorrect' =>  'Der eingegebene Benutzername und/oder E-Mail-Adresse sind ungültig.<br><br>Bitte klicke auf die "Zurück"-Taste in deinem Browser und versuche es erneut.',
'login_password_sent' =>  'Dein WRM-Passwort wurde zurückgesetzt und das neue Passwort wurde gesendet an:<br><br>',
'login_password_sent2' =>  '<br><br>Bitte überprüfe die oben angegebene E-Mail-Adresse auf eine Nachricht vom System. ' .
									'Wenn du die Nachricht nicht findest, prüfe bitte den Spam-Ordner und/oder schalte den ' .
									'Spam-Filter ab und klicke erneut auf "Passwort vergessen".',
'login_password_email_msg' =>  'DIESE NACHRICHT IST KEIN SPAM!<br><br>Jemand (hoffentlich du) hat auf ' .
										'"Passwort vergessen" einer WRM-Installation geklickt und einen Account mit ' .
										'deiner E-Mail-Adresse angegeben. Dein WRM-Passwort wurde zurückgesetzt. Das ' .
										'neue Passwort lautet:<br><br>',
'login_password_email_msg2' =>  '<br><br>Bitte logge dich im WRM-System mit dem oben angegebenen Passwort ein und klicke auf ' .
										 '"Passwort ändern" unter dem Abmelden-Button, um dein Passwort auf ' .
										 'etwas zu ändern, das sich leichter merken lässt.<br><br>Wenn du NICHT der warst, der auf den Link geklickt hat, ' .
										 'kontaktiere bitte deinen WRM-Administrator, um ihn darüber zu informieren, dass der Zurücksetzen-Link missbraucht wurde.<br><br>' .
										 'Du wirst das oben angegebene, neue Passwort benötigen, um auf deinen WRM-Account zuzugreifen.',
'login_password_email_sub' =>  'WRM-Passwort zurückgesetzt',
'login_chpass_text' =>  'Passwort für Benutzer ändern: ',
'login_chpwd' =>  'Passwort ändern',
'login_curr_password' =>  'Aktuelles Passwort',
'login_password_conf' =>  'Passwort bestätigen',
'login_password_incorrect' =>  'Entweder ist das aktuelle Passwort für den angegebenen Benutzernamen falsch, oder das neue ' .
										'Passwort und das Bestätigungs-Passwort stimmen nicht überein.<br><br>Bitte klicke auf die "Zurück"-Taste in deinem Browser und versuche es noch mal.',
'login_password_new' =>  'Neues Passwort',
'login_pwdreset_success' =>  'Dein Passwort WURDE korrekt zurückgesetzt.<br><br>Du benötigst das neue Passwort, wenn du dich das nächste Mal anmeldest.',

// Days of the Week
'month' =>  'Monat',
'year' =>  'Jahr',
'sunday' =>  'Sonntag',
'monday' =>  'Montag',
'tuesday' =>  'Dienstag',
'wednesday' =>  'Mittwoch',
'thursday' =>  'Donnerstag',
'friday' =>  'Freitag',
'saturday' =>  'Samstag',
'2ltrsunday' =>  'So',
'2ltrmonday' =>  'Mo',
'2ltrtuesday' =>  'Di',
'2ltrwednesday' =>  'Mi',
'2ltrthursday' =>  'Do',
'2ltrfriday' =>  'Fr',
'2ltrsaturday' =>  'Sa',

// Months
'month1' =>  'Januar',
'month2' =>  'Februar',
'month3' =>  'März',
'month4' =>  'April',
'month5' =>  'Mai',
'month6' =>  'Juni',
'month7' =>  'Juli',
'month8' =>  'August',
'month9' =>  'September',
'month10' =>  'Oktober',
'month11' =>  'November',
'month12' =>  'Dezember',

// links
'announcements_link' =>  '&raquo; Ankündigungen',
'configuration_link' =>  '&raquo; Konfiguration',
'guilds_link' =>  '&raquo; Gilden',
'home_link' =>  '&raquo; Übersicht',
'calendar_link' =>  '&raquo; Kalender',
'locations_link' =>  '&raquo; Instanzen',
'permissions_link' =>  '&raquo; Berechtigungen',
'profile_link' =>  '&raquo; Profil',
'raids_link' =>  '&raquo; Raids',
'register_link' =>  '&raquo; Registrieren',
'roster_link' =>  '&raquo; Mitgliederliste',
'users_link' =>  '&raquo; Benutzer',
'lua_output_link' =>  '&raquo; LUA-Raidausgabe',
'index_link' =>  '&raquo; Gildenseite',
'dkp_link' =>  '&raquo; DKP',
'bosstrack_link' =>  '&raquo; Boss Kill Tracking',
'raidsarchive_link' =>  '&raquo; Raids Archiv',

// sorting information
'sort_text' =>  'Sortieren nach ',
'sort_desc' => 'Klicke hier, um die Reihenfolge absteigend zu sortieren nach: ',
'sort_asc' => 'Klicke hier, um die Reihenfolge aufsteigend zu sortieren nach: ',

// tooltips
'add' =>  'Hinzufügen',
'announcements' =>  'Ankündigungen',
'arcane' =>  'Arkan',
'calendar' =>  'Kalender',
'cancel' =>  'Anmeldung abbrechen',
'cancel_msg' =>  'Du hast deine Anmeldung für diesen Raid abgebrochen',
'comments' =>  'Kommentar',
'configuration' =>  'Konfiguration',
'deathknight_icon' =>  'Klicke, um Todesritter zu sehen',
'delete' =>  'Löschen',
'description' =>  'Beschreibung',
'druid_icon' =>  'Klicke, um Druiden zu sehen',
'edit' =>  'Bearbeiten',
'edit_comment' =>  'Kommentar bearbeiten',
'fire' =>  'Feuer',
'frost' =>  'Frost',
'frozen_msg' =>  'Dieser Raid wurde eingefroren. Anmeldungen sind deaktiviert.',
'group_name' =>  'Gruppenname',
'group_description' =>  'Gruppenbeschreibung',
'guilds' =>  'Gilden',
'has_permission' =>  'Hat Berechtigung',
'hunter_icon' =>  'Klicke, um Jäger zu sehen',
'in_queue' =>  'Benutzer in die Warteschlange setzen',
'last_login_date' =>  'Letzter Login',
'last_login_time' =>  'Uhrzeit',
'locations' =>  'Instanzen',
'logs' =>  'Protokoll',
'lua' =>  'LUA- und Makroausgabe',
'mage_icon' =>  'Klicke, um Magier zu sehen',
'mark' =>  'Raid als veraltet markieren',
'nature' =>  'Natur',
'new' =>  'Raid als aktuell markieren',
'not_signed_up' =>  'Klicke hier, um dich für den Raid anzumelden',
'out_queue' =>  'Benutzer in die Anmeldeliste setzen',
'paladin_icon' =>  'Klicke, um Paladine zu sehen',
'permissions' =>  'Berechtigungen',
'priest_icon' =>  'Klicke, um Priester zu sehen',
'priv' =>  'Berechtigungsgruppe',
'profile' =>  'Profil',
'raids' =>  'Raids',
// unused: 'remove_group' =>  'Entferne Gruppe aus dem Set',
'remove_user' =>  'Benutzer aus Berechtigungsgruppe entfernen',
'rogue_icon' =>  'Klicke, um Schurken zu sehen',
'shadow' =>  'Schatten',
'shaman_icon' =>  'Klicke, um Schamanen zu sehen',
'signed_up' =>  'Du bist für diesen Raid angemeldet',
'signup_add' =>  'Benutzer der Anmeldung hinzufügen', // wo wird das benutzt!?!?
'signup_delete' =>  'Benutzer von der Anmeldung entfernen (permanent)',
'users' =>  'Benutzer',
'warlock_icon' =>  'Klicke, um Hexenmeister zu sehen',
'warrior_icon' =>  'Klicke, um Krieger zu sehen',

));  ?>