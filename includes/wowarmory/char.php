<?php
/*
* Armory World of Warcraft Tooltip 
*
* Thiago Melo <ReiserFS>
* thiago@oxente.org
* http://thiago.oxente.org
* http://killermokeys.net
*
* MOD Info and Download: http://www.phpbb.com/community/viewtopic.php?f=70&t=576155
*
* Use: [char=RealmName]CharName[/wow]
*
*/

// Include Commom file
include("includes/common.php");
global $armver;

// Get the URL GET And decode
$var  = $_GET['v']; // Character Name
$var2 = $_GET['z']; // Realm/Server
$var3 = $_GET['l']; // Language
$var4 = $_GET['u']; // Armory URL

// Set the armory language
//$armory->setlang($var3);

// Get the char data from Armory
if ($armver == '020')
{
	$armory->lang = $var3;
	$armory->armory = $var4 . "/";
	$char = $armory->characterFetch($var, $var2);
	// Url for armory icons
	$avatar_url = $armory->armory . "images/portraits/";
	$icons_url  = $armory->armory . "images/icons/";
}
else
{
	$char = $armory->getCharacterData($var, $var2);	
	$armoryAreaData = $armory->getArea();
	// Url for armory icons
	$avatar_url = $armoryAreaData[1] . "images/portraits/";
	$icons_url  = $armoryAreaData[1] . "images/icons/";
}

//Output the Converted Character Array to File.
ob_start();
var_dump($char);
$data = ob_get_clean();
$stdoutfptr = fopen(getcwd() . "../../../cache/armory_log/char_data_array.html", "w+");
fwrite($stdoutfptr, $data);
fclose($stdoutfptr);

// Reduce the array name size, make more easy to work with the array.
$char = $char['characterinfo'];

if ((count($char) == 0) ||  ($char['errcode'] == 'noCharacter'))  die("<br /> <br /> ".LANG_ERROR_CONNECT." <br /> <br /> <br />");

//DEBUGGING
//print_r($char);
//die();

function value_color($v)
{
	switch($v)
	{
		case 0: return "#c9c9c9"; 
		case 1: return "#FFFFFF";
		case 2: return "#00FF00";
		case 3: return "#0070DD";
		case 4: return "#A335EE";
		case 5: return "#FF3300"; 
		case 6: return "#ffd517";
		case 7: return "#d80000"; 
		case 8: return "#d800cc"; 
		case 9: return "#ff88FF";
		case 10: return "#00F080";
		case 11: return "#FF0040";
		case 12: return "#FFBF00";
	}
}

function id_to_name($v)
{
	switch($v)
	{
		//Warlock
		case 9: return 'warlock';
		//Mage
		case 8: return 'mage';
		//Warrior
		case 1: return 'warrior';
		//Priest
		case 5: return 'priest';
		//Rogue
		case 4: return 'rogue';
		//Hunter
		case 3: return 'hunter';
		//Shaman
		case 7: return 'shaman';
		//Paladin
		case 2: return 'paladin';
		// Druid
		case 11: return 'druid';
		// DK
		case 6: return 'deathknight';
	}

}

function make_talent($tree,$class)
{
global $icons_url;
	switch($class)
	{
		//Warlock
		case 9:
                  	switch(max($tree['treeone'],$tree['treetwo'],$tree['treethree']))
                        {
                  	        case $tree['treeone']: $talent = LANG_TALENT_AFLIC; $img = 1; break;
                                case $tree['treetwo']: $talent = LANG_TALENT_DEMON; $img = 2; break;
                                case $tree['treethree']: $talent = LANG_TALENT_DEST; $img = 3; break;
                  	}					
		break;
		//Mage
		case 8:
                        switch(max($tree['treeone'],$tree['treetwo'],$tree['treethree']))
                        {
                                case $tree['treeone']: $talent = LANG_TALENT_ARCANE;  $img = 1; break;
                                case $tree['treetwo']: $talent = LANG_TALENT_FIRE;  $img = 2; break;
                                case $tree['treethree']: $talent = LANG_TALENT_FROST;  $img = 3; break;
                        }
		break;
		//Warrior
		case 1:
                        switch(max($tree['treeone'],$tree['treetwo'],$tree['treethree']))
                        {
                                case $tree['treeone']: $talent = LANG_TALENT_ARMS; $img = 1; break;
                                case $tree['treetwo']: $talent = LANG_TALENT_FURY; $img = 2; break;
                                case $tree['treethree']: $talent = LANG_TALENT_PROTECTION; $img = 3; break;
                        }
		break;
		//Priest
		case 5:
                        switch(max($tree['treeone'],$tree['treetwo'],$tree['treethree']))
                        {
                                case $tree['treeone']: $talent = LANG_TALENT_DISC;$img = 1; break;
                                case $tree['treetwo']: $talent = LANG_TALENT_HOLY;$img = 2; break;
                                case $tree['treethree']: $talent = LANG_TALENT_SHADOW; $img = 3;break;
                        }
		break;
		//Rogue
		case 4:
                        switch(max($tree['treeone'],$tree['treetwo'],$tree['treethree']))
                        {
                                case $tree['treeone']: $talent = LANG_TALENT_ASSASIN;  $img = 1; break;
                                case $tree['treetwo']: $talent = LANG_TALENT_COMBAT; $img = 2;  break;
                                case $tree['treethree']: $talent = LANG_TALENT_SUB;$img = 3; break;
                        }
		break;
		//Hunter
		case 3:
                        switch(max($tree['treeone'],$tree['treetwo'],$tree['treethree']))
                        {
                                case $tree['treeone']: $talent = LANG_TALENT_BEASTMASTER;$img = 1; break;
                                case $tree['treetwo']: $talent = LANG_TALENT_MARKS;$img = 2; break;
                                case $tree['treethree']: $talent = LANG_TALENT_SURVI;$img = 3;  break;
                        }
		break;
		//Shaman
		case 7:
                        switch(max($tree['treeone'],$tree['treetwo'],$tree['treethree']))
                        {
                                case $tree['treeone']: $talent = LANG_TALENT_ELEMEN; $img = 1;break;
                                case $tree['treetwo']: $talent = LANG_TALENT_ENHAN; $img = 2;break;
                                case $tree['treethree']: $talent = LANG_TALENT_REST;$img = 3;  break;
                        }
		break;
		//Paladin
		case 2:
                        switch(max($tree['treeone'],$tree['treetwo'],$tree['treethree']))
                        {
                                case $tree['treeone']: $talent = LANG_TALENT_HOLY;$img = 1; break;
                                case $tree['treetwo']: $talent = LANG_TALENT_PROTECTION;$img = 2;  break;
                                case $tree['treethree']: $talent = LANG_TALENT_RET;$img = 3;  break;
                        }
		break;
		// Druid
		case 11:
                        switch(max($tree['treeone'],$tree['treetwo'],$tree['treethree']))
                        {
                                case $tree['treeone']: $talent = LANG_TALENT_BALANCE;$img = 1; break;
                                case $tree['treetwo']: $talent = LANG_TALENT_FERAL; $img = 2; break;
                                case $tree['treethree']: $talent = LANG_TALENT_REST;$img = 3; break;
                        }
		break;
		
		// DK
		case 6:
						switch(max($tree['treeone'], $tree['treetwo'], $tree['treethree']))
						{
								case $tree['treeone']: $talent = LANG_TALENT_BLOOD;$img = 1; break;
                                case $tree['treetwo']: $talent = LANG_TALENT_FROST; $img = 2; break;
                                case $tree['treethree']: $talent = LANG_TALENT_UNHOLY;$img = 3; break;
						}
		break;
	}

	$talent = '<font color="#ffd517">' . $talent . '</font> <font color="#ffffff">'. $tree['treeone'] . '/' . $tree['treetwo'] . '/' . $tree['treethree'] . '</font>';

	$talent = strtoupper($talent);
	$talent = '<img vpsace="0" hspace="0" align="middle" src="'.$icons_url.'class/'.$class.'/talents/'.$img.'.gif"> '.$talent;

	return $talent;
}

function make_extra_data()
{
  // To change the fields by class edit the stats_conf/ files
  // each class have a separated config.

	global $char;
	$stamina = $char['charactertab']['basestats']['stamina']['effective'] . " (" . $char['charactertab']['basestats']['stamina']['base'] . " + " . ($char['charactertab']['basestats']['stamina']['effective'] - $char['charactertab']['basestats']['stamina']['base']) . ")";
	$intellect = $char['charactertab']['basestats']['intellect']['effective'] . " (" . $char['charactertab']['basestats']['intellect']['base'] . " + " . ($char['charactertab']['basestats']['intellect']['effective'] - $char['charactertab']['basestats']['intellect']['base']) . ")";
	$strength = $char['charactertab']['basestats']['strength']['effective'] . " (" . $char['charactertab']['basestats']['strength']['base'] . " + " . ($char['charactertab']['basestats']['strength']['effective'] - $char['charactertab']['basestats']['strength']['base']) . ")";
	$agility = $char['charactertab']['basestats']['agility']['effective'] . " (" . $char['charactertab']['basestats']['agility']['base'] . " + " . ($char['charactertab']['basestats']['agility']['effective'] - $char['charactertab']['basestats']['agility']['base']) . ")";
	$spirit = $char['charactertab']['basestats']['spirit']['effective'] . " (" . $char['charactertab']['basestats']['spirit']['base'] . " + " . ($char['charactertab']['basestats']['spirit']['effective'] - $char['charactertab']['basestats']['spirit']['base']) . ")";
	$armor = $char['charactertab']['basestats']['armor']['effective'] . " (" . $char['charactertab']['basestats']['armor']['base'] . " + " . ($char['charactertab']['basestats']['armor']['effective'] - $char['charactertab']['basestats']['armor']['base']) . ")";


			$extradata['health'] = Array(	 
                                                'field' => LANG_HP,
                       				'value' => $char['charactertab']['characterbars']['health']['effective'],
                                    		'color' => value_color(7)
                                           );
                        $extradata['secondbar'] = Array(   
                                                'field' => LANG_MP,
                                                'value' => $char['charactertab']['characterbars']['secondbar']['effective'],
                                                'color' => value_color(3)
                                            );
                        $extradata['stamina'] = Array(   
                                                'field' => LANG_STATS_STA,
                                                'value' => $stamina, 
                                                'color' => value_color(2)
                                            );
                        $extradata['intellect'] = Array(   
                                                'field' => LANG_STATS_INT,
                                                'value' => $intellect, 
                                                'color' => value_color(2)
                                            );
                        $extradata['strength'] = Array(   
                                                'field' => LANG_STATS_STR,
                                                'value' => $strength,
                                                'color' => value_color(2)
                                            );
                        $extradata['armor'] = Array(   
                                                'field' => LANG_STATS_ARMOR,
                                                'value' => $armor,
                                                'color' => value_color(2)
                                            );
                        $extradata['agility'] = Array(   
                                                'field' => LANG_STATS_AGI,
                                                'value' => $agility,
                                                'color' => value_color(2)
                                            );
                        $extradata['spirit'] = Array(   
                                                'field' => LANG_STATS_SPI,
                                                'value' => $spirit,
                                                'color' => value_color(2)
                                            );                                                                                        
                        $extradata['shadow_power'] = Array(   
                                                'field' => LANG_SHADOW_DMG,
                                                'value' => $char['charactertab']['spell']['bonusdamage']['shadow']['value'],
                                                'color' => value_color(4)
                                            );
                        $extradata['shadow_crit'] = Array(   
                                                'field' => LANG_SHADOW_CRIT,
                                                'value' => $char['charactertab']['spell']['critchance']['shadow']['percent']."%",
                                                'color' => value_color(4)
                                            );
                        $extradata['fire_power'] = Array(   
                                                'field' => LANG_FIRE_DMG,
                                                'value' => $char['charactertab']['spell']['bonusdamage']['fire']['value'],
                                                'color' => value_color(5)
                                            );
                        $extradata['fire_crit'] = Array(   
                                                'field' => LANG_FIRE_CRIT,
                                                'value' => $char['charactertab']['spell']['critchance']['fire']['percent']."%",
                                                'color' => value_color(5)
                                            );
                        $extradata['frost_power'] = Array(   
                                                'field' => LANG_FROST_DMG,
                                                'value' => $char['charactertab']['spell']['bonusdamage']['frost']['value'],
                                                'color' => value_color(3)
                                            );
                        $extradata['frost_crit'] = Array(   
                                                'field' => LANG_FROST_CRIT,
                                                'value' => $char['charactertab']['spell']['critchance']['frost']['percent']."%",
                                                'color' => value_color(3)
                                            );
                        $extradata['arcane_power'] = Array(   
                                                'field' => LANG_ARCANE_DMG,
                                                'value' => $char['charactertab']['spell']['bonusdamage']['arcane']['value'],
                                                'color' => value_color(8)
                                            );
                        $extradata['arcane_crit'] = Array(   
                                                'field' => LANG_ARCANE_CRIT,
                                                'value' => $char['charactertab']['spell']['critchance']['arcane']['percent']."%",
                                                'color' => value_color(8)
                                            );
                        $extradata['nature_power'] = Array(   
                                                'field' => LANG_NATURE_DMG,
                                                'value' => $char['charactertab']['spell']['bonusdamage']['nature']['value'],
                                                'color' => value_color(5)
                                            );
                        $extradata['nature_crit'] = Array(   
                                                'field' => LANG_NATURE_CRIT,
                                                'value' => $char['charactertab']['spell']['critchance']['nature']['percent']. "%",
                                                'color' => value_color(5)
                                            ); 
                        $extradata['holy_power'] = Array(   
                                                'field' => LANG_HOLY_DMG,
                                                'value' => $char['charactertab']['spell']['bonusdamage']['holy']['value'],
                                                'color' => value_color(5)
                                            );
                        $extradata['holy_crit'] = Array(   
                                                'field' => LANG_HOLY_CRIT,
                                                'value' => $char['charactertab']['spell']['critchance']['holy']['percent']. "%",
                                                'color' => value_color(5)
                                            );                                                                                        
                        $extradata['spell_hit_rating'] = Array(   
                                                'field' => LANG_SPELL_HIT,
                                                'value' => $char['charactertab']['spell']['hitrating']['value'],
                                                'color' => value_color(6)
                                            );
                        $extradata['penetration'] = Array(   
                                                'field' => LANG_SPELL_PENETRATION,
                                                'value' => $char['charactertab']['spell']['penetration']['value'],
                                                'color' => value_color(6)
                                            );
                        $extradata['melee_main_dmg'] = Array(   
                                                'field' => LANG_MELEEMAIN_DMG,
                                                'value' => $char['charactertab']['melee']['mainhanddamage']['max'] . "-" .$char['charactertab']['melee']['mainhanddamage']['min'],
                                                'color' => value_color(3)
                                            );
                        $extradata['melee_main_speed'] = Array(   
                                                'field' => LANG_MELEEMAIN_SPEED,
                                                'value' => $char['charactertab']['melee']['mainhanddamage']['speed'],
                                                'color' => value_color(3)
                                            );                                            
                        $extradata['melee_main_dps'] = Array(   
                                                'field' => LANG_MELEEMAIN_DPS,
                                                'value' => $char['charactertab']['melee']['mainhanddamage']['dps'],
                                                'color' => value_color(3)
                                            );
                        $extradata['melee_off_dmg'] = Array(   
                                                'field' => LANG_MELEEOFF_DMG,
                                                'value' => $char['charactertab']['melee']['offhanddamage']['max'] . "-" .$char['charactertab']['melee']['offhanddamage']['min'],
                                                'color' => value_color(10)
                                            );
                        $extradata['melee_off_speed'] = Array(   
                                                'field' => LANG_MELEEMAIN_SPEED,
                                                'value' => $char['charactertab']['melee']['offhanddamage']['speed'],
                                                'color' => value_color(10)
                                            );                                               
                        $extradata['melee_off_dps'] = Array(   
                                                'field' => LANG_MELEEOFF_DPS,
                                                'value' => $char['charactertab']['melee']['offhanddamage']['dps'],
                                                'color' => value_color(10)
                                          );

                        $extradata['melee_power'] = Array(   
                                                'field' => LANG_MELEE_POWER,
                                                'value' => $char['charactertab']['melee']['power']['effective'],
                                                'color' => value_color(3)
                                          );
                        $extradata['melee_hit_rating'] = Array(   
                                                'field' => LANG_MELEE_HIT,
                                                'value' => $char['charactertab']['melee']['hitrating']['value'],
                                                'color' => value_color(3)
                                                              );
                        $extradata['melee_crit'] = Array(   
                                                'field' => LANG_MELEE_CRIT,
                                                'value' => $char['charactertab']['melee']['critchance']['rating'],
                                                'color' => value_color(3)
                                                              );                  			                  			
                        $extradata['melee_expertise'] = Array(   
                                                'field' => LANG_MELEE_EXPER,
                                                'value' => $char['charactertab']['melee']['expertise']['value'],
                                                'color' => value_color(3)
                                                              );                                     			
                        $extradata['defense'] = Array(  
                                                'field' => LANG_STATS_DEFENSE,
                                                'value' => $char['charactertab']['defenses']['defense']['value'] + $char['charactertab']['defenses']['defense']['plusdefense'],
                                                'color' => value_color(6)
                                            );
                        $extradata['block'] = Array(   
                                                'field' => LANG_RATING_BLOCK,
                                                'value' => $char['charactertab']['defenses']['block']['rating'],
                                                'color' => value_color(6)
                                            );
                        $extradata['dodge'] = Array(   
                                                'field' => LANG_RATING_DODGE,
                                                'value' => $char['charactertab']['defenses']['dodge']['rating'],
                                                'color' => value_color(6)
                                            );
                        $extradata['parry'] = Array(   
                                                'field' => LANG_RATING_PARRY,
                                                'value' => $char['charactertab']['defenses']['parry']['rating'],
                                                'color' => value_color(6)
                                            ); 
                        $extradata['resilience'] = Array(   
                                                'field' => LANG_STATS_RESILIENCE,
                                                'value' => $char['charactertab']['defenses']['resilience']['value'],
                                                'color' => value_color(6)
                                            );                                                                                            

                        $extradata['healing'] = Array(   
                                                'field' => LANG_HEAL,
                                                'value' => $char['charactertab']['spell']['bonushealing']['value'],
                                                'color' => value_color(9)
                                            );
                        $extradata['mana_regen'] = Array(   
                                                'field' => LANG_MANA_REGEN,
                                                'value' => $char['charactertab']['spell']['manaregen']['notcasting'],
                                                'color' => value_color(9)
                                            );
                        $extradata['mana_regen_cast'] = Array(   
                                                'field' => LANG_MANA_REGEN_CAST,
                                                'value' => $char['charactertab']['spell']['manaregen']['casting'],
                                                'color' => value_color(9)
                                            );
                        $extradata['ranged_dmg'] = Array(   
                                                'field' => LANG_RANGED_DMG,
                                                'value' => $char['charactertab']['ranged']['damage']['max'] . "-" .$char['charactertab']['ranged']['damage']['min'],
                                                'color' => value_color(5)
                                            );
                        $extradata['ranged_dps'] = Array(   
                                                'field' => LANG_RANGED_DPS,
                                                'value' => $char['charactertab']['ranged']['damage']['dps'],
                                                'color' => value_color(5)
                                            );
                        $extradata['ranged_crit'] = Array(   
                                                'field' => LANG_RANGED_CRIT,
                                                'value' => $char['charactertab']['ranged']['critchance']['percent'],
                                                'color' => value_color(5)
                                            );
                        $extradata['ranged_speed'] = Array(   
                                                'field' => LANG_RANGED_SPEED,
                                                'value' => $char['charactertab']['ranged']['speed']['value'],
                                                'color' => value_color(5)
                                            );
                        $extradata['ranged_hit_rating'] = Array(   
                                                'field' => LANG_RANGED_HIT,
                                                'value' => $char['charactertab']['ranged']['hitrating']['value'],
                                                'color' => value_color(5)
                                            );                                             
                        $extradata['ranged_power'] = Array(   
                                                'field' => LANG_RANGED_POWER,
                                                'value' => $char['charactertab']['ranged']['power']['effective'],
                                                'color' => value_color(5)
                                            ); 

return $extradata;
}

// Create the Avatar URL
$avatar = $avatar_url;
if ($char['character']['level'] == 70)
{
	$avatar .= "wow-70/";
}
elseif ($char['character']['level'] < 70 && $char['character']['level'] > 59)
{
	$avatar .= "wow/";
}
else
{
	$avatar .= "wow-default/";
}
$avatar .= $char['character']['genderid'] . '-' . $char['character']['raceid'] . '-' . $char['character']['classid'] . '.gif';

//Create the Talent info
if (isset($char['charactertab']['talentspecs']['talentspec']['group']))
{   // Character only has one spec, ONLY set primary spec, secondary is blank.
	$pri_talent_data = make_talent($char['charactertab']['talentspecs']['talentspec'],$char['character']['classid']); 
	$sec_talent_data = "";	
}
 
else if ($char['charactertab']['talentspecs']['talentspec'][0]['active'])
{   // Character has 2 specs, spec 1 is the active spec.
	$pri_talent_data = make_talent($char['charactertab']['talentspecs']['talentspec'][0],$char['character']['classid']); 
	$sec_talent_data = make_talent($char['charactertab']['talentspecs']['talentspec'][1],$char['character']['classid']);
}
else
{   // Character has 2 specs, spec 2 is the active spec.
	$pri_talent_data = make_talent($char['charactertab']['talentspecs']['talentspec'][1],$char['character']['classid']); 
	$sec_talent_data = make_talent($char['charactertab']['talentspecs']['talentspec'][0],$char['character']['classid']);
}

if(is_array($char['charactertab']['buffs']['spell'][0]))
{
	$buffs = '';
	foreach($char['charactertab']['buffs']['spell'] as $buf)
	{
	   $buffs .= "<img src='" . $icons_url . "/21x21/" . $buf['icon'] . ".png' vspace='0' hspace='0'> ";
	}
}
elseif(isset( $char['charactertab']['buffs']['spell']['icon'])) 
{
	$buffs = "<img src='" . $icons_url . "/21x21/" . $char['charactertab']['buffs']['spell']['icon'] . ".png' vspace='0' hspace='0'> ";
}

// Include the Stats conf File by class
$class_name = id_to_name($char['character']['classid']);
include_once('stats_conf/'.$class_name.'.php');

// Initiate the template engine
$template = &new template('template/html/'.$conf_template.'/','char.html');

//CREATE DATA STATS
$extradata = make_extra_data();

// MAKE THE TABLES WITH THE STATS
if (is_array($stats_conf))
{
        foreach($stats_conf as $x)
        {
            $tags = array(
			'tpl_data_color' => $extradata[$x]['color'],
			'tpl_data_field' => $extradata[$x]['field'],
			'tpl_data_value' => $extradata[$x]['value'],
	      );	
		$template->loop('body_field', $tags);
	}
	$template->fechaLoop();
}

// define parameters for the class
if ($class_name == 'warrior') $extradata['secondbar']['color'] = '#FF0040';
if ($class_name == 'rogue') $extradata['secondbar']['color'] = '#FFBF00';

$tags=array(
	'tpl_health'=> $extradata['health']['value'],
        'tpl_secondbar' => $extradata['secondbar']['value'],
        'tpl_secondbar_color' => $extradata['secondbar']['color'],
        'tpl_avatar'=>$avatar,
        'tpl_char_character_name'=>$char['character']['name'],
        'tpl_char_character_guildname'=>($char['character']['guildname']) ? $char['character']['guildname'] : " &nbsp; ",
        'tpl_char_character_level'=>$char['character']['level'],
        'tpl_char_character_race'=>strtoupper($char['character']['race']),
        'tpl_char_character_class'=>strtoupper($char['character']['class']),
        'tpl_pri_talent_data'=>$pri_talent_data,
		'tpl_sec_talent_data'=>$sec_talent_data,
        'tpl_buffs'=>$buffs,
        'tpl_icons_professions_0'=>$icons_url . "professions/" . $char['charactertab']['professions']['skill'][0]['key'] . "-sm.gif",
        'tpl_char_charactertab_professions_skill_0_name'=>$char['charactertab']['professions']['skill'][0]['name'],
        'tpl_char_charactertab_professions_skill_0_value'=>$char['charactertab']['professions']['skill'][0]['value'],
        'tpl_char_charactertab_professions_skill_0_max'=>$char['charactertab']['professions']['skill'][0]['max'],
        'tpl_icons_professions_1'=>$icons_url . "professions/" . $char['charactertab']['professions']['skill'][1]['key'] . "-sm.gif",
        'tpl_char_charactertab_professions_skill_1_name'=>$char['charactertab']['professions']['skill'][1]['name'],
        'tpl_char_charactertab_professions_skill_1_value'=>$char['charactertab']['professions']['skill'][1]['value'],
        'tpl_char_charactertab_professions_skill_1_max'=>$char['charactertab']['professions']['skill'][1]['max'],        

);

// parse template file
foreach($tags as $chave=>$valor){
	$template->atribuir($chave, $valor); 
}
// display generated page
$template->ver();
?>
