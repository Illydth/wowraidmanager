<?
/*
* Armory World of Warcraft Items Tooltip
*
* Thiago Melo <ReiserFS>
* thiago@oxente.org
* http://thiago.oxente.org
* http://killermokeys.net
*
* BASE MOD Info and Download: http://www.phpbb.com/community/viewtopic.php?f=70&t=576155
*
*/

//Disable notice reporting
@error_reporting(E_ALL ^ E_NOTICE);
// ini_set('display_errors',1);

// Include the Php Armory Class
require_once("includes/phpArmory.class.php");
//require_once("includes/phpArmoryCache.class.php");
require_once("includes/template.class.php");

// Create a new Armory Object
$armory = new phpArmory();

// Select the lang file
include("languages/lang_en.php");

// Set template
$conf_template = 'default';

?>
