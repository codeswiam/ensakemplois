<?php 
    include ("connexion.php");
    session_start();
    if (isset($_GET["semestre"]) && $_GET["semestre"] != "S0") {
        $getsem = $_GET["semestre"];
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Emplois</title>
    <script type="text/javascript">
        function autoSubmitSem() {
            with (window.document.form) {
                if (semestre.selectedIndex != "S0") {
                    window.location.href = 'acceuil.php?semestre=' + semestre.options[semestre.selectedIndex].value;
                }
            }
        }
    </script>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <nav class="menu"> 
        <ul>
            <li>logo ensa</li>
            <img src="images/logo.png" size="20px" />
            <li><a href="acceuil.php">Acceuil</a></li>
            <?php
                if (isset($_SESSION['admin']))
                {
            ?>
                    <li><a href="filiere.php">Filières</a></li>
                    <li><a href="module.php">Modules</a></li>
                    <li><a href="professeur.php">Professeurs</a></li>
                    <li><a href="locaux.php">Locaux</a></li>
            <?php
                }
                if (!isset($_SESSION['admin']) && !isset($_SESSION['prof']))
                {
            ?>
                    <li><a href="welcome.php">Se connecter</a></li>
            <?php 
                } else {
                    echo "<li><a href=";
                    if (isset($_SESSION['prof']))
                        echo "profilprof.php";
                    if (isset($_SESSION['admin']))
                        echo "profiladmin.php";
                    echo ">Profil</a></li>";
                }
            ?>
        </ul>
    </nav>

    <h1> Organisation des enseignements </h1>

    <?php
        if (isset($_SESSION['admin']))
        {
    ?>
            <div id="modifieremploi"> <h2> Modifier Emploi </h2>
                <form action="modifieremploi.php" method="post" name="form">
                    <div>
                        <label for="semestre">Semestre:</label>
                        <select name="semestre" id="" onchange="autoSubmitSem();">
                            <option value="S0"> Sélectionner </option>
                            <?php
                                $sql = "select * from semestre";
                                $result = mysqli_query($link, $sql) or die(mysqli_error($link));
                                while ($data = mysqli_fetch_assoc($result)) {
                                    echo ("<option value=\"{$data["idsem"]}\" ");
                                    if (isset($getsem)){
                                        if ($getsem == $data['idsem'])
                                            echo "selected";
                                    }
                                    echo ">";
                                    echo $data["nomsem"];
                                    echo'</option>';
                                }
                            ?>
                        </select>
                    </div>

                    <div>
                        <label for="filiere">Filiere:</label>
                        <select name="filiere" id="">
                            <option value="0"> Sélectionner </option>
                            <?php
                                if (isset($getsem) && $getsem != "S0") {
                                    $sql = "select idsem_fi, nomfiliere from filiere,sem_fi where sem_fi.idfiliere = filiere.idfiliere and idsem='".$getsem."'";
                                    $result = mysqli_query($link, $sql) or die(mysqli_error($link));
                                    while ($data= mysqli_fetch_assoc($result)) {
                                        echo ("<option value=\"{$data['idsem_fi']}\" ");
                                        echo ">";
                                        echo $data["nomfiliere"];
                                        echo'</option>';
                                    }
                                }
                            ?>
                        </select>
                    </div>

                    <input type="submit" name="emploi" value="Créer/Modifier Emploi">
                </form>
            </div>
    <?php
        }
    ?>

    <?php
        if (isset($_SESSION['prof']))
        {
    ?>
            <div id="ajoutratt"> <h2> Programmer un rattrapage </h2>
                <form action="rattrapage.php" method="post" name="form">
                    <div>
                        <label for="semfi">Filière:</label>
                        <select name="semfi" id="">
                            <option value="0"> Sélectionner </option>
                            <?php
                                $prof = $_SESSION['prof'];
                                $sql = "SELECT idsem_fi from profmod, modulefiliere where modulefiliere.idmod = profmod.idmod and idprof='".$prof."'";
                                $res = mysqli_query($link, $sql) or die(mysqli_error($link));
                                while ($data = mysqli_fetch_assoc($res)) {
                                    $semfi = $data['idsem_fi'];
                                    $sql2 = "SELECT nomsem, nomfiliere from semestre, filiere, sem_fi 
                                    where sem_fi.idsem=semestre.idsem and sem_fi.idfiliere=filiere.idfiliere 
                                    and idsem_fi='".$semfi."'";
                                    $res2 = mysqli_query($link, $sql2) or die(mysqli_error($link));
                                    while ($data2 = mysqli_fetch_assoc($res2))
                                    {
                                        echo ("<option value=\"{$semfi}\">");
                                        echo $data2['nomsem']." - ".$data2['nomfiliere'];
                                        echo'</option>';
                                    }   
                                }
                            ?>
                        </select>
                    </div>

                    <input type="submit" name="ratt" value="Programmer rattrapage">
                </form>
            </div>
    <?php
        }
    ?>
    
    <?php
        $sql1 = "select * from semestre";
        $res1 = mysqli_query($link, $sql1) or die("Erreur selection semestres");
        while ($semestre= mysqli_fetch_assoc($res1)) {
            $sem = $semestre['idsem'];
            $nomsem = $semestre['nomsem'];
            
            
            // on selectionne la filiere
            $sql2 = "select idsem_fi, nomfiliere from filiere,sem_fi where sem_fi.idfiliere = filiere.idfiliere and idsem='".$sem."'";
            $res2 =  mysqli_query($link, $sql2) or die("Erreur selection filieres");
            $sql11 = "SELECT idseance from seance, profmod, module 
            where seance.idprofmod = profmod.idprofmod and module.idmod = profmod.idmod and module.idsem='".$sem."'";
            $res11 =  mysqli_query($link, $sql11) or die("Erreur selection seances du semestre");
            if (mysqli_num_rows($res11) != 0){
                echo "<h2 class=\"sem\">".$semestre['nomsem']."</h2>";
            } 
            while ($filiere= mysqli_fetch_assoc($res2)) {
                $fil = $filiere['idsem_fi'];
                $nomfiliere = $filiere['nomfiliere'];
                
                // creation d'une view qui contient toutes les seances de cette filiere
                $sql = "CREATE OR REPLACE view seancefiliere as select idseance from seance 
                where idseance in (select idseance from seancecours where idsem_fi = '".$fil."')
                or idseance in (select idseance from seancetd where groupetd in (select groupetd from groupetd where idsem_fi = '".$fil."'))
                or idseance in (select idseance from seancetp where groupetp in (select groupetp from groupetp where idsem_fi = '".$fil."'))";
                $res = mysqli_query($link, $sql) or die("Erreur creation view");
                $sql = "select * from seancefiliere";
                $res = mysqli_query($link, $sql) or die("Erreur selection seance de filiere");
                if (mysqli_num_rows($res) != 0) { 
                    echo "<div class=\"emploi\">";
                    echo "<div class=\"titre\">Organisation des enseignements<br>".$nomfiliere." <span class=\"semestre\">(".$nomsem.")</span></div>";
                    echo "<table border=\"2\">";
                    echo "<th class=\"jh\"> Jour / Horaire </th>";

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
                        echo "<td class=\"jour\">".$jours['nomjour']."</td>";
                        $res4 = mysqli_query($link, $sql4) or die("Erreur selection creneau");
                        while ($horaire= mysqli_fetch_assoc($res4)){
                            $creneau = $horaire['idcreneau'];
                            // on selectionne la seance
                            $sql5 = "select seance.idseance, idsalle, idprofmod, type from seance, seancefiliere where seance.idseance = seancefiliere.idseance and idjour='".$jour."' and idcreneau='".$creneau."'";
                            $res5 = mysqli_query($link, $sql5) or die("Erreur selection seance");
                            $nbr = mysqli_num_rows($res5); // pour le cas ou il y'a deux seances tps/tds en meme temps
                            if ($nbr== 0){
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
                                    if ($nbr > 1){
                                        echo "<div> / </div>";
                                    }
                                }
                                echo "</td>";
                            }
                        }
                        echo "</tr>";
                    }
                    echo "</table>";
                    echo "</div>";
                }
                
            }
        }
    ?>
    
</body>
</html>