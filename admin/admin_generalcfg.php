<?php
/***************************************************************************
                                admin_index.php
 *                            -------------------
 *   begin                : Monday, May 11, 2009
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

/* 
 * Data for Index Page
 */
if($phpraid_config['disable'] == '0')
	$disable_site = '<input type="checkbox" name="disable" value="1">';
else
	$disable_site = '<input type="checkbox" name="disable" value="1" checked>';

if($phpraid_config['debug'] == '0')
	$debug_mode = '<input type="checkbox" name="debug" value="1" disabled> (disabled)';
else
	$debug_mode = '<input type="checkbox" name="debug" value="1" disabled checked> (disabled)';

if($phpraid_config['showphpraid_addon'] == '0')
	$showphpraid_addon = '<input type="checkbox" name="showphpraid_addon" value="1">';
else
	$showphpraid_addon = '<input type="checkbox" name="showphpraid_addon" value="1" checked>';

if($phpraid_config['enable_five_man'] == '0')
	$enable_five_man = '<input type="checkbox" name="enable_five_man" value="1">';
else
	$enable_five_man = '<input type="checkbox" name="enable_five_man" value="1" checked>';
	
// LANGUAGE CHECK
// this is done by search the languages folder (PHP4 compatible)
$dir = '../language';
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
// END LANGUAGE CHECK

// TEMPLATE CHECK
// and now let's check templates
$dir = '../templates';
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
//END TEMPLATE CHECK

$phpraid_addon_link = '<input name="phpraid_addon_link" size="60" type="text" class="post" value="' . $phpraid_config['phpraid_addon_link'] . '">';
$header_logo = '<input name="header_logo" size="60" type="text" class="post" value="' . $phpraid_config['header_logo'] . '">';
$register = '<input name="register" type="text" value="'.$phpraid_config['register_url'].'" size="60" class="post">';
$header_link = '<input name="header_link" size="60" type="text" class="post" value="' . $phpraid_config['header_link'] . '">';
$admin_email = '<input name="admin_email" type="text" class="post" value="' . $phpraid_config['admin_email'] .'" maxlength="255">';
$email_signature = '<textarea name="email_signature" cols="30" rows="5" id="email_signature" class="post">' . $phpraid_config['email_signature'] . '</textarea>';
$rss_site_url = '<input name="rss_site_url" size="60" type="text" class="post" value="' . $phpraid_config['rss_site_url'] . '">';
$rss_export_url = '<input name="rss_export_url" size="60" type="text" class="post" value="' . $phpraid_config['rss_export_url'] . '">';
$rss_feed_amt = '<input name="rss_feed_amt" size="10" type="text" class="post" value="' . $phpraid_config['rss_feed_amt'] . '">';
$records_per_page = '<input name="records_per_page" size="60" type="text" class="post" value="' . $phpraid_config['records_per_page'] . '">';

$buttons = '<input type="submit" name="submit" value="'.$phprlang['submit'].'" class="mainoption"> <input type="reset" name="Reset" value="'.$phprlang['reset'].'" class="liteoption">';

$wrmadminsmarty->assign('config_data',
	array(
		'general_header' => $phprlang['general_configuration_header'],
		'email_header'=>$phprlang['configuration_email_header'],
		'phpraid_addon_link' => $phpraid_addon_link,
		'phpraid_addon_link_text' => $phprlang['configuration_addon'],
		'header_logo_path' => $header_logo,
		'header_logo_text' => $phprlang['configuration_logo'],
		'register' => $register,
		'register_text' => $phprlang['configuration_register_text'],
		'header_link_value' => $header_link,
		'header_link_text' => $phprlang['configuration_sitelink'],
		'language' => $language,
		'language_text' => $phprlang['configuration_language'],
		'template_type' => $template_type,
		'template_text' => $phprlang['configuration_template'],
		'disable_site' => $disable_site,
		'disable_text' => $phprlang['configuration_disable'],
		'debug_mode' => $debug_mode,
		'debug_text' => $phprlang['configuration_debug'],
		'showphpraid_addon_value' => $showphpraid_addon,
		'showphpraid_addon_text' => $phprlang['configuration_show_addon'],
		'enable_five_man' => $enable_five_man, 
		'enable_five_man_text' => $phprlang['configuration_enable_five_man'],
		'admin_email' => $admin_email,
		'admin_email_text' => $phprlang['configuration_admin_email'],
		'email_signature' => $email_signature,
		'email_signature_text' => $phprlang['configuration_email_sig'],
		'rss_header' => $phprlang['configuration_rss_header'],
		'rss_site_text' => $phprlang['configuration_rss_site'],
		'rss_export_text' => $phprlang['configuration_rss_export'],
		'rss_feed_amt_txt' => $phprlang['configuration_rss_feed_amt'],
		'rss_site_url' => $rss_site_url,
		'rss_export_url' => $rss_export_url,
		'rss_feed_amt' => $rss_feed_amt,
		'records_per_page_text' => $phprlang['configuration_records_per_page'],
		'records_per_page' => $records_per_page,
		'buttons' => $buttons,
	)
);

if(isset($_POST['submit']))
{
	if(isset($_POST['disable']))
		$disable = 1;
	else
		$disable = 0;

	if(isset($_POST['debug']))
		$p_debug = 1;
	else
		$p_debug = 0;
		
 	if(isset($_POST['showphpraid_addon']))
 		$showphpraid_addon = 1;
 	else
 		$showphpraid_addon = 0;

 	if(isset($_POST['enable_five_man']))
 		$enable_five_man = 1;
 	else
 		$enable_five_man = 0;
 		
	$p_link = scrub_input($_POST['phpraid_addon_link'], true);
	$h_logo = scrub_input($_POST['header_logo'], true);
	$h_link = scrub_input($_POST['header_link'], true);
	$lang = scrub_input($_POST['language']);
	
	$register = scrub_input(DEUBB($_POST['register']), true);
	$t_type = scrub_input(DEUBB($_POST['template']));
	$a_email = scrub_input(DEUBB($_POST['admin_email']));
	$e_sig = scrub_input(DEUBB($_POST['email_signature']));
	$rss_site_url_p = scrub_input($_POST['rss_site_url'], true);
	$rss_export_url_p = scrub_input($_POST['rss_export_url'], true);
	$rss_feed_amt_p = scrub_input($_POST['rss_feed_amt']);
		
	$records_per_page = scrub_input($_POST['records_per_page']);
	
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'phpraid_addon_link';", quote_smart($p_link));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'header_logo';", quote_smart($h_logo));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'register_url';", quote_smart($register));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'header_link';", quote_smart($h_link));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'language';", quote_smart($lang));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'template';", quote_smart($t_type));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'disable';", quote_smart($disable));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'debug';", quote_smart($p_debug));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'showphpraid_addon';", quote_smart($showphpraid_addon));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'enable_five_man';", quote_smart($enable_five_man));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'admin_email';", quote_smart($a_email));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'email_signature';", quote_smart($e_sig));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'rss_site_url';", quote_smart($rss_site_url_p));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'rss_export_url';", quote_smart($rss_export_url_p));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'rss_feed_amt';", quote_smart($rss_feed_amt_p));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'records_per_page';", quote_smart($records_per_page));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	
	header("Location: admin_generalcfg.php");
}

//
// Start output of the page.
//
require_once('./includes/admin_page_header.php');
$wrmadminsmarty->display('admin_general_config.html');
require_once('./includes/admin_page_footer.php');

?>