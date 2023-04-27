<?php
// Initialize the session
session_start();
 
// Unset all of the session variables
$_SESSION = array();
unset($_SESSION['phone_num']);
 
// Destroy the session.
session_destroy();
 
// Redirect to login page
header("location: login.php");
exit;
?>