<?php
include '../function.php';
session_start();
$course_id = $_GET['course_id'];
$currentUser = $_SESSION['currentUser'];
$course = getCourse($course_id);
$nameCourse = $course['course'];
if (isset($_POST['btn-state']) or isset($_POST['btn-delete'])) {
    header("Refresh:0");
}
$userInCourse = getUsersInCourse($course_id);
if ($currentUser['role'] != 1) {
    header("Location: courses.php");
}
// echo "<pre>";
// print_r($userInCourse);
// echo "</pre>";

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
    <title>Quản lý người dùng trong khóa học</title>
    <!-- Begin bootstrap cdn -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="	sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <!-- End bootstrap cdn -->
    <script src="https://kit.fontawesome.com/772918bb67.js" crossorigin="anonymous"></script>
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
            <p class="h3">Quản lý người dùng trong khóa học
                <?php echo $nameCourse; ?>
            </p>
            <a href="courses.php" class="btn btn-primary"><i class="fa-solid fa-arrow-left"></i></a>
            <a href='AddUserToCourse.php?id=<?php echo $course_id; ?>' class='btn btn-primary'>Thêm người
                dùng</a>


        </div>
        <div class="d-flex flex-wrap flex-column align-items-center" style="padding: 1%;margin: 5% 0 0 0; ">
            <p class="h3">Danh sách sinh viên</p>
            <table class="table table-striped">
                <tr>
                    <th>STT</th>
                    <th>Username</th>
                    <th>Họ và tên</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                </tr>
                <?php
                $stt = 0;
                if ($userInCourse) {
                    foreach ($userInCourse as $key => $value) {
                        $stt++;
                        echo "<tr>";
                        echo "<td>" . $stt . "</td>";
                        echo "<td>" . $value['username'] . "</td>";
                        echo "<td>" . $value['fullname'] . "</td>";
                        echo "<form method='POST'>";
                        if ($value['state'] == 0) {
                            echo "<td>Chờ duyệt</td>";
                            echo "<td>
                            <input type='hidden' value='" . $value['user_id'] . "' name='id'/>
                            <input type='submit' class='btn btn-success' value='Duyệt' name='btn-state'>
                            <input type='submit' name='btn-delete' value='Xóa' class='btn btn-danger'/>
                            </td>";
                        } else {
                            echo "<td>Đã duyệt</td>";
                            echo "<td>
                            <input type='hidden' value='" . $value['user_id'] . "' name='id'/>
                            <input type='submit' name='btn-delete' value='Xóa' class='btn btn-danger'/>
                         </td>";
                        }

                        echo "</form></tr>";
                    }
                } else {
                    echo "<tr>
                        <td colspan='7' align='center'><h1>Chưa có yêu cầu</h1></td>
                    </tr>";
                }

                if (isset($_POST['btn-state'])) {
                    $id = $_POST['id'];
                    $check = approveUserInCourse($id, $course_id);
                    if ($check) {
                        echo "<script>alert('Duyệt người dùng thành công')
                    </script>";
                    }
                }

                if (isset($_POST['btn-delete'])) {
                    $id = $_POST['id'];
                    $checkDelete = deleteUserInCourse($id, $course_id);
                    if ($checkDelete) {
                        echo "<script>alert('Xóa người dùng thành công')
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