<?php
class Main_Controller extends MY_Controller 
{
   const EMPRESAS = "victhamed|damatelemedicina";
   
   function getEmpresa($url){
	    $url = str_replace("www.", "", $url);
		$pos = strpos($url, '.');
		if ($pos === false) return 'damatelemedicina';
		return substr($url, 0, $pos);
   }
   
   function __construct()
   {

      parent::__construct();

      date_default_timezone_set("America/Sao_Paulo");
      
      $this->output->enable_profiler(false);

	  //$empresa = strtolower($this->uri->uri_string());
	  $empresa = $this->getEmpresa($_SERVER['SERVER_NAME']);
	  
	  $pos = strpos(self::EMPRESAS, $empresa);
	  if ($pos === false) {}
	  else $this->setEmpresa($empresa);
	  
      //log_message('debug', '}>>>' . $this->uri->uri_string());
      log_message('debug', '}>>>' . $this->uri->uri_string());

      if ($this->uri->uri_string() == 'laudos/upload') return;
      if ($this->uri->uri_string() == 'laudos/download') return;
      if ($this->uri->uri_string() == 'exames/upload') return;

      if(!UserSession::getInstance()->isLogged() && $this->uri->uri_string() != "login"){
          if($this->input->is_ajax_request()){
              set_status_header(404);
              die("Common.userNotify.show('<p>Sua sessão expirou. Faça seu login novamente.</p>', 'error', 3000);");
          }else{
              redirect("login");
          }
      }
   }
   
   function setEmpresa($empresa){
   		$userSession = UserSession::getInstance();
		$userSession->setEmpresa($empresa);
		log_message('debug', 'EMPRESA:' . $userSession->getEmpresa());
   }
   
}
