<?php
include ("connexion.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <title>ajouter salle</title>

</head>
<h3 ajouter salle></h3> </br>
 </br>
<td><label for="ajouter salle" >salle</label></td>
<td><input type="texte" name="salle" ></td> </br> </br>


<td><label for="nom batimet" >nom batiment</label></td>
<td><input type="texte" name="nom_batiment" ></td>  </br> </br>

<td><label for="capp aceuil" >cap acueil</label></td>
<td><input type="texte" name="cap_acueil" ></td>  </br>  </br>



    </br>
    </br>
    <input type="submit" value="ajouter" name="ajouter" > </br>
</br>

    <?php
if(isset($_POST['ajouter'])){
	$nomsalle=$_POST['salle'];
    $nom_batiment=$_POST['nom_batiment'];
    $cap_acueil=$_POST['cap_acueil'];

        $sql2="INSERT INTO `salle`(`idsalle`, `nombatiment`, `numsalle`, `cap_acceuil`) VALUES (NULL,$nom_batiment,'$nomsalle',$cap_acueil)";
        $result2 = mysqli_query($link,$sql2) ;
        header('location:locaux.php');
}

?>
