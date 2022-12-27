<!DOCTYPE html>
<html lang= "fr " dir="ltr" ></html>
<head>
    <title>FORMULAIRE</title>
    <meta name="author" content="Nom de la personne qui a réalisé la page"/>
    <meta charset= " utf-8" />
    <meta name="keywords" />
    <link rel="stylesheet" href="style.css" />
    
</head>

<body>
<form method="POST" action="">
<label >Nom de la Filliere</label></br>
    <input type="text" name="nom"></br>
<label >Abréviation de la Filliere </label></br>
    <input type="text" name="abv"></br>
<label >Semestre </label></br>
    <!-- ces valeurs doivent venir de la base de donnees
     katdiri une requete sql katakhed lik kolshi men semestre
     diri une boucle b7al lli mwalfin kandiro m3a les listes melli kannakhdo les valeurs
     men lbase de donnees, hi houwwa f blast matdiri dik select w option katdiri input type checkbox
     w west l value kaykounou les idsem w dakshi lli kayt afficha houwwa le nomsem -->
     <?php
        include("connexion.php");
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
    <label >Nombre d'etudiants </label></br>
    <input type="text" name="nbr"></br>
<input type="submit" name="submit" value="envoyer">


</form>


</body>

<?php
include ("connexion.php");
if(isset($_POST['submit'])){
$nom=$_POST["nom"];
$abv=$_POST["abv"];
$choix=$_POST["sem"];
$nbr=$_POST["nbr"];
$sql1="insert into filiere values ('".$abv."','".$nom."')";
$result1 = mysqli_query($link,$sql1);
print_r($choix);
 foreach($choix as $value){
    echo $value;
    $sql="insert into sem_fi values(NULL,'$value','$abv','$nbr')";
    $result = mysqli_query($link,$sql);


 }
/* hna katdiri $sql = "insert into filiere values (idfiliere, nomfiliere)"
 lmhm katkhshi les variables diri concatenation w dak l3jeb
 w sf katdiri $result = mysqli_query...*/



}
// shoufi l'exemple lli sifet lik 3la hadshi dyal choix multiples
/* west la boucle foreach, mor makatkhdi la valeur dyal sem
katmshi bash tdiri la relation sem_fi $sql = "insert into sem_fi values (NULL, idsem, idfiliere)" 
w moraha $result = mysqli_query...*/

// ila mafhmtish shi 7aja sifti liyya msg
?>