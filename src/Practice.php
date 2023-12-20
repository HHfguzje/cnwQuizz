<?php
include '../function.php';
session_start();
$currentUser = $_SESSION['currentUser'];
$course_id = $_GET['course_id'];
$questionForQuizz = getQuestionsForQUizz($course_id);
function checkType($type)
{
    if ($type == "Điền") {
        return 0;
    } else if ($type == "Trắc nghiệm") {
        return 1;
    } else
        return 2;
}
if (isset($_POST['countdown_expired'])) {
    header("location: Point.php?course_id=$course_id");
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['sortedValues'])) {
        $sortedValues = $_POST['sortedValues'];
        $_SESSION['a'] = $sortedValues;
    }
}
$check = isUserEnrolled($currentUser['id'], $course_id);
if (!$check) {
    echo "<script>alert('Hiện tại bạn không có bài kiểm tra nào')
                        window.location.href = 'courses.php';
                    </script>";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="	sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
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

        .container-drag-drop {
            width: 100%;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        #column {
            cursor: grab;
        }

        .list {
            background: blue;
            height: 40px;
            margin: 30px;
            color: #fff;
            display: flex;
            align-items: center;
            cursor: grab;
            user-select: none;
        }

        .list i {
            margin-right: 15px;
            margin-left: 20px;
        }
    </style>
</head>

<body>
    <form method="POST" id='form'>

        <input type="hidden" name="countdown_expired" value="1">
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
            foreach ($questionForQuizz as $index => $q) {
                $numberAnswer = 0;
                $i++;
                if (checkType($q['type']) == 0) {
                    $true_answer[$index] = [0 => getAnswer($q['id'])[0]['answer']];
                    echo "
                        <div class='form-group'>
                            <h5 class='title'>Câu " . $i . ": " . $q['question'] . "?</h5>
                            <input type='hidden' name='' value=" . $q['id'] . ">
                    ";
                    if ($q['image'] != null) {
                        echo "<img src='../uploads/images/" . $q['image'] . "' alt='image' style='max-width:500px;max-height:250px; margin-bottom: 10px;'>";
                    }
                    echo "
                            <input class='form-control' type='text' name='" . $q['id'] . "' value=''>
                        </div>
                ";
                } else if (checkType($q["type"]) == 1) {
                    echo "
                        <div class='form-group'>
                        <h5 class='title'>Câu " . $i . ": " . $q['question'] . "?</h5>
                    ";
                    //ảnh
                    if ($q['image'] != null) {
                        echo "<img src='../uploads/images/" . $q['image'] . "' alt='image' style='max-width:500px;max-height:250px; margin-bottom: 10px;'>";
                    }
                    // lấy ra mảng đáp án đúng của câu hỏi
                    foreach (getAnswer($q['id']) as $key => $a) {
                        if ($a['is_true'] == 1) {
                            $numberAnswer++;
                            $true_answer[$index][] = $key;
                        }
                    }

                    foreach (getAnswer($q['id']) as $key => $a) {
                        if ($numberAnswer > 1) {
                            echo "
                                <div class='form-check'>
                                    <input class='form-check-input' type='checkbox' value='' name='" . $q['id'] . $key . "' id='flexCheckDefault'>
                                    <label class='form-check-label' for='flexCheckDefault'>" . $a['answer'] . "</label>
                                </div>";
                        } else {
                            echo "
                                <div class='form-check'>
                                    <input class='form-check-input' type='radio' name='" . $q['id'] . "' id='flexRadioDefault" . $key . "'>
                                    <label class='form-check-label' for='flexRadioDefault1'>
                                        " . $a['answer'] . "
                                    </label>
                                 </div>";
                        }
                    }
                    echo "</div>";
                } else {
                    echo '<div class="form-group">';
                    echo '<h5 class="title">Câu ' . $i . ': ' . $q['question'] . '?</h5>';
                    echo '<div class="container"><div id="column' . $i . '">';

                    foreach (getRandomAnswer($q['id']) as $index => $value) {

                        echo '<div class="list" draggable="true" data-index="' . $index . '">';
                        echo '<i class="fa fa-list-ul" aria-hidden="true"></i>' . htmlspecialchars($value['answer']);
                        echo '<input type="hidden" name="sortedValues[' . $i . '][]" value="' . $value['ordinalNumber'] . '">';
                        echo '</div>';
                    }
                    echo "</div></div></div>
                        <form method='POST' id='myForm'>
                            <input type='hidden' name='result' id='resultInput" . $i . "' value=''>
                        </form>";
                    echo '<script>
                                $(function () {
                                    $("#column' . $i . '").sortable({
                                        update: function (event, ui) {
                                            updateOrder();
                                        }
                                    });
    
                                    function updateOrder() {
                                        var result = $("#column' . $i . '").sortable("toArray");
                                        $("#resultInput' . $i . '").val(JSON.stringify(result));
                                    }
                                });
                            </script>';

                }
            }
            $_SESSION['true_answer'] = $true_answer;
            ?>
            <button class="btn btn-submit" onclick="submit()">Nộp bài</button>
            <!-- Tính điểm -->
            <?php
            date_default_timezone_set('Asia/Ho_Chi_Minh');
            $currentDateTime = date("Y-m-d H:i:s");
            $score = 0;
            $true_answer = $_SESSION['true_answer'];
            foreach ($true_answer as $index => $value) {
                if (checkType($questionForQuizz[$index]['type']) == 0) {
                    if (!empty($_POST[$questionForQuizz[$index]['id']])) {
                        if ($value[0] == $_POST[$questionForQuizz[$index]['id']]) {
                            $score++;
                        }
                    }
                } else if (checkType($questionForQuizz[$index]['type']) == 1) {
                    $check = true;
                    if (count($value) == 1) {
                        foreach ($value as $key => $v) {
                            //nếu đáp án là dạng radio
                            if (!isset($_POST[$questionForQuizz[$index]['id']])) {
                                $check = false;
                            }
                        }
                        //nếu đáp án là dạng checkbox
                    } else {
                        foreach ($value as $key => $v) {
                            if (!isset($_POST[$questionForQuizz[$index]['id'] . $v])) {
                                $check = false;
                            }
                        }
                    }
                    if ($check) {
                        $score++;
                    }
                }
            }

            if (!empty($_POST['sortedValues'])) {
                foreach ($_POST['sortedValues'] as $index => $value) {
                    $true = true;
                    foreach ($value as $key => $v) {
                        if ($v != $key + 1) {
                            $true = false;
                            break;
                        }
                    }
                    if ($true) {
                        $score++;
                    }
                }

            }
            saveResult($currentUser['id'], $score, $course_id, $currentDateTime);
            ?>

    </form>

    <script>
        function submit() {
            var form = document.getElementById('form');
            form.submit();
        }
    </script>


    <!-- count down -->
    <script type="text/javascript">
        var duration = 10 * 60 * 1000;
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
                    submit();
                }
            }, 1000);
        };
    </script>

</body>

<?php include 'footer.php'; ?>

</html>