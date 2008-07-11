<?php
/***************************************************************************
*                               functions.php
*                            -------------------
*   begin                : Saturday, Jan 16, 2005
*   copyright            : (C) 2007-2008 Douglas Wagner
*   email                : douglasw@wagnerweb.org
*
*   $Id: functions.php,v 2.00 2008/03/03 14:18:34 psotfx Exp $
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

function quote_smart_old($value)
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

function quote_smart($value = "", $nullify = false, $conn = null)
{
	//reset default if second parameter is skipped
	$nullify = ($nullify === null) ? (false) : ($nullify);
	//undo slashes for poorly configured servers
	$value = (get_magic_quotes_gpc()) ? (stripslashes($value)) : ($value);
	//check for null/unset/empty strings (takes advantage of short-circuit evals to avoid a warning)
	if ((!isset($value)) || (is_null($value)) || ($value === ""))
	{
		$value = ($nullify) ? ("NULL") : ("''");
	}
	else
	{
		if (is_string($value))
		{
			//value is a string and should be quoted; determine best method based on available extensions
			if (function_exists('mysql_real_escape_string'))
			{
				$value = "'" . (((isset($conn)) && (is_resource($conn))) ? (mysql_real_escape_string($value, $conn)) : (mysql_real_escape_string($value))) . "'";
			}
			else
			{
				$value = "'" . mysql_escape_string($value) . "'";
			}
		}
		else
		{
			//value is not a string; if not numeric, bail with error
			$value = (is_numeric($value)) ? ($value) : ("'ERROR: unhandled datatype in quote_smart'");
		}
	}
	return $value;
}

function scrub_input($value = "", $html_allowed = false)
{
	$value=strip_tags($value, '<br><a>');

	if (!$html_allowed)
		$value = htmlspecialchars($value);

	return $value;
}

function setup_output() {
	global $report;

	$report->setMainAttributes('width="100%" cellpadding="3" cellspacing="0" border="0" class="dataOutline"');
	$report->setRowAttributes('class="row1"', 'class="row2"', 'rowHover');
	$report->setFieldHeadingAttributes('class="listHeader"');
}

function get_armorychar($name, $language, $server)
{
	if(substr($name, 0, 1) == '_')
	{
		$name = substr($name, 1);
		$name = '<!-- ' . ucfirst($name) . ' -->(<script type="text/javascript"> if(tipcount){ tipcount = tipcount + 1; } else { var tipcount = 1 } document.write("<span id=\"tip-"+tipcount+"\"></span>"); sendRequest_char("' . ucfirst($server) . '", "tip-"+tipcount, "' . ucfirst($name) . '", "'. $language .'"); </script><noscript>' . ucfirst($name) . '</noscript>)';
	}
	else if(substr($name, 0, 1) == '(' && substr($name, strlen($name) - 1, 1) == ')')
	{
		$name = substr($name, 1, strlen($name) - 2);
		$name = '<!-- ' . ucfirst($name) . ' -->(<script type="text/javascript"> if(tipcount){ tipcount = tipcount + 1; } else { var tipcount = 1 } document.write("<span id=\"tip-"+tipcount+"\"></span>"); sendRequest_char("' . ucfirst($server) . '", "tip-"+tipcount, "' . ucfirst($name) . '", "'. $language .'"); </script><noscript>' . ucfirst($name) . '</noscript>)';
	}
	else
	{
		$name = '<!-- ' . ucfirst($name) . ' --><script type="text/javascript"> if(tipcount){ tipcount = tipcount + 1; } else { var tipcount = 1 } document.write("<span id=\"tip-"+tipcount+"\"></span>"); sendRequest_char("' . ucfirst($server) . '", "tip-"+tipcount, "' . ucfirst($name) . '", "'. $language .'"); </script><noscript>' . ucfirst($name) . '</noscript>';
	}

	return $name;
}

function get_color($text, $signedup, $onqueue, $wanted, $type, $extracount, $ddsignedup, $ddonqueue, $ddwanted, &$minustkmel)
{
        $color = '';

        if($type == 2)
        {
                // melee + ranged
                $count_available = $ddsignedup + $ddonqueue;
                $count_onqueue = $ddonqueue;
                $count_wanted = $ddwanted;
        }
        else
        {
                $count_available = $signedup + $onqueue;
                $count_onqueue = $onqueue;
                $count_wanted = $wanted;
        }

        if($type == 1)
        {
                // tank/melee
                if($minustkmel <= $count_available)
                {
                        $count_available = $count_available - $minustkmel;
                }
                else
                {
                        $count_available = 0;
                        $extracount = $extracount - $minustkmel;
                }
        }

        if($count_available < $count_wanted)
        {
                if($count_available + $extracount < $count_wanted)
                {
                        if($type != 2 || $signedup + $onqueue < $wanted)
                        {
                                $color = '#cc0000';
                        }
                        $minustkmel = $minustkmel + $extracount;
                }
                else
                {
                        $minustkmel = $minustkmel + $count_wanted - $count_available;
                }
        }
        else if($count_available - $count_onqueue > $count_wanted)
        {
                if($type != 2 || $signedup > $wanted)
                {
                        $color = '#ffff00';
                }
        }

        return $color ? '<font color="' . $color . '">' . $text . '</font>' : $text;
}

function get_coloredcount($signedup, $onqueue, $wanted, $type, $extracount, $ddsignedup, $ddonqueue, $ddwanted, &$minustkmel)
{
        return '<!-- ' . $signedup . ' -->' . get_color($signedup . "/" . $wanted . ($onqueue ? '(+' . $onqueue . ')' : ''), $signedup, $onqueue, $wanted, $type, $extracount, $ddsignedup, $ddonqueue, $ddwanted, $minustkmel);
}

function linebreak_to_br($str) {
  $str = preg_replace("/(\r\n?)|(\n\r?)/s", "<br />", $str);
	
	return $str;
}

function strip_linebreaks($str) {
  $str = preg_replace("/(\r\n?)+|(\n\r?)+/s", " ", $str);
  
  return $str;
}

// Sanitizes data for entry into the database. Escapes special
// characters and encodes html entities.
function sanitize(&$array) {
  escape_db_data($array);
  
  return $array;
}

// Reverses database sanitization by removing escape backslashes
// and decoding html entities.
function desanitize(&$array) {
  @unescape_db_data($array);
  
  return $array;
}

function escape_db_data(&$array) {
  foreach($array as &$value) {
    if (is_string($value)) {
      escape_data($value);
    }
  }
  unset($value);
}

function escape_data(&$data) {
  $data = addslashes($data);
  $data = htmlspecialchars($data);
}

function unescape_db_data(&$array) {

  foreach($array as &$value) {
    if (is_string($value)) {
      unescape_data($value);
    }
  }
  unset($value);
}

function unescape_data(&$data) {
  $data = stripslashes($data);
  $data = htmlspecialchars_decode($data);
}

function magic_quotes_on() {
  if ((get_magic_quotes_gpc() == '0') OR (strtolower(get_magic_quotes_gpc()) == 'off')) {
    return false;
  }
  
  return true;
}

function get_dupesignup_symbol()
{
	return '<font color="' . '#cc0000' . '"><b>!</b></font>';
}

?>
