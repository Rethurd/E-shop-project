var _resultsPerPage=3,numberOfPages=0,tableToQuery="";lastQueried="",justSearched=!1,justLookedByCategory=!1,lastQueriedSearch="",$(document).ready(function(){function t(e,s){s=s||"price",$.ajax({url:"load-products.php",method:"POST",data:{table:e,order:s},dataType:"html"}).done(function(e){"price"==s&&$("#order-by").val($("#order-by option:first").val()),$("#search-results").empty(),$(".pagination").empty(),$("#search-results").append(e);var t=$("#search-results").children().length;numberOfPages=Math.ceil(t/_resultsPerPage),$("#search-results .product:gt("+(_resultsPerPage-1)+")").hide(),$(".pagination").append('<li class="previous-item"><a class="page-link" href="#">Previous</a></li>');for(var a=1;a<numberOfPages+1;a++)$(".pagination").append('<li class="page-item"><a class="page-link" href="#">'+a+"</a></li>"),1==a&&$(".page-item").addClass("active");$(".pagination").append('<li class="next-item"><a class="page-link" href="#">Next</a></li>')})}function a(e){$(".page-item").removeClass("active"),$(".pagination li:nth-child("+(e+1)+")").addClass("active");var t=e*_resultsPerPage-_resultsPerPage,a=e*_resultsPerPage-1;$("#search-results .product:lt("+(a+1)+")").show(),$("#search-results .product:gt("+a+")").hide(),$("#search-results .product:lt("+t+")").hide()}function s(e,s){s=s||"price",$.ajax({url:"search-products.php",method:"POST",data:{search:e,order:s},dataType:"html"}).done(function(e){"price"==s&&$("#order-by").val($("#order-by option:first").val()),$("#search-results").empty(),$(".pagination").empty(),$("#search-results").append(e);var t=$("#search-results").children().length;numberOfPages=Math.ceil(t/_resultsPerPage),$("#search-results .product:gt("+(_resultsPerPage-1)+")").hide(),$(".pagination").append('<li class="previous-item"><a class="page-link" href="#">Previous</a></li>');for(var a=1;a<numberOfPages+1;a++)$(".pagination").append('<li class="page-item"><a class="page-link" href="#">'+a+"</a></li>"),1==a&&$(".page-item").addClass("active");$(".pagination").append('<li class="next-item"><a class="page-link" href="#">Next</a></li>')})}$(".category").on("click",function(){var e=$(this).attr("id").replace("cat-","");lastQueried=e,console.log(lastQueried),justLookedByCategory=!0,justSearched=!1,t(e)}),$("#order-by").on("change",function(){var e=$(this).val();justLookedByCategory?t(lastQueried,e):justSearched&&s(lastQueriedSearch,e)}),$(document).on("click",".page-item",function(){idx=$(this).index(),a(idx)}),$(document).on("click",".previous-item",function(){var e=$("li.active").index();1!=e&&a(e-1)}),$(document).on("click",".next-item",function(){var e=$("li.active").index();e!=numberOfPages&&a(e+1)}),$(document).on("click",".show-info",function(){var e=$(this)[0].id.split("-")[2],t="more-info-"+e;$("#"+t).css("visibility","visible"),$("#"+t).css("max-height","500px"),$(this).css("visibility","hidden"),$(this).css("max-height","0"),$("#show-less-"+e).css("visibility","visible"),$("#show-less-"+e).css("max-height","50px")}),$(document).on("click",".hide-info",function(){var e=$(this)[0].id.split("-")[2];console.log(e);var t="more-info-"+e;$("#"+t).css("visibility","hidden"),$("#"+t).css("max-height","0px"),$(this).css("visibility","hidden"),$(this).css("max-height","0px"),$("#show-more-"+e).css("visibility","visible"),$("#show-more-"+e).css("max-height","50px")}),$("#input-search").on("keypress",function(e){justLookedByCategory=!1,justSearched=!0,13==e.keyCode&&(lastQueriedSearch=$(this).val(),s($(this).val()))}),$("#search-icon").on("click",function(){justLookedByCategory=!1,justSearched=!0,lastQueriedSearch=$("#input-search").val(),s($("#input-search").val())})}),$(document).on("click",".btn-warning",function(){addItemArray=$(this).attr("id").split("-");var e=addItemArray.length;addItemId=$(this).attr("id").split("-")[e-1],console.log(addItemId),sweetAlert({title:"Add to cart?",className:"swal-footer",icon:"info",buttons:{btn1:{text:"Cancel",className:["swal-cancel-btn","btn-danger"]},btn2:{text:"Add & continue",className:["swal-continue-btn","btn-success"]},btn3:{text:"Add & cart",className:["swal-cart-btn","btn-success"]}}})}),$(document).on("click",".swal-continue-btn",function(){$.ajax({url:"add-to-cart.php",method:"POST",data:{item:addItemId},dataType:"html"}).done(function(e){})}),$(document).on("click",".swal-cart-btn",function(){$.ajax({url:"add-to-cart.php",method:"POST",data:{item:addItemId},dataType:"html"}).done(function(e){window.location="my-cart.php"})});