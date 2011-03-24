<?php
/***************************************************************************
 *                             function.php
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

/**
 * Many Hosts Do not allow "SHOW DATABASES" and such, this is the check.
 * 
 * @return boolean TRUE=OK, FALSE=Error
 */
function check_sql_rights_SHOW_DATABASES($wrm_install)
{	
	$sql_SHOW_DATABASES = "SHOW DATABASES";

	$support_rights_SHOW_DATABASES = TRUE;
	
	$wrm_install->sql_query($sql_SHOW_DATABASES) or $support_rights_SHOW_DATABASES = FALSE;
	
	return ($support_rights_SHOW_DATABASES);
}

/**
 * Many Hosts Do not allow "SHOW TABLES" and such, this is the check.
 * 
 * @return boolean TRUE=OK, FALSE=Error
 */
function check_sql_rights_SHOW_TABLES($wrm_install, $database)
{	
		
	$sql_SHOW_TABLES = "SHOW TABLES FROM `".$database."`";

	$support_rights_SHOW_TABLES = TRUE;
	
	$wrm_install->sql_query($sql_SHOW_TABLES) or $support_rights_SHOW_TABLES = FALSE;

	return ($support_rights_SHOW_TABLES);
}

/*
 * validate wrm configfile
 * @return boolean TRUE=OK,FALSE=Error
 */
function validate_wrm_configfile()
{
	global $phpraid_config;
	
	$validate_value = TRUE;
	
	$curr_dir = dirname(__FILE__);
	$wrm_dir = substr($curr_dir, 0, strpos($curr_dir, "install")-1); //Strip the "install" directory off the end.
	
	$wrm_config_file = $wrm_dir . "/config.php";
	if(is_file($wrm_config_file))
	{
		include_once($wrm_config_file);
		if ( 	!isset($phpraid_config['db_name']) and ($phpraid_config['db_name'] != "") and 
				!isset($phpraid_config['db_host']) and ($phpraid_config['db_host'] != "") and
				!isset($phpraid_config['db_user']) and ($phpraid_config['db_user'] != "") and
				!isset($phpraid_config['db_pass']) and ($phpraid_config['db_pass'] != "") and
				!isset($phpraid_config['db_prefix']) and ($phpraid_config['db_prefix'] != "") and
				!isset($phpraid_config['db_type']) and ($phpraid_config['db_type'] != "")
			)
		{
			//error
			$validate_value = FALSE;
		}
	}
	else
		$validate_value = FALSE;
	
	if ($validate_value == TRUE)
		return TRUE;
	else 
		return FALSE;
}

/**
 * write the WRM Config File "../config.php"
 *
 * @param String $wrm_db_name
 * @param String $wrm_db_server_hostname
 * @param String $wrm_db_username
 * @param String $wrm_db_password
 * @param String $wrm_db_tableprefix
 * @param String $wrm_db_type
 * @param String $eqdkp_db_name
 * @param String $eqdkp_db_host
 * @param String $eqdkp_db_user
 * @param String $eqdkp_db_pass
 * @param String $eqdkp_db_prefix
 * @return boolean 
 */
function write_wrm_configfile($wrm_db_name,$wrm_db_server_hostname = "localhost",$wrm_db_username,$wrm_db_password,$wrm_db_tableprefix = "wrm_",$wrm_db_type="mysql",$eqdkp_db_name = "",$eqdkp_db_host = "",$eqdkp_db_user = "",$eqdkp_db_pass = "",$eqdkp_db_prefix = "",$wrm_db_utf8_support = "",$wrm_mbstring_support = "")
{
	//Calculate UTF8 Support if not already passed:
	if ($wrm_db_utf8_support == '')
	{
		// Check for UTF8 Support in Database
		$gd = get_mysql_version_from_mysql();
		$wrm_db_utf8_support = (strnatcmp($gd,'4.1.0') >= 0) ? "yes" : "no";
	}
	
	//Calculate MBString Support if not already passed:
	if ($wrm_mbstring_support == '')
	{
		// Check for MB String Enabled in PHP
		$wrm_mbstring_support = (extension_loaded('mbstring')) ? "yes" : "no";
	} 
	
	//global $wrm_config_file;
	$wrm_config_file = "../config.php";
	include("../version.php");
	/**
	 * write config file (config.php)
	 */
	$output  = "<?php\n";
	$output .= "/*\n";
	$output .= "#**********************************************#\n";
	$output .= "#                                              #\n";
	$output .= "#     auto-generated configuration file        #\n";
	$output .= "#     WoW Raid Manager ".$version."                   #\n";
	$output .= "#     date: ".date("Y-m-d - H:i:s")."              #\n";
	$output .= "#   Do not change anything in this file!       #\n";
	$output .= "#                                              #\n";
	$output .= "#**********************************************#\n";
 	$output .= "*/\n\n";
	$output .= "global ".'$phpraid_config'.";\n";
	$output .= "\n";
	$output .= "/* WRM Settings */";
	$output .= "\n";
	$output .= '$phpraid_config[\'db_name\']'." = '$wrm_db_name';\n";
	$output .= '$phpraid_config[\'db_host\']'." = '$wrm_db_server_hostname';\n";
	$output .= '$phpraid_config[\'db_user\']'." = '$wrm_db_username';\n";
	$output .= '$phpraid_config[\'db_pass\']'." = '$wrm_db_password';\n";
	$output .= '$phpraid_config[\'db_prefix\']'." = '$wrm_db_tableprefix';\n";
	$output .= "\n";
	$output .= "/* WRM Database Settings */";
	$output .= "\n";
	$output .= '$phpraid_config[\'wrm_db_utf8_support\']'." = '$wrm_db_utf8_support';\n";
	$output .= '$phpraid_config[\'wrm_mbstring_support\']'." = '$wrm_mbstring_support';\n";
	$output .= '$phpraid_config[\'db_type\']'." = '$wrm_db_type';\n";
	$output .= "\n";
	$output .= "\n";
	$output .= "/* EQDKP Settings */";
	$output .= "\n";
	$output .= '$phpraid_config[\'eqdkp_db_name\']'." = '$eqdkp_db_name';\n";
	$output .= '$phpraid_config[\'eqdkp_db_host\']'." = '$eqdkp_db_host';\n";
	$output .= '$phpraid_config[\'eqdkp_db_user\']'." = '$eqdkp_db_user';\n";
	$output .= '$phpraid_config[\'eqdkp_db_pass\']'." = '$eqdkp_db_pass';\n";
	$output .= '$phpraid_config[\'eqdkp_db_prefix\']'." = '$eqdkp_db_prefix';\n";
	$output .= "\n";
	$output .= "?>";
	
	$fd = fopen($wrm_config_file,'w+');
	if (!$fd)
	{
		echo "can not write this file: ". $wrm_config_file."<br>";
		
		//fclose($fd);
		
		return (FALSE);
	}
	else
	{
		fwrite($fd, $output);
		fclose($fd);

		//@chmod($wrm_config_file,0776);
		
		return (TRUE);
	}
}

/**
 * this is a copy from the function in includes/functions.php
 *
 * @param Integer $value
 * @param boolean $nullify
 * @param unknown_type $conn
 * @return unknown
 */
function quote_smart($value = "", $nullify = false, $conn = null)
{
	//reset default if second parameter is skipped
	$nullify = ($nullify === null) ? (false) : ($nullify);
	//undo slashes for poorly configured servers
	$value = (get_magic_quotes_gpc()) ? (stripslashes($value)) : ($value);
	//check for null/unset/empty strings (takes advantage of short-circuit evals to avoid a warning)
	if ((!isset($value)) || (is_null($value)) || ($value === ""))
	{
		$value = ($nullify) ? ("NULL") : ("''");
	}
	else
	{
		if (is_string($value))
		{
			//value is a string and should be quoted; determine best method based on available extensions
			if (function_exists('mysql_real_escape_string'))
			{
				$value = "'" . (((isset($conn)) && (is_resource($conn))) ? (mysql_real_escape_string($value, $conn)) : (mysql_real_escape_string($value))) . "'";
			}
			else
			{
				$value = "'" . mysql_escape_string($value) . "'";
			}
		}
		else
		{
			//value is not a string; if not numeric, bail with error
			$value = (is_numeric($value)) ? ($value) : ("'ERROR: unhandled datatype in quote_smart'");
		}
	}
	return $value;
}

function scrub_input($value = "", $html_allowed = false)
{
	$value=strip_tags($value, '<br><a>');

	if (!$html_allowed)
		$value = htmlspecialchars($value);

	return $value;
}

/***
 * print error
 * @param string $path
 * @return boolean
 */
function print_error($type, $error, $die) 
{
	global $wrm_install_lang, $phpraid_config, $smarty;
	
	if($die == 1)
		$print_error_msg_type = $wrm_install_lang['print_error_critical'];
	else
		$print_error_msg_type = $wrm_install_lang['print_error_minor'];

	include_once ("includes/page_header.php");
	$smarty->assign(
		array(
				"error_title" => $wrm_install_lang['print_error_title'],
				"print_error_msg_type" => $print_error_msg_type,
				"print_error_page" => $wrm_install_lang['print_error_page'],
				"PHP_SELF" => $_SERVER['PHP_SELF'],
				"print_error_query" => $wrm_install_lang['print_error_query'],
				"type" => $type,
				"print_error_details" => $wrm_install_lang['print_error_details'],
				"error_line" => __LINE__,
				"error_no" => $error['code'],
				"error_text" => $error['message'],
				"print_error_msg_begin" => $wrm_install_lang['print_error_msg_begin'],
				"print_error_msg_end" => $wrm_install_lang['print_error_msg_end'],
		)
	);
	
	$smarty->display("error_big.html");
	include_once ("includes/page_footer.php");

	if($die == 1)
		exit;
		
	return TRUE;
}

/**
 * Check for a directory, if the passed path is a directory create a temp file as path
 *  and try to open, otherwise just try to open that file for writing.
 * Is Writeable function is bugged beyond belief, it has issues with ACL and Group accesses, use this instead.
 * will work in despite of Windows ACLs bug.
 * NOTE: use a trailing slash for folders!!!
 * see http://bugs.php.net/bug.php?id=27609
 * see http://bugs.php.net/bug.php?id=30931
 *
 * @param string $path
 * @return boolean
 */
function is__writable($path)
{
	if ($path{strlen($path)-1}=='/') // recursively return a temporary file path
        return is__writable($path.uniqid(mt_rand()).'.tmp');
    else if (is_dir($path))
        return is__writable($path.'/'.uniqid(mt_rand()).'.tmp');
    // check tmp file for read/write capabilities
    $rm = file_exists($path);
    $f = @fopen($path, 'a');
    if ($f===false)
        return false;
    fclose($f);
    if (!$rm)
        unlink($path);
    return true;
	
	//$checkpath = $path;
//
	//if ($path{strlen($path)-1}=='/')
	//$checkpath = $path.uniqid(mt_rand()).'.tmp';
//
	//if (!($f = @fopen($checkpath, 'a+')))
	//return false;
//
	//fclose($f);
	//if ($checkpath != $path)
	//unlink($checkpath);
	//return true;
}

/**
 * get mysql version from phpinfo()
 *
 * @return boolean
 */
function get_mysql_client_version_from_phpinfo()
{
	ob_start();
	phpinfo(INFO_MODULES);
	$info = ob_get_contents();
	ob_end_clean();
	$info = stristr($info, 'Client API version');
	preg_match('@[0-9]+\.[0-9]+\.[0-9]+@', $info, $match);
	$gd = $match[0];

	return $gd;
}

/**
 * get mysql version from mysql()
 *
 * @return boolean
 */
function get_mysql_version_from_mysql()
{
	$a = mysql_get_server_info();
	$mysql_version = substr($a, 0, strpos($a, "-"));
		
	return $mysql_version;
}

/**
 * copy from \includes\functions.php
 * Reverses database sanitization by removing escape backslashes
 * and decoding html entities.
 *
 * @return boolean
 */
function desanitize($array)
{
  $retarr_keys = array_keys($array);
  $retarr_values = array_values($array);
  
  for ($i = 0; $i < count($retarr_keys) - 1; $i++)
  {
  	if (is_string($retarr_values[$i]))
  	{
		$retarr_values[$i] = stripslashes($retarr_values[$i]);
		$retarr_values[$i] = htmlspecialchars_decode($retarr_values[$i]);
  	}

  	$array[$retarr_keys[$i]] = $retarr_values[$i];
  }

  return $array;
}

/***
 *  Get Array with all Langfiles
 * @param boolean $Suffix
 * @return boolean
 */
function get_language_filename($Suffix = FALSE, $linkfilename = "install.php")
{
	$array_lang_files = array();
	$lang_dir = 'language';
	$dh = opendir($lang_dir);
	while($filename = readdir($dh))
	{
		if ( strlen($filename) > 2)
		{
			$filename = substr($filename, 7);//cut from position 7 to filename.lenght end
			$array_lang_files[$linkfilename."?lang=".str_replace('.php','',$filename)."&"] = str_replace('.php','',$filename);
			//$filename_install = "install.php?lang=".$lang."&";
		}
	}

	return ($array_lang_files);
}

/**
 * scan a database
 * @return array
 */
function scan_dbserver_database($wrm_install, $scan_Database, $bridge)
{
	//$scan_Database;$data_db_all['Database'];
	$found_bridge = array();
	$count_user = 0;
	
	//check line: with all bridges
	/*
	 * scan description
	 * @ todo
	 */
	
	for ($i=0; $i < count($bridge); $i++)
	{
		$found_db_table_user_name = false;
		$found_db_table_group_name = false;
		$found_db_table_allgroups = false;
		
		//iums fix
		if ( $bridge[$i]['auth_type_name'] != "iums")
		{
		//echo ":". $scan_Database.":". $bridge;
			//show all TABLES, from the (selected) DATABASES
			$sql_tables = "SHOW TABLES FROM `".$scan_Database."`" ;
			$result_tables = $wrm_install->sql_query($sql_tables) or print_error($sql_tables . "<br>".$bridge[$i]['auth_type_name'], $wrm_install->sql_error(), 1);
			while ($data_tables = $wrm_install->sql_fetchrow($result_tables, true))
			{
				//get current table name
				$db_table_name = $data_tables["Tables_in_".$scan_Database];
		
				$tmp_user_name = substr($db_table_name, strlen($db_table_name) - strlen($bridge[$i]['db_table_user_name']));
				
				//table user name				
				if ( (strcmp( $tmp_user_name ,$bridge[$i]['db_table_user_name']) == 0) and ($bridge[$i]['db_table_user_name'] != ""))
				{
					//set table prefix
					$db_temp_prefix = substr($db_table_name, 0 ,strlen($db_table_name) - strlen($bridge[$i]['db_table_user_name']));
		
					$sql_columns = "SHOW COLUMNS FROM `".$scan_Database."`.".$db_temp_prefix.$bridge[$i]['db_table_user_name'];
					$result_columns = $wrm_install->sql_query($sql_columns) or print_error($sql_columns, $wrm_install->sql_error(), 1);
					
					$counter_valid_column = 0;
					
					while ($data_columns = $wrm_install->sql_fetchrow($result_columns, true))
					{
						if (strcmp($data_columns['Field'],$bridge[$i]['db_user_id']) == 0 )
						{
							$counter_valid_column++;
						}
		
						if (strcmp($data_columns['Field'],$bridge[$i]['db_user_name']) == 0 )
						{
							$counter_valid_column++;
						}
						if (strcmp($data_columns['Field'],$bridge[$i]['db_user_email']) == 0 )
						{
							$counter_valid_column++;
						}
						if (strcmp($data_columns['Field'],$bridge[$i]['db_user_password']) == 0 )
						{
							$counter_valid_column++;
						}
					}
		
					if (($counter_valid_column == 4)  )
					{
						//count: avilable user in the bridge system
						$sql_count_user = 	"SELECT ".$bridge[$i]['db_user_id'].
											" FROM `".$scan_Database."`.".$db_temp_prefix.$bridge[$i]['db_table_user_name']. 
											" " . $bridge[$i]['db_user_name_filter'];
						$result_count_user = $wrm_install->sql_query($sql_count_user) or print_error($sql_count_user, $wrm_install->sql_error(), 1);
						$count_user = $wrm_install->sql_numrows($result_count_user);
						
						$found_db_table_user_name = true;
					}
				}
				
				//table group name
				$tmp_group_name = substr($db_table_name, strlen($db_table_name) - strlen($bridge[$i]['db_table_group_name']));
				if ( (strcmp( $tmp_group_name ,$bridge[$i]['db_table_group_name']) == 0) and ($bridge[$i]['db_table_group_name'] != "") )
				{
					//set table prefix
					$db_temp_prefix = substr($db_table_name, 0 ,strlen($db_table_name) - strlen($bridge[$i]['db_table_group_name']));
						
					$sql_columns = "SHOW COLUMNS FROM `".$scan_Database."`.".$db_temp_prefix.$bridge[$i]['db_table_group_name'];
					$result_columns = $wrm_install->sql_query($sql_columns) or print_error($sql_columns."<br>temp_prefix:".$db_temp_prefix."<br>bridge:".$bridge[$i]['auth_type_name'], $wrm_install->sql_error(), 1);
					while ($data_columns = $wrm_install->sql_fetchrow($result_columns,true))
					{
						if (strcmp($data_columns['Field'],$bridge[$i]['db_group_id']) == 0 )
						{
							$found_db_table_group_name = true;
						}
					}
				}
				
				//table group name
				$tmp_allgroups = substr($db_table_name, strlen($db_table_name) - strlen($bridge[$i]['db_table_allgroups']));
				if ( (strcmp( $tmp_allgroups ,$bridge[$i]['db_table_allgroups']) == 0) and ($bridge[$i]['db_table_allgroups'] != "") )
				{
					$counter_db_table_allgroups = 0;
					//set table prefix
					$db_temp_prefix = substr($db_table_name, 0 ,strlen($db_table_name) - strlen($bridge[$i]['db_table_allgroups']));
					
					$sql_columns = "SHOW COLUMNS FROM `".$scan_Database."`.".$db_temp_prefix.$bridge[$i]['db_table_allgroups'];
					$result_columns = $wrm_install->sql_query($sql_columns) or print_error($sql_columns, $wrm_install->sql_error(), 1);
					while ($data_columns = $wrm_install->sql_fetchrow($result_columns,true))
					{
						if (strcmp($data_columns['Field'],$bridge[$i]['db_allgroups_id']) == 0 )
						{
							$counter_db_table_allgroups++;
						}
						if (strcmp($data_columns['Field'],$bridge[$i]['db_allgroups_name']) == 0 )
						{
							$counter_db_table_allgroups++;
						}
					}
					if ($counter_db_table_allgroups == 2)
					{
						$found_db_table_allgroups = true;
					}
				}		
			}
		}
		/*
		 * add bridge to array
		 */			
		if ( ($found_db_table_user_name == true) and ($found_db_table_group_name == true) and ($found_db_table_allgroups == true))
		{
			//append new bridge to array
			$found_bridge =	$found_bridge + array(
					'bridge_name' => $bridge[$i]['auth_type_name'],
					'bridge_database' => $scan_Database,
					'bridge_table_prefix' => $db_temp_prefix,
					'bridge_founduser' => $count_user
				);
		}
	}

	if ( count ($found_bridge) >=1)
		return $found_bridge;
	else 
		return false;
}//end function scan_dbserver_database($wrm_install, $data_db_all, $bridge)

/***
 * scan the server after Bridges
 * @return array
 */
function scan_dbserver()
{
	
	global $wrm_config_file;
	global $phpraid_config;
	global $lang;
	
	
//load all auth bridges settings
	$bridge = array();
	$found_bridge = array();
	
	$dir_brige = "auth";
	//load all available files, from "auth" dir in a array
	$dh = opendir($dir_brige);
	while(false != ($filename = readdir($dh)))
	{
		$files[] = $filename;
	}
	
	//sort and cut/del "." and ".." from array
	sort($files);
	array_shift($files);
	array_shift($files);
	
	//include and load ALL briges settings
	for ($i=0; $i<count($files); $i++)
	{
		include ($dir_brige."/".$files[$i]);
		array_push($bridge, $bridge_setting_value);
	}

	$wrm_install = create_db_connection($phpraid_config['db_host'], $phpraid_config['db_user'], $phpraid_config['db_pass'], $phpraid_config['db_name']);
	$counter = 0;

	if (check_sql_rights_SHOW_DATABASES($wrm_install)== true)
	{
		$sql_db_all = "SHOW DATABASES";

		$result_db_all = $wrm_install->sql_query($sql_db_all) or print_error($sql_db_all, $wrm_install->sql_error(), 1);
		while ($data_db_all = $wrm_install->sql_fetchrow($result_db_all, true))
		{
			if (($data_db_all['Database'] != "information_schema") and ($data_db_all['Database'] != "mysql"))
			{
				$tmp_array = scan_dbserver_database($wrm_install, $data_db_all['Database'], $bridge);
		
				if ($tmp_array != false)
					array_push($found_bridge,$tmp_array);
			}
		}
	}
	else 
	{
		$found_bridge = scan_dbserver_database($wrm_install, $phpraid_config['db_name'], $bridge);
	}
	$wrm_install->sql_close();
	
	//-----------------------------------------------------------------------//
	//problem: with bridge phpbb2 and phpbb3
	//if on the server phpbb3 install, than have this function, after scan: found phpbb2 and phpbb3
	//-> del phpbb2 in the array
	$found_double = -1;
	for ($y=0; $y<count($found_bridge); $y++)
	{
		//scan after phpbb3
		if ($found_bridge[$y]['bridge_name'] == "phpbb3")
		{
			//scan after phpbb2
			for ($x=0;$x<count($found_bridge); $x++)
			{
				//white the same database and table_prefix
				if 	(
						($found_bridge[$x]['bridge_name'] == "phpbb") and
						($found_bridge[$x]['bridge_database'] == $found_bridge[$y]['bridge_database']) and 
						($found_bridge[$x]['bridge_table_prefix'] == $found_bridge[$y]['bridge_table_prefix'])
					)
				{
					$found_double = $x;
				}
				
			}
			
			//del the found entry
			if ($found_double != -1)
			{
				array_splice($found_bridge, $found_double, 1);
				$found_double = -1;
			}
		}
	}
	//-----------------------------------------------------------------------//
	
	return $found_bridge;
}

/**
 * WRM return the current WRM Version Number
 * 
 * @return Array
 */
function get_WRM_Version_Number()
{
	$wrm_config_file = "../config.php";

	global $phpraid_config, $wrm_install;
	include_once($wrm_config_file);
	
	//read version nr
	$sql = 	sprintf("SELECT version_number "  .
					"FROM " . $phpraid_config['db_prefix'] . "version " .
					"ORDER BY version_number DESC"
			);
	$result_version = $wrm_install->sql_query($sql) or print_error($sql, $wrm_install->sql_error(), 1);	
			
	$data_version = $wrm_install->sql_fetchrow($result_version,true);
	$version_number = $data_version['version_number'];
	
	return (explode('.', $version_number) );
	
}

/*------------------------- Get Last Online Version Nr --------------------------------------------------*/
/** check for new version
 * based on code from phpBB version checking
 * @return string
 */
function get_last_onlineversion_nr()
{
	$errno = 0;
	$errstr = $version_info = '';
	if ($fsock = @fsockopen('www.wowraidmanager.net', 80, $errno, $errstr, 10))
	{
		@fputs($fsock, "GET /vercheck/ver_check_40.txt HTTP/1.1\r\n");
		@fputs($fsock, "HOST: www.wowraidmanager.net\r\n");
		@fputs($fsock, "Connection: close\r\n\r\n");
       
		$get_info = false;
		$version_info = '';
		while (!@feof($fsock))
		{
			if ($get_info)
			{
				$version_info .= trim (@fgets($fsock,128)) . ".";
				//$version_info .= @fread($fsock, 1024);
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
		return $version_info;
	}
	else
	{
		return (false);
	}
	
}

/*
 * return the first 3 numbers
 */
function get_last_onlineversion_nr_short()
{
	$value = explode('.', get_last_onlineversion_nr());
	return $value[0].".".$value[1].".".$value[2].".".$value[4].".".$value[5].".".$value[6];
}

/***
 * show the current 
 */
function show_online_versionnr($file_version)
{

/*
 * ----------------------- (Online) Version Check -------------------------------------------------------
 */	
	$errstr = $latest_version_info = '';
	
	$latest_version_info = get_last_onlineversion_nr();
	if ($latest_version_info == false)
	{
		return -1;
	}
	else
	{
		$installfiles_ver = @explode('.', $file_version);
		//$latest_version_info = explode("\n", $latest_version_info);
		//$latest_version_info = explode(" ", $latest_version_info);
		$latest_version_info = explode(".", $latest_version_info);
		
		if (!isset($installfiles_ver[3]))
			$installfiles_ver[3]= (int) 0;
		if (!isset($installfiles_ver[4]))
			$installfiles_ver[4]= (int) 0;
		if (!isset($installfiles_ver[5]))
			$installfiles_ver[5]= (int) 0;
		if (!isset($installfiles_ver[6]))
			$installfiles_ver[6]= (int) 0;

		$installfiles_ver_text = $installfiles_ver[0].".".$installfiles_ver[1].".".$installfiles_ver[2]." ".$latest_version_info[3];
		$installfiles_ver_text = $installfiles_ver_text." ".$installfiles_ver[3].".".$installfiles_ver[4].".".$installfiles_ver[5];
		
		$latest_version_info_text = $latest_version_info[0].".".$latest_version_info[1].".".$latest_version_info[2]." ".$latest_version_info[3];
		$latest_version_info_text = $latest_version_info_text." ".$latest_version_info[4].".".$latest_version_info[5].".".$latest_version_info[6];

		if (($installfiles_ver[0] == $latest_version_info[0]) and ($installfiles_ver[1] == $latest_version_info[1]) and ($installfiles_ver[2] == $latest_version_info[2]))
		{
			// equal
			return 0;
		}
		else
		{
			return 1;
		}
	}

}
/*----------------- End Online Check -------------------------------------------------------------------------*/

/**
 * return values
 * 0 = all ok
 * 1 = connection failed
 * 2 = bride_type not correct 
 * 
 * check alle tablename, colums
 * @return integer
 */
function test_bridge_connection($bridge_name, $bridge_database_name, $bridge_db_table_prefix)
{
	/**
	 * This is the path to the WRM Config File
	 */
	$wrm_config_file = "../config.php";

	global $phpraid_config;
	include_once($wrm_config_file);
	
	$column_counter = 0;
	$found_selected_db = false;
	
	$found_db_table_name = array();
	
	$wrm_install = create_db_connection($phpraid_config['db_host'], $phpraid_config['db_user'], $phpraid_config['db_pass'], $phpraid_config['db_name']);
	//if not connection available -> goto step epbrgstep1
//	if( ($bridge_install->db_connect_id) == true)
	if( ($wrm_install->db_connect_id) == false)
	{
		return (1);
	}
	
	//pre check: is $bridge_database_name availabe in the database

	/*
	$sql_db_all = "SHOW DATABASES";
	$result_db_all = $wrm_install->sql_query($sql_db_all) or print_error($sql_db_all, $wrm_install->sql_error(), 1);
	while ($data_db_all = $wrm_install->sql_fetchrow($result_db_all, true))
	{
		if ($data_db_all['Database'] == $bridge_database_name)
		{
			$found_selected_db = true;
		}
	}
	if ($found_selected_db == false)
	{
		return (3);
	}
	*/
	
	//include bridge file
	include_once("auth/install_".$bridge_name.".php");

	//easy workaround
	if (check_sql_rights_SHOW_TABLES($wrm_install, $bridge_database_name) == false)
	{
		return (0);
	}
	
	//load all table, from the selected database, in a array	
	$sql_tables = "SHOW TABLES FROM `".$bridge_database_name."`";
	$result_tables = $wrm_install->sql_query($sql_tables) or print_error($sql_tables, $wrm_install->sql_error(), 1);
	while ($data_tables = $wrm_install->sql_fetchrow($result_tables, true))
	{
		$found_db_table_name[] = $data_tables["Tables_in_".$bridge_database_name];
	}
	
	//infos
	//tablename: 	db_table_user_name (db_user_id,db_group_id,db_user_name,db_user_email,db_user_password),
	//				db_table_allgroups (db_allgroups_id,db_allgroups_name), db_table_group_name
	for ($y=0; $y < count($found_db_table_name); $y++)
	{
		if ($found_db_table_name[$y] == $bridge_db_table_prefix.$bridge_setting_value['db_table_user_name'])
		{
			$sql_columns = "SHOW COLUMNS FROM `".$bridge_database_name."`.".$bridge_db_table_prefix.$bridge_setting_value['db_table_user_name'];
			$result_columns = $wrm_install->sql_query($sql_columns) or print_error($sql_columns, $wrm_install->sql_error(), 1);
			while ($data_columns = $wrm_install->sql_fetchrow($result_columns, true))
			{
				//echo "<br>".$data_columns['Field']."==".$bridge_setting_value['db_user_id'];
				if (strcmp($data_columns['Field'],$bridge_setting_value['db_user_id']) == 0 )
				{
					$column_counter++;
				}
				if (strcmp($data_columns['Field'],$bridge_setting_value['db_group_id']) == 0 )
				{
					$column_counter++;
				}
				if (strcmp($data_columns['Field'],$bridge_setting_value['db_user_name']) == 0 )
				{
					$column_counter++;
				}
				if (strcmp($data_columns['Field'],$bridge_setting_value['db_user_email']) == 0 )
				{
					$column_counter++;
				}
				if (strcmp($data_columns['Field'],$bridge_setting_value['db_user_password']) == 0 )
				{
					$column_counter++;
				}
			}
		}
		if ($found_db_table_name[$y] == $bridge_db_table_prefix.$bridge_setting_value['db_table_allgroups'])
		{
			$sql_columns = "SHOW COLUMNS FROM `".$bridge_database_name."`.".$bridge_db_table_prefix.$bridge_setting_value['db_table_allgroups'];
			$result_columns = $wrm_install->sql_query($sql_columns) or print_error($sql_columns, $wrm_install->sql_error(), 1);
			while ($data_columns = $wrm_install->sql_fetchrow($result_columns,true))
			{
				if (strcmp($data_columns['Field'],$bridge_setting_value['db_allgroups_id']) == 0 )
				{
					$column_counter++;
				}
				if (strcmp($data_columns['Field'],$bridge_setting_value['db_allgroups_name']) == 0 )
				{
					$column_counter++;
				}
			}
		}
		if ($found_db_table_name[$y] == $bridge_db_table_prefix.$bridge_setting_value['db_table_group_name'])
		{
			$column_counter++;
		}
		
	}

	//if only all found -> ok=0
	if ($column_counter == 8)
	{
			return (0);
	}
	else
	{
		return (2);
	}
}

/**
 * Create Armory Directory
 * not uses
 */
function create_armory_directory_path($mode = "0777")
{
	mkdir("../cache/armory_cache/",$mode);
	mkdir("../cache/armory_log/",$mode);
	mkdir("../cache/raid_lua/",$mode);
}

/**
 * WRM add Profile in WRM DB
 * only iUMS
 */
function profile_add($user_admin_username,$user_admin_password,$user_admin_email)
{
	global $wrm_install,$phpraid_config;
	$default_admin_Priv = "1";
	
	$sql = sprintf(	"SELECT username, profile_id " .
					" FROM " . $phpraid_config['db_prefix'] . "profile " . 
					" WHERE username = %s", quote_smart($user_admin_username)
			);
	$result = $wrm_install->sql_query($sql) or print_error($sql, $wrm_install->sql_error(), 1);
	$data = $wrm_install->sql_fetchrow($result, true);
	
	if ($wrm_install->sql_numrows() == 0 )
	{	
		$sql = sprintf(	"INSERT INTO " . $phpraid_config['db_prefix'] . "profile " .
						" (`email`, `password`,`priv`,`username`, `last_login_time`) " .
						" VALUES ( %s, %s, %s, %s, %s)",
						quote_smart($user_admin_email),
						quote_smart(md5($user_admin_password)),	quote_smart($default_admin_Priv), 
						quote_smart(strtolower($user_admin_username)), quote_smart(time())
			);
		$wrm_install->sql_query($sql) or print_error($sql, $wrm_install->sql_error(), 1);
	}
	else
	{
		$sql = 	sprintf("UPDATE " . $phpraid_config['db_name'] . "." . $phpraid_config['db_prefix'] . "profile" .
						" SET `email` = %s, `priv` = %s, `password` = %s, `last_login_time` = %s, `username` = %s".
						" WHERE " . $phpraid_config['db_name'] . "." . $phpraid_config['db_prefix'] . "profile.`profile_id` = %s",
						 quote_smart($user_admin_email), quote_smart($default_admin_Priv), quote_smart(md5($user_admin_password)),
						 quote_smart(time()), quote_smart($data["username"]), quote_smart($data["profile_id"])
				);
		$wrm_install->sql_query($sql) or print_error($sql, $wrm_install->sql_error(), 1);
	}
	
}

/**
 * Return RWX Permissions for a Directory or "False" if the directory doesn't exist.
 *
 * @param string $path
 * @return string $permissions
 */
function directory_perms($path)
{		
	clearstatcache();
	if (is_dir($path))
	{
		if (is__writable($path))
		{
			//echo "Writeable!<br>";
			//echo "PATH: " . $path . "<br>";
			//echo substr(sprintf('%o', fileperms($path)), -4);
			$permissions = "1";
		}
		else
		{
			//echo "Not Writeable!<br>";
			//echo "PATH: " . $path . "<br>";
			//echo substr(sprintf('%o', fileperms($path)), -4);
			$permissions = "(" . substr(sprintf('%o', fileperms($path)), -4) . ")*";
		}	
			
		//if (fileperms($path))
		//{
		//	$a1 = fileperms($path);
		//	echo "A1: " . $a1 . "<br>";
		//	$a2 = decoct($a1);
		//	echo "A2: " . $a2 . "<br>";
		//	$a3 = substr($a2, 1);
		//	echo "A3: " . $a3 . "<br>";
		//	$af = "(" . $a3 . ")";
		//	echo "AF: " . $af . "<br>";
		//	$permissions = "(" . substr(decoct(fileperms($path)),1) . ")"; //(0777)
		//}
		//else
		//	$writable_dir_cache_perms_value = FALSE;
	}
	else
		$permissions = "0";
		
	return $permissions;
}

?>