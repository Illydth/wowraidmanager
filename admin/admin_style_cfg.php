<?php
/***************************************************************************
 *                             admin_style_cfg.php
 *                            -------------------
 *   begin                : Dec 19, 2010
 *	 Dev                  : Carsten Hölbing
 *	 email                : carsten@hoelbing.net
 *
 *   -- WoW Raid Manager --
 *   copyright            : (C) 2007-2009 Douglas Wagner
 *   email                : douglasw0@yahoo.com
 *   www				  : http://www.wowraidmanager.net
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
/*
 * updated: 
 * version 4.3 ( Aug 29, 2012 carsten hoelbing)
 * increase usability (more option, show all available template in a list)
 */

// commons
define("IN_PHPRAID", true);	
require_once('./admin_common.php');

/*************************************************
 * Access Authorization Section
 *************************************************/
// page authentication
define("PAGE_LVL","configuration");
require_once("../includes/authentication.php");	

$page_url = "admin_style_cfg.php";
$html_table = '';
$table_pos = 0;

$template_setting = $wrmtemplate->load_current_template_settings();
$available_template_setting = $wrmtemplate->load_all_template_settings();

$selected_template_width = $phpraid_config['template_body_width'];
if ( (isset($template_setting['width_normal'])) AND (isset($template_setting['width_expanded'])) )
{
	$array_template_width = array();
	$array_template_width[$phprlang['configuration_width_normal']] = $template_setting['width_normal'];
	$array_template_width[$phprlang['configuration_width_expanded']] = $template_setting['width_expanded'];
}
else 
{
	$array_template_width = array();
	$array_template_width["n/a"] = "N/A";
}

if ( count($available_template_setting) > 0)
{
	$html_table .= '<div class="contentHeader">'.$phprlang['available_templates_text'].'</div>';
	$html_table .= '<br>';
	$html_table .= '<div class="contentBody">';
	$html_table .= '<table border = "0" width="100%">';
	foreach($available_template_setting as $template_setting_all )
	{
		if ($table_pos == 0) $html_table .= '	<tr>';

	$html_table .= '	<td width="33%">';
	$html_table .= '	<table class ="table_admin_templeallview">';
	$html_table .= '	  <tr>';
	$html_table .= '	    <th class="tablerow_Header_big">'.$phprlang['current_template_name_text'].'</th>';
	$html_table .= '	  </tr>';
	$html_table .= '	  <tr>';
	$html_table .= '	    <td class="row3">'.$template_setting_all['template_name'].'</td>';
	$html_table .= '	  </tr>';
	$html_table .= '	  <tr>';
	$html_table .= '	    <th class="tablerow_Header_big">'.$phprlang['current_template_created_by_text'].'</th>';
	$html_table .= '	  </tr>';
	$html_table .= '	  <tr>';
	$html_table .= '	    <td class="row3">'.$template_setting_all['template_author'].'</td>';
	$html_table .= '	  </tr>';
	$html_table .= '	  <tr>';
	$html_table .= '	    <th class="tablerow_Header_big">'.$phprlang['current_template_version_nr_text'].'</th>';
	$html_table .= '	  </tr>';
	$html_table .= '	  <tr>';
	$html_table .= '	    <td class="row3">'.$template_setting_all['template_version'].'</td>';
	$html_table .= '	  </tr>';
	$html_table .= '	  <tr>';
	$html_table .= '	  <tr>';
	$html_table .= '	    <th class="tablerow_Header_big">'.$phprlang['current_template_info_text'].'</th>';
	$html_table .= '	  </tr>';
	$html_table .= '	  <tr>';
	$html_table .= '	    <td class="row3">'.$template_setting_all['template_description'].'</td>';
	$html_table .= '	  </tr>';
	$html_table .= '	  <tr>';
	$html_table .= '	    <td class="tablerow_Header_big"><a href="'.$page_url.'?mode=active&template_name='.$template_setting_all['template_name'].'">'.$phprlang['active'].'</a></td>';
	$html_table .= '	  </tr>';
	$html_table .= '	  </table>';
	$html_table .= '	  </td>';
	$table_pos++;

	if ($table_pos == 3) 
	{
		$html_table .= '	</tr>';
		$table_pos = 0;
	}

	}
	$html_table .= '</table>';
}


$wrmadminsmarty->assign('config_data',
	array(
		'form_action'=> $page_url,
		'general_header' => $phprlang['general_configuration_header'],
		'template_cfg_header' => $phprlang['configuration_template_cfg_header'],

		'current_template_header_text' => $phprlang['current_template_header_text'],
			
		'current_template_name_text' => $phprlang['current_template_name_text'],
		'current_template_name_value' => $template_setting['template_name'],
		'current_template_created_by_text' => $phprlang['current_template_created_by_text'],
		'current_template_created_by_value' => $template_setting['template_author'],
		'current_template_version_nr_text' => $phprlang['current_template_version_nr_text'],
		'current_template_version_nr_value' => $template_setting['template_version'],
		'current_template_info_text' => $phprlang['current_template_info_text'],
		'current_template_info_value' => $template_setting['template_description'],
			
		'template_width_text' => $phprlang['configuration_template_width_text'],
		'array_template_width' => $array_template_width,
		'selected_template_width' => $selected_template_width,	
	
		'button_submit' => $phprlang['submit'],
		'button_reset' => $phprlang['reset'],
		'html_table' => $html_table
	)
);

if(isset($_POST['submit']))
{
	$template_width = scrub_input(DEUBB($_POST['template_width']));

	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'template_body_width';", quote_smart($template_width));
	$db_raid->sql_query($sql) or print_error($sql,$db_raid->sql_error(),1);


	header("Location: ".$page_url);
}

if (isset($_GET['mode']) AND ($_GET['mode'] == 'active') AND isset($_GET['template_name']))
{	
	$template_name = scrub_input(DEUBB($_GET['template_name']));

	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'template';", quote_smart($template_name));
	$db_raid->sql_query($sql) or print_error($sql,$db_raid->sql_error(),1);
	
	header("Location: ".$page_url);
}

//
// Start output of the page.
//
require_once('./includes/admin_page_header.php');
$wrmadminsmarty->display('admin_style_cfg.html');
require_once('./includes/admin_page_footer.php');

?>