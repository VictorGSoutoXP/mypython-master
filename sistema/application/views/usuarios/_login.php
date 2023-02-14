﻿<!DOCTYPE html>
<html lang="en">
<head>

<!--
<?php if(!$admin): ?>
   <meta http-equiv="refresh" content="0; url=http://damatelemedicina.com.br/sistema/login" />
<?php endif; ?>
-->

   <meta http-equiv="Content-Type" content="text/html" charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta name="description" content="">
   <meta name="keywords" content="">
   <meta name="author" content="">

   <title>Sistema Dama - <?php echo config_item("lab_name");?></title>

   <link href="<?php echo base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
   <link href="<?php echo base_url('assets/css/bootstrap-responsive.min.css') ?>" rel="stylesheet">
   <link href="<?php echo base_url('assets/css/font-awesome.css') ?>" rel="stylesheet">
   <link href="<?php echo base_url('assets/css/custom.css') ?>" rel="stylesheet">

	<script src="<?php echo base_url('assets/js/jquery.min.js') ?>"></script>
	<script src="<?php echo base_url('assets/js/jquery-ui.min.js') ?>"></script>
   <script src="<?php echo base_url('assets/js/bootstrap.min.js') ?>"></script>
	<script src="<?php echo base_url('assets/js/custom.js') ?>"></script>
</head>
<body class="login">
		<div class= "logotipo1"
				<img scr= "img/logo.png" title="Dama">
    	</div>
	<div class="container">
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
	   <div class="form-container">
    	   <!--<div class="clearfix text-center"><?php echo logo()?></div>-->
    	   <form class="form-signin" method="POST" action="<?php echo site_url("login")?>">
                <input type="text" name="email" required class="input-block-level" placeholder="Email" value="<?php echo set_value('email', $this->input->post('email'))?>">
                <input type="password" name="senha" required class="input-block-level" placeholder="Senha">
                <button class="btn btn-large btn-primary" input type="submit">Entrar</button>
    	   </form>
	   </div>
	</div>
</body>
</html>
