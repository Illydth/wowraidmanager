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

// time variables
$guild_time = new_date($phpraid_config['time_format'],time(),$phpraid_config['timezone'] + $phpraid_config['dst']);
$guild_date = new_date($phpraid_config['date_format'],time(),$phpraid_config['timezone'] + $phpraid_config['dst']);

/**************************************************************
 * Show Login Box / Field
 **************************************************************/
require_once('./includes/class_loginbox.php');
$loginbox = &new wrm_loginbox($db_raid, $phpraid_config, $phprlang, $wrmsmarty);
if (isset($ShowLoginForm) and ($ShowLoginForm == FALSE))
{
	$loginbox->set_loginbox_show_status(FALSE);
}
if ( ($BridgeSupportPWDChange == TRUE) and isset($BridgeSupportPWDChange) )
{
	$loginbox->set_BridgeSupportPWDChange_status(FALSE);
}
$login_form = $loginbox->wrm_show_loginbox_gethtmlstring();

$wrmsmarty->assign('page_header_data', 
	array(
		'header_link' => $phpraid_config['header_link'],
		'title_guild_name'=>$phpraid_config['site_name'],
		'title_guild_server'=>$phpraid_config['site_server'],
		'title_guild_description'=>$phpraid_config['site_description'],
		'header_logo' => $phpraid_config['header_logo'],
		'login_form' => $login_form,
		'guild_time' => $guild_time,
		'guild_date' => $guild_date,
		'of_string'=>$phprlang['of'],
		'rss_feed_string'=>$phprlang['rss_feed_text'],
		'guild_time_string'=>$phprlang['guild_time_string'],
		'header_link'=>$phpraid_config['header_link'],
	)
);

$wrmsmarty->display('header.html');

/**************************************************************
 * Show Menu
 **************************************************************/
require_once('./includes/class_menu.php');
$menubar = &new wrm_menu($db_raid, $phpraid_config, $phprlang, $wrmsmarty);
$menubar->wrm_show_menu();

/**************************************************************
 * table stuff between menu and main output frame
 **************************************************************/
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