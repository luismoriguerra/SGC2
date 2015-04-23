<?require_once('ifrm-valida-sesion.php')?>	
<!DOCTYPE html>
<html>
	<head>

		<title>Telesup</title>
		<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
		<link rel="shortcut icon" href="../images/favicon.ico">

		<link rel="stylesheet" type="text/css" href="../css/temas/default/css-sistema.php">
		<link type="text/css" rel="stylesheet" media="screen" href="../javascript/includes/jqgrid-4.3.2/css/ui.jqgrid.css" />
        <link type="text/css" rel="stylesheet" media="screen" href="../javascript/includes/multiselect/css/jquery.multiselect.css" />
        <link type="text/css" rel="stylesheet" media="screen" href="../javascript/includes/multiselect/css/jquery.multiselect.filter.css" />

		<script type="text/javascript" src="../javascript/includes/jquery-1.7.2.min.js"></script>
		<script type="text/javascript" src="../javascript/includes/jquery-ui-1.8.18.custom.min.js"></script>
        <script type="text/javascript" src="../javascript/includes/jqgrid-4.3.2/js/i18n/grid.locale-es.js" ></script>
        <script type="text/javascript" src="../javascript/includes/jqgrid-4.3.2/js/jquery.jqGrid.min.js" ></script>

		
		
       
        <script type="text/javascript" src="../javascript/includes/multiselect/js/jquery.multiselect.filter.min.js"></script>
        <script type="text/javascript" src="../javascript/includes/multiselect/js/jquery.multiselect.min.js"></script>
        <script type="text/javascript" src="../javascript/sistema.js"></script>
	<script type="text/javascript" src="../javascript/templates.js"></script>
        
	<script type="text/javascript" src="../javascript/dao/DAOcarrera.js"></script>
        <script type="text/javascript" src="../javascript/dao/DAOgrupoAcademico.js"></script>
        <script type="text/javascript" src="../javascript/dao/DAOinstitucion.js"></script>
        <script type="text/javascript" src="../javascript/js/js-contador_pago.js"></script>
			
	</head>

	<body>
		<div id="capaOscura" class="capaOscura" style="display:none"></div>
		<div id="capaCargando" class="capaCargando" style="display:none"><div class="girando"><div class="estrella"></div></div></div>
		<?require_once('ifrm-header.php')?>	
		<?require_once('ifrm-nav.php')?>	
        <div class="contenido">
			<div class="cuerpo">
				<div class="secc-izq" id="secc-izq" style="width:0px;">
					<ul class="lca" style="display:none">
						<li id="list_matricula" onclick="sistema.activaPanel('list_matricula','panel_matricula')" class="active"><span><i class="icon-gray icon-list-alt"></i> Ranking <? /*aquui va el menu q se carga en la izquierda*/ ?> </span></li>						
					</ul>
				</div>
				<div id="secc-divi" class="secc-divi secc-divi-izq"><i class="icon-white icon-der"></i></div>
				<div class="secc-der" id="secc-der">
                    
                    <div id="panel_matricula" style="display:block">
                        <div class="barra1"><i class="icon-gray icon-list-alt"></i> <b>Reporte de Totales de Pagantes y Deudores <?   /*aqui va el titulo q presentara  */ ?></b></div>         
                        <div class="cont-der">
			<div class="t-center">
                                <div class="barra4 contentBarra t-blanco t-left"><i class="icon-white icon-th"></i>FILTROS</div>
                       
                                <!--Inicio tabla-->
                                <table style="width:90%">
                                        <tr>
                                            
                                            <!--<td class="t-left label">Filial:</td>
                                            <td class="t-left">
                                                <select id="slct_filial" class="input-xlarge" style="width: 370px; display: none;" multiple>
                                                	<optgroup label="Filial">
                                                		<option value="">--Selecione--</option>
                                                    </optgroup>
                                                </select>
                                            </td> -->
                                            
<!--                                            <td class="t-left label">Tipo Carrera:</td>
                                            <td>
                                                <select id="slct_tipo_carrera" class="input-medium"><option value="">--Selecione--</option></select>
                                            </td>                                        
                                            <td class="t-left label">Modalidad:</td>
                                            <td>
                                                <select id="slct_modalidad" class="input-medium"><option value="">--Selecione--</option></select>
                                            </td>-->
                                            <td class="t-left label">Carrera:</td>
                                            <td>
                                                <select id="slct_carrera" class="input-medium"><option value="">--Selecione--</option></select>
                                            </td>
                                            <td class="t-left label">Semestre:</td>
                                            <td>
                                                <select id="slct_semestre" class="input-medium"><option value="">--Selecione--</option></select>
                                            </td>
<!--                                            <td class="t-left label">Ciclo:</td>
                                            <td>
                                                <select id="cciclo" class="input-medium"><option value="">--Selecione--</option></select>
                                            </td>-->
                                            <td class="t-left label">Inicio:</td>
                                            <td>
                                                <select id="slct_inicio" class="input-medium"><option value="">--Selecione--</option></select>
                                            </td>                                            
                                        </tr>
<!--                                        <tr>
                                        	<td class="t-left label">Horario:</td>
                                            <td>
                                                <select id="slct_horario" class="input-medium"><option value="">--Selecione--</option></select>
                                            </td>                                            
                                        </tr>-->
                                    </table>
                                <!--fin talba--> 
                                
                             	</div>
                            </div>
                            
							<div class="formBotones">
                                <a href="javascript:void(0)" onClick="Exportar();" class="btn btn-azul sombra-3d t-blanco">
                                <i class="icon-white icon-download-alt"></i>
                                <span>Exportar</span>
                                </a>
                            </div>  
                                
                                
                        </div>
    				</div>

            	</div>
			</div>
		</div>
        <div id="capaMensaje" class="capaMensaje" style="display:none"></div>		
		<hr>
		<?require_once('ifrm-footer.php')?>	
	</body>
</html>
