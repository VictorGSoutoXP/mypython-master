<div class="row">
	<div class="span12 page-header"><?php echo $paciente['id'] ? "Alterar Paciente" : "Novo Paciente"?></div>
</div>
<div class="row">
	<form action="<?php echo site_url("pacientes/novo")?>" method="post" name="cadastroPaciente" id="cadastroPaciente">
		<input type="hidden" name="_id" value="<?php echo $paciente['id']?>" />
		<div class="span3">
			<label for="nome">Nome Completo</label>
			<input type="text" id="nome" class="span3 required" name="nome" value="<?php echo $paciente['nome']?>" />
		</div>
		<div class="span2 fix-width">
			<label for="telefone">Telefone</label>
			<input type="text" id="telefone" class="span2 phone required" name="telefone" value="<?php echo mask($paciente['telefone'], "(##) ####-####")?>" />
		</div>
		<!-- <div class="span2">
			<label for="cpf">CPF</label>
			<input type="text" id="cpf" class="span2 cpf" name="cpf" value="<?php echo formatCPF($paciente['cpf']);?>" />
		</div>
		<div class="span3 fix-width">
			<label for="email">Email</label>
			<input type="text" id="email" class="span3" name="email" value="<?php echo $paciente['email']?>" />
		</div> -->
		<div class="span2 fix-width">
			<label>&nbsp;</label>
			<button class="btn btn-primary"><?php echo $paciente['id'] ? "Salvar Alterações" : "Cadastrar"?></button>
		</div>
	</form>
</div>

<div class="tableContainer">
	<div class="row">
		<div class="span12">
			<div class="pull-left">
				<select name="lines" class="select-box-auto-width pagesize">
					<option value="10">Mostrar 10</option>
					<option value="25">Mostrar 25</option>
					<option value="50">Mostrar 50</option>
					<option value="100">Mostrar 100</option>
				</select>
			</div>
	
			<div class="pull-right">
				<form action="#" class="form-search">
					<input type="text" class="input-medium search-query  search-table-list" placeholder="Procurar por Nome" name="search" />
				</form>
			</div>
		</div>
	
	</div>
	<div class="row">
		<div class="span12">
			<table class="table-bordered table-list">
				<thead>
					<tr>
						<th data-sorter="false">Nº</th>
						<th>Paciente</th>
						<?php /*<th>Email Paciente</th>*/?>
						<th data-sorter="false">Telefone</th>
						<th data-sorter="false"></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($pacientes as $paciente) { ?>
					<tr>
						<td class="cpf"><?php echo $paciente['id'];?></td>
						<td><?php echo $paciente['nome']?></td>
						<?php /*<td><?php echo $paciente['email']?></td>*/?>
						<td><?php echo mask($paciente['telefone'], "(##) ####-####")?></td>
						<td class="col-center">
							<a href="<?php echo site_url("pacientes/novo/" . $paciente['id'])?>" class="btn btn-primary btn-small">Editar</a>
							<a href="<?php echo site_url("pacientes/delete/" . $paciente['id'])?>" class="btn btn-danger btn-small remove">Remover</a>
						</td>
					</tr>
					<?php }?>
				</tbody>
			</table>
		</div>
	</div>
<?php echo $this->load->view('layouts/pagination',false,true,false); ?>
</div>