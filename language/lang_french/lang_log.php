<?php

/***************************************************************************
*                             lang_log.php (French)
*                            -------------------
*   begin                : Saturday, Jan 16, 2005
*   copyright            : (C) 2007-2008 Douglas Wagner
*   email                : douglasw@wagnerweb.org
*
*   $Id: lang_log.php,v 2.00 2008/03/07 13:45:11 psotfx Exp $
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

// form variables
$phprlang['log_create_text'] = 'Cr&eacute;ations';
$phprlang['log_date'] = 'date';
$phprlang['log_delete_text'] = 'Suppressions';
$phprlang['log_hack_text'] = 'Tentatives de Hack';
$phprlang['log_id'] = 'id';
$phprlang['log_in'] = ' ordre ';
$phprlang['log_order'] = ' et afficher :';
$phprlang['log_raid_text'] = 'Activit&eacute; de raid';
$phprlang['log_sort_by'] = 'Trier par ';
$phprlang['log_type'] = 'type';

$phprlang['log_filter_show'] = 'Afficher';
$phprlang['log_filter_all'] = 'Tous';
$phprlang['log_filter_2_months'] = 'Deux Mois';
$phprlang['log_filter_1_month'] = 'Un Mois';
$phprlang['log_filter_1_week'] = 'Une Semaine';
$phprlang['log_filter_1_day'] = 'Un Jour';

// cancellation
$phprlang['log_cancel_message'] = '[ANNULATION UTILISATEUR]';

// hack
$phprlang['log_hack_header'] = 'Tentative de piratage d&eacute;tect&eacute;e';
$phprlang['log_hack_message'] = 'Une tentative de piratage aurait &eacute;t&eacute; d&eacute;tect&eacute;e et aura &eacute;t&eacute; enregistr&eacute;e avec les d&eactue;tails suivants :<br><br>
                     <strong>Tentative de piratage:</strong> %s<br>
                     <strong>Date/Heure:</strong> %s<br>
                     <strong>IP Utilisateur:</strong> %s<br><br>
                     Un administrateur a &eacute;t&eacute; pr&eacute;venu.';
                     
// headers
$phprlang['log_header'] = 'Journal de bord du gestionnaire de raid';
$phprlang['log_create_header'] = 'Journal des cr&eacute;ations';
$phprlang['log_delete_header'] = 'Journal des suppressions';
$phprlang['log_hack_header'] = 'Journal des piratages';
$phprlang['log_raid_header'] = 'Journal d\'activit&eacute; de raid';
$phprlang['log_sort_header'] = 'Veuillez s&eacute;lectionner les options de filtrage';
                     
// output text
$phprlang['log_create'] = '%s - %s: Utilisateur [<a href="users.php?mode=details&amp;user_id=%s">%s</a> (%s)] a cr&eacute;e <b>%s</b> ( id : [%s] nom : <b>[%s]</b> )';
$phprlang['log_delete'] = '%s - %s: Utilisateur [<a href="users.php?mode=details&amp;user_id=%s">%s</a> (%s)] a supprim&eacute; <b>%s</b> nomm&eacute; <b>[%s]</b>';
$phprlang['log_hack'] = '%s - %s: Utilisateur IP [%s] aurait tent&eacute; un piratage avec [%s]';
$phprlang['log_raid'] = '%s - %s: Utilisateur [<a href="users.php?mode=details&amp;user_id=%s">%s</a> (%s)] a modifi&eacute; le raid <a href="view.php?mode=view&amp;raid_id=%s">%s %s</a> par <b>%s</b> du personnage %s - %s';
?>