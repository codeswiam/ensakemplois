<?php 
    session_start();
    $_SESSION['prof'] = 1;
    session_destroy();
    session_start();
    $_SESSION['admin'] = "admin";
?>