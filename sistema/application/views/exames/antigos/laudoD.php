<?php echo $this->load->view('layouts/menu',false,true,false); ?>
<script src="<?php echo base_url('assets/js/ckeditor/ckeditor.js') ?>"></script>

<div class="row">
	<form action="<?php echo site_url("exames/laudo");?>" method="post" name="enviaLaudo" id="enviaLaudo" enctype="multipart/form-data">
	    <input type="hidden" name="_id" value="<?php echo $exame['paciente_exame_id']?>" />
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

							<a <?php echo $balloon. " " . $baixar_disabled; ?> href="<?php echo download_exame($exame)."?dummy=dummy"; ?>" download target="_blank"><i class="icon-file"></i> Baixar Exame</a>

	    	            </div>
		    		</div>
		    	</div>
		    </fieldset>
		    
		    <fieldset>
		    	<legend><strong class="text-error">Dados do Laudo</strong></legend>
		    	<div class="row">
		    	
		            <div class="span7">
	    	            <label class="checkbox">
	                      <input type="checkbox" id="laudo_impossibilitado" name="laudo_impossibilitado" value="1" <?php echo $exame['status'] == 2 ? "checked" : ""?> /> Laudo Impossibilitado
	                    </label>
		            </div>
		    	</div>
		    	<div id="laudo_info_container" class="well well-small" style="<?php echo $exame['status'] == 2 ? "display: none;" : ""?>">
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
						
			    		<div class="span7">
			                <label>Selecione as Imagens (Zipadas)</label>
			                <div class="fileupload fileupload-new" data-provides="fileupload">
		                        <span class="btn btn-file">
		                            <span class="fileupload-new">Selecione o arquivo</span>
		                            <span class="fileupload-exists">Alterar</span>
		                            <input id="arquivo_selecionados" type="file" name="arquivo_selecionados" />
		                        </span>
		                        <span class="fileupload-preview"></span>
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
		    	<br />
		    </fieldset>
		    
	        <div class="form-actions">
				<button type="reset" onclick="" class="btn">Cancelar</button>
				<button type="submit" class="btn btn-primary pull-right">Enviar Laudo</button>
			</div>
	    </div>
	</form>
</div>
