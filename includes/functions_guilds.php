<?php
/***************************************************************************
*                           functions_guilds.php
*                           ---------------------
*   begin                : Wed, Sep 01, 2010
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

function guild_add_new($master,$name,$short,$description,$server,$faction,$link,$code)
{	
	global $phpraid_config, $db_raid;
	
	$sql = sprintf("INSERT INTO " . $phpraid_config['db_prefix'] . "guilds 
		(`guild_master`,`guild_name`,`guild_tag`,`guild_description`,`guild_server`,
		`guild_faction`,`guild_armory_link`,`guild_armory_code`) 
		VALUES (%s,%s,%s,%s,%s,%s,%s,%s)",quote_smart($master),quote_smart($name),
		quote_smart($short),quote_smart($description),quote_smart($server),
		quote_smart($faction),quote_smart($link),quote_smart($code));
	
	$db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	
	log_create('guild',mysql_insert_id(),$name);
}

function guild_edit($name,$short,$master,$description,$server,$faction,$link,$code,$id)
{	
	global $phpraid_config, $db_raid;

	$sql = sprintf("UPDATE " . $phpraid_config['db_prefix'] . "guilds 
		SET guild_name=%s,guild_tag=%s,guild_master=%s,guild_description=%s,
		guild_server=%s,guild_faction=%s,guild_armory_link=%s,guild_armory_code=%s 
		WHERE guild_id=%s",quote_smart($name),quote_smart($short),
		quote_smart($master),quote_smart($description),quote_smart($server),
		quote_smart($faction),quote_smart($link),quote_smart($code),
		quote_smart($id));
	$db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
}

function guild_remove($n, $id)
{	
	global $phpraid_config, $db_raid;
	
	log_delete('guild',$n);
	
	$sql = sprintf("DELETE FROM " . $phpraid_config['db_prefix'] . "guilds WHERE guild_id=%s",quote_smart($id));
	$db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	
	// Deleting the guild, set all characters to a guild ID of "0" to denote they are not attached to a guild.
	$sql = sprintf("UPDATE " . $phpraid_config['db_prefix'] . "chars SET guild = '0' WHERE guild = %s",quote_smart($id));
	$db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
}

/*
 * Get Armory Link from code
 * @return string
 */
function get_armory_link_from_code($code)
{

	if ($code == 'US')
		$link = 'http://www.wowarmory.com';

	elseif ($code == 'EU')
		$link = 'http://eu.wowarmory.com';

	elseif ($code == 'DE')
		$link = 'http://eu.wowarmory.com';

	elseif ($code == 'ES')
		$link = 'http://eu.wowarmory.com';

	elseif ($code == 'FR')
		$link = 'http://eu.wowarmory.com';

	elseif ($code == 'KR')
		$link = 'http://kr.wowarmory.com';

	elseif ($code == 'TW')
		$link = 'http://tw.wowarmory.com';
	else
		$link = '';
			
	return ($link);
}

/*
 * Selection Array for Armory Code, full
 * @return array
 */
function get_armory_code_full()
{
	$array_armory_code = array();

	$array_armory_code["US"] = "US : http://www.wowarmory.com : English";
	$array_armory_code["EU"] = "EU : http://eu.wowarmory.com : English";
	$array_armory_code["DE"] = "DE : http://eu.wowarmory.com : German";
	$array_armory_code["ES"] = "ES : http://eu.wowarmory.com : Spanish";
	$array_armory_code["FR"] = "FR : http://eu.wowarmory.com : French";
	$array_armory_code["KR"] = "KR : http://kr.wowarmory.com : Korean";
	$array_armory_code["TW"] = "TW : http://tw.wowarmory.com : Taiwaines";
	$array_armory_code["None"] = "No Armory or Not Applicable";
	
	return $array_armory_code;
}
?>
