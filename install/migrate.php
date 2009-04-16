<?php
	// Class require_onces
	require_once($phpraid_dir.'../version.php');
	require_once($phpraid_dir.'../config.php');
	require_once($phpraid_dir.'../includes/functions.php');
	require_once($phpraid_dir.'../includes/functions_mysql.php');
	require_once($phpraid_dir.'../includes/functions_auth.php');
	require_once($phpraid_dir.'../includes/functions_date.php');
	require_once($phpraid_dir.'../includes/functions_logging.php');
	require_once($phpraid_dir.'../includes/functions_tables.php');
	require_once($phpraid_dir.'../includes/functions_users.php');
	require_once($phpraid_dir.'../includes/ubb.php');
	
	// database connection
	global $db_raid, $errorTitle, $errorMsg, $errorDie;
	$db_raid = &new sql_db($phpraid_config['db_host'],$phpraid_config['db_user'],$phpraid_config['db_pass'],$phpraid_config['db_name']);
	
	if(!$db_raid->db_connect_id)
	{
		die('<div align="center"><strong>There appears to be a problem with the database server.<br>We should be back up shortly.</strong></div>');
	}

	// unset database password for security reasons
	// we won't use it after this point
	unset($phpraid_config['db_pass']);
	
	/***************************************************
	 * Load Game Specific Data to Global Variables
	 ***************************************************/
	$wrm_global_classes = array();
	$wrm_global_races = array();
	$wrm_global_roles = array();
	$wrm_global_gender = array();
	
	// Load the Classes Array
	$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "classes";
	$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
	$x = 0;
	while($data = $db_raid->sql_fetchrow($result, true))
	{
		$wrm_global_classes[$x]['class_id'] = $data['class_id'];
		$wrm_global_classes[$x]['class_code'] = $data['class_code'];
		$wrm_global_classes[$x]['lang_index'] = $data['lang_index'];
		$wrm_global_classes[$x]['image'] = $data['image'];
		$x++;
	}
	
	// Load the Races Array
	$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "races";
	$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
	$x = 0;			
	while($data = $db_raid->sql_fetchrow($result, true))
	{
		$wrm_global_races[$x]['race_id'] = $data['race_id'];
		$wrm_global_races[$x]['faction'] = $data['faction'];
		$wrm_global_races[$x]['lang_index'] = $data['lang_index'];
		$x++;
	}
	
	// Load the Roles Array
	$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "roles";
	$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
	$x = 0;			
	while($data = $db_raid->sql_fetchrow($result, true))
	{
		$wrm_global_roles[$x]['role_id'] = $data['role_id'];
		$wrm_global_roles[$x]['role_name'] = $data['role_name'];
		$wrm_global_roles[$x]['lang_index'] = $data['lang_index'];
		$wrm_global_roles[$x]['image'] = $data['image'];
		$x++;
	}
	
	// Load the Gender Array
	$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "gender";
	$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
	$x = 0;			
	while($data = $db_raid->sql_fetchrow($result, true))
	{
		$wrm_global_gender[$x]['gender_id'] = $data['gender_id'];
		$wrm_global_gender[$x]['lang_index'] = $data['lang_index'];
		$x++;
	}
	
	echo "<br>Processing Locations:<hr>";
	// Pull list of all database locations.
	$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "locations";
	$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
	while($loc_data = $db_raid->sql_fetchrow($result, true))
	{
		echo "<br>Processing Location: " . $loc_data['location_id'] . " : " . $loc_data['name'];
		foreach($wrm_global_classes as $global_class)
		{
			echo "<br>    Processing Class: " . $global_class['class_id'] . " and Limit: " . $loc_data[$global_class['class_code']];
			$sql = sprintf("INSERT INTO " . $phpraid_config['db_prefix'] . "loc_class_lmt 
						VALUES (%s, %s, %s)", quote_smart($loc_data['location_id']), 
						quote_smart($global_class['class_id']), $loc_data[$global_class['class_code']]);

			$db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
		}
		foreach($wrm_global_roles as $global_role)
		{
			if ($loc_data[$global_role['role_id']] != 0)
			{
				echo "<br>    Processing role: " . $global_role['role_id'] . " and Limit: " . $loc_data[$global_role['role_id']];
				$sql = sprintf("INSERT INTO " . $phpraid_config['db_prefix'] . "loc_role_lmt 
							VALUES (%s, %s, %s)", quote_smart($loc_data['location_id']), 
							quote_smart($global_role['role_id']), $loc_data[$global_role['role_id']]);
	
				$db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
			}
		}
	}
	
	echo "<br><hr>Processing Raids:<hr>";
	// Pull list of all database raids.
	$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "raids";
	$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
	while($raid_data = $db_raid->sql_fetchrow($result, true))
	{
		echo "<br>Processing Raid: " . $raid_data['raid_id'] . " : " . $raid_data['location'];
		foreach($wrm_global_classes as $global_class)
		{
			echo "<br>    Processing Class: " . $global_class['class_id'] . " and Limit: " . $raid_data[$global_class['class_code'].'_lmt'];
			$sql = sprintf("INSERT INTO " . $phpraid_config['db_prefix'] . "raid_class_lmt 
						VALUES (%s, %s, %s)", quote_smart($raid_data['raid_id']), 
						quote_smart($global_class['class_id']), $raid_data[$global_class['class_code'].'_lmt']);

			$db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
		}
		foreach($wrm_global_roles as $global_role)
		{
			if ($raid_data[$global_role['role_id']."_lmt"] != 0)
			{
				echo "<br>    Processing role: " . $global_role['role_id'] . " and Limit: " . $raid_data[$global_role['role_id'].'_lmt'];
				$sql = sprintf("INSERT INTO " . $phpraid_config['db_prefix'] . "raid_role_lmt 
							VALUES (%s, %s, %s)", quote_smart($raid_data['raid_id']), 
							quote_smart($global_role['role_id']), $raid_data[$global_role['role_id'].'_lmt']);
	
				$db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
			}
		}
	}
	
	echo "<br><br><b>All Raids and Locations are now Processed.  Continue by running the 'Data Migration Prior to Run' section</b>";
?>