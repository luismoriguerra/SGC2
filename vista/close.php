<?php
    session_start();
    unset($_SESSION['SECON']);
    /*session_unset();
    session_destroy();*/
    header('Location: vst-login.php');
?>
