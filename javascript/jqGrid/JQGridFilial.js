var jQGridFilial={
    type:'json',
    idLayerMessage:'layerMessage',
    Filial: function(){
        var gridC=$('#table_filial').jqGrid({
            url:'../controlador/controladorSistema.php?comando=filial&action=jqgrid_filial',
            datatype:this.type,
            gridview:true,
            height:470,
            colNames:['Código','Nombre','Dirección','Telefono',"Estado"],
            colModel:[
               	{name:'cfilial',index:'cfilial',align:'center',width:150,editable:true,editrules:{required:true},sorttype:"text"},
                {name:'dfilial',index:'dfilial',align:'left',width:210,editable:true,editrules:{required:true},sorttype:"text"},
                {name:'ddirfil',index:'ddirfil',align:'left',width:270,editable:true,editrules:{required:true},sorttype:"text"}, 
                {name:'ntelfil',index:'ntelfil',align:'center',width:150,editable:true,editrules:{required:true},sorttype:"text"}, 
                {name:'cestado',index:'cestado',align:'center',width:100,editable:true,editrules:{required:true},stype:"select",edittype:"select",editoptions:{value:" : ;1:Activo;0:Inactivo"}}//" : , para coger todos los valores 1 y 0, campo required lo interpreta en blanco"
            ],
            rowNum:20,
            //rowList:[5,10],
            rownumbers:true,
            pager:'#pager_table_filial',
            sortname:'cfilial',
            sortorder:'asc',
            loadui: "block"
        });
		
        $("#table_filial").jqGrid('filterToolbar');
        gridC[0].toggleToolbar();//oculta fila de busqueda, boton "buscar registro" lo activara
        $('#table_filial').jqGrid('navGrid','#pager_table_filial',{edit:true,add:true,del:false,view:false,search:false},
         {
                url : '../controlador/controladorSistema.php',
                reloadAfterSubmit : true,
                clearAfterEdit : true,
                closeAfterEdit : true,
                editData : {comando : 'filial', action : 'actualizarFilial',cfilialx:$('#hd_idFilial').val(), usuario_modificacion : $('#hd_idUsuario').val()},
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
                editData : {comando : 'filial', action : 'insertarFilial',cfilialx:$('#hd_idFilial').val(), usuario_creacion : $('#hd_idUsuario').val()},
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
        $("#table_filial").jqGrid('navButtonAdd',"#pager_table_filial",{
            caption:"",
            title:"Buscar Registro", 
            buttonicon :'icon-search', 
            onClickButton:function(){
                gridC[0].toggleToolbar() 
            } 
        });
    }
}


