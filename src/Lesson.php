<?php
include_once '../function.php';
session_start();

$currentUser = $_SESSION['currentUser'];
$course_id = urldecode($_GET['course_id']);
$course = getCourse($course_id);
$lessons = getListLesson($course_id);

if (isset($_GET['lesson_id'])) {
    $lesson_id = $_GET['lesson_id'];
} else {
    if (!empty($lessons)) {
        $lesson_id = $lessons[0]['id'];
    }
}

if (!empty($lesson_id)) {
    $lessonDetail = getLesson($lesson_id);
}
//thêm bài giảng
if (isset($_POST['add-lesson'])) {
    $lesson_name = $_POST['lesson-name'];
    $videoid = $_POST['videoid'];
    $numericalorder = $_POST['numericalorder'];
    $description = $_POST['description'];
    $course_id = $_GET['course_id'];
    $file = $_FILES['file'];

    $file_error = $file['error'];
    $file_name = $file['name'];
    $file_tmp = $file['tmp_name'];
    $file_size = $file['size'];
    $file_type = $file['type'];

    if (!empty($lesson_name) && !empty($videoid) && !empty($numericalorder)) {
        if ($file_error === 0) {
            if ($file_size < 100000000) {

                if (!is_dir('../uploads/files/' . $course_id . '_')) {
                    mkdir('../uploads/files/' . $course_id . '_', 0777, true);
                }
                $file_destination = '../uploads/files/' . $course_id . '_' . '/' . $file_name;
                move_uploaded_file($file_tmp, $file_destination);
                $result = addLesson($lesson_name, $videoid, $numericalorder, $description, $course_id, $file_name);
                if ($result) {
                    echo "<script>alert('Thêm bài giảng thành công')</script>";
                } else {
                    echo "<script>alert('Thêm bài giảng thất bại')</script>";
                }
                // Redirect after form submission
                header('refresh:0; url=lesson.php?course_id=' . $course_id);
                exit();
            } else {
                echo "<script>alert('File quá lớn')</script>";
            }
        } else {
            $result = addLesson($lesson_name, $videoid, $numericalorder, $description, $course_id, "");
            if ($result) {
                echo "<script>alert('Thêm bài giảng thành công')</script>";
            } else {
                echo "<script>alert('Thêm bài giảng thất bại')</script>";
            }
            // Redirect after form submission
            header('refresh:0; url=lesson.php?course_id=' . $course_id);
            exit();
        }
    } else {
        echo "<script>alert('Vui lòng điền đầy đủ thông tin')</script>";
    }






}

// sửa bài giảng
if (isset($_POST['edit-btn'])) {
    $lesson_name = $_POST['edit-lesson-name'];
    $videoid = $_POST['edit-videoid'];
    $numericalorder = $_POST['edit-numericalorder'];
    $description = $_POST['edit-description'];
    $course_id = $_GET['course_id'];
    $file = $_FILES['edit-file'];

    $file_error = $file['error'];
    $file_name = $file['name'];
    $file_tmp = $file['tmp_name'];
    $file_size = $file['size'];
    $file_type = $file['type'];

    if (!empty($lesson_name) && !empty($videoid) && !empty($numericalorder)) {
        if ($file_error === 0) {
            if ($file_size < 100000000) {

                if (!is_dir('../uploads/files/' . $course_id . '_')) {
                    mkdir('../uploads/files/' . $course_id . '_', 0777, true);
                }
                $file_destination = '../uploads/files/' . $course_id . '_' . '/' . $file_name;
                move_uploaded_file($file_tmp, $file_destination);
                $result = editLesson($lesson_name, $videoid, $numericalorder, $description, $lesson_id, $file_name);
                if ($result) {
                    echo "<script>alert('Sửa bài giảng thành công')</script>";
                } else {
                    echo "<script>alert('Sửa bài giảng thất bại')</script>";
                }
                // Redirect after form submission
                header('refresh:0; url=lesson.php?course_id=' . $course_id . '&lesson_id=' . $lesson_id);
                exit();
            } else {
                echo "<script>alert('File quá lớn')</script>";
            }
        } else {
            $result = editLesson($lesson_name, $videoid, $numericalorder, $description, $lesson_id, "");
            if ($result) {
                echo "<script>alert('Sửa bài giảng thành công')</script>";
            } else {
                echo "<script>alert('Sửa bài giảng thất bại')</script>";
            }
            // Redirect after form submission
            header('refresh:0; url=lesson.php?course_id=' . $course_id . '&lesson_id=' . $lesson_id);
            exit();
        }
    } else {
        echo "<script>alert('Vui lòng điền đầy đủ thông tin')</script>";

    }


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
    <!-- Begin bootstrap cdn -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="	sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <!-- End bootstrap cdn -->
    <script src="https://kit.fontawesome.com/772918bb67.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <title>Lesson</title>
    <style>
        .list-group ul {
            padding: 0;
            list-style-type: none;
        }

        .list-group ul li {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            margin-bottom: 10px;
        }



        .content {
            /* margin-left: 400px; */
            width: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 20px;


        }

        .description {
            margin-top: 20px;
            width: 500px;
            height: max-content !important;
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 10px;
        }


        .ratio iframe {
            border-radius: 10px;
        }

        .edit {
            position: absolute;
            left: 20px;
            bottom: 10px;
            width: 50px;
            height: 50px;
            background-color: transparent;
            border: none;
            cursor: pointer;
            outline: 1px solid #ccc;
            border-radius: 50%;
            padding: 10px;
            box-shadow: 0 0 10px #ccc;
        }
    </style>
</head>

<body>
    <?php include 'navbar.php'; ?>

    <main>
        <button class="btn mt-4 ms-4" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasScrolling"
            aria-controls="offcanvasScrolling"><i class="fa-solid fa-bars"></i></button>

        <div class="offcanvas offcanvas-start" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1"
            id="offcanvasScrolling" aria-labelledby="offcanvasScrollingLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasScrollingLabel">
                    <?php
                    echo $course['course'];
                    ?>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <?php
                if ($_SESSION['currentUser']['role'] == 1) {
                    echo '<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Thêm
                        bài
                        giảng</button>
                       
                        ';
                }
                ?>


                <!-- modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Bài Giảng Mới</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form method="POST" id='form-add-lesson' enctype="multipart/form-data">
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="lesson-name" class="col-form-label">Tên bài giảng:</label>
                                        <input type="text" class="form-control" id="lesson-name" name="lesson-name">
                                    </div>
                                    <div class="mb-3">
                                        <label for="videoid" class="col-form-label">Video ID:</label>
                                        <input type="text" class="form-control" id="videoid" name="videoid">
                                    </div>
                                    <div class="mb-3">
                                        <label for="numericalorder" class="col-form-label">Số thứ tự bài giảng:</label>
                                        <input type="text" class="form-control" id="numericalorder"
                                            name="numericalorder">
                                    </div>
                                    <div class="mb-3">
                                        <label for="description" class="col-form-label">Mô tả:</label>
                                        <textarea class="form-control" id="description" name="description"></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="tailieu">Tài liệu</label>
                                        <input class="form-control" type="file" name="file" id="tailieu">
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Đóng</button>
                                    <input type="submit" class="btn btn-primary" value="Thêm bài giảng"
                                        name='add-lesson'>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
                <!-- list lesson -->
                <div class="list-group mt-4">

                    <?php
                    foreach ($lessons as $lesson) {
                        echo '
                        <div style="display:flex;" class="mb-4">
                        <a style="border-radius:10px;min-height:100px;" href="/cnwQuizz/src/Lesson.php?course_id=' . urlencode($course_id) . '&lesson_id=' . urlencode($lesson['id']) . '" class="list-group-item list-group-item-action ';
                        if ($lesson['id'] == $lesson_id) {
                            echo ' active';
                        }
                        echo ' " aria-current="true">
                        <div  class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1">' . $lesson['name'] . '</h5>
                            <small>3 days ago</small>
                        </div>
                        <p class="mb-1 text-truncate">' . $lesson['description'] . '</p>
                        <small>And some small print.</small>
                        </a>';
                        if ($_SESSION['currentUser']['role'] == 1) {
                            echo '
                        <a href="/cnwQuizz/src/DeleteLesson.php?course_id=' . urlencode($course_id) . '&id=' . urlencode($lesson['id']) . '" class="btn" style="border:none;background:transparent;"><i class="fa-solid fa-trash-can btn btn-danger"></i></a>';
                        }
                        echo '
                        </div>
                        ';
                    }
                    ?>

                </div>

            </div>
        </div>
        <div style="display:flex;justify-content:center;padding: 10px; ">
            <?php
            if (!empty($lessonDetail)) {
                echo "
                <div>
                <div class='description'>
                    <h1>Tài Liệu</h1>
                    <a href='/cnwQuizz/uploads/files/" . $course_id . "_" . "/" . $lessonDetail['file'] . "'>" . $lessonDetail['file'] . "</a>
                       
                </div>
                <div class='description'>
                    <h1>Mô Tả</h1>
                    " . $lessonDetail['description'] . "
                </div>
                </div>
                <div class='content'>
                    <div class='ratio ratio-16x9'>
                        <iframe src='https://www.youtube.com/embed/" . $lessonDetail['video'] . "?autoplay=1'
                            title='YouTube video player' frameborder='0'
                            allow='accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share'
                            allowfullscreen></iframe>
                    </div>
                    ";

                if ($_SESSION['currentUser']['role'] == 1) {
                    echo "
                    <button type='button' class='edit' data-bs-target='#editModal' data-bs-toggle='modal' >
                    <i class='fa-solid fa-pen'></i>
                    </button>

                    <div class='modal fade' id='editModal' tabindex='-1' aria-labelledby='exampleModalLabel'
                    aria-hidden='true'>
                    <div class='modal-dialog'>
                        <div class='modal-content'>
                            <div class='modal-header'>
                                <h1 class='modal-title fs-5' id='exampleModalLabel'>Chỉnh sửa</h1>
                                <button type='button' class='btn-close' data-bs-dismiss='modal'
                                    aria-label='Close'></button>
                            </div>
                            <form method='POST' enctype='multipart/form-data' >
                            <div class='modal-body'>
                                    <div class='mb-3'>
                                        <label for='lesson-name' class='col-form-label'>Tên bài giảng:</label>
                                        <input type='text' class='form-control' id='lesson-name' name='edit-lesson-name' value='" . $lessonDetail['name'] . "'>
                                    </div>
                                    <div class='mb-3'>
                                        <label for='videoid' class='col-form-label'>Video ID:</label>
                                        <input type='text' class='form-control' id='videoid' name='edit-videoid' value='" . $lessonDetail['video'] . "'>
                                    </div>
                                    <div class='mb-3'>
                                        <label for='numericalorder' class='col-form-label'>Số thứ tự bài giảng:</label>
                                        <input type='text' class='form-control' id='numericalorder'
                                            name='edit-numericalorder' value='" . $lessonDetail['numericalorder'] . "'>
                                    </div>
                                    <div class='mb-3'>
                                        <label for='tailieu'>Tài liệu</label>
                                        <input class='form-control' type='file' name='edit-file'  id='tailieu'>
                                    </div>
                                    <div class='mb-3'>
                                        <label for='description' class='col-form-label'>Mô tả:</label>
                                        <textarea class='form-control' id='description' name='edit-description'>" . $lessonDetail['description'] . "</textarea>
                                    </div>

                            </div>
                            <div class='modal-footer'>
                                <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Đóng</button>
                                <input type='submit' name='edit-btn' class='btn btn-primary' value='Lưu thay đổi'/>
                            </div>
                            </form>

                        </div>
                    </div>";
                }
                echo "
                </div>
                </div>   
                ";
            } else {
                echo "<h1>Chưa có bài giảng nào</h1>";
            }


            ?>
        </div>
    </main>

    <script>
        function addLesson() {
            var form = document.getElementById('form-add-lesson');
            form.submit();
        }
        document.addEventListener('DOMContentLoaded', function () {
            var myOffcanvas = new bootstrap.Offcanvas(document.getElementById('offcanvasScrolling'));
            myOffcanvas.show();
        });




    </script>
</body>

</html>