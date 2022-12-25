<!DOCTYPE html>
<html lang= "fr " dir="ltr" ></html>
<head>
    <title>FORMULAIRE</title>
    <meta name="author" content="Nom de la personne qui a réalisé la page"/>
    <meta charset= " utf-8" />
    <meta name="keywords" />
    <link rel="stylesheet" href="style.css" />
    
</head>

<body>
<form method="POST" action="">
<label >Nom de la Filliere</label></br>
    <input type="text" name="nom"></br>
<label >Abréviation de la Filliere </label></br>
    <input type="text" name="abv"></br>
<label >Semestre </label></br>
    <input type="checkbox" name="sem[]" value="S5">s5</br>
    <input type="checkbox" name="sem[]" value="S6">s6</br>
    <input type="checkbox" name="sem[]" value="S7">s7</br>
    <input type="checkbox" name="sem[]" value="S8">s8</br>
    <input type="checkbox" name="sem[]" value="S9">s9</br>
    <input type="checkbox" name="sem[]" value="S10">s10</br>

<input type="submit" name="submi" value="envoyer">


</form>


</body>

<?php
include ("connexion.php");
$nom=$_POST["nom"];
$abv=$_POST["abv"];
$choix=$_POST["sem"];
if(isset($_POST["submit"])){
    $sql1="insert into "
    $result1 = mysqli_query($link,$sql1);
}




?>