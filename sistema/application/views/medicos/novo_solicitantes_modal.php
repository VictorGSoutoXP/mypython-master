<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>Cadastrar Novo Médico Solicitante</h3>
</div>
<form class="form-horizontal validator" action="<?php echo site_url('medicos/novo_solicitante')?>" method="post">
<input type="hidden" name="_id" value="<?php echo $medico['id']?>" />
<?php if($cliente_id){?>
<input type="hidden" name="cliente_id" value="<?php echo $cliente_id?>" />
<?php }else{?>
  <div class="control-group">
    <label class="control-label" for="selectCliente">Cliente</label>
    <div class="controls">
      <select name="cliente_id" id="selectCliente">
          <option value="">Selecione um cliente</option>
      <?php foreach ($clientes as $cliente){?>
          <option value="<?php echo $cliente['id'];?>" <?php echo $cliente['id'] == $medico['cliente_id'] ? "selected" : ""?>><?php echo $cliente['nome'];?></option>
      <?php }?>
      </select>
    </div>
  </div>
<?php }?>
  <div class="control-group">
    <label class="control-label" for="inputNome">Nome</label>
    <div class="controls">
      <input type="text" name="nome" id="inputNome" placeholder="Nome" value="<?php echo $medico['nome']?>" class="required">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="inputCRM">CRM</label>
    <div class="controls">
      <input type="text" name="crm" id="inputCRM" placeholder="CRM" value="<?php echo $medico['crm']?>" class="required">
    </div>
  </div>
  <div class="control-group">
    <div class="controls">
      <button type="submit" class="btn btn-primary"><?php echo $medico['id'] ? "Editar" : "Cadastrar"?> Médico</button>
    </div>
  </div>
</form>