<?php 
	// variable declarations
	
	define("IN_PHPRAID",true);
	$rootPath = dirname($_SERVER['PHP_SELF']);
	
	require_once('./common.php');

	// url to phpRaid installation (no trailing slash)
	if (isset($phpraid_config['rss_site_url']))
		$phpraid_url = $phpraid_config['rss_site_url'];
	else
		$phpraid_url = 'http://localhost/phpraid';

	// url to the site you want to display this information
	if (isset($phpraid_config['rss_export_url']))
		$site_url = $phpraid_config['rss_export_url'];
	else
		$site_url = 'http://localhost/phpraid';

	// how many feeds do you want to show?
	if (isset($phpraid_config['rss_feed_amt']))
		$feeds = $phpraid_config['rss_feed_amt'];
	else
		$feeds = 5;
	
	// get raid information in ascending order
	$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "raids ORDER BY start_time ASC";
	$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
	
	// variable to count iterations
	// stopping at $feeds iterations
	$i = 0;
	
	// couple useful variables	
	echo 
		'<?xml version="1.0" encoding="UTF-8"?>
			<!DOCTYPE rss PUBLIC "-//Netscape Communications//DTD RSS 0.91//EN" "http://my.netscape.com/publish/formats/rss-0.91.dtd">
			<rss version="0.91">
			<channel>
			<title>' . $phpraid_config['guild_name'] .' Raids</title>
			<link>' . $site_url . '</link>
			<description>'. $phpraid_config['guild_name'] .' @ '. $phpraid_config['guild_server'] . ' Raids</description>
			<language>en-us</language>
		';
	
	while(($data = $db_raid->sql_fetchrow($result)) && ($i < $feeds))
	{
		$raid_id = $data['raid_id'];

		$raidloc = htmlentities($phpraid_url . '/view.php?mode=view&raid_id='.$data['raid_id']);
		$rssloc = htmlentities($data['location']);
    	$rssdesc = htmlentities(nl2br($data['description']));
		
		$date = htmlentities(new_date($phpraid_config['date_format'],$data['start_time'],$phpraid_config['timezone'] + $phpraid_config['dst']));
		$invite = htmlentities(new_date($phpraid_config['time_format'], $data['invite_time'],$phpraid_config['timezone'] + $phpraid_config['dst']));
		
		echo "<item>\r\n
				\t<title>$rssloc - $date @ $invite</title>\r\n
				\t<description>$rssdesc</description>\r\n
				\t<link>$raidloc</link>\r\n
			</item>\n
		";
	}
	
	echo "</channel>
		</rss>
		";
?>