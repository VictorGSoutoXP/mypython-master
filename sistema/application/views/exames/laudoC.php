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
							<?php $balloon = $usuario['mensagem_exames'] ? 'data-balloon-length="large" data-balloon="' . $usuario['mensagem_exames'] . '""' : ''?>
							<a <?php echo $balloon; ?> href="<?php echo download_exame($exame)."?dummy=dummy"; ?>" download target="_blank" class="btn btn-success"><i class="icon-file"></i> Baixar Exame</a>
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
			                <label>Selecione as Imagens Selecionadas (Zipadas)</label>
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
