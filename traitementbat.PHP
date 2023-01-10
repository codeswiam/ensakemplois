<?php
{include("connexion.php"); 
	$batimenst=$_POST['batiment'];  
        $sql21="INSERT INTO batiment values ('$batimenst')";
        $result2 = mysqli_query($link,$sql21) ;
  
        header("location:locaux.php");

}
?>