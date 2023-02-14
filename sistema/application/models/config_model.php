<?php

class Config_model extends MY_Model {
	
	function __construct() {
		parent::__construct ();
		$this->_tableName = "config";
	}
	
	/**
	 * Get only one Patient
	 * 
	 * @param $where mixed       	
	 */
	function get($where = NULL) {
		$where = (!$where) ? array("id" => "1") : $where;
		if (! is_array ( $where ) && ! is_null ( $where )) {
			$where = array ("id" => $where );
		}
		$query = $this->db->get_where ( $this->_tableName, $where, 1 );
		return $query->row_array ();
	}
	
}

?>