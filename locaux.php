<?php 
    include("connexion.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>locaux</title>
</head>

<body>
<?php
 echo" <table border=1>";

 echo" <th> batiment  </th>";
 echo" <th>salle  </th>";
 echo" <th>taux d'occupation </th>";
         $sql1 = "SELECT * FROM batiment";
         $res1 = mysqli_query($link,$sql1);
         while ($batiments=mysqli_fetch_assoc($res1))
         {
             $batiment = $batiments['nombatiment'];
             $sql3="SELECT * FROM salle WHERE nombatiment='".$batiment."'";
             $res3=mysqli_query($link,$sql3);
             $numsalle=mysqli_num_rows($res3);
             if ($numsalle == 0){
                 echo "<tr><td>".$batiment."</td>";
                 echo "<td></td></tr>";
             } else {

                 echo "<tr>"; 
                 echo "<td rowspan='".$numsalle."'>".$batiment."</td>";
                 while ($salles=mysqli_fetch_assoc($res3))
                 {
                     $salle=$salles['idsalle'];
                     echo" <td>".$salles['numsalle']." </td>";
                    echo" <td>".$salles['cap_acceuil']." </td></tr>";
                 }
                //  echo" <td>".$salles['cap_acceuil']." </td></tr>";
             }  
                  
                }                                                                                                                                                                                                                                                                   
   
echo" </table>";
?>
 </br>
 </br>
<!-- AJOUTER SALLE  -->

<h3>ajouter salle</h3> </br>
 </br>
 <form action="traitementsalle.php" method="post">
<td><label for="salle" >salle</label></td>
<td><input type="texte" name="numsalle" ></td>
    </br>
    </br>
    <td><label for="batiment" >batiment</label></td>
<td><input type="texte" name="batiment" ></td>

    </br>
    <td><label for="capp" >capp acceuil</label></td>
    <td><input type="texte" name="cap_acceuil" ></td>
    </br>
    <input type="submit" value="valider" name="valider" > </br>
</br>
            </form>

<!-- AJOUTER BATIMENT -->
<form action="traitementbat.PHP" method="post">
<h3>ajouter batiment</h3> </br>
 </br>
<td><label for="batiment" >batiment</label></td>
<td><input type="texte" name="batiment" ></td>

    </br>
    </br>
    <input type="submit" value="valider" name="valider" > </br>
</br>
</form>
   


