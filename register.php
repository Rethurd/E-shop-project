<?php 
session_start();
require 'connection.php';

// TO DO: if session variable exists and equals 1 (because at logout we set it to 0, unless session_destroy destroys all session variables
//), redirect to index
// UPDATE: check only if its set, session_destroy() gets rid of the variables 
if(isset($_SESSION['logged-in']))
{
    header("Location: index.php");
}

//if already sent form, check if email is already in the database
if(isset($_POST['email']))
    {
        $sql = "SELECT email em FROM `users_basic_info`";
            $query = $conn->prepare($sql);
            $query->execute();
            $allRows = $query->fetchAll(PDO::FETCH_ASSOC);
            foreach ($allRows as $row) {
                if($_POST['email']==$row['em'])
                {
                    $usernameUsed =1;
                    
                }
              }
    }
// if already sent form, check if password is longer than 6 characters.
if (isset($_POST['password']))
{
    if(strlen($_POST['password'])<6)
    {
        $passwordShort=1;
    }
}
// if already sent form, check if passwords match 
if (isset($_POST['password']) && isset($_POST['confirm-password']))
{
    if($_POST['password']!==$_POST['confirm-password'])
    {
        $passwordDifferent=1;
        
    }
}
// if no errors, add record to the database
if(!isset($passwordDifferent) && !isset($usernameUsed))
{
    if(isset($_POST['email'])) // if this is set, everything else is set, because of client-side validation
    {                          // therefore need to check just for one
        $passwordEncrypted = sha1($_POST['password']);
        $sql = "INSERT INTO `USERS_BASIC_INFO` (`ID`, `email`, `firstname`, `lastname`, `password`) VALUES (NULL, '${_POST['email']}', '${_POST['first-name']}', '${_POST['last-name']}', '${passwordEncrypted}');";
        $query = $conn->prepare($sql);
        $query->execute();
        //Log the user in and THEN redirect to index.php
        $_SESSION["logged-in"]=1;
        //set username to display 
        $_SESSION["FName"]=$_POST['first-name'];
        header("Location: index.php");
        
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
            $('#email-exists').css('display','none');
           }
           else{
            $('#email-exists').css('display','inline-block');
           }
        });

        $('#confirm-password-id').keyup(function () {
           if($('#confirm-password-id').val()!='')
           {
            $('#password-different').css('display','none');
           }
           else{
            $('#password-different').css('display','inline-block');
           }
        });
        $('#password-id').keyup(function () {
           if($('#password-id').val().length>=6)
           {
            $('#password-short').css('display','none');
           }
           else{
            $('#password-short').css('display','inline-block');
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
    <h1 class="mt-4 mb-5 text-center">Create an account</h3>
    <!-- novalidate out for debugging -->
    <form class="needs-validation" action="" method="POST" novalidate >
        <div class="row">
        <div class="form-group mx-3" style="width:233px">
            <label >First name</label>
            <input name="first-name" type="text" class="form-control" placeholder="First name" required >
            <div class="invalid-feedback">
             Enter your first name
            </div>
        </div> 
        <div class="form-group mx-3" style="width:233px">
            <label>Last name</label>
            <input name="last-name" type="text" class="form-control" placeholder="Last name" required >
            <div class="invalid-feedback">
            Enter your last name
            </div>
        </div> 
        </div>
        <div class="form-group">
            <label>Your email</label>
            <!-- here check in php if we made a variable from the beginnign of the file which checks -->
            <input id="email-id" name="email" class="form-control" placeholder="Email" type="email" required >
            <div class="invalid-feedback">
            Enter valid email address
            </div>
            <?php 
            if(isset($usernameUsed))
            {
                if($usernameUsed==1)
                {
                    //print that its used
                    echo('<div id="email-exists" class="invalid-feedback" style="display:inline-block">Email already in use</div>');
                }
            }
            ?>
        </div> 
        <div class="form-group">
            <label>Your password</label>
            <input id="password-id" name="password" class="form-control" placeholder="******" type="password" required >
            <?php
            if(isset($passwordShort))
            {
                //print that its used
                echo('<div id="password-short" class="invalid-feedback" style="display:inline-block">Password needs to be at least 6 characters</div>');
            }
            ?>
        </div>  
        <div class="form-group">
            <label>Confirm password</label>
            <input id="confirm-password-id" name="confirm-password" class="form-control" placeholder="******" type="password" required >
            <?php 
            if(isset($passwordDifferent))
            {
                //print information that the passwords are different
                echo('<div id="password-different" class="invalid-feedback" style="display:inline-block">Passwords do not match</div>');
            }
            ?>
        </div> 
        <div class="custom-control custom-checkbox mb-3">
            <input name="tos" type="checkbox" class="custom-control-input" id="customControlValidation1" required >
            <label class="custom-control-label" for="customControlValidation1">I accept the Terms of Service</label>
            <div class="invalid-feedback">ToS need to be accepted</div>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-block"> Sign up!  </button>
        </div>                                                          
    </form>
    <div class="text-center mt-5"><a href="login.php">Already have an account? Sign in here!</a></div>
</div>
</div>


</body>

</html>