<?php
/***************************************************************************
 *                               locations.php
 *                            -------------------
 *   begin                : Saturday, Jan 16, 2005
 *   copyright            : (C) 2007-2008 Douglas Wagner
 *   email                : douglasw@wagnerweb.org
 *
 *   $Id: locations.php,v 2.0 2008/03/07 16:46:43 psotfx Exp $
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
define("PAGE_LVL","locations");
require_once("includes/authentication.php");

/*************************************************************
 * Setup Record Output Information for Data Table
 *************************************************************/
// Set StartRecord for Page
if(!isset($_GET['Base']) || !is_numeric($_GET['Base']))
	$startRecord = 1;
else
	$startRecord = scrub_input($_GET['Base']);

// Set Sort Field for Page
if(!isset($_GET['Sort']))
	$sortField="";
else
	$sortField = scrub_input($_GET['Sort']);
	
// Set Sort Descending Mark
if(!isset($_GET['SortDescending']) || !is_numeric($_GET['SortDescending']))
	$sortDesc = 1;
else
	$sortDesc = scrub_input($_GET['SortDescending']);
	
$pageURL = 'locations.php?mode=view&';
/**************************************************************
 * End Record Output Setup for Data Table
 **************************************************************/

// show the form
if($_GET['mode'] == 'view')
{
	$loc = array();

	$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "locations";
	$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
	while($data = $db_raid->sql_fetchrow($result, true))
	{
		$edit = '<a href="locations.php?mode=update&amp;id='.$data['location_id'].'"><img src="templates/' . $phpraid_config['template'] .
				'/images/icons/icon_edit.gif" border="0" onMouseover="ddrivetip(\'' . $phprlang['edit'] . '\');" onMouseout="hideddrivetip();" alt="edit icon"></a>';

		$delete = '<a href="locations.php?mode=delete&amp;n='.$data['name'].'&amp;id='.$data['location_id'].'"><img src="templates/' .
					$phpraid_config['template'] . '/images/icons/icon_delete.gif" border="0" onMouseover="ddrivetip(\'' . $phprlang['delete'] . '\');" onMouseout="hideddrivetip();" alt="delete icon"></a>';

		$event_type_id = $data['event_type'];
		if ($event_type_id == '1')
			$event_type_text = $phprlang['raids_type_raid'];
		elseif ($event_type_id == '2')
			$event_type_text = $phprlang['raids_type_dungeon'];
		elseif ($event_type_id == '3')
			$event_type_text = $phprlang['raids_type_pvp'];
		elseif ($event_type_id == '4')
			$event_type_text = $phprlang['raids_type_meeting'];
		elseif ($event_type_id == '5')
			$event_type_text = $phprlang['raids_type_other'];
		else
			$event_type_text = $phprlang['raids_type_raid'];
			
		array_push($loc,
			array(
				'ID'=>$data['location_id'],
				'Name'=>$data['name'],
				'Event Type'=>$event_type_text,
				'Dungeon'=>$data['location'],
				'Min Level'=>$data['min_lvl'],
				'Max Level'=>$data['max_lvl'],
				'Raid Max'=>$data['max'],
				'Death Knight'=>$data['dk'],
				'Druid'=>$data['dr'],
				'Hunter'=>$data['hu'],
				'Mage'=>$data['ma'],
				'Paladin'=>$data['pa'],
				'Priest'=>$data['pr'],
				'Rogue'=>$data['ro'],
				'Shaman'=>$data['sh'],
				'Warlock'=>$data['wk'],
				'Warrior'=>$data['wa'],
				$phpraid_config['role1_name']=>$data['role1'],
				$phpraid_config['role2_name']=>$data['role2'],
				$phpraid_config['role3_name']=>$data['role3'],
				$phpraid_config['role4_name']=>$data['role4'],
				$phpraid_config['role5_name']=>$data['role5'],
				$phpraid_config['role6_name']=>$data['role6'],
				'Locked'=>$data['locked'],
				'Buttons'=>$edit . $delete,
			)
		);
	}

	/**************************************************************
	 * Code to setup for a Dynamic Table Create: guild1 View.
	 **************************************************************/
	$viewName = 'location1';
	
	//Setup Columns
	$loc_headers = array();
	$record_count_array = array();
	$loc_headers = getVisibleColumns($viewName);

	//Get Record Counts
	$loc_record_count_array = getRecordCounts($loc, $loc_headers, $startRecord);
	
	//Get the Jump Menu and pass it down
	$locJumpMenu = getPageNavigation($loc, $startRecord, $pageURL, $sortField, $sortDesc);

	//Setup Data
	$loc = paginateSortAndFormat($loc, $sortField, $sortDesc, $startRecord, $viewName);

	/****************************************************************
	 * Data Assign for Template.
	 ****************************************************************/
	$wrmsmarty->assign('loc_data', $loc); 
	$wrmsmarty->assign('loc_jump_menu', $locJumpMenu);
	$wrmsmarty->assign('column_name', $loc_headers);
	$wrmsmarty->assign('loc_record_counts', $loc_record_count_array);
	$wrmsmarty->assign('header_data',
		array(
			'template_name'=>$phpraid_config['template'],
			'header' => $phprlang['locations_header'],
			'sort_url_base' => $pageURL,
			'sort_descending' => $sortDesc,
			'sort_text' => $phprlang['sort_text'],
		)
	);
}
elseif($_GET['mode'] == 'new' || $_GET['mode'] == 'edit')
{
	// form submitted, check for errors
	// assume no errors
	$form_error = 0;

	// slashes
	$name =scrub_input($_POST['name']);
	$loc = scrub_input($_POST['location']);
	$eventtype = scrub_input($_POST['tag']);
	$min_lvl = scrub_input($_POST['min_lvl']);
	$max_lvl = scrub_input($_POST['max_lvl']);
	$dk = scrub_input($_POST['dk']);
	$dr = scrub_input($_POST['dr']);
	$hu = scrub_input($_POST['hu']);
	$ma = scrub_input($_POST['ma']);
	$pa = scrub_input($_POST['pa']);
	$pr = scrub_input($_POST['pr']);
	$ro = scrub_input($_POST['ro']);
	$sh = scrub_input($_POST['sh']);
	$wk = scrub_input($_POST['wk']);
	$wa = scrub_input($_POST['wa']);
 	$role1 = scrub_input($_POST['role1']);
	if ($role1 == '')
		$role1 = '0';
	$role2 = scrub_input($_POST['role2']);
	if ($role2 == '')
		$role2 = '0';
	$role3 = scrub_input($_POST['role3']);
	if ($role3 == '')
		$role3 = '0';
	$role4 = scrub_input($_POST['role4']);
	if ($role4 == '')
		$role4 = '0';
	$role5 = scrub_input($_POST['role5']);
	if ($role5 == '')
		$role5 = '0';
	$role6 = scrub_input($_POST['role6']);
	if ($role6 == '')
		$role6 = '0';
 
 	if(isset($_POST['lock_template']))
 		$locked = 1;
 	else
 		$locked = 0;
	$max = scrub_input($_POST['max']);

	if($_GET['mode'] == 'new')
	{
		$sql = sprintf("INSERT INTO " . $phpraid_config['db_prefix'] . "locations (`location`,`min_lvl`,`max_lvl`,
		`name`,`dk`,`dr`,`hu`,`ma`,`pa`,`pr`,`ro`,`sh`,`wk`,`wa`,`role1`,`role2`,`role3`,`role4`,`role5`,`role6`,`max`,`locked`,`event_type`) VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)",
		quote_smart($loc),quote_smart($min_lvl),quote_smart($max_lvl),quote_smart($name),quote_smart($dk),quote_smart($dr),quote_smart($hu),
		quote_smart($ma),quote_smart($pa),quote_smart($pr),quote_smart($ro),quote_smart($sh),quote_smart($wk),quote_smart($wa),
		quote_smart($role1),quote_smart($role2),quote_smart($role3),quote_smart($role4),quote_smart($role5),quote_smart($role6),
		quote_smart($max),quote_smart($locked),quote_smart($eventtype));

		$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);

		log_create('location',mysql_insert_id(),$name);
	}
	elseif($_GET['mode'] == 'edit');
	{
		if(isset($_GET['id']))
			$id = scrub_input($_GET['id']);
		else
			$id = '';

		$sql = sprintf("UPDATE " . $phpraid_config['db_prefix'] . "locations SET name=%s,max=%s,dk=%s,dr=%s,hu=%s,ma=%s,pa=%s,pr=%s,ro=%s,sh=%s,wk=%s,
		wa=%s,role1=%s,role2=%s,role3=%s,role4=%s,role5=%s,role6=%s,min_lvl=%s,max_lvl=%s,location=%s,locked=%s,event_type=%s WHERE location_id=%s",quote_smart($name),quote_smart($max),
		quote_smart($dk),quote_smart($dr),quote_smart($hu),quote_smart($ma),quote_smart($pa),quote_smart($pr),quote_smart($ro),quote_smart($sh),quote_smart($wk),quote_smart($wa),
		quote_smart($role1),quote_smart($role2),quote_smart($role3),quote_smart($role4),quote_smart($role5),quote_smart($role6),quote_smart($min_lvl),
		quote_smart($max_lvl),quote_smart($loc),quote_smart($locked),quote_smart($eventtype),quote_smart($id));

		$db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
	}

	header("Location: locations.php?mode=view");
}
elseif($_GET['mode'] == 'delete')
{
	$id = scrub_input($_GET['id']);
	$n = scrub_input($_GET['n']);

	if($_SESSION['priv_locations'] == 1) {
		if(!isset($_POST['submit'])) {
			$form_action = 'locations.php?mode=delete&amp;n='.$n.'&amp;id=' . $id;
			$confirm_button = '<input type="submit" value="'.$phprlang['confirm'].'" name="submit" class="post">';

			$wrmsmarty->assign('page',
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
			require_once('includes/page_header.php');
			$wrmsmarty->display('delete.html');
			require_once('includes/page_footer.php');
		} else {
			log_delete('location',$n);

			$sql = sprintf("DELETE FROM " . $phpraid_config['db_prefix'] . "locations WHERE location_id=%s",quote_smart($id));
			$db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);

			header("Location: locations.php?mode=view");
		}
	} else {
		if($_SESSION['priv_locations'] == 1)
			header("Location: locations.php?mode=view");
		else
			header("Location: index.php");
	}
}

if($_GET['mode'] != 'delete')
{
	if($_GET['mode'] == 'view')
	{
		// setup new form information

		// Event Type for WoW Calendar
		$eventtype = '<select name="tag" class="post">';
		$eventtype .= '<option value="1" selected>' . $phprlang['raids_type_raid'] . '</option>';
		$eventtype .= '<option value="2">' . $phprlang['raids_type_dungeon'] . '</option>';
		$eventtype .= '<option value="3">' . $phprlang['raids_type_pvp'] . '</option>';
		$eventtype .= '<option value="4">' . $phprlang['raids_type_meeting'] . '</option>';
		$eventtype .= '<option value="5">' . $phprlang['raids_type_other'] . '</option>';
		$eventtype .= '</select>';

		$form_action = 'locations.php?mode=new';
		$name = '<input name="name" type="text" id="name" class="post">';
		$location = '<input name="location" type="text" id="location" class="post">';
		$min_lvl = '<input name="min_lvl" type="text" class="post" style="width:20px" maxlength="2">';
		$max_lvl = '<input name="max_lvl" type="text" class="post" style="width:20px" maxlength="2">';
		$dk = '<input name="dk" type="text" class="post" style="width:20px" maxlength="2">';
		$dr = '<input name="dr" type="text" class="post" style="width:20px" maxlength="2">';
		$hu = '<input name="hu" type="text" class="post" style="width:20px" maxlength="2">';
		$ma = '<input name="ma" type="text" class="post" style="width:20px" maxlength="2">';
		$pa = '<input name="pa" type="text" class="post" style="width:20px" maxlength="2">';
		$pr = '<input name="pr" type="text" class="post" style="width:20px" maxlength="2">';
		$ro = '<input name="ro" type="text" class="post" style="width:20px" maxlength="2">';
		$sh = '<input name="sh" type="text" class="post" style="width:20px" maxlength="2">';
		$wk = '<input name="wk" type="text" class="post" style="width:20px" maxlength="2">';
		$wa = '<input name="wa" type="text" class="post" style="width:20px" maxlength="2">';
		if ($phpraid_config['role1_name'] != '')
			$role1 = '<input name="role1" type="text" class="post" style="width:20px" maxlength="2">';
		else
			$role1 = '<input name="role1" type="hidden" value="" class="post" style="width:20px" maxlength="2">';
		if ($phpraid_config['role2_name'] != '')
			$role2 = '<input name="role2" type="text" class="post" style="width:20px" maxlength="2">';
		else
			$role2 = '<input name="role2" type="hidden" value="" class="post" style="width:20px" maxlength="2">';
		if ($phpraid_config['role3_name'] != '')
			$role3 = '<input name="role3" type="text" class="post" style="width:20px" maxlength="2">';
		else
			$role3 = '<input name="role3" type="hidden" value="" class="post" style="width:20px" maxlength="2">';
		if ($phpraid_config['role4_name'] != '')
			$role4 = '<input name="role4" type="text" class="post" style="width:20px" maxlength="2">';
		else
			$role4 = '<input name="role4" type="hidden" value="" class="post" style="width:20px" maxlength="2">';
		if ($phpraid_config['role5_name'] != '')
			$role5 = '<input name="role5" type="text" class="post" style="width:20px" maxlength="2">';
		else
			$role5 = '<input name="role5" type="hidden" value="" class="post" style="width:20px" maxlength="2">';
		if ($phpraid_config['role6_name'] != '')
			$role6 = '<input name="role6" type="text" class="post" style="width:20px" maxlength="2">';
		else
			$role6 = '<input name="role6" type="hidden" value="" class="post" style="width:20px" maxlength="2">';
		$locked = '<input name="lock_template" type="checkbox" value="1" class="post">';
		$max = '<input name="max" type="text" class="post" style="width:20px" maxlength="2">';
		$buttons = '<input type="submit" value="'.$phprlang['submit'].'" name="submit" class="mainoption"> <input type="reset" value="'.$phprlang['reset'].'" name="reset" class="liteoption">';
	}
	elseif($_GET['mode'] == 'update')
	{
		$id = scrub_input($_GET['id']);

		$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "locations WHERE location_id=%s",quote_smart($id));
		$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
		$data = $db_raid->sql_fetchrow($result, true);
		
		// it's an edit... joy
		// Event Type for WoW Calendar
		$eventtype = '<select name="tag" class="post">';
		if ($data['event_type'] == "1")
			$eventtype .= '<option value="1" selected>' . $phprlang['raids_type_raid'] . '</option>';
		else
			$eventtype .= '<option value="1">' . $phprlang['raids_type_raid'] . '</option>';
		if ($data['event_type'] == "2")
			$eventtype .= '<option value="2" selected>' . $phprlang['raids_type_dungeon'] . '</option>';
		else
			$eventtype .= '<option value="2">' . $phprlang['raids_type_dungeon'] . '</option>';
		if ($data['event_type'] == "3")
			$eventtype .= '<option value="3" selected>' . $phprlang['raids_type_pvp'] . '</option>';
		else
			$eventtype .= '<option value="3">' . $phprlang['raids_type_pvp'] . '</option>';
		if ($data['event_type'] == "4")
			$eventtype .= '<option value="4" selected>' . $phprlang['raids_type_meeting'] . '</option>';
		else
			$eventtype .= '<option value="4">' . $phprlang['raids_type_meeting'] . '</option>';
		if ($data['event_type'] == "5")
			$eventtype .= '<option value="5" selected>' . $phprlang['raids_type_other'] . '</option>';
		else
			$eventtype .= '<option value="5">' . $phprlang['raids_type_other'] . '</option>';
		$eventtype .= '</select>';
		$form_action = "locations.php?mode=edit&amp;id=$id";
		$name = '<input name="name" type="text" id="name" value="' . $data['name'] . '" class="post">';
		$location = '<input name="location" type="text" id="name" value="' . $data['location'] . '"  class="post">';
		$min_lvl = '<input name="min_lvl" type="text" value="' . $data['min_lvl'] . '"  class="post" style="width:20px" maxlength="2">';
		$max_lvl = '<input name="max_lvl" type="text" value="' . $data['max_lvl'] . '"  class="post" style="width:20px" maxlength="2">';
		$dk = '<input name="dk" type="text" value="' . $data['dk'] . '"  class="post" style="width:20px" maxlength="2">';
		$dr = '<input name="dr" type="text" value="' . $data['dr'] . '"  class="post" style="width:20px" maxlength="2">';
		$hu = '<input name="hu" type="text" value="' . $data['hu'] . '"  class="post" style="width:20px" maxlength="2">';
		$ma = '<input name="ma" type="text" value="' . $data['ma'] . '"  class="post" style="width:20px" maxlength="2">';
		$pa = '<input name="pa" type="text" value="' . $data['pa'] . '"  class="post" style="width:20px" maxlength="2">';
		$pr = '<input name="pr" type="text" value="' . $data['pr'] . '"  class="post" style="width:20px" maxlength="2">';
		$ro = '<input name="ro" type="text" value="' . $data['ro'] . '"  class="post" style="width:20px" maxlength="2">';
		$sh = '<input name="sh" type="text" value="' . $data['sh'] . '"  class="post" style="width:20px" maxlength="2">';
		$wk = '<input name="wk" type="text" value="' . $data['wk'] . '"  class="post" style="width:20px" maxlength="2">';
		$wa = '<input name="wa" type="text" value="' . $data['wa'] . '"  class="post" style="width:20px" maxlength="2">';
		if ($phpraid_config['role1_name'] != '')
			$role1 = '<input name="role1" type="text" value="' . $data['role1'] . '"  class="post" style="width:20px" maxlength="2">';
		else
			$role1 = '<input name="role1" type="hidden" value="" class="post" style="width:20px" maxlength="2">';
		if ($phpraid_config['role2_name'] != '')
			$role2 = '<input name="role2" type="text" value="' . $data['role2'] . '"  class="post" style="width:20px" maxlength="2">';
		else
			$role2 = '<input name="role2" type="hidden" value="" class="post" style="width:20px" maxlength="2">';
		if ($phpraid_config['role3_name'] != '')
			$role3 = '<input name="role3" type="text" value="' . $data['role3'] . '"  class="post" style="width:20px" maxlength="2">';
		else
			$role3 = '<input name="role3" type="hidden" value="" class="post" style="width:20px" maxlength="2">';
		if ($phpraid_config['role4_name'] != '')
			$role4 = '<input name="role4" type="text" value="' . $data['role4'] . '"  class="post" style="width:20px" maxlength="2">';
		else
			$role4 = '<input name="role4" type="hidden" value="" class="post" style="width:20px" maxlength="2">';
		if ($phpraid_config['role5_name'] != '')
			$role5 = '<input name="role5" type="text" value="' . $data['role5'] . '"  class="post" style="width:20px" maxlength="2">';
		else
			$role5 = '<input name="role5" type="hidden" value="" class="post" style="width:20px" maxlength="2">';
		if ($phpraid_config['role6_name'] != '')
			$role6 = '<input name="role6" type="text" value="' . $data['role6'] . '"  class="post" style="width:20px" maxlength="2">';
		else
			$role6 = '<input name="role6" type="hidden" value="" class="post" style="width:20px" maxlength="2">';
		if($data['locked'] == '0')
			$locked = '<input type="checkbox" name="lock_template" value="' . $data['locked'] . '"  class="post">';
		else
			$locked = '<input type="checkbox" name="lock_template" value="' . $data['locked'] . '"  class="post" checked>';
		$max = '<input name="max" type="text" value="' . $data['max'] . '"  class="post" style="width:20px" maxlength="2">';
		$buttons = '<input type="submit" value="'.$phprlang['update'].'" name="submit" class="mainoption"> <input type="reset" value="'.$phprlang['reset'].'" name="reset" class="liteoption">';
	}

	$wrmsmarty->assign('locations_new',
		array(
			'form_action'=>$form_action,
			'event_type'=>$eventtype,
			'eventtype_text'=>$phprlang['raids_eventtype_text'],
			'name'=>$name,
			'location'=>$location,
			'min_lvl'=>$min_lvl,
			'max_lvl'=>$max_lvl,
			'dk'=>$dk,
			'dr'=>$dr,
			'hu'=>$hu,
			'ma'=>$ma,
			'pa'=>$pa,
			'pr'=>$pr,
			'ro'=>$ro,
			'sh'=>$sh,
			'wk'=>$wk,
			'wa'=>$wa,
			'role1'=>$role1,
			'role2'=>$role2,
			'role3'=>$role3,
			'role4'=>$role4,
			'role5'=>$role5,
			'role6'=>$role6,
			'max'=>$max,
			'locked'=>$locked,
			'buttons'=>$buttons,
			'deathknight_name'=>$phprlang['deathknight'],
			'druid_name'=>$phprlang['druid'],
			'hunter_name'=>$phprlang['hunter'],
			'mage_name'=>$phprlang['mage'],
			'paladin_name'=>$phprlang['paladin'],
			'priest_name'=>$phprlang['priest'],
			'rogue_name'=>$phprlang['rogue'],
			'shaman_name'=>$phprlang['shaman'],
			'warlock_name'=>$phprlang['warlock'],
			'warrior_name'=>$phprlang['warrior'],
			'role1_name'=>$phpraid_config['role1_name'],
			'role2_name'=>$phpraid_config['role2_name'],
			'role3_name'=>$phpraid_config['role3_name'],
			'role4_name'=>$phpraid_config['role4_name'],
			'role5_name'=>$phpraid_config['role5_name'],
			'role6_name'=>$phpraid_config['role6_name'],
			'locked_text'=>$phprlang['lock_template'],
			'newlocation_header'=>$phprlang['locations_new'],
			'shortname_text'=>$phprlang['locations_short'],
			'location_text'=>$phprlang['locations_long'],
			'minlvl_text'=>$phprlang['locations_min_lvl'],
			'maxlvl_text'=>$phprlang['locations_max_lvl'],
			'maxattendees_text'=>$phprlang['locations_raid_max'],
			'limits_header'=>$phprlang['locations_limits_header'],
		)
	);
}

//
// Start output of page
//
if($_GET['mode'] != 'delete')
{
	require_once('includes/page_header.php');
	$wrmsmarty->display('locations.html');
	require_once('includes/page_footer.php');
}
?>