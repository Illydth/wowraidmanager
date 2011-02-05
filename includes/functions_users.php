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

function check_frozen($raid_id) 
{
	global $db_raid, $phpraid_config;
	
	$sql = sprintf(	"SELECT * FROM `" . $phpraid_config['db_prefix'] . "raids` " .
					" WHERE raid_id = %s", quote_smart($raid_id));
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

function get_char_count($raid_id, $type) 
{
	global $db_raid, $phpraid_config, $phprlang;
	global $wrm_global_classes, $wrm_global_roles;

	foreach ($wrm_global_classes as $global_class)
		$count[$global_class['class_id']]='0';
	foreach ($wrm_global_roles as $global_role)
		$count[$global_role['role_id']]='0';
		
	if($type == "queue") //Count Queued Signups
	{
		$sql = sprintf(	"SELECT * FROM `" . $phpraid_config['db_prefix'] . "signups` " .
						" WHERE queue = '1' AND cancel = '0' AND raid_id = %s", quote_smart($raid_id));		
	}
	elseif($type == "cancel") //Count Cancelled Signups
	{
		$sql = sprintf(	"SELECT * FROM `" . $phpraid_config['db_prefix'] . "signups` " .
						" WHERE queue = '0' AND cancel = '1' AND raid_id = %s", quote_smart($raid_id));			
	}
	else //Count Drafted Signups
	{
		$sql = sprintf(	"SELECT * FROM `" . $phpraid_config['db_prefix'] . "signups` " .
						" WHERE queue = '0' AND cancel = '0' AND raid_id = %s", quote_smart($raid_id));			
	}

	$result_signups = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	while($signups = $db_raid->sql_fetchrow($result_signups, true)) 
	{
		$sql = sprintf(	"SELECT * FROM `" . $phpraid_config['db_prefix'] . "chars` ".
						" WHERE char_id = %s",quote_smart($signups['char_id']));
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
		$sql = sprintf(	"SELECT * FROM `" . $phpraid_config['db_prefix'] . "class_role` " .
						" WHERE subclass = %s",quote_smart($signups['selected_spec']));
		$result_spec = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
		$role_id = $db_raid->sql_fetchrow($result_spec, true);
		
		// Handle Roles based upon what's in the Role table.
		foreach ($wrm_global_roles as $global_role)	
			if ($role_id['role_id'] == $global_role['role_id'])
				$count[$global_role['role_id']]++;			
	}

	return $count;
}

function get_priv_name($permission_type_id)
{
	global $db_raid, $phpraid_config;
	
	$sql = sprintf(	"SELECT `permission_type_name` FROM `" . $phpraid_config['db_prefix'] . "permission_type` " .
					" WHERE permission_type_id = %s",quote_smart($permission_type_id));
	$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	$data = $db_raid->sql_fetchrow($result, true);

	return($data['permission_type_name']);
}

// old or unused
function get_signups($raid_id) 
{
	global $db_raid, $phpraid_config;

	$signups = array();
	
	$sql = sprintf(	"SELECT * FROM `" . $phpraid_config['db_prefix'] . "signups` " .
					" WHERE raid_id = %s", quote_smart($raid_id));
	$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	while($data = $db_raid->sql_fetchrow($result, true))
	{
			// match, push onto array
			array_push($signups, 
				array(
						'pos'=>$data['pos'],
						'char_id'=>$data['char_id']
				)
			);
	}

	// sort by position so we make sure to output them in order
	array_multisort($signups);

	return $signups;
}

function is_char_cancel($profile_id, $raid_id)
{
	global $db_raid, $phpraid_config;
	
	$sql = sprintf(	"SELECT * FROM `" . $phpraid_config['db_prefix'] . "signups` " .
					" WHERE cancel = '1' AND profile_id = %s AND raid_id = %s",
					quote_smart($profile_id), quote_smart($raid_id));
	$result = $db_raid->sql_query($sql);

	if($db_raid->sql_numrows($result) == 0)
		return 0;
	else
		return 1;
}

function is_char_signed($profile_id, $raid_id)
{
	global $db_raid, $phpraid_config;
	
	$sql = sprintf(	"SELECT * FROM `" . $phpraid_config['db_prefix'] . "signups` " .
					" WHERE profile_id = %s AND raid_id = %s",
					quote_smart($profile_id), quote_smart($raid_id));
	$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	if($db_raid->sql_numrows($result) > 0)
		return 1;
	else
		return 0;
}

function isCharExist($charName) 
{
	global $db_raid, $phpraid_config;

	$sql = sprintf(	"SELECT * FROM `" . $phpraid_config['db_prefix'] . "chars` ".
					" WHERE name = %s",quote_smart(ucfirst(trim($charName))));
	$result = $db_raid->sql_query($sql);
	return $db_raid->sql_numrows($result);
}

//return profile name from the selected profile_id
function get_user_name($profile_id)
{
	global $db_raid, $phpraid_config;
	
	$sql = sprintf(	"SELECT `username` FROM `" . $phpraid_config['db_prefix'] . "profile` " .
					" WHERE profile_id = %s",quote_smart($profile_id));
	$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	$data = $db_raid->sql_fetchrow($result);

	return($data['username']);
}

//return name from the char
function get_char_name($char_id)
{
	global $db_raid, $phpraid_config;
	
	$sql = sprintf(	"SELECT `name` FROM `" . $phpraid_config['db_prefix'] . "chars` " .
					" WHERE char_id = %s",quote_smart($char_id));
	$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	$data = $db_raid->sql_fetchrow($result);

	return($data['name']);
}

function has_char_multiple_signups($profile_id, $raid_id) 
{
	global $db_raid, $phpraid_config;

	$sql = sprintf(	"SELECT * FROM `" . $phpraid_config['db_prefix'] . "signups` " .
					" WHERE cancel = '0' AND profile_id = %s AND raid_id = %s",
					quote_smart($profile_id),quote_smart($raid_id));
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
 * add a new Character to WRM DB
 * @param $profile
 * @param $name
 * @param $class
 * @param $gender
 * @param $guild
 * @param $level
 * @param $race
 * @param $array_resistance
 * @param $pri_spec
 * @param $sec_spec
 */
function char_addnew($profile,$char_name,$class,$gender,$guild,$level,$race,$array_resistance,$pri_spec,$sec_spec)
{
	global $db_raid, $phpraid_config;

	$sql = sprintf(	"INSERT INTO `" . $phpraid_config['db_prefix'] . "chars` " .
					"	(`profile_id`,`name`,`class`, `gender`,`guild`,`lvl`,`race`," .
					"	 `pri_spec`,`sec_spec`)" .
					" VALUES(%s,%s,%s,%s,%s,%s,%s,%s,%s)",
				quote_smart($profile), quote_smart($char_name), quote_smart($class),
				quote_smart($gender), quote_smart($guild), quote_smart($level), quote_smart($race),
				quote_smart($pri_spec), quote_smart($sec_spec)
			);

	$db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	
	$sql = sprintf(	"SELECT `char_id` ".
					" FROM `" . $phpraid_config['db_prefix'] . "chars`".
					" WHERE name = %s", quote_smart($char_name)
			);
	$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);	
	$char_id = $db_raid->sql_fetchrow($result, true);

	for ($i=0; $i< count($array_resistance);$i++)
	{
		$sql = sprintf(	"INSERT INTO `" . $phpraid_config['db_prefix'] . "char_resistance` " .
						"	(`resistance_id`,`char_id`,`resistance_value`)".
						" VALUES(%s,%s,%s)",
					quote_smart($array_resistance[$i]['resistance_id']), 
					quote_smart($char_id),
					quote_smart($array_resistance[$i]['char_resistance_value'])
				);
		$db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);			
	}
	
	log_create('character',mysql_insert_id(),$char_name);

	return(0);
}

function char_edit($char_name,$level,$race,$class,$gender,$guild,$array_resistance,$pri_spec,$sec_spec,$char_id)
{
	global $db_raid, $phpraid_config;

	$sql = sprintf(	"UPDATE `" . $phpraid_config['db_prefix'] . "chars` " .
					"	SET name = %s, lvl = %s, race = %s, class = %s, gender = %s, guild = %s," .
					"	pri_spec = %s, sec_spec = %s WHERE char_id = %s",
					quote_smart($char_name),quote_smart($level),quote_smart($race),
					quote_smart($class), quote_smart($gender), quote_smart($guild),
					quote_smart($pri_spec),quote_smart($sec_spec),quote_smart($char_id));

	$db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);

	for ($i=0; $i< count($array_resistance);$i++)
	{
		$sql = sprintf(	"UPDATE `" . $phpraid_config['db_prefix'] . "char_resistance` " .
						"	SET resistance_value = %s ".
						"	WHERE resistance_id = %s AND char_id = %s",
						quote_smart($array_resistance[$i]['char_resistance_value']),
						quote_smart($array_resistance[$i]['resistance_id']),
						quote_smart($char_id)
				);
		$db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);			
	}
	return(1);
}

function char_delete($char_id,$profile_id)
{
	global $db_raid, $phpraid_config;

	log_delete('character',get_char_name($char_id));

	$sql = sprintf("DELETE FROM `" . $phpraid_config['db_prefix'] . "chars` ".
					" WHERE char_id = %s AND profile_id = %s",
					quote_smart($char_id), quote_smart($profile_id));
	$db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);

	$sql = sprintf( "DELETE FROM `" . $phpraid_config['db_prefix'] . "signups` " .
					" WHERE char_id = %s AND profile_id = %s",
					quote_smart($char_id), quote_smart($profile_id));
	$db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);

	$sql = sprintf( "DELETE FROM `" . $phpraid_config['db_prefix'] . "char_resistance` ".
					" WHERE char_id = %s ",quote_smart($char_id));
	$db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
		
	return (1);
}

function check_dupe($profile_id, $raid_id)
{
	if(has_char_multiple_signups($profile_id, $raid_id))
	{
		return '&nbsp;' . get_dupesignup_symbol() . '&nbsp;(@&nbsp;<a href="profile_char.php?mode=details&amp;user_id=' . $profile_id . '">' . get_user_name($profile_id) . '</a>)';
	}
	return '';
}

function get_array_spec_from_char($char_id)
{
	global $db_raid, $phpraid_config;	
	
	$sql = sprintf(	"SELECT `pri_spec`,`sec_spec` ".
					" FROM `" . $phpraid_config['db_prefix'] . "chars`".
					" WHERE char_id = %s", quote_smart($char_id)
			);
	$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);	
	$array_data = $db_raid->sql_fetchrow($result, true);

	return ( array($array_data['pri_spec'],$array_data['sec_spec']) );
}

function get_array_char_resistance($char_id)
{
	global $db_raid, $phpraid_config;
	$array_resistance = array();
	
	$sql = sprintf("SELECT a.resistance_value, b.resistance_name".
					" FROM `"  . $phpraid_config['db_prefix'] . "char_resistance` a, " .
					"		`". $phpraid_config['db_prefix'] . "resistance` b ".
					" WHERE a.resistance_id = b.resistance_id ".
					" AND char_id = %s", quote_smart($char_id));
	$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	while($data_resist = $db_raid->sql_fetchrow($result, true))
	{
		$array_resistance[$data_resist['resistance_name']] = $data_resist['resistance_value'];
	}
	
	return $array_resistance;
}

/**
 * 
 * return, in which permission group the user (profile) are
 * @param integer $profile_id
 */
function get_permission_id($profile_id)
{
	global $db_raid, $phpraid_config;

	$sql = sprintf(	"SELECT `priv` ".
					" FROM `" . $phpraid_config['db_prefix'] . "profile` ".
					" WHERE profile_id = %s", quote_smart($profile_id));
	$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	$data = $db_raid->sql_fetchrow($result, true);
	
	return ($data['priv']);	
}

/**
 * 
 * Check if profil_id rights for config "raids"
 * @param unknown_type $profile_id
 */
function has_user_rights_raids($profile_id)
{
	global $db_raid, $phpraid_config;

	$sql = sprintf(	"SELECT `raid_id` ".
					" FROM `" . $phpraid_config['db_prefix'] . "signup` ".
					" WHERE profile_id = %s", quote_smart($profile_id));
	$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	$data = $db_raid->sql_fetchrow($result, true);
	
	return ($data['raid_id']);		
}

/**
 * UPDATE Profil Settings
 * @param Integer $profile_id
 * @param String $profile_email
 */
function update_profile($profile_id, $profile_email)
{
	global $db_raid, $phpraid_config;
	
	$sql = sprintf(	"UPDATE `".$phpraid_config['db_prefix']."profile` " .
					" SET `email` = %s " .
					" WHERE `profile_id` = %s;", 
					quote_smart($profile_email), quote_smart($profile_id)
			);
	$db_raid->sql_query($sql) or print_error($sql,$db_raid->sql_error(),1);
}

?>