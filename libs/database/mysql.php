<?php

define('OBJECT', 'OBJECT');
define('ARRAY_A', 'ARRAY_A');
define('ARRAY_N', 'ARRAY_N');

/**
 * @author pengmz
 */
class MySQL {
	
	private static $db_instance;
	
	protected $dbhost = 'localhost';
	protected $dbname = 'mysql';
	protected $dbuser = 'root';
	protected $dbpassword = '';
	protected $dbcharset = 'utf8';
	protected $debug_mode = DEBUG_MODE;
		
	public function MySQL($db_config) {
		if ($db_config) {
			$this->dbhost = $db_config['host'];
			$this->dbname = $db_config['name'];
			$this->dbuser = $db_config['user'];
			$this->dbpassword = $db_config['password'];
			if ($db_config['debug'] == 'true') {
				$this->debug_mode = true;
			}
		}
		if (defined('DB_CHARSET')) {
			$this->dbcharset = DB_CHARSET;
		}
	}
	
	public function find($table, $where = '0') {
		$sql = 'SELECT * FROM ' . $table . ' WHERE ' . $where;
		return $this->queryForObject($sql);
	}
	
	public function findAll($table, $where = '1') {
		$sql = 'SELECT * FROM ' . $table . ' WHERE ' . $where;
		return $this->queryForList($sql);
	}
	
	public function insert($table, $data) {
		$keys = array();
		$values = array();
		foreach($data as $key => $val) {
			if ($key === NULL || $val === NULL) {
				continue;
			}
			$keys[] = $key;
			$values[] = $this->escape($val);
		}
		$sql = 'INSERT INTO ' . $table . ' (' . implode(', ', $keys) . ') VALUES (' . implode(', ', $values) . ')';
		return $this->executeInsert($sql);
	}
	
	public function update($table, $data, $where = '0') {
		foreach($data as $key => $val) {
			if ($key === NULL || $val === NULL) {
				continue;
			}
			$values[] = $key . ' = ' . $this->escape($val);
		}
		$sql = 'UPDATE ' . $table . ' SET ' . implode(', ', $values) . ' WHERE ' . $where;
		return $this->executeUpdate($sql);
	}
	
	public function updateAll($table, $data, $where = '1') {
		return $this->update($table, $data, $where);
	}
	
	public function delete($table, $where = '0') {
		$sql = 'DELETE FROM ' . $table . ' WHERE ' . $where;
		return $this->executeDelete($sql);
	}
	
	public function deleteAll($table, $where = '1') {
		return $this->delete($table, $where);
	}
	
	public function escape($val) {
		if ($val === NULL) {
			return NULL;
		}		
	    if (is_numeric($val)) {
            return $val;
        }
        	
		$conn = $this->getConnection();
		if (get_magic_quotes_gpc()) {
			$val = stripslashes($val);
		}
		$val = mysql_real_escape_string($val, $conn);
		
		return '\'' . $val . '\'';
	}
	
	public function queryForList($sql) {
		return $this->executeSelect($sql);
	}
	
	public function queryForArray($sql) {
		return $this->executeSelect($sql, ARRAY_A);
	}
	
	public function queryForObject($sql) {
		$list = $this->queryForList($sql);
		if ($list) {
			return $list[0];
		}
		return null;
	}
	
	public function queryForVar($sql) {
		$array = $this->queryForArray($sql);
		if ($array) {
			$array = array_values($array[0]);
			return $array[0];
		}
		return null;
	}
	
	public function executeInsert($sql) {
		$conn = $this->getConnection();
		$result = mysql_query($sql, $conn);
		if ($result) {
			Log::debug('[SQL]: ' . $sql);
			return mysql_insert_id($conn);
		} else {
			Log::error('[INSERT][SQL]: ' . $sql, mysql_error($conn));
		}
		return false;
	}
	
	public function executeUpdate($sql) {
		$conn = $this->getConnection();
		$result = mysql_query($sql, $conn);
		if ($result) {
			Log::debug('[SQL]: ' . $sql);
			return mysql_affected_rows($conn);
		} else {
			Log::error('[UPDATGE][SQL]: ' . $sql, mysql_error($conn));
		}
		return false;
	}
	
	public function executeDelete($sql) {
		Log::debug('[SQL]: ' . $sql);
		return $this->executeUpdate($sql);
	}
	
	public function executeSelect($sql, $mapping_to = OBJECT) {
		$conn = $this->getConnection();
		$result = mysql_query($sql, $conn);
		
		if ($result) {
			Log::debug('[SQL]: ' . $sql);
			if ($mapping_to == OBJECT) {
				$object_result = $this->resultMapperToObject($result);
				mysql_free_result($result);
				return $object_result;
			} else {
				$array_result = $this->resultMapperToArray($result);
				mysql_free_result($result);
				return $array_result;
			}
		} else {
			Log::error('[SELECT][SQL]: ' . $sql, mysql_error($conn));
		}
		return false;
	}
	
	private function resultMapperToObject($result) {
		$result_list = array();
		while(($obj = mysql_fetch_object($result)) != false) {
			$result_list[] = $obj;
		}
		return $result_list;
	}
	
	private function resultMapperToArray($result) {
		$result_list = array();
		while(($obj = mysql_fetch_object($result)) != false) {
			$result_list[] = get_object_vars($obj);
		}
		return $result_list;
	}
	
	public function getConnection() {
		if (is_null(self::$db_instance)) {
			self::$db_instance = $this->connectToMySQL();
		}
		return self::$db_instance;
	}
	
	public function closeConnection() {
		if (is_resource(self::$db_instance)) {
			mysql_close(self::$db_instance);
		}
		self::$db_instance = NULL;
	}
	
	private function connectToMySQL() {
		$conn = @mysql_connect($this->dbhost, $this->dbuser, $this->dbpassword, true);
		if ($conn == null) {
			Log::error('[DB CONNECT]: Failed to connect to database');
		}
		if (! @mysql_select_db($this->dbname)) {
			Log::error('[DB SELECT]: Unknown database name');
		}
		
		$conn = $this->initCharset($conn);
		return $conn;
	}
	
	private function initCharset($conn) {
		mysql_query('SET NAMES ' . $this->dbcharset, $conn);
		return $conn;
	}
	
	private function initTimeout($conn) {
		mysql_query('SET interactive_timeout=24*3600', $conn);
		return $conn;
	}
	
	public function __destruct() {
		$this->closeConnection();
	}

}
?>