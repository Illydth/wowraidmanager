<?php
/***************************************************************************
 *                              admin_logs.php
 *                            -------------------
 *   begin                : Wednesday, May 13, 2005
 *   copyright            : (C) 2007-2009 Douglas Wagner
 *   email                : douglasw@wagnerweb.org
 *
 ***************************************************************************/

/***************************************************************************
*
*    WoW Raid Manager - Raid Management Software for World of Warcraft
*    Copyright (C) 2007-2009 Douglas Wagner
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
require_once('./admin_common.php');

// page authentication
define("PAGE_LVL","configuration");
require_once("../includes/authentication.php");	

$server = $phpraid_config['guild_server'];

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
		$form_action = "admin_logs.php?mode=delete&amp;section=$section";
		$confirm_button = '<input name="submit" type="submit" id="submit" value="'.$phprlang['confirm_deletion'].'" class="mainoption">';

		$wrmadminsmarty->assign('page',
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
		require_once('includes/admin_page_header.php');
		$wrmadminsmarty->display('../delete.html');
		require_once('includes/admin_page_footer.php');	
	}
	else
	{
		$table = $phpraid_config['db_prefix'] . substr(quote_smart($logtype), 1, strlen(quote_smart($logtype)) - 2);
		$sql = "TRUNCATE TABLE " . $table;
		$db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
		header("Location: admin_logs.php");
	}
}
else
{
	// setup page sorting first
	// get checked status and sorting information
	if(!isset($_POST['submit']))
	{
		$c_check = 'checked';
		$d_check = 'checked';
		$h_check = 'checked';
		$r_check = 'checked';

		$d_select = 'selected';
		$de_select = 'selected';

		$f1_select = 'selected';
	}
	else
	{
		// Create the Sort/Filter Area above.
		$_POST['c'] ? $c_check = 'checked' : $c_check = '';
		$_POST['d'] ? $d_check = 'checked' : $d_check = '';
		$_POST['h'] ? $h_check = 'checked' : $h_check = '';
		$_POST['r'] ? $r_check = 'checked' : $r_check = '';

		$_POST['sort_name'] == $phprlang['log_date'] ? $d_select = 'selected' : $d_select = '';
		$_POST['sort_name'] == $phprlang['log_id'] ? $i_select = 'selected' : $i_select = '';
		$_POST['sort_name'] == $phprlang['log_type'] ? $t_select = 'selected' : $t_select = '';

		$_POST['order'] == $phprlang['asc'] ? $a_select = 'selected' : $a_select = '';
		$_POST['order'] == $phprlang['desc'] ? $de_select = 'selected' : $de_select = '';

		$_POST['filter'] == $phprlang['log_filter_all'] ? $fa_select = 'selected' : $fa_select = '';
		$_POST['filter'] == $phprlang['log_filter_2_months'] ? $f60_select = 'selected' : $f60_select = '';
		$_POST['filter'] == $phprlang['log_filter_1_month'] ? $f30_select = 'selected' : $f30_select = '';
		$_POST['filter'] == $phprlang['log_filter_1_week'] ? $f7_select = 'selected' : $f7_select = '';
		$_POST['filter'] == $phprlang['log_filter_1_day'] ? $f1_select = 'selected' : $f1_select = '';
	}

	$sort_by_select = '<select name="sort_name" class="post">
						  <option value="'.$phprlang['log_date'].'" '.$d_select.'>'.$phprlang['log_date'].'</option>
						  <option value="'.$phprlang['log_id'].'" '.$i_select.'>'.$phprlang['log_id'].'</option>
						  <option value="'.$phprlang['log_type'].'" '.$t_select.'>'.$phprlang['log_type'].'</option>
					  </select>';

	$sort_order_select = '<select name="order" class="post">
						  <option value="'.$phprlang['asc'].'" '.$a_select.'>'.$phprlang['asc'].'</option>
						  <option value="'.$phprlang['desc'].'" '.$de_select.'>'.$phprlang['desc'].'</option>
					  </select>';

	$c_checkbox = '<input type="checkbox" name="c" '.$c_check.'>'.$phprlang['log_create_text'];
	$d_checkbox = '<input type="checkbox" name="d" '.$d_check.'>'.$phprlang['log_delete_text'];
	$h_checkbox = '<input type="checkbox" name="h" '.$h_check.'>'.$phprlang['log_hack_text'];
	$r_checkbox = '<input type="checkbox" name="r" '.$r_check.'>'.$phprlang['log_raid_text'];
	
	$sort_time_filter_select = '<select name="filter" class="post">
						  <option value="'.$phprlang['log_filter_all'].'" '.$fa_select.'>'.$phprlang['log_filter_all'].'</option>
						  <option value="'.$phprlang['log_filter_2_months'].'" '.$f60_select.'>'.$phprlang['log_filter_2_months'].'</option>
						  <option value="'.$phprlang['log_filter_1_month'].'" '.$f30_select.'>'.$phprlang['log_filter_1_month'].'</option>
						  <option value="'.$phprlang['log_filter_1_week'].'" '.$f7_select.'>'.$phprlang['log_filter_1_week'].'</option>
						  <option value="'.$phprlang['log_filter_1_day'].'" '.$f1_select.'>'.$phprlang['log_filter_1_day'].'</option>
					  </select>';

	$wrmadminsmarty->assign('sort',
		array(
			'sort_by'=>$phprlang['log_sort_by'],
			'sort_by_select'=>$sort_by_select,
			'log_in'=>$phprlang['log_in'],
			'sort_order_select'=>$sort_order_select,
			'log_order'=>$phprlang['log_order'],
			'c_checkbox'=>$c_checkbox,
			'd_checkbox'=>$d_checkbox,
			'h_checkbox'=>$h_checkbox,
			'r_checkbox'=>$r_checkbox,
			'log_filter_show'=>$phprlang['log_filter_show'],
			'sort_time_filter_select'=>$sort_time_filter_select,
			'filter_text'=>$phprlang['filter'],
			'reset_text'=>$phprlang['reset'],
		)
	);
	
	$wrmadminsmarty->assign('log_sort_header', $phprlang['log_sort_header']);
	// End Sort/Filter Creation, Now display logs.
	
	$sql_where = '';

	if($f60_select == 'selected')
	{
		$sql_where = 'WHERE timestamp >= ' . quote_smart(time() - 60 * 86400);
	}
	else if($f30_select == 'selected')
	{
		$sql_where = 'WHERE timestamp >= ' . quote_smart(time() - 30 * 86400);
	}
	else if($f7_select == 'selected')
	{
		$sql_where = 'WHERE timestamp >= ' . quote_smart(time() - 7 * 86400);
	}
	else if($f1_select == 'selected')
	{
		$sql_where = 'WHERE timestamp >= ' . quote_smart(time() - 1 * 86400);
	}

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
	$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "logs_create $sql_where $sql_order $sql_order2";
	$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);

	$create = array();
	
	while($data = $db_raid->sql_fetchrow($result, true))
	{
		$date = new_date($phpraid_config['date_format'],$data['timestamp'],$phpraid_config['timezone'] + $phpraid_config['dst']);
		$time = new_date($phpraid_config['time_format'],$data['timestamp'],$phpraid_config['timezone'] + $phpraid_config['dst']);

		$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "profile WHERE profile_id=%s", quote_smart($data['profile_id']));
		$data_result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
		$data_profdetail = $db_raid->sql_fetchrow($data_result);

		array_push($create, sprintf($phprlang['log_create'],$date,$time,$data['profile_id'],$data_profdetail['username'],$data['ip'],$data['type'],$data['create_id'],scrub_input($data['create_name'])));
	}

	// deletion logs
	$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "logs_delete $sql_where $sql_order $sql_order2";
	$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);

	$delete = array();
	
	while($data = $db_raid->sql_fetchrow($result, true))
	{
		$date = new_date($phpraid_config['date_format'],$data['timestamp'],$phpraid_config['timezone'] + $phpraid_config['dst']);
		$time = new_date($phpraid_config['time_format'],$data['timestamp'],$phpraid_config['timezone'] + $phpraid_config['dst']);

		$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "profile WHERE profile_id=%s", quote_smart($data['profile_id']));
		$data_result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
		$data_profdetail = $db_raid->sql_fetchrow($data_result);

		array_push($delete, sprintf($phprlang['log_delete'],$date,$time,$data['profile_id'],$data_profdetail['username'],$data['ip'],$data['type'],scrub_input($data['delete_name'])));
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

	$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "logs_hack $sql_where $sql_order_hack $sql_order2_hack";
	$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);

	$hack = array();
	
	while($data = $db_raid->sql_fetchrow($result, true))
	{
		$date = new_date($phpraid_config['date_format'],$data['timestamp'],$phpraid_config['timezone'] + $phpraid_config['dst']);
		$time = new_date($phpraid_config['time_format'],$data['timestamp'],$phpraid_config['timezone'] + $phpraid_config['dst']);

		array_push($hack, sprintf($phprlang['log_hack'],$date,$time,$data['ip'],scrub_input($data['message'])));
	}

	// raid logs
	$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "logs_raid $sql_where $sql_order $sql_order2";
	$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);

	$raid = array();
	
	while($data = $db_raid->sql_fetchrow($result, true))
	{
		$date = new_date($phpraid_config['date_format'],$data['timestamp'],$phpraid_config['timezone'] + $phpraid_config['dst']);
		$time = new_date($phpraid_config['time_format'],$data['timestamp'],$phpraid_config['timezone'] + $phpraid_config['dst']);

		//array_push($raid, sprintf($phprlang['log_create'],$date,$time,$data['profile_id'],$data['ip'],$data['raid_id'],$data['type'],$data['char_id']));
		$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "chars WHERE char_id=%s",quote_smart($data['char_id']));
		$data_result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
		$data_userdetail = $db_raid->sql_fetchrow($data_result);

		$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "raids WHERE raid_id=%s", quote_smart($data['raid_id']));
		$data_result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
		$data_raiddetail = $db_raid->sql_fetchrow($data_result);

		$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "profile WHERE profile_id=%s", quote_smart($data['profile_id']));
		$data_result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
		$data_profdetail = $db_raid->sql_fetchrow($data_result);

		$raiddatum = new_date($phpraid_config['date_format'],$data_raiddetail['start_time'],$phpraid_config['timezone'] + $phpraid_config['dst']);

		array_push($raid, sprintf($phprlang['log_raid'],$date,$time,$data['profile_id'],$data_profdetail['username'],$data['ip'],$data['raid_id'],
			$raiddatum,$data_raiddetail['location'],$data['type'],$data['char_id'],get_armorychar($data_userdetail['name'],$phpraid_config['armory_language'],$server)));

	}

	if($c_check == 'checked')
	{
		$create_output = '<div class="contentHeader">'.$phprlang['log_create_header'].'';
		$create_output .= '&nbsp;&nbsp;<a href="admin_logs.php?mode=delete&amp;section=1"><img src="templates/' .
					$phpraid_config['template'] . '/images/icons/icon_delete.gif" border="0" onMouseover="ddrivetip(\''.$phprlang['delete'].'\');"
					onMouseout="hideddrivetip();" alt="delete icon"></a>
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
		$delete_output .= '&nbsp;&nbsp;<a href="admin_logs.php?mode=delete&amp;section=2"><img src="templates/' .
					$phpraid_config['template'] . '/images/icons/icon_delete.gif" border="0" onMouseover="ddrivetip(\''.$phprlang['delete'].'\');"
					onMouseout="hideddrivetip();" alt="delete icon"></a>
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
		$hack_output .= '&nbsp;&nbsp;<a href="admin_logs.php?mode=delete&amp;section=3"><img src="templates/' .
					$phpraid_config['template'] . '/images/icons/icon_delete.gif" border="0" onMouseover="ddrivetip(\''.$phprlang['delete'].'\');"
					onMouseout="hideddrivetip();" alt="delete icon"></a>
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
		$raid_output .= '&nbsp;&nbsp;<a href="admin_logs.php?mode=delete&amp;section=4"><img src="templates/' .
					$phpraid_config['template'] . '/images/icons/icon_delete.gif" border="0" onMouseover="ddrivetip(\''.$phprlang['delete'].'\');"
					onMouseout="hideddrivetip();" alt="delete icon"></a>
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
	require_once('includes/admin_page_header.php');

	$wrmadminsmarty->assign('logs',
		array(
			'create' => $create_output,
			'delete'=>$delete_output,
			'hack'=>$hack_output,
			'raid'=>$raid_output,
			'header' => $phprlang['log_header']
		)
	);

	$wrmadminsmarty->display('admin_logs.html');
	
	require_once('includes/admin_page_footer.php');
}
?>