var reporteDAO={
	url:'../controlador/controladorSistema.php',    
    ArqueoCaja:function(evento){
		$.ajax({
            url:this.url,
            type:'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType:'json',
            data:{
                comando:'reporte',
                accion:'ArqueoCaja',
                finicio:$("#txt_fechaInicio").val(),				
				ffin:$("#txt_fechaFin").val(),
				cfilial:$("#hd_idFilial").val()
			},
            beforeSend:function(){
			sistema.abreCargando();
            },
            success:function(obj){
			sistema.cierraCargando();
				if(obj.rst=='1'){
                    evento(obj.data,'');
                }else if(obj.rst=='2'){
					evento(obj.data,'ok');					
                    sistema.msjAdvertencia(obj.msj,3000);					
                }else{
                    sistema.msjErrorCerrar(obj.msj);
                }
                
            },
            error:this.msjErrorAjax
        });
    },
	msjErrorAjax:function(){
        sistema.cierraCargando();
        sistema.msjErrorCerrar('<b>Error, pongase en contacto con Sistemas</b>');
    }
}