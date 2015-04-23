var registroDAO={
	url:'../controlador/controladorSistema.php', 
	Cargar: function(fxllena,slct_dest,id_slct){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'registro',
            	accion:'Cargar',
				paterno:$("#txt_paterno").val(),
				materno:$("#txt_materno").val(),
				nombre:$("#txt_nombre").val(),
				dni:$("#txt_dni").val()
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
    Insertar:function(){
		$.ajax({
            url : this.url,
            type : 'POST',
            //async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
                comando:'registro',
                accion:'Insertar',
				paterno:$('#txt_paterno').val(),
				materno:$('#txt_materno').val(),
				nombre:$('#txt_nombre').val(),
				dni:$('#txt_dni').val(),
				email:$('#txt_email').val(),
				tel:$('#txt_tel').val(),
				cel:$('#txt_cel').val(),
				carrera:$('#slct_carrera').val()
            },
            beforeSend : function ( ) {
                sistema.abreCargando();
            },
            success : function ( obj ) {
                sistema.cierraCargando();
                if(obj.rst=='1'){
                    sistema.msjOk(obj.msj);
					window.location='http://www.google.com';
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
        sistema.cierraCargando();
        sistema.msjErrorCerrar('<b>Error, pongase en contacto con Sistemas</b>');
    }
}