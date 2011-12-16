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
'log_create_text' =>  'creations',
'log_date' =>  'date',
'log_delete_text' =>  'deletions',
'log_hack_text' =>  'hack forsøk',
'log_id' =>  'id',
'log_in' =>  ' i ',
'log_order' =>  ' sorter og vis',
'log_raid_text' =>  'raid aktivitet',
'log_sort_by' =>  'Sorter etter ',
'log_type' =>  'type',

'log_filter_show' =>  'Vis',
'log_filter_all' =>  'Alle',
'log_filter_2_months' =>  'To måneder',
'log_filter_1_month' =>  'En måned',
'log_filter_1_week' =>  'En uke',
'log_filter_1_day' =>  'En dag',

// cancellation
'log_cancel_message' =>  '[BRUKER KANSELLERT]',

// hack
'log_hack_header' =>  'Hacking forsøk funnet',
'log_hack_message' =>  'Hacking forsøk funnet med følgende detaljer<br><br>
							<strong>Forsøkt hacket:</strong> %s<br>
							<strong>Dato/Tid:</strong> %s<br>
							<strong>Bruker IP:</strong> %s<br><br>
							En Administrator har blitt informert, og dette kan resulteres i en ban',
							
// headers
'log_header' =>  'Logg utmating',
'log_create_header' =>  'Opprettelseslogg',
'log_delete_header' =>  'Slettingslogg',
'log_hack_header' =>  'Hack Logg',
'log_raid_header' =>  'Raid Aktivitetslogg',
'log_sort_header' =>  'Velg filter',
							
// output text
'log_create' =>  '%s - %s: Bruker [<a href="users.php?mode=details&amp;user_id=%s">%s</a> (%s)] LAGET %s med ID [%s] og NAVN [%s]',
'log_delete' =>  '%s - %s: Bruker [<a href="users.php?mode=details&amp;user_id=%s">%s</a> (%s)] SLETTET %s med NAVN [%s]',
'log_hack' =>  '%s - %s: Bruker med IP [%s] FORSØKTE å hacke med [%s]',
'log_raid' =>  '%s - %s: Bruker [<a href="users.php?mode=details&amp;user_id=%s">%s</a> (%s)] endret RAID <a href="view.php?mode=view&amp;raid_id=%s">%s %s</a> AV %s med CHARACTER %s - %s',
));  ?>