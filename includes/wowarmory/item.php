<?php
/*
* Armory World of Warcraft Items Tooltip
*
* Thiago Melo <ReiserFS>
* thiago@oxente.org
* http://thiago.oxente.org
* http://killermokeys.net
*
* MOD Info and Download: http://www.phpbb.com/community/viewtopic.php?f=70&t=576155
*
* Use: [wow]Warcraft Item Name[/wow]
*
*/

// Include Commom file 
include("includes/common.php");

// Get the URL GET And decode
$var = urldecode($_GET['v']);

// Get the item data from the item name.
$item = $armory->itemnameFetch($var);

// Url for armory icons
$icons_url = $armory->armory . "images/icons/";

// Reduce the array name size, make more easy to work with the array.
$item = $item['itemtooltips']['itemtooltip'];

if (count($item) == 0) die("<br /> <br /> ".LANG_ERROR_CONNECT." <br /> <br /> <br />");

//DEBUGGING
// print_r($item);

// VARIABLES USED
$damage_data = '';
$bonding = '';
$require_data = '';
$type_class = '';
$armor_data = '';
$gem_data = '';
$durability = '';
$spell_data = '';
$set_data = '';
$desc = '';

// Return the quality color
function value_color($v)
{
	switch($v)
	{
		case 0: return "#c9c9c9"; break;
		case 1: return "#FFFFFF"; break;
		case 2: return "#00FF00"; break;
		case 3: return "#0070DD"; break;
		case 4: return "#A335EE"; break;
		case 5: return "#FF3300"; break;
		case 6: return "#ffd517"; break;
		case 7: return "#d80000"; break;
	}
}

// Bonding
function value_bound($v)
{
	switch($v)
	{
		case 1: return LANG_BOP; break;
		case 2: return LANG_BOE; break;
		case 3: return LANG_SOULBOND; break;
    case 4: 
    case 5: return LANG_QUESTITEM; break;
	}
}

// Item Slot
function value_slot($v)
{
	switch($v)
	{
		case 0: return  " ";  break;
    case 1: return  LAND_SLOT_HEAD; break;
    case 2: return  LAND_SLOT_NECK; break;
    case 3: return  LAND_SLOT_SHOULDERS; break;
    case 4: return  LAND_SLOT_SHIRT;  break;
    case 5: return  LAND_SLOT_CHEST;  break;
    case 6: return  LAND_SLOT_WAIST;  break;
    case 7: return  LAND_SLOT_LEGS; break;
    case 8: return  LAND_SLOT_FEET; break;
    case 9: return  LAND_SLOT_WRIST;  break;
		case 10: return LAND_SLOT_HAND; break;
		case 11: return LAND_SLOT_FINGER; break;
		case 12: return LAND_SLOT_TRINKET;  break;
		case 13: return LAND_SLOT_ONEHAND; break;
		case 14: return LAND_SLOT_OFFHAND; break;
		case 15: return LAND_SLOT_RANGED; break;
		case 16: return LAND_SLOT_BACK; break;
		case 17: return LAND_SLOT_TWOHAND; break;
		case 18: return LAND_SLOT_BAG;  break;
		case 19: return LAND_SLOT_TABARD; break;
		case 20: return LAND_SLOT_CHEST;break;		
    case 21: return LAND_SLOT_MAINHAND;break;
    case 22: return LAND_SLOT_OFFHAND;break;
    case 23: return LAND_SLOT_HELDINOFFHAND;break;
    case 24: return LAND_SLOT_PROJECTILE;break;
    case 25: return LAND_SLOT_THROWN;break;
    case 26: return LAND_SLOT_RANGED;break;
    case 27: return LAND_SLOT_QUIVER;break;
    case 28: return LAND_SLOT_RELIC;break;
    default: return $v; 
	}
}

// Reputation level
function value_rep($v)
{
	switch($v)
	{
		case 0: return LANG_REP_HATED; break;
		case 1: return LANG_REP_HOSTILE; break;
		case 2: return LANG_REP_UNFRIENDLY; break;
		case 3: return LANG_REP_NEUTRAL;break;
		case 4: return LANG_REP_FRIENDLY;break;
		case 5: return LANG_REP_HONORED;break;
		case 6: return LANG_REP_REVERED;break;
		case 7: return LANG_REP_EXALTED;break;
	}
}

// Item Spell DATA Trigger
function value_trigger($v)
{
	switch($v)
	{
		case 1: return LANG_ITEM_EQUIP;break;
		default: return LANG_ITEM_USE; break;
	}
}

// Create Required DATA if exist
if (isset($item['requiredability'])) $require_data .= '<font color="#d80000">'.LANG_ITEM_REQUIRE.' '.$item['requiredability'].'</font> <br />';
if (isset($item['requiredlevel'])) $require_data .= '<font color="#d80000">'.LANG_ITEM_REQUIRE_LEVEL.' '.$item['requiredlevel'].'</font> <br />';
if (isset($item['requiredfaction'])) $require_data .= '<font color="#d80000">'.LANG_ITEM_REQUIRE.' '.$item['requiredfaction']['name'].' - '.value_rep($item['requiredfaction']['rep']).'</font> <br />';
if (isset($item['requiredskill']))  $require_data .= '<font color="#d80000">'.LANG_ITEM_REQUIRE.' '.$item['requiredskill']['name'].' - '.$item['requiredskill']['rank'].'</font> <br />'; 

// Class allowable to use
if (isset($item['allowableclasses']))
{
	if (is_array($item['allowableclasses']['class']))
	{
			$class = implode($item['allowableclasses']['class'], ', ');
	}
	else 
	{
		$class = $item['allowableclasses']['class'];
	}
	
	$require_data .='<font color="#d80000">'.LANG_CLASSES.': '.$class.'</font> <br />';
}

// Unique?
if ($item['maxcount']==1) $require_data .='<font color="#FFFFFF">'.LANG_UNIQUE.'</font> <br />';

// Create SPELL DATA if exist
if (isset($item['spelldata']))
{
	$spell = $item['spelldata']['spell'];
	// If existe more then one trigger
	if (is_array($spell['desc']))
	{
		for($i=0;$i<count($spell['desc']);$i++)
		{
			$trigger = (is_array($spell['trigger'][$i])) ? $spell['trigger'][$i] : $spell['trigger'];
			$spell_data .= '<font color="#00FF00">'.value_trigger($trigger) .': '.$spell['desc'][$i] .' </font><br />';
	}	}	
	else $spell_data .= '<font color="#00FF00">'.value_trigger($spell['trigger']).': '.$spell['desc'].' </font><br />';
}
// Make more Spelldata info, i know its very strange, but works =D.
if (isset($item['bonuscritspellrating'])) $spell_data.= '<font color="#00FF00">'.value_trigger(1).': '.LANG_BONUS_SPELLCRIT.' '.$item['bonuscritspellrating'].'</font><br />';
if (isset($item['bonushitspellrating'])) $spell_data.= '<font color="#00FF00">'.value_trigger(1).': '.LANG_BONUS_SPELLHIT.' '.$item['bonushitspellrating'].'</font><br />';
if (isset($item['bonushitrating'])) $spell_data.= '<font color="#00FF00">'.value_trigger(1).': '.LANG_BONUS_HIT.' '.$item['bonushitrating'].'</font><br />';
if (isset($item['bonusdefenseskillrating'])) $spell_data.= '<font color="#00FF00">'.value_trigger(1).': '.LANG_BONUS_DEF.' '.$item['bonusdefenseskillrating'].'</font><br />';
if (isset($item['bonusparryrating'])) $spell_data.= '<font color="#00FF00">'.value_trigger(1).': '.LANG_BONUS_PARRY.' '.$item['bonusparryrating'].'</font><br />';
if (isset($item['bonusdodgerating'])) $spell_data.= '<font color="#00FF00">'.value_trigger(1).': '.LANG_BONUS_DODGE.' '.$item['bonusdodgerating'].'</font><br />';
if (isset($item['bonusblockrating'])) $spell_data.= '<font color="#00FF00">'.value_trigger(1).': '.LANG_BONUS_BLOCK.' '.$item['bonusblockrating'].'</font><br />';
if (isset($item['bonuscritrating'])) $spell_data.= '<font color="#00FF00">'.value_trigger(1).': '.LANG_BONUS_CRITICAL.' '.$item['bonuscritrating'].'</font><br />';
if (isset($item['bonusresiliencerating'])) $spell_data.= '<font color="#00FF00">'.value_trigger(1).': '.LANG_BONUS_RESI.' '.$item['bonusresiliencerating'].'</font><br />';
if (isset($item['bonushitmeleerating'])) $spell_data.= '<font color="#00FF00">'.value_trigger(1).': '.LANG_BONUS_MELEEHIT.' '.$item['bonushitmeleerating'].'</font><br />';
if (isset($item['bonushitrangedrating'])) $spell_data.= '<font color="#00FF00">'.value_trigger(1).': '.LANG_BONUS_RANGEDHIT.' '.$item['bonushitrangedrating'].'</font><br />';
if (isset($item['bonuscritmeleerating'])) $spell_data.= '<font color="#00FF00">'.value_trigger(1).': '.LANG_BONUS_CRITMELEE.' '.$item['bonuscritmeleerating'].'</font><br />';
if (isset($item['bonuscritrangedrating'])) $spell_data.= '<font color="#00FF00">'.value_trigger(1).': '.LANG_BONUS_RANGEDCRIT.' '.$item['bonuscritrangedrating'].'</font><br />';
if (isset($item['bonushittakenmeleerating'])) $spell_data.= '<font color="#00FF00">'.value_trigger(1).': '.LANG_BONUS_TAKENHITMELEE.' '.$item['bonushittakenmeleerating'].'</font><br />';
if (isset($item['bonushittakenrangedrating'])) $spell_data.= '<font color="#00FF00">'.value_trigger(1).': '.LANG_BONUS_TAKENRANGEDHIT.' '.$item['bonushittakenrangedrating'].'</font><br />';
if (isset($item['bonushittakenspellrating'])) $spell_data.= '<font color="#00FF00">'.value_trigger(1).': '.LANG_BONUS_TAKENSPELLHIT.' '.$item['bonushittakenspellrating'].'</font><br />';
if (isset($item['bonuscrittakenmeleerating'])) $spell_data.= '<font color="#00FF00">'.value_trigger(1).': '.LANG_BONUS_TAKENMELEECRIT.' '.$item['bonuscrittakenmeleerating'].'</font><br />';
if (isset($item['bonuscrittakenrangedrating'])) $spell_data.= '<font color="#00FF00">'.value_trigger(1).': '.LANG_BONUS_TAKENRANGEDCRIT.' '.$item['bonuscrittakenrangedrating'].'</font><br />';
if (isset($item['bonuscrittakenspellrating'])) $spell_data.= '<font color="#00FF00">'.value_trigger(1).': '.LANG_BONUS_TAKENSPELLCRIT.' '.$item['bonuscrittakenspellrating'].'</font><br />';
if (isset($item['bonushastemeleerating'])) $spell_data.= '<font color="#00FF00">'.value_trigger(1).': '.LANG_BONUS_HASTEMELEE.' '.$item['bonushastemeleerating'].'</font><br />';
if (isset($item['bonushasterangedrating'])) $spell_data.= '<font color="#00FF00">'.value_trigger(1).': '.LANG_BONUS_HASTERANGED.' '.$item['bonushasterangedrating'].'</font><br />';
if (isset($item['bonushastespellrating'])) $spell_data.= '<font color="#00FF00">'.value_trigger(1).': '.LANG_BONUS_HASTESPELL.' '.$item['bonushastespellrating'].'</font><br />';
if (isset($item['bonushittakenrating'])) $spell_data.= '<font color="#00FF00">'.value_trigger(1).': '.LANG_BONUS_TAKENHIT.' '.$item['bonushittakenrating'].'</font><br />';
if (isset($item['bonuscrittakenrating'])) $spell_data.= '<font color="#00FF00">'.value_trigger(1).': '.LANG_BONUS_TAKENCRIT.' '.$item['bonuscrittakenrating'].'</font><br />';
if (isset($item['bonushasterating'])) $spell_data.= '<font color="#00FF00">'.value_trigger(1).': '.LANG_BONUS_HASTE.' '.$item['bonushasterating'].'</font><br />';
// if ($item['']) $spell_data.= '<font color="#00FF00">'.value_trigger(1).': Improves  by '.$item[''].'</font><br />';

// Build Armor / Bonus data
if (isset($item['armor'])) $armor_data .= '<font color="#FFFFFF">'.$item['armor'][1].' '.LANG_STATS_ARMOR.'</font><br />';
if (isset($item['bonusstamina']))  $armor_data .= '<font color="#FFFFFF">+'.$item['bonusstamina'].' '.LANG_STATS_STA.'</font><br />';
if (isset($item['bonusintellect']))  $armor_data .= '<font color="#FFFFFF">+'.$item['bonusintellect'].' '.LANG_STATS_INT.'</font><br />';
if (isset($item['bonusspirit']))  $armor_data .= '<font color="#FFFFFF">+'.$item['bonusspirit'].' '.LANG_STATS_SPI.'</font><br />';
if (isset($item['bonusagility']))  $armor_data .= '<font color="#FFFFFF">+'.$item['bonusagility'].' '.LANG_STATS_AGI.'</font><br />';
if (isset($item['bonusstrength']))  $armor_data .= '<font color="#FFFFFF">+'.$item['bonusstrength'].' '.LANG_STATS_STR.'</font><br />';
if (isset($item['blockvalue']))  $armor_data .= '<font color="#FFFFFF">'.$item['blockvalue'].' '.LANG_STATS_BLOCK.'</font><br />';
if (isset($item['fireresist']))  $armor_data .= '<font color="#FFFFFF">+'.$item['fireresist'].' '.LANG_STATS_FR.'</font><br />';
if (isset($item['natureresist']))  $armor_data .= '<font color="#FFFFFF">+'.$item['natureresist'].' '.LANG_STATS_NR.'</font><br />';
if (isset($item['frostresist']))  $armor_data .= '<font color="#FFFFFF">+'.$item['frostresist'].' '.LANG_STATS_FROST.'</font><br />';
if (isset($item['shadowresist']))  $armor_data .= '<font color="#FFFFFF">+'.$item['shadowresist'].' '.LANG_STATS_SR.'</font><br />';
if (isset($item['arcaneresist']))  $armor_data .= '<font color="#FFFFFF">+'.$item['arcaneresist'].' '.LANG_STATS_AR.'</font><br />';

// Durability info
if (isset($item['durability']))
{
	$durability = '<font color="#FFFFFF">'.LANG_DURABILITY.': '.$item['durability']['current'].'/'.$item['durability']['max'].'</font><br />';
}

//Build GEM Data
//http://www.wowarmory.com/images/images/icons/Socket_Meta.png
if (isset($item['socketdata']))
{
        // If exist more then one gem slot 
        if (is_array($item['socketdata']['socket'][0]))
        {
                foreach($item['socketdata']['socket'] as $x)
                {
                        $gem_data.= '<font color="#c9c9c9"><img src="'.$icons_url.'Socket_'.$x['color'].'.png">'.$x['color'].' '.LANG_SOCKET.'</font><br />';
        	}       
	}
        else 
	{
		$x = $item['socketdata']['socket'];
		$gem_data.= '<font color="#c9c9c9"><img src="'.$icons_url.'Socket_'.$x['color'].'.png">'.$x['color'].' '.LANG_SOCKET.'</font><br />';
	}

	if ($item['socketdata']['socketmatchenchant'])
	{
		$gem_data.= '<font color="#c9c9c9">'.LANG_SOCKET_BONUS.': '.$item['socketdata']['socketmatchenchant'].'</font><br />';
	}	
}

if (isset($item['gemproperties']))
{
	$gem_data.='<font color="#ffffff">'.$item['gemproperties'].'</font><br />';
}



// Build set DATA if Exist
if (isset($item['setdata']))
{
	$set_data .= '<br /><font color="#ffd517">'.$item['setdata']['name'].' (0/'.count($item['setdata']['item']).')</font><br />';
        foreach($item['setdata']['item'] as $i)
	{
		$set_data .= '<font color="#c9c9c9">'.$i['name'].'</font><br />';
	}
        //Build the set bonus, but first check if the set have mutiple bonus
        if (is_array($item['setdata']['setbonus'][0])) 
	{
		 $set_data .= '<br />';
		foreach($item['setdata']['setbonus'] as $b)
		{
			 $set_data .= '<font color="#c9c9c9">('.$b['threshold'].') '.$b['desc'].'</font><br />';
		}
	}
	else
	{
		$b = $item['setdata']['setbonus'];
		$set_data .= '<br /><font color="#c9c9c9">('.$b['threshold'].') '.$b['desc'].'</font><br />';
	}
}	
if (isset($item['desc']))
{
	$desc = '<font color="#ffd517">"'.$item['desc'].'"</font><br />';
}

// Initiate the template engine
$template = &new template('template/html/'.$conf_template.'/','item.html');

if ((isset($item['equipdata']['inventorytype']) || isset($item['equipdata']['subclassname'])) && !is_array($item['equipdata']['inventorytype']))
{
  $type_class = '<font color="#FFFFFF">'.value_slot($item['equipdata']['inventorytype']).'</font>';
  $type_class_sub = '<font color="#FFFFFF">'.$item['equipdata']['subclassname'].'</font>';

  if ($armory->getlang() != 'en')
  {
        $type_class     = utf8_decode($type_class);
        $type_class_sub     = utf8_decode($type_class_sub);
  }


  $template->loop('type_class', Array('tpl_type_class'=>$type_class,'tpl_type_class_sub'=>$type_class_sub));
  $template->fechaLoop();

}

if (isset($item['damagedata']['damage']))
{
  $damage_data = '<font color="#FFFFFF">'.$item['damagedata']['damage']['min'].'-'.$item['damagedata']['damage']['max'].' '.LANG_DAMAGE_DMG.'</font>';
  $damage_data_speed = '<font color="#FFFFFF"> '.LANG_DAMAGE_SPEED.' '.$item['damagedata']['speed'].'</font>';
  $damage_data_dps = '<font color="#FFFFFF">('.$item['damagedata']['dps'].' '.LANG_DAMAGE_DPS.')</font>';

  if ($armory->getlang() != 'en')
  {
        $damage_data= utf8_decode($damage_data);
        $damage_data_speed= utf8_decode($damage_data_speed);
        $damage_data_dps= utf8_decode($damage_data_dps);
  }


  $template->loop('damage_data', Array('tpl_damage_data'=>$damage_data,'tpl_damage_data_speed'=>$damage_data_speed,'tpl_damage_data_dps'=>$damage_data_dps));
  $template->fechaLoop();

}	

if (isset($item['bonding']))
{
	$bonding = '<font color="#FFFFFF">'.value_bound($item['bonding']).'</font> <br />';
}

// DECODE VALUES IF USING EURO ARMORY DE/FR/ES
if ($armory->getlang() != 'en')
{
	$item['name'] 	= utf8_decode($item['name']);
	$bonding 	= utf8_decode($bonding);	
	$require_data	= utf8_decode($require_data);
	$armor_data	= utf8_decode($armor_data);
	$gem_data	= utf8_decode($gem_data);
	$durability	= utf8_decode($durability);
	$spell_data	= utf8_decode($spell_data);
	$set_data	= utf8_decode($set_data);
	$desc		= utf8_decode($desc);
}

// define parameters for the class

$tags=array(
	'tpl_bonding'=>$bonding,
	'tpl_require_data'=>$require_data,
	'tpl_armor_data'=>$armor_data,
	'tpl_gem_data'=>$gem_data,
	'tpl_durability'=>$durability,
        'tpl_spell_data'=>$spell_data,
        'tpl_set_data'=>$set_data,
        'tpl_desc'=>$desc,
        'tpl_item_color'=>value_color($item['overallqualityid']),
        'tpl_item_name'=>$item['name'],
        'tpl_icon'=>$icons_url .'43x43/'.$item['icon'].'.png',
);

// parse template file
foreach($tags as $chave=>$valor){
        $template->atribuir($chave, $valor);
}
// display generated page
$template->ver();
?>
