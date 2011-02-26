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
	/* HTML MENUBAR construction:
	 * 
	 * <div class="menuHeader">MENU_LIST_MAIN_HEADER_NAME</div>
	 * 
	 * <div align="left" class="navContainer">
	 *   <ul class="navList">
	 *     ...
	 *     <li class="active"> YYYYY_link </li>
	 *     ...
	 *   </ul>
	 *   
	 * </div>
	 * 
	 * YYYYY_link = menu_type_id with all values
	 */

	//gerneral stuff
	var $db_raid ;
	var $phpraid_config;
	var $phprlang;
	var $wrmsmarty;
	var $profile_id;
	var $menu_status;
	var $connection;

	//
	// Constructor
	//
	public function wrm_menu($db_raid, $phpraid_config, $phprlang, $profile_id)
	{
		$this->db_raid = $db_raid;	
		$this->phpraid_config = $phpraid_config;
		$this->phprlang = $phprlang;
		$this->profile_id = $profile_id;
	}
	
	public function wrm_show_menu()
	{
		echo $this->create_menubar();
	}
	

	public function create_menubar()
	{
		$htmlstring = '<td id="leftMenuBackground" width="150px" valign="top">';

		$sql = sprintf("SELECT * FROM " . $this->phpraid_config['db_prefix'] . "menu_type ".
						" WHERE `show_area` = %s ORDER BY `menu_type_id` ASC", 
						quote_smart($this->menu_status));
			
		//for testing => show all menu entrys
		//	$sql = "SELECT * FROM " . $this->phpraid_config['db_prefix'] . "menu_type";
	
		$result = $this->db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);			
		while($table_data = $this->db_raid->sql_fetchrow($result, true))
		{
			$menu_type_id = $table_data['menu_type_id'];

			
			$menuHeader = $this->get_html_menuHeader_value($menu_type_id);
			$navList = $this->get_html_navList_value($menu_type_id);
			
			if ($navList != "")
			{
				$htmlstring .= $menuHeader . $navList ."<br/>";
			}
		}
		
		$htmlstring .= "</td>";
		return $htmlstring;
	}
	
	// available menu_status: admin, normal
	public function set_menu_status($menu_status)
	{
		$this->menu_status = $menu_status;
	}
	
	
	/****************************************************************************
	 * HTML Section
	****************************************************************************/
	
	/**
	 * 
	 * @param integer $menu_type_id
	 */
	private function get_html_menuHeader_value($menu_type_id)
	{
		$sql = sprintf("SELECT * FROM " . $this->phpraid_config['db_prefix'] . "menu_type ".
						" WHERE `menu_type_id` = %s", quote_smart($menu_type_id));
		$result = $this->db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);			
		$table_data = $this->db_raid->sql_fetchrow($result, true);

		$htmlstring = '<div class="menuHeader">';
		
		if ($table_data['show_menu_type_title_alt'] == 0) 
			$htmlstring .= $this->phprlang[$table_data['lang_index']];
		else 
			$htmlstring .= $table_data['menu_type_title_alt'];
		
		$htmlstring .= '</div>';

		return $htmlstring;

	}
	
	/**
	 * create to one entry menubar point, the navList
	 * @param integer $menu_type_id
	 */	
	private function get_html_navList_value($menu_type_id)
	{
		$htmlstring_values = "";
		$htmlstring_top = '<div align="left" class="navContainer"><ul class="navList">';
		$htmlstring_down  = '</ul></div>';

		$sql = sprintf("SELECT * FROM " . $this->phpraid_config['db_prefix'] . "menu_value ".
						" WHERE `menu_type_id` = %s  ORDER BY `ordering` ASC", quote_smart($menu_type_id));		
		$result = $this->db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);			
		while($table_data = $this->db_raid->sql_fetchrow($result, true))
		{
			if ( ($table_data['visible'] != 0) and 
				// user must have rights for reading this entry
			   ((check_permission($table_data['permission_value_id'], $this->profile_id) == TRUE)) OR 
			   //or view free for all 
			   ($table_data['permission_value_id'] == NULL))
			{
				$link = '<a href="'.$table_data['link'].'">';
				
				//show alternative menu titel ?
				if ($table_data['show_menu_value_title_alt'] == 0) 
					$link .= $this->phprlang[$table_data['lang_index']];
				else 
					$link .= $table_data['menu_value_title_alt'];
				$link .= "</a>";

				if ( ($table_data['filename_without_ext'] != "") AND (preg_match("/(.*)".$table_data['filename_without_ext']."\.php(.*)/", $_SERVER['PHP_SELF'])) )
				{
					$htmlstring_values .= '<li class="active">' . $link . '</li>';
				}
				else 
				{
					    $htmlstring_values .= '<li class="">' . $link . '</li>';
				}
			}	  
		}
	
		// if entry not empty then is return value a full list entry 
		// otherwise return value == empty
		if ($htmlstring_values != "")
		{
			$htmlstring = $htmlstring_top . $htmlstring_values . $htmlstring_down;
		}
		else 
		{
			$htmlstring = "";
		}
	
		return $htmlstring;
	}
	
}  //end class wrm_menu

?>