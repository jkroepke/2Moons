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

if(!defined('INSIDE')){ die(header("location:../../"));}


class DB_mysqli
{
	public $mysqli;
	protected $host;
	protected $port;
	protected $user;
	protected $pw;
	protected $database;
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
	public function __construct($host, $user, $pw, $db, $port = null)
	{
		ignore_user_abort(true);

		$this->host 	= $host;
		$this->user 	= $user;
		$this->pw 		= $pw;
		$this->database = $db;
		$this->port 	= $port;
		$this->time		= 0;
	}
	
	/**
	 * Close current database connection.
	 *
	 * @return void
	 */
	public function __destruct()
	{	
		$this->mysqli->close;
	}

	/**
	 * Establish database connection and select database to use.
	 *
	 * @return void
	 */
	private function connect()
	{
		$this->mysqli = new mysqli($this->host, $this->user, $this->pw, $this->database, $this->port);

		if(mysqli_connect_errno())
		{
			trigger_error("Connection to database failed: ".mysqli_connect_error(),E_USER_ERROR);
			return false;
		}		
		$this->mysqli->set_charset("utf8");
		return true;
	}

	/**
	 * Purpose a query on selected database.
	 *
	 * @param string	The SQL query
	 *
	 * @return resource	Results of the query
	 */
	public function query($sql)
	{
		if(!is_object($this->mysqli))
			$this->connect();
		
		if($GLOBALS['game_config']['debug'] == 1)
		{
			$temp = debug_backtrace();
			file_put_contents(ROOT_PATH."adm/logs/querylog_".date("d.m.y").".log", date("H:i:s")." ".$temp[0]['file']." on ".$temp[0]['line']." ".$sql."\n", FILE_APPEND);
		}
		$Timer	= microtime(true);
		if($result = $this->mysqli->query($sql))
		{
			$this->queryCount++;
			return $result;
		}
		else
		{
            $temp = debug_backtrace();
			echo str_replace($_SERVER["DOCUMENT_ROOT"],'.',$temp[0]['file']) . " on " . $temp[0]['line'] . ":<br>";
			echo ("<center><table style=\"z-index:1001;width:80%\"><tr><th align=\"center\">SQL Error (".$this->mysqli->error."): ".$this->error."<br /><br />Query Code: ".$sql."</th></tr></table></center>");
		}
		$this->time	+= (microtime(true) - $Timer);
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
	 * Returns the last inserted id of a table.
	 *
	 * @return integer	The last inserted id
	 */
	public function error()
	{
		return $this->mysqli->error;
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
		return $this->mysqli->real_escape_string($string);
	}

	/**
	 * Returns used mysqli-Verions.
	 *
	 * @return string	mysqli-Version
	 */
	public function getVersion()
	{
		return $this->mysqli->get_client_info();
	}
	
	/**
	 * Returns used mysqli-Verions.
	 *
	 * @return string	mysqli-Version
	 */
	public function getServerVersion()
	{
		return mysqli_get_server_info($this->mysqli);
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
		return $resource->free_result();
	}
	
	public function multi_query($resource, $clear_result_cache = true)
	{	
		if(!is_object($this->mysqli))
			$this->connect();
		
		if($GLOBALS['game_config']['debug'] == 1)
		{
			$temp = debug_backtrace();
			file_put_contents(ROOT_PATH."adm/logs/querylog_".date("d.m.y").".log", date("H:i:s")." ".$temp[0]['file']." on ".$temp[0]['line']." ".str_replace("\n","",$resource)."\n", FILE_APPEND);
		}
		
		$Timer	= microtime(true);
		if($this->mysqli->multi_query($resource))
		{
			if ($clear_result_cache) {
				do {
					if($result = $this->mysqli->store_result())
					{
						$this->free_result($result);
						$this->queryCount++;
					}
					if(!$this->mysqli->more_results()){break;}
					
				} while ($this->mysqli->next_result());
			
			}
		}
		else
		{
            $temp = debug_backtrace();
			echo str_replace($_SERVER["DOCUMENT_ROOT"],'.',$temp[0]['file']) . " on " . $temp[0]['line'] . ":<br>";
			echo ("<center><table style=\"z-index:1001;width:80%\"><tr><th align=\"center\">SQL Error (".$this->mysqli->error."): ".$this->error."<br /><br />Query Code: ".$resource."</th></tr></table></center>");
		}
		$this->time	+= (microtime(true) - $Timer);
	}
	
	public function get_sql()
	{
		return $this->queryCount;
	}
}

?>