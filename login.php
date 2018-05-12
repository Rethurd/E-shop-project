<?php
require('connection.php');
session_start();
// check if session variable exists, if yes, redirect to index
if(isset($_SESSION["logged-in"]))
{
    header("Location: index.php");
}
//if not then check if email exists in database and if the password matches, log in, create session variable, redirect to index.php
else{
    if(isset($_POST['email']) && isset($_POST['password']))
    {
        $sql = "SELECT firstname fname, email em, password pass FROM `users_basic_info`";
        $query = $conn->prepare($sql);
        $query->execute();
        $allRows = $query->fetchAll(PDO::FETCH_ASSOC);
        $emailFound=0;
        foreach ($allRows as $row) {
            if($_POST['email']==$row['em'])
            {
                $emailFound=1;
                if(sha1($_POST['password'])==$row['pass'])
                {
                    $_SESSION["logged-in"]=1;
                    //set username to display 
                    $_SESSION["FName"]=$row['fname'];
                    $_SESSION["email"]=$row['em'];
                    header("Location:index.php");
                }
            }
            
            //if it got there - password incorrect 
            $passwordIncorrect=1;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/style.css">
    
</head>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script>
// Example starter JavaScript for disabling form submissions if there are invalid fields
(function() {
  'use strict';
  window.addEventListener('load', function() {
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.getElementsByClassName('needs-validation');
    // Loop over them and prevent submission
    var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    });
  }, false);
})();

$(document).ready(function () {
       $('#email-id').keyup(function () {
           if($('#email-id').val()!='')
           {
            $('#email-not-found').css('display','none');
           }
           else{
            $('#email-not-found').css('display','inline-block');
           }
        });
        $('#password-id').keyup(function () {
           if($('#password-id').val()!='')
           {
            $('#password-incorrect').css('display','none');
           }
           else{
            $('#password-incorrect').css('display','inline-block');
           }
        });
   });
</script>
<!-- <script src="js/login.js"></script> -->
<body>
<div class="container">
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
                            echo('<a class="nav-link active" href="login.php">Login</a>');
                        }
                    ?>
                </li>
                
            </ul>
        </div>
</nav>
<div class="login-form mx-auto" >
    <h1 class="mt-4 mb-5 text-center">Sign in</h3>
    <!-- add client-side validation -->
    <form class="needs-validation" method='POST' action="" novalidate >
        <div class="form-group">
            <label>Your email</label>
            <input id="email-id" name="email" class="form-control" placeholder="Email" type="email" required>
            <div class="invalid-feedback">
            Enter a valid email address
            </div>
            <?php 
            if(isset($emailFound) && $emailFound==0)
            {
                echo('<div id="email-not-found" class="invalid-feedback" style="display:inline-block">There is no account for this email</div>');
            }
            ?>
        </div> 
        <div class="form-group">
            <a class="float-right" href="#">Forgot?</a>
            <label>Your password</label>
            <input id="password-id" name="password" class="form-control" placeholder="******" type="password" required>
            <div class="invalid-feedback">
            Enter valid password
            </div>
            <?php 
            if(isset($passwordIncorrect))
            {
                echo('<div id="password-incorrect" class="invalid-feedback" style="display:inline-block">Incorrect password</div>');
            }
            ?>
        </div>  
        <div class="form-group"> 
            <div class="checkbox">
                <label> <input type="checkbox"> Save password </label>
            </div> 
        </div> 
        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-block"> Login  </button>
        </div>                                                          
    </form>
    <div class="text-center mt-5"><a href="Register.php">No account? Register here</a></div>
</div>
</div>
</body>

</html>