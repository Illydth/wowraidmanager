<?php

// require_once($phpraid_dir."./wowarmory/simple_html_dom.php");
// require_once($phpraid_dir."./wowarmory/scrapper.php");
require_once("simple_html_dom.php");
require_once("scrapper.class.php");



function fetch_character($name, $realm) {

$url = "http://us.battle.net/wow/en/character/".utf8_encode($realm)."/".utf8_encode($name)."/simple";

$scrapper = new Scrapper();

$scrapper->fetch($url);

$html = $scrapper->removeNewlines($scrapper->result);

	$html = file_get_object($html);

	if($html->find('div[id=server-error] h2')) return FALSE;

	else {
		$return = array();
		
		$return['name'] = $name;
		//echo $return['name'] . "<br>";
		
		$return['level'] = trim($html->find('span[class="level"]',0)->innertext);
			$return['level'] = preg_replace('/\D/', '', $return['level']);	// Strip out anything but numbers
		//echo $return['level'] . "<br>";
		
		$return['avgilvl'] = trim($html->find('span[class="equipped"]',0)->innertext);
			$return['avgilvl'] = preg_replace('/\D/', '', $return['avgilvl']);	// Strip out anything but numbers
		//echo $return['avgilvl'] . "<br>";
				
		$return['bestilvl'] = trim($html->find('div[class="best tip"]',0)->innertext);
			$return['bestilvl'] = preg_replace('/\D/', '', $return['bestilvl']);	// Strip out anything but numbers
		//echo $return['bestilvl'] . "<br>";
			

		$return['health'] = trim($html->find('li[class="health"]',0)->innertext);
			$return['health'] = preg_replace('/\D/', '', $return['health']);	// Strip out anything but numbers
		
		echo $return['health'] . "<br>";
		
		$return['mana'] = trim($html->find('li[class="resource-0"]',0)->innertext);
			$return['mana'] = preg_replace('/\D/', '', $return['mana']);	// Strip out anything but numbers
		echo $return['mana'] . "<br>";

		$return['spec'] = trim($html->find('a[class="spec tip"]',0)->innertext);
		echo $return['spec'] . "<br>";
		
		
		return $return;
	}

}
// troubleshooting purposes only
print_r(fetch_character('Cypress', 'Tichondrius'));
?>