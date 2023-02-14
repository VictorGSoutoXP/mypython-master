<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html" charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="keywords" content="">
<meta name="author" content="">
<meta name="google-site-verification" content="vLDtoocn5bJwLHxTDGo94mij1ZpGj1gqTEVNU42dDIc" />

<?php 
	$empresa = UserSession::getInstance()->getEmpresa();
?>

<title>Sistema - <?php echo strtoupper($empresa); ?></title>

<link href="<?php echo base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
<link href="<?php echo base_url('assets/css/bootstrap-responsive.min.css') ?>" rel="stylesheet">

<link href="<?php echo base_url('assets/css/jasny-bootstrap.min.css') ?>" rel="stylesheet">
<link href="<?php echo base_url('assets/css/font-awesome.css') ?>" rel="stylesheet">
<link href="<?php echo base_url('assets/css/select2.css') ?>" rel="stylesheet">
<link href="<?php echo base_url('assets/css/select2-bootstrap.css') ?>" rel="stylesheet">
<link href="<?php echo base_url('assets/css/datepicker.css') ?>" rel="stylesheet">
<link href="<?php echo base_url('assets/css/balloon.css') ?>" rel="stylesheet">

<!-- OPENSHIFT SOFTWARE CSS -->
<link href="<?php echo base_url('assets/webix/codebase/webix.css') ?>" rel="stylesheet">
<link href="<?php echo base_url('assets/css/os/loader.css') ?>" rel="stylesheet">
<link href="<?php echo base_url('assets/css/os/upload.css') ?>" rel="stylesheet">
<link href="<?php echo base_url('assets/css/os/rotate.css') ?>" rel="stylesheet">
<link href="<?php echo base_url('assets/css/os/layout.css') ?>" rel="stylesheet">

<link rel="stylesheet" href="<?php echo base_url('assets/css/tablesorter/theme.bootstrap.css') ?>">

<link href="<?php echo base_url('assets/css/custom.css') ?>" rel="stylesheet">

<script type="text/javascript">
var baseUrl = "<?php echo base_url()?>";
var pusher_key = "<?php echo config_item("pusher_api_key")?>";
var pusher_channel = "<?php echo get_pusher_channel();?>";
</script>

<script src="<?php echo base_url('assets/js/jquery.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/jquery-ui.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/bootstrap.min.js') ?>"></script>
	<!--
<script src="<?php echo base_url('assets/js/jasny-bootstrap.min.js') ?>"></script>
-->
<script src="<?php echo base_url('assets/js/jquery.maskMoney.js') ?>"></script>
<script src="<?php echo base_url('assets/js/bootstrap-datepicker.js') ?>"></script>
<script src="<?php echo base_url('assets/js/select2.js') ?>"></script>

<script src="<?php echo base_url('assets/js/jquery.rvalidate.js') ?>"></script>

<script src="<?php echo base_url('assets/js/tablesorter/jquery.tablesorter.js') ?>"></script>
<script src="<?php echo base_url('assets/js/tablesorter/jquery.tablesorter.widgets.js') ?>"></script>
<script src="<?php echo base_url('assets/js/tablesorter/jquery.tablesorter.pager.js') ?>"></script>
<script src="<?php echo base_url('assets/js/tablesorter.bootstrap.js') ?>"></script>

<!-- OPENSHIFT SOFTWARE JS -->
<script src="<?php echo base_url('assets/webix/codebase/webix.js') ?>"></script>
<script src="<?php echo base_url('assets/js/os/utils/ajax.js') ?>"></script>
<script src="<?php echo base_url('assets/js/os/utils/loader.js') ?>"></script>
<script src="<?php echo base_url('assets/js/os/utils/rotate.js') ?>"></script>
<script src="<?php echo base_url('assets/js/os/utils/download.js') ?>"></script>

<!--
<script src="<?php echo base_url('assets/js/os/utils/cornerstone.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/os/utils/dicomParse.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/os/utils/cornerstoneWADOImageLoader.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/os/utils/dicomfile/uids.js') ?>"></script>
<script src="<?php echo base_url('assets/js/os/utils/initializeWebWorkers.js') ?>"></script>
-->

<!-- ################## -->

<!-- Pusher -->
<script src="http://js.pusher.com/2.1/pusher.min.js" type="text/javascript"></script>
<!-- Pusher -->
<script src="<?php echo base_url('assets/js/notifications.js?' . time()) ?>"></script>

</head>
<body>

	<div id="loader" class="loading"></div>

	<div id="wrap">
		<div class="container header">
			<div class="navbar navbar">
				<div class="navbar-inner">
					<div class="container">
						<button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
							<span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span>
						</button>

						<a class="brand" href="<?php echo site_url("/")?>">
							<img src="<?php echo site_url('assets/img/dama') . '/' . $empresa . '_logo.png'; ?>" />
						</a>

						<div class="nav-collapse collapse">
							<ul class="nav">
			                  <li class="divider-vertical"></li>
			                </ul>
							<ul class="nav pull-right">
							<?php if(UserSession::isAdmin() && !UserSession::isAuditor()){?>
							    <li class="dropdown">

									<a href="#" class="dropdown-toggle" data-toggle="dropdown">Usuários</a>

							    	<ul class="dropdown-menu">
									    <li><a href="<?php echo site_url("usuarios/novo_medico")?>">Novo Médico</a></li>
									    <li><a href="<?php echo site_url("usuarios/novo_cliente")?>">Novo Cliente</a></li>
									    <li><a href="<?php echo site_url("usuarios/novo")?>">Novo Administrador</a></li>
										<li><a href="<?php echo site_url("usuarios/logados")?>">Logados</a></li>

									</ul>
							    </li>
						    <?php }?>
								<li class="dropdown" style="white-space: nowrap;">

									<a title="Usuários logados" href="<?php echo site_url("inicio/expirando");?>" class="badge-exames-top">
										<span class="badge badge-important"><?php echo get_count_waiting()?></span>
									</a>

									<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo saudacao(ucwords(mb_convert_case(UserSession::user("nome"), MB_CASE_LOWER)));?> <b class="caret"></b></a>

									<ul class="dropdown-menu">
										<?php if(UserSession::isAdmin()){?>
										    <li><a href="<?php echo site_url("usuarios/perfil")?>">Editar Perfil</a></li>
										<?php }?>
										<?php if(UserSession::isMedico() || UserSession::isAdmin()){?>
										
											<li class="divider"></li>
    										<li><a href="<?php echo site_url("laudos/modelos")?>">Modelos Laudos</a></li>
										<?php }?>
										<li class="divider"></li>
										<li><a href="<?php echo site_url("usuarios/logout")?>"><i class="icon-off"></i> Sair</a></li>
									</ul>
								</li>
							</ul>
						</div>
						<!--/.nav-collapse -->
					</div>
				</div>
			</div>
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
		<div class="container">
			<?php echo $content; // View file rendered; ?>
		</div>
		<div id="push"></div>
	</div>

	<div id="footer">
		<div class="container">
			<p class="muted credit">Copyright © - Todos os direitos reservados. - <?php echo date("m/d/Y H:i:s")?></p>
		</div>
	</div>
	<script src="<?php echo base_url('assets/js/custom.js?' . time()) ?>"></script>

</body>

<script type="text/javascript">
    $(document).ready(function(){
        var node = $('#cke_pastebin');
        if (node){
          node.css("position","");
          node.css('width',"");
          node.css('overflow',"");
        }
        loader.stop();
     });
</script>

</html>
