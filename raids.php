<?php
/***************************************************************************
 *                               raids.php
 *                            ---------------
 *   begin                : Saturday, Jan 16, 2005
 *   copyright            : (C) 2007 - 2008 Douglas Wagner
 *   email                : douglasw@wagnerweb.org
 *
 *   $Id: raids.php,v 2.00 2008/03/10 13:26:43 psotfx Exp $
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
if ($phpraid_config['enable_five_man'])
{
	define("PAGE_LVL","profile");
}
else
{
	define("PAGE_LVL","raids");
}
require_once("includes/authentication.php");

$priv_raids = scrub_input($_SESSION['priv_raids']);
$username = scrub_input($_SESSION['username']);

if($_GET['mode'] == 'view')
{
	// two arrays to pass to our report class, current and previous raids
	$current = array();
	$previous = array();

	$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "raids";
	$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);

	// Get information for current raids
	// And push into current array so that we can output it with our report class
	if (!$db_raid->sql_numrows($result) || $db_raid->sql_numrows($result) < 1)
		$new_raid_link = '<a href="raids.php?mode=new"><img src="templates/' . $phpraid_config['template'] . '/images/icons/icon_new_raid.gif" border="0"  onMouseover="ddrivetip(\''.$phprlang['raids_new_header'].'\');" onMouseout="hideddrivetip();" alt="new raid icon"></a>';		

	while($data = $db_raid->sql_fetchrow($result, true)) {
		if ($priv_raids or $username == $data['officer'])
		{
			$edit = '<a href="raids.php?mode=edit&amp;id='.$data['raid_id'].'"><img src="templates/' . $phpraid_config['template'] .
					'/images/icons/icon_edit.gif" border="0" onMouseover="ddrivetip(\''.$phprlang['edit'].'\');" onMouseout="hideddrivetip();" alt="edit icon"></a>';

			$delete = '<a href="raids.php?mode=delete&amp;n='.$data['location'].'&amp;id='.$data['raid_id'].'"><img src="templates/' .
						$phpraid_config['template'] . '/images/icons/icon_delete.gif" border="0" onMouseover="ddrivetip(\''.$phprlang['delete'].'\');"
						onMouseout="hideddrivetip();" alt="delete icon"></a><a href="lua_output.php?raid_id=' . $data['raid_id'] . '">

						<img src="templates/' . $phpraid_config['template'] . '/images/icons/icon_minipost.gif" border="0"
						onMouseover="ddrivetip(\''.$phprlang['lua'].'\');" onMouseout="hideddrivetip();" alt="minipost icon"></a>

						<a href="raids.php?mode=mark&amp;id='.$data['raid_id'].'"><img src="templates/' . $phpraid_config['template'] .
						'/images/icons/icon_latest_reply.gif" border="0" onMouseover="ddrivetip(\''.$phprlang['mark'].'\');"
						onMouseout="hideddrivetip();" alt="latest reply icon"></a>';

			$old_delete = '<a href="raids.php?mode=delete&amp;id='.$data['raid_id'].'"><img src="templates/' . $phpraid_config['template'] . '/images/icons/icon_delete.gif" border="0" onMouseover="ddrivetip(\''.$phprlang['delete'].'\');" onMouseout="hideddrivetip();" alt="delete icon"></a>';

			$mark_new = '<a href="raids.php?mode=mark&amp;id='.$data['raid_id'].'"><img src="templates/' . $phpraid_config['template'] . '/images/icons/icon_latest_reply.gif" border="0" onMouseover="ddrivetip(\''.$phprlang['new'].'\');" onMouseout="hideddrivetip();" alt="latest reply icon"></a>';
		}

		// Create the "new raid" button.
		$new_raid_link = '<a href="raids.php?mode=new"><img src="templates/' . $phpraid_config['template'] . '/images/icons/icon_new_raid.gif" border="0"  onMouseover="ddrivetip(\''.$phprlang['raids_new_header'].'\');" onMouseout="hideddrivetip();" alt="new raid icon"></a>';

		//setup the count array
		$count = array('dk'=>'0','dr'=>'0','hu'=>'0','ma'=>'0','pa'=>'0','pr'=>'0','ro'=>'0','sh'=>'0','wk'=>'0','wa'=>'0','role1'=>'0','role2'=>'0','role3'=>'0','role4'=>'0','role5'=>'0','role6'=>'0');

		$desc = scrub_input($data['description']);
		$desc = str_replace("'", "\'", $desc);
		$ddrivetiptxt = "'<span class=tooltip_title>" . $phprlang['description'] ."</span><br>" . DEUBB2($desc) . "'";
		$location = '<a href="view.php?mode=view&amp;raid_id='.$data['raid_id'].'" onMouseover="ddrivetip('.$ddrivetiptxt.');" onMouseout="hideddrivetip();">'.$data['location'].'</a>';

		// convert unix timestamp to something readable
		$start = new_date('Y/m/d H:i:s',$data['start_time'],$phpraid_config['timezone'] + $phpraid_config['dst']);
		$invite = new_date('Y/m/d H:i:s',$data['invite_time'],$phpraid_config['timezone'] + $phpraid_config['dst']);
		$date = $start;

		$count = get_char_count($data['raid_id'], $type='');
		$count2 = get_char_count($data['raid_id'], $type='queue');

		//Raid maximum
		$total = $count['dk'] + $count['dr'] + $count['hu'] + $count['ma'] + $count['pa'] + $count['pr'] + $count['ro'] + $count['sh'] + $count['wk'] + $count['wa'];

		//Backup
		$total2 = $count2['dk'] + $count2['dr'] + $count2['hu'] + $count2['ma'] + $count2['pa'] + $count2['pr'] + $count2['ro'] + $count2['sh'] + $count2['wk'] + $count2['wa'];

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
		
		//Code Specific to Nalumis
		//$minustkmel = 0;
		//$tank = get_coloredcount($count['tank'], $count2['tank'], $data['tank_lmt'], 0, $count['tkmel'] + $count2['tkmel'], 0, 0, 0, $minustkmel);
		//$heal = get_coloredcount($count['heal'], $count2['heal'], $data['heal_lmt'], 0, 0, 0, 0, 0, $minustkmel);
		//$merk_minustkmel = $minustkmel;
		//$melee = get_coloredcount($count['melee'], $count2['melee'], $data['melee_lmt'], 2, $count['tkmel'] + $count2['tkmel'] - $minustkmel, $count['melee'] + $count['ranged'], $count2['melee'] + $count2['ranged'], $data['melee_lmt'] + $data['ranged_lmt'], $minustkmel);
		//$minustkmel = $merk_minustkmel;
		//$ranged = get_coloredcount($count['ranged'], $count2['ranged'], $data['ranged_lmt'], 2, $count['tkmel'] + $count2['tkmel'] - $minustkmel, $count['melee'] + $count['ranged'], $count2['melee'] + $count2['ranged'], $data['melee_lmt'] + $data['ranged_lmt'], $minustkmel);
		//$tkmel = get_coloredcount($count['tkmel'], $count2['tkmel'], $data['tkmel_lmt'], 1, 0, 0, 0, 0, $minustkmel);

		if($phpraid_config['class_as_min'])
		{
			$dk_text = get_coloredcount('death knight', $count['dk'], $data['dk_lmt'], $count2['dk'], true);
			$dr_text = get_coloredcount('druid', $count['dr'], $data['dr_lmt'], $count2['dr'], true);
			$hu_text = get_coloredcount('hunter', $count['hu'], $data['hu_lmt'], $count2['hu'], true);
			$ma_text = get_coloredcount('mage', $count['ma'], $data['ma_lmt'], $count2['ma'], true);
			$pa_text = get_coloredcount('paladin', $count['pa'], $data['pa_lmt'], $count2['pa'], true);
			$pr_text = get_coloredcount('priest', $count['pr'], $data['pr_lmt'], $count2['pr'], true);
			$ro_text = get_coloredcount('rogue', $count['ro'], $data['ro_lmt'], $count2['ro'], true);
			$sh_text = get_coloredcount('shaman', $count['sh'], $data['sh_lmt'], $count2['sh'], true);
			$wk_text = get_coloredcount('warlock', $count['wk'], $data['wk_lmt'], $count2['wk'], true);
			$wa_text = get_coloredcount('warrior', $count['wa'], $data['wa_lmt'], $count2['wa'], true);
			$role1_text = get_coloredcount('role1', $count['role1'], $data['role1_lmt'], $count2['role1']);
			$role2_text = get_coloredcount('role2', $count['role2'], $data['role2_lmt'], $count2['role2']);
			$role3_text = get_coloredcount('role3', $count['role3'], $data['role3_lmt'], $count2['role3']);
			$role4_text = get_coloredcount('role4', $count['role4'], $data['role4_lmt'], $count2['role4']);
			$role5_text = get_coloredcount('role5', $count['role5'], $data['role5_lmt'], $count2['role5']);
			$role6_text = get_coloredcount('role6', $count['role6'], $data['role6_lmt'], $count2['role6']);
		}
		else
		{
			$dk_text = get_coloredcount('death knight', $count['dk'], $data['dk_lmt'], $count2['dk']);
			$dr_text = get_coloredcount('druid', $count['dr'], $data['dr_lmt'], $count2['dr']);
			$hu_text = get_coloredcount('hunter', $count['hu'], $data['hu_lmt'], $count2['hu']);
			$ma_text = get_coloredcount('mage', $count['ma'], $data['ma_lmt'], $count2['ma']);
			$pa_text = get_coloredcount('paladin', $count['pa'], $data['pa_lmt'], $count2['pa']);
			$pr_text = get_coloredcount('priest', $count['pr'], $data['pr_lmt'], $count2['pr']);
			$ro_text = get_coloredcount('rogue', $count['ro'], $data['ro_lmt'], $count2['ro']);
			$sh_text = get_coloredcount('shaman', $count['sh'], $data['sh_lmt'], $count2['sh']);
			$wk_text = get_coloredcount('warlock', $count['wk'], $data['wk_lmt'], $count2['wk']);
			$wa_text = get_coloredcount('warrior', $count['wa'], $data['wa_lmt'], $count2['wa']);
			$role1_text = get_coloredcount('role1', $count['role1'], $data['role1_lmt'], $count2['role1']);
			$role2_text = get_coloredcount('role2', $count['role2'], $data['role2_lmt'], $count2['role2']);
			$role3_text = get_coloredcount('role3', $count['role3'], $data['role3_lmt'], $count2['role3']);
			$role4_text = get_coloredcount('role4', $count['role4'], $data['role4_lmt'], $count2['role4']);
			$role5_text = get_coloredcount('role5', $count['role5'], $data['role5_lmt'], $count2['role5']);
			$role6_text = get_coloredcount('role6', $count['role6'], $data['role6_lmt'], $count2['role6']);
		}

		// current raids
		if($data['old'] == 0) {
			array_push($current,
				array(
					'id'=>$data['raid_id'],
					'Date'=>$date,'Location'=>$location,'Invite Time'=>$invite,'Start Time'=>$start,'Officer'=>$data['officer'],
					'Max'=>$total.'/'.$data['max']  . '' . $total2,
					'DtK'=>$dk_text,
					'Dru'=>$dr_text,
					'Hun'=>$hu_text,
					'Mag'=>$ma_text,
					'Pal'=>$pa_text,
					'Pri'=>$pr_text,
					'Rog'=>$ro_text,
					'Sha'=>$sh_text,
					'Wlk'=>$wk_text,
					'War'=>$wa_text,
					'role1'=>$role1_text,
					'role2'=>$role2_text,
					'role3'=>$role3_text,
					'role4'=>$role4_text,
					'role5'=>$role5_text,
					'role6'=>$role6_text,
					//'Tank'=>$tank,'Heal'=>$heal,'Melee'=>$melee,'Ranged'=>$ranged,'TkMel'=>$tkmel,
					''=>$edit . $delete,
				)
			);
		}
		else
		{
			array_push($previous,
				array(
					'id'=>$data['raid_id'],'Date'=>$date,'Location'=>UBB2($location),'Invite Time'=>$invite,'Start Time'=>$start,'Officer'=>$data['officer'],
					'Max'=>$total.'/'.$data['max']  . '' . $total2,
					'DtK'=>$dk_text,
					'Dru'=>$dr_text,
					'Hun'=>$hu_text,
					'Mag'=>$ma_text,
					'Pal'=>$pa_text,
					'Pri'=>$pr_text,
					'Rog'=>$ro_text,
					'Sha'=>$sh_text,
					'Wlk'=>$wk_text,
					'War'=>$wa_text,
					'role1'=>$role1_text,
					'role2'=>$role2_text,
					'role3'=>$role3_text,
					'role4'=>$role4_text,
					'role5'=>$role5_text,
					'role6'=>$role6_text,
					//'Tank'=>$tank,'Heal'=>$heal,'Melee'=>$melee,'Ranged'=>$ranged,'TkMel'=>$tkmel,
					''=> $mark_new . $old_delete));
		}
		$edit = "";
		$delete= "";
		$old_delete="";
		$mark_new="";
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
		$report->allowSort(true, 'Date', 'ASC', 'raids.php?mode=view');
	}
	else
	{
		$report->allowSort(true, $_GET['Sort'], $_GET['SortDescending'], 'raids.php?mode=view');
	}

	$report->showRecordCount(true);
	// and now to format each column output
	// the report class makes it very easy to use icons (or whatever) instead of just text
	if($phpraid_config['show_id'] == 1)
		$report->addOutputColumn('id',$phprlang['id'],'','center');
	$report->addOutputColumn('Date',$phprlang['date'],'wrmdate','center');
	$report->addOutputColumn('Location',$phprlang['location'],'','center');
	$report->addOutputColumn('Invite Time',$phprlang['invite_time'],'wrmtime','center');
	$report->addOutputColumn('Start Time',$phprlang['start_time'],'wrmtime','center');
	$report->addOutputColumn('Officer',$phprlang['officer'],'','center');
	$report->addOutputColumn('DtK', '<img src="templates/' . $phpraid_config['template'] . '/images/classes/deathknight_icon.gif" border="0" height="18" width="18" onMouseover="ddrivetip(\'' . $phprlang['sort_text'] . $phprlang['deathknight'] . '\');" onMouseout="hideddrivetip();" alt="death knight">', '', 'center');
	$report->addOutputColumn('Dru', '<img src="templates/' . $phpraid_config['template'] . '/images/classes/druid_icon.gif" border="0" height="18" width="18" onMouseover="ddrivetip(\'' . $phprlang['sort_text'] . $phprlang['druid'] . '\');" onMouseout="hideddrivetip();" alt="druid">', '', 'center');
	$report->addOutputColumn('Hun', '<img src="templates/' . $phpraid_config['template'] . '/images/classes/hunter_icon.gif" border="0" height="18" width="18" onMouseover="ddrivetip(\'' . $phprlang['sort_text'] . $phprlang['hunter'] . '\');" onMouseout="hideddrivetip();" alt="hunter">', '', 'center');
	$report->addOutputColumn('Mag', '<img src="templates/' . $phpraid_config['template'] . '/images/classes/mage_icon.gif" border="0" height="18" width="18" onMouseover="ddrivetip(\'' . $phprlang['sort_text'] . $phprlang['mage'] . '\');" onMouseout="hideddrivetip();" alt="mage">', '', 'center');
	$report->addOutputColumn('Pal', '<img src="templates/' . $phpraid_config['template'] . '/images/classes/paladin_icon.gif" border="0" height="18" width="18" onMouseover="ddrivetip(\'' . $phprlang['sort_text'] . $phprlang['paladin'] . '\');" onMouseout="hideddrivetip();" alt="paladin">', '', 'center');
	$report->addOutputColumn('Pri', '<img src="templates/' . $phpraid_config['template'] . '/images/classes/priest_icon.gif" border="0" height="18" width="18" onMouseover="ddrivetip(\'' . $phprlang['sort_text'] . $phprlang['priest'] . '\');" onMouseout="hideddrivetip();" alt="priest">', '', 'center');
	$report->addOutputColumn('Rog', '<img src="templates/' . $phpraid_config['template'] . '/images/classes/rogue_icon.gif" border="0" height="18" width="18" onMouseover="ddrivetip(\'' . $phprlang['sort_text'] . $phprlang['rogue'] . '\');" onMouseout="hideddrivetip();" alt="rogue">', '', 'center');
	$report->addOutputColumn('Sha', '<img src="templates/' . $phpraid_config['template'] . '/images/classes/shaman_icon.gif" border="0" height="18" width="18" onMouseover="ddrivetip(\'' . $phprlang['sort_text'] . $phprlang['shaman'] . '\');" onMouseout="hideddrivetip();" alt="shaman">', '', 'center');
	$report->addOutputColumn('Wlk', '<img src="templates/' . $phpraid_config['template'] . '/images/classes/warlock_icon.gif" border="0" height="18" width="18" onMouseover="ddrivetip(\'' . $phprlang['sort_text'] . $phprlang['warlock'] . '\');" onMouseout="hideddrivetip();" alt="warlock">', '', 'center');
	$report->addOutputColumn('War', '<img src="templates/' . $phpraid_config['template'] . '/images/classes/warrior_icon.gif" border="0" height="18" width="18" onMouseover="ddrivetip(\'' . $phprlang['sort_text'] . $phprlang['warrior'] . '\');" onMouseout="hideddrivetip();" alt="warrior">', '', 'center');
	if ($phpraid_config['role1_name'] != '')
		$report->addOutputColumn('role1',$phpraid_config['role1_name'],'','center');
	if ($phpraid_config['role2_name'] != '')
		$report->addOutputColumn('role2',$phpraid_config['role2_name'],'','center');
	if ($phpraid_config['role3_name'] != '')
		$report->addOutputColumn('role3',$phpraid_config['role3_name'],'','center');
	if ($phpraid_config['role4_name'] != '')
		$report->addOutputColumn('role4',$phpraid_config['role4_name'],'','center');
	if ($phpraid_config['role5_name'] != '')
		$report->addOutputColumn('role5',$phpraid_config['role5_name'],'','center');
	if ($phpraid_config['role6_name'] != '')
		$report->addOutputColumn('role6',$phpraid_config['role6_name'],'','center');
	$report->addOutputColumn('Max',$phprlang['totals'],'','center');
	$report->addOutputColumn('','','','right');

	// and finally, put the data into the variables to be read
	$current = $report->getListFromArray($current);
	$previous = $report->getListFromArray($previous);
	$page->set_file(array(
		'output' => $phpraid_config['template'] . '/raids.htm')
	);

	$page->set_var(
		array(
			'new_raid_link' => $new_raid_link,
			'old_raids' => $previous,
			'new_raids' => $current,
			'old_raids_header' => $phprlang['raids_old'],
			'new_raids_header' => $phprlang['raids_new']
		)
	);
}
elseif($_GET['mode'] == 'new' || $_GET['mode'] == 'edit')
{
	// error checking, goes before the output so we can show the error at the top and allow them to fix the errors without pressing back
	if(isset($_POST['submit']))
	{
		$location = scrub_input($_POST['location']);
		$date = str_replace(" ", "", scrub_input($_POST['date']));
		$tag = scrub_input($_POST['tag']);
		if ($tag == '')
			$tag = "1";
		$description = scrub_input($_POST['description']);
		$max = scrub_input($_POST['max']);
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
		$role2 = scrub_input($_POST['role2']);
		$role3 = scrub_input($_POST['role3']);
		$role4 = scrub_input($_POST['role4']);
		$role5 = scrub_input($_POST['role5']);
		$role6 = scrub_input($_POST['role6']);		
		
		//~@@**** Change - Douglas Wagner, 6/23/2007 ****
		//Allowing for a Blank Raid Description.  This shouldn't be a required field.  The field is still checked but if it isn't there
		//   the descripton is manually set to "None" and we move on.
//		if($location == "" || $date == "" || $description == "" || $max == "" || $min_lvl == "" || $max_lvl == "" ||$dr == "" ||
//		   $hu == "" || $ma == "" || $pa == "" || $pr == "" || $ro == "" || $sh == "" || $wk == "" || $wa == "" || !is_numeric($max) || !is_numeric($min_lvl) ||
//		   !is_numeric($max_lvl) || !is_numeric($dr) || !is_numeric($hu) || !is_numeric($ma) || !is_numeric($pa) || !is_numeric($pr) || !is_numeric($ro) || !is_numeric($sh) ||
//		   !is_numeric($wk) || !is_numeric($wa))

		// Check Role Numbers
		$bad_role_limit = FALSE;
		if($phpraid_config['role1_name'] != '')
			if (!is_numeric($role1))
				$bad_role_limit = TRUE;
		if($phpraid_config['role2_name'] != '')
			if (!is_numeric($role2))
				$bad_role_limit = TRUE;
		if($phpraid_config['role3_name'] != '')
			if (!is_numeric($role3))
				$bad_role_limit = TRUE;
		if($phpraid_config['role4_name'] != '')
			if (!is_numeric($role4))
				$bad_role_limit = TRUE;
		if($phpraid_config['role5_name'] != '')
			if (!is_numeric($role5))
				$bad_role_limit = TRUE;
		if($phpraid_config['role6_name'] != '')
			if (!is_numeric($role6))
				$bad_role_limit = TRUE;
		if($location == "" || $date == "" || $max == "" || $min_lvl == "" || $max_lvl == "" ||
		   $dk == "" || $dr == "" || $hu == "" || $ma == "" || $pa == "" || $pr == "" || $ro == "" || $sh == "" || $wk == "" || $wa == "" ||
		   !is_numeric($max) || !is_numeric($min_lvl) || !is_numeric($max_lvl) ||
		   !is_numeric($dk) || !is_numeric($dr) || !is_numeric($hu) || !is_numeric($ma) || !is_numeric($pa) || !is_numeric($pr) || !is_numeric($ro) || !is_numeric($sh) || !is_numeric($wk) || !is_numeric($wa) ||
		   $bad_role_limit)
		{
			$errorTitle = $phprlang['form_error'];
			$errorSpace = 1;
			$errorMsg = '<ul>';
			if($location == "")
				$errorMsg .= '<li>' . $phprlang['raid_error_location'] . '</li>';

			if($date == "")
				$errorMsg .= '<li>' . $phprlang['raid_error_date'] . '</li>';

			if($max == "" || $min_lvl == "" || $max_lvl == "" ||
			$dk == "" || $dr == "" || $hu == "" || $ma == "" || $pa == "" || $pr == "" || $ro == "" || $sh == ""  || $wk == "" || $wa == "" ||
			!is_numeric($max) || !is_numeric($min_lvl) || !is_numeric($max_lvl) ||
			!is_numeric($dk) || !is_numeric($dr) || !is_numeric($hu) || !is_numeric($ma) || !is_numeric($pa) ||!is_numeric($pr) || !is_numeric($ro) || !is_numeric($sh) || !is_numeric($wk) || !is_numeric($wa) ||
			$bad_role_limit)
				$errorMsg .= '<li>' . $phprlang['raid_error_limits'] . '</li>';
		}
		if($description == "")				//Moved
		{									//Added
        	$description="-";			//Change
        	$_POST['description']="-";	//Added
		}

	}

	//Normal fetch location
	if(isset($_GET['location']))
	{
		$location = scrub_input($_GET['location']);
		if ($priv_raids == 1)
		{
			$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "locations WHERE name=%s", quote_smart($location));
			$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
			$data = $db_raid->sql_fetchrow($result, true);
		}
		else
		{
			$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "locations WHERE name=%s and locked='0'", quote_smart($location));
			$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
			$data = $db_raid->sql_fetchrow($result, true);
		}

		$tag = $data['event_type'];
		$max = $data['max'];
		$dk = $data['dk'];
		$dr = $data['dr'];
		$hu = $data['hu'];
		$ma = $data['ma'];
		$pa = $data['pa'];
		$pr = $data['pr'];
		$ro = $data['ro'];
		$sh = $data['sh'];
		$wk = $data['wk'];
		$wa = $data['wa'];
		$role1 = $data['role1'];
		$role2 = $data['role2'];
		$role3 = $data['role3'];
		$role4 = $data['role4'];
		$role5 = $data['role5'];
		$role6 = $data['role6'];
		$min_lvl_value = $data['min_lvl'];
		$max_lvl_value = $data['max_lvl'];
		$location_value = $data['location'];
	}

	if(!isset($_POST['submit']) || isset($errorTitle))
	{
		// setup the form action first
		if(isset($_GET['mode']) && $_GET['mode'] == 'new')
		{
			$form_action = 'raids.php?mode=new';
		}
		elseif(isset($_GET['mode']) && $_GET['mode'] == 'edit')
		{
			$id = scrub_input($_GET['id']);
			$form_action = 'raids.php?mode=edit&amp;id='. $id;
		}

 		// and if it's an edit, grab straight from the raids database instead
		if($_GET['mode'] == 'edit')
		{
			// if so, grab values from database
			if(isset($_GET['location']))
			{
				$location = scrub_input($_GET['location']);
				if ($priv_raids == 1)
				{
					$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "locations WHERE name=%s", quote_smart($location));
					$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
					$data = $db_raid->sql_fetchrow($result, true);
				}
				else
				{
					$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "locations WHERE name=%s and locked='0'", quote_smart($location));
					$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
					$data = $db_raid->sql_fetchrow($result, true);
				}

				$tag = $data['event_type'];
	            $max = $data['max'];
	            $dk = $data['dk'];
			    $dr = $data['dr'];
			    $hu = $data['hu'];
			    $ma = $data['ma'];
			    $pa = $data['pa'];
			    $pr = $data['pr'];
			    $ro = $data['ro'];
			    $sh = $data['sh'];
			    $wk = $data['wk'];
			    $wa = $data['wa'];
				$role1 = $data['role1'];
				$role2 = $data['role2'];
				$role3 = $data['role3'];
				$role4 = $data['role4'];
				$role5 = $data['role5'];
				$role6 = $data['role6'];
	            $min_lvl_value = $data['min_lvl'];
	            $max_lvl_value = $data['max_lvl'];
	            $location_value = UBB2($data['location']);
	
	            $id = scrub_input($_GET['id']);
	            $sql2 = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "raids WHERE raid_id=%s", quote_smart($id));
	            $result2 = $db_raid->sql_query($sql2) or print_error($sql2, mysql_error(), 1);
	            $data2 = $db_raid->sql_fetchrow($result2, true);
	            
	            $date_value = new_date("m/d/Y",$data2['start_time'],$phpraid_config['timezone'] + $phpraid_config['dst']);
				if ($phpraid_config['ampm'] == '12')
	            	$i_time_hour_value = new_date("h",$data2['invite_time'],$phpraid_config['timezone'] + $phpraid_config['dst']);
	            else
	            	$i_time_hour_value = new_date("H",$data2['invite_time'],$phpraid_config['timezone'] + $phpraid_config['dst']);	            	
	            $i_time_minute_value = new_date("i",$data2['invite_time'],$phpraid_config['timezone'] + $phpraid_config['dst']);
	            $i_time_ampm_value = new_date("a",$data2['invite_time'],$phpraid_config['timezone'] + $phpraid_config['dst']);
				if ($phpraid_config['ampm'] == '12')
	            	$s_time_hour_value = new_date("h",$data2['start_time'],$phpraid_config['timezone'] + $phpraid_config['dst']);
	            else
   		            $s_time_hour_value = new_date("H",$data2['start_time'],$phpraid_config['timezone'] + $phpraid_config['dst']);
	            $s_time_minute_value = new_date("i",$data2['start_time'],$phpraid_config['timezone'] + $phpraid_config['dst']);
	            $s_time_ampm_value = new_date("a",$data2['start_time'],$phpraid_config['timezone'] + $phpraid_config['dst']);
	            $freeze_value = $data2['freeze'];
	            $description_value = UBB2($data2['description']);
			}
			else
			{
	         	$id = scrub_input($_GET['id']);
	            $sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "raids WHERE raid_id=%s", quote_smart($id));
	            $result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
	            $data = $db_raid->sql_fetchrow($result, true);
	            
	            $tag = $data['event_type'];
	            $max = $data['max'];
	            $dk = $data['dk_lmt'];
	            $dr = $data['dr_lmt'];
	            $hu = $data['hu_lmt'];
	            $ma = $data['ma_lmt'];
			    $pa = $data['pa_lmt'];
	            $pr = $data['pr_lmt'];
	            $ro = $data['ro_lmt'];
	            $sh = $data['sh_lmt'];
	            $wk = $data['wk_lmt'];
	            $wa = $data['wa_lmt'];
				$role1 = $data['role1_lmt'];
				$role2 = $data['role2_lmt'];
				$role3 = $data['role3_lmt'];
				$role4 = $data['role4_lmt'];
				$role5 = $data['role5_lmt'];
				$role6 = $data['role6_lmt'];
	            $min_lvl_value = $data['min_lvl'];
	            $max_lvl_value = $data['max_lvl'];
	            $location_value = UBB2($data['location']);
	            $date_value = new_date("m/d/Y",$data['start_time'],$phpraid_config['timezone'] + $phpraid_config['dst']);
				if ($phpraid_config['ampm'] == '12')
	            	$i_time_hour_value = new_date("h",$data['invite_time'],$phpraid_config['timezone'] + $phpraid_config['dst']);
	            else
	            	$i_time_hour_value = new_date("H",$data['invite_time'],$phpraid_config['timezone'] + $phpraid_config['dst']);	            	
	            $i_time_minute_value = new_date("i",$data['invite_time'],$phpraid_config['timezone'] + $phpraid_config['dst']);
	            $i_time_ampm_value = new_date("a",$data['invite_time'],$phpraid_config['timezone'] + $phpraid_config['dst']);
				if ($phpraid_config['ampm'] == '12')
	            	$s_time_hour_value = new_date("h",$data['start_time'],$phpraid_config['timezone'] + $phpraid_config['dst']);
	            else
	            	$s_time_hour_value = new_date("H",$data['start_time'],$phpraid_config['timezone'] + $phpraid_config['dst']);
	            $s_time_minute_value = new_date("i",$data['start_time'],$phpraid_config['timezone'] + $phpraid_config['dst']);
	            $s_time_ampm_value = new_date("a",$data['start_time'],$phpraid_config['timezone'] + $phpraid_config['dst']);
	            $freeze_value = $data['freeze'];
	            $description_value = UBB2($data['description']);
			}
      	}
		elseif(isset($_POST['submit']))
		{
			// or it could be they screwed up the form, let's put those values back in because we're nice like that
			$tag = scrub_input($_POST['tag']);
			$max = scrub_input($_POST['max']);
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
			$role1 = $data['role1'];
			$role2 = $data['role2'];
			$role3 = $data['role3'];
			$role4 = $data['role4'];
			$role5 = $data['role5'];
			$role6 = $data['role6'];
			$min_lvl_value = scrub_input($_POST['min_lvl']);
			$max_lvl_value = scrub_input($_POST['max_lvl']);
			$location_value = scrub_input($_POST['location']);
			$date_value = scrub_input($_POST['date']);
			$i_time_hour_value = scrub_input($_POST['i_time_hour']);
			$i_time_minute_value = scrub_input($_POST['i_time_minute']);
			$i_time_ampm_value = scrub_input($_POST['i_time_ampm']);
			$s_time_hour_value = scrub_input($_POST['s_time_hour']);
			$s_time_minute_value = scrub_input($_POST['s_time_minute']);
			$s_time_ampm_value = scrub_input($_POST['s_time_ampm']);
			$freeze_value = scrub_input($_POST['freeze']);
			$description_value = scrub_input($_POST['description']);
		}

		// now for the actual form elements
		if(isset($date_value))
			$date = '<input type="text" name="date" size="20" class="post" READONLY value="' . $date_value . '"><a href="javascript:showCal(\'Calendar1\')"><span class="gen"> [+]</span></a>';
		else
			$date = '<input type="text" name="date" size="20" class="post" READONLY><a href="javascript:showCal(\'Calendar1\')"><span class="gen"> [+]</span></a>';

		// invite time
		$i_time_hour = '<select name="i_time_hour" class="post">';
		for($i = 1; $i <= $phpraid_config['ampm']; $i++)
		{
			if($i < 10)
				$i_string = '0' . $i;
			else
				$i_string = $i;

			if(isset($i_time_hour_value) && $i_string == $i_time_hour_value)
				$i_time_hour .= '<option value="' . $i_string . '" selected>' . $i_string . '</option>';
			else
				$i_time_hour .= '<option value="' . $i_string . '">' . $i_string . '</option>';
		}
		$i_time_hour .= '</select>';

		//~@@Change: Douglas Wagner - 6/23/2007
		// This code reduces the selections in the "minute" selection boxes.  We want a 15 minute granularity, not a 1 minute granularity.
		$i_time_minute = '<select name="i_time_minute" class="post">';
		for($i = 0; $i < 60; $i++)
		{
			$ifloor=$i/15;					//Added
			if(($ifloor) == floor($ifloor)) //Added
			{								//Added
				if($i < 10)
					$i_string = '0' . $i;
				else
					$i_string = $i;

				if(isset($i_time_minute_value) && $i_string == $i_time_minute_value)
					$i_time_minute .= '<option value="' . $i_string . '" selected>' . $i_string . '</option>';
				else
					$i_time_minute .= '<option value="' . $i_string . '">' . $i_string . '</option>';
			} 								//Added
		}
		$i_time_minute .= '</select>';

		if ($phpraid_config['ampm'] == '12')
		{
			$i_time_ampm = '<select name="i_time_ampm" class="post">';
			if(isset($i_time_ampm_value) && $i_time_ampm_value == 'am')
			{
				$i_time_ampm .= '<option value="am" selected>am</option><option value="pm">pm</option>';
			}
			elseif(isset($i_time_ampm_value) && $i_time_ampm_value == 'pm')
			{
				$i_time_ampm .= '<option value="am">am</option><option value="pm" selected>pm</option>';
			}
			else
			{
				$i_time_ampm .= '<option value="am">am</option><option value="pm" selected>pm</option>';
			}
			$i_time_ampm .= '</select>';
			// end of invite time
		}
		
		// start time
		$s_time_hour = '<select name="s_time_hour" class="post">';
		for($i = 1; $i <= $phpraid_config['ampm']; $i++)
		{
			if($i < 10)
				$s_string = '0' . $i;
			else
				$s_string = $i;

			if(isset($s_time_hour_value) && $s_string == $s_time_hour_value)
				$s_time_hour .= '<option value="' . $s_string . '" selected>' . $s_string . '</option>';
			else
				$s_time_hour .= '<option value="' . $s_string . '">' . $s_string . '</option>';
		}
		$s_time_hour .= '</select>';

		//~@@Change: Douglas Wagner - 6/23/2007
		// This code reduces the selections in the "minute" selection boxes.  We want a 15 minute granularity, not a 1 minute granularity.
		$s_time_minute = '<select name="s_time_minute" class="post">';
		for($i = 0; $i < 60; $i++)
		{
			$ifloor=$i/15;					//Added
			if(($ifloor) == floor($ifloor)) //Added
			{								//Added
				if($i < 10)
					$s_string = '0' . $i;
				else
					$s_string = $i;

				if(isset($s_time_minute_value) && $s_string == $s_time_minute_value)
					$s_time_minute .= '<option value="' . $s_string . '" selected>' . $s_string . '</option>';
				else
					$s_time_minute .= '<option value="' . $s_string . '">' . $s_string . '</option>';
			} 								//Added
		}
		$s_time_minute .= '</select>';

		if ($phpraid_config['ampm'] == '12')
		{
			$s_time_ampm = '<select name="s_time_ampm" class="post">';
			if(isset($s_time_ampm_value) && $s_time_ampm_value == 'am')
			{
				$s_time_ampm .= '<option value="am" selected>am</option><option value="pm">pm</option>';
			}
			elseif(isset($s_time_ampm_value) && $s_time_ampm_value == 'pm')
			{
				$s_time_ampm .= '<option value="am">am</option><option value="pm" selected>pm</option>';
			}
			else
			{
				$s_time_ampm .= '<option value="am">am</option><option value="pm" selected>pm</option>';
			}
			$s_time_ampm .= '</select>';
			// end of start time
		}
		
		// freeze
		$freeze = '<select name="freeze" class="post">';
		for($i = 0; $i <= 24; $i++)
		{
			if(isset($freeze_value) && $i == $freeze_value)
				$freeze .= '<option value="' . $i . '" selected>' . $i . '</option>';
			else
				$freeze .= '<option value="' . $i . '">' . $i . '</option>';
		}
		$freeze .= '</select>';

		// Event Type for WoW Calendar
		$freeze = '<select name="tag" class="post">';
		$freeze .= '<option value="1" selected>' . $i . '</option>';
		$freeze .= '<option value="2" selected>' . $i . '</option>';
		$freeze .= '<option value="3" selected>' . $i . '</option>';
		$freeze .= '<option value="4" selected>' . $i . '</option>';
		$freeze .= '<option value="5" selected>' . $i . '</option>';
		$freeze .= '</select>';
		
		// location
		if(isset($location_value))
			$location = '<input type="text" name="location" class="post" value="' . $location_value . '">';
		else
			$location = '<input type="text" name="location" class="post">';

		// setup vars for raid templates
		$raid_name = '<select name="name" id="name" class="post" onChange="MM_jumpMenu(\'parent\',this,0)">
					<option value=""></option>';

		if ($priv_raids == 1)
		{
			$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "locations ORDER BY name";
			$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
		}
		else
		{
			$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "locations WHERE locked='0' ORDER BY name";
			$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
		}
		while($data = $db_raid->sql_fetchrow($result, true))
		{
			if (isset($_GET['location'])) {
			   $raid_location = scrub_input($_GET['location']);
			} else {
			   $raid_location = '';
			}
			if (isset($_GET['mode'])) {
			   $raid_mode = scrub_input($_GET['mode']);
			} else {
			   $raid_mode = '';
			}
			if (isset($_GET['id'])) {
			   $raid_id = scrub_input($_GET['id']);
			} else {
			   $raid_id = '';
			}
			if($raid_location == $data['name'])
			{
			   if($raid_mode == 'edit')
				  $raid_name .= '<option value="raids.php?mode=edit&amp;id=' . $raid_id . '&location=' . $data['name'] .'" selected>' . $data['name'] . '</option>';
			   else
				  $raid_name .= '<option value="raids.php?mode=new' . $raid_id  . '&location=' . $data['name'] .'" selected>' . $data['name'] . '</option>';
			}
			else
			{
			   if($raid_mode == 'edit')
				  $raid_name .= '<option value="raids.php?mode=edit&amp;id=' . $raid_id . '&location=' . $data['name'] .'">' . $data['name'] . '</option>';
			   else
				  $raid_name .= '<option value="raids.php?mode=new' . $raid_id . '&location=' . $data['name'] .'">' . $data['name'] . '</option>';
			}
		 }
		 $raid_name .= '</select>';

		// description
		if(isset($description_value))
			$description = '<textarea name="description" cols="50" rows="10" wrap="PHYSICAL" class="post" id="message" style="width:300;height:150">' . $description_value . '</textarea>';
		else
			$description = '<textarea name="description" cols="50" rows="10" wrap="PHYSICAL" class="post" id="message" style="width:300;height:150"></textarea>';

		// limits
		if(isset($min_lvl_value)) {
			$maximum = '<input name="max" type="text" class="post" style="width:20px" value="' . $max . '" maxlength="2">';
			$minimum_level = '<input name="min_lvl" type="text" class="post" style="width:20px" value="' . $min_lvl_value . '" maxlength="2">';
			$maximum_level =  '<input name="max_lvl" type="text" class="post" style="width:20px" value="' . $max_lvl_value . '" maxlength="2">';
			$deathknight_limit = '<input name="dk" type="text" class="post" style="width:20px" value="' . $dk . '" maxlength="2">';
			$druid_limit = '<input name="dr" type="text" class="post" style="width:20px" value="' . $dr . '" maxlength="2">';
			$hunter_limit = '<input name="hu" type="text" class="post" style="width:20px" value="' . $hu . '" maxlength="2">';
			$mage_limit = '<input name="ma" type="text" class="post" style="width:20px" value="' . $ma . '" maxlength="2">';
			$paladin_limit = '<input name="pa" type="text" class="post" style="width:20px" value="' . $pa . '" maxlength="2">';
			$priest_limit = '<input name="pr" type="text" class="post" style="width:20px" value="' . $pr . '" maxlength="2">';
			$rogue_limit = '<input name="ro" type="text" class="post" style="width:20px" value="' . $ro . '" maxlength="2">';
			$shaman_limit = '<input name="sh" type="text" class="post" style="width:20px" value="' . $sh . '" maxlength="2">';
			$warlock_limit = '<input name="wk" type="text" class="post" style="width:20px" value="' . $wk . '" maxlength="2">';
			$warrior_limit = '<input name="wa" type="text" class="post" style="width:20px" value="' . $wa . '" maxlength="2">';
			if ($phpraid_config['role1_name'] != '')
				$role1_limit = '<input name="role1" type="text" class="post" style="width:20px" value="' . $role1 . '" maxlength="2">';
			else
				$role1_limit = '<input name="role1" type="hidden" value="" class="post" style="width:20px" maxlength="2">';
			if ($phpraid_config['role2_name'] != '')
				$role2_limit = '<input name="role2" type="text" class="post" style="width:20px" value="' . $role2 . '" maxlength="2">';
			else
				$role2_limit = '<input name="role2" type="hidden" value="" class="post" style="width:20px" maxlength="2">';
			if ($phpraid_config['role3_name'] != '')
				$role3_limit = '<input name="role3" type="text" class="post" style="width:20px" value="' . $role3 . '" maxlength="2">';
			else
				$role3_limit = '<input name="role3" type="hidden" value="" class="post" style="width:20px" maxlength="2">';
			if ($phpraid_config['role4_name'] != '')
				$role4_limit = '<input name="role4" type="text" class="post" style="width:20px" value="' . $role4 . '" maxlength="2">';
			else
				$role4_limit = '<input name="role4" type="hidden" value="" class="post" style="width:20px" maxlength="2">';
			if ($phpraid_config['role5_name'] != '')
				$role5_limit = '<input name="role5" type="text" class="post" style="width:20px" value="' . $role5 . '" maxlength="2">';
			else
				$role5_limit = '<input name="role5" type="hidden" value="" class="post" style="width:20px" maxlength="2">';
			if ($phpraid_config['role6_name'] != '')
				$role6_limit = '<input name="role6" type="text" class="post" style="width:20px" value="' . $role6 . '" maxlength="2">';
			else
				$role6_limit = '<input name="role6" type="hidden" value="" class="post" style="width:20px" maxlength="2">';			$tank_limit = '<input name="tank" type="text" class="post" style="width:20px" value="' . $tank . '" maxlength="2">';
		} else {
			$maximum = '<input name="max" type="text" class="post" style="width:20px" maxlength="2">';
			$minimum_level = '<input name="min_lvl" type="text" class="post" style="width:20px" maxlength="2">';
			$maximum_level =  '<input name="max_lvl" type="text" class="post" style="width:20px" maxlength="2">';
			$deathknight_limit = '<input name="dk" type="text" class="post" style="width:20px" maxlength="2">';
			$druid_limit = '<input name="dr" type="text" class="post" style="width:20px" maxlength="2">';
			$hunter_limit = '<input name="hu" type="text" class="post" style="width:20px" maxlength="2">';
			$mage_limit = '<input name="ma" type="text" class="post" style="width:20px" maxlength="2">';
			$paladin_limit = '<input name="pa" type="text" class="post" style="width:20px" maxlength="2">';
			$priest_limit = '<input name="pr" type="text" class="post" style="width:20px" maxlength="2">';
			$rogue_limit = '<input name="ro" type="text" class="post" style="width:20px" maxlength="2">';
			$shaman_limit = '<input name="sh" type="text" class="post" style="width:20px" maxlength="2">';
			$warlock_limit = '<input name="wk" type="text" class="post" style="width:20px" maxlength="2">';
			$warrior_limit = '<input name="wa" type="text" class="post" style="width:20px" maxlength="2">';
			if ($phpraid_config['role1_name'] != '')
				$role1_limit = '<input name="role1" type="text" class="post" style="width:20px" maxlength="2">';
			else
				$role1_limit = '<input name="role1" type="hidden" value="" class="post" style="width:20px" maxlength="2">';
			if ($phpraid_config['role2_name'] != '')
				$role2_limit = '<input name="role2" type="text" class="post" style="width:20px" maxlength="2">';
			else
				$role2_limit = '<input name="role2" type="hidden" value="" class="post" style="width:20px" maxlength="2">';
			if ($phpraid_config['role3_name'] != '')
				$role3_limit = '<input name="role3" type="text" class="post" style="width:20px" maxlength="2">';
			else
				$role3_limit = '<input name="role3" type="hidden" value="" class="post" style="width:20px" maxlength="2">';
			if ($phpraid_config['role4_name'] != '')
				$role4_limit = '<input name="role4" type="text" class="post" style="width:20px" maxlength="2">';
			else
				$role4_limit = '<input name="role4" type="hidden" value="" class="post" style="width:20px" maxlength="2">';
			if ($phpraid_config['role5_name'] != '')
				$role5_limit = '<input name="role5" type="text" class="post" style="width:20px" maxlength="2">';
			else
				$role5_limit = '<input name="role5" type="hidden" value="" class="post" style="width:20px" maxlength="2">';
			if ($phpraid_config['role6_name'] != '')
				$role6_limit = '<input name="role6" type="text" class="post" style="width:20px" maxlength="2">';
			else
				$role6_limit = '<input name="role6" type="hidden" value="" class="post" style="width:20px" maxlength="2">';
		}
		$buttons = '<input type="submit" name="submit" value="'.$phprlang['submit'].'" class="mainoption"> <input type="reset" name="reset" value="'.$phprlang['reset'].'" class="liteoption">';			
		
		$page->set_file('output',$phpraid_config['template'] . '/raids_new.htm');
		$page->set_var(
			array(
				'buttons'=>$buttons,
				'form_action'=>$form_action,
				'raid_name'=>$raid_name,
				'date'=>$date,
				'i_time_hour'=>$i_time_hour,
				'i_time_minute'=>$i_time_minute,
				'i_time_ampm'=>$i_time_ampm,
				's_time_hour'=>$s_time_hour,
				's_time_minute'=>$s_time_minute,
				's_time_ampm'=>$s_time_ampm,
				'freeze'=>$freeze,
				'location'=>$location,
				'description'=>$description,
				'maximum'=>$maximum,
				'minimum_level'=>$minimum_level,
				'maximum_level'=>$maximum_level,
				'deathknight_limit'=>$deathknight_limit,
				'druid_limit'=>$druid_limit,
				'hunter_limit'=>$hunter_limit,
				'mage_limit'=>$mage_limit,
				'paladin_limit'=>$paladin_limit,
				'priest_limit'=>$priest_limit,
				'rogue_limit'=>$rogue_limit,
				'shaman_limit'=>$shaman_limit,
				'warlock_limit'=>$warlock_limit,
				'warrior_limit'=>$warrior_limit,
				'role1_limit'=>$role1_limit,
				'role2_limit'=>$role2_limit,
				'role3_limit'=>$role3_limit,
				'role4_limit'=>$role4_limit,
				'role5_limit'=>$role5_limit,
				'role6_limit'=>$role6_limit,
				'dungeon_text'=>$phprlang['raids_dungeon'],
				'date_text'=>$phprlang['raids_date'],
				'raids_new'=>$phprlang['raids_new_header'],
				'invite_text'=>$phprlang['raids_invite'],
				'start_text'=>$phprlang['raids_start'],
				'freeze_text'=>$phprlang['raids_freeze'],
				'location_text'=>$phprlang['raids_location'],
				'description_text'=>$phprlang['raids_description'],
				'limits_text'=>$phprlang['raids_limits'],
				'max_text'=>$phprlang['raids_max'],
				'minlvl_text'=>$phprlang['raids_min_lvl'],
				'maxlvl_text'=>$phprlang['raids_max_lvl'],
				'deathknight_text'=>$phprlang['deathknight'],
				'druid_text'=>$phprlang['druid'],
				'hunter_text'=>$phprlang['hunter'],
				'mage_text'=>$phprlang['mage'],
				'paladin_text'=>$phprlang['paladin'],
				'priest_text'=>$phprlang['priest'],
				'rogue_text'=>$phprlang['rogue'],
				'shaman_text'=>$phprlang['shaman'],
				'warlock_text'=>$phprlang['warlock'],
				'warrior_text'=>$phprlang['warrior'],
				'role1_text'=>$phpraid_config['role1_name'],
				'role2_text'=>$phpraid_config['role2_name'],
				'role3_text'=>$phpraid_config['role3_name'],
				'role4_text'=>$phpraid_config['role4_name'],
				'role5_text'=>$phpraid_config['role5_name'],
				'role6_text'=>$phpraid_config['role6_name']
			)
		);
	}
	else
	{
		// holy crap, time to put it into the database
		// variables first
		$max = scrub_input($_POST['max']);
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
		$min_lvl = scrub_input($_POST['min_lvl']);
		$max_lvl = scrub_input($_POST['max_lvl']);

		$location = scrub_input(DEUBB($_POST['location']));

		$date = scrub_input($_POST['date']);
		$i_time_hour_value = scrub_input($_POST['i_time_hour']);
		$i_time_minute_value = scrub_input($_POST['i_time_minute']);
		$i_time_ampm_value = scrub_input($_POST['i_time_ampm']);
		$s_time_hour_value = scrub_input($_POST['s_time_hour']);
		$s_time_minute_value = scrub_input($_POST['s_time_minute']);
		$s_time_ampm_value = scrub_input($_POST['s_time_ampm']);
		$freeze = scrub_input($_POST['freeze']);
		$description = scrub_input(DEUBB($_POST['description']));
		if(isset($_GET['id']))
			$id = scrub_input($_GET['id']);
		else
			$id = '';

		// setup the date, probably the only tricky tricky part :D
		$month = substr($date,0,2);
		$day = substr($date,3,2);
		$year = substr($date,6,4);

		if($i_time_ampm_value == 'pm' && $i_time_hour_value < 12)
			$i_time_hour_value += 12;

		if($s_time_ampm_value == 'pm' && $s_time_hour_value < 12)
			$s_time_hour_value += 12;

		$invite_time = new_mktime($i_time_hour_value,$i_time_minute_value,0,$month,$day,$year,$phpraid_config['timezone'] + $phpraid_config['dst']);
		$start_time = new_mktime($s_time_hour_value,$s_time_minute_value,0,$month,$day,$year,$phpraid_config['timezone'] + $phpraid_config['dst']);

		if($_GET['mode'] == 'new')
		{
			$sql = sprintf("INSERT INTO " . $phpraid_config['db_prefix'] . "raids (`description`,`freeze`,`invite_time`,
					`location`,`officer`,`old`,`start_time`,`dk_lmt`,`dr_lmt`,`hu_lmt`,`ma_lmt`,`pa_lmt`,`pr_lmt`,`ro_lmt`,`sh_lmt`,`wk_lmt`,`wa_lmt`,
					`role1_lmt`,`role2_lmt`,`role3_lmt`,`role4_lmt`,`role5_lmt`,`role6_lmt`,
					`min_lvl`,`max_lvl`,`max`)	VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)",
					quote_smart($description),quote_smart($freeze),quote_smart($invite_time),quote_smart($location),
					quote_smart($username),quote_smart('0'),quote_smart($start_time),
					quote_smart($dk),quote_smart($dr),quote_smart($hu),quote_smart($ma),quote_smart($pa),quote_smart($pr),quote_smart($ro),quote_smart($sh),
					quote_smart($wk),quote_smart($wa),quote_smart($role1),quote_smart($role2),quote_smart($role3),quote_smart($role4),
					quote_smart($role5),quote_smart($role6),quote_smart($min_lvl),quote_smart($max_lvl),quote_smart($max));

			$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);

			log_create('raid',mysql_insert_id(),$location);
		}
		else
		{
			$sql = sprintf("UPDATE " . $phpraid_config['db_prefix'] . "raids SET location=%s,description=%s,invite_time=%s,start_time=%s,
					freeze=%s,max=%s,old='0',dk_lmt=%s,dr_lmt=%s,hu_lmt=%s,ma_lmt=%s,pa_lmt=%s,pr_lmt=%s,ro_lmt=%s,sh_lmt=%s,wk_lmt=%s,wa_lmt=%s,
					role1_lmt=%s,role2_lmt=%s,role3_lmt=%s,role4_lmt=%s,role5_lmt=%s,role6_lmt=%s,min_lvl=%s,max_lvl=%s WHERE raid_id=%s",
					quote_smart($location),quote_smart($description),quote_smart($invite_time),quote_smart($start_time), quote_smart($freeze),
					quote_smart($max),quote_smart($dk),quote_smart($dr),quote_smart($hu),quote_smart($ma),quote_smart($pa),quote_smart($pr),quote_smart($ro),
					quote_smart($sh),quote_smart($wk),quote_smart($wa),quote_smart($role1),quote_smart($role2),quote_smart($role3),
					quote_smart($role4),quote_smart($role5),quote_smart($role6),quote_smart($min_lvl),quote_smart($max_lvl),quote_smart($id));

			$db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
		}
		header("Location: raids.php?mode=view");
	}
}
elseif($_GET['mode'] == 'delete')
{
	$id = scrub_input($_GET['id']);
	$n = scrub_input($_GET['n']);

	if(!isset($_POST['submit']))
	{
		$form_action = "raids.php?mode=delete&amp;n=$n&amp;id=$id";
		$confirm_button = '<input name="submit" type="submit" id="submit" value="'.$phprlang['confirm_deletion'].'" class="mainoption">';

		$page->set_file('output',$phpraid_config['template'] . '/delete.htm');
		$page->set_var(
			array(
				'form_action'=>$form_action,
				'confirm_button'=>$confirm_button,
				'delete_header'=>$phprlang['confirm_deletion'],
				'delete_msg'=>$phprlang['delete_msg'],
			)
		);
		$page->parse('output','output');
	}
	else
	{
		log_delete('raid',$n);

		$sql = sprintf("DELETE FROM " . $phpraid_config['db_prefix'] . "raids WHERE raid_id=%s", quote_smart($id));
		$db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);

		$sql = sprintf("DELETE FROM " . $phpraid_config['db_prefix'] . "signups WHERE raid_id=%s", quote_smart($id));
		$db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
		header("Location: raids.php?mode=view");
	}
}
elseif($_GET['mode'] == 'mark')
{
	$raid_id = scrub_input($_GET['id']);

	$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "raids WHERE raid_id=%s", quote_smart($raid_id));
	$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
	$data = $db_raid->sql_fetchrow($result, true);
	
	if($data['old'] == 1)
	{
		$sql = sprintf("UPDATE " . $phpraid_config['db_prefix'] . "raids SET old='0' WHERE raid_id=%s", quote_smart($raid_id));
		$db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
	}
	else
	{
		$sql = sprintf("UPDATE " . $phpraid_config['db_prefix'] . "raids SET old='1' WHERE raid_id=%s", quote_smart($raid_id));
		$db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
	}

	header("Location: raids.php?mode=view");
}

//
// Start output of page
//
require_once('includes/page_header.php');

$page->pparse('output','output');

require_once('includes/page_footer.php');
?>