<?php
include '../classes/config.php';
include '../model/BaseEntity.php';
include '../model/Comment.php';
include '../model/Users.php';
include '../model/User.php';
$user = new Users($conn);
$productId = $_POST['id'];
$rate = $_POST['rate'];
$comment = $_POST['comment'];
$time = date("Y-m-d H:i:s");

$commentObj = new Comment($conn);
$commentObj->setComment($comment);
$commentObj->setUserId($_SESSION['userId']);
$commentObj->setRate($rate);
$commentObj->setProduct($productId);
$commentObj->setCreatedAt($time);

$commentObj->save();

$username = $user->getUserName($commentObj->getUserId());


$output = [
    'success'  => true,
    'username' => $username,
    'date'     => $time,
    'text'     => $_POST['comment'],
    'rate'     => $rate,
];

echo json_encode($output);
 
?>