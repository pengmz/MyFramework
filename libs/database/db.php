<?php

/**
 * @author pengmz
 */
interface DB {
	
	public function queryForList($sql);
	
	public function queryForArray($sql);
	
	public function queryForObject($sql);
	
	public function queryForVar($sql);
	
	public function executeInsert($sql);
	
	public function executeUpdate($sql);
	
	public function executeDelete($sql);
	
	public function escape($string);

}

global $DB, $DBCFG;

function get_db($db_config = array()) {
	global $DB;	
	if (! $DB) {
		if (empty($db_config)) {
			global $DBCFG;
			$db_config = $DBCFG;
		}
		$DB = new MySQL($db_config);
		if (! $DB) {
			Log::error('Database load error');
		}
	}	
	return $DB;
}

function db_query_for_list($sql) {
	return get_db()->queryForList($sql);
}

function db_query_for_array($sql) {
	return get_db()->queryForArray($sql);
}

function db_query_for_object($sql) {
	return get_db()->queryForObject($sql);
}

function db_query_for_var($sql) {
	return get_db()->queryForVar($sql);
}

function db_execute_insert($sql) {
	return get_db()->executeInsert($sql);
}

function db_execute_update($sql) {
	return get_db()->executeUpdate($sql);
}

function db_execute_delete($sql) {
	return get_db()->executeDelete($sql);
}

/**
 * @author pengmz
 */
class DBException extends Exception {
	
    public function __construct($message) {
        parent::__construct($message, 500);
    }
    
    public function __toString() {
		return "[DBException][$this->code] $this->message 
				in file $this->file on line $this->line";
    }
}

include_once dirname(__FILE__) . '/mysql.php';

?>