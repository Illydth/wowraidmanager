<?php
/***************************************************************************
 *                             admin_style_menu_mgt.php
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

$page_url = "admin_style_menubar_mgt.php";

/* 
 * Data for Index Page
 */

$phpraid_addon_link = '<input name="phpraid_addon_link" size="60" type="text" class="post" value="' . $phpraid_config['phpraid_addon_link'] . '">';
$register = '<input name="register" type="text" value="'.$phpraid_config['register_url'].'" size="60" class="post">';

$wrmadminsmarty->assign('config_data',
	array(
		'form_action'=> $page_url,
		'general_header' => $phprlang['general_configuration_header'],
		'look_and_feel_header' => $phprlang['configuration_look_and_feel_header'],
	
		'phpraid_addon_link' => $phpraid_addon_link,
		'phpraid_addon_link_text' => $phprlang['configuration_addon'],
		'register' => $register,
		'register_text' => $phprlang['configuration_register_text'],

		'button_submit' => $phprlang['submit'],
		'button_reset' => $phprlang['reset']
	)
);

if(isset($_POST['submit']))
{
	$p_link = scrub_input($_POST['phpraid_addon_link'], true);
	$register = scrub_input(DEUBB($_POST['register']), true);

	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'phpraid_addon_link';", quote_smart($p_link));
	$db_raid->sql_query($sql) or print_error($sql,$db_raid->sql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'register_url';", quote_smart($register));
	$db_raid->sql_query($sql) or print_error($sql,$db_raid->sql_error(),1);

	header("Location: ".$page_url);
}

//
// Start output of the page.
//
require_once('./includes/admin_page_header.php');
$wrmadminsmarty->display('admin_style_menubar_mgt.html');
require_once('./includes/admin_page_footer.php');

?>