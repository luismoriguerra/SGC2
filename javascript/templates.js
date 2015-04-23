var templates={
	msjOk:function(msj){
		var html='<div class="msjOk sombra-3d2 corner-bottom t-14" style="display:inline-block;">';
		html+=		'<i class="icon-gray icon-ok-sign" style="float:left"></i><span style="padding-left:10px">'+msj+'</span>';
		html+=	 '</div>';
		return html;
	},
	msjAdvertencia:function(msj){
		var html='<div class="msjAdvertencia sombra-3d2 corner-bottom t-12" style="display:inline-block;">';
		html+=		'<i class="icon-gray icon-exclamation-sign" style="float:left"></i><span style="padding-left:10px">'+msj+'</span>';
		html+=	 '</div>';
		return html;
	},
	msjAdvertenciaCerrar:function(msj){
		//var html='<div class="msjAdvertencia sombra-3d2 corner-bottom t-12" style="display:inline-block;">';
		var html='<div class="msjAdvertencia sombra-3d2 corner-bottom t-13 t-left" style="min-height:23px;width:auto;padding: 5px 22px 3px 5px;max-height:500px;overflow:auto;">';
		html+=		'<p">'+msj+'</p>';
		html+=		'<i onclick="sistema.slide(\'capaMensaje\')" class="icon-gray icon-remove btn_i" style="position: absolute; right: 3px; top: 3px;"></i>';
		html+=	 '</div>';
		return html;
	},
	msjError:function(msj){
		var html='<div class="msjError sombra-3d2 corner-bottom t-14" style="display:inline-block;">';
		html+=		'<i class="icon-white icon-remove-sign" style="float:left"></i><span style="padding-left:10px">'+msj+'</span>';
		html+=	 '</div>';
		return html;
	},
	msjErrorCerrar:function(msj){
        var html='<div class="msjError sombra-3d2 corner-bottom t-13 t-left" style="min-height:23px;width:auto;padding: 5px 22px 3px 5px;">';
		html+=		'<p>'+msj+'</p>';
		html+=		'<i onclick="sistema.slide(\'capaMensaje\')" class="icon-white icon-remove btn_i" style="position: absolute; right: 3px; top: 3px;"></i>';
		html+=	 '</div>';
        return html;
    }
}