<?php
include '../function.php';
session_start();
$currentUser = $_SESSION['currentUser'];
$listCourses = getAllCourses();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm khóa học</title>
    <!-- Begin bootstrap cdn -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="	sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <!-- End bootstrap cdn -->

</head>

<body>
    <?php
    include 'navbar.php';
    ?>
    <main style=" max-width: 100%;">
        <div id="action" style="margin: 20px 0 0 13%;">
            <a href="CourseManagement.php" class="btn btn-primary">Trở lại</a>
        </div>
        <form action="" method="POST">
            <div style="margin: 20px 13%;">
                <div class="form-group">
                    <label for="name_quiz"><span style="color: red;">*</span>Nhập tên khóa học</label>
                    <input class="form-control" type="text" name="course_name" id="" value="<?php
                    echo isset($_POST['course_name']) ? $_POST['course_name'] : "";
                    ?>">
                </div>
                <div style="margin: 20px 0 0 0;" class="d-grid">
                    <input class="btn btn-primary btn-block" name="btn" type="submit" value="Thêm khóa học">
                </div>
            </div>
        </form>

    </main>

    <?php

    if (isset($_POST['btn'])) {
        $courseName = $_POST['course_name'];
        $check = false;

        if (!empty($courseName)) {
            foreach ($listCourses as $course) {
                if ($course['course'] == $courseName) {
                    $check = true;
                    echo "<div class='alert alert-danger text-center' role='alert'>Khóa học đã tồn tại</div>";
                    exit();
                }
            }
            if ($check == false) {
                $result = createCourse($courseName);
                if ($result) {
                    echo "<script>alert('Thêm khóa học thành công')
                        window.location.href = 'CourseManagement.php';
                    </script>";

                } else {
                    echo "<div class='alert alert-warning text-center' role='alert'>Thêm khóa học thất bại" . mysqli_error($conn) . "</div>";
                }
            }

        } else {
            echo "<div class='alert alert-success text-center' role='alert'>Vui lòng nhập đủ thông tin</div>";
        }
    }
    include 'footer.php';
    ?>
</body>

</html>