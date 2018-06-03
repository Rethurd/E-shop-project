<?php
require 'connection.php';
$search = $_POST['search'];
$order = $_POST['order'];

if(strtolower($order)=='price')
{
  $sql = "SELECT id id, name nm, description descr, image img, price price, manufacturer manu, warranty warr, type type, model model,
   additional_info info FROM `all_products` WHERE description LIKE '%${search}%' OR name LIKE '%${search}%' OR manufacturer LIKE '%${search}%'
   OR model LIKE '%${search}%' ORDER BY ${order} ASC";

}
else{
    $sql = "SELECT id id, name nm, description descr, image img, price price, manufacturer manu, warranty warr, type type, model model,
    additional_info info FROM `all_products` WHERE description LIKE '%${search}%' OR name LIKE '%${search}%' OR manufacturer LIKE '%${search}%'
    OR model LIKE '%${search}%' ORDER BY ${order} DESC";
}
$query=$conn->prepare($sql);
$query->execute();
$allRows = $query->fetchAll(PDO::FETCH_ASSOC);
            foreach ($allRows as $row) {
              if($row['img']==NULL)
              {
                $image='data:image/png;base64,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
                ';
              }
              else{
                $image='data:image/png;base64,'.$row['img'];
                
              }
                echo 
                ' <div class="product card  " id="'.strtolower($row['type']).'-'.$row['id'].'"> 
                    <div class="h5 product-name text-center my-1">'.$row['nm'].'</div>
                    <div class="product-info row mt-1 container">
                      <div class="col-lg-3 col-sm-4">
                      <img class="rounded product-image" src='.$image.'>
                      </div>
                      <div class="col-lg-6 col-sm-8 text-sm-center text-left">
                        <div style="font-weight:bold">Description:</div>
                        <div class="product-description mt-2">'.$row['descr'].'</div>  
                      </div>
                      <div class="col-lg-3 col-sm-12 text-center" >
                        <div style="font-weight:bold">Price:</div>
                        <div class="mt-2">'.$row['price'].'</div>  
                        <div class="mt-3"><button id="btn-'.strtolower($row['type']).'-'.$row['id'].'" class="btn btn-warning"><i class="fas fa-shopping-cart mr-2"></i>Add to cart </button></div>
                      </div>
                    </div>
                      <div class="row container">
                        <div id="show-more-'.$row['id'].'" class="show-info ml-auto col-sm-12 col-md-offset-9 col-md-3 text-center"  ><a href="#"><i class="fas fa-angle-down mr-2"></i> Show more</a> </div>
                      </div>
                      <div class="toggle-info ml-3" id="more-info-'.$row['id'].'" style="visibility:hidden;max-height:0px">
                        <div ><b>Manufacturer: </b>'.$row['manu'].'</div>
                        <div ><b>Warranty:</b> '.$row['warr'].'</div>
                        <div ><b>Type:</b> '.$row['type'].'</div>
                        <div "><b>Model:</b> '.$row['model'].'</div>
                        <div "><b>Additional information:</b></div>
                        <div>'.$row['info'].'</div>
                   </div>
                   <div class="row container">
                   <div id="show-less-'.$row['id'].'" class="hide-info ml-auto  col-sm-12 col-md-offset-9 col-md-3 text-center mb-1" style="visibility:hidden;max-height:0px;"  ><a href="#"><i class="fas fa-angle-up mr-2"></i> Show less</a> </div>
                 </div>
                  </div>';
              }



//<img src="data:image/png;base64,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">
?>