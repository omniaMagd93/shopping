<?php
include '../classes/config.php';
include '../model/BaseEntity.php';
include '../model/Products.php';
include '../model/Product.php';
if($_GET['cat'])
{
$productObj = new Products($conn);

  $products = $productObj->filter($_GET['cat']);    

//echo "<pre>";
//print_r($products);
//exit();


echo json_encode($products);  
}
?>

