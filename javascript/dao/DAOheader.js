var headerDAO={
	url:'../controlador/controladorSistema.php',
    cargarHeader: function(){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'carrera',
            	accion:'cargarHeader',
				cgrupo:$("#slct_grupo_cabecera").val()
            },
            beforeSend : function ( ) {
            },
            success : function (obj) {
				
				window.location='vst-inicio.php';
				
			   //sistema.msjOk(obj.msj);
            },
            error: this.msjErrorAjax
        });
    },
	actualizarHeader: function(){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'carrera',
            	accion:'actualizarHeader',
				cfilial:$("#slct_filial_cabecera").val()
            },
            beforeSend : function ( ) {
            },
            success : function (obj) {
				
				window.location='vst-inicio.php';
				
			   //sistema.msjOk(obj.msj);
            },
            error: this.msjErrorAjax
        });
    },
	msjErrorAjax:function(){
        sistema.msjErrorCerrar('Error General, pongase en contacto con Sistemas');
    }
}