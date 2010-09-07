<?php
/***************************************************************************
 *                               register.php
 *                            -------------------
 *   begin                : Saturday, Jan 16, 2005
 *   copyright            : (C) 2007 - 2008 Douglas Wagner
 *   email                : douglasw@wagnerweb.org
 *
 *   $Id: mysql.php,v 2.00 2008/03/10 01:23:01 psotfx Exp $
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

// if not using iUMS die
if($phpraid_config['auth_type'] != 'iums')
{
	die("You can not access this file");
	$db_raid->sql_close();
}

// page authentication
define("PAGE_LVL","anonymous");
require_once("includes/authentication.php");

$new_user_name = scrub_input(strtolower($_POST['new_user_name']));
$email = scrub_input($_POST['new_user_email']);

if(isset($_POST['submit']))	
{
	// check for errors
	$form_error = FALSE;

	$pass = $_POST['new_user_password']; //Don't scrub, we'll MD5 this later which should blow away any issues.
	$confirm = $_POST['new_user_confirm_password']; //Don't scrub, needs to equal pass.
	
	// confirm passwords
	if($pass != $confirm)
	{
		$form_error = TRUE;
		$msg .= '<li>' . $phprlang['register_confirm'] . '</li>';
	}
	if($new_user_name == '')
	{
		$form_error = TRUE;
		$msg .= '<li>' . $phprlang['register_user_empty'] . '</li>';
	}
	if($pass == '')
	{
		$form_error = TRUE;
		$msg .= '<li>' . $phprlang['register_pass_empty'] . '</li>';
	}
	if($email == '')
	{
		$form_error = TRUE;
		$msg .= '<li>' . $phprlang['register_email_empty'] . '</li>';
	}
	
	// check if username or email already exists
	$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "profile";
	$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	while($data = $db_raid->sql_fetchrow($result))
	{
		if($new_user_name == $data['username'])
		{
			$form_error = TRUE;
			$msg .= '<li>' . $phprlang['register_user_exists'] . '</li>';
		}
		
		if($email == $data['email'])
		{
			$form_error = TRUE;
			$msg .= '<li>' . $phprlang['register_email_exists'] . '</li>';
		}
	}
	
	if($form_error == FALSE)
	{
		$pass = md5($pass);
		
		wrm_profile_add("", $email, $pass, $new_user_name);
		
		$subject = $phprlang['register_email_header'] . ' ' . $phpraid_config['site_name'];
		$msg = $phprlang['register_email_greeting'] . ' ' . $new_user_name . ",\n\n" . $phprlang['register_email_subject'];
		
		//email($email, $subject, $msg);
		
		//
		// Start output of page
		//		
		require_once('includes/page_header.php');
		$wrmsmarty->assign('register_complete',
			array(
				'register_complete_header'=>$phprlang['register_complete_header'],
				'register_complete_msg'=>$phprlang['register_complete_msg'],
			)
		);
		$wrmsmarty->display('register_complete.html');
		require_once('includes/page_footer.php');
	}
	else
	{
		$errorTitle = $phprlang['register_error'];
		$errorMsg = '<ul>' . $msg . '</ul>';
		$errorDie = 1;
		$errorSpace = 1;
	}
}



if(!isset($_POST['submit']) || $form_error == 1)
{
	$form_action = 'register.php';

	//
	// Start output of page
	//
	require_once('includes/page_header.php');

	$wrmsmarty->assign('register_data',
		array(
			'register_header'=>$phprlang['register_header'],
			'buttons'=>$buttons,
			'username'=>$new_user_name,
			'email'=>$email,
			'username_text'=>$phprlang['register_username_text'],
			'email_text'=>$phprlang['register_email_text'],
			'password_text'=>$phprlang['register_password_text'],
			'confirm_password_text'=>$phprlang['register_confirm_text'],
			'button_submit'=>$phprlang['submit'],
			'button_reset'=>$phprlang['reset'],
		)
	);
	
	$wrmsmarty->display('register.html');
	require_once('includes/page_footer.php');
}
?>
