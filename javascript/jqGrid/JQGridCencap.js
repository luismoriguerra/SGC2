var jQGridCencap={
    type:'json',
    idLayerMessage:'layerMessage',
    Cencap: function(){
        var gridC=$('#table_cencap').jqGrid({
            url:'../controlador/controladorSistema.php?comando=cencap&action=jqgrid_cencap',
            datatype:this.type,
            gridview:true,
            height:200,
            colNames:[
                'Código',
                'Descripcion',
                'Filial',
                "id_filia",
                "Estado",
                "cestado"
            ],
            colModel:[               

        {name:'ccencap',index:'ccencap',align:'left',width:120,editable:true,editrules:{required:true},sorttype:"text",hidden:true}, 
        {name:'description',index:'description',align:'left',width:250,editable:true,editrules:{required:true},sorttype:"text"},
        {name:'filial',index:'filial',align:'left',width:250,editable:true,editrules:{required:true},sorttype:"text"},
        {name:'cfilial',index:'cfilial',align:'left',width:150,editable:true,editrules:{required:true},sorttype:"text",hidden:true},
        {name:'estado',index:'estado',align:'center',width:100,editable:true,editrules:{required:true},stype:"select",edittype:"select",editoptions:{value:" : ;1:Activo;0:Inactivo"}},//" : , para coger todos los valores 1 y 0, campo required lo interpreta en blanco"
        {name:'cestado',index:'cestado',align:'left',width:150,editable:true,editrules:{required:true},sorttype:"text",hidden:true},   
            ],
            rowNum:20,
            //rowList:[5,10],
            rownumbers:true,
            pager:'#pager_table_cencap',
            sortname:'c.ccencap',
            sortorder:'asc',
            loadui: "block"
        });
		
        $("#table_cencap").jqGrid('filterToolbar');
        gridC[0].toggleToolbar();//oculta fila de busqueda, boton "buscar registro" lo activara
        $('#table_cencap').jqGrid('navGrid','#pager_table_cencap',{edit:false,add:false,del:false,view:false,search:false});
        
        //Agregando boton Insert
        $('#table_cencap').jqGrid('navButtonAdd','pager_table_cencap',{
            caption:"",
            title:"Agregar Centro de Captación",
            buttonicon:'ui-icon-plus',
            onClickButton:function(){
                add_cencap_jqgrid();
            }
        });
        
        $('#table_cencap').jqGrid('navButtonAdd','pager_table_cencap',{
            caption:"",
            title:"Editar centro de captacion",
            buttonicon:'ui-icon-pencil',
            onClickButton:function(){
                edit_cencap_jqgrid();
            }
        });
        
        // Agregango boton custom
        $("#table_cencap").jqGrid('navButtonAdd',"#pager_table_cencap",{
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


