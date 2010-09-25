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
// Enable Armory Lookups
if($phpraid_config['enable_armory'] == '1')
	$enable_armory = 'checked';

// Integrate with EqDKP
if($phpraid_config['enable_eqdkp'] == '1')
	$enable_eqdkp = 'checked';

/**
 * Armory Cache Setting
 */
$array_armory_cache = array();
$array_armory_cache['database'] = $phprlang['configuration_armory_cache_database'];
$array_armory_cache['file'] = $phprlang['configuration_armory_cache_files'];
$array_armory_cache['none'] = $phprlang['configuration_armory_cache_none'];

if ($phpraid_config['armory_cache_setting'] == 'database')
	$selected_armory_code = 'database';
elseif ($phpraid_config['armory_cache_setting'] == 'file')
	$selected_armory_code = 'file';
elseif ($phpraid_config['armory_cache_setting'] == 'none')
	$selected_armory_code = 'none';
	
/**
 * Bridge Config
 */
$show_bridge_config = TRUE;
if (($phpraid_config[$phpraid_config['auth_type']."_auth_user_class"]) != "")
{
	$bridge_array = array();
	$bridge_array_group = $bridge_array_alt_group = get_group_array();
	
	$bridge_array_group[0] =  $phprlang['configuration_extsys_norest'];
	$bridge_array_alt_group[0] =  $phprlang['configuration_extsys_noaddus'];
	
	$selected_group_id = 0;
	$selected_alt_group_id = 0;
	
	$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "config";
	
	$result_group = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	while ($data_wrm = $db_raid->sql_fetchrow($result_group,true))
	{
		if ($data_wrm['config_name'] == $phpraid_config['auth_type']."_auth_user_class") 
			$selected_group_id = $data_wrm['config_value'];
			
		if ($data_wrm['config_name'] == $phpraid_config['auth_type']."_alt_auth_user_class") 
			$selected_alt_group_id = $data_wrm['config_value'];
	}
}
else 
{
	$show_bridge_config = FALSE;
}
$wrmadminsmarty->assign('config_data',
	array(
		'enable_armory' => $enable_armory,
		'enable_armory_text' => $phprlang['configuration_armory_enable'],
		'enable_eqdkp' => $enable_eqdkp,
		'enable_eqdkp_text' => $phprlang['configuration_eqdkp_integration_text'],
		// URL to Base of EqDKP Installation
		'eqdkp_url' => $phpraid_config['eqdkp_url'],
		'eqdkp_url_text' => $phprlang['configuration_eqdkp_link'],
		'external_links_header'=>$phprlang['configuration_external_links_header'],
		//'roster' => $roster,
		//'roster_text' => $phprlang['configuration_roster_text'],
		'array_armory_cache' => $array_armory_cache,
		'selected_armory_code' => $selected_armory_code,
		'armory_cache_text'=>$phprlang['configuration_armory_cache'],

		'button_submit' => $phprlang['submit'],
		'button_reset' => $phprlang['reset'],
	
		'show_bridge_config' => $show_bridge_config,
		'configuration_extsys_bridge_config_header' => $phprlang['configuration_extsys_bridge_config_header'],
		'configuration_extsys_norest' => $phprlang['configuration_extsys_norest'],
		'configuration_extsys_noaddus' => $phprlang['configuration_extsys_noaddus'],
		'configuration_extsys_group01' => $phprlang['configuration_extsys_group01'],
		'configuration_extsys_group02' => $phprlang['configuration_extsys_group02'],
		'configuration_extsys_group03' => $phprlang['configuration_extsys_group03'],
		'configuration_extsys_alt_group01' => $phprlang['configuration_extsys_alt_group01'],
		'configuration_extsys_alt_group02' => $phprlang['configuration_extsys_alt_group02'],
		'configuration_extsys_group_text' => $phprlang['configuration_extsys_group_text'],
		'configuration_extsys_alt_group_text' => $phprlang['configuration_extsys_alt_group_text'],
		'array_group' => $bridge_array_group,
		'selected_group_id' => $selected_group_id,
		'array_alt_group' => $bridge_array_alt_group,
		'selected_alt_group_id' => $selected_alt_group_id,
	)
);

if(isset($_POST['submit']))
{	
	if(isset($_POST['enable_armory']))
 		$enable_armory = 1;
 	else
 		$enable_armory = 0;

 	if(isset($_POST['enable_eqdkp']))
 		$enable_eqdkp = 1;
 	else
 		$enable_eqdkp = 0;
 
 	$eqdkp_url = scrub_input($_POST['eqdkp_url'], true);
 	$armory_cache = scrub_input($_POST['armory_cache']);
 	
 	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'enable_armory';", quote_smart($enable_armory));
	$db_raid->sql_query($sql) or print_error($sql,$db_raid->sql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'enable_eqdkp';", quote_smart($enable_eqdkp));
	$db_raid->sql_query($sql) or print_error($sql,$db_raid->sql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'eqdkp_url';", quote_smart($eqdkp_url));
	$db_raid->sql_query($sql) or print_error($sql,$db_raid->sql_error(),1);
 	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'armory_cache_setting';", quote_smart($armory_cache));
	$db_raid->sql_query($sql) or print_error($sql,$db_raid->sql_error(),1);

 	if(isset($_POST['configuration_extsys_group']))
 	{
 		$bridge_selected_group_id = scrub_input($_POST['configuration_extsys_group']);
 		$bridge_selected_alt_group_id = scrub_input($_POST['configuration_extsys_alt_group']);

 		change_bridge_groups($bridge_selected_group_id, $bridge_selected_alt_group_id);
 	}
 	
	header("Location: admin_externcfg.php");
}
//
// Start output of the page.
//
require_once('./includes/admin_page_header.php');
$wrmadminsmarty->display('admin_external_systems.html');
require_once('./includes/admin_page_footer.php');

?>
