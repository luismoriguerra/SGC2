var pagoDAO={
	url:'../controlador/controladorSistema.php',    
    cargarMontoPago:function(ids,fx_success){
		$.ajax({
            url:this.url,
            type:'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType:'json',
            data:{
                comando:'pago',
                accion:'cargar_monto_pago',
                crecacas:ids
			},
            beforeSend:function(){
            },
            success:function(obj){
				if(obj.rst=='1'){
                    fx_success(obj.data,'');
                }else if(obj.rst=='2'){
					fx_success(obj.data,'ok');					
                    sistema.msjAdvertencia(obj.msj,3000);					
                }else{
                    sistema.msjErrorCerrar(obj.msj);
                }
                
            },
            error:this.msjErrorAjax
        });
    },
	cargarMontoAcumulado:function(){
		$.ajax({
            url:this.url,
            type:'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType:'json',
            data:{
                comando:'pago',
                accion:'cargarMontoAcumulado',
                cingalu:$("#txt_cingalu").val(),
				cgracpr:$("#txt_cgracpr").val()
			},
            beforeSend:function(){
            },
            success:function(obj){
				if(obj.rst=='1'){
                    $("#txt_monto_total").val(obj.data[0]['total']);
					$("#slct_operacion").val("");
					$("#slct_operacion").val("R");
					Visualizar($("#slct_operacion").val());
					CalcularComision();					
					sistema.msjOk(obj.msj,4000);
                }
				else if(obj.rst=='2'){
					sistema.msjAdvertencia(obj.msj,4000);
					$('.cont-der input[type="text"],.cont-der input[type="hidden"],.cont-der select').val('');			
					$('#frmRetiro').css('display','none');
					$("#txt_dscto").val('0.30');
                }
				else{
                    sistema.msjErrorCerrar(obj.msj);
                }
                
            },
            error:this.msjErrorAjax
        });
    },
    cargarMontoEscala:function(){
        $.ajax({
            url:this.url,
            type:'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType:'json',
            data:{
                comando:'pago',
                accion:'cargarMontoEscala',
                cingalu:$("#txt_cingalu").val(),
                cgracpr:$("#txt_cgracpr").val()
            },
            beforeSend:function(){
            },
            success:function(obj){
                if(obj.rst=='1'){                    
                    $("#div_monto_escala").html(obj.data['monto']);
                    $("#txt_monto_escala").val(obj.data['monto']);
                    $("#div_escala").html(obj.data['concepto']);
                    $("#txt_escala").val(obj.data['cconcep']);
                    pagoDAO.cargarEscalaPersonalizada(sistema.llenaSelect,'slct_escala','',obj.data['cconcep']);
                    sistema.msjOk(obj.msj,4000);
                }
                else if(obj.rst=='2'){
                    sistema.msjAdvertencia(obj.msj,4000);
                    $('.cont-der input[type="text"],.cont-der input[type="hidden"],.cont-der select').val('');                    
                }
                else{
                    sistema.msjErrorCerrar(obj.msj);
                }
                
            },
            error:this.msjErrorAjax
        });
    },
    cargarEscalaPersonalizada:function(fxllena,slct_dest,id_slct,concep){
        $.ajax({
            url:this.url,
            type:'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType:'json',
            data:{
                comando:'pago',
                accion:'cargarEscalaPersonalizada',                
                cgracpr:$("#txt_cgracpr").val(),
                cconcep:concep
            },
            beforeSend:function(){
            },
            success:function(obj){
                if( obj.length!=0 ){
                    fxllena(obj.data,slct_dest,id_slct);
                }
            },
            error:this.msjErrorAjax
        });
    },
	registrarPago:function(ids){
		$.ajax({
            url:this.url,
            type:'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType:'json',
            data:{
                comando:'pago',
                accion:'registrarPago',
                crecacas:ids.join("','"),				
				monto:$("#txt_monto_pagado").val(),
				deuda:$("#txt_monto_deuda").val(),
				fechapago:$("#txt_fecha_pago").val(),
				tpago:$("#slct_tipo_documento_pension").val(),
				dserbol:$("#txt_serie_boleta_pension").val(),
				dnumbol:$("#txt_nro_boleta_pension").val(),
				numvou:$("#txt_nro_voucher_pension").val(),				
				cbanco:$("#slct_banco_pension").val(),
				cfilial:$('#hd_idFilial').val(),
                cusuari: $('#hd_idUsuario').val()
			},
            beforeSend:function(){
				sistema.abreCargando();
            },
            success : function ( obj ) {
                sistema.cierraCargando();
				if(obj.rst=='1'){
                    sistema.msjOk(obj.msj);
					$('#form_pagos input[type="text"],#form_pagos input[type="hidden"],#form_pagos select').val('');
					$("#val_voucher_pension").css("display","none");
					$("#val_boleta_pension").css("display","none");
					$("#txt_monto_deuda").val("0");
					$("#txt_fecha_pago").val(sistema.getFechaActual('yyyy-mm-dd'));
					$('#form_pagos').dialog('close');	
					$("#table_pago").trigger('reloadGrid');
                }else if(obj.rst=='2'){
                    sistema.msjAdvertencia(obj.msj,3000);
                }else{
                    sistema.msjErrorCerrar(obj.msj);
                }
                
            },
            error:this.msjErrorAjax
        });
	},
	registrarRetiro:function(){
		$.ajax({
            url:this.url,
            type:'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType:'json',
            data:{
                comando:'pago',
                accion:'registrarRetiro',				
				cingalu:$("#txt_cingalu").val(),
				cgracpr:$("#txt_cgracpr").val(),				
				descuen:$("#txt_dscto").val(),
				retensi:$('#txt_monto_retension_retiro').val(),
				comisio:$('#txt_monto_comision_retiro').val(),
				reserva:0,
				fechaop:sistema.getFechaActual('yyyy-mm-dd'),
                cusuari: $('#hd_idUsuario').val(),
				cfilial: $('#hd_idFilial').val()
			},
            beforeSend:function(){
				sistema.abreCargando();
            },
            success : function ( obj ) {
                sistema.cierraCargando();
				if(obj.rst=='1'){
                    sistema.msjOk(obj.msj);
					$('.cont-der input[type="text"],.cont-der input[type="hidden"],.cont-der select').val('');			
					$('#frmRetiro').css('display','none');
					$("#txt_dscto").val('0.30');
					$("#table_persona_ingalum").trigger('reloadGrid');
                }else if(obj.rst=='2'){
                    sistema.msjAdvertencia(obj.msj,3000);					
                }else{
                    sistema.msjErrorCerrar(obj.msj);
                }
                
            },
            error:this.msjErrorAjax
        });
	},
    editBoleta:function(ids){
        $.ajax({
            url:this.url,
            type:'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType:'json',
            data:{
                comando:'pago',
                accion:'editBoleta',                
                dserbol:$("#txt_serie_boleta_edit").val(),
                dnumbol:$("#txt_nro_boleta_edit").val(),
                fecha:$("#txt_fecha_edit").val(),
                fecha2:$("#txt_fecha_edit2").val(),
                dserbol2:$("#txt_serie_boleta_edit2").val(),
                dnumbol2:$("#txt_nro_boleta_edit2").val(),                
                cfilial:$('#hd_idFilial').val(),
                cusuari: $('#hd_idUsuario').val()
            },
            beforeSend:function(){
                sistema.abreCargando();
            },
            success : function ( obj ) {
                sistema.cierraCargando();
                if(obj.rst=='1'){
                    sistema.msjOk(obj.msj);                    
                    $('#form_act_boleta').dialog('close');   
                    $("#table_arqueo").trigger('reloadGrid');
                }else if(obj.rst=='2'){
                    sistema.msjAdvertencia(obj.msj,3000);
                }else{
                    sistema.msjErrorCerrar(obj.msj);
                }
                
            },
            error:this.msjErrorAjax
        });
    },
    cambiarEscala:function(){
        var valores=$("#slct_escala").val().split("-"); 
        $.ajax({
            url:this.url,
            type:'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType:'json',
            data:{
                comando:'pago',
                accion:'cambiarEscala',                
                cingalu:$("#txt_cingalu").val(),
                cgracpr:$("#txt_cgracpr").val(),
                cconcep:$("#txt_escala").val(),
                monto:$("#txt_monto_escala").val(),
                cconcepnuevo:valores[0],
                montonuevo:valores[1],
                cuotanuevo:valores[4],
                montopronuevo:valores[2],
                cuotapronuevo:valores[3],
                cfilial:$('#hd_idFilial').val(),
                cusuari: $('#hd_idUsuario').val()
            },
            beforeSend:function(){
                sistema.abreCargando();
            },
            success : function ( obj ) {
                sistema.cierraCargando();
                if(obj.rst=='1'){
                    sistema.msjOk(obj.msj);  
                    eventoClick();                    
                }else if(obj.rst=='2'){
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