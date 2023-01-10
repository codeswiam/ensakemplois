<?php
include ("connexion.php");
session_start();
if (isset($_GET["semestre"]) && $_GET["semestre"] != "S0") {
    $getsem = $_GET["semestre"];
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>WELCOME!</title>
    <link rel="stylesheet" href="style2.css">
</head>
<body>
<h1> bienvenue sur EMPLOI ENSAK </h1>
<img src="photo/ensak.jpg" width="560">
</body>
</html>
