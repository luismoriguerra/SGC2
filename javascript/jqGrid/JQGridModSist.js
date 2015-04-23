var jQGridModSist={
    type:'json',
    idLayerMessage:'layerMessage',
    ModSist: function(){
        var gridC=$('#table_modulo_sist').jqGrid({
            url:'../controlador/controladorSistema.php?comando=modsist&action=jqgrid_modsist',
            datatype:this.type,
            gridview:true,
            height:120,
            colNames:['Nombre',"Estado"],
            colModel:[
               
                {name:'dcagrop',index:'dcagrop',align:'center',width:320,editable:true,editrules:{required:true},sorttype:"text"}, 
				{name:'cestado',index:'cestado',align:'center',width:100,editable:true,editrules:{required:true},stype:"select",edittype:"select",editoptions:{value:" : ;1:Activo;0:Inactivo"}}//" : , para coger todos los valores 1 y 0, campo required lo interpreta en blanco"
            ],
            rowNum:5,
            //rowList:[5,10],
            rownumbers:true,
            pager:'#pager_table_modulo_sist',
            sortname:'ccagrop',
            sortorder:'asc',
            loadui: "block"
        });
		
        $("#table_modulo_sist").jqGrid('filterToolbar');
        gridC[0].toggleToolbar();//oculta fila de busqueda, boton "buscar registro" lo activara
        $('#table_modulo_sist').jqGrid('navGrid','#pager_table_modulo_sist',{edit:true,add:true,del:false,view:false,search:false},
         {
                url : '../controlador/controladorSistema.php',
                reloadAfterSubmit : true,
                clearAfterEdit : true,
                closeAfterEdit : true,
                editData : {comando : 'modsist', action : 'actualizarModSist',cfilialx:$('#hd_idFilial').val(), usuario_modificacion : $('#hd_idUsuario').val()},
                afterComplete : function ( response, postData, formid ) {
                    var objJSON = $.parseJSON(response.responseText);
                    var status = response.status;
                    if( status == 200 ){
                        if( objJSON.rst==1 ) {
                            sistema.msjOk(objJSON.msg,'200');
                        }else if(objJSON.rst==2){
                            sistema.msjAdvertencia(objJSON.msg,'200');
                        }else{
                            sistema.msjError(objJSON.msg,'200');
                        }
                    }else{
                        sistema.msjError('Error general en Proceso','300');
                    }
                }
            },
                     {
               url : '../controlador/controladorSistema.php',
                reloadAfterSubmit : true,
                clearAfterAdd : true,
                closeAfterAdd : true,
                editData : {comando : 'modsist', action : 'insertarModSist',cfilialx:$('#hd_idFilial').val(), usuario_creacion : $('#hd_idUsuario').val()},
                afterComplete : function ( response, postData, formid ) {
                    var objJSON = $.parseJSON(response.responseText);
                    var status = response.status;
                    if( status == 200 ){
                        if( objJSON.rst==1 ) {
                            sistema.msjOk(objJSON.msg,'200');
                        }else if(objJSON.rst==2){
                           sistema.msjAdvertencia(objJSON.msg,'200');
                        }else{
                            sistema.msjError(objJSON.msg,'200');
                        }
                    }else{
                        sistema.msjError('Error general en Proceso','300');
                    }
                }
            }      
        );
        $("#table_modulo_sist").jqGrid('navButtonAdd',"#pager_table_modulo_sist",{
            caption:"",
            title:"Buscar Registro", 
            buttonicon :'icon-search', 
            onClickButton:function(){
                gridC[0].toggleToolbar() 
            } 
        });
    }
}


