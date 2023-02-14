<div class="row">
	<div class="span12 page-header">Modelos de Laudos</div>
</div>
<div class="row">
	<div class="span12">
		<div class="pull-left">
			<a href="<?php echo site_url("laudos/novo_modelo/")?>" class="btn btn-primary">Adicionar Modelo</a>
		</div>
	</div>
</div>
<div class="tableContainer">
	<div class="row">
		<div class="span12">
			<table class="table-bordered table-list">
				<thead>
					<tr>
						<th data-sorter="false" width="30">Nº</th>
						<th>Modelo</th>
						<th data-sorter="false" width="150"></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($modelos as $modelo) { ?>
					<tr>
						<td class="cpf"><?php echo $modelo['id'];?></td>
						<td><?php echo $modelo['title']?></td>
						<td class="col-center">
							<a href="<?php echo site_url("laudos/novo_modelo/" . $modelo['id'])?>" class="btn btn-primary btn-small">Editar</a>
							<a href="<?php echo site_url("laudos/delete_modelo/" . $modelo['id'])?>" class="btn btn-danger btn-small remove">Remover</a>
						</td>
					</tr>
					<?php }?>
				</tbody>
			</table>
		</div>
	</div>
<?php echo $this->load->view('layouts/pagination',false,true,false); ?>
</div>