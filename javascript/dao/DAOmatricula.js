var matriculaDAO={
	url:'../controlador/controladorSistema.php',    
    InsertarMatricula:function(){
        $.ajax({
            url : this.url,
            type : 'POST',
            //async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
                comando:'matricula',
                accion:'InsertarMatricula',
				cperson:$('#txtIdInscrito').val(),
				finscri:$('#txt_fecha_matri').val(),
				sermatr:$('#txt_cod_fic_mat1').val()+"-"+$('#txt_cod_fic_mat2').val(), 
				dcodlib:$('#txt_cod_libro').val(),
				ctipcar:$('#slct_tipo_carrera').val(),
				cmodali:$('#slct_modalidad').val(),
				ccarrer:$('#slct_carrera').val(),
				cseming:$('#slct_semestre').val(),
				ciniing:$('#slct_inicio').val(),
				cmoding:$('#slct_modalidad_ingreso').val(),
				cgruaca:$('#slct_horario').val(),
				dcoduni:$('#txt_cod_univers').val(),
				thorari:'R',
				tusorec:'V',
				testalu:$('#slct_rdo_condic_alum').val(),
				certest:$('#txt_cod_cert_est').val(),
				partnac:$('#txt_cod_part_nac').val(),
				fotodni:$('#slct_rdo_fotoc_dni').val(),
				otrodni:$('#txt_otro_doc').val(),
				crecepc:$('#id_cvended_r').val(),
				
				//////////////////////// Para Pagos /////////////////
				tipo_pago:$("#slct_tipo_pago").val(),
				cconcep:$("#slct_concepto").val().split("-")[0],
				monto_pago:$("#txt_monto_pagado").val(),
				fecha_pago:$("#txt_fecha_pago").val(),
				monto_deuda:($("#slct_concepto").val().split("-")[1]-$("#txt_monto_pagado").val()),
				fecha_deuda:$("#txt_fecha_pago").val(),
				tipo_documento:$("#slct_tipo_documento").val(),
				serie_boleta:$("#txt_serie_boleta").val(),
				numero_boleta:$("#txt_nro_boleta").val(),
				numero_voucher:$("#txt_nro_voucher").val(),
				banco_voucher:$("#slct_banco").val(),
				/////////////////////////////////////////////////////
				//////////////////////// Para Pagos Pensión/////////////////				
				cconcep_pension:$("#slct_concepto_pension").val().split("-")[0],
				monto_pago_pension:$("#txt_monto_pagado_pension").val(),
				fecha_pago_pension:$("#txt_fecha_pago_pension").val(),
				monto_deuda_pension:($("#slct_concepto_pension").val().split("-")[1]-$("#txt_monto_pagado_pension").val()),
				fecha_deuda_pension:$("#txt_fecha_pago_pension").val(),
				tipo_documento_pension:$("#slct_tipo_documento_pension").val(),
				serie_boleta_pension:$("#txt_serie_boleta_pension").val(),
				numero_boleta_pension:$("#txt_nro_boleta_pension").val(),
				numero_voucher_pension:$("#txt_nro_voucher_pension").val(),
				banco_voucher_pension:$("#slct_banco_pension").val(),
				/////////////////////////////////////////////////////
				cinstit:$('#hd_idInstituto').val(),				
				cfilial:$('#hd_idFilial').val(),
                cusuari: $('#hd_idUsuario').val()
            },
            beforeSend : function ( ) {
                sistema.abreCargando();
            },
            success : function ( obj ) {
                sistema.cierraCargando();
                if(obj.rst=='1'){
                    sistema.msjOk(obj.msj);
					LimpiarMatricula();
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