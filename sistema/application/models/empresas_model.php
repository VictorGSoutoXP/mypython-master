<?php

class Empresas_model extends MY_Model {
	
	function __construct() {
		parent::__construct ();
		$this->_tableName = "empresas";
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
	
	function cpf_exists($cpf, $id = NULL) {
		$cpf = preg_replace ( "/\D/", "", $cpf );
		
		if ($id) {
			$this->db->where ( "id <>", $id );
		}
		$this->db->where ( "status", 1 );
		$query = $this->db->limit ( 1 )->get_where ( "pacientes", array ("cpf" => $cpf ) );
		return $query->num_rows () === 0;
	}
	
	function email_exists($email, $id = NULL) {
		
		if ($id) {
			$this->db->where ( "id <>", $id );
		}
		$this->db->where ( "status", 1 );
		$query = $this->db->limit ( 1 )->get_where ( "pacientes", array ("email" => $email ) );
		return $query->num_rows () === 0;
	}
}

?>