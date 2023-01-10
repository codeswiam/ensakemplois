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
    <title>Ajout Filière</title>
    <link rel="stylesheet" href="style.css">
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
    <h1>Ajout d'une filière</h1>
    <form method="POST" action="#">

        <label >Nom de la Filière</label></br>
        <input type="text" name="nom" required></br>

        <label >Abréviation de la Filière </label></br>
        <input type="text" name="abv" required></br>

        <label >Semestre </label></br>
        <?php
            $sql1="select * from semestre";
            $result1=mysqli_query($link,$sql1);
            while ($liste1=mysqli_fetch_assoc($result1))
            {
                echo '<input type="checkbox" name="sem[]" value='.$liste1["idsem"].'>';
                echo $liste1["nomsem"];
                echo'</option>';
            }
        ?>
        </br>

        <input type="submit" name="ajoutfil" value="Ajouter Filière">

    </form>
    <?php
        if(isset($_POST['ajoutfil'])){
            $nom=$_POST["nom"];
            $abv=$_POST["abv"];
            $choix=$_POST["sem"];
            $sql1="insert into filiere values ('".$abv."','".$nom."')";
            $result1 = mysqli_query($link,$sql1);
            foreach($choix as $value){
                echo $value;
                $sql="insert into sem_fi values(NULL,'$value','$abv')";
                $result = mysqli_query($link,$sql);
            }
            if ($result == true){
                header("Location: filiere.php");
            }
        }
    ?>
    <a href="filiere.php">Retour</a>
</body>
</html>
