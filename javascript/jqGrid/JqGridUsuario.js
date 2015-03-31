var jqGridUsuario={
	type:'json',
	usuario:function(){
		var gridTU=$('#table_usuario').jqGrid({
			url:'../controlador/controladorSistema.php?comando=usuario&accion=jqgrid_usuario',
			datatype:this.type,
			gridview:true,
			height:200,
			colNames:['Nombres','Paterno','Materno','DNI','idestado','Estado'],
			colModel:[
				{name:'nombres',index:'nombres',align:'left',width:100},
				{name:'paterno',index:'paterno',align:'left',width:100},
				{name:'materno',index:'materno',align:'left',width:100},
				{name:'dni',index:'dni',align:'left',width:100},
				{name:'idestado',index:'idestado',align:'left',width:40,hidden:true},
				{name:'estado',index:'estado',align:'left',width:100,stype:"select",editoptions:{value:" : ;1:ACTIVO;0:INACTIVO"}}
			],
			rowNum:10,
			rowList:[10,20,30],
			rownumbers:true,
			pager:'pager_table_usuario',
			sortname:'idusuario',
			sortorder:'asc',
			loadui:'block'
		});
		$('#table_usuario').jqGrid('navGrid','#pager_table_usuario',{edit:false,add:false,del:false,view:false,search:false});
		$("#table_usuario").jqGrid('filterToolbar');
		gridTU[0].toggleToolbar();//oculta fila de busqueda, boton "buscar registro" lo activara
		$('#table_usuario').jqGrid('navButtonAdd','pager_table_usuario',{
            caption:"",
            title:"Agregar Usuario",
            buttonicon:'ui-icon-plus',
            onClickButton:function(){
                add_usuario_jqgrid();
            }
        });
        $('#table_usuario').jqGrid('navButtonAdd','pager_table_usuario',{
            caption:"",
            title:"Editar Usuario",
            buttonicon:'ui-icon-pencil',
            onClickButton:function(){
                edit_usuario_jqgrid();
            }
        });
        $("#table_usuario").jqGrid('navButtonAdd',"#pager_table_usuario",{
            caption:"",
            title:"Buscar Registro", 
            buttonicon :'ui-icon-search', 
            onClickButton:function(){
                gridTU[0].toggleToolbar() 
            } 
        }); 
	}
}