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
// Allow Multiple Signups
if($phpraid_config['multiple_signups'] == '0')
	$allow_multiple_signups = '<input type="checkbox" name="multiple_signups" value="1">';
else
	$allow_multiple_signups = '<input type="checkbox" name="multiple_signups" value="1" checked>';

// Allow anonymous viewing.
if($phpraid_config['anon_view'] == '0')
	$allow_anonymous_viewing = '<input type="checkbox" name="anon_view" value="1">';
else
	$allow_anonymous_viewing = '<input type="checkbox" name="anon_view" value="1" checked>';
	
// Make resistance Optional
if($phpraid_config['resop'] == '0')
	$allow_resop = '<input type="checkbox" name="resop" value="1">';
else
	$allow_resop = '<input type="checkbox" name="resop" value="1" checked>';

$buttons = '<input type="submit" name="submit" value="'.$phprlang['submit'].'" class="mainoption"> <input type="reset" name="Reset" value="'.$phprlang['reset'].'" class="liteoption">';
	
$wrmadminsmarty->assign('config_data',
	array(
			'allow_multiple_signups' => $allow_multiple_signups,
			'multiple_text' => $phprlang['configuration_multiple'],
			'allow_anonymous_viewing' => $allow_anonymous_viewing,
			'anonymous_text' => $phprlang['configuration_anonymous'],
			'allow_resop' => $allow_resop,
			'resop_text' => $phprlang['configuration_resop'],
			'user_rights_header'=>$phprlang['configuration_user_rights_header'],
			'buttons' => $buttons,
	)
);

if(isset($_POST['submit']))
{	
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
		
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'multiple_signups';", quote_smart($allow_multiple));
	$db_raid->sql_query($sql) or print_error($sql,$db_raid->sql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'resop';", quote_smart($allow_resop));
	$db_raid->sql_query($sql) or print_error($sql,$db_raid->sql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'anon_view';", quote_smart($anon));
	$db_raid->sql_query($sql) or print_error($sql,$db_raid->sql_error(),1);

	header("Location: admin_usersettings.php");		
}

//
// Start output of the page.
//
require_once('./includes/admin_page_header.php');
$wrmadminsmarty->display('admin_user_settings.html');
require_once('./includes/admin_page_footer.php');

?>
