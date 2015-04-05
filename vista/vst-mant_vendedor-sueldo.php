<?require_once('ifrm-valida-sesion.php')?>
<!DOCTYPE html>
<html ng-app="myApp">
<head>

    <title>SGC2 | Mantenimiento Vendedor Sueldos</title>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
    <link rel="shortcut icon" href="../images/favicon.ico">

    <link data-require="bootstrap-css@*" data-semver="3.2.0" rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="../css/temas/default/css-sistema.php">
    <link type="text/css" rel="stylesheet" media="screen" href="../javascript/includes/jqgrid-4.3.2/css/ui.jqgrid.css" />

    <script type="text/javascript" src="../javascript/includes/jquery-1.7.2.min.js"></script>
    <script type="text/javascript" src="../javascript/includes/jquery-ui-1.8.18.custom.min.js"></script>
    <script type="text/javascript" src="../javascript/includes/jqgrid-4.3.2/js/i18n/grid.locale-es.js" ></script>
    <script type="text/javascript" src="../javascript/includes/jqgrid-4.3.2/js/jquery.jqGrid.min.js" ></script>
    <script type="text/javascript" src="../javascript/includes/angular.min.js" ></script>
    <!--    <script data-require="angular.js@*" data-semver="1.3.1" src="//code.angularjs.org/1.3.1/angular.js"></script>-->
    <script data-require="ui-bootstrap@*" data-semver="0.11.0" src="http://angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.11.0.min.js"></script>

    <script src="../javascript/includes/gm.datepickerMultiSelect.js"></script>
    <script type="text/javascript" src="../javascript/sistema.js"></script>
    <script type="text/javascript" src="../javascript/templates.js"></script>
    <script type="text/javascript" src="../javascript/dao/DAOubigeo.js"></script>
    <script type="text/javascript" src="../javascript/jqGrid/JqGridMantVendedor.js"></script>
    <script type="text/javascript" src="../javascript/dao/DAOpersona.js"></script>
    <script type="text/javascript" src="../javascript/js/js-persona.js"></script>
    <script type="text/javascript" src="../javascript/js/js-persona2.js"></script>
    <style>
        a:hover,a {
            color: #fff;
        }
    </style>
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
                <li id="list_matricula" onclick="sistema.activaPanel('list_matricula','panel_matricula')" class="active"><span><i class="icon-gray icon-list-alt"></i> Vendedor <? /*aquui va el menu q se carga en la izquierda*/ ?> </span></li>
            </ul>
        </div>
        <div id="secc-divi" class="secc-divi secc-divi-izq"><i class="icon-white icon-der"></i></div>
        <div class="secc-der" id="secc-der" ng-controller="angularController">

            <div id="panel_matricula" style="display:block">
                <div class="barra1"><i class="icon-gray icon-list-alt"></i> <b>Mantenimiento Vendedor(es) Sueldo <? /*aqui va el titulo q presentara  */ ?></b></div>
                <div class="cont-der" style="text-align: center">
                    <? /*
                            	aqui va todo tu diseño ... dentro de cont-der 
                            */
                    ?>
                    <table align="center">
                        <tr>
                            <td class="ui-state-default">Seleccione:
                            </td>
                            <td>
                                <select id="slct_vendedor"
                                        name="slct_vendedor"
                                        ng-model="slctVendedor"
                                        ng-change="actualizarLista()">
                                </select>
                            </td>
                        </tr>
                    </table>
                    <br>
                    <br>
                    <div ng-show="cargando"
                         style="width: 50%; margin: 0 auto;">
                        Cargando listado...
                    </div>
                    <div ng-show="noResultados"
                         style="width: 50%; margin: 0 auto;">
                        No se encontraron vendedores que mostrar en esta categoria.
                    </div>
                    <div class="Listado-vendedores"
                         style="width: 50%; margin: 0 auto;"
                         ng-show="vendedores.length">
                        <div>
                            <div style="text-align: left; display: inline-block; float: left;">
                                Agregar a todos :
                                <input type="number"
                                       ng-model="sueldoComun"
                                       placeholder="Monto"/>
                                <button ng-click="actualizarTodosLosSueldos()">Asignar a todos</button>
                            </div>
                            <div style="text-align: right; display: inline-block;">
                                <button ng-click="guardarTodos()"> Guardar Todos </button>
                            </div>
                        </div>

                        <div style="text-align: left; clear: both;">
                            Buscar Vendedor :
                            <input type="text" ng-model="searchText"/>
                            <button ng-click="searchText = ''">Limpiar</button>
                        </div>

                        <table style="display: inline-block">
                            <tr>
                                <th>Nro</th>
                                <th>Vendedor</th>
                                <th>Sueldo</th>
                                <th>Faltas</th>
                            </tr>
                            <tr ng-repeat="vendedor in vendedores | filter : searchText">
                                <td>{{$index + 1}}</td>
                                <td>{{vendedor.nombre}}</td>
                                <td>
                                    <input type="number"
                                           ng-model="vendedor.sueldo"
                                           placeholder="0"/>
                                </td>
                                <td>
                                    <a href="#"
                                       ng-click="diasFaltantes(vendedor)">
                                        <button type="button"
                                                class="btn btn-default"
                                                ng-click="open($event,vendedor)">
                                            <i class="glyphicon glyphicon-calendar"></i>
                                        </button>
                                    </a>({{vendedor.selectedDates.length}})
                                    <div id="ff-{{vendedor.id}}"
                                         style="display: none;">
                                       <table>
                                           <tr>
                                               <td>
                                                   <datepicker ng-model='vendedor.activeDate'
                                                               multi-select='vendedor.selectedDates'
                                                               select-range="false">
                                                   </datepicker>
                                               </td>
                                               <td style="vertical-align: top;">
                                                   <div>
                                                        Total de dias: ({{vendedor.selectedDates.length}})
                                                       <div class='well well-sm'
                                                            style="height: 180px; overflow: scroll; margin-left: 20px">
                                                           <div ng-repeat='d in vendedor.selectedDates | orderBy : vendedor.identity'>
                                                               {{d | date : 'mediumDate'}}
                                                               <button class='btn btn-xs btn-warning'
                                                                       style="margin: 3px"
                                                                       ng-click='removeFromSelected(vendedor, d)'>
                                                                   X
                                                               </button>
                                                           </div>
                                                       </div>
                                                   </div>
                                               </td>
                                           </tr>
                                       </table>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
<!--                    fin listado vendedores-->
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
