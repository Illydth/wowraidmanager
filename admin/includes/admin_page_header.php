<?php
/***************************************************************************
 *                              page_header.php
 *                            -------------------
 *   begin                : Saturday, Jan 16, 2005
 *   copyright            : (C) 2007-2008 Douglas Wagner
 *   email                : douglasw@wagnerweb.org
 *
 *   $Id: page_header.php,v 2.00 2008/03/04 14:26:10 psotfx Exp $
 *
 ***************************************************************************/

/***************************************************************************
*
*    WoW Raid Manager - Raid Management Software for World of Warcraft
*    Copyright (C) 2007-2008 Douglas Wagner
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
// Set Page content type header:
header('Content-Type: text/html; charset=utf-8');

$priv_config=scrub_input($_SESSION['priv_configuration']);
$logged_in=scrub_input($_SESSION['session_logged_in']);

// time variables
$guild_time = new_date($phpraid_config['time_format'],time(),$phpraid_config['timezone'] + $phpraid_config['dst']);
$guild_date = new_date($phpraid_config['date_format'],time(),$phpraid_config['timezone'] + $phpraid_config['dst']);

if(($phpraid_config['disable'] == '1') AND ($priv_config == 1))
{
	$site_disabled_warning = '
					<br>
					<div align="center">
					<div class="errorHeader">'. $phprlang['disabled_header'] . '</div>
					<div class="errorBody">' . $phprlang['disabled_message'] . '</div>
					</div>
					';
}

$wrmadminsmarty->assign('page_header_data', 
		array(
			'header_link' => $phpraid_config['header_link'],
			'title_guild_name'=>$phpraid_config['site_name'],
			'title_guild_server'=>$phpraid_config['site_server'],
			'title_guild_description'=>$phpraid_config['site_description'],
			'header_logo' => $phpraid_config['header_logo'],
			'guild_time' => $guild_time,
			'guild_date' => $guild_date,
			'of_string'=>$phprlang['of'],
			'rss_feed_string'=>$phprlang['rss_feed_text'],
			'guild_time_string'=>$phprlang['guild_time_string'],
			'menu_header_text'=>$phprlang['menu_header_text'],
			'header_link'=>$phpraid_config['header_link'],
			'site_disabled_warning' => $site_disabled_warning,
	)
);

// setup link permissions
require_once($phpraid_dir.'templates/' . $phpraid_config['template'] . '/admin/admin_theme_cfg.php');

/**********************************************
 *  Menu Section - Create the Left Side Menu
 **********************************************/
$admin_site_link = '<a href="../index.php">' . $theme_admin_site_link . "</a>";
$admin_main_link = '<a href="admin_index.php">' . $theme_admin_main_link . '</a>';
$admin_generalcfg_link = '<a href="admin_generalcfg.php">' . $theme_admin_generalcfg_link . '</a>';
$admin_general_rss_cfg_link = '<a href="admin_general_rss_cfg.php">' . $theme_admin_general_rss_cfg_link . '</a>';
$admin_general_email_cfg_link = '<a href="admin_general_email_cfg.php">' . $theme_admin_general_email_cfg_link . '</a>';
$admin_general_game_settings_link = '<a href="admin_general_game_settings.php">' . $theme_admin_general_game_settings_link . '</a>';
$admin_timecfg_link = '<a href="admin_timecfg.php">' . $theme_admin_timecfg_link . '</a>';
$admin_raid_settings_link = '<a href="admin_raidsettings.php">' . $theme_admin_raid_settings_link . '</a>';
$admin_general_lua_output_cfg = '<a href="admin_general_lua_output_cfg.php">' . $theme_admin_general_lua_output_cfg_link . '</a>';
$admin_externcfg_link = '<a href="admin_externcfg.php">' . $theme_admin_externcfg_link . '</a>';
$admin_permissions_link = '<a href="admin_permissions.php?mode=view">' . $theme_admin_permissions_link . '</a>';
$admin_raid_signupgroups_link = '<a href="admin_raid_signupgroups.php?mode=view">' . $theme_admin_raid_signupgroups_link . '</a>';
$admin_signup_rights_link = '<a href="admin_signuprights.php">' . $theme_admin_signuprights_link . '</a>';
$admin_user_settings_link = '<a href="admin_usersettings.php">' . $theme_admin_usersettings_link . '</a>';
$admin_user_mgt_link = '<a href="admin_usermgt.php?mode=view">' . $theme_admin_usermgt_link . '</a>';
$admin_datatablecfg_link = '<a href="admin_datatablecfg.php">' . $theme_admin_datatablecfg_link . '</a>';
$admin_rolecfg_link = '<a href="admin_rolecfg.php?mode=view">' . $theme_admin_rolecfg_link . '</a>';
$admin_logs_link = '<a href="admin_logs.php?mode=view">' . $theme_admin_logs_link . '</a>';
$admin_roletalent_link = '<a href="admin_roletalent.php?mode=view">' . $theme_admin_roletalent_link . '</a>';
$admin_style_conf_link = '<a href="admin_style_cfg.php?mode=view">' . $theme_admin_style_conf_link . '</a>';
$admin_style_menubar_mgt_link = '<a href="admin_style_menubar_mgt.php?mode=view">' . $theme_admin_style_menubar_mgt_link . '</a>';

// The various Admin Menus:
$main_menu = '<div align="left" class="navContainer"><ul class="navList">';
$gen_conf_menu = '<div align="left" class="navContainer"><ul class="navList">';
$style_conf_menu = '<div align="left" class="navContainer"><ul class="navList">';
$user_mgt_menu = '<div align="left" class="navContainer"><ul class="navList">';
$table_conf_menu = '<div align="left" class="navContainer"><ul class="navList">';
$logs_menu = '<div align="left" class="navContainer"><ul class="navList">';

// *** MAIN MENU CONFIG ITEMS ***
// Go Back to the Main Site
$main_menu .= '<li class="">' . $admin_site_link . '</li>';

if (preg_match("/(.*)admin_index\.php(.*)/", $_SERVER['PHP_SELF'])) {
	$main_menu .= '<li class="active">' . $admin_main_link . '</li>';
} else {
    $main_menu .= '<li class="">' . $admin_main_link . '</li>';
}

// *** General Configuration Menu Items ***
// To DO
if (preg_match("/(.*)admin_generalcfg\.php(.*)/", $_SERVER['PHP_SELF'])) {
    $gen_conf_menu .= '<li class="active">' . $admin_generalcfg_link . '</li>';
} else {
    $gen_conf_menu .= '<li class="">' . $admin_generalcfg_link . '</li>';
}
// To DO
if (preg_match("/(.*)admin_general_rss_cfg\.php(.*)/", $_SERVER['PHP_SELF'])) {
    $gen_conf_menu .= '<li class="active">' . $admin_general_rss_cfg_link . '</li>';
} else {
    $gen_conf_menu .= '<li class="">' . $admin_general_rss_cfg_link . '</li>';
}
// To DO
if (preg_match("/(.*)admin_general_email_cfg\.php(.*)/", $_SERVER['PHP_SELF'])) {
    $gen_conf_menu .= '<li class="active">' . $admin_general_email_cfg_link . '</li>';
} else {
    $gen_conf_menu .= '<li class="">' . $admin_general_email_cfg_link . '</li>';
}
// To DO
if (preg_match("/(.*)admin_timecfg\.php(.*)/", $_SERVER['PHP_SELF'])) {
    $gen_conf_menu .= '<li class="active">' . $admin_timecfg_link . '</li>';
} else {
    $gen_conf_menu .= '<li class="">' . $admin_timecfg_link . '</li>';
}
// To DO
if (preg_match("/(.*)admin_raidsettings\.php(.*)/", $_SERVER['PHP_SELF'])) {
    $gen_conf_menu .= '<li class="active">' . $admin_raid_settings_link . '</li>';
} else {
    $gen_conf_menu .= '<li class="">' . $admin_raid_settings_link . '</li>';
}
// To DO
if (preg_match("/(.*)admin_externcfg\.php(.*)/", $_SERVER['PHP_SELF'])) {
    $gen_conf_menu .= '<li class="active">' . $admin_externcfg_link . '</li>';
} else {
    $gen_conf_menu .= '<li class="">' . $admin_externcfg_link . '</li>';
}
// To DO
if (preg_match("/(.*)admin_general_game_settings\.php(.*)/", $_SERVER['PHP_SELF'])) {
    $gen_conf_menu .= '<li class="active">' . $admin_general_game_settings_link . '</li>';
} else {
    $gen_conf_menu .= '<li class="">' . $admin_general_game_settings_link . '</li>';
}
// To DO
if (preg_match("/(.*)admin_general_game_settings\.php(.*)/", $_SERVER['PHP_SELF'])) {
    $gen_conf_menu .= '<li class="active">' . $admin_general_lua_output_cfg . '</li>';
} else {
    $gen_conf_menu .= '<li class="">' . $admin_general_lua_output_cfg . '</li>';
}


// *** Style Menu Items ***
// To DO
if (preg_match("/(.*)admin_style_cfg\.php(.*)/", $_SERVER['PHP_SELF'])) {
    $style_conf_menu .= '<li class="active">' . $admin_style_conf_link . '</li>';
} else {
    $style_conf_menu .= '<li class="">' . $admin_style_conf_link . '</li>';
}

if (preg_match("/(.*)admin_style_menubar_mgt\.php(.*)/", $_SERVER['PHP_SELF'])) {
    $style_conf_menu .= '<li class="active">' . $admin_style_menubar_mgt_link . '</li>';
} else {
    $style_conf_menu .= '<li class="">' . $admin_style_menubar_mgt_link . '</li>';
}

// *** User Management Menu Items ***
// To DO
if (preg_match("/(.*)admin_usermgt\.php(.*)/", $_SERVER['PHP_SELF'])) {
    $user_mgt_menu .= '<li class="active">' . $admin_user_mgt_link . '</li>';
} else {
    $user_mgt_menu .= '<li class="">' . $admin_user_mgt_link . '</li>';
}
// To DO
if (preg_match("/(.*)admin_permissions\.php(.*)/", $_SERVER['PHP_SELF'])) {
    $user_mgt_menu .= '<li class="active">' . $admin_permissions_link . '</li>';
} else {
    $user_mgt_menu .= '<li class="">' . $admin_permissions_link . '</li>';
}
// To DO
if (preg_match("/(.*)admin_raid_signupgroups\.php(.*)/", $_SERVER['PHP_SELF'])) {
    $user_mgt_menu .= '<li class="active">' . $admin_raid_signupgroups_link . '</li>';
} else {
    $user_mgt_menu .= '<li class="">' . $admin_raid_signupgroups_link . '</li>';
}
// To DO
if (preg_match("/(.*)admin_usersettings\.php(.*)/", $_SERVER['PHP_SELF'])) {
    $user_mgt_menu .= '<li class="active">' . $admin_user_settings_link . '</li>';
} else {
    $user_mgt_menu .= '<li class="">' . $admin_user_settings_link . '</li>';
}


// *** Table Configuration Menu Items ***
// To DO
if (preg_match("/(.*)admin_datatablecfg\.php(.*)/", $_SERVER['PHP_SELF'])) {
	$table_conf_menu .= '<li class="active">' . $admin_datatablecfg_link . '</li>';
} else {
    $table_conf_menu .= '<li class="">' . $admin_datatablecfg_link . '</li>';
}
// To DO
if (preg_match("/(.*)admin_rolecfg\.php(.*)/", $_SERVER['PHP_SELF'])) {
	$table_conf_menu .= '<li class="active">' . $admin_rolecfg_link . '</li>';
} else {
    $table_conf_menu .= '<li class="">' . $admin_rolecfg_link . '</li>';
}
// To DO
if (preg_match("/(.*)admin_roletalent\.php(.*)/", $_SERVER['PHP_SELF'])) {
	$table_conf_menu .= '<li class="active">' . $admin_roletalent_link . '</li>';
} else {
    $table_conf_menu .= '<li class="">' . $admin_roletalent_link . '</li>';
}

// *** Log Menu Items ***
if (preg_match("/(.*)logs\.php(.*)/", $_SERVER['PHP_SELF'])) {
    $logs_menu .= '<li class="active">' . $admin_logs_link . '</li>';
} else {
    $logs_menu .= '<li class="">' . $admin_logs_link . '</li>';
}

$main_menu .= '</ul></div>';
$gen_conf_menu .= '</ul></div>';
$user_mgt_menu .= '</ul></div>';
$table_conf_menu .= '</ul></div>';
$logs_menu .= '</ul></div>';
	
$wrmadminsmarty->assign('menus', 
	array(
		'main_menu'=>$main_menu,
		'main_menu_header'=>$phprlang['admin_menu_header'],
		'style_menu'=>$style_conf_menu,
		'style_menu_header'=>$phprlang['style_menu_header'],
		'gen_conf_menu'=>$gen_conf_menu,
		'gen_conf_menu_header'=>$phprlang['gen_conf_menu_header'],
		'user_mgt_menu'=>$user_mgt_menu,
		'user_mgt_menu_header'=>$phprlang['user_mgt_menu_header'],
		'table_conf_menu'=>$table_conf_menu,
		'table_conf_menu_header'=>$phprlang['table_conf_menu_header'],
		'logs_menu'=>$logs_menu,
		'logs_menu_header'=>$phprlang['logs_menu_header'],
	)
);
$wrmadminsmarty->assign('admin_index_header', $phprlang['admin_index_header']);

// display any errors if they exist
if(isset($errorMsg))
{
	$wrmadminsmarty->display('admin_header.html');
	
	if(isset($errorSpace) && $errorSpace == 1) {
		$errorMsg .= '</div><br>';
	} else {
		$errorMsg .= '</div>';
	}

	$wrmadminsmarty->assign('error_data', 
	  array(
		'error_msg' => $errorMsg,
		'error_title' => $errorTitle)
	);
	$wrmadminsmarty->display('admin_error.html');
	
	// is the error fatal?
	if($errorDie)
	{
		require_once('admin_page_footer.php');
		exit;
	}
}
$wrmadminsmarty->display('admin_header.html');
?>