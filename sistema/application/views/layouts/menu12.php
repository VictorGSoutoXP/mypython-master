<div class="container">
  <div class="btn-group btn-group-right">
    <div class="btn-group">
      <button type="button" class="btn btn-nav">
      <div class="<?php echo is_active("inicio/lista") || is_active("exames/single") ? "active" : ""?>"/>
      <a href="<?php echo site_url('inicio/lista')?>"/> <span class="icon-fixed-width icon-home" alt title="Home"><p><h6>Home</h6></p></span> </div>
    </button>
  </div>
    <?php if(!UserSession::isMedico()) {?>
    <div class="btn-group">
    <button type="button" class="btn btn-nav">
		    <div class="<?php echo is_active("exames/envio") ? "active" : ""?>"/>
    <a href="<?php echo site_url('exames/envio')?>"/> <span class="fa fa-upload" alt title="Enviar Um Exame"><p><h6>Enviar Um Exame</h6></p></span> </div>
  </button>
</div>
   <?php }?>
  <?php if(!UserSession::isMedico()) {?>
<div class="btn-group">
  <button type="button" class="btn btn-nav">
		    <div class="<?php echo is_active("exames/lotes") ? "active" : ""?>"/>
  <a href="<?php echo site_url("exames/lotes")?>"/> <i class="fa fa-plus" alt title="Enviar Vários Exames"></i> <span class="fa fa-upload" alt title="Enviar Vários Exames"><p><h6>Lote</h6></p></span>
 </div>
</button>
</div>
 <?php }?>
<div class="btn-group">
  <button type="button" class="btn btn-nav">
  <div class="<?php echo is_active("inicio/pesquisa") ? "active" : ""?>"/>
  <a href="<?php echo site_url('inicio/pesquisa')?>"/> <span class="icon-search" alt title="Pesquisar"><p><h6>Pesquisar</h6></p></span> </div>
</button>
</div>
<?php if (UserSession::isAdmin()){?>
<div class="btn-group">
  <button type="button" class="btn btn-nav">
  <div class="<?php echo is_active("relatorios/exames") ? "active" : ""?>"/>
  <a href="<?php echo site_url("relatorios/exames")?>"/> <span class="fa fa-file-excel-o" alt title="Relatório de Exames"><p><h6>Relatório de Exames</h6></p></span> </div>
</button>
</div>
<?php }?>
<?php if (UserSession::isAdmin()){?>
<div class="btn-group">
  <button type="button" class="btn btn-nav">
  <div class="<?php echo is_active("relatorios/financeiro") ? "active" : ""?>"/>
  <a href="<?php echo site_url("relatorios/financeiro")?>"/> <span class="fa fa-usd" alt title="Relatório Financeiro"><p><h6>Relatório Financeiro</h6></p></span> </div>
</button>
</div>
<?php }?>
<?php if (UserSession::isAdmin()){?>
<div class="btn-group">
  <button type="button" class="btn btn-nav">
  <div class="<?php echo is_active("relatorios/medico") ? "active" : ""?>"/>
  <a href="<?php echo site_url("relatorios/medico")?>"/> <span class="fa fa-user-md" alt title="Relatório Médico"><p><h6>Relatório Médico</h6></p></span> </div>
</button>
</div>
<?php }?>
<?php if(UserSession::isMedico()) {?>
<div class="btn-group">
  <button type="button" class="btn btn-nav">
  <div class="<?php echo is_active("relatorios/medico") ? "active" : ""?>"/>
  <a href="<?php echo site_url("relatorios/medico")?>"/> <span class="fa fa-user-md" alt title="Relatório Médico"><p><h6>Relatório Médico</h6></p></span> </div>
</button>
</div>
<?php }?>
</div>
</a>
<b />

		<?php if (is_active("exames/laudo")){?>
		    <li class="active"><a href="#">Enviar laudo</a></li>
		<?php }?>
		<?php if(UserSession::isMedico()) {?>
		<li class="dropdown <?php echo is_active("relatorios/medico") ? "active" : ""?>"><a class="dropdown-toggle" data-toggle="dropdown" href="#"> Relatórios <b class="caret"></b></a>
    			<ul class="dropdown-menu">
		            <li class="<?php echo is_active("relatorios/medico") ? "active" : ""?>"><a href="<?php echo site_url("relatorios/medico")?>">Financeiro</a></li>
    			</ul>
    		</li>
		<?php }?>
	</ul>
</div>

<?php if (!empty($error)): ?>
  <div class="alert alert-error">
  	 <button type="button" class="close" data-dismiss="alert">×</button>
     <b>Error!</b> <?php echo $error ?>
  </div>
<?php elseif (!empty($info)): ?>
  <div class="alert alert-info">
  	<button type="button" class="close" data-dismiss="alert">×</button>
    <b>Info.</b> <?php echo $info ?>
  </div>
<?php endif; ?>
