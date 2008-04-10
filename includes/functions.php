<?php
/***************************************************************************
*                               functions.php
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
function email($to, $subject, $message) {
	global $phpraid_config;
	
	$message .= "\n\n" . $phpraid_config['email_signature'];
	
	$mheaders = 'From: ' . $phpraid_config['guild_name'] . '<' . $phpraid_config['admin_email'] . '>' . "\r\n" .
		   'Reply-To: '  . $phpraid_config['admin_email'] . "\r\n" .
		   'Return-Path: <' . $phpraid_config['admin_email'] . "\r\n" .
		   'X-Mailer: PHP/' . phpversion();
	
	mail($to, $subject, $message, $mheaders);
}

function print_error($type, $error, $die) {
	global $phprlang, $phpraid_config;
	
	$errorMsg = '<html><link rel="stylesheet" type="text/css" href="templates/'.$phpraid_config['template'].'/style/stylesheet.css"><body>';
	$errorMsg .= '<div align="center">'.$phprlang['print_error_msg_begin'];
	
	if($die == 1)
		$errorMsg .= $phprlang['print_error_critical'];
	else
		$errorMsg .= $phprlang['print_error_minor'];
		
	$errorMsg .= '<br><br><b>'.$phprlang['print_error_page'].':</b> ' . $_SERVER['PHP_SELF'];
	$errorMsg .= '<br><br><b>'.$phprlang['print_error_query'].':</b> ' . $type;
	$errorMsg .= '<br><br><b>'.$phprlang['print_error_details'].':</b> ' . $error;
	$errorMsg .= '<br><br><b>'.$phprlang['print_error_msg_end'].'</b></div></body></html>';
	$errorTitle = $phprlang['print_error_title'];
	
	echo '<div align="center"><div class="errorHeader" style="width:600px">'.$errorTitle .'</div>';
	echo '<div class="errorBody" style="width:600px">'.$errorMsg.'</div></div>';
	
	if($die == 1)
		exit;
}

function quote_smart($value)
{
   // Stripslashes
   if (get_magic_quotes_gpc()) {
       $value = stripslashes($value);
   }
   // Quote if not a number or a numeric string
   if (!is_numeric($value)) {
       $value = "'" . mysql_real_escape_string($value) . "'";
   }
   return $value;
}

function setup_output() {
	global $report;
	
	$report->setMainAttributes('width="100%" cellpadding="3" cellspacing="0" border="0" class="dataOutline"');
	$report->setRowAttributes('class="row1"', 'class="row2"', 'rowHover');
	$report->setFieldHeadingAttributes('class="listHeader"');
}
?>