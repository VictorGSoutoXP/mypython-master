<div class="row">
	<div class="span12 page-header">Perfil</div>
</div>
<form action="<?php echo site_url("usuarios/perfil_medico")?>" method="post" name="cadastroUsuario" id="cadastroUsuario">
	<input type="hidden" name="_id" value="<?php echo $usuario['id']?>" />

	<div class="well well-small">
		<div class="row">
			<div class="span3">
				<label for="laudo_padrao">Modelo de Laudo Padrão</label>
				<select name="laudo_padrao" id="laudo_padrao" 
					class="select-box-auto-width span3 required">
					<option value="0"></option>
					<?php foreach ($modelos_laudo as $modelo){?>
						<?php $selected = $usuario['laudo_padrao'] == $modelo['id'] ? ' selected' : ''; ?>
						<option value="<?php echo $modelo['id']?>" <?php echo $selected; ?>>
							<?php echo $modelo['title']?>
						</option>
					<?php }?>			
				</select>
			</div>
		</div>
	</div>

	<div class="well well-small">
		<div class="row">
    		<div class="span7">
                <label for="arquivo_pfx">Arquivo PFX</label>
                <div class="fileupload fileupload-new" data-provides="fileupload">
					<input type="text" readonly id="fileupload-preview" class="span3" name="fileupload-preview" value="<?php echo $usuario['nome_pfx']?>" /><br />
                  	<!-- <span id="fileupload-preview" style="color: red; display:block;font-weight: bold;" class="fileupload-preview"></span> -->
                  	<span class="btn btn-file">
                      	<span class="fileupload-new">Selecione</span>
                       	<span class="fileupload-exists">Selecione</span>
                      	<input type="file" id="arquivo_pfx" name="arquivo_pfx" accept=".pfx" />	<!-- class="<?php echo !$usuario['id'] ? "required" : ""?>" /> -->
                  	</span>
                  	<a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none">×</a>
           		</div>
    		</div>
		</div>
		
		<div class="row">
			<div class="span3">
				<label for="nome">Senha do PFX</label> 
				<input type="password" id="senha_pfx" class="span3" name="senha_pfx" value="<?php echo $usuario['senha_pfx']?>" />
			</div>
		</div>
		
		<div class="row">
			<div class="span3">
				<label for="nome">Validade do PFX</label> 
				<input type="text" id="validade_pfx" class="span2 data" name="validade_pfx" value="<?php echo (!$usuario['id'] || !$usuario['validade_pfx']) ? "" : date('d/m/Y', strtotime($usuario['validade_pfx']))?>" />
			</div>
		</div>

		<div class="row">
			<div class="span3">
				<label for="nome">Senha Mestre*</label> 
				<input type="password" id="senha_mestre" class="span3" name="senha_mestre" />
			</div>
		</div>

	</div>

	<div class="row">
		<div class="span3">
			<button class="btn btn-primary">Salvar Alterações</button>
		</div>
	</div>

</form>

<script type="text/javascript">

    function loadFileSelected() {
        if (!window.File || !window.FileReader || !window.FileList || !window.Blob) {
          console.log('The File APIs are not fully supported in this browser.');
          return;
        }

        input = document.getElementById('arquivo_pfx');

        if (!input) {
          console.log("Um, couldn't find the fileinput element.");
          return;
        }
        else if (!input.files) {
          console.log("This browser doesn't seem to support the `files` property of file inputs.");
          return;
        }
        else if (!input.files[0]) {
          console.log("Please select a file before clicking 'Load'");
          return;
        }
        else {

	    	  file = input.files[0];

     		  $('#fileupload-preview').val(file.name);

        }
    }

    $(document).ready(function(){
	
        $("#arquivo_pfx").change(function() {
            loadFileSelected();
        });

    });

</script>

