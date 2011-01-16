<?php
/***************************************************************************
*                                common.php
*                            -------------------
*   begin                : Saturday, Jan 16, 2005
*   copyright            : (C) 2007-2008 Douglas Wagner
*   email                : douglasw@wagnerweb.org
*
*   $Id: common.php,v 2.00 2007/11/23 14:45:33 psotfx Exp $
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
$phpraid_dir = './';

/*************************************************
 * Installation Redirect if Needed (Deprecated)
 *************************************************/
// redirect to setup if it exists
if(file_exists($phpraid_dir.'install/')) {
	header("Location: install/install.php");
}

// Sanity Check the Config File
require_once($phpraid_dir."sanity.php");

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
require_once($phpraid_dir.'includes/functions.php');
require_once($phpraid_dir.'includes/functions_mysql.php');
require_once($phpraid_dir.'includes/functions_date.php');
require_once($phpraid_dir.'includes/functions_logging.php');
require_once($phpraid_dir.'includes/functions_tables.php');
require_once($phpraid_dir.'includes/functions_users.php');
require_once($phpraid_dir.'includes/ubb.php');
require_once($phpraid_dir.'includes/scheduler.php');

/****************************************************
 * Report Output Setup (Deprecated)
 *      The information in this section is deprecated from 4.x on
 *      users should NOT uncomment these values unless otherwise told.
 *      This section will be removed as of 4.0.
 ****************************************************/
//require_once($phpraid_dir.'includes/report.php');

// reports for all data listing
//global $report;
//$report = &new ReportList;

/************************************************
 * Database Connection and phpraid_config Load
 ************************************************/
// database connection
global $db_raid, $errorTitle, $errorMsg, $errorDie;
if ($phpraid_config['persistent_db'] == TRUE)
	$db_raid = &new sql_db($phpraid_config['db_host'],$phpraid_config['db_user'],$phpraid_config['db_pass'],$phpraid_config['db_name'],TRUE,TRUE);
else
	$db_raid = &new sql_db($phpraid_config['db_host'],$phpraid_config['db_user'],$phpraid_config['db_pass'],$phpraid_config['db_name'],TRUE,FALSE);
	
if(!$db_raid->db_connect_id)
{
	die('<div align="center"><strong>There appears to be a problem with the database server.<br>We should be back up shortly.</strong></div>');
}

// unset database password for security reasons
// we won't use it after this point
unset($phpraid_config['db_user']);
unset($phpraid_config['db_pass']);

// Set UTF8
set_WRM_DB_utf8();

//
// Populate the $phpraid_config array
//
$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "config";
$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
while($data = $db_raid->sql_fetchrow($result, true))
{
	//$phpraid_config["{$data['0']}"] = $data['1'];
	$phpraid_config[$data['config_name']] = $data['config_value'];
}


/**********************************************************
 * Load Template System Here (Smarty)
 **********************************************************/
//Load Smarty Library
$wrm_dir = $curr_dir = dirname(__FILE__);
define('SMARTY_DIR', $wrm_dir .'/includes/smarty/libs/');
require(SMARTY_DIR . 'Smarty.class.php');

$wrmsmarty = new Smarty();
$wrmsmarty->template_dir = $wrm_dir . '/templates/' . $phpraid_config['template'] . '/';
$wrmsmarty->compile_dir  = $wrm_dir . '/cache/templates_c/';
$wrmsmarty->config_dir   = $wrm_dir . '/includes/smarty/configs/';
$wrmsmarty->cache_dir    = $wrm_dir . '/cache/smarty_cache/';
// Turning on Caching will cause many pages not to display dynamic changes properly.
$wrmsmarty->caching = false;
$wrmsmarty->compile_check = true;
/* Turn on/off Smarty Template Debugging by commenting/uncommenting the lines below. */
$wrmsmarty->debugging = false;
//$wrmsmarty->debugging = true;

//
/**********************************************************
 * Load phpLib Template System (Deprecated)
 *      The phpLib Template System has now been removed.  
 *      4.0 fully migrates to the Smarty Template System
 *      and will no longer use phpLib.
 *      
 *      This section will be removed upon 4.0 release.
 **********************************************************/
//require_once($phpraid_dir.'includes/template.php');
//$page = &new wrmTemplate();
//$page->set_root($phpraid_dir.'templates');

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

//foreach($phprlang as $key => $value)
//{
//	$phprlang[$key] = htmlentities($value, ENT_QUOTES, "UTF-8", false);
//}

/***************************************************
 * Set Authentication Method and Load Auth Files
 ***************************************************/
// get auth type

// Illydth:  We've updated this to parse the "auth" file from the auth directory prior to the definition
//   of wrm_login() within the functions_auth.php file.  This allows users to custom define a wrm_login()
//   function that will work with specialtiy bridges.  The "function_exists" check calls a function that
//   dymanically defines the "wrm_login()" function at runtime.
require_once($phpraid_dir.'auth/auth_' . $phpraid_config['auth_type'] . '.php');
require_once($phpraid_dir.'includes/functions_auth.php');
if (!function_exists('wrm_login'))
	DEFINE_wrm_login();

// good ole authentication
$lifetime = get_cfg_var("session.gc_maxlifetime"); 
$temp = session_name("WRM-" .  $phpraid_config['auth_type']);
$temp = session_set_cookie_params($lifetime, getCookiePath());
session_start();
$_SESSION['name'] = "WRM-" . $phpraid_config['auth_type'];

// set session defaults
if (!isset($_SESSION['initiated'])) 
{
	if(isset($_COOKIE['profile_id']) && isset($_COOKIE['password']))
	{ 
		$testval = wrm_login();
		if (!$testval)
		{
			wrm_logout();
			session_regenerate_id();
			set_WRM_SESSION(-1, 0, 'Anonymous', true);
		}
	}
	else 
	{
		session_regenerate_id();
		set_WRM_SESSION(-1, 0, 'Anonymous', true);
	}
}

get_permissions($_SESSION['profile_id']);

/***************************************************
 * Set Up Column Modification Array
 ***************************************************/
$col_mod = array();

/***************************************************
 * Set Up Column Modification Array
 ***************************************************/
$expboxid = exp1243304747;

/***************************************************
 * Load Game Specific Data to Global Variables
 ***************************************************/
$wrm_global_classes = array();
$wrm_global_races = array();
$wrm_global_roles = array();
$wrm_global_gender = array();

// Load the Classes Array
$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "classes";
$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
$x = 0;
while($data = $db_raid->sql_fetchrow($result, true))
{
	$wrm_global_classes[$x]['class_index'] = $data['class_index'];
	$wrm_global_classes[$x]['class_id'] = $data['class_id'];
	$wrm_global_classes[$x]['class_code'] = $data['class_code'];
	$wrm_global_classes[$x]['lang_index'] = $data['lang_index'];
	$wrm_global_classes[$x]['image'] = $data['image'];
	$x++;
}

// Load the Races Array
$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "races";
$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
$x = 0;			
while($data = $db_raid->sql_fetchrow($result, true))
{
	$wrm_global_races[$x]['race_id'] = $data['race_id'];
	$wrm_global_races[$x]['faction'] = $data['faction'];
	$wrm_global_races[$x]['lang_index'] = $data['lang_index'];
	$x++;
}

// Load the Roles Array
$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "roles";
$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
$x = 0;			
while($data = $db_raid->sql_fetchrow($result, true))
{
	$wrm_global_roles[$x]['role_id'] = $data['role_id'];
	$wrm_global_roles[$x]['role_name'] = $data['role_name'];
	$wrm_global_roles[$x]['lang_index'] = $data['lang_index'];
	$wrm_global_roles[$x]['image'] = $data['image'];
	$x++;
}

// Load the Gender Array
$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "gender";
$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
$x = 0;			
while($data = $db_raid->sql_fetchrow($result, true))
{
	$wrm_global_gender[$x]['gender_id'] = $data['gender_id'];
	$wrm_global_gender[$x]['lang_index'] = $data['lang_index'];
	$x++;
}

/****************************************************
 * Maintenance Flag Disable Site
 ****************************************************/
if($phpraid_config['disable'] == 1 && $_SESSION['priv_configuration'] == 0)
{
	$errorTitle = $phprlang['maintenance_header'];
	$errorMsg = $phprlang['maintenance_message'];
	$errorDie = 1;
}

/****************************************************
 * Execute the Scheduler to Perform Automated Tasks
 ****************************************************/
// Do not execute Scheduler if the site is disabled.
$return_code = array();
$return_code = scheduler();
switch ($return_code['errval'])
{
	case 0:
		//all good, move on.
		break;
	case 1 - 4: //Error Returned from Recurring Raids Scheduler
		$errorTitle = $return_code['errorTitle'];
		$errorMsg = $return_code['errorMsg'];
		$errorMsg .= "<br><br>Error Code: " . $return_code['errval'];
		$errorDie = $return_code['errorDie'];
		break;	
	default:
		$errorTitle = $phprlang['scheduler_error_header'];
		$errorMsg = $phprlang['scheduler_unknown'];
		$errorMsg .= "<br><br>Error Code: " . $return_code;
		$errorDie = 1;
		break;
}

?>