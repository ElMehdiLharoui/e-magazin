<?php
require_once('db/cnx.php');
if(isset($_POST['submit'])){
if(!(empty($_POST['nom'])) and !(empty($_POST['date'])) and !(empty($_POST['pswd'])) and !(empty($_POST['prenom'])) and !(empty($_POST['email'])) and !(empty($_POST['ville'])) and !(empty($_POST['adresse']))){
$nomf=$_POST['nom'];
$datef=$_POST['date'];
$pswdf=$_POST['pswd'];
$prenomf=$_POST['prenom'];
$emailf=$_POST['email'];
$villef=$_POST['ville'];
$adressef=$_POST['adresse'];
$rolef=$_POST['role'];
$etaf=$_POST['etat'];

$sql="INSERT INTO user (nom, prenom, email, adresse,ville, pswd, date, etat, role) VALUES ('$nomf','$prenomf','$emailf','$adressef','$villef',md5('$pswdf'),'$datef',0,'$rolef')";
$pdo->exec($sql);
echo "update page";
//header('location:user.php');
}
}
?>