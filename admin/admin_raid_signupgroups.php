<?php
/***************************************************************************
                              admin_raid_signupgroups.php
 *                            -------------------
 *   begin                : Wed, Sep 09, 2010
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

$sql = "SELECT * FROM " . $phpraid_config['db_prefix'] . "acl_raid_signup_group";

$result_group = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
$data_wrm = $db_raid->sql_fetchrow($result_group,true);

/* 
 * Data for Index Page
 */
// Setup the Signup Flow Configuration Area - Setup Checkboxes
// 		User Permissions
if($data_wrm['on_queue_draft'] == '0')
	$user_queue_promote = '<input type="checkbox" name="user_queue_promote" value="0">';
else
	$user_queue_promote = '<input type="checkbox" name="user_queue_promote" value="1" checked>';

if($data_wrm['on_queue_comments'] == '0')
	$user_queue_comments = '<input type="checkbox" name="user_queue_comments" value="0">';
else
	$user_queue_comments = '<input type="checkbox" name="user_queue_comments" value="1" checked>';

if($data_wrm['on_queue_cancel'] == '0')
	$user_queue_cancel = '<input type="checkbox" name="user_queue_cancel" value="0">';
else
	$user_queue_cancel = '<input type="checkbox" name="user_queue_cancel" value="1" checked>';

if($data_wrm['on_queue_delete'] == '0')
	$user_queue_delete = '<input type="checkbox" name="user_queue_delete" value="0">';
else
	$user_queue_delete = '<input type="checkbox" name="user_queue_delete" value="1" checked>';

if($data_wrm['cancelled_status_queue'] == '0')
	$user_cancel_queue = '<input type="checkbox" name="user_cancel_queue" value="0">';
else
	$user_cancel_queue = '<input type="checkbox" name="user_cancel_queue" value="1" checked>';

if($data_wrm['cancelled_status_draft'] == '0')
	$user_cancel_promote = '<input type="checkbox" name="user_cancel_promote" value="0">';
else
	$user_cancel_promote = '<input type="checkbox" name="user_cancel_promote" value="1" checked>';

if($data_wrm['cancelled_status_comments'] == '0')
	$user_cancel_comments = '<input type="checkbox" name="user_cancel_comments" value="0">';
else
	$user_cancel_comments = '<input type="checkbox" name="user_cancel_comments" value="1" checked>';

if($data_wrm['cancelled_status_delete'] == '0')
	$user_cancel_delete = '<input type="checkbox" name="user_cancel_delete" value="0">';
else
	$user_cancel_delete = '<input type="checkbox" name="user_cancel_delete" value="1" checked>';

if($data_wrm['drafted_queue'] == '0')
	$user_drafted_queue = '<input type="checkbox" name="user_drafted_queue" value="0">';
else
	$user_drafted_queue = '<input type="checkbox" name="user_drafted_queue" value="1" checked>';

if($data_wrm['drafted_comments'] == '0')
	$user_drafted_comments = '<input type="checkbox" name="user_drafted_comments" value="0">';
else
	$user_drafted_comments = '<input type="checkbox" name="user_drafted_comments" value="1" checked>';

if($data_wrm['drafted_cancel'] == '0')
	$user_drafted_cancel = '<input type="checkbox" name="user_drafted_cancel" value="0">';
else
	$user_drafted_cancel = '<input type="checkbox" name="user_drafted_cancel" value="1" checked>';

if($data_wrm['drafted_delete'] == '0')
	$user_drafted_delete = '<input type="checkbox" name="user_drafted_delete" value="0">';
else
	$user_drafted_delete = '<input type="checkbox" name="user_drafted_delete" value="1" checked>';

// 		Raid Leader Permissions
$data_wrm = $db_raid->sql_fetchrow($result_group,true);
if($data_wrm['on_queue_draft'] == '0')
	$rl_queue_promote = '<input type="checkbox" name="rl_queue_promote" value="0">';
else
	$rl_queue_promote = '<input type="checkbox" name="rl_queue_promote" value="1" checked>';

if($data_wrm['on_queue_comments'] == '0')
	$rl_queue_comments = '<input type="checkbox" name="rl_queue_comments" value="0">';
else
	$rl_queue_comments = '<input type="checkbox" name="rl_queue_comments" value="1" checked>';

if($data_wrm['on_queue_cancel'] == '0')
	$rl_queue_cancel = '<input type="checkbox" name="rl_queue_cancel" value="0">';
else
	$rl_queue_cancel = '<input type="checkbox" name="rl_queue_cancel" value="1" checked>';

if($data_wrm['on_queue_delete'] == '0')
	$rl_queue_delete = '<input type="checkbox" name="rl_queue_delete" value="0">';
else
	$rl_queue_delete = '<input type="checkbox" name="rl_queue_delete" value="1" checked>';

if($data_wrm['cancelled_status_queue'] == '0')
	$rl_cancel_queue = '<input type="checkbox" name="rl_cancel_queue" value="0">';
else
	$rl_cancel_queue = '<input type="checkbox" name="rl_cancel_queue" value="1" checked>';

if($data_wrm['cancelled_status_draft'] == '0')
	$rl_cancel_promote = '<input type="checkbox" name="rl_cancel_promote" value="0">';
else
	$rl_cancel_promote = '<input type="checkbox" name="rl_cancel_promote" value="1" checked>';

if($data_wrm['cancelled_status_comments'] == '0')
	$rl_cancel_comments = '<input type="checkbox" name="rl_cancel_comments" value="0">';
else
	$rl_cancel_comments = '<input type="checkbox" name="rl_cancel_comments" value="1" checked>';

if($data_wrm['cancelled_status_delete'] == '0')
	$rl_cancel_delete = '<input type="checkbox" name="rl_cancel_delete" value="0">';
else
	$rl_cancel_delete = '<input type="checkbox" name="rl_cancel_delete" value="1" checked>';

if($data_wrm['drafted_queue'] == '0')
	$rl_drafted_queue = '<input type="checkbox" name="rl_drafted_queue" value="0">';
else
	$rl_drafted_queue = '<input type="checkbox" name="rl_drafted_queue" value="1" checked>';

if($data_wrm['drafted_comments'] == '0')
	$rl_drafted_comments = '<input type="checkbox" name="rl_drafted_comments" value="0">';
else
	$rl_drafted_comments = '<input type="checkbox" name="rl_drafted_comments" value="1" checked>';

if($data_wrm['drafted_cancel'] == '0')
	$rl_drafted_cancel = '<input type="checkbox" name="rl_drafted_cancel" value="0">';
else
	$rl_drafted_cancel = '<input type="checkbox" name="rl_drafted_cancel" value="1" checked>';

if($data_wrm['drafted_delete'] == '0')
	$rl_drafted_delete = '<input type="checkbox" name="rl_drafted_delete" value="0">';
else
	$rl_drafted_delete = '<input type="checkbox" name="rl_drafted_delete" value="1" checked>';
	

// 		Administrator Permissions
$data_wrm = $db_raid->sql_fetchrow($result_group,true);
if($data_wrm['on_queue_draft'] == '0')
	$admin_queue_promote = '<input type="checkbox" name="admin_queue_promote" value="0">';
else
	$admin_queue_promote = '<input type="checkbox" name="admin_queue_promote" value="1" checked>';

if($data_wrm['on_queue_comments'] == '0')
	$admin_queue_comments = '<input type="checkbox" name="admin_queue_comments" value="0">';
else
	$admin_queue_comments = '<input type="checkbox" name="admin_queue_comments" value="1" checked>';

if($data_wrm['on_queue_cancel'] == '0')
	$admin_queue_cancel = '<input type="checkbox" name="admin_queue_cancel" value="0">';
else
	$admin_queue_cancel = '<input type="checkbox" name="admin_queue_cancel" value="1" checked>';

if($data_wrm['on_queue_delete'] == '0')
	$admin_queue_delete = '<input type="checkbox" name="admin_queue_delete" value="0">';
else
	$admin_queue_delete = '<input type="checkbox" name="admin_queue_delete" value="1" checked>';

if($data_wrm['cancelled_status_queue'] == '0')
	$admin_cancel_queue = '<input type="checkbox" name="admin_cancel_queue" value="0">';
else
	$admin_cancel_queue = '<input type="checkbox" name="admin_cancel_queue" value="1" checked>';

if($data_wrm['cancelled_status_draft'] == '0')
	$admin_cancel_promote = '<input type="checkbox" name="admin_cancel_promote" value="0">';
else
	$admin_cancel_promote = '<input type="checkbox" name="admin_cancel_promote" value="1" checked>';

if($data_wrm['cancelled_status_comments'] == '0')
	$admin_cancel_comments = '<input type="checkbox" name="admin_cancel_comments" value="0">';
else
	$admin_cancel_comments = '<input type="checkbox" name="admin_cancel_comments" value="1" checked>';

if($data_wrm['cancelled_status_delete'] == '0')
	$admin_cancel_delete = '<input type="checkbox" name="admin_cancel_delete" value="0">';
else
	$admin_cancel_delete = '<input type="checkbox" name="admin_cancel_delete" value="1" checked>';

if($data_wrm['drafted_queue'] == '0')
	$admin_drafted_queue = '<input type="checkbox" name="admin_drafted_queue" value="0">';
else
	$admin_drafted_queue = '<input type="checkbox" name="admin_drafted_queue" value="1" checked>';

if($data_wrm['drafted_comments'] == '0')
	$admin_drafted_comments = '<input type="checkbox" name="admin_drafted_comments" value="0">';
else
	$admin_drafted_comments = '<input type="checkbox" name="admin_drafted_comments" value="1" checked>';

if($data_wrm['drafted_cancel'] == '0')
	$admin_drafted_cancel = '<input type="checkbox" name="admin_drafted_cancel" value="0">';
else
	$admin_drafted_cancel = '<input type="checkbox" name="admin_drafted_cancel" value="1" checked>';

if($data_wrm['drafted_delete'] == '0')
	$admin_drafted_delete = '<input type="checkbox" name="admin_drafted_delete" value="0">';
else
	$admin_drafted_delete = '<input type="checkbox" name="admin_drafted_delete" value="1" checked>';
	
	
$wrmadminsmarty->assign('config_data',
	array(
		'action' => "admin_raid_signupgroups.php",
		'user_queue_promote'=>$user_queue_promote,
		'user_queue_comments'=>$user_queue_comments,
		'user_queue_cancel'=>$user_queue_cancel,
		'user_queue_delete'=>$user_queue_delete,
		'user_cancel_queue'=>$user_cancel_queue,
		'user_cancel_promote'=>$user_cancel_promote,
		'user_cancel_comments'=>$user_cancel_comments,
		'user_cancel_delete'=>$user_cancel_delete,
		'user_drafted_queue'=>$user_drafted_queue,
		'user_drafted_comments'=>$user_drafted_comments,
		'user_drafted_cancel'=>$user_drafted_cancel,
		'user_drafted_delete'=>$user_drafted_delete,
		'rl_queue_promote'=>$rl_queue_promote,
		'rl_queue_comments'=>$rl_queue_comments,
		'rl_queue_cancel'=>$rl_queue_cancel,
		'rl_queue_delete'=>$rl_queue_delete,
		'rl_cancel_queue'=>$rl_cancel_queue,
		'rl_cancel_promote'=>$rl_cancel_promote,
		'rl_cancel_comments'=>$rl_cancel_comments,
		'rl_cancel_delete'=>$rl_cancel_delete,
		'rl_drafted_queue'=>$rl_drafted_queue,
		'rl_drafted_comments'=>$rl_drafted_comments,
		'rl_drafted_cancel'=>$rl_drafted_cancel,
		'rl_drafted_delete'=>$rl_drafted_delete,
		'admin_queue_promote'=>$admin_queue_promote,
		'admin_queue_comments'=>$admin_queue_comments,
		'admin_queue_cancel'=>$admin_queue_cancel,
		'admin_queue_delete'=>$admin_queue_delete,
		'admin_cancel_queue'=>$admin_cancel_queue,
		'admin_cancel_promote'=>$admin_cancel_promote,
		'admin_cancel_comments'=>$admin_cancel_comments,
		'admin_cancel_delete'=>$admin_cancel_delete,
		'admin_drafted_queue'=>$admin_drafted_queue,
		'admin_drafted_comments'=>$admin_drafted_comments,
		'admin_drafted_cancel'=>$admin_drafted_cancel,
		'admin_drafted_delete'=>$admin_drafted_delete,
		'queue_def'=>$phprlang['configuration_queue_def'],
		'draft_def'=>$phprlang['configuration_draft_def'],
		'comments_def'=>$phprlang['configuration_comments_def'],
		'cancel_def'=>$phprlang['configuration_cancel_def'],
		'delete_def'=>$phprlang['configuration_delete_def'],
		'admin_text'=>$phprlang['configuraiton_admin'],
		'raidlead_text'=>$phprlang['configuration_raidlead'],
		'user_text'=>$phprlang['configuration_user'],
		'on_queue_text'=>$phprlang['configuration_on_queue'],
		'cancelled_text'=>$phprlang['configuration_cancelled'],
		'drafted_text'=>$phprlang['configuration_drafted'],
		'draft_row_header'=>$phprlang['configuration_draft'],
		'comments_row_header'=>$phprlang['configuration_comments'],
		'cancel_row_header'=>$phprlang['configuration_cancel'],
		'delete_row_header'=>$phprlang['configuration_delete'],
		'queue_row_header'=>$phprlang['configuration_queue'],
		'signup_rights_header'=>$phprlang['configuration_raid_signupgroups_header'],
		'button_submit' => $phprlang['submit'],
		'button_reset' => $phprlang['reset'],
	)
);

if(isset($_POST['submit']))
{
// End of Signup Flow Boxes

//Signup Flow Config
$sql = sprintf(	"UPDATE `" . $phpraid_config['db_prefix'] . "acl_raid_signup_group`".
				" Set `on_queue_draft` = %s, `on_queue_comments` = %s, `on_queue_cancel` = %s, `on_queue_delete` = %s, ".
				"    `cancelled_status_queue` = %s, `cancelled_status_draft` = %s, `cancelled_status_comments` = %s, `cancelled_status_delete` = %s,".	
				" `drafted_queue` = %s, `drafted_comments` = %s, `drafted_cancel` = %s, `drafted_delete` = %s".
				" WHERE `" . $phpraid_config['db_prefix'] . "acl_raid_signup_group`.`signup_group_id` = %s;",
				quote_smart(isset($_POST['user_queue_promote'])? 1 : 0), quote_smart(isset($_POST['user_queue_comments'])? 1 : 0), quote_smart(isset($_POST['user_queue_cancel'])? 1 : 0), quote_smart(isset($_POST['user_queue_delete'])? 1 : 0),
				quote_smart(isset($_POST['user_cancel_queue'])? 1 : 0), quote_smart(isset($_POST['user_cancel_promote'])? 1 : 0), quote_smart(isset($_POST['user_cancel_comments'])? 1 : 0), quote_smart(isset($_POST['user_cancel_delete'])? 1 : 0),
				quote_smart(isset($_POST['user_drafted_queue'])? 1 : 0), quote_smart(isset($_POST['user_drafted_comments'])? 1 : 0), quote_smart(isset($_POST['user_drafted_cancel'])? 1 : 0), quote_smart(isset($_POST['user_drafted_delete'])? 1 : 0),
				quote_smart("1")
		);
$db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);

$sql = sprintf(	"UPDATE `" . $phpraid_config['db_prefix'] . "acl_raid_signup_group`".
				" Set `on_queue_draft` = %s, `on_queue_comments` = %s, `on_queue_cancel` = %s, `on_queue_delete` = %s, ".
				"    `cancelled_status_queue` = %s, `cancelled_status_draft` = %s, `cancelled_status_comments` = %s, `cancelled_status_delete` = %s,".	
				" `drafted_queue` = %s, `drafted_comments` = %s, `drafted_cancel` = %s, `drafted_delete` = %s".
				" WHERE `" . $phpraid_config['db_prefix'] . "acl_raid_signup_group`.`signup_group_id` = %s;",
				quote_smart(isset($_POST['rl_queue_promote'])? 1 : 0), quote_smart(isset($_POST['rl_queue_comments'])? 1 : 0), quote_smart(isset($_POST['rl_queue_cancel'])? 1 : 0), quote_smart(isset($_POST['rl_queue_delete'])? 1 : 0),
				quote_smart(isset($_POST['rl_cancel_queue'])? 1 : 0), quote_smart(isset($_POST['rl_cancel_promote'])? 1 : 0), quote_smart(isset($_POST['rl_cancel_comments'])? 1 : 0), quote_smart(isset($_POST['rl_cancel_delete'])? 1 : 0),
				quote_smart(isset($_POST['rl_drafted_queue'])? 1 : 0), quote_smart(isset($_POST['rl_drafted_comments'])? 1 : 0), quote_smart(isset($_POST['rl_drafted_cancel'])? 1 : 0), quote_smart(isset($_POST['rl_drafted_delete'])? 1 : 0),
				quote_smart("2")
		);
$db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);

$sql = sprintf(	"UPDATE `" . $phpraid_config['db_prefix'] . "acl_raid_signup_group`".
				" Set `on_queue_draft` = %s, `on_queue_comments` = %s, `on_queue_cancel` = %s, `on_queue_delete` = %s, ".
				"    `cancelled_status_queue` = %s, `cancelled_status_draft` = %s, `cancelled_status_comments` = %s, `cancelled_status_delete` = %s,".	
				" `drafted_queue` = %s, `drafted_comments` = %s, `drafted_cancel` = %s, `drafted_delete` = %s".
				" WHERE `" . $phpraid_config['db_prefix'] . "acl_raid_signup_group`.`signup_group_id` = %s;",
				quote_smart(isset($_POST['admin_queue_promote'])? 1 : 0), quote_smart(isset($_POST['admin_queue_comments'])? 1 : 0), quote_smart(isset($_POST['admin_queue_cancel'])? 1 : 0), quote_smart(isset($_POST['admin_queue_delete'])? 1 : 0),
				quote_smart(isset($_POST['admin_cancel_queue'])? 1 : 0), quote_smart(isset($_POST['admin_cancel_promote'])? 1 : 0), quote_smart(isset($_POST['admin_cancel_comments'])? 1 : 0), quote_smart(isset($_POST['admin_cancel_delete'])? 1 : 0),
				quote_smart(isset($_POST['admin_drafted_queue'])? 1 : 0), quote_smart(isset($_POST['admin_drafted_comments'])? 1 : 0), quote_smart(isset($_POST['admin_drafted_cancel'])? 1 : 0), quote_smart(isset($_POST['admin_drafted_delete'])? 1 : 0),
				quote_smart("3")
		);
$db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);

header("Location: admin_raid_signupgroups.php");
}

//
// Start output of the page.
//
require_once('./includes/admin_page_header.php');
$wrmadminsmarty->display('admin_raid_signupgroups.html');
require_once('./includes/admin_page_footer.php');

?>
