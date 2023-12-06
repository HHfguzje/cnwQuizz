<?php
include '../function.php';
session_start();
$course_id = $_GET['course_id'];
$currentUser = $_SESSION['currentUser'];
$course = getCourse($course_id);
$nameCourse = $course['course'];
$listResult = getResultByUserandCourseId($currentUser['id'], $course_id);
// print_r($listResult);
// echo $course_id;
// echo $currentUser['id'];
// $currentDateTime = date("Y-m-d H:i:s");
// echo $currentDateTime;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lịch sử làm bài</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <?php include 'navbar.php' ?>
    <div class="container mt-5">
        <div class="row">
            <div class="col-12">
                <h1 class="text-center">Lịch sử làm bài</h1>
            </div>
        </div>
        <div class="align-items-center">
            <a href="courses.php" class="btn btn-primary">Trở lại</a>
        </div>
        <div class="row mt-4">
            <div class="col-12">
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Số thứ tự</th>
                            <th scope="col">Thời gian nộp bài</th>
                            <th scope="col">Điểm làm bài</th>
                            <th scope="col">Thời gian làm bàii</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 0;
                        foreach ($listResult as $r) {
                            $i++;
                            echo "<tr>
                            <td>" . $i . "</td>
                            <td>" . $r['timeSubmit'] . "</td>
                            <td>" . $r['score'] . "</td>
                            </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>

</html>