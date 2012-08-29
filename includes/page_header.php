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

/**************************************************************
 * Show Page Header
**************************************************************/
$wrmtemplate->show_page_default_header();

/**************************************************************
 * Show Menu
 **************************************************************/
$wrmtemplate->wrm_show_default_menus();

/**************************************************************
 * table stuff between menu and main output frame
 **************************************************************/
$wrmsmarty->display('menu_mainfrm.html');

/**************************************************************
 * Show error_site_disable if they disable
 **************************************************************/
if(($phpraid_config['disable'] == '1') AND (scrub_input($_SESSION['priv_configuration']) == 1))
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