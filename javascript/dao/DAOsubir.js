var subirDAO={
	url:'../controlador/controladorSistema.php', 
    procesaArchivoImportar:function(){
        $.ajax({
            url :this.url,
            type : 'POST',
            dataType : 'json',
            data : {
                comando : 'transaccion',
                accion : 'procesa_archivo_importar2',
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
    procesaArchivoImportarSilabo:function(){
        $.ajax({
            url :this.url,
            type : 'POST',
            dataType : 'json',
            data : {
                comando : 'transaccion',
                accion : 'procesa_archivo_importar_silabo',
                file : $("#hddFileImportar").val(),
                cusuari : $('#hd_idUsuario').val(),
                cfilialx : $('#hd_idFilial').val(),
                caspral: $('#txt_caspral').val()
            },
            beforeSend : function ( ) {
                sistema.abreCargando();
            },
            success : function ( obj ) {
                sistema.cierraCargando();
                if(obj.rst=='1'){
                    sistema.msjOk(obj.msj,'5000');
                    if($("#listado_archivos").text().split(obj.file).length==1){
                    $('#listado_archivos').append('<br>'+obj.file);    
                    $("#table_curso_proc").trigger('reloadGrid');
                    }                    
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
    uploadImportarsilabo:function() {
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
                    {name : 'accion', value : 'upload_archivo_importar_silabo'},
                ];
                callBack();
            }
        }); 
    },
	msjErrorAjax:function(){
        sistema.cierraCargando();
        sistema.msjErrorCerrar('<b>Error, pongase en contacto con Sistemas</b>');
    }
}