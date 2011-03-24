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


$areaName           = 'eu';
$characterName      = "Arkanella";
$characterRealmName = "Madmortem";

$sapi_type = substr(php_sapi_name(), 0, 3);

// Instantiate the class library
if ( $armory = new phpArmory5($areaName = $areaName) ) {

    $characterData = $armory->getCharacterData($characterName, $characterRealmName);
    if ($sapi_type == 'cli') {
        var_dump ($characterData);
    } else {
        $string = print_r($characterData, 1);
        $string = str_replace(array(" ", "\n"), array("&nbsp;", "<br />\n"), $string);

        echo "\$character = ".$string;
    }
} else {
    echo "Failed to create a phpArmory5 instance.\n";
}

?>
