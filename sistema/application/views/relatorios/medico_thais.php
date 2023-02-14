<?php echo $this->load->view('layouts/menu',false,true,false); ?>

<form action="" method="post">
    <fieldset>
    <legend>Relatório <?php echo UserSession::isAdmin() ? "Médico" : "Financeiro"?>:</legend>
	<div class="row">
    	<div class="span2 fix-width rel">
    	    <label for="dateInicio">Período</label>
    	    <input id="dpd1" name="inicio" class="span1 datepicker" type="text" value="" placeholder="De" />
    	    <input id="dpd2" name="fim" class="span1 datepicker" type="text" value="" placeholder="Até" />
    	</div>

		<?php if(UserSession::isAdmin()){?>
        <div class="span3 fix-width">
            <label for="clienteNome">Nome do Médico</label>
            <select name="medico" id="medico" class="select-box-auto-width span3" data-placeholder="Selecione o Médico">
                <option value=""></option>
                <?php foreach ($medicos as  $medico){?>
                    <option value="<?php echo $medico['id']?>" <?php echo $params['medico'] == $medico['id'] ? "selected" : ""?>><?php echo $medico['nome']?></option>
                <?php }?>
            </select>
        </div>
		<?php }?>

    	<div class="span2">
			<label>&nbsp;</label>
    	    <button type="submit" class="btn btn-primary inline">Gerar Relatório</button>
    	</div>
	</div>
	</fieldset>
</form>