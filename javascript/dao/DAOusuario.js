var usuarioDAO={
	url:'../controlador/controladorSistema.php',
	modificarUsuario:function(){
        $.ajax({
            url : this.url,
            type : 'POST',
            dataType : 'json',
            data : {
                comando:'usuario',
                accion:'modificar_usuario',
                idusuario:$('#txtIdUsuario').val(),
                nombres:$('#txtNombres').val(),
                paterno:$('#txtPaterno').val(),
                materno:$('#txtMaterno').val(),
                dni:$('#txtDni').val(),
                estado:$('#slctEstado').val(),
                usuario: $('#hd_idUsuario').val()
            },
            beforeSend : function ( ) {
            },
            success : function ( obj ) {
                if(obj.rst=='1'){
                    $('#frmUsuario').dialog('close');
                    sistema.msjOk(obj.msj);
                    $("#table_usuario").trigger('reloadGrid');
                }else if(obj.rst=='2'){
                    sistema.msjAdvertencia(obj.msj);
                }else{
                    sistema.msjErrorCerrar(obj.msj);
                }
            },
            error: this.msjErrorAjax
        });
    },  
	nuevoUsuario:function(){
        $.ajax({
            url : this.url,
            type : 'POST',
            dataType : 'json',
            data : {
                comando:'usuario',
                accion:'nuevo_usuario',
                nombres:$('#txtNombres').val(),
                paterno:$('#txtPaterno').val(),
                materno:$('#txtMaterno').val(),
                dni:$('#txtDni').val(),
                estado:$('#slctEstado').val(),
                usuario: $('#hd_idUsuario').val()
            },
            beforeSend : function ( ) {
            },
            success : function ( obj ) {
                if(obj.rst=='1'){
                    $('#frmUsuario').dialog('close');
                    sistema.msjOk(obj.msj);
                    $("#table_usuario").trigger('reloadGrid');
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