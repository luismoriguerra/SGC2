$(document).ready(function(){
	
	$('#nav-mantenimientos').addClass('active');//aplica estilo al menu activo		    
	$('#btn_Generar').click(function(){Generar()});	
	institucionDAO.cargarFilialValidadaG(sistema.llenaSelectGrupo,'slct_filial','','Filial');
	institucionDAO.cargarInstitucionValidaG(sistema.llenaSelectGrupo,'slct_instituto','','Instituto');
    institucionDAO.cargarCuentas(sistema.llenaSelect,'slct_cuenta','');
	$("#slct_filial").multiselect({
   	selectedList: 4 // 0-based index
	}).multiselectfilter();
	$("#slct_instituto").multiselect({
   	selectedList: 4 // 0-based index
	}).multiselectfilter();        
})

verificaNombre=function(){
	institucionDAO.verificaNombre();
}

VisualizaAsignacion=function(){
    $("#cfilial").val('');
    $("#cinstit").val('');
    institucionDAO.cargarFilIns();

    $("#slct_filial").html('');
    institucionDAO.cargarFilialG(sistema.llenaSelectGrupo,'slct_filial',$("#cfilial").val().split("|"),'Filial');
    $("#slct_filial").multiselect({
    selectedList: 4, // 0-based index       
    }).multiselectfilter();
    

    $("#slct_instituto").html('');
    institucionDAO.cargarInstitucionG(sistema.llenaSelectGrupo,'slct_instituto',$("#cinstit").val().split("|"),'Institucion');
    $("#slct_instituto").multiselect({
    selectedList: 4, // 0-based index       
    }).multiselectfilter();
    
}

muestrafilins=function(a,b){
}


Generar=function(){
	if($("#slct_filial").val()==null){
	sistema.msjAdvertencia('Seleccione Filial',2000);
	}
	else if($("#slct_instituto").val()==null){
	sistema.msjAdvertencia('Seleccione Instituto',2000);
	}
	else if($("#slct_cuenta").val()==''){
	sistema.msjAdvertencia('Seleccione Cuenta de Banco',2000);
	}
	else{
    institucionDAO.GenerarAsignacion();	
	}
}

