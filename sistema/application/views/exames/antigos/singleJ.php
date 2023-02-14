<?php echo $this->load->view('layouts/menu',false,true,false); ?>

<script src="<?php echo base_url('assets/js/ckeditor/ckeditor.js') ?>"></script>

<!--
<div id="areaA" style="height: 1700px; width: 1200px;"></div>

<div id="exame_imagem" style="display: none;">
	<?php if($exame['arquivo_imagem']){?>
		<img src="<?php echo site_url("uploads/dama/exames/" . $exame['arquivo_imagem'])?>" alt="Arquivo de imagem">
	<?php } else { ?>
		<h3>Nenhuma imagem disponível!</h3>
	<?php }?>
</div>
-->
<div id="exame_container">
<div class="row">
    <div class="span12">
    	    <fieldset>
    	    	<legend>Exame</legend>

    	    	<div class="row">
    		    	<div class="span5">						
    					<input type="text" disabled="disabled" value="<?php echo $exame['exame']?> <?php echo $exame['sub_tipo_exame']?>" id="exame[exame]" class="span4" />
    				</div>
    	    	</div>
    	    </fieldset>
    	    <fieldset>
    	    	<legend>Dados do Paciente</legend>
    	    	<?php echo $exame['paciente_view']?>
		    </fieldset>
		    <fieldset>
		    	<legend>Dados do Exame</legend>
		    	<div class="row">
			    	<div class="span3">
						<label for="exame[medico]">Médico Solicitante</label>
    	                <input type="text" disabled="disabled" value="<?php echo $exame['medico_solicitante']?>" id="exame[medico]" class="span3" />
					</div>
<!--
					<div class="span3">
						<label for="exame[motivo]">Motivo Exame</label>
    	                <input type="text" disabled="disabled" value="<?php echo $exame['motivo']?>" id="exame[motivo]" class="span3" />
    	            </div>
-->
					<div class="span3" id="motivo-exame-container">
						<label for="exame[motivo]">Motivo Exame</label>
						<select disabled="disabled" name="exame[motivo]" id="exame[motivo]" class="span3 required" data-placeholder="Selecione o Motivo">
							<option value=""></option>
							<?php foreach ($motivos as  $motivo){?>
								<option value="<?php echo $motivo['id']?>"<?php echo $exame['motivo'] == $motivo['nome'] ? ' selected="selected"' : ''?>><?php echo $motivo['nome']; ?></option>
							<?php }?>
						</select>
					</div>

			    	<div class="span3">
						<label for="exame[tipo_laudo]">Tipo de Laudo</label>
    	                <input type="text" disabled="disabled" value="<?php echo $exame['tipo_laudo']?>" id="exame[tipo_laudo]" class="span3" />
					</div>
					<div class="span2">
						<label for="exame[data_exame]">Data do exame</label>
						<input type="text" disabled="disabled" id="exame[data_exame]" class="span2 data required" name="exame[data_exame]" value="<?php echo date('d/m/Y', strtotime($exame['exame_date']))?>" />
					</div>
    	    	</div>

				<div id="form-acuidade-container" <?php echo $exame['exame_id'] == 6 ? '': 'style="display:none"' ?> >

					<div class="row">

						<div class="span3">
							<label for="exame[acuidade_longe_od]">Acuidade Visual LONGE - OD</label>
							<input type="text" disabled="disabled" id="exame[acuidade_longe_od]"
								   name="exame[acuidade_longe_od]" value="<?php echo $exame['acuidade_longe_od'] ?>" />
						</div>

						<div class="span3">
							<label for="exame[acuidade_longe_oe]">Acuidade Visual LONGE - OE</label>
							<input type="text" disabled="disabled" id="exame[acuidade_longe_oe]"
								   name="exame[acuidade_longe_oe]" value="<?php echo $exame['acuidade_longe_oe'] ?>" />
						</div>

						<div class="span3">
							<label for="exame[acuidade_perto_od]">Acuidade Visual PERTO - OD</label>
							<input type="text" disabled="disabled" id="exame[acuidade_perto_od]"
								   name="exame[acuidade_perto_od]" value="<?php echo $exame['acuidade_perto_od'] ?>" />
						</div>


						<div class="span3">
							<label for="exame[acuidade_perto_oe]">Acuidade Visual PERTO - OE</label>
							<input type="text" disabled="disabled" id="exame[acuidade_perto_oe]"
								   name="exame[acuidade_perto_oe]" value="<?php echo $exame['acuidade_perto_oe'] ?>" />
						</div>

					</div>

					<div class="row">


						<div class="span3">
							<strong>Fez uso de lente corretiva?</strong><br />
							<input type="radio" disabled="disabled" name="exame[lente_corretiva]" value="SIM"
								<?php echo $exame['lente_corretiva'] == 'SIM' ? 'checked="checked"' : ''?>> SIM
							<input type="radio" disabled="disabled" name="exame[lente_corretiva]" value="NAO"
								<?php echo $exame['lente_corretiva'] == 'NAO' ? 'checked="checked"' : ''?>> NÃO
						</div>

						<div class="span3">
							<strong>Senso cromático</strong><br />
							<input type="radio" disabled="disabled" name="exame[senso_cromatico]" value="OK"
								<?php echo $exame['senso_cromatico'] == 'OK' ? 'checked="checked"' : ''?>> OK
							<input type="radio" disabled="disabled" name="exame[senso_cromatico]" value="NAO"
								<?php echo $exame['senso_cromatico'] == 'NAO_OK' ? 'checked="checked"' : ''?>> NÃO OK
						</div>

						<div class="span3">
							<strong>Recuperação da Visão Noturna</strong><br />
							<input type="radio" disabled="disabled" name="exame[visao_noturna]" value="OK"
								<?php echo $exame['visao_noturna'] == 'OK' ? 'checked="checked"' : ''?>> OK
							<input type="radio" disabled="disabled" name="exame[visao_noturna]" value="NAO"
								<?php echo $exame['visao_noturna'] == 'NAO_OK' ? 'checked="checked"' : ''?>> NÃO OK
						</div>

						<div class="span3">
							<strong>Recuperação da Visão Ofuscada</strong><br />
							<input type="radio" disabled="disabled" name="exame[visao_ofuscada]" value="OK"
								<?php echo $exame['visao_ofuscada'] == 'OK' ? 'checked="checked"' : ''?>> OK
							<input type="radio" disabled="disabled" name="exame[visao_ofuscada]" value="NAO"
								<?php echo $exame['visao_ofuscada'] == 'NAO_OK' ? 'checked="checked"' : ''?>> NÃO OK
						</div>

					</div>


					<div class="row">

						<div class="span3">
							<strong>Profundidade</strong><br />
							<input type="radio" disabled="disabled" name="exame[profundidade]" value="OK"
								<?php echo $exame['profundidade'] == 'OK' ? 'checked="checked"' : ''?>> OK
							<input type="radio" disabled="disabled" name="exame[profundidade]" value="NAO"
								<?php echo $exame['profundidade'] == 'NAO_OK' ? 'checked="checked"' : ''?>> NÃO OK
						</div>

					</div>

				</div>

				<br />


				<div class="row">

    	    		<div class="span8">
    	                <label for="exame[observacoes]">Observações</label>
    	                <textarea disabled="disabled" id="exame[observacoes]" cols="30" rows="4" class="span8"><?php echo $exame['observacoes']; ?></textarea>
						<?php if($exame['reenviar_exame'] == "S") { ?>
							<span style="color:red;font-size:14px"><strong>ESSE EXAME FOI REENVIADO!</strong>
						<?php } ?>
    	    		</div>

    	    		<div class="span4">
    	    			<?php if($exame['emergencia']){?>
    	    	            <div class="control-group clearfix">
    	    	                <div class="clearfix"><strong class="text-error">Emergência</strong></div>
    	    	            </div>
    	                <?php }?>
        	            <div class="control-group clearfix">
							<?php
								$balloon = $usuario['mensagem_exames'] ? 'data-balloon-length="large" data-balloon="' . $usuario['mensagem_exames'] . '""' : '';
								$baixar_disabled = $exame['exame_id'] == 6 && !$exame["arquivo_exame"];
								$baixar_disabled = $baixar_disabled ? "class='btn btn-success link-disabled'" : "class='btn btn-success'";
							?>
				            <a <?php echo $balloon . " " . $baixar_disabled; ?> href="<?php echo download_exame($exame)."?dummy=dummy"; ?>" download target="_blank"><i class="icon-list-alt"></i> Baixar Exame</a>
	    	            </div>
		    		</div>

		    	</div>

		    </fieldset>

		    <?php if($exame['status'] <> 0){?>

			    <fieldset>

		    	<legend><strong class="text-error">Dados do Laudo</strong></legend>

    			<?php if($exame['status'] == 2){?>
					<div class="row">
						<div class="span7">
							<div class="control-group clearfix">
								<div class="clearfix"><strong class="text-error">Laudo Impossibilitado</strong></div>
							</div>
						</div>
					</div>
                <?php }?>


				<?php if($exame['status'] == 1){?>

					<?php if($exame['exame_id'] == 9){ ?>
						<!-- Raio X OIT -->
						<div id="form-oit-container" <?php echo $exame['exame_id'] == 9 ? '': 'style="display:none"' ?> >
							<div class="row"> 
								<div class="span3"> 
									<strong>RX Digital</strong><br /> 
									<input type="radio"  disabled="disabled"
										   name="exame_oit[rx_digital]" value="S" 
										<?php echo $exame_oit['rx_digital'] == 'S' ? 'checked="checked"' : ''?>> SIM 
									<input type="radio"  disabled="disabled"
										   name="exame_oit[rx_digital]" value="N" 
										<?php echo $exame_oit['rx_digital'] == 'N' ? 'checked="checked"' : ''?>> NÃO 
								</div> 
								<div class="span3"> 
									<strong>Leitura em Negatoscópio</strong><br /> 
									<input type="radio"  disabled="disabled"
										   name="exame_oit[negatoscopio]" value="S" 
										<?php echo $exame_oit['negatoscopio'] == 'S' ? 'checked="checked"' : ''?>> SIM 
									<input type="radio"  disabled="disabled"
										   name="exame_oit[negatoscopio]" value="N" 
										<?php echo $exame_oit['negatoscopio'] == 'N' ? 'checked="checked"' : ''?>> NÃO 
								</div> 
							</div>
							<hr>
							<div class="row"> 
								<div class="span2"> 
									<strong>1A) Qualidade Técnica</strong><br>
									<input type="radio" disabled="disabled"
										   name="exame_oit[qualidade]" value="1" 
										<?php echo $exame_oit['qualidade'] == '1' ? 'checked="checked"' : ''?>> 1 
									<input type="radio" disabled="disabled"
										   name="exame_oit[qualidade]" value="2" 
										<?php echo $exame_oit['qualidade'] == '2' ? 'checked="checked"' : ''?>> 2 
									<input type="radio" disabled="disabled"
										   name="exame_oit[qualidade]" value="3" 
										<?php echo $exame_oit['qualidade'] == '3' ? 'checked="checked"' : ''?>> 3 
									<input type="radio"  disabled="disabled"
										   name="exame_oit[qualidade]" value="4" 
										<?php echo $exame_oit['qualidade'] == '4' ? 'checked="checked"' : ''?>> 4 
								</div>
							</div>
							<div class="row">
								<div class="span10"> 
									<label for="exame_oit[comentarios_qualidade]">Comentário</label> 
									<input type="text" style="width: 600px;"  disabled="disabled"
										   name="exame_oit[comentarios_qualidade]" value="<?php echo $exame_oit['comentarios_qualidade'] ?>"> 
								</div> 
							</div>
							<hr>
							<div class="row"> 
								<div class="span3">
									<strong>1B) Radiografia Normal</strong><br /> 
									<input type="radio"  disabled="disabled"
										   name="exame_oit[normal]" value="S"
										<?php echo $exame_oit['normal'] == 'S' ? 'checked="checked"' : ''?>> SIM 
									<input type="radio"  disabled="disabled"
										   name="exame_oit[normal]" value="N" 
										<?php echo $exame_oit['normal'] == 'N' ? 'checked="checked"' : ''?>> NÃO 
								</div>
							</div>
							<hr>
							<div class="row">
								<div class="span6">
									<strong>2A) Alguma anormalidade de parênquima consistente com pneumoconiose</strong><br />
									<input id="anormalidade_parenquima" type="radio"  disabled="disabled"
										   name="exame_oit[anormalidade_parenquima]" value="S" 
										<?php echo $exame_oit['anormalidade_parenquima'] == 'S' ? 'checked="checked"' : ''?>> SIM
									<input id="anormalidade_parenquima" type="radio"  disabled="disabled"
										   name="exame_oit[anormalidade_parenquima]" value="N"
										<?php echo $exame_oit['anormalidade_parenquima'] == 'N' ? 'checked="checked"' : ''?>> NÃO
								</div>
							</div>
							<hr>
							<div id="sessao2">
								<div class="row">
									<div class="span6">
										<strong>2B) Pequenas Opacidades</strong> 
									</div>
								</div>
								<div class="row">
									<strong>
										<div class="span4">
											A) Formas e Tamanhos
										</div>
										<div class="span2">
											B) Zonas
										</div>
										<div class="span2">
											C) Profusão
										</div>
									</strong>
								</div>
								<div class="row">
									<div class="span2">
										<strong>Primárias</strong>
										<div>
											<input type="radio" disabled="disabled"
												   name="exame_oit[primarias]" value="P"
												<?php echo $exame_oit['primarias'] == 'P' ? 'checked="checked"' : ''?>> p
											<input type="radio" disabled="disabled"
												   name="exame_oit[primarias]" value="S"
												<?php echo $exame_oit['primarias'] == 'S' ? 'checked="checked"' : ''?>> s
										</div>
										<div>
											<input type="radio"  disabled="disabled"
												   name="exame_oit[primarias]" value="Q"
												<?php echo $exame_oit['primarias'] == 'Q' ? 'checked="checked"' : ''?>> q 
											<input type="radio"  disabled="disabled"
												   name="exame_oit[primarias]" value="T"
												<?php echo $exame_oit['primarias'] == 'T' ? 'checked="checked"' : ''?>> t
										</div>
										<div>
											<input type="radio"  disabled="disabled"
												   name="exame_oit[primarias]" value="R"
												<?php echo $exame_oit['primarias'] == 'R' ? 'checked="checked"' : ''?>> r 
											<input type="radio"  disabled="disabled"
												   name="exame_oit[primarias]" value="U"
												<?php echo $exame_oit['primarias'] == 'U' ? 'checked="checked"' : ''?>> u
										</div>
									</div>
									<div class="span2"> 
										<strong>Secundárias</strong>
										<div>
											<input type="radio"  disabled="disabled"
												   name="exame_oit[secundarias]" value="P"
												<?php echo $exame_oit['secundarias'] == 'P' ? 'checked="checked"' : ''?>> p
											<input type="radio"  disabled="disabled"
												   name="exame_oit[secundarias]" value="S" 
												<?php echo $exame_oit['secundarias'] == 'S' ? 'checked="checked"' : ''?>> s
										</div>
										<div>
											<input type="radio"  disabled="disabled"
												   name="exame_oit[secundarias]" value="Q" 
												<?php echo $exame_oit['secundarias'] == 'Q' ? 'checked="checked"' : ''?>> q
											<input type="radio"  disabled="disabled"
												   name="exame_oit[secundarias]" value="T" 
												<?php echo $exame_oit['secundarias'] == 'T' ? 'checked="checked"' : ''?>> t
										</div>
										<div>
											<input type="radio"  disabled="disabled"
												   name="exame_oit[secundarias]" value="R" 
												<?php echo $exame_oit['secundarias'] == 'R' ? 'checked="checked"' : ''?>> r 
											<input type="radio" disabled="disabled"
												   name="exame_oit[secundarias]" value="U"
												<?php echo $exame_oit['secundarias'] == 'U' ? 'checked="checked"' : ''?>> u
										</div>
									</div>
									<div class="span2"> 
										<div>
											<input type="checkbox" disabled="disabled" 
												   name="exame_oit[zonas_d1]" value="S"
												<?php echo $exame_oit['zonas_d1'] == 'S' ? 'checked="checked"' : ''?>> D 
											<input type="checkbox"  disabled="disabled"
												   name="exame_oit[zonas_e1]" value="S"
												<?php echo $exame_oit['zonas_e1'] == 'S' ? 'checked="checked"' : ''?>> E
										</div>
										<div>
											<input type="checkbox" disabled="disabled"
												   name="exame_oit[zonas_d2]" value="S"
												<?php echo $exame_oit['zonas_d2'] == 'S' ? 'checked="checked"' : ''?>> D 
											<input type="checkbox"  disabled="disabled"
												   name="exame_oit[zonas_e2]" value="S"
												<?php echo $exame_oit['zonas_e2'] == 'S' ? 'checked="checked"' : ''?>> E
										</div>
										<div>
											<input type="checkbox"  disabled="disabled"
												   name="exame_oit[zonas_d3]" value="S"
												<?php echo $exame_oit['zonas_d3'] == 'S' ? 'checked="checked"' : ''?>> D
											<input type="checkbox"  disabled="disabled"
												   name="exame_oit[zonas_e3]" value="S"
												<?php echo $exame_oit['zonas_e3'] == 'S' ? 'checked="checked"' : ''?>> E
										</div>
									</div>
									<div class="span2"> 
										<div>
											<input type="radio"  disabled="disabled"
												   name="exame_oit[profusao]" value="0/-"
												<?php echo $exame_oit['profusao'] == '0/-' ? 'checked="checked"' : ''?>> 0/- 
											<input type="radio"  disabled="disabled"
												   name="exame_oit[profusao]" value="0/0"
												<?php echo $exame_oit['profusao'] == '0/0' ? 'checked="checked"' : ''?>> 0/0
											<input type="radio"  disabled="disabled"
												   name="exame_oit[profusao]" value="0/1"
												<?php echo $exame_oit['profusao'] == '0/1' ? 'checked="checked"' : ''?>> 0/1
										</div>
										<div>
											<input type="radio"  disabled="disabled"
												   name="exame_oit[profusao]" value="1/0"
												<?php echo $exame_oit['profusao'] == '1/0' ? 'checked="checked"' : ''?>> 1/0 
											<input type="radio" disabled="disabled"
												   name="exame_oit[profusao]" value="1/1"
												<?php echo $exame_oit['profusao'] == '1/1' ? 'checked="checked"' : ''?>> 1/1
											<input type="radio" 	disabled="disabled"
												   name="exame_oit[profusao]" value="1/2"
												<?php echo $exame_oit['profusao'] == '1/2' ? 'checked="checked"' : ''?>> 1/2
										</div>
										<div>
											<input type="radio" disabled="disabled"
												   name="exame_oit[profusao]" value="2/1"
												<?php echo $exame_oit['profusao'] == '2/1' ? 'checked="checked"' : ''?>> 2/1 
											<input type="radio"  disabled="disabled"
												   name="exame_oit[profusao]" value="2/2"
												<?php echo $exame_oit['profusao'] == '2/2' ? 'checked="checked"' : ''?>> 2/2 
											<input type="radio"  disabled="disabled"
												   name="exame_oit[profusao]" value="2/3"
												<?php echo $exame_oit['profusao'] == '2/3' ? 'checked="checked"' : ''?>> 2/3
										</div>
										<div>
											<input type="radio"  disabled="disabled"
												   name="exame_oit[profusao]" value="3/2"
												<?php echo $exame_oit['profusao'] == '3/2' ? 'checked="checked"' : ''?>> 3/2
											<input type="radio"  disabled="disabled"
												   name="exame_oit[profusao]" value="3/3"
												<?php echo $exame_oit['profusao'] == '3/3' ? 'checked="checked"' : ''?>> 3/3
											<input type="radio" 	disabled="disabled"
												   name="exame_oit[profusao]" value="3/+"
												<?php echo $exame_oit['profusao'] == '3/+' ? 'checked="checked"' : ''?>> 3/+
										</div>
									</div>
								</div>
								<hr>
								<div class="row">
									<div class="span3">
										<strong>2C) Grandes Opacidades</strong>
										<div>
											<input type="radio" disabled="disabled"
												   name="exame_oit[grd_opacidade]" value="0"
												<?php echo $exame_oit['grd_opacidade'] == '0' ? 'checked="checked"' : ''?>> 0 
											<input type="radio"  disabled="disabled"
												   name="exame_oit[grd_opacidade]" value="A"
												<?php echo $exame_oit['grd_opacidade'] == 'A' ? 'checked="checked"' : ''?>> A
											<input type="radio" 	disabled="disabled"
												   name="exame_oit[grd_opacidade]" value="B"
												<?php echo $exame_oit['grd_opacidade'] == 'B' ? 'checked="checked"' : ''?>> B 
											<input type="radio" disabled="disabled"
												   name="exame_oit[grd_opacidade]" value="C"
												<?php echo $exame_oit['grd_opacidade'] == 'C' ? 'checked="checked"' : ''?>> C
										</div>
									</div>
								</div>
								<hr>
							</div>
							<div class="row"> 
								<div class="span6"> 
									<strong>3A) Alguma anormalidade pleural consistente com pneumoconiose</strong><br />
									<input id="anormalidade_pleural" type="radio" disabled="disabled"    name="exame_oit[anormalidade_pleural]" value="S"
										<?php echo $exame_oit['anormalidade_pleural'] == 'S' ? 'checked="checked"' : ''?>> SIM 
									<input id="anormalidade_pleural" type="radio" disabled="disabled"     name="exame_oit[anormalidade_pleural]" value="N"
										<?php echo $exame_oit['anormalidade_pleural'] == 'N' ? 'checked="checked"' : ''?>> NÃO 
								</div>
							</div>
							<hr>
							<div id="sessao3">
								<div class="row">
									<div class="span6">
										<strong>3B) Placas Pleurais</strong> 
									</div>
								</div>
								<div class="row">
									<div class="span3"> 
										<input type="radio" disabled="disabled"   name="exame_oit[placas_pleurais]" value="S"
											<?php echo $exame_oit['placas_pleurais'] == 'S' ? 'checked="checked"' : ''?>> SIM
										<input type="radio" disabled="disabled"   name="exame_oit[placas_pleurais]" value="N"
											<?php echo $exame_oit['placas_pleurais'] == 'N' ? 'checked="checked"' : ''?>> NÃO
									</div>
								</div>
								<div class="row">
									<div class="span2">
										<strong>
											<br />
											Parede em perfil:<br />
											Frontal:<br />
											Diafragma:<br />
											Outros locais:<br />
										</strong>
									</div>
									<div class="span2">
										<strong>Local</strong><br />
										<div>
											<input type="checkbox" disabled="disabled"   	name="exame_oit[placas_parede_local_0]" value="S"
												<?php echo $exame_oit['placas_parede_local_0'] == 'S' ? 'checked="checked"' : ''?>> 0
											<input type="checkbox" disabled="disabled"  	name="exame_oit[placas_parede_local_D]" value="S"
												<?php echo $exame_oit['placas_parede_local_D'] == 'S' ? 'checked="checked"' : ''?>> D
											<input type="checkbox" disabled="disabled"  	name="exame_oit[placas_parede_local_E]" value="S"
												<?php echo $exame_oit['placas_parede_local_E'] == 'S' ? 'checked="checked"' : ''?>> E
										</div>
										<div>
											<input type="checkbox" disabled="disabled"  name="exame_oit[placas_frontal_local_0]" value="S"
												<?php echo $exame_oit['placas_frontal_local_0'] == 'S' ? 'checked="checked"' : ''?>> 0
											<input type="checkbox" disabled="disabled"  name="exame_oit[placas_frontal_local_D]" value="S"
												<?php echo $exame_oit['placas_frontal_local_D'] == 'S' ? 'checked="checked"' : ''?>> D
											<input type="checkbox" disabled="disabled"  name="exame_oit[placas_frontal_local_E]" value="S"
												<?php echo $exame_oit['placas_frontal_local_E'] == 'S' ? 'checked="checked"' : ''?>> E
										</div>
										<div>
											<input type="checkbox" disabled="disabled"  	name="exame_oit[placas_diafrag_local_0]" value="S"
												<?php echo $exame_oit['placas_diafrag_local_0'] == 'S' ? 'checked="checked"' : ''?>> 0
											<input type="checkbox" disabled="disabled"  	name="exame_oit[placas_diafrag_local_D]" value="S"
												<?php echo $exame_oit['placas_diafrag_local_D'] == 'S' ? 'checked="checked"' : ''?>> D
											<input type="checkbox" disabled="disabled"  	name="exame_oit[placas_diafrag_local_E]" value="S"
												<?php echo $exame_oit['placas_diafrag_local_E'] == 'S' ? 'checked="checked"' : ''?>> E
										</div>
										<div>
											<input type="checkbox" disabled="disabled"  	name="exame_oit[placas_outros_local_0]" value="S"
												<?php echo $exame_oit['placas_outros_local_0'] == 'S' ? 'checked="checked"' : ''?>> 0
											<input type="checkbox" disabled="disabled"  	name="exame_oit[placas_outros_local_D]" value="S"
												<?php echo $exame_oit['placas_outros_local_D'] == 'S' ? 'checked="checked"' : ''?>> D
											<input type="checkbox" disabled="disabled"  	name="exame_oit[placas_outros_local_E]" value="S"
												<?php echo $exame_oit['placas_outros_local_E'] == 'S' ? 'checked="checked"' : ''?>> E
										</div>
									</div>
									<div class="span2">
										<strong>Calcificação</strong><br />
										<div>
											<input type="checkbox" disabled="disabled"   name="exame_oit[placas_parede_calcif_0]" value="S"
												<?php echo $exame_oit['placas_parede_calcif_0'] == 'S' ? 'checked="checked"' : ''?>> 0
											<input type="checkbox" disabled="disabled"   name="exame_oit[placas_parede_calcif_D]" value="S"
												<?php echo $exame_oit['placas_parede_calcif_D'] == 'S' ? 'checked="checked"' : ''?>> D
											<input type="checkbox" disabled="disabled"   name="exame_oit[placas_parede_calcif_E]" value="S"
												<?php echo $exame_oit['placas_parede_calcif_E'] == 'S' ? 'checked="checked"' : ''?>> E
										</div>
										<div>
											<input type="checkbox" disabled="disabled"   name="exame_oit[placas_frontal_calcif_0]" value="S"
												<?php echo $exame_oit['placas_frontal_calcif_0'] == 'S' ? 'checked="checked"' : ''?>> 0
											<input type="checkbox" disabled="disabled"   name="exame_oit[placas_frontal_calcif_D]" value="S"
												<?php echo $exame_oit['placas_frontal_calcif_D'] == 'S' ? 'checked="checked"' : ''?>> D
											<input type="checkbox" disabled="disabled"   name="exame_oit[placas_frontal_calcif_E]" value="S"
												<?php echo $exame_oit['placas_frontal_calcif_E'] == 'S' ? 'checked="checked"' : ''?>> E
										</div>
										<div>
											<input type="checkbox" disabled="disabled"   name="exame_oit[placas_diafrag_calcif_0]" value="S"
												<?php echo $exame_oit['placas_diafrag_calcif_0'] == 'S' ? 'checked="checked"' : ''?>> 0
											<input type="checkbox" disabled="disabled"   name="exame_oit[placas_diafrag_calcif_D]" value="S"
												<?php echo $exame_oit['placas_diafrag_calcif_D'] == 'S' ? 'checked="checked"' : ''?>> D
											<input type="checkbox" disabled="disabled"   name="exame_oit[placas_diafrag_calcif_E]" value="S"
												<?php echo $exame_oit['placas_diafrag_calcif_E'] == 'S' ? 'checked="checked"' : ''?>> E
										</div>
										<div>
											<input type="checkbox" disabled="disabled"   name="exame_oit[placas_outros_calcif_0]" value="S"
												<?php echo $exame_oit['placas_outros_calcif_0'] == 'S' ? 'checked="checked"' : ''?>> 0
											<input type="checkbox" disabled="disabled"   name="exame_oit[placas_outros_calcif_D]" value="S"
												<?php echo $exame_oit['placas_outros_calcif_D'] == 'S' ? 'checked="checked"' : ''?>> D
											<input type="checkbox" disabled="disabled"   name="exame_oit[placas_outros_calcif_E]" value="S"
												<?php echo $exame_oit['placas_outros_calcif_E'] == 'S' ? 'checked="checked"' : ''?>> E
										</div>
									</div>
								</div>
								<div class="row">
									<div class="span5">
										<strong>Extensão da parede(combinado perfil e frontal)</strong><br/>
										<div style="float:left; width:50%">
											<div>
												<input type="checkbox" disabled="disabled"  name="exame_oit[placas_extensao_o_d_0]" value="S"
													<?php echo $exame_oit['placas_extensao_o_d_0'] == 'S' ? 'checked="checked"' : ''?>> 0
												<input type="checkbox" disabled="disabled"  name="exame_oit[placas_extensao_o_d_D]" value="S"
													<?php echo $exame_oit['placas_extensao_o_d_D'] == 'S' ? 'checked="checked"' : ''?>> D
												<input type="checkbox" disabled="disabled" name="exame_oit[placas_extensao_o_d_1]" value="S"
													<?php echo $exame_oit['placas_extensao_o_d_1'] == 'S' ? 'checked="checked"' : ''?>> 1
												<input type="checkbox" disabled="disabled" name="exame_oit[placas_extensao_o_d_2]" value="S"
													<?php echo $exame_oit['placas_extensao_o_d_2'] == 'S' ? 'checked="checked"' : ''?>> 2
												<input type="checkbox" disabled="disabled" name="exame_oit[placas_extensao_o_d_3]" value="S"
													<?php echo $exame_oit['placas_extensao_o_d_3'] == 'S' ? 'checked="checked"' : ''?>> 3
											</div>
                                            <div>
                                                <input type="checkbox" disabled="disabled"   name="exame_oit[placas_extensao_o_e_0]" value="S"
                                                    <?php echo $exame_oit['placas_extensao_o_e_0'] == 'S' ? 'checked="checked"' : ''?>> 0
                                                <input type="checkbox" disabled="disabled"   name="exame_oit[placas_extensao_o_e_E]" value="S"
                                                    <?php echo $exame_oit['placas_extensao_o_e_E'] == 'S' ? 'checked="checked"' : ''?>> E
                                                <input type="checkbox" disabled="disabled"   name="exame_oit[placas_extensao_o_e_1]" value="S"
                                                    <?php echo $exame_oit['placas_extensao_o_e_1'] == 'S' ? 'checked="checked"' : ''?>> 1
                                                <input type="checkbox" disabled="disabled"   name="exame_oit[placas_extensao_o_e_2]" value="S"
                                                    <?php echo $exame_oit['placas_extensao_o_e_2'] == 'S' ? 'checked="checked"' : ''?>> 2
                                                <input type="checkbox" disabled="disabled"   name="exame_oit[placas_extensao_o_e_3]" value="S"
                                                    <?php echo $exame_oit['placas_extensao_o_e_3'] == 'S' ? 'checked="checked"' : ''?>> 3
                                            </div>
											<i>Até 1/4 da parede lateral = 1<br /> 1/4 à 1/2 da parede lateral = 2<br />1/2 da parede lateral = 3<br /></i>
										</div>
									</div>
									<div class="span5">
										<strong>Largura(opcional) (mínimo de 3mm para marcação)</strong><br />
										<div style="float: left; width: 50%">
                                            <div>
                                                <input type="checkbox" disabled="disabled"   name="exame_oit[placas_largura_d_D]" value="S"
                                                    <?php echo $exame_oit['placas_largura_d_D'] == 'S' ? 'checked="checked"' : ''?>> D
                                                <input type="checkbox" disabled="disabled"   name="exame_oit[placas_largura_d_A]" value="S"
                                                    <?php echo $exame_oit['placas_largura_d_A'] == 'S' ? 'checked="checked"' : ''?>> a
                                                <input type="checkbox" disabled="disabled"  name="exame_oit[placas_largura_d_B]" value="S"
                                                    <?php echo $exame_oit['placas_largura_d_B'] == 'S' ? 'checked="checked"' : ''?>> b
                                                <input type="checkbox" disabled="disabled"   name="exame_oit[placas_largura_d_C]" value="S"
                                                    <?php echo $exame_oit['placas_largura_d_C'] == 'S' ? 'checked="checked"' : ''?>> c
                                            </div>
                                            <div>
                                                <input type="checkbox" disabled="disabled"  name="exame_oit[placas_largura_e_E]" value="S"
                                                    <?php echo $exame_oit['placas_largura_e_E'] == 'S' ? 'checked="checked"' : ''?>> E
                                                <input type="checkbox" disabled="disabled"   name="exame_oit[placas_largura_e_A]" value="S"
                                                    <?php echo $exame_oit['placas_largura_e_A'] == 'S' ? 'checked="checked"' : ''?>> a
                                                <input type="checkbox" disabled="disabled"  	name="exame_oit[placas_largura_e_B]" value="S"
                                                    <?php echo $exame_oit['placas_largura_e_B'] == 'S' ? 'checked="checked"' : ''?>> b
                                                <input type="checkbox" disabled="disabled"  	name="exame_oit[placas_largura_e_C]" value="S"
                                                    <?php echo $exame_oit['placas_largura_e_C'] == 'S' ? 'checked="checked"' : ''?>> c<br />
                                                <i> 3 à 5mm = A<br /> 5 à 10mm = B<br />> 10mm = C<br /></i>
                                            </div>
										</div>
									</div>
								</div>
								<hr>
								<div class="row"> 
									<div class="span3"> 
										<strong>3C) Obliteração do seio costofrênico:</strong><br />
										<input type="checkbox" disabled="disabled"   name="exame_oit[obliteracao_0]" value="S"
											<?php echo $exame_oit['obliteracao_0'] == 'S' ? 'checked="checked"' : ''?>> 0 
										<input type="checkbox" disabled="disabled"   name="exame_oit[obliteracao_D]" value="S"
											<?php echo $exame_oit['obliteracao_D'] == 'S' ? 'checked="checked"' : ''?>> D 
										<input type="checkbox" disabled="disabled"  	name="exame_oit[obliteracao_E]" value="S"
											<?php echo $exame_oit['obliteracao_E'] == 'S' ? 'checked="checked"' : ''?>> E<br />  
									</div>
								</div>
								<hr>
								<div class="row"> 
									<div class="span3"> 
										<strong>3D) Espessamento pleural difuso:</strong><br /> 
										<input type="radio" disabled="disabled"   name="exame_oit[espessamento_pleural]" value="S"
											<?php echo $exame_oit['espessamento_pleural'] == 'S' ? 'checked="checked"' : ''?>> SIM 
										<input type="radio" disabled="disabled"   name="exame_oit[espessamento_pleural]" value="N"
											<?php echo $exame_oit['espessamento_pleural'] == 'N' ? 'checked="checked"' : ''?>> NÃO 
									</div>
								</div>
								<div class="row">
									<div class="span2"> 
										<strong>
											<br />Parede em perfil:
											<br />Frontal:<br />
										</strong>
									</div>
									<div class="span2">
										<strong>Local</strong><br />
										<input type="checkbox" disabled="disabled"   name="exame_oit[espes_parede_local_0]" value="S"
											<?php echo $exame_oit['espes_parede_local_0'] == 'S' ? 'checked="checked"' : ''?>> 0
										<input type="checkbox" disabled="disabled"   name="exame_oit[espes_parede_local_D]" value="S"
											<?php echo $exame_oit['espes_parede_local_D'] == 'S' ? 'checked="checked"' : ''?>> D
										<input type="checkbox" disabled="disabled"  	name="exame_oit[espes_parede_local_E]" value="S"
											<?php echo $exame_oit['espes_parede_local_E'] == 'S' ? 'checked="checked"' : ''?>> E<br />
										<input type="checkbox" disabled="disabled"   name="exame_oit[espes_frontal_local_0]" value="S"
											<?php echo $exame_oit['espes_frontal_local_0'] == 'S' ? 'checked="checked"' : ''?>> 0
										<input type="checkbox" disabled="disabled"   name="exame_oit[espes_frontal_local_D]" value="S"
											<?php echo $exame_oit['espes_frontal_local_D'] == 'S' ? 'checked="checked"' : ''?>> D
										<input type="checkbox" disabled="disabled"   name="exame_oit[espes_frontal_local_E]" value="S"
											<?php echo $exame_oit['espes_frontal_local_E'] == 'S' ? 'checked="checked"' : ''?>> E
									</div>
									<div class="span2">
										<strong>Calcificação</strong><br />
										<input type="checkbox" disabled="disabled"   name="exame_oit[espes_parede_calcif_0]" value="S"
											<?php echo $exame_oit['espes_parede_calcif_0'] == 'S' ? 'checked="checked"' : ''?>> 0
										<input type="checkbox" disabled="disabled"   name="exame_oit[espes_parede_calcif_D]" value="S"
											<?php echo $exame_oit['espes_parede_calcif_D'] == 'S' ? 'checked="checked"' : ''?>> D
										<input type="checkbox" disabled="disabled"  	name="exame_oit[espes_parede_calcif_E]" value="S"
											<?php echo $exame_oit['espes_parede_calcif_E'] == 'S' ? 'checked="checked"' : ''?>> E<br />
										<input type="checkbox" disabled="disabled"   name="exame_oit[espes_frontal_calcif_0]" value="S"
											<?php echo $exame_oit['espes_frontal_calcif_0'] == 'S' ? 'checked="checked"' : ''?>> 0
										<input type="checkbox" disabled="disabled"   name="exame_oit[espes_frontal_calcif_D]" value="S"
											<?php echo $exame_oit['espes_frontal_calcif_D'] == 'S' ? 'checked="checked"' : ''?>> D
										<input type="checkbox" disabled="disabled"   name="exame_oit[espes_frontal_calcif_E]" value="S"
											<?php echo $exame_oit['espes_frontal_calcif_E'] == 'S' ? 'checked="checked"' : ''?>> E
									</div>
								</div>
								<div class="row">
									<div class="span5">
										<strong>Extensão da parede(combinado perfil e frontal)</strong><br/>
										<div style="float:left; width:50%">
											<div>
												<input type="checkbox" disabled="disabled"  name="exame_oit[espes_extensao_o_d_0]" value="S"
													<?php echo $exame_oit['espes_extensao_o_d_0'] == 'S' ? 'checked="checked"' : ''?>> 0
												<input type="checkbox" disabled="disabled"  name="exame_oit[espes_extensao_o_d_D]" value="S"
													<?php echo $exame_oit['espes_extensao_o_d_D'] == 'S' ? 'checked="checked"' : ''?>> D
												<input type="checkbox" disabled="disabled" name="exame_oit[espes_extensao_o_d_1]" value="S"
													<?php echo $exame_oit['espes_extensao_o_d_1'] == 'S' ? 'checked="checked"' : ''?>> 1
												<input type="checkbox" disabled="disabled" name="exame_oit[espes_extensao_o_d_2]" value="S"
													<?php echo $exame_oit['espes_extensao_o_d_2'] == 'S' ? 'checked="checked"' : ''?>> 2
												<input type="checkbox" disabled="disabled" name="exame_oit[espes_extensao_o_d_3]" value="S"
													<?php echo $exame_oit['espes_extensao_o_d_3'] == 'S' ? 'checked="checked"' : ''?>> 3
											</div>
                                            <div>
                                                <input type="checkbox" disabled="disabled"   name="exame_oit[espes_extensao_o_e_0]" value="S"
                                                    <?php echo $exame_oit['espes_extensao_o_e_0'] == 'S' ? 'checked="checked"' : ''?>> 0
                                                <input type="checkbox" disabled="disabled"   name="exame_oit[espes_extensao_o_e_E]" value="S"
                                                    <?php echo $exame_oit['espes_extensao_o_e_E'] == 'S' ? 'checked="checked"' : ''?>> E
                                                <input type="checkbox" disabled="disabled"   name="exame_oit[espes_extensao_o_e_1]" value="S"
                                                    <?php echo $exame_oit['espes_extensao_o_e_1'] == 'S' ? 'checked="checked"' : ''?>> 1
                                                <input type="checkbox" disabled="disabled"   name="exame_oit[espes_extensao_o_e_2]" value="S"
                                                    <?php echo $exame_oit['espes_extensao_o_e_2'] == 'S' ? 'checked="checked"' : ''?>> 2
                                                <input type="checkbox" disabled="disabled"   name="exame_oit[espes_extensao_o_e_3]" value="S"
                                                    <?php echo $exame_oit['espes_extensao_o_e_3'] == 'S' ? 'checked="checked"' : ''?>> 3
                                            </div>
											<i>Até 1/4 da parede lateral = 1<br /> 1/4 à 1/2 da parede lateral = 2<br />1/2 da parede lateral = 3<br /></i>
										</div>
									</div>
									<div class="span5">
										<strong>Largura(opcional) (mínimo de 3mm para marcação)</strong><br />
										<div style="float: left; width: 50%">
                                            <div>
                                                <input type="checkbox" disabled="disabled"   name="exame_oit[espes_largura_d_D]" value="S"
                                                    <?php echo $exame_oit['espes_largura_d_D'] == 'S' ? 'checked="checked"' : ''?>> D
                                                <input type="checkbox" disabled="disabled"   name="exame_oit[espes_largura_d_A]" value="S"
                                                    <?php echo $exame_oit['espes_largura_d_A'] == 'S' ? 'checked="checked"' : ''?>> a 
                                                <input type="checkbox" disabled="disabled"  name="exame_oit[espes_largura_d_B]" value="S"
                                                    <?php echo $exame_oit['espes_largura_d_B'] == 'S' ? 'checked="checked"' : ''?>> b
                                                <input type="checkbox" disabled="disabled"   name="exame_oit[espes_largura_d_C]" value="S"
                                                    <?php echo $exame_oit['espes_largura_d_C'] == 'S' ? 'checked="checked"' : ''?>> c
                                            </div>
                                            <div>
                                                <input type="checkbox" disabled="disabled"  name="exame_oit[espes_largura_e_E]" value="S"
                                                    <?php echo $exame_oit['espes_largura_e_E'] == 'S' ? 'checked="checked"' : ''?>> E
                                                <input type="checkbox" disabled="disabled"   name="exame_oit[espes_largura_e_A]" value="S"
                                                    <?php echo $exame_oit['espes_largura_e_A'] == 'S' ? 'checked="checked"' : ''?>> a
                                                <input type="checkbox" disabled="disabled"  	name="exame_oit[espes_largura_e_B]" value="S"
                                                    <?php echo $exame_oit['espes_largura_e_B'] == 'S' ? 'checked="checked"' : ''?>> b
                                                <input type="checkbox" disabled="disabled"  	name="exame_oit[espes_largura_e_C]" value="S"
                                                    <?php echo $exame_oit['espes_largura_e_C'] == 'S' ? 'checked="checked"' : ''?>> c<br />
                                                <i> 3 à 5mm = A<br /> 5 à 10mm = B<br />> 10mm = C<br /></i>
                                            </div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="span3">
									<strong>4A) Outras anormalidades:</strong><br />
									<input id="outras_anormalidades" type="radio" disabled="disabled"    onclick="changeSessao4('S')" name="exame_oit[outras_anormalidades]" value="S"
										<?php echo $exame_oit['outras_anormalidades'] == 'S' ? 'checked="checked"' : ''?>> SIM
									<input id="outras_anormalidades" type="radio" disabled="disabled"    onclick="changeSessao4('N')" name="exame_oit[outras_anormalidades]" value="N"
										<?php echo $exame_oit['outras_anormalidades'] == 'N' ? 'checked="checked"' : ''?>> NÃO
								</div>
							</div>
							<div id="sessao4">
								<div class="row">
									<div class="span12">
										<strong>4B) Simbolos:</strong><br />
										<?php
										$tags = array('aa','at','ax','bu','ca','cg','cn','co','cp','cv','di','ef','em','es','fr','hi','ho','id','ih','kl','me','pa','pb','pi','px','ra','rp','tb','od');
										foreach ($tags as $t){
											$tag = '<input type="checkbox" disabled="disabled" value="S" name="exame_oit[simbolos_#tag#]" ' . '#disabled# #checked#> #tag#&nbsp;';
											$tag = str_replace('#tag#', $t, $tag);
											$tag = str_replace('#disabled#', $exame['status'] == '2' ? 'disabled="disabled"' : '', $tag);
											$tag = str_replace('#checked#', $exame_oit['simbolos_' . $t ] == 'S' ? 'checked="checked"' : '', $tag);
											echo $tag;
										};
										?>
									</div>
								</div>
								<div class="row">
									<div class="span10">
										<strong>Legenda:</strong> aa = Aorta aterosclerótica | at = Espessamento pleural apical significativo |  ax = Coalescência de pequenas opacidades | bu = Bolhas | ca = Câncer | cg = Nódulos não pneumoconióticos calcificados | 				cn = Calcificação de pequenas opacidades pneumoconióticas | co = Anormalidade de forma e tamanho do coração | cp = Cor pulmonale | 				cv = Cavidade | di = Distorção significativa de estrutura intratorácica | ef = Derrame pleural | em = Enfisema | es = Calcificações em casca de ovo | 				fr = Fratura(s) de costela(s) recente(s) ou consolidadas | hi = Aumento de gânglios hilares e/ou mediastinais | 				ho = Faveolamento | id = Borda diafragmática mal definida | ih = Borda cardíaca mal definida | 				kl = Linhas septais (Kerley) | me = Mesotelioma | od = Outras doenças | pa = Atelectasia laminar | 	pb = Banda(s) parenquimatosa(s) | pi = Espessamento pleural de cisura(s) interlobar(es) | px = Pneumotórax |  ra = Atelectasia redonda | rp = Pneumoconiose reumática | tb = Tuberculose 
									</div>
								</div>
							</div>
							<div class="row">
								<div class="span10"> 
									<label for="exame_oit[comentarios_laudo]">4C) Comentários</label> 
									<input type="text" style="width: 900px"  disabled="disabled"
										   id="exame_oit[comentarios_laudo]" 
										   name="exame_oit[comentarios_laudo]"
										   value="<?php echo $exame_oit['comentarios_laudo'] ?>"> 
								</div>
							</div>
						</div>

					<?php }?>

					<?php if($exame['exame_id'] <> 9){ ?>
						<div id="laudo_info_container" class="">
							<div class="row">
							<?php if ($content = $exame['modelo_content']){?>
								<div class="span9">
									<div class="laudo_content">
									<?php echo $exame['modelo_content'];?>
									</div>
								</div>
							<?php }?>
							</div>
						</div>
					<?php }?>

				<?php }?>


	    	<?php if($exame['status'] == 2){?>
				<div id="laudo_imposs_container" class="well well-small">
					<div class="row">
						<div class="span12">
						<?php foreach ($exame_erros as $opcao){?>
							<label class="checkbox">
								(&nbsp;<strong><?php echo in_array($opcao['id'], $exame['opcoes_impossibilitado']) ? "x" : "&nbsp;"?></strong>&nbsp;) <?php echo $opcao['title'];?>
							</label>
						<?php }?>
						</div>
					</div>
					<div class="row">
						<div class="span12">
							<label for="observacoes_medico">Observações</label>
							<textarea name="observacoes_medico" disabled="disabled" id="observacoes_medico" cols="30" rows="5" class="span12"><?php echo $exame['observacoes_medico']?></textarea>
						</div>
					</div>
				</div>
	    	<?php }?>

	    	<br />

	    </fieldset>

		    <?php }?>

			<div class="form-actions">
				<?php if ($linkLaudo = download_laudo($exame)){?>

					<?php if (!UserSession::isMedico()) { ?>
						<a href="<?php echo $linkLaudo?>" target="_blank" class="btn btn-danger"><i class="icon-download-alt"></i> Baixar laudo</a>
					<?php } ?>

				<?php }elseif (UserSession::user('id') == $exame['medico_id'] || UserSession::isAdmin()){?>

					<a href="<?php echo site_url("exames/laudo/" . $exame['paciente_exame_id'])?>" target="_blank" class="btn btn-primary"><i class="icon-edit"></i> Enviar Laudo</a>

				<?php }?>
			</div>

		<div class="span12">
			<div class="row">
				<?php if($exame['arquivo_imagem']){?>
                    <?php
                        $posA = strpos($exame['arquivo_imagem'], '{{');
                        $posB = strpos($exame['arquivo_imagem'], '}}');
                        $arquivos = $posA === false ? 0 : substr($exame['arquivo_imagem'], $posA + 2, $posB - $posA - 2);
                        $nome = $pos === false ? null : substr($exame['arquivo_imagem'], 0, $posA);
                        $ext = $pos === false ? null : substr($exame['arquivo_imagem'], $posB + 2);
                    ?>
				<fieldset>
					<legend>Imagens</legend>
                    <?php if ( $posA === false ) { ?>
					    <img src="<?php echo site_url("uploads/dama/exames/" . $exame['arquivo_imagem'])?>" alt="Arquivo de imagem">
                    <?php } else {
                        for ($i=0; $i < $arquivos;$i++) { ?>
                            <img src="<?php echo site_url("uploads/dama/exames/" . $nome . '_' . $i . $ext) ?>" alt="Arquivo de imagem">
                    <?php } } ?>
				</fieldset>
				<?php }  ?>
			</div>
		</div>

    </div>
</div>


</div>

<!--
<script type="text/javascript" charset="utf-8">

	webix.ui({

		container: "areaA",
		type:"space", padding:8,

		rows:[
			{
				type:"clean",
				rows:[

					{
						borderless:true, view:"tabbar", id:'tabbar', value: 'listView', multiview: true, options: [
						{ value: 'DADOS DO EXAME', id: 'exameView'},
						{ value: 'EXAME EM IMAGEM', id: 'imagemView'}
					]
					},
					{
						cells:[
							{
								id:"exameView",
								template:"html->exame_container"
							},
							{
								id:"imagemView",
								template:"html->exame_imagem"
							}
						]
					}
				]
			}
		]

	});

</script>

-->
