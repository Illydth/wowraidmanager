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

// � = �   � = � 

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
'add_team' => 'Cochez pour ajouter à l\'équipe',
'add_team_dropdown_text' => 'Sèlectionnez une équipe pour y ajouter des membres',
'team_global' => 'Sélection des groupes disponibles pour tous les Raids',
'male' =>  'Male',
'female' =>  'Femelle',
'class' =>  'Classe',
'date' =>  'Date',
'description' =>  'Description',
'email' =>  'E-mail',
'guild' =>  'Guilde',
'guild_name' =>  'Nom de la Guilde',
'guild_master' =>  'Maitre de Guilde',
'guild_tag' =>  'Tag',
'guild_description' =>  'Description',
'guild_server' =>  'Serveur',
'guild_faction' =>  'Faction',
'guild_armory_link' =>  'Lien armurerie',
'guild_armory_code' =>  'URL Armurerie',
'guild_id' =>  'Guild ID',
'raid_force_id' =>  'Raid Force ID',
'raid_force_name' =>  'Raid Force',
'id' =>  'ID',
'invite_time' =>  'Groupage',
'level' =>  'Niveau',
'location' =>  'Donjon',
'max_lvl' =>  'Niv Max',
'max_raiders' =>  'Limite de joueurs',
'locked_header' =>  'Locked?',
'message' =>  'Message',
'min_lvl' =>  'Niv Min',
'name' =>  'Nom',
'officer' =>  'Créateur',
'no_data' =>  'Vide',
'posted_by' =>  'Posté par',
'race' =>  'Race',
'start_time' =>  'Heure de Début',
'team_name' =>  'Nom de l\'équipe',
'time' =>  'Heure',
'title' =>  'Titre',
'totals' =>  'Total',
'username' =>  'Nom du Joueur',
'records' =>  'Enregistrement(s)',
'to' =>  'to',
'of' =>  'of',
'total' =>  'total',
'section' =>  'Section',
'prev' =>  'Préc',
'next' =>  'Suiv',
'earned' =>  'Gagné',
'spent' =>  'Passé',
'adjustment' =>  'Ajustement',
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
'connect_socked_error' =>  'Erreur de connection au socket, erreur : %s',
'invalid_group_title' =>  'Le groupe existe déja',
'invalid_group_message' =>  'The group selected is already part of this set. Press your browsers BACK button to try again.',
'invalid_option_title' =>  'Entrée invalide pour cette page',
'invalid_option_msg' =>  'Vous avez essayé d\'entrer dans cette page avec une entrée invalide.',
'no_user_msg' =>  'Cet utilisateur n\'existe pas ou a été éffacé.',
'no_user_title' =>  'Utilisateur non existant',
'print_error_critical' =>  'erreur critique!',
'print_error_details' =>  'Détails',
'print_error_minor' =>  'erreur mineure!',
'print_error_msg_begin' =>  'Sorry, WRM has encountered ',
'print_error_msg_end' =>  'If this error persists, please make a post 
									with this message <br>on the <a href="http://www.wowraidmanager.net/">wowraidmanager.net Forums</a> and
									we will do our best to get it corrected. Thanks!',
'print_error_page' =>  'Page',
'print_error_query' =>  'Requète',
'print_error_title' =>  'Uh oh! You hit a boo boo',
'socket_functions_disabled' =>  'Update checked failed to connect to server.',

// forms
'asc' =>  'ascendant',
'auth_phpbb_no_groups' =>  'Auncun groupe disponible',
'desc' =>  'descendant',
'form_error' =>  'Error with your form submission',
'form_select' =>  'Sèlectionnez',
'no' =>  'Non',
'none' =>  'Aucun',
'guild_name_missing' =>  'The Full Guild Name is missing.',
'guild_tag_missing' =>  'The Guild Tag is missing.',
'permissions_form_description' =>  'Vous devez ajouter une description',
'permissions_form_name' =>  'Vous devez renseigner un nom',
'profile_error_arcane' =>  'Arcanes doit etre un nombre',
'profile_error_class' =>  'Vous devez sèlectionner une classe',
'profile_error_dupe' =>  'Un personnage porte déja ce nom',
'profile_error_fire' =>  'Feu doit etre un nombre',
'profile_error_frost' =>  'Givre doit etre un nombre',
'profile_error_guild' =>  'Vous devez sèlectionner une guilde',
'profile_error_level' =>  'Le niveau doit etre un nombre entre 1 et 80',
'profile_error_name' =>  'Vous devez renseigner un nom',
'profile_error_nature' =>  'Nature doit etre un nombre',
'profile_error_race' =>  'Vous devez sèlectionner une race',
'profile_error_role' =>  'Vous devez renseigner un role',
'profile_error_shadow' =>  'Ombre doit etre un nombre',
'raid_error_date' =>  'Vous devez entrer une date au format valide',
'raid_error_description' =>  'La description doit etre écrite',
'raid_error_limits' =>  'Toutes les limites de raid doivent etre numèriques',
'raid_error_location' =>  'Ajouter un lieu de raid',
'view_error_signed_up' =>  'Vous etes dèja inscrit avec ce personnage',
'view_error_role_undef' =>  'Make sure that the Character in <a href="profile.php?mode=view">Profile</a> has a defined Role.',
'yes' =>  'Oui',
'teams_error_no_team' =>  'No team is selected to add users to.',

// Buttons
'submit' =>  'Valider',
'reset' =>  'Réinitialiser',
'confirm' =>  'Confirmer',
'update' =>  'Modifier',
'confirm_deletion' =>  'Confirmer Suppression',
'filter' =>  'Filtrer',
'addchar' =>  'Ajouter un Personnage',
'updatechar' =>  'Modifier un Personnage',
'login' =>  'S\'identifier',
'logout' =>  'Déconnexion',
'signup' =>  'S\'inscrire',
'apply' =>  'Apply Options',

// generic information
'delete_msg' =>  'NOTICE: La suppression est IRREVERSIBLE. <br>Cliquez sur le bouton pour confirmer.',
'maintenance_header' =>  'Site en maintenance, contactez l\'administrateur si besoin.',
'maintenance_message' =>  'WoW Raid Manager est actuellement en maintenance. Réessayez plus tard.',
'disabled_header' =>  'Site Disabled Notice!',
'disabled_message' =>  'Please note, your site is disabled. Visitors can\'t use the system right now!<br>Go to <u>Configuration</u> and then uncheck <u>Disable WRM</u>',
'userclass_msg' =>  'Your user is not authorized to use WoW Raid Manager, please contact the system administrator.',
'priv_title' =>  'Privilèges insuffisants',
'priv_msg' =>  'Vosu n\'avez pas les privilèges pour accèder a cette page. Contactez l\'administrateur si vous pensez que c une erreur',
'remember' =>  'Garder mon identifiant en mémoire',
'welcome' =>  'Bienvenue ',

// Login Information
'login_fail_title' =>  'Erreur d\'identification',
'login_fail' =>  'Mauvais mot de passe ou mauvais Identifiant. Veuillez réessayer.',
'login_forgot_password' =>  'Forgot Your Password?',
'login_pwdreset_fail_title' =>  'Failed to Send/Reset Password',
'login_pwdreset_title' =>  'Reset Password',
'login_password_reset_msg' =>  'To Reset Your Password Please Enter the Following Information',
'login_username_email_incorrect' =>  'The Entered Username and/or Email Address is Incorrect.<br><br>Please Click the Back Button and Try Again.',
'login_password_sent' =>  'Your WRM password has been reset and the new password has been sent to:<br><br>',
'login_password_sent2' =>  '<br><br>Please check the E-Mail address listed above for a message from this system. ' .
									'If you do not see the message please check your spam folder and/or turn off ' .
									'your spam filter and use the "Forgot My Password" link again.',
'login_password_email_msg' =>  'THIS MESSAGE IS NOT SPAM!<br><br>Someone (hopefully you) has clicked the ' .
										'"Forgot My Password" link on a WRM installation and entered an account with ' .
										'your e-mail address.  Your WRM Password has been reset by the WRM system.  The ' .
										'new password is:<br><br>',
'login_password_email_msg2' =>  '<br><br>Please login to the WRM system using the above supplied password and click the ' .
										 '"Click to Change Password" link under the Log Out button to reset your password ' .
										 'to something more memorable.<br><br>If you were NOT the one to click this link please ' .
										 'contact your WRM administrator to inform them that the reset link is being abused.<br><br>' .
										 'You will still need to use the new password supplied above to access your WRM account.',
'login_password_email_sub' =>  'WRM Password Reset Notification',										 
'login_chpass_text' =>  'Change Password For User: ',
'login_chpwd' =>  'Click to Change Password',
'login_curr_password' =>  'Current Password',
'login_password_conf' =>  'Confirm Password',
'login_password_incorrect' =>  'Either the current password for the listed username is incorrect or the new password and ' .
										'confirm password do not match.<br><br>Please Click the Back Button and Try Again.',
'login_password_new' =>  'New Password',
'login_pwdreset_success' =>  'Your password HAS BEEN correctly reset.<br><br>You will need to use the new password the next time you login.',

// Days of the Week
'month' =>  'Mois',
'year' =>  'Ann&eacute;e',
'sunday' =>  'Dimanche',
'monday' =>  'Lundi',
'tuesday' =>  'Mardi',
'wednesday' =>  'Mercredi',
'thursday' =>  'Jeudi',
'friday' =>  'Vendredi',
'saturday' =>  'Samedi',
'2ltrsunday' =>  'Dim',
'2ltrmonday' =>  'Lun',
'2ltrtuesday' =>  'Mar',
'2ltrwednesday' =>  'Mer',
'2ltrthursday' =>  'Jeu',
'2ltrfriday' =>  'Ven',
'2ltrsaturday' =>  'Sam',

// Months
'month1' =>  'Janvier',
'month2' =>  'F&eacute;vrier',
'month3' =>  'Mars',
'month4' =>  'Avril',
'month5' =>  'Mai',
'month6' =>  'Juin',
'month7' =>  'Juillet',
'month8' =>  'Ao&ucirc;t',
'month9' =>  'Septembre',
'month10' =>  'Octobre',
'month11' =>  'Novembre',
'month12' =>  'D&eacute;cembre',
							
// links
'announcements_link' =>  '&raquo; Messages D\'Accueil',
'configuration_link' =>  '&raquo; Configuration',
'guilds_link' =>  '&raquo; Guildes',
'home_link' =>  '&raquo; Page D\'Accueil',
'calendar_link' =>  '&raquo; Calendrier Graphique',
'locations_link' =>  '&raquo; Lieux De Raid',
'permissions_link' =>  '&raquo; Droits',
'profile_link' =>  '&raquo; Mes Persos',
'raids_link' =>  '&raquo; Raids',
'register_link' =>  '&raquo; Enregistrement',
'roster_link' =>  '&raquo; Roster',
'users_link' =>  '&raquo; Utilisateurs',
'lua_output_link' =>  '&raquo; Lua output raids',
'index_link' =>  '&raquo; Forum AC',
'dkp_link' =>  '&raquo; DKP',
'bosstrack_link' =>  '&raquo; Boss Kill Tracking',
'raidsarchive_link' =>  '&raquo; Raids Archive',

// sorting information
'sort_text' =>  'Cliquer ici pour trier par ',
'sort_desc' => 'Click here to sort (in descending order) by ',
'sort_asc' => 'Click here to sort (in ascending order) by ', 

// tooltips
'add' =>  'Ajouter',
'announcements' =>  'Messages D\'accueil',
'arcane' =>  'Arcanes',
'calendar' =>  'Calendrier',
'cancel' =>  'Annuler inscription',
'cancel_msg' =>  'Vouz avez annulé votre inscription pour ce raid',
'comments' =>  'Commentaires',
'configuration' =>  'Configuration',
'deathknight_icon' =>  'Cliquez pour voir les Death Knights',
'delete' =>  'Supprimer',
'description' =>  'Description',
'druid_icon' =>  'Cliquez pour voir les Druides',
'edit' =>  'Editer',
'edit_comment' =>  'Editer Commentaire',
'fire' =>  'Feu',
'frost' =>  'Givre',
'frozen_msg' =>  'Les inscriptions pour ce raid sont fermées.',
'group_name' =>  'Nom du groupe',
'group_description' =>  'Description du Groupe',
'guilds' =>  'Guildes',
'has_permission' =>  'Has Permission',
'hunter_icon' =>  'Cliquez pour voir les Chasseurs',
'in_queue' =>  'Placer le personnage en file d\'attente',
'last_login_date' =>  'Dernière connexion',
'last_login_time' =>  'Heure de la dernière connexion',
'locations' =>  'Lieux',
'logs' =>  'Journaux',
'lua' =>  'LUA and macro output',
'mage_icon' =>  'Cliquez pour voir les Mages',
'mark' =>  'Marquer en ancien raid',
'nature' =>  'Nature',
'new' =>  'Marquer en nouveau raid',
'not_signed_up' =>  'Cliquez ici pour vous inscrire au Raid',
'out_queue' =>  'Placer le joueur dans le raid',
'paladin_icon' =>  'Cliquez pour voir les Paladins',
'permissions' =>  'Droits',
'priest_icon' =>  'Cliquez pour voir les prètres',
'priv' =>  'Privilèges',
'profile' =>  'Personnages',
'raids' =>  'Raids',
'remove_group' =>  'Remove group from set',
'remove_user' =>  'Remove user from set',
'rogue_icon' =>  'Cliquez pour voir les Voleurs',
'shadow' =>  'Ombre',
'shaman_icon' =>  'Cliquez pour voir les Chamans',
'signed_up' =>  'You are signed up for this raid',
'signup_add' =>  'Add user to signups',
'signup_delete' =>  'Supprimer le joueur du raid (permanant)',
'users' =>  'Utilisateurs',
'warlock_icon' =>  'Cliquez pour voir les Démonistes',
'warrior_icon' =>  'Cliquez pour voir les Guerriers',

));  ?>