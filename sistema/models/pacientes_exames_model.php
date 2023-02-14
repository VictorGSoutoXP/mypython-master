<?php

class Pacientes_exames_model extends MY_Model {
	
	function __construct() {
		parent::__construct();
		$this->_tableName = "pacientes_exames";
	}

    function getLaudosParaDownload($clinica){
        $this->db->select("pe.id, pe.arquivo_laudo, p.nome, pe.exame_id");
        $this->db->where('pe.ativo', 1);
        $this->db->where("pe.cliente_id", $clinica->id);
        //$this->db->where("date(pe.laudo_date) > date_sub('" . $laudo_download_date . "', interval 1 minute)", null);
        $this->db->where('pe.laudo_date is not null and pe.laudo_download_date is null');
        $this->db->join("pacientes AS p", "p.id = pe.paciente_id");

        $query = $this->db->get( $this->_tableName . " AS pe" );
        return $query->result_array();

    }

	function getFields(){
        $this->db->select("pe.id, pe.arquivo_exame, pe.arquivo_id");
        $query = $this->db->get( $this->_tableName . " AS pe" );
        return $query->result_array();
    }

	function getExameParaMedicoLaudar(){

		$laudar = null; 
		$emergencia = null;
		$tipo_emergencia = null;

        $exames = $this->get_all([]);

        for ($i = 0; $i < count($exames); $i++){

            $exame = $exames[$i];

            if ($exame['status'] > 0) { // Laudados

                continue;
            }

            if ($exame['emergencia']) {

				$tipo_emergencia = !$tipo_emergencia ? 
									$exame['emergencia'] : 
									$tipo_emergencia;
			
                if (!$emergencia) {
                    $emergencia = $exame;
                    continue;
                }

                if ($exame['create_date'] < $emergencia['create_date']){
                    $emergencia = $exame;
					
                    $emergencia = $tipo_emergencia == $exame['emergencia'] ? 
								  $exame : 
								  $emergencia;
					
                    continue;
                }

            } else {

                if (!$laudar){
                    $laudar = $exame;
                    continue;
                }

                if ($exame['create_date'] < $laudar['create_date']){
                    $laudar = $exame;
                    continue;
                }

            }

        }

        if ($emergencia) {
            return $emergencia;
        }

        if ($laudar) {
            return $laudar;
        }

        return  null;

        //return $query->result_array ();

        log_message('debug', 'pacientes_exames_model.getExamesParaMedicoLaudar(): ' . print_r($exame, true));

        // TODO Na sequência buscar novo exame disponivel na pilha de exames para o DESPACHANTE
        return count($exame) == 1 ? $exame[0] : null;
    }

	function get_exames($params = null) {

	    if(UserSession::isCliente()){
	        
	        $this->db->where("pe.cliente_id", UserSession::user("id"));
	    }
	    
	    if(UserSession::isMedico()){
	        $this->db->where("pe.medico_id", UserSession::user("id"));
	    }
	    
        if($params['paciente']){
	        $this->db->where("p.nome LIKE '%" . strtoupper(ltrim($params['paciente'])) . "%'");
	    }
	    
	    if($params['cliente']){
	        $this->db->where("u.id LIKE '%" . strtoupper(ltrim($params['cliente'])) . "%'");
	    }
	    
		if (UserSession::isAdmin()){
			$this->db->where("pe.create_date >= ", date("Y-m-d", strtotime("- 10 day")));
		} else {
			$this->db->where("pe.create_date >= ", date("Y-m-d", strtotime("- 30 day")));
		}
		
		if ($params['status'] == '3') { // WXML para JPG
			
			$this->db->where("pe.status", 0);
			$this->db->where("pe.ativo", 1);
			$this->db->where("pe.arquivo_exame LIKE '%.WXML%' AND (pe.arquivo_imagem IS NULL OR pe.arquivo_imagem = '')");
			
		} else {
			if($params['status'] != ""){
				$this->db->where("pe.status", $params['status']);
			}
			
			if($params['ativo']){
				$this->db->where("pe.ativo", $params['ativo']);
			}
		}

	    if(!UserSession::isAdmin()){
	        $this->db->where('pe.ativo', 1);
	    }
	    
	    $this->db->select("te.tipo AS exame, pe.sub_tipo_exame, te.id AS exame_id, p.nome AS paciente, p.cpf AS paciente_cpf, u.nome AS cliente, u.id AS cliente_id, 
	    u.limite_horas, m.nome AS medico, pe.id, pe.arquivo_exame, pe.arquivo_laudo, pe.arquivo_laudo_assinado, pe.create_date, pe.laudo_date, pe.`status`,
	    				pe.acuidade_longe_od, pe.acuidade_longe_oe, pe.acuidade_perto_od, pe.acuidade_perto_oe, 
				pe.lente_corretiva, pe.senso_cromatico, pe.visao_noturna, pe.visao_ofuscada, pe.profundidade, pe.crc, pe.rnd,
 	    pe.ativo, pe.emergencia, tl.nome AS tipo_laudo, pe.protocolo, pe.arquivo_imagem, pe.arquivo_id");

	    $this->db->join("tipo_exame AS te", "te.id = pe.exame_id", "LEFT");
	    $this->db->join("pacientes AS p", "p.id = pe.paciente_id");
	    $this->db->join("usuarios AS u", "u.id = pe.cliente_id");
	    $this->db->join("usuarios AS m", "m.id = pe.medico_id");
	    $this->db->join("tipo_laudo AS tl", "tl.id = u.tipo_laudo", "LEFT");
	    
	    $this->db->order_by("pe.status = 0", "DESC");
	    $this->db->order_by("pe.emergencia = 1", "DESC");
	    $this->db->order_by("pe.id", "DESC");

		//$this->db->group_by('pe.crc');
		
		$query = $this->db->get ( $this->_tableName . " AS pe" );

        $query = $query->result_array();

		//print_r('debug', $this->db->last_query());
		
		return $query;
	
	}
	
	function get_sql_like($value){
		$part = explode(" ", strtoupper(ltrim(rtrim($value))));
		$ret  = ""; 
		foreach($part as $p){
			$ret .= $ret ? " AND " : "";
			$ret .= " p.nome like '%" . $p . "%'";
		}
		return '(' . $ret . ')';
	}
	
	/**
	 *
	 * @param $where mixed       	
	 */
	function get_all($params = null) {

	    //log_message('debug', '>>>>>>>>', print_r($params));

	    if(UserSession::isCliente()){
	        
	        $this->db->where("pe.cliente_id", UserSession::user("id"));
	    }
	    
	    if(UserSession::isMedico()){
	        $this->db->where("pe.medico_id", UserSession::user("id"));
	    }
	    
	    if(UserSession::isAdmin() && ($params['status'] == "" || !$params['status'])){
	        $this->db->where("pe.status", "0");
	    }

		if ($params['exame_id_min'])
			$this->db->where("pe.id >", $params['exame_id_min']);

	    if( !$params['all_period'] && 
			!$params['baixar'] && 
			!$params['expirando'] &&
			!$params['nome_paciente']) {
				
		    $ano = $params['ano'] ? $params['ano'] : date("Y");
		    $mes = $params['mes'] ? $params['mes'] : date("m");
		     
		    $this->db->where("YEAR(pe.create_date)", $ano);
		    $this->db->where("MONTH(pe.create_date)", $mes);
			
	    }
	    
	    if($tipo = $params['exame']){
	    	$tipo_params = explode("|", $tipo);
	    	if(count($tipo_params) > 1) {
	    		$this->db->where("pe.exame_id", $tipo_params[0]);
	    		$this->db->where("pe.sub_tipo_exame", $tipo_params[1]);
	    	} else {
	        	$this->db->where("pe.exame_id", $tipo);
	    	}
	    }

        if($params['paciente']){
	        $this->db->where("pe.paciente_id", $params['paciente']);
	    }
	    
        if($params['nome_paciente']){
	        //$this->db->where("p.nome LIKE '%" . strtoupper(ltrim($params['nome_paciente'])) . "%'");
	        $this->db->where($this->get_sql_like($params['nome_paciente']));
	    }

	    if($params['cliente']){
	        $this->db->where("pe.cliente_id", $params['cliente']);
	    }
	    
	    if($params['inicio']){
	        $inicio = implode("-", array_reverse(explode("/", $params['inicio'])));
	        log_message('debug', 'INICIO:' . $inicio);
	        $this->db->where("pe.create_date >= ", $inicio);
	    }
	    
	    if($params['fim']){
	        $fim = implode("-",array_reverse(explode("/", $params['fim'])));
            log_message('debug', 'FIM:' . $fim);
            $this->db->where("pe.create_date <=", $fim);
	    }
	    
		if ($params['status'] == '3') { // WXML para JPG
			
			$this->db->where("pe.status", 0);
			$this->db->where("pe.ativo", 1);
			$this->db->where("pe.arquivo_exame LIKE '%.WXML%' AND (pe.arquivo_imagem IS NULL OR pe.arquivo_imagem = '')");
			
		} else {
			if($params['status'] != ""){
				$this->db->where("pe.status", $params['status']);
			}
			
			if($params['ativo']){
				$this->db->where("pe.ativo", $params['ativo']);
			}
		}
		
	    if(!UserSession::isAdmin()){
	        $this->db->where('pe.ativo', 1);
	    }
	    
	    $this->db->select("te.tipo AS exame, pe.sub_tipo_exame, te.id AS exame_id, p.nome AS paciente, p.cpf AS paciente_cpf, u.nome AS cliente, u.id AS cliente_id, 
	    u.limite_horas, m.nome AS medico, pe.id, pe.arquivo_exame, pe.arquivo_laudo, pe.arquivo_laudo_assinado, pe.create_date, pe.laudo_date, pe.`status`,
	    				pe.acuidade_longe_od, pe.acuidade_longe_oe, pe.acuidade_perto_od, pe.acuidade_perto_oe, 
				pe.lente_corretiva, pe.senso_cromatico, pe.visao_noturna, pe.visao_ofuscada, pe.profundidade, pe.crc, pe.rnd,
 	    pe.ativo, pe.emergencia, tl.nome AS tipo_laudo, pe.protocolo, pe.arquivo_imagem, pe.arquivo_id");

	    $this->db->join("tipo_exame AS te", "te.id = pe.exame_id", "LEFT");
	    $this->db->join("pacientes AS p", "p.id = pe.paciente_id");
	    $this->db->join("usuarios AS u", "u.id = pe.cliente_id");
	    $this->db->join("usuarios AS m", "m.id = pe.medico_id");
	    $this->db->join("tipo_laudo AS tl", "tl.id = u.tipo_laudo", "LEFT");
	    
		if (UserSession::isCliente()){
			
			$this->db->order_by("pe.id", "DESC");
			
		} else {
			
			$this->db->order_by("pe.status", "ASC");
			$this->db->order_by("pe.emergencia", "DESC");
			$this->db->order_by("pe.id", "DESC");
			
		}

		$query = $this->db->get ( $this->_tableName . " AS pe" );

        $query = $query->result_array();

        if ($params['todos']) return $query;

        if (UserSession::user()['bloquear_simultaneo'] != 1 || UserSession::user()['despacho'] != 1) return $query;

        /**
         * ORGANIZA DESPACHOS
         */
        $result = array();

        $laudar     = null;
        $emergencia = null;
		$tipo_emergencia = null;
		
        for ($i = 0; $i < count($query); $i++){

            $exame = $query[$i];

            if ($exame['status'] > 0) { // Laudados
                $result[] = $exame;
                continue;
            }

            if ($exame['emergencia']) {
				
				$tipo_emergencia = !$tipo_emergencia ? 
									$exame['emergencia'] : 
									$tipo_emergencia;
									
                if (!$emergencia) {
                    $emergencia = $exame;
                    continue;
                }

                if ($exame['create_date'] < $emergencia['create_date']){
					
                    $emergencia = $tipo_emergencia == $exame['emergencia'] ? 
								  $exame : 
								  $emergencia;
								  
                    continue;
                }

            } else {

                if (!$laudar){
                    $laudar = $exame;
                    continue;
                }

                if ($exame['create_date'] < $laudar['create_date']){
                    $laudar = $exame;
                    continue;
                }

            }

        }

        if ($emergencia) {
            $result[] = $emergencia;
            return $result;
        }

        if ($laudar) $result[] = $laudar;

        return  $result;

		//return $query->result_array ();
	
	}
	
	function get_next_medico_id($where = null){
		$this->db->select("IF(pe.exame_id IS NULL, 0, count(1))  as total_exames, usuarios.id", false);
		$this->db->join("usuarios", "usuarios.id = pe.medico_id", "RIGHT");
		$this->db->where("usuarios.tipo", "medico");
		$this->db->group_by("usuarios.id");
		$this->db->order_by("total_exames");
		
		$query = $this->db->get_where ( $this->_tableName . " AS pe", $where, 1 );
		$row = $query->row_array();
		
		return $row['id'];
	}

	function get_years($where = NULL){
	    
	    $this->db->distinct();
	    $this->db->select("YEAR(pe.create_date) AS ano");
	    
	    $query = $this->db->get_where ( $this->_tableName . " AS pe", $where );
		return $query->result_array ();
	}
	
	function get_months($where = NULL){
	    
	    $this->db->distinct();
	    $this->db->select("MONTH(pe.create_date) AS mes");
	    
	    $query = $this->db->get_where ( $this->_tableName . " AS pe", $where );
		return $query->result_array ();
	}
	
	function relatorio($params){
	
	    if($params['mes']){
	        $ano = $params['ano'] ? $params['ano'] : date("Y");
	        $this->db->where("YEAR(pe.create_date)", $params['ano']);
	        $this->db->where("MONTH(pe.create_date)", $params['mes']);
	    }
	    
	    if($params['inicio']){
	        $inicio = implode("-",array_reverse(explode("/", $params['inicio'])));
	        
	        $this->db->where("pe.create_date >= ", $inicio);
	    }
	    
	    if($params['fim']){
	        $fim = implode("-",array_reverse(explode("/", $params['fim'])));
	        
	        $this->db->where("pe.create_date <=", $fim);
	    }
	
	    if($params['exame']){
	        $this->db->where("pe.exame_id", $params['exame']);
	    }
	
	    if(!is_array($params['cliente']) && $params['cliente']){
	        $this->db->where("pe.cliente_id", $params['cliente']);
	    }
	
	    if($params['medico']){
	        $this->db->where("pe.medico_id", $params['medico']);
	    }
	
	    if(is_array($params['cliente']) && count($params['cliente']) > 0){
	        $this->db->where_in("pe.cliente_id", $params['cliente']);
	    }
	
	    //if(!is_array($params['status']) && $params['status'] != ""){
	    //    $this->db->where("pe.status", $params['status']);
	    //}

	    if(strpos('0|1|2', $params['status']) !== false){ // && $params['status'] >= 0){

	        $this->db->where_in("pe.status", $params['status']);
	    }
	
	    $this->db->select("
	            pe.id AS exame_id, pe.create_date,
				pe.laudo_date, pe.preco_exame, pe.preco_exame_medico, pe.empresa,
				pe.sub_tipo_exame, pe.medico_id, pe.modelo_content,
	            te.tipo AS nome_exame,
	            p.nome AS paciente_nome, 
	            p.cpf AS paciente_cpf,
	             
	            e.nome AS paciente_empresa,
	            
	            o.nome AS cliente_nome, 
	            m.nome AS medico_nome, 
	            pe.status");
	    
	    $this->db->join("tipo_exame AS te", "te.id = pe.exame_id", "LEFT");
	    $this->db->join("pacientes AS p", "p.id = pe.paciente_id");
	    $this->db->join("usuarios AS o", "o.id = pe.cliente_id");
	    $this->db->join("usuarios AS m", "m.id = pe.medico_id");
        $this->db->join("empresas AS e", "e.id = p.empresa_id");

        $this->db->order_by('pe.id', 'DESC');
	    $this->db->where("pe.ativo", 1);
	
	    $query = $this->db->get ( $this->_tableName . " AS pe" );
	    
	    $rows = $query->result_array ();

		return $rows;
	     
	}	
	
	/**
	 * Get only one Patient
	 * 
	 * @param $where mixed       	
	 */
	function get($where = NULL) {
		if (! is_array ( $where ) && ! is_null ( $where )) {
			$where = array ("pe.id" => $where );
		}
		
		$this->db->select("
			te.tipo AS exame, 
				p.nome AS paciente, p.cpf AS paciente_cpf, p.rg AS paciente_rg, p.id AS paciente_id,
				u.nome AS cliente, u.id AS cliente_id, 
				m.nome AS medico, m.id AS medico_id, m.modelo_laudo_ecg AS medico_modelo_laudo_ecg,
				m_s.nome AS medico_solicitante, m_s.crm AS medico_solicitante_crm, m_s.id AS medico_solicitante_id, 
				pe.id AS paciente_exame_id, pe.arquivo_exame, pe.arquivo_laudo, pe.arquivo_laudo_assinado, 
				pe.create_date, pe.exame_date, pe.laudo_date, pe.`status`, 
				pe.ativo, pe.observacoes, pe.observacoes_medico, 
				pe.emergencia, pe.modelo_content, pe.arquivos_selecionados, 
				pe.reenviar_exame,
				pe.opcoes_impossibilitado, mo.nome AS motivo,
				pe.sub_tipo_exame, pe.exame_id, pe.peso, pe.altura, pe.imc, pe.fumante, pe.fumante_tempo, pe.extra_data,
    			pe.acuidade_longe_od, pe.acuidade_longe_oe, pe.acuidade_perto_od, pe.acuidade_perto_oe, 
				pe.lente_corretiva, pe.senso_cromatico, pe.visao_noturna, pe.visao_ofuscada, pe.profundidade, pe.crc, pe.rnd, 
				mo.id AS motivo_id, tl.nome AS tipo_laudo, pe.protocolo, pe.arquivo_imagem, pe.arquivo_id, pe.id,
                pe.rx_digital, 
                pe.negatoscopio,
                pe.qualidade,
                pe.comentarios_qualidade,
                pe.normal,
                pe.anormalidade_parenquima,
                pe.primarias,
                pe.secundarias,
                pe.zonas,
                pe.profusao,
                pe.grd_opacidade,
                pe.anormalidade_pleural,
                pe.placas_pleurais,
                pe.placas_parede_local,
                pe.placas_frontal_local,
                pe.placas_diafrag_local,
                pe.placas_outros_local,
                pe.placas_parede_calcif, 
                pe.placas_frontal_calcif,
                pe.placas_diafrag_calcif,
                pe.placas_outros_calcif,
                pe.placas_extensao_o_d,
                pe.placas_extensao_o_e,
                pe.placas_largura_d,
                pe.placas_largura_e,    
                pe.obliteracao,
                pe.espessamento_pleural,
                pe.espes_parede_local,
                pe.espes_frontal_local,
                pe.espes_parede_calcif,
                pe.espes_frontal_calcif,
                pe.espes_extensao_o_d,
                pe.espes_extensao_o_e,
                pe.espes_largura_d,
                pe.espes_largura_e,
                pe.outras_anormalidades,
                pe.simbolos,
                pe.comentarios_laudo,
                pe.pagina_pdf_laudo,
				pe.enviado_por,
				pe.laudo_ecg,
				pe.laudo_ecg_outros,
				pe.frequencia_ecg"
        );

		$this->db->join("pacientes AS p", "p.id = pe.paciente_id");
		$this->db->join("usuarios AS u", "u.id = pe.cliente_id");
		$this->db->join("usuarios AS m", "m.id = pe.medico_id");
		$this->db->join("medicos AS m_s", "m_s.id = pe.medico_solicitante");
		$this->db->join("motivos_exames AS mo", "mo.id = pe.motivo_id", 'LEFT');
	    $this->db->join("tipo_laudo AS tl", "tl.id = u.tipo_laudo", "LEFT");
	    $this->db->join("tipo_exame AS te", "te.id = pe.exame_id", "LEFT");
	    
		if(!UserSession::isAdmin()){

		    $this->db->where('pe.ativo', 1);
		}

		$query = $this->db->get_where ( $this->_tableName . " AS pe", $where, 1 );
		
		$row = $query->row_array ();
	    if ($row['extra_data']) {
	        $row['extra_data'] = @unserialize($row['extra_data']);
	    }

		return $row;

	} 
	
	function get_pacientes(){

        if(UserSession::isCliente()){
            $this->db->where("pe.cliente_id", UserSession::user("id"));
        }

        if(UserSession::isMedico()){
            $this->db->where("pe.medico_id", UserSession::user("id"));
        }

        $this->db->where("pe.create_date >= ", date("Y-m-d", strtotime("- 90 day")));

        $this->db->select("te.tipo AS exame, p.nome AS nome, p.cpf AS cpf, p.sexo AS sexo, p.rg AS rg, p.nascimento AS data, 
		p.funcao,
        e.nome AS empresa, pe.peso AS peso, pe.altura AS altura, pe.imc AS imc, ms.nome AS medico, 
        mo.nome AS motivo, ms.id AS medico_id, mo.id AS motivo_id");

        $this->db->join("tipo_exame AS te", "te.id = pe.exame_id", "LEFT");
        $this->db->join("pacientes AS p", "p.id = pe.paciente_id");
        $this->db->join("empresas AS e", "e.id = p.empresa_id");
        $this->db->join("medicos AS ms", "ms.id = pe.medico_solicitante");
        $this->db->join("motivos_exames AS mo", "mo.id = pe.motivo_id", 'LEFT');
        $this->db->join("usuarios AS u", "u.id = pe.cliente_id");
        $this->db->join("usuarios AS m", "m.id = pe.medico_id");

        $query = $this->db->get ( $this->_tableName . " AS pe" );

        //log_message('debug', $this->db->last_query());

        return $query->result_array ();

    }

	function delete($where) {
		
		if (! is_array ( $where ) && ! is_null ( $where )) {
			$where = array ("id" => $where );
		}
		
		$data = array ("status" => 0 );
		
		return $this->update ( $data, $where );
	}
}

?>