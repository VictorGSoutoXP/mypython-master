<?php echo $this->load->view('layouts/menu',false,true,false); ?>
<form action="" method="post">
    <fieldset>
    <legend>Relatório de Exames:</legend>
	<div class="row">
    	<div class="span3">
    	    <label for="pacienteNome">Nome do Cliente</label>
    		<select name="cliente" id="cliente" class="select-box-auto-width span3" data-placeholder="Selecione o Cliente">
			    <option value=""></option>
				<?php foreach ($clientes as  $cliente){?>
					<option value="<?php echo $cliente['id']?>" <?php echo $params['cliente'] == $cliente['id'] ? "selected" : ""?>><?php echo $cliente['nome']?></option>
				<?php }?>
			</select>
    	</div>
    	<div class="span2 fix-width">
    	    <label for="dateInicio">Período</label>
    	    <input id="dpd1" name="inicio" class="span1 datepicker" type="text" value="" placeholder="De" />
    	    <input id="dpd2" name="fim" class="span1 datepicker" type="text" value="" placeholder="Até" />
    	</div>
    	<div class="span2 fix-width">
    		<label>Status</label>
    		<select name="status" class="select-box-auto-width span2" data-placeholder="Selecione o Status">
    		    <option value=""></option>
    			<option value="0" <?php echo $params['status'] == "0" && $params['status'] != "" ? "selected" : ""?>>Aguardando Laudo</option>
    			<option value="1" <?php echo $params['status'] == "1" ? "selected" : ""?>>Laudado</option>
    			<option value="2" <?php echo $params['status'] == "2" ? "selected" : ""?>>Laudo Impossibilitado</option>
    		</select>
    	</div>
    	<div class="span2">
			<label>&nbsp;</label>
    	    <button type="submit" class="btn btn-primary">Gerar Relatório</button>
    	</div>
	</div>
	</fieldset>
</form>