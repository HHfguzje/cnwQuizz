<?php
include_once "../function.php";
session_start();
$courses = getAllCourses();
// print_r($courses);
$currentUser = $_SESSION['currentUser'];
if (isset($_POST['btn'])) {
	header("Refresh:0");
}
?>
<!DOCTYPE html>
<html lang="en	">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Tất cả hóa học</title>
	<!-- Begin bootstrap cdn -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
		integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
		integrity="	sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
		crossorigin="anonymous"></script>
	<!-- End bootstrap cdn -->
	<script src="https://kit.fontawesome.com/772918bb67.js" crossorigin="anonymous"></script>
	<style>
		.card-body a {
			margin-top: 5px;
		}
	</style>

</head>

<body>
	<?php include 'navbar.php'; ?>
	<main style="min-height: 100vh; width: 100%;">
		<div class="" style="text-align: center;">
			<h2>Tất cả hóa học </h2>
		</div>
		<button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown">
			Thao tác
		</button>
		<ul class="dropdown-menu">
			<li><a class="dropdown-item" href="Exam.php">Kiểm tra</a></li>
			<li><a class="dropdown-item" href="Rank.php">Bảng xếp hạng</a></li>
		</ul>
		<div class="row row-cols-1 row-cols-md-3 g-4" style="margin: 0 auto; width: 80%;">
			<!-- begin khóa học -->
			<?php
			foreach ($courses as $course) {
				if ($course['id'] == 100) {
					continue;
				}
				if ($course['state'] == 1) {
					echo "
				<div class='col'>
				<div class='card'>
					<img src='../images/khoahoc.jpg' class='card-img-top' alt='Course Image'>
					<div class='card-body'>";
					echo "<h5 class='card-title'>" . $course['course'] . "</h5>";
					if (isUserEnrolled($currentUser['id'], $course['id'])) {
						if ($currentUser['role'] == 1) {
							echo "<a href='CourseDetail.php?course_id=" . $course['id'] . "' class='btn btn-primary'>Biên tập</a>     ";
							echo "<a href='UserManagerment.php?course_id=" . $course['id'] . "' class='btn btn-primary'>Quản lý người dùng</a>";
						} else
							echo "<a href='CourseDetail.php?course_id=" . $course['id'] . "' class='btn btn-primary'>Đóng góp</a>";
						echo "
						<a href='Practice.php?course_id=" . $course['id'] . "' class='btn btn-primary'>Luyện tập</a>
						<a href='Lesson.php?course_id=" . urlencode($course['id']) . "' class='btn btn-primary'>Bài giảng</a>
						<a href='Result.php?course_id=" . $course['id'] . "' class='btn btn-primary'>Lịch sử làm bài</a>
					</div>
						</div>
					</div>
				";
					} elseif (isUserNotApproved($currentUser['id'], $course['id'])) {
						echo "<a href=#' class='btn btn-primary'>Chờ duyệt</a>
						</div>
						</div>
					</div>";
					} else {
						echo "<form method = 'POST'>
						<input type='hidden' value='" . $course['id'] . "' name='id'/>
                            <input type='submit' name='btn' value='Xin vào khóa học' class='btn btn-success'/>
						</form>
								
						</div>
                        </div>
                    </div>";
					}
				}
			}
			if (isset($_POST['btn'])) {
				$id = $_POST['id'];
				enrollInTheCourse($currentUser['id'], $id);
			}
			?>
			<!-- end khóa học -->
		</div>
		<div class="toast-container position-absolute p-3 bottom-0 end-0" style="height: 150px; margin-bottom: 20">
			<?php
			// Danh sách toast từ mảng
			$toastList = getNotificationsByUserId($currentUser['id']);

			foreach ($toastList as $index => $toastMessage) {
				echo '<div id="toast' . ($index + 1) . '" class="toast" role="alert" aria-live="assertive" aria-atomic="true" style="margin-bottom: ' . ($index * 70) . 'px;">';
				echo '<div class="toast-header bg-primary">';
				echo '<i class="fa-regular fa-bell text-light"></i>';
				echo '<strong class="me-auto ms-2 text-light">' . $toastMessage['tittle'] . '</strong>';
				echo '<small class="text-body-secondary text-light">just now</small>';
				echo '<button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>';
				echo '</div>';
				echo '<div class="toast-body">' . $toastMessage['description'] . '</div>';
				echo '</div>';
				echo '<script>';
				echo 'document.addEventListener(\'DOMContentLoaded\', function () {';
				echo 'setTimeout(function () {';
				echo 'var toast' . ($index + 1) . ' = new bootstrap.Toast(document.getElementById(\'toast' . ($index + 1) . '\'));';
				if ($index > 0) {
					echo 'var toast' . $index . ' = new bootstrap.Toast(document.getElementById(\'toast' . $index . '\'));';
					echo 'toast' . $index . '.hide();'; // Ẩn thông báo trước
				}
				echo 'toast' . ($index + 1) . '.show();'; // Hiển thị thông báo hiện tại
				echo '}, ' . ($index * 3000) . ');'; // Thời gian trễ giữa các thông báo (đơn vị: mili giây)
				echo '});';
				echo '</script>';
			}
			?>
		</div>

	</main>
	<?php include 'footer.php'; ?>


</body>


</html>