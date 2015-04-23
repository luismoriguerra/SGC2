var jQGridAmbiente={
    type:'json',
    idLayerMessage:'layerMessage',
    Ambiente: function(){
        var gridC=$('#table_ambiente').jqGrid({
            url:'../controlador/controladorSistema.php?comando=ambiente&action=jqgrid_ambiente&cfilial='+$("#hd_idFilials").val(),
            datatype:this.type,
            gridview:true,
            height:345,
            colNames:[
                "cfilial",
                "Filial",
                "ctipamb",
                "Tipo Ambiente",
                "Nro Ambiente",
                "Capacidad",
                "Metros Cuadrados",
				"Total Maquinas",
				"Estado",
				"cestado"
            ],
            colModel:[               
        {name:'cfilial',index:'cfilial',align:'left',width:20,editable:true,editrules:{required:true},sorttype:"text",hidden:true},
        {name:'dfilial',index:'dfilial',align:'left',width:100,editable:true,editrules:{required:true},sorttype:"text"},
        {name:'ctipamb',index:'ctipamb',align:'left',width:20,editable:true,editrules:{required:true},sorttype:"text",hidden:true},
        {name:'dtipamb',index:'dtipamb',align:'left',width:100,editable:true,editrules:{required:true},sorttype:"text"},
        {name:'numamb',index:'numamb',align:'center',width:100,editable:true,editrules:{required:true},sorttype:"text"},
        {name:'ncapaci',index:'ncapaci',align:'center',width:100,editable:true,editrules:{required:true},sorttype:"text"},
        {name:'nmetcua',index:'nmetcua',align:'center',width:100,editable:true,editrules:{required:true},sorttype:"text"},
        {name:'ntotmaq',index:'ntotmaq',align:'left',width:100,editable:true,editrules:{required:true},sorttype:"text"},  
        {name:'estado',index:'estado',align:'center',width:90,editable:true,editrules:{required:true},stype:"select",edittype:"select",editoptions:{value:" : ;1:Activo;0:Inactivo"}},//" : , para coger todos los valores 1 y 0, campo required lo interpreta en blanco"
        {name:'cestado',index:'cestado',align:'left',width:150,editable:true,editrules:{required:true},sorttype:"text",hidden:true},   
            ],
            rowNum:15,
            //rowList:[5,10],
            rownumbers:true,
            pager:'#pager_table_ambiente',
            sortname:'a.cambien',
            sortorder:'asc',
            loadui: "block"
        });
		
        $("#table_ambiente").jqGrid('filterToolbar');
        gridC[0].toggleToolbar();//oculta fila de busqueda, boton "buscar registro" lo activara
        $('#table_ambiente').jqGrid('navGrid','#pager_table_ambiente',{edit:false,add:false,del:false,view:false,search:false});
        
        //Agregando boton Insert
        $('#table_ambiente').jqGrid('navButtonAdd','pager_table_ambiente',{
            caption:"",
            title:"Agregar Ambiente",
            buttonicon:'ui-icon-plus',
            onClickButton:function(){
                add_ambiente_jqgrid();
            }
        });
        
        $('#table_ambiente').jqGrid('navButtonAdd','pager_table_ambiente',{
            caption:"",
            title:"Editar Ambiente",
            buttonicon:'ui-icon-pencil',
            onClickButton:function(){
                edit_ambiente_jqgrid();
            }
        });
        // Agregango boton custom
        $("#table_ambiente").jqGrid('navButtonAdd',"#pager_table_ambiente",{
            caption:"",
            title:"Buscar Registro", 
            buttonicon :'icon-search', 
            onClickButton:function(){
                gridC[0].toggleToolbar() 
            } 
        });
        //fin boton custom
    },
    TipoAmbiente: function(){
        var gridC=$('#table_tipo_ambiente').jqGrid({
            url:'../controlador/controladorSistema.php?comando=ambiente&action=jqgrid_tipo_ambiente',
            datatype:this.type,
            gridview:true,
            height:345,
            colNames:['Nombre','Apocope',"Estado"],
            colModel:[
               
                {name:'dtipamb',index:'dtipamb',align:'left',width:320,editable:true,editrules:{required:true},sorttype:"text"}, 
                {name:'dnetiam',index:'dnetiam',align:'left',width:100,editable:true,editrules:{required:true},sorttype:"text"},                
                {name:'cestado',index:'cestado',align:'center',width:100,editable:true,editrules:{required:true},stype:"select",edittype:"select",editoptions:{value:" : ;1:Activo;0:Inactivo"}}//" : , para coger todos los valores 1 y 0, campo required lo interpreta en blanco"
            ],
            rowNum:15,
            //rowList:[5,10],
            rownumbers:true,
            pager:'#pager_table_tipo_ambiente',
            sortname:'dtipamb',
            sortorder:'asc',
            loadui: "block"
        });
        
        $("#table_tipo_ambiente").jqGrid('filterToolbar');
        gridC[0].toggleToolbar();//oculta fila de busqueda, boton "buscar registro" lo activara
        $('#table_tipo_ambiente').jqGrid('navGrid','#pager_table_tipo_ambiente',{edit:true,add:true,del:false,view:false,search:false},
         {
                url : '../controlador/controladorSistema.php',
                reloadAfterSubmit : true,
                clearAfterEdit : true,
                closeAfterEdit : true,
                editData : {comando : 'ambiente', action : 'actualizarTipoAmbiente',cfilialx:$('#hd_idFilial').val(), usuario_modificacion : $('#hd_idUsuario').val()},
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
                editData : {comando : 'ambiente', action : 'insertarTipoAmbiente',cfilialx:$('#hd_idFilial').val(), usuario_creacion : $('#hd_idUsuario').val()},
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
        $("#table_tipo_ambiente").jqGrid('navButtonAdd',"#pager_table_tipo_ambiente",{
            caption:"",
            title:"Buscar Registro", 
            buttonicon :'icon-search', 
            onClickButton:function(){
                gridC[0].toggleToolbar() 
            } 
        });
    }
}


