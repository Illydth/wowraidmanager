<?php
/***************************************************************************
 *                             bosstracking.php
 *                            -------------------
 *   begin                : Monday, June 8, 2009
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
require_once('./common.php');

// page authentication
define("PAGE_LVL","anonymous");
require_once("includes/authentication.php");

// Form Display
if($_GET['mode'] == 'view')
{
	$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "boss_kill_type WHERE def='1'";
	$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
	$data = $db_raid->sql_fetchrow($result, true);
	
	isset($_GET['boss_kill_type']) ? $boss_kill_type_id = scrub_input($_GET['boss_kill_type']) : $boss_kill_type_id = $data['boss_kill_type_id'];
	isset($_GET['event_type_id']) ? $event_type_id = scrub_input($_GET['event_type_id']) : $event_type_id = $data['event_type_id'];
	isset($_GET['max']) ? $max = scrub_input($_GET['max']) : $max = $data['max'];
	
	// Setup Event Type Select Box.
	$bosskillselect = '<select name="boss_kill_type" id="boss_kill_type" class="post" onChange="MM_jumpMenu(\'parent\',this,0)">
				<option value=""></option>';

	$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "boss_kill_type";
	$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
	while($data = $db_raid->sql_fetchrow($result, true))
	{		
		// Event Type for WoW Calendar
		if ($boss_kill_type_id != '' && $data['boss_kill_type_id'] == $boss_kill_type_id)
			$bosskillselect .= '<option value="bosstracking.php?mode=view&amp;boss_kill_type='.$data['boss_kill_type_id'].'&amp;event_type_id='.$data['event_type_id'].'&amp;max='.$data['max'].'" selected>' . $phprlang[$data['boss_kill_type_lang_id']] . '</option>';
		elseif ($boss_kill_type_id == '' && $data['boss_kill_type_id'] == 1)
			$bosskillselect .= '<option value="bosstracking.php?mode=view&amp;boss_kill_type='.$data['boss_kill_type_id'].'&amp;event_type_id='.$data['event_type_id'].'&amp;max='.$data['max'].'" selected>' . $phprlang[$data['boss_kill_type_lang_id']] . '</option>';
		else
			$bosskillselect .= '<option value="bosstracking.php?mode=view&amp;boss_kill_type='.$data['boss_kill_type_id'].'&amp;event_type_id='.$data['event_type_id'].'&amp;max='.$data['max'].'">' . $phprlang[$data['boss_kill_type_lang_id']] . '</option>';
	}
	$bosskillselect .= '</select>';		
	// End Event Type Setup
	
	// Create the Instance List Dropdown
	$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "events WHERE event_type_id='" . $event_type_id . "' AND max LIKE '" . $max . "'";
	$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
	while($data = $db_raid->sql_fetchrow($result, true))
	{
		//Fill in dropdown that again refreshes page.		
	}
}

$wrmsmarty->assign('bosstracking_new',
	array(
		'newbosskill_header' => $phprlang['bosskill_header'],
		'bosskill_type' => $bosskillselect,
	)
);

	//
	// Start output of page
	//
	require_once('includes/page_header.php');
	$wrmsmarty->display('bosstracking.html');
	require_once('includes/page_footer.php');

?>