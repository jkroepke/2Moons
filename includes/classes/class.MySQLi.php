<?php

##############################################################################
# *                                                                          #
# * 2MOONS                                                                   #
# *                                                                          #
# * @copyright Copyright (C) 2010 By ShadoX from titanspace.de               #
# *                                                                          #
# *	                                                                         #
# *  This program is free software: you can redistribute it and/or modify    #
# *  it under the terms of the GNU General Public License as published by    #
# *  the Free Software Foundation, either version 3 of the License, or       #
# *  (at your option) any later version.                                     #
# *	                                                                         #
# *  This program is distributed in the hope that it will be useful,         #
# *  but WITHOUT ANY WARRANTY; without even the implied warranty of          #
# *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the           #
# *  GNU General Public License for more details.                            #
# *                                                                          #
##############################################################################

if(!defined('INSIDE')) die('Hacking attempt!');


class DB_mysqli extends mysqli
{
	public $mysqli;
	protected $queryCount = 0;
	protected $qTime = array();
	protected $query;
	protected $result;

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
	public function __construct()
	{
		global $database;
		$this->time		= 0;
		
		@parent::__construct($database["host"], $database["user"], $database["userpw"], $database["databasename"], $database["port"]);

		if($this->connect_errno)
		{
			throw new Exception("Connection to database failed: ".$this->connect_error);
			exit;
		}		
		parent::set_charset("utf8");
		return true;
	}
	
	/**
	 * Close current database connection.
	 *
	 * @return void
	 */
	public function __destruct()
	{	
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
		$Timer	= microtime(true);
		if($result = parent::query($resource))
		{
			$this->queryCount++;
			return $result;
		}
		else
		{
			throw new Exception("SQL Error: ".$this->error."<br /><br />Query Code: ".$resource);
		}
		$this->time	+= (microtime(true) - $Timer);
		return;
		
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
		$Timer	= microtime(true);
		if($result = parent::query($resource))
		{
			$this->queryCount++;
			$Return = $result->fetch_array(MYSQLI_ASSOC);
			$result->close();
			return $Return;
			$this->time	+= (microtime(true) - $Timer);
		}
		else
		{
			throw new Exception("SQL Error: ".$this->error."<br /><br />Query Code: ".$resource);
		}
		return;
		
	}	
	/**
	 * Returns the row of a query as an object.
	 *
	 * @param resource	The SQL query id
	 *
	 * @return object	The data of a row
	 */
	public function fetch_object($result)
	{
		return $result->fetch_object();
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
		return is_object($result) ? $result->fetch_array(MYSQLI_ASSOC) : array();
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
		return is_object($result) ? $result->fetch_array(MYSQLI_NUM) : array();
	}

	/**
	 * Fetch a result row as an associative array.
	 *
	 * @param resource	The SQL query id
	 *
	 * @return array	The data of a row
	 */
	public function fetch($result)
	{
		return is_object($result) ? $result->fetch_assoc() : array();
	}
	
	/**
	 * Returns the value from a result resource.
	 *
	 * @param resource	The SQL query id
	 * @param string	The column name to fetch
	 * @param integer	Row number in result to fetch
	 *
	 * @return mixed
	 */
	public function fetch_field($result, $field, $row = null)
	{
		if($row !== null)
		{
			$result->data_seek($row);
		}
		$this->result = $this->fetch($result);
		return $this->result[$field];
	}

	/**
	 * Get a row as an enumerated array.
	 *
	 * @param resource	The SQL query id
	 *
	 * @return array
	 */
	public function fetch_row($result)
	{
		$this->result = $result->fetch_row();
		return $this->result;
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
		if($query)
		{
			return $query->num_rows;
		}
		return 0;
	}

	/**
	 * Returns the number of affected rows by the last query.
	 *
	 * @return integer	Affected rows
	 */
	public function affected_rows()
	{
		$affected_rows = $this->mysqli->affected_rows;
		if($affected_rows < 0) { $affected_rows = 0; }
		return $affected_rows;
	}

	/**
	 * Returns the last inserted id of a table.
	 *
	 * @return integer	The last inserted id
	 */
	public function insert_id()
	{
		return $this->mysqli->insert_id;
	}

	/**
	 * Escapes a string for a safe SQL query.
	 *
	 * @param string The string that is to be escaped.
	 *
	 * @return string Returns the escaped string, or false on error.
	 */
	public function sql_escape($string)
	{
		return parent::escape_string($string);
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
	 * Type of database.
	 *
	 * @return string
	 */
	public function getDatabaseType()
	{
		return "mysqli";
	}

	/**
	 * Resets a mysqli resource to row number 0.
	 *
	 * @param resource	Resource to reset
	 *
	 * @return void
	 */
	public function reset_resource($result)
	{
		return $result->data_seek(0);
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
		
		$this->time	+= (microtime(true) - $Timer);
	
		if ($this->errno)
		{
			throw new Exception("SQL Error: ".$this->error."<br /><br />Query Code: ".$resource);
		}
	}
	
	public function get_sql()
	{
		return $this->queryCount;
	}
}

?>