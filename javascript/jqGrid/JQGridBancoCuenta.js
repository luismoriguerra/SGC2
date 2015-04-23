var jQGridCuenta={
    type:'json',
    idLayerMessage:'layerMessage',
    Cuenta: function(){
        var gridC=$('#table_cuenta').jqGrid({
            url:'../controlador/controladorSistema.php?comando=cuenta&action=jqgrid_cuenta&cinstit2='+$("#hd_idInstituto").val(),
            datatype:this.type,
            gridview:true,
            height:470,
            colNames:['Banco','Nro Cuenta','Descripción','Dato1','Dato2','Dato3','Dato4','Dato5',"Estado"],
            colModel:[               
                {name:'cbanco',index:'cbanco',align:'center',width:80,editable:true,editrules:{required:true},stype:"select",edittype:"select",editoptions:{value:$("#cbanco").val()}},
				{name:'nrocta',index:'nrocta',align:'left',width:80,editable:true,editrules:{required:true},sorttype:"text"}, 
				{name:'descta',index:'descta',align:'left',width:150,editable:true,editrules:{required:true},sorttype:"text"}, 
				{name:'dato01',index:'dato01',align:'left',width:80,editable:true,editrules:{required:false},sorttype:"text"},
                {name:'dato02',index:'dato02',align:'left',width:80,editable:true,editrules:{required:false},sorttype:"text"},
                {name:'dato03',index:'dato03',align:'left',width:80,editable:true,editrules:{required:false},sorttype:"text"},
                {name:'dato04',index:'dato04',align:'left',width:80,editable:true,editrules:{required:false},sorttype:"text"},
                {name:'dato05',index:'dato05',align:'left',width:80,editable:true,editrules:{required:false},sorttype:"text"},
				{name:'cestado',index:'cestado',align:'center',width:100,editable:true,editrules:{required:true},stype:"select",edittype:"select",editoptions:{value:" : ;1:Activo;0:Inactivo"}}//" : , para coger todos los valores 1 y 0, campo required lo interpreta en blanco"
            ],
            rowNum:20,
            //rowList:[5,10],
            rownumbers:true,
            pager:'#pager_table_cuenta',
            sortname:'c.cctacte',
            sortorder:'asc',
            loadui: "block"
        });
		
        $("#table_cuenta").jqGrid('filterToolbar');
        gridC[0].toggleToolbar();//oculta fila de busqueda, boton "buscar registro" lo activara
        $('#table_cuenta').jqGrid('navGrid','#pager_table_cuenta',{edit:true,add:true,del:false,view:false,search:false},
         {
                url : '../controlador/controladorSistema.php',
                reloadAfterSubmit : true,
                clearAfterEdit : true,
                closeAfterEdit : true,
                editData : {comando : 'cuenta', action : 'actualizarCuenta',cfilialx:$('#hd_idFilial').val(), usuario_modificacion : $('#hd_idUsuario').val()},
                afterComplete : function ( response, postData, formid ) {
                    var objJSON = $.parseJSON(response.responseText);
                    var status = response.status;
                    if( status == 200 ){
                        if( objJSON.rst==1 ) {
                            sistema.msjOk(objJSON.msg,'2000');
                        }else if(objJSON.rst==2){
                            sistema.msjAdvertencia(objJSON.msg,'5000');
                        }else{
                            sistema.msjError(objJSON.msg,'200');
                        }
                    }else{
                        sistema.msjError('Error general en Proceso','300');
                    }
                }
            },
                     {
               url : '../controlador/controladorSistema.php',
                reloadAfterSubmit : true,
                clearAfterAdd : true,
                closeAfterAdd : true,
                editData : {comando : 'cuenta', action : 'insertarCuenta',cfilialx:$('#hd_idFilial').val(), usuario_creacion : $('#hd_idUsuario').val()},
                afterComplete : function ( response, postData, formid ) {
                    var objJSON = $.parseJSON(response.responseText);
                    var status = response.status;
                    if( status == 200 ){
                        if( objJSON.rst==1 ) {
                            sistema.msjOk(objJSON.msg,'200');
                        }else if(objJSON.rst==2){
                           sistema.msjAdvertencia(objJSON.msg,'200');
                        }else{
                            sistema.msjError(objJSON.msg,'200');
                        }
                    }else{
                        sistema.msjError('Error general en Proceso','300');
                    }
                }
            }      
        );
        $("#table_cuenta").jqGrid('navButtonAdd',"#pager_table_cuenta",{
            caption:"",
            title:"Buscar Registro", 
            buttonicon :'icon-search', 
            onClickButton:function(){
                gridC[0].toggleToolbar() 
            } 
        });
    }
}


