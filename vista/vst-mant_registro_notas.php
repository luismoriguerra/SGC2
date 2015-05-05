<?require_once('ifrm-valida-sesion.php')?>
<!DOCTYPE html>
<html>
<head>

    <title>Telesup | Registro de Notas de los Postulantes</title>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
    <link rel="shortcut icon" href="../images/favicon.ico">

    <link rel="stylesheet" type="text/css" href="../css/temas/default/css-sistema.php">
    <link type="text/css" rel="stylesheet" media="screen" href="../javascript/includes/jqgrid-4.3.2/css/ui.jqgrid.css" />
    <link type="text/css" rel="stylesheet" media="screen" href="../javascript/includes/multiselect/css/jquery.multiselect.css" />
    <link type="text/css" rel="stylesheet" media="screen" href="../javascript/includes/multiselect/css/jquery.multiselect.filter.css" />

    <script type="text/javascript" src="../javascript/includes/angular.min.js" ></script>
    <script type="text/javascript" src="../javascript/includes/jquery-1.7.2.min.js"></script>
    <script type="text/javascript" src="../javascript/includes/jquery-ui-1.8.18.custom.min.js"></script>
    <script type="text/javascript" src="../javascript/includes/jqgrid-4.3.2/js/i18n/grid.locale-es.js" ></script>
    <script type="text/javascript" src="../javascript/includes/jqgrid-4.3.2/js/jquery.jqGrid.min.js" ></script>

    <script type="text/javascript" src="../javascript/sistema.js"></script>
    <script type="text/javascript" src="../javascript/templates.js"></script>

    <script type="text/javascript" src="../javascript/includes/multiselect/js/jquery.multiselect.filter.min.js"></script>
    <script type="text/javascript" src="../javascript/includes/multiselect/js/jquery.multiselect.min.js"></script>

    <script type="text/javascript" src="../javascript/dao/DAOcarrera.js"></script>
    <script type="text/javascript" src="../javascript/dao/DAOgrupoAcademico.js"></script>
    <script type="text/javascript" src="../javascript/dao/DAOinstitucion.js"></script>
    <script type="text/javascript" src="../javascript/js/js-registro_notas.js"></script>

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
<!--                <li id="list_matricula" onclick="sistema.activaPanel('list_matricula','panel_matricula')" class="active"><span><i class="icon-gray icon-list-alt"></i> Ranking --><?// /*aquui va el menu q se carga en la izquierda*/ ?><!-- </span></li>-->
            </ul>
        </div>
        <div id="secc-divi" class="secc-divi secc-divi-izq"><i class="icon-white icon-der"></i></div>
        <div class="secc-der" id="secc-der"ng-app="myApp">

            <div id="panel_matricula" style="display:block" ng-controller="angularController">
                <div class="barra1"><i class="icon-gray icon-list-alt"></i> <b>REGISTRO DEL PUNTAJE DE LOS POSTULANTES <?   /*aqui va el titulo q presentara  */ ?></b></div>
                <div class="cont-der">
                    <div class="t-center">
                        <div class="barra4 contentBarra t-blanco t-left"><i class="icon-white icon-th"></i>FILTROS</div>

                        <!--Inicio tabla-->
                        <table style="width:90%">
                            <tr>
                                <td class="t-left label">Filial:</td>
                                <td class="t-left">
                                    <select id="slct_filial" class="input-xlarge" style="width: 370px; display: none;" multiple>
                                        <optgroup label="Filial">
                                            <option value="">--Selecione--</option>
                                        </optgroup>
                                    </select>
                                </td>
                                <td class="t-left label">Institución:</td>
                                <td class="t-left">
                                    <select id="slct_instituto" class="input-xlarge" style="width: 370px; display: none;" multiple>
                                        <optgroup label="Instituto">
                                            <option value="">--Selecione--</option>
                                        </optgroup>
                                    </select>
                                </td>
                            </tr>

                            <tr>
                                <td class="t-left label input-large">Fechas de Inicio de Grupos:</td>
                                <td class="t-left">
                                    Del:
                                    <input type="text" id="txt_fecha_inicio" class="input-medium" value="">
                                    Al
                                    <input type="text" id="txt_fecha_fin" class="input-medium" value="">
                                </td>
                            </tr>
                        </table>
                        <!--fin talba-->
                        <br>
                        <div>
                                    <span style="margin:15px 0px 10px 0px;">
                                        <a ng-click="cargarPostulantes()"
                                           id="btn_listar" class="btn btn-azul sombra-3d t-blanco">
                                            <i class="icon-white icon-th"></i>
                                            <span>Listar</span>
                                        </a>
                                    </span>
                        </div>
                        <br>
                        <div ng-show="noResultados &&  $scope.busquedaActivada" style="text-align: center">
                            No se encontraron postulantes
                        </div>
                        <div ng-show="!noResultados" style="text-align: left">
                            <span> Nro de Postulantes: {{postulantes.length}}</span>
                            <div style="text-align: left; clear: both;">
                                Buscar Postulante :
                                <input type="text" ng-model="searchText"/>
                                <button ng-click="searchText = ''">Limpiar</button>

                                <button style="text-align: right; margin-left: 100px;" ng-click="GuardarPuntajePostulantes()">:: Guardar Puntajes :: </button>

                            </div>
                        </div>
                        <div id="v_lista_grupo" ng-hide="noResultados">
                            <div class="corner_top" style="text-align: center">
                                <table>
                                    <tr class="" align="center">
                                        <td class="t-center label" width="10">N</td>
                                        <td class="t-center label" width="200">Carrera</td>
                                        <td class="t-center label" width="200">Nombre</td>
                                        <td class="t-center label" width="70">Puntaje Obtenido</td>
                                        <td class="t-center label" width="150">Puntaje Mínimo</td>
                                        <td class="t-center label" width="150">Estado</td>
                                    </tr>
                                    <tr ng-repeat="pos in postulantes | filter : searchText">
                                        <td>{{$index + 1}}</td>
                                        <td style="text-align: left">{{pos.carrera}}</td>
                                        <td style="text-align: left">{{pos.nombre}}</td>
                                        <td>
                                            <input type="text"
                                                   ng-model="pos.nota"
                                                   ng-change="actualizarPostulante(pos)"/>
                                        </td>
                                        <td>
                                            {{pos.minima}}
                                        </td>
                                        <td>
                                            {{pos.estado}}
                                        </td>
                                    </tr>
                                </table>
                            </div>

                        </div><!--fin listado de grupos-->
                        <br>
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
