<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
   
    <link rel="#" href="#">

    <title>ajouter module</title>

</head>
<body>

</br>

</br>

<td>
    <label for="semestre" >semestre</label></br>
    <select name="semestre" >

    <?php
include ("connexion.php");

 $sql1="SELECT * FROM `semestre`";
$result1=mysqli_query($link,$sql1);
while ($semestre=mysqli_fetch_assoc($result1))
{
echo '<option value='.$semestre["nomsem"].'>';
echo $semestre["nomsem"];
echo'</option>';
}
?>
</td>
</br>
</br>
<td>
    <label for="module" >module</label></br>
    <input type="texte" name="module" >
</td>
    </br>
    <input type="submit" value="valider" >

    <?php
include ("connexion.php");

if(isset($_POST['valider']))
{
	$module=$_POST['module'];

	
    $requette="INSERT INTO `module`( `nommodule`) VALUES ('$module')";
	$resultat=mysqli_query($link,$requette);
    header('location: module.php');
}

?>