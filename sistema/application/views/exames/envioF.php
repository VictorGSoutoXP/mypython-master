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
				<div id="webix-search" style=""></div>
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

					<div id="form-acuidade-container" style="display:none;">

						<div class="row">

							<div class="span3">
								<label for="paciente[acuidade_longe_od]">Acuidade Visual LONGE - OD</label>
								<select name="paciente[acuidade_longe_od]">
									<option value=""></option>
									<option value="20/10 ou 2">20/10 ou 2</option>
									<option value="20/13 ou 1,5">20/13 ou 1,5</option>
									<option value="20/15 ou 1,3">20/15 ou 1,3</option>
									<option value="20/20 ou 1">20/20 ou 1</option>
									<option value="20/25 ou 0,80">20/25 ou 0,80</option>
									<option value="20/30 ou 0,70">20/30 ou 0,70</option>
									<option value="20/35 ou 0,60">20/35 ou 0,60</option>
									<option value="20/40 ou 0,50">20/40 ou 0,50</option>
									<option value="20/50 ou 0,40">20/50 ou 0,40</option>
									<option value="20/60 ou 0,35">20/60 ou 0,35</option>
									<option value="20/70 ou 0,30">20/70 ou 0,30</option>
									<option value="20/80 ou 0,25">20/80 ou 0,25</option>
									<option value="20/100 ou 0,20">20/100 ou 0,20</option>
									<option value="20/200 ou 0,10">20/200 ou 0,10</option>
								</select>
							</div>

							<div class="span3">
								<label for="paciente[acuidade_longe_oe]">Acuidade Visual LONGE - OE</label>
								<select name="paciente[acuidade_longe_oe]">
									<option value=""></option>
									<option value="20/10 ou 2">20/10 ou 2</option>
									<option value="20/13 ou 1,5">20/13 ou 1,5</option>
									<option value="20/15 ou 1,3">20/15 ou 1,3</option>
									<option value="20/20 ou 1">20/20 ou 1</option>
									<option value="20/25 ou 0,80">20/25 ou 0,80</option>
									<option value="20/30 ou 0,70">20/30 ou 0,70</option>
									<option value="20/35 ou 0,60">20/35 ou 0,60</option>
									<option value="20/40 ou 0,50">20/40 ou 0,50</option>
									<option value="20/50 ou 0,40">20/50 ou 0,40</option>
									<option value="20/60 ou 0,35">20/60 ou 0,35</option>
									<option value="20/70 ou 0,30">20/70 ou 0,30</option>
									<option value="20/80 ou 0,25">20/80 ou 0,25</option>
									<option value="20/100 ou 0,20">20/100 ou 0,20</option>
									<option value="20/200 ou 0,10">20/200 ou 0,10</option>
								</select>
							</div>

							<div class="span3">
								<label for="paciente[acuidade_perto_od]">Acuidade Visual PERTO - OD</label>
								<select name="paciente[acuidade_perto_od]">
									<option value=""></option>
									<option value="J1">J1</option>
									<option value="J2">J2</option>
									<option value="J3">J3</option>
									<option value="J4">J4</option>
									<option value="J5">J5</option>
									<option value="J6">J6</option>
									<option value="J7">J7</option>
									<option value="J8">J8</option>
									<option value="J9">J9</option>
									<option value="J10">J10</option>
									<option value="J11">J11</option>
									<option value="J12">J12</option>
									<option value="J13">J13</option>
									<option value="J14">J14</option>
								</select>
							</div>


							<div class="span3">
								<label for="paciente[acuidade_perto_oe]">Acuidade Visual PERTO - OE</label>
								<select name="paciente[acuidade_perto_oe]">
									<option value=""></option>
									<option value="J1">J1</option>
									<option value="J2">J2</option>
									<option value="J3">J3</option>
									<option value="J4">J4</option>
									<option value="J5">J5</option>
									<option value="J6">J6</option>
									<option value="J7">J7</option>
									<option value="J8">J8</option>
									<option value="J9">J9</option>
									<option value="J10">J10</option>
									<option value="J11">J11</option>
									<option value="J12">J12</option>
									<option value="J13">J13</option>
									<option value="J14">J14</option>
								</select>
							</div>

						</div>

						<div class="row">


							<div class="span3">
								<strong>Fez uso de lente corretiva?</strong><br />
								<input type="radio" name="paciente[lente_corretiva]" class="radio" value="SIM"> SIM
								<input type="radio" name="paciente[lente_corretiva]" class="radio" value="NAO"> NÃO
							</div>

							<div class="span3">
								<strong>Senso cromático</strong><br />
								<input type="radio" name="paciente[senso_cromatico]" class="radio" value="OK"> OK
								<input type="radio" name="paciente[senso_cromatico]" class="radio" value="NAO_OK"> NÃO OK
							</div>

							<div class="span3">
								<strong>Recuperação da Visão Noturna</strong><br />
								<input type="radio" name="paciente[visao_noturna]" class="radio" value="OK"> OK
								<input type="radio" name="paciente[visao_noturna]" class="radio" value="NAO_OK"> NÃO OK
							</div>

							<div class="span3">
								<strong>Recuperação da Visão Ofuscada</strong><br />
								<input type="radio" name="paciente[visao_ofuscada]" class="radio" value="OK"> OK
								<input type="radio" name="paciente[visao_ofuscada]" class="radio" value="NAO_OK"> NÃO OK
							</div>

						</div>


						<div class="row">

							<div class="span3">
								<strong>Profundidade</strong><br />
								<input type="radio" name="paciente[profundidade]" class="radio" value="OK"> OK
								<input type="radio" name="paciente[profundidade]" class="radio" value="NAO_OK"> NÃO OK
							</div>

                            <div class="span3">
                                <button type="button" onclick="desmarcarTodos()" class="btn btn-primary">Desmarcar Todos</button>
                            </div>

						</div>

					</div>

					<br />
			    	<div class="row">
			    		<div class="span4">
			                <label for="exame[observacoes]">Observações</label>
			                <textarea name="exame[observacoes]" id="exame[observacoes]" cols="30" rows="4" class="span4"></textarea>

							<div id="box_emergencia">
								<label class="checkbox" for="exame[emergencia]">
								  <input type="checkbox" id="exame[emergencia]" name="exame[emergencia]" value="1"> Emergência?
								</label>
							</div>

			    		</div>
			    		<div class="span7">
			                <label for="arquivo_exame">Selecione o arquivo do Exame</label>
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
					<button type="reset" class="btn">Cancelar</button>
					<button type="submit" class="btn btn-primary pull-right">Enviar</button>
				</div>
		    </div>
		    
	    </div>
	</form>
</div>

<script type="text/javascript">

    function desmarcarTodos() {
        $('input[type="radio"]').each(function() {
            $(this).prop('checked', false);
        });
    }

    function parseXml(xml) {
        parser = new DOMParser();
        xmlDoc = parser.parseFromString(xml,"text/xml");

        //console.log(xmlDoc);

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

		var form1 = {
			view:"form", width:250, height: 60, scroll:false, borderless: true,
			elements:[
				{ view:"button", label:"Buscar Paciente", autowidth: true,
					on:{
						'onItemClick': function(id){
                            ajax.get('/sistema/exames/pacientes', '', function(data){
                                $$('pacientes').parse(data);
                                $$('win1').show();
                            });
						}
					}
				}
			]
		};

		var table = {
			view:"datatable",
			id: "pacientes",
			bordless: true,
			columns:[
				{ id:"nome",	header:["Nome", {content:"textFilter"}], width:250,	sort:"string"},
				{ id:"empresa",	header:["Empresa", {content:"textFilter"}], width:200,	sort:"string"},
				{ id:"rg",   	header:["RG", {content:"textFilter"}], width:150, sort:"string"},
				{ id:"cpf",	    header:["CPF", {content:"textFilter"}], width:150, sort:"string"},
				{ id:"data",    header:["Nascimento", {content:"textFilter"}], width:110, sort:"string"},
                //{ id:"medico",  header:["Médico Solicitante", {content:"textFilter"}], width:250, sort:"string"},
                //{ id:"motivo",  header:["Motivo do Exame", {content:"textFilter"}], width:170, sort:"string"},
                { id:"exame",   header:["Exame", {content:"textFilter"}], width:160, sort:"string"}
            ],
			//autoheight:true,
			autowidth:true,
			select: "row"
		}

		var ui = {
			view:"window",
			modal: true,
			move: true,
			id:"win1",
			position:"center",
			head:{
				view:"toolbar", cols:[
					{ view:"label", label: "Buscando Paciente" },
					{ view:"button", label: 'Fechar', width: 100, click:"$$('win1').hide();", icon:"times", type: "iconButton" }
				]
			},
			body: {
				rows: [
					{ type: "space",
						rows: [
							{
								view: "form", width: 1100, maxHeight: 500, elements: [ table,
								{
									id: "uploadButtons",
									cols:[
										{view:"button", label: "Selecionar Paciente", type:"iconButton", icon: "check-circle",  autowidth: true,
                                            on: {
                                                'onItemClick': function(){
                                                    $$("win1").hide();
                                                    var p = $$('pacientes').getSelectedItem();
                                                    if (!p) return;
                                                    $('#paciente\\[nome\\]').attr('value', p.nome);
                                                    $("#paciente\\[sexo\\]").attr('value', p.sexo);
                                                    $("#paciente\\[empresa\\]").attr('value', p.empresa);
                                                    $("#paciente\\[nascimento\\]").attr('value', p.data);
                                                    $("#paciente\\[cpf\\]").attr('value', p.cpf);
                                                    $("#paciente\\[rg\\]").attr('value', p.rg);
                                                    $("#paciente\\[peso\\]").attr('value', p.peso);
                                                    $("#paciente\\[altura\\]").attr('value', p.altura);
                                                    $("#paciente\\[imc\\]").attr('value', p.imc);
                                                    $("#exame\\[medico_solicitante\\]").attr('value', p.medico_id);
                                                    $("#exame\\[motivo\\]").attr('value', p.motivo_id);
                                                }
                                            }
                                        },
									]
								}
							]

							}
						]
					}
				]
			}
		};

		webix.ui(ui);

		webix.ui({
			container: "webix-search",
			rows:[ form1 ]
		});

    });


</script>
