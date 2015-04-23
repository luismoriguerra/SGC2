<?require_once('ifrm-valida-sesion.php')?>  
<!DOCTYPE html>
<html>
    <head>

        <title>SGC2</title>
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

        <script type="text/javascript" src="../javascript/sistema.js"></script>
        <script type="text/javascript" src="../javascript/templates.js"></script>
        
        <script type="text/javascript" src="../javascript/includes/multiselect/js/jquery.multiselect.filter.min.js"></script>
        <script type="text/javascript" src="../javascript/includes/multiselect/js/jquery.multiselect.min.js"></script>
        
        <script type="text/javascript" src="../javascript/js/js-r_consolidado_vendedor.js"></script>
            
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
                        <li id="list_matricula" onclick="sistema.activaPanel('list_matricula','panel_matricula')" class="active"><span><i class="icon-gray icon-list-alt"></i> Indice Matricula <? /*aquui va el menu q se carga en la izquierda*/ ?> </span></li>                      
                    </ul>
                </div>
                <div id="secc-divi" class="secc-divi secc-divi-izq"><i class="icon-white icon-der"></i></div>
                <div class="secc-der" id="secc-der">
                    
                    <div id="panel_matricula" style="display:block">
                        <div class="barra1"><i class="icon-gray icon-list-alt"></i> <b>Reporte Consolidado Vendedores <?   /*aqui va el titulo q presentara  */ ?></b></div>         
                        <div class="cont-der">
                            <div class="t-center">
                                <div class="barra4 contentBarra t-blanco t-left"><i class="icon-white icon-th"></i>FILTROS</div>
                       
                                <!--Inicio tabla-->
                                <table style="width:90%">
                                        <tr>
                                            <td class="t-left label input-large">Fecha Matrícula:</td>
                                            <td class="t-left">
                                            <input type="text" id="txt_fecha_matric" class="input-medium" value="">
                                            </td>
                                       </tr>                                       
                                       <!--tr>
                                            <td class="t-left label input-large">Pago Mensual:</td>
                                            <td class="t-left">
                                            <input type="text" id="txt_pago_mensual" class="input-medium" value="">
                                            </td>
                                       </tr-->    
                                    </table>
                                <!--fin talba-->                                
                                <br>
                                <div style="margin:15px 0px 10px 0px;">
                                    <!--<a id="btn_mostar" class="btn btn-azul sombra-3d t-blanco" href="javascript:void(0)" style="margin-right: 10px">
                                        <i class="icon-white  icon-eye-open"></i>
                                        <span>Mostrar</span>
                                    </a>-->
                                    <a id="btn_exportar" class="btn btn-azul sombra-3d t-blanco" href="javascript:void(0)">
                                        <i class="icon-white icon-download"></i>
                                        <span>Exportar</span>
                                    </a>
                                </div>                                
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
