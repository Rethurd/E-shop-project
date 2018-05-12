<?php
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
                    <a class="nav-link active" href="index.php">Home</a>
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
                                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#"><i class="fas fa-user mr-1"></i>'.$_SESSION['FName'].'</a>
                                <div class="dropdown-menu dropdown-menu-right" style="right:-1rem">

                                <a class="dropdown-item" href="account-settings.php"><i class="fas fa-cog mr-3" style="width:20px"></i>Settings</a>
                                <a class="dropdown-item" href="my-cart.php"><i class="fas fa-shopping-cart mr-3" style="width:20px;"></i></i>My cart</a>
                                
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
<div class="jumbotron py-5" >
  <h1 class="display-5">Hello, world!</h1>
  <p class="lead">This is a simple hero unit, a simple jumbotron-style component for calling extra attention to featured content or information.</p>
  <hr class="my-4">
  <p>It uses utility classes for typography and spacing to space content out within the larger container.</p>
  <p class="lead">
    <a class="btn btn-primary btn-lg" href="#" role="button">Learn more</a>
  </p>
</div>
<div class="hot-deals">
    <div class="section-title"><h4 class="display-4">Hot Deals</h4></div>
<div class="row">
    <div class="col-sm-12 col-md-4">
        <div class="card " >
            <img class="card-img-top" src="images/placeholder-blue.png" alt="Card image cap">
            <span class="img-sibling">Short description of a product.</span>
        </div>
    </div>
    <div class="col-sm-12 col-md-4" >
        <div class="card " >
            <img class="card-img-top" src="images/placeholder-blue.png" alt="Card image cap">
            <div class="img-sibling">Short description of a product.</div>
            
        </div>
    </div>
    <div class="col-sm-12 col-md-4">
        <div class="card " >
            <img class="card-img-top" src="images/placeholder-blue.png" alt="Card image cap">
            <span class="img-sibling">Short description of a product.</span>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12 col-md-4">
        <div class="card " >
            <img class="card-img-top" src="images/placeholder-blue.png" alt="Card image cap">
            <span class="img-sibling">Short description of a product.</span>
        </div>
    </div>
    <div class="col-sm-12 col-md-4" >
        <div class="card " >
            <img class="card-img-top" src="images/placeholder-blue.png" alt="Card image cap">
            <div class="img-sibling">Short description of a product.</div>
            
        </div>
    </div>
    <div class="col-sm-12 col-md-4">
        <div class="card " >
            <img class="card-img-top" src="images/placeholder-blue.png" alt="Card image cap">
            <span class="img-sibling">Short description of a product.</span>
        </div>
    </div>
</div>
</div>

<div class="reviews">
<!-- TO DO -->
</div>
<div class="footer">
    <!-- TO DO -->
</div>
</div>


</body>

</html>