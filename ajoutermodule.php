<?php
include ("connexion.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
   
    <link rel="#" href="#">

    <title>ajouter module</title>

</head>
<body>

<tr>
    
    <td><label for="semestre" >semestre</label></br></td>
    <td><select name="semestre" >

    <?php
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
</tr>
</br>

<tr>
<td><label for="module" >module</label></td>
<td><input type="texte" name="module" ></td>

    </br>
    </br>
    <input type="submit" value="valider" >

    <?php
include ("connexion.php");
if(isset($_POST['valider']))
{
	$mod=$_POST['module'];
    echo $module;
    $sem=$_POST['semestre'];
    echo $sem;
    $sql3="SELECT nommodule from module where module.idmod=modulefiliere.idmod" ;
    while($data=mysqli_fetch_assoc($sql3)){
        
        $nommod=$data['nommodule'];
        echo $nommod;
        $sql2="INSERT INTO module values(NULL,'".$nommod."',NULL)";
        $result2 = mysqli_query($link,$sql2) ;
    } 
    header('location: module.php');
}

?>


