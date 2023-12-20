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
    <title>Biên tập</title>
    <script src="https://kit.fontawesome.com/772918bb67.js" crossorigin="anonymous"></script>
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
            <a href="courses.php" class="btn btn-primary"><i class="fa-solid fa-arrow-left"></i></a>

            <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown">
                Thêm câu hỏi
            </button>
            <ul class="dropdown-menu">

                <li><a class="dropdown-item" href="SortingQuestion.php?course_id=<?php echo $course_id ?>">Câu hỏi sắp
                        xếp</a></li>
                <li><a class="dropdown-item" href="MultiChoiceQuestion.php?course_id=<?php echo $course_id ?>">Câu
                        hỏi
                        trắc nghiệm</a></li>

                <li><a class="dropdown-item" href="AddQuestion.php?course_id=<?php echo $course_id ?>">Câu hỏi
                        điền</a>
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
                                    echo "<span style='color: green; margin-left: 10px'><i class='fa-solid fa-circle-check'></i></span>";
                                }
                                echo "</li>";
                            }
                            echo "</ol></td>";
                        } else if ($value['type'] == 'Sắp xếp') {
                            echo "<td>";
                            $listAnswers = getAnswer($value['id']);
                            foreach ($listAnswers as $answer) {
                                echo "<li>" . $answer['ordinalNumber'] . ") " . htmlspecialchars($answer['answer']) . "</li>";
                            }
                            echo "</td>";
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
                            </div>
                            <div class="modal-body">
                                <div class="left">
                                    <h6> Đáp án :</h6>  <ol type="A">';
                        foreach ($listAnswers as $answer) {
                            echo "<li>" . $answer['answer'];
                            if ($answer['is_true'] == 1) {
                                echo "<span style='color: green; margin-left: 10px'><i class='fa-solid fa-circle-check'></i></span>";
                            }
                            echo "</li>";
                        }
                        echo '
                                    </ol>
                                </div>
                                <div class="right">
                                    ';
                        if (isset($value['image']) && $value['image'] != "") {
                            echo "
                        <button type='button' style='border:none; background:transparent;' data-bs-toggle='modal' data-bs-target='#imageModal" . $stt . "'>
                        <img src='../uploads/images/" . $value['image'] . "' alt='image' style=' margin-bottom: 10px;'>
                        </button>
                        <!-- Modal -->
                            <div class='modal fade' id='imageModal" . $stt . "' data-bs-backdrop='static' data-bs-keyboard='false' tabindex='-1' aria-labelledby='imageModalLabel' aria-hidden='true'>
                            <div class='modal-dialog modal-dialog-centered modal-dialog-scrollable'>
                                <div class='modal-content ' style='scale:1.1;'>
                                <div class='modal-header'>
                                   
                                    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                </div>
                                <div class='modal-body' >
                                <img src='../uploads/images/" . $value['image'] . "' class='img-fluid' alt='...'>
                                </div>
                               
                                </div>
                            </div>
                            </div>
                        ";
                        }
                        echo '
                                </div>
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
                    date_default_timezone_set('Asia/Ho_Chi_Minh');
                    $currentDateTime = date("Y-m-d H:i:s");
                    $checkApprove = approveQuestion($id);
                    if ($checkApprove == true) {
                        createNotificationForUser($nameCourse, "Câu hỏi của bạn đã được duyệt", $currentDateTime, $value['user_id']);
                        echo "<script>alert('Duyệt câu hỏi thành công')
                    </script>";
                    }
                }
                if (isset($_POST["btn-delete"])) {
                    $id = $_POST['id'];
                    if (isset(getQuestionById($id)['image']) && getQuestionById($id)['image'] != "") {
                        unlink("../uploads/images/" . getQuestionById($id)['image']);
                    }
                    $checkDelete = deleteQuestion($id);
                    if ($checkDelete) {
                        echo "<script>alert('Xóa câu hỏi thành công')
                    </script>";
                    }
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