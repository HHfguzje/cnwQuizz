<?php
include '../function.php';
session_start();
$course_id = $_GET['course_id'];
$currentUser = $_SESSION['currentUser'];
$course = getCourse($course_id);
$nameCourse = $course['course'];
if ($currentUser['role'] == 1) {
    $listQuestion = getQuestionsByCourseId($course_id);
} else {
    $listQuestion = getQuestionsByUserId($currentUser['id'], $course_id);
}
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
                <li><a class="dropdown-item" href="MultiChoiceQuestion.php?course_id=<?php echo $course_id ?>">Câu
                        hỏi
                        trắc nghiệm</a></li>

                <li><a class="dropdown-item" href="AddQuestion.php?course_id=<?php echo $course_id ?>">Câu hỏi
                        điền</a>
                </li>
                <li><a class="dropdown-item" href="AddQuestionCode.php?course_id=<?php echo $course_id ?>">Câu hỏi
                        code</a>
                </li>
            </ul>

        </div>
        <div class="d-flex flex-wrap flex-column align-items-center" style="padding: 1%;margin: 5% 0 0 0; ">
            <p class="h3">Danh sách câu hỏi đã đóng góp</p>
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
                        if ($value['type'] == 'Trắc nghiệm') {
                            echo "<td> <ol type='A' style='padding-left: 8px;'>";
                            $listAnswers = getAnswer($value['id']);
                            foreach ($listAnswers as $answer) {
                                echo "<li>" . $answer['answer'];
                                if ($answer['is_true'] == 1) {
                                    echo "<span style='color: green; margin-left: 10px'>(Đáp án đúng)</span>";
                                }
                                echo "</li>";
                            }
                            echo "</ol></td>";
                        } else {
                            echo "<td>";
                            $listAnswers = getAnswer($value['id']);
                            foreach ($listAnswers as $answer) {
                                echo $answer['answer'];
                            }
                            echo "</td>";
                        }
                        echo "<td>" . getFullname($value['user_id']) . "</td>";
                        echo "<td>";
                        echo $value['state'] == 1 ? "Đã duyệt" : "Chưa duyệt";
                        echo "</td>";

                        echo "<td>
                        <form method='POST'>
                        <input type='hidden' value='" . $value['id'] . "' name='id'/>

                        <button type='button' class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#staticBackdrop" . $value['id'] . "'>Xem trước</button>";

                        if ($currentUser['role'] == 1) {
                            echo $value['state'] == 1 ? "" :
                                " <input type='submit' class='btn btn-success' value='Duyệt' name='btn-state'>";
                            echo "<input type='submit' name='btn-delete' value='Xóa' class='btn btn-danger'/>";
                        }
                        echo " </form></td>";


                        echo '
                        <div class="modal fade" id="staticBackdrop' . $value['id'] . '" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h1 class="modal-title fs-5" id="staticBackdropLabel">' . $value['question'] . '</h1>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                            <h6> Đáp án :</h6>  <ol type="A">';
                        foreach ($listAnswers as $answer) {
                            echo "<li>" . $answer['answer'];
                            if ($answer['is_true'] == 1) {
                                echo "<span style='color: green; margin-left: 10px'>(Đáp án đúng)</span>";
                            }
                            echo "</li>";
                        }
                        echo '
                            </ol>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                          </div>
                        </div>
                      </div>
                        ';

                    }
                } else {
                    echo "<tr>
                        <td colspan='7' align='center'><h1>Chưa có câu hỏi</h1></td>
                    </tr>";
                }

                if (isset($_POST["btn-state"])) {
                    $id = $_POST['id'];
                    approveQuestion($id);
                }
                if (isset($_POST["btn-delete"])) {
                    $id = $_POST['id'];
                    deleteQuestion($id);

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