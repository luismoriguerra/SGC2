var jqGridPersona={
	type:'json',
	personaIngAlum:function(){
		var gridTU=$('#table_persona_ingalum').jqGrid({
			url:'../controlador/controladorSistema.php?comando=persona&accion=jqgrid_personaIngAlum',
			datatype:this.type,
			gridview:true,
			height:100,
			colNames:['Filial','Institucion','Carrera','Semestre','cperson','Paterno','Materno','Nombres','DNI','cingalu'],
			colModel:[
				{name:'dfilial',index:'dfilial',align:'left',width:150},
				{name:'dinstit',index:'dinstit',align:'left',width:150},
				{name:'dcarrer',index:'dcarrer',align:'left',width:220},
				{name:'csemaca',index:'csemaca',align:'center',width:100},
				{name:'cperson',index:'cperson',align:'left',width:150,hidden:true},				
				{name:'dappape',index:'dappape',align:'left',width:150},
				{name:'dapmape',index:'dapmape',align:'left',width:150},
				{name:'dnomper',index:'dnomper',align:'left',width:150},
				{name:'ndniper',index:'ndniper',align:'center',width:100},
				{name:'cingalu',index:'cingalu',align:'center',width:100,hidden:true}
			],
			rowNum:5,
			rowList:[5,10,20,30],
			rownumbers:true,
			pager:'pager_table_persona_ingalum',
			sortname:'g.csemaca,i.cingalu',
			sortorder:'asc',
			loadui:'block',
			/*ondblClickRow: function(ids){
				var data = $("#table_persona_ingalum").jqGrid('getRowData',ids);
                $("#table_pago").jqGrid('setGridParam',{url:'../controlador/controladorSistema.php?comando=pago&accion=jqgrid_pago&cfilial='+$('#hd_idFilial').val()+'&cingalu='+ids.split("-")[0]+'&cgracpr='+ids.split("-")[1]+'&cperson='+data.cperson}); 
        		$("#table_pago").trigger('reloadGrid');
            }*/
		});
		$('#table_persona_ingalum').jqGrid('navGrid','#pager_table_persona_ingalum',{edit:false,add:false,del:false,view:false,search:false});
		$("#table_persona_ingalum").jqGrid('filterToolbar');
		$("#table_persona_ingalum").jqGrid('navButtonAdd',"#pager_table_persona_ingalum",{
            caption:"",
            title:"Buscar Registro", 
            buttonicon :'ui-icon-search', 
            onClickButton:function(){
                gridTU[0].toggleToolbar() 
            } 
        });
		$("#table_persona_ingalum").jqGrid('navButtonAdd',"#pager_table_persona_ingalum",{
            caption:"",
            title:"Cargar Pagos", 
            buttonicon :'icon-ok-sign', 
            onClickButton:function(){
				var ids=$("#table_persona_ingalum").jqGrid("getGridParam",'selrow');
				var data = $("#table_persona_ingalum").jqGrid('getRowData',ids);
				
				$("#table_pago").jqGrid('setGridParam',{url:'../controlador/controladorSistema.php?comando=pago&accion=jqgrid_pago&cfilial='+$('#hd_idFilial').val()+'&cingalu='+ids.split("-")[0]+'&cgracpr='+ids.split("-")[1]+'&cperson='+data.cperson}); 
        		$("#table_pago").trigger('reloadGrid');                
            } 
        }); 
	},
	persona:function(){
		var gridTU=$('#table_persona').jqGrid({
			url:'../controlador/controladorSistema.php?comando=persona&accion=jqgrid_persona',
			datatype:this.type,
			gridview:true,
			height:232,
			colNames:['Paterno','Materno','Nombres','DNI','email','celular','telefono','tel_oficina','estado_civil','tipo_documento','fecha_nac','sexo','cod_dpto','cod_prov','cod_dist','direccion','referencia','dpt_trabajo','prov_trabajo','dist_trabajo','dpt_col','prov_col','dist_col','dir_trabajo','nombre_trabajo','tipo_colegio','colegio','departamento','provincia','distrito','depar_trab','prov_trab','dist_trab'],
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
				{name:'cdptcol',index:'cdptcol',align:'left',width:10},
				{name:'cprvcol',index:'cprvcol',align:'left',width:10},
				{name:'cdiscol',index:'cdiscol',align:'left',width:10},
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
	 
	},
	persona2:function(){
		var gridTU=$('#table_persona2').jqGrid({
			url:'../controlador/controladorSistema.php?comando=persona&accion=jqgrid_persona',
			datatype:this.type,
			gridview:true,
			height:232,
			colNames:['Paterno','Materno','Nombres','DNI','email','celular','telefono','tel_oficina','estado_civil','tipo_documento','fecha_nac','sexo','cod_dpto','cod_prov','cod_dist','direccion','referencia','dpt_trabajo','prov_trabajo','dist_trabajo','dpt_col','prov_col','dist_col','dir_trabajo','nombre_trabajo','tipo_colegio','colegio','departamento','provincia','distrito','depar_trab','prov_trab','dist_trab'],
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
				{name:'cdptcol',index:'cdptcol',align:'left',width:10,hidden:true},
				{name:'cprvcol',index:'cprvcol',align:'left',width:10,hidden:true},
				{name:'cdiscol',index:'cdiscol',align:'left',width:10,hidden:true},
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
			pager:'pager_table_persona2',
			sortname:'p.cperson',
			sortorder:'asc',
			loadui:'block'
		});
		$('#table_persona2').jqGrid('navGrid','#pager_table_persona2',{edit:false,add:false,del:false,view:false,search:false});
		$("#table_persona2").jqGrid('filterToolbar');
		//gridTU[0].toggleToolbar();//oculta fila de busqueda, boton "buscar registro" lo activara
		/*$('#table_persona2').jqGrid('navButtonAdd','pager_table_persona2',{
            caption:"",
            title:"Agregar Persona",
            buttonicon:'ui-icon-plus',
            onClickButton:function(){
                add_persona_jqgrid();
            }
        });*/
        $('#table_persona2').jqGrid('navButtonAdd','pager_table_persona2',{
            caption:"",
            title:"Editar Persona",
            buttonicon:'ui-icon-pencil',
            onClickButton:function(){
                edit_persona2_jqgrid();
            }
        });
        $("#table_persona2").jqGrid('navButtonAdd',"#pager_table_persona2",{
            caption:"",
            title:"Buscar Registro", 
            buttonicon :'ui-icon-search', 
            onClickButton:function(){
                gridTU[0].toggleToolbar() 
            } 
        });
	 
	},
	promotor:function(){
		var gridTU=$('#table_promotor').jqGrid({
			url:'../controlador/controladorSistema.php?comando=persona&accion=jqgrid_trabajador&tvended=p',
			datatype:this.type,
			gridview:true,
			height:232,
			colNames:['Paterno','Materno','Nombres','DNI','demail','telefono','tipo_documento','sexo','cod_dpto','cod_prov','cod_dist','direccion','fecha_ingreso','codigo_interno','codigo_instituto','tipo_vendedor'],
			colModel:[				
				{name:'dapepat',index:'dapepat',align:'left',width:150},
				{name:'dapemat',index:'dapemat',align:'left',width:150},
				{name:'dnombre',index:'dnombre',align:'left',width:150},
				{name:'ndocper',index:'ndocper',align:'center',width:100},
				{name:'demail',index:'demail',align:'left',width:10,hidden:true},
				{name:'dtelefo',index:'dtelefo',align:'left',width:10,hidden:true},
				{name:'tdocper',index:'tdocper',align:'left',width:10,hidden:true},
				{name:'tsexo',index:'tsexo',align:'left',width:10,hidden:true},
				{name:'coddpto',index:'coddpto',align:'left',width:10,hidden:true},
				{name:'codprov',index:'codprov',align:'left',width:10,hidden:true},
				{name:'coddist',index:'coddist',align:'left',width:10,hidden:true},
				{name:'ddirecc',index:'ddirecc',align:'left',width:10,hidden:true},				
				{name:'fingven',index:'fingven',align:'left',width:10,hidden:true},
				{name:'codintv',index:'codintv',align:'left',width:10,hidden:true},
				{name:'cinstit',index:'cinstit',align:'left',width:10,hidden:true},
				{name:'tvended',index:'tvended',align:'left',width:10,hidden:true}
			],
			rowNum:10,
			//rowList:[10,20,30],
			rownumbers:true,
			pager:'pager_table_promotor',
			sortname:'v.cvended',
			sortorder:'asc',
			loadui:'block'
		});
		$('#table_promotor').jqGrid('navGrid','#pager_table_promotor',{edit:false,add:false,del:false,view:false,search:false});
		$("#table_promotor").jqGrid('filterToolbar');
		//gridTU[0].toggleToolbar();//oculta fila de busqueda, boton "buscar registro" lo activara
		$('#table_promotor').jqGrid('navButtonAdd','pager_table_promotor',{
            caption:"",
            title:"Agregar Promotor",
            buttonicon:'ui-icon-plus',
            onClickButton:function(){
                add_promotor_jqgrid();
            }
        });
        $('#table_promotor').jqGrid('navButtonAdd','pager_table_promotor',{
            caption:"",
            title:"Editar Promotor",
            buttonicon:'ui-icon-pencil',
            onClickButton:function(){
                edit_promotor_jqgrid();
            }
        });
        $("#table_promotor").jqGrid('navButtonAdd',"#pager_table_promotor",{
            caption:"",
            title:"Buscar Registro", 
            buttonicon :'ui-icon-search', 
            onClickButton:function(){
                gridTU[0].toggleToolbar() 
            } 
        });
		$("#table_promotor").jqGrid('navButtonAdd',"#pager_table_promotor",{
            caption:"",
            title:"Cargar Promotor", 
            buttonicon :'icon-ok-sign', 
            onClickButton:function(){
                cargar_promotor_jqgrid();
            } 
        }); 
	},
	teleoperadora:function(){
		var gridTU=$('#table_teleoperadora').jqGrid({
			url:'../controlador/controladorSistema.php?comando=persona&accion=jqgrid_trabajador&tvended=t',
			datatype:this.type,
			gridview:true,
			height:232,
			colNames:['Paterno','Materno','Nombres','DNI','demail','telefono','tipo_documento','sexo','cod_dpto','cod_prov','cod_dist','direccion','fecha_ingreso','codigo_interno','codigo_instituto','tipo_vendedor'],
			colModel:[				
				{name:'dapepat',index:'dapepat',align:'left',width:150},
				{name:'dapemat',index:'dapemat',align:'left',width:150},
				{name:'dnombre',index:'dnombre',align:'left',width:150},
				{name:'ndocper',index:'ndocper',align:'center',width:100},
				{name:'demail',index:'demail',align:'left',width:10,hidden:true},
				{name:'dtelefo',index:'dtelefo',align:'left',width:10,hidden:true},
				{name:'tdocper',index:'tdocper',align:'left',width:10,hidden:true},
				{name:'tsexo',index:'tsexo',align:'left',width:10,hidden:true},
				{name:'coddpto',index:'coddpto',align:'left',width:10,hidden:true},
				{name:'codprov',index:'codprov',align:'left',width:10,hidden:true},
				{name:'coddist',index:'coddist',align:'left',width:10,hidden:true},
				{name:'ddirecc',index:'ddirecc',align:'left',width:10,hidden:true},				
				{name:'fingven',index:'fingven',align:'left',width:10,hidden:true},
				{name:'codintv',index:'codintv',align:'left',width:10,hidden:true},
				{name:'cinstit',index:'cinstit',align:'left',width:10,hidden:true},
				{name:'tvended',index:'tvended',align:'left',width:10,hidden:true}
			],
			rowNum:10,
			//rowList:[10,20,30],
			rownumbers:true,
			pager:'pager_table_teleoperadora',
			sortname:'v.cvended',
			sortorder:'asc',
			loadui:'block'
		});
		$('#table_teleoperadora').jqGrid('navGrid','#pager_table_teleoperadora',{edit:false,add:false,del:false,view:false,search:false});
		$("#table_teleoperadora").jqGrid('filterToolbar');
		//gridTU[0].toggleToolbar();//oculta fila de busqueda, boton "buscar registro" lo activara
		$('#table_teleoperadora').jqGrid('navButtonAdd','pager_table_teleoperadora',{
            caption:"",
            title:"Agregar Teleoperadora",
            buttonicon:'ui-icon-plus',
            onClickButton:function(){
                add_teleoperadora_jqgrid();
            }
        });
        $('#table_teleoperadora').jqGrid('navButtonAdd','pager_table_teleoperadora',{
            caption:"",
            title:"Editar Teleoperadora",
            buttonicon:'ui-icon-pencil',
            onClickButton:function(){
                edit_teleoperadora_jqgrid();
            }
        });
        $("#table_teleoperadora").jqGrid('navButtonAdd',"#pager_table_teleoperadora",{
            caption:"",
            title:"Buscar Registro", 
            buttonicon :'ui-icon-search', 
            onClickButton:function(){
                gridTU[0].toggleToolbar() 
            } 
        });
		$("#table_teleoperadora").jqGrid('navButtonAdd',"#pager_table_teleoperadora",{
            caption:"",
            title:"Cargar Teleoperadora", 
            buttonicon :'icon-ok-sign', 
            onClickButton:function(){
                cargar_teleoperadora_jqgrid();
            } 
        }); 
	},
	recepcionista:function(){
		var gridTU=$('#table_recepcionista').jqGrid({
			url:'../controlador/controladorSistema.php?comando=persona&accion=jqgrid_trabajador&tvended=r',
			datatype:this.type,
			gridview:true,
			height:232,
			colNames:['Paterno','Materno','Nombres','DNI','demail','telefono','tipo_documento','sexo','cod_dpto','cod_prov','cod_dist','direccion','fecha_ingreso','codigo_interno','codigo_instituto','tipo_vendedor'],
			colModel:[				
				{name:'dapepat',index:'dapepat',align:'left',width:150},
				{name:'dapemat',index:'dapemat',align:'left',width:150},
				{name:'dnombre',index:'dnombre',align:'left',width:150},
				{name:'ndocper',index:'ndocper',align:'center',width:100},
				{name:'demail',index:'demail',align:'left',width:10,hidden:true},
				{name:'dtelefo',index:'dtelefo',align:'left',width:10,hidden:true},
				{name:'tdocper',index:'tdocper',align:'left',width:10,hidden:true},
				{name:'tsexo',index:'tsexo',align:'left',width:10,hidden:true},
				{name:'coddpto',index:'coddpto',align:'left',width:10,hidden:true},
				{name:'codprov',index:'codprov',align:'left',width:10,hidden:true},
				{name:'coddist',index:'coddist',align:'left',width:10,hidden:true},
				{name:'ddirecc',index:'ddirecc',align:'left',width:10,hidden:true},				
				{name:'fingven',index:'fingven',align:'left',width:10,hidden:true},
				{name:'codintv',index:'codintv',align:'left',width:10,hidden:true},
				{name:'cinstit',index:'cinstit',align:'left',width:10,hidden:true},
				{name:'tvended',index:'tvended',align:'left',width:10,hidden:true}
			],
			rowNum:10,
			//rowList:[10,20,30],
			rownumbers:true,
			pager:'pager_table_recepcionista',
			sortname:'v.cvended',
			sortorder:'asc',
			loadui:'block'
		});
		$('#table_recepcionista').jqGrid('navGrid','#pager_table_recepcionista',{edit:false,add:false,del:false,view:false,search:false});
		$("#table_recepcionista").jqGrid('filterToolbar');
		//gridTU[0].toggleToolbar();//oculta fila de busqueda, boton "buscar registro" lo activara
		$('#table_recepcionista').jqGrid('navButtonAdd','pager_table_recepcionista',{
            caption:"",
            title:"Agregar Recepcionista",
            buttonicon:'ui-icon-plus',
            onClickButton:function(){
                add_recepcionista_jqgrid();
            }
        });
        $('#table_recepcionista').jqGrid('navButtonAdd','pager_table_recepcionista',{
            caption:"",
            title:"Editar Recepcionista",
            buttonicon:'ui-icon-pencil',
            onClickButton:function(){
                edit_recepcionista_jqgrid();
            }
        });
        $("#table_recepcionista").jqGrid('navButtonAdd',"#pager_table_recepcionista",{
            caption:"",
            title:"Buscar Registro", 
            buttonicon :'ui-icon-search', 
            onClickButton:function(){
                gridTU[0].toggleToolbar() 
            } 
        });
		$("#table_recepcionista").jqGrid('navButtonAdd',"#pager_table_recepcionista",{
            caption:"",
            title:"Cargar Recepcionista", 
            buttonicon :'icon-ok-sign', 
            onClickButton:function(){
                cargar_recepcionista_jqgrid();
            } 
        }); 
	},
	dataWEB:function(){
		var gridTU=$('#table_web').jqGrid({
			url:'../controlador/controladorSistema.php?comando=persona&accion=jqgrid_trabajador&tvended=w',
			datatype:this.type,
			gridview:true,
			height:232,
			colNames:['Paterno','Materno','Nombres','DNI','demail','telefono','tipo_documento','sexo','cod_dpto','cod_prov','cod_dist','direccion','fecha_ingreso','codigo_interno','codigo_instituto','tipo_vendedor'],
			colModel:[				
				{name:'dapepat',index:'dapepat',align:'left',width:150},
				{name:'dapemat',index:'dapemat',align:'left',width:150},
				{name:'dnombre',index:'dnombre',align:'left',width:150},
				{name:'ndocper',index:'ndocper',align:'center',width:100},
				{name:'demail',index:'demail',align:'left',width:10,hidden:true},
				{name:'dtelefo',index:'dtelefo',align:'left',width:10,hidden:true},
				{name:'tdocper',index:'tdocper',align:'left',width:10,hidden:true},
				{name:'tsexo',index:'tsexo',align:'left',width:10,hidden:true},
				{name:'coddpto',index:'coddpto',align:'left',width:10,hidden:true},
				{name:'codprov',index:'codprov',align:'left',width:10,hidden:true},
				{name:'coddist',index:'coddist',align:'left',width:10,hidden:true},
				{name:'ddirecc',index:'ddirecc',align:'left',width:10,hidden:true},				
				{name:'fingven',index:'fingven',align:'left',width:10,hidden:true},
				{name:'codintv',index:'codintv',align:'left',width:10,hidden:true},
				{name:'cinstit',index:'cinstit',align:'left',width:10,hidden:true},
				{name:'tvended',index:'tvended',align:'left',width:10,hidden:true}
			],
			rowNum:10,
			//rowList:[10,20,30],
			rownumbers:true,
			pager:'pager_table_web',
			sortname:'v.cvended',
			sortorder:'asc',
			loadui:'block'
		});
		$('#table_web').jqGrid('navGrid','#pager_table_web',{edit:false,add:false,del:false,view:false,search:false});
		$("#table_web").jqGrid('filterToolbar');
		//gridTU[0].toggleToolbar();//oculta fila de busqueda, boton "buscar registro" lo activara
		$('#table_web').jqGrid('navButtonAdd','pager_table_web',{
            caption:"",
            title:"Agregar Data WEB",
            buttonicon:'ui-icon-plus',
            onClickButton:function(){
                add_web_jqgrid();
            }
        });
        $('#table_web').jqGrid('navButtonAdd','pager_table_web',{
            caption:"",
            title:"Editar Data WEB",
            buttonicon:'ui-icon-pencil',
            onClickButton:function(){
                edit_web_jqgrid();
            }
        });
        $("#table_web").jqGrid('navButtonAdd',"#pager_table_web",{
            caption:"",
            title:"Buscar Registro", 
            buttonicon :'ui-icon-search', 
            onClickButton:function(){
                gridTU[0].toggleToolbar() 
            } 
        });
		$("#table_web").jqGrid('navButtonAdd',"#pager_table_web",{
            caption:"",
            title:"Cargar Data WEB", 
            buttonicon :'icon-ok-sign', 
            onClickButton:function(){
                cargar_web_jqgrid();
            } 
        }); 
	},
	docAut:function(){
		var gridTU=$('#table_doc_aut').jqGrid({
			url:'../controlador/controladorSistema.php?comando=persona&accion=jqgrid_trabajador&tvended=d',
			datatype:this.type,
			gridview:true,
			height:232,
			colNames:['Paterno','Materno','Nombres','DNI','demail','telefono','tipo_documento','sexo','cod_dpto','cod_prov','cod_dist','direccion','fecha_ingreso','codigo_interno','codigo_instituto','tipo_vendedor'],
			colModel:[				
				{name:'dapepat',index:'dapepat',align:'left',width:150},
				{name:'dapemat',index:'dapemat',align:'left',width:150},
				{name:'dnombre',index:'dnombre',align:'left',width:150},
				{name:'ndocper',index:'ndocper',align:'center',width:100},
				{name:'demail',index:'demail',align:'left',width:10,hidden:true},
				{name:'dtelefo',index:'dtelefo',align:'left',width:10,hidden:true},
				{name:'tdocper',index:'tdocper',align:'left',width:10,hidden:true},
				{name:'tsexo',index:'tsexo',align:'left',width:10,hidden:true},
				{name:'coddpto',index:'coddpto',align:'left',width:10,hidden:true},
				{name:'codprov',index:'codprov',align:'left',width:10,hidden:true},
				{name:'coddist',index:'coddist',align:'left',width:10,hidden:true},
				{name:'ddirecc',index:'ddirecc',align:'left',width:10,hidden:true},				
				{name:'fingven',index:'fingven',align:'left',width:10,hidden:true},
				{name:'codintv',index:'codintv',align:'left',width:10,hidden:true},
				{name:'cinstit',index:'cinstit',align:'left',width:10,hidden:true},
				{name:'tvended',index:'tvended',align:'left',width:10,hidden:true}
			],
			rowNum:10,
			//rowList:[10,20,30],
			rownumbers:true,
			pager:'pager_table_doc_aut',
			sortname:'v.cvended',
			sortorder:'asc',
			loadui:'block'
		});
		$('#table_doc_aut').jqGrid('navGrid','#pager_table_doc_aut',{edit:false,add:false,del:false,view:false,search:false});
		$("#table_doc_aut").jqGrid('filterToolbar');
		//gridTU[0].toggleToolbar();//oculta fila de busqueda, boton "buscar registro" lo activara
		$('#table_doc_aut').jqGrid('navButtonAdd','pager_table_doc_aut',{
            caption:"",
            title:"Agregar Docente o Autoridad",
            buttonicon:'ui-icon-plus',
            onClickButton:function(){
                add_doc_aut_jqgrid();
            }
        });
        $('#table_doc_aut').jqGrid('navButtonAdd','pager_table_doc_aut',{
            caption:"",
            title:"Editar Docente o Autoridad",
            buttonicon:'ui-icon-pencil',
            onClickButton:function(){
                edit_doc_aut_jqgrid();
            }
        });
        $("#table_doc_aut").jqGrid('navButtonAdd',"#pager_table_doc_aut",{
            caption:"",
            title:"Buscar Registro", 
            buttonicon :'ui-icon-search', 
            onClickButton:function(){
                gridTU[0].toggleToolbar() 
            } 
        });
		$("#table_doc_aut").jqGrid('navButtonAdd',"#pager_table_doc_aut",{
            caption:"",
            title:"Cargar Docente o Autoridad", 
            buttonicon :'icon-ok-sign', 
            onClickButton:function(){
                cargar_doc_aut_jqgrid();
            } 
        }); 
	},
	exAlumno:function(){
		var gridTU=$('#table_exalumno').jqGrid({
			url:'../controlador/controladorSistema.php?comando=persona&accion=jqgrid_trabajador&tvended=e',
			datatype:this.type,
			gridview:true,
			height:232,
			colNames:['Paterno','Materno','Nombres','DNI','demail','telefono','tipo_documento','sexo','cod_dpto','cod_prov','cod_dist','direccion','fecha_ingreso','codigo_interno','codigo_instituto','tipo_vendedor'],
			colModel:[				
				{name:'dapepat',index:'dapepat',align:'left',width:150},
				{name:'dapemat',index:'dapemat',align:'left',width:150},
				{name:'dnombre',index:'dnombre',align:'left',width:150},
				{name:'ndocper',index:'ndocper',align:'center',width:100},
				{name:'demail',index:'demail',align:'left',width:10,hidden:true},
				{name:'dtelefo',index:'dtelefo',align:'left',width:10,hidden:true},
				{name:'tdocper',index:'tdocper',align:'left',width:10,hidden:true},
				{name:'tsexo',index:'tsexo',align:'left',width:10,hidden:true},
				{name:'coddpto',index:'coddpto',align:'left',width:10,hidden:true},
				{name:'codprov',index:'codprov',align:'left',width:10,hidden:true},
				{name:'coddist',index:'coddist',align:'left',width:10,hidden:true},
				{name:'ddirecc',index:'ddirecc',align:'left',width:10,hidden:true},				
				{name:'fingven',index:'fingven',align:'left',width:10,hidden:true},
				{name:'codintv',index:'codintv',align:'left',width:10,hidden:true},
				{name:'cinstit',index:'cinstit',align:'left',width:10,hidden:true},
				{name:'tvended',index:'tvended',align:'left',width:10,hidden:true}
			],
			rowNum:10,
			//rowList:[10,20,30],
			rownumbers:true,
			pager:'pager_table_exalumno',
			sortname:'v.cvended',
			sortorder:'asc',
			loadui:'block'
		});
		$('#table_exalumno').jqGrid('navGrid','#pager_table_exalumno',{edit:false,add:false,del:false,view:false,search:false});
		$("#table_exalumno").jqGrid('filterToolbar');
		//gridTU[0].toggleToolbar();//oculta fila de busqueda, boton "buscar registro" lo activara
		$('#table_exalumno').jqGrid('navButtonAdd','pager_table_exalumno',{
            caption:"",
            title:"Agregar Ex Alumno",
            buttonicon:'ui-icon-plus',
            onClickButton:function(){
                add_exalumno_jqgrid();
            }
        });
        $('#table_exalumno').jqGrid('navButtonAdd','pager_table_exalumno',{
            caption:"",
            title:"Editar Ex Alumno",
            buttonicon:'ui-icon-pencil',
            onClickButton:function(){
                edit_exalumno_jqgrid();
            }
        });
        $("#table_exalumno").jqGrid('navButtonAdd',"#pager_table_exalumno",{
            caption:"",
            title:"Buscar Registro", 
            buttonicon :'ui-icon-search', 
            onClickButton:function(){
                gridTU[0].toggleToolbar() 
            } 
        });
		$("#table_exalumno").jqGrid('navButtonAdd',"#pager_table_exalumno",{
            caption:"",
            title:"Cargar Ex Alumno", 
            buttonicon :'icon-ok-sign', 
            onClickButton:function(){
                cargar_exalumno_jqgrid();
            } 
        }); 
	}
}