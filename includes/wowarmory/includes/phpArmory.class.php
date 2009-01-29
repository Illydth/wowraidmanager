<?php

/**
 * Project:     phpArmory: fetch and unserialize XML data from the World of Warcraft Armory website.
 * File:		phpArmory.class.php
 * 
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 *
 * For questions, help, comments, discussion, etc., please join the
 * phpArmory mailing list. Send a blank e-mail to
 * smarty-general-subscribe@lists.php.net
 *
 * @link http://sourceforge.net/projects/phparmory/
 * @copyright 2007 Michael Cotterell
 * @author Michael Cotterell <mepcotterell@gmail.com>
 * @package phpArmory
 * @version 0.2
 *
 */
 
 /* $Id: phpArmory.class.php,v 0.1 2007/06/02 */


/**
 * phpArmory Class
 * 
 * A class library to fetch and unserialize XML data from the World of Warcraft Armory website. 
 *
 * @package phpArmory
 */
class phpArmory {

	/* Armory Variable Structure */ 
    
    /** 
     * the language items get fetched - courtesy from flokohlert 
     * 
     * @var string: de/en/fr/es 
     */
    var $lang = "en";  	
    //var $lang = "de";  	
    //var $lang = "fr";  	
    //var $lang = "es";  	
	 
	/** 
	 * The URL of the Armory website 
	 * 
	 * @var string 
	 */
	var $armory = "http://www.wowarmory.com/"; 
	//var $armory = "http://eu.wowarmory.com/";
	//var $armory = "http://kr.wowarmory.com/";
	//var $armory = "http://tw.wowarmory.com/";
	
	/**
	 * The case sensitive name of a realm.
	 *
	 * @var string
	 */
	var $realm = FALSE;
	
	/**
	 * The case sensitive name of a guild.
	 *
	 * @var string
	 */
	var $guild = FALSE;
	
	/**
	 * The case sensitive name of a character.
	 *
	 * @var string
	 */
	var $character = FALSE;
	
	/**
     * The default user agent for making HTTP requests
     *
     * @var string
     */
//	var $userAgent = "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.1) Gecko/20061204 Firefox/2.0.0.1";
    var $userAgent = "Mozilla/5.0 (Windows; U; Windows NT 5.1; pt-BR; rv:1.8.1.12) Gecko/20080201 Firefox/2.0.0.12";
	
	/**
	 * The amounto of time in senconds after which to consider
	 * a connection timed out if not data has been yet been
	 * received.
	 *
	 * @var integer
	 */
	var $timeout = 30;

	/* End: Armory Variable Structure */
	 
	/**#@-*/
	/**
	* The Constructor
	*
	* This function is called when the object is created. It has
	* one optional parameter which sets the base url of the
	* Armory website that will be used to fetch the serialized
	* XML data. (Useful for connecting to the European Armory)
	*
	* @param string	$armory	URL of the Armory website
	*/
	function phpArmory($armory = NULL){
	
		if ($armory){
			$this->armory = $armory;
		}
		
	}

	function getlang(){
		return $this->lang;
	}

	/**
	* characterFetch
	*
	* This function returns the unserialized XML data for a character
	* from the Armory. Both parameters are optional if their
	* corresponding instance variables are set. Most of the
	* time it is safe to assume that the realm instance 
	* variable is set. Therefore, most of the time, the 
	* second paramater is optional whereas the first
	* parameter usually needs to be defined. It is very
	* important to remember that both paramaters are case
	* sensitive.
	*
	* @return string[]			An associative array
	* @param string	$character	The name of the character
	* @param string	$realm		The character's realm
	*/
	function characterFetch($character = NULL, $realm = NULL){
		
		if(($character==NULL)&&($this->character)) $character = $this->character;
		if(($realm==NULL)&&($this->realm)) $realm = $this->realm;
		
		$realm = str_replace("\'", "%%27",$realm);
		$url = $this->armory."character-%s.xml?r=".str_replace(" ", "+",$realm)."&n=".str_replace(" ", "+",$character);
		$result = $this->xmlToArray($this->xmlFetch(sprintf($url, "sheet")));
		
		//Character skills page is no longer available.
		//$pages = array("reputation", "skills", "talents");
		$pages = array("reputation", "talents");
		foreach ($pages as $page) {
			$temp = $this->xmlToArray($this->xmlFetch(sprintf($url, $page)));
			unset($temp['characterinfo']['character']);
			$result['characterinfo'] = array_merge($result['characterinfo'], reset($temp));
		}

		return $result;

	}
	
	/**
	* characterIconURL
	*
	* This function returns the url of a portrait icon for a
	* character from the Armory.
	*
	* @param string[]	$info		The character info array including level, gender, race, and class
	* @return string				The URL of the icon
	* @author Claire Matthews <poeticdragon@stormblaze.net>
	*/
	function characterIconURL($info) {

		$dir = "wow" . ($info['level'] < 60 ? "-default" : ($info['level'] < 70 ? "" : "-70"));
		return $this->armory."images/portraits/$dir/{$info['genderid']}-{$info['raceid']}-{$info['classid']}.gif";

	}

	/**
	* guildFetch
	* 
	* This function returns the unserialized XML data for a Guild
	* from the Armory. Both parameters are optional if their
	* corresponding instance variables are set. Most of the
	* time it is safe to assume that the realm instance 
	* variable is set. Therefore, most of the time, the 
	* second paramater is optional whereas the first
	* parameter usually needs to be defined. It is very
	* important to remember that both paramaters are case
	* sensitive.
	*
	* @return string[]		An associative array
	* @param string	$guild	The name of the guild
	* @param string	$realm	The guild's realm
	*/
	function guildFetch($guild = NULL, $realm = NULL){
	
		if(($guild==NULL)&&($this->guild)) $guild = $this->guild;
		if(($realm==NULL)&&($this->realm)) $realm = $this->realm;
	
		$url = $this->armory."guild-info.xml?r=".str_replace(" ", "+",$realm)."&n=".str_replace(" ", "+",$guild);
		return $this->xmlToArray($this->xmlFetch($url));
	
	}
	
	/**
	* itemFetch
	* 
	* This function returns the unserialized XML data
	* for an item from the Armory. The itemID parameter
	* is required.
	*
	* @return string[]				An associative array
	* @param integer	$itemID		The ID of the item
	*/
	function itemFetch($itemID){
	
		$url = $this->armory."item-tooltip.xml?i=".$itemID;
		return $this->xmlToArray($this->xmlFetch($url));
	
	}
	
	/**
	* itemNameFetch
	* 
	* This function returns the unserialized XML data
	* for an item from the Armory. The item parameter
	* is required. The second parameter filters search
	* results by the specified string and is optional.
	*
	* @return string[]			An associative array
	* @param string		$item	The name of the item
	* @param string[]	$filter	Associative array of search parameters
	* @author Thiago Melo <http://thiago.oxente.org/>
	* @author Claire Matthews <poeticdragon@stormblaze.net>
	* 
	* This function returns the unserialized XML data
	* for an item from the Armory. The item parameter
	* is required. The second parameter filters search
	* results by the specified string and is optional.
	*
	*/
	function itemNameFetch($item, $filter = NULL) {

		$item = str_replace("-", "+ ",$item);
		$url = $this->armory."search.xml?searchQuery=".str_replace(" ", "+",$item)."&searchType=items";
		$items = $this->xmlToArray($this->xmlFetch($url));
		$items = $items['armorysearch']['searchresults']['items']['item'];

		if (!is_array($items[0])) $items = array($items);

		foreach ($items as $x_item) {
			if (strtolower($x_item['name']) == strtolower($item)) {
				$itemID = $x_item['id'];
				if ($filter==NULL) {
					return $this->itemFetch($itemID);
				} elseif (is_array($filter)) {
					$x_item = $this->itemFetch($itemID);
					$tooltip = $x_item['itemtooltip'];
					foreach ($filter as $attrib => $x_filter) {
						if ($tooltip[$attrib] != $x_filter) {
							unset($x_item); break;
						}
					}
					if ($x_item) return $x_item;
				}
			}
		}

	}

	/**
	* xmlFetch
	* 
	* This function returns the string of characters
	* returned from an HTTP GET request to the url 
	* defined in the url parameter. It is interesting
	* to note that although the function is called 
	* xmlFetch, the returned string may not neccesarily
	* be serialized XML data when the function is 
	* called publicly. 
	*
	* @todo Make the function independent of cURL
	*
	* @param string		$url			URL of the page to fetch data from
	* @param string		$userAgent		The user agent making the GET request
	* @param integer	$timeout		The connection timeout in seconds
	*/
	function xmlFetch($url, $userAgent = NULL, $timeout = NULL, $lang = NULL){
	
		if(($userAgent==NULL)&&($this->userAgent)) $userAgent = $this->userAgent;
		if(($timeout==NULL)&&($this->timeout)) $timeout = $this->timeout;
		if(($lang==NULL)&&($this->lang)) $lang = $this->lang; //lang suport courtesy from flokohlert
	
		if (function_exists('curl_init')){
	
			$ch = curl_init();
			$timeout = $this->timeout;
			$userAgent = $this->userAgent;
			
			$stderrfptr = fopen(getcwd() . "../../../cache/armory_log/stderr.log", "w+");
			curl_setopt ($ch, CURLOPT_URL, $url);
			curl_setopt ($ch, CURLOPT_VERBOSE, 1);
			curl_setopt ($ch, CURLOPT_STDERR, $stderrfptr);
			curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
			curl_setopt ($ch, CURLOPT_USERAGENT, $userAgent);
		    curl_setopt ($ch, CURLOPT_HTTPHEADER, array("Accept-Language: ".$lang.",".$lang."-".$lang.";"));  

			$f = curl_exec($ch);
			
			curl_close($ch);
        } elseif(ini_get('allow_url_fopen') == 1) {
        		echo "Gets to Allow URL";
                $contextOptions = array('http'=>array('method'=>"GET",'header'=>"Accept-language: ".$lang."\r\n" . $userAgent . "\r\n"));
                $context = stream_context_create($contextOptions);
                $f = '';
                $handle = fopen($url, 'r', false, $context);
                if ($handle) {
	                while(!feof($handle))
	                {
	                        $f .= fgets($handle);
	                }
	                fclose ($handle);
                }
                return $f;
        } elseif(function_exists('stream_context_create') && function_exists('file_get_contents')) {
        	echo "Gets to Stream Create";
                $contextOptions = array('http'=>array('method'=>"GET",'header'=>"Accept-language: ".$lang."\r\n" . $userAgent . "\r\n"));
                $context = stream_context_create($contextOptions);
                $f = file_get_contents($url,false, $context);
        } else {
                die('There couldn\'t be found any function on your server, whichwork!<br /><br />Try this functions:<br />- curl<br />- file_get_contents with stream_context_create<br />- fopen with stream_context_create<br /><br />Ask your hoster to activate these functions.');
        }

		return $f;
	}

	/**
	* xmlToArray
	* 
	* This function converts an xml string to an associative array
	* duplicating the xml file structure.
	*
	* @param string		$xmlData 		The XML data string to convert.
	* @param boolean 	$includeTopTag	Whether or not the topmost xml tag should be included in the array. The default value for this is false.
	* @param boolean	$lowerCaseTags	Whether or not tags should be set to lower case. Default value for this parameter is true.
	* @return string[]					An associative array
	* @author Jason Read <jason@ace.us.com>
	*/	
	function & xmlToArray($xmlData, $includeTopTag = false, $lowerCaseTags = true){

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
				$data = ( isset($value['attributes']) ? array($value['attributes']) : array());
				$data = ( trim($value['value']) ? array_merge($data, array($value['value'])) : $data);
				if (isset($temp[$p])) $temp[$p] = array_merge($temp[$p], $data);
				else $temp[$p] = $data;
				if ($value['type']=='complete') array_pop($depth);
				break;
	
			case 'close':
				array_pop($depth);
				break;
	
			}
	
		}
		
		if (!$includeTopTag) unset($temp["page"]);
		
		foreach ($temp as $key => $value) {
	
			if (count($value)==1) { $value = reset($value); }

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
				}
				$pointer = $value;
			}
	
		}
	
		return ($includeTopTag ? $xmlArray : reset($xmlArray));

	}
	
	/**#@-*/
	
}

?>