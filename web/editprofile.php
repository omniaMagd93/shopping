<?php
include '../classes/config.php';
include '../model/BaseEntity.php';
include '../model/User.php';

//session_start();
$errorUsername = $errorPassword = "";
if ($_SESSION['logged'] != 1) {
    header("Location: Login.php");
}
$userId = $_SESSION['userId'];

$user = new User($conn, $userId);

if (!empty($_POST)) {

 
    if (!isset($_POST['username']) || !$_POST['username']) {
     
        $errorUsername .= "This Field required.";
    } else {
        if (strlen($_POST['username']) > 20 || strlen($_POST['username']) < 5) {
            $errorUsername .= "Max Legth is 20Char AND Min Length 6";
        } else {
            //check database
        }
    }
   
    
     if(!isset($_POST['password']) || !$_POST['password'] || !isset($_POST['confirm_password']) || !$_POST['confirm_password'])
    {
        $errorPassword = "Password ANd confirm paswword is required";
    }
    else
    {
        if($_POST['password'] != $_POST['confirm_password'])
        {
            $errorPassword = "Password Not Match";
        }
    }
    

    $filename = $_FILES['fileToUpload']['tmp_name'];

    if ($filename != NULL) {

        $filePath = '/images/' . time() . '.png';
        $destination = __DIR__ . $filePath;
        if (!move_uploaded_file($filename, $destination)) {

            die('cant upload');
        }
        $user->setPhoto($filePath);
    } else {
        $user->setPhoto($user->getPhoto());
    }

    $user->setId($userId);
    $user->setUsername($_POST['username']);
    $user->setName($_POST['name']);
    $user->setEmail($_POST['email']);
   
    if($errorPassword == "" && $errorUsername == "")
    {
        echo "in set pass";
    $user->setPassword($_POST['password']);
    $user->update();

    header("Location: account.php");
    exit;
    }
}
?>
<form method="post" enctype="multipart/form-data">
    <table>
        <tr>
            <td>
    <img src="<?= $user->getPhoto() ?>" width="100" height="100">
            </td>
        </tr>
        
        <tr>  
            <td>
    Select image to upload
            </td>
            <td>
    <input type="file" name="fileToUpload" id="fileToUpload">
            </td>
    </tr>
    
    
    <tr>
        <td>Username</td>
        <td><input name="username" value="<?= $user->getUsername() ?>" /></td>
    </tr>
 
    
    <td><span style="color: red"><?php echo $errorUsername ?></span></td>
    
    <tr>
        <td>Email</td>
        <td><input name="email" value="<?= $user->getEmail() ?>" /></td>
    </tr>
    
  
    <tr>
        <td>Name</td>
        <td> <input name="name" value="<?= $user->getName() ?>" /></td>
    </tr>
   
    <tr>
        <td>Password</td>
        <td>  <input name="password" type="password" /></td>
    </tr>
    
       <tr>
        <td> Confirm Password:</td>
        <td> <input name="confirm_password" type="password" /></td>
    </tr>
   
 
    <td><span style="color: red"><?php echo $errorPassword ?></span></td>
    
    </table>
    <button type="submit">Update</button>
</form>