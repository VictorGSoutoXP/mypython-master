<?php

if (! defined ( 'BASEPATH' ))
	die ();
class Pacientes extends Main_Controller {
	
	public function index() {
		redirect("pacientes/novo");
	}
	
	public function novo($id = null) {
		
		if($post = $this->input->post()){
			$this->load->disableLayout();
			$this->form_validation->set_rules('nome', 'Nome', 'required|min_length[10]');
			//$this->form_validation->set_rules('cpf', 'CPF', 'required|callback_cpf_check');
			//$this->form_validation->set_rules('email', 'Email', 'required|valid_email|callback_email_check');
			$this->form_validation->set_rules('telefone', 'Telefone', 'required');
			
			if ($this->form_validation->run()){
				$p = array();
				$p['nome'] = strtoupper($post['nome']);
				$p['cpf'] = preg_replace("/\D/", "", $post['cpf']);
				$p['email'] = $post['email'];
				$p['telefone'] = preg_replace("/\D/", "", $post['telefone']);
				
				if($post['_id']){
					$this->pacientes_model->update($p, $post['_id']);
					
					die("Common.userNotify.show('<p>Os dados do Paciente foram atualizados</p>', 'success', 3000);");
					
				}else{
					$this->pacientes_model->insert($p);
					
					die("Common.userNotify.show('<p>Paciente Cadastrado</p>', 'success', 2000, false, function(){location.reload(true);});");
				}
				
			}else{
				die("Common.userNotify.show('".raw($this->form_validation->error_string())."', 'error', 8000);");
				
			}
		}else{
			if($id){
				$this->_dataView['paciente'] = $this->pacientes_model->get($id);
				if(!$this->_dataView['paciente']){
					redirect("pacientes/novo");
				}
			}
				$this->_dataView['pacientes'] = $this->pacientes_model->get_all();
			
			$this->load->view ($this->_dataView);
		}
	}
	
	public function delete($id){
		if($id){
			$this->pacientes_model->delete($id);
			die("Common.userNotify.show('<p>Paciente Removido</p>', 'success', 3000);");
		}
	}
	
	public function cpf_check($cpf) {
		$id = $this->input->post ( "_id" );
		
		if (! $this->pacientes_model->cpf_exists ( $cpf, $id )) {
			$this->form_validation->set_message ( 'cpf_check', 'Já existe outro Paciente com este CPF.' );
			return FALSE;
		} elseif (! validaCPF ( $cpf )) {
			$this->form_validation->set_message ( 'cpf_check', 'Este número de CPF não é Válido.' );
			return FALSE;
		} else {
			return TRUE;
		}
	}
	
	
	public function email_check($email) {
		$id = $this->input->post ( "_id" );
		
		if (! $this->pacientes_model->email_exists ( $email, $id )) {
			$this->form_validation->set_message ( 'email_check', 'Já existe outro Paciente com este Email.' );
			return FALSE;
		} else {
			return TRUE;
		}
	}
}

/* End of file pacientes.php */
/* Location: ./application/controllers/pacientes.php */
