<style type="text/css">
	.tracado {
		border: 1px solid black;
		width: 400px;
		height: 400px;
		background-color: blue;
	}
</style>

<link href="<?php echo base_url('assets/css/laudo.css') ?>" rel="stylesheet" xmlns="http://www.w3.org/1999/html"/>
<div>
	<div style="width:93%;overflow: hidden;font-size:12px;" class="container">
		<table>
			<tr><td colspan="6"><hr></td></tr>
			<tr>
				<td colspan="6">
					<center><b>
							LAUDO DE <?php echo strtoupper($exame['exame'])?>&nbsp;
							DIGITAL - Nº&nbsp;<?php echo $exame["paciente_exame_id"] ?>
					</b></center>							
				</td>
			</tr>
			<tr><td colspan="6"><hr></td></tr>
			<tr>	
				<td colspan="3">Nome:&nbsp;<?php echo $exame['paciente']['nome']?></td>
				<td colspan="3">Empresa:&nbsp;<?php echo $exame['paciente']['empresa']?></td>			
			</tr>
			<tr>	
				<td colspan="3">
					<?php 
						$nascimento = date('d/m/Y', strtotime($exame['paciente']['nascimento']));
						$idade = $exame['paciente']['idade'];
						$nascimento = $nascimento . "(" . $idade . ")";
						$nascimento = (strpos("2|7|8", $exame['exame_id']) !== false) ? $idade : $nascimento;
						$label_nascimento = (strpos("2|7|8", $exame['exame_id']) !== false) ? "Idade:" : "Dt de Nascimento:";
					?>
					<?php echo $label_nascimento; ?>&nbsp;<?php echo $nascimento; ?>
				</td>
				<td colspan="3">
					<?php if( $exame['paciente']['sexo'] ) {?>
						Sexo:<?php echo $exame['paciente']['sexo'] == "M" ? "Masculino" : "Feminino";?>
					<?php }?>					
				</td>
			</tr>
<?php if($exame['paciente']['cpf'] || $exame['paciente']['rg']) { ?>
			<tr>	
				<td colspan="3">
					<?php if($exame['paciente']['cpf']){ ?>
						CPF:&nbsp;<?php echo $exame['paciente']['cpf']?>
					<?php } ?>
				</td>
				<td colspan="3">
					<?php if($exame['paciente']['rg']){ ?>
						RG:&nbsp;<?php echo $exame['paciente']['rg']?>
					<?php } ?>
				</td>		
			</tr>
<?php } ?>
			<tr><td colspan="6"><hr></td></tr>
			<tr>
				<td colspan="6">
					<b><center>EXAME</b></center>
				</td>
			</tr>
			<tr><td colspan="6"><hr></td></tr>
			<tr>	
				<td colspan="3">Dt. Exame:&nbsp;<?php echo date('d/m/Y', strtotime($exame['exame_date']))?></td>
				<td colspan="3">Dt. Laudo:&nbsp;<?php echo date('d/m/Y', strtotime($exame['laudo_date']))?></td>		
			</tr>
			<tr>	
				<td colspan="3">
					Médico Solicitante:&nbsp;<?php echo $exame['medico_solicitante']?>&nbsp;
					CRM:&nbsp;<?php echo $exame['medico_solicitante_crm']?>
				</td>
				<td colspan="3">
					Motivo Exame:&nbsp;<?php echo $exame['motivo'] ?>
				</td>		
			</tr>
<?php if ($exame['exame_id'] == 6) { ?>
			<tr>	
				<td colspan="3">Acuidade visual longe OD:&nbsp;<?php echo $exame['acuidade_longe_od']?></td>
				<td colspan="3">Acuidade visual longe OE:&nbsp;<?php echo $exame['acuidade_longe_oe']?></td>		
			</tr>
			<tr>	
				<td colspan="3">Acuidade visual perto OD:&nbsp;<?php echo $exame['acuidade_perto_od']?></td>
				<td colspan="3">Acuidade visual perto OE:&nbsp;<?php echo $exame['acuidade_perto_oe']?></td>		
			</tr>
			<tr>	
				<td colspan="3">Lente corretiva:&nbsp;<?php echo $exame['lente_corretiva']?></td>
				<td colspan="3">Senso cromático:&nbsp;<?php echo $exame['senso_cromatico']?></td>		
			</tr>
			<tr>	
				<td colspan="3">Visão noturna:&nbsp;<?php echo $exame['visao_noturna']?></td>
				<td colspan="3">Visão ofuscada:&nbsp;<?php echo $exame['visao_ofuscada']?></td>		
			</tr>
			<tr>	
				<td colspan="3">Profundidade:&nbsp;<?php echo $exame['profundidade']?></td>
				<td colspan="3"></td>		
			</tr>					
<?php } ?>
			<tr><td colspan="6"><hr></td></tr>		
			<tr><td colspan="6"><center><b>ANÁLISE</b></center></td></tr>
			<tr><td colspan="6"><hr></td></tr>
			<tr>	
				<td colspan="6">
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
				</td>
			</tr>
		</table>

<?php if ($exame['arquivo_imagem']) { ?>	
		<div style="width:80%;float:left;">
			<img src="<?php 
				$img = $exame['arquivo_imagem'];
				$img = preg_replace('/{{\d}}/','_0', $img);
				$folder_base = 'uploads/' . config_item('upload_folder_base') . '/exames';
				$img = site_url($folder_base) . '/' . $img;
				echo $img;							
			?>" style="width:100%;height:100%" />
		</div>
		
		<div>
			<div style="height:30%"></div>
<?php if ($CERT) { ?>			
			<div align="center">
				<img src="<?php 
					echo site_url('assets/img/dama') . '/signer.jpeg'; 
				?>" /><br />
				<span style="color:red;font-family:Monospace;font-weight: bold;">
					<?php echo $CERT["protocolo"]; ?>
				</span>
			</div>
<?php } ?>
			<div>
				<img src="<?php 
					$assinatura = $exame['medico']['assinatura'];
					$folder_base = 'uploads/' . config_item('upload_folder_base') . '/assinaturas';
					$img = site_url($folder_base) . '/' . $assinatura;
				echo  $img; 								
				?>" style="width:90%"/>
			</div>
		</div>

<?php } else { ?>

			<div style="height:20%"></div>

<?php if ($CERT) { ?>			
			<div align="center">
				<img src="<?php 
					echo site_url('assets/img/dama') . '/signer.jpeg'; 
				?>" /><br />
				<span style="color:red;font-family:Monospace;font-weight: bold;">
					<?php echo $CERT["protocolo"]; ?>
				</span>
			</div>
<?php } ?>

		<div class="center assinatura">
				<img src="<?php 
					$assinatura = $exame['medico']['assinatura'];
					$folder_base = 'uploads/' . config_item('upload_folder_base') . '/assinaturas';
					$img = site_url($folder_base) . '/' . $assinatura;
				echo  $img; 								
				?>" />
		</div>

<?php } ?>
	
	</div>
</div>


