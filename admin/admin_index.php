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

/*************************************************
 * 		CACHE ACTIONS SECTION
 *************************************************/
if($_GET['mode'] == 'purge_board_cache') 
{
	// Purge Board Cache
	$dir = "../cache/smarty_cache";
	if (is_dir($dir))
		unlinkRecursive($dir, FALSE);
	header("Location: admin_index.php");
}	
elseif($_GET['mode'] == 'purge_template_cache') 
{
	// Purge Board Cache
	$dir = "../cache/templates_c";
	if (is_dir($dir))
		unlinkRecursive($dir, FALSE);
	header("Location: admin_index.php");
}	
elseif($_GET['mode'] == 'purge_armory_cache')	
{
	// Purge Armory Cache
	if ($phpraid_config['armory_cache_setting']=='database')
	{
		//purge database table
		$sql = "DELETE FROM " . $phpraid_config['db_prefix'] . "armory_cache"; 
		$db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	}
	elseif ($phpraid_config['armory_cache_setting']=='file')
	{
		//purge from filesystem
		$dir = "../cache/armory_cache";
		unlinkRecursive($dir, FALSE);
	}
	else
	{
		continue; // Do nothing if no cache is selected.
	}
	header("Location: admin_index.php");
}
elseif($_GET['mode'] == 'purge_armory_logs')
{
	// Purge Armory Logs
	$dir = "../cache/armory_log";
	if (is_dir($dir))
		unlinkRecursive($dir, FALSE);
	header("Location: admin_index.php");
}
else
{
	/* 
	 * Data for Index Page
	 */
	
	//@@ REMOVE THIS
	// Set the Starting Day on the Calendar.
	$startDay = 'Sunday';
	if ($startDay = 'Sunday')
		$dayOffset = 0;
	else
		$dayOffset = 1;
	
	/*************************************************
	 * 			WRM STATISTICS SECTION
	 *************************************************/
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
	$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
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
	$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	$data = $db_raid->sql_fetchrow($result, true);
	$mysql_version = $data['ver'];
	
	// Number of Users
	$sql = "SELECT count(*) as count FROM " . $phpraid_config['db_prefix'] . "profile";
	$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	$data = $db_raid->sql_fetchrow($result, true);
	$user_count = $data['count'];
	
	/*********************************************
	 * 		DATABASE STATISTICS SECTION
	 *********************************************/
	
	$dbsize = get_db_size();
	
	/*********************************************
	 * 		RAID STATISTICS SECTION
	 *********************************************/
	// Number of Active Raids
	$sql = "SELECT count(*) as count FROM " . $phpraid_config['db_prefix'] . "raids
			WHERE old = '0' AND event_type = '1'";
	$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	$data = $db_raid->sql_fetchrow($result, true);
	$active_raid_count = $data['count'];
	
	// Total Number of Raids
	$sql = "SELECT count(*) as count FROM " . $phpraid_config['db_prefix'] . "raids
			WHERE event_type = '1'";
	$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	$data = $db_raid->sql_fetchrow($result, true);
	$total_raid_count = $data['count'];
	
	// Average Attendance Percentage (Week)
	
	// Generate Week Start and End off of Current Time
	$dayOfWeek = date("w", time()) - $dayOffset;
	$firstDayOfWeek = date("U", mktime('00', '00', '00', date("n"), date("j")-$dayOfWeek, date("Y")));
	$lastDayOfWeek = date("U", mktime('23', '59', '59', date("n"), date("j")-(7-$dayOfWeek-1), date("Y")));
	
	// Get Raids within week, determine signups (Queued + Drafted / Max)
	$raid_max_count = 0;
	$raid_attend_count = 0;
	$sql = "SELECT raid_id, max FROM " . $phpraid_config['db_prefix'] . "raids
			WHERE start_time >= " . $firstDayOfWeek . " AND start_time <= " . $lastDayOfWeek . "
			AND event_type = '1'";
	$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	while($data = $db_raid->sql_fetchrow($result, true))
	{ 
		$raid_max_count += $data['max'];
		$sql = "SELECT count(*) as count FROM " . $phpraid_config['db_prefix'] . "signups
				WHERE raid_id = " . $data['raid_id'] . " AND cancel = '0'";
		$result2 = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
		$data2 = $db_raid->sql_fetchrow($result2, true);
		$raid_attend_count += $data2['count'];
	}
	
	if ($raid_max_count <= 0)
		$raid_week_attend_percent_text = "No Raids Scheduled";
	else
	{
		$raid_week_attend_percent = round(($raid_attend_count / $raid_max_count)*100, 2);
		$raid_week_attend_percent_text = $raid_week_attend_percent . "%";
	}
	
	// Average Attendance Percentage (Last 30 days)
	$minus30d_time = date("U", mktime('00', '00', '00', date("n"), date("j")-30, date("Y")));
	$current_time = date("U", mktime('23', '59', '59', date("n"), date("j"), date("Y")));
	// Get Raids within last 30 days, determine signups (Queued + Drafted / Max)
	$raid_max_count = 0;
	$raid_attend_count = 0;
	$sql = "SELECT raid_id, max FROM " . $phpraid_config['db_prefix'] . "raids
			WHERE start_time >= " . $minus30d_time . " AND start_time <= " . $current_time . "
			AND event_type = '1'";
	$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	while($data = $db_raid->sql_fetchrow($result, true))
	{ 
		$raid_max_count += $data['max'];
		$sql = "SELECT count(*) as count FROM " . $phpraid_config['db_prefix'] . "signups
				WHERE raid_id = " . $data['raid_id'] . " AND cancel = '0'";
		$result2 = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
		$data2 = $db_raid->sql_fetchrow($result2, true);
		$raid_attend_count += $data2['count'];
	}
	
	if ($raid_max_count <= 0)
		$raid_30d_attend_percent_text = "No Raids Scheduled";
	else
	{
		$raid_30d_attend_percent = round(($raid_attend_count / $raid_max_count)*100, 2);
		$raid_30d_attend_percent_text = $raid_30d_attend_percent . "%";
	}
	
	// Average Attendance Percentage (3 Months)
	$minus3m_time = date("U", mktime('00', '00', '00', date("n")-3, date("j"), date("Y")));
	$current_time = date("U", mktime('23', '59', '59', date("n"), date("j"), date("Y")));
	// Get Raids within last 3 months, determine signups (Queued + Drafted / Max)
	$raid_max_count = 0;
	$raid_attend_count = 0;
	$sql = "SELECT raid_id, max FROM " . $phpraid_config['db_prefix'] . "raids
			WHERE start_time >= " . $minus3m_time . " AND start_time <= " . $current_time . "
			AND event_type = '1'";
	$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	while($data = $db_raid->sql_fetchrow($result, true))
	{ 
		$raid_max_count += $data['max'];
		$sql = "SELECT count(*) as count FROM " . $phpraid_config['db_prefix'] . "signups
				WHERE raid_id = " . $data['raid_id'] . " AND cancel = '0'";
		$result2 = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
		$data2 = $db_raid->sql_fetchrow($result2, true);
		$raid_attend_count += $data2['count'];
	}
	
	if ($raid_max_count <= 0)
		$raid_3m_attend_percent_text = "No Raids Scheduled";
	else
	{
		$raid_3m_attend_percent = round(($raid_attend_count / $raid_max_count)*100, 2);
		$raid_3m_attend_percent_text = $raid_3m_attend_percent . "%";
	}
	
	// Average Attendance Percentage (6 Months)
	$minus6m_time = date("U", mktime('00', '00', '00', date("n")-6, date("j"), date("Y")));
	$current_time = date("U", mktime('23', '59', '59', date("n"), date("j"), date("Y")));
	// Get Raids within last 3 months, determine signups (Queued + Drafted / Max)
	$raid_max_count = 0;
	$raid_attend_count = 0;
	$sql = "SELECT raid_id, max FROM " . $phpraid_config['db_prefix'] . "raids
			WHERE start_time >= " . $minus6m_time . " AND start_time <= " . $current_time . "
			AND event_type = '1'";
	$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	while($data = $db_raid->sql_fetchrow($result, true))
	{ 
		$raid_max_count += $data['max'];
		$sql = "SELECT count(*) as count FROM " . $phpraid_config['db_prefix'] . "signups
				WHERE raid_id = " . $data['raid_id'] . " AND cancel = '0'";
		$result2 = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
		$data2 = $db_raid->sql_fetchrow($result2, true);
		$raid_attend_count += $data2['count'];
	}
	
	if ($raid_max_count <= 0)
		$raid_6m_attend_percent_text = "No Raids Scheduled";
	else
	{
		$raid_6m_attend_percent = round(($raid_attend_count / $raid_max_count)*100, 2);
		$raid_6m_attend_percent_text = $raid_6m_attend_percent . "%";
	}
	
	// Average Attendance Percentage (Year)
	$minus1y_time = date("U", mktime('00', '00', '00', date("n"), date("j"), date("Y")-1));
	$current_time = date("U", mktime('23', '59', '59', date("n"), date("j"), date("Y")));
	// Get Raids within last 3 months, determine signups (Queued + Drafted / Max)
	$raid_max_count = 0;
	$raid_attend_count = 0;
	$sql = "SELECT raid_id, max FROM " . $phpraid_config['db_prefix'] . "raids
			WHERE start_time >= " . $minus1y_time . " AND start_time <= " . $current_time . "
			AND event_type = '1'";
	$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	while($data = $db_raid->sql_fetchrow($result, true))
	{ 
		$raid_max_count += $data['max'];
		$sql = "SELECT count(*) as count FROM " . $phpraid_config['db_prefix'] . "signups
				WHERE raid_id = " . $data['raid_id'] . " AND cancel = '0'";
		$result2 = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
		$data2 = $db_raid->sql_fetchrow($result2, true);
		$raid_attend_count += $data2['count'];
	}
	
	if ($raid_max_count <= 0)
		$raid_1y_attend_percent_text = "No Raids Scheduled";
	else
	{
		$raid_1y_attend_percent = round(($raid_attend_count / $raid_max_count)*100, 2);
		$raid_1y_attend_percent_text = $raid_1y_attend_percent . "%";
	}
	
	// Average Attendance Percentage (All)
	$raid_max_count = 0;
	$raid_attend_count = 0;
	$sql = "SELECT raid_id, max FROM " . $phpraid_config['db_prefix'] . "raids
			WHERE event_type = '1'";
	$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	while($data = $db_raid->sql_fetchrow($result, true))
	{ 
		$raid_max_count += $data['max'];
		$sql = "SELECT count(*) as count FROM " . $phpraid_config['db_prefix'] . "signups
				WHERE raid_id = " . $data['raid_id'] . " AND cancel = '0'";
		$result2 = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
		$data2 = $db_raid->sql_fetchrow($result2, true);
		$raid_attend_count += $data2['count'];
	}
	
	if ($raid_max_count <= 0)
		$raid_life_attend_percent_text = "No Raids Scheduled";
	else
	{
		$raid_life_attend_percent = round(($raid_attend_count / $raid_max_count)*100, 2);
		$raid_life_attend_percent_text = $raid_life_attend_percent . "%";
	}
	
	$wrmadminsmarty->assign('raid_statistics_data', 
			array
			(
				'header' => $phprlang['raid_stats_header'],
				'explanation' => $phprlang['raid_stats_explanation'],
				'active_count_header' => $phprlang['raid_active_count_header'],
				'total_count_header' => $phprlang['raid_total_count_header'],
				'active_count' => $active_raid_count,
				'total_count' => $total_raid_count,
				'week_percent_header' => $phprlang['raid_week_percent_header'],
				'week_percent' => $raid_week_attend_percent_text,
				'30d_percent_header' => $phprlang['raid_30d_percent_header'],
				'30d_percent' => $raid_30d_attend_percent_text,
				'3m_percent_header' => $phprlang['raid_3m_percent_header'],
				'3m_percent' => $raid_3m_attend_percent_text,
				'6m_percent_header' => $phprlang['raid_6m_percent_header'],
				'6m_percent' => $raid_6m_attend_percent_text,
				'1y_percent_header' => $phprlang['raid_1y_percent_header'],
				'1y_percent' => $raid_1y_attend_percent_text,
				'life_percent_header' => $phprlang['raid_life_percent_header'],
				'life_percent' => $raid_life_attend_percent_text,
			)
	);
	
	/*********************************************
	 * 		LOGINS SECTION
	 *********************************************/
	// Active Users in the Last 5 Minutes
	$minus5_time = time() - (5 * 60); // Current Time - 5 minutes.
	$logged_in = array();
	
	$sql = "SELECT a.username as username, a.email as email, a.last_login_time as last_login_time, b.permission_type_name as perm_name
			FROM " . $phpraid_config['db_prefix'] . "profile a, " . $phpraid_config['db_prefix'] . "permission_type b
			WHERE a.priv = b.permission_type_id"; 
	$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
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
				'explanation' => $phprlang['recent_logins_explanation'],
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
	$sql = "SELECT a.username as username, a.email as email, a.last_login_time as last_login_time, b.permission_type_name as perm_name
			FROM " . $phpraid_config['db_prefix'] . "profile a, " . $phpraid_config['db_prefix'] . "permission_type b
			WHERE a.priv = b.permission_type_id
			ORDER BY a.last_login_time DESC"; 
	$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	$usercount=0;
	while($data = $db_raid->sql_fetchrow($result, true))
	{
		if ($data['last_login_time'] <= $minus30d_time || $data['last_login_time']=='')
		{
			if ($data['last_login_time']=='')
			{
				//User hasn't logged in since somewhere in the WRM 3.5 Days, set them inactive.
				$data['last_login_time'] = 0;
			}
			// Last 10 Users not logged on for the last 30 days.
			array_push($logged_in,
				array
				(
					'username'=>$data['username'],
					'email'=>$data['email'],
					'priv'=>$data['perm_name'],
					'login_time'=>date($phpraid_config['date_format']." ".$phpraid_config['time_format'],$data['last_login_time']),
				)
			);
			$usercount++;		
		}
		if ($usercount >= 10)
			break;
	}
	
	$wrmadminsmarty->assign('inactive_logins_header', 
			array
			(
				'header' => $phprlang['inactive_logins_header'],
				'explanation' => $phprlang['inactive_login_explanation'],
				'username_header' => $phprlang['logins_username_header'],
				'email_header' => $phprlang['logins_email_header'],
				'priv_header' => $phprlang['logins_priv_header'],
				'login_time_header' => $phprlang['logins_time_header'],
			)
	);
	
	$wrmadminsmarty->assign('inactive_logins', $logged_in);
	
	/*********************************************
	 * 		LOGS SECTION
	 *********************************************/
	// Most Recent Hack logs.
	$log_data = array();
	$date_format = $phpraid_config['date_format'] . " " . $phpraid_config['time_format'];
	
	$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "logs_hack 
			ORDER BY timestamp desc LIMIT 10";
	$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	while ($data = $db_raid->sql_fetchrow($result, true))
	{
		array_push($log_data, 
			array(
				'ip' => $data['ip'],
				'message' => scrub_input($data['message']),
				'timestamp' => date($date_format, $data['timestamp']),
			)
		);
	}
	
	$wrmadminsmarty->assign('logs_header',
		array(
			'header' => $phprlang['logs_header'],
			'explanation' => $phprlang['logs_explanation'],
			'ip_header' => $phprlang['ip_header'],
			'message_header' => $phprlang['message_header'],
			'timestamp_header' => $phprlang['timestamp_header'],
		)
	);
	
	$wrmadminsmarty->assign('log_data', $log_data);
	
	/********************************************
	 * 	Cache Actions Buttons
	 ********************************************/
	$delete_board_cache_button = '<a href="admin_index.php?mode=purge_board_cache"><img src="../templates/' . $phpraid_config['template'] . '/images/icons/icon_delete.gif" border="0" onMouseover="ddrivetip(\''.$phprlang['delete'].'\');" onMouseout="hideddrivetip();" alt="delete icon"></a>';
	$delete_armory_cache_button = '<a href="admin_index.php?mode=purge_armory_cache"><img src="../templates/' . $phpraid_config['template'] . '/images/icons/icon_delete.gif" border="0" onMouseover="ddrivetip(\''.$phprlang['delete'].'\');" onMouseout="hideddrivetip();" alt="delete icon"></a>';
	$delete_armory_log_button = '<a href="admin_index.php?mode=purge_armory_logs"><img src="../templates/' . $phpraid_config['template'] . '/images/icons/icon_delete.gif" border="0" onMouseover="ddrivetip(\''.$phprlang['delete'].'\');" onMouseout="hideddrivetip();" alt="delete icon"></a>';
	$delete_template_cache_button = '<a href="admin_index.php?mode=purge_template_cache"><img src="../templates/' . $phpraid_config['template'] . '/images/icons/icon_delete.gif" border="0" onMouseover="ddrivetip(\''.$phprlang['delete'].'\');" onMouseout="hideddrivetip();" alt="delete icon"></a>';

	// Setup Data Ouptut and Display.
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
			'actions_header' => $phprlang['actions_header'],
			'actions_explanation' => $phprlang['actions_explanation'],
			'delete_board_cache_button' => $delete_board_cache_button,
			'delete_armory_cache_button' => $delete_armory_cache_button,
			'delete_armory_log_button' => $delete_armory_log_button,
			'delete_template_cache_button' => $delete_template_cache_button,
			'delete_template_cache_text' => $phprlang['delete_template_cache_text'],
			'delete_board_cache_text' => $phprlang['delete_board_cache_text'],
			'delete_armory_cache_text' => $phprlang['delete_armory_cache_text'],
			'delete_armory_log_text' => $phprlang['delete_armory_log_text'],
		)
	);
	
	//
	// Start output of the page.
	//
	require_once('./includes/admin_page_header.php');
	$wrmadminsmarty->display('admin_main_page.html');
	require_once('./includes/admin_page_footer.php');
} // End of the Else at the Beginning.
?>