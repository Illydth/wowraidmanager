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
if($phpraid_config['enable_armory'] == '0')
	$enable_armory = '<input type="checkbox" name="enable_armory" value="1">';
else
	$enable_armory = '<input type="checkbox" name="enable_armory" value="1" checked>';

// Integrate with EqDKP
if($phpraid_config['enable_eqdkp'] == '0')
	$enable_eqdkp = '<input type="checkbox" name="enable_eqdkp" value="1">';
else
	$enable_eqdkp = '<input type="checkbox" name="enable_eqdkp" value="1" checked>';

// URL to Base of EqDKP Installation
$eqdkp_url='<input name="eqdkp_url" type="text" value="'.$phpraid_config['eqdkp_url'].'" size="60" class="post">';

// Armory Cache Setting
$armory_cache = '<select name="armory_cache" class="post">';
if ($phpraid_config['armory_cache_setting'] == 'database')
	$armory_cache .=   '<option value="database" selected>'.$phprlang['configuration_armory_cache_database'].'</option>';
else
	$armory_cache .=   '<option value="database">'.$phprlang['configuration_armory_cache_database'].'</option>';
if ($phpraid_config['armory_cache_setting'] == 'file')
	$armory_cache .=   '<option value="file" selected>'.$phprlang['configuration_armory_cache_files'].'</option>';
else
	$armory_cache .=   '<option value="file">'.$phprlang['configuration_armory_cache_files'].'</option>';
if ($phpraid_config['armory_cache_setting'] == 'none')
	$armory_cache .=   '<option value="none" selected>'.$phprlang['configuration_armory_cache_none'].'</option>';
else 
	$armory_cache .=   '<option value="none">'.$phprlang['configuration_armory_cache_none'].'</option>';
$armory_cache .= '</select>';

// Integrate with WoW Roster
//if($phpraid_config['roster_integration'] == '0')
//	$roster = '<input type="checkbox" name="roster" value="1">';
//else
//	$roster = '<input type="checkbox" name="roster" value="1" checked>';

$buttons = '<input type="submit" name="submit" value="'.$phprlang['submit'].'" class="mainoption"> <input type="reset" name="Reset" value="'.$phprlang['reset'].'" class="liteoption">';

/**
 * Bridge Config
 */

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

$wrmadminsmarty->assign('config_data',
	array(
		'enable_armory' => $enable_armory,
		'enable_armory_text' => $phprlang['configuration_armory_enable'],
		'enable_eqdkp' => $enable_eqdkp,
		'enable_eqdkp_text' => $phprlang['configuration_eqdkp_integration_text'],
		'eqdkp_url' => $eqdkp_url,
		'eqdkp_url_text' => $phprlang['configuration_eqdkp_link'],
		'external_links_header'=>$phprlang['configuration_external_links_header'],
		//'roster' => $roster,
		//'roster_text' => $phprlang['configuration_roster_text'],
		'armory_cache' => $armory_cache,
		'armory_cache_text'=>$phprlang['configuration_armory_cache'],
		'buttons' => $buttons,
	
		'show_chang_group_conf' => "1",
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
