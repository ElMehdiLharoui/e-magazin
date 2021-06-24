<?php
$host ='127.0.0.1';
$user ='root';
$db='web_projet';
$charcet='utf8mb4';
$pass ='';
 $dsn = "mysql:host=$host;dbname=$db;charset=$charcet";
   try{
      $pdo =new PDO($dsn,$user,$pass);
      echo 'salut bana lharoui';
   }
   catch(PDOException $ex){
    throw new PDOException($ex->getMessage());
   }


?>