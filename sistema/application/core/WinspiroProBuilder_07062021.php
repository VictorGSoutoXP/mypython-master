<?php

interface WinspiroPro {
	public function getExame($data);
}

abstract class AbstractWinspiroProBuilder implements WinspiroPro {
	
	function __construct(){
	}

	abstract function getExame($data);
	
    protected function cutString($str, $to, $modo = 'alpha', $space = true){

        $pos = strpos($str, $to);

        if ($pos === false) return null;

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

            if ($modo == 'alpha' && preg_match('/^[0-9]$/', $char)) break;
            if ($modo == 'alphanum' && !ctype_alnum($char)) break;
            if ($modo == 'numeric' && !preg_match('/^[0-9]$/', $char)) break;

            $cut .= $char;
        }

        return trim($cut);

    }
    protected function toDate($v = null){
        if ($v == null) {
            $datetime = new DateTime();
            return $datetime->format('d/m/Y');
        }
        $v = preg_replace('/[^0-9]/', '', $v);
        if (empty($v)) return  '';
        $date = substr($v, 0, 2) . '/' .  substr($v, 2, 2) . '/' . substr($v, 4);
        return $date;
    }
    protected function getNasc($data, $idade){
        $ano = (int)substr($data, strlen($data) - 4, 4);
        $ano = $ano - (int)$idade;
        return substr($data, 0, strlen($data) - 4) . $ano;
    }
	protected function getIMC($peso, $altura){
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
    protected function getAltura($v){
        $v = preg_replace('/[^0-9]/', '', $v);
        $v = (int)$v;
        return $v > 100 ? $v / 100 : $v;
    }
    protected function getObject(){
		return (object)array(
				'Tipo' => 'ESPIRO',
				'SubTipo' => 'ESPIRO OCUPACIONAL',
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
				'Clinica_id' => null,
				'Funcao' => null			
			);
	}
	
	protected function isValid($exame){
		return $exame->Paciente && $exame->Sexo &&
			   ( $exame->Idade && intval($exame->Idade) > 0 ) &&
			   ( $exame->Altura && intval($exame->Altura) > 0 ) &&
			   ( $exame->Peso && intval($exame->Peso) > 0 );
	}
	
}

class WinspiroPro10640 extends AbstractWinspiroProBuilder {
	
	function __construct(){
		parent::__construct();
	}
	
    private function getNome($str){
		
		if (!$str) return null;
		
        $str = preg_replace('/[0-9]+/', '', $str);

        $pos = strpos($str, "\n");

        if ($pos === false) return $str;

        $sobrenome = preg_replace('/\n/', '', substr($str, 0, $pos));
        $nome      = preg_replace('/\n/', '', substr($str, $pos + 1));

        $sobrenome = preg_replace("/ {2,}/", " ", $sobrenome);
        $nome      = preg_replace("/ {2,}/", " ", $nome);

        return preg_replace('/(WSP)/', '', trim($nome) . ' ' . trim($sobrenome));
    }
	
	function getExame($data){
		
        $paciente = $this->getNome(self::cutString($data, 'Grupo Paciente'));
        $idade    = $this->cutString($data, 'Idade', 'numeric');
        $sexo     = strpos($data, 'Masculino') !== false ? 'M' : 'F';
        $peso     = $this->cutString($data, 'kg', 'numeric');
        $altura   = $this->cutString($data, 'cm', 'numeric');

        $empresa = $this->cutString($data, 'EMPRESA:');
		
		$exame = $this->getObject();
		
		$exame->Empresa     = $empresa;
        $exame->Motivo      = $motivo;
        $exame->Data        = $this->toDate();
        $exame->Paciente    = $paciente;
        $exame->DataNasc    = $this->getNasc($exame->Data, $idade);
        $exame->Idade       = $idade;
        $exame->Sexo        = $sexo;
        $exame->Altura      = $this->getAltura($altura);
        $exame->Peso        = $peso;
        $exame->IMC         = $this->getIMC($exame->Peso, $exame->Altura);

		return $this->isValid($exame) ? $exame : null;
		
	}
}

/*

class WinspiroPro10670 implements AbstractWinspiroPro {
	function __construct() {
	}
	public function load($data){
		return null;
	}
}

class WinspiroPro10730 implements AbstractWinspiroPro {
	function __construct() {
	}
	public function load($data){
		return null;
	}
}

class WinspiroPro10590 implements AbstractWinspiroPro {
	function __construct() {
	}
	public function load($data){
		return null;
	}
}

class WinspiroPro10540 implements AbstractWinspiroPro {
	function __construct() {
	}
	public function load($data){
		return null;
	}
}

class WinspiroPro10501 implements AbstractWinspiroPro {
	function __construct() {
	}
	public function load($data){
		return null;
	}
}
*/

class WinspiroProBuilder {

	var $builder;

	function __construct() {
		$this->builder[] = new WinspiroPro10640();
		//$this->$builder[] = new WinspiroPro10670();
		//$this->$builder[] = new WinspiroPro10730();
		//$this->$builder[] = new WinspiroPro10590();
		//$this->$builder[] = new WinspiroPro10540();
	}

	function getExame($data){
        foreach ($this->builder as $builder){
			$obj = $builder->getExame($data);
			if ($obj) return $obj;
		}
		return null;
	}
	
}

?>