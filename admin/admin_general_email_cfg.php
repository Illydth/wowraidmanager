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

$admin_email = '<input name="admin_email" type="text" class="post" value="' . $phpraid_config['admin_email'] .'" maxlength="255">';
$email_signature = '<textarea name="email_signature" cols="30" rows="5" id="email_signature" class="post">' . $phpraid_config['email_signature'] . '</textarea>';

$wrmadminsmarty->assign('config_data',
	array(
		'general_header' => $phprlang['general_configuration_header'],
		'email_header'=>$phprlang['configuration_email_header'],
		'admin_email' => $admin_email,
		'admin_email_text' => $phprlang['configuration_admin_email'],
		'email_signature' => $email_signature,
		'email_signature_text' => $phprlang['configuration_email_sig'],
		'button_submit' => $phprlang['submit'],
		'button_reset' => $phprlang['reset']
	)
);

if(isset($_POST['submit']))
{

	$admin_email = scrub_input(DEUBB($_POST['admin_email']));
	$email_signature = scrub_input(DEUBB($_POST['email_signature']));

	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'admin_email';", quote_smart($admin_email));
	$db_raid->sql_query($sql) or print_error($sql,$db_raid->sql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'email_signature';", quote_smart($email_signature));
	$db_raid->sql_query($sql) or print_error($sql,$db_raid->sql_error(),1);
	
	header("Location: admin_general_email_cfg.php");
}

//
// Start output of the page.
//
require_once('./includes/admin_page_header.php');
$wrmadminsmarty->display('admin_general_email_cfg.html');
require_once('./includes/admin_page_footer.php');

?>