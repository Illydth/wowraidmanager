<?php
	// phpRaider
/*
	$legalConfigLines = array(
		'^(\<\?php)$',
		'^(\s+)?$',
		'^(\s+)?\/\/.+$',
		'^(\s+)?global(\s+)\$pConfig;$',
		'^\$\w+\[[\'"](\w|_)+[\'"]\](\s+)?=(\s+)?[\'"]([^\'"]+)?[\'"](\s+)?\;',
		'^\?>$'
	);
*/

	// wrm
	$legalConfigLines = array(
		'^(\<\?php)$',
		'^(\s+)?$',
		//'^(\s+)?\/\/.+$',
		'^(\s+)?global(\s+)\$phpraid_config;$',
		'^\$(\w|_)+\[[\'"](\w|_)+[\'"]\](\s+)?=(\s+)?[\'"]([^\'"]+)?[\'"](\s+)?\;',
		'^\?>$'
	);

	$configFile = array();
	$configErrors = array();
	$errorFound = FALSE;
	$lineCounter = 1;
	//$configFile = file(dirname(__FILE__).DIRECTORY_SEPARATOR.'configuration.php');
	$configFile = file(dirname(__FILE__).DIRECTORY_SEPARATOR.'config.php');
	$inCommentBlock = false;
	foreach($configFile as $configLine){
		if (!empty($configLine)) {
			if ($inCommentBlock) {
				if (preg_match('@\*/(\s+)?@',$configLine)) {
					$inCommentBlock = false;
					$dummy = preg_split('@\*/(\s+)?@',$configLine);
					$configLine = $dummy[1];
				}
			}
			if (!$inCommentBlock) {
				if (preg_match('@(\s+)?/\*@',$configLine)) {
					$inCommentBlock = true;
					$dummy = preg_split('@(\s+)?/\*@',$configLine);
					$configLine = $dummy[0];
				}
				if (!empty($configLine)) {
					$isLegal = false;
					foreach ($legalConfigLines as $legalConfigLine) {
						if (preg_match('/'.$legalConfigLine.'/i',$configLine)) {
							$isLegal = true;
							break;
						}
					}
					if (!$isLegal) {
						$configErrors[] = array('line' => $lineCounter, 'contents'=> $configLine);
						$errorFound = TRUE;
					}
				}
			}
		}
		$lineCounter++;
	}

	if ($errorFound)
	{
		echo "<h1>Sanity Checking Errors</h1>";
		echo "The sanity checker for WRM has determined that your WRM installation may have been compromised.<br><br>";
		echo "Listed below are errors that were found in the WRM installation.  Standard attacks include things like<br>";
		echo "adding 'include' or 'require' lines to external sources in continually run code areas like the config.php<br>";
		echo "file.  The sanity checker has determined that there are one or more problems with your installation.<br>";
		echo "<h3>DO NOT IGNORE THIS WARNING</h3>";
		echo "The first step is to go through the information printed below and fix any problems you see.  If it is listed<br>";
		echo "by the sanity checker it SHOULD NOT BE THERE and should be removed.  Any questions with fixing the content<br>";
		echo "identified below should be directed to http://www.wowraidmanager.net.<br>";
		echo "<br>";
		echo "However, this is only the first step. Somewhere along the line your installation got hacked.  It is imperitive<br>";
		echo "that you determine (or work with us in determining) why your files are bad.  Start with the system you<br>";
		echo "downloaded the installation package to and check it for viruses and malware to ensure it is clean.<br>";
		echo "Next check your webserver/ISP/Host for problems and probably change both your database and website passwords<br>";
		echo "to be safe.  Work with your Hosting Provider to see if there has been any unauthorized access to your account<br>";
		echo "and make sure to report the problem on http://www.wowraidmanager.net in the support forum.<br>";
		echo "<hr>";
		echo "<h3>Errors:</h3>\n";
		echo "<pre>\n";
		print_r($configErrors);
		echo "\n</pre>\n";
		die();
	}
?>