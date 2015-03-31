var jQGridGrupoAcademico={
    type:'json',
    idLayerMessage:'layerMessage',
    GrupoAcademico: function(){
        var gridC=$('#table_grupo_academico').jqGrid({
            url:'../controlador/controladorSistema.php?comando=grupo_academico&action=jqgrid_grupo_academico',
            datatype:this.type,
            gridview:true,
            height:230,
            colNames:[
                'Ode',
                'Carrera',
                'Ciclo',
                'Periodo',
                "Inicio",
                "Fecha Inicio",
                "Horario"                
            ],
            colModel:[               

        {name:'dfilial',index:'dfilial',align:'left',width:80,editable:true,editrules:{required:true},sorttype:"text"},
        {name:'dcarrer',index:'dcarrer',align:'left',width:250,editable:true,editrules:{required:true},sorttype:"text"},
        {name:'dciclo',index:'dciclo',align:'left',width:60,editable:true,editrules:{required:true},sorttype:"text"},
        {name:'csemaca',index:'csemaca',align:'center',width:50,editable:true,editrules:{required:true},sorttype:"text"},
        {name:'cinicio',index:'cinicio',align:'center',width:40,editable:true,editrules:{required:true},sorttype:"text"},
        {name:'finicio',index:'finicio',align:'center',width:70,editable:true,editrules:{required:true},sorttype:"text"},
        {name:'horario',index:'horario',align:'left',width:220,editable:true,editrules:{required:true},sorttype:"text",search:false}
            ],
            rowNum:10,
            //rowList:[5,10],
            rownumbers:true,
            pager:'#pager_table_grupo_academico',
            sortname:'c.dcarrer,g.cinicio,g.finicio',
            sortorder:'asc',
            loadui: "block"
        });
		
        $("#table_grupo_academico").jqGrid('filterToolbar');
        gridC[0].toggleToolbar();//oculta fila de busqueda, boton "buscar registro" lo activara
        $('#table_grupo_academico').jqGrid('navGrid','#pager_table_grupo_academico',{edit:false,add:false,del:false,view:false,search:false});
        
        // Agregango boton custom
        $("#table_grupo_academico").jqGrid('navButtonAdd',"#pager_table_grupo_academico",{
            caption:"",
            title:"Buscar Registro", 
            buttonicon :'icon-search', 
            onClickButton:function(){
                gridC[0].toggleToolbar() 
            } 
        });
        $("#table_grupo_academico").jqGrid('navButtonAdd',"#pager_table_grupo_academico",{
            caption:"",
            title:"Cargar", 
            buttonicon :'icon-ok-sign', 
            onClickButton:function(){
                ListadoCursos();
            } 
        }); 
        //fin boton custom
    }
}


