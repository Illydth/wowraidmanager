<?php 
// commons
define("IN_PHPRAID", true);
require_once('./common.php');

// page authentication
if($phpraid_config['anon_view'] == 1)
	define("PAGE_LVL","anonymous");
else
	define("PAGE_LVL","profile");
	
require_once("includes/authentication.php");

$smarty->assign('name','Doug2');
$smarty->display('smartytest.html');

?>