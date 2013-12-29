<?php
session_start();
$_SESSION = array();
$session_name = session_name();

unset($_SESSION['id']);
unset($_SESSION['user']);
unset($_SESSION['status']);

session_destroy();

header("Location: index.php");
exit();
?>
