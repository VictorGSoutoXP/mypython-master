<?php echo $this->load->view('layouts/menu',false,true,false); ?>
<script src="<?php echo base_url('assets/js/ckeditor/ckeditor.js') ?>"></script>

<div class="row">
	<form action="<?php echo site_url("exames/laudo");?>" method="post" name="enviaLaudo" id="enviaLaudo" enctype="multipart/form-data">
		<input type="hidden" name="_id" value="<?php echo $exame['paciente_exame_id']?>" />
		<input type="hidden" name="_exame_id" id="_exame_id" value="<?php echo $exame['exame_id']?>" />
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
					<div class="span3">
						<label for="exame[motivo]">Motivo Exame</label>
						<input type="text" disabled="disabled" value="<?php echo $exame['motivo']?>" id="exame[motivo]" class="span3" />
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
						<textarea disabled="disabled" id="exame[observacoes]" cols="30" rows="4" class="span8"><?php echo $exame['observacoes']?></textarea>
					</div>
					<div class="span4">
						<?php if($exame['emergencia']){?>
							<div class="control-group clearfix">
								<div class="clearfix"><strong class="text-error">Emergência</strong></div>
							</div>
						<?php }?>
						<div class="control-group clearfix">
							<?php //$balloon = $usuario['mensagem_exames'] ? 'data-balloon-length="large" data-balloon="' . $usuario['mensagem_exames'] . '""' : ''?>

							<?php
							$balloon = $usuario['mensagem_exames'] ? 'data-balloon-length="large" data-balloon="' . $usuario['mensagem_exames'] . '""' : '';
							$baixar_disabled = $exame['exame_id'] == 6 && !$exame["arquivo_exame"];
							$baixar_disabled = $baixar_disabled ? "class='btn btn-success link-disabled'" : "class='btn btn-success'";
							?>

							<!-- <a id="btnBaixarExame" <?php echo $balloon. " " . $baixar_disabled; ?> href="<?php echo download_exame($exame)."?dummy=dummy"; ?>" download target="_blank"><i class="icon-file"></i> Baixar Exame</a> -->
							<a id="btnBaixarExame" <?php echo $baixar_disabled; ?> href="<?php echo download_exame($exame)."?dummy=dummy"; ?>" download target="_blank"><i class="icon-file"></i> Baixar Exame</a>

						</div>
						<div style="font-size: 11px; color: red;">
							<?php echo $usuario['mensagem_exames']; ?>
						</div>
					</div>
				</div>
			</fieldset>

			<fieldset>
			
				<?php 
					$pdf = strtolower($exame['arquivo_exame']);
					$pdf = preg_match('/(\.pdf)/', $pdf) == 1 ? 
						   site_url("uploads/dama/exames/" . $exame['arquivo_exame']) : 
						   null;
				?>
				
				<?php if ($pdf) { ?>
					<iframe width=800px height=900px src="<?php echo $pdf; ?>"></iframe>
				<?php } ?>

				<?php if($exame['arquivo_imagem']){ ?>
				
					<?php
					$posA = strpos($exame['arquivo_imagem'], '{{');
					$posB = strpos($exame['arquivo_imagem'], '}}');
					$arquivos = $posA === false ? 0 : substr($exame['arquivo_imagem'], $posA + 2, $posB - $posA - 2);
					$nome = $pos === false ? null : substr($exame['arquivo_imagem'], 0, $posA);
					$ext = $pos === false ? null : substr($exame['arquivo_imagem'], $posB + 2);
					?>
					
					<fieldset>
					
						<legend><strong class="text-error">Imagem</strong></legend>
						
						<?php if ( $posA === false ) { ?>
							
								<div id="imagem0_container">
									<img title="CLIQUE PARA GIRAR!" onClick="doRotate(0)" class="rotate0" id="imagem0" src="<?php echo site_url("uploads/dama/exames/" . $exame['arquivo_imagem'])?>" alt="Arquivo de imagem">
								</div>
							
						<?php } else { ?>

							<?php for ($i=0; $i < $arquivos;$i++) { ?>

									<div id="imagem<?php echo $i; ?>_container">
										<img title="CLIQUE PARA GIRAR!" onClick="doRotate(<?php echo $i; ?>)" id="imagem<?php echo $i; ?>" src="<?php echo site_url("uploads/dama/exames/" . $nome . '_' . $i . $ext) ?>" alt="Arquivo de imagem">
									</div>

							<?php } ?>
						
						<?php } ?>
						
					</fieldset>

				<?php }  ?>
				
				<!--
				<?php if($exame['arquivo_imagem']){?> 
					<legend><strong class="text-error">Imagem</strong></legend>
					<img src="<?php echo site_url("uploads/dama/exames/" . $exame['arquivo_imagem'])?>" alt="Arquivo de imagem"> 
				<?php }?>
				-->

				<legend><strong class="text-error">Dados do Laudo</strong></legend>
				<div class="row">

					<div class="span7">
						<label class="checkbox">
							<input type="checkbox" id="laudo_impossibilitado" name="laudo_impossibilitado" value="1" <?php echo $exame['status'] == 2 ? "checked" : ""?> /> Laudo Impossibilitado
						</label>
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

				<div id="laudo_info_container" class="well well-small" style="<?php echo ($exame['status'] == 2 || $exame['exame_id'] == 9) ? "display: none;" : ""?>">
					<br />
					<div class="row">
						<div class="span4">
							<label for="laudo_modelo">Selecionar Modelo</label>
							<select name="laudo_modelo" id="laudo_modelo" class="select-box-auto-width span4 required" data-placeholder="Selecione o modelo">
								<option value=""></option>
								<option value="-1">Outro</option>
								<?php foreach ($modelos_laudo as  $modelo){?>
									<option value="<?php echo $modelo['id']?>"><?php echo $modelo['title']?></option>
								<?php }?>
							</select>
						</div>

						<div id="areaB"></div>

						<div class="span7">
							<label>Selecione as Imagens (Zipadas)</label>
							<div class="fileupload fileupload-new" data-provides="fileupload">
							<span class="btn btn-file">
								<span class="fileupload-new">Selecione o arquivo</span>
								<span class="fileupload-exists">Alterar</span>
								<input id="arquivo_selecionados" type="file" name="arquivo_selecionados" />
							</span><br />
								<span id="fileupload-preview" class="fileupload-preview" style="color: red; font-size: 12px"></span>
								<a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none">×</a>
							</div>
						</div>
					</div>
					<br />

					<div class="row">
						<div class="span12">
							<label for="modelo_content">Laudo</label>
							<textarea name="modelo_content" id="modelo_content" cols="30" rows="20" class="span8 ckeditor required"><?php echo $exame['modelo_content']?></textarea>
						</div>
					</div>

					<div id="laudoContainer"></div>

				</div>

				<div id="laudo_imposs_container" class="well" style="<?php echo $exame['status'] != 2 ? "display: none;" : ""?>">
					<div class="row">
						<div class="span12">
							<?php foreach ($exame_erros as $opcao){?>
								<label class="checkbox">
									<input type="checkbox" <?php echo in_array($opcao['id'], $exame['opcoes_impossibilitado']) ? "checked" : ""?> class="required" name="laudo_opcoes_impossibilitado[]" value="<?php echo $opcao['id'];?>"> <?php echo $opcao['title'];?>
								</label>
							<?php }?>
						</div>
					</div>
					<div class="row">
						<div class="span12">
							<label for="observacoes_medico">Observações</label>
							<textarea name="observacoes_medico" id="observacoes_medico" cols="30" rows="5" class="span8"><?php echo $exame['observacoes_medico']?></textarea>
						</div>
					</div>
				</div>

				<div id="form-oit-container" <?php echo $exame['exame_id'] == 9 ? '': 'style="display:none"' ?> >
					<div class="row"> 
						<div class="span3"> 
							<strong>RX Digital</strong><br /> 
							<input type="radio" 
								   <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?> 
								   name="exame_oit[rx_digital]" value="S" 
								<?php echo ( $exame_oit['rx_digital'] == 'S' || !$exame_oit['rx_digital'] ) ? 'checked="checked"' : ''?>> SIM 
							<input type="radio" 
								   <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?> 
								   name="exame_oit[rx_digital]" value="N" 
								<?php echo $exame_oit['rx_digital'] == 'N' ? 'checked="checked"' : ''?>> NÃO 
						</div> 
						<div class="span3"> 
							<strong>Leitura em Negatoscópio</strong><br /> 
							<input type="radio" 
								   <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?> 
								   name="exame_oit[negatoscopio]" value="S" 
								<?php echo $exame_oit['negatoscopio'] == 'S' ? 'checked="checked"' : ''?>> SIM 
							<input type="radio" 
								   <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?> 
								   name="exame_oit[negatoscopio]" value="N" 
								<?php echo ( $exame_oit['negatoscopio'] == 'N' || !$exame_oit['negatoscopio'] ) ? 'checked="checked"' : ''?>> NÃO 
						</div> 
					</div>
					<hr>
					<div class="row"> 
						<div class="span2"> 
							<strong>1A) Qualidade Técnica</strong><br>
							<input type="radio" <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?>  name="exame_oit[qualidade]" value="1" 
								<?php echo ( $exame_oit['qualidade'] == '1' || !$exame_oit['qualidade']) ? 'checked="checked"' : ''?>> 1 
							<input type="radio" <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?> name="exame_oit[qualidade]" value="2" 
								<?php echo $exame_oit['qualidade'] == '2' ? 'checked="checked"' : ''?>> 2 
							<input type="radio" <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?> name="exame_oit[qualidade]" value="3" 
								<?php echo $exame_oit['qualidade'] == '3' ? 'checked="checked"' : ''?>> 3 
							<input type="radio"  <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?> name="exame_oit[qualidade]" value="4" 
								<?php echo $exame_oit['qualidade'] == '4' ? 'checked="checked"' : ''?>> 4 
						</div>
					</div>
					<div class="row">
						<div class="span10"> 
							<label for="exame_oit[comentarios_qualidade]">Comentário</label> 
							<input type="text" style="width: 600px;" 
								<?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?> name="exame_oit[comentarios_qualidade]" value="<?php echo $exame_oit['comentarios_qualidade'] ?>"> 
						</div> 
					</div>
					<hr>
					<div class="row"> 
						<div class="span3">
							<strong>1B) Radiografia Normal</strong><br /> 
							<input type="radio"  <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?>  name="exame_oit[normal]" onclick="parseSessao1('S')" value="S"
								<?php echo ( $exame_oit['normal'] == 'S' || !$exame_oit['normal'] ) ? 'checked="checked"' : ''?>> SIM 
							<input type="radio"  <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?>  name="exame_oit[normal]" onclick="parseSessao1('N')" value="N" 
								<?php echo $exame_oit['normal'] == 'N' ? 'checked="checked"' : ''?>> NÃO 
						</div>
					</div>
					<hr>
					<div class="row">
						<div class="span6">
							<strong>2A) Alguma anormalidade de parênquima consistente com pneumoconiose</strong><br />
							<input id="anormalidade_parenquima" type="radio"  <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?>  name="exame_oit[anormalidade_parenquima]" onclick="changeSessao2('S')" value="S" 
								<?php echo $exame_oit['anormalidade_parenquima'] == 'S' ? 'checked="checked"' : ''?>> SIM
							<input id="anormalidade_parenquima" type="radio"  <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?>  name="exame_oit[anormalidade_parenquima]" onclick="changeSessao2('N')" value="N"
								<?php echo $exame_oit['anormalidade_parenquima'] == 'N' ? 'checked="checked"' : ''?>> NÃO
						</div>
					</div>
					<hr>
					<div id="sessao2" style="display: none">
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
									<input type="radio" <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?> name="exame_oit[primarias]" value="P"
										<?php echo $exame_oit['primarias'] == 'P' ? 'checked="checked"' : ''?>> p
									<input type="radio" <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?> name="exame_oit[primarias]" value="S"
										<?php echo $exame_oit['primarias'] == 'S' ? 'checked="checked"' : ''?>> s
								</div>
								<div>
									<input type="radio"  <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?>  name="exame_oit[primarias]" value="Q"
										<?php echo $exame_oit['primarias'] == 'Q' ? 'checked="checked"' : ''?>> q
									<input type="radio"  <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?> name="exame_oit[primarias]" value="T"
										<?php echo $exame_oit['primarias'] == 'T' ? 'checked="checked"' : ''?>> t
								</div>
								<div>
									<input type="radio"  <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?>  name="exame_oit[primarias]" value="R"
										<?php echo $exame_oit['primarias'] == 'R' ? 'checked="checked"' : ''?>> r
									<input type="radio"  <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?>  name="exame_oit[primarias]" value="U"
										<?php echo $exame_oit['primarias'] == 'U' ? 'checked="checked"' : ''?>> u
								</div>
							</div>
							<div class="span2"> 
								<strong>Secundárias</strong>
								<div>
									<input type="radio"  <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?>  name="exame_oit[secundarias]" value="P"
										<?php echo $exame_oit['secundarias'] == 'P' ? 'checked="checked"' : ''?>> p 
									<input type="radio"  <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?>  name="exame_oit[secundarias]" value="S" 
										<?php echo $exame_oit['secundarias'] == 'S' ? 'checked="checked"' : ''?>> s
								</div>
								<div>
									<input type="radio"  <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?>  name="exame_oit[secundarias]" value="Q" 
										<?php echo $exame_oit['secundarias'] == 'Q' ? 'checked="checked"' : ''?>> q
									<input type="radio"  <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?>  name="exame_oit[secundarias]" value="T" 
										<?php echo $exame_oit['secundarias'] == 'T' ? 'checked="checked"' : ''?>> t
								</div>
								<div>
									<input type="radio"  <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?>  name="exame_oit[secundarias]" value="R" 
										<?php echo $exame_oit['secundarias'] == 'R' ? 'checked="checked"' : ''?>> t 
									<input type="radio" <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?>  name="exame_oit[secundarias]" value="U"
										<?php echo $exame_oit['secundarias'] == 'U' ? 'checked="checked"' : ''?>> u
								</div>
							</div>
							<div class="span2"> 
								<div>
									<input type="checkbox"  <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?>  name="exame_oit[zonas_d1]" value="S"
										<?php echo $exame_oit['zonas_d1'] == 'S' ? 'checked="checked"' : ''?>> D 
									<input type="checkbox"  <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?>  name="exame_oit[zonas_e1]" value="S"
										<?php echo $exame_oit['zonas_e1'] == 'S' ? 'checked="checked"' : ''?>> E
								</div>
								<div>
									<input type="checkbox" <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?>  name="exame_oit[zonas_d2]" value="S"
										<?php echo $exame_oit['zonas_d2'] == 'S' ? 'checked="checked"' : ''?>> D 
									<input type="checkbox"  <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?> 	name="exame_oit[zonas_e2]" value="S"
										<?php echo $exame_oit['zonas_e2'] == 'S' ? 'checked="checked"' : ''?>> E
								</div>
								<div>
									<input type="checkbox"  <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?>  name="exame_oit[zonas_d3]" value="S"
										<?php echo $exame_oit['zonas_d3'] == 'S' ? 'checked="checked"' : ''?>> D
									<input type="checkbox"  <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?> 	name="exame_oit[zonas_e3]" value="S"
										<?php echo $exame_oit['zonas_e3'] == 'S' ? 'checked="checked"' : ''?>> E
								</div>
							</div>
							<div class="span2"> 
								<div>
									<input type="radio"  <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?> name="exame_oit[profusao]" value="0/-"
										<?php echo $exame_oit['profusao'] == '0/-' ? 'checked="checked"' : ''?>> 0/- 
									<input type="radio"  <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?>  name="exame_oit[profusao]" value="0/0"
										<?php echo $exame_oit['profusao'] == '0/0' ? 'checked="checked"' : ''?>> 0/0
									<input type="radio"  <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?>  name="exame_oit[profusao]" value="0/1"
										<?php echo $exame_oit['profusao'] == '0/1' ? 'checked="checked"' : ''?>> 0/1
								</div>
								<div>
									<input type="radio"  <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?>  name="exame_oit[profusao]" value="1/0"
										<?php echo $exame_oit['profusao'] == '1/0' ? 'checked="checked"' : ''?>> 1/0 
									<input type="radio" <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?>  name="exame_oit[profusao]" value="1/1"
										<?php echo $exame_oit['profusao'] == '1/1' ? 'checked="checked"' : ''?>> 1/1
									<input type="radio" 	<?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?>  name="exame_oit[profusao]" value="1/2"
										<?php echo $exame_oit['profusao'] == '1/2' ? 'checked="checked"' : ''?>> 1/2
								</div>
								<div>
									<input type="radio" <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?>  name="exame_oit[profusao]" value="2/1"
										<?php echo $exame_oit['profusao'] == '2/1' ? 'checked="checked"' : ''?>> 2/1 
									<input type="radio"  <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?>  name="exame_oit[profusao]" value="2/2"
										<?php echo $exame_oit['profusao'] == '2/2' ? 'checked="checked"' : ''?>> 2/2 
									<input type="radio"  <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?>  name="exame_oit[profusao]" value="2/3"
										<?php echo $exame_oit['profusao'] == '2/3' ? 'checked="checked"' : ''?>> 2/3
								</div>
								<div>
									<input type="radio"  <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?>  name="exame_oit[profusao]" value="3/2"
										<?php echo $exame_oit['profusao'] == '3/2' ? 'checked="checked"' : ''?>> 3/2
									<input type="radio"  <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?> name="exame_oit[profusao]" value="3/3"
										<?php echo $exame_oit['profusao'] == '3/3' ? 'checked="checked"' : ''?>> 3/3
									<input type="radio" 	<?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?>  name="exame_oit[profusao]" value="3/+"
										<?php echo $exame_oit['profusao'] == '3/+' ? 'checked="checked"' : ''?>> 3/+
								</div>
							</div>
						</div>
						<hr>
						<div class="row">
							<div class="span3">
								<strong>2C) Grandes Opacidades</strong>
								<div>
									<input type="radio" <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?>  name="exame_oit[grd_opacidade]" value="0"
										<?php echo $exame_oit['grd_opacidade'] == '0' ? 'checked="checked"' : ''?>> 0 
									<input type="radio"  <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?>  name="exame_oit[grd_opacidade]" value="A"
										<?php echo $exame_oit['grd_opacidade'] == 'A' ? 'checked="checked"' : ''?>> A
									<input type="radio" 	<?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?>  name="exame_oit[grd_opacidade]" value="B"
										<?php echo $exame_oit['grd_opacidade'] == 'B' ? 'checked="checked"' : ''?>> B 
									<input type="radio" <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?>  name="exame_oit[grd_opacidade]" value="C"
										<?php echo $exame_oit['grd_opacidade'] == 'C' ? 'checked="checked"' : ''?>> C
								</div>
							</div>
						</div>
						<hr>
					</div>
					<div class="row"> 
						<div class="span6"> 
							<strong>3A) Alguma anormalidade pleural consistente com pneumoconiose</strong><br />
							<input id="anormalidade_pleural" type="radio" <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?>  onclick="changeSessao3('S')" name="exame_oit[anormalidade_pleural]" value="S"
								<?php echo $exame_oit['anormalidade_pleural'] == 'S' ? 'checked="checked"' : ''?>> SIM 
							<input id="anormalidade_pleural" type="radio"  <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?>  onclick="changeSessao3('N')" name="exame_oit[anormalidade_pleural]" value="N"
								<?php echo $exame_oit['anormalidade_pleural'] == 'N' ? 'checked="checked"' : ''?>> NÃO 
						</div>
					</div>
					<hr>
					<div id="sessao3" style="display: none">
						<div class="row">
							<div class="span6">
								<strong>3B) Placas Pleurais</strong> 
							</div>
						</div>
						<div class="row">
							<div class="span3"> 
								<input type="radio" <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?>  name="exame_oit[placas_pleurais]" value="S"
									<?php echo $exame_oit['placas_pleurais'] == 'S' ? 'checked="checked"' : ''?>> SIM
								<input type="radio"  <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?> name="exame_oit[placas_pleurais]" value="N"
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
									<input type="checkbox"  <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?> 	name="exame_oit[placas_parede_local_0]" value="S"
										<?php echo $exame_oit['placas_parede_local_0'] == 'S' ? 'checked="checked"' : ''?>> 0
									<input type="checkbox"  <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?> 	name="exame_oit[placas_parede_local_D]" value="S"
										<?php echo $exame_oit['placas_parede_local_D'] == 'S' ? 'checked="checked"' : ''?>> D
									<input type="checkbox"  <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?> 	name="exame_oit[placas_parede_local_E]" value="S"
										<?php echo $exame_oit['placas_parede_local_E'] == 'S' ? 'checked="checked"' : ''?>> E
								</div>
								<div>
									<input type="checkbox"  <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?> name="exame_oit[placas_frontal_local_0]" value="S"
										<?php echo $exame_oit['placas_frontal_local_0'] == 'S' ? 'checked="checked"' : ''?>> 0
									<input type="checkbox"  <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?> name="exame_oit[placas_frontal_local_D]" value="S"
										<?php echo $exame_oit['placas_frontal_local_D'] == 'S' ? 'checked="checked"' : ''?>> D
									<input type="checkbox"  <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?> name="exame_oit[placas_frontal_local_E]" value="S"
										<?php echo $exame_oit['placas_frontal_local_E'] == 'S' ? 'checked="checked"' : ''?>> E
								</div>
								<div>
									<input type="checkbox"  <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?> 	name="exame_oit[placas_diafrag_local_0]" value="S"
										<?php echo $exame_oit['placas_diafrag_local_0'] == 'S' ? 'checked="checked"' : ''?>> 0
									<input type="checkbox"  <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?> 	name="exame_oit[placas_diafrag_local_D]" value="S"
										<?php echo $exame_oit['placas_diafrag_local_D'] == 'S' ? 'checked="checked"' : ''?>> D
									<input type="checkbox"  <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?> 	name="exame_oit[placas_diafrag_local_E]" value="S"
										<?php echo $exame_oit['placas_diafrag_local_E'] == 'S' ? 'checked="checked"' : ''?>> E
								</div>
								<div>
									<input type="checkbox"  <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?> 	name="exame_oit[placas_outros_local_0]" value="S"
										<?php echo $exame_oit['placas_outros_local_0'] == 'S' ? 'checked="checked"' : ''?>> 0
									<input type="checkbox"  <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?> 	name="exame_oit[placas_outros_local_D]" value="S"
										<?php echo $exame_oit['placas_outros_local_D'] == 'S' ? 'checked="checked"' : ''?>> D
									<input type="checkbox"  <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?> 	name="exame_oit[placas_outros_local_E]" value="S"
										<?php echo $exame_oit['placas_outros_local_E'] == 'S' ? 'checked="checked"' : ''?>> E
								</div>
							</div>
							<div class="span2">
								<strong>Calcificação</strong><br />
								<div>
									<input type="checkbox"  <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?>  name="exame_oit[placas_parede_calcif_0]" value="S"
										<?php echo $exame_oit['placas_parede_calcif_0'] == 'S' ? 'checked="checked"' : ''?>> 0
									<input type="checkbox"  <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?>  name="exame_oit[placas_parede_calcif_D]" value="S"
										<?php echo $exame_oit['placas_parede_calcif_D'] == 'S' ? 'checked="checked"' : ''?>> D
									<input type="checkbox"  <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?>  name="exame_oit[placas_parede_calcif_E]" value="S"
										<?php echo $exame_oit['placas_parede_calcif_E'] == 'S' ? 'checked="checked"' : ''?>> E
								</div>
								<div>
									<input type="checkbox"  <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?>  name="exame_oit[placas_frontal_calcif_0]" value="S"
										<?php echo $exame_oit['placas_frontal_calcif_0'] == 'S' ? 'checked="checked"' : ''?>> 0
									<input type="checkbox"  <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?>  name="exame_oit[placas_frontal_calcif_D]" value="S"
										<?php echo $exame_oit['placas_frontal_calcif_D'] == 'S' ? 'checked="checked"' : ''?>> D
									<input type="checkbox"  <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?>  name="exame_oit[placas_frontal_calcif_E]" value="S"
										<?php echo $exame_oit['placas_frontal_calcif_E'] == 'S' ? 'checked="checked"' : ''?>> E
								</div>
								<div>
									<input type="checkbox"  <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?>  name="exame_oit[placas_diafrag_calcif_0]" value="S"
										<?php echo $exame_oit['placas_diafrag_calcif_0'] == 'S' ? 'checked="checked"' : ''?>> 0
									<input type="checkbox"  <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?>  name="exame_oit[placas_diafrag_calcif_D]" value="S"
										<?php echo $exame_oit['placas_diafrag_calcif_D'] == 'S' ? 'checked="checked"' : ''?>> D
									<input type="checkbox"  <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?>  name="exame_oit[placas_diafrag_calcif_E]" value="S"
										<?php echo $exame_oit['placas_diafrag_calcif_E'] == 'S' ? 'checked="checked"' : ''?>> E
								</div>
								<div>
									<input type="checkbox"  <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?>  name="exame_oit[placas_outros_calcif_0]" value="S"
										<?php echo $exame_oit['placas_outros_calcif_0'] == 'S' ? 'checked="checked"' : ''?>> 0
									<input type="checkbox"  <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?>  name="exame_oit[placas_outros_calcif_D]" value="S"
										<?php echo $exame_oit['placas_outros_calcif_D'] == 'S' ? 'checked="checked"' : ''?>> D
									<input type="checkbox"  <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?>  name="exame_oit[placas_outros_calcif_E]" value="S"
										<?php echo $exame_oit['placas_outros_calcif_E'] == 'S' ? 'checked="checked"' : ''?>> E
								</div>
							</div>
						</div>
						<div class="row">
							<div class="span5">
								<strong>Extensão da parede(combinado perfil e frontal)</strong><br/>
								<div style="float:left; width:50%">
									<div>
										<input type="checkbox" <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?>  name="exame_oit[placas_extensao_o_d_0]" value="S"
											<?php echo $exame_oit['placas_extensao_o_d_0'] == 'S' ? 'checked="checked"' : ''?>> 0
										<input type="checkbox" <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?>  name="exame_oit[placas_extensao_o_d_D]" value="S"
											<?php echo $exame_oit['placas_extensao_o_d_D'] == 'S' ? 'checked="checked"' : ''?>> D
										<input type="checkbox" <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?> name="exame_oit[placas_extensao_o_d_1]" value="S"
											<?php echo $exame_oit['placas_extensao_o_d_1'] == 'S' ? 'checked="checked"' : ''?>> 1
										<input type="checkbox" <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?> name="exame_oit[placas_extensao_o_d_2]" value="S"
											<?php echo $exame_oit['placas_extensao_o_d_2'] == 'S' ? 'checked="checked"' : ''?>> 2
										<input type="checkbox" <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?> name="exame_oit[placas_extensao_o_d_3]" value="S"
											<?php echo $exame_oit['placas_extensao_o_d_3'] == 'S' ? 'checked="checked"' : ''?>> 3
									</div>
                                    <div>
                                        <input type="checkbox"  <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?>  name="exame_oit[placas_extensao_o_e_0]" value="S"
                                            <?php echo $exame_oit['placas_extensao_o_e_0'] == 'S' ? 'checked="checked"' : ''?>> 0
                                        <input type="checkbox"  <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?>  name="exame_oit[placas_extensao_o_e_E]" value="S"
                                            <?php echo $exame_oit['placas_extensao_o_e_E'] == 'S' ? 'checked="checked"' : ''?>> E
                                        <input type="checkbox"  <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?>  name="exame_oit[placas_extensao_o_e_1]" value="S"
                                            <?php echo $exame_oit['placas_extensao_o_e_1'] == 'S' ? 'checked="checked"' : ''?>> 1
                                        <input type="checkbox"  <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?>  name="exame_oit[placas_extensao_o_e_2]" value="S"
                                            <?php echo $exame_oit['placas_extensao_o_e_2'] == 'S' ? 'checked="checked"' : ''?>> 2
                                        <input type="checkbox"  <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?>  name="exame_oit[placas_extensao_o_e_3]" value="S"
                                            <?php echo $exame_oit['placas_extensao_o_e_3'] == 'S' ? 'checked="checked"' : ''?>> 3
                                    </div>
									<i>Até 1/4 da parede lateral = 1<br /> 1/4 à 1/2 da parede lateral = 2<br />1/2 da parede lateral = 3<br /></i>
								</div>
							</div>
							<div class="span5">
								<strong>Largura(opcional) (mínimo de 3mm para marcação)</strong><br />
								<div style="float: left; width: 50%">
                                    <div>
                                        <input type="checkbox"  <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?>  name="exame_oit[placas_largura_d_D]" value="S"
                                            <?php echo $exame_oit['placas_largura_d_D'] == 'S' ? 'checked="checked"' : ''?>> D
                                        <input type="checkbox"  <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?>  name="exame_oit[placas_largura_d_A]" value="S"
                                            <?php echo $exame_oit['placas_largura_d_A'] == 'S' ? 'checked="checked"' : ''?>> a 
                                        <input type="checkbox"  <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?> name="exame_oit[placas_largura_d_B]" value="S"
                                            <?php echo $exame_oit['placas_largura_d_B'] == 'S' ? 'checked="checked"' : ''?>> b
                                        <input type="checkbox"  <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?>  name="exame_oit[placas_largura_d_C]" value="S"
                                            <?php echo $exame_oit['placas_largura_d_C'] == 'S' ? 'checked="checked"' : ''?>> c
                                    </div>
                                    <div>
                                        <input type="checkbox"  <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?> name="exame_oit[placas_largura_e_E]" value="S"
                                            <?php echo $exame_oit['placas_largura_e_E'] == 'S' ? 'checked="checked"' : ''?>> E
                                        <input type="checkbox"  <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?>  name="exame_oit[placas_largura_e_A]" value="S"
                                            <?php echo $exame_oit['placas_largura_e_A'] == 'S' ? 'checked="checked"' : ''?>> a
                                        <input type="checkbox"  <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?> 	name="exame_oit[placas_largura_e_B]" value="S"
                                            <?php echo $exame_oit['placas_largura_e_B'] == 'S' ? 'checked="checked"' : ''?>> b
                                        <input type="checkbox"  <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?> 	name="exame_oit[placas_largura_e_C]" value="S"
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
								<input type="checkbox"  <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?>  name="exame_oit[obliteracao_0]" value="S"
									<?php echo $exame_oit['obliteracao_0'] == 'S' ? 'checked="checked"' : ''?>> 0 
								<input type="checkbox"  <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?>  name="exame_oit[obliteracao_D]" value="S"
									<?php echo $exame_oit['obliteracao_D'] == 'S' ? 'checked="checked"' : ''?>> D 
								<input type="checkbox"  <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?> 	name="exame_oit[obliteracao_E]" value="S"
									<?php echo $exame_oit['obliteracao_E'] == 'S' ? 'checked="checked"' : ''?>> E<br />  
							</div>
						</div>
						<hr>
						<div class="row"> 
							<div class="span3"> 
								<strong>3D) Espessamento pleural difuso:</strong><br /> 
								<input type="radio"  <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?> name="exame_oit[espessamento_pleural]" value="S"
									<?php echo $exame_oit['espessamento_pleural'] == 'S' ? 'checked="checked"' : ''?>> SIM 
								<input type="radio"  <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?> name="exame_oit[espessamento_pleural]" value="N"
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
								<input type="checkbox"  <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?>  name="exame_oit[espes_parede_local_0]" value="S"
									<?php echo $exame_oit['espes_parede_local_0'] == 'S' ? 'checked="checked"' : ''?>> 0
								<input type="checkbox"  <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?>  name="exame_oit[espes_parede_local_D]" value="S"
									<?php echo $exame_oit['espes_parede_local_D'] == 'S' ? 'checked="checked"' : ''?>> D
								<input type="checkbox"  <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?> 	name="exame_oit[espes_parede_local_E]" value="S"
									<?php echo $exame_oit['espes_parede_local_E'] == 'S' ? 'checked="checked"' : ''?>> E<br />
								<input type="checkbox"  <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?>  name="exame_oit[espes_frontal_local_0]" value="S"
									<?php echo $exame_oit['espes_frontal_local_0'] == 'S' ? 'checked="checked"' : ''?>> 0
								<input type="checkbox"  <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?>  name="exame_oit[espes_frontal_local_D]" value="S"
									<?php echo $exame_oit['espes_frontal_local_D'] == 'S' ? 'checked="checked"' : ''?>> D
								<input type="checkbox"  <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?>  name="exame_oit[espes_frontal_local_E]" value="S"
									<?php echo $exame_oit['espes_frontal_local_E'] == 'S' ? 'checked="checked"' : ''?>> E
							</div>
							<div class="span2">
								<strong>Calcificação</strong><br />
								<input type="checkbox"  <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?>  name="exame_oit[espes_parede_calcif_0]" value="S"
									<?php echo $exame_oit['espes_parede_calcif_0'] == 'S' ? 'checked="checked"' : ''?>> 0
								<input type="checkbox"  <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?>  name="exame_oit[espes_parede_calcif_D]" value="S"
									<?php echo $exame_oit['espes_parede_calcif_D'] == 'S' ? 'checked="checked"' : ''?>> D
								<input type="checkbox"  <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?> 	name="exame_oit[espes_parede_calcif_E]" value="S"
									<?php echo $exame_oit['espes_parede_calcif_E'] == 'S' ? 'checked="checked"' : ''?>> E<br />
								<input type="checkbox"  <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?>  name="exame_oit[espes_frontal_calcif_0]" value="S"
									<?php echo $exame_oit['espes_frontal_calcif_0'] == 'S' ? 'checked="checked"' : ''?>> 0
								<input type="checkbox"  <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?>  name="exame_oit[espes_frontal_calcif_D]" value="S"
									<?php echo $exame_oit['espes_frontal_calcif_D'] == 'S' ? 'checked="checked"' : ''?>> D
								<input type="checkbox"  <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?>  name="exame_oit[espes_frontal_calcif_E]" value="S"
									<?php echo $exame_oit['espes_frontal_calcif_E'] == 'S' ? 'checked="checked"' : ''?>> E
							</div>
						</div>
						<div class="row">
							<div class="span5">
								<strong>Extensão da parede(combinado perfil e frontal)</strong><br/>
								<div style="float:left; width:50%">
									<div>
										<input type="checkbox" <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?>  name="exame_oit[espes_extensao_o_d_0]" value="S"
											<?php echo $exame_oit['espes_extensao_o_d_0'] == 'S' ? 'checked="checked"' : ''?>> 0
										<input type="checkbox" <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?>  name="exame_oit[espes_extensao_o_d_D]" value="S"
											<?php echo $exame_oit['espes_extensao_o_d_D'] == 'S' ? 'checked="checked"' : ''?>> D
                                        <input type="checkbox" <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?> name="exame_oit[espes_extensao_o_d_1]" value="S"
                                            <?php echo $exame_oit['espes_extensao_o_d_1'] == 'S' ? 'checked="checked"' : ''?>> 1
                                        <input type="checkbox" <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?> name="exame_oit[espes_extensao_o_d_2]" value="S"
                                            <?php echo $exame_oit['espes_extensao_o_d_2'] == 'S' ? 'checked="checked"' : ''?>> 2
                                        <input type="checkbox" <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?> name="exame_oit[espes_extensao_o_d_3]" value="S"
                                            <?php echo $exame_oit['espes_extensao_o_d_3'] == 'S' ? 'checked="checked"' : ''?>> 3
									</div>
									<div>
                                        <input type="checkbox"  <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?>  name="exame_oit[espes_extensao_o_e_0]" value="S"
                                            <?php echo $exame_oit['espes_extensao_o_e_0'] == 'S' ? 'checked="checked"' : ''?>> 0
                                        <input type="checkbox"  <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?>  name="exame_oit[espes_extensao_o_e_E]" value="S"
                                            <?php echo $exame_oit['espes_extensao_o_e_E'] == 'S' ? 'checked="checked"' : ''?>> E
                                        <input type="checkbox"  <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?>  name="exame_oit[espes_extensao_o_e_1]" value="S"
                                            <?php echo $exame_oit['espes_extensao_o_e_1'] == 'S' ? 'checked="checked"' : ''?>> 1
                                        <input type="checkbox"  <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?>  name="exame_oit[espes_extensao_o_e_2]" value="S"
                                            <?php echo $exame_oit['espes_extensao_o_e_2'] == 'S' ? 'checked="checked"' : ''?>> 2
                                        <input type="checkbox"  <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?>  name="exame_oit[espes_extensao_o_e_3]" value="S"
                                            <?php echo $exame_oit['espes_extensao_o_e_3'] == 'S' ? 'checked="checked"' : ''?>> 3
									</div>
									<i>Até 1/4 da parede lateral = 1<br /> 1/4 à 1/2 da parede lateral = 2<br />1/2 da parede lateral = 3<br /></i>
								</div>
							</div>
							<div class="span5">
								<strong>Largura(opcional) (mínimo de 3mm para marcação)</strong><br />
								<div style="float: left; width: 50%">
                                    <div>
                                        <input type="checkbox"  <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?>  name="exame_oit[espes_largura_d_D]" value="S"
                                            <?php echo $exame_oit['espes_largura_d_D'] == 'S' ? 'checked="checked"' : ''?>> D
                                        <input type="checkbox"  <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?>  name="exame_oit[espes_largura_d_A]" value="S"
                                            <?php echo $exame_oit['espes_largura_d_A'] == 'S' ? 'checked="checked"' : ''?>> a
                                        <input type="checkbox"  <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?> name="exame_oit[espes_largura_d_B]" value="S"
                                            <?php echo $exame_oit['espes_largura_d_B'] == 'S' ? 'checked="checked"' : ''?>> b
                                        <input type="checkbox"  <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?>  name="exame_oit[espes_largura_d_C]" value="S"
                                            <?php echo $exame_oit['espes_largura_d_C'] == 'S' ? 'checked="checked"' : ''?>> c
                                    </div>
                                    <div>
                                        <input type="checkbox"  <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?> name="exame_oit[espes_largura_e_E]" value="S"
                                            <?php echo $exame_oit['espes_largura_e_E'] == 'S' ? 'checked="checked"' : ''?>> E
                                        <input type="checkbox"  <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?>  name="exame_oit[espes_largura_e_A]" value="S"
                                            <?php echo $exame_oit['espes_largura_e_A'] == 'S' ? 'checked="checked"' : ''?>> a
                                        <input type="checkbox"  <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?> 	name="exame_oit[espes_largura_e_B]" value="S"
                                            <?php echo $exame_oit['espes_largura_e_B'] == 'S' ? 'checked="checked"' : ''?>> b
                                        <input type="checkbox"  <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?> 	name="exame_oit[espes_largura_e_C]" value="S"
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
							<input id="outras_anormalidades" type="radio"  <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?>  onclick="changeSessao4('S')" name="exame_oit[outras_anormalidades]" value="S"
								<?php echo $exame_oit['outras_anormalidades'] == 'S' ? 'checked="checked"' : ''?>> SIM
							<input id="outras_anormalidades" type="radio"  <?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?>  onclick="changeSessao4('N')" name="exame_oit[outras_anormalidades]" value="N"
								<?php echo $exame_oit['outras_anormalidades'] == 'N' ? 'checked="checked"' : ''?>> NÃO
						</div>
					</div>
					<div id="sessao4" style="display: none;">
						<div class="row">
							<div class="span12">
								<strong>4B) Simbolos:</strong><br />
								<?php
								$tags = array('aa','at','ax','bu','ca','cg','cn','co','cp','cv','di','ef','em','es','fr','hi','ho','id','ih','kl','me','pa','pb','pi','px','ra','rp','tb','od');
								foreach ($tags as $t){
									$tag = '<input type="checkbox" value="S" name="exame_oit[simbolos_#tag#]" ' . '#disabled# #checked#> #tag#&nbsp;';
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
							<input type="text" style="width: 900px" 	<?php echo $exame['status'] == 2 ? 'disabled="disabled"' : "" ?>
								   id="exame_oit[comentarios_laudo]" 
								   name="exame_oit[comentarios_laudo]"
								   value="<?php echo $exame_oit['comentarios_laudo'] ?>"> 
						</div>
					</div>
				</div>

				<br />
			</fieldset>

			<div class="form-actions">
				<button type="reset" onclick="" class="btn">Cancelar</button>
				<!-- <button id="btnEnviarBaixar" onclick="sendForm();" class="btn btn-primary pull-center">Enviar/Baixar</button> -->
				<?php 
					$btnEnviarStyle = $exame['status'] != 0 ? "style='visibility: hidden;'" : ""; 
				?>
				<button <?php echo $btnEnviarStyle; ?> id="btnEnviarLaudo" type="submit" class="btn btn-primary pull-right">Enviar Laudo</button>
			</div>
		</div>
	</form>

	<!-- <a style="display: none" id="link_download_laudo" href="#" download /> -->

</div>

<script>

    function limparSessao2(){
        $("input[name='exame_oit[primarias]']").prop('checked', false);
        $("input[name='exame_oit[secundarias]']").prop('checked', false);
        $("input[name='exame_oit[zonas_d1]']").prop('checked', false);
        $("input[name='exame_oit[zonas_e1]']").prop('checked', false);
        $("input[name='exame_oit[zonas_d2]']").prop('checked', false);
        $("input[name='exame_oit[zonas_e2]']").prop('checked', false);
        $("input[name='exame_oit[zonas_d3]']").prop('checked', false);
        $("input[name='exame_oit[zonas_e3]']").prop('checked', false);
        $("input[name='exame_oit[profusao]']").prop('checked', false);
        $("input[name='exame_oit[grd_opacidade]']").prop('checked', false);
    }

    function limparSessao3(){
        $("input[name='exame_oit[placas_pleurais]']").prop('checked', false);

        $("input[name='exame_oit[placas_parede_local_0]']").prop('checked', false);
        $("input[name='exame_oit[placas_parede_local_D]']").prop('checked', false);
        $("input[name='exame_oit[placas_parede_local_E]']").prop('checked', false);

        $("input[name='exame_oit[placas_frontal_local_0]']").prop('checked', false);
        $("input[name='exame_oit[placas_frontal_local_D]']").prop('checked', false);
        $("input[name='exame_oit[placas_frontal_local_E]']").prop('checked', false);

        $("input[name='exame_oit[placas_diafrag_local_0]']").prop('checked', false);
        $("input[name='exame_oit[placas_diafrag_local_D]']").prop('checked', false);
        $("input[name='exame_oit[placas_diafrag_local_E]']").prop('checked', false);

        $("input[name='exame_oit[placas_outros_local_0]']").prop('checked', false);
        $("input[name='exame_oit[placas_outros_local_D]']").prop('checked', false);
        $("input[name='exame_oit[placas_outros_local_E]']").prop('checked', false);

        $("input[name='exame_oit[placas_parede_calcif_0]']").prop('checked', false);
        $("input[name='exame_oit[placas_parede_calcif_D]']").prop('checked', false);
        $("input[name='exame_oit[placas_parede_calcif_E]']").prop('checked', false);

        $("input[name='exame_oit[placas_frontal_calcif_0]']").prop('checked', false);
        $("input[name='exame_oit[placas_frontal_calcif_D]']").prop('checked', false);
        $("input[name='exame_oit[placas_frontal_calcif_E]']").prop('checked', false);

        $("input[name='exame_oit[placas_diafrag_calcif_0]']").prop('checked', false);
        $("input[name='exame_oit[placas_diafrag_calcif_D]']").prop('checked', false);
        $("input[name='exame_oit[placas_diafrag_calcif_E]']").prop('checked', false);

        $("input[name='exame_oit[placas_outros_calcif_0]']").prop('checked', false);
        $("input[name='exame_oit[placas_outros_calcif_D]']").prop('checked', false);
        $("input[name='exame_oit[placas_outros_calcif_E]']").prop('checked', false);

        $("input[name='exame_oit[placas_extensao_o_d_0]']").prop('checked', false);
        $("input[name='exame_oit[placas_extensao_o_d_D]']").prop('checked', false);
        $("input[name='exame_oit[placas_extensao_o_d_1]']").prop('checked', false);
        $("input[name='exame_oit[placas_extensao_o_d_2]']").prop('checked', false);
        $("input[name='exame_oit[placas_extensao_o_d_3]']").prop('checked', false);

        $("input[name='exame_oit[placas_extensao_o_e_0]']").prop('checked', false);
        $("input[name='exame_oit[placas_extensao_o_e_E]']").prop('checked', false);
        $("input[name='exame_oit[placas_extensao_o_e_1]']").prop('checked', false);
        $("input[name='exame_oit[placas_extensao_o_e_2]']").prop('checked', false);
        $("input[name='exame_oit[placas_extensao_o_e_3]']").prop('checked', false);

        $("input[name='exame_oit[placas_largura_d_D]']").prop('checked', false);
        $("input[name='exame_oit[placas_largura_d_A]']").prop('checked', false);
        $("input[name='exame_oit[placas_largura_d_B]']").prop('checked', false);
        $("input[name='exame_oit[placas_largura_d_C]']").prop('checked', false);

        $("input[name='exame_oit[placas_largura_e_E]']").prop('checked', false);
        $("input[name='exame_oit[placas_largura_e_A]']").prop('checked', false);
        $("input[name='exame_oit[placas_largura_e_B]']").prop('checked', false);
        $("input[name='exame_oit[placas_largura_e_C]']").prop('checked', false);

        $("input[name='exame_oit[obliteracao_0]']").prop('checked', false);
        $("input[name='exame_oit[obliteracao_D]']").prop('checked', false);
        $("input[name='exame_oit[obliteracao_E]']").prop('checked', false);

        $("input[name='exame_oit[espessamento_pleural]']").prop('checked', false);


        $("input[name='exame_oit[espes_parede_local_0]']").prop('checked', false);
        $("input[name='exame_oit[espes_parede_local_D]']").prop('checked', false);
        $("input[name='exame_oit[espes_parede_local_E]']").prop('checked', false);

        $("input[name='exame_oit[espes_frontal_local_0]']").prop('checked', false);
        $("input[name='exame_oit[espes_frontal_local_D]']").prop('checked', false);
        $("input[name='exame_oit[espes_frontal_local_E]']").prop('checked', false);


        $("input[name='exame_oit[espes_parede_calcif_0]']").prop('checked', false);
        $("input[name='exame_oit[espes_parede_calcif_D]']").prop('checked', false);
        $("input[name='exame_oit[espes_parede_calcif_E]']").prop('checked', false);

        $("input[name='exame_oit[espes_frontal_calcif_0]']").prop('checked', false);
        $("input[name='exame_oit[espes_frontal_calcif_D]']").prop('checked', false);
        $("input[name='exame_oit[espes_frontal_calcif_E]']").prop('checked', false);

        $("input[name='exame_oit[espes_extensao_o_d_0]']").prop('checked', false);
        $("input[name='exame_oit[espes_extensao_o_d_D]']").prop('checked', false);
        $("input[name='exame_oit[espes_extensao_o_d_1]']").prop('checked', false);
        $("input[name='exame_oit[espes_extensao_o_d_2]']").prop('checked', false);
        $("input[name='exame_oit[espes_extensao_o_d_3]']").prop('checked', false);

        $("input[name='exame_oit[espes_extensao_o_e_0]']").prop('checked', false);
        $("input[name='exame_oit[espes_extensao_o_e_E]']").prop('checked', false);
        $("input[name='exame_oit[espes_extensao_o_e_1]']").prop('checked', false);
        $("input[name='exame_oit[espes_extensao_o_e_2]']").prop('checked', false);
        $("input[name='exame_oit[espes_extensao_o_e_3]']").prop('checked', false);

        $("input[name='exame_oit[espes_largura_d_D]']").prop('checked', false);
        $("input[name='exame_oit[espes_largura_d_A]']").prop('checked', false);
        $("input[name='exame_oit[espes_largura_d_B]']").prop('checked', false);
        $("input[name='exame_oit[espes_largura_d_C]']").prop('checked', false);

        $("input[name='exame_oit[espes_largura_e_E]']").prop('checked', false);
        $("input[name='exame_oit[espes_largura_e_A]']").prop('checked', false);
        $("input[name='exame_oit[espes_largura_e_B]']").prop('checked', false);
        $("input[name='exame_oit[espes_largura_e_C]']").prop('checked', false);

    }

    function limparSessao4(){
        var tags = ['aa','at','ax','bu','ca','cg','cn','co','cp','cv','di','ef','em','es','fr','hi','ho','id','ih','kl','me','pa','pb','pi','px','ra','rp','tb','od'];
        tags.forEach(function(tag){
            $("input[name='exame_oit[simbolos_" + tag + "]'").prop('checked', false);
        });
    }

    function limparSessao1(){
        //$("input[name='exame_oit[normal]']").prop('checked', false);
        $("input[name='exame_oit[anormalidade_parenquima]']").prop('checked', false);
        $("input[name='exame_oit[anormalidade_pleural]']").prop('checked', false);
        $("input[name='exame_oit[outras_anormalidades]']").prop('checked', false);
    }

    function parseSessao1(value){
        if (value == 'S') {
            limparSessao1();
            limparSessao2();
            limparSessao3();
            limparSessao4();
        }
    }

	function changeSessao2(value){
		if (value == 'S') $("#sessao2").show();
		if (value == 'N') {
		    limparSessao2();
		    $("#sessao2").hide();
        }
	}

	function changeSessao3(value){
		if (value == 'S') $("#sessao3").show();
		if (value == 'N') {
		    limparSessao3();
		    $("#sessao3").hide();
        }
	}

	function changeSessao4(value){
		if (value == 'S') $("#sessao4").show();
		if (value == 'N') {
		    limparSessao4();
		    $("#sessao4").hide();
        }
	}

	$(document).ready(function(){

		parseImageContainer();
		
		if ($("#anormalidade_parenquima").is(":checked")) $("#sessao2").show();
		if ($("#anormalidade_pleural").is(":checked")) $("#sessao3").show();
		if ($("#outras_anormalidades").is(":checked")) $("#sessao4").show();

		$("#arquivo_selecionados").change(function() {
			var input = document.getElementById('arquivo_selecionados');
			var file = input.files[0];
			$('#fileupload-preview').text(file.name);

		});

		$("#laudo_modelo").change(function() {
			var value = $(this).val();
			$.post(baseUrl + "laudos/modelo", {_id: value}, function(d){
				$("#modelo_content").val(d);
				CKEDITOR.instances.modelo_content.updateElement();
			});
		});

		var url = $("#btnBaixarExame").attr("href");
		url = url.replace('?dummy=dummy', '');
		$.ajax({
			url: url,
			type: 'POST',
			success: function() {
				//window.location.assign(url); // abre na mesma aba!
				window.open(url); // abre em uma nova aba!
				webix.message("O Exame foi baixado!");
			},
			error: function() {
				webix.message({type:"error", text:"O exame não foi encontrado!"});
			}
		});

	});

</script>
