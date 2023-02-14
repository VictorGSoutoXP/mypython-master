<?php

class Motivos_exames_model extends MY_Model {
	
	function __construct() {
		parent::__construct();
		$this->_tableName = "motivos_exames";
	}
	
	/**
	 *
	 * @param $where mixed       	
	 */
	function get_all($where = NULL) {
		
		if (! is_array ( $where )) {
			$where = array ();
		}
		
		$where ['status'] = 1;
		
		$query = $this->db->get_where ( $this->_tableName, $where );
		
		return $query->result_array ();
	
	}
	
	/**
	 * Get only one Patient
	 * 
	 * @param $where mixed       	
	 */
	function get($where = NULL) {
		if (! is_array ( $where ) && ! is_null ( $where )) {
			$where = array ("id" => $where );
		}
		
		$where ['status'] = 1;
		
		$query = $this->db->get_where ( $this->_tableName, $where, 1 );
		
		return $query->row_array ();
	
	}
	
	function delete($where) {
		
		if (! is_array ( $where ) && ! is_null ( $where )) {
			$where = array ("id" => $where );
		}
		
		$data = array ("status" => 0 );
		
		return $this->update ( $data, $where );
	}
}

?>