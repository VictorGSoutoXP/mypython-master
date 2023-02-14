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
    	                <textarea disabled="disabled" id="exame[observacoes]" cols="30" rows="4" class="span8"><?php echo $exame['observacoes']?></textarea>
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
				<fieldset>
					<legend>Imagem</legend>
					<img src="<?php echo site_url("uploads/dama/exames/" . $exame['arquivo_imagem'])?>" alt="Arquivo de imagem">
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
