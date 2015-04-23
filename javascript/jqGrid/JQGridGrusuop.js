var jQGridGrUsuOp={
    type:'json',
    idLayerMessage:'layerMessage',
    GrUsuOp: function(){
        var gridC=$('#table_grusuop').jqGrid({
            url:'../controlador/controladorSistema.php?comando=grupusu&action=jqgrid_grusuop',
            datatype:this.type,
            gridview:true,
            height:345,
            colNames:[
                'Cod. Grupo',
				'Grupo',
                'Módulo',
				'ccagrop',
                'Opción',
				'copcion',
                'Estado',
                'cestado'
            ],
            colModel:[               

        {name:'cgrupo',index:'cgrupo',align:'left',width:60,editable:true,editrules:{required:true},sorttype:"text",hidden:true}, 
        {name:'dgrupo',index:'dgrupo',align:'left',width:250,editable:true,editrules:{required:true},sorttype:"text"},
		{name:'dcagrop',index:'dcagrop',align:'left',width:250,editable:true,editrules:{required:true},sorttype:"text"},
        {name:'ccagrop',index:'ccagrop',align:'left',width:150,editable:true,editrules:{required:true},sorttype:"text",hidden:true},
		{name:'dopcion',index:'dopcion',align:'left',width:250,editable:true,editrules:{required:true},sorttype:"text"},
        {name:'copcion',index:'copcion',align:'left',width:150,editable:true,editrules:{required:true},sorttype:"text",hidden:true},
        {name:'estado',index:'estado',align:'center',width:100,editable:true,editrules:{required:true},stype:"select",edittype:"select",editoptions:{value:" : ;1:Activo;0:Inactivo"}},//" : , para coger todos los valores 1 y 0, campo required lo interpreta en blanco"
        {name:'cestado',index:'cestado',align:'left',width:150,editable:true,editrules:{required:true},sorttype:"text",hidden:true},   
            ],
            rowNum:15,
            //rowList:[5,10],
            rownumbers:true,
            pager:'#pager_table_grusuop',
            sortname:'c.cgrupo',
            sortorder:'asc',
            loadui: "block"
        });
		
        $("#table_grusuop").jqGrid('filterToolbar');
        gridC[0].toggleToolbar();//oculta fila de busqueda, boton "buscar registro" lo activara
        $('#table_grusuop').jqGrid('navGrid','#pager_table_grusuop',{edit:false,add:false,del:false,view:false,search:false});
        
        //Agregando boton Insert
        $('#table_grusuop').jqGrid('navButtonAdd','pager_table_grusuop',{
            caption:"",
            title:"Agregar Grupo de Usuarios",
            buttonicon:'ui-icon-plus',
            onClickButton:function(){
                add_grusuop_jqgrid();
            }
        });
        
        $('#table_grusuop').jqGrid('navButtonAdd','pager_table_grusuop',{
            caption:"",
            title:"Editar Grupo",
            buttonicon:'ui-icon-pencil',
            onClickButton:function(){
                edit_grusuop_jqgrid();
            }
        });
        
        // Agregango boton custom
        $("#table_grusuop").jqGrid('navButtonAdd',"#pager_table_grusuop",{
            caption:"",
            title:"Buscar Registro", 
            buttonicon :'icon-search', 
            onClickButton:function(){
                gridC[0].toggleToolbar() 
            } 
        });
        //fin boton custom
    }
}


