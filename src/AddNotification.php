<?php
include '../function.php';
session_start();
$currentUser = $_SESSION['currentUser'];
$courses = getAllCourses();

if ($currentUser['role'] != 1) {
    header("Location: courses.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm thông báo</title>
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
            <a href="NotificationManagement.php" class="btn btn-primary">Trở lại</a>
        </div>
        <form action="" method="POST">
            <div style="margin: 20px 13%;">
                <div class="form-group">
                    <label for="name_quiz"><span style="color: red;">*</span>Nhập tiêu đề</label>
                    <input class="form-control" type="text" name="tittle" id="" value="<?php
                    echo isset($_POST['tittle']) ? $_POST['tittle'] : "";
                    ?>">
                    <label for="name_quiz"><span style="color: red;">*</span>Nhập nội dung</label>
                    <input class="form-control" type="text" name="description" id="" value="<?php
                    echo isset($_POST['description']) ? $_POST['description'] : "";
                    ?>">
                    <label for="name_quiz"><span style="color: red;">*</span>Chọn Khóa Học</label>
                    <select class="form-select" name="course_id" aria-label="Default select example">
                        <option selected>---Khóa Học---</option>
                        <?php
                        foreach ($courses as $course) {
                            echo "<option value='$course[id]'>$course[course]</option>";
                        }
                        ?>
                    </select>
                </div>
                <div style="margin: 20px 0 0 0;" class="d-grid">
                    <input class="btn btn-primary btn-block" name="btn" type="submit" value="Thêm thông báo">
                </div>
            </div>
        </form>

    </main>

    <?php

    if (isset($_POST['btn'])) {
        $tittle = $_POST['tittle'];
        $description = $_POST['description'];
        $course_id = $_POST['course_id'];

        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $currentDateTime = date("Y-m-d H:i:s");

        if (!empty($tittle) && !empty($description)) {
            $result = createNotificationForCourses($tittle, $description, $currentDateTime, $course_id);
            if ($result) {
                echo "<script>alert('Thêm thông báo thành công')
                        window.location.href = 'NotificationManagement.php';
                    </script>";

            } else {
                echo "<script>alert('Thêm thông báo thất bại')
                    </script>";
            }
        } else {
            echo "<script>alert('Thêm thông báo thất bại, vui lòng nhập đầy đủ thông tin')
                    </script>";
        }
    }
    include 'footer.php';
    ?>
</body>

</html>