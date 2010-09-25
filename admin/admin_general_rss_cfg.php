<?php
/***************************************************************************
                           admin_general_rss_cfg.php
 *                            -------------------
 *   begin                : Fr, Sep 25, 2010
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

$page_url = "admin_general_rss_cfg.php";

$rss_site_url = '<input name="rss_site_url" size="60" type="text" class="post" value="' . $phpraid_config['rss_site_url'] . '">';
$rss_export_url = '<input name="rss_export_url" size="60" type="text" class="post" value="' . $phpraid_config['rss_export_url'] . '">';
$rss_feed_amt = '<input name="rss_feed_amt" size="10" type="text" class="post" value="' . $phpraid_config['rss_feed_amt'] . '">';

$wrmadminsmarty->assign('config_data',
	array(
		'form_action'=> $page_url,
		'rss_header' => $phprlang['configuration_rss_header'],
		'rss_site_text' => $phprlang['configuration_rss_site'],
		'rss_export_text' => $phprlang['configuration_rss_export'],
		'rss_feed_amt_txt' => $phprlang['configuration_rss_feed_amt'],
		'rss_site_url' => $rss_site_url,
		'rss_export_url' => $rss_export_url,
		'rss_feed_amt' => $rss_feed_amt,
		'button_submit' => $phprlang['submit'],
		'button_reset' => $phprlang['reset']
	)
);

if(isset($_POST['submit']))
{
	$rss_site_url_p = scrub_input($_POST['rss_site_url'], true);
	$rss_export_url_p = scrub_input($_POST['rss_export_url'], true);
	$rss_feed_amt_p = scrub_input($_POST['rss_feed_amt']);

	$db_raid->sql_query($sql) or print_error($sql,$db_raid->sql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'rss_site_url';", quote_smart($rss_site_url_p));
	$db_raid->sql_query($sql) or print_error($sql,$db_raid->sql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'rss_export_url';", quote_smart($rss_export_url_p));
	$db_raid->sql_query($sql) or print_error($sql,$db_raid->sql_error(),1);
	$sql=sprintf("UPDATE `".$phpraid_config['db_prefix']."config` SET `config_value` = %s WHERE `config_name`= 'rss_feed_amt';", quote_smart($rss_feed_amt_p));
	$db_raid->sql_query($sql) or print_error($sql,$db_raid->sql_error(),1);
	
	header("Location: ".$page_url);
}

//
// Start output of the page.
//
require_once('./includes/admin_page_header.php');
$wrmadminsmarty->display('admin_general_rss_cfg.html');
require_once('./includes/admin_page_footer.php');

?>