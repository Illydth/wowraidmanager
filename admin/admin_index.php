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

$wrmadminsmarty->assign('version_data',
	array(
		'version_info_header'=>$phprlang['configuration_version_info_header'],
		'version_info' => $version_info,
		'version' => $version,
	)
);
	
// MySQL Version
// PHP Version
// Database Name
// Server Name
// Database User
// Number of Users
// Active Users in the Last 5 Minutes
// Most Recent Log Entries

// Actions
// Purge Board Cache
// Purge Armory Cache

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
	)
);


//
// Start output of the page.
//
require_once('./includes/admin_page_header.php');
$wrmadminsmarty->display('admin_main_page.html');
require_once('./includes/admin_page_footer.php');

?>