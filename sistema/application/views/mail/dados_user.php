<p>Seus dados de acesso estão abaixo:</p>
<table width="100%">
	<tr>
		<td>Nome</td>
		<td><?php echo $nome?></td>
	</tr>
	<tr>
		<td>CPF</td>
		<td><?php echo formatCPF($cpf_cnpj);?></td>
	</tr>
	<tr>
		<td>Email</td>
		<td><?php echo $email?></td>
	</tr>
	<tr>
		<td>Senha</td>
		<td><span style="color: #999"><?php echo $senha ? $senha : "não alterada"?></span></td>
	</tr>
	<tr>
		<td>Telefone</td>
		<td><?php echo mask($telefone, "(##) ####-####")?></td>
	</tr>
	<tr>
		<td>TIPO</td>
		<td><?php echo tipo_user($tipo)?></td>
	</tr>
</table>