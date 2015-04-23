<?
class MySqlLoginDAO{	
	public function loginUsuario(dto_usuario $dtoUsuario){
		$db=creadorConexion::crear('MySql');

		$dni=$db->limpiaString($dtoUsuario->getDni());
        $pass=$db->limpiaString($dtoUsuario->getPassword());

		$sql="SELECT usug.cperson,pe.dnomper, pe.dappape, pe.dapmape, pe.dlogper,
			  GROUP_CONCAT(CONCAT(usug.cfilial,'|',f.dfilial) SEPARATOR '^^') as filiales,
GROUP_CONCAT(concat(usug.cfilial,'|',f.dfilial,'|',gr.cgrupo,'|',gr.dgrupo,'|',gr.cinstit,'|',IF(ins.dinstit IS NULL,'',ins.dinstit),'|') separator '^^') as accesos, pe.dnivusu
			FROM personm pe 
			INNER JOIN usugrup usug on usug.cperson=pe.cperson
			INNER join grupom gr on gr.cgrupo=usug.cgrupo
			INNER join filialm f on f.cfilial=usug.cfilial	
			LEFT join instita ins on ins.cinstit=gr.cinstit
			WHERE pe.dlogper='".$dni."' AND pe.dpasper='".$pass."'
			and usug.cestado=1
			and gr.cestado=1
			GROUP BY gr.cgrupo
			ORDER BY gr.dgrupo";

		$db->setQuery($sql);
		$usuario=$db->loadObjectList();

		return $usuario;
	}
}
?>