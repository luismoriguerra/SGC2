<?
session_start();
if (empty($_SESSION['SECON']['dlogper']) or trim($_SESSION['SECON']['dlogper'])=='') {
    header('Location: close.php');
}
?>