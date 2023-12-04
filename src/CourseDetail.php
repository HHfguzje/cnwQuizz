<?php
include '../function.php';
session_start();
$course_id = $_GET['course_id'];
$currentUser = $_SESSION['currentUser'];
$course = getCourse($course_id);
$nameCourse = $course['course'];
$listQuestion =  getQuestionsWithAnswersByCourseId($course_id);
if (isset($_POST['btn-state']) or isset($_POST['btn-delete'])) {
    header("Refresh:0");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biên tập</title>
    <!-- Begin bootstrap cdn -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="	sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <!-- End bootstrap cdn -->
    <style>
        img {
            max-width: 400px;
        }

        a {
            text-decoration: none;
            color: white;
        }

        table tr td:last-child form {
            display: flex;
            /* justify-content: center; */
            gap: 10px;
        }
    </style>
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
            <a href="courses.php" class="btn btn-primary">Trở lại</a>

            <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown">
                Thêm câu hỏi
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#?course_id=<?php echo $course_id ?>">Câu hỏi sắp xếp</a></li>
                <li><a class="dropdown-item" href="MultiChoiceQuestion.php?course_id=<?php echo $course_id ?>">Câu hỏi trắc nghiệm</a></li>
                <li><a class="dropdown-item" href="AddQuestion.php?course_id=<?php echo $course_id ?>">Câu hỏi điền</a></li>
            </ul>

        </div>
        <div class="d-flex flex-wrap flex-column align-items-center" style="padding: 1%;margin: 5% 0 0 0; ">
            <p class="h3">Danh sách câu hỏi</p>
            <table class="table table-striped">
                <tr>
                    <th>STT</th>
                    <th>Tên câu hỏi</th>
                    <th>Loại câu hỏi</th>
                    <th>Đáp án</th>
                    <th>Tác giả</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                </tr>
                <?php
                $stt = 0;
                // print_r($listQuestion);
                if ($listQuestion) {
                    foreach ($listQuestion as $key => $value) {
                        $stt++;
                        echo "<tr >";
                        echo "<td>" . $stt . "</td>";
                        echo "<td>" . $value['question'] . "</td>";
                        echo "<td>" . $value['type'] . "</td>";
                        echo "<td>" . $value['fill_answer'] . "</td>";
                        echo "<td>" . getFullname($value['user_id']) . "</td>";
                        echo "<td>";
                        echo $value['state'] == 1 ? "Đã duyệt" : "Chưa duyệt";
                        echo "</td>";

                        echo "<td>
                        <form method='POST'>
                        <input type='hidden' value='" . $value['id'] . "' name='id'/>
                        <button type='submit' class='btn btn-primary' name='btn'>Xem trước</button>";
                if ($currentUser['role'] == 1) {
                    echo $value['state'] == 1 ? "" :
                        " <input type='submit' class='btn btn-success' value='Duyệt' name='btn-state'>";
                    echo "<input type='submit' name='btn-delete' value='Xóa' class='btn btn-danger'/>";
                }
                echo " </form></td>";
                    }
                } else {
                    echo "<tr>
                        <td colspan='7' align='center'><h1>Chưa có câu hỏi</h1></td>
                    </tr>";
                }

                if (isset($_POST["btn-state"])){
                    $id = $_POST['id'];
                    approveQuestion( $id );
                }
                if (isset($_POST["btn-delete"])){
                    $id = $_POST['id'];
                    deleteQuestion( $id );

                }
                ?>
            </table>
        </div>
    </main>
    <?php
    include 'footer.php'; 
    ?>
</body>


</html>