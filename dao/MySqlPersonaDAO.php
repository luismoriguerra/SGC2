<?
class MySqlPersonaDAO{
	
	public function ListarFiltro(){
		$db=creadorConexion::crear('MySql');
		$sql="	select upper(didetip) as id,upper(dtipcap) as nombre
				from tipcapa
				where cestado=1
				and dclacap=2
				order by dtipcap";
		$db->setQuery($sql);
        $data=$db->loadObjectList();
        if(count($data)>0){
            return array('rst'=>'1','msj'=>'Filtros cargados','data'=>$data);
        }else{
            return array('rst'=>'2','msj'=>'No existen Filtros','data'=>$data,'sql'=>$sql);
        }
	}

	public function cargarModalidadIngresoDocumento($data){
		$db=creadorConexion::crear('MySql');
		$sql="	SELECT concat_ws('-',treqcon,cmoding,dmoding) dato
			  FROM modinga 
			  WHERE cmoding='".$data['cmoding']."'";
		$db->setQuery($sql);
        $data=$db->loadObjectList();
        if(count($data)>0){
            return array('rst'=>'1','msj'=>'Filtros cargados','data'=>$data[0]['dato']);
        }else{
            return array('rst'=>'2','msj'=>'No existen Filtros','data'=>$data,'sql'=>$sql);
        }
	}
	
        
    public function ListarFiltrobyID(){
		$db=creadorConexion::crear('MySql');
		$sql="	select ctipcap as id,upper(dtipcap) as nombre
				from tipcapa
				where cestado=1
				and dclacap=2
				order by dtipcap";
		$db->setQuery($sql);
        $data=$db->loadObjectList();
        if(count($data)>0){
            return array('rst'=>'1','msj'=>'Filtros cargados','data'=>$data);
        }else{
            return array('rst'=>'2','msj'=>'No existen Filtros','data'=>$data,'sql'=>$sql);
        }
	}

	public function ListarCiclos(){
		$db=creadorConexion::crear('MySql');
		$sql="	select cciclo as id,dciclo as nombre
				from cicloa
				order by dciclo";
		$db->setQuery($sql);
        $data=$db->loadObjectList();
        if(count($data)>0){
            return array('rst'=>'1','msj'=>'Ciclos cargados','data'=>$data);
        }else{
            return array('rst'=>'2','msj'=>'No existen Ciclos','data'=>$data,'sql'=>$sql);
        }
	}

	public function ActProc($array){
        
        $db=creadorConexion::crear('MySql');

         $sql="	select *
				from aspralm
				where cingalu='".$array['cingalu']."'";
		$db->setQuery($sql);
        $data=$db->loadObjectList();
        if(count($data)==0){
            echo json_encode(array('rst'=>'2','msj'=>'No hay cursos asignados. Registre un nuevo curso para actualizar','data'=>$data)); exit();
        }


        $db->iniciaTransaccion();
        
        $sql = "update aspralm set  
        		dcarpro = '".$array["dcarpro"]."',
        		dinstpro = '".$array["dinstpro"]."',
        		fusuari = NOW(), cusuari = '".$array["cusuari"]."'  
        		WHERE cingalu = '".$array["cingalu"]."'";
        
        $db->setQuery($sql);
        if( $db->executeQuery() ) {
            if(!MySqlTransaccionDAO::insertarTransaccion($sql,$array['cfilialx']) ){
                    $db->rollbackTransaccion();
                    return array('rst'=>'3','msj'=>'Error al Registrar Datos en transaccion','sql'=>$sql);exit();
            }
            $db->commitTransaccion();
            //return array('rst'=>'1','msj'=>'Usuario Actualizado',"sql"=>$sql);
            return array('rst'=>'1','msj'=>'Datos Actualizado');
        }else{
            $db->rollbackTransaccion();
            return array('rst'=>'3','msj'=>'Error al procesar Query update ',"sql"=>$sql);
        }
        
    }

    public function RegistrarAsiCon($array){

        if($array['datos']==''){
            return array('rst'=>'2','msj'=>'Seleccione almenos 1 registro');exit();
        }
        
        $db=creadorConexion::crear('MySql');

        $db->iniciaTransaccion();
        $datos=array();
        $det=array();
        //nuevo_8_1_01_10000040_0130133_2_2_3_No Tiene_estado...
        //casicon,caspral,crescon,cciclo,ccurric,ccurso,'','','','',cestado        

        $datos=explode("^^",$array['datos']);
        for($i=0;$i<count($datos);$i++){
            $det=explode("_",$datos[$i]);
            if($det[0]=="nuevo"){
                $sql="Insert Into asiconm (crescon,ccurso,ccurric,caspral,cusuari,fusuari,cciclo)
                      Values ('".$det[2]."','".$det[5]."','".$det[4]."','".$det[1]."','".$array['cusuari']."',now(),'".$det[3]."')";
            }
            else{
                $sql="  UPDATE asiconm 
                        SET cciclo='".$det[3]."',
                        ccurric='".$det[4]."',
                        ccurso='".$det[5]."',
                        cusuari='".$array['cusuari']."',
                        fusuari=now(),
                        cestado='".$det[10]."'
                        WHERE casicon='".$det[0]."'";
            }
        
            $db->setQuery($sql);
            if( $db->executeQuery() ) {
                if(!MySqlTransaccionDAO::insertarTransaccion($sql,$array['cfilialx']) ){
                        $db->rollbackTransaccion();
                        return array('rst'=>'3','msj'=>'Error al Registrar Datos en transaccion','sql'=>$sql);exit();
                }               
            }else{
                $db->rollbackTransaccion();
                return array('rst'=>'3','msj'=>'Error al procesar Query update ',"sql"=>$sql);exit();
            }

        }

        $db->commitTransaccion();        
        return array('rst'=>'1','msj'=>'Datos Actualizado');
        
    }    

    public function editProcedencia($array){
        
        $db=creadorConexion::crear('MySql');
        
        
        $sql="	select *
				from aspralm
				where daspral='".$array['daspral']."'
				AND cciclo='".$array['cciclo']."'
				AND cingalu='".$array['cingalu']."'
				AND caspral!='".$array['caspral']."'";
		$db->setQuery($sql);
        $data=$db->loadObjectList();
        if(count($data)>0){
            echo json_encode(array('rst'=>'2','msj'=>'Curso de Procedencia ya registrada','data'=>$data)); exit();
        }

        $db->iniciaTransaccion();

        $sql = "update aspralm set  
        		daspral = '".$array["daspral"]."',
        		cciclo = '".$array["cciclo"]."',
        		ncredit = '".$array["ncredit"]."',
        		nhorteo = '".$array["nhorteo"]."',
        		nhorpra = '".$array["nhorpra"]."',
        		cestado = '".$array["cestado"]."',
        		fusuari = NOW(), cusuari = '".$array["cusuari"]."'  
        		WHERE caspral = '".$array["caspral"]."'";
        
        $db->setQuery($sql);
        if( $db->executeQuery() ) {
            if(!MySqlTransaccionDAO::insertarTransaccion($sql,$array['cfilialx']) ){
                    $db->rollbackTransaccion();
                    return array('rst'=>'3','msj'=>'Error al Registrar Datos en transaccion','sql'=>$sql);exit();
            }
            $db->commitTransaccion();
            //return array('rst'=>'1','msj'=>'Usuario Actualizado',"sql"=>$sql);
            return array('rst'=>'1','msj'=>'se Actualizo correctamente');
        }else{
            $db->rollbackTransaccion();
            return array('rst'=>'3','msj'=>'Error al procesar Query update ',"sql"=>$sql);
        }
        
    }

    public function addProcedencia($array){
        
        $db=creadorConexion::crear('MySql');
        
        
        $sql="	select *
				from aspralm
				where daspral='".$array['daspral']."'
				AND cciclo='".$array['cciclo']."'
				AND cingalu='".$array['cingalu']."'";
		$db->setQuery($sql);
        $data=$db->loadObjectList();
        if(count($data)>0){
            echo json_encode(array('rst'=>'2','msj'=>'Curso de Procedencia ya registrada','data'=>$data)); exit();
        }

        $sql="	select *
				from aspralm
				where cingalu='".$array['cingalu']."'
				and dcarpro!=''";
		$db->setQuery($sql);
        $data=$db->loadObjectList();

        if(count($data)>0){
            $array['dcarpro']=$data[0]['dcarpro'];
            $array['dinstpro']=$data[0]['dinstpro'];
        }
        


        $db->iniciaTransaccion();

        $sql = "Insert Into aspralm (cingalu,daspral,cciclo,ncredit,nhorteo,nhorpra,fusuari,cusuari,dinstpro,dcarpro,csilabo)
        		Values ('".$array["cingalu"]."','".$array["daspral"]."','".$array["cciclo"]."','".$array["ncredit"]."','".$array["nhorteo"]."','".$array["nhorpra"]."',NOW(),'".$array["cusuari"]."','".$array['dinstpro']."','".$array['dcarpro']."','')";
        
        $db->setQuery($sql);
        if( $db->executeQuery() ) {
            if(!MySqlTransaccionDAO::insertarTransaccion($sql,$array['cfilialx']) ){
                    $db->rollbackTransaccion();
                    return array('rst'=>'3','msj'=>'Error al Registrar Datos en transaccion','sql'=>$sql);exit();
            }
            $db->commitTransaccion();
            //return array('rst'=>'1','msj'=>'Usuario Actualizado',"sql"=>$sql);
            return array('rst'=>'1','msj'=>'Se Registro correctamente');
        }else{
            $db->rollbackTransaccion();
            return array('rst'=>'3','msj'=>'Error al procesar Query insert ',"sql"=>$sql);
        }
        
    }

    public function guardarResolucion($array){
        
        $db=creadorConexion::crear('MySql');
        
        
        $sql="	select *
				from resconm
				where nrescon='".$array['nrescon']."'";
		$db->setQuery($sql);
        $data=$db->loadObjectList();
        if(count($data)>0){
            echo json_encode(array('rst'=>'2','msj'=>'Resolucion ya registrada','data'=>$data)); exit();
        }

        $db->iniciaTransaccion();

        $sql = "Insert Into resconm (cingalu,nrescon,dautres,frescon,fusuari,cusuari)
        		Values ('".$array["cingalu"]."','".$array["nrescon"]."','".$array["dautres"]."','".$array["frescon"]."',NOW(),'".$array["cusuari"]."')";
        
        $db->setQuery($sql);
        if( $db->executeQuery() ) {
            if(!MySqlTransaccionDAO::insertarTransaccion($sql,$array['cfilialx']) ){
                    $db->rollbackTransaccion();
                    return array('rst'=>'3','msj'=>'Error al Registrar Datos en transaccion','sql'=>$sql);exit();
            }
            $db->commitTransaccion();
            //return array('rst'=>'1','msj'=>'Usuario Actualizado',"sql"=>$sql);
            return array('rst'=>'1','msj'=>'Se Registro correctamente');
        }else{
            $db->rollbackTransaccion();
            return array('rst'=>'3','msj'=>'Error al procesar Query insert ',"sql"=>$sql);
        }
        
    }

    public function editarResolucion($array){
        
        $db=creadorConexion::crear('MySql');
        
        
        $sql="	select *
				from resconm
				where nrescon='".$array['nrescon']."'
				AND crescon!='".$array['crescon']."'";
		$db->setQuery($sql);
        $data=$db->loadObjectList();
        if(count($data)>0){
            echo json_encode(array('rst'=>'2','msj'=>'Resolucion ya registrada','data'=>$data)); exit();
        }

        $db->iniciaTransaccion();

        $sql = "update resconm set  
        		nrescon = '".$array["nrescon"]."',
        		dautres = '".$array["dautres"]."',
        		frescon = '".$array["frescon"]."',
        		fusuari = NOW(), cusuari = '".$array["cusuari"]."'  
        		WHERE crescon = '".$array["crescon"]."'";
        
        $db->setQuery($sql);
        if( $db->executeQuery() ) {
            if(!MySqlTransaccionDAO::insertarTransaccion($sql,$array['cfilialx']) ){
                    $db->rollbackTransaccion();
                    return array('rst'=>'3','msj'=>'Error al Registrar Datos en transaccion','sql'=>$sql);exit();
            }
            $db->commitTransaccion();
            //return array('rst'=>'1','msj'=>'Usuario Actualizado',"sql"=>$sql);
            return array('rst'=>'1','msj'=>'se Actualizo correctamente');
        }else{
            $db->rollbackTransaccion();
            return array('rst'=>'3','msj'=>'Error al procesar Query update ',"sql"=>$sql);
        }
        
    }

	public function ListarProc($array){
		$db=creadorConexion::crear('MySql');
		$sql="	select dcarpro,dinstpro
				from aspralm
				WHERE cingalu='".$array['cingalu']."'
				and dcarpro!=''";
		$db->setQuery($sql);
        $data=$db->loadObjectList();
        if(count($data)>0){
            return array('rst'=>'1','msj'=>'Procedencias cargados','data'=>$data[0]['dcarpro']."-".$data[0]['dinstpro']);
        }else{
            return array('rst'=>'2','msj'=>'No existen Procedencias','data'=>$data,'sql'=>$sql);
        }
	}

	public function ListarResolucion($array){
		$db=creadorConexion::crear('MySql');
		$sql="	select concat_WS('_',crescon,nrescon,dautres,date(frescon)) as id, 
						concat('Nro Resolución: ',nrescon,' Autoriza: ',dautres,' Fecha Resolución:',date(frescon)) as nombre
				from resconm
				WHERE cingalu='".$array['cingalu']."'";
		$db->setQuery($sql);
        $data=$db->loadObjectList();
        if(count($data)>0){
            return array('rst'=>'1','msj'=>'Resoluciones cargados','data'=>$data);
        }else{
            return array('rst'=>'2','msj'=>'No existen Resoluciones','data'=>$data,'sql'=>$sql);
        }
	}

    public function ListarCursoDestino($array){
        $db=creadorConexion::crear('MySql');
        $sql="  SELECT CONCAT(p.cciclo,'-',p.ccurric,'_',p.ccurso,'_',p.nhotecu,'_',p.nhoprcu,'_',p.ncredit,'_',
                CASE WHEN IFNULL(p.`durlsil`,'')!='' THEN 'Tiene'
                ELSE 'No Tiene'
                END)  AS id, cu.`dcurso` AS nombre
                FROM placurp p
                INNER JOIN cicloa c ON (c.`cciclo`=p.`cciclo`)
                INNER JOIN cursom cu ON (cu.`ccurso`=p.ccurso)
                WHERE p.cestado='1'
                AND p.ccurric IN (SELECT ccurric FROM ingalum WHERE cingalu='".$array['cingalu']."')
                ORDER BY p.`cciclo`,cu.`dcurso`";
        $db->setQuery($sql);
        $data=$db->loadObjectList();
        if(count($data)>0){
            return array('rst'=>'1','msj'=>'Cursos cargados','data'=>$data);
        }else{
            return array('rst'=>'2','msj'=>'No existen Cursos','data'=>$data,'sql'=>$sql);
        }
    }

    

    public function listarCursoProcedencia($array){
        $db=creadorConexion::crear('MySql');
        $data=array();
        if($array['crescon']!=''){

            $sql="  SELECT asi.`caspral`,c.dciclo,asi.daspral,asi.`ncredit`,asi.`nhorteo`,asi.`nhorpra`, ifnull(a.cciclo,'') as cciclo, ifnull(a.casicon,'') as casicon,
                    CASE WHEN asi.csilabo!='' THEN 'Tiene'
                    ELSE 'No Tiene'
                    END AS 'silabo',CONCAT(ifnull(a.cciclo,''),'-',IFNULL(a.ccurric,''),'_',IFNULL(a.ccurso,'')) AS idg
                    FROM aspralm asi
                    INNER JOIN cicloa c ON (c.cciclo=asi.cciclo)
                    LEFT JOIN asiconm a ON (a.`caspral`=asi.caspral AND a.`crescon`='".$array['crescon']."' AND a.`cestado`='1')
                    WHERE asi.`cingalu`='".$array['cingalu']."'
                    AND asi.`cestado`='1'
                    ORDER BY asi.`cciclo`,asi.`caspral`;";
            $db->setQuery($sql);
            $data=$db->loadObjectList();
        }

        if(count($data)>0){
            return array('rst'=>'1','msj'=>'CursosProcedencia cargados','data'=>$data);
        }else{
            return array('rst'=>'2','msj'=>'No existen CursosProcedencia','data'=>$data,'sql'=>$sql);
        }
    }   
	
	
	public function ListarVendedor($array){
		$db=creadorConexion::crear('MySql');
		$where="";
		if($array['dapepat']!=''){
		$where.=" AND v.dapepat like '%".$array['dapepat']."%'";
		}
		if($array['dapemat']!=''){
		$where.=" AND v.dapemat like '%".$array['dapemat']."%'";
		}
		if($array['dnombre']!=''){
		$where.=" AND v.dnombre like '%".$array['dnombre']."%'";
		}
		if($array['tvended']!=''){
		$where.=" AND v.tvended like '%".$array['tvended']."%'";
		}
		$sql="	select v.dapemat,v.dapepat,v.dnombre,v.ndocper,v.dtelefo,v.demail,v.ddirecc,
				(select u.nombre from ubigeo u 
				where u.coddpto=v.coddpto and u.codprov=v.codprov and u.coddist=v.coddist) as distrito,
				v.fingven,t.dtipcap as tvended,v.codintv
				from vendedm v
				inner join tipcapa t on (v.tvended=t.didetip and t.dclacap=2)
				WHERE v.cestado = 1 ".$where;
		$db->setQuery($sql);
        $data=$db->loadObjectList();
        if(count($data)>0){
            return array('rst'=>'1','msj'=>'Filtros cargados','data'=>$data);
        }else{
            return array('rst'=>'2','msj'=>'No existen Filtros','data'=>$data,'sql'=>$sql);
        }
	}

	public function JQGridCountPersonaIngAlum($where){
		$db=creadorConexion::crear('MySql');
		$sql="SELECT count(*) as count 
			FROM personm p 
            INNER JOIN ingalum i ON (p.cperson=i.cperson)
            LEFT JOIN vendedm v ON (v.cvended=i.cpromot)
            LEFT JOIN (SELECT cmedpre,dmedpre FROM medprea GROUP BY cmedpre) m ON (m.cmedpre=i.cmedpre)
            INNER JOIN postulm po ON (po.cingalu=i.cingalu)
            INNER JOIN vendedm ve ON (ve.cvended=po.crecepc)
            INNER JOIN tipcapa t    ON (i.ctipcap   = t.ctipcap)
            INNER JOIN modinga mo ON (mo.cmoding=i.cmoding)
            INNER JOIN conmatp c ON (c.cingalu=i.cingalu)
            INNER JOIN gracprp g ON (g.cgracpr=c.cgruaca)
            INNER JOIN carrerm ca ON (ca.ccarrer=g.ccarrer)
            INNER JOIN filialm f ON (f.cfilial=g.cfilial)
            INNER JOIN instita ins ON (ins.cinstit=g.cinstit)
            INNER JOIN horam h ON (h.chora  = g.chora)
            WHERE i.cingalu IS NOT NULL 
			$where";
		$db->setQuery($sql);
		$data=$db->loadObjectList();
		if( count($data)>0 ){
            return $data;
        }else{
            return array(array('COUNT'=>0));
        }
	}
	
	public function JQGRIDRowsPersonaIngAlum ( $sidx, $sord, $start, $limit, $where) {
	$sql="	SELECT i.cingalu,p.cperson,p.dnomper,p.dappape,p.dapmape,p.ndniper,ca.dcarrer,g.csemaca,f.dfilial,ins.dinstit,g.cgracpr,g.cinicio,DATE(g.finicio) finicio,
            CONCAT( (SELECT GROUP_CONCAT(d.dnemdia SEPARATOR '-') FROM diasm d WHERE FIND_IN_SET (d.cdia,REPLACE(g.cfrecue,'-',','))  >  0),' de ' ,h.hinici,'-',h.hfin) AS dhorari,
            IF(i.cestado='1','Activo','Retirado') AS cestado,
            i.nfotos,i.certest,i.sermatr,i.partnac,i.dcodlib,i.fotodni,i.otrodni,i.cpais,i.tinstip,i.dinstip,i.dcarrep,i.ultanop,i.dciclop,i.ddocval,i.cmoding,i.cdevolu,i.fdevolu,mo.dmoding
            ,t.dtipcap
            ,t.dclacap
            ,CONCAT(ve.dapepat,' ',ve.dapemat,', ',ve.dnombre)  AS recepcionista
            ,IF(i.cpromot!='',CONCAT(v.dapepat,' ',v.dapemat,', ',v.dnombre),
                IF(i.cmedpre!='', m.dmedpre,
                    IF(i.destica!='',i.destica,''))) AS detalle_captacion, 
            IFNULL(v.codintv,'') as codintv
            FROM personm p 
            INNER JOIN ingalum i ON (p.cperson=i.cperson)
            LEFT JOIN vendedm v ON (v.cvended=i.cpromot)
            LEFT JOIN (SELECT cmedpre,dmedpre FROM medprea GROUP BY cmedpre) m ON (m.cmedpre=i.cmedpre)
            INNER JOIN postulm po ON (po.cingalu=i.cingalu)
            INNER JOIN vendedm ve ON (ve.cvended=po.crecepc)
            INNER JOIN tipcapa t    ON (i.ctipcap   = t.ctipcap)
            INNER JOIN modinga mo ON (mo.cmoding=i.cmoding)
            INNER JOIN conmatp c ON (c.cingalu=i.cingalu)
            INNER JOIN gracprp g ON (g.cgracpr=c.cgruaca)
            INNER JOIN carrerm ca ON (ca.ccarrer=g.ccarrer)
            INNER JOIN filialm f ON (f.cfilial=g.cfilial)
            INNER JOIN instita ins ON (ins.cinstit=g.cinstit)
            INNER JOIN horam h ON (h.chora  = g.chora)
            WHERE i.cingalu IS NOT NULL
			 $where
            ORDER BY $sidx $sord
            LIMIT $start , $limit ";
        $db=creadorConexion::crear('MySql');
        $db->setQuery($sql);
        $data=$db->loadObjectList();
        return $data;
    }
	public function JQGridCountPersonaConcepto($where){
		$db=creadorConexion::crear('MySql');
		$sql="SELECT count(*) as count 
			FROM personm p left join ingalum i on (p.cperson=i.cperson )
			inner join conmatp c on (c.cingalu=i.cingalu)
			inner join gracprp g on (g.cgracpr=c.cgruaca)
			inner join carrerm ca on (ca.ccarrer=g.ccarrer)
			inner join filialm f on (f.cfilial=g.cfilial)
			inner join instita ins on (ins.cinstit=g.cinstit)
			inner join recacap r on (r.cingalu=i.cingalu)
			inner join concepp con on (con.cconcep=r.cconcep)
			inner join bitacop b on (b.cingalu=c.cingalu and b.cgracpr=c.cgruaca)
			WHERE i.cingalu is not null 
			AND con.cctaing='707.09.01' 
			$where";
		$db->setQuery($sql);
		$data=$db->loadObjectList();
		if( count($data)>0 ){
            return $data;
        }else{
            return array(array('COUNT'=>0));
        }
	}
	
	public function JQGRIDRowsPersonaConcepto( $sidx, $sord, $start, $limit, $where) {
	$sql="	SELECT concat(i.cingalu,IF(FIND_IN_SET(r.crecaca,b.crecaca)>0,r.crecaca,'')) as cingalu ,p.cperson,p.dnomper,p.dappape,p.dapmape,p.ndniper,ca.dcarrer,g.csemaca,f.dfilial,ins.dinstit,g.cgracpr,g.cinicio,date(g.finicio) finicio,
			IF(FIND_IN_SET(r.crecaca,b.crecaca)>0,r.nmonrec,
				IF((IFNULL(b.traspas,0)=0),concat('',b.retensi),concat('',b.traspas))
			) as nmonrec,
			con.cconcep,con.dconcep,r.crecaca,
			if(i.cestado='1','Activo','Retirado') as cestado,
			if(FIND_IN_SET(r.crecaca,b.crecaca)>0 or b.cestado='1','Devuelto','Pendiente') as cestado_b
			from personm p left join ingalum i on (p.cperson=i.cperson)
			inner join conmatp c on (c.cingalu=i.cingalu)
			inner join gracprp g on (g.cgracpr=c.cgruaca)
			inner join carrerm ca on (ca.ccarrer=g.ccarrer)
			inner join filialm f on (f.cfilial=g.cfilial)
			inner join instita ins on (ins.cinstit=g.cinstit)
			inner join recacap r on (r.cingalu=i.cingalu)
			inner join concepp con on (con.cconcep=r.cconcep)
			inner join bitacop b on (b.cingalu=c.cingalu and b.cgracpr=c.cgruaca)
			WHERE i.cingalu is not null 
			AND con.cctaing='707.09.01' 
			AND r.testfin='S' 
			 $where
            ORDER BY $sidx $sord
            LIMIT $start , $limit ";
        $db=creadorConexion::crear('MySql');
        $db->setQuery($sql);
        $data=$db->loadObjectList();
        
        return $data;
    }

	public function InsertarPersona($data){
	$db=creadorConexion::crear('MySql');
	$sql="Select * from personm
		 where (upper(dnomper)='".strtoupper($data['dnomper'])."'
		 and upper(dappape)='".strtoupper($data['dappape'])."'
		 and upper(dapmape)='".strtoupper($data['dapmape'])."')
		 	or (ndniper='".$data['ndniper']."')";
	$db->setQuery($sql);
    $valsql=$db->loadObjectList();
		if(count($valsql)>0){
		return array('rst'=>'2','msj'=>$data['dappape']." ".$data['dapmape'].", ".$data['dnomper']." ó Dni:".$data['ndniper']." existe");exit();
		}
		else{
		$cperson=$db->generarCodigo('personm','cperson',11,$data['cusuari']);
		$sql="Insert Into personm (cfilial,cperson,dnomper,dappape,dapmape,ndniper,email1,ntelpe2,ntelper,ntellab,dtipsan,tipdocper,fnacper,tsexo,coddpto,codprov,coddist,ddirper,ddirref,cdptlab,cprvlab,cdislab,cdptcol,cprvcol,cdiscol,ddirlab,dnomlab,tcolegi,dcolpro,fusuari,cusuari,ttiptra)
			  values ('".$data['cfilial']."','".$cperson."','".$data['dnomper']."',
				'".$data['dappape']."',
				'".$data['dapmape']."',
				'".$data['ndniper']."',
				'".$data['email1']."',
				'".$data['ntelpe2']."',
				'".$data['ntelper']."',
				'".$data['ntellab']."',
				'".$data['cestciv']."',
				'".$data['tipdocper']."',
				'".$data['fnacper']."',
				'".$data['tsexo']."',
				'".$data['coddpto']."',
				'".$data['codprov']."',
				'".$data['coddist']."',
				'".$data['ddirper']."',
				'".$data['ddirref']."',
				'".$data['cdptlab']."',
				'".$data['cprvlab']."',
				'".$data['cdislab']."',
				'".$data['cdptcol']."',
				'".$data['cprvcol']."',
				'".$data['cdiscol']."',
				'".$data['ddirlab']."',
				'".$data['dnomlab']."',
				'".$data['tcolegi']."',
				'".$data['dcolpro']."',
				now(),'".$data['cusuari']."','I')";	
		$db->iniciaTransaccion();
		$db->setQuery($sql);
			if(!$db->executeQuery()){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos'.$sql);exit();
			}
			else{
				$transa="INSERT INTO transam (transaccion,fecha,cfilial) Values('".addslashes($sql)."',now(),'".$data['cfilial']."')";
				$db->setQuery($transa);
					if(!$db->executeQuery()){
						$db->rollbackTransaccion();
						return array('rst'=>'3','msj'=>'Error al Registrar Datos'.$transa);exit();
					}
				$db->commitTransaccion();
				return array('rst'=>'1','msj'=>'Persona ingresada correctamente','id'=>$cperson);exit();
			}
		}
	}
	
	public function ActualizarPersona($data){
	$db=creadorConexion::crear('MySql');
	$sql="Select * from personm
		 where ((upper(dnomper)='".strtoupper($data['dnomper'])."'
		 and upper(dappape)='".strtoupper($data['dappape'])."'
		 and upper(dapmape)='".strtoupper($data['dapmape'])."')
		 	or (ndniper='".$data['ndniper']."'))
		 and cperson!='".$data['cperson']."'";
	$db->setQuery($sql);
    $valsql=$db->loadObjectList();
		if(count($valsql)>0){
		return array('rst'=>'2','msj'=>$data['dappape']." ".$data['dapmape'].", ".$data['dnomper']." ó Dni:".$data['ndniper']." existe");exit();
		}
		else{
		$sql="	UPDATE personm SET
				dnomper='".$data['dnomper']."',
				dappape='".$data['dappape']."',
				dapmape='".$data['dapmape']."',
				ndniper='".$data['ndniper']."',
				email1='".$data['email1']."',
				ntelpe2='".$data['ntelpe2']."',
				ntelper='".$data['ntelper']."',
				ntellab='".$data['ntellab']."',
				dtipsan='".$data['cestciv']."',
				tipdocper='".$data['tipdocper']."',
				fnacper='".$data['fnacper']."',
				tsexo='".$data['tsexo']."',
				coddpto='".$data['coddpto']."',
				codprov='".$data['codprov']."',
				coddist='".$data['coddist']."',
				ddirper='".$data['ddirper']."',
				ddirref='".$data['ddirref']."',
				cdptlab='".$data['cdptlab']."',
				cprvlab='".$data['cprvlab']."',
				cdislab='".$data['cdislab']."',
				cdptcol='".$data['cdptcol']."',
				cprvcol='".$data['cprvcol']."',
				cdiscol='".$data['cdiscol']."',
				ddirlab='".$data['ddirlab']."',
				dnomlab='".$data['dnomlab']."',
				tcolegi='".$data['tcolegi']."',
				dcolpro='".$data['dcolpro']."',
				cusuari='".$data['cusuari']."',
				fusuari=now(),
				ttiptra='M'
				WHERE cperson='".$data['cperson']."'";
		$db=creadorConexion::crear('MySql');
		$db->iniciaTransaccion();
		$db->setQuery($sql);
			if(!$db->executeQuery()){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos');exit();
			}
			else{
				$transa="INSERT INTO transam (transaccion,fecha,cfilial) Values('".addslashes($sql)."',now(),'".$data['cfilial']."')";
				$db->setQuery($transa);
					if(!$db->executeQuery()){
						$db->rollbackTransaccion();
						return array('rst'=>'3','msj'=>'Error al Registrar Datos'.$transa);exit();
					}
				$db->commitTransaccion();
				return array('rst'=>'1','msj'=>'Persona actualizada correctamente','id'=>$data['cperson']);exit();
			}
		}
	}
	
	public function JQGridCountPersona($where){
		$db=creadorConexion::crear('MySql');
                 $nivel = $_SESSION["SECON"]["dnivusu"];
         if(!$nivel){
             $nivelwhere = " and ( p.dnivusu = '' or p.dnivusu is null  ) ";
         }else{
             $nivelwhere = " and ( p.dnivusu <= $nivel or p.dnivusu is null )";
         }
                
		$sql="SELECT count(*) as count FROM personm p
			WHERE 1=1 $where $nivelwhere ";
		$db->setQuery($sql);
		$data=$db->loadObjectList();
		if( count($data)>0 ){
            return $data;
        }else{
            return array(array('COUNT'=>0));
        }
	}
	
	public function JQGRIDRowsPersona ( $sidx, $sord, $start, $limit, $where) {
            
            $nivel = $_SESSION["SECON"]["dnivusu"];
         if(!$nivel){
             $nivelwhere = " and ( p.dnivusu = '' or p.dnivusu is null  ) ";
         }else{
             $nivelwhere = " and ( p.dnivusu <= $nivel or p.dnivusu is null )";
         }
            
	$sql="	select p.cfilial,p.cperson,p.dnomper,p.dappape,p.dapmape,p.email1,p.ntelpe2,p.ntelper,p.ntellab,
			p.dtipsan as cestciv,p.tipdocper,p.ndniper,p.fnacper,p.tsexo,p.coddpto,p.codprov,p.coddist,
			p.ddirper,p.ddirref,p.cdptlab,p.cprvlab,p.cdislab,p.cdptcol,p.cprvcol,p.cdiscol,p.ddirlab,p.dnomlab,p.tcolegi,p.dcolpro,
			(select u.nombre from ubigeo u where u.codprov=0 and u.coddist=0 and u.coddpto=p.coddpto GROUP BY u.coddpto) as ddepart,	
			(select u.nombre from ubigeo u where u.codprov!=0 and u.coddist=0 and u.coddpto=p.coddpto and u.codprov=p.codprov GROUP BY u.codprov) as dprovin,
			(select u.nombre from ubigeo u where u.codprov!=0 and u.coddist!=0 and u.coddpto=p.coddpto and u.codprov=p.codprov and u.coddist=p.coddist GROUP BY u.coddist) as ddistri,
			(select u.nombre from ubigeo u where u.codprov=0 and u.coddist=0 and u.coddpto=p.cdptlab GROUP BY u.coddpto) as depalab,
			(select u.nombre from ubigeo u where u.codprov!=0 and u.coddist=0 and u.coddpto=p.cdptlab and u.codprov=p.cprvlab GROUP BY u.codprov) as provlab,
			(select u.nombre from ubigeo u where u.codprov!=0 and u.coddist!=0 and u.coddpto=p.cdptlab and u.codprov=p.cprvlab and u.coddist=p.cdislab GROUP BY u.coddist) as distlab
			from personm p		
			WHERE 1=1 $where $nivelwhere
            ORDER BY $sidx $sord
            LIMIT $start , $limit ";
        $db=creadorConexion::crear('MySql');
        $db->setQuery($sql);
        $data=$db->loadObjectList();
        
        return $data;
    }
	
	public function InsertarTrabajador($data){
	$db=creadorConexion::crear('MySql');
    $sql="Select * from vendedm
         where codintv='".$data['codintv']."'
         and upper(tvended)='".strtoupper($data['tvended'])."'";
    $db->setQuery($sql);
    $valsql=$db->loadObjectList();
        if(count($valsql)>0){
        return array('rst'=>'2','msj'=>" Cod Int:".$data['codintv']." existe");exit();
        }
		else{
		$cperson=$db->generarCodigo('vendedm','cvended',11,$data['cusuari']);
		$sql="Insert Into vendedm (cfilial,cvended,dnombre,dapepat,dapemat,ndocper,demail,tdocper,fingven,fretven,tsexo,coddpto,codprov,coddist,ddirecc,tvended,cinstit,codintv,dtelefo,fusuari,cusuari,ttiptra,cestado,copeven)
			  values ('".$data['cfilial']."','".$cperson."','".$data['dnombre']."',
				'".$data['dapepat']."',
				'".$data['dapemat']."',
				'".$data['ndocper']."',
				'".$data['demail']."',
				'".$data['tdocper']."',
				'".$data['fingven']."',
                '".$data['fretven']."',
				'".$data['tsexo']."',
				'".$data['coddpto']."',
				'".$data['codprov']."',
				'".$data['coddist']."',
				'".$data['ddirecc']."',
				'".$data['tvended']."',
				'".$data['cinstit']."',
				'".$data['codintv']."',
				'".$data['dtelefo']."',
				now(),'".$data['cusuari']."','I',
				'".$data['cestado']."' , '".$data['copeven']."')";	
		$db->iniciaTransaccion();
		$db->setQuery($sql);
			if(!$db->executeQuery()){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos'.$sql);exit();
			}
			else{
				$transa="INSERT INTO transam (transaccion,fecha,cfilial) Values('".addslashes($sql)."',now(),'".$data['cfilial']."')";
				$db->setQuery($transa);
					if(!$db->executeQuery()){
						$db->rollbackTransaccion();
						return array('rst'=>'3','msj'=>'Error al Registrar Datos'.$transa);exit();
					}
				$db->commitTransaccion();
				return array('rst'=>'1','msj'=>'Persona ingresada correctamente');exit();
			}
		}
	}
	
	public function ActualizarTrabajador($data){
	$db=creadorConexion::crear('MySql');
	$sql="Select * from vendedm
		 where codintv='".$data['codintv']."'
		 and cvended!='".$data['cvended']."'
		 and upper(tvended)='".strtoupper($data['tvended'])."'";
	$db->setQuery($sql);
    $valsql=$db->loadObjectList();
		if(count($valsql)>0){
		return array('rst'=>'2','msj'=>" Cod Int:".$data['codintv']." existe");exit();
		}
		else{
		$sql="	UPDATE vendedm SET
				dnombre='".$data['dnombre']."',
				dapepat='".$data['dapepat']."',
				dapemat='".$data['dapemat']."',
				ndocper='".$data['ndocper']."',
				demail='".$data['demail']."',
				tdocper='".$data['tdocper']."',
				fingven='".$data['fingven']."',
                fretven='".$data['fretven']."',
				tsexo='".$data['tsexo']."',
				coddpto='".$data['coddpto']."',
				codprov='".$data['codprov']."',
				coddist='".$data['coddist']."',
				ddirecc='".$data['ddirecc']."',
				tvended='".$data['tvended']."',
				cinstit='".$data['cinstit']."',
				codintv='".$data['codintv']."',
				dtelefo='".$data['dtelefo']."',
				cusuari='".$data['cusuari']."',
				cestado='".$data['cestado']."',
                copeven='".$data['copeven']."',
				fusuari=now(),
				ttiptra='M'
				WHERE cvended='".$data['cvended']."'";
		$db=creadorConexion::crear('MySql');
		$db->iniciaTransaccion();
		$db->setQuery($sql);
			if(!$db->executeQuery()){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos');exit();
			}
			else{
				$transa="INSERT INTO transam (transaccion,fecha,cfilial) Values('".addslashes($sql)."',now(),'".$data['cfilial']."')";
				$db->setQuery($transa);
					if(!$db->executeQuery()){
						$db->rollbackTransaccion();
						return array('rst'=>'3','msj'=>'Error al Registrar Datos'.$transa);exit();
					}
				$db->commitTransaccion();
				return array('rst'=>'1','msj'=>'Persona actualizada correctamente');exit();
			}
		}
	}

    public function guardarSueldosVendedores ($data) {
        $db=creadorConexion::crear('MySql');
        $db->iniciaTransaccion();
        $rows =json_decode(stripslashes($data["data"]));
        //$rows = json_decode($data["data"]);
        //var_dump($rows);
        foreach($rows as $vendedor) {

            if(trim($vendedor->montele)==''){
                $vendedor->montele=0;
            }
            if(trim($vendedor->descuento)==''){
                $vendedor->descuento=0;
            }
            $sql = "UPDATE vendedm set sueldo = " . $vendedor->sueldo
                . " , descto = ". $vendedor->descuento
                . " , horari = '". $vendedor->horario . "'"
                . " , montele = ". $vendedor->montele 
                . " , dinstit = '". $vendedor->dinstit . "'"
                . " where cvended = '". $vendedor->id ."'";
            $db->setQuery($sql);
            if(!$db->executeQuery()){
                $db->rollbackTransaccion();
                return array('rst'=>'3','msj'=>'Error al Registrar sueldos','sql'=>$sql);exit();
            }
            // REGISTRAR FALTAS
            // deshabilitamos las anteriores
            $sql = "update venfala set cestado = 0, cusuari = '".$data['cusuari']."' where  cvended = '".$vendedor->id."'";
            $db->setQuery($sql);
            if(!$db->executeQuery()){
                $db->rollbackTransaccion();
                return array('rst'=>'3','msj'=>'Error al actualizar las faltas de '.$vendedor->id ,'sql'=>$sql);exit();
            }
            $faltas = $vendedor->selectedDates;
            foreach ($faltas as $f) {
                if ($f) {
                    $fecha = date("Y-m-d",$f/1000);
                    //agregamos el nuevo grupo
                    $sql = "Insert into venfala set cvended = '". $vendedor->id ."', diafalt='".$fecha."', cestado = 1,cusuari = '".$data['cusuari']."', fusuari = NOW() ";
                    $db->setQuery($sql);
                    if(!$db->executeQuery()){
                        $db->rollbackTransaccion();
                        return array('rst'=>'3','msj'=>'Error al Registrar faltas','sql'=>$sql);exit();
                    }
                }
            }
            if(!MySqlTransaccionDAO::insertarTransaccion($sql,$data['cfilial']) ){
                $db->rollbackTransaccion();
                return array('rst'=>'3','msj'=>'Error al Registrar transacciones','sql2'=>$sql);exit();
            }
        }
        $db->commitTransaccion();
        return array('rst'=>'1','msj'=>'Sueldos de Vendedores actualizados');exit();
    }
	
	public function JQGridCountTrabajador($where){
		$db=creadorConexion::crear('MySql');
		$sql="SELECT count(*) as count FROM vendedm v
			WHERE 1=1 $where";
		$db->setQuery($sql);
		$data=$db->loadObjectList();
		if( count($data)>0 ){
            return $data;
        }else{
            return array(array('COUNT'=>0));
        }
	}
	
	public function JQGRIDRowsTrabajador( $sidx, $sord, $start, $limit, $where) {
	$sql="	select v.cfilial,v.cvended,v.dnombre,v.dapepat,v.dapemat,v.demail,v.dtelefo,v.ndocper,
			v.tdocper,v.fingven,v.fretven,v.tsexo,v.coddpto,v.codprov,v.coddist,
			v.ddirecc,v.codintv,v.tvended,v.cinstit,
			IF(v.cestado='1','Activo','Inactivo') as cestado , copeven, sueldo, montele,
			(select GROUP_CONCAT(UNIX_TIMESTAMP(diafalt) * 1000  SEPARATOR 'D') faltas from venfala where cvended = v.cvended and cestado = 1) faltas,
			descto, horari, v.dinstit
			from vendedm v
			WHERE 1=1 $where
            ORDER BY $sidx $sord
            LIMIT $start , $limit ";
        $db=creadorConexion::crear('MySql');
        $db->setQuery($sql);
        $data=$db->loadObjectList();
        $debug = 1;
        return $data;
    }

    public function ActualizarDocumentos($data){
    	$db=creadorConexion::crear('MySql');
    	$db->iniciaTransaccion();
    	$actpersona="UPDATE ingalum 
					 SET nfotos='".$data['nfotos']."',certest='".$data['certest']."',partnac='".$data['partnac']."'
					 ,fotodni='".$data['fotodni']."',otrodni='".$data['otrodni']."',cpais='".$data['cpais']."'
					 ,tinstip='".$data['tinstip']."',dinstip='".$data['dinstip']."',dcarrep='".$data['dcarrep']."'
					 ,ultanop='".$data['ultanop']."',dciclop='".$data['dciclop']."',ddocval='".$data['ddocval']."'
					 ,fdevolu='".$data['fdevolu']."',cdevolu='".$data['cdevolu']."',dcompro='".$data['dcompro']."'
					 ,cusuari='".$data['cusuari']."',fusuari=now()  					 
					 WHERE cingalu='".$data['cingalu']."'";
		$db->setQuery($actpersona);
			if(!$db->executeQuery()){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$actpersona);exit();
			}
			if(!MySqlTransaccionDAO::insertarTransaccion($actpersona,$data['cfilial']) ){
				$db->rollbackTransaccion();
				return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql2'=>$actpersona);exit();
			}

		$db->commitTransaccion();
		return array('rst'=>'1','msj'=>'Documentos Actualizados');exit();
    }

    public function JQGridCountAlumProc($where){
		$db=creadorConexion::crear('MySql');
		$sql="SELECT count(*) as count 
			FROM aspralm a 
			inner join cicloa c on (c.cciclo=a.cciclo)
			WHERE 1=1 
			$where";
		$db->setQuery($sql);
		$data=$db->loadObjectList();
		if( count($data)>0 ){
            return $data;
        }else{
            return array(array('COUNT'=>0));
        }
	}
	
	public function JQGRIDRowsAlumProc( $sidx, $sord, $start, $limit, $where) {
	$sql="	SELECT a.daspral,a.caspral,a.cciclo,a.ncredit,a.nhorteo,a.nhorpra,replace(a.csilabo,',','<br>') as csilabo,c.dciclo,a.cestado,
			CASE
                WHEN	a.cestado='1' THEN 'Activo'
                WHEN	a.cestado='0' THEN 'Inactivo'
                ELSE	''
            END AS estado
			FROM aspralm a 
			inner join cicloa c on (c.cciclo=a.cciclo)
			WHERE 1=1 
			 $where
            ORDER BY $sidx $sord
            LIMIT $start , $limit ";
        $db=creadorConexion::crear('MySql');
        $db->setQuery($sql);
        $data=$db->loadObjectList();
        
        return $data;
    }
}
?>
