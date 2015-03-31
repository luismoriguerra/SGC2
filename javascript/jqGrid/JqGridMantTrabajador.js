var jqGridPersona={
	type:'json',	
	persona:function(){
		var gridTU=$('#table_persona').jqGrid({
			url:'../controlador/controladorSistema.php?comando=persona&accion=jqgrid_persona',
			datatype:this.type,
			gridview:true,
			height:232,
			colNames:['Paterno','Materno','Nombres','DNI','email','celular','telefono','tel_oficina','estado_civil','tipo_documento','fecha_nac','sexo','cod_dpto','cod_prov','cod_dist','direccion','referencia','dpt_trabajo','prov_trabajo','dist_trabajo','dir_trabajo','nombre_trabajo','tipo_colegio','colegio','departamento','provincia','distrito','depar_trab','prov_trab','dist_trab'],
			colModel:[				
				{name:'dappape',index:'dappape',align:'left',width:150},
				{name:'dapmape',index:'dapmape',align:'left',width:150},
				{name:'dnomper',index:'dnomper',align:'left',width:150},
				{name:'ndniper',index:'ndniper',align:'center',width:100},
				{name:'email1',index:'email1',align:'left',width:10,hidden:true},
				{name:'ntelpe2',index:'ntelpe2',align:'left',width:10,hidden:true},
				{name:'ntelper',index:'ntelper',align:'left',width:10,hidden:true},
				{name:'ntellab',index:'ntellab',align:'left',width:10,hidden:true},
				{name:'cestciv',index:'cestciv',align:'left',width:10,hidden:true},
				{name:'tipdocper',index:'tipdocper',align:'left',width:10,hidden:true},
				{name:'fnacper',index:'fnacper',align:'left',width:10,hidden:true},
				{name:'tsexo',index:'tsexo',align:'left',width:10,hidden:true},
				{name:'coddpto',index:'coddpto',align:'left',width:10,hidden:true},
				{name:'codprov',index:'codprov',align:'left',width:10,hidden:true},
				{name:'coddist',index:'coddist',align:'left',width:10,hidden:true},
				{name:'ddirper',index:'ddirper',align:'left',width:10,hidden:true},
				{name:'ddirref',index:'ddirref',align:'left',width:10,hidden:true},
				{name:'cdptlab',index:'cdptlab',align:'left',width:10,hidden:true},
				{name:'cprvlab',index:'cprvlab',align:'left',width:10,hidden:true},
				{name:'cdislab',index:'cdislab',align:'left',width:10,hidden:true},
				{name:'ddirlab',index:'ddirlab',align:'left',width:10,hidden:true},
				{name:'dnomlab',index:'dnomlab',align:'left',width:10,hidden:true},
				{name:'tcolegi',index:'tcolegi',align:'left',width:10,hidden:true},
				{name:'dcolpro',index:'dcolpro',align:'left',width:10,hidden:true},
				{name:'ddepart',index:'ddepart',align:'left',width:10,hidden:true},
				{name:'dprovin',index:'dprovin',align:'left',width:10,hidden:true},
				{name:'ddistri',index:'ddistri',align:'left',width:10,hidden:true},
				{name:'depalab',index:'depalab',align:'left',width:10,hidden:true},
				{name:'provlab',index:'provlab',align:'left',width:10,hidden:true},
				{name:'distlab',index:'distlab',align:'left',width:10,hidden:true}
			],
			rowNum:10,
			//rowList:[10,20,30],
			rownumbers:true,
			pager:'pager_table_persona',
			sortname:'p.cperson',
			sortorder:'asc',
			loadui:'block'
		});
		$('#table_persona').jqGrid('navGrid','#pager_table_persona',{edit:false,add:false,del:false,view:false,search:false});
		$("#table_persona").jqGrid('filterToolbar');
		//gridTU[0].toggleToolbar();//oculta fila de busqueda, boton "buscar registro" lo activara
		$('#table_persona').jqGrid('navButtonAdd','pager_table_persona',{
            caption:"",
            title:"Agregar Persona",
            buttonicon:'ui-icon-plus',
            onClickButton:function(){
                add_persona_jqgrid();
            }
        });
        $('#table_persona').jqGrid('navButtonAdd','pager_table_persona',{
            caption:"",
            title:"Editar Persona",
            buttonicon:'ui-icon-pencil',
            onClickButton:function(){
                edit_persona_jqgrid();
            }
        });
        $("#table_persona").jqGrid('navButtonAdd',"#pager_table_persona",{
            caption:"",
            title:"Buscar Registro", 
            buttonicon :'ui-icon-search', 
            onClickButton:function(){
                gridTU[0].toggleToolbar() 
            } 
        });
		$("#table_persona").jqGrid('navButtonAdd',"#pager_table_persona",{
            caption:"",
            title:"Cargar Persona", 
            buttonicon :'icon-ok-sign', 
            onClickButton:function(){
                cargar_persona_jqgrid();
            } 
        }); 
	}	
}