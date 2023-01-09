<html>
<head>
    <title>ajout prof</title>
</head>
<style>
    .pseudo{
        color:red;
        font-weight: bold;
        text-decoration: underline;
    }
    input{
        width: 501px;
    }
</style>
<link rel="stylesheet" href="style.css">
<body>


<form action=# method="post" enctype="multipart/form-data">


    <h4> NOM:</h4><input type="texte" name="txt_nom"  ></br>
    <h4> PRENOM:</h4><input type="texte" name="txt_prenom"  ></br>
    <h4>email:</h4> <input type="email" name="txt_email" ></br>
    <h4>mot de passe:</h4> <input type="password" name="txt_pass" ></br>



    <h4> image:</h4><input type="file" name="fichier" size="30"><br/>
    </br>


    <input type="submit" name="envoyer" value="ajouter"></br>
</form>



</body>
</html>
<?php
if(isset($_POST['envoyer'])){
    include ("connexion.php");
    /*$sql="select * from user";
    $result=mysqli_query($link,$sql);
    $row = mysqli_fetch_assoc($result);*/
    $email=$_POST["txt_email"];
    $pass=$_POST["txt_pass"];
    $nom=$_POST["txt_nom"];
    $prenom=$_POST["txt_prenom"];
    $image=$_POST["fichier"];


    echo"<br>";

    print "<a href='professeur.php'>Retour page professeur</a>";
    if(isset($_FILES['fichier']) and $_FILES['fichier']['error']==0){
        echo'done';
        $dossier = 'images/'; // dossier où sera déplacé le fichier
        $nom_temporaire = $_FILES['fichier']['tmp_name'];
        if( !is_uploaded_file($nom_temporaire) )
        {exit("Le fichier est introuvable");}
// on copie le fichier dans le dossier de destination

        if($_FILES['fichier']['size']>=10000000)
        {exit("fichier volumineux");}
        $infofichier=pathinfo($_FILES['fichier']['name']);
        $extension_upload=$infofichier['extension'];
        $extension_upload=strtolower($extension_upload);
        $extension_authorise=array('png','jpeg','jpg');
        if(!in_array($extension_upload,$extension_authorise))
        {exit("extension non authorisée svp(authorised(png,jpg,jpeg)");}
        $nom_photo=$nom.".".$extension_upload;
        if(!move_uploaded_file($nom_temporaire,$dossier.$nom_photo))
        {
            exit("error");
        }
        $ph_name=$nom_photo;}
    else{
        $ph_name="2.png";}
    $sql="insert into prof (NOM,PRENOM,mdp,email,photo) 
values ('$pass','$nom','$prenom','$email','$ph_name')";
    $resultat=mysqli_query($link,$sql);
    if ($resultat==true) {
        echo "SUCCESS,professeur ".$nom ."ajouté !";


    }
    else
    {
        echo "Erreur lors de la création de votre compte";
    }}
?>