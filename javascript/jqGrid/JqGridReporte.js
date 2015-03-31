var jqGridReporte={
	type:'json',
	arqueo:function(){
		var gridTU=$('#table_arqueo').jqGrid({
			url:'../controlador/controladorSistema.php?comando=reporte&accion=jqgrid_arqueo&cfilial='+$('#hd_idFilial').val()+'&finicio='+$("#txt_fechaInicio").val()+'&ffin='+$("#txt_fechaFin").val()+'&serbol='+$("#txt_serie_boleta").val()+'&nrobol='+$("#txt_nro_boleta").val(),
			datatype:this.type,
			gridview:true,
			height:470,
			colNames:['FECHA','COD CUENTA INGRESO','ALUMNO(A)','CAJERO(A)','INSTITUCIÓN','SERIE','NRO BOLETA','IMPORTE'],
			colModel:[
				{name:'festfin',index:'festfin',align:'left',width:100},
				{name:'cctaing',index:'cctaing',align:'left',width:120},
				{name:'alumno',index:'alumno',align:'left',width:250},
				{name:'cajero',index:'cajero',align:'left',width:250},
				{name:'dinstit',index:'dinstit',align:'left',width:100},
				{name:'pago',index:'pago',align:'center',width:40},
				{name:'pago',index:'pago',align:'center',width:80},
				{name:'nmonrec',index:'nmonrec',align:'center',width:80}
			],
			rowNum:20,
			rowList:[20,40,60],
			rownumbers:true,
			pager:'pager_table_arqueo',
			sortname:'r.festfin',
			sortorder:'asc',
			loadui:'block',
			caption:'ARQUEO DE CAJA',
			gridComplete: function(){
			$("#validalista").css("display","");	               
			},
		});		
		$('#table_arqueo').jqGrid('navGrid','#pager_table_arqueo',{edit:false,add:false,del:false,view:false,search:false});		
	},
	arqueo_boleta:function(){
		var gridTU=$('#table_arqueo').jqGrid({
			url:'../controlador/controladorSistema.php?comando=reporte&accion=jqgrid_arqueo&finicio='+$("#txt_fechaInicio").val()+'&ffin='+$("#txt_fechaFin").val()+'&serbol='+$("#txt_serie_boleta").val()+'&nrobol='+$("#txt_nro_boleta").val(),
			datatype:this.type,
			gridview:true,
			height:470,
			colNames:['FECHA','COD CUENTA INGRESO','ALUMNO(A)','CAJERO(A)','INSTITUCIÓN','SERIE','NRO BOLETA','IMPORTE'],
			colModel:[
				{name:'festfin',index:'festfin',align:'left',width:100},
				{name:'cctaing',index:'cctaing',align:'left',width:120},
				{name:'alumno',index:'alumno',align:'left',width:250},
				{name:'cajero',index:'cajero',align:'left',width:250},
				{name:'dinstit',index:'dinstit',align:'left',width:100},
				{name:'nserbol',index:'nserbol',align:'center',width:40},
				{name:'nnrobol',index:'nnrobol',align:'center',width:80},
				{name:'nmonrec',index:'nmonrec',align:'center',width:80}
			],
			rowNum:20,
			rowList:[20,40,60],
			rownumbers:true,
			pager:'pager_table_arqueo',
			sortname:'r.festfin',
			sortorder:'asc',
			loadui:'block',
			caption:'BOLETA',
			gridComplete: function(){
			$("#validalista").css("display","");
				$("#table_arqueo tr[id^='P_']").map(function(index, element) {					
                   $("#jqg_table_arqueo_"+element.id).attr("disabled","true");
                });                
			},
		});		
		$('#table_arqueo').jqGrid('navGrid','#pager_table_arqueo',{edit:false,add:false,del:false,view:false,search:false});		
		$("#table_arqueo").jqGrid('navButtonAdd',"#pager_table_arqueo",{
            caption:"Actualizar",
            title:"Actualizar Boleta", 
            buttonicon :'icon-ok-sign', 
            onClickButton:function(){
            		ActualizarBoleta();
                
            } 
        }); 
	},
	arqueo_boleta2:function(){
		var gridTU=$('#table_arqueo').jqGrid({
			url:'../controlador/controladorSistema.php?comando=reporte&accion=jqgrid_arqueo&finicio='+$("#txt_fechaInicio").val()+'&ffin='+$("#txt_fechaFin").val()+'&serbol='+$("#txt_serie_boleta").val()+'&nrobol='+$("#txt_nro_boleta").val(),
			datatype:this.type,
			gridview:true,
			height:470,
			colNames:['FECHA','COD CUENTA INGRESO','ALUMNO(A)','CAJERO(A)','INSTITUCIÓN','SERIE','NRO BOLETA','IMPORTE'],
			colModel:[
				{name:'festfin',index:'festfin',align:'left',width:100},
				{name:'cctaing',index:'cctaing',align:'left',width:120},
				{name:'alumno',index:'alumno',align:'left',width:250},
				{name:'cajero',index:'cajero',align:'left',width:250},
				{name:'dinstit',index:'dinstit',align:'left',width:100},
				{name:'nserbol',index:'nserbol',align:'center',width:40},
				{name:'nnrobol',index:'nnrobol',align:'center',width:80},
				{name:'nmonrec',index:'nmonrec',align:'center',width:80}
			],
			rowNum:20,
			rowList:[20,40,60],
			rownumbers:true,
			pager:'pager_table_arqueo',
			sortname:'r.festfin',
			sortorder:'asc',
			loadui:'block',
			caption:'BOLETA',
			gridComplete: function(){
			$("#validalista").css("display","");
				$("#table_arqueo tr[id^='P_']").map(function(index, element) {					
                   $("#jqg_table_arqueo_"+element.id).attr("disabled","true");
                });                
			},
		});		
		$('#table_arqueo').jqGrid('navGrid','#pager_table_arqueo',{edit:false,add:false,del:false,view:false,search:false});
	},
	bitbol:function(){ // bitacora de la boleta
		var gridTU=$('#table_bitbol').jqGrid({
			url:'../controlador/controladorSistema.php?comando=reporte&accion=jqgrid_bitbol&finicio='+$("#txt_fechaInicio").val()+'&ffin='+$("#txt_fechaFin").val()+'&serbol='+$("#txt_serie_boleta").val()+'&nrobol='+$("#txt_nro_boleta").val(),
			datatype:this.type,
			gridview:true,
			height:470,
			colNames:['FILIAL','PERSONA QUE MODIFICO','FECHA Y HORA MODIFICO','BOLETA ANT.','FECHA ANT.','BOLETA NUE.','FECHA NUE.'],
			colModel:[
				{name:'dfilial',index:'dfilial',align:'left',width:100},
				{name:'nombre',index:'nombre',align:'left',width:160},
				{name:'fusuari',index:'fusuari',align:'center',width:100},
				{name:'cboleta',index:'cboleta',align:'center',width:80},
				{name:'fechaan',index:'fechaan',align:'center',width:80},				
				{name:'cboletanu',index:'cboletanu',align:'center',width:80},
				{name:'fechanu',index:'fechanu',align:'center',width:80}
			],
			rowNum:20,
			rowList:[20,40,60],
			rownumbers:true,
			pager:'pager_table_bitbol',
			sortname:'',
			sortorder:'',
			loadui:'block',
			caption:'BITACORA DE BOLETA',
			gridComplete: function(){
			$("#validalista").css("display","");               
			}
		});		
		$('#table_bitbol').jqGrid('navGrid','#pager_table_bitbol',{edit:false,add:false,del:false,view:false,search:false});
	}
}

