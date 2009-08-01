<?php
/**********************************************************
 * Load Template System Here (Smarty/phpLib)
 **********************************************************/

//Load Smarty Library
define('SMARTY_DIR', dirname(__FILE__).'/smarty/libs/');
include_once('smarty/libs/Smarty.class.php');

$smarty = new Smarty();
// Turning on Caching will cause many pages not to display dynamic changes properly.
$smarty->caching = false;
$smarty->compile_check = true;

/* Turn on/off Smarty Template Debugging by commenting/uncommenting the lines below. */
$smarty->debugging = false;
//$smarty->debugging = true;

$smarty->template_dir = 'templates';
$smarty->compile_dir = 'cache/templates_c';
$smarty->config_dir = 'includes/smarty/configs/';
$smarty->cache_dir = 'cache/smarty_cache';

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