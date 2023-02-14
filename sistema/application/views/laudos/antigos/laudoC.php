<link href="<?php echo base_url('assets/css/laudo.css') ?>" rel="stylesheet" xmlns="http://www.w3.org/1999/html"/>
	<div class="container">
		<div class="content">
			<div class="box title">LAUDO DE <?php echo strtoupper($exame['exame'])?> DIGITAL </div>
			<div class="mt20">
				<div class="box">
                    
					<div class="box title inne box-inner">DADOS DO PACIENTE</div>
					
					<table class="table mt20" width="100%">
						<tr>
							<td width="35%" valign="top" colspan="2">
								<strong>NOME: </strong> <?php echo $exame['paciente']['nome']?>
							</td>
							<td width="35%" valign="top" colspan="2">
								<strong>EMPRESA: </strong>  <?php echo $exame['paciente']['empresa']?>
							</td>						
                            <td width="30%" valign="top">
								<!--
								<strong>NASC.: </strong> <?php echo date('d/m/Y', strtotime($exame['paciente']['nascimento']))?>
								-->
								<strong>IDADE: </strong> <?php echo $exame['paciente']['idade'] ?>
							</td>
						</tr>
						<?php if($exame['paciente']['cpf'] || $exame['paciente']['rg']) {?>
							<tr>
								<?php if($exame['paciente']['cpf']){?>
									<td valign="top">
										<strong>CPF: </strong> <?php echo $exame['paciente']['cpf']?>
									</td>
								<?php } if($exame['paciente']['rg']){?>
									<td valign="top">
										<strong>RG: </strong>  <?php echo $exame['paciente']['rg']?>
									</td>
								<?php }?>
								<td valign="top" colspan="4"></td>
							</tr>
						<?php }?>
						<tr>
							<td valign="top">
								<?php if( $exame['paciente']['sexo'] ) {?>
									<strong>SEXO: </strong> <?php echo $exame['paciente']['sexo'] == "M" ? "Masculino" : "Feminino";?>
								<?php }?>
							</td>
							

						</tr>
						
					</table>
				</div>
			</div>

			<div class="mt20">
				<div class="box">
					<div class="center" style="text-align: center;">
						DATA DO EXAME: <b><?php echo date('d/m/Y', strtotime($exame['exame_date']))?></b>&nbsp;&nbsp;
						DATA DO LAUDO: <b><?php echo date('d/m/Y', strtotime($exame['laudo_date']))?></b> <br />
						SOLICITANTE: <b><?php echo $exame['medico_solicitante']?></b>&nbsp;&nbsp;
						CRM: <b><?php echo $exame['medico_solicitante_crm']?></b><br />
						MOTIVO: <b><?php echo $exame['motivo']?></b>
					</div>
				</div>
			</div>

			<!--
			<div class="mt20">
				<div class="box">
				<?php if($exame['exame_id'] == 1) { //Eletrocardiograma?>
					<div class="center" style="text-align: center;">
						DATA DO EXAME: <b><?php echo date('d/m/Y', strtotime($exame['exame_date']))?></b>&nbsp;&nbsp;
						DATA DO LAUDO: <b><?php echo date('d/m/Y', strtotime($exame['laudo_date']))?></b> <br />
						SOLICITANTE: <b><?php echo $exame['medico_solicitante']?></b>&nbsp;&nbsp;
						CRM: <b><?php echo $exame['medico_solicitante_crm']?></b>								
						</div>
				<?php }if($exame['exame_id'] == 2) { //ELETROENCEFALOGRAMA?>
					<div class="center" style="text-align: center;">
						DATA DO EXAME: <b><?php echo date('d/m/Y', strtotime($exame['exame_date']))?></b>&nbsp;&nbsp;
						DATA DO LAUDO: <b><?php echo date('d/m/Y', strtotime($exame['laudo_date']))?></b> <br />
						SOLICITANTE: <b><?php echo $exame['medico_solicitante']?></b>&nbsp;&nbsp;
						CRM: <b><?php echo $exame['medico_solicitante_crm']?></b>
					</div>
				<?php }
						if($exame['exame_id'] == 3) { //ESPIROMETRIA?>
					<div class="center" style="text-align: center;">
						DATA DO EXAME: <b><?php echo date('d/m/Y', strtotime($exame['exame_date']))?></b>&nbsp;&nbsp;
						DATA DO LAUDO: <b><?php echo date('d/m/Y', strtotime($exame['laudo_date']))?></b> <br />
						SOLICITANTE: <b><?php echo $exame['medico_solicitante']?></b>&nbsp;&nbsp;
						CRM: <b><?php echo $exame['medico_solicitante_crm']?></b>
					</div>
						<?php }
						if($exame['exame_id'] == 4) { //RAIO-X?>
					<div class="center" style="text-align: center;">
						DATA DO EXAME: <b><?php echo date('d/m/Y', strtotime($exame['exame_date']))?></b> <br />
						DATA DO LAUDO: <b><?php echo date('d/m/Y', strtotime($exame['laudo_date']))?></b> <br />
						SOLICITANTE: <b><?php echo $exame['medico_solicitante']?></b> <br />
						CRM: <b><?php echo $exame['medico_solicitante_crm']?></b>
					</div>
						<?php }
						if($exame['exame_id'] == 5) { //mapa?>
					<div class="center" style="text-align: center;">
						DATA DO EXAME: <b><?php echo date('d/m/Y', strtotime($exame['exame_date']))?></b> <br />
						DATA DO LAUDO: <b><?php echo date('d/m/Y', strtotime($exame['laudo_date']))?></b> <br />
						SOLICITANTE: <b><?php echo $exame['medico_solicitante']?></b> <br />
						CRM: <b><?php echo $exame['medico_solicitante_crm']?></b>
					</div>	
				<?php }
				 {?>
    				<?php foreach ($motivos as $motivo) { ?>
    					<span class="box-left" style="display: inline-block;">
    						(&nbsp;<strong><?php echo $motivo['id'] == $exame['motivo_id'] ? "x" : "&nbsp;"?></strong>&nbsp;) <?php echo $motivo['nome']?>
    					</span>
    					&nbsp;&nbsp;
    				<?php }?>
				<?php }?>
					<div class="clear"></div>
				</div>
			</div>
			-->

			<div class="mt20">
				<div class="box">
					<div class="box title inner box-inner">ANÁLISE</div>
					<div class="laudo-content">
						<!-- BEGIN CONTENT -->
						<?php
							if(!$exame['motivos']) {

								echo $exame['modelo_content'];

							} else {
								echo '<h3>L A U D O&nbsp;&nbsp;I M P O S S I B I L I T A D O</h3>';
								echo '<ul>';
								foreach ($exame['motivos'] as $motivo)
									if (in_array($motivo['id'], $exame['opcoes_impossibilitado']))
										echo '<li>' . $motivo['title'] . '</li>';
								echo '</ul>';
							}
						?>
						<!-- END CONTENT -->
					</div>
					
					<div>
						<div class="center assinatura">
							<img src="<?php echo site_url('uploads/' . config_item('upload_folder_base') .'/assinaturas') ?>/<?php echo $exame['medico']['assinatura']?>" height="150" />
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>