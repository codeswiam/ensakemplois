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
    <title>Professeurs</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav class="menu"> 
        <ul>
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
                    <li><a href="welcome.php">Se connecter</a></li>
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

    <h1>PROFESSEURS</h1>



<table border=1>
    <tr >
        <th >Nom</th>
        <th >Prénom</th>
        <th >Charge Horaire</th>
    </tr>
    <?php
    $sql1="SELECT * FROM prof" ;
    $result1=mysqli_query($link,$sql1);
    while($data1=mysqli_fetch_assoc ( $result1)){
        $sql2="SELECT nom,count(idseance) as nbseance FROM seance,profmod,prof where seance.idprofmod=profmod.idprofmod and prof.idprof=profmod.idprof and prof.idprof='".$data1['idprof']."'" ;
        $result2=mysqli_query($link,$sql2);
        $data2=mysqli_fetch_assoc ( $result2);
        echo"<tr>";
        echo"<td>".$data1['nom']."</td> ";
        echo"<td>".$data1['prenom']."</td>";
        echo"<td>". $data2['nbseance']*2 ."<nbsp> heures"."</td>";
        echo "</tr>";
    }
    ?>
</table>
</body>
<br>
</br>
<a href="ajouterprof.php"> Ajouter un professeur </a>
</html>
