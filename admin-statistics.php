
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.js"></script>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/index.js"></script>
<body>

<div class="container full-page">
    <!-- navbar-expand-lg means it will show the items when its lg and collapse when < -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <a class="navbar-brand" href="index.php"><i class="fas fa-shopping-bag mr-2"></i>WeShop</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
    <span class="navbar-toggler-icon"></span>
</button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home</a>
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
                                    <a class="dropdown-item active" href="admin-statistics.php"><i class="far fa-chart-bar mr-3" style="width:20px" ></i>Statistics</a>
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

<?php
// get the data for popularity on different categories and then print them onto the page
$sql = "SELECT type type, sum(popularity) popSum FROM `all_products` GROUP BY type";
$query=$conn->prepare($sql);
$query->execute();
$allRows = $query->fetchAll(PDO::FETCH_ASSOC);
echo('<div id="popularity-data-container" style="display:none;">');
foreach ($allRows as $row)
{
    echo('<div class="category-count">'.$row['type'].';'. $row['popSum'].'</div>');
}
echo('</div>');
//write the number of users:
$sql = "SELECT * FROM `users_basic_info`";
$query=$conn->prepare($sql);
$query->execute();
$allRows = $query->fetchAll(PDO::FETCH_ASSOC);
echo('<div id="users-count-container" style="display:none;">');
echo(count($allRows));
echo('</div>');
//write the number of products
$sql = "SELECT * FROM `all_products`";
$query=$conn->prepare($sql);
$query->execute();
$allRows = $query->fetchAll(PDO::FETCH_ASSOC);
echo('<div id="products-count-container" style="display:none;">');
echo(count($allRows));
echo('</div>');
//write the most popular product:
$sql = "SELECT name name,max(popularity) count FROM `all_products` WHERE 1";
$query=$conn->prepare($sql);
$query->execute();
$allRows = $query->fetchAll(PDO::FETCH_ASSOC);
echo('<div id="most-popular-product-container" style="display:none;">');
echo(($allRows[0]['name']));
echo('</div>');
//write the top 10 most popular products
$sql = "SELECT name name, popularity pop FROM `all_products` ORDER BY popularity DESC LIMIT 10";
$query=$conn->prepare($sql);
$query->execute();
$allRows = $query->fetchAll(PDO::FETCH_ASSOC);
echo('<div id="10-most-popular-container" style="display:none;">');
foreach($allRows as $row)
{
    echo('<div class="product-popularity">'.$row['name'].';'. $row['pop'].'</div>');
}
echo('</div>');
?>
<div class="heading h3 text-center my-3 ">Statistics:</div>
<div class="buttons-wrapper text-center mx-auto">
    <button class="btn btn-primary btn-chart-1 mx-2 mb-4">Popularity by category</button>
    <button class="btn btn-primary btn-general mx-2 mb-4">General</button>
    <button class="btn btn-primary btn-chart-2 mx-2 mb-4">Popularity by product</button>
</div>
<div class="statistics-wrapper">


<div id="chart-1-holder"  style="width: 50%; margin: 0 auto;display:none;">
    <div class="chart-1-title h4 text-center">Popularity by category:</div>
    <canvas id="myChart" style="display: block; height: 206px; width: 413px;" width="473" height="236" class="chartjs-render-monitor;display: inline;"></canvas>
</div>
<div id="chart-2-holder"  style="width: 50%; margin: 0 auto;display:none;">
    <div class="chart-1-title h4 text-center">Popularity by item:</div>
    <canvas id="myChart2" style="display: block; height: 206px; width: 413px;" width="473" height="236" class="chartjs-render-monitor;display: inline;"></canvas>
</div>

<div class="general-holder" style="display:none;">
    <div class="chart-1-title h4 text-center">General statistics:</div>
    <table class="table table-hover">
    <thead class="thead-dark">
        <tr>
            <th>Name</th>
            <th>Info</th>
        </tr>
    </thead>
        <tr>
            <td>Number of users</td>
            <td id="table-number-of-users">Info</td>
        </tr>
        <tr>
            <td>Number of products</td>
            <td id="table-number-of-products">Info</td>
        </tr>
        <tr>
            <td>Most popular product</td>
            <td id="table-most-popular-product">Info</td>
        </tr>
    </table>
</div>
<script>

        var productArray = [];
        var popularityArray =[];
        var len = $("#10-most-popular-container")[0]['childNodes'].length;
        
        for (var i=0;i<len;i++)
        {
            var currentProduct = $("#10-most-popular-container")[0]['childNodes'][i].innerHTML.split(';');
            productArray.push(currentProduct[0]);
            popularityArray.push(currentProduct[1]);
        }
        productArray=productArray.reverse();
        popularityArray=popularityArray.reverse();
		var color = Chart.helpers.color;
		var barChartData = {
			labels: [productArray[0],productArray[1],productArray[2],productArray[3],productArray[4],
            productArray[5],productArray[6],productArray[7],productArray[8],productArray[9]],
			datasets: [{
				label: 'Products',
				backgroundColor: 'rgba(255, 99, 132)',
				borderColor: 'rgba(255, 99, 132)',
				borderWidth: 1,
				data: [
					popularityArray[0],popularityArray[1],popularityArray[2],popularityArray[3],popularityArray[4],popularityArray[5],
                    popularityArray[6],popularityArray[7],popularityArray[8],popularityArray[9]
				]
			}]

		};

function getPopularityByCategoryChart()
{
    var ctx = document.getElementById("myChart").getContext('2d');
    //get the data into the chart from the page
    var categoryCount = $(".category-count").length;
    var categories=[];
    var popularityScores=[];
    var count =0;
    for(var i=0;i<categoryCount;i++)
    {
        
        var catAndCount=$(".category-count")[i].innerHTML.split(';');
        categories.push(catAndCount[0]);
        popularityScores.push(catAndCount[1]);
        count++;
    }
    switch(count)
    {
        case 3:
        var myChart = new Chart(ctx, {
            type: 'pie',
        data: {
                labels: [categories[0],categories[1],categories[2]],
                datasets: [{
                    label: 'Popularity by category',
                    data: [popularityScores[0],popularityScores[1],popularityScores[2]],
                    backgroundColor: [
                        'rgba(255, 99, 132)',
                        'rgba(54, 162, 235)',
                        'rgba(255, 206, 86)'
                    ],
                    borderWidth: 1,
                    

                }]
            },
            options: {}
        });
        break;
        case 4:
        var myChart = new Chart(ctx, {
            type: 'pie',
        data: {
                labels: [categories[0].charAt(0).toUpperCase()+categories[0].slice(1),
                categories[1].charAt(0).toUpperCase()+categories[1].slice(1),categories[2].charAt(0).toUpperCase()+categories[2].slice(1),
                categories[3].charAt(0).toUpperCase()+categories[3].slice(1)],
                datasets: [{
                    label: 'Popularity by category',
                    data: [popularityScores[0],popularityScores[1],popularityScores[2],popularityScores[3]],
                    backgroundColor: [
                        'rgba(255, 99, 132)',
                        'rgba(54, 162, 235)',
                        'rgba(255, 206, 86)',
                        'rgba(75, 192, 192)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {}
        });
        break;
        case 5:
        var myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: [categories[0],categories[1],categories[2],categories[3],categories[4]],
                datasets: [{
                    label: 'Popularity by category',
                    data: [popularityScores[0],popularityScores[1],popularityScores[2],popularityScores[3],popularityScores[4]],
                    backgroundColor: [
                        'rgba(255, 99, 132)',
                        'rgba(54, 162, 235)',
                        'rgba(255, 206, 86)',
                        'rgba(75, 192, 192)',
                        'rgba(153, 102, 255)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {}
        });
            break;

        default:
        var myChart = new Chart(ctx, {
            type: 'pie',
        data: {
                labels: [categories[0],categories[1],categories[2],categories[3],categories[4],categories[5]],
                datasets: [{
                    label: 'Popularity by category',
                    data: [popularityScores[0],popularityScores[1],popularityScores[2],popularityScores[3],popularityScores[4],popularityScores[5]],
                    backgroundColor: [
                        'rgba(255, 99, 132)',
                        'rgba(54, 162, 235)',
                        'rgba(255, 206, 86)',
                        'rgba(75, 192, 192)',
                        'rgba(153, 102, 255)',
                        'rgba(255, 159, 64)'
                    ],
                    borderWidth: 1
                }]
            },
            options: { }
        });
            break;
    }
}
function getNumberOfUsers()
    {
        return parseInt($("#users-count-container")[0].innerHTML);
    }
function getNumberOfProducts()
    {
        return parseInt($("#products-count-container")[0].innerHTML);
    }
    function getMostPopularProduct()
    {
        return $("#most-popular-product-container")[0].innerHTML;
    }
$(document).on("click",".btn-chart-1",function()
{
    //show div or hide div
   
    if($("#chart-1-holder").css('display')=='none')
    {
        //show chart
        $("#chart-1-holder").css('display','block');
        //hide everything else 
        $(".general-holder").css('display','none');
        $("#chart-2-holder").css('display','none');
    }
    

    //show chart
    getPopularityByCategoryChart();
})
$(document).on("click",".btn-general",function()
{
    //show div or hide div
    if($(".general-holder").css('display')=='none')
    {
        //show chart
        $(".general-holder").css('display','block');
        //fill in data
        $("#table-number-of-users")[0].innerHTML=getNumberOfUsers();
        $("#table-number-of-products")[0].innerHTML=getNumberOfProducts();
        $("#table-most-popular-product")[0].innerHTML=getMostPopularProduct();
        //hide everything else 
        $("#chart-1-holder").css('display','none');
        $("#chart-2-holder").css('display','none');
    }
    //show stats
    
})
$(document).on("click",".btn-chart-2",function()
{
    if($("#chart-2-holder").css('display')=='none')
    {
        //show chart
        $("#chart-2-holder").css('display','block');
        //hide everything else 
        $(".general-holder").css('display','none');
        $("#chart-1-holder").css('display','none');
    }
    
    var ctx = document.getElementById('myChart2').getContext('2d');
			window.myBar = new Chart(ctx, {
				type: 'bar',
				data: barChartData,
				options: {
					responsive: true,
					legend: {
						position: 'top',
					},
					
				}
			});
})

</script>

</div>

<?php
    include 'footer.php';
    ?>
</div>
    

</body>

</html>