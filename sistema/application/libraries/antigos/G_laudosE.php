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
					"subject" => "C=" . $CertPriv["subject"]["C"] .
								 "/O=" . $CertPriv["subject"]["O"] .
				    			 "/OU=" . $this->getCertData($CertPriv["subject"]["OU"]) .
								 "/CN=" . $CertPriv["subject"]["CN"],
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

	function gerar_laudo($id_exame){
		
		$exame = $this->CI->pacientes_exames_model->get($id_exame);

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

				return $name;

			}else{

				$mpdf->Output();

			}

			$this->assinarLaudoDigital($this->dest_path . $name, $_dataView['CERT'], $id_exame . "-" . $exame['medico_id']);

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
