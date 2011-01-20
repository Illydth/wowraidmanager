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

$page_url = "admin_generalcfg.php";

/* 
 * Data for Index Page
 */
if($phpraid_config['disable'] == '0')
	$disable_site = '<input type="checkbox" name="disable" value="1">';
else
	$disable_site = '<input type="checkbox" name="disable" value="1" checked>';

if($phpraid_config['debug'] == '0')
	$debug_mode = '<input type="checkbox" name="debug" value="1" disabled> (disabled)';
else
	$debug_mode = '<input type="checkbox" name="debug" value="1" disabled checked> (disabled)';

if($phpraid_config['showphpraid_addon'] == '0')
	$showphpraid_addon = '<input type="checkbox" name="showphpraid_addon" value="1">';
else
	$showphpraid_addon = '<input type="checkbox" name="showphpraid_addon" value="1" checked>';

if($phpraid_config['enable_five_man'] == '0')
	$enable_five_man = '<input type="checkbox" name="enable_five_man" value="1">';
else
	$enable_five_man = '<input type="checkbox" name="enable_five_man" value="1" checked>';

if($phpraid_config['persistent_db'] == '0')
	$persistent_db = '<input type="checkbox" name="persistent_db" value="1">';
else
	$persistent_db = '<input type="checkbox" name="persistent_db" value="1" checked>';
	
// LANGUAGE CHECK
// this is done by search the languages folder (PHP4 compatible)
$dir = '../language';
$dh = opendir($dir);
while(false != ($filename = readdir($dh))) {
	$files[] = $filename;
}

sort($files);
array_shift($files);
array_shift($files);

$language = '<select name="language">';

foreach($files as $key=>$value)
{
	$temp = substr($value, 5, strlen($value)-4);
	if($phpraid_config['language'] == $temp)
		$language .= "<option value=\"$temp\" selected>$temp</option>";
	else
		$language .= "<option value=\"$temp\">$temp</option>";
}

$language .= '</select>';

unset($files);
// END LANGUAGE CHECK

// default group
$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "permission_type";
$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);

$default_group = '<select name="default_group">';

while($data = $db_raid->sql_fetchrow($result, true))
{
	if($phpraid_config['default_group'] == $data['permission_type_id'])
		$default_group .= '<option value="'.$data['permission_type_id'].'" selected>'.$data['permission_type_name'].'</option>';
	else
		$default_group .= '<option value="'.$data['permission_type_id'].'">'.$data['permission_type_name'].'</option>';
}

$default_group .= '</select>';

$records_per_page = '<input name="records_per_page" size="5" type="text" class="post" value="' . $phpraid_config['records_per_page'] . '">';
$num_old_raids_index = '<input name="num_old_raids_index" size="5" type="text" class="post" value="' . $phpraid_config['num_old_raids_index'] . '">';

$wrmadminsmarty->assign('config_data',
	array(
		'form_action'=> $page_url,
		'general_header' => $phprlang['general_configuration_header'],
		'default_group_text' => $phprlang['configuration_default'],
		'default_group_value' => $default_group,
		'language' => $language,
		'language_text' => $phprlang['configuration_language'],
		'disable_site' => $disable_site,
		'disable_text' => $phprlang['configuration_disable'],
		'debug_mode' => $debug_mode,
		'debug_text' => $phprlang['configuration_debug'],
		'enable_five_man' => $enable_five_man, 
		'enable_five_man_text' => $phprlang['configuration_enable_five_man'],
		'persistent_db' => $persistent_db, 
		'persistent_db_text' => $phprlang['configuration_persistent_db'],
		'records_per_page_text' => $phprlang['configuration_records_per_page'],
		'records_per_page' => $records_per_page,
		'old_raids_index_text' => $phprlang['configuration_old_raids_index'],
		'num_old_raids_index' => $num_old_raids_index,
	
		'side_cfg_header' => $phprlang['general_side_cfg_header'],
	
		'site_name_value' =>  $phpraid_config['site_name'],
		'site_name_text' => $phprlang['configuration_site_name'],
		'site_description_value' => $phpraid_config['site_description'],
		'site_description_text' => $phprlang['configuration_site_description'],
		'site_server_value' => $phpraid_config['site_server'],
		'site_server_text' => $phprlang['configuration_site_server'],
		'button_submit' => $phprlang['submit'],
		'button_reset' => $phprlang['reset']
	)
);

if(isset($_POST['submit']))
{
	if(isset($_POST['disable']))
		$disable = 1;
	else
		$disable = 0;

	if(isset($_POST['debug']))
		$p_debug = 1;
	else
		$p_debug = 0;

 	if(isset($_POST['enable_five_man']))
 		$enable_five_man = 1;
 	else
 		$enable_five_man = 0;
 		
  	if(isset($_POST['default_group']))
 		$default_group = 1;
 	else
 		$default_group = 0;

 	if(isset($_POST['persistent_db']))
 		$persistent_db = 1;
 	else
 		$persistent_db = 0;
 		

	$lang = scrub_input($_POST['language']);
	
	$default_group = scrub_input($_POST['default_group']);
	
	$records_per_page = scrub_input($_POST['records_per_page']);
	
	$num_old_raids_index = scrub_input($_POST['num_old_raids_index']);
	
	$site_name = scrub_input($_POST['site_name']);
	$site_description = scrub_input($_POST['site_desc']);
	$site_server = scrub_input($_POST['site_server']);

	$db_raid->sql_query($sql) or print_error($sql,$db_raid->sql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'language';", quote_smart($lang));
	$db_raid->sql_query($sql) or print_error($sql,$db_raid->sql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'disable';", quote_smart($disable));
	$db_raid->sql_query($sql) or print_error($sql,$db_raid->sql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'debug';", quote_smart($p_debug));
	$db_raid->sql_query($sql) or print_error($sql,$db_raid->sql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'enable_five_man';", quote_smart($enable_five_man));
	$db_raid->sql_query($sql) or print_error($sql,$db_raid->sql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'default_group';", quote_smart($default_group));
	$db_raid->sql_query($sql) or print_error($sql,$db_raid->sql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'persistent_db';", quote_smart($persistent_db));
	$db_raid->sql_query($sql) or print_error($sql,$db_raid->sql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'records_per_page';", quote_smart($records_per_page));
	$db_raid->sql_query($sql) or print_error($sql,$db_raid->sql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'num_old_raids_index';", quote_smart($num_old_raids_index));
	$db_raid->sql_query($sql) or print_error($sql,$db_raid->sql_error(),1);
	
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'site_name';", quote_smart($site_name));
	$db_raid->sql_query($sql) or print_error($sql,$db_raid->sql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'site_description';", quote_smart($site_description));
	$db_raid->sql_query($sql) or print_error($sql,$db_raid->sql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'site_server';", quote_smart($site_server));
	$db_raid->sql_query($sql) or print_error($sql,$db_raid->sql_error(),1);
	
	header("Location: ".$page_url);
}

//
// Start output of the page.
//
require_once('./includes/admin_page_header.php');
$wrmadminsmarty->display('admin_general_config.html');
require_once('./includes/admin_page_footer.php');

?>