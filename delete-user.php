<?php
require 'connection.php';
require 'admin-check.php';
require 'admin-restricted.php';


$email=$_GET['email'];
echo($email);

$sql = "DELETE FROM `users_basic_info` WHERE email='${email}'";
$query = $conn->prepare($sql);
$query->execute();
//header("Location:manage-users.php");

?>