<?php

class Usuarios_model extends MY_Model {
	
	function __construct() {
		parent::__construct ();
		$this->_tableName = "usuarios";
	}

	function getAdminAndAudit(){
        $query = $this->db->get_where ( $this->_tableName, "tipo = 'admin' OR tipo = 'auditor'");
        return $query->result_array ();
    }

	/**
	 *
	 * @param $where mixed       	
	 */
	function get_all($where = NULL) {
		
		if (! is_array ( $where )) {
			$where = array ();
		}
		$this->db->order_by("id", "DESC");
		
		if(UserSession::isCliente()){
		    $this->db->where("cliente_id", UserSession::user("id"));
		}
		if($where ['status'] != 'all'){
		    $where ['status'] = 1;
		}else{

		    unset($where ['status']);
		}
		
		$query = $this->db->get_where ( $this->_tableName, $where );
		
		return $query->result_array ();
	
	}

    function  get_logados(){
        $query = $this->db->get_where ( $this->_tableName, "logado is not null", NULL);
        return $query->result_array();
    }

    function get_medico_by_key($key){
        $where = array('tipo' => 'medico', 'chave_transmissao' => $key);
        $query = $this->db->get_where( $this->_tableName, $where );
        $query = $query->result_array();
        if ($query) return (object)$query[0];
        return null;

    }

    function get_clinica_by_key($key){
        $where = array('tipo' => 'cliente', 'chave_transmissao' => $key);
        $query = $this->db->get_where( $this->_tableName, $where );
        $query = $query->result_array();
        if ($query) return (object)$query[0];
        return null;
    }

    function get_clinica_by_cnpj($cnpj){
        $where = array('tipo' => 'cliente', 'cpf_cnpj' => $cnpj, 'status' => 1);
        $query = $this->db->get_where( $this->_tableName, $where );
        $query = $query->result_array();
        if ($query) return (object)$query[0];
        return null;
    }

    function get_clinica_by_institution_name($name){
        $where = array('tipo' => 'cliente', 'dicom_institution_name' => $name, 'status' => 1);
        $query = $this->db->get_where( $this->_tableName, $where );
        $query = $query->result_array();
        if ($query) return (object)$query[0];
        return null;
    }

    function get_medico_responsavel(){
	    $id = UserSession::user("id");
	    
	    $this->db->from($this->_tableName . " clientes");
	    $this->db->join($this->_tableName . " medicos", "medicos.id = clientes.medico_responsavel");
	    $this->db->where("clientes.id", $id);
	    $this->db->where("clientes.status", 1);
	    $this->db->limit(1);
	    
	    $query = $this->db->get();
	    
	    return $query->row_array();
	}

	function get_medicos_solicitantes($cliente_id) {
		
		if (! is_array ( $where )) {
			$where = array ();
		}
		$this->db->order_by("id", "DESC");
		
		//if(UserSession::isCliente()){
		    $this->db->where("cliente_id", UserSession::user("id"));
		//}
		$where['tipo'] = 'medico';
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
		
		$query = $this->db->get_where( $this->_tableName, $where, 1 );
		
		return $query->row_array();
	
	}
	
	function update(array $data, $where){
		if ($data['senha']){
		    $data['senha'] = $this->pass($data['senha']);
		}
		return parent::update($data, $where);
	}
	
	function insert(array $data){
		if ($data['senha']){
		    $data['senha'] = $this->pass($data['senha']);
		}
		return parent::insert($data);
	}
	
	function delete($where) {
		
		if (! is_array ( $where ) && ! is_null ( $where )) {
			$where = array ("id" => $where );
		}
		
		$data = array ("status" => 0 );
		
		return $this->update ( $data, $where );
	}
	
	function send_dados_email(array $dados){
		
		$this->mailer->to = $dados['email'];
		$this->mailer->subject = "Dados de Acesso - " . config_item("site_name");
		$this->mailer->message = $this->load->view("mail/dados_user", $dados, TRUE, FALSE);
		
		$this->mailer->send();
	}
	
	function cpf_cnpj_exists($cpf_cnpj, $id = NULL) {
		$cpf_cnpj = preg_replace ( "/\D/", "", $cpf_cnpj );
		
		if ($id) {
			$this->db->where ( "id <>", $id );
		}
		$this->db->where ( "status", 1 );
		$query = $this->db->limit ( 1 )->get_where ( $this->_tableName, array ("cpf_cnpj" => $cpf_cnpj ) );
		return $query->num_rows () === 0;
	}
	
	function email_exists($email, $id = NULL) {
		
		if ($id) {
			$this->db->where ( "id <>", $id );
		}
		$this->db->where ( "status", 1 );
		$query = $this->db->limit ( 1 )->get_where ( $this->_tableName, array ("email" => $email ) );
		return $query->num_rows () === 0;
	}
	

	public function login($email, $senha){

		$this->db->from($this->_tableName);
		$this->db->where("email", $email);
		
		$row = $this->db->get();
		
		if($row->num_rows()> 0){
		    
		    $this->db->from($this->_tableName);
		    $this->db->where("email", $email);
		    $this->db->where("status", 1);
		    
		    $row = $this->db->get();
		    
		    if($row->num_rows() == 1){
    			$result = $row->row_array();
    			
    			if ($result['senha'] != $this->pass($senha)) {
    				$return = array("error" => "Sua senha está incorreta!");
    			}else{

    				$userSession = UserSession::getInstance();
    				$userSession->setSession($result);
                    redirect("/");

    			}
		    }else{
		        $return = array("error" => "Seu usuário foi desabilitado, contate a administração!");
		    }
		}else{
			$return = array("error" => "Não encontramos esse email em nosso Banco de Dados");
		}
		
		return $return;
	}
	
	private function pass($senha){
		$senha =  md5($senha);
		return $senha;
	}
}

?>