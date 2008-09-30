<?php

/**
 * Project:     phpArmory: fetch and unserialize XML data from the World of Warcraft Armory website.
 * File:		examples/character.php
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
 * Configuration
 * 
 * @var string $charName	Case-sensitive name of the character
 * @var string $realmName	Case-sensitive name of the realm
 * 
 */
 
$charName = "Phattangent";
$realmName = "Kul Tiras";

// Include the phpArmory class library
include('../phpArmory.class.php');

// Instantiate the class library
$armory = new phpArmory();

// Fetch character information
$char = $armory->characterFetch($charName, $realmName);

$string = print_r($char, 1);
$string = str_replace(array(" ", "\n"), array("&nbsp;", "<br />\n"), $string);

echo "\$char = ".$string;
 
?>