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

// This is the number of rows (ie, weeks.. current week included) the calendar shows
$num_rows=4;

// commons
define("IN_PHPRAID", true);
include("./common.php");

// page authentication
if($phpraid_config['anon_view'] == 1)
	define("PAGE_LVL","anonymous");
else
	define("PAGE_LVL","profile");

require_once("includes/authentication.php");
include("includes/page_header.php");

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
				'announcement_msg'=>$data['message'],
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


?>

<center>
<hr>
</center>
<div align=\"left\">

<p>
<table border="4" width="100%" id="table1" align="center" cellspacing="3">
        <tr height="18">
<?php
print "                <th colspan=\"7\"><font color=\"#0000FF\"><div align=\"center\">" . date("F",mktime(0, 0, 0, date("m") , date("d") , date("Y"))) . " " . date("Y",mktime(0, 0, 0, date("m") , date("d") , date("Y")))  . "</div></font></th>";
?>
<?php
        echo "</tr>";
        echo "<tr height=\"18\">";
        echo "  <th width=14% align=\"center\"><b>" . $phprlang['sunday'] . "</b></td>";
        echo "  <th width=14% align=\"center\"><b>" . $phprlang['monday'] . "</b></td>";
        echo "  <th width=14% align=\"center\"><b>" . $phprlang['tuesday'] . "</b></td>";
        echo "  <th width=14% align=\"center\"><b>" . $phprlang['wednesday'] . "</b></td>";
        echo "  <th width=14% align=\"center\"><b>" . $phprlang['thursday'] . "</b></td>";
        echo "  <th width=14% align=\"center\"><b>" . $phprlang['friday'] . "</b></td>";
        echo "  <th width=14% align=\"center\"><b>" . $phprlang['saturday'] . "</b></td>";
        echo "</tr>";
?>
<?php

$today = mktime(0, 0, 0, date("m") , date("d"), date("Y"));
$start = mktime(0, 0, 0, date("m") , date("d") - date("w"), date("Y"));

print "        <tr height=\"100\"> \n";

for ($i = 1; $i <= ($num_rows*7); $i++)   {

    $txt_color = "";

  if( (mktime(0, 0, 0, date("m",$start ) , date("d",$start ) +$i-1 , date("Y",$start ))) == $today) {
    $txt_color = "#FF0000";
  }

  if( (mktime(0, 0, 0, date("m",$start ) , date("d",$start ) +$i-1 , date("Y",$start ))) < $today) {
    $txt_color = "#FFFFFF";
  }

  if(($i==1) or (date("d",mktime(0, 0, 0, date("m",$start ) , date("d",$start ) +$i-1 , date("Y",$start ))) == "01")){
    print "                <td valign=\"top\"><div align=\"right\"><b><font size=\"4\" color=\"{$txt_color}\">" . date("M",mktime(0, 0, 0, date("m",$start ) , date("d",$start ) +$i-1 , date("Y",$start ))) . " " . date("d",mktime(0, 0, 0, date("m",$start ) , date("d",$start ) +$i-1 , date("Y",$start ))) . "&nbsp;</font></b></div>";
  } else {
    print "                <td valign=\"top\"><div align=\"right\"><b><font size=\"4\" color=\"{$txt_color}\">" . date("d",mktime(0, 0, 0, date("m",$start ) , date("d",$start ) +$i-1 , date("Y",$start ))) . "&nbsp;</font></b></div>";
  }

print "<div align=\"left\"><font size=\"1\" color=\"#FFFFFF\">";

$current_date = date("m-d-Y",mktime(0, 0, 0, date("m",$start ) , date("d",$start ) +$i-1 , date("Y",$start )));

$dayfirst =  mktime(0, 0, 0, date("m",$start ) , date("d",$start ) +$i-1 , date("Y",$start ));
$daylast = mktime(23, 59, 59, date("m",$start ) , date("d",$start ) +$i-1 , date("Y",$start ));

$result = $db_raid->sql_query("SELECT * FROM " . $phpraid_config['db_prefix'] . "raids WHERE start_time > '" . $dayfirst . "' AND start_time <= '" . $daylast . "' ORDER BY start_time");
$bob = "a";

while($data = $db_raid->sql_fetchrow($result, true)) {
	$invitetime = new_date($phpraid_config['time_format'], $data['invite_time'],$phpraid_config['timezone'] + $phpraid_config['dst']);
	$starttime = new_date($phpraid_config['time_format'], $data['start_time'],$phpraid_config['timezone'] + $phpraid_config['dst']);

//	$starttime = date($config['time_format'],$data['start_time']);
//	$invitetime = date($config['time_format'],$data['invite_time']);

	$uid = $_SESSION['profile_id'];
	$issignedup = "";
	$resultz = $db_raid->sql_query("SELECT * FROM " . $phpraid_config['db_prefix'] . "signups WHERE raid_id='" . $data['raid_id']. "' AND profile_id='{$_SESSION['profile_id']}'");
	if($db_raid->sql_numrows($resultz) > 0)
	{
		$data2 =  $db_raid->sql_fetchrow($resultz, true);
		if (($data2['queue'] == '0') and ($data2['cancel'] == '0')) {
			$issignedup = "*";
		} else {
			$issignedup = "#";
		}
	}
	$resultz2 = $db_raid->sql_query("SELECT * FROM " . $phpraid_config['db_prefix'] . "signups WHERE raid_id='" . $data['raid_id']. "' AND profile_id='{$_SESSION['profile_id']}' AND queue = '0' AND cancel = '0'");
	if ($db_raid->sql_numrows($resultz2) > 0) {
		$issignedup = "*";
	}

	$desc = scrub_input($data['description']);
	$ddrivetiptxt = "'<span class=tooltip_title>" . $phprlang['description'] ."</span><br>" . DEUBB2($desc) . "'";
	$location = '<a href="view.php?mode=view&raid_id='.$data['raid_id'].'" onMouseover="ddrivetip('.$ddrivetiptxt.')"; onMouseout="hideddrivetip()">'.$data['location'].'</a> <font color="#0000ff" size=+1>' . $issignedup . '</font></font>';
	
	//$location = '<a href="view.php?mode=view&raid_id='.$data['raid_id'].'" onMouseover="ddrivetip(\'<span class=tooltip_title>Description</span><br>' . $desc . '\')" onMouseout="hideddrivetip()">'.$data['location'].'</a> <font color="#0000ff" size=+1>' . $issignedup . '</font></font>';
	$result_total = $db_raid->sql_query("SELECT * FROM " . $phpraid_config['db_prefix'] . "signups WHERE raid_id='".$data['raid_id']."' AND queue='0'");
	$total = $db_raid->sql_numrows($result_total);

//	$location = '<a href="view.php?mode=view&raid_id=' . $data['raid_id'] . '">' . $data['location'] . '</a>';

	if ($bob <> "a") {
		print "<hr>";
	} else {
		$bob="b";
	}

	print $location;
	print "<br>";
	print $phprlang['invites'] . ": " . $invitetime;
	print "<br>";
	print $phprlang['start'] . ": " . $starttime;
	print "<br>";

}
print "&nbsp;</font></div></td> \n";



  if ( ($i % 7 == 0) and ($i < ($num_rows*7)) ) {
    print "        </tr> \n";
    print "        <tr height=\"100\"> \n";
  }
}
    print "        </tr> \n";

?>
	<tr>
<?php
    print '<td colspan="7"><font size="1"><div align="left">' . $phprlang['key']. '</div></font></td>';
?>
	</tr>

</table>

<p>&nbsp;</p></div>

<?php

        include("includes/page_footer.php");

?>