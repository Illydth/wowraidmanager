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

// if not using phpRaid die
if($phpraid_config['auth_type'] != 'iums')
{
	die("You can not access this file");
	$db_raid->sql_close();
}

// page authentication
define("PAGE_LVL","anonymous");
require_once("includes/authentication.php");

if(isset($_POST['submit']))	
{
	// check for errors
	$form_error = 0;
	
	$user = scrub_input(strtolower($_POST['username']));
	$pass = $_POST['password']; //Don't scrub, we'll MD5 this later which should blow away any issues.
	$confirm = $_POST['confirm']; //Don't scrub, needs to equal pass.
	$email = scrub_input($_POST['email']);
	
	// confirm passwords
	if($pass != $confirm)
	{
		$form_error = 1;
		$msg .= '<li>' . $phprlang['register_confirm'] . '</li>';
	}
	if($user == '')
	{
		$form_error = 1;
		$msg .= '<li>' . $phprlang['register_user_empty'] . '</li>';
	}
	if($pass == '')
	{
		$form_error = 1;
		$msg .= '<li>' . $phprlang['register_pass_empty'] . '</li>';
	}
	if($email == '')
	{
		$form_error = 1;
		$msg .= '<li>' . $phprlang['register_email_empty'] . '</li>';
	}
	
	// check if username or email already exists
	$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "profile";
	$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
	while($data = $db_raid->sql_fetchrow($result, true))
	{
		if($user == $data['username'])
		{
			$form_error = 1;
			$msg .= '<li>' . $phprlang['register_user_exists'] . '</li>';
		}
		
		if($email == $data['email'])
		{
			$form_error = 1;
			$msg .= '<li>' . $phprlang['register_email_exists'] . '</li>';
		}
	}
	
	if($form_error == 0)
	{
		$pass = md5($pass);
		
		// default group
		if($phpraid_config['default_group'] != 'nil')
			$default = $phpraid_config['default_group'];
		else
			$default = '0';
		
		// no errors, insert into database
		$sql = sprintf("INSERT INTO " . $phpraid_config['db_prefix'] . "profile 
					(`email`,`password`,`priv`,`username`)
				VALUES
					(%s,%s,%s,%s)", quote_smart($email), quote_smart($pass), 
					quote_smart($default), quote_smart($user));
		$db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
		
		$subject = $phprlang['register_email_header'] . ' ' . $phpraid_config['guild_name'];
		$msg = $phprlang['register_email_greeting'] . ' ' . $user . ",\n\n" . $phprlang['register_email_subject'];
		
		email($email, $subject, $msg);
		
		$errorTitle = $phprlang['register_complete_header'];
		$errorMsg = $phprlang['register_complete_msg'];
		$errorDie = 0;
	}
	else
	{
		$errorTitle = $phprlang['register_error'];
		$errorMsg = '<ul>' . $msg . '</ul>';
		$errorDie = 1;
		$errorSpace = 1;
	}
}

//
// Start output of page
//
require_once('includes/page_header.php');

if(!isset($_POST['submit']) || $form_error == 1)
{
	$form_action = 'register.php';
	$buttons = '<input type="submit" value="Submit" name="submit" class="mainoption"> 
				<input type="reset" value="Reset" name="reset" class="liteoption">';
	$username = '<input type="text" name="username" value="' . $user . '" class="post">';
	$email = '<input type="text" name="email" value="' . $email . '" class="post">';
	$password = '<input type="password" name="password" class="post">';
	$confirm = '<input type="password" name="confirm" class="post">';
	$wrmsmarty->assign('register_data',
		array(
			'register_header'=>$phprlang['register_header'],
			'buttons'=>$buttons,
			'username'=>$username,
			'email'=>$email,
			'password'=>$password,
			'confirm_password'=>$confirm,
			'username_text'=>$phprlang['register_username_text'],
			'email_text'=>$phprlang['register_email_text'],
			'password_text'=>$phprlang['register_password_text'],
			'confirm_password_text'=>$phprlang['register_confirm_text'],
			'buttons'=>$buttons
		)
	);
	
	$wrmsmarty->display('register.html');
}

require_once('includes/page_footer.php');
?>