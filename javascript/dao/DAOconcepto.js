var conceptoDAO={
	url:'../controlador/controladorSistema.php',
    cargarConcepto: function(fxllena,slct_dest,id_slct,cta,pre,tp){
		var cgr="";
		if($.trim($("#lista_grupos .ui-state-highlight").text())!=""){
		cgr=$("#lista_grupos .ui-state-highlight").attr("id").split("-")[1];	
		}
		if($("#slct_local_estudio").val()!=""){
		cfil=$("#slct_local_estudio").val();
		}
		else{
		cfil=$('#hd_idFilial').val();
		}
		if($("#slct_local_instituto").val()!=""){
		cins=$("#slct_local_instituto").val().split("-")[0];
		cmod=$("#slct_local_instituto").val().split("-")[1];
		}
		else{
		cins=$("#hd_idInstituto").val();
		cmod=$("#hd_idModalidad").val();
		}
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'concepto',
            	accion:'cargar_concepto',
				cfilial:cfil,
				cinstit:cins,
				tinscri:tp,
				cgruaca:cgr,
				//cmodali:$("#slct_modalidad").val(),
				cctaing:cta,
				nprecio:pre
            },
            beforeSend : function ( ) {
            },
            success : function ( obj ) {               
            	fxllena(obj.data,slct_dest,id_slct);               
            },
            error: this.msjErrorAjax
        });
    },	
	cargarConceptoPension: function(fxllena,slct_dest,id_slct,cta,pre,tp,cgr){
		if($("#slct_local_estudio").val()!=""){
		cfil=$("#slct_local_estudio").val();
		}
		else{
		cfil=$('#hd_idFilial').val();
		}
		if($("#slct_local_instituto").val()!=""){
		cins=$("#slct_local_instituto").val().split("-")[0];
		cmod=$("#slct_local_instituto").val().split("-")[1];
		}
		else{
		cins=$("#hd_idInstituto").val();
		cmod=$("#hd_idModalidad").val();
		}
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'concepto',
            	accion:'cargar_concepto_pension',
				cfilial:cfil,
				cinstit:cins,
				tinscri:tp,
				//cmodali:$("#slct_modalidad").val(),
				cgruaca:cgr,
				cctaing:cta,
				nprecio:pre
            },
            beforeSend : function ( ) {
            },
            success : function ( obj ) {
            	fxllena(obj.data,slct_dest,id_slct);
            },
            error: this.msjErrorAjax
        });
    },	
	cargarCuentaIngreso: function(fxllena,slct_dest,id_slct){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'concepto',
            	accion:'cargar_cuentas_ingreso',
                validacuentas:$('#validacuentas').val()
            },
            beforeSend : function ( ) {
            },
            success : function ( obj ) {
				fxllena(obj.data,slct_dest,id_slct);
            },
            error: this.msjErrorAjax
        });
    },	
	cargarCuentaIngresoC: function(fxllena,slct_dest,id_slct){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'concepto',
            	accion:'cargar_cuentas_ingreso_comp'
            },
            beforeSend : function ( ) {
            },
            success : function ( obj ) {
				fxllena(obj.data,slct_dest,id_slct);
            },
            error: this.msjErrorAjax
        });
    },	
	CambEstCtaIng: function(){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'concepto',
            	accion :'act_est_cta_ing',
            	cctaing:$("#slct_cuenta_ing").val(),
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
					conceptoDAO.cargarCuentaIngresoC(sistema.llenaSelect,'slct_cuenta_ing',obj.cctaing);
					sistema.limpiaSelect('slct_subcta_2');
					CancelarNuevaCtaIng();
					ValidaBotones();
                }else if(obj.rst=='2'){
                    sistema.msjAdvertencia(obj.msj,3000);
                }else{
                    sistema.msjErrorCerrar(obj.msj);
                }
            },
            error: this.msjErrorAjax
        });
    },	
	cargarSubCuenta1: function(fxllena,slct_orig,slct_dest,id_slct){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'concepto',
            	accion:'cargar_sub_cuentas_1',
				cctaing:$("#"+slct_orig).val(),
                validacuentas:$('#validacuentas').val()
            },
            beforeSend : function ( ) {
            },
            success : function ( obj ) {
                    fxllena(obj.data,slct_dest,id_slct);
            },
            error: this.msjErrorAjax
        });
    },	
	cargarSubCuenta1C: function(fxllena,slct_orig,slct_dest,id_slct){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'concepto',
            	accion:'cargar_sub_cuentas_1_comp',
				cctaing:$("#"+slct_orig).val(),
                validacuentas:$('#validacuentas').val()
            },
            beforeSend : function ( ) {
            },
            success : function ( obj ) {
                    fxllena(obj.data,slct_dest,id_slct);
            },
            error: this.msjErrorAjax
        });
    },	
	CambEstSubCta1: function(){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'concepto',
            	accion :'act_est_sub_cta_1',
            	cctaing:$("#slct_subcta_1").val(),
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
					conceptoDAO.cargarSubCuenta1C(sistema.llenaSelect,'slct_cuenta_ing','slct_subcta_1',obj.cctaing);
					CancelarNuevaSubCta1();
					ValidaBotones();
                }else if(obj.rst=='2'){
                    sistema.msjAdvertencia(obj.msj,3000);
                }else{
                    sistema.msjErrorCerrar(obj.msj);
                }
            },
            error: this.msjErrorAjax
        });
    },	
	cargarSubCuenta2C: function(fxllena,slct_orig,slct_dest,id_slct){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'concepto',
            	accion:'cargar_sub_cuentas_2_comp',
				cctaing:$("#"+slct_orig).val(),
                validacuentas:$('#validacuentas').val()
            },
            beforeSend : function ( ) {
            },
            success : function ( obj ) {
                    fxllena(obj.data,slct_dest,id_slct);
            },
            error: this.msjErrorAjax
        });
    },
	cargarSubCuenta2: function(fxllena,slct_orig,slct_dest,id_slct){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'concepto',
            	accion:'cargar_sub_cuentas_2',
				cctaing:$("#"+slct_orig).val(),
                validacuentas:$('#validacuentas').val()
            },
            beforeSend : function ( ) {
            },
            success : function ( obj ) {
                    fxllena(obj.data,slct_dest,id_slct);
            },
            error: this.msjErrorAjax
        });
    },
	CambEstSubCta2: function(fxllena,slct_dest,id_slct){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'concepto',
            	accion :'act_est_sub_cta_2',
            	cctaing:$("#slct_subcta_2").val(),
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
					conceptoDAO.cargarSubCuenta1C(sistema.llenaSelect,'slct_subcta_1','slct_subcta_2',obj.cctaing);
					CancelarNuevaSubCta2();
					ValidaBotones();
                }else if(obj.rst=='2'){
                    sistema.msjAdvertencia(obj.msj,3000);
                }else{
                    sistema.msjErrorCerrar(obj.msj);
                }
            },
            error: this.msjErrorAjax
        });
    },
	InsertarCuenta: function(){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
                comando:'concepto',
                accion:'Insertar_CuentaIng',
				dctaing:$('#txt_NuevaCtaIng').val(),
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
					conceptoDAO.cargarCuentaIngreso(sistema.llenaSelect,'slct_cuenta_ing',obj.cctaing);
					sistema.limpiaSelect('slct_subcta_1,#slct_subcta_2');
					CancelarNuevaCtaIng();
					ValidaConcepto();
                }else if(obj.rst=='2'){
                    sistema.msjAdvertencia(obj.msj,3000);
                }else{
                    sistema.msjErrorCerrar(obj.msj);
                }
            },
            error: this.msjErrorAjax
        });
	},	
	InsertarCuentaC: function(){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
                comando:'concepto',
                accion:'Insertar_CuentaIng',
				dctaing:$('#txt_NuevaCtaIng').val(),
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
					conceptoDAO.cargarCuentaIngresoC(sistema.llenaSelect,'slct_cuenta_ing',obj.cctaing);
					sistema.limpiaSelect('slct_subcta_1,#slct_subcta_2');
					CancelarNuevaCtaIng();
					ValidaBotones();
                }else if(obj.rst=='2'){
                    sistema.msjAdvertencia(obj.msj,3000);
                }else{
                    sistema.msjErrorCerrar(obj.msj);
                }
            },
            error: this.msjErrorAjax
        });
	},	

	InsertarSubCuenta1: function(){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
                comando:'concepto',
                accion:'Insertar_SubCuenta1',
				tctaing:$('#slct_cuenta_ing').val(),
				dctaing:$('#txt_NuevaSubCta1').val(),
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
					conceptoDAO.cargarSubCuenta1(sistema.llenaSelect,'slct_cuenta_ing','slct_subcta_1',obj.cctaing);
					sistema.limpiaSelect('slct_subcta_2');
					CancelarNuevaSubCta1();
					ValidaConcepto();
                }else if(obj.rst=='2'){
                    sistema.msjAdvertencia(obj.msj,3000);
                }else{
                    sistema.msjErrorCerrar(obj.msj);
                }
            },
            error: this.msjErrorAjax
        });
	},	

	InsertarSubCuenta1C: function(){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
                comando:'concepto',
                accion:'Insertar_SubCuenta1',
				tctaing:$('#slct_cuenta_ing').val(),
				dctaing:$('#txt_NuevaSubCta1').val(),
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
					conceptoDAO.cargarSubCuenta1C(sistema.llenaSelect,'slct_subcta_1',obj.cctaing);
					sistema.limpiaSelect('slct_subcta_2');
					CancelarNuevaSubCta1();
					ValidaBotones();
                }else if(obj.rst=='2'){
                    sistema.msjAdvertencia(obj.msj,3000);
                }else{
                    sistema.msjErrorCerrar(obj.msj);
                }
            },
            error: this.msjErrorAjax
        });
	},

	InsertarSubCuenta2: function(){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
                comando:'concepto',
                accion:'Insertar_SubCuenta2',
				dctaing:$('#txt_NuevaSubCta2').val(),
				tctaing:$('#slct_subcta_1').val(),
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
					conceptoDAO.cargarSubCuenta2(sistema.llenaSelect,'slct_subcta_1','slct_subcta_2',obj.cctaing);
					CancelarNuevaSubCta2();
					ValidaConcepto();
                }else if(obj.rst=='2'){
                    sistema.msjAdvertencia(obj.msj,3000);
                }else{
                    sistema.msjErrorCerrar(obj.msj);
                }
            },
            error: this.msjErrorAjax
        });
	},

	InsertarSubCuenta2C: function(){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
                comando:'concepto',
                accion:'Insertar_SubCuenta2',
				dctaing:$('#txt_NuevaSubCta2').val(),
				tctaing:$('#slct_subcta_1').val(),
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
					conceptoDAO.cargarSubCuenta2C(sistema.llenaSelect,'slct_subcta_1','slct_subcta_2',obj.cctaing);
					CancelarNuevaSubCta2();
					ValidaBotones();
                }else if(obj.rst=='2'){
                    sistema.msjAdvertencia(obj.msj,3000);
                }else{
                    sistema.msjErrorCerrar(obj.msj);
                }
            },
            error: this.msjErrorAjax
        });
	},	
	
	ValidaCuadroConcepto: function(evento){
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
            	comando:'concepto',
            	accion:'valida_conceptos',
				cfilial:$("#slct_filial").val().join(","),
				cinstit:$("#slct_instituto").val(),
				//cmodali:$("#slct_modalidad").val(),
				ctipcar:$("#slct_tipo_carrera").val(),
				tinscri:$("#slct_tipo_pago").val(),
				cctaing1:$("#slct_subcta_1").val(),
				cctaing2:$("#slct_subcta_2").val(),
                cusuari:$('#hd_idUsuario').val(),
				cfilialx:$('#hd_idFilial').val()
            },
            beforeSend : function ( ) {
            },
            success : function ( obj ) {
                if(obj.rst=='1'){
					evento(obj.data);
                }else if(obj.rst=='2'){
					$("#valConceptos .ListaConceptos").remove();
                }else{
                    //sistema.msjErrorCerrar(obj.msj);
				}
            },
            error: this.msjErrorAjax
        });
    },	
	
	GuardarCambiosConceptos: function(datoscjto){
		var carrera='';
		if($("#slct_todas_carreras").val()=="NO"){
		carrera=$("#slct_carrera").val().join(",");
		}
		
        $.ajax({
            url : this.url,
            type : 'POST',
            async:false,//no ejecuta otro ajax hasta q este termine
            dataType : 'json',
            data : {
                comando:'concepto',
                accion:'Guardar_Cambio_Concep',
                datos:datoscjto,
				cfilial:$("#slct_filial").val().join(","),
				cinstit:$("#slct_instituto").val(),
				//cmodali:$("#slct_modalidad").val(),
				ccarrer:carrera,
				valcarr:$("#slct_todas_carreras").val(),
				ctipcar:$("#slct_tipo_carrera").val(),
				tinscri:$("#slct_tipo_pago").val(),
				cctaing1:$("#slct_subcta_1").val(),
				cctaing2:$("#slct_subcta_2").val(),
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
					ValidaConcepto();
					$("#btn_NuevoConcepto").css("display",'');
                }else if(obj.rst=='2'){
                    sistema.msjAdvertencia(obj.msj,3000);
					ValidaConcepto();
					$("#btn_NuevoConcepto").css("display",'');
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