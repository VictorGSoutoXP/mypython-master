<?php

class Modelo_laudoECG_model extends MY_Model {
	
	function __construct() {
		parent::__construct ();
		$this->_tableName = "modelo_laudo_ecg";
	}
	
	/**
	 *
	 * @param $where mixed       	
	 */
	function get_all($where = NULL) {
		
		if (! is_array ( $where )) {
			$where = array ();
		}
		
		$this->db->order_by("tipo", "asc");
		
		$query = $this->db->get_where ( $this->_tableName, $where );
		
		return $query->result_array ();
	
	}
	
}

?>