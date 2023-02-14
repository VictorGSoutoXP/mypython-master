<?php

class MY_Model extends CI_Model {
	
	protected $_tableName;

	/**
	 * 
	 * @param array $data
	 * @return object
	 */
	public function insert(array $data){
		
		$this->db->insert($this->_tableName, $data);
		return $this->db->insert_id();
	}

	/**
	 * Update data on Database
	 * @param array $data
	 * @param mixed $where
	 * @return object
	 */
	public function update(array $data, $where){
		
		if(!is_array($where) && !is_null($where)){
			$where = array("id" => $where);
		}
		
		return $this->db->update($this->_tableName, $data, $where);
	}
	
	/**
	 * Remove Data from database
	 * @param mixed $where
	 * @param int $limit
	 */
	public function delete($where, $limit = NULL){
		
		if(!is_array($where) && !is_null($where)){
			$where = array("id" => $where);
		}
	
		return $this->db->delete($this->_tableName, $where, $limit);
	}
}

?>