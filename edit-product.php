<?php
require 'connection.php';
require 'admin-check.php';
require 'admin-restricted.php';

// var address = "edit-product.php?id="+id+"&name="+name+"&descr="+descr+"&price="+price+"&manufacturer="+manufacturer+"&warranty="+warranty+"&type="+type+"&model="+model+"&info="+info;  
       
$id=$_GET['id'];
$name=$_GET['name'];
$descr=$_GET['descr'];
$price=$_GET['price'];
$manufacturer=$_GET['manufacturer'];
$warranty=$_GET['warranty'];
$type=$_GET['type'];
$model=$_GET['model'];
$info=$_GET['info'];


    $sql = "UPDATE `all_products` SET `name` = '${name}', `description` = '${descr}', `price` = '${price}',
     `manufacturer` = '${manufacturer}', `warranty` = '${warranty}', `type` = '${type}', `model` = '${model}', `additional_info` = '${info}' WHERE `all_products`.`id` = '${id}';";
     echo($sql);
    $query = $conn->prepare($sql);
    $query->execute();
    header("Location:manage-products.php");
    

?>