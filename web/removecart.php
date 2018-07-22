<?php
include '../classes/config.php';
include '../model/BaseEntity.php';

if($_GET['id'])
{
$item = array($_GET['id']);
//$_SESSION['cart'] = array_diff($_SESSION['cart'], $item);
array_splice($_SESSION['cart'], array_search($item, $_SESSION['cart']), 1);

$output = array(
    'success'  => true,
  
);


}

echo json_encode($output);

?>

