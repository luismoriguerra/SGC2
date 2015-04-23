var cursoDAO={
	url:'../controlador/controladorSistema.php',
    cargarCursos: function(fxllena,slct_dest,id_slct){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'curso',
            	action:'cargarCurso',
				cinstit:$("#slct_instituto").val(),
				ctipcar:'2' //profesional
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
	/*InsertarCurso: function(){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
                comando:'curso',
                accion:'Insertar_Curso',
				cinstit:$("#slct_instituto").val(),
				ctipcar:'2', //profesional
				dcurso:$('#txt_NuevoCurso').val(),
				dnemoni:$('#txt_NuevoAbrev').val(),
                cusuari:$('#hd_idUsuario').val(),
				cfilialx:$('#hd_idFilial').val()
            },
            beforeSend : function ( ) {
                sistema.abreCargando();
            },
            success : function ( obj ) {
                sistema.cierraCargando();
                if(obj.rst=='1'){
                    sistema.msjOk(obj.msj);
					cursoDAO.cargarCursos(sistema.llenaSelect,'slct_curso',obj.ccurso);
					CancelarNuevoCurso();
                }else if(obj.rst=='2'){
                    sistema.msjAdvertencia(obj.msj,3000);
                }else{
                    sistema.msjErrorCerrar(obj.msj);
                }
            },
            error: this.msjErrorAjax
        });
	},	
	ActualizarCurso: function(){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
                comando:'curso',
                accion:'Actualiza_Curso',
				cinstit:$("#slct_instituto").val(),
				ctipcar:'2', //profesional
				ccurso:$("#slct_curso").val(),
				dcurso:$('#txt_ModifCurso').val(),
				dnemoni:$('#txt_ModifAbrev').val(),
                cusuari:$('#hd_idUsuario').val(),
				cfilialx:$('#hd_idFilial').val()
            },
            beforeSend : function ( ) {
                sistema.abreCargando();
            },
            success : function ( obj ) {
                sistema.cierraCargando();
                if(obj.rst=='1'){
                    sistema.msjOk(obj.msj);
					cursoDAO.cargarCursos(sistema.llenaSelect,'slct_curso',obj.ccurso);
					CancelarModifCurso();
                }else if(obj.rst=='2'){
                    sistema.msjAdvertencia(obj.msj,3000);
                }else{
                    sistema.msjErrorCerrar(obj.msj);
                }
            },
            error: this.msjErrorAjax
        });
	},*/
	msjErrorAjax:function(){
        sistema.msjErrorCerrar('Error General, pongase en contacto con Sistemas');
    }
}