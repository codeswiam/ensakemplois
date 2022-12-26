<html>
<head>
    <title>mycv</title>
    <link rel="stylesheet" href="style.css">
</head>
<style>
    .pseudo{
        color:red;
        font-weight: bold;
        text-decoration: underline;
    }
    input{
        width: 500px;
    }
</style>
<body>
<header>

</header>
<?php
session_start();
include "connexion.php";
$sql1="SELECT * FROM prof" ;
$result1=mysqli_query($link,$sql1);
$data1=mysqli_fetch_assoc ( $result1);
echo $data1['nom']." ";
echo $data1['prenom']." ";

?>
</body>
</html>
