<?php
require_once('db/cnx.php');

$i=$_GET['id'];

$sql="DELETE From USER WHERE id = '$i'";
$pdo->exec($sql);

header('location:user.php');





?>