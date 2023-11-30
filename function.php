<?php
include 'connectdb.php';
function isLogin(){
	if (isset($_SESSION['currentUser']) && !empty($_SESSION['currentUser'])) {
		return true;
	}
	return false;
}
function checkLogin($username, $password){
	global $conn;
	$md5Password = md5($password);
	$sql = "SELECT * FROM user WHERE username = '$username' AND password = '$md5Password'";
	$result = mysqli_query($conn, $sql);
	$user = mysqli_fetch_assoc($result);
	if ($user) {
		return $user;
	} else {
		return false;
	}
}

function getUser($id_user){
	global $conn;
	$sql = "SELECT * from user WHERE id_user = '$id_user'";
	$result = mysqli_query($conn, $sql);
	$user = mysqli_fetch_assoc($result);
	return $user;
}
function getAllCourses(){
	global $conn;
	$sql = "SELECT * FROM khoa_hoc";
	$result = mysqli_query($conn, $sql);
	$courses = mysqli_fetch_all($result, MYSQLI_ASSOC);
	return $courses;
}


function getCourse($id_khoa_hoc){
	global $conn;
	$sql = "SELECT name FROM khoa_hoc WHERE id = '$id_khoa_hoc'";
	$result = mysqli_query($conn, $sql);
	$course = mysqli_fetch_assoc($result);
	return $course;
}

function getQuestionByCourseId($id_khoa_hoc){
	global $conn;

	$sql = "SELECT * from cau_hoi WHERE id_khoa_hoc = '$id_khoa_hoc'";
	$result = mysqli_query($conn, $sql);
	$listQuestion = mysqli_fetch_all($result, MYSQLI_ASSOC);
	return $listQuestion;

}

function action($id){
	global $conn;
	$sql = "UPDATE cau_hoi SET state = 1 WHERE id = '$id'";
	$result = mysqli_query($conn, $sql);
	return $result;
}

function createQuestion($ten_cau_hoi, $file_tai_len, $dang_cau_hoi, $da, $id_khoa_hoc, $id_user, $state){
	global $conn;
	$sql = "INSERT INTO cau_hoi(name, image, type, answer, id_khoa_hoc, id_user, state) VALUES ('$ten_cau_hoi', '$file_tai_len', '$dang_cau_hoi', '$da', '$id_khoa_hoc', '$id_user', '$state')";
	$result = mysqli_query($conn, $sql);
	return $result;
}

function deleteQuestion($id){
	global $conn;
	$sql = "DELETE from cau_hoi WHERE id = '$id'";
	$result = mysqli_query($conn, $sql);
	return $result;
}