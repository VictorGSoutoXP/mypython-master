<?php
if (! defined ( 'BASEPATH' ))
    die ();
class Inicio extends Main_Controller {

    public function index() {
        redirect ( "inicio/lista" );
    }
    
    public function test_pusher(){
    	
    	$this->load->library('pusher');
    	
    	echo date_default_timezone_get();
    	
    	$data = array();
    	$data['icon'] = null;
    	$data['title'] = "Alerta";
    	$data['content'] = "Novo Exame Recebido!";
    	$data['gotourl'] = site_url("exames/single/755");
    	
    	echo date("d/m/Y H:i:s");
    	echo "<br />";
    	
    	echo $this->pusher->trigger(get_pusher_channel(), 'new_notification', $data, null, true);
    }

    public function lista() {

        $params = array ();
        
        $params ['mes'] = $this->input->get ( 'mes' );
        $params ['ano'] = $this->input->get ( 'ano' );
        $params ['exame'] = $this->input->get ( 'exame' );
        $params ['status'] = $this->input->get ( 'status' );

        $params['bloquear_simultaneo'] = UserSession::user()['bloquear_simultaneo'];

        $this->_dataView ['params'] = $params;
        $this->_dataView ['exames_select'] = $this->clientes_exames_model->get_all_select (null, true);

        $this->_dataView ['exames'] = $this->pacientes_exames_model->get_all( $params );

        $this->_dataView ['anos'] = $this->pacientes_exames_model->get_years ();
        $this->_dataView ['meses'] = $this->pacientes_exames_model->get_months ();

        $this->load->view ( $this->_dataView );
    }

    public function manuais(){
        $this->load->view ( $this->_dataView );
    }

    public function expirando() {
    	
    	if(!UserSession::isAdmin() && !UserSession::isMedico()){
    		redirect("/");
    	}

    	//$this->pacientes_exames_model->db->order_by("create_date");
        $this->pacientes_exames_model->db->order_by("emergencia desc, create_date asc, rnd asc");

        $this->_dataView ['exames'] = $this->pacientes_exames_model->get_all ( array("status" => "0", "ativo" => 1, "expirando" => true) );
        $this->_dataView ['anos'] = $this->pacientes_exames_model->get_years ();
        $this->_dataView ['meses'] = $this->pacientes_exames_model->get_months ();
        
        $this->load->view ( $this->_dataView );
    }

    public function pesquisa() {
        
        $params = array ();

		log_message('debug', '>>> 1');
		
        $params ['exame'] = $this->input->get ( 'exame' );
        $params ['paciente'] = $this->input->get ( 'paciente' );
        $params ['cliente'] = $this->input->get ( 'cliente' );
        $params ['inicio'] = $this->input->get ( 'inicio' );
        $params ['fim'] = $this->input->get ( 'fim' );
        $params ['status'] = $this->input->get ( 'status' );

		log_message('debug', '>>> 2');
        
        //$this->_dataView['exames_select'] = $this->pacientes_exames_model->get_all();
        
		$this->_dataView['clientes']  = $this->usuarios_model->get_all(array('tipo' => 'cliente'));
        
		log_message('debug', '>>> 3');

		$this->_dataView ['params'] = $params;
		
		log_message('debug', '>>> 4');

        $this->_dataView ['exames'] = $this->pacientes_exames_model->get_exames ( $params );

		log_message('debug', '>>> 5');

		//log_message('debug', print_r($this->_dataView ['exames'], true));
        
        $this->load->view ( $this->_dataView );
    }

}

/* End of file inicio.php */
/* Location: ./application/controllers/inicio.php */
