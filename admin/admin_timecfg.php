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
if($phpraid_config['dst'] == '0')
	$dst = '<input type="checkbox" name="dst" value="1">';
else
	$dst = '<input type="checkbox" name="dst" value="1" checked>';

// 12/24 Hour switch
$ampm = '<select name="ampm">';
if($phpraid_config['ampm'] == '12')
       $ampm .= '<option value="12" selected>12h</option><option value="24">24h</option>';
else
    $ampm .= '<option value="12">12h</option><option value="24" selected>24h</option>';
$ampm .= '</select>';

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

$date_format = '<input name="date_format" type="text" class="post"  value="' . $phpraid_config['date_format']. '">';
$time_format = '<input name="time_format" type="text" class="post" value="' . $phpraid_config['time_format']. '">';
$buttons = '<input type="submit" name="submit" value="'.$phprlang['submit'].'" class="mainoption"> <input type="reset" name="Reset" value="'.$phprlang['reset'].'" class="liteoption">';

$wrmadminsmarty->assign('config_data',
	array(
		'time_header' => $phprlang['time_header'],
		'date_text' => $phprlang['configuration_date'],
		'date_format' => $date_format,
		'time_text' => $phprlang['configuration_time'],
		'time_format' => $time_format,
		'ampm_text' => $phprlang['configuration_ampm'],
		'ampm' => $ampm,
		'timezone_text' => $phprlang['configuration_timezone_text'],
		'timezone'=>$timezone,
		'dst_text' => $phprlang['configuration_dst_text'],
		'dst'=>$dst,
		'buttons' => $buttons,
	)
);

if(isset($_POST['submit']))
{
	// form submission, update the database		
	if(isset($_POST['dst']))
		$dst = 1;
	else
		$dst = 0;
	
	$d_format = scrub_input(DEUBB($_POST['date_format']));
	$t_format = scrub_input(DEUBB($_POST['time_format']));
	$ampm = scrub_input(DEUBB($_POST['ampm']));
	$t_zone = scrub_input(DEUBB($_POST['timezone'] * 100));
	$dst *= 100;
	
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'date_format';", quote_smart($d_format));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error($sql),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'time_format';", quote_smart($t_format));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'ampm';", quote_smart($ampm));
    $db_raid->sql_query($sql) or print_error($sql,mysql_error($sql),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'timezone';", quote_smart($t_zone));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
    $sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'dst';", quote_smart($dst));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	
	header("Location: admin_timecfg.php");
}
//
// Start output of the page.
//
require_once('./includes/admin_page_header.php');
$wrmadminsmarty->display('admin_time_config.html');
require_once('./includes/admin_page_footer.php');

?>