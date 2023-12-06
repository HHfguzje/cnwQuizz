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
    <style>
        .form-check {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }


        .form-check-input[type=checkbox] {
            margin-bottom: 5px;
        }
    </style>

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
                <label for="name_quiz">Câu hỏi trắc nghiệm</label>
                <input class="form-control" value="Trắc nghiệm" readonly type="text" name="type_question" id="     ">
            </div>
            <div style='margin: 20px 0 0 0;' class='form-group mb-3'>
                <label for="numberAnswer">Số lượng đáp án</label>
                <input name='numberAnswer' id="numberAnswer" type='text' class='form-control'
                    placeholder='Nhập số lượng đáp án' value="<?php
                    echo isset($_POST['numberAnswer']) ? $_POST['numberAnswer'] : "";
                    ?>">
            </div>
            <?php
            function saveValue($i) {
                if(isset($_POST['a'.$i])) {
                    return $_POST['a'.$i];
                }
                return "";
            }

            $numberQuestion = 0;
            if(isset($_POST['numberAnswer'])) {
                $numberQuestion = $_POST['numberAnswer'];
            }
            if(isset($_POST['btn-answer']) || isset($_POST['btn'])) {
                echo "<div class='form-group'>";
                for($i = 1; $i <= $numberQuestion; $i++) {
                    echo "
                        <label for='name_quiz'>Đáp án ".$i."</label>
                        <div class='form-check'>
                        <input class='form-check-input' type='checkbox' name='true".$i."' value='".$i."' id='flexCheckDefault'>
                        <input class='form-control' value='".saveValue($i)."' type='text' name='a".$i."'>
                        </div>
                       ";
                }
                echo "</div>";
            }
            ?>
            <div style="margin: 20px 0 0 0; width: 50px;" class="d-grid">
                <input class="btn btn-primary btn-block" name="btn-answer" type="submit" value="Thêm đáp án">
            </div>
            <div style="margin: 20px 0 0 0;" class="d-grid">
                <input class="btn btn-primary btn-block" name="btn-add" type="submit" value="Thêm câu hỏi">
            </div>
        </div>
        </form>

        <?php
        if(isset($_POST['btn-add'])) {
            $question_name = $_POST['question_name'];
            $type_question = $_POST['type_question'];
            $numberAnswer = $_POST['numberAnswer'];
            $file = $_FILES['file'];
            $image = "";

            //lấy đáp án
            if($numberAnswer > 0) {
                //lấy đáp án đúng
                $true_answer = array();
                for($i = 1; $i <= $numberAnswer; $i++) {
                    if(isset($_POST['true'.$i])) {
                        $true_answer[$i] = $_POST['true'.$i];
                    }
                }

                $answer = [];
                for($i = 1; $i <= $numberAnswer; $i++) {
                    $answer[$i] = ['answer' => $_POST['a'.$i], 'is_true' => 0];
                    foreach($true_answer as $key => $value) {
                        if($i == $value) {
                            $answer[$i] = ['answer' => $_POST['a'.$i], 'is_true' => 1];
                        }
                    }

                }

            }

            //upload image
            if($file['error'] == 0) {
                $fileName = $file['name'];
                $fileTmp = $file['tmp_name'];
                $fileSize = $file['size'];
                $fileType = $file['type'];
                $arr = explode('.', $fileName);
                $fileExtension = strtolower(end($arr));
                $allow = array('png', 'jpg', 'jpeg');
                if(in_array($fileExtension, $allow)) {
                    if($fileSize < 5000000) {
                        $newFileName = uniqid('image-', true).".".$fileExtension;
                        $image = $newFileName;
                        if(!is_dir('../uploads/images')) {
                            mkdir('../uploads/images');
                        }
                        move_uploaded_file($fileTmp, '../uploads/images/'.$newFileName);
                    } else {
                        echo "<div class='alert alert-warning text-center' role='alert'>File quá lớn</div>";
                    }
                } else {
                    echo "<div class='alert alert-warning text-center' role='alert'>File không đúng định dạng</div>";
                }
            }
            // echo $image;
        
            $result = createQuestionChoice($question_name, $type_question, $image, $course_id, $answer);
            if($result) {
                echo "<script>alert('Thêm câu hỏi thành công')</script>";
            } else {
                echo "<script>alert('Thêm câu hỏi thất bại')</script>";
            }





        }
        ?>

    </main>

    <?php
    include 'footer.php';
    ?>

</body>

</html>