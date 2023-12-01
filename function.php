<?php
include 'connectdb.php';
//Đăng ký
function isUsernameExists($username) {
    global $conn;
    $sql = "SELECT * FROM user WHERE username = '$username'";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);
    return $user ? true : false;
}
function validateRegister($username, $password, $fullname){
    $errors = array();
    if (strlen($username) < 6 || strlen($username) > 16) {
        $errors[] = "Username phải từ 6 đến 16 ký tự";
    }
    if (strlen($password) < 8 || strlen($password) > 20) {
        $errors[] = "Password phải từ 8 đến 20 ký tự";
    }
	if (empty($fullname)) {
        $errors[] = "Không được để trống họ tên";
    }
	if (isUsernameExists($username)) {
        $errors[] = "Tên đăng nhập đã tồn tại, vui lòng chọn tên khác";
    }
    return $errors;
}

function register($username, $password, $fullname){
    global $conn;
    $validationErrors = validateRegister($username, $password, $fullname);
    if (!empty($validationErrors)) {
        return $validationErrors;
    }
    $md5Password = md5($password);
    $sql = "INSERT INTO user(username, password, fullname, role) VALUES ('$username', '$md5Password', '$fullname', '0')";
    $result = mysqli_query($conn, $sql);
    return $result;
}

//Đăng nhập
function checkLogin($username, $password) {
    global $conn;
    $md5Password = md5($password);
    $sql = "SELECT * FROM user WHERE username = '$username' AND password = '$md5Password'";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);
	// var_dump($user);
	if ($user) {
			return $user;
		} else {
			return false;
		}
}
function isLogin(){
	if (isset($_SESSION['currentUser']) && !empty($_SESSION['currentUser'])) {
		return true;
	}
	return false;
}
//đổi mật khẩu
function validateChangePassword($oldPassword, $newPassword, $confirmPassword) {
    $errors = array();
    if (empty($oldPassword) || empty($newPassword) || empty($confirmPassword)) {
        $errors[] = "Vui lòng nhập đầy đủ thông tin.";
    }
    if (md5($oldPassword) != $_SESSION['currentUser']['password']) {
        $errors[] = "Mật khẩu cũ không chính xác.";
    }
    if (strlen($newPassword) < 8 || strlen($newPassword) > 20) {
        $errors[] = "Mật khẩu mới phải từ 8 đến 20 ký tự.";
    }
    if ($newPassword !== $confirmPassword) {
        $errors[] = "Mật khẩu mới và xác nhận mật khẩu không khớp.";
    }
    if ($oldPassword === $newPassword) {
        $errors[] = "Mật khẩu mới phải khác mật khẩu cũ.";
    }
    return $errors;
}

function updatePassword($username, $newPassword) {
    global $conn;
    $sql = "UPDATE user SET password = '$newPassword' WHERE username = '$username'";
    return mysqli_query($conn, $sql);
}
//Khóa học
function getAllCourses(){
	global $conn;
	$sql = "SELECT * FROM courses";
	$result = mysqli_query($conn, $sql);
	$courses = mysqli_fetch_all($result, MYSQLI_ASSOC);
	return $courses;
}
