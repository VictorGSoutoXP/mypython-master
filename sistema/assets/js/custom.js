_log = function(){
	try {
		if(jQuery.browser.msie == true){
			for ( var i in arguments) {
				if(typeof arguments == "object"){
					console.log(JSON.stringify(arguments[i]));
				}else{
					console.log(arguments[i]);
				}
			}
		}else{
			for ( var i in arguments) {
				console.log(arguments[i]);
			}
		}
	} catch (e) {} 
};

(function($) {
	var System = function() {
		var exports = {};
		var self = this;

		this.init = function() {
			self.customizeSelects();
			if($("#cpf").length){
				$("#cpf").focus();
			}else if($("#nome").length){
				$("#nome").focus();
			}
			
			$(document).on('click', '.novoSolicitante', function(e){
				e.preventDefault();
				Common.userNotify.show('<p>Aguarde. Carregando...</p>', 'alert');
				var $modalSolicitante = $('#modalMedico').modal({
					show: false,
					backdrop: 'static'
				});
				
				$modalSolicitante.modal('hide');
				$modalSolicitante.empty();
				
				$.get($(this).attr('href'), function(data){
					Common.userNotify.destroy();
					
					$modalSolicitante.html(data);
					$modalSolicitante.modal('show');
					$modalSolicitante.find("form").rvalidate({
						onsuccess: function(a, b, c, d){
							try {
								if(a.indexOf("error") == -1){
									d.get(0).reset();
									$modalSolicitante.modal('hide');
								}
							} catch (e) {}
						}
					});
				});

				$modalSolicitante.on('hidden', function(){
					$modalSolicitante.empty();
				})
			});
		}
		
		this.customizeSelects = function(){
			if ($.fn.select2) {
				$("select.select-box, select.select-box-auto-width").select2({
				    allowClear: true
				});

				$(".select-box-pacientes").select2({
					initSelection : function (element, callback) {
						
						var val = $(element).val();
						var type = $(element).data("type");
						if(val){
							$.ajax(baseUrl + "exames/get_pessoas", {
				                data: {
					            	type: type,
				                    id: val
				                },
				                dataType: "json"
				            }).done(function(data) {
				            	callback(data.results[0]); 
				            });
							
					        var data = {id: element.val(), text: element.data('text')};
					        callback(data);
						}
				    },
					allowClear: true,
					minimumInputLength: 2,
					ajax : {
						url: baseUrl + "exames/get_pessoas",
						dataType: "json",
						quietMillis: 100,
						data: function (term, page) { // page is the one-based page number tracked by Select2
							$type = $(this).data("type");
							
				            return {
				            	type: $type,
				                q: term
				            };
				        },
						results: function(data, page){
				            _log(data);
				            return {results: data.results, more: data.more};
						},
						params: {
							error: function(a, b, c, d){
								if(a.responseText){
									try {
										eval(a.responseText);
									} catch (e) {
										Common.userNotify.show('<p>Houve um erro no sistema. Atualize a página</p>', 'error', 4000);
									}
								}
							}
						}
					}
				});
			}
		}
	};
	
	var Medicos = function(){

		this.insertRowMedicoSolicitante = function(data){
			var $target = $("#medicos-sol-cliente .table tbody"),
				$html = Common.render($('#row-medico-solicitante'), data);
			if($target.length > 0) {
				$target.append($html);
			} else {
				Common.userNotify.show('<p>Houve um erro no sistema. Atualize a página</p>', 'error', 4000);
			}
		};
		
		this.updateRowMedicoSolicitante = function(target, data){
			var $target = $(target),
				$html = Common.render($('#row-medico-solicitante'), data);
			if($target.length > 0) {
				$target.replaceWith($html);
			} else {
				Common.userNotify.show('<p>Houve um erro no sistema. Atualize a página</p>', 'error', 4000);
			}
		}
	};
	
	var Exames = function() {
		
		var self = this;
		$(document).on('change', '#exame\\[exame\\]', function(e){
			
			e.preventDefault();

			var $this = $(this),
				exame_id,
				sub_exame_nome;
			
			if($this.val()) {

				var exame_params = $this.val().split('|');
				
				if(exame_params.length == 2){
					exame_id = exame_params[0];
					sub_exame_nome = exame_params[1];
					
					self.loadFormByExame(exame_id);

				}else {
					Common.userNotify.show('<p>Houve um erro no sistema. Atualize a página</p>', 'error', 4000);
				}
			}
		});
		
		$(document).on('keyup', '.bind-imc', function(e){
			$(this).val($(this).val().replace(',', '.'));
			self.calculateIMC();
		});
		
		$(document).on('click', '.check-fumante', function(e){
			var $this = $(this),
				$target = $('#paciente\\[fumante_tempo\\], #exame\\[extra_data\\]\\[cigarros_dia\\], #tempo_fumante_container, #cigarros_dia_container');
			
			if($this.val() == 1){
				$target.removeClass('hide');
			} else {
				$target.addClass('hide');
			}
		});
		
		this.loadFormByExame = function(exame_id){

			Common.userNotify.show('<p>Aguarde. Carregando...</p>', 'alert');

			$('#box_laudo_rapido').show();

			if (exame_id == 3) $("#box_laudo_rapido").hide();

			var $target = $('#form-exame-distinct-container'),
				$container = $('.form-fields-container');
			
			$target.empty();

			$(".error", $container).removeClass('error');
			$("#exame\\[observacoes\\]", $container).removeAttr("required");

			if (exame_id == 6) {

				$('#form-acuidade-container').show();
				$("#arquivo_exame", $container).removeClass('required');


			} else {

				$('#form-acuidade-container').hide();
				$("#arquivo_exame", $container).addClass('required');

			}

			if ($("#usuario_laudos_rapido").val() == 1) $("#box_laudo_rapido").hide();

			$.post(baseUrl + "exames/get_form_exame", {exame_id: exame_id}, function(d){
				Common.userNotify.destroy();
				
				$target.html(d);
				
				$('.data').mask('99/99/9999');
				$container.show();

			}, 'html');


		};
		
		this.calculateIMC = function() {
			var peso = parseFloat($('#paciente\\[peso\\]').val()),
				altura = parseFloat($('#paciente\\[altura\\]').val()),
				imc = 0,
				target = $('#paciente\\[imc\\]');
			
			console.log(peso, altura);
			
			if(!isNaN(peso) && !isNaN(altura)) {
				imc = peso / Math.pow(altura, 2);

				console.log(imc, Math.pow(altura, 2));
				
				if(!isNaN(imc)){
					target.val(imc.toFixed(2));
				} else {
					Common.userNotify.show('<p>Para Calcular o IMC digite o Peso em <b>Kilos</b> e a Altura em <b>Metros</b></p>', 'error', 4000);
				}
			}
		}
	};

	window.system = new System();
	window.medicos = new Medicos();
	window.exames = new Exames();
	
	$(document).ready(function() {
		system.init();
		
		var dashboard = $('#dpd1').datepicker({
			format: 'dd/mm/yyyy'
		}).on('changeDate', function(ev) {
			if (ev.date.valueOf() > fim.date.valueOf()) {
				var newDate = new Date(ev.date)
			    newDate.setDate(newDate.getDate() + 1);
			    fim.setValue(newDate);
			}
			dashboard.hide();
			$('#dpd2').get(0).focus();
		}).data('datepicker');
		
		window.dashboard = dashboard;
		
		var fim = $('#dpd2').datepicker({
			format: 'dd/mm/yyyy',
			onRender: function(date) {
				if(dashboard.element.val()){
					return date.valueOf() <= dashboard.date.valueOf() ? 'disabled' : '';
				}
				return '';
			}
		}).on('changeDate', function(ev) {
			fim.hide();
		}).data('datepicker');

		window.fim = fim;

		$("form#cadastroPaciente").rvalidate({
			onsuccess: function(a, b, c, d){
				d.get(0).reset();
			}
		});
		$("form#cadastroUsuario").rvalidate({
			onsuccess: function(a, b, c, d){
				try {
					if(a.indexOf("error") == -1){
						d.get(0).reset();
						$(".select-box-auto-width", d).select2("val", "");
					}
				} catch (e) {}
			},
			validate : {
				highlight: function(element, errorClass, validClass) {
					$(element).prev().find(".select2-choice").addClass(errorClass);
					$(element).closest('.btn-file').addClass(errorClass);
					try {
						$.validator.defaults.highlight(element, errorClass, validClass);
					} catch (e) {
						_log(e.message)
					}
				},
				unhighlight: function(element, errorClass, validClass) {
					$(element).prev().find(".select2-choice").removeClass(errorClass);
					$(element).closest('.btn-file').removeClass(errorClass);
					try {
						$.validator.defaults.unhighlight(element, errorClass, validClass);
					} catch (e) {
						_log(e.message)
					}
				}
			}
		});
		$("form#alterarUsuario").rvalidate({
			validate : {
				highlight: function(element, errorClass, validClass) {
					$(element).prev().find(".select2-choice").addClass(errorClass);
					$(element).closest('.btn-file').addClass(errorClass);
					try {
						$.validator.defaults.highlight(element, errorClass, validClass);
					} catch (e) {
						_log(e.message)
					}
				},
				unhighlight: function(element, errorClass, validClass) {
					$(element).prev().find(".select2-choice").removeClass(errorClass);
					$(element).closest('.btn-file').removeClass(errorClass);
					try {
						$.validator.defaults.unhighlight(element, errorClass, validClass);
					} catch (e) {
						_log(e.message)
					}
				}
			}
		});
		$("form#cadastroExame").rvalidate({
			validate: {
				ignore: "",
				highlight: function(element, errorClass, validClass) {
					$(element).prev().find(".select2-choice").addClass(errorClass);
					$(element).closest('.btn-file').addClass(errorClass);
					try {
						$.validator.defaults.highlight(element, errorClass, validClass);
					} catch (e) {
						_log(e.message)
					}
				},
				unhighlight: function(element, errorClass, validClass) {
					$(element).prev().find(".select2-choice").removeClass(errorClass);
					$(element).closest('.btn-file').removeClass(errorClass);
					try {
						$.validator.defaults.unhighlight(element, errorClass, validClass);
					} catch (e) {
						_log(e.message)
					}
				},
				debug: false
			},
			onsuccess: function(a, b, c, d){
				try {
					eval(a);
				} catch (e) {}
				if(a.indexOf("error") == -1){
					$(".select-box-auto-width", d).select2("val", "");
					d.get(0).reset();
				}
			},
			onerror: function(a, b, c, d){
				Common.userNotify.show('<p>Houve um erro no sistema. Atualize a página</p>', 'error', 4000);
			}
		});
		$("form#meuPerfil").rvalidate();
		$("form#enviaExame").rvalidate({
			validate: {
				ignore: "",
				highlight: function(element, errorClass, validClass) {
					$(element).prev().find(".select2-choice").addClass(errorClass);
					$(element).closest('.btn-file').addClass(errorClass);
					try {
						$.validator.defaults.highlight(element, errorClass, validClass);
					} catch (e) {
						_log(e.message)
					}
				},
				unhighlight: function(element, errorClass, validClass) {
					$(element).prev().find(".select2-choice").removeClass(errorClass);
					$(element).closest('.btn-file').removeClass(errorClass);
					try {
						$.validator.defaults.unhighlight(element, errorClass, validClass);
					} catch (e) {
						_log(e.message)
					}
				},
				debug: false
			},
			onstart: function(form){
				try {
					if (CKEDITOR.instances.content) CKEDITOR.instances.content.updateElement();
				} catch (e) {}
			},
			onsuccess: function(a, b, c, d){
				try {
					eval(a);
				} catch (e) {}
				if(a.indexOf("error") == -1){
					d.get(0).reset();
					$(".select-box-medicos, .select-box-pacientes, .select-box-exames", d).select2("val", "");
				}
			},
			onerror: function(a, b, c, d){
				Common.userNotify.show('<p>Houve um erro no sistema. Atualize a página</p>', 'error', 4000);
			}
		});

		$("form#enviaLaudo").rvalidate({
			validate: {
				ignore: ":hidden",
				highlight: function(element, errorClass, validClass) {
					$(element).prev().find(".select2-choice").addClass(errorClass);
					$(element).closest('.btn-file').addClass(errorClass);
					try {
						$.validator.defaults.highlight(element, errorClass, validClass);
					} catch (e) {
						_log(e.message)
					}
				},
				unhighlight: function(element, errorClass, validClass) {
					$(element).prev().find(".select2-choice").removeClass(errorClass);
					$(element).closest('.btn-file').removeClass(errorClass);
					try {
						$.validator.defaults.unhighlight(element, errorClass, validClass);
					} catch (e) {
						_log(e.message)
					}
				}
			},
			onstart: function(form){

				if (CKEDITOR.instances.modelo_content)
					CKEDITOR.instances.modelo_content.updateElement();

				var arquivo = $('#arquivo_selecionados', form).val();
				var impossibilitado = $('#laudo_impossibilitado', form).is(':checked');

				return true;

				var cf = confirm("Verifique todos os Dados do Laudo, após o envio, não será possível alterá-lo.")
				
				if (!cf) {
					return false;
				}
				
				if (!impossibilitado && !arquivo) {
					return confirm("Confirma o Envio do Laudo sem as imagens selecionadas?")
				}
				
				return true;

			},
			onsuccess: function(a, b, c, d){
				try {
					eval(a);
				} catch (e) {}
				if(a.indexOf("error") == -1){
					d.get(0).reset();
				}
			},
			onerror: function(a, b, c, d){

				//Common.userNotify.show('<p>Houve um erro no sistema X. Atualize a página</p>', 'error', 4000);
			}
		});

		
		$(document).on('click', "table tr .remove", function(e){
			e.preventDefault();
			var self = $(this);
			
			var message = "Deseja remover este item?";
			if(self.data('message')){
				message = self.data('message');
			}
			
			if(confirm(message)){
				$.post($(this).attr('href'), function(){
					self.closest('tr').fadeOut(function(){
						$(this).remove();
					});
				}, "script");
			}
		});

		
		$(document).on('click', ".table-list .deactive", function(e){
			e.preventDefault();
			var self = $(this);
			
			var message = "Deseja desabilitar este item?";
			if(self.data('message')){
				message = self.data('message');
			}
			
			if(confirm(message)){
				$.post($(this).attr('href'), function(){
					self.closest('tr').addClass('deactivated');
				}, "script");
			}
		});
		
		$(document).on('click', ".table-list .desativar, .table-list .ativar", function(e){
			e.preventDefault();
			var self = $(this), cf = "Deseja desativar este item?";
			if(self.hasClass('ativar')){
				cf = "Deseja reativar este item?";
			}

			if(self.data('message')){
				cf = self.data('message');
			}
			if(confirm(cf)){
				$.post($(this).attr('href'), function(){
					if(self.hasClass('desativar')){
						self.closest('tr').addClass('warning');
						self.closest('tr').find('.desativar').addClass('hide');
						self.closest('tr').find('.ativar').removeClass('hide');
					}else{
						self.closest('tr').removeClass('warning')
						self.closest('tr').find('.ativar').addClass('hide');
						self.closest('tr').find('.desativar').removeClass('hide');
					}
				}, "script");
			}
		});
		
		$(document).on('change', "#laudo_modelo", function(e){

			e.preventDefault();

			var btnPdf = $("#arquivo_laudo_pdf");

			var value = $(this).val();

			btnPdf.attr('required', value == -2);
				
			if(value){
				
				if (value == -1 || value == -2){
					//$("#modelo_content").attr('disabled', 'disabled');
					CKEDITOR.instances.modelo_content.setData("", function(){
						this.updateElement();
					});
					CKEDITOR.instances.modelo_content.setReadOnly(true);
					return;
				}

				CKEDITOR.instances.modelo_content.setReadOnly(false);
				
				$("#cke_modelo_content").makeLoad();
				$.post(baseUrl + "laudos/modelo", {_id: value}, function(d){
					if (d.length) {

						if (CKEDITOR.instances.modelo_content.getData().trim().length == 0) {
							CKEDITOR.instances.modelo_content.insertHtml( d );
							setTimeout(function(){
								$("#cke_modelo_content").removeLoad();
							}, 500);
							return;
						}

						webix.modalbox({
							title:"Dama Telemedicina",
							buttons:["SIM", "NÃO"],
							text:"Mantém o texto anterior?",
							width:500,
							callback:function(result){
								switch(result){
									case "0": 
										CKEDITOR.instances.modelo_content.insertHtml( d );
										setTimeout(function(){
											$("#cke_modelo_content").removeLoad();
										}, 500);
										break;
									case "1":
										CKEDITOR.instances.modelo_content.setData( d, function(){
											this.updateElement();
											setTimeout(function(){
												$("#cke_modelo_content").removeLoad();
											}, 500);
										});										
										break;
								}
							}
						});

					} else {
						Common.userNotify.show('<p>Esse modelo não possui conteudo, altere-o ou crie um outro. </p>', 'error', 4000);
					}
				});
			}
			
		});
		
		$(document).on('click', "#laudo_impossibilitado", function(){
			var checked = $(this).is(":checked");
			var exame_id = $("#_exame_id").val();
			var btnPdf = $("#arquivo_laudo_pdf");
			if (checked) {
				$("#laudo_imposs_container").show();
				$("#master_container").hide();
				return;
			}
			$("#laudo_imposs_container").hide();
			$("#master_container").show();
		});
		
		//Metodos Novo Cliente

		$(document).on('click', "#exames-cliente .active-deactive", function(e){
			checkActiveDeactive.call(this, this, e);			
		});
		
		$("#exames-cliente .active-deactive").each(function(e){
			checkActiveDeactive.call(this, this, e);			
		});
		
		$(document).on('click', '.add-subtipo-exame', function(e){
			e.preventDefault();
			var id = $(this).data('id'),
				rows = $(this).closest('.sub-tipos-container').find('.row'),
				last_row = rows.last(),
				new_row = Common.render($('#row-sub-template'), {id : id});
			
				if(last_row.length > 0){
					last_row.after(new_row);
				} else {
					try{
						$(this).before(new_row);
					} catch (e) {
						Common.userNotify.show('<p>Erro ao inserir um Subtipo, atualize a página e tente novamente. </p>', 'error', 4000);
					}
				}
				
				rows.first().find('.remove-subtipo-exame').remove();
		})
		
		$(document).on('click', '.remove-subtipo-exame', function(e){
			e.preventDefault();
			
			if(confirm('Deseja realmente remover esse Subtipo? Caso já haja exames para esse subtipo em andamentos, eles não aparecerão nos relatorios!')){
				$(this).closest('.row').remove();
			}
		})
		
		
	});
	
	function checkActiveDeactive(ckx){
		var checked = $(ckx).is(":checked"),
		row = $(ckx).closest('.exame-row');
	
		if(checked){
			row.removeClass('deactive');
			row.find('input,select').removeAttr('disabled');
		}else{
			row.addClass('deactive');
			row.find('input,select').attr('disabled', true);
		}
		
		$(ckx).removeAttr('disabled');
	}
	
	function openWindow(url){
		var janela = window.open(url, "Janela",'width=1000,height=500');
		janela.focus();
		
		return janela;
	}
})(jQuery);


var Common = {};
(function($) {
	 
	Common.userNotify = {};
	Common.userNotify.show = function(msg, c, t, i, r){
		var tpl = '<div id="userNotify" class="alert alert-'+ c +'">\
			<button type="button" class="close" data-dismiss="alert">×</button>\
			<div class="message">'+ msg +'</div>\
		</div>';
			Common.userNotify.remove();
			Common.userNotify.clearInterval();
			Common.userNotify.clearTimeout();
		$('body').append(tpl);
		
		$('#userNotify').fadeIn('slow', function(){
			$('#userNotify').css({marginLeft: 0, width: 'auto'});
		})
		.css('width', $('#userNotify').width()+ 15)
		.css('left', $('body').width()/2 - $('#userNotify').width()/2);

		if(i && t){
			Common.userNotify.interval = setInterval(function(){
				Common.userNotify.showHide(msg, c, t, i);
			}, t);
		}else if(t){
			Common.userNotify.timeout = setTimeout(function(){
				Common.userNotify.destroy();
				if(r){
					r.call(this);
				}
			}, t);
		}
		
		_log('Common.userNotify.show');
	};
	Common.userNotify.showHide = function(msg, c, t, i){
		if($(document).find('#userNotify')[0]){
			Common.userNotify.remove();
		}else{
			Common.userNotify.show(msg, c, t, i);
		}
		_log('Common.userNotify.showHide');
	};
	Common.userNotify.remove = function(){
		if($(document).find('#userNotify')[0]){
			$('#userNotify').remove();
		}
		_log('Common.userNotify.remove');
	};
	Common.userNotify.destroy = function(){
		if($(document).find('#userNotify')[0]){
			Common.userNotify.remove();
			Common.userNotify.clearInterval();
			Common.userNotify.clearTimeout();
		}
		_log('Common.userNotify.destroy');
	};
	Common.userNotify.clearInterval = function(){
		if(!Common.userNotify.interval) return;
		clearInterval(Common.userNotify.interval);
		delete Common.userNotify.interval;
		_log('Common.userNotify.clearInterval');
	};
	Common.userNotify.clearTimeout = function(){
		if(!Common.userNotify.timeout) return;
		clearTimeout(Common.userNotify.timeout);
		delete Common.userNotify.timeout;
		_log('Common.userNotify.clearTimeout');
	};
	
	Common.redirect = function(url){
		var url = base_url + url;
		window.location = url;
	};
	
	Common.render = function(html, vars) {
		var $html = html;
		try {
			$html = $($html);
			if($html.length > 0){
				$html = $html.text();
			}else {
				throw new Error('Elemento Invalido');
			}
		} catch (e) {
			$html = html;
		}
		
		for ( var i in vars) {
			var _var = vars[i],
				_regExp = new RegExp('#'+i.toUpperCase()+'#', 'g');
			
			$html = $html.replace(_regExp, _var);
		}

		return $html;
	}
})(jQuery);
/**
 * jQuery(element).makeLoad
 * Create Load mask over the element
 */
;(function($){

	if ($("#_exame_id").val() == 10) {
		$("#modelo_content").attr('disabled', 'disabled');
	}

	$.extend($.fn, {
		makeLoad: function(e){
			var $target = $(this);
			var $mask = createMask();
			$('body').css('cursor', 'progress');
			
			$target.data('loading', true);
			if($target.css('position') != 'absolute')
				$target.css('position', 'relative');
			$target.append($mask);
			$mask.fadeIn();
			
		},
		removeLoad: function(e){
			var $target = $(this);
			removeMask($target);
			$('body').css('cursor', 'default');
			$(this).data('loading', false);
			
			return $target;
		}
	});
	function createMask(){
		return $('<div></div>')
			.addClass('modal-backdrop')
			.addClass('loading');
	}
	
	function removeMask(parent){
		$('.loading', parent).fadeOut(function(){
			$(this).remove();
		});
	}
})(jQuery);