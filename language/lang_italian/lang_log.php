<?php

/***************************************************************************
 *                             lang_log.php
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
$phprlang['log_create_text'] = 'Inserimenti';
$phprlang['log_date'] = 'data';
$phprlang['log_delete_text'] = 'Eliminazioni';
$phprlang['log_hack_text'] = 'Tentativi di hacking';
$phprlang['log_id'] = 'id';
$phprlang['log_in'] = ' in ordine ';
$phprlang['log_order'] = ' e visualizza';
$phprlang['log_raid_text'] = 'Attività Raid';
$phprlang['log_sort_by'] = 'Ordina per ';
$phprlang['log_type'] = 'tipo';

$phprlang['log_filter_show'] = 'Visualizza';
$phprlang['log_filter_all'] = 'Tutti';
$phprlang['log_filter_2_months'] = 'Due mesi';
$phprlang['log_filter_1_month'] = 'Un mese';
$phprlang['log_filter_1_week'] = 'Una settimana';
$phprlang['log_filter_1_day'] = 'Un giorno';

// cancellation
$phprlang['log_cancel_message'] = '[ELIMINAZIONE DA PARTE DELL\'UTENTE]';

// hack
$phprlang['log_hack_header'] = 'Rilevato tentativo di hacking';
$phprlang['log_hack_message'] = 'E\' stato rilevato un tentativo di hacking con le seguenti caratteristiche<br><br>
							<strong>Tipo di hack:</strong> %s<br>
							<strong>Data/ora:</strong> %s<br>
							<strong>Indirizzo IP:</strong> %s<br><br>
							Il tentativo è stato notificato agli Amministratori, che prenderanno i provvedimenti del caso.';
							
// headers
$phprlang['log_header'] = 'Log';
$phprlang['log_create_header'] = 'Log degli inserimenti';
$phprlang['log_delete_header'] = 'Log delle eliminazioni';
$phprlang['log_hack_header'] = 'Log dei tentativi di hacking';
$phprlang['log_raid_header'] = 'Log delle attività Raid';
$phprlang['log_sort_header'] = 'Filtri di visualizzazione';
							
// output text
$phprlang['log_create'] = '%s - %s: l\'Utente [<a href="users.php?mode=details&user_id=%s">%s</a> (%s)] ha creato [%s] con id [%s] e nome [%s]';
$phprlang['log_delete'] = '%s - %s: l\'Utente [<a href="users.php?mode=details&user_id=%s">%s</a> (%s)] ha eliminato [%s] con nome [%s]';
$phprlang['log_hack'] = '%s - %s: l\'Utente con IP [%s] ha tentato un hack [%s]';
$phprlang['log_raid'] = '%s - %s: l\'Utente [<a href="users.php?mode=details&user_id=%s">%s</a> (%s)] ha alterato il Raid <a href="view.php?mode=view&raid_id=%s">%s %s</a>: [%s] del Personaggio %s - %s';
?>