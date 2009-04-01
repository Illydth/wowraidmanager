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
$guildName          = "Divinitas";
$guildRealmName     = "Madmortem";

$sapi_type = substr(php_sapi_name(), 0, 3);

// Instantiate the class library
if ( $armory = new phpArmory5($areaName = $areaName) ) {

    $guildData = $armory->getGuildData($guildName, $guildRealmName);
    if ($sapi_type == 'cli') {
        var_dump ($guildData);
    } else {
    // Define some variables
    $guildName = $guildData['guildinfo']['guild']['name'];
    $guildMemberCount = $guildData['guildinfo']['guild']['members']['membercount'];
    $guildCharacters = $guildData['guildinfo']['guild']['members']['character'];?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?=$guildName;?> Roster</title>
</head>

<body>

    <h1><?=$guildName;?> Roster</h1>
    <h2><?=$guildMemberCount;?> Members</h2>

    <table>
        <caption>Guild Members</caption>
        <thead>
            <tr>
                <th>Name</th>
                <th>Level</th>
                <th>Race</th>
                <th>Class</th>
                <th>Gender</th>
                <th>Rank</th>
                <th>Portrait</th>
            </tr>
        </thead>
        <tbody>
<?php

foreach($guildCharacters as $char){
    $char = $char;
?>
            <tr>
                <td><?=$char['name'];?></td>
                <td><?=$char['level'];?></td>
                <td><?=$char['race'];?></td>
                <td><?=$char['class'];?></td>
                <td><?=$char['gender'];?></td>
                <td><?=$char['rank'];?></td>
                <td><img src="<?=$armory->getCharacterIconURL($char);?>" alt="" /></td>
            </tr>
<?

}

?>
        </tbody>
    </table>
    <p>Data scraped from the official World of Warcraft Armory (<?=$armory->armory;?>)</p>
</body>
</html>
<?php
    }
} else {
    echo "Failed to create a phpArmory5 instance.\n";
}

?>
