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
    
}
else{
    $_SESSION['cart']=array();
    array_push($_SESSION['cart'],$item);
}
echo($_SESSION['cart']);


?>