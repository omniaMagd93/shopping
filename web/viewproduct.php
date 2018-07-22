<?php
include '../classes/config.php';
include '../model/BaseEntity.php';
include '../model/Products.php';
include '../model/Product.php';
include '../model/Categories.php';
include '../model/Category.php';
include '../model/User.php';
include '../model/Comment.php';
include '../model/Comments.php';


       $products= new Products($conn);
       $productsObj = $products->getproductsByID($_GET['id']);
       
       $categories= new Categories($conn);
       $categoryObj = $categories->getCategories();
       
       $comments = new Comments($conn);
       $commentsObj = $comments->getComments($_GET['id']);
?>
<html>
    <head>
        <style>
           ul.products li {
    width: 200px;
    display: inline-block;
    vertical-align: top;
}
            .comment{
                border: 1px solid black;
            }
    
        </style>
          <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="/resources/demos/style.css">
          <style>
            .ui-autocomplete-loading {
                background: white url("images/ui-anim_basic_16x16.gif") right center no-repeat;
            }
        </style>
        <title>Shooping now</title>
    </head>
    
    <body>
        <h1>Product View</h1>
        
        <ul class="products">
         <?php foreach($productsObj as $product): ?>
        
           
              <li>
        
                  <a href="viewproduct.php?id=<?=$product->getId()?>"><img src="<?= $product->getImage()?>" width="200" height="300"></a>
            <h4><?= $product->getName()?></h4>
            <h5><?= $product->getPrice()?></h5>
            <p><?= $product->getDescription();?></p>
          
       <?php if(isset($_SESSION["logged"]) && $_SESSION["logged"] ==1 ){
          
         if ($_SESSION['type'] == 1) {
                            ?>  
                            <button class="EditBtn" onclick="return editProduct(<?= $product->getId() ?>);" >Edit</button>
                            <button class="DeletetBtn" onclick="return deleteProduct(<?= $product->getId() ?>);" >Delete</button>
                           <button  class="cartBtn"  value="<?= $product->getId() ?>">Add To Cart</button>
 <?php
                        } else {
                           ?>
                                <button  class="cartBtn"  value="<?= $product->getId() ?>">Add To Cart</button>
                                <br>
                                <br>
                            <?php
                            } ?>
             <div>         
  Rate: <input type="number"value="1" id="rate" name="quantity" min="1" max="5">
  comment:<textarea id="comment" rows="4" cols="50" name="productdesc" > </textarea>
  <button class="addcomment" value="<?=$product->getId()?>">Add</button>
          </div>
    </li>
           
        <?php
        $count = 0;
        $ratesSum = 0;
        foreach($commentsObj as $comment): 
        $count++;
        $ratesSum += $comment->getRate();
        endforeach;
        
        if($count !=0)
        {
        $finRate = $ratesSum / $count;
        }
 else {
     $finRate = 0;
 }
        ?>
        <input type="hidden" id="sumsRate" value="<?=$ratesSum?>"/>
        <input type="hidden" id="countsRate" value="<?=$count?>"/>
        <div> Rate is: <input type="text"value="<?=$finRate?>" id="totalRate"/></div>
        
         <div id="commentsDiv">
            <?php foreach($commentsObj as $comment): ?>
             
                <div class="comment">
                    <h3><?= $comment->getUserId()->getUsername()?></h3>
                    <h5><?= $comment->getComment() ?></h5>
                    <h6><?= $comment->getCreatedAt() ?></h6>
    
                </div>
            <?php endforeach; ?>
        </div>             
       <?php }endforeach; ?>
        </ul>

        
        <script src="jquery-3.1.1.js"></script>
     <script>
$(document).ready( function() {
    $('#selectionCat').change(function() {
      
        $.ajax({
            type: 'GET',
            url: 'categorysearch.php',
            data: {cat:$(this).val()},
            dataType: 'json',
            cache: false,
            
            success: function(result) {
           $("li").remove(); 
        result.forEach(function(data) {
            var str = data.sp_description;
         if(str.length > 5) str = str.substring(0,5);
          $('.products').prepend('<li><img src='+data.sp_image+'><h4>'+data.sp_name+'</h4><p>'+data.sp_price+'</p><p>'+str+'</p></li>') 
     
});  
          
                        }
           
        });
    });
    
    $('.cartBtn').click(function() {
     $(this).text("Added");
                            $(this).attr('disabled', 'disabled');
        $.ajax({
            type: 'GET',
            url: 'cart.php',
            data: {id:$(this).val()},
          

          
                        });
           
        });
      $('.addcomment').click(function () {
                        var product = $(this).val();
                        var rate = parseInt($("#rate").val()); 
                        var comment = $("#comment").val();
                        
//                        console.log(product);
//                        console.log(rate);
//                        console.log(comment);
                      var countRate = parseInt($('#countsRate').val());
                      console.log(countRate)
                      var finalcountRate = parseInt(countRate + 1);
                      console.log(finalcountRate);
                      
                      var totalrate = parseInt($('#sumsRate').val());
                      console.log(totalrate);
                      
                      var Finaltotalrate = parseInt(totalrate +rate);
                      console.log(Finaltotalrate);
                      
                      var RateFin = parseFloat(Finaltotalrate / finalcountRate);
                      
                      $("#countsRate").val(finalcountRate);
                      $('#totalRate').val(RateFin);
                          $.ajax({
                                type: 'POST',
                                url: 'comment.php',
                                data: 
                               {
                                   id: product,
                                   rate: rate,
                                   comment: comment,
                               },
                                dataType: 'json',
            cache: false,
                                  success: function (response) {
                console.log(response);
                if (response.success == true) {
                  
                    $('#commentsDiv').prepend('<div class="comment"><h3>' + response.username + '</h3><h5>' + response.text + '</h5><h6>' + response.date + '</h6></<div>')
                }
            }

                            });
                       
                        });   
    });
    
   
</script>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

        <script src="/js/search.js"></script>
    </body>
</html>