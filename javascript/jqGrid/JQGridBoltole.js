var jQGridBoltole={
    type:'json',
    idLayerMessage:'layerMessage',
    Boltole: function(){
        var gridC=$('#table_boltole').jqGrid({
            url:'../controlador/controladorSistema.php?comando=boltole&action=jqgrid_boltole',
            datatype:this.type,
            gridview:true,
            height:345,
            colNames:['Nombre','Descripcion','Tiempo Dias',"Estado"],
            colModel:[
               
                {name:'dboltole',index:'dboltole',align:'left',width:150,editable:true,editrules:{required:true},sorttype:"text"}, 
				{name:'desbolt',index:'desbolt',align:'left',width:200,editable:true,editrules:{required:true},sorttype:"text"}, 
                {name:'ntiempo',index:'ntiempo',align:'center',width:100,editable:true,editrules:{required:true},stype:"select",edittype:"select",editoptions:{value:" : ;1:1;2:2;3:3;4:4;5:5;6:6;7:7"}},				
                {name:'cestado',index:'cestado',align:'center',width:100,editable:true,editrules:{required:true},stype:"select",edittype:"select",editoptions:{value:" : ;1:Activo;0:Inactivo"}},
            ],
            rowNum:15,
            //rowList:[5,10],
            rownumbers:true,
            pager:'#pager_table_boltole',
            sortname:'cboltole',
            sortorder:'asc',
            loadui: "block"
        });
		
        $("#table_boltole").jqGrid('filterToolbar');
        gridC[0].toggleToolbar();//oculta fila de busqueda, boton "buscar registro" lo activara
        $('#table_boltole').jqGrid('navGrid','#pager_table_boltole',{edit:true,add:true,del:false,view:false,search:false},
         {
                url : '../controlador/controladorSistema.php',
                reloadAfterSubmit : true,
                clearAfterEdit : true,
                closeAfterEdit : true,
                editData : {comando : 'boltole', action : 'actualizarBoltole',cfilialx:$('#hd_idFilial').val(), usuario_modificacion : $('#hd_idUsuario').val()},
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
                editData : {comando : 'boltole', action : 'insertarBoltole',cfilialx:$('#hd_idFilial').val(), usuario_creacion : $('#hd_idUsuario').val()},
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
        $("#table_boltole").jqGrid('navButtonAdd',"#pager_table_boltole",{
            caption:"",
            title:"Buscar Registro", 
            buttonicon :'icon-search', 
            onClickButton:function(){
                gridC[0].toggleToolbar() 
            } 
        });
    }
}


