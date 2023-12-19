<?php
// session_start();
$currentUser = $_SESSION['currentUser'];
$listNotification = getNotificationsByUserId($currentUser['id']);
$read = 0;
foreach ($listNotification as $notification) {
  if ($notification['is_read'] == 1) {
    $read++;
  }
}
if (!isLogin()) {
  header("Location: login.php");
}
?>
<nav class="navbar navbar-expand-lg navbar-light bg-light px-2">
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
            <?php echo $_SESSION['currentUser']['fullname']; ?>
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <li><a class="dropdown-item" href="SelfCourse.php">Khóa học của tôi</a></li>
            <li><a class="dropdown-item" href="ChangePassword.php">Đổi mật khẩu</a></li>
            <li><a class="dropdown-item" href="logout.php">Đăng xuất</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="SelfCourse.php">Khóa học của tôi</a>
        </li>
        <!-- Tất cả khóa học -->
        <li class="nav-item">
          <a class="nav-link" href="courses.php">Tất cả khóa học</a>
        </li>
        <?php if ($currentUser['role'] == 1) { ?>
          <li class='nav-item dropdown'>
            <a class='nav-link dropdown-toggle active' href='#' id='adminDropdownMenuLink' role='button'
              data-bs-toggle='dropdown' aria-expanded='false'>
              Quản trị
            </a>
            <ul class='dropdown-menu' aria-labelledby='adminDropdownMenuLink'>
              <li><a class='dropdown-item' href='CourseManagement.php'>Quản lý khóa học</a></li>
              <li><a class='dropdown-item' href='NotificationManagement.php'>Quản lý thông báo</a></li>
              <li class='dropdown'>
                <a class='dropdown-item dropdown-toggle' href='#' role='button' data-bs-toggle='dropdown'
                  aria-expanded='false'>
                  Quản lý kì thi
                </a>
                <ul class='dropdown-menu'>
                  <li><a class='dropdown-item' href='UserManagerment.php?course_id=100'>Quản lý người thi</a></li>
                  <li><a class='dropdown-item' href='Result.php?course_id=100'>Thống kê kết quả</a></li>
                </ul>
              </li>
            </ul>
          </li>
        <?php } ?>
      </ul>
    </div>
    <div class="notification-badge" data-badge="3">
      <button type="button" class="btn btn-white " style="scale: 1.5;" data-bs-toggle="modal"
        data-bs-target="#noticationModal"><i class="fa-regular fa-bell"></i></button>
      <span class="badge bg-primary rounded-pill">
        <?php echo count($listNotification) - $read; ?>
      </span>
    </div>

    <div class="modal fade" id="noticationModal" tabindex="-1" aria-labelledby="noticationModalLabel"
      aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="noticationModalLabel">Thông Báo</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="list-group list-group-flush">

              <?php
              $listNotification = getNotifications();
              foreach ($listNotification as $notification) {
                echo '
              <a href="#" class="list-group-item list-group-item-action " aria-current="true">
                <div class="d-flex w-100 justify-content-between">
                <h5 class="mb-1">' . $notification['tittle'] . '</h5>
                <small>3 days ago</small>
              </div>
              <p class="mb-1 text-truncate">' . $notification['description'] . '</p>
              </a>
             
              ';
              }
              ?>
            </div>

          </div>

        </div>
      </div>
    </div>
  </div>
</nav>