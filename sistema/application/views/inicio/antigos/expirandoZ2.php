<?php echo $this->load->view('layouts/menu',false,true,false); ?>
<?php echo "<meta HTTP-EQUIV='refresh' CONTENT='120;URL=http://damatelemedicina.com.br/sistema/inicio/expirando'>"; ?>
<div class="breadcrumb clearfix">
	Exames a serem laudados
</div>

<?php if($exames){?>
<div class="tableContainer">	<div class="row">
		<div class="span12">
			<div class="pull-left">
				<select name="lines" class="select-box-auto-width pagesize">
					<option value="100">Mostrar 100</option>
					<option value="200">Mostrar 200</option>
					<option value="500" selected="selected">Mostrar 500</option>
				</select>
			</div>
	
			<div class="pull-right" style="display: none;">
				<form action="#" class="form-search">
					<input type="text" class="input-medium search-query  search-table-list" placeholder="Procurar por Nome" name="search" />
				</form>
			</div>
		</div>
	</div>
	<br />
	<div class="row">
		<div class="span12">
			<table class="table-bordered table-list tablesorter table hasFilters tablesorter-bootstrap">
				<thead>
					<tr>
						<th>Nº</th>
						<?php if (!UserSession::isCliente() && !UserSession::isMedico()){?>
						<th>Cliente</th>
						<?php }?>
						<th>Paciente</th>
						<th>Tipo&nbsp;de&nbsp;Exame</th>
						<th>Envio</th>
						<th>Tempo&nbsp;Restante</th>
						<th data-sorter="false"></th>
						<?php if(UserSession::isAdmin()){?>
						    <th data-sorter="false"></th>
						<?php }?>
					</tr>
				</thead>
				<tbody>
				<?php foreach ($exames as $exame){ ?>
					<?php 
						$estilo_linha = "";
						$estilo_linha = $exame['emergencia'] == 2 ? "error" : $estilo_linha;
						$estilo_linha = $exame['emergencia'] == 1 ? "fast" : $estilo_linha;
					?>
					<tr class="<?php echo $exame['status'] == 1 ? "success" : ""?> <?php echo $estilo_linha; ?> <?php echo $exame['ativo'] == 0 ? "warning" : ""?> <?php echo $exame['status'] == 2 ? "laudo_impossibilitado" : ""?>">
						<td class="col-center"><strong><a href="<?php echo site_url("exames/laudo/" . $exame['id'])?>" class="info"><?php echo $exame['id']?></a></strong></td>
						<?php if (!UserSession::isCliente() && !UserSession::isMedico()){?>
						<td><?php echo $exame['cliente']?></td>
						<?php }?>
						<td><?php echo $exame['paciente']?></td>
						<td><?php echo $exame['exame']?></td>
						<td><?php echo date("d/m/Y H:i", strtotime($exame['create_date']));?></td>
						<td class="col-center">
						<?php $time = get_time_remainder($exame);
						if($time > 0){?>
							<span class="label label-success"><?php echo $time;?> Horas</span>
						<?php }else{?>
							<span class="label label-important"><?php echo $time;?> Horas</span>
						<?php }?>
						</td>
						<td class="col-center">
						<?php $linkLaudo = download_laudo($exame)?>
						<?php if(!$linkLaudo && (UserSession::isMedico() || UserSession::isAdmin())){?>
						    <!-- <a id="<?php echo download_exame($exame); ?>" onclick="baixarExame(this)" rel="<?php echo site_url("exames/laudo/" . $exame['id']) ?>" title="Enviar Laudo" class="btn icon-arrow-up btn-alert btn-icon"></a> -->
							<a id="<?php echo download_exame($exame); ?>" href="<?php echo site_url("exames/laudo/" . $exame['id']) ?>" title="Enviar Laudo" class="btn icon-arrow-up btn-alert btn-icon"></a>
						<?php }?>
						<?php if($linkLaudo){?>
						    <a href="<?php echo $linkLaudo?>" title="<?php echo $exame['status'] != 2 ? "Baixar Laudo" : "Baixar Explicação"?>" class="btn icon-arrow-down <?php echo $exame['status'] != 2 ? "btn-success" : ""?> btn-icon"></a>
						<?php }?>
						</td>
						<?php if(UserSession::isAdmin()){?>
						<td class="col-center">
						    <a href="<?php echo site_url("exames/manage_exame/desativar/" . $exame['id'])?>" title="Desativar Exame" class="btn icon-remove btn-danger btn-icon desativar <?php echo $exame['ativo'] == 0 ? "hide" : ""?>" data-message="Deseja marcar esse exame como desativado?"></a>
						    
						    <a href="<?php echo site_url("exames/manage_exame/ativar/" . $exame['id'])?>" title="Reativar Exame" class="btn icon-ok btn-success btn-icon ativar <?php echo $exame['ativo'] == 1 ? "hide" : ""?>" data-message="Deseja Reativar esse exame?"></a>
						    
						</td>
						<?php }?>
					</tr>
				<?php }?>
				</tbody>
			</table>
		</div>
	</div>
    <?php echo $this->load->view('layouts/pagination',false,true,false); ?>

	<a id="download_container" href="" style="display:none;"></a>

</div>
<?php }else{ ?>
    <div class="well">
    	<h3 class="text-center">Nenhum Exame encontrado</h3>
    </div>
<?php }?>

<script>

	function baixarExame(me){
		//var uri = window.location.origin + me.id + "?dummy=dummy";
		//$("#download_container").attr("href", uri);
		//document.getElementById("download_container").click();
		//console.log(me);
		//console.log(me.id, me.uri);
		//download(me.id + "?dummy=dummy");
		//window.location = window.location.origin + me.rel;
	}

</script>
