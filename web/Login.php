<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include '../classes/config.php';
include '../model/BaseEntity.php';
include '../model/User.php';
include '../model/Users.php';
$error = "";
$UsersObj = new Users($conn);

if(!empty($_POST))
{
    // $_POST['username'] $_POST['password']
    if(!isset($_POST['username']) || !$_POST['username'])
    {
//error
//        die('No Username');
        $error .= "No Username given<br>";
    }

    if(!isset($_POST['password']) || !$_POST['password'])
    {
//error
//        die('No Password');
        $error .= "No Password given<br>";
    }

    //Success $_POST['username'] $_POST['password']
    if($error == "")
    {
        $loggedIn = false;
        $result = $UsersObj->getUser($_POST['password'], $_POST['username'] );
         
       if($result != NULL)
       {
              
            foreach($result as $user): 
            
                $_SESSION['userId'] = $user->getId();
                $_SESSION['username'] = $user->getUsername();
                $_SESSION['password'] = $_POST['password'];
                $_SESSION['type'] = $user->getType();
                $_SESSION['logged'] = 1;
                $_SESSION['cart'] = array();
                $loggedIn = TRUE;
                endforeach; 
       }
        
        if($loggedIn)
        {
            //acount.php
            header('Location: account.php');
            exit;
        }
        else
        {
            //error
            $error .= "Erorr username and password";
        }
    }
}
 
?>
<style>
    .error{
        color: red;
    }
</style>
<h1>Please Login to your account</h1>
<div class="error">
    <?php echo $error ?>
</div>
<form method="post">
    <input name="username" type="text"  value="<?php echo isset($_POST['username']) ? $_POST['username'] : "" ?>" />
    <br/>
    <br/>
    <input name="password" type="password" />
    <br/>
    <br/>
    <button type="submit">Login</button>
    <?php if(!isset($_SESSION['userId'])): ?>
   
    <button type="button" value="home" onClick="document.location.href='home.php'">Home</button>
<?php endif; ?>
</form>