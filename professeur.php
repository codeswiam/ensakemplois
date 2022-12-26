<html>
<head>
    <title>mycv</title>
    <link rel="stylesheet" href="style.css">
</head>
<style>
    .pseudo{
        color:red;
        font-weight: bold;
        text-decoration: underline;
    }
    input{
        width: 500px;
    }
</style>
<body>
<table cellpadding="20px"cellspacing="10px" >
 <tr >
         <th >nom</th>
         <th >prenom</th>
          <th >charge horaire</th>
     </tr>
<?php
session_start();
include "connexion.php";
$sql1="SELECT * FROM prof" ;
$result1=mysqli_query($link,$sql1);

 while($data1=mysqli_fetch_assoc ( $result1)){
        echo"<tr>";
        echo"<td>".$data1['nom']."</td> ";
        echo"<td>".$data1['prenom']."</td>";
        echo "</tr>";
    }
?>
</table>
</body>
</html>
