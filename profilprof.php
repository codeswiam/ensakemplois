<?PHP
    session_start();
    include ("connexion.php");
    if (!isset($_SESSION['prof'])){
        header("Location: acceuil.php");
    } else {
        $prof = $_SESSION['prof'];
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profil</title>
    <style>
        section{
            display: none;
        }
    </style>
</head>
<body>
    <nav> 
        <ul>
            <li>Logo Ensa</li>
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

    <a href="deconnexion.php"> Se déconnecter </a>
</body>
</html>