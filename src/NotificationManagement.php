<?php
include_once "../function.php";
session_start();
$notifications = getNotifications();
$currentUser = $_SESSION['currentUser'];

if (isset($_POST['btn-state']) or isset($_POST['btn-delete']) or isset($_POST['btn-state-hidden'])) {
    header("Refresh:0");
}
if ($currentUser['role'] != 1) {
    header("Location: courses.php");
}
?>
<!DOCTYPE html>
<html lang="en	">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông báo</title>
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
    <?php include 'navbar.php'; ?>
    <main style="min-height: 100vh; width: 100%;">
        <div class="" style="text-align: center;">
            <h2>Quản lý thông báo</h2>
        </div>
        <style>
            .btn-primary:hover {
                background-color: #2980b9;
            }
        </style>

        <div class="align-items-center">
            <a href="Lesson.php" class="btn btn-primary">Trở lại</a>
            <button type="button" class="btn btn-primary">
                <a href="AddNotification.php" style="color: inherit; text-decoration: none;">Thêm thông báo</a>
            </button>
        </div>

        <div class="d-flex flex-wrap flex-column align-items-center" style="padding: 1%;margin: 5% 0 0 0; ">
            <table class="table table-striped">
                <tr>
                    <th>STT</th>
                    <th>Tiêu đề</th>
                    <th>Nội dung</th>
                    <th>Thời gian</th>
                    <th>Thao tác</th>
                </tr>
                <?php
                $i = 0;
                foreach ($notifications as $n) {
                    $i++;
                    echo "<tr>
                    <td>" . $i . "</td>
                    <td>" . $n['tittle'] . "</td>
                    <td>" . $n['description'] . "</td>
                    <td>" . $n['time'] . "</td>";
                    echo "<td>
                       <form method='GET' action='editNotification.php'>
                            <input type='hidden' value='" . $n['id'] . "' name='id'/>
                            <button type='submit' class='btn btn-success' title='Edit'>
                                <i class='bi bi-pencil'></i> Sửa
                            </button>
                        </form>
                        <form method='POST'>
                            <input type='hidden' value='" . $n['id'] . "' name='id'/>
                            <button type='submit' name='btn-delete' class='btn btn-danger' title='Delete'>
                                <i class='bi bi-trash'></i> Xóa
                            </button>
                        </form>
                    </td>";
                }
                if (isset($_POST['btn-delete'])) {
                    $id = $_POST['id'];
                    $check = deleteNotification($id);
                    if ($check) {
                        echo "<script>alert(Xóa thông báo thành công')
                         </script>";
                    }
                }
                ?>
            </table>
        </div>

        </div>
    </main>
    <?php include 'footer.php'; ?>
</body>


</html>