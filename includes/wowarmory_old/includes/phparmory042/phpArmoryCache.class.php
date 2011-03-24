<?php
/**
 * phpArmory is an embeddable class to retrieve XML data from the WoW armory.
 *
 * phpArmory is an embeddable PHP5 class, which allow you to fetch XML data
 * from the World of Warcraft armory in order to display arena teams,
 * characters, guilds, and items on a web page.
 * @author Daniel S. Reichenbach <daniel.s.reichenbach@mac.com>
 * @copyright Copyright (c) 2008, Daniel S. Reichenbach
 * @license http://www.opensource.org/licenses/gpl-3.0.html GNU General Public License version 3
 * @link https://github.com/marenkay/phparmory/tree
 * @package phpArmory
 * @version 0.4.2
 */

/**
 * phpArmory5Cache extends phpArmory5, thus we require the base class file.
 */
require_once('phpArmory.class.php');

/**
 * phpArmory5Cache class
 *
 * A class to fetch and cache unserialized XML data from the World of Warcraft
 * armory site.
 * @package phpArmory
 * @subpackage classes
 */
class phpArmory5Cache extends phpArmory5 {

    /**
     * Current version of the phpArmory5Cache class.
     * @access      protected
     * @var         string      Contains the current class version.
     */
    protected $version = "0.4.2";

    /**
     * Current state of the phpArmory5Cache class. Allowed values are alpha, beta,
     * and release.
     * @access      protected
     * @var         string      Contains the current versions' state.
     */
    protected $version_state = "release";

    /**
     * The current cache ID in use.
     * @access      protected
     * @var         string      Contains the cache ID.
     */
    protected $cacheID = "";

    /**
     * Selected data storage for the class. Can be "file" or "mysql".
     * @access      protected
     * @var         string      Contains the selected data storage.
     */
    protected $dataStore = "file";

    /**
     * The path to the cache directory (must chmod 777 to make it writeable).
     * @access      protected
     * @var         string      Contains the path where to store cache files.
     */
    protected $dataPath = "./cache";

    /**
     * MySQL connection string.
     * @access      protected
     * @var         string      Contains the MySQL connection string.
     */
    protected $mysqlString = "mysql://username:password@host/database";
    /**
     * MySQL cache table.
     * @access      protected
     * @var         string      Contains the MySQL cache table.
     */
    protected $mysqlTable = "armory_cache";

    /**
     * The time between cache updates in seconds
     * @access      protected
     * @var         integer     Contains the time delay between updates in seconds. Default is 4 hours.
     */
    protected $updateInterval = 14400;

    /**
     * phpArmory5Cache class constructor.
     * @access      public
     * @param       string      $areaName
     * @param       string      $dataStore
     * @param       string      $mysqlString
     * @param       string      $mysqlTable
     * @param       int         $downloadRetries
     * @return      mixed       $result                 Returns TRUE if the class could be instantiated properly. Returns FALSE and an error string, if the class could not be instantiated.
     */
    public function __construct($areaName = NULL, $dataStore = NULL, $dataPath = NULL, $mysqlString = NULL, $downloadRetries = NULL) {

        parent::__construct($areaName, $downloadRetries);

        if(($dataStore==NULL)&&($this->dataStore)){
            $dataStore = $this->dataStore;
        } else {
            $this->dataStore = $dataStore;
        }

        if(($mysqlString==NULL)&&($this->mysqlString)){
            $mysqlString = $this->mysqlString;
        } else {
            $this->mysqlString = $mysqlString;
        }

        if(($mysqlTable==NULL)&&($this->mysqlTable)){
            $mysqlTable = $this->mysqlTable;
        } else {
            $this->mysqlTable = $mysqlTable;
        }

        switch($this->dataStore) {

            case 'file':
                if(($dataPath==NULL)&&($this->dataPath)){
                    $dataPath = $this->dataPath;
                } else {
                    $this->dataPath = $dataPath;
                }
                break;
            case 'mysql':
                if (!extension_loaded('mysql') || !extension_loaded('mysqli')) {
                    self::triggerError("Either PHP extension \"mysql\" or \"mysqli\" extension is required to use this class.");
                } else {
                    if(($dataPath==NULL)&&($this->mysqlTable)){
                        $dataPath = $this->mysqlTable;
                    } else {
                        $this->mysqlTable = $dataPath;
                    }
                    $conn = @parse_url($this->mysqlString);
                    $this->mysqlString = mysql_connect($conn['host'], $conn['user'], $conn['pass']) or die("Failed to connect to database");
                    mysql_select_db(str_replace('/', '', $conn['path']), $this->mysqlString) or die("Unable to select database table");
                    $query = "CREATE TABLE IF NOT EXISTS `".$this->mysqlTable."` (
                    `cache_id` VARCHAR(100) NOT NULL DEFAULT '',
                    `cache_time` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
                    `cache_xml` TEXT,
                    PRIMARY KEY `cache_id` (`cache_id`))";
                    mysql_query($query, $this->mysqlString) or self::triggerError("Unable to create the cache table");
                }
                break;
            default:
                die("Invalid dataStore defined.");
                break;

        }

        parent::setArea($areaName);

    }

    /**
     * Raise a PHP error.
     * @access      protected
     * @param       string       $userError              The error string to output.
     */
    protected function triggerError ($userError = NULL) {
        if (is_string($userError)) {
            trigger_error("phpArmoryCache " . $this->version . " - " . $this->version_state . ": " . $userError, E_USER_ERROR);
        }
    }

    /**
     * Raise a PHP warning if the class is used from the command line.
     * @access      protected
     * @param       string       $userWarning            The warning string to output.
     */
    protected function triggerWarning ($userWarning = NULL) {
        if (is_string($userWarning)) {
            $sapi_type = substr(php_sapi_name(), 0, 3);
            if ($sapi_type == 'cli') {
                trigger_error("phpArmoryCache " . $this->version . " - " . $this->version_state . ": " . $userWarning, E_USER_WARNING);
            }
        }
    }

    /**
     * Raise a PHP notice if the class is used from the command line.
     * @access      protected
     * @param       string       $userNotice             The notice string to output.
     */
    protected function triggerNotice ($userNotice = NULL) {
        if (is_string($userNotice)) {
            $sapi_type = substr(php_sapi_name(), 0, 3);
            if ($sapi_type == 'cli') {
                trigger_error("phpArmoryCache " . $this->version . " - " . $this->version_state . ": " . $userNotice, E_USER_NOTICE);
            }
        }
    }

    /**
     * Retrieve cached data.
     * @access      public
     * @param       string      $cacheID                The unique ID of the retrieved data.
     * @return      mixed       $result                 Returns a string containg the cached XML data, or FALSE if there is no cached data.
     */
    public function getCachedData($cacheID) {

        switch($this->dataStore) {

            case "file":
                $filename = $this->dataPath."/".$cacheID;
                if (file_exists($filename)) {
                    if (time()-filemtime($filename) > $this->updateInterval) {
                        // Cache is out of date, remove the old file
                        self::triggerNotice("Cached file data for " . $cacheID . " is outdated.");
                        @unlink($filename);
                    } else {
                        // Return the cached XML as an array
                        $array = unserialize(file_get_contents($filename));
                        self::triggerNotice("Cached file data for " . $cacheID . " is valid.");
                        return $array;
                    }
                }
                break;
            case "mysql":
                $query = "SELECT cache_xml, UNIX_TIMESTAMP(cache_time) AS cache_time FROM `".$this->mysqlTable."` WHERE cache_id = '".$cacheID."'";
                $result = mysql_query($query, $this->mysqlString) or self::triggerError("Unable to select cache from database");
                if ($result && mysql_num_rows($result)) {
                    if (time()-mysql_result($result, 0, 'cache_time') > $this->updateInterval) {
                        $query = "DELETE FROM `".$this->mysqlTable."` WHERE cache_id = '".$cacheID."'";
                        mysql_query($query, $this->mysqlString);
                        self::triggerNotice("Cached mysql data for " . $cacheID . " is outdated.");
                    } else {
                        // Return the cached XML as an array
                        self::triggerNotice("Cached mysql data for " . $cacheID . " is valid.");
                        return parent::convertXmlToArray(mysql_result($result, 0, 'cache_xml'));
                    }
                }
                break;

        }

    }

    /**
     * Saved retrieved data to cache.
     * @access      public
     * @param       string      $cacheID                The unique ID of the retrieved data.
     * @param       string      $xml                    The retrieved XML data to store.
     * @return      bool        $result                 Returns TRUE if $xml could be cached, and FALSE if it failed to be saved.
     */
    public function setCachedData($cacheID, $xml) {

        switch($this->dataStore){

            case "file":
                $filename = $this->dataPath."/".$cacheID;
                $handle = fopen($filename, 'w') or self::triggerError("Can not open file (" . $filename . ")");
                fwrite($handle, $xml) or self::triggerError("Can not write to file (" . $filename . ")");
                self::triggerNotice("Successfully cached " . $cacheID . " in file mode.");
                fclose($handle);
                break;

            case "mysql":
                if (get_magic_quotes_gpc()) $xml = stripslashes($xml);
                $xml = mysql_escape_string($xml);
                $query = "REPLACE INTO `".$this->mysqlTable."` (cache_id, cache_xml) VALUES('".$cacheID."','".$xml."')";
                mysql_query($query, $this->mysqlString) or self::triggerError("Unable to save to database " . mysql_error());
                self::triggerNotice("Successfully cached " . $cacheID . " in mysql mode.");
                break;

        }

    }

    /**
     * Provides information on a specific arena team.
     * @access      public
     * @param       string      $arenaName              The arena teams' name.
     * @param       string      $realmName              The arena teams' realm name.
     * @return      array       $result                 Returns an array containing arenaTeamData if $arenaTeamName and $realmName are valid, otherwise FALSE.
     */
    public function getArenaTeamData($arenaTeamName = NULL, $realmName = NULL) {

        $this->cacheID = "a".md5($arenaTeamName.$realmName);
        $cached = $this->getCachedData($this->cacheID);

        if (!is_array($cached)) {
            $cached = parent::getArenaTeamData($arenaTeamName, $realmName);

            if ( $this->cacheID && is_array($cached) ) {

                $scached = serialize($cached);
                $this->setCachedData($this->cacheID, $scached);
                unset($this->cacheID);

            } else {
                return FALSE;
            }

            return $cached;

        } else {
            return $cached;
        }

    }

    /**
     * Provides information on a specific character.
     * @access      public
     * @param       string      $characterName          The characters' name.
     * @param       string      $realmName              The characters' realm name.
     * @param       bool        $onlyBasicData          If true, only the basic character data will be fetched.
     * @return      array       $result                 Returns an array containing characterData if $characterName and $realmName are valid, otherwise FALSE.
     */
    public function getCharacterData($characterName = NULL, $realmName = NULL, $onlyBasicData = false) {

        $this->cacheID = "c".md5($characterName.$realmName);
        $cached = $this->getCachedData($this->cacheID);

        if (!is_array($cached)) {
            $cached = parent::getCharacterData($characterName, $realmName, $onlyBasicData);

            if ( $this->cacheID && is_array($cached) ) {

                $scached = serialize($cached);
                $this->setCachedData($this->cacheID, $scached);
                unset($this->cacheID);

            } else {
                return FALSE;
            }

            return $cached;

        } else {
            return $cached;
        }

    }

    /**
     * Provides information on a specific guild.
     * @access      public
     * @param       string      $guildName              The guilds' name.
     * @param       string      $realmName              The guilds' realm name.
     * @return      array       $result                 Returns an array containing guildData if $guildName and $realmName are valid, otherwise FALSE.
     */
    public function getGuildData($guildName = NULL, $realmName = NULL) {

        $this->cacheID = "g".md5($guildName.$realmName);
        $cached = $this->getCachedData($this->cacheID);

        if (!is_array($cached)) {
            $cached = parent::getGuildData($guildName, $realmName);

            if ( $this->cacheID && is_array($cached) ) {

                $scached = serialize($cached);
                $this->setCachedData($this->cacheID, $scached);
                unset($this->cacheID);

            } else {
                return FALSE;
            }

            return $cached;
        } else {
            return $cached;
        }

    }
    /**
     * Provides information on a specific item by querying its' ID.
     * @access      public
     * @param       int         $itemID                 The items' ID.
     * @return      array       $result                 Returns an array containing itemData if $itemID is valid, otherwise FALSE.
     */
    public function getItemData($itemID) {

        $this->cacheID = "i".md5($itemID);
        $cached = $this->getCachedData($this->cacheID);

        if (!is_array($cached)) {
            $cached = parent::getItemData($itemID);

            if ( $this->cacheID && is_array($cached) ) {

                $scached = serialize($cached);
                $this->setCachedData($this->cacheID, $scached);
                unset($this->cacheID);

            } else {
                return FALSE;
            }

            return $cached;
        } else {
            return $cached;
        }

    }

    /**
     * Provides information on a specific item by querying its' name.
     * @access      public
     * @param       string      $itemName               The items' name.
     * @param       string      $itemFilter             An associative array of search paramters.
     * @return      mixed       $result                 Returns an array containing itemData if $itemName is valid, otherwise FALSE.
     */
    public function getItemDataByName($itemName, $itemFilter = NULL) {

        if ($filter&&is_array($filter)) {
            $this->cacheID = "s".md5($itemName.implode('', $filter));
        } else {
            $this->cacheID = "s".md5($itemName);
        }

        $cached = $this->getCachedData($this->cacheID);

        if (!is_array($cached)) {
            $cached = parent::getItemDataByName($itemName, $itemFilter);

            if ( $this->cacheID && is_array($cached) ) {

                $scached = serialize($cached);
                $this->setCachedData($this->cacheID, $scached);
                unset($this->cacheID);

            } else {
                return FALSE;
            }

            return $cached;
        } else {
            return $cached;
        }

    }

}
?>
