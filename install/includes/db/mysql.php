<?php
/***************************************************************************
 *                                 mysql.php
 *                            -------------------
 *   begin                : Saturday, Feb 13, 2001
 *   copyright            : (C) 2007-2008 Douglas Wagner (Originally from phpbb.com)
 *   email                : douglasw@wagnerweb.org
 *
 *   $Id: mysql.php,v 2.00 2008/02/29 13:19:25 psotfx Exp $
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

class sql_db
{

	var $db_raid_connect_id;
	var $sql_result;
	var $row = array();
	var $rowset = array();
	var $num_queries = 0;

	//
	// Constructor
	//
	function sql_db($sqlserver, $sqluser, $sqlpassword, $database, $persistency = true)
	{

		$this->persistency = $persistency;
		$this->user = $sqluser;
		$this->password = $sqlpassword;
		$this->server = $sqlserver;
		$this->dbname = $database;

		if($this->persistency)
		{
			$this->db_connect_id = @mysql_pconnect($this->server, $this->user, $this->password);
		}
		else
		{
			$this->db_connect_id = @mysql_connect($this->server, $this->user, $this->password);
		}
		if($this->db_connect_id)
		{
			if($database != "")
			{
				$this->dbname = $database;
				$db_raidselect = @mysql_select_db($this->dbname);
				if(!$db_raidselect)
				{
					@mysql_close($this->db_connect_id);
					$this->db_connect_id = $db_raidselect;
				}
			}
			
			//Force a UTF-8 connection to the Database.  Information comes from a writeup at:
			// http://www.adviesenzo.nl/examples/php_mysql_charset_fix/
			// http://marc.info/?l=php-db&m=120760127026719&w=2
			
			// Make sure any results we retrieve or commands we send use the same charset and collation as the database:
			//$db_charset = mysql_query( "SHOW VARIABLES LIKE 'character_set_database'" );
			//$charset_row = mysql_fetch_assoc( $db_charset );
			//mysql_query( "SET NAMES '" . $charset_row['Value'] . "'" );
			//unset( $db_charset, $charset_row );
			
			return $this->db_connect_id;
		}
		else
		{
			return false;
		}
	}

	//
	// Other base methods
	//
	function sql_close()
	{
		if($this->db_connect_id)
		{
			if($this->query_result)
			{
				@mysql_free_result($this->query_result);
			}
			$result = @mysql_close($this->db_connect_id);
			return $result;
		}
		else
		{
			return false;
		}
	}

	//
	// Base query method
	//
	function sql_query($sql = "", $transaction = FALSE)
	{
		// Remove any pre-existing queries
		unset($this->query_result);
		if($sql != "")
		{
			$this->num_queries++;

			$this->query_result = @mysql_query($sql, $this->db_connect_id);
		}
		if($this->query_result)
		{
			unset($this->row[$this->query_result]);
			unset($this->rowset[$this->query_result]);
			return $this->query_result;
		}
		else
		{
			return ( $transaction == END_TRANSACTION ) ? true : false;
		}
	}

	//
	// Other query methods
	//
	function sql_numrows($sql_id = 0)
	{
		if(!$sql_id)
		{
			$sql_id = $this->query_result;
		}
		if($sql_id)
		{
			$result = @mysql_num_rows($sql_id);
			return $result;
		}
		else
		{
			return false;
		}
	}
	function sql_affectedrows()
	{
		if($this->db_connect_id)
		{
			$result = @mysql_affected_rows($this->db_connect_id);
			return $result;
		}
		else
		{
			return false;
		}
	}
	function sql_numfields($sql_id = 0)
	{
		if(!$sql_id)
		{
			$sql_id = $this->query_result;
		}
		if($sql_id)
		{
			$result = @mysql_num_fields($sql_id);
			return $result;
		}
		else
		{
			return false;
		}
	}
	function sql_fieldname($offset, $sql_id = 0)
	{
		if(!$sql_id)
		{
			$sql_id = $this->query_result;
		}
		if($sql_id)
		{
			$result = @mysql_field_name($sql_id, $offset);
			return $result;
		}
		else
		{
			return false;
		}
	}
	function sql_fieldtype($offset, $sql_id = 0)
	{
		if(!$sql_id)
		{
			$sql_id = $this->query_result;
		}
		if($sql_id)
		{
			$result = @mysql_field_type($sql_id, $offset);
			return $result;
		}
		else
		{
			return false;
		}
	}
	function sql_fetchrow($sql_id = 0, $desanitize = false)
	{
		if(!$sql_id)
			$sql_id = $this->query_result;

		if($sql_id)
		{
			$this->row[$sql_id] = @mysql_fetch_array($sql_id);
			if ($this->row[$sql_id] != false)
				if ($desanitize)
					return desanitize($this->row[$sql_id]);
				else
					return $this->row[$sql_id];
			else
				return false;
		}
		else
			return false;
	}
	function sql_fetchrowset($sql_id = 0)
	{
		if(!$sql_id)
		{
			$sql_id = $this->query_result;
		}
		if($sql_id)
		{
			unset($this->rowset[$sql_id]);
			unset($this->row[$sql_id]);
			while($this->rowset[$sql_id] = @mysql_fetch_array($sql_id))
			{
				$result[] = $this->rowset[$sql_id];
			}
			return $result;
		}
		else
		{
			return false;
		}
	}
	function sql_fetchfield($field, $rownum = -1, $sql_id = 0)
	{
		if(!$sql_id)
		{
			$sql_id = $this->query_result;
		}
		if($sql_id)
		{
			if($rownum > -1)
			{
				$result = @mysql_result($sql_id, $rownum, $field);
			}
			else
			{
				if(empty($this->row[$sql_id]) && empty($this->rowset[$sql_id]))
				{
					if($this->sql_fetchrow())
					{
						$result = $this->row[$sql_id][$field];
					}
				}
				else
				{
					if($this->rowset[$sql_id])
					{
						$result = $this->rowset[$sql_id][$field];
					}
					else if($this->row[$sql_id])
					{
						$result = $this->row[$sql_id][$field];
					}
				}
			}
			return $result;
		}
		else
		{
			return false;
		}
	}
	function sql_rowseek($rownum, $sql_id = 0){
		if(!$sql_id)
		{
			$sql_id = $this->query_result;
		}
		if($sql_id)
		{
			$result = @mysql_data_seek($sql_id, $rownum);
			return $result;
		}
		else
		{
			return false;
		}
	}
	function sql_nextid(){
		if($this->db_connect_id)
		{
			$result = @mysql_insert_id($this->db_connect_id);
			return $result;
		}
		else
		{
			return false;
		}
	}
	function sql_freeresult($sql_id = 0){
		if(!$sql_id)
		{
			$sql_id = $this->query_result;
		}

		if ( $sql_id )
		{
			unset($this->row[$sql_id]);
			unset($this->rowset[$sql_id]);

			@mysql_free_result($sql_id);

			return true;
		}
		else
		{
			return false;
		}
	}
	function sql_error($sql_id = 0)
	{
		$result["message"] = @mysql_error($this->db_connect_id);
		$result["code"] = @mysql_errno($this->db_connect_id);

		return $result;
	}

} // class sql_db

?>