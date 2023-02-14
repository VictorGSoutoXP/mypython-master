<?php echo $this->load->view('layouts/menu',false,true,false); ?>
<script src="<?php echo base_url('assets/js/ckeditor/ckeditor.js') ?>"></script>

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
        	                <a href="<?php echo download_exame($exame)."?dummy=dummy";?> download" target="_blank" class="btn btn-success"><i class="icon-file"></i> Baixar Exame</a>
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
				<a href="<?php echo $linkLaudo?>" target="_blank" class="btn btn-error"><i class="icon-file"></i> Baixar laudo</a>
			<?php }elseif (UserSession::user('id') == $exame['medico_id'] || UserSession::isAdmin()){?>
				<a href="<?php echo site_url("exames/laudo/" . $exame['paciente_exame_id'])?>" target="_blank" class="btn btn-primary"><i class="icon-file"></i> Enviar Laudo</a>
			<?php }?>
			</div>
    </div>
</div>