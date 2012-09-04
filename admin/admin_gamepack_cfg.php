<?php
/***************************************************************************
*                             admin_gamepack_cfg.php
*                            -------------------
*    begin                : Sep 03, 2012
 *	 Dev                  : Carsten Hölbing
 *	 email                : carsten@hoelbing.net
 *
 *   -- WoW Raid Manager --
 *   copyright            : (C) 2007-2012 Douglas Wagner
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

$page_url = "admin_gamepack_cfg.php";
$html_table = '';
$table_pos = 0;
$html_table = "";

//load gamepack settings
$gamepack_setting = $wrmtemplate->load_current_gamepack_settings();


$wrmadminsmarty->assign('config_data',
	array(
		'form_action'=> $page_url,
		'general_header' => $phprlang['general_configuration_header'],
		'gamepack_cfg_header' => $phprlang['configuration_gamepack_cfg_header'],

		'current_gamepack_header_text' => $phprlang['current_gamepack_header_text'],
			
		'current_gamepack_name_text' => $phprlang['current_gamepack_name_text'],
		'current_gamepack_name_value' => $gamepack_setting['gamepack_name'],
		'current_gamepack_created_by_text' => $phprlang['current_gamepack_created_by_text'],
		'current_gamepack_created_by_value' => $gamepack_setting['gamepack_author'],
		'current_gamepack_version_nr_text' => $phprlang['current_gamepack_version_nr_text'],
		'current_gamepack_version_nr_value' => $gamepack_setting['gamepack_version'],
		'current_gamepack_info_text' => $phprlang['current_gamepack_info_text'],
		'current_gamepack_info_value' => $gamepack_setting['gamepack_description'],	
	
		'button_submit' => $phprlang['submit'],
		'button_reset' => $phprlang['reset'],
		'html_table' => $html_table
	)
);

if(isset($_POST['submit']))
{
	$template_width = scrub_input(DEUBB($_POST['template_width']));

	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'template_body_width';", quote_smart($template_width));
	$db_raid->sql_query($sql) or print_error($sql,$db_raid->sql_error(),1);


	header("Location: ".$page_url);
}

if (isset($_GET['mode']) AND ($_GET['mode'] == 'active') AND isset($_GET['gampack_name']))
{	
	$template_name = scrub_input(DEUBB($_GET['template_name']));

	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'template';", quote_smart($template_name));
	$db_raid->sql_query($sql) or print_error($sql,$db_raid->sql_error(),1);
	
	header("Location: ".$page_url);
}

//
// Start output of the page.
//
require_once('./includes/admin_page_header.php');
$wrmadminsmarty->display('admin_gamepack_cfg.html');
require_once('./includes/admin_page_footer.php');

?>