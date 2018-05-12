<?php
require 'vendor/autoload.php';
require 'admin-check.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/index.js"></script>
<body>

<div class="container">
    <!-- navbar-expand-lg means it will show the items when its lg and collapse when < -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <a class="navbar-brand" href="index.php"><i class="fas fa-shopping-bag mr-2"></i>WeShop</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
    <span class="navbar-toggler-icon"></span>
</button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link " href="index.php">Home</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link " href="products.php">Products</a>
                    
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="about.php">About</a>
                </li>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contact-us.php">Contact Us</a>
                </li>
                <!-- If logged in, make a dropdown menu with settings, shopping cart, logout -->
                <li class="nav-item dropdown ">
                    <?php
                        if(isset($_SESSION['logged-in']))
                        {
                            echo
                                '
                                <a class="nav-link dropdown-toggle active" data-toggle="dropdown" href="#"><i class="fas fa-user mr-1"></i>'.$_SESSION['FName'].'</a>
                                <div class="dropdown-menu dropdown-menu-right" style="right:-1rem">

                                <a class="dropdown-item" href="account-settings.php"><i class="fas fa-cog mr-3" style="width:20px"></i>Settings</a>
                                <a class="dropdown-item active" href="my-cart.php"><i class="fas fa-shopping-cart mr-3" style="width:20px;"></i></i>My cart</a>
                                
                                ';
                                if(isset($_SESSION['adminAccount']))
                                {
                                echo'
                                    <a class="dropdown-item" href="manage-users.php"><i class="fas fa-users mr-3" style="width:20px" ></i>Manage users</a>
                                    <a class="dropdown-item" href="add-product.php"><i class="fas fa-plus mr-3" style="width:20px" ></i>Add products</a>
                                    <a class="dropdown-item" href="manage-products.php"><i class="fas fa-edit mr-3" style="width:20px" ></i>Edit products</a>
                                    <a class="dropdown-item" href="admin-statistics.php"><i class="far fa-chart-bar mr-3" style="width:20px" ></i>Statistics</a>
                                ';
                                }
                                echo'
                                <div class="dropdown-divider"></div>

                                <a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt mr-3" style="width:20px" ></i>Logout</a>
                                
                                </div>
                            ';

                        }
                        else{
                            echo('<a class="nav-link" href="login.php">Login</a>');
                        }
                    ?>
                </li>
                
            </ul>
        </div>
</nav>
<div class="cart-container">
    <div class="heading h3 text-center mt-3 mb-5 ">Shopping cart:</div>
    <?php
    if(isset($_SESSION['cart']))
    {
        print_r($_SESSION['cart']);
    }
    else{
        echo(456);
    }

    ?>  
</div>
<div class="footer">
    <!-- TO DO -->
</div>
</div>


</body>

</html>