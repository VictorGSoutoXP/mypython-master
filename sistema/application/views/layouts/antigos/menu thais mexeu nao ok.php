<div class="container">
<div class="nav nav-tabs">
  <div class="btn-tha-group">
    <li class="<?php echo is_active("inicio/lista") || is_active("exames/single") ? "active" : ""?>"><a class="btn-tha btn-cinza" href="<?php echo site_url('inicio/lista')?>"><i class="icon-home"></i> Home</a>
    </li>
  </div>
  <?php if(!UserSession::isMedico()){?>
  <div class="btn-tha-group">
    <li class="<?php echo is_active("exames/envio") ? "active" : ""?>"><a class="btn-tha btn-cinza" href="<?php echo site_url('exames/envio')?>">
      <i class="fa fa-arrow-up icon-white"></i> Enviar um exame</a>
      </li>    
  </div>
  <?php }?>
  
   <div class="btn-tha-group">
  <li class="<?php echo is_active("inicio/pesquisa") ? "active" : ""?>"><a class="btn-tha btn-cinza" href="<?php echo site_url('inicio/pesquisa')?>"><i class="fa fa-search icon-white"></i> Pesquisar</a></li>
  </div>
  <?php if (!UserSession::isCliente()){?>
    <div class="btn-tha-group">
      <a class="btn-tha btn-cinza" href="#"><i class="fa fa-file-excel-o icon-white"></i> Relatórios</a>
      <a class="btn-tha btn-cinza dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
      <ul class="dropdown-menu">
    
      <?php if (UserSession::isAdmin()){?>
		<li class="<?php echo is_active("relatorios/exames") ? "active" : ""?>"/><a href="<?php echo site_url("relatorios/exames")?>"><i class="icon-file"></i> Exames</a></li>
        <?php }?>
        <?php if (UserSession::isAdmin()){?>
        <li class="<?php echo is_active("relatorios/financeiro") ? "active" : ""?>"/><a href="<?php echo site_url("relatorios/financeiro")?>"><i class="icon-file"></i> Financeiro</a></li>         
        <?php }?>
         <?php if (!UserSession::isCliente()){?>
         <li class="<?php echo is_active("relatorios/medico") ? "active" : ""?>"/><a href="<?php echo site_url("relatorios/medico")?>"><i class="icon-file"></i> Médico</a></li>
        <?php }?>                   
      </ul>
    </div>  
   <?php }?>  
<?php if (is_active("exames/laudo")){?>
<li class="active"><a href="#">Enviar laudo</a></li>
<?php }?>



  <?php if(!UserSession::isMedico()){?>
<div class="btn-tha-group">
      <a class="btn-tha btn-cinza" href="#"><i class="fa fa-upload icon-white"></i> Lote</a>
      <a class="btn-tha btn-cinza dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
      <ul class="dropdown-menu">           
		<li class="<?php echo is_active("exames/lotes") ? "active" : ""?>"><a href="<?php echo site_url("exames/lotes")?>"><i class="icon-file"></i> Enviar exames em lote</a></li>    
        
        <!-- <li class="<?php echo is_active("exames/baixar") ? "active" : ""?>"><a href="<?php echo site_url("exames/baixar")?>"><i class="icon-file"></i> Baixar laudos em lote</a></li>-->         
                          
      </ul>
    </div> 
<?php }?>

  <?php if (is_active("exames/laudo")){?>
  <li class="active"><a href="#">Enviar laudo</a></li>
  <?php }?>
 <!-- <?php if(UserSession::isMedico()) {?>
  <li class="dropdown <?php echo is_active("relatorios/medico") ? "active" : ""?>"><a class="dropdown-toggle" data-toggle="dropdown" href="#"> Relatórios <b class="caret"></b></a>
    <ul class="dropdown-menu">
      <li class="<?php echo is_active("relatorios/medico") ? "active" : ""?>"><a href="<?php echo site_url("relatorios/medico")?>">Financeiro</a></li>
    </ul>
  </li>
  <?php }?>-->
  </ul>
</div>
<?php if (!empty($error)): ?>
<div class="alert alert-error">
  <button type="button" class="close" data-dismiss="alert">×</button>
  <b>Error!</b> <?php echo $error ?> </div>
<?php elseif (!empty($info)): ?>
<div class="alert alert-info">
  <button type="button" class="close" data-dismiss="alert">×</button>
  <b>Info.</b> <?php echo $info ?> </div>
<?php endif; ?>
