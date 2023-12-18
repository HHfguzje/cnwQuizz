<?php
include "../function.php";
$id = urldecode($_GET['id']);
$course_id = urldecode($_GET['course_id']);
$result = deleteLesson($id);
if ($result) {
    echo "<script>alert('Xóa bài giảng thành công')
          window.location.href = 'Lesson.php?course_id=" . $course_id . "';
                    </script>";
} else {
    echo "<script>alert('Xóa bài giảng thất bại')
    window.location.href = 'Lesson.php?course_id=" . $course_id . "';
                    </script>";
}

?>