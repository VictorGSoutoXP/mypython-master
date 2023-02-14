function notificationsAvaliable() {
	try {
		if (webkitNotifications !== undefined)
			return true;
	} catch (e) {
	}
	return false;
}

var notID = 0;
var Notification = function(){
	var self = this;
	
	self.pusher = null;
	
	self.pusher_channel = null;
	
	self.init = function(){

		if(notificationsAvaliable()){
			
			if(!self.checkPermission()){
				Common.userNotify.show('Clique aqui para ativar Notificacoes de Novos Exames.', 'info request-permission', 50000);
				$('.request-permission').one('click', function(){
					window.webkitNotifications.requestPermission(function(e){
						if(!self.checkPermission()){
							alert('OK. Você não irá receber nenhuma notificação, para verificar novos exames acesse o sistema periodicamente.')
						}
					});
					Common.userNotify.destroy();
				})
			}
		}
	}
	
	self.initPusher = function(){
		if(pusher_key && pusher_channel){
			self.pusher = new Pusher(pusher_key);
			self.pusher_channel = self.pusher.subscribe(pusher_channel);
			self.pusher_channel.bind('new_notification', function(data) {
				if (data.content && data.title) {
					var callback = null;
					if(data.gotourl){
						callback = function(e){
							_log(e, data);
							window.location = data.gotourl;
							window.focus(); 
							this.cancel();
						}
					}
					self.createNotification(data.icon, data.title, data.content, callback);
					
					self.updateCountBadge();
				}
		    });
		}
	}
	
	self.updateCountBadge = function(){
		var el = $('.badge-exames-top .badge');
		var current = parseInt(el.text());
		current++;
		
		el.text(current);
	}
	

	this.init();
	this.initPusher();
}

Notification.prototype.checkPermission = function(){
	return window.webkitNotifications.checkPermission() == 0;
}

Notification.prototype.requestPermission = function(callback){
	if (this.checkPermission() != 0) {
	    window.webkitNotifications.requestPermission(callback);
	  }
}

Notification.prototype.createNotification = function(icon, title, content, callback){
	if (window.webkitNotifications.checkPermission() == 0) {
	    // function defined in step 2
	    var notification = window.webkitNotifications.createNotification(icon, title, content);
	    
	    if(typeof callback == "function"){
	    	notification.onclick = callback;
	    }
	    
	    notification.show();
	    
	  } else {
	    window.webkitNotifications.requestPermission();
	  }
}

;(function($){
	$(function(){
		window.n = new Notification();
	})
})(jQuery);
