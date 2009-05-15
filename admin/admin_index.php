<?php
/***************************************************************************
                                admin_index.php
 *                            -------------------
 *   begin                : Monday, May 11, 2009
 *   copyright            : (C) 2007-2009 Douglas Wagner
 *   email                : douglasw@wagnerweb.org
 *
 ***************************************************************************/

/***************************************************************************
*
*    WoW Raid Manager - Raid Management Software for World of Warcraft
*    Copyright (C) 2007-2009 Douglas Wagner
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

// commons
define("IN_PHPRAID", true);	
require_once('./admin_common.php');

/*************************************************
 * Access Authorization Section
 *************************************************/
// page authentication
define("PAGE_LVL","configuration");
require_once("../includes/authentication.php");	

/* 
 * Data for Index Page
 */
// Version Check
// primarily stripped from phpBB version checking
$current_version_array = explode('.', $version);
$major_version = (int) $current_version_array[0];
$minor_version = (int) $current_version_array[1];
$patch_version = (int) $current_version_array[2];
$sub_major_version = (int) $current_version_array[3];
$sub_minor_version = (int) $current_version_array[4];
$sub_patch_version = (int) $current_version_array[5];
$current_version = (int) $current_version_array[0] . '.' . (int) $current_version_array[1] . '.' . (int) $current_version_array[2] . ':' . (int) $current_version_array[3] . '.' . (int) $current_version_array[4] . '.' . (int) $current_version_array[5];

$errno = 0;
$errstr = $version_info = '';

if ($fsock = @fsockopen('www.wowraidmanager.net', 80, $errno, $errstr, 10))
{
	@fputs($fsock, "GET /vercheck/ver_check_40.txt HTTP/1.1\r\n");
	@fputs($fsock, "HOST: www.wowraidmanager.net\r\n");
	@fputs($fsock, "Connection: close\r\n\r\n");

	$get_info = false;
	while (!@feof($fsock))
	{
		if ($get_info)
		{
			$version_info .= @fread($fsock, 1024);
		}
		else
		{
			if (@fgets($fsock, 1024) == "\r\n")
			{
				$get_info = true;
			}
		}
	}
	@fclose($fsock);
	$version_info = explode("\n", $version_info);
	$latest_major_version = (int) $version_info[0];
	$latest_minor_version = (int) $version_info[1];
	$latest_patch_revision = (int) $version_info[2];
	$latest_sub_major_version = (int) $version_info[4];
	$latest_sub_minor_version = (int) $version_info[5];
	$latest_sub_patch_version = (int) $version_info[6];
	$latest_version = (int) $version_info[0] . '.' . (int) $version_info[1] . '.' . (int) $version_info[2] . ':' . (int) $version_info[4] . '.' . (int) $version_info[5] . '.' . (int) $version_info[6];

	if ($current_version == $latest_version)
	{
		$version_info = '<p style="color:green">' . $phprlang['configuration_version_current'] . '</p>';
	}
	else
	{
		$version_info = '<br><div class="errorHeader">' . $phprlang['configuration_version_outdated_header'] . '</div>';
		$version_info .= '<div class="errorBody">' . sprintf($phprlang['configuration_version_outdated_message'], $latest_version, $current_version) . '</div><br>';
	}
}
else
{
	if ($errstr)
	{
		$version_info = '<p style="color:red">' . sprintf($phprlang['connect_socket_error'], $errstr) . '</p>';
	}
	else
	{
		$version_info = '<p style="color:red">' . $phprlang['socket_functions_disabled'] . '</p>';
	}
}

// WRM Database Version
$sql = "SELECT max(version_number) as db_ver FROM " . $phpraid_config['db_prefix'] . "version";
$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
$data = $db_raid->sql_fetchrow($result, true);
$wrm_db_version = $data['db_ver'];

$wrmadminsmarty->assign('version_data',
	array(
		'version_info_header'=>$phprlang['configuration_version_info_header'],
		'version_info' => $version_info,
		'version' => $version,
		'wrm_db_version' => $wrm_db_version, 
	)
);

// MySQL Version
$sql = "SELECT version() as ver";
$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
$data = $db_raid->sql_fetchrow($result, true);
$mysql_version = $data['ver'];

// MySQL Database Size
$dbsize = 0;
$sql = "SHOW TABLE STATUS WHERE name LIKE '". $phpraid_config['db_prefix'] . "%'";
$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
while($data = $db_raid->sql_fetchrow($result, true)) 
{  
	$dbsize += $data[ "Data_length" ] + $data[ "Index_length" ];
}
$dbsize = round($dbsize / 1024, 2); //(Kilobytes)

// Number of Users
$sql = "SELECT count(*) as count FROM " . $phpraid_config['db_prefix'] . "profile";
$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
$data = $db_raid->sql_fetchrow($result, true);
$user_count = $data['count'];

// Active Users in the Last 5 Minutes
$minus5_time = time() - (5 * 60); // Current Time - 5 minutes.
$logged_in = array();

$sql = "SELECT a.username as username, a.email as email, a.last_login_time as last_login_time, b.name as perm_name
		FROM " . $phpraid_config['db_prefix'] . "profile a, " . $phpraid_config['db_prefix'] . "permissions b
		WHERE a.priv = b.permission_id"; 
$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
while($data = $db_raid->sql_fetchrow($result, true))
{
	if ($data['last_login_time'] >= $minus5_time)
	{
		// User's logged on in the last 5 mins.
		array_push($logged_in,
			array
			(
				'username'=>$data['username'],
				'email'=>$data['email'],
				'priv'=>$data['perm_name'],
				'login_time'=>date($phpraid_config['date_format']." ".$phpraid_config['time_format'],$data['last_login_time']),
			)
		);		
	}
}

$wrmadminsmarty->assign('recent_logins_header', 
		array
		(
			'header' => $phprlang['recent_logins_header'],
			'username_header' => $phprlang['logins_username_header'],
			'email_header' => $phprlang['logins_email_header'],
			'priv_header' => $phprlang['logins_priv_header'],
			'login_time_header' => $phprlang['logins_time_header'],
		)
);

$wrmadminsmarty->assign('recent_logins', $logged_in);

// Inactive Users (30 Days)
$minus30d_time = time() - (30 * 24 * 60 * 60); // Current Time - 30 days.
$logged_in = array();

$sql = "SELECT a.username as username, a.email as email, a.last_login_time as last_login_time, b.name as perm_name
		FROM " . $phpraid_config['db_prefix'] . "profile a, " . $phpraid_config['db_prefix'] . "permissions b
		WHERE a.priv = b.permission_id"; 
$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
while($data = $db_raid->sql_fetchrow($result, true))
{
	if ($data['last_login_time'] <= $minus30d_time || $data['last_login_time']=='')
	{
		if ($data['last_login_time']=='')
		{
			//User hasn't logged in since somewhere in the WRM 3.5 Days, set them inactive.
			$data['last_login_time'] = 0;
		}
		// Users not logged on for the last 30 days.
		array_push($logged_in,
			array
			(
				'username'=>$data['username'],
				'email'=>$data['email'],
				'priv'=>$data['perm_name'],
				'login_time'=>date($phpraid_config['date_format']." ".$phpraid_config['time_format'],$data['last_login_time']),
			)
		);		
	}
}

$wrmadminsmarty->assign('inactive_logins_header', 
		array
		(
			'header' => $phprlang['inactive_logins_header'],
			'username_header' => $phprlang['logins_username_header'],
			'email_header' => $phprlang['logins_email_header'],
			'priv_header' => $phprlang['logins_priv_header'],
			'login_time_header' => $phprlang['logins_time_header'],
		)
);

$wrmadminsmarty->assign('inactive_logins', $logged_in);

// Raid Statistics
// Number of Active Raids
// Total Number of Raids
// Average Attendance Percentage (Week)
// Average Attendance Percentage (30 days)
// Average Attendance Percentage (3 Months)
// Average Attendance Percentage (6 Months)
// Average Attendance Percentage (Year)
// Average Attendance Percentage (All)

// Most Recent Log Entries

// Actions
// Purge Board Cache
// Purge Armory Cache
// Purge Inactive Users

$wrmadminsmarty->assign('general_page_data',
	array(
		'statistics_header'=>$phprlang['admin_statistics_header'],
		'statistic_text'=>$phprlang['statistic'],
		'wrm_statistics_text' =>  $phprlang['wrm_statistics_header'],
		'database_statistics_text' => $phprlang['database_statistics_header'],
		'value_text'=>$phprlang['value'],
		'wrm_version_text' => $phprlang['admin_version_stat_text'],
		'wrm_db_name_text' => $phprlang['db_name_text'],
		'database_name' => $phpraid_config['db_name'],
		'wrm_db_host_text' => $phprlang['db_host_text'],
		'database_host' => $phpraid_config['db_host'],
		'wrm_db_user_text' => $phprlang['db_user_text'],
		'database_user' => $phpraid_config['db_user'],
		'wrm_tbl_prefix_text' => $phprlang['db_prefix_text'],
		'table_prefix' => $phpraid_config['db_prefix'],
		'php_version_text' => $phprlang['php_version_text'],
		'php_version' => PHP_VERSION,
		'mysql_version_text' => $phprlang['mysql_version_text'],
		'mysql_version' => $mysql_version,
		'mysql_database_size_text' => $phprlang['db_size_text'],
		'mysql_database_size' => $dbsize . ' ' . $phprlang['kib'],
		'user_count_text' => $phprlang['user_count_text'],
		'user_count' => $user_count,
		'wrm_db_version_text' => $phprlang['wrm_db_ver_text'],
	)
);


//
// Start output of the page.
//
require_once('./includes/admin_page_header.php');
$wrmadminsmarty->display('admin_main_page.html');
require_once('./includes/admin_page_footer.php');

?>