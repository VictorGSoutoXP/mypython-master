<div class="row">
	<div class="span12 page-header"><?php echo $usuario['id'] ? "Alterar Médico" : "Novo Médico"?></div>
</div>
<form action="<?php echo site_url("usuarios/novo_medico")?>" method="post" name="<?php echo $usuario['id'] ? "alterarUsuario" : "cadastroUsuario"?>" id="<?php echo $usuario['id'] ? "alterarUsuario" : "cadastroUsuario"?>">
	<input type="hidden" name="_id" value="<?php echo $usuario['id']?>" />
	<div class="well well-small">
		<div class="row">
			<div class="span4">
				<label for="nome">Nome Completo</label> <input type="text" id="nome" class="span4 required" name="nome" value="<?php echo $usuario['nome']?>" />
			</div>
			<div class="span3 fix-width">
				<label for="cpf">CPF/CNPJ</label> <input type="text" id="cpf_cnpj" class="span3 required" name="cpf_cnpj" value="<?php echo $usuario['cpf_cnpj'];?>" />
			</div>
			<div class="span3 fix-width">
				<label for="email">Email</label> <input type="text" id="email" class="span3 required" name="email" value="<?php echo $usuario['email']?>" />
			</div>
			<div class="span2 fix-width">
				<label for="telefone">Telefone</label> <input type="text" id="telefone" class="span2 phone required" name="telefone" value="<?php echo mask($usuario['telefone'], "(##) ####-####")?>" />
			</div>
		</div>
		<div class="row">
			<div class="span3">
				<label for="nome">Especialidade</label> <input type="text" id="especialidade" class="span3 required" name="especialidade" value="<?php echo $usuario['especialidade']?>" />
			</div>
			<div class="span2 fix-width">
				<label for="cpf">Registro CRM</label> <input type="text" id="crm" class="span2 required" name="crm" value="<?php echo $usuario['crm'];?>" />
			</div>
			<div class="span2 fix-width">
				<label for="cpf">Tipo(s) de Exame(s)</label> <input type="text" id="tipo_exames" class="span2 required" name="tipo_exames" value="<?php echo $usuario['tipo_exames'];?>" />
			</div>

		</div>
		<div class="row">
			<?php if ($usuario['id']){?>
			<div class="span1">
				<img src="<?php echo site_url()?>uploads/<?php echo config_item('upload_folder_base')?>/assinaturas/<?php echo $usuario['assinatura']?>" alt="" width="65" />
			</div>
			<?php }?>
    		<div class="<?php echo !$usuario['id'] ? "span7" : "span5"?>">
                <label for="arquivo_exame"><?php echo $usuario['id'] ? "Altere" : "Selecione"?> o arquivo da assinatura (Completa com especialidade e CRM) <small>(tamanho de 250px/250px)</small></label>
                <div class="fileupload fileupload-new" data-provides="fileupload">
                  	<span class="btn btn-file">
                      	<span class="fileupload-new"><?php echo $usuario['id'] ? "Altere" : "Selecione"?> a Imagem</span>
                       	<span class="fileupload-exists">Alterar</span>
                      	<input type="file" id="assinatura" name="assinatura" class="<?php echo !$usuario['id'] ? "required" : ""?>" />
                  	</span>
                  	<span class="fileupload-preview"></span>
                  	<a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none">×</a>
           		</div>
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
					<?php
						$checked = $usuario['bloquear_simultaneo'] == '1' ? "checked='checked'" : "";
					?>
					<input type="checkbox" value="1" <?php echo $checked ?> name="bloquear_simultaneo">
					Bloquear laudos simultâneos.
				</label>
			</div>
		</div>

		<div class="row">
			<div class="span5">
				<label class="checkbox">
					<?php
					$checked = $usuario['despacho'] == '1' ? "checked='checked'" : "";
					?>
					<input type="checkbox" value="1" <?php echo $checked ?> name="despacho">
					Despacho automático de novo exame.
				</label>
			</div>
		</div>

		<div class="row">
			<div class="span5">
				<label class="checkbox">
					<?php
					$checked = $usuario['assina_digital'] == '1' ? "checked='checked'" : "";
					?>
					<input type="checkbox" value="1" <?php echo $checked ?> name="assina_digital">
					Assina digitalmente.
				</label>
			</div>
		</div>

		<div class="row">
			<div class="span8">
				<label for="chave_transmissao">Chave de transmissão</label>
				<textarea id="chave_transmissao" name="chave_transmissao" cols="30" rows="4" class="span8"><?php echo $usuario['chave_transmissao']?></textarea>
			</div>
		</div>

	</div>
</form>

<div class="row">
<div class="span12 page-header">Médicos Cadastrados</div>
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
						<th data-sorter="false">CPF/CNPJ</th>
						<th>Nome Médico</th>
						<th>Email</th>
						<th data-sorter="false">Telefone</th>
						<th>CRM</th>
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
						<td><?php echo $usuario['crm'];?></td>
						<td class="col-center"><a href="<?php echo site_url("usuarios/novo_medico/" . $usuario['id'])?>" class="btn btn-primary btn-small">Editar</a> <a href="<?php echo site_url("usuarios/delete/" . $usuario['id'])?>" class="btn btn-danger btn-small remove">Remover</a></td>
					</tr>
					<?php }?>
				</tbody>
			</table>
		</div>
	</div>
<?php echo $this->load->view('layouts/pagination',false,true,false); ?>
</div>