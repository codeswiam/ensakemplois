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
            echo"<tr>";
            echo"<td>".$semestre['nomsem']."</td>";
            $sql1="select idsem_fi, nomfiliere from sem_fi, filiere where sem_fi.idfiliere = filiere.idfiliere and idsem='".$sem."'";
            $res1=mysqli_query($link,$sql1);
            if(mysqli_num_rows($res1)==0)
                echo"<td></td>";
            else{
                echo"<td>";
                while($filiere=mysqli_fetch_assoc($res1)){
                    $fil=$filiere['idsem_fi'];
                    echo"<div>".$filiere['nomfiliere']."<div>";
                    $sql2="select nomgrp from groupetd where idsem_fi='".$fil."'";
                    $res2=mysqli_query($link,$sql2);
                    if(mysqli_num_rows($res2)==0)
                        echo"<td></td>";
                    else{
                        echo"<td>";
                        while($td=mysqli_fetch_assoc($res2)){
                            echo"<div>".$td['nomgrp']."</div>";
                        }
                        echo"</td>";
                        }
                    
                    }
                echo"</td>"; 
                

            }
            
            //$sql4="select ";
            //$res4=mysqli_query($link,$sql4);
            /*if(mysqli_num_rows($res4)==0)
                echo"<td></td>";
            else{
                echo"<td>";
                while($ch=mysqli_fetch_assoc($res4)){
                    echo"<div>".$ch['nomgrp']."</div>";
                }
                echo"</td>";

            }*/
            


        echo"</tr>";

        }
        echo"</table>";
        ?>

    


    




</body>
