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

$pageURL = "admin_externcfg.php";

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
	

$wrmadminsmarty->assign('config_data',
	array(
		'form_action' => $pageURL,
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
	)
);

if(isset($_POST['submit']))
{	
	if(isset($_POST['enable_armory']))
 		$enable_armory = 1;
 	else
 		$enable_armory = 0;

 	if(isset($_POST['enable_eqdkp']))
 	{
 		$enable_eqdkp = 1;
 		//enable link visible
 		$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."menu_value` SET `visible` = %s WHERE `menu_value_id` = 43;", quote_smart("1"));
		$db_raid->sql_query($sql) or print_error($sql,$db_raid->sql_error(),1);
 	}
 	else
 	{
 		$enable_eqdkp = 0;
 		//disable link (visible)
 		$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."menu_value` SET `visible` = %s WHERE `menu_value_id` = 43;", quote_smart("0"));
		$db_raid->sql_query($sql) or print_error($sql,$db_raid->sql_error(),1);
 	}
 
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

 	
	header("Location: " . $pageURL);
}

//
// Start output of the page.
//
require_once('./includes/admin_page_header.php');
$wrmadminsmarty->display('admin_external_systems.html');
require_once('./includes/admin_page_footer.php');

?>