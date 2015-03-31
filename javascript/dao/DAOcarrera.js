var carreraDAO={
	url:'../controlador/controladorSistema.php',
    cargaAmbiente: function(fxllena,slct_dest,id_slct){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
                comando:'carrera',
                accion:'cargaAmbiente',
                cfilial:$("#slct_filial").val(),
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
    
    cargarCarrera: function(fxllena,slct_dest,id_slct){
		var cfil="";
		if($("#slct_local_estudio").val()!=""){
		cfil=$("#slct_local_estudio").val();
		}
		else if($("#slct_filial").val()!=""){
		cfil=$("#slct_filial").val();
		}
		else{
		cfil=$('#hd_idFilial').val();
		}
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'carrera',
				accion:'cargar_carrera',
				ctipcar:$("#slct_tipo_carrera").val(),
				//cmodali:$("#slct_modalidad").val(),
				cinstit:$('#slct_instituto').val(),
				cfilial:cfil
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
	cargarTipoCarrera: function(fxllena,slct_dest,id_slct){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'carrera',
            	accion:'cargar_tipo_carrera'
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
	cargarModalidad: function(fxllena,slct_dest,id_slct){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'carrera',
            	accion:'cargar_modalidad'
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
	cargarSemestre: function(fxllena,slct_dest,id_slct){
		var cfil="";
		var cins="";
		if($.trim($("#slct_local_estudio").val())!=""){
		cfil=$("#slct_local_estudio").val();
		}
		else if($("#slct_filial").val()!=""){
		cfil=$("#slct_filial").val();
		}
		else{
		cfil=$('#hd_idFilial').val();
		}
		
		if($.trim($("#slct_local_instituto").val())!=""){
		cins=$("#slct_local_instituto").val().split("-")[0];
		}
		else{
		cins=$('#slct_instituto').val();
		}		
		
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'carrera',
            	accion:'cargar_semestre',
				cinstit:cins,
				cfilial:cfil
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
	cargarSemestreR: function(fxllena,slct_dest,id_slct){
		var cfil="";
		if($("#slct_local_estudio").val()!=""){
		cfil=$("#slct_local_estudio").val();
		}
		else if($("#slct_filial").val()!=""){
		cfil=$("#slct_filial").val();
		}
		else{
		cfil=$('#hd_idFilial').val();
		}
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'carrera',
            	accion:'cargar_semestre_r',
				cinstit:$('#slct_instituto').val(),
				cfilial:cfil 
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
	cargarInicio: function(fxllena,slct_dest,id_slct){
		var cfil="";
		if($("#slct_local_estudio").val()!=""){
		cfil=$("#slct_local_estudio").val();
		}
		else if($("#slct_filial").val()!=""){
		cfil=$("#slct_filial").val();
		}
		else{
		cfil=$('#hd_idFilial').val();
		}
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'carrera',
            	accion:'cargar_inicio',
				csemaca:$("#slct_semestre").val(),
				cinstit:$('#slct_instituto').val(),
				cfilial:cfil
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
	cargarInicioR: function(fxllena,slct_dest,id_slct){
		var cfil="";
		if($("#slct_local_estudio").val()!=""){
		cfil=$("#slct_local_estudio").val();
		}
		else if($("#slct_filial").val()!=""){
		cfil=$("#slct_filial").val();
		}
		else{
		cfil=$('#hd_idFilial').val();
		}
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'carrera',
            	accion:'cargar_inicio_r',
				csemaca:$("#slct_semestre").val(),
				cinstit:$('#slct_instituto').val(),
				cfilial:cfil
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
	cargarModalidadIngreso: function(fxllena,slct_dest,id_slct){
		if($("#slct_local_instituto").val()!=""){
		cins=$("#slct_local_instituto").val().split("-")[0];
		cmod=$("#slct_local_instituto").val().split("-")[1];
		}
		else{
		cins=$("#hd_idInstituto").val();
		cmod=$("#hd_idModalidad").val();
		}
        $.ajax({
            url : this.url,
            type : 'POST',
            //async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'carrera',
            	accion:'cargar_modalidad_ingreso',
				cinstit:cins
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
	cargarModalidadIngresoIns: function(fxllena,slct_dest,id_slct){
		if($("#slct_local_instituto").val()!=""){
		cins=$("#slct_local_instituto").val().split("-")[0];
		cmod=$("#slct_local_instituto").val().split("-")[1];
		}
		else{
		cins=$("#hd_idInstituto").val();
		cmod=$("#hd_idModalidad").val();
		}
        $.ajax({
            url : this.url,
            type : 'POST',
            //async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'carrera',
            	accion:'cargar_modalidad_ingreso_ins',
				cinstit:cins
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
	cargarMedioCaptacion: function(fxllena,slct_dest,id_slct){
        $.ajax({
            url : this.url,
            type : 'POST',
            //async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'carrera',
            	accion:'cargar_medio_captacion'
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
	cargarMedioPrensa: function(fxllena,slct_dest,id_slct){
		var cfil="";		
		cfil=$('#hd_idFilial').val();		
        $.ajax({
            url : this.url,
            type : 'POST',
            //async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'carrera',
            	accion:'cargar_medio_prensa',
				cfilial:cfil
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
	cargarBanco: function(fxllena,slct_dest,id_slct){
        $.ajax({
            url : this.url,
            type : 'POST',
            //async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'carrera',
            	accion:'cargar_banco'
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
	
	cargarCiclo: function(fxllena,slct_dest,id_slct){
        $.ajax({
            url : this.url,
            type : 'POST',
            //async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'carrera',
            	accion:'cargar_ciclo'
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
	
	cargarCiclo2: function(fxllena,slct_dest,id_slct){
        $.ajax({
            url : this.url,
            type : 'POST',
            //async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'carrera',
            	accion:'cargar_ciclo2'
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
    //cargar de moduloa
    cargarCiclosdeModuloa: function(fxllena,slct_dest,id_slct){
        $.ajax({
            url : this.url,
            type : 'POST',
            //async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'carrera',
            	accion:'cargarCiclosdeModuloa',
                ccarrer: $('#slct_carrera').val()
                
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
    cargarCiclosdeModuloaG: function(fxllena,slct_dest,id_slct){
        $.ajax({
            url : this.url,
            type : 'POST',
            //async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
                comando:'carrera',
                accion:'cargarCiclosdeModuloa',
                ccarrer: $('#slct_carrera').val().join(",")
                
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
    //fin carga de ciclos por moduloa
	cargarCurricula: function(fxllena,slct_dest,id_slct){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'carrera',
            	accion:'cargar_curricula',
				ccarrer:$('#slct_carrera').val()
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
	
    cargarCarreraG: function(fxllena,slct_dest,id_slct,tit){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'carrera',
				accion:'cargar_carrera_g',
				ctipcar:'2',
				//cmodali:$("#slct_modalidad").val(),
				cinstit:$('#slct_instituto').val(),
				cfilial:$("#slct_filial").val().join("','")        	
            },
            beforeSend : function ( ) {
            },
            success : function ( obj ) {
                if( obj.length!=0 ){
                    fxllena(obj.data,slct_dest,id_slct,tit);
                }
            },
            error: this.msjErrorAjax
        });
    },
	
	cargarInicioG: function(fxllena,slct_dest,id_slct){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'carrera',
            	accion:'cargar_inicio_g',
				csemaca:$("#slct_semestre").val(),
				cinstit:$('#slct_instituto').val(),
				cfilial:$("#slct_filial").val().join("','")
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
	
	cargarSemestreG: function(fxllena,slct_dest,id_slct){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'carrera',
            	accion:'cargar_semestre_g',
				cinstit:$('#slct_instituto').val(),
				cfilial:$("#slct_filial").val().join("','")
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
	
	cargarTurno: function(fxllena,slct_dest,id_slct){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'carrera',
            	accion:'cargar_turno'				
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
	
	cargarDias: function(fxllena,slct_dest,id_slct){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'carrera',
            	accion:'cargar_dias'				
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
		
	cargarHora: function(fxllena,slct_dest,id_slct){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'carrera',
            	accion:'cargar_hora',
				cturno:$("#slct_turno").val(),
				cinstit:$('#slct_instituto').val(),
				thora:2
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
	cargarHoraEdit: function(fxllena,slct_dest,id_slct){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
				comando:'carrera',
				accion:'cargar_hora',
				cturno:$("#slct_turno_edit").val(),
				cinstit:$('#slct_instituto').val(),
				thora:2
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
	GetDatosGrupo: function(cod_gru,fn){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
              comando:'carrera',
              accion:'GetDatosGrupo',
                cgruaca:cod_gru
            },
            beforeSend : function ( ) {
            },
            success : function ( obj ) {
                fn(obj.data);
            },
            error: this.msjErrorAjax
        });
    },
	GetDatosSemestre: function(cod_sem,fn){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
              comando:'carrera',
              accion:'GetDatosSemestre',
              csemaca:cod_sem
			},
            beforeSend : function ( ) {
            },
            success : function ( obj ) {
                fn(obj.data);
            },
            error: this.msjErrorAjax
        });
    },
	GuardarCambiosSemestre: function(datoscjto){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
                comando:'carrera',
                accion:'guardar_semestre',
				datos:datoscjto,
				cfilial:$('#slct_filial').val().join(","),
				cinstit:$('#slct_instituto').val().join(","),
				cmodali:$('#slct_modalidad').val(),
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
					limpiarSelects();
                }else if(obj.rst=='2'){
                    sistema.msjAdvertencia(obj.msj,3000);
                }else{
                    sistema.msjErrorCerrar(obj.msj);
                }
            },
            error: this.msjErrorAjax
        });
	},	
	
	cargarCarreraM: function(fxllena,slct_dest,id_slct){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'carrera',
            	accion:'cargar_carrera_m',
				cinstit:$('#slct_instituto').val(),
				ctipcar:'2'
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
	
	ValidaCuadroModulo: function(evento){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'carrera',
            	accion:'valida_modulos',
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
					$("#valModulos .ListaModulos").remove();
                }else{
                    //sistema.msjErrorCerrar(obj.msj);
				}
            },
            error: this.msjErrorAjax
        });
    },	
	
	GuardarModulo: function(){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'carrera',
            	accion:'guardar_modulo',
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
					ValidaModulo();
                }else if(obj.rst=='2'){
                    sistema.msjAdvertencia(obj.msj,3000);
                }else{
                    sistema.msjErrorCerrar(obj.msj);
                }
            },
            error: this.msjErrorAjax
        });
	},	
	
	actualizaNroMmod: function(codigo){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'carrera',
            	accion:'act_nro_modulo',
				ccarrer:$("#slct_carrera").val(),
				cmodulo:codigo,
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
					ValidaModulo();
                }else if(obj.rst=='2'){
                    sistema.msjAdvertencia(obj.msj,3000);
                }else{
                    sistema.msjErrorCerrar(obj.msj);
                }
            },
            error: this.msjErrorAjax
        });
	},
	
	actualizaDescModulo: function(codigo){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'carrera',
            	accion:'act_desc_modulo',
				ccarrer:$("#slct_carrera").val(),
				cmodulo:codigo,
				dmodulo:$("#txt_des_"+codigo).val(),
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
					ValidaModulo();
                }else if(obj.rst=='2'){
                    sistema.msjAdvertencia(obj.msj,3000);
                }else{
                    sistema.msjErrorCerrar(obj.msj);
                }
            },
            error: this.msjErrorAjax
        });
	},
	
	ValidaCuadroCarrera: function(evento){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'carrera',
            	accion:'valida_carreras',
				cinstit:$("#slct_instituto").val(),
				//cmodali:$("#slct_modalidad").val(),
				ctipcar:'2',
                cusuari:$('#hd_idUsuario').val(),
				cfilialx:$('#hd_idFilial').val()
            },
            beforeSend : function ( ) {
            },
            success : function ( obj ) {
                if(obj.rst=='1'){
					evento(obj.data);
                }else if(obj.rst=='2'){
					$("#valCarreras .ListaCarreras").remove();
                }else{
                    //sistema.msjErrorCerrar(obj.msj);
				}
            },
            error: this.msjErrorAjax
        });
    },	

	GuardarCambiosCarreras: function(datoscjto){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
                comando:'carrera',
                accion:'guardar_cambio_carrera',
                datos:datoscjto,
				cinstit:$("#slct_instituto").val(),
				//cmodali:$("#slct_modalidad").val(),
				ctipcar:'2',
                cusuari:$('#hd_idUsuario').val(),
				cfilialx:$('#hd_idFilial').val()
            },
            beforeSend : function ( ) {
                sistema.abreCargando();
            },
            success : function ( obj ) {
                sistema.cierraCargando();
                if(obj.rst=='1'){
                    sistema.msjOk(obj.msj,7000);
					ValidaCarrera();
					$("#btn_NuevaCarrera").css("display",'');
                }else if(obj.rst=='2'){
                    sistema.msjAdvertencia(obj.msj,3000);
                }else{
                    sistema.msjErrorCerrar(obj.msj);
                }
            },
            error: this.msjErrorAjax
        });
	},	
	cargarModulo: function(fxllena,slct_dest,id_slct){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            comando:'carrera',
            accion:'cargar_modulos',
			ccarrer:$("#slct_carrera").val(),
            cusuari:$('#hd_idUsuario').val(),
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
	cargarPais: function(fxllena,slct_dest,id_slct){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'carrera',
            	accion:'cargar_pais'
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
    listarSemestres: function(evento){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'carrera',
            	accion:'listar_semestres',
                cfilial:$('#slct_filial').val().join(","),
                cinstit:$('#slct_instituto').val().join(","),
            },
            beforeSend : function ( ) {
              sistema.abreCargando();
            },
            success : function ( obj ) {
                    sistema.cierraCargando();
                if(obj.rst=='1'){
               		sistema.msjOk(obj.msj);
			evento(obj.data);
                }else if(obj.rst=='2'){
                    sistema.msjAdvertencia(obj.msj,3000);
                }else{
                    sistema.msjErrorCerrar(obj.msj);
                }
            },
            error: this.msjErrorAjax
        });
    },
    
    ActualizarSemestre: function(obj){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'carrera',
            	accion:'actualizar_semestre',
                cfilial:$(obj).attr("cfilial"),
                cinstit:$(obj).attr("cinstit"),
                csemaca:$(obj).attr("semestre"),
                cinicio:$(obj).attr("cinicio"),
                finisem:$(obj).attr("finisem"),
                cestado:$(obj).attr("ces"),
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
			listarSemestres();
                }else if(obj.rst=='2'){
                    sistema.msjAdvertencia(obj.msj,3000);
                }else{
                    sistema.msjErrorCerrar(obj.msj);
                }
            },
            error: this.msjErrorAjax
        });
	},
	ModificarSemestre: function(){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'carrera',
            	accion:'ModificarSemestre',
                cfilial:$("#slct_filial_edit").val(),
                cinstit:$("#slct_instituto_edit").val(),
                csemaca:$("#txt_semestre1_edit").val()+"-"+$("#txt_semestre2_edit").val(),
                cinicio:$("#txt_inicio_edit").val(),
                finisem:$("#txt_fecha_inicio_sem_edit").val(),
				ffinsem:$("#txt_fecha_final_sem_edit").val(),
				finimat:$("#txt_fecha_inicio_mat_edit").val(),
                ffinmat:$("#txt_fecha_final_mat_edit").val(),
                fechgra:$("#txt_fecha_gra_edit").val(),
				fechext:$("#txt_fecha_ext_edit").val(),
				datos:$("#csemaca").val(),
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
					 $('#frmSemestre').dialog('close');
					listarSemestres();
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