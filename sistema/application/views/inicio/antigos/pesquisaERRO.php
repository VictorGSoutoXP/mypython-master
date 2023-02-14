<?php echo $this->load->view('layouts/menu',false,true,false); ?>

<form action="" method="get">
    <fieldset>
    <legend>Preencha os campos abaixo para pesquisa avançada:</legend>
	
	<!-- <div class="row" id="filtro"></div> -->
	
	<div class="row">
    	<div class="span4">
    	<?php if (!UserSession::isAdmin()){?>
    	    <label for="pacienteNome">Nome do Paciente</label>
    	    <input type="text" name="paciente" class="span4 required" value="<?php echo $params['paciente'];?>" />
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
    			<option value="2" <?php echo $params['status'] == "2" && $params['status'] != "" ? "selected" : ""?>>Laudo Impossibilitado</option>
				<?php if (UserSession::isAdmin() || UserSession::isAuditor()){ ?>
					<option value="3" <?php echo $params['status'] == "3" && $params['status'] != "" ? "selected" : ""?>>WXML para JPG</option>
				<?php } ?>
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
