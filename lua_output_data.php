<?php

class Output_Data
{
	function GetOptions()
	{
		global $phpraid_config;

		//$phpraid_config['lua_output_sort_signups']
		//$phpraid_config['lua_output_sort_queue']
		//	1=name, 2=date, 3=class

		if (!array_key_exists('lua_output_sort_signups', $phpraid_config))
		{
			$phpraid_config['lua_output_sort_signups'] = 1;
		}
		if (!array_key_exists('lua_output_sort_queue', $phpraid_config))
		{
			$phpraid_config['lua_output_sort_queue'] = 2;
		}
	}

	function ShowOptions()
	{
		global $db_raid, $text, $phpraid_config;

		$selected[1] = ($phpraid_config['lua_output_sort_signups'] == 1) ? 'SELECTED' : '';
		$selected[2] = ($phpraid_config['lua_output_sort_signups'] == 2) ? 'SELECTED' : '';
		$selected[3] = ($phpraid_config['lua_output_sort_queue'] == 1) ? 'SELECTED' : '';
		$selected[4] = ($phpraid_config['lua_output_sort_queue'] == 2) ? 'SELECTED' : '';
		$selected[5] = ($phpraid_config['lua_output_sort_queue'] == 3) ? 'SELECTED' : '';

		$text .= '<form method="post" action="lua_output.php?raid_id='.$_GET['raid_id'].' name="post">';
		$text .= '<table width="200" align="center">';
		$text .= '<tr><th colspan="2">Options</th></tr>';
		$text .= '<tr>';
		$text .= '<td>Sort signups by:</td>';
		$text .= '<td><select name="config[lua_output_sort_signups]" size=1 maxlength="256">';
		$text .= '<option '.$selected[1].' value="1">Name</option>';
		$text .= '<option '.$selected[2].' value="2">Date</option>';
		$text .= '</select></td>';
		$text .= '</tr><tr>';
		$text .= '<td>Sort queue by:</td>';
		$text .= '<td><select name="config[lua_output_sort_queue]" size=1 maxlength="256">';
		$text .= '<option '.$selected[3].' value="1">Name</option>';
		$text .= '<option '.$selected[4].' value="2">Date</option>';
		$text .= '<option '.$selected[5].' value="3">Class</option>';
		$text .= '</select></td>';
		$text .= '</tr>';
		$text .= '<tr>';
		$text .= '<td align="left" colspan="2"><input type="submit" name="parse" value="Apply options" class="mainoption" /></td>';
		$text .= '</tr>';
		$text .= '</table>';
		$text .= '</form>';
	}

	function UpdateOptions()
	{
		global $db_raid, $phpraid_config;

		$phpraid_config['lua_output_sort_signups'] = mysql_escape_string($_POST['config']['lua_output_sort_signups']);
		$phpraid_config['lua_output_sort_queue'] = mysql_escape_string($_POST['config']['lua_output_sort_queue']);

		$sql = "SELECT config_name FROM `".$phpraid_config['db_prefix']."config` WHERE `config_name`= 'lua_output_sort_signups';";
		$result = $db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
		if ($db_raid->sql_numrows($result) != 0)
		{
			$sql = "UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value`='".$phpraid_config['lua_output_sort_signups']."' WHERE `config_name`= 'lua_output_sort_signups';";
		}
		else
		{
			$sql = "INSERT INTO `".$phpraid_config['db_prefix']."config` (`config_name`, `config_value`) VALUES('lua_output_sort_signups', '".$phpraid_config['lua_output_sort_signups']."');";
		}
		$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);

		$sql = "SELECT config_name FROM `".$phpraid_config['db_prefix']."config` WHERE `config_name`= 'lua_output_sort_queue';";
		$result = $db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
		if ($db_raid->sql_numrows($result) != 0)
		{
			$sql = "UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value`='".$phpraid_config['lua_output_sort_queue']."' WHERE `config_name`= 'lua_output_sort_queue';";
		}
		else
		{
			$sql = "INSERT INTO `".$phpraid_config['db_prefix']."config` (`config_name`, `config_value`) VALUES('lua_output_sort_queue', '".$phpraid_config['lua_output_sort_queue']."');";
		}
		$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	}

	function GetClassIdByClassName($class)
	{
		global $phprlang;

		switch(strtolower($class))
		{
			case strtolower($phprlang['druid']):
				return 1;
			case strtolower($phprlang['hunter']):
				return 2;
			case strtolower($phprlang['mage']):
				return 3;
			case strtolower($phprlang['paladin']):
				return 4;
			case strtolower($phprlang['priest']):
				return 5;
			case strtolower($phprlang['rogue']):
				return 6;
			case strtolower($phprlang['shaman']):
				return 7;
			case strtolower($phprlang['warlock']):
				return 8;
			case strtolower($phprlang['warrior']):
				return 9;
		}
	}

	function GetClassNameByClassId($id)
	{
		global $phprlang;

		switch($id)
		{
			case 0:
				return 'queue';
			case 1:
				return 'druids';
			case 2:
				return 'hunters';
			case 3:
				return 'mages';
			case 4:
				return 'paladins';
			case 5:
				return 'priests';
			case 6:
				return 'rogues';
			case 7:
				return 'shaman';
			case 8:
				return 'warlocks';
			case 9:
				return 'warriors';
		}
	}

	function Output_Macro()
	{
		global $db_raid, $text, $phpraid_config;

		// macro output
		// non-queued first
		$text .= "<b>Macro output listing...</b>";
		$text .= '<table width="100%"><tr>';
		$text .= "<td>Non-queued users</td>";
		$text .= "<td>Queued users</td></tr>";
		$text .= '<tr><td width="50%"><textarea rows="10" cols="60" style="width: 100%">';

		$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "signups WHERE raid_id=%s AND queue='0' AND cancel='0'",quote_smart($_GET['raid_id']));
		$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
		while($data = $db_raid->sql_fetchrow($result))
		{
			$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "chars WHERE char_id=%s",quote_smart($data['char_id']));
			$result2 = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
			$data2 = $db_raid->sql_fetchrow($result2);
			$data2['name'] = ucfirst(strtolower($data2['name']));
			$text .= "/i {$data2['name']}\n";
		}

		$text .= '</textarea></td>';
		$text .= '<td width="50%"><textarea rows="10" cols="60" style="width: 100%">';

		$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "signups WHERE raid_id=%s AND queue='1' AND cancel='0'",quote_smart($_GET['raid_id']));
		$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
		while($data = $db_raid->sql_fetchrow($result))
		{
			$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "chars WHERE char_id='" . $data['char_id'] . "'";
			$result2 = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
			$data2 = $db_raid->sql_fetchrow($result2);
			$data2['name'] = ucfirst(strtolower($data2['name']));
			$text .= "/i {$data2['name']}\n";
		}
		$text .= '</textarea></td></tr></table>';
		$text .= "<b><br>Macro output listing complete.<br>";
		$text .= "Copy and paste the above to a macro and run in-game</b>";
	}

	function Output_Lua()
	{
		global $db_raid, $text, $phpraid_config;

		$lua_version = "31";

		$text .= "<b>Beginning LUA output</b><br>";

		// open/create file
		$file = fopen('./raid_lua/phpRaid_Data.lua','w');

		// sql query
		$sql_where = 'old=0';
		if (isset($_GET['raid_id']) && is_numeric($_GET['raid_id']))
		{
			$text .= "<a href=\"lua_output.php\">Output all open raids</a><br><br>";
			$sql_where = "raid_id=".quote_smart($_GET['raid_id']);
		}
		$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "raids WHERE ".$sql_where." ORDER BY invite_time ASC";
		$raids_result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);

		// base output
		$lua_output  = "phpRaid_Data = {\n";
		$lua_output .= "\t[\"lua_version\"] = \"{$lua_version}\",\n";
		$lua_output .= "\t[\"raid_count\"] = \"".$db_raid->sql_numrows($raids_result)."\",\n";
		$lua_output .= "\t[\"raids\"] = {\n";

		// parse result
		$count = 0;
		while($raid_data = $db_raid->sql_fetchrow($raids_result))
		{
			$lua_output .= "\t\t[{$count}] = {\n";
			$lua_output .= "\t\t\t[\"location\"] = \"{$raid_data['location']}\",\n";
			$lua_output .= "\t\t\t[\"date\"] = \"" . new_date($phpraid_config['date_format'],$raid_data['invite_time'],$phpraid_config['timezone'] + $phpraid_config['dst']) . "\",\n";
			$lua_output .= "\t\t\t[\"invite_time\"] = \"" . new_date($phpraid_config['time_format'],$raid_data['invite_time'],$phpraid_config['timezone'] + $phpraid_config['dst']) . "\",\n";
			$lua_output .= "\t\t\t[\"start_time\"] = \"" . new_date($phpraid_config['time_format'],$raid_data['start_time'],$phpraid_config['timezone'] + $phpraid_config['dst']) . "\",\n";

			// sql string for signups
			$sql = "SELECT ".$phpraid_config['db_prefix']."signups.comments AS comment,
						   ".$phpraid_config['db_prefix']."signups.timestamp AS timestamp,
						   ".$phpraid_config['db_prefix']."chars.name AS name,
						   ".$phpraid_config['db_prefix']."chars.lvl AS lvl,
						   ".$phpraid_config['db_prefix']."chars.race AS race,
						   ".$phpraid_config['db_prefix']."chars.class AS class
					FROM ".$phpraid_config['db_prefix']."signups
					LEFT JOIN ".$phpraid_config['db_prefix']."chars ON
						".$phpraid_config['db_prefix']."chars.char_id = ".$phpraid_config['db_prefix']."signups.char_id
					WHERE ".$phpraid_config['db_prefix']."signups.raid_id = ".$raid_data['raid_id']."
						AND ".$phpraid_config['db_prefix']."signups.cancel = 0
						AND ".$phpraid_config['db_prefix']."signups.queue = ";

			// get data signed up
			$order_by = '';
			$signups = array();
			if ($phpraid_config['lua_output_sort_signups'] == 1)
				$order_by = 'ORDER BY '.$phpraid_config['db_prefix'].'chars.name ASC';
			elseif ($phpraid_config['lua_output_sort_signups'] == 2)
				$order_by = 'ORDER BY '.$phpraid_config['db_prefix'].'signups.timestamp ASC';
			$sql1 = $sql."0 ".$order_by.";";
			$signup_result = $db_raid->sql_query($sql1) or print_error($sql1, mysql_error(), 1);
			while($signup = $db_raid->sql_fetchrow($signup_result))
			{

				array_push($signups, array(
					'name'		=> ucfirst(strtolower($signup['name'])),
					'level'		=> $signup['lvl'],
					'race'		=> $signup['race'],
					'class'		=> $signup['class'],
					'comment'	=> preg_replace("/\r|\n/s", " ", str_replace('"', '\"', $signup['comment'])),
					'timestamp'	=> new_date($phpraid_config['date_format'],$signup['timestamp'],$phpraid_config['timezone'] + $phpraid_config['dst']) . ' - ' . new_date($phpraid_config['time_format'],$signup['timestamp'],$phpraid_config['timezone'] + $phpraid_config['dst']),
				));
			}

			// get data queue
			$order_by = '';
			$queue = array();
			if ($phpraid_config['lua_output_sort_queue'] == 1)
				$order_by = 'ORDER BY '.$phpraid_config['db_prefix'].'chars.name ASC';
			elseif ($phpraid_config['lua_output_sort_queue'] == 2)
				$order_by = 'ORDER BY '.$phpraid_config['db_prefix'].'signups.timestamp ASC';
			elseif ($phpraid_config['lua_output_sort_queue'] == 3)
				$order_by = 'ORDER BY '.$phpraid_config['db_prefix'].'chars.class ASC';
			$sql1 = $sql."1 ".$order_by.";";
			$signup_result = $db_raid->sql_query($sql1) or print_error($sql1, mysql_error(), 1);
			while($signup = $db_raid->sql_fetchrow($signup_result))
			{

				array_push($queue, array(
					'name'		=> ucfirst(strtolower($signup['name'])),
					'level'		=> $signup['lvl'],
					'race'		=> $signup['race'],
					'class'		=> $signup['class'],
					'comment'	=> preg_replace("/\r|\n/s", " ", str_replace('"', '\"', $signup['comment'])),
					'timestamp'	=> new_date($phpraid_config['date_format'],$signup['timestamp'],$phpraid_config['timezone'] + $phpraid_config['dst']) . ' - ' . new_date($phpraid_config['time_format'],$signup['timestamp'],$phpraid_config['timezone'] + $phpraid_config['dst']),
				));
			}

			// begin - add data to lua output
			for($i=0; $i<10; $i++)
				$lua_signups[$i] = "\t\t\t[\"".$this->GetClassNameByClassId($i)."\"] = {\n";

			// init counter vars
			$cnt[0] = 0;
			$cnt[1] = 0;
			$cnt[2] = 0;
			$cnt[3] = 0;
			$cnt[4] = 0;
			$cnt[5] = 0;
			$cnt[6] = 0;
			$cnt[7] = 0;
			$cnt[8] = 0;
			$cnt[9] = 0;

			foreach($queue as $char)
			{
				$lua_signups[0] .= "\t\t\t\t[{$cnt[0]}] = {\n";
				$lua_signups[0] .= "\t\t\t\t\t[\"name\"] = \"{$char['name']}\",\n";
				$lua_signups[0] .= "\t\t\t\t\t[\"level\"] = \"{$char['level']}\",\n";
				$lua_signups[0] .= "\t\t\t\t\t[\"class\"] = \"".$char['class']."\",\n";
				$lua_signups[0] .= "\t\t\t\t\t[\"race\"] = \"{$char['race']}\",\n";
				$lua_signups[0] .= "\t\t\t\t\t[\"comment\"] = \"{$char['comment']}\",\n";
				$lua_signups[0] .= "\t\t\t\t\t[\"timestamp\"] = \"{$char['timestamp']}\",\n";
				$lua_signups[0] .= "\t\t\t\t},\n";
				$cnt[0]++;
			}

			foreach($signups as $char)
			{
				$class_id = $this->GetClassIdByClassName($char['class']);
				$lua_signups[$class_id] .= "\t\t\t\t[{$cnt[$class_id]}] = {\n";
				$lua_signups[$class_id] .= "\t\t\t\t\t[\"name\"] = \"{$char['name']}\",\n";
				$lua_signups[$class_id] .= "\t\t\t\t\t[\"level\"] = \"{$char['level']}\",\n";
				$lua_signups[$class_id] .= "\t\t\t\t\t[\"class\"] = \"".$char['class']."\",\n";
				$lua_signups[$class_id] .= "\t\t\t\t\t[\"race\"] = \"{$char['race']}\",\n";
				$lua_signups[$class_id] .= "\t\t\t\t\t[\"comment\"] = \"{$char['comment']}\",\n";
				$lua_signups[$class_id] .= "\t\t\t\t\t[\"timestamp\"] = \"{$char['timestamp']}\",\n";
				$lua_signups[$class_id] .= "\t\t\t\t},\n";
				$cnt[$class_id]++;
			}

			// add class counts
			$lua_output .= "\t\t\t[\"queue_count\"] = \"".$cnt[0]."\",\n";
			$lua_output .= "\t\t\t[\"druids_count\"] = \"".$cnt[1]."\",\n";
			$lua_output .= "\t\t\t[\"hunters_count\"] = \"".$cnt[2]."\",\n";
			$lua_output .= "\t\t\t[\"mages_count\"] = \"".$cnt[3]."\",\n";
			$lua_output .= "\t\t\t[\"paladins_count\"] = \"".$cnt[4]."\",\n";
			$lua_output .= "\t\t\t[\"priests_count\"] = \"".$cnt[5]."\",\n";
			$lua_output .= "\t\t\t[\"rogues_count\"] = \"".$cnt[6]."\",\n";
			$lua_output .= "\t\t\t[\"shaman_count\"] = \"".$cnt[7]."\",\n";
			$lua_output .= "\t\t\t[\"warlocks_count\"] = \"".$cnt[8]."\",\n";
			$lua_output .= "\t\t\t[\"warriors_count\"] = \"".$cnt[9]."\",\n";

			for($i=0; $i<10; $i++)
				$lua_output .= $lua_signups[$i] . "\t\t\t},\n";
			$lua_output .= "\t\t},\n";

			$count++;
		}
		$lua_output .= "\t}\n}";
		// end - add data to lua output

		// write to file
		fwrite($file,utf8_encode($lua_output));

		// output to textarea
		$text .= 'LUA file created.</b><br>';
		$text .= 'Download <a href="./raid_lua/phpRaid_Data.lua">phpRaid_Data.lua</a> and save it to [wow-dir]\interface\addons\phpraidviewer\<br>';
		$text .= 'or use this for copy+paste:<br>';
		$text .= '<textarea rows="10" cols="60" style="width: 100%">';
		$text .= $lua_output;
		$text .= '</textarea><br><br><br>';
		//$output = str_replace("\n","<br>",$output);
		//echo '<br><br>' . $output;
	}
}

global $text;
$text = '';

$Output_Data = new Output_Data;
if (array_key_exists('config', $_POST))
	$Output_Data->UpdateOptions();
$Output_Data->GetOptions();
$Output_Data->ShowOptions();
$Output_Data->Output_Lua();
if (isset($_GET['raid_id']) && is_numeric($_GET['raid_id']))
	$Output_Data->Output_Macro();
?>