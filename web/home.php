<?php
include '../classes/config.php';
include '../model/BaseEntity.php';
include '../model/Products.php';
include '../model/Product.php';
include '../model/Categories.php';
include '../model/Category.php';


$products = new Products($conn);
$productsObj = $products->getProducts();

$categories = new Categories($conn);
$categoryObj = $categories->getCategories();

//print_r($_SESSION['username']);
?>
<html>
    <head>
        <style>
            ul.products li {
                width: 200px;
                display: inline-block;
                vertical-align: top;
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
        <h1>Shopping Now</h1>
        <input type="text" placeholder="search for user" id="searchProduct"/>

        <select id="selectionCat">
            <option value="no">choose</option>
            <?php foreach ($categoryObj as $category): ?>
                <option value="<?= $category->getId() ?>"><?= $category->getName() ?></option>
            <?php endforeach; ?>
        </select> 
        <?php if(isset($_SESSION["logged"]) && $_SESSION["logged"] == 1){?>
        <button type="button" value="cart" onClick="document.location.href='checkout.php'">Your Cart</button>
        <button type="button" value="account" onClick="document.location.href='account.php'">Profile</button>
        <?php }?>
        <ul class="products">
<?php foreach ($productsObj as $product): ?>
                <li>

                    <a href="viewproduct.php?id=<?= $product->getId() ?>"><img src="<?= $product->getImage() ?>" width="100" height="100"></a>
                    <h4><?= $product->getName() ?></h4>
                    <h5><?= $product->getPrice() ?></h5>
                    <p><?= strlen($product->getDescription()) > 100 ? substr($product->getDescription(), 0, 100) . "..." : $product->getDescription(); ?></p>
                 
 <?php
                    if (isset($_SESSION['logged']) && $_SESSION['logged'] == 1) {
                        if ($_SESSION['type'] == 1) {
                            ?>  
                            <button class="EditBtn" onclick="return editProduct(<?= $product->getId() ?>);" >Edit</button>
                            <button class="DeletetBtn" onclick="return deleteProduct(<?= $product->getId() ?>);" >Delete</button>
                           <button  class="cartBtn"  value="<?= $product->getId() ?>">Add To Cart</button>
                             <?php
                        } else {
                           ?>
                                <button  class="cartBtn"  value="<?= $product->getId() ?>">Add To Cart</button>
                            <?php
                            }
                            ?>                      
                                <br>
                                <br>
                               

                                <br>
                           <?php
                        }
                    
                    ?>


                </li>
<?php
            endforeach;
            ?>
            </ul>
         <?php
          
            if (isset($_SESSION['logged'])) {
                ?>
            <button onclick="return confirmLogout();">logout</button>
            <?php if ($_SESSION['type'] == 1) { ?>  
                <button class="EditBtn" onclick="return addProduct();" >Add Product</button>
    <?php }
} else {
    ?>
            <p>
                <a href="Login.php" value="login">Login</a>
                <a href="register.php" value="register">Register</a>
            </p>
<?php } ?>
        <script src="jquery-3.1.1.js"></script>
        <script>
                    function deleteProduct(id)
                    {
                        if (confirm("Are you sure you want to Delete this product?")) {
                            window.location = "editProduct.php?delpro=" + id;
                        }
                    }

                    function confirmLogout() {
                        if (confirm("Are you sure you want to Logout")) {
                            window.location = "logout.php"
                        }
                    }

                    function editProduct(id)
                    {
                        window.location = "editProduct.php?product=" + id;
                    }

                    function addProduct()
                    {
                        window.location = "addProduct.php";
                    }
                    $(document).ready(function () {


                        $('#selectionCat').on('change',function () {

                            $.ajax({
                                type: 'GET',
                                url: 'categorysearch.php',
                                data: {cat: $(this).val()},
                                dataType: 'json',
                                cache: false,

                                success: function (result) {
                                    $("li").remove();
                                    result.forEach(function (data) {
                                        var str = data.sp_description;
                                        if (str.length > 100)
                                            str = str.substring(0, 100);
                                        $('.products').prepend('<li><img src=' + data.sp_image + ' width="100" height="100"><h4>' + data.sp_name + '</h4><p>' + data.sp_price + '</p><p>' + str + '</p></li>')

                                    });

                                }

                            });
                        });

                        $('.cartBtn').click(function () {
                            $(this).text("Added");
                            $(this).attr('disabled', 'disabled');
                            $.ajax({
                                type: 'GET',
                                url: 'cart.php',
                                data: {id: $(this).val()},

                            });

                        });
                        
                        $('.addcomment').click(function () {
                        var product = $(this).val();
                        var rate = $("#rate").val(); 
                        var comment = $("#comment").val();
                        
//                        console.log(product);
//                        console.log(rate);
//                        console.log(comment);
                          $.ajax({
                                type: 'POST',
                                url: 'comment.php',
                                data: 
                               {
                                   id: product,
                                   rate: rate,
                                   comment: comment,
                               },

                            });
                       
                        });


                    });


        </script>
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

        <script src="/js/search.js"></script>
    </body>
</html>