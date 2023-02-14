<?php

if (! defined ( 'BASEPATH' ))
    die ();

class Validar extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
    }

    function laudo()
    {
        $arquivo_laudo = $_GET["a"];
        if ($arquivo_laudo) {
            $laudo = config_item('upload_folder'). "/laudos/" . $arquivo_laudo;
            if (!is_file($laudo)){
                header('Content-type: application/json');
                echo json_encode(array("erro" => "LAUDO NAO ENCONTRADO!", "codigo" =>2));
                return;
            }
            header("Content-Type: application/pdf");
            header('Content-Disposition: attachment; filename="laudo.pdf"'); // . $arquivo_laudo . '"');
            header("Content-Length: " . filesize($laudo));
            readfile($laudo);
            exit();
        }

        $exame = $this->pacientes_exames_model->get(array('protocolo' => $_GET["p"]));
        if (!$exame) {
            $exame = $this->pacientes_exames_model->get(array('protocolo' => strtoupper($_GET["p"])));
        }

        if (!$exame){
            header('Content-type: application/json');
            echo json_encode(array("erro" => "PROTOCOLO NAO ENCONTRADO! POR FAVOR VERIFIQUE SE DIGITOU CORRETAMENTE!", "codigo" => 1));
            return;
        }

        if ($exame['ativo'] == 0) {
            header('Content-type: application/json');
            echo json_encode(array("erro" => "PROTOCOLO NAO ENCONTRADO! POR FAVOR VERIFIQUE SE DIGITOU CORRETAMENTE!", "codigo" => 1));
            return;
        }

        $laudo = config_item('upload_folder'). "/laudos/" . $exame['arquivo_laudo'];

        if (!is_file($laudo)){
            header('Content-type: application/json');
            echo json_encode(array("erro" => "LAUDO NAO ENCONTRADO!", "codigo" => 2));
            return;
        }

        echo json_encode(array("laudo" => '"' . $exame['arquivo_laudo'] . '"'));
        
        //header("Content-Type: application/pdf");
        //header('Content-Disposition: attachment; filename="' . $laudo . '"');
        //header("Content-Length: " . filesize($laudo));
        //readfile($laudo);

    }

    function download($arquivo_laudo) {

    }

}