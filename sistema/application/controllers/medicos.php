<?php

if (! defined ( 'BASEPATH' ))
	die ();
class Medicos extends Main_Controller {
	
	public function index() {
		redirect("usuarios/novo");
	}
	
	public function perfil() {
	    
	    if(!UserSession::isAdmin()){
	        UserSession::notPermited();
	    }
	}

	public function incluir(){

	    $post = $this->input->post();
        if (!$post){
            return $this->output
                ->set_content_type('application/json')
                ->set_status_header(200)
                ->set_output(null);

        }

        $m = array();
        $m['nome'] = strtoupper($post['nome']);
        $m['crm'] = $post['crm'];
        $m['cliente_id'] = UserSession::user("id");
        $m['status'] = 1;
        $m['tipo'] = 'solicitante';

        $doc = $this->medicos_model->get(array('crm' => $m['crm'], 'cliente_id' => $m['cliente_id']));
        if ($doc){
            return $this->output
                ->set_content_type('application/json')
                ->set_status_header(200)
                ->set_output(json_encode(array('erro' => "Médico já cadastrado")));
        }

        log_message("debug", "MEDICO INCLUIDO");
        log_message('debug', print_r($m, true));
        log_message("debug", "===============");

        $id = $this->medicos_model->insert($m);
        $this->load->disableLayout();
        return $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output(json_encode(array('id' => $id)));

    }

	public function novo_solicitante($cliente_id = null, $id = null){

	    if($post = $this->input->post()){
	            
	        $this->form_validation->set_rules('nome', 'Nome do Médico', 'required');
            $this->form_validation->set_rules('crm', 'CRM do Médico', 'required');
            $this->form_validation->set_rules('cliente_id', 'Cliente', 'required');
	        
	        if ($this->form_validation->run()){
	        
	        
	            $m = array();
	            $m['nome'] = strtoupper($post['nome']);
	            $m['crm'] = $post['crm'];
	            $m['cliente_id'] = $post['cliente_id'];
	            $m['status'] = 1;
	            $m['tipo'] = 'solicitante';
	            
	        
	            if($id = $post['_id']){
	                $this->medicos_model->update($m, $post['_id']);
	        
	                $msg = "Common.userNotify.show('<p>Os dados do Médico foram atualizados</p>', 'success', 3000);";

	                $m['medico_id'] = $id;
	                $msg .= " medicos.updateRowMedicoSolicitante('#row-sol-$id', ".json_encode($m).")";
	            }else{
	                $id = $this->medicos_model->insert($m);
	                $msg = "Common.userNotify.show('<p>Médico Cadastrado</p>', 'success', 3000);";

	                $m['medico_id'] = $id;
	                $msg .= " medicos.insertRowMedicoSolicitante(".json_encode($m).")";
	            }
	            
	            die($msg);

	        }else{
				die("Common.userNotify.show('".raw($this->form_validation->error_string())."', 'error', 8000);");
			}
	    }else{
			if($id){
	    		$this->_dataView['medico'] = $this->medicos_model->get($id);
			}
	        $this->_dataView['clientes'] = $this->clientes_model->get_all();
	        $this->_dataView['cliente_id'] = $cliente_id;
	        
	        if ($this->input->is_ajax_request()){
	            $this->load->disableLayout();
	            $this->load->view("medicos/novo_solicitantes_modal", $this->_dataView, false);
	        }else{
	            $this->load->view($this->_dataView);
	        }
	    }
	}
	
	public function remove_solicitante($id){
	    
	    if(!UserSession::isAdmin()){
	        UserSession::notPermited();
	    }
	    
		if($id){
			$this->medicos_model->delete($id);
			die("Common.userNotify.show('<p>Médico Removido</p>', 'success', 3000);");
		}
	}
}

/* End of file usuarios.php */
/* Location: ./application/controllers/usuarios.php */
