<?php
require 'connection.php';
require 'admin-check.php';
require 'admin-restricted.php';

$email=$_GET['email'];
$fname=$_GET['fname'];
$lname=$_GET['lname'];


    $sql = "UPDATE `users_basic_info` SET `firstname` = '${fname}', `lastname` = '${lname}' WHERE `users_basic_info`.`email` = '${email}';";
     echo($sql);
    $query = $conn->prepare($sql);
    $query->execute();
    header("Location:manage-users.php");
    

?>