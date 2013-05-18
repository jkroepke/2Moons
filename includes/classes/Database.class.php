<?php

class Database
{
	protected $dbHandle = NULL;
	protected $dbTableNames = array();
	protected $lastInsertId = false;
	protected $rowCount = false;
	protected $queryCounter = 0;
	protected static $instance = NULL;


	public static function get()
	{
		if (!isset(self::$instance))
			self::$instance = new self();

		return self::$instance;
	}

	public function getDbTableNames()
	{
		return $this->dbTableNames;
	}

	private function __clone()
	{

	}

	protected function __construct()
	{
		$database = array();
		require 'includes/config.php';
		//Connect
		$db = new PDO("mysql:host=".$database['host'].";port=".$database['port'].";dbname=".$database['databasename'], $database['user'], $database['userpw']);
		//error behaviour
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$db->query("set character set utf8");
		$db->query("set names utf8");
		$this->dbHandle = $db;

		$dbTableNames = array();

		include 'includes/dbtables.php';

		foreach($dbTableNames as $key => $name)
		{
			$this->dbTableNames['keys'][]	= '%%'.$key.'%%';
			$this->dbTableNames['names'][]	= $name;
		}
	}

	public function disconnect()
	{
		$this->dbHandle = NULL;
	}

	public function getHandle()
	{
		return $this->dbHandle;
	}

	public function lastInsertId()
	{
		return $this->lastInsertId;
	}

	public function rowCount()
	{
		return $this->rowCount;
	}
	
	protected function _query($qry, array $params, $type)
	{
		if (in_array($type, array("insert", "select", "update", "delete", "replace")) === false)
		{
			throw new Exception("Unsupported Query Type");
		}

		$this->lastInsertId = false;
		$this->rowCount = false;
		
		$qry	= str_replace($this->dbTableNames['keys'], $this->dbTableNames['names'], $qry);

		/** @var $stmt PDOStatement */
		$stmt	= $this->dbHandle->prepare($qry);

		if (isset($params[':limit']) || isset($params[':offset']))
		{
			foreach($params as $param => $value)
			{
				if($param == ':limit' || $param == ':offset')
				{
					$stmt->bindValue($param, (int) $value, PDO::PARAM_INT);
				}
				else
				{
					$stmt->bindValue($param, (int) $value, PDO::PARAM_STR);
				}
			}
		}

		try {
			$success = (count($params) !== 0 && !isset($params[':limit']) && !isset($params[':offset'])) ? $stmt->execute($params) : $stmt->execute();
		}
		catch (PDOException $e) {
			throw new Exception($e->getMessage()."<br>\r\n<br>\r\nQuery-Code:".str_replace(array_keys($params), array_values($params), $qry));
		}

		$this->queryCounter++;

		if (!$success)
			return false;

		if ($type === "insert")
			$this->lastInsertId = $this->dbHandle->lastInsertId();
		$this->rowCount = $stmt->rowCount();

		return ($type === "select") ? $stmt : true;
	}

	protected function getQueryType($qry)
	{
		list($type, ) = explode(" ", trim(strtolower($qry)), 2);
		return $type;
	}

	public function delete($qry, array $params = array())
	{
		if (($type = $this->getQueryType($qry)) !== "delete")
			throw new Exception("Incorrect Delete Query");

		return $this->_query($qry, $params, $type);
	}

	public function replace($qry, array $params = array())
	{
		if (($type = $this->getQueryType($qry)) !== "replace")
			throw new Exception("Incorrect Replace Query");

		return $this->_query($qry, $params, $type);
	}

	public function update($qry, array $params = array())
	{
		if (($type = $this->getQueryType($qry)) !== "update")
			throw new Exception("Incorrect Update Query");

		return $this->_query($qry, $params, $type);
	}

	public function insert($qry, array $params = array())
	{
		if (($type = $this->getQueryType($qry)) !== "insert")
			throw new Exception("Incorrect Insert Query");

		return $this->_query($qry, $params, $type);
	}

	public function select($qry, array $params = array())
	{
		if (($type = $this->getQueryType($qry)) !== "select")
			throw new Exception("Incorrect Select Query");

		$stmt = $this->_query($qry, $params, $type);
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public function selectSingle($qry, array $params = array(), $field = false)
	{
		if (($type = $this->getQueryType($qry)) !== "select")
			throw new Exception("Incorrect Select Query");

		$stmt = $this->_query($qry, $params, $type);
		$res = $stmt->fetch(PDO::FETCH_ASSOC);
		return ($field === false || is_null($res)) ? $res : $res[$field];
	}

	public function query($qry)
	{
		$this->lastInsertId = false;
		$this->rowCount = false;
		$this->rowCount = $this->dbHandle->exec($qry);
		$this->queryCounter++;
	}

	public function nativeQuery($qry)
	{
		$this->lastInsertId = false;
		$this->rowCount = false;

		$qry	= str_replace($this->dbTableNames['keys'], $this->dbTableNames['names'], $qry);

		/** @var $stmt PDOStatement */
		$stmt	= $this->dbHandle->query($qry);

		$this->rowCount = $stmt->rowCount();

		$this->queryCounter++;
		return in_array($this->getQueryType($qry), array('select', 'show')) ? $stmt->fetchAll(PDO::FETCH_ASSOC) : true;
	}

	public function getQueryCounter()
	{
		return $this->queryCounter;
	}

	static public function formatDate($time)
	{
		return date('Y-m-d H:i:s', $time);
	}

	public function quote($str)
	{
		return $this->dbHandle->quote($str);
	}
}