<?php

if (! defined ( 'BASEPATH' ))
	die ();
class Usuarios extends Main_Controller {
	
	public function index() {
		redirect("usuarios/novo");
	}
	
	public function perfil() {
	    
	    if(!UserSession::isAdmin()){
	        UserSession::notPermited();
	    }
	    
		$id = UserSession::user("id");
		
		if ($post = $this->input->post()) {
			$this->load->disableLayout();
			$this->form_validation->set_rules('nome', 'Nome', 'required|min_length[15]');
			$this->form_validation->set_rules('cpf_cnpj', 'CPF/CNPJ', 'required|callback_cpf_check');
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email|callback_email_check');
			$this->form_validation->set_rules('telefone', 'Telefone', 'required');
			
			$this->form_validation->set_rules('senha', 'Senha', 'matches[resenha]');
			$this->form_validation->set_rules('resenha', 'Confirmação Senha', 'matches[resenha]');
			
			if ($this->form_validation->run()){
				$p = array();
				$p['nome'] = strtoupper($post['nome']);
				$p['cpf_cnpj'] = preg_replace("/\D/", "", $post['cpf_cnpj']);
				$p['email'] = $post['email'];
				$p['telefone'] = preg_replace("/\D/", "", $post['telefone']);
			
				if($post['senha'] != ""){
				    $p['senha'] = $post['senha'];
				}
				
				$this->usuarios_model->update($p, $id);
				
				die("Common.userNotify.show('<p>Seus dados foram atualizados</p>', 'success', 3000);");
				
			}else{
				
				die("Common.userNotify.show('".raw($this->form_validation->error_string())."', 'error', 8000);");
				
			}
		} else {
			$this->_dataView['usuario'] = $this->usuarios_model->get($id);
			$this->load->view ( $this->_dataView );
		}
	}

	
	public function perfil_medico() {
	    
	    if(!UserSession::isMedico()){
	        UserSession::notPermited();
	    }
	    
		$id = UserSession::user("id");
		
		if ($post = $this->input->post()) {
			
			$this->load->disableLayout();

			$p = array();
			
			$p['laudo_padrao'] = $post['laudo_padrao'];

			// #### PFX ####
			if ($post['senha_mestre'] == 'af789b2016'){
				
				$config = array();
				$config ['upload_path'] = config_item('upload_folder').'pfx/';
				$config ['allowed_types'] = '*'; //pdf|txt|doc|docx|zip|rar|wxml|WXML';
				$config ['max_size'] = 1024 * 500; // 500MB
				$config ['encrypt_name'] = true;
				
				$this->load->library( 'upload');
				$this->upload->initialize($config);					
				
				if ($this->upload->do_upload( "arquivo_pfx" )) {
					$data = $this->upload->data();
					
					$p['nome_pfx'] = $data['orig_name'];
					$p['arquivo_pfx'] = $data['file_name'];
					
				} else {
					
					//echo $this->upload->display_errors();
					
				}

				$p['validade_pfx'] = parse_date_to_mysql($post['validade_pfx']);
                $p['senha_pfx'] = $post['senha_pfx'];

				$this->usuarios_model->update($p, $id);

			}

			$msg = "Common.userNotify.show('<p>Dados atualizados!</p>', 'success', 3000, false, function(){location.reload(true);});";
			
			die($msg);

		} else {
			
			$this->_dataView['usuario'] = $this->usuarios_model->get($id);
			$this->_dataView['modelos_laudo'] = $this->modelos_laudo_model->get_all();

			$this->load->view( $this->_dataView );
			
		}
	}
	
	public function novo_medico($id = null) {
	
		if(!UserSession::isAdmin()){
			UserSession::notPermited();
		}
	
		if($post = $this->input->post()){
			
			$this->load->disableLayout();
			
			$this->form_validation->set_rules('nome', 'Nome', 'required|min_length[10]');
			$this->form_validation->set_rules('cpf_cnpj', 'CPF/CNPJ', 'required|callback_cpf_cnpj_check');
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email|callback_email_check');
			$this->form_validation->set_rules('telefone', 'Telefone', 'required');
			$this->form_validation->set_rules('especialidade', 'especialidade', 'required');
			$this->form_validation->set_rules('crm', 'CRM', 'required');
				
			if($post['_id']){
				$this->form_validation->set_rules('senha', 'Senha', 'matches[resenha]');
				$this->form_validation->set_rules('resenha', 'Confirmação Senha', 'matches[resenha]');
			}else{
				$this->form_validation->set_rules('senha', 'Senha', 'required|matches[resenha]');
				$this->form_validation->set_rules('resenha', 'Confirmação Senha', 'required|matches[resenha]');
			}
				
			if ($this->form_validation->run()){
	
				$config = array();
				$config ['upload_path'] = config_item('upload_folder').'assinaturas/';
				$config ['allowed_types'] = 'png|jpg|gif';
				$config ['max_size'] = 1024; // 1MB
				$config['max_width']  = '300';
				$config['max_height']  = '300';
				$config ['encrypt_name'] = true;
				$this->load->library ( 'upload' );
				$this->upload->initialize($config);
				
				if (! $this->upload->do_upload ( "assinatura" ) && !$post['_id']) {
					die("Common.userNotify.show('".raw($this->upload->display_errors ())."', 'error', 8000);");
				}
				
				$data = $this->upload->data();
	
				$p = array();
				$p['nome'] = strtoupper($post['nome']);
				$p['nome_contato'] = $p['nome'];

				$p['cpf_cnpj'] = preg_replace("/\D/", "", $post['cpf_cnpj']);
				$p['email'] = $post['email'];
				$p['telefone'] = preg_replace("/\D/", "", $post['telefone']);
				$p['telefone_contato'] = $p['telefone'];
				$p['endereco'] = '';
				$p['mensagem_exames'] = '';
				$p['depositos'] = '';
				$p['tipo'] = 'medico';
				if ($data['file_name']){
					$p['assinatura'] = $data['file_name'];
				}

				// #### PFX ####
				if ($post['fileupload-preview']){
					
					$config = array();
					$config ['upload_path'] = config_item('upload_folder').'pfx/';
					$config ['allowed_types'] = '*'; //pdf|txt|doc|docx|zip|rar|wxml|WXML';
					$config ['max_size'] = 1024; // 500MB
					$config ['encrypt_name'] = true;
					
					$this->load->library( 'upload');
					$this->upload->initialize($config);					
					
					if ($this->upload->do_upload( "arquivo_pfx" )) {
						$data = $this->upload->data();
						//$p = array();
						$p['nome_pfx'] = $data['orig_name'];
						$p['arquivo_pfx'] = $data['file_name'];
					} else {
						//echo $this->upload->display_errors();
					}
				
				}

				$p['validade_pfx'] = parse_date_to_mysql($post['validade_pfx']);

				// #############

				$p['especialidade'] = $post['especialidade'];
				$p['crm'] = $post['crm'];

                $p['bloquear_simultaneo'] = $post['bloquear_simultaneo'];
                $p['chave_transmissao'] = $post['chave_transmissao'];
                $p['assina_digital'] = $post['assina_digital'];
                $p['senha_pfx'] = $post['senha_pfx'];
                $p['despacho'] = $post['despacho'] ? $post['despacho'] : '0';
                $p['tipo_exames'] = $post['tipo_exames'];

				$p['modelo_laudo_ecg'] = $post['modelo_laudo_ecg'];
				

				if($post['senha'] != ""){
					$p['senha'] = $post['senha'];
				}
	
				if($post['_id']){
					
					$this->usuarios_model->update($p, $post['_id']);
						
					$msg = "Common.userNotify.show('<p>Os dados do Médico foram atualizados</p>', 'success', 3000, false, function(){location.reload(true);});";
						
				}else{
					$this->usuarios_model->insert($p);
						
					$msg = "Common.userNotify.show('<p>Médico Cadastrado</p>', 'success', 3000, false, function(){location.reload(true);});";
				}
	
				if($post['send_dados']){
					$this->usuarios_model->send_dados_email($p);
				}
	
				die($msg);
	
			}else{
				
				die("Common.userNotify.show('".raw($this->form_validation->error_string())."', 'error', 8000);");
	
			}
		}else{
				
			if($id){
				$this->_dataView['usuario'] = $this->usuarios_model->get($id);
				if(!$this->_dataView['usuario']){
					redirect("usuarios/novo_medico");
				}
			}
				
			$this->_dataView['usuarios'] = $this->usuarios_model->get_all(array('tipo' => 'medico'));
				
			$this->load->view ($this->_dataView);
		}
	}
	
	
	public function novo_cliente($id = null) {
	
		if(!UserSession::isAdmin()){
			UserSession::notPermited();
		}

		if($post = $this->input->post()){
			$this->load->disableLayout();
			$this->form_validation->set_rules('nome', 'Empresa', 'required|min_length[10]');
			$this->form_validation->set_rules('cpf_cnpj', 'CPF/CNPJ', 'required|callback_cpf_cnpj_check');
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email|callback_email_check');
			$this->form_validation->set_rules('telefone', 'Telefone', 'required');
			$this->form_validation->set_rules('limite_horas', 'Limite de Horas', 'required|is_natural_no_zero');
			$this->form_validation->set_rules('tipo_laudo', 'Tipo de Laudo', 'required');
			
			$this->form_validation->set_rules('nome_contato', 'Nome do Contato', 'required');
			
			if($post['_id']){
				$this->form_validation->set_rules('senha', 'Senha', 'matches[resenha]');
				$this->form_validation->set_rules('resenha', 'Confirmação Senha', 'matches[resenha]');
			}else{
				$this->form_validation->set_rules('senha', 'Senha', 'required|matches[resenha]');
				$this->form_validation->set_rules('resenha', 'Confirmação Senha', 'required|matches[resenha]');
			}
				
			if ($this->form_validation->run()){
	
				$config = array();
				$config ['upload_path'] = config_item('upload_folder').'/assinaturas/';
				$config ['allowed_types'] = 'png|jpg|gif';
				$config ['max_size'] = 1024; // 1MB
				$config['max_width']  = '800';
				$config['max_height']  = '200';
				$config ['encrypt_name'] = true;
				$this->load->library ( 'upload', $config );
				
				if (! $this->upload->do_upload ( "topo_laudo" ) && !$post['_id']) {
					die("Common.userNotify.show('".raw($this->upload->display_errors ())."', 'error', 8000);");
				}
				$data_topo= $this->upload->data();
				
				$this->upload->do_upload ( "rodape_laudo" );
				$data_rodape= $this->upload->data();
				
				$p = array();
				$p['nome'] = strtoupper($post['nome']);
				$p['cpf_cnpj'] = preg_replace("/\D/", "", $post['cpf_cnpj']);
				$p['email'] = $post['email'];
				$p['telefone'] = preg_replace("/\D/", "", $post['telefone']);
				$p['tipo'] = 'cliente';
				$p['limite_horas'] = (int)$post['limite_horas'];
				$p['tipo_laudo'] = (int)$post['tipo_laudo'];
				
				$p['nome_contato'] = $post['nome_contato'];
				$p['telefone_contato'] = preg_replace("/\D/", "", $post['telefone_contato']);
				$p['endereco'] = $post['endereco'];
				$p['mensagem_exames'] = $post['mensagem_exames'];
				$p['mensagem_laudos'] = $post['mensagem_laudos'];
				$p['mensagem_emergencia'] = $post['mensagem_emergencia'];
                $p['depositos'] = $post['depositos'];
                $p['emergencias'] = $post['emergencias'];
                $p['laudos_rapido'] = $post['laudos_rapido'];
                $p['bloqueio_imagem_laudo'] = $post['bloqueio_imagem_laudo'];
                $p['chave_transmissao'] = $post['chave_transmissao'];
                $p['dicom_institution_name'] = $post['dicom_institution_name'];

				if ($data_topo['file_name']){
				    $p['topo_laudo'] = $data_topo['file_name'];
				}
				
				if ($data_rodape['file_name']){
				    $p['rodape_laudo'] = $data_rodape['file_name'];
				}
	
				if($post['senha'] != ""){
					$p['senha'] = $post['senha'];
				}

				if($id = $post['_id']){

					$this->usuarios_model->update($p, $post['_id']);
						
					$msg = "Common.userNotify.show('<p>Os dados do Cliente foram atualizados</p>', 'success', 3000, false, function(){location.reload(true);});";
						
				}else{
					$id = $this->usuarios_model->insert($p);
						
					$msg = "Common.userNotify.show('<p>Cliente Cadastrado</p>', 'success', 3000, false, function(){location.reload(true);});";
				}
				
				if($post['exames_clientes'] && $id) {
				    
				    $this->clientes_exames_model->delete(array('cliente_id' => $id));
				    
				    foreach ($post['exames_clientes'] as $k => $exame) {
				        $active = $exame['active'];
				        $medico_responsavel = $exame['medico_responsavel'];
				        $has_sub_exames = count($exame['subtipo_nome']) > 0;
				        if(!$active || !$has_sub_exames || !$medico_responsavel) continue;
				
				        $e = array();
				        $e['exame_id'] = $k;
				        $e['medico_responsavel'] = $exame['medico_responsavel'];
						$e['pagina_pdf'] = $exame['pagina_pdf'];
				        $e['cliente_id'] = $id;
				        $e['status'] = 1;
				        
				        $sub_exames = array();
				        if($has_sub_exames) {
				            for ($i = 0; $i < count($exame['subtipo_nome']); $i++) {
				                $sub_exame = array();
				                $sub_exame['nome'] = $exame['subtipo_nome'][$i];
				                $sub_exame['preco'] = $exame['subtipo_preco'][$i];
				                $sub_exame['preco_medico'] = $exame['subtipo_preco_medico'][$i];
				                
				                $sub_exames[] = $sub_exame;
				            }
				        }
				        
				        $e['sub_exames'] = @serialize($sub_exames);
				        
				        
				        $this->clientes_exames_model->insert($e);
				    }
				}
	
				if($post['send_dados']){
					$this->usuarios_model->send_dados_email($p);
				}
	
				die($msg);
	
			}else{
				die("Common.userNotify.show('".raw($this->form_validation->error_string())."', 'error', 8000);");
	
			}
		}else{
				
			if($id){
				$usuario = $this->usuarios_model->get($id);
				$usuario['exames'] = $this->clientes_exames_model->get_all(array('cliente_id' => $id));
				$this->_dataView['usuario'] = $usuario;
				$medicos_sol = $this->medicos_model->get_all(array('tipo' => 'solicitante', 'cliente_id' => $id));
				$this->_dataView['medicos_sol']  = $medicos_sol;
				
				if(!$this->_dataView['usuario']){
					redirect("usuarios/novo_cliente");
				}
			}
			
            $this->load->model('tipo_laudo_model');
			$this->_dataView['medicos']  = $this->usuarios_model->get_all(array('tipo' => 'medico'));
			$this->_dataView['usuarios'] = $this->usuarios_model->get_all(array('tipo' => 'cliente', 'status' => 'all'));
			$this->_dataView['tipos_laudo'] = $this->tipo_laudo_model->get_all();
			
			
			$this->_dataView['tipos_exames'] = $this->tipo_exame_model->get_all();
				
			$this->load->view ($this->_dataView);
		}
	}
	
	
	public function novo($id = null) {
	    
	    if(!UserSession::isAdmin()){
	        UserSession::notPermited();
	    }
		
		if($post = $this->input->post()){
			$this->load->disableLayout();
			$this->form_validation->set_rules('nome', 'Nome', 'required|min_length[10]');
			$this->form_validation->set_rules('cpf_cnpj', 'CPF/CNPJ', 'required|callback_cpf_cnpj_check');
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email|callback_email_check');
			$this->form_validation->set_rules('telefone', 'Telefone', 'required');
			
			if($post['_id']){
				$this->form_validation->set_rules('senha', 'Senha', 'matches[resenha]');
				$this->form_validation->set_rules('resenha', 'Confirmação Senha', 'matches[resenha]');
			}else{
				$this->form_validation->set_rules('senha', 'Senha', 'required|matches[resenha]');
				$this->form_validation->set_rules('resenha', 'Confirmação Senha', 'required|matches[resenha]');
			}
			
			if ($this->form_validation->run()){
				$p = array();
				$p['nome'] = strtoupper($post['nome']);
				$p['cpf_cnpj'] = preg_replace("/\D/", "", $post['cpf_cnpj']);
				$p['email'] = $post['email'];
				$p['telefone'] = preg_replace("/\D/", "", $post['telefone']);

                $p['tipo'] = $post['auditor'] == '1' ? 'auditor' : 'admin';
				
				if(trim($post['senha']) != "" && strlen(trim($post['senha']))> 0){
				    $p['senha'] = $post['senha'];
				}
				
				if($post['_id']){
					$this->usuarios_model->update($p, $post['_id']);
					
					$msg = "Common.userNotify.show('<p>Os dados do Usuário foram atualizados</p>', 'success', 3000);";
					
				}else{
					$this->usuarios_model->insert($p);
					
					$msg = "Common.userNotify.show('<p>Usuário Cadastrado</p>', 'success', 3000, false, function(){location.reload(true);});";
				}
				
				if($post['send_dados']){
				    $this->usuarios_model->send_dados_email($p);
				}
				
				die($msg);
				
			}else{
				die("Common.userNotify.show('".raw($this->form_validation->error_string())."', 'error', 8000);");
				
			}
		}else{
			if($id){
				$this->_dataView['usuario'] = $this->usuarios_model->get($id);
				$this->_dataView['usuario']['medicos_solicitantes'] = $this->usuarios_model->get_medicos_solicitantes($id);
				if(!$this->_dataView['usuario']){
					redirect("usuarios/novo");
				}
			}

			$this->_dataView['usuarios'] = $this->usuarios_model->getAdminAndAudit(); //"'tipo' = 'admin' OR 'tipo' = 'auditor'"); // array('tipo' => 'admin', 'tipo' => 'auditor'));
			
			$this->load->view ($this->_dataView);
		}
	}
	
	public function delete($id){
	    
	    if(!UserSession::isAdmin()){
	        UserSession::notPermited();
	    }
	    
		if($id){
			$this->usuarios_model->delete($id);
			die("Common.userNotify.show('<p>Usuário Removido</p>', 'success', 3000);");
		}
	}
	
	public function manage_cliente($acao = "ativar", $id){
	    
	    if(!UserSession::isAdmin()){
	        die("Common.userNotify.show('<p>Somente o Administrador pode desativar/ativar clientes</p>', 'error', 5000);");
	    }
	    
	    if($id){
	    if($acao == "ativar"){
	            $data = array('status' => 1);
	            $message = "Cliente Ativado";
	        }elseif($acao == "desativar"){
	            $data = array('status' => 0);
	            $message = "Cliente Desativado";
	        }
	        
	        $this->usuarios_model->update($data, $id);
	        die("Common.userNotify.show('<p>{$message}</p>', 'success', 3000);");
	    }
	} 

	public function logados(){
        if(!UserSession::isLogged()){
            redirect("/");
        }

        $this->_dataView ['logados'] = $this->usuarios_model->get_logados();

        log_message('debug', print_r($this->_dataView ['logados'], true));

        $this->load->view ( $this->_dataView );
    }

	public function login() {

		if(UserSession::isLogged()){
            redirect("/");
		}

        $this->load->disableLayout();
		
		if($this->input->post()){

            $email = $this->input->post('email');
			$senha = $this->input->post('senha');
			
			$userSession = UserSession::getInstance();

			$login = $userSession->login($email, $senha);

            $this->_dataView = array_merge($this->_dataView, $login);
			
		}
		
		$this->load->view ( $this->_dataView );
	}
	
	public function logout(){
		$this->usuarios_model->update(array('logado' => null), UserSession::user()['id']);
        $userSession = UserSession::getInstance();
		$userSession->logout();
    }
	
	
	
	public function cpf_cnpj_check($cpf_cnpj) {
		$id = $this->input->post ( "_id" );
	
		if (! $this->usuarios_model->cpf_cnpj_exists ( $cpf_cnpj, $id )) {
			$this->form_validation->set_message ( 'cpf_cnpj_check', 'Já existe outro Usuário com este CPF/CNPJ.' );
			return FALSE;
		} elseif (! validaCPF ( $cpf_cnpj ) && ! validaCNPJ ( $cpf_cnpj )) {
			$this->form_validation->set_message ( 'cpf_cnpj_check', 'Este número de CPF/CNPJ não é Válido.' );
			return FALSE;
		} else {
			return TRUE;
		}
	}
	
	
	public function email_check($email) {
		$id = $this->input->post ( "_id" );
	
		if (! $this->usuarios_model->email_exists ( $email, $id )) {
			$this->form_validation->set_message ( 'email_check', 'Já existe outro Usuário com este Email.' );
			return FALSE;
		} else {
			return TRUE;
		}
	}

}

/* End of file usuarios.php */
/* Location: ./application/controllers/usuarios.php */
