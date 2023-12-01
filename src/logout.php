<?php
session_start();
$_SESSION['currentUser'] = '';
header('Location: login.php');
?>