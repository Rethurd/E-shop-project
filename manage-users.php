<?php
require 'connection.php';
require 'admin-check.php';
require 'admin-restricted.php';



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
<script>
  $(document).ready(function()
  {
    
    var storeData=[];
    //editing an entry
    $(document).on('click', '.btn-edit', function() // simply $(".btn-edit").on("click",func...) doesnt work on dynamically created elements
    {
      //FIXED: doesnt work anymore when you go through the edit-cancel cycle once, it doesnt even trigger the event, but it DOES have the .btn-edit class??
      //jQuery function didn't work on dynamic elements
      var btnId = $(this).attr('id');
      var rowId= btnId.replace('btn','row');
      var selectedRow = document.getElementById(rowId);
      $myArr= $(this).parent().parent()[0]["childNodes"];
      //cannot assign myArr straight to storeData, creating a copy of data:
      var oldDataArr=[];
      for (var j=0;j<6;j++)
      {
        oldDataArr[j]=$myArr[j].innerHTML;
        
      }
      var current1;
      storeData[rowId]=oldDataArr;
      for (var i=0;i<4;i++)
      { 
        //ids given as row-0-0, row-1-2 etc... (row-rowNum-inputNum)
        if(i==0)
        {
          $temp=$myArr[i].innerHTML;
          $myArr[i].innerHTML="<input id='"+rowId+"-"+i+"' type='text'  disabled placeholder='"+$temp+"'/>";
          //instead of placeholders, more comfortable 
          current1=document.getElementById(rowId+"-"+i);
          current1.value=$temp;
          //console.log($myArr[i].innerHTML);
        }
        else if(i==3)
        {
          $temp=$myArr[i].innerHTML;
          $myArr[i].innerHTML="<input id='"+rowId+"-"+i+"' type='text' disabled placeholder='"+$temp+"'/>"; 
          current1=document.getElementById(rowId+"-"+i);
          current1.value=$temp;

        }
        else{
          $temp=$myArr[i].innerHTML;
          $myArr[i].innerHTML="<input id='"+rowId+"-"+i+"' type='text' placeholder='"+$temp+"'/>"; 
          current1=document.getElementById(rowId+"-"+i);
          current1.value=$temp;
        }
      } 
      $myArr[4].innerHTML="<button id="+btnId.replace('btn','btn-save')+ " class='btn btn-success'>Save</button>"
      $myArr[5].innerHTML="<button id="+btnId.replace('btn','btn-cancel')+ " class='btn btn-warning '>Cancel</button>"
      
      //cancellation
      $(document).on('click', '.btn-warning', function()
      {
        var cancelButtonId = $(this).attr('id');
        var cancelRowId=cancelButtonId.replace('btn-cancel','row');
        var cancelSelectedRow = document.getElementById(cancelRowId);
       
        for (var j=0;j<6;j++)
        {
          cancelSelectedRow.childNodes[j].innerHTML=storeData[cancelRowId][j];
          console.log(storeData[cancelRowId][j]);
        }
     
      });
      
      //addition
      $(document).on('click','.btn-success',function()
      {
        var addButtonId = $(this).attr('id');
        var addRowId=addButtonId.replace('btn-save','row');
        var addSelectedRow = document.getElementById(addRowId);
        //getting ID of CODE to get the placeholder values;
        var email = $("#"+addRowId+"-0").attr('placeholder'); // email read from placeholder

        var fname = addSelectedRow.childNodes[1].childNodes[0].value;
        var lname = addSelectedRow.childNodes[2].childNodes[0].value;
        //var pwd = addSelectedRow.childNodes[3].childNodes[0].value;
        var address = "edit-user.php?email="+email+"&fname="+fname+"&lname="+lname;  
        window.location=address;
        //window.location="addRow.php?code="+code+;
      });
    });
    
      //deleting an entry
      $(document).on('click', '.btn-danger', function()
    {
      var email = $(this).parent().parent()[0]['childNodes'][0].innerHTML;
      console.log(email);
      window.location="delete-user.php?email="+email;
      
      
    });
      //adding a new entry
    
  });
</script>
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
                                    <a class="dropdown-item active" href="manage-users.php"><i class="fas fa-users mr-3" style="width:20px" ></i>Manage users</a>
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

<div class="add-product">
    <div class="heading h3 text-center mt-3 mb-5 ">Manage users:</div>
    <?php
        $sql="SELECT id id, email email,firstname fname, lastname lname, password pwd FROM `users_basic_info` ";
        $query = $conn->prepare($sql);
        $query->execute();
        $allRows = $query->fetchAll(PDO::FETCH_ASSOC);
        echo('<table class="table table-hover"><thead><tr><th>Email</th><th>First name</th><th>Last name</th><th>Password (encrypted)</th><th colspan="2">Functions</th></tr></thead><tbody>
           ');
        $rownum=0;
        foreach($allRows as $row)
        { echo "<tr id='row-".$rownum."'><td>".$row['email']."</td><td>".$row['fname']."</td><td>".$row['lname']."</td><td>".$row['pwd'].
          "</td><td><button id='btn-".$rownum."' class='btn btn-info btn-edit'>Edit</button></td><td><button class='btn btn-danger'>Delete</button></td></tr>";
          $rownum++;
        
        }
        echo('</table>');
        
    ?>
</div>


<div class="footer">
    <!-- TO DO -->
</div>
</div>


</body>

</html>