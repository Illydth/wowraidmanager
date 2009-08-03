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
// Set View_Name if Passed
if(isset($_GET['view_name']))
	$view_name = scrub_input($_GET['view_name']);

// Fill in the Class Dropdown
$sql = "SELECT DISTINCT view_name FROM " . $phpraid_config['db_prefix'] . "column_headers";
$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);			
while($view_data = $db_raid->sql_fetchrow($result, true))
{
	$view_options .= "<option ";
	if($view_name == $view_data['view_name'])
		$view_options .= "SELECTED ";
	$view_options .= "value=\"admin_datatablecfg.php?mode=select&amp;view_name=" . $view_data['view_name'] . "\">" . $view_data['view_name']."</option>";
}

$view_select = '<select name="view_name" onChange="MM_jumpMenu(\'parent\',this,0)" class="form" style="width:100px">';
$view_select .= '<option value="admin_datatablecfg.php?mode=view">'.$phprlang['form_select'].'</option>' . $view_options . '</select>';

$form_action = 'admin_datatablecfg.php?mode=select';

$wrmadminsmarty->assign('header_data', 
	array(
		'datatable_header' => $phprlang['configuration_datatable_header'],
		'view_select_text' => $phprlang['configuration_datatable_view_select_text'],
		'view_select' => $view_select,
		'form_action' => $form_action,
	)
); 

if($_GET['mode'] == 'edit')
{
	$view_name = scrub_input($_GET['view_name']);
	
	$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "column_headers 
					WHERE view_name = %s", quote_smart($view_name));
	$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
	while($view_data = $db_raid->sql_fetchrow($result, true))
	{
		$column_name_real = $view_data['column_name'];
		$column_name = str_replace(' ', '_', $view_data['column_name']);
		$visible = scrub_input($_POST[$column_name . '_visible']);
		$position = scrub_input($_POST[$column_name . '_position_id']);
		$image_url = scrub_input($_POST[$column_name . '_image_url']);
		$default_sort = scrub_input($_POST[$column_name . '_default_sort']);

		$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."column_headers` 
					SET `visible` = %d, `position` =  %d, `img_url` = %s, `default_sort` = %d
					WHERE `view_name`= %s AND `column_name` = %s;", $visible, 
					$position, quote_smart($image_url), $default_sort,
					quote_smart($view_name), quote_smart($column_name_real));
		$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	}
	
	header("Location: admin_datatablecfg.php?mode=select&view_name=" . $view_name);
}

if($_GET['mode'] == 'select')
{
	$viewdata = array();
	$view_name = scrub_input($_GET['view_name']);
	
	//Get number of columns in view to determine position and view data.
	$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "column_headers WHERE view_name = %s", quote_smart($view_name));
	$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
	$numrows = $db_raid->sql_numrows($result);

	while($view_data = $db_raid->sql_fetchrow($result, true))
	{
		// Create the Column Name Box
		$column_name_data = str_replace(' ', '_', $view_data['column_name']);
		$column_name = '<input name="' . $column_name_data . '_column_name" size="60" type="text" class="post" value="' . $view_data['column_name'] . '" DISABLED>';
		
		//Create the Position Dropdown.
		$column_position = '<select name="' . $column_name_data . '_position_id">';
		for($x=1; $x<=$numrows; $x++)
		{
			$column_position .= "<option ";
			if($x == $view_data['position'])
				$column_position .= "SELECTED ";
			$column_position .= "value=\"" . $x . "\">" . $x ."</option>";
		}
		$column_position .= '</select>';
				
		// Create the Visible Checkbox
		if($view_data['visible'] == '1')
			$visible = '<input type="checkbox" name="' . $column_name_data . '_visible" value="1" checked>';
		else
			$visible = '<input type="checkbox" name="' . $column_name_data . '_visible" value="1">';
		
		// Create the Image URL Text Box.
		$image_url = '<input name="' . $column_name_data . '_image_url" size="60" type="text" class="post" value="' . $view_data['img_url'] . '">';
			
		// Create the Default Sort Checkbox.
		if($view_data['default_sort'] == '1')
			$default_sort = '<input type="checkbox" name="' . $column_name_data . '_default_sort" value="1" checked>';
		else
			$default_sort = '<input type="checkbox" name="' . $column_name_data . '_default_sort" value="1">';
		
		array_push($viewdata,
			array(
				'column_name' => $column_name, //Static
				'visible' => $visible, //Editable - Check Box 
				'position' => $column_position, //Editable - Drop Down	
				'image_url' => $image_url, //Editable - Text
				'default_sort' => $default_sort, //Editable - Check Box
				//'Buttons'=>'<a href="admin_datatablecfg.php?mode=view"><img src="../templates/' . $phpraid_config['template'] . '/images/icons/icon_delete.gif" border="0" onMouseover="ddrivetip(\''. $phprlang['delete'] .'\');" onMouseout="hideddrivetip();" alt="delete icon"></a>
				//	 <a href="admin_datatablecfg.php?mode=view"><img src="../templates/' . $phpraid_config['template'] . '/images/icons/icon_edit.gif" border="0" onMouseover="ddrivetip(\'' . $phprlang['edit'] .'\');" onMouseout="hideddrivetip();" alt="edit icon"></a>'				
			)
		);
	}
	$buttons = '<input type="submit" name="submit" value="'.$phprlang['submit'].'" class="mainoption"> <input type="reset" name="Reset" value="'.$phprlang['reset'].'" class="liteoption">';
	$form_action = 'admin_datatablecfg.php?mode=edit&amp;view_name='.$view_name;
	
	$wrmadminsmarty->assign('view_data', $viewdata);
	$wrmadminsmarty->assign('edit_data', 
		array(
			'edit_header' => $phprlang['configuration_datatable_edit_header'],
			'column_name_header' => $phprlang['configuration_datatable_column_name'],
			'visible_header' => $phprlang['configuration_datatable_visible'],
			'position_header' => $phprlang['configuration_datatable_position'],
			'image_url_header' => $phprlang['configuration_datatable_image_url'],
			'default_sort_header' => $phprlang['configuration_datatable_default_sort'], 
			'form_action' => $form_action,
			'buttons' => $buttons,
		)
	); 
}


//
// Start output of the page.
//
require_once('./includes/admin_page_header.php');
$wrmadminsmarty->display('admin_data_table_config.html');
require_once('./includes/admin_page_footer.php');

?>