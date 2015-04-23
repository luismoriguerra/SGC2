var jqGridInscrito={
	type:'json',
	inscrito:function(){
		var gridTU=$('#table_inscrito').jqGrid({
			url:'../controlador/controladorSistema.php?comando=inscrito&accion=jqgrid_inscrito&cinstit='+$('#hd_idInstituto').val(),
			datatype:this.type,
			gridview:true,
			height:232,
			colNames:['NOMBRES','PATERNO','MATERNO','DNI','email1','ntelpe2','ntelper','ntellab','ddirper','ddirref','ddirlab','dnomlab','ddepart','dprovin','ddistri','ccarrer','CARRERA','ctipcar','cmodali','csemadm','cinicio','cmoding','serinsc','certest','partnac','fotodni','otrodni'],
			colModel:[
				{name:'dnomper',index:'dnomper',align:'left',width:150},
				{name:'dappape',index:'dappape',align:'left',width:150},
				{name:'dapmape',index:'dapmape',align:'left',width:150},
				{name:'ndniper',index:'ndniper',align:'center',width:100},				
				{name:'email1',index:'email1',hidden:true},
				{name:'ntelpe2',index:'ntelpe2',hidden:true},
				{name:'ntelper',index:'ntelper',hidden:true},
				{name:'ntellab',index:'ntellab',hidden:true},
				{name:'ddirper',index:'ddirper',hidden:true},
				{name:'ddirref',index:'ddirref',hidden:true},
				{name:'ddirlab',index:'ddirlab',hidden:true},
				{name:'dnomlab',index:'dnomlab',hidden:true},
				{name:'ddepart',index:'ddepart',hidden:true},
				{name:'dprovin',index:'dprovin',hidden:true},
				{name:'ddistri',index:'ddistri',hidden:true},				
				{name:'ccarrer',index:'ccarrer',hidden:true},
				{name:'dcarrer',index:'dcarrer',align:'left',width:250},
				{name:'ctipcar',index:'ctipcar',hidden:true},
				{name:'cmodali',index:'cmodali',hidden:true},
				{name:'csemadm',index:'csemadm',hidden:true},
				{name:'cinicio',index:'cinicio',hidden:true},
				{name:'tmodpos',index:'tmodpos',hidden:true},
				{name:'serinsc',index:'serinsc',hidden:true},
				{name:'certest',index:'certest',hidden:true},
				{name:'partnac',index:'partnac',hidden:true},
				{name:'fotodni',index:'fotodni',hidden:true},
				{name:'otrodni',index:'otrodni',hidden:true}
			],
			rowNum:10,
			rowList:[10,20,30],
			rownumbers:true,
			pager:'pager_table_inscrito',
			sortname:'p.cperson',
			sortorder:'asc',
			loadui:'block',
			ondblClickRow: function(){
                mostrarInscripcion();
            }
		});
		$('#table_inscrito').jqGrid('navGrid','#pager_table_inscrito',{edit:false,add:false,del:false,view:false,search:false});
		$("#table_inscrito").jqGrid('filterToolbar');
		$("#table_inscrito").jqGrid('navButtonAdd',"#pager_table_inscrito",{
            caption:"",
            title:"Buscar Registro", 
            buttonicon :'ui-icon-search', 
            onClickButton:function(){
                gridTU[0].toggleToolbar() 
            } 
        });
		$("#table_inscrito").jqGrid('navButtonAdd',"#pager_table_inscrito",{
            caption:"",
            title:"Cargar Inscrito", 
            buttonicon :'icon-ok-sign', 
            onClickButton:function(){
                mostrarInscripcion();
            } 
        }); 
	},
	
}