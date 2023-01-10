<?PHP
    session_start();
    include ("connexion.php");
    if (!isset($_SESSION['admin'])){
        header("Location: acceuil.php");
    } else {
        $admin = $_SESSION['admin'];
    }   
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Locaux</title>
</head>
<body>
    <table border=1>
        <th>Batiment</th>
        <th>Salle</th>
        <th>Capacité d'acceuil</th>
        <th>Taux d'occupation </th>
        <?php
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
                        $idsalle=$salles['idsalle'];
                        echo "<td>".$salles['numsalle']."</td>";
                        echo "<td>".$salles['cap_acceuil']." </td>";
                        $sql4 = "select count(idseance) as nbr from seance, salle where seance.idsalle = salle.idsalle group by seance.idsalle";
                        $res4 = mysqli_query($link, $sql4) or die("Erreur seance");
                        while ($data = mysqli_fetch_assoc($res4)){
                            $nbrheures = $data['nbr']*2;
                            echo "<td>".$nbrheures." </td></tr>";
                        }
                        
                    }
                }         
            }                                                                                                                                                                                                                                                                   
        ?> 
    </table> 
    <!-- AJOUTER SALLE  -->

    <h3>ajouter salle</h3> 
    <form action="traitementsalle.php" method="post">
<label for="salle" >salle</label>
<input type="texte" name="numsalle" >
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

</body>


