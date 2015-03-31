var horarioDAO={
	url:'../controlador/controladorSistema.php',    
	cargarDia: function(fxllena,slct_dest,id_slct){
        $.ajax({
            url : this.url,
            type : 'POST',
            //async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'horario',
            	accion:'cargarDia'
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
                comando:'horario',
                accion:'cargarHora',
                cinstit: $("#cinstit").val()
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
    cargarTipoAmbiente: function(fxllena,slct_dest,id_slct){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
                comando:'horario',
                accion:'cargarTipoAmbiente'
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
    cargarAmbiente: function(fxllena,slct_dest,id_slct,valor){
        $.ajax({
            url : this.url,
            type : 'POST',
            //async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
                comando:'horario',
                accion:'cargarAmbiente',
                ctipamb:valor,
                cfilial:$("#cfilial").val()
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
    cargarTiempoTolerancia: function(fxllena,slct_dest,id_slct){
        $.ajax({
            url : this.url,
            type : 'POST',
            //async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
                comando:'horario',
                accion:'cargarTiempoTolerancia'
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
    guardarHorarios: function(d){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
                comando:'horario',
                accion:'guardarHorarios',
                datos:d,
                cdetgra:$("#slct_detalle_grupo").val().split("|")[0],                
                ccuprpr:$("#ccuprpr").val(),
                cprofes:$('#cprofes').val(),
                finipre:$("#txt_fecha_ini_pre").val(),
                ffinpre:$("#txt_fecha_fin_pre").val(),
                finivir:$("#txt_fecha_ini_vir").val(),
                ffinvir:$("#txt_fecha_fin_vir").val(),
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
                    var idg=$("#lista_grupos .ui-state-highlight").attr('id');
                    grupoAcademicoDAO.cargarCursosAcademicos(VisualizarCursosHTML,idg.substring(4).split("-").join(","));
                }else if(obj.rst=='2'){
                    sistema.msjAdvertencia(obj.msj,3000);
                }else{
                    sistema.msjErrorCerrar(obj.msj);
                }
            },
            error: this.msjErrorAjax
        });
    },      
    cargarHorarioValidado: function(fxllena,slct_dest,id_slct,cprofe,cambie){
        $.ajax({
            url : this.url,
            type : 'POST',
            //async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
                comando:'horario',
                accion:'cargarHorarioValidado',
                cprofes: cprofe,
                cambien: cambie,
                cinstit: $("#cinstit").val(),
                dias   : $("#diasdelgrupo").val()
            },
            beforeSend : function ( ) {
            },
            success : function ( obj ) {                
                    fxllena(obj.data,slct_dest,id_slct,'');                
            },
            error: this.msjErrorAjax
        });
    },
	msjErrorAjax:function(){
        sistema.msjErrorCerrar('Error General, pongase en contacto con Sistemas');
    }
}