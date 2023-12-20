<?php
include '../function.php';
session_start();
$currentUser = $_SESSION['currentUser'];
$course_id = $_GET['id'];
$courseName = getCourse($course_id)['course'];
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
    <script src="https://kit.fontawesome.com/772918bb67.js" crossorigin="anonymous"></script>

</head>

<body>
    <?php
    include 'navbar.php';
    ?>
    <main style=" max-width: 100%;">
        <div id="action" style="margin: 20px 0 0 13%;">
            <a href="UserManagerment.php?course_id=<?php echo $course_id ?>" class="btn btn-primary"><i
                    class="fa-solid fa-arrow-left"></i></a>
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
                    $user = isUsernameExists($username);
                    $user_id = $user['id'];

                    if ($result) {
                        date_default_timezone_set('Asia/Ho_Chi_Minh');
                        $currentDateTime = date("Y-m-d H:i:s");
                        createNotificationForUser($courseName, "Bạn đã được thêm vào khóa học", $currentDateTime, $user_id);
                        echo "<script>alert('Thêm thành công')
                                window.location.href = 'UserManagerment.php?course_id=" . $course_id . "';
                            </script>";
                    } else {
                        echo "<script>alert('Thêm thất bại')
                            </script>";
                    }
                } else {
                    echo "<script>alert('Người dùng không tồn tại')
                            </script>";
                }
            }
        } else {
            echo "<script>alert('Vui lòng nhập đủ thông tin')
                            </script>";
        }
    }

    include 'footer.php';
    ?>
</body>

</html>