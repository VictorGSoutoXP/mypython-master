<div class="row">
	<div class="span12 page-header"><?php echo $usuario['id'] ? "Alterar Cliente" : "Novo Cliente"?></div>
</div>
<ul class="nav nav-tabs">
  <li class="active"><a href="#dados-cliente" data-toggle="tab">Dados do Cliente</a></li>
  <li><a href="#laudo-cliente" data-toggle="tab">Laudo</a></li>
  <li><a href="#exames-cliente" data-toggle="tab">Tipos de Exames</a></li>
  <li><a href="#medicos-sol-cliente" data-toggle="tab">Medicos Solicitantes</a></li>
</ul>

<form class="formCliente" action="<?php echo site_url("usuarios/novo_cliente")?>" method="post" name="<?php echo $usuario['id'] ? "alterarUsuario" : "cadastroUsuario"?>" id="<?php echo $usuario['id'] ? "alterarUsuario" : "cadastroUsuario"?>">
	<input type="hidden" name="_id" value="<?php echo $usuario['id']?>" />
<div class="tab-content">
  <div class="tab-pane active" id="dados-cliente">
      <div class="row">
	   		<div class="span3">
				<label for="nome">Empresa</label> <input type="text" id="nome" class="span3 required" name="nome" value="<?php echo $usuario['nome']?>" />
			</div>
			<div class="span2 fix-width">
				<label for="cpf">CPF/CNPJ</label> <input type="text" id="cpf_cnpj" class="span2 required" name="cpf_cnpj" value="<?php echo $usuario['cpf_cnpj'];?>" />
			</div>
			<div class="span3 fix-width">
				<label for="email">Email</label> <input type="text" id="email" class="span3 required" name="email" value="<?php echo $usuario['email']?>" />
			</div>
			<div class="span2 fix-width">
				<label for="telefone">Telefone</label> <input type="text" id="telefone" class="span2 phone required" name="telefone" value="<?php echo mask($usuario['telefone'], "(##) ####-####")?>" />
			</div>
			<div class="span2 fix-width">
				<label for="limite_horas">Tempo para Laudo (H)</label> <input type="number" id="limite_horas" class="span1 required" name="limite_horas" value="<?php echo $usuario['limite_horas'] ? $usuario['limite_horas'] : 2?>" />
			</div>
		</div>
		
		<div class="row">
			<div class="span3">
				<label for="nome_contato">Nome do Contato</label> <input type="text" id="nome_contato" class="span3" name="nome_contato" value="<?php echo $usuario['nome_contato']?>" />
			</div>
			<div class="span2 fix-width">
				<label for="telefone_contato">Telefone do Contato</label> <input type="text" id="telefone_contato" class="span2 phone" name="telefone_contato" value="<?php echo mask($usuario['telefone_contato'], "(##) ####-#####")?>" />
			</div>
			<div class="span5 fix-width">
				<label for="endereco">Endereço</label> <input type="text" id="endereco" class="span5 required" name="endereco" value="<?php echo $usuario['endereco'];?>" />
			</div>
		</div>

	  <div class="row">
		  <div class="span5">
			  <label class="checkbox"> <input type="checkbox" value="1" <?php echo $usuario['laudos_rapido'] == '1' ? 'checked' : '' ?> id="laudos_rapido" name="laudos_rapido"> Desativar Laudos Rápido
			  </label>
		  </div>
	  </div>

	  <div class="row">
		  <div class="span5">
			  <label class="checkbox"> <input type="checkbox" value="1" <?php echo $usuario['emergencias'] == '1' ? 'checked' : '' ?> id="emergencias" name="emergencias"> Ativar Emergências
			  </label>
		  </div>
	  </div>

	  <div class="well">
			<div class="row">
				<div class="span2">
					<label>Senha</label> <input type="password" class="span2 <?php echo !$usuario['id'] ? "required" : ""?>" name="senha" value="" />
				</div>
				<div class="span2 fix-width">
					<label>Confirmação Senha</label> <input type="password" class="span2 <?php echo !$usuario['id'] ? "required" : ""?>" name="resenha" value="" />
				</div>
			</div>
			<div class="row">
				<div class="span5">
					<label class="checkbox"> <input type="checkbox" value="1" name="send_dados"> Enviar para o email do usuário os novos dados de acesso?
					</label>
				</div>
			</div>
		</div>

	  <div class="row">
		<div class="span5">
			<label class="checkbox">
				<?php
				$checked = $usuario['bloqueio_imagem_laudo'] == '1' ? "checked='checked'" : "";
				?>
				<input type="checkbox" value="1" <?php echo $checked ?> name="bloqueio_imagem_laudo">
				Bloqueio de imagem em laudos.
			</label>
		</div>
	  </div>
		
		<div class="row">
			<div class="span8">
				<label for="mensagem_exames">Mensagem para Exames</label>
				<textarea id="mensagem_exames" name="mensagem_exames" cols="30" rows="4" class="span8"><?php echo $usuario['mensagem_exames']?></textarea>
			</div>
		</div>

		<div class="row">
			<div class="span8">
				<label for="mensagem_exames">Mensagem para Emergências</label>
				<textarea id="mensagem_exames" name="mensagem_emergencia" cols="30" rows="4" class="span8"><?php echo $usuario['mensagem_emergencia']?></textarea>
			</div>
		</div>

		<div class="row">
		  <div class="span8">
			  <label for="depositos">Depósitos Efetuados</label>
			  <textarea id="depositos" name="depositos" cols="30" rows="4" class="span8"><?php echo $usuario['depositos']?></textarea>
		  </div>
	  </div>

	  <div class="row">
		  <div class="span8">
			  <label for="chave_transmissao">Chave de transmissão (Dama Desktop)</label>
			  <textarea id="chave_transmissao" name="chave_transmissao" cols="30" rows="4" class="span8"><?php echo $usuario['chave_transmissao']?></textarea>
		  </div>
	  </div>

	  <div class="row">
		  <div class="span10">
			  <label for="dicom_institution_name">DICOM InstitutionName(Informar o CNPJ)</label>
			  <input type="text" id="dicom_institution_name" class="span4" name="dicom_institution_name" value="<?php echo $usuario['dicom_institution_name'];?>" />
		  </div>
	  </div>

  </div>
  <div id="laudo-cliente" class="tab-pane">
		
		<div class="row">
    		<?php if ($usuario['id'] && $usuario['topo_laudo']){?>
    		<div class="span4">
				<img src="<?php echo site_url()?>uploads/<?php echo config_item('upload_folder_base')?>/assinaturas/<?php echo $usuario['topo_laudo']?>" alt="" style="max-height: 50px" />
			</div>
    		<?php }?>
    		<div class="<?php echo !$usuario['id'] || !$usuario['topo_laudo'] ? "span7" : "span5 fix-width"?>">
				<label for="arquivo_exame"><?php echo $usuario['id'] ? "Altere" : "Selecione"?> o arquivo do Topo do Laudo <small>(tamanho de 750px/100px)</small></label>
				<div class="fileupload fileupload-new" data-provides="fileupload">
					<span class="btn btn-file"> <span class="fileupload-new"><?php echo $usuario['id'] ? "Altere" : "Selecione"?> a Imagem</span> <span class="fileupload-exists">Alterar</span> <input type="file" id="topo_laudo" name="topo_laudo" class="<?php echo !$usuario['id'] ? "required" : ""?>" />
					</span> <span class="fileupload-preview"></span> <a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none">×</a>
				</div>
			</div>
		</div>
		
		<div class="row">
    		<?php if ($usuario['id'] && $usuario['rodape_laudo']){?>
    		<div class="span4">
				<img src="<?php echo site_url()?>uploads/<?php echo config_item('upload_folder_base')?>/assinaturas/<?php echo $usuario['rodape_laudo']?>" alt="" style="max-height: 50px" />
			</div>
    		<?php }?>
    		<div class="<?php echo !$usuario['id'] || !$usuario['rodape_laudo'] ? "span7" : "span5 fix-width"?>">
				<label for="arquivo_exame"><?php echo $usuario['id'] ? "Altere" : "Selecione"?> o arquivo do Rodapé do Laudo <small>(tamanho de 750px/100px)</small></label>
				<div class="fileupload fileupload-new" data-provides="fileupload">
					<span class="btn btn-file"> <span class="fileupload-new"><?php echo $usuario['id'] ? "Altere" : "Selecione"?> a Imagem</span> <span class="fileupload-exists">Alterar</span> <input type="file" id="rodape_laudo" name="rodape_laudo" />
					</span> <span class="fileupload-preview"></span> <a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none">×</a>
				</div>
			</div>
		</div>
		<div class="row">
		    
			<div class="span3">
				<label for="tipo_laudo">Tipo de Laudo</label> 
    			<select name="tipo_laudo" id="tipo_laudo" class="span4 required">
    				<option value="">Selecione o Tipo de Laudo</option>
					<?php foreach ($tipos_laudo as  $tipo){?>
						<option value="<?php echo $tipo['id']?>" <?php echo $usuario['tipo_laudo'] == $tipo['id'] ? "selected" : "" ?>><?php echo $tipo['nome']?></option>
					<?php }?>
				</select>
			</div>
		</div>
  </div>
  
  <div class="tab-pane" id="exames-cliente">
    	<h4>Lista de Exames Realizados</h4>
    	<?php foreach ($tipos_exames as $tipo) {
    		$exame = $usuario['exames'][$tipo['id']];
			$pagina_pdf = $exame['pagina_pdf'];
    		$sub_exames = $exame['sub_exames'];
    		if (!is_array($sub_exames) && count($sub_exames) > 1) {
    			$sub_exames = array(array());
    		}
    		?>
			
				<div class="exame-row deactive">
				
		
    	    <div class="mask"></div>
			
        	<div class="row header">
        		<div class="span1 text-center">Ativar</div>
        		<div class="span2">Exame Principal</div>
        		<div class="span2">Médico responsável</div>
        		<div class="span1">Pág.PDF</div>
        		<div class="span5 sub-tipos-container">
            		<div class="row">
            		    <div class="span2">Tipos de Exame</div>
            		    <div class="span1">Preço</div>
            		    <div class="span2">Preço Médico</div>
            		</div>
        		</div>
        	</div>
        	
        	<div class="row">

        		<div class="span1 text-center">
					<input class="active-deactive" type="checkbox" name="exames_clientes[<?php echo $tipo['id']?>][active]" value="1" <?php echo $exame ? "checked" : ""?> />
				</div>

				<div class="span2">
        		    <select class="span2" disabled>
    			        <option value=""><?php echo $tipo['tipo'];?></option>
    				</select>
        		</div>

				<div class="span2">
        		    <select name="exames_clientes[<?php echo $tipo['id']?>][medico_responsavel]" class="span2" required>
    			        <option value=""></option>
    					<?php foreach ($medicos as  $medico){?>
    						<option value="<?php echo $medico['id']?>" <?php echo $exame['medico_responsavel'] == $medico['id'] ? "selected" : "" ?>><?php echo $medico['nome']?></option>
    					<?php }?>
    				</select>
        		</div>
				
        		<div class="span1">
					<input class="span1" type="number" name="exames_clientes[<?php echo $tipo['id']?>][pagina_pdf]" value="<?php echo $pagina_pdf; ?>" />
				</div>

        		<div class="span5 sub-tipos-container">
        		<?php $i = 0;foreach ($sub_exames as $sub_exame) { ?>
        		    <div class="row">
        		        <div class="span2">
        		            <input type="text" class="span2" name="exames_clientes[<?php echo $tipo['id']?>][subtipo_nome][]" value="<?php echo $sub_exame['nome']?>" required <?php echo $sub_exame ? "readonly" : ""?>/>
        		        </div>
        		        <div class="span1">
        		            <input type="text" class="span1 preco" name="exames_clientes[<?php echo $tipo['id']?>][subtipo_preco][]" value="<?php echo $sub_exame['preco']?>" required/>
        		        </div>
        		        <div class="span1">
        		            <input type="text" class="span1 preco" name="exames_clientes[<?php echo $tipo['id']?>][subtipo_preco_medico][]" value="<?php echo $sub_exame['preco_medico']?>" required/>
        		        </div>
        		        <?php if($sub_exame && $i > 0){?>
        		        <div class="span1">
				            <button class="btn btn-danger remove-subtipo-exame" type="button">Remover</button>
				        </div>
        		        <?php }?>
        		    </div>
        		<?php  $i++;}?>
        		    <button class="btn btn-success add-subtipo-exame" data-id="<?php echo $tipo['id']?>" type="button">Adicionar</button>
        		</div>
				
        	</div>
    	</div>
    	<?php }?>
  </div>
  <div class="tab-pane" id="medicos-sol-cliente">
    	<?php if($usuario['id']){?>
    	<h4>Lista de Médicos Cadastrados</h4>
		<table class="table">
			<thead>
				<tr>
					<th data-sorter="false">Nome</th>
					<th>CRM</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php 
				if(count($medicos_sol)){
    				foreach ($medicos_sol as $medico) { ?>
    				<tr id="row-sol-<?php echo $medico['id'];?>">
						<td><?php echo $medico['nome']?></td>
						<td><?php echo $medico['crm']?></td>
						<td class="col-center"><a href="<?php echo site_url('medicos/novo_solicitante/' . $usuario['id'] . '/' . $medico['id'])?>" class="btn btn-primary btn-small novoSolicitante">Editar</a> <a href="<?php echo site_url('medicos/remove_solicitante/' . $medico['id'])?>" class="btn btn-danger btn-small remove">Remover</a></td>
					</tr>
    				<?php }
				}else{?>
				<tr>
					<td colspan="3"><center>Nenhum médico cadastrado para esse cliente.</center></td>
				</tr>
				<?php }?>
			</tbody>
		</table>
		<a href="<?php echo site_url('medicos/novo_solicitante/' . $usuario['id'])?>" class="btn novoSolicitante">Adicionar médico</a>
    	<?php }?>
  </div>
</div>
<br /><br />
<div class="row">
	<div class="span3">
	    <button class="btn btn-primary"><?php echo $usuario['id'] ? "Salvar Alterações" : "Cadastrar"?></button>
	</div>
</div>
	
</form>
<br /><br />
<div class="row page-header">
	<div class="span12">Clientes Cadastrados</div>
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
						<th>Empresa</th>
						<th>Email</th>
						<th data-sorter="false">Telefone</th>
						<th data-sorter="false"></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($usuarios as $usuario) {?>
					<tr class="<?php echo $usuario['status'] == 0 ? "warning" : ""?> ">
						<td class="cpf"><?php echo strlen($usuario['cpf_cnpj']) == 11 ? formatCPF($usuario['cpf_cnpj']) : formatCNPJ($usuario['cpf_cnpj']);?></td>
						<td><?php echo $usuario['nome']?></td>
						<td><?php echo $usuario['email']?></td>
						<td><?php echo mask($usuario['telefone'], "(##) ####-####")?></td>
						<td class="col-center"><a href="<?php echo site_url("usuarios/novo_cliente/" . $usuario['id'])?>" class="btn btn-primary btn-small">Editar</a> 
						<a href="<?php echo site_url("usuarios/manage_cliente/desativar/" . $usuario['id'])?>" title="Desativar Cliente" class="btn btn-small btn-danger desativar <?php echo $usuario['status'] == 0 ? "hide" : ""?>" data-message="Deseja desativar esse Cliente?"><i class="icon-remove"></i> Desativar</a> 
						<a href="<?php echo site_url("usuarios/manage_cliente/ativar/" . $usuario['id'])?>" title="Reativar Cliente" class="btn btn-success btn-small ativar <?php echo $usuario['status'] == 1 ? "hide" : ""?>" data-message="Deseja Reativar esse cliente?"><i
								class="icon-ok"></i> Ativar</a></td>
					</tr>
					<?php }?>
				</tbody>
			</table>
		</div>
	</div>
<?php echo $this->load->view('layouts/pagination',false,true,false); ?>
</div>

<div id="modalMedico" class="modal fade"></div>
<script id="row-sub-template" type="text/html">
    <div class="row">
        <div class="span2">
            <input type="text" class="span2" name="exames_clientes[#ID#][subtipo_nome][]" required/>
        </div>
        <div class="span1">
            <input type="text" class="span1 preco" name="exames_clientes[#ID#][subtipo_preco][]" required/>
        </div>
        <div class="span1">
            <input type="text" class="span1 preco" name="exames_clientes[#ID#][subtipo_preco_medico][]" required/>
        </div>
        <div class="span1">
            <button class="btn btn-danger remove-subtipo-exame" type="button">Remover</button>
        </div>
    </div>
</script>
<script id="row-medico-solicitante" type="text/html">
<tr id="row-sol-#MEDICO_ID#">
		<td>#NOME#</td>
		<td>#CRM#</td>
		<td class="col-center"><a href="<?php echo site_url('medicos/novo_solicitante/#CLIENTE_ID#/#MEDICO_ID#')?>" class="btn btn-primary btn-small novoSolicitante">Editar</a> <a href="<?php echo site_url('medicos/remove_solicitante/#MEDICO_ID#')?>" class="btn btn-danger btn-small remove">Remover</a></td>
	</tr>
</script>