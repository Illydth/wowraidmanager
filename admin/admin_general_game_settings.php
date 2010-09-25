<?php
/***************************************************************************
                           admin_general_game_settings.php
 *                            -------------------
 *   begin                : Fr, Sep 25, 2010
 *	 Dev                  : Carsten Hölbing
 *	 email                : carsten@hoelbing.net
 *
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

$page_url = "admin_general_game_settings.php";

/**
 * Expansion Setting
 */
$array_game_expansion = array();

//load expansion
$sql = "SELECT exp_lang_id, exp_id FROM " . $phpraid_config['db_prefix'] . "expansion";
$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
while($data = $db_raid->sql_fetchrow($result, true))
{
	$array_game_expansion[$data['exp_id']] = $phprlang[$data['exp_lang_id']];
	
	if ($phpraid_config['game_expansion'] = $data['exp_id'])
	{
		$selected_array_game_expansion = $data['exp_id'];
	}
}
	
$wrmadminsmarty->assign('config_data',
	array(
		'form_action'=> $page_url,
		'game_header'=>$phprlang['configuration_game_header'],

		'select_expansion_text' => $phprlang['configuration_game_select_addon'],
		'array_game_expansion' => $array_game_expansion,
		'selected_array_game_expansion' => $selected_array_game_expansion,
	
		'button_submit' => $phprlang['submit'],
		'button_reset' => $phprlang['reset']
	)
);

if(isset($_POST['submit']))
{

	$game_expansion = scrub_input(DEUBB($_POST['game_expansion']));

	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'game_expansion';", quote_smart($game_expansion));
	$db_raid->sql_query($sql) or print_error($sql,$db_raid->sql_error(),1);

	header("Location: ".$page_url);
}

//
// Start output of the page.
//
require_once('./includes/admin_page_header.php');
$wrmadminsmarty->display('admin_general_game_settings.html');
require_once('./includes/admin_page_footer.php');

?>