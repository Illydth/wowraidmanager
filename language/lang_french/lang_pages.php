<?php
/***************************************************************************
*                          lang_pages.php (French)
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
$phprlang['announcements_new_header'] = 'Cr&eacute;er un messages D\'Accueil';
$phprlang['announcements_msg_txt'] = 'Message';
$phprlang['announcements_title_txt'] = 'Titre';

// Calendar
$phprlang['invites'] = 'Invites';
$phprlang['start'] = 'D&eacute;but';
$phprlang['key'] = 'L&eacute;gende:<br>Bord blanc = Non inscrit<br>Bord Vert = Inscrit & S&eacute;lectionn&eacute;<br>Bord Bleu = Inscrit, En file d\'attente<br>Bord Rouge = Inscription annul&eacute;e<br><span class="priorDay">CES DATES</span> sont dans le pass&eacute;.<br><span class="currentDay">DATE</span> d\'aujourd\'hui.<br><span class="postDay">CES DATES</span> sont dans le futur.'; //New
$phprlang['calendar_month_select_header'] = 'S&eacute;lectionnez un mois et une ann&eacute;e pour l\'afficher';

// DKP View
$phprlang['eqdkp_system_link'] = 'Lien direct vers le gestionnaire de DKP:';

// guilds
$phprlang['guilds_header'] = 'Liste des Guildes';
$phprlang['guilds_new_header'] = 'Nouvelle Guilde';
$phprlang['guilds_master'] = 'Maitre de guilde';
$phprlang['guilds_name'] = 'Nom complet';
$phprlang['guilds_tag']   = 'Tag';
$phprlang['guilds_description'] = 'Description ';
$phprlang['guilds_server'] = 'Serveur';
$phprlang['guilds_faction'] = 'Faction';
$phprlang['guilds_armory_code'] = 'URL Armurerie Battle.Net';
$phprlang['armory_lang_US'] = 'US : http://us.battle.net/wow/ : Anglais US'; //New
$phprlang['armory_lang_EU'] = 'EU : http://eu.battle.net/wow/ : Anglais GB'; //New
$phprlang['armory_lang_DE'] = 'DE : http://eu.battle.net/wow/ : Allemand'; //New
$phprlang['armory_lang_ES'] = 'ES : http://eu.battle.net/wow/ : Espagnol'; //New
$phprlang['armory_lang_FR'] = 'FR : http://eu.battle.net/wow/ : Fran&ccedil;ais'; //New
$phprlang['armory_lang_KR'] = 'KR : http://kr.battle.net/wow/ : Cor&eacute;en'; //New
$phprlang['armory_lang_TW'] = 'TW : http://tw.battle.net/wow/ : Ta&iuml;wainais'; //New
$phprlang['armory_lang_none'] = 'Inexistant ou non applicable'; //New

// locations
$phprlang['locations_header'] = 'Lieux enregistr&eacute;s';
$phprlang['locations_max_lvl'] = 'Niveau Max';
$phprlang['locations_min_lvl'] = 'Niveau Mini';
$phprlang['locations_limits_header'] = 'Nombre de joueurs du Raid';
$phprlang['locations_long'] = 'Donjon';
$phprlang['locations_new'] = 'Creer un nouveau lieu de Raid';
$phprlang['locations_raid_max'] = 'Nombre max de joueurs';
$phprlang['locations_short'] = 'Identifiant';
$phprlang['lock_template'] = 'Structure du raid verrouill&eacute;?';
$phprlang['locations_ro_text'] = 'Lecture seule: Rempli avec les noms officiels de WoW';
$phprlang['locations_expansion_text'] = 'Expansion';
$phprlang['locations_events_text'] = 'Nom de l\'&eacute;v&egrave;nement';

// lua_output
$phprlang['rim_download'] = 'T&eacute;l&eacute;charger RIM (Raid Information Manager)';
$phprlang['phprv_download'] = 'T&eacute;l&eacute;charger phpRaidViewer';
$phprlang['lua_header'] = 'Sortie LUA/Macro';
$phprlang['sort_name'] = 'Nom';
$phprlang['sort_date'] = 'Date';
$phprlang['output_rim'] = 'RIM (Raid Invite Manager)';
$phprlang['output_phprv'] = 'PHP Raid Viewer';
$phprlang['sort_signups_text'] = 'Trier les inscrits par :';
$phprlang['sort_queue_text'] = 'Trier la file d\'attente par :';
$phprlang['output_format_text'] = 'Format de Sortie:';
$phprlang['options_header'] = 'Options';
$phprlang['lua_output_header'] = 'Commencer la sortie LUA';
$phprlang['lua_show_all_raids'] = 'Sortir tous les raids &agrave; inscription ouverte';
$phprlang['lua_failed_to_write'] = 'Le fichier LUA ne peu &ecirc;tre cr&eacute;&eacute; - &eacute;chec en &ecute;criture.</b><br/>' .
                           'Merci d\'afficher les avertissement (E_WARNING, ou mieux) ' .
                           'pour voir le probl&ecirc;me<br>' .
                           'Utilisez ceci en copier-coller:<br>';
$phprlang['lua_rim_write_success'] = '<b>Fichier LUA cr&eacute;&eacute;.</b><br>' .
                           'T&eacute;l&eacute;charger <a href="cache/raid_lua/phpRaid_Data.lua">phpRaid_Data.lua</a> and sauvegardez
                           le dans [wow]\interface\addons\RIM\<br>' .
                           'ou utilisez ceci en copier-coller :<br>';
$phprlang['lua_prv_write_success'] = '<b>Fichier LUA cr&eacute;&eacute;.</b><br>' .
                           'T&eacute;l&eacute;charger <a href="cache/raid_lua/phpRaid_Data.lua">phpRaid_Data.lua</a> and sauvegardez
                           le dans [wow]\interface\addons\phpraidviewer\<br>' .
                           'ou utilisez ceci en copier-coller :<br>';

// permissions
$phprlang['permissions_add'] = 'Affecter les joueurs coch&eacute;s aux droits';
$phprlang['permissions_announcements'] = 'Messages d\'accueil';
$phprlang['permissions_configuration'] = 'Configuration';
$phprlang['permissions_details_users_header'] = 'Droits des utilisateurs d&eacute;taill&eacute;s';
$phprlang['permissions_edit_header'] = 'Editer';
$phprlang['permissions_description'] = 'Description';
$phprlang['permissions_details_header'] = 'Droits d&eacute;taill&eacute;s';
$phprlang['permissions_guilds'] = 'Guildes';
$phprlang['permissions_header'] = 'Droits';
$phprlang['permissions_locations'] = 'Lieux de Raids';
$phprlang['permissions_logs'] = 'Journaux';
$phprlang['permissions_name'] = 'Nom';
$phprlang['permissions_permissions'] = 'Droits';
$phprlang['permissions_profile'] = 'Personnages';
$phprlang['permissions_raids'] = 'Raids';
$phprlang['permissions_new'] = 'Cr&eacute;er de nouveaux droits';
$phprlang['permissions_users'] = 'Utilisateurs';
$phprlang['permissions_users_header'] = 'Utilisateurs affect&eacute;s &agrave; ces droits';

// profile
$phprlang['profile_arcane'] = 'R&eacute;sistance aux Arcanes';
$phprlang['profile_class'] = 'Classe';
$phprlang['profile_create_header'] = 'Impossible de cr&eacute;er le personnage';
$phprlang['profile_create_msg'] = 'Impossible de cr&eacute;er un personnage tant qu\'un administrateur n\'aura pas cr&eacute;&eacute; de guilde';
$phprlang['profile_fire'] = 'Resistance Feu';
$phprlang['profile_frost'] = 'Resistance au Givre';
$phprlang['profile_gender'] = 'Sexe';
$phprlang['profile_guild'] = 'Guilde';
$phprlang['profile_role'] = 'R&ocirc;le';
$phprlang['profile_header'] = 'Characters';
$phprlang['profile_level'] = 'Niveau';
$phprlang['profile_name'] = 'Nom';
$phprlang['profile_raid'] = 'Participation aux raids';
$phprlang['profile_race'] = 'Race';
$phprlang['profile_header_text'] = "my Profile";
$phprlang['profile_number_character'] = "Number of my Character";
$phprlang['profile_number_signups_all'] = "Number of all my signups";
$phprlang['profile_number_signups_draft'] = "Number of my signups in confirmation list";
$phprlang['profile_number_signups_queue'] = "Number of my signups in queue list";
$phprlang['profile_number_signups_chancel'] = "Number of my checkouts (chancel)";

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
$phprlang['raids_edit_header'] = 'Editer Raid'; //new
$phprlang['raids_start'] = 'D&eacute;part';
$phprlang['raids_eventtype_text'] = 'Type &Eacute;v&egrave;nement';
$phprlang['raids_mark_selected_raids_to_old'] = "Clore et terminer tous les raids coch&eacute;s";

// event type
$phprlang['event_type_raid'] = 'Raid (10/25 joueurs)';
$phprlang['event_type_dungeon'] = 'Donjon (Instance &agrave; 5)';
$phprlang['event_type_pvp'] = '&Eacute;v&egrave;nement PvP';
$phprlang['event_type_meeting'] = 'Rencontre (en ligne/hors-ligne)';
$phprlang['event_type_other'] = 'Autre';

// expansions
$phprlang['exp_generic_wow'] = 'World of Warcraft g&eacute;n&eacute;';
$phprlang['exp_burning_crusade'] = 'The Burning Crusade';
$phprlang['exp_wrath_lich_king'] = 'Wrath of the Lich King';
$phprlang['exp_cataclysm'] = 'Cataclysm';

// roster
$phprlang['roster_header'] = 'Liste des Joueurs';

// registration
$phprlang['register_complete_header'] = 'Inscription Termin&eacute;e';
$phprlang['register_complete_msg'] = 'Vous etes maintenant enregistr&eacute; pour utiliser WRM. Vous pourrez cr&eacute;er vos personnages et vous inscrire apr&egrave;s que votre inscription ait &eacute;t&eacute; valid&eacute;e par un administrateur.';
$phprlang['register_confirm'] = 'Mot de passe incorrect ou invalide.';
$phprlang['register_confirm_text'] = 'Entrez &agrave; nouveau votre mot de passe';
$phprlang['register_email_header'] = 'Enregistrement &agrave;';
$phprlang['register_email_empty'] = 'Vous devez renseigner une adresse e-mail';
$phprlang['register_email_exists'] = 'Cet e-mail existe d&eacute;j&agrave; sur un autre compte, veuillez contacter l\'administrateur';
$phprlang['register_email_greeting'] = 'Bienvenue ! ';
$phprlang['register_email_subject'] = 'Merci de ne pas r&eacute;pondre &agrave; cet e-mail.';
$phprlang['register_email_text'] = 'Adresse E-Mail';
$phprlang['register_error'] = 'Erreur d\'enregistrement';
$phprlang['register_header'] = 'Enregistrement d\'un utilisateur';
$phprlang['register_pass_empty'] = 'Vous devez mettre un mot de passe';
$phprlang['register_password_text'] = 'Mot de passe';
$phprlang['register_user_empty'] = 'Vous devez mettre un nom';
$phprlang['register_user_exists'] = 'Ce nom est d&eacute;j&agrave; utilis&eacute;';
$phprlang['register_username_text'] = 'Nom d\'utilisateur';

// users
$phprlang['users_assign'] = 'ASSIGNER LES DROITS';
$phprlang['users_char_header'] = 'Personnages';
$phprlang['users_header'] = 'Utilisateurs';

// view
$phprlang['view_approved'] = 'Personnages approuv&eacute;s';
$phprlang['view_cancel_header'] = 'Inscriptions annul&eacute;es';
$phprlang['view_character'] = 'Personnage';
$phprlang['view_comments'] = 'Commentaire';
$phprlang['view_create'] = 'Cr&eacute;er un personnage pour s\'inscrire';
$phprlang['view_date'] = 'Date';
$phprlang['view_description_header'] = 'Description de la rencontre';
$phprlang['view_frozen'] = 'Les inscriptions sont ferm&eacute;es';
$phprlang['view_information_header'] = 'Information';
$phprlang['view_invite'] = 'Heure de Groupage';
$phprlang['view_location'] = 'Donjon';
$phprlang['view_login'] = 'S\'identifier pour s\'inscrire';
$phprlang['view_new'] = 'S\'inscrire pour ce raid';
$phprlang['view_max'] = 'Nombre de joueurs';
$phprlang['view_max_lvl'] = 'Niveau Maximum';
$phprlang['view_min_lvl'] = 'Niveau Minimum';
$phprlang['view_missing_signups_link_text'] = 'Voir les personnages NON inscrits &agrave; ce raid.';
$phprlang['view_officer'] = 'Cr&eacute;ateur de l\'&eacute;v&egrave;nement';
$phprlang['view_ok'] = 'Ouvert aux inscriptions';
$phprlang['view_queue'] = 'Comment valider votre inscription?';
$phprlang['view_queue_header'] = 'Inscriptions en attente';
$phprlang['view_queued'] = 'Membres en attente';
$phprlang['view_raid_cancel_text'] = 'Inscriptions annul?es';
$phprlang['view_signed'] = 'Vous êtes d&eacute;j&agrave; inscris';
$phprlang['view_signup'] = 'Infos sur l\'inscription';
$phprlang['view_signup_queue'] = 'En file d\'attente';
$phprlang['view_signup_cancel'] = 'Non pr&eacute;sent';
$phprlang['view_signup_draft'] = 'Dans le raid';
$phprlang['view_start'] = 'Heure de d&eacute;marrage';
$phprlang['view_statistics_header'] = 'Statistiques';
$phprlang['view_teams_link_text'] = 'Cr&eacute;er et assigner une &eacute;quipe au raid';
$phprlang['view_total'] = 'Nombre d\'inscrits';
$phprlang['view_username'] = 'Nom d\'utilisateur';
$phprlang['view_missing_signups_return_to_view']= 'Retour au panneau Raid'; //New

// main page
$phprlang['main_previous_raids'] = 'Anciennes rencontres';
$phprlang['main_upcoming_raids'] = 'Prochaines rencontres';
$phprlang['signup'] = 'S\'inscrire';
$phprlang['rss_feed_text'] = 'Raid flux RSS';
$phprlang['guild_time_string'] = 'Heure';
$phprlang['menu_header_text'] = 'Menu WRM AC';

// teams
$phprlang['team_new_header'] = 'Cr&eacute;er une &eacute;quipe';
$phprlang['team_add_header'] = 'Ajouter des membres &agrave; l\'&eacute;quipe';
$phprlang['team_remove_header'] = 'Supprimer des membres d\'une &eacute;quipe';
$phprlang['teams_raid_view_text'] = 'Retourner sur la fiche du Raid';
$phprlang['team_cur_teams_header'] = 'Equipes cr&eacute;&eacute;es';
$phprlang['team_page_header'] = 'Equipes';

// Boss Kill Tracking
$phprlang['boss_kill_type_dungeon'] = 'Donjon (5 joueurs)';
$phprlang['boss_kill_type_25_man'] = 'Raid 25 joueurs';
$phprlang['boss_kill_type_10_man'] = 'Raid 10 joueurs';
$phprlang['boss_kill_type_40_man'] = 'Raid 40 joueurs';
$phprlang['bosskill_header'] = 'Liste des Boss tu&eacute;s';

//Raids Archive
$phprlang['raidsarchive_header'] = 'Archive des raids';

//Menubar 
$phprlang['user_menu_header'] = 'User Menu';
$phprlang['main_menu_header'] = 'Main Menu';

//Signup Page
$phprlang['signup_edit_header'] = "Edit your Signup Settings";
$phprlang['signup_character_spec'] = "Character Spec";
?>