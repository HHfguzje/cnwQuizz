<?php
include '../function.php';
session_start();
$currentUser = $_SESSION['currentUser'];
$course_id = $_GET['course_id'];

$course = getCourse($course_id);
$nameCourse = $course['course'];

$check = isUserEnrolled($currentUser['id'], $course_id);
if (!$check) {
    header("location: courses.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm câu hỏi</title>
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
            <p class="h3">Khóa học
                <?php echo $nameCourse; ?>
            </p>
            <a href="CourseDetail.php?course_id=<?php echo $course_id ?>" class="btn btn-primary">Trở lại</a>
            <form action="" method="POST" enctype="multipart/form-data">
        </div>
        <div style="margin: 20px 13%;">
            <div class="form-group">
                <label for="name_quiz"><span style="color: red;">*</span>Nhập tên câu hỏi</label>
                <input class="form-control" type="text" name="question_name" id="" value="<?php
                echo isset($_POST['question_name']) ? $_POST['question_name'] : "";
                ?>">
            </div>
            <div class="form-group">
                <label for="name_quiz">Ảnh cho câu hỏi</label>
                <input class="form-control" type="file" name="file" id="" accept="image/png, image/jpeg, image/jpg">
            </div>
            <div class="form-group">
                <label for="name_quiz">Dạng câu hỏi</label>
                <input class="form-control" value="Điền" readonly type="text" name="type_question" id="     ">
            </div>
            <div class="form-group">
                <label for="name_quiz"><span style="color: red;">*</span>Nhập đáp án</label>
                <input class="form-control" name='answer' type='text' class='form-control' placeholder='Nhập đáp án'
                    value="<?php
                    echo isset($_POST['answer']) ? $_POST['answer'] : "";
                    ?>">
            </div>
            <div style="margin: 20px 0 0 0;" class="d-grid">
                <input class="btn btn-primary btn-block" name="btn" type="submit" value="Thêm câu hỏi">
            </div>
        </div>
        </form>

    </main>

    <?php

    if (isset($_POST['btn'])) {
        $questionName = $_POST['question_name'];
        $typeQuestion = $_POST['type_question'];
        $file = $_FILES['file'];
        $answer = $_POST['answer'];
        $image = "";

        //upload image
        if ($file['error'] == 0) {
            $fileName = $file['name'];
            $fileTmp = $file['tmp_name'];
            $fileSize = $file['size'];
            $fileType = $file['type'];
            $arr = explode('.', $fileName);
            $fileExtension = strtolower(end($arr));
            $allow = array('png', 'jpg', 'jpeg');
            if (in_array($fileExtension, $allow)) {
                if ($fileSize < 5000000) {
                    $newFileName = uniqid('image-', true) . "." . $fileExtension;
                    $image = $newFileName;
                    if (!is_dir('../uploads/images/')) {
                        mkdir('../uploads/images/');
                    }
                    move_uploaded_file($fileTmp, '../uploads/images/' . $newFileName);


                } else {
                    echo "<script>alert('File quá lớn')
                    </script>";
                }
            } else {
                echo "<script>alert('File không đúng định dạng')
                    </script>";
            }
        }
        //insert question
        if (!empty($questionName) && !empty($answer)) {
            date_default_timezone_set('Asia/Ho_Chi_Minh');
            $currentDateTime = date("Y-m-d H:i:s");

            $result = createQuestionAndAnswers($questionName, $typeQuestion, $image, $course_id, $answer, 1);
            if ($result) {
                createNotificationForUser($nameCourse, $currentUser['fullname'] . " đã đóng góp câu hỏi mới", $currentDateTime, 13);
                echo "<script>alert('Thêm câu hỏi thành công')
                        window.location.href = 'CourseDetail.php?course_id=" . $course_id . "';
                    </script>";

            } else {
                echo "<script>alert('Thêm câu hỏi thất bại')
                    </script>";
            }
        } else {
            echo "<script>alert('Vui lòng nhập đủ thông tin')
                    </script>";
        }



    }

    include 'footer.php';
    ?>

</body>


</html>