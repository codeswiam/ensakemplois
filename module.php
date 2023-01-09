<?php 
    include ("connexion.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
   
    <link rel="#" href="#">

    <title>module</title>

</head>
<body>
<a href="ajoutermodule.php">ajoutermodule</a>
<?php
echo" <table border=1>";

echo" <th> semestre  </th>";
echo" <th> MODULE  </th>";
        $sql1 = "SELECT * FROM semestre ";
        $result1 = mysqli_query($link,$sql1);
        while ($semestre=mysqli_fetch_assoc($result1))
        {
            $sem=$semestre['idsem'];
           echo" <tr>";
           echo" <td>".$semestre['nomsem'] ." </td>";
        }
   
         $sql3="SELECT nommodule  FROM module WHERE module.idmod=modulefiliere.idmod  and idsem='".$sem."'";
        $result3=mysqli_query($link,$sql3);
        echo" <td>";
        while ($module=mysqli_fetch_assoc($result3))
{
            $mod=$module['idmodule'];
            echo" <div>".$module['nommodule']." </div>";
}
echo "</td>";
echo" </tr>";
echo" </table>";
?>



