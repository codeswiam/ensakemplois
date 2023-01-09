<?php
include ("connexion.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
   
    <link rel="#" href="#">

    <title>ajouter salle</title>

</head>
<body>
<td><label for="ajouter batiment" >batiment</label></td>
<td><input type="texte" name="batiment" ></td>

    </br>
    </br>
    <input type="submit" value="valider" >

    <?php
include ("connexion.php");
if(isset($_POST['valider']))
{
	$batiment=$_POST['batiment'];
    echo $batiment;
    
        $sql2="INSERT INTO batiment values (NULL,'".$nombatiment."',NULL)";
        $result2 = mysqli_query($link,$sql2) ;
   }
    header('location: locaux.php');


?>


