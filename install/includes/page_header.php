<?php
/***************************************************************************
 *                             page_header.php
 *                            -------------------
 *   begin                : Dec 12, 2008
 *	 Dev                  : Carsten Hölbing
 *	 email                : carsten@hoelbing.net
 *
 *   -- WoW Raid Manager --
 *   copyright            : (C) 2007-2009 Douglas Wagner
 *   email                : douglasw0@yahoo.com
 *   www				  : http://www.wowraidmanager.net
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

/**********************************************************
 * Load Template System Here (Smarty/phpLib)
 **********************************************************/

//Load Smarty Library
//define('SMARTY_DIR', dirname(__FILE__).'../includes/smarty/libs/');
define('SMARTY_DIR', '../includes/smarty/libs/');
include_once('../includes/smarty/libs/Smarty.class.php');

$smarty = new Smarty();
// Turning on Caching will cause many pages not to display dynamic changes properly.
$smarty->caching = false;
$smarty->compile_check = true;

/* Turn on/off Smarty Template Debugging by commenting/uncommenting the lines below. */
$smarty->debugging = false;
//$smarty->debugging = true;

$smarty->template_dir = 'templates';
$smarty->compile_dir = '../cache/templates_c';
$smarty->config_dir = '../includes/smarty/configs/';
$smarty->cache_dir = '../cache/smarty_cache';

// Set Page content type header:
header('Content-Type: text/html; charset=utf-8');

include_once('language/locale-'.$lang.'.php');

$smarty->assign(
	array(
		"headtitle" =>  $wrm_install_lang['headtitle'],
		"install_title" =>  $wrm_install_lang['headtitle'],
	)
);

$smarty->display('header.tpl.html');
?>