<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="pt-br" xml:lang="pt-br">
<head>
<title>TEST WOW ARMORY FILE</title>
<!-- <link rel="stylesheet" href="../styles/prosilver/theme/stylesheet.css" type="text/css" /> -->
</head>
<body>
<h2>TEST WOW ARMORY FILE</h2>
<?
include("config.php");
ini_set('user_agent', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; de-DE; rv:1.8.1) Gecko/20061010 Firefox/2.0');

$url = 'http://eu.wowarmory.com/item-tooltip.xml?i=33682';

//MODIFY THESE FOR YOUR TEST
$realm='TestRealm';
$character='TestChar';
$lang='en';

$file_get_contents = (function_exists('file_get_contents')) ? "<font color='green'>YES</font>" : "<font color='red'>NO</font>";
$stream_context_create = (function_exists('stream_context_create')) ? "<font color='green'>YES</font>" : "<font color='red'>NO</font>";
$arm = (file_get_contents($url)) ? "<font color='green'>YES</font>" : "<font color='red'>NO</font>";
$curl = (function_exists('curl_init')) ? "<font color='green'>YES</font>" : "<font color='red'>NO</font>";
$testcache = (is_writable("cache")) ? "<font color='green'>YES</font>" : "<font color='red'>NO</font>";
$fopen = (ini_get('allow_url_fopen') == 1) ? "<font color='green'>YES</font>" : "<font color='red'>NO</font>";

//Test Write to cache directory:
$filename = 'cache/'.$realm.'-'.$character.'-'.$lang.'-name.html';
$link = '<a href="' . ARMORY . '/character-sheet.xml?r='.$realm.'&n='.urlencode($character).'" target="new" onmouseover="tooltip_charid(\''.str_replace("'","\'",$realm).'\',\''.$lang.'\',\''.$character.'\')" onmouseout="tooltip_close_char()">'.$character.'</a>';

$handle = @fopen($filename, 'w+');
@fwrite($handle, $link);
fclose($handle);
$file_exists=(file_exists($filename)) ? "<font color='green'>YES</font>" : "<font color='red'>NO</font>";

//Read from cache directory to complete test:
$handle = @fopen($filename, 'r');
$link2 = fread($handle,1000);
fclose($handle);
echo $link2;
$read_from_file=($link2 != '') ? "<font color='green'>YES</font>" : "<font color='red'>NO</font>";

echo "<br /> <hr><hr>";
//Server info
echo "<br /> Server type: ". $_SERVER['SERVER_SOFTWARE'];
//PHP version
echo "<br /> PHP version: ". phpversion();
// Test if curl is Enabled
echo "<br />Curl is Enabled: " . $curl; 
// Test if file_get_contents is Enabled
echo "<br />file_get_contents is Enabled: " . $file_get_contents; 
// Test if stream_context_create is Enabled
echo "<br />stream_context_create is Enabled: " . $stream_context_create; 
// Test if fopen is Enabled
echo "<br />fopen is Enabled: " . $fopen;
// Test if your server can make a connection with armory
echo "<br />Connection with armory: ". $arm;
// Test for proper file write to cache directory:
echo "<br />Cache Directory Write Succeeded?: ". $file_exists;
// Test if we correctly wrote and read from the cache directory.
echo "<br />Read from Cache Directory: ". $read_from_file;
// Test
echo "<br />Test cache: ". $testcache;
echo "<br />Armory: ". ARMORY;

if($_GET['a']=="phpinfo")
{
	phpinfo();
}
?>
</body>
</html>
