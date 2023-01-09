<?php 
    include ("connexion.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
   
    <link rel="#" href="#">

    <title>locaux</title>

</head>
<body>
<a href="ajouterbatiment.php">ajouterbatiment</a>
<a href="ajoutersalle.php">ajoutersalle</a>
<?php
echo" <table border=1>";

echo" <th> batiment  </th>";
echo" <th>salle  </th>";
echo" <th>taux d occupation </th>";
        $sql1 = "SELECT * FROM batiment ";
        $res1 = mysqli_query($link,$sql1);
        while ($batiment=mysqli_fetch_assoc($res1))
        {
            $batiment=$batiment['nombatiment'];
            $sql3="SELECT * FROM salle ,batiment WHERE salle.nombatiment=batiment.nombatiment  and nombatiment='".$batiment."'";
            $res3=mysqli_query($link,$sql3);
            $numsalle=mysqli_num_rows($res3);
           echo" <tr>";

           echo" <td>".$batiment['nombatiment'] ." </td>";
            while ($salle=mysqli_fetch_assoc($res3))
{
            $salle=$salle['idsalle'];
            echo" <td>".$salle['numsalle']." </td>";
            echo" </tr>";
}
}
echo" </table>";
?>
 </br>
 </br>
<!-- AJOUTER SALLE  -->

<h3 ajouter salle></h3> </br>
 </br>
<td><label for="ajouter salle" >salle</label></td>
<td><input type="texte" name="salle" ></td>

    </br>
    </br>
    <input type="submit" value="valider" > </br>
</br>

    <?php
if(isset($_POST['valider']))
{
	$salle=$_POST['salle'];
    echo $salle;
    
        $sql2="INSERT INTO salle values(NULL,'".$nomsalle."',NULL)";
        $result2 = mysqli_query($link,$sql2) ;
   
    header('location: locaux.php');
   
}

?>

<!-- AJOUTER BATIMENT -->

<h3 ahouter batiment></h3> </br>
 </br>
<td><label for="ajouter batiment" >batiment</label></td>
<td><input type="texte" name="batiment" ></td>

    </br>
    </br>
    <input type="submit" value="valider" > </br>
</br>

    <?php
include ("connexion.php");
if(isset($_POST['valider']))
{
	$batiment=$_POST['batiment'];
    echo $batiment;
    
        $sql2="INSERT INTO batiment values(NULL,'".$nombatiment."',NULL)";
        $result2 = mysqli_query($link,$sql2) ;
   }
    header('location: locaux.php');


?>



