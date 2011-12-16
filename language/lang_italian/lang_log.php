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

if (empty($phprlang) || !is_array($phprlang))
	$phprlang = array();
	
$phprlang = array_merge($phprlang, array(

// form variables
'log_create_text' =>  'Inserimenti',
'log_date' =>  'data',
'log_delete_text' =>  'Eliminazioni',
'log_hack_text' =>  'Tentativi di hacking',
'log_id' =>  'id',
'log_in' =>  ' in ordine ',
'log_order' =>  ' e visualizza',
'log_raid_text' =>  'Attività Raid',
'log_sort_by' =>  'Ordina per ',
'log_type' =>  'tipo',

'log_filter_show' =>  'Visualizza',
'log_filter_all' =>  'Tutti',
'log_filter_2_months' =>  'Due mesi',
'log_filter_1_month' =>  'Un mese',
'log_filter_1_week' =>  'Una settimana',
'log_filter_1_day' =>  'Un giorno',

// cancellation
'log_cancel_message' =>  '[ELIMINAZIONE DA PARTE DELL\'UTENTE]',

// hack
'log_hack_header' =>  'Rilevato tentativo di hacking',
'log_hack_message' =>  'E\' stato rilevato un tentativo di hacking con le seguenti caratteristiche<br><br>
							<strong>Tipo di hack:</strong> %s<br>
							<strong>Data/ora:</strong> %s<br>
							<strong>Indirizzo IP:</strong> %s<br><br>
							Il tentativo è stato notificato agli Amministratori, che prenderanno i provvedimenti del caso.',
							
// headers
'log_header' =>  'Log',
'log_create_header' =>  'Log degli inserimenti',
'log_delete_header' =>  'Log delle eliminazioni',
'log_hack_header' =>  'Log dei tentativi di hacking',
'log_raid_header' =>  'Log delle attività Raid',
'log_sort_header' =>  'Filtri di visualizzazione',
							
// output text
'log_create' =>  '%s - %s: l\'Utente [<a href="users.php?mode=details&amp;user_id=%s">%s</a> (%s)] ha creato [%s] con id [%s] e nome [%s]',
'log_delete' =>  '%s - %s: l\'Utente [<a href="users.php?mode=details&amp;user_id=%s">%s</a> (%s)] ha eliminato [%s] con nome [%s]',
'log_hack' =>  '%s - %s: l\'Utente con IP [%s] ha tentato un hack [%s]',
'log_raid' =>  '%s - %s: l\'Utente [<a href="users.php?mode=details&amp;user_id=%s">%s</a> (%s)] ha alterato il Raid <a href="view.php?mode=view&amp;raid_id=%s">%s %s</a>: [%s] del Personaggio %s - %s',
));  ?>