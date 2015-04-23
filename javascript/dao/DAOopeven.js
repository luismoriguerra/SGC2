var cencapDAO={
	url:'../controlador/controladorSistema.php',
    cargarFiliales: function(fxllena,slct_dest,id_slct){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'cencap',
            	action:'cargarFiliales'
            },
            beforeSend : function ( ) {
            },
            success : function ( obj ) {
                fxllena(obj.data,slct_dest,id_slct);
            },
            error: this.msjErrorAjax
        });
    },
	cargarInstitutos: function(fxllena,slct_dest,id_slct){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'cencap',
            	action:'cargarInstitutos'
            },
            beforeSend : function ( ) {
            },
            success : function ( obj ) {				
            	fxllena(obj.data,slct_dest,id_slct);
            },
            error: this.msjErrorAjax
        });
    },
	ListarCencap: function(fxllena,slct_dest,id_slct){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:true,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'cencap',
            	action:'ListCencap',
				cfilial:$("#hd_idFilial").val()
            },
            beforeSend : function ( ) {
            },
            success : function ( obj ) {
                if( obj.length!=0 ){
                    fxllena(obj.data,slct_dest,id_slct);
                }
            },
            error: this.msjErrorAjax
        });
    },
	addCencap: function(){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'opeven',
            	action:'addOpeven',
                descrip:$('#txt_dopeven').val(),
                 depa:$('#slct_depa').val(),
                 prov:$("#slct_prov").val(),
                 dist:$("#slct_dist").val(),
                 direc:$('#txt_direc').val(),
                 tipo:$("#slct_tipo").val(),
                 cestado:$("#slct_estado").val(),
                   
                cusuari:$("#hd_idUsuario").val(),
                cfilialx:$("#hd_idFilial").val()
            },
            beforeSend : function ( ) {
                 sistema.abreCargando();
            },
            success : function ( obj ) {
                 sistema.cierraCargando();
                if(obj.rst=='1'){
                    $('#frmCencap').dialog('close');
                    $("#table_cencap").trigger('reloadGrid');
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
    editCencap: function(){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'opeven',
            	action:'editOpeven',
                id: $('#id_copeven').val(),
                descrip:$('#txt_dopeven').val(),
                 depa:$('#slct_depa').val(),
                 prov:$("#slct_prov").val(),
                 dist:$("#slct_dist").val(),
                 direc:$('#txt_direc').val(),
                 tipo:$("#slct_tipo").val(),
                 cestado:$("#slct_estado").val(),
				cusuari:$("#hd_idUsuario").val(),
				cfilialx:$("#hd_idFilial").val()
            },
            beforeSend : function ( ) {
                 sistema.abreCargando();
            },
            success : function ( obj ) {
                 sistema.cierraCargando();
                if(obj.rst=='1'){
                    $('#frmCencap').dialog('close');
                    $("#table_cencap").trigger('reloadGrid');
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