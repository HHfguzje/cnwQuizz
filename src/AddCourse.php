<?php
include '../function.php';
session_start();
$currentUser = $_SESSION['currentUser'];
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
        <form action="" method="POST" id="form">
            <div style="margin: 20px 13%;">
                <div class="form-group">
                    <label for="name_quiz"><span style="color: red;">*</span>Nhập tên khóa học</label>
                    <input class="form-control" type="text" name="course_name" id="" value="<?php
                    echo isset($_POST['course_name']) ? $_POST['course_name'] : "";
                    ?>">
                </div>
                <div style="margin: 20px 0 0 0;" class="d-grid">
                    <button type='button' class='btn btn-primary' data-bs-toggle='modal'
                        data-bs-target='#staticBackdrop' onclick="submit()">Thêm khóa học</button>
                </div>
            </div>
        </form>

    </main>

    <?php

    $courseName = $_POST['course_name'];
    if (!empty($courseName)) {
        $result = createCourse($courseName);
        if ($result) {
            echo "<div class='alert alert-success text-center' role='alert'>Thêm khóa học thành công</div>";
        } else {
            echo "<div class='alert alert-warning text-center' role='alert'>Thêm khóa học thất bại" . mysqli_error($conn) . "</div>";
        }
    } else {
        echo "<div class='alert alert-success text-center' role='alert'>Vui lòng nhập đủ thông tin</div>";
    }


    include 'footer.php';
    if (isset($_POST['btn-return'])) {
        header("location: courses.php");
    }
    ?>
    <div class="modal" tabindex="-1" id="staticBackdrop">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Thêm khóa học thành công</p>
                </div>
                <div class="modal-footer">
                    <form method="Post">
                        <input type="submit" class="btn btn-primary" value="Trở về" name="btn-return">
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
    function submit() {
        var form = document.getElementById('form');
        form.submit();
    }
</script>

</html>