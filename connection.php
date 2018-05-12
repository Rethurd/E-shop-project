<?php

$db_name = "myshopapp";
$db_user = "root";
$db_pass = "";
$db_host = "localhost";

try {
	$conn = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_pass);
} catch (PDOException $e) {
	echo 'Connection failed: ' . $e->getMessage();
}

?>