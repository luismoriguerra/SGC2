var opcsistDAO={
	url:'../controlador/controladorSistema.php',
	addOpcSist: function(){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'opcsist',
            	action:'addOpcSist',
                dopcion:$('#txt_descrip').val(),
                durlopc:$('#txt_url').val(),
                dcoment:$('#txt_coment').val(),
                cestado:$("#slct_estado").val(),
                cusuari:$('#hd_idUsuario').val(),
				cfilialx:$('#hd_idFilial').val()
            },
            beforeSend : function ( ) {
                 sistema.abreCargando();
            },
            success : function ( obj ) {
                 sistema.cierraCargando();
                if(obj.rst=='1'){
                    $('#frmOpcSist').dialog('close');
                    $("#table_opcsist").trigger('reloadGrid');
                    sistema.msjOk(obj.msj);					
                }else if(obj.rst=='2'){
                    sistema.msjAdvertencia(obj.msj,3000);
                }else{
                    sistema.msjErrorCerrar(obj.msj);
                }
            },
            error: this.msjErrorAjax
        });
    },
    editOpcSist: function(){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'opcsist',
            	action:'editOpcSist',
                id:$('#id_opcion').val(),
                dopcion:$('#txt_descrip').val(),
                durlopc:$('#txt_url').val(),
                dcoment:$('#txt_coment').val(),
                cestado:$("#slct_estado").val(),
                cusuari:$('#hd_idUsuario').val(),
				cfilialx:$('#hd_idFilial').val()
            },
            beforeSend : function ( ) {
                 sistema.abreCargando();
            },
            success : function ( obj ) {
                 sistema.cierraCargando();
                if(obj.rst=='1'){
                    $('#frmOpcSist').dialog('close');
                    $("#table_opcsist").trigger('reloadGrid');
                    sistema.msjOk(obj.msj);
					
                }else if(obj.rst=='2'){
                    sistema.msjAdvertencia(obj.msj,3000);
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