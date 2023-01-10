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
 <form action="#" method="post">
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
<form action="#" method="post">
<h3>ajouter batiment</h3> </br>
 </br>
<td><label for="batiment" >batiment</label></td>
<td><input type="texte" name="batiment" ></td>

    </br>
    </br>
    <input type="submit" value="valider" > </br>
</br>

    <?php
if(isset($_POST['valider']))
{
	$batiment=$_POST['batiment'];
    echo $batiment;
    
        $sql2="INSERT INTO batiment values (NULL,'".$nombatiment."',NULL)";
        $result2 = mysqli_query($link,$sql2) ;
  
   
}
?>