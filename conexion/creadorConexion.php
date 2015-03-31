<?
class creadorConexion{
	public static function crear($tipo){
		$cn=null;
		switch ($tipo) {
			case 'MySql':
				$cn=MySqlConexion::getInstance();
				break;	
		}
		return $cn;
	}
}
?>