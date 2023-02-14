<?php

class UserSession {
    
    const CLIENTE = "cliente";
    const MEDICO = "medico";
    const ADMIN = "admin";
    const AUDITOR = "auditor";

    private static $_instance = null;
	private $ci;
	
	public function __construct() {
		$this->ci =& get_instance();
	}
	
	public function setSession($data){
		$data['logged'] = true;
		$this->ci->session->set_userdata("user", $data);

        $this->ci->usuarios_model->update(array('logado' => date('d/m/Y H:i:s', time())), $data['id']);

    }
	
	public function login($email, $senha){
		$result = $this->ci->usuarios_model->login($email, $senha);
		return $result;
	}

	public function logout(){

	    $this->ci->usuarios_model->update(array('logado' => null), UserSession::user()['id']);

        $this->ci->session->set_userdata("user", array());
		$this->ci->session->set_flashdata('info', "Você está desconectado agora.");
		
		redirect("/login");
	}
	
	public function getSession(){
		$session = $this->ci->session->userdata("user");
		if($session){
			return $session;
		}
		return array();
	}

	public function getEmpresa(){
		return $this->ci->session->userdata("empresa");
	}
	
	public function setEmpresa($empresa){
		$this->ci->session->set_userdata("empresa", $empresa);
	}
	
	public static function isLogged($type = "user"){
		$session = UserSession::getInstance();
		$data = $session->getSession();
		
		if($data)
			return $data['logged'] == true;
		return false;
	}
	
	public static function isAdmin(){
	    $userType = self::user("tipo");
	    return ($userType == self::ADMIN || $userType == self::AUDITOR);
	}
	
	public static function isMedico(){
	    $userType = self::user("tipo");
	    return $userType == self::MEDICO;
	}
	
	public static function isCliente(){
	    $userType = self::user("tipo");
	    return $userType == self::CLIENTE;
	}

    public static function isAuditor(){
        $userType = self::user("tipo");
        return $userType == self::AUDITOR;
    }

    private function getUser(){
        $session = UserSession::getInstance();
        $data = $session->getSession();
        return $session->ci->usuarios_model->get($data['id']);
    }

    public static function isBlocked(){
        $session = UserSession::getInstance();
        $user = $session->getUser();
        return !$user;
    }

	public static function notPermited(){
	    $userSession = UserSession::getInstance();
	    $userSession->ci->session->set_flashdata('info', "Você não possui acesso a essa área. Para acessar contacte o administrador");
	    redirect("/inicio/lista");
	    exit(1);
	}
	/**
	 * 
	 * @return UserSession
	 */
	public static function getInstance(){
		if(self::$_instance == null){
			self::$_instance = new self();
		}
		
		return self::$_instance;
	}
	
	public static function user($key = ""){
		$session = UserSession::getInstance();
		$data = $session->getSession();
		
		if(empty($key)){
			return $data;
		}elseif ($string = $data[$key]){
			return $string;
		}
		return "";
	}
	
}