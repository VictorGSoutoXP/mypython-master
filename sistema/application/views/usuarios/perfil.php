<div class="row">
	<div class="span12 page-header">Meu Perfil</div>
</div>
<form action="<?php echo site_url("usuarios/perfil")?>" method="post" name="meuPerfil" id="meuPerfil">
	<input type="hidden" name="_id" value="<?php echo $usuario['id']?>" />
	<div class="row">
		<div class="span2">
			<label for="cpf">CPF</label> <input type="text" id="cpf" class="span2 cpf required" name="cpf" value="<?php echo formatCPF($usuario['cpf_cnpj']);?>" />
		</div>
		<div class="span4 fix-width">
			<label for="nome">Nome Completo</label> <input type="text" id="nome" class="span3 required" name="nome" value="<?php echo $usuario['nome']?>" />
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
			<label>Senha</label> <input type="password" class="span2" name="senha" value="" />
		</div>
		<div class="span2 fix-width">
			<label>Confirmação Senha</label> <input type="password" class="span2" name="resenha" value="" />
		</div>
		<div class="span2 fix-width">
			<label>&nbsp;</label>
			<button class="btn btn-primary">Salvar Alterações</button>
		</div>
	</div>
</form>