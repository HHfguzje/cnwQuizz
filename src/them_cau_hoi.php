<?php
include '../function.php';
session_start();
$currentUser = $_SESSION['currentUser'];
$id_khoa_hoc = $_GET['id_khoa_hoc'];

$course = getCourse($id_khoa_hoc);
$nameCourse = $course['name'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm câu hỏi</title>
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
    // include 'navbar.php';
    ?>
    <main style="min-height: 100vh; max-width: 100%;">
        <div id="action" style="margin: 20px 0 0 13%;">
            <p class="h3">Khóa học
                <?php echo $nameCourse; ?>
            </p>
            <a href="bien_tap.php?id_khoa_hoc=<?php echo $id_khoa_hoc ?>" class="btn btn-primary">Trở lại</a>
            <form action="" method="POST" enctype="multipart/form-data">
        </div>
        <div style="margin: 20px 13%;">
            <div class="form-group">
                <label for="name_quiz"><span style="color: red;">*</span>Nhập tên câu hỏi</label>
                <input class="form-control" type="text" name="ten_cau_hoi" id="" value="<?php
                echo isset($_POST['ten_cau_hoi']) ? $_POST['ten_cau_hoi'] : "";
                ?>">
            </div>
            <div class="form-group">
                <label for="name_quiz">Ảnh cho câu hỏi</label>
                <input class="form-control" type="file" name="file_tai_len" id=""
                    accept="image/png, image/jpeg, image/jpg">
            </div>
            <div class="form-group">
                <label for="name_quiz">Dạng câu hỏi</label>
                <input class="form-control" value="Điền" readonly type="text" name="dang_cau_hoi" id="" value="<?php
                echo isset($_POST['dang_cau_hoi']) ? $_POST['dang_cau_hoi'] : "";
                ?>">
            </div>
            <div style='margin: 20px 0 0 0;' class='input-group mb-3'>
                <input name='da' type='text' class='form-control' placeholder='Nhập đáp án' value="<?php
                echo isset($_POST['da']) ? $_POST['da'] : "";
                ?>">
            </div>
            <?php
            // bạn code vào đây
            if (isset($_POST['btn'])) {
                $ten_cau_hoi = $_POST['ten_cau_hoi'];
                $dang_cau_hoi = $_POST['dang_cau_hoi'];
                $da = $_POST['da'];
                $state = 0;
                if ($currentUser['role'] == 1) {
                    $state = 1;
                }


                if (isset($_FILES['file_tai_len']) && $_FILES['file_tai_len']['error'] != 4) {
                    $tmp_name = $_FILES['file_tai_len']['tmp_name'];
                    move_uploaded_file($tmp_name, "../images/" . $_FILES['file_tai_len']['name']);
                    $file_tai_len = 'images/' . $_FILES['file_tai_len']['name'];
                } else {
                    $file_tai_len = "";
                }

                $result = createQuestion($ten_cau_hoi, $file_tai_len, $dang_cau_hoi, $da, $id_khoa_hoc, $currentUser['id_user'], $state);
                if ($result) {
                    echo "<div class='alert alert-success text-center' role='alert'>Thêm câu hỏi thành công</div>";

                } else {
                    echo "<div class='alert alert-warning text-center' role='alert'>Thêm câu hỏi thất bại</div>";
                }
            }
            // ......
            

            // mẫu thông báo thêm câu hỏi thành công và thất bại
            // <div class="alert alert-warning text-center" role="alert">Thêm câu hỏi thất bại</div>
            // <div class="alert alert-success text-center" role="alert">Thêm câu hỏi thành công</div>
            
            ?>


            <div style="margin: 20px 0 0 0;" class="d-grid">
                <input class="btn btn-primary btn-block" name="btn" type="submit" value="Thêm câu hỏi">
            </div>

        </div>
        </form>

    </main>

    <?php
    // include 'footer.php'; 
    ?>

</body>


</html>