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

   
      /**
     * the language items get fetched
     * courtesy from flokohlert
     * @var de/en/fr/es
     */
        var $lang = "en";

	/**
     * The URL of the Armory website
     *
     * @var string
     */
	var $armory = "http://www.wowarmory.com/";
//	 var $armory = "http://eu.wowarmory.com/";
	
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
	function armory($armory = NULL){
	
		if ($armory){
			$this->armory = $armory;
		}
		
	}

	/*
	*
	* setlang and getlang for multilanguage suport
	*
	*/
	function setlang($l) {
		switch($l)
		{
			case 'de':
				$this->lang = 'de';
				$this->armory = 'http://eu.wowarmory.com/';
			break;
                        case 'es':
                                $this->lang = 'es';
                                $this->armory = 'http://eu.wowarmory.com/';
                        break;

                        case 'fr':
                                $this->lang = 'fr';
                                $this->armory = 'http://eu.wowarmory.com/';
                        break;
                        case 'uk':
                                $this->lang = 'en';
                                $this->armory = 'http://eu.wowarmory.com/';
                        break;
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

		$realm = str_replace("\'", "%27",$realm);
		$url = $this->armory."character-sheet.xml?r=".str_replace(" ", "+",$realm)."&n=".str_replace(" ", "+",$character);
		return $this->xmlToArray($this->xmlFetch($url));
		
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
	* itemnameFetch
	*
	* This function returns the unserialized XML data
        * for an item from the Armory. But now you can use the Item Name instead of the Item ID
        * @return string[]                              An associative array
        * @param string 	$itemNAME         The NAME of the item
        */
        function itemnameFetch($itemNAME){

		// Fix for the "-" Minux character
		$itemNAME = str_replace("-", "+ ",$itemNAME);
                $url = $this->armory."search.xml?searchQuery=".str_replace(" ", "+",$itemNAME)."&searchType=items";
                 //return $this->xmlToArray($this->xmlFetch($url));
                $item_ary = $this->xmlToArray($this->xmlFetch($url));
                $item_ary_value = $item_ary['armorysearch']['searchresults']['items']['item'];
                if (is_array($item_ary_value[0]))
		{
			foreach($item_ary_value as $x_item)
			{
				if (isset($x_item['name']))
				{
					if ($lang != 'en')
					{
					   $x_item['name'] = utf8_decode($x_item['name']);
					}
					if (strtoupper($x_item['name']) == strtoupper($itemNAME))
                			$url = $this->armory."item-tooltip.xml?i=".$x_item['id'];
				}
			}
		}
		else
			$url = $this->armory."item-tooltip.xml?i=".$item_ary_value['id'];
                return $this->xmlToArray($this->xmlFetch($url));
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
					
			curl_setopt ($ch, CURLOPT_URL, $url);
			curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
			curl_setopt ($ch, CURLOPT_USERAGENT, $userAgent);
		        curl_setopt ($ch, CURLOPT_HTTPHEADER, array("Accept-Language: ".$lang.",".$lang."-".$lang.";"));  

			$f = curl_exec($ch);
			
			curl_close($ch);
		} else {

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
