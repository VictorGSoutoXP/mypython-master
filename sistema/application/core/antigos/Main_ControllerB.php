<?php
class Main_Controller extends MY_Controller 
{
   function __construct()
   {

      parent::__construct();

      date_default_timezone_set("America/Sao_Paulo");
      
      $this->output->enable_profiler(false);

      if ($this->uri->uri_string() == 'laudos/upload') return;
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
}
