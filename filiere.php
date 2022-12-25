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
<nav>
     <ul > 
            <li ><a href=#>FILIERE</a></li>
            <li><a href="">Ajouter filière</a></li>
            <li><a href="">Ajouter un groupe de td</a></li>
            <li><a href="" >Ajouter un groupe de tp</a></li>                                  
    </ul>                                    
                                          
</nav>
    
    <h2>FILLIERE</h2>
<table>
    <tr>
        <th>Filliere</th>
        <th>Semestre</th>
        <th>Groupe td</th>
        <th>Groupe tp</th>
        <th>Charge horaire</th>

        <?php
        include ("connexion.php");
        $sql="select nomfiliere,nomsem,groupetd.nomgrp,groupetp.nomgrp,nbretudiants
        from filiere,sem_fi,semestre,groupetd,groupetp
        where sem_fi.idfiliere=filiere.idfiliere 
        and sem_fi.idsem_fi=groupetd.idsem_fi
        and sem_fi.idsem_fi=groupetp.idsem_fi
        and sem_fi.idsem=semestre.idsem";
        $result = mysqli_query($link,$sql);
        while($data=mysqli_fetch_assoc($result)){
            echo"<tr>";
            echo"<td>".$data['nomfiliere']."</td>";
            echo"<td>".$data['nomsem']."</td>";
            echo"<td>".$data['nomgrp']."</td>";
            echo"<td>".$data['nomgrp']."</td>";
            echo"<td>".$data['nbretudiants']."</td>";
            echo"</tr>";

        }

        ?>

    </tr>
    <table>


    




</body>
