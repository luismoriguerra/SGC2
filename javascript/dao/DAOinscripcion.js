var inscripcionDAO={
	url:'../controlador/controladorSistema.php',    
    InsertarInscripcion:function(){
		var id="";
		if($("#lista_grupos .ui-state-highlight").attr("id")){
		id=$("#lista_grupos .ui-state-highlight").attr("id").split("-")[1];	
		}
		
		var dcompr="0";
		if($("#validatotal").attr("checked")){
		dcompr="1";
		}
		
		var valm="";
		
		var v=$("#slct_modalidad_ingreso").val().split("-")[1];
		if(v=="S"){
		valm="ok";	
		}
        $.ajax({
            url : this.url,
            type : 'POST',
            //async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
                comando:'inscrito',
                accion:'InsertarInscripcion',
				persona_elegida:$("#txt_persona_elegida").val(),
				persona_elegida_monto:$("#txt_nmonrec_concepto").val(),
				cperson:$('#id_cperson').val(),
				/*Datos de Admision*/
				locestu:$("#slct_local_estudio").val(),
				cinstit:$('#slct_local_instituto').val().split("-")[0],
				//cmodali:$("#slct_modalidad").val(),
				tmodpos:$('#slct_modalidad_ingreso').val().split("-")[0],
				cmoding:$('#slct_modalidad_ingreso').val().split("-")[0],
				tmodpos2:$("#txt_nueva_modalidad").val(),
				cmoding2:$("#txt_nueva_modalidad").val(),
				csemadm:$('#slct_semestre').val(),
				cseming:$('#slct_semestre').val(),
				nfotos:$('#slct_nro_fotos').val(),
				
				dcompro:dcompr,
				dproeco:$("#txt_promocion_economica").val(),
				/*
				ciniing:$('#slct_inicio').val(),
				cinicio:$('#slct_inicio').val(),
				ccarrer:$('#slct_carrera').val(),
				ctipcar:$('#slct_tipo_carrera').val(),				
				*/
				cgruaca:id,
				posbeca:$("#slct_solo_beca").val(), // para presencial preguntar nomas XD
				/*//////////////////////*/
				/*//////////DOCUMENTOS ACADÉMICOS OBLIGATORIOS PARA EL PROCESO DE ADMISIÓN//////////*/
				certest:$("#txt_cod_cert_est").val(),
				partnac:$("#txt_cod_part_nac").val(),
				fotodni:$('#slct_rdo_fotoc_dni').val(),
				otrodni:$('#txt_otro_doc').val(),
				/*//////////////////////*/
				/*///////////////// PAGO INSCRIPCIÓN //////////////////////////////*/
				tipo_pago_ins:$("#slct_tipo_pago_ins").val(),
				cconcep_ins:$("#slct_concepto_ins").val().split("-")[0],
				monto_pago_ins:$("#txt_monto_pagado_ins").val(),
				fecha_pago_ins:$("#txt_fecha_pago_ins").val(),
				monto_deuda_ins:($("#slct_concepto_ins").val().split("-")[1]*1-$("#txt_monto_pagado_ins").val()*1),
				fecha_deuda_ins:$("#txt_fecha_pago_ins").val(),
				tipo_documento_ins:$("#slct_tipo_documento_ins").val(),
				serie_boleta_ins:$("#txt_serie_boleta_ins").val(),
				numero_boleta_ins:$("#txt_nro_boleta_ins").val(),
				numero_voucher_ins:$("#txt_nro_voucher_ins").val(),
				banco_voucher_ins:$("#slct_banco_ins").val(),
				/*////////////////////////////////////////////////////////*/
				/*////////////PAGO MATRÍCULA/////////////////////////////////////*/
				condi_pago:$("#slct_condicion_pago").val(),				
				tipo_pago:$("#slct_tipo_pago").val(),
				cconcep:$("#slct_concepto").val().split("-")[0],
				monto_pago:$("#txt_monto_pagado").val(),
				fecha_pago:$("#txt_fecha_pago").val(),
				monto_deuda:($("#slct_concepto").val().split("-")[1]*1-$("#txt_monto_pagado").val()*1),
				fecha_deuda:$("#txt_fecha_pago").val(),
				tipo_documento:$("#slct_tipo_documento").val(),
				serie_boleta:$("#txt_serie_boleta").val(),
				numero_boleta:$("#txt_nro_boleta").val(),
				numero_voucher:$("#txt_nro_voucher").val(),
				banco_voucher:$("#slct_banco").val(),
				/*///////////////////////////////////////////////////////*/
				/*///////////////////CONVALIDACIÓN/////////////////////////*/
				cconcep_convalida:$("#slct_concepto_convalida").val().split("-")[0],
				monto_pago_convalida:$("#txt_monto_pagado_convalida").val(),
				fecha_pago_convalida:$("#txt_fecha_pago_convalida").val(),
				monto_deuda_convalida:($("#slct_concepto_convalida").val().split("-")[1]*1-$("#txt_monto_pagado_convalida").val()*1),
				fecha_deuda_convalida:$("#txt_fecha_pago_convalida").val(),
				tipo_documento_convalida:$("#slct_tipo_documento_convalida").val(),
				serie_boleta_convalida:$("#txt_serie_boleta_convalida").val(),
				numero_boleta_convalida:$("#txt_nro_boleta_convalida").val(),
				numero_voucher_convalida:$("#txt_nro_voucher_convalida").val(),
				banco_voucher_convalida:$("#slct_banco_convalida").val(),
				/*/////////////////////////////////////////////////////*/
				//////////////////////// PAGO PENSIÓN/////////////////				
				cconcep_pension:$("#slct_concepto_pension").val().split("-")[0],
				monto_pago_pension:$("#txt_monto_pagado_pension").val(),
				fecha_pago_pension:$("#txt_fecha_pago_pension").val(),
				monto_deuda_pension:$("#txt_monto_deuda_pension").val(),
				fecha_deuda_pension:$("#txt_fecha_pago_pension").val(),
				tipo_documento_pension:$("#slct_tipo_documento_pension").val(),
				serie_boleta_pension:$("#txt_serie_boleta_pension").val(),
				numero_boleta_pension:$("#txt_nro_boleta_pension").val(),
				numero_voucher_pension:$("#txt_nro_voucher_pension").val(),
				banco_voucher_pension:$("#slct_banco_pension").val(),
				ctaprom:$("#slct_concepto_pension").val().split("-")[2],
				mtoprom:$("#slct_concepto_pension").val().split("-")[3],
				monto_concepto_pension:$("#slct_concepto_pension").val().split("-")[1],
				/*////////////////////////////////////////////////////////*/
				/*/////////////DATOS PARA EL PROCESO DE CONVALIDACIÓN ////////////*/
				cpais:$("#slct_pais_procedencia").val(),
				tinstip:$("#slct_tipo_institucion").val(),
				dinstip:$("#txt_institucion").val(),
				dcarrep:$("#txt_carrera_procedencia").val(),
				ultanop:$("#slct_ultimo_año").val(),
				dciclop:$("#slct_ciclo").val(),
				ddocval:$("#txt_docum_vali").val(),
				valconv:valm,
				/*////////////////////////////////////////////////////////////////*/
				ctipcap:$('#slct_medio_captacion').val().split("-")[0],
				dclacap:$('#slct_medio_captacion').val().split("-")[1],
				destica:$('#txt_medio_captacion').val(),
				medio_prensa:$('#slct_medio_prensa').val().split("|")[0],
				id_cvended_jqgrid:$('#id_cvended_jqgrid').val(),
				/*id_cvended_p:$('#id_cvended_p').val(),				
				id_cvended_t:$('#id_cvended_t').val(),
				id_cvended_w:$('#id_cvended_w').val(),
				id_cvended_doa:$('#id_cvended_doa').val(),
				id_cvended_exa:$('#id_cvended_exa').val(),*/
				crecepc:$('#id_cvended_r').val(),
				finscri:$('#txt_fecha').val(),
				dcodlib:$('#txt_codigo_libro_cod').val()+"-"+$('#txt_codigo_libro').val(),// verificar campo maximo
				ccencap:$("#slct_centro_captacion").val(),
				serinsc:$('#txt_codigo_ficha_insc1').val()+"-"+$('#txt_codigo_ficha_insc2').val(), 
				sermatr:$('#txt_codigo_ficha_insc1').val()+"-"+$('#txt_codigo_ficha_insc2').val(), 
				/*/////////////////////////////////////////////////////////////////////////////////*/
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
					LimpiarInscripcion();
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