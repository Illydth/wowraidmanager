<?php
/***************************************************************************
                                admin_index.php
 *                            -------------------
 *   begin                : Monday, May 11, 2009
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

/* 
 * Data for Index Page
 */
// Setup the Signup Flow Configuration Area - Setup Checkboxes
// 		User Permissions
if($phpraid_config['user_queue_promote'] == '0')
	$user_queue_promote = '<input type="checkbox" name="user_queue_promote" value="1">';
else
	$user_queue_promote = '<input type="checkbox" name="user_queue_promote" value="1" checked>';

if($phpraid_config['user_queue_comments'] == '0')
	$user_queue_comments = '<input type="checkbox" name="user_queue_comments" value="1">';
else
	$user_queue_comments = '<input type="checkbox" name="user_queue_comments" value="1" checked>';

if($phpraid_config['user_queue_cancel'] == '0')
	$user_queue_cancel = '<input type="checkbox" name="user_queue_cancel" value="1">';
else
	$user_queue_cancel = '<input type="checkbox" name="user_queue_cancel" value="1" checked>';

if($phpraid_config['user_queue_delete'] == '0')
	$user_queue_delete = '<input type="checkbox" name="user_queue_delete" value="1">';
else
	$user_queue_delete = '<input type="checkbox" name="user_queue_delete" value="1" checked>';

if($phpraid_config['user_cancel_queue'] == '0')
	$user_cancel_queue = '<input type="checkbox" name="user_cancel_queue" value="1">';
else
	$user_cancel_queue = '<input type="checkbox" name="user_cancel_queue" value="1" checked>';

if($phpraid_config['user_cancel_promote'] == '0')
	$user_cancel_promote = '<input type="checkbox" name="user_cancel_promote" value="1">';
else
	$user_cancel_promote = '<input type="checkbox" name="user_cancel_promote" value="1" checked>';

if($phpraid_config['user_cancel_comments'] == '0')
	$user_cancel_comments = '<input type="checkbox" name="user_cancel_comments" value="1">';
else
	$user_cancel_comments = '<input type="checkbox" name="user_cancel_comments" value="1" checked>';

if($phpraid_config['user_cancel_delete'] == '0')
	$user_cancel_delete = '<input type="checkbox" name="user_cancel_delete" value="1">';
else
	$user_cancel_delete = '<input type="checkbox" name="user_cancel_delete" value="1" checked>';

if($phpraid_config['user_drafted_queue'] == '0')
	$user_drafted_queue = '<input type="checkbox" name="user_drafted_queue" value="1">';
else
	$user_drafted_queue = '<input type="checkbox" name="user_drafted_queue" value="1" checked>';

if($phpraid_config['user_drafted_comments'] == '0')
	$user_drafted_comments = '<input type="checkbox" name="user_drafted_comments" value="1">';
else
	$user_drafted_comments = '<input type="checkbox" name="user_drafted_comments" value="1" checked>';

if($phpraid_config['user_drafted_cancel'] == '0')
	$user_drafted_cancel = '<input type="checkbox" name="user_drafted_cancel" value="1">';
else
	$user_drafted_cancel = '<input type="checkbox" name="user_drafted_cancel" value="1" checked>';

if($phpraid_config['user_drafted_delete'] == '0')
	$user_drafted_delete = '<input type="checkbox" name="user_drafted_delete" value="1">';
else
	$user_drafted_delete = '<input type="checkbox" name="user_drafted_delete" value="1" checked>';

// 		Raid Leader Permissions
if($phpraid_config['rl_queue_promote'] == '0')
	$rl_queue_promote = '<input type="checkbox" name="rl_queue_promote" value="1">';
else
	$rl_queue_promote = '<input type="checkbox" name="rl_queue_promote" value="1" checked>';

if($phpraid_config['rl_queue_comments'] == '0')
	$rl_queue_comments = '<input type="checkbox" name="rl_queue_comments" value="1">';
else
	$rl_queue_comments = '<input type="checkbox" name="rl_queue_comments" value="1" checked>';

if($phpraid_config['rl_queue_cancel'] == '0')
	$rl_queue_cancel = '<input type="checkbox" name="rl_queue_cancel" value="1">';
else
	$rl_queue_cancel = '<input type="checkbox" name="rl_queue_cancel" value="1" checked>';

if($phpraid_config['rl_queue_delete'] == '0')
	$rl_queue_delete = '<input type="checkbox" name="rl_queue_delete" value="1">';
else
	$rl_queue_delete = '<input type="checkbox" name="rl_queue_delete" value="1" checked>';

if($phpraid_config['rl_cancel_queue'] == '0')
	$rl_cancel_queue = '<input type="checkbox" name="rl_cancel_queue" value="1">';
else
	$rl_cancel_queue = '<input type="checkbox" name="rl_cancel_queue" value="1" checked>';

if($phpraid_config['rl_cancel_promote'] == '0')
	$rl_cancel_promote = '<input type="checkbox" name="rl_cancel_promote" value="1">';
else
	$rl_cancel_promote = '<input type="checkbox" name="rl_cancel_promote" value="1" checked>';

if($phpraid_config['rl_cancel_comments'] == '0')
	$rl_cancel_comments = '<input type="checkbox" name="rl_cancel_comments" value="1">';
else
	$rl_cancel_comments = '<input type="checkbox" name="rl_cancel_comments" value="1" checked>';

if($phpraid_config['rl_cancel_delete'] == '0')
	$rl_cancel_delete = '<input type="checkbox" name="rl_cancel_delete" value="1">';
else
	$rl_cancel_delete = '<input type="checkbox" name="rl_cancel_delete" value="1" checked>';

if($phpraid_config['rl_drafted_queue'] == '0')
	$rl_drafted_queue = '<input type="checkbox" name="rl_drafted_queue" value="1">';
else
	$rl_drafted_queue = '<input type="checkbox" name="rl_drafted_queue" value="1" checked>';

if($phpraid_config['rl_drafted_comments'] == '0')
	$rl_drafted_comments = '<input type="checkbox" name="rl_drafted_comments" value="1">';
else
	$rl_drafted_comments = '<input type="checkbox" name="rl_drafted_comments" value="1" checked>';

if($phpraid_config['rl_drafted_cancel'] == '0')
	$rl_drafted_cancel = '<input type="checkbox" name="rl_drafted_cancel" value="1">';
else
	$rl_drafted_cancel = '<input type="checkbox" name="rl_drafted_cancel" value="1" checked>';

if($phpraid_config['rl_drafted_delete'] == '0')
	$rl_drafted_delete = '<input type="checkbox" name="rl_drafted_delete" value="1">';
else
	$rl_drafted_delete = '<input type="checkbox" name="rl_drafted_delete" value="1" checked>';

// 		Administrator Permissions
if($phpraid_config['admin_queue_promote'] == '0')
	$admin_queue_promote = '<input type="checkbox" name="admin_queue_promote" value="1">';
else
	$admin_queue_promote = '<input type="checkbox" name="admin_queue_promote" value="1" checked>';

if($phpraid_config['admin_queue_comments'] == '0')
	$admin_queue_comments = '<input type="checkbox" name="admin_queue_comments" value="1">';
else
	$admin_queue_comments = '<input type="checkbox" name="admin_queue_comments" value="1" checked>';

if($phpraid_config['admin_queue_cancel'] == '0')
	$admin_queue_cancel = '<input type="checkbox" name="admin_queue_cancel" value="1">';
else
	$admin_queue_cancel = '<input type="checkbox" name="admin_queue_cancel" value="1" checked>';

if($phpraid_config['admin_queue_delete'] == '0')
	$admin_queue_delete = '<input type="checkbox" name="admin_queue_delete" value="1">';
else
	$admin_queue_delete = '<input type="checkbox" name="admin_queue_delete" value="1" checked>';

if($phpraid_config['admin_cancel_queue'] == '0')
	$admin_cancel_queue = '<input type="checkbox" name="admin_cancel_queue" value="1">';
else
	$admin_cancel_queue = '<input type="checkbox" name="admin_cancel_queue" value="1" checked>';

if($phpraid_config['admin_cancel_promote'] == '0')
	$admin_cancel_promote = '<input type="checkbox" name="admin_cancel_promote" value="1">';
else
	$admin_cancel_promote = '<input type="checkbox" name="admin_cancel_promote" value="1" checked>';

if($phpraid_config['admin_cancel_comments'] == '0')
	$admin_cancel_comments = '<input type="checkbox" name="admin_cancel_comments" value="1">';
else
	$admin_cancel_comments = '<input type="checkbox" name="admin_cancel_comments" value="1" checked>';

if($phpraid_config['admin_cancel_delete'] == '0')
	$admin_cancel_delete = '<input type="checkbox" name="admin_cancel_delete" value="1">';
else
	$admin_cancel_delete = '<input type="checkbox" name="admin_cancel_delete" value="1" checked>';

if($phpraid_config['admin_drafted_queue'] == '0')
	$admin_drafted_queue = '<input type="checkbox" name="admin_drafted_queue" value="1">';
else
	$admin_drafted_queue = '<input type="checkbox" name="admin_drafted_queue" value="1" checked>';

if($phpraid_config['admin_drafted_comments'] == '0')
	$admin_drafted_comments = '<input type="checkbox" name="admin_drafted_comments" value="1">';
else
	$admin_drafted_comments = '<input type="checkbox" name="admin_drafted_comments" value="1" checked>';

if($phpraid_config['admin_drafted_cancel'] == '0')
	$admin_drafted_cancel = '<input type="checkbox" name="admin_drafted_cancel" value="1">';
else
	$admin_drafted_cancel = '<input type="checkbox" name="admin_drafted_cancel" value="1" checked>';

if($phpraid_config['admin_drafted_delete'] == '0')
	$admin_drafted_delete = '<input type="checkbox" name="admin_drafted_delete" value="1">';
else
	$admin_drafted_delete = '<input type="checkbox" name="admin_drafted_delete" value="1" checked>';

$buttons = '<input type="submit" name="submit" value="'.$phprlang['submit'].'" class="mainoption"> <input type="reset" name="Reset" value="'.$phprlang['reset'].'" class="liteoption">';	
	
$wrmadminsmarty->assign('config_data',
	array(
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
		'signup_rights_header'=>$phprlang['configuration_signup_rights_header'],
		'buttons' => $buttons,
	)
);

if(isset($_POST['submit']))
{
		// Process Signup Flow Checkboxes
	if(isset($_POST['user_queue_promote']))
		$uqp = 1;
	else
		$uqp = 0;
	if(isset($_POST['user_queue_comments']))
		$uqc = 1;
	else
		$uqc = 0;
	if(isset($_POST['user_queue_cancel']))
		$uqa = 1;
	else
		$uqa = 0;
	if(isset($_POST['user_queue_delete']))
		$uqd = 1;
	else
		$uqd = 0;
	if(isset($_POST['user_cancel_queue']))
		$ucq = 1;
	else
		$ucq = 0;
	if(isset($_POST['user_cancel_promote']))
		$ucp = 1;
	else
		$ucp = 0;
	if(isset($_POST['user_cancel_comments']))
		$ucc = 1;
	else
		$ucc = 0;
	if(isset($_POST['user_cancel_delete']))
		$ucd = 1;
	else
		$ucd = 0;
	if(isset($_POST['user_drafted_queue']))
		$udq = 1;
	else
		$udq = 0;
	if(isset($_POST['user_drafted_comments']))
		$udc = 1;
	else
		$udc = 0;
	if(isset($_POST['user_drafted_cancel']))
		$uda = 1;
	else
		$uda = 0;
	if(isset($_POST['user_drafted_delete']))
		$udd = 1;
	else
		$udd = 0;
	if(isset($_POST['rl_queue_promote']))
		$rqp = 1;
	else
		$rqp = 0;
	if(isset($_POST['rl_queue_comments']))
		$rqc = 1;
	else
		$rqc = 0;
	if(isset($_POST['rl_queue_cancel']))
		$rqa = 1;
	else
		$rqa = 0;
	if(isset($_POST['rl_queue_delete']))
		$rqd = 1;
	else
		$rqd = 0;
	if(isset($_POST['rl_cancel_queue']))
		$rcq = 1;
	else
		$rcq = 0;
	if(isset($_POST['rl_cancel_promote']))
		$rcp = 1;
	else
		$rcp = 0;
	if(isset($_POST['rl_cancel_comments']))
		$rcc = 1;
	else
		$rcc = 0;
	if(isset($_POST['rl_cancel_delete']))
		$rcd = 1;
	else
		$rcd = 0;
	if(isset($_POST['rl_drafted_queue']))
		$rdq = 1;
	else
		$rdq = 0;
	if(isset($_POST['rl_drafted_comments']))
		$rdc = 1;
	else
		$rdc = 0;
	if(isset($_POST['rl_drafted_cancel']))
		$rda = 1;
	else
		$rda = 0;
	if(isset($_POST['rl_drafted_delete']))
		$rdd = 1;
	else
		$rdd = 0;
	if(isset($_POST['admin_queue_promote']))
		$aqp = 1;
	else
		$aqp = 0;
	if(isset($_POST['admin_queue_comments']))
		$aqc = 1;
	else
		$aqc = 0;
	if(isset($_POST['admin_queue_cancel']))
		$aqa = 1;
	else
		$aqa = 0;
	if(isset($_POST['admin_queue_delete']))
		$aqd = 1;
	else
		$aqd = 0;
	if(isset($_POST['admin_cancel_queue']))
		$acq = 1;
	else
		$acq = 0;
	if(isset($_POST['admin_cancel_promote']))
		$acp = 1;
	else
		$acp = 0;
	if(isset($_POST['admin_cancel_comments']))
		$acc = 1;
	else
		$acc = 0;
	if(isset($_POST['admin_cancel_delete']))
		$acd = 1;
	else
		$acd = 0;
	if(isset($_POST['admin_drafted_queue']))
		$adq = 1;
	else
		$adq = 0;
	if(isset($_POST['admin_drafted_comments']))
		$adc = 1;
	else
		$adc = 0;
	if(isset($_POST['admin_drafted_cancel']))
		$ada = 1;
	else
		$ada = 0;
	if(isset($_POST['admin_drafted_delete']))
		$add = 1;
	else
		$add = 0;
// End of Signup Flow Boxes

	//Signup Flow Config
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'user_queue_promote';", quote_smart($uqp));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'user_queue_comments';", quote_smart($uqc));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'user_queue_cancel';", quote_smart($uqa));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'user_queue_delete';", quote_smart($uqd));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'user_cancel_queue';", quote_smart($ucq));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'user_cancel_promote';", quote_smart($ucp));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'user_cancel_comments';", quote_smart($ucc));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'user_cancel_delete';", quote_smart($ucd));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'user_drafted_queue';", quote_smart($udq));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'user_drafted_comments';", quote_smart($udc));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'user_drafted_cancel';", quote_smart($uda));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'user_drafted_delete';", quote_smart($udd));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'rl_queue_promote';", quote_smart($rqp));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'rl_queue_comments';", quote_smart($rqc));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'rl_queue_cancel';", quote_smart($rqa));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'rl_queue_delete';", quote_smart($rqd));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'rl_cancel_queue';", quote_smart($rcq));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'rl_cancel_promote';", quote_smart($rcp));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'rl_cancel_comments';", quote_smart($rcc));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'rl_cancel_delete';", quote_smart($rcd));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'rl_drafted_queue';", quote_smart($rdq));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'rl_drafted_comments';", quote_smart($rdc));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'rl_drafted_cancel';", quote_smart($rda));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'rl_drafted_delete';", quote_smart($rdd));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'admin_queue_promote';", quote_smart($aqp));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'admin_queue_comments';", quote_smart($aqc));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'admin_queue_cancel';", quote_smart($aqa));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'admin_queue_delete';", quote_smart($aqd));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'admin_cancel_queue';", quote_smart($acq));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'admin_cancel_promote';", quote_smart($acp));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'admin_cancel_comments';", quote_smart($acc));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'admin_cancel_delete';", quote_smart($acd));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'admin_drafted_queue';", quote_smart($adq));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'admin_drafted_comments';", quote_smart($adc));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'admin_drafted_cancel';", quote_smart($ada));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'admin_drafted_delete';", quote_smart($add));
	$db_raid->sql_query($sql) or print_error($sql,mysql_error(),1);
	
	header("Location: admin_signuprights.php");
}

//
// Start output of the page.
//
require_once('./includes/admin_page_header.php');
$wrmadminsmarty->display('admin_signup_rights.html');
require_once('./includes/admin_page_footer.php');

?>