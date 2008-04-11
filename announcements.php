<?php
/***************************************************************************
 *                             announcements.php
 *                            -------------------
 *   begin                : Saturday, Jan 16, 2005
 *   copyright            : (C) 2007-2008 Douglas Wagner
 *   email                : douglasw@wagnerweb.org
 *
 *   $Id: announcements.php,v 2.00 2007/11/18 13:08:36 psotfx Exp $
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
define("PAGE_LVL","announcements");
require_once("includes/authentication.php");

if($_GET['mode'] == 'view')
{
	$announcements = array();
	$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "announcements";
	$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
	while($data = $db_raid->sql_fetchrow($result))
	{
		$id = $data['announcements_id'];
		$title = $data['title'];
		$message = $data['message'];

		if(strlen($title) > 30)
			$title = substr($title, 0, 30) . '...';

		if(strlen($message) > 30)
			$message = substr($message, 0, 30) . '...';

		$posted_by = $data['posted_by'];
		$date = new_date($phpraid_config['date_format'],$data['timestamp'],$phpraid_config['timezone'] + $phpraid_config['dst']);
		$time = new_date($phpraid_config['time_format'],$data['timestamp'],$phpraid_config['timezone'] + $phpraid_config['dst']);

		$edit = '<a href="announcements.php?mode=edit&id='.$data['announcements_id'].'"><img src="templates/' . $phpraid_config['template'] .
				'/images/icons/icon_edit.gif" border="0" onMouseover="ddrivetip(\'' . $phprlang['edit'] . '\')"; onMouseout="hideddrivetip()"></a> ';

		$delete = '<a href="announcements.php?mode=delete&n='.$data['title'].'&id='.$data['announcements_id'].'"><img src="templates/' .
					$phpraid_config['template'] . '/images/icons/icon_delete.gif" border="0" onMouseover="ddrivetip(\'' . $phprlang['delete'] . '\')";
					onMouseout="hideddrivetip()"></a>';

		array_push($announcements,
			array(
				'id'=>$id,
				'title'=>$title,
				'message'=>$message,
				'posted_by'=>$posted_by,
				'date'=>$date,
				'time'=>$time,
				''=>$edit . $delete,
			)
		);
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
		$report->allowSort(true, 'date', 'ASC', 'announcements.php?mode=view');
	}
	else
	{
		$report->allowSort(true, $_GET['Sort'], $_GET['SortDescending'], 'announcements.php?mode=view');
	}

	if($phpraid_config['show_id'] == 1)
		$report->addOutputColumn('id',$phprlang['id'],'','center');
	$report->addOutputColumn('title',$phprlang['title'],'','center');
	$report->addOutputColumn('message',$phprlang['message'],'','center');
	$report->addOutputColumn('posted_by',$phprlang['posted_by'],'','center');
	$report->addOutputColumn('date',$phprlang['date'],'','center');
	$report->addOutputColumn('time',$phprlang['time'],'','center');
	$report->addOutputColumn('','','','right');
	$announcements = $report->getListFromArray($announcements);
	$page->set_file('output',$phpraid_config['template'] . '/announcements.htm');
	$page->set_var(
		array(
			'header'=>$phprlang['announcements_header'],
			'announcements'=>$announcements
		)
	);
	$page->parse('output','output');
}
elseif($_GET['mode'] == 'delete')
{
	$id = scrub_input($_GET['id'], false);
	$delete_name = scrub_input($_GET['n'], false);

	if($_SESSION['priv_announcements'] == 1) {
		if(!isset($_POST['submit'])) {
			$form_action = 'announcements.php?mode=delete&n='.$delete_name.'&id=' . $id;
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
			log_delete('announcement',$delete_name);

			$sql = sprintf("DELETE FROM " . $phpraid_config['db_prefix'] . "announcements WHERE announcements_id=%s", quote_smart($id));
			$db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);

			header("Location: announcements.php?mode=view");
		}
	} else {
		if($_SESSION['priv_announcements'] == 1)
			header("Location: announcements.php?mode=view");
		else
		{
			//@@ Pop up an error explaning the user doesn't have privlidges to do that.
			header("Location: index.php");
		}
	}
}
elseif(($_GET['mode'] == 'new' || $_GET['mode'] = 'edit') && isset($_POST['submit']))
{
	// just grab the values they posted
	$title = scrub_input($_POST['title'], true);
	$message = scrub_input($_POST['message'], true);
	$timestamp = time();
	$posted_by = $_SESSION['username'];
	if($_GET['mode'] == 'new')
	{

		$sql = sprintf("INSERT INTO " . $phpraid_config['db_prefix'] . "announcements (`title`,`message`,`timestamp`,`posted_by`)
		VALUES (%s,%s,%s,%s)", quote_smart($title),quote_smart($message),quote_smart($timestamp),quote_smart($posted_by));

		$db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);

		log_create('announcement',mysql_insert_id(),$title);
	}
	elseif($_GET['mode'] == 'edit')
	{
		$id = scrub_input($_GET['id']);
		$sql = sprintf("UPDATE " . $phpraid_config['db_prefix'] . "announcements SET title=%s,message=%s WHERE announcements_id=%s",quote_smart($title),quote_smart($message),quote_smart($id));
		$db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
	}
	header("Location: announcements.php?mode=view");
}

// and the form
if($_GET['mode'] != 'delete')
{
	if($_GET['mode'] == 'edit')
	{
		// grab from DB
		$id = scrub_input($_GET['id']);

		$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "announcements WHERE announcements_id=%s",quote_smart($id));
		$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
		$data = $db_raid->sql_fetchrow($result);

		$form_action = 'announcements.php?mode=edit&id=' . $id;
		$title = '<input type="text" size="69" name="title" class="post" value="' . $data['title'] . '">';
 		$message = '<textarea name="message" class="post" cols="57" rows="10">' . $data['message'] . '</textarea>';
		$buttons = '<input type="submit" name="submit" value="Update" class="mainoption"> <input type="reset" name="reset" value="Reset" class="liteoption">';
	}
	else
	{
		$form_action = 'announcements.php?mode=new';
		$title = '<input type="text" size="69" name="title" class="post">';
		$message = '<textarea name="message" class="post" cols="57" rows="10"></textarea>';
		$buttons = '<input type="submit" name="submit" value="Submit" class="mainoption"> <input type="reset" name="reset" value="Reset" class="liteoption">';
	}

	// set variables
	$page->set_file('new_file',$phpraid_config['template'] . '/announcements_new.htm');
	$page->set_var(
		array(
			'form_action'=>$form_action,
			'title'=>$title,
			'title_text'=>$phprlang['announcements_title_text'],
			'message_text'=>$phprlang['announcements_message_text'],
			'header'=>$phprlang['announcements_new_header'],
			'message'=>$message,
			'buttons'=>$buttons,
		)
	);

	$page->parse('output','new_file',true);
}

//
// Start output of page
//
require_once('includes/page_header.php');

$page->p('output');

require_once('includes/page_footer.php');
?>
