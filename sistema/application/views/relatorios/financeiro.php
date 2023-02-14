<?php echo $this->load->view('layouts/menu',false,true,false); ?>

<form action="" method="post">
    <fieldset>
    <legend>Relatório Financeiro:</legend>
	<div class="row">
    	<div class="span2 fix-width rel">
    	    <label for="dateInicio">Período</label>
    	    <input id="dpd1" name="inicio" class="span1 datepicker" type="text" value="" placeholder="De" />
    	    <input id="dpd2" name="fim" class="span1 datepicker" type="text" value="" placeholder="Até" />
    	</div>
    	
    	<div class="span3 fix-width">
    	    <label for="clienteNome">Nome do Cliente</label>
    		<select name="cliente" id="cliente" class="select-box-auto-width span3" data-placeholder="Selecione o Cliente">
			    <option value=""></option>
				<?php foreach ($clientes as  $cliente){?>
					<option value="<?php echo $cliente['id']?>" <?php echo $params['cliente'] == $cliente['id'] ? "selected" : ""?>><?php echo $cliente['nome']?></option>
				<?php }?>
			</select>
    	</div>
    	
    	<div class="span2">
			<label>&nbsp;</label>
    	    <button type="submit" class="btn btn-primary inline">Gerar Relatório</button>
    	</div>
	</div>
	</fieldset>
</form>