<?
set_time_limit(300);
$con=mysql_connect("localhost","cpdteles","btexqbw8hchk");
mysql_select_db("cpdteles_caja1",$con);
$tab=$sql="select * from cpdtabm where cestado='1'";
$qtab=mysql_query($tab);
$query="";
while($r=mysql_fetch_array($qtab)){
echo $r[0]."<br>";
	$sql="DESC ".$r[0];
	$qsql=mysql_query($sql);
	$query="ALTER TABLE ".$r[0];
	$cantidad=0;
	while($r2=mysql_fetch_array($qsql)){
		$cantidad++;
		if(substr($r2[1],0,7)=="varchar" or substr($r2[1],0,4)=="char"){		
		$query.=" MODIFY COLUMN ".$r2[0]." ".$r2[1]." CHARACTER SET utf8 COLLATE utf8_general_ci,";			
		}
	}
	$query.="ENGINE=InnoDB,
			 DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci";
	echo $query."<hr>";
	$resultado=mysql_query($query);
}


mysql_free_result();
?>