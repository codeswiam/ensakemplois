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
        <li><img src="images/logo1.png" width="90px" height="30px"></li>
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
    <div id="container">
    <form action="#" method="post" name="form">

        <div>
            <label for="type">Compte</label>
            <select name="type" id="">
                <option value="prof">Professeur</option>
                <option value="admin">Admin</option>
            </select>
        </div>

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
            </div>
    <?php
        if (isset($_POST['connexion'])){
            $type = $_POST['type'];
            $email = $_POST['email'];
            $mdp = $_POST['mdp'];
            $trouve = 0;
            if ($type == "prof"){
                $sql = "select idprof, email, mdp from prof";
                $res = mysqli_query($link, $sql) or die ("Erreur de connexion à la base.");
                while ($data = mysqli_fetch_assoc($res)){
                    if ($email == $data['email'] and $mdp == $data['mdp']){
                        $trouve = 1;
                        session_start();
                        $_SESSION['prof'] = $data['idprof'];
                        header("Location: acceuil.php");
                        break;
                    }
                }   
            } else {
                $sql = "select idadmin, email, mdp from admin";
                $res = mysqli_query($link, $sql) or die ("Erreur de connexion à la base.");
                while ($data = mysqli_fetch_assoc($res)){
                    if ($email == $data['email'] and $mdp == $data['mdp']){
                        $trouve = 1;
                        session_start();
                        $_SESSION['admin'] = $data['idadmin'];
                        header("Location: acceuil.php");
                        break;
                    }
                } 
            }
            if (!$trouve){
                echo "Les données que vous avez saisies sont incorrectes. Veuillez réessayer.";
            }
        }
    ?>



</body>
</html>