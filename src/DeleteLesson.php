<?php
include "../function.php";
$id = $_GET['id'];
$course_id = $_GET['course_id'];
$result = deleteLesson($id);
if ($result) {
    header("Location: Lesson.php?course_id=$course_id");
} else {
    echo "something wrong";
    header("Location: Lesson.php?course_id=$course_id");
}

?>