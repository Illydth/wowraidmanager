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

// Selection box for Raid View Type.
$raid_view_type = '<select name="raid_view_type" class="post">';
if ($phpraid_config['raid_view_type'] == 'by_class')
	$raid_view_type .=   '<option value="by_class" selected>' . $phprlang['configuration_raid_view_type_class'] . '</option>';
else
	$raid_view_type .=   '<option value="by_class">' . $phprlang['configuration_raid_view_type_class'] . '</option>';
if ($phpraid_config['raid_view_type'] == 'by_role')
	$raid_view_type .=   '<option value="by_role" selected>'. $phprlang['configuration_raid_view_type_role'] . '</option>';
else
	$raid_view_type .=   '<option value="by_role">' . $phprlang['configuration_raid_view_type_role'] . '</option>';
$raid_view_type .= '</select>';

// Set up the input boxes.
$rss_site_url = '<input name="rss_site_url" size="60" type="text" class="post" value="' . $phpraid_config['rss_site_url'] . '">';
$rss_export_url = '<input name="rss_export_url" size="60" type="text" class="post" value="' . $phpraid_config['rss_export_url'] . '">';
$rss_feed_amt = '<input name="rss_feed_amt" size="10" type="text" class="post" value="' . $phpraid_config['rss_feed_amt'] . '">';
$guild_name = '<input name="guild_name" type="text" id="guild_name" value="' . $phpraid_config['guild_name'] . '" maxlength="255" class="post">';
$guild_description = '<input name="guild_description" type="text" id="guild_description" value="' . $phpraid_config['guild_description'] . '" maxlength="255" class="post">';
$guild_server = '<input name="guild_server" type="text" id="guild_server" value="' . $phpraid_config['guild_server'] . '" maxlength="255" class="post">';
$buttons = '<input type="submit" name="submit" value="'.$phprlang['submit'].'" class="mainoption"> <input type="reset" name="Reset" value="'.$phprlang['reset'].'" class="liteoption">';
$armory_language = '<input name="armory_language" type="text" value="'.$phpraid_config['armory_language'].'" size="4" class="post">';

// Setup the Role Boxes based upon what's in the Role table.
$role_data = array();

$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "roles";
$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);

while($data = $db_raid->sql_fetchrow($result, true))
{
	$var = $data['role_id'] . "_name";
	$role_name = '<input name="'.$var.'" type="text" value="'.$data['role_name'].'" size="25" class="post">';
	$role_text = $phprlang[$data['lang_index']];
	
	array_push($role_data,
		array(
			'role_name' => $role_name,
			'role_text' => $role_text,
			)
		);
}

// put the variables into the template
$wrmsmarty->assign('role_data', $role_data);
$wrmsmarty->assign('config_data',
	array(
		'guild_name' => $guild_name,
		'guild_description' => $guild_description,
		'show_id' => $show_id,
		'guild_server' => $guild_server,
		'armory_link' => $armory_box,
		'raid_view_type' => $raid_view_type,
		'armory_language' => $armory_language,
		'faction' => $faction,
		'buttons' => $buttons,
		'armory_link_text' => $phprlang['configuration_armory_link_text'],
		'raid_view_type_text' => $phprlang['configuration_raid_view_type_text'],
		'armory_language_text' => $phprlang['configuration_armory_language_text'],
		'guild_configure' => $phprlang['configuration_guild_header'],
		'guild_name_text' => $phprlang['configuration_guild_name'],
		'description_text' => $phprlang['configuration_description'],
		'server_text' => $phprlang['configuration_server'],
		'faction_text' =>$phprlang['configuration_faction'],
		'site_configure' => $phprlang['configuration_site_header'],
		'rss_site_text' => $phprlang['configuration_rss_site'],
		'rss_export_text' => $phprlang['configuration_rss_export'],
		'rss_feed_amt_txt' => $phprlang['configuration_rss_feed_amt'],
		'rss_site_url' => $rss_site_url,
		'rss_export_url' => $rss_export_url,
		'rss_feed_amt' => $rss_feed_amt,
		'auth_text' => $phprlang['configuration_auth'],
		'putonsignup_text' => $phprlang['configuration_putonsignup'],
		'id_text' => $phprlang['configuration_id'],
		'version_info' => $version_info,
		'default'=>$default,
		'default_text'=>$phprlang['configuration_default'],

		'version_info_header'=>$phprlang['configuration_version_info_header'],
		'site_configure_header'=>$phprlang['configuration_site_header'],
		'guild_configure_header'=>$phprlang['configuration_guild_header'],
		'role_configure_header'=>$phprlang['configuration_role_header'],
	)
);

if(isset($_POST['submit']))
{
 	if(isset($_POST['show_id']))
	 	$show_id = 1;
 	else
 		$show_id = 0;
 		
	$rss_site_url_p = scrub_input($_POST['rss_site_url'], true);
	$rss_export_url_p = scrub_input($_POST['rss_export_url'], true);
	$rss_feed_amt_p = scrub_input($_POST['rss_feed_amt']);
	$armory_link = scrub_input($_POST['armory_link']);
	$raid_view_type = scrub_input($_POST['raid_view_type']);
	$armory_language = scrub_input($_POST['armory_language']);
	
	// Process Roles
	$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "roles";
	$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
	
	while($data = $db_raid->sql_fetchrow($result, true))
	{
		$var = $data['role_id'] . "_name";
		$$var = scrub_input($_POST[$var]);

		if ($data['role_name'] != $$var)
		{
			$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."roles` SET `role_name` = %s WHERE `role_id`= %s;", quote_smart($$var), quote_smart($data['role_id']));
			$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
		}
	}	

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
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'show_id';", quote_smart($show_id));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'default_group';", quote_smart($default));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'rss_site_url';", quote_smart($rss_site_url_p));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'rss_export_url';", quote_smart($rss_export_url_p));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'rss_feed_amt';", quote_smart($rss_feed_amt_p));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'raid_view_type';", quote_smart($raid_view_type));
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