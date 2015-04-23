var jQGridOpcSist={
    type:'json',
    idLayerMessage:'layerMessage',
    OpcSist: function(){
        var gridC=$('#table_opcsist').jqGrid({
            url:'../controlador/controladorSistema.php?comando=opcsist&action=jqgrid_opcsist',
            datatype:this.type,
            gridview:true,
            height:345,
            colNames:[
                'Descripcion',
                'URL',
                "Comentarios",
                "Estado",
                "cestado"
            ],
            colModel:[               
        {name:'dopcion',index:'dopcion',align:'left',width:250,editable:true,editrules:{required:true},sorttype:"text"},
        {name:'durlopc',index:'durlopc',align:'left',width:250,editable:true,editrules:{required:true},sorttype:"text"},
        {name:'dcoment',index:'dcoment',align:'left',width:400,editable:true,editrules:{required:true},sorttype:"text"},
        {name:'estado',index:'estado',align:'center',width:100,editable:true,editrules:{required:true},stype:"select",edittype:"select",editoptions:{value:" : ;1:Activo;0:Inactivo"}},//" : , para coger todos los valores 1 y 0, campo required lo interpreta en blanco"
        {name:'cestado',index:'cestado',align:'left',width:150,editable:true,editrules:{required:true},sorttype:"text",hidden:true},   
            ],
            rowNum:15,
            //rowList:[5,10],
            rownumbers:true,
            pager:'#pager_table_opcsist',
            sortname:'copcion',
            sortorder:'asc',
            loadui: "block"
        });
		
        $("#table_opcsist").jqGrid('filterToolbar');
        gridC[0].toggleToolbar();//oculta fila de busqueda, boton "buscar registro" lo activara
        $('#table_opcsist').jqGrid('navGrid','#pager_table_opcsist',{edit:false,add:false,del:false,view:false,search:false});
        
        //Agregando boton Insert
        $('#table_opcsist').jqGrid('navButtonAdd','pager_table_opcsist',{
            caption:"",
            title:"Agregar Opcion del Sistema",
            buttonicon:'ui-icon-plus',
            onClickButton:function(){
                add_opcsist_jqgrid();
            }
        });
        
        $('#table_opcsist').jqGrid('navButtonAdd','pager_table_opcsist',{
            caption:"",
            title:"Editar Opcion",
            buttonicon:'ui-icon-pencil',
            onClickButton:function(){
                edit_opcsist_jqgrid();
            }
        });
        
        // Agregango boton custom
        $("#table_opcsist").jqGrid('navButtonAdd',"#pager_table_opcsist",{
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


