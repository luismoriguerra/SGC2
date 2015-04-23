var jQGridPlanCurricular={
    type:'json',
    idLayerMessage:'layerMessage',
    PlanCurricular: function(){
        var gridC=$('#table_plan_curricular').jqGrid({
            url:'../controlador/controladorSistema.php?comando=curricula&action=jqgrid_listar_plancurricular&cingalu='+$('#txt_cingalu').val(),
            datatype:this.type,
            gridview:true,
            height:230,
            colNames:[                
                'Ciclo',
                'Curso',
                "Creditos",
                "Requisitos",
                "Estado"                
            ],
            colModel:[                      
        
        {name:'dmodulo',index:'dmodulo',align:'left',width:60,editable:true,editrules:{required:true},sorttype:"text"},
        {name:'dcurso',index:'dcurso',align:'left',width:120,editable:true,editrules:{required:true},sorttype:"text"},
        {name:'ncredit',index:'ncredit',align:'center',width:40,editable:true,editrules:{required:true},sorttype:"text"},
        {name:'requisito',index:'requisito',align:'left',width:120,editable:true,editrules:{required:true},sorttype:"text",search:false},
        {name:'estado',index:'estado',align:'center',width:100,editable:true,editrules:{required:true},sorttype:"text",search:false}
            ],
            rowNum:10,
            //rowList:[5,10],
            rownumbers:true,
            pager:'#pager_table_plan_curricular',
            sortname:'ci.nromcic,c.dcurso',
            sortorder:'asc',
            loadui: "block"
        });
		
        $("#table_plan_curricular").jqGrid('filterToolbar');
        gridC[0].toggleToolbar();//oculta fila de busqueda, boton "buscar registro" lo activara
        $('#table_plan_curricular').jqGrid('navGrid','#pager_table_plan_curricular',{edit:false,add:false,del:false,view:false,search:false});
        
        // Agregango boton custom
        $("#table_plan_curricular").jqGrid('navButtonAdd',"#pager_table_plan_curricular",{
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


