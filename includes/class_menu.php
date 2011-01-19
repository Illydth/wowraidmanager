<?php
/***************************************************************************
*                               class_menu.php
*                            -------------------
*   begin                : Monday, Aug 23, 2010
*   copyright            : (C) 2007-2010 Carsten Hölbing
*   email                : carsten@hoelbing.net
*
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
/*
 *  Menu Stuff
 */
class wrm_menu
{
	//gerneral stuff
	var $db_raid;
	var $phpraid_config;
	var $phprlang;
	var $wrmsmarty;
	

	//
	// Constructor
	//
	function wrm_menu($db_raid, $phpraid_config, $phprlang, $wrmsmarty)
	{
		$this->db_raid = $db_raid;	
		$this->phpraid_config = $phpraid_config;
		$this->phprlang = $phprlang;
		$this->wrmsmarty = $wrmsmarty;
	}
	
	function wrm_show_menu()
	{
		$phpraid_dir = "./";
		$phprlang = $this->phprlang;
		
		$priv_announcement=scrub_input($_SESSION['priv_announcements']);
		$priv_guilds=scrub_input($_SESSION['priv_guilds']);
		$priv_locations=scrub_input($_SESSION['priv_locations']);
		$priv_profile=scrub_input($_SESSION['priv_profile']);
		$priv_raids=scrub_input($_SESSION['priv_raids']);
		$logged_in=scrub_input($_SESSION['session_logged_in']);
		
		/**************************************************************
		 * setup link permissions
		 **************************************************************/
		require_once($phpraid_dir.'templates/' . $this->phpraid_config['template'] . '/theme_cfg.php');

		/**************************************************************
		 * links useable for everyone
		 **************************************************************/
		$index_link = '<a href="' . $this->phpraid_config['header_link'] . '">' . $theme_index_link . '</a>';
		$home_link = '<a href="index.php">' . $theme_home_link . '</a>';
		$calendar_link = '<a href="calendar.php">' . $theme_calendar_link . '</a>';
		$roster_link = '<a href="roster.php">' . $theme_roster_link . '</a>';
		$dkp_view_link = '<a href="dkp_view.php">' . $theme_dkp_link . '</a>';
		$boss_tracking_link = '<a href="bosstracking.php?mode=view">' . $theme_bosstrack_link . '</a>';
		$raids_archive_link = '<a href="raidsarchive.php?mode=view">' . $theme_raids_archive_link . '</a>';

		/**************************************************************
		 * these links need special permissions
		 **************************************************************/
		$priv_announcement ? $announce_link = '<a href="announcements.php?mode=view">' . $theme_announcement_link . '</a>' : $announce_link = '';
		$priv_guilds ?	$guild_link = '<a href="guilds.php?mode=view">' . $theme_guild_link . '</a>' : $guild_link = '';
		$priv_locations ? $locations_link = '<a href="locations.php?mode=view">' . $theme_locations_link . '</a>' : $locations_link = '';
		$priv_profile ? $profile_link = '<a href="profile.php?mode=view">' . $theme_profile_link . '</a>' : $profile_link = '';
		
		$logged_in != '1' ? $register_link = '<a href="' . $this->phpraid_config['register_url'] . '">' . $theme_register_link . '</a>' : $register_link = '';
		
		if ( $priv_raids OR ($this->phpraid_config['enable_five_man'] AND $priv_profile) )
		{
			$raids_link = '<a href="raids.php?mode=view">' . $theme_raids_link . '</a>';
			$lua_output_link = '<a href="lua_output_new.php?mode=lua">' . $theme_lua_output_link . '</a>';
		}
		else
		{
			$raids_link = '';
			$lua_output_link = '';
		}

		/**************************************************************
		 * setup menu
		 **************************************************************/		
		$menu = '<div align="left" class="navContainer">';
		$menu .= '<ul class="navList">';
		
		/**************************************************************
		 * Ignore link to another site
		 **************************************************************/
		$menu .= '<li>' . $index_link . '</li>';
		if (preg_match("/(.*)index\.php(.*)/", $_SERVER['PHP_SELF'])) {
			$menu .= '<li class="active">' . $home_link . '</li>';
		} else {
		    $menu .= '<li class="">' . $home_link . '</li>';
		}
		
		// Show Calendar Link
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
		
		// Show Guild Link		
		if($_SESSION['priv_guilds'] == 1)
		{
			if (preg_match("/(.*)guilds\.php(.*)/", $_SERVER['PHP_SELF'])) {
			    $menu .= '<li class="active">' . $guild_link . '</li>';
			} else {
			    $menu .= '<li class="">' . $guild_link . '</li>';
			}
		}
		
		// Show Locations Link		
		if($_SESSION['priv_locations'] == 1)
		{
			if (preg_match("/(.*)locations\.php(.*)/", $_SERVER['PHP_SELF'])) {
			    $menu .= '<li class="active">' . $locations_link . '</li>';
			} else {
			    $menu .= '<li class="">' . $locations_link . '</li>';
			}
		}
		
		// Show Profile Link
		if($_SESSION['priv_profile'] == 1)
		{
			if (preg_match("/(.*)profile\.php(.*)/", $_SERVER['PHP_SELF'])) {
			    $menu .= '<li class="active">' . $profile_link . '</li>';
			} else {
			    $menu .= '<li class="">' . $profile_link . '</li>';
			}
		}
		
		// Show Raids and lua_output Link		
		if ( $_SESSION['priv_raids'] OR ($this->phpraid_config['enable_five_man'] AND $priv_profile) )
		{
			if (preg_match("/(.*)raids\.php(.*)/", $_SERVER['PHP_SELF'])) {
			    $menu .= '<li class="active">' . $raids_link . '</li>';
			} else {
			    $menu .= '<li class="">' . $raids_link . '</li>';
			}
			if (preg_match("/(.*)lua_output_new\.php(.*)/", $_SERVER['PHP_SELF'])) {
			    $menu .= '<li class="active">' . $lua_output_link . '</li>';
			} else {
			    $menu .= '<li class="">' . $lua_output_link . '</li>';
			}
		}
		
		// Show Register Link		
		if(($logged_in == 0) and ($this->phpraid_config['auth_type']== "iums")) {
			$menu .= '<li>' . $register_link . '</li>';
			$this->wrmsmarty->assign('register_link',$register_link);
		}
		
		if (preg_match("/(.*)roster\.php(.*)/", $_SERVER['PHP_SELF'])) {
		    $menu .= '<li class="active">' . $roster_link . '</li>';
		} else {
		    $menu .= '<li class="">' . $roster_link . '</li>';
		}
		
		// If integration with EQDKP is enabled, add a link here.
		if ($this->phpraid_config['enable_eqdkp'])
		{
			if (preg_match("/(.*)dkp_view\.php(.*)/", $_SERVER['PHP_SELF'])) {
				$menu .= '<li class="active">' . $dkp_view_link . '</li>';
			} else {
				$menu .= '<li class="">' . $dkp_view_link . '</li>';
			}
		}
		
		// Show Boss Kill Tracking Link
		/*if (preg_match("/(.*)bosstracking\.php(.*)/", $_SERVER['PHP_SELF'])) {
			$menu .= '<li class="active">' . $boss_tracking_link . '</li>';
		} else {
			$menu .= '<li class="">' . $boss_tracking_link . '</li>';
		}*/
		
		// Show Raids Archives Link
		if (preg_match("/(.*)raidsarchive\.php(.*)/", $_SERVER['PHP_SELF'])) {
			$menu .= '<li class="active">' . $raids_archive_link . '</li>';
		} else {
			$menu .= '<li class="">' . $raids_archive_link . '</li>';
		}
		
		$menu .= '</ul></div>';


		$this->wrmsmarty->assign('menu_data', 
			array(
				'menu_header_text' => $this->phprlang['menu_header_text'],
				'menu'=> $menu
			)
		);
		$this->wrmsmarty->display('menu.html');
		
	}

	
}  //end class wrm_menu

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

?>