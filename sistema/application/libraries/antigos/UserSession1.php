<?php

class UserSession {
    
    const CLIENTE = "cliente";
    const MEDICO = "medico";
    const ADMIN = "admin";
	
	private static $_instance = null;
	private $ci;
	
	public function __construct() {
		$this->ci =& get_instance();
	}
	
	public function setSession($data){
		$data['logged'] = true;
		$this->ci->session->set_userdata("user", $data);
	}
	
	public function login($email, $senha){
		$result = $this->ci->usuarios_model->login($email, $senha);
		return $result;
	}
	
	public function logout(){
		
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
	
	public static function isLogged($type = "user"){
		$session = UserSession::getInstance();
		$data = $session->getSession();
		
		if($data)
			return $data['logged'] == true;
		return false;
	}
	
	public static function isAdmin(){
	    $userType = self::user("tipo");
	    return $userType == self::ADMIN;
	}
	
	public static function isMedico(){
	    $userType = self::user("tipo");
	    return $userType == self::MEDICO;
	}
	
	public static function isCliente(){
	    $userType = self::user("tipo");
	    return $userType == self::CLIENTE;
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