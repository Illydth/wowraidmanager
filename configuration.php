<?php
/***************************************************************************
 *                             configuration.php
 *                            -------------------
 *   begin                : Saturday, Jan 16, 2005
 *   copyright            : (C) 2005 Kyle Spraggs
 *   email                : spiffyjr@gmail.com
 *
 *   $Id: mysql.php,v 1.16 2002/03/19 01:07:36 psotfx Exp $
 *
 ***************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/
// commons
define("IN_PHPRAID", true);	
require_once('./common.php');

// page authentication
define("PAGE_LVL","configuration");
require_once($phpraid_dir.'includes/authentication.php');

// check for new version
// primarily stripped from phpBB version checking
// ingenious ;)
$current_version = explode('.', $version);
$minor_revision = (int) $current_version[2];
$sub_head_revision = (int) $current_version[3];
$sub_middle_revision = (int) $current_version[4];
$sub_minor_revision = (int) $current_version[5];

$errno = 0;
$errstr = $version_info = '';

if ($fsock = @fsockopen('www.warbandofgrey.net', 80, $errno, $errstr, 10))
{
	@fputs($fsock, "GET /vercheck/309.txt HTTP/1.1\r\n");
	@fputs($fsock, "HOST: www.warbandofgrey.net\r\n");
	@fputs($fsock, "Connection: close\r\n\r\n");

	$get_info = false;
	while (!@feof($fsock))
	{
		if ($get_info)
		{
			$version_info .= @fread($fsock, 1024);
		}
		else
		{
			if (@fgets($fsock, 1024) == "\r\n")
			{
				$get_info = true;
			}
		}
	}
	@fclose($fsock);
	$version_info = explode("\n", $version_info);
	$latest_head_revision = (int) $version_info[0];
	$latest_minor_revision = (int) $version_info[2];
	$sub_latest_head_revision = (int) $version_info[4];
	$sub_latest_middle_revision = (int) $version_info[5];
	$sub_latest_minor_revision = (int) $version_info[6];
	$latest_version = (int) $version_info[0] . '.' . (int) $version_info[1] . '.' . (int) $version_info[2] . ' subversion ' . (int) $version_info[4] . '.' . (int) $version_info[5] . '.' . (int) $version_info[6];

	if ($latest_head_revision == 3 && $minor_revision == $latest_minor_revision && $sub_head_revision  == $sub_latest_head_revision && $sub_middle_revision == $sub_latest_middle_revision && $sub_minor_revision == $sub_latest_minor_revision)
	{
		$version_info = '<p style="color:green">' . $phprlang['configuration_version_current'] . '</p>';
	}
	else
	{
		$version_info = '<br><div class="errorHeader">' . $phprlang['configuration_version_outdated_header'] . '</div>';
		$version_info .= '<div class="errorBody">' . sprintf($phprlang['configuration_version_outdated_message'], $latest_version, $version) . '</div><br>';
	}
}
else
{
	if ($errstr)
	{
		$version_info = '<p style="color:red">' . sprintf($phprlang['connect_socket_error'], $errstr) . '</p>';
	}
	else
	{
		$version_info = '<p style="color:red">' . $phprlang['socket_functions_disabled'] . '</p>';
	}
}

// setup variables based on the forum information
// start with the checkboxes
if($phpraid_config['disable'] == '0')
	$disable_site = '<input type="checkbox" name="disable" value="1">';
else
	$disable_site = '<input type="checkbox" name="disable" value="1" checked>';
	
if($phpraid_config['debug'] == '0')
	$debug_mode = '<input type="checkbox" name="debug" value="1">';
else
	$debug_mode = '<input type="checkbox" name="debug" value="1" checked>';
	
if($phpraid_config['multiple_signups'] == '0')
	$allow_multiple_signups = '<input type="checkbox" name="multiple_signups" value="1">';
else
	$allow_multiple_signups = '<input type="checkbox" name="multiple_signups" value="1" checked>';

if($phpraid_config['resop'] == '0')
	$allow_resop = '<input type="checkbox" name="resop" value="1">';
else
	$allow_resop = '<input type="checkbox" name="resop" value="1" checked>';

if($phpraid_config['putonqueue'] == '0')
	$allow_putonqueue = '<input type="checkbox" name="putonqueue" value="1">';
else
	$allow_putonqueue = '<input type="checkbox" name="putonqueue" value="1" checked>';
	
if($phpraid_config['dst'] == '0')
	$dst = '<input type="checkbox" name="dst" value="1">';
else
	$dst = '<input type="checkbox" name="dst" value="1" checked>';
	
if($phpraid_config['roster_integration'] == '0')
	$roster = '<input type="checkbox" name="roster" value="1">';
else
	$roster = '<input type="checkbox" name="roster" value="1" checked>';
	
if($phpraid_config['anon_view'] == '0')
	$allow_anonymous_viewing = '<input type="checkbox" name="anon_view" value="1">';
else
	$allow_anonymous_viewing = '<input type="checkbox" name="anon_view" value="1" checked>';
	
if($phpraid_config['disable_freeze'] == '0')
	$disable_freeze = '<input type="checkbox" name="disable_freeze" value="1">';
else
	$disable_freeze = '<input type="checkbox" name="disable_freeze" value="1" checked>';
	
if($phpraid_config['auto_queue'] == '0')
	$auto_queue = '<input type="checkbox" name="auto_queue" value="1">';
else
	$auto_queue = '<input type="checkbox" name="auto_queue" value="1" checked>';

if($phpraid_config['show_id'] == '0')
	$show_id = '<input type="checkbox" name="show_id" value="1">';
else
	$show_id = '<input type="checkbox" name="show_id" value="1" checked>';
 
if($phpraid_config['showphpraid_addon'] == '0')
	$showphpraid_addon = '<input type="checkbox" name="showphpraid_addon" value="1">';
else
	$showphpraid_addon = '<input type="checkbox" name="showphpraid_addon" value="1" checked>';
	
// now the faction
$faction = '<select name="faction">';
if($phpraid_config['faction'] == 'alliance')
   	$faction .= '<option value="alliance" selected>Alliance</option><option value="horde">Horde</option>';
else
	$faction .= '<option value="alliance">Alliance</option><option value="horde" selected>Horde</option>';
$faction .= '</select>';

$date_format = '<input name="date_format" type="text" class="post"  value="' . $phpraid_config['date_format']. '">';
$time_format = '<input name="time_format" type="text" class="post" value="' . $phpraid_config['time_format']. '">';
$admin_email = '<input name="admin_email" type="text" class="post" value="' . $phpraid_config['admin_email'] .'" maxlength="255">';
$email_signature = '<textarea name="email_signature" cols="30" rows="5" id="email_signature" class="post">' . $phpraid_config['email_signature'] . '</textarea>';

// and now let's check languages
// this is done by search the languages folder (PHP4 compatible)
$dir = './language';
$dh = opendir($dir);
while(false != ($filename = readdir($dh))) {
	$files[] = $filename;
}

sort($files);
array_shift($files);
array_shift($files);

$language = '<select name="language">';

foreach($files as $key=>$value)
{
	$temp = substr($value, 5, strlen($value)-4);
	if($phpraid_config['language'] == $temp)
		$language .= "<option value=\"$temp\" selected>$temp</option>";
	else
		$language .= "<option value=\"$temp\">$temp</option>";
}

$language .= '</select>';

unset($files);

// and now let's check templates
$dir = './templates';
$dh = opendir($dir);
while(false != ($filename = readdir($dh))) {
	$files[] = $filename;
}

sort($files);
array_shift($files);
array_shift($files);

$template_type = '<select name="template">';

foreach($files as $key=>$value)
{
	if($phpraid_config['template'] == $value)
		$template_type .= "<option value=\"$value\" selected>$value</option>";
	else
		$template_type .= "<option value=\"$value\">$value</option>";
}

$template_type .= '</select>';

//timezones, how i hate thee!
$timezone = '<select name="timezone">';
for($i = -12; $i <= 12; $i = $i + 0.5)
{		
	if($i == 12 || $i == 11 || $i == 10 || $i == 9.5 || $i == 9 || $i == 8 || $i == 7 || $i == 6.5 || $i == 6 || 
	   $i == 5.5 || $i == 5 || $i == 4.5 || $i == 4 || $i == 3.5 || $i == 3 || $i == 2 || $i == 1 || $i == 0 ||
	   $i == -12 || $i == -11 || $i == -10 || $i == -9 || $i == -8 || $i == -7 || $i == -6 || $i == -5 || $i == -4 ||
	   $i == -3.5 || $i == -3 || $i == -2|| $i == -1)
	{		
		if($i < 0)
			$format = 'GMT - ' . abs($i) . ' Hours';
		elseif($i > 0)
			$format = 'GMT + ' . $i . ' Hours ';
		else
			$format = 'GMT';
		
		if($phpraid_config['timezone'] != ($i * 100))
			$timezone .= '<option value="' . $i . '">' . $format . '</option>';
		else
			$timezone .= '<option value="' . $i . '" SELECTED>' . $format . '</option>';
	}
}
$timezone .= '</select>';

// default group
$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "permissions";
$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);

$default = '<select name="default" class="post"><option value="nil">'.$phprlang['none'].'</option>';

while($data = $db_raid->sql_fetchrow($result))
{
	if($phpraid_config['default_group'] == $data['permission_id'])
		$default .= '<option value="'.$data['permission_id'].'" selected>'.$data['name'].'</option>';
	else
		$default .= '<option value="'.$data['permission_id'].'">'.$data['name'].'</option>';
}

$default .= '</select>';

$header_logo = '<input name="header_logo" size="60" type="text" class="post" value="' . $phpraid_config['header_logo'] . '">';
$header_link = '<input name="header_link" size="60" type="text" class="post" value="' . $phpraid_config['header_link'] . '">';
$phpraid_addon_link = '<input name="phpraid_addon_link" size="60" type="text" class="post" value="' . $phpraid_config['phpraid_addon_link'] . '">';
$guild_name = '<input name="guild_name" type="text" id="guild_name" value="' . $phpraid_config['guild_name'] . '" maxlength="255" class="post">';
$guild_description = '<input name="guild_description" type="text" id="guild_description" value="' . $phpraid_config['guild_description'] . '" maxlength="255" class="post">';
$guild_server = '<input name="guild_server" type="text" id="guild_server" value="' . $phpraid_config['guild_server'] . '" maxlength="255" class="post">';
$register = '<input name="register" type="text" value="'.$phpraid_config['register_url'].'" size="60" class="post">';
$buttons = '<input type="submit" name="submit" value="Submit" class="mainoption"> <input type="reset" name="Reset" value="Reset" class="liteoption">';

// put the variables into the template
$page->set_var(
	array(
		'guild_name' => $guild_name,
		'guild_description' => $guild_description,
		'show_id' => $show_id,
		'guild_server' => $guild_server,
		'admin_email' => $admin_email,
		'email_signature' => $email_signature,
		'disable_site' => $disable_site,
		'debug_mode' => $debug_mode,
		'allow_multiple_signups' => $allow_multiple_signups,
		'allow_anonymous_viewing' => $allow_anonymous_viewing,
		'allow_putonqueue' => $allow_putonqueue,
		'allow_resop' => $allow_resop,
		'faction' => $faction,
		'language' => $language,
		'date_format' => $date_format,
		'time_format' => $time_format,
		'auto_queue' => $auto_queue,
		'disable_freeze' => $disable_freeze,
		'buttons' => $buttons,
		'template_type' => $template_type,
		'timezone'=>$timezone,
		'dst'=>$dst,
		'roster' => $roster,
		'register' => $register,
		'dst_text' => $phprlang['configuration_dst_text'],
		'timezone_text' => $phprlang['configuration_timezone_text'],
		'guild_configure' => $phprlang['configuration_guild_header'],
		'guild_name_text' => $phprlang['configuration_guild_name'],
		'description_text' => $phprlang['configuration_description'],
		'server_text' => $phprlang['configuration_server'],
		'faction_text' =>$phprlang['configuration_faction'],
		'site_configure' => $phprlang['configuration_site_header'],
		'template_text' => $phprlang['configuration_template'],
		'header_logo_path' => $header_logo,
		'header_link_value' => $header_link,
		'header_link_text' => $phprlang['configuration_sitelink'],
		'header_logo_text' => $phprlang['configuration_logo'],
		'phpraid_addon_link' => $phpraid_addon_link,
		'showphpraid_addon_value' => $showphpraid_addon,
		'phpraid_addon_link_text' => $phprlang['configuration_addon'],
		'showphpraid_addon_text' => $phprlang['configuration_show_addon'],
		'auth_text' => $phprlang['configuration_auth'],
		'language_text' => $phprlang['configuration_language'],
		'time_text' => $phprlang['configuration_time'],
		'date_text' => $phprlang['configuration_date'],
		'resop_text' => $phprlang['configuration_resop'],
		'putonsignup_text' => $phprlang['configuration_putonsignup'],
		'putonqueue_text' => $phprlang['configuration_putonqueue'],
		'multiple_text' => $phprlang['configuration_multiple'],
		'anonymous_text' => $phprlang['configuration_anonymous'],
		'freeze_text' => $phprlang['configuration_freeze'],
		'autoqueue_text' => $phprlang['configuration_autoqueue'],
		'disable_text' => $phprlang['configuration_disable'],
		'debug_text' => $phprlang['configuration_debug'],
		'email_configure' => $phprlang['configuration_email_header'],
		'admin_email_text' => $phprlang['configuration_admin_email'],
		'email_signature_text' => $phprlang['configuration_email_sig'],
		'roster_text' => $phprlang['configuration_roster_text'],
		'id_text' => $phprlang['configuration_id'],
		'register_text' => $phprlang['configuration_register_text'],
		'email_signature' => $email_signature,
		'version_info' => $version_info,
		'default'=>$default,
		'default_text'=>$phprlang['configuration_default'],
	)
);

// show the form
if(!isset($_POST['submit']))
{
	$page->set_file(array(
		'body' => $phpraid_config['template'] . '/configuration.htm')
	);
}
else
{
	// form submission, update the database		
	if(isset($_POST['dst']))
		$dst = 1;
	else
		$dst = 0;
		
	if(isset($_POST['disable']))
		$disable = 1;
	else
		$disable = 0;
	
	if(isset($_POST['debug']))
		$p_debug = 1;
	else
		$p_debug = 0;
	
 	if(isset($_POST['show_id']))
	 	$show_id = 1;
 	else
 		$show_id = 0;
 	
 	if(isset($_POST['showphpraid_addon']))
 		$showphpraid_addon = 1;
 	else
 		$showphpraid_addon = 0;
		
	$h_logo = $_POST['header_logo'];
 	$h_link = $_POST['header_link'];
 	$p_link = $_POST['phpraid_addon_link'];
		
	if(isset($_POST['multiple_signups']))
		$allow_multiple = 1;
	else
		$allow_multiple = 0;
		
	if(isset($_POST['putonqueue']))
		$allow_putonqueue = 1;
	else
		$allow_putonqueue = 0;
		
	if(isset($_POST['resop']))
		$allow_resop = 1;
	else
		$allow_resop = 0;
	
	if(isset($_POST['anon_view']))
		$anon = 1;
	else
		$anon = 0;
		
	if(isset($_POST['auto_queue']))
		$a_queue = 1;
	else
		$a_queue = 0;

	if(isset($_POST['disable_freeze']))
		$d_freeze = 1;
	else
		$d_freeze = 0;
		
	$g_name = DEUBB($_POST['guild_name']);
	$g_desc =  DEUBB($_POST['guild_description']);
	$g_server =  DEUBB($_POST['guild_server']);
	$faction = $_POST['faction'];
	$lang = $_POST['language'];
	$a_email = $_POST['admin_email'];
	$e_sig = $_POST['email_signature'];
	$d_format = $_POST['date_format'];
	$t_format = $_POST['time_format'];
	$t_type = $_POST['template'];
	$t_zone = $_POST['timezone'] * 100;
	$register = $_POST['register'];
	$default =  DEUBB($_POST['default']);
	$dst *= 100;
	
	$db_raid->sql_query("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = '$a_email' WHERE `config_name`= 'admin_email';") or print_error($sql,mysql_error(),1);
	$db_raid->sql_query("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = '$allow_multiple' WHERE `config_name`= 'multiple_signups';") or print_error($sql,mysql_error(),1);
	$db_raid->sql_query("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = '$allow_resop' WHERE `config_name`= 'resop';") or print_error($sql,mysql_error(),1);
	$db_raid->sql_query("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = '$allow_putonqueue' WHERE `config_name`= 'putonqueue';") or print_error($sql,mysql_error(),1);
	$db_raid->sql_query("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = '$anon' WHERE `config_name`= 'anon_view';") or print_error($sql,mysql_error(),1);
	$db_raid->sql_query("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = '$a_queue' WHERE `config_name`= 'auto_queue';") or print_error($sql,mysql_error(),1);
	$db_raid->sql_query("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = '$d_format' WHERE `config_name`= 'date_format';") or print_error($sql,mysql_error(),1);
	$db_raid->sql_query("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = '$p_debug' WHERE `config_name`= 'debug';") or print_error($sql,mysql_error(),1);
	$db_raid->sql_query("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = '$disable' WHERE `config_name`= 'disable';") or print_error($sql,mysql_error(),1);
	$db_raid->sql_query("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = '$d_freeze' WHERE `config_name`= 'disable_freeze';") or print_error($sql,mysql_error(),1);
	$db_raid->sql_query("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = '$dst' WHERE `config_name`= 'dst';") or print_error($sql,mysql_error(),1);
	$db_raid->sql_query("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = '$e_sig' WHERE `config_name`= 'email_signature';") or print_error($sql,mysql_error(),1);
	$db_raid->sql_query("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = '$faction' WHERE `config_name`= 'faction';") or print_error($sql,mysql_error(),1);
	$db_raid->sql_query("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = '$g_desc' WHERE `config_name`= 'guild_description';") or print_error($sql,mysql_error(),1);
	$db_raid->sql_query("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = '$g_name' WHERE `config_name`= 'guild_name';") or print_error($sql,mysql_error(),1);
	$db_raid->sql_query("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = '$g_server' WHERE `config_name`= 'guild_server';") or print_error($sql,mysql_error(),1);
	$db_raid->sql_query("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = '$h_link' WHERE `config_name`= 'header_link';") or print_error($sql,mysql_error(),1);
	$db_raid->sql_query("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = '$h_logo' WHERE `config_name`= 'header_logo';") or print_error($sql,mysql_error(),1);
	$db_raid->sql_query("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = '$lang' WHERE `config_name`= 'language';") or print_error($sql,mysql_error(),1);
	$db_raid->sql_query("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = '$p_link' WHERE `config_name`= 'phpraid_addon_link';") or print_error($sql,mysql_error(),1);
	$db_raid->sql_query("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = '$register' WHERE `config_name`= 'register_url';") or print_error($sql,mysql_error(),1);
	$db_raid->sql_query("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = '$show_id' WHERE `config_name`= 'show_id';") or print_error($sql,mysql_error(),1);
	$db_raid->sql_query("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = '$showphpraid_addon' WHERE `config_name`= 'showphpraid_addon';") or print_error($sql,mysql_error(),1);
	$db_raid->sql_query("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = '$t_type' WHERE `config_name`= 'template';") or print_error($sql,mysql_error(),1);
	$db_raid->sql_query("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = '$t_format' WHERE `config_name`= 'time_format';") or print_error($sql,mysql_error(),1);
	$db_raid->sql_query("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = '$t_zone' WHERE `config_name`= 'timezone';") or print_error($sql,mysql_error(),1);
	$db_raid->sql_query("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = '$default' WHERE `config_name`= 'default_group';") or print_error($sql,mysql_error(),1);
																
	header("Location: configuration.php");
}

//
// Start output of page
//
require_once('includes/page_header.php');

$page->pparse('body','body');

require_once('includes/page_footer.php');
?>