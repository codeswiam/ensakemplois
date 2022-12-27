<?php
    include ("connexion.php");
?>

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
<form method="POST" action="#"> <!-- action kounti mkhelyaha khawya  -->
<label >Semestre</label></br>
<select name="semestre" >
<?php
            $sql1="select * from semestre";
            $result1=mysqli_query($link,$sql1);
            while ($liste1=mysqli_fetch_assoc($result1))
            {
            echo '<option value='.$liste1["idsem"].'>';
            echo $liste1["nomsem"];
            echo'</option>';
            }
            ?>
</select><br>

<label >Nom de la Filliere</label></br>
<select name="filiere" >
<?php
            $sql="select * from filiere";
            $result=mysqli_query($link,$sql);
            while ($liste=mysqli_fetch_assoc($result))
            {
            echo '<option value='.$liste["idfiliere"].'>';
            echo $liste["nomfiliere"];
            echo'</option>';
            }
            ?>
    </select><br>

<label >Nom du grp </label></br>
<input type="text" name="nom"></br>

<input type="submit" name="ajouter" value="ajouter">


</form>

</body>

<?php
if (isset($_POST['ajouter'])){
    $fi=$_POST['filiere'];
    echo $fi;
    $sem=$_POST['semestre'];
    echo $sem;
    $nom=$_POST['nom'];
    echo $nom;
    $sql4="select idsem_fi from sem_fi where idsem='".$sem."' and idfiliere='".$fi."'";
    $result4 = mysqli_query($link,$sql4) or die("Echec semfi");
    while($data4=mysqli_fetch_assoc($result4)){
        echo "on a selectionné l'idsem";
        $semfi=$data4['idsem_fi'];
        echo $semfi;
        $sql2="insert into groupetp values(NULL,'".$semfi."','".$nom."')";
        $result2 = mysqli_query($link,$sql2) or die("Echec groupetp");
    }
    if($result2==true){
        echo'<a href="filiere.php" >Retour</a></br>';
        echo'<a href="ajoutertd.php" >Ajouter un autre groupe</a></br>';
    }

}   




?>