<?php
include '../function.php';
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Đăng nhập</title>
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
			<h1>Đăng nhập</h1>
		</div>
		<div class="d-flex justify-content-center">
			<form class="w-25" method="POST">
				<div class="mb-3">
					<label for="username" class="form-label">Username</label>
					<input type="text" class="form-control" id="username" name="username" placeholder="Nhập username"
						value="<?php echo isset($_POST['username']) ? $_POST['username'] : ''; ?>">
				</div>
				<div class="mb-3">
					<label for="inputPassword" class="col-sm-2 col-form-label">Password</label>
					<div class="col">
						<input type="password" class="form-control" id="inputPassword" placeholder="Nhập Password"
							name="password">
					</div>
				</div>
				<input type="submit" class="btn btn-primary" name="btnLogin" value="Đăng nhập">
			</form>
		</div>
		<div class="d-flex justify-content-center mt-3">
			<p>Bạn chưa có tài khoản? <a href="register.php">Đăng ký</a></p>
		</div>
		<?php
		if (isset($_POST['btnLogin'])) {
			$username = $_POST['username'];
			$password = $_POST['password'];
			if (!empty($username) || !empty($password)) {
				if (checkLogin($username, $password)) {
					$_SESSION['currentUser'] = checkLogin($username, $password);
					$_SESSION['is_show'] = false;
					echo "<script>alert('Đăng nhập thành công!')
                        window.location.href = 'courses.php';
                    </script>";
				} else {
					echo '<div class="alert alert-danger text-center" role="alert">Tài khoản hoặc mật khẩu không chính xác</div>';
				}
			} else {
				echo '<div class="alert alert-danger text-center" role="alert">Vui lòng nhập đầy đủ thông tin</div>';
			}
		}
		?>

	</main>
	<?php include 'footer.php'; ?>
</body>


</html>