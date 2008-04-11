<?php
/***************************************************************************
 *                              lua_output.php
 *                            -------------------
 *   begin                : Saturday, Jan 16, 2005
 *   copyright            : (C) 2005 Kyle Spraggs
 *   email                : spiffyjr@gmail.com
 *
 *   $Id: mysql.php,v 1.16 2002/03/19 01:07:36 psotfx Exp $
 *
 ***************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/
 $raid_id = $_GET['raid_id'];
 
// commons
define("IN_PHPRAID", true);	
require_once('./common.php');

// page authentication
// page authentication
if ($phpraid_config['enable_five_man'])
{ 
	define("PAGE_LVL","profile");
}
else
{
	define("PAGE_LVL","raids");
}

require_once($phpraid_dir.'includes/authentication.php');
require_once('./lua_output_data.php');

if($phpraid_config['showphpraid_addon'] == 1)
	$phpraid_addon_link = '<a href="' . $phpraid_config['phpraid_addon_link'] . '">' . $phprlang['lua_download'] . '</a>';
else
	$phpraid_addon_link = '';

//
// Start output of page
//
require_once('includes/page_header.php');

$page->set_file('output',$phpraid_config['template'] . '/lua_output.htm');

if($phpraid_config['showphpraid_addon'] == 1)
	$page->set_var('output_header',$phprlang['lua_header'] . ' - ' . $phpraid_addon_link);
else
	$page->set_var('output_header',$phprlang['lua_header']);

$page->set_var(
	array(
		'output_data'=>$text,
		)
);

$page->pparse('output','output');

require_once('includes/page_footer.php');
?>