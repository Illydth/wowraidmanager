<?php
/***************************************************************************
 *                              page_header.php
 *                            -------------------
 *   begin                : Saturday, Jan 16, 2005
 *   copyright            : (C) 2005 Kyle Spraggs
 *   email                : spiffyjr@gmail.com
 *
 *   $Id: mysql.php,v 1.16 2002/03/19 01:07:36 psotfx Exp $
 *
 ***************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/
//
// Parse and show the overall header.
//
$page->set_file('headerFile',$phpraid_config['template'] . '/header.htm');

// setup header variables
if($phpraid_config['faction'] == 'alliance')
	$page->set_var('other_name',$phprlang['paladin']);
else
	$page->set_var('other_name',$phprlang['shaman']);

// time variables
$guild_time = new_date($phpraid_config['time_format'],time(),$phpraid_config['timezone'] + $phpraid_config['dst']);
$guild_date = new_date($phpraid_config['date_format'],time(),$phpraid_config['timezone'] + $phpraid_config['dst']);

// login stuff
// now for the links
if($_SESSION['session_logged_in'] != 1)
{
	$login_form_open = '<form action="login.php" method="POST">';
	$login_username = '<input name="username" type="text" value="username" size="15" maxlength="45" onFocus="if(this.value==\'username\')this.value=\'\';" class="post">';
	$login_password = '<input name="password" type="password" value="password" size="15" onFocus="if(this.value==\'password\')this.value=\'\';" class="post">';
	$login_button = '<input type="submit" name="login" value="Log in" style="font-size:10px" class="mainoption"></form>';
	$login_remember = '<input type="checkbox" checked="checked" name="autologin">';
	$login_remember_hidden = '<input type="hidden" value="1" name="autologin">';
	$login_form_close = '</form>';
}
else
{
	$login_form_open = '<form action="login.php?logout=true" method="POST">';
	$login_username = $_SESSION['username'];
	$login_password = '';
	$login_button = '<input type="submit" name="login" value="Log out" style="font-size:10px" class="mainoption"></form>';
	$login_remember = '';
	$login_remember_hidden = '';
	$login_form_close = '</form>';
}
if(($phpraid_config['disable'] == '1') AND ($_SESSION['priv_configuration'] == 1))
{
	$site_disabled_warning = "
	<br>
	<div align=\"center\">
	<div class=\"errorHeader\">Site disabled notice</div>
	<div class=\"errorBody\">Please note, your site is disabled. Visitors can't use the system right now!<br>
	Go to <u>Configuration</u> and then uncheck <u>Disable phpRaid</u></div>
	</div>
	";
}

$page->set_var(
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
			'site_disabled_warning' => $site_disabled_warning
	)
);

// setup link permissions
require_once($phpraid_dir.'templates/' . $phpraid_config['template'] . '/theme_cfg.php');

// links useable for everyone
$index_link = '<a href="' . $phpraid_config['header_link'] . '">' . $theme_index_link . '</a>';
$home_link = '<a href="index.php">' . $theme_home_link . '</a>';
$calendar_link = '<a href="calendar_raids.php">' . $theme_calendar_link . '</a>';
$roster_link = '<a href="roster.php">' . $theme_roster_link . '</a>';

// these links need special permissions
$_SESSION['priv_announcements'] ? $announce_link = '<a href="announcements.php?mode=view">' . $theme_announcement_link . '</a>' : $announce_link = '';
$_SESSION['priv_configuration'] ? $phpraid_configure_link = '<a href="configuration.php">' . $theme_configure_link . '</a>' : $phpraid_configure_link = '';
$_SESSION['priv_permissions'] ? $permissions_link = '<a href="permissions.php?mode=view">' . $theme_permissions_link . '</a>' : $permissions_link = '';
$_SESSION['priv_guilds'] ?	$guild_link = '<a href="guilds.php?mode=view">' . $theme_guild_link . '</a>' : $guild_link = '';
$_SESSION['priv_locations'] ? $locations_link = '<a href="locations.php?mode=view">' . $theme_locations_link . '</a>' : $locations_link = '';
$_SESSION['priv_logs']? $logs_link = '<a href="logs.php?mode=view">' . $theme_logs_link . '</a>' : $logs_link = '';
$_SESSION['priv_profile'] ? $profile_link = '<a href="profile.php?mode=view">' . $theme_profile_link . '</a>' : $profile_link = '';
$_SESSION['priv_users'] ? $users_link = '<a href="users.php?mode=view">' . $theme_users_link . '</a>' : $users_link = '';
$_SESSION['session_logged_in'] != '1' ? $register_link = '<a href="' . $phpraid_config['register_url'] . '">' . $theme_register_link . '</a>' : $register_link = '';
if ( $_SESSION['priv_raids'] OR ($phpraid_config['enable_five_man'] AND $_SESSION['priv_profile']) )
{ 
	$raids_link = '<a href="raids.php?mode=view">' . $theme_raids_link . '</a>';
	$lua_output_link = '<a href="lua_output.php">' . $theme_lua_output_link . '</a>'; 
}
else
{
	$raids_link = '';
	$lua_output_link = '';
}

// setup menu
$menu = '<div align="left" class="navContainer"><ul class="navList">
<li>' . $index_link . '</li>
<li>' . $home_link . '</li>
<li>' . $calendar_link . '</li>';

// setup permission based links
if($_SESSION['priv_announcements'] == 1)
	$menu .= '<li>' . $announce_link . '</li>';
	
if($_SESSION['priv_configuration'] == 1)
	$menu .= '<li>' . $phpraid_configure_link . '</li>';

if($_SESSION['priv_guilds'] == 1)
	$menu .= '<li>' . $guild_link . '</li>';
	
if($_SESSION['priv_locations'] == 1)
	$menu .= '<li>' . $locations_link . '</li>';
	
if($_SESSION['priv_logs'] == 1)
	$menu .= '<li>' . $logs_link . '</li>';
	
if($_SESSION['priv_permissions'] == 1)
	$menu .= '<li>' . $permissions_link . '</li>';
	
if($_SESSION['priv_profile'] == 1)
	$menu .= '<li>' . $profile_link . '</li>';

if ( $_SESSION['priv_raids'] OR ($phpraid_config['enable_five_man'] AND $_SESSION['priv_profile']) )
{ 	
	$menu .= '<li>' . $raids_link . '</li>';
	$menu .= '<li>' . $lua_output_link . '</li>';
}
	
if($_SESSION['priv_users'] == 1)
	$menu .= '<li>' . $users_link . '</li>';

if($_SESSION['session_logged_in'] == 0) {
	$menu .= '<li>' . $register_link . '</li>';
	$page->set_var('register_link',$register_link);
}

$menu .= '<li>' . $roster_link . '</li></ul></div>';
$page->set_var('menu',$menu);

// finally, output the header information
$page->parse('header','headerFile');

// display any errors if they exist
if(isset($errorMsg)) 
{
	if(isset($errorSpace) && $errorSpace == 1) {
		$errorMsg .= '</div><br>';
	} else {
		$errorMsg .= '</div>';
	}
		
	$page->set_file('errorFile',$phpraid_config['template'] . '/error.htm');
	$page->set_var(array(
		'error_msg' => $errorMsg,
		'error_title' => $errorTitle)
	);
	
	$page->parse('header','errorFile',true);
	
	// is the error fatal?
	if($errorDie)
	{
		$page->p('header');
		require_once('page_footer.php');
		exit;
	}
}
$page->p('header');
?>