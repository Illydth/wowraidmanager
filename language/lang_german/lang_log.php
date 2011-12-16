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
'log_create_text' =>  'Erstellungen',
'log_date' =>  'Datum',
'log_delete_text' =>  'Löschungen',
'log_hack_text' =>  'Hack-Versuche',
'log_id' =>  'ID',
'log_in' =>  ' in ',
'log_order' =>  ' Reihenfolge und zeige',
'log_raid_text' =>  'Raidaktivitäten',
'log_sort_by' =>  'Sortiere nach ',
'log_type' =>  'Typ',

'log_filter_show' =>  'Zeige',
'log_filter_all' =>  'alles',
'log_filter_2_months' =>  'letzten beiden Monate',
'log_filter_1_month' =>  'letzten Monat',
'log_filter_1_week' =>  'letzte Woche',
'log_filter_1_day' =>  'letzten Tag',

// cancellation
// unused ... 'log_cancel_message' =>  '[USER CANCEL]',

// hack
'log_hack_header' =>  'Hack-Versuch erkannt',			// will not be used as declared again below
'log_hack_message' =>  'Ein Hack-Versuch wurde erkannt und mit folgenden Details protokolliert:<br><br>
							<strong>Versuchter Hack:</strong> %s<br>
							<strong>Datum/Uhrzeit:</strong> %s<br>
							<strong>Benutzer-IP:</strong> %s<br><br>
							Ein Administrator wurdebenachrichtigt, das kann zu einem Bann führen.',
							
// headers
'log_header' =>  'Protokoll',
'log_create_header' =>  'Protokoll der Erstellungen',
'log_delete_header' =>  'Protokoll der Löschungen',
'log_hack_header' =>  'Protokoll der Hack-Versuche',
'log_raid_header' =>  'Protokoll der Raidaktivitäten',
'log_sort_header' =>  'Filteroptionen',
							
// output text
'log_create' =>  '%s - %s: Benutzer [<a href="users.php?mode=details&amp;user_id=%s">%s</a> (%s)] ERZEUGTE %s mit ID [%s] und NAME [%s]',
'log_delete' =>  '%s - %s: Benutzer [<a href="users.php?mode=details&amp;user_id=%s">%s</a> (%s)] LÖSCHTE %s mit NAME [%s]',
'log_hack' =>  '%s - %s: Benutzer mit IP [%s] VERSUCHTE einen HACK mit[%s]',
'log_raid' =>  '%s - %s: Benutzer [<a href="users.php?mode=details&amp;user_id=%s">%s</a> (%s)] änderte RAID <a href="view.php?mode=view&amp;raid_id=%s">%s %s</a> nach %s mit CHARAKTER %s - %s',
));  ?>