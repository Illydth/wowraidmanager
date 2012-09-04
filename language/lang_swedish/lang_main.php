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

// admin section language file
require_once('lang_admin.php');

if (empty($phprlang) || !is_array($phprlang))
	$phprlang = array();
	
$phprlang = array_merge($phprlang, array(

// data output headers (Reports.php)
'add_team' => 'Kryssa i för att lägga till i Lag',
'add_team_dropdown_text' => 'Välj Lag att lägga till medlemmarna i',
'team_global' => 'Markera gruppen tillgänglig för alla raids',
'male' =>  'Man',
'female' =>  'Kvinna',
'class' =>  'Klass',
'date' =>  'Datum',
'description' =>  'Beskrivning',
'email' =>  'E-post',
'guild' =>  'Guild',
'guild_name' =>  'Guild Namn',
'guild_master' =>  'Guildmaster',
'guild_tag' =>  'Guild märke',
'guild_description' =>  'Guild Beskrivning',
'guild_server' =>  'Guild Server',
'guild_faction' =>  'Guild Faction',
'guild_armory_link' =>  'Armory Länk',
'guild_armory_code' =>  'Armory Kod',
'guild_id' =>  'Guild ID',
'raid_force_id' =>  'Raidgrupp ID',
'raid_force_name' =>  'Raidgrupp',
'id' =>  'ID',
'invite_time' =>  'Inbjudningstid',
'level' =>  'Level',
'location' =>  'Instans',
'max_lvl' =>  'Högsta Lvl',
'max_raiders' =>  'Raid Max',
'locked_header' =>  'Låst?',
'message' =>  'Meddelande',
'min_lvl' =>  'Lägsta Lvl',
'name' =>  'Namn',
'officer' =>  'Skapare',
'no_data' =>  'Tom',
'posted_by' =>  'Skapad av',
'race' =>  'Ras',
'start_time' =>  'Starttid',
'team_name' =>  'Lagnamn',
'time' =>  'Tid',
'title' =>  'Titel',
'totals' =>  'Totala',
'username' =>  'Användarnamn',
'records' =>  'Visar',
'to' =>  'till',
'of' =>  'av',
'total' =>  'totalt',
'section' =>  'Avdelning',
'prev' =>  'Föregående',
'next' =>  'Nästa',
'earned' =>  'Intjänad',
'spent' =>  'Spenderad',
'adjustment' =>  'Justerad',
'dkp' =>  'DKP',
'buttons' =>  'Knappar',
'add_to_team' =>  'Lägg till Laget',
'create_date' =>  'Skapad Datum',
'create_time' =>  'Skapad Tid',
'pri_spec' =>  'Primär Talent',
'sec_spec' =>  'Sekundär Talent',
'signup_spec' =>  'Tag ut som',
'talent_tree' =>  'Talangträd',
'display_text' =>  'Visningsext',
'perm_mod' =>  'Updatera Rättigheter',
'all' =>  'Alla',

// Recurrance Text Items
'recur_header' =>  'Återkommande Raid Inställningar',
'raids_recur' =>  'Återkommande Raids',
'daily' =>  'Dagligen (Varje dag vid denna tid)',
'weekly' =>  'Veckovis (Varje vecka på denna dag/tid)',
'monthly' =>  'Månadsvis (På denna dag varje månad)',
'recurrance' =>  'Återkommande Raid?<br><a href="../docs/recurring_raids.html" target="_blank">help?</a>',
'recur_interval' =>  'Återkommande Intervall',
'recur_length' =>  'Antal Intervaller att visa',

// Scheduler Texts
'scheduler_error_header' =>  'Scheduler Error',
'scheduler_unknown' =>  'The scheduler threw an Unknown error, please post the error message to WRM support.',
'scheduler_error_no_raid_found' =>  'Ingen raid hittades vid försök att välja nuvarande återkommande raid från tabellen.
												Återkommande raid var troligtvis raderad, vänligen ladda om webbsidan.',
'scheduler_error_schedule_raid' =>  'Error Scheduling New Raids from Recurring Raids.',
'scheduler_error_sql_error' =>  'Generic SQL Error Occured, See Above Printed Information.',
'scheduler_error_update_recurring' =>  'Failed to Update Timestamp on Recurring Raid.',
'scheduler_error_class_limits_missing' =>  'Class Limits could not be retrieved for Recurring Raid.  
													Delete Recurring Raid and Try again.',
'scheduler_error_role_limits_missing' =>  'Role Limits could not be retrieved for Recurring Raid.  
													Delete Recurring Raid and Try again.',

// roles
'role_none' =>  '-',
'role' =>  'Roll', //New

// errors
'connect_socked_error' =>  'Kunde inte ansluta till socket med error %s',
'invalid_group_title' =>  'Grupp existerar',
'invalid_group_message' =>  'Den utvalda gruppen ingår redan i denna uppsättning. Tryck på din webbläsares knappen tillbaka för att försöka igen.',
'invalid_option_title' =>  'Ogiltig indata för sida',
'invalid_option_msg' =>  'Du har försökt komma åt den här sidan med ogiltig indata.',
'no_user_msg' =>  'Användaren du försöker se finns inte eller har tagits bort.',
'no_user_title' =>  'Användare existerar inte',
'print_error_critical' =>  'ett kritiskt fel!',
'print_error_details' =>  'Detaljer',
'print_error_minor' =>  'ett mindre fel!',
'print_error_msg_begin' =>  'Tyvärr har WRM stött på ',
'print_error_msg_end' =>  'Om felet kvarstår, var god gör ett inlägg
                                                                    med detta meddelande <br> på <a href="http://www.wowraidmanager.net/"> wowraidmanager.net Forum </ a> och
                                                                    vi gör vårt bästa för att få dem rättade. Tack',
'print_error_page' =>  'Sida',
'print_error_query' =>  'Fråga',
'print_error_title' =>  'Uh oh! You hit a boo boo',
'socket_functions_disabled' =>  'Uppdaterings förfrågan misslyckades, kunde inte ansluta till servern.',

// forms
'asc' =>  'stigande',
'auth_phpbb_no_groups' =>  'Inga grupper finna att lägga till',
'desc' =>  'fallande',
'form_error' =>  'Fel i formuläret',
'form_select' =>  'Välj En',
'no' =>  'Nej',
'none' =>  'Ingen',
'guild_name_missing' =>  'Komplett guild namn saknas.',
'guild_tag_missing' =>  'Guild märke saknas.',
'permissions_form_description' =>  'Du måste lägga till en beskrivning',
'permissions_form_name' =>  'Du måste skriva in ett namn',
'profile_error_arcane' =>  'Arcane måste vara en siffra',
'profile_error_class' =>  'Du måste välja en klass',
'profile_error_dupe' =>  'En karaktär med det namnet finns redan',
'profile_error_fire' =>  'Fire måste vara en siffra',
'profile_error_frost' =>  'Frost måste vara en siffra',
'profile_error_guild' =>  'Du måste välja ett guild',
'profile_error_level' =>  'Level måste vara ett tal mellan 1-80',
'profile_error_name' =>  'Du måste skriva ett namn',
'profile_error_nature' =>  'Nature måste vara en siffra',
'profile_error_race' =>  'Du måste välja en ras',
'profile_error_role' =>  'Du måste välja en roll',
'profile_error_shadow' =>  'Shadow måste vara en siffra',
'raid_error_date' =>  'Du måste skriva in en korrekt datum',
'raid_error_description' =>  'Beskrivningen måste fyllas i',
'raid_error_limits' =>  'Alla raidgränser måste fyllas i och vara siffror',
'raid_error_location' =>  'Fyll i en raid instans',
'view_error_signed_up' =>  'Du är redan uppskriven med denna karaktär',
'view_error_role_undef' =>  'Se till att Karaktären har en Roll vald i <a href="profile.php?mode=view">Profilen</a>.',
'yes' =>  'Ja',
'teams_error_no_team' =>  'Inget lag har valts att lägga till användare till.',

// Buttons
'submit' =>  'Skicka',
'reset' =>  'Återställ',
'confirm' =>  'Bekräfta',
'update' =>  'Uppdatera',
'confirm_deletion' =>  'Bekräfta Rardering',
'filter' =>  'Filtrera',
'addchar' =>  'Lägg till karaktär',
'updatechar' =>  'Uppdatera karaktär',
'login' =>  'Logga in',
'logout' =>  'Logga ut',
'signup' =>  'Skriv upp',
'apply' =>  'Ansöknings Inställningar',

// generic information
'delete_msg' =>  'VARNING: Radering är permanent och kan inte ångras. <br>Klicka knappen nedan för att fortsätta.',
'disable_header' =>  'Underhåll av sidan pågår',
'disable_message' =>  'WoW Raid Manager undergår för närvarande underhåll. Vänligen försök igen senare.',
'login_title' =>  'Inloggningen misslyckades',
'login_msg' =>  'Du har angett fel användarnamn eller lösenord. Försök gärna igen.',
'userclass_msg' =>  'Din användare har inte rättighet till att använda WRM, vänligen kontakta administratören.',
'priv_title' =>  'Otillräcklig behörighet',
'priv_msg' =>  'Du saknar behörighet för att visa denna sida. Om du tror detta är ett fel, vänligen kontakta administratören',
'remember' =>  'Kom ihåg mig från denna datorn',
'welcome' =>  'Välkommen ',

// Login Information
'login_fail_title' =>  'Inloggning Misslyckades',
'login_fail' =>  'Du har angett ett ogiltig användarnamn eller lösenord. Var god försök igen.',
'login_forgot_password' =>  'Har du glömt ditt lösenord?',
'login_pwdreset_fail_title' =>  'Misslyckades med att skicka / Återställ lösenord',
'login_pwdreset_title' =>  'Återställ Lösenord',
'login_password_reset_msg' =>  'För att återställa ditt lösenord Fyll i följande information',
'login_username_email_incorrect' =>  'Det inmatade användarnamnet och / eller e-postadressen är felaktig.<br><br>Klicka på knappen Bakåt och försök igen.',
'login_password_sent' =>  'Ditt WRM lösenord har återställts och det nya lösenord har skickats till:<br><br>',
'login_password_sent2' =>  '<br><br>Kontrollera e-post adressen som anges ovan för ett meddelande från detta system. ' .
									'Om du inte ser meddelandet vänligen kontrollera din skräppostmapp och / eller stänga ' .
									'av ditt spamfilter och använda "Glömt mitt lösenord"-länken igen.',
'login_password_email_msg' =>  'Detta meddelande är inte skräppost!<br><br>Någon (förhoppningsvis du) har klickat på ' .
										'"Jag har glömt mitt lösenord" på en WRM installation och trädde ett konto med ' .
										'din e-postadress. Ditt WRM lösenord har återställts av WRM systemet. Ditt ' .
										'nya lösenord är:<br><br>',
'login_password_email_msg2' =>  '<br><br>Vänligen logga in till WRM Systemet med ovannämnda medföljande lösenord och klicka på ' .
										 '"Klicka för att ändra lösenord" länken under knappen Logga ut för att återställa ditt lösenord ' .
										 'till något mer minnesvärd. <br><br> Om det INTE var du som klicka på denna länk vänligen ' .
										 'kontakta WRM administratören för att informera dem om att återställa länken missbrukas.<br><br>' .
										 'Du kommer fortfarande att behöva använda det nya lösenordet levereras ovan för att komma åt ditt WRM konto.',
'login_password_email_sub' =>  'WRM Återställning av lösenord Meddelande',									 
'login_chpass_text' =>  'Ändra lösenord för användare: ',
'login_chpwd' =>  'Klicka för att ändra lösenord',
'login_curr_password' =>  'Nuvarande lösenord',
'login_password_conf' =>  'Bekräfta lösenord',
'login_password_incorrect' =>  'Antingen är det nuvarande lösenordet för det angivna användarnamn felaktig eller så stämmer det nya lösenordet och ' .
										'bekräftelse lösenordet inte.<br><br>Klicka på knappen Bakåt och försök igen.',
'login_password_new' =>  'Nytt Lösenord',
'login_pwdreset_success' =>  'Ditt lösenord har korrekt blivit ändrat <br><br> Du måste använda det nya lösenordet nästa gång du loggar in.',

// Days of the Week
'sunday' =>  'Söndag',
'monday' =>  'Måndag',
'tuesday' =>  'Tisdag',
'wednesday' =>  'Onsdag',
'thursday' =>  'Torsdag',
'friday' =>  'Fredag',
'saturday' =>  'Lördag',
'2ltrsunday' =>  'Sö',
'2ltrmonday' =>  'Må',
'2ltrtuesday' =>  'Ti',
'2ltrwednesday' =>  'On',
'2ltrthursday' =>  'To',
'2ltrfriday' =>  'Fr',
'2ltrsaturday' =>  'Lö',

// Months
'month' =>  'Månad',
'year' =>  'År',
'month1' =>  'januari',
'month2' =>  'februari',
'month3' =>  'mars',
'month4' =>  'april',
'month5' =>  'maj',
'month6' =>  'juni',
'month7' =>  'juli',
'month8' =>  'augusti',
'month9' =>  'september',
'month10' =>  'oktober',
'month11' =>  'november',
'month12' =>  'december',
							
// links
'announcements_link' =>  '&raquo; Nyheter',
'configuration_link' =>  '&raquo; Konfiguration',
'guilds_link' =>  '&raquo; Guilder',
'home_link' =>  '&raquo; Startsida',
'calendar_link' =>  '&raquo; Kalender',
'locations_link' =>  '&raquo; Instanser',
'permissions_link' =>  '&raquo; Rättigheter',
'profile_link' =>  '&raquo; Profil',
'raids_link' =>  '&raquo; Raider',
'register_link' =>  '&raquo; Registrera',
'roster_link' =>  '&raquo; Roster',
'users_link' =>  '&raquo; Medlemmar',
'lua_output_link' =>  '&raquo; Lua raidutmatning',
'index_link' =>  '&raquo; Hem',
'dkp_link' =>  '&raquo; DKP',
'bosstrack_link' =>  '&raquo; Boss Kill Spårning',
'raidsarchive_link' =>  '&raquo; Raid Arkiv',

// sorting information
'sort_text' =>  'Klicka här för att sortera efter ',
'sort_desc' => 'Klicka här för att sortera (i fallande ordning) efter ',
'sort_asc' => 'Klicka här för att sortera (i stigande ordning) efter ', 

// tooltips
'add' =>  'Lägg till',
'announcements' =>  'Nyheter',
'calendar' =>  'Kalender',
'cancel' =>  'Placera som Ej Tillgänglig',
'cancel_msg' =>  'Du är Ej Tillgänglig för denna raid.',
'comments' =>  'Kommentarer',
'configuration' =>  'Konfiguration',
'delete' =>  'Radera',
'description' =>  'Beskrivning',
'edit' =>  'Ändra',
'edit_comment' =>  'Ändra kommentar',
'frozen_msg' =>  'Denna raid är fryst. Det går därför inte att skriva upp sig till den längre.',
'group_name' =>  'Gruppnamn',
'group_description' =>  'Gruppbeskrivning',
'guilds' =>  'Guilder',
'has_permission' =>  'Har Behörighet',
'in_queue' =>  'Placera som Tillgänglig',
'last_login_date' =>  'Inloggad senast',
'last_login_time' =>  'Klockan',
'locations' =>  'Instanser',
'logs' =>  'Loggar',
'lua' =>  'LUA och macro utmatning',
'mark' =>  'Markera raiden som Gammal',
'new' =>  'Markera raiden som Ny',
'not_signed_up' =>  'Klicka här för att skriva upp dig till raiden',
'out_queue' =>  'Placera som Uttagen',
'permissions' =>  'Rättigheter',
'priv' =>  'Rättigheter',
'profile' =>  'Profil',
'raids' =>  'Raider',
'remove_group' =>  'Ta bort gruppen från sett',
'remove_user' =>  'Ta bort användare från sett',
'signed_up' =>  'Du är uppskriven till denna raid',
'signup_add' =>  'Lägg till spelare som Klar',
'signup_delete' =>  'Ta bort spelare från raiden (permanent)',
'users' =>  'Användare',

));
?>