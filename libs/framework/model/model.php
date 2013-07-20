<?php

/**
 * @author pengmz
 */	
class DataAccessObject extends BaseComponent {
	
	protected $db;
	
	public function __construct() {
		parent::__construct();
	}
	
	public function __autowire() {
		$this->db = ComponentLoader::getDB();
	}

	public function escape($string) {
		return $this->db->escape($string);
	}	
}
	
/**
 * @author pengmz
 */
class Model extends DataAccessObject {
		
	protected $table;
	
	public function __construct($table_name) {
		parent::__construct();
		$this->table = $table_name;
	}
	
	public function findById($id) {
		$id = $this->escape($id);
		return $this->find("id = $id");
	}

	public function updateById($id, $data) {
		$id = $this->escape($id);
		return $this->update($data, "id = $id");
	}
	
	public function deleteById($id) {
		$id = $this->escape($id);
		return $this->delete("id = $id");
	}
		
	public function find($where = '0') {
		return $this->db->find($this->table, $where);
	}
	
	public function save($data) {
		return $this->db->insert($this->table, $data);
	}
	
	public function update($data, $where = '0') {
		return $this->db->update($this->table, $data, $where);
	}
	
	public function delete($where = '0') {
		return $this->db->delete($this->table, $where);
	}
		
	public function findAll($where = '1') {
		return $this->db->findAll($this->table, $where);
	}
		
	public function updateAll($data, $where = '1') {
		return $this->db->updateAll($this->table, $data, $where);
	}
	
	public function deleteAll($where = '1') {
		return $this->db->deleteAll($this->table, $where);
	}

}

class ScaffoldModel extends Model {
		
	public function __construct($table_name) {
		parent::__construct($table_name);
	}
		
	public function getFields() {
		return $this->db->queryForList('DESC ' . $this->table);
	}	
	
}

?>