	<div class="row">
		<div class="span12">

			<div class="pull-left">
				<select name="lines" class="pagesize span2">
					<option value="50">Mostrar 50</option>
					<option value="100">Mostrar 100</option>
					<option value="200" selected="selected">Mostrar 200</option>
				</select>
			</div>
			<div style="float: right">
				<!--
				<button disabled="disabled" onclick="BaixarLaudoLote()" class="btn btn-success">Baixar Laudos</button>
				-->
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
						<th>Data&nbsp;Laudo</th>
						<th data-sorter="status">Status</th>
						<th data-sorter="false"></th>
						<th data-sorter="false"></th>
						<?php if(UserSession::isAdmin()){?>
						    <th data-sorter="false"></th>
						<?php }?>
<!--
						<th data-sorter="false"></th>
-->
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

					<?php if (!UserSession::isMedico() || $exame['status'] != 0){?>
                        	<td class="col-center"><strong><a href="<?php echo site_url("exames/single/" . $exame['id'])?>" class="info"><?php echo $exame['id']?></a></strong></td>
					<?php }  else {  ?>
                        	<td class="col-center"><strong><a href="<?php echo site_url("exames/laudo/" . $exame['id'])?>" class="info"><?php echo $exame['id']?></a></strong></td>
                    <?php }?>

						<?php if (!UserSession::isCliente() && !UserSession::isMedico()){?>
						<td><?php echo $exame['cliente']?></td>
					<?php }?>
						<td><?php echo $exame['paciente']?></td>
						<td><?php echo $exame['exame']?> <?php echo $exame['sub_tipo_exame'] ? " - " . $exame['sub_tipo_exame']: ""?></td>
						<td><?php echo date("d/m/Y H:i", strtotime($exame['create_date']));?></td>
						<td><?php echo data_laudo($exame)?></td>
						<td data-create-date="<?php echo strtotime($exame['create_date']);?>"><?php echo status_laudo($exame);?></td>
						
						<td class="col-center">
							<?php $linkLaudo = download_laudo($exame)?>
							<?php if(!$linkLaudo && (UserSession::isMedico() || UserSession::isAdmin())){?>
							    <a href="<?php echo site_url("exames/laudo/" . $exame['id'])?>" title="Enviar Laudo" class="btn icon-list-alt btn-warning btn-icon"></a>
							<?php }?>
							<?php if($linkLaudo && !UserSession::isMedico()){?>
								<a href="<?php echo $linkLaudo?>" target="_blank" title="<?php echo $exame['status'] != 2 ? "Baixar Laudo" : "Baixar Explicação"?>" class="btn icon-download-alt <?php echo $exame['status'] != 2 ? "btn-success" : ""?> btn-icon"></a>
								<!--
								<a href="<?php echo site_url("exames/single/" . $exame['id'])?>" title="<?php echo $exame['status'] != 2 ? "Baixar Laudo" : "Baixar Explicação"?>" class="btn icon-download-alt <?php echo $exame['status'] != 2 ? "btn-success" : ""?> btn-icon"></a>
								-->
							<?php }?>
						</td>

						<td class="col-center">
						    <a href="<?php echo download_exame($exame)."?dummy=dummy"; ?>" download title="Baixar Exame" class="btn icon-film btn-info btn-icon"</a>
						</td>

						<?php if(UserSession::isAdmin()){?>
						<td class="col-center">
						    <a href="<?php echo site_url("exames/manage_exame/desativar/" . $exame['id'])?>" title="Desativar Exame" class="btn icon-remove btn-danger btn-icon desativar <?php echo $exame['ativo'] == 0 ? "hide" : ""?>" data-message="Deseja desativar este exame?"></a>
						    
						    <a href="<?php echo site_url("exames/manage_exame/ativar/" . $exame['id'])?>" title="Ativar Exame" class="btn icon-ok btn-success btn-icon ativar <?php echo $exame['ativo'] == 1 ? "hide" : ""?>" data-message="Deseja ativar esse exame?"></a>
						    
						</td>
						<?php }?>

<!--
						<td><label><input type="checkbox" value="<?php echo $exame['id']; ?>" /></label></td>
-->
					</tr>
				<?php }?>
				</tbody>
			</table>
		</div>
	</div>

