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

require_once('../../config.php');

$mysqlString = "mysql://" . $phpraid_config['db_user'] . ":" . $phpraid_config['db_pass'] . "@" . $phpraid_config['db_host'] . "/" . $phpraid_config['db_name'];
$conn = @parse_url($mysqlString);
$dbconnection = mysql_connect($conn['host'], $conn['user'], $conn['pass']) or die("Failed to connect to database");
mysql_select_db(str_replace('/', '', $conn['path']), $dbconnection) or die("Unable to select database table");
$query = "SELECT config_value FROM " . $phpraid_config['db_prefix'] . "config WHERE config_name = 'armory_cache_setting'";
$result = mysql_query($query, $dbconnection) or die("Unable to select from config table.");
$sqlresultdata = mysql_fetch_assoc($result);
$armory_cache_setting = $sqlresultdata['config_value'];
$query = "SELECT config_value FROM " . $phpraid_config['db_prefix'] . "config WHERE config_name = 'armory_language'";
$result = mysql_query($query, $dbconnection) or die("Unable to select from config table.");
$sqlresultdata = mysql_fetch_assoc($result);
$locale = $sqlresultdata['config_value'];

echo "Armory Locale = " . $locale;
echo "<br>Armory Cache Setting = " . $armory_cache_setting;

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
//require_once("includes/phparmory042/phpArmory.class.php");
require_once("includes/phparmory042/phpArmoryCache.class.php");
require_once("includes/template.class.php");

// Create a new Armory Object
$armver = '042';
// Setup Cache Selection.  Valid Values: database, file, none.
if ($armory_cache_setting == 'database')
{
	if ( ! $armory = new phpArmory5Cache($areaName = $locale, 
									$dataStore = "mysql", 
									$dataPath = $phpraid_config['db_prefix'] . "armory_cache", 
									$mysqlString = "mysql://" . $phpraid_config['db_user'] . ":" . $phpraid_config['db_pass'] . "@" . $phpraid_config['db_host'] . "/" . $phpraid_config['db_name']) )
		echo "Could not create an instance of phpArmory5. Please consult your PHP5 logs.\n";
}
elseif ($armory_cache_setting == 'file')
{
	if ( ! $armory = new phpArmory5Cache($areaName = $locale, 
									$dataStore = "file", 
									$dataPath = "../../cache/armory_cache") ) 
		echo "Could not create an instance of phpArmory5. Please consult your PHP5 logs.\n";
}
else
{									
	if ( ! $armory = new phpArmory5($areaName = $locale) )
	    echo "Could not create an instance of phpArmory5. Please consult your PHP5 logs.\n";
}
   
// Select the lang file
include("languages/lang_en.php");

// Set template
$conf_template = 'default';

?>
