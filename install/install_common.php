<?php
/***************************************************************************
*                            install_common.php
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

/**********************************************************
 * Load Template System Here (Smarty)
 **********************************************************/
$inst_dir = dirname(__FILE__);
$wrm_dir = substr($inst_dir, 0, strlen($inst_dir)-8); //Strip the "install" directory off the end.
define('SMARTY_DIR', $wrm_dir .'/includes/smarty/libs/');
require(SMARTY_DIR . 'Smarty.class.php');

$smarty = new Smarty();
$smarty->template_dir = $inst_dir . '/templates/';
$smarty->compile_dir  = $inst_dir . '/cache/templates_c';
$smarty->config_dir   = $wrm_dir . '/includes/smarty/configs/';
$smarty->cache_dir    = $inst_dir . '/cache/smarty_cache';
// Turning on Caching will cause many pages not to display dynamic changes properly.
$smarty->caching = false;
$smarty->compile_check = true;
/* Turn on/off Smarty Template Debugging by commenting/uncommenting the lines below. */
$smarty->debugging = false;
//$smarty->debugging = true;


///Load Smarty Library
///define('SMARTY_DIR', dirname(__FILE__).'../includes/smarty/libs/');
//define('SMARTY_DIR', '../includes/smarty/libs/');
//include_once('../includes/smarty/libs/Smarty.class.php');
//
//$smarty = new Smarty();
/// Turning on Caching will cause many pages not to display dynamic changes properly.
//$smarty->caching = false;
//$smarty->compile_check = true;

/* Turn on/off Smarty Template Debugging by commenting/uncommenting the lines below. */
//$smarty->debugging = false;
///$smarty->debugging = true;

//$smarty->template_dir = 'templates';
//$smarty->compile_dir = '../cache/templates_c';
//$smarty->config_dir = '../includes/smarty/configs/';
//$smarty->cache_dir = '../cache/smarty_cache';


/*
 * set Lang. Format (default english)
 */
if (!isset($_GET['lang']))
	$lang = "english";
else
	$lang = $_GET['lang'];
include_once('language/locale-'.$lang.'.php');


/*
 * include default libs
 */
include_once ("includes/db/db.php");
include_once ("includes/function.php");

?>