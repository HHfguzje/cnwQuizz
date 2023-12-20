<?php
include '../function.php';
session_start();
if (!isLogin()) {
	header("Location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Đăng ký</title>
	<script src="https://kit.fontawesome.com/772918bb67.js" crossorigin="anonymous"></script>

	<!-- Begin bootstrap cdn -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
		integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
		integrity="	sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
		crossorigin="anonymous"></script>
	<!-- End bootstrap cdn -->

</head>

<body>
	<?php include 'navbar.php'; ?>
	<main style="min-height: 100vh;">
		<div class="ms-4 mt-4">
			<a href="courses.php" class="btn btn-primary"><i class="fa-solid fa-arrow-left"></i></a>
		</div>
		<div class="d-flex justify-content-center">
			<h1>Đổi mật khẩu</h1>
		</div>

		<div class="d-flex justify-content-center">
			<form class="w-25" method="POST">
				<div class="mb-3">

					<label for="inputPassword" class=" col-form-label">Mật khẩu cũ</label>
					<div class="col">
						<input type="password" class="form-control" id="inputPassword" placeholder="Nhập Password cũ"
							name="old_password">
					</div>
				</div>
				<div class="mb-3">
					<label for="inputPassword" class=" col-form-label">Mật khẩu mới</label>
					<div class="col">
						<input type="password" class="form-control" id="inputPassword" placeholder="Nhập Password mới"
							name="new_password">
					</div>
				</div>
				<div class="mb-3">
					<label for="inputPassword" class=" col-form-label">Nhập lại mật khẩu mới</label>
					<div class="col">
						<input type="password" class="form-control" id="inputPassword"
							placeholder="Nhập lại Password mới" name="confirm_new_password">
					</div>
				</div>
				<input type="submit" class="btn btn-primary" name="btnChangePassword" value="Đổi mật khẩu">
			</form>
		</div>
		<div class="d-flex justify-content-center mt-3">
			<p>Quay lại trang chủ <a href="courses.php">Khóa học</a></p>
		</div>

		<?php
		if (isset($_POST['btnChangePassword'])) {
			$oldPW = $_POST['old_password'];
			$newPW = $_POST['new_password'];
			$confirmNewPW = $_POST['confirm_new_password'];
			$validationErrors = validateChangePassword($oldPW, $newPW, $confirmNewPW);

			if (empty($validationErrors)) {
				$username = $_SESSION['currentUser']['username'];
				$currentPassword = $_SESSION['currentUser']['password'];
				if (md5($oldPW) == $currentPassword) {
					$md5NewPassword = md5($newPW);
					if (updatePassword($username, $md5NewPassword)) {
						echo "<script>alert('Đổi mật khẩu thành công!')
						      window.location.href = 'courses.php';
                            </script>";
					} else {
						echo "<script>alert('Đã xảy ra lỗi, vui lòng thử lại sau')
                            </script>";
					}
				} else {
					echo "<script>alert('Mật khẩu cũ không chính xác')
                            </script>";
				}
			} else {
				foreach ($validationErrors as $error) {
					echo "<script>alert('" . $error . "')
                            </script>";
				}
			}
		}
		?>

	</main>
	<?php include 'footer.php'; ?>
</body>


</html>