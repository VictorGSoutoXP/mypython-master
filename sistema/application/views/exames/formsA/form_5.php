<div class="row">
    	<div class="span3">
			<label for="paciente[nome]">Nome Completo</label>
			<input type="text" id="paciente[nome]" class="span3 required" name="paciente[nome]" value="<?php echo $paciente['nome']?>" <?php echo $paciente['readonly'] ? "disabled" : ""?> />
		</div>
		<div class="span3">
			<label for="paciente[empresa]">Empresa</label>
			<input type="text" id="paciente[empresa]" class="span3" name="paciente[empresa]" value="<?php echo $paciente['empresa']?>" <?php echo $paciente['readonly'] ? "disabled" : ""?> />
		</div>
		<div class="span2">
			<label for="paciente[sexo]">Sexo</label>
			<?php if($paciente['readonly']){?>
			<input type="text" id="paciente[sexo]" class="span2" name="paciente[sexo]" value="<?php echo $paciente['sexo'] ? ($paciente['sexo'] == "M" ? "Masculino" : "Feminino") : ""?>" <?php echo $paciente['readonly'] ? "disabled" : ""?>/>
			<?php } else {?>
			<select id="paciente[sexo]" class="span2" name="paciente[sexo]">
				<option value=""></option>
				<option value="M" <?php echo $paciente['sexo'] == "M" ? "selected" : ""?>>Masculino</option>
				<option value="F" <?php echo $paciente['sexo'] == "F" ? "selected" : ""?>>Feminino</option>
			</select>
			<?php }?>
		</div>
		<div class="span2">
			<label for="paciente[nascimento]">Data de nascimento</label>
			<input type="text" id="paciente[nascimento]" class="span2 data" name="paciente[nascimento]" value="<?php echo $paciente['nascimento'] && $paciente['nascimento'] != "0000-00-00" ? date('d/m/Y', strtotime($paciente['nascimento'])) : ""?>" <?php echo $paciente['readonly'] ? "disabled" : ""?>/>
		</div>
		<?php if($paciente['readonly']){?>
    		<div class="span2">
    			<label for="paciente[idade]">Idade</label>
    			<input type="text" id="paciente[idade]" class="span2" name="paciente[idade]" value="<?php echo $paciente['idade'] ? $paciente['idade'] : ""?>" <?php echo $paciente['readonly'] ? "disabled" : ""?>/>
    		</div>
		<?php }?>
</div>
<div class="row">
		<div class="span2">
			<label for="paciente[cpf]">CPF</label>
			<input type="text" id="paciente[cpf]" class="span2" name="paciente[cpf]" value="<?php echo $paciente['cpf']?>" <?php echo $paciente['readonly'] ? "disabled" : ""?> />
		</div>
		<div class="span2">
			<label for="paciente[rg]">RG</label>
			<input type="text" id="paciente[rg]" class="span2" name="paciente[rg]" value="<?php echo $paciente['rg']?>" <?php echo $paciente['readonly'] ? "disabled" : ""?> />
		</div>
</div>
<div class="row">
	<div class="span1">
		<label for="paciente[peso]">Peso (KG)</label>
		<input type="text" id="paciente[peso]" class="span1 bind-imc" name="paciente[peso]" value="<?php echo $peso?>" <?php echo $paciente['readonly'] ? "disabled" : ""?> />
	</div>
	<div class="span1">
		<label for="paciente[altura]">Altura (M)</label>
		<input type="text" id="paciente[altura]" class="span1 bind-imc" name="paciente[altura]" value="<?php echo $altura?>" <?php echo $paciente['readonly'] ? "disabled" : ""?> />
	</div>
	<div class="span1">
		<label for="paciente[imc]">IMC</label>
		<input type="text" id="paciente[imc]" class="span1" name="paciente[imc]" readonly="readonly" value="<?php echo $imc?>" <?php echo $paciente['readonly'] ? "disabled" : ""?> />
	</div>
</div>
<script>
		$("#exame\\[motivo\\]").removeAttr("required").removeClass('required');
</script>