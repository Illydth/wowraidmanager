<?php
/***************************************************************************
 *                                profile.php
 *                            -------------------
 *   begin                : Saturday, Jan 16, 2005
 *   copyright            : (C) 2007-2008 Douglas Wagner
 *   email                : douglasw@wagnerweb.org
 *
 *   $Id: profile.php,v 2.00 2008/03/08 14:28:18 psotfx Exp $
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

// page authentication
define("PAGE_LVL","profile");
require_once("includes/authentication.php");

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
	$sortField="";
	$initSort=FALSE;
}
else
{
	$sortField = scrub_input($_GET['Sort']);
	$initSort=TRUE;
}
	
// Set Sort Descending Mark
if(!isset($_GET['SortDescending']) || !is_numeric($_GET['SortDescending']))
	$sortDesc = 0;
else
	$sortDesc = scrub_input($_GET['SortDescending']);
	
$pageURL = 'profile.php?mode=view&';
/**************************************************************
 * End Record Output Setup for Data Table
 **************************************************************/

if($_GET['mode'] == 'view') {
	$chars = array();
	
	// now that we have their profile_id, let's get a list of all their characters
	$profile_id = scrub_input($_SESSION['profile_id']);
	$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "chars WHERE profile_id=%s",quote_smart($profile_id));
	$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
	while($data = $db_raid->sql_fetchrow($result, true))
	{
		// Get Armory Data for Character
		if ($phpraid_config['enable_armory'])
			$charname = get_armorychar($data['name'], $data['guild']);
		else
			$charname = $data['name'];
			
		// Get the Internationalized data to display from the database values:
		foreach ($wrm_global_races as $global_race)
			if ($data['race'] == $global_race['race_id'])
				$race = $phprlang[$global_race['lang_index']];

		foreach ($wrm_global_classes as $global_class)
			if ($data['class'] == $global_class['class_id'])
				$class = $phprlang[$global_class['lang_index']];
				
		// Get the Guild Name to Display instead of Just the ID
		$sql = sprintf("SELECT guild_name FROM " . $phpraid_config['db_prefix'] . "guilds WHERE guild_id=%s",quote_smart($data['guild']));
		$guild_result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
		$guild_data = $db_raid->sql_fetchrow($guild_result, true);
		$guild_name = $guild_data['guild_name'];
		
		array_push($chars,
			array(
				'ID'=>$data['char_id'],
				'Name'=>$charname,
				'Guild'=>$guild_name,
				'Level'=>$data['lvl'],
				'Race'=>$race,
				'Class'=>$class,
				'Arcane'=>$data['arcane'],
				'Fire'=>$data['fire'],
				'Frost'=>$data['frost'],
				'Nature'=>$data['nature'],
				'Shadow'=>$data['shadow'],
				'Pri_Spec'=>$data['pri_spec'],
				'Sec_Spec'=>$data['sec_spec'],
				'Buttons'=>'<a href="profile.php?mode=remove&amp;n='.$data['name'].'&amp;id='.$data['char_id'].'"><img src="templates/' . $phpraid_config['template'] . '/images/icons/icon_delete.gif" border="0" onMouseover="ddrivetip(\''. $phprlang['delete'] .'\');" onMouseout="hideddrivetip();" alt="delete icon"></a>
					 <a href="profile.php?mode=edit&amp;race='.$data['race'].'&amp;id='.$data['char_id'].'"><img src="templates/' . $phpraid_config['template'] . '/images/icons/icon_edit.gif" border="0" onMouseover="ddrivetip(\'' . $phprlang['edit'] .'\');" onMouseout="hideddrivetip();" alt="edit icon"></a>')
			);
	}

	/**************************************************************
	 * Code to setup for a Dynamic Table Create: guild1 View.
	 **************************************************************/
	$viewName = 'char1';
	
	//Setup Columns
	$char_headers = array();
	$record_count_array = array();
	$char_headers = getVisibleColumns($viewName);

	//Get Record Counts
	$char_record_count_array = getRecordCounts($chars, $char_headers, $startRecord);
	
	//Get the Jump Menu and pass it down
	$charJumpMenu = getPageNavigation($chars, $startRecord, $pageURL, $sortField, $sortDesc);
			
	//Setup Default Data Sort from Headers Table
	if (!$initSort)
		foreach ($char_headers as $column_rec)
			if ($column_rec['default_sort'])
				$sortField = $column_rec['column_name'];

	//Setup Data
	$chars = paginateSortAndFormat($chars, $sortField, $sortDesc, $startRecord, $viewName);

	/****************************************************************
	 * Data Assign for Template.
	 ****************************************************************/
	$wrmsmarty->assign('char_data', $chars); 
	$wrmsmarty->assign('char_jump_menu', $charJumpMenu);
	$wrmsmarty->assign('char_column_name', $char_headers);
	$wrmsmarty->assign('char_record_counts', $char_record_count_array);
	
	// time to get a list of raids that they've signed up for
	$raid_list = array();
	$count = array();
	$count2 = array();
	$raid_loop_cur = 0;
	$raid_loop_prev = 0;
	
	$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "signups WHERE profile_id=%s", quote_smart($profile_id));
	$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
	while($signups = $db_raid->sql_fetchrow($result, true))
	{
		// Initialize Count Array and Totals.
		foreach ($wrm_global_classes as $global_class)
		{
			$count[$global_class['class_id']]='0';
			$count2[$global_class['class_id']]='0';
		}		
		foreach ($wrm_global_roles as $global_role)
		{	
			$count[$global_role['role_id']]='0';
			$count2[$global_role['role_id']]='0';
		}
		$total = 0;
		$total2 = 0;
		
		$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "raids WHERE raid_id=%s", quote_smart($signups['raid_id']));
		$result_raid = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
		$data = $db_raid->sql_fetchrow($result_raid, true);
		
		//$desc = strip_tags($data['description']);
		//$desc = UBB($desc);
		$desc = scrub_input($data['description']);
		$ddrivetiptxt = "'<span class=tooltip_title>" . $phprlang['description'] ."</span><br>" . DEUBB2($desc) . "'";
		$location = '<a href="view.php?mode=view&amp;raid_id='.$data['raid_id'].'"
					 onMouseover="ddrivetip('.$ddrivetiptxt.');" onMouseout="hideddrivetip();">'.$data['location'].'</a>';

		// convert unix timestamp to something readable
		$start = new_date('Y/m/d H:i:s',$data['start_time'],$phpraid_config['timezone'] + $phpraid_config['dst']);
		$invite = new_date('Y/m/d H:i:s',$data['invite_time'],$phpraid_config['timezone'] + $phpraid_config['dst']);
		$date = $start;

		//Get Raid Total Counts
		$count = get_char_count($data['raid_id'], $type='');
		$count2 = get_char_count($data['raid_id'], $type='queue');		

		foreach ($wrm_global_classes as $global_class)
			$total += $count[$global_class['class_id']];
		foreach ($wrm_global_classes as $global_class)
			$total2 += $count2[$global_class['class_id']];
			
		//foreach ($count as $class_count)
		//	$total += $class_count;
		//foreach ($count2 as $class_queue_count)
		//	$total2 += $class_queue_count;

		// Now that we have the raid data, we need to retrieve limit data based upon Raid ID.
		// Get Class Limits and set Colored Counts
		$raid_class_array = array();
		$class_color_count = array();
		$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "raid_class_lmt WHERE raid_id = %s", quote_smart($data['raid_id']));
		$result_raid_class = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
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
		$result_raid_role = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
		while($raid_role_data = $db_raid->sql_fetchrow($result_raid_role, true))
		{
			$sql2 = sprintf("SELECT role_name FROM " . $phpraid_config['db_prefix'] . "roles WHERE role_id = %s", quote_smart($raid_role_data['role_id']));
			$result_role_name = $db_raid->sql_query($sql2) or print_error($sql2, mysql_error(), 1);
			$role_name = $db_raid->sql_fetchrow($result_role_name, true);
			
			$raid_role_array[$role_name['role_name']] = $raid_role_data['lmt'];
			$role_color_count[$role_name['role_name']] = get_coloredcount($role_name['role_name'], $count[$raid_role_data['role_id']], $raid_role_array[$role_name['role_name']], $count2[$raid_role_data['role_id']]);
		}
		
		// current raids
		if($data['old'] == 0) {
			array_push($raid_list,
				array(
					'ID'=>$data['raid_id'],
					'Date'=>$date,
					'Dungeon'=>$location,
					'Invite Time'=>$invite,
					'Start Time'=>$start,
					'Creator'=>$data['officer'],
					'Totals'=>$total.'/'.$data['max']  . '(+' . $total2. ')',
					'Buttons'=>''
				)
			);
			foreach ($class_color_count as $left => $right)
				$raid_list[$raid_loop_cur][$left]= $right;
			foreach ($role_color_count as $left => $right)
				$raid_list[$raid_loop_cur][$left]= $right;
			$raid_loop_cur++;
		}
	}

	/**************************************************************
	 * Code to setup for a Dynamic Table Create: guild1 View.
	 **************************************************************/
	$viewName = 'raids1';
	
	//Setup Columns
	$raid_headers = array();
	$record_count_array = array();
	$raid_headers = getVisibleColumns($viewName);
	
	//Get Record Counts
	$raid_record_count_array = getRecordCounts($raid_list, $char_headers, $startRecord);
	
	//Get the Jump Menu and pass it down
	$raidJumpMenu = getPageNavigation($raid_list, $startRecord, $pageURL, $sortField, $sortDesc);
			
	//Setup Default Data Sort from Headers Table
	if (!$initSort)
		foreach ($raid_headers as $column_rec)
			if ($column_rec['default_sort'])
				$sortField = $column_rec['column_name'];
	
	//Setup Data
	$raid_list = paginateSortAndFormat($raid_list, $sortField, $sortDesc, $startRecord, $viewName);

	/****************************************************************
	 * Data Assign for Template.
	 ****************************************************************/
	$wrmsmarty->assign('raid_data', $raid_list); 
	$wrmsmarty->assign('raid_jump_menu', $raidJumpMenu);
	$wrmsmarty->assign('raid_column_name', $raid_headers);
	$wrmsmarty->assign('raid_record_counts', $raid_record_count_array);
	$wrmsmarty->assign('header_data',
		array(
			'template_name'=>$phpraid_config['template'],
			'character_header' => $phprlang['profile_header'],
			'raid_header' => $phprlang['profile_raid'],
			'sort_url_base' => $pageURL,
			'sort_descending' => $sortDesc,
			'sort_text' => $phprlang['sort_text'],
		)
	);
	
} elseif($_GET['mode'] == 'remove') {
	$id = scrub_input($_GET['id']);
	$n = scrub_input($_GET['n']);
	$profile_id = scrub_input($_SESSION['profile_id']);

	if(!isset($_POST['submit']))
	{
		$form_action = "profile.php?mode=remove&amp;n=$n&amp;id=$id";
		$confirm_button = '<input name="submit" type="submit" id="submit" value="'.$phprlang['confirm_deletion'].'" class="mainoption">';

		$wrmsmarty->assign('page',
			array(
				'form_action'=>$form_action,
				'confirm_button'=>$confirm_button,
				'delete_header'=>$phprlang['confirm_deletion'],
				'delete_msg'=>$phprlang['delete_msg'],
				)
			);
		//
		// Start output of delete page.
		//
		require_once('includes/page_header.php');
		$wrmsmarty->display('delete.html');
		require_once('includes/page_footer.php');
		exit;
	}
	else
	{
		log_delete('character',$n);

		$sql = sprintf("DELETE FROM " . $phpraid_config['db_prefix'] . "chars WHERE char_id=%s AND profile_id=%s",quote_smart($id), quote_smart($profile_id));
		$db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);

		$sql = sprintf("DELETE FROM " . $phpraid_config['db_prefix'] . "signups WHERE char_id=%s AND profile_id=%s",quote_smart($id), quote_smart($profile_id));
		$db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
		header("Location: profile.php?mode=view");
	}
} elseif(($_GET['mode'] == 'new' || $_GET['mode'] == 'edit')) {
	if($_GET['mode'] == 'new') {
		// check for errors
		$guild = scrub_input($_GET['guild']);
		$race = scrub_input($_GET['race']);
		$class = scrub_input($_GET['class']);
		$gender = scrub_input($_POST['gender']);
		$name = scrub_input(trim($_POST['name']));
		$dupeChar = isCharExist($name);
		$level = scrub_input($_POST['level']);
		$pri_spec = scrub_input($_POST['pri_spec']);
		$sec_spec = scrub_input($_POST['sec_spec']);	
		$arcane = scrub_input($_POST['arcane']);
		$fire = scrub_input($_POST['fire']);
		$frost = scrub_input($_POST['frost']);
		$nature = scrub_input($_POST['nature']);
		$shadow = scrub_input($_POST['shadow']);
	} else {
		// edit, grab from database
		$char_id = scrub_input($_GET['id']);

		$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "chars WHERE char_id=%s",quote_smart($char_id));
		$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
		$data = $db_raid->sql_fetchrow($result, true);
		
		$guild = $data['guild'];
		$race = $data['race'];
		$class = $data['class'];
		$gender = $data['gender'];
		$name = $data['name'];
		$dupeChar = 0;
		$level = $data['lvl'];
		$pri_spec = $data['pri_spec'];
		$sec_spec = $data['sec_spec'];		
		$arcane = $data['arcane'];
		$fire = $data['fire'];
		$frost = $data['frost'];
		$nature = $data['nature'];
		$shadow = $data['shadow'];
	}

	if(isset($_POST['submit'])) {
		$guild = scrub_input($_GET['guild']);
		$race = scrub_input($_GET['race']);
		$class = scrub_input($_GET['class']);
		$gender = scrub_input($_POST['gender']);
		$name = scrub_input(ucfirst(trim($_POST['name'])));
		$level = scrub_input($_POST['level']);
		$pri_spec = scrub_input($_POST['pri_spec']);
		$sec_spec = scrub_input($_POST['sec_spec']);
		$arcane = scrub_input($_POST['arcane']);
		$fire = scrub_input($_POST['fire']);
		$frost = scrub_input($_POST['frost']);
		$nature = scrub_input($_POST['nature']);
		$shadow = scrub_input($_POST['shadow']);
		// check for errors
		
		// check for errors + resistance optional
		if (($phpraid_config['resop'] == 1) AND ($fire == "") AND ($frost == "") AND ($nature == "") AND ($arcane == ""))
		{
			$errorSpace = 1;
			$errorTitle = $phprlang['form_error'];
			$errorMsg = '<ul>';
							
			if($guild == '')
				$errorMsg .= '<li>'.$phprlang['profile_error_guild'].'</li>';
			if($dupeChar)
				$errorMsg .= '<li>'.$phprlang['profile_error_dupe'].'</li>';
			if($class == '')
				$errorMsg .= '<li>'.$phprlang['profile_error_class'].'</li>';
			if($race == $phprlang['form_select'])
				$errorMsg .= '<li>'.$phprlang['profile_error_race'].'</li>';
			if($name == '')
				$errorMsg .= '<li>'.$phprlang['profile_error_name'].'</li>';
			if($level == '' || !is_numeric($level) || $level < 1 || $level > 80)
				$errorMsg .= '<li>'.$phprlang['profile_error_level'].'</li>';
			if($pri_spec == '' || $pri_spec == $phprlang['role_none'])
				$errorMsg .= '<li>'.$phprlang['profile_error_role'].'</li>';

			$errorDie = 0;
			$errorMsg .= '</ul>';

			if($errorMsg != '<ul></ul>')
			{
				$errorDie = 1;
			}
			else
			{
				//So resistance optional and values are empty, time to convert
				$shadow = "0";
				$fire = "0";
				$frost = "0";
				$nature = "0";
				$arcane = "0";

				// all is good add to database
				$profile = scrub_input($_SESSION['profile_id']);

				if($_GET['mode'] == 'new') {
					$sql = sprintf("INSERT INTO " . $phpraid_config['db_prefix'] . "chars (`profile_id`,`name`,`class`,
					`gender`,`guild`,`lvl`,`race`,`arcane`,`fire`,`frost`,`nature`,`shadow`,`pri_spec`,`sec_spec`) VALUES(%s,%s,%s,%s,%s,%s,%s,%s,%s,
					%s,%s,%s,%s,%s)",quote_smart($profile),quote_smart($name),quote_smart($class),quote_smart($gender),quote_smart($guild),
					quote_smart($level),quote_smart($race),quote_smart($arcane),quote_smart($fire),quote_smart($frost),quote_smart($nature),
					quote_smart($shadow),quote_smart($pri_spec),quote_smart($sec_spec));

					$db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);

					log_create('character',mysql_insert_id(),$name);
				} elseif($_GET['mode'] == 'edit') {
					$char_id=scrub_input($_GET['id']);
					$sql = sprintf("UPDATE " . $phpraid_config['db_prefix'] . "chars SET name=%s,lvl=%s,race=%s,
					class=%s,gender=%s,guild=%s,arcane=%s,nature=%s,shadow=%s,fire=%s,frost=%s,pri_spec=%s,sec_spec=%s WHERE char_id=%s",
					quote_smart($name),quote_smart($level),quote_smart($race),quote_smart($class),quote_smart($gender),
					quote_smart($guild),quote_smart($arcane),quote_smart($nature),quote_smart($shadow),quote_smart($fire),
					quote_smart($frost),quote_smart($pri_spec),quote_smart($sec_spec),quote_smart($char_id));

					$db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
				}
				header("Location: profile.php?mode=view");
			}
		}
		else
		{
			// We're not checking "sec_spec" below as we want that to be able to be blank if the player doesn't have one.
			if($dupeChar || $guild == '' || $class == '' || $race == $phprlang['form_select'] || $name == '' ||
				!is_numeric($arcane) || !is_numeric($fire) || !is_numeric($frost) ||
				!is_numeric($nature) || !is_numeric($shadow) || !is_numeric($level) ||
				$level < 1 || $level > 80 || $pri_spec == '' || $pri_spec == $phprlang['role_none'])
			{
				$errorSpace = 1;
				$errorTitle = $phprlang['form_error'];
				$errorMsg = '<ul>';

				if($guild == '')
					$errorMsg .= '<li>'.$phprlang['profile_error_guild'].'</li>';
				if($dupeChar)
					$errorMsg .= '<li>'.$phprlang['profile_error_dupe'].'</li>';
				if($class == '')
					$errorMsg .= '<li>'.$phprlang['profile_error_class'].'</li>';
				if($race == $phprlang['form_select'])
					$errorMsg .= '<li>'.$phprlang['profile_error_race'].'</li>';
				if($name == '')
					$errorMsg .= '<li>'.$phprlang['profile_error_name'].'</li>';
				if($level == '' || !is_numeric($level) || $level < 1 || $level > 80)
					$errorMsg .= '<li>'.$phprlang['profile_error_level'].'</li>';
				if(!is_numeric($arcane))
					$errorMsg .= '<li>'.$phprlang['profile_error_arcane'].'</li>';
				if(!is_numeric($fire))
					$errorMsg .= '<li>'.$phprlang['profile_error_fire'].'</li>';
				if(!is_numeric($frost))
					$errorMsg .= '<li>'.$phprlang['profile_error_frost'].'</li>';
				if(!is_numeric($nature))
					$errorMsg .= '<li>'.$phprlang['profile_error_nature'].'</li>';
				if(!is_numeric($shadow))
					$errorMsg .= '<li>'.$phprlang['profile_error_shadow'].'</li>';
				if($pri_spec == '' || $pri_spec == $phprlang['role_none'])
					$errorMsg .= '<li>'.$phprlang['profile_error_role'].'</li>';
				$errorDie = 0;

				$errorMsg .= '</ul>';

				if($errorMsg != '<ul></ul>')
					$errorDie = 1;
			} 
			else 
			{
				// all is good add to database
				$profile = scrub_input($_SESSION['profile_id']);

				if($_GET['mode'] == 'new')
				{
					$sql = sprintf("INSERT INTO " . $phpraid_config['db_prefix'] . "chars (`profile_id`,`name`,`class`,
					`gender`,`guild`,`lvl`,`race`,`arcane`,`fire`,`frost`,`nature`,`shadow`,`pri_spec`,`sec_spec`) VALUES(%s,%s,%s,%s,%s,%s,%s,%s,%s,
					%s,%s,%s,%s,%s)",quote_smart($profile),quote_smart($name),quote_smart($class),quote_smart($gender),quote_smart($guild),
					quote_smart($level),quote_smart($race),quote_smart($arcane),quote_smart($fire),quote_smart($frost),quote_smart($nature),
					quote_smart($shadow),quote_smart($pri_spec),quote_smart($sec_spec));

					$db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);

					log_create('character',mysql_insert_id(),$name);
				}
				elseif($_GET['mode'] == 'edit')
				{
					$char_id=scrub_input($_GET['id']);
					$sql = sprintf("UPDATE " . $phpraid_config['db_prefix'] . "chars SET name=%s,lvl=%s,race=%s,
					class=%s,gender=%s,guild=%s,arcane=%s,nature=%s,shadow=%s,fire=%s,frost=%s,pri_spec=%s,sec_spec=%s WHERE char_id=%s",
					quote_smart($name),quote_smart($level),quote_smart($race),quote_smart($class),quote_smart($gender),
					quote_smart($guild),quote_smart($arcane),quote_smart($nature),quote_smart($shadow),quote_smart($fire),
					quote_smart($frost),quote_smart($pri_spec),quote_smart($sec_spec),quote_smart($char_id));

					$db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
				}

				header("Location: profile.php?mode=view");
			}
		}
	}
}

// and the form
$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "guilds";
$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);

if($db_raid->sql_numrows($result) == 0) {
	$errorTitle = $phprlang['profile_create_header'];
	$errorMsg = $phprlang['profile_create_msg'];
	$errorDie = 0;
	$errorSpace = 1;
} else {
	if($_GET['mode'] != 'remove') {
		// form variables
		// nothing worse than submitting a form wrong and losing all your input
		if(isset($_GET['guild']))
			$guild = scrub_input($_GET['guild']);
		elseif(!isset($guild))
			$guild = '';

		if(isset($_GET['race']))
			$race = scrub_input($_GET['race']);
		else
			$race = '';

		if(isset($_GET['id']))
			$id = scrub_input($_GET['id']);
		else
			$id = '';

		if(isset($_GET['class']))
			$class = scrub_input($_GET['class']);
		elseif(!isset($class))
			$class = '';

		if(!isset($name))
			$name = '';

		if(!isset($level))
			$level = '';

		if(!isset($class_options))
			$class_options = '';

		if(!isset($arcane))
			$arcane = '';

		if(!isset($fire))
			$fire = '';

		if(!isset($frost))
			$frost = '';

		if(!isset($nature))
			$nature = '';

		if(!isset($shadow))
			$shadow = '';

		if(!isset($pri_spec))
			$pri_spec = '';

		if(!isset($sec_spec))
			$sec_spec = '';
			
		// template variables
		if($_GET['mode'] == 'view' || $_GET['mode'] == 'new')
			$form_action = 'profile.php?mode=new&amp;guild='.$guild.'&amp;race='.$race.'&amp;class='.$class;
		else
			$form_action = 'profile.php?mode=edit&amp;guild='.$guild.'&amp;id='.$id.'&amp;race='.$race.'&amp;class='.$class;

		if($_GET['mode'] == 'view' || $_GET['mode'] == 'new')
			$Form_use = "value=\"profile.php?mode=view&amp;guild=".$guild."&amp;race=";
		else
			$Form_use = "value=\"profile.php?mode=edit&amp;id=".$id."&amp;guild=".$guild."&amp;race=";

		if($_GET['mode'] == 'view' || $_GET['mode'] == 'new')
			$form_class = "value=\"profile.php?mode=view&amp;guild=".$guild."&amp;race=".$race."&amp;class=";
		else
			$form_class = "value=\"profile.php?mode=edit&amp;id=".$id."&amp;guild=".$guild."&amp;race=".$race."&amp;class=";

		if($_GET['mode'] == 'view' || $_GET['mode'] == 'new')
			$form_guild = "value=\"profile.php?mode=view&amp;guild=";
		else
			$form_guild = "value=\"profile.php?mode=edit&amp;id=".$id."&amp;guild=".$guild."&amp;race=";
			
		// Set Guild Option Box.
		$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "guilds";
		$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);			
		while($guild_data = $db_raid->sql_fetchrow($result, true))
		{
			$guild_options .= "<option ";
			if($guild == $guild_data['guild_id'])
				$guild_options .= "SELECTED ";
			$guild_options .= $form_guild.$guild_data['guild_id']."\">".$guild_data['guild_name']."</option>";
		}
						
		// Set Race Option Box.
		$sql = sprintf("SELECT guild_faction FROM " . $phpraid_config['db_prefix'] . "guilds WHERE guild_id = %s", quote_smart($guild));
		$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
		$faction_data = $db_raid->sql_fetchrow($result, true);
		$faction = $faction_data['guild_faction'];
		$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "races WHERE faction = %s", quote_smart($faction));
		$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);			
		while($race_data = $db_raid->sql_fetchrow($result, true))
		{
			$race_options .= "<option ";
			if($race == $race_data['race_id'])
				$race_options .= "SELECTED ";
			$race_options .= $Form_use.$race_data['race_id']."\">".$phprlang[$race_data['lang_index']]."</option>";
		}

		// Now that we have the race, let's show them what classes pertain to that race
		// Set Class Option Box.
		$sql = sprintf("SELECT a.race_id, a.class_id, b.lang_index
						FROM " . $phpraid_config['db_prefix'] . "class_race a, " 
								. $phpraid_config['db_prefix'] . "classes b 
						WHERE a.class_id = b.class_id
						AND race_id = %s", quote_smart($race));

		$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);			
		while($class_data = $db_raid->sql_fetchrow($result, true))
		{
			$class_options .= "<option ";
			if($class == $class_data['class_id'])
				$class_options .= "SELECTED ";
			$class_options .= $form_class.$class_data['class_id']."\">".$phprlang[$class_data['lang_index']]."</option>";
			
			//if($class == $class_data['class_id'])
			//	$class_options .= "<option value=\"".$class_data['class_id']."\" selected>".$phprlang[$class_data['lang_index']]."</option>";
			//else
			//	$class_options .= "<option value=\"".$class_data['class_id']."\">".$phprlang[$class_data['lang_index']]."</option>";
		}
		
		//Gender Selection
		$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "gender");
		$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);			
		while($gender_data = $db_raid->sql_fetchrow($result, true))
		{
			if($gender == $gender_data['gender_id'])
				$gender_options .= "<option value=\"".$gender_data['gender_id']."\" selected>".$phprlang[$gender_data['lang_index']]."</option>";
			else
				$gender_options .= "<option value=\"".$gender_data['gender_id']."\">".$phprlang[$gender_data['lang_index']]."</option>";
		}			
			
		//Spec Selection
		$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "class_role WHERE class_id = %s", quote_smart($class));
		//echo "SQL: " . $sql;
		$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);			
		while($spec_data = $db_raid->sql_fetchrow($result, true))
		{
			// Setup Primary Spec Selection Box
			if($pri_spec == $spec_data['subclass'])
				$pri_options .= "<option value=\"".$spec_data['subclass']."\" selected>".$phprlang[$spec_data['lang_index']]."</option>";
			else
				$pri_options .= "<option value=\"".$spec_data['subclass']."\">".$phprlang[$spec_data['lang_index']]."</option>";
			
			// Setup Secondary Spec Selection Box
			if($sec_spec == $spec_data['subclass'])
				$sec_options .= "<option value=\"".$spec_data['subclass']."\" selected>".$phprlang[$spec_data['lang_index']]."</option>";
			else
				$sec_options .= "<option value=\"".$spec_data['subclass']."\">".$phprlang[$spec_data['lang_index']]."</option>";				
		}			
		// Set up "Not Available" option for Seconary Spec.
		if($sec_spec == "")
			$sec_options .= "<option value=\"\" selected>".$phprlang['notavailable']."</option>";
		else
			$sec_options .= "<option value=\"\">".$phprlang['notavailable']."</option>";				
		
		// setup output variables for form
		$guild_output = '<select name="guild" onChange="MM_jumpMenu(\'self\',this,0)" class="form" style="width:100px">
						<option value="profile.php?mode=new">'.$phprlang['form_select'].'</option>' . $guild_options . '</select>';
			
		$race_output = '<select name="race" onChange="MM_jumpMenu(\'self\',this,0)" class="form" style="width:100px">
						<option value="profile.php?mode=new">'.$phprlang['form_select'].'</option>' . $race_options . '</select>';

		$class_output = '<select name="class" onChange="MM_jumpMenu(\'self\',this,0)" class="form" style="width:100px">
						<option value="profile.php?mode=new">'.$phprlang['form_select'].'</option>' . $class_options . '</select>';
		
		if(!isset($_GET['guild'])) {
			$race_output = '<select name="race" DISABLED><option></option></select>';
			$class_output = '<select name="class" DISABLED><option></option></select>';
			$name = '<select name="name" DISABLED><option></option></select>';
			$level = '<select name="level" DISABLED><option></option></select>';
			$gender = '<select name="gender" DISABLED><option></option></select>';
			$guild = '<select name="guild" DISABLED><option></option></select>';
			$pri_spec = '<select name="pri_spec" DISABLED><option></option></select>';
			$sec_spec = '<select name="sec_spec" DISABLED><option></option></select>';
			$arcane = '<select name="arcane" DISABLED><option></option></select>';
			$fire = '<select name="fire" DISABLED><option></option></select>';
			$frost = '<select name="frost" DISABLED><option></option></select>';
			$nature = '<select name="nature" DISABLED><option></option></select>';
			$shadow = '<select name="shadow" DISABLED><option></option></select>';
		}
		elseif (!isset($_GET['race'])) {
			$class_output = '<select name="class" DISABLED><option></option></select>';
			$name = '<select name="name" DISABLED><option></option></select>';
			$level = '<select name="level" DISABLED><option></option></select>';
			$gender = '<select name="gender" DISABLED><option></option></select>';
			$guild = '<select name="guild" DISABLED><option></option></select>';
			$pri_spec = '<select name="pri_spec" DISABLED><option></option></select>';
			$sec_spec = '<select name="sec_spec" DISABLED><option></option></select>';
			$arcane = '<select name="arcane" DISABLED><option></option></select>';
			$fire = '<select name="fire" DISABLED><option></option></select>';
			$frost = '<select name="frost" DISABLED><option></option></select>';
			$nature = '<select name="nature" DISABLED><option></option></select>';
			$shadow = '<select name="shadow" DISABLED><option></option></select>';
		} else {
			$name = '<input type="text" name="name" class="post" value="' . $name . '" style="width:100px">';
			$level = '<input name="level" type="text" class="post" size="2" value="' . $level . '" maxlength="2">';
			$gender = '<select name="gender" class="form" id="gender" style="width:100px">' .$gender_options. '</select>';
			$pri_spec = '<select name="pri_spec" class="form" id="role" style="width:140px">' .$pri_options. '</select>';
			$sec_spec = '<select name="sec_spec" class="form" id="role" style="width:140px">' .$sec_options. '</select>';			
			$arcane = '<input name="arcane" type="text" class="post" size="3" value="' . $arcane . '" maxlength="3">';
			$fire =  '<input name="fire" type="text" class="post" size="3" value="' . $fire . '" maxlength="3">';
			$frost =  '<input name="frost" type="text" class="post" size="3" value="' . $frost . '" maxlength="3">';
			$nature =  '<input name="nature" type="text" class="post" size="3" value="' . $nature . '" maxlength="3">';
			$shadow =  '<input name="shadow" type="text" class="post" size="3" value="' . $shadow . '" maxlength="3">';
		}

		if($_GET['mode'] == 'view' || $_GET['mode'] == 'new') {
			$buttons = '<input type="submit" name="submit" value="'.$phprlang['addchar'].'" class="mainoption"> <input type="reset" name="Reset" value="'.$phprlang['reset'].'" class="liteoption">';
		} else {
			$buttons = '<input type="submit" name="submit" value="'.$phprlang['updatechar'].'" class="mainoption"> <input type="reset" name="Reset" value="'.$phprlang['reset'].'" class="liteoption">';
		}

		$wrmsmarty->assign('guilds_new',
			array(
				'name' => $name,
				'form_action' => $form_action,
				'buttons' => $buttons,
				'race'=>$race_output,
				'class'=>$class_output,
				'gender'=>$gender,
				'name'=>$name,
				'arcane_text'=>$phprlang['profile_arcane'],
				'fire_text'=>$phprlang['profile_fire'],
				'frost_text'=>$phprlang['profile_frost'],
				'nature_text'=>$phprlang['profile_nature'],
				'shadow_text'=>$phprlang['profile_shadow'],
				'arcane'=>$arcane,
				'fire'=>$fire,
				'frost'=>$frost,
				'nature'=>$nature,
				'shadow'=>$shadow,
				'guild_text' => $phprlang['profile_guild'],
				'guild' => $guild_output,
				'role_text' => $phprlang['profile_role'],
				'pri_spec' => $pri_spec,
				'sec_spec' => $sec_spec,
				'level'=>$level,
				'new_header'=>$phprlang['profile_new'],
				'race_text'=>$phprlang['profile_race'],
				'class_text'=>$phprlang['profile_class'],
				'gender_text'=>$phprlang['profile_gender'],
				'name_text'=>$phprlang['profile_name'],
				'level_text'=>$phprlang['profile_level']
			)
		);
	}
}

//
// Start output of page
//
if($_GET['mode'] != 'delete')
{
	require_once('includes/page_header.php');
	$wrmsmarty->display('profile.html');
	require_once('includes/page_footer.php');
}
?>