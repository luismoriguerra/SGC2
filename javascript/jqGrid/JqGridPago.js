var jqGridPago={
	type:'json',
	pago:function(){
		var gridTU=$('#table_pago').jqGrid({
			url:'../controlador/controladorSistema.php?comando=pago&accion=jqgrid_pago&cfilial='+$('#hd_idFilial').val(),
			datatype:this.type,
			gridview:true,
			height:290,
			colNames:['crecaca','Cuota','Concepto','Semestre','Ciclo','T. Pago','Nro Doc ','Monto','Fecha Pago','Fecha Vencimiento'],
			colModel:[
				{name:'crecaca',index:'crecaca',align:'left',width:150,hidden:true},
				{name:'dcuota',index:'dcuota',align:'left',width:100},
				{name:'dconcep',index:'dconcep',align:'left',width:250},
				{name:'csemaca',index:'csemaca',align:'left',width:70},
				{name:'dciclo',index:'dciclo',align:'left',width:70},
				{name:'pago',index:'pago',align:'center',width:100},
				{name:'monto',index:'monto',align:'center',width:100},
				{name:'nmonrec',index:'nmonrec',align:'center',width:80},
				{name:'festfin',index:'festfin',align:'center',width:100},
				{name:'fvencim',index:'fvencim',align:'center',width:100}
			],
			rowNum:20,
			rowList:[20,40,60],
			rownumbers:true,
			pager:'pager_table_pago',
			sortname:'r.ccuota,r.fvencim,r.cconcep,r.testfin',
			sortorder:'asc',
			loadui:'block',
			caption:'PAGOS',
			multiselect:true,
			gridComplete: function(){			
				$("#table_pago tr[id^='P_']").map(function(index, element) {					
                   $("#jqg_table_pago_"+element.id).attr("disabled","true");
                });                
			},
			onSelectAll: function(){			
				$("#table_pago tr[id^='P_']").map(function(index, element) {
				   $("#jqg_table_pago_"+element.id).removeAttr("checked");
				   $("#"+element.id).removeClass("ui-state-highlight");
                });                
			},
			onSelectRow: function(ids){
				$("#table_pago tr[id^='P_']").map(function(index, element) {
				   $("#jqg_table_pago_"+element.id).removeAttr("checked");
				   $("#"+element.id).removeClass("ui-state-highlight");
                });
            }			
		});
		$('#table_pago').jqGrid('navGrid','#pager_table_pago',{edit:false,add:false,del:false,view:false,search:false});
		$("#table_pago").jqGrid('navButtonAdd',"#pager_table_pago",{
            caption:"Cargar",
            title:"Cargar Inscrito", 
            buttonicon :'icon-ok-sign', 
            onClickButton:function(){
            	ids=$('#table_pago').jqGrid('getGridParam','selarrrow');
            	if(ids.length==0){
            		sistema.msjAdvertencia('Seleccione <b>Registros de Pago</b>');
            	}else{
            		cargarMontoPago();            		
            	}
                
            } 
        }); 
	},
	pagolista:function(){
		var gridTU=$('#table_pago').jqGrid({
			url:'../controlador/controladorSistema.php?comando=pago&accion=jqgrid_pago&cfilial='+$('#hd_idFilial').val(),
			datatype:this.type,
			gridview:true,
			height:290,
			colNames:['crecaca','Cuota','Concepto','Semestre','Ciclo','T. Pago','Nro Doc ','Monto','Fecha Pago','Fecha Vencimiento'],
			colModel:[
				{name:'crecaca',index:'crecaca',align:'left',width:150,hidden:true},
				{name:'dcuota',index:'dcuota',align:'left',width:100},
				{name:'dconcep',index:'dconcep',align:'left',width:250},
				{name:'csemaca',index:'csemaca',align:'left',width:70},
				{name:'dciclo',index:'dciclo',align:'left',width:70},
				{name:'pago',index:'pago',align:'center',width:100},
				{name:'monto',index:'monto',align:'center',width:100},
				{name:'nmonrec',index:'nmonrec',align:'center',width:80},
				{name:'festfin',index:'festfin',align:'center',width:100},
				{name:'fvencim',index:'fvencim',align:'center',width:100}
			],
			rowNum:20,
			rowList:[20,40,60],
			rownumbers:true,
			pager:'pager_table_pago',
			sortname:'r.ccuota,r.fvencim,r.cconcep,r.testfin',
			sortorder:'asc',
			loadui:'block',
			caption:'PAGOS',
			//multiselect:true,
			gridComplete: function(){			
				$("#table_pago tr[id^='P_']").map(function(index, element) {					
                   $("#jqg_table_pago_"+element.id).attr("disabled","true");
                });                
			},
			/*onSelectAll: function(){			
				$("#table_pago tr[id^='P_']").map(function(index, element) {
				   $("#jqg_table_pago_"+element.id).removeAttr("checked");
				   $("#"+element.id).removeClass("ui-state-highlight");
                });                
			},
			onSelectRow: function(ids){
				$("#table_pago tr[id^='P_']").map(function(index, element) {
				   $("#jqg_table_pago_"+element.id).removeAttr("checked");
				   $("#"+element.id).removeClass("ui-state-highlight");
                });
            }*/			
		});
		$('#table_pago').jqGrid('navGrid','#pager_table_pago',{edit:false,add:false,del:false,view:false,search:false});
		/*$("#table_pago").jqGrid('navButtonAdd',"#pager_table_pago",{
            caption:"Cargar",
            title:"Cargar Inscrito", 
            buttonicon :'icon-ok-sign', 
            onClickButton:function(){
            	ids=$('#table_pago').jqGrid('getGridParam','selarrrow');
            	if(ids.length==0){
            		sistema.msjAdvertencia('Seleccione <b>Registros de Pago</b>');
            	}else{
            		cargarMontoPago();            		
            	}
                
            } 
        });*/ 
	}
}