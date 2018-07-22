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

$productObj = new Product($conn);

$errorProductName= "";
$errorProductPrice= "";
$errorProductDescription= "";
$errorCategory = "";
$errorImage = "";

if(!empty($_POST))
{
   
   
    if(!isset($_POST['productname']) || !$_POST['productname'])
    {
        //die('product name');
        $errorProductName = "No product name given<br>";
    }

    if(!isset($_POST['productprice']) || !$_POST['productprice'])
    {
         //die('No product price');
        $errorProductPrice = "No product price given<br>";
    }
   
    
     if(!isset($_POST['category']) || !$_POST['category'])
    {

        $errorCategory = "No category selected<br>";
    }
   
    
   
     if($_FILES['image']['name']==NULL)
    {
      $path = "images/dummy.jpg";
    }
    
    if ($_FILES['image']['tmp_name'] != NULL) {
    
        $filename = $_FILES['image']['tmp_name'];
        $path = '/images/' . time() . '.png';
        $destination = __DIR__ . $path;
        if (!move_uploaded_file($filename, $destination)) {
 
            $errorImage = "Can't Load Image";
//            die('cant upload');
        }
       
     else {
        //echo  $path;
    }
    }

   
    $productObj->setName($_POST['productname']);
    $productObj->setCategory($_POST['category']);
    $productObj->setPrice($_POST['productprice']);
    $productObj->setDescription($_POST['productdesc']);
    $productObj->setImage($path);


    if($errorProductName == "" && $errorProductPrice =="" && $errorProductDescription == "" && $errorCategory == "") 
    { 
       if($productObj->insertProduct())
       {
           header("Location: home.php"); 
       }
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
<h1>Add Product</h1>

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
            <td><textarea rows="4" cols="50" name="productdesc" >
               <?=$productObj->getDescription()?>  </textarea></td>
            
        </tr>
        <span style="color: red"><?=$errorProductDescription?></span>
        <tr>
            <td>Product category:</td>
            <td> <select id="selectionCat" name="category">
                    <option value="">choose</option>
              <?php foreach($categoryObj as $category): ?>
  <option value="<?=$category->getId()?>"<?php if($productObj->getCategory() == $category->getId()){echo "selected";} ?>><?=$category->getName()?></option>
  <?php endforeach; ?>
</select>
            </td>
            <span style="color: red"><?=$errorCategory?></span>

        </tr>
        
        <tr>
            <td>Product Image:</td>
            <td><input TYPE="file" NAME="image"></td>
        </tr>
        <?=$errorImage;?>
        <tr>
            <td> <button type="submit">Submit</button></td>
    </tr>
  
    </table>
</form>
    </body>
</html>
<?php } else {
    header('Location: account.php');
}
?>