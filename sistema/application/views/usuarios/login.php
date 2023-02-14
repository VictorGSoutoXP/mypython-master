<!DOCTYPE html>
<html lang="en">
<head>
   <meta http-equiv="Content-Type" content="text/html" charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta name="description" content="">
   <meta name="keywords" content="">
   <meta name="author" content="">

   <?php 
	 $empresa = UserSession::getInstance()->getEmpresa();
   ?>

   <title>Sistema de Laudo Online - <?php echo strtoupper($empresa); ?></title> <!-- <?php echo config_item("lab_name");?> -->

   <link href="<?php echo base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
   <link href="<?php echo base_url('assets/css/bootstrap-responsive.min.css') ?>" rel="stylesheet">
	<link href="<?php echo base_url('assets/css/font-awesome.css') ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/custom.css') ?>" rel="stylesheet">
    <link rel="shortcut icon" href="http://sistemadama.com.br/site_dama/wp-content/uploads/2021/02/favicon-1.ico" />


	<style>
		.fullscreen_bg {
			background-image: url('/sistema/assets/img/dama/<?php echo $empresa; ?>.png');
		}
	</style>
	
	<script src="<?php echo base_url('assets/js/jquery.min.js') ?>"></script>
	<script src="<?php echo base_url('assets/js/jquery-ui.min.js') ?>"></script>
   <script src="<?php echo base_url('assets/js/bootstrap.min.js') ?>"></script>
	<script src="<?php echo base_url('assets/js/custom.js') ?>"></script>
	
	<script language=javascript>
		//function redirect(){
		  //window.location = "http://damatelemedicina.com.br/sistema/login";
		//}
	</script>
	
</head>
<body class="login"> <!--  onload="redirect()"> -->
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
		<div id="fullscreen_bg" class="fullscreen_bg"/>

		<div class="container">
	   <div class="form-signin">
    	   	    <form class="form-signin-heading text-muted" method="POST" action="<?php echo site_url("login")?>">
                <input type="text" name="email" required class="form-control" placeholder="Seu Email" value="<?php echo set_value('email', $this->input->post('email'))?>">
                <input type="password" name="senha" required class="form-control" placeholder="Senha">
                <button class="btn btn-lg btn-success btn-block" input type="submit">Acessar</button>
    	   </form>
	   </div>
	</div>
</body>

</html>
