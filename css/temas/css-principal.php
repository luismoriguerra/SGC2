<?php
echo <<<FINCSS
/***BOOTSTRAT***/
.f-gris{background:$fondo13;}
.input-mini {width: 60px;}
.input-small {width: 90px;}
.input-medium {width: 150px;}
.input-large {width: 210px;}
.input-xlarge {width: 270px;}
.input-xxlarge {width: 530px;}
input[disabled],
select[disabled],
textarea[disabled],
input[readonly],
select[readonly],
textarea[readonly] {
  cursor: not-allowed;
  background-color: #eeeeee;
}
input[type="radio"][disabled],
input[type="checkbox"][disabled],
input[type="radio"][readonly],
input[type="checkbox"][readonly] {
  background-color: transparent;
}

/****************************/
body {
    margin:0px;font-family: $tipoletra1;font-size:13px;color: $txt1;text-align:center;min-width:500px;
    background:url("../../../images/fondo11.png") no-repeat right bottom fixed;
}
ul, li {list-style-type:none;margin:0px;}
.navp{
    background:$fondo1;
    box-shadow: 0 1px 3px $sombra1,
        0 1px $sombra3 inset,
        0 10px $sombra4 inset,
        0 10px 20px $sombra5 inset;
    height:30px;text-align:left;
}
.footer{margin:0px 30px;text-align:left;}
hr{margin:18px 0px;border-top: 1px solid $borde7fondo14;border-bottom: 1px solid $borde8;}
p{margin:0px 0px 8px 0px;}
.header{height:50px;padding:0px 20px;background:$fondo15;
    background-image:-moz-linear-gradient(center bottom, $fondo15, $fondo16);
    background-image:-webkit-linear-gradient(top, $fondo15,$fondo16);; 
}
/*ELEMENTOS FORMULARIO*/
input[type="radio"]{margin:3px 0px 0px 0px;}
input[type="text"], input[type="password"], select, textarea{
    height:auto !important;
    border-width:1px;border-color:$borde9;border-style:solid;
    padding: 3px;
	font-size:11px;color:$txt1;
	/*border-radius:3px;*/
    -moz-transition:all 0.3s linear 0s;
    -webkit-transition:all 0.3s linear 0s;
    background:$fondo14;
}
input[type="text"]:focus, input[type="password"]:focus, select:focus,textarea:focus{
    border-color:$borde10;box-shadow:0 1px 1px $sombra7 inset, 0 0 8px $sombra8;
}
a{text-decoration:none;color:default;}
/************/
/**********/
.girado90{
    -webkit-transform: rotate(-90deg);
    -moz-transform: rotate(-90deg);
    filter: progid:DXImageTransform.Microsoft.BasicImage(rotation=3);
}
.borde1{border-color: $borde11;border-style: solid;border-width: 1px;}
.borde2{border-color: $borde12 transparent;border-style: solid;border-width: 1px;}
.borde3{border-color: $borde13;border-style: solid;border-width: 1px;}
.borde4{border-color: $borde14;border-style: solid;border-width: 1px;}
/*CLASES PANEL INFORME*/
.img_titulo_result{
    background-image: url("../../../images/informe/tit_resultados.png");
    background-repeat: no-repeat;
    display: inline-block;
    height: 25px;
    width: 153px;
}
.img_ficha0{background-position: 0px 0px;}
.img_ficha1{background-position: 0px -25px;}
.img_rgen0{background-position: 0px -50px;}
.img_rgen1{background-position: 0px -75px;}
.img_rgra0{background-position: 0px -100px;}
.img_rgra1{background-position: 0px -125px;}
.img_cri0{background-position: 0px -150px;}
.img_cri1{background-position: 0px -175px;}

.img_tit_izq{
    background-image: url("../../../images/informe/tit_menu_izq.png");
    background-repeat: no-repeat;
    display: inline-block;
    height: 248px;
    width: 89px;    
}
.img_tit_izq_end0{background-position: 0px 0px;}
.img_tit_izq_end1{background-position: -89px 0px;}
.img_tit_izq_res0{background-position: -178px 0px;}
.img_tit_izq_res1{background-position: -267px 0px;}


/*********/
#vistaMenuResultado{background: none repeat scroll 0 0 $fondo14;
    display: table;
    height: 100%;
    overflow: auto;
    width: 1150px;/*vertical-align:middle;*/}
.contTab{}
.menuResultado{
    background:$fondo17;font-weight:bold;height:34px;width:1150px;
}
.menuResultadoPestana{
    padding:3px 0px 0px 0px;color:$txt2;width:283px;display:inline-block;cursor:pointer;border-style:solid;border-width:1px;border-color:transparent $borde15 transparent transparent;vertical-align: top;
}
.resultadoPestana{

}
.informeTab{
    width:70%;background:$fondo18;padding:50px 5px;height:100px;margin:10px 0px;display:inline-block;border:1px solid $borde16;cursor:pointer;margin-right:-1px;
    border-style:solid;
    border-width:1px;
    border-color:$borde16;
}


/*CLASES CONFIGURAR ENCUESTA*/
.labelce{padding:3px 10px !important; width:320px;}
.contentBarra{padding:3px 3px 3px 10px;font-weight:bold;text-align:left;}
.contentTab{display:inline-block;margin:7px 5px 10px;}
.header{height:50px;padding:0px 20px;background:$fondo19;
    background-image:-moz-linear-gradient(center bottom, $fondo15, $fondo19);
    background-image:-webkit-linear-gradient(top,$fondo15,$fondo19);; 
}
.album{max-width:1000px;margin:20px auto;min-height:150px;overflow:auto;}
.parametro{margin: 0 auto;max-width: 600px;}
.pregunta{text-align:left;margin-top:50px;}
.preguntacg{text-align:left;margin-top:50px;}
.finalizar{}
.cuerpo_encuesta{position:absolute;
    left:50%;
    margin-left:-400px !important;
    /*top:50%;
    margin-top:-280px !important;*/}


/*punteros*/
.p-pointer{cursor:pointer;}
/*barras*/
.barra1{background: $fondo4;box-shadow: 0 0 1px $sombra1, 0 1px $sombra3 inset, 0 10px $sombra4 inset, 0 30px 20px $sombra5 inset;}
.barra2{background: $fondo20;box-shadow: 0 0 1px $sombra1, 0 1px $sombra3 inset, 0 10px $sombra4 inset, 0 30px 20px $sombra5 inset;}
.barra3{background: $fondo1;box-shadow: 0 0 1px $sombra1, 0 1px $sombra3 inset, 0 10px $sombra4 inset, 0 30px 20px $sombra5 inset;}
.barra4{background: $fondo21;}
.barra5{background: $fondo51;}
/*formualrios*/
.label{background:$fondo22;border:1px solid $borde9;padding:3px 5px 3px 20px;}
.label2{border:1px solid $borde9;padding:3px 5px 3px 5px;}
.labeld{min-width:250px;}
.form{padding:10px 40px 10px 20px !important;}
.formBotones{margin:5px;text-align:right;}
/*textos*/
.t-right{text-align:right;}
.t-center{text-align:center;}
.t-left{text-align:left;}
.t-justify{text-align:justify;}
.t-negrita{font-weight:bold;}
.t-cursiva{font-style:italic;}
.t-10{font-size:10px;}
.t-11{font-size:11px;}
.t-12{font-size:12px !important;}
.t-13{font-size:13px !important;;}
.t-14{font-size:14px;}
.t-15{font-size:15px;}
.t-16{font-size:16px;}
.t-17{font-size:17px;}
.t-18{font-size:18px;}
.t-19{font-size:19px;}
.t-20{font-size:20px;}
.t-22{font-size:22px;}
.t-azul{color:$txt3;}
.t-azul2{color:$txt4;}
.t-azul3{color:$txt5;}
.t-marino{color:$txt6;}
.t-blanco{color:$txt7;}
.t-negro{color:$txt8;}
.t-rojo{color:$txt9 !important;}
.t-verde{color:$txt10;}
.t-gris{color:$txt11;}
.t-gris1{color:$txt12;}
.t-gris2{color:$txt13;}
.t-gris3{color:$txt14;}
.t-sombra{text-shadow:3px 3px 3px $sombra12;}
.t-tahoma{font-family: Tahoma, Arial !important;}
.t-arial{font-family: Arial;}
.t-narrow{font-family: 'PT Sans Narrow', Arial;}
/*botones*/
.btn_i{cursor:pointer;border-radius:4px;border:1px solid transparent;padding:2px 2px 0px;}
.btn_i:hover{border:1px solid $borde9;}
.btn_i:active{opacity:.6;}
.btn{
    border-color: $borde2 $borde2 $borde3;
    border-style: solid;
    border-width: 1px;
    padding: 4px 5px;
    cursor:pointer;
    font-size: 12px;
}
.btn-verde{background: $fondo23;color:$txt7 !important;}
.btn-verde:hover{background: $fondo24;}
.btn-verde:active{background: $fondo23;}
.btn-azul{background: $fondo25;color:$txt7 !important;}
.btn-azul:hover{background: $fondo26;}
.btn-azul:active{background: $fondo25;}
.btn-gris{background: $fondo27;color:$txt1 !important;}
.btn-gris:hover{background: $fondo28;}
.btn-gris:active{background: $fondo27;}
.btn-amarillo{background: $fondo29;color:$txt7;text-shadow:1px 1px 1px $sombra13;}
.btn-amarillo:hover{background: $fondo30;}
.btn-amarillo:active{background: $fondo29;color:$txt7;text-shadow:1px 1px 1px $sombra13;}
/**SOMBRA TEXTO**/
.sombra-text{text-shadow:2px 2px 2px $sombra14;}
/****SOMBRAS***/
.sombra-br{/*bottom-right*/box-shadow:2px 3px 2px $sombra15;}
.sombra-i{/*iconos botones*/box-shadow:0 1px $sombra3 inset,0 10px $sombra2 inset,0 10px 20px $sombra5 inset;}
.sombra-3d{box-shadow: 0 2px 6px $sombra1,0 1px $sombra3 inset,0 10px $sombra2 inset,0 10px 20px $sombra5 inset;}
.sombra-3d2{box-shadow: 0 2px 7px $sombra1,0 1px $sombra3 inset,0 10px 2px $sombra2 inset,0 10px 20px $sombra5 inset;
}
/*contenido secc derecha*/
.cont-der{overflow: auto;padding: 3px 5px 5px 20px;}
/*capaMensaje*/
.capaMensaje{width:400px;top:0;left:50%;margin-left:-200px;position: fixed;overflow: auto;padding-bottom:10px;z-index:2000;}
.msjOk{margin:-1px auto 0px;padding:5px 5px;background-color: $fondo31;border: 1px solid $borde17;
    background-image: -moz-linear-gradient(center top , $fondo31, $fondo33);
    background-image: -webkit-linear-gradient(top,$fondo31,fondo33);
}
.msjOk:hover{background-color: $fondo33;border-color: $borde18;
    background-image: -moz-linear-gradient(center top , $fondo31, $fondo32);
    background-image: -webkit-linear-gradient(top,$fondo31,$fondo32);
}
.msjAdvertencia{margin:-1px auto 0px;padding:5px 5px;background-color: $fondo34;border: 1px solid $borde19;color:black;
    background-image: -moz-linear-gradient(center top , $fondo34, $fondo36);
    background-image: -webkit-linear-gradient(top,$fondo34,$fondo36);
}
.msjAdvertencia:hover{background-color: $fondo37;border-color: $borde20;
    background-image: -moz-linear-gradient(center top , $fondo34, $fondo35);
    background-image: -webkit-linear-gradient(top,$fondo34,$fondo35);   
}
.msjError{margin:-1px auto 0px;padding:5px 5px;background-color: $fondo38;border: 1px solid $borde21;color:white;
    background-image: -moz-linear-gradient(center top , $fondo39, $fondo38);
    background-image: -webkit-linear-gradient(top,$fondo39,$fondo38);
}
.msjError:hover{background-color: $fondo40;border-color: $borde22;
    background-image: -moz-linear-gradient(center top , $fondo39, $fondo40);
    background-image: -webkit-linear-gradient(top,$fondo39,$fondo40);      
}
/**lista contenido aside**/
.lca{padding: 0px 3px 0px 3px;margin:5px 0px;text-align:left;}
.lca li{padding: 3px;cursor:pointer;white-space:nowrap;}
.lca li.active{background:$fondo4;
    box-shadow: 0 0px 1px $sombra1,
        0 1px $sombra3 inset,0 10px $sombra4 inset,0 30px 20px $sombra5 inset;
}
.lca li:hover{background:$fondo41;
    box-shadow: 0 0px 1px $sombra1,
        0 1px $sombra3 inset,0 10px $sombra4 inset,0 10px 20px $sombra5 inset;
}
/*contenido*/
.contenido{
    padding:0px 30px;
    left:0px;position: relative;right: 0px;top: 0px;}
.cuerpo{margin:5px auto;display:table;width:100%;table-layout:fixed;}
.secc-izq{display:table-cell;background:$fondo5;
}
.secc-divi{width:8px;display:table-cell;cursor: pointer;vertical-align:middle}
.secc-divi-izq{box-shadow: -4px 0px 3px $sombra9 inset;}
.secc-divi-izq:hover{box-shadow: -5px 0px 3px $sombra11 inset}
.secc-divi-der{box-shadow: 4px 0px 3px $sombra9 inset;}
.secc-divi-der:hover{box-shadow: 5px 0px 3px $sombra11 inset}
.secc-der{display:table-cell;background:$fondo7;padding:0px;border:1px solid $borde23;vertical-align:top;}
/*listas cabecera derecha*/
.lcd{display: inline-block;margin:0px 0px 0px 5px;line-height:27px;vertical-align:top;color:$txt15;}
.avatar{border-width:1px;border-style:solid;border-color:$borde24;height:27px;display:block;border-radius:2px;}
/*cabecera*/
.cab-izq{/*cabecera-izquierda*/float:left; display:inline-block;padding-top: 3px;}
.cab-der{/*cabecera-derecha*/float:right; display:inline-block;padding-top: 3px;}
/*******MENU NAV******/
.nav {height:30px;display: inline-block;margin:0px 0px 0px 30px;}
.nav ul {padding: 0px; /*evita q ul's se adelante pq kita margen al ul*/cursor: pointer;}
.nav ul li {float:left;position:relative;color:$txt7;text-shadow:0px -1px 0px $sombra10;
    vertical-align: middle;height:28px;margin-left:-1px;
    border-color: $borde6;
    border-width:1px;border-style:solid;background:$fondo2;
    box-shadow:1px 0px $sombra3 inset,0px 10px $sombra2 inset,0px 10px 20px $sombra5 inset;
}
.nav ul li.active{border-color: $borde1;background:$fondo4;color:$txt8;text-shadow:0px -1px 0px $sombra5;}
.nav ul li:hover{-webkit-transition:all 0.1s linear;-moz-transition:all 0.1s linear;background:$fondo3;color:$txt7;}
/*.nav ul li:first-child{border-top-left-radius:10px;}
.nav ul li:last-child{border-bottom-right-radius:10px;}*/
.nav ul li a, .nav ul li span,.nav-sub ul li a, .nav-sub ul li span {padding:5px 10px;display: block;font-size:1em;}
.nav-sub ul {margin-top: 2px;position: absolute;display:none;border:1px solid $borde6;box-shadow:1px 1px 8px $sombra16;padding:0px;z-index:100;min-width:130px;}
.menu-header{/*estilo pal menu de cabecera*/
    border:1px solid $borde9 !important;line-height:20px;background:$fondo14;}
.menu-header li{background:$fondo14 !important;cursor:pointer;font-size:0.85em;text-align: right;}
.menu-header li:hover{background:$fondo42 !important;}
.nav-sub ul li {
    float: none;white-space: nowrap;/*evita salto de linea*/
    margin:0px;/*evita conflicto de corner del nav principal*/
    border-top-left-radius:0px !important;border-bottom-right-radius:0px !important;
    border:0px;background:$fondo8;box-shadow:0px 0px 0px $sombra13;}
.nav-sub ul li:hover{opacity: 0.9;}
.nav-sub ul li:hover > ul {visibility: visible;}
.nav-sub-sub ul {visibility: hidden;display:block;left:100%;top:0px;}
.nav-sub-sub ul li {float: none;white-space: nowrap;margin-bottom:0px;border:0px;}
/*****BORDER****/
.corner-tl {border-top-left-radius:5px;}
.corner-tr {border-top-right-radius:5px;}
.corner-bl {border-bottom-left-radius:5px;}
.corner-br {border-bottom-right-radius:5px;}
.corner-all {border-radius:5px;}
.corner-top{border-radius:5px 5px 0px 0px;}
.corner-top-10{border-radius:10px 10px 0px 0px;}
.corner-bottom{border-radius:0px 0px 5px 5px;}
.corner-left{border-radius:5px 0px 0px 5px;}
.corner-right{border-radius:0px 5px 5px 0px;}

/*LOGIN*/
.login{background:#FCFCFE;display:inline-block;box-shadow:0 15px 10px -10px #000000;padding:15px;border:1px solid #cccccc}

/*TOOLTIP*/
#tooltip {
    color:$txt15;font-size: 11px; 
    position: absolute; z-index: 1000;padding: 5px 7px;
    border: 1px solid $borde25; background: $fondo9;
    box-shadow: 1px 1px 3px $sombra1,3px 0px 30px $sombra1,
        0 1px $sombra3 inset,0 10px $sombra4 inset,
        0 30px 20px $sombra5 inset;
    border-radius:0px 5px 5px 0px;
}
#tooltip h3{font-size: 11px;}/*h3 es mandado por la libreria tooltip y no meto mano al codigo de la libreria, por eso lo pongo asi*/
#tooltip h3, #tooltip div { margin: 0; }

#tooltip.advert{margin-left:5px;}
#tooltip.advert:after{
    content: " ";display: block;position: absolute;width: 0;height: 0;
    bottom: 3px;left: -16px;
    border-color:transparent $borde9 transparent transparent;border-width: 8px;border-style: solid;
}
#tooltip.advert:before{
    content: " ";display: block;position: absolute;width: 0;height: 0;z-index: 2;
    bottom: 5px;left: -12px;
    border-color:transparent $borde4 transparent transparent;border-width: 6px;border-style: solid;
}
#tooltip.msjAdv {
    border-radius:0px;box-shadow:none;border: none;width:220px;height: 23px;padding:11px 18px 5px 2px;
    background: url('../../img/tootip_adv.png');
}
#tooltip.msjAdv div {width: 200px;}
#tooltip.msjAdv.viewport-right {background: url('../../img/tootip_adv-reverse.png');}
/****ICONOS****/
.icon-gray {background-image:url("../../img/icons-gray.png");}
.icon-white {background-image:url("../../img/icons-white.png");}
.icon-red {background-image:url("../../img/icons-red.png");}
[class^="icon-"],[class*=" icon-"]{background-repeat:no-repeat;display:inline-block;height:14px;width:14px;line-height:14px; /*interlineado, altura de linea*/}

.icon-glass {background-position:0 0;}
.icon-music {background-position: -24px 0;}
.icon-search {background-position: -48px 0;}
.icon-envelope {background-position: -72px 2px;}
.icon-heart {background-position: -96px 0;}
.icon-star {background-position: -120px 0;}
.icon-star-empty {background-position: -144px 0;}
.icon-user {background-position: -168px 1px;}
.icon-film {background-position: -192px 0;}
.icon-th-large {background-position: -216px 0;}
.icon-th {background-position: -240px 1px;}
.icon-th-list {background-position: -264px 0;}
.icon-ok {background-position: -288px 0;}
.icon-remove {background-position: -310px 0;}
.icon-zoom-in {background-position: -336px 0;}
.icon-zoom-out {background-position: -360px 0;}
.icon-off {background-position: -384px 0;}
.icon-signal {background-position: -408px 1px;}
.icon-cog {background-position: -432px 0;}
.icon-trash {background-position: -456px 1px;}

.icon-home {background-position: 0 -24px;}
.icon-file {background-position: -24px -24px;}
.icon-time {background-position: -48px -24px;}
.icon-road {background-position: -72px -24px;}
.icon-download-alt {background-position: -96px -23px;}
.icon-download {background-position: -120px -24px;}
.icon-upload {background-position: -144px -24px;}
.icon-inbox {background-position: -168px -24px;}
.icon-play-circle {background-position: -192px -24px;}
.icon-repeat {background-position: -216px -24px;}
.icon-refresh {background-position: -240px -24px;}
.icon-list-alt {background-position: -264px -23px;}
.icon-lock {background-position: -287px -23px;}
.icon-flag {background-position: -312px -24px;}
.icon-headphones {background-position: -336px -24px;}
.icon-volume-off {background-position: -360px -24px;}
.icon-volume-down {background-position: -384px -24px;}
.icon-volume-up {background-position: -408px -24px;}
.icon-qrcode {background-position: -432px -24px;}
.icon-barcode {background-position: -456px -24px;}

.icon-tag {background-position: 0 -48px;}
.icon-tags {background-position: -25px -48px;}
.icon-book {background-position: -48px -48px;}
.icon-bookmark {background-position: -72px -48px;}
.icon-print {background-position: -96px -48px;}
.icon-camera {background-position: -120px -48px;}
.icon-font {background-position: -144px -48px;}
.icon-bold {background-position: -167px -48px;}
.icon-italic {background-position: -192px -48px;}
.icon-text-height {background-position: -216px -48px;}
.icon-text-width {background-position: -240px -48px;}
.icon-align-left {background-position: -264px -48px;}
.icon-align-center {background-position: -288px -48px;}
.icon-align-right {background-position: -312px -48px;}
.icon-align-justify {background-position: -336px -48px;}
.icon-list {background-position: -360px -48px;}
.icon-indent-left {background-position: -384px -48px;}
.icon-indent-right {background-position: -408px -48px;}
.icon-facetime-video {background-position: -432px -48px;}
.icon-picture {background-position: -456px -48px;}

.icon-pencil {background-position: 0 -71px;}
.icon-map-marker {background-position: -24px -72px;}
.icon-adjust {background-position: -48px -72px;}
.icon-tint {background-position: -72px -72px;}
.icon-edit {background-position: -96px -71px;}
.icon-share {background-position: -120px -72px;}
.icon-check {background-position: -144px -72px;}
.icon-move {background-position: -168px -72px;}
.icon-step-backward {background-position: -192px -72px;}
.icon-fast-backward {background-position: -216px -72px;}
.icon-backward {background-position: -240px -72px;}
.icon-play {background-position: -264px -72px;}
.icon-pause {background-position: -288px -72px;}
.icon-stop {background-position: -312px -72px;}
.icon-forward {background-position: -336px -72px;}
.icon-fast-forward {background-position: -360px -72px;}
.icon-step-forward {background-position: -384px -72px;}
.icon-eject {background-position: -408px -72px;}
.icon-chevron-left {background-position: -432px -72px;}
.icon-chevron-right {background-position: -456px -72px;}

.icon-plus-sign {background-position: 0 -95px;}
.icon-minus-sign {background-position: -24px -95px;}
.icon-remove-sign {background-position: -48px -95px;}
.icon-ok-sign {background-position: -72px -96px;}
.icon-question-sign {background-position: -96px -95px;}
.icon-info-sign {background-position: -120px -95px;}
.icon-screenshot {background-position: -144px -95px;}
.icon-remove-circle {background-position: -168px -95px;}
.icon-ok-circle {background-position: -192px -95px;}
.icon-ban-circle {background-position: -216px -95px;}
.icon-arrow-left {background-position: -240px -94px;}
.icon-arrow-right {background-position: -264px -94px;}
.icon-arrow-up {background-position: -289px -95px;}
.icon-arrow-down {background-position: -312px -95px;}
.icon-share-alt {background-position: -336px -95px;}
.icon-resize-full {background-position: -360px -95px;}
.icon-resize-small {background-position: -384px -95px;}
.icon-plus {background-position: -408px -95px;}
.icon-minus {background-position: -433px -95px;}
.icon-asterisk {background-position: -456px -95px;}

.icon-exclamation-sign {background-position: 0 -119px;}
.icon-gift {background-position: -24px -120px;}
.icon-leaf {background-position: -48px -120px;}
.icon-fire {background-position: -72px -120px;}
.icon-eye-open {background-position: -96px -120px;}
.icon-eye-close {background-position: -120px -119px;}
.icon-warning-sign {background-position: -144px -120px;}
.icon-plane {background-position: -168px -120px;}
.icon-calendar {background-position: -192px -120px;}
.icon-random {background-position: -217px -119px;}
.icon-comment {background-position: -240px -120px;}
.icon-magnet {background-position: -264px -120px;}
.icon-chevron-up {background-position: -288px -120px;}
.icon-chevron-down {background-position: -313px -119px;}
.icon-retweet {background-position: -336px -118px;}
.icon-shopping-cart {background-position: -360px -120px;}
.icon-folder-close {background-position: -384px -120px;}
.icon-folder-open {background-position: -408px -120px;}
.icon-resize-vertical {background-position: -432px -119px;}
.icon-resize-horizontal {background-position: -456px -118px;}

.icon-izq{background-position: -432px -72px;width:6px;}/*agregados manualmente triangulitos pequeños*/
.icon-der{background-position: -464px -72px;width:6px;}
.icon-aba{background-position: -313px -127px;height:6px;vertical-align: middle;}

.icon-perfil{background-position: 0 -143px;}

/*formularios login*/
.label-login{
    margin:2px 5px 2px 2px;
    padding:2px;display:inline-block;
    text-align:right;line-height:18px;
    text-shadow:1px 1px 0px #cccccc;
    background:none;
    border:none;
}
.form-login{text-align:left;margin:20px 0px 5px 0px;vertical-align:top;}
.form-login label{width:75px;}
.form-login input[type="text"],.form-login input[type="password"]{width:150px;clear:both;padding: 3px;margin:2px 2px 10px 2px;}

/*ANIMACIONES
==============*/
@-webkit-keyframes girar {
    from {
        -webkit-transform: rotate(0deg);opacity:1;
    }
    to {
        -webkit-transform: rotate(360deg);opacity:.3;
    }
}
@-moz-keyframes girar {
    from {
        -moz-transform: rotate(0deg);opacity:1;
    }
    to {
        -moz-transform: rotate(360deg);opacity:.3;
    }
}
.girando{
    display:inline-block;
    -webkit-animation-name: girar;
    -webkit-animation-duration: 2s;
    -webkit-animation-iteration-count: infinite;
    -webkit-animation-timing-function: ease-in-out;
     
    -moz-animation-name: girar;
    -moz-animation-duration: 2s;
    -moz-animation-iteration-count: infinite;
    -moz-animation-timing-function: ease-in-out;
}
@-webkit-keyframes opacidad {
    from {
        opacity:1;
    }
    to {
        opacity:0.1;
    }
}
@-moz-keyframes opacidad {
    from {
        opacity:1;
    }
    to {
        opacity:0.1;
    }
}
.opacando{
    display:inline-block;
    -webkit-animation-name: opacidad;
    -webkit-animation-duration: 2s;
    -webkit-animation-iteration-count: infinite;
    -webkit-animation-timing-function: ease-in-out;
     
    -moz-animation-name: opacidad;
    -moz-animation-duration: 2s;
    -moz-animation-iteration-count: infinite;
    -moz-animation-timing-function: ease-in-out;
}


/*FORMAS
===========*/
.estrella {
    margin: 12px 5px;
    position: relative;
    display: block;
    width: 0px;
    height: 0px;
    border-right:  15px solid transparent;
    border-bottom: 10px  solid $borde26;
    border-left:   15px solid transparent;
    -moz-transform:    rotate(35deg);
    -webkit-transform: rotate(35deg);
    -ms-transform:     rotate(35deg);
}
.estrella:before {
    border-bottom: 15px solid $borde26;
    border-left: 5px solid transparent;
    border-right: 5px solid transparent;
    position: absolute;
    top: -10px;
    left: -11px;
    display: block;
    content: '';
    -webkit-transform: rotate(-35deg);
    -moz-transform:    rotate(-35deg);
    -ms-transform:     rotate(-35deg);   
}
.estrella:after {
   position: absolute;
   display: block;
   top: 0px;
   left: -16px;
   border-right: 15px solid transparent;
   border-bottom: 10px solid $borde26;
   border-left: 15px solid transparent;
   content: '';
   -webkit-transform: rotate(-70deg);
   -moz-transform:    rotate(-70deg);
   -ms-transform:     rotate(-70deg);
}
/*loading*/
.capaCargando {/*JC*/
    background: $fondo10 !important;
    border-color: $borde5 !important;
    border-radius: 50%;
    border-width: 2px !important;
    box-shadow: 0 1px $sombra3 inset, 0 10px $sombra4 inset, 0 10px 20px $sombra5 inset !important;
    border: 1px solid $borde9;
    z-index:10001;
    padding: 5px 2px 2px;
    text-align: center;
    width: auto;
    left:49%;
    top:50%;
    position: fixed;
}
.capaOscura{width:100%;height:100%;position:fixed;background: none repeat scroll 0 0 $fondo11;z-index:10000}


/**********************************************************JQUERY CSS*******************************************************/
/***************************************************************************************************************************/
/*tabs*/
.tabs-bottom { position: relative; } 
.tabs-bottom .ui-tabs-panel { overflow: auto; } 
.tabs-bottom .ui-tabs-nav { left: 0; bottom: 0; right:0; padding: 0.2em 0.2em 0; } 
.tabs-bottom .ui-tabs-nav li { margin-top: -2px !important; margin-bottom: 1px !important; border-top: none; border-bottom-width: 1px; }
.ui-tabs-selected { margin-top: -3px !important; }
.ui-tabs .ui-tabs-nav .ui-state-active  {background:$fondo6;}/*reemplaza al estilo active de jquery*/
.ui-tabs .ui-tabs-nav .ui-state-active:hover  {background:$fondo6;}/*reemplaza al hover de jquery*/
.ui-tabs .ui-tabs-nav .ui-state-active  a{color:$txt16;}/*reemplaza al color del active de jquery*/

.ui-tabs .ui-tabs-hide {display: none !important;}
.ui-helper-clearfix:before, .ui-helper-clearfix:after {content: "";display: table;}
.ui-tabs .ui-tabs-nav li {
    float: left;list-style: none outside none;margin: 0 0.2em 1px 0;padding: 0;position: relative;top: 1px;white-space: nowrap;
    background: $fondo44;
    border-color: $borde2 $borde2 $borde3;border-style: solid;border-width: 1px 1px 0px;
    box-shadow: 1px 0 $sombra3 inset, 0 10px $sombra2 inset, 0 10px 20px $sombra5 inset;
    text-shadow: 0 -1px 0 $sombra10;
    top:1px;
}
.ui-tabs .ui-tabs-nav li:hover {background: $fondo28;}
.ui-tabs .ui-tabs-nav li a {float: left;padding: 0.5em 1em;text-decoration: none;color:$txt8;}
.ui-tabs .ui-tabs-panel {background: none repeat scroll 0 0 transparent;border-width: 0;display: block;padding: 1em 1.4em;}
/*jgrid*/
.ui-jqgrid{margin:5px;display:inline-block;}
/*iconos*/
.ui-icon{background-image:url("../../img/icons-gray.png");background-repeat: no-repeat;display: block;overflow: hidden;text-indent: -99999px;}

.ui-icon-plus{background-position: 1px -95px;width:16px;height:16px;}
.ui-icon-pencil{background-position: -95px -71px;width:16px;height:16px;}
.ui-icon-document{background-position: -264px -23px;width:16px;height:16px;}
.ui-icon-trash{background-position: -456px 2px;width:16px;height:16px;}
.ui-icon-search{background-position: -47px 1px;width:16px;height:16px;}
.ui-icon-refresh{background-position: -239px -23px;width:16px;height:16px;}
.ui-icon-seek-prev{background-position: -191px -71px;width:16px;height:16px;}
.ui-icon-seek-first{background-position: -215px -71px;width:16px;height:16px;}
.ui-icon-seek-next{background-position: -384px -71px;width:16px;height:16px;}
.ui-icon-seek-end{background-position: -359px -71px;width:16px;height:16px;}
.ui-icon-closethick{background-position: -310px 1px;width:16px;height:16px;}
.ui-icon-disk{background-position: -94px -23px;width:16px;height:16px; background-image:url("../../img/icons-white.png");}
.ui-icon-close{background-position: -46px -95px;width:16px;height:16px;background-image:url("../../img/icons-white.png");}
.ui-icon-gripsmall-diagonal-se{background-position: 15px 0px;width:16px;height:16px;}/*no tengo ese icono (resize)*/
.ui-icon-circle-triangle-w{background-position: -430px -71px;width:16px;height:16px;}
.ui-icon-circle-triangle-e{background-position: -455px -71px;width:16px;height:16px;}
.ui-icon-circle-triangle-n{background-position: -286px -120px;width:16px;height:16px;}
.ui-icon-circle-triangle-s{background-position: -311px -119px;width:16px;height:16px;}
.ui-icon-cancel{background-position: -48px -95px;width:16px;height:16px;}
/*dialog*/
.ui-dialog {
    box-shadow: 0 15px 10px -10px $sombra13;overflow: hidden;position: absolute;width: 300px;padding:2px;}
.ui-dialog .ui-dialog-titlebar {
    color: $txt7;font-size: 11px;
    padding: 4px 5px 4px;position: relative;text-decoration: none;}
.ui-dialog .ui-dialog-title {float: left;margin: 0.1em 16px 0.1em 0;}
.ui-dialog .ui-dialog-titlebar-close {
    height: 18px;margin: -10px 0 0;padding: 1px;
    position: absolute;right: 0.3em;top: 50%;width: 19px;}
.ui-dialog .ui-dialog-titlebar-close span { display: block; margin: 1px; }
.ui-dialog .ui-dialog-titlebar-close:hover, .ui-dialog .ui-dialog-titlebar-close:focus { padding: 0px; }
.ui-dialog .ui-dialog-content { position: relative; padding: .5em; background: none; overflow: auto;border:none;  }
.ui-dialog .ui-dialog-buttonpane { text-align: left; border-width: 1px 0 0 0; background-image: none; margin: .5em 0 0 0; padding: 0px 5px;background:$fondo14;margin:0px 5px 5px 5px;}
.ui-dialog .ui-dialog-buttonpane .ui-dialog-buttonset { float: right; }
.ui-dialog .ui-dialog-buttonpane button { margin: .5em .4em .5em 0; cursor: pointer; }
.ui-draggable .ui-dialog-titlebar { cursor: move; }

/*rezisable*/
.ui-resizable-handle {display: block;font-size: 0.1px;position: absolute;z-index: 99999;}
.ui-dialog .ui-resizable-se { width: 14px; height: 14px; right: 3px; bottom: 3px; }
.ui-resizable {position: relative;}
.ui-resizable-se {bottom: 1px;cursor: se-resize;height: 12px;right: 1px;width: 12px;}

.ui-helper-clearfix {display: block;}
.ui-helper-clearfix:after {clear: both;content: ".";display: block;height: 0;visibility: hidden;}

/* Component containers
----------------------------------*/
.ui-widget { font-size: 12px; }
.ui-widget-content a { color: $txt1; }
.ui-widget-content { 
    border: 1px solid $borde9; color: $txt1;
    background: $fondo45;
}
.ui-state-default a, .ui-state-default a:link, .ui-state-default a:visited { color: $txt1; text-decoration: none; }
.ui-state-default, .ui-widget-content .ui-state-default { 
    border: 1px solid $borde27; 
    background:$fondo46;
    box-shadow: 0 1px $sombra3 inset,
        0 10px $sombra4 inset,
        0 10px 20px $sombra5 inset;
    font-weight: normal; 
    color: $txt1; 
}
.ui-state-default2, .ui-widget-content .ui-state-default2 { 
    border: 1px solid $borde27; 
    background:$fondo46;
    box-shadow: 0 1px $sombra3 inset,
        0 10px $sombra4 inset,
        0 10px 20px $sombra5 inset;
    font-weight: normal;
	font-size:16px;
    color: $txt1; 
}
.ui-widget-header a { color: $txt16; }
.ui-widget-header { 
    background:$fondo2;
    box-shadow: 0 1px $sombra3 inset,
        0 10px $sombra4 inset,
        0 30px 20px $sombra5 inset;
    color: $txt1; 
    font-weight: bold;}
.ui-state-hover a, .ui-state-hover a:hover { color: $txt1; text-decoration: none; }
.ui-state-hover, .ui-widget-content .ui-state-hover, .ui-state-focus, .ui-widget-content .ui-state-focus { 
    border: 1px solid $borde28; 
    background:$fondo47;
    box-shadow: 0 1px $sombra3 inset,
        0 10px $sombra4 inset,
        0 30px 20px $sombra5 inset;
    font-weight: normal; 
    color: $txt1; 
}
.ui-state-highlight a, .ui-widget-content .ui-state-highlight a { color: $txt17; }
.ui-state-highlight, .ui-widget-content .ui-state-highlight {
    border: 1px solid $borde29; 
    background: $fondo48; 
    color: $txt17; 
}
.ui-widget-overlay{
    background: $fondo12;
    height: 100%;
    left: 0;
    position: absolute;
    top: 0;
    width: 100%;
    opacity:1 !important;
}

.ui-state-active, .ui-widget-content .ui-state-active {background: $fondo49;color:$txt1;text-shadow: 1px 1px 1px $sombra17;border:1px solid $borde29;}
.ui-state-active a, .ui-state-active a:link, .ui-state-active a:visited { color: $txt8; text-decoration: none; }
.ui-widget :active { outline: none; }
/*datepicker*/
/************DATEPICKER****************/
.ui-datepicker { width: 17em; padding: .2em .2em 0; display:none;box-shadow:0 15px 10px -10px $sombra13}
.ui-datepicker .ui-datepicker-header { position:relative; padding:.2em 0; }
.ui-datepicker .ui-datepicker-prev, .ui-datepicker .ui-datepicker-next { position:absolute; top: 3px; width: 1.5em; height: 1.5em; }
.ui-datepicker .ui-datepicker-prev-hover, .ui-datepicker .ui-datepicker-next-hover { top: 2px; }
.ui-datepicker .ui-datepicker-prev span, .ui-datepicker .ui-datepicker-next span { display: block; position: absolute; left: 50%; margin-left: -8px; top: 50%; margin-top: -8px;  }
.ui-datepicker .ui-datepicker-prev { left:2px; }
.ui-datepicker .ui-datepicker-next { right:2px; }
.ui-datepicker .ui-datepicker-title { margin: 0 2.3em; line-height: 1.8em; text-align: center;font-size:11px; }
.ui-datepicker select.ui-datepicker-month, 
.ui-datepicker select.ui-datepicker-year { width: 49%;}
.ui-datepicker table {width: 100%; font-size: 11px; border-collapse: collapse; margin:0 0 .4em; }
.ui-datepicker th { padding: .7em .3em; text-align: center; font-weight: bold; border: 0;  }
.ui-datepicker td { border: 0; padding: 1px; }
.ui-datepicker td span, .ui-datepicker td a { display: block; padding: .2em; text-align: right; text-decoration: none; }
.ui-datepicker .ui-datepicker-buttonpane button.ui-datepicker-current { float:left; }


















/* por EVALUAr
----------------------------------*/
/* Interaction Cues
----------------------------------*/
.ui-state-error, /*.ui-widget-content*/ .ui-state-error {border: 1px solid $borde30; background: $fondo50 url(../../img/advertencia.png) 50% 50% repeat-x; color: $txt1; }
.ui-state-error a, .ui-widget-content .ui-state-error a { color: $txt18; }
.ui-state-error-text, .ui-widget-content .ui-state-error-text { color: $txt28; }
.ui-priority-primary, .ui-widget-content .ui-priority-primary { font-weight: bold; }
.ui-priority-secondary, .ui-widget-content .ui-priority-secondary { opacity: .7; filter:Alpha(Opacity=70); font-weight: normal; }
.ui-state-disabled, .ui-widget-content .ui-state-disabled { opacity: .35; filter:Alpha(Opacity=35); /*background-image: none;JC*/ }

FINCSS;
?>

