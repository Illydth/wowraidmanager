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
$phprlang['log_create_text'] = 'creations';
$phprlang['log_date'] = 'date';
$phprlang['log_delete_text'] = 'deletions';
$phprlang['log_hack_text'] = 'hack attempts';
$phprlang['log_id'] = 'id';
$phprlang['log_in'] = ' in ';
$phprlang['log_order'] = ' order and show';
$phprlang['log_raid_text'] = 'raid activity';
$phprlang['log_sort_by'] = 'Sort by ';
$phprlang['log_type'] = 'type';

$phprlang['log_filter_show'] = 'Show';
$phprlang['log_filter_all'] = 'All';
$phprlang['log_filter_2_months'] = 'Two Months';
$phprlang['log_filter_1_month'] = 'One Month';
$phprlang['log_filter_1_week'] = 'One Week';
$phprlang['log_filter_1_day'] = 'One Day';

// cancellation
$phprlang['log_cancel_message'] = '[USER CANCEL]';

// hack
$phprlang['log_hack_header'] = 'Hacking attempt detected';
$phprlang['log_hack_message'] = 'A hacking attempt has been detected and is logged with the following details<br><br>
							<strong>Attempted Hack:</strong> %s<br>
							<strong>Date/Time:</strong> %s<br>
							<strong>User IP:</strong> %s<br><br>
							An administrator has been notified and may result in a ban.';
							
// headers
$phprlang['log_header'] = 'Log Output';
$phprlang['log_create_header'] = 'Creation Logs';
$phprlang['log_delete_header'] = 'Deletion Logs';
$phprlang['log_hack_header'] = 'Hack Logs';
$phprlang['log_raid_header'] = 'Raid Activity Logs';
$phprlang['log_sort_header'] = 'Choose filter options';
							
// output text
$phprlang['log_create'] = '%s - %s: User [<a href="users.php?mode=details&amp;user_id=%s">%s</a> (%s)] CREATED %s with ID [%s] and NAME [%s]';
$phprlang['log_delete'] = '%s - %s: User [<a href="users.php?mode=details&amp;user_id=%s">%s</a> (%s)] DELETED %s with NAME [%s]';
$phprlang['log_hack'] = '%s - %s: User with IP [%s] ATTEMPTED hack with [%s]';
$phprlang['log_raid'] = '%s - %s: User [<a href="users.php?mode=details&amp;user_id=%s">%s</a> (%s)] altered RAID <a href="raid_view.php?mode=view&amp;raid_id=%s">%s %s</a> BY %s with CHARACTER %s - %s';
?>