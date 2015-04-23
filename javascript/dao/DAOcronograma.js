// JavaScript Document
var cronogramaDAO={
	url:'../controlador/controladorSistema.php',

	guardarCronograma: function(cgrupos){
		var fechas=$(".fechas").map(function(index, element) {
						return $("#"+element.id).val();						
        			}).get().join(",");
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
                comando:'cronograma',
                accion:'insertar_cronograma',
				cfilial:$('#slct_filial').val().join(","),
				cinstit:$('#slct_instituto').val(),
				conceptos:$('#slct_concepto').val().join(","),
				cgracpr:cgrupos,
				//cmodali:$('#slct_modalidad').val(),
				csemaca:$('#slct_semestre').val(),
				cciclo :$('#slct_ciclo').val(),
				cinicio:$('#slct_inicio').val(),
				ctipcar:$('#slct_tipo_carrera').val(),
				ccarrer:$('#slct_carrera').val(),
				ccurric:$('#slct_curricula').val(),
				fvencim:fechas,
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
					validaFechasPago();
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