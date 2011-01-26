<?php
/***************************************************************************
*                             functions_date.php
*                            --------------------
*   begin                : Saturday, Jun 03, 2006
*   copyright            : (C) 2007-2008 Douglas Wagner
*   email                : douglasw@wagnerweb.org
*
*   $Id: functions_date.php,v 2.00 2008/03/03 14:46:45 psotfx Exp $
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

function new_date($format, $timestamp, $tz) {
	$offset = (60 * 60) * ($tz / 100); // Seconds from GMT
    $timestamp = $timestamp + $offset;
    return gmdate($format, $timestamp);
}

function new_mktime($hr,$mi,$se,$mo,$dy,$yr,$tz) {
    $timestamp = gmmktime($hr,$mi,$se,$mo,$dy,$yr);
    $offset = (60 * 60) * ($tz / 100); // Seconds from GMT
    $timestamp = $timestamp - $offset;
	return $timestamp;
}

function set_date($stamp)
{
	global $phpraid_config;
	return new_date($phpraid_config['date_format'],$stamp,$phpraid_config['timezone'] + $phpraid_config['dst']);
}

function set_time($stamp)
{
	global $phpraid_config;
	return new_date($phpraid_config['time_format'],$stamp,$phpraid_config['timezone'] + $phpraid_config['dst']);
}
function get_date($stamp)
{
	global $phpraid_config;
	return new_date($phpraid_config['date_format'],$stamp,$phpraid_config['timezone'] + $phpraid_config['dst']);
}
function get_time($stamp)
{
	global $phpraid_config;
	return new_date($phpraid_config['time_format'],$stamp,$phpraid_config['timezone'] + $phpraid_config['dst']);
}
function get_time_full($stamp)
{
	global $phpraid_config;
	return (new_date($phpraid_config['date_format'] . ' - ' . $phpraid_config['time_format'] , $stamp,$phpraid_config['timezone'] + $phpraid_config['dst']));
}
?>