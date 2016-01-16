

    <style>
        
        body {
            font-size: 0.75em;
        }

      .row div{
            box-sizing: border-box;
            /*border: 1px solid #ccc;*/
            /*background: rgba(204, 146, 182, 0.30);*/
            /*min-height: 1.5em;*/
        }
        .bordeado {
            border: 1px solid #ccc;
        }
        .top {
            border-top: 1px solid #ccc;
        }
        .left {
            border-left: 1px solid #ccc;
        }
        .right {
            border-right: 1px solid #ccc;
        }
        .bottom {
            border-bottom: 1px solid #ccc;
        }

        .h1 , .h2, .h3, .h4, .h5, .h6, .table {
            margin: 0;
        }
        .row   {

        }

        .oscuro {
            color: #fff;
            background: rgba(0, 0, 0, 0.61);
        }
        .plomo {
            background: #e8e8e8;
        }



        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }




        .col-sm-2 {
            width: 15.5%;
            display: inline-block;
        }
        .col-sm-3 {
            width: 24.5%;
            display: inline-block;
        }
      .col-sm-4 {
          width: 33.5%;
          display: inline-block;
      }

      .col-sm-5 {
          width: 40.5%;
          display: inline-block;
      }
      .col-sm-6 {
          width: 49.5%;
          display: inline-block;
      }

      .col-sm-8 {
          width: 65.5%;
          display: inline-block;
      }
        .col-sm-9 {
            width: 74.5%;
            display: inline-block;
        }

    </style>

</head>
<body>
<div class="container left top right">
    <!--cabecera-->
    <div class="row bordeado">
        <div class="col-sm-8 right oscuro">
            <div class="row">
                <div class="col-sm-8 h3 text-center">FICHA DE INSCRIPCION A CARRERAS PROFESIONALES:</div>
                <div class="col-sm-4">TELESUP</div>
            </div>
        </div>
        <div class="col-sm-4 ">
            Fecha:{{fecha}}
        </div>
    </div>
    <!--parte 2 -->
    <div class="row">
        <div class="col-sm-6 small">PLANO DE UBICACION DEL DOMICILIO</div>
        <div class="col-sm-6">
            <div class="row bordeado">
                <div class="col-sm-10 col-sm-offset-2">
                    <div class="row">
                        <div class="col-sm-12 h2">SERIE: 001-</div>
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-sm-3 small">Ap Pat: </div>
                                <div class="col-sm-9 left top">{{paterno}}</div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3 small">Ap Mat: </div>
                                <div class="col-sm-9 left top">{{materno}}</div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3 small">Nombres: </div>
                                <div class="col-sm-9 left top bottom">{{nombres}}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-8 text-center">
                            <div class="row bordeado">{{centro_captacion}}</div>
                            <div class="row small">CENTRO DE CAPTACION</div>
                            <div class="row bordeado">{{oficina_enlace}}</div>
                            <div class="row small">OFICINA ENLACE</div>
                        </div>
                        <div class="col-sm-4">
                            <div class="row "></div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-3"><div class="row">CODIGO DEL LIBRO:</div> </div>
                        <div class="col-sm-9">
                            {{codlib}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--datos de posutlante-->

    <div class="row text-center oscuro left right">
        DATOS DEL POSTULANTE
    </div>
    <div class="row bottom text-center">
        <div class="col-sm-2 right">{{estado_civil}}</div>
        <div class="col-sm-4 right">{{documento}}</div>
        <div class="col-sm-4 right">{{fecha_nacimiento}}</div>
        <div class="col-sm-2">{{genero}}</div>
    </div>
    <div class="row text-center">
        <div class="col-sm-2">ESTADO CIVIL</div>
        <div class="col-sm-4">DOCUMENTO</div>
        <div class="col-sm-4"> FECHA DE NACIMIENTO</div>
        <div class="col-sm-2">GENERO</div>
    </div>
    <div class="row">
        <div class="col-sm-4 text-right plomo bottom" style="line-height: 3em;">LUGAR DE NACIMIENTO</div>
        <div class="col-sm-8 text-center ">
            <div class="row bottom top">
                <div class="col-sm-2 right">{{pais}}</div>
                <div class="col-sm-2 right">{{region}}</div>
                <div class="col-sm-2 right">{{provincia}}</div>
                <div class="col-sm-6 right">{{distrito}}</div>
            </div>
            <div class="row ">
                <div class="col-sm-2">PAIS</div>
                <div class="col-sm-2">REGION</div>
                <div class="col-sm-2">PROVINCIA</div>
                <div class="col-sm-6">DISTRITO</div>
            </div>
        </div>
    </div>
    <!--ubicacion de postulante-->
    <div class="row oscuro text-center">UBICACION DE POSTULANTE</div>
    <div class="row bottom">
        <div class="col-sm-6 right text-center">{{email}}</div>
        <div class="col-sm-2 right text-center">{{celular}}</div>
        <div class="col-sm-2 right text-center">{{telf_casa}}</div>
        <div class="col-sm-2">{{telf_trabajo}}</div>
    </div>
    <div class="row">
        <div class="col-sm-6 text-center">CORREO ELECTRONICO</div>
        <div class="col-sm-2 text-center">CELULAR</div>
        <div class="col-sm-2 text-center"> TELF CASA</div>
        <div class="col-sm-2 text-center">TELF TRABAJO</div>
    </div>
    <div class="row top">
        <div class="col-sm-5 text-center right">{{direccion}}</div>
        <div class="col-sm-5 text-center right">{{urb}}</div>
        <div class="col-sm-2 text-center">{{tenencia}}</div>
    </div>
    <div class="row top">
        <div class="col-sm-5 text-center">AV/JR/CALL/PJE/N/MZ/LTE/INT/DPTO</div>
        <div class="col-sm-5 text-center">URB/ASOC/COOP/PPJJ/AAHH</div>
        <div class="col-sm-2 text-center">TENENCIA</div>
    </div>
    <div class="row top">
        <div class="col-sm-2 text-center right">{{p_region}}</div>
        <div class="col-sm-2 text-center right">{{p_provincia}}</div>
        <div class="col-sm-2 text-center right">{{p_distrito}}</div>
        <div class="col-sm-3 text-center right">{{p_empresa}}</div>
        <div class="col-sm-3 text-center right">{{p_empresa_direcicon}}</div>
    </div>
    <div class="row top">
        <div class="col-sm-2 text-center">REGION</div>
        <div class="col-sm-2 text-center">PROVINCIA</div>
        <div class="col-sm-2 text-center">DISTRITO</div>
        <div class="col-sm-3 text-center">EMPRESA DONDE LABORA</div>
        <div class="col-sm-3 text-center">DIRECCION DE LA EMPRESA</div>
    </div>
    <!--datos de colegio-->
    <div class="row text-center oscuro">
        DATOS DE COLEGIO
    </div>
    <div class="row">
        <div class="col-sm-5 right bottom text-center">{{nombre_colegio}}</div>
        <div class="col-sm-5 right bottom text-center">{{c_ubicacion}}</div>
        <div class="col-sm-2">
            <div class="row">
                <div class="col-sm-10 col-sm-offset-2">
                    <div class="row">
                        <table class="table table-bordered">
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-5 text-center">NOMBRE DE COLEGIO</div>
        <div class="col-sm-5 text-center">REGION/PROVINCIA/DISTRITO</div>
        <div class="col-sm-2 text-right small">
            <div class="row">
                NAC. PART.PARR.FF.AA.FF.PP
            </div>
        </div>
    </div>
    <div class="row oscuro text-center">
        DATOS DE ADMISION
    </div>
    <div class="row">
        <div class="col-sm-6 bottom">
            <div class="row plomo text-center">DATOS DE LA CARRERA</div>
            <div class="row">
                <div class="col-sm-4 text-right">
                    <div class="row">CARRERA: </div>
                    <div class="row">SEMESTRE/INICIO: </div>
                    <div class="row">FECHA INICIO: </div>
                    <div class="row">MODALIDAD DE ESTUDIO: </div>
                    <div class="row">FRECUENCIA/HORARIO: </div>
                    <div class="row">LOCAL DE ESTUDIO: </div>
                </div>
                <div class="col-sm-8 right">
                    <div class="row bottom left text-center">{{carrera}}</div>
                    <div class="row bottom left text-center">{{semestre}}</div>
                    <div class="row bottom left text-center">{{fecha_inicio}}</div>
                    <div class="row bottom left text-center">{{modalidad}}</div>
                    <div class="row bottom left text-center">{{frecuencia}}</div>
                    <div class="row  left text-center">{{local_estudio}}</div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 bottom">
            <div class="row plomo text-center">MODALIDAD DE INGRESO</div>
            <div class="row">
                <div class="col-sm-4 text-right">ORDINARIO:</div>
                <div class="col-sm-1 left right text-center bottom">x</div>
                <div class="col-sm-6 text-right">CENTRO PRE-UNIVERSITARIO:</div>
                <div class="col-sm-1 left bottom text-center">x</div>
            </div>
            <div class="row">
                <div class="col-sm-4 text-right">TRASLADO EXTERNO:</div>
                <div class="col-sm-1 left right text-center bottom">x</div>
                <div class="col-sm-6 text-right">EXAMEN PREFERENTE:</div>
                <div class="col-sm-1 left  text-center bottom">x</div>
            </div>
            <div class="row">
                <div class="col-sm-4 text-right">CONVENIO:</div>
                <div class="col-sm-1 left right text-center ">x</div>
                <div class="col-sm-6 text-right"></div>
            </div>
            <div class="row">
                <div class="col-sm-4 text-right">OTRA MODALIDAD:</div>
                <div class="col-sm-8 left  text-center top bottom">x</div>
            </div>
            <div class="row plomo text-center">
                SOLO PARA MODALIDAD DE ESTUDIO PRESENCIAL
            </div>
            <div class="row">
                <div class="col-sm-8 text-center">POSTULA SOLO POR BECA</div>
                <div class="col-sm-4 text-center">SI / NO</div>
            </div>
        </div>
    </div>
    <div class="row text-center oscuro">
        DOCUMENTOS ACADEMICOS OBLIGATORIOS PARA EL PROCESO DE ADMISION
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="row">
                <div class="col-sm-2 text-right"><div class="row">CARRERA:</div></div>
                <div class="col-sm-4 bordeado">X</div>
                <div class="col-sm-2 text-right"><div class="row">PART. NAC.</div></div>
                <div class="col-sm-4 bordeado">X</div>
            </div>
            <div class="row">
                <div class="col-sm-2 text-right"><div class="row">FOT. DE DNI:</div></div>
                <div class="col-sm-4 text-center">SI/NO</div>
                <div class="col-sm-2 text-right"><div class="row">OTRO:</div></div>
                <div class="col-sm-4 left right bottom">X</div>
            </div>
        </div>
        <div class="col-sm-6 small">
            Declaro que entregaré mis documentos, requisito de la matrícula, para el ( / / ).
            De no cumplir perderé mi condición de alumno y no se me permitirá matricularme al siguiente semetres académico. <br>Firma:
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="row oscuro text-center">
                PAGOS REALIZADOS
            </div>
            <div class="row plomo bottom">
                <div class="col-sm-5 text-center right">CRITERIO</div>
                <div class="col-sm-2 text-center right">FECHA</div>
                <div class="col-sm-3 text-center right">SERIE-NRO DOC</div>
                <div class="col-sm-2 text-center right">MONTO</div>
            </div>
            <div class="row bottom">
                <div class="col-sm-5 text-center right">DERECHO DE INSCRIPCION</div>
                <div class="col-sm-2 text-center right">X</div>
                <div class="col-sm-3 text-center right">X</div>
                <div class="col-sm-2 text-center right">X</div>
            </div>
            <div class="row bottom">
                <div class="col-sm-5 text-center right">DERECHO DE MATRICULA</div>
                <div class="col-sm-2 text-center right">X</div>
                <div class="col-sm-3 text-center right">X</div>
                <div class="col-sm-2 text-center right">X</div>
            </div>
            <div class="row bottom">
                <div class="col-sm-2 text-center right">CUOTAS</div>
                <div class="col-sm-3 text-center right">DE</div>
                <div class="col-sm-2 text-center right">X</div>
                <div class="col-sm-3 text-center right">X</div>
                <div class="col-sm-2 text-center right">X</div>
            </div>
            <div class="row bottom">
                <div class="col-sm-5 text-center right">DERECHO DE CONVALID.:</div>
                <div class="col-sm-2 text-center right">X</div>
                <div class="col-sm-3 text-center right">X</div>
                <div class="col-sm-2 text-center right">X</div>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="row oscuro">DATOS PARA EL PROCESO DE CONVALIDACION</div>
            <div class="row">
                <div class="col-sm-12 bottom">PAIS DE PROCEDENCIA:</div>
                <div class="col-sm-12 bottom">TIPO DE INSTITUCION: UNIVERSIDAD / INSTITUCION</div>
                <div class="col-sm-12 bottom">NOMBRE DE LA INSTITUCION</div>
                <div class="col-sm-12 bottom">CARRERA DE PROCEDENCIA</div>
                <div class="col-sm-12 bottom">ULTIMO AÑO DE ESTUDIOS Y CICLO</div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6  text-center right">
            <div class="row plomo">PROMOCION ECONOMICA DE LA ADMISION</div>
            <div class="row bottom">x</div>
            <div class="row bottom">x</div>
        </div>
        <div class="col-sm-6  text-center">
            <div class="row plomo">DOCUM. CONVALIDACIÓN <span class="small">(Cert. de estudios, silabos de asignacion y otros)</span></div>
            <div class="row bottom">x</div>
            <div class="row bottom">x</div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 small">
            <div class="row">
                <div class="col-sm-3">RECEPCIONISTA: </div>
                <div class="col-sm-9 bottom">X</div>
            </div>
            <div class="row">
                <div class="col-sm-4">MEDIO DE CAPTACIÓN: </div>
                <div class="col-sm-8 bottom">X</div>
            </div>
        </div>
        <div class="col-sm-6 small">
            <div class="row">
                <div class="col-sm-5">RESPONSABLE DE LA CAPTACIÓN: </div>
                <div class="col-sm-7 bottom">X</div>
            </div>
            <div class="row">
                <div class="col-sm-5">DESCRIPCIÓN DE LA CAPTACIÓN: </div>
                <div class="col-sm-7 bottom">X</div>
            </div>
        </div>
    </div>
    <div class="row text-center oscuro">
        EL INSCRITO DECLARA CONOCER Y ACEPTAR LAS POLITICAS DEL PROCESO DE ADMISION
    </div>
    <div class="row plomo">
        <div class="col-sm-12">
            <span>1.- </span>
            <span>
                Se considera alumno matriculado y goza de todos los derechos como tal, aquel que ha realizado el pago de la matrícula
                , el pago de la primera cuota como mínimo, ha presentado todos los documentos solicitados y ha realiazado su proceso de matrícula
            </span>
            <br/>
            <span>2.- </span>
            <span>
                El alumno matriculado en fecha extenporanea, que ha cumplido con todos los pagos y ha entregado los documentos solicitados,
                deberá esperar 7 días después de inciado las clases para gozar de todos los derechos como alumno matriculado y se somete a
                la disponibilidad de inicios, asignaturas, ambientes, horarios y frecuencias de estudio.
            </span>
            <br/>
            <span>3.- </span>
            <span>
                En tanto el alumno no cancele el integro del pago de sus pensiones educativas,
                la universiodad retendrá los certificados correspondientes
                a los períodos no pagados.
            </span>
            <br/>
            <span>4.- </span>
            <span>
                El alumno no podrá matricularse en el ciclo académico siguiente hasta la cancelación de la deuda por pensiones educativas,
                salvo existencias de convenio de pago
            </span>
            <br/>
            <span>5.- </span>
            <span>
               Las pensiones no pagadas generarán intereses moratorios (LEY Nro 29947).
            </span>
            <br>
            <span>6.- </span>
            <span>
               El alumno conoce y acepta todo lo estipulado en el reglamento aprobado con la Resolución  Nro 018-2015-UPTELESUP-CU.
            </span>
            <br>
            <span>7.- </span>
            <span>
                Las pensiones no son congeladas, se adecuan a los incrementos gubernamentales de la UIT (Unidad Impositiva Tributaria anualmente)
            </span>
            <br/>
            <span>* Estoy de acuerdo con el contenido de la Ficha de Inscripción:</span>
        </div>

    </div>










</div><!--fin container-->










