<?php
session_start();
header('Content-Type: application/json');

$conn = new mysqli('localhost', 'username', 'password', 'exam_system_db');

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

$title = $_POST['title'];
$description = $_POST['description'];
$creator_id = $_SESSION['user_id'];

$stmt = $conn->prepare('INSERT INTO exams (title, description, creator_id) VALUES (?, ?, ?)');
$stmt->bind_param('ssi', $title, $description, $creator_id);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Exam created successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to create exam']);
}

$stmt->close();
$conn->close();
?>
