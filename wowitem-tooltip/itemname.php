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

function color($v)
{
	switch($v)
	{
		case 0: return "#c9c9c9"; break;
		case 1: return "#000000"; break;
		case 2: return "#00FF00"; break;
		case 3: return "#0070DD"; break;
		case 4: return "#A335EE"; break;
		case 5: return "#FF8000"; break;
		case 6: return "#e5cc80"; break;
		case 7: return "#d80000"; break;
	}
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


$id = str_replace("\'","'",$_GET['id']);
$filename = 'cache/'.preg_replace("/[^a-zA-Z0-9]/", "-", $id).'-'.$_GET['lang'].'-name.html';

if(!file_exists($filename) && is_numeric($_GET['id']))
{
	$arr = xmlToArray(xmlFetch(ARMORY . "/item-tooltip.xml?i=".$_GET['id'],$_GET['lang']));

	if(isset($arr['itemtooltips']['itemtooltip']['name']))
	{
		$link = '<a href="' . ARMORY . '/item-info.xml?i='.$arr['itemtooltips']['itemtooltip']['id'].'" target="new" onmouseover="tooltip_itemid(\''.$arr['itemtooltips']['itemtooltip']['id'].'\',\''.$_GET['lang'].'\')" onmouseout="tooltip_close()" style="color:'.color($arr['itemtooltips']['itemtooltip']['overallqualityid']).'">['.utf8_decode($arr['itemtooltips']['itemtooltip']['name']).']</a>';

		$handle = @fopen($filename, 'w+') or die("Cannot open file ($filename)");
		@fwrite($handle, $link) or die("Cannot write to file ($filename)");
		fclose($handle);

		echo $link;
	}
	else
	{
		echo "[Item not found]";
	}
}
elseif(!file_exists($filename) && !is_numeric($_GET['id']))
{
	$arr = xmlToArray(xmlFetch(ARMORY . "/search.xml?searchQuery=".str_replace(" ","+",$_GET['id'])."&searchType=items",$_GET['lang']));
	$arr = $arr['armorysearch']['searchresults']['items']['item'];
	/*
	print("<pre>");
	print_r($arr);
	print("</pre>");
	*/
	if(is_array($arr[0]))
	{
		foreach($arr as $item)
		{
			if(strtolower(trim($item['name'])) == strtolower(trim($_GET['id'])))
			{
				$item_x = xmlToArray(xmlFetch(ARMORY . "/item-tooltip.xml?i=".$item['id'],$_GET['lang']));
				
				if(isset($item_x['itemtooltips']['itemtooltip']['name']))
				{
					$link[] = '<a href="' . ARMORY . '/item-info.xml?i='.$item_x['itemtooltips']['itemtooltip']['id'].'" target="new" onmouseover="tooltip_itemid(\''.$item_x['itemtooltips']['itemtooltip']['id'].'\',\''.$_GET['lang'].'\')" onmouseout="tooltip_close()" style="color:'.color($item_x['itemtooltips']['itemtooltip']['overallqualityid']).'">['.utf8_decode($item_x['itemtooltips']['itemtooltip']['name']).']</a>';
					
					$handle = @fopen($filename, 'w+') or die("Cannot open file ($filename)");
					@fwrite($handle, ((isset($link[1])) ? ($link[0]." ".$link[1]) : ($link[0]))) or die("Cannot write to file ($filename)");
					fclose($handle);
					
					echo ((isset($link[1])) ? ($link[0]." ".$link[1]) : ($link[0]));
				}
				else
				{
					echo "[Item not found]";
				}
			}
		}
	}
	else
	{
		$item_x = xmlToArray(xmlFetch(ARMORY . "/item-tooltip.xml?i=".$arr['id'],$_GET['lang']));
		
		if(isset($item_x['itemtooltips']['itemtooltip']['name']))
		{
			$link = '<a href="' . ARMORY . '/item-info.xml?i='.$item_x['itemtooltips']['itemtooltip']['id'].'" target="new" onmouseover="tooltip_itemid(\''.$item_x['itemtooltips']['itemtooltip']['id'].'\',\''.$_GET['lang'].'\')" onmouseout="tooltip_close()" style="color:'.color($item_x['itemtooltips']['itemtooltip']['overallqualityid']).'">['.utf8_decode($item_x['itemtooltips']['itemtooltip']['name']).']</a>';

			$handle = @fopen($filename, 'w+') or die("Cannot open file ($filename)");
			@fwrite($handle, $link) or die("Cannot write to file ($filename)");
			fclose($handle);

			echo $link;
		}
		else
		{
			echo "[Item not found]";
		}
	}
}
?>
