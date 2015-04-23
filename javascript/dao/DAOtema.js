var temaDAO={
	url:'../controlador/controladorSistema.php',
	cargarTema:function(fxllena,slct_dest,id_slct,txt){
        $.ajax({
            url : this.url,
            type : 'POST',
            dataType : 'json',
            data : {
                comando:'tema',
                accion:'cargar_temas',
                idencuesta:$('#idencuesta').val()
            },
            beforeSend : function ( ) {
            },
            success : function ( obj ) {
                if(obj.rst=='1'){
                    fxllena(obj.data,slct_dest,id_slct,txt);
                }else if(obj.rst=='2'){
                    sistema.msjAdvertencia(obj.msj);
                }else{
                    sistema.msjErrorCerrar(obj.msj);
                }
            },
            error: this.msjErrorAjax
        });
    }, 
	msjErrorAjax:function(){
		sistema.msjErrorCerrar('Error General, pongase en contacto con Sistemas');
	}
}