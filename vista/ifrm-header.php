<script type="text/javascript" src="../javascript/ifrm-header.js"></script>
<script type="text/javascript" src="../javascript/dao/DAOheader.js"></script>
<div class="header">
	<div class="cab-izq">
    	<?
		$dinstit="LOGO";
		if($_SESSION['SECON']['cinstit']!=''){
		$dinstit=$_SESSION['SECON']['dinstit'];
		}
        
		?>
		<img src="../reporte/excel/includes/<?=$dinstit;?>.jpg"/>
	</div>
	<div class="cab-der">
		<ul>        	
			<li class="lcd"><span><? echo($_SESSION['SECON']['dnomper']." ".$_SESSION['SECON']['dappape']." ".$_SESSION['SECON']['dapmape']);?></span></li>
			<li class="lcd nav-sub"><span class="avatar"><img style="left: 0;top: 0;cursor:pointer" src="../images/usuarios/avatar.jpg"></span>
				<ul class="menu-header" style="right:20px;margin-top:0px">
					<li id="sub_opciones"><span>Opciones de Cuenta</span></li>
					<li id="select_temas"><span>Temas</span></li>
				</ul>
			</li>
            <li class="lcd">
            	<span id="detalle_ode">ODE:</span>
                <span id="seleccion_ode">
                	<Select id="slct_filial_cabecera">
                    <? echo $_SESSION['SECON']['slct_filial_cabecera'];?>                    
                    </Select>
                </span>
            </li>
            <li class="lcd">
            	<span id="detalle_grupo">GRUPO:</span>
                <span id="seleccion_grupo">
                	<Select id="slct_grupo_cabecera">
                    <? echo $_SESSION['SECON']['slct_grupo_cabecera'];?>                    
                    </Select>
                </span>
            </li>
		</ul>
	</div>
	<input type="hidden" value="<?= $_SESSION['SECON']['dlogper']?>" id="hd_idUsuario"/>
    <input type="hidden" value="<?= $_SESSION['SECON']['cfilial']?>" id="hd_idFilial"/>
    <input type="hidden" value="<?= $_SESSION['SECON']['dfilial']?>" id="hd_desFilial"/>
    <input type="hidden" value="<?= $_SESSION['SECON']['cinstit']?>" id="hd_idInstituto"/>
    <input type="hidden" value="<?= $_SESSION['SECON']['cgrupo']?>" id="hd_idGrupo"/>
    <input type="hidden" value="<?= $_SESSION['SECON']['cfilials']?>" id="hd_idFilials"/>
    
</div>