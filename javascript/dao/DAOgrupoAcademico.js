var grupoAcademicoDAO={
	url:'../controlador/controladorSistema.php',
    cargarDiasdelGrupo:function(ids){
        $.ajax({
            url : this.url,
            type : 'POST',            
            dataType : 'json',
            data : {
                comando:'grupo_academico',
                accion:'cargarDiasdelGrupo',                
                cgracpr:ids             
            },
            beforeSend : function ( ) {
                sistema.abreCargando();
            },
            success : function ( obj ) {
                sistema.cierraCargando(); 
                $("#diasdelgrupo").val(obj.data);
            },
            error: this.msjErrorAjax
        });
    },
	cargarGrupoAcademicoMatri:function(evento){
		var cfil="";var cini="";
		var cins="";var cmod="";
        if( $("#cinicio").val()!=undefined ){
            cini=$("#cinicio").val();
        }
		if($("#slct_local_estudio").val()!=""){
		cfil=$("#slct_local_estudio").val();
		}
		if($("#slct_local_instituto").val()!=""){
		cins=$("#slct_local_instituto").val().split("-")[0];
		cmod=$("#slct_local_instituto").val().split("-")[1];
		}
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'grupo_academico',
            	accion:'cargarGrupoAcademicoMatri',
				cfilial:cfil,
				cinstit:cins,
				cmodali:cmod,
				csemaca:$("#slct_semestre").val(),
				cciclo:$("#cciclo").val(),
                cinicio:cini,
            },
            beforeSend : function ( ) {
				sistema.abreCargando();
            },
            success : function ( obj ) {
				sistema.cierraCargando(); 
            	evento(obj.data);             
            },
            error: this.msjErrorAjax
        });
	},
    cargarGrupoAcademico: function(evento){
		var cfil="";
		var cins="";var cmod="";
		if($("#slct_local_estudio").val()!=""){
		cfil=$("#slct_local_estudio").val();
		}
		if($("#slct_local_instituto").val()!=""){
		cins=$("#slct_local_instituto").val().split("-")[0];
		cmod=$("#slct_local_instituto").val().split("-")[1];
		}
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'grupo_academico',
            	accion:'cargar_grupo_academico',
				cfilial:cfil,
				cinstit:cins,
				cmodali:cmod,
				csemaca:$("#slct_semestre").val(),
				cciclo:$("#cciclo").val()				
            },
            beforeSend : function ( ) {
				sistema.abreCargando();
            },
            success : function ( obj ) {
				sistema.cierraCargando(); 
            	evento(obj.data);             
            },
            error: this.msjErrorAjax
        });
    },
	cargarGrupoAcademico2: function(evento){
		$.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'grupo_academico',
            	accion:'cargar_grupo_academico2',
				cfilial:$("#slct_filial").val().join(","),
				cinstit:$("#slct_instituto").val(),
				csemaca:$("#slct_semestre").val(),
				cciclo:$("#slct_ciclo").val()				
            },
            beforeSend : function ( ) {
				sistema.abreCargando();
            },
            success : function ( obj ) {
				sistema.cierraCargando(); 
            	evento(obj.data);             
            },
            error: this.msjErrorAjax
        });
    },cargarGrupoAcademicoR: function(evento){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
                comando:'grupo_academico',
                accion:'cargar_grupo_academico2',
                cfilial:$("#slct_filial").val().join(","),
                cinstit:$("#slct_instituto").val().join(","),
                csemaca:$("#slct_semestre").val().join(","),
                cciclo:$("#slct_ciclo").val()
            },
            beforeSend : function ( ) {
                sistema.abreCargando();
            },
            success : function ( obj ) {
                sistema.cierraCargando(); 
                evento(obj.data);             
            },
            error: this.msjErrorAjax
        });
    },
    cargarGrupoAcademicoR2: function(evento){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
                comando:'grupo_academico',
                accion:'cargar_grupo_academico2',
                cfilial:$("#slct_filial").val().join(","),
                cinstit:$("#slct_instituto").val().join(","),
                fechini:$("#txt_fecha_inicio").val(),
                fechfin:$("#txt_fecha_fin").val()
            },
            beforeSend : function ( ) {
                sistema.abreCargando();
            },
            success : function ( obj ) {
                sistema.cierraCargando(); 
                evento(obj.data);             
            },
            error: this.msjErrorAjax
        });
    },
	cargarAlumnos: function(evento,ids){
		$.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'grupo_academico',
            	accion:'cargarAlumnos',
				id:ids
            },
            beforeSend : function ( ) {
            },
            success : function ( obj ) {
                if( obj.length!=0 ){
                    evento(obj.data);
                }
            },
            error: this.msjErrorAjax
        });
	},
	cargarCursosProgramados: function(evento){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'grupo_academico',
            	accion:'cargar_cursos_programados',
				cgracpr:$("#slct_horario").val()
            },
            beforeSend : function ( ) {
            },
            success : function ( obj ) {
                if( obj.length!=0 ){
                    evento(obj.data);
                }
            },
            error: this.msjErrorAjax
        });
    },	
	guardarGruposAcademicos: function(dias){
		
		$.ajax({
            url : this.url,
            type : 'POST',
            //async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'grupo_academico',
            	accion:'guardar_grupos_academicos',
				fechainiciosemestre:$("#fechainiciosemestre").val(),
				fechafinsemestre:$("#fechafinsemestre").val(),
				cfilial:$("#slct_filial").val().join(","),
				cinstit:$("#slct_instituto").val(),
				cmodali:"",
				ccarrer:$("#slct_carrera").val(),
				ctipcar:2,
				ccurric:$("#slct_curricula").val(),
				csemaca:$("#slct_semestre").val(),
				cciclo:$("#slct_ciclo").val(),
				cinicio:$("#slct_inicio").val(),
				cturno:$("#slct_turno").val(),
				chora:$("#slct_horario").val(),
				dias: dias,
				finicio:$("#txt_fecha_inicio").val(),
				ffinal:$("#txt_fecha_final").val(),
				nmetmat:$("#txt_meta_mat").val(),
                nmetmin:$("#txt_meta_min").val(),
				cfilialx:$("#hd_idFilial").val(),
				usuario: $("#hd_idUsuario").val()				
            },
            beforeSend : function ( ) {
				sistema.abreCargando();
            },
            success : function ( obj ) {
				sistema.cierraCargando();                
				if(obj.rst=='1'){
					limpiarSelects();
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
    guardarGruposAcademicosG: function(dias){
        
        $.ajax({
            url : this.url,
            type : 'POST',
            //async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
                comando:'grupo_academico',
                accion:'guardar_grupos_academicos',
                fechainiciosemestre:$("#fechainiciosemestre").val(),
                fechafinsemestre:$("#fechafinsemestre").val(),
                cfilial:$("#slct_filial").val().join(","),
                cinstit:$("#slct_instituto").val(),
                cmodali:"",
                ccarrer:$("#slct_carrera").val().join(","),
                ctipcar:2,
                //ccurric:$("#slct_curricula").val(),
                csemaca:$("#slct_semestre").val(),
                cciclo:$("#slct_ciclo").val(),
                cinicio:$("#slct_inicio").val(),
                cturno:$("#slct_turno").val(),
                chora:$("#slct_horario").val(),
                observacion:$("#txt_observacion").val(),
                dias: dias,
                finicio:$("#txt_fecha_inicio").val(),
                ffinal:$("#txt_fecha_final").val(),
                nmetmat:$("#txt_meta_mat").val(),
                nmetmin:$("#txt_meta_min").val(),
                cfilialx:$("#hd_idFilial").val(),
                usuario: $("#hd_idUsuario").val()               
            },
            beforeSend : function ( ) {
                sistema.abreCargando();
            },
            success : function ( obj ) {
                sistema.cierraCargando();                
                if(obj.rst=='1'){
                    limpiarSelects();
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
	ActualizarGrupoAcademico: function(dias,detalle){
  	$.ajax({
		url : this.url + '?testObservacion',
		type : 'POST',
		//async:false,//no ejecuta otro ajax hasta q este termine
		dataType : 'json',
		data : {
			comando:'grupo_academico',
			accion:'ActualizarGrupoAcademico', //Applications/MAMP/htdocs/SGC2/controlador/servletGrupoAcademico.php
			cgruaca:$("#cgruaca").val(),        
			cturno:$("#slct_turno_edit").val(),
			chora:$("#slct_horario_edit").val(),
			nmetmat:$("#txt_meta_mat_edit").val(),
        nmetmin:$("#txt_meta_min_edit").val(),
        observacion:$("#observacion").val(),
			  dias: dias,
        valores:detalle,
			fechainiciosemestre:$("#fechainiciosemestre").val(),
			fechafinsemestre:$("#fechafinsemestre").val(),
			finicio:$("#txt_fecha_inicio_edit").val(),
			ffinal:$("#txt_fecha_final_edit").val(),
			cfilialx:$("#hd_idFilial").val(),
			usuario: $("#hd_idUsuario").val()        
            },
        beforeSend : function ( ) {
        	sistema.abreCargando();
        },
        success : function ( obj ) {
        sistema.cierraCargando();                
        	if(obj.rst=='1'){
				$('#frmGruposAca').dialog('close');
				ListarGrupos();
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
  cargarCursosAcademicos: function(evento,ids){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
                comando:'grupo_academico',
                accion:'cargarCursosAcademicos',
                cgracpr:ids                
            },
            beforeSend : function ( ) {
            },
            success : function ( obj ) {
                if( obj.length!=0 ){
                    evento(obj.data);
                }
            },
            error: this.msjErrorAjax
        });
    },
    cargarHorarioProgramado: function(evento,id){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
                comando:'grupo_academico',
                accion:'cargarHorarioProgramado',
                ccuprpr:id,
                cdetgra:$("#slct_detalle_grupo").val().split("|")[0]
            },
            beforeSend : function ( ) {
            },
            success : function ( obj ) {
                if( obj.length!=0 ){
                    evento(obj.data);
                }
            },
            error: this.msjErrorAjax
        });
    },
    cargarDetalleGrupo: function(fxllena,slct_dest,id_slct,ids){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
                comando:'grupo_academico',
                accion:'cargarDetalleGrupo',
                cgracpr:ids                
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
    cargarCursosAcademicosAlumno:function(evento){
       
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
                comando:'grupo_academico',
                accion:'cargarCursosAcademicosAlumno',
                cingalu:$('#txt_cingalu').val(),
                cgracpr:$("#txt_cgracpr_destino").val()                
            },
            beforeSend : function ( ) {
                sistema.abreCargando();
            },
            success : function ( obj ) {
                sistema.cierraCargando(); 
                evento(obj.data);             
            },
            error: this.msjErrorAjax
        });
    },
    validarPasarRegistro:function(ccuprp,gruequ,htm,ncredit){

        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
                comando:'grupo_academico',
                accion:'validarPasarRegistro',
                ccuprpr:ccuprp,
                gruequi:gruequ,
                cingalu:$('#txt_cingalu').val()
            },
            beforeSend : function ( ) {
                sistema.abreCargando();
            },
            success : function ( obj ) {
                var cantidad=0; var adic="ok";
                sistema.cierraCargando(); 
                if(obj.rst=='2'){
                    adicionarRegistro(htm,ncredit,ccuprp);                    
                }
                else if(obj.rst=='1' && obj.data*1>=11){
                    if(obj.data2*1>0 && obj.data2*1<3){
                        $("#tcreditosaux").val('14');
                        cantidad=$("#ccreditosaux").val()*1+1;
                        $("#ccreditosaux").val(cantidad);
                        adicionarRegistro(htm,ncredit,ccuprp,adic); 
                    }
                    else if(obj.data2*1==3){
                        sistema.msjAdvertencia('Ud no puede ser matriculado tiene acumulado 3 veces un mismo curso.',4000);
                    } 
                    else{
                        adicionarRegistro(htm,ncredit,ccuprp);
                    }
                    
                }
                else{
                    sistema.msjAdvertencia('Curso seleccionado sin aprobar por falta de pre requisito',4000);
                }
                
            },
            error: this.msjErrorAjax
        });
    },
    crearPonderado:function(){

        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
                comando:'grupo_academico',
                accion:'crearPonderado',
                cingalu:$('#txt_cingalu').val()
            },
            beforeSend : function ( ) {
                sistema.abreCargando();
            },
            success : function ( obj ) {
                sistema.cierraCargando(); 
                $("#tcreditos").val(obj.creditos)
                
            },
            error: this.msjErrorAjax
        });
    },
    guardarPuntajePostulantes: function (data) {
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
                comando: 'grupo_academico',
                accion: 'guardarPuntajePostulantes',
                cfilialx:$('#hd_idFilial').val(),
                cusuari: $('#hd_idUsuario').val(),
                data: data
            },
            beforeSend : function ( ) {
                sistema.abreCargando();
            },
            success : function ( obj ) {
                sistema.cierraCargando();
                if(obj.rst=='1'){
                    sistema.msjOk(obj.msj,3000);
                } else {
                    this.msjErrorAjax
                }
            },
            error: this.msjErrorAjax
        });

    },
    guardarPostulantesNotas: function (data) {
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
                comando: 'inscrito',
                accion: 'guardarPostulantesNotas',
                cfilial:$('#hd_idFilial').val(),
                cusuari: $('#hd_idUsuario').val(),
                data: data
            },
            beforeSend : function ( ) {
                sistema.abreCargando();
            },
            success : function ( obj ) {
                sistema.cierraCargando();
                if(obj.rst=='1'){
                    sistema.msjOk(obj.msj,3000);
                } else {
                    this.msjErrorAjax
                }
            },
            error: this.msjErrorAjax
        });

    },
	msjErrorAjax:function(){
        sistema.msjErrorCerrar('Error General, pongase en contacto con Sistemas');
    }
}
