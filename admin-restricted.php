<?php
if(isset($_SESSION['logged-in']))
{
    if(in_array($_SESSION['email'],$admins))
    {
        $_SESSION['adminAccount']=true;
    }
    else{
        header("Location:index.php");
    }
}
else{
    
        header("Location:index.php");
    
}
?>