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

if ($fsock = @fsockopen('www.wowraidmanager.net', 80, $errno, $errstr, 10))
{
	@fputs($fsock, "GET /vercheck/ver_check.txt HTTP/1.1\r\n");
	@fputs($fsock, "HOST: www.wowraidmanager.net\r\n");
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

// Get Text Strings for Configuration Page setup correctly
//$version_info_header = $phprlang['configuration_version_info_header'];
//$site_configure_header = $phprlang['configuration_site_header'];
//$guild_configure_header = $phprlang['configuration_guild_header'];
//$role_configure_header = $phprlang['configuration_role_header'];
//$user_rights_header = $phprlang['configuration_user_rights_header'];
//$external_links_header = $phprlang['configuration_external_links_header'];
//$signup_rights_header = $phprlang['configuration_signup_rights_header'];
//$on_queue_text = $phprlang['configuration_on_queue'];
//$cancelled_text = $phprlang['configuration_cancelled'];
//$drafted_text = $phprlang['configuration_drafted'];
//$draft_row_header = $phprlang['configuration_draft'];
//$comments_row_header = $phprlang['configuration_comments'];
//$cancel_row_header = $phprlang['configuration_cancel'];
//$delete_row_header = $phprlang['configuration_delete'];
//$queue_row_header = $phprlang['configuration_queue'];

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
	
if($phpraid_config['enable_five_man'] == '0')
	$enable_five_man = '<input type="checkbox" name="enable_five_man" value="1">';
else
	$enable_five_man = '<input type="checkbox" name="enable_five_man" value="1" checked>';
		
if($phpraid_config['enforce_role_limits'] == '0')
	$enforce_role_limits = '<input type="checkbox" name="enforce_role_limits" value="1">';
else
	$enforce_role_limits = '<input type="checkbox" name="enforce_role_limits" value="1" checked>';

if($phpraid_config['enforce_class_limits'] == '0')
	$enforce_class_limits = '<input type="checkbox" name="enforce_class_limits" value="1">';
else
	$enforce_class_limits = '<input type="checkbox" name="enforce_class_limits" value="1" checked>';

if($phpraid_config['class_as_min'] == '0')
	$class_as_min = '<input type="checkbox" name="class_as_min" value="1">';
else
	$class_as_min = '<input type="checkbox" name="class_as_min" value="1" checked>';

if($phpraid_config['enable_armory'] == '0')
	$enable_armory = '<input type="checkbox" name="enable_armory" value="1">';
else
	$enable_armory = '<input type="checkbox" name="enable_armory" value="1" checked>';

if($phpraid_config['enable_eqdkp'] == '0')
	$enable_eqdkp = '<input type="checkbox" name="enable_eqdkp" value="1">';
else
	$enable_eqdkp = '<input type="checkbox" name="enable_eqdkp" value="1" checked>';

// now the faction
$faction = '<select name="faction">';
if($phpraid_config['faction'] == 'alliance')
   	$faction .= '<option value="alliance" selected>Alliance</option><option value="horde">Horde</option>';
else
	$faction .= '<option value="alliance">Alliance</option><option value="horde" selected>Horde</option>';
$faction .= '</select>';

// 12/24 Hour switch
$ampm = '<select name="ampm">';
if($phpraid_config['ampm'] == '12')
       $ampm .= '<option value="12" selected>12h</option><option value="24">24h</option>';
else
    $ampm .= '<option value="12">12h</option><option value="24" selected>24h</option>';
$ampm .= '</select>';

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


// Setup the Signup Flow Configuration Area - Setup Checkboxes
// 		User Permissions
if($phpraid_config['user_queue_promote'] == '0')
	$user_queue_promote = '<input type="checkbox" name="user_queue_promote" value="1">';
else
	$user_queue_promote = '<input type="checkbox" name="user_queue_promote" value="1" checked>';

if($phpraid_config['user_queue_comments'] == '0')
	$user_queue_comments = '<input type="checkbox" name="user_queue_comments" value="1">';
else
	$user_queue_comments = '<input type="checkbox" name="user_queue_comments" value="1" checked>';

if($phpraid_config['user_queue_cancel'] == '0')
	$user_queue_cancel = '<input type="checkbox" name="user_queue_cancel" value="1">';
else
	$user_queue_cancel = '<input type="checkbox" name="user_queue_cancel" value="1" checked>';

if($phpraid_config['user_queue_delete'] == '0')
	$user_queue_delete = '<input type="checkbox" name="user_queue_delete" value="1">';
else
	$user_queue_delete = '<input type="checkbox" name="user_queue_delete" value="1" checked>';

if($phpraid_config['user_cancel_queue'] == '0')
	$user_cancel_queue = '<input type="checkbox" name="user_cancel_queue" value="1">';
else
	$user_cancel_queue = '<input type="checkbox" name="user_cancel_queue" value="1" checked>';

if($phpraid_config['user_cancel_promote'] == '0')
	$user_cancel_promote = '<input type="checkbox" name="user_cancel_promote" value="1">';
else
	$user_cancel_promote = '<input type="checkbox" name="user_cancel_promote" value="1" checked>';

if($phpraid_config['user_cancel_comments'] == '0')
	$user_cancel_comments = '<input type="checkbox" name="user_cancel_comments" value="1">';
else
	$user_cancel_comments = '<input type="checkbox" name="user_cancel_comments" value="1" checked>';

if($phpraid_config['user_cancel_delete'] == '0')
	$user_cancel_delete = '<input type="checkbox" name="user_cancel_delete" value="1">';
else
	$user_cancel_delete = '<input type="checkbox" name="user_cancel_delete" value="1" checked>';

if($phpraid_config['user_drafted_queue'] == '0')
	$user_drafted_queue = '<input type="checkbox" name="user_drafted_queue" value="1">';
else
	$user_drafted_queue = '<input type="checkbox" name="user_drafted_queue" value="1" checked>';

if($phpraid_config['user_drafted_comments'] == '0')
	$user_drafted_comments = '<input type="checkbox" name="user_drafted_comments" value="1">';
else
	$user_drafted_comments = '<input type="checkbox" name="user_drafted_comments" value="1" checked>';

if($phpraid_config['user_drafted_cancel'] == '0')
	$user_drafted_cancel = '<input type="checkbox" name="user_drafted_cancel" value="1">';
else
	$user_drafted_cancel = '<input type="checkbox" name="user_drafted_cancel" value="1" checked>';

if($phpraid_config['user_drafted_delete'] == '0')
	$user_drafted_delete = '<input type="checkbox" name="user_drafted_delete" value="1">';
else
	$user_drafted_delete = '<input type="checkbox" name="user_drafted_delete" value="1" checked>';

// 		Raid Leader Permissions
if($phpraid_config['rl_queue_promote'] == '0')
	$rl_queue_promote = '<input type="checkbox" name="rl_queue_promote" value="1">';
else
	$rl_queue_promote = '<input type="checkbox" name="rl_queue_promote" value="1" checked>';

if($phpraid_config['rl_queue_comments'] == '0')
	$rl_queue_comments = '<input type="checkbox" name="rl_queue_comments" value="1">';
else
	$rl_queue_comments = '<input type="checkbox" name="rl_queue_comments" value="1" checked>';

if($phpraid_config['rl_queue_cancel'] == '0')
	$rl_queue_cancel = '<input type="checkbox" name="rl_queue_cancel" value="1">';
else
	$rl_queue_cancel = '<input type="checkbox" name="rl_queue_cancel" value="1" checked>';

if($phpraid_config['rl_queue_delete'] == '0')
	$rl_queue_delete = '<input type="checkbox" name="rl_queue_delete" value="1">';
else
	$rl_queue_delete = '<input type="checkbox" name="rl_queue_delete" value="1" checked>';

if($phpraid_config['rl_cancel_queue'] == '0')
	$rl_cancel_queue = '<input type="checkbox" name="rl_cancel_queue" value="1">';
else
	$rl_cancel_queue = '<input type="checkbox" name="rl_cancel_queue" value="1" checked>';

if($phpraid_config['rl_cancel_promote'] == '0')
	$rl_cancel_promote = '<input type="checkbox" name="rl_cancel_promote" value="1">';
else
	$rl_cancel_promote = '<input type="checkbox" name="rl_cancel_promote" value="1" checked>';

if($phpraid_config['rl_cancel_comments'] == '0')
	$rl_cancel_comments = '<input type="checkbox" name="rl_cancel_comments" value="1">';
else
	$rl_cancel_comments = '<input type="checkbox" name="rl_cancel_comments" value="1" checked>';

if($phpraid_config['rl_cancel_delete'] == '0')
	$rl_cancel_delete = '<input type="checkbox" name="rl_cancel_delete" value="1">';
else
	$rl_cancel_delete = '<input type="checkbox" name="rl_cancel_delete" value="1" checked>';

if($phpraid_config['rl_drafted_queue'] == '0')
	$rl_drafted_queue = '<input type="checkbox" name="rl_drafted_queue" value="1">';
else
	$rl_drafted_queue = '<input type="checkbox" name="rl_drafted_queue" value="1" checked>';

if($phpraid_config['rl_drafted_comments'] == '0')
	$rl_drafted_comments = '<input type="checkbox" name="rl_drafted_comments" value="1">';
else
	$rl_drafted_comments = '<input type="checkbox" name="rl_drafted_comments" value="1" checked>';

if($phpraid_config['rl_drafted_cancel'] == '0')
	$rl_drafted_cancel = '<input type="checkbox" name="rl_drafted_cancel" value="1">';
else
	$rl_drafted_cancel = '<input type="checkbox" name="rl_drafted_cancel" value="1" checked>';

if($phpraid_config['rl_drafted_delete'] == '0')
	$rl_drafted_delete = '<input type="checkbox" name="rl_drafted_delete" value="1">';
else
	$rl_drafted_delete = '<input type="checkbox" name="rl_drafted_delete" value="1" checked>';

// 		Administrator Permissions
if($phpraid_config['admin_queue_promote'] == '0')
	$admin_queue_promote = '<input type="checkbox" name="admin_queue_promote" value="1">';
else
	$admin_queue_promote = '<input type="checkbox" name="admin_queue_promote" value="1" checked>';

if($phpraid_config['admin_queue_comments'] == '0')
	$admin_queue_comments = '<input type="checkbox" name="admin_queue_comments" value="1">';
else
	$admin_queue_comments = '<input type="checkbox" name="admin_queue_comments" value="1" checked>';

if($phpraid_config['admin_queue_cancel'] == '0')
	$admin_queue_cancel = '<input type="checkbox" name="admin_queue_cancel" value="1">';
else
	$admin_queue_cancel = '<input type="checkbox" name="admin_queue_cancel" value="1" checked>';

if($phpraid_config['admin_queue_delete'] == '0')
	$admin_queue_delete = '<input type="checkbox" name="admin_queue_delete" value="1">';
else
	$admin_queue_delete = '<input type="checkbox" name="admin_queue_delete" value="1" checked>';

if($phpraid_config['admin_cancel_queue'] == '0')
	$admin_cancel_queue = '<input type="checkbox" name="admin_cancel_queue" value="1">';
else
	$admin_cancel_queue = '<input type="checkbox" name="admin_cancel_queue" value="1" checked>';

if($phpraid_config['admin_cancel_promote'] == '0')
	$admin_cancel_promote = '<input type="checkbox" name="admin_cancel_promote" value="1">';
else
	$admin_cancel_promote = '<input type="checkbox" name="admin_cancel_promote" value="1" checked>';

if($phpraid_config['admin_cancel_comments'] == '0')
	$admin_cancel_comments = '<input type="checkbox" name="admin_cancel_comments" value="1">';
else
	$admin_cancel_comments = '<input type="checkbox" name="admin_cancel_comments" value="1" checked>';

if($phpraid_config['admin_cancel_delete'] == '0')
	$admin_cancel_delete = '<input type="checkbox" name="admin_cancel_delete" value="1">';
else
	$admin_cancel_delete = '<input type="checkbox" name="admin_cancel_delete" value="1" checked>';

if($phpraid_config['admin_drafted_queue'] == '0')
	$admin_drafted_queue = '<input type="checkbox" name="admin_drafted_queue" value="1">';
else
	$admin_drafted_queue = '<input type="checkbox" name="admin_drafted_queue" value="1" checked>';

if($phpraid_config['admin_drafted_comments'] == '0')
	$admin_drafted_comments = '<input type="checkbox" name="admin_drafted_comments" value="1">';
else
	$admin_drafted_comments = '<input type="checkbox" name="admin_drafted_comments" value="1" checked>';

if($phpraid_config['admin_drafted_cancel'] == '0')
	$admin_drafted_cancel = '<input type="checkbox" name="admin_drafted_cancel" value="1">';
else
	$admin_drafted_cancel = '<input type="checkbox" name="admin_drafted_cancel" value="1" checked>';

if($phpraid_config['admin_drafted_delete'] == '0')
	$admin_drafted_delete = '<input type="checkbox" name="admin_drafted_delete" value="1">';
else
	$admin_drafted_delete = '<input type="checkbox" name="admin_drafted_delete" value="1" checked>';

// Set up the input boxes.
$header_logo = '<input name="header_logo" size="60" type="text" class="post" value="' . $phpraid_config['header_logo'] . '">';
$header_link = '<input name="header_link" size="60" type="text" class="post" value="' . $phpraid_config['header_link'] . '">';
$phpraid_addon_link = '<input name="phpraid_addon_link" size="60" type="text" class="post" value="' . $phpraid_config['phpraid_addon_link'] . '">';
$rss_site_url = '<input name="rss_site_url" size="60" type="text" class="post" value="' . $phpraid_config['rss_site_url'] . '">';
$rss_export_url = '<input name="rss_export_url" size="60" type="text" class="post" value="' . $phpraid_config['rss_export_url'] . '">';
$rss_feed_amt = '<input name="rss_feed_amt" size="10" type="text" class="post" value="' . $phpraid_config['rss_feed_amt'] . '">';
$guild_name = '<input name="guild_name" type="text" id="guild_name" value="' . $phpraid_config['guild_name'] . '" maxlength="255" class="post">';
$guild_description = '<input name="guild_description" type="text" id="guild_description" value="' . $phpraid_config['guild_description'] . '" maxlength="255" class="post">';
$guild_server = '<input name="guild_server" type="text" id="guild_server" value="' . $phpraid_config['guild_server'] . '" maxlength="255" class="post">';
$register = '<input name="register" type="text" value="'.$phpraid_config['register_url'].'" size="60" class="post">';
$buttons = '<input type="submit" name="submit" value="'.$phprlang['submit'].'" class="mainoption"> <input type="reset" name="Reset" value="'.$phprlang['reset'].'" class="liteoption">';
$armory_language = '<input name="armory_language" type="text" value="'.$phpraid_config['armory_language'].'" size="4" class="post">';
$role1_name='<input name="role1_name" type="text" value="'.$phpraid_config['role1_name'].'" size="25" class="post">';
$role2_name='<input name="role2_name" type="text" value="'.$phpraid_config['role2_name'].'" size="25" class="post">';
$role3_name='<input name="role3_name" type="text" value="'.$phpraid_config['role3_name'].'" size="25" class="post">';
$role4_name='<input name="role4_name" type="text" value="'.$phpraid_config['role4_name'].'" size="25" class="post">';
$role5_name='<input name="role5_name" type="text" value="'.$phpraid_config['role5_name'].'" size="25" class="post">';
$role6_name='<input name="role6_name" type="text" value="'.$phpraid_config['role6_name'].'" size="25" class="post">';
$eqdkp_url='<input name="eqdkp_url" type="text" value="'.$phpraid_config['eqdkp_url'].'" size="60" class="post">';

// put the variables into the template
$wrmsmarty->assign('config_data',
	array(
		'guild_name' => $guild_name,
		'guild_description' => $guild_description,
		'show_id' => $show_id,
		'guild_server' => $guild_server,
		'armory_link' => $armory_box,
		'raid_view_type' => $raid_view_type,
		'armory_language' => $armory_language,
		'admin_email' => $admin_email,
		'email_signature' => $email_signature,
		'disable_site' => $disable_site,
		'debug_mode' => $debug_mode,
		'allow_multiple_signups' => $allow_multiple_signups,
		'allow_anonymous_viewing' => $allow_anonymous_viewing,
		'enforce_role_limits' => $enforce_role_limits,
		'enforce_class_limits' => $enforce_class_limits,
		'class_as_min' => $class_as_min,
		'enable_five_man' => $enable_five_man, 
		'allow_resop' => $allow_resop,
		'faction' => $faction,
		'language' => $language,
		'ampm' => $ampm,
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
		'eqdkp_url' => $eqdkp_url,
		'enable_armory' => $enable_armory,
		'enable_eqdkp' => $enable_eqdkp,
		'enable_armory_text' => $phprlang['configuration_armory_enable'],
		'enable_eqdkp_text' => $phprlang['configuration_eqdkp_integration_text'],
		'eqdkp_url_text' => $phprlang['configuration_eqdkp_link'],
		'role1_name' => $role1_name,
		'role2_name' => $role2_name,
		'role3_name' => $role3_name,
		'role4_name' => $role4_name,
		'role5_name' => $role5_name,
		'role6_name' => $role6_name,
		'role1_text' => $phprlang['configuration_role1_text'],
		'role2_text' => $phprlang['configuration_role2_text'],
		'role3_text' => $phprlang['configuration_role3_text'],
		'role4_text' => $phprlang['configuration_role4_text'],
		'role5_text' => $phprlang['configuration_role5_text'],
		'role6_text' => $phprlang['configuration_role6_text'],
		'role_limit_text' => $phprlang['configuration_role_limit_text'],
		'class_limit_text' => $phprlang['configuration_class_limit_text'],
		'class_as_min_text' => $phprlang['configuration_class_as_min'],
		'armory_link_text' => $phprlang['configuration_armory_link_text'],
		'raid_view_type_text' => $phprlang['configuration_raid_view_type_text'],
		'armory_language_text' => $phprlang['configuration_armory_language_text'],
		'enable_five_man_text' => $phprlang['configuration_enable_five_man'],
		'dst_text' => $phprlang['configuration_dst_text'],
		'timezone_text' => $phprlang['configuration_timezone_text'],
		'guild_configure' => $phprlang['configuration_guild_header'],
		'guild_name_text' => $phprlang['configuration_guild_name'],
		'description_text' => $phprlang['configuration_description'],
		'server_text' => $phprlang['configuration_server'],
		'faction_text' =>$phprlang['configuration_faction'],
		'site_configure' => $phprlang['configuration_site_header'],
		'template_text' => $phprlang['configuration_template'],
		'rss_site_text' => $phprlang['configuration_rss_site'],
		'rss_export_text' => $phprlang['configuration_rss_export'],
		'rss_feed_amt_txt' => $phprlang['configuration_rss_feed_amt'],
		'header_logo_path' => $header_logo,
		'header_link_value' => $header_link,
		'rss_site_url' => $rss_site_url,
		'rss_export_url' => $rss_export_url,
		'rss_feed_amt' => $rss_feed_amt,
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
		'ampm_text' => $phprlang['configuration_ampm'],
		'resop_text' => $phprlang['configuration_resop'],
		'putonsignup_text' => $phprlang['configuration_putonsignup'],
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
		'admin_text'=>$phprlang['configuraiton_admin'],
		'raidlead_text'=>$phprlang['configuration_raidlead'],
		'user_text'=>$phprlang['configuration_user'],
		'user_queue_promote'=>$user_queue_promote,
		'user_queue_comments'=>$user_queue_comments,
		'user_queue_cancel'=>$user_queue_cancel,
		'user_queue_delete'=>$user_queue_delete,
		'user_cancel_queue'=>$user_cancel_queue,
		'user_cancel_promote'=>$user_cancel_promote,
		'user_cancel_comments'=>$user_cancel_comments,
		'user_cancel_delete'=>$user_cancel_delete,
		'user_drafted_queue'=>$user_drafted_queue,
		'user_drafted_comments'=>$user_drafted_comments,
		'user_drafted_cancel'=>$user_drafted_cancel,
		'user_drafted_delete'=>$user_drafted_delete,
		'rl_queue_promote'=>$rl_queue_promote,
		'rl_queue_comments'=>$rl_queue_comments,
		'rl_queue_cancel'=>$rl_queue_cancel,
		'rl_queue_delete'=>$rl_queue_delete,
		'rl_cancel_queue'=>$rl_cancel_queue,
		'rl_cancel_promote'=>$rl_cancel_promote,
		'rl_cancel_comments'=>$rl_cancel_comments,
		'rl_cancel_delete'=>$rl_cancel_delete,
		'rl_drafted_queue'=>$rl_drafted_queue,
		'rl_drafted_comments'=>$rl_drafted_comments,
		'rl_drafted_cancel'=>$rl_drafted_cancel,
		'rl_drafted_delete'=>$rl_drafted_delete,
		'admin_queue_promote'=>$admin_queue_promote,
		'admin_queue_comments'=>$admin_queue_comments,
		'admin_queue_cancel'=>$admin_queue_cancel,
		'admin_queue_delete'=>$admin_queue_delete,
		'admin_cancel_queue'=>$admin_cancel_queue,
		'admin_cancel_promote'=>$admin_cancel_promote,
		'admin_cancel_comments'=>$admin_cancel_comments,
		'admin_cancel_delete'=>$admin_cancel_delete,
		'admin_drafted_queue'=>$admin_drafted_queue,
		'admin_drafted_comments'=>$admin_drafted_comments,
		'admin_drafted_cancel'=>$admin_drafted_cancel,
		'admin_drafted_delete'=>$admin_drafted_delete,		
		'queue_def'=>$phprlang['configuration_queue_def'],
		'draft_def'=>$phprlang['configuration_draft_def'],
		'comments_def'=>$phprlang['configuration_comments_def'],
		'cancel_def'=>$phprlang['configuration_cancel_def'],
		'delete_def'=>$phprlang['configuration_delete_def'],
		'version_info_header'=>$phprlang['configuration_version_info_header'],
		'site_configure_header'=>$phprlang['configuration_site_header'],
		'guild_configure_header'=>$phprlang['configuration_guild_header'],
		'role_configure_header'=>$phprlang['configuration_role_header'],
		'raid_settings_header'=>$phprlang['configuration_raid_settings_header'],
		'user_rights_header'=>$phprlang['configuration_user_rights_header'],
		'signup_rights_header'=>$phprlang['configuration_signup_rights_header'],
		'external_links_header'=>$phprlang['configuration_external_links_header'],
		'email_header'=>$phprlang['configuration_email_header'],
		'on_queue_text'=>$phprlang['configuration_on_queue'],
		'cancelled_text'=>$phprlang['configuration_cancelled'],
		'drafted_text'=>$phprlang['configuration_drafted'],
		'draft_row_header'=>$phprlang['configuration_draft'],
		'comments_row_header'=>$phprlang['configuration_comments'],
		'cancel_row_header'=>$phprlang['configuration_cancel'],
		'delete_row_header'=>$phprlang['configuration_delete'],
		'queue_row_header'=>$phprlang['configuration_queue'],
	)
);

if(isset($_POST['submit']))
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
		
	if(isset($_POST['enforce_role_limits']))
		$enforce_role_limits = 1;
	else
		$enforce_role_limits = 0;
	
	if(isset($_POST['enforce_class_limits']))
		$enforce_class_limits = 1;
	else
		$enforce_class_limits = 0;

	if(isset($_POST['class_as_min']))
		$class_as_min = 1;
	else
		$class_as_min = 0;
	
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

 	if(isset($_POST['enable_five_man']))
 		$enable_five_man = 1;
 	else
 		$enable_five_man = 0;
 		
 	if(isset($_POST['enable_armory']))
 		$enable_armory = 1;
 	else
 		$enable_armory = 0;

 	if(isset($_POST['enable_eqdkp']))
 		$enable_eqdkp = 1;
 	else
 		$enable_eqdkp = 0;
 
	$h_logo = scrub_input($_POST['header_logo'], true);
 	$h_link = scrub_input($_POST['header_link'], true);
 	$p_link = scrub_input($_POST['phpraid_addon_link'], true);
	$eqdkp_url = scrub_input($_POST['eqdkp_url'], true);
	$rss_site_url_p = scrub_input($_POST['rss_site_url'], true);
	$rss_export_url_p = scrub_input($_POST['rss_export_url'], true);
	$rss_feed_amt_p = scrub_input($_POST['rss_feed_amt']);
	$armory_link = scrub_input($_POST['armory_link']);
	$raid_view_type = scrub_input($_POST['raid_view_type']);
	$armory_language = scrub_input($_POST['armory_language']);
	$role1_name = scrub_input($_POST['role1_name']);
	$role2_name = scrub_input($_POST['role2_name']);
	$role3_name = scrub_input($_POST['role3_name']);
	$role4_name = scrub_input($_POST['role4_name']);
	$role5_name = scrub_input($_POST['role5_name']);
	$role6_name = scrub_input($_POST['role6_name']);

	// Check for changes in role name.  If the Role Name changes, we need to update the characters table.
	if ($phpraid_config['role1_name'] != $role1_name)
	{
		$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."chars` SET `role` = %s WHERE `role`= %s;", quote_smart($role1_name), quote_smart($phpraid_config['role1_name']));
		$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	}
	if ($phpraid_config['role2_name'] != $role2_name)
	{
		$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."chars` SET `role` = %s WHERE `role`= %s;", quote_smart($role2_name), quote_smart($phpraid_config['role2_name']));
		$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);		
	}
	if ($phpraid_config['role3_name'] != $role3_name)
	{
		$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."chars` SET `role` = %s WHERE `role`= %s;", quote_smart($role3_name), quote_smart($phpraid_config['role3_name']));
		$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);		
	}
	if ($phpraid_config['role4_name'] != $role4_name)
	{
		$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."chars` SET `role` = %s WHERE `role`= %s;", quote_smart($role4_name), quote_smart($phpraid_config['role4_name']));
		$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	}
	if ($phpraid_config['role5_name'] != $role5_name)
	{
		$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."chars` SET `role` = %s WHERE `role`= %s;", quote_smart($role5_name), quote_smart($phpraid_config['role5_name']));
		$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	}
	if ($phpraid_config['role6_name'] != $role6_name)
	{
		$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."chars` SET `role` = %s WHERE `role`= %s;", quote_smart($role6_name), quote_smart($phpraid_config['role6_name']));
		$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	}

	if(isset($_POST['multiple_signups']))
		$allow_multiple = 1;
	else
		$allow_multiple = 0;
		
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
		
	// Process Signup Flow Checkboxes
	if(isset($_POST['user_queue_promote']))
		$uqp = 1;
	else
		$uqp = 0;
	if(isset($_POST['user_queue_comments']))
		$uqc = 1;
	else
		$uqc = 0;
	if(isset($_POST['user_queue_cancel']))
		$uqa = 1;
	else
		$uqa = 0;
	if(isset($_POST['user_queue_delete']))
		$uqd = 1;
	else
		$uqd = 0;
	if(isset($_POST['user_cancel_queue']))
		$ucq = 1;
	else
		$ucq = 0;
	if(isset($_POST['user_cancel_promote']))
		$ucp = 1;
	else
		$ucp = 0;
	if(isset($_POST['user_cancel_comments']))
		$ucc = 1;
	else
		$ucc = 0;
	if(isset($_POST['user_cancel_delete']))
		$ucd = 1;
	else
		$ucd = 0;
	if(isset($_POST['user_drafted_queue']))
		$udq = 1;
	else
		$udq = 0;
	if(isset($_POST['user_drafted_comments']))
		$udc = 1;
	else
		$udc = 0;
	if(isset($_POST['user_drafted_cancel']))
		$uda = 1;
	else
		$uda = 0;
	if(isset($_POST['user_drafted_delete']))
		$udd = 1;
	else
		$udd = 0;
	if(isset($_POST['rl_queue_promote']))
		$rqp = 1;
	else
		$rqp = 0;
	if(isset($_POST['rl_queue_comments']))
		$rqc = 1;
	else
		$rqc = 0;
	if(isset($_POST['rl_queue_cancel']))
		$rqa = 1;
	else
		$rqa = 0;
	if(isset($_POST['rl_queue_delete']))
		$rqd = 1;
	else
		$rqd = 0;
	if(isset($_POST['rl_cancel_queue']))
		$rcq = 1;
	else
		$rcq = 0;
	if(isset($_POST['rl_cancel_promote']))
		$rcp = 1;
	else
		$rcp = 0;
	if(isset($_POST['rl_cancel_comments']))
		$rcc = 1;
	else
		$rcc = 0;
	if(isset($_POST['rl_cancel_delete']))
		$rcd = 1;
	else
		$rcd = 0;
	if(isset($_POST['rl_drafted_queue']))
		$rdq = 1;
	else
		$rdq = 0;
	if(isset($_POST['rl_drafted_comments']))
		$rdc = 1;
	else
		$rdc = 0;
	if(isset($_POST['rl_drafted_cancel']))
		$rda = 1;
	else
		$rda = 0;
	if(isset($_POST['rl_drafted_delete']))
		$rdd = 1;
	else
		$rdd = 0;
	if(isset($_POST['admin_queue_promote']))
		$aqp = 1;
	else
		$aqp = 0;
	if(isset($_POST['admin_queue_comments']))
		$aqc = 1;
	else
		$aqc = 0;
	if(isset($_POST['admin_queue_cancel']))
		$aqa = 1;
	else
		$aqa = 0;
	if(isset($_POST['admin_queue_delete']))
		$aqd = 1;
	else
		$aqd = 0;
	if(isset($_POST['admin_cancel_queue']))
		$acq = 1;
	else
		$acq = 0;
	if(isset($_POST['admin_cancel_promote']))
		$acp = 1;
	else
		$acp = 0;
	if(isset($_POST['admin_cancel_comments']))
		$acc = 1;
	else
		$acc = 0;
	if(isset($_POST['admin_cancel_delete']))
		$acd = 1;
	else
		$acd = 0;
	if(isset($_POST['admin_drafted_queue']))
		$adq = 1;
	else
		$adq = 0;
	if(isset($_POST['admin_drafted_comments']))
		$adc = 1;
	else
		$adc = 0;
	if(isset($_POST['admin_drafted_cancel']))
		$ada = 1;
	else
		$ada = 0;
	if(isset($_POST['admin_drafted_delete']))
		$add = 1;
	else
		$add = 0;
// End of Signup Flow Boxes
		 		
	$g_name = scrub_input(DEUBB($_POST['guild_name']));
	$g_desc =  scrub_input(DEUBB($_POST['guild_description']));
	$g_server =  scrub_input(DEUBB($_POST['guild_server']));
	$faction = scrub_input($_POST['faction']);
	$lang = scrub_input($_POST['language']);
	$ampm = scrub_input(DEUBB($_POST['ampm']));
	$a_email = scrub_input(DEUBB($_POST['admin_email']));
	$e_sig = scrub_input(DEUBB($_POST['email_signature']));
	$d_format = scrub_input(DEUBB($_POST['date_format']));
	$t_format = scrub_input(DEUBB($_POST['time_format']));
	$t_type = scrub_input(DEUBB($_POST['template']));
	$t_zone = scrub_input(DEUBB($_POST['timezone'] * 100));
	$register = scrub_input(DEUBB($_POST['register']), true);
	$default =  scrub_input(DEUBB($_POST['default']));
	$dst *= 100;

	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'admin_email';", quote_smart($a_email));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'multiple_signups';", quote_smart($allow_multiple));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'resop';", quote_smart($allow_resop));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'anon_view';", quote_smart($anon));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'auto_queue';", quote_smart($a_queue));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error($sql),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'armory_link';", quote_smart($armory_link));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error($sql),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'armory_language';", quote_smart($armory_language));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error($sql),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'date_format';", quote_smart($d_format));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error($sql),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'debug';", quote_smart($p_debug));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'disable';", quote_smart($disable));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'disable_freeze';", quote_smart($d_freeze));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'dst';", quote_smart($dst));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'email_signature';", quote_smart($e_sig));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'faction';", quote_smart($faction));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'guild_description';", quote_smart($g_desc));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'guild_name';", quote_smart($g_name));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'guild_server';", quote_smart($g_server));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'header_link';", quote_smart($h_link));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'header_logo';", quote_smart($h_logo));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'language';", quote_smart($lang));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'ampm';", quote_smart($ampm));
    $db_raid->sql_query($sql) or print_error($sql,mysql_error($sql),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'phpraid_addon_link';", quote_smart($p_link));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'register_url';", quote_smart($register));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'show_id';", quote_smart($show_id));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'showphpraid_addon';", quote_smart($showphpraid_addon));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'template';", quote_smart($t_type));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'time_format';", quote_smart($t_format));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'timezone';", quote_smart($t_zone));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'default_group';", quote_smart($default));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'enable_five_man';", quote_smart($enable_five_man));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'rss_site_url';", quote_smart($rss_site_url_p));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'rss_export_url';", quote_smart($rss_export_url_p));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'rss_feed_amt';", quote_smart($rss_feed_amt_p));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'role1_name';", quote_smart($role1_name));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'role2_name';", quote_smart($role2_name));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'role3_name';", quote_smart($role3_name));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'role4_name';", quote_smart($role4_name));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'role5_name';", quote_smart($role5_name));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'role6_name';", quote_smart($role6_name));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'raid_view_type';", quote_smart($raid_view_type));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	//Signup Flow Config
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'user_queue_promote';", quote_smart($uqp));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'user_queue_comments';", quote_smart($uqc));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'user_queue_cancel';", quote_smart($uqa));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'user_queue_delete';", quote_smart($uqd));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'user_cancel_queue';", quote_smart($ucq));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'user_cancel_promote';", quote_smart($ucp));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'user_cancel_comments';", quote_smart($ucc));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'user_cancel_delete';", quote_smart($ucd));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'user_drafted_queue';", quote_smart($udq));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'user_drafted_comments';", quote_smart($udc));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'user_drafted_cancel';", quote_smart($uda));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'user_drafted_delete';", quote_smart($udd));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'rl_queue_promote';", quote_smart($rqp));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'rl_queue_comments';", quote_smart($rqc));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'rl_queue_cancel';", quote_smart($rqa));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'rl_queue_delete';", quote_smart($rqd));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'rl_cancel_queue';", quote_smart($rcq));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'rl_cancel_promote';", quote_smart($rcp));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'rl_cancel_comments';", quote_smart($rcc));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'rl_cancel_delete';", quote_smart($rcd));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'rl_drafted_queue';", quote_smart($rdq));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'rl_drafted_comments';", quote_smart($rdc));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'rl_drafted_cancel';", quote_smart($rda));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'rl_drafted_delete';", quote_smart($rdd));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'admin_queue_promote';", quote_smart($aqp));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'admin_queue_comments';", quote_smart($aqc));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'admin_queue_cancel';", quote_smart($aqa));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'admin_queue_delete';", quote_smart($aqd));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'admin_cancel_queue';", quote_smart($acq));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'admin_cancel_promote';", quote_smart($acp));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'admin_cancel_comments';", quote_smart($acc));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'admin_cancel_delete';", quote_smart($acd));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'admin_drafted_queue';", quote_smart($adq));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'admin_drafted_comments';", quote_smart($adc));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'admin_drafted_cancel';", quote_smart($ada));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'admin_drafted_delete';", quote_smart($add));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'enforce_role_limits';", quote_smart($enforce_role_limits));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'enforce_class_limits';", quote_smart($enforce_class_limits));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'class_as_min';", quote_smart($class_as_min));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'enable_armory';", quote_smart($enable_armory));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'enable_eqdkp';", quote_smart($enable_eqdkp));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'eqdkp_url';", quote_smart($eqdkp_url));
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