<?php
/***************************************************************************
*                              admin_common.php
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
*
****************************************************************************/

/******************************************
 * Hacking Protection Section 
 ******************************************/
if ( !defined('IN_PHPRAID'))
	print_error("Hacking Attempt", "Invalid access detected", 1);

if(isset($_GET['phpraid_dir']) || isset($_POST['phpraid_dir']))
	die("Hacking attempt detected!");

// force reporting - Turn on the First Error_Reporting for Development, The Second for Production. 
//error_reporting(E_ALL ^ E_NOTICE);
error_reporting(E_ERROR | E_WARNING | E_PARSE);

// feel free to set this to absolute if necessary
$phpraid_dir = '../';

//FIX FOR OPEN BASEDIR ISSUES.
// No Win here, some people aren't allowed to include files not listed in the include list, 
//     others aren't able to modify their ini variables with INI set.  End result?  Someone
//     blows up on this code.
// Get list of Includes and Add them to ini_set for include path. 
//     - COMMNET THIS OUT IF YOU HAVE ISSUES WITH INI_SET ON YOUR HOST.
$include_list .= $phpraid_dir . "auth/";
$include_list .= ":" . $phpraid_dir . "db/";
$include_list .= ":" . $phpraid_dir . "includes/";
$include_list .= ":" . ini_get('include_path');
ini_set('include_path', $include_list); 

// Class require_onces
require_once($phpraid_dir.'includes/functions_mbwrapper.php');
require_once($phpraid_dir.'version.php');
require_once($phpraid_dir.'config.php');
require_once($phpraid_dir.'includes/functions_mysql.php');
require_once($phpraid_dir.'includes/functions_auth.php');
require_once($phpraid_dir.'includes/functions.php');
require_once($phpraid_dir.'includes/functions_date.php');
require_once($phpraid_dir.'includes/functions_logging.php');
require_once($phpraid_dir.'includes/functions_tables.php');
require_once($phpraid_dir.'includes/functions_users.php');
require_once($phpraid_dir.'includes/class_template.php');
require_once($phpraid_dir.'includes/ubb.php');
require_once($phpraid_dir.'includes/wowarmory/simple_html_dom.php');
require_once($phpraid_dir.'includes/wowarmory/scrapper.class.php');

/************************************************
 * Database Connection and phpraid_config Load
 ************************************************/
// database connection
global $db_raid, $errorTitle, $errorMsg, $errorDie;
if ($phpraid_config['persistent_db'])
	$db_raid = create_db_connection($phpraid_config['db_host'],$phpraid_config['db_user'],$phpraid_config['db_pass'],$phpraid_config['db_name'],TRUE,TRUE);
else
	$db_raid = create_db_connection($phpraid_config['db_host'],$phpraid_config['db_user'],$phpraid_config['db_pass'],$phpraid_config['db_name'],TRUE,FALSE);

if(!$db_raid->db_connect_id)
{
	die('<div align="center"><strong>There appears to be a problem with the database server.<br>We should be back up shortly.</strong></div>');
}

// Set UTF8
set_WRM_DB_utf8();

// unset database password for security reasons
// we won't use it after this point
unset($phpraid_config['db_pass']);

//
// Populate the $phpraid_config array
//
$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "config";
$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
while($data = $db_raid->sql_fetchrow($result, true))
{
	$phpraid_config["{$data['0']}"] = $data['1'];
}

/**********************************************************
 * Load Template System Here (Smarty)
 **********************************************************/
//Load Smarty Library
$curr_dir = dirname(__FILE__);
$dir_split_var = array();
preg_match('"(.*)admin"', $curr_dir, $dir_split_var);
$wrm_dir = $dir_split_var[1];
define('SMARTY_DIR', $wrm_dir . '/includes/smarty/libs/');
require(SMARTY_DIR . 'Smarty.class.php');

$wrmadminsmarty = new Smarty();
$wrmadminsmarty->template_dir = $wrm_dir . 'admin/template/';
$wrmadminsmarty->compile_dir  = $wrm_dir . 'cache/templates_c/admin/';
$wrmadminsmarty->config_dir   = $wrm_dir . 'includes/smarty/configs/';
$wrmadminsmarty->cache_dir    = $wrm_dir . 'cache/smarty_cache/admin/';
// Turning on Caching will cause many pages not to display dynamic changes properly.
$wrmadminsmarty->caching = false;
$wrmadminsmarty->compile_check = true;
/* Turn on/off Smarty Template Debugging by commenting/uncommenting the lines below. */
$wrmadminsmarty->debugging = false;
//$wrmadminsmarty->debugging = true;


//$wrmthemplate->set_loginbox_show_status($ShowLoginForm);
//$wrmthemplate->set_BridgeSupportPWDChange_status($BridgeSupportPWDChange);

/***************************************************
 * Load Language Files
 ***************************************************/
//FIX FOR OPEN BASEDIR ISSUES.
// No Win here, some people aren't allowed to include files not listed in the include list, 
//     others aren't able to modify their ini variables with INI set.  End result?  Someone
//     blows up on this code.
// Setup the Include for the Language Files.
//     - COMMNET THIS OUT IF YOU HAVE ISSUES WITH INI_SET ON YOUR HOST.
$include_list = $phpraid_dir . "language/lang_" . $phpraid_config['language'] . "/";
$include_list .= ":" . ini_get('include_path');
ini_set('include_path', $include_list); 

// Include Language Files.
if(!is_file($phpraid_dir."language/lang_{$phpraid_config['language']}/lang_main.php"))
{
	die("The language file <i>" . $phpraid_config['language'] . "</i> could not be found!");
	$db_raid->sql_close();
}
else
{
	require_once($phpraid_dir."language/lang_{$phpraid_config['language']}/lang_main.php");
}

/***************************************************
 * Set WRM Template
***************************************************/
$wrmtemplate = new wrm_template($db_raid,$phpraid_config,$phprlang, $phpraid_dir);
$wrmtemplate->set_smarty($wrmadminsmarty);

/***************************************************
 * Set Authentication Method and Load Auth Files
 ***************************************************/
// get auth type
require_once($phpraid_dir.'auth/auth_' . $phpraid_config['auth_type'] . '.php');

// good ole authentication
//$lifetime = get_cfg_var("session.gc_maxlifetime");
$lifetime = 60*60*24*30*2; // session lifetime = 2 month 
session_name("WRM-" .  $phpraid_config['auth_type']);
//$temp = session_set_cookie_params($lifetime, getCookiePath());
/*
 * more infos here
 * http://www.php.net/manual/en/function.session-set-cookie-params.php
 */ 
session_set_cookie_params($lifetime,"/");
session_start();

//$_SESSION['name'] = "WRM-" . $phpraid_config['auth_type'];

// set session defaults
//if (!isset($_SESSION['initiated'])) 
//{
//	if(isset($_COOKIE['profile_id']) && isset($_COOKIE['password']))
//	{ 
//		$testval = wrm_login();
//		if (!$testval)
//		{
//			wrm_logout();
//			session_regenerate_id();
//			$_SESSION['initiated'] = true;
//			$_SESSION['username'] = 'Anonymous';
//			$_SESSION['session_logged_in'] = 0;
//			$_SESSION['profile_id'] = -1;
//		}
//	}
//	else 
//	{
//		session_regenerate_id();
//		$_SESSION['initiated'] = true;
//		$_SESSION['username'] = 'Anonymous';
//		$_SESSION['session_logged_in'] = 0;
//		$_SESSION['profile_id'] = -1;
//	}
//}

get_permissions($_SESSION['profile_id']);

//if($_SESSION['priv_configuration'] == 0)
//	header("Location: ../index.php");

/****************************************************
 * Maintenance Flag Disable Site
 ****************************************************/
//if($phpraid_config['disable'] == 1 && $_SESSION['priv_configuration'] == 0)
//{
//	$errorTitle = $phprlang['maintenance_header'];
//	$errorMsg = $phprlang['maintenance_message'];
//	$errorDie = 1;
//}

?>
