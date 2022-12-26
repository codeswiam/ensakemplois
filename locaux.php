<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
   
    <link rel="#" href="#">

    <title>module</title>

</head>
<body>
<a href="ajouterbatiment.php">ajouterbatiment</a>
<a href="ajoutersalle.php">ajoutersalle</a>
</br>

</br>

<td>
    <label for="batiment" >batiment</label></br>
    <select name="batiment" >
<?php
include ("connexion.php");

$sql1="SELECT nombatiment FROM `batiment`";
$result1=mysqli_query($link,$sql1);
while ($batiment=mysqli_fetch_assoc($result1))
{
echo '<option value='.$batiment["nombatiment"].'>';
echo $batiment["nombatiment"];
echo'</option>';
}
?>
</td>


<td>
    <label for="salle" >salle</label></br>
    <select name="salle" >
<?php
include ("connexion.php");

$sql2="SELECT numsalle  FROM `salle`";
$result2=mysqli_query($link,$sql2);
while ($batiment=mysqli_fetch_assoc($result2))
{
echo '<option value='.$salle["numsalle"].'>';
echo $salle["numsalle"];
echo'</option>';
}
?>
</td>





