<?php
session_start();
header('Content-Type: application/json');

$conn = new mysqli('localhost', 'username', 'password', 'school_exam_system');

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

$role = $_SESSION['role'];
$user_id = $_SESSION['user_id'];

if ($role == 'admin' || $role == 'dos' || $role == 'instructor') {
    $stmt = $conn->prepare('SELECT * FROM exams WHERE creator_id = ?');
    $stmt->bind_param('i', $user_id);
} else if ($role == 'student') {
    $stmt = $conn->prepare('SELECT exams.id, exams.title, exams.description FROM exams JOIN results ON exams.id = results.exam_id WHERE results.student_id = ?');
    $stmt->bind_param('i', $user_id);
}

$stmt->execute();
$result = $stmt->get_result();
$exams = [];

while ($row = $result->fetch_assoc()) {
    $exams[] = $row;
}

echo json_encode($exams);

$stmt->close();
$conn->close();
?>
