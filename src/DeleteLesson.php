<?php
include "../function.php";
$id = urldecode($_GET['id']);
$course_id = urldecode($_GET['course_id']);
$result = deleteLesson($id);
if ($result) {
    header("Location: Lesson.php?course_id=$course_id");
} else {
    echo "something wrong";
    header("Location: Lesson.php?course_id=$course_id");
}

?>