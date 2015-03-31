<?
class servletLogin extends controladorComandos{
	public function doPost(){
		$daoLogin=creadorDAO::getLoginDAO();
		$daoCarrera=creadorDAO::getCarreraDAO();
		switch ($_POST['accion']) {
			case 'login':
				$dtoUsuario=new dto_usuario;
				$dtoUsuario->setDni($_POST['user']);
                $dtoUsuario->setPassword($_POST['pass']);
				$data=$daoLogin->loginUsuario($dtoUsuario);

				if(count($data)>0){
					$r=array();
					
					$_SESSION['SECON']=$data[0];
					$det=explode("|",$_SESSION['SECON']['accesos']);
					$detfil=explode("^^",$_SESSION['SECON']['filiales']);
					$_SESSION['SECON']['cfilial']=$det[0];
					$_SESSION['SECON']['dfilial']=$det[1];
					$_SESSION['SECON']['cinstit']=$det[4];
					$_SESSION['SECON']['dinstit']=$det[5];
					$r['cgrupo']=$det[2];
					$_SESSION['SECON']['cgrupo']=$_SESSION['SECON']['accesos'];
					
					$option="";
					$codigofiliales="";
						foreach($detfil as $d){
						$dd=explode("|",$d);
						$codigofiliales.=$dd[0].",";
						$option.="<option value='".$d."'><b>".$dd[1]."</b></option>";
						}
						$ordenar=explode(",",$codigofiliales."9999");
						sort($ordenar);
					$_SESSION['SECON']['cfilials']=implode(",",$ordenar);
					$_SESSION['SECON']['slct_filial_cabecera']=$option;
					$option="";
						foreach($data as $d){
						$det=explode("|",$d['accesos']);
						$option.="<option value='".$d['accesos']."'><b>".$det[3]."</b></option>";
						}
					$_SESSION['SECON']['slct_grupo_cabecera']=$option;
					
					
					$menu=$daoCarrera->listarMenuDinamico($r);
					$_SESSION['SECON']['menu']='';
						if(count($menu)>0){
							$cab="";
							$detmenu="";
							foreach($menu as $m){
								if($m['dcagrop']!=$cab){
									if($cab!=""){
								$detmenu.='	</ul>'.
										  '</li>';	
									}
								$detmenu.='<li id="nav-'.$m['dcagrop'].'" class="nav-sub">'.
										  '	<a> '.$m['dcagrop'].' <i class="icon-white icon-aba"></i></a>'.
										  '	<ul>';
								$cab=$m['dcagrop'];
								}
								$detmenu.='		<li id="'.$m['durlopc'].'"><a>'.$m['dopcion'].'</a></li>';
							}
								$detmenu.='	</ul>'.
										  '</li>';
						$_SESSION['SECON']['menu']=$detmenu;	
						}
				echo json_encode(array('rst'=>1,'msj'=>'Bienvenido al Sistema'));						                   
                }else{
					echo json_encode(array('rst'=>2,'msj'=>'Verifique Usuario y Contraseña'));
				}
				break;
			default:
                echo json_encode(array('rst'=>3,'msj'=>'Accion POST no encontrada'));
				break;
		}
	}
	public function doGet(){
		$daoLogin=creadorDAO::getLoginDAO();
		switch ($_GET['accion']) {
			default:
                echo json_encode(array('rst'=>3,'msj'=>'Accion GET no encontrada'));
				break;
		}	
	}
}
?>