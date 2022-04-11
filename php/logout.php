<?php
session_start();
 
//yeet session variables
$_SESSION = array();
 
// Destroy the session.
session_destroy();
 
// Redirect to login page
header("location: php/login.php");
exit;
?>