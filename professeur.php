<html>
<head>
    <title>professeur</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <a href="ajouterprof.php"> Ajouter un professeur </a>
</header>

<table border=1>
    <tr >
        <th >Nom</th>
        <th >Prénom</th>
        <th >Charge Horaire</th>
    </tr>
    <?php
    session_start();
    include "connexion.php";
    $sql1="SELECT * FROM prof" ;
    $result1=mysqli_query($link,$sql1);
    while($data1=mysqli_fetch_assoc ( $result1)){
        $sql2="SELECT nom,count(idseance) as nbseance FROM seance,profmod,prof where seance.idprofmod=profmod.idprofmod and prof.idprof=profmod.idprof and prof.idprof='".$data1['idprof']."'" ;
        $result2=mysqli_query($link,$sql2);
        $data2=mysqli_fetch_assoc ( $result2);
        echo"<tr>";
        echo"<td>".$data1['nom']."</td> ";
        echo"<td>".$data1['prenom']."</td>";
        echo"<td>". $data2['nbseance']*2 ."<nbsp> heures"."</td>";
        echo "</tr>";
    }
    ?>
</table>
</body>
</html>
