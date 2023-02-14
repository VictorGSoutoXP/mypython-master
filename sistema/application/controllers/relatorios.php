<?php if (!defined('BASEPATH')) die();
class Relatorios extends Main_Controller {
    
    public $headerRelStyle;
    public $oddRelStyle;
    public $evenRelStyle;

    public function __construct() {
        parent::__construct ();
        
        $this->load->library(array("PHPExcel" => "phpexcel"));
        
        $this->headerRelStyle = new PHPExcel_Style();
        
        $this->headerRelStyle->applyFromArray ( array (
            'fill' => array (
                'type' => PHPExcel_Style_Fill::FILL_SOLID, 
                'color' => array (
                    'argb' => 'FF999999' 
                ) 
            ), 
            'font' => array (
                'bold' => true, 
                'color' => array (
                    'argb' => 'FF333333' 
                ) 
            ), 
            'borders' => array (
                'allborders' => array (
                    'style' => PHPExcel_Style_Border::BORDER_THIN, 
                    'color' => array (
                        'argb' => 'FF333333' 
                    ) 
                ) 
            ) 
        ) );
        
        $this->evenRelStyle = new PHPExcel_Style ();
        
        $this->evenRelStyle->applyFromArray ( array (
            'fill' => array (
                'type' => PHPExcel_Style_Fill::FILL_SOLID, 
                'color' => array (
                    'argb' => 'FFf1f1f1' 
                ) 
            ), 
            'font' => array (
                'color' => array (
                    'argb' => 'FF666666' 
                ) 
            ), 
            'borders' => array (
                'allborders' => array (
                    'style' => PHPExcel_Style_Border::BORDER_THIN, 
                    'color' => array (
                        'argb' => 'FF333333' 
                    ) 
                ) 
            ) 
        ) );
        
        $this->oddRelStyle = new PHPExcel_Style ();
        
        $this->oddRelStyle->applyFromArray ( array (
            'fill' => array (
                'type' => PHPExcel_Style_Fill::FILL_SOLID, 
                'color' => array (
                    'argb' => 'FFffffff' 
                ) 
            ), 
            'font' => array (
                'color' => array (
                    'argb' => 'FF666666' 
                ) 
            ), 
            'borders' => array (
                'allborders' => array (
                    'style' => PHPExcel_Style_Border::BORDER_THIN, 
                    'color' => array (
                        'argb' => 'FF333333' 
                    ) 
                ) 
            ) 
        )
         );
    }

    public function index() {
        $this->load->view ( $this->_dataView );
    }

    public function exames() {
        
        if(!UserSession::isAdmin() && !UserSession::isCliente()){
            UserSession::notPermited();
        }
        
        if($post = $this->input->post()){

            $cliente = UserSession::isCliente() ? UserSession::getInstance()->getSession() : $post['cliente'];

            $params = array();
            $params['inicio'] = $post['inicio'];
            $params['fim'] = $post['fim'];
            $params['cliente'] = UserSession::isCliente() ? $cliente['id'] : $post['cliente'];
            $params['status'] = $post['status'];

            $exames = $this->pacientes_exames_model->relatorio($params);
            
            $titulo_relatorio = UserSession::isAdmin() ? "Relatório de Laudos" : "Relatório de Exames";
            
            $this->phpexcel->getProperties()->setCreator(config_item("lab_name"))
                ->setLastModifiedBy(config_item("lab_name"))
                ->setTitle($titulo_relatorio)
                ->setCategory($titulo_relatorio);
            
            $styleLaudado = array (
                'fill' => array (
                    'type' => PHPExcel_Style_Fill::FILL_SOLID, 
                    'color' => array (
                        'argb' => 'FFDDFFDD' 
                    ) 
                ) 
            );
            
            $styleAguardando = array (
                'fill' => array (
                    'type' => PHPExcel_Style_Fill::FILL_SOLID, 
                    'color' => array (
                        'argb' => 'FFEEFFEE' 
                    ) 
                ) 
            );
            
            $styleImpossibilitado = array (
                'fill' => array (
                    'type' => PHPExcel_Style_Fill::FILL_SOLID, 
                    'color' => array (
                        'argb' => 'FFCCCCFF' 
                    ) 
                ) 
            );
            
            
            if($exames){
                
                $activeSheet = $this->phpexcel->getActiveSheet();

                $activeSheet->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
                $activeSheet->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
                $activeSheet->getPageSetup()->setFitToPage(true);
                $activeSheet->getPageSetup()->setFitToWidth(1);
                $activeSheet->getPageSetup()->setFitToHeight(0);

                $activeSheet
                    ->setCellValue('A1', 'ID')
                    ->setCellValue('B1', 'Cliente')
                    ->setCellValue('C1', 'Data do Envio')
                    ->setCellValue('D1', 'Médico')
                    ->setCellValue('E1', 'Data do Laudo')
                    ->setCellValue('F1', 'Nome do Exame')
                    ->setCellValue('G1', 'Paciente')
                    ->setCellValue('H1', 'Empresa')
                    ->setCellValue('I1', 'Status');
                
                if (UserSession::isAdmin()) {
                    $activeSheet->setCellValue('J1', 'Laudo');
                }
                
                $i = 2;
                foreach ($exames as $exame) {
                    $dataExame = strtotime($exame['create_date']);
                    $dataLaudo = strtotime($exame['laudo_date']);
                    $statusExame = status_laudo($exame);
                    
                    $nomeExame = $exame['sub_tipo_exame'] ? $exame['nome_exame'] .  " - " . $exame['sub_tipo_exame'] : $exame['nome_exame'];
                    
                    $activeSheet
                        ->setCellValue('A' . $i, $exame['exame_id'])
                        ->setCellValue('B' . $i, $exame['cliente_nome'])
                        ->setCellValue('C' . $i, PHPExcel_Shared_Date::PHPToExcel( $dataExame ))
                        ->setCellValue('D' . $i, $exame['medico_nome'])
                        ->setCellValue('E' . $i, PHPExcel_Shared_Date::PHPToExcel( $dataLaudo ))
                        ->setCellValue('F' . $i, $nomeExame)
                        ->setCellValue('G' . $i, $exame['paciente_nome'])
                        ->setCellValue('H' . $i, $exame['paciente_empresa'])
                        ->setCellValue('I' . $i, $statusExame);

                    if (UserSession::isAdmin()) {
                        $laudo_content = html_entity_decode($exame['modelo_content']);
                        $laudo_content = str_replace(array('<br />', '<br/>'), ' ', $laudo_content);
                        $laudo_content = str_replace('  ', ' ', $laudo_content);
                        $laudo_content = strip_tags($laudo_content);
                        $activeSheet->setCellValue('J' . $i, $laudo_content);
                    }
                        
                    if($i%2){
                        $activeSheet->setSharedStyle($this->oddRelStyle, "A{$i}:J{$i}");
                    }else{
                        $activeSheet->setSharedStyle($this->evenRelStyle, "A{$i}:J{$i}");
                    }
                    
                    if($exame['status'] == 1){
                        $activeSheet->getStyle("A{$i}:J{$i}")->applyFromArray($styleLaudado);
                    }elseif($exame['status'] == 2){
                        $activeSheet->getStyle("A{$i}:J{$i}")->applyFromArray($styleImpossibilitado);
                    }else{
                        $activeSheet->getStyle("A{$i}:J{$i}")->applyFromArray($styleAguardando);
                    }
                    
                    $activeSheet->getStyle('C' . $i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DDMMYYYY);
                    $activeSheet->getStyle('E' . $i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DDMMYYYY);
                    $i++;
                }
                
                $activeSheet->getColumnDimension('A')->setAutoSize(true);
                $activeSheet->getColumnDimension('B')->setAutoSize(true);
                $activeSheet->getColumnDimension('C')->setAutoSize(true);
                $activeSheet->getColumnDimension('D')->setAutoSize(true);
                $activeSheet->getColumnDimension('E')->setAutoSize(true);
                $activeSheet->getColumnDimension('F')->setAutoSize(true);
                $activeSheet->getColumnDimension('G')->setAutoSize(true);
                $activeSheet->getColumnDimension('H')->setAutoSize(true);
                $activeSheet->getColumnDimension('I')->setAutoSize(true);
                $activeSheet->getColumnDimension('J')->setAutoSize(true);
                
                $this->phpexcel->setActiveSheetIndex(0);
                
                ob_get_clean();
                header('Content-Type: application/vnd.ms-excel');

                if (UserSession::isAdmin()) {
                    header('Content-Disposition: attachment;filename="Relatorio_Laudos_' . date("d_m_Y"). '.xls"');
                }
                else {
                    header('Content-Disposition: attachment;filename="Relatorio_Exames_' . date("d_m_Y"). '.xls"');
                }
                
                header('Cache-Control: max-age=0');
                
                $objWriter = PHPExcel_IOFactory::createWriter($this->phpexcel, 'Excel5');
                $objWriter->save('php://output');
                
                exit();
            }else{
                $this->_dataView['info'] = "Nenhum Exame com esses Critérios foi encontrado";
            }
            
        }
        
        $this->_dataView['clientes']  = $this->usuarios_model->get_all(array('tipo' => 'cliente'));
        $this->_dataView ['exames_select'] = $this->pacientes_exames_model->get_all ();
        
        $this->load->view ( $this->_dataView );
    }

    public function financeiro() {
        
        if(!UserSession::isAdmin()){
            UserSession::notPermited();
        }
        
        if($post = $this->input->post()){
            $params = array();
            $params['status'] = array(1,2); //Todos laudos
            $params['inicio'] = $post['inicio'];
            $params['fim'] = $post['fim'];
            $params['cliente'] = $post['cliente'] ? explode(",", $post['cliente']) : array();

            $usuario = $this->usuarios_model->get($params['cliente'][0]);

            $this->load->library("phpexcel");

            $exames = $this->pacientes_exames_model->relatorio($params);
            
            $this->phpexcel->getProperties()->setCreator(config_item("lab_name"))
                ->setLastModifiedBy(config_item("lab_name"))
                ->setTitle("Relatório Financeiro")
                ->setCategory("Relatorio Financeiro");
            
            
            $styleLaudado = array (
                    'fill' => array (
                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                            'color' => array (
                                    'argb' => 'FFDDFFDD'
                            )
                    )
            );
            
            $styleImpossibilitado = array (
                    'fill' => array (
                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                            'color' => array (
                                    'argb' => 'FFCCCCFF'
                            )
                    )
            );
            
            if($exames){
                
                $activeSheet = $this->phpexcel->getActiveSheet();

                $activeSheet->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
                $activeSheet->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
                $activeSheet->getPageSetup()->setFitToPage(true);
                $activeSheet->getPageSetup()->setFitToWidth(1);
                $activeSheet->getPageSetup()->setFitToHeight(0);

                $activeSheet
                    ->setCellValue('A1', 'ID')
                    ->setCellValue('B1', 'Cliente')
                    ->setCellValue('C1', 'Data do Envio')
                    ->setCellValue('D1', 'Médico')
                    ->setCellValue('E1', 'Data do Laudo')
                    ->setCellValue('F1', 'Nome do Exame')
                    ->setCellValue('G1', 'Paciente')
                    ->setCellValue('H1', 'Empresa')
                    ->setCellValue('I1', 'Valor do Exame R$')
                    ->setCellValue('J1', 'Telemedicina');
                    //->setCellValue('I1', 'Valor do Médico R$');
                
                $i = 2; $totalValorExames = 0; $totalValorExamesMedicos = 0;

                /**/

                $id_cliente = null;

                foreach ($exames as $exame) {
                    $dataExame = strtotime($exame['create_date']);
                    $dataLaudo = strtotime($exame['laudo_date']);
                    $totalValorExames += $exame['preco_exame'];
                    $totalValorExamesMedicos += $exame['preco_exame_medico'];
                    
                    $nomeExame = $exame['sub_tipo_exame'] ? $exame['nome_exame'] .  " - " . $exame['sub_tipo_exame'] : $exame['nome_exame'];
                    $empresa = (!isset($exame['empresa']) || trim($exame['empresa']) === '') ? 
                                "DAMATELEMEDICINA" : strtoupper($exame['empresa']);

                    $id_cliente = $id_cliente == null ? $exame['cliente_id'] : $id_cliente;

                    /**/
                    
                                
                    $activeSheet
                        ->setCellValue('A' . $i, $exame['exame_id'])
                        ->setCellValue('B' . $i, $exame['cliente_nome'])
                        ->setCellValue('C' . $i, PHPExcel_Shared_Date::PHPToExcel( $dataExame ))
                        ->setCellValue('D' . $i, $exame['medico_nome'])
                        ->setCellValue('E' . $i, PHPExcel_Shared_Date::PHPToExcel( $dataLaudo ))
                        ->setCellValue('F' . $i, $nomeExame)
                        ->setCellValue('G' . $i, $exame['paciente_nome'])
                        ->setCellValue('H' . $i, $exame['paciente_empresa'])
                        ->setCellValue('I' . $i, doubleval($exame['preco_exame']))
                        ->setCellValue('J' . $i, $empresa );

                        //->setCellValue('I' . $i, doubleval($exame['preco_exame_medico']));
                    
                    if($i%2){
                        $activeSheet->setSharedStyle($this->oddRelStyle, "A{$i}:I{$i}");
                        //$activeSheet->setSharedStyle($this->oddRelStyle, "A{$i}:I{$i}");
                    }else{
                        $activeSheet->setSharedStyle($this->evenRelStyle, "A{$i}:I{$i}");
                        //$activeSheet->setSharedStyle($this->evenRelStyle, "A{$i}:I{$i}");
                    }
                    
                    if($exame['status'] == 1){
                        $activeSheet->getStyle("A{$i}:I{$i}")->applyFromArray($styleLaudado);
                        //$activeSheet->getStyle("A{$i}:I{$i}")->applyFromArray($styleLaudado);
                    }elseif($exame['status'] == 2){
                        $activeSheet->getStyle("A{$i}:I{$i}")->applyFromArray($styleImpossibilitado);
                        //$activeSheet->getStyle("A{$i}:I{$i}")->applyFromArray($styleImpossibilitado);
                   }
                    
                    $activeSheet->getStyle('C' . $i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DDMMYYYY);
                    $activeSheet->getStyle('E' . $i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DDMMYYYY);
                    $activeSheet->getStyle('I' . $i)->getNumberFormat()->setFormatCode("R$ * 0.00"); //'R$ * 0.00'

                    $i++;
                }
                
                $totalExames = count($exames);
                
                $numLinha = ($i + 3);

                $activeSheet
                    ->setCellValue('B' . $numLinha, "Total de Exames")
                    ->setCellValue('C' . $numLinha, "Valor Total dos Exames")
                    //->setCellValue('D' . $numLinha, "Valor Total dos Médicos")
                    ->setCellValue('B' . ($numLinha + 1), $totalExames)
                    ->setCellValue('C' . ($numLinha + 1), $totalValorExames);
                    //->setCellValue('D' . ($numLinha + 1), $totalValorExamesMedicos);

                $activeSheet->getStyle('C' . ($numLinha + 1))->getNumberFormat()->setFormatCode("R$ * 0.00");

                //$activeSheet->setSharedStyle($this->headerRelStyle, "A1:I1");
                $activeSheet->setSharedStyle($this->headerRelStyle, "A1:I1");

                $activeSheet->setSharedStyle($this->evenRelStyle, "B{$numLinha}:C{$numLinha}");
                //$activeSheet->setSharedStyle($this->evenRelStyle, "B{$numLinha}:D{$numLinha}");

                $numLinha += 2;

                $activeSheet->setCellValue('B' . $numLinha, 'Depósitos Efetuados')
                    ->setCellValue('C' . $numLinha, 'Valor a Pagar')
                    ->setCellValue('C' . ($numLinha + 1), $totalValorExames);

                $activeSheet->getStyle('C' . ($numLinha + 1))->getNumberFormat()->setFormatCode("R$ * 0.00");
                $activeSheet->setSharedStyle($this->evenRelStyle, "B{$numLinha}:C{$numLinha}");

                $activeSheet->setCellValue('B' . ($numLinha + 1), $usuario['depositos']);

                $activeSheet->getColumnDimension('A')->setAutoSize(true);
                $activeSheet->getColumnDimension('B')->setAutoSize(true);
                $activeSheet->getColumnDimension('C')->setAutoSize(true);
                $activeSheet->getColumnDimension('D')->setAutoSize(true);
                $activeSheet->getColumnDimension('E')->setAutoSize(true);
                $activeSheet->getColumnDimension('F')->setAutoSize(true);
                $activeSheet->getColumnDimension('G')->setAutoSize(true);
                $activeSheet->getColumnDimension('H')->setAutoSize(true);
                $activeSheet->getColumnDimension('I')->setAutoSize(true);
                $activeSheet->getColumnDimension('J')->setAutoSize(true);
                //$activeSheet->getColumnDimension('I')->setAutoSize(true);
                
                $this->phpexcel->setActiveSheetIndex(0);
                
                ob_get_clean();

                $nome_cliente = $params['cliente'] ? $exame['cliente_nome'] : 'TODOS';

                /**/
               
                $excel_file_name = '"RF_' .  $id_cliente . '_' . $nome_cliente . '_' . $post['inicio'] . '.xls"';
                
                header('Content-Type: application/vnd.ms-excel');
                //header('Content-Disposition: attachment;filename= "Relatorio_Financeiro_' . date("d_m_Y"). '.xls"');
                header('Content-Disposition: attachment;filename='.$excel_file_name);

                header('Cache-Control: max-age=0');
                
                $objWriter = PHPExcel_IOFactory::createWriter($this->phpexcel, 'Excel5');
                $objWriter->save('php://output');
                
                exit();
                
            }else{
                $this->_dataView['info'] = "Nenhum Exame com esses Critérios foi encontrado";
            }
        }
        
        $this->_dataView['clientes']  = $this->usuarios_model->get_all(array('tipo' => 'cliente'));
        
        $this->load->view ( $this->_dataView );
    }

    public function medico() {
        
        if(!UserSession::isAdmin() && !UserSession::isMedico()){
            UserSession::notPermited();
        }
        
        if($post = $this->input->post()){
            $params = array();
            $params['status'] = array(1,2); //Todos laudos
            $params['inicio'] = $post['inicio'];
            $params['fim'] = $post['fim'];
            $params['medico'] = $post['medico'];

            if(!UserSession::isAdmin()){
                $params['medico'] = UserSession::user('id');
            }
            
            $params['cliente'] = $post['cliente'] ? explode(",", $post['cliente']) : array();
            
            $this->load->library("phpexcel");
            
            $exames = $this->pacientes_exames_model->relatorio($params);
            
            $this->phpexcel->getProperties()->setCreator(config_item("lab_name"))
                ->setLastModifiedBy(config_item("lab_name"))
                ->setTitle("Relatório Financeiro")
                ->setCategory("Relatorio Financeiro");
            
            
            $styleLaudado = array (
                    'fill' => array (
                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                            'color' => array (
                                    'argb' => 'FFDDFFDD'
                            )
                    )
            );
            
            $styleImpossibilitado = array (
                    'fill' => array (
                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                            'color' => array (
                                    'argb' => 'FFCCCCFF'
                            )
                    )
            );
            
            if($exames){
                
                $activeSheet = $this->phpexcel->getActiveSheet();

                $activeSheet->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
                $activeSheet->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
                $activeSheet->getPageSetup()->setFitToPage(true);
                $activeSheet->getPageSetup()->setFitToWidth(1);
                $activeSheet->getPageSetup()->setFitToHeight(0);

                $activeSheet
                    ->setCellValue('A1', 'ID')
                    ->setCellValue('B1', 'Médico')
                    //->setCellValue('C1', 'Cliente')
                    ->setCellValue('C1', 'Paciente')
                    ->setCellValue('D1', 'Data do Envio')
                    ->setCellValue('E1', 'Data do Laudo')
                    ->setCellValue('F1', 'Exame Laudado')
                    ->setCellValue('G1', 'Valor do Médico R$')
                    ->setCellValue('H1', 'Empresa');
                
                $i = 2;
                $medicos = array();
                foreach ($exames as $exame) {
                    if($exame['status'] != 1) continue; //Somente Laudados
                    $dataExame = strtotime($exame['create_date']);
                    $dataLaudo = strtotime($exame['laudo_date']);
                    
                    $medicos[$exame['medico_nome']]['totalValor'] += $exame['preco_exame_medico'];
                    $medicos[$exame['medico_nome']]['totalExames'] ++;
                    
                    $nomeExame = $exame['sub_tipo_exame'] ? $exame['nome_exame'] .  " - " . $exame['sub_tipo_exame'] : $exame['nome_exame'];
                    $empresa = (!isset($exame['empresa']) || trim($exame['empresa']) === '') ? 
                                "DAMATELEMEDICINA" : strtoupper($exame['empresa']);
                    $activeSheet
                        ->setCellValue('A' . $i, $exame['exame_id'])
                        ->setCellValue('B' . $i, $exame['medico_nome'])
                        ->setCellValue('C' . $i, $exame['paciente_nome'])
                        //->setCellValue('C' . $i, $exame['cliente_nome'])
                        ->setCellValue('D' . $i, PHPExcel_Shared_Date::PHPToExcel( $dataExame ))
                        ->setCellValue('E' . $i, PHPExcel_Shared_Date::PHPToExcel( $dataLaudo ))
                        ->setCellValue('F' . $i, $nomeExame)
                        ->setCellValue('G' . $i, doubleval($exame['preco_exame_medico']))
                        ->setCellValue('H' . $i, $empresa );
                    
                    if($i%2){
                        $activeSheet->setSharedStyle($this->oddRelStyle, "A{$i}:H{$i}");
                    }else{
                        $activeSheet->setSharedStyle($this->evenRelStyle, "A{$i}:H{$i}");
                    }
                    
                    $activeSheet->getStyle("A{$i}:H{$i}")->applyFromArray($styleLaudado);
                    
                    $activeSheet->getStyle('D' . $i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DDMMYYYY);
                    $activeSheet->getStyle('E' . $i)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DDMMYYYY);
                    $activeSheet->getStyle('G' . $i)->getNumberFormat()->setFormatCode("R$ * 0.00");

                    $i++;
                }
                
                $numLinha = $i + 3;
                
                if(UserSession::isAdmin()) {
                    $activeSheet->setCellValue('B' . $numLinha, "Médico");
                    $activeSheet->setSharedStyle($this->evenRelStyle, "B{$numLinha}:D{$numLinha}");
                } else {
                    $activeSheet->setSharedStyle($this->evenRelStyle, "C{$numLinha}:D{$numLinha}");
                }
                
                $activeSheet
                    ->setCellValue('C' . $numLinha, "Total de Exames")
                    ->setCellValue('D' . $numLinha, "Valor a Receber");
                
                foreach ($medicos as $k => $v){
                    
                    if(UserSession::isAdmin()) {
                        $activeSheet->setCellValue('B' . ($numLinha +1 ), $k);
                    }
                    $activeSheet
                        ->setCellValue('C' . ($numLinha + 1), $v['totalExames'])
                        ->setCellValue('D' . ($numLinha + 1), $v['totalValor']);

                    $activeSheet->getStyle('D' . ($numLinha + 1))->getNumberFormat()->setFormatCode("R$ * 0.00");

                    $numLinha ++;
                }
                
                $activeSheet->setSharedStyle($this->headerRelStyle, "A1:G1");
                $activeSheet->getColumnDimension('A')->setAutoSize(true);
                $activeSheet->getColumnDimension('B')->setAutoSize(true);
                $activeSheet->getColumnDimension('C')->setAutoSize(true);
                $activeSheet->getColumnDimension('D')->setAutoSize(true);
                $activeSheet->getColumnDimension('E')->setAutoSize(true);
                $activeSheet->getColumnDimension('F')->setAutoSize(true);
                $activeSheet->getColumnDimension('G')->setAutoSize(true);
                $activeSheet->getColumnDimension('H')->setAutoSize(true);
                
                $this->phpexcel->setActiveSheetIndex(0);
                
                ob_get_clean();

                $nome_medico = $params['medico'] ? $exame['medico_nome'] : 'TODOS';
                $excel_file_name = '"RM_' . $nome_medico . '_' . $post['inicio'] . '.xls"';

                header('Content-Type: application/vnd.ms-excel');
                //header('Content-Disposition: attachment;filename="Relatorio_Medico_' . date("d_m_Y"). '.xls"');
                header('Content-Disposition: attachment;filename='.$excel_file_name);

                header('Cache-Control: max-age=0');
                
                $objWriter = PHPExcel_IOFactory::createWriter($this->phpexcel, 'Excel5');
                $objWriter->save('php://output');
                
                exit();
            }else{
                $this->_dataView['info'] = "Nenhum Exame com esses Critérios foi encontrado";
            }
        }

        $this->_dataView['medicos']  = $this->usuarios_model->get_all(array('tipo' => 'medico'));

        $this->load->view ( $this->_dataView );
    }
   
}

/* End of file relatorios.php */
/* Location: ./application/controllers/relatorios.php */
