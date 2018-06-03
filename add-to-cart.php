<?php
require 'connection.php';
session_start();
$item=$_POST['item'];
if(isset($_SESSION['cart']))
{
    //if its already in, dont add again:
    if(!in_array($item,$_SESSION['cart']))
    {
        array_push($_SESSION['cart'],$item);
    }
    $sql = "SELECT popularity pop FROM all_products WHERE id=${item}";
    $query=$conn->prepare($sql);
    $query->execute();
    $allRows = $query->fetchAll(PDO::FETCH_ASSOC);
    $currentPop= $allRows[0]['pop'];
    $currentPop++;
    $sqlUpdate = "UPDATE all_products SET popularity=${currentPop} WHERE ID=${item}";
    $query=$conn->prepare($sqlUpdate);
    $query->execute();
    
}
else{
    $_SESSION['cart']=array();
    array_push($_SESSION['cart'],$item);
}



?>