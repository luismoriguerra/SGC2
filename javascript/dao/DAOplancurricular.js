var curriculaDAO={
	url:'../controlador/controladorSistema.php',
    cargarCurricula: function(fxllena,slct_dest,id_slct){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'curricula',
				action:'cargar_curricula',
				ctipcar:$("#slct_tipo_carrera").val(),
				cmodali:$("#slct_modalidad").val(),
                cinstit:$('#slct_instituto').val(),
				cfilialx:$('#hd_idFilial').val()            	
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
    
    cargarPlancurricular: function(evento){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
			comando:'curricula',
			action:'cargarPlancurricular',
			ccur:$("#slct_curricula").val() , 
			cmod:$("#slct_modulo").val(),
			ccarrer:$("#slct_carrera").val(),
			cusuari:$('#hd_idUsuario').val(),
			cfilialx:$('#hd_idFilial').val()
            },
            beforeSend : function ( ) {
            },
            success : function ( obj ) {
                if(obj.rst=='1'){
		evento(obj.data);
                }else if(obj.rst=='2'){
		$("#valPlancurricular .ListaCursos").remove();
                }else{
                    //sistema.msjErrorCerrar(obj.msj);
				}
            },
            error: this.msjErrorAjax
        });
    },

    listarPlanCurricular: function(evento){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            comando:'curricula',
            action:'listarPlanCurricular',            
            cingalu:$('#txt_cingalu').val()
            },
            beforeSend : function ( ) {
            },
            success : function ( obj ) {
                if(obj.rst=='1'){
                evento(obj.data);
                }
            },
            error: this.msjErrorAjax
        });
    },
	
        GuardarPlancurricular: function(){
            var reqs = "";
            jQuery('#slct_req\\[\\]').each(function(i,e){
            if( reqs == "" ){
            reqs = e.value;
            }else{
            reqs +="|"+e.value;
            }});
            
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'curricula',
            	action:'guardar_plancurricular',
                
                ccurri:$("#slct_curricula").val(),
                ccurso:$("#slct_curso").val(),
                cmodul:$("#slct_modulo").val(),

                //creando cadena de cursos requeridos
                ccurre:reqs,
                ncredi:$("#txt_nro_creditos").val(),
                nroteo:$("#txt_nro_teo").val(),
                nropra:$("#txt_nro_pra").val(),
                estado:$("#slct_estado").val(),
                
		ccarrer:$("#slct_carrera").val(),
		dmodulo:$("#txt_des_nuevo").val(),
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
		 ValidaPlancurricular();
                }else if(obj.rst=='2'){
                    sistema.msjAdvertencia(obj.msj,3000);
                }else{
                    sistema.msjErrorCerrar(obj.msj);
                }
            },
            error: this.msjErrorAjax
        });
	},
      
    ActualizarPlancurricular: function(){
            var reqs = "";
            jQuery('#slct_req\\[\\]').each(function(i,e){
            if( reqs == "" ){
            reqs = e.value;
            }else{
            reqs +="|"+e.value;
            }});
       
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'curricula',
            	action:'actualizar_plancurricular',
                
                ccurri:$("#slct_curricula").val(),
                cmodul:$("#slct_modulo").val(),
                ccurso:$("#slct_curso").val(),
                
                //creando cadena de cursos requeridos
                ccurre:reqs,
                ncredi:$("#txt_nro_creditos").val(),
                nroteo:$("#txt_nro_teo").val(),
                nropra:$("#txt_nro_pra").val(),
                estado:$("#slct_estado").val(),
                
		ccarrer:$("#slct_carrera").val(),
		dmodulo:$("#txt_des_nuevo").val(),
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
                        ValidaPlancurricular();
                }else if(obj.rst=='2'){
                    sistema.msjAdvertencia(obj.msj,3000);
                }else{
                    sistema.msjErrorCerrar(obj.msj);
                }
            },
            error: this.msjErrorAjax
        });
	},
    
    
    GuardarCurricular: function(){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'curricula',
            	action:'guardar_curricular',

				ccarrer:$("#slct_carrera").val(),
				dtitulo:$("#txt_nc_titulo").val(),
                dresolu:$("#txt_nro_resolu").val(),
                
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
		
                }else if(obj.rst=='2'){
                    sistema.msjAdvertencia(obj.msj,3000);
                }else{
                    sistema.msjErrorCerrar(obj.msj);
                }
            },
            error: this.msjErrorAjax
        });
	},
    
        
}