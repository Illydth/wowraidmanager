<?php
/***************************************************************************
 *                             auth_phpraid.php
 *                            -------------------
 *   begin                : Monday, Jan 18, 2005
 *   copyright            : (C) 2007-2008 Douglas Wagner
 *   email                : douglasw@wagnerweb.org
 *
 *   $Id: auth_phpraid.php,v 2.00 2007/11/23 14:25:57 psotfx Exp $
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

if ( !defined('IN_PHPRAID'))
	print_error("Hacking Attempt", "Invalid access detected", 1);

if(isset($_GET['phpraid_dir']) || isset($_POST['phpraid_dir']))
	die("Hacking attempt detected!");

$BridgeSupportPWDChange = TRUE;
$Bridge2ColumGroup = FALSE;

/*********************************************** 
 * Table and Column Names - change per CMS.
 ***********************************************/
// Column Name for the ID field for the User.
$db_user_id = "profile_id";
// Column Name for the UserName field.
$db_user_name = "username";
// Column Name for the User's E-Mail Address
$db_user_email = "email";
// Column Name for the User's password
$db_user_password = "password";

$db_table_user_name = "profile";

$table_prefix = $phpraid_config['db_prefix'];

$auth_user_class = "";
$auth_alt_user_class = "";
	
//change password in WRM DB
function db_password_change($profile_id, $dbusernewpassword)
{
	global $db_raid, $phpraid_config;

	//convert pwd
	//$dbusernewpassword = $pwd_hasher->HashPassword(dbusernewpassword);
	$dbusernewpassword = md5($dbusernewpassword);


	//check: is profile_id in WRM DB
	$sql = sprintf(	"SELECT profile_id ".
					" FROM " . $phpraid_config['db_prefix'] . "profile ".
					" WHERE profile_id = %s", quote_smart($profile_id)
			);
	$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(),1);
	if ($db_raid->sql_numrows($result) != 1) {
		//user not found in WRM DB
		return 2;
	}

	$sql = sprintf("UPDATE " . $phpraid_config['db_prefix'] . "profile SET password = %s WHERE profile_id = %s", 
				quote_smart($dbusernewpassword), quote_smart($profile_id)
			);

	if (($db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1)) == true)
	{
		//pwd change
		return 1;
	}
	else
	{
		//pwd NOT change
		return 0;
	} 
}

//compare password
//return value -> $data['password'] (Password from CMS database) upon success, FALSE upon fail.
function password_check($oldpassword, $profile_id, $encryptflag)
{
	global $db_raid, $phpraid_config;
	$sql = sprintf(	"SELECT password ".
					" FROM " . $phpraid_config['db_prefix'] . "profile ".
					" WHERE profile_id = %s", quote_smart($profile_id)
			);
	$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	$data = $db_raid->sql_fetchrow($result, true);
	
	if ($encryptflag)
	{ // Encrypted Password Sent In.
		if ($oldpassword == $data['password'])
			return $data['password'];
		else
			return FALSE;
	}
	else 
	{ // Plain text password sent in.
		if (md5($oldpassword) == $data['password'])
			return $data['password'];
		else
			return FALSE;
	}
}

?>
