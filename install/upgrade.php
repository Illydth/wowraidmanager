<?php
/***************************************************************************
 *                             upgrade.php
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
/*
*
* load file "database_schema/upgrade/update_files_conf.php"
* which include a array with "filename", and (new)"versionsnr"
* then start the automatic update Process
*/

if (!isset($_GET['step']))
	$step = "0";
else
	$step = $_GET['step'];



include_once ("install_common.php");

/*----------------------------------------------------------------*/

/**
 * Name from this File
 */
$filename_upgrade = "upgrade.php?lang=".$lang."&";
$filename_install = "install.php?lang=".$lang."&";

/**
 *  VersionNR, from this wrm Install File
 */
include_once("../version.php");
$wrm_version = $version;

/**
 * This is the path to the WRM Config File
 */
$wrm_config_file = "../config.php";
include_once ($wrm_config_file);

/**
 * default wrm Table prefix
 * used: database_schema/upgrade/x.x.x.sql
 */
$default_file_sql_table_prefix = "wrm_";

/*
 * dir. upgrade
 */
$sql_dir_upgrade = "database_schema/upgrade/";

//var, if table "version" exist in wrm db
$table_version_available = FALSE;

//for a test connection
$table_profile_available = FALSE;

//connect 2 wrm server
$wrm_install = create_db_connection($phpraid_config['db_host'],$phpraid_config['db_user'],$phpraid_config['db_pass'],$phpraid_config['db_name']);
if($wrm_install->db_connect_id == FALSE)
{
	header("Location: ".$filename_install);
}

//check if table "version" available
//result ($table_version_available)
//true -> from 3.5.0 to 4.x.x (table version and profile exist)
//false -> older 3.5.0 (table version exist NOT)
$prev_version = '0.0.0';
$found_version = TRUE;
$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "version";
$result_tables = $wrm_install->sql_query($sql) or $found_version = FALSE;
if (!$found_version)
	header("Location: ".$filename_install."step=1");
else
{
	$table_version_available = TRUE;
	$table_profile_available = TRUE;
}

/*----------------------------------------------------------------*/
/**
 * Version from your wrm (Server) Database
 */
if ($table_version_available != FALSE)
{
	//get the last (max) version nr, from wrm db
	$version_number_text = 'version_number';
	$sql = "SELECT ".$version_number_text." FROM ".$phpraid_config['db_prefix']."version ORDER BY ".$version_number_text." DESC LIMIT 0,1";
	$result = $wrm_install->sql_query($sql) or print_error($sql, $wrm_install->sql_error(), 1);
	$data = $wrm_install->sql_fetchrow($result, true);
	$wrm_versions_nr_current_value = $data[$version_number_text];
}
else
{
	$wrm_versions_nr_current_value = "0.0.0";	
}

/* 
 * check version nr
 *
*/
if ($step === "0")
{	
	global $smarty;
	
	include_once ('../version.php');
	$installfiles_ver_text = $version;
	$latest_version_info_text = get_last_onlineversion_nr_short(); 
	$show_online_versionnr_value = show_online_versionnr($wrm_version);
	include_once ("includes/page_header.php");
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
	else
	{
			$smarty->assign(
				array(
						"install_version_info_header" => $wrm_install_lang['install_version_info_header'],
						"install_version_header" => $wrm_install_lang['install_version_header'],
						"install_version_text" => $wrm_install_lang['install_version_text'],
						"install_version_message01" => $wrm_install_lang['install_version_message01'],
						"install_version_message02" => $wrm_install_lang['install_version_message02'],
						"latest_version_value" => $latest_version_info_text,
						"install_version_message03" => $wrm_install_lang['install_version_message03'],
						"install_version_value" => $installfiles_ver_text,
						"install_version_message04" => $wrm_install_lang['install_version_message04'],
						"install_version_message05" => $wrm_install_lang['install_version_message05'],
				)
			);
			$smarty->display("version_nr_error.html");
	}
	
	//wrm DB is older then 3.6.1 -> not support 
	if (($table_version_available == FALSE) or ((str_replace(".","",$wrm_versions_nr_current_value)) < "361"))
	{
		$smarty->assign(
			array(
				"install_version_info_header" =>$wrm_install_lang['install_version_info_header'],
				"error_install_version_to_old_titel" => $wrm_install_lang['error_install_version_to_old_text'],
				"form_action" => "install.php?lang=".$lang."&step=6",
				"error_found_table_bd_cont" => $wrm_install_lang['error_found_table_bd_cont'],
				"bd_submit" => $wrm_install_lang['bd_continue'],
			)
		);
		$smarty->display("update_toold.tpl.html");
		include_once ("includes/page_footer.php");
	}
	
	//install (@wrm server) and the new install version are equal
	else if ($wrm_versions_nr_current_value == $wrm_version)
	{
		// "your wrm is up to date";		
		//show_online_versionnr($wrm_install_lang, $versions_nr_install);
		$show_next_bd = false;
		$smarty->assign(
			array(
				//"version_info" => checking_onlineversion(),
				"install_version_info_header" =>$wrm_install_lang['install_version_info_header'],
				"form_action" => "install.php?lang=".$lang."&step=done",
				"upgrade_headtitle" => $wrm_install_lang['wrm_up_to_date'],
				"wrm_versions_nr_current_value" => $wrm_versions_nr_current_value,
				"wrm_versions_nr_current_text" => $wrm_install_lang['wrm_versions_nr_current_text'],
				"wrm_versions_nr_from_install_value" => $wrm_version, 
				"wrm_versions_nr_from_install_text" => $wrm_install_lang['wrm_versions_nr_from_install_text'],
				"bd_start" => $wrm_install_lang['bd_continue'],	
			)
		);
		$smarty->display("update.tpl.html");
		include_once ("includes/page_footer.php");
	}
	else
	{
		//upgrades
		show_online_versionnr($wrm_install_lang, $wrm_version);
		$smarty->assign(
			array(
			//	"version_info" => checking_onlineversion(),
				"install_version_info_header" =>$wrm_install_lang['install_version_info_header'],
				"form_action" => $filename_upgrade."step=1",
				"upgrade_headtitle" => $wrm_install_lang['upgrade_headtitle'],
				"wrm_versions_nr_current_value" => $wrm_versions_nr_current_value,
				"wrm_versions_nr_current_text" => $wrm_install_lang['wrm_versions_nr_current_text'],
				"wrm_versions_nr_from_install_value" => $wrm_version, 
				"wrm_versions_nr_from_install_text" => $wrm_install_lang['wrm_versions_nr_from_install_text'],
				"bd_start" => $wrm_install_lang['upgrade'],	
			)
		);
		$smarty->display("update.tpl.html");
		include_once ("includes/page_footer.php");
	}
}

/**
 * update from version ($wrm_update_array[ "current version"])
 * to the last version ($wrm_update_array[ "max" ]) from the array $wrm_update_array
 */
if ($step == "1")
{
	//load update infos
	include_once("database_schema/upgrade/update_files_conf.php");
	
	//connect to wrm server
	$wrm_install = create_db_connection($phpraid_config['db_host'],$phpraid_config['db_user'],$phpraid_config['db_pass'],$phpraid_config['db_name']);

	$wrm_update_array_y = 0;

	for ($i = 0; $i < count($wrm_update_array);$i++)
	{
		if ($wrm_update_array[$i]["update_to_version"] == $wrm_versions_nr_current_value)
		{
			$wrm_update_array_y = $i;
		}
	}
	
	//+1
	$wrm_update_array_y++;
	
	//update from version ($wrm_update_array[ "current version"])
	//to the last version ($wrm_update_array[ "max" ]) from the array $wrm_update_array
	//open sql file; do sql; close file;
	for ($wrm_update_array_y; $wrm_update_array_y < count($wrm_update_array); $wrm_update_array_y++)
	{

		if(!$fd = fopen($sql_dir_upgrade . $wrm_update_array[$wrm_update_array_y]["file_name"], 'r'))
				die('<font color=red>'.$localstr['step3errorschema'].'.</font>');
			
		if ($fd) {
			$sql = '';
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
	}
	
	//read new install version from wrm server
	$sql = "SELECT version_number FROM ".$phpraid_config['db_prefix']."version ORDER BY version_number DESC LIMIT 0,1";
	$result = $wrm_install->sql_query($sql) or print_error($sql, $wrm_install->sql_error(), 1);
	$data = $wrm_install->sql_fetchrow($result, true);
	$wrm_versions_nr_current_value = $data['version_number'];
	
	// write/replace the "../config.php" file
	write_wrm_configfile($phpraid_config['db_name'], $phpraid_config['db_host'], $phpraid_config['db_user'], $phpraid_config['db_pass'], $phpraid_config['db_prefix'],$phpraid_config['db_type']);
	
	//close wrm con.
	$wrm_install->sql_close();
	
	header("Location: ".$filename_upgrade."step=2");
}

/*
 * dynamic changes at bridge settings
 */
if ($step == "2")
{
	
	// read auth_type from wrm db
	$sql = 	sprintf("SELECT * "  .
					"FROM " . 	$phpraid_config['db_name'] . "." . $phpraid_config['db_prefix'] . "config " .
					"WHERE config_name = %s", quote_smart("auth_type"));								
	$result = $wrm_install->sql_query($sql) or print_error($sql, $wrm_install->sql_error(), 1);
	$data = $wrm_install->sql_fetchrow($result, true);
	
	//save result (bridge name) in $bridge_name
	$bridge_name = $data['config_value'];
	
	include_once("auth/install_".$bridge_name.".php");
	$bridge_setting = $bridge_setting_value;
	
	$install_version_number = get_WRM_Version_Number();
	
	// update_version_nr <= 4.0.0
	if ( ($install_version_number[0] < "4") or (($install_version_number[0] == "4") and ($install_version_number[1] == "0")) )
	{
		/**
		 * read old table_prefix value
		 * (variables not exist before)
		 * add $bridge_name . _db_name
		 * add $bridge_name . _table_prefix
		 * add $bridge_name . _utf8_support
		 */
		
		/**
		 * test for old table settings prefix
		 * before < 4.1.0
		 * two much different name for this variablename 
		 * (no problems) e107_table_prefix,joomla_table_prefix,smf_table_prefix (v1),wbb_table_prefix,xoops_table_prefix
		 * 
		 * (wrong bringname) smf_table_prefix(v2),
		 * (wrong bringname + fail "_table_") phpbb_prefix(v2),phpbb_prefix (v3), 
		 * (all wrong) db_prefix (iums)
		 * 
		 * over > 4.1.0
		 * $bridge_name . _table_prefix
		 */
		$auth_type = $phpraid_config['auth_type'];

		// Auth/Bridge Type: iums		
		if ($auth_type == "iums")
		{
			$sql = 	sprintf("SELECT * "  .
							"FROM " . $phpraid_config['db_prefix'] . "config " .
							"WHERE config_name = %s", quote_smart("db_prefix"));			
		}
		
		// Auth/Bridge Type: phpbb, phpbb3
		else if (($auth_type == "phpbb") or ($auth_type == "phpbb3"))
		{
			$sql = 	sprintf("SELECT * "  .
							"FROM " . $phpraid_config['db_prefix'] . "config " .
							" WHERE config_name = %s", quote_smart("phpbb_prefix"));			
		}
		
		// Auth/Bridge Type: smf2
		else if ($auth_type == "smf2")
		{
			$sql = 	sprintf("SELECT * "  .
							"FROM " . $phpraid_config['db_prefix'] . "config " .
							"WHERE config_name = %s", quote_smart("smf_table_prefix"));			
		}
		else
		{
			echo "unknown Bridge";
		}
		
		$result = $wrm_install->sql_query($sql) or print_error($sql, $wrm_install->sql_error(), 1);
		$data = $wrm_install->sql_fetchrow($result, true);
		//$data['config_value']) == old "table prefix" value
		
		//if format == databasename.database_table_prefix split
		// => $bridge_db_name and $bridge_table_prefix
		if (($tmp_prefix = explode('.', $data['config_value'])) != false)
		{
			$bridge_db_name = $tmp_prefix[0];
			$bridge_table_prefix = $tmp_prefix[1];
		}
		else 
		{
			$bridge_db_name = "";
			$bridge_table_prefix = $data['config_value'];			
		}
		
		/*
		 * $bridge_name . _db_name
		 */
		$sql = sprintf(	"INSERT INTO " . $phpraid_config['db_prefix'] . "config ".
						"VALUES(%s,%s)", quote_smart($bridge_name . "_db_name"), quote_smart($bridge_db_name));
		$wrm_install->sql_query($sql) or print_error($sql, $wrm_install->sql_error(), 1);
		
		/*
		 * $bridge_name . _table_prefix
		 */	
		$sql = sprintf(	"INSERT INTO " . $phpraid_config['db_prefix'] . "config ".
						"VALUES(%s,%s)", 
						quote_smart($bridge_name . "_table_prefix"), quote_smart($bridge_table_prefix));
		$wrm_install->sql_query($sql) or print_error($sql, $wrm_install->sql_error(), 1);
			
		/*
		 * $bridge_name . _utf8_support
		 */
		$sql = sprintf(	"INSERT INTO " . $phpraid_config['db_prefix'] . "config ".
						"VALUES(%s,%s)", quote_smart($bridge_name . "_utf8_support"), quote_smart($bridge_setting['bridge_utf8_support'])
				);
		$wrm_install->sql_query($sql) or print_error($sql, $wrm_install->sql_error(), 1);
	}

	//_auth_user_group
	$sql = 	sprintf("SELECT * "  .
					"FROM " . $phpraid_config['db_prefix'] . "config " .
					" WHERE  config_name = %s", quote_smart($bridge_name."_auth_user_group"));
	$wrm_install->sql_query($sql) or print_error($sql, $wrm_install->sql_error(), 1);
	if ($wrm_install->sql_numrows() == 0)
	{
		$sql = sprintf(	"INSERT INTO " . $phpraid_config['db_prefix'] . "config ".
						"VALUES(%s,%s)", quote_smart($bridge_name . "_auth_user_group"), quote_smart("0"));
		$wrm_install->sql_query($sql) or print_error($sql, $wrm_install->sql_error(), 1);
	}
	
	//_alt_auth_user_class
	$sql = 	sprintf("SELECT * "  .
				"FROM " . 	$phpraid_config['db_name'] . "." . $phpraid_config['db_prefix'] . "config " .
				"WHERE config_name = %s", quote_smart($bridge_name."_alt_auth_user_class"));
	$wrm_install->sql_query($sql) or print_error($sql, $wrm_install->sql_error(), 1);
	if ($wrm_install->sql_numrows() == 0)
	{	
		$sql = sprintf(	"INSERT INTO " . $phpraid_config['db_prefix'] . "config ".
						"VALUES(%s,%s)", quote_smart($bridge_name . "_alt_auth_user_class"), quote_smart("0"));
		$wrm_install->sql_query($sql) or print_error($sql, $wrm_install->sql_error(), 1);
	}

	//close wrm con.
	$wrm_install->sql_close();
		
	header("Location: ".$filename_upgrade."step=3");
}

/*
 * dynamic changes at wrm
 * wrm_updated_on and if not exist insert wrm_created_on (<wrm 4.1)
 */
if ($step == "3")
{
	//$wrm_install = &new sql_db($phpraid_config['db_host'], $phpraid_config['db_user'], $phpraid_config['db_pass'], $phpraid_config['db_name']);
	
	$sql = 	sprintf("SELECT * "  .
					"FROM " . 	$phpraid_config['db_name'] . "." . $phpraid_config['db_prefix'] . "config " .
					"WHERE config_name = %s", quote_smart("wrm_created_on"));
	$wrm_install->sql_query($sql) or print_error($sql, $wrm_install->sql_error(), 1);
	$data = $wrm_install->sql_fetchrow($result, true);
	if ($wrm_install->sql_numrows() == 0)
	{
		$sql = sprintf(	"INSERT INTO " . $phpraid_config['db_prefix'] . "config ".
						"VALUES(%s,%s)", quote_smart("wrm_created_on"), quote_smart(time()));
		$wrm_install->sql_query($sql) or print_error($sql, $wrm_install->sql_error(), 1);
		$sql = sprintf(	"INSERT INTO " . $phpraid_config['db_prefix'] . "config ".
						"VALUES(%s,%s)", quote_smart("wrm_updated_on"), quote_smart(time())
				);
		$wrm_install->sql_query($sql) or print_error($sql, $wrm_install->sql_error(), 1);
	}
	else
	{
		$sql = 	sprintf("UPDATE " . $phpraid_config['db_prefix'] . "config " .
						"SET config_value = %s WHERE config_name = 'wrm_updated_on'", quote_smart(time()));
		$wrm_install->sql_query($sql) or print_error($sql, $wrm_install->sql_error(), 1);
	}
	
	//close wrm con.
	$wrm_install->sql_close();
	
	header("Location: ".$filename_upgrade."step=update_done");
}

//show page
if ($step == "update_done")
{
	write_wrm_configfile($phpraid_config['db_name'], $phpraid_config['db_host'], $phpraid_config['db_user'],
						 $phpraid_config['db_pass'], $phpraid_config['db_prefix'], $phpraid_config['db_type'],
						 $phpraid_config['eqdkp_db_name'], $phpraid_config['eqdkp_db_host'] , $phpraid_config['eqdkp_db_user'] ,
						 $phpraid_config['eqdkp_db_pass'] , $phpraid_config['eqdkp_db_prefix'],
						 $phpraid_config['wrm_db_utf8_support'],$phpraid_config['wrm_mbstring_support']
	);
	
	include_once ("includes/page_header.php");
	$smarty->assign(
		array(
			"form_action" => "install.php?lang=".$lang."&step=done",
			"upgrade_headtitle" => $wrm_install_lang['upgrade_headtitle'],
			"wrm_versions_nr_current_value" => $wrm_versions_nr_current_value,
			"wrm_versions_nr_current_text" => $wrm_install_lang['wrm_versions_nr_current_text'],
			"wrm_versions_nr_from_install_value" => $wrm_version, 
			"wrm_versions_nr_from_install_text" => $wrm_install_lang['wrm_versions_nr_from_install_text'],
			"bd_start" => $wrm_install_lang['bd_submit'],	
		)
	);
	$smarty->display("update.tpl.html");
	include_once ("includes/page_footer.php");
}

?>