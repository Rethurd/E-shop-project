<?php
require 'admin-check.php';
require 'admin-restricted.php';
$id = $_POST['IdToRemove'];
echo($id);
print_r($_SESSION['cart']);
if(isset($_SESSION['cart']))
{
    //php arrays - not real arrays - when removing an element, gotta move every other one ...
    for($i=0;$i<sizeof($_SESSION['cart']);$i++)
    {
        if($_SESSION['cart'][$i]==$id)
        {   
            unset($_SESSION['cart'][$i]);
            $_SESSION['cart'] = array_values($_SESSION['cart']);
            break;
        }
    }
    print_r($_SESSION['cart']);
}


?>