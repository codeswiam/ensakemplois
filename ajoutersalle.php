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
<td><label for="ajouter salle" >salle</label></td>
<td><input type="texte" name="salle" ></td>

    </br>
    </br>
    <input type="submit" value="valider" >

    <?php
include ("connexion.php");
if(isset($_POST['valider']))
{
	$salle=$_POST['salle'];
    echo $salle;
    
        $sql2="INSERT INTO salle values(NULL,'".$nomsalle."',NULL)";
        $result2 = mysqli_query($link,$sql2) ;
   
    header('location: locaux.php');
}

?>


