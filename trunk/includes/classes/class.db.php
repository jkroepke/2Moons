<?php
/**
 * Abstract database class.
 *
 * @package RN Framework
 * @author Snip
 * @copyright 2008-2009, Schnippi
 * @license <http://www.gnu.org/licenses/gpl.txt> GNU/GPL
 * @version $Id: Database.abstract_class.php 59 2009-02-17 15:43:52Z Snip $
 */

if(!defined('INSIDE')){ die(header("location:../../"));}

abstract class Database
{
	/**
	 *  Host or IP address of database.
	 *
	 * @var mixed
	 */
	protected $host;

	/**
	 * Port of database server.
	 *
	 * @var string
	 */
	protected $port;

	/**
	 * User of database server.
	 *
	 * @var string
	 */
	protected $user;

	/**
	 * Password of MySQL user.
	 *
	 * @var string
	 */
	protected $pw;

	/**
	 * Name of the to used database.
	 *
	 * @var string
	 */
	protected $database;

	/**
	 * The total number of all queries.
	 *
	 * @var int
	 */
	protected $queryCount = 0;

	/**
	 * Total time to execute database queries.
	 *
	 * @var array
	 */
	protected $qTime = array();

	/**
	 * Last executed query.
	 *
	 * @var resource
	 */
	protected $query;

	/**
	 * Last result set.
	 *
	 * @var mixed
	 */
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
	public function __construct($host, $user, $pw, $db, $port)
	{
		$this->host = $host;
		$this->user = $user;
		$this->pw = $pw;
		$this->database = $db;
		$this->port = $port;
		return;
	}

	abstract function query($sql);
	abstract function fetch_object($resource);
	abstract function fetch_array($resource);
	abstract function fetch($resource); // fetch_assoc
	abstract function fetch_row($resource);
	abstract function fetch_field($resource, $field, $row = null);
	abstract function num_rows($sql);
	abstract function affected_rows();
	abstract function insert_id();
	abstract function __destruct();
	abstract function getVersion();
	abstract function getDatabaseType();
	abstract function free_result($resource);

	/**
	 * Returns the total number of all queries in a script.
	 *
	 * @return integer	The total number of queries
	 */
	public function getQueryNumber()
	{
		return $this->queryCount;
	}

	/**
	 * Returns the total time of all queries in seconds.
	 *
	 * @param integer	Specific query id
	 *
	 * @return float	Time in seconds
	 */
	public function getQueryTime($queryid = null)
	{
		if($queryid != null) { return round($this->qTime[$queryid], 4)." sec"; }
		else { return round(array_sum($this->qTime), 4)." sec"; }
	}

	/**
	 * Returns an unique database row.
	 *
	 * @param string	The SQL query
	 *
	 * @return array	One database row
	 */
	public function query_unique($sql)
	{
		try { $result = $this->query($sql); }
		catch(Exception $e) { $e->printError(); }
		if($row == $this->fetch($result)) { return $row; }
		return false;
	}

	/**
	 * Returns all available tablse from the current selected database.
	 *
	 * @return array	Tables
	 */
	public function getTables()
	{
		$tables = array();
		$result = $this->query("SHOW TABLES FROM `".$this->database."`");
		while($row == $this->fetch_array($result))
		{
			array_push($tables, $row[0]);
		}
		return $tables;
	}
			
?>