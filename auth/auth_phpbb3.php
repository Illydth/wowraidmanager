<?php
/***************************************************************************
 *                             auth_phpbb3.php
 *                            -------------------
 *   begin                : Apr 15, 2008
 *	 Dev                  : Carsten Hölbing
 *	 email                : hoelbin@gmx.de
 *
 *   copyright            : (C) 2007-2008 Douglas Wagner
 *   email                : douglasw0@yahoo.com
 *
 ***************************************************************************/

// setup phpBB user integration
define('IN_PHPBB', true);

// define our auth type
if( isset( $_GET["phpbb_root_path"] ) || isset( $_POST["phpbb_root_path"]) )
	log_hack();

//change password in phpbb
//return value:
//  -1 not support
//   1 has been successfully change
// >=2 cannot change
function db_password_change($newpassword)
{
	return (-1);
}

// check profile
// Specific to phpBB authentication only. Checks to see if a profile exists
// for phpBB user and if not, creates one.
function check_profile($user)
{
	global $db_raid, $phpraid_config;
	
	$user_id = $user->data['user_id'];
	$email = $user->data['user_email'];
	
	$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "profile WHERE profile_id='$user_id'";
	$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
	
	//Update email incase it doesn't match phpBB
	if($user->data['user_email'] != $result['email'])
	{
		$sql = "UPDATE " . $phpraid_config['db_prefix'] . "profile SET email='$email',last_login_time='".quote_smart(time())."' WHERE profile_id='$user_id'";
		$db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
	}
	
	// if nothing returns we need to create profile
	// otherwise they have a profile so let's set their ID
	// we'll just use the phpBB user id as the profile ID to simplify things
	if($db_raid->sql_numrows($result) == 0 && $user->data['username'] != 'Anonymous')
	{
		$user_id = $user->data['user_id'];
		$username = $user->data['username'];
		
		if($phpraid_config['default_group'] != 'nil')
			$default = $phpraid_config['default_group'];
		else
			$default = '0';
		
		// nothing returned, create profile
		$sql = "INSERT INTO " . $phpraid_config['db_prefix'] . "profile (`profile_id`,`email`,`password`,`priv`,`username`,`last_login_time`)
				VALUES ('$user_id','$email','','$default','$username',".quote_smart(time()).")";
		$db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
	}
	
	return $user->data['user_id'];
}


function phpraid_login()
{

	//$db= phpbb3 db;$db_raid=wrm db
	global $db,   $phpbb_root_path, $phpEx, $phpraid_config ;
	global $user, $auth;

	$username = isset($_POST['username']) ? $_POST['username'] : '';
	$password = isset($_POST['password']) ? $_POST['password'] : '';
	
		$sql = "SELECT user_id, username, user_password
		FROM " . USERS_TABLE . " WHERE username = '" . str_replace("\\'", "''", $username) . "'";
		
	if ( !($result = $db->sql_query($sql)) ){
		message_die(GENERAL_ERROR, 'Error in obtaining userdata', '', __LINE__, __FILE__, $sql);
	}

		
	if( $row = $db->sql_fetchrow($result) )
	{

		if( phpbb_check_hash($password,$row['user_password'])){
		
		
			if ($user->data['is_registered']){
				redirect(append_sid("{$phpbb_root_path}index.$phpEx"));
			}
			else{
				$result = $auth->login($username,$password);
				if ($result['status'] == LOGIN_SUCCESS)
				{	//User was succesfully logged into phpBB
					return 1;
				}
				else
				{  //User's login failed
					return 0;
				}
				
			}		
		}
	}
	return 0;
}


// logout function for phpBB3
function phpraid_logout()
{

	global $user;
	
	$user->session_kill();
	$user->session_begin();
	$message = $user->lang['LOGOUT_REDIRECT'];
	
	clear_session();
}

// database connection
$phpbb_prefix = $phpraid_config['phpbb_prefix'];

global $user_group_table, $phpbb_root_path, $phpEx;

$user_group_table = $phpbb_prefix . "user_group";
$phpbb_root_path = $phpraid_config['phpbb_root_path'];
$phpEx = substr(strrchr(__FILE__, '.'), 1);

include($phpbb_root_path . 'common.' . $phpEx);
require($phpbb_root_path . 'includes/functions_user.' . $phpEx);
require($phpbb_root_path . 'includes/functions_module.' . $phpEx);

//require($phpbb_root_path . 'includes/functions_template.' . $phpEx);
// read Session and load User-Information (phpbb3)
$user->session_begin();  // read Session 
$auth->acl($user->data); // load User-Information

$user->setup();

// remove the phpbb3 template variable.
unset($template);

//0 = not log in
//1 = log in
if ($user->data['username'] != 'Anonymous' ) {
		
	if ($user->data['user_id'] != '1') {

		// check profile in db
		check_profile($user);
	
		// setup session information
		$_SESSION['profile_id'] = $user->data['user_id'];
		$_SESSION['session_logged_in'] = 1;

		$_SESSION['username'] = $user->data['username'];
		$_SESSION['user_email'] = $user->data['user_email'];
	} else {
		$_SESSION['profile_id'] = 1;
		$_SESSION['session_logged_in'] = 0;
	}
}else{
		//if user login -> Anonymous 
			$_SESSION['priv_configuration'] = 0;
			$_SESSION['priv_profile'] = -1;
			define("PAGE_LVL","profile");
}

?>