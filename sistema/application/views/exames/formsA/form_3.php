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
			<input type="text" id="paciente[sexo]" class="span2 required" name="paciente[sexo]" value="<?php echo $paciente['sexo'] ? ($paciente['sexo'] == "M" ? "Masculino" : "Feminino") : ""?>" <?php echo $paciente['readonly'] ? "disabled" : ""?>/>
			<?php } else {?>
			<select id="paciente[sexo]" class="span2 required" name="paciente[sexo]">
				<option value=""></option>
				<option value="M" <?php echo $paciente['sexo'] == "M" ? "selected" : ""?>>Masculino</option>
				<option value="F" <?php echo $paciente['sexo'] == "F" ? "selected" : ""?>>Feminino</option>
			</select>
			<?php }?>
		</div>
		<div class="span2">
			<label for="paciente[nascimento]">Data de nascimento</label>
			<input type="text" id="paciente[nascimento]" class="span2 data required" name="paciente[nascimento]" value="<?php echo $paciente['nascimento'] && $paciente['nascimento'] != "0000-00-00" ? date('d/m/Y', strtotime($paciente['nascimento'])) : ""?>" <?php echo $paciente['readonly'] ? "disabled" : ""?>/>
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
		<div class="span2">
			<label for="paciente[fumante]">Fumante ?</label>
            <div class="checkbox-inputs">
            	<input type="radio" id="fumante_sim" name="paciente[fumante]" class="check-fumante" value="1" <?php echo $fumante ? "checked" : ""?> <?php echo $paciente['readonly'] ? "disabled" : ""?>> Sim
            	&nbsp;&nbsp;
            	<input type="radio" id="fumante_nao" name="paciente[fumante]" class="check-fumante" value="0" <?php echo !$fumante ? "checked" : ""?> <?php echo $paciente['readonly'] ? "disabled" : ""?>> Não
            	&nbsp;&nbsp;&nbsp;&nbsp;
            </div>         
		</div>
		<div class="span2 <?php echo !$fumante ? "hide" : ""?>" id="tempo_fumante_container">
			<label for="paciente[imc]">Tempo Fumante?</label>
			<input type="text" id="paciente[fumante_tempo]" class="span2 <?php echo !$fumante ? "hide" : ""?>" name="paciente[fumante_tempo]" placeholder="Quanto tempo?" value="<?php echo $fumante_tempo?>"  <?php echo $paciente['readonly'] ? "disabled" : ""?>/>
		</div>
		<div class="span2 <?php echo !$fumante ? "hide" : ""?>" id="cigarros_dia_container">
			<label for="paciente[imc]">Cigarros / Dia</label>
			<input type="text" id="exame[extra_data][cigarros_dia]" class="span2 <?php echo !$fumante ? "hide" : ""?>" name="exame[extra_data][cigarros_dia]" placeholder="Cigarros / Dia" value="<?php echo $extra_data['cigarros_dia']?>"  <?php echo $paciente['readonly'] ? "disabled" : ""?>/>
		</div>
</div>
