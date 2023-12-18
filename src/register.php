<?php
include '../function.php';
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Đăng ký</title>
	<!-- Begin bootstrap cdn -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
		integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
		integrity="	sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
		crossorigin="anonymous"></script>
	<!-- End bootstrap cdn -->
	<style>
		body {
			background-color: #f8f9fa;
		}

		main {
			min-height: 100vh;
			margin-top: 10%;
		}

		form {
			background-color: #ffffff;
			padding: 20px;
			border-radius: 10px;
			box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
		}

		h1 {
			color: #007bff;
		}
	</style>
</head>

<body>


	<!-- <div class="alert alert-danger text-center" role="alert">Mẫu:Tài khoản hoặc mật khẩu không chính xác</div> -->
	<main style="min-height: 100vh; margin-top: 10%;">
		<div class="d-flex justify-content-center">
			<h1>Đăng ký</h1>
		</div>
		<div class="d-flex justify-content-center">
			<form class="w-25" method="POST">
				<div class="mb-3">
					<label for="username" class="form-label">Username</label>
					<input type="text" class="form-control" id="username" name="username" placeholder="Nhập username"
						value="<?php echo isset($_POST['username']) ? $_POST['username'] : ''; ?>">
				</div>
				<div class="mb-3">
					<label for="fullname" class="form-label">Họ và tên</label>
					<input type="text" class="form-control" id="username" name="fullname" placeholder="Nhập họ và tên"
						value="<?php echo isset($_POST['fullname']) ? $_POST['fullname'] : ''; ?>">
				</div>
				<div class="mb-3">
					<label for="inputPassword" class="col-sm-2 col-form-label">Password</label>
					<div class="col">
						<input type="password" class="form-control" id="inputPassword" placeholder="Nhập Password"
							name="confirm_password">
					</div>
				</div>
				<div class="mb-3">
					<label for="inputPassword" class=" col-form-label">Confirm Password</label>
					<div class="col">
						<input type="password" class="form-control" id="inputPassword" placeholder="Nhập lại Password"
							name="password">
					</div>
				</div>
				<input type="submit" class="btn btn-primary" name="btnRegister" value="Đăng ký">
			</form>
		</div>
		<div class="d-flex justify-content-center mt-3">
			<p>Bạn đã có tài khoản? <a href="login.php">Đăng nhập</a></p>
		</div>

		<?php
		if (isset($_POST['btnRegister'])) {
			$username = $_POST['username'];
			$password = $_POST['password'];
			$confirmPassword = $_POST['confirm_password'];
			$fullname = $_POST['fullname'];
			if ($password == $confirmPassword) {
				$validationErrors = validateRegister($username, $password, $fullname);
				if (!empty($validationErrors)) {
					// Hiển thị thông báo lỗi nếu có
					echo "<script>alert('";
					foreach ($validationErrors as $error) {
						echo $error . " ";
					}
					echo "')</script>;";
				} else {
					// Lưu tài khoản vào database
					$check = register($username, $password, $fullname);

					if ($check === true) {
						echo "<script>alert('Đăng ký thành công!')
                        window.location.href = 'login.php';
                    </script>";
					} else {
						echo "<script>alert('Đăng ký thất bại!')
                    </script>";
					}
				}
			} else {
				echo "<script>alert('Mật khẩu với nhập lại mật khẩu không khớp!')
                    </script>";
			}
		}
		?>

	</main>
	<?php include 'footer.php'; ?>
</body>


</html>