var loginDAO={
	url:'../controlador/controladorSistema.php',
	login:function(){
		$.ajax({
			url : this.url,
            type : 'POST',
            dataType : 'json',
			data:{
				comando:'login',
				accion:'login',
				user:$('#txt_usuario').val(),
				pass:$('#txt_password').val()
			},
			beforeSend:function(){
				sistema.abreCargando();
			},
			success:function(obj){
				sistema.cierraCargando();
				if(obj.rst=='1'){
					window.location.href='vst-inicio.php';
					//window.location.href='vst-configuracion-encuesta.php';
				}else{
					$('#mensaje').html('<span style="background:rgba(0,0,0,0.8);padding:3px 5px;">'+obj.msj+'</span>');
				}
			},
			error:function(){
				sistema.cierraCargando();
				$('#mensaje').html('<span style="background:rgba(255,0,0,0.8);padding:3px 5px;color:#fff">Error General Ajax, comuniquese con Sistemas</span>');
			}
		})
	}
}