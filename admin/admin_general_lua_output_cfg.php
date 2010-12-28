<?php
/***************************************************************************
                      admin_general_lua_output_cfg.php
 *                    --------------------------------
 *   begin                : Sun, Dec. 26, 2010
 *	 Dev                  : Douglas Wagner
 *	 email                : douglasw@wagnerweb.org
 *
 *   copyright            : (C) 2007-2009 Douglas Wagner
 *   email                : douglasw@wagnerweb.org
 *
 ***************************************************************************/

/***************************************************************************
*
*    WoW Raid Manager - Raid Management Software for World of Warcraft
*    Copyright (C) 2007-2009 Douglas Wagner
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
require_once('./admin_common.php');

/*************************************************
 * Access Authorization Section
 *************************************************/
// page authentication
define("PAGE_LVL","configuration");
require_once("../includes/authentication.php");	

$page_url = "admin_general_lua_output_cfg.php";

if(isset($_POST['submit']))
{
	$sort_signups = scrub_input($_POST['lua_output_sort_signups']);
	$sort_queue = scrub_input($_POST['lua_output_sort_queue']);
	$output_format = scrub_input($_POST['lua_output_format']);
	
	// Update Sort Signups
	$sql = sprintf("UPDATE " . $phpraid_config['db_prefix'] . "config 
					SET config_value=%s
					WHERE config_name='lua_output_sort_signups'", quote_smart($sort_signups));
	$db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);				
					
	// Update Sort Queued
	$sql = sprintf("UPDATE " . $phpraid_config['db_prefix'] . "config 
					SET config_value=%s
					WHERE config_name='lua_output_sort_queue'", quote_smart($sort_queue));
	$db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);				
	
	// Update Output Format
	$sql = sprintf("UPDATE " . $phpraid_config['db_prefix'] . "config 
					SET config_value=%s
					WHERE config_name='lua_output_format'", quote_smart($output_format));
	$db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);				
	
	header("Location: ".$page_url);
}

// Standard Display of Page
	
$lua_output_form = array();
	
isset($_GET['raid_id']) ? $raid_id = scrub_input($_GET['raid_id']) : $raid_id = '';
isset($_GET['raid_id']) ? $raid_id_set = 1 : $raid_id_set = 0;

/******************************
 * Setup Options Boxes.
 ******************************/
// Sort Signups Option Box.
$sort_signups_option = '<select name="lua_output_sort_signups" size=1>';
if ($phpraid_config['lua_output_sort_signups']==2)
{
	$sort_signups_option .= '<option value="1">'.$phprlang['sort_name'].'</option>';
	$sort_signups_option .= '<option SELECTED value="2">'.$phprlang['sort_date'].'</option>';
}
else
{
	$sort_signups_option .= '<option SELECTED value="1">'.$phprlang['sort_name'].'</option>';
	$sort_signups_option .= '<option value="2">'.$phprlang['sort_date'].'</option>';
}
$sort_signups_option .= '</select>';

// Sort Queued Option Box.
$sort_queue_option = '<select name="lua_output_sort_queue" size=1>';
if ($phpraid_config['lua_output_sort_queue']==2)
{
	$sort_queue_option .= '<option value="1">'.$phprlang['sort_name'].'</option>';
	$sort_queue_option .= '<option SELECTED value="2">'.$phprlang['sort_date'].'</option>';
}
else
{
	$sort_queue_option .= '<option SELECTED value="1">'.$phprlang['sort_name'].'</option>';
	$sort_queue_option .= '<option value="2">'.$phprlang['sort_date'].'</option>';
}
$sort_queue_option .= '</select>';

// Output Format Option Box.
$output_format_option = '<select name="lua_output_format" size=1>';
if ($phpraid_config['lua_output_format']==2)
{
	$output_format_option .= '<option value="1">'.$phprlang['output_rim'].'</option>';
	$output_format_option .= '<option SELECTED value="2">'.$phprlang['output_phprv'].'</option>';
}
else
{
	$output_format_option .= '<option SELECTED value="1">'.$phprlang['output_rim'].'</option>';
	$output_format_option .= '<option value="2">'.$phprlang['output_phprv'].'</option>';
}
$output_format_option .= '</select>';

//Set the Form Action
$form_action = 'admin_general_lua_output_cfg.php';

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
	
$wrmadminsmarty->assign('lua_output_form',
	array(
		'sort_signups_text'=>$phprlang['sort_signups_text'],
		'sort_signups'=>$sort_signups_option,
		'sort_queue_text'=>$phprlang['sort_queue_text'],
		'sort_queue'=>$sort_queue_option,
		'output_format_text'=>$phprlang['output_format_text'],
		'output_format'=>$output_format_option,
		'form_action'=>$form_action,
		'options_header'=>$phprlang['options_header'],
		'raid_id_set'=>$raid_id_set,
		'Buttons'=>$buttons,
	)
);



//
// Start output of page
//
require_once('./includes/admin_page_header.php');

if($phpraid_config['showphpraid_addon'] == 1)
	$wrmadminsmarty->assign('options_header',$phprlang['lua_header'] . ' - ' . $phpraid_addon_link);
else
	$wrmadminsmarty->assign('options_header',$phprlang['lua_header']);

$wrmadminsmarty->display('admin_lua_output_cfg.html');

require_once('./includes/admin_page_footer.php');

?>