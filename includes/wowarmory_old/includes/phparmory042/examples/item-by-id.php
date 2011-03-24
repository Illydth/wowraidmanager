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
$itemID             = 19990;

$sapi_type = substr(php_sapi_name(), 0, 3);

// Instantiate the class library
if ( $armory = new phpArmory5($areaName = $areaName) ) {

    $itemIDData = $armory->getItemData($itemID);
    if ($sapi_type == 'cli') {
        var_dump ($itemIDData);
    } else {
        $string = print_r($itemIDData, 1);
        $string = str_replace(array(" ", "\n"), array("&nbsp;", "<br />\n"), $string);

        echo "\$item = ".$string;
    }
} else {
    echo "Failed to create a phpArmory5 instance.\n";
}

?>
