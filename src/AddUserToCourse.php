<?php
include '../function.php';
session_start();
$currentUser = $_SESSION['currentUser'];
$course_id = $_GET['id'];
$userInCourse = getUsersInCourse($course_id);
$users = getAllUser();
if ($currentUser['role'] != 1) {
    header("Location: courses.php");
}
$check = isUserEnrolled($currentUser['id'], $course_id);
if (!$check) {
    header("location: courses.php");
}
// echo "<pre>";
// print_r($userInCourse);
// echo "<pre>";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm người dùng vào khóa học</title>
    <!-- Begin bootstrap cdn -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="	sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <!-- End bootstrap cdn -->

</head>

<body>
    <?php
    include 'navbar.php';
    ?>
    <main style=" max-width: 100%;">
        <div id="action" style="margin: 20px 0 0 13%;">
            <a href="UserManagerment.php?course_id=<?php echo $course_id ?>" class="btn btn-primary">Trở lại</a>
        </div>
        <form action="" method="POST">
            <div style="margin: 20px 13%;">
                <div class="form-group">
                    <label for="name_quiz"><span style="color: red;">*</span>Nhập username</label>
                    <input class="form-control" type="text" name="username" id="" value="<?php
                    echo isset($_POST['username']) ? $_POST['username'] : "";
                    ?>">
                </div>
                <div style="margin: 20px 0 0 0;" class="d-grid">
                    <input class="btn btn-primary btn-block" name="btn" type="submit" value="Thêm vào khóa học">
                </div>
            </div>
        </form>

    </main>

    <?php
    if (isset($_POST['btn'])) {
        $username = $_POST['username'];

        if (!empty($username)) {
            // Kiểm tra xem người dùng đã ở trong khóa học chưa
            $userExistsInCourse = false;
            foreach ($userInCourse as $u) {
                if ($u['username'] == $username) {
                    if ($u['state'] == 1) {
                        $userExistsInCourse = true;
                        break;
                    } else {
                        $userExistsInCourse = false;
                    }
                }
            }

            if ($userExistsInCourse) {
                echo "<div class='alert alert-success text-center' role='alert'>Người dùng đã ở trong khóa học</div>";
            } else {
                // Kiểm tra xem người dùng có tồn tại hay không
                $uns = array_column($users, 'username');
                $userExists = in_array($username, $uns);

                if ($userExists) {
                    // Thêm người dùng vào khóa học
                    $result = addUserToCourse($username, $course_id);

                    if ($result) {
                        echo "<script>alert('Thêm thành công')
                                window.location.href = 'UserManagerment.php?course_id=" . $course_id . "';
                            </script>";
                    } else {
                        echo "<div class='alert alert-warning text-center' role='alert'>Thêm thất bại" . mysqli_error($conn) . "</div>";
                    }
                } else {
                    echo "<div class='alert alert-success text-center' role='alert'>Người dùng không tồn tại</div>";
                }
            }
        } else {
            echo "<div class='alert alert-success text-center' role='alert'>Vui lòng nhập đủ thông tin</div>";
        }
    }

    include 'footer.php';
    ?>
</body>

</html>