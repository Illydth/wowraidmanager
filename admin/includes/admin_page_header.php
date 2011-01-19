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
/**
 * 
 * return a html string with a list field
 * @param integer $menu_type_id
 */
function get_htmlstring_menu_list($menu_type_id)
{
	global $phpraid_config, $db_raid, $phprlang;

	$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "menu_type WHERE `menu_type_id` = ".$menu_type_id;
	$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);			
	while($table_data = $db_raid->sql_fetchrow($result, true))
	{
		$htmlstring = '<div class="menuHeader">';
		
		if ($table_data['show_menu_type_title_alt'] == 0) 
			$htmlstring .= $phprlang[$table_data['lang_index']];
		else 
			$htmlstring .= $table_data['menu_type_title_alt'];
		
		$htmlstring .= '</div>';
	}
	
	
	$htmlstring .= '<div align="left" class="navContainer"><ul class="navList">';
	
	//SELECT * FROM `wrm_menu_value` WHERE `menu_type_id` = "1" ORDER BY `ordering` ASC
	$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "menu_value WHERE `menu_type_id` = ".$menu_type_id." ORDER BY `ordering` ASC";
	$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);			
	while($table_data = $db_raid->sql_fetchrow($result, true))
	{
		if (($table_data['visible'] != 0) and (verify_user_listentry($table_data['permission_value_id']) == TRUE))
		{
			$link = '<a href="'.$table_data['link'].'">';
			if ($table_data['show_menu_value_title_alt'] == 0) 
				$link .= $phprlang[$table_data['lang_index']];
			else 
				$link .= $table_data['menu_value_title_alt'];
			$link .= "</a>";
		
			if($table_data['filename_without_ext'] == "")
			{
				$htmlstring .= '<li class="">' . $link . '</li>';
			}
			
			else if (preg_match("/(.*)".$table_data['filename_without_ext']."\.php(.*)/", $_SERVER['PHP_SELF']) )
			{
				$htmlstring .= '<li class="active">' . $link . '</li>';
			}
			else 
			{
				    $htmlstring .= '<li class="">' . $link . '</li>';
			}
		}	  
	}

	$htmlstring .= '</ul></div>';

	return $htmlstring;
}

/*
verify user if they have rights for show the selected list entry
TRUE = correct privileges
False =  not enough rights
*/
function verify_user_listentry($permission_value_id)
{
	if (($permission_value_id == 1) and (scrub_input($_SESSION['priv_announcements']) == 1))
		return TRUE;
	if (($permission_value_id == 2) and (scrub_input($_SESSION['priv_configuration']) == 1))
		return TRUE;
	if (($permission_value_id == 3) and (scrub_input($_SESSION['priv_guilds']) == 1))
		return TRUE;
	if (($permission_value_id == 4) and (scrub_input($_SESSION['priv_locations']) == 1))
		return TRUE;
	if (($permission_value_id == 5) and (scrub_input($_SESSION['priv_profile']) == 1))
		return TRUE;
	if (($permission_value_id == 6) and (scrub_input($_SESSION['priv_raids']) == 1))
		return TRUE;

	//error 
	return FALSE;
}

function get_htmlstring_full_menu($usage)
{
	global $phpraid_config, $db_raid;

	$htmlstring = "";

	if ($usage!="")
		$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "menu_type WHERE `show_area` = '".$usage."' ORDER BY `menu_type_id` ASC";
	else //for testing
		$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "menu_type";
			
	$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);			
	while($table_data = $db_raid->sql_fetchrow($result, true))
	{
		$htmlstring .= get_htmlstring_menu_list($table_data['menu_type_id'])."<br/>";
	}

	return $htmlstring;
}

header('Content-Type: text/html; charset=utf-8');

$priv_config=scrub_input($_SESSION['priv_configuration']);
//$logged_in=scrub_input($_SESSION['session_logged_in']);

// time variables
$guild_time = new_date($phpraid_config['time_format'],time(),$phpraid_config['timezone'] + $phpraid_config['dst']);
$guild_date = new_date($phpraid_config['date_format'],time(),$phpraid_config['timezone'] + $phpraid_config['dst']);

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

$wrmadminsmarty->assign('admin_menu', get_htmlstring_full_menu("admin"));
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
