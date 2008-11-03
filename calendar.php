<?php
/***************************************************************************
 *                                 calendar.php
 *                            	-------------------
 *   begin                : Monday, Jan 18, 2005
 *   copyright            : (C) 2007-2008 Douglas Wagner
 *   email                : douglasw@wagnerweb.org
 *
 *   $Id: calendar.php,v 2.00 2007/11/23 14:25:57 psotfx Exp $
 *
 ****************************************************************************/

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
include("./common.php");

// page authentication
if($phpraid_config['anon_view'] == 1)
	define("PAGE_LVL","anonymous");
else
	define("PAGE_LVL","profile");

require_once("includes/authentication.php");

// check for month/year passing
isset($_POST['month']) ? $in_month = scrub_input($_POST['month']) : $in_month = '';
isset($_POST['year']) ? $in_year = scrub_input($_POST['year']) : $in_year = '';

isset($_GET['month']) ? $in_month = scrub_input($_GET['month']) : $in_month = $in_month;
isset($_GET['year']) ? $in_year = scrub_input($_GET['year']) : $in_year = $in_year;

// Generate "Current" values.
$currYear = date("Y");
$nextYear = date("Y")+1;
$prevYear = date("Y")-1;
$currMonth = date("n");
$currDate = date("j");
$currTimeStamp = mktime(0,0,0);

// Generate the "timestamp" to use for this display.
if ($in_month == '')
	$in_month = $currMonth;
if ($in_year == '')
	$in_year = $currYear;

// This "timestamp" is for what the user passed into us and should be the basis for everything generated
//     on the page.
$timestamp = mktime('00','00','00', $in_month, '1', $in_year);

// This is for the "next"/"previous" links.  We need the next and prev months and the year those months
//     are in, this keeps us from moving from December 2008 to January 2008.
$prevMonth = date("n", mktime('00', '00', '00', $in_month - 1, '1', $in_year));
$prevMonthYear = date("Y", mktime('00', '00', '00', $in_month - 1, '1', $in_year));
$nextMonth = date("n", mktime('00', '00', '00', $in_month + 1, '1', $in_year));
$nextMonthYear = date("Y", mktime('00', '00', '00', $in_month + 1, '1', $in_year));

// Generate the "Year" dropdown.
$yearSelect = '<select name="year">';
$yearSelect .= '<option value="'. $prevYear . '">' . $prevYear . '</option>';
$yearSelect .= '<option value="'. $currYear . '" selected>' . $currYear . '</option>';
$yearSelect .= '<option value="'. $nextYear . '">' . $nextYear . '</option>';
$yearSelect .= '</select>';

// Generate the "Month" dropdown.
$monthSelect = '<select name="month">';
for ($x = 1; $x <= 12; $x++)
{
	if($currMonth == $x)
		$monthSelect .= '<option value="' . $x . '" selected>'. $phprlang['month'.$x] . '</option>';
	else
		$monthSelect .= '<option value="' . $x . '">'. $phprlang['month'.$x] . '</option>';
}
$monthSelect .= '</select>';

// Pass Along the Headers
$monthSelectHeader = $phprlang['calendar_month_select_header'];

//@@ REMOVE THIS
// Set the Starting Day on the Calendar.
$startDay = 'Sunday';

$boxOffset = array();
$box = array();

if ($startDay == $phprlang['monday'])
{
	$day1 = $phprlang['monday'];
	$day2 = $phprlang['tuesday'];
	$day3 = $phprlang['wednesday'];
	$day4 = $phprlang['thursday'];
	$day5 = $phprlang['friday'];
	$day6 = $phprlang['saturday'];
	$day7 = $phprlang['sunday'];

	$boxOffset[0]=6;
	$boxOffset[1]=0;
	$boxOffset[2]=1;
	$boxOffset[3]=2;
	$boxOffset[4]=3;
	$boxOffset[5]=4;
	$boxOffset[6]=5;
}
else
{
	$day1 = $phprlang['sunday'];
	$day2 = $phprlang['monday'];
	$day3 = $phprlang['tuesday'];
	$day4 = $phprlang['wednesday'];
	$day5 = $phprlang['thursday'];
	$day6 = $phprlang['friday'];
	$day7 = $phprlang['saturday'];

	$boxOffset[0]=0;
	$boxOffset[1]=1;
	$boxOffset[2]=2;
	$boxOffset[3]=3;
	$boxOffset[4]=4;
	$boxOffset[5]=5;
	$boxOffset[6]=6;
}

// This is the Month and Year Header for the Calendar.
$monthHead = $phprlang['month'.date("n", $timestamp)] . " " . date("Y", $timestamp);

// Get Day of Week Number for First Day of Month and the Offset Number to Add.
$dayOfWeekFirst = date("w", $timestamp);
$offset = $boxOffset[$dayOfWeekFirst];

// So from here on out, to get any specific box to write into you use the following formula:
//    Day of Month + Offset = Box Number for that Day of the Month.

// Write the Days of the Month into the correct calendar boxes in the correct color.
$daysInMonth = date("t", $timestamp);

for ($x = 1; $x <= $daysInMonth; $x++)
{
	$checkDate = mktime(0,0,0,$in_month,$x,$in_year);
	
	if ($checkDate == $currTimeStamp)
	{
		$boxNum = $x + $offset;
		$varname = 'box'.$boxNum;
		$$varname = '<div align="right"><font size="4" color="#FF0000"><b>' . $x . '</b></font></div>';		
	}
	elseif ($checkDate < $currTimeStamp)
	{
		$boxNum = $x + $offset;
		$varname = 'box'.$boxNum;
		$$varname = '<div align="right"><font size="4" color="#FFFFFF"><b>' . $x . '</b></font></div>';				
	}
	else
	{
		$boxNum = $x + $offset;
		$varname = 'box'.$boxNum;
		$$varname = '<div align="right"><font size="4"><b>' . $x . '</b></font></div>';				
	}
}

// Ok, so the calendar is setup, now put the raids on it.  For each raid, pull the data from the database
//   obtain it's start date/time and calculate the box that raid needs to go into.
//   Append the data for that raid into the appropriate calendar box.

// Get the Unix Timestamp for the Start of the Passed in Month and the End of the Passed in Month.
$raidStartMonth = mktime("0", "0", "0", $in_month, "1", $in_year);
$lastDayPassedMonth = date("t", $timestamp);
$raidEndMonth = mktime("23", "59", "59", $in_month, $lastDayPassedMonth, $in_year);

$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "raids WHERE start_time >= '" . $raidStartMonth . "' AND start_time <= '" . $raidEndMonth . "' ORDER BY start_time";

$raids_result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
while($raids = $db_raid->sql_fetchrow($raids_result, true)) 
{
	// Calculate the Invite and Start Time for the Raid.
	$invitetime = new_date($phpraid_config['time_format'], $raids['invite_time'],$phpraid_config['timezone'] + $phpraid_config['dst']);
	$starttime = new_date($phpraid_config['time_format'], $raids['start_time'],$phpraid_config['timezone'] + $phpraid_config['dst']);

	$uid = scrub_input($_SESSION['profile_id']);
	$issignedup = "";
	
	// Get a list of all the signups for this raid for the current profile.
	$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "signups WHERE raid_id=%s AND profile_id=%s", quote_smart($raids['raid_id']), quote_smart($uid)); 
	$resultz = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
	
	// If the profile is signed up check to see whether it should be marked for Drafted or Queued/Cancelled
	//		the "drafted" mark overrides the "Queued/Cancel" mark for players with more than one character
	//		signed up for the raid.
	if($db_raid->sql_numrows($resultz) > 0)
	{
		while($signups = $db_raid->sql_fetchrow($resultz, true)) 
		{
			if (($signups['queue'] == '0') and ($signups['cancel'] == '0')) {
				$issignedup = "*";
			} elseif ($issignedup == '') {
				$issignedup = "#";
			}
		}
	}

	// Create the link to the raids view.
	$desc = scrub_input($raids['description']);
	$ddrivetiptxt = "'<span class=tooltip_title>" . $phprlang['description'] ."</span><br>" . DEUBB2($desc) . "'";
	$location = '<a href="view.php?mode=view&amp;raid_id='.$raids['raid_id'].'" onMouseover="ddrivetip('.$ddrivetiptxt.');" onMouseout="hideddrivetip()">'.$raids['location'].'</a> <font color="#0000ff" size="+1">' . $issignedup . '</font>';

	// Start the "display" portion, get the "box" the raid link and information is supposed to go into
	//		then append the raid into the box.
	$raidDayOfMonth = date("j", $raids['start_time']);
	$boxNum = $raidDayOfMonth + $offset;
	$varname = 'box'.$boxNum;
	
	$$varname .= '<div align="left">';
	$$varname .= $location; 
	$$varname .= "<br>"; 
	$$varname .= $phprlang['invites'] . ": " . $invitetime;
	$$varname .= "<br>";
	$$varname .= $phprlang['start'] . ": " . $starttime;
	$$varname .= "<br><br>";
	$$varname .= "</div>";
}

include("includes/page_header.php");

$page->set_file(array(
	'body_file' => $phpraid_config['template'] . '/calendar.htm')
);

// Array for Calendar Part Here.
$page->set_var(
	array(
		'key'=>$phprlang['key'],
		'submit_text'=>$phprlang['submit'],
		'reset_text'=>$phprlang['reset'],
		'month_select_header'=>$monthSelectHeader,
		'month_select'=>$monthSelect,
		'year_select'=>$yearSelect,
		'buttons'=>$buttons,
		'month_text'=>$phprlang['month'],
		'year_text'=>$phprlang['year'],
		'monthhead'=>$monthHead,
		'prevmonth'=>$prevMonth,
		'prevmonthyear'=>$prevMonthYear,
		'nextmonth'=>$nextMonth,
		'nextmonthyear'=>$nextMonthYear,
		'day1'=>$day1,
		'day2'=>$day2,
		'day3'=>$day3,
		'day4'=>$day4,
		'day5'=>$day5,
		'day6'=>$day6,
		'day7'=>$day7,
		'box1'=>$box1,
		'box2'=>$box2,
		'box3'=>$box3,
		'box4'=>$box4,
		'box5'=>$box5,
		'box6'=>$box6,
		'box7'=>$box7,
		'box8'=>$box8,
		'box9'=>$box9,
		'box10'=>$box10,
		'box11'=>$box11,
		'box12'=>$box12,
		'box13'=>$box13,
		'box14'=>$box14,
		'box15'=>$box15,
		'box16'=>$box16,
		'box17'=>$box17,
		'box18'=>$box18,
		'box19'=>$box19,
		'box20'=>$box20,
		'box21'=>$box21,
		'box22'=>$box22,
		'box23'=>$box23,
		'box24'=>$box24,
		'box25'=>$box25,
		'box26'=>$box26,
		'box27'=>$box27,
		'box28'=>$box28,
		'box29'=>$box29,
		'box30'=>$box30,
		'box31'=>$box31,
		'box32'=>$box32,
		'box33'=>$box33,
		'box34'=>$box34,
		'box35'=>$box35,
		'box36'=>$box36,
		'box37'=>$box37,
		'box38'=>$box38,
		'box39'=>$box39,
		'box40'=>$box40,
		'box41'=>$box41,
		'box42'=>$box42,
		)
);

// now for announcements
// get announcements
$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "announcements";
$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);
if($db_raid->sql_numrows($result) > 0)
{
	$page->set_file('announceFile',$phpraid_config['template'] . '/announcements_msg.htm');
	$page->set_block('announceFile','announcement_row','ARow');

	/* fetch rows in reverse order */
	$i = $db_raid->sql_numrows($result) - 1;
	while($i >= 0)
	{
		$db_raid->sql_rowseek($i, $result);
		$data = $db_raid->sql_fetchrow($result, true);
		$time = new_date($phpraid_config['time_format'], $data['timestamp'],$phpraid_config['timezone'] + $phpraid_config['dst']);
		$date = new_date($phpraid_config['date_format'], $data['timestamp'],$phpraid_config['timezone'] + $phpraid_config['dst']);

		$page->set_var(
			array(
				'announcement_header'=>$phprlang['announcements_header'],
				'announcement_author'=>$data['posted_by'],
				'announcement_date'=>$date,
				'announcement_time'=>$time,
				'announcement_msg'=>linebreak_to_br($data['message']),
				'announcement_title'=>$data['title'],
			)
		);

		$page->parse('ARow','announcement_row',true);

		$i--;
	}
	$page->parse('body','announceFile',true);
}
$page->parse('body','body_file',true);

$page->p('body');

include('includes/page_footer.php');

?>