<?php
include '../function.php';
session_start();
$course_id = $_GET['course_id'];
$currentUser = $_SESSION['currentUser'];
$course = getCourse($course_id);
$nameCourse = $course['course'];
if ($currentUser['role'] == 1) {
    $listResult = getResultByCourseId($course_id);
} else {
    $listResult = getResultByUserandCourseId($currentUser['id'], $course_id);
}

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
    <title>Lịch sử làm bài</title>
    <script src="https://kit.fontawesome.com/772918bb67.js" crossorigin="anonymous"></script>

    <!-- Begin bootstrap cdn -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="	sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <!-- End bootstrap cdn -->
</head>

<body>
    <?php include 'navbar.php' ?>
    <div class="container mt-5">
        <div class="align-items-center">
            <a href="courses.php" class="btn btn-primary"><i class="fa-solid fa-arrow-left"></i></a>
        </div>
        <div class="row">
            <div class="col-12">
                <h1 class="text-center">Lịch sử làm bài</h1>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Số thứ tự</th>
                            <th scope="col">Thời gian nộp bài</th>
                            <th scope="col">Điểm làm bài</th>
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
<?php include 'footer.php'; ?>

</html>