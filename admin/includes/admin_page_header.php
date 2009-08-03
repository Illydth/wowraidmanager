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

$priv_announcement=scrub_input($_SESSION['priv_announcements']);
$priv_config=scrub_input($_SESSION['priv_configuration']);
$priv_guilds=scrub_input($_SESSION['priv_guilds']);
$priv_locations=scrub_input($_SESSION['priv_locations']);
$priv_logs=scrub_input($_SESSION['priv_logs']);
$priv_permissions=scrub_input($_SESSION['priv_permissions']);
$priv_profile=scrub_input($_SESSION['priv_profile']);
$priv_raids=scrub_input($_SESSION['priv_raids']);
$priv_users=scrub_input($_SESSION['priv_users']);
$logged_in=scrub_input($_SESSION['session_logged_in']);

// time variables
$guild_time = new_date($phpraid_config['time_format'],time(),$phpraid_config['timezone'] + $phpraid_config['dst']);
$guild_date = new_date($phpraid_config['date_format'],time(),$phpraid_config['timezone'] + $phpraid_config['dst']);

// login stuff
// now for the links
if($logged_in != 1)
{
	$login_form_open = '<form action="../login.php" method="POST">';
	$login_username = '<input name="username" type="text" value="username" size="15" maxlength="45" onFocus="if(this.value==\'username\')this.value=\'\';" class="post">';
	$login_password = '<input name="password" type="password" value="password" size="15" onFocus="if(this.value==\'password\')this.value=\'\';" class="post">';
	$login_button = '<input type="submit" name="login" value="'.$phprlang['login'].'" style="font-size:10px" class="mainoption">';
	$login_remember = '<input type="checkbox" checked="checked" name="autologin">';
	$login_remember_hidden = '<input type="hidden" value="1" name="autologin">';
	if ( ($BridgeSupportPWDChange == TRUE) and isset($BridgeSupportPWDChange) )
		$login_change_pass = '<a href="../login.php?mode=new_pwd">'.$phprlang['login_forgot_password'].'</a>';
	$login_form_close = '</form>';
}
else
{
	$login_form_open = '<form action="../login.php?logout=true" method="POST">';
	$login_username = scrub_input($_SESSION['username']);
	$login_password = '';
	$login_button = '<input type="submit" name="login" value="'.$phprlang['logout'].'" style="font-size:10px" class="mainoption">';
	$login_remember = '';
	$login_remember_hidden = '';
	//$BridgeSupportPWDChange came from the bridge
	if ( ($BridgeSupportPWDChange == TRUE) and isset($BridgeSupportPWDChange) )
		$login_change_pass = '<a href="../login.php?mode=ch_pwd">'.$phprlang['login_chpwd'].'</a>';
	$login_form_close = '</form>';
}
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
if (isset($ShowLoginForm) and ($ShowLoginForm == FALSE))
{
	$login_form_open=$login_username=$login_change_pass=$login_password=$login_button=$login_remember=$login_remember_hidden=$login_form_close = "";
}

$wrmadminsmarty->assign('page_header_data', 
		array(
			'header_link' => $phpraid_config['header_link'],
			'title_guild_name'=>$phpraid_config['guild_name'],
			'title_guild_server'=>$phpraid_config['guild_server'],
			'title_guild_description'=>$phpraid_config['guild_description'],
			'header_logo' => $phpraid_config['header_logo'],
			'guild_time' => $guild_time,
			'guild_date' => $guild_date,
			'login_form_open' => $login_form_open,
			'login_form_close' => $login_form_close,
			'login_username' => $login_username,
			'login_password' => $login_password,
			'login_remember' => $login_remember,
			'login_remember_hidden' => $login_remember_hidden,
			'login_button' => $login_button,
			'login_change_pass'=>$login_change_pass,
			'site_disabled_warning' => $site_disabled_warning,
			'of_string'=>$phprlang['of'],
			'rss_feed_string'=>$phprlang['rss_feed_text'],
			'guild_time_string'=>$phprlang['guild_time_string'],
			'menu_header_text'=>$phprlang['menu_header_text'],
			'armory_url'=>$phpraid_config['armory_link'],
			'dkp_url'=>$phpraid_config['eqdkp_url'],
			'header_link'=>$phpraid_config['header_link'],
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
$admin_timecfg_link = '<a href="admin_timecfg.php">' . $theme_admin_timecfg_link . '</a>';
$admin_raid_settings_link = '<a href="admin_raidsettings.php">' . $theme_admin_raid_settings_link . '</a>';
$admin_externcfg_link = '<a href="admin_externcfg.php">' . $theme_admin_externcfg_link . '</a>';
$admin_permissions_link = '<a href="admin_permissions.php?mode=view">' . $theme_admin_permissions_link . '</a>';
$admin_signup_rights_link = '<a href="admin_signuprights.php">' . $theme_admin_signuprights_link . '</a>';
$admin_user_settings_link = '<a href="admin_usersettings.php">' . $theme_admin_usersettings_link . '</a>';
$admin_user_mgt_link = '<a href="admin_usermgt.php?mode=view">' . $theme_admin_usermgt_link . '</a>';
$admin_datatablecfg_link = '<a href="admin_datatablecfg.php">' . $theme_admin_datatablecfg_link . '</a>';
$admin_rolecfg_link = '<a href="admin_rolecfg.php?mode=view">' . $theme_admin_rolecfg_link . '</a>';
$admin_logs_link = '<a href="admin_logs.php?mode=view">' . $theme_admin_logs_link . '</a>';
$admin_roletalent_link = '<a href="admin_roletalent.php?mode=view">' . $theme_admin_roletalent_link . '</a>';

// The various Admin Menus:
$main_menu = '<div align="left" class="navContainer"><ul class="navList">';
$gen_conf_menu = '<div align="left" class="navContainer"><ul class="navList">';
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

// *** User Management Menu Items ***
// To DO
if (preg_match("/(.*)admin_permissions\.php(.*)/", $_SERVER['PHP_SELF'])) {
    $user_mgt_menu .= '<li class="active">' . $admin_permissions_link . '</li>';
} else {
    $user_mgt_menu .= '<li class="">' . $admin_permissions_link . '</li>';
}
// To DO
if (preg_match("/(.*)admin_signuprights\.php(.*)/", $_SERVER['PHP_SELF'])) {
    $user_mgt_menu .= '<li class="active">' . $admin_signup_rights_link . '</li>';
} else {
    $user_mgt_menu .= '<li class="">' . $admin_signup_rights_link . '</li>';
}
// To DO
if (preg_match("/(.*)admin_usersettings\.php(.*)/", $_SERVER['PHP_SELF'])) {
    $user_mgt_menu .= '<li class="active">' . $admin_user_settings_link . '</li>';
} else {
    $user_mgt_menu .= '<li class="">' . $admin_user_settings_link . '</li>';
}
// To DO
if (preg_match("/(.*)admin_usermgt\.php(.*)/", $_SERVER['PHP_SELF'])) {
    $user_mgt_menu .= '<li class="active">' . $admin_user_mgt_link . '</li>';
} else {
    $user_mgt_menu .= '<li class="">' . $admin_user_mgt_link . '</li>';
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