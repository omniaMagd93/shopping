<?php
$fb = new Facebook\Facebook([
  'app_id' => '104696687080641',
  'app_secret' => '{app-secret}',
  'default_graph_version' => 'v2.2',
]);
 
$helper = $fb->getRedirectLoginHelper();
 
$permissions = []; // Optional information that your app can access, such as 'email'
$loginUrl = $helper->getLoginUrl('https://example.com/fb-callback.php', $permissions);
 
echo '<a href="' . htmlspecialchars($loginUrl) . '">Log in with Facebook</a>';
?>