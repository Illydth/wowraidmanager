<?php
/***************************************************************************
 *                             admin_style_cfg.php
 *                            -------------------
 *   begin                : Dec 19, 2010
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

// commons
define("IN_PHPRAID", true);	
require_once('./admin_common.php');

/*************************************************
 * Access Authorization Section
 *************************************************/
// page authentication
define("PAGE_LVL","configuration");
require_once("../includes/authentication.php");	

$page_url = "admin_style_cfg.php";

/* 
 * Data for Index Page
 */
	

// TEMPLATE CHECK
// and now let's check templates
$dir = '../templates';
$dh = opendir($dir);
while(false != ($filename = readdir($dh))) {
	$files[] = $filename;
}

sort($files);
array_shift($files);
array_shift($files);

$array_template_type = array();
$selected_template_type = "";

include_once ("../templates/".$phpraid_config['template']."/theme_cfg.php");
$selected_template_width = $phpraid_config['template_body_width'];
if (isset($template_width))
{
	$array_template_width = $template_width;
}
else 
{
	$array_template_width = array();
	$array_template_width["n/a"] = "N/A";
}

foreach($files as $key=>$value)
{
	if($phpraid_config['template'] == $value)
		$selected_template_type = $value;

	$array_template_type[$value] = $value;
}

//END TEMPLATE CHECK

$wrmadminsmarty->assign('config_data',
	array(
		'form_action' => $page_url,
		'general_header' => $phprlang['general_configuration_header'],
		'template_cfg_header' => $phprlang['configuration_template_cfg_header'],


		'header_logo_path_value' => $phpraid_config['header_logo'],
		'header_logo_path_text' => $phprlang['configuration_logo'],
		'header_link_value' => $phpraid_config['header_link'],
		'header_link_text' => $phprlang['configuration_sitelink'],
	
		'template_text' => $phprlang['configuration_template'],
		'array_template_type' => $array_template_type,
		'selected_template_type' => $selected_template_type,
	
		'template_width_text' => $phprlang['configuration_template_width_text'],
		'array_template_width' => $array_template_width,
		'selected_template_width' => $selected_template_width,	
	
		'button_submit' => $phprlang['submit'],
		'button_reset' => $phprlang['reset']
	)
);

if(isset($_POST['submit']))
{

	$h_logo = scrub_input($_POST['header_logo'], true);
	$h_link = scrub_input($_POST['header_link'], true);

	$t_type = scrub_input(DEUBB($_POST['template']));
	$template_width = scrub_input(DEUBB($_POST['template_width']));

	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'template_body_width';", quote_smart($template_width));
	$db_raid->sql_query($sql) or print_error($sql,$db_raid->sql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'header_logo';", quote_smart($h_logo));
	$db_raid->sql_query($sql) or print_error($sql,$db_raid->sql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'header_link';", quote_smart($h_link));
	$db_raid->sql_query($sql) or print_error($sql,$db_raid->sql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'template';", quote_smart($t_type));
	$db_raid->sql_query($sql) or print_error($sql,$db_raid->sql_error(),1);
	
	header("Location: ".$page_url);
}

//
// Start output of the page.
//
require_once('./includes/admin_page_header.php');
$wrmadminsmarty->display('admin_style_cfg.html');
require_once('./includes/admin_page_footer.php');

?>