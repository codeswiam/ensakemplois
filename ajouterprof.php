<?PHP
    session_start();
    include ("connexion.php");
    if (!isset($_SESSION['admin'])){
        header("Location: acceuil.php");
    } else {
        $admin = $_SESSION['admin'];
    }
?>
<html>
<head>
    <title>Ajout Professeur</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="stylee.css">
</head>
<style>
    .pseudo{
        color:red;
        font-weight: bold;
        text-decoration: underline;
    }
    input{
        width: 501px;
    }
</style>
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

    <h1>Ajout d'un professeur</h1>


<form action=# method="post" enctype="multipart/form-data">


    <h4>Nom:</h4><input type="text" name="txt_nom"  ></br>
    <h4>Prénom:</h4><input type="text" name="txt_prenom"  ></br>
    <h4>Email:</h4> <input type="email" name="txt_email" ></br>
    <h4>Mot de passe:</h4> <input type="password" name="txt_pass" ></br>
    <h4>Image:</h4><input type="file" name="fichier" size="30"><br/>
    </br>


    <input type="submit" name="envoyer" value="ajouter"></br>
</form>
<?php
if(isset($_POST['envoyer'])){
    $email=$_POST["txt_email"];
    $pass=$_POST["txt_pass"];
    $nom=$_POST["txt_nom"];
    $prenom=$_POST["txt_prenom"];
    $image=$_POST["fichier"];


    echo"<br>";

    print "<a href='professeur.php'>Retour page professeur</a>";
    if(isset($_FILES['fichier']) and $_FILES['fichier']['error']==0){
        echo'done';
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
        $ph_name="inconnu.jpeg";}
    $sql="insert into prof (NOM,PRENOM,mdp,email,photo) 
values ('$pass','$nom','$prenom','$email','$ph_name')";
    $resultat=mysqli_query($link,$sql);
    if ($resultat==true) {
        header("Location: professeur.php");
    }
    else
    {
        echo "Erreur lors de la création de votre compte";
    }}
?>
<a href="professeur.php" id="retour">Retour</a>

</body>
</html>