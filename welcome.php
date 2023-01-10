<?php
include ("connexion.php");
session_start();
if (isset($_GET["semestre"]) && $_GET["semestre"] != "S0") {
    $getsem = $_GET["semestre"];
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>WELCOME!</title>
    <link rel="stylesheet" href="style2.css">
</head>
<body>
<header>
    <h2> bienvenue sur <span>EMPLOI ENSAK</span> </h2>
<img src="photo/cookie.jpg" width="900" height="500" id="ensak">
</header>
<section>
    <h4>Vous êtes ?</h4>
    <form action="#" method="POST" name="form">
    <div>

        <button type="submit" name="prof" title="Envoyer"><figure><img src="photo/professeur.png" class="imgbut" alt="" /> <figcaption>je suis professeur</figcaption> </figure></button>
        <button type="submit" name="admin"  title="Envoyer"><figure><img src="photo/administrateur.png" class="imgbut" alt="" /> <figcaption>je suis adminstrateur</figcaption> </figure></button>

    </div>
    </form>
</section>
</body>
</html>
<?php
if (isset($_POST['prof'])) {

        session_start();
        $_SESSION['session'] = "prof";
        echo  $_SESSION['session'];
        header("Location: seconnecter.php"); }

if (isset($_POST['admin'])) {
        session_start();
        $_SESSION['session'] = "admin";
        header("Location: seconnecter.php");
    }

