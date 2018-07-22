<?php
error_reporting(E_ALL);
include '../classes/config.php';
include '../model/BaseEntity.php';
ini_set('display_errors', 1);
include '../model/Products.php';
include '../model/Product.php';
if($_SESSION['logged'] != 1)
{
     header("Location: Login.php");   
}


$products= new Products($conn);




$counterPrice = 0;

?>
<html>
    <head></head>
    <body>
        <h1>Your Cart</h1>  <button type="button" value="home" onClick="document.location.href='home.php'">Home</button>  
<ul class="products">
         <?php foreach($_SESSION['cart'] as $pro): 
         $productData = $products->getproductsByID($pro);
         foreach($productData as $product):
         ?>

    
              <li class="productsData">
        
                  <a href="viewproduct.php?id=<?=$product->getId()?>"><img src="<?= $product->getImage()?>" width="250" height="250"></a>
            <h4><?= $product->getName()?></h4>
            <h5><?= $product->getPrice()?></h5>
            <?php $counterPrice += $product->getPrice()?>
           
            <p><?= strlen($product->getDescription())> 100 ? substr($product->getDescription(),0, 100)."...":$product->getDescription();?></p>
       
           <button class="removeBtn" value="<?=$product->getId()?>" data-price="<?=$product->getPrice()?>">Remove</button>

    </li>
           
             
        <?php
        endforeach;
        endforeach; 
        ?>
        </ul>
       Total Salary: <input type="text" value="<?=$counterPrice?>" id="priceval"/>
        <script src="jquery-3.1.1.js"></script>
         <script>
$(document).ready( function() {
   
   
    $('.removeBtn').click(function() {
        
        var ItemPrice = $(this).data('price');
     $(this).parents(".productsData").remove();        
       var priceTotal = $('#priceval').val();
        $.ajax({
            type: 'GET',
            url: 'removecart.php',
            data: {id:$(this).val()},
          success: function(result) {
             var duce = jQuery.parseJSON(result);
              var art1 = duce.success;
              if(art1 == true)
              {
                  var finPrice = priceTotal-ItemPrice;
                  $('#priceval').val(finPrice);
                  
                 
              }
            
          }

          
                        });
           
        });
        
    });
    
   
</script>
        </body>
</html>