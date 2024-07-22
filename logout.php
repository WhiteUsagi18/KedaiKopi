<?php
// Start session
session_start();

// Unset all session variables
session_unset();

// Destroy the session
session_destroy();

// Delete cookies (if any)
if(isset($_COOKIE['id']) && isset($_COOKIE['key'])) {
    setcookie('id', '', time() - 24*60*60); // set to past time
    setcookie('key', '', time() - 24*60*60); // set to past time

}

setcookie('cartItems', '', time() - 6000);

header("Location: index.php");
exit();
?>