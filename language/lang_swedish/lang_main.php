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
$phprlang['add_team']='Kryssa i för att lägga till i Lag';
$phprlang['add_team_dropdown_text']='Välj Lag att lägga till medlemmarna i';
$phprlang['team_global']='Markera gruppen tillgänglig för alla raids';
$phprlang['male'] = 'Man';
$phprlang['female'] = 'Kvinna';
$phprlang['class'] = 'Klass';
$phprlang['date'] = 'Datum';
$phprlang['description'] = 'Beskrivning';
$phprlang['email'] = 'E-post';
$phprlang['guild'] = 'Guild';
$phprlang['guild_name'] = 'Guild Namn';
$phprlang['guild_master'] = 'Guildmaster';
$phprlang['guild_tag'] = 'Guild märke';
$phprlang['id'] = 'ID';
$phprlang['invite_time'] = 'Inbjudnings Tid';
$phprlang['level'] = 'Level';
$phprlang['location'] = 'Instans';
$phprlang['max_lvl'] = 'Högsta Lvl';
$phprlang['max_raiders'] = 'Raid Max';
$phprlang['locked_header'] = 'Låst?';
$phprlang['message'] = 'Meddelande';
$phprlang['min_lvl'] = 'Lägsta Lvl';
$phprlang['name'] = 'Namn';
$phprlang['officer'] = 'Skapare';
$phprlang['no_data'] = 'Tom';
$phprlang['posted_by'] = 'Skapad av';
$phprlang['race'] = 'Ras';
$phprlang['start_time'] = 'Start Tid';
$phprlang['team_name'] = 'Lag Namne';
$phprlang['time'] = 'Tid';
$phprlang['title'] = 'Titel';
$phprlang['totals'] = 'Totala';
$phprlang['username'] = 'Användarnamn';
$phprlang['records'] = 'Registrering';
$phprlang['to'] = 'till';
$phprlang['of'] = 'av';
$phprlang['total'] = 'totalt';
$phprlang['section'] = 'Avdelning';
$phprlang['prev'] = 'Föregående';
$phprlang['next'] = 'Nästa';
$phprlang['earned'] = 'Intjänad';
$phprlang['spent'] = 'Spenderad';
$phprlang['adjustment'] = 'Justerad';
$phprlang['dkp'] = 'DKP';
$phprlang['buttons'] = 'Buttons';
$phprlang['add_to_team'] = 'Add To Team';
$phprlang['create_date'] = 'Create Date';
$phprlang['create_time'] = 'Create Time';
$phprlang['pri_spec'] = 'Pri Talent';
$phprlang['sec_spec'] = 'Sec Talent';

// roles
$phprlang['role'] = 'Roll';
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

$phprlang['max_tanks'] = 'Max Tanks';
$phprlang['max_heals'] = 'Max Healers';
$phprlang['max_melees'] = 'Max Melee';
$phprlang['max_ranged'] = 'Max Ranged';
$phprlang['max_tkmels'] = 'Max Tank/Melee';

// errors
$phprlang['connect_socked_error'] = 'Failed to connect to socket with error %s';
$phprlang['invalid_group_title'] = 'Group exists';
$phprlang['invalid_group_message'] = 'The group selected is already part of this set. Press your browsers BACK button to try again.';
$phprlang['invalid_option_title'] = 'Invalid input for page';
$phprlang['invalid_option_msg'] = 'You have tried to access this page using invalid input.';
$phprlang['no_user_msg'] = 'The user you are trying to view does not exist or has been deleted.';
$phprlang['no_user_title'] = 'User does not exist';
$phprlang['print_error_critical'] = 'a critical error!';
$phprlang['print_error_details'] = 'Details';
$phprlang['print_error_minor'] = 'a minor error!';
$phprlang['print_error_msg_begin'] = 'Sorry, phpRaid has encountered ';
$phprlang['print_error_msg_end'] = 'If this error persists, please make a post 
									with this message <br>on the <a href="http://www.wowraidmanager.net/">wowraidmanager.net Forums</a> and
									we will do our best to get it corrected. Thanks!';
$phprlang['print_error_page'] = 'Page';
$phprlang['print_error_query'] = 'Query';
$phprlang['print_error_title'] = 'Uh oh! You hit a boo boo';
$phprlang['socket_functions_disabled'] = 'Update checked failed to connect to server.';

// forms
$phprlang['asc'] = 'stigande';
$phprlang['auth_phpbb_no_groups'] = 'Inga grupper finna att lägga till';
$phprlang['desc'] = 'fallande';
$phprlang['form_error'] = 'Fel i formuläret';
$phprlang['form_select'] = 'Välj En';
$phprlang['no'] = 'Nej';
$phprlang['none'] = 'Ingen';
$phprlang['guild_name_missing'] = 'Komplett guild namn saknas.';
$phprlang['guild_tag_missing'] = 'Guild märke saknas.';
$phprlang['permissions_form_description'] = 'Du måste lägga till en beskrivning';
$phprlang['permissions_form_name'] = 'Du måste skriva in ett namn';
$phprlang['profile_error_arcane'] = 'Arcane måste vara en siffra';
$phprlang['profile_error_class'] = 'Du måste välja en klass';
$phprlang['profile_error_dupe'] = 'En karaktär med det namnet finns redan';
$phprlang['profile_error_fire'] = 'Fire måste vara en siffra';
$phprlang['profile_error_frost'] = 'Frost måste vara en siffra';
$phprlang['profile_error_guild'] = 'Du måste välja ett guild';
$phprlang['profile_error_level'] = 'Level måste vara ett tal mellan 1-80';
$phprlang['profile_error_name'] = 'Du måste skriva ett namn';
$phprlang['profile_error_nature'] = 'Nature måste vara en siffra';
$phprlang['profile_error_race'] = 'Du måste välja en ras';
$phprlang['profile_error_role'] = 'Du måste välja en roll';
$phprlang['profile_error_shadow'] = 'Shadow måste vara en siffra';
$phprlang['raid_error_date'] = 'Du måste skriva in en korrekt datum';
$phprlang['raid_error_description'] = 'Beskrivningen måste fyllas i';
$phprlang['raid_error_limits'] = 'Alla raidgränser måste fyllas i och vara siffror';
$phprlang['raid_error_location'] = 'Fyll i en raid instans';
$phprlang['view_error_signed_up'] = 'Du är redan bokad med denna karaktär';
$phprlang['view_error_role_undef'] = 'Se till att Karaktären har en Roll vald i <a href="profile.php?mode=view">Profilen</a>.';
$phprlang['yes'] = 'Ja';

// Buttons
$phprlang['submit'] = 'Skicka';
$phprlang['reset'] = 'Återställ';
$phprlang['confirm'] = 'Bekräfta';
$phprlang['update'] = 'Uppdatera';
$phprlang['confirm_deletion'] = 'Bekräfta Rardering';
$phprlang['filter'] = 'Filtrera';
$phprlang['addchar'] = 'Lägg till karaktär';
$phprlang['updatechar'] = 'Uppdatera karaktär';
$phprlang['login'] = 'Logga in';
$phprlang['logout'] = 'Logga ut';
$phprlang['signup'] = 'Boka';


// generic information
$phprlang['delete_msg'] = 'VARNING: Radering är permanent och kan inte ångras. <br>Klicka knappen nedan för att fortsätta.';
$phprlang['disable_header'] = 'Underhåll av sidan pågår';
$phprlang['disable_message'] = 'WoW Raid Manager undergår för närvarande underhåll. Vänligen försök igen senare.';
$phprlang['login_title'] = 'Inloggningen misslyckades';
$phprlang['login_msg'] = 'Du har angett fel användarnamn eller lösenord. Försök gärna igen.';
$phprlang['userclass_msg'] = 'Din e107 användare har inte rättighet till att använda WRM, vänligen kontakta administratören.';
$phprlang['priv_title'] = 'Otillräcklig behörighet';
$phprlang['priv_msg'] = 'Du saknar behörighet för att visa denna sida. Om du tror detta är ett fel, vänligen kontakta administratören';
$phprlang['remember'] = 'Kom ihåg mig från denna datorn';
$phprlang['welcome'] = 'Välkommen ';

// Login Information
$phprlang['login_fail_title'] = 'Login failed';
$phprlang['login_fail'] = 'You have specified an invalid username or password. Please try again.';
$phprlang['login_forgot_password'] = 'Forgot Your Password?';
$phprlang['login_pwdreset_fail_title'] = 'Failed to Send/Reset Password';
$phprlang['login_pwdreset_title'] = 'Reset Password';
$phprlang['login_password_reset_msg']= 'To Reset Your Password Please Enter the Following Information';
$phprlang['login_username_email_incorrect'] = 'The Entered Username and/or Email Address is Incorrect.<br><br>Please Click the Back Button and Try Again.';
$phprlang['login_password_sent'] = 'Your WRM password has been reset and the new password has been sent to:<br><br>';
$phprlang['login_password_sent2'] = '<br><br>Please check the E-Mail address listed above for a message from this system. ' .
									'If you do not see the message please check your spam folder and/or turn off ' .
									'your spam filter and use the "Forgot My Password" link again.';
$phprlang['login_password_email_msg'] = 'THIS MESSAGE IS NOT SPAM!<br><br>Someone (hopefully you) has clicked the ' .
										'"Forgot My Password" link on a WRM installation and entered an account with ' .
										'your e-mail address.  Your WRM Password has been reset by the WRM system.  The ' .
										'new password is:<br><br>';
$phprlang['login_password_email_msg2'] = '<br><br>Please login to the WRM system using the above supplied password and click the ' .
										 '"Click to Change Password" link under the Log Out button to reset your password ' .
										 'to something more memorable.<br><br>If you were NOT the one to click this link please ' .
										 'contact your WRM administrator to inform them that the reset link is being abused.<br><br>' .
										 'You will still need to use the new password supplied above to access your WRM account.';
$phprlang['login_password_email_sub'] = 'WRM Password Reset Notification'.										 
$phprlang['login_chpass_text'] = 'Change Password For User: ';
$phprlang['login_chpwd'] = 'Click to Change Password';
$phprlang['login_curr_password'] = 'Current Password';
$phprlang['login_password_conf'] = 'Confirm Password';
$phprlang['login_password_incorrect'] = 'Either the current password for the listed username is incorrect or the new password and ' .
										'confirm password do not match.<br><br>Please Click the Back Button and Try Again.';
$phprlang['login_password_new'] = 'New Password';
$phprlang['login_pwdreset_success'] = 'Your password HAS BEEN correctly reset.<br><br>You will need to use the new password the next time you login.';

// Days of the Week
$phprlang['sunday'] = 'Söndag';
$phprlang['monday'] = 'Måndag';
$phprlang['tuesday'] = 'Tisdag';
$phprlang['wednesday'] = 'Onsdag';
$phprlang['thursday'] = 'Torsdag';
$phprlang['friday'] = 'Fredag';
$phprlang['saturday'] = 'Lördag';
$phprlang['2ltrsunday'] = 'Sö';
$phprlang['2ltrmonday'] = 'Må';
$phprlang['2ltrtuesday'] = 'Ti';
$phprlang['2ltrwednesday'] = 'On';
$phprlang['2ltrthursday'] = 'To';
$phprlang['2ltrfriday'] = 'Fr';
$phprlang['2ltrsaturday'] = 'Lö';

// Months
$phprlang['month'] = 'Month';
$phprlang['year'] = 'Year';
$phprlang['month1'] = 'January';
$phprlang['month2'] = 'February';
$phprlang['month3'] = 'March';
$phprlang['month4'] = 'April';
$phprlang['month5'] = 'May';
$phprlang['month6'] = 'June';
$phprlang['month7'] = 'July';
$phprlang['month8'] = 'August';
$phprlang['month9'] = 'September';
$phprlang['month10'] = 'October';
$phprlang['month11'] = 'November';
$phprlang['month12'] = 'December';
							
// links
$phprlang['announcements_link'] = '&raquo; Nyheter';
$phprlang['configuration_link'] = '&raquo; Konfiguration';
$phprlang['guilds_link'] = '&raquo; Guilder';
$phprlang['home_link'] = '&raquo; Start Sida';
$phprlang['calendar_link'] = '&raquo; Kalender';
$phprlang['locations_link'] = '&raquo; Instanser';
$phprlang['logs_link'] = '&raquo; Loggar';
$phprlang['permissions_link'] = '&raquo; Rättigheter';
$phprlang['profile_link'] = '&raquo; Profil';
$phprlang['raids_link'] = '&raquo; Raider';
$phprlang['register_link'] = '&raquo; Registrera';
$phprlang['roster_link'] = '&raquo; Roster';
$phprlang['users_link'] = '&raquo; Medlemmar';
$phprlang['lua_output_link'] = '&raquo; Lua utmatning raid';
$phprlang['index_link'] = '&raquo; Hem';
$phprlang['dkp_link'] = '&raquo; DKP';

// sorting information
$phprlang['sort_text'] = 'Klicka här för att sortera efter ';
$phprlang['sort_desc']='Klicka här för att sortera (i fallande ordning) efter ';
$phprlang['sort_asc']='Klicka här för att sortera (i stigande ordning) efter '; 

// tooltips
$phprlang['add'] = 'Lägg till';
$phprlang['announcements'] = 'Nyheter';
$phprlang['arcane'] = 'Arcane';
$phprlang['calendar'] = 'Kalender';
$phprlang['cancel'] = 'Avboka';
$phprlang['cancel_msg'] = 'Du har nu tagit bort din bokning för detta raid';
$phprlang['comments'] = 'Kommentarer';
$phprlang['configuration'] = 'Konfiguration';
$phprlang['deathknight_icon'] = 'Klicka för att se Death Knights';
$phprlang['delete'] = 'Radera';
$phprlang['description'] = 'Beskrivning';
$phprlang['druid_icon'] = 'Klicka för att se Druider';
$phprlang['edit'] = 'Ändra';
$phprlang['edit_comment'] = 'Ändra kommentar';
$phprlang['fire'] = 'Fire';
$phprlang['frost'] = 'Frost';
$phprlang['frozen_msg'] = 'Detta raid är fryst. Det går inte att boka sig till det längre.';
$phprlang['group_name'] = 'Grupp Namn';
$phprlang['group_description'] = 'Grupp Beskrivning';
$phprlang['guilds'] = 'Guilder';
$phprlang['has_permission'] = 'Har Behörighet';
$phprlang['hunter_icon'] = 'Klicka för att se Hunters';
$phprlang['in_queue'] = 'Placera spelaren i kö';
$phprlang['last_login_date'] = 'Senaste inloggningsdatum';
$phprlang['last_login_time'] = 'SEnaste inloggningstid';
$phprlang['locations'] = 'Instancer';
$phprlang['logs'] = 'Loggar';
$phprlang['lua'] = 'LUA och macro utmatning';
$phprlang['mage_icon'] = 'Klicka för att se Mages';
$phprlang['mark'] = 'Markera raiden som Gammal';
$phprlang['nature'] = 'Nature';
$phprlang['new'] = 'Markera raiden som Ny';
$phprlang['not_signed_up'] = 'Klicka här för att boka dig till raiden';
$phprlang['out_queue'] = 'Placera spelaren som Klar';
$phprlang['paladin_icon'] = 'Klicka för att se Paladiner';
$phprlang['permissions'] = 'Rättigheter';
$phprlang['priest_icon'] = 'Klicka för att se Präster';
$phprlang['priv'] = 'Rättigheter';
$phprlang['profile'] = 'Profil';
$phprlang['raids'] = 'Raider';
$phprlang['remove_group'] = 'Ta bort gruppen från set';
$phprlang['remove_user'] = 'Ta bort användare från set';
$phprlang['rogue_icon'] = 'Klicka för att se Rogues';
$phprlang['shadow'] = 'Shadow';
$phprlang['shaman_icon'] = 'Klicka för att se Shamans';
$phprlang['signed_up'] = 'Du är Bokad på denna raiden';
$phprlang['signup_add'] = 'Lägg till spelare som Klar';
$phprlang['signup_delete'] = 'Ta bort spelare från raidet (permanent)';
$phprlang['users'] = 'Användare';
$phprlang['warlock_icon'] = 'Klicka för att se Warlocks';
$phprlang['warrior_icon'] = 'Klicka för att se Warriors';

?>