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
if ($phpraid_config['enable_five_man'])
{ 
	define("PAGE_LVL","profile");
}
else
{
	define("PAGE_LVL","raids");
}

if ($phpraid_config['lua_output_format']==1)
	require_once('./lua_output_data_RIM.php');
else
	require_once('./lua_output_data_phpRaidViewer.php');

// Standard Display of Page
if($_GET['mode'] == 'lua') 
{
	$lua_output_data = array();
	
	isset($_GET['raid_id']) ? $raid_id = scrub_input($_GET['raid_id']) : $raid_id = '';
	isset($_GET['raid_id']) ? $raid_id_set = 1 : $raid_id_set = 0;

	//Create the Download Header if Configured to do so.
	if($phpraid_config['showphpraid_addon'] == 1)
		if ($phpraid_config['lua_output_format'] == "1")
			$phpraid_addon_link = '<a href="http://www.wowraidmanager.net">' . $phprlang['rim_download'] . '</a>';
		else
			$phpraid_addon_link = '<a href="http://wow.curse.com/downloads/wow-addons/details/phpraider-viewer.aspx">' . $phprlang['phprv_download'] . '</a>';
	else
		$phpraid_addon_link = '';
	
	//Create the Submit/Apply Options button.
	$buttons = '<input name="submit" type="submit" id="submit" value="'.$phprlang['apply'].'" class="mainoption"> <input type="reset" name="Reset" value="'.$phprlang['reset'].'" class="liteoption">';
		
	$wrmsmarty->assign('lua_output_form',
		array(
			'options_header'=>$phprlang['options_header'],
			'raid_id_set'=>$raid_id_set,
			'Buttons'=>$buttons,
		)
	);
	
	//Generate LUA Output
	$text = '';
	// open/create file
	$file = fopen('cache/raid_lua/phpRaid_Data.lua','w');
	if ($file == FALSE)
		$failed_to_open=TRUE;

	// output to textarea
	if ( $failed_to_open == TRUE)
		$text = $phprlang['lua_failed_to_write'];	
	else
		if ($phpraid_config['lua_output_format'] == 1)
			$text = $phprlang['lua_rim_write_success'];
		else
			$text = $phprlang['lua_prv_write_success'];

	// Set the Where Clause for the Raid Selection.  Set here so that we can allow the user to display all raids by re-opening the lua_output
	//    page without passing a raid_id in.
	if (isset($raid_id) && is_numeric($raid_id))
	{
		$text .= "<a href=\"lua_output.php?mode=lua\">".$phprlang['lua_show_all_raids']."</a><br><br>";
		$raid_sql_where = "raid_id=".quote_smart($raid_id);
	}
	else
		$raid_sql_where = 'old=0';
	
	if ($phpraid_config['lua_output_format'] == 1)
		$lua_output = output_lua_rim();
	else
		$lua_output = output_lua_prv();
		
	// write to lua_output file
	$output = "\xEF\xBB\xBF" . $lua_output;
	fwrite($file, $output);
			
	$wrmsmarty->assign('lua_output_data',
		array(
			'output_header'=>$phprlang['lua_output_header'],
			'intro_text'=>$text,
			'lua_output'=>$lua_output,
		)
	);
	
	if ($raid_id_set)
	{
		// Get Macro Output
		$drafted_text = output_macro_drafted($raid_id);
		$queued_text = output_macro_queued($raid_id);
		
		$wrmsmarty->assign('macro_output',
			array(
				'macro_header'=>$phprlang['lua_macro_header'],
				'macro_footer'=>$phprlang['lua_macro_footer'],
				'drafted_users_text'=>$phprlang['lua_drafted'],
				'queued_users_text'=>$phprlang['lua_queued'],
				'drafted_users'=>$drafted_text,
				'queued_users'=>$queued_text,
			)
		);		
	}
}

//
// Start output of page
//
require_once('includes/page_header.php');

if($phpraid_config['showphpraid_addon'] == 1)
	$wrmsmarty->assign('options_header',$phprlang['lua_header'] . ' - ' . $phpraid_addon_link);
else
	$wrmsmarty->assign('options_header',$phprlang['lua_header']);

$wrmsmarty->display('lua_output_new.html');

require_once('includes/page_footer.php');

?>