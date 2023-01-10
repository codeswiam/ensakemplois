<?PHP
    session_start();
    include ("connexion.php");
    if (!isset($_SESSION['admin'])){
        header("Location: acceuil.php");
    } else {
        $admin = $_SESSION['admin'];
    }
    if (isset($_GET["sem"]) && $_GET["sem"] != "S0") {
        $getsem = $_GET["sem"];
    }  
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ajout Module</title>
    <link rel="stylesheet" href="style.css">
    <script type="text/javascript">
        function autoSubmitSem() {
            with (window.document.form) {
                if (sem.selectedIndex != "S0") {
                    window.location.href = 'ajoutermodule.php?sem=' + sem.options[sem.selectedIndex].value;
                }
            }
        }
    </script>
    <link rel="stylesheet" href="style.css">
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
    <h1>Ajouter Module 2</h1>
    <form action="#" method="post" name="form">

        <div>
            <label for="sem">Semestre</label>
            <select name="sem" onchange="autoSubmitSem();">
            <?php
                $sql = "SELECT * from semestre";
                $result = mysqli_query($link,$sql);
                while ($data=mysqli_fetch_assoc($result))
                {
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

        <?php
            if (isset($getsem) && $getsem != "S0" && $getsem != "S1" && $getsem != "S2" && $getsem != "S3" && $getsem != "S4") {
                ?>
                <div>
                    <label>Filière</label>
                    <?php
                        $sql="select idsem_fi, nomfiliere from filiere,sem_fi where sem_fi.idfiliere = filiere.idfiliere and idsem='".$getsem."'";
                        $result=mysqli_query($link,$sql);
                        while ($liste=mysqli_fetch_assoc($result))
                        {
                            echo '<input type="checkbox" name="fil[]" value='.$liste["idsem_fi"].'>';
                            echo $liste["nomfiliere"];
                            echo'</option>';
                        }
                    ?>
                </div>
                <?php
            }
        ?>
        <div>
            <label for="nommod">Module</label>
            <input type="text" name="nommod" required>
        </div>

        <div>
            <label for="prof[]">Professeurs </label>
            <?php
                $sql1="select * from prof order by nom";
                $result1=mysqli_query($link,$sql1);
                while ($liste1=mysqli_fetch_assoc($result1))
                {
                    echo '<input type="checkbox" name="prof[]" value='.$liste1["idprof"].'>';
                    echo $liste1["nom"]." ".$liste1["prenom"];
                    echo'</option>';
                }
            ?>
        </div>

        <input type="submit" value="Ajouter" name="ajoutmod">

    </form>
    <?php
        if(isset($_POST['ajoutmod'])){
            $nommod=$_POST["nommod"];
            $idsem=$_POST["sem"];
            $choix=$_POST["prof"];
            $choix2=$_POST["fil"];
            $sql1="INSERT into module values (NULL,'".$nommod."','".$idsem."')";
            $result1 = mysqli_query($link,$sql1) or die("erreur insertion module");
            $sql2 = "SELECT idmod from module where nommodule='".$nommod."' and idsem='".$idsem."'";
            $res2=mysqli_query($link,$sql2) or die("erreur module");
            while ($data=mysqli_fetch_assoc($res2))
            {
                $idmod = $data['idmod'];
                foreach($choix as $idprof){
                    $sql="INSERT into profmod values (NULL,'".$idmod."','".$idprof."')";
                    $result = mysqli_query($link,$sql) or die("Erreur prof");
                }
                foreach($choix2 as $idsemfi){
                    $sql="INSERT into modulefiliere values ('".$idmod."', '".$idsemfi."')";
                    $result = mysqli_query($link,$sql) or die("Erreur filiere");
                }
                if ($result == true){
                    header("Location: module.php");
                }
            }   
        }
    ?>
    <a href="module.php">Retour</a>
</body>

