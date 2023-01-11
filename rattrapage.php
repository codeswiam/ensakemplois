<?php
    session_start();
    include ("connexion.php");
    if (!isset($_SESSION['prof'])){
        header("Location: acceuil.php");
    } else {
        $prof = $_SESSION['prof'];
    }
    if (isset($_POST['ratt'])){
        if ($_POST['semfi'] == "0"){
            echo "Veuillez selectionner un semestre et une filière";
            echo "<span class='retouracceuil'><a href='acceuil.php' class='link'>Retour</a></span>";
            exit();
        }
        else{
            $temps = 365*24*3600;
            setcookie("semfi", $_POST['semfi'], time() + $temps);
            $_COOKIE['semfi'] = $_POST['semfi'];
        }
    }
    if (isset($_GET["jour"])) {
        $j = $_GET["jour"];
    }
    if (isset($_GET["heure"])) {
        $h = $_GET["heure"];
    }
    if (isset($_GET["mod"]) && $_GET["mod"] != 0) {
        $module = $_GET["mod"];
    }
    if (isset($_GET["type"]) && $_GET["type"] != "TYP") {
        $typ = $_GET["type"];
    }
    if (isset($_GET["grp"]) && $_GET["grp"] != "0") {
        $gr = $_GET["grp"];
    }
?>
<!DOCTYPE html>
<html lang="en">
    
<head>
    <meta charset="UTF-8">
    <title>Ajout rattrapage</title>
    <script type="text/javascript">
        function autoSubmitJour() {
            with (window.document.form) {
                if (jour.selectedIndex != 0) {
                    window.location.href = 'rattrapage.php?jour=' + jour.options[jour.selectedIndex].value;
                }
            }
        }
        function autoSubmitHeure() {
            with (window.document.form) {
                if (heure.selectedIndex != 0) {
                    window.location.href = 'rattrapage.php?jour=' + jour.options[jour.selectedIndex].value + '&heure=' + heure.options[heure.selectedIndex].value;
                }
            }
        }
        function autoSubmitMod() {
            with (window.document.form) {
                if (mod.selectedIndex != 0) {
                    window.location.href = 'rattrapage.php?jour=' + jour.options[jour.selectedIndex].value + '&heure=' + heure.options[heure.selectedIndex].value +'&mod=' + mod.options[mod.selectedIndex].value;
                }
            }
        }
        function autoSubmitTyp() {
            with (window.document.form) {
                if (type.selectedIndex != "TYP") {
                    window.location.href = 'rattrapage.php?jour=' + jour.options[jour.selectedIndex].value + '&heure=' + heure.options[heure.selectedIndex].value +'&mod=' + mod.options[mod.selectedIndex].value + '&type=' + type.options[type.selectedIndex].value;
                }
            }
        }
        function autoSubmitGrp() {
            with (window.document.form) {
                if (grp.selectedIndex != 0) {
                    window.location.href = 'rattrapage.php?jour=' + jour.options[jour.selectedIndex].value + '&heure=' + heure.options[heure.selectedIndex].value +'&mod=' + mod.options[mod.selectedIndex].value + '&type=' + type.options[type.selectedIndex].value + '&grp=' + grp.options[grp.selectedIndex].value;
                }
            }
        }
    </script>
    <link rel="stylesheet" href="stylee.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="stylee.css">

</head>
<body>

    <nav class="menu"> 
        <ul>
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
    
    
    <!-- affichage emploi -->
    <?php
        if (isset($_COOKIE['semfi'])){
            $fil = $_COOKIE['semfi'];
            ?>
                <h1> Programmer un rattrapage </h1>
                <form action="#" method="post" name="form" class="myform">

                    <div>
                        <label for="jour">Jour:</label>
                        <select name="jour" id="" onchange="autoSubmitJour();">
                            <option value="0"> Sélectionner </option>
                            <?php
                                $sql = "SELECT * from jour";
                                $result = mysqli_query($link, $sql) or die(mysqli_error($link));
                                while ($data= mysqli_fetch_assoc($result)) {
                                    echo ("<option value=\"{$data['idjour']}\" ");
                                    if (isset($j)){
                                        if ($j == $data['idjour'])
                                            echo "selected";
                                    }
                                    echo ">";
                                    echo $data["nomjour"];
                                    echo'</option>';
                                }
                            ?>
                        </select>
                    </div>

                    <div>
                        <label for="heure">Horaire:</label>
                        <select name="heure" id="" required onchange="autoSubmitHeure();">
                            <option value="0"> Sélectionner </option>
                            <?php
                                if (isset($j)){
                                    $sql = "SELECT * from creneau 
                                    where idcreneau not in 
                                    (select creneau.idcreneau from creneau, seancefiliere, seance 
                                    where seancefiliere.idseance= seance.idseance 
                                    and seance.idcreneau = creneau.idcreneau and idjour='".$j."')"; // you don't need creneau ??? seance has idcreneau
                                    $result = mysqli_query($link, $sql) or die(mysqli_error($link));
                                    while ($data= mysqli_fetch_assoc($result)) {
                                        echo ("<option value=\"{$data['idcreneau']}\" ");
                                        if (isset($h)){
                                            if ($h == $data['idcreneau'])
                                                echo "selected";
                                        }
                                        echo ">";
                                        echo $data["starttime"].' - '.$data["endtime"];
                                        echo'</option>';
                                    }
                                }  
                            ?>
                        </select>
                    </div>

                    <div>
                        <label for="mod">Module:</label>
                        <select name="mod" id="" required onchange="autoSubmitMod();">
                            <option value="0"> Sélectionner </option>
                            <?php
                                    $sql = "SELECT nommodule, idprofmod from module, modulefiliere, profmod 
                                    where module.idmod = modulefiliere.idmod 
                                    and module.idmod = profmod.idmod
                                    and idprof='".$prof."' 
                                    and idsem_fi= '".$fil."'";
                                    $result = mysqli_query($link, $sql) or die(mysqli_error($link));
                                    while ($data= mysqli_fetch_assoc($result)) {
                                        echo ("<option value=\"{$data['idprofmod']}\" ");
                                        if (isset($module)){
                                            if ($module == $data['idprofmod'])
                                                echo "selected";
                                        }
                                        echo ">";
                                        echo $data["nommodule"];
                                        echo'</option>';
                                    }
                            ?>
                        </select>
                    </div>

                    <div>
                        <label for="type">Type de Séance:</label>
                        <select name="type" id="" required onchange="autoSubmitTyp();">
                            <option value="TYP"> Sélectionner </option>
                            <?php
                                $sql = "SELECT * from typeseance";
                                $result = mysqli_query($link, $sql) or die(mysqli_error($link));
                                while ($data= mysqli_fetch_assoc($result)) {
                                    echo ("<option value=\"{$data['type']}\" ");
                                    if (isset($typ)){
                                        if ($typ == $data['type'])
                                            echo "selected";
                                    }
                                    echo ">";
                                    echo $data["type"];
                                    echo'</option>';
                                }
                            ?>
                        </select>
                    </div>

                    <?php
                        if (isset($typ) && $typ != "TYP" && $typ != "Cours"){
                            ?>
                            <div>
                                <label for="grp">Groupe:</label>
                                <select name="grp" id="" required onchange="autoSubmitGrp();">
                                    <option value="0"> Sélectionner </option>
                                    <?php
                                        if ($typ == "TD")
                                            $sql = "SELECT groupetd as groupe, nomgrp from groupetd where idsem_fi = '".$fil."'";
                                        if ($typ == "TP")
                                            $sql = "SELECT groupetp as groupe, nomgrp from groupetp where idsem_fi = '".$fil."'";
                                        $result = mysqli_query($link, $sql) or die(mysqli_error($link));
                                        while ($data= mysqli_fetch_assoc($result)) {
                                            echo ("<option value=\"{$data['groupe']}\" ");
                                            if (isset($gr)){
                                                if ($gr == $data['groupe'])
                                                    echo "selected";
                                            }
                                            echo ">";
                                            echo $data["nomgrp"];
                                            echo'</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                            <?php
                        }
                    ?>

                    
                    <div>
                        
                        <label for="salle">Local:</label>
                        <select name="salle" id="" required>
                            <option value="0"> Sélectionner </option>
                            <?php
                                if (isset($j) && isset($h)){
                                    $sql = "SELECT * from salle where idsalle not in (select idsalle from seance where idjour='".$j."' and idcreneau='".$h."')";
                                    $result = mysqli_query($link, $sql) or die(mysqli_error($link));
                                    while ($data= mysqli_fetch_assoc($result)) {
                                        echo ("<option value=\"{$data['idsalle']}\">");
                                        echo $data["nombatiment"]." ".$data["numsalle"];
                                        echo'</option>';
                                    }
                                }
                            ?>
                        </select>

                    </div>

                    <input type="submit" name="ajoutratt" value="Programmer Rattrapage">

                </form>
            <?php
            $sql1 = "SELECT nomsem from semestre, sem_fi where semestre.idsem=sem_fi.idsem and idsem_fi='".$fil."'";
            $res1 = mysqli_query($link, $sql1) or die("Erreur selection semestres");
            while ($semestre= mysqli_fetch_assoc($res1)) {
                $nomsem = $semestre['nomsem'];
                
                // on selectionne la filiere
                $sql2 = "SELECT nomfiliere from filiere,sem_fi where sem_fi.idfiliere = filiere.idfiliere and idsem_fi='".$fil."'";
                $res2 =  mysqli_query($link, $sql2) or die("Erreur selection filieres");
                while ($filiere= mysqli_fetch_assoc($res2)) {
                    $nomfiliere = $filiere['nomfiliere'];

                    // creation d'une view qui contient toutes les seances de cette filiere
                    $sql = "CREATE or replace view seancefiliere as select idseance from seance 
                    where idseance in (select idseance from seancecours where idsem_fi = '".$fil."') 
                    or idseance in (select idseance from seancetd where groupetd in (select groupetd from groupetd where idsem_fi = '".$fil."'))
                    or idseance in (select idseance from seancetp where groupetp in (select groupetp from groupetp where idsem_fi = '".$fil."'))";
                    $res = mysqli_query($link, $sql) or die("Erreur creation view");
                    $sql = "select * from seancefiliere";
                    $res = mysqli_query($link, $sql) or die("Erreur selection seance de filiere");
                    $nbrseance = mysqli_num_rows($res);
                    /*if (mysqli_num_rows($res) == 0) {
                        echo "Aucun emploi disponible pour ".$nomfiliere." de ".$nomsem."."; // cas ou on n'a aucune seance enregistrée pour cette filière
                    } else { */
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
                                if ($nbr== 0 or $nbrseance == 0){
                                        echo "<td></td>"; // cas de seance vide
                                } else {
                                    echo "<td>";
                                    // affichage seance
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
    <a href="acceuil.php" id="retour">Retour</a>
    
    <?php
        if(isset($_POST['ajoutratt']))
        {

            $profmod= $_POST['mod'];

            // recuperation des données du type de la seance et des grps tds/tps
            $type = $_POST['type'];
            if ($type == "TD" or $type == "TP"){
                $grp = $_POST['grp'];
            }

            // recuperation de la date et heure
            $jour = $_POST['jour'];
            $creneau = $_POST['heure'];

            // recuperation des donnees de la salle
            $salle = $_POST['salle'];


            // traitement des données de la séance
            if (isset($profmod) && isset($salle)){
                $sql2 = "insert into seance values (NULL, '".$salle."', '".$jour."', '".$creneau."', '".$profmod."', '".$type."')";
                $res = mysqli_query($link, $sql2) or die("Erreur insertion seance");
                $sql = "select idseance from seance where idjour='".$jour."' and idsalle='".$salle."' and idcreneau='".$creneau."'";
                $result = mysqli_query($link, $sql) or die("Erreur trouver seance apres insertion");
                while ($data= mysqli_fetch_assoc($result)) {
                    $seance= $data['idseance'];
                }

                // selon le type de la seance, on enregistre l'idseance et le groupe cours/td/tp
                if ($type == "Cours" && isset($fil))
                {
                    $sql = "insert into seancecours values ('".$seance."', '".$fil."')";
                }
                if (isset($grp)){
                    if ($type == "TD"){
                        $sql = "insert into seancetd values ('".$seance."', '".$grp."')";
                    }
                    if ($type == "TP"){
                        $sql = "insert into seancetp values ('".$seance."', '".$grp."')";
                    }
                }
                $result = mysqli_query($link, $sql) or die("Erreur seance cours/td/tp");
                if ($result == true){
                    ?>
                    <script type="text/javascript">
                        window.location.href = 'rattrapage.php';
                    </script>
                    <?php
                }
            }
        }
    ?>


</body>
</html>