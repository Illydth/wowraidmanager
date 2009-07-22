<?php
/***************************************************************************
 *                             configuration.php
 *                            -------------------
 *   begin                : Saturday, Jan 16, 2005
 *   copyright            : (C) 2007-2008 Douglas Wagner
 *   email                : douglasw@wagnerweb.org
 *
 *   $Id: configuration.php,v 2.00 2007/11/23 14:51:03 psotfx Exp $
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
define("PAGE_LVL","configuration");
require_once("includes/authentication.php");
 
// now the faction
$faction = '<select name="faction">';
if($phpraid_config['faction'] == 'alliance')
   	$faction .= '<option value="alliance" selected>Alliance</option><option value="horde">Horde</option>';
else
	$faction .= '<option value="alliance">Alliance</option><option value="horde" selected>Horde</option>';
$faction .= '</select>';

// default group
$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "permissions";
$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);

$default = '<select name="default" class="post"><option value="nil">'.$phprlang['none'].'</option>';

while($data = $db_raid->sql_fetchrow($result, true))
{
	if($phpraid_config['default_group'] == $data['permission_id'])
		$default .= '<option value="'.$data['permission_id'].'" selected>'.$data['name'].'</option>';
	else
		$default .= '<option value="'.$data['permission_id'].'">'.$data['name'].'</option>';
}

$default .= '</select>';

// Selection box for Appropriate Armory.
$armory_box = '<select name="armory_link" class="post">';
if ($phpraid_config['armory_link'] == 'http://www.wowarmory.com')
	$armory_box .=   '<option value="http://www.wowarmory.com" selected>http://www.wowarmory.com</option>';
else
	$armory_box .=   '<option value="http://www.wowarmory.com">http://www.wowarmory.com</option>';
if ($phpraid_config['armory_link'] == 'http://eu.wowarmory.com')
	$armory_box .=   '<option value="http://eu.wowarmory.com" selected>http://eu.wowarmory.com</option>';
else
	$armory_box .=   '<option value="http://eu.wowarmory.com">http://eu.wowarmory.com</option>';
if ($phpraid_config['armory_link'] == 'http://kr.wowarmory.com')
	$armory_box .=   '<option value="http://kr.wowarmory.com" selected>http://kr.wowarmory.com</option>';
else
	$armory_box .=   '<option value="http://kr.wowarmory.com">http://kr.wowarmory.com</option>';
if ($phpraid_config['armory_link'] == 'http://tw.wowarmory.com')
	$armory_box .=   '<option value="http://tw.wowarmory.com" selected>http://tw.wowarmory.com</option>';
else
	$armory_box .=   '<option value="http://tw.wowarmory.com">http://tw.wowarmory.com</option>';
$armory_box .= '</select>';

// Set up the input boxes.
$guild_name = '<input name="guild_name" type="text" id="guild_name" value="' . $phpraid_config['guild_name'] . '" maxlength="255" class="post">';
$guild_description = '<input name="guild_description" type="text" id="guild_description" value="' . $phpraid_config['guild_description'] . '" maxlength="255" class="post">';
$guild_server = '<input name="guild_server" type="text" id="guild_server" value="' . $phpraid_config['guild_server'] . '" maxlength="255" class="post">';
$buttons = '<input type="submit" name="submit" value="'.$phprlang['submit'].'" class="mainoption"> <input type="reset" name="Reset" value="'.$phprlang['reset'].'" class="liteoption">';
$armory_language = '<input name="armory_language" type="text" value="'.$phpraid_config['armory_language'].'" size="4" class="post">';

// put the variables into the template
$wrmsmarty->assign('role_data', $role_data);
$wrmsmarty->assign('config_data',
	array(
		'guild_name' => $guild_name,
		'guild_description' => $guild_description,
		'guild_server' => $guild_server,
		'armory_link' => $armory_box,
		'armory_language' => $armory_language,
		'faction' => $faction,
		'buttons' => $buttons,
		'armory_link_text' => $phprlang['configuration_armory_link_text'],
		'armory_language_text' => $phprlang['configuration_armory_language_text'],
		'guild_configure' => $phprlang['configuration_guild_header'],
		'guild_name_text' => $phprlang['configuration_guild_name'],
		'description_text' => $phprlang['configuration_description'],
		'server_text' => $phprlang['configuration_server'],
		'faction_text' =>$phprlang['configuration_faction'],
		'auth_text' => $phprlang['configuration_auth'],
		'putonsignup_text' => $phprlang['configuration_putonsignup'],
		'default'=>$default,
		'default_text'=>$phprlang['configuration_default'],

		'guild_configure_header'=>$phprlang['configuration_guild_header'],
	)
);



if(isset($_POST['submit']))
{
 	if(isset($_POST['show_id']))
	 	$show_id = 1;
 	else
 		$show_id = 0;
 		
	$armory_link = scrub_input($_POST['armory_link']);
	$armory_language = scrub_input($_POST['armory_language']);
	
	$g_name = scrub_input(DEUBB($_POST['guild_name']));
	$g_desc =  scrub_input(DEUBB($_POST['guild_description']));
	$g_server =  scrub_input(DEUBB($_POST['guild_server']));
	$faction = scrub_input($_POST['faction']);
	$default =  scrub_input(DEUBB($_POST['default']));

	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'armory_link';", quote_smart($armory_link));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error($sql),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'armory_language';", quote_smart($armory_language));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error($sql),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'faction';", quote_smart($faction));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'guild_description';", quote_smart($g_desc));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'guild_name';", quote_smart($g_name));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'guild_server';", quote_smart($g_server));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'default_group';", quote_smart($default));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);

	header("Location: configuration.php");
}

//
// Start output of page
//
require_once('includes/page_header.php');

$wrmsmarty->display('configuration.html');

require_once('includes/page_footer.php');
?>