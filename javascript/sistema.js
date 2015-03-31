$(document).ready(function(){
    $('li[id^="sub_"]').click(sistema.armaLink);//arma link de los sub-menus
    $('#nav-inicio span[id^="sub_"]').click(sistema.armaLink);
})
var sistema={
    checked_all:function(element,idtb){
        if(element) {
            $('#'+idtb).find(':checkbox').attr('checked',true);
        }else{
            $('#'+idtb).find(':checkbox').attr('checked',false);
        }
    },
    abreCargando:function(){
        $('#capaOscura,#capaCargando').css('display','block');
    },
    cierraCargando:function(){
        $('#capaOscura,#capaCargando').css('display','none');
    },
    loading:function(){
        $('#capaOscura,#capaCargando').toggle();
    },
    limpiaSelect:function(slct_dest){
        var html='';html+='<option value="">--Seleccione--</option>';$("#"+slct_dest).html(html);
    },
    llenaSelect:function(obj,slct_dest,id_slct){//si manda mas de un select, enviar el 2do con michi adelante ej:'slct_agencia_region, #slct_nombre_agencia_region'
        var html='';
		$.each(obj,function(key,data){
			html+='<option value="'+data.id+'">'+data.nombre+'</option>';
		});
        $('#'+slct_dest).html('<option value="">--Seleccione--</option>'+html);
        $('#'+slct_dest).val(id_slct);
    },
	llenaSelectGrupo:function(obj,slct_dest,id_slct,titulo){//si manda mas de un select, enviar el 2do con michi adelante ej:'slct_agencia_region, #slct_nombre_agencia_region'
        var html='';  
		
  html+='<optgroup label="'+titulo+'">';  
        $.each(obj,function(key,data){
            html+='<option value="'+data.id+'">'+data.nombre+'</option>';
        });
  html+='</optgroup>';
  //alert(titulo);
        $('#'+slct_dest).html(html);
        $('#'+slct_dest).val(id_slct);
        $("#"+slct_dest).multiselect("refresh");
    },
	llenaSelectGrupo2:function(obj,slct_dest,id_slct,todo){
        var html='';  		
		var cab='';
				$.each(obj,function(key,data){
					if(cab!=data.titulo){
						if(cab!=""){
						html+='</optgroup>';
						}
					html+='<optgroup label="'+data.titulo+'">';
					cab=data.titulo;
					}
					html+='<option value="'+data.id+'">'+data.nombre+'</option>';
				});
		  		html+='</optgroup>';				
        $('#'+slct_dest).html(html);
        $('#'+slct_dest).val(id_slct);
		$("#"+slct_dest).multiselect("refresh");
		if(todo!=''){
		$("#"+slct_dest).multiselect("checkAll");
		}
    },
    llenaSelectTodos:function(obj,slct_dest,id_slct){//si manda mas de un select, enviar el 2do con michi adelante ej:'slct_agencia_region, #slct_nombre_agencia_region'
        var html='';
        $.each(obj,function(key,data){
            html+='<option value="'+data.id+'">'+data.nombre+'</option>';
        });
        $('#'+slct_dest).html('<option value="">Todos</option>'+html);
        $('#'+slct_dest).val(id_slct);
    },
    llenaSelectTxt:function(obj,slct_dest,id_slct,txt){//si manda mas de un select, enviar el 2do con michi adelante ej:'slct_agencia_region, #slct_nombre_agencia_region'
        var html='';
        $.each(obj,function(key,data){
            html+='<option value="'+data.id+'">'+data.nombre+'</option>';
        });
        $('#'+slct_dest).html('<option value="todo">'+txt+'</option>'+html);
        $('#'+slct_dest).val(id_slct);
    },
    requeridoSlct:function(id){
        $('#'+id).parent().children('i').remove();
        if($.trim($('#'+id).val())==''){
            $('#'+id).parent().append(' <i onclick="sistema.msjAdvertencia(\'<b>Campo Obligatorio</b>\')" title="Campo Obligatorio" class="icon-red icon-exclamation-sign p-pointer"></i>');
            return false;
        }else{return true;}
    },
    requeridoTxt:function(id){
        $('#'+id).parent().children('i').remove();
        if($.trim($('#'+id).val())==''){
            $('#'+id).parent().append(' <i onclick="sistema.msjAdvertencia(\'<b>Campo Obligatorio</b>\')" title="Campo Obligatorio" class="icon-red icon-exclamation-sign p-pointer"></i>');
            return false;
        }else{return true;}
    },
    requerido:function(id){
        $('#'+id).parent().children('i').css('display','none');
        if($.trim($('#'+id).val())==''){
            $('#'+id).parent().children('i').css('display','');
            return false;
        }else{return true;}
    },
    activaMenu:function(id){$('#'+id).addClass('active');
    },
    activaPanel:function(idList,idPanel){
        $("#secc-izq li[id^='list']").removeClass('active');
        $("#secc-izq #"+idList).addClass('active');
        $("#secc-der div[id^='panel']").css('display','none');
        $("#secc-der #"+idPanel).fadeIn(300);
    },
    armaLink:function(){window.location.href='vst-'+this.id.substring(4)+'.php';
    },
    slide:function(id){$("#"+id).slideToggle('slow');
    },
    ocultaMsj:function(id,tiempo){setTimeout("sistema.slide('"+id+"')",tiempo);
    },
    msjOk:function(msj,time){if(time==undefined){time=2500};$('#capaMensaje').css('display','none');$('#capaMensaje').html(templates.msjOk(msj));sistema.slide('capaMensaje');sistema.ocultaMsj('capaMensaje',time);
    },
    msjAdvertencia:function(msj,time){if(time==undefined){time=2500};$('#capaMensaje').css('display','none');$('#capaMensaje').html(templates.msjAdvertencia(msj));sistema.slide('capaMensaje');sistema.ocultaMsj('capaMensaje',time);
    },
    msjAdvertenciaCerrar:function(msg){$('#capaMensaje').css('display','none');$('#capaMensaje').html(templates.msjAdvertenciaCerrar(msg));sistema.slide('capaMensaje');
    },
    msjError:function(msj,time){if(time==undefined){time=2500};$('#capaMensaje').css('display','none');$('#capaMensaje').html(templates.msjError(msj));sistema.slide('capaMensaje');sistema.ocultaMsj('capaMensaje',time);
    },
    msjErrorCerrar:function(msg){$('#capaMensaje').css('display','none');$('#capaMensaje').html(templates.msjErrorCerrar(msg));sistema.slide('capaMensaje');
    },
	lpad : function(id,padString, length) {    
		while ($("#"+id).val().length < length){
			$("#"+id).val(padString + $("#"+id).val());
		}
    
	},
    validaDni:function(e,id){ 
        tecla = (document.all) ? e.keyCode : e.which;//captura evento teclado
        if (tecla==8 || tecla==0) return true;//8 barra, 0 flechas desplaz
        if($('#'+id).val().length==8)return false;
        patron = /\d/; // Solo acepta números
        te = String.fromCharCode(tecla); 
        return patron.test(te);
    },
    validaLetras:function(e) { // 1
        tecla = (document.all) ? e.keyCode : e.which; // 2
        if (tecla==8 || tecla==0) return true;//8 barra, 0 flechas desplaz
        patron =/[A-Za-zñÑáéíóúÁÉÍÓÚ\s]/; // 4 ,\s espacio en blanco, patron = /\d/; // Solo acepta números, patron = /\w/; // Acepta números y letras, patron = /\D/; // No acepta números, patron =/[A-Za-z\s]/; //sin ñÑ
        te = String.fromCharCode(tecla); // 5
        return patron.test(te); // 6
    },
	validaAlfanumerico:function(e) { // 1
        tecla = (document.all) ? e.keyCode : e.which; // 2
        if (tecla==8 || tecla==0 || tecla==46) return true;//8 barra, 0 flechas desplaz
        patron =/[A-Za-zñÑáéíóúÁÉÍÓÚ@.,_\-\s\d]/; // 4 ,\s espacio en blanco, patron = /\d/; // Solo acepta números, patron = /\w/; // Acepta números y letras, patron = /\D/; // No acepta números, patron =/[A-Za-z\s]/; //sin ñÑ
        te = String.fromCharCode(tecla); // 5
        return patron.test(te); // 6
    },
    validaNumeros:function(e) { // 1
        tecla = (document.all) ? e.keyCode : e.which; // 2
        if (tecla==8 || tecla==0 || tecla==46) return true;//8 barra, 0 flechas desplaz
        patron = /\d/; // Solo acepta números
        te = String.fromCharCode(tecla); // 5
        return patron.test(te); // 6
    },
    getFechaActual:function(formato){//recibe yyyy/mm/dd, dd/mm/yyyy, yyyy-mm-dd
        var currentTime = new Date(); 
        var month = parseInt(currentTime.getMonth() + 1);month = month <= 9 ? "0"+month : month; 
        var day = currentTime.getDate();day = day <= 9 ? "0"+day : day; 
        var year = currentTime.getFullYear(); 
        switch(formato){
            case 'dd/mm/yyyy':
                return day+"/"+month+"/"+year; 
            break;
            case 'yyyy/mm/dd':
                return year+"/"+month+"/"+day; 
            break;
            case 'yyyy-mm-dd':
                return year+"-"+month + "-"+day;
            break;
            default:return year+"-"+month + "-"+day;
        }        
    },
	mostrar_cerrar_buscar:function(id,id_icon){
		/*var ico=$('#'+id_icon).attr('class');
		if(ico=="icon_content icon_lupa1"){
			$('#'+id_icon).removeClass('icon_lupa1').addClass('icon_cerrar2');
		}else{
			$('#'+id_icon).removeClass('icon_cerrar2').addClass('icon_lupa1');
		}*/
		
		var display=$('#'+id).css('display');
		if(display=='none'){
			$('#'+id).css('display','block');
		}else{
			$('#'+id).css('display','none')
		}
	},
	checkall:function(ids,id){
		sistema.msjOk('Listando todos',2000);
		$("#"+ids+' tr').map(function(index, element) {
			if($("#"+id).attr("checked") && $('#'+element.id).css('display')!="none"){
			$('#chk-'+element.id.split("-")[1]).attr('checked',"checked");
			}
			else{
			$('#chk-'+element.id.split("-")[1]).removeAttr('checked');
			}
			$('#'+element.id).css('display','');
		});
	},
	buscarEnTable: function ( xtext, xidtable ) {
		var text = xtext;
		text = text.toUpperCase();
		$('#'+xidtable).find('tr').css('display','none');
		//$('#'+xidtable+' tr').find('td:contains("'+text+'")').parent().css('display','block'); //altera el css
		$('#'+xidtable+' tr').find('td:contains("'+text+'")').parent().attr('style', ''); // NO altera el css, usar siempre y cuando no halla "style"
	},
	selectorClass: function (id,grupo){
		$('#'+grupo+' tr').removeClass('ui-state-highlight');
		$('#'+id).addClass('ui-state-highlight');
	},
	mouseOver:function(id){
		$('#'+id).addClass('ui-state-hover');
	},
	mouseOut:function(id){
		$('#'+id).removeClass('ui-state-hover');
	},
	validaFecha:function(val1,val2){
		if($("#"+val1).val() && $("#"+val2).val() && $("#"+val1).val()>$("#"+val2).val()){
		sistema.msjAdvertencia("Fecha Final:<b>"+$("#"+val2).val()+"</b> no puede ser menor a Fecha Inicial:<b>"+$("#"+val1).val()+"</b>",3000);
		$("#"+val2).val('');		
		}
	},
	validaNumeroMayor:function(val1,val2){
		if($("#"+val1).val() && $("#"+val2).val() && $("#"+val1).val()*1<$("#"+val2).val()*1){
		sistema.msjAdvertencia("<b>"+$("#"+val2).val()+"</b> no puede ser mayor a <b>"+$("#"+val1).val()+"</b>",3000);
		$("#"+val2).val('');
		$("#"+val2).focus();
		}
	}
};

$.fn.navDesplegable = function(){
    this
    .hover(
        function(){
            //$(this).find('ul').css('display','block')
        }, 
        function(){
            $(this).children('ul').css('display','none')
        }
    )
    .click(
        function(){
            var d=$(this).children('ul').css('display');
            if(d=='none'){
                $(this).children('ul').css('display','block');
            }else{
                $(this).children('ul').css('display','none');
            }
        }
    );
}
$.fn.ocultaSeccIzq=function(){
    this
    .click(
        function(){
            //var display=$('#secc-izq').css('width');
            displayx=($('#secc-izq').css('width')).substring(0,1);
            //if(display>='150px'){
            if(displayx>0){  
                $('#secc-izq ul').css('display','none');
                $('#secc-izq').animate({width: '-=150'},150);
                $("#secc-divi").removeClass('secc-divi-izq').addClass('secc-divi-der');
                $("#secc-divi i").removeClass('icon-izq').addClass('icon-der');
            }else{
                $('#secc-izq').animate({width: '+=150'},150);
                $('#secc-izq ul').css('display','block');
                $("#secc-divi").removeClass('secc-divi-der').addClass('secc-divi-izq');
                $("#secc-divi i").removeClass('icon-der').addClass('icon-izq');
            }
        }    
    );
};
$.fn.selectorTemas = function(){
    var options = {
        TextoInicial: 'Temas',
        Ancho: 300,
        Alto: 280,
        idContenedor: 'GaleriaTemas',
        ClassPanelTemas: 'fondo_2',
        ClassBarraTitulo: 'corner_all txt_temaM bar_2',
        ClassListaTemas: 'corner_all',
        styleTema: 'float: left; margin: 10px; border: 1px solid #DDDDDD; padding: 2px 2px 2px 2px;',
        ClassTema: 'brillohv',
        idLinkCss: 'estilo',
        ClassBoton: 'btn btn-azul sombra-3d t-blanco',
        ColorBoton: '#454545'
        //OnGuardar: buscar 'PanelTemas.find('input').click' en EVENTOS y agregar cod
    };
    /*****COMPONENTES******/
    var PanelTemas= 
            $('<div title="Galeria de Temas" class="'+options.ClassPanelTemas+'" id="'+options.idContenedor+'" align="center">\n\
                    <div class="'+options.ClassListaTemas+'" style="background: #ffffff;height:100%;">\n\
                        <div style="margin:7px;float:left;width:95%;height:'+(options.Alto-80)+'px;overflow-x:hidden;overflow-y:auto;">\n\
                            <div onclick="cambiatema(\'default\');" class="'+options.ClassTema+'" style="'+options.styleTema+'"><div style="height:70px;width:90px;background:#0070CE"></div></div>\n\
                            <div onclick="cambiatema(\'naranja\')" class="'+options.ClassTema+'" style="'+options.styleTema+'"><div style="height:70px;width:90px;background:#D66F08"></div></div>\n\
                            <div  onclick="cambiatema(\'verde\')" class="'+options.ClassTema+'" style="'+options.styleTema+'"><div style="height:70px;width:90px;background:#095909"></div></div>\n\
                            <div onclick="cambiatema(\'rosa\');" class="'+options.ClassTema+'" style="'+options.styleTema+'"><div style="height:70px;width:90px;background:#C74AE1"></div></div>\n\
                            <div onclick="cambiatema(\'gris\');" class="'+options.ClassTema+'" style="'+options.styleTema+'"><div style="height:70px;width:90px;background:#808080"></div></div>\n\
                        </div>\n\
                        <div style="padding: 10px; bottom: 0px; position: absolute; right: 0px;">\n\
                            <input id="btnGuardarTemaSelector" class="'+options.ClassBoton+'" type="button" value="ACEPTAR"/>\n\
                            <input class="'+options.ClassBoton+'" type="button" value="CANCELAR" onclick="$(\'#'+options.idContenedor+'\').dialog(\'close\');"/>\n\
                        </div>\n\
                    </div>\n\
               </div>');
    /*****CSS******/
    PanelTemas.css({
        //position:'absolute',
        //left: $(window).width()/2-options.Ancho/2,
        //top: $(window).height()/2.5-options.Alto/2,
        //width:options.Ancho,
        //height:options.Alto,
        fontFamily: 'tahoma,arial,geneva,verdana,sans',
        fontSize: '11px'
    });
    /*********EVENTOS*************/
    PanelTemas.find('#btnGuardarTemaSelector').click(function(){
        sistema.guardarTema();
    });
    /*****IMPRESION*******/
    $(this).click(function(){
        $('#'+options.idContenedor).dialog('open');
    });
    $('body').append(PanelTemas);
}

cambiatema=function(tema){
    var cssLink = $('<link href="../css/temas/'+tema+'/css-sistema.php" type="text/css" rel="Stylesheet" class="ui-theme" />');
    $("head").append(cssLink);
    if($("link.ui-theme").size() > 1){
        $("link.ui-theme:first").remove();
    }
    $('#hd_idTemaSession').val(tema);//opcional, para guardar nuevo tema es necesario
}



