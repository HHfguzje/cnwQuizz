<?php
include '../function.php';
session_start();
$course_id = $_GET['course_id'];
$currentUser = $_SESSION['currentUser'];
$course = getCourse($course_id);
$nameCourse = $course['course'];
$listResult = getResultByUserandCourseId($currentUser['id'], $course_id);
$finalResult = end($listResult);
// print_r($_SESSION['a']);
echo "<pre>";

print_r(getTrueAnswerInSortQuestion(96));
echo "</pre>";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Điểm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="	sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
</head>

<body>
    <form method="POST">
        <?php include 'navbar.php'; ?>
        <div class="countdowncontainer" id='countdowncontainer'
            style='width: 20%;min-width:5%;display: flex; justify-content: center;position: absolute; top: 20%;left: 0;'>
        </div>
        <div class="container">
            <h2>KẾT QUẢ</h2>
            <table class="table table-dark table-striped-columns">
                <tr>
                    <td class="table-primary">Tên Khóa học: </td>
                    <td class="table-primary">
                        <?php echo $course['course']; ?>
                    </td>
                </tr>
                <tr>
                    <td class="table-primary">Họ & tên</td>
                    <td class="table-primary">
                        <?php echo $currentUser['fullname'] ?>
                    </td>
                </tr>
                <tr>
                    <td class="table-primary">Điểm</td>
                    <td class="table-primary">
                        <?php echo $finalResult['score']; ?>
                    </td>
                </tr>
                <tr>
                    <td class="table-primary">Thời gian nộp bài</td>
                    <td class="table-primary">
                        <?php echo $finalResult['timeSubmit']; ?>
                    </td>
                </tr>
            </table>
            <div class="align-items-center">
                <a href="courses.php" class="btn btn-primary">Trở lại</a>
                <a href='<?php echo "Practice.php?course_id=" . $course_id ?>' class="btn btn-primary">Làm lại</a>
            </div>
</body>

</html>