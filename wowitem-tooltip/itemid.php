<table cellpadding='0' border='0' class='tooltip_new'>
  <tr>
    <td>
<?php
include("config.php");
$filename = 'cache/'.$_GET['id'].'-'.$_GET['lang'].'-tooltip.html';

if(file_exists($filename) && trim(file_get_contents($filename))!="" && time()-filemtime($filename) < 604800)
{
	echo file_get_contents($filename);
}
else
{
	$url = ARMORY . '/item-tooltip.xml?i='.$_GET['id'];

	if (function_exists('curl_init')){
		$ch = curl_init();

		curl_setopt ($ch, CURLOPT_URL, $url);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, '10');
		curl_setopt ($ch, CURLOPT_HEADER, 0);
		curl_setopt ($ch, CURLOPT_HTTPHEADER, array("Accept-Language: ".$_GET['lang'])); 
		
		$f = curl_exec($ch);
		
		curl_close($ch);
	
	} elseif(ini_get('allow_url_fopen') == 1) {
		$contextOptions = array('http'=>array('method'=>"GET",'header'=>"Accept-language: ".$_GET['lang']."\r\n"));
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
		$contextOptions = array('http'=>array('method'=>"GET",'header'=>"Accept-language: ".$_GET['lang']."\r\n"));
		$context = stream_context_create($contextOptions);
		$f = file_get_contents($url,false, $context);
	} else {
		die('There couldn\'t be found any function on your server, which work!<br /><br />Try this functions:<br />- curl<br />- file_get_contents with stream_context_create<br />- fopen with stream_context_create<br /><br />Ask your hoster to activate these functions.');
	}
		
	$handle = @fopen($filename, 'w+') or die("Cannot open file ($filename)");
	@fwrite($handle, str_replace('/shared/global/tooltip/images/icons','wowitem-tooltip/image',$f)) or die("Cannot write to file ($filename)");
	fclose($handle);
	
	echo file_get_contents($filename);
}
?>
    </td>
  </tr>
</table>