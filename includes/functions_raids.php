<?php
/***************************************************************************
*                           functions_raids.php
*                           ---------------------
*   begin                : Mon, Sep 20, 2010
*   copyright            : (C) 2007-2010 Carsten Hölbing
*   email                : carsten@hoelbing.net
*
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
/*
 * Raid: del
 */
function raid_del($id, $n)
{	
	global $phpraid_config, $db_raid;
	
	log_delete('raid',$n);

	$sql = sprintf(	"DELETE FROM " . $phpraid_config['db_prefix'] . "raids ".
					"	WHERE raid_id=%s", quote_smart($id));
	$db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);

	$sql = sprintf(	"DELETE FROM " . $phpraid_config['db_prefix'] . "signups".
					"	WHERE raid_id=%s", quote_smart($id));
	$db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);

	$sql = sprintf(	"DELETE FROM " . $phpraid_config['db_prefix'] . "raid_class_lmt ".
					"	WHERE raid_id=%s",quote_smart($id));
	$db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);

	$sql = sprintf(	"DELETE FROM " . $phpraid_config['db_prefix'] . "raid_role_lmt ".
					"	WHERE raid_id=%s",quote_smart($id));
	$db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
		
}

function raid_mark($raid_id)
{
	global $phpraid_config, $db_raid;
	
	$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "raids WHERE raid_id=%s", quote_smart($raid_id));
	$result = $db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	$data = $db_raid->sql_fetchrow($result, true);
	
	if($data['old'] == 1)
	{
		$sql = sprintf("UPDATE " . $phpraid_config['db_prefix'] . "raids SET old='0' WHERE raid_id=%s", quote_smart($raid_id));
		$db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	}
	else
	{
		$sql = sprintf("UPDATE " . $phpraid_config['db_prefix'] . "raids SET old='1' WHERE raid_id=%s", quote_smart($raid_id));
		$db_raid->sql_query($sql) or print_error($sql, $db_raid->sql_error(), 1);
	}
}

?>
