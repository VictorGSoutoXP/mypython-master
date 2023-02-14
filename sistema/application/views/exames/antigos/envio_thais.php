<?php echo $this->load->view('layouts/menu',false,true,false); ?>


<div class="row">
	<form action="<?php echo site_url("exames/envio");?>" method="post" name="enviaExame" id="enviaExame" enctype="multipart/form-data">
		
		
	
	    <div class="span12">
		    <fieldset>
		    	<legend>Selecione o Exame</legend>
		    	<div class="row">
			    	<div class="span4">						
						<select name="exame[exame]" id="exame[exame]" class="select-box-auto-width span3 required" data-placeholder="Selecione o Exame">
						    <option value=""></option>
							<?php foreach ($exames as  $exame){ ?>
								<option value="<?php echo $exame['value']?>"><?php echo $exame['title']?></option>
							<?php }?>
						</select>
					</div>
		    	</div>
		    </fieldset>
		    
		    <div class="form-fields-container" style="display: none;">
			    <fieldset>
			    	<legend>Dados do Paciente</legend>
			    	<div id="form-exame-distinct-container">
			    	</div>
			    </fieldset>
			    
			    <fieldset>
			    	<legend>Dados do Exame</legend>
			    	<div class="row">
				    	<div class="span3">
							<label for="exame[medico_solicitante]">Médico Solicitante</label>
							<select name="exame[medico_solicitante]" id="exame[medico_solicitante]" class="span3 required" data-placeholder="Selecione o Médico">
							    <option value=""></option>
								<?php foreach ($medicos as  $medico){?>
									<option value="<?php echo $medico['id']?>"><?php echo $medico['nome']?></option>
								<?php }?>
							</select>
						</div>
						<div class="span2">
							<label for="exame[data_exame]">Data do exame</label>
							<input type="text" id="exame[data_exame]" class="span2 data required" name="exame[data_exame]" value="<?php echo date('d/m/Y')?>" />
						</div>
						<div class="span3" id="motivo-exame-container">
							<label for="exame[motivo]">Motivo Exame</label>
							<select name="exame[motivo]" id="exame[motivo]" class="span3" data-placeholder="Selecione o Motivo">
							    <option value=""></option>
								<?php foreach ($motivos as  $motivo){?>
									<option value="<?php echo $motivo['id']?>"><?php echo $motivo['nome']?></option>
								<?php }?>
							</select>
						</div>
			    	</div>
			    	<br />
			    	<div class="row">
			    		<div class="span4">
			                <label for="exame[observacoes]">Observações</label>
			                <textarea name="exame[observacoes]" id="exame[observacoes]" cols="30" rows="4" class="span4"></textarea>
		    	            <label class="checkbox" for="exame[emergencia]">
		                      <input type="checkbox" id="exame[emergencia]" name="exame[emergencia]" value="1"> Emergência?
		                    </label>
			    		</div>
			    		<div class="span7">
			                <label for="arquivo_exame">Selecione o arquivo do Exame:</label>
			                <div class="fileupload fileupload-new" data-provides="fileupload">
		                        <span class="btn btn-file">
		                            <span class="fileupload-new">Selecione o arquivo</span>
		                            <span class="fileupload-exists">Alterar</span>
		                            <input type="file" id="arquivo_exame" name="arquivo_exame" class="required" />
		                        </span>
		                        <span class="fileupload-preview"></span>
		                        <a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none">×</a>
		                    </div>
			    		</div>
			    	</div>
			    </fieldset>
			    
		        <div class="form-actions">
					<button type="reset" class="btn btn-info">Cancelar</button>
					<button type="submit" class="btn btn-danger pull-right">Enviar</button>
				</div>
		    </div>
		    
	    </div>
	</form>
</div>

<script type="text/javascript">

    function parseXml(xml) {
        parser = new DOMParser();
        xmlDoc = parser.parseFromString(xml,"text/xml");

        console.log(xmlDoc);

        var exame    = xmlDoc.getElementsByTagName("Exame")[0];
        var paciente = xmlDoc.getElementsByTagName("Paciente")[0];
        if (!paciente || !exame) return;

        var nome = paciente.getElementsByTagName("Nome")[0].childNodes[0].nodeValue;
        var sexo = paciente.getElementsByTagName("Sexo")[0].childNodes[0].nodeValue;
        var nascimento = paciente.getElementsByTagName("DataNascimento")[0].childNodes[0].nodeValue;

        var peso = exame.getElementsByTagName("Peso")[0].childNodes[0].nodeValue;
        var altura = exame.getElementsByTagName("Altura")[0].childNodes[0].nodeValue;
        var imc = exame.getElementsByTagName("IMC")[0].childNodes[0].nodeValue.replace(/\D/g, '');

        $('#paciente\\[nome\\]').attr('value', nome);
        $("#paciente\\[sexo\\]").attr('value', sexo);
        $("#paciente\\[nascimento\\]").attr('value', nascimento);
        $("#paciente\\[peso\\]").attr('value', peso);
        $("#paciente\\[altura\\]").attr('value', altura / 100);
        $("#paciente\\[imc\\]").attr('value', imc / 10);

    }

    function loadFileSelected() {
        if (!window.File || !window.FileReader || !window.FileList || !window.Blob) {
          console.log('The File APIs are not fully supported in this browser.');
          return;
        }

        input = document.getElementById('arquivo_exame');
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
          fr = new FileReader();
          fr.onload = function(){
            parseXml(fr.result);
          }
          fr.readAsText(file);
          //fr.readAsDataURL(file);
        }
    }

    $(document).ready(function(){
        $("#arquivo_exame").change(function() {
            loadFileSelected();
        });
    });


</script>

