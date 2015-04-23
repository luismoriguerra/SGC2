var jQGridCurso={
    type:'json',
    idLayerMessage:'layerMessage',
    Curso: function(){
        var gridC=$('#table_curso').jqGrid({
            url:'../controlador/controladorSistema.php?comando=curso&action=jqgrid_curso&cinstit2='+$("#hd_idInstituto").val(),
            datatype:this.type,
            gridview:true,
            height:470,
            colNames:['Institución','Código','Descripcion','Abreviatura',"Estado"],
            colModel:[               
                {name:'cinstit',index:'cinstit',align:'center',width:120,editable:true,editrules:{required:true},stype:"select",edittype:"select",editoptions:{value:$("#cinstits").val()}},
				{name:'codicur',index:'codicur',align:'left',width:120,editable:true,editrules:{required:true},sorttype:"text"}, 
				{name:'dcurso',index:'dcurso',align:'left',width:250,editable:true,editrules:{required:true},sorttype:"text"}, 
				{name:'dnemoni',index:'dnemoni',align:'left',width:150,editable:true,editrules:{required:true},sorttype:"text"},
				{name:'cestado',index:'cestado',align:'center',width:100,editable:true,editrules:{required:true},stype:"select",edittype:"select",editoptions:{value:" : ;1:Activo;0:Inactivo"}}//" : , para coger todos los valores 1 y 0, campo required lo interpreta en blanco"
            ],
            rowNum:20,
            //rowList:[5,10],
            rownumbers:true,
            pager:'#pager_table_curso',
            sortname:'c.ccurso',
            sortorder:'asc',
            loadui: "block"
        });
		
        $("#table_curso").jqGrid('filterToolbar');
        gridC[0].toggleToolbar();//oculta fila de busqueda, boton "buscar registro" lo activara
        $('#table_curso').jqGrid('navGrid','#pager_table_curso',{edit:true,add:true,del:false,view:false,search:false},
         {
                url : '../controlador/controladorSistema.php',
                reloadAfterSubmit : true,
                clearAfterEdit : true,
                closeAfterEdit : true,
                editData : {comando : 'curso', action : 'actualizarCurso',cfilialx:$('#hd_idFilial').val(), usuario_modificacion : $('#hd_idUsuario').val()},
                afterComplete : function ( response, postData, formid ) {
                    var objJSON = $.parseJSON(response.responseText);
                    var status = response.status;
                    if( status == 200 ){
                        if( objJSON.rst==1 ) {
                            sistema.msjOk(objJSON.msg,'2000');
                        }else if(objJSON.rst==2){
                            sistema.msjAdvertencia(objJSON.msg,'5000');
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
                editData : {comando : 'curso', action : 'insertarCurso',cfilialx:$('#hd_idFilial').val(), usuario_creacion : $('#hd_idUsuario').val()},
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
        $("#table_curso").jqGrid('navButtonAdd',"#pager_table_curso",{
            caption:"",
            title:"Buscar Registro", 
            buttonicon :'icon-search', 
            onClickButton:function(){
                gridC[0].toggleToolbar() 
            } 
        });
    },

    CursoSelect: function(){
        var gridC=$('#table_curso').jqGrid({
            url:'../controlador/controladorSistema.php?comando=curso&action=jqgrid_curso&cinstit2='+$("#hd_idInstituto").val(),
            datatype:this.type,
            gridview:true,
            height:250,
            colNames:['Institución','Código','Descripcion','Abreviatura',"Estado"],
            colModel:[               
                {name:'cinstit',index:'cinstit',align:'center',width:120,editable:true,editrules:{required:true},stype:"select",edittype:"select",editoptions:{value:$("#cinstits").val()}},
                {name:'codicur',index:'codicur',align:'left',width:120,editable:true,editrules:{required:true},sorttype:"text"}, 
                {name:'dcurso',index:'dcurso',align:'left',width:250,editable:true,editrules:{required:true},sorttype:"text"}, 
                {name:'dnemoni',index:'dnemoni',align:'left',width:150,editable:true,editrules:{required:true},sorttype:"text"},
                {name:'cestado',index:'cestado',align:'center',width:100,editable:true,editrules:{required:true},stype:"select",edittype:"select",editoptions:{value:" : ;1:Activo;0:Inactivo"}}//" : , para coger todos los valores 1 y 0, campo required lo interpreta en blanco"
            ],
            rowNum:10,
            //rowList:[5,10],
            rownumbers:true,
            pager:'#pager_table_curso',
            sortname:'c.ccurso',
            sortorder:'asc',
            loadui: "block"
        });
        
        $("#table_curso").jqGrid('filterToolbar');
        gridC[0].toggleToolbar();//oculta fila de busqueda, boton "buscar registro" lo activara
        $('#table_curso').jqGrid('navGrid','#pager_table_curso',{edit:false,add:false,del:false,view:false,search:false});

        $("#table_curso").jqGrid('navButtonAdd',"#pager_table_curso",{
            caption:"",
            title:"Buscar Registro", 
            buttonicon :'icon-search', 
            onClickButton:function(){
                gridC[0].toggleToolbar() 
            } 
        });
        $("#table_curso").jqGrid('navButtonAdd',"#pager_table_curso",{
            caption:"",
            title:"Cargar", 
            buttonicon :'icon-ok-sign', 
            onClickButton:function(){
                SeleccionarCurso();
            } 
        }); 

    }
}


