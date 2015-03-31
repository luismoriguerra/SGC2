var equivalenciaDAO = {
    url: '../controlador/controladorSistema.php',
    comando: 'equivalencia',
    cargarCarreras: function(fxllena,slct_dest,id_slct) {
        $.ajax({
            url: this.url,
            type: 'POST',
            async: false, //no ejecuta otro ajax hasta q este termine
            dataType: 'json',
            data: {
                comando: this.comando,
                action: 'cargarCarreras',
                cinstit: $('#slct_instituto').val(),
                
                cusuari: $('#hd_idUsuario').val(),
                cfilialx: $('#hd_idFilial').val()
            },
            beforeSend: function( ) {
               // sistema.abreCargando();
            },
            success: function(obj) {
               // sistema.cierraCargando();
               if( obj.length!=0 ){
                    fxllena(obj.data,slct_dest,id_slct);					
                }
            },
            error: this.msjErrorAjax
        });
    },
    cargarCarreras_asig: function(id , fxllena,slct_dest,id_slct) {
        $.ajax({
            url: this.url,
            type: 'POST',
            async: false, //no ejecuta otro ajax hasta q este termine
            dataType: 'json',
            data: {
                comando: this.comando,
                action: 'cargarCarreras',
                cinstit: $('#slct_instituto_asig_'+id).val(),
                
                cusuari: $('#hd_idUsuario').val(),
                cfilialx: $('#hd_idFilial').val()
            },
            beforeSend: function( ) {
               // sistema.abreCargando();
            },
            success: function(obj) {
               // sistema.cierraCargando();
               if( obj.length!=0 ){
                    fxllena(obj.data,slct_dest,id_slct);					
                }
            },
            error: this.msjErrorAjax
        });
    },
    cargarCurriculas: function(fxllena,slct_dest,id_slct) {
        $.ajax({
            url: this.url,
            type: 'POST',
            async: false, //no ejecuta otro ajax hasta q este termine
            dataType: 'json',
            data: {
                comando: this.comando,
                action: 'cargarCurriculas',
                cinstit: $('#slct_instituto').val(),
                ccarrer: $('#slct_carrera').val(),
                
                cusuari: $('#hd_idUsuario').val(),
                cfilialx: $('#hd_idFilial').val()
            },
            beforeSend: function( ) {
               // sistema.abreCargando();
            },
            success: function(obj) {
               // sistema.cierraCargando();
               if( obj.length!=0 ){
                    fxllena(obj.data,slct_dest,id_slct);					
                }
            },
            error: this.msjErrorAjax
        });
    },
    cargarCurriculas_asig: function(id,fxllena,slct_dest,id_slct) {
        $.ajax({
            url: this.url,
            type: 'POST',
            async: false, //no ejecuta otro ajax hasta q este termine
            dataType: 'json',
            data: {
                comando: this.comando,
                action: 'cargarCurriculas',
                cinstit: $('#slct_instituto_asig_'+id).val(),
                ccarrer: $('#slct_carrera_asig_'+id).val(),
                
                cusuari: $('#hd_idUsuario').val(),
                cfilialx: $('#hd_idFilial').val()
            },
            beforeSend: function( ) {
               // sistema.abreCargando();
            },
            success: function(obj) {
               // sistema.cierraCargando();
               if( obj.length!=0 ){
                    fxllena(obj.data,slct_dest,id_slct);					
                }
            },
            error: this.msjErrorAjax
        });
    },
    cargarModulos: function(fxllena,slct_dest,id_slct) {
        $.ajax({
            url: this.url,
            type: 'POST',
            async: false, //no ejecuta otro ajax hasta q este termine
            dataType: 'json',
            data: {
                comando: this.comando,
                action: 'cargarModulos',
                //cinstit: $('#slct_instituto').val(),
                ccarrer: $('#slct_carrera').val(),
                
                cusuari: $('#hd_idUsuario').val(),
                cfilialx: $('#hd_idFilial').val()
            },
            beforeSend: function( ) {
               // sistema.abreCargando();
            },
            success: function(obj) {
               // sistema.cierraCargando();
               if( obj.length!=0 ){
                    fxllena(obj.data,slct_dest,id_slct);					
                }
            },
            error: this.msjErrorAjax
        });
    },
    cargarModulos_asig: function(id,fxllena,slct_dest,id_slct) {
        $.ajax({
            url: this.url,
            type: 'POST',
            async: false, //no ejecuta otro ajax hasta q este termine
            dataType: 'json',
            data: {
                comando: this.comando,
                action: 'cargarModulos',
                //cinstit: $('#slct_instituto').val(),
                ccarrer: $('#slct_carrera_asig_'+id).val(),
                
                cusuari: $('#hd_idUsuario').val(),
                cfilialx: $('#hd_idFilial').val()
            },
            beforeSend: function( ) {
               // sistema.abreCargando();
            },
            success: function(obj) {
               // sistema.cierraCargando();
               if( obj.length!=0 ){
                    fxllena(obj.data,slct_dest,id_slct);					
                }
            },
            error: this.msjErrorAjax
        });
    },
    cargarCursos: function(fxllena,slct_dest,id_slct) {
        $.ajax({
            url: this.url,
            type: 'POST',
            async: false, //no ejecuta otro ajax hasta q este termine
            dataType: 'json',
            data: {
                comando: this.comando,
                action: 'cargarCursos',
                //cinstit: $('#slct_instituto').val(),
                ccurric: $('#slct_curricula').val(),
                cmodulo: $('#slct_modulo').val(),
                
                cusuari: $('#hd_idUsuario').val(),
                cfilialx: $('#hd_idFilial').val()
            },
            beforeSend: function( ) {
               // sistema.abreCargando();
            },
            success: function(obj) {
               // sistema.cierraCargando();
               if( obj.length!=0 ){
                    fxllena(obj.data,slct_dest,id_slct);					
                }
            },
            error: this.msjErrorAjax
        });
    },
    cargarCursos_asig: function(id, fxllena,slct_dest,id_slct) {
        $.ajax({
            url: this.url,
            type: 'POST',
            async: false, //no ejecuta otro ajax hasta q este termine
            dataType: 'json',
            data: {
                comando: this.comando,
                action: 'cargarCursos',
                //cinstit: $('#slct_instituto').val(),
                ccurric: $('#slct_curricula_asig_'+id).val(),
                cmodulo: $('#slct_modulo_asig_'+id).val(),
                
                cusuari: $('#hd_idUsuario').val(),
                cfilialx: $('#hd_idFilial').val()
            },
            beforeSend: function( ) {
               // sistema.abreCargando();
            },
            success: function(obj) {
               // sistema.cierraCargando();
               if( obj.length!=0 ){
                    fxllena(obj.data,slct_dest,id_slct);					
                }
            },
            error: this.msjErrorAjax
        });
    },
    addEquivalencia: function(actas){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
                comando:this.comando,
            	action:'addEquivalencia',
                post:{
                	comando:this.comando,
                	action:'addEquivalencia',
                    actas: actas,
                    ccurric:$('#slct_curricula').val(),
                    cmodulo :$('#slct_modulo').val(),
                    ccurso :$("#slct_curso").val() ,
                    estide :$("#slct_tequi").val() ,
                    cusuari:$('#hd_idUsuario').val(),
		          cfilialx:$('#hd_idFilial').val()
                }
            },
            beforeSend : function ( ) {
                 sistema.abreCargando();
            },
            success : function ( obj ) {
                 sistema.cierraCargando();
                if(obj.rst=='1'){
                
                    $('#frmEquivalencia').dialog('close');
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
    EditarEquivalencia: function(actas){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
                comando:this.comando,
            	action:'EditarEquivalencia',
                post:{
                  id :$('#gruequi').val(),
                  ccurric:$('#slct_curricula').val(),
                  cmodulo :$('#slct_modulo').val(),
                  ccurso :$("#slct_curso").val() ,
                  actas :actas,
                  estide :$("#slct_tequi").val() ,
                  cusuari:$('#hd_idUsuario').val(),
                  cfilialx:$('#hd_idFilial').val()
                }
            },
            beforeSend : function ( ) {
                 sistema.abreCargando();
            },
            success : function ( obj ) {
                 sistema.cierraCargando();
                if(obj.rst=='1'){
                    $('#frmEquivalencia').dialog('close');
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
    EliminarEquivalencia: function(id){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
                comando:this.comando,
            	action:'EliminarEquivalencia',
                post:{
                  id :id,
                  cusuari:$('#hd_idUsuario').val(),
                  cfilialx:$('#hd_idFilial').val()
                }
            },
            beforeSend : function ( ) {
                 sistema.abreCargando();
            },
            success : function ( obj ) {
                 sistema.cierraCargando();
                if(obj.rst=='1'){
                    $('#frmEquivalencia').dialog('close');
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
    msjErrorAjax: function() {
        sistema.msjErrorCerrar('Error General, pongase en contacto con Sistemas');
    }
}