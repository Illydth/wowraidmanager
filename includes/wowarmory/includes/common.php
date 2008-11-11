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

// FIX FOR OPEN BASEDIR ISSUES.
// No Win here, some people aren't allowed to include files not listed in the include list, 
//     others aren't able to modify their ini variables with INI set.  End result?  Someone
//     blows up on this code.
// Setup Include Directories to get around open_basedir problems.
//     - COMMNET THIS OUT IF YOU HAVE ISSUES WITH INI_SET ON YOUR HOST.
$include_list .= "./";
$include_list .= ":./includes/";
$include_list .= ":./stats_conf/";
$include_list .= ":./template/css/";
$include_list .= ":./languages/";
$include_list .= ":" . ini_get('include_path');
ini_set('include_path',  $include_list);

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
