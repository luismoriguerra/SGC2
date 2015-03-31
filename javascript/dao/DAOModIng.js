var modingDAO={
	url:'../controlador/controladorSistema.php',
	addModIng: function(){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'moding',
            	action:'addModIng',
                dmoding:$('#txt_descrip').val(),
                cinstit:$('#slct_instituto').val(),
                cestado:$("#slct_estado").val(),
				treqcon:$("#slct_tipo").val(),
                cusuari:$('#hd_idUsuario').val(),
				cfilialx:$('#hd_idFilial').val()
            },
            beforeSend : function ( ) {
                 sistema.abreCargando();
            },
            success : function ( obj ) {
                 sistema.cierraCargando();
                if(obj.rst=='1'){
                    $('#frmModIng').dialog('close');
                    $("#table_moding").trigger('reloadGrid');
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
    editModIng: function(){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'moding',
            	action:'editModIng',
                id:$('#id_opcion').val(),
                dmoding:$('#txt_descrip').val(),
                cinstit:$('#slct_instituto').val(),
				treqcon:$("#slct_tipo").val(),
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
                    $('#frmModIng').dialog('close');
                    $("#table_moding").trigger('reloadGrid');
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