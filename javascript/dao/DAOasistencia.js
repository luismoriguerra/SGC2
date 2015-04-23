var asistenciaDAO = {
    url:'../controlador/controladorSistema.php',
            cargarAlumnos:function(evento,grupo){
                  
            $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'asistencia',
            	accion:'cargarAlumnos',
		//DATOS
                cgrupo:grupo
            },
            beforeSend : function ( ) {
		sistema.abreCargando();
            },
            success : function ( obj ) {
		sistema.cierraCargando(); 
                window.console.log(obj);
            	evento(obj.data);             
            },
            error: this.msjErrorAjax
        });
                  
                  
     },
     actualizarSeccionGrupo:function(datag){
         
         //DATOS ENVIADOS
         var data  = datag.split("-");
         
         
         //FUNCION AJAX
         $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'asistencia',
            	accion:'actualizarSeccionGrupo',
		//DATOS
                cgruaca:data[3],
                seccion:data[0],
                cingalu:data[2],
                cperson:data[1],
                //DATOS TRANSACCIONALES
                cfilialx:$("#hd_idFilial").val(),
	  usuario: $("#hd_idUsuario").val()
            },
            beforeSend : function ( ) {
		sistema.abreCargando();
            },
            success : function ( obj ) {
                
		sistema.cierraCargando();            
            },
            error: this.msjErrorAjax
        });
     },
     mostrarListadoCheck:function(evento,grupo,secc){
         
         $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'asistencia',
            	accion:'mostrarListadoCheck',
		//DATOS
                cgrupo:grupo,
                seccion:secc,
                //DATOS TRANSACCIONALES
                cfilialx:$("#hd_idFilial").val(),
		usuario: $("#hd_idUsuario").val()
            },
            beforeSend : function ( ) {
		sistema.abreCargando();
            },
            success : function ( obj ) {
		sistema.cierraCargando(); 
            	evento(obj.data,grupo);             
            },
            error: this.msjErrorAjax
        });
         
     },
     registrarAsistencia:function(idse,estasist,fecha){
         $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'asistencia',
            	accion:'registrarAsistencia',
		//DATOS
                idse:idse,
                estado:estasist,
                fecha:fecha,
                //DATOS TRANSACCIONALES
                cfilialx:$("#hd_idFilial").val(),
		usuario: $("#hd_idUsuario").val()
            },
            beforeSend : function ( ) {
		
            },
            success : function ( obj ) {
		//sistema.cierraCargando(); 
            	            
            },
            error: this.msjErrorAjax
        });
         
         
         
     },
     
	msjErrorAjax:function(){
        sistema.msjErrorCerrar('Error General, pongase en contacto con Sistemas');
    }
}