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
<select name="filiere" >
<?php
include ("connexion.php");
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
<label >Semestre</label></br>
<select name="semestre" >
<?php
include ("connexion.php");
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
<label >Nom du grp </label></br>
<input type="text" name="nom"></br>

<input type="submit" name="ajouter" value="ajouter">


</form>

</body>

<?php
include ("connexion.php");
$fi=$_POST['filiere'];
$sem=$_POST['semestre'];
$nom=$_POST['nom'];
if(isset($_POST["ajouter"])){
    $sql3="select idsem_fi from sem_fi where idsem='$sem' and idfiliere='$fi";
    $result3 = mysqli_query($link,$sql3);
    while($data=mysqli_fetch_assoc($result3))
        $semfi=$data['idem_fi'];
    $sql2="insert into groupetd values(NULL,'$semfi','$nom')";
    $result2 = mysqli_query($link,$sql2);
}



?>