<?php
/***************************************************************************
                                admin_index.php
 *                            -------------------
 *   begin                : Monday, May 11, 2009
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

/*************************************************
 * Access Authorization Section
 *************************************************/
// page authentication
define("PAGE_LVL","configuration");
require_once("../includes/authentication.php");	

/* 
 * Data for Index Page
 */
// Selection box for Raid View Type.
$raid_view_type = '<select name="raid_view_type" class="post">';
if ($phpraid_config['raid_view_type'] == 'by_class')
	$raid_view_type .=   '<option value="by_class" selected>' . $phprlang['configuration_raid_view_type_class'] . '</option>';
else
	$raid_view_type .=   '<option value="by_class">' . $phprlang['configuration_raid_view_type_class'] . '</option>';
if ($phpraid_config['raid_view_type'] == 'by_role')
	$raid_view_type .=   '<option value="by_role" selected>'. $phprlang['configuration_raid_view_type_role'] . '</option>';
else
	$raid_view_type .=   '<option value="by_role">' . $phprlang['configuration_raid_view_type_role'] . '</option>';
$raid_view_type .= '</select>';

$buttons = '<input type="submit" name="submit" value="'.$phprlang['submit'].'" class="mainoption"> <input type="reset" name="Reset" value="'.$phprlang['reset'].'" class="liteoption">';	

// Setup the Role Boxes based upon what's in the Role table.
$role_data = array();

$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "roles";
$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);

while($data = $db_raid->sql_fetchrow($result, true))
{
	$var = $data['role_id'] . "_name";
	$role_name = '<input name="'.$var.'" type="text" value="'.$data['role_name'].'" size="25" class="post">';
	$role_text = $phprlang[$data['lang_index']];
	
	array_push($role_data,
		array(
			'role_name' => $role_name,
			'role_text' => $role_text,
			)
		);
}

// Display Roles for Delete (create checkboxes)
$delete_data = array();

$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "roles";
$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);

while($data = $db_raid->sql_fetchrow($result, true))
{
	$var = $data['role_id'] . "_del";
	
	$role_delete = '<input name="'.$var.'" type="checkbox" value="'.$data['role_id'].'" class="post">';
	if ($data['role_name'] == '')
		$role_text = '&lt;Blank Role&gt;';
	else
		$role_text = $data['role_name'];
	
	array_push($delete_data,
		array(
			'role_delete_checkbox' => $role_delete,
			'role_text' => $role_text,
			)
		);
}

// Add Role Box
$role_add = '<input name="role_num" type="text" value="" size="5" class="post">';

$wrmadminsmarty->assign('role_data', $role_data);
$wrmadminsmarty->assign('delete_data', $delete_data);
$wrmadminsmarty->assign('config_data',
	array(
		'raid_view_type' => $raid_view_type,
		'raid_view_type_text' => $phprlang['configuration_raid_view_type_text'],
		'role_configure_header'=>$phprlang['configuration_role_header'],
		'role_delete_header' => $phprlang['role_delete_header'],
		'role_delete_text' => $phprlang['role_delete_text'],
		'role_add_header' => $phprlang['role_add_header'],
		'role_add_text' => $phprlang['role_add_text'],
		'role_add_box_text' => $phprlang['role_add_box_text'],
		'role_add_box' => $role_add,
		'buttons' => $buttons,
	)
);

if(isset($_POST['submit']))
{
	$raid_view_type = scrub_input($_POST['raid_view_type']);

	// Process Roles
	$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "roles";
	$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
	
	while($data = $db_raid->sql_fetchrow($result, true))
	{
		$var = $data['role_id'] . "_name";
		$$var = scrub_input($_POST[$var]);

		if ($data['role_name'] != $$var)
		{
			$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."roles` SET `role_name` = %s WHERE `role_id`= %s;", quote_smart($$var), quote_smart($data['role_id']));
			$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
		}
	}	
	
	// Process Delete Checkboxes
	$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "roles";
	$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
	
	while($data = $db_raid->sql_fetchrow($result, true))
	{
		$var = $data['role_id'] . "_del";
		$$var = scrub_input($_POST[$var]);
		//echo $var . " = " . $$var;
		if ($$var == $data['role_id'])
		{
			$sql=sprintf("DELETE FROM `".$phpraid_config['db_prefix']."roles` WHERE `role_id` = %s;", quote_smart($data['role_id']));
			$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
		}
	}	
	
	// Process the Add Role Box.
	$var = scrub_input($_POST['role_num']);
	if ($var != '')
	{
		$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "roles WHERE role_id = 'role".$var."'";
		$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
		$exists = $db_raid->sql_fetchrow($result, true);
		
		if ($exists['role_id'] != '')
			echo "Role Already Exists.";
		else 
		{
			$role_id_text = 'role' . $var;
			$lang_index_text = 'configuration_role' . $var . "_text";
			$sql = sprintf("INSERT INTO ". $phpraid_config['db_prefix'] . "roles VALUES (%s, '', %s, NULL)", quote_smart($role_id_text), quote_smart($lang_index_text));
			$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
		}
	}

	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'raid_view_type';", quote_smart($raid_view_type));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	
	header("Location: admin_rolecfg.php");
}
//
// Start output of the page.
//
require_once('./includes/admin_page_header.php');
$wrmadminsmarty->display('admin_role_config.html');
require_once('./includes/admin_page_footer.php');

?>