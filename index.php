<?php
include 'function.php';
session_start();
// dùng hàm kiểm tra đăng nhập trong file funciton
if (isLogin()) {
	header('Location: ./src/courses.php');
	// echo 'Đã đăng nhập';
} else {
	header('Location: ./src/login.php');
	// echo 'Chưa đăng nhập';
}
// nếu đăng nhập rồi thì truy cập vào trang khóa học
// còn chưa đăng nhập thì điều hướng ra trang đăng nhập
?>