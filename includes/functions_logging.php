<?php
/***************************************************************************
*                           functions_logging.php
*                           ---------------------
*   begin                : Monday, May 22, 2006
*   copyright            : (C) 2007-2008 Douglas Wagner
*   email                : douglasw@wagnerweb.org
*
*   $Id: functions_logging.php,v 2.00 2008/03/03 14:49:45 psotfx Exp $
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

function log_create($type, $create_id, $create_name)
{
	global $db_raid, $phprlang, $phpraid_config;
	
	$profile_id = scrub_input($_SESSION['profile_id']);
	
	// log IP among other information useful
	if (isset($_SERVER['HTTP_X_FORWARD_FOR'])) {
		$ip = scrub_input($_SERVER['HTTP_X_FORWARD_FOR']);
	} else {
		$ip = scrub_input($_SERVER['REMOTE_ADDR']);
	}
	
	$timestamp = time();
	
	$sql = sprintf("INSERT INTO " . $phpraid_config['db_prefix'] . "logs_create (`create_id`,`create_name`,`profile_id`,`ip`,`timestamp`,`type`)
	VALUES (%s,%s,%s,%s,%s,%s)",quote_smart($create_id),quote_smart($create_name),quote_smart($profile_id),quote_smart($ip),quote_smart($timestamp),quote_smart($type));	
	
	$db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
}

function log_delete($type, $delete_name)
{
	global $db_raid, $phprlang, $phpraid_config;
	
	$profile_id = $_SESSION['profile_id'];
	
	// log IP among other information useful
	if (isset($_SERVER['HTTP_X_FORWARD_FOR'])) {
		$ip = scrub_input($_SERVER['HTTP_X_FORWARD_FOR']);
	} else {
		$ip = scrub_input($_SERVER['REMOTE_ADDR']);
	}
	
	$timestamp = time();
	
	$sql = sprintf("INSERT INTO " . $phpraid_config['db_prefix'] . "logs_delete
				(`profile_id`,`delete_name`,`ip`,`timestamp`,`type`)
			VALUES
				(%s,%s,%s,%s,%s)",quote_smart($profile_id),quote_smart($delete_name),quote_smart($ip),quote_smart($timestamp),quote_smart($type));
	$db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
}

function log_hack()
{
	global $db_raid, $phprlang, $phpraid_config;
	
	// it's a hacking attempt
	// log IP among other information useful
	if (isset($_SERVER['HTTP_X_FORWARD_FOR'])) {
		$ip = scrub_input($_SERVER['HTTP_X_FORWARD_FOR']);
	} else {
		$ip = scrub_input($_SERVER['REMOTE_ADDR']);
	}
		
	$page = basename($_SERVER['PHP_SELF']);
	
	foreach($_GET as $key=>$value)
	{
		$arguments .= $key . '=' . $value . '&';
	}
	
	$full_page = $page . '?' . substr($arguments,0,strlen($arguments)-1);
	$timestamp = time();
	$time = new_date($phpraid_config['date_format'] . ' @ ' . $phpraid_config['time_format'], $timestamp, $phpraid_config['timezone'] + $phpraid_config['dst']);
	
	$sql = sprintf("INSERT INTO " . $phpraid_config['db_prefix'] . "logs_hack (`ip`, `message`, `timestamp`) 
		VALUES	(%s,%s,%s)",quote_smart($ip),quote_smart($full_page),quote_smart($timestamp));
	$db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	
	// print error out
	echo '<html><link rel="stylesheet" type="text/css" href="templates/'.$phpraid_config['template'].'/style/stylesheet.css"><body>';
	echo '<div align="center"><div class="errorHeader" style="width:600px">'.$phprlang['log_hack_header'] .'</div>';
	echo '<div class="errorBody" style="width:600px">'.sprintf($phprlang['log_hack_message'], $full_page, $time, $ip).'</div>';
	echo '</body></html>';
	
	die();
}

function log_raid($char_id, $raid_id, $type)
{
	global $db_raid, $phprlang, $phpraid_config;
	
	$profile_id = $_SESSION['profile_id'];
	
	// log IP among other information useful
	if (isset($_SERVER['HTTP_X_FORWARD_FOR'])) {
		$ip = scrub_input($_SERVER['HTTP_X_FORWARD_FOR']);
	} else {
		$ip = scrub_input($_SERVER['REMOTE_ADDR']);
	}
	
	$timestamp = time();
	
	$sql = sprintf("INSERT INTO " . $phpraid_config['db_prefix'] . "logs_raid
				(`char_id`,`profile_id`,`raid_id`,`ip`,`timestamp`,`type`)
			VALUES
				(%s,%s,%s,%s,%s,%s)", quote_smart($char_id), quote_smart($profile_id), quote_smart($raid_id), quote_smart($ip), quote_smart($timestamp), quote_smart($type));
	$db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
}
?>