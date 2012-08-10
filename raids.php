<?php
/***************************************************************************
 *                               raids.php
 *                            ---------------
 *   begin                : Saturday, Jan 16, 2005
 *   copyright            : (C) 2007 - 2008 Douglas Wagner
 *   email                : douglasw@wagnerweb.org
 *
 *   $Id: raids.php,v 2.00 2008/03/10 13:26:43 psotfx Exp $
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
if ($phpraid_config['enable_five_man'])
{
	define("PAGE_LVL","profile");
}
else
{
	define("PAGE_LVL","raids");
}
require_once("includes/authentication.php");
require_once("includes/functions_raids.php");

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

$page_filename = 'raids.php';
$pageURL = $page_filename.'?mode=view&';
/**************************************************************
 * End Record Output Setup for Data Table
 **************************************************************/
		
$priv_raids = scrub_input($_SESSION['priv_raids']);
$username = scrub_input($_SESSION['username']);

/*
 * 
*/
/*if (isset($_GET['raids_del']))
{
	

}*/
if (isset($_GET['mark_raid_as_old']))
{
	$array_mark = $_GET['raids'];
	for ($i=0; $i < count($array_mark);$i++)
	{
		raid_mark($array_mark[$i]);
	}
}
/************************************************************************************************
 *   Mode: VIEW 
 ************************************************************************************************/
if(($_GET['mode'] == 'view') or isset($_GET['raids_del']) or isset($_GET['mark_raid_as_old']))
{
	// two arrays to pass to our report class, current and previous raids
	$current = array();
	$previous = array();
	$recurring = array();
	$count = array();
	$count2 = array();
	$raid_loop_cur = 0;
	$raid_loop_prev = 0;
	$raid_loop_rec = 0;

	// Create the "new raid" button. -- This needs to be created regardless of whether or not we have raids.
	//$new_raid_link = '<a href="raids.php?mode=new"><img src="templates/' . $phpraid_config['template'] . '/images/icons/icon_new_raid.gif" border="0"  onMouseover="ddrivetip(\''.$phprlang['raids_new_header'].'\');" onMouseout="hideddrivetip();" alt="new raid icon"></a>';
	$form_action = "raids.php?mode=new";
	
	//$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "raids";
	// Select all raids that are marked current and only the top X raids marked old.
	$sql = sprintf("(SELECT * from " . $phpraid_config['db_prefix'] . "raids " .
		"WHERE `old` = 0) " .
		"UNION ALL " .
		"(SELECT * FROM " . $phpraid_config['db_prefix'] . "raids " . 
		"WHERE `old` = 1 " .
		"ORDER BY `raid_id` DESC " .
		"LIMIT " . $phpraid_config['num_old_raids_index'] . ")");
	$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);	
	while($data = $db_raid->sql_fetchrow($result, true)) 
	{
		if ($data['recurrance']==0)
		{
			if ($priv_raids || $username == $data['officer'])
			{
				// $bd_edit = '<a href="raids.php?mode=edit&amp;id='.$data['raid_id'].'"><img src="templates/' . $phpraid_config['template'] .
						// '/images/icons/icon_edit.gif" border="0" onMouseover="ddrivetip(\''.$phprlang['edit'].'\');" onMouseout="hideddrivetip();" alt="edit icon"></a>';

				$url = 'raids.php?mode=edit&amp;id='.$data['raid_id'];
				$img = '<img src="templates/'. $phpraid_config['template'].'/images/icons/icon_edit.gif" border="0" alt="edit icon" />';
				$bd_edit = cssToolTip($img, $phprlang['edit'], 'smallIconText', $url);
	
				// $bd_delete = '<a href="raids.php?mode=delete&amp;n='.$data['location'].'&amp;id='.$data['raid_id'].'"><img src="templates/' .
							// $phpraid_config['template'] . '/images/icons/icon_delete.gif" border="0" onMouseover="ddrivetip(\''.$phprlang['delete'].'\');"
							// onMouseout="hideddrivetip();" alt="delete icon"></a>
							
							// <a href="lua_output_new.php?mode=lua&raid_id=' . $data['raid_id'] . '">
							// <img src="templates/' . $phpraid_config['template'] . '/images/icons/icon_minipost.gif" border="0"
							// onMouseover="ddrivetip(\''.$phprlang['lua'].'\');" onMouseout="hideddrivetip();" alt="minipost icon"></a>
	
							// <a href="raids.php?mode=mark&amp;id='.$data['raid_id'].'"><img src="templates/' . $phpraid_config['template'] .
							// '/images/icons/icon_latest_reply.gif" border="0" onMouseover="ddrivetip(\''.$phprlang['mark'].'\');"
							// onMouseout="hideddrivetip();" alt="latest reply icon"></a>';
				$urlDelete = 'raids.php?mode=delete&amp;n='.urlencode($data['location']).'&amp;id='.$data['raid_id'];
				$imgDelete = '<img src="templates/'.$phpraid_config['template'].'/images/icons/icon_delete.gif" border="0" alt="delete icon" />';
					$urlLua = 'lua_output_new.php?mode=lua&raid_id=' . $data['raid_id'];
					$imgLua = '<img src="templates/'. $phpraid_config['template'].'/images/icons/icon_minipost.gif" border="0" alt="minipost icon" />';
						$urlRaid = 'raids.php?mode=mark&amp;id='.$data['raid_id'];
						$imgRaid = '<img src="templates/'. $phpraid_config['template'].'/images/icons/icon_latest_reply.gif" border="0" alt="latest reply icon" />';
				$bd_delete = cssToolTip($imgDelete, $phprlang['delete'], 'smallIconText', $urlDelete).
							cssToolTip($imgLua, $phprlang['lua'], 'mediumIconText', $urlLua).
							cssToolTip($imgRaid, $phprlang['mark'], 'mediumIconText', $urlRaid);				
	
				//$old_delete = '<a href="raids.php?mode=delete&amp;id='.$data['raid_id'].'"><img src="templates/' . $phpraid_config['template'] . '/images/icons/icon_delete.gif" border="0" onMouseover="ddrivetip(\''.$phprlang['delete'].'\');" onMouseout="hideddrivetip();" alt="delete icon"></a>';
				//$imgDelete = '<img src="templates/'.$phpraid_config['template'].'/images/icons/icon_delete.gif" border="0" alt="delete icon" />';
				$urlDelete = 'raids.php?mode=delete&amp;id='.$data['raid_id'];
				$old_delete = cssToolTip($imgDelete, $phprlang['delete'], 'smallIconText', $urlDelete);
				//$mark_new = '<a href="raids.php?mode=mark&amp;id='.$data['raid_id'].'"><img src="templates/' . $phpraid_config['template'] . '/images/icons/icon_latest_reply.gif" border="0" onMouseover="ddrivetip(\''.$phprlang['new'].'\');" onMouseout="hideddrivetip();" alt="latest reply icon"></a>';
				$imgNew = '<img src="templates/'.$phpraid_config['template'].'/images/icons/icon_latest_reply.gif" border="0" alt="latest reply icon" />';
				$urlNew = 'raids.php?mode=mark&amp;id='.$data['raid_id'];
				$mark_new = cssToolTip($imgNew, $phprlang['new'], 'mediumIconText', $urlNew);
				
				$check_box = '<input type="checkbox" name="raids[]" value="'.$data['raid_id'].'" >';				
			}
		}
		else
		{
			if ($priv_raids || $username == $data['officer'])
			{
				//$bd_delete = '<a href="raids.php?mode=delete&amp;n='.$data['location'].'&amp;id='.$data['raid_id'].'"><img src="templates/' .
							//$phpraid_config['template'] . '/images/icons/icon_delete.gif" border="0" onMouseover="ddrivetip(\''.$phprlang['delete'].'\');"
							//onMouseout="hideddrivetip();" alt="delete icon"></a>';
				$imgDelete = '<img src="templates/'.$phpraid_config['template'].'/images/icons/icon_delete.gif" border="0" alt="delete icon" />';
				$urlDelete = 'raids.php?mode=delete&amp;n='.urlencode($data['location']).'&amp;id='.$data['raid_id'];
				$bd_delete = cssToolTip($imgDelete, $phprlang['delete'], 'smallIconText', $urlDelete).
				$check_box = '<input type="checkbox" name="raids[]" value="'.$data['raid_id'].'" class="post">';
			}
		}
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

//		$desc = scrub_input($data['description']);
//		$desc = str_replace("'", "\'", $desc);
//		$ddrivetiptxt = "'<span class=tooltip_title>" . $phprlang['description'] ."</span><br>" . DEUBB2($desc) . "'";
//		$location = '<a href="view.php?mode=view&amp;raid_id='.$data['raid_id'].'" onMouseover="ddrivetip('.$ddrivetiptxt.');" onMouseout="hideddrivetip();">'.$data['location'].'</a>';
		
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
					
		$raid_date = new_date($phpraid_config['date_format'],$data['start_time'],$phpraid_config['timezone'] + $phpraid_config['dst']);
		$raid_start_time = new_date($phpraid_config['time_format'],$data['start_time'],$phpraid_config['timezone'] + $phpraid_config['dst']);
		$raid_invite_time = new_date($phpraid_config['time_format'],$data['invite_time'],$phpraid_config['timezone'] + $phpraid_config['dst']);
			
		//$desc = scrub_input($data['description']);
		//$desc = str_replace("'", "\'", $desc);
		//$raid_txt_desc = "'<span class=tooltip_title>" . $phprlang['description'] ."</span><br>" . DEUBB2($desc);
		$raid_txt_info = "------------------";
		$raid_txt_info .= "<br>".$phprlang['location'].":".$data['location'];
		$raid_txt_info .= "<br>".$phprlang['officer'].":".$data['officer'];
		$raid_txt_info .= "<br>".$phprlang['date'].":".$raid_date;
		$raid_txt_info .= "<br>".$phprlang['start_time'].":".$raid_start_time;
		$raid_txt_info .= "<br>".$phprlang['invite_time'].":".$raid_invite_time;
		$raid_txt_info .= "<br>".$phprlang['totals'].": ".$total.'/'.$data['max']  . ' (+' . $total2. ')';
//		$raid_txt_info .=
		//$ddrivetiptxt = $raid_txt_desc.'<br>'. $raid_txt_info."'";	
		//$popupdesc = $data['description'];
		//$location = '<a href="view.php?mode=view&amp;raid_id='.$data['raid_id'].'" onMouseover="ddrivetip('.$ddrivetiptxt.');" onMouseout="hideddrivetip();">'.$data['location'].'</a>';	
		$url = 'view.php?mode=view&amp;raid_id=' . $data['raid_id'];
		//$location=create_comment_popup($phprlang['description'], $popupdesc, $url, $data['location']);
		$location=cssToolTip($data['location'], $data['description'],'custom comment', $url, $phprlang['description']);
		
		// current raids
		if($data['old'] == 0 && $data['recurrance']==0) {
			array_push($current,
				array(
					'ID'=>$data['raid_id'],
					'Date'=>$date,
					'Force Name'=>$data['raid_force_name'],
					'Dungeon'=>$location,
					'Invite Time'=>$invite,
					'Start Time'=>$start,
					'Creator'=>$data['officer'],
					'Totals'=>$total.'/'.$data['max']  . '(+' . $total2. ')',
					'Buttons'=>$bd_edit . $bd_delete.$check_box,
				)
			);
			foreach ($class_color_count as $left => $right)
				$current[$raid_loop_cur][$left]= $right;
			foreach ($role_color_count as $left => $right)
				$current[$raid_loop_cur][$left]= $right;
			$raid_loop_cur++;
		}
		elseif($data['old'] == 1)
		{
			array_push($previous,
				array(
					'ID'=>$data['raid_id'],
					'Date'=>$date,
					'Force Name'=>$data['raid_force_name'],
					'Dungeon'=>UBB2($location),
					'Invite Time'=>$invite,
					'Start Time'=>$start,
					'Creator'=>$data['officer'],
					'Totals'=>$total.'/'.$data['max']  . '(+' . $total2. ')',
					'Buttons'=> $mark_new . $old_delete
				)
			);	
			foreach ($class_color_count as $left => $right)
				$previous[$raid_loop_prev][$left]= $right;
			foreach ($role_color_count as $left => $right)
				$previous[$raid_loop_prev][$left]= $right;
			$raid_loop_prev++;
		}
		else
		{
			array_push($recurring,
				array(
					'ID'=>$data['raid_id'],
					'Date'=>$date,
					'Force Name'=>$force_name,
					'Dungeon'=>UBB2($location),
					'Invite Time'=>$invite,
					'Start Time'=>$start,
					'Creator'=>$data['officer'],
					'Totals'=>$total.'/'.$data['max']  . '(+' . $total2. ')',
					'Buttons'=> $bd_delete,
				)
			);	
			foreach ($class_color_count as $left => $right)
				$recurring[$raid_loop_rec][$left]= $right;
			foreach ($role_color_count as $left => $right)
				$recurring[$raid_loop_rec][$left]= $right;
			$raid_loop_rec++;
		}
		$bd_edit = "";
		$bd_delete= "";
		$old_delete="";
		$mark_new="";
	}
	

	if ($priv_raids and ($db_raid->sql_numrows($result) != FALSE))
	{
		$button_mark_raid_as_old = $phprlang['raids_mark_selected_raids_to_old'];
	//	$button_raids_del = $phprlang['delete'];
	}
	/**************************************************************
	 * Code to setup for a Dynamic Table Create: raids1 View.
	 **************************************************************/
	$viewName = 'raids1';
	
	//Setup Columns
	$raid_headers = array();
	$record_count_array = array();
	$raid_headers = getVisibleColumns($viewName);

	//Get Record Counts
	$curr_record_count_array = getRecordCounts($current, $raid_headers, $startRecord);
	$prev_record_count_array = getRecordCounts($previous, $raid_headers, $startRecord);
	$recur_record_count_array = getRecordCounts($recurring, $raid_headers, $startRecord);
	
	//Get the Jump Menu and pass it down
	$currJumpMenu = getPageNavigation($current, $startRecord, $pageURL, $sortField, $sortDesc);
	$prevJumpMenu = getPageNavigation($previous, $startRecord, $pageURL, $sortField, $sortDesc);
	$recJumpMenu = getPageNavigation($recurring, $startRecord, $pageURL, $sortField, $sortDesc);
	
	//Setup Default Data Sort from Headers Table
	if (!$initSort)
		foreach ($raid_headers as $column_rec)
			if ($column_rec['default_sort'])
				$sortField = $column_rec['column_name'];

	//Setup Data
	$current = paginateSortAndFormat($current, $sortField, $sortDesc, $startRecord, $viewName);
	$previous = paginateSortAndFormat($previous, $sortField, $sortDesc, $startRecord, $viewName);
	$recurring = paginateSortAndFormat($recurring, $sortField, $sortDesc, $startRecord, $viewName);
	
	/****************************************************************
	 * Data Assign for Template.
	 ****************************************************************/
	$wrmsmarty->assign('new_data', $current); 
	$wrmsmarty->assign('old_data', $previous);
	$wrmsmarty->assign('rec_data', $recurring);
	$wrmsmarty->assign('current_jump_menu', $currJumpMenu);
	$wrmsmarty->assign('previous_jump_menu', $prevJumpMenu);
	$wrmsmarty->assign('recurring_jump_menu', $recJumpMenu);
	$wrmsmarty->assign('column_name', $raid_headers);
	$wrmsmarty->assign('curr_record_counts', $curr_record_count_array);
	$wrmsmarty->assign('prev_record_counts', $prev_record_count_array);
	$wrmsmarty->assign('recur_record_counts', $recur_record_count_array);
	$wrmsmarty->assign('header_data',
		array(
			'template_name'=>$phpraid_config['template'],
			'gamepack_name' => $phpraid_config['gamepack_name'],
			'form_action'=> $form_action,
			'form_action_raids_table' => $pageURL."&",
			'button_addraid' => $phprlang['raids_new_header'],

			'button_mark_raid_as_old' => $button_mark_raid_as_old,
			'button_raids_del' => $button_raids_del,
		
			'new_raid_link' => $new_raid_link,
			'old_raids_header' => $phprlang['raids_old'],
			'new_raids_header' => $phprlang['raids_new'],
			'recur_raids_header' => $phprlang['raids_recur'],
			'sort_url_base' => $pageURL,
			'sort_descending' => $sortDesc,
			'sort_text' => $phprlang['sort_text'],
			'show_recurrance' => $phpraid_config['recurrance_enabled']
		)
	);

	//
	// Start output of raids page.
	//
	require_once('includes/page_header.php');
	$wrmsmarty->display('raids.html');
	require_once('includes/page_footer.php');
}

/************************************************************************************************
 *   Mode: NEW
 ************************************************************************************************/
elseif($_GET['mode'] == 'new')
{
	// error checking, goes before the output so we can show the error at the top and allow them to fix the errors without pressing back
	if(isset($_POST['submit']))
	{
		$location = scrub_input($_POST['location']);
		$date = str_replace(" ", "", scrub_input($_POST['date']));
		$raid_force_name = scrub_input($_POST['raid_force_name']);
		$event_type = scrub_input($_POST['event_type']);
		if ($event_type == '')
			$event_type = "1";
		$event_id = scrub_input($_POST['event_id']);
		if ($event_id == '')
			$event_id = "0";
		$description = scrub_input($_POST['description']);
		$max_user = scrub_input($_POST['max']);
		$min_lvl = scrub_input($_POST['min_lvl']);
		$max_lvl = scrub_input($_POST['max_lvl']);
		$recurring = scrub_input($_POST['recurring']);
		$recur_interval = scrub_input($_POST['recur_interval']);
		$recur_length = scrub_input($_POST['recur_length']);
		
		// Handle Classes
		$bad_class_limit = FALSE;
		foreach ($wrm_global_classes as $global_class)
		{
			$classtrans = str_replace(" ", "_", $global_class['class_id']);
			if ($_POST[$classtrans]!='' && is_numeric($_POST[$classtrans]))
				$class[$global_class['class_id']] = scrub_input($_POST[$classtrans]);
			else
				$bad_class_limit = TRUE;
		}
		
		// Handle Roles
		$bad_role_limit = FALSE;
		foreach ($wrm_global_roles as $global_role)	
		{
			$role[$global_role['role_id']] = scrub_input($_POST[$global_role['role_id']]);
			if ($role[$global_role['role_id']] == '')
				$role[$global_role['role_id']] == '0'; 

			if($global_role['role_name'] != '')
				if (!is_numeric($role[$global_role['role_id']]))
					$bad_role_limit = TRUE;	
		}
		
		// Verify Data to ensure Correctness, set error if not.
		if($location == "" || $date == "" || $max_user == "" || $min_lvl == "" || $max_lvl == "" ||
		   !is_numeric($max_user) || !is_numeric($min_lvl) || !is_numeric($max_lvl) || $bad_class_limit ||
		   $bad_role_limit)
		{
			$errorTitle = $phprlang['form_error'];
			$errorSpace = 1;
			$errorMsg = '<ul>';
			if($location == "")
				$errorMsg .= '<li>' . $phprlang['raid_error_location'] . '</li>';

			if($date == "")
				$errorMsg .= '<li>' . $phprlang['raid_error_date'] . '</li>';

			if($max_user== "" || $min_lvl == "" || $max_lvl == "" ||
			!is_numeric($max_user) || !is_numeric($min_lvl) || !is_numeric($max_lvl) || $bad_class_limit ||
			$bad_role_limit)
				$errorMsg .= '<li>' . $phprlang['raid_error_limits'] . '</li>';
		}
		if($description == "")				
		{									
        	$description="-";			
        	$_POST['description']="-";	
		}

	}

	// Either We Haven't submitted the form or we have and we errored.  If we have 
	//   submitted the form and errored, set variables, otherwise just build form.
	if(!isset($_POST['submit']) || isset($errorTitle))
	{
		// setup the form action first
		$mode = 'new';
		$form_action = 'raids.php?mode='.$mode;

		/****************************************************************************************
		 *  Set Data for Form Below.
		 ****************************************************************************************/
		// If the "Locations" dropdown was changed.
		if(isset($_GET['id'])) //From "Stored Location" - This is the Location ID. Mode, Location ID, and Location Name are set.
		{
			$location = scrub_input($_GET['id']);
			if ($priv_raids == 1)
			{
				$sql = sprintf(	"SELECT * FROM " . $phpraid_config['db_prefix'] . "locations ".
								"	WHERE location_id = %s", quote_smart($location));
			}
			else
			{
				$sql = sprintf(	"SELECT * FROM " . $phpraid_config['db_prefix'] . "locations ".
								"	WHERE location_id=%s and locked='0'", quote_smart($location));
			}
			
			$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
			$data = $db_raid->sql_fetchrow($result, true);
			$event_type = $data['event_type'];
			$event_id = $data['event_id'];
			$max_user= $data['max'];
	
			// Now that we have the location data, we need to retrieve limit data based upon location ID.
			// Get Class Limits
			//$raid_class_array = array();
			$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "loc_class_lmt WHERE location_id = %s", quote_smart($location));
			$result_loc_class = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
			while($loc_class_data = $db_raid->sql_fetchrow($result_loc_class, true))
			{
				$class[$loc_class_data['class_id']] = $loc_class_data['lmt'];
			}
			// Get Role Limits
			//$raid_role_array = array();
			$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "loc_role_lmt WHERE location_id = %s", quote_smart($location));
			$result_loc_role = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
			while($loc_role_data = $db_raid->sql_fetchrow($result_loc_role, true))
			{
				$sql2 = sprintf("SELECT role_name FROM " . $phpraid_config['db_prefix'] . "roles WHERE role_id = %s", quote_smart($loc_role_data['role_id']));
				$result_role_name = $db_raid->sql_query($sql2) or print_error($sql2, $db_raid->sql_error(), 1);
				$role_name = $db_raid->sql_fetchrow($result_role_name, true);
				
				$role[$role_name['role_name']] = $loc_role_data['lmt'];
			}
			$min_lvl_value = $data['min_lvl'];
			$max_lvl_value = $data['max_lvl'];
			$location_value = $data['location'];
		}
		
		// If the form is in error.
		if(isset($errorTitle)) // We are in error on the form, get old values and set boxes for values.
		{
			$event_type = scrub_input($_POST['event_type']);
			$event_id = scrub_input($_POST['event_id']);
			$max_user= scrub_input($_POST['max']);

			// Handle Classes
			foreach ($wrm_global_classes as $global_class)
			{
				$classtrans = str_replace(" ", "_", $global_class['class_id']);
				$class[$global_class['class_id']] = scrub_input($_POST[$classtrans]);
			}
			
			// Handle Roles
			foreach ($wrm_global_roles as $global_role)	
			{
				$role[$global_role['role_id']] = scrub_input($_POST[$global_role['role_id']]);
				if ($role[$global_role['role_id']] == '')
					$role[$global_role['role_id']] == '0'; 
			}			
			$min_lvl_value = scrub_input($_POST['min_lvl']);
			$max_lvl_value = scrub_input($_POST['max_lvl']);
			$location_value = scrub_input($_POST['location']);
			$date_value = scrub_input($_POST['date']);
			$raid_force_name = scrub_input($_POST['raid_force_name']);
			$i_time_hour_value = scrub_input($_POST['i_time_hour']);
			$i_time_minute_value = scrub_input($_POST['i_time_minute']);
			$i_time_ampm_value = scrub_input($_POST['i_time_ampm']);
			$s_time_hour_value = scrub_input($_POST['s_time_hour']);
			$s_time_minute_value = scrub_input($_POST['s_time_minute']);
			$s_time_ampm_value = scrub_input($_POST['s_time_ampm']);
			$freeze_value = scrub_input($_POST['freeze']);
			$description_value = scrub_input($_POST['description']);
		}

		/************************************************************************************************
		 *   Build the form, use data from above if it exists.
		 ************************************************************************************************/
		// now for the actual form elements
		if(isset($date_value))
			$date = '<input type="text" name="date" size="20" class="post" READONLY value="' . $date_value . '"><a href="javascript:showCal(\'Calendar1\')"><span class="gen"> [+]</span></a>';
		else
			$date = '<input type="text" name="date" size="20" class="post" READONLY><a href="javascript:showCal(\'Calendar1\')"><span class="gen"> [+]</span></a>';

		// This code sets up the selection box for raid force from the raid_force table.
		$raid_force_box = '<select name="raid_force_name" class="post">';
		$raid_force_box .= "<option SELECTED value=\"All\">" . $phprlang['all'] ."</option>";
		$sql = "SELECT DISTINCT raid_force_name FROM " . $phpraid_config['db_prefix'] . "raid_force";
		$raid_force_result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
		while($raid_force_data = $db_raid->sql_fetchrow($raid_force_result, true))
		{
			$raid_force_box .= "<option ";
			if ($data['raid_force_name'] == $raid_force_data['raid_force_name'])
				$raid_force_box .= "SELECTED ";
			$raid_force_box .= "value=\"" . $raid_force_data['raid_force_name'] . "\">" . $raid_force_data['raid_force_name'] ."</option>";	
		}
		$raid_force_box .= '</select>';

		//Re-Occurance Items
		if ($_SESSION['priv_raids'])
		{
			$recurring='<input name="recurring" type="checkbox" value="1" class="post">';
			
			$recur_interval = '<select name="recur_interval" class="post">';
			$recur_interval .= '<option value="daily">' . $phprlang['daily'] . '</option>';
			$recur_interval .= '<option value="weekly">' . $phprlang['weekly'] . '</option>';
			$recur_interval .= '<option value="monthly">' . $phprlang['monthly'] . '</option>';
			$recur_interval .= '</select>';
			
			$recur_length = '<input type="text" name="recur_length" size="5" class="post">';
		}
			
		// invite time
		$i_time_hour = '<select name="i_time_hour" class="post">';
		for($i = 1; $i <= $phpraid_config['ampm']; $i++)
		{
			if($i < 10)
				$i_string = '0' . $i;
			else
				$i_string = $i;

			if(isset($i_time_hour_value) && $i_string == $i_time_hour_value)
				$i_time_hour .= '<option value="' . $i_string . '" selected>' . $i_string . '</option>';
			else
				$i_time_hour .= '<option value="' . $i_string . '">' . $i_string . '</option>';
		}
		$i_time_hour .= '</select>';

		//~@@Change: Douglas Wagner - 6/23/2007
		// This code reduces the selections in the "minute" selection boxes.  We want a 15 minute granularity, not a 1 minute granularity.
		$i_time_minute = '<select name="i_time_minute" class="post">';
		for($i = 0; $i < 60; $i++)
		{
			$ifloor=$i/15;					//Added
			if(($ifloor) == floor($ifloor)) //Added
			{								//Added
				if($i < 10)
					$i_string = '0' . $i;
				else
					$i_string = $i;

				if(isset($i_time_minute_value) && $i_string == $i_time_minute_value)
					$i_time_minute .= '<option value="' . $i_string . '" selected>' . $i_string . '</option>';
				else
					$i_time_minute .= '<option value="' . $i_string . '">' . $i_string . '</option>';
			} 								//Added
		}
		$i_time_minute .= '</select>';

		if ($phpraid_config['ampm'] == '12')
		{
			$i_time_ampm = '<select name="i_time_ampm" class="post">';
			if(isset($i_time_ampm_value) && $i_time_ampm_value == 'am')
			{
				$i_time_ampm .= '<option value="am" selected>am</option><option value="pm">pm</option>';
			}
			elseif(isset($i_time_ampm_value) && $i_time_ampm_value == 'pm')
			{
				$i_time_ampm .= '<option value="am">am</option><option value="pm" selected>pm</option>';
			}
			else
			{
				$i_time_ampm .= '<option value="am">am</option><option value="pm" selected>pm</option>';
			}
			$i_time_ampm .= '</select>';
			// end of invite time
		}
		
		// start time
		$s_time_hour = '<select name="s_time_hour" class="post">';
		for($i = 1; $i <= $phpraid_config['ampm']; $i++)
		{
			if($i < 10)
				$s_string = '0' . $i;
			else
				$s_string = $i;

			if(isset($s_time_hour_value) && $s_string == $s_time_hour_value)
				$s_time_hour .= '<option value="' . $s_string . '" selected>' . $s_string . '</option>';
			else
				$s_time_hour .= '<option value="' . $s_string . '">' . $s_string . '</option>';
		}
		$s_time_hour .= '</select>';

		//~@@Change: Douglas Wagner - 6/23/2007
		// This code reduces the selections in the "minute" selection boxes.  We want a 15 minute granularity, not a 1 minute granularity.
		$s_time_minute = '<select name="s_time_minute" class="post">';
		for($i = 0; $i < 60; $i++)
		{
			$ifloor=$i/15;					//Added
			if(($ifloor) == floor($ifloor)) //Added
			{								//Added
				if($i < 10)
					$s_string = '0' . $i;
				else
					$s_string = $i;

				if(isset($s_time_minute_value) && $s_string == $s_time_minute_value)
					$s_time_minute .= '<option value="' . $s_string . '" selected>' . $s_string . '</option>';
				else
					$s_time_minute .= '<option value="' . $s_string . '">' . $s_string . '</option>';
			} 								//Added
		}
		$s_time_minute .= '</select>';

		if ($phpraid_config['ampm'] == '12')
		{
			$s_time_ampm = '<select name="s_time_ampm" class="post">';
			if(isset($s_time_ampm_value) && $s_time_ampm_value == 'am')
			{
				$s_time_ampm .= '<option value="am" selected>am</option><option value="pm">pm</option>';
			}
			elseif(isset($s_time_ampm_value) && $s_time_ampm_value == 'pm')
			{
				$s_time_ampm .= '<option value="am">am</option><option value="pm" selected>pm</option>';
			}
			else
			{
				$s_time_ampm .= '<option value="am">am</option><option value="pm" selected>pm</option>';
			}
			$s_time_ampm .= '</select>';
			// end of start time
		}
		
		// freeze
		$freeze = '<select name="freeze" class="post">';
		for($i = 0; $i <= 24; $i++)
		{
			if(isset($freeze_value) && $i == $freeze_value)
				$freeze .= '<option value="' . $i . '" selected>' . $i . '</option>';
			else
				$freeze .= '<option value="' . $i . '">' . $i . '</option>';
		}
		$freeze .= '</select>';
		
		// Event Type for WoW Calendar
		$eventtype = '<select name="event_type" class="post">';
		$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "event_type";
		$result2 = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
		while($event_type_data = $db_raid->sql_fetchrow($result2, true))
		{		
			// Event Type for WoW Calendar
			if (isset($event_type) && $event_type_data['event_type_id'] == $event_type)
				$eventtype .= '<option value="'.$event_type_data['event_type_id'].'" selected>' . $phprlang[$event_type_data['event_type_lang_id']] . '</option>';
			elseif (!isset($event_type) && $event_type_data['event_type_id'] == 1)
				$eventtype .= '<option value="'.$event_type_data['event_type_id'].'" selected>' . $phprlang[$event_type_data['event_type_lang_id']] . '</option>';
			else
				$eventtype .= '<option value="'.$event_type_data['event_type_id'].'">' . $phprlang[$event_type_data['event_type_lang_id']] . '</option>';
		}
		$eventtype .= '</select>';		
		// End Event Type Setup		
		
		$event_id_info = '<input type="hidden" name="event_id" class="post" value="' . $event_id . '">';

		// location
		if(isset($location_value))
			$location = '<input type="text" name="location" class="post" value="' . $location_value . '">';
		else
			$location = '<input type="text" name="location" class="post">';

		// Determine values for Location Dropdown.
		if (isset($_GET['location'])) {
		   $raid_location = scrub_input($_GET['location']);
		} else {
		   $raid_location = '';
		}
		if (isset($_GET['id'])) {
		   $raid_id = scrub_input($_GET['id']);
		} else {
		   $raid_id = '';
		}
			
		// setup vars for raid templates
		$array_raid_name = array();
		$array_raid_name[$page_filename.'?mode=new'] = "";

		if ($priv_raids == 1)
		{
			$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "locations ORDER BY name";
		}
		else
		{
			$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "locations WHERE locked='0' ORDER BY name";
		}
		$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
		while($data = $db_raid->sql_fetchrow($result, true))
		{
			$tmp_link = $page_filename.'?mode=new&id=' . $data['location_id'] . '&location=' . $data['name'];
			$array_raid_name[$tmp_link] = $data['name'];
			
			if($raid_location == $data['name'])
				$selected_raid_name = $tmp_link;
		 }

		// description
		if(!isset($description_value))
			$description_value = "";

		// limits
		$raid_class_array = array();
		$raid_role_array = array();
		if(isset($_GET['id']))
		{
			$maximum = $max_user;
			$minimum_level = $min_lvl_value;
			$maximum_level = $max_lvl_value;
			
			// Handle Classes
			foreach ($wrm_global_classes as $global_class)
				$raid_class_array[$global_class['class_id']] = '<input name="'.$global_class['class_id'].'" type="text" class="post" style="width:20px" value="' . $class[$global_class['class_id']] . '" maxlength="2">';
			
			// Handle Roles
			foreach ($wrm_global_roles as $global_role)	
			{
				if ($global_role['role_name'] != '')
					$raid_role_array[$global_role['role_id']] = '<input name="'.$global_role['role_id'].'" type="text" class="post" style="width:20px" value="' . $role[$global_role['role_name']] . '" maxlength="2">';
				else
					$raid_role_array[$global_role['role_id']] = '';	
			}					
		} else {
			$maximum = '1';
			$minimum_level = '1';
			$maximum_level =  '1';

			// Handle Classes
			foreach ($wrm_global_classes as $global_class)
				$raid_class_array[$global_class['class_id']] = '<input name="'.$global_class['class_id'].'" type="text" class="post" style="width:20px" maxlength="2">';
			
			// Handle Roles
			foreach ($wrm_global_roles as $global_role)	
			{
				if ($global_role['role_name'] != '')
					$raid_role_array[$global_role['role_id']] = '<input name="'.$global_role['role_id'].'" type="text" class="post" style="width:20px" maxlength="2">';
				else
					$raid_role_array[$global_role['role_id']] = '';	
			}			
		}
		
		/****************************************************************
		 * Data Assign for Template.
		 ****************************************************************/		
		$wrmsmarty->assign('page',
			array(
				'form_action'=>$form_action,
				'mode'=>$mode,
				'array_raid_name'=>$array_raid_name,
				'selected_raid_name'=>$selected_raid_name,
				'date'=>$date,
				'i_time_hour'=>$i_time_hour,
				'i_time_minute'=>$i_time_minute,
				'i_time_ampm'=>$i_time_ampm,
				's_time_hour'=>$s_time_hour,
				's_time_minute'=>$s_time_minute,
				's_time_ampm'=>$s_time_ampm,
				'freeze'=>$freeze,
				'event_type'=>$eventtype,
				'event_id_info'=>$event_id_info,
				'location'=>$location,
				'description_value'=>$description_value,
				'maximum'=>$maximum,
				'minimum_level'=>$minimum_level,
				'maximum_level'=>$maximum_level,
				'dungeon_text'=>$phprlang['raids_dungeon'],
				'date_text'=>$phprlang['raids_date'],
				'raids_new'=>$phprlang['raids_new_header'],
				'invite_text'=>$phprlang['raids_invite'],
				'start_text'=>$phprlang['raids_start'],
				'freeze_text'=>$phprlang['raids_freeze'],
				'eventtype_text'=>$phprlang['raids_eventtype_text'],
				'location_text'=>$phprlang['raids_location'],
				'description_text'=>$phprlang['raids_description'],
				'limits_text'=>$phprlang['raids_limits'],
				'max_text'=>$phprlang['raids_max'],
				'minlvl_text'=>$phprlang['raids_min_lvl'],
				'maxlvl_text'=>$phprlang['raids_max_lvl'],
				'raid_force'=>$raid_force_box,
				'raid_force_text'=>$phprlang['raid_force_name'],
				'recurrance_header'=>$phprlang['recur_header'],
				'recurring_checkbox'=>$recurring,
				'recurring_check_text'=>$phprlang['recurrance'],
				'recur_interval'=>$recur_interval,
				'recur_interval_text'=>$phprlang['recur_interval'],
				'recur_length'=>$recur_length,
				'recur_length_text'=>$phprlang['recur_length'],
				'button_submit' => $phprlang['submit'],
				'button_reset' => $phprlang['reset'],
				'show_recurrance' => $phpraid_config['recurrance_enabled'],
			)
		);
		
		// Handle Classes
		$class_array = array();
		foreach ($wrm_global_classes as $global_class)
		{				
			array_push($class_array,
				array(
					'lmt'=>$raid_class_array[$global_class['class_id']],
					'lang_id'=>$phprlang[$global_class['lang_index']],
				)
			);
		}
		$wrmsmarty->assign('class_limits', $class_array);
				
		// Handle Roles
		$role_array = array();
		foreach ($wrm_global_roles as $global_role)	
		{
			array_push($role_array,
				array(
					'lmt'=>$raid_role_array[$global_role['role_id']],
					'lang_id'=>$global_role['role_name'],
				)
			);
		}			
		$wrmsmarty->assign('role_limits', $role_array);	
		
		//
		// Start output of New Raid Or Edit Raid Page
		//
		require_once('includes/page_header.php');
		$wrmsmarty->display('raids_new.html');
		require_once('includes/page_footer.php');		
	}
	else // Submit Set, Error Title Not Set - Normal Submit.
	{
		// holy crap, time to put it into the database
		// variables first
		$max_user= scrub_input($_POST['max']);

		// Handle Classes
		foreach ($wrm_global_classes as $global_class)
		{
			$classtrans = str_replace(" ", "_", $global_class['class_id']);
			$class[$global_class['class_id']] = scrub_input($_POST[$classtrans]);
		}
		
		// Handle Roles
		foreach ($wrm_global_roles as $global_role)	
		{
			$role[$global_role['role_id']] = scrub_input($_POST[$global_role['role_id']]);
			if ($role[$global_role['role_id']] == '')
				$role[$global_role['role_id']] == '0'; 
		}

		$min_lvl = scrub_input($_POST['min_lvl']);
		$max_lvl = scrub_input($_POST['max_lvl']);

		$location = scrub_input(DEUBB($_POST['location']));

		$date = scrub_input($_POST['date']);
		$raid_force_name = scrub_input($_POST['raid_force_name']);
		$i_time_hour_value = scrub_input($_POST['i_time_hour']);
		$i_time_minute_value = scrub_input($_POST['i_time_minute']);
		$i_time_ampm_value = scrub_input($_POST['i_time_ampm']);
		$s_time_hour_value = scrub_input($_POST['s_time_hour']);
		$s_time_minute_value = scrub_input($_POST['s_time_minute']);
		$s_time_ampm_value = scrub_input($_POST['s_time_ampm']);
		$freeze = scrub_input($_POST['freeze']);
		$event_type = scrub_input($_POST['event_type']);
		$event_id = scrub_input($_POST['event_id']);
		$description = scrub_input(DEUBB($_POST['description']));
		$recur_interval = scrub_input($_POST['recur_interval']);
		$recur_length = scrub_input($_POST['recur_length']);
		
		if(isset($_GET['id']))
			$id = scrub_input($_GET['id']);
		else
			$id = '';

		if(isset($_POST['recurring']))
			$recurring = 1;
		else
			$recurring = 0;
			
		// setup the date, probably the only tricky tricky part :D
		$month = substr($date,0,2);
		$day = substr($date,3,2);
		$year = substr($date,6,4);

		if($i_time_ampm_value == 'pm' && $i_time_hour_value < 12)
			$i_time_hour_value += 12;

		if($s_time_ampm_value == 'pm' && $s_time_hour_value < 12)
			$s_time_hour_value += 12;

		$invite_time = new_mktime($i_time_hour_value,$i_time_minute_value,0,$month,$day,$year,$phpraid_config['timezone'] + $phpraid_config['dst']);
		$start_time = new_mktime($s_time_hour_value,$s_time_minute_value,0,$month,$day,$year,$phpraid_config['timezone'] + $phpraid_config['dst']);

		if ($recurring)
			$sql = sprintf("INSERT INTO " . $phpraid_config['db_prefix'] . "raids (`description`,`freeze`,`invite_time`,
				`location`,`officer`,`old`,`start_time`,`min_lvl`,`max_lvl`,`max`,`event_type`,
				`event_id`,`raid_force_name`,`recurrance`,`rec_interval`,`num_recur`)	
				VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)",
				quote_smart($description),quote_smart($freeze),quote_smart($invite_time),quote_smart($location),
				quote_smart($username),quote_smart('0'),quote_smart($start_time),
				quote_smart($min_lvl),quote_smart($max_lvl),quote_smart($max_user),quote_smart($event_type),quote_smart($event_id),
				quote_smart($raid_force_name),quote_smart($recurring),quote_smart($recur_interval),
				quote_smart($recur_length));
		else
			$sql = sprintf("INSERT INTO " . $phpraid_config['db_prefix'] . "raids (`description`,`freeze`,`invite_time`,
				`location`,`officer`,`old`,`start_time`,`min_lvl`,`max_lvl`,`max`,`event_type`,
				`event_id`,`raid_force_name`,`recurrance`)	
				VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)",
				quote_smart($description),quote_smart($freeze),quote_smart($invite_time),quote_smart($location),
				quote_smart($username),quote_smart('0'),quote_smart($start_time),
				quote_smart($min_lvl),quote_smart($max_lvl),quote_smart($max_user),quote_smart($event_type),quote_smart($event_id),
				quote_smart($raid_force_name),'0');
		
		$db_raid->sql_query($sql) or print_error($sql,$db_raid->sql_error(),1);

		// Get the Location ID of what was Just Entered to Apply to the Lookup Tables
		$sql = "SELECT raid_id FROM " . $phpraid_config['db_prefix'] . "raids ORDER BY raid_id DESC LIMIT 1";
		$raid_id_result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
		$raid_id = $db_raid->sql_fetchrow($raid_id_result, true);
		
		// Insert Class Data to loc_class_lmt
		foreach ($wrm_global_classes as $global_class)
		{
			$sql = sprintf("INSERT INTO " . $phpraid_config['db_prefix'] . "raid_class_lmt (`raid_id`, `class_id`, `lmt`)
			VALUES (%s,%s,%s)",quote_smart($raid_id['raid_id']), quote_smart($global_class['class_id']), quote_smart($class[$global_class['class_id']]));
			
			$db_raid->sql_query($sql) or print_error($sql,$db_raid->sql_error(),1);
		}
		
		// Insert Role Data to loc_role_lmt
		foreach ($wrm_global_roles as $global_role)	
		{
			$sql = sprintf("INSERT INTO " . $phpraid_config['db_prefix'] . "raid_role_lmt (`raid_id`, `role_id`, `lmt`)
			VALUES (%s,%s,%s)",quote_smart($raid_id['raid_id']), quote_smart($global_role['role_id']), quote_smart($role[$global_role['role_id']]));
			
			$db_raid->sql_query($sql) or print_error($sql,$db_raid->sql_error(),1);	
		}
		
		log_create('raid',mysql_insert_id(),$location);
		header("Location: raids.php?mode=view");
	}
}
/************************************************************************************************
 *   Mode: EDIT
 ************************************************************************************************/
elseif($_GET['mode'] == 'edit')
{
	// error checking, goes before the output so we can show the error at the top and allow them to fix the errors without pressing back
	if(isset($_POST['submit']))
	{
		$location = scrub_input($_POST['location']);
		$date = str_replace(" ", "", scrub_input($_POST['date']));
		$event_type = scrub_input($_POST['event_type']);
		if ($event_type == '')
			$event_type = "1";
		$event_id = scrub_input($_POST['event_id']);
		if ($event_id == '')
			$event_id = "0";
		$description = scrub_input($_POST['description']);
		$max_user = scrub_input($_POST['max']);
		$min_lvl = scrub_input($_POST['min_lvl']);
		$max_lvl = scrub_input($_POST['max_lvl']);
		$raid_force_name = scrub_input($_POST['raid_force_name']);

		// Handle Classes
		$bad_class_limit = FALSE;
		foreach ($wrm_global_classes as $global_class)
		{
			$classtrans = str_replace(" ", "_", $global_class['class_id']);
			if ($_POST[$classtrans]!='' && is_numeric($_POST[$classtrans]))
				$class[$global_class['class_id']] = scrub_input($_POST[$classtrans]);
			else
				$bad_class_limit = TRUE;
		}
		
		// Handle Roles
		$bad_role_limit = FALSE;
		foreach ($wrm_global_roles as $global_role)	
		{
			$role[$global_role['role_id']] = scrub_input($_POST[$global_role['role_id']]);
			if ($role[$global_role['role_id']] == '')
				$role[$global_role['role_id']] == '0'; 

			if($global_role['role_name'] != '')
				if (!is_numeric($role[$global_role['role_id']]))
					$bad_role_limit = TRUE;	
		}
		
		// Verify Data to ensure Correctness, set error if not.
		if($location == "" || $date == "" || $max_user == "" || $min_lvl == "" || $max_lvl == "" ||
		   !is_numeric($max_user) || !is_numeric($min_lvl) || !is_numeric($max_lvl) || $bad_class_limit ||
		   $bad_role_limit)
		{
			$errorTitle = $phprlang['form_error'];
			$errorSpace = 1;
			$errorMsg = '<ul>';
			if($location == "")
				$errorMsg .= '<li>' . $phprlang['raid_error_location'] . '</li>';

			if($date == "")
				$errorMsg .= '<li>' . $phprlang['raid_error_date'] . '</li>';

			if($max_user == "" || $min_lvl == "" || $max_lvl == "" ||
			!is_numeric($max_user) || !is_numeric($min_lvl) || !is_numeric($max_lvl) || $bad_class_limit ||
			$bad_role_limit)
				$errorMsg .= '<li>' . $phprlang['raid_error_limits'] . '</li>';
		}
		if($description == "")				
		{									
        	$description="-";			
        	$_POST['description']="-";	
		}
	}

	// Either We Haven't submitted the form or we have and we errored.  
	//   If we have submitted the form and errored, set variables, otherwise just 
	//   build form.
	if(!isset($_POST['submit']) || isset($errorTitle))
	{
		// setup the form action first
		$id = scrub_input($_GET['id']); // Raid ID
		$mode = 'edit';
		$form_action = 'raids.php?mode='.$mode.'&amp;id='. $id;
		
		// They screwed up the form on submission.
		if(isset($errorTitle))
		{
			$event_type = scrub_input($_POST['event_type']);
			$event_id = scrub_input($_POST['event_id']);
			$max_user = scrub_input($_POST['max']);

			// Handle Classes
			foreach ($wrm_global_classes as $global_class)
			{
				$classtrans = str_replace(" ", "_", $global_class['class_id']);
				$class[$global_class['class_id']] = scrub_input($_POST[$classtrans]);
			}
			
			// Handle Roles
			foreach ($wrm_global_roles as $global_role)	
			{
				$role[$global_role['role_id']] = scrub_input($_POST[$global_role['role_id']]);
				if ($role[$global_role['role_id']] == '')
					$role[$global_role['role_id']] == '0'; 
			}			
			$min_lvl_value = scrub_input($_POST['min_lvl']);
			$max_lvl_value = scrub_input($_POST['max_lvl']);
			$location_value = scrub_input($_POST['location']);
			$date_value = scrub_input($_POST['date']);
			$raid_force_name = scrub_input($_POST['raid_force_name']);
			$i_time_hour_value = scrub_input($_POST['i_time_hour']);
			$i_time_minute_value = scrub_input($_POST['i_time_minute']);
			$i_time_ampm_value = scrub_input($_POST['i_time_ampm']);
			$s_time_hour_value = scrub_input($_POST['s_time_hour']);
			$s_time_minute_value = scrub_input($_POST['s_time_minute']);
			$s_time_ampm_value = scrub_input($_POST['s_time_ampm']);
			$freeze_value = scrub_input($_POST['freeze']);
			$description_value = scrub_input($_POST['description']);
		}
		else
		{
			// Grab Values for Edit from Raid in DB.
			$id = scrub_input($_GET['id']);
			$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "raids WHERE raid_id=%s", quote_smart($id));
			$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
			$data = $db_raid->sql_fetchrow($result, true);
			            
			$event_type = $data['event_type'];
			$event_id = $data['event_id'];
			$max_user = $data['max'];
			$raid_force_name = $data['raid_force_name'];
			
			// Now that we have the raid data, we need to retrieve limit data based upon Raid ID.
			// Get Class Limits and set Colored Counts
			//$raid_class_array = array();
			$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "raid_class_lmt WHERE raid_id = %s", quote_smart($data['raid_id']));
			$result_raid_class = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
			while($raid_class_data = $db_raid->sql_fetchrow($result_raid_class, true))
			{
				$class[$raid_class_data['class_id']] = $raid_class_data['lmt'];
			}
			// Get Role Limits and set Colored Counts
			//$raid_role_array = array();
			$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "raid_role_lmt WHERE raid_id = %s", quote_smart($data['raid_id']));
			$result_raid_role = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
			while($raid_role_data = $db_raid->sql_fetchrow($result_raid_role, true))
			{
				$sql2 = sprintf("SELECT role_name FROM " . $phpraid_config['db_prefix'] . "roles WHERE role_id = %s", quote_smart($raid_role_data['role_id']));
				$result_role_name = $db_raid->sql_query($sql2) or print_error($sql2, $db_raid->sql_error(), 1);
				$role_name = $db_raid->sql_fetchrow($result_role_name, true);
								
				$role[$role_name['role_name']] = $raid_role_data['lmt'];
			}	            
			$min_lvl_value = $data['min_lvl'];
			$max_lvl_value = $data['max_lvl'];
			$location_value = UBB2($data['location']);
			$date_value = new_date("m/d/Y",$data['start_time'],$phpraid_config['timezone'] + $phpraid_config['dst']);
			if ($phpraid_config['ampm'] == '12')
				$i_time_hour_value = new_date("h",$data['invite_time'],$phpraid_config['timezone'] + $phpraid_config['dst']);
			else
				$i_time_hour_value = new_date("H",$data['invite_time'],$phpraid_config['timezone'] + $phpraid_config['dst']);	            	
			$i_time_minute_value = new_date("i",$data['invite_time'],$phpraid_config['timezone'] + $phpraid_config['dst']);
			$i_time_ampm_value = new_date("a",$data['invite_time'],$phpraid_config['timezone'] + $phpraid_config['dst']);
			if ($phpraid_config['ampm'] == '12')
				$s_time_hour_value = new_date("h",$data['start_time'],$phpraid_config['timezone'] + $phpraid_config['dst']);
			else
				$s_time_hour_value = new_date("H",$data['start_time'],$phpraid_config['timezone'] + $phpraid_config['dst']);
			$s_time_minute_value = new_date("i",$data['start_time'],$phpraid_config['timezone'] + $phpraid_config['dst']);
			$s_time_ampm_value = new_date("a",$data['start_time'],$phpraid_config['timezone'] + $phpraid_config['dst']);
			$freeze_value = $data['freeze'];
			$description_value = UBB2($data['description']);
		}

		// now for the actual form elements
		if(isset($date_value))
			$date = '<input type="text" name="date" size="20" class="post" READONLY value="' . $date_value . '"><a href="javascript:showCal(\'Calendar1\')"><span class="gen"> [+]</span></a>';
		else
			$date = '<input type="text" name="date" size="20" class="post" READONLY><a href="javascript:showCal(\'Calendar1\')"><span class="gen"> [+]</span></a>';

		// This code sets up the selection box for raid force from the raid_force table.
		$raid_force_box = '<select name="raid_force_name" class="post">';
		$raid_force_box .= "<option SELECTED value=\"All\">" . $phprlang['all'] ."</option>";
		
		$sql = "SELECT DISTINCT raid_force_name FROM " . $phpraid_config['db_prefix'] . "raid_force";
		$raid_force_result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
		while($raid_force_data = $db_raid->sql_fetchrow($raid_force_result, true))
		{
			$raid_force_box .= "<option ";
			if ($raid_force_name == $raid_force_data['raid_force_name'])
				$raid_force_box .= "SELECTED ";
			$raid_force_box .= "value=\"" . $raid_force_data['raid_force_name'] . "\">" . $raid_force_data['raid_force_name'] ."</option>";	
		}
		$raid_force_box .= '</select>';
			
		// invite time
		$i_time_hour = '<select name="i_time_hour" class="post">';
		for($i = 1; $i <= $phpraid_config['ampm']; $i++)
		{
			if($i < 10)
				$i_string = '0' . $i;
			else
				$i_string = $i;

			if(isset($i_time_hour_value) && $i_string == $i_time_hour_value)
				$i_time_hour .= '<option value="' . $i_string . '" selected>' . $i_string . '</option>';
			else
				$i_time_hour .= '<option value="' . $i_string . '">' . $i_string . '</option>';
		}
		$i_time_hour .= '</select>';

		//~@@Change: Douglas Wagner - 6/23/2007
		// This code reduces the selections in the "minute" selection boxes.  We want a 15 minute granularity, not a 1 minute granularity.
		$i_time_minute = '<select name="i_time_minute" class="post">';
		for($i = 0; $i < 60; $i++)
		{
			$ifloor=$i/15;					//Added
			if(($ifloor) == floor($ifloor)) //Added
			{								//Added
				if($i < 10)
					$i_string = '0' . $i;
				else
					$i_string = $i;

				if(isset($i_time_minute_value) && $i_string == $i_time_minute_value)
					$i_time_minute .= '<option value="' . $i_string . '" selected>' . $i_string . '</option>';
				else
					$i_time_minute .= '<option value="' . $i_string . '">' . $i_string . '</option>';
			} 								//Added
		}
		$i_time_minute .= '</select>';

		if ($phpraid_config['ampm'] == '12')
		{
			$i_time_ampm = '<select name="i_time_ampm" class="post">';
			if(isset($i_time_ampm_value) && $i_time_ampm_value == 'am')
			{
				$i_time_ampm .= '<option value="am" selected>am</option><option value="pm">pm</option>';
			}
			elseif(isset($i_time_ampm_value) && $i_time_ampm_value == 'pm')
			{
				$i_time_ampm .= '<option value="am">am</option><option value="pm" selected>pm</option>';
			}
			else
			{
				$i_time_ampm .= '<option value="am">am</option><option value="pm" selected>pm</option>';
			}
			$i_time_ampm .= '</select>';
			// end of invite time
		}
		
		// start time
		$s_time_hour = '<select name="s_time_hour" class="post">';
		for($i = 1; $i <= $phpraid_config['ampm']; $i++)
		{
			if($i < 10)
				$s_string = '0' . $i;
			else
				$s_string = $i;

			if(isset($s_time_hour_value) && $s_string == $s_time_hour_value)
				$s_time_hour .= '<option value="' . $s_string . '" selected>' . $s_string . '</option>';
			else
				$s_time_hour .= '<option value="' . $s_string . '">' . $s_string . '</option>';
		}
		$s_time_hour .= '</select>';

		//~@@Change: Douglas Wagner - 6/23/2007
		// This code reduces the selections in the "minute" selection boxes.  We want a 15 minute granularity, not a 1 minute granularity.
		$s_time_minute = '<select name="s_time_minute" class="post">';
		for($i = 0; $i < 60; $i++)
		{
			$ifloor=$i/15;					//Added
			if(($ifloor) == floor($ifloor)) //Added
			{								//Added
				if($i < 10)
					$s_string = '0' . $i;
				else
					$s_string = $i;

				if(isset($s_time_minute_value) && $s_string == $s_time_minute_value)
					$s_time_minute .= '<option value="' . $s_string . '" selected>' . $s_string . '</option>';
				else
					$s_time_minute .= '<option value="' . $s_string . '">' . $s_string . '</option>';
			} 								//Added
		}
		$s_time_minute .= '</select>';

		if ($phpraid_config['ampm'] == '12')
		{
			$s_time_ampm = '<select name="s_time_ampm" class="post">';
			if(isset($s_time_ampm_value) && $s_time_ampm_value == 'am')
			{
				$s_time_ampm .= '<option value="am" selected>am</option><option value="pm">pm</option>';
			}
			elseif(isset($s_time_ampm_value) && $s_time_ampm_value == 'pm')
			{
				$s_time_ampm .= '<option value="am">am</option><option value="pm" selected>pm</option>';
			}
			else
			{
				$s_time_ampm .= '<option value="am">am</option><option value="pm" selected>pm</option>';
			}
			$s_time_ampm .= '</select>';
			// end of start time
		}
		
		// freeze
		$freeze = '<select name="freeze" class="post">';
		for($i = 0; $i <= 24; $i++)
		{
			if(isset($freeze_value) && $i == $freeze_value)
				$freeze .= '<option value="' . $i . '" selected>' . $i . '</option>';
			else
				$freeze .= '<option value="' . $i . '">' . $i . '</option>';
		}
		$freeze .= '</select>';
		
		// Event Type for WoW Calendar
		$eventtype = '<select name="event_type" class="post">';
		$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "event_type";
		$result2 = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
		while($event_type_data = $db_raid->sql_fetchrow($result2, true))
		{		
			// Event Type for WoW Calendar
			if (isset($event_type) && $event_type_data['event_type_id'] == $event_type)
				$eventtype .= '<option value="'.$event_type_data['event_type_id'].'" selected>' . $phprlang[$event_type_data['event_type_lang_id']] . '</option>';
			elseif (!isset($event_type) && $event_type_data['event_type_id'] == 1)
				$eventtype .= '<option value="'.$event_type_data['event_type_id'].'" selected>' . $phprlang[$event_type_data['event_type_lang_id']] . '</option>';
			else
				$eventtype .= '<option value="'.$event_type_data['event_type_id'].'">' . $phprlang[$event_type_data['event_type_lang_id']] . '</option>';
		}
		$eventtype .= '</select>';		
		// End Event Type Setup		

		// location
		if(isset($location_value))
			$location = '<input type="text" name="location" class="post" value="' . $location_value . '">';
		else
			$location = '<input type="text" name="location" class="post">';

		// setup vars for raid templates
		$array_raid_name = array();
		$event_id_info = '<input type="hidden" name="event_id" class="post" value="' . $event_id . '">';
					
		$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "locations WHERE event_id=%s", quote_smart($event_id));
		$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);

		while($data = $db_raid->sql_fetchrow($result, true))
		{
			$tmp_link = $data['event_id'];
			$array_raid_name[$tmp_link] = $data['name'];
			$selected_raid_name = $tmp_link;
		 }

		// description
		if(!isset($description_value))
			$description_value = "";

		// limits
		$raid_class_array = array();
		$raid_role_array = array();
		$maximum = $max_user;
		$minimum_level = $min_lvl_value;
		$maximum_level = $max_lvl_value;
		
		// Handle Classes
		foreach ($wrm_global_classes as $global_class)
			$raid_class_array[$global_class['class_id']] = '<input name="'.$global_class['class_id'].'" type="text" class="post" style="width:20px" value="' . $class[$global_class['class_id']] . '" maxlength="2">';
		
		// Handle Roles
		foreach ($wrm_global_roles as $global_role)	
		{
			if ($global_role['role_name'] != '')
				$raid_role_array[$global_role['role_id']] = '<input name="'.$global_role['role_id'].'" type="text" class="post" style="width:20px" value="' . $role[$global_role['role_name']] . '" maxlength="2">';
			else
				$raid_role_array[$global_role['role_id']] = '';	
		}					

		/****************************************************************
		 * Data Assign for Template.
		 ****************************************************************/		
		$wrmsmarty->assign('page',
			array(
				'form_action'=>$form_action,
				'mode'=>$mode,
				'array_raid_name'=>$array_raid_name,
				'raid_name'=>$raid_name,
				'date'=>$date,
				'i_time_hour'=>$i_time_hour,
				'i_time_minute'=>$i_time_minute,
				'i_time_ampm'=>$i_time_ampm,
				's_time_hour'=>$s_time_hour,
				's_time_minute'=>$s_time_minute,
				's_time_ampm'=>$s_time_ampm,
				'freeze'=>$freeze,
				'event_type'=>$eventtype,
				'event_id_info'=>$event_id_info,
				'location'=>$location,
				'description_value'=>$description_value,
				'maximum'=>$maximum,
				'minimum_level'=>$minimum_level,
				'maximum_level'=>$maximum_level,
				'dungeon_text'=>$phprlang['raids_dungeon'],
				'date_text'=>$phprlang['raids_date'],
				'raids_new'=>$phprlang['raids_edit_header'],
				'invite_text'=>$phprlang['raids_invite'],
				'start_text'=>$phprlang['raids_start'],
				'freeze_text'=>$phprlang['raids_freeze'],
				'eventtype_text'=>$phprlang['raids_eventtype_text'],
				'location_text'=>$phprlang['raids_location'],
				'description_text'=>$phprlang['raids_description'],
				'limits_text'=>$phprlang['raids_limits'],
				'max_text'=>$phprlang['raids_max'],
				'minlvl_text'=>$phprlang['raids_min_lvl'],
				'maxlvl_text'=>$phprlang['raids_max_lvl'],
				'raid_force'=>$raid_force_box,
				'raid_force_text'=>$phprlang['raid_force_name'],
				'button_submit' => $phprlang['submit'],
				'button_reset' => $phprlang['reset']
			)
		);
		
		// Handle Classes
		$class_array = array();
		foreach ($wrm_global_classes as $global_class)
		{				
			array_push($class_array,
				array(
					'lmt'=>$raid_class_array[$global_class['class_id']],
					'lang_id'=>$phprlang[$global_class['lang_index']],
				)
			);
		}
		$wrmsmarty->assign('class_limits', $class_array);
				
		// Handle Roles
		$role_array = array();
		foreach ($wrm_global_roles as $global_role)	
		{
			array_push($role_array,
				array(
					'lmt'=>$raid_role_array[$global_role['role_id']],
					'lang_id'=>$global_role['role_name'],
				)
			);
		}			
		$wrmsmarty->assign('role_limits', $role_array);	
		
		//
		// Start output of New Raid Or Edit Raid Page
		//
		require_once('includes/page_header.php');
		$wrmsmarty->display('raids_new.html');
		require_once('includes/page_footer.php');		
	}
	else
	{
		// holy crap, time to put it into the database
		// variables first
		$max_user = scrub_input($_POST['max']);

		// Handle Classes
		foreach ($wrm_global_classes as $global_class)
		{
			$classtrans = str_replace(" ", "_", $global_class['class_id']);
			$class[$global_class['class_id']] = scrub_input($_POST[$classtrans]);
		}
		
		// Handle Roles
		foreach ($wrm_global_roles as $global_role)	
		{
			$role[$global_role['role_id']] = scrub_input($_POST[$global_role['role_id']]);
			if ($role[$global_role['role_id']] == '')
				$role[$global_role['role_id']] == '0'; 
		}

		$min_lvl = scrub_input($_POST['min_lvl']);
		$max_lvl = scrub_input($_POST['max_lvl']);

		$location = scrub_input(DEUBB($_POST['location']));

		$date = scrub_input($_POST['date']);
		$raid_force_name = scrub_input($_POST['raid_force_name']);
		$i_time_hour_value = scrub_input($_POST['i_time_hour']);
		$i_time_minute_value = scrub_input($_POST['i_time_minute']);
		$i_time_ampm_value = scrub_input($_POST['i_time_ampm']);
		$s_time_hour_value = scrub_input($_POST['s_time_hour']);
		$s_time_minute_value = scrub_input($_POST['s_time_minute']);
		$s_time_ampm_value = scrub_input($_POST['s_time_ampm']);
		$freeze = scrub_input($_POST['freeze']);
		$event_type = scrub_input($_POST['event_type']);
		$event_id = scrub_input($_POST['event_id']);
		$description = scrub_input(DEUBB($_POST['description']));
		if(isset($_GET['id']))
			$id = scrub_input($_GET['id']);
		else
			$id = '';

		// setup the date, probably the only tricky tricky part :D
		$month = substr($date,0,2);
		$day = substr($date,3,2);
		$year = substr($date,6,4);

		if($i_time_ampm_value == 'pm' && $i_time_hour_value < 12)
			$i_time_hour_value += 12;

		if($s_time_ampm_value == 'pm' && $s_time_hour_value < 12)
			$s_time_hour_value += 12;

		$invite_time = new_mktime($i_time_hour_value,$i_time_minute_value,0,$month,$day,$year,$phpraid_config['timezone'] + $phpraid_config['dst']);
		$start_time = new_mktime($s_time_hour_value,$s_time_minute_value,0,$month,$day,$year,$phpraid_config['timezone'] + $phpraid_config['dst']);

		$sql = sprintf("UPDATE " . $phpraid_config['db_prefix'] . "raids SET location=%s,description=%s,invite_time=%s,start_time=%s,
				freeze=%s,max=%s,event_type=%s,event_id=%s,old='0',min_lvl=%s,max_lvl=%s,raid_force_name=%s WHERE raid_id=%s",
				quote_smart($location),quote_smart($description),quote_smart($invite_time),quote_smart($start_time), quote_smart($freeze),
				quote_smart($max_user),quote_smart($event_type),quote_smart($event_id),quote_smart($min_lvl),quote_smart($max_lvl),quote_smart($raid_force_name),quote_smart($id));

		$db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);

		// Insert Class Data to loc_class_lmt
		foreach ($wrm_global_classes as $global_class)
		{
			$sql = sprintf("UPDATE " . $phpraid_config['db_prefix'] . "raid_class_lmt SET lmt=%s WHERE raid_id=%s AND class_id=%s",
			quote_smart($class[$global_class['class_id']]), quote_smart($id), quote_smart($global_class['class_id']));
			
			$db_raid->sql_query($sql) or print_error($sql,$db_raid->sql_error(),1);
		}
		
		// Insert Role Data to loc_role_lmt
		foreach ($wrm_global_roles as $global_role)	
		{
			$sql = sprintf("UPDATE " . $phpraid_config['db_prefix'] . "raid_role_lmt SET lmt=%s WHERE raid_id=%s AND role_id=%s",
			quote_smart($role[$global_role['role_id']]), quote_smart($id), quote_smart($global_role['role_id']));
			
			$db_raid->sql_query($sql) or print_error($sql,$db_raid->sql_error(),1);	
		}		
		header("Location: raids.php?mode=view");
	}
}
/************************************************************************************************
 *   Mode: DELETE
 ************************************************************************************************/
elseif($_GET['mode'] == 'delete')
{
	$id = scrub_input($_GET['id']);
	$n = scrub_input($_GET['n']);

	if(!isset($_POST['submit']))
	{
		$form_action = "raids.php?mode=delete&amp;n=$n&amp;id=$id";
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
		// Start output of Delete Page
		//
		require_once('includes/page_header.php');
		$wrmsmarty->display('delete.html');
		require_once('includes/page_footer.php');		
	}
	else
	{

		raid_del($id,$n);
		header("Location: raids.php?mode=view");
	}
}
/************************************************************************************************
 *   Mode: MARK
 ************************************************************************************************/
elseif($_GET['mode'] == 'mark')
{
	$raid_id = scrub_input($_GET['id']);
	
	raid_mark($raid_id);

	header("Location: raids.php?mode=view");
}

?>