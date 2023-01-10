<?php
include("connexion.php"); 
{
    $numsalles=$_POST['numsalle'];
    $batiments=$_POST['batiment'];
    $cap_acceuils=$_POST['cap_acceuil'];
    $sql22="INSERT INTO `salle`(`nombatiment`, `numsalle`, `cap_acceuil`) VALUES ('$batiments','$numsalles','$cap_acceuils')";
     $result22 = mysqli_query($link,$sql22) ;
     header("location:locaux.php");

}

?>