<?php
include_once "../function.php";
session_start();
$currentUser = $_SESSION['currentUser'];
$courses = getApprovedCoursesForUser($currentUser['id']);
?>
<!DOCTYPE html>
<html lang="en	">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Khóa học của tôi</title>
    <!-- Begin bootstrap cdn -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="	sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <!-- End bootstrap cdn -->
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
            <h2>Khóa học của tôi</h2>
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
                if ($course['state'] == 1) {
                    echo "
				<div class='col'>
				<div class='card'>
					<img src='../images/khoahoc.jpg' class='card-img-top' alt='Course Image'>
					<div class='card-body'>
						<h5 class='card-title'>" . $course['course'] . "</h5>";
                    if ($currentUser['role'] == 1) {
                        echo "<a href='CourseDetail.php?course_id=" . $course['id'] . "' class='btn btn-primary'>Biên tập</a>     ";
                        echo "<a href='UserManagerment.php?course_id=" . $course['id'] . "' class='btn btn-primary'>Quản lý người dùng</a>";
                    } else
                        echo "<a href='CourseDetail.php?course_id=" . $course['id'] . "' class='btn btn-primary'>Đóng góp</a>";
                    echo "
						<a href='Practice.php?course_id=" . $course['id'] . "' class='btn btn-primary'>Luyện tập</a>
						<a href='Practice.php?course_id=" . $course['id'] . "' class='btn btn-primary'>Bài giảng</a>
						<a href='Result.php?course_id=" . $course['id'] . "' class='btn btn-primary'>Lịch sử làm bài</a>
					</div>
				</div>
			</div>
				";
                }
            }
            ?>
            <!-- end khóa học -->


        </div>
    </main>
    <?php include 'footer.php'; ?>
</body>


</html>