<?php

include("connexion.php");

$idsems = $_POST['semestre'];
$modules= $_POST['nommodule'];

$sql="INSERT INTO `module`(`nommodule`, `idsem`) VALUES ('$modules','$idsems')";

$result = mysqli_query($link,$sql);
header("location:module.php");


?>