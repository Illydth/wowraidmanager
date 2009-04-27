<?php
/***************************************************************************
 *                                login.php
 *                            -------------------
 *   begin                : Saturday, Jan 16, 2005
 *   copyright            : (C) 2007-2008 Douglas Wagner
 *   email                : douglasw@wagnerweb.org
 *
 *   $Id: login.php,v 2.00 2008/03/07 17:01:57 psotfx Exp $
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
define("PAGE_LVL","anonymous");
require_once("includes/authentication.php");

$ShowLoginForm = TRUE;

if(!isset($_GET['mode']))
{
	// is the user already logged in? if so, there's no need for them to login again
	if($_SESSION['session_logged_in'] == 0) {
		if(isset($_POST['login'])) 	{
			$logged_in = phpraid_login();
			if($logged_in == 0)
			{
				$ShowLoginForm = FALSE;
				
				$forgot_password_line='';
				
				//$BridgeSupportPWDChange came from the bridge
				if ( ($BridgeSupportPWDChange == TRUE) and isset($BridgeSupportPWDChange) )
				{
					$forgot_password_line='<a href="login.php?mode=new_pwd">'.$phprlang['login_forgot_password'].'</a>';
				}

				//$page->set_file(array(
				//	'output' => $phpraid_config['template'] . '/error_login.htm')
				//);
				
				$wrmsmarty->assign('login_frm',
					array(
							'form_action'=>'login.php',
							'login_fail'=>$phprlang['login_fail'],
							'forgot_password'=>$phprlang['login_forgot_password'],
							'errorlogin_header'=>$phprlang['login_fail_title'],
							'username'=>$phprlang['username'],
							'password'=>$phprlang['login_curr_password'],
							'forgot_password_line'=>$forgot_password_line,
							'bd_login'=>$phprlang['login'],
						)
				);
				require_once('includes/page_header.php');

				$wrmsmarty->display('error_login.html');
				
			}
			else if ($logged_in == -1)
			{
				$errorTitle = $phprlang['login_fail_title'];
				$errorMsg = $phprlang['userclass_msg'];
				$errorDie = 1;			
			} 
			else { 
				//unset $errorDie;
				header("Location: index.php");
			}
		}
	} else {
		// user is already logged in
		// either they're trying to logout
		// or they shouldn't be accessing this page
		if(isset($_GET['logout'])) {
			// it would appear they're trying to logout
			phpraid_logout();
					
			header("Location: index.php");
		} else {
			// they did something wrong, let's just send them back to the mainpage
			header("Location: index.php");
		}
	}
}

if ($_GET['mode'] == "new_pwd"){

	$ShowLoginForm = FALSE;

	if(!isset($_POST['substep'])) {
		//$page->set_file(array(
		//	'output' => $phpraid_config['template'] . '/error_resetpwd.htm')
		//);
		
		$wrmsmarty->assign('new_pwd',
			array(
					'form_action'=>'login.php?mode=new_pwd',
					'password_reset_msg'=>$phprlang['login_password_reset_msg'],
					'sendnewpwd_header'=>$phprlang['login_pwdreset_title'],
					'username'=>$phprlang['username'],
					'email'=>$phprlang['email'],
					'bd_submit'=>$phprlang['submit'],
					'bd_reset'=>$phprlang['reset'],
					'hidden_substep'=>2,
				)
		);

		require_once('includes/page_header.php');

		$wrmsmarty->display('error_resetpwd.html');
		$ShowLoginForm = TRUE;
	}
	if($_POST['substep'] == 2) {
		$errorDie = 2;
		$username = $_POST['username'];
		$email = $_POST['email'];
			
		//check: is user in WRM DB
		$sql = sprintf("SELECT  profile_id, email, username FROM " . $phpraid_config['db_prefix'] . "profile WHERE username = %s and email= %s", quote_smart($username),quote_smart($email));

		$profilresult = $db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
		if (mysql_num_rows($profilresult) != 1)
		{
			$errorTitle = $phprlang['login_pwdreset_fail_title'];
			$errorMsg = $phprlang['login_username_email_incorrect'];
		}
		else
		{
			$data = $db_raid->sql_fetchrow($profilresult, true);
			//create password
			$newpassword = "";
			$newpasswordlength = 8;

			for($i=0; $i < $newpasswordlength; $i++) 
			{
				//Generate a random integer
				//chr(int $ascii) -> Return a specific character
				$newpassword .= chr(rand(48,122)); 
			}
			$errorTitle = $phprlang['login_pwdreset_title'];
			$errorMsg  = $phprlang['login_password_sent'].$email.$phprlang['login_password_sent2'];
			//$errorMsg .= $phprlang['password_new'].':<br/>'.$newpassword.'<br/>';
			
			$emailmsg  = $phprlang['login_password_email_msg'].$newpassword.$phprlang['login_password_email_msg2'];
			email($email,$phprlang['login_password_email_sub'],$emailmsg);
			db_password_change($data['profile_id'],$newpassword);
		}
	}
}

if ($_GET['mode'] == "ch_pwd"){

	$ShowLoginForm = FALSE;

	if(!isset($_POST['substep'])) {
		//$page->set_file(array(
		//	'output' => $phpraid_config['template'] . '/error_chpwd.htm')
		//);
		
		$wrmsmarty->assign('ch_pwd',
			array(
					'form_action'=>'login.php?mode=ch_pwd',
					'password_reset_msg'=>$phprlang['login_password_reset_msg'],
					'sendnewpwd_header'=>$phprlang['login_pwdreset_title'],
					'username_text'=>$phprlang['login_chpass_text'],
					'username'=>$_SESSION['username'],
					'curr_password'=>$phprlang['login_curr_password'],
					'new_password'=>$phprlang['login_password_new'],
					'confirm_password'=>$phprlang['login_password_conf'],
					'bd_submit'=>$phprlang['submit'],
					'bd_reset'=>$phprlang['reset'],
					'hidden_substep'=>2,
				)
		);

		require_once('includes/page_header.php');

		$wrmsmarty->display('error_chpwd.html');
		$ShowLoginForm = TRUE;
	}
	if($_POST['substep'] == 2) {
		$username = scrub_input($_POST['username']);
		$curr_pass = scrub_input($_POST['curr_password']);
		$new_pass = scrub_input($_POST['new_password']);
		$conf_pass = scrub_input($_POST['confirm_password']);
		$errorTitle = $phprlang['pwdsend_title'];
		//$errorDie = 2;
			
		//check: is user in WRM DB
		$sql = sprintf("SELECT  profile_id, password, username FROM " . $phpraid_config['db_prefix'] . "profile WHERE username = %s and password = %s", quote_smart($username),quote_smart(md5($curr_pass)));

		$profilresult = $db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
		if (mysql_num_rows($profilresult) != 1)
		{
			$errorTitle = $phprlang['login_pwdreset_fail_title'];
			$errorMsg = $phprlang['login_password_incorrect'];
			$errorDie=TRUE;
		}
		else
		{
			$data = $db_raid->sql_fetchrow($profilresult, true);
			
			if (md5($new_pass) == md5($conf_pass))
			{			 
				db_password_change($data['profile_id'],$new_pass);
				$errorTitle = $phprlang['login_pwdreset_title'];
				$errorMsg = $phprlang['login_pwdreset_success'];
				$errorDie = TRUE;
			}
			else
			{
				$errorTitle = $phprlang['login_pwdreset_fail_title'];
				$errorMsg = $phprlang['login_password_incorrect'];
				$errorDie = TRUE;				
			}
		}
	}
}


//
// Start output of page
//
if (isset($errorDie)){
	$ShowLoginForm = TRUE;
	require_once('includes/page_header.php');
}
require_once('includes/page_footer.php');
?>