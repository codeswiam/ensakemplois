<?PHP
    session_start();
    include ("connexion.php");
    if (!isset($_SESSION['admin'])){
        header("Location: acceuil.php");
    } else {
        $admin = $_SESSION['admin'];
    }
    if (isset($_GET["semestre"]) && $_GET["semestre"] != "S0") {
        $getsem = $_GET["semestre"];
    } 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ajout Groupe</title>
    <script type="text/javascript">
        function autoSubmitSem() {
            with (window.document.form) {
                if (semestre.selectedIndex != "S0") {
                    window.location.href = 'ajoutertd.php?semestre=' + semestre.options[semestre.selectedIndex].value;
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
                    <li><a href="seconnecter.php">Se connecter</a></li>
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
    <h1>Ajout d'un groupe TD</h1>
    <form method="POST" action="#" name="form"> 
        
        <label >Semestre</label></br>
        <select name="semestre" onchange="autoSubmitSem();">
            <option value="S0"> Sélectionner </option>
            <?php
                $sql1="select * from semestre";
                $result1=mysqli_query($link,$sql1);
                while ($liste1=mysqli_fetch_assoc($result1))
                {
                    echo ("<option value=\"{$liste1["idsem"]}\" ");
                    if (isset($getsem)){
                        if ($getsem == $liste1['idsem'])
                            echo "selected";
                    }
                    echo ">";
                    echo $liste1["nomsem"];
                    echo'</option>';
                }
            ?>
        </select><br>

        <label >Nom de la Filière</label></br>
        <select name="filiere" >
            <option value="0"> Sélectionner </option>
            <?php
                if (isset($getsem) && $getsem != "S0") {
                    $sql="select idsem_fi, nomfiliere from filiere,sem_fi where sem_fi.idfiliere = filiere.idfiliere and idsem='".$getsem."'";
                    $result=mysqli_query($link,$sql);
                    while ($liste=mysqli_fetch_assoc($result))
                    {
                        echo ("<option value=\"{$liste['idsem_fi']}\" ");
                        echo ">";
                        echo $liste["nomfiliere"];
                        echo'</option>';
                    }
                }
            ?>
        </select><br>

        <label >Nom du grp </label></br>
        <input type="text" name="nom" required></br>

        <input type="submit" name="ajoutertd" value="Ajouter Groupe">

    </form>
    <a href="filiere.php">Retour</a>
    <?php
        if (isset($_POST['ajoutertd'])){
            $sem=$_POST['semestre'];
            $nom=$_POST['nom'];
            $semfi=$_POST['filiere'];
            if ($sem == "S0" or $semfi == 0){
                echo "Veuillez selectionner un semestre et une filière";
            } else {
                $sql2="insert into groupetd values(NULL,'".$semfi."','".$nom."')";
                $result2 = mysqli_query($link,$sql2) or die("Echec groupetd");
                if($result2==true){
                    header("Location: filiere.php");
                }
            }   
        }    
    ?>

</body>
</html>