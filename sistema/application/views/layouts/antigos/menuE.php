<div class="container">
	<ul class="nav nav-tabs">
		<li class="<?php echo is_active("inicio/lista") || is_active("exames/single") ? "active" : ""?>"><a href="<?php echo site_url('inicio/lista')?>">Início</a></li>

		<?php if(!UserSession::isMedico()){?>
		    <li class="<?php echo is_active("exames/envio") ? "active" : ""?>"><a href="<?php echo site_url('exames/envio')?>">Enviar Exame</a></li> 
		<?php }?>

		<li class="<?php echo is_active("inicio/pesquisa") ? "active" : ""?>"><a href="<?php echo site_url('inicio/pesquisa')?>">Pesquisa</a></li>

		<?php if (UserSession::isAdmin()){?>
    		<li class="dropdown <?php echo is_active("relatorios/exames") || is_active("relatorios/financeiro") || is_active("relatorios/medico") ? "active" : ""?>"><a class="dropdown-toggle" data-toggle="dropdown" href="#"> Relatórios <b class="caret"></b></a>
    			<ul class="dropdown-menu">
    				<li class="<?php echo is_active("relatorios/exames") ? "active" : ""?>"><a href="<?php echo site_url("relatorios/exames")?>">Exames</a></li>
    				<li class="<?php echo is_active("relatorios/financeiro") ? "active" : ""?>"><a href="<?php echo site_url("relatorios/financeiro")?>">Financeiro</a></li>
		            <li class="<?php echo is_active("relatorios/medico") ? "active" : ""?>"><a href="<?php echo site_url("relatorios/medico")?>">Médico</a></li>
    				
    			</ul>
    		</li>
		<?php }?>

		<?php if(!UserSession::isMedico()){?>
			<li class="dropdown <?php echo is_active("exames/envio") || is_active("exames/lote") ? "active" : ""?>"><a class="dropdown-toggle" data-toggle="dropdown" href="#"> Lote <b class="caret"></b></a>
				<ul class="dropdown-menu">
					<li class="<?php echo is_active("exames/lotes") ? "active" : ""?>"><a href="<?php echo site_url("exames/lotes")?>">Enviar Exames...</a></li>
					<!-- <li class="<?php echo is_active("exames/baixar") ? "active" : ""?>"><a href="<?php echo site_url("exames/baixar")?>">Baixar Laudos</a></li> -->
                </ul>
			</li>
			<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#"> Ajuda <b class="caret"></b></a>
				<ul class="dropdown-menu">
					<li class="active"><a href="<?php echo site_url("inicio/manuais")?>">Manuais & Downloads...</a></li>
				</ul>
			</li>
		<?php }?>

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
