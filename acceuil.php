<?php 
    include ("connexion.php");
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Emplois</title>
</head>
<body>
    <h1> Affichage table 9</h1>
    <?php
        $sql1 = "select * from semestre";
        $res1 = mysqli_query($link, $sql1) or die("Erreur selection semestres");
        while ($semestre= mysqli_fetch_assoc($res1)) {
            $sem = $semestre['idsem'];
            $nomsem = $semestre['nomsem'];
            echo "<h2>".$semestre['nomsem']."</h2>";
            
            // on selectionne la filiere
            $sql2 = "select idsem_fi, nomfiliere from filiere,sem_fi where sem_fi.idfiliere = filiere.idfiliere and idsem='".$sem."'";
            $res2 =  mysqli_query($link, $sql2) or die("Erreur selection filieres");
            while ($filiere= mysqli_fetch_assoc($res2)) {
                $fil = $filiere['idsem_fi'];
                $nomfiliere = $filiere['nomfiliere'];
                echo "<h3>".$nomfiliere."</h3>";
                // creation d'une view qui contient toutes les seances de cette filiere
                $sql = "create or replace view seancefiliere as select idseance from seance 
                where idseance in (select idseance from seancecours where idsem_fi = '".$fil."')
                or idseance in (select idseance from seancetd where groupetd in (select groupetd from groupetd where idsem_fi = '".$fil."'))
                or idseance in (select idseance from seancetp where groupetp in (select groupetp from groupetp where idsem_fi = '".$fil."'))";
                $res = mysqli_query($link, $sql) or die("Erreur creation view");
                $sql = "select * from seancefiliere";
                $res = mysqli_query($link, $sql) or die("Erreur selection seance de filiere");
                if (mysqli_num_rows($res) == 0) {
                    echo "Aucun emploi disponible pour ".$nomfiliere." de ".$nomsem."."; // cas ou on n'a aucune seance enregistrée pour cette filière
                } else {
                    echo "<div class=\"emploi\">";
                    echo "<div class=\"titre\">Organisation des enseignements<br>".$nomfiliere." <span class=\"semestre\">(".$nomsem.")</span></div>";
                    echo "<table border=\"2\">";
                    echo "<th> Jour / Horaire </th>";

                    $sql4 = "select * from creneau";
                    $res4 = mysqli_query($link, $sql4) or die("Erreur selection creneau");
                    while ($horaire= mysqli_fetch_assoc($res4)){ 
                        // affichage de l'horaire 
                        echo "<th>".$horaire['starttime']." - ".$horaire['endtime']."</th>";
                    }

                    $sql3 = "select * from jour";
                    $res3 = mysqli_query($link, $sql3) or die("Erreur selection jours");
                    while ($jours= mysqli_fetch_assoc($res3)) {
                        $jour = $jours['idjour'];
                        echo "<tr>";
                        
                        // affichage des jours
                        echo "<td>".$jours['nomjour']."</td>";
                        $res4 = mysqli_query($link, $sql4) or die("Erreur selection creneau");
                        while ($horaire= mysqli_fetch_assoc($res4)){
                            $creneau = $horaire['idcreneau'];
                            // on selectionne la seance
                            $sql5 = "select seance.idseance, idsalle, idprofmod, type from seance, seancefiliere where seance.idseance = seancefiliere.idseance and idjour='".$jour."' and idcreneau='".$creneau."'";
                            $res5 = mysqli_query($link, $sql5) or die("Erreur selection seance");
                            if (mysqli_num_rows($res5) == 0){
                                    echo "<td></td>"; // cas de seance vide
                            } else {
                                echo "<td>";
                                while ($data= mysqli_fetch_assoc($res5)) {
                                    $seance = $data['idseance'];
                                    $salle = $data['idsalle'];
                                    $profmod = $data['idprofmod'];
                                    $type = $data['type'];
                                    
                                    // affichage du type de seance avec filieres/grp td/ grp tp
                                    echo "<div class=\"type\">".$type;
                                    if ($type == "Cours")
                                    {
                                        $sql6 = "select filiere.idfiliere from seancecours, filiere, sem_fi 
                                        where sem_fi.idsem_fi = seancecours.idsem_fi and sem_fi.idfiliere = filiere.idfiliere
                                        and idseance='".$seance."'";
                                        $res6 = mysqli_query($link, $sql6) or die("Erreur selection seancecours");
                                        $rows = mysqli_num_rows($res6);
                                        if ($rows > 1){
                                            $i = 1;
                                            echo "(";
                                            while ($grp = mysqli_fetch_assoc($res6)) {
                                                echo $grp['idfiliere'];
                                                if ($i != $rows)
                                                    echo " + "; 
                                                $i++;                     
                                            }
                                            echo ")"; 
                                        }
                                    }
    
                                    if ($type == "TD")
                                    {
                                        $sql7 = "select nomgrp from seancetd, groupetd
                                        where seancetd.groupetd = groupetd.groupetd
                                        and idseance='".$seance."'";
                                        $res7 = mysqli_query($link, $sql7) or die("Erreur selection seancetd");
                                        $rows = mysqli_num_rows($res7);
                                        if ($rows > 1){
                                            $i = 1;
                                            echo "(";
                                            while ($grp = mysqli_fetch_assoc($res7)) {
                                                echo $grp['nomgrp'];
                                                if ($i != $rows)
                                                    echo " + ";
                                                $i++;                       
                                            }
                                            echo ")"; 
                                        }
                                    }
    
                                    if ($type == "TP")
                                    {
                                        $sql8 = "select nomgrp from seancetp, groupetp
                                        where seancetp.groupetp = groupetp.groupetp
                                        and idseance='".$seance."'";
                                        $res8 = mysqli_query($link, $sql8) or die("Erreur selection seancetd");
                                        $rows = mysqli_num_rows($res8);
                                        if ($rows > 1){
                                            $i = 1;
                                            echo "(";
                                            while ($grp = mysqli_fetch_assoc($res8)) {
                                                echo $grp['nomgrp'];
                                                if ($i != $rows)
                                                    echo " + ";
                                                $i++;                       
                                            }
                                            echo ")"; 
                                        }
                                    }
                                    echo "</div>";
    
                                    $sql9= "select nom, nommodule from profmod, prof, module 
                                    where profmod.idprof = prof.idprof and profmod.idmod = module.idmod and idprofmod='".$profmod."'";
                                    $res9 = mysqli_query($link, $sql9) or die("Erreur selection prof/module");
                                    while ($profmod= mysqli_fetch_assoc($res9)) {
                                        echo "<div class=\"module\">".$profmod['nommodule']."</div>";
                                        echo "<div class=\"prof\">Prof ".$profmod['nom']."</div>";                       
                                    } 
                                    
                                    $sql10 = "select nombatiment, numsalle from salle where idsalle = '".$salle."'";
                                    $res10 = mysqli_query($link, $sql10) or die("Erreur selection salle");
                                    while ($salles= mysqli_fetch_assoc($res10)) {
                                        $nombatiment = $salles['nombatiment'];
                                        $numsalle = $salles['numsalle'];
                                        echo "<div class=\"salle\">(";
                                        if ($nombatiment == "Amphi"){
                                            echo $nombatiment." ".$numsalle;
                                        } else {
                                            echo "Salle ".$nombatiment."".$numsalle;
                                        }
                                        echo ")</div>";             
                                    } 
                                }
                                echo "</td>";
                            }
                        }
                        echo "</tr>";
                    }
                    echo "</table>";
                }
                
            }
        }
    ?>
    
</body>
</html>