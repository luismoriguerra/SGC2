var transaccionDAO={
	url:'../controlador/controladorSistema.php', 
    procesaArchivoImportar:function(){
        $.ajax({
            url :this.url,
            type : 'POST',
            dataType : 'json',
            data : {
                comando : 'transaccion',
                accion : 'procesa_archivo_importar',
                file : $("#hddFileImportar").val(),
                usuario_creacion : $('#hd_idUsuario').val(),
            },
            beforeSend : function ( ) {
                sistema.abreCargando();
            },
            success : function ( obj ) {
                sistema.cierraCargando();
                if(obj.rst=='1'){
                    sistema.msjOk(obj.msj,'5000');
                    cancelaProcesarImportar();//limpia la vista de "procesa"
                }else if(obj.rst=='2'){
                    sistema.msjAdvertenciaCerrar(obj.msj);
                    cancelaProcesarImportar();
                }else{
                    sistema.msjErrorCerrar(obj.msj);
                }
            },
            error: this.msjErrorAjax
        });
    },
    uploadImportar:function() {
        $('#file_uploadImportar').fileUploadUI({
            url : '../controlador/controladorSistema.php',
            fieldName : 'uploadFileImportar',
            uploadTable: $('#filesImportar'),
            autoUpload : true,
            buildUploadRow: function (files, index, handler) {
                return $('<tr><td>' + files[index].name + '<\/td>' +
                    '<td class="file_upload_progress"><div><\/div><\/td>' +
                    '<td class="file_upload_cancel">' +
                    '<button class="ui-state-default ui-corner-all" title="Cancel">' +
                    '<span class="ui-icon ui-icon-cancel">Cancel<\/span>' +
                    '<\/button><\/td><\/tr>');
            },
            buildDownloadRow: function (file, handler) {
            },
            onSend : function (event, files, index, xhr, handler) {
            },
            onComplete : function (event, files, index, xhr, handler) {
                var obj;
                if (typeof xhr.responseText !== 'undef') {
                    obj = $.parseJSON(xhr.responseText);
                } else {
                        // Instead of an XHR object, an iframe is used for legacy browsers:
                    obj = $.parseJSON(xhr.contents().text());
                }
                $('#hddFileImportar').val(obj.file);//si viene vacio, limpia no hay resultado
                $('#spanImportar').html(obj.file);//si viene vacio, limpia no hay resultado
                if( obj.rst==2 ){
                    sistema.msjAdvertencia(obj.msj,'5000');
                    $('#msg_resultado_importar').css('display', 'none');
                }
                if( obj.rst==1 ){
                    $('#msg_resultado_importar').fadeIn('fast');
                    $('#hddFileImportar').val(obj.file_upload);
                }
            },
            beforeSend : function (event, files, index, xhr, handler, callBack) {
                handler.formData = [
                    {name : 'comando', value : 'transaccion'},
                    {name : 'accion', value : 'upload_archivo_importar'},
                ];
                callBack();
            }
        }); 
    },   
    generaTransaccionExportar:function(fx_succes){
		$.ajax({
            url:this.url,
            type:'POST',
            //async:false,//no ejecuta otro ajax hasta q este termine
            dataType:'json',
            data:{
                comando:'transaccion',
                accion:'genera_transaccion_exportar',
				cfilial:$('#hd_idFilial').val(),
                f_ini:$('#txt_fechaInicio').val(),
                f_fin:$('#txt_fechaFin').val()
            },
            beforeSend:function(){
                sistema.abreCargando();
            },
            success:function(obj){
                sistema.cierraCargando();
                if(obj.rst=='1'){
                    fx_succes(obj.file);
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