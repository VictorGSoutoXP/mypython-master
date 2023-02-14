<?php

class Clientes_exames_model extends MY_Model {
	
	function __construct() {
		parent::__construct();
		$this->_tableName = "clientes_exames";
	}
	
	/**
	 *
	 * @param $where mixed       	
	 */
	function get_all($where = NULL) {
		
		if(UserSession::isCliente()){
			$this->db->where("cliente_id", UserSession::user("id"));
		}
		
		$this->db->join("tipo_exame", "clientes_exames.exame_id = tipo_exame.id");
		
		if ( is_null ( $where )) {
			$where = array ();
		}

		$where ['clientes_exames.status'] = 1;
		$where ['tipo_exame.status'] = 1;
		
		$query = $this->db->get_where ( $this->_tableName, $where );
		
		$rows = $query->result_array ();
		
		if (is_array($rows)){
			$new_rows = array();
			foreach ($rows as $row) {
				
				if ($row['sub_exames']) {
					$row['sub_exames'] = @unserialize($row['sub_exames']);
				}
				$new_rows[$row['exame_id']] = $row;
			}
			
			return $new_rows;
		}
		return $rows;
	}
	
	/**
	 *
	 * @param $where mixed       	
	 */
	function get_all_select($where = NULL, $include_subs = false, $only_subs = false) {
		
		$exames = $this->get_all($where);
		$rows = array();
		foreach ($exames as $exame) {
			$sub_exames = $exame['sub_exames'];

			if(!$only_subs) {
				$row = array(
						'value' => $exame['exame_id'],
						'title' => $exame['tipo']
				);
				$rows[] = $row;
			}
			
			if ($include_subs) {
				foreach ($sub_exames as $k => $sub_exame){
					$row = array(
						'value' => $exame['exame_id'] . "|" .$sub_exame["nome"],
						'title' => $exame['tipo'] . " - " .$sub_exame["nome"]
					);
					$rows[] = $row;
				}
			}
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

		$where ['status'] = 1;
		
		if(UserSession::isCliente()){
			$this->db->where("cliente_id", UserSession::user("id"));
		}
		$query = $this->db->get_where ( $this->_tableName, $where, 1 );
		
		$row = $query->row_array ();
		if ($row['sub_exames']) {
			$row['sub_exames'] = @unserialize($row['sub_exames']);
		}
		
		return $row;
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