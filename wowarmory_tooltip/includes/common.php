<?
/*
* Armory World of Warcraft Items Tooltip
*
* Thiago Melo <ReiserFS>
* thiago@oxente.org
* http://thiago.oxente.org
* http://killermokeys.net
*
* MOD Info and Download: http://www.phpbb.com/community/viewtopic.php?f=70&t=576155
*
* Use: [wow]Warcraft Item Name[/wow]
*
* Edit $armory->setlang('en'); to change the language (en/de/es/fr/uk)
*
*/

//Disable notice reporting
@error_reporting(E_ALL ^ E_NOTICE);
// ini_set('display_errors',1);

// Include the Php Armory Class
require_once("includes/phpArmory.class.php");
require_once("includes/template.class.php");

// Get the URL GET And decode
$var = urldecode($_GET['v']);

// Create a new Armory Object
$armory = new phpArmory();

// Set language en/de/es/fr/uk (uk for eu.armory)
$armory->setlang('en');

// Select the lang file
include("languages/lang_en.php");

// Set template
$conf_template = 'default';

?>
