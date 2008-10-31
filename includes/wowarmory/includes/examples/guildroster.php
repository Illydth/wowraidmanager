<?php

/**
 * Project:     phpArmory: fetch and unserialize XML data from the World of Warcraft Armory website.
 * File:		examples/guildroster.php
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
 * @version 1.0
 *
 */

/**
 *  Configuration
 * 
 * @var string $guildName	Case-sensitive name of the guild
 * @var string $realmName	Case-sensitive name of the realm
 * 
 */

$guildName = "Knights of Chaos";
$realmName = "Kul Tiras";

// Include the phpArmory class library
include('../phpArmory.class.php');

// Instantiate the class library
$armory = new phpArmory();

// Fetch guild information
$guild = $armory->guildFetch($guildName, $realmName);

// Define some variables
$guildName = $guild['guildinfo']['guild']['name'];
$guildMemberCount = $guild['guildinfo']['guild']['members']['membercount'];
$guildCharacters = $guild['guildinfo']['guild']['members']['character'];

?>
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
                <td><img src="<?=$armory->characterIconURL($char);?>" alt="" /></td>
        	</tr>
<?

}

?>  	
    	</tbody>
	</table>
	<p>Data scraped from the official World of Warcraft Armory (<?=$armory->armory;?>)</p>    
</body>
</html>