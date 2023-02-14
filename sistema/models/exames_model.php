<?php

class Exames_model extends MY_Model {
	
	function __construct() {
		parent::__construct();
		$this->_tableName = "exames";
	}
	
	/**
	 *
	 * @param $where mixed       	
	 */
	function get_all($where = NULL) {
		
		if(UserSession::isCliente()){
			$this->db->where("cliente_id", UserSession::user("id"));
		}
		$query = $this->db->get_where ( $this->_tableName, $where );
		
		$rows = $query->result_array ();
	
		if (UserSession::isAdmin()){
			$new_rows = array();
			foreach ($rows as $row) {
				$row['nome'] .= " - {$row['cliente_id']}";
				$new_rows[] = $row;
			}
			
			return $new_rows;
		}
		return $rows;
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
		if(UserSession::isCliente()){
			$this->db->where("cliente_id", UserSession::user("id"));
		}
		$query = $this->db->get_where ( $this->_tableName, $where, 1 );
		
		return $query->row_array ();
	
	}
	
	function delete($where) {
		
		if (! is_array ( $where ) && ! is_null ( $where )) {
			$where = array ("id" => $where );
		}
		if(UserSession::isCliente()){
			$this->db->where("cliente_id", UserSession::user("id"));
		}
		
		$data = array ("status" => 0 );
		
		return $this->update ( $data, $where );
	}
}

?>