<?
class MySqlHorarioDAO{
    public function cargarDia(){
        $sql="  SELECT cdia AS id,dnomdia AS nombre
                FROM diasm";
        $db=creadorConexion::crear('MySql');
        $db->setQuery($sql);
        $data=$db->loadObjectList();
        if(count($data)>0){
            return array('rst'=>'1','msj'=>'Dias cargados','data'=>$data);
        }else{
            return array('rst'=>'2','msj'=>'No existen Dias','data'=>$data,'sql'=>$sql);
        }
    }   

    public function cargarHorarioValidado($array){
        $sql="  select concat(d.cdia,'-',h.chora) as id,
                concat(d.dnemdia,' | ',h.hinici,' - ',h.hfin,' | Turno: ',t.dnemtur) as nombre,
                h2.horario as horario,d.cdia as cdia,td.cdia,td.hini,td.hfin,
                if(h.hinici>=td.hini and h.hfin<=td.hfin,'ok','') as rpta, 
                h3.hinici,h3.hfin,
                if((h3.hfin>=h.hinici  and h3.hfin<=h.hfin)
                    or (h3.hinici>=h.hinici  and h3.hinici<=h.hfin)
                  or (h.hinici>=h3.hinici and h.hfin<=h3.hfin),'ok','') as rpta2
                from horam h 
                inner join turnoa t on (t.cturno=h.cturno)
                inner join diasm d 
                inner join disprom td on (td.cdia=d.cdia and td.cestado='1' and td.cprofes='".$array['cprofes']."')
                left join (
                            select ho.hinici,ho.hfin,h.cdia
                            from horprop h
                            inner join horam ho on (ho.chora=h.chora)
                            inner join cuprprp c on (h.ccurpro=c.ccuprpr)
                            where (h.cprofes='".$array['cprofes']."' or h.cambien='".$array['cambien']."') 
                            and ho.cinstit!='".$array['cinstit']."'
                            and h.cestado='1'           
                ) h3 on (h3.cdia=d.cdia and ((h3.hfin>=h.hinici  and h3.hfin<=h.hfin)
                                        or (h3.hinici>=h.hinici  and h3.hinici<=h.hfin)
                                        or (h.hinici>=h3.hinici and h.hfin<=h3.hfin)))
                left join (
                                        select concat(h.cdia,'-',h.chora) as horario,g.finicio,g.ffin
                                        from horprop h
                                        inner join cuprprp c on (h.ccurpro=c.ccuprpr)
                                        inner join gracprp g on (c.cgracpr=g.cgracpr)
                                        where h.cambien='".$array['cambien']."'
                                        and h.cestado='1'
                                        and CURRENT_DATE() <=g.ffin
                                        UNION
                                        select concat(h.cdia,'-',h.chora) as horario,g.finicio,g.ffin
                                        from horprop h
                                        inner join cuprprp c on (h.ccurpro=c.ccuprpr)
                                        inner join gracprp g on (c.cgracpr=g.cgracpr)
                                        where h.cprofes='".$array['cprofes']."'
                                        and h.cestado='1'
                                        and CURRENT_DATE() <=g.ffin
                                                ) as h2 on (h2.horario=concat(d.cdia,'-',h.chora))
                where h.cinstit='".$array['cinstit']."'
                and h.thora='1'
                and h.cestado='1'
                and FIND_IN_SET(d.cdia ,'".$array['dias']."') > 0
                and h2.horario is NULL
                and (h.hinici>=td.hini and h.hfin<=td.hfin)
                and h3.hinici is NULL
                GROUP BY d.cdia,h.hinici,h.hfin
                ORDER BY d.cdia,h.hinici,h.hfin";       

        $db=creadorConexion::crear('MySql');
        $db->setQuery($sql);
        $data=$db->loadObjectList();
        if(count($data)>0){
            return array('rst'=>'1','msj'=>'Horarios cargados','data'=>$data);
        }else{
            return array('rst'=>'2','msj'=>'No existen Horarios','data'=>$data,'sql'=>$sql);
        }
    }

    public function cargarHora($array){
        $sql="  SELECT h.chora AS id,CONCAT('Turno:',t.`dturno`,' | ',h.hinici,'-',h.hfin) AS nombre
                FROM horam h
                INNER JOIN turnoa t ON (h.`cturno`=t.`cturno`)
                WHERE cinstit='".$array['cinstit']."'
                AND thora='1'
                AND cestado='1'
                ORDER BY h.`hinici`";
        $db=creadorConexion::crear('MySql');
        $db->setQuery($sql);
        $data=$db->loadObjectList();
        if(count($data)>0){
            return array('rst'=>'1','msj'=>'Horas cargados','data'=>$data);
        }else{
            return array('rst'=>'2','msj'=>'No existen Horas','data'=>$data,'sql'=>$sql);
        }
    }

    public function cargarTipoAmbiente(){
        $sql="  SELECT ctipamb AS id, dtipamb AS nombre
                FROM tipamba
                WHERE cestado='1'
                ORDER BY nombre";
        $db=creadorConexion::crear('MySql');
        $db->setQuery($sql);
        $data=$db->loadObjectList();
        if(count($data)>0){
            return array('rst'=>'1','msj'=>'Tipo de Ambiente cargados','data'=>$data);
        }else{
            return array('rst'=>'2','msj'=>'No existen Tipo de Ambiente','data'=>$data,'sql'=>$sql);
        }
    }

    public function cargarAmbiente($array){
        $sql="  SELECT cambien AS id,numamb AS nombre
                FROM ambienm
                WHERE ctipamb='".$array['ctipamb']."'
                AND cfilial='".$array['cfilial']."'
                AND cestado='1'";
        $db=creadorConexion::crear('MySql');
        $db->setQuery($sql);
        $data=$db->loadObjectList();
        if(count($data)>0){
            return array('rst'=>'1','msj'=>'Ambiente cargados','data'=>$data);
        }else{
            return array('rst'=>'2','msj'=>'No existen Ambiente','data'=>$data,'sql'=>$sql);
        }
    }

    public function cargarTiempoTolerancia(){
        $sql="  SELECT ctietol AS id,CONCAT(mintol,' MIN') AS nombre
                FROM tietolm
                WHERE cestado='1'";
        $db=creadorConexion::crear('MySql');
        $db->setQuery($sql);
        $data=$db->loadObjectList();
        if(count($data)>0){
            return array('rst'=>'1','msj'=>'Tiempo Tolerancia cargados','data'=>$data);
        }else{
            return array('rst'=>'2','msj'=>'No existen Tiempo Tolerancia','data'=>$data,'sql'=>$sql);
        }
    }

    public function guardarHorarios($array){
        $db=creadorConexion::crear('MySql');

        $db->iniciaTransaccion();
        $sql="UPDATE cuprprp
              SET cprofes='".$array['cprofes']."'
              ,finipre=".$array['finipre']."
              ,ffinpre=".$array['ffinpre']."
              ,finivir=".$array['finivir']."
              ,ffinvir=".$array['ffinvir']."
              ,cusuari='".$array['cusuari']."'
              ,fusuari=now()
              WHERE ccuprpr='".$array['ccuprpr']."'";

            $db->setQuery($sql);
            if(!$db->executeQuery()){
                $db->rollbackTransaccion();
                return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sql);exit();
            }
            if(!MySqlTransaccionDAO::insertarTransaccion($sql,$array['cfilialx']) ){
                $db->rollbackTransaccion();
                return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql2'=>$sql);exit();
            }

        $datos=explode("^^",$array['datos']);
        $detdatact=explode("|",$datos[0]);
        for($i=0;$i<count($detdatact);$i++){
            $dd=explode("_",$detdatact[$i]);

            $sqlinsert="UPDATE horprop SET
                        ctipcla='".$dd[0]."',                        
                        ctietol='".$dd[1]."',
                        cestado='".$dd[2]."',
                        fusuari=NOW(),
                        cusuari='".$array['cusuari']."'    
                        WHERE chorpro='".$dd[3]."'";
            $db->setQuery($sqlinsert);
            if(!$db->executeQuery()){
                $db->rollbackTransaccion();
                return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sqlinsert);exit();
            }
            if(!MySqlTransaccionDAO::insertarTransaccion($sqlinsert,$array['cfilialx']) ){
                $db->rollbackTransaccion();
                return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql2'=>$sqlinsert);exit();
            }
        }

        $detdatins=explode("|",$datos[1]);
        for($i=0;$i<count($detdatins);$i++){
            $dd=explode("_",$detdatins[$i]);

            $sqlinsert="INSERT INTO horprop (cdia,chora,ccurpro,ctipcla,cambien,fusuari,cusuari,ctietol,cestado,cdetgra,cprofes)
                        VALUES ('".$dd[0]."','".$dd[1]."','".$array['ccuprpr']."','".$dd[2]."','".$dd[4]."',now(),'".$array['cusuari']."','".$dd[5]."','1','".$array['cdetgra']."','".$dd[6]."')";
            $db->setQuery($sqlinsert);
            if(!$db->executeQuery()){
                $db->rollbackTransaccion();
                return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql'=>$sqlinsert);exit();
            }
            if(!MySqlTransaccionDAO::insertarTransaccion($sqlinsert,$array['cfilialx']) ){
                $db->rollbackTransaccion();
                return array('rst'=>'3','msj'=>'Error al Registrar Datos','sql2'=>$sqlinsert);exit();
            }
        }

        $db->commitTransaccion();
        return array('rst'=>'1','msj'=>'Cambios guardados correctamente');exit();                
            
    }

}
?>