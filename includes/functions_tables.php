<?php
/***************************************************************************
*                            functions_tables.php
*                            --------------------
*   begin                : Wednesday, Nov 5, 2008
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

/**
* Gets a list of column names from the column_header table for the input report view name.
*	The column name, visibility and image url for the column is returned in sorted order
*	by "position".
* @param string $view_name - The name of the report view to return columns for.
* @return array $table_headers - The array of data including column name, visibility, and image URL
* @access public
*/
function getVisibleColumns($view_name) 
{
	global $phpraid_config, $db_raid;
	
	$table_headers = array();
	
	// Get all the columns from the column_header table
	$sql = sprintf("SELECT * FROM " . $phpraid_config['db_prefix'] . "column_headers WHERE view_name = %s ORDER BY position", quote_smart($view_name));
	
	$result = $db_raid->sql_query($sql) or print_error($sql, mysql_error(), 1);

	// Fail if something isn't returned.
	if (!$db_raid->sql_numrows($result) || $db_raid->sql_numrows($result) < 1)
		return FALSE;

	// Cycle all the columns in the table name view.
	while($data = $db_raid->sql_fetchrow($result, true)) 
	{
		//Replace Columns that start with @ with the proper header names (used to replace
		//  generic "Role1" header with the proper "Role1" header from config.)
		$column_name = $data['column_name'];
		if (strncmp($column_name, '@r', 1) == 0)
		{
			//It's a replacement variable, determine what replacement.
			$repstr = substr($column_name, 1);
			switch($repstr)
			{
				case "role1":
					$column_name = ucfirst($phpraid_config['role1_name']);
					break;
				case "role2":
					$column_name = ucfirst($phpraid_config['role2_name']);
					break;
				case "role3":
					$column_name = ucfirst($phpraid_config['role3_name']);
					break;
				case "role4":
					$column_name = ucfirst($phpraid_config['role4_name']);
					break;
				case "role5":
					$column_name = ucfirst($phpraid_config['role5_name']);
					break;
				case "role6":
					$column_name = ucfirst($phpraid_config['role6_name']);
					break;
			}
		}

		array_push($table_headers,
			array(
				'column_name'=>$column_name,
				'visible'=>$data['visible'],
				'img_url'=>$data['img_url']
			)
		);
	}
	return $table_headers;
}

?>