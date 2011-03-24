<?php
/**
 * phpArmory5 test case
 *
 * A test case to derive a new class object from the phpArmory5 class.
 * @package phpArmory
 * @subpackage tests
 */

// Include the phpArmory class library
require_once ('../phpArmory.class.php');

$euArea             = 'eu';
$usArea             = 'us';

$itemID             = 19990;
$itemName           = "Glimmering Naaru Sliver";

$characterName      = "Arkanella";
$characterRealmName = "Madmortem";

$guildName          = "Divinitas";
$guildRealmName     = "Madmortem";

// Instantiate the class library
if ( $armory = new phpArmory5($areaName = $usArea) ) {
    echo "We have created an instance of phpArmory5 with the area \"" . $usArea ."\" selected.\n";

    echo "The current armory patch level is: " . $armory->getPatchLevel() . "\n";

    echo "World of Warcraft provides us with " . count ($armory->getTalentData()) . " talent definitions.\n";

    if ( $armory->setArea($euArea) ) {

        $armoryAreaData = $armory->getArea();

        echo "Area used now is \"" . $armoryAreaData[0] ."\".\n";

        echo "Armory site used now is \"" . $armoryAreaData[1] ."\".\n";

        echo "Web site used now is \"" . $armoryAreaData[2] ."\".\n";

        $itemIDData = $armory->getItemData($itemID);

        $itemNameData = $armory->getItemDataByName($itemName);

        $characterData = $armory->getCharacterData($characterName, $characterRealmName);

        $characterIcon = $armory->getCharacterIconURL($characterData['characterinfo']['character']);

        $guildData = $armory->getGuildData($guildName, $guildRealmName);

        $searchResults = $armory->getAnyData($type = "characters", $objectName = "dark", $filter = NULL);
    }
} else {
    echo "Could not create an instance of phpArmory5. Please consult your PHP5 logs.\n";
}

?>
