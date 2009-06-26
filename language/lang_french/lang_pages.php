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
// announcements
$phprlang['announcements_header'] = 'Messages D\'Accueil';
$phprlang['announcements_new_header'] = 'Créer un messages D\'Accueil';
$phprlang['announcements_msg_txt'] = 'Message';
$phprlang['announcements_title_txt'] = 'Titre';

// Calendar
$phprlang['invites'] = 'Invites';
$phprlang['start'] = 'Début';
$phprlang['key'] = 'Key:<br>(<span class="draftedmark">*</span>) = Signed Up & Drafted<br>(<span class="qcanmark">#</span>) = Signed Up, Not Drafted (queued or cancelled)<br><span class="priorDay">TEXT</span> dates are in the past.<br><span class="currentDay">TEXT</span> date is today.<br><span class="postDay">TEXT</span> dates are in the future.';
$phprlang['calendar_month_select_header'] = 'Select Month and Year to View';

// configuration
$phprlang['configuration_addon'] = 'Addon URL';
$phprlang['configuraiton_admin'] = 'Administrateur';
$phprlang['configuration_admin_email'] = 'Admin e-mail';
$phprlang['configuration_ampm'] = 'Schedule Raids in 12h/24h format';
$phprlang['configuration_anonymous'] = 'Allow anonymous viewing';
$phprlang['configuration_armory_enable'] = 'Enable Armory Lookups';
$phprlang['configuration_armory_link_text'] = 'Correct Armory Link for Server';
$phprlang['configuration_armory_language_text'] = 'Code langage pour l\'armurerie';
$phprlang['configuration_autoqueue'] = 'Disallow Signup to Drafted Status';
$phprlang['configuration_cancel'] = 'Annuler';
$phprlang['configuration_cancel_def'] = 'Cancel = Place User Into Cancelled Area';
$phprlang['configuration_cancelled'] = 'Cancelled Status';
$phprlang['configuration_comments'] = 'Commentaires';
$phprlang['configuration_comments_def'] = 'Comments = Allow User to Edit Their Comments';
$phprlang['configuration_date'] = 'Date format<br><a href="http://www.php.net/date/" target="_blank">help?</a>';
$phprlang['configuration_description'] = 'Description';
$phprlang['configuration_debug'] = 'Debug mode';
$phprlang['configuration_default'] = 'Default Group';
$phprlang['configuration_delete'] = 'Supprimer';
$phprlang['configuration_delete_def'] = 'Delete = Remove User Signup Completely';
$phprlang['configuration_disable'] = 'Disable phpRaid';
$phprlang['configuration_draft_def'] = 'Draft = Place User into Attending Raid Area';
$phprlang['configuration_draft'] = 'Draft';
$phprlang['configuration_drafted'] = 'Drafted (In Raid)';
$phprlang['configuration_dst_text'] = 'Daylight saving time?';
$phprlang['configuration_email_header'] = 'E-mail configuration';
$phprlang['configuration_email_sig'] = 'E-mail signature';
$phprlang['configuration_enable_five_man'] = 'Enable groups<br><a href="docs/enable_groups.htm" target="_blank">help?</a>';
$phprlang['configuration_eqdkp_integration_text'] = 'Integrate with EqDKP<br><a href="docs/eqdkp_link.htm" target="_blank">help?</a>';
$phprlang['configuration_eqdkp_link'] = 'URL to Base of EqDKP Installation (No Trailing /)';
$phprlang['configuration_external_links_header'] = 'Integration with External Systems';
$phprlang['configuration_faction'] = 'Faction';
$phprlang['configuration_freeze'] = 'Disable freeze checking';
$phprlang['configuration_guild_header'] = 'Guild Configuration';
$phprlang['configuration_guild_name'] = 'Nom';
$phprlang['configuration_id'] = 'Show id in tables';
$phprlang['configuration_language'] = 'Langage';
$phprlang['configuration_logo'] = 'Path to header image';
$phprlang['configuration_multiple'] = 'Allow multiple signups';
$phprlang['configuration_on_queue'] = 'En file d\'attente';
$phprlang['configuration_queue'] = 'Queue';
$phprlang['configuration_queue_def'] = 'Queue = Place User In Queued Area';
$phprlang['configuration_raid_settings_header'] = 'Raid Settings';
$phprlang['configuration_raid_view_type_text'] = 'Select Raid View Type';
$phprlang['configuration_raid_view_type_class'] = 'Display Raid View By Class';
$phprlang['configuration_raid_view_type_role'] = 'Display Raid View By Role';
$phprlang['configuration_raidlead'] = 'Raid Leader';
$phprlang['configuration_resop'] = 'Make resistance optional';
$phprlang['configuration_register_text'] = 'Registration URL';
$phprlang['configuration_role_header'] = 'Role Configuration';
$phprlang['configuration_role1_text'] = 'Role #1';
$phprlang['configuration_role2_text'] = 'Role #2';
$phprlang['configuration_role3_text'] = 'Role #3';
$phprlang['configuration_role4_text'] = 'Role #4';
$phprlang['configuration_role5_text'] = 'Role #5';
$phprlang['configuration_role6_text'] = 'Role #6';
$phprlang['configuration_role_limit_text'] = 'Enforce Role Limits for Raid';
$phprlang['configuration_class_limit_text'] = 'Enforce Class Limits for Raid';
$phprlang['configuration_class_as_min'] = 'Use Class Limits as Minimums';
$phprlang['configuration_roster_text'] = 'Integrate with WoW Roster';
$phprlang['configuration_rss_site'] = 'RSS: URL to phpRaid Installation (No Trailing /)';
$phprlang['configuration_rss_export'] = 'RSS: Site to export RSS feed to';
$phprlang['configuration_rss_feed_amt'] = 'RSS: Number of Raids to Show in Feed';
$phprlang['configuration_server'] = 'Serveur';
$phprlang['configuration_show_addon'] = 'Show addon link';
$phprlang['configuration_signup_rights_header'] = 'Signup Rights';
$phprlang['configuration_site_header'] = 'Site Configuration';
$phprlang['configuration_sitelink'] = '"Home" Link Points To';
$phprlang['configuration_template'] = 'Talents';
$phprlang['configuration_time'] = 'Time format<br><a href="http://www.php.net/date/" target="_blank">help?</a>';
$phprlang['configuration_timezone_text'] = 'Timezone';
$phprlang['configuration_user'] = 'Utilisateurs';
$phprlang['configuration_user_rights_header'] = 'Droits des utilisateurs';
$phprlang['configuration_version_current'] = 'You are running the latest version of phpRaid';
$phprlang['configuration_version_info_header'] = 'Version Information';
$phprlang['configuration_version_outdated_header'] = 'WoW Raid Manager update available!';
$phprlang['configuration_version_outdated_message'] = 'Your version of WoW Raid Manager is out of date. Updating is strongly recommended.<br>
													   The latest version is %s and you are running version %s.<br>
													   To download, visit the <a href="http://www.wowraidmanager.net">WoW Raid Manager for BC download</a> section.';

// DKP View
$phprlang['eqdkp_system_link'] = 'Direct link to Associated DKP System:';

// guilds
$phprlang['guilds_header'] = 'Liste des Guildes';
$phprlang['guilds_new_header'] = 'New Guild';
$phprlang['guilds_master'] = 'Maitre de guilde';
$phprlang['guilds_name'] = 'Nom complet de la Guilde';
$phprlang['guilds_tag']	= 'Tag de Guilde';						

// locations
$phprlang['locations_header'] = 'Lieux enregistrés';
$phprlang['locations_max_lvl'] = 'Niveau Max';
$phprlang['locations_min_lvl'] = 'Niveau Mini';
$phprlang['locations_limits_header'] = 'Nombre de joueurs du Raid';
$phprlang['locations_long'] = 'Donjon';
$phprlang['locations_new'] = 'Creer un nouveau lieu de Raid';
$phprlang['locations_raid_max'] = 'Nombre max de joueurs';
$phprlang['locations_short'] = 'Identifiant';
$phprlang['lock_template'] = 'Locked Raid Template?';
$phprlang['locations_ro_text'] = 'Read Only: Populated With WoW Official Name for Instance';
$phprlang['locations_expansion_text'] = 'Expansion';
$phprlang['locations_events_text'] = 'Event Name';

// lua_output
$phprlang['rim_download'] = 'Download RIM (Raid Information Manager)';
$phprlang['lua_download'] = 'Download phpRaidViewer';
$phprlang['lua_header'] = 'LUA/Macro Output';

// permissions
$phprlang['permissions_add'] = 'Affecter les joueurs cochés aux droits';
$phprlang['permissions_announcements'] = 'Messages d\'accueil';
$phprlang['permissions_configuration'] = 'Configuration';
$phprlang['permissions_details_users_header'] = 'Droits des utilisateurs détaillés';
$phprlang['permissions_edit_header'] = 'Edit set';
$phprlang['permissions_description'] = 'Description';
$phprlang['permissions_details_header'] = 'Droits détaillés';
$phprlang['permissions_guilds'] = 'Guildes';
$phprlang['permissions_header'] = 'Droits';
$phprlang['permissions_locations'] = 'Lieux de Raids';
$phprlang['permissions_logs'] = 'Journaux';
$phprlang['permissions_name'] = 'Nom';
$phprlang['permissions_permissions'] = 'Droits';
$phprlang['permissions_profile'] = 'Personnages';
$phprlang['permissions_raids'] = 'Raids';
$phprlang['permissions_new'] = 'Créer de nouveaux droits';
$phprlang['permissions_users'] = 'Utilisateurs';
$phprlang['permissions_users_header'] = 'Utilisateurs affectés à ces droits';

// profile
$phprlang['profile_arcane'] = 'Resistance aux Arcanes';
$phprlang['profile_class'] = 'Classe';
$phprlang['profile_create_header'] = 'Impossible de créer le personnage';
$phprlang['profile_create_msg'] = 'Until an admin creates a guild character creation will be unavailable';
$phprlang['profile_fire'] = 'Resistance Feu';
$phprlang['profile_frost'] = 'Resistance au Givre';
$phprlang['profile_gender'] = 'Sexe';
$phprlang['profile_guild'] = 'Guilde';
$phprlang['profile_role'] = 'Role';
$phprlang['profile_header'] = 'Characters';
$phprlang['profile_level'] = 'Niveau';
$phprlang['profile_name'] = 'Nom';
$phprlang['profile_nature'] = 'Resistance Nature';
$phprlang['profile_raid'] = 'Participation aux raids';
$phprlang['profile_race'] = 'Race';
$phprlang['profile_shadow'] = 'Resistance Ombre';

// raids
$phprlang['raids_date'] = 'Date';
$phprlang['raids_description'] = 'Description';
$phprlang['raids_dungeon'] = 'Donjon';
$phprlang['raids_freeze'] = 'Limite d\'inscription avant le raid (en heures)';
$phprlang['raids_invite'] = 'Heure de Groupage';
$phprlang['raids_limits'] = 'Nombre de joueurs';
$phprlang['raids_location'] = 'Lieu du RAID';
$phprlang['raids_max'] = 'Maximum de joueurs';
$phprlang['raids_max_lvl'] = 'Niveau Maximum';
$phprlang['raids_min_lvl'] = 'Niveau Minimum';
$phprlang['raids_old'] = 'Anciens Raids';
$phprlang['raids_new'] = 'Prochaines rencontres';
$phprlang['raids_new_header'] = 'Nouveau Raid';
$phprlang['raids_start'] = 'Départ';
$phprlang['raids_eventtype_text'] = 'Event Type';

// event type
$phprlang['event_type_raid'] = 'Raid (10/25 man)';
$phprlang['event_type_dungeon'] = 'Dungeon (5 man Instance)';
$phprlang['event_type_pvp'] = 'PvP Event';
$phprlang['event_type_meeting'] = 'Meeting (online/offline)';
$phprlang['event_type_other'] = 'Other';

// expansions
$phprlang['exp_generic_wow'] = 'Generic World of Warcraft';
$phprlang['exp_burning_crusade'] = 'The Burning Crusade';
$phprlang['exp_wrath_lich_king'] = 'Wrath of the Lich King';

// roster
$phprlang['roster_header'] = 'Liste des Joueurs';

// registration
$phprlang['register_complete_header'] = 'Inscription complète';
$phprlang['register_complete_msg'] = 'Vous etes maintenant enregistré pour utiliser WRM. Vous pourrez créer vos personnages et vous inscrire après que votre inscription ait été validée par un administrateur.';
$phprlang['register_confirm'] = 'Mot de passe incorrect ou invalide.';
$phprlang['register_confirm_text'] = 'Entrez à nouveau votre mot de passe';
$phprlang['register_email_header'] = 'Enregistrement à';
$phprlang['register_email_empty'] = 'Vous devez renseigner une adresse e-mail';
$phprlang['register_email_exists'] = 'Cet e-mail existe déjà sur un autre compte, veuillez contacter l\'administrateur';
$phprlang['register_email_greeting'] = 'Bienvenue chez les fous ! ';
$phprlang['register_email_subject'] = 'Merci de ne pas répondre à cet e-mail car de toute façon personne ne le lira et encore moins y répondera :)';
$phprlang['register_email_text'] = 'Adresse E-Mail';
$phprlang['register_error'] = 'Erreur d\'enregistrement';
$phprlang['register_header'] = 'Enregistrement d\'un utilisateur';
$phprlang['register_pass_empty'] = 'Vous devez mettre un mot de passe';
$phprlang['register_password_text'] = 'Mot de passe';
$phprlang['register_user_empty'] = 'Vous devez mettre un nom';
$phprlang['register_user_exists'] = 'Ce nom est déjà utilisé';
$phprlang['register_username_text'] = 'Nom d\'utilisateur';

// users
$phprlang['users_assign'] = 'ASSIGNER LES DROITS';
$phprlang['users_char_header'] = 'Personnages';
$phprlang['users_header'] = 'Utilisateurs';

// view
$phprlang['view_approved'] = 'Personnages approuvés';
$phprlang['view_cancel_header'] = 'Inscriptions annulées';
$phprlang['view_character'] = 'Personnage';
$phprlang['view_comments'] = 'Commentaire';
$phprlang['view_create'] = 'Créer un personnage pour s\'inscrire';
$phprlang['view_date'] = 'Date';
$phprlang['view_description_header'] = 'Description de la rencontre';
$phprlang['view_frozen'] = 'Les inscriptions sont fermées';
$phprlang['view_information_header'] = 'Information';
$phprlang['view_invite'] = 'Heure de Groupage';
$phprlang['view_location'] = 'Donjon';
$phprlang['view_login'] = 'S\'identifier pour s\'inscrire';
$phprlang['view_new'] = 'S\'inscrire pour ce raid';
$phprlang['view_max'] = 'Nombre de joueurs';
$phprlang['view_max_lvl'] = 'Niveau Maximum';
$phprlang['view_min_lvl'] = 'Niveau Minimum';
$phprlang['view_missing_signups_link_text'] = 'Voir les personnages NON inscrits à ce raid.';
$phprlang['view_officer'] = 'Créateur de l\'évènement';
$phprlang['view_ok'] = 'Ouvert aux inscriptions';
$phprlang['view_queue'] = 'Comment valider votre inscription?';
$phprlang['view_queue_header'] = 'Inscriptions en attente';
$phprlang['view_queued'] = 'Membres en attente';
$phprlang['view_raid_cancel_text'] = 'Inscriptions annul�es';
$phprlang['view_signed'] = 'Vous êtes déjà inscris';
$phprlang['view_signup'] = 'Infos sur l\'inscription';
$phprlang['view_signup_queue'] = 'En file d\'attente';
$phprlang['view_signup_cancel'] = 'Non présent';
$phprlang['view_signup_draft'] = 'Dans le raid';
$phprlang['view_start'] = 'Heure de démarrage';
$phprlang['view_statistics_header'] = 'Statistiques';
$phprlang['view_teams_link_text'] = 'Créer et assigner une Equipe au raid';
$phprlang['view_total'] = 'Nombre d\'inscrits';
$phprlang['view_username'] = 'Nom d\'utilisateur';

// main page
$phprlang['main_previous_raids'] = 'Anciennes rencontres';
$phprlang['main_upcoming_raids'] = 'Prochaines rencontres';
$phprlang['signup'] = 'S\'inscrire';
$phprlang['rss_feed_text'] = 'Raid flux RSS';
$phprlang['guild_time_string'] = 'Heure';
$phprlang['menu_header_text'] = 'Menu WRM AC';

// teams
$phprlang['team_new_header'] = 'Créer une équipe';
$phprlang['team_add_header'] = 'Ajouter des membres à l\'équipe';
$phprlang['team_remove_header'] = 'Supprimer des membres d\'une équipe';
$phprlang['teams_raid_view_text'] = 'Retourner sur la fiche du Raid';
$phprlang['team_cur_teams_header'] = 'Equipes créées';
$phprlang['team_page_header'] = 'Equipes';
?>