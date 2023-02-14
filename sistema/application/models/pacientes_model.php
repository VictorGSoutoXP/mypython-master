<?php

class Pacientes_model extends MY_Model {
	
	function __construct() {
		parent::__construct ();
		$this->_tableName = "pacientes";
	}
	
	function get_pacientes(){
		$where = array();
		$this->db->where("p.cliente_id", UserSession::user("id"));
		$this->db->where("p.status", 1);
		$this->db->join("empresas AS e", "e.id = p.empresa_id");
        $this->db->select(
			"p.nome as nome, p.funcao as funcao, e.nome as empresa, 
			p.rg as rg, p.cpf as cpf, p.nascimento as nascimento, p.sexo as sexo"
		);
		$query = $this->db->get ( $this->_tableName . " AS p" );
		return $query->result_array();
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