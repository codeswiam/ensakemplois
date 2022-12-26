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
        $sql1 = "SELECT nombatiment FROM batiment ";
        $result1 = mysqli_query($link,$sql1);
        while ($batiment=mysqli_fetch_assoc($result1))
        {
            $bat=$batiment['nombatiment '];
           echo" <tr>";
           echo" <td>".$batiment['nombatiment '] ." </td>";
        }
   
         $sql3="SELECT idsalle  FROM salle WHERE salle.idbatiment=batiment.idbatiment ";
        $result3=mysqli_query($link,$sql3);
        echo" <td>";
        while ($salle=mysqli_fetch_assoc($result3))
{
            $salle=$salle['idsalle'];
            echo" <div>".$salle['numsalle']." </div>";
}
echo "</td>";
echo" </tr>";
echo" </table>";
?>


</br>




<input type="submit" value="valider" >
</br>

</br>
