<?
class MySqlInstitucionDAO{
    public function cargarFilial($array){
		$filial="";
		if($array['cfilial']!='' and substr($array['cfilial'],0,3)!='000'){
		$filial=" AND cfilial in ('".str_replace(",","','",$array['cfilial'])."')";
		}
        $sql="SELECT cfilial as id, dfilial as nombre 
			  FROM filialm 
			  WHERE cestado='1' 
			  ".$filial."
			  ORDER BY dfilial";
		$db=creadorConexion::crear('MySql');
        $db->setQuery($sql);
        $data=$db->loadObjectList();
        if(count($data)>0){
            return array('rst'=>'1','msj'=>'Filiales cargadas','data'=>$data);
        }else{
            return array('rst'=>'2','msj'=>'No existen Filiales','data'=>$data,'sql'=>$sql);
        }
    }

    public function cargarCiclo(){       
        $sql="Select cciclo as id,dciclo as nombre
              from cicloa 
              where cestado=1
              ORDER BY dciclo";
        $db=creadorConexion::crear('MySql');
        $db->setQuery($sql);
        $data=$db->loadObjectList();
        if(count($data)>0){
            return array('rst'=>'1','msj'=>'Filiales cargadas','data'=>$data);
        }else{
            return array('rst'=>'2','msj'=>'No existen Filiales','data'=>$data,'sql'=>$sql);
        }
    }
	
	public function cargarPensionG($array){
		$array['cfilial']=str_replace('\\','',$array['cfilial']);
        $array['ccarrer']=str_replace(',',"','",$array['ccarrer']);

        $sql="	SELECT concat(c.cconcep,'-',c.ncuotas,'-',c.cfilial) as id, concat(c.dconcep,' - ',c.ncuotas,'C - ',c.nprecio) as nombre,f.dfilial as titulo
				FROM concepp c 
				INNER JOIN filialm f on (f.cfilial=c.cfilial) 				
				WHERE c.cfilial in ('".$array['cfilial']."')
				AND c.cinstit='".$array['cinstit']."'
				AND (c.ccarrer='' or c.ccarrer in ('".$array['ccarrer']."'))
				AND c.cestado='1' 
				AND c.cctaing like '701.03%'			
				ORDER BY f.dfilial,c.dconcep";
        $db=creadorConexion::crear('MySql');
        $db->setQuery($sql);
        $data=$db->loadObjectList();
        if(count($data)>0){
            return array('rst'=>'1','msj'=>'Pensiones cargadas','data'=>$data,'sql'=>$sql);
        }else{
            return array('rst'=>'2','msj'=>'No existen Pensiones','data'=>$data,'sql'=>$sql);
        }
    }

    public function cargarSemestreG($array){
        $array['cfilial']=str_replace(',',"','",$array['cfilial']);
        $array['cinstit']=str_replace(',',"','",$array['cinstit']);
        $sql="  select CONCAT_WS(' | ',csemaca,cinicio) as id,CONCAT_WS(' | ',csemaca,cinicio) as nombre
                from semacan
                where cfilial in ('".$array['cfilial']."')
                and cinstit in ('".$array['cinstit']."')
                and cestado=1
                GROUP BY csemaca,cinicio
                ORDER BY csemaca,cinicio";
        $db=creadorConexion::crear('MySql');
        $db->setQuery($sql);
        $data=$db->loadObjectList();
        if(count($data)>0){
            return array('rst'=>'1','msj'=>'Semestres cargadas','data'=>$data,'sql'=>$sql);
        }else{
            return array('rst'=>'2','msj'=>'No existen Semestres','data'=>$data,'sql'=>$sql);
        }
    }

    public function cargarCarreraG($array){
        $array['cfilial']=str_replace(',',"','",$array['cfilial']);
        $array['cinstit']=str_replace(',',"','",$array['cinstit']);
        $sql="  select GROUP_CONCAT(DISTINCT(c.ccarrer)) as id,c.dcarrer as nombre
                from carrerm c
                inner join filcarp fc on (c.ccarrer=fc.ccarrer)
                where fc.cfilial in ('".$array['cfilial']."')
                and c.cinstit in ('".$array['cinstit']."')
                and c.cestado=1
                GROUP BY c.dcarrer
                order by c.dcarrer";
        $db=creadorConexion::crear('MySql');
        $db->setQuery($sql);
        $data=$db->loadObjectList();
        if(count($data)>0){
            return array('rst'=>'1','msj'=>'Carreras cargadas','data'=>$data,'sql'=>$sql);
        }else{
            return array('rst'=>'2','msj'=>'No existen Carreras','data'=>$data,'sql'=>$sql);
        }
    }
	
	public function cargarInstitucion($array){
		$instituto="";
		if($array['cinstit']!=''){
		$instituto=" AND cinstit='".$array['cinstit']."'";
		}
        $sql="SELECT cinstit as id, dinstit as nombre 
			  FROM instita 
			  where cestado='1' 
			  ".$instituto."
			  ORDER BY dinstit";
        $db=creadorConexion::crear('MySql');
        $db->setQuery($sql);
        $data=$db->loadObjectList();
        if(count($data)>0){
            return array('rst'=>'1','msj'=>'Intituciones cargadas','data'=>$data);
        }else{
            return array('rst'=>'2','msj'=>'No existe Instituciones','data'=>$data);
        }
    }
	
	public function ListarInstituto($array){
		$instituto="";
		if($array['cinstit']!=''){
		$instituto=" AND cinstit='".$array['cinstit']."'";
		}
        $sql="SELECT concat(cinstit,':',dinstit) as nombre 
			  FROM instita 
			  WHERE cestado='1' 
			  ".$instituto."
			  ORDER BY dinstit";
        $db=creadorConexion::crear('MySql');
        $db->setQuery($sql);
        $data=$db->loadObjectList();		
        if(count($data)>0){
			$cursos=" : ";
				foreach($data as $d){					
						$cursos.=";".$d['nombre'];
				}
            return array('rst'=>'1','msj'=>'Intituciones cargadas','data'=>$cursos);
        }else{
            return array('rst'=>'2','msj'=>'No existe Instituciones','data'=>$data);
        }
    }

    public function ListaBancos(){        
        $sql="SELECT concat(cbanco,':',dbanco) as nombre 
              FROM bancosm               
              ORDER BY dbanco";
        $db=creadorConexion::crear('MySql');
        $db->setQuery($sql);
        $data=$db->loadObjectList();        
        if(count($data)>0){
            $bancos=" : ";
                foreach($data as $d){                   
                        $bancos.=";".$d['nombre'];
                }
            return array('rst'=>'1','msj'=>'Intituciones cargadas','data'=>$bancos);
        }else{
            return array('rst'=>'2','msj'=>'No existe Bancos','data'=>$data);
        }
    }
	
	public function ListarDetalleGrupos($data){
	$db=creadorConexion::crear('MySql');
	$sql="select cr.cconcep,GROUP_CONCAT(cr.fvencim SEPARATOR '|') as fechas,concat(co.dconcep,' - ',co.ncuotas,'C - ',co.nprecio) as concepto
			from cropaga cr
      INNER JOIN gracprp g on (g.cgracpr=cr.cgruaca)
			INNER JOIN concepp co on (co.cconcep=cr.cconcep AND co.cestado='1' AND co.ccarrer IN ('',g.ccarrer) )
			where cr.cgruaca in 
			('".$data['cgracpr']."')
			GROUP BY cr.cconcep,cr.cgruaca";
	$db->setQuery($sql);
    $data=$db->loadObjectList();
        if(count($data)>0){
            return array('rst'=>'1','msj'=>'Cronogramas cargados','data'=>$data,"sql"=>$sql);
        }else{
            return array('rst'=>'2','msj'=>'No tiene Cronograma asignado','data'=>$data,"sql"=>$sql);
        }
	}
    
    public function ListarGrupos($data){
         $db=creadorConexion::crear('MySql');
        $carrera=str_replace(",", "','", $data['ccarrer']);
        $sql="
SELECT 
(SELECT c.dtitulo from curricm as c where c.ccurric = g.ccurric) as curricula,
(select f.dfilial from filialm as f where f.cfilial = g.cfilial) as filial,
(select i.dinstit from instita as i where i.cinstit = g.cinstit) as institucion,
(select cc.dciclo from cicloa as cc where cc.cciclo = g.cciclo  ) as ciclo,
(select ca.dcarrer from carrerm ca where ca.ccarrer = g.ccarrer) as carrera,
(select t.dturno from turnoa as t where t.cturno = g.cturno ) as turno,
(select CONCAT	(h.hinici,'-',h.hfin) from horam as h where h.chora = g.chora) as hora,
(
select GROUP_CONCAT(d.dnemdia SEPARATOR '-')
				from diasm d
				where FIND_IN_SET (d.cdia,replace(g.cfrecue,'-',','))  >  0
) as dias,
esg.desgrpr as gestado,
g.* 
from gracprp as g 
left join esgrpra as esg on esg.cesgrpr = g.cesgrpr
where 
cfilial in (".$data['cfilial'].") 
and cinstit = '".$data['cinstit']."'
and g.ccarrer in ('".$carrera."')
and g.csemaca = '".$data['csemaca']."'
and g.trgrupo='R' ";
    
        if($data["ccurric"]!= "")
            $sql.=" and g.ccurric = '".$data["ccurric"]."' ";
        
        if($data["cciclo"]!= "")
            $sql.=" and g.cciclo='".$data["cciclo"]."'  ";
		
		if($data["cinicio"]!= "")
            $sql.=" and g.cinicio='".$data["cinicio"]."'  ";
        
        if($data["cturno"]!= "")
            $sql.=" and g.cturno='".$data["cturno"]."'  ";
        
        if($data["chora"]!= "")
            $sql.=" and g.chora='".$data["chora"]."'  ";
        
        $db->setQuery($sql);
        $data=$db->loadObjectList();		
        if(count($data)>0){
            return array('rst'=>'1','msj'=>'Grupos cargados','data'=>$data,"sql"=>$sql);
        }else{
            return array('rst'=>'2','msj'=>'No existe grupos','data'=>$data,"sql"=>$sql);
        }
        
    }    
    
    public function getFechasSemetre($data){
         $db=creadorConexion::crear('MySql');
        
        $sql="
select date(finisem) as finisem,date(ffinsem) as ffinsem,
(select f.dfilial from filialm as f where f.cfilial = g.cfilial) as filial
from semacan as g
where 
g.cestado='1'
AND g.cfilial in (".$data['cfilial'].") 
and g.cinstit = '".$data['cinstit']."'
and g.cinicio = '".$data['cinicio']."'
and g.csemaca = '".$data['csemaca']."'
    GROUP BY g.finisem ";
    
       
        
        $db->setQuery($sql);
        $data=$db->loadObjectList();		
        if(count($data)>0){
            return array('rst'=>'1','msj'=>'Fechas cargados','data'=>$data,"sql"=>$sql);
        }else{
            return array('rst'=>'2','msj'=>'No existe fechas','data'=>$data,"sql"=>$sql);
        }
        
    }
    
    
    public function listarUsuarios($data){
         $db=creadorConexion::crear('MySql');
        
         $nombre = "";
         $paterno = "";
         $materno = "";
         $filiales = "";
         
         if($data["nombres"] != ''){
             $nombre = " and p.dnomper like '%".$data["nombres"]."%'  ";
         }
         
          
         if($data["paterno"] != ''){
             $paterno = " and p.dappape like '%".$data["paterno"]."%'  ";
         }
         
          $materno = "";
         if($data["materno"] != ''){
             $materno = " and p.dapmape like '%".$data["materno"]."%'  ";
         }
         
         if($data["cfilial"] != ''){
             $finsetins = "";
             $f = explode(",", $data["cfilial"]);
             $fin = array();
             foreach($f as $fi){
                 $fin[] = "FIND_IN_SET('$fi',g.cfiliales)";
             }
             $finsetins = implode(" or ", $fin);
             $filiales = " and ( $finsetins )  ";
         }
         $nivel = $_SESSION["SECON"]["dnivusu"];
         if(!$nivel){
             $nivelwhere = " and ( p.dnivusu = '' or p.dnivusu is null  ) ";
         }else{
             $nivelwhere = " and ( p.dnivusu <= $nivel or p.dnivusu is null )";
         }
             
         
         
        $sql="
select 
	p.cperson as cperson,
	p.dnomper AS nombres,
	p.dappape AS paterno,
	p.dapmape AS materno,
	p.dlogper AS login,
	p.dpasper AS clave,
	g.cfiliales,
	IFNULL(g.grupos,'(No registra Grupos)') as grupos
from personm p
left JOIN ( select
u.cperson as person, 
IFNULL(GROUP_CONCAT(f.cfilial SEPARATOR ','),'--') as cfiliales,
IFNULL(GROUP_CONCAT(CONCAT('(',f.dfilial,') ',g.dgrupo) SEPARATOR '<hr>'),'--') as grupos
from usugrup u
inner JOIN filialm f ON f.cfilial = u.cfilial
inner join grupom g on u.cgrupo = g.cgrupo where u.cestado = 1
group by u.cperson) as g on g.person = p.cperson
where 1 = 1 $nivelwhere
$filiales $nombre $paterno $materno ";
    
        $db->setQuery($sql);
        $data=$db->loadObjectList();		
        if(count($data)>0){
            return array('rst'=>'1','msj'=>'Usuarios cargados','data'=>$data,"count"=>count($data),"sql"=>$sql);
        }else{
            return array('rst'=>'2','msj'=>'No existe usuarios','data'=>$data,"sql"=>$sql);
        }
        
    }
    
    
    public function listarIndiceMatricula($data){
         $db=creadorConexion::crear('MySql');
        
         $nombre = "";
         $paterno = "";
         $materno = "";
         $filiales = "";
         
        
         
$cfilial=str_replace(",","','",$data['cfilial']);
$csemaca=$data['csemaca'];
$fechini=$data['fechini'];
$fechfin=$data['fechfin'];
$filtro="";
$filtro2="";
        if($csemaca!=''){
		$cinstit=$data['cinsiti'];
		$filtro=" g.csemaca='".$csemaca."' ";
		$filtro2=" AND g.cinstit='".$cinstit."'";
		}
		else{
		$cinstit=str_replace(",","','",$data['cinsiti']);		
		$filtro=" date(g.finicio) between '".$fechini."' and '".$fechfin."' ";
		$filtro2=" AND g.cinstit in ('".$cinstit."')";
		}
         
             
         
         
        $sql="	SELECT  f.dfilial,ins.dinstit,t.dturno,c.dcarrer,g.csemaca,g.cinicio,g.finicio,g.ffin,concat( 
				(select GROUP_CONCAT(d.dnemdia SEPARATOR '-') 
				from diasm d 
				where FIND_IN_SET (d.cdia,replace(g.cfrecue,'-',','))  >  0), 
				' de ',h.hinici,' - ',h.hfin) as horario,GROUP_CONCAT(distinct(g.cgracpr)) as id,
					(select count(*)
					from gracprp g2
					inner join conmatp co on (co.cgruaca=g2.cgracpr)
					where FIND_IN_SET (g2.cgracpr,GROUP_CONCAT(DISTINCT(g.cgracpr)))  >  0
					) as total,cu.dtitulo as dcurric,nmetmat,
					(select count(*)
					from gracprp g2
					inner join conmatp co on (co.cgruaca=g2.cgracpr)
					inner join (select r2.cingalu,r2.cgruaca
											from recacap r2	
											inner join concepp co2 on (co2.cconcep=r2.cconcep)
											inner join conmatp conm2 on (conm2.cingalu=r2.cingalu and conm2.cgruaca=r2.cgruaca)
											where (r2.ccuota='' or r2.ccuota=1)
											and r2.testfin='P'
											and co2.cctaing like '701.03%'
											and (IF(substring(conm2.dproeco,1,3)='Pro',(co2.mtoprom/2),co2.nprecio/2))>=r2.nmonrec
											GROUP BY r2.cgruaca,r2.cingalu
											) rec on (rec.cingalu=co.cingalu and rec.cgruaca=co.cgruaca)
					WHERE (FIND_IN_SET (g2.cgracpr,GROUP_CONCAT(g.cgracpr SEPARATOR ','))  >  0)					
					) as mayor,
					(select count(*)
					from gracprp g2
					inner join conmatp co on (co.cgruaca=g2.cgracpr)
					inner join (select r2.cingalu,r2.cgruaca
											from recacap r2	
											inner join concepp co2 on (co2.cconcep=r2.cconcep)
											inner join conmatp conm2 on (conm2.cingalu=r2.cingalu and conm2.cgruaca=r2.cgruaca)
											where (r2.ccuota='' or r2.ccuota=1)
											and r2.testfin='P'
											and co2.cctaing like '701.03%'
											and (IF(substring(conm2.dproeco,1,3)='Pro',(co2.mtoprom/2),co2.nprecio/2))<r2.nmonrec
											GROUP BY r2.cgruaca,r2.cingalu
											) rec on (rec.cingalu=co.cingalu and rec.cgruaca=co.cgruaca)
					WHERE (FIND_IN_SET (g2.cgracpr,GROUP_CONCAT(g.cgracpr SEPARATOR ','))  >  0)					
					) as menor
				FROM gracprp g 
				INNER JOIN curricm cu on (cu.ccurric=g.ccurric)
				INNER JOIN filialm f on (f.cfilial=g.cfilial)
				INNER JOIN instita ins on (ins.cinstit=g.cinstit)
				INNER JOIN turnoa t on (g.cturno=t.cturno) 
				INNER JOIN horam h on (h.chora=g.chora) 
				INNER JOIN carrerm c on (c.ccarrer=g.ccarrer) 
				WHERE ".$filtro." 
				".$filtro2."
				AND g.cfilial in ('".$cfilial."')
				AND g.cesgrpr in ('3','4')
				GROUP by g.csemaca,g.cfilial,g.cinstit,g.ccarrer,g.cciclo,g.cinicio,g.cfrecue,g.cturno,g.chora,g.finicio,g.ffin
				order by total desc,mayor desc,menor desc,c.dcarrer,g.cinicio,g.finicio";

    
        $db->setQuery($sql);
        $data=$db->loadObjectList();		
        if(count($data)>0){
            return array('rst'=>'1','msj'=>'Indices cargados','data'=>$data,"count"=>count($data),"sql"=>$sql);
        }else{
            return array('rst'=>'2','msj'=>'No se encontraron registros','data'=>$data,"sql"=>$sql);
        }
        
    }
    
    
    //Muestra los datos de un solo Usuario
    public function mostrarUsuarios($data){
         $db=creadorConexion::crear('MySql');
                
        $sql="
SELECT
	p.cperson,
	p.dnomper AS nombres,
	p.dappape AS paterno,
	p.dapmape AS materno,
	p.dlogper AS login,
	p.dpasper AS clave,
	u.cfilial,
	f.dfilial AS filial,
	u.cestado AS estado,
        u.cgrupo,
        p.dnivusu
        
FROM
usugrup u
right JOIN personm AS p ON p.cperson = u.cperson
left JOIN filialm f ON f.cfilial = u.cfilial
WHERE
1=1
AND p.cperson = '".$data["cperson"]."'  

order by p.cperson";
        
        $db->setQuery($sql);
        $data=$db->loadObjectList();		
        if(count($data)>0){
            $nuevadata = array();
            $cont = 0;
            foreach($data as  $value){
               foreach($value as $k => $v){  
                   if($k == "cgrupo")
                       $nuevadata["grupos"][$cont]["cgrupo"] = $v;
                   elseif($k == "cfilial")
                       $nuevadata["grupos"][$cont]["cfilial"] = $v;
                   else
                        $nuevadata[$k] = $v;
               
               }  
               //validando que no agrege los que estan en estado cero
               if($value["estado"] == 0){
                   unset($nuevadata["grupos"][$cont]);
               }
               $cont++;
            }
   
            return array('rst'=>'1','msj'=>'Datos de Usuario cargados','data'=>$nuevadata,"count"=>count($nuevadata),"sql"=>$sql);
        }else{
            return array('rst'=>'2','msj'=>'No es posible cargar los datos del usuario'.$sql ,'data'=>$data,"sql"=>$sql);
        }
        
    }
    
    public function cargarGrupos($data){
         $db=creadorConexion::crear('MySql');
        
        $sql="select cgrupo as id , dgrupo as nombre from grupom where cestado = 1 ";

        $db->setQuery($sql);
        $data=$db->loadObjectList();		
        if(count($data)>0){
            return array('rst'=>'1','msj'=>'Grupos cargados','data'=>$data,"sql"=>$sql);
        }else{
            return array('rst'=>'2','msj'=>'Grupos fechas','data'=>$data,"sql"=>$sql);
        }
 
    }
    
    public function actualizarUsuario($post){
       
	$msj = '';
        $db=creadorConexion::crear('MySql');
        
        //validando login de usuario que no se repita
        $sql = "select 1 from personm where dlogper = '".$post["login"]."' and cperson <>  '".$post["cperson"]."' limit 1";
        $db->setQuery($sql);
        $login=$db->loadObjectList();
        $clogin = count($login);
        if($clogin != 0){
            return array('rst'=>'3','msj'=>'El User "'.$post["login"].'" ya existe. Intente otro.','sql'=>$sql);exit();
        }
        
        
        
        $db->iniciaTransaccion();
        //1ro Actualizar login y password de cperson
        $sql = "update personm set 
            dlogper = '".$post["login"]."' , 
            dpasper = '".$post["clave"]."',
            dnivusu= '".$post["dnivusu"]."',
            fusuari = NOW(),
            cusuari = '".$post["cusuari"]."'
            where cperson = '".$post["cperson"]."'";
        
        $db->setQuery($sql);
        if( $db->executeQuery() ) {
            if(!MySqlTransaccionDAO::insertarTransaccion($sql,$post['cfilialx']) ){
                    $db->rollbackTransaccion();
                    return array('rst'=>'3','msj'=>'Error al Registrar Datos en transaccion','sql'=>$sql);exit();
            }
            $db->commitTransaccion();
            //return array('rst'=>'1','msj'=>'Usuario Actualizado',"sql"=>$sql);
            $msj .= "Datos cperson actualizado ";
        }else{
            $db->rollbackTransaccion();
            return array('rst'=>'3','msj'=>'Error al procesar Query update person '.$sql,"sql"=>$sql);
        }
        
        //Conseguimos los grupos existentes y en estado activo
        $grupos_antiguos = "select * from usugrup where cperson = '".$post["cperson"]."' and cestado = '1'";
        $db->setQuery($grupos_antiguos);
        $grupos_antiguos=$db->loadObjectList();
        $cant_grupos_antiguos = count($grupos_antiguos);
        
        
        //2do Registrando todos los roles de esa persona
        $cgrupos = explode("|",$post["cgrupos"]);
        $filiales = explode("|",$post["cfilial"]);
        $contador = 0;
        
            foreach($cgrupos as $grupo){
                
                //Primero Pregunto sino existe para recien insertarlo
                $grupos = "select * from usugrup where cperson = '".$post["cperson"]."' and cfilial = '".$filiales[$contador]."' and cgrupo = '$grupo'";
                $db->setQuery($grupos);
                $data=$db->loadObject();
                if(count($data) == 0){ //si no existe registrado empiezo la transaccion
                    $db->iniciaTransaccion();
                    $sql = "insert into usugrup set cperson='".$post["cperson"]."' , cfilial = '".$filiales[$contador]."', cgrupo = '$grupo', cestado = '1', fusuari = NOW() ,fingres = NOW() , cusuari = '".$post["cusuari"]."'";

                    $db->setQuery($sql);
                    if( $db->executeQuery() ) {
                        if(!MySqlTransaccionDAO::insertarTransaccion($sql,$post['cfilialx']) ){
                                $db->rollbackTransaccion();
                                return array('rst'=>'3','msj'=>'Error al Registrar Datos en transaccion','sql'=>$sql);exit();
                        }
                        $db->commitTransaccion();
                        //return array('rst'=>'1','msj'=>'Usuario Actualizado',"sql"=>$sql);
                        $msj .= " Datos cperson elimiados ";
                    }else{
                        $db->rollbackTransaccion();
                        return array('rst'=>'3','msj'=>'Error al procesar Query insert '.$sql,"sql"=>$sql);
                    }
                }//fin if(count($data) == 0){     
				else{
					$sql = "update usugrup 
							set cestado='1', fusuari = NOW() , cusuari = '".$post["cusuari"]."'
							WHERE cperson='".$post["cperson"]."'";

                    $db->setQuery($sql);
                    if( $db->executeQuery() ) {
                        if(!MySqlTransaccionDAO::insertarTransaccion($sql,$post['cfilialx']) ){
                                $db->rollbackTransaccion();
                                return array('rst'=>'3','msj'=>'Error al Registrar Datos en transaccion','sql'=>$sql);exit();
                        }
                        $db->commitTransaccion();
                        //return array('rst'=>'1','msj'=>'Usuario Actualizado',"sql"=>$sql);
                        $msj .= " Datos de persona elimiados ";
                    }else{
                        $db->rollbackTransaccion();
                        return array('rst'=>'3','msj'=>'Error al procesar Query insert '.$sql,"sql"=>$sql);
                    }
				} 
                $contador++;
            }
        
            //SI LOS ANTIGUOS NO ESTAN DENTRO DE LOS ENVIADOS CAMBIAR A CESTADO 0 CON FEGRES
            if($cant_grupos_antiguos > 0){
                $cant_g = count($cgrupos);
                $gactuales = array();
                for ($i = 0; $i < $cant_g ; $i++){
                    $gactuales[] = "'".$cgrupos[$i].$filiales[$i]."'";
                }    
                $gactualesin = implode(",", $gactuales);
                $where = "";
                if( $gactualesin != "" ){
                    $where = " and CONCAT(cgrupo,cfilial) not IN ($gactualesin) ";
                }
                
                $sql = "select * from usugrup where cperson = '".$post["cperson"]."' $where and cestado = 1";
              
                $db->setQuery($sql);
                $gantiguos=$db->loadObjectList();
                
                foreach ($gantiguos as $gantiguo) {
                    
                    //actualizando todos los antiguos
                    $db->iniciaTransaccion();
                    $sql = "update usugrup set  cestado = '0', fegreso = NOW() ,fusuari = NOW() , cusuari = '".$post["cusuari"]."'
                        where cperson = '".$gantiguo["cperson"]."' and cfilial = '".$gantiguo["cfilial"]."' and cgrupo = '".$gantiguo["cgrupo"]."' ";

                    $db->setQuery($sql);
                    if( $db->executeQuery() ) {
                        if(!MySqlTransaccionDAO::insertarTransaccion($sql,$post['cfilialx']) ){
                                $db->rollbackTransaccion();
                                return array('rst'=>'3','msj'=>'Error al actualizar los antiguos'.$sql,'sql'=>$sql);exit();
                        }
                        $db->commitTransaccion();
                        //return array('rst'=>'1','msj'=>'Usuario Actualizado',"sql"=>$sql);
                        $msj .= " Datos usugrup elimiados ";
                    }else{
                        $db->rollbackTransaccion();
                        return array('rst'=>'3','msj'=>'Error al procesar Query de actualizacion de antiguos '.$sql,"sql"=>$sql);
                    }  
                }    
            }
              
         if($msj != ""){
             return array('rst'=>'1','msj'=>'Usuario Actualizado');
         }   
            
    }
    
    public function ActualizarGrupo($post){
        
        $db=creadorConexion::crear('MySql');
        $db->iniciaTransaccion();
        //1ro Actualizar login y password de cperson
        $sql = "update gracprp set  cesgrpr = '".$post["ces"]."', fusuari = NOW(), cusuari = '".$post["cusuari"]."'  where cgracpr = '".$post["gru"]."'";
        
        $db->setQuery($sql);
        if( $db->executeQuery() ) {
            if(!MySqlTransaccionDAO::insertarTransaccion($sql,$post['cfilialx']) ){
                    $db->rollbackTransaccion();
                    return array('rst'=>'3','msj'=>'Error al Registrar Datos en transaccion','sql'=>$sql);exit();
            }
            $db->commitTransaccion();
            //return array('rst'=>'1','msj'=>'Usuario Actualizado',"sql"=>$sql);
            return array('rst'=>'1','msj'=>'Grupo Actualizado');
        }else{
            $db->rollbackTransaccion();
            return array('rst'=>'3','msj'=>'Error al procesar Query update person '.$sql,"sql"=>$sql);
        }
        
    }
    
}
?>