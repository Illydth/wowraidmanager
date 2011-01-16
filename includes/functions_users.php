<?php
/***************************************************************************
*                           functions_users.php
*                           ---------------------
*   begin                : Friday, May 26, 2006
*   copyright            : (C) 2007-2008 Douglas Wagner
*   email                : douglasw@wagnerweb.org
*
*   $Id: functions_users.php,v 2.00 2008/03/03 15:24:16 psotfx Exp $
*
***************************************************************************/

/***************************************************************************
*
*    WoW Raid Manager - Raid Management Software for World of Warcraft
*    Copyright (C) 2007-2008 Douglas Wagner
*
*    This program is free software: you can redistribute it and/or modify
*    it under the terms of the GNU General Public License as published by
*    the Free Software Foundation, either version 3 of the License, or
*    (at your option) any later version.
*
*    This program is distributed in the hope that it will be useful,
*    but WITHOUT ANY WARRANTY; without even the implied warranty of
*    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*    GNU General Public License for more details.
*
*    You should have received a copy of the GNU General Public License
*    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*
****************************************************************************/

function check_frozen($raid_id) {
	global $db_raid, $phpraid_config;

	$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "raids where raid_id='$raid_id'";
	$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	$data = $db_raid->sql_fetchrow($result, true);

 	$raid_date_month = new_date("m",$data['start_time'],$phpraid_config['timezone'] + $phpraid_config['dst']);
	$raid_date_day = new_date("d",$data['start_time'],$phpraid_config['timezone'] + $phpraid_config['dst']);
	$raid_date_year = new_date("Y",$data['start_time'],$phpraid_config['timezone'] + $phpraid_config['dst']);
	$raid_time_hour = new_date("H",$data['invite_time'],$phpraid_config['timezone'] + $phpraid_config['dst']);
	$raid_time_minute = new_date("i",$data['invite_time'],$phpraid_config['timezone'] + $phpraid_config['dst']);
	$cur_date_month = new_date("m",time(),$phpraid_config['timezone'] + $phpraid_config['dst']);
	$cur_date_day = new_date("d",time(),$phpraid_config['timezone'] + $phpraid_config['dst']);
	$cur_date_year = new_date("Y",time(),$phpraid_config['timezone'] + $phpraid_config['dst']);
	$cur_time_hour = new_date("H",time(),$phpraid_config['timezone'] + $phpraid_config['dst']);
	$cur_time_minute = new_date("i",time(),$phpraid_config['timezone'] + $phpraid_config['dst']);
	$freeze = $data['freeze'];

	// check if raid is frozen
	if($phpraid_config['disable_freeze'] == 0)
	{
		$frozen = 0;

		if($raid_date_year < $cur_date_year)
		{
			$frozen = 1;
		}
		elseif($raid_date_year == $cur_date_year)
		{
			if($raid_date_month < $cur_date_month)
			{
				$frozen = 1;
			}
			elseif($raid_date_month == $cur_date_month)
			{
				if($raid_date_day < $cur_date_day)
				{
					$frozen = 1;
				}
				elseif($raid_date_day == $cur_date_day)
				{
					if($raid_time_hour < ($cur_time_hour + $freeze))
					{
						$frozen = 1;
					}
					elseif($raid_time_hour == ($cur_time_hour + $freeze))
					{
						if($raid_time_minute < $cur_time_minute)
							$frozen = 1;
					}
				}
			}
		}
	}

	return $frozen;
}

function get_char_count($id, $type) {
	global $db_raid, $phpraid_config, $phprlang, $wrm_global_classes, $wrm_global_roles;

	//$count = array('dk'=>'0','dr'=>'0','hu'=>'0','ma'=>'0','pa'=>'0','pr'=>'0','ro'=>'0','sh'=>'0','wk'=>'0','wa'=>'0','role1'=>'0','role2'=>'0','role3'=>'0','role4'=>'0','role5'=>'0','role6'=>'0');
	foreach ($wrm_global_classes as $global_class)
		$count[$global_class['class_id']]='0';
	foreach ($wrm_global_roles as $global_role)
		$count[$global_role['role_id']]='0';
		
	if($type == "queue") //Count Queued Signups
	{
		$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "signups WHERE raid_id='$id' AND queue='1' AND cancel='0'";
		$result_signups = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	}
	elseif($type == "cancel") //Count Cancelled Signups
	{
		$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "signups WHERE raid_id='$id' AND queue='0' AND cancel='1'";
		$result_signups = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);		
	}
	else //Count Drafted Signups
	{
		$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "signups WHERE raid_id='$id' AND queue='0' AND cancel='0'";
		$result_signups = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	}
	while($signups = $db_raid->sql_fetchrow($result_signups, true)) {
		$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "chars WHERE char_id='{$signups['char_id']}'";
		$result_char = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
		$char = $db_raid->sql_fetchrow($result_char, true);

		foreach ($wrm_global_classes as $global_class)
		{
			if ($char['class'] == $global_class['class_id'])
			{
				$count[$global_class['class_id']]++;
				break;
			}
		}

		// Get Role from Spec
		$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "class_role WHERE subclass=%s", quote_smart($signups['selected_spec']));
		$result_spec = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
		$role_id = $db_raid->sql_fetchrow($result_spec, true);
		
		// Handle Roles based upon what's in the Role table.
		foreach ($wrm_global_roles as $global_role)	
			if ($role_id['role_id'] == $global_role['role_id'])
				$count[$global_role['role_id']]++;			
	}

	return $count;
}

function get_priv_name($id)
{
	global $db_raid, $phpraid_config;

	$sql = "SELECT `name` FROM " . $phpraid_config['db_prefix'] . "permissions WHERE permission_id='$id'";
	$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	$data = $db_raid->sql_fetchrow($result, true);

	return($data['name']);
}

function get_queued($raid_id) {
	global $db_raid, $phpraid_config;

	$queued = array();

	$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "queues";
	$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	while($data = $db_raid->sql_fetchrow($result, true)) {
		if($raid_id == $data['raid_id']) {
			// match, push onto array
			array_push($queued, array('pos'=>$data['pos'],'char_id'=>$data['char_id']));
		}
	}

	// sort by position so we make sure to output them in order
	array_multisort($queued);

	return $queued;
}

function get_signups($raid_id) {
	global $db_raid, $phpraid_config;

	$signups = array();

	$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "signups";
	$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	while($data = $db_raid->sql_fetchrow($result, true)) 	{
		if($raid_id == $data['raid_id']) {
			// match, push onto array
			array_push($signups, array('pos'=>$data['pos'],'char_id'=>$data['char_id']));
		}
	}

	// sort by position so we make sure to output them in order
	array_multisort($signups);

	return $signups;
}

function is_char_cancel($profile_id, $raid_id) {
	global $db_raid, $phpraid_config;

	$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "signups WHERE profile_id='$profile_id' AND raid_id='$raid_id' AND cancel='1'";
	$result = $db_raid->sql_query($sql);

	if($db_raid->sql_numrows($result) == 0)
		return 0;
	else
		return 1;
}

function is_char_signed($profile_id, $raid_id) {
	global $db_raid, $phpraid_config;

	$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "signups WHERE profile_id='$profile_id' AND raid_id='$raid_id'";
	$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	if($db_raid->sql_numrows($result) > 0)
		return 1;
	else
		return 0;
}

function isCharExist($charName) {
	global $db_raid, $phpraid_config;

	$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "chars WHERE name='".ucfirst(trim($charName))."'";
	$result = $db_raid->sql_query($sql);
	return $db_raid->sql_numrows($result);
}

function get_user_name($profile_id)
{
	global $db_raid, $phpraid_config;

	$sql = "SELECT `username` FROM " . $phpraid_config['db_prefix'] . "profile WHERE profile_id='$profile_id'";
	$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	$data = $db_raid->sql_fetchrow($result);

	return($data['username']);
}

function get_char_name($char_id)
{
	global $db_raid, $phpraid_config;

	$sql = "SELECT `name` FROM " . $phpraid_config['db_prefix'] . "chars WHERE char_id='$char_id'";
	$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	$data = $db_raid->sql_fetchrow($result);

	return($data['name']);
}

function has_char_multiple_signups($profile_id, $raid_id) {
	global $db_raid, $phpraid_config;

	$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "signups WHERE profile_id='$profile_id' AND raid_id='$raid_id' AND cancel='0'";
	$result = $db_raid->sql_query($sql);

	if($db_raid->sql_numrows($result) > 1)
	{
		// check if there is more than one signed-up user for this raid
		$signup_count = 0;
		while($data = $db_raid->sql_fetchrow($result))
		{
			// exclude external sign-ups
			$name = get_char_name($data['char_id']);
			if(!(substr_wrap($name, 0, 1, "UTF-8") == '_' || substr_wrap($name, 0, 1, "UTF-8") == '(' && substr_wrap($name, strlen_wrap($name, "UTF-8") - 1, 1, "UTF-8") == ')'))
			{
				$signup_count += 1;
				if($signup_count > 1)
				{
					return 1;
				}
			}
		}
	}
	return 0;
}
/**
 * add a new Character
 * @param $profile
 * @param $name
 * @param $class
 * @param $gender
 * @param $guild
 * @param $level
 * @param $race
 * @param $arcane
 * @param $fire
 * @param $frost
 * @param $nature
 * @param $shadow
 * @param $pri_spec
 * @param $sec_spec
 */
function char_addnew($profile,$name,$class,$gender,$guild,$level,$race,$arcane="0",$fire="0",$frost="0",$nature="0",$shadow="0",$pri_spec,$sec_spec)
{
	global $db_raid, $phpraid_config;

	$sql = sprintf(	"INSERT INTO " . $phpraid_config['db_prefix'] . "chars" .
					"	(`profile_id`,`name`,`class`, `gender`,`guild`,`lvl`,`race`," .
					"	 `arcane`,`fire`,`frost`,`nature`,`shadow`,`pri_spec`,`sec_spec`)" .
					" VALUES(%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)",
				quote_smart($profile), quote_smart($name), quote_smart($class),
				quote_smart($gender), quote_smart($guild), quote_smart($level), quote_smart($race),
				quote_smart($arcane), quote_smart($fire), quote_smart($frost), quote_smart($nature),
				quote_smart($shadow), quote_smart($pri_spec), quote_smart($sec_spec)
			);

	$db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);

	log_create('character',mysql_insert_id(),$name);

	return(0);
}

function char_edit($name,$level,$race,$class,$gender,$guild,$arcane="0",$nature="0",$shadow="0",$fire="0",$frost="0",$pri_spec,$sec_spec,$char_id)
{
	global $db_raid, $phpraid_config;

	$sql = sprintf(	"UPDATE " . $phpraid_config['db_prefix'] . "chars " .
					"	SET name=%s,lvl=%s,race=%s, class=%s,gender=%s,guild=%s," .
					"	arcane=%s,nature=%s,shadow=%s,fire=%s,frost=%s," .
					"	pri_spec=%s,sec_spec=%s WHERE char_id=%s",
					quote_smart($name),quote_smart($level),quote_smart($race),
					quote_smart($class), quote_smart($gender), quote_smart($guild),
					quote_smart($arcane),quote_smart($nature),quote_smart($shadow),quote_smart($fire),
					quote_smart($frost),quote_smart($pri_spec),quote_smart($sec_spec),quote_smart($char_id));

	$db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);

	return(1);
}

function char_delete($char_id,$profile_id)
{
	global $db_raid, $phpraid_config;

	//log_delete('character',$n);

	$sql = sprintf("DELETE FROM " . $phpraid_config['db_prefix'] . "chars WHERE char_id=%s AND profile_id=%s",quote_smart($char_id), quote_smart($profile_id));
	$db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);

	$sql = sprintf("DELETE FROM " . $phpraid_config['db_prefix'] . "signups WHERE char_id=%s AND profile_id=%s",quote_smart($char_id), quote_smart($profile_id));
	$db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);

	return (1);
}

function check_dupe($profile_id, $raid_id)
{
	if(has_char_multiple_signups($profile_id, $raid_id))
	{
		return '&nbsp;' . get_dupesignup_symbol() . '&nbsp;(@&nbsp;<a href="users.php?mode=details&amp;user_id=' . $profile_id . '">' . get_user_name($profile_id) . '</a>)';
	}
	return '';
}

?>