<link href="<?php echo base_url('assets/css/laudo.css') ?>" rel="stylesheet" xmlns="http://www.w3.org/1999/html"/>
<div>
	<div style="width:93%;overflow: hidden;font-size:12px;" class="container">
		<table style="width:100%">
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
						$nascimento = (strpos("2|3|7|8", $exame['exame_id']) !== false) ? $idade : $nascimento;
						$label_nascimento = (strpos("2|3|7|8", $exame['exame_id']) !== false) ? "Idade:" : "Dt de Nascimento:";
					?>
					<?php echo $label_nascimento; ?>&nbsp;<?php echo $nascimento; ?>
				</td>
				<td colspan="3">
					<?php if( $exame['paciente']['sexo'] ) {?>
						Sexo:<?php echo $exame['paciente']['sexo'] == "M" ? "Masculino" : "Feminino";?>
					<?php }?>					
				</td>
			</tr>
<?php if(trim($exame['paciente']['cpf']) || trim($exame['paciente']['rg']) || trim($exame['paciente']['funcao']) ) { ?>
			<tr>	
				<td>
					<?php if(trim($exame['paciente']['cpf'])){ ?>
						CPF:&nbsp;<?php echo $exame['paciente']['cpf']?>
					<?php } ?>
				</td>
				<td>
					<?php if(trim($exame['paciente']['rg'])){ ?>
						RG:&nbsp;<?php echo $exame['paciente']['rg']?>
					<?php } ?>
				</td>
				<td colspan="4">
					<?php if(trim($exame['paciente']['funcao'])){ ?>
						Função:&nbsp;<?php echo $exame['paciente']['funcao']?>
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

							$content = '
Ritmo Sinusal regular.
Eixo: Normal entre 0° e +90º.
Onda P: amplitude e duração normais. PR: duração normal.
QRS: duração, morfologia e amplitude normais.
ST: sem supra ou infradesnivelamento.
Onda T: morfologia habitual. QT: duração normal.
Conclusão: Traçado dentro dos limites da normalidade.
* A correta interpretação dos exames complementares deve ser feita mediante correlação com dados clínico-epidemiológicos do paciente
** Bibliografia: Pastore CA, Pinho JA, Pinho C, Samesima N, Pereira-Filho HG, Kruse JCL, et al. III Diretrizes da Sociedade Brasileira de Cardiologia sobre
Análise e Emissão de Laudos Eletrocardiográficos. Arq Bras Cardiol 2016; 106(4Supl.1):1-23
							';

							echo '<span style="font-size:10px;">' . $exame['modelo_content'] . '</span>';
							//echo '<span style="font-size:10px;">' . $content . '</span>';

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

		
<?php 

	$imprime_imagem = $exame['arquivo_imagem'] &&
					  $exame['cliente']['bloqueio_imagem_laudo'] !== '1' &&
					  !$exame['motivos'];
					  
	if ($imprime_imagem) { // inicio $imprime_imagem

	?>	
	
		<div style="width:70%;float:left;border:1px solid black;">
			<img src="<?php 
				
				$img = $exame['arquivo_imagem'];
				$img = preg_replace('/{{\d}}/','_0', $img);

				$folder_base = 'uploads/' . config_item('upload_folder_base') . '/exames';

				if (strpos($img, '../laudos/') === false){}
				else {
					$folder_base = 'uploads/' . config_item('upload_folder_base') . '/laudos';
					$img = str_replace('../laudos/', '', $img);
				}
				
				$img = site_url($folder_base) . '/' . $img;
				echo $img;
				
			?>" style="width:100%;height:100%;" />
			
			<!-- <?php file_put_contents($folder_base . '/' . $exame['id'] . '.txt', $img); ?> -->
			
			<span style='font-size: 9px;'>
				<?php 
					if (intval($exame['pagina_pdf_laudo']) > 0) 
						echo '&nbsp;&nbsp;PÁGINA:&nbsp;' .  $exame['pagina_pdf_laudo']; 
				?>
			</span>
			
		</div>
		
<!-- 
		<div style="width:80%;float:left;">
			<img src="<?php 
				$img = $exame['arquivo_imagem'];
				$img = preg_replace('/{{\d}}/','_0', $img);
				$folder_base = 'uploads/' . config_item('upload_folder_base') . '/exames';
				$img = site_url($folder_base) . '/' . $img;
				echo $img;							
			?>" style="max-width:600px;max-height:600px;width:auto;height:auto;" />
		</div>
-->

		<div>
			<div style="height:10%"></div>
			
<!-- ####################-->			
<?php if ($CERT) { // inicio $CERT ?>			
			<div align="center">
				<img src="<?php 
					echo site_url('assets/img/dama') . '/signer.jpeg'; 
				?>" /><br />
				<span style="color:red;font-family:Monospace;font-weight: bold;">
					<?php echo $CERT["protocolo"]; //'0123456789012345'; ?>
				</span>
			</div>
<?php } // fim $CERT ?>
<!-- ####################-->			

			<div>
				<img src="<?php 
					//$assinatura = '53.jpeg';
					$assinatura = $exame['medico']['assinatura'];
					$folder_base = 'uploads/' . config_item('upload_folder_base') . '/assinaturas';
					$img = site_url($folder_base) . '/' . $assinatura;
				echo  $img; 								
				?>" style="width:90%"/>
			</div>
			
		</div>

<?php } else { ?>

			<!-- <div style="height:10%"></div> -->

<!-- ####################-->			
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
<!-- ####################-->			

		<div class="center assinatura">
				<img src="<?php 
					$assinatura = $exame['medico']['assinatura'];
					$folder_base = 'uploads/' . config_item('upload_folder_base') . '/assinaturas';
					$img = site_url($folder_base) . '/' . $assinatura;
					echo $img; 								
				?>" style="width:30%" />
		</div>

<?php } // fim $imprime_imagem ?>
	
	</div>
</div>

