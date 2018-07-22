<?php
include '../classes/config.php';
include '../model/BaseEntity.php';
include '../model/Categories.php';
include '../model/Category.php';
include '../model/Products.php';
include '../model/Product.php';

if($_SESSION['type'] == 1 && $_SESSION['logged'] == 1)
{
    
$categories= new Categories($conn);
$categoryObj = $categories->getCategories();


$products= new Products($conn);
$productData = $products->getproductsByIDV2($_GET['product']);
$productObj = new Product($conn,$productData);

$errorProductName = "";
$errorProductPrice = "";   
$errorProductDescription = "";  
$errorCategory= "";   	
$errorImage= "";
 if(isset($_GET['delpro']))
 {
    if($products->deleteProduct($_GET['delpro']))
    {
        header('Location: home.php');
    }
    
 }
 
       
if(!empty($_POST))
{
  
    // $_POST['username'] $_POST['password']
    if(!isset($_POST['productname']) || !$_POST['productname'])
    {
//error
//        die('No Username');
        $errorProductName = "No product name given<br>";
    }

    if(!isset($_POST['productprice']) || !$_POST['productprice'])
    {
//error
//        die('No Password');
        $errorProductPrice = "No product price given<br>";
    }
    
    
     if(!isset($_POST['category']) || !$_POST['category'])
    {
//error
//        die('No Password');
        $errorCategory = "No category selected<br>";
    }
   
//        if($_FILES['image']['name']==NULL)
//    {
//      $path = "images/dummy.jpg";
//    }
    
    if ($_FILES['image']['tmp_name'] != NULL) {
    
        $filename = $_FILES['image']['tmp_name'];
        $path = '/images/' . time() . '.png';
        $destination = __DIR__ . $path;
        if (!move_uploaded_file($filename, $destination)) {
 
            $productimage = "Can't Load Image";
        }
 else {
     $productObj->setImage($path);
 }
       
    }
   
    $productObj->setId($_GET['product']);
    $productObj->setName($_POST['productname']);
    $productObj->setCategory($_POST['category']);
    $productObj->setPrice($_POST['productprice']);
    $productObj->setDescription($_POST['productdesc']);
    
  
    if($errorProductName == "" && $errorProductPrice =="" && $errorProductDescription == "" && $errorCategory == "") 
    { 
       $productsObj = $productObj->updateproduct();
       header("Location: home.php");
    exit;
    }
}

 
?>
<html>
    <head></head>
    <body>
       <style>
    .error{
        color: red;
    }
</style>
<h1>Edit Product</h1>

<form method="post" enctype="multipart/form-data">
    <table>
        <tr>
            <td>Product Name:</td>
            <td><input type="text" name="productname" value="<?=$productObj->getName()?>"></td>
        </tr>
        <span style="color: red"><?=$errorProductName?></span>
        <tr>
            <td>Product Price:</td>
            <td><input type="text" name="productprice" value="<?=$productObj->getPrice()?>"></td>
        </tr>
        <span style="color: red"><?=$errorProductPrice?></span>
        <tr>
            <td>Product Description:</td>
             <td><textarea rows="4" cols="50" name="productdesc" ><?=$productObj->getDescription()?></textarea></td>
            
        </tr>
         <span style="color: red"><?=$errorProductDescription?></span>
        <tr>
            <td>Product category:</td>
            <td> 
       
                <select id="selectionCat" name="category">
                    <option value="">Choose</option>
              <?php foreach($categoryObj as $category): ?>
  <option value="<?=$category->getId()?>" <?php if($category->getId() == $productObj->getCategory()){echo "Selected";}?>><?=$category->getName()?></option>
  <?php endforeach; ?>
                 </select> 
            </td>
        </tr>
        <span style="color: red"><?=$errorCategory?></span>
        <tr>
            <td>Product Image:</td>
            <img src="<?= $productObj->getImage() ?>" width="100" height="100">
            <td><input TYPE="file" NAME="image" ></td>
            
        </tr>
        <span style="color: red"><?=$errorImage?></span>
        <tr>
            <td> <button type="submit">Submit</button></td>
    </tr>
   
    </table>
</form>
    </body>
</html>
<?php
}else{
     header('Location: account.php');
}
?>
