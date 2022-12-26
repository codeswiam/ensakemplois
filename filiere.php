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
        <?php
        include ("connexion.php");
        echo"<table border=1>";
        echo"<tr>";
        echo"<th>Semestre</th>";
        echo"<th>Filiere</th>"; 
        echo"<th>Charge horaire</th>";
        echo"<th>Groupes td</th>";
        echo"<th>Groupes tp</th>";
        echo "</tr>";
        $sql="select * from semestre"; 
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
        $res = mysqli_query($link,$sql);
        while($semestre=mysqli_fetch_assoc($res)){
            $sem= $semestre['idsem'];

            $sql1="select idsem_fi, nomfiliere from sem_fi, filiere where sem_fi.idfiliere = filiere.idfiliere and idsem='".$sem."'";
            $res1=mysqli_query($link,$sql1);
            $numfil = mysqli_num_rows($res1);
            if($numfil==0){
                echo "<tr><td>".$semestre['nomsem']."</td>";
                echo "<td></td>"; // ce sem n'a pas de filiere
                echo "<td></td>"; // pas de filiere donc pas de charge horaire
                echo "<td></td>"; // pas de filiere donc pas de grp td
                echo "<td></td>"; // pas de filiere donc pas de grp tp
                echo "</tr>";
            } else {
                echo"<tr>";
                echo "<td rowspan='".$numfil."'>".$semestre['nomsem']."</td>";
                while($filiere=mysqli_fetch_assoc($res1)){
                    $fil=$filiere['idsem_fi'];
                    echo "<td>".$filiere['nomfiliere']."</td>";
                    
                    // partie charge horaire
                    // requete sql qui compte le nbr de seances totales de cette filiere
                    $sql4 = "select count(idseance) as nbrseance from seance 
                    where idseance in (select idseance from seancecours where idsem_fi = '".$fil."')
                    or idseance in (select idseance from seancetd where groupetd in (select groupetd from groupetd where idsem_fi = '".$fil."'))
                    or idseance in (select idseance from seancetp where groupetp in (select groupetp from groupetp where idsem_fi = '".$fil."'))";
                    $res4=mysqli_query($link,$sql4);
                    if(mysqli_num_rows($res4)==0)
                        echo"<td></td>";
                    else{
                        echo"<td>";
                        while($ch=mysqli_fetch_assoc($res4)){
                            $ch=$ch['nbrseance']*2;
                            echo"<div>".$ch."</div>";
                        }
                        echo"</td>";

            }
                    // mor matakhdi le resultat b fetch assoc, ila kant dik nbrseance kaysawi 0 bi ma3na filiere ma3endeha ta seance enregistrée fla base de donnees 
                    // donc diri echo<td></td> ze3ma hatb9a khawya
                    // sinon diri echo <td> w tu multiplie nbreance*2, 7it kan7esbou le nbr de jour, w diri echo l had le resultat w seddi </td>
                    
                    // partie grp td
                    $sql2="select nomgrp from groupetd where idsem_fi='".$fil."'";
                    $res2=mysqli_query($link,$sql2);
                    if(mysqli_num_rows($res2)==0)
                        echo"<td></td>";
                    else{
                        echo"<td>";
                        while($td=mysqli_fetch_assoc($res2)){
                            echo $td['nomgrp']." ";
                        }
                        echo"</td>";
                        }
                    
                    // partie grp tp
                    $sql3="select nomgrp from groupetp where idsem_fi='".$fil."'";
                    $res3=mysqli_query($link,$sql3);
                    if(mysqli_num_rows($res3)==0)
                        echo"<td></td>";
                    else{
                        echo"<td>";
                        while($td=mysqli_fetch_assoc($res3)){
                            echo $td['nomgrp']." ";
                        }
                        echo"</td>";
                        }
                    echo "</tr>";
                }
            }
            
            //$sql4="select ";
            //

        }
        echo"</table>";
        ?>

    


    




</body>
