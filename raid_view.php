<?php
/***************************************************************************
 *                         raid_view.php
 *                        -------------------
 *   begin                : Jan 16, 2011
 *	 Dev                  : Carsten Hölbing
 *	 email                : carsten@hoelbing.net
 *
 *   copyright            : (C) 2007-2011 Douglas Wagner
 *   email                : douglasw0@yahoo.com
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

// commons
define("IN_PHPRAID", true);	
require_once('./common.php');
require_once('./includes/functions_raids.php');

// page authentication
if($phpraid_config['anon_view'] == 1)
	define("PAGE_LVL","anonymous");
else
	define("PAGE_LVL","profile");
	
require_once("includes/authentication.php");

// check for mode passing
if (isset($_GET['raid_id']))
{
	$raid_id = scrub_input($_GET['raid_id']);
}
else 
{
	if($raid_id == '' || !is_numeric($raid_id))
		log_hack();
}

//Page URL
$pageURL = 'raid_view.php';

$returnURL = "index.php";

// check for mode passing
isset($_GET['mode']) ? $mode = scrub_input($_GET['mode']) : $mode = '';

/* =====================================================
 *       Mode VIEW
   =====================================================*/
if($mode == 'view')
{
	$profile_id = scrub_input($_SESSION['profile_id']);
	$priv_raids = scrub_input($_SESSION['priv_raids']);	
	
	/**
	 *  Raid Mark Status
	 *  raid status == old => $raid_mark_status = "1"
	 */
	$raid_mark_status = get_raid_mark_status($raid_id);
	
	/*************************************************************
	 * Setup Record Output Information for Data Table
	 *************************************************************/
	// Set StartRecord for Page
	if(!isset($_GET['Base']) || !is_numeric($_GET['Base']))
		$startRecord = 1;
	else
		$startRecord = scrub_input($_GET['Base']);
		
	// Set Sort Field for Page
	if(!isset($_GET['Sort'])||$_GET['Sort']=='')
	{
		$sortField = "";
		$initSort = FALSE;
	}
	else
	{
		$sortField = scrub_input($_GET['Sort']);
		$initSort = TRUE;
	}
			
	// Set Sort Descending Mark
	if(!isset($_GET['SortDescending']) || !is_numeric($_GET['SortDescending']))
		$sortDesc = 0;
	else
		$sortDesc = scrub_input($_GET['SortDescending']);

	/**************************************************************
	 * End Record Output Setup for Data Table
	 **************************************************************/
	
	// This require sets up the flow control surrounding queueing, cancelling and drafting of users.
	require_once('includes/signup_flow.php');	

	// Initialize Class/Role Arrays and Counts.
	$class_info = array();
	$role_info = array();
	
	if ($phpraid_config['raid_view_type'] == 'by_class')
		foreach ($wrm_global_classes as $global_class)
			$class_info[$global_class['class_id']] = array();
	else
		foreach ($wrm_global_roles as $global_role)
			$role_info[$global_role['role_id']] = array();
				
	$raid_queue = array();
	$raid_cancel = array();

	$sql = sprintf(	"SELECT * FROM " . $phpraid_config['db_prefix'] . "raids".
					" WHERE raid_id = %s ", quote_smart($raid_id));
	$raidinfo_result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	$raidinfo_data = $db_raid->sql_fetchrow($raidinfo_result, true);
	
	$raid_min_lvl = $raidinfo_data['min_lvl'];	
	$raid_max_lvl = $raidinfo_data['max_lvl'];
	
	/*******************************************************************************
	 * 	
	 ******************************************************************************/
	// parse the signup array and seperate to classes or roles
	$sql = sprintf(	"SELECT * FROM " . $phpraid_config['db_prefix'] . "signups".
					" WHERE raid_id = %s ", quote_smart($raid_id));
	$signups_result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	while($signups = $db_raid->sql_fetchrow($signups_result, true))
	{
		$signup_signup_id = $signups['signup_id'];
		$signup_char_id = $signups['char_id'];
		$signup_profile_id = $signups['profile_id'];
		$signup_raid_id = $signups['raid_id'];
		$signup_comments = $signups['comments'];
		$signup_signupstatus = get_signup_status($signup_signup_id);
		$signup_timestamp = $signups['timestamp'];
		
		//Get Spec Information.
		$signup_selected_spec = $signups['selected_spec'];		
		
		$race = '';
		$name = '';
		$team_name = '';
		


		// okay, push the value into the array after we
		// get all the character information from the database
		$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "chars WHERE char_id=%s",quote_smart($signups['char_id']));
		$data_result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
		$data = $db_raid->sql_fetchrow($data_result, true);

		$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "teams WHERE char_id=%s and raid_id=%s",quote_smart($signups['char_id']),quote_smart($raid_id));
		$teams_result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
		$teamrow = $db_raid->sql_fetchrow($teams_result, true);

		if ($db_raid->sql_numrows($teams_result) > 0)
		{
			$team_name=$teamrow['team_name'];
		}

		/**********************
		 * Buttons applicable to users who are Signed Up (drafted) for a raid.  Buttons for Queued and Cancelled
		 * Character signups are below.
		 *
		 * This goes to Flow control, see signup_flow.php.
		 *
		 * The function below controls the logic of what users, admins and raid leaders can do
		 * to a character that is signed up for a raid.  The default flow control for this
		 * application is documented in the docs directory under "User_Signup_Flow.txt", if
		 * you wish to change the Signup Flow, please read that document and modify what buttons
		 * are available to each class of user ($user_perm_group) by commenting and uncommenting
		 * the available buttons in signup_flow.php.
		 **********************/
		if ($raid_mark_status == "0")
		{
			$actions = get_SignUp_Buttons($profile_id, $priv_raids, $signup_profile_id, $signup_signup_id, $signup_raid_id, $signup_signupstatus);
		}

		$time = get_date($signup_timestamp);
		$date = $time;

		// Get the proper race/gender image into the $race variable.
		foreach($wrm_global_races as $global_race)
			if ($data['race'] == $global_race['race_id'])
				foreach($wrm_global_gender as $global_gender)
					if ($data['gender'] == $global_gender['gender_id'])
					{
						$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "race_gender WHERE race_id = %s and gender_id = %s", quote_smart($global_race['race_id']),quote_smart($global_gender['gender_id']));
						$result_race_gender = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
						$race_gender_data = $db_raid->sql_fetchrow($result_race_gender, true);
						$race = '<img src="templates/' . $phpraid_config['template'] . $race_gender_data['image'] . '" height="18" width="18" border="0" onMouseover="ddrivetip(\''.$phprlang[$global_race['lang_index']].'\');" onMouseout="hideddrivetip();" alt="'.$phprlang[$global_race['lang_index']].' '.$phprlang[$global_gender['lang_index']].'">';
					}					

		$comments = escapePOPUP(scrub_input($signup_comments));

		if(strlen_wrap($signup_comments, "UTF-8") > 25)
			$comments = '<a href="#" onMouseover="fixedtooltip(\'<span class=tooltip_title>'.$phprlang['comments'].'</span><br>'.$comments.'\',this,event,\'150\')" onMouseout="delayhidetip();">' . substr_wrap($signup_comments, 0, 22, "UTF-8") . '...</a>';
		else
			$comments = UBB(scrub_input($signup_comments));

		if(strlen_wrap($comments, "UTF-8") == 0)
			$comments = '-';


		$sql = sprintf("SELECT role_id,lang_index FROM " . $phpraid_config['db_prefix'] . "class_role WHERE class_id = %s and subclass = %s", quote_smart($data['class']), quote_smart($data['pri_spec']));
		$result_spec_lang = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
		$spec_lang_data = $db_raid->sql_fetchrow($result_spec_lang, true);
		//$pri_spec_lang = $spec_lang_data['lang_index'];
		$pri_spec_role = $spec_lang_data['role_id'];
		$pri_spec_lang_index = $spec_lang_data['lang_index'];
		foreach ($wrm_global_roles as $global_role)
			if($pri_spec_role == $global_role['role_id'])
				$pri_spec_role_name = $global_role['role_name'];
		
		$sql = sprintf("SELECT role_id,lang_index FROM " . $phpraid_config['db_prefix'] . "class_role WHERE class_id = %s and subclass = %s", quote_smart($data['class']), quote_smart($data['sec_spec']));
		$result_spec_lang = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
		$spec_lang_data = $db_raid->sql_fetchrow($result_spec_lang, true);
		//$sec_spec_lang = $spec_lang_data['lang_index'];
		$sec_spec_role = $spec_lang_data['role_id'];
		$sec_spec_lang_index = $spec_lang_data['lang_index'];
		foreach ($wrm_global_roles as $global_role)
			if($sec_spec_role == $global_role['role_id'])
				$sec_spec_role_name = $global_role['role_name'];
			
		if ($signup_selected_spec == $data['pri_spec'])
			$pri_spec = "<b>" . $pri_spec_role_name . ":" . $phprlang[$pri_spec_lang_index] . "</b>";
		else
			$pri_spec = $pri_spec_role_name . ":" . $phprlang[$pri_spec_lang_index];
		if ($signup_selected_spec == $data['sec_spec'])
			$sec_spec = "<b>" . $sec_spec_role_name . ":" . $phprlang[$sec_spec_lang_index] . "</b>";
		else
			$sec_spec = $sec_spec_role_name . ":" . $phprlang[$sec_spec_lang_index];
				
		/*
		$arcane = $data['arcane'];
		$fire = $data['fire'];
		$nature = $data['nature'];
		$frost = $data['frost'];
		$shadow = $data['shadow'];
		*/
		$array_resistance = get_array_char_resistance($data['char_id']);
		
		if ($phpraid_config['enable_armory'])
			$name = get_armorychar($data['name'], $data['guild']);
		else
			$name = $data['name'];
		
		$guildname = '?';

		$name .= check_dupe($data['profile_id'], $raid_id);
		
		// Get the Guild Name to Display instead of Just the ID
		$sql = sprintf("SELECT guild_name FROM " . $phpraid_config['db_prefix'] . "guilds WHERE guild_id=%s",quote_smart($data['guild']));
		$guild_result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
		$guild_data = $db_raid->sql_fetchrow($guild_result, true);
		$guildname = $guild_data['guild_name'];

		if ($signup_signupstatus == "00")
		{
				// now that we have the row, figure out what class or role and push into corresponding array
				if ($phpraid_config['raid_view_type'] == 'by_class')
				{		
					foreach ($wrm_global_classes as $global_class)
					{
						if ($data['class'] == $global_class['class_id'])
						{
							$class = ' <img src="templates/' . $phpraid_config['template'] . '/'. $global_class['image'] .'" height="18" width="18" border="0" onMouseover="ddrivetip(\''.$phprlang[$global_class['lang_index']].'\');" onMouseout="hideddrivetip();" alt="'.$phprlang[$global_class['lang_index']].'">';
							$char_array = 
								array(
										'ID'=>$data['char_id'],
										'Pri_Spec'=>$pri_spec,
										'Sec_Spec'=>$sec_spec,
										'Race'=>$race,
										'Class'=>$class,
										'Name'=>$name,
										'Comments'=>$comments,
										'Level'=>$data['lvl'],
										'Buttons'=>$actions,
										'Date'=>$date,
										'Time'=>$time,
										'Team Name'=>$team_name,
										'Guild'=>$guildname
								);
							
							// add array	
							$char_array = $char_array + $array_resistance;							
							array_push($class_info[$global_class['class_id']],$char_array);

						}	
					}
				}
				else
				{
					foreach ($wrm_global_classes as $global_class)
						if ($data['class'] == $global_class['class_id'])
							$class = ' <img src="templates/' . $phpraid_config['template'] . '/'. $global_class['image'] .'" height="18" width="18" border="0" onMouseover="ddrivetip(\''.$phprlang[$global_class['lang_index']].'\');" onMouseout="hideddrivetip();" alt="'.$phprlang[$global_class['lang_index']].'">';
							
					// Get Role attached to primary spec by looking up in class/role table.
					$sql = sprintf("SELECT role_id FROM " . $phpraid_config['db_prefix'] . "class_role WHERE class_id=%s and subclass=%s",quote_smart($data['class']),quote_smart($signup_selected_spec));
					$role_name_data_result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
					$role_name_data = $db_raid->sql_fetchrow($role_name_data_result, true);
					$role_id = $role_name_data['role_id'];
					foreach ($wrm_global_roles as $global_role)
						if ($role_id == $global_role['role_id'])
						{
							$char_array = 
									array(
											'ID'=>$data['char_id'],
											'Pri_Spec'=>$pri_spec,
											'Sec_Spec'=>$sec_spec,
											'Race'=>$race,
											'Class'=>$class,
											'Name'=>$name,
											'Comments'=>$comments,
											'Level'=>$data['lvl'],
											'Buttons'=>$actions,
											'Date'=>$date,
											'Time'=>$time,
											'Team Name'=>$team_name,
											'Guild'=>$guildname
									);
								
								// add array	
								$char_array = $char_array + $array_resistance;							
								array_push($role_info[$global_role['role_id']],$char_array);
						}						
						/*	array_push($role_info[$global_role['role_id']],
								array(
										'ID'=>$data['char_id'],
										'Arcane'=>$arcane,
										'Fire'=>$fire,
										'Nature'=>$nature,
										'Frost'=>$frost,
										'Shadow'=>$shadow,
										'Pri_Spec'=>$pri_spec,
										'Sec_Spec'=>$sec_spec,
										'Race'=>$race,
										'Class'=>$class,
										'Name'=>$name,
										'Comments'=>$comments,
										'Level'=>$data['lvl'],
										'Buttons'=>$actions,
										'Date'=>$date,
										'Time'=>$time,
										'Team Name'=>$team_name,
										'Guild'=>$guildname
								)
							);
						*/
				}
		}	
		if ($signup_signupstatus == "01")
		{
			array_push($raid_queue, 
				array(
					'ID'=>$data['char_id'],
					'Race'=>$race,
					'Class'=>$class,
					'Name'=>$name,
					'Level'=>$data['lvl'],
					'Pri_Spec'=>$data['pri_spec'],
					'Sec_Spec'=>$data['sec_spec'],
					'Buttons'=>$actions,
					'Date'=>$date,
					'Time'=>$time,
					'Comments'=>$comments,
					'Guild'=>$guildname,
					'Role'=>$role,
					'Signup_Spec'=>$signup_spec_output,
				)
			);
		}
		elseif ($signup_signupstatus == "10")
		{
			array_push($raid_cancel, 
				array(
					'ID'=>$data['char_id'],
					'Race'=>$race,
					'Class'=>$class,
					'Name'=>$name,
					'Level'=>$data['lvl'],
					'Pri_Spec'=>$data['pri_spec'],
					'Sec_Spec'=>$data['sec_spec'],
					'Buttons'=>$actions,
					'Date'=>$date,
					'Time'=>$time,
					'Comments'=>$comments,
					'Guild'=>$guildname,
					'Role'=>$role,
					'Signup_Spec'=>$signup_spec_output,
				)
			);
		}
	}

	/*if($priv_raids != 1 && $user_perm_group['RL'] != 1)
	{
		hideCol('Guild');
	}*/
	
	if ($phpraid_config['raid_view_type'] == 'by_class')
	{
		// Create the Class Drafted Table Views.
		$class_table_array = array();
		$class_data = array();
		foreach ($wrm_global_classes as $global_class)
		{
			$class_data = $class_info[$global_class['class_id']];
			/**************************************************************
			 * Code to setup for a Dynamic Table Create: raidview1 View.
			 **************************************************************/
			$viewName = 'raidview1';
			
			//Setup Columns
			$headers = array();
			$headers = getVisibleColumns($viewName);
		
			//Get Record Counts
			$record_counts = array();
			$record_counts = getRecordCounts($class_data, $headers, $startRecord);
			
			//Get the Jump Menu and pass it down
			$jump_menu = getPageNavigation($class_data, $startRecord, $pageURL, $sortField, $sortDesc);
			
			//Setup Default Data Sort from Headers Table
			if (!$initSort)
				foreach ($headers as $column_rec)
					if ($column_rec['default_sort'])
						$sortField = $column_rec['column_name'];

			//Setup Data
			$class_data = paginateSortAndFormat($class_data, $sortField, $sortDesc, $startRecord, $viewName);
			/****************************************************************
			 * Data Assign for Template.
			 ****************************************************************/
			$header_data = array(
							'template_name'=>$phpraid_config['template'],
							'header'=>$phprlang[$global_class['lang_index']],
							'sort_url_base' => $pageURL,
							'sort_descending' => $sortDesc,
							'sort_text' => $phprlang['sort_text'],			
						);
			
			array_push($class_table_array,
				array(
					'column_name'=>$headers,
					'record_counts'=>$record_counts,
					'jump_menu'=>$jump_menu,
					'header_data'=>$header_data,
					'class_data'=>$class_data,
				)
			);
		}
		$wrmsmarty->assign('class_table', $class_table_array); 
	}
	else
	{
		// Create the Class Drafted Table Views.
		$role_table_array = array();
		$role_data = array();
		foreach ($wrm_global_roles as $global_role)
		{
			if ($global_role['role_name'] != '')
			{
				$role_data = $role_info[$global_role['role_id']];
				/**************************************************************
				 * Code to setup for a Dynamic Table Create: raidview1 View.
				 **************************************************************/
				$viewName = 'raidview1';
				
				//Setup Columns
				$headers = array();
				$headers = getVisibleColumns($viewName);
			
				//Get Record Counts
				$record_counts = array();
				$record_counts = getRecordCounts($role_data, $headers, $startRecord);
				
				//Get the Jump Menu and pass it down
				$jump_menu = getPageNavigation($role_data, $startRecord, $pageURL, $sortField, $sortDesc);

				//Setup Default Data Sort from Headers Table
				if (!$initSort)
					foreach ($headers as $column_rec)
						if ($column_rec['default_sort'])
							$sortField = $column_rec['column_name'];
				
				//Setup Data
				$role_data = paginateSortAndFormat($role_data, $sortField, $sortDesc, $startRecord, $viewName);
				/****************************************************************
				 * Data Assign for Template.
				 ****************************************************************/
				$header_data = array(
								'template_name'=>$phpraid_config['template'],
								'header'=>$global_role['role_name'],
								'sort_url_base' => $pageURL,
								'sort_descending' => $sortDesc,
								'sort_text' => $phprlang['sort_text'],			
							);
				
				array_push($role_table_array,
					array(
						'column_name'=>$headers,
						'record_counts'=>$record_counts,
						'jump_menu'=>$jump_menu,
						'header_data'=>$header_data,
						'role_data'=>$role_data,
					)
				);
			}
		}
		$wrmsmarty->assign('role_table', $role_table_array); 
	}

	/**************************************************************
	 * Code to setup for a Dynamic Table Create: raidview2 View.
	 **************************************************************/
	$viewName = 'raidview2';
	
	//Setup Columns
	$queue_headers = array();
	$record_count_array = array();
	$queue_headers = getVisibleColumns($viewName);
	
	//Get Record Counts
	$queue_record_count_array = getRecordCounts($raid_queue, $queue_headers, $startRecord);
		
	//Get the Jump Menu and pass it down
	$queueJumpMenu = getPageNavigation($raid_queue, $startRecord, $pageURL, $sortField, $sortDesc);

	//Setup Default Data Sort from Headers Table
	if (!$initSort)
		foreach ($queue_headers as $column_rec)
			if ($column_rec['default_sort'])
				$sortField = $column_rec['column_name'];

	//Setup Data
	$raid_queue = paginateSortAndFormat($raid_queue, $sortField, $sortDesc, $startRecord, $viewName);
	/****************************************************************
	 * Data Assign for Template.
	 ****************************************************************/
	$wrmsmarty->assign('queue_data', $raid_queue); 
	$wrmsmarty->assign('queue_jump_menu', $queueJumpMenu);
	$wrmsmarty->assign('queue_column_name', $queue_headers);
	$wrmsmarty->assign('queue_record_counts', $queue_record_count_array);
	$wrmsmarty->assign('queue_header_data',
		array(
			'template_name'=>$phpraid_config['template'],
			'raid_queue_header'=>$phprlang['view_queue_header'],
			'sort_url_base' => $pageURL,
			'sort_descending' => $sortDesc,
			'sort_text' => $phprlang['sort_text'],
		)
	);

	/**************************************************************
	 * Code to setup for a Dynamic Table Create: raidview2 View.
	 **************************************************************/
	$viewName = 'raidview2';
	
	//Setup Columns
	$cancel_headers = array();
	$record_count_array = array();
	$cancel_headers = getVisibleColumns($viewName);
	
	//Get Record Counts
	$cancel_record_count_array = getRecordCounts($raid_cancel, $cancel_headers, $startRecord);
		
	//Get the Jump Menu and pass it down
	$cancelJumpMenu = getPageNavigation($raid_cancel, $startRecord, $pageURL, $sortField, $sortDesc);

	//Setup Default Data Sort from Headers Table
	if (!$initSort)
		foreach ($cancel_headers as $column_rec)
			if ($column_rec['default_sort'])
				$sortField = $column_rec['column_name'];

	//Setup Data
	$raid_cancel = paginateSortAndFormat($raid_cancel, $sortField, $sortDesc, $startRecord, $viewName);
	/****************************************************************
	 * Data Assign for Template.
	 ****************************************************************/
	$wrmsmarty->assign('cancel_data', $raid_cancel); 
	$wrmsmarty->assign('cancel_jump_menu', $cancelJumpMenu);
	$wrmsmarty->assign('cancel_column_name', $cancel_headers);
	$wrmsmarty->assign('cancel_record_counts', $cancel_record_count_array);
	$wrmsmarty->assign('cancel_header_data',
		array(
			'template_name'=>$phpraid_config['template'],
			'raid_cancel_header'=>$phprlang['view_cancel_header'],
			'sort_url_base' => $pageURL,
			'sort_descending' => $sortDesc,
			'sort_text' => $phprlang['sort_text'],
		)
	);
	
	// last but not least, tooltips for class breakdown
	$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "raids WHERE raid_id=%s",quote_smart($raid_id));
	$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	$data = $db_raid->sql_fetchrow($result, true);

	//Get Raid Total Counts
	$count = get_char_count($raid_id, $type='');
	$count2 = get_char_count($raid_id, $type='queue');		
	foreach ($wrm_global_classes as $global_class)
		$total += $count[$global_class['class_id']];
	foreach ($wrm_global_classes as $global_class)
		$total2 += $count2[$global_class['class_id']];
	//$count = get_char_count($raid_id, $type='');
	//$count2 = get_char_count($raid_id, $type='queue');
	
	// Now that we have the raid data, we need to retrieve limit data based upon Raid ID.
	// Get Class Limits and set Colored Counts
	$raid_class_array = array();
	$class_color_count = array();
	$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "raid_class_lmt WHERE raid_id = %s", quote_smart($data['raid_id']));
	$result_raid_class = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	while($raid_class_data = $db_raid->sql_fetchrow($result_raid_class, true))
	{
		$raid_class_array[$raid_class_data['class_id']] = $raid_class_data['lmt'];
		if($phpraid_config['class_as_min'])
			$class_color_count[$raid_class_data['class_id']] = get_coloredcount($raid_class_data['class_id'], $count[$raid_class_data['class_id']], $raid_class_array[$raid_class_data['class_id']], $count2[$raid_class_data['class_id']], true);
		else
			$class_color_count[$raid_class_data['class_id']] = get_coloredcount($raid_class_data['class_id'], $count[$raid_class_data['class_id']], $raid_class_array[$raid_class_data['class_id']], $count2[$raid_class_data['class_id']]);
	}
	// Get Role Limits and set Colored Counts
	$raid_role_array = array();
	$role_color_count = array();
	$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "raid_role_lmt WHERE raid_id = %s", quote_smart($data['raid_id']));
	$result_raid_role = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	while($raid_role_data = $db_raid->sql_fetchrow($result_raid_role, true))
	{
		$sql2 = sprintf("SELECT role_name FROM " . $phpraid_config['db_prefix'] . "roles WHERE role_id = %s", quote_smart($raid_role_data['role_id']));
		$result_role_name = $db_raid->sql_query($sql2) or print_error($sql2, $db_raid->sql_error(), 1);
		$role_name = $db_raid->sql_fetchrow($result_role_name, true);
		
		$raid_role_array[$role_name['role_name']] = $raid_role_data['lmt'];
		$role_color_count[$role_name['role_name']] = get_coloredcount($role_name['role_name'], $count[$raid_role_data['role_id']], $raid_role_array[$role_name['role_name']], $count2[$raid_role_data['role_id']]);
	}		

	// check to see if they have permissions to signup
	$show_signup = 1;
	//raid_view.php?mode=view&raid_id=3#signup
	$raid_notice = "<a href=\"raid_signup.php?mode=signup&raid_id=".$raid_id." #asignup\">" . $phprlang['view_ok'] . "</a>";

	// check if raid is frozen
	if($phpraid_config['disable_freeze'] == 0)
	{
		if(check_frozen($raid_id)) {
			$show_signup = 0;
			$raid_notice = $phprlang['view_frozen'];
		}
	}

	// check if already signed up
	if($phpraid_config['multiple_signups'] == 0)
	{
		$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "signups WHERE raid_id=%s AND profile_id=%s",quote_smart($raid_id),quote_smart($profile_id));
		$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
		if($db_raid->sql_numrows($result) > 0)
		{
			$show_signup = 0;
			$raid_notice = $phprlang['view_signed'];
		}
	}

	// check if they have chars and that they have at least one within the range limit
	$sql = sprintf(	"SELECT * FROM " . $phpraid_config['db_prefix'] . "chars " .
					"	WHERE profile_id=%s AND lvl<=%s AND lvl>=%s",
					quote_smart($profile_id),quote_smart($raid_max_lvl),quote_smart($raid_min_lvl));
	$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	$char_count = $db_raid->sql_numrows($result);
	if($char_count <= 0)
	{
		$show_signup = 0;
		$raid_notice = '<a href="profile_char.php?mode=view">' . $phprlang['view_create'] . '</a>';
	}

	// check if any of their characters belong to the guild that the raid force is specfiying.
	if ($data['raid_force_name'] != 'All')
	{
		$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "raid_force WHERE raid_force_name=%s", quote_smart($data['raid_force_name']));
		$raid_force_result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
		$char_in_guild_check = false;
		while($raid_force_data = $db_raid->sql_fetchrow($raid_force_result, true))
		{
			$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "chars WHERE 
								profile_id=%s AND guild=%s", quote_smart($profile_id), 
							quote_smart($raid_force_data['guild_id']));
			$char_in_guild_result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
			$char_count = $db_raid->sql_numrows($char_in_guild_result);
			if($char_count > 0)
				$char_in_guild_check = true;
		}
		if (!$char_in_guild_check)
		{
			$show_signup = 0;
			$raid_notice = '<a href="profile_char.php?mode=view">' . $phprlang['view_create'] . '</a>';
		}
	}
	
	if($_SESSION['priv_profile'] == 0)
	{
		$show_signup = 0;
		$raid_notice = $phprlang['view_login'];
	}
	
	// finally, icons
	$class_icons = array();
	foreach ($wrm_global_classes as $global_class)
		$class_icons[$global_class['class_id']] = '<a href="#'.$global_class['lang_index'].'" onMouseover="ddrivetip(\''.$phprlang[$global_class['lang_index']].'\');" onMouseout="hideddrivetip();"><img src="templates/'.$phpraid_config['template'].'/'.$global_class['image'].'" width="24" height="24" border="0" alt="'.$global_class['class_id'].'"></a>'; 

	// And now create the link to the team assignment/creation form and view missing signups but only if RL or RA.
	if ($user_perm_group['admin'] OR $user_perm_group['RL'])
	{
		$team_link = '<a href="teams.php?mode=view&amp;raid_id=' . $raid_id . '">' . $phprlang['view_teams_link_text'] . '</a>';
		$missing_link = '<a href="missing_signups.php?raid_id=' . $raid_id . '">' . $phprlang['view_missing_signups_link_text'] . '</a>';
	}
	else
	{
		$team_link="";
		$missing_link = "";
	}

	$wrmsmarty->assign('raid_view',
		array(
			'team_link'=>$team_link,
			'missing_link'=>$missing_link,
			'raid_location'=>$raid_location,
			'raid_officer'=>$raid_officer,
			'raid_date'=>$raid_date,
		//	'raid_invite_time'=>$raid_invite_time,
		//	'raid_start_time'=>$raid_start_time,
		//	'raid_cancel'=>$raid_cancel,
			'raid_max'=>$raid_max,
			'raid_max_percentage'=>$raid_max_percentage,
			'raid_min_lvl'=>$raid_min_lvl,
			'raid_max_lvl'=>$raid_max_lvl,
			'raid_count'=>$raid_count,
			'raid_count_percentage'=>$raid_count_percentage,
			'raid_cancel_count'=>$raid_cancel_count,
			'raid_cancel_percentage'=>$raid_cancel_count_percentage,
			'raid_queue_count'=>$raid_queue_count,
			'raid_queue_count_percentage'=>$raid_queue_count_percentage,
			'raid_total'=>$raid_total,
			'raid_open'=>$raid_open,
			'raid_notice'=>$raid_notice,
			'raid_description'=>$raid_description,
			'cancel_text'=>$phprlang['view_raid_cancel_text'],
			'raid_description_header'=>$phprlang['view_description_header'],
			'location_text'=>$phprlang['view_location'],
			'date_text'=>$phprlang['view_date'],
			'officer_text'=>$phprlang['view_officer'],
			'invite_text'=>$phprlang['view_invite'],
			'start_text'=>$phprlang['view_start'],
			'signup_text'=>$phprlang['view_signup'],
			'minlvl_text'=>$phprlang['view_min_lvl'],
			'maxlvl_text'=>$phprlang['view_max_lvl'],
			'maxattendees_text'=>$phprlang['view_max'],
			'approved_text'=>$phprlang['view_approved'],
			'queued_text'=>$phprlang['view_queued'],
			'total_text'=>$phprlang['view_total'],
			'information_header'=>$phprlang['view_information_header'],
			'statistics_header'=>$phprlang['view_statistics_header'],
			'raid_force'=>$data['raid_force_name'],
			'raid_force_text'=>$phprlang['raid_force_name'],
		)
	);
	
	$raid_info_array = get_array_allInfo_from_RaidID($raid_id);
	$wrmsmarty->assign('raid_view',
		array(
			'form_action' => $form_action,
			'raid_description_header' => $phprlang['view_description_header'],
			'raid_description' => $raid_info_array['description'] ,
			'information_header' => $phprlang['view_information_header'],
			'statistics_header' => $phprlang['view_statistics_header']  ,
			'location_text' => $phprlang['view_location'] ,
			'raid_location' => $raid_info_array['location'] ,
			'officer_text' => $phprlang['view_officer'] , 
			'raid_officer' => $raid_info_array['officer'] ,
			'raid_force_text' => $phprlang['raid_force_name'] ,
			'raid_force' => $raid_info_array['raid_force_name'] ,
			'date_text' => $phprlang['view_date'] ,
			'raid_date' => $raid_info_array['date'] ,
			'invite_text' => $phprlang['view_invite'] ,
			'raid_invite_time' => $raid_info_array['invite_time'] ,
			'start_text' => $phprlang['view_start'] ,
			'raid_start_time' => $raid_info_array['start_time'] ,
			'signup_text' => $phprlang['view_signup'] ,
			'raid_signup' => $raid_notice ,
			'minlvl_text' => $phprlang['view_min_lvl'] ,
			'raid_min_lvl' => $raid_info_array['min_lvl'] ,
			'maxlvl_text' => $phprlang['view_max_lvl'] ,
			'raid_max_lvl' => $raid_info_array['max_lvl'] ,
			'maxattendees_text' => $phprlang['view_max'] ,
			'raid_max' => $raid_info_array['max'] ,
			'approved_text' => $phprlang['view_approved'] ,
			'raid_count_percentage' => $raid_count_percentage ,
			'queued_text' => $phprlang['view_queued'] ,
			'raid_queue_count' => $raid_info_array['queue_count'] ,
			'raid_queue_count_percentage' => ($raid_info_array['queue_count']/$raid_info_array['count_total'])*100 ,
			'cancel_text' => $phprlang['view_cancel_header'] ,
			'raid_cancel_count' => $raid_info_array['count_chancel'] ,
			'raid_cancel_percentage' => ($raid_info_array['count_chancel']/$raid_info_array['count_total'])*100 ,
			'total_text' => $phprlang['view_total'] ,
			'raid_total' => $raid_info_array['count_total'] , 
		)
	);		
	$class_count_icon = array();
	$role_count_icon = array();
	
	foreach ($wrm_global_classes as $global_class)
	{
		array_push($class_count_icon,
			array(
				'count'=>$class_color_count[$global_class['class_id']],
				'icon'=>$class_icons[$global_class['class_id']],
			)
		);
	}
	foreach ($wrm_global_roles as $global_role)
	{
		if ($global_role['role_name'] != '')
			array_push($role_count_icon,
				array(
					'count'=>$role_color_count[$global_role['role_name']],
					'text'=>$global_role['role_name'],
				)
			);
	}
		
	$wrmsmarty->assign('class_count_icon', $class_count_icon);
	$wrmsmarty->assign('role_count_icon', $role_count_icon);
	
	
	
	/**
	 * 
	 */
	require_once('./includes/page_header.php');
	
	// output
	if ($phpraid_config['raid_view_type'] == 'by_class')
		$wrmsmarty->display('raid_view_class.html');
	else
		$wrmsmarty->display('raid_view_role.html');	
	
	
	require_once('./includes/page_footer.php');	
}
elseif($mode == 'switch_spec')
{
	//Retrieve Values
	$raid_id = scrub_input($_GET['raid_id']);
	$signup_id = scrub_input($_GET['signup_id']);
	$spec = scrub_input($_GET['spec']);
	$sort_mode = scrub_input($_GET['Sort']);
	$sort_descending = scrub_input($_GET['SortDescending']);
	
	// Update the Signups Table with the selected spec and forward back to the view page.
	$sql = sprintf("UPDATE " . $phpraid_config['db_prefix'] . "signups set selected_spec=%s WHERE signup_id=%s", quote_smart($spec), quote_smart($signup_id));
	$db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);

	header("Location: " . $pageURL . "?mode=view&raid_id=$raid_id&Sort=$sort_mode&SortDescending=$sort_descending");
}
?>