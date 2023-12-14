<?php
if (!isLogin()) {
  header("Location: login.php");
}
?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="courses.php">ProjectPHP K71</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
      aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle active" href="#" id="navbarDropdownMenuLink" role="button"
            data-bs-toggle="dropdown" aria-expanded="false">
            <?php
            echo $_SESSION['currentUser']['fullname'];
            ?>
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <?php
            if ($currentUser['role'] == 1) {
              echo "<li><a class='dropdown-item' href='CourseManagement.php'>Quản lý khóa học</a></li>";
              echo "<li><a class='dropdown-item' href='NotificationManagement.php'>Quản lý thông báo</a></li>";
            } ?>
            <li><a class="dropdown-item" href="SelfCourse.php">Khóa học của tôi</a></li>
            <li><a class="dropdown-item" href="ChangePassword.php">Đổi mật khẩu</a></li>
            <li><a class="dropdown-item" href="logout.php">Đăng xuất</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>