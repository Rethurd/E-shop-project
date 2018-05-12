<?php
require 'connection.php';
require 'admin-check.php';
require 'admin-restricted.php';


$name=$_GET['name'];
$descr=$_GET['descr'];
echo($name);
echo($descr);

$sql = "DELETE FROM `all_products` WHERE name='${name}' AND description='${descr}'";
$query = $conn->prepare($sql);
$query->execute();
header("Location:manage-products.php");

?>