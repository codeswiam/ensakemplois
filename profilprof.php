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
    <link rel="stylesheet" href="style.css">
</head>
<body>
<nav>
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

<a href="deconnexion.php"> Se déconnecter </a>
<h1>VOTRE PROFIL :</h1>
<?php
$sql="select * from prof where idprof='".$_SESSION['prof']."'";
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
<button onclick="myFunction()">modifier le profil</button>
<script>
    function myFunction() {
        var section = document.getElementById("my-section");
        section.style.display = "block";
    }
</script>
<section id="my-section">
    <form action="#" method="post" enctype="multipart/form-data">
        <h4>clicker sur modifier apres changement de vos donner</h4>
        <hr>

        <label for="nom">Nom  </label>
        <input type="text" name="nom" value=<?php echo $data["nom"];?>><br>
        <label for="prenom" >Prénom  </label>
        <input type="text" name="prenom" value=<?php echo $data["prenom"];?>><br>
        <label for="email">Nom  </label>
        <input type="text" name="email" value=<?php echo $data["email"];?>><br>
        <label for="mdp">mot de passe </label>
        <input type="password" name="mdp" value=<?php echo $data["mdp"];?>><br>
        <h4>Photo</h4><hr>
        <label for="image">Déposez votre nouvelle image </label>
        <input type="file" name="fichier"><br><br>
        <input type="submit" name="envoyer" value="modifier" class="submit">
    </form>
</section>
</body>

</html>
<?php
if(isset($_POST['envoyer'])){

    $email=$_POST['email'];
    $nom=$_POST["nom"];
    $prenom=$_POST["prenom"];
    $mdp=$_POST["mdp"];

    if(isset($_FILES['fichier']) and $_FILES['fichier']['error']==0){
        $dossier = 'images/'; // dossier où sera déplacé le fichier
        $nom_temporaire = $_FILES['fichier']['tmp_name'];
        if( !is_uploaded_file($nom_temporaire) )
        {exit("Le fichier est introuvable");}
// on copie le fichier dans le dossier de destination

        if($_FILES['fichier']['size']>=10000000)
        {exit("fichier volumineux");}
        $infofichier=pathinfo($_FILES['fichier']['name']);
        $extension_upload=$infofichier['extension'];
        $extension_upload=strtolower($extension_upload);
        $extension_authorise=array('png','jpeg','jpg');
        if(!in_array($extension_upload,$extension_authorise))
        {exit("extension non authorisée svp(authorised(png,jpg,jpeg)");}
        $nom_photo=$nom.".".$extension_upload;
        if(!move_uploaded_file($nom_temporaire,$dossier.$nom_photo))
        {
            exit("error");
        }
        $ph_name=$nom_photo;}
    else{
        $ph_name=$data["photo"];}

    $sql="update prof set
NOM='$nom',PRENOM='$prenom',email='$email',photo='$ph_name', mdp='$mdp' where
idprof='$prof'";
    $resultat=mysqli_query($link,$sql);
    if ($resultat==true) {
        echo " Votre compte a été modifié correctement";
    }
    else{echo "Erreur lors de la modification de votre compte";}}


?>

