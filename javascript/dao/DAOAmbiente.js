var ambienteDAO={
	url:'../controlador/controladorSistema.php',
    cargarTipoAmbiente: function(fxllena,slct_dest,id_slct){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
                comando:'ambiente',
                action:'cargarTipoAmbiente',
            },
            beforeSend : function ( ) {
            },
            success : function ( obj ) {
                if( obj.rst==1 ){
                    fxllena(obj.data,slct_dest,id_slct);
                }
            },
            error: this.msjErrorAjax
        });
    },
	addAmbiente: function(){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'ambiente',
            	action:'addAmbiente',
                cfilial:$('#slct_filial').val().join(','),
                ctipamb :$('#slct_tipo_ambiente').val(),                
                numamb :$('#txt_nro_ambiente').val(),
                ncapaci :$('#txt_capacidad').val(),
                nmetcua :$('#txt_metroscuadrados').val(),
                ntotmaq :$('#txt_maquinas').val(),
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
                    $('#frmAmbiente').dialog('close');
                    $("#table_ambiente").trigger('reloadGrid');
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
    editAmbiente: function(){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'ambiente',
            	action:'editAmbiente',
                id:$('#id_ambiente').val(),
                cfilial:$('#slct_filial_edit').val(),
                ctipamb :$('#slct_tipo_ambiente').val(),                
                numamb :$('#txt_nro_ambiente').val(),
                ncapaci :$('#txt_capacidad').val(),
                nmetcua :$('#txt_metroscuadrados').val(),
                ntotmaq :$('#txt_maquinas').val(),
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
                    $('#frmAmbiente').dialog('close');
                    $("#table_ambiente").trigger('reloadGrid');
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