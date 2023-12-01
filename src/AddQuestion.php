<?php
include '../function.php';
session_start();
$currentUser = $_SESSION['currentUser'];
$course_id = $_GET['course_id'];

$course = getCourse($course_id);
$nameCourse = $course['course'];
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
    <main style="min-height: 100vh; max-width: 100%;">
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
                <input class="form-control" type="file" name="file" id=""
                    accept="image/png, image/jpeg, image/jpg">
            </div>
            <div class="form-group">
                <label for="name_quiz">Dạng câu hỏi</label>
                <input class="form-control" value="Điền" readonly type="text" name="type_question" id="     ">
            </div>
            <div style='margin: 20px 0 0 0;' class='input-group mb-3'>
                <input name='answer' type='text' class='form-control' placeholder='Nhập đáp án' value="<?php
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
        $answers = $_POST['answer'];
        $image = "";
        if (!empty($questionName) && !empty($answers)) {
            $result = createQuestionAndAnswers($questionName, $typeQuestion, $image, $course_id, $answers);
            if ($result) {
                echo "<div class='alert alert-success text-center' role='alert'>Thêm câu hỏi thành công</div>";
    
            } else {
                echo "<div class='alert alert-warning text-center' role='alert'>Thêm câu hỏi thất bại". mysqli_error($conn)."</div>";
            }
        } else {
            echo "<div class='alert alert-success text-center' role='alert'>Vui lòng nhập đủ thông tin</div>";
        }
        
        
    }

    include 'footer.php'; 
    ?>

</body>


</html>