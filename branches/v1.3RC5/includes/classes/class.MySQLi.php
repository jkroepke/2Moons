<?php

/**
 *  2Moons
 *  Copyright (C) 2011  Slaver
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @package 2Moons
 * @author Slaver <slaver7@gmail.com>
 * @copyright 2009 Lucky <douglas@crockford.com> (XGProyecto)
 * @copyright 2011 Slaver <slaver7@gmail.com> (Fork/2Moons)
 * @license http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
 * @version 1.3 (2011-01-21)
 * @link http://code.google.com/p/2moons/
 */
 
class DB_mysqli extends mysqli
{
	protected $con;

	/**
	 * Constructor: Set database access data.
	 *
	 * @param string	The database host
	 * @param string	The database username
	 * @param string	The database password
	 * @param string	The database name
	 * @param integer	The database port
	 *
	 * @return void
	 */
	public function __construct($exception = true)
	{
		$this->con = $GLOBALS['database'];

        if (!isset($this->con['port'])) {
            $this->con['port'] = 3306;
        }

		@parent::__construct($this->con['host'], $this->con['user'], $this->con['userpw'], $this->con['databasename'], $this->con['port']);

		if(mysqli_connect_error())
		{
			if($exception == true)
				throw new Exception("Connection to database failed: ".mysqli_connect_error());
			elseif(defined('INSTALL'))
				return false;
		}		
		parent::set_charset("utf8");
		parent::query("SET SESSION sql_mode = '';");
	}
	
	/**
	 * Close current database connection.
	 *
	 * @return void
	 */
	public function __destruct()
	{	
		if(!mysqli_connect_error())
			parent::close();
	}

	/**
	 * Purpose a query on selected database.
	 *
	 * @param string	The SQL query
	 *
	 * @return resource	Results of the query
	 */
	public function query($resource)
	{
		if($result = parent::query($resource))
		{
			$this->queryCount++;
			return $result;
		}
		else
		{
			if($exception == true) {
				throw new Exception("SQL Error: ".$this->error."<br><br>Query Code: ".$resource);
			} else {
				return "SQL Error: ".$this->error;
			}
		}
        return false;
	}
	/**
	 * Purpose a query on selected database.
	 *
	 * @param string	The SQL query
	 *
	 * @return resource	Results of the query
	 */

	public function uniquequery($resource)
	{		
		$result = $this->query($resource);
		$Return = $result->fetch_array(MYSQLI_ASSOC);
		$result->close();
		return $Return;
		
	}
	/**
	 * Purpose a query on selected database.
	 *
	 * @param string	The SQL query
	 *
	 * @return resource	Results of the query
	 */

	public function countquery($resource)
	{		
		$result = $this->query($resource);
		list($Return) = $result->fetch_array(MYSQLI_NUM);
		$result->close();
		return $Return;
	}	
	/**
	 * Purpose a query on selected database.
	 *
	 * @param string	The SQL query
	 *
	 * @return resource	Results of the query
	 */

	public function fetchquery($resource, $encode = array())
	{		
		$result = $this->query($resource);
		$Return	= array();
		$Col	= 0;
		while($Data	= $result->fetch_array(MYSQLI_ASSOC)) {
			foreach($Data as $Key => $Store) {
				if(in_array($Key, $encode))
					$Data[$Key]	= base64_encode($Store);
			}
			$Return[]	= $Data;
		}
		$result->close();
		return $Return;
	}

	/**
	 * Returns the row of a query as an array.
	 *
	 * @param resource	The SQL query id
	 *
	 * @return array	The data of a row
	 */
	public function fetch_array($result)
	{
		return $result->fetch_array(MYSQLI_ASSOC);
	}

	/**
	 * Returns the row of a query as an array.
	 *
	 * @param resource	The SQL query id
	 *
	 * @return array	The data of a row
	 */
	public function fetch_num($result)
	{
		return $result->fetch_array(MYSQLI_NUM);
	}

	/**
	 * Returns the total row numbers of a query.
	 *
	 * @param resource	The SQL query id
	 *
	 * @return integer	The total row number
	 */
	public function num_rows($query)
	{
		return $query->num_rows;
	}

	/**
	 * Returns the total row numbers of a query.
	 *
	 * @param resource	The SQL query id
	 *
	 * @return integer	The total row number
	 */
	public function GetInsertID()
	{
		return $this->insert_id;
	}

	/**
	 * Escapes a string for a safe SQL query.
	 *
	 * @param string The string that is to be escaped.
	 *
	 * @return string Returns the escaped string, or false on error.
	 */
	
    public function sql_escape($string, $flag = false)
    {
		return ($flag === false) ? parent::escape_string($string): addcslashes(parent::escape_string($string), '%_');
    }
	
	public function str_correction($str)
	{
		return stripcslashes($str);
	}

	/**
	 * Returns used mysqli-Verions.
	 *
	 * @return string	mysqli-Version
	 */
	public function getVersion()
	{
		return parent::get_client_info();
	}
	
	/**
	 * Returns used mysqli-Verions.
	 *
	 * @return string	mysqli-Version
	 */
	public function getServerVersion()
	{
		return $this->server_info;
	}

	/**
	 * Frees stored result memory for the given statement handle.
	 *
	 * @param resource	The statement to free
	 *
	 * @return void
	 */
	public function free_result($resource)
	{
		return $resource->close();
	}
	
	public function multi_query($resource)
	{	
		$Timer	= microtime(true);
		if(parent::multi_query($resource))
		{
			do {
			    if ($result = parent::store_result())
					$result->free();
				
				$this->queryCount++;
					
				if(!parent::more_results()){break;}
					
			} while (parent::next_result());		
		}
		
		$this->SQL[]	= $resource;
	
		if ($this->errno)
		{
			if($exception == true) {
				throw new Exception("SQL Error: ".$this->error."<br><br>Query Code: ".$resource);
			} else {
				return "SQL Error: ".$this->error;
			}
		}
	}
	
	public function get_sql()
	{
		return $this->queryCount;
	}
}

?>