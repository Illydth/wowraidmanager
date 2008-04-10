<?php
/***************************************************************************
*                           functions_logging.php
*                           ---------------------
*   begin                : Monday, May 22, 2006
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
function log_create($type, $create_id, $create_name)
{
	global $db_raid, $phprlang, $phpraid_config;
	
	$profile_id = $_SESSION['profile_id'];
	
	// log IP among other information useful
	if (isset($_SERVER['HTTP_X_FORWARD_FOR'])) {
		$ip = $_SERVER['HTTP_X_FORWARD_FOR'];
	} else {
		$ip = $_SERVER['REMOTE_ADDR'];
	}
	
	$timestamp = time();
	
	$sql = sprintf("INSERT INTO " . $phpraid_config['db_prefix'] . "logs_create (`create_id`,`create_name`,`profile_id`,`ip`,`timestamp`,`type`)
	VALUES (%s,%s,%s,%s,%s,%s)",quote_smart($create_id),quote_smart($create_name),quote_smart($profile_id),quote_smart($ip),quote_smart($timestamp),quote_smart($type));	
	
	$db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
}

function log_delete($type, $delete_name)
{
	global $db_raid, $phprlang, $phpraid_config;
	
	$profile_id = $_SESSION['profile_id'];
	
	// log IP among other information useful
	if (isset($_SERVER['HTTP_X_FORWARD_FOR'])) {
		$ip = $_SERVER['HTTP_X_FORWARD_FOR'];
	} else {
		$ip = $_SERVER['REMOTE_ADDR'];
	}
	
	$timestamp = time();
	
	$sql = "INSERT INTO " . $phpraid_config['db_prefix'] . "logs_delete
				(`profile_id`,`delete_name`,`ip`,`timestamp`,`type`)
			VALUES
				('$profile_id','$delete_name','$ip','$timestamp','$type')";
	$db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
}

function log_hack()
{
	global $db_raid, $phprlang, $phpraid_config;
	
	// it's a hacking attempt
	// log IP among other information useful
	if (isset($_SERVER['HTTP_X_FORWARD_FOR'])) {
		$ip = $_SERVER['HTTP_X_FORWARD_FOR'];
	} else {
		$ip = $_SERVER['REMOTE_ADDR'];
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
	$db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
	
	// print error out
	echo '<html><link rel="stylesheet" type="text/css" href="templates/'.$phpraid_config['template'].'/style/stylesheet.css"><body>';
	echo '<div align="center"><div class="errorHeader" style="width:600px">'.$phprlang['log_hack_header'] .'</div>';
	echo '<div class="errorBody" style="width:600px">'.sprintf($phprlang['log_hack_message'], $full_page, $time, $ip).'</div></div>';
	echo '</body></html>';
	
	die();
}

function log_raid($char_id, $raid_id, $type)
{
	global $db_raid, $phprlang, $phpraid_config;
	
	$profile_id = $_SESSION['profile_id'];
	
	// log IP among other information useful
	if (isset($_SERVER['HTTP_X_FORWARD_FOR'])) {
		$ip = $_SERVER['HTTP_X_FORWARD_FOR'];
	} else {
		$ip = $_SERVER['REMOTE_ADDR'];
	}
	
	$timestamp = time();
	
	$sql = "INSERT INTO " . $phpraid_config['db_prefix'] . "logs_raid
				(`char_id`,`profile_id`,`raid_id`,`ip`,`timestamp`,`type`)
			VALUES
				('$char_id','$profile_id','$raid_id','$ip','$timestamp','$type')";
	$db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
}
?>