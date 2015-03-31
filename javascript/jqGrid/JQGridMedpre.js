var jQGridMedpre={
    type:'json',
    idLayerMessage:'layerMessage',
    Medpre: function(){
        var gridC=$('#table_medpre').jqGrid({
            url:'../controlador/controladorSistema.php?comando=medpre&action=jqgrid_medpre',
            datatype:this.type,
            gridview:true,
            height:345,
            colNames:[
                "cmedpre",
                'Medio de Prensa',
                'Abrev',
                "cfilial",
                "Filial"
            ],
            colModel:[
        {name:'cmedpre',index:'cmedpre',align:'left',width:250,editable:true,editrules:{required:true},sorttype:"text",hidden:true},        
        {name:'dmedpre',index:'dmedpre',align:'left',width:250,editable:true,editrules:{required:true},sorttype:"text"},
        {name:'tmedpre',index:'tmedpre',align:'left',width:50,editable:true,editrules:{required:true},stype:"select",edittype:"select",editoptions:{value:" : ;R:Radio;D:Diario;T:Tv"}},
        {name:'cfilial',index:'cfilial',align:'left',width:250,editable:true,editrules:{required:true},sorttype:"text",hidden:true},
        {name:'dfilial',index:'dfilial',align:'center',width:100,editable:true,editrules:{required:true},sorttype:"text"},//" : , para coger todos los valores 1 y 0, campo required lo interpreta en blanco"
        
            ],
            rowNum:15,
            //rowList:[5,10],
            rownumbers:true,
            pager:'#pager_table_medpre',
            sortname:'c.cmedpre',
            sortorder:'asc',
            loadui: "block"
        });
		
        $("#table_medpre").jqGrid('filterToolbar');
        gridC[0].toggleToolbar();//oculta fila de busqueda, boton "buscar registro" lo activara
        $('#table_medpre').jqGrid('navGrid','#pager_table_medpre',{edit:false,add:false,del:false,view:false,search:false});
        
        //Agregando boton Insert
        $('#table_medpre').jqGrid('navButtonAdd','pager_table_medpre',{
            caption:"",
            title:"Agregar Modalidad de Ingreso",
            buttonicon:'ui-icon-plus',
            onClickButton:function(){
                add_medpre_jqgrid();
            }
        });
        
        $('#table_medpre').jqGrid('navButtonAdd','pager_table_medpre',{
            caption:"",
            title:"Editar Modalidad",
            buttonicon:'ui-icon-pencil',
            onClickButton:function(){
                edit_medpre_jqgrid();
            }
        });
        
        // Agregango boton custom
        $("#table_medpre").jqGrid('navButtonAdd',"#pager_table_medpre",{
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


