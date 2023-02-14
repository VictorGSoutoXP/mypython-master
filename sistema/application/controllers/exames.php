<?php
if (! defined ( 'BASEPATH' ))
	die ();

class Exames extends Main_Controller {


    private $UBERMED = 38;
    private $LINEFEED = 10;

    private static $PNG_SHORTER = false;

    private static $TARGET = '/^.*\.(wxml|xml|datest|dte|dat|plg|tep|eeg|pdf|txt|dcm|oit)$/i';
    private static $HIGH_PRIORITY = '/^.*\.(xml|datest|dte)$/i';

    function __construct() {
        
        parent::__construct();

        if (UserSession::isBlocked()){
            redirect("/usuarios/logout");
            return;
        }

        $this->load->library('letters');
        $this->load->library("pusher");

        $this->load->library('g_laudos');
        $this->load->library('dicom');

        $this->g_laudos->dest_path = config_item('upload_folder') . '/laudos/';

    }

    public function index() {
		$this->load->view ( $this->_dataView );
	}
	
	public function manage_exame($acao = "ativar", $id){
	    
	    if(!UserSession::isAdmin()){
	        die("Common.userNotify.show('<p>Somente o Administrador pode desativar exames</p>', 'error', 5000);");
	    }
	    
	    if($id){
			if($acao == "ativar"){
	            $data = array('ativo' => 1);
	            $message = "Exame Ativado";
	        }elseif($acao == "desativar"){
	            $data = array('ativo' => 0);
	            $message = "Exame Desativado";
	        }
	        $this->pacientes_exames_model->update($data, $id);
	        die("Common.userNotify.show('<p>{$message}</p>', 'success', 3000);");
	    }
	}

    private function isValidLaudoOIT($post){

        $data = $post['exame_oit'];

        if ($data['simbolos_od'] == 'S' && !$data['comentarios_laudo']){
            die("Common.userNotify.show('Item 4C deve ser preenchido!', 'error', 8000, null);");
            return false;
        }

        return true;
    }

    private function buscaProximoExame($id){

        if (UserSession::isMedico() && UserSession::user()['despacho'] == 1) {

			$exame = $this->pacientes_exames_model->getExameParaMedicoLaudar();

            if ($exame !== null) {

                die(
					"Common.userNotify.show('<p>Os dados do Exame foram atualizados</p>', 'success', 3000, null, function(){ window.location = '" . site_url("exames/laudo/" . $exame['id']) . "'});"
				);
				
            }

        }

        die("Common.userNotify.show('<p>Os dados do Exame foram atualizados</p>', 'success', 3000, null, function(){ window.location = '" . site_url( "exames/single/" . $id ) . "'});");

    }

	private function isValidLaudoECG($post){
		$laudo_ecg = $post['laudo_ecg'];
		$ritmo_ok = false;
		foreach($laudo_ecg as $key => $doenca)
			if (strpos(strtoupper($doenca), "RITMO") !== FALSE ) { $ritmo_ok = true; break; }
		
		if (!$post['frequencia_ecg']){
			die("Common.userNotify.show('FREQUENCIA deve ser preenchida!', 'error', 3000, null);");
			return false;
		}
		if (!$ritmo_ok)	{
			die("Common.userNotify.show('RITMO deve ser preenchido!', 'error', 3000, null);");
			return false;
		}
		return true;
	}
	
	private function getCamposLaudoECG($post){
		$laudo = $post['laudo_ecg'];
		$campos = '';
		foreach($laudo as $key => $doencas)
			$campos .= substr($doencas, 0, strpos($doencas, '|')) . ';';
		return $campos;
	}
	
	private function doInsertLaudoECG($post){
		$medico = $this->usuarios_model->get(UserSession::user()['id']);
		if ($post['_exame_id'] != 1 || 
			$post['laudo_impossibilitado'] == 1 ||
			$medico['modelo_laudo_ecg'] == '0') return false;
		
		if (!$this->isValidLaudoECG($post)) return true;
		
		$id = $post['_id'];
		
        if ($post['laudo_impossibilitado']) { // Laudo IMPOSSIBILITADO!

            $exame = array();
            $exame['status'] = 2;
            $exame['laudo_date'] = date("Y-m-d H:i:s");
            $exame['opcoes_impossibilitado'] = serialize($post['laudo_opcoes_impossibilitado']);
            $exame['observacoes_medico'] = $post['observacoes_medico'];
            $exame['modelo_content'] = "";
            $this->pacientes_exames_model->update($exame, $id);

            $exame = array();
            $arquivo_laudo = $this->g_laudos->gerar_impossibilitado($id);
            $exame['arquivo_laudo'] = $arquivo_laudo;
            $this->pacientes_exames_model->update($exame, $id);

            $this->buscaProximoExame($id);

            return true;
        }
		
        $exame = array();
        $exame['laudo_ecg'] = $this->getCamposLaudoECG($post);
		$exame['frequencia_ecg'] = $post['frequencia_ecg'];
		$exame['laudo_ecg_outros'] = $post['laudo_ecg_outros'];
		$exame['status'] = 1;
        $exame['laudo_date'] = date("Y-m-d H:i:s");
        $this->pacientes_exames_model->update($exame, $id);
		
        $this->load->library('g_laudos');
        $this->g_laudos->dest_path = config_item('upload_folder').'/laudos/';
        
		$dados_ecg = $this->modelo_laudoecg_model->get_all();

		$arquivo_laudo = $this->g_laudos->gerar_laudo_ecg(
			$id, 
			$dados_ecg
		);

        $exame = array();
        $exame['arquivo_laudo'] = $arquivo_laudo;
        $this->pacientes_exames_model->update($exame, $id);
		
		$this->buscaProximoExame($id);
		
		return true;
	}
	
    private function doInsertLaudoOIT($post){

        if ($post['_exame_id'] != 9 || $post['laudo_impossibilitado'] == 1 || !$this->isValidLaudoOIT($post)) return false;

        $id = $post['_id'];

        if ($post['laudo_impossibilitado']) { // Laudo IMPOSSIBILITADO!

            $exame = array();
            $exame['status'] = 2;
            $exame['laudo_date'] = date("Y-m-d H:i:s");
            $exame['opcoes_impossibilitado'] = serialize($post['laudo_opcoes_impossibilitado']);
            $exame['observacoes_medico'] = $post['observacoes_medico'];
            $exame['modelo_content'] = "";

            $this->pacientes_exames_model->update($exame, $id);

            $exame = array();
            $arquivo_laudo = $this->g_laudos->gerar_impossibilitado($id);
            $exame['arquivo_laudo'] = $arquivo_laudo;

            $this->pacientes_exames_model->update($exame, $id);

            $this->buscaProximoExame($id);

            return true;

        }

        $data = $this->OIT_Parse_To_DB($post);

        $this->pacientes_exames_model->update($data, $id);

        $this->load->library('g_laudos');

        $this->g_laudos->dest_path = config_item('upload_folder').'/laudos/';

        $arquivo_laudo = $this->g_laudos->gerar_laudo_oit($id);

        $exame = array();
        $exame['arquivo_laudo'] = $arquivo_laudo;
        $exame['status'] = 1;
        $exame['laudo_date'] = date("Y-m-d H:i:s");

        $this->pacientes_exames_model->update($exame, $id);

        $this->buscaProximoExame($id);

        return true;

    }
	
    private function OIT_Parse_To_View($exame){
        if (!$exame) return null;

        $data = array();

        $data['rx_digital'] = $exame['rx_digital'];
        $data['negatoscopio'] = $exame['negatoscopio'];
        $data['qualidade'] = $exame['qualidade'];
        $data['comentarios_qualidade'] = $exame['comentarios_qualidade'];
        $data['normal'] = $exame['normal'];
        $data['anormalidade_parenquima'] = $exame['anormalidade_parenquima'];
        $data['primarias'] = $exame['primarias'];
        $data['secundarias'] = $exame['secundarias'];
        $data['zonas'] = $exame['zonas'];
        $data['profusao'] = $exame['profusao'];
        $data['grd_opacidade'] = $exame['grd_opacidade'];
        $data['anormalidade_pleural'] = $exame['anormalidade_pleural'];
        $data['placas_pleurais'] = $exame['placas_pleurais'];

        $data['placas_parede_local'] = $exame['placas_parede_local'];
        $data['placas_frontal_local'] = $exame['placas_frontal_local'];
        $data['placas_diafrag_local'] = $exame['placas_diafrag_local'];
        $data['placas_outros_local'] = $exame['placas_outros_local'];

        $data['placas_parede_calcif'] = $exame['placas_parede_calcif'];
        $data['placas_frontal_calcif'] = $exame['placas_frontal_calcif'];
        $data['placas_diafrag_calcif'] = $exame['placas_diafrag_calcif'];
        $data['placas_outros_calcif'] = $exame['placas_outros_calcif'];

        $data['placas_extensao_o_d'] = $exame['placas_extensao_o_d'];
        $data['placas_extensao_o_e'] = $exame['placas_extensao_o_e'];

        $data['placas_largura_d'] = $exame['placas_largura_d'];
        $data['placas_largura_e'] = $exame['placas_largura_e'];

        $data['obliteracao'] = $exame['obliteracao'];

        $data['espessamento_pleural'] = $exame['espessamento_pleural'];

        $data['espes_parede_local'] = $exame['espes_parede_local'];
        $data['espes_frontal_local'] = $exame['espes_frontal_local'];

        $data['espes_parede_calcif'] = $exame['espes_parede_calcif'];
        $data['espes_frontal_calcif'] = $exame['espes_frontal_calcif'];

        $data['espes_extensao_o_d'] = $exame['espes_extensao_o_d'];
        $data['espes_extensao_o_e'] = $exame['espes_extensao_o_e'];

        $data['espes_largura_d'] = $exame['espes_largura_d'];
        $data['espes_largura_e'] = $exame['espes_largura_e'];

        $data['outras_anormalidades'] = $exame['outras_anormalidades'];

        $data['simbolos'] = $exame['simbolos'];

        $data['comentarios_laudo'] = $exame['comentarios_laudo'];

        $data = $this->parse_OIT_Views('zonas', $data, array('d1', 'e1', 'd2' , 'e2', 'd3', 'e3'));

        $data = $this->parse_OIT_Views('placas_parede_local', $data, array('0', 'D', 'E'));
        $data = $this->parse_OIT_Views('placas_frontal_local', $data, array('0', 'D', 'E'));
        $data = $this->parse_OIT_Views('placas_diafrag_local', $data, array('0', 'D', 'E'));
        $data = $this->parse_OIT_Views('placas_outros_local', $data, array('0', 'D', 'E'));

        $data = $this->parse_OIT_Views('placas_parede_calcif', $data, array('0', 'D', 'E'));
        $data = $this->parse_OIT_Views('placas_frontal_calcif', $data, array('0', 'D', 'E'));
        $data = $this->parse_OIT_Views('placas_diafrag_calcif', $data, array('0', 'D', 'E'));
        $data = $this->parse_OIT_Views('placas_outros_calcif', $data, array('0', 'D', 'E'));

        $data = $this->parse_OIT_Views('placas_extensao_o_d', $data, array('0', 'D', '1', '2', '3'));
        $data = $this->parse_OIT_Views('placas_extensao_o_e', $data, array('0', 'E', '1', '2', '3'));

        $data = $this->parse_OIT_Views('obliteracao', $data, array('0', 'D', 'E'));

        $data = $this->parse_OIT_Views('placas_largura_d', $data, array('D', 'A', 'B', 'C'));
        $data = $this->parse_OIT_Views('placas_largura_e', $data, array('E', 'A', 'B', 'C'));

        $data = $this->parse_OIT_Views('espes_parede_local', $data, array('0', 'D', 'E'));
        $data = $this->parse_OIT_Views('espes_frontal_local', $data, array('0', 'D', 'E'));

        $data = $this->parse_OIT_Views('espes_parede_calcif', $data, array('0', 'D', 'E'));
        $data = $this->parse_OIT_Views('espes_frontal_calcif', $data, array('0', 'D', 'E'));

        $data = $this->parse_OIT_Views('espes_extensao_o_d', $data, array('0', 'D', '1', '2', '3'));
        $data = $this->parse_OIT_Views('espes_extensao_o_e', $data, array('0', 'E', '1', '2', '3'));

        $data = $this->parse_OIT_Views('espes_largura_d', $data, array('D', 'A', 'B', 'C'));
        $data = $this->parse_OIT_Views('espes_largura_e', $data, array('E', 'A', 'B', 'C'));

        $data = $this->parse_OIT_Views('simbolos', $data, array('aa','at','ax','bu','ca','cg','cn','co','cp','cv','di','ef','em','es','fr','hi','ho','id','ih','kl','me','pa','pb','pi','px','ra','rp','tb','od'));

        return $data;
    }
    private function parse_OIT_Views($field, $data, $fields){
        $pos = 0;
        foreach ($fields as $f){
            $id = $data[$f] ? $f : $field . '_' . $f;
            $val = substr($data[$field], $pos, 1); $pos++;
            $data[$id] = $val;
        }
        unset($data[$field]);
        return $data;
    }
    private function parse_OIT_Fields($field, $post, $fields){
        $ret = '';
        foreach ($fields as $f) {
            $id = $post[$f] ? $f : $field . '_' . $f;
            //if(!array_key_exists($id, $post)) {
            //    $ret .= 'N';
            //    continue;
            //}
            $ret .= ($post[$id] == 'S' ? 'S' : 'N');
            unset($post[$id]);
        }
        $post[$field] = $ret;
        return $post;
    }
    private function OIT_Parse_To_DB($post){

        $data = $post['exame_oit'];

        $data = $this->parse_OIT_Fields('zonas', $data, array('d1', 'e1', 'd2' , 'e2', 'd3', 'e3'));

        $data = $this->parse_OIT_Fields('placas_parede_local', $data, array('placas_parede_local_0', 'placas_parede_local_D', 'placas_parede_local_E'));
        $data = $this->parse_OIT_Fields('placas_frontal_local', $data, array('placas_frontal_local_0', 'placas_frontal_local_D', 'placas_frontal_local_E'));
        $data = $this->parse_OIT_Fields('placas_diafrag_local', $data, array('placas_diafrag_local_0', 'placas_diafrag_local_D', 'placas_diafrag_local_E'));
        $data = $this->parse_OIT_Fields('placas_outros_local', $data, array('placas_outros_local_0', 'placas_outros_local_D', 'placas_outros_local_E'));

        $data = $this->parse_OIT_Fields('placas_parede_calcif', $data, array('placas_parede_calcif_0', 'placas_parede_calcif_D', 'placas_parede_calcif_E'));
        $data = $this->parse_OIT_Fields('placas_frontal_calcif', $data, array('placas_frontal_calcif_0', 'placas_frontal_calcif_D', 'placas_frontal_calcif_E'));
        $data = $this->parse_OIT_Fields('placas_diafrag_calcif', $data, array('placas_diafrag_calcif_0', 'placas_diafrag_calcif_D', 'placas_diafrag_calcif_E'));
        $data = $this->parse_OIT_Fields('placas_outros_calcif', $data, array('placas_outros_calcif_0', 'placas_outros_calcif_D', 'placas_outros_calcif_E'));

        $data = $this->parse_OIT_Fields('placas_extensao_o_d', $data, array('placas_extensao_o_d_0', 'placas_extensao_o_d_D', 'placas_extensao_o_d_1', 'placas_extensao_o_d_2', 'placas_extensao_o_d_3'));
        $data = $this->parse_OIT_Fields('placas_extensao_o_e', $data, array('placas_extensao_o_e_0', 'placas_extensao_o_e_E', 'placas_extensao_o_e_1', 'placas_extensao_o_e_2', 'placas_extensao_o_e_3'));

        $data = $this->parse_OIT_Fields('obliteracao', $data, array('obliteracao_0', 'obliteracao_D', 'obliteracao_E'));

        $data = $this->parse_OIT_Fields('placas_largura_d', $data, array('placas_largura_d_D', 'placas_largura_d_A', 'placas_largura_d_B', 'placas_largura_d_C'));
        $data = $this->parse_OIT_Fields('placas_largura_e', $data, array('placas_largura_e_E', 'placas_largura_e_A', 'placas_largura_e_B', 'placas_largura_e_C'));

        $data = $this->parse_OIT_Fields('espes_parede_local', $data, array('espes_parede_local_0', 'espes_parede_local_D', 'espes_parede_local_E'));
        $data = $this->parse_OIT_Fields('espes_frontal_local', $data, array('espes_frontal_local_0', 'espes_frontal_local_D', 'espes_frontal_local_E'));

        $data = $this->parse_OIT_Fields('espes_parede_calcif', $data, array('espes_parede_calcif_0', 'espes_parede_calcif_D', 'espes_parede_calcif_E'));
        $data = $this->parse_OIT_Fields('espes_frontal_calcif', $data, array('espes_frontal_calcif_0', 'espes_frontal_calcif_D', 'espes_frontal_calcif_E'));

        $data = $this->parse_OIT_Fields('espes_extensao_o_d', $data, array('0', 'D', '1', '2', '3'));
        $data = $this->parse_OIT_Fields('espes_extensao_o_e', $data, array('0', 'E', '1', '2', '3'));

        $data = $this->parse_OIT_Fields('espes_largura_d', $data, array('D', 'A', 'B', 'C'));
        $data = $this->parse_OIT_Fields('espes_largura_e', $data, array('E', 'A', 'B', 'C'));

        $data = $this->parse_OIT_Fields('simbolos', $data, array('aa','at','ax','bu','ca','cg','cn','co','cp','cv','di','ef','em','es','fr','hi','ho','id','ih','kl','me','pa','pb','pi','px','ra','rp','tb','od'));

        return $data;
    }

	private function getPaginaPDFLaudo($pagina){
		if (!$pagina) return 1;
		$pagina = intval($pagina);
		if ($pagina > 0) return $pagina;
		return 1;
	}
	
	private function getPaginaPadraoPDF($exame){
		$config = $this->clientes_exames_model->get(
			array(
				'cliente_id' => $exame['cliente_id'], 
				'exame_id' => $exame['exame_id']
			)
		);
		return $config['pagina_pdf'] ? $config['pagina_pdf'] : 1;
	}
	
	private function doInsertLaudoViaPdf($post, $files){

		if ($post['laudo_impossibilitado'] == 1) return false;
		if ($post['_exame_id'] != 10 && $post['_exame_id'] != 5) return false;
		if (!isset($files["arquivo_laudo_pdf"])) return false;
		if ($post["modelo_content"]) return false;
		
		$exame = array();
		$exame['modelo_content'] = "";	

		$this->load->library('g_laudos');
		
		$this->g_laudos->dest_path = config_item('upload_folder').'/laudos/';
		
		$config = array();
		$config ['upload_path'] = config_item('upload_folder').'laudos/';
		$config ['allowed_types'] = '*';
		$config ['max_size'] = 1024 * 500;
		$config ['encrypt_name'] = true;

		$this->load->library( 'upload', $config );

		if (!$this->upload->do_upload( "arquivo_laudo_pdf" ))
			die("Common.userNotify.show('".raw($this->upload->display_errors ())."', 'error', 8000);");

		$data = $this->upload->data();
		
		$exame = array();
		$exame['status'] = 1;
		$exame['laudo_date'] = date("Y-m-d H:i:s");
		$exame['arquivo_laudo'] = $data['file_name'];
		$exame['pagina_pdf_laudo'] = 1;
		
		$this->pacientes_exames_model->update($exame, $post['_id']);

		$this->g_laudos->gerar_laudo_via_pdf($post['_id']);
		
		$this->buscaProximoExame($post['_id']);
		
		return true;

	}
	
	private function getDadosECG($exame){
		if ($exame['exame_id'] != 1) return null;
		
		$dadosECG = $this->titulo_laudoecg_model->get_all();
		
		for($i=0;$i < count($dadosECG);$i++){
			$dadosECG[$i]["itens"] = array();
			$dadosECG[$i]["itens"] = $this->modelo_laudoecg_model->get_all(
				array("tipo" => $dadosECG[$i]["id"])
			);
		}
		
        return $dadosECG;

	}
	
    private function getModeloLaudoPadrao($exame_id){
        if (!UserSession::isMedico()) return null;
        if ($exame_id == 10) return null; // Holter
        $usuario = $this->usuarios_model->get(UserSession::user()['id']);
        $id = $usuario['laudo_padrao'];
        if ($id == '0') return null;
        return $this->modelos_laudo_model->get($id);
    }

    public function laudo($id = 0){
		
        if(UserSession::isCliente()){
            UserSession::notPermited();
        }

        if ($post = $this->input->post()) {

			$this->load->disableLayout();

            if ($post['laudo_impossibilitado']){

                $this->form_validation->set_rules('laudo_opcoes_impossibilitado[]', 'Motivo Impossibilidade', 'required');

            }else {

                $this->form_validation->set_rules('modelo_content', 'Conteúdo do Laudo', 'required');

            }

            if ($post['_exame_id'] == 9  || 
				$post['_exame_id'] == 10 || 
				$post['_exame_id'] == 5  || 
				$post['_exame_id'] == 1  || 
				$this->form_validation->run()){

				// ECG(Novo Modelo)
                if ($this->doInsertLaudoECG($post)) return;
				
                // RAIOX_OIT
                if ($this->doInsertLaudoOIT($post)) return;

				// Laudo via PDF
				if ($this->doInsertLaudoViaPdf($post, $_FILES)) return;

                $config = array();
                $config ['upload_path'] = config_item('upload_folder').'laudos/';
                $config ['allowed_types'] = '*'; //pdf|txt|doc|docx|zip|rar|wxml|WXML';
                $config ['max_size'] = 1024 * 500; // 500MB
                $config ['encrypt_name'] = true;
				
                $this->load->library( 'upload', $config );

                $arquivos_selecionados_data = array();
                if (isset($_FILES["arquivo_selecionados"])){
                    if (!$this->upload->do_upload( "arquivo_selecionados" ) && $post['laudo_impossibilitado'] != 1) {
                        die("Common.userNotify.show('".raw($this->upload->display_errors ())."', 'error', 8000);");
                    } else {
						
                        $arquivos_selecionados_data = $this->upload->data();
						
						if (self::PDF2PNG($arquivos_selecionados_data['full_path'])) {
							$this->pacientes_exames_model->update(
								array( 
									'arquivo_imagem' => '../laudos/' . 
														$arquivos_selecionados_data['raw_name'] . '.png',
									'imagem_date' => date("Y-m-d H:i:s")
								), 
								$post['_id']
							);
						}
						
                    }
                }

                $this->load->library('g_laudos');

                $this->g_laudos->dest_path = config_item('upload_folder').'/laudos/';

                $arquivos_selecionados = @$arquivos_selecionados_data['file_name'];

                $exame = array();
                $exame['arquivos_selecionados'] = $arquivos_selecionados;
                $exame['status'] = 1;
                $exame['laudo_date'] = date("Y-m-d H:i:s");
                $exame['modelo_content'] = $post['modelo_content'];
				
				$exame['pagina_pdf_laudo'] = self::getPaginaPDFLaudo($post['pagina_pdf_laudo']);
				
                if($post['laudo_impossibilitado'] == 1){
                    $exame['status'] = 2;
                    $exame['opcoes_impossibilitado'] = serialize($post['laudo_opcoes_impossibilitado']);
                    $exame['observacoes_medico'] = $post['observacoes_medico'];
                    $exame['modelo_content'] = "";
                }else{
                    $exame['opcoes_impossibilitado'] = "";
                    $exame['observacoes_medico'] = "";
                }

                if($post['_id']) {

                    $this->pacientes_exames_model->update($exame, $post['_id']);

                    if ($post['laudo_impossibilitado'] != 1) {

                        $arquivo_laudo = $this->g_laudos->gerar_laudo($post['_id']);

                    } else {

                        $arquivo_laudo = $this->g_laudos->gerar_impossibilitado($post['_id']);

                    }

                    $exame = array();

                    $exame['arquivo_laudo'] = $arquivo_laudo;

                    $this->pacientes_exames_model->update($exame, $post['_id']);

                    if (UserSession::isMedico() && UserSession::user()['despacho'] == 1) {

                        $exame = $this->pacientes_exames_model->getExameParaMedicoLaudar();

                        if ($exame !== null) {

                            die("Common.userNotify.show('<p>Os dados do Exame foram atualizados</p>', 'success', 3000, null, function(){ window.location = '" . site_url("exames/laudo/" . $exame['id']) . "'});");

                        }

                    }

                    die("Common.userNotify.show('<p>Os dados do Exame foram atualizados</p>', 'success', 3000, null, function(){ window.location = '" . site_url("exames/single/" . $post['_id']) . "'});");

                }

            }else{

                die("Common.userNotify.show('".raw($this->form_validation->error_string())."', 'error', 8000);");
            }

        }

        else {

            $exame = $this->pacientes_exames_model->get($id);

			$exame['pagina_pdf_laudo'] = self::getPaginaPadraoPDF($exame);

            $exame['opcoes_impossibilitado'] = @unserialize($exame['opcoes_impossibilitado']);

            $paciente = $this->pacientes_model->get($exame['paciente_id']);
            $paciente['idade'] = calculate_years_old($paciente['nascimento'], $exame['create_date']);

            if(!is_null($paciente['empresa_id'])){
                $empresa = $this->empresas_model->get($paciente['empresa_id']);
                $paciente['empresa'] = $empresa['nome'];
            }

            $paciente['readonly'] = true;
			
            $exame['paciente'] = $paciente;
			
            $paciente_view = $this->load->view("exames/forms/form_{$exame['exame_id']}", $exame, true, false);
            
			$exame['paciente_view'] = $paciente_view;

            $this->_dataView['modelos_laudo'] = 
				$this->modelos_laudo_model->get_all();
            
			$this->_dataView['opcoes_impossibilitado'] = 
				$this->modelos_laudo_model->get_all();
				
            $this->_dataView['exame_erros'] = $this->exame_erros_laudo_model->get_all();

            $exame['paciente'] = $paciente;

            $exame['laudo_padrao'] = $this->getModeloLaudoPadrao($exame['exame_id']);

            $exame['modelo_content'] = $exame['laudo_padrao'] == null ? '' : $exame['laudo_padrao']['content'];
                         
			$exame['dados_ecg'] = $this->getDadosECG($exame);
			
            $this->_dataView['exame'] = $exame;

            $this->_dataView['exame_oit'] = $this->OIT_Parse_To_View($exame);

            /**
             * USUARIO
             */
            $this->_dataView['usuario'] = $this->usuarios_model->get($exame['cliente_id']);

            $this->load->view ( $this->_dataView );
        }

    }

    public function laudo_novo($id = 0){

        if(UserSession::isCliente()){
			UserSession::notPermited();
		}

		if ($post = $this->input->post ()) {

            $this->load->disableLayout();

			if ($post['laudo_impossibilitado']){

				$this->form_validation->set_rules('laudo_opcoes_impossibilitado[]', 'Motivo Impossibilidade', 'required');

			} else{

			    $this->form_validation->set_rules('modelo_content', 'Conteúdo do Laudo', 'required');

			}

            if ($this->form_validation->run()){
			    
                $config = array();
				$config ['upload_path'] = config_item('upload_folder').'laudos/';
				$config ['allowed_types'] = '*'; //pdf|txt|doc|docx|zip|rar|wxml|WXML';
				$config ['max_size'] = 1024 * 500; // 500MB
				$config ['encrypt_name'] = true;
	            $this->load->library ( 'upload', $config );
				
	            $arquivos_selecionados_data = array();
				if (isset($_FILES["arquivo_selecionados"])){

					if (! $this->upload->do_upload ( "arquivo_selecionados" ) && $post['laudo_impossibilitado'] != 1) {

						die("Common.userNotify.show('".raw($this->upload->display_errors ())."', 'error', 8000);");

					} else {

                        $arquivos_selecionados_data = $this->upload->data();

					}
				}

				$this->load->library('g_laudos');

				$this->g_laudos->dest_path = config_item('upload_folder').'/laudos/';
					
				$arquivos_selecionados = @$arquivos_selecionados_data['file_name'];
				
				$exame = array();
				$exame['arquivos_selecionados'] = $arquivos_selecionados;
				$exame['status'] = 1;
				$exame['laudo_date'] = date("Y-m-d H:i:s");
				$exame['modelo_content'] = $post['modelo_content'];
				
				if($post['laudo_impossibilitado'] == 1){

					$exame['status'] = 2;
					$exame['opcoes_impossibilitado'] = serialize($post['laudo_opcoes_impossibilitado']);
					$exame['observacoes_medico'] = $post['observacoes_medico'];
					$exame['modelo_content'] = "";

				}else{

					$exame['opcoes_impossibilitado'] = "";
					$exame['observacoes_medico'] = "";

				}
				
				if($post['_id']){

					$this->pacientes_exames_model->update($exame, $post['_id']);
					
					if($post['laudo_impossibilitado'] != 1){

					    $arquivo_laudo = $this->g_laudos->gerar_laudgerar_laudo($post['_id']);

					}else{

					    $arquivo_laudo = $this->g_laudos->gerar_impossibilitado($post['_id']);

					}
					
					$exame = array();
					$exame['arquivo_laudo'] = $arquivo_laudo;
					
					$this->pacientes_exames_model->update($exame, $post['_id']);

                    $exame  = $this->pacientes_exames_model->get($post['_id']);
                    $medico = $this->usuarios_model->get($exame['medico_id']);

                    if ($medico['assina_digital'] == 1){

                        echo json_encode(
                            array( "laudo" => $exame['arquivo_laudo'],
                                   "msg" => "Common.userNotify.show('<p>Os dados do Exame foram atualizados</p>', 'success', 3000, null, function(){ window.location = '" . site_url("exames/single/" . $post['_id']) . "'});"
                            )
                        );

                    } else {

                        echo json_encode(
                            array(
                                "msg" => "Common.userNotify.show('<p>Os dados do Exame foram atualizados</p>', 'success', 3000, null, function(){ window.location = '" . site_url("exames/single/" . $post['_id']) . "'});"
                            )
                            //die("Common.userNotify.show('<p>Os dados do Exame foram atualizados</p>', 'success', 3000, null, function(){ window.location = '" . site_url("exames/single/" . $post['_id']) . "'});");
                        );

                    }

				}
			
			}else{

			    echo json_encode(
				    array(
				        "msg" => "Common.userNotify.show('".raw($this->form_validation->error_string())."', 'error', 8000);"
                    )
                );

			}

		}

		else {

			$exame = $this->pacientes_exames_model->get($id);
			$exame['opcoes_impossibilitado'] = @unserialize($exame['opcoes_impossibilitado']);
			
			$paciente = $this->pacientes_model->get($exame['paciente_id']);
			$paciente['idade'] = calculate_years_old($paciente['nascimento'], $exame['create_date']);
			
			if(!is_null($paciente['empresa_id'])){
				$empresa = $this->empresas_model->get($paciente['empresa_id']);
				$paciente['empresa'] = $empresa['nome'];
			}
			
			$paciente['readonly'] = true;
			$exame['paciente'] = $paciente;
			$paciente_view = $this->load->view("exames/forms/form_{$exame['exame_id']}", $exame, true, false);
			$exame['paciente_view'] = $paciente_view;
			
			$this->_dataView['modelos_laudo'] = $this->modelos_laudo_model->get_all();
			$this->_dataView['opcoes_impossibilitado'] = $this->modelos_laudo_model->get_all();
			$this->_dataView['exame_erros'] = $this->exame_erros_laudo_model->get_all();
			
			$exame['paciente'] = $paciente;

			$this->_dataView['exame'] = $exame;

            /**
             * USUARIO
             */
            $this->_dataView['usuario'] = $this->usuarios_model->get($exame['cliente_id']);

            $this->load->view ( $this->_dataView );
		}
		
	}

	public function upload(){

        $this->load->disableLayout();

        $key = $_SERVER['QUERY_STRING'] ? str_replace("key=", "", $_SERVER['QUERY_STRING']) : null;

		if ($_SERVER['REQUEST_METHOD'] !== 'POST' || $key == null){
            return;
        }

        $config ['upload_path'] = config_item('upload_folder').'exames/lotes';
        $config ['allowed_types'] = '*'; 
		$config ['max_size'] = 1024 * 500; // 500MB
        $config ['encrypt_name'] = true;

        $this->load->library( 'upload', $config );

        if (!$this->upload->do_upload("file")) {
			
            die("Common.userNotify.show('".raw($this->upload->display_errors ())."', 'error', 8000);");
        
		} else {

		
            $data = $this->upload->data();


            $f = strtolower($data['file_name']);
            if (preg_match('/(\.zip)/', $f ) == 1){


				$this->insertZIP2($data, $key);
				
                return;
            }

            $this->doInsert($data['full_path'], $data['file_name'], $key);

        }
    }

	public function doLoteUpload($file){

		$config ['upload_path'] = config_item('upload_folder').'exames/lotes';
        $config ['allowed_types'] = '*';
        $config ['max_size'] = 1024 * 500; // 500MB
        $config ['encrypt_name'] = true;

        if (!class_exists('upload')) $this->load->library( 'upload', $config );

        if (!$this->upload->do_upload($file)) {
			
			log_message('error', "Common.userNotify.show('" . raw($this->upload->display_errors()));
			return null;
			
		} else {
			
			$data = $this->upload->data();
			return $data;
			
		}
	}
	
	private function doZipFiles($file_upload_list){
		
		//log_message('debug', ' ************** doZipFiles *****************');
		//log_message('debug', print_r($file_upload_list, true));
		//log_message('debug', ' ************** doZipFiles *****************');
		
		$path = $file_upload_list[0]['file_path'];
		$raw_name = $file_upload_list[0]['raw_name'];

		$data = array(
			'file_path' => $path, 
			'full_path' => $path . $raw_name . '.zip', 
			'raw_name' => $raw_name
		);
		
		$zip_name = $path . $raw_name . '.zip';

		$zip = new ZipArchive();
		if ($zip->open($zip_name,  ZipArchive::CREATE) == true) {
			
			for ($i = 0; $i < count($file_upload_list); $i++){
				$zip->addFile($path . $file_upload_list[$i]['file_name'], $file_upload_list[$i]['client_name'] );
			}
			
			$zip->close();
			
			for ($i = 0; $i < count($file_upload_list); $i++) {
				$fn = $path . $file_upload_list[$i]['file_name'];
				unlink($fn);
			}
			
			return $data;
		}
		
		return null;
		
	}
	
	public function lotes() {

        if(UserSession::isMedico()){

            UserSession::notPermited();

        }

        if (!($_SERVER['REQUEST_METHOD'] == 'POST')){

            $this->load->view( $this->_dataView );

            return;
        }

        //log_message('debug', print_r($_FILES, true));
		//return;
		
		$file_upload_list = array();
		
		for ($i = 0; $i < count($_FILES); $i++){
			
			$data = $this->doLoteUpload('file' . $i);

			//log_message('debug', print_r($data, true));
            //log_message('debug', '=======================================');
			//continue;
			
			if ($data == null) continue;
			
            /**
             * INSERE IMAGENS DOS EXAMES
             */
            $orig_name = strtolower($data['orig_name']);
            if (preg_match('/dama_imagens.zip/', $orig_name ) == 1 && !UserSession::isCliente()) {
				$this->insertIMAGENS($data);
                continue;
            }
			
            /**
             * INSERE PACIENTES
             */
            if (preg_match('/pacientes.dama/', $orig_name ) == 1 && UserSession::isCliente()) {
				$this->insertPACIENTES($data);
                continue;
            }

			
			if (preg_match('/(\.zip)/', strtolower($data['file_name'])) == 1){
                $this->insertZIP2($data);
                continue;
            }
			
			array_push($file_upload_list, 
				array( 
					'client_name' => $data['client_name'], 
					'file_path' => $data['file_path'],
					'file_name' => $data['file_name'],
					'raw_name' => $data['raw_name']
				)
			);
			
		}
		
		if (count($file_upload_list) > 0) {
			$data = $this->doZipFiles($file_upload_list);
			if ($data == null) return;
			$this->insertZIP2($data);
		}
		
		//log_message('debug', print_r($data, true));
		
    }
	 
	 
    /*
     * ############################# LOTES - INICIO ##################################
     */
	public function lotes2(){

        if(UserSession::isMedico()){

            UserSession::notPermited();

        }

        if (!($_SERVER['REQUEST_METHOD'] == 'POST')){

            $this->load->view( $this->_dataView );

            return;
        }

        $config ['upload_path'] = config_item('upload_folder').'exames/lotes';
        $config ['allowed_types'] = '*';
        $config ['max_size'] = 1024 * 500; // 100MB
        $config ['encrypt_name'] = true;

        $this->load->library( 'upload', $config );

        if (!$this->upload->do_upload("file")) {

            die("Common.userNotify.show('".raw($this->upload->display_errors ())."', 'error', 8000);");

        } else {

            $data = $this->upload->data();

            log_message('debug', "$data: " . print_R($data, TRUE));

            $f = strtolower($data['file_name']);

            /**
             * INSERE IMAGENS DOS EXAMES
             */
            $orig_name = strtolower($data['orig_name']);
			log_message('debug', '==========> INSERTIMAGENS 1');
            if (preg_match('/dama_imagens.zip/', $orig_name ) == 1 && !UserSession::isCliente()) {
			log_message('debug', '==========> INSERTIMAGENS 2');
                $this->insertIMAGENS($data);
                return;
            }

            if (preg_match('/(\.zip)/', $f ) == 1){
                $this->insertZIP2($data);
                return;
            }

            $this->doInsert($data['full_path'], $data['file_name'], null, null);

        }

    }

    private function getObject(){
        return (object)array(
            'Tipo' => null,
            'Motivo' => null,
            'Data' => null,
            'Empresa' => null,
            'Paciente' => null,
            'DataNasc' => null,
            'Idade' => null,
            'Sexo' => null,
            'Altura' => null,
            'Peso' => null,
            'IMC' => null,
            'Medico' => null,
            'Observacao' => null,
            'RG' => null,
            'CPF' => null,
            'DamaDesktopKey' => null,
            'Imagem' => null,
			'SubTipo' => null,
			'Clinica_id' => null,
			'Funcao' => null			
        );
    }

    function utf8_fopen_read($fileName) {
        $fc = iconv('windows-1250', 'utf-8', file_get_contents($fileName));
        $handle=fopen("php://memory", "rb");
        fwrite($handle, $fc);
        fseek($handle, 0);
        return $handle;
    }

    private function getBytes($file){
        if (!file_exists($file)) return null;
        $handle = fopen($file, "rb");
        //$handle = $this->utf8_fopen_read($file); //fopen($file, "rb");
        //$handle = utf8_fopen_read($file, "rb");
        $data = fread($handle, filesize($file));
        fclose($handle);
        return $data;
    }

    private function getString($bytes, $start = 0, $stop = null){
        if ($bytes == null) return '';
        $str = '';
        for($i = $start; $i < strlen($bytes); $i++) {
            $char = $bytes[$i];
            if ($stop == null) {
                if (ord($char) == null) return $str;
            } else if ($i > $stop) return $str;

            $str .= $this->parse_char($char); // Normalizer::normalize( $char, Normalizer::FORM_C ); //$this->letters->noDiacritics($char);

        }
        return $str;
    }

    private function parse_char($char){
        if (ord($char) == null) return '';
        return html_entity_decode('&#' . ord($char) . ';');
        //return $this->letters->noDiacritics(html_entity_decode('&#' . ord($char) . ';'));
    }

    private function getAno($ano) {
        $hoje = intval((new DateTime())->format('Y'));
        return ( intval('20' . $ano ) > $hoje ? '19' . $ano : '20' . $ano);
    }

    private function toDate($v = null){

        if ($v == null) {
            $datetime = new DateTime();
            return $datetime->format('d/m/Y');
        }
        $v = preg_replace('/[^0-9]/', '', $v);
        if (empty($v)) return  '';
        
        $date = strlen($v) == 8 ?
            substr($v, 0, 2) . '/' .  substr($v, 2, 2) . '/' . substr($v, 4) :
            substr($v, 0, 2) . '/' .  substr($v, 2, 2) . '/' . $this->getAno(substr($v, 4, 2));

        return $date;
    }

    private function toMMDDAAAA($date){
        $dd = substr($date, 0, 2);
        $mm = substr($date, 3, 2);
        $aa = substr($date, 6, 4);
        return $mm . '/' . $dd . '/' . $aa;
    }

    private function getIdade($dt_nasc){
        $datetime1 = strtotime($this->toMMDDAAAA($dt_nasc));
        $datetime2 = strtotime($this->toMMDDAAAA($this->toDate()));
        $secs = $datetime2 - $datetime1; // == <seconds between the two times>
        return  intval($secs / 86400 / 360);
    }

	private function getIdadeDDMMAAAA($dt_nasc){
		$dt_nasc = str_replace('/', '-', $dt_nasc);
		$dt_nasc = date('Y-m-d', strtotime($dt_nasc));
		$today = date('Y-m-d', time());
        return  $today - $dt_nasc;
    }

    private function getNasc($data, $idade){
        $ano = (int)substr($data, strlen($data) - 4, 4);
        $ano = $ano - (int)$idade;
        return substr($data, 0, strlen($data) - 4) . $ano;
    }

    private function getIMC($peso, $altura){
        if (!$peso && !$altura) return 0;

        try {

            $peso = (float)$peso; $altura = (float)$altura;
            $altura = $altura > 100 ? $altura / 100 : $altura;
            $imc = round($peso / ($altura * $altura), 2);
            return $imc;

        } catch (Exception $e){

            return 0;
        }

        return 0;
    }

    private function getAltura($v){
        $v = preg_replace('/[^0-9]/', '', $v);
        $v = (int)$v;
        return $v > 100 ? $v / 100 : $v;
    }

    private function toDateAAAAMMDD($date){
        $aa = substr($date, 0, 4);
        $mm = substr($date, 4, 2);
        $dd = substr($date, 6, 2);
        return $this->toDate($dd . $mm . $aa);
    }

    private function toDateDDMMAAAA($dd, $mm, $aa){
        $dd = $dd < 10 ? '0' . $dd : $dd;
        $mm = $mm < 10 ? '0' . $mm : $mm;
        return $this->toDate($dd . $mm . $aa);
    }

    private function toDateDDMMAA($date){
        $dd = substr($date, 0, 2);
        $mm = substr($date, 2, 2);
        $aa = '20' . substr($date, 4, 2);
        return $this->toDate($dd . $mm . $aa);
    }

    private function doInsert($full_path, $file_name, $dama_desktop_key, $params){

        $f = strtolower($full_path);

		if (preg_match('/(\.dcm|\.oit)/', $f) == 1){
            $this->insertDCM($full_path, $file_name, $dama_desktop_key, $params);
            return true;
        }
		
        if (preg_match('/(\.wxml)/', $f) == 1){
            $this->insertWXML($full_path, $file_name, $dama_desktop_key, $params);
            return true;
        }
        if (preg_match('/(\.xml)/', $f) == 1){
            $this->insertXML($full_path, $file_name, $dama_desktop_key, $params);
            return true;
        }
        if (preg_match('/(\.datest)/', $f) == 1){
            $this->insertDATEST($full_path, $file_name, $dama_desktop_key, $params);
            return true;
        }
        if (preg_match('/(\.mdt)/', $f) == 1){
            $this->insertMDT($full_path, $file_name, $dama_desktop_key, $params);
            return true;
        }
        if (preg_match('/(\.dte)/', $f) == 1){
            $this->insertDTE($full_path, $file_name, $dama_desktop_key, $params);
            return true;
        }
        if (preg_match('/(\.dat)/', $f) == 1){
            $this->insertDAT($full_path, $file_name, $dama_desktop_key, $params);
            return true;
        }
        if (preg_match('/(\.plg)/', $f) == 1){
            $this->insertPLG($full_path, $file_name, $dama_desktop_key, $params);
            return true;
        }
		
        if (preg_match('/(\.tep)/', $f) == 1){
            $this->insertTEP($full_path, $file_name, $dama_desktop_key, $params);
            return true;
        }
        if (preg_match('/(\.eeg)/', $f) == 1){
            $this->insertEEG($full_path, $file_name, $dama_desktop_key, $params);
            return true;
        }
        if (preg_match('/(\.pdf)/', $f) == 1){
            $this->insertPDF($full_path, $file_name, $dama_desktop_key, $params);
            return true;
        }
        if (preg_match('/(\.txt)/', $f) == 1){
            $this->insertTXT($full_path, $file_name, $dama_desktop_key, $params);
            return true;
        }

        return false;

    }

    private function addFileInList($files_in_zip, $name){

        $len = strpos($name, '/');
        if ($len === false) $len = strlen($name) - strlen(strrchr($name, '.'));
        $fname = substr($name, 0, $len);
		
		if (preg_match('/(\.dcm|\.oit)/', strtolower($name)) == 1) return $files_in_zip; // Exclui DCMs e OITs
			
        for ($i = 0; $i < count($files_in_zip); $i++)
            if ($files_in_zip[$i]['name'] == $fname){
                array_push($files_in_zip[$i]['files'], $name);
                return $files_in_zip;
            }

        $files_in_zip[] = array('name' => $fname, 'target' => null, 'raw_name' => crc32($fname), 'files' => array($name));

        return $files_in_zip;
		
    }

    private function isOneFile($name){
        $name = strtolower($name);
        if (preg_match('/(\.eeg)/',  $name) == 1) return true;
        if (preg_match('/(\.wxml)/', $name) == 1) return true;
        if (preg_match('/(\.mdt)/',  $name) == 1) return true;
        if (preg_match('/(\.dcm)/',  $name) == 1) return true;
        if (preg_match('/(\.oit)/',  $name) == 1) return true;
        if (preg_match('/(\.pdf)/',  $name) == 1) return true;
        return false;
    }

    private function isTarget($name){
        return preg_match(self::$TARGET, $name) == 1;
    }

    private function isHighPriority($name){
        return preg_match(self::$HIGH_PRIORITY, $name) == 1;
    }

    private function getFileTarget($files){
        $target = null;
        for ($i = 0; $i < count($files); $i++) {
            if ($this->isTarget($files[$i])) $target = $files[$i];
            if ($this->isHighPriority($target)) return $target;
        }
        return $target;
    }

    private function setFileTarget($files){
        for ($i = 0; $i < count($files); $i++) {
            $files[$i]['target'] = $this->getFileTarget($files[$i]['files']);
        }
        return $files;
    }

    // setImagemTarget() #################################################################

    private function getImagemTarget($files){
        for ($i = 0; $i < count($files); $i++) {
            $str = strtolower($files[$i]);
            $pos = strpos($str, ".jpg");
            if ($pos === false) {
                $pos = strpos($str, ".bmp");
                if ($pos === false) continue;
            }
            return $files[$i];
        }
        return null;
    }

    private function setImagemTarget($files){
        for ($i = 0; $i < count($files); $i++) {
            $files[$i]['image'] = $this->getImagemTarget($files[$i]['files']);
        }
        return $files;
    }

    // #################################################################

    private function doTest(){
		  
		  //$t["itens"]$this->modelo_laudoecg_model->get_all(
		  //	array("tipo" => $t["id"])
		  //);
        //log_message('debug', ':::::::>>>>>' . print_r($titulosLaudoECG, true));
		//log_message('debug', ':::::::>>>>>' . print_r($itensLaudoECG, true));
		return;
		
		
        log_message('debug', ' >>>>>>> TESTES UNITÁRIOS >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>');

		PHPUnit::assertTrue('1 ano', calculate_years_old('2017-06-06'));        
		PHPUnit::assertTrue('49 anos', calculate_years_old('1969-03-11'));        

		PHPUnit::assertTrue('1 mes', calculate_years_old('2018-05-06'));        
		PHPUnit::assertTrue('2 meses', calculate_years_old('2018-04-06'));

		PHPUnit::assertTrue('1 dia', calculate_years_old('2018-06-05'));
		PHPUnit::assertTrue('2 dias', calculate_years_old('2018-06-04'));

        log_message('debug', '<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<');
		return;
		
		PHPUnit::assertTrue('cdef', $this->getArquivoId('a/b/cdef.wxml'), '1');
        PHPUnit::assertTrue('cdef', $this->getArquivoId('b/cdef.WXML'), '2');
        PHPUnit::assertTrue('cdef', $this->getArquivoId('/cdef.wxml'), '3');
        PHPUnit::assertTrue('cdef', $this->getArquivoId('cdef.WXML'), '4');

        $files = array(

            ['name' => '0', 'files' => array('*.xml', '*.1', '*.2'), 'res' => '*.xml'],
            ['name' => '1', 'files' => array('*.1',   '*.xml', '*.2'), 'res' => '*.xml'],
            ['name' => '2', 'files' => array('*.1',   '*.2', '*.xml'), 'res' => '*.xml'],

            ['name' => '3', 'files' => array('*.xml', '*.xml.1', '*.2'), 'res' => '*.xml'],

            ['name' => '4', 'files' => array('*.1', '*.2', '*.wxml'), 'res' => '*.wxml'],

            ['name' => '5', 'files' => array('*.1', '*.datest', '*.2'), 'res' => '*.datest'],
            ['name' => '6', 'files' => array('*.1', '*.2', '*.dte'), 'res' => '*.dte'],
            ['name' => '7', 'files' => array('*.dat', '*.1', '*.2'), 'res' => '*.dat'],
            ['name' => '8', 'files' => array('*.plg', '*.1', '*.2'), 'res' => '*.plg'],
            ['name' => '9', 'files' => array('*.tep', '*.1', '*.2'), 'res' => '*.tep'],
            ['name' => '10', 'files' => array('*.1', '*.eeg', '*.2'), 'res' => '*.eeg'],
            ['name' => '11', 'files' => array('*.1', '*.2', '*.pdf'), 'res' => '*.pdf'],
            ['name' => '12', 'files' => array('*.1', '*.2', '*.txt'), 'res' => '*.txt'],

            ['name' => '13', 'files' => array('*.xml', '*.txt', '*.3'), 'res' => '*.xml'],
            ['name' => '14', 'files' => array('*.txt', '*.1', '*.xml'), 'res' => '*.xml'],
            ['name' => '15', 'files' => array('*.eeg', '*.datest', '*.1'), 'res' => '*.datest'],
            ['name' => '16', 'files' => array('*.eeg', '*.dte', '*.1'), 'res' => '*.dte'],

            ['name' => '16', 'files' => array('*.1', '*.2', '*.3'), 'res' => null]

        );

        $files = $this->setFileTarget($files);

        log_message('debug', print_r($files, true));

        for ($i = 0; $i < count($files); $i++)
            PHPUnit::assertTrue($files[$i]['target'], $files[$i]['res'], $files[$i]['name']);

    }

    private function getArquivoId($name){
        if ($name == null) return null;
        $str = strtolower($name);
        $fim = strpos($str, ".jpg");
        if ($fim === false) $fim = strpos($str, ".wxml");
        if ($fim === false) $fim = strpos($str, ".dcm");
        if ($fim === false) $fim = strpos($str, ".zip");
        if ($fim === false) return null;
        $inicio = strrpos($str, "/");
        if ($inicio === false) $inicio = 0;
        else $inicio++;
        return substr($str, $inicio, $fim - $inicio);
    }

    private function insertIMAGEM($path, $name){
        $arquivo_id = $this->getArquivoId($name);
        $exame = $this->pacientes_exames_model->get(array('pe.arquivo_id' => $arquivo_id));
        if(count($exame) == 0){
            return;
        }
        $this->pacientes_exames_model->update(
            array(
				'arquivo_imagem' => 'lotes/imagens/' . $name,
				'imagem_date' => date("Y-m-d H:i:s")
			),
            $exame['id']);
    }

    private function insertIMAGENS($data){
        $path = $data['file_path'] . 'imagens/';
        if (!is_dir($path)){
            mkdir($path, 0777);
        }
        $zip  = new ZipArchive();
        if ($zip->open($data['full_path']) == TRUE) {
            for ($i = 0; $i < $zip->numFiles; $i++) {
                $name = $zip->getNameIndex($i);
                if (preg_match('/(\.jpg|\.JPG)/', $name) !== 1) continue;
                $zip->extractTo($path, $name);
                $this->insertIMAGEM($path, $name);
            }
        }
    }

    private function insertPACIENTES($data){
		$file = fopen($data['full_path'], "r");
        while(!feof($file)) {
		  $this->insertPACIENTE(fgets($file));
		}
	}

	private function PACIENTEInserted($data){
        if (!$data[0] || (!$data[2] && !$data[3])) return true;
		if ($data[2]) {
			$paciente = $this->pacientes_model->get(array('rg' => $data[2]));
			if ($paciente) return true;
		}
		if ($data[3]) {
			$paciente = $this->pacientes_model->get(array('cpf' => $data[3]));
			if ($paciente) return true;
		}
        return false;
	}
	
	private function insertPACIENTE($data){
		$parts = explode('|', $data);
        if (count($parts) < 7) return;

        if ($this->PACIENTEInserted($parts)) return;

        $paciente = array();
        
		$paciente['nome'] = $this->remove_accents($parts[0]);
        $paciente['rg']  = preg_replace( '/[^A-Za-z0-9]/', '', $parts[2]);
        $paciente['cpf'] = preg_replace( '/[^0-9]/', '', $parts[3]);
        if ($parts[4]){
			$nasc = str_replace('/', '-', $parts[4] );
			$nasc = date("Y-m-d", strtotime($nasc));
			$paciente['nascimento'] = $nasc;
		}
		
        $paciente["sexo"] = $parts[5];
		$paciente['funcao'] = $this->remove_accents($parts[6]);
		$paciente['telefone'] = '-';
		$paciente['cliente_id'] = UserSession::user("id");
		
		$empresa = array('nome' => $parts[1]);
		$empresa_id = $this->empresas_model->insert($empresa);
        $paciente['empresa_id'] = $empresa_id;

        $paciente_id = $this->pacientes_model->insert($paciente);
		
	}
	
	private function isFilesGroupIsValid($files){
		$target = strtolower($files['target']);
		if (preg_match('/(\.xml|\.txt)/', $target) == 1) {
			$ex0 = false; $fas = false;
			for ($i = 0; $i < count($files['files']); $i++) {
				$name = strtolower($files['files'][$i]);
				if (preg_match('/(\.ex0)/', $name) == 1) $ex0 = true;
				if (preg_match('/(\.fas)/', $name) == 1) $fas = true;
			}
			return ($ex0 && $fas);
		}
		return true; 
	}

	function ordutf8($string, &$offset) {
		$code = ord(substr($string, $offset,1)); 
		if ($code >= 128) {        //otherwise 0xxxxxxx
			if ($code < 224) $bytesnumber = 2;                //110xxxxx
			else if ($code < 240) $bytesnumber = 3;        //1110xxxx
			else if ($code < 248) $bytesnumber = 4;    //11110xxx
			$codetemp = $code - 192 - ($bytesnumber > 2 ? 32 : 0) - ($bytesnumber > 3 ? 16 : 0);
			for ($i = 2; $i <= $bytesnumber; $i++) {
				$offset ++;
				$code2 = ord(substr($string, $offset, 1)) - 128;        //10xxxxxx
				$codetemp = $codetemp*64 + $code2;
			}
			$code = $codetemp;
		}
		$offset += 1;
		if ($offset >= strlen($string)) $offset = -1;
		return $code;
	}
	
	function stripAccents($str) {
		$str = strtr(utf8_decode($str), utf8_decode('àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ'), 'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');
		$str = str_replace('?', '_', $str);
		return $str;
	}
	
	function renamePdf($name, $raw_name){
		$n = strtolower($name);
		$pos = strpos($n, '.pdf');
		if ($pos === false) return $name;
		return $raw_name . substr($name, $pos);
	}
	
	private function normalizeFileNames($data) {
		$zipName = $data['full_path'];
		$raw_name = $data['raw_name'];
		$zip  = new ZipArchive();
		if ($zip->open($zipName) == TRUE) {
            for ($i = 0; $i < $zip->numFiles; $i++) {
				$zip->renameIndex($i,
					$this->renamePdf(
						$this->stripAccents($zip->getNameIndex($i)),
						$raw_name . '_' . $i
					)
				);
			}
			
			$zip->close();
			
		}
	}
	
    private function insertZIP2($data, $dama_desktop_key = null){

        $files_in_zip = array();

        $USER_ID = $this->getClienteDoExame((object)array('DamaDesktopKey' => $dama_desktop_key));
		
		//log_message('debug', '>>>>>>>>> $USER_ID: ' . $USER_ID . ' KEY: ' . $dama_desktop_key);
		//return;
		
        $path = $data['file_path'] . $USER_ID . '/';
        $path_images = $path . 'imagens/';
        $path_dcm = $data['file_path'] . 'dcm/';

        $params = array( 
			'imagem' => null
		);

        if (!is_dir($path)){
            mkdir($path, 0777);
        }

        if (!is_dir($path_images)){
            mkdir($path_images, 0777);
        }

        if (!is_dir($path_dcm)){
            mkdir($path_dcm, 0777);
        }

		self::normalizeFileNames($data);
		
        $zip  = new ZipArchive();
        $zip2 = new ZipArchive();

        if ($zip->open($data['full_path']) == TRUE) {

            for ($i = 0; $i < $zip->numFiles; $i++) {
                $name = $zip->getNameIndex($i);
                $files_in_zip = $this->addFileInList($files_in_zip, $name);
            }

            $files_in_zip = $this->setFileTarget($files_in_zip);
            $files_in_zip = $this->setImagemTarget($files_in_zip);

            //log_message('debug', '>>>>>>>>>>>>>>>>>>>>> $files_in_zip');
            //log_message('debug', print_r($files_in_zip, true));
            //log_message('debug', '>>>>>>>>>>>>>>>>>>>>> $files_in_zip');
			//return;

            for ($i = 0; $i < count($files_in_zip); $i++){

		        $params = array( 'imagem' => null );

                $zip->extractTo($path, $files_in_zip[$i]['files']);

                if ($files_in_zip[$i]['image']){
					$image_file_name = str_replace(' ', '_', $files_in_zip[$i]['image']);
                    //$params['imagem'] = 'lotes/' . $USER_ID . '/imagens/' . $files_in_zip[$i]['image'];
                    $params['imagem'] = 'lotes/' . $USER_ID . '/imagens/' . $image_file_name;
                    $zip->extractTo($path_images, $files_in_zip[$i]['image']);
					rename(
						$path_images . $files_in_zip[$i]['image'],
						$path_images . $image_file_name
					);
                }

                $files_in_zip = $this->renameFile($files_in_zip, $path, $i, $data['raw_name']);
				
				//$params['DCM_OIT'] = $files_in_zip[$i]['DCM_OIT'] == true;
                //log_message('debug', print_r($files_in_zip, true));
                //continue; //continue; // <<< REMOVER
				
				if (!$this->isFilesGroupIsValid($files_in_zip[$i])) continue;

                if (count($files_in_zip[$i]['files']) == 1) {
                    if (!$this->isOneFile($files_in_zip[$i]['files'][0])) continue;
                    $fn = $path . $files_in_zip[$i]['files'][0];
                    $this->doInsert($fn, $USER_ID . '/' . $files_in_zip[$i]['files'][0], $dama_desktop_key, $params);
                    continue;
                }

                $raw_name = $data['raw_name'] . '_' . $files_in_zip[$i]['raw_name'] . '.zip';

                $zip_name = $path . $raw_name;

                if ($zip2->open($zip_name,  ZipArchive::CREATE) == true) {

                    //$this->doInsert($path . $files_in_zip[$i]['target'], UserSession::user("id") . '/' . $raw_name, $dama_desktop_key);
                    $this->doInsert($path . $files_in_zip[$i]['target'], $USER_ID . '/' . $raw_name, $dama_desktop_key, $params);

                    //$exame_inserido = false;
                    for ($f = 0; $f < count($files_in_zip[$i]['files']); $f++) {
                        $fn = $path . $files_in_zip[$i]['files'][$f];
                        $zip2->addFile($fn, $files_in_zip[$i]['files'][$f]);
                        //$exame_inserido = !$exame_inserido ? $this->doInsert($fn, UserSession::user("id") . '/' . $raw_name) : TRUE;
                    }

                    $zip2->close();

                    // REMOVENDO ARQUIVOS DA PASTA
                    for ($f = 0; $f < count($files_in_zip[$i]['files']); $f++) {
                        $fn = $path . $files_in_zip[$i]['files'][$f];
                        unlink($fn);
                    }

                }

            }

            // REMOVENDO PASTAS
            for ($f = 0; $f < count($files_in_zip); $f++) {
                $fn = $path . $files_in_zip[$f]['name'];
                $this->delDir($fn);
            }
			
            //log_message('debug', '$files_in_zip: ' . print_r($files_in_zip, true));
            //return; // <<< REMOVER

			// ############# DICOMs(DCMs e OITs) #############
			$dcm_files = array();
            for ($i = 0; $i < $zip->numFiles; $i++) {
				$name = $zip->getNameIndex($i);
                $dcm_files = $this->addDCMFileInList($dcm_files, $zip, $name, $path_dcm);
            }
			
			//log_message('debug', '>>>>>>>>>>>>>> DCM_FILES' . print_r($dcm_files, true));
			//return;
			
			foreach ($dcm_files as $key => $obj) {

				$clinica_id = $this->getClinicaIdDoDCM($obj, $dama_desktop_key);
				
				if (!$clinica_id) continue;
				
				if ($this->createDCMZip($obj, $path_dcm)){
					
					$dcm_count = count($obj['files']);
					
					$observacao = '';
					foreach($obj['exames'] as $e){
						$observacao .= trim($e) . ' + ';
					}
					
                    $observacao = $obj['subtipo'] . ' - ' . $observacao;

					$params = array(
						'OIT' => $obj['OIT'], 
						'imagem' => 'lotes/dcm/' . $obj['zip_name'] . '{{' . $dcm_count . '}}.jpg', 
						'clinica_id' => $clinica_id,
						'observacao' => substr($observacao, 0, strlen($observacao)-3),
						'subtipo' => $obj['subtipo'],
                        'medico' => $obj['medico'],
                        'empresa' => $obj['empresa']
					);
					
					$this->insertExameDCM(
						$path_dcm . $obj['files'][0],
						'dcm/' . $obj['zip_name'] . '.zip',
						$dama_desktop_key,
						$params
					);

				}
				
			}			
			
        }

        $zip->close();

    }

	private function isAdmin($usuario){
		return $usuario->tipo == 'admin' || $usuario->tipo == 'auditor';
	}
	
	private function getClinicaIdDoDCM($obj, $dama_desktop_key){
		
		$USER_ID = UserSession::user("id");

		if ($USER_ID){
			return $USER_ID;
		}

		if (strlen(trim($dama_desktop_key)) > 0){
			$clinica = $this->usuarios_model->get_clinica_by_key($dama_desktop_key);
			if ($clinica && !$this->isAdmin($clinica)) {
				return $clinica->id;
			}
		}
		
		$cnpj = $obj['cliente'];
		if ($cnpj){
			$clinica = $this->usuarios_model->get_clinica_by_cnpj($cnpj);
			if ($clinica) {
				return $clinica->id;
			}
		}

		$institutionName = $obj['cliente'];
		if ($institutionName){
			$clinica = $this->usuarios_model->get_clinica_by_institution_name($institutionName);
			if ($clinica) {
				return $clinica->id;
			}
		}
		
		return null;
		
	}
	
    private function insertExameDCM_ECG($file, $file_name, $dama_desktop_key, $params){
		
		log_message('debug', 'insertExameDCM() - ECG >>> ' . $file);

		$dicom = $this->dicom->getInstance($file);
	
        $dicom->parse(array('PatientName'));        // 0x0010,0x0010
		$dicom->parse(array('AcquisitionDate'));	// 0x0008,0x0022
		$dicom->parse(array('PatientID'));			// 0x0010,0x0020
		$dicom->parse(array('PatientBirthDate'));   // 0x0010,0x0030 
		$dicom->parse(array('PatientAge'));         // 0x0010,0x1010 
		$dicom->parse(array('PatientSex'));         // 0x0010,0x0040
		$dicom->parse(array('PatientSize'));        // 0x0010,0x1020 
		$dicom->parse(array('PatientWeight'));      // 0x0010,0x1030 
	
        $exame = $this->getObject();
        $exame->Tipo        = 'ECG';
        $exame->Data        = $this->toDateAAAAMMDD($dicom->value(0x0008, 0x0022));
        $exame->Paciente    = $dicom->value(0x0010, 0x0010);
        $exame->DataNasc    = $this->toDateAAAAMMDD($dicom->value(0x0010, 0x0030));
        $exame->Idade       = $dicom->value(0x0010,0x1010); //$this->getIdade($exame->DataNasc);
        $exame->DataNasc    = $this->getNasc($exame->Data, $exame->Idade);
        $exame->Sexo        = $dicom->value(0x0010, 0x0040);
        $exame->Altura      = $dicom->value(0x0010, 0x1020) / 100;
        $exame->Peso        = $dicom->value(0x0010, 0x1030);
        $exame->IMC         = $this->getIMC($exame->Peso, $exame->Altura);
        $exame->Empresa     = ($params && $params['empresa']) ? $params['empresa'] : null;
        $exame->Motivo      = null;
        $exame->Medico      = ($params && $params['medico']) ? $params['medico'] : null;
        $exame->Arquivo     = $file_name;
        $exame->RG          = null;
        $exame->Imagem      = ($params && $params['imagem']) ? $params['imagem'] : null;
        $exame->DamaDesktopKey = $dama_desktop_key;
		$exame->Observacao = $params['observacao'];
		
		$exame->Paciente   = trim(str_replace('^', ' ', $exame->Paciente));
		$exame->Paciente   = $this->str_remove($exame->Paciente, "[^A-Za-z0-9 \.\-]"); //$this->remove_accents($exame->Paciente);
		
		$exame->Clinica_id = $params['clinica_id'];
		
		log_message('debug', print_r($exame, true));
		
        //$this->insertExame($exame);
	
	}
	
    private function insertExameDCM($file, $file_name, $dama_desktop_key, $params){
        
		$dicom = $this->dicom->getInstance($file); 
		
        $dicom->parse(array('PatientName'));        // 0x0010,0x0010
		$dicom->parse(array('AcquisitionDate'));	// 0x0008,0x0022
		$dicom->parse(array('PatientID'));			// 0x0010,0x0020
		$dicom->parse(array('PatientBirthDate'));   // 0x0010,0x0030 
		$dicom->parse(array('PatientSex'));         // 0x0010,0x0040
		$dicom->parse(array('Modality'));           // 0x0008,0x0060
		
		$tipoExame = trim($dicom->value(0x0008,0x0060));
	
		if ($tipoExame == "EC") {
			$this->insertExameDCM_ECG($file, $file_name, $dama_desktop_key, $params);
			return;
		}
		
		log_message('debug', 'insertExameDCM() - RAIOX >>> ' . $file);
		
		$isOit = ($params && $params['OIT'] && $params['OIT'] == 'S') ? true : false;
		
        $exame = $this->getObject();

        $exame->Tipo        = $isOit ? "RAIOX_OIT" : ($this->isOIT($dicom) ? 'RAIOX_OIT' : 'RAIO');
		$exame->SubTipo     = $params['subtipo'];
        $exame->Data        = $this->toDateAAAAMMDD($dicom->value(0x0008, 0x0022));
        $exame->Paciente    = $dicom->value(0x0010, 0x0010);
        $exame->DataNasc    = $this->toDateAAAAMMDD($dicom->value(0x0010, 0x0030));
        $exame->Idade       = $this->getIdade($exame->DataNasc);
        $exame->Sexo        = $dicom->value(0x0010, 0x0040);
        $exame->Altura      = null;
        $exame->Peso        = null;
        $exame->IMC         = null;
        $exame->Empresa     = ($params && $params['empresa']) ? $params['empresa'] : null;
        $exame->Motivo      = null;
        $exame->Medico      = ($params && $params['medico']) ? $params['medico'] : null;
        $exame->Arquivo     = $file_name;
        //$exame->RG          = $dicom->value(0x0010, 0x0020);
        //Thais
        if ($dicom->value(0x0008,0x0070) == 'KONICA MINOLTA') {
        $exame->RG          = $dicom->value(0x0010, 0x0020);
        $exame->CPF          = $dicom->value(0x0010, 0x0020);
        }
        $exame->Imagem      = ($params && $params['imagem']) ? $params['imagem'] : null;
        $exame->DamaDesktopKey = $dama_desktop_key;
		$exame->Observacao = $params['observacao'];
		
		$exame->Paciente   = trim(str_replace('^', ' ', $exame->Paciente));
		$exame->Paciente   = $this->str_remove($exame->Paciente, "[^A-Za-z0-9 \.\-]");
		
		$exame->Clinica_id = $params['clinica_id'];
		
		log_message('debug', print_r($exame, true));
		
        $this->insertExame($exame);
		
	}
	
	private function createDCMZip($obj, $path_dcm){
        $zip = new ZipArchive();
		$zip_name = $path_dcm . $obj['zip_name'] . '.zip';
		if ($zip->open($zip_name, ZipArchive::CREATE) == true) {
			foreach($obj['files'] as $item){
				$zip->addFile($path_dcm . $item, $item);
			}
			$zip->close();
			//foreach($obj['files'] as $item){
			//	unlink($path_dcm . $item);
			//}
			return true;
		}
		return false; 
	}
	
	private function getDICOMTipoExame($data){
		$tipoExame = $this->str_remove($data, "[^A-Z0-9]");
		$tipoExame = str_replace("LAT", "", $tipoExame);
		$tipoExame = str_replace("FRN", "", $tipoExame);
		$tipoExame = str_replace("AP", "", $tipoExame);
		if ($tipoExame == "PA") $tipoExame = "TORAX";
		$tipoExame = str_replace("PA", "", $tipoExame);
		$tipoExame = str_replace("PERFIL", "", $tipoExame);
		$tipoExame = str_replace("MENTO", "", $tipoExame);
		$tipoExame = str_replace("FRONTO", "", $tipoExame);
		$tipoExame = str_replace("OBL", "", $tipoExame);
		return $tipoExame;
	}
	
    private function getCRJDICOMInfoCR($dicom) {
        
        $dicom->parse(array('InstitutionName'));   // 0x0008,0x0080
        $dicom->parse(array('StationName'));       // 0x0008,0x1010
        $dicom->parse(array('StudyDescription'));  // 0x0008,0x1030
        $dicom->parse(array('SeriesDescription')); // 0x0008,0x103E
        $dicom->parse(array('PerformedProcedureStepDescription')); // 0x0040, 0x0254
        
        $cliente = strtoupper($dicom->value(0x0008,0x0080));
        $studyDescription = trim(strtoupper($dicom->value(0x0008,0x1030)));
        $seriesDescription = $this->remove_accents(
            trim(
                strtoupper($dicom->value(0x0008,0x103E))
            )
        );

        $tipoExame = $this->remove_accents(
            trim(
                strtoupper($dicom->value(0x0040, 0x0254))
            )
        );

        $medico = trim(str_replace('^', ' ', $dicom->value(0x0008,0x0090)));
        $medico = $this->remove_accents(
            $this->getNomeSobrenome($medico)
        );

        $empresa = $this->remove_accents(
            trim(str_replace('^', ' ', $dicom->value(0x0038,0x4000)))
        );

        $id = $dicom->value(0x0020,0x000D) . '-' . $tipoExame; ;

        $isOit = $studyDescription == 'OIT' && $seriesDescription == 'PA PORTRAIT' &&
                 $tipoExame == 'PEITO' ? "S" : "N"; 

		$info = (object)array(
			'id' => $id,
			'cliente' => $cliente,
			'oit' => $isOit,
			'exame' => $seriesDescription,
			'subtipo' => $tipoExame,
            'medico' => $medico,
            'empresa' => $empresa
		);

        return $info;

    }


    private function getCRJDICOMInfoDR($dicom) { //Thais
        
        $dicom->parse(array('InstitutionName'));   // 0x0008,0x0080
        $dicom->parse(array('StationName'));     // 0x0008,0x1010
        $dicom->parse(array('StudyDescription'));  // 0x0008,0x1030
        $dicom->parse(array('SeriesDescription')); // 0x0008,0x103E
        $dicom->parse(array('PatientID')); //    0x0010,0x0020 CPF ou RG
        $dicom->parse(array('BodyPartExamined'));  // 0x0018,0015     
        $dicom->parse(array('ProtocolName'));  // 0x0018,1030
        $dicom->parse(array('ReferringPhysiciansName'));  // 0x0008,0x0090 
        $dicom->parse(array('ImageLaterality'));  // 0020,0062   lado direit ou esquerdo 
        $dicom->parse(array('CodeMeaning'));  // 0008,0104   Paranasal sinus / (Seios da face)
        //cpf

        
        $cliente = strtoupper($dicom->value(0x0008,0x0080));  //CRJ - Centro Radiologico Jundiai
        //$studyDescription = trim(strtoupper($dicom->value(0x0008,0x1030)));   //Mao EObliqua   era assim, alterei a tag para funcionar tbm o worklist
        $studyDescription = trim(strtoupper($dicom->value(0x0018,0x1030)));   //Mao EObliqua



        $seriesDescription = $this->remove_accents(
            trim(
                strtoupper($dicom->value(0x0008,0x103E)) //Obliqua
            )
        );
        $bodypartexamined = $this->remove_accents(
            trim(
                strtoupper($dicom->value(0x0018,0x0015))  //HAND
            )
        );
         $patientposition = $this->remove_accents(
            trim(
                strtoupper($dicom->value(0x0008,0x103E))   //Obliqua
            )
        );
        

        
        $ausencia_tipoExame = substr($dicom->value(0x0008,0x1030), 0, 5);  // 5 PRIMEIRASLETRAS  / Forearm bone //ANTEBRAÇO

        switch ($ausencia_tipoExame) {
            case "Seios":
                $ausencia_tipoExame = "SEIOS DA FACE";
                break;
            case "Forea":
                $ausencia_tipoExame = "ANTEBRAÇO";
                break;
            case "Cavum":
                $ausencia_tipoExame = "CAVUM";
                break;
                
            
        }

        //$tipoExame = $this->remove_accents(trim(strtoupper($dicom->value(0x0018, 0x0015))));  //HAND
         $tipoExame = $this->remove_accents(trim(strtoupper($dicom->value(0x0018, 0x0015))));  //HAND
        if ($tipoExame == null) $tipoExame = $ausencia_tipoExame . " - "; // thais ver

         //$tipoExame = $tipoExame ." ( ". $ausencia_tipoExame ." ) ". " - "; // thais ver


         switch ($tipoExame) {
            case "HAND":
                $tipoExame = "MAO";
                break;
            case "ELBOW":
                $tipoExame = "COTOVELO";
                break;
            case "LSPINE":
                $tipoExame = "COLUNA LOMBAR";
                break;
            case "CSPINE":
                $tipoExame = "COLUNA CERVICAL";
                break;
            case "CHEST":
                $tipoExame = "TORAX";
                break;
            case "KNEE":
                $tipoExame = "JOELHO";
                break;
            case "WRIST":
                $tipoExame = "PUNHO";
                break;
            case "SHOULDER":
                $tipoExame = "OMBRO";
                break;
            case "HUMERUS":
                $tipoExame = "UMERO";
                break;
            case "SCAPULA":
                $tipoExame = "ESCAPULA";
                break;
            case "CLAVICLE":
                $tipoExame = "CLAVICULA";
                break;
            case "HIP":
                $tipoExame = "ART. QUADRIL";
                break;           
        }
 		//$tipoExame = $tipoExame ." ( ". $ausencia_tipoExame ." ) ". " - "; // thais ver

  
        $lateralidade = $this->remove_accents(trim(strtoupper($dicom->value(0x0020, 0x0062))));  //L ou R ou vazia
       	if ($lateralidade == "L") $tipoExame = $tipoExame ." ESQ"; 
       	if ($lateralidade == "R") $tipoExame = $tipoExame ." DIR"; 


       

        $medico = trim(str_replace('^', ' ', $dicom->value(0x0008,0x0090))); //GESSE^GOMES^BARBOSA
        $medico = $this->remove_accents($medico);
       
        $empresa = trim(str_replace('^', ' ', $dicom->value(0x0010,0x4000))); //METRA HOERBIGER BRASIL LTDA
       	$empresa = $this->remove_accents($empresa);        
        
    
  
         $id = $dicom->value(0x0020,0x000D) . '-' . $tipoExame; //1.2.392.200036.9107.307.31235.113123521110900680
        
        

        $isOit = $studyDescription == 'TORAX PA/AP' && $bodypartexamined == 'CHEST' &&
                 $patientposition == 'OIT PA' ? "S" : "N";
         
                 /*
        $isOit = $studyDescription == 'TORAX OITPA' && $bodypartexamined == 'CHEST' &&
                 $patientposition == 'PA' ? "S" : "N";*/
        
	
        
        $info = (object)array(
            'id' => $id,
            'cliente' => $cliente,
            'oit' => $isOit,
            //'exame' => $seriesDescription,
            'exame' => $patientposition,
            'subtipo' => $tipoExame,
            'medico' => $medico,
            'empresa' => $empresa,
            'cpf' => $cpf                     
        );
        
        return $info;

    }

/*RX Bem Viver*/
private function getBEMVIVERDICOMInfoDR($dicom) { //Thais
        
        $dicom->parse(array('InstitutionName'));   // 0x0008,0x0080
        $dicom->parse(array('StationName'));     // 0x0008,0x1010
        $dicom->parse(array('StudyDescription'));  // 0x0008,0x1030
        //$dicom->parse(array('SeriesDescription')); // 0x0008,0x103E
        $dicom->parse(array('PatientID')); //    0x0010,0x0020 CPF ou RG
        $dicom->parse(array('BodyPartExamined'));  // 0x0018,0015     
        $dicom->parse(array('ProtocolName'));  // 0x0018,1030
        $dicom->parse(array('ReferringPhysiciansName'));  // 0x0008,0x0090 
        

        
        $cliente = strtoupper($dicom->value(0x0008,0x0080));  //BEM VIVER
        /*$studyDescription = trim(strtoupper($dicom->value(0x0008,0x1030)));   //Mao EObliqua
        $seriesDescription = $this->remove_accents(
            trim(
                strtoupper($dicom->value(0x0008,0x103E)) //Obliqua
            )
        );*/
        $bodypartexamined = $this->remove_accents(
            trim(
                strtoupper($dicom->value(0x0018,0x0015))  //CHEST
            )
        );
        

        $tipoExame = $this->remove_accents(trim(strtoupper($dicom->value(0x0018, 0x0015))));  //HAND
         
                  
       

        $medico = trim(str_replace('^', ' ', $dicom->value(0x0008,0x0090))); //GESSE^GOMES^BARBOSA
        $medico = $this->remove_accents($medico);

       
        $empresa = trim(str_replace('^', ' ', $dicom->value(0x0008,0x1030))); //METRA HOERBIGER BRASIL LTDA
       	$empresa = $this->remove_accents($empresa);        
        
    
  
        $id = $dicom->value(0x0020,0x000D) . '-' . $tipoExame; //1.2.392.200036.9107.307.31235.113123521110900680
        
        $ProtocolName = $this->remove_accents(
            trim(
                strtoupper($dicom->value(0x0018,0x1030))  //TORAX OIT PA
            )
        );
        
        
        $isOit = $ProtocolName == 'TORAX OIT PA' && $bodypartexamined == 'CHEST' ? "S" : "N";
        //$isOit = $ProtocolName == 'TORAX OIT AP' && $bodypartexamined == 'CHEST' ? "S" : "N"; NÃO DEU CERTO

        
        $info = (object)array(
            'id' => $id,
            'cliente' => $cliente,
            'oit' => $isOit,
            //'exame' => $seriesDescription,
            'exame' => $bodypartexamined,
            'medico' => $medico,
            'empresa' => $empresa,
            'subtipo' => $tipoExame
                      
        );
        
        return $info;

    }
 
/*********************/

	private function getDICOMInfo($file){

		$dicom = $this->dicom->getInstance($file);
		
		$dicom->parse(array('StudyInstanceUID'));  // 0x0020,0x000D
        $dicom->parse(array('InstitutionName'));   // 0x0008,0x0080
		$dicom->parse(array('SeriesDescription')); // 0x0008,0x103E 
		$dicom->parse(array('PatientComments'));   // 0x0010,0x4000 
		$dicom->parse(array('StationName'));       // 0x0008,0x1010
		$dicom->parse(array('AcquisitionDeviceProcessingDescription')); // 0x0018,0x1400

        if ($dicom->value(0x0008,0x1010) == 'XC_DICOM_CRJ') return $this->getCRJDICOMInfoCR($dicom);
        if ($dicom->value(0x0008,0x0070) == 'KONICA MINOLTA') return $this->getCRJDICOMInfoDR($dicom); //Thais
        if ($dicom->value(0x0008,0x0070) == 'Imex Medical Group') return $this->getBEMVIVERDICOMInfoDR($dicom); //Thais

		$cliente = preg_replace('/[^0-9]/', '', $cliente);
		$cliente = $cliente ? $cliente : $dicom->value(0x0008,0x0080);

				
		$seriesDescription = trim($dicom->value(0x0008,0x103E));
		if (strlen($seriesDescription) == 0) $seriesDescription = trim($dicom->value(0x0018,0x1400));
		$seriesDescription = strtoupper($seriesDescription);
		$seriesDescription = $this->str_remove($seriesDescription, "[^A-Z0-9 ]");

		$tipoExame = $this->str_remove($seriesDescription, "[^A-Z0-9]");

		$tipoExame = str_replace("LAT", "", $tipoExame);
		$tipoExame = str_replace("FRN", "", $tipoExame);
		$tipoExame = str_replace("AP", "", $tipoExame);
		
		if ($tipoExame == "PA") $tipoExame = "TORAX";
		
		$tipoExame = str_replace("PA", "", $tipoExame);
		$tipoExame = str_replace("OBL", "", $tipoExame);
		$tipoExame = str_replace("PERFIL", "", $tipoExame);
		$tipoExame = str_replace("MENTO", "", $tipoExame);
		$tipoExame = str_replace("FRONTO", "", $tipoExame);
		
		$id = $dicom->value(0x0020,0x000D) . '-' . $tipoExame;
		
		$isOit = $this->isOit($dicom) ? "S" : "N";

				
		$info = (object)array(
			'id' => $id,
			'cliente' => $cliente,
			'oit' => $isOit,
			'exame' => $seriesDescription,
			'subtipo' => $tipoExame
		);
		
		return $info;
	}
	
	private function DCM2JPG($name){
		$path_cmd = realpath(config_item('upload_folder')) . '/dcm4che/bin/';
		$jpg  = str_replace('.dcm', '.jpg', $name);
		$cmd = $path_cmd . 'dcm2jpg ' . $name . ' ' . $jpg;
		
		if (substr(php_uname(), 0, 7) == "Windows"){
			$cmd = getcwd() . '\uploads\dama\dcm4che\bin\dcm2jpg.bat ' . $name . ' ' . $jpg;
			$cmd = str_replace('/', '\\', $cmd);
		    pclose(popen("start /B ". $cmd, "r"));  
		}
		else { 
			exec($cmd . " > /dev/null &");   
		}

		log_message('debug', 'DCM2JPG ' . $cmd);

		return $jpg;
	}
	
	private function addDCMFileInList($dcm_files, $zip, $name, $path_dcm){
		if (preg_match('/(\.dcm|\.oit)/', strtolower($name)) !== 1) return $dcm_files;
		
		$isOit = (preg_match('/(\.oit)/', strtolower($name)) == 1) ? "S" : "N";

		$new_name = md5(uniqid(rand(), true)) . '.dcm';
		
		$zip->renameName($name, $new_name);

		$zip->extractTo($path_dcm, $new_name);

		$info = $this->getDICOMInfo($path_dcm . $new_name);

		$isOit = ($isOit == "S") ? "S" : $info->oit;
		
		if ($dcm_files[$info->id]){
			$final_name = $dcm_files[$info->id]['zip_name'] . '_' . count($dcm_files[$info->id]['files']) . '.dcm';
			$dcm_files[$info->id]['files'][] = $final_name;
			$dcm_files[$info->id]['exames'][] = $info->exame;
			rename($path_dcm . $new_name, $path_dcm . $final_name);
			$this->DCM2JPG($path_dcm . $final_name);
			return $dcm_files;
		}

        $dcm_files[$info->id] = array(
			'cliente' => $info->cliente,
			'OIT' => $isOit,
			'zip_name' => md5(uniqid(rand(), true)),
			'files' => null,
			'exames' => array($info->exame),
			'subtipo' => $info->subtipo,
            'medico' => $info->medico,
            'empresa' => $info->empresa
		);
		
		$final_name = $dcm_files[$info->id]['zip_name'] . '_0.dcm';
		$dcm_files[$info->id]['files'] = array($final_name);
		rename($path_dcm . $new_name, $path_dcm . $final_name);
		$this->DCM2JPG($path_dcm . $final_name);
		
		return $dcm_files;

	}
	
	private function renameDCMOITFiles($files_in_zip, $path, $i, $raw_name){
		if (preg_match('/(\.oit)/', strtolower($files_in_zip[$i]['target'])) == 1){
			
			for ($f = 0; $f < count($files_in_zip[$i]['files']); $f++){
				$new_name = $files_in_zip[$i]['name'] . '_' . $f . '.dcm';
				rename($path . $files_in_zip[$i]['files'][$f], $path . $new_name);
				$files_in_zip[$i]['files'][$f] = $new_name;
				$files_in_zip[$i]['target'] = $files_in_zip[$i]['files'][0];
			}

			$files_in_zip[$i]['target'] = $files_in_zip[$i]['files'][0];
			$files_in_zip[$i]['DCM_OIT'] = true;
			
		}
		
		return $files_in_zip;
	}

	private function renameDCMFiles($files_in_zip, $path, $i, $raw_name){
		if (preg_match('/(\.dcm)/', strtolower($files_in_zip[$i]['target'])) == 1){
			
			for ($f = 0; $f < count($files_in_zip[$i]['files']); $f++){
				$new_name = $files_in_zip[$i]['name'] . '_' . $f . '.dcm';
				rename($path . $files_in_zip[$i]['files'][$f], $path . $new_name);
				$files_in_zip[$i]['files'][$f] = $new_name;
				$files_in_zip[$i]['target'] = $files_in_zip[$i]['files'][0];
			}
			
			$files_in_zip[$i]['target'] = $files_in_zip[$i]['files'][0];
			$files_in_zip[$i]['DCM_OIT'] = false;
			
		}
		
		return $files_in_zip;
	}
	
    private function renameFile($files_in_zip, $path, $i, $raw_name){
		
		$name = str_replace("#", "_", $files_in_zip[$i]['name']);

		$files_in_zip[$i]['name'] = $name;
		$files_in_zip[$i]['target'] = str_replace("#", "_", $files_in_zip[$i]['target']);

		for ($f = 0; $f < count($files_in_zip[$i]['files']); $f++){
			$new_name = str_replace("#", "_", $files_in_zip[$i]['files'][$f]);
			rename($path . $files_in_zip[$i]['files'][$f], $path . $new_name);
			$files_in_zip[$i]['files'][$f] = $new_name;
		}
		
		return $files_in_zip;
		
    }

    private function renameFiles($files_in_zip, $path, $path_images){
        for ($i = 0; $i < count($files_in_zip); $i++){

            $name = str_replace("#", "_", $files_in_zip[$i]['name']);

            if ($name == $files_in_zip[$i]['name']) continue;

            $files_in_zip[$i]['name'] = $name;
            $files_in_zip[$i]['target'] = str_replace("#", "_", $files_in_zip[$i]['target']);

            for ($f = 0; $f < count($files_in_zip[$i]['files']); $f++){
                $new_name = str_replace("#", "_", $files_in_zip[$i]['files'][$f]);
                rename($path . $files_in_zip[$i]['files'][$f], $path . $new_name);
                $files_in_zip[$i]['files'][$f] = $new_name;
            }


        }
        return $files_in_zip;
    }

    private function delDir($dir) {
        if (!is_dir($dir)) {
            //return unlink($dir);
            return true;
        }

        if (!file_exists($dir)) {
            return true;
        }

        foreach (scandir($dir) as $item) {
            if ($item == '.' || $item == '..') {
                continue;
            }

            if (!$this->delDir($dir . DIRECTORY_SEPARATOR . $item)) {
                return false;
            }
        }

        return rmdir($dir);
    }

    private function insertEEG($file, $file_name, $dama_desktop_key, $params){

        log_message('debug', 'insertEEG() >>> ' . $file);

        $bytes = $this->getBytes($file);

        $exame = $this->getObject();
        $exame->DamaDesktopKey = $dama_desktop_key;

        $exame->Tipo        = 'EEG';
        //$exame->Motivo      = null;
        $exame->Data        = $this->toDate();
        $exame->Paciente    = $this->getString($bytes, 6); // . ' ' . $this->getString($bytes, 37);
        $exame->DataNasc    = $this->toDate($this->getString($bytes, 83, 92)); // offset 83 até 92. -> ela virá assim "04-04-1977".
        $exame->Idade       = $this->getIdade($exame->DataNasc);
        $exame->Sexo        = substr($this->getString($bytes, 108), 0, 1); // offset 108 até 00. -> virá assim "Masculino".
        $exame->Altura      = null;
        $exame->Peso        = null;
        $exame->IMC         = null;

        $sobrenome          = $this->getString($bytes, 37);

        $exame->Empresa     = $this->getInner($sobrenome);
        $exame->Motivo      = $this->getOuterRight($sobrenome);

        if (!$exame->Empresa) $exame->Paciente .= ' ' . $sobrenome;

        $exame->Medico      = null;
        $exame->Observacao  = null;
        $exame->Arquivo     = $file_name;
        $exame->RG          = $this->getString($bytes, 68);
        $exame->Imagem      = ($params && $params['imagem']) ? $params['imagem'] : null;

        //log_message('debug', print_r($exame, true));
        //return;

        $this->insertExame($exame);

    }

	private function remove_accents($data){
		$str = utf8_encode($data);
		$str = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
		return preg_replace("/[^A-Za-z0-9 \-\,]/i", "", $str);
	}
	
	private function str_remove($data, $regexp){
		$str = utf8_encode($data);
		$str = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
		return preg_replace('/' . $regexp . '/i', "", $str);
		//return ereg_replace($regexp, "", $str);
	}

    private function insertDCM_OIT($file, $file_name, $dama_desktop_key, $params){

		if (preg_match('/(\.oit)/', strtolower($file)) == 1){
			$file_name = substr($file_name, 0, strlen($file_name) - 4) . '.dcm';
			$new_file = substr($file, 0, strlen($file) - 4) . '.dcm';
			rename($file, $new_file);
			$file = $new_file;
		}
	
        log_message('debug', 'insertDCM_OIT() >>> ' . $file);

		$dicom = $this->dicom->getInstance($file);
		
        $dicom->parse(array('PatientName'));
		$dicom->parse(array('AcquisitionDate'));
		$dicom->parse(array('PatientID'));
		$dicom->parse(array('PatientBirthDate'));
		$dicom->parse(array('PatientSex'));
		$dicom->parse(array('StudyDescription'));
		$dicom->parse(array('SeriesDescription'));
		
        $exame = $this->getObject();
        $exame->Tipo        = 'RAIOX_OIT';
		$exame->SubTipo     = $this->str_remove($dicom->value(0x0008,0x103E), "[^A-Za-z0-9]");
        $exame->Data        = $this->toDateAAAAMMDD($dicom->value(0x0008, 0x0022));
        $exame->Paciente    = $dicom->value(0x0010, 0x0010); // $dicom->PatientName;
        $exame->DataNasc    = $this->toDateAAAAMMDD($dicom->value(0x0010, 0x0030));
        $exame->Idade       = $this->getIdade($exame->DataNasc);
        $exame->Sexo        = $dicom->value(0x0010, 0x0040); //$dicom->PatientSex;
        $exame->Altura      = null;
        $exame->Peso        = null;
        $exame->IMC         = null;
        $exame->Empresa     = null; //$dicom->value(0x0010, 0x0020); //$dicom->PatientID;
        $exame->Motivo      = null;
        $exame->Medico      = null;
        //$exame->RG          = $dicom->value(0x0010, 0x0020);
        //Thais
        if ($dicom->value(0x0008,0x0070) == 'KONICA MINOLTA') {
        $exame->RG          = $dicom->value(0x0010, 0x0020);
        $exame->CPF          = $dicom->value(0x0010, 0x0020);
        }
        $exame->Observacao  = $dicom->value(0x0008,0x103E); //null;
        $exame->Arquivo     = $file_name;
        $exame->Imagem      = ($params && $params['imagem']) ? $params['imagem'] : null;
        $exame->DamaDesktopKey = $dama_desktop_key;

		$exame->Observacao = $this->str_remove($exame->Observacao, "[^A-Za-z0-9 \,\.\-]"); //$this->remove_accents($exame->Observacao);

		$exame->Paciente   = trim(str_replace('^', ' ', $exame->Paciente));
		$exame->Paciente   = $this->str_remove($exame->Paciente, "[^A-Za-z0-9 \.\-]"); //$this->remove_accents($exame->Paciente);
		
		log_message('debug', print_r($exame, true));
		
        $this->insertExame($exame);
		
	}

	private function isOIT($dicom){
		
		$dicom->parse(array('PatientComments')); // 0x0010,0x4000
		$dicom->parse(array('AcquisitionDeviceProcessingDescription')); // 0x0018,0x1400
		$dicom->parse(array('SeriesDescription')); // 0x0008,0x103E
		
		$patientComments = strtoupper($dicom->value(0x0010,0x4000));
		$acquisitionDevice = strtoupper($dicom->value(0x0018,0x1400));
		
		if (strlen(trim($acquisitionDevice)) == 0) $acquisitionDevice = trim($dicom->value(0x0008,0x103E));
		
		$patientComments = $this->str_remove($patientComments, "[^A-Z0-9 ]");
		$acquisitionDevice = $this->str_remove($acquisitionDevice, "[^A-Z0-9 ]");
		
		if (strpos($patientComments, ' OIT') === false) return false;
		if (strpos($acquisitionDevice, 'TORAX') === false) return false;

		return true;
		
	}
	
    private function insertDCM($file, $file_name, $dama_desktop_key, $params){
		
		$isOit = preg_match('/(\.oit)/', strtolower($file)) == 1;
		
		if ($isOit){
			$file_name = substr($file_name, 0, strlen($file_name) - 4) . '.dcm';
			$new_file = substr($file, 0, strlen($file) - 4) . '.dcm';
			rename($file, $new_file);
			$file = $new_file;
		}

		log_message('debug', 'insertDCM() >>> ' . $file);

		$this->DCM2JPG($file);
		$imagem = 'lotes/' . substr($file_name, 0, strlen($file_name) - 4) . '.jpg';

		$dicom = $this->dicom->getInstance($file);
		
        $dicom->parse(array('PatientName'));
		$dicom->parse(array('AcquisitionDate'));
		$dicom->parse(array('PatientID'));
		$dicom->parse(array('PatientBirthDate'));
		$dicom->parse(array('PatientSex'));
		$dicom->parse(array('StudyDescription'));
		$dicom->parse(array('SeriesDescription')); // 0x0008,0x103E 
		$dicom->parse(array('AcquisitionDeviceProcessingDescription')); // 0x0018,0x1400
		$dicom->parse(array('Modality')); // 0x0008,0x0060
		$dicom->parse(array('PatientComments')); // 0x0010,0x4000

		$isOit = $isOit ? true : ($this->isOIT($dicom) ? true : false);
		
		$tipoExame = trim($dicom->value(0x0008,0x0060));
	
		if ($tipoExame == "EC") {
			$params['imagem'] = $imagem;
			$this->insertExameDCM_ECG($file, $file_name, $dama_desktop_key, $params);
			return;
		}
		
		$seriesDescription = trim($dicom->value(0x0008,0x103E));
		if (strlen($seriesDescription) == 0) $seriesDescription = trim($dicom->value(0x0018,0x1400));
		$seriesDescription = strtoupper($seriesDescription);
		$seriesDescription = $this->str_remove($seriesDescription, "[^A-Z0-9 ]");

        $exame = $this->getObject();
        $exame->Tipo        = $isOit ? 'RAIOX_OIT' : 'RAIO';
		$exame->SubTipo     = $this->getDICOMTipoExame($seriesDescription);
        $exame->Data        = $this->toDateAAAAMMDD($dicom->value(0x0008, 0x0022));
        $exame->Paciente    = $dicom->value(0x0010, 0x0010); // $dicom->PatientName;
        $exame->DataNasc    = $this->toDateAAAAMMDD($dicom->value(0x0010, 0x0030));
        $exame->Idade       = $this->getIdade($exame->DataNasc);
        $exame->Sexo        = $dicom->value(0x0010, 0x0040); //$dicom->PatientSex;
        $exame->Altura      = null;
        $exame->Peso        = null;
        $exame->IMC         = null;
        $exame->Empresa     = null; //$dicom->value(0x0010, 0x0020); //$dicom->PatientID;
        $exame->Motivo      = null;
        $exame->Medico      = null;
        $exame->Observacao  = $seriesDescription;
        $exame->Arquivo     = $file_name;
        //$exame->RG          = $dicom->value(0x0010, 0x0020);
        //Thais
        if ($dicom->value(0x0008,0x0070) == 'KONICA MINOLTA') {
        $exame->RG          = $dicom->value(0x0010, 0x0020);
        $exame->CPF          = $dicom->value(0x0010, 0x0020);
        }
        $exame->Imagem      = $imagem; //($params && $params['imagem']) ? $params['imagem'] : null;

        $exame->DamaDesktopKey = $dama_desktop_key;

		$exame->Paciente   = trim(str_replace('^', ' ', $exame->Paciente));
		$exame->Paciente   = $this->str_remove($exame->Paciente, "[^A-Za-z0-9 \.\-]"); //$this->remove_accents($exame->Paciente);
		
		log_message('debug', print_r($exame, true));
		
        $this->insertExame($exame);
		
	}

    private function insertWXML($file, $file_name, $dama_desktop_key, $params){

        log_message('debug', 'insertWXML() >>> ' . $file);

        $exame = $this->getObject();
        $exame->DamaDesktopKey = $dama_desktop_key;

        try {

            $xml=simplexml_load_file($file);

            $exame->Tipo        = 'ECG';
            $exame->Motivo      = (string)$xml->Paciente->RegistroClinico;
            $exame->Empresa     = (string)$xml->Paciente->Endereco;
            $exame->Data        = (string)$xml->Exame->Registros->Registro->Data;
            $exame->Paciente    = (string)$xml->Paciente->Nome;
            $exame->DataNasc    = $this->toDate($xml->Paciente->DataNascimento);
            $exame->Idade       = $this->getIdade($exame->DataNasc);
            $exame->Sexo        = (string)$xml->Paciente->Sexo;

            $exame->Altura      = (string)$xml->Exame->Altura / 100;
            $exame->Peso        = (string)$xml->Exame->Peso;
            $exame->IMC         = (string)$xml->Exame->IMC;

            $exame->Medico      = (string)$xml->Exame->Medicos->Solicitante->Nome;
            $exame->CRM         = (string)$xml->Exame->Medicos->Solicitante->CRM;
            $exame->Observacao  = (string)$xml->Exame->Observacoes;
            $exame->RG          = (string)$xml->Paciente->Telefones->Residencial;
            $exame->Arquivo     = $file_name;
            $exame->Imagem      = ($params && $params['imagem']) ? $params['imagem'] : null;

            //log_message('debug', print_r($exame, true));

            $this->insertExame($exame);

        } catch (Exception $e) {

            //log_message('debug', $e->getMessage());

        }

        return $exame;

    }

    private function getUBERMED($exame, $xml){
        //if (UserSession::user("id") == $this->UBERMED){
            $exame->Empresa = (string)$xml->Paciente->Email;
            $exame->Motivo  = (string)$xml->Paciente->Indicacao;
            return $exame;
        //}
        //return $exame;
    }

    private function insertXML($file, $file_name, $dama_desktop_key, $params){

        log_message('debug', 'insertXML() >>> ' . $file);

        $exame = $this->getObject();
        $exame->DamaDesktopKey = $dama_desktop_key;

        try {
            $xml=simplexml_load_file($file);
            $exame->Tipo        = 'EEG';
            $exame->Data        = (string)$xml->Paciente->DataExame;
            $exame->Paciente    = (string)$xml->Paciente->Nome;
            $exame->DataNasc    = (string)$xml->Paciente->DataNasc;
            $exame->Idade       = $this->getIdade($exame->DataNasc);
            $exame->Sexo        = substr($xml->Paciente->Sexo, 0, 1);
            $exame->Altura      = (string)$xml->Paciente->Altura / 100;
            $exame->Peso        = (string)$xml->Paciente->Peso;
            $exame->IMC         = $this->getIMC($exame->Peso, $exame->Altura);
            $exame->Medico      = (string)$xml->Paciente->Medico;
            $exame->Observacao  = (string)$xml->Paciente->Obs;

            $exame->RG          = (string)$xml->Paciente->Fone;
            $exame->CPF         = (string)$xml->Paciente->Celular;

            $exame->Arquivo     = $file_name;
            $exame->Imagem      = ($params && $params['imagem']) ? $params['imagem'] : null;

            $exame = $this->getUBERMED($exame, $xml);

            $this->insertExame($exame);

        } catch (Exception $e) {

            //log_message('debug', $e->getMessage());

        }

        return $exame;

    }

    private function insertDATEST($file, $file_name, $dama_desktop_key, $params){

        log_message('debug', 'insertDATEST() >>> ' . $file);

        $exame = $this->getObject();
        $exame->DamaDesktopKey = $dama_desktop_key;

        try {

            $xml=simplexml_load_file($file);
            //log_message('debug', print_r($xml, TRUE));

            $exame->Tipo        = 'EEG';
            $exame->Motivo      = (string)$xml->convenio;
            $exame->Data        = $this->toDateDDMMAAAA($xml->dia, $xml->mes, $xml->anio);
            $exame->Paciente    = $xml->nombres . ' ' . $xml->apellido;
            $exame->DataNasc    = null;
            $exame->Idade       = (string)$xml->edad;
            $exame->Sexo        = (string)$xml->sexo;
            $exame->Altura      = (string)$this->getAltura($xml->altura);
            $exame->Peso        = (string)$xml->peso;
            $exame->IMC         = $this->getIMC($exame->Peso, $exame->Altura);
            $exame->Medico      = (string)$xml->doctor;
            $exame->Observacao  = null;
            $exame->Arquivo     = $file_name;
            $exame->RG          = (string)$xml->rg;
            $exame->CPF         = (string)$xml->cpf;
            $exame->Empresa     = (string)$xml->empresa;
            $exame->Imagem      = ($params && $params['imagem']) ? $params['imagem'] : null;

            $this->insertExame($exame);

        } catch (Exception $e) {

            log_message('debug', $e->getMessage());

        }

        return $exame;

    }

    private function insertMDT($file, $file_name, $dama_desktop_key, $params){

        log_message('debug', 'insertMDT() >>> ' . $file);

        $xml = $this->getBytes($file);
        $start = strpos($xml, "<?xml");
        $stop  = strpos($xml, "</datest>");
        $xml = substr($xml, $start, $stop + 9 - $start);

        //log_message('debug', $xml);

        $exame = $this->getObject();
        $exame->DamaDesktopKey = $dama_desktop_key;

        try {

            $xml=simplexml_load_string($xml);
            //log_message('debug', print_r($xml, TRUE));

            $exame->Tipo        = 'EEG';
            $exame->Motivo      = (string)$xml->convenio;
            $exame->Data        = $this->toDateDDMMAAAA($xml->dia, $xml->mes, $xml->anio);
            $exame->Paciente    = $xml->nombres . ' ' . $xml->apellido;
            $exame->DataNasc    = null;
            $exame->Idade       = (string)$xml->edad;
            $exame->Sexo        = (string)$xml->sexo;
            $exame->Altura      = (string)$this->getAltura($xml->altura);
            $exame->Peso        = (string)$xml->peso;
            $exame->IMC         = $this->getIMC($exame->Peso, $exame->Altura);
            $exame->Medico      = (string)$xml->doctor;
            $exame->Observacao  = null;
            $exame->Arquivo     = $file_name;
            $exame->RG          = (string)$xml->rg;
            $exame->CPF         = (string)$xml->cpf;
            $exame->Empresa     = (string)$xml->empresa;
            $exame->Imagem      = ($params && $params['imagem']) ? $params['imagem'] : null;

            $this->insertExame($exame);

        } catch (Exception $e) {

            log_message('debug', $e->getMessage());
        }

        return $exame;

    }

    private function insertDTE($file, $file_name, $dama_desktop_key, $params){

        log_message('debug', 'insertDTE() >>> ' . $file);

        $bytes = $this->getBytes($file);

        $exame = $this->getObject();
        $exame->DamaDesktopKey = $dama_desktop_key;

        $exame->Tipo        = 'EEG';
        $sobrenome          = $this->getString($bytes, 15);

        $exame->Motivo      = $this->getString($bytes, 162, 162);
        $exame->Data        = $this->toDate();
        $exame->Paciente    = $this->getString($bytes, 36); //  . ' ' . $this->getString($bytes, 15); // offset 36 até 00 (nome) + offset 15 até 00 (sobrenome).
        $exame->DataNasc    = null;
        $exame->Idade       = $this->getString($bytes, 59); // offset 59 até 00 -> ele virá assim "33".
        $exame->Sexo        = $this->getString($bytes, 57); // offset 57 -> ele virá assim "M".
        $exame->Altura      = null;
        $exame->Peso        = null;
        $exame->IMC         = null;

        $exame->Medico      = $this->getString($bytes, 66); // offset 66 até 00.
        $exame->Observacao  = null;
        $exame->Arquivo     = $file_name;

        $exame->RG          = $this->getString($bytes, 97);
        $exame->CPF         = $this->getString($bytes, 114);
        $exame->Empresa     = $this->getString($bytes, 131);
        $exame->Imagem      = ($params && $params['imagem']) ? $params['imagem'] : null;

        /**
         * EQUIPAMENTO ANTIGO?
         */
        if (!$exame->Empresa) {

            $exame->Empresa = $this->getInner($sobrenome);
            $exame->Motivo  = $this->getOuterRight($sobrenome);

            if (!$exame->Empresa) $exame->Paciente .= ' ' . $sobrenome;

        } else {

            $exame->Paciente .= ' ' . $sobrenome;

        }

        //log_message('debug', print_r($exame, true));

        $this->insertExame($exame);

    }

    private function insertDAT($file, $file_name, $dama_desktop_key, $params){
        log_message('debug', 'insertDAT() >>> ' . $file);

        $bytes = $this->getBytes($file);

        $exame = $this->getObject();
        $exame->DamaDesktopKey = $dama_desktop_key;

        $exame->Tipo        = 'EEG';
        $exame->Data        = $this->getString($bytes, 172, 181); // offset 172 até 181 -> ele virá assim "04/11/2015"
        $exame->Paciente    = trim($this->getString($bytes, 50, 149)); // offset 50 até TAM 100 caracteres.
        $exame->DataNasc    = $this->getString($bytes, 385, 394); // offset 385 até 394 -> ele virá assim "01/09/1988"
        $exame->Idade       = $this->getIdade($exame->DataNasc);
        $exame->Sexo        = $this->getString($bytes, 161, 161); // offset 57 -> ele virá assim "M".
        $exame->Altura      = null;
        $exame->Peso        = null;
        $exame->IMC         = null;

        $paciente           = $exame->Paciente;

        $exame->Paciente    = $this->getOuterLeft($paciente);
        $exame->Motivo      = $this->getOuterRight($paciente);
        $exame->Empresa     = $this->getInner($paciente);

        $exame->Medico      = null;
        $exame->Observacao  = null;
        $exame->Arquivo     = $file_name;
        $exame->Imagem      = ($params && $params['imagem']) ? $params['imagem'] : null;

        $this->insertExame($exame);

    }

    private function insertPLG($file, $file_name, $dama_desktop_key, $params){
        log_message('debug', 'insertPLG() >>> ' . $file);

        $bytes = $this->getBytes($file);

        $exame = $this->getObject();
        $exame->DamaDesktopKey = $dama_desktop_key;

        $exame->Tipo        = 'EEG';
        $exame->Motivo      = $this->getString($bytes, 100, 100);
        $exame->Data        = $this->toDateAAAAMMDD($this->getString($bytes, 206, 213)); // offset 206 até 213 -> ele virá assim "20160303".
        $exame->Paciente    = trim($this->getString($bytes, 12, 41)); //  offset 12 até 41.
        $exame->DataNasc    = $this->toDateAAAAMMDD($this->getString($bytes, 170, 177)); // offset 170 até 177 -> ele virá assim "19940505".
        $exame->Idade       = $this->getIdade($exame->DataNasc);
        $exame->Sexo        = null;
        $exame->Altura      = null;
        $exame->Peso        = null;
        $exame->IMC         = null;

        $exame->Medico      = $this->getString($bytes, 224); // offset 224 até 00.
        $exame->Observacao  = null;
        $exame->Arquivo     = $file_name;

        $exame->Empresa     = $this->getString($bytes, 69);
        $exame->Sexo        = $this->getString($bytes, 203, 203);
        $exame->Imagem      = ($params && $params['imagem']) ? $params['imagem'] : null;

        $this->insertExame($exame);

    }

    private function insertTEP($file, $file_name, $dama_desktop_key, $params) {

        log_message('debug', 'insertTEP() >>> ' . $file);

        $bytes = $this->getBytes($file);

        $exame = $this->getObject();
        $exame->DamaDesktopKey = $dama_desktop_key;

        $exame->Tipo        = 'ECG';
        $exame->Motivo      = $this->getString($bytes, 1246); // offset 1246 ao 00
        $exame->Data        = $this->toDateDDMMAA($this->getString($bytes, 10)); // offset 10 ao 00
        $exame->Paciente    = $this->getString($bytes, 17); // offset 17 ao 00
        $exame->DataNasc    = $this->getString($bytes, 1045); // offset 1045 ao 1054
        $exame->Idade       = $this->getIdade($exame->DataNasc);
        $exame->Sexo        = substr($this->getString($bytes, 107), 0, 1); // offset 107 ao 00
        $exame->Altura      = $this->getAltura($this->getString($bytes, 117)); // offset 117 ao 00
        $exame->Peso        = $this->getString($bytes, 103); // offset 103 ao 00
        $exame->IMC         = $this->getIMC($exame->Peso, $exame->Altura);

        $exame->Medico      = $this->getString($bytes, 58); // offset 58 ao 00
        $exame->Observacao  = $this->getString($bytes, 1589) . ' ' . $this->getString($bytes, 860) . ' ' .
                              $this->getString($bytes, 891, 896) . ' ' . $this->getString($bytes, 1246);
        $exame->Arquivo     = $file_name;
        $exame->Empresa     = $this->getString($bytes, 1079);
        $exame->RG          = $this->getString($bytes, 977);
        $exame->CPF         = $this->getString($bytes, 998);
        $exame->Imagem      = ($params && $params['imagem']) ? $params['imagem'] : null;
		$exame->Funcao      = $this->getString($bytes, 1058); // offset 1058 ao 00

        $this->insertExame($exame);

    }

    private function getNomePaciente($nome){
        $nome = ltrim(rtrim(str_replace('-', '', $nome)));
        $nome = str_replace('Nascimento:', '', $nome);
        return $nome;
    }

    // letras com acentuação: '/^[\pL\pM\p{Zs}.-]+$/u'
    private function insertTXT($file, $file_name, $dama_desktop_key){

        log_message('debug', 'insertTXT() >>> ' . $file);

        $txt = $this->getInlineText($file);

        //log_message('debug', $txt);		// or : echo ( string ) $pdf ;

        $paciente = self::getNomePaciente(self::cutString($txt, 'Nome:'));
        $idade    = self::cutString($txt, 'Idade:', 'numeric');
        $sexo     = strpos($txt, 'Masculino') !== false ? 'M' : 'F';
        $indicacao = self::cutString($txt, 'Indicação:', 'numeric');

        $empresa   = self::cutString($txt, 'Email:');
        $empresa = str_replace('Indicação:', '', $empresa);
        $empresa = str_replace('Data Exame:', '', $empresa);

        $exame = $this->getObject();
        $exame->DamaDesktopKey = $dama_desktop_key;

        $exame->Tipo        = 'EEG';
        $exame->Motivo      = $indicacao;
        $exame->Data        = $this->toDate();
        $exame->Paciente    = $paciente;
        $exame->DataNasc    = $this->getNasc($exame->Data, $idade);
        $exame->Idade       = $idade;
        $exame->Sexo        = $sexo;
        $exame->Altura      = null;
        $exame->Peso        = null;
        $exame->IMC         = $this->getIMC($exame->Peso, $exame->Altura);

        $exame->Medico      = null;
        $exame->Observacao  = null;
        $exame->Arquivo     = $file_name;

        $exame->Empresa     = $empresa;

        //log_message('debug', print_r($exame, true));

        $this->insertExame($exame);


    }

    private function getInlineText($file){
        $handle = fopen($file, "r");
        if (!$handle) return '';
        $ret = '';
        while (($line = fgets($handle)) !== false)
            $ret .= $this->getString(trim($line));
        fclose($handle);
        return $ret;
    }

    private function dumpString($str){
        $ret = '';
        for($i = 0; $i < strlen($str); $i++)
            $ret .= ord($str[$i]) . '(' . $str[$i] . ').';
        return $ret;
    }

	private function cutStringFromTo($str, $from, $to){
		$posA = strpos($str, $from);
		$posB = strpos($str, $to);
		if ($posA === false || $posB === false) return null;
		$posA += strlen($from);
		$ret = ltrim(rtrim(substr($str, $posA, $posB - $posA)));
		$ret = preg_replace('!\s+!', ' ', $ret);
		return $ret;
	}
	
    private function cutString($str, $to, $modo = 'alpha', $space = true){

        //$str = $this->letters->noDiacritics($str);

        $pos = strpos($str, $to);

        if ($pos === false) return '';

        $pos += strlen($to);

        $cut = '';

        for ($i = $pos; $i < strlen($str); $i++){
            $char = $str[$i];

            if ($char == ' ') {
                if ($space) {
                    $cut .= $char;
                    continue;
                } else
                    break;
            }

            //if ($modo == 'alpha' && !preg_match('/^[a-zA-Z]$/', $char)) break;
            if ($modo == 'alpha' && preg_match('/^[0-9]$/', $char)) break;
            //if ($modo == 'alpha' && !ctype_alpha($char)) break;
            if ($modo == 'alphanum' && !ctype_alnum($char)) break; //&& !preg_match('/^[a-zA-Z0-9]$/', $char)) break;
            if ($modo == 'numeric') {
                if (!preg_match('/^[0-9]$/', $char) && $char !== '.' && $char !== ',') break;
            } 

            $cut .= $char;
        }

        return trim($cut);

    }

    private function getVersion($str){

        //$str = self::normalize($str);
        $str = self::removeCRLF($str);

        $pos = strpos($str, 'Impresso por');

        if ($pos === false) return '';

        $pos += 12;

        $cut = '';

        for ($i = $pos; $i < strlen($str); $i++){
            $char = $str[$i];

            if ($char == '-') {
                break;
            }
            $cut .= $char;
        }

        return str_replace(' ','', $cut);

    }

    private function normalize($str) {
        $ret = '';
        for ($i = 0; $i < strlen($str); $i++) {
            $char = $str[$i];
            $ret .= ord($char) == $this->LINEFEED ? ' ' : $char;
        }
        return $ret;
    }

    private function isVersion($version, $txt){
        $ver = self::getVersion($txt);
        return ($version === $ver);
    }

    private function isEspiro($txt){
        return strpos($txt, "Resultados de Teste de Funções pulmonares") !== false;
    }

    private function isWinspiroPRO($txt) {
        $txt = self::removeCRLF($txt);
        $pos = strpos($txt, 'WinspiroPRO');
        return ($pos !== false);
    }

    private function getNomeSobrenome($str) {
        $pos = strpos($str, " ");
        return substr($str, $pos + 1) . ' ' . substr($str, 0, $pos);
    }

    private function getNome($str){

        $str = preg_replace('/[0-9]+/', '', $str);

        $pos = strpos($str, "\n");

        if ($pos === false) return $str;

        $sobrenome = preg_replace('/\n/', '', substr($str, 0, $pos));
        $nome      = preg_replace('/\n/', '', substr($str, $pos + 1));

        $sobrenome = preg_replace("/ {2,}/", " ", $sobrenome);
        $nome      = preg_replace("/ {2,}/", " ", $nome);

        return preg_replace('/(WSP)/', '', trim($nome) . ' ' . trim($sobrenome));
    }


    private function insertPDF($file, $file_name, $dama_desktop_key, $params){

        log_message('debug', 'insertPDF() >>> ' . $file);
        
        $pdf	=  new PdfToText($file);
        $txt    = (string)$pdf -> Text;

        log_message('debug', 'insertPDF() >>> 1');

        if (self::isVersion("WinspiroPRO7.5.1", $txt)){
            self::insertPDF_WinspiroPRO751($txt, $file_name, $dama_desktop_key, $params);
            return;
        }

        log_message('debug', 'insertPDF() >>> 2');

        if (self::isVersion("WinspiroPRO1.05.8.1", $txt)){
            self::insertPDF_WinspiroPRO10581($txt, $file_name, $dama_desktop_key, $params);
            return;
        }

        log_message('debug', 'insertPDF() >>> 3');

        if (self::isVersion('WinspiroPRO1.06.4.0', $txt)){
            self::insertPDF_WinspiroPRO10640($txt, $file_name, $dama_desktop_key, $params);
            return;
        }

        log_message('debug', 'insertPDF() >>> 4');

        if (self::isVersion('WinspiroPRO1.05.9.0', $txt)){
            self::insertPDF_WinspiroPRO10590($txt, $file_name, $dama_desktop_key, $params);
            return;
        }

        log_message('debug', 'insertPDF() >>> 5');

        if (self::isVersion('WinspiroPRO1.05.4.0', $txt)){
            self::insertPDF_WinspiroPRO10540($txt, $file_name, $dama_desktop_key, $params);
            return;
        }

        log_message('debug', 'insertPDF() >>> 6');

        if (self::isVersion('WinspiroPRO1.05.0.1', $txt)){
            self::insertPDF_WinspiroPRO10501($txt, $file_name, $dama_desktop_key, $params);
            return;

        }

        log_message('debug', 'insertPDF() >>> 7');

        if (self::isVersion("WinspiroPRO1.06.5.0", $txt)){
            self::insertPDF_WinspiroPRO10650($txt, $file_name, $dama_desktop_key, $params);
            return;
        }

        log_message('debug', 'insertPDF() >>> 8');

        if (self::isVersion("WinspiroPRO1.06.7.0", $txt)){
            self::insertPDF_WinspiroPRO10670($txt, $file_name, $dama_desktop_key, $params);
            return;
        }

        log_message('debug', 'insertPDF() >>> 9');

        if (self::isVersion("WinspiroPRO1.07.3.0", $txt)){
            self::insertPDF_WinspiroPRO10730($txt, $file_name, $dama_desktop_key, $params);
            return;
        }

        log_message('debug', 'insertPDF() >>> 10');

        if (self::isVersion("WinspiroPRO1.05.1.0", $txt)){
            self::insertPDF_WinspiroPRO10510($txt, $file_name, $dama_desktop_key, $params);
            return;
        }

        log_message('debug', 'insertPDF() >>> 11');

        if (self::isEspiro($txt) || self::isWinspiroPRO($txt)){
            self::insertPDF_WinspiroPRO($txt, $file_name, $dama_desktop_key, $params);
            return;
        }

        log_message('debug', 'insertPDF() >>> 12');

        if (self::insertECG_HFECG($txt, $file_name, $dama_desktop_key, $params)) return;

        log_message('debug', 'insertPDF() >>> 13');

        if (self::insertECG_General_Hospital($txt, $file_name, $dama_desktop_key, $params)) return;

        log_message('debug', 'insertPDF() >>> 14');

        if (self::insertECG($pdf, $file_name, $dama_desktop_key, $params)) return;

        log_message('debug', 'insertPDF() >>> 15');

        if (self::insertPDF_Espiro($txt, $file_name, $dama_desktop_key, $params)) return;

        log_message('debug', 'insertPDF() >>> 16');

        if (self::insertPDF_COSMED($txt, $file_name, $dama_desktop_key, $params)) return;

        log_message('debug', 'insertPDF() >>> 17');

        if (self::insertPDF_EEG($txt, $file_name, $dama_desktop_key, $params)) return;

        log_message('debug', 'insertPDF() >>> 18');

        if (self::insertPDF_CardioBrasil($txt, $file_name, $dama_desktop_key, $params)) return;
		
        log_message('debug', 'insertPDF() >>> 19');

        if (self::insertPDF_HW_ECGV6_1036($txt, $file_name, $dama_desktop_key, $params)) return;

    }


	private function getDateAAAAMMDDHHMM($data){
		$data = preg_replace('/[^0-9]/', '', $data);	
		$aa = substr($data, 0, 4);
		$mm = substr($data, 4, 2);
		$dd = substr($data, 6, 2);
		return $dd . '/' . $mm . '/' . $aa;
	}

    private function insertPDF_HW_ECGV6_1036($txt, $file_name, $dama_desktop_key, $params) {

        log_message('debug', 'insertPDF_HW_ECGV6_1036() - 1');

        $t = str_replace(' ', '', self::removeCRLF($txt));
        if (strpos($t, 'EcgV6v1.0.3.6') === false || strpos($t, 'Heartware') === false) return false;
        
        log_message('debug', 'insertPDF_HW_ECGV6_1036() - 2');

        $txt = self::removeCRLF($txt);

        $pos = strpos($txt, '  -  ');
        if ($pos === false) return false; 

        log_message('debug', 'insertPDF_HW_ECGV6_1036() - 3');

        $paciente = substr($txt, 0, $pos);
        $idade    = self::cutString($txt, 'kg, ', 'numeric');
        $sexo     = '';
        $peso     = self::cutString($txt, 'm, ', 'numeric');
        $altura   = self::cutString($txt, '(', 'numeric');

        $empresa = null;
        $motivo =  null;

        $exame = $this->getObject();
        $exame->DamaDesktopKey = $dama_desktop_key;

        $exame->Tipo        = 'ECG';
		//$exame->SubTipo     = '';
        $exame->Motivo      = $motivo;
        $exame->Data        = $this->toDate();
        $exame->Paciente    = $paciente;
        $exame->DataNasc    = $this->getNasc($exame->Data, $idade);
        $exame->Idade       = $idade;
        $exame->Sexo        = $sexo;
        $exame->Altura      = $this->getAltura($altura);
        $exame->Peso        = $peso;
        $exame->IMC         = $this->getIMC($exame->Peso, $exame->Altura);

        $exame->Medico      = null;
        $exame->Observacao  = null;
        $exame->Arquivo     = $file_name;

        $exame->Empresa     = $empresa;
        $exame->Imagem      = ($params && $params['imagem']) ? $params['imagem'] : null;

        /**
         * REMOVER
         */
        //log_message('debug', 'insertPDF_HW_ECGV6_1036');
        //log_message('debug', print_r($exame, true));
        //return;

        $this->insertExame($exame);

        return true;


    }
    private function insertECG_HFECG($txt, $file_name, $dama_desktop_key, $params) {

        if (strpos($txt, "HFECG") === false) return false;
        
		$paciente = $this->getNomeSobrenome(self::cutStringFromTo($txt, "Nome :", "ID :"));
        $idade    = trim(self::cutStringFromTo($txt, "Idade :", "Nasc :"));
        $sexo     = trim(self::cutStringFromTo($txt, "Sexo :", "Idade :"));
        $sexo     = strpos($sexo, 'Fem') === false ? 'M' : 'F';
        $nasc     = trim(self::cutStringFromTo($txt, "Nasc :", "Data do Teste :"));
        $nasc     = str_replace('-', '/', $nasc);
        
        $data = $this->toDate();
        $pos = strpos($txt, "Data do Teste :");
        if ($pos !== false) {
            $data = substr($txt, $pos+15, 10);
            $data = str_replace('-', '/', $data);
        }
		
        $exame = $this->getObject();

        $exame->Tipo        = 'ECG';
		$exame->Empresa     = null;
        $exame->Data        = $data;
        $exame->Paciente    = $paciente;
        $exame->DataNasc    = $nasc;
        $exame->Idade       = $idade;
        $exame->Sexo        = $sexo;
        $exame->Altura      = null;
        $exame->Peso        = null;
        $exame->IMC         = null;
        $exame->Medico      = null;
        $exame->Observacao  = null;
        
        $exame->Arquivo        = $file_name;
        $exame->DamaDesktopKey = $dama_desktop_key;
        $exame->Imagem         = ($params && $params['imagem']) ? $params['imagem'] : null;

        $this->insertExame($exame);
		
        return true;
    }


//Thais / Leda
     private function insertECG_General_Hospital($txt, $file_name, $dama_desktop_key, $params) {

        if (strpos($txt, "General Hospital") === false) return false;
        
		$paciente = $this->getNomeSobrenome(self::cutStringFromTo($txt, "Nome :", "ID :"));
        $idade    = trim(self::cutStringFromTo($txt, "Idade :", "Nasc :"));
        $sexo     = trim(self::cutStringFromTo($txt, "Sexo :", "Idade :"));
        $sexo     = strpos($sexo, 'Fem') === false ? 'M' : 'F';
        $nasc     = trim(self::cutStringFromTo($txt, "Nasc :", "Data do Teste :"));
        $nasc     = str_replace('-', '/', $nasc);
        
        $data = $this->toDate();
        $pos = strpos($txt, "Data do Teste :");
        if ($pos !== false) {
            $data = substr($txt, $pos+15, 10);
            $data = str_replace('-', '/', $data);
        }
		
        $exame = $this->getObject();

        $exame->Tipo        = 'ECG';
		$exame->Empresa     = null;
        $exame->Data        = $data;
        $exame->Paciente    = $paciente;
        $exame->DataNasc    = $nasc;
        $exame->Idade       = $idade;
        $exame->Sexo        = $sexo;
        $exame->Altura      = null;
        $exame->Peso        = null;
        $exame->IMC         = null;
        $exame->Medico      = null;
        $exame->Observacao  = null;
        
        $exame->Arquivo        = $file_name;
        $exame->DamaDesktopKey = $dama_desktop_key;
        $exame->Imagem         = ($params && $params['imagem']) ? $params['imagem'] : null;

        $this->insertExame($exame);
		
        return true;
    }

	private function insertPDF_EEG($txt, $file_name, $dama_desktop_key, $params){
		
		$txt    = str_replace(array("\r\n", "\n", "\r"), '', $txt);
		$txt    = preg_replace("/[^A-Za-z0-9 :\/-]/i", "", $txt);

        //file_put_contents("./pdf.txt", $txt);
		
		//log_message('debug', "insertPDF_EEG");
		//log_message('debug', $txt);
		//log_message('debug', "---------------------------");
		//return;
		
		$paciente = null; $sexo = null; $idade = null; $altura = null; $peso = null;
		
		$ver = "EN";
		
		$id = self::cutStringFromTo($txt, "Name :", "Sex :");
		
		if (!$id) {
			$ver = "PT";
			$id = self::cutStringFromTo($txt, "Nome :", "Sexo :");
		}
		
		if (!$id) return false;
		
		if ($ver == "EN"){
			$paciente = self::cutStringFromTo($txt, "Name :", "Sex :");
			$sexo = self::cutStringFromTo($txt, "Sex :", "Age :");
			$sexo = strtolower($sexo);
			$sexo = $sexo == "male" ? "M" : "F";
			$idade = self::cutStringFromTo($txt, "Age :", "Date :");
			$dataExame = self::cutStringFromTo($txt, "Date :", "ID:");
		} else {
			$paciente = self::cutStringFromTo($txt, "Nome :", "Sexo :");
			$sexo = self::cutStringFromTo($txt, "Sexo :", "Idade:");
			$sexo = strtolower($sexo);
			$sexo = $sexo == "feminino" ? "F" : "M";
			$idade = self::cutStringFromTo($txt, "Idade:", "Data:");
			$dataExame = self::cutStringFromTo($txt, "Data:", "Exame:");
		}
		
		if (empty($paciente)) return false;
		
        log_message('debug', 'insertPDF_EEG() >>> ' . $file_name);

        $paciente = preg_replace('/[^a-zA-Z ]/', '', $paciente);		
		
        $exame = $this->getObject();

        $exame->DamaDesktopKey = $dama_desktop_key;
        $exame->Tipo        = 'EEG';
        $exame->Motivo      = null;
        $exame->Data        = $this->getDateAAAAMMDDHHMM($dataExame);
        $exame->Paciente    = $paciente;
        $exame->DataNasc    = $this->getNasc($this->toDate(), $idade);
        $exame->Idade       = trim($idade);
        $exame->Sexo        = $sexo;
        $exame->Altura      = $altura / 100;
        $exame->Peso        = $peso;
        $exame->IMC         = $this->getIMC($exame->Peso, $exame->Altura);

        $exame->Medico      = null;
        $exame->Observacao  = null;
        $exame->Arquivo     = $file_name;

        $exame->Empresa     = null; //ltrim(rtrim($empresa));
        $exame->Imagem      = ($params && $params['imagem']) ? $params['imagem'] : null;

		log_message('debug', '>>>>>>>>>>');
        log_message('debug', print_r($exame, true));
        log_message('debug', '<<<<<<<<<<');

        $this->insertExame($exame);
		
		return true;
		
	}

	private function insertPDF_COSMED($txt, $file_name, $dama_desktop_key, $params){
		
		$txt = str_replace(array("\r\n", "\n", "\r"), '', $txt);
        
		//log_message('debug', '#############');
        //log_message('debug', $txt);
        //log_message('debug', '#############');
		//return;

		$id = strpos($txt, 'COSMED');
		if ($id === false) return false;
		
		$paciente = self::cutStringFromTo($txt, "Primeiro Nome:", "ID:") . ' ' .
					self::cutStringFromTo($txt, "Sobrenome:", "Primeiro Nome:");
		
		$dataExame = self::cutStringFromTo($txt, "Data:", "Previs");
		$dataNasc  = self::cutStringFromTo($txt, "Data de nascimento:", "Sexo :");
		$peso = self::cutStringFromTo($txt, "Peso (kg):", "Altura (cm):");
		$altura = self::cutStringFromTo($txt, "Altura (cm):", "BMI (");
		$sexo = self::cutStringFromTo($txt, "Sexo :", "Corre");
		$empresa = self::cutStringFromTo($txt, "Empresa:", "Idade:");
		
        $exame = $this->getObject();

        $exame->DamaDesktopKey = $dama_desktop_key;
        $exame->Tipo        = 'ESPIRO';
        $exame->Motivo      = null;
        $exame->Data        = $dataExame; //null;// $this->getDateAAAAMMDDHHMM($dataExame);
        $exame->Paciente    = $paciente;
        $exame->DataNasc    = $dataNasc;//$this->getNasc($this->toDate(), $idade);
        $exame->Idade       = $this->getIdadeDDMMAAAA($dataNasc); //null; //trim($idade);
        $exame->Sexo        = substr(trim($sexo), 0, 1); //$sexo;
        $exame->Altura      = $altura; //$altura / 100;
        $exame->Peso        = $peso; //$peso;
        $exame->IMC         = $this->getIMC($exame->Peso, $exame->Altura);

        $exame->Medico      = null;
        $exame->Observacao  = null;
        $exame->Arquivo     = $file_name;

        $exame->Empresa     = $empresa; //ltrim(rtrim($empresa));
        $exame->Imagem      = ($params && $params['imagem']) ? $params['imagem'] : null;

		//log_message('debug', '>>>>>>>>>>');
        //log_message('debug', print_r($exame, true));
        //log_message('debug', '<<<<<<<<<<');
		
		$this->insertExame($exame);

        return true;

	}
	
	private function insertPDF_Espiro($txt, $file_name, $dama_desktop_key, $params){
		
		$txt    = str_replace(array("\r\n", "\n", "\r"), '', $txt);
		$txt    = preg_replace("/[^A-Za-z0-9 :\/-]/i", "", $txt);
		
		//log_message('debug', "insertPDF_Espiro");
		//log_message('debug', $txt);
		//log_message('debug', "---------------------------");
		
		$paciente = null; $sexo = null; $idade = null; $altura = null; $peso = null;
		
		$ver = "EN";
		
		$id = strpos($txt, 'vital capacity report');
		
		if ($id === false) {
			$ver = "PT";	
			$id = strpos($txt, 'rio de capacidade vital');
		}
		
		if ($id === false) return false;
		
		if ($ver == "EN"){
			$paciente = self::cutStringFromTo($txt, "name: ", "Gender:");
			$sexo = self::cutStringFromTo($txt, "Gender:", "Age:");
			$sexo = $sexo == "male" ? "M" : "F";
			$idade = self::cutStringFromTo($txt, "Age:", "Nation:");
			$dataExame = self::cutStringFromTo($txt, "Time:", "FVC:");
			$altura = self::cutStringFromTo($txt, "Height:", "cmWeight:");
			$peso = self::cutStringFromTo($txt, "cmWeight:", "k gTime:");
		} else {
			$paciente = self::cutStringFromTo($txt, "Nome:", "Sexo:");
			$sexo = self::cutStringFromTo($txt, "Sexo:", "Idade:");
			$sexo = strtolower($sexo);
			$sexo = $sexo == "feminino" ? "F" : "M";
			$idade = self::cutStringFromTo($txt, "Idade:", "Nao:");
			$dataExame = self::cutStringFromTo($txt, "Tempo:", "CVF:");
			$altura = self::cutStringFromTo($txt, "Altura:", "cmPeso:");
			$peso = self::cutStringFromTo($txt, "cmPeso:", "kgTempo:");
		}
		
		if (empty($paciente)) return false;
		
		$paciente = preg_replace('/[^a-zA-Z ]/', '', $paciente);		
		
        $exame = $this->getObject();

        $exame->DamaDesktopKey = $dama_desktop_key;
        $exame->Tipo        = 'ESPIRO';
        $exame->Motivo      = null;
        $exame->Data        = $this->getDateAAAAMMDDHHMM($dataExame);
        $exame->Paciente    = $paciente;
        $exame->DataNasc    = $this->getNasc($this->toDate(), $idade);
        $exame->Idade       = trim($idade);
        $exame->Sexo        = $sexo;
        $exame->Altura      = $altura / 100;
        $exame->Peso        = $peso;
        $exame->IMC         = $this->getIMC($exame->Peso, $exame->Altura);

        $exame->Medico      = null;
        $exame->Observacao  = null;
        $exame->Arquivo     = $file_name;

        $exame->Empresa     = null; //ltrim(rtrim($empresa));
        $exame->Imagem      = ($params && $params['imagem']) ? $params['imagem'] : null;

		//log_message('debug', '>>>>>>>>>>');
        //log_message('debug', print_r($exame, true));
        //log_message('debug', '<<<<<<<<<<');

        $this->insertExame($exame);
		
		return true;
	}
	
	
	private function insertECG($pdf, $file_name, $dama_desktop_key, $params){
        $ver = $pdf->PdfVersion;
        $data = $pdf->Title;
        if ($ver == "1.3") return $this->insertECG13($pdf, $file_name, $dama_desktop_key, $params);
        if ($ver == "1.4") return $this->insertECG14($pdf, $file_name, $dama_desktop_key, $params);
		return false;
	}

	private function insertECG13($pdf, $file_name, $dama_desktop_key, $params){
		$txt = preg_replace("/[\n\r]/","",$pdf);

        $data  = self::cutStringFromTo($txt, "Rhythm Report", "ID   :");
		$data = preg_replace('/[^0-9]/', '', $data);
		$data = $this->toDateAAAAMMDD($data);
		
		$nome = self::cutStringFromTo($txt, "Name : ", "Surname : ") . ' ' .
				self::cutStringFromTo($txt, "Surname : ", "Age : ");
				
		$idade = self::cutStringFromTo($txt, "Age : ", "yrs.");
		
		$sexo = self::cutStringFromTo($txt, "Sex : ", "H : ");
		$sexo = substr(strtoupper($sexo),0,1);
		
		$altura = self::cutStringFromTo($txt, "H : ", "cm");
		$peso = self::cutStringFromTo($txt, "W : ", "kg");

        $exame = $this->getObject();

        $exame->DamaDesktopKey = $dama_desktop_key;
        $exame->Tipo        = 'ECG';
        $exame->Motivo      = null;
        $exame->Data        = $this->toDate();
        $exame->Paciente    = $nome;
        $exame->DataNasc    = $this->getNasc($exame->Data, $idade);
        $exame->Idade       = trim($idade);
        $exame->Sexo        = trim($sexo);
        $exame->Altura      = $altura;
        $exame->Peso        = $peso;
        $exame->IMC         = $this->getIMC($exame->Peso, $exame->Altura);

        $exame->Medico      = null;
        $exame->Observacao  = null;
        $exame->Arquivo     = $file_name;

        $exame->Empresa     = ltrim(rtrim($empresa));
        $exame->Imagem      = ($params && $params['imagem']) ? $params['imagem'] : null;

        $this->insertExame($exame);
		
        //log_message('debug', '>>>>>>>>>>');
        //log_message('debug', print_r($exame, true));
        //log_message('debug', '<<<<<<<<<<');
		
		return true;
	}
	
    private function insertECG14($pdf, $file_name, $dama_desktop_key, $params){

        //$data = "JOSE LUZIVAN VIEIRA DE PAULA 5 4 M 2 DAMA TELEMEDICINA - 03-06-2017"; // REMOVER

        $data = $pdf->Title;

        $paciente = ""; $idade = ""; $sexo  = ""; $motivo = 1; $empresa = ""; $flag = 0;

        for ($i = 0; $i < strlen($data); $i++){
            $c = substr($data, $i, 1);
            if ($c == '-') break;
            if ($flag == 0) {
                if (is_numeric($c)) $flag = 1;
                else $paciente .= $c;
            }
            if ($flag == 1) {
                if ($c == ' ') continue;
                if (!is_numeric($c)) $flag = 2;
                else $idade .= trim($c);
            }
            if ($flag == 2) {
                if ($c == ' ') continue;
                if (is_numeric($c)) $flag = 3;
                else $sexo .= $c;
            }
            if ($flag == 3) {
                if ($c == ' ') continue;
                $motivo = $c; $flag = 4; continue;
            }
            if ($flag == 4) { $empresa .= $c; }
        }

        if (!is_numeric($idade) || ($sexo !== "M" && $sexo !==  "F")) return false;

        $exame = $this->getObject();

        $exame->DamaDesktopKey = $dama_desktop_key;
        $exame->Tipo        = 'ECG';
        $exame->Motivo      = trim($motivo);
        $exame->Data        = $this->toDate();
        $exame->Paciente    = ltrim(rtrim($paciente));
        $exame->DataNasc    = $this->getNasc($exame->Data, $idade);
        $exame->Idade       = trim($idade);
        $exame->Sexo        = trim($sexo);
        $exame->Altura      = null;
        $exame->Peso        = null;
        $exame->IMC         = null; // $this->getIMC($exame->Peso, $exame->Altura);

        $exame->Medico      = null;
        $exame->Observacao  = null;
        $exame->Arquivo     = $file_name;

        $exame->Empresa     = ltrim(rtrim($empresa));
        $exame->Imagem      = ($params && $params['imagem']) ? $params['imagem'] : null;

        $this->insertExame($exame);

        //log_message('debug', '>>>>>>>>>>');
        //log_message('debug', print_r($exame, true));
        //log_message('debug', '<<<<<<<<<<');

		return true;
		
    }

    private function insertPDF_WinspiroPRO10650($txt, $file_name, $dama_desktop_key, $params){
        $this->insertPDF_WinspiroPRO10640($txt, $file_name, $dama_desktop_key);
        log_message('debug', ">>> WINSPIROPRO10650 <<<");
    }

    private function removeCRLF($str) {

        $ret = '';
        for ($i = 0; $i < strlen($str); $i++) {
            $char = $str[$i];
			if (ord($char) == 10) $val = ' ';
			else if (ord($char) == 13) $val = '';
			else $val = $char;
            $ret .= $val;
        }
		
        return $ret;
    }
	
    private function insertPDF_WinspiroPRO10670($txt, $file_name, $dama_desktop_key, $params){

        $paciente = self::getNome(self::cutString($txt, 'Grupo Paciente'));
        $idade    = self::cutString($txt, 'Idade', 'numeric');
        $sexo     = strpos($txt, 'Masculino') !== false ? 'M' : 'F';
        $peso     = self::cutString($txt, 'kg', 'numeric');
        $altura   = self::cutString($txt, 'cm', 'numeric');

        $empresa = self::cutStringFromTo(self::removeCRLF($txt), 'EMPRESA:', 'FUNÇÃO');
        $motivo =  null;

        $exame = $this->getObject();

        $exame->DamaDesktopKey = $dama_desktop_key;

        $exame->Tipo        = 'ESPIRO';
		$exame->SubTipo     = 'ESPIRO OCUPACIONAL';
        $exame->Motivo      = $motivo;
        $exame->Data        = $this->toDate();
        $exame->Paciente    = $paciente;
        $exame->DataNasc    = $this->getNasc($exame->Data, $idade);
        $exame->Idade       = $idade;
        $exame->Sexo        = $sexo;
        $exame->Altura      = $this->getAltura($altura);
        $exame->Peso        = $peso;
        $exame->IMC         = $this->getIMC($exame->Peso, $exame->Altura);

        $exame->Medico      = null;
        $exame->Observacao  = null;
        $exame->Arquivo     = $file_name;

        $exame->Empresa     = $empresa;
        $exame->Imagem      = ($params && $params['imagem']) ? $params['imagem'] : null;

        /**
         * REMOVER
         */
        //log_message('debug', '### 10670 ###');
        //log_message('debug', print_r($exame, true));
        //return;

        $this->insertExame($exame);


	}
	
    private function insertPDF_WinspiroPRO751($txt, $file_name, $dama_desktop_key, $params){

        $this->insertPDF_WinspiroPRO10640($txt, $file_name, $dama_desktop_key, $params);
        //$this->insertPDF_WinspiroPRO10590($txt, $file_name, $dama_desktop_key, $params);
        //$this->insertPDF_WinspiroPRO10540($txt, $file_name, $dama_desktop_key, $params);
        //$this->insertPDF_WinspiroPRO10501($txt, $file_name, $dama_desktop_key, $params);
        //$this->insertPDF_WinspiroPRO10650($txt, $file_name, $dama_desktop_key, $params);
        //$this->insertPDF_WinspiroPRO10730($txt, $file_name, $dama_desktop_key, $params);

        log_message('debug', ">>> WINSPIROPRO751 <<<");
		
    }

    private function insertPDF_WinspiroPRO10581($txt, $file_name, $dama_desktop_key, $params){
        //$this->insertPDF_WinspiroPRO10730($txt, $file_name, $dama_desktop_key, $params);
        $this->insertPDF_WinspiroPRO10640($txt, $file_name, $dama_desktop_key, $params);
        //$this->insertPDF_WinspiroPRO10590($txt, $file_name, $dama_desktop_key, $params);
        //$this->insertPDF_WinspiroPRO10540($txt, $file_name, $dama_desktop_key, $params);
        //$this->insertPDF_WinspiroPRO10501($txt, $file_name, $dama_desktop_key, $params);
        //$this->insertPDF_WinspiroPRO10650($txt, $file_name, $dama_desktop_key, $params);
	}	
	
    private function insertPDF_WinspiroPRO10510($txt, $file_name, $dama_desktop_key, $params){
        log_message('debug', ">>> WINSPIROPRO10510 <<<");
        $this->insertPDF_WinspiroPRO10501($txt, $file_name, $dama_desktop_key, $params);
	}

    private function insertPDF_WinspiroPRO($txt, $file_name, $dama_desktop_key, $params){

		log_message('debug', ">>> WinspiroPRO BUILDER <<<");

        $builder = new WinspiroProBuilder();
		$exame = $builder->getExame($txt);
		if (!$exame) return false;
        
        /**
         * REMOVER
         */
        log_message('debug', 'insertPDF_WinspiroPRO');
        log_message('debug', print_r($exame, true));

        $exame->Arquivo = $file_name;
        $exame->DamaDesktopKey = $dama_desktop_key;
        $exame->Imagem  = ($params && $params['imagem']) ? $params['imagem'] : null;

		$this->insertExame($exame);

        return true;

    }

    private function insertPDF_CardioBrasil($txt, $file_name, $dama_desktop_key, $params){

		$builder = new CardioBrasilBuilder();
		$exame = $builder->getExame($txt);
		if ($exame == null) return false;
		
        /**
         * REMOVER
         */
        log_message('debug', 'insertPDF_CardioBrasil');
        log_message('debug', print_r($exame, true));
        //return;

		//log_message('debug', ">>> CARDIOBRASIL BUILDER <<<");

        $exame->Arquivo = $file_name;
        $exame->DamaDesktopKey = $dama_desktop_key;
        $exame->Imagem  = ($params && $params['imagem']) ? $params['imagem'] : null;

		$this->insertExame($exame);

        return true;

    }

    private function insertPDF_WinspiroPRO10730($txt, $file_name, $dama_desktop_key, $params){

        $paciente = self::getNome(self::cutString($txt, 'Grupo Paciente'));
        $idade    = self::cutString($txt, 'Idade', 'numeric');
        $sexo     = strpos($txt, 'Masculino') !== false ? 'M' : 'F';
        $peso     = self::cutString($txt, 'kg', 'numeric');
        $altura   = self::cutString($txt, 'cm', 'numeric');

        $empresa = self::cutString($txt, 'EMPRESA:');
        $motivo =  null;

        $exame = $this->getObject();
        $exame->DamaDesktopKey = $dama_desktop_key;

        $exame->Tipo        = 'ESPIRO';
		$exame->SubTipo     = 'ESPIRO OCUPACIONAL';
        $exame->Motivo      = $motivo;
        $exame->Data        = $this->toDate();
        $exame->Paciente    = $paciente;
        $exame->DataNasc    = $this->getNasc($exame->Data, $idade);
        $exame->Idade       = $idade;
        $exame->Sexo        = $sexo;
        $exame->Altura      = $this->getAltura($altura);
        $exame->Peso        = $peso;
        $exame->IMC         = $this->getIMC($exame->Peso, $exame->Altura);

        $exame->Medico      = null;
        $exame->Observacao  = null;
        $exame->Arquivo     = $file_name;

        $exame->Empresa     = $empresa;
        $exame->Imagem      = ($params && $params['imagem']) ? $params['imagem'] : null;

        /**
         * REMOVER
         */
        //log_message('debug', '>>> 10730 <<<');
        //log_message('debug', print_r($exame, true));
        //return;

        $this->insertExame($exame);
    }

    private function insertPDF_WinspiroPRO10640($txt, $file_name, $dama_desktop_key, $params){

        $paciente = self::getNome(self::cutString($txt, 'Grupo Paciente'));
        $idade    = self::cutString($txt, 'Idade', 'numeric');
        $sexo     = strpos($txt, 'Masculino') !== false ? 'M' : 'F';
        $peso     = self::cutString($txt, 'kg', 'numeric');
        $altura   = self::cutString($txt, 'cm', 'numeric');

        $empresa = self::cutString($txt, 'EMPRESA:');
        $motivo =  null;

        $exame = $this->getObject();
        $exame->DamaDesktopKey = $dama_desktop_key;

        $exame->Tipo        = 'ESPIRO';
		$exame->SubTipo     = 'ESPIRO OCUPACIONAL';
        $exame->Motivo      = $motivo;
        $exame->Data        = $this->toDate();
        $exame->Paciente    = $paciente;
        $exame->DataNasc    = $this->getNasc($exame->Data, $idade);
        $exame->Idade       = $idade;
        $exame->Sexo        = $sexo;
        $exame->Altura      = $this->getAltura($altura);
        $exame->Peso        = $peso;
        $exame->IMC         = $this->getIMC($exame->Peso, $exame->Altura);

        $exame->Medico      = null;
        $exame->Observacao  = null;
        $exame->Arquivo     = $file_name;

        $exame->Empresa     = $empresa;
        $exame->Imagem      = ($params && $params['imagem']) ? $params['imagem'] : null;

        /**
         * REMOVER
         */
        //log_message('debug', '### 10640 ###');
        //log_message('debug', print_r($exame, true));
        //return;

        $this->insertExame($exame);

    }

    private function insertPDF_WinspiroPRO10590($txt, $file_name, $dama_desktop_key, $params){
		$_txt = str_replace(PHP_EOL, '', $txt);
        $paciente = self::getNome(self::cutString($txt, 'Grupo Paciente'));
        $idade    = self::cutString($_txt, 'Idade', 'numeric');
        $sexo     = strpos($txt, 'Masculino') !== false ? 'M' : 'F';
        $peso     = self::cutString($txt, 'kg', 'numeric');
        $altura   = self::cutString($txt, 'cm', 'numeric');

        $empresa = self::cutString($txt, 'EMPRESA:');
        $motivo =  null;

        $exame = $this->getObject();
        $exame->DamaDesktopKey = $dama_desktop_key;

        $exame->Tipo        = 'ESPIRO';
		$exame->SubTipo     = 'ESPIRO OCUPACIONAL';
        $exame->Motivo      = $motivo;
        $exame->Data        = $this->toDate();
        $exame->Paciente    = $paciente;
        $exame->DataNasc    = $this->getNasc($exame->Data, $idade);
        $exame->Idade       = $idade;
        $exame->Sexo        = $sexo;
        $exame->Altura      = $this->getAltura($altura);
        $exame->Peso        = $peso;
        $exame->IMC         = $this->getIMC($exame->Peso, $exame->Altura);

        $exame->Medico      = null;
        $exame->Observacao  = null;
        $exame->Arquivo     = $file_name;

        $exame->Empresa     = $empresa;
        $exame->Imagem      = ($params && $params['imagem']) ? $params['imagem'] : null;

        /**
         * REMOVER
         */
        //log_message('debug', '### 10590 ###');
        //log_message('debug', print_r($exame, true));
        //return;

        $this->insertExame($exame);

    }

    private function insertPDF_WinspiroPRO10540($txt, $file_name, $dama_desktop_key, $params){

        $txt = self::normalize($txt);

        //log_message('debug', $txt);

        $sobrenome = self::cutString($txt, 'Paciente', 'alphanum');
        $nome      = self::cutString($txt, 'Nome', 'alpha', false);

        $paciente  = self::getNome($sobrenome . "\n" . $nome);

        $idade = self::cutString($txt, 'Idade', 'numeric');
        $sexo = strpos($txt, 'Masculino') !== false ? 'M' : 'F';

        $data = self::cutString($txt, 'cm', 'numeric');
        $peso  = substr($data, 0, 2);
        $altura  = substr($data, 2);

        $empresa = self::cutString($txt, 'EMPRESA:');
        $motivo =  null;

        $exame = $this->getObject();
        $exame->DamaDesktop_Key = $dama_desktop_key;

        $exame->Tipo        = 'ESPIRO';
		$exame->SubTipo     = 'ESPIRO OCUPACIONAL';
        $exame->Motivo      = $motivo;
        $exame->Data        = $this->toDate();
        $exame->Paciente    = $paciente;
        $exame->DataNasc    = $this->getNasc($exame->Data, $idade);
        $exame->Idade       = $idade;
        $exame->Sexo        = $sexo;
        $exame->Altura      = $this->getAltura($altura);
        $exame->Peso        = $peso;
        $exame->IMC         = $this->getIMC($exame->Peso, $exame->Altura);

        $exame->Medico      = null;
        $exame->Observacao  = null;
        $exame->Arquivo     = $file_name;

        $exame->Empresa     = $empresa;
        $exame->Imagem      = ($params && $params['imagem']) ? $params['imagem'] : null;

        /**
         * REMOVER
         */
        //log_message('debug', '### 10540 ###');
        //log_message('debug', print_r($exame, true));
        //return;

        $this->insertExame($exame);

    }
    private function getPaciente_WinspiroPRO10501($txt){
        preg_match('/Nome?(.*)Idade/', $txt, $match);
        $nome = trim($match[1]);
        preg_match('/[0-9]{4}.*[0-9]{2}\/[0-9]{2}\/[0-9]{4}[Feminino|Masculino]/', $txt, $match);

        $sobrenome = trim($match[0]);
        $sobrenome = preg_replace('/[0-9]{2}\/[0-9]{2}\/[0-9]{4}[Feminino|Masculino]/', '', $sobrenome);
        $sobrenome = preg_replace('/[0-9]{4}\-\s\p{L}*|\s/', '', $sobrenome);
		$nome = $nome . ' ' . $sobrenome;
		$nome = preg_replace('/[0-9]+/', '', $nome);
        return $nome;
    }

    private function insertPDF_WinspiroPRO10501($txt, $file_name, $dama_desktop_key, $params) {

        $txt = self::removeCRLF($txt);

        $exame = $this->getObject();
        $exame->DamaDesktopKey = $dama_desktop_key;

        $paciente = self::getPaciente_WinspiroPRO10501($txt);

        $data = self::cutString($txt, 'cm', 'numeric');
        $peso  = substr($data, 0, 2);
        $altura  = substr($data, 2);
        $idade = self::cutString($txt, 'Idade', 'numeric');

        $sexo = strpos($txt, 'Masculino') !== false ? 'M' : 'F';

        $empresa = self::cutString($txt, 'EMPRESA:');
        $motivo   = null;

        $exame->Tipo        = 'ESPIRO';
		$exame->SubTipo     = 'ESPIRO OCUPACIONAL';
        $exame->Motivo      = $motivo;
        $exame->Data        = $this->toDate();
        $exame->Paciente    = $paciente;
        $exame->DataNasc    = $this->getNasc($exame->Data, $idade);
        $exame->Idade       = $idade;
        $exame->Sexo        = $sexo;
        $exame->Altura      = $this->getAltura($altura);
        $exame->Peso        = $peso;
        $exame->IMC         = $this->getIMC($exame->Peso, $exame->Altura);

        $exame->Medico      = null;
        $exame->Observacao  = null;
        $exame->Arquivo     = $file_name;

        $exame->Empresa     = $empresa;
        $exame->Imagem      = ($params && $params['imagem']) ? $params['imagem'] : null;

        /**
         * REMOVER
         */
        //log_message('debug', '### 10501 ###');
        //log_message('debug', print_r($exame, true));
        //return;

        $this->insertExame($exame);

    }

    private function getMotivo($id, $MAX_MOTIVO){
        if (!$id) return null;
        try {
            $id = (int)$id;
            return ($id > 0 && $id <= $MAX_MOTIVO) ? $id : null;
        } catch (Exception $e) {
            return null;
        }
    }

    private function hasValue($id){
        if (!$id) return false;
        return (!empty((string)$id));
    }

    private function getOuterLeft($target){
        $pos = strpos($target, '[');
        if (!$pos) return $target;
        return substr($target, 0, $pos);
    }

    private function getOuterRight($target){
        $pos = strpos($target, ']');
        if (!$pos) return "";
        return substr($target, $pos + 1);
    }

    private function getInner($target){
        $pos_a = strpos($target, '[');
        $pos_b = strpos($target, ']');
        if ($pos_a === false || $pos_b == false) return "";
        return substr($target, $pos_a + 1, $pos_b - $pos_a - 1);
    }

    private function getCRCFields($lote){

        $dt_nasc = '';
        if ($lote->Tipo != 'ESPIRO') $dt_nasc = str_replace(' ', '', strtoupper(trim($lote->DataNasc))) . '#';
		if ($lote->Tipo == 'EEG') {
			$lote->Peso = 0; 
			$lote->Altura = 0;
		}

		//$sub_tipo = strtoupper(trim($lote->SubTipo));
		$sub_tipo = $lote->SubTipo ? strtoupper(trim($lote->SubTipo)) : "";
		$sub_tipo = strlen($sub_tipo) > 0 ? $sub_tipo . '#' : "";
		
		$clinica_id = $lote->Clinica_id ? $lote->Clinica_id : $this->getClienteDoExame($lote);
		
        $ret = str_replace(' ', '', strtoupper(trim($lote->Tipo))) . '#' .
			   $sub_tipo .
               str_replace(' ', '', strtoupper(trim($lote->Motivo))) . '#' .
               str_replace(' ', '', strtoupper(trim($lote->Paciente))) . '#' .
               //str_replace(' ', '', strtoupper(trim($lote->Empresa))) . '#' .
               $dt_nasc .
               str_replace(' ', '', strtoupper(trim($lote->Idade))) .  '#' .
               str_replace(' ', '', strtoupper(trim($lote->Sexo))) .  '#' .
               str_replace(' ', '', strtoupper(trim($lote->Altura))) .  '#' .
               str_replace(' ', '', strtoupper(trim($lote->Peso))) .  '#' .
               str_replace(' ', '', strtoupper(trim($lote->Empresa))) . '#' .
			   $clinica_id;

        log_message('DEBUG', 'CRC String: >>>> ' . $ret);

        return $ret;
    }

    private function getClienteDoExame($exame){
		
        if (!$exame->DamaDesktopKey) {
			
			return UserSession::user("id");
		}

        $clinica = $this->usuarios_model->get_clinica_by_key($exame->DamaDesktopKey);

        if (!$clinica) {

			return null;
		}
		
		UserSession::getInstance()->setSession((array)$clinica);

		$id = $clinica->id;

        return $id;
    }

    private function PNGShorter($name) {
        if (!$name) return false;
        if (!Self::$PNG_SHORTER) return false;

        $name = str_replace('.pdf', '', strtolower($name));
        $name = (substr(php_uname(), 0, 7) == "Windows") ? str_replace('/', '\\', $name) : $name;
		$path = realpath(config_item('upload_folder'));

        $app_name = "convert";

        if (substr(php_uname(), 0, 7) == "Windows") {
            $app_name = $path . DIRECTORY_SEPARATOR . "magick.exe";
        }

        $cmd = $app_name . ' "' . $name . '.png" -resize "50%" -density "72x72" "' . $name . '-short.png"';
		
        log_message("debug", "======================= PNGShorter ==========================");
		log_message("debug", $cmd);
		log_message("debug", "-------------------------------------------------------------");

        $ret = array();
        exec($cmd . ' 2>&1', $output, $ret);

        if (file_exists($name . "-short.png")) {
            unlink($name . ".png");
            rename($name . "-short.png", $name . ".png");
        }

        return true;

    }

	private function PDF2PNG($name, $pagina = 1){
		if (!$name) return false;
		
		$name = (substr(php_uname(), 0, 7) == "Windows") ? str_replace('/', '\\', $name) : $name;
		
		$path = realpath(config_item('upload_folder'));
		$sep = DIRECTORY_SEPARATOR;
		$app_name  = $path . $sep . "pdf2png.jar" ;
		
		$cmd = "java -jar " . $app_name . " \"" . $name . "\"" . " " . $pagina;
		
		$ret = array();
		exec($cmd, $ret); // . " > /dev/null &");
		log_message("debug", "======================= PDF2PNG ==========================");
		log_message("debug", $cmd);
		log_message("debug", "----------------------------------------------------------");
		foreach($ret as $r){
			//log_message("debug", $r);
			if ($r == "SUCESSO") {
                $this->PNGShorter($name);
				return true;
			}
		}
		log_message("debug", "==========================================================");
		return false;
		
	}
	
	private function getImageFromFile($name){
		$sep = DIRECTORY_SEPARATOR;
		$path = realpath(config_item('upload_folder') . $sep . "exames" . $sep);
		$arquivo = $path . $sep . $name;
        if (preg_match('/(\.pdf)/', strtolower($arquivo)) == 1) {
			if (self::PDF2PNG($arquivo)){
				$nome_antigo = str_replace('.pdf', '.png', strtolower($name));
				$nome_novo = str_replace(' ', '_', $nome_antigo);
				rename(
					$path . $sep . $nome_antigo,
					$path . $sep . $nome_novo
				);
				return $nome_novo; // str_replace('.pdf', '.png', strtolower($name));
			}
			return null;
		}

		return null;
		
	}
	
    private function insertExame($lote){

            //log_message('debug', '>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>');
            //log_message('debug', print_r($lote, true));
            //log_message('debug', '<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<');
			//return;

			if (!isset($lote->Paciente) || trim($lote->Paciente) === '') return;

            $MOTIVO_PADRAO  = 6;
            $MAX_MOTIVO     = 10;
            $MEDICO_PADRAO  = 1;
            $EMPRESA_PADRAO = 1;

            $data_exame = parse_date_to_mysql($lote->Data);
            $data_nascimento = $lote->DataNasc ? parse_date_to_mysql($lote->DataNasc) : parse_date_to_mysql($this->getNasc($lote->Data, $lote->Idade));

            $arquivo_nome = $lote->Arquivo;

            $empresa_id = $EMPRESA_PADRAO;

            if ($this->hasValue($lote->Empresa)){
                $empresa = array();
                $empresa['nome'] = mb_convert_case($lote->Empresa, MB_CASE_UPPER);
                $empresa_id = $this->empresas_model->insert($empresa);
            }

            $paciente = array();
            $paciente['nome'] = mb_convert_case($lote->Paciente, MB_CASE_UPPER);

            $paciente['cpf'] = $lote->CPF;
            $paciente['cpf'] = preg_replace( '/[^0-9]/', '', $paciente['cpf']);
            $paciente['rg']  = $lote->RG;
            $paciente['telefone'] = "";
            $paciente['nascimento'] = $data_nascimento;
            $paciente["sexo"] = $lote->Sexo; //  ? (string)$lote->Sexo : null;
            $paciente['empresa_id'] = $empresa_id;
			$paciente['funcao'] = $lote->Funcao;
	
            $paciente_id = $this->pacientes_model->insert($paciente);

			$cliente_id = $lote->Clinica_id ? $lote->Clinica_id : $this->getClienteDoExame($lote);
			
            $exame = array();
            //$exame['sub_tipo_exame'] = $lote->Tipo;
            $exame['sub_tipo_exame'] = ($lote->SubTipo && strlen(trim($lote->SubTipo)) > 0) ?
										$lote->SubTipo :
										$lote->Tipo;

            $tipo_exame = array('ECG' => 1, 'EEG' => 2, 'ESPIRO' => 3, 'RAIO' => 4, 'RAIOX_OIT' => 9);

            $exame['exame_id'] = $tipo_exame[$lote->Tipo];
            $exame['paciente_id'] = $paciente_id;

            $exame_config  = $this->clientes_exames_model->get(array('cliente_id' => $cliente_id, 'exame_id' => $exame['exame_id']));

            $exame['medico_id'] = $exame_config['medico_responsavel'] ? $exame_config['medico_responsavel'] : $MEDICO_PADRAO;

            $medico_id = $MEDICO_PADRAO;

            if ($this->hasValue($lote->Medico)){
                $medico = array();
                $medico['nome'] =(string)$lote->Medico;
                $medico['crm'] = (string)$lote->CRM;
                $medico_id = $this->medicos_model->insert($medico);
            }

            $exame['medico_solicitante'] = $medico_id;

            $exame['motivo_id'] = $this->getMotivo($lote->Motivo, $MAX_MOTIVO);
            $exame['motivo_id'] = $exame['motivo_id'] ? $exame['motivo_id'] : $MOTIVO_PADRAO;

            /**
             * Busca cliente pela chave de transmissão ou pela sessão ativa(usuario logado)
             */
            $exame['cliente_id'] = $cliente_id;
            if (!$exame['cliente_id']) return;

            $exame['arquivo_exame'] = 'lotes/' . $arquivo_nome;
            //$exame['arquivo_imagem'] = $lote->Imagem;
            $exame['arquivo_imagem'] = $lote->Imagem ? 
									   $lote->Imagem : 
									   self::getImageFromFile($exame['arquivo_exame']);

			$exame['imagem_date'] = $exame['arquivo_imagem'] ? date("Y-m-d H:i:s") : null;

            $exame['arquivo_id'] = $this->getArquivoId($arquivo_nome);

            $exame['exame_date'] = $data_exame;
            $exame['observacoes'] = $lote->Observacao ? (string)$lote->Observacao : '';

            $exame['peso'] = float($lote->Peso);
            $exame['altura'] = float($lote->Altura);
            $exame['imc'] = float($lote->IMC);
            $exame['status'] = 0; // Aguardando Laudo!

			$exame['emergencia'] = !$exame['emergencia'] ? 0 : $exame['emergencia'];
			$exame['emergencia'] = UserSession::user('emergencias') == 1 ? 2 : $exame['emergencia'];

            $exame['preco_exame'] = $this->precoExameLote($exame);
            $exame['preco_exame_medico'] = $this->precoExameLote($exame, true);

            $exame['rnd'] = rand(1, 1000000);
			
			$exame['enviado_por'] = $lote->DamaDesktopKey ? "DAMA_DESKTOP" : "LOTE";
			
			$exame['empresa'] = UserSession::getInstance()->getEmpresa();
			
            /*
             *   VERIFICAR CRC DOS DADOS
             */
            $exame['crc'] = crc32($this->getCRCFields($lote));

            //log_message('debug', 'MD5 = ' . md5($this->getCRCFields($lote)) . " - CRC32: " . $exame['crc']);

            $exame_crc = $this->pacientes_exames_model->get(array('pe.crc' => $exame['crc'], 'pe.ativo' => 1));

            if ($exame_crc) {
                //log_message("DEBUG", "EXAME JÁ INSERIDO!!!");
                return;
            }

            //log_message('debug', "EXAME CRC");
            //log_message('debug', print_r($exame_crc, true));
            //log_message('debug', '=========================');
            //return;

            $get_id = $this->pacientes_exames_model->insert($exame);
            
            $this->pacientes_exames_model->update(
                array('protocolo' => $this->getProtocolo($get_id)),
                $get_id
            );

            log_message('debug', 'EXAME: ' . $get_id . ' INCLUIDO - CRC: ' . $exame['crc'] . ' RND: '. $exame['rnd']);

            $data = array();
            //$data['icon'] = null;
            //$data['title'] = "Alerta";
            //$data['content'] = "Novo Exame Recebido!";
            $data['gotourl'] = site_url("inicio/lista/");

            $this->pusher->trigger(get_pusher_channel_by_user_id($exame['cliente_id']), 'new_notification', $data);

    }

    function precoExameLote($exame, $medico = false) {
        $c_exame = $this->clientes_exames_model->get(
            array('cliente_id' => $exame['cliente_id'], 'exame_id' => $exame['exame_id'], 'medico_responsavel' => $exame['medico_id'])
        );

        $preco = 0;
        $preco_medico = 0;

        foreach ((array)$c_exame['sub_exames'] as $sub_exame){
            if ($c_exame['status'] == 1){
                $preco = float($sub_exame['preco']);
                $preco_medico = float($sub_exame['preco_medico']);
                break;
            }
        }
        return $medico ? $preco_medico : $preco;
    }

    /*
     * ############################# LOTES - FIM ##################################
     */

	function getProtocolo($id) {
		$protocolo = "";
		for ($t=0; $t < 2; $t++) {
			$alfa = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
			$letras = "";
			for ($i = 0; $i < strlen($id); $i++) {
				$l = substr($alfa, rand(0, 25), 1);
				if (rand(0, 1) == 1) $l = strtolower($l);
				$letras .= $l;
			}
			for ($i = 0; $i < strlen($id); $i++) {
				if (rand(0, 1) == 1) $protocolo .= substr($id, $i, 1);
				else $protocolo .= substr($letras, $i, 1);
			}
		}
		return strtoupper($protocolo);
	}

    public function envio() {
	    
	    if(UserSession::isMedico()){

	        UserSession::notPermited();
	    }

	    if ($post = $this->input->post()) {

            $this->load->disableLayout();
			$this->form_validation->set_rules('paciente[nome]', 'Paciente', 'required');
			
			$this->form_validation->set_rules('exame[exame]', 'Exame', 'required');
			$this->form_validation->set_rules('exame[data_exame]', 'Data do Exame', 'required|callback_data_check');

			$exame_data = $post['exame']['exame'];
			$exame_params = explode("|", $exame_data);

			if(count($exame_params) == 2){

				$exame_id = $exame_params[0];
				$sub_tipo_exame = $exame_params[1];

			} else {

				$exame_id = (int)$exame_data;
			}

			if($exame_id != 1 && $exame_id != 5 && $exame_id != 6 && $exame_id != 10) {

				$this->form_validation->set_rules('exame[motivo]', 'Motivo', 'required');
			}

			$requer_arquivo_exame = true;

			if($exame_id == 6){ // ACUIDADE VISUAL

                $requer_arquivo_exame = !$post['paciente']['acuidade_perto_od'] && !$post['paciente']['acuidade_perto_oe'] &&
                                 !$post['paciente']['acuidade_longe_od'] && !$post['paciente']['acuidade_longe_oe'] &&
                                 !$post['paciente']['lente_corretiva']   && !$post['paciente']['senso_cromatico']   &&
                                 !$post['paciente']['visao_noturna']     && !$post['paciente']['visao_ofuscada']    &&
                                 !$post['paciente']['profundidade'];


			    if (!$requer_arquivo_exame && !$post['paciente']['lente_corretiva']){
                    die("Common.userNotify.show('por favor, selecione se paciente fez uso de lente corretiva!', 'error', 8000);");
                    return;
                }

                if ($requer_arquivo_exame && !$_FILES['arquivo_exame']){
                    die("Common.userNotify.show('por favor, selecione arquivo de exame!', 'error', 8000);");
                    return;
                }

            }

			if ($this->form_validation->run()){
			    
			    $data_nascimento = parse_date_to_mysql($post['paciente']['nascimento']);
			    $data_exame = parse_date_to_mysql($post['exame']['data_exame']);
			    
			    if (!$data_exame || (!$data_nascimento && $post['paciente']['nascimento'])){

			        die("Common.userNotify.show('Verifique a data do exame e/ou a data de nascimento do Paciente.', 'error', 8000);");
			    }
			    
                $config['upload_path'] = config_item('upload_folder') . 'exames/';
                $config['allowed_types'] = '*'; //'pdf|jpg|WXML|wxml|zip|rar';
                $config['max_size'] = 1024 * 500; // 500MB
                $config['encrypt_name'] = true;
                
                $this->load->library( 'upload', $config );
                
                if ($requer_arquivo_exame && !$this->upload->do_upload( "arquivo_exame" )) {

                    die("Common.userNotify.show('".raw($this->upload->display_errors ())."', 'error', 8000);");
                    
                } else {

				    $MOTIVO_PADRAO  = 6;
					
                    $exame = array();

                    $arquivo_nome = '';
                    $arquivo_imagem = null;

                    $data = null;

                    if ($requer_arquivo_exame) {
                        $data = $this->upload->data();
                        $arquivo_nome = $data['file_name'];
                        $exame['arquivo_imagem'] = $this->getArquivoImagem($data);
					    $exame['arquivo_imagem'] = $exame['arquivo_imagem'] ?
						     				       $exame['arquivo_imagem'] :
											       self::getImageFromFile($arquivo_nome);
						$exame['imagem_date'] = $exame['arquivo_imagem'] ? date("Y-m-d H:i:s") : null;
					}

                    $empresa = array();
                    $empresa['nome'] = $post['paciente']['empresa'];
                    $empresa_id = $this->empresas_model->insert($empresa);
                    
                    $paciente = array();
                    $paciente['nome'] = mb_convert_case($post['paciente']['nome'], MB_CASE_UPPER);
                    $paciente['cpf'] = $post['paciente']['cpf'] ? $post['paciente']['cpf'] : "";
                    $paciente['rg'] = $post['paciente']['rg'] ? $post['paciente']['rg'] : "";
                    $paciente['funcao'] = $post['paciente']['funcao'] ? $post['paciente']['funcao'] : "";
                    $paciente['telefone'] = "(00) 0000-0000";
                    $paciente['nascimento'] = $data_nascimento;
                    $paciente['sexo'] = $post['paciente']['sexo'];
                    $paciente['empresa_id'] = $empresa_id;

                    $paciente_id = $this->pacientes_model->insert($paciente);

                    if(isset($sub_tipo_exame) && $sub_tipo_exame) {
                    	$exame['sub_tipo_exame'] = $sub_tipo_exame;
                    }

					$exame['exame_id'] = $exame_id;
                    $exame['paciente_id'] = $paciente_id;

					$exame['empresa'] = UserSession::getInstance()->getEmpresa();
					
                    $exame_config  = $this->clientes_exames_model->get(array('cliente_id' => UserSession::user('id'), 'exame_id' => $exame['exame_id']));
                    
                    $exame['medico_id'] = $exame_config['medico_responsavel'];
                    $exame['medico_solicitante'] = !$post['exame']['medico_solicitante'] ? '1' : $post['exame']['medico_solicitante'];
                    $exame['motivo_id'] = $post['exame']['motivo'] ? $post['exame']['motivo'] : $MOTIVO_PADRAO;
                    $exame['cliente_id'] = UserSession::user("id");

                    $exame['arquivo_exame'] = $arquivo_nome;
					
                    $exame['arquivo_id'] = $this->getArquivoId($arquivo_nome);

                    $exame['exame_date'] = $data_exame;
                    $exame['observacoes'] = $post['exame']['observacoes'];
                    $exame['reenviar_exame'] = $post['exame']['reenviar_exame'];
                    $exame['status'] = 0;
                    $exame['ativo'] = 1;

                    $exame['peso'] = float($post['paciente']['peso']);
                    $exame['altura'] = float($post['paciente']['altura']);
                    $exame['imc'] = (string)float($post['paciente']['imc']);
                    $exame['fumante'] = $post['paciente']['fumante'];
                    $exame['fumante_tempo'] = $post['paciente']['fumante_tempo'];

                    // ACUIDADE VISUAL
                    $exame['acuidade_perto_od'] = $post['paciente']['acuidade_perto_od'];
                    $exame['acuidade_perto_oe'] = $post['paciente']['acuidade_perto_oe'];
                    $exame['acuidade_longe_od'] = $post['paciente']['acuidade_longe_od'];
                    $exame['acuidade_longe_oe'] = $post['paciente']['acuidade_longe_oe'];
                    $exame['lente_corretiva']   = $post['paciente']['lente_corretiva'];
                    $exame['senso_cromatico']   = $post['paciente']['senso_cromatico'];
                    $exame['visao_noturna']     = $post['paciente']['visao_noturna'];
                    $exame['visao_ofuscada']    = $post['paciente']['visao_ofuscada'];
                    $exame['profundidade']      = $post['paciente']['profundidade'];
                    $exame['rnd']               = rand(1, 1000000);

                    $crc = $this->getObject();
					
					$tipo_exame = array(1 => 'ECG', 2 => 'EEG', 3 => 'ESPIRO', 4 => 'RAIO', 5 => 'MAPA', 6 => 'Acuidade Visual', 7 => 'EEG Clínico', 8 => 'Mapeamento Cerebral', 9 => 'OIT', 10 => 'Holter', 11 => 'Espirometria', 12 => 'Espirometria Clínica',  13 => 'Teste Ishihara');
					
                    $crc->Tipo     = $tipo_exame[$exame['exame_id']];
					$crc->Motivo   = $exame['motivo_id'];
                    $crc->Paciente = $paciente['nome'];
                    $crc->DataNasc = $this->getMMDDAAAA($data_nascimento);
                    $crc->Idade    = $this->getIdade($crc->DataNasc);
                    $crc->Sexo     = $paciente['sexo'];
                    $crc->Altura   = (string)$exame['altura'] * 100 / 100; // ponto para virgula!
                    $crc->Peso     = $exame['peso'];
					$crc->Empresa  = $empresa['nome'];
					
                    $exame['crc'] =  crc32($this->getCRCFields($crc));

					//log_message('debug', 'MD5 = ' . md5($this->getCRCFields($crc)) . " - CRC32: " . $exame['crc']);
            		//return;
					
					$exame_crc = $this->pacientes_exames_model->get(array('pe.crc' => $exame['crc'], 'pe.ativo' => 1));

					if ($exame_crc) {
						if ($exame['reenviar_exame'] !== 'S') {
							log_message("DEBUG", "EXAME JÁ INSERIDO!!!");
							die("Common.userNotify.show('Exame já inserido!', 'error', 8000);");
						}
					}			
					
                    if($post['exame']['extra_data']){
                        $exame['extra_data'] = @serialize($post['exame']['extra_data']);
                    }

                    if($post['exame']['emergencia'] == 1){
                        $exame['emergencia'] = 1;
                    }
                    
					$exame['emergencia'] = !$exame['emergencia'] ? 0 : $exame['emergencia'];
					$exame['emergencia'] = UserSession::user('emergencias') == 1 ? 2 : $exame['emergencia'];
					
                    $exame['preco_exame'] = preco_exame($exame);
                    $exame['preco_exame_medico'] = preco_exame($exame, true);

                    if($post['_id']){

                        $this->pacientes_exames_model->update($exame, $post['_id']);
                        die("Common.userNotify.show('<p>Os dados do Exame foram atualizados</p>', 'success', 2000, null, function(){ window.location = '".site_url("exames/single/" .$post['_id'])."'});");
                        	
                    }else{
                    	if (!$exame['medico_id']) {
							die("Common.userNotify.show('Esse exame não possui um Médico Responsável cadastrado. Entre em contato com Administrador do Sistema', 'error', 8000);");
                    	}


                       $get_id = $this->pacientes_exames_model->insert($exame);

                       $this->pacientes_exames_model->update(
                           array('protocolo' => $this->getProtocolo($get_id)),
                           $get_id
                       );

                       $data = array();
                       $data['icon'] = null;
                       $data['title'] = "Alerta";
                       $data['content'] = "Novo Exame Recebido!";
                       $data['gotourl'] = site_url("exames/single/" .$get_id);
                       
                       $this->load->library("pusher");
                       $this->pusher->trigger(get_pusher_channel_by_user_id($exame['medico_id']), 'new_notification', $data);
                       
                        die("Common.userNotify.show('<p>O Exame foi Cadastrado</p>', 'success', 2000, null, function(){ window.location = '".site_url("exames/single/" .$get_id)."'});");
                    }
                }
			  
			}else{

				die("Common.userNotify.show('".raw($this->form_validation->error_string())."', 'error', 8000);");
			}

        } else {

        	$exames  = $this->clientes_exames_model->get_all_select(null, true, true);
        	
			$medicos = $this->medicos_model->get_all(array('tipo' => 'solicitante'));
        	$motivos  = $this->motivos_exames_model->get_all();

            $this->_dataView['medico_responsavel']  = $this->usuarios_model->get_medico_responsavel();
        	$this->_dataView['medicos']  = $medicos;
        	$this->_dataView['exames'] = $exames;
            //$this->_dataView['exame_oit'] = $exames;
        	$this->_dataView['motivos'] = $motivos;
        	$this->_dataView['usuario'] = UserSession::user();

            $this->load->view ( $this->_dataView );
        }
	}

	private function getArquivoImagem($data){
		
	    if (!$data) return null;

        if (preg_match('/(\.zip)/', strtolower($data['file_name'])) !== 1) {
			
            if (preg_match('/(\.dcm)/', strtolower($data['file_name'])) == 1) {
				$this->DCM2JPG($data['full_path']);
				return str_replace('.dcm', '.jpg', strtolower($data['file_name']));
			}
			
            if (preg_match('/(\.jpg|\.bmp|\.jpeg|\.gif|\.png)/', strtolower($data['file_name'])) !== 1) return null;
			
            return $data['file_name'];
        }

        $zip  = new ZipArchive();

        if ($zip->open($data['full_path']) == TRUE) {

            $numFiles = $zip->numFiles;
            if ($numFiles == 0) return null;

            $numArquivoImagem = 0;
			
			$last_ext = null;
			
            for ($i = 0; $i < $numFiles; $i++) {
				
                $name = $zip->getNameIndex($i);

                $ext = null;
                $ext = ($ext == null && (preg_match('/(\.jpg)/', strtolower($name)) == 1)) ? '.jpg' : $ext;
                $ext = ($ext == null && (preg_match('/(\.jpeg)/', strtolower($name)) == 1)) ? '.jpeg' : $ext;
                $ext = ($ext == null && (preg_match('/(\.bmp)/', strtolower($name)) == 1)) ? '.bmp' : $ext;
                $ext = ($ext == null && (preg_match('/(\.gif)/', strtolower($name)) == 1)) ? '.gif' : $ext;
                $ext = ($ext == null && (preg_match('/(\.png)/', strtolower($name)) == 1)) ? '.png' : $ext;
                $ext = ($ext == null && (preg_match('/(\.dcm)/', strtolower($name)) == 1)) ? '.dcm' : $ext;
                if ($ext == null) continue;

				$last_ext = $last_ext == null ? $ext : $last_ext;
				
                $new_name = $data['raw_name'] . '_' . $numArquivoImagem . $ext; //'.jpg';

                $numArquivoImagem++;
				
                $zip->renameName($name, $new_name);
                $zip->extractTo($data['file_path'], $new_name);
				
				if($ext == '.dcm') {
					$this->DCM2JPG($data['file_path'] . $new_name);
				}
					
            }

        }
		
        $zip->close();

        //return $numArquivoImagem > 0 ? $data['raw_name'] . '{{' . $numFiles  . '}}' . '.jpg' : null;
		
		if ($last_ext == '.dcm') $last_ext = '.jpg';
		
        return $numArquivoImagem > 0 ? $data['raw_name'] . '{{' . $numArquivoImagem . '}}' . $last_ext : null;

    }

	public function download($id){

	    $tipo_exame = array('ECG', 'EEG', 'ESPIRO', 'RAIOX', 'MAPA', 'ACUIDADE', "EEG_CLINICO", "MAPEAMENTO", "RAIOX_OIT");

	    $exame = $this->pacientes_exames_model->get($id);

        if (!$exame){
            $this->session->set_flashdata('error', "Exame não encontrado!");
            redirect("/inicio/lista");
            return;
        }

        $paciente = $this->pacientes_model->get($exame['paciente_id']);

        $laudo = config_item('upload_folder'). "/laudos/" . $exame['arquivo_laudo'];

        if (!is_file($laudo)){
            $this->session->set_flashdata('error', "Arquivo de laudo não encontrado!");
            redirect("/inicio/lista");
            return;
        }

        /****
         *  GERA PDF DO LAUDO EM TEMPO DE EXECUCAO
         */


        if ($exame['status'] == 1) {

            $this->g_laudos->gerar_laudo($id);

        }else{

            $this->g_laudos->gerar_impossibilitado($id);

        }

        $selecionado = config_item('upload_folder'). "/laudos/" . $exame['arquivos_selecionados'];

        //$esquema = str_replace(' ', '_', $id . '_' . $tipo_exame[$exame['exame_id'] - 1] . '_' . ltrim(rtrim($paciente['nome'])));
        $esquema = str_replace(' ', '_', $id . '_' . $tipo_exame[$exame['exame_id'] - 1] . '_' . ltrim(rtrim($paciente['nome'])). '_' .$paciente['cpf']);

        $arquivo = 'LAUDO_' . $esquema;
        $tracado = 'TRACADO_' . $esquema;

        //$arquivo .= $exame['arquivos_selecionados'] ? '.zip' : '.pdf';

        /**
         * Download como ZIP (Laudo + Traçado)
         */
        if ($exame['arquivos_selecionados']) {

            if (!is_file($selecionado)) {
                $this->session->set_flashdata('error', "Traçado não encontrado!");
                redirect("/inicio/lista");
                return;
            }

            $caminho = config_item('upload_folder') . "download/";

            if (!is_dir($caminho)){

                mkdir($caminho, 0777);
            }

            if(file_exists($caminho . $arquivo . '.zip')) @unlink($caminho . $arquivo . '.zip');

            $zip = new ZipArchive();
            $zip->open($caminho . $arquivo . '.zip', ZIPARCHIVE::CREATE);

            $zip->addFile($laudo, $arquivo . '.pdf');
            $zip->addFile($selecionado, $tracado . '.' . pathinfo($selecionado, PATHINFO_EXTENSION));

            $zip->close();

            $arquivo .= '.zip';

            $outfile = $caminho . $arquivo;
            //header("Content-Type: application/octet-stream");
            header("Content-Type: application/zip");
            header('Content-Disposition: attachment; filename="' . $arquivo . '"');
            header("Content-Length: " . filesize($outfile));

            readfile($outfile);

            exit();

         /**
         * Download como PDF (laudo somente)
         */
        } else {

            $arquivo .= '.pdf';

            //header("Content-Type: application/octet-stream");
            header("Content-Type: application/pdf");
            header('Content-Disposition: attachment; filename="' . $arquivo . '"');
            header("Content-Length: " . filesize($laudo));

            readfile($laudo);

            exit();

        }

        //log_message('debug', '>>>> ' . $arquivo);

    }

    public function baixar() {

        if (UserSession::isMedico()){

            UserSession::notPermited();
        }

        $exames = $this->pacientes_exames_model->get_all(array('baixar' => true));

        if (count($exames) == 0){

            echo json_encode(array('err' => 'Nenhum Laudo para Baixar!'));
            return;
        }

        foreach ($exames as $exame) {

            log_message('debug', print_r($exame['paciente'], true));

        }

    }

    private function gerarLaudo($id, $exame){

        /****
         *  GERA PDF DO LAUDO EM TEMPO DE EXECUCAO
         */
        $this->g_laudos->dest_path = config_item('upload_folder').'/laudos/';

        if($exame['laudo_impossibilitado'] != 1){
            	$arquivo_laudo = $this->g_laudos->gerar_laudo($id);
        }else{
            	$arquivo_laudo = $this->g_laudos->gerar_impossibilitado($id);
        }

    }

    public function download_old($id){
	    if ($id){

	        $exame = $this->pacientes_exames_model->get($id);
	        
// 	        $exame_file   = config_item('upload_folder'). "/exames/" . $exame['arquivo_exame'];

	        $laudo_file   = config_item('upload_folder'). "/laudos/" . $exame['arquivo_laudo'];

	        $selecionados = config_item('upload_folder'). "/laudos/" . $exame['arquivos_selecionados'];

	        $filename_path = config_item('upload_folder'). "/laudos/";
	        
	        $filename = "laudo_file_{$exame['cliente_id']}_{$exame['paciente_id']}_{$exame['medico_id']}_{$id}.zip";
	        
                // GERA PDF DO LAUDO EM TEMPO DE EXECUCAO
     		//$this->load->library('g_laudos');
		//$this->g_laudos->dest_path = config_item('upload_folder').'/laudos/';
		//if($exame['laudo_impossibilitado'] != 1){
        	//    	$arquivo_laudo = $this->g_laudos->gerar_laudo($id);
	        //}else{
        	//    	$arquivo_laudo = $this->g_laudos->gerar_impossibilitado($id);
	        //}
	        // #########################################

		if(/*is_file($exame_file) || */is_file($laudo_file) || is_file($selecionados)){
	            
	            if(file_exists($filename_path . $filename)){
	                @unlink($filename_path . $filename);
	            }
	            
	        	$zip = new ZipArchive();
	        	$zip->open($filename_path . $filename, ZIPARCHIVE::CREATE);
	        
// 	        	$exame_nome = "arquivo_exame." . pathinfo($exame_file, PATHINFO_EXTENSION);

	        	$laudo_nome = "arquivo_laudo." . pathinfo($laudo_file, PATHINFO_EXTENSION);

        		$selecionados_nome = "tracado_selecionado." . pathinfo($selecionados, PATHINFO_EXTENSION);
	        	
// 	        	if ( is_file($exame_file) ){
// 	        		$zip->addFile($exame_file, $exame_nome);
// 	        	}
	        	
	        	if ( is_file($laudo_file) ){
	        		$zip->addFile($laudo_file, $laudo_nome);
	        	}
	        	
	        	if ( is_file($selecionados) ){
	        		$zip->addFile($selecionados, $selecionados_nome);
	        	}
	        
	        	$zip->close();
	        	
	        	$file_name = basename($filename_path . $filename);
	        	
	        	header("Content-Type: application/octet-stream");
	        	header("Content-Disposition: attachment; filename=$file_name");
	        	header("Content-Length: " . filesize($filename_path . $filename));
	        	
                        //header("Expires: 0");
                        //header("Cache-Control: must-revalidate");
                        //header("Pragma: public");
//ob_clean();
//flush();
//error_log("FILENAME: " . $file_name);

	        	readfile($filename_path . $filename);
	        	exit();
	        }else{
	        	
	        	$this->session->set_flashdata('error', "Não há arquivo disponível para download.");
	        	redirect("/inicio/lista");
	        }
	    }
	}
	
	public function single($id) {
	    if($id){

			$exame = $this->pacientes_exames_model->get($id);

            if(UserSession::isCliente()) {
                if ($exame['cliente_id'] !== UserSession::user("id")) {
                    redirect("/inicio/lista");
                    return;
                }
            }

            if (UserSession::isMedico()){
                if ($exame['medico_id'] !== UserSession::user("id")) {
                    redirect("/inicio/lista");
                    return;
                }
            }

			$exame['opcoes_impossibilitado'] = @unserialize($exame['opcoes_impossibilitado']);
			
			$paciente = $this->pacientes_model->get($exame['paciente_id']);
			$paciente['idade'] = calculate_years_old($paciente['nascimento'], $exame['create_date']);
			
			if(!is_null($paciente['empresa_id'])){
				$empresa = $this->empresas_model->get($paciente['empresa_id']);
				$paciente['empresa'] = $empresa['nome'];
			}
			$paciente['readonly'] = true;
			$exame['paciente'] = $paciente;

			$paciente_view = $this->load->view("exames/forms/form_{$exame['exame_id']}", $exame, true, false);

			$exame['paciente_view'] = $paciente_view;

            $this->_dataView['motivos'] = $this->motivos_exames_model->get_all();

			$this->_dataView['modelos_laudo'] = $this->modelos_laudo_model->get_all();
			$this->_dataView['opcoes_impossibilitado'] = $this->modelos_laudo_model->get_all();
			$this->_dataView['exame_erros'] = $this->exame_erros_laudo_model->get_all();

			// ECG 
			$exame['dados_ecg'] = $this->getDadosECG($exame);
			
			$this->_dataView['exame'] = $exame;

            // RAIOX_OIT
            $this->_dataView['exame_oit'] = $this->OIT_Parse_To_View($exame);
			
			/**
             * USUARIO
             */
            $this->_dataView['usuario'] = $this->usuarios_model->get($exame['cliente_id']);
            if (!UserSession::isMedico()) $this->_dataView['usuario']['mensagem_exames'] = null;

			$this->load->view ( $this->_dataView );

	    }else{
	    	redirect("/");
	    }
	}

	public function get_pessoas(){
	    $q = $this->input->get("q");
	    $type = $this->input->get("type");
	    $id = $this->input->get("id");
	    
	    $data = array("more" => false, "results" => array());
	    
	    if($q || $id){
	        if($type == "medico"){
	            
	            if($id){
	                $where = array("id" => $id);
	            }else{
	                $where = array("tipo" => "medico", "nome LIKE" => "%$q%");
	            }
	            
	            $medicos = $this->usuarios_model->get_all($where);
	            if($medicos){
	                $results = array();
	                foreach ($medicos as $medico) {
	                    $results[] = array(
                            "id" => $medico["id"],
                            "text" => $medico["nome"]
	                    );
	                }
	                 
	                $data['results'] = $results;
	            }
	        }elseif($type == "cliente"){
	            
	            if($id){
	                $where = array("id" => $id);
	            }else{
	                $where = array("tipo <>" => "medico", "nome LIKE" => "%$q%");
	            }
	            
	            $clientes = $this->usuarios_model->get_all($where);
	            if($clientes){
	                $results = array();
	                foreach ($clientes as $cliente) {
	                    $results[] = array(
                            "id" => $cliente["id"],
                            "text" => $cliente["nome"]
	                    );
	                }
	                 
	                $data['results'] = $results;
	            }
	        }elseif($type == "paciente"){
	            
	            if($id){
	                $where = array("id" => $id);
	            }else{
	                $where = array("nome LIKE" => "%$q%");
	            }
	            
	            $pacientes = $this->pacientes_model->get_all($where);
	            if($pacientes){
	                $results = array();
	                foreach ($pacientes as $paciente) {
	                    $results[] = array(
	                            "id" => $paciente["id"],
	                            "text" => $paciente["nome"]
	                    );
	                }
	                 
	                $data['results'] = $results;
	            }
	        }elseif($type == "exame"){
	            if($id){
	                $where = array("id" => $id);
	            }else{
	                $where = array("nome LIKE" => "%$q%");
	            }
	            
	            $exames = $this->exames_model->get_all($where);
	            
	            if($exames){
	                $results = array();
	                foreach ($exames as $exame) {
	                    $results[] = array(
                            "id" => $exame["id"],
                            "text" => $exame["nome"]
	                    );
	                }
	                
	                $data['results'] = $results;
	            }
	        }
	    }
	    
	    die(json_encode($data));
	}
	
	
	public function data_check($data) {

	    $_ = explode("/", $data);
        $_2 = explode("-", $data);
		if (strlen($data) != 10 || (@checkdate($_[1], $_[0], $_[2]) && @checkdate($_2[1], $_2[0], $_2[2]))) {
			$this->form_validation->set_message ( 'data_check', 'Corrija as datas enviadas.' );
			return FALSE;
		} else {
			return TRUE;
		}
	}
	
	public function get_form_exame() {

		$this->output->enable_profiler(false);
		$exame_id = $this->input->post("exame_id");

		$this->load->disableLayout();

		$this->load->view("exames/forms/form_{$exame_id}", $this->_dataView, false);
	}

	private function getMMDDAAAA($data){
        $ano= substr($data, 0, 4);
        $mes= substr($data, 5, 2);
        $dia= substr($data, 8);
        $data = $dia."/".$mes."/".$ano;
        return $data;
    }

    public function pacientes(){

		$exames = $this->pacientes_exames_model->get_pacientes();
		
        for ($i = 0; $i < count($exames); $i++) {
            $exames[$i]['data'] = $this->getMMDDAAAA($exames[$i]['data']);
        }

		$pacientes = $this->pacientes_model->get_pacientes();
		
        for ($i = 0; $i < count($pacientes); $i++) {
            $pacientes[$i]['data'] = $this->getMMDDAAAA($pacientes[$i]['nascimento']);
        }

		$exames = array_merge($exames, $pacientes);
		
        $this->load->disableLayout();
		
        return $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output(json_encode($exames));
    }

	public function doPaciente(){
		
        $this->load->disableLayout();
		
		$exames = $this->pacientes_exames_model->get_exames_do_paciente("");

        return $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output(json_encode($exames));
			
	}
	
    public function medicos(){

        $medicos = $this->medicos_model->get_all(array('tipo' => 'solicitante'));

        $data = [];
        for ($i = 0; $i < count($medicos); $i++)
            $data[] = array('id' => $medicos[$i]['id'], 'nome' => $medicos[$i]['nome']);

        return $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output(json_encode($data));

    }

}

/* End of file exames.php */
/* Location: ./application/controllers/exames.php */
