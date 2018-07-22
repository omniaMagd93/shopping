<?php
include '../classes/config.php';
include '../model/BaseEntity.php';

if($_GET['id'])
{
   
if(array_push($_SESSION['cart'],$_GET['id']))
{
    echo "1";
}



}
?>