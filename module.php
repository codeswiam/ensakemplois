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
    <title>Module</title>
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
    <h1>Modules</h1>
    <a href="ajoutermodule.php">Ajouter Module</a> 
    <table border=1>
        <tr>
            <th>Semestre</th>      
            <th>Module</th>
            <th>Professeurs</th>
        </tr>
        <?php
            $sql="select * from semestre"; 
            $res = mysqli_query($link,$sql);
            while($semestre=mysqli_fetch_assoc($res)){
                $sem= $semestre['idsem'];
    
                $sql1="select nommodule, idmod from module where idsem = '".$sem."'";
                $res1=mysqli_query($link,$sql1);
                $nummod = mysqli_num_rows($res1);
                if($nummod==0){
                    echo "<tr><td>".$semestre['nomsem']."</td>";
                    echo "<td></td>"; // ce sem n'a pas de filiere
                    echo "<td></td>"; // pas de filiere donc pas de charge horaire
                    echo "</tr>";
                } else {
                    echo"<tr>";
                    echo "<td rowspan='".$nummod."'>".$semestre['nomsem']."</td>";
                    while($module=mysqli_fetch_assoc($res1)){
                        $mod=$module['idmod'];
                        echo "<td>".$module['nommodule']."</td>";
                        $sql4 = "select nom from prof, profmod where prof.idprof = profmod.idprof and idmod = '".$mod."'";
                        $res4=mysqli_query($link,$sql4);
                        $numprofs = mysqli_num_rows($res4);
                        if($numprofs==0)
                            echo"<td></td></tr>";
                        else{
                            echo"<td>";
                            $i = 1;
                            while($data=mysqli_fetch_assoc($res4)){
                                echo $data['nom'];
                                if ($numprofs > 1 and $i < $numprofs){
                                    echo ", ";
                                    $i++;
                                }

                            }
                            echo"</td></tr>";
                        }   
                    }
                }
            }
        ?>
    </table>
    ?>
