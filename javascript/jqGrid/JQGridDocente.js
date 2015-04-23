var jqGridDocente={
	type:'json',	
	Docente:function(){
    var gridTU=$('#table_docente').jqGrid({
      url:'../controlador/controladorSistema.php?comando=docente&accion=jqgrid_docente&cestado=1',
      datatype:this.type,
      gridview:true,
      height:232,
      colNames:['Paterno','Materno','Nombres','DNI','Fecha Ingreso'],
      colModel:[        
        {name:'dappape',index:'dappape',align:'left',width:150},
        {name:'dapmape',index:'dapmape',align:'left',width:150},
        {name:'dnomper',index:'dnomper',align:'left',width:150},
        {name:'ndniper',index:'ndniper',align:'center',width:100},        
                {name:'fingreso',index:'fingreso',align:'left',width:100},
      ],
      rowNum:10,
      //rowList:[10,20,30],
      rownumbers:true,
      pager:'pager_table_docente',
      sortname:'pe.dappape,pe.dapmape,pe.dnomper',
      sortorder:'asc',
      loadui:'block'
    });
    $('#table_docente').jqGrid('navGrid','#pager_table_docente',{edit:false,add:false,del:false,view:false,search:false});
    $("#table_docente").jqGrid('filterToolbar');
    //gridTU[0].toggleToolbar();//oculta fila de busqueda, boton "buscar registro" lo activara    
        $("#table_docente").jqGrid('navButtonAdd',"#pager_table_docente",{
            caption:"",
            title:"Buscar Registro", 
            buttonicon :'ui-icon-search', 
            onClickButton:function(){
                gridTU[0].toggleToolbar() 
            } 
        });
    $("#table_docente").jqGrid('navButtonAdd',"#pager_table_docente",{
            caption:"",
            title:"Cargar", 
            buttonicon :'icon-ok-sign', 
            onClickButton:function(){
                cargar_docente();
            } 
        }); 
  },
  Docente2:function(){
    var gridTU=$('#table_docente2').jqGrid({
      url:'../controlador/controladorSistema.php?comando=docente&accion=jqgrid_docente&cestado=1',
      datatype:this.type,
      gridview:true,
      height:232,
      colNames:['Paterno','Materno','Nombres','DNI','Fecha Ingreso'],
      colModel:[        
        {name:'dappape',index:'dappape',align:'left',width:150},
        {name:'dapmape',index:'dapmape',align:'left',width:150},
        {name:'dnomper',index:'dnomper',align:'left',width:150},
        {name:'ndniper',index:'ndniper',align:'center',width:100},        
                {name:'fingreso',index:'fingreso',align:'left',width:100},
      ],
      rowNum:10,
      //rowList:[10,20,30],
      rownumbers:true,
      pager:'pager_table_docente2',
      sortname:'pe.dappape,pe.dapmape,pe.dnomper',
      sortorder:'asc',
      loadui:'block'
    });
    $('#table_docente2').jqGrid('navGrid','#pager_table_docente2',{edit:false,add:false,del:false,view:false,search:false});
    $("#table_docente2").jqGrid('filterToolbar');
    //gridTU[0].toggleToolbar();//oculta fila de busqueda, boton "buscar registro" lo activara    
        $("#table_docente2").jqGrid('navButtonAdd',"#pager_table_docente2",{
            caption:"",
            title:"Buscar Registro", 
            buttonicon :'ui-icon-search', 
            onClickButton:function(){
                gridTU[0].toggleToolbar() 
            } 
        });
    $("#table_docente2").jqGrid('navButtonAdd',"#pager_table_docente2",{
            caption:"",
            title:"Cargar", 
            buttonicon :'icon-ok-sign', 
            onClickButton:function(){
                cargar_docente2();
            } 
        }); 
  },
  DocenteMante:function(){
		var gridTU=$('#table_docente').jqGrid({
			url:'../controlador/controladorSistema.php?comando=docente&accion=jqgrid_docente',
			datatype:this.type,
			gridview:true,
			height:232,
			colNames:['Paterno','Materno','Nombres','DNI','Fecha Ingreso','Filial','cfilial','Institucion','cinstit','Peso','estado','cestado','cperson'],
			colModel:[				
				{name:'dappape',index:'dappape',align:'left',width:150},
				{name:'dapmape',index:'dapmape',align:'left',width:150},
				{name:'dnomper',index:'dnomper',align:'left',width:150},
				{name:'ndniper',index:'ndniper',align:'center',width:100},				
                {name:'fingreso',index:'fingreso',align:'left',width:100},
                {name:'filial',index:'filial',align:'left',width:100},
                {name:'cfilial',index:'cfilial',align:'left',width:100,hidden:true},
                {name:'institucion',index:'institucion',align:'left',width:100},
                {name:'cinstit',index:'cinstit',align:'left',width:100,hidden:true},
                {name:'peso',index:'peso',align:'left',width:100,hidden:true},
				{name:'estado',index:'estado',align:'left',width:100,stype:"select",editoptions:{value:" : ;1:ACTIVO;0:INACTIVO"}},
                {name:'cestado',index:'cestado',align:'left',width:100,hidden:true},
                {name:'cperson',index:'cperson',align:'left',width:100,hidden:true}

                
			],
			rowNum:10,
			//rowList:[10,20,30],
			rownumbers:true,
			pager:'pager_table_docente',
			sortname:'pe.dappape,pe.dapmape,pe.dnomper',
			sortorder:'asc',
			loadui:'block'
		});
		$('#table_docente').jqGrid('navGrid','#pager_table_docente',{edit:false,add:false,del:false,view:false,search:false});
		$("#table_docente").jqGrid('filterToolbar');

		$('#table_docente').jqGrid('navButtonAdd','#pager_table_docente',{
            caption:"",
            title:"Agregar ",
            buttonicon:'ui-icon-plus',
            onClickButton:function(){
                docente_agregar();
            }
        });
        $('#table_docente').jqGrid('navButtonAdd','#pager_table_docente',{
            caption:"",
            title:"Editar ",
            buttonicon:'ui-icon-pencil',
            onClickButton:function(){
                docente_editar();
            }
        });

	},
   DocenteHorario:function(){
    var gridTU=$('#table_docente').jqGrid({
      url:'../controlador/controladorSistema.php?comando=docente&accion=jqgrid_docente',
      datatype:this.type,
      gridview:true,
      height:232,
      colNames:['Paterno','Materno','Nombres','DNI','Fecha Ingreso','Filial','cfilial','Institucion','cinstit','Peso','estado','cestado','cperson'],
      colModel:[        
        {name:'dappape',index:'dappape',align:'left',width:150},
        {name:'dapmape',index:'dapmape',align:'left',width:150},
        {name:'dnomper',index:'dnomper',align:'left',width:150},
        {name:'ndniper',index:'ndniper',align:'center',width:100},        
                {name:'fingreso',index:'fingreso',align:'left',width:100},
                {name:'filial',index:'filial',align:'left',width:100},
                {name:'cfilial',index:'cfilial',align:'left',width:100,hidden:true},
                {name:'institucion',index:'institucion',align:'left',width:100},
                {name:'cinstit',index:'cinstit',align:'left',width:100,hidden:true},
                {name:'peso',index:'peso',align:'left',width:100,hidden:true},
        {name:'estado',index:'estado',align:'left',width:100,stype:"select",editoptions:{value:" : ;1:ACTIVO;0:INACTIVO"}},
                {name:'cestado',index:'cestado',align:'left',width:100,hidden:true},
                {name:'cperson',index:'cperson',align:'left',width:100,hidden:true}

                
      ],
      rowNum:10,
      //rowList:[10,20,30],
      rownumbers:true,
      pager:'pager_table_docente',
      sortname:'pe.dappape,pe.dapmape,pe.dnomper',
      sortorder:'asc',
      loadui:'block',multiselect:true
    });
    $('#table_docente').jqGrid('navGrid','#pager_table_docente',{edit:false,add:false,del:false,view:false,search:false});
    $("#table_docente").jqGrid('filterToolbar');

    // $('#table_docente').jqGrid('navButtonAdd','#pager_table_docente',{
    //         caption:"",
    //         title:"Agregar ",
    //         buttonicon:'ui-icon-plus',
    //         onClickButton:function(){
    //             docente_agregar();
    //         }
    //     });
    //     $('#table_docente').jqGrid('navButtonAdd','#pager_table_docente',{
    //         caption:"",
    //         title:"Editar ",
    //         buttonicon:'ui-icon-pencil',
    //         onClickButton:function(){
    //             docente_editar();
    //         }
    //     });

  },
	DocenteMantePeso:function(){
		var gridTU=$('#table_docente').jqGrid({
			url:'../controlador/controladorSistema.php?comando=docente&accion=jqgrid_docente',
			datatype:this.type,
			gridview:true,
			height:232,
			colNames:['Paterno','Materno','Nombres','DNI','Fecha Ingreso','Filial','cfilial','Institucion','cinstit','Peso','estado','cestado','cperson'],
			colModel:[				
				{name:'dappape',index:'dappape',align:'left',width:150},
				{name:'dapmape',index:'dapmape',align:'left',width:150},
				{name:'dnomper',index:'dnomper',align:'left',width:150},
				{name:'ndniper',index:'ndniper',align:'center',width:100},				
                {name:'fingreso',index:'fingreso',align:'left',width:100},
                {name:'filial',index:'filial',align:'left',width:100},
                {name:'cfilial',index:'cfilial',align:'left',width:100,hidden:true},
                {name:'institucion',index:'institucion',align:'left',width:100},
                {name:'cinstit',index:'cinstit',align:'left',width:100,hidden:true},
                {name:'peso',index:'peso',align:'left',width:100},
				{name:'estado',index:'estado',align:'left',width:100,stype:"select",editoptions:{value:" : ;1:ACTIVO;0:INACTIVO"}},
                {name:'cestado',index:'cestado',align:'left',width:100,hidden:true},
                {name:'cperson',index:'cperson',align:'left',width:100,hidden:true}

                
			],
			rowNum:10,
			//rowList:[10,20,30],
			rownumbers:true,
			pager:'pager_table_docente',
			sortname:'pe.dappape,pe.dapmape,pe.dnomper',
			sortorder:'asc',
			loadui:'block'
		});
		$('#table_docente').jqGrid('navGrid','#pager_table_docente',{edit:false,add:false,del:false,view:false,search:false});
		$("#table_docente").jqGrid('filterToolbar');
		//gridTU[0].toggleToolbar();//oculta fila de busqueda, boton "buscar registro" lo activara		
  //       $("#table_docente").jqGrid('navButtonAdd',"#pager_table_docente",{
  //           caption:"",
  //           title:"Buscar Registro", 
  //           buttonicon :'ui-icon-search', 
  //           onClickButton:function(){
  //               gridTU[0].toggleToolbar() 
  //           } 
  //       });
		// $("#table_docente").jqGrid('navButtonAdd',"#pager_table_docente",{
  //           caption:"",
  //           title:"Cargar", 
  //           buttonicon :'icon-ok-sign', 
  //           onClickButton:function(){
  //               cargar_docente();
  //           } 
  //       }); 
		$('#table_docente').jqGrid('navButtonAdd','#pager_table_docente',{
            caption:"",
            title:"Agregar ",
            buttonicon:'ui-icon-plus',
            onClickButton:function(){
                docente_agregar();
            }
        });
        $('#table_docente').jqGrid('navButtonAdd','#pager_table_docente',{
            caption:"",
            title:"Editar ",
            buttonicon:'ui-icon-pencil',
            onClickButton:function(){
                docente_editar();
            }
        });

	}





}




