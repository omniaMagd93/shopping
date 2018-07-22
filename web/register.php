<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include '../classes/config.php';
include '../model/BaseEntity.php';
include '../model/User.php';

$user = new User($conn);
$errorUsername = $errorPassword = $errorImage= "";
if(!empty($_POST))
{
    if(!isset($_POST['username']) || !$_POST['username'])
    {
        $errorUsername .= "This Field required.";
    }
    else
    {
        if(strlen($_POST['username']) > 20 || strlen($_POST['username']) < 5)
        {
            $errorUsername .= "Max Legth is 20Char AND Min Length 6";
        }
        else
        {
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
    
    
    
   //////////////////////////////////////////
         if($_FILES['image']['name']==NULL)
    {
         echo "in no image";
      $path = "images/nouser.png";
    }
    
    if($_FILES['image']['name']==NULL)
    {
      $path = "images/nouser.jpg";
    }
    
    if ($_FILES['image']['tmp_name'] != NULL) {
    
        $filename = $_FILES['image']['tmp_name'];
        $path = '/images/' . time() . '.png';
        $destination = __DIR__ . $path;
        if (!move_uploaded_file($filename, $destination)) {
 
            $errorImage = "Can't Load Image";
//            die('cant upload');
        }
       
    } else {
        //echo  $path;
    }
       $user->setUsername($_POST['username']);
       $user->setEmail($_POST['email']);
    
    if($errorPassword == "" && $errorUsername == "")
    { 
        $user->setPhoto($path);
        $_SESSION['userId'] = $user->save();
        $_SESSION['username'] = $user->getUsername();
        $_SESSION['logged'] = 1;
        $_SESSION['type'] = $user->getType();
        $_SESSION['cart'] = array(); 
        
        header('Location: account.php');
        
    }
    ////////////////////////////////////////// 
}
?>
<html>
    <head>

    </head>
    <body>
        <h1>Registration </h1>
        <form method="post" enctype="multipart/form-data">
            <table>
                <tr>
                    <td>Username:</td>
                    <td><input name="username" type="text"  value="<?=$user->getUsername()?>"/></td>
                </tr>
            
            <span style="color: red"> <?php echo $errorUsername ?></span>
              <tr>
                    <td>Email:</td>
                    <td><input name="email" type="email" value="<?=$user->getEmail()?>"/></td>
              </tr>
          
              <tr>
                    <td>Password:</td>
                    <td><input name="password" type="password" /></td>
              </tr>
            
              <tr>
                    <td>Confirm Password:</td>
                    <td><input name="confirm_password" type="password" /></td>
              </tr>
           
            
            <span style="color: red"><?php echo $errorPassword ?></span>
          
             <tr>
                    <td>Image:</td>
                    <td><input TYPE="file" NAME="image"></td>
              </tr>
           
            
            </table>
            <button type="submit">Register</button>
        </form>
    </body>
</html>
