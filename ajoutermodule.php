<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ajouter module</title>
</head>
<body>
<!-- ajouter module -->
<form action="traitementmod.php" method="post">
<td><label for="module" >module</label></td></br>
<td><input type="texte" name="nommodule"  ></td>
    </br>
    </br>
    
    <tr>
   
    <label for="">semestre</label><br><br>
    <select name="semestre" >
        <?php
        include("connexion.php");
        $sql = "SELECT * from `semestre`";
        $result = mysqli_query($link,$sql);
        while ($data=mysqli_fetch_assoc ($result)) {
            $semestre=$data['nomsem'];
            $idsem=$data['idsem'];
            echo "<option value=".$idsem.">$semestre</option>";
        }
        ?>
    </select><br>


    <input type="submit" value="ajouter"  name="ajouter">

