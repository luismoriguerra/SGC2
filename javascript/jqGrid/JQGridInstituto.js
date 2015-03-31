var jQGridInstituto={
    type:'json',
    idLayerMessage:'layerMessage',
    Instituto: function(){
        var gridC=$('#table_instituto').jqGrid({
            url:'../controlador/controladorSistema.php?comando=instituto&action=jqgrid_instituto',
            datatype:this.type,
            gridview:true,
            height:345,
            colNames:['Nombre','Código','Modalidad',"Estado"],
            colModel:[
               
                {name:'dinstit',index:'dinstit',align:'left',width:320,editable:true,editrules:{required:true},sorttype:"text"}, 
				{name:'dnmeins',index:'dnmeins',align:'center',width:50,editable:true,editrules:{required:true},sorttype:"text"}, 
				{name:'cmodali',index:'cmodali',align:'center',width:100,editable:true,editrules:{required:true},stype:"select",edittype:"select",editoptions:{value:" : ;1:Presencial;2:Virtual"}},
				{name:'cestado',index:'cestado',align:'center',width:100,editable:true,editrules:{required:true},stype:"select",edittype:"select",editoptions:{value:" : ;1:Activo;0:Inactivo"}}//" : , para coger todos los valores 1 y 0, campo required lo interpreta en blanco"
            ],
            rowNum:15,
            //rowList:[5,10],
            rownumbers:true,
            pager:'#pager_table_instituto',
            sortname:'cinstit',
            sortorder:'asc',
            loadui: "block"
        });
		
        $("#table_instituto").jqGrid('filterToolbar');
        gridC[0].toggleToolbar();//oculta fila de busqueda, boton "buscar registro" lo activara
        $('#table_instituto').jqGrid('navGrid','#pager_table_instituto',{edit:true,add:true,del:false,view:false,search:false},
         {
                url : '../controlador/controladorSistema.php',
                reloadAfterSubmit : true,
                clearAfterEdit : true,
                closeAfterEdit : true,
                editData : {comando : 'instituto', action : 'actualizarInstituto',cfilialx:$('#hd_idFilial').val(), usuario_modificacion : $('#hd_idUsuario').val()},
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
                editData : {comando : 'instituto', action : 'insertarInstituto',cfilialx:$('#hd_idFilial').val(), usuario_creacion : $('#hd_idUsuario').val()},
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
        $("#table_instituto").jqGrid('navButtonAdd',"#pager_table_instituto",{
            caption:"",
            title:"Buscar Registro", 
            buttonicon :'icon-search', 
            onClickButton:function(){
                gridC[0].toggleToolbar() 
            } 
        });
    }
}


