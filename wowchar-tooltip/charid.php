<table cellpadding='0' border='0' class='tooltip_new_char'>
  <tr>
    <td>
<?php
include("config.php");
if (!file_exists('lang/'.$_GET['lang'].'.php')) {
	die('Language ('.$_GET['lang'].') not found!</td></tr></table>');
}
include("lang/".$_GET['lang'].".php");

function & xmlToArray($xmlData, $includeTopTag = false, $lowerCaseTags = true){

	$xmlArray = array();

	$parser = xml_parser_create();
	xml_parse_into_struct($parser, $xmlData, $vals, $index);
	xml_parser_free($parser);

	$temp = $depth = array();

	foreach ($vals as $value) {

		switch ($value['type']) {

			case 'open':
			case 'complete':
				array_push($depth, $value['tag']);
				$p = join('::', $depth);
				if ($lowerCaseTags) {
					$p = strtolower($p);
					if (is_array($value['attributes']))
					$value['attributes'] = array_change_key_case($value['attributes']);
				}
				$data = ( isset($value['attributes']) ? array($value['attributes']) : array());
				$data = ( trim($value['value']) ? array_merge($data, array($value['value'])) : $data);
				if (isset($temp[$p])) $temp[$p] = array_merge($temp[$p], $data);
				else $temp[$p] = $data;
				if ($value['type']=='complete') array_pop($depth);
				break;

			case 'close':
				array_pop($depth);
				break;

		}

	}

	if (!$includeTopTag) unset($temp["page"]);

	foreach ($temp as $key => $value) {

		if (count($value)==1) { $value = reset($value); }

		$levels = explode('::', $key);
		$num_levels = count($levels);

		if ($num_levels==1) {
			$xmlArray[$levels[0]] = $value;
		} else {
			$pointer = &$xmlArray;
			for ($i=0; $i<$num_levels; $i++) {
				if ( !isset( $pointer[$levels[$i]] ) ) {
					$pointer[$levels[$i]] = array();
				}
				$pointer = &$pointer[$levels[$i]];
			}
			$pointer = $value;
		}

	}

	return ($includeTopTag ? $xmlArray : reset($xmlArray));

}
function xmlFetch($url, $lang = "de"){

	if (function_exists('curl_init')){
		$ch = curl_init();

		curl_setopt ($ch, CURLOPT_URL, $url);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, '10');
		curl_setopt ($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; de-DE; rv:1.8.1.1) Gecko/20061204 Firefox/2.0.0.1');
		curl_setopt ($ch, CURLOPT_HEADER, 0);
		curl_setopt ($ch, CURLOPT_HTTPHEADER, array("Accept-Language: ".$lang));

		$f = curl_exec($ch);

		curl_close($ch);

	} elseif(ini_get('allow_url_fopen') == 1) {
		$contextOptions = array('http'=>array('method'=>"GET",'header'=>"Accept-language: ".$lang."\r\n" . "User-Agent: Mozilla/5.0 (Windows; U; Windows NT 5.1; de-DE; rv:1.8.1.1) Gecko/20061204 Firefox/2.0.0.1\r\n"));
		$context = stream_context_create($contextOptions);
		$f = '';
		$handle = fopen($url, 'r', false, $context);
		while(!feof($handle))
		{
			$f .= fgets($handle);
		}
		fclose ($handle);
		return $f;
	} elseif(function_exists('stream_context_create') && function_exists('file_get_contents')) {
		$contextOptions = array('http'=>array('method'=>"GET",'header'=>"Accept-language: ".$lang."\r\n" . "User-Agent: Mozilla/5.0 (Windows; U; Windows NT 5.1; de-DE; rv:1.8.1.1) Gecko/20061204 Firefox/2.0.0.1\r\n"));
		$context = stream_context_create($contextOptions);
		$f = file_get_contents($url,false, $context);
	} else {
		die('There couldn\'t be found any function on your server, which work!<br /><br />Try this functions:<br />- curl<br />- file_get_contents with stream_context_create<br />- fopen with stream_context_create<br /><br />Ask your hoster to activate these functions.');
	}

	return $f;

}
function make_talent($tree,$class)
	{
		global $icons_url,$lang;
		switch($class)
		{
			//Warlock
			case 9:
				switch(max($tree['treeone'],$tree['treetwo'],$tree['treethree']))
				{
					case $tree['treeone']: $talent = $lang['warlock.treeone']; $img = 1; break;
					case $tree['treetwo']: $talent = $lang['warlock.treetwo']; $img = 2; break;
					case $tree['treethree']: $talent = $lang['warlock.treethree']; $img = 3; break;
				}
				break;
				//Mage
			case 8:
				switch(max($tree['treeone'],$tree['treetwo'],$tree['treethree']))
				{
					case $tree['treeone']: $talent = $lang['mage.treeone'];  $img = 1; break;
					case $tree['treetwo']: $talent = $lang['mage.treetwo'];  $img = 2; break;
					case $tree['treethree']: $talent = $lang['mage.treethree'];  $img = 3; break;
				}
				break;
				//Warrior
			case 1:
				switch(max($tree['treeone'],$tree['treetwo'],$tree['treethree']))
				{
					case $tree['treeone']: $talent = $lang['warrior.treeone']; $img = 1; break;
					case $tree['treetwo']: $talent = $lang['warrior.treetwo']; $img = 2; break;
					case $tree['treethree']: $talent = $lang['warrior.treethree']; $img = 3; break;
				}
				break;
				//Priest
			case 5:
				switch(max($tree['treeone'],$tree['treetwo'],$tree['treethree']))
				{
					case $tree['treeone']: $talent = $lang['priest.treeone'];	$img = 1; break;
					case $tree['treetwo']: $talent = $lang['priest.treetwo'];	$img = 2; break;
					case $tree['treethree']: $talent = $lang['priest.treethree']; $img = 3;break;
				}
				break;
				//Rogue
			case 4:
				switch(max($tree['treeone'],$tree['treetwo'],$tree['treethree']))
				{
					case $tree['treeone']: $talent = $lang['rogue.treeone']; $img = 1; break;
					case $tree['treetwo']: $talent = $lang['rogue.treetwo']; $img = 2;  break;
					case $tree['treethree']: $talent = $lang['rogue.treethree']; $img = 3; break;
				}
				break;
				//Hunter
			case 3:
				switch(max($tree['treeone'],$tree['treetwo'],$tree['treethree']))
				{
					case $tree['treeone']: $talent = $lang['hunter.treeone']; $img = 1; break;
					case $tree['treetwo']: $talent = $lang['hunter.treetwo']; $img = 2; break;
					case $tree['treethree']: $talent = $lang['hunter.treethree']; $img = 3;  break;
				}
				break;
				//Shaman
			case 7:
				switch(max($tree['treeone'],$tree['treetwo'],$tree['treethree']))
				{
					case $tree['treeone']: $talent = $lang['shaman.treeone']; $img = 1;break;
					case $tree['treetwo']: $talent = $lang['shaman.treetwo']; $img = 2;break;
					case $tree['treethree']: $talent = $lang['shaman.treethree']; $img = 3;  break;
				}
				break;
				//Paladin
			case 2:
				switch(max($tree['treeone'],$tree['treetwo'],$tree['treethree']))
				{
					case $tree['treeone']: $talent = $lang['paladin.treeone']; $img = 1; break;
					case $tree['treetwo']: $talent = $lang['paladin.treetwo']; $img = 2;  break;
					case $tree['treethree']: $talent = $lang['paladin.treethree']; $img = 3;  break;
				}
				break;
				// Druid
			case 11:
				switch(max($tree['treeone'],$tree['treetwo'],$tree['treethree']))
				{
					case $tree['treeone']: $talent = $lang['druid.treeone']; $img = 1; break;
					case $tree['treetwo']: $talent = $lang['druid.treetwo']; $img = 2; break;
					case $tree['treethree']: $talent = $lang['druid.treethree']; $img = 3; break;
				}
				break;
		}
		$talent = $talent.' ('.$tree['treeone'].'/'.$tree['treetwo'].'/'.$tree['treethree'].')';
		//$talent = '<img src="' . ARMORY . '/images/icons/class/'.$class.'/talents/'.$img.'.gif" align="middle"> '.$talent;

		return $talent;
}

$r = str_replace("\'","'",$_GET['r']);
$filename = 'cache/'.preg_replace("/[^a-zA-Z0-9]/", "-", $r).'-'.preg_replace("/[^a-zA-Z0-9]/", "-", $_GET['n']).'-'.$_GET['lang'].'-tooltip.html';
if(file_exists($filename) && trim(file_get_contents($filename))!="" && time()-filemtime($filename) < 21600)
{
	echo file_get_contents($filename);
}
else
{
	$arr = xmlToArray(xmlFetch(ARMORY . "/character-sheet.xml?r=".urlencode($r)."&n=".urlencode($_GET['n']),$_GET['lang']));
	/*
	print("<pre>");
	print_r($arr);
	print("</pre>");
	*/
	if($arr['characterinfo']['character']['level']>="1" && $arr['characterinfo']['character']['level']<="59")
	{
		$level = "1-59";
	}
	elseif($arr['characterinfo']['character']['level']>="60" && $arr['characterinfo']['character']['level']<="69")
	{
		$level = "60-69";
	}
	else
	{
		$level = "70";
	}
	$tooltip = "<div><table width='100%' border='0' cellspacing='0' cellpadding='0'>
      <tr>
        <td align='left' valign='top' width='68' height='68'><img src='wowchar-tooltip/image/portraits/".$level."/".$arr['characterinfo']['character']['genderid']."-".$arr['characterinfo']['character']['raceid']."-".$arr['characterinfo']['character']['classid'].".gif' alt='Portrait' /></td>
        <td align='left' valign='top'>";

	if(isset($arr['characterinfo']['character']['prefix']) && $arr['characterinfo']['character']['prefix']!="")
	{
		$tooltip .= $arr['characterinfo']['character']['prefix']." ";
	}

	$tooltip .= "<strong style='font-size:14px'>".$arr['characterinfo']['character']['name']."</strong>";

	if(isset($arr['characterinfo']['character']['suffix']) && $arr['characterinfo']['character']['suffix']!="")
	{
		$tooltip .= $arr['characterinfo']['character']['suffix']." ";
	}

	$tooltip .= "<br />";

	if(isset($arr['characterinfo']['character']['guildname']) && $arr['characterinfo']['character']['guildname']!="")
	{
		$tooltip .= "&lt;".$arr['characterinfo']['character']['guildname']."&gt;<br />";
		$guildname = $arr['characterinfo']['character']['guildname'];
	}
	else
	{
		$guildname = '';
	}

	if($_GET['lang']=="fr" || $_GET['lang']=="es")
	{
		$tooltip .= $lang['race'][$arr['characterinfo']['character']['genderid']][$arr['characterinfo']['character']['raceid']]." ".$lang['class'][$arr['characterinfo']['character']['genderid']][$arr['characterinfo']['character']['classid']]." ".$lang['level']." ".$arr['characterinfo']['character']['level'];
	}
	elseif($_GET['lang']=="ko")
	{
		$tooltip .= $arr['characterinfo']['character']['level']." ".$lang['level']." ".$lang['race'][$arr['characterinfo']['character']['genderid']][$arr['characterinfo']['character']['raceid']]." ".$lang['class'][$arr['characterinfo']['character']['genderid']][$arr['characterinfo']['character']['classid']];
	}
	else
	{
		$tooltip .= $lang['level']." ".$arr['characterinfo']['character']['level']." ".$lang['race'][$arr['characterinfo']['character']['genderid']][$arr['characterinfo']['character']['raceid']]." ".$lang['class'][$arr['characterinfo']['character']['genderid']][$arr['characterinfo']['character']['classid']];
	}

	$tooltip .= "<br />".make_talent($arr['characterinfo']['charactertab']['talentspec'],$arr['characterinfo']['character']['classid'])."</td>
      </tr>
      <tr>
        <td colspan='2'><table width='100%' border='0' cellspacing='1' cellpadding='1'>";

	if($arr['characterinfo']['character']['classid']=="1")  //Krieger
	{
		$extras[] = array('name'=>$lang['health'],
						  'wert'=>$arr['characterinfo']['charactertab']['characterbars']['health']['effective']);
		if($arr['characterinfo']['charactertab']['talentspec']['treethree'] > $arr['characterinfo']['charactertab']['talentspec']['treetwo'] &&
		   $arr['characterinfo']['charactertab']['talentspec']['treethree'] > $arr['characterinfo']['charactertab']['talentspec']['treeone'])
		{
			$extras[] = array('name'=>'<strong>'.$lang['title.defense'].'</strong>',
							  'wert'=>'hr');
			$extras[] = array('name'=>$lang['armor'],
							  'wert'=>$arr['characterinfo']['charactertab']['defenses']['armor']['base']);
			$extras[] = array('name'=>$lang['defense'],
							  'wert'=>($arr['characterinfo']['charactertab']['defenses']['defense']['plusdefense']+$arr['characterinfo']['charactertab']['defenses']['defense']['value']));
			$extras[] = array('name'=>$lang['dodge'],
							  'wert'=>$arr['characterinfo']['charactertab']['defenses']['dodge']['percent'].'%');
			$extras[] = array('name'=>$lang['parry'],
							  'wert'=>$arr['characterinfo']['charactertab']['defenses']['parry']['percent'].'%');
			$extras[] = array('name'=>$lang['block'],
							  'wert'=>$arr['characterinfo']['charactertab']['defenses']['block']['percent'].'%');
			$extras[] = array('name'=>$lang['resilience'],
							  'wert'=>$arr['characterinfo']['charactertab']['defenses']['resilience']['value']);
		}
		if($arr['characterinfo']['charactertab']['talentspec']['treetwo'] > $arr['characterinfo']['charactertab']['talentspec']['treethree'] ||
		   $arr['characterinfo']['charactertab']['talentspec']['treeone'] > $arr['characterinfo']['charactertab']['talentspec']['treethree'])
		{
			$extras[] = array('name'=>'<strong>'.$lang['title.melee'].'</strong>',
							  'wert'=>'hr');
			$extras[] = array('name'=>$lang['power'],
							  'wert'=>$arr['characterinfo']['charactertab']['melee']['power']['effective']);
			$extras[] = array('name'=>$lang['hitrating'],
							  'wert'=>$arr['characterinfo']['charactertab']['melee']['hitrating']['value']);
			$extras[] = array('name'=>$lang['critchance'],
							  'wert'=>$arr['characterinfo']['charactertab']['melee']['critchance']['percent'].'%');
			$extras[] = array('name'=>$lang['expertise'],
							  'wert'=>$arr['characterinfo']['charactertab']['melee']['expertise']['value']);
			$extras[] = array('name'=>'<strong>'.$lang['title.defense'].'</strong>',
							  'wert'=>'hr');
			$extras[] = array('name'=>$lang['resilience'],
							  'wert'=>$arr['characterinfo']['charactertab']['defenses']['resilience']['value']);
		}
	}
	elseif($arr['characterinfo']['character']['classid']=="2") //Paladin
	{
		$extras[] = array('name'=>$lang['health'],
						  'wert'=>$arr['characterinfo']['charactertab']['characterbars']['health']['effective']);
		$extras[] = array('name'=>$lang['mana'],
						  'wert'=>$arr['characterinfo']['charactertab']['characterbars']['secondbar']['effective']);
		if($arr['characterinfo']['charactertab']['talentspec']['treetwo'] > $arr['characterinfo']['charactertab']['talentspec']['treethree'] &&
		   $arr['characterinfo']['charactertab']['talentspec']['treetwo'] > $arr['characterinfo']['charactertab']['talentspec']['treeone'])
		{
			$extras[] = array('name'=>'<strong>'.$lang['title.defense'].'</strong>',
							  'wert'=>'hr');
			$extras[] = array('name'=>$lang['armor'],
							  'wert'=>$arr['characterinfo']['charactertab']['defenses']['armor']['base']);
			$extras[] = array('name'=>$lang['defense'],
							  'wert'=>($arr['characterinfo']['charactertab']['defenses']['defense']['plusdefense']+$arr['characterinfo']['charactertab']['defenses']['defense']['value']));
			$extras[] = array('name'=>$lang['dodge'],
							  'wert'=>$arr['characterinfo']['charactertab']['defenses']['dodge']['percent'].'%');
			$extras[] = array('name'=>$lang['parry'],
							  'wert'=>$arr['characterinfo']['charactertab']['defenses']['parry']['percent'].'%');
			$extras[] = array('name'=>$lang['block'],
							  'wert'=>$arr['characterinfo']['charactertab']['defenses']['block']['percent'].'%');
			$extras[] = array('name'=>$lang['resilience'],
							  'wert'=>$arr['characterinfo']['charactertab']['defenses']['resilience']['value']);
			$extras[] = array('name'=>'<strong>'.$lang['title.spell'].'</strong>',
							  'wert'=>'hr');
			$extras[] = array('name'=>$lang['damage'],
							  'wert'=>$arr['characterinfo']['charactertab']['spell']['bonusdamage']['holy']['value']);
		}
		if($arr['characterinfo']['charactertab']['talentspec']['treethree'] > $arr['characterinfo']['charactertab']['talentspec']['treetwo'] &&
		   $arr['characterinfo']['charactertab']['talentspec']['treethree'] > $arr['characterinfo']['charactertab']['talentspec']['treeone'])
		{
			$extras[] = array('name'=>'<strong>'.$lang['title.melee'].'</strong>',
							  'wert'=>'hr');
			$extras[] = array('name'=>$lang['power'],
							  'wert'=>$arr['characterinfo']['charactertab']['melee']['power']['effective']);
			$extras[] = array('name'=>$lang['hitrating'],
							  'wert'=>$arr['characterinfo']['charactertab']['melee']['hitrating']['value']);
			$extras[] = array('name'=>$lang['critchance'],
							  'wert'=>$arr['characterinfo']['charactertab']['melee']['critchance']['percent'].'%');
			$extras[] = array('name'=>$lang['expertise'],
							  'wert'=>$arr['characterinfo']['charactertab']['melee']['expertise']['value']);
			$extras[] = array('name'=>'<strong>'.$lang['title.defense'].'</strong>',
							  'wert'=>'hr');
			$extras[] = array('name'=>$lang['resilience'],
							  'wert'=>$arr['characterinfo']['charactertab']['defenses']['resilience']['value']);
		}
		if($arr['characterinfo']['charactertab']['talentspec']['treeone'] > $arr['characterinfo']['charactertab']['talentspec']['treetwo'] &&
		   $arr['characterinfo']['charactertab']['talentspec']['treeone'] > $arr['characterinfo']['charactertab']['talentspec']['treethree'])
		{
			$extras[] = array('name'=>'<strong>'.$lang['title.spell'].'</strong>',
							  'wert'=>'hr');
			$extras[] = array('name'=>$lang['healing'],
							  'wert'=>$arr['characterinfo']['charactertab']['spell']['bonushealing']['value']);
			$extras[] = array('name'=>$lang['hitrating'],
							  'wert'=>$arr['characterinfo']['charactertab']['spell']['hitrating']['value']);
			$extras[] = array('name'=>$lang['critchance'],
							  'wert'=>$arr['characterinfo']['charactertab']['spell']['critchance']['holy']['percent'].'%');
			$extras[] = array('name'=>$lang['manaregen'],
							  'wert'=>$arr['characterinfo']['charactertab']['spell']['manaregen']['notcasting']);
			$extras[] = array('name'=>'<strong>'.$lang['title.defense'].'</strong>',
							  'wert'=>'hr');
			$extras[] = array('name'=>$lang['resilience'],
							  'wert'=>$arr['characterinfo']['charactertab']['defenses']['resilience']['value']);
		}
	}
	elseif($arr['characterinfo']['character']['classid']=="3") //J�ger
	{
		$extras[] = array('name'=>$lang['health'],
						  'wert'=>$arr['characterinfo']['charactertab']['characterbars']['health']['effective']);
		$extras[] = array('name'=>$lang['mana'],
						  'wert'=>$arr['characterinfo']['charactertab']['characterbars']['secondbar']['effective']);
		if($arr['characterinfo']['charactertab']['talentspec']['treetwo'] > $arr['characterinfo']['charactertab']['talentspec']['treethree'] &&
		   $arr['characterinfo']['charactertab']['talentspec']['treetwo'] > $arr['characterinfo']['charactertab']['talentspec']['treeone'])
		{
			$extras[] = array('name'=>'<strong>'.$lang['title.ranged'].'</strong>',
							  'wert'=>'hr');
			$extras[] = array('name'=>$lang['power'],
							  'wert'=>$arr['characterinfo']['charactertab']['ranged']['power']['effective']);
			$extras[] = array('name'=>$lang['hitrating'],
							  'wert'=>$arr['characterinfo']['charactertab']['ranged']['hitrating']['value']);
			$extras[] = array('name'=>$lang['critchance'],
							  'wert'=>$arr['characterinfo']['charactertab']['ranged']['critchance']['percent'].'%');
			$extras[] = array('name'=>'<strong>'.$lang['title.defense'].'</strong>',
							  'wert'=>'hr');
			$extras[] = array('name'=>$lang['resilience'],
							  'wert'=>$arr['characterinfo']['charactertab']['defenses']['resilience']['value']);
		}
		if($arr['characterinfo']['charactertab']['talentspec']['treethree'] > $arr['characterinfo']['charactertab']['talentspec']['treetwo'] &&
		   $arr['characterinfo']['charactertab']['talentspec']['treethree'] > $arr['characterinfo']['charactertab']['talentspec']['treeone'])
		{
			$extras[] = array('name'=>'<strong>'.$lang['title.ranged'].'</strong>',
							  'wert'=>'hr');
			$extras[] = array('name'=>$lang['power'],
							  'wert'=>$arr['characterinfo']['charactertab']['ranged']['power']['effective']);
			$extras[] = array('name'=>$lang['hitrating'],
							  'wert'=>$arr['characterinfo']['charactertab']['ranged']['hitrating']['value']);
			$extras[] = array('name'=>$lang['critchance'],
							  'wert'=>$arr['characterinfo']['charactertab']['ranged']['critchance']['percent'].'%');
			$extras[] = array('name'=>'<strong>'.$lang['title.defense'].'</strong>',
							  'wert'=>'hr');
			$extras[] = array('name'=>$lang['resilience'],
							  'wert'=>$arr['characterinfo']['charactertab']['defenses']['resilience']['value']);
		}
		if($arr['characterinfo']['charactertab']['talentspec']['treeone'] > $arr['characterinfo']['charactertab']['talentspec']['treetwo'] &&
		   $arr['characterinfo']['charactertab']['talentspec']['treeone'] > $arr['characterinfo']['charactertab']['talentspec']['treethree'])
		{
			$extras[] = array('name'=>'<strong>'.$lang['title.ranged'].'</strong>',
							  'wert'=>'hr');
			$extras[] = array('name'=>$lang['power'],
							  'wert'=>$arr['characterinfo']['charactertab']['ranged']['power']['effective']);
			$extras[] = array('name'=>$lang['hitrating'],
							  'wert'=>$arr['characterinfo']['charactertab']['ranged']['hitrating']['value']);
			$extras[] = array('name'=>$lang['critchance'],
							  'wert'=>$arr['characterinfo']['charactertab']['ranged']['critchance']['percent'].'%');
			$extras[] = array('name'=>'<strong>'.$lang['title.defense'].'</strong>',
							  'wert'=>'hr');
			$extras[] = array('name'=>$lang['resilience'],
							  'wert'=>$arr['characterinfo']['charactertab']['defenses']['resilience']['value']);
		}
	}
	elseif($arr['characterinfo']['character']['classid']=="4") //Schurke
	{
		$extras[] = array('name'=>$lang['health'],
						  'wert'=>$arr['characterinfo']['charactertab']['characterbars']['health']['effective']);
		if($arr['characterinfo']['charactertab']['talentspec']['treetwo'] > $arr['characterinfo']['charactertab']['talentspec']['treethree'] &&
		   $arr['characterinfo']['charactertab']['talentspec']['treetwo'] > $arr['characterinfo']['charactertab']['talentspec']['treeone'])
		{
			$extras[] = array('name'=>'<strong>'.$lang['title.melee'].'</strong>',
							  'wert'=>'hr');
			$extras[] = array('name'=>$lang['power'],
							  'wert'=>$arr['characterinfo']['charactertab']['melee']['power']['effective']);
			$extras[] = array('name'=>$lang['hitrating'],
							  'wert'=>$arr['characterinfo']['charactertab']['melee']['hitrating']['value']);
			$extras[] = array('name'=>$lang['critchance'],
							  'wert'=>$arr['characterinfo']['charactertab']['melee']['critchance']['percent'].'%');
			$extras[] = array('name'=>$lang['expertise'],
							  'wert'=>$arr['characterinfo']['charactertab']['melee']['expertise']['value']);
			$extras[] = array('name'=>'<strong>'.$lang['title.defense'].'</strong>',
							  'wert'=>'hr');
			$extras[] = array('name'=>$lang['resilience'],
							  'wert'=>$arr['characterinfo']['charactertab']['defenses']['resilience']['value']);
		}
		if($arr['characterinfo']['charactertab']['talentspec']['treethree'] > $arr['characterinfo']['charactertab']['talentspec']['treetwo'] &&
		   $arr['characterinfo']['charactertab']['talentspec']['treethree'] > $arr['characterinfo']['charactertab']['talentspec']['treeone'])
		{
			$extras[] = array('name'=>'<strong>'.$lang['title.melee'].'</strong>',
							  'wert'=>'hr');
			$extras[] = array('name'=>$lang['power'],
							  'wert'=>$arr['characterinfo']['charactertab']['melee']['power']['effective']);
			$extras[] = array('name'=>$lang['hitrating'],
							  'wert'=>$arr['characterinfo']['charactertab']['melee']['hitrating']['value']);
			$extras[] = array('name'=>$lang['critchance'],
							  'wert'=>$arr['characterinfo']['charactertab']['melee']['critchance']['percent'].'%');
			$extras[] = array('name'=>$lang['expertise'],
							  'wert'=>$arr['characterinfo']['charactertab']['melee']['expertise']['value']);
			$extras[] = array('name'=>'<strong>'.$lang['title.defense'].'</strong>',
							  'wert'=>'hr');
			$extras[] = array('name'=>$lang['resilience'],
							  'wert'=>$arr['characterinfo']['charactertab']['defenses']['resilience']['value']);
		}
		if($arr['characterinfo']['charactertab']['talentspec']['treeone'] > $arr['characterinfo']['charactertab']['talentspec']['treetwo'] &&
		   $arr['characterinfo']['charactertab']['talentspec']['treeone'] > $arr['characterinfo']['charactertab']['talentspec']['treethree'])
		{
			$extras[] = array('name'=>'<strong>'.$lang['title.melee'].'</strong>',
							  'wert'=>'hr');
			$extras[] = array('name'=>$lang['power'],
							  'wert'=>$arr['characterinfo']['charactertab']['melee']['power']['effective']);
			$extras[] = array('name'=>$lang['hitrating'],
							  'wert'=>$arr['characterinfo']['charactertab']['melee']['hitrating']['value']);
			$extras[] = array('name'=>$lang['critchance'],
							  'wert'=>$arr['characterinfo']['charactertab']['melee']['critchance']['percent'].'%');
			$extras[] = array('name'=>$lang['expertise'],
							  'wert'=>$arr['characterinfo']['charactertab']['melee']['expertise']['value']);
			$extras[] = array('name'=>'<strong>'.$lang['title.defense'].'</strong>',
							  'wert'=>'hr');
			$extras[] = array('name'=>$lang['resilience'],
							  'wert'=>$arr['characterinfo']['charactertab']['defenses']['resilience']['value']);
		}
	}
	elseif($arr['characterinfo']['character']['classid']=="5") //Priester
	{
		$extras[] = array('name'=>$lang['health'],
						  'wert'=>$arr['characterinfo']['charactertab']['characterbars']['health']['effective']);
		$extras[] = array('name'=>$lang['mana'],
						  'wert'=>$arr['characterinfo']['charactertab']['characterbars']['secondbar']['effective']);
		if($arr['characterinfo']['charactertab']['talentspec']['treetwo'] > $arr['characterinfo']['charactertab']['talentspec']['treethree'] &&
		   $arr['characterinfo']['charactertab']['talentspec']['treetwo'] > $arr['characterinfo']['charactertab']['talentspec']['treeone'])
		{
			$extras[] = array('name'=>'<strong>'.$lang['title.spell'].'</strong>',
							  'wert'=>'hr');
			$extras[] = array('name'=>$lang['healing'],
							  'wert'=>$arr['characterinfo']['charactertab']['spell']['bonushealing']['value']);
			$extras[] = array('name'=>$lang['hitrating'],
							  'wert'=>$arr['characterinfo']['charactertab']['spell']['hitrating']['value']);
			$extras[] = array('name'=>$lang['critchance'],
							  'wert'=>$arr['characterinfo']['charactertab']['spell']['critchance']['holy']['percent'].'%');
			$extras[] = array('name'=>$lang['manaregen'],
							  'wert'=>$arr['characterinfo']['charactertab']['spell']['manaregen']['notcasting']);
			$extras[] = array('name'=>'<strong>'.$lang['title.defense'].'</strong>',
							  'wert'=>'hr');
			$extras[] = array('name'=>$lang['resilience'],
							  'wert'=>$arr['characterinfo']['charactertab']['defenses']['resilience']['value']);
		}
		if($arr['characterinfo']['charactertab']['talentspec']['treethree'] > $arr['characterinfo']['charactertab']['talentspec']['treetwo'] &&
		   $arr['characterinfo']['charactertab']['talentspec']['treethree'] > $arr['characterinfo']['charactertab']['talentspec']['treeone'])
		{
			$extras[] = array('name'=>'<strong>'.$lang['title.spell'].'</strong>',
							  'wert'=>'hr');
			$extras[] = array('name'=>$lang['damage'],
							  'wert'=>$arr['characterinfo']['charactertab']['spell']['bonusdamage']['shadow']['value']);
			$extras[] = array('name'=>$lang['hitrating'],
							  'wert'=>$arr['characterinfo']['charactertab']['spell']['hitrating']['value']);
			$extras[] = array('name'=>$lang['critchance'],
							  'wert'=>$arr['characterinfo']['charactertab']['spell']['critchance']['shadow']['percent'].'%');
			$extras[] = array('name'=>$lang['penetration'],
							  'wert'=>$arr['characterinfo']['charactertab']['spell']['penetration']['value']);
			$extras[] = array('name'=>'<strong>'.$lang['title.defense'].'</strong>',
							  'wert'=>'hr');
			$extras[] = array('name'=>$lang['resilience'],
							  'wert'=>$arr['characterinfo']['charactertab']['defenses']['resilience']['value']);
		}
		if($arr['characterinfo']['charactertab']['talentspec']['treeone'] > $arr['characterinfo']['charactertab']['talentspec']['treetwo'] &&
		   $arr['characterinfo']['charactertab']['talentspec']['treeone'] > $arr['characterinfo']['charactertab']['talentspec']['treethree'])
		{
			$extras[] = array('name'=>'<strong>'.$lang['title.spell'].'</strong>',
							  'wert'=>'hr');
			$extras[] = array('name'=>$lang['damage'],
							  'wert'=>$arr['characterinfo']['charactertab']['spell']['bonusdamage']['shadow']['value']);
			$extras[] = array('name'=>$lang['healing'],
							  'wert'=>$arr['characterinfo']['charactertab']['spell']['bonushealing']['value']);
			$extras[] = array('name'=>$lang['hitrating'],
							  'wert'=>$arr['characterinfo']['charactertab']['spell']['hitrating']['value']);
			$extras[] = array('name'=>$lang['critchance'],
							  'wert'=>$arr['characterinfo']['charactertab']['spell']['critchance']['holy']['percent'].'%');
			$extras[] = array('name'=>$lang['manaregen'],
							  'wert'=>$arr['characterinfo']['charactertab']['spell']['manaregen']['notcasting']);
			$extras[] = array('name'=>'<strong>'.$lang['title.defense'].'</strong>',
							  'wert'=>'hr');
			$extras[] = array('name'=>$lang['resilience'],
							  'wert'=>$arr['characterinfo']['charactertab']['defenses']['resilience']['value']);
		}
	}
	elseif($arr['characterinfo']['character']['classid']=="7") //Schamane
	{
		$extras[] = array('name'=>$lang['health'],
						  'wert'=>$arr['characterinfo']['charactertab']['characterbars']['health']['effective']);
		$extras[] = array('name'=>$lang['mana'],
						  'wert'=>$arr['characterinfo']['charactertab']['characterbars']['secondbar']['effective']);
		if($arr['characterinfo']['charactertab']['talentspec']['treetwo'] > $arr['characterinfo']['charactertab']['talentspec']['treethree'] &&
		   $arr['characterinfo']['charactertab']['talentspec']['treetwo'] > $arr['characterinfo']['charactertab']['talentspec']['treeone'])
		{
			$extras[] = array('name'=>'<strong>'.$lang['title.melee'].'</strong>',
							  'wert'=>'hr');
			$extras[] = array('name'=>$lang['power'],
							  'wert'=>$arr['characterinfo']['charactertab']['melee']['power']['effective']);
			$extras[] = array('name'=>$lang['hitrating'],
							  'wert'=>$arr['characterinfo']['charactertab']['melee']['hitrating']['value']);
			$extras[] = array('name'=>$lang['critchance'],
							  'wert'=>$arr['characterinfo']['charactertab']['melee']['critchance']['percent'].'%');
			$extras[] = array('name'=>$lang['expertise'],
							  'wert'=>$arr['characterinfo']['charactertab']['melee']['expertise']['value']);
			$extras[] = array('name'=>'<strong>'.$lang['title.defense'].'</strong>',
							  'wert'=>'hr');
			$extras[] = array('name'=>$lang['resilience'],
							  'wert'=>$arr['characterinfo']['charactertab']['defenses']['resilience']['value']);
		}
		if($arr['characterinfo']['charactertab']['talentspec']['treethree'] > $arr['characterinfo']['charactertab']['talentspec']['treetwo'] &&
		   $arr['characterinfo']['charactertab']['talentspec']['treethree'] > $arr['characterinfo']['charactertab']['talentspec']['treeone'])
		{
			$extras[] = array('name'=>'<strong>'.$lang['title.spell'].'</strong>',
							  'wert'=>'hr');
			$extras[] = array('name'=>$lang['healing'],
							  'wert'=>$arr['characterinfo']['charactertab']['spell']['bonushealing']['value']);
			$extras[] = array('name'=>$lang['hitrating'],
							  'wert'=>$arr['characterinfo']['charactertab']['spell']['hitrating']['value']);
			$extras[] = array('name'=>$lang['critchance'],
							  'wert'=>$arr['characterinfo']['charactertab']['spell']['critchance']['holy']['percent'].'%');
			$extras[] = array('name'=>$lang['manaregen'],
							  'wert'=>$arr['characterinfo']['charactertab']['spell']['manaregen']['notcasting']);
			$extras[] = array('name'=>'<strong>'.$lang['title.defense'].'</strong>',
							  'wert'=>'hr');
			$extras[] = array('name'=>$lang['resilience'],
							  'wert'=>$arr['characterinfo']['charactertab']['defenses']['resilience']['value']);
		}
		if($arr['characterinfo']['charactertab']['talentspec']['treeone'] > $arr['characterinfo']['charactertab']['talentspec']['treetwo'] &&
		   $arr['characterinfo']['charactertab']['talentspec']['treeone'] > $arr['characterinfo']['charactertab']['talentspec']['treethree'])
		{
			$extras[] = array('name'=>'<strong>'.$lang['title.spell'].'</strong>',
							  'wert'=>'hr');
			$extras[] = array('name'=>$lang['healing'],
							  'wert'=>$arr['characterinfo']['charactertab']['spell']['bonushealing']['value']);
			$extras[] = array('name'=>$lang['hitrating'],
							  'wert'=>$arr['characterinfo']['charactertab']['spell']['hitrating']['value']);
			$extras[] = array('name'=>$lang['critchance'],
							  'wert'=>$arr['characterinfo']['charactertab']['spell']['critchance']['holy']['percent'].'%');
			$extras[] = array('name'=>$lang['manaregen'],
							  'wert'=>$arr['characterinfo']['charactertab']['spell']['manaregen']['notcasting']);
			$extras[] = array('name'=>'<strong>'.$lang['title.defense'].'</strong>',
							  'wert'=>'hr');
			$extras[] = array('name'=>$lang['resilience'],
							  'wert'=>$arr['characterinfo']['charactertab']['defenses']['resilience']['value']);
		}
	}
	elseif($arr['characterinfo']['character']['classid']=="8") //Magier
	{
		$extras[] = array('name'=>$lang['health'],
						  'wert'=>$arr['characterinfo']['charactertab']['characterbars']['health']['effective']);
		$extras[] = array('name'=>$lang['mana'],
						  'wert'=>$arr['characterinfo']['charactertab']['characterbars']['secondbar']['effective']);
		if($arr['characterinfo']['charactertab']['talentspec']['treetwo'] > $arr['characterinfo']['charactertab']['talentspec']['treethree'] &&
		   $arr['characterinfo']['charactertab']['talentspec']['treetwo'] > $arr['characterinfo']['charactertab']['talentspec']['treeone'])
		{
			$extras[] = array('name'=>'<strong>'.$lang['title.spell'].'</strong>',
							  'wert'=>'hr');
			$extras[] = array('name'=>$lang['damage'],
							  'wert'=>$arr['characterinfo']['charactertab']['spell']['bonusdamage']['fire']['value']);
			$extras[] = array('name'=>$lang['hitrating'],
							  'wert'=>$arr['characterinfo']['charactertab']['spell']['hitrating']['value']);
			$extras[] = array('name'=>$lang['critchance'],
							  'wert'=>$arr['characterinfo']['charactertab']['spell']['critchance']['fire']['percent'].'%');
			$extras[] = array('name'=>$lang['penetration'],
							  'wert'=>$arr['characterinfo']['charactertab']['spell']['penetration']['value']);
			$extras[] = array('name'=>'<strong>'.$lang['title.defense'].'</strong>',
							  'wert'=>'hr');
			$extras[] = array('name'=>$lang['resilience'],
							  'wert'=>$arr['characterinfo']['charactertab']['defenses']['resilience']['value']);
		}
		if($arr['characterinfo']['charactertab']['talentspec']['treethree'] > $arr['characterinfo']['charactertab']['talentspec']['treetwo'] &&
		   $arr['characterinfo']['charactertab']['talentspec']['treethree'] > $arr['characterinfo']['charactertab']['talentspec']['treeone'])
		{
			$extras[] = array('name'=>'<strong>'.$lang['title.spell'].'</strong>',
							  'wert'=>'hr');
			$extras[] = array('name'=>$lang['damage'],
							  'wert'=>$arr['characterinfo']['charactertab']['spell']['bonusdamage']['frost']['value']);
			$extras[] = array('name'=>$lang['hitrating'],
							  'wert'=>$arr['characterinfo']['charactertab']['spell']['hitrating']['value']);
			$extras[] = array('name'=>$lang['critchance'],
							  'wert'=>$arr['characterinfo']['charactertab']['spell']['critchance']['frost']['percent'].'%');
			$extras[] = array('name'=>$lang['penetration'],
							  'wert'=>$arr['characterinfo']['charactertab']['spell']['penetration']['value']);
			$extras[] = array('name'=>'<strong>'.$lang['title.defense'].'</strong>',
							  'wert'=>'hr');
			$extras[] = array('name'=>$lang['resilience'],
							  'wert'=>$arr['characterinfo']['charactertab']['defenses']['resilience']['value']);
		}
		if($arr['characterinfo']['charactertab']['talentspec']['treeone'] > $arr['characterinfo']['charactertab']['talentspec']['treetwo'] &&
		   $arr['characterinfo']['charactertab']['talentspec']['treeone'] > $arr['characterinfo']['charactertab']['talentspec']['treethree'])
		{
			$extras[] = array('name'=>'<strong>'.$lang['title.spell'].'</strong>',
							  'wert'=>'hr');
			if($arr['characterinfo']['charactertab']['talentspec']['treethree'] >= "10")
			{
				$extras[] = array('name'=>$lang['damage'],
								  'wert'=>$arr['characterinfo']['charactertab']['spell']['bonusdamage']['frost']['value']);
			}
			elseif($arr['characterinfo']['charactertab']['talentspec']['treetwo'] >= "10")
			{
				$extras[] = array('name'=>$lang['damage'],
								  'wert'=>$arr['characterinfo']['charactertab']['spell']['bonusdamage']['fire']['value']);
			}
			else
			{
				$extras[] = array('name'=>$lang['damage'],
								  'wert'=>$arr['characterinfo']['charactertab']['spell']['bonusdamage']['arcane']['value']);
			}
			$extras[] = array('name'=>$lang['hitrating'],
							  'wert'=>$arr['characterinfo']['charactertab']['spell']['hitrating']['value']);
			if($arr['characterinfo']['charactertab']['talentspec']['treethree'] >= "10")
			{
				$extras[] = array('name'=>$lang['critchance'],
								  'wert'=>$arr['characterinfo']['charactertab']['spell']['critchance']['frost']['percent'].'%');
			}
			elseif($arr['characterinfo']['charactertab']['talentspec']['treetwo'] >= "10")
			{
				$extras[] = array('name'=>$lang['critchance'],
								  'wert'=>$arr['characterinfo']['charactertab']['spell']['critchance']['fire']['percent'].'%');
			}
			else
			{
				$extras[] = array('name'=>$lang['critchance'],
								  'wert'=>$arr['characterinfo']['charactertab']['spell']['critchance']['arcane']['percent'].'%');
			}
			$extras[] = array('name'=>$lang['penetration'],
							  'wert'=>$arr['characterinfo']['charactertab']['spell']['penetration']['value']);
			$extras[] = array('name'=>'<strong>'.$lang['title.defense'].'</strong>',
							  'wert'=>'hr');
			$extras[] = array('name'=>$lang['resilience'],
							  'wert'=>$arr['characterinfo']['charactertab']['defenses']['resilience']['value']);
		}
	}
	elseif($arr['characterinfo']['character']['classid']=="9") //Hexenmeister
	{
		$extras[] = array('name'=>$lang['health'],
						  'wert'=>$arr['characterinfo']['charactertab']['characterbars']['health']['effective']);
		$extras[] = array('name'=>$lang['mana'],
						  'wert'=>$arr['characterinfo']['charactertab']['characterbars']['secondbar']['effective']);
		if($arr['characterinfo']['charactertab']['talentspec']['treetwo'] > $arr['characterinfo']['charactertab']['talentspec']['treethree'] &&
		   $arr['characterinfo']['charactertab']['talentspec']['treetwo'] > $arr['characterinfo']['charactertab']['talentspec']['treeone'])
		{
			$extras[] = array('name'=>'<strong>'.$lang['title.spell'].'</strong>',
							  'wert'=>'hr');
			$extras[] = array('name'=>$lang['damage'],
							  'wert'=>$arr['characterinfo']['charactertab']['spell']['bonusdamage']['shadow']['value']);
			$extras[] = array('name'=>$lang['hitrating'],
							  'wert'=>$arr['characterinfo']['charactertab']['spell']['hitrating']['value']);
			$extras[] = array('name'=>$lang['critchance'],
							  'wert'=>$arr['characterinfo']['charactertab']['spell']['critchance']['shadow']['percent'].'%');
			$extras[] = array('name'=>$lang['penetration'],
							  'wert'=>$arr['characterinfo']['charactertab']['spell']['penetration']['value']);
			$extras[] = array('name'=>'<strong>'.$lang['title.defense'].'</strong>',
							  'wert'=>'hr');
			$extras[] = array('name'=>$lang['resilience'],
							  'wert'=>$arr['characterinfo']['charactertab']['defenses']['resilience']['value']);
		}
		if($arr['characterinfo']['charactertab']['talentspec']['treethree'] > $arr['characterinfo']['charactertab']['talentspec']['treetwo'] &&
		   $arr['characterinfo']['charactertab']['talentspec']['treethree'] > $arr['characterinfo']['charactertab']['talentspec']['treeone'])
		{
			$extras[] = array('name'=>'<strong>'.$lang['title.spell'].'</strong>',
							  'wert'=>'hr');
			$extras[] = array('name'=>$lang['damage'],
							  'wert'=>$arr['characterinfo']['charactertab']['spell']['bonusdamage']['fire']['value']);
			$extras[] = array('name'=>$lang['hitrating'],
							  'wert'=>$arr['characterinfo']['charactertab']['spell']['hitrating']['value']);
			$extras[] = array('name'=>$lang['critchance'],
							  'wert'=>$arr['characterinfo']['charactertab']['spell']['critchance']['fire']['percent'].'%');
			$extras[] = array('name'=>$lang['penetration'],
							  'wert'=>$arr['characterinfo']['charactertab']['spell']['penetration']['value']);
			$extras[] = array('name'=>'<strong>'.$lang['title.defense'].'</strong>',
							  'wert'=>'hr');
			$extras[] = array('name'=>$lang['resilience'],
							  'wert'=>$arr['characterinfo']['charactertab']['defenses']['resilience']['value']);
		}
		if($arr['characterinfo']['charactertab']['talentspec']['treeone'] > $arr['characterinfo']['charactertab']['talentspec']['treetwo'] &&
		   $arr['characterinfo']['charactertab']['talentspec']['treeone'] > $arr['characterinfo']['charactertab']['talentspec']['treethree'])
		{
			$extras[] = array('name'=>'<strong>'.$lang['title.spell'].'</strong>',
							  'wert'=>'hr');
			$extras[] = array('name'=>$lang['damage'],
							  'wert'=>$arr['characterinfo']['charactertab']['spell']['bonusdamage']['shadow']['value']);
			$extras[] = array('name'=>$lang['hitrating'],
							  'wert'=>$arr['characterinfo']['charactertab']['spell']['hitrating']['value']);
			$extras[] = array('name'=>$lang['critchance'],
							  'wert'=>$arr['characterinfo']['charactertab']['spell']['critchance']['shadow']['percent'].'%');
			$extras[] = array('name'=>$lang['penetration'],
							  'wert'=>$arr['characterinfo']['charactertab']['spell']['penetration']['value']);
			$extras[] = array('name'=>'<strong>'.$lang['title.defense'].'</strong>',
							  'wert'=>'hr');
			$extras[] = array('name'=>$lang['resilience'],
							  'wert'=>$arr['characterinfo']['charactertab']['defenses']['resilience']['value']);
		}
	}
	elseif($arr['characterinfo']['character']['classid']=="11") //Druide
	{
		$extras[] = array('name'=>$lang['health'],
						  'wert'=>$arr['characterinfo']['charactertab']['characterbars']['health']['effective']);
		$extras[] = array('name'=>$lang['mana'],
						  'wert'=>$arr['characterinfo']['charactertab']['characterbars']['secondbar']['effective']);
		if($arr['characterinfo']['charactertab']['talentspec']['treetwo'] > $arr['characterinfo']['charactertab']['talentspec']['treethree'] &&
		   $arr['characterinfo']['charactertab']['talentspec']['treetwo'] > $arr['characterinfo']['charactertab']['talentspec']['treeone'])
		{
			$extras[] = array('name'=>'<strong>'.$lang['title.defense'].'</strong>',
							  'wert'=>'hr');
			$extras[] = array('name'=>$lang['armor'],
							  'wert'=>$arr['characterinfo']['charactertab']['defenses']['armor']['base']);
			$extras[] = array('name'=>$lang['defense'],
							  'wert'=>($arr['characterinfo']['charactertab']['defenses']['defense']['plusdefense']+$arr['characterinfo']['charactertab']['defenses']['defense']['value']));
			$extras[] = array('name'=>$lang['dodge'],
							  'wert'=>$arr['characterinfo']['charactertab']['defenses']['dodge']['percent'].'%');
			$extras[] = array('name'=>$lang['resilience'],
							  'wert'=>$arr['characterinfo']['charactertab']['defenses']['resilience']['value']);
			$extras[] = array('name'=>'<strong>'.$lang['title.melee'].'</strong>',
							  'wert'=>'hr');
			$extras[] = array('name'=>$lang['power'],
							  'wert'=>$arr['characterinfo']['charactertab']['melee']['power']['effective']);
			$extras[] = array('name'=>$lang['hitrating'],
							  'wert'=>$arr['characterinfo']['charactertab']['melee']['hitrating']['value']);
			$extras[] = array('name'=>$lang['critchance'],
							  'wert'=>$arr['characterinfo']['charactertab']['melee']['critchance']['percent'].'%');
			$extras[] = array('name'=>$lang['expertise'],
							  'wert'=>$arr['characterinfo']['charactertab']['melee']['expertise']['value']);
		}
		if($arr['characterinfo']['charactertab']['talentspec']['treethree'] > $arr['characterinfo']['charactertab']['talentspec']['treetwo'] &&
		   $arr['characterinfo']['charactertab']['talentspec']['treethree'] > $arr['characterinfo']['charactertab']['talentspec']['treeone'])
		{
			$extras[] = array('name'=>'<strong>'.$lang['title.spell'].'</strong>',
							  'wert'=>'hr');
			$extras[] = array('name'=>$lang['healing'],
							  'wert'=>$arr['characterinfo']['charactertab']['spell']['bonushealing']['value']);
			$extras[] = array('name'=>$lang['hitrating'],
							  'wert'=>$arr['characterinfo']['charactertab']['spell']['hitrating']['value']);
			$extras[] = array('name'=>$lang['critchance'],
							  'wert'=>$arr['characterinfo']['charactertab']['spell']['critchance']['nature']['percent'].'%');
			$extras[] = array('name'=>$lang['manaregen'],
							  'wert'=>$arr['characterinfo']['charactertab']['spell']['manaregen']['notcasting']);
			$extras[] = array('name'=>'<strong>'.$lang['title.defense'].'</strong>',
							  'wert'=>'hr');
			$extras[] = array('name'=>$lang['resilience'],
							  'wert'=>$arr['characterinfo']['charactertab']['defenses']['resilience']['value']);
		}
		if($arr['characterinfo']['charactertab']['talentspec']['treeone'] > $arr['characterinfo']['charactertab']['talentspec']['treetwo'] &&
		   $arr['characterinfo']['charactertab']['talentspec']['treeone'] > $arr['characterinfo']['charactertab']['talentspec']['treethree'])
		{
			$extras[] = array('name'=>'<strong>'.$lang['title.spell'].'</strong>',
							  'wert'=>'hr');
			$extras[] = array('name'=>$lang['damage'],
							  'wert'=>$arr['characterinfo']['charactertab']['spell']['bonusdamage']['nature']['value']);
			$extras[] = array('name'=>$lang['hitrating'],
							  'wert'=>$arr['characterinfo']['charactertab']['spell']['hitrating']['value']);
			$extras[] = array('name'=>$lang['critchance'],
							  'wert'=>$arr['characterinfo']['charactertab']['spell']['critchance']['nature']['percent'].'%');
			$extras[] = array('name'=>$lang['penetration'],
							  'wert'=>$arr['characterinfo']['charactertab']['spell']['penetration']['value']);
			$extras[] = array('name'=>'<strong>'.$lang['title.defense'].'</strong>',
							  'wert'=>'hr');
			$extras[] = array('name'=>$lang['resilience'],
							  'wert'=>$arr['characterinfo']['charactertab']['defenses']['resilience']['value']);
		}
	}

	if(isset($extras))
	{
		foreach($extras as $extra)
		{
			if($extra['wert'] != "hr")
			{
				$tooltip .= "<tr><td align='left' valign='top' style='background-color:#222222' width='60%'>".$extra['name']."</td><td align='right' valign='top' style='background-color:#022202' width='40%'>".$extra['wert']."</td></tr>";
			}
			else
			{
				$tooltip .= "<tr><td align='left' valign='top' style='background-color:#222222' width='60%' colspan='2'><strong>".$extra['name']."</strong></td></tr>";
			}
		}
	}

	if(isset($arr['characterinfo']['charactertab']['professions']['skill'][0]))
	{
		$tooltip .= "<tr><td align='left' valign='top' style='background-color:#222222' width='60%' colspan='2'><strong>".$lang['title.professions']."</strong></td></tr><tr><td align='left' valign='top' style='background-color:#222222' width='60%'>".$arr['characterinfo']['charactertab']['professions']['skill'][0]['name']."</td><td align='right' valign='top' style='background-color:#022202' width='40%'>".$arr['characterinfo']['charactertab']['professions']['skill'][0]['value']."/".$arr['characterinfo']['charactertab']['professions']['skill'][0]['max']."</td></tr><tr><td align='left' valign='top' style='background-color:#222222' width='60%'>".$arr['characterinfo']['charactertab']['professions']['skill'][1]['name']."</td><td align='right' valign='top' style='background-color:#022202' width='40%'>".$arr['characterinfo']['charactertab']['professions']['skill'][1]['value']."/".$arr['characterinfo']['charactertab']['professions']['skill'][1]['max']."</td></tr>";
	}
	else
	{
		$tooltip .= "<tr><td align='left' valign='top' style='background-color:#222222' width='60%' colspan='2'><strong>".$lang['title.professions']."</strong></td></tr><tr><td align='left' valign='top' style='background-color:#222222' width='60%'>".$arr['characterinfo']['charactertab']['professions']['skill']['name']."</td><td align='right' valign='top' style='background-color:#022202' width='40%'>".$arr['characterinfo']['charactertab']['professions']['skill']['value']."/".$arr['characterinfo']['charactertab']['professions']['skill']['max']."</td></tr>";
	}
	$tooltip .= "</table></td>
      </tr>
	  <tr>
        <td colspan='2' style='font-size:10px;'>".$lang['lastmodified']." ".$arr['characterinfo']['character']['lastmodified']."</td>
      </tr>
    </table></div>";

	if($arr['characterinfo']['character']['name'] != "")
	{
		$handle = @fopen($filename, 'w+') or die("Cannot open file ($filename)");
		@fwrite($handle, $tooltip) or die("Cannot write to file ($filename)");
		fclose($handle);

		echo file_get_contents($filename);
	}
	else
	{
		echo "<div><table width='100%' border='0' cellspacing='0' cellpadding='0'><tr><td align='left' valign='top'>Charakter nicht gefunden. Arsenal erreichbar?</td></tr></table></div>";
	}

	if($arr['characterinfo']['character']['name'] != "")
	{
		$filename = 'cache/'.preg_replace("/[^a-zA-Z0-9]/", "-", $r).'-'.preg_replace("/[^a-zA-Z0-9]/", "-", $_GET['n']).'-guild.txt';

		$handle = @fopen($filename, 'w+') or die("Cannot open file ($filename)");
		if($guildname == "")
		{
			$guildname = "-";
		}
		@fwrite($handle, $guildname) or die("Cannot write to file ($filename)");
		fclose($handle);
	}
}
?>
    </td>
  </tr>
</table>