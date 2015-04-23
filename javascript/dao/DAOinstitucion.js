var institucionDAO={
	url:'../controlador/controladorSistema.php',
    cargarFilial: function(fxllena,slct_dest,id_slct){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'institucion',
				accion:'cargar_filial',
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
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
                comando:'institucion',
                accion:'cargarCiclo',
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
    verificaNombre:function(){
        $.ajax({
            url : this.url,
            type : 'POST',            
            dataType : 'json',
            data : {
                comando:'cuenta',
                action:'verificaNombre',
                dextxtb:$("#txt_detalle_ex").val(),
            },
            beforeSend : function ( ) {
            },
            success : function ( obj ) {
                $('#nombre_ide').text('.::Nuevo::.');
                $('#slct_cuenta').removeAttr('disabled');
                $("#slct_cuenta").val('');
                if( obj.rst==1 ){
                    $("#slct_cuenta").val(obj.data);  
                    $('#nombre_ide').text('.::Modificando::.');
                    $('#slct_cuenta').attr('disabled','true');
                }
                VisualizaAsignacion();

            },
            error: this.msjErrorAjax
        });        
    },
    verificaNombre2:function(){
        $.ajax({
            url : this.url,
            type : 'POST',            
            dataType : 'json',
            data : {
                comando:'cuenta',
                action:'verificaNombre',
                dextxtb:$("#txt_detalle_ex").val(),
            },
            beforeSend : function ( ) {
            },
            success : function ( obj ) {
            $("#slct_cuenta").val(obj.data);  
            VisualizaAsignacion();

            },
            error: this.msjErrorAjax
        });        
    },
    cargarCuentas: function(fxllena,slct_dest,id_slct){
        $.ajax({
            url : this.url,
            type : 'POST',            
            dataType : 'json',
            data : {
                comando:'cuenta',
                action:'cargarCuentas',
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
    cargarDetalleEx: function(fxllena,slct_dest,id_slct){
        $.ajax({
            url : this.url,
            type : 'POST',            
            dataType : 'json',
            data : {
                comando:'cuenta',
                action:'cargarDetalleEx',
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
    GenerarAsignacion: function(){
        $.ajax({
            url : this.url,
            type : 'POST',            
            dataType : 'json',
            data : {
                comando:'cuenta',
                action:'GenerarAsignacion',
                cfilial:$("#slct_filial").val().join(","),
                cinstit:$("#slct_instituto").val().join(","),
                cctacte:$("#slct_cuenta").val(),
                dextxtb:$("#txt_detalle_ex").val(),
                cfilialx:$("#hd_idFilial").val()
            },
            beforeSend : function ( ) {
            },
            success : function ( obj ) {
                sistema.msjOk(obj.msg,200);
                $("#slct_cuenta").val('');
                $("#slct_cuenta").attr('disabled','true');
                $("#txt_detalle_ex").val('');
                $('#nombre_ide').text('.::Nuevo::.');
                VisualizaAsignacion();
            },
            error: this.msjErrorAjax
        });
    },
    cargarFilIns: function(){
        $.ajax({
            url : this.url,
            type : 'POST', 
            async:false,           
            dataType : 'json',
            data : {
                comando:'cuenta',
                action:'cargarFilIns',
                dextxtb:$("#txt_detalle_ex").val(),
                cctacte:$("#slct_cuenta").val()
            },
            beforeSend : function ( ) {
            },
            success : function ( obj ) {
                $('#cfilial').val(obj.cfilial);
                $('#cinstit').val(obj.cinstit);
                $('#cuenta').val(obj.cuenta);
                muestrafilins(obj.dfilial,obj.dinstit);
            },
            error: this.msjErrorAjax
        });
    },    
    cargarSemestreG: function(fxllena,slct_dest,id_slct,titulo){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
                comando:'institucion',
                accion:'cargarSemestreG',
                cinstit:$('#slct_instituto').val().join(","),
                cfilial:$("#slct_filial").val().join(",")
            },
            beforeSend : function ( ) {
            },
            success : function ( obj ) {
                if( obj.length!=0 ){
                    fxllena(obj.data,slct_dest,id_slct,titulo);
                }
            },
            error: this.msjErrorAjax
        });
    },
    cargarSemestreR: function(fxllena,slct_dest,id_slct,titulo){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
                comando:'institucion',
                accion:'cargarSemestreG',
                cinstit:$('#cinstit').val().split("|").join(","),
                cfilial:$("#cfilial").val().split("|").join(",")
            },
            beforeSend : function ( ) {
            },
            success : function ( obj ) {
                if( obj.length!=0 ){
                    fxllena(obj.data,slct_dest,id_slct,titulo);
                }
            },
            error: this.msjErrorAjax
        });
    },
    cargarCarreraG: function(fxllena,slct_dest,id_slct,titulo){
        $.ajax({
            url : this.url,
            type : 'POST',
            //async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
                comando:'institucion',
                accion:'cargarCarreraG',
                cinstit:$('#slct_instituto').val().join(","),
                cfilial:$("#slct_filial").val().join(",")
            },
            beforeSend : function ( ) {
            },
            success : function ( obj ) {
                if( obj.length!=0 ){
                    fxllena(obj.data,slct_dest,id_slct,titulo);
                }
            },
            error: this.msjErrorAjax
        });
    },
    cargarCarreraR: function(fxllena,slct_dest,id_slct,titulo){
        $.ajax({
            url : this.url,
            type : 'POST',
            //async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
                comando:'institucion',
                accion:'cargarCarreraG',
                cinstit:$('#cinstit').val().split("|").join(","),
                cfilial:$("#cfilial").val().split("|").join(",")
            },
            beforeSend : function ( ) {
            },
            success : function ( obj ) {
                if( obj.length!=0 ){
                    fxllena(obj.data,slct_dest,id_slct,titulo);
                }
            },
            error: this.msjErrorAjax
        });
    },
	cargarFilialValida: function(fxllena,slct_dest,id_slct){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'institucion',
				accion:'cargar_filial',
				cfilial:$("#hd_idFilials").val()
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
	cargarFilialG: function(fxllena,slct_dest,id_slct,titulo){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'institucion',
				accion:'cargar_filial'				
            },
            beforeSend : function ( ) {
            },
            success : function ( obj ) {
                if( obj.length!=0 ){
                    fxllena(obj.data,slct_dest,id_slct,titulo);
                }
            },
            error: this.msjErrorAjax
        });
    },
	cargarFilialValidadaG: function(fxllena,slct_dest,id_slct,titulo){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'institucion',
				accion:'cargar_filial',
				cfilial:$("#hd_idFilials").val()
            },
            beforeSend : function ( ) {
            },
            success : function ( obj ) {
                if( obj.length!=0 ){
                    fxllena(obj.data,slct_dest,id_slct,titulo);
                }
            },
            error: this.msjErrorAjax
        });
    },
    cargarPensionG: function(fxllena,slct_dest,id_slct,todo){
		var fil=""
		if($("#slct_filial").val()!=""){
		fil=$("#slct_filial").val().join("','");
		}
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'institucion',
				accion:'cargar_pension_g',
				cfilial:fil,
				cinstit:$("#slct_instituto").val(),
				ccarrer:$("#slct_carrera").val()
            },
            beforeSend : function ( ) {
            },
            success : function ( obj ) {                
            	fxllena(obj.data,slct_dest,id_slct,todo);                
            },
            error: this.msjErrorAjax
        });
    },
    cargarPensionG2: function(fxllena,slct_dest,id_slct,todo){
        var fil=""
        if($("#slct_filial").val()!=""){
        fil=$("#slct_filial").val().join("','");
        }
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
                comando:'institucion',
                accion:'cargar_pension_g',
                cfilial:fil,
                cinstit:$("#slct_instituto").val(),
                ccarrer:$("#slct_carrera").val().join(",")
            },
            beforeSend : function ( ) {
            },
            success : function ( obj ) {                
                fxllena(obj.data,slct_dest,id_slct,todo);                
            },
            error: this.msjErrorAjax
        });
    },
	cargarInstitucion: function(fxllena,slct_dest,id_slct){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'institucion',
				accion:'cargar_institucion'
            },
            beforeSend : function ( ) {
            },
            success : function ( obj ) {                
            	fxllena(obj.data,slct_dest,id_slct);                
            },
            error: this.msjErrorAjax
        });
    },
	cargarInstitucionValida: function(fxllena,slct_dest,id_slct){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'institucion',
				accion:'cargar_institucion',
				cinstit:$("#hd_idInstituto").val()
            },
            beforeSend : function ( ) {
            },
            success : function ( obj ) {                
            	fxllena(obj.data,slct_dest,id_slct);                
            },
            error: this.msjErrorAjax
        });
    },
	cargarInstitucionG: function(fxllena,slct_dest,id_slct,titulo){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'institucion',
				accion:'cargar_institucion',       	
            },
            beforeSend : function ( ) {
            },
            success : function ( obj ) {
                if( obj.length!=0 ){
                    fxllena(obj.data,slct_dest,id_slct,titulo);
                }
            },
            error: this.msjErrorAjax
        });
    },
	cargarInstitucionValidaG: function(fxllena,slct_dest,id_slct,titulo){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'institucion',
				accion:'cargar_institucion',
				cinstit:$("#hd_idInstituto").val()
            },
            beforeSend : function ( ) {
            },
            success : function ( obj ) {
                if( obj.length!=0 ){
                    fxllena(obj.data,slct_dest,id_slct,titulo);
                }
            },
            error: this.msjErrorAjax
        });
    },
	ListaInstitutos: function(evento){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'institucion',
				accion:'ListarInstituto',
				cinstit:$("#hd_idInstituto").val()
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
    ListaBancos: function(evento){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
                comando:'institucion',
                accion:'ListaBancos'
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
    ListarGrupos: function(evento){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'institucion',
            	accion:'ListarGrupos',
                cfilial:$('#slct_filial').val().join(","),
                cinstit:$('#slct_instituto').val(),
                ccarrer:$('#slct_carrera').val(),
                csemaca:$('#slct_semestre').val(),
                
                ccurric:$("#slct_curricula").val(),
                cciclo:$("#slct_ciclo").val(),
                cturno:$("#slct_turno").val(),
                cinicio:$("#slct_inicio").val(),
                chora:$("#slct_horario").val()
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
    ListarGruposG: function(evento){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
                comando:'institucion',
                accion:'ListarGrupos',
                cfilial:$('#slct_filial').val().join(","),
                cinstit:$('#slct_instituto').val(),
                ccarrer:$('#slct_carrera').val().join(","),
                csemaca:$('#slct_semestre').val(),
                
                //ccurric:$("#slct_curricula").val(),
                cciclo:$("#slct_ciclo").val(),
                cturno:$("#slct_turno").val(),
                cinicio:$("#slct_inicio").val(),
                chora:$("#slct_horario").val()
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
	ListarDetalleGrupos: function(evento,id){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'institucion',
            	accion:'ListarDetalleGrupos',
                cgracpr:id
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
    getFechasSemetre: function(evento){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'institucion',
            	accion:'getFechasSemetre',
                cfilial:$('#slct_filial').val().join(","),
                cinstit:$('#slct_instituto').val(),
                csemaca:$('#slct_semestre').val(),
                cinicio:$("#slct_inicio").val(),
                
                
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
    listarUsuarios: function(evento){
        //valido que no envie null
        var filiales = $('#slct_filial').val();
        if(filiales){
            filiales = $('#slct_filial').val().join(",");
        }else{
            filiales = "";
        }
        
        
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'institucion',
            	accion:'listarUsuarios',
                cfilial:filiales,
                nombres:$('#cnom').val(),
                paterno:$('#cape').val(),
                materno:$('#came').val()
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
                     $("#lista_usuarios").html("");
                     $(".UsuariosCampos").hide();
                }else{
                    sistema.msjErrorCerrar(obj.msj);
                     $("#lista_usuarios").html("");
                     $(".UsuariosCampos").hide();
                }
            },
            error: this.msjErrorAjax
        });
    },
    listarIndiceMatricula: function(evento){
        //valido que no envie null
        var filiales = $('#slct_filial').val();
        if(filiales){
            filiales = $('#slct_filial').val().join(",");
        }else{
            filiales = "";
        }
        
        
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'institucion',
            	accion:'listarIndiceMatricula',
                cfilial:filiales,
                cinsiti:$("#slct_instituto").val(),
                csemaca:$("#slct_semestre").val()
                
            },
            beforeSend : function ( ) {
              sistema.abreCargando();
            },
            success : function ( obj ) {
                 $(".table-indicematricula").show();
                    sistema.cierraCargando();
                if(obj.rst=='1'){
               		sistema.msjOk(obj.msj);
			evento(obj.data);
                }else{
                    $(".table-indicematricula").hide();
                    sistema.msjAdvertencia(obj.msj);
//                     $("#lista_usuarios").html("");
//                     $(".UsuariosCampos").hide();
                }
            },
            error: this.msjErrorAjax
        });
    },
	listarIndiceMatricula2: function(evento){
        //valido que no envie null
        var filiales = $('#slct_filial').val();
        if(filiales){
            filiales = $('#slct_filial').val().join(",");
        }else{
            filiales = "";
        }
		var instituciones= $('#slct_instituto').val();
        if(instituciones){
            instituciones = $('#slct_instituto').val().join(",");
        }else{
            instituciones = "";
        }
        
        
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'institucion',
            	accion:'listarIndiceMatricula',
                cfilial:filiales,
                cinsiti:instituciones,
				fechini:$("#txt_fecha_inicio").val(),
				fechfin:$("#txt_fecha_fin").val()
                
            },
            beforeSend : function ( ) {
              sistema.abreCargando();
            },
            success : function ( obj ) {
                 $(".table-indicematricula").show();
                    sistema.cierraCargando();
                if(obj.rst=='1'){
               		sistema.msjOk(obj.msj);
					evento(obj.data);
                }else{
                    $(".table-indicematricula").hide();
                    sistema.msjAdvertencia(obj.msj);
//                     $("#lista_usuarios").html("");
//                     $(".UsuariosCampos").hide();
                }
            },
            error: this.msjErrorAjax
        });
    },
    mostrarUsuarios: function(person,funcion){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'institucion',
            	accion:'mostrarUsuarios',
               
                cperson:person
            },
            beforeSend : function ( ) {
              sistema.abreCargando();
            },
            success : function ( obj ) {
                    sistema.cierraCargando();
                if(obj.rst=='1'){
               		sistema.msjOk(obj.msj);
			funcion(obj.data);
                }else if(obj.rst=='2'){
                    sistema.msjAdvertencia(obj.msj,3000);
                        $(".UsuariosCampos.title").hide();
                        $(".UsuariosCampos.fields").hide();
                        $(".UsuariosCampos.operaciones").hide();
                    
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
            	comando:'institucion',
            	accion:'cargarGrupos',
		cfilial:002,
                cperson:001
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
    
    actualizarUsuario: function(){
            var reqs = "";
            jQuery('#slct_grupo\\[\\]').each(function(i,e){
            if( reqs == "" ){
            reqs = e.value;
            }else{
            reqs +="|"+e.value;
            }});
            
            //consiguiendo las filiales de los grupos
            var filiales = "";
            jQuery('#slct_gfilial\\[\\]').each(function(i,e){
            if( filiales == "" ){
            filiales = e.value;
            }else{
            filiales +="|"+e.value;
            }});
            
            
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'institucion',
            	accion:'actualizarUsuario',
                
                cperson:$("#ucperson").val(),
                cestado:$("#slct_estado").val(),
                cfilial:filiales,
                dnivusu:$("#dnivusu").val(),
                
                login:$("#login").val(),
		clave:$("#pass").val(),
                //creando cadena de cursos grupos
                cgrupos:reqs,
                //datos transaccion             
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
                        $(".UsuariosCampos.title").hide();
                        $(".UsuariosCampos.fields").hide();
                        $(".UsuariosCampos.operaciones").hide();
                        btn_buscarUsuarios();
                }else if(obj.rst=='2'){
                    sistema.msjAdvertencia(obj.msj,3000);
                }else{
                    sistema.msjErrorCerrar(obj.msj);
                }
            },
            error: this.msjErrorAjax
        });
	},
        
         ActualizarGrupo: function(obj){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'institucion',
            	accion:'ActualizarGrupo',
                ces:$(obj).attr("ces"),
                gru:$(obj).attr("gru"),
                
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
			ListarGrupos();
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