<div class="container">
	<div id="webix_menu"></div>

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

<script>
	function disparaMenu(id, medico) {
		var url = null;
		if (id == 'inicio'){ url = 'inicio/lista' }
		if (id == 'exames'){ url = 'exames/envio' }
		if (id == 'pesquisa'){ url = 'inicio/pesquisa' }
		if (id == 'rel_exame'){ url = 'relatorios/exames' }
		if (id == 'rel_financeiro' && !medico){ url = 'relatorios/financeiro' }
		if (id == 'rel_financeiro' && medico){ url = 'relatorios/medico' }
		if (id == 'rel_medico'){ url = 'relatorios/medico' }
		if (id == 'enviar_exames'){ url = 'exames/lotes' }
		if (id == 'lista_ajuda'){ url = 'inicio/manuais' }
		if (url) window.location = window.location.origin + '/sistema/' + url;
	}
</script>

<?php if (UserSession::isAdmin()){?>
	<script>

		webix.ui({
			container:"webix_menu",
			view:"menu",
			data:[
				{ id:"inicio",value:"Início" },
				{ id:"exames",value:"Enviar Exame" },
				{ id:"pesquisa",value:"Pesquisa" },
				{ id:"relatorios",value:"Relatórios",
					submenu:[
						{ id: 'rel_exame', value: "Exames..." },
						{ id: 'rel_financeiro', value: "Financeiros..." },
						{ id: 'rel_medico', value: "Medicos" }
					]
				},
				{ id:"lotes",value:"Lotes",
					submenu:[
						{ id: 'enviar_exames', value: "Enviar Exames..." }
					]
				},
				{ id:"ajuda", value:"Ajuda",
					submenu:[
						{ id: 'lista_ajuda', value: "Downloads..." }
					]
				}
			],
			on:{
				onMenuItemClick:function(id){
					disparaMenu(id);
				}
			},
			type:{
				subsign:true
			}
		});

	</script>
<?php } ?>


<?php if (UserSession::isMedico()){?>
	<script>
		webix.ui({
			container:"webix_menu",
			view:"menu",
			data:[
				{ id:"inicio",value:"Início" },
				{ id:"pesquisa",value:"Pesquisa" },
				{ id:"relatorios",value:"Relatórios",
					submenu:[
						{ id: 'rel_financeiro', value: "Financeiros..." },
					]
				}
			],
			on:{
				onMenuItemClick:function(id){
					disparaMenu(id, true);
				}
			},
			type:{
				subsign:true
			}
		});

	</script>
<?php } ?>

<?php if (UserSession::isCliente()){?>
	<script>
		webix.ui({
			container:"webix_menu",
			view:"menu",
			data:[
				{ id:"inicio",value:"Início" },
				{ id:"exames",value:"Enviar Exame" },
				{ id:"pesquisa",value:"Pesquisa" },
				{ id:"lotes",value:"Lotes",
					submenu:[
						{ id: 'enviar_exames', value: "Enviar Exames..." }
					]
				},
				{ id:"ajuda", value:"Ajuda",
					submenu:[
						{ id: 'lista_ajuda', value: "Downloads..." }
					]
				}
			],
			on:{
				onMenuItemClick:function(id){
					disparaMenu(id);
				}
			},
			type:{
				subsign:true
			}
		});

	</script>
<?php } ?>

