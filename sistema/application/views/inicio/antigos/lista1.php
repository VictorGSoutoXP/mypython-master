<?php echo $this->load->view('layouts/menu',false,true,false); ?>
<?php echo "<meta HTTP-EQUIV='refresh' CONTENT='600;URL=http://damatelemedicina.com.br/sistema/inicio/lista'>"; ?>
<div class="breadcrumb clearfix">
	<form class="form-inline search-top">
		<div class="pull-left title">
			Exibindo Exames do Mês/Ano: <b><?php echo $params['mes'] ? month_name($params['mes']) : month_name(date("m")) ?>/<?php echo $params['ano'] ? $params['ano'] : date("Y") ?></b>
		</div>
		<div class="pull-right">
		<div class="span2 fix-width title">
			<label for="">Busque por</label>
		</div>
			<div class="span2 fix-width">
			<select name="mes" class="span2" data-placeholder="Selecione o Mês">
			    <option value=""></option>
				<?php foreach ($meses as $mes) { ?>
			    <option value="<?php echo $mes['mes']?>" <?php echo $params['mes'] ==  $mes['mes']? "selected" : ""?>><?php echo month_name($mes['mes'])?></option>
			    <?php }?>
			</select>
			</div>
			<div class="span2 fix-width">
			<select name="ano" class="span1" data-placeholder="Selecione o Ano">
			    <option value=""></option>
				<?php foreach ($anos as $ano) { ?>
			    <option value="<?php echo $ano['ano']?>" <?php echo $params['ano'] ==  $ano['ano']? "selected" : ""?>><?php echo $ano['ano']?></option>
			    <?php }?>
				
			</select>
			</div>
			<div class="span2 fix-width">
			<select name="exame" id="exame" class="span3" data-placeholder="Selecione o Exame">
			    <option value=""></option>
				<?php foreach ($exames_select as  $exame){?>
					<option value="<?php echo $exame['value']?>" <?php echo $params['exame'] == $exame['value'] ? "selected" : ""?>><?php echo $exame['title']?></option>
				<?php }?>
			</select>
			</div>
			<div class="span2 fix-width">
			<button type="submit" class="btn btn-primary">Filtrar</button>
			</div>
		</div>
	</form>
</div>

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