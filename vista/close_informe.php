<?php
    session_start();
    unset($_SESSION['SECONINFORMEWEB']);
    /*session_unset();
    session_destroy();*/
    header('Location: http://www.seguraconsult.com');
?>
