var jqGridPersona={
	type:'json',
	personaIngAlum:function(){
		var gridTU=$('#table_persona_ingalum').jqGrid({
			url:'../controlador/controladorSistema.php?comando=persona&accion=jqgrid_personaIngAlum',
			datatype:this.type,
			gridview:true,
			height:240,
			colNames:['Estado','Filial','Institucion','Carrera','Inicio','Fecha Inicio','Horario','Semestre','cperson','Serie Matricula','Paterno','Materno','Nombres','DNI','cingalu','Codigo Libro','Medio Captacion','Responsable Captacion','Recepcionista','Codigo Responsable'],
			colModel:[
				{name:'cestado',index:'cestado',align:'center',width:80,editable:true,editrules:{required:true},stype:"select",edittype:"select",editoptions:{value:" : ;1:Activo;0:Retirado"}},
				{name:'dfilial',index:'dfilial',align:'left',width:110},
				{name:'dinstit',index:'dinstit',align:'left',width:100},
				{name:'dcarrer',index:'dcarrer',align:'left',width:250},
				{name:'cinicio',index:'cinicio',align:'center',width:70},
				{name:'finicio',index:'finicio',align:'center',width:100},
				{name:'dhorari',index:'dhorari',align:'center',width:120},
				{name:'csemaca',index:'csemaca',align:'center',width:100},
				{name:'cperson',index:'cperson',align:'left',width:150,hidden:true},								
				{name:'sermatr',index:'sermatr',align:'center',width:100},
				{name:'dappape',index:'dappape',align:'left',width:100},
				{name:'dapmape',index:'dapmape',align:'left',width:100},
				{name:'dnomper',index:'dnomper',align:'left',width:100},
				{name:'ndniper',index:'ndniper',align:'center',width:100},
				{name:'cingalu',index:'cingalu',align:'center',width:100,hidden:true},
				{name:'dcodlib',index:'dcodlib',align:'center',width:100},
				{name:'dtipcap',index:'dtipcap',align:'left',width:100},
				{name:'detalle_captacion',index:'detalle_captacion',align:'left',width:100},
				{name:'recepcionista',index:'recepcionista',align:'left',width:180},
				{name:'codintv',index:'codintv',align:'left',width:70}
			],
			rowNum:10,
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
	personaIngAlum2:function(){
		var gridTU=$('#table_persona_ingalum').jqGrid({
			url:'../controlador/controladorSistema.php?comando=persona&accion=jqgrid_personaIngAlum',
			datatype:this.type,
			gridview:true,
			height:240,
			colNames:['Estado','Filial','Institucion','Carrera','Inicio','Fecha Inicio','Horario','Semestre','cperson','Serie Matricula','Paterno','Materno','Nombres','DNI','cingalu','Codigo Libro','Medio Captacion','Responsable Captacion','Recepcionista','Codigo Responsable'],
			colModel:[
				{name:'cestado',index:'cestado',align:'center',width:80,editable:true,editrules:{required:true},stype:"select",edittype:"select",editoptions:{value:" : ;1:Activo;0:Retirado"}},
				{name:'dfilial',index:'dfilial',align:'left',width:110},
				{name:'dinstit',index:'dinstit',align:'left',width:100},
				{name:'dcarrer',index:'dcarrer',align:'left',width:250},
				{name:'cinicio',index:'cinicio',align:'center',width:70},
				{name:'finicio',index:'finicio',align:'center',width:100},
				{name:'dhorari',index:'dhorari',align:'center',width:120},
				{name:'csemaca',index:'csemaca',align:'center',width:100},
				{name:'cperson',index:'cperson',align:'left',width:150,hidden:true},	
				{name:'sermatr',index:'sermatr',align:'center',width:100},			
				{name:'dappape',index:'dappape',align:'left',width:100},
				{name:'dapmape',index:'dapmape',align:'left',width:100},
				{name:'dnomper',index:'dnomper',align:'left',width:100},
				{name:'ndniper',index:'ndniper',align:'center',width:100},
				{name:'cingalu',index:'cingalu',align:'center',width:100,hidden:true},
				{name:'dcodlib',index:'dcodlib',align:'center',width:100},
				{name:'dtipcap',index:'dtipcap',align:'left',width:100},
				{name:'detalle_captacion',index:'detalle_captacion',align:'left',width:100},
				{name:'recepcionista',index:'recepcionista',align:'left',width:180},	
				{name:'codintv',index:'codintv',align:'left',width:70}			
			],			
			rowNum:10,
			rowList:[5,10,20,30],
			rownumbers:true,
			pager:'pager_table_persona_ingalum',
			sortname:'g.csemaca,i.cingalu',
			sortorder:'asc',
			loadui:'block',			
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
				eventoClick();
            } 
        }); 
	},	
	AlumProc:function(){
		var gridTU=$('#table_curso_proc').jqGrid({
			url:'../controlador/controladorSistema.php?comando=persona&accion=jqgrid_AlumProc&cingalu='+$('#txt_cingalu').val(),
			datatype:this.type,
			gridview:true,
			height:240,
			colNames:['Asig. Procedencia','cciclo','Ciclo','Nro Credito','Nro H. Teorica','Nro H. Practica','Silabo','cestado','Estado'],
			colModel:[
				{name:'daspral',index:'daspral',align:'left',width:110},
				{name:'cciclo',index:'cciclo',align:'left',width:100,hidden:true},
				{name:'dciclo',index:'dciclo',align:'left',width:100},
				{name:'ncredit',index:'ncredit',align:'center',width:70},
				{name:'nhorteo',index:'nhorteo',align:'center',width:70},
				{name:'nhorpra',index:'nhorpra',align:'center',width:70},
				{name:'csilabo',index:'csilabo',align:'left',width:250},
				{name:'cestado',index:'cestado',align:'left',width:100,hidden:true},
				{name:'estado',index:'estado',align:'center',width:80,editable:true,editrules:{required:true},stype:"select",edittype:"select",editoptions:{value:" : ;1:Activo;0:Inactivo"}}
			],			
			rowNum:10,
			rowList:[5,10,20,30],
			rownumbers:true,
			pager:'pager_table_curso_proc',
			sortname:'a.caspral',
			sortorder:'desc',
			loadui:'block',			
		});
		$('#table_curso_proc').jqGrid('navGrid','#pager_table_curso_proc',{edit:false,add:false,del:false,view:false,search:false});
		$("#table_curso_proc").jqGrid('filterToolbar');
		$("#table_curso_proc").jqGrid('navButtonAdd',"#pager_table_curso_proc",{
            caption:"",
            title:"Buscar Registro", 
            buttonicon :'ui-icon-search', 
            onClickButton:function(){
                gridTU[0].toggleToolbar() 
            } 
        });
        //Agregando boton Insert
        $('#table_curso_proc').jqGrid('navButtonAdd','pager_table_curso_proc',{
            caption:"",
            title:"Agregar Curso de Procedencia",
            buttonicon:'ui-icon-plus',
            onClickButton:function(){
                add_jqgrid();
            }
        });
        //Agregando boton Edit
        $('#table_curso_proc').jqGrid('navButtonAdd','pager_table_curso_proc',{
            caption:"",
            title:"Editar Curso de Procedencia",
            buttonicon:'ui-icon-pencil',
            onClickButton:function(){
                edit_jqgrid();
            }
        }); 
	},
	personaIngAlum3:function(){
		var gridTU=$('#table_persona_ingalum').jqGrid({
			url:'../controlador/controladorSistema.php?comando=persona&accion=jqgrid_personaIngAlum2',
			datatype:this.type,
			gridview:true,
			height:240,
			colNames:['Estado','Filial','Institucion','Carrera','Inicio','Fecha Inicio','Horario','Semestre','cperson','Paterno','Materno','Nombres','DNI','cingalu','nfotos','certest','partnac','fotodni','otrodni','cpais','tinstip','dinstip','dcarrep','ultanop','dciclop','ddocval','cmoding','cdevolu'],
			colModel:[
				{name:'cestado',index:'cestado',align:'center',width:80,editable:true,editrules:{required:true},stype:"select",edittype:"select",editoptions:{value:" : ;1:Activo;0:Retirado"}},
				{name:'dfilial',index:'dfilial',align:'left',width:110},
				{name:'dinstit',index:'dinstit',align:'left',width:100},
				{name:'dcarrer',index:'dcarrer',align:'left',width:250},
				{name:'cinicio',index:'cinicio',align:'center',width:70},
				{name:'finicio',index:'finicio',align:'center',width:100},
				{name:'dhorari',index:'dhorari',align:'center',width:120},
				{name:'csemaca',index:'csemaca',align:'center',width:100},
				{name:'cperson',index:'cperson',align:'left',width:150,hidden:true},				
				{name:'dappape',index:'dappape',align:'left',width:100},
				{name:'dapmape',index:'dapmape',align:'left',width:100},
				{name:'dnomper',index:'dnomper',align:'left',width:100},
				{name:'ndniper',index:'ndniper',align:'center',width:100},
				{name:'cingalu',index:'cingalu',align:'center',width:100,hidden:true},
				{name:'nfotos',index:'nfotos',align:'center',width:100,hidden:true},
				{name:'certest',index:'certest',align:'center',width:100,hidden:true},
				{name:'partnac',index:'partnac',align:'center',width:100,hidden:true},
				{name:'fotodni',index:'fotodni',align:'center',width:100,hidden:true},
				{name:'otrodni',index:'otrodni',align:'center',width:100,hidden:true},
				{name:'cpais',index:'cpais',align:'center',width:100,hidden:true},
				{name:'tinstip',index:'tinstip',align:'center',width:100,hidden:true},
				{name:'dinstip',index:'dinstip',align:'center',width:100,hidden:true},
				{name:'dcarrep',index:'dcarrep',align:'center',width:100,hidden:true},
				{name:'ultanop',index:'ultanop',align:'center',width:100,hidden:true},
				{name:'dciclop',index:'dciclop',align:'center',width:100,hidden:true},
				{name:'ddocval',index:'ddocval',align:'center',width:100,hidden:true},
				{name:'cmoding',index:'cmoding',align:'center',width:100,hidden:true},
				{name:'cdevolu',index:'cdevolu',align:'center',width:100,hidden:true}
			],			
			rowNum:10,
			rowList:[5,10,20,30],
			rownumbers:true,
			pager:'pager_table_persona_ingalum',
			sortname:'g.csemaca,i.cingalu',
			sortorder:'asc',
			loadui:'block',			
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
            title:"Cargar Alumno", 
            buttonicon :'icon-ok-sign', 
            onClickButton:function(){
				eventoClick();
            } 
        }); 
	},
	personaIngAlum4:function(){
		var gridTU=$('#table_persona_ingalum').jqGrid({
			url:'../controlador/controladorSistema.php?comando=persona&accion=jqgrid_personaIngAlum4',
			datatype:this.type,
			gridview:true,
			height:240,
			colNames:['Estado','Filial','Institucion','Carrera','Modalidad Ingreso','Inicio','Fecha Inicio','Horario','Semestre','cperson','Serie Matricula','Paterno','Materno','Nombres','DNI','cingalu','Codigo Libro','dinstip','dcarrep'],
			colModel:[
				{name:'cestado',index:'cestado',align:'center',width:80,editable:true,editrules:{required:true},stype:"select",edittype:"select",editoptions:{value:" : ;1:Activo;0:Retirado"}},
				{name:'dfilial',index:'dfilial',align:'left',width:110},
				{name:'dinstit',index:'dinstit',align:'left',width:100},
				{name:'dcarrer',index:'dcarrer',align:'left',width:250},
				{name:'dmoding',index:'dmoding',align:'left',width:100},
				{name:'cinicio',index:'cinicio',align:'center',width:70},
				{name:'finicio',index:'finicio',align:'center',width:100},
				{name:'dhorari',index:'dhorari',align:'center',width:120},
				{name:'csemaca',index:'csemaca',align:'center',width:100},
				{name:'cperson',index:'cperson',align:'left',width:150,hidden:true},	
				{name:'sermatr',index:'sermatr',align:'center',width:100},			
				{name:'dappape',index:'dappape',align:'left',width:100},
				{name:'dapmape',index:'dapmape',align:'left',width:100},
				{name:'dnomper',index:'dnomper',align:'left',width:100},
				{name:'ndniper',index:'ndniper',align:'center',width:100},
				{name:'cingalu',index:'cingalu',align:'center',width:100,hidden:true},
				{name:'dcodlib',index:'dcodlib',align:'center',width:100},
				{name:'dinstip',index:'dinstip',align:'center',width:100,hidden:true},
				{name:'dcarrep',index:'dcarrep',align:'center',width:100,hidden:true}
			],			
			rowNum:10,
			rowList:[5,10,20,30],
			rownumbers:true,
			pager:'pager_table_persona_ingalum',
			sortname:'g.csemaca,i.cingalu',
			sortorder:'asc',
			loadui:'block',			
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
				eventoClick();
            } 
        }); 
	},	
	personaConcepto:function(){
		var gridTU=$('#table_jqgrid_concep').jqGrid({
			url:'../controlador/controladorSistema.php?comando=persona&accion=jqgrid_personaConcepto',
			datatype:this.type,
			gridview:true,
			height:240,
			colNames:['Estado','Filial','Institucion','Carrera','Semestre','cperson','Paterno','Materno','Nombres','DNI','cconcep','CONCEPTO','MONTO','cingalu','crecaca'],
			colModel:[
				{name:'cestado',index:'cestado',align:'center',width:80,editable:true,editrules:{required:true},stype:"select",edittype:"select",editoptions:{value:" : ;1:Devuelto;0:Pendiente"}},
				{name:'dfilial',index:'dfilial',align:'left',width:110},
				{name:'dinstit',index:'dinstit',align:'left',width:100},
				{name:'dcarrer',index:'dcarrer',align:'left',width:250},
				{name:'csemaca',index:'csemaca',align:'center',width:100},
				{name:'cperson',index:'cperson',align:'left',width:150,hidden:true},
				{name:'dappape',index:'dappape',align:'left',width:100},
				{name:'dapmape',index:'dapmape',align:'left',width:100},
				{name:'dnomper',index:'dnomper',align:'left',width:100},
				{name:'ndniper',index:'ndniper',align:'center',width:100},
				{name:'cconcep',index:'cconcep',align:'center',width:150,hidden:true},
				{name:'dconcep',index:'dconcep',align:'center',width:150},
				{name:'nmonrec',index:'nmonrec',align:'center',width:100},
				{name:'cingalu',index:'cingalu',align:'center',width:100,hidden:true},
				{name:'crecaca',index:'crecaca',align:'center',width:100,hidden:true}
			],
			rowNum:10,
			rowList:[5,10,20,30],
			rownumbers:true,
			pager:'pager_table_jqgrid_concep',
			sortname:'g.csemaca,i.cingalu',
			sortorder:'asc',
			loadui:'block',
			/*ondblClickRow: function(ids){
				var data = $("#table_persona_ingalum").jqGrid('getRowData',ids);
                $("#table_pago").jqGrid('setGridParam',{url:'../controlador/controladorSistema.php?comando=pago&accion=jqgrid_pago&cfilial='+$('#hd_idFilial').val()+'&cingalu='+ids.split("-")[0]+'&cgracpr='+ids.split("-")[1]+'&cperson='+data.cperson}); 
        		$("#table_pago").trigger('reloadGrid');
            }*/
		});
		$('#table_jqgrid_concep').jqGrid('navGrid','#pager_table_jqgrid_concep',{edit:false,add:false,del:false,view:false,search:false});
		$("#table_jqgrid_concep").jqGrid('filterToolbar');
		$("#table_jqgrid_concep").jqGrid('navButtonAdd',"#pager_table_jqgrid_concep",{
            caption:"",
            title:"Buscar Registro", 
            buttonicon :'ui-icon-search', 
            onClickButton:function(){
                gridTU[0].toggleToolbar() 
            } 
        });
		$("#table_jqgrid_concep").jqGrid('navButtonAdd',"#pager_table_jqgrid_concep",{
            caption:"",
            title:"Cargar Pagos", 
            buttonicon :'icon-ok-sign', 
            onClickButton:function(){
				var ids=$("#table_jqgrid_concep").jqGrid("getGridParam",'selrow');
				$("#txt_persona_elegida").val(ids);
				var data = $("#table_jqgrid_concep").jqGrid('getRowData',ids);	
					if(data.cestado=='Pendiente' || data.cestado=='0'){
					$("#txt_nmonrec_concepto").val(data.nmonrec);
					$("#txt_cconcep_concepto").val(data.cconcep);
					$("#txt_persona_elegida").val(ids+"-"+data.cperson+"-"+data.cconcep+"-"+data.crecaca);
					$("#txt_persona_person").val(data.dnomper+' '+data.dappape+' '+data.dapmape);					
					}
					else{
					$("#txt_nmonrec_concepto").val('');
					$("#txt_cconcep_concepto").val('');
					$("#txt_persona_elegida").val('');
					$("#txt_persona_person").val('');
					sistema.msjAdvertencia('Devolucion del alumno, ya realizada anteriormente',3000);
					}
				cargarConcepto();cargarConceptoIns();PrepararPagos();Limpiarpagos();
								/*$("#table_pago").jqGrid('setGridParam',{url:'../controlador/controladorSistema.php?comando=pago&accion=jqgrid_pago&cfilial='+$('#hd_idFilial').val()+'&cingalu='+ids.split("-")[0]+'&cgracpr='+ids.split("-")[1]+'&cperson='+data.cperson}); 
        		$("#table_pago").trigger('reloadGrid');                */
            } 
        }); 
	},
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
			colNames:['COD INT','Paterno','Materno','Nombres','DNI','demail','telefono','tipo_documento','sexo','cod_dpto','cod_prov','cod_dist','direccion','fecha_ingreso','codigo_instituto','tipo_vendedor','Estado'],
			colModel:[
				{name:'codintv',index:'codintv',align:'left',width:80},
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
				{name:'cinstit',index:'cinstit',align:'left',width:10,hidden:true},
				{name:'tvended',index:'tvended',align:'left',width:10,hidden:true},
				{name:'cestado',index:'cestado',align:'center',width:100,editable:true,editrules:{required:true},stype:"select",edittype:"select",editoptions:{value:" : ;1:Activo;0:Inactivo"},hidden:true}
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
	},
	jqgridVended:function(){
		var gridTU=$('#table_jqgrid_vended').jqGrid({
			url:'../controlador/controladorSistema.php?comando=persona&accion=jqgrid_trabajador&cestado=1&tvended='+$("#slct_medio_captacion").val().split("-")[2],
			datatype:this.type,
			gridview:true,
			height:232,
			colNames:['COD INT','Paterno','Materno','Nombres','DNI','demail','telefono','tipo_documento','sexo','cod_dpto','cod_prov','cod_dist','direccion','fecha_ingreso','codigo_instituto','tipo_vendedor','Estado',"copeven"],
			colModel:[
				{name:'codintv',index:'codintv',align:'left',width:80},
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
				{name:'cinstit',index:'cinstit',align:'left',width:10,hidden:true},
				{name:'tvended',index:'tvended',align:'left',width:10,hidden:true},
				{name:'cestado',index:'cestado',align:'center',width:100,editable:true,editrules:{required:true},stype:"select",edittype:"select",editoptions:{value:" : ;1:Activo;0:Inactivo"},hidden:true},
                {name:'copeven',index:'copeven',align:'left',width:10,hidden:true},
			],
			rowNum:10,
			//rowList:[10,20,30],
			rownumbers:true,
			pager:'pager_table_jqgrid_vended',
			sortname:'v.cvended',
			sortorder:'asc',
			loadui:'block'
		});
		$('#table_jqgrid_vended').jqGrid('navGrid','#pager_table_jqgrid_vended',{edit:false,add:false,del:false,view:false,search:false});
		$("#table_jqgrid_vended").jqGrid('filterToolbar');
		//gridTU[0].toggleToolbar();//oculta fila de busqueda, boton "buscar registro" lo activara
		$('#table_jqgrid_vended').jqGrid('navButtonAdd','pager_table_jqgrid_vended',{
            caption:"",
            title:"Agregar Vendedor",
            buttonicon:'ui-icon-plus',
            onClickButton:function(){
                //add_exalumno_jqgrid();
            }
        });
        $('#table_jqgrid_vended').jqGrid('navButtonAdd','pager_table_jqgrid_vended',{
            caption:"",
            title:"Editar",
            buttonicon:'ui-icon-pencil',
            onClickButton:function(){
                //edit_exalumno_jqgrid();
            }
        });
        $("#table_jqgrid_vended").jqGrid('navButtonAdd',"#pager_table_jqgrid_vended",{
            caption:"",
            title:"Buscar Registro", 
            buttonicon :'ui-icon-search', 
            onClickButton:function(){
                gridTU[0].toggleToolbar() 
            } 
        });
		$("#table_jqgrid_vended").jqGrid('navButtonAdd',"#pager_table_jqgrid_vended",{
            caption:"",
            title:"Cargar", 
            buttonicon :'icon-ok-sign', 
            onClickButton:function(){
                cargar_vended_jqgrid();
            } 
        }); 
	}
}