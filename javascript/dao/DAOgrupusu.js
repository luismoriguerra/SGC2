var grupusuDAO={
	url:'../controlador/controladorSistema.php',
	addGrupUsu: function(){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'grupusu',
            	action:'addGrupUsu',
                dgrupo:$('#txt_descrip').val(),
				cinstit:$("#slct_instituto").val(),
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
                    $('#frmGrupUsu').dialog('close');
                    $("#table_grupusu").trigger('reloadGrid');
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
    modificarPass:function(){
        $.ajax({
            url : this.url,
            type : 'POST',
            dataType : 'json',
            data : {
                comando:'grupusu',
                action:'modificarPass',
                pass: $("#txt_pass").val(),
                cusuari:$('#hd_idUsuario').val(),
                cfilialx:$('#hd_idFilial').val()
            },
            beforeSend : function ( ) {
            },
            success : function ( obj ) {
                if(obj.rst=='1'){                   
                    sistema.msjOk(obj.msj);      
                    alert('Ingrese nuevamente');
                    window.location.href='../vista/close.php';
                }else if(obj.rst=='2'){
                    sistema.msjAdvertencia(obj.msj);
                }else{
                    sistema.msjErrorCerrar(obj.msj);
                }
            },
            error: this.msjErrorAjax
        });
    },  
    editGrupUsu: function(){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'grupusu',
            	action:'editGrupUsu',
                cgrupo:$('#id_grupom').val(),
                dgrupo:$('#txt_descrip').val(),
				cinstit:$("#slct_instituto").val(),
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
                    $('#frmGrupUsu').dialog('close');
                    $("#table_grupusu").trigger('reloadGrid');
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
    cargarGrupos: function(fxllena,slct_dest,id_slct){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'grupusu',
            	action:'cargar_grupos'
            },
            beforeSend : function ( ) {
            },
            success : function ( obj ) {
                fxllena(obj.data,slct_dest,id_slct);
            },
            error: this.msjErrorAjax
        });
    },
    cargarModulos: function(fxllena,slct_dest,id_slct){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'grupusu',
            	action:'cargar_modulos'
            },
            beforeSend : function ( ) {
            },
            success : function ( obj ) {
                fxllena(obj.data,slct_dest,id_slct);
            },
            error: this.msjErrorAjax
        });
    },
    cargarOpciones: function(fxllena,slct_dest,id_slct){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'grupusu',
            	action:'cargar_opciones'
            },
            beforeSend : function ( ) {
            },
            success : function ( obj ) {
                fxllena(obj.data,slct_dest,id_slct);
            },
            error: this.msjErrorAjax
        });
    },
    addGrUsuOp: function(){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'grupusu',
            	action:'addGrUsuOp',
                cgrupo:$('#slct_grupo').val(),
                ccagrop:$('#slct_cagrop').val(),
                copcion:$('#slct_opcion').val(),
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
                    $('#frmGrUsuOp').dialog('close');
                    $("#table_grusuop").trigger('reloadGrid');
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
    editGrUsuOp: function(){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'grupusu',
            	action:'editGrUsuOp',
                cgrupo:$('#id_grupom').val(),
                cgrupo:$('#slct_grupo').val(),
                ccagrop:$('#slct_cagrop').val(),
                copcion:$('#slct_opcion').val(),
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
                    $('#frmGrUsuOp').dialog('close');
                    $("#table_grusuop").trigger('reloadGrid');
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