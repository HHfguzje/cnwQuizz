<?php
include 'connectdb.php';
//Đăng ký
function isUsernameExists($username)
{
    global $conn;
    $sql = "SELECT * FROM user WHERE username = '$username'";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);
    return $user ? true : false;
}
function validateRegister($username, $password, $fullname)
{
    $errors = array();
    if (strlen($username) < 6 || strlen($username) > 16) {
        $errors[] = "Username phải từ 6 đến 16 ký tự";
    }
    if (strlen($password) < 8 || strlen($password) > 20) {
        $errors[] = "Password phải từ 8 đến 20 ký tự";
    }
    if (empty($fullname)) {
        $errors[] = "Không được để trống họ tên";
    }
    if (isUsernameExists($username)) {
        $errors[] = "Tên đăng nhập đã tồn tại, vui lòng chọn tên khác";
    }
    return $errors;
}

function register($username, $password, $fullname)
{
    global $conn;
    $validationErrors = validateRegister($username, $password, $fullname);
    if (!empty($validationErrors)) {
        return $validationErrors;
    }
    $md5Password = md5($password);
    $sql = "INSERT INTO user(username, password, fullname, role) VALUES ('$username', '$md5Password', '$fullname', '0')";
    $result = mysqli_query($conn, $sql);
    return $result;
}

//Đăng nhập
function checkLogin($username, $password)
{
    global $conn;
    $md5Password = md5($password);
    $sql = "SELECT * FROM user WHERE username = '$username' AND password = '$md5Password'";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);
    // var_dump($user);
    if ($user) {
        return $user;
    } else {
        return false;
    }
}
function isLogin()
{
    if (isset($_SESSION['currentUser']) && !empty($_SESSION['currentUser'])) {
        return true;
    }
    return false;
}

function getFullname($id)
{
    global $conn;
    $sql = "SELECT fullname from user WHERE id = '$id'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $user = mysqli_fetch_assoc($result);
        return $user ? $user['fullname'] : false;
    } else {
        die("Query failed: " . mysqli_error($conn));
    }
}
//đổi mật khẩu
function validateChangePassword($oldPassword, $newPassword, $confirmPassword)
{
    $errors = array();
    if (empty($oldPassword) || empty($newPassword) || empty($confirmPassword)) {
        $errors[] = "Vui lòng nhập đầy đủ thông tin.";
    }
    if (md5($oldPassword) != $_SESSION['currentUser']['password']) {
        $errors[] = "Mật khẩu cũ không chính xác.";
    }
    if (strlen($newPassword) < 8 || strlen($newPassword) > 20) {
        $errors[] = "Mật khẩu mới phải từ 8 đến 20 ký tự.";
    }
    if ($newPassword !== $confirmPassword) {
        $errors[] = "Mật khẩu mới và xác nhận mật khẩu không khớp.";
    }
    if ($oldPassword === $newPassword) {
        $errors[] = "Mật khẩu mới phải khác mật khẩu cũ.";
    }
    return $errors;
}

function updatePassword($username, $newPassword)
{
    global $conn;
    $sql = "UPDATE user SET password = '$newPassword' WHERE username = '$username'";
    return mysqli_query($conn, $sql);
}
//Khóa học
function getAllCourses()
{
    global $conn;
    $sql = "SELECT * FROM courses";
    $result = mysqli_query($conn, $sql);
    $courses = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $courses;
}

function getCourse($id)
{
    global $conn;
    $sql = "SELECT course FROM courses WHERE id = '$id'";
    $result = mysqli_query($conn, $sql);
    $course = mysqli_fetch_assoc($result);
    return $course;
}

function getQuestionsByCourseId($id)
{
    global $conn;
    $sql = "SELECT *
            FROM questions q
            WHERE course_id = '$id'";
    $result = mysqli_query($conn, $sql);
    $listQuestion = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $listQuestion;
}


function createQuestionAndAnswers($questionName, $typeQuestion, $image, $course_id, $answer, $is_true)
{
    global $conn;
    $userId = $_SESSION['currentUser']['id'];
    $state = 0;
    $sqlQuestion = "INSERT INTO questions (question, type, course_id, image, user_id, state)
                    VALUES ('$questionName', '$typeQuestion', '$course_id', '$image', $userId, $state)";
    $resultQuestion = mysqli_query($conn, $sqlQuestion);

    if ($resultQuestion) {
        $questionId = mysqli_insert_id($conn);
        $sqlAnswers = "INSERT INTO answers (question_id, answer, is_true)
                       VALUES ($questionId, '$answer', '$is_true')";

        $resultAnswers = mysqli_query($conn, $sqlAnswers);

        return $resultAnswers;
    } else {
        return false;
    }
}
//dạng trắc nghiệm

function createQuestionChoice($questionName, $typeQuestion, $image, $course_id, $answer)
{
    global $conn;
    $userId = $_SESSION['currentUser']['id'];
    $state = 0;
    $sqlQuestion = "INSERT INTO questions (question, type, course_id, image, user_id, state)
                    VALUES ('$questionName', '$typeQuestion', '$course_id', '$image', $userId, $state)";
    $resultQuestion = mysqli_query($conn, $sqlQuestion);
    if ($resultQuestion) {
        $questionId = mysqli_insert_id($conn);
        foreach ($answer as $key => $value) {
            $sqlAnswers = "INSERT INTO answers (question_id, answer, is_true)
                           VALUES ($questionId, '$value[answer]', $value[is_true])";
            $resultAnswers = mysqli_query($conn, $sqlAnswers);

        }
        return $resultAnswers;
    }
}
function approveQuestion($questionId)
{
    global $conn;
    $sql = "UPDATE  questions SET state = '1' WHERE id = '$questionId'";
    $result = mysqli_query($conn, $sql);
    return $result;
}

function approveCourse($courseId)
{
    global $conn;
    $sql = "UPDATE courses SET state = '1' WHERE id = '$courseId'";
    $result = mysqli_query($conn, $sql);
    return $result;
}
function hiddenCourse($courseId)
{
    global $conn;
    $sql = "UPDATE courses SET state = '0' WHERE id = '$courseId'";
    $result = mysqli_query($conn, $sql);
    return $result;
}
function deleteQuestion($questionId)
{
    global $conn;
    // Xóa bản ghi trong bảng answers
    $sqlDeleteAnswers = "DELETE FROM answers WHERE question_id = $questionId";
    mysqli_query($conn, $sqlDeleteAnswers);
    // Xóa bản ghi trong bảng questions
    $sqlDeleteQuestion = "DELETE FROM questions WHERE id = $questionId";
    mysqli_query($conn, $sqlDeleteQuestion);

}

function deleteCourse($courseId)
{
    global $conn;
    $sql = "DELETE FROM courses WHERE id = '$courseId'";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }
}


function getQuestionsForQUizz($id)
{
    global $conn;
    $sql = "SELECT *
            FROM questions q
            WHERE q.course_id = '$id' && q.state = 1
            ORDER BY rand() limit 10";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $listQuestion = mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
        die("Query failed: " . mysqli_error($conn));
    }
    return $listQuestion;
}

function getQuestionsForExam()
{
    global $conn;
    $sql = "SELECT *
            FROM questions q
            WHERE q.state = 1
            ORDER BY rand() limit 20";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $listQuestion = mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
        die("Query failed: " . mysqli_error($conn));
    }
    return $listQuestion;
}

function getAnswer($question_id)
{
    global $conn;
    $sql = "SELECT * FROM answers WHERE question_id = $question_id";
    $result = mysqli_query($conn, $sql);
    $a = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $a;
}

function getCorrectAnswer($questionId)
{
    global $conn;
    $sql = "SELECT answer FROM answers WHERE question_id = $questionId AND is_true = 1";
    $result = mysqli_query($conn, $sql);
    $trueAnswer = mysqli_fetch_assoc($result);
    return $trueAnswer;
}

function getResultByUserandCourseId($userId, $courseId)
{
    global $conn;
    $sql = "SELECT * FROM result WHERE user_id = $userId AND course_id= $courseId ";
    $result = mysqli_query($conn, $sql);
    $listResult = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $listResult;
}

function getResultByCourseId($courseId)
{
    global $conn;
    $sql = "SELECT * FROM result WHERE course_id= $courseId ";
    $result = mysqli_query($conn, $sql);
    $listResult = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $listResult;
}

function createCourse($courseName)
{
    global $conn;

    // Thêm khóa học
    $state = 0;
    $sql = "INSERT INTO courses (course, state) VALUES ('$courseName', '$state')";
    $result = mysqli_query($conn, $sql);

    // Lấy ID của khóa học vừa thêm
    $courseId = mysqli_insert_id($conn);

    // Thêm tài khoản admin vào khóa học
    $adminUserId = 3; // ID của tài khoản admin
    $sqlAddAdminToCourse = "INSERT INTO course_users (course_id, user_id, state) VALUES ('$courseId', '$adminUserId', 1)";
    $resultAddAdminToCourse = mysqli_query($conn, $sqlAddAdminToCourse);

    return $result && $resultAddAdminToCourse;
}

function saveResult($userId, $score, $courseId, $timeSubmit)
{
    global $conn;
    $sql = "INSERT INTO result (user_id, score, course_id, timeSubmit) VALUES ($userId, $score, $courseId, '$timeSubmit')";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }
    return $result;
}

function getQuestionsByUserId($userId, $courseId)
{
    global $conn;
    $sql = "SELECT * FROM questions q WHERE course_id = '$courseId' and user_id='$userId'";
    $result = mysqli_query($conn, $sql);
    $listQuestion = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $listQuestion;
}

function getRank()
{
    global $conn;
    $sql = "SELECT u.fullname, r.score, r.timeSubmit 
        FROM user u 
        JOIN result r ON u.id = r.user_id 
        WHERE r.course_id = 9
        ORDER BY r.score DESC";
    $result = mysqli_query($conn, $sql);
    $rank = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $rank;
}

function createSortingQuestion($questionName, $course_id, $answer)
{
    global $conn;
    $userId = $_SESSION['currentUser']['id'];
    $sqlQuestion = "INSERT INTO questions (question, type, course_id, user_id, state)
                    VALUES ('$questionName', 'Sắp xếp', '$course_id', $userId, 0)";
    $resultQuestion = mysqli_query($conn, $sqlQuestion);
    // if (!$resultQuestion) {
    //     echo "Error in answers query: " . mysqli_error($conn);
    // }
    if ($resultQuestion) {
        $questionId = mysqli_insert_id($conn);
        foreach ($answer as $value) {
            $sqlAnswers = "INSERT INTO answers (question_id, answer, ordinalNumber, is_true)
                           VALUES ($questionId, '$value[answer]', '$value[ordinal]', 1)";
            $resultAnswers = mysqli_query($conn, $sqlAnswers);
            if (!$resultAnswers) {
                // Nếu có lỗi trong quá trình thêm câu trả lời, hãy xóa câu hỏi đã thêm và trả về false
                mysqli_query($conn, "DELETE FROM questions WHERE id = $questionId");
                return false;
            }

        }
        return true;
    }
    return false;
}
function getRandomAnswer($question_id)
{
    global $conn;
    $sql = "SELECT * FROM answers WHERE question_id = $question_id ORDER BY RAND()";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $a = mysqli_fetch_all($result, MYSQLI_ASSOC);
        return $a;
    } else {
        die("Error: " . mysqli_error($conn));
    }
}
function getTrueAnswerInSortQuestion($questionId)
{
    global $conn;
    $sql = "SELECT answer FROM answers WHERE question_id = $questionId ORDER BY ordinalNumber";
    $result = mysqli_query($conn, $sql);
    $trueAnswer = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $trueAnswer;
}
function getNotifications()
{
    global $conn;
    $sql = "SELECT * FROM notifications";
    $result = mysqli_query($conn, $sql);
    $notifications = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $notifications;
}

function getNotificationsById($id)
{
    global $conn;
    $sql = "SELECT * FROM notifications WHERE id = $id";
    $result = mysqli_query($conn, $sql);
    $notification = mysqli_fetch_assoc($result);
    return $notification;
}

function createNotification($tittle, $description, $time)
{
    global $conn;
    $sql = "INSERT INTO notifications (tittle, description, time) VALUE ('$tittle', '$description', '$time')";
    $result = mysqli_query($conn, $sql);
    return $result;
}

function deleteNotification($id)
{
    global $conn;
    $sql = "DELETE FROM notifications WHERE id = $id";
    $result = mysqli_query($conn, $sql);
    return $result;
}

function updateNotification($id, $tittle, $description, $time)
{
    global $conn;
    $sql = "UPDATE notifications SET tittle = '$tittle', description = '$description', time = '$time' WHERE id = $id";
    $result = mysqli_query($conn, $sql);
    return $result;
}

function getUsersInCourse($courseId)
{
    global $conn;
    $sql = "SELECT cu.user_id, u.username, u.fullname, cu.state FROM user u
            JOIN course_users cu ON u.id = cu.user_id
            WHERE cu.course_id = '$courseId'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $users = mysqli_fetch_all($result, MYSQLI_ASSOC);
        return $users;
    } else {
        die("Error: " . mysqli_error($conn));
    }
}

function addUserToCourse($username, $courseId)
{
    global $conn;

    // Lấy ID của người dùng từ tên người dùng
    $sqlUserId = "SELECT id FROM user WHERE username = '$username'";
    $resultUserId = mysqli_query($conn, $sqlUserId);

    if ($resultUserId && mysqli_num_rows($resultUserId) > 0) {
        $row = mysqli_fetch_assoc($resultUserId);
        $userId = $row['id'];

        //Thêm người dùng vào khóa học
        $sql = "INSERT INTO course_users (state, course_id, user_id) VALUES (1, '$courseId', '$userId')";
        $result = mysqli_query($conn, $sql);

        return $result;
    } else
        die("Error: " . mysqli_error($conn));
}

function getAllUser()
{
    global $conn;
    $sql = "SELECT username FROM user";
    $result = mysqli_query($conn, $sql);
    $users = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $users;
}

function deleteUserInCourse($userId, $courseId)
{
    global $conn;
    $sql = "DELETE FROM course_users  WHERE user_id = '$userId' AND course_id = '$courseId'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        return true;
    } else {
        die("Error: " . mysqli_error($conn));
    }
}

function approveUserInCourse($userId, $courseId)
{
    global $conn;
    $sql = "UPDATE course_users cu SET cu.state = 1 WHERE cu.user_id = '$userId' AND cu.course_id = '$courseId'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        return true;
    } else {
        die("Error: " . mysqli_error($conn));
    }
}

function getApprovedCoursesForUser($userId)
{
    global $conn;

    $sql = "SELECT courses.course, courses.state, courses.id FROM courses
            INNER JOIN course_users ON courses.id = course_users.course_id
            WHERE course_users.user_id = '$userId' AND course_users.state = 1";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        $courses = mysqli_fetch_all($result, MYSQLI_ASSOC);
        return $courses;
    } else {
        die("Error: " . mysqli_error($conn));
    }
}

//kiem tra ng dung da duoc o trong khoa hoc hay chua
function isUserEnrolled($userId, $courseId)
{
    global $conn;
    $sql = "SELECT * FROM course_users WHERE user_id = '$userId' AND course_id = '$courseId' AND state = 1";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        return true;
    } else {
        return false;
    }
}

function isUserNotApproved($userId, $courseId)
{
    global $conn;
    $sql = "SELECT * FROM course_users WHERE user_id = '$userId' AND course_id = '$courseId' AND state = 0";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        return true;
    } else {
        return false;
    }
}

function enrollInTheCourse($userId, $courseId)
{
    global $conn;
    $sql = "INSERT INTO course_users (state, course_id, user_id) VALUES (0, '$courseId', '$userId')";
    $result = mysqli_query($conn, $sql);
    return $result;
}
function addLesson($lesson_name, $videoid, $numericalorder, $description, $course_id, $file_name)
{
    global $conn;
    $sql1 = "UPDATE lesson SET numericalorder = numericalorder + 1 WHERE numericalorder >= '$numericalorder' AND id_course = '$course_id'";
    $result1 = mysqli_query($conn, $sql1);
    if ($result1) {
        $sql = "INSERT INTO lesson (name, video, numericalorder, description, id_course, file) VALUES ('$lesson_name', '$videoid', '$numericalorder', '$description', '$course_id', '$file_name')";
        $result = mysqli_query($conn, $sql);
        return $result;
    } else {
        return false;
    }

}

function getListLesson($course_id)
{
    global $conn;
    $sql = "SELECT * FROM lesson WHERE id_course = '$course_id' ORDER BY numericalorder ASC";
    $result = mysqli_query($conn, $sql);
    $listLesson = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $listLesson;
}

function getLesson($id)
{
    global $conn;
    $sql = "SELECT * FROM lesson WHERE id = '$id'";
    $result = mysqli_query($conn, $sql);
    $lesson = mysqli_fetch_assoc($result);
    return $lesson;
}

function editLesson($lesson_name, $videoid, $numericalorder, $description, $id, $file_name)
{
    global $conn;
    $sql = "UPDATE lesson SET name = '$lesson_name', video = '$videoid', numericalorder = '$numericalorder', description = '$description', file = '$file_name' WHERE id = '$id'";
    $result = mysqli_query($conn, $sql);
    return $result;
}

function deleteLesson($id)
{
    global $conn;
    $sql = "DELETE FROM lesson WHERE id = '$id'";
    $result = mysqli_query($conn, $sql);
    return $result;
}

function getQuestionById($id)
{
    global $conn;
    $sql = "SELECT * FROM questions WHERE id = '$id'";
    $result = mysqli_query($conn, $sql);
    $question = mysqli_fetch_assoc($result);
    return $question;
}