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
        <th>Filiere</th> <!-- diri semestre houwwa lewwel 3ad filiere -->
        <th>Semestre</th> <!-- charge horaire diriha hna mor semestre w filiere-->
        <th>Groupes td</th>
        <th>Groupes tp</th>
        <th>Charge horaire</th>

        <?php
        include ("connexion.php");
        $sql="select nomfiliere,nomsem,groupetd.nomgrp,groupetp.nomgrp,nbretudiants
        from filiere,sem_fi,semestre,groupetd,groupetp
        where sem_fi.idfiliere=filiere.idfiliere 
        and sem_fi.idsem_fi=groupetd.idsem_fi
        and sem_fi.idsem_fi=groupetp.idsem_fi
        and sem_fi.idsem=semestre.idsem"; // a malek 3la had la requete 9eddeha 9eddash hhhhh
        // hanti katdiri select * from semestre 
        // moraha mor makatakhdi l resultat kat7elli l boucle while dyal fetch assoc
        // west menneha katakhdi l'id sem, kat afficher le nom d sem b  echo <td> nomsem </td>
        /* w nti mazala west dik la boucle katdiri 
        select idsem_fi, nomfiliere from sem_fi, filiere where sem_fi.idfiliere = filiere.idfiliere and idsem=(variable sem lli hezziti)
        moraha menni katdir le resultat w kat7elli la boucle fetch assoc dyal had le resultat, katakhdi idsem_fi w katafficher le nomfiliere
        3ad katmshi tehezzi les groupes td bou7dhoum w les grps tps bou7dhoum en utilisant dik idsem_fi lli hezziti 9bayla,
        <td> diri boucle while dyal fetch assoc dles grps tds </td>
        nefs l7aja pour les grps tps
        */
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
