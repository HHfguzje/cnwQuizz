<?php
include '../function.php';
session_start();
$course_id = $_GET['course_id'];
$currentUser = $_SESSION['currentUser'];
$course = getCourse($course_id);
$nameCourse = $course['course'];
if(isset($_POST['btn-state']) or isset($_POST['btn-delete'])) {
    header("Refresh:0");
}
function checkType($type) {
    if($type == "Điền") {
        return 0;
    } else if($type == "Trắc nghiệm") {
        return 1;
    }
}
$questionForQuizz = getQuestionsForQUizz($course_id);
if(isset($_POST['btn-submit'])) {
    header("location: Point.php?course_id=$course_id");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Câu hỏi trắc nghiệm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="	sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
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
    <form method="POST" name="formSubmit">
        <?php include 'navbar.php'; ?>
        <div class="align-items-center">
            <a href="courses.php" class="btn btn-primary">Trở lại</a>
        </div>
        <div class="countdowncontainer" id='countdowncontainer'
            style='width: 20%;min-width:5%;display: flex; justify-content: center;position: absolute; top: 20%;left: 0;'>
        </div>
        <div class="container">
            <h2>BÀI THI</h2>
            <?php
            $true_answer = [];
            $currentDateTime = '';
            $i = 0;

            foreach($questionForQuizz as $index => $q) {
                $numberAnswer = 0;
                $i++;
                if(checkType($q['type']) == 0) {
                    $true_answer[$index] = [0 => getAnswer($q['id'])[0]['answer']];
                    echo "
                        <div class='form-group'>
                            <h5 class='title'>Câu ".$i.": ".$q['question']."?</h5>
                            <input type='hidden' name='' value=".$q['id'].">
                            <input class='form-control' type='text' name='".$q['id']."' value=''>
                        </div>
                ";
                } else if(checkType($q["type"]) == 1) {
                    echo "
                        <div class='form-group'>
                        <h5 class='title'>Câu ".$i.": ".$q['question']."?</h5>
                    ";
                    foreach(getAnswer($q['id']) as $key => $a) {
                        if($a['is_true'] == 1) {
                            $numberAnswer++;
                            $true_answer[$index][] = $key;
                        }
                    }
                    foreach(getAnswer($q['id']) as $key => $a) {
                        if($numberAnswer > 1) {
                            echo "
                                <div class='form-check'>
                                    <input class='form-check-input' type='checkbox' value='' name='".$q['id'].$key."' id='flexCheckDefault'>
                                    <label class='form-check-label' for='flexCheckDefault'>".$a['answer']."</label>
                                </div>";
                        } else {
                            echo "
                                <div class='form-check'>
                                    <input class='form-check-input' type='radio' name='".$q['id'].$key."' id='flexRadioDefault".$key."'>
                                    <label class='form-check-label' for='flexRadioDefault1'>
                                        ".$a['answer']."
                                    </label>
                                 </div>";
                        }
                    }
                    echo "</div>";
                } else {
                    echo "";
                }
            }
            $_SESSION['true_answer'] = $true_answer;
            ?>
            <input class="btn-submit" type="submit" name="btn-submit" value='Nộp bài' />
            <?php
            $score = 0;
            if(isset($_POST['btn-submit'])) {
                $currentDateTime = date("Y-m-d H:i:s");
                $true_answer = $_SESSION['true_answer'];
                foreach($true_answer as $index => $value) {
                    if(checkType($questionForQuizz[$index]['type']) == 0) {
                        if(!empty($_POST[$questionForQuizz[$index]['id']])) {
                            if($value[0] == $_POST[$questionForQuizz[$index]['id']]) {
                                $score++;
                            }
                        }
                    } else if(checkType($questionForQuizz[$index]['type']) == 1) {
                        $check = true;
                        foreach($value as $key => $v) {
                            if(!isset($_POST[$questionForQuizz[$index]['id'].$v])) {
                                $check = false;
                            }
                        }
                        if($check) {
                            $score++;
                        }
                    }
                }
                saveResult($currentUser['id'], $score, $course_id, $currentDateTime);
            }
            ?>
            <?php include 'footer.php'; ?>
    </form>

    <!-- count down -->
    <?php
    echo <<<EOD
                    <script type="text/javascript">
                    var duration = 0.1 * 60 * 1000;
                    var countDownBtn = document.getElementById("countdownbtn");
                    var x;

                    window.onload = e => {
                        e.preventDefault();

                        var startTime = new Date().getTime();
                        if (x) clearInterval(x);
                        x = setInterval(function () {
                            var now = new Date().getTime();
                            var distance = startTime + duration - now;
                            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                            var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                            document.getElementById("countdowncontainer").innerHTML = 'Thời gian:  ' + minutes + "m " + seconds + "s ";
                            if (distance <= 0) {
                                clearInterval(x);
                                document.getElementById("countdowncontainer").innerHTML = "Hết thời gian!";
                                document.getElementById("countdowncontainer").setAttribute("class", "text-danger");
                                
                                // Chuyển hướng sau khi kết thúc đếm ngược
                                window.location.href = "Point.php?course_id=$course_id";
                            }
                        }, 1000);
                    };
                </script>
                EOD;
    ?>

</body>

</html>