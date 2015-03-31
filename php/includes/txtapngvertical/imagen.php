<?php  
header("Content-type: image/gif");  
//Texto q convertiremos en imagen 
$var = $_GET['var']; 
//http://es.php.net/manual/es/function.imagecreatefromgif.php 
$img1 = imagecreatefromgif("home.gif");  
//Tipus de Lletra 
$fuente = "./arialbd.ttf"; 
//http://es.php.net/manual/es/function.imagecolorallocate.php 
$color = imagecolorallocate($img1,23,58,100);  
//http://es.php.net/manual/es/function.imagettftext.php 
imagettftext($img1,10,90,24,115,$color,$fuente, $var);  

//http://es.php.net/manual/es/function.imagegif.php 
imagegif($img1);  
//http://es.php.net/manual/es/function.imagedestroy.php 
imagedestroy($img1);
?>

