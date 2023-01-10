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
    <nav class="menu"> 
        <ul>
            <li>logo ensa</li>
            <li><a href="acceuil.php">Acceuil</a></li>
            <?php
                if (isset($_SESSION['admin']))
                {
            ?>
                    <li><a href="filiere.php">Filières</a></li>
                    <li><a href="module.php">Modules</a></li>
                    <li><a href="professeur.php">Professeurs</a></li>
                    <li><a href="locaux.php">Locaux</a></li>
            <?php
                }
                if (!isset($_SESSION['admin']) && !isset($_SESSION['prof']))
                {
            ?>
                    <li><a href="seconnecter.php">Se connecter</a></li>
            <?php 
                } else {
                    echo "<li><a href=";
                    if (isset($_SESSION['prof']))
                        echo "profilprof.php";
                    if (isset($_SESSION['admin']))
                        echo "profiladmin.php";
                    echo ">Profil</a></li>";
                }
            ?>
        </ul>
    </nav>
    <h1>Locaux</h1>

    <!-- AJOUTER BATIMENT -->
    <form action="#" method="post">
        <h3>Ajouter Batiment</h3>

        <div>
            <label for="batiment" >Batiment</label>
            <input type="texte" name="batiment" required>
        </div>
        
        <input type="submit" value="Ajouter" name="ajoutbat" >
    </form>

    <!-- AJOUTER SALLE  -->
    <h3>Ajouter Salle</h3> 
    <form action="#" method="post">
        <div>
            <label for="bat" >Batiment</label>
            <select name="bat" id="">
                <?php
                    $sql = "select * from batiment";
                    $result = mysqli_query($link, $sql) or die(mysqli_error($link));
                    while ($data= mysqli_fetch_assoc($result)) {
                        $batiment = $data['nombatiment'];
                        echo "<option value='".$batiment."'>".$batiment."</option>";
                    }
                ?>    
            </select>
        </div>

        <div>
            <label for="salle">Salle</label>
            <input type="number" name="salle" required>
        </div>

        <div>
            <label for="cap" >Capacité d'acceuil</label>
            <input type="number" name="cap" required>
        </div>

        <input type="submit" value="Ajouter" name="ajoutsalle" > 
    </form>

    <table border=1>
        <tr>
            <th>Batiment</th>
            <th>Salle</th>
            <th>Capacité d'acceuil</th>
            <th>Taux d'occupation </th>
        </tr>
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
                    echo "<td></td><td></td><td></td></tr>";
                } else {
                    echo "<tr>"; 
                    echo "<td rowspan='".$numsalle."'>".$batiment."</td>";
                    while ($salles=mysqli_fetch_assoc($res3))
                    {
                        $idsalle=$salles['idsalle'];
                        echo "<td>".$salles['numsalle']."</td>";
                        echo "<td>".$salles['cap_acceuil']."</td>";
                        $sql4 = "SELECT count(idseance) as nbr from seance, salle where seance.idsalle = salle.idsalle and seance.idsalle='".$idsalle."' group by seance.idsalle";
                        $res4 = mysqli_query($link, $sql4) or die("Erreur seance");
                        $numseance=mysqli_num_rows($res4);
                        if ($numseance == 0){
                            echo "<td>0</td></tr>";
                        } else {
                            while ($data = mysqli_fetch_assoc($res4)){
                                $nbrheures = $data['nbr']*2;
                                echo "<td>".$nbrheures." </td></tr>";
                            }
                        }     
                    }
                }         
            }                                                                                                                                                                                                                                                                   
        ?> 
    </table> 

    <?php
        if(isset($_POST['ajoutsalle'])){
            $salle=$_POST['salle'];
            echo $salle;
            $batiment=$_POST['bat'];
            echo $batiment;
            $cap=$_POST['cap'];
            echo $cap;
            $sql="INSERT INTO salle VALUES (NULL, '".$batiment."','".$salle."','".$cap."')";
            $result = mysqli_query($link,$sql) or die("erreur salle") ;
            if ($result == true){
                header("Location:locaux.php");
            }
        }
        if(isset($_POST['ajoutbat'])){
            $bat=$_POST['batiment'];  
            $sql="INSERT INTO batiment values ('".$bat."')";
            $result = mysqli_query($link,$sql) or die("erreur batiment");
            if ($result == true){
                header("Location:locaux.php");
            }
        }
    ?>

</body>


