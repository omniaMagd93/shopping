<?php

include '../classes/config.php';
include '../model/BaseEntity.php';
include '../model/Product.php';
include '../model/Products.php';

$productObj = new Products($conn);
$products = $productObj->search($_GET['term']);

//echo "<pre>";
//print_r($products);
//die();
$return = array();
foreach($products as $product){
    $return[] = array('label' => $product->getName(), 'value' => $product->getId());
}

echo json_encode($return);

