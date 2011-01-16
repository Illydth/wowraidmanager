<?php
/***************************************************************************
 *                          functions_mbwrapper.php
 *                           --------------------
 *   begin                : Sunday, May 16, 2010
 *   copyright            : (C) 2007-2010 Douglas Wagner
 *   email                : douglasw@wagnerweb.org
 *
  ***************************************************************************/

/***************************************************************************
*
*    WoW Raid Manager - Raid Management Software for World of Warcraft
*    Copyright (C) 2007-2010 Douglas Wagner
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
/*
 * more infos here
 * http://www.php.net/manual/en/book.mbstring.php
 */


function strtolower_wrap($str, $encoding)
{
	if (function_exists('mb_strtolower') and ($phpraid_config['wrm_mbstring_support'] == 'yes'))
		$retstr = mb_strtolower($str, $encoding);
	else if (function_exists('strtolower'))
		$retstr = strtolower($str);
	else 
		$retstr = $str;
	return $retstr;
}

function strlen_wrap($str, $encoding)
{
	if (function_exists('mb_strlen') and ($phpraid_config['wrm_mbstring_support'] == 'yes'))
		$retlen = mb_strlen($str, $encoding);
	else if (function_exists('strlen'))
		$retlen = strlen($str);
	else 
		$retlen = FALSE;
	return $retlen;
}

function substr_wrap($str, $start, $length, $encoding)
{
	if (function_exists('mb_substr') and ($phpraid_config['wrm_mbstring_support'] == 'yes'))
		$retstr = mb_substr($str, $start, $length, $encoding);
	else if (function_exists('substr'))
		$retstr = substr($str, $start, $length);
	else 
		$retstr = $str;
	return $retstr;
}

function strtoupper_wrap($str, $encoding)
{
	if (function_exists('mb_strtoupper') and ($phpraid_config['wrm_mbstring_support'] == 'yes'))
		$retstr = mb_strtoupper($str, $encoding);
	else if (function_exists('strtoupper'))
		$retstr = strtoupper($str);
	else 
		$retstr = $str;
	return $retstr;
}

function convertcase_wrap($str, $mode, $encoding)
{
	if (function_exists('mb_convert_case')and ($phpraid_config['wrm_mbstring_support'] == 'yes'))
		$retstr = mb_convert_case($str, $mode, $encoding);
	else if (function_exists('strtoupper') && $mode==MB_CASE_UPPER)
		$retstr = strtoupper($str);
	else if (function_exists('strtolower') && $mode==MB_CASE_LOWER)
		$retstr = strtolower($str);
	else 
		$retstr = $str;
	return $retstr;
}


?>