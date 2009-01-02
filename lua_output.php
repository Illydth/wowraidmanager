<?php
/***************************************************************************
 *                              lua_output.php
 *                            -------------------
 *   begin                : Saturday, Jan 16, 2005
 *   copyright            : (C) 2007-2008 Douglas Wagner
 *   email                : douglasw@wagnerweb.org
 *
 *   $Id: lua_output.php,v 2.00 2008/03/08 13:47:28 psotfx Exp $
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
// commons
define("IN_PHPRAID", true);	
require_once('./common.php');

// page authentication
// page authentication
if ($phpraid_config['enable_five_man'])
{ 
	define("PAGE_LVL","profile");
}
else
{
	define("PAGE_LVL","raids");
}

$raid_id = scrub_input($_GET['raid_id']);

require_once("includes/authentication.php");
require_once('./lua_output_data.php');

if($phpraid_config['showphpraid_addon'] == 1)
	if ($phpraid_config['lua_output_format'] == "1")
	{
		$phpraid_addon_link = '<a href="http://www.wowraidmanager.net">' . $phprlang['rim_download'] . '</a>';
	}
	else
	{
		$phpraid_addon_link = '<a href="' . $phpraid_config['phpraid_addon_link'] . '">' . $phprlang['lua_download'] . '</a>';
	}
else
	$phpraid_addon_link = '';

//
// Start output of page
//
require_once('includes/page_header.php');

if($phpraid_config['showphpraid_addon'] == 1)
	$wrmsmarty->assign('output_header',$phprlang['lua_header'] . ' - ' . $phpraid_addon_link);
else
	$wrmsmarty->assign('output_header',$phprlang['lua_header']);

$wrmsmarty->assign('output_data', $text);

$wrmsmarty->display('lua_output.html');

require_once('includes/page_footer.php');
?>