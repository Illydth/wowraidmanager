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


//set Lang. Format (default english)
if (!isset($_GET['lang']))
	$lang = "english";
else
	$lang = $_GET['lang'];


if ($step == 2)
{
	if (isset($_POST['classlang_type']))
	{
		//$lang = $_POST['classlang_type'];
	}
}

/*----------------------------------------------------------------*/

/*
 * name of this file
 */
$filename_install = "install.php?lang=".$lang."&";
$filename_upgrade = "upgrade.php";


/**
 * This is the path to the WRM Config File
 */
$wrm_config_file = "../config.php";

/**
 * default wrm Table prefix
 */
$default_file_sql_table_prefix = "wrm_";

/*
 * sql files
 */
$file_sql_install_schema = "database_schema/install/install_schema.sql";
$file_sql_insert_values = "database_schema/install/insert_values.sql";

/*----------------------------------------------------------------*/

include_once('language/locale-'.$lang.'.php');

include_once ("includes/db/db.php");
include_once ("includes/function.php");

/*----------------------------------------------------------------*/

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

	if(is_file($wrm_config_file))
	{
			
		include_once($wrm_config_file);
		$table_profile_available = FALSE;
		
		//test
		if (isset($phpraid_config['db_host']))
		{
			// database connection
			$wrm_install = &new sql_db($phpraid_config['db_host'],$phpraid_config['db_user'],$phpraid_config['db_pass'],$phpraid_config['db_name']);
			
			//if connection available -> goto upgrade.php
			if( ($wrm_install->db_connect_id) == TRUE)
			{
				$sql_db_all = "SHOW DATABASES";
				$result_db_all = $wrm_install->sql_query($sql_db_all) or print_error($sql_db_all, $wrm_install->sql_error(), 1);
				$Database_Exist = False;
				while ($data_db_all = $wrm_install->sql_fetchrow($result_db_all,true))
				{
					//cmp if select db ($wrm_db_name) in/on Server exist
					if ($phpraid_config['db_name'] == $data_db_all['Database'])
					{
						$Database_Exist = TRUE;
					}
				}
				
				if ($Database_Exist == TRUE)
				{
					$sql_tables = "SHOW TABLES FROM ".$phpraid_config['db_name'];
					$result_tables = $wrm_install->sql_query($sql_tables) or print_error($sql_tables, $wrm_install->sql_error(), 1);
					while ($data_tables = $wrm_install->sql_fetchrow($result_tables,true))
					{
						//each version has this table
						if ($phpraid_config['db_prefix']."_".$data_tables["profile"])
						{
							$table_profile_available = TRUE;
						}
					}
					
					if ($table_profile_available != TRUE)
					{
						header("Location: " . $filename_upgrade);
						exit;
					}
				}
			}
		}
	}

	header("Location: ".$filename_install."step=1");

}

/**
 * --------------------
 * Step 1
 * ---------------------
 * */

else if($step == "1")
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

	create_armory_directory_path();
	
	$show_next_bd = TRUE;
	
	$writable_dir_cache_bgcolor = "green";
	$writable_dir_cache_value = $wrm_install_lang['yes'];
	
	//from /include/function.php
	//load all lang file in a array
	$array_lang_files = get_language_filename();

	$phpversion = (int)(str_replace(".", "", phpversion()));

	//fileperm: Returns TRUE = success or FALSE = failure
	if (!(is_writable ("../cache/")))
	{
		$show_next_bd = FALSE;
		$writable_dir_cache_bgcolor = "red";
		$writable_dir_cache_value = $wrm_install_lang['no'];
		
		if (fileperms("../cache/"))
		{
			$writable_dir_cache_perms_value = " (" . substr(decoct(fileperms("../cache")),1) . ")";
		}
		else
			$writable_dir_cache_perms_value = "";
	}
	else
		$writable_dir_cache_perms_value = "";
		 
	if($phpversion < 401)
	{
		$phpversion_bgcolor = "red";
		$show_next_bd = FALSE;
	}
	else
	{
		$phpversion_bgcolor = "green";
	}

	$gd = get_mysql_version_from_phpinfo();
	if ($gd < "4.1.0")
	{
		$mysqlversion_bgcolor = "red";
		$show_next_bd = FALSE;
	}
	else
	{
		$mysqlversion_bgcolor = "green";
	}

	
	// NOTE: BE CAREFUL WITH IS__WRITEABLE, that is NOT the built in is_writeable function. (See Double Underscore)
	if (is_file($wrm_config_file))
	{
		chmod($wrm_config_file,0777);
		if(!is__writeable($wrm_config_file))
		{
			$writeable_config_bgcolor = "red";
			$writeable_config_value = $wrm_install_lang['no'];
			$show_next_bd = FALSE;
			if (fileperms($wrm_config_file))
			{
				$wrm_config_file_fileperms = " (" . substr(decoct(fileperms($wrm_config_file)),2) . ")";
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
		$wrm_config_file_fileperms = "";
		$writeable_config_bgcolor = "green";
		$writeable_config_value = $wrm_install_lang['yes'];		
	}
		
	include_once ("includes/page_header.php");
	$smarty->assign(
		array(
				"form_action" => $filename_install."step=2",
				//table
				"headtitle" => $wrm_install_lang['headtitle'],
				"property" => $wrm_install_lang['step0_property'],
				"required" => $wrm_install_lang['step0_required'],
				"exist" => $wrm_install_lang['step0_exist'],
				"system_requirements" => $wrm_install_lang['step0_system_requirements'],
				"phpversion_text" => $wrm_install_lang['step0_phpversion_text'],
				"phpversion_value" => phpversion(),
				"phpversion_bgcolor" => $phpversion_bgcolor,
				"mysqlversion_text" => $wrm_install_lang['step0_mysqlversion'],
				"mysqlversion_value" => $gd,
				"mysqlversion_bgcolor" => $mysqlversion_bgcolor,
				"nonactive" => $wrm_install_lang['step0_nonactive'],
		
				"writeable_config_text" => $wrm_install_lang['step0_writeable_config'],
				"writeable_config_value" => $writeable_config_value,
				"yes" => $wrm_install_lang['yes'],
				"writeable_config_bgcolor" => $writeable_config_bgcolor,
				"file_perm_value" => $wrm_config_file_fileperms,
		
				"writable_dir_cache_text" => $wrm_install_lang['writable_dir_cache_text'],
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
		$wrm_db_server_hostname_value = $_POST['wrm_db_server_hostname'];
	else
		$wrm_db_server_hostname_value = "localhost";			

	if (isset($_POST['wrm_db_username']))
		$wrm_db_username_value = $_POST['wrm_db_username'];
	else
		$wrm_db_username_value = "";
			
	if (isset($_POST['wrm_db_password']))
		$wrm_db_password_value = $_POST['wrm_db_password'];
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
else if($step == 3) {

//	echo $_POST['sql_db_list_name']. ":" . $_GET['sql_db_list_name'];
	$wrm_db_server_hostname = $_POST['wrm_db_server_hostname'];
	$wrm_db_username = $_POST['wrm_db_username'];
	$wrm_db_password = $_POST['wrm_db_password'];
	
	$wrm_db_name = $_POST['wrm_db_name'];
	$wrm_create_db_value = $_POST['wrm_db_create_name'];
	$wrm_db_tableprefix = $_POST['wrm_db_tableprefix'];
	$sql_db_name_selected = $_POST['list_sql_db_name'];
	
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
	$wrm_install = &new sql_db($wrm_db_server_hostname, $wrm_db_username, $wrm_db_password, "");
	
	if(!$wrm_install->db_connect_id)
	{
		$FOUNDERROR_Connection = TRUE;
		header("Location: ".$filename_install."step=2&erro_con=1");
	}
	
	$wrm_install_lang['step3error_no_DB_found'] = "Open a Database Management Tool (like phpMyAdmin) and create a Database for WRM";
	$error_msg = "";

	if ( isset($_GET['erro_con']) )
		$error_msg .= "Error connecting to Server (Servername or Username or Password incorrect) <br/>";//. ;

	if ( isset($_GET['error_db']))
		$error_msg .= $wrm_install_lang['step3errordbcon'];

	if ($error_msg != "")
	{
		$error_msg .= "<br/>".$wrm_install_lang['hittingsubmit'];
	}
			
	if (isset($_POST['wrm_db_tableprefix'])and $_POST['wrm_db_tableprefix'] != "")
		$wrm_db_tableprefix_value = $_POST['wrm_db_tableprefix'];
	else
		$wrm_db_tableprefix_value = "wrm_";


	//load all DATABASES name in a array ($sql_all_dbname)
	$sql_db_name_values = array();
	$sql_db_all = "SHOW DATABASES";

	$result_db_all = $wrm_install->sql_query($sql_db_all) or print_error($sql_db_all, $wrm_install->sql_error(), 1);
	$i=0;
	while ($data_db_all = $wrm_install->sql_fetchrow($result_db_all,true))
	{
		//show all TABLES
		//# without private sql Database -> readonly
		if  (	( $data_db_all['Database'] != "mysql" ) and 
				( $data_db_all['Database'] != "information_schema" ) and 
				( $data_db_all['Database'] != "phpmyadmin" )
			)
		{
			$sql_db_name_values[$data_db_all['Database']] = $data_db_all['Database'];
			$i++;
		}
	}

	if ($i == 0)
	{
		$enable_next_bd = FALSE;
		$error_msg = $wrm_install_lang['step3error_no_DB_found'];
	}
	
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
			"sql_db_name_values" => $sql_db_name_values,
			"sql_db_name_selected" => $sql_db_name_selected,
			"wrm_db_create_name" => $wrm_install_lang['none'],
			"wrm_db_server_hostname" => $wrm_db_server_hostname,
			"wrm_db_username" => $wrm_db_username,
			"wrm_db_password" => $wrm_db_password,
			"enable_wrm_db_create_name" => $enable_wrm_db_create_name,		
			"error_msg" => $error_msg,
			"only_if_create_new_tab_text" => $wrm_install_lang['only_if_create_new_tab'],
			"head_title_wrm_sql_server" => $wrm_install_lang['head_title_wrm_sql_server'],
			"enable_next_bd" => $enable_next_bd,
			"hittingsubmit" => $wrm_install_lang['hittingsubmit'],
			"bd_submit" => $wrm_install_lang['bd_submit'],
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
	$wrm_db_server_hostname = $_POST['wrm_db_server_hostname'];
	$wrm_db_username = $_POST['wrm_db_username'];
	$wrm_db_password = $_POST['wrm_db_password'];
	
	$wrm_db_name = $_POST['wrm_db_create_name'];

	$wrm_db_tableprefix = $_POST['wrm_db_tableprefix'];
	
	$wrm_config_writeable = FALSE;
	$FOUNDERROR_Database = FALSE;
	
	if ( $_POST['sql_db_list_name'] != " - ".$wrm_install_lang['create_db']." - ")
	{
		$wrm_db_name = $_POST['sql_db_list_name'];
		$wrm_install = &new sql_db($wrm_db_server_hostname, $wrm_db_username, $wrm_db_password, $wrm_db_name);
	}
	else
	{
		//load all DATABASES name in a array ($sql_all_dbname)
		$sql_db_name_values = array();
		$Database_Exist = FALSE;
		$sql_db_all = "SHOW DATABASES";
		$wrm_install = &new sql_db($wrm_db_server_hostname, $wrm_db_username, $wrm_db_password, "");
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
			$wrm_install = &new sql_db($wrm_db_server_hostname, $wrm_db_username, $wrm_db_password, "");
			$sql = "CREATE DATABASE ".$wrm_db_name;
			$wrm_install->sql_query($sql) or print_error($sql, $wrm_install->sql_error() ,1);
		}
		else
		{
			//write config file and then jump to upgrade.php
			write_wrm_configfile($wrm_db_name, $wrm_db_server_hostname, $wrm_db_username, $wrm_db_password, $wrm_db_tableprefix);
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
		$wrm_config_writeable = write_wrm_configfile($wrm_db_name, $wrm_db_server_hostname, $wrm_db_username, $wrm_db_password, $wrm_db_tableprefix);
	
		//writeable 
		if ($wrm_config_writeable == TRUE)
		{
			//go to next step
			header("Location: ".$filename_install."step=".($step+1) );
		}
		//config FILE ist NOT writeable
		else
		{
			header("Location: ".$filename_install."step=1&error_confile_not_writeable");
		}
	}

	if ($FOUNDERROR_Database == TRUE)
	{
		header("Location: ".$filename_install."step=3&error_db=1");
	}
}
/**
 * --------------------
 * Step 5
 *
 * test: if selected db, are wrm table include/exist
 * ---------------------
 * */
else if($step == 5)
{

	include_once($wrm_config_file);
	include_once("install_settings.php");

	$wrm_install = &new sql_db($phpraid_config['db_host'], $phpraid_config['db_user'], $phpraid_config['db_pass'], $phpraid_config['db_name']);
	
	$foundtable = FALSE;
	
	//load all DATABASES name in a array ($sql_all_dbname)
	$result_list_tables = array();
	$sql_tables = "SHOW TABLES FROM ".$phpraid_config['db_name'];

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

	$wrm_install = &new sql_db($phpraid_config['db_host'],$phpraid_config['db_user'],$phpraid_config['db_pass'],$phpraid_config['db_name']);
	

	//DROP all TABLE (array from "install_settings.php")
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

	$wrm_install = &new sql_db($phpraid_config['db_host'],$phpraid_config['db_user'],$phpraid_config['db_pass'],$phpraid_config['db_name']);
	
	//insert (default) values (database_schema/install/insert_values.sql)
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

	$wrm_install = &new sql_db($phpraid_config['db_host'],$phpraid_config['db_user'],$phpraid_config['db_pass'],$phpraid_config['db_name']);
	
	//if db_type == mysql
	if ( ($phpraid_config['db_type'] == "mysql") or (!isset($phpraid_config['db_type'])) )
	{
		$gd = get_mysql_version_from_phpinfo();
		if ($gd >= "4.1.0")
		{
			include_once("install_settings.php");
	
			for ($i=0; $i <count($wrm_tables); $i++)
			{
				$sql = 	sprintf("ALTER TABLE " .$phpraid_config['db_name'] . "." . $phpraid_config['db_prefix'].$wrm_tables[$i] .
								" DEFAULT CHARACTER SET %s COLLATE=utf8_bin", quote_smart("UTF8") );
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
	$wrm_install = &new sql_db($phpraid_config['db_host'], $phpraid_config['db_user'], $phpraid_config['db_pass'], $phpraid_config['db_name']);
	
	$sql = 	sprintf("SELECT * "  .
					" FROM " . 	$phpraid_config['db_name'] . "." . $phpraid_config['db_prefix'] . "config" .
					" WHERE  `config_name` = %s ", quote_smart("header_link")
			);
	$result = $wrm_install->sql_query($sql) or print_error($sql, $wrm_install->sql_error(), 1);

	if($wrm_install->sql_numrows($result) == 0)
	{
		$sql = sprintf(	"INSERT INTO " . $phpraid_config['db_name'] . "." .$phpraid_config['db_prefix'] . "config".
						" VALUES(%s,%s)", quote_smart("header_link"), quote_smart($wrmserver));
		$wrm_install->sql_query($sql) or print_error($sql, $wrm_install->sql_error(), 1);
		$sql = sprintf(	"INSERT INTO " . $phpraid_config['db_name'] . "." .$phpraid_config['db_prefix'] . "config".
						" VALUES(%s,%s)", quote_smart("rss_site_url"), quote_smart($wrmserverfile));
		$wrm_install->sql_query($sql) or print_error($sql, $wrm_install->sql_error(), 1);
		$sql = sprintf(	"INSERT INTO " . $phpraid_config['db_name'] . "." .$phpraid_config['db_prefix'] . "config".
						" VALUES(%s,%s)", quote_smart("rss_export_url"), quote_smart($wrmserverfile));
		$wrm_install->sql_query($sql) or print_error($sql, $wrm_install->sql_error(), 1);
		$sql = sprintf(	"INSERT INTO " . $phpraid_config['db_name'] . "." .$phpraid_config['db_prefix'] . "config".
						" VALUES(%s,%s)", quote_smart("eqdkp_url"), quote_smart($eqdkp_url_link));
		$wrm_install->sql_query($sql) or print_error($sql, $wrm_install->sql_error(), 1);
//		$sql = sprintf(	"INSERT INTO " . $phpraid_config['db_name'] . "." .$phpraid_config['db_prefix'] . "config".
//						" VALUES(%s,%s)", quote_smart("armory_language"), quote_smart($default_armory_language_value));
//		$wrm_install->sql_query($sql) or print_error($sql, $wrm_install->sql_error(), 1);
//		$sql = sprintf(	"INSERT INTO " . $phpraid_config['db_name'] . "." .$phpraid_config['db_prefix'] . "config".
//						" VALUES(%s,%s)", quote_smart("armory_link"), quote_smart($default_armory_link_value));
//		$wrm_install->sql_query($sql) or print_error($sql, $wrm_install->sql_error(), 1);
		$sql = sprintf(	"INSERT INTO " . $phpraid_config['db_name'] . "." .$phpraid_config['db_prefix'] . "config".
						" VALUES(%s,%s)", quote_smart("wrm_created_on"), quote_smart(time()));
		$wrm_install->sql_query($sql) or print_error($sql, $wrm_install->sql_error(), 1);
		$sql = sprintf(	"INSERT INTO " . $phpraid_config['db_name'] . "." .$phpraid_config['db_prefix'] . "config".
						" VALUES(%s,%s)", quote_smart("wrm_updated_on"), quote_smart(time()));
		$wrm_install->sql_query($sql) or print_error($sql, $wrm_install->sql_error(), 1);
	}
	else
	{
		$sql = 	sprintf("UPDATE " . $phpraid_config['db_name'] . "." . $phpraid_config['db_prefix'] . "config" .
						" SET `config_value` = %s WHERE %s = `config_name`", quote_smart($wrmserver), quote_smart("header_link"));
		$wrm_install->sql_query($sql) or print_error($sql, $wrm_install->sql_error(), 1);
		$sql = 	sprintf("UPDATE " . $phpraid_config['db_name'] . "." . $phpraid_config['db_prefix'] . "config" .
						" SET `config_value` = %s WHERE %s = `config_name`", quote_smart($wrmserverfile), quote_smart("rss_site_url"));
		$wrm_install->sql_query($sql) or print_error($sql, $wrm_install->sql_error(), 1);
		$sql = 	sprintf("UPDATE " . $phpraid_config['db_name'] . "." . $phpraid_config['db_prefix'] . "config" .
						" SET `config_value` = %s WHERE %s = `config_name`", quote_smart($wrmserverfile), quote_smart("rss_export_url"));
		$wrm_install->sql_query($sql) or print_error($sql, $wrm_install->sql_error(), 1);
		$sql = 	sprintf("UPDATE " . $phpraid_config['db_name'] . "." . $phpraid_config['db_prefix'] . "config" .
						" SET `config_value` = %s WHERE %s = `config_name`", quote_smart($eqdkp_url_link), quote_smart("eqdkp_url"));
		$wrm_install->sql_query($sql) or print_error($sql, $wrm_install->sql_error(), 1);
//		$sql = 	sprintf("UPDATE " . $phpraid_config['db_name'] . "." . $phpraid_config['db_prefix'] . "config" .
//						" SET `config_value` = %s WHERE %s = `config_name`", quote_smart($default_armory_language_value), quote_smart("armory_language"));
//		$wrm_install->sql_query($sql) or print_error($sql, $wrm_install->sql_error(), 1);
//		$sql = 	sprintf("UPDATE " . $phpraid_config['db_name'] . "." . $phpraid_config['db_prefix'] . "config" .
//						" SET `config_value` = %s WHERE %s = `config_name`", quote_smart($default_armory_link_value), quote_smart("armory_link"));
//		$wrm_install->sql_query($sql) or print_error($sql, $wrm_install->sql_error(), 1);
		$sql = 	sprintf("UPDATE " . $phpraid_config['db_name'] . "." . $phpraid_config['db_prefix'] . "config" .
						" SET `config_value` = %s WHERE %s = `config_name`", quote_smart(time()), quote_smart("wrm_created_on"));
		$wrm_install->sql_query($sql) or print_error($sql, $wrm_install->sql_error(), 1);
		$sql = 	sprintf("UPDATE " . $phpraid_config['db_name'] . "." . $phpraid_config['db_prefix'] . "config" .
						" SET `config_value` = %s WHERE %s = `config_name`", quote_smart(time()), quote_smart("wrm_updated_on"));
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
