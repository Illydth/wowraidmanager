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

// classes　職業
'deathknight' =>  'Death Knight',
'druid' =>  '德魯伊',
'hunter' =>  '獵人',
'mage' =>  '法師',
'paladin' =>  '聖騎士',
'priest' =>  '牧師',
'rogue' =>  '盜賊',
'shaman' =>  '薩滿',
'warlock' =>  '術士',
'warrior' =>  '戰士',

// races　種族
'blood_elf' =>  '血精靈',
'draenei' =>  '德萊尼',
'dwarf' =>  '矮人',
'gnome' =>  '地精',
'goblin' =>  'Goblin', //New
'human' =>  '人類',
'night_elf' =>  '夜精靈',
'orc' =>  '獸人',
'tauren' =>  '牛頭人',
'troll' =>  '食人妖',
'undead' =>  '不死族',
'worgen' =>  'Worgen', //New

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
'arcane' =>  '祕法抗性',
'arcane_resistance_title' =>  '祕法抗性',
'fire' =>  '火焰抗性',
'fire_resistance_title' =>  '火焰抗性',
'frost' =>  '冰霜抗性',
'frost_resistance_title' =>  '冰霜抗性',
'nature' =>  '自然抗性',	
'nature_resistance_title' =>  '自然抗性',
'shadow' =>  '暗影抗性',
'shadow_resistance_title' =>  '暗影抗性',
		
'deathknight_icon' =>  'Click to see Death Knights',
'druid_icon' =>  '點擊這裡查看德魯伊',
'hunter_icon' =>  '點擊這裡查看獵人',
'mage_icon' =>  '點擊這裡查看法師',
'paladin_icon' =>  '點擊這裡查看聖騎士',
'priest_icon' =>  '點擊這裡查看牧師',
'rogue_icon' =>  '點擊這裡查看盜賊',
'shaman_icon' =>  '點擊這裡查看薩滿',
'warlock_icon' =>  '點擊這裡查看術士',
'warrior_icon' =>  '點擊這裡查看戰士',
		
));  ?>