<?php

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

	function getCertificadoNEW($medico){
		$cert = (object)array(
			'arquivo_pfx' => $medico['arquivo_pfx'], 
			'senha_pfx' => $medico['senha_pfx'],
			'nome_pfx' => $medico['nome_pfx'],
			'validade_pfx' => $medico['validade_pfx']
		);
		return !$cert->arquivo_pfx ? null : $cert;
	}
	
	function getCertificado($medico_id, $cert_password){

		$pfxCertPrivado = "./uploads/" . config_item('upload_folder_base') . "/certificados/" . $medico_id . '.pfx';

		//$pfxCertPrivado = $path . '/' . $medico_id . '.pfx';

		if (!file_exists($pfxCertPrivado)) {
			return null;
		}

		$pfxContent = file_get_contents($pfxCertPrivado);

		if (!openssl_pkcs12_read($pfxContent, $x509certdata, $cert_password)) {

			return null;

		} else {

			$CertPriv   = openssl_x509_parse(openssl_x509_read($x509certdata['cert']));

			//log_message("debug", print_r($CertPriv, true));

			$PrivateKey = $x509certdata['pkey'];

			$pub_key = openssl_pkey_get_public($x509certdata['cert']);
			$keyData = openssl_pkey_get_details($pub_key);

			$PublicKey  = $keyData['key'];

			if ($CertPriv["version"] == "2"){

				$cert =  array(
					"subject" => //"C=" . $CertPriv["subject"]["C"] .
								 //"/O=" . $CertPriv["subject"]["O"] .
				    			 //"/OU=" . $this->getCertData($CertPriv["subject"]["OU"]) .
								 "CN=" . $CertPriv["subject"]["CN"],
					"issuer" =>  "C=" . $CertPriv["issuer"]["C"] .
								 "/O=" . $CertPriv["issuer"]["O"] .
								 "/OU=" . $CertPriv["issuer"]["OU"] .
						         "/CN=" . $CertPriv["issuer"]["CN"],
					"signature" => "VL=" . date('d/m/Y', $CertPriv['validTo_time_t']) .
								   "/SN=" . $CertPriv["signatureTypeSN"] .
						           "/LN=" . $CertPriv["signatureTypeLN"],
					"PUK" => $PublicKey,
					"PIK" => $PrivateKey
				);

				return str_replace("//", "/", $cert);

			} else {

			    return null;

            }

			return array(
				"NAME" => $CertPriv['name'],
				"HASH" => $CertPriv['hash'],
				"C"    => $CertPriv['subject']['C'],
				"ST"   => $CertPriv['subject']['ST'],
				"L"    => $CertPriv['subject']['L'],
				"CN"   => $CertPriv['subject']['CN'],
				"VL"   => date('d/m/Y', $CertPriv['validTo_time_t']),
				"EM"   => $this->getEmail($CertPriv['extensions']['subjectAltName']),
			    "AUT"  => $CertPriv['extensions']['authorityKeyIdentifier'],
				"OU"   => $CertPriv['issuer']['OU'],
				"PUK" => $PublicKey,
				"PIK" => $PrivateKey
			);

			/*
			echo '<br>'.'<br>'.'--- Dados do Certificado ---'.'<br>'.'<br>';
			echo $CertPriv['name'].'<br>';                           //Nome
			echo $CertPriv['hash'].'<br>';                           //hash
			echo $CertPriv['subject']['C'].'<br>';                   //País
			echo $CertPriv['subject']['ST'].'<br>';                  //Estado
			echo $CertPriv['subject']['L'].'<br>';                   //Município
			echo $CertPriv['subject']['CN'].'<br>';                  //Razão Social e CNPJ / CPF
			echo date('d/m/Y', $CertPriv['validTo_time_t'] ).'<br>'; //Validade
			echo $CertPriv['extensions']['subjectAltName'].'<br>';   //Emails Cadastrados separado por ,
			echo $CertPriv['extensions']['authorityKeyIdentifier'].'<br>';
			echo $CertPriv['issuer']['OU'].'<br>';                   //Emissor
			echo '<br>'.'<br>'.'--- Chave Pública ---'.'<br>'.'<br>';
			print_r($PublicKey);
			echo '<br>'.'<br>'.'--- Chave Privada ---'.'<br>'.'<br>';
			echo $PrivateKey;
			*/

		}
	}

	function getEmail($data){
		preg_match('/\S+@\S+/', $data, $matches);
		$email = count($matches) > 0 ? $matches[0] : "";
		return str_replace(',', '', $email);
	}

	function assinarLaudoDigitalNEW($filename, $CERT){
		log_message('debug', '1');
		log_message('debug', print_r($CERT, true));
		$pfx_path = config_item('upload_folder') . '/pfx/';
		log_message('debug', '2');
		$cmd = "java -jar " . $pfx_path . "signer.jar " . $CERT->arquivo_pfx . ' ' . $CERT->senha_pfx . ' ' . $filename;
		log_message('debug', '3');
		log_message('debug', '>>>>>>> ' . $cmd);
		//exec($cmd . " > /dev/null &");
	}
	
	function assinarLaudoDigital($filename, $CERT, $id){
		if (!$CERT) return;
		$handle = fopen ($filename, "r");
		$data = fread ($handle, filesize ($filename));
		fclose ($handle);
		openssl_sign($data, $signature, $CERT["PIK"], OPENSSL_ALGO_SHA256);
		$path = "./uploads/" . config_item('upload_folder_base') . "/certificados/assinaturas/";
		file_put_contents($path . $id . '.pub', $CERT["PUK"]);
		file_put_contents($path . $id . '.key', $CERT["PIK"]);
		file_put_contents($path . $id . '.sign', $signature);
	}

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
		return $protocolo;
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

		log_message('debug', 'OIT_Parse_To_View' . print_r($data, true));

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

	function gerar_laudo_oit($id){

		$exame = $this->CI->pacientes_exames_model->get($id);

		if ($exame['arquivo_laudo']) return $exame['arquivo_laudo'];

		//$oit = $this->CI->pacientes_exames_oit_model->get($id);

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

        $_dataView['exame'] = $exame;

        $this->CI->load->disableLayout();

        $content = $this->CI->load->view('laudos/laudo-oit', $_dataView, true);

        $mpdf= new mPDF(null, 'A4','', '', 5, 5, 5, 5, 0, 0);
		$mpdf->charset_in='UTF-8';
		$mpdf->SetDisplayMode('fullpage');
		//$mpdf= new mPDF(null, 'A4', '', '', 10, 10, 45, 45, 5, 5);
        $mpdf->WriteHTML($content);

        $arquivo_laudo = $id . "-" .md5(uniqid(rand(), true)) . ".pdf";
		//$arquivo_laudo = $id . "-OIT-TESTE.pdf";
		log_message('debug', '>>>>>>> Arquivo Laudo: ' . $arquivo_laudo);


        if ($this->dest_path) {

            $mpdf->Output($this->dest_path . $arquivo_laudo, "F");

        } else {

            $mpdf->Output();

        }

		return $arquivo_laudo;
	}

	function gerar_laudo($id_exame){
		
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

        $motivos  = $this->CI->motivos_exames_model->get_all();
        
        $_dataView['motivos'] = $motivos;
        
		$paciente = $this->CI->pacientes_model->get($exame['paciente_id']);

		$paciente['idade'] = calculate_years_old($paciente['nascimento'], $exame['create_date']);
		
		$empresa = $this->CI->empresas_model->get($paciente['empresa_id']);
		$paciente['empresa'] = $empresa['nome'];
		$exame['paciente'] = $paciente;
		
		$medico = $this->CI->usuarios_model->get($exame['medico_id']);
		//$_dataView['CERT'] = $this->getCertificado($medico);

		$_dataView['CERT'] = $this->getCertificado($exame['medico_id'], 1);

		$protocolo = $exame["paciente_exame_id"] . $exame["medico_id"];

		if (!$exame["protocolo"]) {

			$exame['protocolo'] = !$_dataView["CERT"] ? null : $this->getProtocolo($protocolo);

			$this->CI->pacientes_exames_model->update(array('protocolo' => $exame["protocolo"]), $id_exame);

		}

		$cliente = $this->CI->usuarios_model->get($exame['cliente_id']);
		
		$exame['medico'] = $medico;

        //$exame['titulo'] =  date('d/m/Y', strtotime($exame['laudo_date'])) .
        //                    str_repeat(' ', (95 - strlen($exame['exame']) - strlen('xx/xx/xxxx') - strlen('LAUDO DE DIGITAL') / 2)) .
        //                    'LAUDO DE ' . $exame['exame' . 'DIGITAL'];

        //log_message('debug', 'AQUI >>>>>>> ' . $exame['titulo']);

		$exame['modelo_content'] = str_replace('<br /><br />', '<br />', $exame['modelo_content']);

		$_dataView['exame'] = $exame;
		
		$this->CI->load->disableLayout();

		$content = $this->CI->load->view('laudos/laudo', $_dataView, true);

		if ($exame){

			$upload_path = site_url("uploads/" . config_item('upload_folder_base') . "/assinaturas/");
			
			$header_image = $cliente['topo_laudo'] ? $upload_path . "/" . $cliente['topo_laudo'] : site_url("assets/img/") . "/" . config_item('upload_folder_base') . '/topo_laudo.png';
			$header = '<center><img src="' . $header_image . '" alt="Dama" /></center>';
			
			$footer_image = $cliente['rodape_laudo'] ? $upload_path . "/" . $cliente['rodape_laudo'] : site_url("assets/img/") . "/" . config_item('upload_folder_base') . '/rodape_laudo.png';
			$footer = '<center><img src="' . $footer_image . '" alt="" /></center>';

			$mpdf= new mPDF(null, 'A4', '', '', 10, 10, 45, 45, 5, 5);
			
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

				$this->assinarLaudoDigital($this->dest_path . $name, $_dataView['CERT'], $id_exame . "-" . $exame['medico_id'] );
				//$this->assinarLaudoDigital($this->dest_path . $name, $_dataView['CERT'] );

				return $name;

			}else{

				$mpdf->Output();

			}

			//$this->assinarLaudoDigital($this->dest_path . $name, $_dataView['CERT'], $id_exame . "-" . $exame['medico_id']);
			//$this->assinarLaudoDigital($this->dest_path . $name, $_dataView['CERT']);

		}
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

		$_dataView['CERT'] = $this->getCertificado($exame['medico_id'], 1);

		$protocolo = $exame["paciente_exame_id"] . $exame["medico_id"];

		if (!$exame["protocolo"]) {

			$exame['protocolo'] = !$_dataView["CERT"] ? null : $this->getProtocolo($protocolo);

			$this->CI->pacientes_exames_model->update(array('protocolo' => $exame["protocolo"]), $id_exame);

		}

		$cliente = $this->CI->usuarios_model->get($exame['cliente_id']);

		$exame['medico'] = $medico;

		$_dataView['exame'] = $exame;

		$this->CI->load->disableLayout();

		$content = $this->CI->load->view('laudos/laudo', $_dataView, true);

		if ($exame){

			$upload_path = site_url("uploads/" . config_item('upload_folder_base') . "/assinaturas/");

			$header_image = $cliente['topo_laudo'] ? $upload_path . "/" . $cliente['topo_laudo'] : site_url("assets/img/") . "/" . config_item('upload_folder_base') . '/topo_laudo.png';
			$header = '<center><img src="' . $header_image . '" alt="Dama" /></center>';

			$footer_image = $cliente['rodape_laudo'] ? $upload_path . "/" . $cliente['rodape_laudo'] : site_url("assets/img/") . "/" . config_item('upload_folder_base') . '/rodape_laudo.png';
			$footer = '<center><img src="' . $footer_image . '" alt="" /></center>';

			$mpdf= new mPDF(null, 'A4', '', '', 10, 10, 45, 45, 5, 5);

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

				$this->assinarLaudoDigital($this->dest_path . $name, $_dataView['CERT'], $id_exame . "-" . $exame['medico_id'] );

				return $name;

			}else{

				$mpdf->Output();
			}

			$this->assinarLaudoDigital($this->dest_path . $name, $_dataView['CERT'], $id_exame . "-" . $exame['medico_id'] );

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
