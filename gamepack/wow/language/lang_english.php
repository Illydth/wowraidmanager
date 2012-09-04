<?php
/***************************************************************************
 *                             lang_wow.php
 *                            -------------------
 *   begin                : Saturday, Jan 16, 2005
 *   copyright            : (C) 2007-2008 Douglas Wagner
 *   email                : douglasw@wagnerweb.org
 *
 *   $Id: lang_wow.php,v 2.00 2008/03/07 13:51:25 psotfx Exp $
 *
 ***************************************************************************/

/***************************************************************************
*
*    WoW Raid Manager - Raid Management Software for World of Warcraft
*    Copyright (C) 2007-2008 Douglas Wagner
*
*    This program is free software: you can redistribute it and/or modify
*    it under the terms of the GNU General Public License as published by
*    the Free Software Foundation, either version 3 of the License, or
*    (at your option) any later version.
*
*    This program is distributed in the hope that it will be useful,
*    but WITHOUT ANY WARRANTY; without even the implied warranty of
*    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*    GNU General Public License for more details.
*
*    You should have received a copy of the GNU General Public License
*    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*
****************************************************************************/
if (empty($phprlang) || !is_array($phprlang))
	$phprlang = array();
	
$phprlang = array_merge($phprlang, array(


// factions
'alliance' =>  'Alliance',
'horde' =>  'Horde',

// classes
'deathknight' =>  'Death Knight',
'druid' =>  'Druid',
'hunter' =>  'Hunter',
'mage' =>  'Mage',
'paladin' =>  'Paladin',
'priest' =>  'Priest',
'rogue' =>  'Rogue',
'shaman' =>  'Shaman',
'warlock' =>  'Warlock',
'warrior' =>  'Warrior',

// races
'blood_elf' =>  'Blood Elf',
'draenei' =>  'Draenei',
'dwarf' =>  'Dwarf',
'gnome' =>  'Gnome',
'goblin' =>  'Goblin',
'human' =>  'Human',
'night_elf' =>  'Night Elf',
'orc' =>  'Orc',
'tauren' =>  'Tauren',
'troll' =>  'Troll',
'undead' =>  'Undead',
'worgen' =>  'Worgen',

// Talent Specs
'disc' =>  "Discipline",
'holy' =>  "Holy",
'shadow' =>  "Shadow",
'assassination' =>  "Assassination",
'combat' =>  "Combat",
'subtlety' =>  "Subtlety",
'arms' =>  "Arms",
'fury' =>  "Fury",
'prot' =>  "Protection",
'arcane' =>  "Arcane",
'fire' =>  "Fire",
'frost' =>  "Frost",
'balance' =>  "Balance",
'cat' =>  "Feral (Cat)",
'bear' =>  "Feral (Bear)",
'resto' =>  "Restoration",
'bm' =>  "Beast Mastery",
'marks' =>  "Marksmanship",
'survival' =>  "Survival",
'affliction' =>  "Affliction",
'demon' =>  "Demonology",
'destro' =>  "Destruction",
'elemental' =>  "Elemental",
'enhance' =>  "Enhancement",
'ret' =>  "Retribution",
'frost_tank' =>  "Frost (Tank)",
'frost_melee' =>  "Frost (Melee)",
'blood_tank' =>  "Blood (Tank)",
'blood_melee' =>  "Blood (Melee)",
'unholy_tank' =>  "Unholy (Tank)",
'unholy_melee' =>  "Unholy (Melee)",
'notavailable' =>  "N/A",

// tooltips
'arcane' =>  'Arcane',
'arcane_resistance_title' =>  'Arcane Resistance',
'fire' =>  'Fire',
'fire_resistance_title' =>  'Fire Resistance',
'frost' =>  'Frost',
'frost_resistance_title' =>  'Frost Resistance',
'nature' =>  'Nature',
'nature_resistance_title' =>  'Nature Resistance',
'shadow' =>  'Shadow',
'shadow_resistance_title' =>  'Shadow Resistance',
		
		
'deathknight_icon' =>  'Click to see Death Knights',
'druid_icon' =>  'Click to see druids',
'hunter_icon' =>  'Click to see hunters',
'mage_icon' =>  'Click to see mages',
'paladin_icon' =>  'Click to see paladins',
'priest_icon' =>  'Click to see priests',
'rogue_icon' =>  'Click to see rogues',
'shaman_icon' =>  'Click to see shamans',
'warlock_icon' =>  'Click to see warlocks',
'warrior_icon' =>  'Click to see warriors',
));
?>