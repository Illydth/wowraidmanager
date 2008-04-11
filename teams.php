<?php
/***************************************************************************
 *                              teams.php
 *                            -------------------
 *   begin                : Monday, July 2, 2007
 *   copyright            : (C) 2007 Douglas Wagner
 *   email                : douglasw@wagnerweb.org
 *
 *   $Id: mysql.php,v 1.16 2002/03/19 01:07:36 psotfx Exp $
 *
 ***************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/
// commons
define("IN_PHPRAID", true);	
require_once('./common.php');

// page authentication
define("PAGE_LVL","raids");
require_once($phpraid_dir.'includes/authentication.php');

// check for valid input of raid_id
if(!isset($_GET['raid_id']) || !is_numeric($_GET['raid_id']))
	log_hack();

// check for mode passing
isset($_GET['mode']) ? $mode = $_GET['mode'] : $mode = '';

if($mode == '')
	log_hack();
	
// check for invalid raid passed
isset($_GET['raid_id']) ? $raid_id = $_GET['raid_id'] : $raid_id = '';

if($raid_id == '' || !is_numeric($raid_id))
	log_hack();

//View Mode, display the page with Current Data.
if($mode == 'view')
{
	//**********************************************	
	//Setup the "New Team" Form
	//**********************************************
	$team_new = '<form action="teams.php?mode=new&raid_id='.$raid_id.'" method="POST">';
	$team_new .= '<input name="team_name" type="text" class="post"><br>';
	$team_new .= '<input type="checkbox" name="global" value="1">  ';
	$team_new .= $phprlang['team_global'] . '<br><br>';
	$team_new .= '<input type="submit" name="submit" value="'.$phprlang['add'].'" class="mainoption"> ';
	$team_new .= '<input type="reset" name="reset" value="'.$phprlang['reset'].'" class="liteoption">';
	$team_new .= '</form>';
	
	$team_cur_teams = '<form action="teams.php?mode=delteam&raid_id='.$raid_id.'" method="POST">';
	
	$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "teams WHERE (raid_id='$raid_id' and char_id='-1') or char_id='-2'";
	$teams_result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
	while($team = $db_raid->sql_fetchrow($teams_result))
	{
		if ($team['char_id']=="-2")
			$team_cur_teams .= "<b>" . $team['team_name'] . "</b>  ";
		else
			$team_cur_teams .= $team['team_name'] . "  ";
			
		$team_cur_teams .= '<input type="checkbox" name="delteam' . $team['team_id'] . '" value="' . $team['team_id'] . '"><br>'; 
	}
	$team_cur_teams .= '<br>';
	$team_cur_teams .= '<input type="submit" name="submit" value="'.$phprlang['delete'].'" class="mainoption"> ';
	$team_cur_teams .= '<input type="reset" name="reset" value="'.$phprlang['reset'].'" class="liteoption">';
	$team_cur_teams .= '</form>';
	
	//********************************************
	//Setup the "Remove Users from Team" section.
	//********************************************
	$team_remove = array();
	
	// get everyone already on a team for this raid, print info from chars table, selection from teams table, 
	//   join is on char_id.
	$sql = "select " . $phpraid_config['db_prefix'] . "chars.char_id, " . 
					   $phpraid_config['db_prefix'] . "chars.name, " . 
					   $phpraid_config['db_prefix'] . "chars.class, " .
					   $phpraid_config['db_prefix'] . "chars.guild, " . 
					   $phpraid_config['db_prefix'] . "chars.lvl, " . 
					   $phpraid_config['db_prefix'] . "teams.team_name " . 
			"from " . $phpraid_config['db_prefix'] . "teams, " .
					  $phpraid_config['db_prefix'] . "chars " .
			"where " . $phpraid_config['db_prefix'] . "teams.char_id = " . $phpraid_config['db_prefix'] . "chars.char_id " .
			"and " . $phpraid_config['db_prefix'] . "teams.raid_id = '" . $raid_id . "'"; 
	$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
	while($team = $db_raid->sql_fetchrow($result))
	{
		// set delete permissions 
		if($_SESSION['priv_raids'] == 1) {
			$delete = '<a href="teams.php?mode=remove&raid_id=' . $raid_id . '&char_id='.$team['char_id'].'">
						<img src="templates/' . $phpraid_config['template'] . '/images/icons/icon_delete.gif" border="0" 
						onMouseover="ddrivetip(\''.$phprlang['remove_user'].'\')"; onMouseout="hideddrivetip()"></a>';
		} else {
			$delete = '';
		}
	
		array_push($team_remove,
			array(
				'id'=>$team['char_id'],
				'name'=>$team['name'],
				'class'=>$team['class'],
				'guild'=>$team['guild'],
				'level'=>$team['lvl'],
				'team_name'=>$team['team_name'],
				'admin'=>$delete
			)
		);
	}
	
	// setup report (users)
	$report->clearOutputColumns();
	//Default sorting
	$report->allowSort(true, 'name', 'ASC', 'teams.php?mode=view&raid_id=' . $raid_id);
	setup_output();
		
	$report->showRecordCount(true);
	//$report->allowPaging(true, $_SERVER['PHP_SELF'] . '?mode=view&raid_id=' . $raid_id . '&Base=');
	$report->setListRange($_GET['Base'], 25);
	$report->allowLink(ALLOW_HOVER_INDEX,'',array());
		
	if($phpraid_config['show_id'] == 1)
		$report->addOutputColumn('id',$phprlang['id'],'','center');
	$report->addOutputColumn('name',$phprlang['username'],'','left');
	$report->addOutputColumn('class',$phprlang['class'],'','left');
	$report->addOutputColumn('guild',$phprlang['guild'],'','left');
	$report->addOutputColumn('level',$phprlang['level'],'','left');
	$report->addOutputColumn('team_name',$phprlang['team_name'],'','left');
	$report->addOutputColumn('admin','','','right',__NOLINK__);
	$team_remove_body .= $report->getListFromArray($team_remove);
	
//******************************************
//Setup the "Add Users to Team" section.
//******************************************
//$team_add = 'Characters to Add go here.';
	$signups = array();
	$teamed_users = array();
	$unteamed_users = array();
	$team_add = array();
		
	//************************************************
	//  So here we need to get everyone who is NOT already place into a team.  This would be trivial with a
	//    subselect using a NOT IN and checking the char_id in signups vs the char_id in teams.  That said, 
	//    mysql 4.0 DOES NOT support subselects...thus we have to do this the hard way around by getting
	//    the data from the first table, the second table, and then parsing that data into a third variable
	//    that contains the differences between the two.
	//*************************************************	
	// get everyone signed up for this raid: 
	$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "signups WHERE raid_id='$raid_id' and cancel='0' and queue='0'";
	$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
			
	$X=0;		
	while($data = $db_raid->sql_fetchrow($result))
	{
		$signups[$X]['char_id'] = $data['char_id'];
		$X++;
	}
	$signups_num=$X;
	
	// get everyone already on a team for this raid 
	$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "teams WHERE raid_id='$raid_id'";
	$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
	
	$X=0;
	while($data = $db_raid->sql_fetchrow($result))
	{
		$teamed_users[$X]['char_id']=$data['char_id'];
		$X++;
	}
	$teamed_users_num=$X;
	
	// now we need to compare the first array's data vs the second array and put info from array 1 into array
	//   3 if it's not in array 2...the trials of having to support old versions of MySQL.
	$Z=0;
	for($X=0; $X<$signups_num; $X++)
	{
		$found=FALSE;
		for($Y=0; $Y<$teamed_users_num; $Y++)
			if ($signups[$X]['char_id']==$teamed_users[$Y]['char_id'])
			{
				$found=TRUE;
				break;
			}
		if (!$found)
		{
			$unteamed_users[$Z]['char_id']=$signups[$X]['char_id'];
			$Z++;
		}		
	}
	$unteamed_users_num=$Z;
	
	//At this point we have a list of char_id's that are not already assigned to a team.  Now we need to get
	//  the data from the characters table to display and load that into our form.	
	for($X=0; $X<$unteamed_users_num;$X++)
	{
		$char_id = $unteamed_users[$X]['char_id']; 
			
		// get character data from the characters table.
		$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "chars WHERE char_id='$char_id'";
		$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
		$data = $db_raid->sql_fetchrow($result);

		$action='<input type="checkbox" name="addtolist' . $data['char_id'] . '" value="' . $data['char_id'] . '">';
		
		array_push($team_add,
			array(
				'id'=>$data['char_id'],
				'name'=>$data['name'],
				'class'=>$data['class'],
				'guild'=>$data['guild'],
				'level'=>$data['lvl'],
				'action'=>$action
			)
		);
	}	

	$team_add_body = '<form action="teams.php?mode=add&raid_id=' . $raid_id . '" method="POST">';
	$team_add_body .= '<center>';
	$team_add_body .= $phprlang['add_team_dropdown_text'];
	$team_add_body .= '<br><select name="team_drop_name" class="post">';

	// get character data from the teams table.
	$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "teams WHERE (raid_id='$raid_id' and char_id='-1') or char_id='-2'";
	$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
	while ($data = $db_raid->sql_fetchrow($result))
		$team_add_body .= '<option value="' . $data['team_id']. '">' . $data['team_name'] . '</option>';
	$team_add_body .= '</select></center><br>';
	
	// setup report (users)
	$report->clearOutputColumns();
	//Default sorting
	$report->allowSort(true, 'name', 'ASC', 'teams.php?mode=view&raid_id=' . $raid_id);
	setup_output();
		
	$report->showRecordCount(true);
	$report->allowPaging(true, $_SERVER['PHP_SELF'] . '?mode=view&raid_id=' . $raid_id . '&Base=');
	$report->setListRange($_GET['Base'], 25);
	$report->allowLink(ALLOW_HOVER_INDEX,'',array());
		
	if($phpraid_config['show_id'] == 1)
		$report->addOutputColumn('id',$phprlang['id'],'','center');
	$report->addOutputColumn('name',$phprlang['username'],'','left');
	$report->addOutputColumn('class',$phprlang['class'],'','left');
	$report->addOutputColumn('guild',$phprlang['guild'],'','left');
	$report->addOutputColumn('level',$phprlang['level'],'','left');
	$report->addOutputColumn('action',$phprlang['add_team'],'','left',__NOLINK__);
	$team_add_body .= $report->getListFromArray($team_add);
			
	$team_add_buttons = '<input type="submit" value="Submit" name="submit" class="mainoption"> 
						<input type="reset" value="Reset" name="reset" class="liteoption"></form>';
}
elseif($mode == 'new')
{
	isset($_POST['team_name']) ? $team_name = $_POST['team_name'] : $team_name = '';
	isset($_POST['global']) ? $global = $_POST['team_name'] : $global = '';

	if ($team_name != "")
	{
		if ($_POST['global'])
			$sql = sprintf("INSERT INTO " . $phpraid_config['db_prefix'] . "teams VALUES('0',%s,%s,'-2')",quote_smart($raid_id),quote_smart($team_name));
		else
			$sql = sprintf("INSERT INTO " . $phpraid_config['db_prefix'] . "teams VALUES('0',%s,%s,'-1')",quote_smart($raid_id),quote_smart($team_name));			

		$db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
		
		log_create('teams',mysql_insert_id(),$name);
	}
	header("Location: teams.php?mode=view&raid_id=$raid_id");
}
elseif($mode == 'remove')
{
	//We simply need to find the char ID/Raid ID combo in the teams table and delete the row.
	// check for invalid raid passed
	isset($_GET['char_id']) ? $char_id = $_GET['char_id'] : $char_id = '';

	if($char_id == '' || !is_numeric($char_id))
		log_hack();
	
	$sql = sprintf("DELETE FROM " . $phpraid_config['db_prefix'] . "teams WHERE raid_id=%s and char_id=%s", quote_smart($raid_id),quote_smart($char_id));
	$db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
			
	header("Location: teams.php?mode=view&raid_id=$raid_id");
}
elseif($mode == 'add')
{
	//Obtain and Verify the Team_ID from the POST data.
	isset($_POST['team_drop_name']) ? $team_id = $_POST['team_drop_name'] : $team_id = '';

	if($team_id == '' || !is_numeric($team_id))
		log_hack();
	
	//get team_name from team_id: Only one team name can be passed at any given time, so only retrieve team once.
	$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "teams WHERE team_id='$team_id'";
	$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
	$data = $db_raid->sql_fetchrow($result);
	$team_name = $data['team_name'];

	//For each char id on input, we need to add a record to the teams table noteing that that char is now on a team.
	foreach($_POST as $key=>$value) 
	{
		if($key != 'submit' and $key != 'team_drop_name') 
		{
			$char_id = $value;
			//insert character and raid to teams table.
			$sql = sprintf("INSERT INTO " . $phpraid_config['db_prefix'] . "teams (`team_id`,`raid_id`,`team_name`,`char_id`) 
						VALUES ('0',%s,%s,%s)", quote_smart($raid_id),quote_smart($team_name),quote_smart($char_id));
			$db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
				
			log_create('teams',mysql_insert_id(),$title);
		}
	}
	header("Location: teams.php?mode=view&raid_id=$raid_id");
}
elseif($mode == 'delteam')
{
	//For each team id on input, we need to delete a record from the teams table.
	foreach($_POST as $key=>$value) 
	{
		if($key != 'submit') 
		{
			$team_id = $value;
			
			//delete from teams table.
			$sql = sprintf("DELETE FROM " . $phpraid_config['db_prefix'] . "teams WHERE team_id=%s", quote_smart($team_id));
			$db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
				
			log_delete('teams',$title);
		}
	}
	header("Location: teams.php?mode=view&raid_id=$raid_id");
}
else
{
	$errorMsg = $phprlang['invalid_option_msg'];
	$errorTitle = $phprlang['invalid_option_title'];
	$errorDie = 1;
}

//Create Link back to the Raid View page.
$raid_view_link = '<a href="view.php?mode=view&raid_id=' . $raid_id . '">' . $phprlang['teams_raid_view_text'] . '</a>';

require_once('./includes/page_header.php');

$page->set_file('output',$phpraid_config['template'] . '/team_view.htm');
//	array(
//		'team_add'=>$team_add,
//		'character'=>$character,
//		'queue'=>$queue,
//		'comments'=>$comments,
//		'signup_action'=>$signup_action,
//		'hidden_vars'=>$hidden_vars,
//		'view_signup_header'=>$phprlang['view_new'],
//		'username_text'=>$phprlang['view_username'],
//		'character_text'=>$phprlang['view_character'],
//		'queue_text'=>$phprlang['view_queue'],
//		'comments_text'=>$phprlang['view_comments']
//	)
//);
$page->set_var(
	array(
		'team_page_header'=>$phprlang['team_page_header'],
		'team_new_header'=>$phprlang['team_new_header'],
		'team_new'=>$team_new,
		'team_remove_header'=>$phprlang['team_remove_header'],
		'team_remove_body'=>$team_remove_body,
		'team_add_header'=>$phprlang['team_add_header'],
		'team_add_body'=>$team_add_body,
		'team_add_buttons'=>$team_add_buttons,
		'raid_view_link'=>$raid_view_link,
		'team_cur_teams'=>$team_cur_teams,
		'team_cur_teams_header'=>$phprlang['team_cur_teams_header']
	)
);
$page->pparse('output','output');

require_once('./includes/page_footer.php');
?>
