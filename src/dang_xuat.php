<?php
session_start();
$_SESSION['currentUser'] = '';
header('Location: dang_nhap.php');
?>