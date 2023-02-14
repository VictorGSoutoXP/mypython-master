<div class="container">
	<div class="btn-group btn-group-right">
            <div class="btn-group">
                <button type="button" class="btn btn-nav">
                <div class="<?php echo is_active("inicio/lista") || is_active("exames/single") ? "active" : ""?>"><a href="<?php echo site_url('inicio/lista')?>">
                    <span class="icon-fixed-width icon-home" alt title="Home"></span>    			    
                </div>
                </button>
            </div> 
            <div class="btn-group">
                <button type="button" class="btn btn-nav">
                    <div class="<?php if(!UserSession::isMedico()){?>
		    <li class="<?php echo is_active("exames/envio") ? "active" : ""?>"><a href="<?php echo site_url('exames/envio')?>">
                    <span class="fa fa-upload" alt title="Enviar Um Exame"></span> 	                                         
                     </div>
                      <?php }?>   
                </button>
            </div> 
               
            <div class="btn-group">
                <button type="button" class="btn btn-nav">
                <div class="<?php if(!UserSession::isMedico()){?>
		    <div class="<?php echo is_active("exames/lotes") ? "active" : ""?>"><a href="<?php echo site_url("exames/lotes")?>">
            		<i class="fa fa-upload" alt title="Enviar Vários Exames"></i>
                    <span class="fa fa-upload" alt title="Enviar Vários Exames"></span>                                        		 
                     <?php }?>	
                    </div>                   
                </button>
            </div>      
            
            
             <div class="btn-group">
                <button type="button" class="btn btn-nav">
                <div class="<?php echo is_active("inicio/pesquisa") ? "active" : ""?>"><a href="<?php echo site_url('inicio/pesquisa')?>">
                    <span class="icon-search" alt title="Pesquisar"></span>                        			    
                    </div>
                </button>
            </div>  
               
                   <div class="btn-group">
                <button type="button" class="btn btn-nav">
                <div class="<?php echo is_active("relatorios/exames") ? "active" : ""?>"><a href="<?php echo site_url("relatorios/exames")?>">
                    <span class=" icon-list-alt" alt title="Relatório de Exames"></span>                        			    
                    </div>
                </button>
            </div>      
 			    
                <?php if (UserSession::isAdmin()){?>
                   <div class="btn-group">
                <button type="button" class="btn btn-nav">
                <div class="<?php echo is_active("relatorios/financeiro") ? "active" : ""?>"><a href="<?php echo site_url("relatorios/financeiro")?>">
                    <span class="fa fa-usd" alt title="Relatório Financeiro"></span>                        			    
                    </div>
                </button>
            </div>      
 			   	<?php }?>    
                <?php if (UserSession::isAdmin()){?>
                   <div class="btn-group">
                <button type="button" class="btn btn-nav">
                <div class="<?php echo is_active("relatorios/medico") ? "active" : ""?>"><a href="<?php echo site_url("relatorios/medico")?>">
                    <span class="fa fa-user-md" alt title="Relatório Médico"></span>                        			    
                    </div>
                </button>
            </div>      
 			   	<?php }?>  
              <?php if(UserSession::isMedico()) {?>
                   <div class="btn-group">
                <button type="button" class="btn btn-nav">
                <div class="<?php echo is_active("relatorios/medico") ? "active" : ""?>"><a href="<?php echo site_url("relatorios/medico")?>"/>
                    <span class="fa fa-user-md" alt title="Relatório Médico"></span>                        			    
                </div>
                </button>
            </div>      
 			   	<?php }?>  
    
	
          
           
</div>
<b />
	
           
		<?php if (is_active("exames/laudo")){?>
		    <li class="active"><a href="#">Enviar laudo</a></li>
		<?php }?>


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


	


