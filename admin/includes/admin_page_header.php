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
$profile_id = scrub_input($_SESSION['profile_id']);

// time variables
$guild_date = get_date(time());
$guild_time = get_time(time());

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
$wrmadminsmarty->display('admin_header.html');

/**************************************************************
 * Show Menu
 **************************************************************/
require_once('../includes/class_menu.php');
$menubar = new wrm_menu($db_raid, $phpraid_config, $phprlang, $profile_id);
$menubar->set_menu_status("admin");
$menubar->wrm_show_menu();

/**************************************************************
 * table stuff between menu and main output frame
 **************************************************************/
$wrmadminsmarty->assign('admin_index_header', $phprlang['admin_index_header']);
$wrmadminsmarty->display('admin_contentContainer.html');

/**************************************************************
 * display any errors if they exist
 **************************************************************/
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

?>