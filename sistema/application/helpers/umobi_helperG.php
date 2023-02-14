<?php

if (! function_exists ( 'saudacao' )) {
	function saudacao($nome) {
		$hora = date ( 'H' );
		if ($hora > 5 && $hora < 12) {
			$saudacao = "Bom dia";
		}
		
		if ($hora >= 12 && $hora < 18) {
			$saudacao = "Boa tarde";
		}
		
		if ($hora >= 18 || $hora <= 5) {
			$saudacao = "Boa tarde";
		}
		
		return $saudacao . ", " . $nome;
	}
}

function parse_date_to_mysql($data){
    $_ = explode("/", $data);
    if (count($_) != 3){
        $_ = explode("-", $data);
    }
    if (count($_) != 3){
        return false;
    }
     
    $mysql_date = @implode("-", array_reverse($_));
     
    if (@checkdate($_[1], $_[0], $_[2])){
        return $mysql_date;
    }
    return false;
}

function formatCNPJ($cnpj) {
	if(!$cnpj) return "";
	return mask($cnpj, '##.###.###/####-##');
}
function formatCPF($cpf) {
	if(!$cpf) return "";
	if(strlen($cpf) == 14) $cpf = substr($cpf, 3, 11);
	return mask($cpf, '###.###.###-##');
}
function mask($val, $mask) {
	$maskared = '';
	$k = 0;
	
	if(!$val) return "";
	
	for($i = 0; $i <= strlen ( $mask ) - 1; $i ++) {
		if ($mask [$i] == '#') {
			if (isset ( $val [$k] ))
				$maskared .= $val [$k ++];
		} else {
			if (isset ( $mask [$i] ))
				$maskared .= $mask [$i];
		}
	}
	return $maskared;
}

function validaCPF($cpf = null) {
	
	// Verifica se um número foi informado
	if (empty ( $cpf )) {
		return false;
	}
	
	// Elimina possivel mascara
	$cpf = preg_replace ( '/[^0-9]/', '', $cpf );
	$cpf = str_pad ( $cpf, 11, '0', STR_PAD_LEFT );
	
	// Verifica se o numero de digitos informados é igual a 11
	if (strlen ( $cpf ) != 11) {
		return false;
	} 	// Verifica se nenhuma das sequências invalidas abaixo
	// foi digitada. Caso afirmativo, retorna falso
	else if ($cpf == '00000000000' || $cpf == '11111111111' || $cpf == '22222222222' || $cpf == '33333333333' || $cpf == '44444444444' || $cpf == '55555555555' || $cpf == '66666666666' || $cpf == '77777777777' || $cpf == '88888888888' || $cpf == '99999999999') {
		return false;
		// Calcula os digitos verificadores para verificar se o
		// CPF é válido
	} else {
		
		for($t = 9; $t < 11; $t ++) {
			
			for($d = 0, $c = 0; $c < $t; $c ++) {
				$d += $cpf {$c} * (($t + 1) - $c);
			}
			$d = ((10 * $d) % 11) % 10;
			if ($cpf {$c} != $d) {
				return false;
			}
		}
		
		return true;
	}
}

function validaCNPJ($cnpj)
{
    $pontos = array(',','-','.','','/');
    
    $cnpj = preg_replace ( '/[^0-9]/', '', $cnpj );
    $cnpj = trim($cnpj);
    
    if(empty($cnpj) || strlen($cnpj) != 14) return FALSE;
    else {
            $rev_cnpj = strrev(substr($cnpj, 0, 12));
            for ($i = 0; $i <= 11; $i++) {
                $i == 0 ? $multiplier = 2 : $multiplier;
                $i == 8 ? $multiplier = 2 : $multiplier;
                $multiply = ($rev_cnpj[$i] * $multiplier);
                $sum = $sum + $multiply;
                $multiplier++;

            }
            $rest = $sum % 11;
            if ($rest == 0 || $rest == 1)  $dv1 = 0;
            else $dv1 = 11 - $rest;
             
            $sub_cnpj = substr($cnpj, 0, 12);
            $rev_cnpj = strrev($sub_cnpj.$dv1);
            unset($sum);
            for ($i = 0; $i <= 12; $i++) {
                $i == 0 ? $multiplier = 2 : $multiplier;
                $i == 8 ? $multiplier = 2 : $multiplier;
                $multiply = ($rev_cnpj[$i] * $multiplier);
                $sum = $sum + $multiply;
                $multiplier++;

            }
            $rest = $sum % 11;
            if ($rest == 0 || $rest == 1)  $dv2 = 0;
            else $dv2 = 11 - $rest;

            if ($dv1 == $cnpj[12] && $dv2 == $cnpj[13]) return true; //$cnpj;
            else return false;
        
    }
}

function get_user($id, $field = null){
	$ci =& get_instance();
	$user = $ci->usuarios_model->get($id);
	
	if($field && $user[$field]){
		return $user[$field];
	}
	return "";
}

function logo($text = false){
    if($text){
        return config_item("lab_name");
    }else{
        return '<img src="' . site_url("assets/img/" . config_item("lab_logo")) . '" alt="" title="'.config_item("lab_name").'" />';
    }
}

function tipo_user($key){
	$tipos = array(
		'medico' 	=> 'Médico',
		'cliente' 	=> "Cliente",
		'admin'		=> "Administrador",
        'auditor'   => "Auditor"
    );
	
	if($tipos[$key]) return $tipos[$key];
	return $key;
}

function raw($str){
	$str = preg_replace(array("/\n/", "/\'/"), array("", "\'"), $str);
	return $str;
}

function preco_exame($exame, $medico = false)
{
	$ci =& get_instance();
	$c_exame = $ci->clientes_exames_model->get(
	    array('cliente_id' => $exame['cliente_id'], 'exame_id' => $exame['exame_id'], 'medico_responsavel' => $exame['medico_id'])
    );

    $preco = 0;
	$preco_medico = 0;

	foreach ((array)$c_exame['sub_exames'] as $sub_exame){
	    if ($c_exame['status'] == 1 && $sub_exame['nome'] == $exame['sub_tipo_exame']){
	        //if($sub_exame['nome'] == $exame['sub_tipo_exame']){
	        $preco = float($sub_exame['preco']);
	        $preco_medico = float($sub_exame['preco_medico']);
	        break;
	    }
	}
	return $medico ? $preco_medico : $preco;
}

function data_laudo($exame){
   if ($exame['status'] <> 0){
       return date("d/m/Y H:i", strtotime($exame['laudo_date']));
   }
}

function status_laudo($exame){
    $status = array(
        0 => "Aguardando Laudo",
        1 => "Exame Laudado",
        2 => "Laudo Impossibilitado"
    );
    return $status[$exame['status']]  ? $status[$exame['status']] : $status[0];
}

function calculate_years_old($birthday, $current_day){
	if (!$birthday || $birthday == "0000-00-00") return "";
	if (!$current_day) $current_day = date("Y-m-d");
	
	$birthday = strtotime($birthday);
	$current_day = strtotime($current_day);
	
    $subTime = $current_day - $birthday;
    
    $y = floor(($subTime/(60*60*24*365)));
    $m = floor(($subTime-(60*60*24*365)/(60*60*24*30)));
    $d = floor(($subTime/(60*60*24)) %365);
    $h = floor(($subTime/(60*60)) %24);
    
    
    if ($y){
        return $y . ' anos';
    }elseif ($m){
        return $m . ' meses';
    }else{
        return $d . ' dias';
    }
}

function download_laudo($exame){
    
    if(!$exame['arquivo_laudo']) return;
    
    $url = config_item('upload_folder')."/laudos/" . $exame['arquivo_laudo'];
    $id = $exame['id'] ? $exame['id'] : $exame['paciente_exame_id'];
    $url = "exames/download/" . $id;
    return site_url($url);
}

function download_selecionados($exame){
    
    if(!$exame['arquivos_selecionados']) return;
    
    $url = config_item('upload_folder')."laudos/" . $exame['arquivos_selecionados'];
    return site_url($url);
}

// Function for basic field validation (present and neither empty nor only white space
function IsNullOrEmptyString($question){
    return (!isset($question) || trim($question)==='');
}

function download_exame($exame){
    $arquivo = $exame['arquivo_exame'];
    if (!IsNullOrEmptyString($exame['arquivo_imagem'])) $arquivo = $exame['arquivo_imagem'];
    log_message('debug', '>>>>>>' . $arquivo);
    $url = config_item('upload_folder')."exames/" . $arquivo; //$exame['arquivo_exame'];
    return site_url($url);
}

function month_name($num_mes){
    $meses = array (1 => "Janeiro", 2 => "Fevereiro", 3 => "Março", 4 => "Abril", 5 => "Maio", 6 => "Junho", 7 => "Julho", 8 => "Agosto", 9 => "Setembro", 10 => "Outubro", 11 => "Novembro", 12 => "Dezembro");
    return $meses[intval($num_mes)];
}



function get_pusher_channel(){
	if(UserSession::isMedico() || UserSession::isAdmin()){
		return md5(UserSession::user("email") . config_item("encryption_key"));
	}
}

function get_pusher_channel_by_user_id($user_id){
	if(UserSession::isMedico() || UserSession::isAdmin()){
		return md5(get_user($user_id, "email") . config_item("encryption_key"));
	}
}

function get_time_remainder($exame){
	date_default_timezone_set("America/Sao_Paulo");
	
	$limite_horas = (int) $exame['limite_horas'];
	$now = time();
	$create = strtotime($exame['create_date']);
	
	$elapsed_hour = ($now - $create) / 3600;
// 	return date("d/m/Y H:i:s", $now) . "/" . date("d/m/Y H:i:s", $create);

	$horas_restantes = $limite_horas - round($elapsed_hour, 1); 
	if ($horas_restantes < 0){
		return ceil($horas_restantes);
	}
	return$horas_restantes;
}

function get_count_waiting() {
	$ci =& get_instance();
	
	$exames = $ci->pacientes_exames_model->get_all( array("status" => "0", "ativo" => 1, "expirando" => true) );
	
	return count($exames);
}

function float($str) {
	if(strstr($str, ",")) {
		$str = str_replace(".", "", $str); // replace dots (thousand seps) with blancs
		$str = str_replace(",", ".", $str); // replace ',' with '.'
	}

	if(preg_match("#([0-9\.]+)#", $str, $match)) { // search for number that may contain '.'
		return str_replace(",", ".", floatval($match[0]));
	} else {
		return str_replace(",", ".", floatval($str)); // take some last chances with floatval
	}
}