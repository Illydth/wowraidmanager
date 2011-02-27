<?php
/***************************************************************************
 *                             admin_auth_cfg.php
 *                            -------------------
 *   begin                : Feb 27, 2011
 *	 Dev                  : Carsten Hölbing
 *	 email                : carsten@hoelbing.net
 *
 *   -- WoW Raid Manager --
 *   copyright            : (C) 2007-2011 Douglas Wagner
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

// commons
define("IN_PHPRAID", true);	
require_once('./admin_common.php');

/*************************************************
 * Access Authorization Section
 *************************************************/
// page authentication
define("PAGE_LVL","configuration");
require_once("../includes/authentication.php");	

$pageURL = "admin_auth_cfg.php";

/* 
 * Data for Index Page
 */
	
/**
 * Bridge Config
 */
$show_bridge_config = TRUE;
if (($phpraid_config[$phpraid_config['auth_type']."_auth_user_class"]) != "")
{
	$bridge_array = array();
	$bridge_array_group = $bridge_array_alt_group = get_group_array();
	$default_bridge_value = "-1";
	
	$bridge_array_group[$default_bridge_value] =  $phprlang['configuration_extsys_norest'];
	$bridge_array_alt_group[$default_bridge_value] =  $phprlang['configuration_extsys_noaddus'];
	
	$selected_group_id = $phpraid_config[$phpraid_config['auth_type'].'_auth_user_class'];
	$selected_alt_group_id = $phpraid_config[$phpraid_config['auth_type'].'_alt_auth_user_class'];
	
/*	$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "config";
	
	$result_group = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	while ($data_wrm = $db_raid->sql_fetchrow($result_group,true))
	{
		if ($data_wrm['config_name'] == $phpraid_config['auth_type']."_auth_user_class") 
			$selected_group_id = $data_wrm['config_value'];
			
		if ($data_wrm['config_name'] == $phpraid_config['auth_type']."_alt_auth_user_class") 
			$selected_alt_group_id = $data_wrm['config_value'];
	}
	*/
}
else 
{
	$show_bridge_config = FALSE;
}
$wrmadminsmarty->assign('config_data',
	array(
		'form_action' => $pageURL,
		'auth_header' => $phprlang['configuration_auth_header'],
		'auth_info_header' => $phprlang['configuration_auth_info_header'],
		'auth_system_text' => $phprlang['configuration_auth_system_text'],
		'auth_system_value' => $phpraid_config['auth_type'],
		'auth_db_name_text' => $phprlang['db_name_text'],
		'auth_db_name_value' =>$phpraid_config[$phpraid_config['auth_type'].'_db_name'],
		'auth_db_table_prefix_text' => $phprlang['db_prefix_text'],
		'auth_db_table_prefix_value' => $phpraid_config[$phpraid_config['auth_type'].'_table_prefix'],

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

 	if(isset($_POST['configuration_extsys_group']))
 	{
 		$bridge_selected_group_id = scrub_input($_POST['configuration_extsys_group']);
 		$bridge_selected_alt_group_id = scrub_input($_POST['configuration_extsys_alt_group']);

 		change_bridge_groups($bridge_selected_group_id, $bridge_selected_alt_group_id);
 	}
 	
	header("Location: " . $pageURL);
}

//
// Start output of the page.
//
require_once('./includes/admin_page_header.php');
$wrmadminsmarty->display('admin_auth_cfg.html');
require_once('./includes/admin_page_footer.php');

?>