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

        .input-group {
            width: 50%;
            margin: 0 auto;
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
                <label for="name_quiz">Kiểu câu hỏi</label>
                <input class="form-control" value="Sắp xếp" readonly type="text" name="type_question" id="     ">
            </div>
            <div style='margin: 20px 0 0 0;' class='form-group mb-3'>
                <label for="numberAnswer">Số lượng dòng cần sắp xếp</label>
                <input name='numberAnswer' id="numberAnswer" type='text' class='form-control'
                    placeholder='Nhập số lượng đáp án' value="<?php
                    echo isset($_POST['numberAnswer']) ? $_POST['numberAnswer'] : "";
                    ?>">
            </div>
            <?php
            $numberQuestion = 0;
            if (isset($_POST['numberAnswer'])) {
                $numberQuestion = $_POST['numberAnswer'];
            } else {
                echo "Vui lòng nhập số đáp án";
            }
            if (isset($_POST['btn-answer'])) {
                echo "<div class='form-group'>";
                for ($i = 1; $i <= $numberQuestion; $i++) {
                    echo "
                        <div class='input-group mb-3'>
                            <select class='form-select' name='select_$i' id='inputGroupSelect03'>
                                <option value='$i'>$i</option>
                            </select>
                            <input type='text' class='form-control' name='textbox_$i'>
                        </div>
                    ";
                }
                echo "</div>";
            }
            ?>
            <div style="margin: 20px 0 0 0; width: 50px;" class="d-grid">
                <input class="btn btn-primary btn-block" name="btn-answer" type="submit" value="Thêm dòng">
            </div>
            <div style="margin: 20px 0 0 0;" class="d-grid">
                <input class="btn btn-primary btn-block" name="btn-add" type="submit" value="Thêm câu hỏi">
            </div>
        </div>
        </form>
        <?php
        $ordinalArray = [];
        $result = 0;
        if (isset($_POST['btn-add'])) {
            $questionName = $_POST['question_name'];
            $selectedValuesArray = array();

            for ($i = 1; $i <= $numberQuestion; $i++) {
                $ordinal = $_POST['select_' . $i];
                $answer = $_POST['textbox_' . $i];
                if (empty($ordinal) && empty($answer)) {
                    echo "Vui lòng nhập đầy đủ thông tin";
                } else {
                    $ordinalArray[$i] = ['ordinal' => $ordinal,
                        'answer' => $answer];
                }
            }
            $result = createSortingQuestion($questionName, $course_id, $ordinalArray);
            if ($result) {
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