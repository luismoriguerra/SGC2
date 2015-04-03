var personaDAO={
	url:'../controlador/controladorSistema.php',    
    InsertarPersona:function(){
        $.ajax({
            url : this.url,
            type : 'POST',
            //async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
                comando:'persona',
                accion:'InsertarPersona',
				dappape:$('#txt_paterno').val(),
				dapmape:$('#txt_materno').val(),
				dnomper:$('#txt_nombre').val(),
				email1:$('#txt_email').val(),
				ntelpe2:$('#txt_celular').val(),
				ntelper:$('#txt_telefono_casa').val(),
				ntellab:$('#txt_telefono_oficina').val(),
				cestciv:$('#slct_estado_civil').val(),
				ndniper:$('#txt_dni').val(),
				tsexo:$('#slct_sexo').val(),
				fnacper:$('#txt_fecha_nacimiento').val(),
				coddpto:$('#slct_departamento').val(),
				codprov:$('#slct_provincia').val(),
				coddist:$('#slct_distrito').val(),
				ddirper:$('#txt_direccion').val(),
				ddirref:$('#txt_referencia').val(),
				cdptlab:$('#slct_departamento2').val(),
				cprvlab:$('#slct_provincia2').val(),
				cdislab:$('#slct_distrito2').val(),
                cdptcol:$('#slct_departamento3').val(),
                cprvcol:$('#slct_provincia3').val(),
                cdiscol:$('#slct_distrito3').val(),				
				ddirlab:$('#txt_direccion2').val(),
				dnomlab:$('#txt_nombre_trabajo').val(),
				dcolpro:$('#txt_colegio').val(),
				tcolegi:$('#slct_Tipo').val(),
				cfilial:$('#hd_idFilial').val(),
                cusuari: $('#hd_idUsuario').val()
            },
            beforeSend : function ( ) {
                sistema.abreCargando();
            },
            success : function ( obj ) {
                sistema.cierraCargando();
                if(obj.rst=='1'){					
                    $('#frmPersona').dialog('close');
                    sistema.msjOk(obj.msj);					
                    $("#table_persona").trigger('reloadGrid');
					
					$('#id_cperson').val(obj.id);
					$('#txt_paterno_c').val($('#txt_paterno').val());
					$('#txt_materno_c').val($('#txt_materno').val());
					$('#txt_nombre_c').val($('#txt_nombre').val());
					$('#txt_email_c').val($('#txt_email').val());        
					$('#txt_celular_c').val($('#txt_celular').val());
					$('#txt_telefono_casa_c').val($('#txt_telefono_casa').val());
					$('#txt_telefono_oficina_c').val($('#txt_telefono_oficina').val());
					$('#slct_estado_civil_c').val($('#slct_estado_civil').val());
					$('#txt_dni_c').val($('#txt_dni').val());
					$('#slct_sexo_c').val($('#slct_sexo').val());
					$('#txt_fecha_nacimiento_c').val($('#txt_fecha_nacimiento').val());
					$('#slct_departamento_c').val($('#slct_departamento').val());
					if($('#slct_departamento').val()!=''){
					ubigeoDAO.cargarProvincia(sistema.llenaSelect,'slct_departamento_c','slct_provincia_c',$('#slct_provincia').val());	
					ubigeoDAO.cargarDistrito(sistema.llenaSelect,'slct_departamento_c','slct_provincia_c','slct_distrito_c',$('#slct_distrito').val());		
					}
                    $('#slct_departamento_c2').val($('#slct_departamento3').val());
                    if($('#slct_departamento3').val()!=''){
                    ubigeoDAO.cargarProvincia(sistema.llenaSelect,'slct_departamento_c2','slct_provincia_c2',$('#slct_provincia3').val()); 
                    ubigeoDAO.cargarDistrito(sistema.llenaSelect,'slct_departamento_c2','slct_provincia_c2','slct_distrito_c2',$('#slct_distrito3').val());     
                    }
					$('#txt_colegio_c').val($('#txt_colegio').val());
					$('#slct_Tipo_c').val($('#slct_Tipo').val());
					$("#mantenimiento_persona").css("display",'none');
                }else if(obj.rst=='2'){
                    sistema.msjAdvertencia(obj.msj,3000);					
                }else{
                    sistema.msjErrorCerrar(obj.msj);
                }
            },
            error: this.msjErrorAjax
        });
    },
    ActualizarPersona:function(){
		$.ajax({
            url:this.url,
            type:'POST',
            //async:false,//no ejecuta otro ajax hasta q este termine
            dataType:'json',
            data:{
                comando:'persona',
                accion:'ActualizarPersona',
				cperson:$("#cperson").val(),
                dappape:$('#txt_paterno').val(),
				dapmape:$('#txt_materno').val(),
				dnomper:$('#txt_nombre').val(),
				email1:$('#txt_email').val(),
				ntelpe2:$('#txt_celular').val(),
				ntelper:$('#txt_telefono_casa').val(),
				ntellab:$('#txt_telefono_oficina').val(),
				cestciv:$('#slct_estado_civil').val(),
				ndniper:$('#txt_dni').val(),
				tsexo:$('#slct_sexo').val(),
				fnacper:$('#txt_fecha_nacimiento').val(),
				coddpto:$('#slct_departamento').val(),
				codprov:$('#slct_provincia').val(),
				coddist:$('#slct_distrito').val(),
				ddirper:$('#txt_direccion').val(),
				ddirref:$('#txt_referencia').val(),
				cdptlab:$('#slct_departamento2').val(),
				cprvlab:$('#slct_provincia2').val(),
				cdislab:$('#slct_distrito2').val(),
                cdptcol:$('#slct_departamento3').val(),
                cprvcol:$('#slct_provincia3').val(),
                cdiscol:$('#slct_distrito3').val(),				
				ddirlab:$('#txt_direccion2').val(),
				dnomlab:$('#txt_nombre_trabajo').val(),
				dcolpro:$('#txt_colegio').val(),
				tcolegi:$('#slct_Tipo').val(),
				cfilial:$('#hd_idFilial').val(),
                cusuari: $('#hd_idUsuario').val()
            },
            beforeSend:function(){
                sistema.abreCargando();
            },
            success:function(obj){
                sistema.cierraCargando();
                if(obj.rst=='1'){
                    $('#frmPersona').dialog('close');
                    sistema.msjOk(obj.msj);
                    $("#table_persona").trigger('reloadGrid');
					$("#table_persona2").trigger('reloadGrid');
					
					$('#id_cperson').val(obj.id);
					$('#txt_paterno_c').val($('#txt_paterno').val());
					$('#txt_materno_c').val($('#txt_materno').val());
					$('#txt_nombre_c').val($('#txt_nombre').val());
					$('#txt_email_c').val($('#txt_email').val());        
					$('#txt_celular_c').val($('#txt_celular').val());
					$('#txt_telefono_casa_c').val($('#txt_telefono_casa').val());
					$('#txt_telefono_oficina_c').val($('#txt_telefono_oficina').val());
					$('#slct_estado_civil_c').val($('#slct_estado_civil').val());
					$('#txt_dni_c').val($('#txt_dni').val());
					$('#slct_sexo_c').val($('#slct_sexo').val());
					$('#txt_fecha_nacimiento_c').val($('#txt_fecha_nacimiento').val());
					$('#slct_departamento_c').val($('#slct_departamento').val());
					if($('#slct_departamento').val()!=''){
					ubigeoDAO.cargarProvincia(sistema.llenaSelect,'slct_departamento_c','slct_provincia_c',$('#slct_provincia').val());	
					ubigeoDAO.cargarDistrito(sistema.llenaSelect,'slct_departamento_c','slct_provincia_c','slct_distrito_c',$('#slct_distrito').val());		
					}
                    $('#slct_departamento_c2').val($('#slct_departamento3').val());
                    if($('#slct_departamento3').val()!=''){
                    ubigeoDAO.cargarProvincia(sistema.llenaSelect,'slct_departamento_c2','slct_provincia_c2',$('#slct_provincia3').val()); 
                    ubigeoDAO.cargarDistrito(sistema.llenaSelect,'slct_departamento_c2','slct_provincia_c2','slct_distrito_c2',$('#slct_distrito3').val());     
                    }
					$('#txt_colegio_c').val($('#txt_colegio').val());
					$('#slct_Tipo_c').val($('#slct_Tipo').val());
					$("#mantenimiento_persona").css("display",'none');					
                }else if(obj.rst=='2'){
                    sistema.msjAdvertencia(obj.msj,3000);
                }else{
                    sistema.msjErrorCerrar(obj.msj);
                }
            },
            error:this.msjErrorAjax
        });
    }, 
	InsertarTrabajador:function(trab){
        $.ajax({
            url : this.url,
            type : 'POST',
            //async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
                comando:'persona',
                accion:'InsertarTrabajador',
				dapepat:$('#txt_paterno_t').val(),
				dapemat:$('#txt_materno_t').val(),
				dnombre:$('#txt_nombre_t').val(),
				demail:$('#txt_email_t').val(),
				dtelefo:$('#txt_celular_t').val(),
				ndocper:$('#txt_dni_t').val(),
				tsexo:$('#slct_sexo_t').val(),
				fingven:$('#txt_fecha_ingreso_t').val(),
                fretven:$('#txt_fecha_retiro_t').val(),
				coddpto:$('#slct_departamento_t').val(),
				codprov:$('#slct_provincia_t').val(),
				coddist:$('#slct_distrito_t').val(),
				ddirecc:$('#txt_direccion_t').val(),
				tvended:$('#slct_tipo_trabajador_t').val(),
				codintv:$('#txt_codigo_interno_t').val(),
				cinstit:$('#hd_idInstituto').val(),
				cfilial:$('#hd_idFilial').val(),
				cestado:$('#slct_estado_t').val(),
                cusuari: $('#hd_idUsuario').val(),
                copeven:$("#slct_opeven").val()
            },
            beforeSend : function ( ) {
                sistema.abreCargando();
            },
            success : function ( obj ) {
                sistema.cierraCargando();
                if(obj.rst=='1'){
                    $('#frmTrabajador').dialog('close');
                    sistema.msjOk(obj.msj);
                    $("#table_"+trab).trigger('reloadGrid');					
                }else if(obj.rst=='2'){
                    sistema.msjAdvertencia(obj.msj,3000);					
                }else{
                    sistema.msjErrorCerrar(obj.msj);
                }
            },
            error: this.msjErrorAjax
        });
    },
    ActualizarTrabajador:function(trab){
		$.ajax({
            url:this.url,
            type:'POST',
            //async:false,//no ejecuta otro ajax hasta q este termine
            dataType:'json',
            data:{
                comando:'persona',
                accion:'ActualizarTrabajador',
				cvended:$("#cvended").val(),
                dapepat:$('#txt_paterno_t').val(),
				dapemat:$('#txt_materno_t').val(),
				dnombre:$('#txt_nombre_t').val(),
				demail:$('#txt_email_t').val(),
				dtelefo:$('#txt_celular_t').val(),
				ndocper:$('#txt_dni_t').val(),
				tsexo:$('#slct_sexo_t').val(),
				fingven:$('#txt_fecha_ingreso_t').val(),
                fretven:$('#txt_fecha_retiro_t').val(),
				coddpto:$('#slct_departamento_t').val(),
				codprov:$('#slct_provincia_t').val(),
				coddist:$('#slct_distrito_t').val(),
				ddirecc:$('#txt_direccion_t').val(),
				tvended:$('#slct_tipo_trabajador_t').val(),
				codintv:$('#txt_codigo_interno_t').val(),
				cinstit:$('#hd_idInstituto').val(),
				cfilial:$('#hd_idFilial').val(),
				cestado:$('#slct_estado_t').val(),
                cusuari: $('#hd_idUsuario').val(),
                copeven:$("#slct_opeven").val()
            },
            beforeSend:function(){
                sistema.abreCargando();
            },
            success:function(obj){
                sistema.cierraCargando();
                if(obj.rst=='1'){
                    $('#frmTrabajador').dialog('close');
                    sistema.msjOk(obj.msj);
                    $("#table_"+trab).trigger('reloadGrid');
                }else if(obj.rst=='2'){
                    sistema.msjAdvertencia(obj.msj,3000);
                }else{
                    sistema.msjErrorCerrar(obj.msj);
                }
            },
            error:this.msjErrorAjax
        });
    },
	listarFiltro: function(fxllena,slct_dest,id_slct){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'persona',
				accion:'ListarFiltro',
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
    
    listarOpeven: function(fxllena,slct_dest,id_slct){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'opeven',
				action:'cargarOpevenbyTipcap',
                didetip:$("#slct_vendedor").val()
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
    
    ListarFiltrobyID: function(fxllena,slct_dest,id_slct){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'persona',
				accion:'ListarFiltrobyID',
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
    
	ListarVendedor: function(evento){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'persona',
				accion:'ListarVendedor',
				dapepat:$("#txt_paterno").val(),
				dapemat:$("#txt_materno").val(),
				dnombre:$("#txt_nombre").val(),
				tvended:$("#slct_vendedor").val()
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

    ListarCiclos: function(fxllena,slct_dest,id_slct){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
                comando:'persona',
                accion:'ListarCiclos'
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

    ListarProc: function(){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
                comando:'persona',
                accion:'ListarProc',
                cingalu:$('#txt_cingalu').val()
            },
            beforeSend : function ( ) {
            },
            success : function ( obj ) {
                if( obj.rst==1 ){
                    $('#txt_dcarpro').val(obj.data.split('-')[0]);
                    $('#txt_dinstpro').val(obj.data.split('-')[1]);
                }
            },
            error: this.msjErrorAjax
        });
    },

    ListarResolucion: function(fxllena,slct_dest,id_slct){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
                comando:'persona',
                accion:'ListarResolucion',
                cingalu:$('#txt_cingalu').val()
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

    ListarCursoDestino: function(fxllena,slct_dest,id_slct){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
                comando:'persona',
                accion:'ListarCursoDestino',
                cingalu:$('#txt_cingalu').val()
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

    listarCursoProcedencia: function(evento){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
                comando:'persona',
                accion:'listarCursoProcedencia',
                cingalu:$('#txt_cingalu').val(),
                crescon:$('#slct_resolucion').val().split("_")[0]
            },
            beforeSend : function ( ) {
            },
            success : function ( obj ) {
                if( obj.rst==1 ){
                    evento(obj.data);
                }
            },
            error: this.msjErrorAjax
        });
    },

    ListarProc2: function(evento){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
                comando:'persona',
                accion:'ListarProc',
                cingalu:$('#txt_cingalu').val()
            },
            beforeSend : function ( ) {
            },
            success : function ( obj ) {
                if( obj.rst==1 ){
                    $('#span_dcarpro').html(obj.data.split('-')[0]);
                    $('#span_dinstpro').html(obj.data.split('-')[1]);
                }
            },
            error: this.msjErrorAjax
        });
    },

    RegistrarAsiCon: function(d){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
                comando:'persona',
                accion:'RegistrarAsiCon',
                datos:d.join("^^"),
                cusuari: $('#hd_idUsuario').val(),
                cfilialx: $('#hd_idFilial').val()
            },
            beforeSend : function ( ) {
            },
            success : function ( obj ) {
                if(obj.rst=='1'){
                sistema.msjOk(obj.msj,3000);   
                listacursos();             
                }
                else{
                    sistema.msjAdvertencia(obj.msj);
                }
            },
            error: this.msjErrorAjax
        });
    },

    ActProc: function(){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
                comando:'persona',
                accion:'ActProc',
                cingalu:$('#txt_cingalu').val(),
                dinstpro:$('#txt_dinstpro').val(),
                dcarpro:$('#txt_dcarpro').val(),
                cfilialx:$('#hd_idFilial').val(),
                cusuari: $('#hd_idUsuario').val()
            },
            beforeSend : function ( ) {
            },
            success : function ( obj ) {
                if(obj.rst=='1'){
                sistema.msjOk(obj.msj,3000);                
                }
                else{
                    sistema.msjAdvertencia(obj.msj);
                }
            },
            error: this.msjErrorAjax
        });
    },

    guardarResolucion: function(){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
                comando:'persona',
                accion:'guardarResolucion',
                nrescon:$('#txt_nrescon').val(),
                dautres:$('#txt_dautres').val(),
                frescon:$('#txt_fecha').val(),
                cingalu:$('#txt_cingalu').val(),                
                cfilialx:$('#hd_idFilial').val(),
                cusuari: $('#hd_idUsuario').val()
            },
            beforeSend : function ( ) {
            },
            success : function ( obj ) {
                if(obj.rst=='1'){
                sistema.msjOk(obj.msj,3000);  
                ListarResolucion('');   
                cancelar();           
                }
                else{
                    sistema.msjAdvertencia(obj.msj);
                }
            },
            error: this.msjErrorAjax
        });
    },

    editarResolucion: function(){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
                comando:'persona',
                accion:'editarResolucion',
                nrescon:$('#txt_nrescon').val(),
                dautres:$('#txt_dautres').val(),
                frescon:$('#txt_fecha').val(),
                cingalu:$('#txt_cingalu').val(),
                crescon:$('#txt_crescon').val(),
                cfilialx:$('#hd_idFilial').val(),
                cusuari: $('#hd_idUsuario').val()
            },
            beforeSend : function ( ) {
            },
            success : function ( obj ) {
                if(obj.rst=='1'){
                sistema.msjOk(obj.msj,3000);  
                ListarResolucion($('#slct_resolucion').val());    
                cancelar();         
                }
                else{
                    sistema.msjAdvertencia(obj.msj);
                }
            },
            error: this.msjErrorAjax
        });
    },

    addProcedencia: function(){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
                comando:'persona',
                accion:'addProcedencia',
                daspral:$('#txt_daspral').val(),
                cingalu:$('#txt_cingalu').val(),
                dcarpro:$('#txt_dcarpro').val(),
                dinstpro:$('#txt_dinstpro').val(),
                cciclo:$('#slct_ciclo').val(),
                ncredit:$('#txt_ncredit').val(),
                nhorteo:$('#txt_nhorteo').val(),
                nhorpra:$('#txt_nhorpra').val(),
                cfilialx:$('#hd_idFilial').val(),
                cusuari: $('#hd_idUsuario').val()
            },
            beforeSend : function ( ) {
            },
            success : function ( obj ) {
                if(obj.rst=='1'){
                sistema.msjOk(obj.msj,3000);  
                $('#frmProcedencia').dialog('close');
                $("#table_curso_proc").trigger('reloadGrid');              
                }
                else{
                    sistema.msjAdvertencia(obj.msj);
                }
            },
            error: this.msjErrorAjax
        });
    },

    editProcedencia: function(){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
                comando:'persona',
                accion:'editProcedencia',
                caspral:$('#txt_caspral').val(),
                cingalu:$('#txt_cingalu').val(),
                daspral:$('#txt_daspral').val(),
                cciclo:$('#slct_ciclo').val(),
                ncredit:$('#txt_ncredit').val(),
                nhorteo:$('#txt_nhorteo').val(),
                nhorpra:$('#txt_nhorpra').val(),
                cestado:$('#slct_estado').val(),
                cfilialx:$('#hd_idFilial').val(),
                cusuari: $('#hd_idUsuario').val()
            },
            beforeSend : function ( ) {
            },
            success : function ( obj ) {
                if(obj.rst=='1'){
                sistema.msjOk(obj.msj,3000); 
                $('#frmProcedencia').dialog('close');
                $("#table_curso_proc").trigger('reloadGrid');               
                }
                else{
                    sistema.msjAdvertencia(obj.msj);
                }
            },
            error: this.msjErrorAjax
        });
    },

    ActualizarDocumentos: function(obj){
        var valm="";        
        
        if($("#valida_proceso_convalidacion").css('display')!='none'){
        valm="ok";  
        }

        var dcompr="0";
        if($("#validatotal").attr("checked")){
        dcompr="1";
        }

        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
                comando:'persona',
                accion:'ActualizarDocumentos',
                cingalu:$('#txt_cingalu').val(),
                cgracpr:$('#txt_cgracpr').val(),
                nfotos:$('#slct_nro_fotos').val(),
                certest:$("#txt_cod_cert_est").val(),
                partnac:$("#txt_cod_part_nac").val(),
                fotodni:$('#slct_rdo_fotoc_dni').val(),
                otrodni:$('#txt_otro_doc').val(),

                /*/////////////DATOS PARA EL PROCESO DE CONVALIDACIÓN ////////////*/
                cpais:$("#slct_pais_procedencia").val(),
                tinstip:$("#slct_tipo_institucion").val(),
                dinstip:$("#txt_institucion").val(),
                dcarrep:$("#txt_carrera_procedencia").val(),
                ultanop:$("#slct_ultimo_año").val(),
                dciclop:$("#slct_ciclo").val(),
                ddocval:$("#txt_docum_vali").val(),
                valconv:valm,
                cfilial:$('#hd_idFilial').val(),
                cusuari: $('#hd_idUsuario').val(),
                dcompro:dcompr
            },
            beforeSend : function ( ) {
            },
            success : function ( obj ) {
                if(obj.rst=='1'){
                sistema.msjOk(obj.msj,3000);
                Limpiar();
                $("#table_persona_ingalum").trigger('reloadGrid');
                }
            },
            error: this.msjErrorAjax
        });
    },    
    cargarModalidadIngresoDocumento: function(evento,cmod){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
                comando:'persona',
                accion:'cargarModalidadIngresoDocumento',
                cmoding:cmod
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
    /**
     * Guarda todos los sueldos de todos los vendedores listados
     * @param data : cadena de id vendedor y sueldos concatenados id*sueldo|id*sueldo|....
     */
    guardarSueldosVendedores: function (data) {
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
                comando: 'persona',
                accion: 'guardarSueldosVendedores',
                cfilial:$('#hd_idFilial').val(),
                cusuari: $('#hd_idUsuario').val(),
                data: data
            },
            beforeSend : function ( ) {
            },
            success : function ( obj ) {
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
        sistema.cierraCargando();
        sistema.msjErrorCerrar('<b>Error, pongase en contacto con Sistemas</b>');
    }
}