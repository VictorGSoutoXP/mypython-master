<?php

if (! defined ( 'BASEPATH' ))
	die ();
class Laudos extends Main_Controller {
	
	public function index() {
		redirect("laudos/modelos");
	}

	public function upload(){
        if (!($_SERVER['REQUEST_METHOD'] == 'POST')) return;

        $key = str_replace("key=", "", $_SERVER['QUERY_STRING']);

        $medico = $this->usuarios_model->get_medico_by_key($key);
        if (!$medico) {
            $this->output->set_content_type('application/json')->set_output(json_encode(array('error' => 'Chave invalida!')));
            return;
        }

        log_message('debug', print_r($medico, true));

        $config ['upload_path'] = config_item('upload_folder').'laudos/assinados';
        $config ['allowed_types'] = '*';
        $config ['max_size'] = 1024 * 100; // 100MB
        $config ['encrypt_name'] = true;

        //log_message("debug", print_r($config, true));

        $this->load->library( 'upload', $config );

        if (!$this->upload->do_upload("file")) {
            $this->output->set_content_type('application/json')->set_output(json_encode(array('error' => 'File upload Error!')));
            return;
        }

        //$this->output->set_content_type('application/json')->set_output(json_encode(array('error' => 'File upload Error!')));

        $data = $this->upload->data();
        //log_message('debug', print_r($data, true));
        $exame_id = substr($data['client_name'], 0, strpos($data['client_name'], '-'));
        log_message('debug', '---------------------------');
        log_message("debug", 'medico_id: ' . $medico['id']);
        log_message('debug', 'exame_id.: ' . $exame_id);
        log_message('debug', 'arquivo_laudo_assinado: ' . $data['file_name']);
        log_message('debug', '---------------------------');

        $exame = $this->pacientes_exames_model->get($exame_id);
        if ($exame['medico_id'] !== $medico['id']) {
            $this->output->set_content_type('application/json')->set_output(json_encode(array('error' => 'Exame nao pertence ao medico!')));
            return;
        }

        $path = config_item('upload_folder').'laudos/assinados/';
        $nome_assinado = $exame_id . '-' . $data['file_name'];
        rename($path . $data['file_name'], $path . $nome_assinado);

        $this->pacientes_exames_model->update(array('arquivo_laudo_assinado' => $nome_assinado), $exame_id);

        $exame = $this->pacientes_exames_model->get($exame_id);
        log_message('debug', print_r($exame, true));

        $this->output->set_content_type('application/json')->set_output(json_encode(array('message' => 'Exame atualizado!')));

        //$f = strtolower($data['file_name']);

    }

    private function geraZipParaDownload($laudos, $clinica){

        $tipo_exame = array('ECG', 'EEG', 'ESPIRO', 'RAIOX', 'MAPA', 'ACUIDADE', "EEG_CLINICO", "MAPEAMENTO", "RAIOX_OIT");

        $path = config_item('upload_folder') . 'laudos/';
        $path_zip = $path . 'download/';
        $zip_name = $path_zip . $clinica->id . '.zip';

        if (!file_exists($path_zip))  mkdir($path_zip, 0777, true);
        if (file_exists($zip_name)) unlink ($zip_name);

        $zip  = new ZipArchive();
        if ($zip->open($zip_name,  ZipArchive::CREATE) == true) {
            foreach ($laudos as $laudo){
                $file = trim($laudo['arquivo_laudo']);
                if (empty($file)) continue;
                $file = $path . $file;
                if (!file_exists($file)) continue;
                $name = "LAUDO_" . $laudo["id"] . "_" . $tipo_exame[$laudo["exame_id"]-1] . "_" . str_replace(" ", "_", $laudo["nome"]) . '.pdf';
                //$name = $laudo["id"] . "-" . str_replace(" ", "-", $laudo["nome"]) . "-" . trim($laudo["nascimento"]) . '.pdf';

                $this->pacientes_exames_model->update(
                    array('laudo_download_date' => date("Y-m-d H:i:s")),
                    $laudo["id"]
                );

                $zip->addFile($file, $name);
            }
            $zip->close();
        }

        return $zip_name;

    }

    public function download() {

        $this->load->disableLayout();

        if (!($_SERVER['REQUEST_METHOD'] == 'GET')) return;

        $key = str_replace("key=", "", $_SERVER['QUERY_STRING']);

        $clinica = $this->usuarios_model->get_clinica_by_key($key);
        if (!$clinica) {
           $this->output->set_content_type('application/json')->set_output(json_encode(array('error' => 'Chave invalida!')));
            return;
        }

        $laudos = $this->pacientes_exames_model->getLaudosParaDownload($clinica);
        $arquivo = $this->geraZipParaDownload($laudos, $clinica);

        log_message('debug', 'ARQUIVOS DE LAUDOS EM: ' . $arquivo);

        ob_start();
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=laudos.zip');
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($arquivo));
        ob_clean();
        flush();
        readfile($arquivo);
        echo $arquivo;
        //exit();

        //log_message('debug', print_r($this->output, true));

        //echo "OK";
    }

	/**
     * ######################
     * REMOVER POSTERIORMENTE
     * ######################
     */
	public function laudo() {

    //    $this->load->library('g_laudos');

	//    $this->_dataView['exame'] = $this->pacientes_exames_model->get(156154);
    //    $this->_dataView['CERT']  = $this->g_laudos->getCertificado($this->_dataView['exame']['medico_id'], 1);

    //    $this->load->view($this->_dataView);

    //    $exame['spacer'] = (95 - strlen($exame['exame']) - strlen('xx/xx/xxxx') - strlen('LAUDO DE DIGITAL') / 2);
    //    $exame['titulo'] =  date('d/m/Y', strtotime($exame['laudo_date'])) .
    //                        str_repeat(" ", 50) . //(95 - strlen($exame['exame']) - strlen('xx/xx/xxxx') - strlen('LAUDO DE DIGITAL') / 2)) .
    //                        'LAUDO DE ' . $exame['exame'] . ' DIGITAL';
    //                        str_repeat(' ', (95 - strlen($exame['exame']) - strlen('xx/xx/xxxx') - strlen('LAUDO DE DIGITAL') / 2));

    //    log_message('debug', '>>>>>> ' . $exame['spacer']);

    //    $this->_dataView['exame'] = $exame;
    //    $this->load->view ($this->_dataView);

    }

    //public function validar(){
        //$this->layout = null;
        //echo json_encode(array('status' => $status, 'msg' => $msg));
        // you can use this but your layout should be null
    //    $this->output
    //        ->set_content_type('application/json')
    //        ->set_output(json_encode(array('foo' => 'bar')));

    //}

    public function pdf($id){

		$exame = $this->pacientes_exames_model->get($id);

		$this->load->library('g_laudos');

        $this->g_laudos->dest_path = config_item('upload_folder').'/laudos/';

		//if($exame['status'] == 1){

			$this->g_laudos->gerar_laudo($id);
			
		//}elseif($exame['status'] == 2){

		//	$this->g_laudos->gerar_impossibilitado($id);
		//}
	}

	public function modelos($id = null) {
		
		$this->_dataView['modelos'] = $this->modelos_laudo_model->get_all();
		
		$this->load->view ($this->_dataView);
	}
	
	public function modelo(){
		
		if($post=$this->input->post()){
			if($id = $post['_id']){
				$modelo = $this->modelos_laudo_model->get($id);
				die($modelo['content']);
			}
		}

		die();

	}

	public function novo_modelo($id){
		if($post=$this->input->post()){
			$this->load->disableLayout();
			$this->form_validation->set_rules('title', 'Titulo', 'required');
			$this->form_validation->set_rules('content', 'Conteúdo', 'required');
			
			if ($this->form_validation->run()){
				$modelo = array();
				$modelo['title'] = $post['title'];
				$modelo['content'] = $post['content'];
				$modelo['medico_id'] = UserSession::user('id');
				
				if($post['_id']){
					$this->modelos_laudo_model->update($modelo, $post['_id']);
						
					die("Common.userNotify.show('<p>O Modelo foi Atualizado</p>', 'success', 2000, null, function(){ window.location = '".site_url("laudos/modelos/")."'});");
						
				}else{
					$this->modelos_laudo_model->insert($modelo);
						
					die("Common.userNotify.show('<p>Modelo Cadastrado</p>', 'success', 1500, null, function(){ window.location = '".site_url("laudos/modelos/")."'});");
				}
				
			}else{
				die("Common.userNotify.show('".raw($this->form_validation->error_string())."', 'error', 8000);");
			}
		}else{
			if($id){
				$this->_dataView['modelo'] = $this->modelos_laudo_model->get($id);
			}
			
			$this->load->view ($this->_dataView);
		}
	}
	
	
	public function delete_modelo($id){
		 
		if(!UserSession::isAdmin() && !UserSession::isMedico()){
			UserSession::notPermited();
		}
		 
		if($id){
			$this->modelos_laudo_model->delete($id);
			die("Common.userNotify.show('<p>Modelo Removido</p>', 'success', 3000);");
		}
	}
	
}

/* End of file laudos.php */
/* Location: ./application/controllers/laudos.php */
