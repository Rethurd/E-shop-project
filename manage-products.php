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
    <title>Document</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/index.js"></script>
<script>
function capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}
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
      for (var j=0;j<10;j++)
      {
        oldDataArr[j]=$myArr[j].innerHTML;
        
      }
      var current1;
      storeData[rowId]=oldDataArr;
      var typesStr = $("#typesStr")[0].childNodes[0]['data'];
      typesArr = typesStr.split(', ');
      for (var i=0;i<10;i++)
      {         
        if(i==1)
        {
            $temp=$myArr[i].innerHTML;
          $myArr[i].innerHTML="<textarea class='form-control' id='"+rowId+"-"+i+"' style='width:300px' rows='3' placeholder='"+$temp+"'></textarea>"; 
          current1=document.getElementById(rowId+"-"+i);
          current1.value=$temp;
        }
        else if(i==5)
        {
            $temp=$myArr[i].innerHTML;
            //<select class="form-control mx-auto" name="type" > 
            $typeInnerHTML="";
            $typeInnerHTML="<select class='form-control'  id='"+rowId+"-"+i+"' >";
            for(var j=0;j<typesArr.length-1;j++)
            {
                $typeInnerHTML+='<option value='+typesArr[j]+' >'+typesArr[j]+'</option>';
            }
            $typeInnerHTML+="</select>"; 
            $myArr[i].innerHTML=$typeInnerHTML;
            console.log($typeInnerHTML)
            current1=document.getElementById(rowId+"-"+i);
            current1.value=$temp;  
        }
        else if(i==7)
        {
            $temp=$myArr[i].innerHTML;
          $myArr[i].innerHTML="<textarea class='form-control' id='"+rowId+"-"+i+"' style='width:170px' rows='3' placeholder='"+$temp+"'></textarea>"; 
          current1=document.getElementById(rowId+"-"+i);
          current1.value=$temp;
        }
        else{
          $temp=$myArr[i].innerHTML;
          $myArr[i].innerHTML="<input class='form-control' id='"+rowId+"-"+i+"' type='text' placeholder='"+$temp+"'/>"; 
          current1=document.getElementById(rowId+"-"+i);
          current1.value=$temp;
        }
        
      } 
      console.log($myArr);
      $myArr[8].innerHTML="<button id="+btnId.replace('btn','btn-save')+ " class='btn btn-success'>Save</button>"
      $myArr[9].innerHTML="<button id="+btnId.replace('btn','btn-cancel')+ " class='btn btn-warning '>Cancel</button>"
      
      //cancellation
      $(document).on('click', '.btn-warning', function()
      {
        var cancelButtonId = $(this).attr('id');
        var cancelRowId=cancelButtonId.replace('btn-cancel','row');
        console.log(cancelRowId);
        var cancelSelectedRow = document.getElementById(cancelRowId);
       
        for (var j=0;j<10;j++)
        {
          cancelSelectedRow.childNodes[j].innerHTML=storeData[cancelRowId][j];
          console.log(storeData[cancelRowId][j]);
        }
     
      });
      
      //confirm edition
      $(document).on('click','.btn-success',function()
      {
        var addButtonId = $(this).attr('id');
        var addRowId=addButtonId.replace('btn-save','row');
        var addSelectedRow = document.getElementById(addRowId);
        console.log(addSelectedRow.childNodes);
        //getting ID of CODE to get the placeholder values;
        var id = addSelectedRow.childNodes[10].childNodes[0]['data'];


        var name = addSelectedRow.childNodes[0].childNodes[0].value;
        var descr = addSelectedRow.childNodes[1].childNodes[0].value;
        var price = addSelectedRow.childNodes[2].childNodes[0].value;
        var manufacturer = addSelectedRow.childNodes[3].childNodes[0].value;
        var warranty = addSelectedRow.childNodes[4].childNodes[0].value;
        var type = addSelectedRow.childNodes[5].childNodes[0].value;
        var model = addSelectedRow.childNodes[6].childNodes[0].value;
        var info = addSelectedRow.childNodes[7].childNodes[0].value;
        
        //var pwd = addSelectedRow.childNodes[3].childNodes[0].value;
        var address = "edit-product.php?id="+id+"&name="+name+"&descr="+descr+"&price="+price+"&manufacturer="+manufacturer+"&warranty="+warranty+"&type="+type+"&model="+model+"&info="+info;  
        window.location=address;
        //window.location="addRow.php?code="+code+;
      });
    });
    
      //deleting an entry
      $(document).on('click', '.btn-danger', function()
    {
     var name = $(this).parent().parent()[0]['childNodes'][0].innerHTML;
     var descr = $(this).parent().parent()[0]['childNodes'][1].innerHTML;
      window.location="delete-product.php?name="+name+"&descr="+descr;
      
      
    });
      //adding a new entry
    
  });
</script>

<body>

<div class="container-fluid">
    <!-- navbar-expand-lg means it will show the items when its lg and collapse when < -->
    <nav class="navbar container navbar-expand-lg navbar-dark bg-primary">
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
                                    <a class="dropdown-item" href="add-product.php"><i class="fas fa-plus mr-3" style="width:20px" ></i>Add products</a>
                                    <a class="dropdown-item active  " href="manage-products.php"><i class="fas fa-edit mr-3" style="width:20px" ></i>Edit products</a>
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

<div class="manage-products container-fluid">
    <div class="heading h3 text-center mt-3 mb-5 container-fluid ">Manage products:</div>
    <?php
        $sql="SELECT id id, name name, description descr, image img, price price, manufacturer manu, warranty warr, type type, model model, additional_info info FROM `all_products` ";
        $query = $conn->prepare($sql);
        $query->execute();
        $allRows = $query->fetchAll(PDO::FETCH_ASSOC);
        echo('<table class="table table-hover"><thead><tr><th>Label</th><th>Description</th><th>Price</th><th>Manufacturer</th><th>Warranty</th>
        <th>Type</th><th>Model</th><th>Additional information</th>
        <th colspan="2">Functions</th></tr></thead><tbody>
           ');
           $rownum=0;
        foreach($allRows as $row)
        { 

            echo "<tr id='row-".$rownum."'><td>".$row['name']."</td><td style='width:300px'>".$row['descr']."</td><td>".$row['price']."</td><td>".$row['manu']."</td><td>".$row['warr']."</td><td >".$row['type']."</td><td>".$row['model']."</td><td style='width:100px'>".$row['info']."</td><td><button id='btn-".$rownum."' class='btn btn-info btn-edit'>Edit</button></td><td><button class='btn btn-danger'>Delete</button></td><td style='display:none'>".$row['id']."</td></tr>";
            $rownum++;
        }
        echo('</table>');
        
        //provide a reference for exisiting typesStr
        $sql = "SELECT DISTINCT type type FROM all_products";
        $query=$conn->prepare($sql);
        $query->execute();
        $allRows=$query->fetchAll(PDO::FETCH_ASSOC);
        echo('<div id="typesStr" style="display:none;">');
        foreach($allRows as $row)
        {
            echo ($row['type'].", ");
        }
        echo('</div>');
                       
                    
        
    ?>
</div>
<div class="footer">
    <!-- TO DO -->
</div>
</div>


</body>

</html>