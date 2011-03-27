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
// Disallow Signup to Drafted Status
if($phpraid_config['auto_queue'] == '0')
	$auto_queue = '<input type="checkbox" name="auto_queue" value="1">';
else
	$auto_queue = '<input type="checkbox" name="auto_queue" value="1" checked>';

// Enforce Role Limits for Raid
if($phpraid_config['enforce_role_limits'] == '0')
	$enforce_role_limits = '<input type="checkbox" name="enforce_role_limits" value="1">';
else
	$enforce_role_limits = '<input type="checkbox" name="enforce_role_limits" value="1" checked>';

// Enforce Class Limits for Raid
if($phpraid_config['enforce_class_limits'] == '0')
	$enforce_class_limits = '<input type="checkbox" name="enforce_class_limits" value="1">';
else
	$enforce_class_limits = '<input type="checkbox" name="enforce_class_limits" value="1" checked>';

// Use Class Limits as Minimums
if($phpraid_config['class_as_min'] == '0')
	$class_as_min = '<input type="checkbox" name="class_as_min" value="1">';
else
	$class_as_min = '<input type="checkbox" name="class_as_min" value="1" checked>';

// Disable Freeze Checking
if($phpraid_config['disable_freeze'] == '0')
	$disable_freeze = '<input type="checkbox" name="disable_freeze" value="1">';
else
	$disable_freeze = '<input type="checkbox" name="disable_freeze" value="1" checked>';

// Show "Recurring Raids" settings (Enable/Disable Recurring Raids).
if($phpraid_config['recurrance_enabled'] == '0')
	$recurrance_enabled = '<input type="checkbox" name="recurrance_enabled" value="1">';
else
	$recurrance_enabled = '<input type="checkbox" name="recurrance_enabled" value="1" checked>';

// Prevent change in status (draft) if raid is frozen
if($phpraid_config['disable_freeze'] == '1') {
	$freeze_status_draft = '<input type="checkbox" name="freeze_status_draft" value="1" DISABLED>';
}
else {
	if($phpraid_config['freeze_status_draft'] == '0')
		$freeze_status_draft = '<input type="checkbox" name="freeze_status_draft" value="1">';
	else
		$freeze_status_draft = '<input type="checkbox" name="freeze_status_draft" value="1" checked>';
}

// Prevent change in status (queue) if raid is frozen
if($phpraid_config['disable_freeze'] == '1') {
	$freeze_status_queue = '<input type="checkbox" name="freeze_status_queue" value="1" DISABLED>';
}
else {
	if($phpraid_config['freeze_status_queue'] == '0')
		$freeze_status_queue = '<input type="checkbox" name="freeze_status_queue" value="1">';
	else
		$freeze_status_queue = '<input type="checkbox" name="freeze_status_queue" value="1" checked>';
}
	
// Prevent change in status (cancel) if raid is frozen
if($phpraid_config['disable_freeze'] == '1') {
	$freeze_status_cancel = '<input type="checkbox" name="freeze_status_cancel" value="1" DISABLED>';
}
else {
	if($phpraid_config['freeze_status_cancel'] == '0')
		$freeze_status_cancel = '<input type="checkbox" name="freeze_status_cancel" value="1">';
	else
		$freeze_status_cancel = '<input type="checkbox" name="freeze_status_cancel" value="1" checked>';
}
	
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
	
$buttons = '<input type="submit" name="submit" value="'.$phprlang['submit'].'" class="mainoption"> <input type="reset" name="Reset" value="'.$phprlang['reset'].'" class="liteoption">';	
	
$wrmadminsmarty->assign('config_data',
	array(
		'enforce_role_limits' => $enforce_role_limits,
		'enforce_class_limits' => $enforce_class_limits,
		'class_as_min' => $class_as_min,
		'auto_queue' => $auto_queue,
		'disable_freeze' => $disable_freeze,
		'freeze_status_draft' => $freeze_status_draft,
		'freeze_status_draft_text' => $phprlang['configuration_freeze_status_draft'],
		'freeze_status_queue' => $freeze_status_queue,
		'freeze_status_queue_text' => $phprlang['configuration_freeze_status_queue'],
		'freeze_status_cancel' => $freeze_status_cancel,
		'freeze_status_cancel_text' => $phprlang['configuration_freeze_status_cancel'],	
		'role_limit_text' => $phprlang['configuration_role_limit_text'],
		'class_limit_text' => $phprlang['configuration_class_limit_text'],
		'class_as_min_text' => $phprlang['configuration_class_as_min'],
		'freeze_text' => $phprlang['configuration_freeze'],
		'autoqueue_text' => $phprlang['configuration_autoqueue'],
		'raid_settings_header'=>$phprlang['configuration_raid_settings_header'],
		'raid_view_type' => $raid_view_type,
		'raid_view_type_text' => $phprlang['configuration_raid_view_type_text'],
		'recurrance_enabled_text' => $phprlang['configuration_recurrance_enabled_text'],
		'recurrance_enabled' => $recurrance_enabled,	
		'buttons' => $buttons,
	)
);

if(isset($_POST['submit']))
{
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
	
	if(isset($_POST['auto_queue']))
		$a_queue = 1;
	else
		$a_queue = 0;

	if(isset($_POST['disable_freeze']))
		$d_freeze = 1;
	else
		$d_freeze = 0;

	if(isset($_POST['recurrance_enabled']))
		$recurrance_enabled = 1;
	else
		$recurrance_enabled = 0;		

	if(isset($_POST['freeze_status_draft']))
		$freeze_draft = 1;
	else
		$freeze_draft = 0;
		
	if(isset($_POST['freeze_status_queue']))
		$freeze_queue = 1;
	else
		$freeze_queue = 0;
		
	if(isset($_POST['freeze_status_cancel']))
		$freeze_cancel = 1;
	else
		$freeze_cancel = 0;
		
	$raid_view_type = scrub_input($_POST['raid_view_type']);

	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'raid_view_type';", quote_smart($raid_view_type));
	$db_raid->sql_query($sql) or print_error($sql,$db_raid->sql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'auto_queue';", quote_smart($a_queue));
	$db_raid->sql_query($sql) or print_error($sql,$db_raid->sql_error($sql),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'disable_freeze';", quote_smart($d_freeze));
	$db_raid->sql_query($sql) or print_error($sql,$db_raid->sql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'enforce_role_limits';", quote_smart($enforce_role_limits));
	$db_raid->sql_query($sql) or print_error($sql,$db_raid->sql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'enforce_class_limits';", quote_smart($enforce_class_limits));
	$db_raid->sql_query($sql) or print_error($sql,$db_raid->sql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'class_as_min';", quote_smart($class_as_min));
	$db_raid->sql_query($sql) or print_error($sql,$db_raid->sql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'recurrance_enabled';", quote_smart($recurrance_enabled));
	$db_raid->sql_query($sql) or print_error($sql,$db_raid->sql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'freeze_status_draft';", quote_smart($freeze_draft));
	$db_raid->sql_query($sql) or print_error($sql,$db_raid->sql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'freeze_status_queue';", quote_smart($freeze_queue));
	$db_raid->sql_query($sql) or print_error($sql,$db_raid->sql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'freeze_status_cancel';", quote_smart($freeze_cancel));
	$db_raid->sql_query($sql) or print_error($sql,$db_raid->sql_error(),1);
	
	header("Location: admin_raidsettings.php");
}
	
//
// Start output of the page.
//
require_once('./includes/admin_page_header.php');
$wrmadminsmarty->display('admin_raid_settings.html');
require_once('./includes/admin_page_footer.php');

?>