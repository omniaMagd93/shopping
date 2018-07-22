<?php
include '../classes/config.php';
include '../model/BaseEntity.php';
include '../model/User.php';

if($_SESSION['logged'] != 1)
{
  header("Location: Login.php");  
}
else
{
//session_start();
if(!isset($_SESSION['userId']) || !$_SESSION['userId'])
{
    header("Location: Login.php");
    exit;
}
$userId = $_SESSION['userId'];

if(isset($_GET['id']) && $_GET['id'])
{
    $userId = $_GET['id'];
}

$user = new User($conn, $userId);

?>

<h1><?= $user->getUsername()?> Profile</h1>
<img src="<?= $user->getPhoto() ?>" width="100" height="100" />
<h3>Name: <?= $user->getName() ?></h3>
<h3>Username: <?= $user->getUsername()?></h3>
<h3>Email: <?= $user->getEmail() ?></h3>
<?php if($userId == $_SESSION['userId']): ?>
    <h3><a href="editprofile.php">Edit Ptofile</a></h3>
    <button type="button" value="home" onClick="document.location.href='home.php'">Home</button>
<?php endif; ?>
<?php } ?>