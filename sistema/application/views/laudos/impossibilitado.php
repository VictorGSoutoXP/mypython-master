<link href="<?php echo base_url('assets/css/laudo.css') ?>" rel="stylesheet" />
<div class="container">
	<div class="content">
		<div class="mt20">
			<p><strong>PREZADO CLIENTE,</strong></p>
			<div class="mt20">
			NÃO FOI POSSÍVEL REALIZAR O LAUDO DE: <strong class="destaque"><?php echo $exame['paciente'];?> - (ID <?php echo $exame['paciente_exame_id']?>)</strong>, POR UM DOS MOTIVOS ABAIXO:
			</div>
			<div class="mt20">
			<?php foreach ($motivos as $motivo) { ?>
				<div>
					(&nbsp;<strong><?php echo in_array($motivo['id'], $exame['opcoes_impossibilitado']) ? "x" : "&nbsp;"?></strong>&nbsp;) <?php echo $motivo['title']?>
				</div>
				&nbsp;&nbsp;
			<?php }?>
				<div class="clear"></div>
			</div>
			<div class="mt20">
				<p>Favor entrar em contato pelo Telefone: <strong class="destaque"><?php echo config_item("telefone_empresa");?></strong> ou pelo email: <strong class="destaque"><?php echo config_item("email_empresa");?></strong></p>
			</div>
		</div>
		<?php if ($exame['observacoes_medico']){?>
		<div class="mt20">
			<strong>OBSERVAÇÕES</strong>
			<div class="laudo-content">
				<!-- BEGIN CONTENT -->
				<?php echo nl2br($exame['observacoes_medico'])?>
				<!-- END CONTENT -->
			</div>
		</div>
		<?php }?>
		<div>
			<div class="center assinatura">
				<img src="<?php echo site_url('uploads/' . config_item('upload_folder_base') .'/assinaturas') ?>/<?php echo $exame['medico']['assinatura']?>" height="180" />
				<?php /**
				<div><strong><?php echo $exame['medico']['nome']?></strong></div>
				<div class="small"><strong><?php echo $exame['medico']['especialidade']?></strong></div>
				<div class="small"><strong>CRM: <?php echo $exame['medico']['crm']?></strong></div>
				*/?>
			</div>
			<br />
		</div>
	</div>
</div>