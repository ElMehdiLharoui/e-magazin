<?php

	$dsn = "mysql:host=localhost;dbname=zackbase";

	try {
		$pdo = new PDO($dsn, 'root', '');
	}
	catch(PDOException $e) {
		echo $e->getMessage();
	}

?>