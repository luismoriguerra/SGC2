var jQGridModIng={
    type:'json',
    idLayerMessage:'layerMessage',
    ModIng: function(){
        var gridC=$('#table_moding').jqGrid({
            url:'../controlador/controladorSistema.php?comando=moding&action=jqgrid_moding&cinstit='+$("#hd_idInstituto").val(),
            datatype:this.type,
            gridview:true,
            height:345,
            colNames:[
                'Descripcion',
                'Instituto',
                "cinstit",
				"Validacion?",
				"treqcon",
                "Estado",
                "cestado"
            ],
            colModel:[               
        {name:'dmoding',index:'dmoding',align:'left',width:250,editable:true,editrules:{required:true},sorttype:"text"},
        {name:'dinstit',index:'dinstit',align:'left',width:250,editable:true,editrules:{required:true},sorttype:"text"},
        {name:'cinstit',index:'cinstit',align:'left',width:100,editable:true,editrules:{required:true},sorttype:"text",hidden:true},
		{name:'dreqcon',index:'dreqcon',align:'center',width:100,editable:true,editrules:{required:true},stype:"select",edittype:"select",editoptions:{value:" : ;S:SI;N:NO"}},//" : , para coger todos los valores 1 y 0, campo required lo interpreta en blanco"
		{name:'treqcon',index:'treqcon',align:'left',width:150,editable:true,editrules:{required:true},sorttype:"text",hidden:true}, 
        {name:'destado',index:'destado',align:'center',width:100,editable:true,editrules:{required:true},stype:"select",edittype:"select",editoptions:{value:" : ;1:Activo;0:Inactivo"}},//" : , para coger todos los valores 1 y 0, campo required lo interpreta en blanco"
        {name:'cestado',index:'cestado',align:'left',width:150,editable:true,editrules:{required:true},sorttype:"text",hidden:true},   
            ],
            rowNum:15,
            //rowList:[5,10],
            rownumbers:true,
            pager:'#pager_table_moding',
            sortname:'c.cmoding',
            sortorder:'asc',
            loadui: "block"
        });
		
        $("#table_moding").jqGrid('filterToolbar');
        gridC[0].toggleToolbar();//oculta fila de busqueda, boton "buscar registro" lo activara
        $('#table_moding').jqGrid('navGrid','#pager_table_moding',{edit:false,add:false,del:false,view:false,search:false});
        
        //Agregando boton Insert
        $('#table_moding').jqGrid('navButtonAdd','pager_table_moding',{
            caption:"",
            title:"Agregar Modalidad de Ingreso",
            buttonicon:'ui-icon-plus',
            onClickButton:function(){
                add_moding_jqgrid();
            }
        });
        
        $('#table_moding').jqGrid('navButtonAdd','pager_table_moding',{
            caption:"",
            title:"Editar Modalidad",
            buttonicon:'ui-icon-pencil',
            onClickButton:function(){
                edit_moding_jqgrid();
            }
        });
        
        // Agregango boton custom
        $("#table_moding").jqGrid('navButtonAdd',"#pager_table_moding",{
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


