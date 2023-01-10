<!-- ajouter module -->
<form action="#" method="post">

<td><label for="module" >module</label></td></br>
<td><input type="texte" name="nommodule"  ></td>
    </br>
    </br>
    
    <td><label for="semestre" >semestre</label></br></td>
    <td><select name="idsem" >

    <?php
 $sql1="SELECT * FROM `semestre`";
$result1=mysqli_query($link,$sql1);
while ($semestre=mysqli_fetch_assoc($result1))
{
echo '<option value='.$semestre["nomsem"].'>';
echo $semestre["nomsem"];
echo'</option>';
}
?>
</td>
</br>



    <input type="submit" value="ajouter"  name="ajouter">

    <?php
 include('connexion.php');
if(isset($_POST['ajouter']))
{
	$mod=$_POST['nommodule'];
    $sem=$_POST['idsem'];
   
        $sql2="INSERT INTO module values(NULL,'$mod','$sem')";
        $result2 = mysqli_query($link,$sql2) ;
} 

header('location: module.php');


?>


