<link href="<?php echo base_url('assets/css/laudo.css') ?>" rel="stylesheet" />
	<div class="container">
		<div class="content">
			<div class="box title">LAUDO DE <?php echo strtoupper($exame['exame'])?> DIGITAL</div>
			<div class="mt20">
				<div class="box">
					<div class="box title inne box-inner">DADOS DO PACIENTE</div>
					
					<table class="table mt20" width="100%">
						<tr>
							<td width="35%" valign="top" colspan="2">
								<strong>NOME: </strong> <?php echo $exame['paciente']['nome']?>
							</td>
							<td width="30%" valign="top" colspan="2">
								<strong>EMPRESA: </strong>  <?php echo $exame['paciente']['empresa']?>
							</td>
							<td width="15%" valign="top">
								<strong>IDADE: </strong> <?php echo $exame['paciente']['idade']?>
							</td>
							<td width="20%" valign="top">
								<strong>DATA: </strong> <?php echo date('d.m.Y', strtotime($exame['create_date']))?>
							</td>
						</tr>
						<?php if((int)$exame['paciente']['cpf'] || (int)$exame['paciente']['rg']) {?>
							<tr>
								<?php if((int)$exame['paciente']['cpf']){?>
									<td valign="top">
										<strong>CPF: </strong> <?php echo $exame['paciente']['cpf']?>
									</td>
								<?php } if((int)$exame['paciente']['rg']){?>
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
							<td valign="top">
								<?php if(floatval($exame['peso'])){?><strong>PESO: </strong> <?php echo $exame['peso']?>KG<?php }?>
							</td>
							<td valign="top">
								<?php if(floatval($exame['altura'])){?><strong>ALTURA: </strong> <?php echo $exame['altura']?>M<?php }?>
							</td>
							<td valign="top">
								<?php if(floatval($exame['imc'])){?><strong>IMC: </strong> <?php echo $exame['imc']?><?php }?>
							</td>
							<td valign="top" colspan="2"></td>

						</tr>
						<?php if(!is_null($exame['fumante'])) { //Espirometria?>
						<tr>
						    <td valign="top">
								<strong>FUMA?: </strong> <?php echo $exame['fumante'] ? "SIM" : "NÃO"?>
							</td>
							<td valign="top">
								<strong>CIGARROS/DIA: </strong> <?php echo $exame['extra_data']['cigarros_dia']?>
							</td>
							<td valign="top" colspan="2">
								<strong>TEMPO FUMANTE: </strong> <?php echo $exame['fumante_tempo']?>
							</td>
						</tr>
						<?php }?>
					</table>
				</div>
			</div>
			<div class="mt20">
				<div class="box">
				<?php if($exame['exame_id'] == 1) { //Eletrocardiograma?>
					<div class="center" style="text-align: center;">
						DATA DO EXAME: <b><?php echo date('d/m/Y', strtotime($exame['exame_date']))?></b> <br />
						SOLICITANTE: <b><?php echo $exame['medico_solicitante']?></b> <br />
						CRM: <b><?php echo $exame['medico_solicitante_crm']?></b>
					</div>
				<?php }

				if($exame['exame_id'] == 2) { //ELETROENCEFALOGRAMA?>
					<div class="center" style="text-align: center;">
						DATA DO EXAME: <b><?php echo date('d/m/Y', strtotime($exame['exame_date']))?></b> <br />
						<!-- SOLICITANTE: <b><?php echo $exame['medico_solicitante']?></b> <br />
						CRM: <b><?php echo $exame['medico_solicitante_crm']?></b> -->
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
			<div class="mt20">
				<div class="box">
					<div class="box title inner box-inner">ANÁLISE</div>
					<div class="laudo-content">
						<!-- BEGIN CONTENT -->
						<?php echo $exame['modelo_content']?>
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