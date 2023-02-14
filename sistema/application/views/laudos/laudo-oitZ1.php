<link href="<?php echo base_url('assets/css/laudo-oit.css') ?>" rel="stylesheet" xmlns="http://www.w3.org/1999/html"/>
<div class="oit-container">
    <div style="height:30px;">
        <img src="<?php echo base_url('uploads/dama/oit/' . $exame['cliente_id'] . '-logo.jpg') ?>" alt="Logomarca">
    </div>
    <div style="font-size: 10px;padding-top: 10px;display: block"><b>FOLHA DE LEITURA RADIOLÓGICA - CLASSIFICAÇÃO INTERNACIONAL DE RADIOGRAFIAS DE PNEUMOCONIOSE - OIT 2011</b></div>
    <hr>

    <?php

        $nascimento = $exame['paciente']['nascimento'];
        $nascimento = $nascimento ? date('d/m/Y', strtotime($nascimento)) . "(" . $exame['paciente']['idade'] . ")" : "";

        $data_exame = $exame['exame_date'];
        $data_exame = $data_exame ? date('d/m/Y', strtotime($data_exame)) : "";

        $data_leitura = substr(date("Y-m-d H:i:s"), 0, 11) . "00:00:00";
        $data_leitura = $data_leitura ? date('d/m/Y', strtotime($data_leitura)) : "";

    ?>

    <div id="oit.body">
        <div>
            <div class="oit-box">
                <div style="float: left; width: 40%;">
                    <span class="oit-label">Nome:</span> <span class="oit-text"><?php echo $exame['paciente']['nome']?></span><br />
                    <span class="oit-label">Médico:</span> <span class="oit-text"><?php echo $exame['medico_solicitante']?> - <?php echo $exame['medico_solicitante_crm']?></span><br />
                    <span class="oit-label">Empresa:</span> <span class="oit-text"><?php echo $exame['paciente']['empresa']?></span>
                </div>
                <div>
                    <span class="oit-label">Motivo Exame:</span> <span class="oit-text"><?php echo $exame['motivo']?></span><br />
                    <span class="oit-label">Dt.Nasc.:</span> <span class="oit-text"><?php echo $nascimento; ?></span> Sexo: <span class="oit-text"><?php echo $exame['paciente']['sexo']; ?></span><br />
                    <span class="oit-label">RG:</span> <span class="oit-text"><?php echo $exame['paciente']['rg']?></span>
                </div>
            </div>
            <div class="oit-box">
                <div style="float: left; width: 40%;">
                    <span class="oit-label">Data do Exame:</span> <span class="oit-text"><?php echo $data_exame; ?></span><br />
                    <span class="oit-label">RX Digital:</span>
                    <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['rx_digital'] == 'S' ? '&#9745;' : '&#9744;' ?></span><span class="oit-choice">SIM</span>
                    <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['rx_digital'] == 'N' ? '&#9745;' : '&#9744;' ?></span><span class="oit-choice">NAO</span>
                </div>
                <div>
                    <span class="oit-label">Data da Leitura:</span>
                    <span class="oit-text"><?php echo $data_leitura; ?></span><br />

                    <span class="oit-label">Leitura em Negatoscópio:</span>
                    <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['negatoscopio'] == 'S' ? '&#9745;' : '&#9744;' ?></span><span class="oit-choice">SIM</span>
                    <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['negatoscopio'] == 'N' ? '&#9745;' : '&#9744;' ?></span><span class="oit-choice">NAO</span>

                </div>
            </div>
            <div class="oit-box">
                <div>
                    <div style="float: left;width: 270px;padding-right: 20px; border-right: 1px dashed black">
                        <span class="oit-label">1A) Qualidade técnica:</span>
                        <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['qualidade'] == '1' ? '&#9745;' : '&#9744;' ?></span><span class="oit-choice">1</span>
                        <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['qualidade'] == '2' ? '&#9745;' : '&#9744;' ?></span><span class="oit-choice">2</span>
                        <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['qualidade'] == '3' ? '&#9745;' : '&#9744;' ?></span><span class="oit-choice">3</span>
                        <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['qualidade'] == '4' ? '&#9745;' : '&#9744;' ?></span><span class="oit-choice">4</span>
                    </div>
                    <div>
                        <span class="oit-label">&nbsp;&nbsp;&nbsp;1B) Radiografia Normal:</span>
                        <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['normal'] == 'S' ? '&#9745;' : '&#9744;' ?></span><span class="oit-choice">SIM</span>
                        <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['normal'] == 'N' ? '&#9745;' : '&#9744;' ?></span><span class="oit-choice">NAO</span>
                    </div>
                    <span class="oit-label">Comentários:</span><span class="oit-text"><?php echo $exame['oit']['comentarios_qualidade']?></span>
                </div>
            </div>
            <div class="oit-box">
                <div>
                    <span class="oit-label">2A) Alguma anormalidade de parênquima consistente com pneumoconiose:</span>
                    <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['anormalidade_parenquima'] == 'S' ? '&#9745;' : '&#9744;' ?></span><span class="oit-choice">SIM</span>
                    <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['anormalidade_parenquima'] == 'N' ? '&#9745;' : '&#9744;' ?></span><span class="oit-choice">NAO</span>
                </div>
            </div>
            <div class="oit-box" style="height: 110px">
                <div style="float: left;width: 270px;padding-right: 20px; border-right: 1px dashed black">
                    <div>
                        <span class="oit-label">2B) Pequenas Opacidades</span>
                    </div>
                    <div>
                        <span class="oit-label">A) Formas e Tamanhos&nbsp;&nbsp;&nbsp;&nbsp;B) Zonas&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;C) Profusão</span>
                    </div>
                    <div>
                        <span class="oit-label">Primárias&nbsp;&nbsp;Secundárias</span>
                    </div>
                    <div>
                        <div style="float:left;width: 170px">
                            <div>
                                <div style="text-align: left">
                                    <!-- l1 primarias -->
                                    <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['primarias']=='P'?'&#9745;':'&#9744;'?></span><span class="oit-choice">p</span>
                                    <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['primarias']=='S'?'&#9745;':'&#9744;'?></span><span class="oit-choice">s</span>
                                    <!-- l1 secundarias -->
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['secundarias']=='P'?'&#9745;':'&#9744;'?></span><span class="oit-choice">p</span>
                                    <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['secundarias']=='S'?'&#9745;':'&#9744;'?></span><span class="oit-choice">s</span>
                                    <!-- l1 zonas -->
                                    &nbsp;&nbsp;&nbsp;
                                    <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['zonas_d1']=='S'?'&#9745;':'&#9744;'?></span><span class="oit-choice">D</span>
                                    <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['zonas_e1']=='S'?'&#9745;':'&#9744;'?></span><span class="oit-choice">E</span>
                                </div>
                            </div>
                            <div>
                                <div style="text-align: left">
                                    <!-- l2 primarias -->
                                    <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['primarias']=='Q'?'&#9745;':'&#9744;'?></span><span class="oit-choice">q</span>
                                    <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['primarias']=='T'?'&#9745;':'&#9744;'?></span><span class="oit-choice">t</span>
                                    &nbsp;&nbsp;&nbsp;
                                    <!-- l2 secundarias -->
                                    <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['secundarias']=='Q'?'&#9745;':'&#9744;'?></span><span class="oit-choice">q</span>
                                    <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['secundarias']=='T'?'&#9745;':'&#9744;'?></span><span class="oit-choice">t</span>
                                    &nbsp;&nbsp;&nbsp;
                                    <!-- l2 zonas -->
                                    <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['zonas_d2']=='S'?'&#9745;':'&#9744;'?></span><span class="oit-choice">D</span>
                                    <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['zonas_e2']=='S'?'&#9745;':'&#9744;'?></span><span class="oit-choice">E</span>

                                </div>
                            </div>
                            <div>
                                <div style="text-align: left"   >

                                    <!-- l3 primarias -->
                                    <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['primarias']=='R'?'&#9745;':'&#9744;'?></span><span class="oit-choice">r</span>
                                    <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['primarias']=='U'?'&#9745;':'&#9744;'?></span><span class="oit-choice">u</span>
                                    &nbsp;&nbsp;&nbsp;
                                    <!-- l3 secundarias -->
                                    <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['secundarias']=='R'?'&#9745;':'&#9744;'?></span><span class="oit-choice">r</span>
                                    <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['secundarias']=='U'?'&#9745;':'&#9744;'?></span><span class="oit-choice">u</span>
                                    &nbsp;&nbsp;&nbsp;
                                    <!-- l3 zonas -->
                                    <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['zonas_d3']=='S'?'&#9745;':'&#9744;'?></span><span class="oit-choice">D</span>
                                    <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['zonas_e3']=='S'?'&#9745;':'&#9744;'?></span><span class="oit-choice">E</span>

                                </div>
                            </div>
                        </div>
                        <div style="float: left">
                            <div style="width:160px">
                                <div style="text-align: left">
                                    <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['profusao'] == '0/-' ? '&#9745;' : '&#9744;' ?></span><span class="oit-choice">0/-</span>
                                    <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['profusao'] == '0/0' ? '&#9745;' : '&#9744;' ?></span><span class="oit-choice">0/0</span>
                                    <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['profusao'] == '0/1' ? '&#9745;' : '&#9744;' ?></span><span class="oit-choice">0/1</span>
                                </div>
                            </div>
                            <div style="width:160px">
                                <div style="text-align: left">
                                    <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['profusao'] == '1/0' ? '&#9745;' : '&#9744;' ?></span><span class="oit-choice">1/0</span>
                                    <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['profusao'] == '1/1' ? '&#9745;' : '&#9744;' ?></span><span class="oit-choice">1/1</span>
                                    <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['profusao'] == '1/2' ? '&#9745;' : '&#9744;' ?></span><span class="oit-choice">1/2</span>
                                </div>
                            </div>
                            <div style="width:160px">
                                <div style="text-align: left">
                                    <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['profusao'] == '2/0' ? '&#9745;' : '&#9744;' ?></span><span class="oit-choice">2/0</span>
                                    <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['profusao'] == '2/1' ? '&#9745;' : '&#9744;' ?></span><span class="oit-choice">2/1</span>
                                    <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['profusao'] == '2/2' ? '&#9745;' : '&#9744;' ?></span><span class="oit-choice">2/2</span>
                                </div>
                            </div>
                            <div style="width:162px">
                                <div style="text-align: left">
                                    <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['profusao'] == '3/0' ? '&#9745;' : '&#9744;' ?></span><span class="oit-choice">3/0</span>
                                    <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['profusao'] == '3/1' ? '&#9745;' : '&#9744;' ?></span><span class="oit-choice">3/1</span>
                                    <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['profusao'] == '3/+' ? '&#9745;' : '&#9744;' ?></span><span class="oit-choice">3/+</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    &nbsp;&nbsp;&nbsp;<span class="oit-label">2C) Grandes Opacidades</span><br />
                    &nbsp;&nbsp;&nbsp;<span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['grd_opacidade'] == '0' ? '&#9745;' : '&#9744;' ?></span>
                    <span class="oit-choice">0 </span>

                    <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['grd_opacidade'] == 'A' ? '&#9745;' : '&#9744;' ?></span>
                    <span class="oit-choice">A</span>

                    <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['grd_opacidade'] == 'B' ? '&#9745;' : '&#9744;' ?></span>
                    <span class="oit-choice">B</span>

                    <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['grd_opacidade'] == 'C' ? '&#9745;' : '&#9744;' ?></span>
                    <span class="oit-choice">C</span>
                </div>
            </div>
            <!-- 3A -->
            <div class="oit-box">
                <span class="oit-label">3A) Alguma anormalidade pleural consistente com pneumoconiose:</span>
                <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['anormalidade_pleural'] == 'S' ? '&#9745;' : '&#9744;' ?></span><span class="oit-choice">SIM</span>
                <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['anormalidade_pleural'] == 'N' ? '&#9745;' : '&#9744;' ?></span><span class="oit-choice">NÃO</span>
            </div>
            <!-- 3B -->
            <div class="oit-box" style="height: 120px">
                <div style="width: 300px">
                    <span class="oit-label">3B) Placas Pleurais:</span>
                    <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['placas_pleurais'] == 'S' ? '&#9745;' : '&#9744;' ?></span><span class="oit-choice">SIM</span>
                    <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['placas_pleurais'] == 'N' ? '&#9745;' : '&#9744;' ?></span><span class="oit-choice">NÃO</span>
                </div>
                <div style="float: left;">
                    <div style="float: left;width: 80px">
                        <div>
                            <div style="padding-top: 15px;"><span class="oit-label-block-10">Parede em perfil:</span></div>
                            <div style="padding-top: 7px;"><span class="oit-label-block-10">Frontal:</span></div>
                            <div style="padding-top: 7px;"><span class="oit-label-block-10">Diafragma:</span></div>
                            <div style="padding-top: 7px;"><span class="oit-label-block-10">Outros locais:</span></div>
                        </div>
                    </div>
                    <div style="float: left;width: 15%">
                            <div class="oit-label">Local</div>
                            <div>
                                <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['placas_parede_local_0'] == 'S' ? '&#9745;' : '&#9744;' ?></span>
                                <span class="oit-choice">0 </span>
                                <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['placas_parede_local_D'] == 'S' ? '&#9745;' : '&#9744;' ?></span>
                                <span class="oit-choice">D</span>
                                <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['placas_parede_local_E'] == 'S' ? '&#9745;' : '&#9744;' ?></span>
                                <span class="oit-choice">E</span>
                            </div>
                            <div>
                                <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['placas_frontal_local_0'] == 'S' ? '&#9745;' : '&#9744;' ?></span>
                                <span class="oit-choice">0 </span>
                                <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['placas_frontal_local_D'] == 'S' ? '&#9745;' : '&#9744;' ?></span>
                                <span class="oit-choice">D</span>
                                <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['placas_frontal_local_E'] == 'S' ? '&#9745;' : '&#9744;' ?></span>
                                <span class="oit-choice">E</span>
                            </div>
                            <div>
                                <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['placas_diafrag_local_0'] == 'S' ? '&#9745;' : '&#9744;' ?></span>
                                <span class="oit-choice">0 </span>
                                <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['placas_diafrag_local_D'] == 'S' ? '&#9745;' : '&#9744;' ?></span>
                                <span class="oit-choice">D</span>
                                <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['placas_diafrag_local_E'] == 'S' ? '&#9745;' : '&#9744;' ?></span>
                                <span class="oit-choice">E</span>
                            </div>
                            <div>
                                <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['placas_outros_local_0'] == 'S' ? '&#9745;' : '&#9744;' ?></span>
                                <span class="oit-choice">0 </span>
                                <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['placas_outros_local_D'] == 'S' ? '&#9745;' : '&#9744;' ?></span>
                                <span class="oit-choice">D</span>
                                <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['placas_outros_local_E'] == 'S' ? '&#9745;' : '&#9744;' ?></span>
                                <span class="oit-choice">E</span>
                            </div>
                    </div>
                    <div style="float: left; width: 15%;">
                            <div><span class="oit-label" style="text-align: center">Calcificação</span></div>
                            <div>
                                <div>
                                    <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['placas_parede_calcif_0'] == 'S' ? '&#9745;' : '&#9744;' ?></span>
                                    <span class="oit-choice">0 </span>
                                    <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['placas_parede_calcif_D'] == 'S' ? '&#9745;' : '&#9744;' ?></span>
                                    <span class="oit-choice">D</span>
                                    <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['placas_parede_calcif_E'] == 'S' ? '&#9745;' : '&#9744;' ?></span>
                                    <span class="oit-choice">E </span>
                                </div>
                                <div>
                                    <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['placas_frontal_calcif_0'] == 'S' ? '&#9745;' : '&#9744;' ?></span>
                                    <span class="oit-choice">0 </span>
                                    <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['placas_frontal_calcif_D'] == 'S' ? '&#9745;' : '&#9744;' ?></span>
                                    <span class="oit-choice">D</span>
                                    <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['placas_frontal_calcif_E'] == 'S' ? '&#9745;' : '&#9744;' ?></span>
                                    <span class="oit-choice">E</span>
                                </div>
                                <div>
                                    <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['placas_diafrag_calcif_0'] == 'S' ? '&#9745;' : '&#9744;' ?></span>
                                    <span class="oit-choice">0 </span>
                                    <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['placas_diafrag_calcif_D'] == 'S' ? '&#9745;' : '&#9744;' ?></span>
                                    <span class="oit-choice">D</span>
                                    <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['placas_diafrag_calcif_E'] == 'S' ? '&#9745;' : '&#9744;' ?></span>
                                    <span class="oit-choice">E</span>
                                </div>
                                <div>
                                    <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['placas_outros_calcif_0'] == 'S' ? '&#9745;' : '&#9744;' ?></span>
                                    <span class="oit-choice">0 </span>
                                    <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['placas_outros_calcif_D'] == 'S' ? '&#9745;' : '&#9744;' ?></span>
                                    <span class="oit-choice">D</span>
                                    <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['placas_outros_calcif_E'] == 'S' ? '&#9745;' : '&#9744;' ?></span>
                                    <span class="oit-choice">E</span>
                                </div>
                            </div>
                    </div>
                    <div style="float: left;width: 30%">
                        <span class="oit-label">Extensão parede(combinado em <br />perfil e frontal)</span>
                        <div>
                            <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['placas_extensao_o_d_0'] == 'S' ? '&#9745;' : '&#9744;' ?></span>
                            <span class="oit-choice">0 </span>
                            <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['placas_extensao_o_d_D'] == 'S' ? '&#9745;' : '&#9744;' ?></span>
                            <span class="oit-choice">D</span>
                            <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['placas_extensao_o_d_1'] == 'S' ? '&#9745;' : '&#9744;' ?></span>
                            <span class="oit-choice">1</span>
                            <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['placas_extensao_o_d_2'] == 'S' ? '&#9745;' : '&#9744;' ?></span>
                            <span class="oit-choice">2</span>
                            <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['placas_extensao_o_d_3'] == 'S' ? '&#9745;' : '&#9744;' ?></span>
                            <span class="oit-choice">3</span>
                        </div>
                        <div>
                            <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['placas_extensao_o_e_0'] == 'S' ? '&#9745;' : '&#9744;' ?></span>
                            <span class="oit-choice">0 </span>
                            <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['placas_extensao_o_e_E'] == 'S' ? '&#9745;' : '&#9744;' ?></span>
                            <span class="oit-choice">E</span>
                            <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['placas_extensao_o_e_1'] == 'S' ? '&#9745;' : '&#9744;' ?></span>
                            <span class="oit-choice">1</span>
                            <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['placas_extensao_o_e_2'] == 'S' ? '&#9745;' : '&#9744;' ?></span>
                            <span class="oit-choice">2</span>
                            <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['placas_extensao_o_e_3'] == 'S' ? '&#9745;' : '&#9744;' ?></span>
                            <span class="oit-choice">3</span>
                        </div>
                        <span style="font-size: 10px">Até 1/4 da parede lateral = 1<br />1/4 à 1/2 da parede lateral = 2<br />> 1/2 da parede lateral = 3</span>
                    </div>
                    <div style="float: left;width: 20%">
                        <span class="oit-label">Largura(Opcional)(Mínimo de 3mm para marcação)</span>
                        <div>
                            <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['placas_largura_d_D'] == 'S' ? '&#9745;' : '&#9744;' ?></span>
                            <span class="oit-choice">D</span>
                            <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['placas_largura_d_A'] == 'S' ? '&#9745;' : '&#9744;' ?></span>
                            <span class="oit-choice">a</span>
                            <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['placas_largura_d_B'] == 'S' ? '&#9745;' : '&#9744;' ?></span>
                            <span class="oit-choice">b</span>
                            <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['placas_largura_d_C'] == 'S' ? '&#9745;' : '&#9744;' ?></span>
                            <span class="oit-choice">c</span>
                        </div>
                        <div>
                            <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['placas_largura_e_E'] == 'S' ? '&#9745;' : '&#9744;' ?></span>
                            <span class="oit-choice">E</span>
                            <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['placas_largura_e_A'] == 'S' ? '&#9745;' : '&#9744;' ?></span>
                            <span class="oit-choice">a</span>
                            <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['placas_largura_e_B'] == 'S' ? '&#9745;' : '&#9744;' ?></span>
                            <span class="oit-choice">b</span>
                            <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['placas_largura_e_C'] == 'S' ? '&#9745;' : '&#9744;' ?></span>
                            <span class="oit-choice">c</span>
                        </div>
                        <span style="font-size: 10px">3 à 5mm = A<br />5 à 10mm = B<br />> 10mm = C</span>
                    </div>
                </div>
            </div>
            <!-- 3C -->
            <div class="oit-box">
                <span class="oit-label">3C) Obliteração do seio costofrênico:</span>
                <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['obliteracao_0'] == 'S' ? '&#9745;' : '&#9744;' ?></span>
                <span class="oit-choice">0 </span>
                <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['obliteracao_D'] == 'S' ? '&#9745;' : '&#9744;' ?></span>
                <span class="oit-choice">D </span>
                <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['obliteracao_E'] == 'S' ? '&#9745;' : '&#9744;' ?></span>
                <span class="oit-choice">E </span>
            </div>
            <!-- 3D -->
            <div class="oit-box" style="height: 120px">
                <div>
                    <span class="oit-label">3D) Espessamento pleural difuso:</span>
                    <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['espessamento_pleural'] == 'S' ? '&#9745;' : '&#9744;' ?></span><span class="oit-choice">SIM</span>
                    <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['espessamento_pleural'] == 'N' ? '&#9745;' : '&#9744;' ?></span><span class="oit-choice">NÃO</span>
                </div>

                <div style="float: left;">
                    <div style="float: left;width: 80px">
                        <div>
                            <div style="padding-top: 15px;"><span class="oit-label-block-10">Parede em perfil:</span></div>
                            <div style="padding-top: 7px;"><span class="oit-label-block-10">Frontal:</span></div>
                        </div>
                    </div>
                    <div style="float: left;width: 15%">
                        <div class="oit-label">Local</div>
                        <div>
                            <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['espes_parede_local_0'] == 'S' ? '&#9745;' : '&#9744;' ?></span>
                            <span class="oit-choice">0 </span>
                            <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['espes_parede_local_D'] == 'S' ? '&#9745;' : '&#9744;' ?></span>
                            <span class="oit-choice">D</span>
                            <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['espes_parede_local_E'] == 'S' ? '&#9745;' : '&#9744;' ?></span>
                            <span class="oit-choice">E</span>
                        </div>
                        <div>
                            <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['espes_frontal_local_0'] == 'S' ? '&#9745;' : '&#9744;' ?></span>
                            <span class="oit-choice">0 </span>
                            <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['espes_frontal_local_D'] == 'S' ? '&#9745;' : '&#9744;' ?></span>
                            <span class="oit-choice">D</span>
                            <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['espes_frontal_local_E'] == 'S' ? '&#9745;' : '&#9744;' ?></span>
                            <span class="oit-choice">E</span>
                        </div>
                    </div>
                    <div style="float: left; width: 15%;">
                        <div><span class="oit-label" style="text-align: center">Calcificação</span></div>
                        <div>
                            <div>
                                <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['espes_parede_calcif_0'] == 'S' ? '&#9745;' : '&#9744;' ?></span>
                                <span class="oit-choice">0 </span>
                                <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['espes_parede_calcif_D'] == 'S' ? '&#9745;' : '&#9744;' ?></span>
                                <span class="oit-choice">D</span>
                                <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['espes_parede_calcif_E'] == 'S' ? '&#9745;' : '&#9744;' ?></span>
                                <span class="oit-choice">E </span>
                            </div>
                            <div>
                                <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['espes_frontal_calcif_0'] == 'S' ? '&#9745;' : '&#9744;' ?></span>
                                <span class="oit-choice">0 </span>
                                <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['espes_frontal_calcif_D'] == 'S' ? '&#9745;' : '&#9744;' ?></span>
                                <span class="oit-choice">D</span>
                                <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['espes_frontal_calcif_E'] == 'S' ? '&#9745;' : '&#9744;' ?></span>
                                <span class="oit-choice">E</span>
                            </div>
                        </div>
                    </div>
                    <div style="float: left;width: 30%">
                        <span class="oit-label">Extensão parede(combinado em <br />perfil e frontal)</span>
                        <div>
                            <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['espes_extensao_o_d_0'] == 'S' ? '&#9745;' : '&#9744;' ?></span>
                            <span class="oit-choice">0 </span>
                            <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['espes_extensao_o_d_D'] == 'S' ? '&#9745;' : '&#9744;' ?></span>
                            <span class="oit-choice">D</span>
                            <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['espes_extensao_o_d_1'] == 'S' ? '&#9745;' : '&#9744;' ?></span>
                            <span class="oit-choice">1</span>
                            <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['espes_extensao_o_d_2'] == 'S' ? '&#9745;' : '&#9744;' ?></span>
                            <span class="oit-choice">2</span>
                            <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['espes_extensao_o_d_3'] == 'S' ? '&#9745;' : '&#9744;' ?></span>
                            <span class="oit-choice">3</span>
                        </div>
                        <div>
                            <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['espes_extensao_o_e_0'] == 'S' ? '&#9745;' : '&#9744;' ?></span>
                            <span class="oit-choice">0 </span>
                            <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['espes_extensao_o_e_E'] == 'S' ? '&#9745;' : '&#9744;' ?></span>
                            <span class="oit-choice">E</span>
                            <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['espes_extensao_o_e_1'] == 'S' ? '&#9745;' : '&#9744;' ?></span>
                            <span class="oit-choice">1</span>
                            <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['espes_extensao_o_e_2'] == 'S' ? '&#9745;' : '&#9744;' ?></span>
                            <span class="oit-choice">2</span>
                            <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['espes_extensao_o_e_3'] == 'S' ? '&#9745;' : '&#9744;' ?></span>
                            <span class="oit-choice">3</span>
                        </div>
                        <span style="font-size: 10px">Até 1/4 da parede lateral = 1<br />1/4 à 1/2 da parede lateral = 2<br />> 1/2 da parede lateral = 3</span>
                    </div>
                    <div style="float: left;width: 20%">
                        <span class="oit-label">Largura(Opcional)(Mínimo de 3mm para marcação)</span>
                        <div>
                            <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['espes_largura_d_D'] == 'S' ? '&#9745;' : '&#9744;' ?></span>
                            <span class="oit-choice">D</span>
                            <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['espes_largura_d_A'] == 'S' ? '&#9745;' : '&#9744;' ?></span>
                            <span class="oit-choice">a</span>
                            <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['espes_largura_d_B'] == 'S' ? '&#9745;' : '&#9744;' ?></span>
                            <span class="oit-choice">b</span>
                            <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['espes_largura_d_C'] == 'S' ? '&#9745;' : '&#9744;' ?></span>
                            <span class="oit-choice">c</span>
                        </div>
                        <div>
                            <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['espes_largura_e_E'] == 'S' ? '&#9745;' : '&#9744;' ?></span>
                            <span class="oit-choice">E</span>
                            <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['espes_largura_e_A'] == 'S' ? '&#9745;' : '&#9744;' ?></span>
                            <span class="oit-choice">a</span>
                            <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['espes_largura_e_B'] == 'S' ? '&#9745;' : '&#9744;' ?></span>
                            <span class="oit-choice">b</span>
                            <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['espes_largura_e_C'] == 'S' ? '&#9745;' : '&#9744;' ?></span>
                            <span class="oit-choice">c</span>
                        </div>
                        <span style="font-size: 10px">3 à 5mm = A<br />5 à 10mm = B<br />> 10mm = C</span>
                    </div>
                </div>
            </div>
            <!-- 4A -->
            <div class="oit-box">
                <span class="oit-label">4A) Outras anormalidades:</span>
                <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['outras_anormalidades'] == 'S' ? '&#9745;' : '&#9744;' ?></span>
                <span class="oit-choice">SIM</span>
                <span style="font-family: wingdings; font-size: 150%;"><?php echo $exame['oit']['outras_anormalidades'] == 'N' ? '&#9745;' : '&#9744;' ?></span>
                <span class="oit-choice">NÃO</span>
            </div>
            <!-- 4B -->
            <div class="oit-box">
                <div>
                    <span class="oit-label">4B) Símbolos:</span>
                    <?php
                        $simbolos = array(
                            'aa' => 'aorta aterosclerótica',
                            'at' => 'espessamento pleural apical significativo',
                            'ax' => 'coalescência de pequenas opacidades',
                            'bu' => 'bolhas',
                            'ca' => 'câncer',
                            'cg' => 'nódulos não pneumoconióticos calcificados',
                            'cn' => 'calcificação de pequenas opacidades pneumoconióticas',
                            'co' => 'anormalidade de forma e tamanho do coração',
                            'cp' => 'cor pulmonale',
                            'cv' => 'cavidade',
                            'di' => 'distorção significativa de estrutura intratorácica',
                            'ef' => 'derrame pleural',
                            'em' => 'enfisema',
                            'es' => 'calcificações em casca de ovo',
                            'fr' => 'fratura(s) de costela(s) recente(s) ou consolidadas',
                            'hi' => 'Aumento de gânglios hilares e/ou mediastinais',
                            'ho' => 'faveolamento',
                            'id' => 'borda diafragmática mal definida',
                            'ih' => 'borda cardíaca mal definida',
                            'kl' => 'linhas septais (kerley)',
                            'me' => 'mesotelioma',
                            'pa' => 'atelectasia laminar',
                            'pb' => 'banda(s) parenquimatosa(s)',
                            'pi' => 'espessamento pleural de cisura(s) interlobar(es)',
                            'px' => 'pneumotórax',
                            'ra' => 'atelectasia redonda',
                            'rp' => 'pneumoconiose reumática',
                            'tb' => 'tuberculose',
                            'od' => 'outras doenças'
                        );
                        $legenda = '';
                        foreach ($simbolos as $key => $value){
                            $id = 'simbolos_' . $key;
                            if ($exame['oit'][$id] == 'S') {
                                echo "<span style='font-family: wingdings; font-size: 150%;'>&#9745;" . $key . "</span>";
                                $legenda .= $key . '(' . $value . ');';
                            }
                        }
                    ?>
                </div>
                <div>
                    <span style="font-size: 10px"><i>
                        &nbsp; Legenda: <?php echo $legenda; ?>
                    </i></span>
                </div>
            </div>
            <!-- 4C -->
            <div class="oit-box">
                <div style="float: left;width: 70%">
                    4C) Comentarios:<br />
                    <?php echo $exame['oit']['comentarios_laudo'] ?>
                </div>
                <div>
                    Assinatura:<br />
                    <img src="<?php echo base_url('uploads/dama/oit/' . $exame['medico_id'] . '-sign.jpg') ?>" alt="Assinatura">
                </div>
            </div>

        </div>
    </div>
</div>
