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
	public function __construct($test = false)
	{
		$this->con = $GLOBALS['database'];

        if (!isset($this->con['port'])) {
            $this->con['port'] = 3306;
        }

		@parent::__construct($this->con['host'], $this->con['user'], $this->con['userpw'], $this->con['databasename'], $this->con['port']);

		if($this->connect_errno)
		{
			if($test != true) {
				throw new Exception("Connection to database failed: ".$this->connect_error);
				exit;
			} else {
				return false;
			}
		}		
		parent::set_charset("utf8");
	}
	
	/**
	 * Close current database connection.
	 *
	 * @return void
	 */
	public function __destruct()
	{	
		if(!$this->connect_errno)
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
			throw new Exception("SQL Error: ".$this->error."<br><br>Query Code: ".$resource);
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
		if(false === ($result = parent::query($resource)))
		{
			throw new Exception("SQL Error: ".$this->error."<br><br>Query Code: ".$resource);
		}	
		
		$this->queryCount++;
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
		if(false === ($result = parent::query($resource)))
		{
			throw new Exception("SQL Error: ".$this->error."<br><br>Query Code: ".$resource);
		}	
		
		$this->queryCount++;
		list($Return) = $result->fetch_array(MYSQLI_NUM);
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
	 * Type of database.
	 *
	 * @return string
	 */
	public function getDatabaseType()
	{
		return "mysqli";
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
		$this->SQL[]	= $resource;
	
		if ($this->errno)
		{
			throw new Exception("SQL Error: ".$this->error."<br><br>Query Code: ".$resource);
		}
	}
	
	public function get_sql()
	{
		return $this->queryCount;
	}
}

?>