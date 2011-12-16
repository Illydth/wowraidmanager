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

if (empty($phprlang) || !is_array($phprlang))
	$phprlang = array();
	
$phprlang = array_merge($phprlang, array(


// announcements
'announcements_header' =>  'Messages D\'Accueil',
'announcements_new_header' =>  'Cr&eacute;er un messages D\'Accueil',
'announcements_msg_txt' =>  'Message',
'announcements_title_txt' =>  'Titre',

// Calendar
'invites' =>  'Invites',
'start' =>  'D&eacute;but',
'key' =>  'L&eacute;gende:<br>Bord blanc = Non inscrit<br>Bord Vert = Inscrit & S&eacute;lectionn&eacute;<br>Bord Bleu = Inscrit, En file d\'attente<br>Bord Rouge = Inscription annul&eacute;e<br><span class="priorDay">CES DATES</span> sont dans le pass&eacute;.<br><span class="currentDay">DATE</span> d\'aujourd\'hui.<br><span class="postDay">CES DATES</span> sont dans le futur.', //New
'calendar_month_select_header' =>  'S&eacute;lectionnez un mois et une ann&eacute;e pour l\'afficher',

// DKP View
'eqdkp_system_link' =>  'Lien direct vers le gestionnaire de DKP:',

// guilds
'guilds_header' =>  'Liste des Guildes',
'guilds_new_header' =>  'Nouvelle Guilde',
'guilds_master' =>  'Maitre de guilde',
'guilds_name' =>  'Nom complet',
'guilds_tag'   => 'Tag',
'guilds_description' =>  'Description ',
'guilds_server' =>  'Serveur',
'guilds_faction' =>  'Faction',
'guilds_armory_code' =>  'URL Armurerie Battle.Net',
'raid_force_header' =>  'Raid Force Listing', //New
'raid_force_select_text' =>  'Select Raid Force: ', //New
'raid_force_name_box_text' =>  'Raid Force Name', //New
'raid_force_guild_options_text' =>  'Guild', //New
'raid_force_new_header' =>  'New Raid Force Link', //New
'raid_force_name_missing' =>  'Raid Force Name must not be blank or NULL.', //New
'raid_force_duplicate' =>  'Duplicate Raid Force Name/Guild Record.', //New
'raid_force_guild_id_missing' =>  'Guild ID must not be blank or NULL', //New
'armory_lang_US' =>  'US : http://us.battle.net/wow/ : Anglais US', //New
'armory_lang_EU' =>  'EU : http://eu.battle.net/wow/ : Anglais GB', //New
'armory_lang_DE' =>  'DE : http://eu.battle.net/wow/ : Allemand', //New
'armory_lang_ES' =>  'ES : http://eu.battle.net/wow/ : Espagnol', //New
'armory_lang_FR' =>  'FR : http://eu.battle.net/wow/ : Fran&ccedil;ais', //New
'armory_lang_KR' =>  'KR : http://kr.battle.net/wow/ : Cor&eacute;en', //New
'armory_lang_TW' =>  'TW : http://tw.battle.net/wow/ : Ta&iuml;wainais', //New
'armory_lang_none' =>  'Inexistant ou non applicable', //New

// locations
'locations_header' =>  'Lieux enregistr&eacute;s',
'locations_max_lvl' =>  'Niveau Max',
'locations_min_lvl' =>  'Niveau Mini',
'locations_limits_header' =>  'Nombre de joueurs du Raid',
'locations_long' =>  'Donjon',
'locations_new' =>  'Creer un nouveau lieu de Raid',
'locations_raid_max' =>  'Nombre max de joueurs',
'locations_short' =>  'Identifiant',
'lock_template' =>  'Structure du raid verrouill&eacute;?',
'locations_ro_text' =>  'Lecture seule: Rempli avec les noms officiels de WoW',
'locations_expansion_text' =>  'Expansion',
'locations_events_text' =>  'Nom de l\'&eacute;v&egrave;nement',

// lua_output
'rim_download' =>  'T&eacute;l&eacute;charger RIM (Raid Information Manager)',
'phprv_download' =>  'T&eacute;l&eacute;charger phpRaidViewer',
'lua_header' =>  'Sortie LUA/Macro',
'sort_name' =>  'Nom',
'sort_date' =>  'Date',
'output_rim' =>  'RIM (Raid Invite Manager)',
'output_phprv' =>  'PHP Raid Viewer',
'sort_signups_text' =>  'Trier les inscrits par :',
'sort_queue_text' =>  'Trier la file d\'attente par :',
'output_format_text' =>  'Format de Sortie:',
'options_header' =>  'Options',
'lua_output_header' =>  'Commencer la sortie LUA',
'lua_show_all_raids' =>  'Sortir tous les raids &agrave; inscription ouverte',
'lua_failed_to_write' =>  'Le fichier LUA ne peu &ecirc;tre cr&eacute;&eacute; - &eacute;chec en &ecute;criture.</b><br/>' .
                           'Merci d\'afficher les avertissement (E_WARNING, ou mieux) ' .
                           'pour voir le probl&ecirc;me<br>' .
                           'Utilisez ceci en copier-coller:<br>',
'lua_rim_write_success' =>  '<b>Fichier LUA cr&eacute;&eacute;.</b><br>' .
                           'T&eacute;l&eacute;charger <a href="cache/raid_lua/phpRaid_Data.lua">phpRaid_Data.lua</a> and sauvegardez
                           le dans [wow]\interface\addons\RIM\<br>' .
                           'ou utilisez ceci en copier-coller :<br>',
'lua_prv_write_success' =>  '<b>Fichier LUA cr&eacute;&eacute;.</b><br>' .
                           'T&eacute;l&eacute;charger <a href="cache/raid_lua/phpRaid_Data.lua">phpRaid_Data.lua</a> and sauvegardez
                           le dans [wow]\interface\addons\phpraidviewer\<br>' .
                           'ou utilisez ceci en copier-coller :<br>',
'lua_drafted' =>  'Drafted Users', //New
'lua_queued' =>  'Queued Users', //New
'lua_macro_header' =>  'Macro output listing...', //New
'lua_macro_footer' =>  '<br>Macro output listing complete.<br>Copy and paste the above to a macro and run in-game.', //New

// permissions
'permissions_add' =>  'Affecter les joueurs coch&eacute;s aux droits',
'permissions_announcements' =>  'Messages d\'accueil',
'permissions_configuration' =>  'Configuration',
'permissions_details_users_header' =>  'Droits des utilisateurs d&eacute;taill&eacute;s',
'permissions_edit_header' =>  'Editer',
'permissions_description' =>  'Description',
'permissions_details_header' =>  'Droits d&eacute;taill&eacute;s',
'permissions_guilds' =>  'Guildes',
'permissions_header' =>  'Droits',
'permissions_locations' =>  'Lieux de Raids',
'permissions_logs' =>  'Journaux',
'permissions_name' =>  'Nom',
'permissions_permissions' =>  'Droits',
'permissions_profile' =>  'Personnages',
'permissions_raids' =>  'Raids',
'permissions_new' =>  'Cr&eacute;er de nouveaux droits',
'permissions_users' =>  'Utilisateurs',
'permissions_users_header' =>  'Utilisateurs affect&eacute;s &agrave; ces droits',

// profile
'profile_arcane' =>  'R&eacute;sistance aux Arcanes',
'profile_class' =>  'Classe',
'profile_create_header' =>  'Impossible de cr&eacute;er le personnage',
'profile_create_msg' =>  'Impossible de cr&eacute;er un personnage tant qu\'un administrateur n\'aura pas cr&eacute;&eacute; de guilde',
'profile_fire' =>  'Resistance Feu',
'profile_frost' =>  'Resistance au Givre',
'profile_gender' =>  'Sexe',
'profile_guild' =>  'Guilde',
'profile_role' =>  'R&ocirc;le',
'profile_header' =>  'Characters',
'profile_level' =>  'Niveau',
'profile_name' =>  'Nom',
'profile_nature' =>  'Resistance Nature',
'profile_raid' =>  'Participation aux raids',
'profile_race' =>  'Race',
'profile_shadow' =>  'Resistance Ombre',
'iLvL' =>  "iLvL (Equipped, Best)", //New
'health' =>  "Health", //New
'mana' =>  "Mana", //New

// raids
'raids_date' =>  'Date',
'raids_description' =>  'Description',
'raids_dungeon' =>  'Donjon',
'raids_freeze' =>  'Limite d\'inscription avant le raid (en heures)',
'raids_invite' =>  'Heure de Groupage',
'raids_limits' =>  'Nombre de joueurs',
'raids_location' =>  'Lieu du RAID',
'raids_max' =>  'Maximum de joueurs',
'raids_max_lvl' =>  'Niveau Maximum',
'raids_min_lvl' =>  'Niveau Minimum',
'raids_old' =>  'Anciens Raids',
'raids_new' =>  'Prochaines rencontres',
'raids_new_header' =>  'Nouveau Raid',
'raids_edit_header' =>  'Editer Raid', //new
'raids_start' =>  'D&eacute;part',
'raids_eventtype_text' =>  'Type &Eacute;v&egrave;nement',
'raids_mark_selected_raids_to_old' =>  "Clore et terminer tous les raids coch&eacute;s",

// event type
'event_type_raid' =>  'Raid (10/25 joueurs)',
'event_type_dungeon' =>  'Donjon (Instance &agrave; 5)',
'event_type_pvp' =>  '&Eacute;v&egrave;nement PvP',
'event_type_meeting' =>  'Rencontre (en ligne/hors-ligne)',
'event_type_other' =>  'Autre',

// expansions
'exp_generic_wow' =>  'World of Warcraft g&eacute;n&eacute;',
'exp_burning_crusade' =>  'The Burning Crusade',
'exp_wrath_lich_king' =>  'Wrath of the Lich King',
'exp_cataclysm' =>  'Cataclysm',

// roster
'roster_header' =>  'Liste des Joueurs',

// registration
'register_complete_header' =>  'Inscription Termin&eacute;e',
'register_complete_msg' =>  'Vous etes maintenant enregistr&eacute; pour utiliser WRM. Vous pourrez cr&eacute;er vos personnages et vous inscrire apr&egrave;s que votre inscription ait &eacute;t&eacute; valid&eacute;e par un administrateur.',
'register_confirm' =>  'Mot de passe incorrect ou invalide.',
'register_confirm_text' =>  'Entrez &agrave; nouveau votre mot de passe',
'register_email_header' =>  'Enregistrement &agrave;',
'register_email_empty' =>  'Vous devez renseigner une adresse e-mail',
'register_email_exists' =>  'Cet e-mail existe d&eacute;j&agrave; sur un autre compte, veuillez contacter l\'administrateur',
'register_email_greeting' =>  'Bienvenue ! ',
'register_email_subject' =>  'Merci de ne pas r&eacute;pondre &agrave; cet e-mail.',
'register_email_text' =>  'Adresse E-Mail',
'register_error' =>  'Erreur d\'enregistrement',
'register_header' =>  'Enregistrement d\'un utilisateur',
'register_pass_empty' =>  'Vous devez mettre un mot de passe',
'register_password_text' =>  'Mot de passe',
'register_user_empty' =>  'Vous devez mettre un nom',
'register_user_exists' =>  'Ce nom est d&eacute;j&agrave; utilis&eacute;',
'register_username_text' =>  'Nom d\'utilisateur',

// users
'users_assign' =>  'ASSIGNER LES DROITS',
'users_char_header' =>  'Personnages',
'users_header' =>  'Utilisateurs',

// view
'view_approved' =>  'Personnages approuv&eacute;s',
'view_cancel_header' =>  'Inscriptions annul&eacute;es',
'view_character' =>  'Personnage',
'view_comments' =>  'Commentaire',
'view_create' =>  'Cr&eacute;er un personnage pour s\'inscrire',
'view_date' =>  'Date',
'view_description_header' =>  'Description de la rencontre',
'view_frozen' =>  'Les inscriptions sont ferm&eacute;es',
'view_information_header' =>  'Information',
'view_invite' =>  'Heure de Groupage',
'view_location' =>  'Donjon',
'view_login' =>  'S\'identifier pour s\'inscrire',
'view_new' =>  'S\'inscrire pour ce raid',
'view_max' =>  'Nombre de joueurs',
'view_max_lvl' =>  'Niveau Maximum',
'view_min_lvl' =>  'Niveau Minimum',
'view_missing_signups_link_text' =>  'Voir les personnages NON inscrits &agrave; ce raid.',
'view_officer' =>  'Cr&eacute;ateur de l\'&eacute;v&egrave;nement',
'view_ok' =>  'Ouvert aux inscriptions',
'view_queue' =>  'Comment valider votre inscription?',
'view_queue_header' =>  'Inscriptions en attente',
'view_queued' =>  'Membres en attente',
'view_raid_cancel_text' =>  'Inscriptions annul?es',
'view_signed' =>  'Vous êtes d&eacute;j&agrave; inscris',
'view_signup' =>  'Infos sur l\'inscription',
'view_signup_queue' =>  'En file d\'attente',
'view_signup_cancel' =>  'Non pr&eacute;sent',
'view_signup_draft' =>  'Dans le raid',
'view_start' =>  'Heure de d&eacute;marrage',
'view_statistics_header' =>  'Statistiques',
'view_teams_link_text' =>  'Cr&eacute;er et assigner une &eacute;quipe au raid',
'view_total' =>  'Nombre d\'inscrits',
'view_username' =>  'Nom d\'utilisateur',
'view_missing_signups_return_to_view' =>  'Retour au panneau Raid', //New

// main page
'main_previous_raids' =>  'Anciennes rencontres',
'main_upcoming_raids' =>  'Prochaines rencontres',
'signup' =>  'S\'inscrire',
'rss_feed_text' =>  'Raid flux RSS',
'guild_time_string' =>  'Heure',
'menu_header_text' =>  'Menu WRM AC',

// teams
'team_new_header' =>  'Cr&eacute;er une &eacute;quipe',
'team_add_header' =>  'Ajouter des membres &agrave; l\'&eacute;quipe',
'team_remove_header' =>  'Supprimer des membres d\'une &eacute;quipe',
'teams_raid_view_text' =>  'Retourner sur la fiche du Raid',
'team_cur_teams_header' =>  'Equipes cr&eacute;&eacute;es',
'team_page_header' =>  'Equipes',

// Boss Kill Tracking
'boss_kill_type_dungeon' =>  'Donjon (5 joueurs)',
'boss_kill_type_25_man' =>  'Raid 25 joueurs',
'boss_kill_type_10_man' =>  'Raid 10 joueurs',
'boss_kill_type_40_man' =>  'Raid 40 joueurs',
'bosskill_header' =>  'Liste des Boss tu&eacute;s',

//Raids Archive
'raidsarchive_header' =>  'Archive des raids',
));  ?>