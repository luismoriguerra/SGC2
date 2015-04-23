var jQGridGrupUsu={
    type:'json',
    idLayerMessage:'layerMessage',
    GrupUsu: function(){
        var gridC=$('#table_grupusu').jqGrid({
            url:'../controlador/controladorSistema.php?comando=grupusu&action=jqgrid_grupusu',
            datatype:this.type,
            gridview:true,
            height:345,
            colNames:[
                'Código',
                'Descripcion',
                'Instituto',
                "cinstit",
                "Estado",
                "cestado"
            ],
            colModel:[               

        {name:'cgrupo',index:'cgrupo',align:'left',width:60,editable:true,editrules:{required:true},sorttype:"text",hidden:true}, 
        {name:'dgrupo',index:'dgrupo',align:'left',width:250,editable:true,editrules:{required:true},sorttype:"text"},
        {name:'instit',index:'instit',align:'left',width:250,editable:true,editrules:{required:true},sorttype:"text"},
        {name:'cinstit',index:'cinstit',align:'left',width:150,editable:true,editrules:{required:true},sorttype:"text",hidden:true},
        {name:'estado',index:'estado',align:'center',width:100,editable:true,editrules:{required:true},stype:"select",edittype:"select",editoptions:{value:" : ;1:Activo;0:Inactivo"}},//" : , para coger todos los valores 1 y 0, campo required lo interpreta en blanco"
        {name:'cestado',index:'cestado',align:'left',width:150,editable:true,editrules:{required:true},sorttype:"text",hidden:true},   
            ],
            rowNum:15,
            //rowList:[5,10],
            rownumbers:true,
            pager:'#pager_table_grupusu',
            sortname:'c.cgrupo',
            sortorder:'asc',
            loadui: "block"
        });
		
        $("#table_grupusu").jqGrid('filterToolbar');
        gridC[0].toggleToolbar();//oculta fila de busqueda, boton "buscar registro" lo activara
        $('#table_grupusu').jqGrid('navGrid','#pager_table_grupusu',{edit:false,add:false,del:false,view:false,search:false});
        
        //Agregando boton Insert
        $('#table_grupusu').jqGrid('navButtonAdd','pager_table_grupusu',{
            caption:"",
            title:"Agregar Grupo de Usuarios",
            buttonicon:'ui-icon-plus',
            onClickButton:function(){
                add_grupusu_jqgrid();
            }
        });
        
        $('#table_grupusu').jqGrid('navButtonAdd','pager_table_grupusu',{
            caption:"",
            title:"Editar Grupo",
            buttonicon:'ui-icon-pencil',
            onClickButton:function(){
                edit_grupusu_jqgrid();
            }
        });
        
        // Agregango boton custom
        $("#table_grupusu").jqGrid('navButtonAdd',"#pager_table_grupusu",{
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


