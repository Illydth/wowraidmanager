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

// data output headers (Reports.php)
$phprlang['add_team']='Cochez pour ajouter à l\'équipe';
$phprlang['add_team_dropdown_text']='Sèlectionnez une équipe pour y ajouter des membres';
$phprlang['team_global']='Sélection des groupes disponibles pour tous les Raids';
$phprlang['male'] = 'Male';
$phprlang['female'] = 'Femelle';
$phprlang['class'] = 'Classe';
$phprlang['date'] = 'Date';
$phprlang['description'] = 'Description';
$phprlang['email'] = 'E-mail';
$phprlang['guild'] = 'Guilde';
$phprlang['guild_name'] = 'Nom de la Guilde';
$phprlang['guild_master'] = 'Maitre de Guilde';
$phprlang['guild_tag'] = 'Tag Guilde';
$phprlang['guild_description'] = 'Guild Description';
$phprlang['guild_server'] = 'Guild Server';
$phprlang['guild_faction'] = 'Guild Faction';
$phprlang['guild_armory_link'] = 'Armory Link';
$phprlang['guild_armory_code'] = 'Armory Code';
$phprlang['guild_id'] = 'Guild ID';
$phprlang['raid_force_id'] = 'Raid Force ID';
$phprlang['raid_force_name'] = 'Raid Force';
$phprlang['id'] = 'ID';
$phprlang['invite_time'] = 'Groupage';
$phprlang['level'] = 'Niveau';
$phprlang['location'] = 'Donjon';
$phprlang['max_lvl'] = 'Niv Max';
$phprlang['max_raiders'] = 'Limite de joueurs';
$phprlang['locked_header'] = 'Locked?';
$phprlang['message'] = 'Message';
$phprlang['min_lvl'] = 'Niv Min';
$phprlang['name'] = 'Nom';
$phprlang['officer'] = 'Créateur';
$phprlang['no_data'] = 'Vide';
$phprlang['posted_by'] = 'Posté par';
$phprlang['race'] = 'Race';
$phprlang['start_time'] = 'Heure de Début';
$phprlang['team_name'] = 'Nom de l\'équipe';
$phprlang['time'] = 'Heure';
$phprlang['title'] = 'Titre';
$phprlang['totals'] = 'Total';
$phprlang['username'] = 'Nom du Joueur';
$phprlang['records'] = 'Enregistrement(s)';
$phprlang['to'] = 'to';
$phprlang['of'] = 'of';
$phprlang['total'] = 'total';
$phprlang['section'] = 'Section';
$phprlang['prev'] = 'Préc';
$phprlang['next'] = 'Suiv';
$phprlang['earned'] = 'Gagné';
$phprlang['spent'] = 'Passé';
$phprlang['adjustment'] = 'Ajustement';
$phprlang['dkp'] = 'DKP';
$phprlang['buttons'] = 'Buttons';
$phprlang['add_to_team'] = 'Add To Team';
$phprlang['create_date'] = 'Create Date';
$phprlang['create_time'] = 'Create Time';
$phprlang['pri_spec'] = 'Pri Talent';
$phprlang['sec_spec'] = 'Sec Talent';
$phprlang['signup_spec'] = 'Draft As';
$phprlang['role_id'] = 'Role ID';
$phprlang['role_name'] = 'Role Name';
$phprlang['role_config'] = 'Role Config Text';
$phprlang['role_image'] = 'Role Image';
$phprlang['talent_tree'] = 'Talent Tree';
$phprlang['display_text'] = 'Display Text';
$phprlang['perm_mod'] = 'Update Permissions';
$phprlang['all'] = 'All';
$phprlang['resistance'] = "Resistance";

// Recurrance Text Items
$phprlang['recur_header'] = 'Raid Recurrance Settings';
$phprlang['raids_recur'] = 'Recurring Raids';
$phprlang['daily'] = 'Daily (Every Day At This Time)';
$phprlang['weekly'] = 'Weekly (On This Day of the Week)';
$phprlang['monthly'] = 'Monthly (On This Day of the Month)';
$phprlang['recurrance'] = 'Recurring Raid?<br><a href="../docs/recurring_raids.html" target="_blank">help?</a>';
$phprlang['recur_interval'] = 'Recurrance Interval';
$phprlang['recur_length'] = 'Number of Intervals to Show';

// Scheduler Texts
$phprlang['scheduler_error_header'] = 'Scheduler Error';
$phprlang['scheduler_unknown'] = 'The scheduler threw an Unknown error, please post the error message to WRM support.';
$phprlang['scheduler_error_no_raid_found'] = 'No raid found when attempting to select the current recurring raid from the raids table.
												Recurring Raid was likely deleted, please reload the page.';
$phprlang['scheduler_error_schedule_raid'] = 'Error Scheduling New Raids from Recurring Raids.';
$phprlang['scheduler_error_sql_error'] = 'Generic SQL Error Occured, See Above Printed Information.';
$phprlang['scheduler_error_update_recurring'] = 'Failed to Update Timestamp on Recurring Raid.';
$phprlang['scheduler_error_class_limits_missing'] = 'Class Limits could not be retrieved for Recurring Raid.  
													Delete Recurring Raid and Try again.';
$phprlang['scheduler_error_role_limits_missing'] = 'Role Limits could not be retrieved for Recurring Raid.  
													Delete Recurring Raid and Try again.';

// roles
$phprlang['role_none'] = '-';
$phprlang['role'] = 'Role'; //New

// errors
$phprlang['connect_socked_error'] = 'Erreur de connection au socket, erreur : %s';
$phprlang['invalid_group_title'] = 'Le groupe existe déja';
$phprlang['invalid_group_message'] = 'The group selected is already part of this set. Press your browsers BACK button to try again.';
$phprlang['invalid_option_title'] = 'Entrée invalide pour cette page';
$phprlang['invalid_option_msg'] = 'Vous avez essayé d\'entrer dans cette page avec une entrée invalide.';
$phprlang['no_user_msg'] = 'Cet utilisateur n\'existe pas ou a été éffacé.';
$phprlang['no_user_title'] = 'Utilisateur non existant';
$phprlang['print_error_critical'] = 'erreur critique!';
$phprlang['print_error_details'] = 'Détails';
$phprlang['print_error_minor'] = 'erreur mineure!';
$phprlang['print_error_msg_begin'] = 'Sorry, WRM has encountered ';
$phprlang['print_error_msg_end'] = 'If this error persists, please make a post 
									with this message <br>on the <a href="http://www.wowraidmanager.net/">wowraidmanager.net Forums</a> and
									we will do our best to get it corrected. Thanks!';
$phprlang['print_error_page'] = 'Page';
$phprlang['print_error_query'] = 'Requète';
$phprlang['print_error_title'] = 'Uh oh! You hit a boo boo';
$phprlang['socket_functions_disabled'] = 'Update checked failed to connect to server.';

// forms
$phprlang['asc'] = 'ascendant';
$phprlang['auth_phpbb_no_groups'] = 'Auncun groupe disponible';
$phprlang['desc'] = 'descendant';
$phprlang['form_error'] = 'Error with your form submission';
$phprlang['form_select'] = 'Sèlectionnez';
$phprlang['no'] = 'Non';
$phprlang['none'] = 'Aucun';
$phprlang['guild_name_missing'] = 'The Full Guild Name is missing.';
$phprlang['guild_tag_missing'] = 'The Guild Tag is missing.';
$phprlang['permissions_form_description'] = 'Vous devez ajouter une description';
$phprlang['permissions_form_name'] = 'Vous devez renseigner un nom';
$phprlang['profile_error_class'] = 'Vous devez sèlectionner une classe';
$phprlang['profile_error_dupe'] = 'Un personnage porte déja ce nom';
$phprlang['profile_error_guild'] = 'Vous devez sèlectionner une guilde';
$phprlang['profile_error_level'] = 'Level must be numeric';
$phprlang['profile_error_name'] = 'Vous devez renseigner un nom';
$phprlang['profile_error_race'] = 'Vous devez sèlectionner une race';
$phprlang['profile_error_role'] = 'Vous devez renseigner un role';
$phprlang['raid_error_date'] = 'Vous devez entrer une date au format valide';
$phprlang['raid_error_description'] = 'La description doit etre écrite';
$phprlang['raid_error_limits'] = 'Toutes les limites de raid doivent etre numèriques';
$phprlang['raid_error_location'] = 'Ajouter un lieu de raid';
$phprlang['view_error_signed_up'] = 'Vous etes dèja inscrit avec ce personnage';
$phprlang['view_error_role_undef'] = 'Make sure that the Character in <a href="profile_char.php?mode=view">Profile</a> has a defined Role.';
$phprlang['yes'] = 'Oui';
$phprlang['teams_error_no_team'] = 'No team is selected to add users to.';

// Buttons
$phprlang['submit'] = 'Valider';
$phprlang['reset'] = 'Réinitialiser';
$phprlang['confirm'] = 'Confirmer';
$phprlang['update'] = 'Modifier';
$phprlang['confirm_deletion'] = 'Confirmer Suppression';
$phprlang['filter'] = 'Filtrer';
$phprlang['addchar'] = 'Ajouter un Personnage';
$phprlang['updatechar'] = 'Modifier un Personnage';
$phprlang['login'] = 'S\'identifier';
$phprlang['logout'] = 'Déconnexion';
$phprlang['signup'] = 'S\'inscrire';
$phprlang['apply'] = 'Apply Options';

// generic information
$phprlang['delete_msg'] = 'NOTICE: La suppression est IRREVERSIBLE. <br>Cliquez sur le bouton pour confirmer.';
$phprlang['maintenance_header'] = 'Site en maintenance, contactez l\'administrateur si besoin.';
$phprlang['maintenance_message'] = 'WoW Raid Manager est actuellement en maintenance. Réessayez plus tard.';
$phprlang['disabled_header'] = 'Site Disabled Notice!';
$phprlang['disabled_message'] = 'Please note, your site is disabled. Visitors can\'t use the system right now!<br>Go to <u>Configuration</u> and then uncheck <u>Disable WRM</u>';
$phprlang['userclass_msg'] = 'Your user is not authorized to use WoW Raid Manager, please contact the system administrator.';
$phprlang['priv_title'] = 'Privilèges insuffisants';
$phprlang['priv_msg'] = 'Vosu n\'avez pas les privilèges pour accèder a cette page. Contactez l\'administrateur si vous pensez que c une erreur';
$phprlang['remember'] = 'Garder mon identifiant en mémoire';
$phprlang['welcome'] = 'Bienvenue ';

// Login Information
$phprlang['login_fail_title'] = 'Erreur d\'identification';
$phprlang['login_fail'] = 'Mauvais mot de passe ou mauvais Identifiant. Veuillez réessayer.';
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
$phprlang['month'] = 'Month';
$phprlang['year'] = 'Year';
$phprlang['sunday'] = 'Dimanche';
$phprlang['monday'] = 'Lundi';
$phprlang['tuesday'] = 'Mardi';
$phprlang['wednesday'] = 'Mercredi';
$phprlang['thursday'] = 'Jeudi';
$phprlang['friday'] = 'Vendredi';
$phprlang['saturday'] = 'Samedi';
$phprlang['2ltrsunday'] = 'Dim';
$phprlang['2ltrmonday'] = 'Lun';
$phprlang['2ltrtuesday'] = 'Mar';
$phprlang['2ltrwednesday'] = 'Mer';
$phprlang['2ltrthursday'] = 'Jeu';
$phprlang['2ltrfriday'] = 'Ven';
$phprlang['2ltrsaturday'] = 'Sam';

// Months
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
$phprlang['announcements_link'] = '&raquo; Messages D\'Accueil';
$phprlang['configuration_link'] = '&raquo; Configuration';
$phprlang['guilds_link'] = '&raquo; Guildes';
$phprlang['home_link'] = '&raquo; Page D\'Accueil';
$phprlang['calendar_link'] = '&raquo; Calendrier Graphique';
$phprlang['locations_link'] = '&raquo; Lieux De Raid';
$phprlang['permissions_link'] = '&raquo; Droits';
$phprlang['profile_link'] = '&raquo; Mes Persos';
$phprlang['raids_link'] = '&raquo; Raids';
$phprlang['register_link'] = '&raquo; Enregistrement';
$phprlang['roster_link'] = '&raquo; Roster';
$phprlang['users_link'] = '&raquo; Utilisateurs';
$phprlang['lua_output_link'] = '&raquo; Lua output raids';
$phprlang['index_link'] = '&raquo; Forum AC';
$phprlang['eqdkp_link'] = '&raquo; EQ-DKP';
$phprlang['bosstrack_link'] = '&raquo; Boss Kill Tracking';
$phprlang['raidsarchive_link'] = '&raquo; Raids Archive';
$phprlang['profile_char_link'] = '&raquo; My Characters';

// sorting information
$phprlang['sort_text'] = 'Cliquer ici pour trier par ';
$phprlang['sort_desc']='Click here to sort (in descending order) by ';
$phprlang['sort_asc']='Click here to sort (in ascending order) by '; 

// tooltips
// more tooltips for race and resist in  lang_wow.php
$phprlang['add'] = 'Ajouter';
$phprlang['announcements'] = 'Messages D\'accueil';
$phprlang['calendar'] = 'Calendrier';
$phprlang['cancel'] = 'Annuler inscription';
$phprlang['cancel_msg'] = 'Vouz avez annulé votre inscription pour ce raid';
$phprlang['comments'] = 'Commentaires';
$phprlang['configuration'] = 'Configuration';
$phprlang['delete'] = 'Supprimer';
$phprlang['description'] = 'Description';
$phprlang['edit'] = 'Editer';
$phprlang['edit_comment'] = 'Editer Commentaire';
$phprlang['frozen_msg'] = 'Les inscriptions pour ce raid sont fermées.';
$phprlang['group_name'] = 'Nom du groupe';
$phprlang['group_description'] = 'Description du Groupe';
$phprlang['guilds'] = 'Guildes';
$phprlang['has_permission'] = 'Has Permission';
$phprlang['in_queue'] = 'Placer le personnage en file d\'attente';
$phprlang['last_login_date'] = 'Dernière connexion';
$phprlang['last_login_time'] = 'Heure de la dernière connexion';
$phprlang['locations'] = 'Lieux';
$phprlang['logs'] = 'Journaux';
$phprlang['lua'] = 'LUA and macro output';
$phprlang['mark'] = 'Marquer en ancien raid';
$phprlang['new'] = 'Marquer en nouveau raid';
$phprlang['not_signed_up'] = 'Cliquez ici pour vous inscrire au Raid';
$phprlang['out_queue'] = 'Placer le joueur dans le raid';
$phprlang['permissions'] = 'Droits';
$phprlang['priv'] = 'Privilèges';
$phprlang['profile'] = 'Personnages';
$phprlang['raids'] = 'Raids';
$phprlang['remove_group'] = 'Remove group from set';
$phprlang['remove_user'] = 'Remove user from set';
$phprlang['signed_up'] = 'You are signed up for this raid';
$phprlang['signup_add'] = 'Add user to signups';
$phprlang['signup_delete'] = 'Supprimer le joueur du raid (permanant)';
$phprlang['users'] = 'Utilisateurs';

?>