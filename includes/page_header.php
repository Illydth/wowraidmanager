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

$priv_config = scrub_input($_SESSION['priv_configuration']);
$logged_in = scrub_input($_SESSION['session_logged_in']);

// time variables
$guild_time = new_date($phpraid_config['time_format'],time(),$phpraid_config['timezone'] + $phpraid_config['dst']);
$guild_date = new_date($phpraid_config['date_format'],time(),$phpraid_config['timezone'] + $phpraid_config['dst']);

/**************************************************************
 * Show Login Box / Field
 **************************************************************/
// now for the links
if($logged_in != 1)
{
	$login_form_open = '<form action="login.php" method="POST">';
	$login_username = '<input name="username" type="text" value="username" size="15" maxlength="45" onFocus="if(this.value==\'username\')this.value=\'\';" class="post">';
	$login_password = '<input name="password" type="password" value="password" size="15" onFocus="if(this.value==\'password\')this.value=\'\';" class="post">';
	$login_button = '<input type="submit" name="login" value="'.$phprlang['login'].'" style="font-size:10px" class="mainoption">';
	$login_remember = '<input type="checkbox" checked="checked" name="autologin">';
	$login_remember_hidden = '<input type="hidden" value="1" name="autologin">';
	if ( ($BridgeSupportPWDChange == TRUE) and isset($BridgeSupportPWDChange) )
		$login_change_pass = '<a href="login.php?mode=new_pwd">'.$phprlang['login_forgot_password'].'</a>';
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
	//$BridgeSupportPWDChange came from the bridge
	if ( ($BridgeSupportPWDChange == TRUE) and isset($BridgeSupportPWDChange) )
		$login_change_pass = '<a href="login.php?mode=ch_pwd">'.$phprlang['login_chpwd'].'</a>';
	if ( $priv_config )
		$admin_config_link = '<a href="admin/admin_index.php?'.SID.'">'.$phprlang['admin_section_link'].'</a>';
//	else
//		echo "Priv Config not Set.";
	$login_form_close = '</form>';
}
 
if (isset($ShowLoginForm) and ($ShowLoginForm == FALSE))
{
	$login_form_open=$login_username=$login_change_pass=$login_password=$login_button=$login_remember=$login_remember_hidden=$login_form_close = "";
}

$wrmsmarty->assign('page_header_data', 
		array(
			'header_link' => $phpraid_config['header_link'],
			'title_guild_name'=>$phpraid_config['site_name'],
			'title_guild_server'=>$phpraid_config['site_server'],
			'title_guild_description'=>$phpraid_config['site_description'],
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
			'of_string'=>$phprlang['of'],
			'rss_feed_string'=>$phprlang['rss_feed_text'],
			'guild_time_string'=>$phprlang['guild_time_string'],
			'menu_header_text'=>$phprlang['menu_header_text'], //
			'dkp_url'=>$phpraid_config['eqdkp_url'],//
			'header_link'=>$phpraid_config['header_link'],
			'admin_config_link'=>$admin_config_link,
	)
);

$wrmsmarty->display('header.html');

/**************************************************************
 * Show Menu
 **************************************************************/
require_once('./includes/class_menu.php');
$menubar = &new wrm_menu($db_raid, $phpraid_config, $phprlang, $wrmsmarty);
$menubar->wrm_show_menu();


$wrmsmarty->display('menu_mainfrm.html');

/**************************************************************
 * Show error_site_disable if they disable
 **************************************************************/
if(($phpraid_config['disable'] == '1') AND ($priv_config == 1))
{
	$wrmsmarty->assign('error_data', 
		array(
			'site_disabled_header' => $phprlang['disabled_header'],
			'site_disabled_message' => $phprlang['disabled_message']
		)
	);
	$wrmsmarty->display('error_site_disable.html');
}

/**************************************************************
 * display any errors if they exist
 **************************************************************/
if(isset($errorMsg))
{
	
	if(isset($errorSpace) && $errorSpace == 1) {
		$errorMsg .= '</div><br>';
	} else {
		$errorMsg .= '</div>';
	}

	$wrmsmarty->assign('error_data', 
	  array(
		'error_msg' => $errorMsg,
		'error_title' => $errorTitle)
	);
	$wrmsmarty->display('error.html');
	
	// is the error fatal?
	if($errorDie)
	{
		require_once('page_footer.php');
		exit;
	}
}

?>