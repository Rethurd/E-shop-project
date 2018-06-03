<?php
require 'connection.php';
require 'vendor/autoload.php';
require 'admin-check.php';
require 'admin-restricted.php';

//if already tried to add an item, try to validate:
if(isset($_POST['name']) && $_POST['name']!='')
{
    $error=0;
    if($_POST['price']<=0)
    {
        $error=1;
        $priceErrorMessage="Price has to be greater than 0";
    }
    if(strlen($_POST['description'])>1000)
    {
        $error=1;
        $descriptionErrorMessage="Description has to be shorter than 1000 characters";
    }
    if(strlen($_POST['additional-information'])>200)
    {
        $error=1;
        $addInfoErrorMessage="This field has to be shorter than 200 characters";
    }
    if(empty($_POST['warranty']))
    {
        $error=1;
        $warrantyErrorMessage="This field should not be empty!";
    }
    //validation complete, add new record
    if($error==0)
    {
        $image=addslashes($_FILES['image']['tmp_name']);
        $image=file_get_contents($image);
        $image=base64_encode($image);
        
        // $sql="INSERT INTO `all_products` (`ID`, `name`, `description`, `image`, `price`, 
        // `manufacturer`, `warranty`, `type`, `model`, `additional_info`, `ratings`, `popularity`) VALUES
        // (NULL, ${_POST['name']}, ' work or also for gaming.', NULL,'${_POST['price']}',
        //  '${_POST['manufacturer]}', '${_POST['warranty']}', 'laptop', 'A515-51G-509A', NULL, '0', '0');";
         $sql="INSERT INTO `all_products` (`ID`, `name`, `description`, `image`, `price`, `manufacturer`, `warranty`,
          `type`, `model`, `additional_info`, `ratings`, `popularity`)
          VALUES (NULL, '${_POST['name']}', '${_POST['description']}', '${image}', '${_POST['price']}', '${_POST['manufacturer']}', '${_POST['warranty']}',
           '${_POST['type']}', '${_POST['model']}', '${_POST['additional-information']}','0','0');";
           $query=$conn->prepare($sql);
           $query->execute();
    }
}


?>
<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Add Products</title>
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
                                <a class="dropdown-item" href="my-cart.php"><i class="fas fa-shopping-cart mr-3" style="width:20px;"></i></i>My cart</a>
                                
                                ';
                                if(isset($_SESSION['adminAccount']))
                                {
                                echo'
                                    <a class="dropdown-item" href="manage-users.php"><i class="fas fa-users mr-3" style="width:20px" ></i>Manage users</a>
                                    <a class="dropdown-item active " href="add-product.php"><i class="fas fa-plus mr-3" style="width:20px" ></i>Add products</a>
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

<div class="add-product">
    <div class="heading h3 text-center mt-3 mb-5 ">Add product:</div>
    <form method="POST" action="#" enctype="multipart/form-data">
        <div class="row first-row" >
           <div class="col-sm-12 col-lg-3 my-auto">
                <div class="row mb-2">
                    <label class="col-5 text-center" for="" class="mr-3">Label:</label>
                    <input class="col-7 form-control" name="name" type="text" required>
                    
                </div>
                
                <div class="row">
                    <label class="col-5 text-center" for="" class="mr-3">Price:</label>
                    <input class="col-7 form-control" name="price" type="number">
                </div>
                <?php
                    if(isset($priceErrorMessage))
                    {
                        echo('<div class="text-danger text-center">'.$priceErrorMessage.'</div>');
                    }
                ?>
           </div>
           <div class=" col-sm-12 col-lg-6 mb-3">
                <div class="text-center ">Description:</div>
                <div class="mx-auto"><textarea class="form-control mx-auto"  name="description" rows="3" style="width:400px;"></textarea></div>
                <?php
                    if(isset($descriptionErrorMessage))
                    {
                        echo('<div class="text-danger text-center">'.$descriptionErrorMessage.'</div>');
                    }
           ?>
           </div>
          
           <div class="col-sm-12 col-lg-3">
                <div class="text-center ">Additional information:</div>
                <div class="mx-auto"><textarea class="form-control mx-auto"  name="additional-information" rows="3"></textarea></div>
                <?php
                if(isset($addInfoErrorMessage))
                {
                    echo('<div class="text-danger text-center">'.$addInfoErrorMessage.'</div>');
                }
                ?>
           </div>
        </div>
        <div class="row second-row">
        
            <div class="col-sm-6 col-lg-3 py-2" >
                <div class="text-center mb-2">Manufacturer:</div>
                <div > <input class="form-control mx-auto" name="manufacturer" type="text"></div>
            </div>
            <div class="col-sm-6 col-lg-3 py-2" >
                <div class="text-center mb-2">Warranty:</div>
                <div > <input class="form-control mx-auto" name="warranty" type="text"></div>
                <?php
                    if(isset($warrantyErrorMessage))
                    {
                        echo('<div class="text-danger text-center">'.$warrantyErrorMessage.'</div>');
                    }
                ?>
            </div>
            <div class="col-sm-6 col-lg-3 py-2" >
                <div class="text-center mb-2">Type:</div>
                
                <div >
                    <select class="form-control mx-auto" name="type" > 
                    <?php
                        $sql = "SELECT DISTINCT type type FROM all_products";
                        $query=$conn->prepare($sql);
                        $query->execute();
                        $allRows=$query->fetchAll(PDO::FETCH_ASSOC);
                        echo($allRows);
                        foreach($allRows as $row)
                        {
                            echo ('<option value='.ucfirst($row['type']).' >'.ucfirst($row['type']).'</option>');
                        }
                       
                    ?>
                    </select>
                </div>
                
            </div>
            <div class="col-sm-6 col-lg-3 py-2"  >
                <div class="text-center mb-2">Model:</div>
                <div > <input class="form-control mx-auto" name="model" type="text"></div>
            </div>
        </div>


        <div class="row">
            <div class="col-sm-12 col-lg-6 py-2 row" >
                <label class="text-center mb-2 col-3">Image:</label>
                 <input class="form-control mx-auto col-9" name="image" type="file" id="image">
            </div>
            <div class="col-sm-12 col-lg-6 my-auto">
                <button type="submit" class="btn btn-primary btn-block mx-auto" style="width:300px"> Add  </button>
            </div> 
        </div>
            
            
    </form>
</div>


<div class="footer">
    <!-- TO DO -->
</div>
</div>


</body>

</html>