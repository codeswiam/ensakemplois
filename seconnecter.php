<?php
    include("connexion.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="stylee.css">
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
    
    <form action="#" method="post" name="form" class="myform">
        <?php
        session_start();
        if ($_SESSION['session'] == "prof"){
            echo "<h1>Bienvenue Dans L'Espace Professeur</h1>";
            echo "<h4>connecter-vous a votre compte</h4>";
        }
            else if ($_SESSION['session'] == "admin"){
                echo "<h1>Bienvenue Dans L'Espace Adminstrateur</h1>";
                echo "<h4>connecter-vous a votre compte</h4>";
        }?>


        <div>
            <label for="email">Email:</label> 
            <input type="email" name="email" id="" required>
        </div>
        
        <div>
            <label for="mdp"> Mot de Passe:</label> 
            <input type="text" name="mdp" id="" required>
        </div>
        
        <input type="submit" value="Connexion" name="connexion">

    </form>
    <?php
        if (isset($_POST['connexion'])){
            $email = $_POST['email'];
            $mdp = $_POST['mdp'];
            $trouve = 0;
            if ($_SESSION['session'] == "prof"){
                $sql = "select idprof, email, mdp from prof";
                $res = mysqli_query($link, $sql) or die ("Erreur de connexion à la base.");
                while ($data = mysqli_fetch_assoc($res)){
                    if ($email == $data['email'] and $mdp == $data['mdp']){
                        $trouve = 1;
                        $_SESSION['prof'] = $data['idprof'];
                        header("Location: acceuil.php");
                        break;
                    }
                }   
            }
            else if ($_SESSION['session'] == "admin")  {
                $sql = "select idadmin, email, mdp from admin";
                $res = mysqli_query($link, $sql) or die ("Erreur de connexion à la base.");
                while ($data = mysqli_fetch_assoc($res)){
                    if ($email == $data['email'] and $mdp == $data['mdp']){
                        $trouve = 1;
                        $_SESSION['admin'] = $data['idadmin'];
                        header("Location: acceuil.php");
                        break;
                    }
                } 
            }
            if (!$trouve){
                echo "<font size=5 color=red>
          Les données que vous avez saisies sont incorrectes. Veuillez réessayer.
          </font>";
            }
        }
    ?>



</body>
</html>