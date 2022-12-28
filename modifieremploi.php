<?php
    //session_start();
    include ("connexion.php");
    if (!isset($_SESSION['admin'])){
        header("Location: acceuil.php");
    }
    if (isset($_POST['emploi'])){
        if ($_POST['semestre'] == "S0" or $_POST['filiere'] == "FIL"){
            echo "Veuillez selectionner un semestre et une filière";
            echo "<span class='retouracceuil'><a href='acceuil.php' class='link'>Retour</a></span>";
        }
        else{
            $temps = 365*24*3600;
            setcookie("semestre", $_POST['semestre'], time() + $temps);
            setcookie("filiere", $_POST['filiere'], time() + $temps);
        }
    }
    if (isset($_GET["mod"]) && $_GET["mod"] != 0) {
        $module = $_GET["mod"];
    }

    if (isset($_GET["prof"]) && $_GET["prof"] != 0) {
        $professeur = $_GET["prof"];
    }

    if (isset($_GET["type"]) && $_GET["type"] != "TYP") {
        $typ = $_GET["type"];
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Modification Emploi</title>
    <script type="text/javascript">
        function autoSubmitMod() {
            with (window.document.form) {
                if (mod.selectedIndex != 0) {
                    window.location.href = 'modifieremploi.php?mod=' + mod.options[mod.selectedIndex].value;
                }
            }
        }
        function autoSubmitProf() {
            with (window.document.form) {
                if (prof.selectedIndex != "0") {
                    window.location.href = 'modifieremploi.php?mod=' + mod.options[mod.selectedIndex].value + '&prof=' + prof.options[prof.selectedIndex].value;
                }
            }
        }
        function autoSubmitTyp() {
            with (window.document.form) {
                if (type.selectedIndex != "TYP") {
                    window.location.href = 'modifieremploi.php?mod=' + mod.options[mod.selectedIndex].value + '&prof=' + prof.options[prof.selectedIndex].value + '&type=' + type.options[type.selectedIndex].value;
                }
            }
        }
    </script>
</head>
<body>
    <h1> emploi 11 </h1>
    <!-- affichage emploi -->
    <?php
        if (isset($_COOKIE['semestre']) && isset($_COOKIE['filiere'])){
            $sem = $_COOKIE['semestre'];
            $fil= $_COOKIE['filiere'];
            /*if ($sem == "S0" or $fil == "FIL"){
                echo "Veuillez selectionner un semestre et une filière";
                echo "<span class='retouracceuil'><a href='acceuil.php' class='link'>Retour</a></span>";
            } else {*/
                $sql1 = "SELECT nomsem from semestre where idsem='".$sem."'";
                $res1 = mysqli_query($link, $sql1) or die("Erreur selection semestres");
                while ($semestre= mysqli_fetch_assoc($res1)) {
                    $nomsem = $semestre['nomsem'];
                    echo "<h2>".$semestre['nomsem']."</h2>";
                    
                    // on selectionne la filiere
                    $sql2 = "SELECT nomfiliere from filiere,sem_fi where sem_fi.idfiliere = filiere.idfiliere and idsem_fi='".$fil."'";
                    $res2 =  mysqli_query($link, $sql2) or die("Erreur selection filieres");
                    while ($filiere= mysqli_fetch_assoc($res2)) {
                        $nomfiliere = $filiere['nomfiliere'];
                        echo "<h3>".$nomfiliere."</h3>";

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
                                    if (mysqli_num_rows($res5) == 0 or $nbrseance == 0){
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
                                        }
                                        echo "</td>";
                                    }
                                }
                                echo "</tr>";
                            }
                            echo "</table>";
                            echo "</div>"; 
                        //}
                    }
                }
            //}
        }
        
    ?>
    <form action="#" method="post" name="form">

        <div>
            <label for="mod">Module:</label>
            <select name="mod" id="" required onchange="autoSubmitMod();">
                <option value="0"> Sélectionner </option>
                <?php
                        $sql = "SELECT nommodule, module.idmod from module, modulefiliere, sem_fi 
                        where module.idmod = modulefiliere.idmod 
                        and sem_fi.idsem_fi = modulefiliere.idsem_fi 
                        and sem_fi.idsem_fi= '".$fil."'"; // why do you need sem_fi??
                        $result = mysqli_query($link, $sql) or die(mysqli_error($link));
                        while ($data= mysqli_fetch_assoc($result)) {
                            echo ("<option value=\"{$data['idmod']}\" ");
                            if (isset($module)){
                                if ($module == $data['idmod'])
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
            <label for="prof">Professeur:</label>
            <select name="prof" id="" required onchange="autoSubmitProf();">
                <option value="0"> Sélectionner: </option>
                <?php
                    if (isset($module) && $module != 0) {
                        $sql = "SELECT nom, idprofmod from profmod, prof where profmod.idprof = prof.idprof and idmod='".$module."'";
                        $result = mysqli_query($link, $sql) or die(mysqli_error($link));
                        while ($data= mysqli_fetch_assoc($result)) {
                            echo ("<option value=\"{$data['idprofmod']}\" ");
                            if (isset($professeur)){
                                if ($professeur == $data['idprofmod'])
                                    echo "selected";
                            }
                            echo ">";
                            echo $data["nom"];
                            echo'</option>';
                        }
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
                    <select name="grp" id="" required>
                        <option value="0"> Sélectionner </option>
                        <?php
                            if ($typ == "TD")
                                $sql = "SELECT groupetd as groupe, nomgrp from groupetd where idsem_fi = '".$fil."'";
                            if ($typ == "TP")
                                $sql = "SELECT groupetp as groupe, nomgrp from groupetp where idsem_fi = '".$fil."'";
                            $result = mysqli_query($link, $sql) or die(mysqli_error($link));
                            while ($data= mysqli_fetch_assoc($result)) {
                                echo ("<option value=\"{$data['groupe']}\">");
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
            <label for="jour">Jour:</label>
            <select name="jour" id="" required>
                <?php
                    $sql = "SELECT * from jour";
                    $result = mysqli_query($link, $sql) or die(mysqli_error($link));
                    while ($data= mysqli_fetch_assoc($result)) {
                        echo ("<option value=\"{$data['idjour']}\">");
                        echo $data["nomjour"];
                        echo'</option>';
                    }
                ?>
            </select>
        </div>

        <div>
            <label for="creneau">Horaire:</label>
            <select name="creneau" id="" required>
                <?php
                    $sql = "SELECT * from creneau";
                    $result = mysqli_query($link, $sql) or die(mysqli_error($link));
                    while ($data= mysqli_fetch_assoc($result)) {
                        echo ("<option value=\"{$data['idcreneau']}\">");
                        echo $data["starttime"].' - '.$data["endtime"];
                        echo'</option>';
                    }
                ?>
            </select>
        </div>
        <div>
            <label for="">Local:</label>
            
            <label for="batiment">Batiment:</label>
            <select name="batiment" id="" required>
                <option value="BAT"> Sélectionner </option>
                <?php
                    $sql = "SELECT * from batiment";
                    $result = mysqli_query($link, $sql) or die(mysqli_error($link));
                    while ($data= mysqli_fetch_assoc($result)) {
                        echo ("<option value=\"{$data['nombatiment']}\">");
                        echo $data["nombatiment"];
                        echo'</option>';
                    }
                ?>
            </select>

            <label for="numero">Salle/Amphi Num:</label>
            <input type="number" name="numero" id="" value="0">

        </div>

        <input type="submit" name="ajouter" value="Ajouter/Modifier Séance">

    </form>
    <?php
        if(isset($_POST['ajouter']))
        {
            // recuperation des données du semestre et filiere
            /*$sem = $_POST['sem'];
            $fil = $_POST['fil'];
            $sql = "select idsem_fi from sem_fi where idsem = '".$sem."' and idfiliere = '".$fil."'";
            $result = mysqli_query($link, $sql) or die("Erreur semfi");
            while ($data= mysqli_fetch_assoc($result)) {
                $semfi = $data['idsem_fi'];
            }*/

            // recuperation des données du professeur et module
            /*$mod = $_POST['mod'];
            $prof = $_POST['prof'];
            $sql = "select idprofmod from profmod where idprof = '".$prof."' and idmod = '".$mod."'";
            $result = mysqli_query($link, $sql) or die("Erreur profmod");
            while ($data= mysqli_fetch_assoc($result)) {
                $profmod= $data['idprofmod'];
            }*/

            $profmod= $_POST['prof'];

            // recuperation des données du type de la seance et des grps tds/tps
            $type = $_POST['type'];
            if ($type == "TD" or $type == "TP"){
                $grp = $_POST['grp'];
            }

            $jour = $_POST['jour'];
            $creneau = $_POST['creneau'];

            // recuperation des donnees de la salle
            $bat = $_POST['batiment'];
            $num = $_POST['numero'];
            // on voit premierement si la salle selectionnée par l'admin existe ou non dans la base de données
            $sql = "select idsalle from salle where nombatiment='".$bat."' and numsalle='".$num."'";
            $result = mysqli_query($link, $sql) or die("Erreur trouver salle");
            // si la salle n'existe pas dans la bd, on la crée
            if (mysqli_num_rows($result) == 0){
                $sql2 = "insert into salle values (NULL, '".$bat."', '".$num."', NULL)";
                $res = mysqli_query($link, $sql2) or die("Erreur insertion salle");
                $result = mysqli_query($link, $sql) or die("Erreur trouver salle apres insertion");
            }
            while ($data = mysqli_fetch_assoc($result)) {
                $salle = $data['idsalle'];
            }

            // traitement des données de la séance
            if (isset($profmod) && isset($salle)){
                // on voit premierement si la seance existe déjà (cas ou plusieurs filieres ont même seance)
                $sql = "select idseance from seance where idjour='".$jour."' and idsalle='".$salle."' and idcreneau='".$creneau."'";
                // peut etre qu'on a fait une erreur, si (we need to check)c'est le meme prof, c la meme seance, sinon
                // on doit afficher que la salle est remplise a ce moment
                $result = mysqli_query($link, $sql) or die("Erreur trouver seance");
                // si la seance n'existe pas dans la bd, on la crée
                if (mysqli_num_rows($result) == 0){
                    $sql2 = "insert into seance values (NULL, '".$salle."', '".$jour."', '".$creneau."', '".$profmod."', '".$type."')";
                    $res = mysqli_query($link, $sql2) or die("Erreur insertion seance");
                    $result = mysqli_query($link, $sql) or die("Erreur trouver seance apres insertion");
                }
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
                        window.location.href = 'modifieremploi.php';
                    </script>
                    <?php
                }
            }
        }
    ?>


</body>
</html>


