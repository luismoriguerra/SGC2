var horaDAO={
	url:'../controlador/controladorSistema.php',
	addHora: function(){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'hora',
            	action:'addHora',
                cinstit:$('#slct_instituto').val(),
                cturno :$('#slct_turno').val(),
                hinici :$("#txt_hini").val() + ":" + $("#txt_mini").val(),
                hfin   :$("#txt_hfin").val() + ":" + $("#txt_mfin").val(),
                thorari:$("#slct_thorari").val(),
                thora  :$("#slct_chora").val(),
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
                    $('#frmHora').dialog('close');
                    $("#table_hora").trigger('reloadGrid');
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
    editHora: function(){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'hora',
            	action:'editHora',
                id:$('#id_hora').val(),
                cinstit:$('#slct_instituto').val(),
                cturno :$('#slct_turno').val(),
                hinici :$("#txt_hini").val() + ":" + $("#txt_mini").val(),
                hfin   :$("#txt_hfin").val() + ":" + $("#txt_mfin").val(),
                thorari:$("#slct_thorari").val(),
                thora  :$("#slct_chora").val(),
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
                    $('#frmHora').dialog('close');
                    $("#table_hora").trigger('reloadGrid');
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