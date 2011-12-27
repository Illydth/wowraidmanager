<?php
/***************************************************************************
 *                             install.php
 *                            -------------------
 *   begin                : Dec 12, 2008
 *	 Dev                  : Carsten Hölbing
 *	 email                : carsten@hoelbing.net
 *
 *   -- WoW Raid Manager --
 *   copyright            : (C) 2007-2009 Douglas Wagner
 *   email                : douglasw0@yahoo.com
 *   www				  : http://www.wowraidmanager.net
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

if (!isset($_GET['step']))
	$step = "0";
else
	$step = $_GET['step'];
	
/*
 * include libs
 */
include_once ("install_common.php");


// force reporting - Turn on the First Error_Reporting for Development, The Second for Production. 
//error_reporting(E_ALL ^ E_NOTICE);
error_reporting(E_ERROR | E_WARNING | E_PARSE);

/*
 * name of this file
 */
$filename_install = "install.php?lang=".$lang."&";
$filename_upgrade = "upgrade.php?lang=".$lang;


/**
 * This is the path to the WRM Config File
 */
$wrm_config_file = $wrm_dir . "/config.php";

/**
 * default wrm Table prefix
 */
$default_file_sql_table_prefix = "wrm_";

/*
 * sql files
 */
$file_sql_install_schema = "database_schema/install/install_schema.sql";
$file_sql_insert_values = "database_schema/install/insert_values.sql";
$file_sql_game_values = "database_schema/install/games/World_Of_Warcraft.sql";

/**
 * --------------------
 * Step 0
 *
 * check: if config.php file available
 * yes -> test database connection -> open upgrade.php 
 * no -> jump to step1 (installation)
 * ---------------------
 * */
if ($step == "0")
{

	if(validate_wrm_configfile())
	{
			
		include_once($wrm_config_file);
		$table_profile_available = FALSE;
	
		// database connection
		$wrm_install = create_db_connection($phpraid_config['db_host'],$phpraid_config['db_user'],$phpraid_config['db_pass'],$phpraid_config['db_name']);
		
		//1. check: connection available 
		//2. check:  exist $phpraid_config['db_name'] (database)-> SERVER
		//3. check:  exist wrm tables (schema)-> $phpraid_config['db_name'] (database)
		//then goto upgrade.php
		if( ($wrm_install->db_connect_id) == TRUE)
		{
			// Since we've passed Database above, we are assuming that the connection was
			//   made to the actual WRM database, thus it HAS to exist.  The check if the
			//   database is listed in a "show databases" list is redundant, and causes
			//   problems for those who's ISP has removed the show database functionality.
			// Also if the database doesn't exist the "do the tables exist" check below 
			//   will catch it.
			
			//$sql_db_all = "SHOW DATABASES";
			//$result_db_all = $wrm_install->sql_query($sql_db_all) or print_error($sql_db_all, $wrm_install->sql_error(), 1);
			//$Database_Exist = False;
			$Database_Exist = TRUE;
			//while ($data_db_all = $wrm_install->sql_fetchrow($result_db_all,true))
			//{
			//	
				//cmp if select db ($wrm_db_name) in/on Server exist
			//	if ($phpraid_config['db_name'] == $data_db_all['Database'])
			//	{
			//		$Database_Exist = TRUE;
			//	}
			//}
			
			if ($Database_Exist == TRUE)
			{
				// ILLYDTH: Code below uses "Show tables" to check if the tables exist in the DB.
				//  This causes problems for some hosts (for some reason I don't know) so instead
				//  we'll make the check a different way.
				
				//$sql_tables = "SHOW TABLES FROM ".$phpraid_config['db_name'];
				//$result_tables = $wrm_install->sql_query($sql_tables) or print_error($sql_tables, $wrm_install->sql_error(), 1);
				//while ($data_tables = $wrm_install->sql_fetchrow($result_tables,true))
				//{
					//each version has this table
				//	if ($data_tables['Tables_in_'.$phpraid_config['db_name']] == $phpraid_config['db_prefix']."raids")
				//	{
				//		$table_profile_available = TRUE;
				//	}
				//}
				
				// Select * will return successful even if no profiles are in the table, if the table
				//   exists, this returns true.
				$sql = "SELECT * FROM " . $phpraid_config['db_prefix']."profile";
				$result_table_exist = $wrm_install->sql_query($sql) or print_error($sql, $wrm_install->sql_error(), 1);
				if ($result_table_exist)
				{
					header("Location: " . $filename_upgrade);
					exit;
				}
			}
		}
	}

	$step = "1";
	//header("Location: ".$filename_install."step=1");
	//exit;
}

/**
 * --------------------
 * Step 1
 * ---------------------
 * */

if($step == "1")
{
	/**
	 *  VersionNR, from this wrm Install File
	 */
	include_once("../version.php");
	$versions_nr_install = $version;

	include_once ("includes/page_header.php");

	$show_online_versionnr_value = show_online_versionnr($versions_nr_install);
	if ($show_online_versionnr_value == -1)
	{
		$smarty->assign(
			array(
					"install_version_info_header" => $wrm_install_lang['install_version_info_header'],
					"install_connect_socked_error_header" => $wrm_install_lang['install_connect_socked_error_header'],
					"install_connect_socked_error" => $wrm_install_lang['install_connect_socked_error'],
			)
		);
		$smarty->display("version_nr_error_socket.html");		
	}
	
	else if ($show_online_versionnr_value == 0)
	{
			//versionsnr are equal
			$smarty->assign(
				array(
						"install_version_info_header" => $wrm_install_lang['install_version_info_header'],
						"info_Body" => $wrm_install_lang['install_version_current'],
				
				)
			);
			$smarty->display("version_nr_ok.html");		
	}

	//create_armory_directory_path();
	
	$show_next_bd = TRUE;
	
	$writable_dir_cache_bgcolor = "green";
	$writable_dir_cache_value = $wrm_install_lang['yes'];
	
	//from /include/function.php
	//load all lang file in a array
	$array_lang_files = get_language_filename();

	// Cache Directory Verification
	// Need to check both the Compile Directory as well as the Cache Directory.
	$cache_dir_array = array();
	// The armory cache directories are no longer needed due to an updated armory ability.
	//$cache_dir_array[0] = '/cache/armory_cache';
	//$cache_dir_array[1] = '/cache/armory_log';
	$cache_dir_array[2] = '/cache/raid_lua';
	$cache_dir_array[3] = '/cache/smarty_cache';
	$cache_dir_array[4] = '/cache/smarty_cache/admin';
	$cache_dir_array[5] = '/cache/templates_c';
	$cache_dir_array[6] = '/cache/templates_c/admin';
	
	foreach ($cache_dir_array as $cache_dir)
	{
		$retval = directory_perms($wrm_dir.$cache_dir);
		if ($retval != "1")
		{
			if ($retval == "0")
			{
				$show_next_bd = FALSE;
				$writable_dir_cache_bgcolor = "red";
				$writable_dir_cache_value = $wrm_install_lang['no'];
				$writable_dir_cache_perms_value = "-&nbsp;" . $wrm_install_lang['dir_missing'];
			}
			else
			{
				$show_next_bd = FALSE;
				$writable_dir_cache_bgcolor = "red";
				$writable_dir_cache_value = $wrm_install_lang['no'];
				$writable_dir_cache_perms_value = "-&nbsp;" . $retval;
			}
			$check_directory = $cache_dir;
			$dir_check_string = $wrm_install_lang['directory'].' "'.$check_directory.'" '.$wrm_install_lang['writable'];
			break;
		}
		else
			$writable_dir_cache_perms_value = "";
			$dir_check_string = $wrm_install_lang['all_dir_checks_passed'];
				
	}
	

	//PHP Version Check
	$phpversion = (int)(str_replace(".", "", phpversion()));
	if($phpversion < 500)
	{
		$phpversion_bgcolor = "red";
		$show_next_bd = FALSE;
	}
	else
	{
		$phpversion_bgcolor = "green";
	}

	$gd = get_mysql_client_version_from_phpinfo();
	if ($gd < "4.1.0")
	{
		$mysqlversion_bgcolor = "red";
		$show_next_bd = FALSE;
	}
	else
	{
		$mysqlversion_bgcolor = "green";
	}
	
	// Check for PHP Safe Mode - Depreciated in 5.3.0 and Removed in 5.4.0
	// "Safe" does not mean what it sounds like, and this interferes with armory lookups
	// 
	if( ini_get('safe_mode'))
	{
		$phpsafemode_bgcolor = "red";
		$show_next_bd = FALSE;
		$phpsafemode_status = "No";
	}
	else
	{
		$phpsafemode_bgcolor = "green";
		$phpsafemode_status = "yes";
	}

	
	// NOTE: BE CAREFUL WITH IS__WRITEABLE, that is NOT the built in is_writeable function. (See Double Underscore)
	if (is_file($wrm_config_file))
	{
		if(!is__writable($wrm_config_file))
		{
			$writeable_config_bgcolor = "red";
			$writeable_config_value = $wrm_install_lang['no'];
			$show_next_bd = FALSE;
			if (fileperms($wrm_config_file))
			{
				$wrm_config_file_fileperms = " *(" . substr(decoct(fileperms($wrm_config_file)),2) . ")";
			}
			else
				$wrm_config_file_fileperms = "";
		}
		else
		{
			$wrm_config_file_fileperms = "";
			$writeable_config_bgcolor = "green";
			$writeable_config_value = $wrm_install_lang['yes'];
		}
	}
	else
	{
		// Config file does not already exist, we now need a "touch" test to verify we can write it.
		if ($fp=@fopen($wrm_config_file, 'a'))  //This is akin to "touch", it opens the file for write.
		{
			$wrm_config_file_fileperms = "";
			$writeable_config_bgcolor = "green";
			$writeable_config_value = $wrm_install_lang['yes'];					
		}
		else 
		{
			$show_next_bd = FALSE;
			$wrm_config_file_fileperms = "";
			$writeable_config_bgcolor = "red";
			$writeable_config_value = $wrm_install_lang['no'];						
		}
		@fclose($fp);
	}
		
	include_once ("includes/page_header.php");
	$smarty->assign(
		array(
				"form_action" => $filename_install."step=2",
				//table
				"headtitle" => $wrm_install_lang['headtitle'],
				"property" => $wrm_install_lang['step0_property'],
				"required" => $wrm_install_lang['step0_required'],
				"exist" => $wrm_install_lang['step0_status'],
				"system_requirements" => $wrm_install_lang['step0_system_requirements'],
				"phpversion_text" => $wrm_install_lang['step0_phpversion_text'],
				"phpversion_value" => phpversion(),
				"phpversion_bgcolor" => $phpversion_bgcolor,
				"mysqlversion_text" => $wrm_install_lang['step0_mysqlversion'],
				"mysqlversion_value" => $gd,
				"mysqlversion_bgcolor" => $mysqlversion_bgcolor,
				"phpsafemode_text" => "Safe mode Disabled?",
				"phpsafemode_status" => $phpsafemode_status,
				"phpsafemode_bgcolor" => $phpsafemode_bgcolor,
				"nonactive" => $wrm_install_lang['step0_nonactive'],
				"permission_warning" => $wrm_install_lang['permission_warning'],
				"writeable_config_text" => $wrm_install_lang['step0_writeable_config'],
				"writeable_config_value" => $writeable_config_value,
				"yes" => $wrm_install_lang['yes'],
				"writeable_config_bgcolor" => $writeable_config_bgcolor,
				"file_perm_value" => $wrm_config_file_fileperms,
		
				"writable_dir_cache_text" => $dir_check_string,
				"writable_dir_cache_bgcolor" => $writable_dir_cache_bgcolor,
				"writable_dir_cache_value" => $writable_dir_cache_value,
				"writable_dir_cache_perms_value" => $writable_dir_cache_perms_value,
		
				"php_variables_text" => $wrm_install_lang['php_variables'],
				"SERVER_SERVER_SOFTWARE_text" => '_SERVER["SERVER_SOFTWARE"]',
				"SERVER_SERVER_SOFTWARE_value" => $_SERVER["SERVER_SOFTWARE"],
				"SERVER_DOCUMENT_ROOT_text" => '_SERVER["DOCUMENT_ROOT"]',
				"SERVER_DOCUMENT_ROOT_value" => $_SERVER["DOCUMENT_ROOT"],
				"SERVER_SERVER_NAME_text" => '_SERVER["SERVER_NAME"]',
				"SERVER_SERVER_NAME_value" => $_SERVER["SERVER_NAME"],
				"SERVER_HTTP_ACCEPT_CHARSET_text" => '_SERVER["HTTP_ACCEPT_CHARSET"]',
				"SERVER_HTTP_ACCEPT_CHARSET_value" => $_SERVER["HTTP_ACCEPT_CHARSET"],
			    "array_lang_files_values" => $array_lang_files,
			    "classlang_type_selected" => $filename_install,
			    "select_lang" => $wrm_install_lang['select_lang'],
				"bd_submit" => $wrm_install_lang['bd_submit'],
				"show_next_bd" => $show_next_bd,
		)
	);
	
	$smarty->display("step1.tpl.html");
	include_once ("includes/page_footer.php");
}

/**
 * --------------------
 * Step 2
 *
 * show/set db settings (server_hostname, db_username, db_password)
 * ---------------------
 * */
else if($step == 2) {

	$error_msg = "";

	if ( isset($_GET['erro_con']) )
	{
		$error_msg .= '<div class="errorHeader">'.$wrm_install_lang['step3errordbcon_titel'].'<br/>';
		$error_msg .= $wrm_install_lang['step3errordbcon'];
		$error_msg .= "<br/>".$wrm_install_lang['hittingsubmit']."</div><br/>"."<br/>";
	}

	if (isset($_POST['wrm_db_server_hostname']))
		$wrm_db_server_hostname_value = scrub_input($_POST['wrm_db_server_hostname']);
	else
		$wrm_db_server_hostname_value = "localhost";			

	if (isset($_POST['wrm_db_username']))
		$wrm_db_username_value = scrub_input($_POST['wrm_db_username']);
	else
		$wrm_db_username_value = "";
			
	if (isset($_POST['wrm_db_password']))
		$wrm_db_password_value = scrub_input($_POST['wrm_db_password']);
	else
		$wrm_db_password_value = "";			


	if(is_file($wrm_config_file) and !isset($_POST['wrm_db_server_hostname']))
	{
		include_once($wrm_config_file);
		
		if (isset($phpraid_config['db_name']))
		{
			$wrm_db_server_hostname_value = $phpraid_config['db_host'];
			$wrm_db_username_value = $phpraid_config['db_user'];
			$wrm_db_password_value = $phpraid_config['db_pass'];
		}
	}
	 
	include_once ("includes/page_header.php");
	$smarty->assign(
		array(
			"form_action" => $filename_install."step=3",
			"headtitle" => $wrm_install_lang['headtitle'],
			"wrm_db_server_hostname_text" => $wrm_install_lang['step2dbserverhostname'],
			"wrm_db_server_hostname_value" => $wrm_db_server_hostname_value,
			"wrm_db_username_text" => $wrm_install_lang['step2dbserverusername'],
			"wrm_db_username_value" => $wrm_db_username_value,
			"wrm_db_password_text" => $wrm_install_lang['step2dbserverpwd'],
			"wrm_db_password_value" => $wrm_db_password_value,
			"wrm_db_create_name" => $_POST['wrm_db_create_name'],
			"wrm_db_tableprefix" => $_POST['wrm_db_tableprefix'],
			"error_msg" => $error_msg,
			"hittingsubmit" => $wrm_install_lang['hittingsubmit'],
			"step2_sql_server_pref" => $wrm_install_lang['step2_sql_server_pref'],
			"bd_submit" => $wrm_install_lang['bd_submit'],
		)
	);
	$smarty->display("step2.tpl.html");
	include_once ("includes/page_footer.php");
}

/**
 * --------------------
 * Step 3
 *
 * show/set db settings (db_name and db_tableprefix) 
 * ---------------------
 * */
else if($step == 3)
{
	$wrm_db_server_hostname = scrub_input($_POST['wrm_db_server_hostname']);
	$wrm_db_username = scrub_input($_POST['wrm_db_username']);
	$wrm_db_password = scrub_input($_POST['wrm_db_password']);
	
	$wrm_db_name = scrub_input($_POST['wrm_db_name']);
	$wrm_create_db_value = scrub_input($_POST['wrm_db_create_name']);
	$wrm_db_tableprefix = scrub_input($_POST['wrm_db_tableprefix']);
	$sql_db_name_selected = scrub_input($_POST['list_sql_db_name']);
	
	$wrm_config_writeable = FALSE;
	$FOUNDERROR_Connection = FALSE;
	$enable_wrm_db_create_name = FALSE;
	$enable_next_bd = TRUE;
	
	if(is_file($wrm_config_file) )//and !isset($_POST['wrm_db_server_hostname']))
	{
		include_once($wrm_config_file);
		
		if (isset($phpraid_config['db_name']))
		{
			$wrm_db_server_hostname = $phpraid_config['db_host'];
			$wrm_db_username = $phpraid_config['db_user'];
			$wrm_db_password = $phpraid_config['db_pass'];
			$wrm_db_name = $phpraid_config['db_name'];
			$sql_db_name_selected = $phpraid_config['db_name'];
			$wrm_db_tableprefix = $phpraid_config['db_prefix'];
		}
	}
	
	// check/test connection
	$wrm_install = create_db_connection($wrm_db_server_hostname, $wrm_db_username, $wrm_db_password, "");
	
	if(!$wrm_install->db_connect_id)
	{
		$FOUNDERROR_Connection = TRUE;
		header("Location: ".$filename_install."step=2&erro_con=1");
	}
	
	$error_msg = "";

	if ( isset($_GET['erro_con']) )
		$error_msg .= $wrm_install_lang['step3error_bad_con_parms'];//. ;

	if ( isset($_GET['error_db']))
		$error_msg .= $wrm_install_lang['step3errordbcon'];

	if ($error_msg != "")
	{
		$error_msg .= "<br/>".$wrm_install_lang['hittingsubmit'];
	}
			
	if (isset($_POST['wrm_db_tableprefix'])and $_POST['wrm_db_tableprefix'] != "")
		$wrm_db_tableprefix_value = scrub_input($_POST['wrm_db_tableprefix']);
	else
		$wrm_db_tableprefix_value = $default_file_sql_table_prefix;


	//load all DATABASES name in a array ($sql_all_dbname)
	$sql_db_name_values = array();
	$sql_db_all = "SHOW DATABASES";

	//$result_db_all = $wrm_install->sql_query($sql_db_all) or print_error($sql_db_all, $wrm_install->sql_error(), 1);
	// Many Hosts Do not allow "SHOW DATABASES" and such, this is the check.
	$can_list_dbs = TRUE;
	$result_db_all = $wrm_install->sql_query($sql_db_all) or $can_list_dbs = FALSE;
	if ($can_list_dbs)
	{
		$i=0;
		$sql_db_list_name = '<select name="sql_db_list_name" class="post" style="width:140px">';
		while ($data_db_all = $wrm_install->sql_fetchrow($result_db_all,true))
		{
			//show all TABLES
			//without private sql Database -> readonly
			if  (	( $data_db_all['Database'] != "mysql" ) and 
					( $data_db_all['Database'] != "information_schema" ) and 
					( $data_db_all['Database'] != "phpmyadmin" )
				)
			{
				$sql_db_list_name .= "<option value=\"" . $data_db_all['Database'] . "\">" . $data_db_all['Database'] ."</option>";		
				//$sql_db_name_values[$data_db_all['Database']] = $data_db_all['Database'];
				$i++;
			}
		}
		$sql_db_list_name .= '</select>';
	}
	else
	{
		// SHOW DATABASES does not work on this host or threw an error.  We now want the user to be
		//   able to type in their database name for the next step.
		$error_msg = $wrm_install_lang['step3error_no_show_databases'];
		$sql_db_list_name = '<input type="text" name="sql_db_list_name" class="post"/>';
		$i=1;
	}
	//0 == no Database found
	if ($i == 0)
	{
		$enable_next_bd = FALSE;
		$error_msg = $wrm_install_lang['step3error_no_DB_found'];
	}
	
	// Check for UTF8 Support in Database
	$gd = get_mysql_version_from_mysql();
	$utf8checked = (strnatcmp($gd,'4.1.0') >= 0) ? "checked" : "";
	
	// Check for MB String Enabled in PHP
	$mbstringchecked = (extension_loaded('mbstring')) ? "checked" : "";
	
	//add create db
	$wrm_install->sql_close();
	
	include_once ("includes/page_header.php");
	$smarty->assign(
		array(
			"form_action" => $filename_install."step=4",
			"headtitle" => $wrm_install_lang['headtitle'],
			"wrm_db_name_text" => $wrm_install_lang['step2dbname'],
			"wrm_create_db_text" => $wrm_install_lang['step2_create_db'],
			"wrm_create_db_value" => $wrm_create_db_value,
			"wrm_db_tableprefix_text" => $wrm_install_lang['step2WRMtableprefix'],
			"wrm_db_tableprefix_value" => $wrm_db_tableprefix_value,
			"wrm_db_tableprefix_default_text" => "(".$wrm_install_lang['default'].":".' "wrm_" )',
			//"sql_db_name_values" => $sql_db_name_values,
			"sql_db_list_name" => $sql_db_list_name,
			"sql_db_name_selected" => $sql_db_name_selected,
			"wrm_db_create_name" => $wrm_install_lang['none'],
			"wrm_db_server_hostname" => $wrm_db_server_hostname,
			"wrm_db_username" => $wrm_db_username,
			"wrm_db_password" => $wrm_db_password,
			"wrm_db_utf8_support_text" => $wrm_install_lang['wrm_db_utf8_support_text'],
			"wrm_mbstring_support_text" => $wrm_install_lang['wrm_mbstring_support_text'],
			"enable_wrm_db_create_name" => $enable_wrm_db_create_name,		
			"error_msg" => $error_msg,
			"only_if_create_new_tab_text" => $wrm_install_lang['only_if_create_new_tab'],
			"head_title_wrm_sql_server" => $wrm_install_lang['head_title_wrm_sql_server'],
			"enable_next_bd" => $enable_next_bd,
			"hittingsubmit" => $wrm_install_lang['hittingsubmit'],
			"bd_submit" => $wrm_install_lang['bd_submit'],
			'wrm_db_utf8_warning' => $wrm_install_lang['utf8_warning'],
			'wrm_db_mbstring_warning' => $wrm_install_lang['mbstring_warning'],
			"utf8checked" => $utf8checked,
			"mbstringchecked" => $mbstringchecked,
			"show_create_new_DB" => FALSE,
		)
	);

	$smarty->display("step3.tpl.html");
	include_once ("includes/page_footer.php");
}

/**
 * --------------------
 * Step 4
 *  create datebase
 *	write wrm configfile
 * ---------------------
 * */
else if($step == 4)
{
	$wrm_db_server_hostname = scrub_input($_POST['wrm_db_server_hostname']);
	$wrm_db_username = scrub_input($_POST['wrm_db_username']);
	$wrm_db_password = scrub_input($_POST['wrm_db_password']);
	
	$wrm_db_name = scrub_input($_POST['wrm_db_create_name']);

	$wrm_db_tableprefix = scrub_input($_POST['wrm_db_tableprefix']);
	
	// UTF8 Support
	$wrm_db_utf8_support_value = (isset($_POST['wrm_db_utf8_support_value'])) ? "yes" : "no";
	
	// Multibyte String Support
	$wrm_mbstring_support_value = (isset($_POST['wrm_mbstring_support_value'])) ? "yes" : "no";
		
	$wrm_config_writeable = FALSE;
	$FOUNDERROR_Database = FALSE;
	
	if ( $_POST['sql_db_list_name'] != " - ".$wrm_install_lang['create_db']." - ")
	{
		$wrm_db_name = scrub_input($_POST['sql_db_list_name']);
		$wrm_install = create_db_connection($wrm_db_server_hostname, $wrm_db_username, $wrm_db_password, $wrm_db_name, TRUE);
	}
	else // This section is not implemented yet.  You cannot get here.
	{
		//load all DATABASES name in a array ($sql_all_dbname)
		// @@ Will need to fix the "Show Databases" part of this.
		$sql_db_name_values = array();
		$Database_Exist = FALSE;
		$sql_db_all = "SHOW DATABASES";
		$wrm_install = create_db_connection($wrm_db_server_hostname, $wrm_db_username, $wrm_db_password, "");
		$result_db_all = $wrm_install->sql_query($sql_db_all) or print_error($sql_db_all, $wrm_install->sql_error(), 1);
		while ($data_db_all = $wrm_install->sql_fetchrow($result_db_all,true))
		{
			//cmp if select db ($wrm_db_name) in/on Server exist
			if ($wrm_db_name == $data_db_all['Database'])
			{
				$Database_Exist = TRUE;
			}
		}
		
		if ($Database_Exist != TRUE)
		{
			$wrm_install = create_db_connection($wrm_db_server_hostname, $wrm_db_username, $wrm_db_password, "");
			$sql = "CREATE DATABASE ".$wrm_db_name;
			$wrm_install->sql_query($sql) or print_error($sql, $wrm_install->sql_error() ,1);
		}
		else
		{
			//write config file and then jump to upgrade.php
			write_wrm_configfile($wrm_db_name, $wrm_db_server_hostname, $wrm_db_username, $wrm_db_password, $wrm_db_tableprefix,"","","","","","",$wrm_db_utf8_support_value,$wrm_mbstring_support_value);
			$wrm_install->sql_close();
			header("Location: ".$filename_upgrade);
		}
	}
	
	if(!$wrm_install->db_connect_id)
	{
		$FOUNDERROR_Database = TRUE;
	}

	$wrm_install->sql_close();

	//no error then write the config file "../config.php"
	if ($FOUNDERROR_Database == FALSE) 
	{
		$wrm_config_writeable = write_wrm_configfile($wrm_db_name, $wrm_db_server_hostname, $wrm_db_username, $wrm_db_password, $wrm_db_tableprefix,"mysql","","","","","",$wrm_db_utf8_support_value,$wrm_mbstring_support_value);
	
		//writeable 
		if ($wrm_config_writeable == TRUE)
		{
			//go to next step
			// ILLYDTH: This has been updated to force into step 6, skipping step 5 completely.
			//   see the notes at the beginning of step 5 for more information.
			header("Location: ".$filename_install."step=".($step+2) );
			exit;
		}
		//config FILE ist NOT writeable
		else
		{
			header("Location: ".$filename_install."step=1&error_confile_not_writeable");
			exit;
		}
	}

	if ($FOUNDERROR_Database == TRUE)
	{
		header("Location: ".$filename_install."step=3&error_db=1");
		exit;
	}
}
/**
 * --------------------
 * Step 5
 *
 * test: if selected db, are wrm table include/exist
 * ---------------------
 * */
// Illydth: 
// The entirety of Step 5 is Irrelivant.  We've gotten to this place because the "profile" table did not
//  exist back in Step 1 when we checked for it.  If the profile table existed, we'd be at "upgrade"
//  right now, not install.  If the profile table doesn't exist, it doesn't matter what we do to the
//  user database, there are no users, thus there can't be any way to do anything IN the system...even
//  initial configuration would require the admin user to be in the profile table, and it doesn't exist.
//
// The "install_schema.sql" we're about to run is setup to drop any tables that already exist, so
//  there's very little reason to run a check to see if any of the tables exist.
//
// This step is now being "skipped" in step 4 above: The code will run step 4 and then "skip" to step
//  6, bypassing this "else if" block entirely.
else if($step == 5)
{

	include_once($wrm_config_file);
	include_once("install_settings.php");

	$wrm_install = create_db_connection($phpraid_config['db_host'], $phpraid_config['db_user'], $phpraid_config['db_pass'], $phpraid_config['db_name']);
	
	$foundtable = FALSE;
	
	//load all DATABASES name in a array ($sql_all_dbname)
	$result_list_tables = array();
	// ILLYDTH: This line commented because Step 5 is now skipped, this keeps compiler errors from
	//   crapping out the code.
	//$sql_tables = "SHOW TABLES FROM ".$phpraid_config['db_name'];

	$result_db_all = $wrm_install->sql_query($sql_tables) or print_error($sql_tables, $wrm_install->sql_error(), 1);
	while ($db_table_name = $wrm_install->sql_fetchrow($result_db_all,true))
	{
		//show all TABLES
		$result_list_tables[] = $db_table_name['Database'];
	}
	
	for($x=0; $x < count($result_list_tables)-1; $x++)
	{
			for($i=0; $i < count($result_list_tables)-1; $i++)
			{
				if( $result_list_tables[$x] == ($phpraid_config['db_prefix']."_".$wrm_tables[$i]) )
				{
					$foundtable = TRUE;
				}
			}
	}
	
	//close sql connection
	$wrm_install->sql_close();

	if($foundtable == TRUE)
	{
		include_once ("includes/page_header.php");
		$smarty->assign(
			array(
				"error_found_table_titel" => $wrm_install_lang['error_found_table_titel'],

				"form_action_bd_next_link" => $filename_install."step=".($step+1), //6
				"form_action_bd_back_link" => $filename_install."step=".($step-2), //3
	

				"error_found_table_bd_back_text" => $wrm_install_lang['error_found_table_bd_back'],
				"error_found_table_bd_cont_text" => $wrm_install_lang['error_found_table_bd_cont'],
			
				"bd_back" => $wrm_install_lang['bd_back'],
				"bd_submit" => $wrm_install_lang['bd_submit'],
			)
		);
	
		$smarty->display("step5.tpl.html");
		include_once ("includes/page_footer.php");

	}
	else
	{
		header("Location: ".$filename_install."step=".($step+1));
	}
}

/**
 * --------------------
 * Step 6
 *
 * del all table and then
 * insert schema(=tables), in wrm db
 * ---------------------
 * */
else if($step == 6)
{
	include_once($wrm_config_file);
	include_once("install_settings.php");

	$wrm_install = create_db_connection($phpraid_config['db_host'],$phpraid_config['db_user'],$phpraid_config['db_pass'],$phpraid_config['db_name'],TRUE);
	//DROP all TABLE (array from "install_settings.php")
	// ILLYDTH: Technically this for loop is Irrelivant as well.  The SQL query we run automatically does
	//   a drop if exists prior to executing the creation, so this is redundant.
	for ($i=0; $i<count($wrm_tables);$i++)
	{
		$sql_del_tab = "DROP TABLE IF EXISTS ".$phpraid_config['db_prefix'].$wrm_tables[$i];
		$wrm_install->sql_query($sql_del_tab) or print_error($sql_del_tab, $wrm_install->sql_error(), 1);
	}

	//install schema  (database_schema/install/install_schema.sql)
	if(!$fd = fopen($file_sql_install_schema, 'r'))
	die('<font color=red>'.$wrm_install_lang['step3errorschema'].'.</font>');

	if ($fd) {
		while (!feof($fd)) {
			$line = fgetc($fd);
			$sql .= $line;

			if($line == ';')
			{
				$sql = substr(str_replace('`'.$default_file_sql_table_prefix,'`' . $phpraid_config['db_prefix'], $sql), 0, -1);
				$wrm_install->sql_query($sql) or print_error($sql, $wrm_install->sql_error(), 1);
				$sql = '';
			}
		}
		fclose($fd);
	}
	
	$wrm_install->sql_close();
	header("Location: ".$filename_install."step=".($step+1));
}

/**
 * --------------------
 * Step 7
 *
 * fill, wrm db, with default values
 * ---------------------
 * */
else if($step == 7)
{
	include_once($wrm_config_file);
	include_once("install_settings.php");

	$wrm_install = create_db_connection($phpraid_config['db_host'],$phpraid_config['db_user'],$phpraid_config['db_pass'],$phpraid_config['db_name']);
	
	//insert (default) values (database_schema/install/insert_values.sql)

	// Changing this to add another Game-Specific file to the insert of values. 
	// $file_sql_insert_values = Generic Game Data like Config, Column Header, Version, etc. data.
	// $file_sql_game_values = Game Specific Data like class and race data.

	// Load $file_sql_insert_values to DB
	if(!$fd = fopen($file_sql_insert_values, 'r'))
	die('<font color=red>'.$wrm_install_lang['step3errorschema'].'.</font>');

	if ($fd) {
		while (!feof($fd)) {
			$line = fgetc($fd);
			$sql .= $line;

			if($line == ';')
			{
				$sql = substr(str_replace('`'.$default_file_sql_table_prefix,'`' . $phpraid_config['db_prefix'], $sql), 0, -1);
				$wrm_install->sql_query($sql) or print_error($sql, $wrm_install->sql_error(), 1);
				$sql = '';
			}
		}
		fclose($fd);
	}
	
	// Load $file_sql_game_values to DB
	if(!$fd = fopen($file_sql_game_values, 'r'))
	die('<font color=red>'.$wrm_install_lang['step3errorschema'].'.</font>');

	if ($fd) {
		while (!feof($fd)) {
			$line = fgetc($fd);
			$sql .= $line;

			if($line == ';')
			{
				$sql = substr(str_replace('`'.$default_file_sql_table_prefix,'`' . $phpraid_config['db_prefix'], $sql), 0, -1);
				$wrm_install->sql_query($sql) or print_error($sql, $wrm_install->sql_error(), 1);
				$sql = '';
			}
		}
		fclose($fd);
	}
	
	$wrm_install->sql_close();

	header("Location: ".$filename_install."step=".($step+1));
}

/**
 * --------------------
 * Step 8
 *
 * install Collation on wrm tablle @ MySQL
 * Run the alter_tables.sql for setting Character Set and Collation if MySQL version > 4.1.0
 * ---------------------
 * */
else if($step == 8)
{
	include_once($wrm_config_file);
	include_once("install_settings.php");

	$wrm_install = create_db_connection($phpraid_config['db_host'],$phpraid_config['db_user'],$phpraid_config['db_pass'],$phpraid_config['db_name']);
	
	//if db_type == mysql
	if ( ($phpraid_config['db_type'] == "mysql") or (!isset($phpraid_config['db_type'])) )
	{
		if ($phpraid_config['wrm_db_utf8_support'] == "yes")
		{
			include_once("install_settings.php");
	
			for ($i=0; $i <count($wrm_tables); $i++)
			{
				$sql = sprintf("ALTER TABLE `" .$phpraid_config['db_name'] . "`.`" . $phpraid_config['db_prefix'].$wrm_tables[$i] .
                          "` DEFAULT CHARACTER SET UTF8 COLLATE='utf8_bin'");
				$wrm_install->sql_query($sql) or print_error($sql, $wrm_install->sql_error(), 1);
			}
		}
	}
	
	$wrm_install->sql_close();

	header("Location: ".$filename_install."step=".($step+1));

}



/**
 * --------------------
 * Step 9
 *
 * jump to bridge install(/config) at/in "install_bridges.php"
 * ---------------------
 * */
else if($step == 9)
{
	header("Location: install_bridges.php?lang=".$lang."&step=0");
}

/**
 * --------------------
 * Step 10
 * tmp
 * ---------------------
 * */
else if($step == 10)
{

}

/**
 * --------------------
 * Step done
 * 
 * only for dynamic (default) values
 * ---------------------
 * */

else if($step === "done")
{
	include_once ($wrm_config_file);

	$wrmserver = 'http://'.$_SERVER['SERVER_NAME'];
	$wrmserverfile = str_replace("/install/install.php","",$wrmserver. $_SERVER['PHP_SELF']);
	
	$eqdkp_url_link = $wrmserverfile."/eqdkp";
//	$default_armory_language_value = $wrm_install_lang['default_armory_language_value'];
//	$default_armory_link_value = $wrm_install_lang['default_armory_link_value'];
	
	//init con. to wrm
	$wrm_install = create_db_connection($phpraid_config['db_host'], $phpraid_config['db_user'], $phpraid_config['db_pass'], $phpraid_config['db_name']);
	
	$sql = 	sprintf("SELECT * "  .
					"FROM " . $phpraid_config['db_prefix'] . "config " .
					"WHERE config_name = %s", quote_smart("header_link")
			);
	$result = $wrm_install->sql_query($sql) or print_error($sql, $wrm_install->sql_error(), 1);

	if($wrm_install->sql_numrows($result) == 0)
	{
		$sql = sprintf(	"INSERT INTO " . $phpraid_config['db_prefix'] . "config ".
						"VALUES(%s,%s)", quote_smart("header_link"), quote_smart($wrmserver));
		$wrm_install->sql_query($sql) or print_error($sql, $wrm_install->sql_error(), 1);
		$sql = sprintf(	"INSERT INTO " . $phpraid_config['db_prefix'] . "config ".
						"VALUES(%s,%s)", quote_smart("rss_site_url"), quote_smart($wrmserverfile));
		$wrm_install->sql_query($sql) or print_error($sql, $wrm_install->sql_error(), 1);
		$sql = sprintf(	"INSERT INTO " . $phpraid_config['db_prefix'] . "config ".
						"VALUES(%s,%s)", quote_smart("rss_export_url"), quote_smart($wrmserverfile));
		$wrm_install->sql_query($sql) or print_error($sql, $wrm_install->sql_error(), 1);
		$sql = sprintf(	"INSERT INTO " . $phpraid_config['db_prefix'] . "config ".
						"VALUES(%s,%s)", quote_smart("eqdkp_url"), quote_smart($eqdkp_url_link));
		$wrm_install->sql_query($sql) or print_error($sql, $wrm_install->sql_error(), 1);
//		$sql = sprintf(	"INSERT INTO " . $phpraid_config['db_name'] . "." .$phpraid_config['db_prefix'] . "config".
//						" VALUES(%s,%s)", quote_smart("armory_language"), quote_smart($default_armory_language_value));
//		$wrm_install->sql_query($sql) or print_error($sql, $wrm_install->sql_error(), 1);
//		$sql = sprintf(	"INSERT INTO " . $phpraid_config['db_name'] . "." .$phpraid_config['db_prefix'] . "config".
//						" VALUES(%s,%s)", quote_smart("armory_link"), quote_smart($default_armory_link_value));
//		$wrm_install->sql_query($sql) or print_error($sql, $wrm_install->sql_error(), 1);
		$sql = sprintf(	"INSERT INTO " . $phpraid_config['db_prefix'] . "config ".
						"VALUES(%s,%s)", quote_smart("wrm_created_on"), quote_smart(time()));
		$wrm_install->sql_query($sql) or print_error($sql, $wrm_install->sql_error(), 1);
		$sql = sprintf(	"INSERT INTO " . $phpraid_config['db_prefix'] . "config ".
						"VALUES(%s,%s)", quote_smart("wrm_updated_on"), quote_smart(time()));
		$wrm_install->sql_query($sql) or print_error($sql, $wrm_install->sql_error(), 1);
	}
	else
	{
		$sql = 	sprintf("UPDATE " . $phpraid_config['db_prefix'] . "config " .
						"SET config_value = %s WHERE config_name = 'header_link'", quote_smart($wrmserver));
		$wrm_install->sql_query($sql) or print_error($sql, $wrm_install->sql_error(), 1);
		$sql = 	sprintf("UPDATE " . $phpraid_config['db_prefix'] . "config " .
						"SET config_value = %s WHERE config_name = 'rss_site_url'", quote_smart($wrmserverfile));
		$wrm_install->sql_query($sql) or print_error($sql, $wrm_install->sql_error(), 1);
		$sql = 	sprintf("UPDATE " . $phpraid_config['db_prefix'] . "config " .
						"SET config_value = %s WHERE config_name = 'rss_export_url'", quote_smart($wrmserverfile));
		$wrm_install->sql_query($sql) or print_error($sql, $wrm_install->sql_error(), 1);
		$sql = 	sprintf("UPDATE " . $phpraid_config['db_prefix'] . "config " .
						"SET config_value = %s WHERE config_name = 'eqdkp_url'", quote_smart($eqdkp_url_link));
		$wrm_install->sql_query($sql) or print_error($sql, $wrm_install->sql_error(), 1);
//		$sql = 	sprintf("UPDATE " . $phpraid_config['db_name'] . "." . $phpraid_config['db_prefix'] . "config" .
//						" SET `config_value` = %s WHERE %s = `config_name`", quote_smart($default_armory_language_value), quote_smart("armory_language"));
//		$wrm_install->sql_query($sql) or print_error($sql, $wrm_install->sql_error(), 1);
//		$sql = 	sprintf("UPDATE " . $phpraid_config['db_name'] . "." . $phpraid_config['db_prefix'] . "config" .
//						" SET `config_value` = %s WHERE %s = `config_name`", quote_smart($default_armory_link_value), quote_smart("armory_link"));
//		$wrm_install->sql_query($sql) or print_error($sql, $wrm_install->sql_error(), 1);
		$sql = 	sprintf("UPDATE " . $phpraid_config['db_prefix'] . "config " .
						"SET config_value = %s WHERE config_name='wrm_created_on'", quote_smart(time()));
		$wrm_install->sql_query($sql) or print_error($sql, $wrm_install->sql_error(), 1);
		$sql = 	sprintf("UPDATE " . $phpraid_config['db_prefix'] . "config " .
						"SET config_value = %s WHERE config_name = 'wrm_updated_on'", quote_smart(time()));
		$wrm_install->sql_query($sql) or print_error($sql, $wrm_install->sql_error(), 1);
	}
	
	$wrm_install->sql_close();
	include_once ("includes/page_header.php");
	$smarty->assign(
		array(
			"headtitle" => $wrm_install_lang['stepdonefinished'],
			"donesetupcomplete_text" => $wrm_install_lang['stepdonesetupcomplete'],
			"doneremovedir_text" => $wrm_install_lang['stepdoneremovedir'],
		)
	);

	$smarty->display("done.tpl.html");
	include_once ("includes/page_footer.php");
}

?>