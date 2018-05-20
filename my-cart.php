<?php
require 'connection.php';
require 'admin-check.php';

print_r($_SESSION['cart']);
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
$(document).ready(function()
{
    $(document).on('change','.item-count',function()
    {
        if($(this).val()>20)
        {
            $(this).val(20);
           
        }
        console.log($(this));
        //get current sum of prices
        var currentSum = $("#current-total-price")[0]['innerHTML'];
        //get the id and price of changed item
        var idOfPricePerOne = $(this)[0]['id'].replace('count-','price-');
        var pricePerOne = $("#"+idOfPricePerOne+"")[0]['innerHTML'];
        // this approach doesnt work because if I dont know what was the previous value of count, i dont know how much to substract from the previous sum
        // gotta recalculate every time?
        // Make a loop to go through each row excluding the row of the changed one and calculate over
        var clickedRowId = $(this).parent().parent()[0]['id'];
        var table = $(this).parent().parent().parent()[0]['childNodes'];
        var newSum =0;
        var newCount=0;
        for (var i=0;i<table.length-1;i++)
        {
            if(table[i]['id']!=clickedRowId)
            {
                //change price:
                var countId = table[i]['childNodes'][5]['childNodes'][0]['id'];
                var count = $("#"+countId+"").val();
                var price = parseInt(table[i]['childNodes'][7]['innerHTML']);
                newSum+=price*count;
                newCount+=parseInt(count);
                console.log(newCount);
                //change count:

            }
        }
        // to the calculated, add the changed:
        newSum+=pricePerOne*$(this).val();
        newCount+=parseInt($(this).val());
        
        // change the sum to the new one
        $("#current-total-price")[0]['innerHTML']=newSum;
        $("#current-total-count-short")[0]['innerHTML']=newCount;
        $("#current-total-count-full")[0]['innerHTML']=newCount+" item(s)";

        
        
    })

    $(document).on('click','.remove-from-cart',function()
    {
        
        rowId = $(this).parent().parent()[0]['id'];
        var row = document.getElementById(rowId);
        row.parentNode.removeChild(row);
        justId=rowId.replace("row-","");

        //ajax call to remove it from session cart variable
        $.ajax({
            url: "remove-from-cart.php",
            method: "POST",
            data:{
                IdToRemove:justId
            },
            dataType:"html"
                }).done(function(msg) {
        console.log( msg );
        });
    
    })
    
})

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
        $sql = "SELECT id id, name name, price price FROM `all_products` ";
        for($i=0;$i<sizeof($_SESSION['cart']);$i++)
        {
            $current=$_SESSION['cart'][$i];
            if($i==0)
            {
                $sql.=" WHERE ID='${current}'";
            }
            else{
                $sql.=" OR ID='${current}'";
            }
        }
        $query=$conn->prepare($sql);
        $query->execute();
        $allRows = $query->fetchAll(PDO::FETCH_ASSOC);
        echo('<table class="cart-table table table-striped">');
        echo '<thead class="thead-dark"> 
                <tr>
                    <th>#</th>
                    <th>Item</th>
                    <th>Count</th>
                    <th>Price</th>
                    <th></th>
                </tr>
             </thead>';
             $sum=0;
             $count=0;
        for($i=0;$i<sizeof($_SESSION['cart']);$i++)
        {
            echo '<tr id="row-'.$allRows[$i]['id'].'">
                    <td>'.($i+1).'</td>
                    <td>'.$allRows[$i]['name'].'</td>
                    <td><input class="item-count form-control" style="width:100px;" max="20" type="number" id="count-'.$allRows[$i]['id'].'" name="item-'.$allRows[$i]['id'].'" value="1" /></td>
                    <td id="price-'.$allRows[$i]['id'].'">'.$allRows[$i]['price'].'</td>
                    <td style="width:130px;vertical-align:middle" class="text-center" ><i style="color:#dc3545" id="remove-'.$allRows[$i]['id'].'" class="fas fa-times remove-from-cart"></i></td>
                </tr>';
                $sum+=$allRows[$i]['price'];
                $count=$i+1;
                
        }
        echo '<tr style="font-weight:bold;"> 
                <td></td>
                <td id="current-total-count-full">'.$count.' item(s)</td>
                <td id="current-total-count-short">'.$count.'</td>
                <td id="current-total-price">'.$sum.'</td>
                <td><button style="font-size:90%;" id="order-btn" class="btn btn-warning"><i class="fas fa-truck-moving mr-2"></i> Order!</button></td>
            </tr>';
        echo('</table>');
    }
    else{
        echo(456);
    }
// once ordered, add 1 to popularity of each item
    ?>  
</div>
<div class="footer">
    <!-- TO DO -->
</div>
</div>


</body>

</html>