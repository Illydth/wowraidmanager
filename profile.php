<?php
/***************************************************************************
 *                           profile.php
 *                        -------------------
 *   begin                : Jan 23, 2011
 *	 Dev                  : Carsten Hölbing
 *	 email                : carsten@hoelbing.net
 *
 *   copyright            : (C) 2007-2011 Douglas Wagner
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

/*************************************************
 * Access Authorization Section
 *************************************************/
// page authentication
define("PAGE_LVL","anonymous");
require_once("includes/authentication.php");


$pageURL = "profile.php";

$profile_id = scrub_input($_SESSION['profile_id']);

$sql = sprintf(	"SELECT * FROM " . $phpraid_config['db_prefix'] . "profile".
				" WHERE profile_id = %s ", quote_smart($profile_id));
$profile_result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
$profile_data = $db_raid->sql_fetchrow($profile_result, true);

$sql = sprintf(	"SELECT * FROM " . $phpraid_config['db_prefix'] . "chars " .
				" WHERE profile_id = %s", quote_smart($profile_id));
$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
$char_count = $db_raid->sql_numrows($result);

$count_signups_draft = 0;
$count_signups_queue = 0;
$count_signups_chancel = 0;

$sql = sprintf(	"SELECT * FROM " . $phpraid_config['db_prefix'] . "signups " .
				" WHERE profile_id = %s", quote_smart($profile_id));
$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
$count_signups_all = $db_raid->sql_numrows($result);
while ($signups_data = $db_raid->sql_fetchrow($result, true))
{
	if ($signups_data['queue'] == "0" and $signups_data['cancel'] == "0")
		$count_signups_draft++;

	if ($signups_data['queue'] == "1" and $signups_data['cancel'] == "0")
		$count_signups_queue++;
		
	if ($signups_data['queue'] == "0" and $signups_data['cancel'] == "1")
		$count_signups_chancel++;				
}

$wrmsmarty->assign('profile_data',
	array(
		'form_action'=> $pageURL,
		'profile_header' => $phprlang['profile_header_text'],
		'profile_email_text' => $phprlang['email'],
		'profile_email_value' => $profile_data['email'],
		'profile_username_text' => $phprlang['username'],
		'profile_username_value' => $profile_data['username'],
		'profile_last_login_time_text' => $phprlang['last_login_time'],
		'profile_last_login_time_value' => get_date($profile_data['last_login_time']),
		
	
		'statistics_header' => $phprlang['view_statistics_header'],
		'profile_number_character_text' => $phprlang['profile_number_character'],
		'profile_number_character_value' => $char_count,
	
		'count_signups_all_text' => $phprlang['profile_number_signups_all'],
		'count_signups_all' => $count_signups_all,	
		'count_signups_draft_text' => $phprlang['profile_number_signups_draft'],
		'count_signups_draft' => $count_signups_draft,
		'count_signups_queue_text' => $phprlang['profile_number_signups_queue'],
		'count_signups_queue' => $count_signups_queue,
		'count_signups_chancel_text' => $phprlang['profile_number_signups_chancel'],
		'count_signups_chancel' => $count_signups_chancel,
	
		'button_submit' => $phprlang['submit'],
		'button_reset' => $phprlang['reset']
	)
);

/*if(isset($_POST['submit']))
{


	$email = scrub_input(DEUBB($_POST['profile_email']));

	update_profile($profile_id, $email);
	
	header("Location: ".$page_url);
}*/

//
// Start output of the page.
//
require_once('includes/page_header.php');
$wrmsmarty->display('profile.html');
require_once('includes/page_footer.php');

?>