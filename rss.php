<?php
header('Content-type: application/rss+xml; charset=utf-8');
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

	echo '<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom"><channel><atom:link href="'. $site_url . '/rss.php" rel="self" type="application/rss+xml" />' . PHP_EOL;
	$sql = "SELECT icon_path, event_id FROM " . $phpraid_config['db_prefix'] . "events";
	$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	while ($row = mysql_fetch_assoc($result)) {
		$imgpath[$row['event_id']] = $row['icon_path'];
	}
   
	// how many feeds do you want to show?
	if (isset($phpraid_config['rss_feed_amt']))
		$feeds = $phpraid_config['rss_feed_amt'];
	else
		$feeds = 5;

	// get raid information in ascending order
	$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "raids WHERE old = 0 AND recurrance = 0 ORDER BY start_time ASC";
	$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);

	// variable to count iterations
	// stopping at $feeds iterations
	$i = 0;

	// couple useful variables

	echo   '<title>' . $phpraid_config['site_name'] .' Raids</title>
			<link>' . $site_url . '</link>
			<description>'. $phpraid_config['site_name'] .' @ '. $phpraid_config['site_server'] . ' Raids</description>
			<language>en-us</language>
	';

	while(($data = $db_raid->sql_fetchrow($result, true)) && ($i < $feeds))
	{
		$raid_id = $data['raid_id'];
		$icon = $imgpath[$data['event_id']];
		$raidloc = htmlentities($phpraid_url . '/view.php?mode=view&raid_id='.$data['raid_id']);
		$rssloc = htmlentities($data['location']);
		$description = sprintf ("<img src=\"%s/templates/default/%s\"> %s", $site_url, $icon, $data['description']);
		$rssdesc = htmlentities(nl2br($description));

		$date = htmlentities(new_date($phpraid_config['date_format'],$data['start_time'],$phpraid_config['timezone'] + $phpraid_config['dst']));
		$invite = htmlentities(new_date($phpraid_config['time_format'], $data['invite_time'],$phpraid_config['timezone'] + $phpraid_config['dst']));

		echo "<item>\r\n
			\t<title>$rssloc - $date @ $invite</title>\r\n
			\t<description>$rssdesc</description>\r\n
			\t<link>$raidloc</link>\r\n
			\t<guid>$raidloc</guid>\r\n
			</item>\n
		";
		$i++;
	}

	echo "</channel>
			</rss>
	";
?>