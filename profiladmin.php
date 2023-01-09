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
    <title>Profil</title>
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
    <?php
        $sql="select * from admin where idadmin='".$_SESSION['admin']."'";
        $result=mysqli_query($link,$sql);
        $data= mysqli_fetch_assoc($result);
    ?>
    <?php echo"<p><img src=photo/".$data["photo"]."></p>"; ?>
    <h3>Nom</h3>
    <?php  echo $data["nom"];?>
    <h3>Prenom</h3>
    <?php echo $data["prenom"]; ?>
</br>
    <h3>Email</h3>
    <?php echo $data["email"];?>
</br>

    <a href="deconnexion.php"> Se déconnecter </a> 
</body>
</html>