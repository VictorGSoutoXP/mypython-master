<div class="row">
	<div class="span12 page-header"><?php echo $usuario['id'] ? "Alterar Administrador/Auditor" : "Novo Administrador/Auditor"?></div>
</div>
<form action="<?php echo site_url("usuarios/novo")?>" method="post" name="<?php echo $usuario['id'] ? "alterarUsuario" : "cadastroUsuario"?>" id="<?php echo $usuario['id'] ? "alterarUsuario" : "cadastroUsuario"?>">
	<div class="row">
		<input type="hidden" name="_id" value="<?php echo $usuario['id']?>" />
		<div class="span2">
			<label for="cpf">CPF/CNPJ</label> <input type="text" id="cpf_cnpj" class="span2 required" name="cpf_cnpj" value="<?php echo $usuario['cpf_cnpj'];?>" />
		</div>
		<div class="span4 fix-width">
			<label for="nome">Nome Completo</label> <input type="text" id="nome" class="span4 required" name="nome" value="<?php echo $usuario['nome']?>" />
		</div>
		<div class="span2 fix-width">
			<label for="email">Email</label> <input type="text" id="email" class="span2 required" name="email" value="<?php echo $usuario['email']?>" />
		</div>
		<div class="span2 fix-width">
			<label for="telefone">Telefone</label> <input type="text" id="telefone" class="span2 phone required" name="telefone" value="<?php echo mask($usuario['telefone'], "(##) ####-####")?>" />
		</div>
	</div>
	<div class="row">
		<div class="span2">
			<label>Senha</label> <input type="password" class="span2 <?php echo !$usuario['id'] ? "required" : ""?>" name="senha" value="" />
		</div>
		<div class="span2 fix-width">
			<label>Confirmação Senha</label> <input type="password" class="span2 <?php echo !$usuario['id'] ? "required" : ""?>" name="resenha" value="" />
		</div>
		<div class="span2 fix-width">
			<label>&nbsp;</label>
			<button class="btn btn-primary"><?php echo $usuario['id'] ? "Salvar Alterações" : "Cadastrar"?></button>
		</div>
	</div>
	
	<div class="row">
		<div class="span5">
			<label class="checkbox">
			  <input type="checkbox" value="1" name="send_dados">
			  Enviar para o email do usuário os novos dados de acesso?
			</label>
		</div>
	</div>

	<div class="row">
		<div class="span5">
			<label class="checkbox">
				<input type="checkbox" <?php if ($usuario['tipo'] == 'auditor') echo ' checked="checked"' ?> value="1" name="auditor">
				Usuário é uma AUDITOR
			</label>
		</div>
	</div>

	<div class="page-header"></div>

</form>

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
						<th data-sorter="false">CPF/CNPJ</th>
						<th>Nome Usuário</th>
						<th>Email</th>
						<th data-sorter="false">Telefone</th>
						<th>Tipo</th>
						<th data-sorter="false"></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($usuarios as $usuario) { ?>
					<tr>
						<td class="cpf"><?php echo strlen($usuario['cpf_cnpj']) == 11 ? formatCPF($usuario['cpf_cnpj']) : formatCNPJ($usuario['cpf_cnpj']);?></td>
						<td><?php echo $usuario['nome']?></td>
						<td><?php echo $usuario['email']?></td>
						<td><?php echo mask($usuario['telefone'], "(##) ####-####")?></td>
						<td><?php echo tipo_user($usuario['tipo']);?></td>
						<td class="col-center"><a href="<?php echo site_url("usuarios/novo/" . $usuario['id'])?>" class="btn btn-primary btn-small">Editar</a> <a href="<?php echo site_url("usuarios/delete/" . $usuario['id'])?>" class="btn btn-danger btn-small remove">Remover</a></td>
					</tr>
					<?php }?>
				</tbody>
			</table>
		</div>
	</div>
<?php echo $this->load->view('layouts/pagination',false,true,false); ?>
</div>