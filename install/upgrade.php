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


//set Lang. Format
if (!isset($_GET['lang']))
	$lang = "english";
else
	$lang = $_GET['lang'];

/*----------------------------------------------------------------*/

/**
 * Name from this File
 */
$filename_upgrade = "upgrade.php?lang=".$lang."&";

/**
 *  VersionNR, from this wrm Install File
 */
include_once("../version.php");
$versions_nr_install = $version;

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

/*----------------------------------------------------------------*/

include_once('language/locale-'.$lang.'.php');

include_once ("includes/db/db.php");
include_once ("includes/function.php");

include_once("../config.php");

/*----------------------------------------------------------------*/

//connect 2 wrm server
$wrm_install = &new sql_db($phpraid_config['db_host'],$phpraid_config['db_user'],$phpraid_config['db_pass'],$phpraid_config['db_name']);
if($wrm_install->db_connect_id == FALSE)
{
	header("Location: install.php");
}


//check if table "version" available
//result ($table_version_available)
//true -> from 3.5.0 to 4.x.x
//false -> older 3.5.0
$sql_tables = "SHOW TABLES FROM ".$phpraid_config['db_name'];
$result_tables = $wrm_install->sql_query($sql_tables) or print_error($sql_tables, $wrm_install->sql_error(), 1);
while ($data_tables = $wrm_install->sql_fetchrow($result_tables,true))
{
	if ($phpraid_config['db_prefix']."_".$data_tables["Tables_in_version"])
	{
		$table_version_available = TRUE;
	}
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
	//older 3.5.0 and older 3.6.1 not support 
	if (($table_version_available == FALSE) or ((str_replace(".","",$wrm_versions_nr_current_value)) < "361"))
	{
		include_once ("includes/page_header.php");
		schow_online_versionnr();
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
	else if ($wrm_versions_nr_current_value == $versions_nr_install)
	{
		// "your wrm is up to date";		
		include_once ("includes/page_header.php");
		schow_online_versionnr();
		$smarty->assign(
			array(
				//"version_info" => checking_onlineversion(),
				"install_version_info_header" =>$wrm_install_lang['install_version_info_header'],
				"form_action" => "install.php?lang=".$lang."&step=done",
				"upgrade_headtitle" => $wrm_install_lang['wrm_up_to_date'],
				"wrm_versions_nr_current_value" => $wrm_versions_nr_current_value,
				"wrm_versions_nr_current_text" => $wrm_install_lang['wrm_versions_nr_current_text'],
				"wrm_versions_nr_from_install_value" => $versions_nr_install, 
				"wrm_versions_nr_from_install_text" => $wrm_install_lang['wrm_versions_nr_from_install_text'],
				"bd_start" => $wrm_install_lang['bd_submit'],	
			)
		);
		$smarty->display("update.tpl.html");
		include_once ("includes/page_footer.php");
	}
	else
	{
		//upgrade
		include_once ("includes/page_header.php");
		schow_online_versionnr();
		$smarty->assign(
			array(
			//	"version_info" => checking_onlineversion(),
				"install_version_info_header" =>$wrm_install_lang['install_version_info_header'],
				"form_action" => $filename_upgrade."step=1",
				"upgrade_headtitle" => $wrm_install_lang['upgrade_headtitle'],
				"wrm_versions_nr_current_value" => $wrm_versions_nr_current_value,
				"wrm_versions_nr_current_text" => $wrm_install_lang['wrm_versions_nr_current_text'],
				"wrm_versions_nr_from_install_value" => $versions_nr_install, 
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
if ($step == 1)
{
	//load update infos
	include_once("database_schema/upgrade/update_files_conf.php");
	
	//connect to wrm server
	//$wrm_install = &new sql_db($phpraid_config['db_host'],$phpraid_config['db_user'],$phpraid_config['db_pass'],$phpraid_config['db_name']);

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
if ($step == 2)
{
	//$wrm_install = &new sql_db($phpraid_config['db_host'],$phpraid_config['db_user'],$phpraid_config['db_pass'],$phpraid_config['db_name']);
	
	// update bridge setting only if not exist
	
	// read auth_type from wrm db
	$sql = 	sprintf("SELECT * "  .
					" FROM " . 	$phpraid_config['db_name'] . "." . $phpraid_config['db_prefix'] . "config" .
					" WHERE  %s = `config_name`", quote_smart("auth_type")
			);								
	$result = $wrm_install->sql_query($sql) or print_error($sql, $wrm_install->sql_error(), 1);
	$data = $wrm_install->sql_fetchrow($result, true);
	
	//save result (bridge name) in $bridge_name
	$bridge_name = $data['config_value'];
	
	include_once("auth/install_".$bridge_name.".php");
	$bridge_setting = $bridge_setting_value;
	
	
	$sql = 	sprintf("SELECT * "  .
					" FROM " . 	$phpraid_config['db_name'] . "." . $phpraid_config['db_prefix'] . "config" .
					" WHERE  `%s` = %s", "config_name", quote_smart($bridge_name."_table_prefix")
			);
	$result = $wrm_install->sql_query($sql) or print_error($sql, $wrm_install->sql_error(), 1);
	$data = $wrm_install->sql_fetchrow($result, true);
	if ($wrm_install->sql_numrows() == 0 or $data['config_value'] == "")
	{
		//test for old table settings
		$where_text = "`config_name` = ".quote_smart($bridge_name."_table_prefix");
		
		//only for the phpbb2/3 bridge
		if ($bridge_name == "phpbb" or $bridge_name == "phpbb3")
		{
			$where_text = "`config_name` = 'phpbb_prefix' OR `config_name` = 'phpbb3_prefix' ";//OR `config_name` = '".$bridge_name."_table_prefix' ";
		}
		$sql = 	sprintf("SELECT * "  .
						" FROM " . 	$phpraid_config['db_name'] . "." . $phpraid_config['db_prefix'] . "config" .
						" WHERE ".$where_text
				);
		$result = $wrm_install->sql_query($sql) or print_error($sql, $wrm_install->sql_error(), 1);
		$data = $wrm_install->sql_fetchrow($result, true);
		$tmp_prefix = explode('.', $data['config_value']);
		
		$bridge_db_name = $tmp_prefix[0];
		$bridge_table_prefix = $tmp_prefix[1];
		
		/*
		 * $bridge_name . _table_prefix
		 */
		$sql = 	sprintf("SELECT * "  .
						" FROM " . 	$phpraid_config['db_name'] . "." . $phpraid_config['db_prefix'] . "config" .
						" WHERE  `%s` = %s", "config_name", quote_smart($bridge_name . "_table_prefix")
				);
		$wrm_install->sql_query($sql) or print_error($sql, $wrm_install->sql_error(), 1);
		if ($wrm_install->sql_numrows() != 0 and $data['config_value'] != "")
		{
			$sql = 	sprintf("UPDATE " . $phpraid_config['db_name'] . "." . $phpraid_config['db_prefix'] . "config" .
							" SET `config_value` = %s WHERE %s = `config_name`", quote_smart($data['config_value']), quote_smart($bridge_name . "_table_prefix"));
			$wrm_install->sql_query($sql) or print_error($sql, $wrm_install->sql_error(), 1);
		}
		else if ($wrm_install->sql_numrows() != 0 and $data['config_value'] == "")
		{
			$sql = 	sprintf("UPDATE " . $phpraid_config['db_name'] . "." . $phpraid_config['db_prefix'] . "config" .
							" SET `config_value` = %s WHERE %s = `config_name`", quote_smart($bridge_table_prefix), quote_smart($bridge_name . "_table_prefix"));
			$wrm_install->sql_query($sql) or print_error($sql, $wrm_install->sql_error(), 1);
		}		
		else
		{	
			$sql = sprintf(	"INSERT INTO " . $phpraid_config['db_prefix'] . "config".
							" VALUES(%s,%s)", quote_smart($bridge_name . "_table_prefix"), quote_smart($bridge_table_prefix)
					);
			$wrm_install->sql_query($sql) or print_error($sql, $wrm_install->sql_error(), 1);
		}
		
		/*
		 * $bridge_name . _db_name
		 */
		$sql = 	sprintf("SELECT * "  .
						" FROM " . 	$phpraid_config['db_name'] . "." . $phpraid_config['db_prefix'] . "config" .
						" WHERE  `%s` = %s", "config_name", quote_smart($bridge_name . "_db_name")
				);
		$wrm_install->sql_query($sql) or print_error($sql, $wrm_install->sql_error(), 1);
		$data = $wrm_install->sql_fetchrow($result, true);
		if ($wrm_install->sql_numrows() != 0 and $data['config_value'] != "")
		{
			$sql = 	sprintf("UPDATE " . $phpraid_config['db_name'] . "." . $phpraid_config['db_prefix'] . "config" .
							" SET `config_value` = %s WHERE %s = `config_name`", quote_smart($data['config_value']), quote_smart($bridge_name . "_db_name"));
			$wrm_install->sql_query($sql) or print_error($sql, $wrm_install->sql_error(), 1);
		}
		else if ($wrm_install->sql_numrows() != 0 and $data['config_value'] == "")
		{
			$sql = 	sprintf("UPDATE " . $phpraid_config['db_name'] . "." . $phpraid_config['db_prefix'] . "config" .
							" SET `config_value` = %s WHERE %s = `config_name`", quote_smart($bridge_db_name), quote_smart($bridge_name . "_db_name"));
			$wrm_install->sql_query($sql) or print_error($sql, $wrm_install->sql_error(), 1);
		}
		else
		{
			$sql = sprintf(	"INSERT INTO " . $phpraid_config['db_prefix'] . "config".
							" VALUES(%s,%s)", quote_smart($bridge_name . "_db_name"), quote_smart($bridge_db_name)
					);
			$wrm_install->sql_query($sql) or print_error($sql, $wrm_install->sql_error(), 1);	
		}
		
		/*
		 * $bridge_name . _utf8_support
		 */
		$sql = 	sprintf("SELECT * "  .
						" FROM " . 	$phpraid_config['db_name'] . "." . $phpraid_config['db_prefix'] . "config" .
						" WHERE  `%s` = %s", "config_name", quote_smart($bridge_name . "_utf8_support")
				);
		$wrm_install->sql_query($sql) or print_error($sql, $wrm_install->sql_error(), 1);
		$data = $wrm_install->sql_fetchrow($result, true);
		if ($wrm_install->sql_numrows() == 0)
		{
			$sql = sprintf(	"INSERT INTO " . $phpraid_config['db_prefix'] . "config".
							" VALUES(%s,%s)", quote_smart($bridge_name . "_utf8_support"), quote_smart($bridge_setting['bridge_utf8_support'])
					);
			$wrm_install->sql_query($sql) or print_error($sql, $wrm_install->sql_error(), 1);
		}
		else
		{
			$sql = 	sprintf("UPDATE " . $phpraid_config['db_name'] . "." . $phpraid_config['db_prefix'] . "config" .
							" SET `config_value` = %s WHERE %s = `config_name`", quote_smart($bridge_setting['bridge_utf8_support']), quote_smart($bridge_name . "_utf8_support"));
			$wrm_install->sql_query($sql) or print_error($sql, $wrm_install->sql_error(), 1);
		}	
	}

	//_auth_user_group
	$sql = 	sprintf("SELECT * "  .
					" FROM " . 	$phpraid_config['db_name'] . "." . $phpraid_config['db_prefix'] . "config" .
					" WHERE  `%s` = %s", ("config_name"), quote_smart($bridge_name."_auth_user_group")
			);
	$wrm_install->sql_query($sql) or print_error($sql, $wrm_install->sql_error(), 1);
	if ($wrm_install->sql_numrows() == 0)
	{
		$sql = sprintf(	"INSERT INTO " . $phpraid_config['db_prefix'] . "config".
						" VALUES(%s,%s)", quote_smart($bridge_name . "_auth_user_group"), quote_smart("0")
				);
	$wrm_install->sql_query($sql) or print_error($sql, $wrm_install->sql_error(), 1);
	}
	
	//_alt_auth_user_class
	$sql = 	sprintf("SELECT * "  .
				" FROM " . 	$phpraid_config['db_name'] . "." . $phpraid_config['db_prefix'] . "config" .
				" WHERE  `%s` = %s", ("config_name"), quote_smart($bridge_name."_alt_auth_user_class")
		);
	$wrm_install->sql_query($sql) or print_error($sql, $wrm_install->sql_error(), 1);
	if ($wrm_install->sql_numrows() == 0)
	{	
		$sql = sprintf(	"INSERT INTO " . $phpraid_config['db_prefix'] . "config".
						" VALUES(%s,%s)", quote_smart($bridge_name . "_alt_auth_user_class"), quote_smart("0")
				);
	$wrm_install->sql_query($sql) or print_error($sql, $wrm_install->sql_error(), 1);

	}
	//--------------------------------------------------------------------------------------------------------

	//close wrm con.
	$wrm_install->sql_close();
		
	header("Location: ".$filename_upgrade."step=3");
}

/*
 * dynamic changes at wrm
 */
if ($step == 3)
{
	//$wrm_install = &new sql_db($phpraid_config['db_host'], $phpraid_config['db_user'], $phpraid_config['db_pass'], $phpraid_config['db_name']);
	
	$sql = 	sprintf("SELECT * "  .
					" FROM " . 	$phpraid_config['db_name'] . "." . $phpraid_config['db_prefix'] . "config" .
					" WHERE  `%s` = %s", "config_name", quote_smart("wrm_created_on")
			);
	$wrm_install->sql_query($sql) or print_error($sql, $wrm_install->sql_error(), 1);
	$data = $wrm_install->sql_fetchrow($result, true);
	if ($wrm_install->sql_numrows() == 0)
	{
		$sql = sprintf(	"INSERT INTO " . $phpraid_config['db_prefix'] . "config".
						" VALUES(%s,%s)", quote_smart("wrm_created_on"), quote_smart(time())
				);
		$wrm_install->sql_query($sql) or print_error($sql, $wrm_install->sql_error(), 1);
		$sql = sprintf(	"INSERT INTO " . $phpraid_config['db_prefix'] . "config".
						" VALUES(%s,%s)", quote_smart("wrm_updated_on"), quote_smart(time())
				);
		$wrm_install->sql_query($sql) or print_error($sql, $wrm_install->sql_error(), 1);
	}
	else
	{
		$sql = 	sprintf("UPDATE " . $phpraid_config['db_name'] . "." . $phpraid_config['db_prefix'] . "config" .
						" SET `config_value` = %s WHERE %s = `config_name`", quote_smart(time()), quote_smart("wrm_updated_on"));
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
						 $phpraid_config['eqdkp_db_pass'] , $phpraid_config['eqdkp_db_prefix']
	);
	
	include_once ("includes/page_header.php");
	$smarty->assign(
		array(
			"form_action" => "install.php?lang=".$lang."&step=done",
			"upgrade_headtitle" => $wrm_install_lang['upgrade_headtitle'],
			"wrm_versions_nr_current_value" => $wrm_versions_nr_current_value,
			"wrm_versions_nr_current_text" => $wrm_install_lang['wrm_versions_nr_current_text'],
			"wrm_versions_nr_from_install_value" => $versions_nr_install, 
			"wrm_versions_nr_from_install_text" => $wrm_install_lang['wrm_versions_nr_from_install_text'],
			"bd_start" => $wrm_install_lang['bd_submit'],	
		)
	);
	$smarty->display("update.tpl.html");
	include_once ("includes/page_footer.php");
}

?>