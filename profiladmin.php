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
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="stylee.css">
    <style>
    
    </style>
</head>
<body>
    <nav> 
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
    <?php
        $sql="select * from admin where idadmin='".$_SESSION['admin']."'";
        $result=mysqli_query($link,$sql);
        $data= mysqli_fetch_assoc($result);
    ?>
    <section class="card">
        <aside>
    <?php echo"<p><img  id='image' src=images/".$data["photo"]."></p>"; ?></aside>
        <article>
    <span>Nom :
            <?php  echo $data["nom"];?>
    </span>
            <span>Prenom :
    <?php echo $data["prenom"]; ?>
            </span>
</br>
            <span>Email:
           <?php echo $data["email"];?>
            </span>
</br>
        </article>
    
            </section>
            <form method="POST" action="#" id="form2">
    <input type="submit" value="Se déconnecter" name="deconnecter"> 
            </form>  

  
</body>
<?php 
    if(isset($_POST["deconnecter"])){
        header("location: deconnexion.php");
    }
?>
</html>