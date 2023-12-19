<?php
session_start();
$_SESSION['currentUser'] = '';
$_SESSION['is_show'] = false;
header('Location: login.php');
?>