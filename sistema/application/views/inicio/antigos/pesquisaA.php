<?php echo $this->load->view('layouts/menu',false,true,false); ?>

<form action="" method="get">
    <fieldset>
    <legend>Preencha os campos abaixo para pesquisa avançada:</legend>
	<div class="row">
    	<div class="span4">
    	<?php if (!UserSession::isAdmin()){?>
    	    <label for="pacienteNome">Nome do Paciente</label>
    	    <input type="hidden" name="paciente" class="select-box-pacientes span4 required" data-type="paciente" value="<?php echo $params['paciente'];?>" />
    		<!-- <select name="paciente" id="paciente" class="select-box-auto-width span4" data-placeholder="Selecione o Paciente">
			    <option value=""></option>
				<?php foreach ($pacientes as  $paciente){?>
					<option value="<?php echo $paciente['id']?>" <?php echo $params['paciente'] == $paciente['id'] ? "selected" : ""?>><?php echo $paciente['nome']?></option>
				<?php }?>
			</select> -->
		<?php }else{?>
    	    <label for="pacienteNome">Nome do Cliente</label>
    		<select name="cliente" id="cliente" class="span4" data-placeholder="Selecione o Cliente">
			    <option value=""></option>
				<?php foreach ($clientes as  $cliente){?>
					<option value="<?php echo $cliente['id']?>" <?php echo $params['cliente'] == $cliente['id'] ? "selected" : ""?>><?php echo $cliente['nome']?></option>
				<?php }?>
			</select>
		<?php }?>
    	</div>
    	<div class="span2 fix-width">
    	    <label for="dateInicio">Período</label>
    	    <input id="dpd1" name="inicio" class="span1 datepicker" type="text" value="" placeholder="De" />
    	    <input id="dpd2" name="fim" class="span1 datepicker" type="text" value="" placeholder="Até" />
    	</div>
    	<div class="span2 fix-width">
    		<label>Status</label>
    		<select name="status" class="span2" data-placeholder="Selecione o Status">
    		    <option value="">Selecione o Status</option>
    			<option value="1" <?php echo $params['status'] == "1" ? "selected" : ""?>>Laudado</option>
    			<option value="0" <?php echo $params['status'] == "0" && $params['status'] != "" ? "selected" : ""?>>Aguardando Laudo</option>
    		</select>
    	</div>
    	<div class="span1">
			<label>&nbsp;</label>
    	    <button type="submit" class="btn btn-primary">Pesquisar</button>
    	</div>
	</div>
	</fieldset>
</form>

<?php if($exames){?>
<div class="tableContainer">

<?php echo $this->load->view('inicio/exames_table', $exames, true, false); ?>

<?php echo $this->load->view('layouts/pagination',false,true,false); ?>
</div>
<?php }else{ ?>
    <div class="well">
    	<h3 class="text-center">Nenhum Exame encontrado</h3>
    </div>
<?php }?>