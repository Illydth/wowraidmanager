<?php
/***************************************************************************
 *                                users.php
 *                            -------------------
 *   begin                : Saturday, Jan 16, 2005
 *   copyright            : (C) 2007-2008 Douglas Wagner
 *   email                : douglasw@wagnerweb.org
 *
 *   $Id: users.php,v 2.0 2008/03/08 15:28:46 psotfx Exp $
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
define("PAGE_LVL","users");
require_once("includes/authentication.php");

isset($_GET['mode']) ? $mode = scrub_input($_GET['mode']) : $mode = '';

if($mode == '')
	log_hack();
	
if($mode == 'view')
{
	$users = array();
	
	// get a list of all users and assign permissions accordingly
	$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "profile";
	$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
	
	while($data = $db_raid->sql_fetchrow($result))
	{
		$usersname = '<a href="users.php?mode=details&user_id='.$data['profile_id'].'">'.$data['username'].'</a>';
		
		if($data['priv'] == 0)
			$priv = '<a href="permissions.php?mode=view">'.$phprlang['users_assign'].'</a>';
		else
			$priv = '<a href="permissions.php?mode=details&id='.$data['priv'].'">'.get_priv_name($data['priv']).'</a>';
			
		$actions = '<a href="users.php?mode=remove_user&n='.$data['name'].'&user_id='.$data['profile_id'].'">
					<img src="templates/' . $phpraid_config['template'] . '/images/icons/icon_delete.gif" border="0" 
					onMouseover="ddrivetip(\''. $phprlang['delete'] .'\')"; onMouseout="hideddrivetip()"></a>';
		
		array_push($users, 
			array(
				'id'=>$data['profile_id'],
				'username'=>$usersname,
				'priv'=>$priv,
				'email'=>$data['email'],
				''=>$actions));
	}
	
	// setup output
	setup_output();
	$report->showRecordCount(true);
	$report->allowPaging(true, $_SERVER['PHP_SELF'] . '?mode=view&Base=');
	$report->setListRange($_GET['Base'], 25);
	$report->allowLink(ALLOW_HOVER_INDEX,'',array());
	
	//Default sorting
	if(!$_GET['Sort'])
	{
		$report->allowSort(true, 'username', 'ASC', 'users.php?mode=view');
	}
	else
	{
		$report->allowSort(true, $_GET['Sort'], $_GET['SortDescending'], 'users.php?mode=view');
	}
	
	if($phpraid_config['show_id'] == 1)
		$report->addOutputColumn('id',$phprlang['id'],'','center');
	$report->addOutputColumn('username',$phprlang['username'],'','center');
	$report->addOutputColumn('email',$phprlang['email'],'','center');
	$report->addOutputColumn('priv',$phprlang['priv'],'','center');
	$report->addOutputColumn('','','','right');
	$users = $report->getListFromArray($users);
	
	$page->set_file('body_file',$phpraid_config['template'] . '/users.htm');

	$page->set_var(
		array('users'=>$users,
			'header'=>$phprlang['users_header'])
	);
	
	$page->parse('output','body_file');
}
else if($mode == 'details')
{
	// detailed information
	$chars = array();
	$user_id = scrub_input($_GET['user_id']);
	
	// check valid input
	$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "profile WHERE profile_id=%s",quote_smart($user_id));
	$result = $db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	if($db_raid->sql_numrows($result) == 0)
	{
		// invalid user
		$errorMsg = $phprlang['no_user_msg'];
		$errorTitle = $phprlang['no_user_title'];
		$errorDie = 1;
	}
	
	$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "chars WHERE profile_id=%s",quote_smart($user_id));
	$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
	
	while($data = $db_raid->sql_fetchrow($result))
	{
		array_push($chars, 
			array(
				'ID'=>$data['char_id'],
				'Name'=>$data['name'],
				'Guild'=>$data['guild'],
				'Level'=>$data['lvl'],
				'Race'=>$data['race'],
				'Class'=>$data['class'],
				'Arcane'=>$data['arcane'],
				'Fire'=>$data['fire'],
				'Frost'=>$data['frost'],
				'Nature'=>$data['nature'],
				'Shadow'=>$data['shadow'],
				''=>'<a href="users.php?mode=remove_char&n='.$data['name'].'&char_id='.$data['char_id'].'&user_id='.$data['profile_id'].'"><img src="templates/' . $phpraid_config['template'] . '/images/icons/icon_delete.gif" border="0" onMouseover="ddrivetip(\''. $phprlang['delete'] .'\')"; onMouseout="hideddrivetip()"></a>')
			);
	}
	
	// setup formatting for report class (THANKS to www.thecalico.com)
	// generic settings
	setup_output();
	
	$report->showRecordCount(true);
	$report->allowPaging(true, $_SERVER['PHP_SELF'] . '?mode=view&Base=');
	$report->setListRange($_GET['Base'], 25);
	$report->allowLink(ALLOW_HOVER_INDEX,'',array());
	
	$report->allowSort(true, $_GET['Sort'], $_GET['SortDescending'], 'profile.php?mode=view');
	$report->showRecordCount(count);
	// display settings
	if($phpraid_config['show_id'] == 1)
		$report->addOutputColumn('ID',$phprlang['id'],'','center');
	$report->addOutputColumn('Name',$phprlang['name'],'','center');
	$report->addOutputColumn('Guild',$phprlang['guild'],'','center');
	$report->addOutputColumn('Level',$phprlang['level'],'','center');
	$report->addOutputColumn('Race',$phprlang['race'],'','center');
	$report->addOutputColumn('Class',$phprlang['class'],'','center');
	$report->addOutputColumn('Arcane','<img src="templates/' . $phpraid_config['template'] . '/images/resistances/arcane_resistance.gif" onMouseover="ddrivetip(\''.$phprlang['arcane'].'\')"; onMouseout="hideddrivetip()" height="16" width="16" border="0">','','center');
	$report->addOutputColumn('Fire','<img src="templates/' . $phpraid_config['template'] . '/images/resistances/fire_resistance.gif" onMouseover="ddrivetip(\''.$phprlang['fire'].'\')"; onMouseout="hideddrivetip()" height="16" width="16" border="0">','','center');
	$report->addOutputColumn('Nature','<img src="templates/' . $phpraid_config['template'] . '/images/resistances/nature_resistance.gif" onMouseover="ddrivetip(\''.$phprlang['nature'].'\')"; onMouseout="hideddrivetip()" height="16" width="16" border="0">','','center');
	$report->addOutputColumn('Frost','<img src="templates/' . $phpraid_config['template'] . '/images/resistances/frost_resistance.gif" onMouseover="ddrivetip(\''.$phprlang['frost'].'\')"; onMouseout="hideddrivetip()" height="16" width="16" border="0">','','center');
	$report->addOutputColumn('Shadow','<img src="templates/' . $phpraid_config['template'] . '/images/resistances/shadow_resistance.gif" onMouseover="ddrivetip(\''.$phprlang['shadow'].'\')"; onMouseout="hideddrivetip()" height="16" width="16" border="0">','','center');
	$report->addOutputColumn('','','','right');
	$chars = $report->getListFromArray($chars);
	
	$page->set_file('body_file',$phpraid_config['template'] . '/users_details.htm');

	$page->set_var(
		array('chars'=>$chars,
			'header'=>$phprlang['users_char_header'])
	);
	
	$page->parse('output','body_file');
}
else if($mode == 'remove_user')
{
	$user_id = scrub_input($_GET['user_id']);
	$delete_name = scrub_input($_GET['n']);
	
	if(!isset($_POST['submit'])) {			
		$form_action = 'users.php?mode=remove_user&user_id='.$user_id.'&n='.$delete_name;
		$confirm_button = '<input type="submit" value="Confirm" name="submit" class="post">';
			
		$page->set_file('output',$phpraid_config['template'] . '/delete.htm');
			
		$page->set_var(
			array(
				'form_action'=>$form_action,
				'confirm_button'=>$confirm_button,
				'delete_header'=>$phprlang['delete_header'],
				'delete_msg'=>$phprlang['delete_msg'],
			)
		);
		$page->parse('output','output');
	} else {
		log_delete('user',$delete_name);
			
		$sql = sprintf("DELETE FROM " . $phpraid_config['db_prefix'] . "profile WHERE profile_id=%s", quote_smart($user_id));
		$db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
		
		$sql = sprintf("DELETE FROM " . $phpraid_config['db_prefix'] . "chars WHERE profile_id=%s", quote_smart($user_id));
		$db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
			
		header("Location: users.php?mode=view");
	}
}
else if($mode == 'remove_char')
{
	$char_id = scrub_input($_GET['char_id']);
	$user_id = scrub_input($_GET['user_id']);
	$delete_name = scrub_input($_GET['n']);
	
	if(!isset($_POST['submit'])) {			
		$form_action = 'users.php?mode=remove_char&char_id='.$char_id.'&user_id='.$user_id.'&n='.$delete_name;
		$confirm_button = '<input type="submit" value="Confirm" name="submit" class="post">';
			
		$page->set_file('output',$phpraid_config['template'] . '/delete.htm');
			
		$page->set_var(
			array(
				'form_action'=>$form_action,
				'confirm_button'=>$confirm_button,
				'delete_header'=>$phprlang['delete_header'],
				'delete_msg'=>$phprlang['delete_msg'],
			)
		);
		$page->parse('output','output');
	} else {
		log_delete('character',$delete_name);
			
		$sql = sprintf("DELETE FROM " . $phpraid_config['db_prefix'] . "chars WHERE char_id=%s", quote_smart($char_id));
		$db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
		
		$sql = sprintf("DELETE FROM " . $phpraid_config['db_prefix'] . "signups WHERE char_id=%s", quote_smart($char_id));
		$db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
			
		header("Location: users.php?mode=details&user_id=$user_id");
	}
}
else
{
	$errorMsg = $phprlang['invalid_option_msg'];
	$errorTitle = $phprlang['invalid_option_title'];
	$errorDie = 1;
}

//
// Start output of page
//
require_once('includes/page_header.php');

$page->p('output');

require_once('includes/page_footer.php');
?>