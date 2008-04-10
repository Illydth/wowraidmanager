<?php
/***************************************************************************
 *                               guilds.php
 *                            -------------------
 *   begin                : Saturday, Jan 16, 2005
 *   copyright            : (C) 2005 Kyle Spraggs
 *   email                : spiffyjr@gmail.com
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
define("PAGE_LVL","guilds");
require_once($phpraid_dir.'includes/authentication.php');

// show the form
if($_GET['mode'] == 'view') {
	$loc = array();
	
	$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "guilds";
	$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(),1);
	while($data = $db_raid->sql_fetchrow($result)) {
		

	$edit = '<a href="guilds.php?mode=update&id='.$data['guild_id'].'"><img src="templates/' . $phpraid_config['template'] . 
			'/images/icons/icon_edit.gif" border="0" onMouseover="ddrivetip(\''.$phprlang['delete'].'\')"; onMouseout="hideddrivetip()"></a>';
			
	$delete = '<a href="guilds.php?mode=delete&n='.$data['guild_name'].'&id='.$data['guild_id'].'"><img src="templates/' . 
				$phpraid_config['template'] . '/images/icons/icon_delete.gif" border="0" onMouseover="ddrivetip(\''.$phprlang['delete'].'\')"; 
				onMouseout="hideddrivetip()"></a>';
		
		array_push($loc, 
			array(
				'id'=>$data['guild_id'],
				'name'=>$data['guild_name'],
				'short'=>$data['guild_tag'],
				'master'=>$data['guild_master'],
				''=>$edit . $delete,
				)
		);
	}
	
	// output for listing
	setup_output();
	
	$report->showRecordCount(true);
	$report->allowPaging(true, $_SERVER['PHP_SELF'] . '?mode=view&Base=');
	$report->setListRange($_GET['Base'], 25);
	$report->allowLink(ALLOW_HOVER_INDEX,'',array());
	
	//Default sorting
	if(!$_GET['Sort'])
	{
		$report->allowSort(true, 'name', 'ASC', 'guilds.php?mode=view');
	}
	else
	{
		$report->allowSort(true, $_GET['Sort'], $_GET['SortDescending'], 'guilds.php?mode=view');
	}
	
	if($phpraid_config['show_id'] == 1)
		$report->addOutputColumn('id',$phprlang['id'],'','left');
	$report->addOutputColumn('name',$phprlang['guild_name'],'','center');
	$report->addOutputColumn('short',$phprlang['guild_tag'],'','center');
	$report->addOutputColumn('master',$phprlang['guild_master'],'','center');
	$report->addOutputColumn('','','','right');
	$loc = $report->getListFromArray($loc);
	
	$page->set_file(array(
		'output' => $phpraid_config['template'] . '/guilds.htm')
	);
	
	$page->set_var('guilds',$loc);
	$page->set_var('header',$phprlang['guilds_header']);
	
	$page->parse('output','output');
} elseif($_GET['mode'] == 'new' || $_GET['mode'] == 'edit') {
	// slashes
	$name = $_POST['name'];
	$short = $_POST['short'];
	$master = $_POST['master'];
	
	if($_GET['mode'] == 'new') 	{
		$sql = sprintf("INSERT INTO " . $phpraid_config['db_prefix'] . "guilds (`guild_master`,`guild_name`,`guild_tag`) 
		VALUES (%s,%s,%s)",quote_smart($master),quote_smart($name),quote_smart($short));
		
		$db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
		
		log_create('guild',mysql_insert_id(),$name);
	} elseif($_GET['mode'] == 'edit') {
		$id = $_GET['id'];
		
		$sql = sprintf("UPDATE " . $phpraid_config['db_prefix'] . "guilds SET guild_name=%s,guild_tag=%s,guild_master=%s WHERE guild_id=%s",quote_smart($name),quote_smart($short),quote_smart($master),quote_smart($id));
		$db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
	}
	
	header("Location: guilds.php?mode=view");
} elseif($_GET['mode'] == 'delete') {
	$id = $_GET['id'];
	$n = $_GET['n'];
	
	if($_SESSION['priv_guilds'] == 1) {
		if(!isset($_POST['submit'])) {			
			$form_action = 'guilds.php?mode=delete&n='.$n.'&id=' . $id;
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
			log_delete('guild',$n);
			
			$sql = sprintf("DELETE FROM " . $phpraid_config['db_prefix'] . "guilds WHERE guild_id=%s",quote_smart($id));
			$db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
			
			header("Location: guilds.php?mode=view");
		}
	} else {
		if($_SESSION['priv_guilds'] == 1)
			header("Location: guilds.php?mode=view");
		else
			header("Location: index.php");
	}
}

if($_GET['mode'] != 'delete') {
	if($_GET['mode'] == 'view') {
		// setup new form information
		$form_action = 'guilds.php?mode=new';
		$name = '<input name="name" type="text" id="name" class="post">';
		$short = '<input name="short" type="text" id="short" class="post">';
		$master = '<input name="master" type="text" id="short" class="post">';
		
		$buttons = '<input type="submit" value="Submit" name="submit" class="mainoption"> <input type="reset" value="Reset" name="reset" class="liteoption">';
	} elseif($_GET['mode'] == 'update') {
		$id = $_GET['id'];
		
		$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "guilds WHERE guild_id=%s",quote_smart($id));
		$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
		$data = $db_raid->sql_fetchrow($result);
		
		// it's an edit... joy
		$form_action = "guilds.php?mode=edit&id=$id";
		$name = '<input name="name" type="text" id="name" value="' . $data['guild_name'] . '" class="post">';
		$short = '<input name="short" type="text" id="short" value="' . $data['guild_tag'] . '" class="post">';
		$master = '<input name="master" type="text" id="short" value="' . $data['guild_master'] . '" class="post">';
		
		$buttons = '<input type="submit" value="Update" name="submit" class="mainoption"> <input type="reset" value="Reset" name="reset" class="liteoption">';			
	}
	
	$page->set_file('new_group',$phpraid_config['template'] . '/guilds_new.htm');
	$page->set_var(
		array(
			'form_action'=>$form_action,
			'name'=>$name,
			'short'=>$short,
			'master'=>$master,
			'buttons'=>$buttons,
			'newguild_header'=>$phprlang['guilds_new_header'],
			'name_text'=>$phprlang['guilds_name'],
			'short_text'=>$phprlang['guilds_tag'],
			'master_text'=>$phprlang['guilds_master']
		)
	);
	
	$page->parse('output','new_group',true);
}

//
// Start output of page
//
require_once('includes/page_header.php');

$page->p('output','output');

require_once('includes/page_footer.php');
?>