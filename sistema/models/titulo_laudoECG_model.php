<?php

class Titulo_laudoECG_model extends MY_Model {
	
	function __construct() {
		parent::__construct ();
		$this->_tableName = "titulo_ecg";
	}
	
	/**
	 *
	 * @param $where mixed       	
	 */
	function get_all($where = NULL) {
		
		if (! is_array ( $where )) {
			$where = array ();
		}
		
		$query = $this->db->get_where ( $this->_tableName, $where );
		
		return $query->result_array ();
	
	}
	
}

?>