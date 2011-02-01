<?php
/***************************************************************************
*                           functions_tooltip.php
*                           ---------------------
*   begin                : Feb 01, 2011
*   copyright            : (C) 2007-2011 Carsten Hölbing
*   email                : carsten@hoelbing.net
*
*   -- WoW Raid Manager --
*   copyright            : (C) 2007-2011 Douglas Wagner
*   email                : douglasw0@yahoo.com
*   www		  			 : http://www.wowraidmanager.net
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
 * Tooltip about a Raid
 */
function get_raid_tooltip($raid_id)
{
	global $db_raid,$phpraid_config,$phprlang;
	
	//$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "raids";
	$sql =	sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "raids ".
					" WHERE raid_id=%s",quote_smart($raid_id));
	$raids_result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	$raids = $db_raid->sql_fetchrow($raids_result, true); 

	$desc = scrub_input($raids['description']);
	$desc = str_replace("'", "\'", $desc);
	$raid_txt_desc = "'<span class=tooltip_title>" . $phprlang['description'] ."</span><br>" . DEUBB2($desc);
	
	$raid_txt_info = "------------------";
	$raid_txt_info .= "<br>".$phprlang['location'].": ". $raids['location'];
	$raid_txt_info .= "<br>".$phprlang['officer'].": ". $raids['officer'];
	$raid_txt_info .= "<br>".$phprlang['date'].": ". get_date($raids['start_time']);
	$raid_txt_info .= "<br>".$phprlang['start_time'].": " . get_time_full($raids['start_time']);
	$raid_txt_info .= "<br>".$phprlang['invite_time'].": " . get_time_full($raids['invite_time']);
	$raid_txt_info .= "<br>".$phprlang['raid_force_name'] . ": " . $raids['raid_force_name'];
	$raid_txt_info .= "<br>".$phprlang['min_lvl'] . ": " . $raids['min_lvl'];
	$raid_txt_info .= "<br>".$phprlang['max_lvl'] . ": " . $raids['max_lvl'];	
	$raid_txt_info .= "<br>".$phprlang['totals'].": ".$total.'/' . $raids['max']  . ' (+' . $total2. ')';
	
	$ddrivetiptxt = $raid_txt_desc.'<br>'. $raid_txt_info."'";

	return ($ddrivetiptxt);
}

/**
 *  Tooltip about a Char, information from Armory
 */
function get_armorychar($name, $guild)
{
	global $phpraid_config, $db_raid;

	// Get Armory Data from Guild.
	$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "guilds WHERE guild_id=%s",quote_smart($guild));
	$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	$data = $db_raid->sql_fetchrow($result, true);

	//$realm = str_replace(" ", "+", ucfirst($server));
	$realm = ucfirst($data['guild_server']);
	$lang = strtolower($data['guild_armory_code']);
	// Pre-Cataclysm Armory Links
	//$javascript = '<a href="' . $data['guild_armory_link'] . '/character-sheet.xml?r=' . $realm . '&amp;n=' . ucfirst($name) . '" target="new" onmouseover=\'tooltip.show("includes/wowarmory/char.php?v=' . ucfirst($name) . '&amp;z=' . str_replace("'", "\"+String.fromCharCode(39)+\"", $realm) . '&amp;l=' . $lang . '&amp;u='. $data['guild_armory_link'] .'");\' onmouseout="tooltip.hide();"><strong>' . ucfirst($name) . '</strong></a>';
	// Post-Cataclysm Armory Links.
	$javascript = '<a href="' . $data['guild_armory_link'] . $realm . '/' . ucfirst($name) . '/advanced" target="new" onmouseover=\'tooltip.show("includes/wowarmory/char.php?v=' . ucfirst($name) . '&amp;z=' . str_replace("'", "\"+String.fromCharCode(39)+\"", $realm) . '&amp;l=' . $lang . '&amp;u='. $data['guild_armory_link'] .'");\' onmouseout="tooltip.hide();"><strong>' . ucfirst($name) . '</strong></a>';
	
	if(substr_wrap($name, 0, 1, "UTF-8") == '_')
	{
		$name = substr_wrap($name, 1, (strlen_wrap($name, "UTF-8")-1), "UTF-8");
		$name = '<!-- ' . ucfirst($name) . ' -->' . $javascript;
	}
	else if(substr_wrap($name, 0, 1, "UTF-8") == '(' && substr_wrap($name, strlen_wrap($name) - 1, 1, "UTF-8") == ')')
	{
		$name = substr_wrap($name, 1, strlen_wrap($name, "UTF-8") - 2, "UTF-8");
		$name = '<!-- ' . ucfirst($name) . ' -->' . $javascript;
	}
	else
	{
		$name = '<!-- ' . ucfirst($name) . ' -->' . $javascript;
	}

	return $name;
}

?>