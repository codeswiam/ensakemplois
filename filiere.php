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
    <title>Filières</title>
</head>
<body>
    <nav> 
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

    <h1>FILIÈRES</h1>

    <ul> 
        <li><a href="ajouterfiliere.php">Ajouter filière</a></li>
        <li><a href="ajoutertd.php">Ajouter un groupe de td</a></li>
        <li><a href="ajoutertp.php">Ajouter un groupe de tp</a></li>                                  
    </ul>                                    

    <?php
        echo"<table border=1>";
        echo"<tr>";
        echo"<th>Semestre</th>";
        echo"<th>Filière</th>"; 
        echo"<th>Charge horaire</th>";
        echo"<th>Groupes td</th>";
        echo"<th>Groupes tp</th>";
        echo "</tr>";
        $sql="select * from semestre"; 
        $res = mysqli_query($link,$sql);
        while($semestre=mysqli_fetch_assoc($res)){
            $sem= $semestre['idsem'];

            $sql1="select idsem_fi, nomfiliere from sem_fi, filiere where sem_fi.idfiliere = filiere.idfiliere and idsem='".$sem."'";
            $res1=mysqli_query($link,$sql1);
            $numfil = mysqli_num_rows($res1);
            if($numfil==0){
                echo "<tr><td>".$semestre['nomsem']."</td>";
                echo "<td></td>"; // ce sem n'a pas de filiere
                echo "<td></td>"; // pas de filiere donc pas de charge horaire
                echo "<td></td>"; // pas de filiere donc pas de grp td
                echo "<td></td>"; // pas de filiere donc pas de grp tp
                echo "</tr>";
            } else {
                echo"<tr>";
                echo "<td rowspan='".$numfil."'>".$semestre['nomsem']."</td>";
                while($filiere=mysqli_fetch_assoc($res1)){
                    $fil=$filiere['idsem_fi'];
                    echo "<td>".$filiere['nomfiliere']."</td>";
                    $sql4 = "select count(idseance) as nbrseance from seance 
                    where idseance in (select idseance from seancecours where idsem_fi = '".$fil."')
                    or idseance in (select idseance from seancetd where groupetd in (select groupetd from groupetd where idsem_fi = '".$fil."'))
                    or idseance in (select idseance from seancetp where groupetp in (select groupetp from groupetp where idsem_fi = '".$fil."'))";
                    $res4=mysqli_query($link,$sql4);
                    if(mysqli_num_rows($res4)==0)
                        echo"<td></td>";
                    else{
                        echo"<td>";
                        while($ch=mysqli_fetch_assoc($res4)){
                            $ch=$ch['nbrseance']*2;
                            echo"<div>".$ch."</div>";
                        }
                        echo"</td>";

                    }   

                    // partie grp td
                    $sql2="select nomgrp from groupetd where idsem_fi='".$fil."'";
                    $res2=mysqli_query($link,$sql2);
                    if(mysqli_num_rows($res2)==0)
                        echo"<td></td>";
                    else{
                        echo"<td>";
                        while($td=mysqli_fetch_assoc($res2)){
                            echo $td['nomgrp']." ";
                        }
                        echo"</td>";
                        }
                    
                    // partie grp tp
                    $sql3="select nomgrp from groupetp where idsem_fi='".$fil."'";
                    $res3=mysqli_query($link,$sql3);
                    if(mysqli_num_rows($res3)==0)
                        echo"<td></td>";
                    else{
                        echo"<td>";
                        while($td=mysqli_fetch_assoc($res3)){
                            echo $td['nomgrp']." ";
                        }
                        echo"</td>";
                        }
                    echo "</tr>";
                }
            }
        }
        echo"</table>";
    ?>
</body>
</html>