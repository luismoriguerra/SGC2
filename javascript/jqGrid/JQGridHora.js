var jQGridHora={
    type:'json',
    idLayerMessage:'layerMessage',
    Hora: function(){
        var gridC=$('#table_hora').jqGrid({
            url:'../controlador/controladorSistema.php?comando=hora&action=jqgrid_hora&cinstit='+$("#hd_idInstituto").val(),
            datatype:this.type,
            gridview:true,
            height:345,
            colNames:[
                //"Codigo",
                "Turno",
                "cturno",
                "Instituto",
                "cinstit",
                "Hora Inicio",
                "Hora Fin",
                "Tipo Horario",
				"thorari",
                "Clase Horario",
				"thora",
				"Estado",
				"cestado"
            ],
            colModel:[               
        //{name:'chora',index:'chora',align:'left',width:100,editable:true,editrules:{required:true},sorttype:"text"},
        {name:'dturno',index:'dturno',align:'left',width:80,editable:true,editrules:{required:true},sorttype:"text"},
        {name:'cturno',index:'cturno',align:'left',width:100,editable:true,editrules:{required:true},sorttype:"text",hidden:true},
        {name:'dinstit',index:'dinstit',align:'left',width:120,editable:true,editrules:{required:true},sorttype:"text"},
        {name:'cinstit',index:'cinstit',align:'left',width:100,editable:true,editrules:{required:true},sorttype:"text",hidden:true},
        {name:'hinici',index:'hinici',align:'center',width:70,editable:true,editrules:{required:true},sorttype:"text"},
        {name:'hfin',index:'hfin',align:'center',width:70,editable:true,editrules:{required:true},sorttype:"text"},
        {name:'thorario',index:'thorario',align:'center',width:80,editable:true,editrules:{required:true},stype:"select",edittype:"select",editoptions:{value:" : ;R:Regular;M:Muerto"}},//" : , para coger todos los valores 1 y 0, campo required lo interpreta en blanco"
        {name:'thorari',index:'thorari',align:'left',width:150,editable:true,editrules:{required:true},sorttype:"text",hidden:true},  
        {name:'clahora',index:'clahora',align:'center',width:80,editable:true,editrules:{required:true},stype:"select",edittype:"select",editoptions:{value:" : ;1:Curso;2:Grupo"}},//" : , para coger todos los valores 1 y 0, campo required lo interpreta en blanco"
        {name:'thora',index:'thora',align:'left',width:150,editable:true,editrules:{required:true},sorttype:"text",hidden:true},  
        {name:'estado',index:'estado',align:'center',width:90,editable:true,editrules:{required:true},stype:"select",edittype:"select",editoptions:{value:" : ;1:Activo;0:Inactivo"}},//" : , para coger todos los valores 1 y 0, campo required lo interpreta en blanco"
        {name:'cestado',index:'cestado',align:'left',width:150,editable:true,editrules:{required:true},sorttype:"text",hidden:true},   
            ],
            rowNum:15,
            //rowList:[5,10],
            rownumbers:true,
            pager:'#pager_table_hora',
            sortname:'c.chora',
            sortorder:'asc',
            loadui: "block"
        });
		
        $("#table_hora").jqGrid('filterToolbar');
        gridC[0].toggleToolbar();//oculta fila de busqueda, boton "buscar registro" lo activara
        $('#table_hora').jqGrid('navGrid','#pager_table_hora',{edit:false,add:false,del:false,view:false,search:false});
        
        //Agregando boton Insert
        $('#table_hora').jqGrid('navButtonAdd','pager_table_hora',{
            caption:"",
            title:"Agregar Hora de Ingreso",
            buttonicon:'ui-icon-plus',
            onClickButton:function(){
                add_hora_jqgrid();
            }
        });
        
        $('#table_hora').jqGrid('navButtonAdd','pager_table_hora',{
            caption:"",
            title:"Editar Hora",
            buttonicon:'ui-icon-pencil',
            onClickButton:function(){
                edit_hora_jqgrid();
            }
        });
        
        // Agregango boton custom
        $("#table_hora").jqGrid('navButtonAdd',"#pager_table_hora",{
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


