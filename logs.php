<?php
/***************************************************************************
 *                              logs.php
 *                            -------------------
 *   begin                : Saturday, Jan 16, 2005
 *   copyright            : (C) 2007-2008 Douglas Wagner
 *   email                : douglasw@wagnerweb.org
 *
 *   $Id: logs.php,v 2.00 2008/03/07 17:05:18 psotfx Exp $
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
define("PAGE_LVL","logs");
require_once("includes/authentication.php");

if($_GET['mode'] == 'delete')
{
	$section = scrub_input($_GET['section']);

	if($section == "1")
	{
		$logtype = "logs_create";
	}
	elseif($section == "2")
	{
		$logtype = "logs_delete";
	}
	elseif($section == "3")
	{
		$logtype = "logs_hack";
	}
	else
	{
		$logtype = "logs_raid";
	}

	if(!isset($_POST['submit']))
	{
		$form_action = "logs.php?mode=delete&section=$section";
		$confirm_button = '<input name="submit" type="submit" id="submit" value="Confirm Deletion" class="mainoption">';

		$page->set_file('output',$phpraid_config['template'] . '/delete.htm');
		$page->set_var(
			array(
				'form_action'=>$form_action,
				'confirm_button'=>$confirm_button,
				'delete_header'=>$phprlang['delete_header'],
				'delete_msg'=>$phprlang['delete_msg'],
			)
		);
		require_once('includes/page_header.php');
		$page->pparse('output','output');
		require_once('includes/page_footer.php');
	}
	else
	{
		$table = $phpraid_config['db_prefix'] . substr(quote_smart($logtype), 1, strlen(quote_smart($logtype)) - 2);
		$sql = printf("TRUNCATE TABLE " . $phpraid_config['db_prefix'] . $logtype);
		$db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
		header("Location: logs.php");
	}
}
else
{
	// setup page sorting first
	$page->set_file('sort_file',$phpraid_config['template'].'/logs_sort.htm');

	// get checked status and sorting information
	if(!isset($_POST['submit']))
	{
		$c_check = 'checked';
		$d_check = 'checked';
		$h_check = 'checked';
		$r_check = 'checked';
		
		$s_default = 'date';
		$s_order = 'ascending';
	}
	else
	{
		$_POST['c'] ? $c_check = 'checked' : $c_check = '';
		$_POST['d'] ? $d_check = 'checked' : $d_check = '';
		$_POST['h'] ? $h_check = 'checked' : $h_check = '';
		$_POST['r'] ? $r_check = 'checked' : $r_check = '';

		$_POST['sort_name'] == $phprlang['log_date'] ? $d_select = 'selected' : $d_select = '';
		$_POST['sort_name'] == $phprlang['log_id'] ? $i_select = 'selected' : $i_select = '';
		$_POST['sort_name'] == $phprlang['log_type'] ? $t_select = 'selected' : $t_select = '';

		$_POST['order'] == $phprlang['asc'] ? $a_select = 'selected' : $a_select = '';
		$_POST['order'] == $phprlang['desc'] ? $de_select = 'selected' : $de_select = '';
	}

	$sort = '<form action="logs.php?mode=view" method="POST">
			<table width="450" border="0" cellspacing="0" cellpadding="0">
			  <tr>
				<td scope="col"><div align="center">'.$phprlang['log_sort_by'].'
					  <select name="sort_name" class="post" class="post">
						  <option value="'.$phprlang['log_date'].'" '.$d_select.'>'.$phprlang['log_date'].'</option>
						  <option value="'.$phprlang['log_id'].'" '.$i_select.'>'.$phprlang['log_id'].'</option>
						  <option value="'.$phprlang['log_type'].'" '.$t_select.'>'.$phprlang['log_type'].'</option>
					  </select>
					  '.$phprlang['log_in'].'
					  <select name="order" class="post" class="post">
						  <option value="'.$phprlang['asc'].'" '.$a_select.'>'.$phprlang['asc'].'</option>
						  <option value="'.$phprlang['desc'].'" '.$de_select.'>'.$phprlang['desc'].'</option>
					  </select>
					'.$phprlang['log_order'].'</div></td>
			  </tr>
			  <tr>
				<td><div align="center">
					  <input type="checkbox" name="c" '.$c_check.'>
					  '.$phprlang['log_create_text'].'
					  <input type="checkbox" name="d" '.$d_check.'>
					  '.$phprlang['log_delete_text'].'
					  <input type="checkbox" name="h" '.$h_check.'>
					  '.$phprlang['log_hack_text'].'
					  <input type="checkbox" name="r" '.$r_check.'>
					  '.$phprlang['log_raid_text'].'
				  </div></td>
			  </tr>
			  <tr>
				<td><br><div align="center"><input type="submit" value="Filter" name="submit" class="mainoption"> <input type="reset" value="Reset" name="reset" class="liteoption"></div></td>
			  </tr>
			</table>
			</form>
			';

	$page->set_var('sort',$sort);
	$page->set_var('log_sort_header',$phprlang['log_sort_header']);
	$page->parse('output','sort_file');
	
	$sql_order = '';

	if($d_select == 'selected')
	{
		$sql_order = 'ORDER BY timestamp';
	}
	else if($i_select == 'selected')
	{
		$sql_order = 'ORDER BY log_id';
	}
	else if($t_select == 'selected')
	{
		$sql_order = 'ORDER BY type';
	}

	if($a_select == 'selected')
	{
		$sql_order2 .= 'ASC';
	}
	else if($de_select == 'selected')
	{
		$sql_order2 .= 'DESC';
	}

	// creation logs
	$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "logs_create $sql_order $sql_order2";
	$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);

	$create = array();
	
	while($data = $db_raid->sql_fetchrow($result, true))
	{
		$date = new_date($phpraid_config['date_format'],$data['timestamp'],$phpraid_config['timezone'] + $phpraid_config['dst']);
		$time = new_date($phpraid_config['time_format'],$data['timestamp'],$phpraid_config['timezone'] + $phpraid_config['dst']);
		
		array_push($create, sprintf($phprlang['log_create'],$date,$time,$data['profile_id'],$data['ip'],$data['type'],$data['create_id'],$data['create_name']));
	}

	// deletion logs
	$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "logs_delete $sql_order $sql_order2";
	$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);

	$delete = array();
	
	while($data = $db_raid->sql_fetchrow($result, true))
	{
		$date = new_date($phpraid_config['date_format'],$data['timestamp'],$phpraid_config['timezone'] + $phpraid_config['dst']);
		$time = new_date($phpraid_config['time_format'],$data['timestamp'],$phpraid_config['timezone'] + $phpraid_config['dst']);
		
		array_push($delete, sprintf($phprlang['log_delete'],$date,$time,$data['profile_id'],$data['ip'],$data['type'],$data['delete_name']));
	}

	// hack logs
	if($sql_order == "ORDER BY type")
	{
		$sql_order_hack = '';
		$sql_order2 = '';
	}
	else
	{
		$sql_order_hack = $sql_order;
		$sql_order2_hack = $sql_order2;
	}
	
	$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "logs_hack $sql_order_hack $sql_order2_hack";
	$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);

	$hack = array();
	
	while($data = $db_raid->sql_fetchrow($result, true))
	{
		$date = new_date($phpraid_config['date_format'],$data['timestamp'],$phpraid_config['timezone'] + $phpraid_config['dst']);
		$time = new_date($phpraid_config['time_format'],$data['timestamp'],$phpraid_config['timezone'] + $phpraid_config['dst']);

		array_push($hack, sprintf($phprlang['log_hack'],$date,$time,$data['ip'],$data['message']));
	}

	// raid logs
	$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "logs_raid $sql_order $sql_order2";
	$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);

	$raid = array();
	
	while($data = $db_raid->sql_fetchrow($result, true))
	{
		$date = new_date($phpraid_config['date_format'],$data['timestamp'],$phpraid_config['timezone'] + $phpraid_config['dst']);
		$time = new_date($phpraid_config['time_format'],$data['timestamp'],$phpraid_config['timezone'] + $phpraid_config['dst']);
		
		array_push($raid, sprintf($phprlang['log_create'],$date,$time,$data['profile_id'],$data['ip'],$data['raid_id'],$data['type'],$data['char_id']));
	}

	if($c_check == 'checked')
	{
		$create_output = '<div class="contentHeader">'.$phprlang['log_create_header'].'';
		$create_output .= '&nbsp;&nbsp;<a href="logs.php?mode=delete&section=1"><img src="templates/' .
					$phpraid_config['template'] . '/images/icons/icon_delete.gif" border="0" onMouseover="ddrivetip(\''.$phprlang['delete'].'\')";
					onMouseout="hideddrivetip()"></a>
					';
		$create_output .= '</div><br>';

		foreach($create as $key=>$value)
		{
			$create_output .= '<div class="contentBody">'.$value.'</div>';
		}
		$create_output .= '<br>';
	}

	if($d_check == 'checked')
	{
		$delete_output = '<div class="contentHeader">'.$phprlang['log_delete_header'].'';
		$delete_output .= '&nbsp;&nbsp;<a href="logs.php?mode=delete&section=2"><img src="templates/' .
					$phpraid_config['template'] . '/images/icons/icon_delete.gif" border="0" onMouseover="ddrivetip(\''.$phprlang['delete'].'\')";
					onMouseout="hideddrivetip()"></a>
					';
		$delete_output .= '</div><br>';
		foreach($delete as $key=>$value)
		{
			$delete_output .= '<div class="contentBody">'.$value.'</div>';
		}
		$delete_output .= '<br>';
	}

	if($h_check == 'checked')
	{
		$hack_output = '<div class="contentHeader">'.$phprlang['log_hack_header'].'';
		$hack_output .= '&nbsp;&nbsp;<a href="logs.php?mode=delete&section=3"><img src="templates/' .
					$phpraid_config['template'] . '/images/icons/icon_delete.gif" border="0" onMouseover="ddrivetip(\''.$phprlang['delete'].'\')";
					onMouseout="hideddrivetip()"></a>
					';
		$hack_output .= '</div><br>';

		foreach($hack as $key=>$value)
		{
			$hack_output .= '<div class="contentBody">'.$value.'</div>';
		}

		$hack_output .= '<br>';
	}

	if($r_check == 'checked')
	{
		$raid_output = '<div class="contentHeader">'.$phprlang['log_raid_header'].'';
		$raid_output .= '&nbsp;&nbsp;<a href="logs.php?mode=delete&section=4"><img src="templates/' .
					$phpraid_config['template'] . '/images/icons/icon_delete.gif" border="0" onMouseover="ddrivetip(\''.$phprlang['delete'].'\')";
					onMouseout="hideddrivetip()"></a>
					';
		$raid_output .= '</div><br>';

		foreach($raid as $key=>$value)
		{
			$raid_output .= '<div class="contentBody">'.$value.'</div>';
		}

		$raid_output .= '<br>';
	}

	//
	// Start output of page
	//
	require_once('includes/page_header.php');

	$page->set_file(array(
		'log_file' => $phpraid_config['template'] . '/logs.htm')
	);

	$page->set_var(
		array(
			'create' => $create_output,
			'delete'=>$delete_output,
			'hack'=>$hack_output,
			'raid'=>$raid_output,
			'header' => $phprlang['log_header']
		)
	);
	$page->parse('output','log_file',true);
	$page->p('output');

	require_once('includes/page_footer.php');
}
?>