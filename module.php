<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
   
    <link rel="#" href="#">

    <title>module</title>

</head>
<body>
<a href="ajoutermodule.php">ajoutermodule</a>
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
echo '<option value='.$semestre["idsem"].'>';
echo $semestre["idsem"];
echo'</option>';
}
?>
</select>
</td>
</br>
<td>
    <label for="module" >module</label></br>
    <select name="module" >
<?php
include ("connexion.php");
$semes=$semestre["idsem"];
 $sql3="SELECT nommodule  FROM `module` WHERE semestre='.$semes.'";
$result3=mysqli_query($link,$sql3);
while ($module=mysqli_fetch_assoc($result3))
{
echo '<option value='.$module["nommodule"].'>';
echo $module["nommodule"];
echo'</option>';
}
?>
</select>
</td>

</br>

</br>


<td>
    <label for="prof" >prof</label></br>
    <select name="prof" >
<?php
include ("connexion.php");
 $sql2="SELECT nom FROM `prof` WHERE ";
$result2=mysqli_query($link,$sql2);
while ($prof=mysqli_fetch_assoc($result2))
{
echo '<option value='.$prof["nom"].'>';
echo $prof["nom"];
echo'</option>';
}
?>
</select>
</td>

</br>

</br>




<input type="submit" value="valider" >
</br>

</br>
