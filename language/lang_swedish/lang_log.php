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
$phprlang['log_create_text'] = 'skapade';
$phprlang['log_date'] = 'datum';
$phprlang['log_delete_text'] = 'raderade';
$phprlang['log_hack_text'] = 'intrångsförsök';
$phprlang['log_id'] = 'id';
$phprlang['log_in'] = ' i ';
$phprlang['log_order'] = ' sortera och visa';
$phprlang['log_raid_text'] = 'raid aktivitet';
$phprlang['log_sort_by'] = 'Sortera efter ';
$phprlang['log_type'] = 'typ';

$phprlang['log_filter_show'] = 'Visa';
$phprlang['log_filter_all'] = 'Alla';
$phprlang['log_filter_2_months'] = 'Två månader';
$phprlang['log_filter_1_month'] = 'En månad';
$phprlang['log_filter_1_week'] = 'En vecka';
$phprlang['log_filter_1_day'] = 'En dag';

// cancellation
$phprlang['log_cancel_message'] = '[ANVÄNDARE ANNULLERA]';

// hack
$phprlang['log_hack_header'] = 'Intrångsförsök upptäckt';
$phprlang['log_hack_message'] = 'Ett intrångsförsök har upptäckts och sparats med följande detaljer<br><br>
							<strong>Försök till intrång:</strong> %s<br>
							<strong>Datum/Tid:</strong> %s<br>
							<strong>Användar IP:</strong> %s<br><br>
							En administratör har meddelats, och detta kan resultera i en bannlysning.';
							
// headers
$phprlang['log_header'] = 'Logg utskrift';
$phprlang['log_create_header'] = 'Skapelselogg';
$phprlang['log_delete_header'] = 'Borttagingslogg';
$phprlang['log_hack_header'] = 'Intrångsförsöksloggar';
$phprlang['log_raid_header'] = 'Raid aktivitets logg';
$phprlang['log_sort_header'] = 'Välj filter val';
							
// output text
$phprlang['log_create'] = '%s - %s: Användare [<a href="users.php?mode=details&user_id=%s">%s</a> (%s)] SKAPAD %s med ID [%s] och NAME [%s]';
$phprlang['log_delete'] = '%s - %s: Användare [<a href="users.php?mode=details&user_id=%s">%s</a> (%s)] RADERAD %s med NAME [%s]';
$phprlang['log_hack'] = '%s - %s: Användare med IP [%s] FÖRSÖKTE göra intrång med [%s]';
$phprlang['log_raid'] = '%s - %s: Användare [<a href="users.php?mode=details&user_id=%s">%s</a> (%s)] ändrade i RAID <a href="view.php?mode=view&raid_id=%s">%s %s</a> AV %s med KARAKTÄR %s - %s';
?>