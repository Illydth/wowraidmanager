<?php
/***************************************************************************
 *                                profile.php
 *                            -------------------
 *   begin                : Saturday, Jan 16, 2005
 *   copyright            : (C) 2007-2008 Douglas Wagner
 *   email                : douglasw@wagnerweb.org
 *
 *   $Id: profile.php,v 2.00 2008/03/08 14:28:18 psotfx Exp $
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
define("PAGE_LVL","profile");
require_once("includes/authentication.php");

// Set the Guild Server for the Page.
$server = $phpraid_config['guild_server'];

if($_GET['mode'] == 'view') {
	$chars = array();

	// now that we have their profile_id, let's get a list of all their characters
	$profile_id = scrub_input($_SESSION['profile_id']);
	$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "chars WHERE profile_id=%s",quote_smart($profile_id));
	$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
	while($data = $db_raid->sql_fetchrow($result, true))
	{
		array_push($chars,
			array(
				'ID'=>$data['char_id'],
				'Name'=>get_armorychar($data['name'], $phpraid_config['armory_language'], $server),
				'Guild'=>$data['guild'],
				'Level'=>$data['lvl'],
				'Race'=>$data['race'],
				'Class'=>$data['class'],
				'Arcane'=>$data['arcane'],
				'Fire'=>$data['fire'],
				'Frost'=>$data['frost'],
				'Nature'=>$data['nature'],
				'Shadow'=>$data['shadow'],
				'Role'=>$data['role'],
				''=>'<a href="profile.php?mode=remove&n='.$data['name'].'&id='.$data['char_id'].'"><img src="templates/' . $phpraid_config['template'] . '/images/icons/icon_delete.gif" border="0" onMouseover="ddrivetip(\''. $phprlang['delete'] .'\')"; onMouseout="hideddrivetip()"></a>
					 <a href="profile.php?mode=edit&race='.$data['race'].'&id='.$data['char_id'].'"><img src="templates/' . $phpraid_config['template'] . '/images/icons/icon_edit.gif" border="0" onMouseover="ddrivetip(\'' . $phprlang['edit'] .'\')"; onMouseout="hideddrivetip()"></a>')
			);
	}

	// setup formatting for report class (THANKS to www.thecalico.com)
	// generic settings
	setup_output();

	$report->showRecordCount(true);
	$report->allowPaging(true, $_SERVER['PHP_SELF'] . '?mode=view&Base=');
	$report->setListRange($_GET['Base'], 25);
	$report->allowLink(ALLOW_HOVER_INDEX,'',array());

	//Default sorting
	if(!$_GET['Sort'])
	{
		$report->allowSort(true, 'Name', 'ASC', 'profile.php?mode=view');
	}
	else
	{
		$report->allowSort(true, $_GET['Sort'], $_GET['SortDescending'], 'profile.php?mode=view');
	}

	$report->showRecordCount(count);
	// display settings
	if($phpraid_config['show_id'] == 1)
		$report->addOutputColumn('ID',$phprlang['id'],'','center');
	$report->addOutputColumn('Name',$phprlang['name'],'','center');
	$report->addOutputColumn('Guild',$phprlang['guild'],'','center');
	$report->addOutputColumn('Level',$phprlang['level'],'','center');
	$report->addOutputColumn('Race',$phprlang['race'],'','center');
	$report->addOutputColumn('Class',$phprlang['class'],'','center');
	$report->addOutputColumn('Role',$phprlang['role'],'','center');	
	$report->addOutputColumn('Arcane','<img src="templates/' . $phpraid_config['template'] . '/images/resistances/arcane_resistance.gif" onMouseover="ddrivetip(\''.$phprlang['arcane'].'\')"; onMouseout="hideddrivetip()" height="16" width="16" border="0">','','center');
	$report->addOutputColumn('Fire','<img src="templates/' . $phpraid_config['template'] . '/images/resistances/fire_resistance.gif" onMouseover="ddrivetip(\''.$phprlang['fire'].'\')"; onMouseout="hideddrivetip()" height="16" width="16" border="0">','','center');
	$report->addOutputColumn('Nature','<img src="templates/' . $phpraid_config['template'] . '/images/resistances/nature_resistance.gif" onMouseover="ddrivetip(\''.$phprlang['nature'].'\')"; onMouseout="hideddrivetip()" height="16" width="16" border="0">','','center');
	$report->addOutputColumn('Frost','<img src="templates/' . $phpraid_config['template'] . '/images/resistances/frost_resistance.gif" onMouseover="ddrivetip(\''.$phprlang['frost'].'\')"; onMouseout="hideddrivetip()" height="16" width="16" border="0">','','center');
	$report->addOutputColumn('Shadow','<img src="templates/' . $phpraid_config['template'] . '/images/resistances/shadow_resistance.gif" onMouseover="ddrivetip(\''.$phprlang['shadow'].'\')"; onMouseout="hideddrivetip()" height="16" width="16" border="0">','','center');
	$report->addOutputColumn('','','','right');
	$chars = $report->getListFromArray($chars);

	// time to get a list of raids that they've signed up for
	$raid_list = array();

	$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "signups WHERE profile_id=%s", quote_smart($profile_id));
	$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
	while($signups = $db_raid->sql_fetchrow($result, true))
	{
		// setup the count array
		$count = array('dr'=>'0','hu'=>'0','ma'=>'0','pa'=>'0','pr'=>'0','ro'=>'0','sh'=>'0','wk'=>'0','wa'=>'0','ranged'=>'0','tank'=>'0','heal'=>'0','melee'=>'0','tkmel'=>'0');

		$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "raids WHERE raid_id=%s", quote_smart($signups['raid_id']));
		$result_raid = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
		$data = $db_raid->sql_fetchrow($result_raid, true);
		
		$desc = strip_tags($data['description']);
		$desc = UBB($desc);

		$location = '<a href="view.php?mode=view&raid_id='.$data['raid_id'].'"
					 onMouseover="ddrivetip(\'<span class=tooltip_title>'.$phprlang['description'].'</span><br>'
					 . DEUBB($desc) . '\')" onMouseout="hideddrivetip()">'.UBB($data['location']).'</a>';

		// convert unix timestamp to something readable
		$start = new_date($phpraid_config['time_format'],$data['start_time'],$phpraid_config['timezone'] + $phpraid_config['dst']);
		$invite = new_date($phpraid_config['time_format'],$data['invite_time'],$phpraid_config['timezone'] + $phpraid_config['dst']);
		$date = $data['start_time'];

		$count = get_char_count($data['raid_id'], $type='');
		$count2 = get_char_count($data['raid_id'], $type='backup');

		$total = $count['dr'] + $count['hu'] + $count['ma'] + $count['pa'] +$count['pr'] + $count['ro'] + $count['sh'] + $count['wk'] + $count['wa'];
		$total2 = $count2['dr'] + $count2['hu'] + $count2['ma'] + $count2['pa'] + $count2['pr'] + $count2['ro'] + $count2['sh'] + $count2['wk'] + $count2['wa'];

		if($total == "")
		{
			$total = "0";
		}
		if($total2 == "")
		{
			$total2 = "";
		}
		else
		{
			$total2 = " (+$total2)";
		}

		// current raids
		if($data['old'] == 0) {
			array_push($raid_list,
				array(
					'id'=>$data['raid_id'],
					'Date'=>$date,'Location'=>$location,
					'Invite Time'=>$invite,
					'Start Time'=>$start,'Officer'=>$data['officer'],
					'Max'=>$total.'/'.$data['max']  . '' . $total2,
					'Dru'=>$count['dr'] . "/" . $data['dr_lmt'],
					'Hun'=>$count['hu'] . "/" . $data['hu_lmt'],
					'Mag'=>$count['ma'] . "/" . $data['ma_lmt'],
					'Pal'=>$count['pa'] . "/" . $data['pa_lmt'],
					'Pri'=>$count['pr'] . "/" . $data['pr_lmt'],
					'Rog'=>$count['ro'] . "/" . $data['ro_lmt'],
					'Sha'=>$count['sh'] . "/" . $data['sh_lmt'],
					'Wlk'=>$count['wk'] . "/" . $data['wk_lmt'],
					'War'=>$count['wa'] . "/" . $data['wa_lmt'],
				)
			);
		}
	}

	// setup formatting for report class (THANKS to www.thecalico.com)
	// generic settings
	$report->clearOutputColumns();
	setup_output();

	$report->showRecordCount(true);
	$report->allowPaging(true, $_SERVER['PHP_SELF'] . '?mode=view&Base=');
	$report->setListRange($_GET['Base'], 25);
	$report->allowLink(ALLOW_HOVER_INDEX,'',array());

	//Default sorting
	if(!$_GET['Sort'])
	{
		$report->allowSort(true, 'Date', 'ASC', 'profile.php?mode=view');
	}
	else
	{
		$report->allowSort(true, $_GET['Sort'], $_GET['SortDescending'], 'profile.php?mode=view');
	}

	$report->showRecordCount(false);
	// and now to format each column output
	// the report class makes it very easy to use icons (or whatever) instead of just text
	if($phpraid_config['show_id'])
		$report->addOutputColumn('id',$phprlang['id'],'','left');
	$report->addOutputColumn('Date',$phprlang['date'],'unixtime','center');
	$report->addOutputColumn('Location',$phprlang['location'],'','center');
	$report->addOutputColumn('Invite Time',$phprlang['invite_time'],'','center');
	$report->addOutputColumn('Start Time',$phprlang['start_time'],'','center');
	$report->addOutputColumn('Officer',$phprlang['officer'],'','center');
	$report->addOutputColumn('Dru', '<img src="templates/' . $phpraid_config['template'] . '/images/classes/druid_icon.gif" border="0" height="18" width="18" onMouseover="ddrivetip(\'' . $phprlang['sort_text'] . $phprlang['druid'] . '\')"; onMouseout="hideddrivetip()">', '', 'center');
	$report->addOutputColumn('Hun', '<img src="templates/' . $phpraid_config['template'] . '/images/classes/hunter_icon.gif" border="0" height="18" width="18" onMouseover="ddrivetip(\'' . $phprlang['sort_text'] . $phprlang['hunter'] . '\')"; onMouseout="hideddrivetip()">', '', 'center');
	$report->addOutputColumn('Mag', '<img src="templates/' . $phpraid_config['template'] . '/images/classes/mage_icon.gif" border="0" height="18" width="18" onMouseover="ddrivetip(\'' . $phprlang['sort_text'] . $phprlang['mage'] . '\')"; onMouseout="hideddrivetip()">', '', 'center');
	$report->addOutputColumn('Pal', '<img src="templates/' . $phpraid_config['template'] . '/images/classes/paladin_icon.gif" border="0" height="18" width="18" onMouseover="ddrivetip(\'' . $phprlang['sort_text'] . $phprlang['paladin'] . '\')"; onMouseout="hideddrivetip()">', '', 'center');
	$report->addOutputColumn('Pri', '<img src="templates/' . $phpraid_config['template'] . '/images/classes/priest_icon.gif" border="0" height="18" width="18" onMouseover="ddrivetip(\'' . $phprlang['sort_text'] . $phprlang['priest'] . '\')"; onMouseout="hideddrivetip()">', '', 'center');
	$report->addOutputColumn('Rog', '<img src="templates/' . $phpraid_config['template'] . '/images/classes/rogue_icon.gif" border="0" height="18" width="18" onMouseover="ddrivetip(\'' . $phprlang['sort_text'] . $phprlang['rogue'] . '\')"; onMouseout="hideddrivetip()">', '', 'center');
	$report->addOutputColumn('Sha', '<img src="templates/' . $phpraid_config['template'] . '/images/classes/shaman_icon.gif" border="0" height="18" width="18" onMouseover="ddrivetip(\'' . $phprlang['sort_text'] . $phprlang['shaman'] . '\')"; onMouseout="hideddrivetip()">', '', 'center');
	$report->addOutputColumn('Wlk', '<img src="templates/' . $phpraid_config['template'] . '/images/classes/warlock_icon.gif" border="0" height="18" width="18" onMouseover="ddrivetip(\'' . $phprlang['sort_text'] . $phprlang['warlock'] . '\')"; onMouseout="hideddrivetip()">', '', 'center');
	$report->addOutputColumn('War', '<img src="templates/' . $phpraid_config['template'] . '/images/classes/warrior_icon.gif" border="0" height="18" width="18" onMouseover="ddrivetip(\'' . $phprlang['sort_text'] . $phprlang['warrior'] . '\')"; onMouseout="hideddrivetip()">', '', 'center');
	$report->addOutputColumn('Max',$phprlang['totals'],'','center');

	// and finally, put the data into the variables to be read
	$raid_list = $report->getListFromArray($raid_list);

	$page->set_file(array(
		'output' => $phpraid_config['template'] . '/profile.htm')
	);

	$page->set_var(
		array(
			'character_list' => $chars,
			'raid_list' => $raid_list,
			'character_header' => $phprlang['profile_header'],
			'raid_header' => $phprlang['profile_raid'],
			)
		);

	$page->parse('output','output');
} elseif($_GET['mode'] == 'remove') {
	$id = scrub_input($_GET['id']);
	$n = scrub_input($_GET['n']);
	$profile_id = scrub_input($_SESSION['profile_id']);

	if(!isset($_POST['submit']))
	{
		$form_action = "profile.php?mode=remove&n=$n&id=$id";
		$confirm_button = '<input name="submit" type="submit" id="submit" value="'.$phprlang['confirm_deletion'].'" class="mainoption">';

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
	}
	else
	{
		log_delete('character',$n);

		$sql = sprintf("DELETE FROM " . $phpraid_config['db_prefix'] . "chars WHERE char_id=%s AND profile_id=%s",quote_smart($id), quote_smart($profile_id));
		$db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);

		$sql = sprintf("DELETE FROM " . $phpraid_config['db_prefix'] . "signups WHERE char_id=%s AND profile_id=%s",quote_smart($id), quote_smart($profile_id));
		$db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
		header("Location: profile.php?mode=view");
	}
} elseif(($_GET['mode'] == 'new' || $_GET['mode'] == 'edit')) {
	if($_GET['mode'] == 'new') {
		// check for errors
		$race = scrub_input($_GET['race']);
		$class = scrub_input($_POST['class']);
		$gender = scrub_input($_POST['gender']);
		$name = scrub_input(trim($_POST['name']));
		$dupeChar = isCharExist($name);
		$guild = scrub_input($_POST['guild']);
		$level = scrub_input($_POST['level']);
		$role = scrub_input($_POST['role']);	
		$arcane = scrub_input($_POST['arcane']);
		$fire = scrub_input($_POST['fire']);
		$frost = scrub_input($_POST['frost']);
		$nature = scrub_input($_POST['nature']);
		$shadow = scrub_input($_POST['shadow']);
	} else {
		// edit, grab from database
		$char_id = scrub_input($_GET['id']);

		$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "chars WHERE char_id=%s",quote_smart($char_id));
		$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
		$data = $db_raid->sql_fetchrow($result, true);
		
		$guild = $data['guild'];
		$race = $data['race'];
		$class = $data['class'];
		$gender = $data['gender'];
		$name = $data['name'];
		$dupeChar = 0;
		$level = $data['lvl'];
		$role = $data['role'];		
		$arcane = $data['arcane'];
		$fire = $data['fire'];
		$frost = $data['frost'];
		$nature = $data['nature'];
		$shadow = $data['shadow'];
	}

	if(isset($_POST['submit'])) {
		$race = scrub_input($_GET['race']);
		$class = scrub_input($_POST['class']);
		$gender = scrub_input($_POST['gender']);
		$name = scrub_input(ucfirst(trim($_POST['name'])));
		$guild = scrub_input($_POST['guild']);
		$level = scrub_input($_POST['level']);
		$role = scrub_input($_POST['role']);
		$arcane = scrub_input($_POST['arcane']);
		$fire = scrub_input($_POST['fire']);
		$frost = scrub_input($_POST['frost']);
		$nature = scrub_input($_POST['nature']);
		$shadow = scrub_input($_POST['shadow']);
		// check for errors
		
		// check for errors + resistance optional
		if (($phpraid_config['resop'] == 1) AND ($fire == "") AND ($frost == "") AND ($nature == "") AND ($arcane == ""))
		{
			$errorSpace = 1;
			$errorTitle = $phprlang['form_error'];
			$errorMsg = '<ul>';
							
			if($guild == '')
				$errorMsg .= '<li>'.$phprlang['profile_error_guild'].'</li>';
			if($dupeChar)
				$errorMsg .= '<li>'.$phprlang['profile_error_dupe'].'</li>';
			if($class == '')
				$errorMsg .= '<li>'.$phprlang['profile_error_class'].'</li>';
			if($race == $phprlang['form_select'])
				$errorMsg .= '<li>'.$phprlang['profile_error_race'].'</li>';
			if($name == '')
				$errorMsg .= '<li>'.$phprlang['profile_error_name'].'</li>';
			if($level == '' || !is_numeric($level) || $level < 1 || $level > 70)
				$errorMsg .= '<li>'.$phprlang['profile_error_level'].'</li>';
			if($role == '' || $role == $phprlang['role_none'])
				$errorMsg .= '<li>'.$phprlang['profile_error_role'].'</li>';

			$errorDie = 0;
			$errorMsg .= '</ul>';

			if($errorMsg != '<ul></ul>')
			{
				$errorDie = 1;
			}
			else
			{
				//So resistance optional and valuas are empty, time to convert
				$shadow = "0";
				$fire = "0";
				$frost = "0";
				$nature = "0";
				$arcane = "0";

				// all is good add to database
				$profile = scrub_input($_SESSION['profile_id']);

				if($_GET['mode'] == 'new') {
					$sql = sprintf("INSERT INTO " . $phpraid_config['db_prefix'] . "chars (`profile_id`,`name`,`class`,
					`gender`,`guild`,`lvl`,`race`,`arcane`,`fire`,`frost`,`nature`,`shadow`,`role`) VALUES(%s,%s,%s,%s,%s,%s,%s,%s,
					%s,%s,%s,%s,%s)",quote_smart($profile),quote_smart($name),quote_smart($class),quote_smart($gender),quote_smart($guild),
					quote_smart($level),quote_smart($race),quote_smart($arcane),quote_smart($fire),quote_smart($frost),quote_smart($nature),quote_smart($shadow),quote_smart($role));

					$db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);

					log_create('character',mysql_insert_id(),$name);
				} elseif($_GET['mode'] == 'edit') {
					$char_id=scrub_input($_GET['id']);
					$sql = sprintf("UPDATE " . $phpraid_config['db_prefix'] . "chars SET name=%s,lvl=%s,race=%s,
					class=%s,gender=%s,guild=%s,arcane=%s,nature=%s,shadow=%s,fire=%s,frost=%s,role=%s WHERE char_id=%s",
					quote_smart($name),quote_smart($level),quote_smart($race),quote_smart($class),quote_smart($gender),
					quote_smart($guild),quote_smart($arcane),quote_smart($nature),quote_smart($shadow),quote_smart($fire),
					quote_smart($frost),quote_smart($role),quote_smart($char_id));

					$db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
				}
				header("Location: profile.php?mode=view");
			}
		}
		else
		{
			if($dupeChar || $guild == '' || $class == '' || $race == $phprlang['form_select'] || $name == '' ||
				!is_numeric($arcane) || !is_numeric($fire) || !is_numeric($frost) ||
				!is_numeric($nature) || !is_numeric($shadow) || !is_numeric($level) ||
				$level < 1 || $level > 70 || $role == '' || $role == $phprlang['role_none'])
			{
				$errorSpace = 1;
				$errorTitle = $phprlang['form_error'];
				$errorMsg = '<ul>';

				if($guild == '')
					$errorMsg .= '<li>'.$phprlang['profile_error_guild'].'</li>';
				if($dupeChar)
					$errorMsg .= '<li>'.$phprlang['profile_error_dupe'].'</li>';
				if($class == '')
					$errorMsg .= '<li>'.$phprlang['profile_error_class'].'</li>';
				if($race == $phprlang['form_select'])
					$errorMsg .= '<li>'.$phprlang['profile_error_race'].'</li>';
				if($name == '')
					$errorMsg .= '<li>'.$phprlang['profile_error_name'].'</li>';
				if($level == '' || !is_numeric($level) || $level < 1 || $level > 70)
					$errorMsg .= '<li>'.$phprlang['profile_error_level'].'</li>';
				if(!is_numeric($arcane))
					$errorMsg .= '<li>'.$phprlang['profile_error_arcane'].'</li>';
				if(!is_numeric($fire))
					$errorMsg .= '<li>'.$phprlang['profile_error_fire'].'</li>';
				if(!is_numeric($frost))
					$errorMsg .= '<li>'.$phprlang['profile_error_frost'].'</li>';
				if(!is_numeric($nature))
					$errorMsg .= '<li>'.$phprlang['profile_error_nature'].'</li>';
				if(!is_numeric($shadow))
					$errorMsg .= '<li>'.$phprlang['profile_error_shadow'].'</li>';
				if($role == '' || $role == $phprlang['role_none'])
					$errorMsg .= '<li>'.$phprlang['profile_error_role'].'</li>';
				$errorDie = 0;

				$errorMsg .= '</ul>';

				if($errorMsg != '<ul></ul>')
					$errorDie = 1;
			} 
			else 
			{
				// all is good add to database
				$profile = scrub_input($_SESSION['profile_id']);

				if($_GET['mode'] == 'new')
				{
					$sql = sprintf("INSERT INTO " . $phpraid_config['db_prefix'] . "chars (`profile_id`,`name`,`class`,
					`gender`,`guild`,`lvl`,`race`,`arcane`,`fire`,`frost`,`nature`,`shadow`,`role`) VALUES(%s,%s,%s,%s,%s,%s,%s,%s,
					%s,%s,%s,%s,%s)",quote_smart($profile),quote_smart($name),quote_smart($class),quote_smart($gender),quote_smart($guild),
					quote_smart($level),quote_smart($race),quote_smart($arcane),quote_smart($fire),quote_smart($frost),quote_smart($nature),quote_smart($shadow),quote_smart($role));

					$db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);

					log_create('character',mysql_insert_id(),$name);
				}
				elseif($_GET['mode'] == 'edit')
				{
					$char_id=scrub_input($_GET['id']);
					$sql = sprintf("UPDATE " . $phpraid_config['db_prefix'] . "chars SET name=%s,lvl=%s,race=%s,
					class=%s,gender=%s,guild=%s,arcane=%s,nature=%s,shadow=%s,fire=%s,frost=%s,role=%s WHERE char_id=%s",
					quote_smart($name),quote_smart($level),quote_smart($race),quote_smart($class),quote_smart($gender),
					quote_smart($guild),quote_smart($arcane),quote_smart($nature),quote_smart($shadow),quote_smart($fire),
					quote_smart($frost),quote_smart($role),quote_smart($char_id));

					$db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
				}

				header("Location: profile.php?mode=view");
			}
		}
	}
}

// and the form
$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "guilds";
$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);

if($db_raid->sql_numrows($result) == 0) {
	$errorTitle = $phprlang['profile_create_header'];
	$errorMsg = $phprlang['profile_create_msg'];
	$errorDie = 0;
	$errorSpace = 1;
} else {
	if($_GET['mode'] != 'remove') {
		// form variables
		// nothing worse than submitting a form wrong and losing all your input
		if(isset($_GET['race']))
			$race = scrub_input($_GET['race']);
		else
			$race = '';

		if(isset($_GET['id']))
			$id = scrub_input($_GET['id']);
		else
			$id = '';

		if(!isset($class))
			$class = '';

		if(!isset($name))
			$name = '';

		if(!isset($guild))
			$guild = '';

		if(!isset($level))
			$level = '';

		if(!isset($class_options))
			$class_options = '';

		if(!isset($arcane))
			$arcane = '';

		if(!isset($fire))
			$fire = '';

		if(!isset($frost))
			$frost = '';

		if(!isset($nature))
			$nature = '';

		if(!isset($shadow))
			$shadow = '';

		if(!isset($role))
			$role = '';

		// template variables
		if($_GET['mode'] == 'view' || $_GET['mode'] == 'new')
			$form_action = 'profile.php?mode=new&race='.$race;
		else
			$form_action = 'profile.php?mode=edit&id='.$id.'&race='.$race;

		if($_GET['mode'] == 'view' || $_GET['mode'] == 'new')
		$Form_use = "value=\"profile.php?mode=view&race=";
		else
		$Form_use = "value=\"profile.php?mode=edit&id=".$id."&race=";
		// only show alliance races
		if($phpraid_config['faction'] == "alliance")
		{
			// $phprlang['draenei']
			$race_options .= "<option ";
			if($race == $phprlang['draenei'])
				$race_options .= "SELECTED ";
			$race_options .= $Form_use.$phprlang['draenei']."\">".$phprlang['draenei']."</option>";
			// $phprlang['dwarf']
			$race_options .= "<option ";
			if($race == $phprlang['dwarf'])
				$race_options .= "SELECTED ";
			$race_options .= $Form_use.$phprlang['dwarf']."\">".$phprlang['dwarf']."</option>";
			// $phprlang['gnome']
			$race_options .= "<option ";
			if($race == $phprlang['gnome'])
				$race_options .= "SELECTED ";
			$race_options .= $Form_use.$phprlang['gnome']."\">".$phprlang['gnome']."</option>";
			// $phprlang['human']
			$race_options .= "<option ";
			if($race == $phprlang['human'])
				$race_options .= "SELECTED ";
			$race_options .= $Form_use.$phprlang['human']."\">".$phprlang['human']."</option>";
			// $phprlang['night_elf']
			$race_options .= "<option ";
			if($race == $phprlang['night_elf'])
				$race_options .= "SELECTED ";
			$race_options .= $Form_use.$phprlang['night_elf']."\">".$phprlang['night_elf']."</option>";
		}
		// only show horde races
		if($phpraid_config['faction'] == "horde")
		{
			// $phprlang['blood_elf']
			$race_options .= "<option ";
			if($race == $phprlang['blood_elf'])
				$race_options .= "SELECTED ";
			$race_options .= $Form_use.$phprlang['blood_elf']."\">".$phprlang['blood_elf']."</option>";
			// $phprlang['orc']
			$race_options .= "<option ";
			if($race == $phprlang['orc'])
				$race_options .= "SELECTED ";
			$race_options .= $Form_use.$phprlang['orc']."\">".$phprlang['orc']."</option>";
			// $phprlang['tauren']
			$race_options .= "<option ";
			if($race == $phprlang['tauren'])
				$race_options .= "SELECTED ";
			$race_options .= $Form_use.$phprlang['tauren']."\">".$phprlang['tauren']."</option>";
			// $phprlang['troll']
			$race_options .= "<option ";
			if($race == $phprlang['troll'])
				$race_options .= "SELECTED ";
			$race_options .= $Form_use.$phprlang['troll']."\">".$phprlang['troll']."</option>";
			// $phprlang['undead']
			$race_options .= "<option ";
			if($race == $phprlang['undead'])
				$race_options .= "SELECTED ";
			$race_options .= $Form_use.$phprlang['undead']."\">".$phprlang['undead']."</option>";
		}

		// now that we have the race, let's show them what classes pertain to that race
		//Druid
		if($race == $phprlang['night_elf'] || $race == $phprlang['tauren']) {
			if($class == $phprlang['druid'])
				$class_options .= "<option value=\"".$phprlang['druid']."\" selected>".$phprlang['druid']."</option>";
			else
				$class_options .= "<option value=\"".$phprlang['druid']."\">".$phprlang['druid']."</option>";
		}

		//Hunter
		if($race == $phprlang['draenei'] || $race == $phprlang['dwarf'] || $race == $phprlang['night_elf'] || $race == $phprlang['blood_elf'] || $race == $phprlang['tauren'] || $race == $phprlang['orc'] || $race == $phprlang['troll']) {
			if($class == $phprlang['hunter'])
				$class_options .= "<option value=\"".$phprlang['hunter']."\" selected>".$phprlang['hunter']."</option>";
			else
				$class_options .= "<option value=\"".$phprlang['hunter']."\">".$phprlang['hunter']."</option>";
		}

		//Mage
		if($race == $phprlang['draenei'] || $race == $phprlang['gnome'] || $race == $phprlang['human'] || $race == $phprlang['blood_elf'] || $race == $phprlang['undead'] || $race == $phprlang['troll']) {
			if($class == $phprlang['mage'])
				$class_options .= "<option value=\"".$phprlang['mage']."\" selected>".$phprlang['mage']."</option>";
			else
				$class_options .= "<option value=\"".$phprlang['mage']."\">".$phprlang['mage']."</option>";
		}

		//Paladin
		if($race == $phprlang['blood_elf'] || $race == $phprlang['draenei'] || $race == $phprlang['dwarf'] || $race == $phprlang['human']) {
			if($class == $phprlang['paladin'])
				$class_options .= "<option value=\"".$phprlang['paladin']."\" selected>".$phprlang['paladin']."</option>";
			else
				$class_options .= "<option value=\"".$phprlang['paladin']."\">".$phprlang['paladin']."</option>";
		}

		//Priest
		if($race == $phprlang['blood_elf'] || $race == $phprlang['draenei'] || $race == $phprlang['dwarf'] || $race == $phprlang['human'] || $race == $phprlang['night_elf'] || $race == $phprlang['undead'] || $race == $phprlang['troll']) {
			if($class == $phprlang['priest'])
				$class_options .= "<option value=\"".$phprlang['priest']."\" selected>".$phprlang['priest']."</option>";
			else
				$class_options .= "<option value=\"".$phprlang['priest']."\">".$phprlang['priest']."</option>";
		}

		//Rogue
		if($race != $phprlang['tauren'] && $race != $phprlang['draenei'] && $race != "") {
			if($class == $phprlang['rogue'])
				$class_options .= "<option value=\"".$phprlang['rogue']."\" selected>".$phprlang['rogue']."</option>";
			else
				$class_options .= "<option value=\"".$phprlang['rogue']."\">".$phprlang['rogue']."</option>";
		}

		//Shaman
		if($race == $phprlang['draenei'] || $race == $phprlang['orc'] || $race == $phprlang['tauren'] || $race == $phprlang['troll']) {
			if($class == $phprlang['shaman'])
				$class_options .= "<option value=\"".$phprlang['shaman']."\" selected>".$phprlang['shaman']."</option>";
			else
				$class_options .= "<option value=\"".$phprlang['shaman']."\">".$phprlang['shaman']."</option>";
		}

		//Warlock
		if($race == $phprlang['blood_elf'] || $race == $phprlang['human'] || $race == $phprlang['gnome'] || $race == $phprlang['orc'] || $race == $phprlang['undead']) {
			if($class == $phprlang['warlock'])
				$class_options .= "<option value=\"".$phprlang['warlock']."\" selected>".$phprlang['warlock']."</option>";
			else
				$class_options .= "<option value=\"".$phprlang['warlock']."\">".$phprlang['warlock']."</option>";
		}

		//Warrior
		if($race != $phprlang['blood_elf'] && $race != "") {
			if($class == $phprlang['warrior'])
				$class_options .= "<option value=\"".$phprlang['warrior']."\" selected>".$phprlang['warrior']."</option>";
			else
				$class_options .= "<option value=\"".$phprlang['warrior']."\">".$phprlang['warrior']."</option>";
		}

		//Gender Selection
		if(strtolower($gender) == strtolower($phprlang['male']))
			$gender_options .= "<option value=\"".$phprlang['male']."\" selected>".$phprlang['male']."</option>";
		else
			$gender_options .= "<option value=\"".$phprlang['male']."\">".$phprlang['male']."</option>";
		
		if(strtolower($gender) == strtolower($phprlang['female']))
			$gender_options .= "<option value=\"".$phprlang['female']."\" selected>".$phprlang['female']."</option>";
		else
			$gender_options .= "<option value=\"".$phprlang['female']."\">".$phprlang['female']."</option>";

		//Role Selection
		if($role == $phprlang['role_none'] || $role == '')
			$role_options .= "<option value=\"".$phprlang['role_none']."\" selected>".$phprlang['role_none']."</option>".$role;
		else
			$role_options .= "<option value=\"".$phprlang['role_none']."\">".$phprlang['role_none']."</option>";

		if($role == $phprlang['role_tank'])
			$role_options .= "<option value=\"".$phprlang['role_tank']."\" selected>".$phprlang['role_tank']."</option>";
		else
			$role_options .= "<option value=\"".$phprlang['role_tank']."\">".$phprlang['role_tank']."</option>";

		if($role == $phprlang['role_heal'])
			$role_options .= "<option value=\"".$phprlang['role_heal']."\" selected>".$phprlang['role_heal']."</option>";
		else
			$role_options .= "<option value=\"".$phprlang['role_heal']."\">".$phprlang['role_heal']."</option>";

		if($role == $phprlang['role_melee'])
			$role_options .= "<option value=\"".$phprlang['role_melee']."\" selected>".$phprlang['role_melee']."</option>";
		else
			$role_options .= "<option value=\"".$phprlang['role_melee']."\">".$phprlang['role_melee']."</option>";

		if($role == $phprlang['role_ranged'])
			$role_options .= "<option value=\"".$phprlang['role_ranged']."\" selected>".$phprlang['role_ranged']."</option>";
		else
			$role_options .= "<option value=\"".$phprlang['role_ranged']."\">".$phprlang['role_ranged']."</option>";

		if($role == $phprlang['role_tankmelee'])
			$role_options .= "<option value=\"".$phprlang['role_tankmelee']."\" selected>".$phprlang['role_tankmelee']."</option>";
		else
			$role_options .= "<option value=\"".$phprlang['role_tankmelee']."\">".$phprlang['role_tankmelee']."</option>";

		// setup output variables for form
		$race_output = '<select name="race" onChange="MM_jumpMenu(\'parent\',this,0)" class="form" style="width:100px">
						<option value="profile.php?mode=new">'.$phprlang['form_select'].'</option>' . $race_options . '</select>';

		if(!isset($_GET['race'])) {
			$class = '<select name="class" DISABLED><option></option></select>';
			$name = '<select name="name" DISABLED><option></option></select>';
			$level = '<select name="level" DISABLED><option></option></select>';
			$gender = '<select name="gender" DISABLED><option></option></select>';
			$guild = '<select name="guild" DISABLED><option></option></select>';
			$role = '<select name="role" DISABLED><option></option></select>';
			$arcane = '<select name="arcane" DISABLED><option></option></select>';
			$fire = '<select name="fire" DISABLED><option></option></select>';
			$frost = '<select name="frost" DISABLED><option></option></select>';
			$nature = '<select name="nature" DISABLED><option></option></select>';
			$shadow = '<select name="shadow" DISABLED><option></option></select>';
		} else {
			// get guild list
			$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "guilds";
			$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
			while($data = $db_raid->sql_fetchrow($result, true))
			{
				If($guild == $data['guild_tag'])
				{
					$guild_options .= '<option value="' . $data['guild_tag'] . '"\ selected>' . $data['guild_name'] . '</option>';
				}
				else
				{
					$guild_options .= '<option value="' . $data['guild_tag'] . '">' . $data['guild_name'] . '</option>';
				}
			}

			$guild = '<select name="guild" class="post" style="width:100px">' . $guild_options . '</select>';

			$class = '<select name="class" id="class" class="form" style="width:100px">' . $class_options . '</select>';
			$name = '<input type="text" name="name" class="post" value="' . $name . '" style="width:100px">';
			$level = '<input name="level" type="text" class="post" size="2" value="' . $level . '" maxlength="2">';
			$gender = '<select name="gender" class="form" id="gender" style="width:100px">' .$gender_options. '</select>';
			$role = '<select name="role" class="form" id="role" style="width:140px">' .$role_options. '</select>';
			$arcane = '<input name="arcane" type="text" class="post" size="3" value="' . $arcane . '" maxlength="3">';
			$fire =  '<input name="fire" type="text" class="post" size="3" value="' . $fire . '" maxlength="3">';
			$frost =  '<input name="frost" type="text" class="post" size="3" value="' . $frost . '" maxlength="3">';
			$nature =  '<input name="nature" type="text" class="post" size="3" value="' . $nature . '" maxlength="3">';
			$shadow =  '<input name="shadow" type="text" class="post" size="3" value="' . $shadow . '" maxlength="3">';
		}

		if($_GET['mode'] == 'view' || $_GET['mode'] == 'new') {
			$buttons = '<input type="submit" name="submit" value="Add Character" class="mainoption"> <input type="reset" name="Reset" value="Reset" class="liteoption">';
		} else {
			$buttons = '<input type="submit" name="submit" value="Update Character" class="mainoption"> <input type="reset" name="Reset" value="Reset" class="liteoption">';
		}

		$page->set_file(array(
			'new_file' => $phpraid_config['template'] . '/profile_new.htm')
		);

		$page->set_var(array(
			'name' => $name,
			'form_action' => $form_action,
			'buttons' => $buttons,
			'race'=>$race_output,
			'class'=>$class,
			'gender'=>$gender,
			'name'=>$name,
			'arcane_text'=>$phprlang['profile_arcane'],
			'fire_text'=>$phprlang['profile_fire'],
			'frost_text'=>$phprlang['profile_frost'],
			'nature_text'=>$phprlang['profile_nature'],
			'shadow_text'=>$phprlang['profile_shadow'],
			'arcane'=>$arcane,
			'fire'=>$fire,
			'frost'=>$frost,
			'nature'=>$nature,
			'shadow'=>$shadow,
			'guild_text' => $phprlang['profile_guild'],
			'guild' => $guild,
			'role_text' => $phprlang['profile_role'],
			'role' => $role,
			'level'=>$level,
			'new_header'=>$phprlang['profile_new'],
			'race_text'=>$phprlang['profile_race'],
			'class_text'=>$phprlang['profile_class'],
			'gender_text'=>$phprlang['profile_gender'],
			'name_text'=>$phprlang['profile_name'],
			'level_text'=>$phprlang['profile_level']
			)
		);

		$page->parse('output','new_file',true);
	}
}

//
// Start output of page
//
require_once('includes/page_header.php');

$page->p('output','output');

require_once('includes/page_footer.php');
?>