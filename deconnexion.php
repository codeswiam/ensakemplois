<?php
    session_start();
    if (isset($_SESSION['prof']) or isset($_SESSION['admin'])){
        $_SESSION = array(); // unsets all the session variables
        session_destroy();
    }
    header("Location: acceuil.php");
?>