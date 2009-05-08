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
 * phpArmory5 class
 *
 * A class to fetch and unserialize XML data from the World of Warcraft armory
 * site.
 * @package phpArmory
 * @subpackage classes
 */
class phpArmory5 {

    /**
     * Current version of the phpArmory5 class.
     * @access      protected
     * @var         string      Contains the current class version.
     */
    protected $version = "0.4.2";

    /**
     * Current state of the phpArmory5 class. Allowed values are alpha, beta,
     * and release.
     * @access      protected
     * @var         string      Contains the current versions' state.
     */
    protected $version_state = "release";

    /**
     * The URL of the World of Warcraft armory website to be used.
     * @access      protected
     * @var         string      Contains the URL of the armory website.
     */
    protected $armory = "http://www.wowarmory.com/";

    /**
     * The URL of the World of Warcraft website to be used.
     * @access      protected
     * @var         string      Contains the URL of the World of Warcraft website.
     */
    protected $wow = "http://www.worldofwarcraft.com/";

    /**
     * The armory area to send requests to.
     * @access      protected
     * @var         string      Contains the area / region to be used.
     */
    protected $areaName = "us";

    /**
     * The locale used to send requests.
     * @access      protected
     * @var         string      Contains the locale used to send requests.
     */
    protected $localeName = "en";

    /**
     * The case sensitive name of a realm.
     * @access      private
     * @var         string      Contains the case sensitive name of a realm.
     */
    private $realmName = "";

    /**
     * The case sensitive name of a arena team.
     * @access      protected
     * @var         string      Contains the case sensitive name of a arena team.
     */
    private $arenaTeam = "";

    /**
     * The case sensitive name of a guild.
     * @access      private
     * @var         string      Contains the case sensitive name of a guild.
     */
    private $guildName = "";

    /**
     * The case sensitive name of a character.
     * @access      private
     * @var         string      Contains the case sensitive name of a character.
     */
    private $characterName = "";

    /**
     * The default user agent for making HTTP requests.
     * @access      protected
     * @var         string      Contains the user agent string used to query the armory.
     */
    protected $userAgent = "Mozilla/5.0 (Windows; U; Windows NT 5.1; de; rv:1.8.1.11) Gecko/20071127 Firefox/2.0.0.11";

    /**
     * The amount of time in seconds after which to consider a connection timed
     * out if no data has been yet retrieved.
     * received.
     * @access      protected
     * @var         integer     Contains the nr# of seconds to wait between connection tries.
     */
    protected $timeOut = 5;

    /**
     * Time of last download, used to insert a random delay to prevent armorys'
     * weird behaviour.
     * @access      private
     * @var         integer     Contains the time passed since last download.
     */
    protected $lastDownload = 0;

    /**
     * Number of retries for downloading data.
     * @access      private
     * @var         integer     Contains the nr# of retries to perform in case of connection failures.
     */
    protected $downloadRetries = 5;

    /**
     * phpArmory5 class constructor.
     * @access      public
     * @param       string      $areaName
     * @param       int         $downloadRetries
     * @return      mixed       $result                 Returns TRUE if the class could be instantiated properly. Returns FALSE and an error string, if the class could not be instantiated.
     */
    public function __construct($areaName = NULL, $downloadRetries = NULL) {

        if (!extension_loaded('curl') || !extension_loaded('xml')) {
            self::triggerError("The PHP extensions \"curl\" and \"xml\" are required to use this class.");
        } else {

            // If an area is provided, we will configure armory site, wow site, and language appropriately.
            if ($areaName) {
                self::setArea($areaName);
            }

            // If we received a limit for download retries, we will use it.
            if ($downloadRetries) {
                $this->downloadRetries = $downloadRetries;
            }

            // The class is now properly configured.
            return TRUE;
        }
    }

    /**
     * Provides information on the current area configuration of phpArmory.
     * @access      public
     * @return      array       $areaSettings           Returns an array with $this->areaName, $this->armory, and $this->wow.
     */
    public function getArea() {
        return array ( $this->areaName, $this->armory, $this->wow );
    }

    /**
     * Configure the area in which phpArmory should operate.
     * @access      protected
     * @param       string      $areaName               The area phpArmory should operate in.
     * @return      bool        $result                 Returns TRUE if $areaName was set.
     */
    public function setArea($areaName) {
        switch($areaName) {
            case 'eu':
                $this->areaName 	= 'eu';
                $this->armory   	= 'http://eu.wowarmory.com/';
                $this->wow      	= 'http://www.wow-europe.com/';
                $this->localeName 	= 'en';
                break;
            case 'us':
                $this->areaName 	= 'us';
                $this->armory   	= 'http://www.wowarmory.com/';
                $this->wow      	= 'http://www.worldofwarcraft.com/';
                $this->localeName 	= 'en';
                break;
            case 'kr':
                $this->areaName 	= 'us';
                $this->armory   	= 'http://kr.wowarmory.com/';
                $this->wow      	= 'http://www.worldofwarcraft.co.kr';
                $this->localeName 	= 'en';
                break;
            case 'tw':
                $this->areaName 	= 'us';
                $this->armory   	= 'http://tw.wowarmory.com/';
                $this->wow      	= 'http://www.wowtaiwan.com.tw/';
                $this->localeName 	= 'en';
                break;
			default:
                $this->areaName 	= 'us';
                $this->armory   	= 'http://www.wowarmory.com/';
                $this->wow      	= 'http://www.worldofwarcraft.com/';
                $this->localeName 	= 'en';
            	break;
        }

        self::triggerNotice("Area now is [" . $this->areaName . "].");
        self::triggerNotice("Armory now is [" . $this->armory . "].");
        self::triggerNotice("Wow site now is [" . $this->wow . "].");

        return TRUE;
    }

    /**
     * Provides information on the current locale in which phpArmory returns data.
     * @access      public
     * @return      string      $localeName             Returns the current locales' name.
     */
    public function getLocale() {
        return $this->localeName;
    }

    /**
     * Configure the locale in which phpArmory should query the armory.
     * @access      protected
     * @param       string      $localeName             The locale to query data in.
     * @return      bool        $result                 Returns TRUE if $localeName was set.
     */
    public function setLocale($localeName) {

        if ($this->areaName == 'us') {
            if ($localeName == 'en') {
                $this->localeName = $localeName;
            } else {
                $this->localeName = 'en';
            }
        } elseif ($this->areaName == 'eu') {
            if ($localeName == 'de' | $localeName == 'en' | $localeName == 'es' | $localeName == 'fr' ) {
                $this->localeName = $localeName;
            } else {
                $this->localeName = 'en';
            }
        } else {
                $this->localeName = 'en';
        }

        self::triggerNotice("Locale now is [" . $this->localeName . "].");

        return TRUE;
    }

    /**
     *
     * @access      protected
     * @param       string      $url                    URL of the page to fetch data from.
     * @param       string      $userAgent              The user agent making the GET request.
     * @param       integer     $timeout                The connection timeout in seconds.
     * @return      array       $result                 Returns TRUE if $url is valid, and could be fetched. Returns FALSE and an error string, if $url is not valid.
     */
    protected function getXmlData($url, $userAgent = NULL, $timeOut = NULL) {

    	// @@ DWAGNER - Changes to Function @@
    	
        // If no user agent is defined, use our pre-defined userAgent from the class definition.
        if ( ($userAgent == NULL) && ($this->userAgent)) {
            $userAgent = $this->userAgent;
        }

        // If no timeout is defined, use our pre-defined timeout from the class definition.
        if ( ($timeOut == NULL) && ($this->timeOut)) {
            $timeout = $this->timeOut;
        }

        // @@ Change: Get the specific page data from the URL and use that to open error
        //    and output files.
		if (strpos($url,$this->wow) === FALSE)
		{
			// Getting Character information
			$matches = array();
			preg_match('"(.*)/(.*).xml(.*)"', $url, $matches);
			$output_data = $matches[2];
			$ext = ".xml";
		}
		else
		{
			// Getting Patch Notes
			$output_data = "patch_notes";
			$ext = ".html";
		}
        // Open an error log to write to for information.
        $stderrfptr = fopen(getcwd() . "../../../cache/armory_log/" . $output_data . "_stderr.log", "w+");
        
        // Try to download from the given URL for a maximum of our pre-defined download retries from the class definition.
        for ( $i = 1; $i <= $this->downloadRetries; $i++ ) {

            if (time() < $this->lastDownload+1) {

                $delay = rand (1,2);
                self::triggerNotice("Inserting fetch delay of " . $delay . " seconds.");
                sleep($delay);    //random delay

            } // if

            self::triggerNotice("Fetching [" . $url . "] (tries: #" . $i . ").");
            $ch = curl_init();
            $timeout = $this->timeOut;

            curl_setopt ( $ch, CURLOPT_URL, $url );
            curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
            curl_setopt ( $ch, CURLOPT_CONNECTTIMEOUT, $timeout );
            curl_setopt ( $ch, CURLOPT_USERAGENT, $userAgent );
            curl_setopt ( $ch, CURLOPT_HTTPHEADER, array('Accept-language: ' . $this->localeName) );
            curl_setopt ( $ch, CURLOPT_HEADER, 0 );
            curl_setopt ( $ch, CURLOPT_FOLLOWLOCATION, 0 );
			curl_setopt ( $ch, CURLOPT_VERBOSE, 1);
            curl_setopt ( $ch, CURLOPT_STDERR, $stderrfptr);
            curl_setopt ( $ch, CURLOPT_FORBID_REUSE, 1 );
            curl_setopt ( $ch, CURLOPT_LOW_SPEED_LIMIT, 5 );
            curl_setopt ( $ch, CURLOPT_LOW_SPEED_TIME, $timeout );
            curl_setopt ( $ch, CURLOPT_TIMEVALUE, $timeout*3 );            
            
            $f = curl_exec ( $ch );
            $this->lastDownload = time();

            // Disabled reporting of the fetched content in error logs. This may spam your host. Only uncomment this line if you are working on localhost aka 127.0.0.1.
            //trigger_error("phpArmory " . $this->version . " - " . $this->version_state . ": Fetched content: " . $f, E_USER_NOTICE);
			
            // Turn on to output raw XML armory data to file on disk.
        	$stdoutfptr = fopen(getcwd() . "../../../cache/armory_log/" . $output_data . "_data" . $ext, "w+");
            fwrite($stdoutfptr, $f);
            fclose($stdoutfptr);
            
            curl_close($ch);

            if ( strpos ( $f, 'errCode="noCharacter"' ) ) return ( array ( 'result' => FALSE, 'error' => "Character not found on armory, check spelling and area settings!") );

            if ( strpos ( $f, 'errorhtml' ) AND $i <= $this->downloadRetries-1 ) return ( array( 'result' => FALSE, 'error' => "Armory send an error page, retrying...") );
            else {
                if ( strlen ( $f ) AND $i <= $this->downloadRetries-1 ) break;
                    else return ( array ('result' => FALSE, 'error' => "No data, retrying...") );
            }

        } // for
        fclose($stderrfptr);
        
        if ( strlen ( $f ) < 100 ) {
            return ( array( 'result' => FALSE, 'error' => "Download failed, giving up! Server response: " . $f) );
        }

        self::triggerNotice("Fetched [" . $url . "] in " . $i . " tries.");
        return array ( 'result' => TRUE, 'XmlData' => $f);
    }

    /**
     * Converts an XML string into an associative array, duplicating the XML structure.
     * @access      protected
     * @param       string      $xmlData                The XML data string to convert.
     * @param       bool        $includeTopTag          Whether or not the topmost XML tag should be included in the array. The default value for this is FALSE.
     * @param       bool        $lowerCaseTags          Whether or not tags should be set to lower case. Default value for this parameter is TRUE.
     * @return      array       $result                 An associative array duplicating the XML structure.
     */
    protected function & convertXmlToArray($xmlData, $includeTopTag = FALSE, $lowerCaseTags = TRUE) {

        $xmlArray = array();

        $parser = xml_parser_create();
        xml_parse_into_struct($parser, $xmlData, $vals, $index);
        xml_parser_free($parser);

        $temp = $depth = array();

        foreach ($vals as $value) {

            switch ($value['type']) {

                case 'open':
                case 'complete':
                    array_push($depth, $value['tag']);
                    $p = join('::', $depth);
                    if ($lowerCaseTags) {

                        $p = strtolower($p);
                        if (is_array($value['attributes']))
                            $value['attributes'] = array_change_key_case($value['attributes']);

                    }

                    $data = ( $value['attributes'] ? array($value['attributes']) : array());
                    $data = ( trim($value['value']) ? array_merge($data, array($value['value'])) : $data);

                    if ($temp[$p]) {

                        $temp[$p] = array_merge($temp[$p], $data);

                    } else {

                        $temp[$p] = $data;

                    }

                    if ($value['type']=='complete') {

                        array_pop($depth);

                    }
                    break;

                case 'close':
                    array_pop($depth);
                break;

            }  // switch

        } // foreach

        if (!$includeTopTag) {

            unset($temp["page"]);

        }

        foreach ($temp as $key => $value) {

            if (count($value)==1) {

                $value = reset($value);

            }

            $levels = explode('::', $key);
            $num_levels = count($levels);

            if ($num_levels==1) {

                $xmlArray[$levels[0]] = $value;

            } else {

                $pointer = &$xmlArray;
                for ($i=0; $i<$num_levels; $i++) {

                    if ( !isset( $pointer[$levels[$i]] ) ) {

                        $pointer[$levels[$i]] = array();

                    }

                $pointer = &$pointer[$levels[$i]];

                } // for

            $pointer = $value;

            } // if

        } // foreach

        return ($includeTopTag ? $xmlArray : reset($xmlArray));

    }

    /**
     * Raise a PHP error.
     * @access      protected
     * @param       string       $userError              The error string to output.
     */
    protected function triggerError ($userError = NULL) {
        if (is_string($userError)) {
            trigger_error("phpArmory " . $this->version . " - " . $this->version_state . ": " . $userError, E_USER_ERROR);
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
                trigger_error("phpArmory " . $this->version . " - " . $this->version_state . ": " . $userWarning, E_USER_WARNING);
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
                trigger_error("phpArmory " . $this->version . " - " . $this->version_state . ": " . $userNotice, E_USER_NOTICE);
            }
        }
    }

    /**
     * Provides information on the current patch level of World of Warcraft.
     * @access      public
     * @return      string       $patchLevel             Returns a string with int $patchLevelMajor, int $patchLevelMinor, and int $patchLevelFix.
     */
    public function getPatchLevel() {
        $major = 0;
        $minor = 0;
        $patch = 0;

        if ($this->areaName == 'eu') {
            $patchnotes = $this->getXmlData ( $this->wow . "en/patchnotes/", NULL, 5);

            if (is_array($patchnotes) && array_key_exists ('XmlData' , $patchnotes)) {
                // Current patch header = <h3 class="blood">Patch 2.4.3</h3>
                if ( !preg_match( '@<h3 .+>Patch ([0-9\.]+)</h3>@', $patchnotes['XmlData'], $matches ) ) return sprintf ( "%02d%02d%02d", $major, $minor, $patch );
            }
        } elseif ($this->areaName == 'us') {
            $patchnotes = $this->getXmlData($this->wow."patchnotes/",NULL,5);

            if (is_array($patchnotes) && array_key_exists ('XmlData' , $patchnotes)) {
                // Current patch header = <b>World of Warcraft Client Patch 2.4.3 (2008-07-15)</b>
                if ( !preg_match( '@<a href="/patchnotes/">Patch ([0-9\.]+)</a>@', $patchnotes['XmlData'], $matches ) ) return sprintf ( "%02d%02d%02d", $major, $minor, $patch );
            }
        }

        list ( $major, $minor, $patch ) = explode ( ".", $matches[1] );
        return sprintf ( "%02d%02d%02d", $major, $minor, $patch );

    }

    /**
     * Provides information on the current talent tree definitions used by all character classes World of Warcraft.
     * @access      public
     * @return      array       $result                 Returns an array containing TalentDefinitions, otherwise FALSE.
     */
    public function getTalentData() {
        $classes = array (
                            "Deathknight",
                            "Druid",
                            "Hunter",
                            "Mage",
                            "Paladin",
                            "Priest",
                            "Rogue",
                            "Shaman",
                            "Warlock",
                            "Warrior"
                        );
        foreach ( $classes as $class ) {
            $class = strtolower ( $class );
            $url = $this->wow . "shared/global/talents/".$class."/data.js";
            $result[$class] = $this->getXmlData($url);
        }

        return $result;
    }

    /**
     * Provides information on a specific arena team.
     * @access      public
     * @param       string      $arenaName              The arena teams' name.
     * @param       string      $realmName              The arena teams' realm name.
     * @return      array       $result                 Returns an array containing arenaTeamData if $arenaTeamName and $realmName are valid, otherwise FALSE.
     * @todo IMPLEMENTATION MISSING.
     */
    public function getArenaTeamData($arenaTeamName = NULL, $realmName = NULL) {

        if (is_string($arenaTeamName) && is_string($realmName)) {
            $realmName  = ucfirst($realmName);

            return TRUE;
        } else {
            return FALSE;
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

        if (is_string($characterName) && is_string($realmName)) {
            $characterName  = ucfirst($characterName);
            $realmName      = ucfirst($realmName);

            $armoryBaseURL = $this->armory."character-";
            $armoryBaseURLEnd = ".xml?r=".urlencode($realmName)."&n=".urlencode($characterName);

            $characterXML = $this->getXmlData($armoryBaseURL . "sheet" . $armoryBaseURLEnd);

            if (is_array($characterXML) && array_key_exists('XmlData', $characterXML)) {
                $characterArray = $this->convertXmlToArray($characterXML['XmlData']);

                if ($onlyBasicData) {
                    $characterPages = array("reputation", "skills", "talents", "achievements", "statistics");
                    foreach ($characterPages as $characterPage) {
                        $tempXML = $this->getXmlData($armoryBaseURL . $characterPage . $armoryBaseURLEnd);
                        if (is_array($tempXML) && array_key_exists('XmlData', $tempXML)) {
                            $tempArray = $this->convertXmlToArray($tempXML['XmlData']);

                            if ($characterPage == "achievements" || $characterPage == "statistics") {
                                // the new character pages use a different XML structure
                                $tempArray['characterinfo'][$characterPage] = $tempArray[$characterPage];
                                unset($tempArray[$characterPage]);
                            }
                            // remove character info from array
                            unset($tempArray['characterinfo']['character']);

                            // $string = print_r($tempArray, 1);
                            // $string = str_replace(array(" ", "\n"), array("&nbsp;", "<br />\n"), $string);
                            // echo "\$tempArray['".$characterPage."'] = ".$string;

                            // merge the data received from $armoryBaseURL . $characterPage . $armoryBaseURLEnd into characterArray
                            $characterArray = array_merge($characterArray, reset($tempArray));
                        } else {
                            return FALSE;
                        }
                    }
                }

                // retrieve the current patch level
                $patchlevel["armorypatchlevel"] = $this->getPatchLevel();

                // merge patch level into characterArray
                $characterArray = array_merge($characterArray, $patchlevel);

                return $characterArray;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    /**
     * Provides the link to the matching portrait icon for a charater.
     * @access      public
     * @param       array       $characterInfo          The ['characterinfo']['character'] array returned by getCharacterData.
     * @return      array       $result                 Returns an array containing characterIconURL if $characterInfo is valid, otherwise FALSE.
     */
    public function getCharacterIconURL($characterInfo) {

        if (is_array($characterInfo) && array_key_exists('level', $characterInfo) && array_key_exists('genderid', $characterInfo) && array_key_exists('raceid', $characterInfo) && array_key_exists('classid', $characterInfo)) {

            $dir = "wow" . ($characterInfo['level'] < 60 ? "-default" : ($characterInfo['level'] < 80 ? "-70" : "-80"));
            return $this->armory."images/portraits/$dir/{$characterInfo['genderid']}-{$characterInfo['raceid']}-{$characterInfo['classid']}.gif";
        } else {
            return FALSE;
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

        if (is_string($guildName) && is_string($realmName)) {
            $guildName  = ucfirst($guildName);
            $realmName  = ucfirst($realmName);

            $armoryURL = $this->armory."guild-info.xml?r=" . urlencode($realmName) . "&n=" . urlencode($guildName);

            $guildXML = $this->getXmlData($armoryURL);

            if (is_array($guildXML) && array_key_exists('XmlData', $guildXML)) {
                $guildArray = $this->convertXmlToArray($guildXML['XmlData']);
                return $guildArray;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }

    }

    /**
     * Provides information on a specific item by querying its' ID.
     * @access      public
     * @param       int         $itemID                 The items' ID.
     * @return      array       $result                 Returns an array containing itemData if $itemID is valid, otherwise FALSE.
     */
    public function getItemData($itemID) {

        if (is_numeric($itemID)) {
            $itemURL = $this->armory."item-tooltip.xml?i=".$itemID;

            $itemXML = $this->getXmlData($itemURL);

            if (is_array($itemXML) && array_key_exists('XmlData', $itemXML)) {

                $itemArray = $this->convertXmlToArray($itemXML['XmlData']);

                self::triggerNotice("Fetched item by ID [" . $itemID . "].");

                return $itemArray;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
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

        if (is_string($itemName)) {
            $itemURL = $this->armory."search.xml?searchQuery=".urlencode($itemName)."&searchType=items";

            $itemsXML = $this->getXmlData($itemURL);

            if (is_array($itemsXML) && array_key_exists('XmlData', $itemsXML)) {

                $itemsArray = $this->convertXmlToArray($itemsXML['XmlData']);

                $items = $itemsArray['armorysearch']['searchresults']['items']['item'];

                if (!is_array($items[0])) {
                    $items = array($items);
                }

                foreach ($items as $x_item) {
                    if (strtolower($x_item['name']) == strtolower($itemName)) {
                        $itemID = $x_item['id'];
                        if ($filter==NULL) {
                            return $this->getItemData($itemID);
                        } elseif (is_array($filter)) {
                            $x_item = $this->getItemData($itemID);
                            $tooltip = $x_item['itemtooltip'];
                            foreach ($itemFilter as $attrib => $x_filter) {
                                if ($tooltip[$attrib] != $x_filter) {
                                    unset($x_item); break;
                                }
                            }
                            if ($x_item) return $x_item;
                        }
                    }
                }
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }

    }

    /**
     * Searches for any object in the armory matching given search specifications.
     * @access      public
     * @param       string      $type                   The type of search to perform. Valid search types are 'items', 'characters', 'guilds', 'arenateams'.
     * @param       string      $objectName             The object name to search for.
     * @param       string      $filter                 An associative array of search paramters.
     * @return      mixed       $result                 Returns an array containing searchData if $objectName is valid, otherwise FALSE.
     */
    public function getAnyData($type = NULL, $objectName, $filter = NULL) {

        if (is_string($type) && is_string($objectName)) {

            switch ($type) {
                case 'arenateams':
                    $searchType = 'arenateams';
                    break;
                case 'characters':
                    $searchType = 'characters';
                    break;
                case 'guilds':
                    $searchType = 'guilds';
                    break;
                case 'items':
                    $searchType = 'items';
                    break;
                default:
                    $searchType = 'characters';
                    break;
            }

            $searchURL = $this->armory."search.xml?searchQuery=".urlencode($objectName)."&searchType=".$searchType;
            $searchXML = $this->getXmlData($searchURL);

            if (is_array($searchXML) && array_key_exists('XmlData', $searchXML)) {
                self::triggerNotice("Searched for object \"".$objectName."\" of type [" . $searchType . "].");

                $searchArray = $this->convertXmlToArray($searchXML['XmlData']);

                return $searchArray;
            } else {
                self::triggerNotice("Searching for object \"".$objectName."\" of type [" . $searchType . "] failed.");
                return FALSE;
            }

        } else {
            return FALSE;
        }
    }
}
?>
