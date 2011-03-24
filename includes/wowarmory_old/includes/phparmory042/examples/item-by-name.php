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
$itemName           = "Glimmering Naaru Sliver";

$sapi_type = substr(php_sapi_name(), 0, 3);

// Instantiate the class library
if ( $armory = new phpArmory5($areaName = $areaName) ) {

    $itemNameData = $armory->getItemDataByName($itemName);
    if ($sapi_type == 'cli') {
        var_dump ($itemNameData);
    } else {
        $string = print_r($itemNameData, 1);
        $string = str_replace(array(" ", "\n"), array("&nbsp;", "<br />\n"), $string);

        echo "\$item = ".$string;
    }
} else {
    echo "Failed to create a phpArmory5 instance.\n";
}

?>
