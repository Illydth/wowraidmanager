<?php
/***************************************************************************
*                               functions.php
*                            -------------------
*   begin                : Saturday, Jun 03, 2006
*   copyright            : (C) 2005 Kyle Spraggs
*   email                : spiffyjr@gmail.com
*
*   $Id: mysql.php,v 1.16 2002/03/19 01:07:36 psotfx Exp $
*
***************************************************************************/

/***************************************************************************
*
*   This program is free software; you can redistribute it and/or modify
*   it under the terms of the GNU General Public License as published by
*   the Free Software Foundation; either version 2 of the License, or
*   (at your option) any later version.
*
***************************************************************************/

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
?>