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

//
// Parse and show the overall header.
//
$page->set_file('headerFile',$phpraid_config['template'] . '/header.htm');

// This looks like dead code due to BC making shaman and paladins all on both sides.
// setup header variables
//if($phpraid_config['faction'] == 'alliance')
//    $page->set_var('other_name',$phprlang['paladin']);
//else
//    $page->set_var('other_name',$phprlang['shaman']);
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
	$login_form_open = '<form action="login.php" method="POST">';
	$login_username = '<input name="username" type="text" value="username" size="15" maxlength="45" onFocus="if(this.value==\'username\')this.value=\'\';" class="post">';
	$login_password = '<input name="password" type="password" value="password" size="15" onFocus="if(this.value==\'password\')this.value=\'\';" class="post">';
	$login_button = '<input type="submit" name="login" value="'.$phprlang['login'].'" style="font-size:10px" class="mainoption">';
	$login_remember = '<input type="checkbox" checked="checked" name="autologin">';
	$login_remember_hidden = '<input type="hidden" value="1" name="autologin">';
	$login_form_close = '</form>';
}
else
{
	$login_form_open = '<form action="login.php?logout=true" method="POST">';
	$login_username = scrub_input($_SESSION['username']);
	$login_password = '';
	$login_button = '<input type="submit" name="login" value="'.$phprlang['logout'].'" style="font-size:10px" class="mainoption">';
	$login_remember = '';
	$login_remember_hidden = '';
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
require_once($phpraid_dir.'templates/' . $phpraid_config['template'] . '/theme_cfg.php');

// links useable for everyone
$index_link = '<a href="' . $phpraid_config['header_link'] . '">' . $theme_index_link . '</a>';
$home_link = '<a href="index.php">' . $theme_home_link . '</a>';
$calendar_link = '<a href="calendar.php">' . $theme_calendar_link . '</a>';
$roster_link = '<a href="roster.php">' . $theme_roster_link . '</a>';
$dkp_view_link = '<a href="dkp_view.php">' . $theme_dkp_link . '</a>';

// these links need special permissions
$priv_announcement ? $announce_link = '<a href="announcements.php?mode=view">' . $theme_announcement_link . '</a>' : $announce_link = '';
$priv_config ? $phpraid_configure_link = '<a href="configuration.php">' . $theme_configure_link . '</a>' : $phpraid_configure_link = '';
$priv_permissions ? $permissions_link = '<a href="permissions.php?mode=view">' . $theme_permissions_link . '</a>' : $permissions_link = '';
$priv_guilds ?	$guild_link = '<a href="guilds.php?mode=view">' . $theme_guild_link . '</a>' : $guild_link = '';
$priv_locations ? $locations_link = '<a href="locations.php?mode=view">' . $theme_locations_link . '</a>' : $locations_link = '';
$priv_logs ? $logs_link = '<a href="logs.php?mode=view">' . $theme_logs_link . '</a>' : $logs_link = '';
$priv_profile ? $profile_link = '<a href="profile.php?mode=view">' . $theme_profile_link . '</a>' : $profile_link = '';
$priv_users ? $users_link = '<a href="users.php?mode=view">' . $theme_users_link . '</a>' : $users_link = '';
$logged_in != '1' ? $register_link = '<a href="' . $phpraid_config['register_url'] . '">' . $theme_register_link . '</a>' : $register_link = '';
if ( $priv_raids OR ($phpraid_config['enable_five_man'] AND $priv_profile) )
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
$menu = '<div align="left" class="navContainer"><ul class="navList">';


//Ingore link to another site
$menu .= '<li>' . $index_link . '</li>';
if (preg_match("/(.*)index\.php(.*)/", $_SERVER['PHP_SELF'])) {
	$menu .= '<li class="active">' . $home_link . '</li>';
} else {
    $menu .= '<li class="">' . $home_link . '</li>';
}
if (preg_match("/(.*)calendar\.php(.*)/", $_SERVER['PHP_SELF'])) {
    $menu .= '<li class="active">' . $calendar_link . '</li>';
} else {
    $menu .= '<li class="">' . $calendar_link . '</li>';
}

// setup permission based links
if($_SESSION['priv_announcements'] == 1)
{
	if (preg_match("/(.*)announcements\.php(.*)/", $_SERVER['PHP_SELF'])) {
	    $menu .= '<li class="active">' . $announce_link . '</li>';
	} else {
	    $menu .= '<li class="">' . $announce_link . '</li>';
	}
}

if($_SESSION['priv_configuration'] == 1)
{
	if (preg_match("/(.*)configuration\.php(.*)/", $_SERVER['PHP_SELF'])) {
	    $menu .= '<li class="active">' . $phpraid_configure_link . '</li>';
	} else {
	    $menu .= '<li class="">' . $phpraid_configure_link . '</li>';
	}
}

if($_SESSION['priv_guilds'] == 1)
{
	if (preg_match("/(.*)guilds\.php(.*)/", $_SERVER['PHP_SELF'])) {
	    $menu .= '<li class="active">' . $guild_link . '</li>';
	} else {
	    $menu .= '<li class="">' . $guild_link . '</li>';
	}
}

if($_SESSION['priv_locations'] == 1)
{
	if (preg_match("/(.*)locations\.php(.*)/", $_SERVER['PHP_SELF'])) {
	    $menu .= '<li class="active">' . $locations_link . '</li>';
	} else {
	    $menu .= '<li class="">' . $locations_link . '</li>';
	}
}

if($_SESSION['priv_logs'] == 1)
{
	if (preg_match("/(.*)logs\.php(.*)/", $_SERVER['PHP_SELF'])) {
	    $menu .= '<li class="active">' . $logs_link . '</li>';
	} else {
	    $menu .= '<li class="">' . $logs_link . '</li>';
	}
}

if($_SESSION['priv_permissions'] == 1)
{
	if (preg_match("/(.*)permissions\.php(.*)/", $_SERVER['PHP_SELF'])) {
	    $menu .= '<li class="active">' . $permissions_link . '</li>';
	} else {
	    $menu .= '<li class="">' . $permissions_link . '</li>';
	}
}

if($_SESSION['priv_profile'] == 1)
{
	if (preg_match("/(.*)profile\.php(.*)/", $_SERVER['PHP_SELF'])) {
	    $menu .= '<li class="active">' . $profile_link . '</li>';
	} else {
	    $menu .= '<li class="">' . $profile_link . '</li>';
	}
}

if ( $_SESSION['priv_raids'] OR ($phpraid_config['enable_five_man'] AND $priv_profile) )
{
	if (preg_match("/(.*)raids\.php(.*)/", $_SERVER['PHP_SELF'])) {
	    $menu .= '<li class="active">' . $raids_link . '</li>';
	} else {
	    $menu .= '<li class="">' . $raids_link . '</li>';
	}
	if (preg_match("/(.*)lua_output\.php(.*)/", $_SERVER['PHP_SELF'])) {
	    $menu .= '<li class="active">' . $lua_output_link . '</li>';
	} else {
	    $menu .= '<li class="">' . $lua_output_link . '</li>';
	}
}

if($priv_users == 1)
{
	if (preg_match("/(.*)users\.php(.*)/", $_SERVER['PHP_SELF'])) {
	    $menu .= '<li class="active">' . $users_link . '</li>';
	} else {
	    $menu .= '<li class="">' . $users_link . '</li>';
	}
}

if($logged_in == 0) {
	$menu .= '<li>' . $register_link . '</li>';
	$page->set_var('register_link',$register_link);
}

if (preg_match("/(.*)roster\.php(.*)/", $_SERVER['PHP_SELF'])) {
    $menu .= '<li class="active">' . $roster_link . '</li>';
} else {
    $menu .= '<li class="">' . $roster_link . '</li>';
}

// If integration with EQDKP is enabled, add a link here.
if ($phpraid_config['enable_eqdkp'])
{
	if (preg_match("/(.*)dkp_view\.php(.*)/", $_SERVER['PHP_SELF'])) {
		$menu .= '<li class="active">' . $dkp_view_link . '</li>';
	} else {
		$menu .= '<li class="">' . $dkp_view_link . '</li>';
	}
}

$menu .= '</ul></div>';

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