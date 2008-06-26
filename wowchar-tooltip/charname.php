<?php
include("config.php");
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


$r = str_replace("\'","'",$_GET['r']);
$filename = 'cache/'.preg_replace("/[^a-zA-Z0-9]/", "-", $r).'-'.preg_replace("/[^a-zA-Z0-9]/", "-", $_GET['n']).'-'.$_GET['lang'].'-name.html';
if(!file_exists($filename))
{
	$arr = xmlToArray(xmlFetch(ARMORY . "/character-sheet.xml?r=".urlencode($r)."&n=".urlencode($_GET['n']),$_GET['lang']));
	/*
	print("<pre>".$_GET['n']);
	print_r($arr);
	print("</pre>");
	*/
	if(isset($arr['characterinfo']['character']['name']))
	{
		//$link = '<img src="wowchar-tooltip/image/icons/race/'.$arr['characterinfo']['character']['raceid'].'-'.$arr['characterinfo']['character']['genderid'].'.png" alt="'.$arr['characterinfo']['character']['race'].'" align="top" /><img src="wowchar-tooltip/image/icons/class/'.$arr['characterinfo']['character']['classid'].'.png" alt="'.$arr['characterinfo']['character']['class'].'" align="top" /> <a href="' . ARMORY . '/character-sheet.xml?r='.$arr['characterinfo']['character']['realm'].'&n='.urlencode($arr['characterinfo']['character']['name']).'" target="new" onmouseover="tooltip_charid(\''.str_replace("'","\'",$arr['characterinfo']['character']['realm']).'\',\''.$_GET['lang'].'\',\''.$arr['characterinfo']['character']['name'].'\')" onmouseout="tooltip_close_char()">['.$arr['characterinfo']['character']['realm'].(($_GET['lang']=='fr') ? (' : ') : (': ')).$arr['characterinfo']['character']['name'].']</a>';
		$link = '<a href="' . ARMORY . '/character-sheet.xml?r='.$arr['characterinfo']['character']['realm'].'&n='.urlencode($arr['characterinfo']['character']['name']).'" target="new" onmouseover="tooltip_charid(\''.str_replace("'","\'",$arr['characterinfo']['character']['realm']).'\',\''.$_GET['lang'].'\',\''.$arr['characterinfo']['character']['name'].'\')" onmouseout="tooltip_close_char()">'.$arr['characterinfo']['character']['name'].'</a>';

		$handle = @fopen($filename, 'w+') or die("Cannot open file ($filename)");
		@fwrite($handle, $link) or die("Cannot write to file ($filename)");
		fclose($handle);

		echo $link;
	}
	else
	{
		echo "[".$_GET['n']."]";
	}
}
?>