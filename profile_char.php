<?php
/***************************************************************************
 *                             profile_char.php
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

/*************************************************************
 * Setup Record Output Information for Data Table
 *************************************************************/
// Set StartRecord for Page
if(!isset($_GET['Base']) || !is_numeric($_GET['Base']))
	$startRecord = 1;
else
	$startRecord = scrub_input($_GET['Base']);

// Set Sort Field for Page
if(!isset($_GET['Sort'])||$_GET['Sort']=='')
{
	$sortField="";
	$initSort=FALSE;
}
else
{
	$sortField = scrub_input($_GET['Sort']);
	$initSort=TRUE;
}
	
// Set Sort Descending Mark
if(!isset($_GET['SortDescending']) || !is_numeric($_GET['SortDescending']))
	$sortDesc = 0;
else
	$sortDesc = scrub_input($_GET['SortDescending']);
	
$pageURL = "profile_char.php";
$pageURL_edit = $pageURL. '?mode=edit&';
$pageURL_new = $pageURL. '?mode=new';
$pageURL_remove = $pageURL. '?mode=remove&';
$pageURL_view = $pageURL. '?mode=view&';

/**************************************************************
 * End Record Output Setup for Data Table
 **************************************************************/

if($_GET['mode'] == 'view') {
	$chars = array();
	
	// now that we have their profile_id, let's get a list of all their characters
	$profile_id = scrub_input($_SESSION['profile_id']);
	$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "chars WHERE profile_id=%s",quote_smart($profile_id));
	$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	while($data = $db_raid->sql_fetchrow($result, true))
	{
		// Get Armory Data for Character
		if ($phpraid_config['enable_armory'])
			$charname = get_armorychar($data['name'], $data['guild']);
		else
			$charname = $data['name'];
			
		// Get the Internationalized data to display from the database values:
		foreach ($wrm_global_races as $global_race)
			if ($data['race'] == $global_race['race_id'])
				$race = $phprlang[$global_race['lang_index']];

		foreach ($wrm_global_classes as $global_class)
			if ($data['class'] == $global_class['class_id'])
				$class = $phprlang[$global_class['lang_index']];
				
		// Get the Guild Name to Display instead of Just the ID
		$sql = sprintf("SELECT guild_name FROM " . $phpraid_config['db_prefix'] . "guilds WHERE guild_id=%s",quote_smart($data['guild']));
		$guild_result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
		$guild_data = $db_raid->sql_fetchrow($guild_result, true);
		$guild_name = $guild_data['guild_name'];
		
		$Buttons_tmp='<a href="'.$pageURL_remove.'char_name='.$data['name'].'&amp;char_id='.$data['char_id'].'"><img src="templates/' . $phpraid_config['template'] . '/images/icons/icon_delete.gif" border="0" onMouseover="ddrivetip(\''. $phprlang['delete'] .'\');" onMouseout="hideddrivetip();" alt="delete icon"></a>
					 <a href="'.$pageURL_edit.'char_id='.$data['char_id'].'&amp;guild='.$data['guild'].'&amp;race='.$data['race'].'&amp;class='.$data['class'].'"><img src="templates/' . $phpraid_config['template'] . '/images/icons/icon_edit.gif" border="0" onMouseover="ddrivetip(\'' . $phprlang['edit'] .'\');" onMouseout="hideddrivetip();" alt="edit icon"></a>';
		array_push($chars,
			array(
				'ID'=>$data['char_id'],
				'Name'=>$charname,
				'Guild'=>$guild_name,
				'Level'=>$data['lvl'],
				'Race'=>$race,
				'Class'=>$class,
				'Arcane'=>$data['arcane'],
				'Fire'=>$data['fire'],
				'Frost'=>$data['frost'],
				'Nature'=>$data['nature'],
				'Shadow'=>$data['shadow'],
				'Pri_Spec'=>$data['pri_spec'],
				'Sec_Spec'=>$data['sec_spec'],
				'Buttons'=>$Buttons_tmp,
			));
	}

	/**************************************************************
	 * Code to setup for a Dynamic Table Create: guild1 View.
	 **************************************************************/
	$viewName = 'char1';
	
	//Setup Columns
	$char_headers = array();
	$record_count_array = array();
	$char_headers = getVisibleColumns($viewName);

	//Get Record Counts
	$char_record_count_array = getRecordCounts($chars, $char_headers, $startRecord);
	
	//Get the Jump Menu and pass it down
	$charJumpMenu = getPageNavigation($chars, $startRecord, $pageURL, $sortField, $sortDesc);
			
	//Setup Default Data Sort from Headers Table
	if (!$initSort)
		foreach ($char_headers as $column_rec)
			if ($column_rec['default_sort'])
				$sortField = $column_rec['column_name'];

	//Setup Data
	$chars = paginateSortAndFormat($chars, $sortField, $sortDesc, $startRecord, $viewName);

	/****************************************************************
	 * Data Assign for Template.
	 ****************************************************************/
	$wrmsmarty->assign('char_data', $chars); 
	$wrmsmarty->assign('char_jump_menu', $charJumpMenu);
	$wrmsmarty->assign('char_column_name', $char_headers);
	$wrmsmarty->assign('char_record_counts', $char_record_count_array);
	
	$wrmsmarty->assign('header_data',
		array(
			'form_action' => $form_action,
			'template_name'=>$phpraid_config['template'],
			'character_header' => $phprlang['profile_header'],
			'raid_header' => $phprlang['profile_raid'],
			'sort_url_base' => $pageURL,
			'sort_descending' => $sortDesc,
			'sort_text' => $phprlang['sort_text'],
			'button_addchar' => $phprlang['addchar'],
		)
	);

	require_once('includes/page_header.php');
	$wrmsmarty->display('profile_char.html');
	require_once('includes/page_footer.php');
			
}
elseif($_GET['mode'] == 'remove') 
{
	$char_id = scrub_input($_GET['char_id']);
	$char_name = scrub_input($_GET['char_name']);
	$profile_id = scrub_input($_SESSION['profile_id']);

	if(!isset($_POST['submit']))
	{
		$form_action = $pageURL_remove . "char_name=".$char_name."&amp;char_id=".$char_id;
		$confirm_button = '<input name="submit" type="submit" id="submit" value="'.$phprlang['confirm_deletion'].'" class="mainoption">';

		$wrmsmarty->assign('page',
			array(
				'form_action'=>$form_action,
				'confirm_button'=>$confirm_button,
				'delete_header'=>$phprlang['confirm_deletion'],
				'delete_msg'=>$phprlang['delete_msg'],
				)
			);
		//
		// Start output of delete page.
		//
		require_once('includes/page_header.php');
		$wrmsmarty->display('delete.html');
		require_once('includes/page_footer.php');
		exit;
	}
	else
	{
		log_delete('character',$char_name);
		char_delete($char_id,$profile_id);
		
		header("Location: ".$pageURL_view);
	}
}

elseif(($_GET['mode'] == 'new' || $_GET['mode'] == 'edit')) 
{
	if(isset($_POST['submit']))
	{
		$guild = scrub_input($_GET['guild']);
		$race = scrub_input($_GET['race']);
		$class = scrub_input($_GET['class']);
		$gender = scrub_input($_POST['gender']);
		$name = scrub_input(ucfirst(trim($_POST['name'])));
		$level = scrub_input($_POST['level']);
		$pri_spec = scrub_input($_POST['pri_spec']);
		$sec_spec = scrub_input($_POST['sec_spec']);
		$arcane = scrub_input($_POST['arcane']);
		$fire = scrub_input($_POST['fire']);
		$frost = scrub_input($_POST['frost']);
		$nature = scrub_input($_POST['nature']);
		$shadow = scrub_input($_POST['shadow']);
		
		$profile = scrub_input($_SESSION['profile_id']);

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
		if(	($level == '' || !is_numeric($level)) and  
			( $level < 1  || $level > ($phpraid_config['max_lvl']+1))
			)
			$errorMsg .= '<li>'.$phprlang['profile_error_level'].'</li>';
		if($pri_spec == '' || $pri_spec == $phprlang['role_none'])
			$errorMsg .= '<li>'.$phprlang['profile_error_role'].'</li>';

		if ($phpraid_config['resop'] == 1)
		{
			//So resistance optional and values are empty, time to convert
			if ($shadow == "")
				$shadow = "0";
			if ($fire == "")
				$fire = "0";
			if ($frost == "")
				$frost = "0";
			if ($nature == "")
				$nature = "0";
			if ($arcane == "")
				$arcane = "0";
		}
		else
		{
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
		}
		
		$errorDie = 0;
		$errorMsg .= '</ul>';

		if($errorMsg != '<ul></ul>')
		{
			$errorDie = 1;
			$errorMsg = "";
		}
		else
		{
			// all is good add to database
			$profile = scrub_input($_SESSION['profile_id']);

			if($_GET['mode'] == 'new')
			{
				char_addnew($profile,$name,$class,$gender,$guild,$level,$race,$arcane,$fire,$frost,$nature,$shadow,$pri_spec,$sec_spec);
			} 
			elseif($_GET['mode'] == 'edit') 
			{
				$char_id=scrub_input($_GET['char_id']);
				char_edit($name,$level,$race,$class,$gender,$guild,$arcane,$nature,$shadow,$fire,$frost,$pri_spec,$sec_spec,$char_id);
			}
			
			header("Location: " . $pageURL_view);			
		}
	}
}

if (($_GET['mode'] == 'new') or ($_GET['mode'] == 'edit'))
{
	$mode_status = $_GET['mode'];
	// *if (($_GET['mode'] == 'edit') and ( !isset($_GET['guild']) or !isset($_GET['race']) or !isset($_GET['class'])))
	//{
	//	echo "HACK";
	//}
	// * /
	if($_GET['mode'] == 'new')
	{

		$guild = scrub_input($_GET['guild']);
		$race = scrub_input($_GET['race']);
		$class = scrub_input($_GET['class']);

		$dupeChar = isCharExist($name);		
		$char_id = "";
	
		if(isset($_POST['gender']))
			$gender = scrub_input($_POST['gender']);
		else
			$gender = '';
					
		if(isset($_POST['name']))
			$name = scrub_input(trim($_POST['name']));
		else
			$name = '';
			
		if(isset($_POST['level']))
			$level = scrub_input($_POST['level']);
		else
			$level = 1;

		if(isset($_POST['arcane']))
			$arcane = scrub_input($_POST['arcane']);
		else
			$arcane = 0;

		if(isset($_POST['fire']))
			$fire = scrub_input($_POST['fire']);
		else
			$fire = 0;

		if(isset($_POST['frost']))
			$frost = scrub_input($_POST['frost']);
		else
			$frost = 0;

		if(isset($_POST['nature']))
			$nature = scrub_input($_POST['nature']);
		else
			$nature = 0;
			
		if(isset($_POST['shadow']))
			$shadow = scrub_input($_POST['shadow']);
		else
			$shadow = 0;
			
		if(isset($_POST['pri_spec']))
			$pri_spec = scrub_input($_POST['pri_spec']);
		else
			$pri_spec = 0;
			
		if(isset($_POST['sec_spec']))
			$sec_spec = scrub_input($_POST['sec_spec']);
		else
			$sec_spec = 0;		
	}
	else 
	{
		// edit, grab from database
		$char_id = scrub_input($_GET['char_id']);

		$sql = sprintf(	"SELECT * ".
						"	FROM " . $phpraid_config['db_prefix'] . "chars ".
						"	WHERE char_id = %s",quote_smart($char_id));
		$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
		$data = $db_raid->sql_fetchrow($result, true);
		
		$guild = scrub_input($_GET['guild']);
		$race = scrub_input($_GET['race']);
		$class = scrub_input($_GET['class']);
		
		//$guild = $data['guild'];
		//$race = $data['race'];
		//$class = $data['class'];

		$dupeChar = 0;

		if(isset($_POST['gender']))
			$gender = scrub_input($_POST['gender']);
		else
			$gender = $data['gender'];
					
		if(isset($_POST['name']))
			$name = scrub_input(trim($_POST['name']));
		else
			$name = $data['name'];
			
		if(isset($_POST['level']))
			$level = scrub_input($_POST['level']);
		else
			$level = $data['lvl'];

		if(isset($_POST['arcane']))
			$arcane = scrub_input($_POST['arcane']);
		else
			$arcane = $data['arcane'];

		if(isset($_POST['fire']))
			$fire = scrub_input($_POST['fire']);
		else
			$fire = $data['fire'];

		if(isset($_POST['frost']))
			$frost = scrub_input($_POST['frost']);
		else
			$frost = $data['frost'];

		if(isset($_POST['nature']))
			$nature = scrub_input($_POST['nature']);
		else
			$nature = $data['nature'];
			
		if(isset($_POST['shadow']))
			$shadow = scrub_input($_POST['shadow']);
		else
			$shadow = $data['shadow'];
			
		if(isset($_POST['pri_spec']))
			$pri_spec = scrub_input($_POST['pri_spec']);
		else
			$pri_spec = $data['pri_spec'];
			
		if(isset($_POST['sec_spec']))
			$sec_spec = scrub_input($_POST['sec_spec']);
		else
			$sec_spec = $data['sec_spec'];	
	}
	
	// and the form
	$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "guilds";
	$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	
	if($db_raid->sql_numrows($result) == 0) {
		$errorTitle = $phprlang['profile_create_header'];
		$errorMsg = $phprlang['profile_create_msg'];
		$errorDie = 0;
		$errorSpace = 1;
		require_once('includes/page_header.php');
		require_once('includes/page_footer.php');		
	} 
	else 
	{

		//$form_action = "profile.php?mode=view";
		$form_action = $pageURL."?mode=".$mode_status."&amp;char_id=".$char_id."&amp;guild=". $guild."&race=". $race."&amp;class=".$class;
		//
		// init Arrays
		//	
		$array_guild = array();
		$array_race = array();
		$array_class = array();
		
		//$array_gender = array();
		//$array_class_role = array();
		
		//
		// fill array with start values
		//
		if( $_GET['mode'] == 'new')
		{
			$array_guild[$pageURL."?mode=".$mode_status] = $phprlang['form_select'] ;
			$array_race[$pageURL."?mode=".$mode_status."&amp;guild=". $guild] = $phprlang['form_select'] ;
			$array_class[$pageURL."?mode=".$mode_status."&amp;guild=". $guild."&race=". $race] = $phprlang['form_select'] ;
		}
		else
		{
			$array_guild[$pageURL."?mode=".$mode_status."&amp;char_id=".$char_id."&amp;guild=". $guild."&race=". $race."&amp;class=".$class] = $phprlang['form_select'] ;
			$array_race[$pageURL."?mode=".$mode_status."&amp;char_id=".$char_id."&amp;guild=". $guild."&race=". $race."&amp;class=".$class] = $phprlang['form_select'] ;
			$array_class[$pageURL."?mode=".$mode_status."&amp;char_id=".$char_id."&amp;guild=". $guild."&race=". $race."&amp;class=".$class] = $phprlang['form_select'] ;
			
		}
		// Set Guild Option Box.
		$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "guilds";
		$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);			
		while($guild_data = $db_raid->sql_fetchrow($result, true))
		{
			$tmp_url = "";
			if($_GET['mode'] == 'new')
			
				$tmp_url = $pageURL."?mode=".$mode_status."&amp;guild=". $guild_data['guild_id'];
			else
				$tmp_url = $pageURL."?mode=".$mode_status."&amp;char_id=".$char_id."&amp;guild=". $guild_data['guild_id']."&race=". $race."&amp;class=".$class;
			
			$array_guild[$tmp_url] = $guild_data['guild_name'];
			
			if($guild == $guild_data['guild_id'])
			{
				$selected_guild = $tmp_url; //$page_filename."?mode=".$mode_status."&amp;char_id=".$char_id."&amp;guild=". $guild_data['guild_id']."&race=". $race."&amp;class=".$class;
			}
		}

		// Set Race Option Box.
		$sql = sprintf("SELECT guild_faction FROM " . $phpraid_config['db_prefix'] . "guilds WHERE guild_id = %s", quote_smart($guild));
		$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
		$faction_data = $db_raid->sql_fetchrow($result, true);
		$faction = $faction_data['guild_faction'];
		$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "races WHERE faction = %s", quote_smart($faction));
		$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);			
		while($race_data = $db_raid->sql_fetchrow($result, true))
		{
			$tmp_url = "";
			if($_GET['mode'] == 'new')
				$tmp_url = $pageURL."?mode=".$mode_status."&amp;guild=". $guild."&amp;race=".$race_data['race_id'];
			else
				$tmp_url = $pageURL."?mode=".$mode_status."&amp;char_id=".$char_id."&amp;guild=". $guild."&race=". $race_data['race_id']."&amp;class=".$class;
			
			$array_race[$tmp_url] = $phprlang[$race_data['lang_index']];
			
			if($race == $race_data['race_id'])
			{
				$selected_race = $tmp_url; //$page_filename."?mode=".$mode_status."&amp;char_id=".$char_id."&amp;guild=". $guild."&race=". $race_data['race_id']."&amp;class=".$class;
			}
		}

		// Now that we have the race, let's show them what classes pertain to that race
		// Set Class Option Box.
		$sql = sprintf("SELECT a.race_id, a.class_id, b.lang_index
						FROM " . $phpraid_config['db_prefix'] . "class_race a, " 
								. $phpraid_config['db_prefix'] . "classes b 
						WHERE a.class_id = b.class_id
						AND race_id = %s", quote_smart($race));

		$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);			
		while($class_data = $db_raid->sql_fetchrow($result, true))
		{
			$tmp_url = "";
			if($_GET['mode'] == 'new')
				$tmp_url = $pageURL."?mode=".$mode_status."&guild=". $guild."&race=".$race."&class=".$class_data['class_id'];
			else
				$tmp_url = $pageURL."?mode=".$mode_status."&amp;char_id=".$char_id."&amp;guild=". $guild."&race=". $race."&amp;class=".$class_data['class_id'];
				
			$array_class[$tmp_url] = $phprlang[$class_data['lang_index']];
			
			if($class == $class_data['class_id'])
			{
				$selected_class = $tmp_url;//$page_filename."?mode=".$mode_status."&amp;char_id=".$char_id."&amp;guild=". $guild."&race=". $race."&amp;class=".$class_data['class_id'];
			}
		}
		
		//Gender Selection
		$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "gender");
		$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);			
		while($gender_data = $db_raid->sql_fetchrow($result, true))
		{
			if($gender == $gender_data['gender_id'])
				$gender_options .= "<option value=\"".$gender_data['gender_id']."\" selected>".$phprlang[$gender_data['lang_index']]."</option>";
			else
				$gender_options .= "<option value=\"".$gender_data['gender_id']."\">".$phprlang[$gender_data['lang_index']]."</option>";
		}			
			
		//Spec Selection
		$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "class_role WHERE class_id = %s", quote_smart($class));
		$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);			
		while($spec_data = $db_raid->sql_fetchrow($result, true))
		{
			// Setup Primary Spec Selection Box
			if($pri_spec == $spec_data['subclass'])
				$pri_options .= "<option value=\"".$spec_data['subclass']."\" selected>".$phprlang[$spec_data['lang_index']]."</option>";
			else
				$pri_options .= "<option value=\"".$spec_data['subclass']."\">".$phprlang[$spec_data['lang_index']]."</option>";
			
			// Setup Secondary Spec Selection Box
			if($sec_spec == $spec_data['subclass'])
				$sec_options .= "<option value=\"".$spec_data['subclass']."\" selected>".$phprlang[$spec_data['lang_index']]."</option>";
			else
				$sec_options .= "<option value=\"".$spec_data['subclass']."\">".$phprlang[$spec_data['lang_index']]."</option>";				
		}			
		// Set up "Not Available" option for Seconary Spec.
		if($sec_spec == "")
			$sec_options .= "<option value=\"\" selected>".$phprlang['notavailable']."</option>";
		else
			$sec_options .= "<option value=\"\">".$phprlang['notavailable']."</option>";				
		
		
		if(!isset($_GET['guild'])) {
			$race_output = '<select name="race" DISABLED><option></option></select>';
			$class_output = '<select name="class" DISABLED><option></option></select>';
			$name = '<select name="name" DISABLED><option></option></select>';
			$level = '<select name="level" DISABLED><option></option></select>';
			$gender = '<select name="gender" DISABLED><option></option></select>';
			$guild = '<select name="guild" DISABLED><option></option></select>';
			$pri_spec = '<select name="pri_spec" DISABLED><option></option></select>';
			$sec_spec = '<select name="sec_spec" DISABLED><option></option></select>';
			$arcane = '<select name="arcane" DISABLED><option></option></select>';
			$fire = '<select name="fire" DISABLED><option></option></select>';
			$frost = '<select name="frost" DISABLED><option></option></select>';
			$nature = '<select name="nature" DISABLED><option></option></select>';
			$shadow = '<select name="shadow" DISABLED><option></option></select>';
		}
		elseif (!isset($_GET['race'])) {
			$class_output = '<select name="class" DISABLED><option></option></select>';
			$name = '<select name="name" DISABLED><option></option></select>';
			$level = '<select name="level" DISABLED><option></option></select>';
			$gender = '<select name="gender" DISABLED><option></option></select>';
			$guild = '<select name="guild" DISABLED><option></option></select>';
			$pri_spec = '<select name="pri_spec" DISABLED><option></option></select>';
			$sec_spec = '<select name="sec_spec" DISABLED><option></option></select>';
			$arcane = '<select name="arcane" DISABLED><option></option></select>';
			$fire = '<select name="fire" DISABLED><option></option></select>';
			$frost = '<select name="frost" DISABLED><option></option></select>';
			$nature = '<select name="nature" DISABLED><option></option></select>';
			$shadow = '<select name="shadow" DISABLED><option></option></select>';
		} else {
			$name = '<input type="text" name="name" class="post" value="' . $name . '" style="width:100px">';
			$level = '<input name="level" type="text" class="post" size="2" value="' . $level . '" maxlength="2">';
			$gender = '<select name="gender" class="form" id="gender" style="width:100px">' .$gender_options. '</select>';
			$pri_spec = '<select name="pri_spec" class="form" id="role" style="width:140px">' .$pri_options. '</select>';
			$sec_spec = '<select name="sec_spec" class="form" id="role" style="width:140px">' .$sec_options. '</select>';			
			$arcane = '<input name="arcane" type="text" class="post" size="3" value="' . $arcane . '" maxlength="3">';
			$fire =  '<input name="fire" type="text" class="post" size="3" value="' . $fire . '" maxlength="3">';
			$frost =  '<input name="frost" type="text" class="post" size="3" value="' . $frost . '" maxlength="3">';
			$nature =  '<input name="nature" type="text" class="post" size="3" value="' . $nature . '" maxlength="3">';
			$shadow =  '<input name="shadow" type="text" class="post" size="3" value="' . $shadow . '" maxlength="3">';
		}

		if($_GET['mode'] == 'new')
		{
			$buttons_01 = $phprlang['addchar'];
			$header_titel = $phprlang['addchar'];
		}
		else
		{
			$buttons_01 = $phprlang['updatechar'];
			$header_titel = $phprlang['updatechar'];
		}

		$wrmsmarty->assign('char_new',
			array(
				'name' => $name,
				'char_header' => $header_titel,
				'form_action' => $form_action,
				'buttons_01' => $buttons_01,
				'array_guild' => $array_guild,
				'selected_guild' => $selected_guild,
				'array_race' => $array_race,
				'selected_race' => $selected_race,
				'array_class' => $array_class,
				'selected_class' => $selected_class,
				'gender'=>$gender,
				'arcane_text'=>$phprlang['resistance_arcane'],
				'fire_text'=>$phprlang['resistance_fire'],
				'frost_text'=>$phprlang['resistance_frost'],
				'nature_text'=>$phprlang['resistance_nature'],
				'shadow_text'=>$phprlang['resistance_shadow'],
				'arcane'=>$arcane,
				'fire'=>$fire,
				'frost'=>$frost,
				'nature'=>$nature,
				'shadow'=>$shadow,
				'guild_text' => $phprlang['profile_guild'],
				'role_text' => $phprlang['profile_role'],
				'pri_spec' => $pri_spec,
				'sec_spec' => $sec_spec,
				'level'=>$level,
				'race_text'=>$phprlang['profile_race'],
				'class_text'=>$phprlang['profile_class'],
				'gender_text'=>$phprlang['profile_gender'],
				'name_text'=>$phprlang['profile_name'],
				'level_text'=>$phprlang['profile_level']

			)
		);
		
		require_once('includes/page_header.php');
		$wrmsmarty->display('profile_char_new.html');
		require_once('includes/page_footer.php');
	}
}

?>