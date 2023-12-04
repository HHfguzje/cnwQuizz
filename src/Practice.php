<?php
include '../function.php';
session_start();
$course_id = $_GET['course_id'];
$currentUser = $_SESSION['currentUser'];
$course = getCourse($course_id);
$nameCourse = $course['course'];
$listQuestion = getQuestionsWithAnswersByCourseId($course_id);
if (isset($_POST['btn-state']) or isset($_POST['btn-delete'])) {
    header("Refresh:0");
}
$questionForQuizz = getQuestionsForQUizz($course_id);
// print_r(getQuestionsForQUizz($course_id));

function checkType($type)
{
    if ($type == "Điền") {
        return 0;
    } else if ($type == "Trắc nghiệm") {
        return 1;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Câu hỏi trắc nghiệm</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #007bff;
        }

        .title {
            color: #343a40;
            margin-bottom: 10px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-check {
            margin-bottom: 10px;
        }

        .btn-submit {
            background-color: #28a745;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn-submit:hover {
            background-color: #218838;
        }
    </style>
</head>

<body>
    <?php include 'navbar.php'; ?>
    <div class="container">
        <h2>BÀI THI</h2>
        <?php
        $i = 0;
        foreach ($questionForQuizz as $q) {
            $i++;
            if (checkType($q['type']) == 0) {
                echo "
                <div class='form-group'>
                    <h5 class='title'>Câu " . $i . ": " . $q['question'] . "?</h5>
                    <input type='hidden' name='' value=" . $q['id'] . ">
                    <input class='form-control' type='text' name='' value=''>
                </div>
                ";
            } else if (checkType($q["type"]) == 1) {
                echo "<div class='form-group'>
                    <h5 class='title'>Câu " . $i . ": " . $q['question'] . "?</h5>";
                foreach (getAnswer($q['id']) as $a) {
                    echo "
                        <div class='form-check'>
                            <input class='form-check-input' type='checkbox' value='' id='flexCheckDefault'>
                            <label class='form-check-label' for='flexCheckDefault'>" . $a['answer'] . "</label>
                        </div>
                    ";
                }
                echo "</div>";
            } else {
                echo "";
            }
        }
        ?>
        <button class="btn-submit">Submit</button>
    </div>
    <?php include 'footer.php'; ?>
    <!-- Bootstrap JS and Popper.js -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>

</html>