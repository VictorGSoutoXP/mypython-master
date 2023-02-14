<?php

require('Util.php');
//require('pdf.php');

class G_laudos {
	/**
	 * 
	 * @var MY_Controller
	 */
	private $CI;
	
	public $dest_path;
	
	function __construct() {
		$this->CI = & get_instance();
	}

	function getCertData($array){
		$data = "";
		for ($i = 0; $i < count($array); $i++)
			$data .= $array[$i] == "(EM BRANCO)"  ? "" : $array[$i] . "/";
		return $data;
	}

	function getCertificado($exame, $medico){
		if (!$medico['assina_digital']) return null;
		$cert = array(
			'arquivo_pfx' => $medico['arquivo_pfx'], 
			'senha_pfx' => $medico['senha_pfx'],
			'nome_pfx' => $medico['nome_pfx'],
			'validade_pfx' => $medico['validade_pfx'],
			'assinado' => false,
			'protocolo' => $exame['protocolo']
		);
		
		return !$cert['arquivo_pfx'] ? null : $cert;
	}

	function getEmail($data){
		preg_match('/\S+@\S+/', $data, $matches);
		$email = count($matches) > 0 ? $matches[0] : "";
		return str_replace(',', '', $email);
	}

	function assinarLaudoDigital($filename, $CERT){
		if (!$CERT) return false;
		
		$path = realpath(config_item('upload_folder'));
		$sep = DIRECTORY_SEPARATOR;
		$signer   = $path . $sep . "pfx" . $sep . "signer.jar" ;
		$pfx_file = $path . $sep . "pfx" . $sep . $CERT['arquivo_pfx'];
		$pdf_file = $path . $sep . "laudos" . $sep . $filename;
		
		//$java = $path . $sep . "java -jar ";
		
		$params = $pfx_file . " " . $CERT['senha_pfx'] . " " . $pdf_file;
		
		$cmd = "java -jar " . $signer . " " . $params;
		//$cmd = $java . $signer . " " . $params;
		
		$ret = array();
		exec($cmd, $ret); // . " > /dev/null &");
		log_message("debug", "======================= SIGNER ==========================");
		log_message("debug", "0 => " . $ret[0]);
		log_message("debug", "1 => " . isset($ret[1]) ? $ret[1] : "ND");
		log_message("debug", "======================= SIGNER ==========================");
		return $ret && $ret[0] == "OK";
		
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

		//log_message('debug', 'OIT_Parse_To_View' . print_r($data, true));

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

	function inserirLogoNoPdf($filename, $logo){
		$path = realpath(config_item('upload_folder'));
		$sep = DIRECTORY_SEPARATOR;
		$path_logo = $path . $sep . "logo_holter" . $sep;
		
		$pdf_file = $path . $sep . "laudos" . $sep . $filename;
		$img_file = $path_logo . $logo;
		
		$app = $path_logo . "img4pdf.jar";
		$params = $img_file . " " . $pdf_file; // . " 20 760";
		
		$starter = (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') ? "logo.bat" : "logo.sh";
		$starter = $path_logo . $starter;
		
		$cmd = $starter . " " . $app . " " . $params;
	
		$ret = array();
		exec($cmd, $ret);
		
		log_message("debug", "======================= IMG4PDF ==========================");
		log_message("debug", $cmd); 
		log_message("debug", "0 => " . $ret[0]);
		log_message("debug", "1 => " . isset($ret[1]) ? $ret[1] : "ND");
		log_message("debug", "======================= IMG4PDF ==========================");

		return $ret && $ret[0] == "OK";
		
	}
	
	function gerar_laudo_via_pdf($id){
		$exame  = $this->CI->pacientes_exames_model->get($id);
		$logo = $exame['cliente_id'] . '.png';
		$this->inserirLogoNoPdf($exame['arquivo_laudo'], $logo);
		$medico = $this->CI->usuarios_model->get($exame['medico_id']);
		$cert = $this->getCertificado($exame, $medico);
		$this->assinarLaudoDigital($exame['arquivo_laudo'], $cert);
	}
	
	function gerar_laudo_oit($id){

		$exame = $this->CI->pacientes_exames_model->get($id);

		if ($exame['arquivo_laudo']) return $exame['arquivo_laudo'];

		$paciente = $this->CI->pacientes_model->get($exame['paciente_id']);
		$empresa = $this->CI->empresas_model->get($paciente['empresa_id']);
		$medico   = $this->CI->usuarios_model->get($exame['medico_id']);
		$cliente = $this->CI->usuarios_model->get($exame['cliente_id']);

		$paciente['idade'] = calculate_years_old($paciente['nascimento'], $exame['create_date']);
		$paciente['empresa'] = $empresa['nome'];

		$exame['paciente'] = $paciente;
		$exame['medico']   = $medico;
        $exame['cliente'] = $cliente;
        //$exame['oit']     = $this->OIT_Parse_To_View($oit);
		$exame['oit']     = $this->OIT_Parse_To_View($exame);

		$oit_logo = realpath('uploads/dama/oit/' . $exame['cliente_id'] . '-logo.jpg');
		$oit_logo = file_exists($oit_logo) === true ? 
					$oit_logo : 
					realpath('uploads/dama/oit/oit-logo.jpg');
					
		$exame['oit-logo'] = $oit_logo;
		
        $_dataView['exame'] = $exame;
		$_dataView['CERT'] = $this->getCertificado($exame, $medico);

        $this->CI->load->disableLayout();

        $content = $this->CI->load->view('laudos/laudo-oit', $_dataView, true);

		$mpdf = new Mpdf();
        $mpdf->mPDF(null, 'A4','', '', 5, 5, 5, 5, 0, 0);
		
		$mpdf->charset_in='UTF-8';
		$mpdf->SetDisplayMode('fullpage');
        $mpdf->WriteHTML($content);

        $arquivo_laudo = $id . "-" .md5(uniqid(rand(), true)) . ".pdf";
		log_message('debug', '>>>>>>> Arquivo Laudo: ' . $arquivo_laudo);

        if ($this->dest_path) {

            $mpdf->Output($this->dest_path . $arquivo_laudo, "F");

			$_dataView = $this->doAssinarLaudo($_dataView, $arquivo_laudo);
			
        } else {

            $mpdf->Output();

        }

		return $arquivo_laudo;
	}

	private function gerarTracadoDaPagina($exame){
		if ($exame['pagina_pdf_laudo'] == 0) return;
		
		$sep = DIRECTORY_SEPARATOR;
		$path = realpath(config_item('upload_folder') . $sep . "exames" . $sep);
		$arquivo_exame = $path . $sep . $exame['arquivo_exame'];

        if (preg_match('/(\.pdf)/', strtolower($arquivo_exame)) !== 1) return;

		Util::PDF2PNG(
			$arquivo_exame, 
			$exame['pagina_pdf_laudo']
		);
		
	}
	
	function gerar_laudo_ecg($id, $dados_ecg){
		$dados = array();
		foreach($dados_ecg as $doenca)
			$dados[$doenca['id']] = $doenca['descricao'];
		return $this->gerar_laudo($id, $dados);
	}
	
	function getDadosLaudoECG($exame, $dados_ecg){
		if ($exame['exame_id'] !== '1') return null;
		$medico = $this->CI->usuarios_model->get(UserSession::user()['id']);
		if ($medico['modelo_laudo_ecg'] == '0') return null;
		$doencas = '';
		$ids = explode(";", $exame['laudo_ecg']);
		foreach($ids as $id){
			if (!$id) continue;
			$doenca = $dados_ecg[$id];
			if (!$doenca) continue;
			$doencas .= $doenca . '<br />';
		}
		$frequencia = $exame['frequencia_ecg'] ? $exame['frequencia_ecg'] : '0';
		$content = "Frequência: " . $frequencia . '&nbsp;bpm<br />' 
			. $doencas 
			. $exame['laudo_ecg_outros'] . '<br />';
		return $content;
	}
	
	function gerar_laudo($id_exame, $dados_ecg = null){
		
		$exame = $this->CI->pacientes_exames_model->get($id_exame);

		if ($exame['exame_id'] == '9') {
			$this->gerar_laudo_oit($id_exame);
			return;
		}

		/**
		 * Evita assinatura digital em laudos antigos
		 * com isso, para forçar a geração de novo laudo se faz necessário remover conteúdo do campo 'arquivo_laudo'
		 */
		if ($exame['arquivo_laudo']) return $exame['arquivo_laudo'];

		self::gerarTracadoDaPagina($exame);
		
        $motivos  = $this->CI->motivos_exames_model->get_all();
        
        $_dataView['motivos'] = $motivos;
        
		$paciente = $this->CI->pacientes_model->get($exame['paciente_id']);

		$paciente['idade'] = calculate_years_old($paciente['nascimento'], $exame['create_date']);
		
		$empresa = $this->CI->empresas_model->get($paciente['empresa_id']);
		$paciente['empresa'] = $empresa['nome'];
		$exame['paciente'] = $paciente;
		
		$medico = $this->CI->usuarios_model->get($exame['medico_id']);
		$cliente = $this->CI->usuarios_model->get($exame['cliente_id']);
		
		$exame['medico'] = $medico;
		$exame['cliente'] = $cliente;
		
		$exame['modelo_content'] = str_replace('<br /><br />', '<br />', $exame['modelo_content']);
		
		$exame['dados_ecg'] = $this->getDadosLaudoECG($exame, $dados_ecg);

		$_dataView['exame'] = $exame;
		
		$_dataView['CERT'] = $this->getCertificado($exame, $medico);

		$this->CI->load->disableLayout();

		$content = $this->CI->load->view('laudos/laudo', $_dataView, true);
		
		if ($exame){

			$upload_path = site_url("uploads/" . config_item('upload_folder_base') . "/assinaturas/");
			
			$header_image = $cliente['topo_laudo'] ? $upload_path . "/" . $cliente['topo_laudo'] : site_url("assets/img/") . "/" . config_item('upload_folder_base') . '/topo_laudo.png';
			$header = '<center><img src="' . $header_image . '" alt="Dama" /></center>';
			
			$footer_image = $cliente['rodape_laudo'] ? $upload_path . "/" . $cliente['rodape_laudo'] : site_url("assets/img/") . "/" . config_item('upload_folder_base') . '/rodape_laudo.png';
			$footer = '<center><img src="' . $footer_image . '" alt="" /></center>';

			$mpdf = new Mpdf();
			$mpdf->mPDF(null, 'A4', '', '', 10, 10, 20, 20, 0, 0);
			
			$mpdf->charset_in='UTF-8';
			
			$mpdf->SetHTMLHeader($header);
			$mpdf->SetHTMLFooter($footer);
			
			$mpdf->WriteHTML($content);
			
			$name = $id_exame . "-" .md5(uniqid(rand(), true)) . ".pdf";

			if ($this->dest_path){

				/***
				 * A LINHA ABAIXO EH UTIL PARA A GERACAO DE LAUDO NO DOWNLOAD
				 */
                if ($exame['arquivo_laudo']) $name = $exame['arquivo_laudo'];

				$mpdf->Output($this->dest_path . $name, "F");

				$_dataView = $this->doAssinarLaudo($_dataView, $name);
				
				return $name;

			}else{

				$mpdf->Output();

			}

			$this->assinarLaudoDigital($this->dest_path . $name, $_dataView['CERT'], $id_exame . "-" . $exame['medico_id']);

		}
	}

	function doAssinarLaudo($_dataView, $pdf){
		if (!$_dataView['CERT']) return $_dataView;
		$exame = $_dataView['exame'];
		$id_exame = $exame["id"];
		$medico = $exame["medico"];
		$_dataView["CERT"]["assinado"] = $this->assinarLaudoDigital($pdf, $_dataView['CERT']);
		return $_dataView;
	}
	
	function gerar_impossibilitado($id_exame){

		$exame = $this->CI->pacientes_exames_model->get($id_exame);

		/**
		 * Evita assinatura digital em laudos antigos
		 * com isso, para forçar a geração de novo laudo se faz necessário remover conteúdo do campo 'arquivo_laudo'
		 */
		if ($exame['arquivo_laudo']) return $exame['arquivo_laudo'];

		$exame['motivos'] = $this->CI->exame_erros_laudo_model->get_all();
		$exame['motivos'] = $exame['motivos'] ? $exame['motivos'] : null;
		$exame['opcoes_impossibilitado'] = unserialize($exame['opcoes_impossibilitado']);

		$paciente = $this->CI->pacientes_model->get($exame['paciente_id']);

		$paciente['idade'] = calculate_years_old($paciente['nascimento'], $exame['create_date']);

		$empresa = $this->CI->empresas_model->get($paciente['empresa_id']);
		$paciente['empresa'] = $empresa['nome'];
		$exame['paciente'] = $paciente;

		$medico = $this->CI->usuarios_model->get($exame['medico_id']);
		$cliente = $this->CI->usuarios_model->get($exame['cliente_id']);
		$exame['medico'] = $medico;
		$exame['cliente'] = $cliente;

		log_message('debug', 'G_laudos.impossibilitado.cliente: >>>>>>>>>>>>>>>>>>>>>>>.' . print_r($cliente, true));

		$_dataView['exame'] = $exame;
		$_dataView['CERT'] = $this->getCertificado($exame, $medico);
		
		$this->CI->load->disableLayout();

		$content = $this->CI->load->view('laudos/laudo', $_dataView, true);

		if ($exame){

			$upload_path = site_url("uploads/" . config_item('upload_folder_base') . "/assinaturas/");

			$header_image = $cliente['topo_laudo'] ? $upload_path . "/" . $cliente['topo_laudo'] : site_url("assets/img/") . "/" . config_item('upload_folder_base') . '/topo_laudo.png';
			$header = '<center><img src="' . $header_image . '" alt="Dama" /></center>';

			$footer_image = $cliente['rodape_laudo'] ? $upload_path . "/" . $cliente['rodape_laudo'] : site_url("assets/img/") . "/" . config_item('upload_folder_base') . '/rodape_laudo.png';
			$footer = '<center><img src="' . $footer_image . '" alt="" /></center>';

			//$mpdf= new mPDF(null, 'A4', '', '', 10, 10, 45, 45, 5, 5);

			$mpdf = new Mpdf();
			$mpdf->mPDF(null, 'A4', '', '', 10, 10, 45, 45, 5, 5);
			
			$mpdf->charset_in='UTF-8';

			$mpdf->SetHTMLHeader($header);
			$mpdf->SetHTMLFooter($footer);

			$mpdf->WriteHTML($content);

			$name = $id_exame . "-" . md5(uniqid(rand(), true)) . ".pdf";

			if ($this->dest_path){

				/***
				 * A LINHA ABAIXO EH UTIL PARA A GERACAO DE LAUDO NO DOWNLOAD
				 */
				if ($exame['arquivo_laudo']) $name = $exame['arquivo_laudo'];

				$mpdf->Output($this->dest_path . $name, "F");
				
				$_dataView = $this->doAssinarLaudo($_dataView, $name);

				return $name;

			}else{

				$mpdf->Output();
				
			}

			//$this->assinarLaudoDigital($this->dest_path . $name, $_dataView['CERT'], $id_exame . "-" . $exame['medico_id'] );

		}
	}

	function gerar_impossibilitado_old($id_exame){
		$this->CI->load->disableLayout();
		
		$exame = $this->CI->pacientes_exames_model->get($id_exame);
		
		$motivos  = $this->CI->exame_erros_laudo_model->get_all();
		$_dataView['motivos'] = $motivos;
		
		$medico = $this->CI->usuarios_model->get($exame['medico_id']);
		$cliente = $this->CI->usuarios_model->get($exame['cliente_id']);
		
		$exame['medico'] = $medico;
		$exame['opcoes_impossibilitado'] = unserialize($exame['opcoes_impossibilitado']);
		$_dataView['exame'] = $exame;

		$content = $this->CI->load->view ('laudos/impossibilitado', $_dataView, true);
		
		if ($exame){
			$upload_path = site_url("uploads/" . config_item('upload_folder_base') . "/assinaturas/");
			$header = '<center><img src="' . $upload_path . "/" . $cliente['topo_laudo'] . '"/></center>';
			$footer = '<center><img src="' . site_url("assets/img/") . "/" . config_item('upload_folder_base') . '/rodape_laudo.png" alt="" /></center>';
			
			$mpdf=new mPDF(null, 'A4', '', '', 25, 30, 45, 45, 5, 5);
		
		
			$mpdf->SetHTMLHeader($header);
			$mpdf->SetHTMLFooter($footer);
		
			$mpdf->WriteHTML($content);
			
			if ($this->dest_path){
				$name = $id_exame . "-" .md5(uniqid(rand(), true)) . ".pdf";
				$mpdf->Output($this->dest_path . $name, "F");
				
				return $name;
			}else{
				$mpdf->Output();
			}
		}
	}
}

?>