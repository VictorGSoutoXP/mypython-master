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
	
	function gerar_laudo($id_exame){
		
		$exame = $this->CI->pacientes_exames_model->get($id_exame);
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

			if ($this->dest_path){

				$name = $id_exame . "-" .md5(uniqid(rand(), true)) . ".pdf";

				/***
				 * A LINHA ABAIXO EH UTIL PARA A GERACAO DE LAUDO NO DOWNLOAD
				 */
                if ($exame['arquivo_laudo']) $name = $exame['arquivo_laudo'];

				$mpdf->Output($this->dest_path . $name, "F");
				
				return $name;

			}else{
				$mpdf->Output();
			}
		}
	}

	function gerar_impossibilitado($id_exame){

		log_message('debug', 'GERA IMPOSSIBILITADO');

		$exame = $this->CI->pacientes_exames_model->get($id_exame);

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

			if ($this->dest_path){

				$name = $id_exame . "-" .md5(uniqid(rand(), true)) . ".pdf";

				/***
				 * A LINHA ABAIXO EH UTIL PARA A GERACAO DE LAUDO NO DOWNLOAD
				 */
				if ($exame['arquivo_laudo']) $name = $exame['arquivo_laudo'];

				$mpdf->Output($this->dest_path . $name, "F");

				return $name;

			}else{
				$mpdf->Output();
			}
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
