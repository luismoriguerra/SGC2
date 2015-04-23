var jQGridTipoCaptacion={
    type:'json',
    idLayerMessage:'layerMessage',
    TipoCaptacion: function(){
        var gridC=$('#table_tipo_captacion').jqGrid({
            url:'../controlador/controladorSistema.php?comando=tipo_captacion&action=jqgrid_tipo_captacion',
            datatype:this.type,
            gridview:true,
            height:345,
            colNames:['Nombre','Identificación','Clase','Estado'],
            colModel:[
               
                {name:'dtipcap',index:'dinstit',align:'left',width:320,editable:true,editrules:{required:true},sorttype:"text"}, 
				{name:'didetip',index:'didetip',align:'left',width:50,editable:true,editrules:{required:true},sorttype:"text"}, 
				{name:'dclacap',index:'dclacap',align:'center',width:100,editable:true,editrules:{required:true},stype:"select",edittype:"select",editoptions:{value:" : ;1:NO COMISIONAN;2:SI COMISIONAN;3:MASIVOS"}},
				{name:'cestado',index:'cestado',align:'center',width:100,editable:true,editrules:{required:true},stype:"select",edittype:"select",editoptions:{value:" : ;1:ACTIVADO;2:DESACTIVADO"}}
				
            ],
            rowNum:15,
            //rowList:[5,10],
            rownumbers:true,
            pager:'#pager_table_tipo_captacion',
            sortname:'ctipcap',
            sortorder:'asc',
            loadui: "block"
        });
		
        $("#table_tipo_captacion").jqGrid('filterToolbar');
        gridC[0].toggleToolbar();//oculta fila de busqueda, boton "buscar registro" lo activara
        $('#table_tipo_captacion').jqGrid('navGrid','#pager_table_tipo_captacion',{edit:true,add:true,del:false,view:false,search:false},
         {
                url : '../controlador/controladorSistema.php',
                reloadAfterSubmit : true,
                clearAfterEdit : true,
                closeAfterEdit : true,
                editData : {comando : 'tipo_captacion', action : 'actualizarTipoCaptacion',cfilialx:$('#hd_idFilial').val(), usuario_modificacion : $('#hd_idUsuario').val()},
                afterComplete : function ( response, postData, formid ) {
                    var objJSON = $.parseJSON(response.responseText);
                    var status = response.status;
                    if( status == 200 ){
                        if( objJSON.rst==1 ) {
                            sistema.msjOk(objJSON.msg,'2000');
                        }else if(objJSON.rst==2){
                            sistema.msjAdvertencia(objJSON.msg,'2000');
                        }else{
                            sistema.msjError(objJSON.msg,'2000');
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
                editData : {comando : 'tipo_captacion', action : 'insertarTipoCaptacion',cfilialx:$('#hd_idFilial').val(), usuario_creacion : $('#hd_idUsuario').val()},
                afterComplete : function ( response, postData, formid ) {
                    var objJSON = $.parseJSON(response.responseText);
                    var status = response.status;
                    if( status == 200 ){
                        if( objJSON.rst==1 ) {
                            sistema.msjOk(objJSON.msg,'2000');
                        }else if(objJSON.rst==2){
                           sistema.msjAdvertencia(objJSON.msg,'2000');
                        }else{
                            sistema.msjError(objJSON.msg,'2000');
                        }
                    }else{
                        sistema.msjError('Error general en Proceso','300');
                    }
                }
            }      
        );
        $("#table_tipo_captacion").jqGrid('navButtonAdd',"#pager_table_tipo_captacion",{
            caption:"",
            title:"Buscar Registro", 
            buttonicon :'icon-search', 
            onClickButton:function(){
                gridC[0].toggleToolbar() 
            } 
        });
    }
}


