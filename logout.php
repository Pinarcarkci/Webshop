<?php
session_start();

// clean 
$_SESSION = [];

session_destroy();

header("Location: login.php");
exit;
?>
